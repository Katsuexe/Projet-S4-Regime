<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 *
 * Extend this class in any new controllers:
 * ```
 *     class Home extends BaseController
 * ```
 *
 * For security, be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */

    protected $helpers = ['form', 'url'];

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Load here all helpers you want to be available in your controllers that extend BaseController.
        // Caution: Do not put the this below the parent::initController() call below.
        // $this->helpers = ['form', 'url'];

        // Caution: Do not edit this line.
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.
        // $this->session = service('session');
        $this->hydrateAuthenticatedSession();
    }

    private function hydrateAuthenticatedSession(): void
    {
        $userId = session()->get('user_id');

        if (! $userId) {
            return;
        }

        $userModel = new UserModel();
        $user = $userModel->find($userId);

        if (! is_array($user)) {
            session()->destroy();
            return;
        }

        session()->set([
            'user_id'     => $user['id'],
            'user_nom'    => $user['nom'],
            'user_prenom' => $user['prenom'],
            'user_email'  => $user['email'],
            'genre'       => $user['genre'],
            'is_gold'     => (bool) ($user['is_gold'] ?? false),
            'auth_role'   => $user['role'] ?? 'sportif',
        ]);
    }
}
