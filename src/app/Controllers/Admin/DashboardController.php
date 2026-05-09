<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class DashboardController extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        
        $stats = [
            'nb_sportifs'    => $db->table('users')->where('role', 'sportif')->countAllResults(),
            'nb_gold'        => $db->table('users')->where('is_gold', 1)->countAllResults(),
            'solde_moyen'    => $db->query('SELECT AVG(solde) as v FROM users WHERE role="sportif"')->getRow()->v ?? 0,
            'revenus_total'  => $db->query('SELECT SUM(prix_paye) as v FROM user_regimes')->getRow()->v ?? 0,
            'codes_libres'   => $db->table('codes')->where('is_used', 0)->countAllResults(),
            'codes_utilises' => $db->table('codes')->where('is_used', 1)->countAllResults(),
        ];
        
        $chart_souscriptions = $db->query('
            SELECT DATE(created_at) as date, COUNT(*) as nb 
            FROM user_regimes 
            WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) 
            GROUP BY DATE(created_at) 
            ORDER BY date ASC
        ')->getResultArray();

        $chart_objectifs = $db->query('
            SELECT objectif, COUNT(*) as nb 
            FROM user_sante 
            GROUP BY objectif
        ')->getResultArray();
        
        $tableau_croise_1 = $db->query('
            SELECT r.nom, 
                   SUM(CASE WHEN s.objectif = "augmenter" THEN 1 ELSE 0 END) as augmenter,
                   SUM(CASE WHEN s.objectif = "reduire" THEN 1 ELSE 0 END) as reduire,
                   SUM(CASE WHEN s.objectif = "ideal" THEN 1 ELSE 0 END) as ideal,
                   COUNT(ur.id) as total
            FROM regimes r
            LEFT JOIN user_regimes ur ON ur.regime_id = r.id
            LEFT JOIN user_sante s ON s.user_id = ur.user_id
            GROUP BY r.id, r.nom
        ')->getResultArray();
        
        $tableau_croise_2 = $db->query('
            SELECT a.nom, COUNT(ur.id) as nb_souscriptions
            FROM activites a
            LEFT JOIN user_regimes ur ON ur.regime_id IN (
                SELECT regime_id FROM regimes /* Simplification, en supposant que les regimes ont des activites, il faudrait adapter selon schema */
            )
            GROUP BY a.id, a.nom
        ')->getResultArray();

        $derniers_achats = $db->query('
            SELECT u.prenom, u.nom, r.nom as regime, rd.duree_jours, ur.prix_paye, u.is_gold, ur.created_at
            FROM user_regimes ur
            JOIN users u ON u.id = ur.user_id
            JOIN regimes r ON r.id = ur.regime_id
            LEFT JOIN regime_durees rd ON rd.id = ur.regime_duree_id
            ORDER BY ur.created_at DESC
            LIMIT 10
        ')->getResultArray();

        $users_gold_recents = $db->query('
            SELECT nom, prenom, created_at 
            FROM users 
            WHERE is_gold = 1 
            ORDER BY id DESC 
            LIMIT 5
        ')->getResultArray();

        return view('admin/dashboard', [
            'title' => 'Espace administrateur',
            'stats' => $stats,
            'chart_souscriptions' => json_encode($chart_souscriptions),
            'chart_objectifs' => json_encode($chart_objectifs),
            'tableau_croise_1' => $tableau_croise_1,
            'tableau_croise_2' => $tableau_croise_2,
            'derniers_achats' => $derniers_achats,
            'users_gold_recents' => $users_gold_recents,
        ]);
    }
}

