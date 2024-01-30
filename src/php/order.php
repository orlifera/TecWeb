<?php

require_once "DBAccess.php";
session_start();
$cartCounter =  0;
$_SESSION['cart_counter'] = $cartCounter;

use DB\DBAccess;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
setlocale(LC_ALL, 'it_IT');

$paginaHTML = file_get_contents(__DIR__ . "/../pages/payments.html");

$listaPC = "";

$sku = $_GET["id"];
$quantitaOrdinata = $_GET["quantitaOrdinata"];
$nomeUtente = $_GET["nome"];
$cognomeUtente = $_GET["cognome"];
$emailUtente = $_GET["email"];
$phoneUtente = $_GET["phone"];
$indirizzoUtente = $_GET["indirizzo"];
$cittaUtente = $_GET["citta"];
$capUtente = $_GET["cap"];
$prezzo = $_GET["prezzo"];

$quantitaRimanente = "";

$skuArray = explode(',', $sku);
$quantitaArray = explode(',', $quantitaOrdinata);

foreach ($skuArray as $i => $id) {
    $skuProdotto[] = $id;
}

foreach ($quantitaArray as $i => $id) {
    $quantita[] = $id;
}

$connection = new DBAccess();
$connectionOk = "";
$connectionOk = $connection->openDBConnection();

if ($connectionOk) {
    foreach ($skuProdotto as $i => $sku) {
        $quantitaOrdinata = $quantita[$i];
        $listaPC = $connection->getDisp($sku);
        if (!empty($listaPC)) {
            $quantitaRimanente = $listaPC[0] - $quantitaOrdinata;
            $listaPC = $connection->updateDisponibilitaProdotto($sku, $quantitaRimanente);
            $listaPC = $connection->insertNewOrder($quantitaOrdinata, $nomeUtente, $cognomeUtente, $emailUtente, $phoneUtente, $indirizzoUtente, $cittaUtente, $capUtente, $prezzo);
            $listaPC = $connection->deleteFromCart($sku);
        } else {
            $htmlProdotti = "<p>Errore</p>";
        }
    }
} else {
    $nomeProdottoCompleto = $prezzo = $path = $sku = [];
    header("HTTP/1.0 404 Not Found");
    include("../pages/404.html");
    exit;
}
$connection->closeDBConnection();

$paginaHTML = str_replace('src/pages/cart.html', 'cart.php', $paginaHTML);

$paginaHTML = str_replace('catalog.html?categoria=kbd', 'getCatalog.php?categoria=kbd', $paginaHTML);
$paginaHTML = str_replace('catalog.html?categoria=pc', 'getCatalog.php?categoria=pc', $paginaHTML);
$paginaHTML = str_replace('{count_cart}', $cartCounter, $paginaHTML);
$paginaHTML = str_replace('contacts.html', '../pages/contacts.html', $paginaHTML);
$paginaHTML = str_replace('faq.html', '../pages/faq.html', $paginaHTML);
$paginaHTML = str_replace('news.html', '../pages/news.html', $paginaHTML);
$paginaHTML = str_replace('profile.html', '../pages/profile.html', $paginaHTML);
$paginaHTML = str_replace('tos.html', '../pages/tos.html', $paginaHTML);
$paginaHTML = str_replace('privacy.html', '../pages/privacy.html', $paginaHTML);
$paginaHTML = str_replace('cookies.html', '../pages/cookies.html', $paginaHTML);



//sistemazione tutti collegamenti footer
echo $paginaHTML;
