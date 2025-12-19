<section class="get-in-touch">
    <div class="d-flex justify-content-center">
        <div class="d-flex flex-column align-items-center gap-2" style="width: 600px;">
            <h1><?= $stats["hero_name"] ?></h1>
            <img class="card" src=<?= url($stats["class_img"]) ?> alt=<?= $stats["class_img"] ?>>
            <span>Votre histoire : </span>
            <p class="text-start align-self-stretch">
                <?= $stats["hero_biography"] ?>
            </p>
            <span>Niveau : <?= $stats["hero_level"] ?></span>
            <span>PV : <?= $stats["hero_pv"] ?></span>
            <span>Mana : <?= $stats["hero_mana"] ?></span>
            <span>Force : <?= $stats["hero_strength"] ?></span>
            <?php if (isset($stats["hero_spell_list"])) { ?>
                <span>Vos sorts : <?= $stats["hero_spell_list"] ?></span>
            <?php } ?>
        </div>
    </div>
</section>