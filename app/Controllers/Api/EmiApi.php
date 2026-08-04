<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\BankModel;
use App\Models\EmiRecordModel;

class EmiApi extends BaseController
{
    /**
     * POST /api/calculate-emi
     * Accepts: principal, interest_rate, tenure_months (or tenure_years)
     * Returns: JSON with emi, total_interest, total_payment and schedule
     */
    public function calculate()
    {
        $rules = [
            'principal'      => 'required|numeric|greater_than[0]',
            'interest_rate'  => 'required|numeric|greater_than[0]',
            'tenure_months'  => 'required|integer|greater_than[0]',
        ];

        if (! $this->validate($rules)) {
            return $this->response->setStatusCode(422)->setJSON([
                'success' => false,
                'errors'  => $this->validator->getErrors(),
            ]);
        }

        $principal = (float) $this->request->getPost('principal');
        $rate      = (float) $this->request->getPost('interest_rate');
        $tenure    = (int) $this->request->getPost('tenure_months');

        $result   = calculate_emi($principal, $rate, $tenure);
        $schedule = generate_amortization_schedule($principal, $rate, $tenure);

        // Persist EMI record (optional, anonymous if not logged in)
        try {
            (new EmiRecordModel())->insert([
                'user_id'        => $this->authUserId(),
                'principal'      => $principal,
                'interest_rate'  => $rate,
                'tenure_months'  => $tenure,
                'emi_amount'     => $result['emi'],
                'total_interest' => $result['total_interest'],
                'total_payment'  => $result['total_payment'],
                'schedule_json'  => json_encode($schedule),
                'created_at'     => date('Y-m-d H:i:s'),
            ]);
        } catch (\Throwable $e) {
            log_message('error', 'EMI record save failed: ' . $e->getMessage());
        }

        return $this->response->setJSON([
            'success' => true,
            'data'    => [
                'principal'      => $principal,
                'interest_rate'  => $rate,
                'tenure_months'  => $tenure,
                'emi'            => $result['emi'],
                'total_interest' => $result['total_interest'],
                'total_payment'  => $result['total_payment'],
                'schedule'       => $schedule,
            ],
        ]);
    }

    /**
     * POST /api/compare-loans
     * Compares EMI across all active banks for a given principal/tenure,
     * using each bank's minimum interest rate.
     */
    public function compare()
    {
        $rules = [
            'principal'     => 'required|numeric|greater_than[0]',
            'tenure_months' => 'required|integer|greater_than[0]',
        ];

        if (! $this->validate($rules)) {
            return $this->response->setStatusCode(422)->setJSON([
                'success' => false,
                'errors'  => $this->validator->getErrors(),
            ]);
        }

        $principal = (float) $this->request->getPost('principal');
        $tenure    = (int) $this->request->getPost('tenure_months');

        $banks   = (new BankModel())->getActive();
        $results = [];

        foreach ($banks as $bank) {
            $rate = (float) $bank['interest_rate_min'];
            $calc = calculate_emi($principal, $rate, $tenure);

            $results[] = [
                'bank_id'        => $bank['id'],
                'bank_name'      => $bank['bank_name'],
                'bank_code'      => $bank['bank_code'],
                'interest_rate'  => $rate,
                'processing_fee' => round($principal * ($bank['processing_fee_percent'] / 100), 2),
                'emi'            => $calc['emi'],
                'total_interest' => $calc['total_interest'],
                'total_payment'  => $calc['total_payment'],
            ];
        }

        usort($results, static fn ($a, $b) => $a['emi'] <=> $b['emi']);

        return $this->response->setJSON([
            'success' => true,
            'data'    => $results,
        ]);
    }
}
