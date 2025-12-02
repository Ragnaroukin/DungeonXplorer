<?php 
require_once("views/header.php");
?>


<?php
        //Requete pour le Monstre
        $queryMonstre = $bdd->prepare('SELECT monster_name,monster_image,monster_pv,monster_mana,monster_initiative,monster_strength,monster_attack,monster_xp FROM Monster where monster_id = ?');
        $queryMonstre->execute(array(1)); // Modifier les valeur avec les paramètre qui seront donnée
        $reponseMonstre = $queryMonstre->fetch();
        
        //Requete pour le Hero
        $queryHero = $bdd->prepare('SELECT hero_name ,class_id,hero_pv ,hero_mana ,hero_strength ,hero_initiative ,hero_level ,hero_xp, hero_armor_item_id,hero_weapon_item_id,hero_shield_item_id FROM hero where hero_id = ?');
        $queryHero->execute(array(1)); // Modifier les valeur avec les paramètre qui seront donnée
        $reponseHero = $queryHero->fetch();
        
        //Requete pour les class et les effets propre
        $queryClass = $bdd->prepare('SELECT class_name,class_image  ,class_base_pv ,class_base_mana  ,class_base_strength  ,class_base_initiative  FROM Class where class_id  = ?');
        $queryClass->execute(array($reponseHero['class_id']));
        $reponseClass = $queryClass->fetch();
        
        //Requete pour les level et les stats associer
        $queryLevel = $bdd->prepare('SELECT level_required_xp   ,level_pv_bonus  ,level_mana_bonus   ,level_strength_bonus   ,level_initiative_bonus   FROM level where level_number  = ? and class_id = ?');
        $queryLevel->execute(array($reponseHero['hero_level'],$reponseHero['class_id']));
        $reponseLevel = $queryLevel->fetch();

        //Preparation de la requete qui sera appeler a la fin du combat
        //$queryLink = $bdd->prepare('SELECT link_aventure_id   ,link_chapter_id  FROM Links where aventure_id  = ? and chapter_id = ? and link_choice = ?');

        //Requete pour les Objets du hero
        $queryItem = $bdd->prepare('SELECT item_value FROM Items where item_id = ?');
        $queryItem->execute(array($reponseHero['hero_weapon_item_id']));
        $tempItem = $queryItem->fetch();  
        $reponseItem['weapon_value'] = $tempItem['item_value']; 
        $queryItem->execute(array($reponseHero['hero_shield_item_id']));
        $tempItem = $queryItem->fetch(); 
        $reponseItem['shield_value'] =  $tempItem['item_value'];
        $queryItem->execute(array($reponseHero['hero_armor_item_id']));
        $tempItem = $queryItem->fetch(); 
        $reponseItem['armor_value'] = $tempItem['item_value'];


        function parserManaCost($spell) {
            $pos = strpos($spell, '-');
            echo intval(substr( $spell,strpos($spell, '-') + 1)); 
            if ($pos == false) {
                return false;
            } else {
                return intval(substr( $spell,$pos + 1));
            }
        }

        // Definie si le monstre est capable d'utiliser des capaciter magiques
        $magical_monster = false;
        if ($reponseMonstre['monster_spell'] != null) {
                $magical_monster = true;
        }

        //Calcule de l'intiative
        $initiative_hero = rand(1, 6) + $reponseHero['hero_initiative'];
        $initiative_monstre = rand(1, 6) + $reponseMonstre['monster_initiative'];

        //Tour du monstre si le monstre a l'initiative
        if($initiative_hero < $initiative_monstre || ($initiative_hero = $initiative_monstre && $reponseHero['class_id'] != 2) ) {
            if ($magical_monster == true) {
                $magical_mana_cost = parserManaCost('Magie générique - 5');
                if ($reponseMonstre['monster_mana'] - $magical_mana_cost >= 0) {
                    $reponseMonstre['monster_mana'] -= $magical_mana_cost;
                    $attaque = rand(1,6) + rand(1,6) + $magical_mana_cost;
                } else { //Fait une attaque physique si il n'a pas assez de mana.
                    $attaque = rand(1,6) +  $reponseMonstre['monster_strength'];
                }
            } else {
                $attaque = rand(1,6) +  $reponseMonstre['monster_strength'];
            }
            $defense = (int) rand(1,6) + (int) ($reponseHero['hero_strength']/2) + $reponseItem['shield_value'] + $reponseItem['armor_value'];
            $degat = max(0, $attaque - $defense);
            $reponseHero['hero_pv'] -= $degat;

            //Verification de la victoire du Monstre

            if ($reponseHero['hero_pv'] <= 0) {
                //A faire
                //$queryLink->execute(array(1,1,1));
                //$reponseLink = $queryLink->fetch();
            }
        }
?>

<!-- Affichage Monstre -->
<img src= "<?php  $reponseMonstre['monster_image']  ?>" alt="image_monstre">
<h3><?php  echo $reponseMonstre['monster_name']; ?></h3>
<p> <?php  echo $reponseMonstre['monster_pv']; ?> PV |
    <?php  echo $reponseMonstre['monster_mana']; ?> Mana |
    <?php  echo $reponseMonstre['monster_strength']; ?> Force 
</p>

<!-- Affichage Hero -->
<img src= "<?php $reponseClass['class_image']  ?>" alt="image_hero">
<h3><?php echo $reponseHero['hero_name']; ?></h3>
<p> 
    <?php echo $reponseHero['hero_pv']; ?> / <?php echo $reponseClass['class_base_pv'] + $reponseLevel['level_pv_bonus']; ?> PV |
    <?php echo $reponseHero['hero_mana']; ?> / <?php echo $reponseClass['class_base_mana'] + $reponseLevel['level_mana_bonus']; ?> Mana |
    <?php echo $reponseHero['hero_initiative']; ?> / <?php echo $reponseClass['class_base_initiative'] + $reponseLevel['level_initiative_bonus']; ?> Initiative |
    <?php echo $reponseHero['hero_strength']; ?> / <?php echo $reponseClass['class_base_strength'] + $reponseLevel['level_strength_bonus']; ?> Force |
    Level : <?php echo $reponseHero['hero_level']; ?> (<?php echo $reponseHero['hero_xp'] ?>/<?php echo  $reponseLevel['level_required_xp']?> <!-- Xp requis n'est pas forcement celui du suivant ! revoir quand la base est bien définis -->)
</p> 

<!-- Choix du Joueur -->
<form action="" method="post"> 
    <input type="radio" name="choice" value="physical"> Attaque physique
    <input type="radio" name="choice" value="magical"> Attaque Magique
    <input type="radio" name="choice" value="health_potion"> Boire une potion de vie
    <input type="radio" name="choice" value="mana_potion"> Boire une potion de mana
    <hr/>
    <input type="submit" name="combattre">
</form>

<!-- Le guerrier est 0, Le mage est 1 ,Le voleur possède l'id 2 -->
<?php
        if(isset($_POST['choice'])) {
            $choice = $_POST['choice'];
        
            //Tour du joueur

            switch($choice) { 
                    case "physical" :
                        $attaque = rand(1,6) + $reponseHero['hero_strength'] + $reponseItem['weapon_value'];
                        $defense = rand(1,6) + (int) ($reponseMonstre['monster_strength']/2);  //Le monstre n'a pas d'armure
                        $reponseMonstre['monster_pv'] -= $degat;
                        break;
                    case "magical" :
                        if ($reponseHero['class_id'] == 1) {
                            $magical_mana_cost = parserManaCost($reponseHero['hero_spell_list']);
                            if ($reponseHero['hero_mana'] - $magical_mana_cost >= 0) {
                                $reponseHero['hero_mana'] -= $magical_mana_cost;
                                $attaque = rand(1,6) + rand(1,6) + $magical_mana_cost;
                                $defense = rand(1,6) + (int) ($reponseMonstre['monster_strength']/2); //Le monstre n'a pas d'armure
                                $degat = max(0, $attaque - $defense);
                                $reponseMonstre['monster_pv'] -= $degat;
                            } else {
                                echo "Vous n'avez pas assez de mana !";
                            }
                        } else {
                            echo "Vous n'êtes pas un mage !";
                        }
                        break;
                    case "health_potion" :
                        //Ne verifie pas si il y a des potions dans l'inventaire et leur valeur
                        if ($reponseHero['hero_pv'] + 10 > $reponseClass['class_base_pv'] + $reponseLevel['level_pv_bonus'] ) {
                            $reponseHero['hero_pv'] = $reponseClass['class_base_pv'] + $reponseLevel['level_pv_bonus'];
                        } else {
                            $reponseHero['hero_pv'] += 10;
                        }
                        break;
                    case "mana_potion" :
                        //Ne verifie pas si il y a des potions dans l'inventaire et leur valeur
                        if ($reponseHero['hero_mana'] + 10 > $reponseClass['class_base_mana'] + $reponseLevel['level_mana_bonus'] ) { 
                            $reponseHero['hero_mana'] = $reponseClass['class_base_mana'] + $reponseLevel['level_mana_bonus'];
                        } else {
                            $reponseHero['hero_mana'] += 10;
                        }
                        break;
                }
            
                //Verification de la victoire du joueur

                if ($reponseMonstre['monster_pv'] <= 0) {
                    //A faire
                    //$queryLink->execute(array(1,1,1));
                    //$reponseLink = $queryLink->fetch();
                }

                // Tours du monstre

                if ($magical_monster == true) {
                    $magical_mana_cost = parserManaCost('Magie générique - 5');
                    if ($reponseMonstre['monster_mana'] - $magical_mana_cost >= 0) {
                        $reponseMonstre['monster_mana'] -= $magical_mana_cost;
                        $attaque = rand(1,6) + rand(1,6) + $magical_mana_cost;
                    } else { //Fait une attaque physique si il n'a pas assez de mana.
                        $attaque = rand(1,6) +  $reponseMonstre['monster_strength'];
                    }
                } else {
                    $attaque = rand(1,6) +  $reponseMonstre['monster_strength']; 
                }
                $defense = rand(1,6) + (int) ($reponseHero['hero_strength']/2)  + $reponseItem['shield_value'] + $reponseItem['armor_value'];
                $degat = max(0, $attaque - $defense);
                $reponseHero['hero_pv'] -= $degat;

                //Verification de la victoire du Monstre

                if ($reponseHero['hero_pv'] <= 0) {
                    //A faire
                    //$queryLink->execute(array(1,1,1));
                    //$reponseLink = $queryLink->fetch();
                }
            
        } else {
            echo "Choisissez une action";
        }
    
    
?>

<?php
require_once("views/footer.php");
?>