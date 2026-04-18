<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('img/(:any)', 'Assets::image/$1');
$routes->get('/', 'Home::index');
$routes->get('/register', 'Home::register');
$routes->get('/login', 'Home::login');
