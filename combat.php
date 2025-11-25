<?php 
require_once("views/header.php");
?>

<?php
    $reponseMonstre = $bdd->prepare('SELECT monster_name,monster_image,monster_pv,monster_mana,monster_initiative,monster_strength,monster_attack,monster_xp FROM Monster where monster_id = ?');
    $reponseMonstre->execute(array($_POST['monster_id']));

    $reponseHero = $bdd->prepare('SELECT hero_name ,class_id,hero_image,hero_pv ,hero_mana ,hero_strength ,hero_initiative ,hero_level ,hero_xp  FROM hero where hero_id = ?');
    $reponseHero->execute(array($_POST['hero_id']));

    $reponseClass = $bdd->prepare('SELECT class_name  ,class_base_pv ,class_base_mana  ,class_base_strength  ,class_base_initiative  FROM Class where class_id  = ?');
    $reponseClass->execute(array($reponseHero['class_id']));

    $reponseLevel = $bdd->prepare('SELECT level_required_xp   ,level_pv_bonus  ,level_mana_bonus   ,level_strength_bonus   ,level_initiative_bonus   FROM level where level_number  = ? and class_id = ?');
    $reponseLevel->execute(array($reponseHero['level'],$reponseHero['class_id']));

    $initiative_hero = rand(1, 6) + $reponseHero['hero_initiative'];
    $initiative_monstre = rand(1, 6) + $reponseMonstre['monster_initiative'];

    function parserManaCost($spell) {
        echo intval(substr( $spell,strpos($spell, '-') + 1)); 
        return intval(substr( $spell,strpos($spell, '-') + 1)); 
    }

    if($initiative_hero < $initiative_monstre || ($initiative_hero = $initiative_monstre && $reponseHero['class_id'] != 2) ) {
        if ($magical_monster == true) { //Definition de monstre magique pas encore implementer
            $magical_mana_cost = parserManaCost('Magie générique - 5');
            if ($reponseMonstre['monster_mana'] - $magical_mana_cost >= 0) {
                $reponseMonstre['monster_mana'] -= $magical_mana_cost;
                $attaque = rand(1,6) + rand(1,6) + $magical_mana_cost;
            } else { //Fait une attaque physique si il n'a pas assez de mana.
                $attaque = rand(1,6) +  $reponseMonstre['monster_strength']; //L'arme n'est pas encore pris en compte !corrige
            }
        } else {
            $attaque = rand(1,6) +  $reponseMonstre['monster_strength'];  //L'arme n'est pas encore pris en compte !corrige
        }
        $defense = rand(1,6) + (int) ($reponseHero['hero_strength']/2); //Armure n'est pas encore pris en compte !corrige
        $degat = max(0, $attaque - $defense);
        $reponseHero['hero_pv'] -= $degat;

        //Verification de la victoire du Monstre

        if ($reponseHero['hero_pv'] <= 0) {
            
        }
    }
?>

<img src= "<?php  $reponseMonstre['monstre_image']  ?>" alt="image_monstre">
<h3><?php  $reponseMonstre['monstre_name'] ?></h3>
<p> <?php  $reponseMonstre['monster_pv'] ?> PV |
    <?php  $reponseMonstre['monster_mana'] ?> Mana |
    <?php  $reponseMonstre['monster_strength'] ?> Force 
</p>

<img src= "<?php $reponseHero['hero_image']  ?>" alt="image_hero">
<h3><?php $reponseHero['hero_name'] ?></h3>
<p> 
    <?php $reponseHero['hero_pv'] ?> / <?php $reponseClass['class_base_pv'] + $reponseLevel['level_pv_bonus'] ?> PV |
    <?php $reponseHero['hero_mana'] ?> / <?php $reponseClass['class_base_mana'] + $reponseLevel['level_mana_bonus'] ?> Mana |
    <?php $reponseHero['hero_initiative'] ?> / <?php $reponseClass['class_base_initiative'] + $reponseLevel['level_initiative_bonus'] ?> Initiative |
    <?php $reponseHero['hero_strength'] ?> / <?php $reponseClass['class_base_strength'] + $reponseLevel['level_strength_bonus'] ?> Force |
    Level : <?php $reponseHero['hero_level'] ?> (<?php $reponseHero['hero_xp'] ?>/<?php $reponseLevel['level_required_xp']?> <!-- Xp requis n'est pas forcement celui du suivant ! revoir quand la base est bien définis -->)
</p> 

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
                    $attaque = rand(1,6) + $reponseHero['hero_strength']; //L'arme n'est pas encore pris en compte !corrige
                    $defense = rand(1,6) + (int) ($reponseMonstre['monster_strength']/2); //Armure n'est pas encore pris en compte !corrige
                    $degat = max(0, $attaque - $defense);
                    $reponseMonstre['monster_pv'] -= $degat;
                    break;
                case "magical" :
                    if ($reponseHero['class_id'] == 1) {
                        $magical_mana_cost = parserManaCost($reponseHero['hero_spell_list']); //parserCost existe pas encore
                        if ($reponseHero['hero_mana'] - $magical_mana_cost >= 0) {
                            $reponseHero['hero_mana'] -= $magical_mana_cost;
                            $attaque = rand(1,6) + rand(1,6) + $magical_mana_cost;
                            $defense = rand(1,6) + (int) ($reponseMonstre['monster_strength']/2); //Armure n'est pas encore pris en compte !corrige
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
                    break;
                case "mana_potion" :
                    break;
            }
        
            //Verification de la victoire du joueur

            if ($reponseMonstre['monster_pv'] <= 0) {

            }

            // Tours du monstre

            if ($magical_monster == true) { //Definition de monstre magique pas encore implementer
                $magical_mana_cost = parserManaCost('Magie générique - 5');
                if ($reponseMonstre['monster_mana'] - $magical_mana_cost >= 0) {
                    $reponseMonstre['monster_mana'] -= $magical_mana_cost;
                    $attaque = rand(1,6) + rand(1,6) + $magical_mana_cost;
                } else { //Fait une attaque physique si il n'a pas assez de mana.
                    $attaque = rand(1,6) +  $reponseMonstre['monster_strength']; //L'arme n'est pas encore pris en compte !corrige
                }
            } else {
                $attaque = rand(1,6) +  $reponseMonstre['monster_strength'];  //L'arme n'est pas encore pris en compte !corrige
            }
            $defense = rand(1,6) + (int) ($reponseHero['hero_strength']/2); //Armure n'est pas encore pris en compte !corrige
            $degat = max(0, $attaque - $defense);
            $reponseHero['hero_pv'] -= $degat;

            //Verification de la victoire du Monstre

            if ($reponseHero['hero_pv'] <= 0) {

            }
        
    } else {
        echo "Choisissez une action";
    }
    
    
?>



<?php
require_once("views/footer.php");
?>