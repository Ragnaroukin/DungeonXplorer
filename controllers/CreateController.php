<?php
class CreateController
{
        public function classChoice()
        {
                $pdo = Database::getConnection();

                $class = $pdo->prepare("SELECT * FROM Class");
                $class->execute();

                require_once __DIR__ . "/../views/header.php";
                require_once __DIR__ . '/../views/characterCreation/creaPerso.php';
                require_once __DIR__ . "/../views/footer.php";
        }

        public function heroDetail()
        {
                $pdo = Database::getConnection();

                $stmt = $pdo->prepare('SELECT class_img FROM Class WHERE class_id = :cid');
                $stmt->bindParam(":cid", $_POST['class_id']);
                $stmt->execute();
                $row = $stmt->fetch();

                $stmt = $pdo->prepare('SELECT * FROM Aventure');
                $stmt->execute();
                $aventures = $stmt->fetchAll();

                $_SESSION['class_id'] = $_POST['class_id'];
                $_SESSION['class_img'] = $row["class_img"];


                require_once __DIR__ . "/../views/header.php";
                require_once __DIR__ . '/../views/characterCreation/createHero.php';
                require_once __DIR__ . "/../views/footer.php";
        }

        public function create()
        {
                $pdo = Database::getConnection();

                $name = trim($_POST['name'] ?? '');
                $bio = trim($_POST['bio']);

                $classId = $_SESSION["class_id"];
                $user = $_SESSION["pseudo"];

                $stmt = $pdo->prepare('SELECT class_base_pv AS pv, class_base_mana AS mana, class_base_strength AS strength, class_base_initiative AS initiative FROM Class WHERE class_id = :cid');
                $stmt->bindParam(":cid", $classId);
                $stmt->execute();
                $row = $stmt->fetch();
                $pv = (int) ($row['pv']);
                $mana = (int) ($row['mana']);
                $strength = (int) ($row['strength']);
                $initiative = (int) ($row['initiative']);

                $hero_id = $pdo->prepare("SELECT MAX(hero_id)+1 as max FROM Hero WHERE joueur_pseudo = :pseudo");
                $hero_id->bindParam(":pseudo", $user);
                $hero_id->execute();
                $hero = $hero_id->fetch()['max'] ?? 1;

                $sql = 'INSERT INTO Hero (hero_id, joueur_pseudo, hero_name, class_id, hero_biography, hero_pv, hero_mana, hero_strength, hero_initiative)
            VALUES (:hero_id, :joueur_pseudo, :hero_name, :class_id, :hero_bio, :pv, :mana, :strength, :initiative)';
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':hero_id', $hero);
                $stmt->bindParam(':joueur_pseudo', $user);
                $stmt->bindParam(':hero_name', $name);
                $stmt->bindParam(':class_id', $classId);
                $stmt->bindParam(':hero_bio', $bio);
                $stmt->bindParam(':pv', $pv);
                $stmt->bindParam(':mana', $mana);
                $stmt->bindParam(':strength', $strength);
                $stmt->bindParam(':initiative', $initiative);
                $stmt->execute();

                $new = $pdo->prepare("INSERT INTO `Hero_Progress` (`aventure_id`, `chapter_id`, `joueur_pseudo`, `hero_id`, `progress_completion_date`) VALUES (:aventure_id, 1, :pseudo, :hero_id, NOW())");
                $new->bindParam(":pseudo", $_SESSION["pseudo"]);
                $new->bindParam(":hero_id", $hero);
                $new->bindParam(":aventure_id", $_POST["aventure"]);
                $new->execute();

                unset($_SESSION["class_id"]);
                unset($_SESSION["class_img"]);
                $_SESSION["hero"] = $hero;
                $_SESSION["aventure"] = $_POST["aventure"];

                header("Location: ../chapter");
        }
}