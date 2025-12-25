<!-- Affichage Monstre -->
<h3 id="monster_nom">default</h3>
<p id="monster_stat">default</p>

<!-- Affichage Hero -->
<h3 id="hero_nom">default</h3>
<p id="hero_stat">default</p>

<button onclick="action_physique()">Attaque physique</button>
<button onclick="action_magique()">Attaque Magique</button>
<button onclick="action_soin_pv()">Boire une potion de vie</button>
<button onclick="action_soin_mana()">Boire une potion de mana</button>

<p id="log_hero"></p>
<p id="log_monster"></p>

<script>
    const monster_nom = document.getElementById("monster_nom");
    const monster_stat = document.getElementById("monster_stat");
    const hero_nom = document.getElementById("hero_nom");
    const hero_stat = document.getElementById("hero_stat");

    const log_hero = document.getElementById("log_hero");
    const log_monster = document.getElementById("log_monster");

    let monster_name = <?= json_encode($reponseMonstre['monster_name']) ?>;
    let monster_image;
    let monster_pv = <?= $reponseMonstre['monster_pv'] ?>;
    let monster_mana = <?= $reponseMonstre['monster_mana'] ?>;
    let monster_initiative = <?= $reponseMonstre['monster_initiative'] ?>;
    let monster_strength = <?= $reponseMonstre['monster_strength'] ?>;
    let monster_attack = <?= json_encode($reponseMonstre['monster_attack']) ?>;
    let monster_spell = <?= json_encode($reponseMonstre['monster_spell']) ?>;

    let hero_name = <?= json_encode($reponseHero['hero_name']) ?>;
    let class_name = "<?= $reponseClass['class_name'] ?>";
    let hero_pv = <?= $reponseHero['hero_pv'] ?>;
    let hero_mana = <?= $reponseHero['hero_mana'] ?>;
    let hero_strength = <?= $reponseHero['hero_strength'] ?>;
    let hero_initiative = <?= $reponseHero['hero_initiative'] ?>;
    let hero_armor_value = <?= $reponseItem['armor_value'] ?>;
    let hero_weapon_value = <?= $reponseItem['weapon_value'] ?>;
    let hero_shield_value = <?= $reponseItem['shield_value'] ?>;
    let hero_spell = <?= json_encode($reponseHero['hero_spell_list']) ?>;

    const hero_max_pv = <?= $reponseHero['hero_pv'] ?>;
    const hero_max_mana = <?= $reponseHero['hero_mana'] ?>;
    function parserManaCost(spell) {
        let pos = spell.split('-');
        return Number(pos[1]);
    }

    function tour_hero(choice) {
        switch (choice) {
            case "physical":
                let attaque = Math.random(1, 6) + hero_strength + hero_weapon_value;
                let defense = Math.random(1, 6) + Math.round(monster_strength / 2);
                let degat = Math.round(Math.max(0, attaque - defense));
                monster_pv -= degat;
                log_hero.textContent = "Vous l'attaquez pour : " + degat + " !";
                break;
            case "magical":
                if (class_name == "Mage" || class_name == "mage" || class_name == "Magicien" || class_name == "magicien") {
                    let magical_mana_cost = parserManaCost(hero_spell);
                    if (hero_mana - magical_mana_cost >= 0) {
                        hero_mana -= magical_mana_cost;
                        let attaque = Math.random(1, 6) + Math.random(1, 6) + magical_mana_cost;
                        let defense = Math.random(1, 6) + (monster_strength / 2);
                        let degat = Math.round(Math.max(0, attaque - defense));
                        monster_pv -= degat;
                        log_hero.textContent = "Vous l'attaquez avec votre magie pour : " + degat + " !";
                    } else {
                        log_hero.textContent = "Vous n'avez pas assez de mana !";
                    }
                } else {
                    log_hero.textContent = "Vous n'êtes pas un mage !";
                }
                break;
            case "health_potion":
                //Ne verifie pas si il y a des potions dans l'inventaire et leur valeur
                if (hero_pv + 10 > hero_max_pv) {
                    hero_pv = hero_max_pv;
                } else {
                    hero_pv += 10;
                }
                log_hero.textContent = "Vous vous soignez avec une potion de soin !";
                break;
            case "mana_potion":
                //Ne verifie pas si il y a des potions dans l'inventaire et leur valeur
                if (hero_mana + 10 > hero_max_mana) {
                    hero_mana = hero_max_mana;
                } else {
                    hero_mana += 10;
                }
                log_hero.textContent = "Vous vous régénérez avec une potion de mana !";
                break;
        }
        affichage();
    }

    function tour_monstre() {
        let attaque;
        if (monster_spell != null) {
            let magical_mana_cost = parserManaCost(monster_spell);
            if (monster_mana - magical_mana_cost >= 0) {
                monster_mana -= magical_mana_cost;
                attaque = Math.random(1, 6) + Math.random(1, 6) + magical_mana_cost;
                let defense = Math.random(1, 6) + Math.round(hero_strength / 2) + hero_armor_value + hero_shield_value;
                let degat = Math.round(Math.max(0, attaque - defense));
                hero_pv -= degat;
                log_monster.textContent = "Le monstre utilise sa magie et inflige : " + degat;
            } else {
                attaque = Math.random(1, 6) + monster_strength;
                log_monster.textContent = "Le monstre utilise :" + monster_attack;
                let defense = Math.random(1, 6) + Math.round(hero_strength / 2) + hero_armor_value + hero_shield_value;
                let degat = Math.round(Math.max(0, attaque - defense));
                hero_pv -= degat;
                log_monster.textContent = "Le monstre utilise : " + monster_attack + " et inflige : " + degat;
            }
        } else {
            attaque = Math.random(1, 6) + monster_strength;
            log_monster.textContent = "Le monstre utilise :" + monster_attack;
            let defense = Math.random(1, 6) + Math.round(hero_strength / 2) + hero_armor_value + hero_shield_value;
            let degat = Math.round(Math.max(0, attaque - defense));
            hero_pv -= degat;
            log_monster.textContent = "Le monstre utilise : " + monster_attack + " et inflige : " + degat;
        }
    }

    function first_turn_initiative() {
        let init_hero = Math.random(1, 6) + hero_initiative;
        let init_monstre = Math.random(1, 6) + monster_initiative;

        if (init_hero < init_monstre || (init_hero == init_monstre && (class_name != "Voleur" || class_name != "voleur"))) {
            tour_monstre();
            affichage();
        }
    }

    function affichage_monstre() {
        monster_nom.textContent = monster_name;
        monster_stat.textContent = monster_pv + " PV | " + monster_mana + " Mana | " + monster_strength + " Force";
    }

    function affichage_hero() {
        hero_nom.textContent = hero_name;
        hero_stat.textContent = hero_pv + "/" + hero_max_pv + " PV  | " + hero_mana + " /" + hero_max_mana + " Mana";
    }

    function combat() {
        tour_monstre();
        affichage();
        isCombatEnded();
    }

    function affichage() {
        affichage_hero();
        affichage_monstre();
    }

    function action_physique() {
        tour_hero('physical');
        if (isCombatEnded())
            return;
        setTimeout(() => {
            combat();
        }, 1000);
    }

    function action_magique() {
        tour_hero('magical');
        if (isCombatEnded())
            return;
        setTimeout(() => {
            combat();
        }, 1000);
    }

    function action_soin_pv() {
        tour_hero('health_potion');
        if (isCombatEnded())
            return;
        setTimeout(() => {
            combat();
        }, 1000);
    }

    function action_soin_mana() {
        tour_hero('mana_potion');
        if (isCombatEnded())
            return;
        setTimeout(() => {
            combat();
        }, 1000);
    }

    function isCombatEnded() {
        if (monster_pv <= 0) {
            window.location.href = "<?= url("game/chapter/fight/end/win") ?>";
            return true;
        } else if (hero_pv <= 0) {
            window.location.href = "<?= url("game/chapter/fight/end/lose") ?>";
            return true;
        }
        return false;
    }

    affichage();
    first_turn_initiative();
</script>