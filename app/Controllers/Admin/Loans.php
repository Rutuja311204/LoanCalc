<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BankModel;
use App\Models\LoanApplicationModel;
use App\Models\LoanStatusModel;
use App\Models\LoanTypeModel;
use App\Models\NotificationModel;

class Loans extends BaseController
{
    protected LoanApplicationModel $loanApplicationModel;

    public function __construct()
    {
        $this->loanApplicationModel = new LoanApplicationModel();
    }

    public function index()
    {
        $data = [
            'title'        => 'Manage Loan Applications - LoanCalc Admin',
            'applications' => $this->loanApplicationModel->allWithRelations(),
        ];

        return view('admin/loans', $data);
    }

    public function view(int $id)
    {
        $application = $this->loanApplicationModel->withRelations($id);

        if (! $application) {
            return redirect()->to('/admin/loans')->with('error', 'Application not found.');
        }

        $data = [
            'title'       => 'Application ' . $application['application_no'] . ' - LoanCalc Admin',
            'application' => $application,
            'history'     => (new LoanStatusModel())->historyFor($id),
        ];

        return view('admin/loan_view', $data);
    }

    public function updateStatus(int $id)
    {
        $rules = [
            'status'  => 'required|in_list[pending,under_review,approved,rejected,disbursed]',
            'remarks' => 'permit_empty|max_length[255]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        $application = $this->loanApplicationModel->withRelations($id);

        if (! $application) {
            return redirect()->to('/admin/loans')->with('error', 'Application not found.');
        }

        $status  = $this->request->getPost('status');
        $remarks = $this->request->getPost('remarks') ?: 'Status updated by admin.';

        $this->loanApplicationModel->update($id, ['current_status' => $status]);

        (new LoanStatusModel())->insert([
            'loan_application_id' => $id,
            'status'              => $status,
            'remarks'             => $remarks,
            'updated_by'          => $this->authUserId(),
            'created_at'          => date('Y-m-d H:i:s'),
        ]);

        (new NotificationModel())->insert([
            'user_id'    => $application['user_id'],
            'title'      => 'Loan Application Status Updated',
            'message'    => "Your application {$application['application_no']} status has been updated to: " . ucfirst(str_replace('_', ' ', $status)),
            'type'       => $status === 'approved' ? 'success' : ($status === 'rejected' ? 'danger' : 'info'),
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        send_acknowledgement_email(
            $application['email'],
            'Loan Application Update - ' . $application['application_no'],
            "Dear {$application['full_name']},\n\nYour loan application {$application['application_no']} status has been updated to: " . ucfirst(str_replace('_', ' ', $status)) . ".\n\nRemarks: {$remarks}",
            'loan_status_update',
            $id
        );

        return redirect()->to('/admin/loans/view/' . $id)->with('success', 'Loan status updated successfully.');
    }

    public function loanTypes()
    {
        $data = [
            'title'     => 'Loan Types - LoanCalc Admin',
            'loanTypes' => (new LoanTypeModel())->findAll(),
        ];

        return view('admin/loan_types', $data);
    }

    public function banks()
    {
        $data = [
            'title' => 'Banks - LoanCalc Admin',
            'banks' => (new BankModel())->findAll(),
        ];

        return view('admin/banks', $data);
    }
}
