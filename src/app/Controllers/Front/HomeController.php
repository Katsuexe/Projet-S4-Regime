<?php

namespace App\Controllers\Front;

use App\Controllers\BaseController;

class HomeController extends BaseController
{
    public function index()
    {
        if (session()->get('user_id')) {
            $role = session()->get('auth_role') ?? 'sportif';

            return redirect()->to(match ($role) {
                'admin' => '/admin',
                'coach' => '/coach',
                default => '/suggestions',
            });
        }

        return redirect()->to('/inscription/etape1');
    }
}
