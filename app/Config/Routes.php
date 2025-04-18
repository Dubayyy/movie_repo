<?php
namespace Config;
use CodeIgniter\Router\RouteCollection;
// Create a new instance of our RouteCollection class.
$routes = Services::routes();
// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}
/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);
/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

//Route to test my database connection
$routes->get('test/database', 'Test::database');
$routes->get('auth/test_db', 'Auth::test_db');


// Home route
$routes->get('/', 'Home::index');

// Auth routes
$routes->get('auth/login', 'Auth::login');
$routes->post('auth/login', 'Auth::login');

$routes->get('auth/register', 'Auth::register');
$routes->post('auth/register', 'Auth::register');

$routes->get('auth/logout', 'Auth::logout');


// Movie routes
$routes->get('movies', 'Movies::index');
$routes->get('movies/view/(:num)', 'Movies::view/$1');
$routes->get('movies/search', 'Movies::search');
$routes->get('movies/now-playing', 'Movies::nowPlaying');

// Profile route
$routes->get('profile', 'Home::getProfile');


// Review routes
$routes->post('reviews/create/(:num)', 'Reviews::create/$1');
$routes->get('reviews/delete/(:num)', 'Reviews::delete/$1');

// Movie routes
$routes->get('movies', 'Movies::index');
$routes->get('movies/view/(:num)', 'Movies::view/$1');
$routes->get('movies/search', 'Movies::search');

// Watchlist routes
$routes->get('watchlist', 'Watchlist::index');
$routes->get('watchlist/add/(:num)', 'Watchlist::add/$1');
$routes->get('watchlist/remove/(:num)', 'Watchlist::remove/$1');

//search route
$routes->get('api/search', 'Api::search');

$routes->get('movies/ajax-search', 'Movies::ajaxSearch');

//ajax quick view
$routes->get('api/quick-view', 'Api::quickView');



/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}