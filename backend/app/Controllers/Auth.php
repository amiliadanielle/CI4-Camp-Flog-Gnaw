<?php

namespace App\Controllers;

use App\Models\UsersModel;
use CodeIgniter\Controller;

class Auth extends Controller
{
    public function loginPage()
    {
        // Show login view
        return view('loginPage');
    }

    public function signupPage()
    {
        // Show signup view
        return view('signupPage');
    }

    public function signup()
    {
        helper(['form', 'url']);

        $rules = [
            'first_name'       => 'required|min_length[2]',
            'last_name'        => 'required|min_length[2]',
            'email'            => 'required|valid_email|is_unique[users.email]',
            'password'         => 'required|min_length[8]',
            'password_confirm' => 'required|matches[password]'
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $userModel = new UsersModel();

        $data = [
            'first_name'      => $this->request->getPost('first_name'),
            'middle_name'     => $this->request->getPost('middle_name') ?: null,
            'last_name'       => $this->request->getPost('last_name'),
            'email'           => $this->request->getPost('email'),
            'password_hash'   => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'type'            => 'client',
            'account_status'  => 1,
            'email_activated' => 0,
            'newsletter'      => 1,
        ];

        $inserted = $userModel->insert($data);

        if (! $inserted) {
            return redirect()->back()
                ->withInput()
                ->with('errors', ['general' => 'Unable to create account. Try again later.']);
        }

        session()->setFlashdata('success', 'Sign up successful! Redirecting to login page...');
        return redirect()->to(base_url('signupPage'));
    }

    public function login()
    {
        helper(['form', 'url']);

        $rules = [
            'email'    => 'required|valid_email',
            'password' => 'required'
        ];

        $post = $this->request->getPost();

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $userModel = new UsersModel();
        // find user by email
        $user = $userModel->where('email', $post['email'])->first();

        if (! $user) {
            // No user found
            return redirect()->back()
                ->withInput()
                ->with('errors', ['email' => 'No account found with that email.']);
        }

        // $user is an array (your UsersModel is returnType 'array')
        $hash = $user['password_hash'] ?? ($user['password'] ?? '');

        if (! password_verify($post['password'], $hash)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', ['password' => 'Incorrect password.']);
        }

        // Authentication success — set session
        $name = trim(($user['first_name'] ?? '') . ' ' . ($user['last_name'] ?? ''));

        $sessionData = [
            'user_id'    => $user['id'] ?? null,
            'email'      => $user['email'] ?? null,
            'first_name' => $user['first_name'] ?? null,
            'last_name'  => $user['last_name'] ?? null,
            'name'       => $name,
            'type'       => strtolower($user['type'] ?? 'client'),
            'isLoggedIn' => true,
        ];

        session()->set($sessionData);

        // Redirect after login:
        // - managers to /admin/dashboard
        // - clients (or others) to /dashboard
        $type = $sessionData['type'];

        if ($type === 'manager' || $type === 'admin') {
            return redirect()->to(base_url('admin/dashboard'));
        }

        // default dashboard route — change if your app uses another path
        return redirect()->to(base_url('dashboard'));
    }

    public function logout()
    {
        // destroy entire session
        session()->destroy();
        // redirect to landing or login page
        return redirect()->to(base_url('landing'));
    }
}
