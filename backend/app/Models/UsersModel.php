<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array'; // returning arrays (you can change to entity if you add one)
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'first_name', 'middle_name', 'last_name', 'email',
        'password_hash', 'type', 'account_status', 'email_activated',
        'newsletter', 'gender', 'profile_image'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation rules (example — keep form/password validation in controller)
    protected $validationRules = [
        'first_name' => 'required|max_length[100]',
        'last_name'  => 'required|max_length[100]',
        'email'      => 'required|valid_email|is_unique[users.email]',
        // Note: do NOT validate password_hash here — handle raw password validation in controller
    ];

    // Optional callbacks — uncomment and implement if you want the model to hash passwords automatically
    // protected $beforeInsert = ['hashPassword'];
    // protected $beforeUpdate = ['hashPassword'];

    /**
     * Convenience: find user by email
     *
     * @param string $email
     * @return array|object|null
     */
    public function findByEmail(string $email)
    {
        return $this->where('email', $email)->first();
    }

    /**
     * Example callback to hash a plain 'password' field into 'password_hash'.
     * Uncomment the $beforeInsert/$beforeUpdate arrays above to enable.
     *
     * @param array $data
     * @return array
     */
    protected function hashPassword(array $data)
    {
        if (isset($data['data']['password'])) {
            $data['data']['password_hash'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
            unset($data['data']['password']);
        }
        return $data;
    }
}
