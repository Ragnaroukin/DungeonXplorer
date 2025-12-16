<?php

class StatistiquesController
{
    public function gather() {
        $pdo = Database::getConnection();
        $req = $pdo->prepare("SELECT hero_name, hero_biography, hero_pv, hero_mana, hero_strength, class_img, class_name, hero_spell_list FROM Hero
                                     JOIN Class USING(class_id)
                                     WHERE hero_id = :hero 
                                     AND joueur_pseudo = :pseudo");
        $req->bindParam(":hero", $_SESSION["hero"], PDO::PARAM_STR);
        $req->bindParam(":pseudo", $_SESSION["pseudo"], PDO::PARAM_STR);
        $req->execute();
        $stats = $req->fetch(PDO::FETCH_ASSOC);
        require_once "views/statistiques.php";
    }
}