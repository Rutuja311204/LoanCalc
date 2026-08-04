<?php

namespace App\Controllers;

use App\Models\UserModel;

class ProfileController extends BaseController
{
    protected UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $data = [
            'title' => 'My Profile - LoanCalc',
            'user'  => $this->userModel->find($this->authUserId()),
        ];

        return view('profile/index', $data);
    }

    public function update()
    {
        $rules = [
            'full_name' => 'required|min_length[3]|max_length[150]',
            'phone'     => 'required|min_length[10]|max_length[15]',
            'address'   => 'permit_empty|max_length[255]',
            'dob'       => 'permit_empty|valid_date',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->userModel->update($this->authUserId(), [
            'full_name' => $this->request->getPost('full_name'),
            'phone'     => $this->request->getPost('phone'),
            'address'   => $this->request->getPost('address'),
            'dob'       => $this->request->getPost('dob') ?: null,
        ]);

        $this->session->set('fullName', $this->request->getPost('full_name'));

        return redirect()->to('/profile')->with('success', 'Profile updated successfully.');
    }

    public function changePassword()
    {
        $rules = [
            'current_password'     => 'required',
            'new_password'         => 'required|min_length[6]',
            'confirm_new_password' => 'required|matches[new_password]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        $user = $this->userModel->find($this->authUserId());

        if (! password_verify($this->request->getPost('current_password'), $user['password'])) {
            return redirect()->back()->with('error', 'Current password is incorrect.');
        }

        $this->userModel->update($this->authUserId(), [
            'password' => password_hash($this->request->getPost('new_password'), PASSWORD_BCRYPT),
        ]);

        return redirect()->to('/profile')->with('success', 'Password changed successfully.');
    }
}
