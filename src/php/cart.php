<?php

require_once "DBAccess.php";

use DB\DBAccess;

session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
setlocale(LC_ALL, 'it_IT');

$paginaHTML = file_get_contents(__DIR__ . "/../pages/cart.html");

$listaPC = "";
$htmlProdotti = "";
$nomeProdottoCompleto = $prezzo = $path = $sku = $categoria = $quantita = $colore = $disponibilita =  [];
$counter = 0;

$connection = new DBAccess();
$connectionOk = $connection->openDBConnection();

if ($connectionOk) {
    $listaPC = $connection->getProductCart();
    // $prova = $connection->getProduct($categoria, $sku);

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
    $htmlProdotti = "<p>I sistemi sono momentaneamente fuori servizio, ci scusiamo per il disagio</p>";
}
$connection->closeDBConnection();

foreach ($nomeProdottoCompleto as $i => $nome) {
    if ($nome != null) {
        $prova = //"<dl class=\"productDetail\">\n" .
            "<a class=\"\" href=\"getProduct.php?categoria=" . $categoria[$i] . "&id=" . $sku[$i] . "\">\n" .
            "<img src=\"" . $path[$i] . "\" alt=\"image\">\n" .
            "<dt class=\"productName\">" . $nome . "</dt>\n" .
            "<dd class=\"productPrice\">" . $prezzo[$i] . "</dd>\n" .
            // <dt> Quantità scelta: " . $quantita[$i] . "</dt>\n
            //"<dt id=\"disponibilita\"> " . ($disponibilita[$i] > 10 ? "Disponibilità: "  .  $disponibilita[$i] : "Non disponibile") . "</dt>" .
            "</a>\n" .

            "<dd>Quantità</dd><div><div class=\"\">
            <input type=\"button\" value=\"-\" class=\"minus\">
            <input type=\"number\" max=\"" . $disponibilita[$i] . "\" value=\"" .  $quantita[$i] . "\" inputmode=\"numeric\" class=\"quantity\" disabled>
            <input type=\"button\" value=\"+\" class=\"plus\">
            </div></div>" .
            "<input type=\"button\" value=\"Rimuovi dal carrello\" class=\"removeCart\"name=\"removeCart" . $sku[$i] . "\">";
        //. "</dl>\n";
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

$scriptReplacement = '<script src="../js/orderHandler.js" data-id="{SKU}" data-quantita="{QUANTITA}">';
$scripts = '';

$skuValues = array();
$quantitaValues = array();

foreach ($sku as $i => $value) {
    $skuValues[] = $sku[$i];
    $quantitaValues[] = $quantita[$i];
}

$script = str_replace('{SKU}', implode(',', $skuValues), $scriptReplacement);
$script = str_replace('{QUANTITA}', implode(',', $quantitaValues), $script);
$scripts .= $script;

$paginaHTML = str_replace('<script src="../js/orderHandler.js">', $scripts, $paginaHTML);

echo $paginaHTML;
