<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Libraries\ImcCalculator;
use App\Models\UserModel;
use App\Models\UserSanteModel;

class RegisterStep2 extends BaseController
{
    public function index()
    {
        if (session()->get('user_id')) {
            return redirect()->to('/suggestions');
        }

        if (! session()->has('register_step1')) {
            return redirect()->to('/inscription/etape1')->with('error', 'Commencez par l etape 1 de l inscription.');
        }

        return view('auth/register_step2', [
            'title' => 'Inscription - Etape 2',
            'step'  => 2,
        ]);
    }

    public function store()
    {
        $step1 = session()->get('register_step1');

        if (! is_array($step1)) {
            return redirect()->to('/inscription/etape1')->with('error', 'Votre session d inscription a expire.');
        }

        $rules = [
            'taille'   => 'required|numeric|greater_than[100]|less_than[250]',
            'poids'    => 'required|numeric|greater_than[30]|less_than[300]',
            'objectif' => 'required|in_list[augmenter,reduire,ideal]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userModel = new UserModel();
        $santeModel = new UserSanteModel();

        $userId = $userModel->insert([
            'nom'      => $step1['nom'],
            'prenom'   => $step1['prenom'],
            'email'    => $step1['email'],
            'password' => password_hash($step1['password'], PASSWORD_DEFAULT),
            'role'     => 'sportif',
            'genre'    => $step1['genre'],
        ], true);

        $santeModel->insert([
            'user_id'  => $userId,
            'taille'   => (float) $this->request->getPost('taille'),
            'poids'    => (float) $this->request->getPost('poids'),
            'objectif' => (string) $this->request->getPost('objectif'),
        ]);

        $profile = $userModel->find($userId);
        $ideal = ImcCalculator::imcIdeal($profile['genre'], (float) $this->request->getPost('taille'));

        session()->remove('register_step1');
        session()->set([
            'user_id'     => $userId,
            'user_nom'    => $profile['nom'],
            'user_prenom' => $profile['prenom'],
            'user_email'  => $profile['email'],
            'auth_role'   => $profile['role'] ?? 'sportif',
            'genre'       => $profile['genre'],
            'is_gold'     => (bool) ($profile['is_gold'] ?? false),
            'poids_ideal' => $ideal['poids_ideal'],
        ]);

        return redirect()->to('/suggestions')->with('success', 'Votre compte sportif a ete cree avec succes.');
    }
}
