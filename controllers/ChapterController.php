<?php
class ChapterController
{
    public function index()
    {
        $pdo = Database::getConnection();

        $req = $pdo->prepare("SELECT count(*) as nb FROM Hero_Progress WHERE joueur_pseudo = :pseudo and hero_id = :hero_id and aventure_id = :aventure_id");
        $req->bindParam(":pseudo", $_SESSION["pseudo"], type: PDO::PARAM_STR);
        $req->bindParam(":hero_id", $_SESSION["hero"], type: PDO::PARAM_STR);
        $req->bindParam(":aventure_id", $_SESSION["aventure"], type: PDO::PARAM_STR);
        $req->execute();
        $progress = $req->fetch();

        if ($progress["nb"] == "0") {
            $new = $pdo->prepare("INSERT INTO `Hero_Progress` (`aventure_id`, `chapter_id`, `joueur_pseudo`, `hero_id`, `progress_completion_date`) VALUES (:aventure_id, '0', :pseudo, :hero_id, NOW())");
            $new->bindParam(":pseudo", $_SESSION["pseudo"], type: PDO::PARAM_STR);
            $new->bindParam(":hero_id", $_SESSION["hero"], type: PDO::PARAM_STR);
            $new->bindParam(":aventure_id", $_SESSION["aventure"], type: PDO::PARAM_STR);
            $new->execute();
        }

        $reqProgress = $pdo->prepare("SELECT * FROM Hero_Progress WHERE joueur_pseudo = :pseudo and hero_id = :hero_id and aventure_id = :aventure_id");
        $reqProgress->bindParam(":pseudo", $_SESSION["pseudo"], type: PDO::PARAM_STR);
        $reqProgress->bindParam(":hero_id", $_SESSION["hero"], type: PDO::PARAM_STR);
        $reqProgress->bindParam(":aventure_id", $_SESSION["aventure"], type: PDO::PARAM_STR);
        $reqProgress->execute();

        $progress = $reqProgress->fetch();

        $reqChapter = $pdo->prepare("SELECT * FROM Chapter WHERE aventure_id = :aventure_id and chapter_id = :chapter_id");
        $reqChapter->bindParam(":aventure_id", $_SESSION["aventure"], type: PDO::PARAM_STR);
        $reqChapter->bindParam(":chapter_id", $progress["chapter_id"], type: PDO::PARAM_STR);
        $reqChapter->execute();

        $chapter = $reqChapter->fetch();

        $reqLink = $pdo ->prepare("SELECT * FROM Links where aventure_id = :aventure_id AND chapter_id = :chapter_id");
        $reqLink->bindParam(":aventure_id", $_SESSION["aventure"], type: PDO::PARAM_STR);
        $reqLink->bindParam(":chapter_id", $progress["chapter_id"], type: PDO::PARAM_STR);
        $reqLink->execute();
        
        $links = $reqLink->fetchAll();

        require_once 'views/chapter.php';
    }
}