<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=DungeonXplorer","root", "");
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
} 
require_once "header.php" 
?>
<div class="container-fluid">
    <div class="row">
        <div class="sidebar border border-right col-md-3 col-lg-2 p-0 bg-body-tertiary" id="sidebarMenu">
            <div class="offcanvas-md offcanvas-end bg-body-tertiary" tabindex="-1" aria-labelledby="sidebarMenuLabel">
                <div class="offcanvas-body d-md-flex flex-column p-0 pt-lg-3 overflow-y-auto" id="div-dashboard">
                    <h2 id="titre-dashboard">
                        <i class="fa-solid fa-dungeon"></i>
                        Dashboard
                    </h2>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <h3>
                                <a class="nav-link d-flex align-items-center gap-2" href="#chapters">
                                    <i class="fa-solid fa-book-bookmark"></i>
                                    Chapitres
                                </a>
                            </h3>
                        </li>
                        <li class="nav-item">
                            <h3>
                                <a class="nav-link d-flex align-items-center gap-2" href="#monsters">
                                    <i class="fa-solid fa-dragon"></i>
                                    Monstres
                                </a>
                            </h3>
                        </li>
                        <li class="nav-item">
                            <h3>
                                <a class="nav-link d-flex align-items-center gap-2" href="#objects">
                                    <i class="fa-solid fa-gem"></i>
                                    Objets
                                </a>
                            </h3>
                        </li>
                        <li class="nav-item">
                            <h3>
                                <a class="nav-link d-flex align-items-center gap-2" href="#hero">
                                    <i class="fa-solid fa-shield-halved"></i>
                                    Héros
                                </a>
                            </h3>
                        </li>
                        <hr>
                        <li class="nav-item">
                            <h3>
                                <a class="nav-link d-flex align-items-center gap-2" href="#">
                                    <i class="fa-solid fa-user"></i>
                                    Joueurs
                                </a>
                            </h3>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div
                class="d-flex flex-column justify-content-between flex-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom w-100">
                <div class="d-flex justify-content-between mb-3 w-100">
                    <h1 class="h2" id="chapters">Chapitres</h1>
                    <div>
                        <a href="admin/add/chapter"><button type="button" class="btn btn-warning">Ajouter</button></a>
                        <button type="button" class="btn btn-outline-secondary">Voir tout</button>
                    </div>
                </div>
                <div class="d-flex flex-nowrap align-items-center pt-3 pb-2 mb-3 border-top w-100 scroll-container">
                    <?php
                    $sql = "SELECT chapter_id, chapter_num, chapter_image FROM `Chapter`";

                    $stmt = $pdo->prepare($sql);
                    $stmt->execute();

                    $chapters = $stmt->fetchAll(PDO::FETCH_ASSOC);   // tableau de tableaux associatifs
                    
                    foreach ($chapters as $chapter) {
                    ?>
                    <div class="card">
                        <h3 class="text-nowrap">Chapitre <?php echo $chapter["chapter_num"] ?></h3>
                        <img src="<?php echo $chapter["chapter_image"] ?>" alt="img">
                    </div>
                    <?php } ?>
                </div>
                <div class="d-flex justify-content-between mb-3 w-100">
                    <h1 class="h2" id="monsters">Monstres</h1>
                    <div>
                        <a href="admin/add/monster"><button type="button" class="btn btn-warning">Ajouter</button></a>
                        <button type="button" class="btn btn-outline-secondary">Voir tout</button>
                    </div>
                </div>
                <div class="d-flex flex-nowrap align-items-center pt-3 pb-2 mb-3 border-top w-100 scroll-container">
                    <?php
                    $sql = "SELECT monster_name, monster_image FROM `Monster`";

                    $stmt = $pdo->prepare($sql);
                    $stmt->execute();

                    $monsters = $stmt->fetchAll(PDO::FETCH_ASSOC);   // tableau de tableaux associatifs
                    
                    foreach ($monsters as $monster) {
                    ?>
                    <div class="card">
                        <h3 class="text-nowrap"><?php echo $monster["monster_name"] ?></h3>
                        <img src="<?php echo $monster["monster_image"] ?>" alt="img">
                    </div>
                    <?php } ?>
                </div>
                <div class="d-flex justify-content-between mb-3 w-100">
                    <h1 class="h2" id="objects">Objets</h1>
                    <div>
                        <a href="admin/add/item"><button type="button" class="btn btn-warning">Ajouter</button></a>
                        <button type="button" class="btn btn-outline-secondary">Voir tout</button>
                    </div>
                </div>
                <div class="d-flex flex-nowrap align-items-center pt-3 pb-2 mb-3 border-top w-100 scroll-container">
                    <?php
                    $sql = "SELECT item_name, item_image FROM `Items`";

                    $stmt = $pdo->prepare($sql);
                    $stmt->execute();

                    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);   // tableau de tableaux associatifs
                    
                    foreach ($items as $item) {
                    ?>
                    <div class="card">
                        <h3 class="text-nowrap"><?php echo $item["item_name"] ?></h3>
                        <img src="<?php echo $item["item_image"] ?>" alt="img">
                    </div>
                    <?php } ?>
                </div>
                <div class="d-flex justify-content-between mb-3 w-100">
                    <h1 class="h2" id="hero">Héros</h1>
                    <div>
                        <a href="admin/add/class"><button type="button" class="btn btn-warning">Ajouter</button></a>
                        <button type="button" class="btn btn-outline-secondary">Voir tout</button>
                    </div>
                </div>
                <div class="d-flex flex-nowrap align-items-center pt-3 pb-2 mb-3 border-top w-100 scroll-container">
                    <?php
                    $sql = "SELECT class_name, class_img FROM `Class`";

                    $stmt = $pdo->prepare($sql);
                    $stmt->execute();

                    $classes = $stmt->fetchAll(PDO::FETCH_ASSOC);   // tableau de tableaux associatifs
                    
                    foreach ($classes as $class) {
                    ?>
                    <div class="card">
                        <h3 class="text-nowrap"><?php echo $class["class_name"] ?></h3>
                        <img src="<?php echo $class["class_img"] ?>" alt="img">
                    </div>
                    <?php } ?>
                </div>
            </div>
        </main>
    </div>
</div>
<?php require_once "footer.php" ?>