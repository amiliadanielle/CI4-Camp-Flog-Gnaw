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
