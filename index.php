<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require 'autoload.php';
require 'models/router.php';
// Instanciation du routeur

$router = new Router('DungeonXplorer');

// Ajout des routes
$router->addRoute('', 'HomeController@index'); // Pour la racine
$router->addRoute('admin', 'DashboardController@index'); // Pour la partie administrateur
//$router->addRoute('admin/add/model', 'FormController@index'); // Pour le modèle de formulaire
$router->addRoute('admin/add/{type}', 'FormController@choose'); // Pour les différents formulaires d'ajout

// Appel de la méthode route
$router->route(trim($_SERVER['REQUEST_URI'], '/'));