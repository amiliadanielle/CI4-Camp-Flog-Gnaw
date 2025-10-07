<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Users extends BaseController
{
    public function index(): string
    {
        return view('user/landing'); // loads app/Views/users/index.php
    }

    public function loginPage(): string
    {
        return view('user/loginPage'); // loads app/Views/users/login.php
    }
}
