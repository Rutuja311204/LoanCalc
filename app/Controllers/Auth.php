<?php

namespace App\Controllers;

use App\Models\NotificationModel;
use App\Models\UserModel;

class Auth extends BaseController
{
    protected UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    // ------------------------------------------------------------
    // LOGIN
    // ------------------------------------------------------------
    public function login()
    {
        if ($this->session->get('isLoggedIn')) {
            return redirect()->to($this->isAdmin() ? '/admin/dashboard' : '/dashboard');
        }

        return view('auth/login', ['title' => 'Login - LoanCalc']);
    }

    public function attemptLogin()
    {
        $rules = [
            'email'    => 'required|valid_email',
            'password' => 'required|min_length[6]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $this->userModel->findByEmail($email);

        if (! $user || ! password_verify($password, $user['password'])) {
            return redirect()->back()->withInput()->with('error', 'Invalid email or password.');
        }

        if ($user['status'] !== 'active') {
            return redirect()->back()->withInput()->with('error', 'Your account has been deactivated. Please contact support.');
        }

        $this->session->set([
            'userId'      => $user['id'],
            'fullName'    => $user['full_name'],
            'email'       => $user['email'],
            'role'        => $user['role'],
            'isLoggedIn'  => true,
        ]);

        return redirect()->to($user['role'] === 'admin' ? '/admin/dashboard' : '/dashboard')
            ->with('success', 'Welcome back, ' . $user['full_name'] . '!');
    }

    // ------------------------------------------------------------
    // REGISTER
    // ------------------------------------------------------------
    public function register()
    {
        if ($this->session->get('isLoggedIn')) {
            return redirect()->to('/dashboard');
        }

        return view('auth/register', ['title' => 'Register - LoanCalc']);
    }

    public function attemptRegister()
    {
        $rules = [
            'full_name'        => 'required|min_length[3]|max_length[150]',
            'email'            => 'required|valid_email|is_unique[users.email]',
            'phone'            => 'required|min_length[10]|max_length[15]',
            'password'         => 'required|min_length[6]',
            'confirm_password' => 'required|matches[password]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userId = $this->userModel->insert([
            'full_name' => $this->request->getPost('full_name'),
            'email'     => $this->request->getPost('email'),
            'phone'     => $this->request->getPost('phone'),
            'password'  => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
            'role'      => 'user',
            'status'    => 'active',
        ]);

        // Welcome notification + email acknowledgement
        (new NotificationModel())->insert([
            'user_id'    => $userId,
            'title'      => 'Welcome to LoanCalc!',
            'message'    => 'Your account has been created successfully. Explore our EMI calculator and apply for a loan today.',
            'type'       => 'success',
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        send_acknowledgement_email(
            $this->request->getPost('email'),
            'Welcome to LoanCalc',
            'Thank you for registering with LoanCalc. Your account is now active.',
            'registration',
            $userId
        );

        return redirect()->to('/login')->with('success', 'Registration successful! Please login to continue.');
    }

    // ------------------------------------------------------------
    // LOGOUT
    // ------------------------------------------------------------
    public function logout()
    {
        $this->session->destroy();

        return redirect()->to('/login')->with('success', 'You have been logged out successfully.');
    }

    // ------------------------------------------------------------
    // FORGOT PASSWORD
    // ------------------------------------------------------------
    public function forgotPassword()
    {
        return view('auth/forgot_password', ['title' => 'Forgot Password - LoanCalc']);
    }

    public function attemptForgotPassword()
    {
        $rules = ['email' => 'required|valid_email'];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $email = $this->request->getPost('email');
        $user  = $this->userModel->findByEmail($email);

        if (! $user) {
            // Do not reveal whether the email exists.
            return redirect()->back()->with('success', 'If that email exists in our system, a reset link has been sent.');
        }

        $token   = bin2hex(random_bytes(32));
        $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));

        $this->userModel->update($user['id'], [
            'reset_token'   => $token,
            'reset_expires' => $expires,
        ]);

        $resetLink = base_url('reset-password/' . $token);

        send_acknowledgement_email(
            $email,
            'Reset your LoanCalc password',
            'Click the following link to reset your password (valid for 1 hour): ' . $resetLink,
            'password_reset',
            $user['id']
        );

        return redirect()->back()->with('success', 'If that email exists in our system, a reset link has been sent.');
    }

    public function resetPassword(string $token)
    {
        $user = $this->userModel->where('reset_token', $token)
            ->where('reset_expires >=', date('Y-m-d H:i:s'))
            ->first();

        if (! $user) {
            return redirect()->to('/forgot-password')->with('error', 'This password reset link is invalid or has expired.');
        }

        return view('auth/reset_password', ['title' => 'Reset Password - LoanCalc', 'token' => $token]);
    }

    public function attemptResetPassword()
    {
        $rules = [
            'token'            => 'required',
            'password'         => 'required|min_length[6]',
            'confirm_password' => 'required|matches[password]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $token = $this->request->getPost('token');

        $user = $this->userModel->where('reset_token', $token)
            ->where('reset_expires >=', date('Y-m-d H:i:s'))
            ->first();

        if (! $user) {
            return redirect()->to('/forgot-password')->with('error', 'This password reset link is invalid or has expired.');
        }

        $this->userModel->update($user['id'], [
            'password'      => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
            'reset_token'   => null,
            'reset_expires' => null,
        ]);

        return redirect()->to('/login')->with('success', 'Your password has been reset. Please login with your new password.');
    }
}
