<?php

require_once "DBAccess.php";

use DB\DBAccess;

session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
setlocale(LC_ALL, 'it_IT');

$paginaHTML = file_get_contents(__DIR__ . "/../pages/cart.html");

$username = isset($_SESSION['user']) ? $_SESSION['user'] : 'non registrato';

$listaPC = "";
$htmlProdotti = "";
$nomeProdottoCompleto = $prezzo = $path = $sku = $categoria = $quantita = $colore = $disponibilita =  [];
$counter = 0;

$connection = new DBAccess();
$connectionOk = $connection->openDBConnection();

if ($connectionOk) {
    if ($username == "non registrato") {
        $listaPC = $connection->getProductCart();
    } else {
        $listaPC = $connection->getProductCartReg($username);
    }
    if (!empty($listaPC)) {
        $nomeProdottoCompleto = $prezzo = $path = $sku = $categoria = $quantita = $colore = $disponibilita = [];

        foreach ($listaPC as $pc) {
            $nomeProdottoCompleto[] = "" . htmlspecialchars($pc['nome']);
            $prezzo[] = "&euro;" . htmlspecialchars($pc['prezzo']);
            $path[] = htmlspecialchars($pc['path_immagine']);
            $sku[] = htmlspecialchars($pc['sku']);
            $categoria[] = htmlspecialchars($pc['categoria']);
            $quantita[] = htmlspecialchars($pc['quantitaScelta']);
            $disponibilita[] = htmlspecialchars($pc['disponibilita']);
        }
    } else {
        $nomeProdottoCompleto = $prezzo = $path = $sku = [];
        $htmlProdotti = "<p>Carrello vuoto</p>";
    }
} else {
    $nomeProdottoCompleto = $prezzo = $path = $sku = [];
    header("HTTP/1.0 404 Not Found");
    include("../pages/404.html");
    exit;
}


foreach ($nomeProdottoCompleto as $i => $nome) {
    if ($nome != null) {
        $prova =
            "<div class=\"cart-container\">" .
            "<a href=\"getProduct.php?categoria=" . $categoria[$i] . "&id=" . $sku[$i] . "\">\n" .
            "<img class=\"product-image\" src=\"" . $path[$i] . "\" alt=\"" . $nome . "\">\n" . "</a>\n" .
            "<div id=\"caps1\" class=\"capsule\">" .
            "<dt class=\"product-name\">" . $nome . "</dt>\n" .
            "<dd class=\"product-price\">" . $prezzo[$i] . "</dd>\n</div>" .
            "<div id=\"caps2\" class=\"capsule\">" .
            "<div class=\"qty-container\"><div class=\"qty-input\">
            <input id=\"minus\" type=\"button\" value=\"-\" class=\"qty-count qty-count--minus \">
            <input id=\"qty\" type=\"number\" max=\"" . $disponibilita[$i] . "\" value=\"" . $quantita[$i] . "\" inputmode=\"numeric\" class=\"product-quantity quantity\" disabled>

            <input id=\"add\" type=\"button\" value=\"+\" class=\" qty-count qty-count--plus \">
            </div></div>" .
            "<input type=\"button\" value=\"Rimuovi\" class=\"removeItemCart\" id=\"removeCart\"name=\"removeCart" . $sku[$i] . "\">" . "</div></div>";

        $htmlProdotti .= $prova;
        $counter++;
    }
}

$_SESSION['cart_counter'] = $counter;

$paginaHTML = str_replace('{ciao}', $htmlProdotti, $paginaHTML);
$paginaHTML = str_replace('{count_cart}', $counter, $paginaHTML);
$paginaHTML = str_replace('src/pages/cart.html', 'cart.php', $paginaHTML);
$paginaHTML = str_replace('catalog.html?categoria=kbd', 'getCatalog.php?categoria=kbd&riferimento=', $paginaHTML);
$paginaHTML = str_replace('catalog.html?categoria=pc', 'getCatalog.php?categoria=pc&riferimento=', $paginaHTML);
$paginaHTML = str_replace('contacts.html', '../pages/contacts.html', $paginaHTML);
$paginaHTML = str_replace('faq.html', '../pages/faq.html', $paginaHTML);
$paginaHTML = str_replace('news.html', '../pages/news.html', $paginaHTML);
$paginaHTML = str_replace('profile.html', '../pages/profile.html', $paginaHTML);
$paginaHTML = str_replace('tos.html', '../pages/tos.html', $paginaHTML);
$paginaHTML = str_replace('privacy.html', '../pages/privacy.html', $paginaHTML);
$paginaHTML = str_replace('cookies.html', '../pages/cookies.html', $paginaHTML);


if (isset($_SESSION['user'])) {
    $scriptReplacementUser = '<script src="../JS/orderHandler.js" data-id="{SKU}" data-quantita="{QUANTITA}" data-oggetti="{OGGETTI}" data-prezzo="{PREZZO}" data-sessione="{SESSIONE}" data-nome="{NOME}" data-cognome="{COGNOME}" data-email="{EMAIL}" data-phone="{PHONE}" data-indirizzo="{INDIRIZZO}" data-citta="{CITTA}" data-cap="{CAP}">';
    $scripts = '';

    $skuValues = array();
    $quantitaValues = array();
    $oggettiValues = array();
    $prezzoValues = array();

    foreach ($sku as $i => $value) {
        $skuValues[] = $sku[$i];
        $quantitaValues[] = $quantita[$i];
        $oggettiValues[] = $nomeProdottoCompleto[$i];
        $prezzoValues[] = $prezzo[$i];
    }

    $listaInfo = $connection->getProfileInfo($username);
    if ($listaInfo != null) {
        $nome = $listaInfo[0];
        $cognome = $listaInfo[1];
        $email = $listaInfo[5];
        $phone = $listaInfo[7];
        $indirizzo = $listaInfo[9];
        $citta = $listaInfo[8];
        $cap = $listaInfo[10];
    }

    $script = str_replace('{SKU}', implode(',', $skuValues), $scriptReplacementUser);
    $script = str_replace('{QUANTITA}', implode(',', $quantitaValues), $script);
    $script = str_replace('{OGGETTI}', implode(',', $oggettiValues), $script);
    $script = str_replace('{PREZZO}', implode(',', $prezzoValues), $script);
    $script = str_replace('{SESSIONE}', $username, $script);
    $script = str_replace('{NOME}', $nome, $script);
    $script = str_replace('{COGNOME}', $cognome, $script);
    $script = str_replace('{EMAIL}', $email, $script);
    $script = str_replace('{PHONE}', $phone, $script);
    $script = str_replace('{INDIRIZZO}', $indirizzo, $script);
    $script = str_replace('{CITTA}', $citta, $script);
    $script = str_replace('{CAP}', $cap, $script);
    $scripts .= $script;
    $paginaHTML = str_replace('<script src="../js/orderHandler.js">', $scripts, $paginaHTML);
} else {

    $scriptReplacement = '<script src="../JS/orderHandler.js" data-id="{SKU}" data-quantita="{QUANTITA}" data-oggetti="{OGGETTI}" data-prezzo="{PREZZO}" data-sessione="{SESSIONE}">';
    $scripts = '';

    $skuValues = array();
    $quantitaValues = array();
    $oggettiValues = array();
    $prezzoValues = array();

    foreach ($sku as $i => $value) {
        $skuValues[] = $sku[$i];
        $quantitaValues[] = $quantita[$i];
        $oggettiValues[] = $nomeProdottoCompleto[$i];
        $prezzoValues[] = $prezzo[$i];
    }

    $script = str_replace('{SKU}', implode(',', $skuValues), $scriptReplacement);
    $script = str_replace('{QUANTITA}', implode(',', $quantitaValues), $script);
    $script = str_replace('{OGGETTI}', implode(',', $oggettiValues), $script);
    $script = str_replace('{PREZZO}', implode(',', $prezzoValues), $script);
    $script = str_replace('{SESSIONE}', 'non registrato', $script);
    $scripts .= $script;
    $paginaHTML = str_replace('<script src="../js/orderHandler.js">', $scripts, $paginaHTML);
}

$connection->closeDBConnection();


echo $paginaHTML;
