<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class UserLanding extends Controller
{
    public function index()
    {
        $session = session();

        // 🔒 Redirect to login if user not logged in
        if (!$session->get('isLoggedIn')) {
            return redirect()->to(base_url('loginPage'));
        }

        // Load user-specific header and page
        echo view('UserLanding');   // your new page
        echo view('components/footer');
    }
}
