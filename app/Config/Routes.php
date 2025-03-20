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
// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
// Auth routes
$routes->get('auth/login', 'Auth::login');
$routes->get('auth/register', 'Auth::register');

// Movie routes
$routes->get('movies', 'Movies::index');
$routes->get('movies/view/(:num)', 'Movies::view/$1');
$routes->get('movies/search', 'Movies::search');
$routes->get('movies/now-playing', 'Movies::nowPlaying');

// Watchlist routes
$routes->get('watchlist', 'Watchlist::index');
$routes->get('watchlist/add/(:num)', 'Watchlist::add/$1');
$routes->get('watchlist/remove/(:num)', 'Watchlist::remove/$1');

// Review routes
$routes->post('reviews/create/(:num)', 'Reviews::create/$1');
$routes->get('reviews/delete/(:num)', 'Reviews::delete/$1');
/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}