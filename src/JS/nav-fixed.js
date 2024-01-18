document.addEventListener('DOMContentLoaded', function () {
    // variabili
    var navbar = document.getElementById('menu');
    var header = document.querySelector('header');
    var bread = document.getElementById('breadcrumb');
    var headerHeight = header.clientHeight;
    // aggiunge classe fixed a menu
    function toggleNavbar() {
        if (window.innerWidth > 600 && window.scrollY >= headerHeight) {
            navbar.classList.add('fixed');
            bread.classList.add('fixed');
        } else {
            navbar.classList.remove('fixed');
            bread.classList.remove('fixed');
        }
    }
    // in ascolto per scroll
    window.addEventListener('scroll', toggleNavbar);
    // inizializza
    toggleNavbar();
});