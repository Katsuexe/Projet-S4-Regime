<?php

namespace App\Controllers\Front;

use App\Controllers\BaseController;

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
        return view('front/suggestions', ['title' => 'Suggestions']);
    }
}
