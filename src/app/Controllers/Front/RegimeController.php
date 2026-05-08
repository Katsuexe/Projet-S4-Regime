<?php

namespace App\Controllers\Front;

use App\Controllers\BaseController;
use App\Libraries\ImcCalculator;
use App\Models\ActiviteModel;
use App\Models\RegimeDureeModel;
use App\Models\RegimeModel;
use App\Models\UserModel;
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
