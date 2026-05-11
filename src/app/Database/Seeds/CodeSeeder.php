<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CodeSeeder extends Seeder
{
    public function run()
    {
        $codes = [
            ['code' => 'BIENV-2024-AAAA', 'montant' => 5.00, 'is_used' => 0],
            ['code' => 'BIENV-2024-BBBB', 'montant' => 5.00, 'is_used' => 0],
            ['code' => 'PROMO-10-CCCC', 'montant' => 10.00, 'is_used' => 0],
            ['code' => 'PROMO-10-DDDD', 'montant' => 10.00, 'is_used' => 0],
            ['code' => 'PROMO-10-EEEE', 'montant' => 10.00, 'is_used' => 0],
            ['code' => 'SUPER-20-FFFF', 'montant' => 20.00, 'is_used' => 0],
            ['code' => 'SUPER-20-GGGG', 'montant' => 20.00, 'is_used' => 0],
            ['code' => 'MEGA-50-HHHH', 'montant' => 50.00, 'is_used' => 0],
            ['code' => 'MEGA-50-IIII', 'montant' => 50.00, 'is_used' => 0],
            ['code' => 'GOLD-100-JJJJ', 'montant' => 100.00, 'is_used' => 0],
            ['code' => 'GOLD-100-KKKK', 'montant' => 100.00, 'is_used' => 0],
            ['code' => 'NOEL-15-LLLL', 'montant' => 15.00, 'is_used' => 0],
            ['code' => 'NOEL-15-MMMM', 'montant' => 15.00, 'is_used' => 0],
            ['code' => 'TEST-2-NNNN', 'montant' => 2.50, 'is_used' => 0],
            ['code' => 'TEST-2-OOOO', 'montant' => 2.50, 'is_used' => 0],
        ];

        $this->db->table('codes')->emptyTable();
        $this->db->table('codes')->insertBatch($codes);
    }
}
