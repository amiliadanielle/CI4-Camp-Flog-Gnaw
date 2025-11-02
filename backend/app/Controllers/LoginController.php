<?php

namespace App\Controllers;

use App\Models\UsersModel;

class LoginController extends BaseController
{
    // Show login page
    public function index()
    {
        return view('user/loginPage');
    }

    // Authenticate login form submission
    public function authenticate()
    {
        helper(['form', 'url']);
        $session = session();

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // Basic validation
        if (empty($email) || empty($password)) {
            $session->setFlashdata('errors', ['general' => 'Email and password are required.']);
            return redirect()->back()->withInput();
        }

        $userModel = new UsersModel();
        $user = $userModel->where('email', $email)->first();

        if (!$user) {
            $session->setFlashdata('errors', ['general' => 'No account found with that email.']);
            return redirect()->back()->withInput();
        }

        $hash = $user['password_hash'] ?? ($user['password'] ?? '');

        if (!password_verify($password, $hash)) {
            $session->setFlashdata('errors', ['general' => 'Incorrect password.']);
            return redirect()->back()->withInput();
        }

        // Set session
        $sessionData = [
            'user_id'    => $user['id'],
            'email'      => $user['email'],
            'name'       => trim(($user['first_name'] ?? '') . ' ' . ($user['last_name'] ?? '')),
            'isLoggedIn' => true,
            'role'       => $user['role'] ?? 'user' // default to user
        ];
        $session->set($sessionData);

        // Redirect based on role
        if ($session->get('role') === 'admin') {
            return redirect()->to(base_url('user/dashboard')); // admin dashboard
        } else {
            return redirect()->to(base_url('user')); // regular user landing page
        }
    }

    // Logout
    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('login'));
    }
}
