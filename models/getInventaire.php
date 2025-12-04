<?php
require_once "models/connexion.php";
$id = $_SESSION["id"];
$req = $pdo->prepare("SELECT item_name, item_image, inventory_quantity FROM Inventory 
                            JOIN Items USING(item_id)
                            JOIN Hero USING(hero_id)
                            WHERE joueur_id = :id");
$req->bindParam(":id", $id, PDO::PARAM_INT);
$req->execute();
$items = $req->fetch(PDO::FETCH_ASSOC);

echo json_encode($items);