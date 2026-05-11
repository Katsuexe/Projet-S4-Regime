<?php

namespace App\Controllers\Front;

use App\Controllers\BaseController;
use App\Libraries\ImcCalculator;
use App\Models\ActiviteModel;
use App\Models\RegimeDureeModel;
use App\Models\RegimeModel;
use App\Models\UserModel;
use App\Models\UserRegimeModel;
use App\Models\UserSanteModel;

class ProfilController extends BaseController
{
    public function index()
    {
        $userId = session()->get('user_id');

        if (! $userId) {
            return redirect()->to('/connexion')->with('error', 'Veuillez vous connecter pour voir votre profil.');
        }

        $userModel = new UserModel();
        $user = $userModel->find($userId);

        if (! $user) {
            session()->destroy();
            return redirect()->to('/connexion')->with('error', 'Utilisateur introuvable.');
        }

        $userSanteModel = new UserSanteModel();
        $sante = $userSanteModel->where('user_id', $userId)->first() ?: [];

        $userRegimeModel = new UserRegimeModel();
        $regimeModel = new RegimeModel();
        $regimeDureeModel = new RegimeDureeModel();
        $activiteModel = new ActiviteModel();
        $subscriptions = $userRegimeModel->where('user_id', $userId)->orderBy('date_debut', 'DESC')->findAll();

        $regimeIds = array_unique(array_filter(array_column($subscriptions, 'regime_id')));
        $dureeIds = array_unique(array_filter(array_column($subscriptions, 'regime_duree_id')));
        $activiteIds = array_unique(array_filter(array_column($subscriptions, 'activite_id')));

        $regimes = [];
        if (! empty($regimeIds)) {
            $regimes = $regimeModel->whereIn('id', $regimeIds)->findAll();
        }
        $durees = [];
        if (! empty($dureeIds)) {
            $durees = $regimeDureeModel->whereIn('id', $dureeIds)->findAll();
        }
        $activites = [];
        if (! empty($activiteIds)) {
            $activites = $activiteModel->whereIn('id', $activiteIds)->findAll();
        }

        $regimeMap = array_column($regimes, 'nom', 'id');
        $dureeMap = array_column($durees, null, 'id');
        $activiteMap = array_column($activites, 'nom', 'id');
        $today = strtotime(date('Y-m-d'));

        foreach ($subscriptions as &$subscription) {
            $duree = $dureeMap[$subscription['regime_duree_id']] ?? null;
            $subscription['regime_nom'] = $regimeMap[$subscription['regime_id']] ?? 'Programme';
            $subscription['duree_label'] = $duree ? ((string) $duree['duree_jours'] . ' j') : '-';
            $subscription['activite_nom'] = $subscription['activite_id'] ? ($activiteMap[$subscription['activite_id']] ?? '-') : 'Aucune';
            $subscription['date_fin'] = '-';
            $subscription['active'] = false;
            if (! empty($subscription['date_debut']) && $duree) {
                $startTimestamp = strtotime($subscription['date_debut']);
                $endTimestamp = $startTimestamp ? strtotime('+' . (int) $duree['duree_jours'] . ' days', $startTimestamp) : 0;
                if ($endTimestamp) {
                    $subscription['date_fin'] = date('Y-m-d', $endTimestamp);
                    $subscription['active'] = $today <= $endTimestamp;
                }
            }
        }
        unset($subscription);

        $imc = 0;
        $categorie = '-';
        $ideal = ['poids_ideal' => '-', 'imc_min' => '-', 'imc_max' => '-'];

        if (! empty($sante['poids']) && ! empty($sante['taille'])) {
            $imc = ImcCalculator::calculate((float) $sante['poids'], (float) $sante['taille']);
            $categorie = ImcCalculator::categorie($imc);
            $ideal = ImcCalculator::imcIdeal((string) ($user['genre'] ?? 'homme'), (float) $sante['taille']);
        }

        return view('front/profil', [
            'title'     => 'Mon profil',
            'user'      => $user,
            'sante'     => $sante,
            'imc'       => $imc,
            'categorie' => $categorie,
            'ideal'     => $ideal,
            'subscriptions' => $subscriptions,
        ]);
    }

    public function update()
    {
        $userId = session()->get('user_id');

        if (! $userId) {
            return redirect()->to('/connexion')->with('error', 'Veuillez vous connecter pour modifier votre profil.');
        }

        $rules = [
            'taille'  => 'required|numeric|greater_than_equal_to[100]|less_than_equal_to[250]',
            'poids'   => 'required|numeric|greater_than_equal_to[30]|less_than_equal_to[300]',
            'objectif' => 'required|in_list[augmenter,reduire,ideal]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $santeData = [
            'taille'   => (float) $this->request->getPost('taille'),
            'poids'    => (float) $this->request->getPost('poids'),
            'objectif' => $this->request->getPost('objectif'),
        ];

        $userSanteModel = new UserSanteModel();
        $existing = $userSanteModel->where('user_id', $userId)->first();

        if ($existing) {
            $userSanteModel->update($existing['id'], $santeData);
        } else {
            $userSanteModel->insert(array_merge(['user_id' => $userId], $santeData));
        }

        return redirect()->back()->with('success', 'Profil mis à jour.');
    }
}
