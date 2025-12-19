<?php
class ProfileController
{
    public function show()
    {
        if (empty($_SESSION['pseudo']))
            require_once "views/404.php";
        else {
            $pdo = Database::getConnection();

            // Logique pour afficher le profil de l'utilisateur
            $pseudo = $_SESSION['pseudo'];
            $admin = $_SESSION['admin'];

            $sql = "SELECT joueur_image FROM Joueur WHERE joueur_pseudo = :pseudo";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':pseudo', $pseudo);
            $stmt->execute();
            $resultat = $stmt->fetch();

            $joueurImage = $resultat['joueur_image'];

            require_once 'views/profile.php';
        }
    }

    public function disconnect()
    {
        if (isset($_SESSION["pseudo"]))
            unset($_SESSION["pseudo"]);
        if (isset($_SESSION["admin"]))
            unset($_SESSION["admin"]);
        if (isset($_SESSION["aventure"]))
            unset($_SESSION["aventure"]);
        if (isset($_SESSION["hero"]))
            unset($_SESSION["hero"]);


        header("Location:" . url(""));
    }

    public function delete()
    {
        if (empty($_SESSION['pseudo']))
            require_once "views/404.php";
        else {
            $pdo = Database::getConnection();

            $req = $pdo->prepare("DELETE FROM Hero_Progress WHERE joueur_pseudo = :pseudo");
            $req->bindParam(":pseudo", $_SESSION["pseudo"]);
            $req->execute();

            $req = $pdo->prepare("DELETE FROM Hero WHERE joueur_pseudo = :pseudo");
            $req->bindParam(":pseudo", $_SESSION["pseudo"]);
            $req->execute();

            $req = $pdo->prepare("DELETE FROM Joueur WHERE joueur_pseudo = :pseudo");
            $req->bindParam(":pseudo", $_SESSION["pseudo"]);
            $req->execute();

            self::disconnect();
        }
    }

    public function modify()
    {
        if (empty($_SESSION['pseudo']))
            require_once "views/404.php";
        else {
            $pdo = Database::getConnection();

            // Logique pour afficher le profil de l'utilisateur
            $pseudo = isset($_SESSION['pseudo']) ? $_SESSION['pseudo'] : "Invité";
            $admin = isset($_SESSION['admin']) ? $_SESSION['admin'] : 0;

            $sql = "SELECT joueur_image FROM Joueur WHERE joueur_pseudo = :pseudo";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':pseudo', $pseudo);
            $stmt->execute();
            $resultat = $stmt->fetch();

            $joueurImage = $resultat['joueur_image'];

            require_once 'views/profileModify.php';
        }
    }

    public function modifying()
    {
        if (empty($_SESSION['pseudo']))
            require_once "views/404.php";
        else {
            if ($_POST["image"] !== "") {
                $pdo = Database::getConnection();

                // Logique pour afficher le profil de l'utilisateur
                $pseudo = $_SESSION['pseudo'];
                $img = "img/" . $_POST['image'];

                $sql = "UPDATE `Joueur` SET `joueur_image` = :img WHERE `Joueur`.`joueur_pseudo` = :pseudo";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':pseudo', $pseudo);
                $stmt->bindParam(':img', $img);
                $stmt->execute();
            }
            header("Location:" . url("profile"));
        }
    }

    public function heroes()
    {
        if (empty($_SESSION['pseudo']))
            require_once "views/404.php";
        else {
            $pdo = Database::getConnection();

            $req = $pdo->prepare("SELECT * FROM Hero JOIN Class USING(class_id) JOIN Hero_Progress USING (hero_id, joueur_pseudo) WHERE joueur_pseudo = :pseudo");
            $req->bindParam('pseudo', $_SESSION["pseudo"]);
            $req->execute();

            $heroes = $req->fetchAll();

            require_once __DIR__ . "/../views/heroList.php";
        }
    }
}
