<?php namespace App\Controllers;

use App\Models\UsersModel;
use CodeIgniter\Controller;

class Account extends Controller
{
    protected $users;
    protected $session;

    public function __construct()
    {
        $this->users = new UsersModel();
        $this->session = session();
        helper(['form', 'url']);
    }

    /**
     * POST /account/save
     * expects authenticated user (user_id in session)
     */
    public function save()
    {
        // ensure AJAX or normal POST
        if ($this->request->getMethod() !== 'post') {
            return $this->response->setStatusCode(405)->setBody('Method not allowed');
        }

        $userId = $this->session->get('user_id');
        if (!$userId) {
            // unauthorized
            return $this->response->setStatusCode(401)->setJSON(['message' => 'Not signed in']);
        }

        // validation rules
        $rules = [
            'first_name' => 'required|min_length[2]',
            'last_name'  => 'required|min_length[2]',
            'email'      => 'required|valid_email'
        ];

        // if changing password, require current + match + min length
        $newPassword = $this->request->getPost('new_password');
        if ($newPassword && $newPassword !== '') {
            $rules['current_password'] = 'required';
            $rules['new_password'] = 'required|min_length[6]';
            $rules['new_password_confirm'] = 'required|matches[new_password]';
        }

        if (!$this->validate($rules)) {
            $errors = $this->validator->getErrors();
            return $this->response->setStatusCode(422)->setJSON(['message' => 'Validation failed', 'errors' => $errors]);
        }

        // fetch user from DB
        $user = $this->users->find($userId);
        if (!$user) {
            return $this->response->setStatusCode(404)->setJSON(['message' => 'User not found']);
        }

        // if user wants to change password: verify current password
        if ($newPassword && $newPassword !== '') {
            $current = $this->request->getPost('current_password');
            if (!password_verify($current, $user['password'])) {
                return $this->response->setStatusCode(403)->setJSON(['message' => 'Current password incorrect']);
            }
        }

        // handle file upload if provided
        $profileFile = $this->request->getFile('profile_image');
        $newFilename = null;
        if ($profileFile && $profileFile->isValid() && !$profileFile->hasMoved()) {
            // basic server-side checks
            if ($profileFile->getSize() > 2 * 1024 * 1024) {
                return $this->response->setStatusCode(413)->setJSON(['message' => 'Uploaded file too large']);
            }
            if (! in_array($profileFile->getMimeType(), ['image/jpeg','image/png','image/webp','image/jpg'])) {
                // allow common image mimes
                // note: you can adjust as needed
            }

            // create uploads folder if doesn't exist (public/uploads/profiles)
            $targetPath = FCPATH . 'uploads' . DIRECTORY_SEPARATOR . 'profiles' . DIRECTORY_SEPARATOR;
            if (!is_dir($targetPath)) mkdir($targetPath, 0755, true);

            $newFilename = $profileFile->getRandomName();
            try {
                $profileFile->move($targetPath, $newFilename);
            } catch (\Exception $e) {
                return $this->response->setStatusCode(500)->setJSON(['message' => 'Failed to save uploaded image']);
            }

            // optionally delete old file
            if (!empty($user['profile_image']) && file_exists($targetPath . $user['profile_image'])) {
                @unlink($targetPath . $user['profile_image']);
            }
        }

        // prepare payload for update
        $updateData = [
            'first_name' => $this->request->getPost('first_name'),
            'middle_name'=> $this->request->getPost('middle_name'),
            'last_name'  => $this->request->getPost('last_name'),
            'email'      => $this->request->getPost('email'),
            'gender'     => $this->request->getPost('gender') ?? ''
        ];

        if ($newFilename) {
            $updateData['profile_image'] = $newFilename;
        }

        if ($newPassword && $newPassword !== '') {
            $updateData['password'] = password_hash($newPassword, PASSWORD_DEFAULT);
        }

        // perform update
        try {
            $this->users->update($userId, $updateData);
            // optional: refresh session profile name/email if you store them
            $this->session->set('user_first_name', $updateData['first_name']);
            // return updated user for UI
            $userUpdated = $this->users->find($userId);
            return $this->response->setJSON(['message' => 'Saved', 'user' => $userUpdated]);
        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON(['message' => 'Failed to update account', 'error' => $e->getMessage()]);
        }
    }
}
