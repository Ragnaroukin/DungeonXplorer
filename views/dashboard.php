<?php require_once "header.php" ?>
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
                                <a class="nav-link d-flex align-items-center gap-2" href="#treasures">
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
                <h1 class="h2" id="chapters">Chapitres</h1>
                <div class="d-flex flex-nowrap align-items-center pt-3 pb-2 mb-3 border-top w-100 scroll-container">
                    <div class="card">
                        <h3 class="text-nowrap">Chapitre 1</h3>
                        <img src="img/Castle01.jpg" alt="chapitre1">
                    </div>
                </div>
                <h1 class="h2" id="monsters">Monstres</h1>
                <div class="d-flex flex-nowrap align-items-center pt-3 pb-2 mb-3 border-top w-100 scroll-container">
                    <div class="card">
                        <h3 class="text-nowrap">Vampire</h3>
                        <img src="img/Vampire01.jpg" alt="chapitre1">
                    </div>
                </div>
                <h1 class="h2" id="treasures">Objets</h1>
                <div class="d-flex flex-nowrap align-items-center pt-3 pb-2 mb-3 border-top w-100 scroll-container">
                    <div class="card">
                        <h3 class="text-nowrap">Épée 1</h3>
                        <img src="img/Sword01.jpg" alt="chapitre1">
                    </div>
                </div>
                <h1 class="h2" id="hero">Héros</h1>
                <div class="d-flex flex-nowrap align-items-center pt-3 pb-2 mb-3 border-top w-100 scroll-container">
                    <div class="card">
                        <h3 class="text-nowrap">Magicienne</h3>
                        <img src="img/Magician01.jpg" alt="chapitre1">
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
<?php require_once "footer.php" ?>