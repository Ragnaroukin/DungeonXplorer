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
function url(string $path = ''): string
{
    // On retire le dernier / de BASE_URL et le premier de path puis on en concatène un entre les deux
    // Cela permet de passer path soit en "chemin", soit en "/chemin" sans provoquer d'erreur
    return rtrim(BASE_URL, '/') . '/' . ltrim($path, '/');
}


require __DIR__ . '/autoload.php';
require __DIR__ . '/models/Router.php';
require __DIR__ . '/models/Database.php';

// Récupération de la base de donnée
$pdo = Database::getConnection();

// Instanciation du routeur
$router = new Router('DungeonXplorer');

// Ajout des routes
$router->addRoute('', 'HomeController@index'); // Pour la racine
$router->addRoute('connexion', 'CompteController@index');
$router->addRoute('inscription', 'CompteController@index');

/*
 * Partie administrateur
 */
$router->addRoute('admin', 'DashboardController@index');
$router->addRoute('admin/profile', 'DashboardController@viewProfile');
$router->addRoute('admin/profile/delete', 'DashboardController@deleteProfile');
$router->addRoute('admin/profile/heroes', 'DashboardController@viewHeroes');

/*
 * Gestion de l'aventure
 */

$router->addRoute('game/start', 'GameController@start'); // Nouvelle aventure ou continuer
// Création d'une nouvelle partie
$router->addRoute('game/create/class', 'CreateController@classChoice'); // Choix de la classe 
$router->addRoute('game/create/hero', 'CreateController@heroDetail'); // Choix du nom
$router->addRoute('game/create/creating', 'CreateController@create'); // Gestion de la création
// Reprendre une partie
$router->addRoute('game/load', 'GameController@load'); // Choix du héros
$router->addRoute('game/loading', 'GameController@loading'); // Choix du héros
// Gestion des chapitres
$router->addRoute('game/chapter', 'ChapterController@index'); // Pour les chapitres
$router->addRoute('game/progress', 'ChapterController@progress'); // Pour avancer dans l'histoire
// Gestion des combats
$router->addRoute('game/chapter/fight', 'CombatController@startCombat');
$router->addRoute('game/chapter/fight/end/{result}', 'CombatController@endFight');
//Statistiques du héros courant
$router->addRoute("game/stats", "StatsController@gather");

/*
 *Profil
 */
$router->addRoute('profile', 'ProfileController@show');
// Modifier
$router->addRoute('profile/modify', 'ProfileController@modify');
$router->addRoute('profile/modifying', 'ProfileController@modifying');
// Déconnexion
$router->addRoute('profile/disconnect', 'ProfileController@disconnect');
// Suppression
$router->addRoute('profile/delete', 'ProfileController@delete');
// Liste des héros
$router->addRoute('profile/heroes', 'ProfileController@heroes');

// Appel de la méthode route
$router->route(trim($_SERVER['REQUEST_URI'], '/'));
