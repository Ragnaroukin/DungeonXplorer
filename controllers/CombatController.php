<?php
class CombatController
{
    public function startCombat()
    {
        if (empty($_SESSION["pseudo"]) || empty($_SESSION["hero"]) || empty($_SESSION["aventure"])) {
            require_once __DIR__ . "/../views/header.php";
            require_once __DIR__ . "/../views/404.php";
            require_once __DIR__ . "/../views/footer.php";
        } else {
            $pdo = Database::getConnection();

            //Requete pour le Monstre
            $queryMonstre = $pdo->prepare('SELECT monster_name,monster_image,monster_pv,monster_mana,monster_initiative,monster_strength,monster_attack,monster_spell,monster_xp 
                FROM Monster 
                WHERE monster_id = :monster_id');
            $queryMonstre->bindParam(":monster_id", $_POST["monster_id"], type: PDO::PARAM_STR);
            $queryMonstre->execute();

            $reponseMonstre = $queryMonstre->fetch();

            //Requete pour le Hero
            $queryHero = $pdo->prepare('SELECT hero_name ,class_id,hero_pv ,hero_mana ,hero_strength ,hero_initiative ,hero_level, hero_spell_list ,hero_xp, hero_armor_item_id,hero_weapon_item_id,hero_shield_item_id 
            FROM Hero 
            WHERE hero_id = :hero_id');
            $queryHero->bindParam(":hero_id", $_SESSION["hero"], type: PDO::PARAM_STR);
            $queryHero->execute();

            $reponseHero = $queryHero->fetch();

            //Requete pour les class et les effets propre
            $queryClass = $pdo->prepare('SELECT class_name,class_img  ,class_base_pv ,class_base_mana  ,class_base_strength  ,class_base_initiative  
            FROM Class 
            WHERE class_id  = :class_id');
            $queryClass->bindParam(":class_id", $reponseHero['class_id'], type: PDO::PARAM_STR);
            $queryClass->execute();

            $reponseClass = $queryClass->fetch();

            //Requete pour les level et les stats associer
            $queryLevel = $pdo->prepare('SELECT level_required_xp   ,level_pv_bonus  ,level_mana_bonus   ,level_strength_bonus   ,level_initiative_bonus   
            FROM Level 
            WHERE level_number = :level_number AND class_id = :class_id');
            $queryLevel->bindParam(":level_number", $reponseHero['hero_level'], type: PDO::PARAM_STR);
            $queryLevel->bindParam(":class_id", $reponseHero['class_id'], type: PDO::PARAM_STR);
            $queryLevel->execute();

            $reponseLevel = $queryLevel->fetch();

            //Requete pour les Objets du hero

            //Arme
            $sql = 'SELECT item_value FROM Items where item_id = :item_id';

            $queryItem = $pdo->prepare($sql);
            $queryItem->bindParam(":item_id", $reponseHero['hero_weapon_item_id']);
            $queryItem->execute();

            $tempItem = $queryItem->fetch();
            if ($tempItem === false) {
                $reponseItem['weapon_value'] = 0;
            } else {
                $reponseItem['weapon_value'] = $tempItem['item_value'];
            }

            //Bouclier
            $queryItem = $pdo->prepare($sql);
            $queryItem->bindParam(":item_id", $reponseHero['hero_shield_item_id']);
            $queryItem->execute();

            $tempItem = $queryItem->fetch();

            if ($tempItem === false) {
                $reponseItem['shield_value'] = 0;
            } else {
                $reponseItem['shield_value'] = $tempItem['item_value'];
            }
            //Armure
            $queryItem = $pdo->prepare($sql);
            $queryItem->bindParam(":item_id", $reponseHero['hero_armor_item_id']);
            $queryItem->execute();

            $tempItem = $queryItem->fetch();

            if ($tempItem === false) {
                $reponseItem['armor_value'] = 0;
            } else {
                $reponseItem['armor_value'] = $tempItem['item_value'];
            }

            require_once __DIR__ . "/../views/header.php";
            require_once __DIR__ . '/../views/combat.php';
            require_once __DIR__ . "/../views/footer.php";
        }
    }

    public function endFight($result)
    {
        if (empty($_SESSION["pseudo"]) || empty($_SESSION["hero"]) || empty($_SESSION["aventure"])) {
            require_once __DIR__ . "/../views/header.php";
            require_once __DIR__ . "/../views/404.php";
            require_once __DIR__ . "/../views/footer.php";
        } else {
            $pdo = Database::getConnection();

            if ($result == "win") {
                $req = $pdo->prepare("SELECT chapter_id, chapter_image, chapter_content, chapter_id_win as link_chapter_id, 'Victoire' as link_description 
                                                FROM Hero_Progress 
                                                JOIN Chapter USING (aventure_id, chapter_id) 
                                                LEFT JOIN Encounter USING (aventure_id, chapter_id)
                                        WHERE joueur_pseudo = :pseudo 
                                        and hero_id = :hero_id
                                        and aventure_id = :aventure_id");
                $req->bindParam(":pseudo", $_SESSION["pseudo"], type: PDO::PARAM_STR);
                $req->bindParam(":hero_id", $_SESSION["hero"], type: PDO::PARAM_STR);
                $req->bindParam(":aventure_id", $_SESSION["aventure"], type: PDO::PARAM_STR);
                $req->execute();

                $data = $req->fetchAll();

                $req = $pdo->prepare("SELECT monster_xp FROM Monster join Encounter USING (monster_id) WHERE chapter_id = :chapter");
                $req->bindParam(":chapter", $data[0]["chapter_id"]);
                $req->execute();

                $xp = ($req->fetch())["monster_xp"];

                $req = $pdo->prepare("SELECT hero_level, hero_pv, hero_mana, hero_strength, hero_initiative, hero_xp, level_required_xp, level_pv_bonus, level_strength_bonus, level_mana_bonus, level_initiative_bonus FROM Hero JOIN Level ON Hero.hero_level = Level.level_number AND Hero.class_id = Level.class_id WHERE Hero.hero_id = :hero");
                $req->bindParam(":hero", $_SESSION["hero"]);
                $req->execute();

                $stats = $req->fetch();

                if ($stats["level_required_xp"] < $stats["hero_xp"] + $xp) {
                    $xp = $stats["hero_xp"] + $xp - $stats["level_required_xp"];
                    $lvl = $stats["hero_level"] + 1;
                    $pv = $stats["hero_pv"] + $stats["level_pv_bonus"];
                    $pm = $stats["hero_mana"] + $stats["level_mana_bonus"];
                    $str = $stats["hero_strength"] + $stats["level_strength_bonus"];
                    $agi = $stats["hero_initiative"] + $stats["level_initiative_bonus"];

                    $req = $pdo->prepare($sql = "UPDATE `Hero` SET `hero_pv` = :pv, `hero_mana` = :pm, `hero_strength` = :str, `hero_initiative` = :agi, `hero_xp` = :xp, `hero_level` = :lvl WHERE `Hero`.`hero_id` = :hero AND `Hero`.`joueur_pseudo` = :pseudo");
                    $req->bindParam(":xp", $xp);
                    $req->bindParam(":lvl", $lvl);
                    $req->bindParam(":pv", $pv);
                    $req->bindParam(":pm", $pm);
                    $req->bindParam(":str", $str);
                    $req->bindParam(":agi", $agi);
                    $req->bindParam(":pseudo", $_SESSION["pseudo"]);
                    $req->bindParam(":hero", $_SESSION["hero"]);
                    $req->execute();

                } else {
                    $xp = $stats["hero_xp"] + $xp;
                    $req = $pdo->prepare($sql = "UPDATE `Hero` SET `hero_xp` = :xp WHERE `Hero`.`hero_id` = :hero AND `Hero`.`joueur_pseudo` = :pseudo");
                    $req->bindParam(":xp", $xp);
                    $req->bindParam(":pseudo", $_SESSION["pseudo"]);
                    $req->bindParam(":hero", $_SESSION["hero"]);
                    $req->execute();
                }
            } else {
                $req = $pdo->prepare("SELECT chapter_id, chapter_image, chapter_content, chapter_id_lose as link_chapter_id, 'Défaite' as link_description 
                                                FROM Hero_Progress 
                                                JOIN Chapter USING (aventure_id, chapter_id) 
                                                LEFT JOIN Encounter USING (aventure_id, chapter_id)
                                        WHERE joueur_pseudo = :pseudo 
                                        and hero_id = :hero_id
                                        and aventure_id = :aventure_id");
                $req->bindParam(":pseudo", $_SESSION["pseudo"], type: PDO::PARAM_STR);
                $req->bindParam(":hero_id", $_SESSION["hero"], type: PDO::PARAM_STR);
                $req->bindParam(":aventure_id", $_SESSION["aventure"], type: PDO::PARAM_STR);
                $req->execute();

                $data = $req->fetchAll();
            }

            require_once __DIR__ . "/../views/header.php";
            require_once __DIR__ . "/../views/chapter.php";
            require_once __DIR__ . "/../views/footer.php";
        }
    }
}
