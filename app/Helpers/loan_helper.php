<?php
/**
 * Loan / EMI calculation helper functions.
 * Load with: helper('loan');
 */

if (! function_exists('calculate_emi')) {
    /**
     * Calculate EMI using the standard reducing-balance formula:
     * EMI = P x r x (1+r)^n / ((1+r)^n - 1)
     *
     * @param float $principal    Loan amount
     * @param float $annualRate   Annual interest rate in percent (e.g. 8.5)
     * @param int   $tenureMonths Tenure in months
     * @return array{emi: float, total_payment: float, total_interest: float}
     */
    function calculate_emi(float $principal, float $annualRate, int $tenureMonths): array
    {
        if ($principal <= 0 || $tenureMonths <= 0) {
            return ['emi' => 0, 'total_payment' => 0, 'total_interest' => 0];
        }

        $monthlyRate = ($annualRate / 12) / 100;

        if ($monthlyRate == 0) {
            $emi = $principal / $tenureMonths;
        } else {
            $factor = pow(1 + $monthlyRate, $tenureMonths);
            $emi    = $principal * $monthlyRate * $factor / ($factor - 1);
        }

        $totalPayment  = $emi * $tenureMonths;
        $totalInterest = $totalPayment - $principal;

        return [
            'emi'            => round($emi, 2),
            'total_payment'  => round($totalPayment, 2),
            'total_interest' => round($totalInterest, 2),
        ];
    }

    /**
     * Generate month-by-month amortization schedule.
     *
     * @return array<int, array{month:int, emi:float, principal:float, interest:float, balance:float}>
     */
    function generate_amortization_schedule(float $principal, float $annualRate, int $tenureMonths): array
    {
        $monthlyRate = ($annualRate / 12) / 100;
        $emiData     = calculate_emi($principal, $annualRate, $tenureMonths);
        $emi         = $emiData['emi'];
        $balance     = $principal;
        $schedule    = [];

        for ($month = 1; $month <= $tenureMonths; $month++) {
            $interestPart  = round($balance * $monthlyRate, 2);
            $principalPart = round($emi - $interestPart, 2);
            $balance       = round($balance - $principalPart, 2);

            if ($month == $tenureMonths || $balance < 0) {
                $balance = 0;
            }

            $schedule[] = [
                'month'     => $month,
                'emi'       => $emi,
                'principal' => $principalPart,
                'interest'  => $interestPart,
                'balance'   => $balance,
            ];
        }

        return $schedule;
    }

    /**
     * Generate a unique loan application number, e.g. LC2026000123
     */
    function generate_application_no(int $lastId): string
    {
        return 'LC' . date('Y') . str_pad((string) ($lastId + 1), 6, '0', STR_PAD_LEFT);
    }
}

if (! function_exists('send_acknowledgement_email')) {
    /**
     * Send an acknowledgement / notification email and log it to email_logs.
     * Uses CodeIgniter's Email service. Failures are caught and logged,
     * they never interrupt the calling request.
     */
    function send_acknowledgement_email(
        string $toEmail,
        string $subject,
        string $message,
        ?string $relatedType = null,
        ?int $relatedId = null
    ): bool {
        $status = 'sent';

        try {
            $emailService = \Config\Services::email();
            $emailService->setTo($toEmail);
            $emailService->setFrom(env('email.fromEmail', 'no-reply@loancalc.test'), 'LoanCalc');
            $emailService->setSubject($subject);
            $emailService->setMessage(
                '<div style="font-family:Arial,sans-serif;max-width:600px;margin:auto">' .
                '<h2 style="color:#0d6efd">LoanCalc</h2>' .
                '<p>' . nl2br(esc($message)) . '</p>' .
                '<hr><p style="font-size:12px;color:#888">This is an automated message from LoanCalc. Please do not reply.</p>' .
                '</div>'
            );

            if (! $emailService->send(false)) {
                $status = 'failed';
            }
        } catch (\Throwable $e) {
            log_message('error', 'Email send failed: ' . $e->getMessage());
            $status = 'failed';
        }

        try {
            $db = \Config\Database::connect();
            $db->table('email_logs')->insert([
                'to_email'     => $toEmail,
                'subject'      => $subject,
                'body'         => $message,
                'status'       => $status,
                'related_type' => $relatedType,
                'related_id'   => $relatedId,
                'created_at'   => date('Y-m-d H:i:s'),
            ]);
        } catch (\Throwable $e) {
            log_message('error', 'Failed to write email_logs: ' . $e->getMessage());
        }

        return $status === 'sent';
    }
}
