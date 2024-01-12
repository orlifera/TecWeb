<?php

require_once "DBAccess.php";

use DB\DBAccess;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
setlocale(LC_ALL, 'it_IT');

$paginaHTML = file_get_contents(__DIR__ . "/../pages/cart.html");

$connection = new DBAccess();
$connectionOk = $connection->openDBConnection();

if ($connectionOk) {
    $listaPC = $connection->deleteAllCart();
} else {
    $stringaPC = "<p>I sistemi sono momentaneamente fuori servizio, ci scusiamo per il disagio</p>";
}
$connection->closeDBConnection();

header("Location: cart.php");
