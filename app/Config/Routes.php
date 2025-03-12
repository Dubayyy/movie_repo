<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('/movies', 'MovieController::index'); // Show all movies
$routes->get('/movies/create', 'MovieController::create'); // Show form to add movie
$routes->post('/movies/store', 'MovieController::store'); // Save movie to DB
$routes->get('/movies/edit/(:num)', 'MovieController::edit/$1'); // Show edit form
$routes->post('/movies/update/(:num)', 'MovieController::update/$1'); // Update movie
$routes->get('/movies/delete/(:num)', 'MovieController::delete/$1'); // Delete movie
