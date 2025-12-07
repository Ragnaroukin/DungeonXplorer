<section class="get-in-touch">
    <h1 class="title">Inscription</h1>
    <form class="contact-form row" method="post" action="">
        <div class="form-field col-lg-12">
            <label>Nom d'utilisateur : <input type="text" name="pseudo" required></label>
        </div>
        <div class="form-field col-lg-12">
            <label>Mot de passe : <input type="password" minlength="8" name="mdp" required></label>
        </div>
        <div class="form-field col-lg-12">
            <input type="submit" value="S'inscrire">
        </div>
    </form>
</section>

<?php
require_once "models/connexion.php";

if (isset($_POST["pseudo"]) && isset($_POST["mdp"])) {
    $pseudo = $_POST["pseudo"];
    $mdp = $_POST["mdp"];
    $pseudo = strip_tags($pseudo);
    $mdp = strip_tags($mdp);
    $hash = password_hash($mdp, PASSWORD_DEFAULT);

    $req = $pdo->prepare("INSERT INTO Joueur(joueur_pseudo, joueur_mdp) VALUES(:pseudo, :mdp)");
    $req->bindParam(":pseudo", $pseudo, PDO::PARAM_STR);
    $req->bindParam(":mdp", $hash, PDO::PARAM_STR);
    try {
        $req->execute();
    } catch (PDOException $e) {
        echo "<script>alert(\"Erreur lors de l'inscription !\")</script>";
    }

    $req = $pdo->prepare("SELECT joueur_id, joueur_pseudo FROM Joueur WHERE joueur_pseudo = :pseudo");
    $req->bindParam(":pseudo", $pseudo, type: PDO::PARAM_STR);

    $req->execute();

    $joueur = $req->fetch(PDO::FETCH_ASSOC);

    if ($joueur) {
        $_SESSION["id"] = $joueur["joueur_id"];
        $_SESSION["pseudo"] = $joueur["joueur_pseudo"];
        header("Location: /DungeonXplorer/");
    }
}
?>