<?php
/* Rimuove un prodotto dal database prodotto */

require_once "DBAccess.php";

use DB\DBAccess;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
setlocale(LC_ALL, 'it_IT');

$category = $_GET['category'];
$id = $_GET['id'];
$id = explode(",", $id);
$connection = new DBAccess();
$connectionOk = "";
$connectionOk = $connection->openDBConnection();

if ($connectionOk) {
    if ($category == "product") {

        while (!empty($id)) {
            $currentId = $id[0];
            $listaPC = $connection->deleteProductAdmin($currentId);
            array_shift($id);
        }
    } else if ($category == "sale") {
        while (!empty($id)) {
            $currentId = $id[0];
            $listaPC = $connection->deleteSale($currentId);
            array_shift($id);
        }
    } else {
        while (!empty($id)) {
            $currentId = $id[0];
            $listaPC = $connection->deleteOrder($currentId);
            array_shift($id);
        }
    }
} else {
    header("HTTP/1.0 404 Not Found");
    include("../pages/404.html");
    exit;
}
$connection->closeDBConnection();

header("Location: productAdmin.php");
