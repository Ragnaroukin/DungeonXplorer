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
    
    fetch("getInventaire", {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Content-Type': 'application/json'
        }
    })
    .then(res => res.json())
    .then(items => {
            inventoryItems.innerHTML = '';

            console.log(items);

            items.forEach(item => {
                const itemElement = document.createElement('div');
                itemElement.classList.add('inventory-item');

                itemElement.innerHTML = `
                    <img src="${item.item_image}" alt="${item.item_name}">
                    <strong>${item.item_name}</strong>
                    <p>Quantité: ${item.inventory_quantity}</p>
                `;

                inventoryItems.appendChild(itemElement);
            });
        })
    .catch(err => {
        console.error(err);
    });

    inventoryItems.innerHTML = '';
}
