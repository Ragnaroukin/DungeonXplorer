<?php
class ProfileController
{
    public function show()
    {
        $pdo = Database::getConnection();

        // Logique pour afficher le profil de l'utilisateur
        $pseudo = isset($_SESSION['pseudo']) ? $_SESSION['pseudo'] : "Invité";

        $sql = "SELECT joueur_image, joueur_admin FROM Joueur WHERE joueur_pseudo = :pseudo";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':pseudo', $pseudo);
        $stmt->execute();
        $resultat = $stmt->fetch();

        $admin = $resultat['joueur_admin'];
        $joueurImage = $resultat['joueur_image'];

        $connected = true;

        require_once 'views/profile.php';
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
        $pdo = Database::getConnection();

        $req = $pdo->prepare("DELETE FROM Hero_Progress WHERE joueur_pseudo = :pseudo");
        $req->bindParam(":pseudo", $_SESSION["pseudo"]);
        $req->execute();

        $req = $pdo->prepare("DELETE FROM Inventory WHERE joueur_pseudo = :pseudo");
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

    public function modify()
    {
        $pdo = Database::getConnection();

        // Logique pour afficher le profil de l'utilisateur
        $pseudo = ($_SESSION['pseudo'] ?? "Invité");

        $sql = "SELECT joueur_image, joueur_admin FROM Joueur WHERE joueur_pseudo = :pseudo";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':pseudo', $pseudo);
        $stmt->execute();
        $resultat = $stmt->fetch();

        $admin = $resultat['joueur_admin'];
        $joueurImage = $resultat['joueur_image'];

        require_once 'views/profileModify.php';
    }

    public function modifying()
    {
        // On vérifie qu'il n'y a pas eu d'erreur
        if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
            header("Location: " . url("profile"));
            exit;
        }

        $pdo = Database::getConnection();
        $pseudo = $_SESSION['pseudo'];

        // On vérifie que le fichier est bien une image
        $tmpImg = $_FILES['image']['tmp_name'];
        $info = getimagesize($tmpImg);
        if ($info === false) {
            header("Location: " . url("profile"));
            exit;
        }

        // On récupère l'extension
        $mime = $info['mime'];
        $ext = match ($mime) {
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/webp' => 'webp',
            default => null
        };

        if ($ext === null) {
            // Extension inconnue on arrête
            header("Location: " . url("profile"));
            exit;
        }

        // On défini le répertoire de destination
        $uploadDir = __DIR__ . '/../img/profiles';

        // nom unique
        $filename = $pseudo . '_' . time() . '.' . $ext;
        $destPath = $uploadDir . '/' . $filename;

        if (!move_uploaded_file($tmpImg, $destPath)) {
            header("Location: " . url("profile"));
            exit;
        }

        $img = 'img/profiles/' . $filename;

        $sql = "UPDATE Joueur SET joueur_image = :img WHERE joueur_pseudo = :pseudo";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
        $stmt->bindParam(':img', $img, PDO::PARAM_STR);
        $stmt->execute();

        header("Location: " . url("profile"));
        exit;
    }


    public function heroes()
    {
        $pdo = Database::getConnection();

        $req = $pdo->prepare("SELECT * FROM Hero JOIN Class USING(class_id) JOIN Hero_Progress USING (hero_id, joueur_pseudo) WHERE joueur_pseudo = :pseudo");
        $req->bindParam('pseudo', $_SESSION["pseudo"]);
        $req->execute();

        $heroes = $req->fetchAll();

        require_once __DIR__ . "/../views/heroList.php";
    }
}
