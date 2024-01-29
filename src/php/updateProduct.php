<?php

require_once "DBAccess.php";

use DB\DBAccess;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
setlocale(LC_ALL, 'it_IT');

$connection = new DBAccess();
$connectionOk = "";
$connectionOk = $connection->openDBConnection();

$variabile_dec = $_GET['variabile_decisionale'];

if ($connectionOk) {
    if ($variabile_dec == "product") {
        $sku = $_GET['id'];
        $nome = $_GET['nome'];
        $tipo = $_GET['tipo'];
        $descrizione = $_GET['descrizione'];
        $prezzo = $_GET['prezzo'];
        $colore = $_GET['colore'];
        $disponibilita = $_GET['disponibilita'];
        $path_image = $_GET['path'];
        $categoria = $_GET['categoria'];
        $riferimento = $_GET['riferimento'];


        $listaPC = $connection->updateProduct($sku, $nome, $tipo, $descrizione, $prezzo, $colore, $disponibilita, $path_image, $categoria, $riferimento);
    } else if ($variabile_dec == "sale") {
        $codice = $_GET['id'];
        $data_emissione = $_GET['data_emissione'];
        $data_scadenza = $_GET['data_scadenza'];
        $username = $_GET['username'];
        $isUsed = $_GET['isUsed'];
        $valore = $_GET['valore'];
        $listaSconti = $connection->updateSale($codice, $data_emissione, $data_scadenza, $username, $isUsed, $valore);
    } else {
        $codice = $_GET['id'];
        $utente = $_GET['utente'];
        $quantitaOrdinata = $_GET['quantitaOrdinata'];
        $indirizzo = $_GET['indirizzo'];
        $prezzo = $_GET['prezzo'];

        $listaSconti = $connection->updateOrder($codice, $utente, $quantitaOrdinata, $indirizzo, $prezzo);
    }
} else {
    header("HTTP/1.0 404 Not Found");
    include("../pages/404.html");
    exit;
}
$connection->closeDBConnection();


header("Location: productAdmin.php");
