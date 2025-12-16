<a class="btn btn-lg" id="disconnect-btn" href=<?= url("profile/disconnect") ?>>Déconnexion</a>
<<<<<<< HEAD
=======

>>>>>>> inventaire
<div class="profile-container">
    <header class="profile-header">
        <h1>Profil</h1>
    </header>

    <div class="profile-image-box">
        <img src="<?= url($joueurImage) ?>" alt="Photo de profil du joueur">
    </div>

    <section class="profile-details">
        <p>
            <span>Pseudo :</span> <?= $pseudo ?>
        </p>
        <p>
            <?php if ($admin) {
                echo '<span>Statut :</span> Administrateur';
            } else {
                echo '<span>Statut :</span> Utilisateur';
            } ?>
        </p>
    </section>

    <div class="d-flex flex-column gap-3 mt-3">
        <a class="btn btn-secondary btn-lg" href=<?= url("profile/heroes") ?>>Héros</a>
        <a class="btn btn-warning btn-lg" href=<?= url("profile/modify") ?>>Modifier</a>
        <a class="btn btn-danger btn-lg" href=<?= url("profile/delete") ?>>Supprimer</a>
    </div>
</div>