<?php
class ChapterController
{
        public function index()
        {
                $pdo = Database::getConnection();

                $req = $pdo->prepare("SELECT chapter_image, chapter_content, link_chapter_id,link_description 
                                                FROM Hero_Progress 
                                                JOIN Chapter USING (aventure_id, chapter_id) 
                                                JOIN Links USING (aventure_id, chapter_id)
                                        WHERE joueur_pseudo = :pseudo 
                                        and hero_id = :hero_id
                                        and aventure_id = :aventure_id");
                $req->bindParam(":pseudo", $_SESSION["pseudo"], type: PDO::PARAM_STR);
                $req->bindParam(":hero_id", $_SESSION["hero"], type: PDO::PARAM_STR);
                $req->bindParam(":aventure_id", $_SESSION["aventure"], type: PDO::PARAM_STR);
                $req->execute();

                $data = $req->fetchAll();

                require_once 'views/chapter.php';
        }

        public function progress()
        {
                $pdo = Database::getConnection();

                $req = $pdo->prepare("UPDATE `Hero_Progress` SET `chapter_id` = :new_chapter_id WHERE `Hero_Progress`.`aventure_id` = :aventure_id AND `Hero_Progress`.`joueur_pseudo` = :pseudo AND `Hero_Progress`.`hero_id` = :hero_id");
                $req->bindParam(":pseudo", $_SESSION["pseudo"], type: PDO::PARAM_STR);
                $req->bindParam(":hero_id", $_SESSION["hero"], type: PDO::PARAM_STR);
                $req->bindParam(":aventure_id", $_SESSION["aventure"], type: PDO::PARAM_STR);
                $req->bindParam(":new_chapter_id", $_POST["choice"], type: PDO::PARAM_STR);

                $req->execute();

                header("Location: chapter");
        }
}