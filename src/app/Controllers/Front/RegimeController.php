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
        $userId = session('user_id');
        if (! $userId) {
            return redirect()->to('/connexion')->with('error', 'Veuillez vous connecter pour modifier votre objectif.');
        }

        $rules = [
            'objectif' => 'required|in_list[augmenter,reduire,ideal]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $objectif = $this->request->getPost('objectif');

        $userSanteModel = new UserSanteModel();
        $existing = $userSanteModel->where('user_id', $userId)->first();

        if ($existing) {
            $userSanteModel->update($existing['id'], ['objectif' => $objectif]);
        } else {
            $userSanteModel->insert(['user_id' => $userId, 'objectif' => $objectif]);
        }

        return redirect()->to('/profil')->with('success', 'Objectif mis a jour.');
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

        $activites = (new ActiviteModel())->orderBy('nom', 'ASC')->findAll();

        $subscriptions = [];
        $activeRegimeIds = [];
        if ($userId) {
            $userRegimeModel = new UserRegimeModel();
            $subscriptions = $userRegimeModel->where('user_id', $userId)->orderBy('date_debut', 'DESC')->findAll();
            $regimeIds = array_unique(array_filter(array_column($subscriptions, 'regime_id')));
            $dureeIds = array_unique(array_filter(array_column($subscriptions, 'regime_duree_id')));
            $regimeMap = [];
            if (! empty($regimeIds)) {
                $regimeRows = $regimeModel->whereIn('id', $regimeIds)->findAll();
                $regimeMap = array_column($regimeRows, 'nom', 'id');
            }
            $durees = [];
            if (! empty($dureeIds)) {
                $durees = $regimeDureeModel->whereIn('id', $dureeIds)->findAll();
            }
            $dureesById = array_column($durees, null, 'id');
            $today = strtotime(date('Y-m-d'));

            foreach ($subscriptions as &$subscription) {
                $duree = $dureesById[$subscription['regime_duree_id']] ?? null;
                $subscription['regime_nom'] = $regimeMap[$subscription['regime_id']] ?? 'Programme';
                $subscription['duree_label'] = $duree ? ((string) $duree['duree_jours'] . ' j') : '-';
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

                if ($subscription['active']) {
                    $activeRegimeIds[$subscription['regime_id']] = true;
                }
            }
            unset($subscription);
        }

        $regimeIds = array_unique(array_filter(array_column($regimes, 'id')));
        $dureesByRegime = [];
        if (! empty($regimeIds)) {
            $durees = $regimeDureeModel->whereIn('regime_id', $regimeIds)->orderBy('duree_jours', 'ASC')->findAll();
            foreach ($durees as $duree) {
                $dureesByRegime[$duree['regime_id']][] = $duree;
            }
        }

        foreach ($regimes as &$regime) {
            $regime['durees'] = $dureesByRegime[$regime['id']] ?? [];
            $regime['hasActiveSubscription'] = ! empty($activeRegimeIds[$regime['id']]);
        }
        unset($regime);

        $objectif = $sante['objectif'] ?? '';
        if (in_array($objectif, ['augmenter', 'reduire', 'ideal'], true)) {
            $scored = [];
            foreach ($regimes as $index => $regime) {
                $deltaMin = (float) ($regime['delta_poids_min'] ?? 0);
                $deltaMax = (float) ($regime['delta_poids_max'] ?? 0);
                $tag = 'ideal';

                if ($deltaMin >= 0 && $deltaMax >= 0) {
                    $tag = 'augmenter';
                } elseif ($deltaMin <= 0 && $deltaMax <= 0) {
                    $tag = 'reduire';
                }

                $scored[] = [
                    'score' => $tag === $objectif ? 0 : 1,
                    'index' => $index,
                    'regime' => $regime,
                ];
            }

            usort($scored, static function ($a, $b) {
                if ($a['score'] === $b['score']) {
                    return $a['index'] <=> $b['index'];
                }
                return $a['score'] <=> $b['score'];
            });

            $regimes = array_values(array_map(static fn ($item) => $item['regime'], $scored));
        }

        return view('front/suggestions', [
            'title' => 'Suggestions',
            'user' => $user,
            'sante' => $sante,
            'imc' => $imc,
            'regimes' => $regimes,
            'activites' => $activites,
            'subscriptions' => $subscriptions,
        ]);
    }
}
