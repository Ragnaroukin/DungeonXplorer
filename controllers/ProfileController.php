<?php
class ProfileController
{
    public function show()
    {
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

        require_once 'views/profile.php';
    }

    public function delete()
    {

    }

    public function modify()
    {
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

    public function modifying()
    {
        if (isset($_POST["image"])) {
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
        header("Location:".url("profile"));

    }

    public function heroes()
    {

    }
}
