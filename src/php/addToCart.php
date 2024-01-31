<?php

require_once "DBAccess.php";
session_start();
$cartCounter = isset($_SESSION['cart_counter']) ? $_SESSION['cart_counter'] + 1 : 0;

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
$connectionOk = "";
$connectionOk = $connection->openDBConnection();

$_SESSION['cart_counter'] = $cartCounter;

if ($connectionOk) {
    $listaPC = $connection->insertToCart($sku, $nome, $tipo, $descrizione, $prezzo, $colore, $quantita, $path_image, $categoria);
    if ($listaPC) {
        echo '<p class="confirmDati">Prodotto aggiunto al carrello!</p>';
    } else {
        echo '<p class="errorDati">Prodotto non inserito, ti preghiamo di riprovare</p>';
    }
} else {
    header("HTTP/1.0 404 Not Found");
    include("../pages/404.html");
    exit;
}
$connection->closeDBConnection();


header("Location: getProduct.php?id=$sku&categoria=$categoria");
