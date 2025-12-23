-- Création de la table Class (Classe des personnages)
DROP TABLE IF EXISTS Class;

CREATE TABLE Class (
    class_id INT AUTO_INCREMENT PRIMARY KEY,
    class_name VARCHAR(50) NOT NULL,
    class_description TEXT,
    class_base_pv INT NOT NULL,
    class_base_mana INT NOT NULL,
    class_base_strength INT NOT NULL,
    class_base_initiative INT NOT NULL,
    class_max_items INT NOT NULL,
    class_img VARCHAR(255)
);

-- Création de la table Items (Objets disponibles dans le jeu)
DROP TABLE IF EXISTS Items;

CREATE TABLE Items (
    item_id INT AUTO_INCREMENT PRIMARY KEY,
    item_name VARCHAR(50) NOT NULL,
    item_description TEXT,
    item_image VARCHAR(255),
    item_type VARCHAR(50) NOT NULL,
    -- Ex: 'Arme', 'Armure', 'Potion', etc.
    item_value INT
);

-- Création de la table Monster (Monstres rencontrés dans l'histoire)
DROP TABLE IF EXISTS Monster;

CREATE TABLE Monster (
    monster_id INT AUTO_INCREMENT PRIMARY KEY,
    monster_name VARCHAR(50) NOT NULL,
    monster_pv INT NOT NULL,
    monster_mana INT,
    monster_initiative INT NOT NULL,
    monster_strength INT NOT NULL,
    monster_attack TEXT,
    monster_spell TEXT,
    -- attaque magique
    monster_xp INT NOT NULL,
    monster_image VARCHAR(255)
);

-- Table intermédiaire pour les butins des monstres (Monster - Items)
-- Permet à un monstre de lâcher plusieurs types d'objets, avec une quantité.
DROP TABLE IF EXISTS Monster_Loot;

CREATE TABLE Monster_Loot (
    monster_id INT,
    item_id INT,
    loot_quantity INT NOT NULL DEFAULT 1,
    loot_drop_rate DECIMAL(3, 2) DEFAULT 1.0 -- Taux de chance de drop (ex: 0.5 pour 50%)
);

-- Création de la table Hero (Personnage principal)
-- Les équipements (armor, weapon, etc.) font référence à des Items.
DROP TABLE IF EXISTS Hero;

CREATE TABLE Hero (
    hero_id INT,
    joueur_pseudo varchar(60),
    class_id INT,
    -- Relation avec Class
    hero_name VARCHAR(30),
    hero_biography TEXT,
    hero_pv INT NOT NULL,
    hero_mana INT NOT NULL,
    hero_strength INT NOT NULL,
    hero_initiative INT NOT NULL,
    hero_armor_item_id INT,
    hero_weapon_item_id INT,
    hero_shield_item_id INT,
    hero_spell_list TEXT DEFAULT NULL,
    hero_xp INT NOT NULL DEFAULT 0,
    hero_level INT DEFAULT 1
);

-- Création de la table Level (Niveaux de progression des classes)
DROP TABLE IF EXISTS Level;

CREATE TABLE Level (
    class_id INT,
    -- Relation avec Class
    level_number INT,
    level_required_xp INT NOT NULL,
    level_pv_bonus INT NOT NULL,
    level_mana_bonus INT NOT NULL,
    level_strength_bonus INT NOT NULL,
    level_initiative_bonus INT NOT NULL
);

-- Création de la table Chapter (Chapitres de l'histoire)
DROP TABLE IF EXISTS Chapter;

CREATE TABLE Chapter (
    aventure_id INT,
    chapter_id INT,
    chapter_content TEXT NOT NULL,
    chapter_image VARCHAR(255)
);

-- Table intermédiaire pour les trésors dans les chapitres (Chapter - Items)
DROP TABLE IF EXISTS Chapter_Treasure;

CREATE TABLE Chapter_Treasure (
    aventure_id INT,
    chapter_id INT,
    item_id INT,
    treasure_quantity INT NOT NULL DEFAULT 1
);

-- Création de la table Encounter (Rencontres dans les chapitres)
DROP TABLE IF EXISTS Encounter;

CREATE TABLE Encounter (
    aventure_id INT,
    chapter_id INT,
    monster_id INT,
    aventure_id_win INT,
    chapter_id_win INT,
    aventure_id_lose INT,
    chapter_id_lose INT
);

-- Table intermédiaire pour l'inventaire des héros (Hero - Items)
DROP TABLE IF EXISTS Inventory;

CREATE TABLE Inventory (
    joueur_pseudo varchar(60),
    hero_id INT,
    item_id INT,
    inventory_quantity INT NOT NULL DEFAULT 1
);

-- Création de la table Links (Liens entre chapitres) A revoir
DROP TABLE IF EXISTS Links;

CREATE TABLE Links (
    link_id INT,
    aventure_id INT,
    chapter_id INT,
    link_aventure_id INT,
    link_chapter_id INT,
    link_description TEXT NOT NULL
);

-- Table intermédiaire pour le suivi de progression (Hero - Chapter)
DROP TABLE IF EXISTS Hero_Progress;

CREATE TABLE Hero_Progress (
    aventure_id INT,
    chapter_id INT,
    joueur_pseudo VARCHAR(60),
    hero_id INT,
    progress_completion_date DATETIME -- Pour marquer quand le chapitre a été terminé
);

-- Création de la table Aventure (Aventure a faire)
DROP TABLE IF EXISTS Aventure;

CREATE TABLE Aventure (
    aventure_id INT AUTO_INCREMENT PRIMARY KEY,
    aventure_name varchar(30),
    aventure_content TEXT NOT NULL,
    aventure_image VARCHAR(255)
);

-- Création de la table Joueur (Utilisateur)
DROP TABLE IF EXISTS Joueur;

CREATE TABLE Joueur (
    joueur_pseudo VARCHAR(60) PRIMARY KEY,
    joueur_mdp VARCHAR(60),
    joueur_image VARCHAR(255) DEFAULT 'img/profiles/default.jpg',
    joueur_admin BOOLEAN DEFAULT 0
);

ALTER TABLE
    Chapter
ADD
    CONSTRAINT pk_Chapter PRIMARY KEY(aventure_id, chapter_id);

ALTER TABLE
    Hero
ADD
    CONSTRAINT pk_Hero PRIMARY KEY(hero_id, joueur_pseudo);

ALTER TABLE
    Hero_Progress
ADD
    CONSTRAINT pk_Hero_Progress PRIMARY KEY(joueur_pseudo, hero_id, aventure_id, chapter_id);

ALTER TABLE
    Inventory
ADD
    CONSTRAINT pk_Inventory PRIMARY KEY(hero_id, item_id);

ALTER TABLE
    Encounter
ADD
    CONSTRAINT pk_Encounter PRIMARY KEY(monster_id, aventure_id, chapter_id);

ALTER TABLE
    Links
ADD
    CONSTRAINT pk_Links PRIMARY KEY(
        link_id,
        aventure_id,
        chapter_id,
        link_aventure_id,
        link_chapter_id
    );

ALTER TABLE
    Chapter_Treasure
ADD
    CONSTRAINT pk_Chapter_Treasure PRIMARY KEY(item_id, aventure_id, chapter_id);

ALTER TABLE
    Level
ADD
    CONSTRAINT pk_Level PRIMARY KEY(level_number, class_id);

ALTER TABLE
    Monster_Loot
ADD
    CONSTRAINT pk_Monster_Loot PRIMARY KEY(item_id, monster_id);

ALTER TABLE
    Monster_Loot
ADD
    CONSTRAINT fk1_Monster_Loot FOREIGN KEY (monster_id) REFERENCES Monster(monster_id);

ALTER TABLE
    Monster_Loot
ADD
    CONSTRAINT fk2_Monster_Loot FOREIGN KEY (item_id) REFERENCES Items(item_id);

ALTER TABLE
    Hero
ADD
    CONSTRAINT fk1_Hero FOREIGN KEY (class_id) REFERENCES Class(class_id);

ALTER TABLE
    Hero
ADD
    CONSTRAINT fk2_Hero FOREIGN KEY (hero_armor_item_id) REFERENCES Items(item_id);

ALTER TABLE
    Hero
ADD
    CONSTRAINT fk3_Hero FOREIGN KEY (hero_weapon_item_id) REFERENCES Items(item_id);

ALTER TABLE
    Hero
ADD
    CONSTRAINT fk4_Hero FOREIGN KEY (hero_shield_item_id) REFERENCES Items(item_id);

ALTER TABLE
    Hero
ADD
    CONSTRAINT fk5_Hero FOREIGN KEY (joueur_pseudo) REFERENCES Joueur(joueur_pseudo);

ALTER TABLE
    Level
ADD
    CONSTRAINT fk_Level FOREIGN KEY (class_id) REFERENCES Class(class_id);

ALTER TABLE
    Hero_Progress
ADD
    CONSTRAINT fk1_Hero_Progress FOREIGN KEY (joueur_pseudo, hero_id) REFERENCES Hero(joueur_pseudo, hero_id);

ALTER TABLE
    Hero_Progress
ADD
    CONSTRAINT fk2_Hero_Progress FOREIGN KEY (aventure_id, chapter_id) REFERENCES Chapter(aventure_id, chapter_id);

ALTER TABLE
    Chapter
ADD
    CONSTRAINT fk1_Chapter FOREIGN KEY (aventure_id) REFERENCES Aventure(aventure_id);

ALTER TABLE
    Chapter_Treasure
ADD
    CONSTRAINT fk1_Chapter_Treasure FOREIGN KEY (aventure_id, chapter_id) REFERENCES Chapter(aventure_id, chapter_id);

ALTER TABLE
    Chapter_Treasure
ADD
    CONSTRAINT fk2_Chapter_Treasure FOREIGN KEY (item_id) REFERENCES Items(item_id);

ALTER TABLE
    Links
ADD
    CONSTRAINT fk1_Links FOREIGN KEY (aventure_id, chapter_id) REFERENCES Chapter(aventure_id, chapter_id);

ALTER TABLE
    Links
ADD
    CONSTRAINT fk2_Links FOREIGN KEY (link_aventure_id, link_chapter_id) REFERENCES Chapter(aventure_id, chapter_id);

ALTER TABLE
    Inventory
ADD
    CONSTRAINT fk1_Inventory FOREIGN KEY (joueur_pseudo, hero_id) REFERENCES Hero(joueur_pseudo, hero_id);

ALTER TABLE
    Inventory
ADD
    CONSTRAINT fk2_Inventory FOREIGN KEY (item_id) REFERENCES Items(item_id);

ALTER TABLE
    Encounter
ADD
    CONSTRAINT fk1_Encounter FOREIGN KEY (aventure_id, chapter_id) REFERENCES Chapter(aventure_id, chapter_id);

ALTER TABLE
    Encounter
ADD
    CONSTRAINT fk2_Encounter FOREIGN KEY (monster_id) REFERENCES Monster(monster_id);

ALTER TABLE
    Encounter
ADD
    CONSTRAINT fk3_Encounter FOREIGN KEY (aventure_id_win, chapter_id_win) REFERENCES Chapter(aventure_id, chapter_id);

ALTER TABLE
    Encounter
ADD
    CONSTRAINT fk4_Encounter FOREIGN KEY (aventure_id_lose, chapter_id_lose) REFERENCES Chapter(aventure_id, chapter_id);

/*
 * Insertions
 */
INSERT INTO
    `Class`(
        `class_name`,
        `class_description`,
        `class_base_pv`,
        `class_base_mana`,
        `class_base_strength`,
        `class_base_initiative`,
        `class_max_items`,
        `class_img`
    )
VALUES
    (
        'Barbare',
        'Force brute incarnée, un guerrier forgé par les terres sauvages et les épreuves impitoyables. Son corps, massif et couvert de cicatrices, témoigne d’une vie passée à survivre là où d’autres périraient. Sa chevelure, souvent longue et indisciplinée, flotte au vent comme une crinière indomptée, et ses yeux brûlent d’une intensité primitive. Armé d’une lourde arme – hache gigantesque, marteau de guerre ou épée à deux mains – il combat avec une rage qui semble jaillir du plus profond de son être. Sa puissance physique dépasse celle des combattants ordinaires : chaque coup qu’il porte résonne avec la force de la terre elle-même. Bien qu’il puisse sembler brutal ou rustre, le barbare possède souvent un code d’honneur personnel : loyauté envers ses compagnons, respect de la nature et dédain pour les artifices de la civilisation. Vivant en harmonie avec la sauvagerie qui l’entoure, il puise sa force dans l’instinct, la liberté et l’indomptable énergie du monde sauvage.',
        100,
        0,
        5,
        2,
        15,
        'img/Barbarian.jpg'
    ),
    (
        'Magicien',
        'Maître des arcanes, un savant dont l’esprit s’aventure là où la plupart n’oseraient même pas poser les yeux. Drapé dans une longue robe ornée de runes mystérieuses, il dégage une aura à la fois sereine et inquiétante, comme si des secrets anciens murmuraient autour de lui.
    Son regard, vif et pénétrant, témoigne d’une intelligence affûtée et d’une curiosité insatiable. Là où le barbare compte sur sa force, le magicien puise sa puissance dans les flux invisibles de la magie : l’énergie du feu, la froideur du givre, les courants de la pensée ou même les forces du cosmos lui obéissent lorsqu’il trace des signes dans l’air.
    Dans sa main, il tient souvent un bâton gravé de symboles ésotériques ou un grimoire poussiéreux rempli de connaissances interdites. Chaque sort qu’il lance est un équilibre délicat entre maîtrise et danger, car la magie est un outil puissant, mais capricieux.
    Sage, mystérieux et parfois distant, le magicien consacre sa vie à comprendre l’incompréhensible. Il sait que le vrai pouvoir ne se mesure pas en muscles ni en richesse, mais en savoir, en patience, et en la capacité de modeler la réalité elle-même.',
        50,
        100,
        1,
        1,
        5,
        'img/Magician01.jpg'
    ),
    (
        'Voleur',
        'Une ombre parmi les ombres, un expert de la discrétion et de la ruse. Agile et silencieux, il se déplace avec la souplesse d’un félin, chaque pas calculé pour ne jamais attirer l’attention. Ses vêtements sombres, souvent renforcés de pièces légères de cuir, lui permettent de se fondre naturellement dans l’obscurité, et un capuchon rabattu sur son visage dissimule ses intentions comme ses traits.
    Ses yeux, vifs et observateurs, ne manquent aucun détail : une serrure fragile, une bourse mal attachée, un passage secret à peine perceptible… rien ne lui échappe. Armé de dagues affûtées ou d’une rapière légère, il privilégie la précision à la force brute, frappant quand l’ennemi ne s’y attend pas.
    Le voleur n’est pas seulement un maître des larcins : c’est aussi un stratège subtil. Bluff, agilité, acrobaties et sens aigu du danger lui permettent de survivre dans les rues les plus malfamées comme dans les couloirs les plus piégés.
    Qu’il soit un aventurier pragmatique, un charmeur insolent ou un hors-la-loi au grand cœur, le voleur vit dans l’équilibre fragile entre liberté et danger, toujours prêt à disparaître avant que quiconque ne comprenne qu’il était là.',
        75,
        50,
        3,
        4,
        10,
        'img/Thief.jpg'
    );

/*Insert items*/
INSERT INTO
    `Items`(
        `item_name`,
        `item_description`,
        `item_image`,
        `item_type`
    )
VALUES
    (
        'Potion de soin',
        'Un puissant breuvage permettant de remettre sur pieds un aventurier blessé',
        'img/healingPotion.jpg',
        'misc'
    ),
    (
        'Casque',
        'Un casque permettant de protéger sa tête',
        'img/Helmet.jpg',
        'armor'
    ),
    (
        'Arbalète',
        'Une arme à distance tirant des carreaux',
        'img/Crossbow.jpg',
        'weapon'
    ),
    (
        'Plastron en métal',
        'Une pauvre plaque de fer à peu près pliée de sorte à protéger son porteur',
        'img/Chestplate.jpg',
        'armor'
    ),
    (
        'epée',
        'lame double et acérée, finement gravée de motifs sinueux d’inspiration gothique. Sa garde, richement ornementée de volutes métalliques et de pointes acérées, lui donne une allure à la fois élégante et menaçante. Le manche gainé de cuir sombre complète l’ensemble, faisant de cette arme une pièce aussi esthétique que redoutable',
        'img/Sword01.jpg',
        'weapon'
    ),
    (
        'Baton magique',
        'Un catalyseur du pouvoir magique des sorciers',
        'img/MagicStaff.jpg',
        'weapon'
    );

/*Niveaux Barbare*/
INSERT INTO
    `Level`(
        `class_id`,
        `level_number`,
        `level_required_xp`,
        `level_pv_bonus`,
        `level_mana_bonus`,
        `level_strength_bonus`,
        `level_initiative_bonus`
    )
VALUES
    (1, 1, 50, 10, 0, 1, 0),
    (1, 2, 100, 20, 0, 1, 0),
    (1, 3, 200, 30, 0, 5, 0),
    (1, 4, 400, 50, 0, 7, 0),
    (1, 5, 800, 60, 0, 9, 1),
    (1, 6, 1600, 70, 0, 11, 0),
    (1, 7, 3200, 80, 0, 13, 0),
    (1, 8, 6400, 90, 0, 15, 0),
    (1, 9, 12800, 100, 0, 17, 0),
    (1, 10, 25600, 150, 0, 19, 1);

/*Niveaux Mage*/
INSERT INTO
    `Level`(
        `class_id`,
        `level_number`,
        `level_required_xp`,
        `level_pv_bonus`,
        `level_mana_bonus`,
        `level_strength_bonus`,
        `level_initiative_bonus`
    )
VALUES
    (2, 1, 50, 1, 5, 0, 0),
    (2, 2, 100, 3, 10, 0, 0),
    (2, 3, 200, 5, 15, 0, 0),
    (2, 4, 400, 7, 20, 0, 0),
    (2, 5, 800, 20, 35, 0, 1),
    (2, 6, 1600, 9, 25, 0, 0),
    (2, 7, 3200, 11, 30, 0, 0),
    (2, 8, 6400, 13, 35, 0, 0),
    (2, 9, 12800, 15, 40, 0, 0),
    (2, 10, 25600, 50, 70, 0, 2);

/*Niveaux Voleur*/
INSERT INTO
    `Level`(
        `class_id`,
        `level_number`,
        `level_required_xp`,
        `level_pv_bonus`,
        `level_mana_bonus`,
        `level_strength_bonus`,
        `level_initiative_bonus`
    )
VALUES
    (3, 1, 50, 10, 1, 1, 1),
    (3, 2, 100, 15, 4, 2, 0),
    (3, 3, 200, 20, 7, 4, 2),
    (3, 4, 400, 25, 10, 6, 0),
    (3, 5, 800, 50, 13, 15, 5),
    (3, 6, 1600, 30, 16, 10, 0),
    (3, 7, 3200, 35, 19, 12, 2),
    (3, 8, 6400, 40, 22, 14, 0),
    (3, 9, 12800, 50, 25, 16, 2),
    (3, 10, 25600, 100, 35, 30, 10);