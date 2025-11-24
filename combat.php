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

<?php 
    if(isset($_POST['choice'])) {
        $choice = $_POST['choice'];
    
        switch($choice) {
                case "physical" :
                    break;
                case "magical" :
                    break;
                case "health_potion" :
                    break;
                case "mana_potion" :
                    break;
            }
    } else {
        echo "Choisissez une action";
    }
    
?>



<?php
require_once("views/footer.php");
?>