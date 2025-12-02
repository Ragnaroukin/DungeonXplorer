<?php 
    require_once("header.php");
    require_once("models/connexion.php");
    if (isset($_SESSION['id'])) {
        $id=$_SESSION['id'];
    }else {
        $id=0;
    }
    if (isset($_SESSION['pseudo'])) {
        $pseudo=$_SESSION['pseudo'];
    }else {
        $pseudo="Invité";
    }
    if (isset($_SESSION['admin'])) {
        $admin=$_SESSION['admin'];
    }else {
        $admin=0;
    }

    $sql = "SELECT joueur_image FROM joueurs WHERE joueur_id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $resultat = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($resultat) {
    // La colonne joueur_image est stockée dans $resultat['joueur_image']
        $joueurImage = $resultat['joueur_image'];
    } else {
        $joueurImage = '/img/default.jpg'; // Image par défaut si aucune image n'est trouvée
    }

?>
<body>

    <div class="profile-container">

        <header class="profile-header">
            <h1>Nom et Prénom du Joueur</h1>
            <p>Poste : Attaquant</p>
        </header>

        <div class="profile-image-box">
            <img src="<?php echo $joueurImage; ?>" alt="Photo de profil du joueur">
        </div>

        <section class="profile-details">
            <h2>Informations Clés</h2>
            <p>
                <span>ID Joueur :</span> <?php echo $id; ?>
            </p>
            <p>
                <span>Pseudo :</span> <?php echo htmlspecialchars($pseudo); ?>
            </p>
            <p>
                <?php if ($admin){
                    echo '<span>Statut :</span> Administrateur';
                } else {
                    echo '<span>Statut :</span> Utilisateur';
                } ?>
            </p>
        </section>

    </div>

</body>
</html>