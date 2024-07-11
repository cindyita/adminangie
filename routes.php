<?php

date_default_timezone_set('America/Mexico_City');
setlocale(LC_TIME, 'es_ES.UTF-8');

require_once "commons.php";
$router = new \Bramus\Router\Router();
use ControllersNS\PagesController;

$router->setNamespace('ControllersNS');

PagesController::headerLayout();

$router->get('/', 'PagesController@home');
$router->get('/home', 'PagesController@home');
$router->get('/users', 'PagesController@users');
$router->get('/orders', 'PagesController@orders');
$router->get('/sales', 'PagesController@sales');
$router->get('/products', 'PagesController@products');
$router->get('/services', 'PagesController@services');
$router->get('/inventory', 'PagesController@inventory');
$router->get('/categories', 'PagesController@categories');
$router->get('/contacts', 'PagesController@contacts');
$router->get('/settings', 'PagesController@settings');


$router->get('/login', 'PagesController@login');
$router->get('/logout', 'PagesController@logout');
$router->get('/register', 'PagesController@register');

$router->get('/unauth', 'PagesController@unAuth');

$router->set404('PagesController@error404');

$router->run();

PagesController::footerLayout();

ob_end_flush();