<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ----------------- Default Route -----------------
$routes->get('/', 'Users::index');  // Landing page

// ----------------- Landing & Auth Pages -----------------
$routes->get('landingPage', 'Users::index');         // Landing page
$routes->get('loginPage', 'Users::loginPage');      // Show login form
$routes->get('signupPage', 'Users::signupPage');    // Show signup form
$routes->post('login', 'Users::login');             // Handle login form POST
$routes->get('logout', 'Users::logout');            // Logout

// ----------------- Dashboard -----------------
$routes->get('dashboard', 'Users::dashboard');      // Admin dashboard

// ----------------- Moodboard -----------------
$routes->get('moodboard', 'Users::moodboard');

// ----------------- Admin CRUD (Booths, Singers, Tickets) -----------------
$routes->get('admin/booths', 'Admin::booths');
$routes->get('admin/boothCreate', 'Admin::boothCreate');
$routes->get('admin/boothEdit/(:num)', 'Admin::boothEdit/$1');
$routes->post('admin/boothSave', 'Admin::boothSave');
$routes->get('admin/boothDelete/(:num)', 'Admin::boothDelete/$1');

$routes->get('admin/singers', 'Admin::singers');
$routes->get('admin/singerCreate', 'Admin::singerCreate');
$routes->get('admin/singerEdit/(:num)', 'Admin::singerEdit/$1');
$routes->post('admin/singerSave', 'Admin::singerSave');
$routes->get('admin/singerDelete/(:num)', 'Admin::singerDelete/$1');

$routes->get('admin/tickets', 'Admin::tickets');
$routes->get('admin/ticketCreate', 'Admin::ticketCreate');
$routes->get('admin/ticketEdit/(:num)', 'Admin::ticketEdit/$1');
$routes->post('admin/ticketSave', 'Admin::ticketSave');
$routes->get('admin/ticketDelete/(:num)', 'Admin::ticketDelete/$1');

// ----------------- Optional: Default landing for /users -----------------
$routes->get('users', 'Users::index');                  
$routes->get('users/dashboard', 'User::dashboard');    

$routes->post('login', 'Users::loginPage');             // Handle login form POST

$routes->get('signupPage', 'Users::signupPage'); // To show the signup page
$routes->post('signup', 'Users::signup');       // To handle the form POST

// admin ajax create/save endpoints
$routes->post('admin/boothSave', 'Admin::boothSave');
$routes->post('admin/singerSave', 'Admin::singerSave');
$routes->post('admin/ticketSave', 'Admin::ticketSave');

// json listing endpoints used by dashboard manage modal
$routes->get('admin/boothsJson', 'Admin::boothsJson');
$routes->get('admin/singersJson', 'Admin::singersJson');
$routes->get('admin/ticketsJson', 'Admin::ticketsJson');

// existing admin pages (if not already present)
$routes->get('admin', 'Admin::index');
$routes->get('admin/booths', 'Admin::booths');
$routes->get('admin/singers', 'Admin::singers');
$routes->get('admin/tickets', 'Admin::tickets');

$routes->get('account', 'AccountController::index', ['filter' => 'auth']);
$routes->post('account/save', 'AccountController::save', ['filter' => 'auth']);
$routes->post('account/save', 'Account::save');






