<div class="profile-container">
    <header class="profile-header">
        <h1>Profil</h1>
    </header>

    <div class="profile-image-box">
        <img src="<?= url($joueurImage) ?>" alt="Photo de profil du joueur">
    </div>

    <section class="profile-details">
        <p>
            <span>Pseudo :</span> <?= $pseudo?>
        </p>
        <p>
            <?php if ($admin) {
                echo '<span>Statut :</span> Administrateur';
            } else {
                echo '<span>Statut :</span> Utilisateur';
            } ?>
        </p>
    </section>
</div>