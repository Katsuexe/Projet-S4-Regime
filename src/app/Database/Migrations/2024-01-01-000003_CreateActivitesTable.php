<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateActivitesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nom' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'calories_h' => [
                'type'       => 'SMALLINT',
                'constraint' => 6,
                'null'       => true,
            ],
            'duree_min' => [
                'type'       => 'SMALLINT',
                'constraint' => 6,
                'null'       => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('activites', true);
    }

    public function down()
    {
        $this->forge->dropTable('activites', true);
    }
}
