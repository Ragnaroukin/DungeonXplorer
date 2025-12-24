<h1>Vous rencontrez un monstre !!!</h1>
<form action="chapter/fight" method="post">
    <input type="hidden" name="monster_id" value=<?= $encounters[0]["monster_id"] ?>>
    <input type="submit" value="Commencez le combat">
</form>