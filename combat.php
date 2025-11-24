<?php 
require_once("views/header.php");
?>

<?php
    $monster_id = $_POST['monster_id'];
    $reponseMonstre = $bdd->query("'SELECT monster_nom,monster_image,monster_pv,monster_mana,monster_initiative,monster_strength,monster_attack,monster_xp FROM Monster where monster_id = ' $monster_id");
?>

<img src= "<?php  $reponseMonstre['monstre_image']  ?>" alt="image_monstre">
<h3><?php  $reponseMonstre['monstre_nom'] ?></h3>
<p><?php  $reponseMonstre['monster_pv'] ?> PV / <?php  $reponseMonstre['monster_mana'] ?> Mana / <?php  $reponseMonstre['monster_strength'] ?> Force </p>



<?php
require_once("views/footer.php");
?>