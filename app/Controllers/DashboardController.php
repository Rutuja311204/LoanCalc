<?php

namespace App\Controllers;

use App\Models\LoanApplicationModel;
use App\Models\NotificationModel;

class DashboardController extends BaseController
{
    public function index()
    {
        $loanApplicationModel = new LoanApplicationModel();
        $notificationModel    = new NotificationModel();
        $userId                = $this->authUserId();

        $applications = $loanApplicationModel->forUser($userId);

        $stats = [
            'total'     => count($applications),
            'approved'  => count(array_filter($applications, static fn ($a) => $a['current_status'] === 'approved')),
            'pending'   => count(array_filter($applications, static fn ($a) => in_array($a['current_status'], ['pending', 'under_review'], true))),
            'rejected'  => count(array_filter($applications, static fn ($a) => $a['current_status'] === 'rejected')),
        ];

        $data = [
            'title'         => 'Dashboard - LoanCalc',
            'applications'  => array_slice($applications, 0, 5),
            'stats'         => $stats,
            'notifications' => $notificationModel->forUser($userId, 5),
        ];

        return view('dashboard/index', $data);
    }

    public function notifications()
    {
        $notificationModel = new NotificationModel();

        $data = [
            'title'         => 'Notifications - LoanCalc',
            'notifications' => $notificationModel->forUser($this->authUserId(), 50),
        ];

        return view('dashboard/notifications', $data);
    }

    public function markNotificationRead(int $id)
    {
        (new NotificationModel())->update($id, ['is_read' => 1]);

        return redirect()->back();
    }
}
