<popup>
    <form method="post">
        <label>Nom d'utilisateur : <input type="text" name="pseudo" required></label>
        <label>Mot de passe : <input type="password" minlength="8" name="mdp" required></label>
        <button type="submit">Se connecter</button>
    </form>
</popup>

<?php
require_once "../connexionBDD.php";
session_start();
$pseudo = strip_tags($_POST["pseudo"]);
$mdp = strip_tags($_POST["mdp"]);

 
$req = $pdo->prepare("SELECT * FROM User WHERE user_pseudo = :pseudo");
$req->bindParam(":pseudo", $pseudo, type:PDO::PARAM_STR);
$req->execute();

$user = $req->fetch();

if(password_verify($mdp, $user["user_mdp"])) {
    $_SESSION["id"] = $user["user_id"];
} else {
    echo "<script>alert('Mot de passe incorrecte')</script>";
}
?>