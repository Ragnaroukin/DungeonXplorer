<?php if ($connected) { ?>
    <a class="btn btn-lg" id="disconnect-btn" href=<?= url("profile/disconnect") ?>>Déconnexion</a>
<?php } ?>
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
        <?php if ($connected) { ?>
            <a class="btn btn-secondary btn-lg" href=<?= url("profile/heroes") ?>>Héros</a>
            <a class="btn btn-warning btn-lg" href=<?= url("profile/modify") ?>>Modifier</a>
        <?php } else { ?>
            <form action=<?= url("admin/profile/heroes") ?> method="post">
                <input type="hidden" id="pseudo" name="pseudo" value="<?= $pseudo ?>">
                <input class="btn btn-secondary btn-lg w-100" type="submit" value="Héros">
            </form>
        <?php } ?>
        <a class="btn btn-danger btn-lg" href=<?= url("profile/delete") ?>>Supprimer</a>
    </div>
</div>