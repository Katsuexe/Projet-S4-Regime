<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;

class RegisterStep1 extends BaseController
{
    public function index()
    {
        if (session()->get('user_id')) {
            return redirect()->to('/suggestions');
        }

        return view('auth/register_step1', [
            'title' => 'Inscription - Etape 1',
            'step'  => 1,
        ]);
    }

    public function store()
    {
        $rules = [
            'nom'              => 'required|min_length[2]|max_length[100]',
            'prenom'           => 'required|min_length[2]|max_length[100]',
            'email'            => 'required|valid_email|is_unique[users.email]',
            'genre'            => 'required|in_list[homme,femme]',
            'password'         => 'required|min_length[8]',
            'password_confirm' => 'required|matches[password]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $payload = [
            'nom'      => trim((string) $this->request->getPost('nom')),
            'prenom'   => trim((string) $this->request->getPost('prenom')),
            'email'    => strtolower(trim((string) $this->request->getPost('email'))),
            'genre'    => (string) $this->request->getPost('genre'),
            'password' => (string) $this->request->getPost('password'),
        ];

        session()->set('register_step1', $payload);

        return redirect()->to('/inscription/etape2');
    }
}
