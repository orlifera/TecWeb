<?php

require_once "DBAccess.php";

use DB\DBAccess;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
setlocale(LC_ALL, 'it_IT');

$paginaHTML = file_get_contents(__DIR__ . "/../pages/accessories.html");

$listaVentola = "";
$stringaVentola = "";
$nomeVentola = "";
$prezzoVentola = "";
$path_image = "";

$connection = new DBAccess();
$connectionOk = $connection->openDBConnection();

if ($connectionOk) {
    $listaVentola = $connection->getNamePricePathAcc();
    if ($listaVentola != null) {
        foreach ($listaVentola as $tast) {
            $stringaVentola .= "<dt>" . $tast['Nome'] . "</dt>,";
            $prezzoVentola .= "<dt>&euro;" . $tast['Prezzo'] . "</dt>,";
            $path_image .= $tast['path_immagine'] . ",";
        }
        $nomeVentola = explode(",", $stringaVentola);
        $prezzo = explode(",", $prezzoVentola);
        $path = explode(",", $path_image);
    } else {
        $stringaVentola = "<p>Errore</p>";
    }
} else {

    $stringaVentola = "<p>I sistemi sono momentaneamente fuori servizio, ci scusiamo per il disagio</p>";
}
$connection->closeDBConnection();


for ($i = 0; $nomeVentola[$i] != null; $i++) {
    $prova = $i + 1;
    $paginaHTML = str_replace("{PRODOTTO$prova}", $nomeVentola[$i], $paginaHTML);
    $paginaHTML = str_replace("&euro;{PREZZO$prova}", $prezzo[$i], $paginaHTML);
    $paginaHTML = str_replace("pc$prova.jpg", $path[$i], $paginaHTML);
}

echo ($paginaHTML);
