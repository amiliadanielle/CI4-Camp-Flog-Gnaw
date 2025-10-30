<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ClearDatabaseSeeder extends UsersSeeder
{
    public function run()
    {
        // tables in order (truncate respecting FKs); add 'users'
        $tablesInOrder = [
            'users',
            // add other tables here as needed
        ];

        $db = \Config\Database::connect();

        foreach ($tablesInOrder as $table) {
            // disable foreign key checks, then truncate, then enable
            $db->query('SET FOREIGN_KEY_CHECKS=0;');
            $db->table($table)->truncate();
            $db->query('SET FOREIGN_KEY_CHECKS=1;');
        }
    }
}
