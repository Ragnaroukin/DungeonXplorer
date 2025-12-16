<?php
class CombatController
{    
    public function startCombat()
    {
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
            FROM hero 
            WHERE hero_id = :hero_id');
        $queryHero->bindParam(":hero_id", $_SESSION["hero_id"], type: PDO::PARAM_STR);
        $queryHero->execute();
        
        $reponseHero = $queryHero->fetch();
        
        //Requete pour les class et les effets propre
        $queryClass = $pdo->prepare('SELECT class_name,class_image  ,class_base_pv ,class_base_mana  ,class_base_strength  ,class_base_initiative  
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
        $queryItem = $pdo->prepare('SELECT item_value FROM Items where item_id = :item_id');
        $queryItem->bindParam(":item_id", $reponseHero['hero_weapon_item_id'], type: PDO::PARAM_STR);
        $queryItem->execute();

        $tempItem = $queryItem->fetch(); 
        $reponseItem['weapon_value'] = $tempItem['item_value']; 

        //Bouclier
        $queryItem->bindParam(":item_id", $reponseHero['hero_shield_item_id'], type: PDO::PARAM_STR);
        $queryItem->execute();
        
        $tempItem = $queryItem->fetch(); 
        $reponseItem['shield_value'] =  $tempItem['item_value'];

        //Armure
        $queryItem->bindParam(":item_id", $reponseHero['hero_armor_item_id'], type: PDO::PARAM_STR);
        $queryItem->execute();
        
        $tempItem = $queryItem->fetch(); 
        $reponseItem['armor_value'] = $tempItem['item_value'];

        require_once 'views/combat.php';
    }
}
?>
