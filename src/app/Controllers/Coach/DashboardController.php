<?php

namespace App\Controllers\Coach;

use App\Controllers\BaseController;

class DashboardController extends BaseController
{
    public function index()
    {
        return view('coach/dashboard', [
            'title' => 'Espace coach',
        ]);
    }
}
