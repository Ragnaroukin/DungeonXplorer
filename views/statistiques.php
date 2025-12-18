<section class="get-in-touch">
        <div class="d-flex justify-center">
            <h1><?= $stats["hero_name"]?></h1>
            <img class="card" src=<?=url($stats["class_img"])?> alt=<?=$stats["class_img"]?>>
            Votre histoire :<br><?= $stats["hero_biography"]?><br><br>
            Niveau : <?=$stats["hero_level"]?><br>
            PV : <?= $stats["hero_pv"]?><br>
            Mana : <?= $stats["hero_mana"]?><br>
            Force : <?= $stats["hero_strength"]?><br>
            <?php if(isset($stats["hero_spell_list"])) echo "Vos sorts : ".$stats["hero_spell_list"];?>
        </div>
</section>