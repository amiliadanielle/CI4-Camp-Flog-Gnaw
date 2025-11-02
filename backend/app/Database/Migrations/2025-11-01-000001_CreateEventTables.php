<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEventTables extends Migration
{
    public function up()
    {
        // booths
        $this->forge->addField([
            'id' => ['type'=>'INT','unsigned'=>true,'auto_increment'=>true],
            'name' => ['type'=>'VARCHAR','constraint'=>255],
            'location' => ['type'=>'VARCHAR','constraint'=>255,'null'=>true],
            'description' => ['type'=>'TEXT','null'=>true],
            'created_at' => ['type'=>'DATETIME','null'=>true],
            'updated_at' => ['type'=>'DATETIME','null'=>true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('booths', true);

        // singers
        $this->forge->addField([
            'id' => ['type'=>'INT','unsigned'=>true,'auto_increment'=>true],
            'name' => ['type'=>'VARCHAR','constraint'=>255],
            'genre' => ['type'=>'VARCHAR','constraint'=>100,'null'=>true],
            'performance_date' => ['type'=>'DATETIME','null'=>true],
            'bio' => ['type'=>'TEXT','null'=>true],
            'created_at' => ['type'=>'DATETIME','null'=>true],
            'updated_at' => ['type'=>'DATETIME','null'=>true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('singers', true);

        // tickets
        $this->forge->addField([
            'id' => ['type'=>'INT','unsigned'=>true,'auto_increment'=>true],
            'type' => ['type'=>'VARCHAR','constraint'=>255],
            'price' => ['type'=>'DECIMAL','constraint'=>'10,2','default'=>'0.00'],
            'available' => ['type'=>'INT','unsigned'=>true,'default'=>0],
            'description' => ['type'=>'TEXT','null'=>true],
            'created_at' => ['type'=>'DATETIME','null'=>true],
            'updated_at' => ['type'=>'DATETIME','null'=>true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('tickets', true);
    }

    public function down()
    {
        $this->forge->dropTable('booths', true);
        $this->forge->dropTable('singers', true);
        $this->forge->dropTable('tickets', true);
    }
}
