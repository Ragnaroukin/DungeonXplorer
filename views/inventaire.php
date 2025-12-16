<?php $items = Inventaire::getItems(); ?>

<button id="openInventoryBtn">Ouvrir Inventaire</button>
<div id="inventoryPopup" class="popup">
    <div class="popup-content">
        <span id="closePopupBtn" class="close">&times;</span>
        <h2>Inventaire</h2>
        <div id="inventoryItems">
            <?php foreach ($items as $item) {?>
                <div class="inventory-item">
                    <img src="<?php echo $item["item_image"]; ?>" alt="<?php echo $item["item_name"]; ?>">
                    <strong><?php echo $item["item_name"]; ?></strong>
                    <p>Quantité: <?php echo $item["inventory_quantity"] ?></p>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
