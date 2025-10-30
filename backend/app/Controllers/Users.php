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

        // ✅ Hardcoded user accounts
        $users = [
            'amiliadanielle06@gmail.com' => [
                'password' => 'amilia123',
                'role' => 'user'
            ],
            'admin@gmail.com' => [
                'password' => 'admin123',
                'role' => 'admin'
            ],
        ];

        // 🧩 Check if email exists and password matches
        if (isset($users[$email]) && $password === $users[$email]['password']) {
            $role = $users[$email]['role'];

            // ✅ Set session data
            session()->set([
                'isLoggedIn' => true,
                'email'      => $email,
                'role'       => $role
            ]);

            // 🧭 Redirect based on role
            if ($role === 'admin') {
                return redirect()->to(base_url('dashboard')); // Admin dashboard
            } else {
                return redirect()->to(base_url('landing')); // Regular user landing
            }
        }

        // ❌ Invalid credentials
        return redirect()->back()->with('error', 'Invalid email or password.');
    }

    // 🟢 Dashboard Page (admin only)
    public function dashboard()
    {
        $session = session();

        // Check login
        if (! $session->get('isLoggedIn')) {
            return redirect()->to(base_url('loginPage'));
        }

        // Check role
        if ($session->get('role') !== 'admin') {
            return redirect()->to(base_url('landing'));
        }

        // ✅ Load admin dashboard
        return view('dashboard'); // Loads app/Views/user/dashboard.php
    }

    // 🟢 Landing Page (user)
    public function landing()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('loginPage'));
        }

        return view('user/landing'); // Regular user landing
    }

    // 🟣 Logout
    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('loginPage'));
    }

    // 🧡 Example: Moodboard
    public function moodboard()
    {
        return view('user/moodboard');
    }
}
