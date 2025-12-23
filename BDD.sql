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
    ),
    (
        'Potion de mana',
        'Une boisson pour récupérer de la magie',
        '/img/Potions.jpg',
        'misc');

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

-- ==========================================================
-- INSERTION DE L'AVENTURE
-- ==========================================================
INSERT INTO
        Aventure (aventure_name, aventure_content, aventure_image)
VALUES
        (
                'Sauver la fille',
                'Une quête périlleuse pour retrouver la fille du bourgmestre disparue dans la forêt du Val Perdu.',
                'img/chap'
        );

-- ==========================================================
-- INSERTION DES CHAPITRES (0 à 48)
-- ==========================================================
INSERT INTO
        Chapter (
                aventure_id,
                chapter_id,
                chapter_content,
                chapter_image
        )
VALUES
        (
                1,
                0,
                'Bienvenue au Val Perdu. Votre destin commence ici, devant la taverne du village.',
                'img/chap0.jpg'
        ),
        (
                1,
                1,
                'Introduction : Le ciel est lourd. Le bourgmestre vous supplie de retrouver sa fille enlevée par un sorcier dans un château en ruines.',
                'img/chap1.jpg'
        ),
        (
                1,
                2,
                'L\'orée de la forêt : Un vent froid glisse entre les arbres. Deux chemins s\'offrent à vous : un sinueux ou un envahi de ronces.',
                'img/chap2.jpg'
        ),
        (
                1,
                3,
                'L\'arbre aux corbeaux : Des oiseaux noirs vous observent. Vous ressentez la présence d\'un prédateur proche.',
                'img/chap3.jpg'
        ),
        (
                1,
                4,
                'Combat : Un énorme sanglier enragé aux yeux injectés de sang surgit des buissons et vous charge brutalement.',
                'img/forestFight.jpg'
        ),
        (
                1,
                5,
                'Rencontre avec le paysan : Un vieil homme vous avertit que des créatures rôdent la nuit au cœur de la forêt.',
                'img/chap5.jpg'
        ),
        (
                1,
                6,
                'Combat : Un loup noir aux crocs acérés bondit devant vous. Le combat est inévitable pour survivre.',
                'img/forestFight.jpg'
        ),
        (
                1,
                7,
                'La clairière aux pierres anciennes : Une brume rampe au sol entre des pierres dressées comme un autel oublié.',
                'img/chap7.jpg'
        ),
        (
                1,
                8,
                'Les murmures du ruisseau : Le chant de l\'eau cache des inscriptions anciennes gravées dans une pierre moussue.',
                'img/chap8.jpg'
        ),
        (
                1,
                9,
                'Au pied du château : Devant vous se dresse une colline escarpée couronnée par les ruines menaçantes de la forteresse.',
                'img/chap9.jpg'
        ),
        (
                1,
                10,
                'La lumière au bout du néant : L\'obscurité vous enveloppe. Une voix murmure qu\'une seconde chance vous est accordée, mais sans vos objets.',
                'img/chap10.jpg'
        ),
        (
                1,
                11,
                'La curiosité tua le chat : Un piège magique s\'est déclenché sur la pierre. Le monde s\'effondre autour de vous.',
                'img/chap11.jpg'
        ),
        (
                1,
                12,
                'Le Réduit des Sentinelles : Vous avez atteint une guérite isolée. C\'est un endroit sûr pour planifier l\'infiltration.',
                'img/chap12.jpg'
        ),
        (
                1,
                13,
                'La Traversée de la Cour Ouest : Les débris jonchent le sol. Une patrouille approche, il faut agir vite.',
                'img/chap13.jpg'
        ),
        (
                1,
                14,
                'Le Couloir de la Peur : Un tunnel étroit exhalant une odeur de moisissure. Des symboles brillent d\'une lueur verte.',
                'img/chap14.jpg'
        ),
        (
                1,
                15,
                'Le Piège de la Dalle : Une pierre suspecte semble protéger l\'accès au palier. Une erreur pourrait être fatale.',
                'img/chap15.jpg'
        ),
        (
                1,
                16,
                'Combat : L\'escarmouche nocturne contre un molosse noir aux yeux rouges protégeant l\'accès intérieur.',
                'img/ruinsFight.jpg'
        ),
        (
                1,
                17,
                'Repos du Guerrier : Une alcôve vous permet de panser vos plaies et de préparer la suite de l\'ascension.',
                'img/chap17.jpg'
        ),
        (
                1,
                18,
                'Les Marches de la Crypte : Un escalier décrépit descend vers les profondeurs. L\'air devient glacial.',
                'img/chap18.jpg'
        ),
        (
                1,
                19,
                'Le Dédale des Morts : Des runes pulsantes sur les murs déforment les ombres. Sont-elles protectrices ou maudites?',
                'img/chap19.jpg'
        ),
        (
                1,
                20,
                'Combat : Le réveil des gardiens squelettiques qui sortent du sol pour bloquer votre progression dans les catacombes.',
                'img/labyrinthFight.jpg'
        ),
        (
                1,
                21,
                'Le Mur Illusoire : Une paroi de pierre semble vibrer. La magie du sorcier tente de vous égarer.',
                'img/chap21.jpg'
        ),
        (
                1,
                22,
                'Le Trésor Maudit : Une amulette de jade repose sur un autel. Elle dégage une aura de puissance et de danger.',
                'img/chap22.jpg'
        ),
        (
                1,
                23,
                'L\'Issue Scellée : Une immense porte de granit bloque le passage. Elle semble fermée par un mécanisme ancien.',
                'img/chap23.jpg'
        ),
        (
                1,
                24,
                'L\'Arsenal Oublié : Une salle remplie d\'armures en poussière. Vous avez trouvé un point de sécurité stratégique.',
                'img/chap24.jpg'
        ),
        (
                1,
                25,
                'L\'Erreur Fatale : Une vapeur toxique s\'échappe du puits que vous inspectiez. Vos forces vous abandonnent.',
                'img/chap25.jpg'
        ),
        (
                1,
                26,
                'Combat : Deux esprits de soldats fantomatiques se matérialisent pour protéger l\'accès aux étages supérieurs.',
                'img/stairsFight.jpg'
        ),
        (
                1,
                27,
                'La Discrétion Payante : Vous utilisez les tunnels de service pour contourner les gardes restants.',
                'img/chap27.jpg'
        ),
        (
                1,
                28,
                'Combat : Le duel contre le champion spectral. Chaque coup d\'épée résonne dans le vide de la salle.',
                'img/chap28.jpg'
        ),
        (
                1,
                29,
                'Découverte du Plan : Vous trouvez une carte du château indiquant les points faibles des défenses du sorcier.',
                'img/chap29.jpg'
        ),
        (
                1,
                30,
                'Les Balcons Intérieurs : Vous dominez la cour. Les appartements privés du sorcier ne sont plus loin.',
                'img/chap30.jpg'
        ),
        (
                1,
                31,
                'La Retraite Nécessaire : Trop de gardes ont été alertés. Vous devez fuir vers l\'entrée pour survivre.',
                'img/chap31.jpg'
        ),
        (
                1,
                32,
                'Les Illusions Mobiles : La réalité se fragmente. Les murs semblent bouger pour vous emmurer vivant.',
                'img/chap32.jpg'
        ),
        (
                1,
                33,
                'Le Serviteur Apeuré : Un vieil homme terrifié peut vous livrer les secrets de son maître ou vous trahir.',
                'img/chap33.jpg'
        ),
        (
                1,
                34,
                'Les Fils d\'Arcane : Des pièges magiques invisibles quadrillent la pièce. Un mouvement brusque déclenchera l\'alarme.',
                'img/chap34.jpg'
        ),
        (
                1,
                35,
                'Le Journal du Sorcier : Des notes personnelles révèlent le rituel de sacrifice et une faille dans sa magie.',
                'img/chap35.jpg'
        ),
        (
                1,
                36,
                'La Salle d\'Observation : Vous voyez le sorcier au loin. Le rituel a commencé. C\'est votre dernier répit.',
                'img/chap36.jpg'
        ),
        (
                1,
                37,
                'Le Seuil de la Confrontation : L\'antichambre vibre d\'énergie noire. Le sorcier vous attend pour le duel final.',
                'img/chap37.jpg'
        ),
        (
                1,
                38,
                'Les Révélations Audibles : Vous comprenez enfin le but ultime du sorcier en écoutant ses incantations.',
                'img/chap38.jpg'
        ),
        (
                1,
                39,
                'L\'Aiguisage des Sens : Un moment de concentration extrême avant de franchir la porte du trône.',
                'img/chap39.jpg'
        ),
        (
                1,
                40,
                'Le Dernier Pas : La porte s\'ouvre. La captive est enchaînée derrière l\'autel sacrificiel.',
                'img/chap40.jpg'
        ),
        (
                1,
                41,
                'Le Raccourci Payant : Grâce à vos talents, vous avez trouvé un passage secret menant directement au boss.',
                'img/chap41.jpg'
        ),
        (
                1,
                42,
                'Combat : Le duel arcanique commence. Le sorcier déchaîne des éclairs d\'énergie pure contre vous.',
                'img/mageFight.jpg'
        ),
        (
                1,
                43,
                'Le Contre de l\'Expert : Vous esquivez et trouvez une ouverture dans la défense magique de votre ennemi.',
                'img/chap43.jpg'
        ),
        (
                1,
                44,
                'L\'Exploitation de l\'Environnement : Vous utilisez les piliers de la salle pour déstabiliser le rituel en cours.',
                'img/chap44.jpg'
        ),
        (
                1,
                45,
                'Le Coup Désespéré : Le sorcier lance ses dernières flammes sombres. C\'est maintenant ou jamais.',
                'img/chap45.jpg'
        ),
        (
                1,
                46,
                'Combat : La chute du tyran. Le sorcier s\'effondre et son pouvoir se dissipe dans un cri agonisant.',
                'img/mageFight.jpg'
        ),
        (
                1,
                47,
                'Le Succès et la Récompense : La fille est libre. Vous devez choisir votre récompense finale avant de partir.',
                'img/chap47.jpg'
        ),
        (
                1,
                48,
                'La Vanité Punie : Votre tentative de négociation a échoué. Le sorcier ne connaît aucune pitié.',
                'img/chap48.jpg'
        );

-- ==========================================================
-- INSERTION DES LIENS (LINKS)
-- ==========================================================
INSERT INTO
        Links (
                link_id,
                aventure_id,
                chapter_id,
                link_aventure_id,
                link_chapter_id,
                link_description
        )
VALUES
        (1, 1, 0, 1, 1, 'Commencer l\'aventure'),
        (2, 1, 1, 1, 2, 'S\'enfoncer dans la forêt'),
        (3, 1, 2, 1, 3, 'Prendre le chemin sinueux'),
        (4, 1, 2, 1, 4, 'Prendre le sentier de ronces'),
        (5, 1, 3, 1, 5, 'Rester prudent'),
        (6, 1, 3, 1, 6, 'Ignorer les bruits'),
        (7, 1, 4, 1, 8, 'Vaincre le sanglier'),
        (8, 1, 4, 1, 10, 'Succomber au sanglier'),
        (9, 1, 5, 1, 7, 'Continuer vers la clairière'),
        (10, 1, 6, 1, 7, 'Survivre au loup'),
        (11, 1, 6, 1, 10, 'Mourir sous les crocs'),
        (12, 1, 7, 1, 8, 'Prendre le sentier de mousse'),
        (13, 1, 7, 1, 9, 'Suivre les racines'),
        (14, 1, 8, 1, 11, 'Toucher la pierre gravée'),
        (15, 1, 8, 1, 9, 'Ignorer la pierre'),
        (16, 1, 9, 1, 12, 'Entrer dans le château'),
        (17, 1, 10, 1, 1, 'Renaître au début'),
        (18, 1, 11, 1, 10, 'Sombrer dans le vide'),
        (19, 1, 12, 1, 13, 'Passer par la cour'),
        (20, 1, 12, 1, 14, 'Prendre le passage dérobé'),
        (21, 1, 13, 1, 15, 'Se cacher dans les gravats'),
        (22, 1, 13, 1, 16, 'Détourner l\'attention'),
        (23, 1, 14, 1, 16, 'Ignorer les symboles'),
        (24, 1, 14, 1, 17, 'Se reposer dans le tunnel'),
        (25, 1, 15, 1, 17, 'Analyser la dalle'),
        (26, 1, 15, 1, 18, 'Traverser rapidement'),
        (27, 1, 16, 1, 17, 'Se soigner après le combat'),
        (28, 1, 16, 1, 18, 'Continuer vers la crypte'),
        (29, 1, 17, 1, 18, 'Partir à l\'aube'),
        (30, 1, 17, 1, 18, 'Fouiller l\'alcôve'),
        (31, 1, 18, 1, 19, 'Descendre l\'escalier'),
        (30, 1, 18, 1, 25, 'Inspecter le puits'),
        (31, 1, 19, 1, 20, 'Décrypter les glyphes'),
        (32, 1, 19, 1, 21, 'Se presser vers l\'avant'),
        (33, 1, 20, 1, 22, 'Engager le combat'),
        (34, 1, 20, 1, 23, 'Contourner les squelettes'),
        (35, 1, 21, 1, 23, 'Dissiper l\'illusion'),
        (36, 1, 21, 1, 24, 'Forcer le mur'),
        (37, 1, 22, 1, 23, 'Prendre l\'amulette'),
        (38, 1, 22, 1, 24, 'Laisser le trésor'),
        (39, 1, 23, 1, 24, 'Forcer la porte'),
        (40, 1, 23, 1, 24, 'Écouter aux portes'),
        (41, 1, 24, 1, 26, 'Vers le centre du château'),
        (42, 1, 24, 1, 31, 'Faire une reconnaissance'),
        (43, 1, 25, 1, 10, 'Lutter contre le poison'),
        (44, 1, 25, 1, 10, 'Accepter la mort'),
        (45, 1, 26, 1, 27, 'Approche furtive'),
        (46, 1, 26, 1, 28, 'Attaque frontale'),
        (47, 1, 27, 1, 29, 'Écouter aux portes'),
        (48, 1, 27, 1, 30, 'Foncer vers la sortie'),
        (49, 1, 28, 1, 29, 'Déblayer les gravats'),
        (50, 1, 28, 1, 30, 'Trouver un autre accès'),
        (51, 1, 29, 1, 30, 'Étudier le plan'),
        (52, 1, 29, 1, 30, 'Partir immédiatement'),
        (53, 1, 30, 1, 32, 'Prendre l\'escalier privé'),
        (54, 1, 30, 1, 41, 'Utiliser la porte sculptée'),
        (55, 1, 31, 1, 12, 'Repli vers la guérite'),
        (56, 1, 31, 1, 12, 'Chercher de l\'aide'),
        (57, 1, 32, 1, 33, 'Dissiper les visions'),
        (58, 1, 32, 1, 34, 'Frapper le vide'),
        (59, 1, 33, 1, 35, 'Interroger le serviteur'),
        (60, 1, 33, 1, 36, 'Ignorer le vieillard'),
        (61, 1, 34, 1, 35, 'Désactiver les fils'),
        (62, 1, 34, 1, 36, 'Tenter un saut agile'),
        (63, 1, 35, 1, 36, 'Lire le journal'),
        (64, 1, 35, 1, 36, 'Brûler les preuves'),
        (65, 1, 36, 1, 38, 'Attaquer par surprise'),
        (66, 1, 36, 1, 39, 'Se reposer une dernière fois'),
        (67, 1, 37, 1, 42, 'Assaut frontal'),
        (68, 1, 37, 1, 48, 'Tenter de raisonner'),
        (69, 1, 38, 1, 40, 'Se préparer à l\'embuscade'),
        (70, 1, 38, 1, 39, 'Contourner la salle'),
        (71, 1, 39, 1, 40, 'Améliorer son offensive'),
        (72, 1, 39, 1, 37, 'Aller au duel'),
        (73, 1, 40, 1, 37, 'Entrer silencieusement'),
        (74, 1, 40, 1, 37, 'Défoncer la porte'),
        (75, 1, 41, 1, 37, 'Entrer immédiatement'),
        (76, 1, 41, 1, 37, 'Prendre une pause'),
        (77, 1, 42, 1, 43, 'Plonger sur le côté'),
        (78, 1, 42, 1, 44, 'Charger malgré l\'éclair'),
        (79, 1, 43, 1, 45, 'Presser l\'attaque'),
        (80, 1, 43, 1, 46, 'Se soigner rapidement'),
        (81, 1, 44, 1, 45, 'Cibler la faille au sol'),
        (82, 1, 44, 1, 46, 'Focaliser sur le sorcier'),
        (83, 1, 45, 1, 46, 'Bloquer le coup final'),
        (84, 1, 45, 1, 46, 'Donner le coup de grâce'),
        (85, 1, 46, 1, 47, 'Secourir la captive'),
        (86, 1, 46, 1, 47, 'Prendre les artefacts'),
        (89, 1, 48, 1, 10, 'Accepter son sort'),
        (90, 1, 48, 1, 10, 'Action désespérée');

INSERT INTO `Monster` (`monster_name`, `monster_pv`, `monster_mana`, `monster_initiative`, `monster_strength`, `monster_attack`, `monster_spell`, `monster_xp`, `monster_image`) VALUES
(0,'Sanglier', 5, 0, 4, 10, 'Charge', NULL, 10, '/img/Wild boar.jpg'),
(1,'Loup', 15, NULL, 8, 15, 'Morsure', NULL, 15, '/img/Wolf02.jpg'),
(2,'Manticore', 30, 20, 10, 5, 'Brulure', 'Boule de feu - 10', 25, '/img/Manticore.jpg'),
(3, 'Squelette', 50, NULL, 6, 10, 'Coup d\'épée', NULL, 10, '/img/Skeleton.png'),
(4, 'Guerrier maléfique', 100, 25, 10, 20, 'Frappe lourde', 'Peur bleue - 15', 30, '/img/Evil warrior.jpg'),
(5, 'Sorcier', 200, 100, 8, 75, 'Coup de spectre', 'Ténébres - 25', 50, '/img/Wizard.jpg');


INSERT INTO `Encounter` (`aventure_id`, `chapter_id`, `monster_id`, `aventure_id_win`, `chapter_id_win`, `aventure_id_lose`, `chapter_id_lose`) VALUES
(1, 4, 0, 1, 8, 1, 17),
(1, 6, 1, 1, 7, 1, 17),
(1, 16, 2, 1, 18, 1, 10),
(1, 20, 3, 1, 22, 1, 10),
(1, 28, 4, 1, 29, 1, 10),
(1, 42, 5, 1, 43, 1, 10);

INSERT INTO `Monster_Loot` (`monster_id`, `item_id`, `loot_quantity`, `loot_drop_rate`) VALUES
(0, 2, 1, 0.05),
(4, 3, 1, 0.15),
(3, 4, 1, 0.25),
(1, 5, 1, 0.10),
(5, 6, 1, 1.00),
(2, 7, 3, 0.50);

INSERT INTO `Chapter_Treasure` (`aventure_id`, `chapter_id`, `item_id`, `treasure_quantity`) VALUES
(1, 5, 1, 3),
(1, 19, 1, 2),
(1, 29, 2, 1),
(1, 24, 3, 1),
(1, 15, 4, 1),
(1, 9, 5, 1),
(1, 40, 5, 1),
(1, 35, 7, 4);