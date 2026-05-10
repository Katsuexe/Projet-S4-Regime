<?php

namespace App\Controllers\Front;

use App\Controllers\BaseController;
use App\Libraries\ImcCalculator;
use App\Libraries\RegimeSuggestor;
use App\Models\ActiviteModel;
use App\Models\RegimeDureeModel;
use App\Models\RegimeModel;
use App\Models\UserModel;
use App\Models\UserRegimeModel;
use App\Models\UserSanteModel;

class RegimeController extends BaseController
{
    public function objectif()
    {
        return view('front/objectif', ['title' => 'Mon objectif']);
    }

    public function choisir()
    {
        return redirect()->to('/suggestions');
    }

    public function souscrire()
    {
        $userId = session('user_id');
        if (! $userId) {
            return redirect()->to('/connexion')->with('error', 'Veuillez vous connecter pour souscrire.');
        }

        $rules = [
            'regime_id' => 'required|integer',
            'regime_duree_id' => 'required|integer',
            'activite_id' => 'permit_empty|integer',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Données de souscription invalides.');
        }

        $regimeId = (int) $this->request->getPost('regime_id');
        $regimeDureeId = (int) $this->request->getPost('regime_duree_id');
        $activiteId = $this->request->getPost('activite_id') ?: null;

        $regimeDureeModel = new RegimeDureeModel();
        $duree = $regimeDureeModel
            ->where('id', $regimeDureeId)
            ->where('regime_id', $regimeId)
            ->first();

        if (! $duree) {
            return redirect()->back()->withInput()->with('error', 'Durée invalide pour ce programme.');
        }

        $userModel = new UserModel();
        $user = $userModel->find($userId);
        if (! $user) {
            return redirect()->to('/connexion')->with('error', 'Utilisateur introuvable.');
        }

        $prixNet = RegimeSuggestor::applyGoldDiscount((float) $duree['prix'], (bool) ($user['is_gold'] ?? false));
        if ((float) ($user['solde'] ?? 0) < $prixNet) {
            return redirect()->back()->withInput()->with('error', 'Solde insuffisant pour souscrire à ce programme.');
        }

        $db = \Config\Database::connect();
        $db->transStart();

        $db->table('user_regimes')->insert([
            'user_id' => $userId,
            'regime_id' => $regimeId,
            'regime_duree_id' => $regimeDureeId,
            'activite_id' => $activiteId,
            'prix_paye' => $prixNet,
            'gold_remise' => (int) (bool) ($user['is_gold'] ?? false),
            'date_debut' => date('Y-m-d'),
        ]);

        $newSolde = (float) $user['solde'] - $prixNet;
        $db->table('users')->where('id', $userId)->update(['solde' => $newSolde]);

        $db->transComplete();
        if ($db->transStatus() === false) {
            return redirect()->back()->withInput()->with('error', 'Erreur lors de la souscription.');
        }

        session()->set('solde', $newSolde);

        return redirect()->to('/suggestions')->with('success', 'Souscription réussie. Nouveau solde : ' . number_format($newSolde, 2, ',', ' ') . ' Ar');
    }

    public function suggestions()
    {
        $userId = session('user_id');
        $user = [];
        $sante = [];
        $imc = 0.0;

        if ($userId) {
            $userModel = new UserModel();
            $user = $userModel->find($userId) ?? [];

            $santeModel = new UserSanteModel();
            $sante = $santeModel->where('user_id', $userId)->first() ?? [];

            if (! empty($sante['poids']) && ! empty($sante['taille'])) {
                $imc = ImcCalculator::calculate((float) $sante['poids'], (float) $sante['taille']);
            }
        }

        $regimeModel = new RegimeModel();
        $regimeDureeModel = new RegimeDureeModel();
        $regimes = $regimeModel->orderBy('id', 'ASC')->findAll();

        foreach ($regimes as &$regime) {
            $regime['durees'] = $regimeDureeModel
                ->where('regime_id', $regime['id'])
                ->orderBy('duree_jours', 'ASC')
                ->findAll();
        }
        unset($regime);

        $activites = (new ActiviteModel())->orderBy('nom', 'ASC')->findAll();

        $activeRegimeIds = [];
        if ($userId) {
            $userRegimeModel = new UserRegimeModel();
            $subscriptions = $userRegimeModel->where('user_id', $userId)->findAll();
            $dureeIds = array_unique(array_filter(array_column($subscriptions, 'regime_duree_id')));
            $durees = [];
            if (! empty($dureeIds)) {
                $durees = $regimeDureeModel->whereIn('id', $dureeIds)->findAll();
            }
            $dureesById = array_column($durees, null, 'id');
            $today = strtotime(date('Y-m-d'));

            foreach ($subscriptions as $subscription) {
                $duree = $dureesById[$subscription['regime_duree_id']] ?? null;
                $endTimestamp = 0;
                if (! empty($subscription['date_debut']) && $duree) {
                    $startTimestamp = strtotime($subscription['date_debut']);
                    $endTimestamp = $startTimestamp ? strtotime('+' . (int) $duree['duree_jours'] . ' days', $startTimestamp) : 0;
                }
                if ($endTimestamp && $today <= $endTimestamp) {
                    $activeRegimeIds[$subscription['regime_id']] = true;
                }
            }
        }

        foreach ($regimes as &$regime) {
            $regime['durees'] = $regimeDureeModel
                ->where('regime_id', $regime['id'])
                ->orderBy('duree_jours', 'ASC')
                ->findAll();
            $regime['hasActiveSubscription'] = ! empty($activeRegimeIds[$regime['id']]);
        }
        unset($regime);

        return view('front/suggestions', [
            'title' => 'Suggestions',
            'user' => $user,
            'sante' => $sante,
            'imc' => $imc,
            'regimes' => $regimes,
            'activites' => $activites,
        ]);
    }
}
