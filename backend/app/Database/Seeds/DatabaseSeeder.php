<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

/**
 * DatabaseSeeder
 *
 * Docblock hints help Intelephense (VS Code) understand methods/properties
 * provided by the CodeIgniter Seeder base class when the framework isn't indexed.
 *
 * @method void call(string $class)
 */
class DatabaseSeeder extends UsersSeeder
{
    public function run()
    {
        // call other seeders
        $this->call('App\\Database\\Seeds\\ClearDatabaseSeeder');
        $this->call('App\\Database\\Seeds\\UsersSeeder');

        // $this->call('App\\Database\\Seeds\\<name of the seeder here>');
    }
}
