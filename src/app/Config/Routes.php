<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Front\HomeController::index');

$routes->get('inscription/etape1', 'Auth\RegisterStep1::index');
$routes->post('inscription/etape1', 'Auth\RegisterStep1::store');
$routes->get('inscription/etape2', 'Auth\RegisterStep2::index');
$routes->post('inscription/etape2', 'Auth\RegisterStep2::store');
$routes->get('connexion', 'Auth\LoginController::index');
$routes->post('connexion', 'Auth\LoginController::login');
$routes->get('deconnexion', 'Auth\LoginController::logout');

$routes->group('', ['filter' => 'auth'], static function (RouteCollection $routes): void {
    $routes->get('profil', 'Front\ProfilController::index');
    $routes->post('profil', 'Front\ProfilController::update');
    $routes->get('objectif', 'Front\RegimeController::objectif');
    $routes->post('objectif', 'Front\RegimeController::choisir');
    $routes->get('suggestions', 'Front\RegimeController::suggestions');
    $routes->get('portefeuille', 'Front\PorteMonnaieController::index');
});
