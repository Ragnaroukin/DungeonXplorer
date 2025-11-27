<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=DungeonXplorer", "root", "");
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

// Récup du formulaire
$name = $_POST['name'];
$pv = $_POST['pv'];
$mp = $_POST['mp'];
$str = $_POST['str'];
$ini = $_POST['ini'];
$maxItem = $_POST['maxItem'];
$description = $_POST['description'];

// Début de la transaction
$pdo->beginTransaction();

try {
    $sql = "INSERT INTO Class (
                class_name,
                class_description,
                class_base_pv,
                class_base_mana,
                class_base_strength,
                class_base_initiative,
                class_max_items
            ) VALUES (
                :name,
                :description,
                :pv,
                :mana,
                :strength,
                :initiative,
                :max_items
            )";

    $stmt = $pdo->prepare($sql);
    // Protection des params
    $stmt->execute([
        ':name' => $name,
        ':description' => $description,
        ':pv' => $pv,
        ':mana' => $mp,
        ':strength' => $str,
        ':initiative' => $ini,
        ':max_items' => $maxItem
    ]);

    // Récup de l'id
    $classId = $pdo->lastInsertId();

    // Traitement de l'image
    $imgPath = null;
    // On vérifie que le fichier est bon
    if (isset($_FILES['image1']) && $_FILES['image1']['error'] === UPLOAD_ERR_OK) {


        $tmpPath = $_FILES['image1']['tmp_name'];
        $originalName = $_FILES['image1']['name'];

        // On récup l'extension
        $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

        // On bloque les fichiers autres que les images
        $extensionsAutorisees = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        if (!in_array($extension, $extensionsAutorisees)) {
            throw new Exception("Extension d'image non autorisée.");
        }

        // On empêche les noms de fichiers dangereux
        $safeName = preg_replace('/[^a-zA-Z0-9_-]/', '_', $name);

        // On change pour le nom de l'image qui sera définitif
        $fileName = $safeName . $classId . "." . $extension;

        // On définit où enregistrer l'image
        $uploadDir = __DIR__ . "/../img/";
        // On définit le chemin enregistré dans la BDD
        $relativePath = "img/" . $fileName;

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }


        $destination = $uploadDir . $fileName;

        if (!move_uploaded_file($tmpPath, $destination)) {
            throw new Exception("Erreur lors de l'enregistrement de l'image.");
        }

        $imgPath = $relativePath;
    }

    if ($imgPath !== null) {
        $stmt = $pdo->prepare("UPDATE Class SET class_img = :img WHERE class_id = :id");
        $stmt->execute([
            ':img' => $imgPath,
            ':id' => $classId
        ]);
    }


    // On ajoute la seconde classe
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':name' => $name,
        ':description' => $description,
        ':pv' => $pv,
        ':mana' => $mp,
        ':strength' => $str,
        ':initiative' => $ini,
        ':max_items' => $maxItem
    ]);

    // Récup de l'id
    $classId = $pdo->lastInsertId();

    // Traitement de l'image
    $imgPath = null;
    // On vérifie que le fichier est bon
    if (isset($_FILES['image2']) && $_FILES['image2']['error'] === UPLOAD_ERR_OK) {


        $tmpPath = $_FILES['image2']['tmp_name'];
        $originalName = $_FILES['image2']['name'];

        // On récup l'extension
        $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

        // On bloque les fichiers autres que les images
        $extensionsAutorisees = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        if (!in_array($extension, $extensionsAutorisees)) {
            throw new Exception("Extension d'image non autorisée.");
        }

        // On empêche les noms de fichiers dangereux
        $safeName = preg_replace('/[^a-zA-Z0-9_-]/', '_', $name);

        // On change pour le nom de l'image qui sera définitif
        $fileName = $safeName . $classId . "." . $extension;

        // On définit où enregistrer l'image
        $uploadDir = __DIR__ . "/../img/";
        // On définit le chemin enregistré dans la BDD
        $relativePath = "img/" . $fileName;

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }


        $destination = $uploadDir . $fileName;

        if (!move_uploaded_file($tmpPath, $destination)) {
            throw new Exception("Erreur lors de l'enregistrement de l'image.");
        }

        $imgPath = $relativePath;
    }

    if ($imgPath !== null) {
        $stmt = $pdo->prepare("UPDATE Class SET class_img = :img WHERE class_id = :id");
        $stmt->execute([
            ':img' => $imgPath,
            ':id' => $classId
        ]);
    }

    // Aucune erreur on enregistre
    $pdo->commit();

    header("Location: /DungeonXplorer/admin/");

} catch (Exception $e) {
    $pdo->rollBack();
    echo "Erreur : " . $e->getMessage();
}
