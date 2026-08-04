<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\LoanApplicationModel;
use App\Models\UserModel;

class Users extends BaseController
{
    protected UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Manage Users - LoanCalc Admin',
            'users' => $this->userModel->where('role', 'user')->orderBy('created_at', 'DESC')->findAll(),
        ];

        return view('admin/users', $data);
    }

    public function view(int $id)
    {
        $user = $this->userModel->find($id);

        if (! $user) {
            return redirect()->to('/admin/users')->with('error', 'User not found.');
        }

        $data = [
            'title'        => 'User Details - LoanCalc Admin',
            'user'         => $user,
            'applications' => (new LoanApplicationModel())->forUser($id),
        ];

        return view('admin/user_view', $data);
    }

    public function toggleStatus(int $id)
    {
        $user = $this->userModel->find($id);

        if (! $user) {
            return redirect()->back()->with('error', 'User not found.');
        }

        $newStatus = $user['status'] === 'active' ? 'inactive' : 'active';
        $this->userModel->update($id, ['status' => $newStatus]);

        return redirect()->back()->with('success', "User has been marked as {$newStatus}.");
    }

    public function delete(int $id)
    {
        $this->userModel->delete($id);

        return redirect()->to('/admin/users')->with('success', 'User deleted successfully.');
    }
}
