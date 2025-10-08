<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Default route → landing page
$routes->get('/', 'Users::index');

// Landing page route (optional alias)
$routes->get('landingPage', 'Users::index');

// Login page route
$routes->get('loginPage', 'Users::loginPage');

// Example route for users section
$routes->get('user', 'Users::index');

$routes->get('signupPage', 'Users::signupPage'); // ✅ Added route
$routes->get('userLanding', 'UserLanding::index'); // Protected user landing page
$routes->get('dashboard', 'Users::dashboard'); // loads dashboard view
$routes->post('login', 'Users::login'); // 🔹 Handles POST from form
$routes->get('logout', 'Users::logout');

$routes->get('moodboard', 'Users::moodboard');

$routes->get('roadmap', 'Roadmap::index');
$routes->get('roadmap/create', 'Roadmap::create');
$routes->post('roadmap/store', 'Roadmap::store');
$routes->get('roadmap/edit/(:num)', 'Roadmap::edit/$1');
$routes->post('roadmap/update/(:num)', 'Roadmap::update/$1');
$routes->get('roadmap/delete/(:num)', 'Roadmap::delete/$1');
$routes->match(['get', 'post'], 'roadmap', 'Roadmap::index');







