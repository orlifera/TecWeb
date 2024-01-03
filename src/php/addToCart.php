<?php

require_once "DBAccess.php";

use DB\DBAccess;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
setlocale(LC_ALL, 'it_IT');

$paginaHTML = file_get_contents(__DIR__ . "/../pages/cart.html");

$sku = $_GET['id'];
$nome = $_GET['nome'];
$tipo = $_GET['tipo'];
$descrizione = $_GET['descrizione'];
$prezzo = $_GET['prezzo'];
$colore = $_GET['colore'];
$quantita = $_GET['quantita'];
$path_image = $_GET['path'];
$categoria = $_GET['categoria'];

$connection = new DBAccess();
$connectionOk = $connection->openDBConnection();

if ($connectionOk) {
    $listaPC = $connection->insertToCart($sku, $nome, $tipo, $descrizione, $prezzo, $colore, $quantita, $path_image, $categoria);
} else {
    $stringaPC = "<p>I sistemi sono momentaneamente fuori servizio, ci scusiamo per il disagio</p>";
}
$connection->closeDBConnection();

header("Location: cart.php");
