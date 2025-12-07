<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=DungeonXplorer","root", "");
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}