<?php

//manca: 
// 2) collegamento al carrello
// 3) collegamento agli accessori

require_once "DBAccess.php";

use DB\DBAccess;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
setlocale(LC_ALL, 'it_IT');

$paginaHTML = file_get_contents(__DIR__ . "/../pages/catalog.html");

$listaPC = "";
$stringaPC = "";
$nomePc = "";
$prezzoPc = "";
$path_image = "";

$connection = new DBAccess();
$connectionOk = $connection->openDBConnection();

if ($connectionOk) {
    $listaPC = $connection->getNamePricePath();
    if ($listaPC != null) {
        foreach ($listaPC as $pc) {
            $stringaPC .= "<dt>" . $pc['Nome'] . "</dt>,";
            $prezzoPc .= "<dt>&euro;" . $pc['Prezzo'] . "</dt>,";
            $path_image .= $pc['path_immagine'] . ",";
        }
        $nomePc = explode(",", $stringaPC);
        $prezzo = explode(",", $prezzoPc);
        $path = explode(",", $path_image);
    } else {
        $stringaPC = "<p>Errore</p>";
    }
} else {

    $stringaPC = "<p>I sistemi sono momentaneamente fuori servizio, ci scusiamo per il disagio</p>";
}
$connection->closeDBConnection();


for ($i = 1; $nomePc[$i - 1] != null; $i++) {
    $paginaHTML = str_replace("{PRODOTTO$i}", $nomePc[$i - 1], $paginaHTML);
    $paginaHTML = str_replace("&euro;{PREZZO$i}", $prezzo[$i - 1], $paginaHTML);
    $paginaHTML = str_replace("pc$i.jpg", $path[$i - 1], $paginaHTML);
}



$paginaHTML = str_replace('src/php/getCatalog.php', 'getCatalog.php', $paginaHTML);

echo ($paginaHTML);
