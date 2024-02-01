<?php
/* Rimuove un singolo prodotto dal carrello */

require_once "DBAccess.php";

use DB\DBAccess;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
setlocale(LC_ALL, 'it_IT');

$paginaHTML = file_get_contents(__DIR__ . "/../pages/cart.html");

$sku = $_GET['id'];

$connection = new DBAccess();
$connectionOk = "";
$connectionOk = $connection->openDBConnection();

if ($connectionOk) {
    $listaPC = $connection->deleteFromCart($sku);
} else {
    header("HTTP/1.0 404 Not Found");
    include("../pages/404.html");
    exit;
}
$connection->closeDBConnection();

header("Location: cart.php");
