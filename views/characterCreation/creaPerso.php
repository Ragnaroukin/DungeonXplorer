<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choix de la classe</title>
    <link rel="stylesheet" href="../../styles/styleCreaPerso.css">
</head>
<body class="classSelectBackground">
    <?php ?>
    <div class="classCards">
        <div class="card">
            <img src="../../img/BarbarianClass.png" alt="The image of a Barbarian">
            <form action="" method="post">
                <input type="hidden" name="class_id" value="0">
                <a href="createHero.php?class_id=0"><button type="button" class="classSelectButton">Barbare</button></a>
            </form>
        </div>

        <div class="card">
            <img src="../../img/WizardClass.png" alt="The image of a Barbarian">
            <form action="" method="post">
                <input type="hidden" name="class_id" value="1">
                <a href="createHero.php?class_id=1"><button type="button" class="classSelectButton">Mage</button></a>
            </form>
        </div>

        <div class="card">
            <img src="../../img/RogueClass.png" alt="The image of a Barbarian">
            <form action="" method="post">
                <input type="hidden" name="class_id" value="2">
                <a href="createHero.php?class_id=2"><button type="button" class="classSelectButton">Voleur</button></a>
            </form>
        </div>
    </div>
    
</body>
</html>

<?php

//require_once  ;

?>
