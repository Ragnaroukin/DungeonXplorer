<?php
require 'autoload.php';
require 'models/router.php';
// Instanciation du routeur
$router = new Router('DungeonXplorer');

// Ajout des routes
$router->addRoute('', 'HomeController@index'); // Pour la racine

// Appel de la méthode route
$router->route(trim($_SERVER['REQUEST_URI'], '/'));
?>