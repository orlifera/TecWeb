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
    $lista = "<input type=\"text\" id=\"id\" placeholder=\"Id\" required>" . "\n
    <input type=\"text\" id=\"nome\" placeholder=\"Nome\" required>" . "\n
    <input type=\"text\" id=\"tipo\" placeholder=\"Tipologia\" required>" . "\n
    <input type=\"textarea\" id=\"descrizione\" placeholder=\"Descrizione\" required> " . "\n
    <input type=\"text\" id=\"prezzo\" placeholder=\"Prezzo\" required> " . "\n
    <input type=\"text\" id=\"colore\" placeholder=\"Colore\" required>" . "\n
    <input type=\"text\" id=\"disponibilita\" placeholder=\"Disponibilità\" required>" . "\n
    <input type=\"text\" id=\"categoria\" placeholder=\"Categoria\" required>" . "\n
    <input type=\"text\" id=\"riferimento\" placeholder=\"Riferimento\" required>" . "\n
    <input type=\"button\" class=\"inserisciProdotto\" value=\"Inserisci\">";
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
