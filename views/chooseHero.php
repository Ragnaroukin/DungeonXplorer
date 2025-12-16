<div class="d-flex justify-content-center mb-3 w-100">
    <h1 class="titre">Vos héros :</h1>
</div>
<div class="d-flex flex-nowrap align-items-center pt-3 pb-2 mb-3 border-top w-100 scroll-container hero-chooser">
    <?php foreach ($heros as $hero) { ?>
        <div class="choose-card">
            <div class="choose-header">
                <h2 class="text-nowrap"><?= $hero['hero_name'] ?></h2>
                <h4 class="text-nowrap"><?= 'Lv . ' . $hero['hero_level'] ?></h4>
            </div>
            <img class="choose-img" src=<?= url($hero["class_img"]) ?>>
            <form action="loading" method="post">
                <input type="hidden" id="hero_id" name="hero_id" value=<?= $hero["hero_id"] ?>>
                <input type="hidden" id="aventure_id" name="aventure_id" value=<?= $hero["aventure_id"] ?>>
                <input class="choose-btn" type="submit" value="Choisir">
            </form>
        </div>
    <?php } ?>
</div>
<div class="d-flex justify-content-center">
    <button class="btn btn-danger align-middle btn-lg text-black fw-bold" type="button"
        onclick="history.back()">Retour</button>
</div>