<?php

namespace App\Controllers\Front;

use App\Controllers\BaseController;

class ProfilController extends BaseController
{
    public function index()
    {
        return view('front/profil', ['title' => 'Mon profil']);
    }

    public function update()
    {
        return redirect()->back()->with('success', 'Profil mis a jour.');
    }
}
