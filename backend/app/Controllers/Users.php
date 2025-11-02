<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UsersModel;

class Users extends BaseController
{
    // 🟠 Landing Page (public)
    public function index(): string
    {
        return view('user/landing');
    }

    // 🟠 Show Login Page
    public function loginPage(): string
    {
        return view('user/loginPage');
    }

    // 🟠 Show Signup Page
    public function signupPage(): string
    {
        return view('user/signupPage');
    }

    // 🟢 Handle Signup Form Submission
    public function signup()
    {
        $userModel = new UsersModel();

        // Get POST data
        $firstName  = $this->request->getPost('first_name');
        $middleName = $this->request->getPost('middle_name');
        $lastName   = $this->request->getPost('last_name');
        $email      = $this->request->getPost('email');
        $password   = $this->request->getPost('password');
        $gender     = $this->request->getPost('gender') ?? null;

        // Validate input with custom error message
        $validation = \Config\Services::validation();
        $validation->setRules([
            'first_name' => [
                'label' => 'Name',
                'rules' => 'required|alpha|max_length[100]',
                'errors' => [
                    'alpha' => 'Name field may only contain alphabetical characters.'
                ]
            ],
            'last_name' => [
                'label' => 'Last Name',
                'rules' => 'required|alpha|max_length[100]',
                'errors' => [
                    'alpha' => 'Last Name field may only contain alphabetical characters.'
                ]
            ],
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Hash password
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        // Prepare data
        $data = [
            'first_name'     => $firstName,
            'middle_name'    => $middleName,
            'last_name'      => $lastName,
            'email'          => $email,
            'password_hash'  => $passwordHash,
            'type'           => 'user',
            'account_status' => 1,    // integer
            'email_activated'=> 0,
            'newsletter'     => 0,
            'gender'         => $gender,
            'profile_image'  => null
        ];

        // Insert into database
        $userModel->insert($data);

        return redirect()->to(base_url('loginPage'))->with('message', 'Account created successfully! Please log in.');
    }

    // 🟢 Handle Login Form Submission
    public function login()
    {
        $userModel = new UsersModel();

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $userModel->findByEmail($email);

        if (!$user) {
            return redirect()->back()->with('error', 'Account does not exist.');
        }

        if (!password_verify($password, $user['password_hash'])) {
            return redirect()->back()->with('error', 'Password is incorrect.');
        }

        // Set session
        session()->set([
            'isLoggedIn' => true,
            'email'      => $user['email'],
            'name'       => $user['first_name'] . ' ' . $user['last_name'],
            'role'       => $user['type'],
            'user_id'    => $user['id']
        ]);

        // Redirect based on role
        return $user['type'] === 'admin' 
            ? redirect()->to(base_url('dashboard')) 
            : redirect()->to(base_url('users'));
    }

    // 🟢 Landing Page (after login)
    public function landing()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('loginPage'));
        }

        return view('user/landing');
    }

    // 🟢 Dashboard (admin only)
    public function dashboard()
    {
        $session = session();
        if (!$session->get('isLoggedIn') || $session->get('role') !== 'admin') {
            return redirect()->to(base_url('loginPage'));
        }

        return view('user/dashboard');
    }

    // 🟣 Logout
    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('loginPage'));
    }
}
