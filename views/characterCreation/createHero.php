<section class="get-in-touch">
    <h1 class="title">Créer un héros :</h1>
    <form class="contact-form row" method="post" action="creating">
        <div class="img-field">
            <div class="image-box">
                <img id="hero-img" src=<?= url($_SESSION["class_img"]) ?>>
            </div>
        </div>
        <div class="form-field col-lg-6 ">
            <label>Nom :</label>
            <input id="name" name="name" class="input-text js-input" type="text" required>
        </div>
        <div class="form-field col-lg-6">
            <label>Aventure :</label>
            <br>
            <select id="aventure" name="aventure" class="w-100">
                <?php foreach ($aventures as $aventure) { ?>
                    <option value=<?= $aventure["aventure_id"] ?>><?= $aventure["aventure_name"] ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-field col-lg-6 long-text">
            <label>Biographie :</label>
            <textarea id="bio" name="bio" rows="6"></textarea>
        </div>
        <div class="form-field col-lg-12">
            <input class="submit-btn" type="submit" value="Valider la création du personnage">
        </div>
    </form>
</section>