<section class="get-in-touch">
    <h1 class="title"><?= ucwords($titre)?></h1>
    <form class="contact-form row" method="post" action="">
        <div class="form-field col-lg-12">
            <label>Nom d'utilisateur : <input type="text" name="pseudo" required></label>
        </div>
        <div class="form-field col-lg-12">
            <label>Mot de passe : <input type="password" minlength="4" name="mdp" required></label>
        </div>
        <div class="form-field col-lg-12">
            <input class="submit-btn" type="submit" value="Se connecter">
        </div>
    </form>
</section>