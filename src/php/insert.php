<?php
require_once "DBAccess.php";


use DB\DBAccess;


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
setlocale(LC_ALL, 'it_IT');

$paginaHTML = file_get_contents(__DIR__ . "/../pages/insert.html");

$category = $_GET['category'];
$lista = "";
if ($category == "product") {
    $lista = "<h2 class=\"headings\">Crea Prodotto</h2>" . "<div class=\"info-container\">" .
        "<div class=\"text-fields\"><label for=\"id\">SKU</label><input type=\"text\" id=\"id\" placeholder=\"Id\" required></div>" . "\n
    <div class=\"text-fields\"><label for=\"nome\">Nome</label><input type=\"text\" id=\"nome\" placeholder=\"Nome\" required></div>" . "</div>" . "<div class=\"info-container\">" . "\n
    <div class=\"text-fields\"><label for=\"tipo\">Tipo</label><input type=\"text\" id=\"tipo\" placeholder=\"Tipologia\" required></div>" . "\n
    <div class=\"text-fields\"><label for=\"riferimento\">PC o Tastiera</label><input type=\"text\" id=\"riferimento\" placeholder=\"Riferimento\" required></div>" .  "\n
    </div>" . "<div class=\"info-container\">" .  "\n
    <div class=\"text-fields\"><label for=\"prezzo\">Prezzo</label><input type=\"text\" id=\"prezzo\" placeholder=\"Prezzo\" required></div> " . "\n
    <div class=\"text-fields\"><label for=\"colore\">Colore</label><input type=\"text\" id=\"colore\" placeholder=\"Colore\" required></div>" . "</div>" . "<div class=\"info-container\">" . "\n
    <div class=\"text-fields\"><label for=\"disponibilita\">Disponibilità</label><input type=\"text\" id=\"disponibilita\" placeholder=\"Disponibilità\" required></div>" . "\n
    <div class=\"text-fields\"><label for=\"categoria\">Categoria</label><input type=\"text\" id=\"categoria\" placeholder=\"Categoria\" required></div>" . "</div>"  . "<div class=\"text-fields prod-description\"><label for=\"descrizione\">Descrizione</label>
                                <textarea id=\"descrizione\" rows=\"10\" cols=\"100\"  placeholder=\"Descrizione Prodotto\"></textarea></div>\n" . "\n
<input id=\"inserisci-prodotto\" type=\"button\" class=\"inserisciProdotto\" value=\"Inserisci\">";
    $paginaHTML = str_replace('<script src="../js/insertProductAdmin.js"></script>', '<script src="../js/insertProductAdmin.js" data-categoria="product"></script>', $paginaHTML);
} else {
    $lista = "<input type=\"text\" id=\"codice\" placeholder=\"codice\" required>" . "\n
    <input type=\"text\" id=\"data_emissione\" placeholder=\"data_emissione\" required>" . "\n
    <input type=\"text\" id=\"data_scadenza\" placeholder=\"data_scadenza\" required>" . "\n
    <input type=\"text\" id=\"username\" placeholder=\"username\" required>" . "\n
    <input type=\"text\" id=\"valore\" placeholder=\"valore\" required>" . "\n
    <input type=\"button\" class=\"inserisciProdotto\" value=\"Inserisci\">";
    $paginaHTML = str_replace('<script src="../js/insertProductAdmin.js"></script>', '<script src="../js/insertProductAdmin.js" data-categoria="sale"></script>', $paginaHTML);
}

$paginaHTML = str_replace('{prova}', $lista, $paginaHTML);
$paginaHTML = str_replace('src/pages/cart.html', 'cart.php', $paginaHTML);
$paginaHTML = str_replace('src/php/getCatalog.php?categoria=kbd&riferimento=', 'getCatalog.php?categoria=kbd&riferimento=', $paginaHTML);
$paginaHTML = str_replace('src/php/getCatalog.php?categoria=pc&riferimento=', 'getCatalog.php?categoria=pc&riferimento=', $paginaHTML);
$paginaHTML = str_replace('catalog.html?categoria=kbd', 'getCatalog.php?categoria=kbd&riferimento=', $paginaHTML);
$paginaHTML = str_replace('catalog.html?categoria=pc', 'getCatalog.php?categoria=pc&riferimento=', $paginaHTML);
$paginaHTML = str_replace('src/pages/contacts.html', '../pages/contacts.html', $paginaHTML);
$paginaHTML = str_replace('catalog.html', '../pages/catalog.html', $paginaHTML);
$paginaHTML = str_replace('faq.html', '../pages/faq.html', $paginaHTML);
$paginaHTML = str_replace('news.html', '../pages/news.html', $paginaHTML);
$paginaHTML = str_replace('profile.html', '../pages/profile.html', $paginaHTML);
$paginaHTML = str_replace('tos.html', '../pages/tos.html', $paginaHTML);
$paginaHTML = str_replace('privacy.html', '../pages/privacy.html', $paginaHTML);
$paginaHTML = str_replace('contacts.html', '../pages/contacts.html', $paginaHTML);
$paginaHTML = str_replace('cookies.html', '../pages/cookies.html', $paginaHTML);
$paginaHTML = str_replace('login.html', '../pages/login.html', $paginaHTML);
$paginaHTML = str_replace('signup.html', '../pages/signup.html', $paginaHTML);
$paginaHTML = str_replace('news.html', '../pages/news.html', $paginaHTML);



echo ($paginaHTML);
