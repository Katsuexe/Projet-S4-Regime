<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUserRegimesTable extends Migration
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
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'regime_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'regime_duree_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'activite_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'prix_paye' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'gold_remise' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
            ],
            'date_debut' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('regime_id', 'regimes', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('regime_duree_id', 'regime_durees', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('activite_id', 'activites', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('user_regimes', true);
    }

    public function down()
    {
        $this->forge->dropTable('user_regimes', true);
    }
}
