<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddRoleToUsersTable extends Migration
{
    public function up()
    {
        if (! $this->db->fieldExists('role', 'users')) {
            $this->forge->addColumn('users', [
                'role' => [
                    'type'       => 'ENUM',
                    'constraint' => ['sportif', 'admin', 'coach'],
                    'default'    => 'sportif',
                    'after'      => 'password',
                ],
            ]);
        }
    }

    public function down()
    {
        if ($this->db->fieldExists('role', 'users')) {
            $this->forge->dropColumn('users', 'role');
        }
    }
}
