<?php
//ob_start();
session_start();
//autoloader
require_once("includes/class-autoloader.inc.php");

//autoloader för classer
spl_autoload_register('class_autoloader');

//Konfigurationer
require_once("includes/db-settings.inc.php");

//Ansluta till en DB
require_once("includes/db-conn.inc.php");

//Ladda rätt controller
require_once("includes/routes.inc.php");

//inkludera fil med hjälpfunktioner
require_once("includes/functions.inc.php");

//inkludera fil med registreringklasser
require_once("includes/classes/Account.php");
require_once("includes/classes/Constants.php");

$account = new Account($dbh); /*calling an instance aka class. In this case we call the PDO to the Account class*/

//Om det finns någon getparameter controller, annars sätt till default.
$controller = $_GET['controller'] ??  "default";

//Om angiven controller inte finns i vår routes array, sätt till default.
if(!array_key_exists($controller,$routes)){
    $controller = 'default';
}
require_once("controllers/".$routes[$controller]);

