<?php

require_once "DBAccess.php";

use DB\DBAccess;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
setlocale(LC_ALL, 'it_IT');

$paginaHTML = file_get_contents(__DIR__ . "/../pages/cart.html");

$listaPC = "";
$htmlProdotti = "";
$nomeProdottoCompleto = $prezzo = $path = $sku = $categoria = $quantita = $colore = [];

$connection = new DBAccess();
$connectionOk = $connection->openDBConnection();

if ($connectionOk) {
    $listaPC = $connection->getProductCart();

    if (!empty($listaPC)) {
        $nomeProdottoCompleto = $prezzo = $path = $sku = $categoria = $quantita = $colore = [];

        foreach ($listaPC as $pc) {
            $nomeProdottoCompleto[] = "<dt>" . htmlspecialchars($pc['nome']) . "</dt>";
            $prezzo[] = "<dt>&euro;" . htmlspecialchars($pc['prezzo']) . "</dt>";
            $path[] = htmlspecialchars($pc['path_immagine']);
            $sku[] = htmlspecialchars($pc['sku']);
            $categoria[] = htmlspecialchars($pc['categoria']);
            $quantita[] = htmlspecialchars($pc['quantitaScelta']);
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
        $prova = "<div class=\"cell\">\n" .
            "<a class=\"\" href=\"getProduct.php?categoria=" . $categoria[$i] . "&id=" . $sku[$i] . "\">\n" .
            "<img src=\"" . $path[$i] . "\" alt=\"image\">\n" .
            $nome .
            $prezzo[$i] .
            "<dt> Quantità scelta: " . $quantita[$i] . "</dt>\n" .
            "</a>\n" .
            "</div>\n" .
            "<input type=\"button\" value=\"Rimuovi dal carrello\" class=\"removeCart\"name=\"removeCart" . $sku[$i] . "\">";
        $htmlProdotti .= $prova;
    }
}

$paginaHTML = str_replace('{ciao}', $htmlProdotti, $paginaHTML);

$paginaHTML = str_replace('src/pages/cart.html', 'cart.php', $paginaHTML);

$paginaHTML = str_replace('catalog.html?categoria=kbd', 'getCatalog.php?categoria=kbd&riferimento=', $paginaHTML);


$paginaHTML = str_replace('catalog.html?categoria=pc', 'getCatalog.php?categoria=pc&riferimento=', $paginaHTML);

// $paginaHTML = str_replace('../php/order.php', 'order.php?sku=' . $sku[0], $paginaHTML);

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
