<?php

namespace App\Controllers;

use App\Models\UsersModel;

class LoginController extends BaseController
{
    public function authenticate()
{
    helper(['form', 'url']);

    $session = session();

    // Log entry
    \Log::debug('Authenticate called - method: ' . $this->request->getMethod());

    // Raw POST and headers
    $post = $this->request->getPost();
    \Log::debug('POST payload: ' . print_r($post, true));
    \Log::debug('Request headers: ' . print_r($this->request->getHeaders(), true));

    // CSRF info
    $csrfEnabled = (bool) config('App')->CSRFProtection ?? false;
    \Log::debug('CSRF enabled: ' . ($csrfEnabled ? 'yes' : 'no'));

    // Is request POST?
    if (! $this->request->is('post')) {
        \Log::warning('Authenticate: not a POST request');
        dd(['error' => 'Expected POST', 'method' => $this->request->getMethod(), 'post' => $post]);
    }

    $email = $post['email'] ?? null;
    $password = $post['password'] ?? null;

    \Log::debug("Login attempt for email: " . ($email ?? '[none]'));

    // Basic validation
    if (empty($email) || empty($password)) {
        \Log::debug('Validation failed: missing email or password');
        dd(['status' => 'validation_failed', 'post' => $post, 'message' => 'Email and password required']);
    }

    // Find user
    $userModel = new \App\Models\UsersModel();
    $user = $userModel->where('email', $email)->first();
    \Log::debug('DB user row: ' . print_r($user, true));

    if (! $user) {
        dd(['status' => 'no_user', 'email' => $email]);
    }

    $hash = $user['password_hash'] ?? ($user['password'] ?? '');
    if (empty($hash)) {
        \Log::warning('Missing password hash for user id: ' . ($user['id'] ?? 'unknown'));
        dd(['status' => 'no_hash', 'user' => $user]);
    }

    $verify = password_verify($password, $hash);
    \Log::debug('password_verify => ' . ($verify ? 'true' : 'false'));

    if (! $verify) {
        dd(['status' => 'bad_password', 'email' => $email]);
    }

    // Set session
    $sessionData = [
        'user_id' => $user['id'],
        'email' => $user['email'],
        'name' => trim(($user['first_name'] ?? '') . ' ' . ($user['last_name'] ?? '')),
        'isLoggedIn' => true,
    ];
    $session->set($sessionData);
    \Log::info('Login success, session set: ' . print_r($sessionData, true));

    // Report back to browser (you'll see this)
    dd([
        'status' => 'ok',
        'redirect' => base_url('landing'),
        'session' => $session->get(),
        'post' => $post,
        'user' => $user,
    ]);
}
}