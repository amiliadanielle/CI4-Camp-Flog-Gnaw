<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Users extends BaseController
{
    // 🟠 Landing Page
    public function index(): string
    {
        return view('user/landing'); // Loads app/Views/user/landing.php
    }

    // 🟠 Show Login Page
    public function loginPage(): string
    {
        return view('user/loginPage'); // Loads app/Views/user/loginPage.php
    }

    // 🟠 Show Signup Page
    public function signupPage(): string
    {
        return view('user/signupPage'); // Loads app/Views/user/signupPage.php
    }

    // 🟢 Handle Login Form Submission
    public function login()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // ✅ Dummy credentials (for testing, no database yet)
        $validEmail = 'user@example.com';
        $validPass  = 'pass123';

        if ($email === $validEmail && $password === $validPass) {
            // ✅ Store session data
            session()->set([
                'isLoggedIn' => true,
                'email' => $email
            ]);

            // ✅ Redirect to dashboard
            return redirect()->to(base_url('dashboard'));
        }

        // ❌ Invalid credentials — reload loginPage with error message
        return redirect()->back()->with('error', 'Invalid email or password.');
    }

    // 🟢 Dashboard Page (only accessible if logged in)
    public function dashboard()
    {
        if (!session()->get('isLoggedIn')) {
            // Not logged in → redirect to login page
            return redirect()->to(base_url('loginPage'));
        }

        // ✅ Logged in → show dashboard view
        return view('user/dashboard');
    }

    // 🟣 Logout
    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('loginPage'));
    }
}
