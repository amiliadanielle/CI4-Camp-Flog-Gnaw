<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ✅ Default route → Landing page
$routes->get('/', 'Users::index');

// ✅ Landing & Auth Pages
$routes->get('landingPage', 'Users::index');
$routes->get('loginPage', 'Users::loginPage');
$routes->get('signupPage', 'Users::signupPage');
$routes->get('logout', 'Users::logout');

// ✅ User Dashboard & Pages
$routes->get('user', 'Users::index');
$routes->get('userLanding', 'UserLanding::index');
$routes->get('dashboard', 'Users::dashboard');
$routes->post('login', 'Users::login');

// ✅ Moodboard Page
$routes->get('moodboard', 'Users::moodboard');

// ✅ Roadmap Routes (clean + functional)
$routes->get('roadmap', 'Roadmap::index');
$routes->post('roadmap', 'Roadmap::index'); // handles create & update form submissions
$routes->get('roadmap/edit/(:any)', 'Roadmap::edit/$1'); // edit by ID
$routes->get('roadmap/delete/(:any)', 'Roadmap::delete/$1'); // delete by ID
