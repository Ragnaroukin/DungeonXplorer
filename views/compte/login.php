<form method="post">
    <label>Nom d'utilisateur : <input type="text" name="pseudo" required></label>
    <label>Mot de passe : <input type="password" minlength="8" name="mdp" required></label>
    <button type="submit">Se connecter</button>
</form>

<?php
require_once "/DungeonXplorer/models/connexion.php";
session_start();
$pseudo = strip_tags($_POST["pseudo"]);
$mdp = strip_tags($_POST["mdp"]);

 
$req = $pdo->prepare("SELECT * FROM Joueur WHERE joueur_pseudo = :pseudo");
$req->bindParam(":pseudo", $pseudo, type:PDO::PARAM_STR);
$req->execute();

$joueur = $req->fetch(PDO::FETCH_ASSOC);

if(password_verify($mdp, $joueur["joueur_mdp"])) {
    $_SESSION["id"] = $joueur["joueur_id"];
    $_SESSION["pseudo"] = $joueur["joueur_pseudo"];
    echo "<script>alert('Connexion réussie')</script>";
} else {
    echo "<script>alert('Connexion échouée')</script>";
    exit();
}
?>