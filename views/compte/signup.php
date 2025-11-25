<form method="post">
    <label>Nom d'utilisateur : <input type="text" name="pseudo" required></label>
    <label>Mot de passe : <input type="password" minlength="8" name="mdp" required></label>
    <button type="submit">S'inscrire</button>
</form>

<?php
require_once "/DungeonXplorer/models/connexion.php";
session_start();
$pseudo = strip_tags($_POST["pseudo"]);
$mdp = strip_tags($_POST["mdp"]);

if(isset($pseudo) && isset($mdp)) {

    $hash = password_hash($mdp, PASSWORD_DEFAULT);

    $req = $pdo->prepare("INSERT INTO Joueur(joueur_pseudo, joueur_mdp) VALUES(:pseudo, :mdp)");
    $req->bindParam(":pseudo", $pseudo, PDO::PARAM_STR);
    $req->bindParam(":mdp", $hash, PDO::PARAM_STR);
    try{
        $req->execute();
    } catch (PDOException $e) {
        echo "<script>alert(\"Erreur lors de l'inscription !\")</script>";
        //echo $e->getMessage();
        exit();
    }
    
    $req = $pdo->prepare("SELECT joueur_id FROM Joueur WHERE joueur_pseudo = :pseudo");
    $req->bindParam(":pseudo", $pseudo, type:PDO::PARAM_STR);
    $req->execute();

    $joueur = $req->fetch(PDO::FETCH_ASSOC);

    $_SESSION["id"] = $joueur["joueur_id"];
    $_SESSION["pseudo"] = $joueur["joueur_pseudo"];
}
?>