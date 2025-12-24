<div id="treasurePopup" class="popup">
    <div class="popup-content">
        <span id="closeTreasureBtn" class="close">&times;</span>
        <h2>Trésor</h2>
        <div class="inventory-item">
            <img src="<?= url($treasure["item_image"]) ?>" alt="<?= $treasure["item_name"] ?>">
            <strong><?= $treasure["item_name"] ?></strong>
            <p>Quantité: <?= $treasure["treasure_quantity"] ?></p>
        </div>
    </div>
</div>
</div>