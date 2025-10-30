<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class User extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [
        'id' => 'int',
        'account_status' => 'int',
        'email_activated' => 'int',
        'newsletter' => 'int',
    ];

    /**
     * Convenience: return a friendly full name
     *
     * @return string
     */
    public function getFullName(): string
    {
        $first = $this->attributes['first_name'] ?? '';
        $middle = $this->attributes['middle_name'] ?? '';
        $last = $this->attributes['last_name'] ?? '';

        $parts = array_filter([$first, $middle, $last]);
        return implode(' ', $parts);
    }

    /**
     * Set password by hashing and storing in password_hash field.
     * Use $user->setPassword('plain') before saving via model if you want.
     */
    public function setPassword(string $plain)
    {
        $this->attributes['password_hash'] = password_hash($plain, PASSWORD_DEFAULT);
        return $this;
    }

    /**
     * Check password convenience
     */
    public function checkPassword(string $plain): bool
    {
        return password_verify($plain, $this->attributes['password_hash'] ?? '');
    }
}
