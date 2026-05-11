<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (! session()->get('user_id')) {
            $this->rememberIntendedUrl($request, 'sportif');

            return redirect()->to('/connexion')->with('error', 'Connectez-vous d abord.');
        }

        if (session()->get('auth_role') !== 'sportif') {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return null;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Pas de post-traitement: filtre read-only pour proteger les routes.
        unset($request, $response, $arguments);
    }

    private function rememberIntendedUrl(RequestInterface $request, string $role): void
    {
        if (strtoupper($request->getMethod()) !== 'GET') {
            return;
        }

        $path = trim($request->getUri()->getPath(), '/');
        if ($path === '') {
            return;
        }

        $query = $request->getUri()->getQuery();
        $target = '/' . $path . ($query !== '' ? '?' . $query : '');

        session()->set([
            'intended_url' => $target,
            'intended_role' => $role,
        ]);
    }
}
