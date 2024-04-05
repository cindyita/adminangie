<?php 
require 'vendor/autoload.php';
//Cargar variables de entorno
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
require_once 'const.php';
require_once 'src/resources/functions.php';
require_once 'src/resources/emails.php';
