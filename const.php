<?php 
// Constantes disponibles en todo el programa
define("DATE", date('Y-m-d'));
define("DATETIME", date('Y-m-d H:i:s'));
define("BASEPATH", $_SERVER['DOCUMENT_ROOT']);
define("BASESELF", $_SERVER['PHP_SELF']);
define("ACTUALPAGE", basename($_SERVER['PHP_SELF']));

define('VIEW', '__view__');

// define("VERSION", "0.1.3");
define("VERSION", DATETIME);