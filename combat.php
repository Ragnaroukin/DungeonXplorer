<?php 
require_once("views/header.php");
?>

<?php
        //Requete pour le Monstre
        $queryMonstre = $bdd->prepare('SELECT monster_name,monster_image,monster_pv,monster_mana,monster_initiative,monster_strength,monster_attack,monster_spell,monster_xp FROM Monster where monster_id = ?');
        $queryMonstre->execute(array(1)); // Modifier les valeur avec les paramètre qui seront donnée
        $reponseMonstre = $queryMonstre->fetch();
        
        //Requete pour le Hero
        $queryHero = $bdd->prepare('SELECT hero_name ,class_id,hero_pv ,hero_mana ,hero_strength ,hero_initiative ,hero_level, hero_spell_list ,hero_xp, hero_armor_item_id,hero_weapon_item_id,hero_shield_item_id FROM hero where hero_id = ?');
        $queryHero->execute(array(1)); // Modifier les valeur avec les paramètre qui seront donnée
        $reponseHero = $queryHero->fetch();
        
        //Requete pour les class et les effets propre
        $queryClass = $bdd->prepare('SELECT class_name,class_image  ,class_base_pv ,class_base_mana  ,class_base_strength  ,class_base_initiative  FROM Class where class_id  = ?');
        $queryClass->execute(array($reponseHero['class_id']));
        $reponseClass = $queryClass->fetch();
        
        //Requete pour les level et les stats associer
        $queryLevel = $bdd->prepare('SELECT level_required_xp   ,level_pv_bonus  ,level_mana_bonus   ,level_strength_bonus   ,level_initiative_bonus   FROM level where level_number  = ? and class_id = ?');
        $queryLevel->execute(array($reponseHero['hero_level'],$reponseHero['class_id']));
        $reponseLevel = $queryLevel->fetch();

        //Preparation de la requete qui sera appeler a la fin du combat
        //$queryLink = $bdd->prepare('SELECT link_aventure_id   ,link_chapter_id  FROM Links where aventure_id  = ? and chapter_id = ? and link_choice = ?');

        //Requete pour les Objets du hero
        $queryItem = $bdd->prepare('SELECT item_value FROM Items where item_id = ?');
        $queryItem->execute(array($reponseHero['hero_weapon_item_id']));
        $tempItem = $queryItem->fetch();  
        $reponseItem['weapon_value'] = $tempItem['item_value']; 
        $queryItem->execute(array($reponseHero['hero_shield_item_id']));
        $tempItem = $queryItem->fetch(); 
        $reponseItem['shield_value'] =  $tempItem['item_value'];
        $queryItem->execute(array($reponseHero['hero_armor_item_id']));
        $tempItem = $queryItem->fetch(); 
        $reponseItem['armor_value'] = $tempItem['item_value'];
?>

<!-- Affichage Monstre -->
<h3 id="monster_nom" >default</h3>
<p id="monster_stat">default</p>

<!-- Affichage Hero -->
<h3 id="hero_nom">default</h3>
<p id="hero_stat">default</p> 

<form> 
    <input type="button" value="Attaque physique" onClick="action_physique()">
    <input type="button" value="Attaque Magique" onClick="action_magique()">
    <input type="button" value="Boire une potion de vie" onClick="action_soin_pv()">
    <input type="button" value="Boire une potion de mana" onClick="action_soin_mana()">
</form>

<script>
    const monster_nom = document.getElementById("monster_nom");
    const monster_stat = document.getElementById("monster_stat");
    const hero_nom = document.getElementById("hero_nom");
    const hero_stat = document.getElementById("hero_stat");

    let monster_name = <?php  echo json_encode($reponseMonstre['monster_name']);?>;
    let monster_image;
    let monster_pv = <?php echo $reponseMonstre['monster_pv'];?>;
    let monster_mana = <?php echo $reponseMonstre['monster_mana'];?>;
    let monster_initiative = <?php echo $reponseMonstre['monster_initiative'];?>;
    let monster_strength = <?php echo $reponseMonstre['monster_strength'];?>;
    let monster_attack = <?php echo json_encode($reponseMonstre['monster_attack']);?>;
    let monster_spell = null;
   
    let hero_name  = <?php echo json_encode($reponseHero['hero_name']); ?>;
    let class_id  = <?php echo $reponseHero['class_id']; ?>;
    let hero_pv  = <?php echo $reponseHero['hero_pv']; ?>;
    let hero_mana  = <?php echo $reponseHero['hero_mana']; ?>;
    let hero_strength  = <?php echo $reponseHero['hero_strength']; ?>;
    let hero_initiative  = <?php echo $reponseHero['hero_initiative']; ?>;
    let hero_armor_value = <?php echo  $reponseItem['armor_value']; ?>;
    let hero_weapon_value  = <?php echo $reponseItem['weapon_value']; ?>;
    let hero_shield_value  = <?php echo $reponseItem['shield_value']; ?>;
    let hero_spell =  <?php echo json_encode($reponseHero['hero_spell_list']); ?>;
    
    const hero_max_pv  = <?php echo $reponseClass['class_base_pv'] + $reponseLevel['level_pv_bonus']; ?>;
    const hero_max_mana  = <?php echo $reponseClass['class_base_mana'] + $reponseLevel['level_mana_bonus']; ?>;

    function parserManaCost(spell) {
        let pos = spell.split('-');
        return Number(pos[1]);
    }

    function tour_hero(choice) {
            switch(choice) { 
                case "physical" :
                    let attaque = Math.random(1,6) + hero_strength + hero_weapon_value;
                    let defense = Math.random(1,6) + Math.round(monster_strength/2);
                    let degat = Math.round(Math.max(0, attaque - defense));
                    monster_pv -= degat;
                    break;
                case "magical" :
                    if (class_id == 1) {
                        let magical_mana_cost = parserManaCost(hero_spell);
                        if (hero_mana - magical_mana_cost >= 0) {
                            hero_mana -= magical_mana_cost;
                            let attaque = Math.random(1,6) + Math.random(1,6) + magical_mana_cost;
                            let defense = Math.random(1,6) + (monster_strength/2); //Le monstre n'a pas d'armure
                            let degat = Math.round(Math.max(0, attaque - defense));
                            monster_pv -= degat;
                        } else {
                            //print("Vous n'avez pas assez de mana !");
                        }
                    } else {
                        //print("Vous n'êtes pas un mage !");
                    }
                    break;
                case "health_potion" :
                    //Ne verifie pas si il y a des potions dans l'inventaire et leur valeur
                    if (hero_pv + 10 > hero_max_pv ) {
                        hero_pv = hero_max_pv;
                    } else {
                        hero_pv += 10;
                    }
                    break;
                case "mana_potion" :
                    //Ne verifie pas si il y a des potions dans l'inventaire et leur valeur
                    if (hero_mana + 10 > hero_max_mana ) { 
                        hero_mana = hero_max_mana;
                    } else {
                        hero_mana += 10;
                    }
                    break;
            }
    }

    function tour_monstre() {
        let attaque;
        if (monster_spell != null ) {
            let magical_mana_cost = parserManaCost(monster_spell);
            if (monster_mana - magical_mana_cost >= 0) {
                monster_mana -= magical_mana_cost;
                attaque = Math.random(1,6) + Math.random(1,6) + magical_mana_cost;
            } else {
                attaque = Math.random(1,6) + monster_strength;
            }
        } else {
            attaque = Math.random(1,6) + monster_strength;
        }
            let defense = Math.random(1,6) + Math.round(hero_strength/2) + hero_armor_value + hero_shield_value;
            let degat = Math.round(Math.max(0, attaque - defense));
            hero_pv -= degat;
        affichage_monstre();
        affichage_hero();
    }

    function first_turn_initiative() {
        let init_hero = Math.random(1, 6) + hero_initiative;
        let init_monstre = Math.random(1, 6) + monster_initiative;

        if(init_hero < init_monstre || (init_hero = init_monstre && class_id != 2) ) {
            tour_monstre();
        }
    }

    function affichage_monstre() {
        //mettre l'image
        monster_nom.textContent = monster_name;
        monster_stat.textContent = monster_pv + " PV | " + monster_mana + " Mana | " + monster_strength + " Force";
    }

    function affichage_hero() {
        //mettre image
        hero_nom.textContent = hero_name;
        hero_stat.textContent = hero_pv + "/" + hero_max_pv + " PV  | " + hero_mana+ " /" + hero_max_mana + " Mana";
    }
    
    function combat(){
			affichage_monstre();
			affichage_hero();
			tour_monstre();
			affichage_monstre();
			affichage_hero();
	}

    function action_physique() {
        tour_hero('physical');
        combat();
    }

    function action_magique() {
        tour_hero('magical');
        combat();
    }

    function action_soin_pv() {
        tour_hero('health_potion');
        combat();
    }

    function action_soin_mana() {
        tour_hero('mana_potion');
        combat();
    }


    affichage_monstre();
	affichage_hero();
    first_turn_initiative();
</script>

<?php
require_once("views/footer.php");
?>
