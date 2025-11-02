<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use Config\Migrations;

class CreateSingersTable extends Migrations
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type'=>'INT','constraint'=>11,'unsigned'=>true,'auto_increment'=>true],
            'name' => ['type'=>'VARCHAR','constraint'=>200,'null'=>false],
            'genre' => ['type'=>'VARCHAR','constraint'=>100,'null'=>true],
            'bio' => ['type'=>'TEXT','null'=>true],
            'performance_date' => ['type'=>'DATETIME','null'=>true],
            'created_at' => ['type'=>'DATETIME','null'=>true],
            'updated_at' => ['type'=>'DATETIME','null'=>true],
            'deleted_at' => ['type'=>'DATETIME','null'=>true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('singers', true);
    }

    public function down()
    {
        $this->forge->dropTable('singers', true);
    }
}
