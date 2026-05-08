<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Models\UserModel;

class LoginController extends BaseController
{
    public function index()
    {
        if (session()->get('user_id')) {
            return redirect()->to('/suggestions');
        }

        return view('auth/login', [
            'title' => 'Connexion',
        ]);
    }

    public function login()
    {
        $rules = [
            'email'    => 'required|valid_email',
            'password' => 'required|min_length[8]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userModel = new UserModel();
        $user = $userModel->where('email', strtolower(trim((string) $this->request->getPost('email'))))->first();

        if (! $user || ! password_verify((string) $this->request->getPost('password'), $user['password'])) {
            return redirect()->back()->withInput()->with('error', 'Adresse email ou mot de passe incorrect.');
        }

        session()->set([
            'user_id'     => $user['id'],
            'user_nom'    => $user['nom'],
            'user_prenom' => $user['prenom'],
            'user_email'  => $user['email'],
            'genre'       => $user['genre'],
            'is_gold'     => (bool) ($user['is_gold'] ?? false),
        ]);

        return redirect()->to('/suggestions')->with('success', 'Connexion reussie.');
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to('/connexion')->with('success', 'Vous etes deconnecte.');
    }
}
