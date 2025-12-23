delete from class;
delete from items;
delete from level;

INSERT INTO `class`(`class_id`, `class_name`, `class_description`, `class_base_pv`, 
`class_base_mana`, `class_base_strength`, `class_base_initiative`, `class_max_items`) 
VALUES (
    0,
    'Barbare',
    'Force brute incarnée, un guerrier forgé par les terres sauvages et les épreuves impitoyables. Son corps, massif et couvert de cicatrices, témoigne d’une vie passée à survivre là où d’autres périraient. Sa chevelure, souvent longue et indisciplinée, flotte au vent comme une crinière indomptée, et ses yeux brûlent d’une intensité primitive. Armé d’une lourde arme – hache gigantesque, marteau de guerre ou épée à deux mains – il combat avec une rage qui semble jaillir du plus profond de son être. Sa puissance physique dépasse celle des combattants ordinaires : chaque coup qu’il porte résonne avec la force de la terre elle-même. Bien qu’il puisse sembler brutal ou rustre, le barbare possède souvent un code d’honneur personnel : loyauté envers ses compagnons, respect de la nature et dédain pour les artifices de la civilisation. Vivant en harmonie avec la sauvagerie qui l’entoure, il puise sa force dans l’instinct, la liberté et l’indomptable énergie du monde sauvage.',
    100,
    0,
    5,
    2,
    15);

INSERT INTO `class`(`class_id`, `class_name`, `class_description`, `class_base_pv`,
 `class_base_mana`, `class_base_strength`, `class_base_initiative`, `class_max_items`)
VALUES (
    1,
    'Magicien',
    'Maître des arcanes, un savant dont l’esprit s’aventure là où la plupart n’oseraient même pas poser les yeux. Drapé dans une longue robe ornée de runes mystérieuses, il dégage une aura à la fois sereine et inquiétante, comme si des secrets anciens murmuraient autour de lui.
    Son regard, vif et pénétrant, témoigne d’une intelligence affûtée et d’une curiosité insatiable. Là où le barbare compte sur sa force, le magicien puise sa puissance dans les flux invisibles de la magie : l’énergie du feu, la froideur du givre, les courants de la pensée ou même les forces du cosmos lui obéissent lorsqu’il trace des signes dans l’air.
    Dans sa main, il tient souvent un bâton gravé de symboles ésotériques ou un grimoire poussiéreux rempli de connaissances interdites. Chaque sort qu’il lance est un équilibre délicat entre maîtrise et danger, car la magie est un outil puissant, mais capricieux.
    Sage, mystérieux et parfois distant, le magicien consacre sa vie à comprendre l’incompréhensible. Il sait que le vrai pouvoir ne se mesure pas en muscles ni en richesse, mais en savoir, en patience, et en la capacité de modeler la réalité elle-même.',
    50,
    100,
    1,
    1,
    5);

INSERT INTO `class`(`class_id`, `class_name`, `class_description`, `class_base_pv`,
 `class_base_mana`, `class_base_strength`, `class_base_initiative`, `class_max_items`)
VALUES (
    2,
    'Voleur',
    'Une ombre parmi les ombres, un expert de la discrétion et de la ruse. Agile et silencieux, il se déplace avec la souplesse d’un félin, chaque pas calculé pour ne jamais attirer l’attention. Ses vêtements sombres, souvent renforcés de pièces légères de cuir, lui permettent de se fondre naturellement dans l’obscurité, et un capuchon rabattu sur son visage dissimule ses intentions comme ses traits.
    Ses yeux, vifs et observateurs, ne manquent aucun détail : une serrure fragile, une bourse mal attachée, un passage secret à peine perceptible… rien ne lui échappe. Armé de dagues affûtées ou d’une rapière légère, il privilégie la précision à la force brute, frappant quand l’ennemi ne s’y attend pas.
    Le voleur n’est pas seulement un maître des larcins : c’est aussi un stratège subtil. Bluff, agilité, acrobaties et sens aigu du danger lui permettent de survivre dans les rues les plus malfamées comme dans les couloirs les plus piégés.
    Qu’il soit un aventurier pragmatique, un charmeur insolent ou un hors-la-loi au grand cœur, le voleur vit dans l’équilibre fragile entre liberté et danger, toujours prêt à disparaître avant que quiconque ne comprenne qu’il était là.',
    75,
    50,
    3,
    4,
    10);


/*Insert items*/

INSERT INTO `items`(`item_id`,`item_name`, `item_description`, `item_image`, `item_type`) 
VALUES (0, 'Potion de soin','Un puissant breuvage permettant de remettre sur pieds un aventurier blessé',
        '/img/healingPotion.jpg','misc');

INSERT INTO `items`(`item_name`, `item_description`, `item_image`, `item_type`) 
VALUES ('Casque','Un casque permettant de protéger sa tête',
        '/img/Helmet.jpg','armor');

INSERT INTO `items`(`item_name`, `item_description`, `item_image`, `item_type`) 
VALUES ('Arbalète','Une arme à distance tirant des carreaux',
        '/img/Crossbow.jpg','weapon');

INSERT INTO `items`(`item_name`, `item_description`, `item_image`, `item_type`) 
VALUES ('Plastron en métal','Une pauvre plaque de fer à peu près pliée de sorte à protéger son porteur',
        '/img/Chestplate.jpg','armor');

INSERT INTO `items`( `item_name`, `item_description`, `item_image`, `item_type`) 
VALUES ('epée','lame double et acérée, finement gravée de motifs sinueux d’inspiration gothique. Sa garde, richement ornementée de volutes métalliques et de pointes acérées, lui donne une allure à la fois élégante et menaçante. Le manche gainé de cuir sombre complète l’ensemble, faisant de cette arme une pièce aussi esthétique que redoutable',
        '/img/Sword01.jpg','weapon');

INSERT INTO `items`(`item_name`, `item_description`, `item_image`, `item_type`) 
VALUES ('Baton magique','Un catalyseur du pouvoir magique des sorciers',
        '/img/MagicStaff.jpg','weapon');


/*Niveaux Barbare*/

INSERT INTO `level`(`class_id`, `level_number`, `level_required_xp`, `level_pv_bonus`, `level_mana_bonus`, `level_strength_bonus`,
`level_initiative_bonus`) VALUES (0, 1, 50, 10, 0, 1, 0);

INSERT INTO `level`(`class_id`, `level_number`, `level_required_xp`, `level_pv_bonus`, `level_mana_bonus`, `level_strength_bonus`,
`level_initiative_bonus`) VALUES (0, 2, 100, 20, 0, 1, 0);

INSERT INTO `level`(`class_id`, `level_number`, `level_required_xp`, `level_pv_bonus`, `level_mana_bonus`, `level_strength_bonus`,
`level_initiative_bonus`) VALUES (0, 3, 200, 30, 0, 5, 0);

INSERT INTO `level`(`class_id`, `level_number`, `level_required_xp`, `level_pv_bonus`, `level_mana_bonus`, `level_strength_bonus`,
`level_initiative_bonus`) VALUES (0, 4, 400, 50, 0, 7, 0);

INSERT INTO `level`(`class_id`, `level_number`, `level_required_xp`, `level_pv_bonus`, `level_mana_bonus`, `level_strength_bonus`,
`level_initiative_bonus`) VALUES (0, 5, 800, 60, 0, 9, 1);

INSERT INTO `level`(`class_id`, `level_number`, `level_required_xp`, `level_pv_bonus`, `level_mana_bonus`, `level_strength_bonus`,
`level_initiative_bonus`) VALUES (0, 6, 1600, 70, 0, 11, 0);

INSERT INTO `level`(`class_id`, `level_number`, `level_required_xp`, `level_pv_bonus`, `level_mana_bonus`, `level_strength_bonus`,
`level_initiative_bonus`) VALUES (0, 7, 3200, 80, 0, 13, 0);

INSERT INTO `level`(`class_id`, `level_number`, `level_required_xp`, `level_pv_bonus`, `level_mana_bonus`, `level_strength_bonus`,
`level_initiative_bonus`) VALUES (0, 8, 6400, 90, 0, 15, 0);

INSERT INTO `level`(`class_id`, `level_number`, `level_required_xp`, `level_pv_bonus`, `level_mana_bonus`, `level_strength_bonus`,
`level_initiative_bonus`) VALUES (0, 9, 12800, 100, 0, 17, 0);

INSERT INTO `level`(`class_id`, `level_number`, `level_required_xp`, `level_pv_bonus`, `level_mana_bonus`, `level_strength_bonus`,
`level_initiative_bonus`) VALUES (0, 10, 25600, 150, 0, 19, 1);

/*Niveaux Mage*/

INSERT INTO `level`(`class_id`, `level_number`, `level_required_xp`, `level_pv_bonus`, `level_mana_bonus`, `level_strength_bonus`,
`level_initiative_bonus`) VALUES (1, 1, 50, 1, 5, 0, 0);

INSERT INTO `level`(`class_id`, `level_number`, `level_required_xp`, `level_pv_bonus`, `level_mana_bonus`, `level_strength_bonus`,
`level_initiative_bonus`) VALUES (1, 2, 100, 3, 10, 0, 0);

INSERT INTO `level`(`class_id`, `level_number`, `level_required_xp`, `level_pv_bonus`, `level_mana_bonus`, `level_strength_bonus`,
`level_initiative_bonus`) VALUES (1, 3, 200, 5, 15, 0, 0);

INSERT INTO `level`(`class_id`, `level_number`, `level_required_xp`, `level_pv_bonus`, `level_mana_bonus`, `level_strength_bonus`,
`level_initiative_bonus`) VALUES (1, 4, 400, 7, 20, 0, 0);

INSERT INTO `level`(`class_id`, `level_number`, `level_required_xp`, `level_pv_bonus`, `level_mana_bonus`, `level_strength_bonus`,
`level_initiative_bonus`) VALUES (1, 5, 800, 20, 35, 0, 1);

INSERT INTO `level`(`class_id`, `level_number`, `level_required_xp`, `level_pv_bonus`, `level_mana_bonus`, `level_strength_bonus`,
`level_initiative_bonus`) VALUES (1, 6, 1600, 9, 25, 0, 0);

INSERT INTO `level`(`class_id`, `level_number`, `level_required_xp`, `level_pv_bonus`, `level_mana_bonus`, `level_strength_bonus`,
`level_initiative_bonus`) VALUES (1, 7, 3200, 11, 30, 0, 0);

INSERT INTO `level`(`class_id`, `level_number`, `level_required_xp`, `level_pv_bonus`, `level_mana_bonus`, `level_strength_bonus`,
`level_initiative_bonus`) VALUES (1, 8, 6400, 13, 35, 0, 0);

INSERT INTO `level`(`class_id`, `level_number`, `level_required_xp`, `level_pv_bonus`, `level_mana_bonus`, `level_strength_bonus`,
`level_initiative_bonus`) VALUES (1, 9, 12800, 15, 40, 0, 0);

INSERT INTO `level`(`class_id`, `level_number`, `level_required_xp`, `level_pv_bonus`, `level_mana_bonus`, `level_strength_bonus`,
`level_initiative_bonus`) VALUES (1, 10, 25600, 50, 70, 0, 2);

/*Niveaux Voleur*/

INSERT INTO `level`(`class_id`, `level_number`, `level_required_xp`, `level_pv_bonus`, `level_mana_bonus`, `level_strength_bonus`,
`level_initiative_bonus`) VALUES (2, 1, 50, 10, 1, 1, 1);

INSERT INTO `level`(`class_id`, `level_number`, `level_required_xp`, `level_pv_bonus`, `level_mana_bonus`, `level_strength_bonus`,
`level_initiative_bonus`) VALUES (2, 2, 100, 15, 4, 2, 0);

INSERT INTO `level`(`class_id`, `level_number`, `level_required_xp`, `level_pv_bonus`, `level_mana_bonus`, `level_strength_bonus`,
`level_initiative_bonus`) VALUES (2, 3, 200, 20, 7, 4, 2);

INSERT INTO `level`(`class_id`, `level_number`, `level_required_xp`, `level_pv_bonus`, `level_mana_bonus`, `level_strength_bonus`,
`level_initiative_bonus`) VALUES (2, 4, 400, 25, 10, 6, 0);

INSERT INTO `level`(`class_id`, `level_number`, `level_required_xp`, `level_pv_bonus`, `level_mana_bonus`, `level_strength_bonus`,
`level_initiative_bonus`) VALUES (2, 5, 800, 50, 13, 15, 5);

INSERT INTO `level`(`class_id`, `level_number`, `level_required_xp`, `level_pv_bonus`, `level_mana_bonus`, `level_strength_bonus`,
`level_initiative_bonus`) VALUES (2, 6, 1600, 30, 16, 10, 0);

INSERT INTO `level`(`class_id`, `level_number`, `level_required_xp`, `level_pv_bonus`, `level_mana_bonus`, `level_strength_bonus`,
`level_initiative_bonus`) VALUES (2, 7, 3200, 35, 19, 12, 2);

INSERT INTO `level`(`class_id`, `level_number`, `level_required_xp`, `level_pv_bonus`, `level_mana_bonus`, `level_strength_bonus`,
`level_initiative_bonus`) VALUES (2, 8, 6400, 40, 22, 14, 0);

INSERT INTO `level`(`class_id`, `level_number`, `level_required_xp`, `level_pv_bonus`, `level_mana_bonus`, `level_strength_bonus`,
`level_initiative_bonus`) VALUES (2, 9, 12800, 50, 25, 16, 2);

INSERT INTO `level`(`class_id`, `level_number`, `level_required_xp`, `level_pv_bonus`, `level_mana_bonus`, `level_strength_bonus`,
`level_initiative_bonus`) VALUES (2, 10, 25600, 100, 35, 30, 10);

