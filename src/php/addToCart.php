<?php
/* Inserisce un prodotto nel database, tabella "carrello" */

require_once "DBAccess.php";
session_start();
$username = isset($_SESSION['user']) ? $_SESSION['user'] : 'non registrato';

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
$utente = $_GET['utente'];

$connection = new DBAccess();
$connectionOk = "";
$connectionOk = $connection->openDBConnection();


if ($connectionOk) {
    if (isset($_SESSION['user']))
        $listaPC = $connection->insertToCartReg($sku, $nome, $tipo, $prezzo, $colore, $quantita, $path_image, $categoria, $utente);
    else
        $listaPC = $connection->insertToCart($sku, $nome, $tipo, $prezzo, $colore, $quantita, $path_image, $categoria);
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


header("Location: cart.php");
