<?php

namespace App\Controllers;

use App\Models\BankModel;
use App\Models\LoanApplicationModel;
use App\Models\LoanStatusModel;
use App\Models\LoanTypeModel;
use App\Models\NotificationModel;

class LoanController extends BaseController
{
    protected LoanApplicationModel $loanApplicationModel;
    protected LoanTypeModel $loanTypeModel;
    protected BankModel $bankModel;

    public function __construct()
    {
        $this->loanApplicationModel = new LoanApplicationModel();
        $this->loanTypeModel        = new LoanTypeModel();
        $this->bankModel            = new BankModel();
    }

    public function compare()
    {
        $data = [
            'title' => 'Loan Comparison - LoanCalc',
            'banks' => $this->bankModel->getActive(),
        ];

        return view('loan/compare', $data);
    }

    public function apply()
    {
        $data = [
            'title'     => 'Apply for a Loan - LoanCalc',
            'loanTypes' => $this->loanTypeModel->getActive(),
            'banks'     => $this->bankModel->getActive(),
        ];

        return view('loan/apply', $data);
    }

    public function submitApplication()
    {
        $rules = [
            'loan_type_id'    => 'required|integer',
            'bank_id'         => 'required|integer',
            'loan_amount'     => 'required|numeric|greater_than[0]',
            'tenure_months'   => 'required|integer|greater_than[0]',
            'monthly_income'  => 'required|numeric|greater_than[0]',
            'employment_type' => 'required|in_list[salaried,self_employed,business,other]',
            'purpose'         => 'permit_empty|max_length[255]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $bank      = $this->bankModel->find($this->request->getPost('bank_id'));
        $rate      = $bank['interest_rate_min'];
        $principal = (float) $this->request->getPost('loan_amount');
        $tenure    = (int) $this->request->getPost('tenure_months');
        $emiCalc   = calculate_emi($principal, $rate, $tenure);

        $lastId  = $this->loanApplicationModel->orderBy('id', 'DESC')->first();
        $appNo   = generate_application_no($lastId['id'] ?? 0);

        $applicationId = $this->loanApplicationModel->insert([
            'application_no'   => $appNo,
            'user_id'          => $this->authUserId(),
            'loan_type_id'     => $this->request->getPost('loan_type_id'),
            'bank_id'          => $this->request->getPost('bank_id'),
            'loan_amount'      => $principal,
            'tenure_months'    => $tenure,
            'interest_rate'    => $rate,
            'monthly_income'   => $this->request->getPost('monthly_income'),
            'employment_type'  => $this->request->getPost('employment_type'),
            'purpose'          => $this->request->getPost('purpose'),
            'emi_amount'       => $emiCalc['emi'],
            'total_payable'    => $emiCalc['total_payment'],
            'total_interest'   => $emiCalc['total_interest'],
            'current_status'  => 'pending',
        ]);

        (new LoanStatusModel())->insert([
            'loan_application_id' => $applicationId,
            'status'              => 'pending',
            'remarks'             => 'Application submitted by applicant.',
            'created_at'          => date('Y-m-d H:i:s'),
        ]);

        (new NotificationModel())->insert([
            'user_id'    => $this->authUserId(),
            'title'      => 'Loan Application Submitted',
            'message'    => "Your loan application {$appNo} has been received and is pending review.",
            'type'       => 'info',
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        send_acknowledgement_email(
            $this->session->get('email'),
            'Loan Application Received - ' . $appNo,
            "Dear {$this->session->get('fullName')},\n\nWe have received your loan application ({$appNo}) for ₹{$principal}. Our team will review it shortly and update you on the status.\n\nEstimated EMI: ₹{$emiCalc['emi']} for {$tenure} months.",
            'loan_application',
            $applicationId
        );

        return redirect()->to('/loan-status')->with('success', "Your loan application {$appNo} has been submitted successfully!");
    }

    public function status()
    {
        $data = [
            'title'        => 'Loan Status - LoanCalc',
            'applications' => $this->loanApplicationModel
                ->select('loan_applications.*, loan_types.name as loan_type_name, banks.bank_name')
                ->join('loan_types', 'loan_types.id = loan_applications.loan_type_id')
                ->join('banks', 'banks.id = loan_applications.bank_id')
                ->where('loan_applications.user_id', $this->authUserId())
                ->orderBy('loan_applications.created_at', 'DESC')
                ->findAll(),
        ];

        return view('loan/status', $data);
    }

    public function viewApplication(int $id)
    {
        $application = $this->loanApplicationModel->withRelations($id);

        if (! $application || (int) $application['user_id'] !== (int) $this->authUserId()) {
            return redirect()->to('/loan-status')->with('error', 'Application not found.');
        }

        $data = [
            'title'       => 'Application ' . $application['application_no'],
            'application' => $application,
            'history'     => (new LoanStatusModel())->historyFor($id),
        ];

        return view('loan/status', $data + ['applications' => [], 'singleView' => true]);
    }
}
