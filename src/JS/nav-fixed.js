document.addEventListener('DOMContentLoaded', function () {
    // variabili
    var navbar = document.getElementById('menu');
    var header = document.querySelector('header');
    var bread = document.getElementById('breadcrumb');
    var main = document.querySelector('main');
    var headerHeight = header.clientHeight;
    // aggiunge classe fixed a menu
    function toggleNavbar() {
        if (window.innerWidth > 600 && window.scrollY >= headerHeight) {
            navbar.classList.add('fixed');
            bread.classList.add('fixed');
            main.classList.add('float');
        } else {
            navbar.classList.remove('fixed');
            bread.classList.remove('fixed');
            main.classList.remove('float');
        }
    }
    // in ascolto per scroll
    window.addEventListener('scroll', toggleNavbar);
    // inizializza
    toggleNavbar();
});