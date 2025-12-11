<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

$_SESSION["hero"] = 1; //temporaire
$_SESSION["aventure"] = 1; //temporaire

require 'autoload.php';
require 'models/Router.php';
require 'models/Database.php';

$pdo = Database::getConnection();

// Instanciation du routeur
$router = new Router('DungeonXplorer');

// Ajout des routes
$router->addRoute('', 'HomeController@index'); // Pour la racine
$router->addRoute('chapter', 'ChapterController@index'); // Pour les chapitres
$router->addRoute('avancement', 'ChapterController@avancement'); // Pour avancer dans l'histoire
$router->addRoute('admin', 'DashboardController@index'); // Pour la partie administrateur
$router->addRoute('login', 'CompteController@login');
$router->addRoute('signup', 'CompteController@signup');

// Appel de la méthode route
require_once "views/header.php";
$router->route(trim($_SERVER['REQUEST_URI'], '/'));
require_once "views/footer.php";
