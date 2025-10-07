<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Users extends BaseController
{
    public function index(): string
    {
        return view('user/landing'); // Landing page
    }

    public function loginPage(): string
    {
        return view('user/loginPage'); // Login page
    }

    public function signupPage(): string
    {
        return view('user/signupPage'); // ✅ New signup page
    }
}
