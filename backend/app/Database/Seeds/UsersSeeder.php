<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');
        $password = password_hash('Password123!', PASSWORD_DEFAULT);

        $data = [
            [
                'first_name' => 'Juan',
                'middle_name' => 'Dela',
                'last_name' => 'Cruz',
                'email' => 'juan.cruz@example.com',
                'password_hash' => $password,
                'type' => 'client',
                'account_status' => 1,
                'email_activated' => 1,
                'newsletter' => 1,
                'gender' => 'male',
                'profile_image' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'first_name' => 'Maria',
                'middle_name' => null,
                'last_name' => 'Santos',
                'email' => 'maria.santos@example.com',
                'password_hash' => $password,
                'type' => 'manager',
                'account_status' => 1,
                'email_activated' => 1,
                'newsletter' => 1,
                'gender' => 'female',
                'profile_image' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        // Insert batch
        $this->db->table('users')->insertBatch($data);
    }
}
