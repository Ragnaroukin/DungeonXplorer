<?php
class GameController
{
    public function start()
    {

        if (isset($_SESSION["pseudo"]))
            require_once __DIR__ . "/../views/startGame.php";
        else {
            require_once __DIR__ . "/../views/header.php";
            require_once __DIR__ . "/../views/404.php";
            require_once __DIR__ . "/../views/footer.php";
        }
    }

    public function load()
    {
        if (isset($_SESSION["pseudo"])) {
            $pdo = Database::getConnection();

            $req = $pdo->prepare("SELECT * FROM Hero JOIN Class USING(class_id) JOIN Hero_Progress USING (hero_id, joueur_pseudo) WHERE joueur_pseudo = :pseudo");
            $req->bindParam('pseudo', $_SESSION["pseudo"]);
            $req->execute();

            $heros = $req->fetchAll();


            require_once __DIR__ . "/../views/header.php";
            require_once __DIR__ . "/../views/chooseHero.php";
            require_once __DIR__ . "/../views/footer.php";
        } else {

            require_once __DIR__ . "/../views/header.php";
            require_once __DIR__ . "/../views/404.php";
            require_once __DIR__ . "/../views/footer.php";
        }
    }

    public function loading()
    {
        if (isset($_POST["hero_id"])) {
            $_SESSION["hero"] = $_POST["hero_id"];
            $_SESSION["aventure"] = $_POST["aventure_id"];

            header("Location: " . url("game/chapter"));
        } else {
            require_once __DIR__ . "/../views/header.php";
            require_once __DIR__ . "/../views/404.php";
            require_once __DIR__ . "/../views/footer.php";
        }
    }
}