<?php $items = Inventaire::getItems(); ?>

<button id="openInventoryBtn">Ouvrir Inventaire</button>
<div id="inventoryPopup" class="popup">
    <div class="popup-content">
        <span id="closeInventoryBtn" class="close">&times;</span>
        <h2>Inventaire</h2>
        <div id="inventoryItems">
            <?php foreach ($items as $item) {?>
                <div class="inventory-item">
                    <img src="<?= url($item["item_image"]) ?>" alt="<?= $item["item_name"] ?>">
                    <strong><?= $item["item_name"] ?></strong>
                    <p>Quantité: <?= $item["inventory_quantity"] ?></p>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
