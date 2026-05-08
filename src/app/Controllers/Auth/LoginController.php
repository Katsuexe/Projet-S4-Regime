<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Models\UserModel;
use Config\AuthGroups;

class LoginController extends BaseController
{
    public function index()
    {
        if ($redirect = $this->redirectIfAuthenticated()) {
            return $redirect;
        }

        return view('auth/login', [
            'title' => 'Connexion',
            'space' => 'sportif',
        ]);
    }

    public function login()
    {
        return $this->handleLogin('sportif');
    }

    public function adminIndex()
    {
        if ($redirect = $this->redirectIfAuthenticated()) {
            return $redirect;
        }

        return view('auth/login', [
            'title' => 'Connexion administrateur',
            'space' => 'admin',
        ]);
    }

    public function adminLogin()
    {
        return $this->handleLogin('admin');
    }

    public function coachIndex()
    {
        if ($redirect = $this->redirectIfAuthenticated()) {
            return $redirect;
        }

        return view('auth/login', [
            'title' => 'Connexion coach',
            'space' => 'coach',
        ]);
    }

    public function coachLogin()
    {
        return $this->handleLogin('coach');
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to('/connexion')->with('success', 'Vous etes deconnecte.');
    }

    public function adminLogout()
    {
        $config = config(AuthGroups::class);
        session()->destroy();

        return redirect()->to('/' . $config->hiddenLoginRoutes['admin'])->with('success', 'Session administrateur fermee.');
    }

    public function coachLogout()
    {
        $config = config(AuthGroups::class);
        session()->destroy();

        return redirect()->to('/' . $config->hiddenLoginRoutes['coach'])->with('success', 'Session coach fermee.');
    }

    private function handleLogin(string $expectedRole)
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

        $role = $user['role'] ?? 'sportif';

        if ($role !== $expectedRole) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        session()->set([
            'user_id'     => $user['id'],
            'user_nom'    => $user['nom'],
            'user_prenom' => $user['prenom'],
            'user_email'  => $user['email'],
            'genre'       => $user['genre'],
            'is_gold'     => (bool) ($user['is_gold'] ?? false),
            'auth_role'   => $role,
        ]);

        $config = config(AuthGroups::class);
        $redirect = $config->defaultRedirects[$role] ?? '/';

        return redirect()->to($redirect)->with('success', 'Connexion reussie.');
    }

    private function redirectIfAuthenticated()
    {
        if (! session()->get('user_id')) {
            return null;
        }

        $config = config(AuthGroups::class);
        $role = session()->get('auth_role') ?: 'sportif';
        $redirect = $config->defaultRedirects[$role] ?? '/';

        return redirect()->to($redirect);
    }
}
