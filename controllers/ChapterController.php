<?php
class ChapterController
{
        public function index()
        {
                if (empty($_SESSION["pseudo"]) || empty($_SESSION["hero"]) || empty($_SESSION["aventure"])) {
                        require_once __DIR__ . "/../views/header.php";
                        require_once __DIR__ . "/../views/404.php";
                        require_once __DIR__ . "/../views/footer.php";
                } else {
                        $pdo = Database::getConnection();
                        $req = $pdo->prepare("SELECT chapter_id, chapter_image, chapter_content, link_chapter_id,link_description 
                                                FROM Hero_Progress 
                                                JOIN Chapter USING (aventure_id, chapter_id) 
                                                LEFT JOIN Links USING (aventure_id, chapter_id)
                                        WHERE joueur_pseudo = :pseudo 
                                        and hero_id = :hero_id
                                        and aventure_id = :aventure_id");
                        $req->bindParam(":pseudo", $_SESSION["pseudo"], type: PDO::PARAM_STR);
                        $req->bindParam(":hero_id", $_SESSION["hero"], type: PDO::PARAM_STR);
                        $req->bindParam(":aventure_id", $_SESSION["aventure"], type: PDO::PARAM_STR);
                        $req->execute();

                        $data = $req->fetchAll();

                        $req = $pdo->prepare("SELECT item_id, item_image, item_name, treasure_quantity FROM Chapter_Treasure
                                        JOIN Items USING(item_id)
                                        WHERE aventure_id = :aventure_id
                                        AND chapter_id = :chapter_id");
                        $req->bindParam(":aventure_id", $_SESSION["aventure"]);
                        $req->bindParam(":chapter_id", $data[0]["chapter_id"]);
                        $req->execute();

                        $treasure = $req->fetch();

                        if(!empty($treasure))
                                Inventaire::addItem($treasure["item_id"], $treasure["treasure_quantity"]);
                        
                        $req = $pdo->prepare("SELECT * FROM Encounter
                                                WHERE aventure_id = :aventure_id AND chapter_id = :chapter");
                        $req->bindParam(":aventure_id", $_SESSION["aventure"]);
                        $req->bindParam(":chapter", $data[0]["chapter_id"]);
                        $req->execute();

                        $encounters = $req->fetchAll();

                        if (count($encounters) > 0) {
                                require_once __DIR__ . "/../views/header.php";
                                require_once __DIR__ . "/../views/startFight.php";
                                require_once __DIR__ . "/../views/footer.php";
                        } else {
                                require_once __DIR__ . "/../views/header.php";
                                if(!empty($treasure))
                                        require_once   __DIR__ . "/../views/tresor.php";
                                require_once __DIR__ . "/../views/chapter.php";
                                require_once __DIR__ . "/../views/footer.php";
                        }
                }
        }

        public function progress()
        {
                if (empty($_SESSION["pseudo"]) || empty($_SESSION["hero"]) || empty($_SESSION["aventure"])) {
                        require_once __DIR__ . "/../views/header.php";
                        require_once __DIR__ . "/../views/404.php";
                        require_once __DIR__ . "/../views/footer.php";
                } else {
                        $pdo = Database::getConnection();
                        $req = $pdo->prepare("UPDATE `Hero_Progress` 
                                                SET `chapter_id` = :new_chapter_id 
                                                WHERE `Hero_Progress`.`aventure_id` = :aventure_id 
                                                AND `Hero_Progress`.`joueur_pseudo` = :pseudo 
                                                AND `Hero_Progress`.`hero_id` = :hero_id");
                        $req->bindParam(":pseudo", $_SESSION["pseudo"], type: PDO::PARAM_STR);
                        $req->bindParam(":hero_id", $_SESSION["hero"], type: PDO::PARAM_STR);
                        $req->bindParam(":aventure_id", $_SESSION["aventure"], type: PDO::PARAM_STR);
                        $req->bindParam(":new_chapter_id", $_POST["choice"], type: PDO::PARAM_STR);
                        $req->execute();

                        header("Location: chapter");
                }
        }
}
