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
$routes->get('deconnexion', 'Auth\LoginController::logout');
$routes->get($authGroups->hiddenLoginRoutes['admin'], 'Auth\LoginController::adminIndex');
$routes->post($authGroups->hiddenLoginRoutes['admin'], 'Auth\LoginController::adminLogin');
$routes->get($authGroups->hiddenLoginRoutes['coach'], 'Auth\LoginController::coachIndex');
$routes->post($authGroups->hiddenLoginRoutes['coach'], 'Auth\LoginController::coachLogin');
$routes->get('espace-securise/admin/sortie', 'Auth\LoginController::adminLogout');
$routes->get('espace-securise/coach/sortie', 'Auth\LoginController::coachLogout');

$routes->group('', ['filter' => 'auth'], static function (RouteCollection $routes): void {
    $routes->get('profil', 'Front\ProfilController::index');
    $routes->post('profil', 'Front\ProfilController::update');
    $routes->get('objectif', 'Front\RegimeController::objectif');
    $routes->post('objectif', 'Front\RegimeController::choisir');
    $routes->get('suggestions', 'Front\RegimeController::suggestions');
    $routes->get('portefeuille', 'Front\PorteMonnaieController::index');
});

$routes->group('admin', ['filter' => 'admin'], static function (RouteCollection $routes): void {
    $routes->get('/', 'Admin\DashboardController::index');
});

$routes->group('coach', ['filter' => 'coach'], static function (RouteCollection $routes): void {
    $routes->get('/', 'Coach\DashboardController::index');
});
