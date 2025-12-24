window.addEventListener('DOMContentLoaded', event => {

    // Navbar shrink function
    var navbarShrink = function () {
        const navbarCollapsible = document.body.querySelector('#mainNav');
        if (!navbarCollapsible) {
            return;
        }
        if (window.scrollY === 0) {
            navbarCollapsible.classList.remove('navbar-shrink')
        } else {
            navbarCollapsible.classList.add('navbar-shrink')
        }

    };

    // Shrink the navbar 
    navbarShrink();

    // Shrink the navbar when page is scrolled
    document.addEventListener('scroll', navbarShrink);

    //  Activate Bootstrap scrollspy on the main nav element
    const mainNav = document.body.querySelector('#mainNav');
    if (mainNav) {
        new bootstrap.ScrollSpy(document.body, {
            target: '#mainNav',
            rootMargin: '0px 0px -40%',
        });
    };

    // Collapse responsive navbar when toggler is visible
    const navbarToggler = document.body.querySelector('.navbar-toggler');
    const responsiveNavItems = [].slice.call(
        document.querySelectorAll('#navbarResponsive .nav-link')
    );
    responsiveNavItems.map(function (responsiveNavItem) {
        responsiveNavItem.addEventListener('click', () => {
            if (window.getComputedStyle(navbarToggler).display !== 'none') {
                navbarToggler.click();
            }
        });
    });

});

const inventoryPopup = document.getElementById('inventoryPopup');
const treasurePopup = document.getElementById('treasurePopup');

if (inventoryPopup) {
    const openInventoryBtn = document.getElementById('openInventoryBtn');
    const closeInventoryBtn = document.getElementById('closeInventoryBtn');

    openInventoryBtn.addEventListener('click', () => {
        inventoryPopup.style.display = 'flex';
    });

    closeInventoryBtn.addEventListener('click', () => {
        inventoryPopup.style.display = 'none';
    });
}

if(treasurePopup){
    const closeTreasureBtn = document.getElementById('closeTreasureBtn');

    treasurePopup.style.display = 'flex';
    
    closeTreasureBtn.addEventListener('click', () => {
        treasurePopup.style.display = 'none';
    });
}