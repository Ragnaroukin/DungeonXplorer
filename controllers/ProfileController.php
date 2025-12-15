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
}
