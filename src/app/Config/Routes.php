<?php

use CodeIgniter\Router\RouteCollection;
use Config\AuthGroups;

/**
 * @var RouteCollection $routes
 */
$authGroups = config(AuthGroups::class);

$routes->get('/', 'Front\HomeController::index');

$routes->get('inscription/etape1', 'Auth\RegisterStep1::index');
$routes->post('inscription/etape1', 'Auth\RegisterStep1::store');
$routes->get('inscription/etape2', 'Auth\RegisterStep2::index');
$routes->post('inscription/etape2', 'Auth\RegisterStep2::store');
$routes->get('connexion', 'Auth\LoginController::index');
$routes->post('connexion', 'Auth\LoginController::login');
$routes->post('deconnexion', 'Auth\LoginController::logout');
$routes->get($authGroups->hiddenLoginRoutes['admin'], 'Auth\LoginController::adminIndex');
$routes->post($authGroups->hiddenLoginRoutes['admin'], 'Auth\LoginController::adminLogin');
$routes->get($authGroups->hiddenLoginRoutes['coach'], 'Auth\LoginController::coachIndex');
$routes->post($authGroups->hiddenLoginRoutes['coach'], 'Auth\LoginController::coachLogin');
$routes->post('espace-securise/admin/sortie', 'Auth\LoginController::adminLogout');
$routes->post('espace-securise/coach/sortie', 'Auth\LoginController::coachLogout');

$routes->group('', ['filter' => 'auth'], static function (RouteCollection $routes): void {
    $routes->get('profil', 'Front\ProfilController::index');
    $routes->post('profil', 'Front\ProfilController::update');
    $routes->get('objectif', 'Front\RegimeController::objectif');
    $routes->post('objectif', 'Front\RegimeController::choisir');
    $routes->get('suggestions', 'Front\RegimeController::suggestions');
    $routes->post('souscrire', 'Front\RegimeController::souscrire');
    $routes->get('portefeuille', 'Front\PorteMonnaieController::index');
    $routes->post('ajax/code', 'Front\PorteMonnaieController::redeemCode');
    $routes->post('ajax/gold', 'Front\PorteMonnaieController::activateGold');
});

$routes->group('admin', ['filter' => 'admin'], static function (RouteCollection $routes): void {
    $routes->get('/', 'Admin\DashboardController::index');
    
    // Regimes
    $routes->get('regimes', 'Admin\RegimeAdminController::index');
    $routes->get('regimes/creer', 'Admin\RegimeAdminController::creer');
    $routes->post('regimes/store', 'Admin\RegimeAdminController::store');
    $routes->get('regimes/modifier/(:num)', 'Admin\RegimeAdminController::modifier/$1');
    $routes->post('regimes/update/(:num)', 'Admin\RegimeAdminController::update/$1');
    $routes->get('regimes/supprimer/(:num)', 'Admin\RegimeAdminController::supprimer/$1');
    
    // Activites
    $routes->get('activites', 'Admin\ActiviteAdminController::index');
    $routes->get('activites/creer', 'Admin\ActiviteAdminController::creer');
    $routes->post('activites/store', 'Admin\ActiviteAdminController::store');
    $routes->get('activites/modifier/(:num)', 'Admin\ActiviteAdminController::modifier/$1');
    $routes->post('activites/update/(:num)', 'Admin\ActiviteAdminController::update/$1');
    $routes->get('activites/supprimer/(:num)', 'Admin\ActiviteAdminController::supprimer/$1');
    
    // Codes
    $routes->get('codes', 'Admin\CodeAdminController::index');
    $routes->get('codes/creer', 'Admin\CodeAdminController::creer');
    $routes->post('codes/store', 'Admin\CodeAdminController::store');
    
    // Parametres
    $routes->get('parametres', 'Admin\ParametreController::index');
    $routes->post('parametres/update', 'Admin\ParametreController::update');
});

$routes->group('coach', ['filter' => 'coach'], static function (RouteCollection $routes): void {
    $routes->get('/', 'Coach\DashboardController::index');
});
