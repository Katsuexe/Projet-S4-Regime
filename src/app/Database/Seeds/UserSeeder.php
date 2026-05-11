<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'id' => 1,
                'nom' => 'Rakoto',
                'prenom' => 'Jean',
                'email' => 'jean.rakoto@mail.mg',
                'password' => '$2y$10$Fp1WCzC/ksEBRnd8tMv3JO7e/28g8tkSvmDZ6MunlVKEmukwE44Oa',
                'role' => 'sportif',
                'genre' => 'homme',
                'is_gold' => 0,
                'solde' => 50.00,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 2,
                'nom' => 'Rasoa',
                'prenom' => 'Marie',
                'email' => 'marie.rasoa@mail.mg',
                'password' => '$2y$10$gJ3jd9DWTSNWgCL0WRlc0untwFQum15L0X52LHOPWT3rdNxVKVBL2',
                'role' => 'sportif',
                'genre' => 'femme',
                'is_gold' => 1,
                'solde' => 120.00,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 3,
                'nom' => 'Ramiandri',
                'prenom' => 'Paul',
                'email' => 'paul.ramiandri@mail.mg',
                'password' => '$2y$10$McaBMvrrrLg2OeHc8tKfP.Ks9hPJ8/CBRUzSA5e/bOmSq8RAQBi5u',
                'role' => 'sportif',
                'genre' => 'homme',
                'is_gold' => 0,
                'solde' => 30.00,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 4,
                'nom' => 'Ravelo',
                'prenom' => 'Sophie',
                'email' => 'sophie.ravelo@mail.mg',
                'password' => '$2y$10$/yVfbDodJCCL/h25QaPijeJU9kqoWy5U.AWnC/k6itsfFyUiPXPV.',
                'role' => 'sportif',
                'genre' => 'femme',
                'is_gold' => 0,
                'solde' => 75.50,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 5,
                'nom' => 'Andriana',
                'prenom' => 'Christophe',
                'email' => 'chris.andriana@mail.mg',
                'password' => '$2y$10$zRp8cyiXBpDWBpaJdTKhCu2DEl68jnU4itGARzhPcYthXmjboJOO6',
                'role' => 'sportif',
                'genre' => 'homme',
                'is_gold' => 1,
                'solde' => 200.00,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 6,
                'nom' => 'Admin',
                'prenom' => 'Systeme',
                'email' => 'admin@regime.local',
                'password' => '$2y$10$QVmIOwLxQUPZkaiRKzYO1ehBLESWORvQ7lARNKhY0vdfwHWmTQ33q',
                'role' => 'admin',
                'genre' => 'homme',
                'is_gold' => 0,
                'solde' => 0.00,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 7,
                'nom' => 'Coach',
                'prenom' => 'Principal',
                'email' => 'coach@regime.local',
                'password' => '$2y$10$u.HcnV5DjSacjzLUha.Oo.PjkfOu8KHc5lPPRCjoqYdqPjcwimgsy',
                'role' => 'coach',
                'genre' => 'femme',
                'is_gold' => 0,
                'solde' => 0.00,
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $userSante = [
            ['user_id' => 1, 'taille' => 175.00, 'poids' => 85.00, 'objectif' => 'reduire'],
            ['user_id' => 2, 'taille' => 162.00, 'poids' => 48.00, 'objectif' => 'augmenter'],
            ['user_id' => 3, 'taille' => 180.00, 'poids' => 95.00, 'objectif' => 'reduire'],
            ['user_id' => 4, 'taille' => 165.00, 'poids' => 63.00, 'objectif' => 'ideal'],
            ['user_id' => 5, 'taille' => 178.00, 'poids' => 72.00, 'objectif' => 'ideal'],
        ];

        $this->db->table('user_sante')->emptyTable();
        $this->db->table('users')->emptyTable();
        $this->db->table('users')->insertBatch($users);
        $this->db->table('user_sante')->insertBatch($userSante);
    }
}
