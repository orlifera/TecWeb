document.addEventListener('DOMContentLoaded', function () {
    // variabili
    var navbar = document.getElementById('menu');
    var header = document.querySelector('header');
    var headerHeight = header.clientHeight;
    var widt
    // aggiunge classe fixed a menu
    function toggleNavbar() {
        if (window.innerWidth > 600 && window.scrollY >= headerHeight) {
            navbar.classList.add('fixed');
        } else {
            navbar.classList.remove('fixed');
        }
    }
    // in ascolto per scroll
    window.addEventListener('scroll', toggleNavbar);
    // inizializza
    toggleNavbar();
});