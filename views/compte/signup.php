<?php 
require_once "views/header.php";
?>
<form id="popup" method="post">
    <label>Nom d'utilisateur : <input type="text" name="pseudo" required></label>
    <label>Mot de passe : <input type="password" minlength="8" name="mdp" required></label>
    <button><a href="login">Se connecter</a></button>
    <button type="submit"><a href="@">S'inscrire</a></button>
</form>

<?php
require_once "views/footer.php";
require_once "models/connexion.php";
session_start();
$pseudo = $_POST["pseudo"];
$mdp = $_POST["mdp"];

if(isset($pseudo) && isset($mdp)) {
    $pseudo = strip_tags($pseudo);
    $mdp = strip_tags($mdp);
    $hash = password_hash($mdp, PASSWORD_DEFAULT);

    $req = $pdo->prepare("INSERT INTO Joueur(joueur_pseudo, joueur_mdp) VALUES(:pseudo, :mdp)");
    $req->bindParam(":pseudo", $pseudo, PDO::PARAM_STR);
    $req->bindParam(":mdp", $hash, PDO::PARAM_STR);
    try{
        $req->execute();
    } catch (PDOException $e) {
        echo "<script>alert(\"Erreur lors de l'inscription !\")</script>";
    }
    
    $req = $pdo->prepare("SELECT joueur_id, joueur_pseudo FROM Joueur WHERE joueur_pseudo = :pseudo");
    $req->bindParam(":pseudo", $pseudo, type:PDO::PARAM_STR);
    
    $req->execute();

    $joueur = $req->fetch(PDO::FETCH_ASSOC);

    if($joueur) {
        $_SESSION["id"] = $joueur["joueur_id"];
        $_SESSION["pseudo"] = $joueur["joueur_pseudo"];
        header("Location: /DungeonXplorer/");
    }
}
?>