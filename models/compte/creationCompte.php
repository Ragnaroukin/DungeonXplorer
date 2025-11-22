<popup>
    <form method="post">
        <label>Nom d'utilisateur : <input type="text" name="pseudo" required></label>
        <label>Mot de passe : <input type="password" minlength="8" name="mdp" required></label>
        <button type="submit">S'inscrire</button>
    </form>
</popup>

<?php
require_once "../connexionBDD.php";
session_start();
$pseudo = strip_tags($_POST["pseudo"]);
$mdp = strip_tags($_POST["mdp"]);

if(isset($pseudo) && isset($mdp)) {

    $hash = password_hash($mdp, PASSWORD_DEFAULT);

    $req = $pdo->prepare("INSERT INTO User(user_pseudo, user_mdp) VALUES(:pseudo, :mdp)");
    $req->bindParam(":pseudo", $pseudo, PDO::PARAM_STR);
    $req->bindParam(":mdp", $hash, PDO::PARAM_STR);
    try{
        $req->execute();
    } catch (PDOException $e) {
        echo "<script>alert('Pseudo déjà utilisé !')</script>";
        exit();
    }
    
    $req = $pdo->prepare("SELECT user_id FROM User WHERE user_pseudo = :pseudo");
    $req->bindParam(":pseudo", $pseudo, type:PDO::PARAM_STR);
    $req->execute();

    $_SESSION["id"] = $req->fetch()["user_id"];
}
?>