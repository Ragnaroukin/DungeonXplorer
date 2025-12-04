const openInventoryBtn = document.getElementById('openInventoryBtn');
const inventoryPopup = document.getElementById('inventoryPopup');
const closePopupBtn = document.getElementById('closePopupBtn');
const inventoryItems = document.getElementById('inventoryItems');

openInventoryBtn.addEventListener('click', () => {
    inventoryPopup.style.display = 'flex';
    loadInventoryItems();
});

closePopupBtn.addEventListener('click', () => {
    inventoryPopup.style.display = 'none';
});

function loadInventoryItems() {
    fetch("models/getInventaire")
    .then(items => {
            inventoryGrid.innerHTML = '';

            items.forEach(item => {
                const itemElement = document.createElement('div');
                itemElement.classList.add('inventory-item');

                itemElement.innerHTML = `
                    <img src="${item.item_image}" alt="${item.item_name}">
                    <strong>${item.item_name}</strong>
                    <p>Quantité: ${item.quantity}</p>
                `;

                inventoryGrid.appendChild(itemElement);
            });
        })
    .catch(err => {
        console.error(err);
    });

    inventoryItems.innerHTML = '';
}
