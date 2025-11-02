<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use Config\Migrations;

class CreateBoothsTable extends Migrations
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'=>'INT','constraint'=>11,'unsigned'=>true,'auto_increment'=>true
            ],
            'name' => ['type'=>'VARCHAR','constraint'=>150,'null'=>false],
            'description' => ['type'=>'TEXT','null'=>true],
            'location' => ['type'=>'VARCHAR','constraint'=>150,'null'=>true],
            'created_at' => ['type'=>'DATETIME','null'=>true],
            'updated_at' => ['type'=>'DATETIME','null'=>true],
            'deleted_at' => ['type'=>'DATETIME','null'=>true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('booths', true);
    }

    public function down()
    {
        $this->forge->dropTable('booths', true);
    }
}
