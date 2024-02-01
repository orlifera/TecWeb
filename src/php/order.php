<?php

require_once "DBAccess.php";
session_start();
$cartCounter = 0;
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
$prezzoTotale = $_GET["prezzo"];
$oggettiOrdinati = $_GET["oggetti"];
$quantitaRimanente = "";

$skuArray = explode(',', $sku);
$quantitaArray = explode(',', $quantitaOrdinata);
$oggettiArray = explode(',', $oggettiOrdinati);

$oggettiOrdinatiTotale = "";

foreach ($skuArray as $i => $id) {
    $skuProdotto[] = $id;
}

foreach ($quantitaArray as $i => $id) {
    $quantita[] = $id;
}

foreach ($oggettiArray as $i => $id) {
    $oggetti[] = $id;
    $oggettiOrdinatiTotale .= $id . ",";
}


$oggettiOrdinatiTotale = implode(",", array_unique($oggettiArray));

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
        } else {
            $htmlProdotti = "<p>Errore</p>";
        }
        $listaPC = $connection->deleteFromCart($sku);
    }

    $listaPC = $connection->insertNewOrder(
        $nomeUtente,
        $cognomeUtente,
        $emailUtente,
        $phoneUtente,
        $indirizzoUtente,
        $cittaUtente,
        $capUtente,
        $quantitaOrdinata,
        $prezzoTotale,
        $oggettiOrdinatiTotale
    );
} else {
    $nomeProdottoCompleto = $prezzo = $path = $sku = [];
    header("HTTP/1.0 404 Not Found");
    include("../pages/404.html");
    exit;
}
$connection->closeDBConnection();

$paginaHTML = str_replace('src/pages/cart.html', 'cart.php', $paginaHTML);

echo $paginaHTML;
