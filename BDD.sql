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
<<<<<<< HEAD
    class_max_items INT NOT NULL
=======
    class_max_items INT NOT NULL,
    class_img VARCHAR(255)
>>>>>>> Chapitre
);

-- Création de la table Items (Objets disponibles dans le jeu)
DROP TABLE IF EXISTS Items;
CREATE TABLE Items (
    item_id INT AUTO_INCREMENT PRIMARY KEY,
    item_name VARCHAR(50) NOT NULL,
    item_description TEXT,
    item_image VARCHAR(255),
    item_type VARCHAR(50) NOT NULL -- Ex: 'Arme', 'Armure', 'Potion', etc.
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
    loot_drop_rate DECIMAL(5, 2) DEFAULT 1.0 -- Taux de chance de drop (ex: 0.5 pour 50%)
);

-- Création de la table Hero (Personnage principal)
-- Les équipements (armor, primary_weapon, etc.) font référence à des Items.
DROP TABLE IF EXISTS Hero;
CREATE TABLE Hero (
    hero_id INT AUTO_INCREMENT PRIMARY KEY,
<<<<<<< HEAD
    joueur_id INT,
    hero_name VARCHAR(50) NOT NULL,
    class_id INT, -- Relation avec Class
    hero_image VARCHAR(255),
    hero_biography TEXT,
=======
    joueur_pseudo varchar(60),
    class_id INT, -- Relation avec Class
>>>>>>> Chapitre
    hero_pv INT NOT NULL,
    hero_mana INT NOT NULL,
    hero_strength INT NOT NULL,
    hero_initiative INT NOT NULL,
    
    hero_armor_item_id INT,
    hero_primary_weapon_item_id INT,
    hero_secondary_weapon_item_id INT,
    hero_shield_item_id INT,
    
<<<<<<< HEAD
    hero_spell_list TEXT,
    hero_xp INT NOT NULL,
=======
    hero_spell_list TEXT DEFAULT NULL,
    hero_xp INT NOT NULL DEFAULT 0,
>>>>>>> Chapitre
    hero_level INT DEFAULT 1
);

-- Création de la table Level (Niveaux de progression des classes)
DROP TABLE IF EXISTS Level;
CREATE TABLE Level (
    class_id INT, -- Relation avec Class
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
<<<<<<< HEAD
    chapter_image VARCHAR(255)
=======
    chapter_img VARCHAR(255)
>>>>>>> Chapitre
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
    monster_id INT
);

-- Table intermédiaire pour l'inventaire des héros (Hero - Items)
DROP TABLE IF EXISTS Inventory;
CREATE TABLE Inventory (
    hero_id INT,
    item_id INT,
    inventory_quantity INT NOT NULL DEFAULT 1
);

-- Création de la table Links (Liens entre chapitres) A revoir
DROP TABLE IF EXISTS Links;
CREATE TABLE Links (
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
    aventure_content TEXT NOT NULL,
    aventure_image VARCHAR(255)
);

-- Création de la table Joueur (Utilisateur)
DROP TABLE IF EXISTS Joueur;
CREATE TABLE Joueur (
    joueur_pseudo VARCHAR(60) PRIMARY KEY,
    joueur_mdp VARCHAR(60),
    joueur_admin BOOLEAN DEFAULT 0
);

ALTER TABLE Chapter ADD CONSTRAINT pk_Chapter PRIMARY KEY(aventure_id,chapter_id);
ALTER TABLE Hero_Progress ADD CONSTRAINT pk_Hero_Progress PRIMARY KEY(joueur_id,hero_id,aventure_id,chapter_id);
ALTER TABLE Inventory ADD CONSTRAINT pk_Inventory PRIMARY KEY(hero_id,item_id);
ALTER TABLE Encounter ADD CONSTRAINT pk_Encounter PRIMARY KEY(monster_id,aventure_id,chapter_id);
ALTER TABLE Links ADD CONSTRAINT pk_Links PRIMARY KEY(aventure_id,chapter_id, link_aventure_id, link_chapter_id);
ALTER TABLE Chapter_Treasure ADD CONSTRAINT pk_Chapter_Treasure PRIMARY KEY(item_id,aventure_id,chapter_id);
ALTER TABLE Level ADD CONSTRAINT pk_Level PRIMARY KEY(level_number,class_id);
ALTER TABLE Monster_Loot ADD CONSTRAINT pk_Monster_Loot PRIMARY KEY(item_id,monster_id);

ALTER TABLE Monster_Loot ADD CONSTRAINT fk1_Monster_Loot FOREIGN KEY (monster_id) REFERENCES Monster(monster_id);
ALTER TABLE Monster_Loot ADD CONSTRAINT fk2_Monster_Loot FOREIGN KEY (item_id) REFERENCES Items(item_id);
ALTER TABLE Hero ADD CONSTRAINT fk1_Hero FOREIGN KEY (class_id) REFERENCES Class(class_id);
ALTER TABLE Hero ADD CONSTRAINT fk2_Hero FOREIGN KEY (hero_armor_item_id) REFERENCES Items(item_id);
ALTER TABLE Hero ADD CONSTRAINT fk3_Hero FOREIGN KEY (hero_primary_weapon_item_id) REFERENCES Items(item_id);
ALTER TABLE Hero ADD CONSTRAINT fk4_Hero FOREIGN KEY (hero_secondary_weapon_item_id) REFERENCES Items(item_id);
ALTER TABLE Hero ADD CONSTRAINT fk5_Hero FOREIGN KEY (hero_shield_item_id) REFERENCES Items(item_id);
ALTER TABLE Hero ADD CONSTRAINT fk6_Hero FOREIGN KEY (joueur_pseudo) REFERENCES Joueur(joueur_pseudo);
ALTER TABLE Level ADD CONSTRAINT fk_Level FOREIGN KEY (class_id) REFERENCES Class(class_id);
ALTER TABLE Hero_Progress ADD CONSTRAINT fk1_Hero_Progress FOREIGN KEY (joueur_pseudo, hero_id) REFERENCES Hero(joueur_pseudo, hero_id);
ALTER TABLE Hero_Progress ADD CONSTRAINT fk2_Hero_Progress FOREIGN KEY (aventure_id,chapter_id) REFERENCES Chapter(aventure_id,chapter_id);
ALTER TABLE Chapter ADD CONSTRAINT fk1_Chapter FOREIGN KEY (aventure_id) REFERENCES Aventure(aventure_id);
ALTER TABLE Chapter_Treasure ADD CONSTRAINT fk1_Chapter_Treasure FOREIGN KEY (aventure_id,chapter_id) REFERENCES Chapter(aventure_id,chapter_id);
ALTER TABLE Chapter_Treasure ADD CONSTRAINT fk2_Chapter_Treasure FOREIGN KEY (item_id) REFERENCES Items(item_id);
ALTER TABLE Links ADD CONSTRAINT fk1_Links FOREIGN KEY (aventure_id,chapter_id) REFERENCES Chapter(aventure_id,chapter_id);
ALTER TABLE Links ADD CONSTRAINT fk2_Links FOREIGN KEY (link_aventure_id,link_chapter_id) REFERENCES Chapter(aventure_id,chapter_id);
ALTER TABLE Inventory ADD CONSTRAINT fk1_Inventory FOREIGN KEY (hero_id) REFERENCES Hero(hero_id);
ALTER TABLE Inventory ADD CONSTRAINT fk2_Inventory FOREIGN KEY (item_id) REFERENCES Items(item_id);
ALTER TABLE Encounter ADD CONSTRAINT fk1_Encounter FOREIGN KEY (aventure_id,chapter_id) REFERENCES Chapter(aventure_id,chapter_id);
ALTER TABLE Encounter ADD CONSTRAINT fk2_Encounter FOREIGN KEY (monster_id) REFERENCES Monster(monster_id);
