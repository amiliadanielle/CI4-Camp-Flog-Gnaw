<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;

    // only fields used by account page
    protected $allowedFields    = [
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'gender',
        'profile_image',
        'password_hash'
    ];

    // timestamps
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Basic validation for account updates (used optionally in controller)
    protected $validationRules = [
        'first_name' => 'required|max_length[100]',
        'last_name'  => 'required|max_length[100]',
        'email'      => 'required|valid_email',
    ];

    // hash password before insert/update if provided
    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    /**
     * Find user by email.
     */
    public function findByEmail(string $email)
    {
        return $this->where('email', $email)->first();
    }

    /**
     * Get user by id (helper).
     */
    public function getUser(int $id)
    {
        return $this->find($id);
    }

    /**
     * Check whether an email is unique excluding a given user id.
     * Useful when updating: allow the user to keep their own email.
     */
    public function isEmailUniqueForUpdate(string $email, int $excludeId): bool
    {
        return $this->where('email', $email)
                    ->where("id !=", $excludeId)
                    ->countAllResults() === 0;
    }

    /**
     * Update account helper (keeps controller cleaner).
     * $data should use keys in $allowedFields (password plain-text may be passed as 'password' and will be hashed).
     */
    public function updateAccount(int $id, array $data): bool
    {
        return (bool) $this->update($id, $data);
    }

    /**
     * Hash password before saving.
     * Accepts 'password' (plain) or 'password_hash' (already hashed or plain).
     * Stores hashed string in 'password_hash'.
     */
    protected function hashPassword(array $data)
    {
        if (!isset($data['data']) || !is_array($data['data'])) {
            return $data;
        }

        // if 'password' present (plain), convert to 'password_hash'
        if (!empty($data['data']['password'])) {
            $pw = $data['data']['password'];

            // avoid double hashing: if it looks like a password_hash already, keep it
            if (!preg_match('/^\$2y\$|^\$2a\$|^\$argon2/', $pw)) {
                $data['data']['password_hash'] = password_hash($pw, PASSWORD_DEFAULT);
            } else {
                $data['data']['password_hash'] = $pw;
            }

            unset($data['data']['password']);
            return $data;
        }

        // if caller supplied 'password_hash' (could be plain or hashed)
        if (!empty($data['data']['password_hash'])) {
            $pwHash = $data['data']['password_hash'];
            if (!preg_match('/^\$2y\$|^\$2a\$|^\$argon2/', $pwHash)) {
                // plain text (unexpected) — hash it
                $data['data']['password_hash'] = password_hash($pwHash, PASSWORD_DEFAULT);
            }
        }

        return $data;
    }
}
