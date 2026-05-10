<?php

namespace App\Controllers\Front;

use App\Controllers\BaseController;
use App\Libraries\ImcCalculator;
use App\Models\UserModel;
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
