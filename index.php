<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require 'autoload.php';
require 'models/router.php';

// Instanciation du routeur
$router = new Router('DungeonXplorer');

// Ajout des routes
$router->addRoute('', 'HomeController@index'); // Pour la racine
$router->addRoute('admin', 'DashboardController@index'); // Pour la partie administrateur
$router->addRoute('login', 'CompteController@login');
$router->addRoute('signup', 'CompteController@signup');

// Appel de la méthode route
require_once "views/header.php";
$router->route(trim($_SERVER['REQUEST_URI'], '/'));
require_once "views/footer.php";
?>
