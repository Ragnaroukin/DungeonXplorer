<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Création de Personnage</title>
    <link rel="stylesheet" href="../../styles/styleCreaPerso.css">
</head>
<body class="classSelectBackground">
    <form action="" method="post"  class="heroForm">
        Nom : <input type="text" name="name" id="name">
        Biographie : <textarea name="bio" id="bio"></textarea>
        <button type="submit">Valider la création du personnage</button>
    </form>
</body>
</html>

<?php
    $class_id = $_GET['class_id'];
    echo($class_id);

    session_start();
    //$_SESSION['user_id'] = 1;

    function createHero(int $heroType) {
    $dsn = "mysql:host=127.0.0.1;port=3306;dbname=dungeonxplorer;charset=utf8mb4";
    $pdo = new PDO($dsn, "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $user_id = ($_SESSION['user_id']);
    $name = trim($_POST['name'] ?? '');
    $bio  = trim($_POST['bio'] ?? '');

    if ($name === '') {
        throw new Exception('Le nom du héros est requis.');
    }

    // map heroType -> class_id et image
    switch ($heroType) {
        case 1:
            $classId = 2; break;
        case 2:
            $classId = 3; break;
        default:
            $classId = 1; break;
    }

    // récupérer stats de la classe
    $stmt = $pdo->prepare('SELECT class_base_pv AS pv, class_base_mana AS mana, class_base_strength AS strength, class_base_initiative AS initiative FROM class WHERE class_id = :cid');
    $stmt->execute([':cid' => $classId]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $pv = (int)($row['pv'] ?? 0);
    $mana = (int)($row['mana'] ?? 0);
    $strength = (int)($row['strength'] ?? 0);
    $initiative = (int)($row['initiative'] ?? 0);

    // next hero id (si la colonne n'est pas AUTO_INCREMENT)
    $row = $pdo->query('SELECT COALESCE(MAX(hero_id),0) + 1 AS next_id FROM hero')->fetch(PDO::FETCH_ASSOC);
    $hero_id = (int)$row['next_id'];

    // insertion sécurisée (colonnes explicites + paramètres nommés)
    $sql = 'INSERT INTO hero (hero_id, joueur_id, hero_name, class_id, hero_biography, hero_pv, hero_mana, hero_strength, hero_initiative, hero_armor_item_id, hero_primary_weapon_item_id, hero_secondary_weapon_item_id, hero_shield_item_id, hero_spell_list, hero_xp, hero_level)
            VALUES (:hero_id, :joueur_id, :hero_name, :class_id, :hero_bio, :pv, :mana, :strength, :initiative, NULL, NULL, NULL, NULL, "Foudre - 20", 0, 1)';

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':hero_id'   => $hero_id,
        ':joueur_id' => $user_id,
        ':hero_name' => $name,
        ':class_id'  => $classId,
        ':hero_bio'  => $bio,
        ':pv'        => $pv,
        ':mana'      => $mana,
        ':strength'  => $strength,
        ':initiative'=> $initiative
    ]);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $bio = trim($_POST['bio'] ?? '');
    
    // récupère la classe depuis la session si disponible, sinon depuis le POST
    createHero($class_id);
}

?>