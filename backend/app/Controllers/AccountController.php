<?php

namespace App\Controllers;

use App\Models\UsersModel;
use CodeIgniter\Controller;

class AccountController extends Controller
{
    protected $helpers = ['form', 'url', 'filesystem'];

    /**
     * Show account page.
     */
    public function index()
    {
        $session = session();

        // Ensure logged in
        if (! $session->get('isLoggedIn')) {
            return redirect()->to(site_url('loginPage'));
        }

        $userId = $session->get('user_id') ?? ($session->get('loggedUser')['id'] ?? null);

        if (! $userId) {
            return redirect()->to(site_url('loginPage'));
        }

        $userModel = new UsersModel();
        $user = $userModel->find($userId);

        if (! $user) {
            $session->destroy();
            return redirect()->to(site_url('loginPage'));
        }

        // ✅ FIX: View lives in app/Views/user/account.php
        return view('user/account', ['user' => $user]);
    }

    /**
     * Save account updates.
     */
    public function save()
    {
        $session = session();

        if (! $session->get('isLoggedIn')) {
            if ($this->request->isAJAX()) {
                return $this->response->setStatusCode(401)->setJSON(['error' => 'Not authenticated']);
            }
            return redirect()->to(site_url('loginPage'));
        }

        $userId = $session->get('user_id') ?? ($session->get('loggedUser')['id'] ?? null);
        if (! $userId) {
            if ($this->request->isAJAX()) {
                return $this->response->setStatusCode(400)->setJSON(['error' => 'User not found in session']);
            }
            return redirect()->back()->with('error', 'User not found in session');
        }

        $userModel = new UsersModel();
        $user = $userModel->find($userId);
        if (! $user) {
            if ($this->request->isAJAX()) {
                return $this->response->setStatusCode(404)->setJSON(['error' => 'User not found']);
            }
            return redirect()->back()->with('error', 'User not found');
        }

        // Validation
        $rules = [
            'first_name' => 'required|max_length[100]',
            'last_name'  => 'required|max_length[100]',
            'email'      => 'required|valid_email'
        ];

        $validation = \Config\Services::validation();
        $validation->setRules($rules);

        if (! $validation->withRequest($this->request)->run()) {
            $errors = $validation->getErrors();
            if ($this->request->isAJAX()) {
                return $this->response->setStatusCode(422)->setJSON(['errors' => $errors]);
            }
            return redirect()->back()->withInput()->with('errors', $errors);
        }

        // Email uniqueness check
        $newEmail = trim($this->request->getPost('email'));
        if ($newEmail !== ($user['email'] ?? '')) {
            $exists = $userModel->where('email', $newEmail)->first();
            if ($exists && (int)$exists['id'] !== (int)$userId) {
                $err = ['email' => 'That email is already in use.'];
                if ($this->request->isAJAX()) {
                    return $this->response->setStatusCode(409)->setJSON(['errors' => $err]);
                }
                return redirect()->back()->withInput()->with('errors', $err);
            }
        }

        // Data for update
        $update = [
            'first_name'  => $this->request->getPost('first_name'),
            'middle_name' => $this->request->getPost('middle_name') ?: null,
            'last_name'   => $this->request->getPost('last_name'),
            'email'       => $newEmail,
        ];

        // Password handling
        $newPassword = $this->request->getPost('new_password');
        $newPasswordConfirm = $this->request->getPost('new_password_confirm');
        $currentPassword = $this->request->getPost('current_password');

        if (! empty($newPassword)) {
            if ($newPassword !== $newPasswordConfirm) {
                $err = ['new_password' => 'New passwords do not match'];
                if ($this->request->isAJAX()) {
                    return $this->response->setStatusCode(422)->setJSON(['errors' => $err]);
                }
                return redirect()->back()->withInput()->with('errors', $err);
            }

            $storedHash = $user['password_hash'] ?? '';
            if (empty($currentPassword) || ! password_verify($currentPassword, $storedHash)) {
                $err = ['current_password' => 'Current password is incorrect'];
                if ($this->request->isAJAX()) {
                    return $this->response->setStatusCode(401)->setJSON(['errors' => $err]);
                }
                return redirect()->back()->withInput()->with('errors', $err);
            }

            $update['password_hash'] = password_hash($newPassword, PASSWORD_DEFAULT);
        }

        // Image upload
        $file = $this->request->getFile('profile_image');
        if ($file && $file->isValid() && ! $file->hasMoved()) {
            if ($file->getSize() > 2 * 1024 * 1024) {
                $err = ['profile_image' => 'File must be under 2MB'];
                if ($this->request->isAJAX()) return $this->response->setStatusCode(422)->setJSON(['errors' => $err]);
                return redirect()->back()->withInput()->with('errors', $err);
            }

            $allowed = ['image/jpeg', 'image/png', 'image/webp'];
            if (! in_array($file->getMimeType(), $allowed)) {
                $err = ['profile_image' => 'Only JPG, PNG, or WEBP allowed'];
                if ($this->request->isAJAX()) return $this->response->setStatusCode(422)->setJSON(['errors' => $err]);
                return redirect()->back()->withInput()->with('errors', $err);
            }

            $destDir = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . 'profiles' . DIRECTORY_SEPARATOR;
            if (! is_dir($destDir)) {
                mkdir($destDir, 0755, true);
            }

            $newName = $file->getRandomName();
            try {
                $file->move($destDir, $newName);
            } catch (\Exception $e) {
                if ($this->request->isAJAX()) {
                    return $this->response->setStatusCode(500)->setJSON(['error' => 'Failed to save uploaded image']);
                }
                return redirect()->back()->with('error', 'Failed to save uploaded image');
            }

            if (! empty($user['profile_image'])) {
                $old = $destDir . $user['profile_image'];
                if (is_file($old)) {
                    @unlink($old);
                }
            }

            $update['profile_image'] = $newName;
        }

        // Update DB
        try {
            $userModel->update($userId, $update);
        } catch (\Throwable $e) {
            if ($this->request->isAJAX()) {
                return $this->response->setStatusCode(500)->setJSON(['error' => 'Failed to update account']);
            }
            return redirect()->back()->with('error', 'Failed to update account')->withInput();
        }

        // Refresh session
        $freshUser = $userModel->find($userId);
        if ($freshUser) {
            $session->set([
                'user_id'    => $freshUser['id'],
                'email'      => $freshUser['email'],
                'first_name' => $freshUser['first_name'],
                'last_name'  => $freshUser['last_name'],
                'name'       => trim(($freshUser['first_name'] ?? '') . ' ' . ($freshUser['last_name'] ?? '')),
            ]);
            $session->set('loggedUser', $freshUser);
        }

        // Success response
        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['ok' => true, 'message' => 'Account updated', 'user' => $freshUser]);
        }

        session()->setFlashdata('success', 'Account updated');
        return redirect()->to(site_url('account'));
    }
}
