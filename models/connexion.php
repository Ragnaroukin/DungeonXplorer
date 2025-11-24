<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=DungeonXplorer","solal", "so_pic13");
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}