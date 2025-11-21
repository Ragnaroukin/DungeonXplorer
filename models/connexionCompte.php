<popup>
    <form method="post">
        <label>Nom d'utilisateur : <input type="text" name="username" required></label>
        <label>Mot de passe : <input type="password" minlength="8" name="password" required></label>
        <button type="submit">Connexion</button>
    </form>
</popup>

<?php
session_start();
require_once "connexionBDD.php";
$username = $_POST["username"];
$password = $_POST["password"];

echo $pdo->query("SELECT * FROM Users");
?>