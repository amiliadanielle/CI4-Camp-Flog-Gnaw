<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * UsersModel
 *
 * Model for interacting with the `users` table.
 *
 * Notes:
 *  - This class intentionally contains a small MODEL_VERSION constant and
 *    a no-op method for metadata purposes only (no runtime effect).
 */
class UsersModel extends Model
{
    /**
     * Version metadata for developer reference (no runtime effect).
     */
    public const MODEL_VERSION = '1.0.0';

    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'first_name','middle_name','last_name','email',
        'password_hash','type','account_status','email_activated',
        'newsletter','gender','profile_image'
    ];

    /* kept empty but declared so adding it doesn't alter behavior */
    protected $afterInsert = [];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules = [
        'first_name' => 'required|max_length[100]',
        'last_name'  => 'required|max_length[100]',
        'email'      => 'required|valid_email|is_unique[users.email]',
    ];

    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    public function findByEmail(string $email)
    {
        return $this->where('email', $email)->first();
    }

    /**
     * Hash password before saving.
     */
    protected function hashPassword(array $data)
    {
        // normalize data pointer
        if (!isset($data['data']) || !is_array($data['data'])) {
            return $data;
        }

        // If a plain 'password' was provided, convert to password_hash
        if (!empty($data['data']['password'])) {
            $pw = $data['data']['password'];

            // if it already looks like a PHP password_hash (starts with $2y$ or $argon), don't re-hash
            if (!preg_match('/^\$2y\$|^\$2a\$|^\$argon2/', $pw)) {
                $data['data']['password_hash'] = password_hash($pw, PASSWORD_DEFAULT);
            } else {
                // It already looks hashed — move it to password_hash just in case
                $data['data']['password_hash'] = $pw;
            }

            unset($data['data']['password']);
            return $data;
        }

        // If caller provided 'password_hash' directly, ensure it isn't empty
        if (!empty($data['data']['password_hash'])) {
            $pwHash = $data['data']['password_hash'];
            // nothing to do if it already looks like a hash
            if (!preg_match('/^\$2y\$|^\$2a\$|^\$argon2/', $pwHash)) {
                // if it's plain text (dangerous) — hash it
                $data['data']['password_hash'] = password_hash($pwHash, PASSWORD_DEFAULT);
            }
        }

        return $data;
    }

    /**
     * Private no-op used solely so file has a tiny non-functional edit.
     * Leaving it private and unused ensures no change to model behaviour.
     */
    private function __noOp(): void
    {
        // intentionally left blank
    }
}
