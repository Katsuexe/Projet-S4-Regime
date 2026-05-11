<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ActiviteSeeder extends Seeder
{
    public function run()
    {
        $activites = [
            [
                'id' => 1,
                'nom' => 'Marche rapide',
                'description' => 'Activite accessible a tous, ideale pour commencer. Ameliore le systeme cardiovasculaire et favorise la perte de poids progressive.',
                'calories_h' => 300,
                'duree_min' => 45,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 2,
                'nom' => 'Natation',
                'description' => 'Sport complet sollicitant tous les groupes musculaires. Tres efficace pour bruler des calories sans impact articulaire.',
                'calories_h' => 550,
                'duree_min' => 45,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 3,
                'nom' => 'Musculation',
                'description' => 'Entrainement en resistance pour developper la masse musculaire. Recommande en complement d un regime hyperproteine.',
                'calories_h' => 400,
                'duree_min' => 60,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 4,
                'nom' => 'Velo / Cyclisme',
                'description' => 'Activite cardio d endurance. Adaptee a tous les niveaux pour entretenir la forme et perdre du poids en douceur.',
                'calories_h' => 500,
                'duree_min' => 60,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 5,
                'nom' => 'Yoga & Stretching',
                'description' => 'Ameliore la souplesse, reduit le stress et favorise une meilleure conscience corporelle. Complementaire a tout regime.',
                'calories_h' => 200,
                'duree_min' => 30,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('activites')->emptyTable();
        $this->db->table('activites')->insertBatch($activites);
    }
}
