<?php
session_start();
ob_start();
date_default_timezone_set('America/Mexico_City');
setlocale(LC_TIME, 'es_ES.UTF-8');

require_once "commons.php";
$router = new \Bramus\Router\Router();
use ControllersNS\PagesController;

$router->setNamespace('ControllersNS');

PagesController::headerLayout();
PagesController::menuLayout();

$router->get('/', 'PagesController@home');
$router->get('/home', 'PagesController@home');
$router->get('/session', 'PagesController@session');
$router->get('/login', 'PagesController@login');
$router->get('/logout', 'PagesController@logout');
$router->get('/register', 'PagesController@register');

$router->set404('PagesController@error404');

$router->run();

PagesController::footerLayout();

ob_end_flush();