<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ContactMessageModel;
use App\Models\LoanApplicationModel;

class Reports extends BaseController
{
    public function index()
    {
        $loanApplicationModel = new LoanApplicationModel();
        $applications          = $loanApplicationModel->allWithRelations();

        // Monthly application volume (last 6 months)
        $monthly = [];
        foreach ($applications as $app) {
            $month = date('M Y', strtotime($app['created_at']));
            $monthly[$month] = ($monthly[$month] ?? 0) + 1;
        }

        // Loan type distribution
        $byType = [];
        foreach ($applications as $app) {
            $byType[$app['loan_type_name']] = ($byType[$app['loan_type_name']] ?? 0) + 1;
        }

        // Status distribution
        $byStatus = [];
        foreach ($applications as $app) {
            $byStatus[$app['current_status']] = ($byStatus[$app['current_status']] ?? 0) + 1;
        }

        $data = [
            'title'        => 'Reports & Analytics - LoanCalc Admin',
            'monthly'      => $monthly,
            'byType'       => $byType,
            'byStatus'     => $byStatus,
            'applications' => $applications,
        ];

        return view('admin/reports', $data);
    }

    public function export()
    {
        $applications = (new LoanApplicationModel())->allWithRelations();

        $filename = 'loan_applications_report_' . date('Ymd_His') . '.csv';

        $this->response->setHeader('Content-Type', 'text/csv');
        $this->response->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"');

        $output = fopen('php://temp', 'w+');
        fputcsv($output, ['Application No', 'Applicant', 'Email', 'Loan Type', 'Bank', 'Amount', 'Tenure (months)', 'Interest Rate', 'EMI', 'Status', 'Applied On']);

        foreach ($applications as $app) {
            fputcsv($output, [
                $app['application_no'],
                $app['full_name'],
                $app['email'],
                $app['loan_type_name'],
                $app['bank_name'],
                $app['loan_amount'],
                $app['tenure_months'],
                $app['interest_rate'],
                $app['emi_amount'],
                $app['current_status'],
                $app['created_at'],
            ]);
        }

        rewind($output);
        $csv = stream_get_contents($output);
        fclose($output);

        return $this->response->setBody($csv);
    }

    public function messages()
    {
        $data = [
            'title'    => 'Contact Messages - LoanCalc Admin',
            'messages' => (new ContactMessageModel())->orderBy('created_at', 'DESC')->findAll(),
        ];

        return view('admin/messages', $data);
    }

    public function markMessageRead(int $id)
    {
        (new ContactMessageModel())->update($id, ['is_read' => 1]);

        return redirect()->back()->with('success', 'Message marked as read.');
    }
}
