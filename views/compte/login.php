<section class="get-in-touch">
    <h1 class="title">Connexion</h1>
    <form class="contact-form row" method="post" action="">
        <div class="form-field col-lg-12">
            <label>Nom d'utilisateur : <input type="text" name="pseudo" required></label>
        </div>
        <div class="form-field col-lg-12">
            <label>Mot de passe : <input type="password" minlength="8" name="mdp" required></label>
        </div>
        <div class="form-field col-lg-12">
            <input class="submit-btn" type="submit" value="Se connecter">
        </div>
    </form>
</section>

<?php
if (isset($_POST["pseudo"]) && isset($_POST["mdp"])) {
    $pseudo = $_POST["pseudo"];
    $mdp = $_POST["mdp"];
    $pseudo = strip_tags($pseudo);
    $mdp = strip_tags($mdp);

    $req = $pdo->prepare("SELECT * FROM Joueur WHERE joueur_pseudo = :pseudo");
    $req->bindParam(":pseudo", $pseudo, type: PDO::PARAM_STR);
    $req->execute();

    $joueur = $req->fetch(PDO::FETCH_ASSOC);

    if ($joueur && password_verify($mdp, $joueur["joueur_mdp"])) {
        $_SESSION["pseudo"] = $joueur["joueur_pseudo"];
        $_SESSION["admin"] = $joueur["joueur_admin"];
        header("Location: /DungeonXplorer/");
    } else if ($joueur) //On connait le joueur mais le mot de passe est incorrecte
        echo "<script>alert('Mot de passe incorrect !')</script>";
    else //l'utilisateur est inconnu
        echo "<script>alert('Joueur inconnu !')</script>";
}
?>