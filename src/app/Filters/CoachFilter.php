<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\AuthGroups;

class CoachFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (! session()->get('user_id')) {
            $config = config(AuthGroups::class);

            return redirect()->to('/' . $config->hiddenLoginRoutes['coach'])->with('error', 'Connectez-vous avec un compte coach.');
        }

        if (session()->get('auth_role') !== 'coach') {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return null;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
