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

// --- Authentication pages (show forms) ---
$routes->get('loginPage', 'LoginController::index');    // GET /loginPage -> show login form
$routes->get('loginPage', 'LoginController::index');
$routes->get('signupPage', 'Auth::signupPage');        // GET /signupPage -> show signup form

// --- Authentication actions (form submissions) ---
$routes->post('login', 'LoginController::authenticate'); // POST /login -> process login
$routes->get('loginPage', 'LoginController::index');
$routes->match(['get','post'], 'logout', 'LoginController::logout');
$routes->post('signup', 'Auth::signup');                // POST /signup -> process signup

// --- Logout (accept GET or POST) ---
$routes->match(['get', 'post'], 'logout', 'LoginController::logout');

// --- Quick placeholders for testing redirects (remove when real controllers exist) ---
$routes->get('dashboard', function(){ echo 'User dashboard'; });
$routes->get('admin/dashboard', function(){ echo 'Admin dashboard'; });

$routes->get('landing', 'Home::landing'); // or a closure/view






