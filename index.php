<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

//Définition automatique de la racine du projet
$scriptName = str_replace('\\', '/', $_SERVER['SCRIPT_NAME']);
$basePath = rtrim(dirname($scriptName), '/');
define('BASE_URL', $basePath === '' ? '/' : $basePath);

// Fonction pour créer des liens à partir de la racine
function url(string $path = ''): string {
    // On retire le dernier / de BASE_URL et le premier de path puis on en concatène un entre les deux
    // Cela permet de passer path soit en "chemin", soit en "/chemin" sans provoquer d'erreur
    return rtrim(BASE_URL, '/') . '/' . ltrim($path, '/');
}


require __DIR__.'/autoload.php';
require __DIR__.'/models/Router.php';
require __DIR__.'/models/Database.php';

// Récupération de la base de donnée
$pdo = Database::getConnection();

// Instanciation du routeur
$router = new Router('DungeonXplorer');

// Ajout des routes
$router->addRoute('', 'HomeController@index'); // Pour la racine
$router->addRoute('login', 'CompteController@login');
$router->addRoute('signup', 'CompteController@signup');
$router->addRoute('inventaire', 'InventaireController@show');
$router->addRoute('getInventaire', 'InventaireController@get');
$router->addRoute('profile', 'ProfileController@show');
$router->addRoute('chapter', 'ChapterController@index'); // Pour les chapitres
$router->addRoute('avancement', 'ChapterController@avancement'); // Pour avancer dans l'histoire
$router->addRoute('admin', 'DashboardController@index'); // Pour la partie administrateur
$router->addRoute('login', 'CompteController@login');
$router->addRoute('signup', 'CompteController@signup');
$router->addRoute('create/class', 'CreateController@classChoice');
$router->addRoute('create/hero', 'CreateController@heroDetail');
$router->addRoute('create/creating', 'CreateController@create');


// Appel de la méthode route
require_once __DIR__."/views/header.php";
$router->route(trim($_SERVER['REQUEST_URI'], '/'));
require_once __DIR__."/views/footer.php";
