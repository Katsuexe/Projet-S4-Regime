<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RegimeSeeder extends Seeder
{
    public function run()
    {
        $regimes = [
            [1, 'Mediterraneen', 'Inspire des pays du bassin mediterraneen, riche en poisson, legumes et huile d olive. Ideal pour atteindre un IMC equilibre.', 20.00, 40.00, 40.00, -0.50, 0.20],
            [2, 'Hyperproteine', 'Regime riche en proteines animales favorisant la prise de masse musculaire et l augmentation du poids corporel.', 50.00, 20.00, 30.00, 0.30, 1.00],
            [3, 'Hypocalorique', 'Regime a faible apport calorique base sur la volaille maigre et le poisson pour une perte de poids progressive.', 15.00, 35.00, 50.00, -1.50, -0.30],
            [4, 'Cetogene', 'Tres faible en glucides, tres riche en proteines et lipides. Favorise une perte de poids rapide par cetose.', 60.00, 10.00, 30.00, -2.00, -0.50],
            [5, 'Flexitarien marin', 'Priorite au poisson et a la volaille, viande reduite au minimum. Equilibre et durable pour maintenir l IMC ideal.', 5.00, 55.00, 40.00, -0.80, 0.10],
        ];

        $durees = [
            [1, 7, 9.99], [1, 14, 17.99], [1, 30, 29.99], [1, 60, 49.99],
            [2, 7, 12.99], [2, 14, 22.99], [2, 30, 39.99], [2, 60, 69.99],
            [3, 7, 8.99], [3, 14, 15.99], [3, 30, 27.99], [3, 60, 44.99],
            [4, 7, 14.99], [4, 14, 26.99], [4, 30, 44.99], [4, 60, 79.99],
            [5, 7, 10.99], [5, 14, 19.99], [5, 30, 34.99], [5, 60, 59.99],
        ];

        $regimeRows = array_map(static fn (array $row): array => [
            'id' => $row[0],
            'nom' => $row[1],
            'description' => $row[2],
            'pct_viande' => $row[3],
            'pct_poisson' => $row[4],
            'pct_volaille' => $row[5],
            'delta_poids_min' => $row[6],
            'delta_poids_max' => $row[7],
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ], $regimes);

        $dureeRows = array_map(static fn (array $row): array => [
            'regime_id' => $row[0],
            'duree_jours' => $row[1],
            'prix' => $row[2],
        ], $durees);

        $this->db->table('regime_durees')->emptyTable();
        $this->db->table('regimes')->emptyTable();
        $this->db->table('regimes')->insertBatch($regimeRows);
        $this->db->table('regime_durees')->insertBatch($dureeRows);
    }
}
