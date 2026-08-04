<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ContactMessageModel;
use App\Models\LoanApplicationModel;
use App\Models\UserModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $loanApplicationModel = new LoanApplicationModel();
        $userModel             = new UserModel();
        $contactModel          = new ContactMessageModel();

        $applications = $loanApplicationModel->allWithRelations();

        $stats = [
            'total_users'        => $userModel->where('role', 'user')->countAllResults(),
            'total_applications' => count($applications),
            'pending'            => count(array_filter($applications, static fn ($a) => $a['current_status'] === 'pending')),
            'under_review'       => count(array_filter($applications, static fn ($a) => $a['current_status'] === 'under_review')),
            'approved'           => count(array_filter($applications, static fn ($a) => $a['current_status'] === 'approved')),
            'rejected'           => count(array_filter($applications, static fn ($a) => $a['current_status'] === 'rejected')),
            'disbursed'          => count(array_filter($applications, static fn ($a) => $a['current_status'] === 'disbursed')),
            'total_loan_amount'  => array_sum(array_column($applications, 'loan_amount')),
            'unread_messages'    => $contactModel->where('is_read', 0)->countAllResults(),
        ];

        $data = [
            'title'        => 'Admin Dashboard - LoanCalc',
            'stats'        => $stats,
            'applications' => array_slice($applications, 0, 8),
        ];

        return view('admin/dashboard', $data);
    }
}
