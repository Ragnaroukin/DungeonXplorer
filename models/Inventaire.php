<?php

class Inventaire
{
    public static function getItems() {
        $pdo = Database::getConnection();
        $pseudo = $_SESSION["pseudo"];
        $hero = $_SESSION["hero"];
        $req = $pdo->prepare("SELECT item_name, item_image, inventory_quantity FROM Inventory 
                                    JOIN Items USING(item_id)
                                    JOIN Hero USING(hero_id)
                                    WHERE Hero.joueur_pseudo = :pseudo
                                    AND Hero.hero_id = :hero");
        $req->bindParam(":pseudo", $pseudo, PDO::PARAM_STR);
        $req->bindParam(":hero", $hero, PDO::PARAM_STR);
        $req->execute();
        $items = $req->fetchAll(PDO::FETCH_ASSOC);
        return $items;
    }
}