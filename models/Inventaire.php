<?php

class Inventaire
{
    public static function getItems() {
        $pdo = Database::getConnection();
        $pseudo = $_SESSION["pseudo"];
        $hero = $_SESSION["hero"];
        $req = $pdo->prepare("SELECT item_name, item_image, inventory_quantity FROM Inventory 
                                    JOIN Items USING(item_id)
                                    JOIN Hero USING(joueur_pseudo, hero_id)
                                    WHERE joueur_pseudo = :pseudo
                                    AND hero_id = :hero");
        $req->bindParam(":pseudo", $pseudo, PDO::PARAM_STR);
        $req->bindParam(":hero", $hero, PDO::PARAM_STR);
        $req->execute();
        $items = $req->fetchAll(PDO::FETCH_ASSOC);
        return $items;
    }

    public static function addItem($item, $quantity){
        $pdo = Database::getConnection();
        $pseudo = $_SESSION["pseudo"];
        $hero = $_SESSION["hero"];
        $req = $pdo->prepare("INSERT INTO Inventory VALUES(:pseudo, :hero, :item, :quantity)");
        $req->bindParam(":pseudo", $pseudo, PDO::PARAM_STR);
        $req->bindParam(":hero", $hero, PDO::PARAM_STR);
        $req->bindParam(":item", $item, PDO::PARAM_INT);
        $req->bindParam(":quantity", $quantity, PDO::PARAM_INT);
        $req->execute();
    }
}