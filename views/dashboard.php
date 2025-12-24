<div class="container-fluid">
    <div class="row">
        <div class="sidebar border border-right col-md-3 col-lg-2 p-0" id="sidebarMenu">
            <div class="offcanvas-md offcanvas-end" tabindex="-1" aria-labelledby="sidebarMenuLabel">
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
                                <a class="nav-link d-flex align-items-center gap-2" href="#player">
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
                    <h1 id="chapters">Chapitres</h1>
                    <div>
                        <button type="button" class="btn btn-warning">Ajouter</button>
                        <button type="button" class="btn btn-outline-secondary">Voir tout</button>
                    </div>
                </div>
                <div class="d-flex flex-nowrap align-items-center pt-3 pb-2 mb-3 border-top w-100 scroll-container">
                    <?php foreach ($chapters as $chapter) { ?>
                        <div class="card">
                            <h3 class="text-nowrap">Chapitre <?= $chapter["chapter_id"] ?></h3>
                            <img src="<?= url($chapter["chapter_image"]) ?>" alt="img">
                        </div>
                    <?php } ?>
                </div>
                <div class="d-flex justify-content-between mb-3 w-100">
                    <h1 id="chapters">Monstres</h1>
                    <div>
                        <button type="button" class="btn btn-warning">Ajouter</button>
                        <button type="button" class="btn btn-outline-secondary">Voir tout</button>
                    </div>
                </div>
                <div class="d-flex flex-nowrap align-items-center pt-3 pb-2 mb-3 border-top w-100 scroll-container">
                    <?php foreach ($monsters as $monster) { ?>
                        <div class="card">
                            <h3 class="text-nowrap"><?= $monster["monster_name"] ?></h3>
                            <img src="<?= url($monster["monster_image"]) ?>" alt="img">
                        </div>
                    <?php } ?>
                </div>
                <div class="d-flex justify-content-between mb-3 w-100">
                    <h1 id="chapters">Objets</h1>
                    <div>
                        <button type="button" class="btn btn-warning">Ajouter</button>
                        <button type="button" class="btn btn-outline-secondary">Voir tout</button>
                    </div>
                </div>
                <div class="d-flex flex-nowrap align-items-center pt-3 pb-2 mb-3 border-top w-100 scroll-container">
                    <?php foreach ($items as $item) { ?>
                        <div class="card">
                            <h3 class="text-nowrap"><?= $item["item_name"] ?></h3>
                            <img src="<?= url($item["item_image"]) ?>" alt="img">
                        </div>
                    <?php } ?>
                </div>
                <div class="d-flex justify-content-between mb-3 w-100">
                    <h1 id="chapters">Héros</h1>
                    <div>
                        <button type="button" class="btn btn-warning">Ajouter</button>
                        <button type="button" class="btn btn-outline-secondary">Voir tout</button>
                    </div>
                </div>
                <div class="d-flex flex-nowrap align-items-center pt-3 pb-2 mb-3 border-top w-100 scroll-container">
                    <?php foreach ($classes as $class) { ?>
                        <div class="card">
                            <h3 class="text-nowrap"><?= $class["class_name"] ?></h3>
                            <img src="<?= url($class["class_img"]) ?>" alt="img">
                        </div>
                    <?php } ?>
                </div>
                <div class="d-flex justify-content-between mb-3 w-100">
                    <h1 id="player">Joueurs</h1>
                </div>
                <div
                    class="d-flex flex-nowrap align-items-center pt-3 pb-2 mb-3 border-top w-100 scroll-container gap-3">
                    <?php foreach ($accounts as $account) { ?>
                        <div class="choose-card">
                            <div class="choose-header">
                                <h2 class="text-nowrap"><?= $account['joueur_pseudo'] ?></h2>
                            </div>
                            <img class="choose-img" src=<?= url($account["joueur_image"]) ?>>
                            <form action=<?= url("admin/profile") ?> method="post">
                                <input type="hidden" id="pseudo" name="pseudo" value=<?= $account["joueur_pseudo"] ?>>
                                <input class="choose-btn" type="submit" value="Voir Profil">
                            </form>
                            <form action=<?= url("admin/profile/delete") ?> method="post">
                                <input type="hidden" id="pseudo" name="pseudo" value=<?= $account["joueur_pseudo"] ?>>
                                <input class="btn btn-lg btn-danger mt-1" type="submit" value="Supprimer">
                            </form>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </main>
    </div>
</div>
