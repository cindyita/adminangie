<?php 
session_start();
ob_start();
require 'vendor/autoload.php';
//Cargar variables de entorno
use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();
$appENV = $_ENV['APP_ENV'] ?? "production";

if($appENV == 'local' || $_SESSION['MYSESSION']['company']['db_type'] == "0"){
    $dotenv = Dotenv::createMutable(__DIR__,'.env.local');
    $dotenv->load();
}
require_once 'const.php';
require_once 'src/resources/functions.php';
require_once 'src/resources/html.php';
require_once 'src/resources/emails.php';
