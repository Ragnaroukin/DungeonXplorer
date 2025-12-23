<?php
class CompteController
{

        public function index()
        {
                $titre = explode("/", $_SERVER["REQUEST_URI"])[2];
                if ($titre === "connexion")
                        self::login();    
                else if ($titre === "inscription")
                        self::signup();
                require_once __DIR__ . "/../views/header.php";
                require_once __DIR__ . "/../views/compte.php";
                require_once __DIR__ . "/../views/footer.php";
        }

        public function login()
        {
                $pdo = Database::getConnection();
                if (isset($_POST["pseudo"]) && isset($_POST["mdp"])) {
                        $pseudo = $_POST["pseudo"];
                        $mdp = $_POST["mdp"];
                        $pseudo = strip_tags($pseudo);
                        $mdp = strip_tags($mdp);

                        $req = $pdo->prepare("SELECT * FROM Joueur WHERE joueur_pseudo = :pseudo");
                        $req->bindParam(":pseudo", $pseudo, type: PDO::PARAM_STR);
                        try {
                                $req->execute();      
                        } catch (PDOException $e) {
                               echo "Une erreur s'est produite !";
                        }
                        
                        $joueur = $req->fetch(PDO::FETCH_ASSOC);

                        if ($joueur && password_verify($mdp, $joueur["joueur_mdp"])) {
                                        $_SESSION["pseudo"] = $joueur["joueur_pseudo"];
                                        $_SESSION["admin"] = $joueur["joueur_admin"];
                                        header("Location: " . url(""));
                                        exit();
                                }
                }
        }

        public function signup()
        {
                $pdo = Database::getConnection();
                if (isset($_POST["pseudo"]) && isset($_POST["mdp"])) {
                        $pseudo = $_POST["pseudo"];
                        $mdp = $_POST["mdp"];
                        $pseudo = strip_tags($pseudo);
                        $mdp = strip_tags($mdp);
                        $hash = password_hash($mdp, PASSWORD_DEFAULT);

                        $req = $pdo->prepare("INSERT INTO Joueur(joueur_pseudo, joueur_mdp) VALUES(:pseudo, :mdp)");
                        $req->bindParam(":pseudo", $pseudo, PDO::PARAM_STR);
                        $req->bindParam(":mdp", $hash, PDO::PARAM_STR);

                        $req->execute();

                        self::login();
                }
        }
}