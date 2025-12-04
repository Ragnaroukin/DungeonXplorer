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
$router->addRoute('login', 'CompteController@login');
$router->addRoute('signup', 'CompteController@signup');
$router->addRoute('inventaire', 'InventaireController@show');
$router->addRoute('getInventaire', 'InventaireController@get');


// Appel de la méthode route
$router->route(trim($_SERVER['REQUEST_URI'], '/'));
?>