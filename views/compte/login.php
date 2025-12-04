<?php 
session_start();
require_once "views/header.php";
?>
<form id="popup" method="post">
    <label>Nom d'utilisateur : <input type="text" name="pseudo" required></label>
    <label>Mot de passe : <input type="password" minlength="8" name="mdp" required></label>
    <button type="submit"><a href="">Se connecter</a></button>
</form>

<?php
require_once "views/footer.php";
require_once "models/connexion.php";
$pseudo = $_POST["pseudo"];
$mdp = $_POST["mdp"];

if(isset($pseudo) && isset($mdp)) {
    $pseudo = strip_tags($pseudo) ;
    $mdp = strip_tags($mdp);
    
    $req = $pdo->prepare("SELECT * FROM Joueur WHERE joueur_pseudo = :pseudo");
    $req->bindParam(":pseudo", $pseudo, type:PDO::PARAM_STR);
    $req->execute();

    $joueur = $req->fetch(PDO::FETCH_ASSOC);

    if($joueur && password_verify($mdp, $joueur["joueur_mdp"])) {
        $_SESSION["id"] = $joueur["joueur_id"];
        $_SESSION["pseudo"] = $joueur["joueur_pseudo"];
        header("Location: /DungeonXplorer/");
    }
    else if($joueur) //On connait le joueur mais le mot de passe est incorrecte
        echo "<script>alert('Mot de passe incorrect !')</script>";
    else //l'utilisateur est inconnu
        echo "<script>alert('Joueur inconnu !')</script>";
}
?>