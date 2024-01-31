<?php

require_once "DBAccess.php";

use DB\DBAccess;

session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
setlocale(LC_ALL, 'it_IT');

$paginaHTML = file_get_contents(__DIR__ . "/../pages/viewDetails.html");

$listaPC = "";
$htmlProdotti = "";
$id = $_GET['id'];
$connection = new DBAccess();
$connectionOk = $connection->openDBConnection();

if ($connectionOk) {
    $codice = $_GET['id'];
    $ids = explode(",", $codice);
    $result = [];
    $htmlProdotti = '';

    foreach ($ids as $code) {
        try {
            $listaordini = $connection->getOrdiniAdmin($code);

            if ($listaordini !== null) {
                $result[$code] = [
                    'id' => $listaordini[0],
                    'nome' => $listaordini[1],
                    'cognome' => $listaordini[2],
                    'email' => $listaordini[3],
                    'numero' => $listaordini[4],
                    'indirizzo' => $listaordini[5],
                    'citta' => $listaordini[6],
                    'cap' => $listaordini[7],
                    'quantitaOrdinata' => $listaordini[8],
                    'prezzo' => $listaordini[9],
                    'oggetti_ordinati' => $listaordini[10],
                ];
            } else {
                $result[$code] = ['id' => "<p>Errore</p>"];
            }
        } catch (Exception $e) {
            echo 'Errore durante l\'ottenimento degli ordini.';
        }
    }
} else {
    $nomeProdottoCompleto = $prezzo = $path = $sku = [];
    header("HTTP/1.0 404 Not Found");
    include("../pages/404.html");
    exit;
}
$connection->closeDBConnection();

foreach ($result as $code => $data) {
    if (isset($data['id'])) {
        $prova = "<h2 class=\"headings admin\">Ordine {$data['id']}</h2>" .
            "<li>" . $data['nome'] . "</li>" .
            "<li>" . $data['cognome'] . "</li>" .
            "<li>" . $data['email'] . "</li>" .
            "<li>" . $data['numero'] . "</li>" .
            "<li>" . $data['indirizzo'] . "</li>" .
            "<li>" . $data['citta'] . "</li>" .
            "<li>" . $data['cap'] . "</li>" .
            "<li>" . $data['quantitaOrdinata'] . "</li>" .
            "<li>" . $data['prezzo'] . "</li>" .
            "<li>" . $data['oggetti_ordinati'] . "</li>";
        $htmlProdotti .= $prova;
    }
}

$paginaHTML = str_replace('{dettagli}', $htmlProdotti, $paginaHTML);
$paginaHTML = str_replace('src/pages/cart.html', 'cart.php', $paginaHTML);
$paginaHTML = str_replace('catalog.html?categoria=kbd', 'getCatalog.php?categoria=kbd&riferimento=', $paginaHTML);
$paginaHTML = str_replace('catalog.html?categoria=pc', 'getCatalog.php?categoria=pc&riferimento=', $paginaHTML);
$paginaHTML = str_replace('contacts.html', '../pages/contacts.html', $paginaHTML);
$paginaHTML = str_replace('faq.html', '../pages/faq.html', $paginaHTML);
$paginaHTML = str_replace('news.html', '../pages/news.html', $paginaHTML);
$paginaHTML = str_replace('profile.html', '../pages/profile.html', $paginaHTML);
$paginaHTML = str_replace('tos.html', '../pages/tos.html', $paginaHTML);
$paginaHTML = str_replace('privacy.html', '../pages/privacy.html', $paginaHTML);
$paginaHTML = str_replace('cookies.html', '../pages/cookies.html', $paginaHTML);

$scriptReplacement = '<script src="../js/orderHandler.js" data-id="{SKU}" data-quantita="{QUANTITA}" data-oggetti="{OGGETTI}" data-prezzo="{PREZZO}">';
$scripts = '';

echo $paginaHTML;
