<?php
class DashboardController
{
    public function index()
    {
        $pdo = Database::getConnection();

        $stmt = $pdo->prepare("SELECT chapter_id, chapter_image FROM Chapter");
        $stmt->execute();
        $chapters = $stmt->fetchAll();

        $stmt = $pdo->prepare("SELECT monster_name, monster_image FROM Monster");
        $stmt->execute();
        $monsters = $stmt->fetchAll();

        $stmt = $pdo->prepare("SELECT item_name, item_image FROM Items");
        $stmt->execute();
        $items = $stmt->fetchAll();

        $stmt = $pdo->prepare("SELECT class_name, class_img FROM Class");
        $stmt->execute();
        $classes = $stmt->fetchAll();

        $stmt = $pdo->prepare("SELECT * FROM Joueur WHERE joueur_admin = 0");
        $stmt->execute();
        $accounts = $stmt->fetchAll();

        require_once __DIR__ . "/../views/header.php";
        require_once __DIR__ . "/../views/dashboard.php";
    }

    public function viewProfile()
    {
        $pdo = Database::getConnection();

        // Logique pour afficher le profil de l'utilisateur
        $pseudo = isset($_POST['pseudo']) ? $_POST['pseudo'] : "Invité";

        $stmt = $pdo->prepare("SELECT joueur_image, joueur_admin FROM Joueur WHERE joueur_pseudo = :pseudo");
        $stmt->bindParam(':pseudo', $pseudo);
        $stmt->execute();
        $resultat = $stmt->fetch();

        $admin = $resultat['joueur_admin'];
        $joueurImage = $resultat['joueur_image'];

        $connected = false;

        require_once __DIR__ . "/../views/header.php";
        require_once 'views/profile.php';
    }

    public function viewHeroes()
    {
        if (isset($_POST["pseudo"])) {
            $pdo = Database::getConnection();

            $req = $pdo->prepare("SELECT * FROM Hero JOIN Class USING(class_id) JOIN Hero_Progress USING (hero_id, joueur_pseudo) WHERE joueur_pseudo = :pseudo");
            $req->bindParam('pseudo', $_POST["pseudo"]);
            $req->execute();

            $heroes = $req->fetchAll();

            require_once __DIR__ . "/../views/header.php";
            require_once __DIR__ . "/../views/heroList.php";
            require_once __DIR__ . "/../views/footer.php";
        } else {
            header("Location: " . url("admin"));
        }
    }

    public function deleteProfile()
    {
        if (isset($_POST["pseudo"])) {
            $pdo = Database::getConnection();


            $req = $pdo->prepare("DELETE FROM Hero_Progress WHERE joueur_pseudo = :pseudo");
            $req->bindParam(":pseudo", $_POST["pseudo"]);
            $req->execute();

            $req = $pdo->prepare("DELETE FROM Inventory WHERE joueur_pseudo = :pseudo");
            $req->bindParam(":pseudo", $_POST["pseudo"]);
            $req->execute();

            $req = $pdo->prepare("DELETE FROM Hero WHERE joueur_pseudo = :pseudo");
            $req->bindParam(":pseudo", $_POST["pseudo"]);
            $req->execute();

            $req = $pdo->prepare("DELETE FROM Joueur WHERE joueur_pseudo = :pseudo");
            $req->bindParam(":pseudo", $_POST["pseudo"]);
            $req->execute();
        }
        header("Location: " . url("admin"));
    }
}