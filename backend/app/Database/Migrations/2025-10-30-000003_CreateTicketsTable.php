<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use Config\Migrations;

class CreateTicketsTable extends Migrations
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type'=>'INT','constraint'=>11,'unsigned'=>true,'auto_increment'=>true],
            'type' => ['type'=>'VARCHAR','constraint'=>150,'null'=>false], // e.g. VIP, Regular
            'price' => ['type'=>'DECIMAL','constraint'=>'10,2','null'=>false,'default'=>'0.00'],
            'available' => ['type'=>'INT','constraint'=>11,'null'=>false,'default'=>0],
            'description' => ['type'=>'TEXT','null'=>true],
            'created_at' => ['type'=>'DATETIME','null'=>true],
            'updated_at' => ['type'=>'DATETIME','null'=>true],
            'deleted_at' => ['type'=>'DATETIME','null'=>true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('tickets', true);
    }

    public function down()
    {
        $this->forge->dropTable('tickets', true);
    }
}
