<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->db->query('SET FOREIGN_KEY_CHECKS = 0');
        $this->db->table('user_regimes')->emptyTable();
        $this->db->table('codes')->emptyTable();
        $this->db->table('regime_durees')->emptyTable();
        $this->db->table('user_sante')->emptyTable();
        $this->db->table('activites')->emptyTable();
        $this->db->table('regimes')->emptyTable();
        $this->db->table('users')->emptyTable();
        $this->db->table('parametres')->emptyTable();
        $this->db->query('SET FOREIGN_KEY_CHECKS = 1');

        $this->call(UserSeeder::class);
        $this->call(RegimeSeeder::class);
        $this->call(ActiviteSeeder::class);
        $this->call(CodeSeeder::class);
        $this->call(ParametreSeeder::class);
    }
}
