<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ParametreSeeder extends Seeder
{
    public function run()
    {
        $parametres = [
            ['cle' => 'prix_gold', 'valeur' => '29.99'],
            ['cle' => 'gold_price', 'valeur' => '29.99'],
            ['cle' => 'remise_gold_pct', 'valeur' => '15'],
            ['cle' => 'gold_discount', 'valeur' => '15'],
            ['cle' => 'imc_ideal_min', 'valeur' => '18.5'],
            ['cle' => 'imc_ideal_max', 'valeur' => '24.9'],
            ['cle' => 'imc_surpoids', 'valeur' => '25.0'],
            ['cle' => 'imc_obesite', 'valeur' => '30.0'],
        ];

        $this->db->table('parametres')->emptyTable();
        $this->db->table('parametres')->insertBatch($parametres);
    }
}
