<?php
require_once "DBAccess.php";

use DB\DBAccess;

session_start();
$_SESSION['cart_counter'] = isset($_SESSION['cart_counter']) ? $_SESSION['cart_counter'] : 0;
$cartCounter = $_SESSION['cart_counter'];

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
setlocale(LC_ALL, 'it_IT');

$paginaHTML = file_get_contents(__DIR__ . "/../pages/product.html");

$stringaPC = "";
$listaPC = "";
$prezzoPc = "";
$colorePc = "";
$disponibilita = "";
$path_image = "";
$tipoPC = "";
$descrizione = "";
$quantita = "";
$riferimento = "";
$categoria = $_GET['categoria'];
$sku = $_GET['id'];
$i = 0;

$colori = "";

$connection = new DBAccess();
$connectionOk = "";
$connectionOk = $connection->openDBConnection();

if ($connectionOk) {
    $listaPC = $connection->getProduct($categoria, $sku);

    if ($listaPC != null) {
        $stringaPC = "<dt class=\"product-name\">" . $listaPC[1] . "</dt>";
        $tipoPC = "<div class=\"product-info\"><dt class=\"product-type\"> Tipologia: </dt><dd>" . $listaPC[2] . "</dd></div>";
        $descrizione = "<div class=\"product-info\"><dt class=\"product-description\"></dt><dd>" . $listaPC[3] . "</dd></div>";
        $prezzoPc = "<div class=\"product-info\"><dt class=\"product-price\"> Prezzo:</dt><dd> €" . $listaPC[4] . "</dd></div>";


        if (!empty($listaPC[5]) && !empty($listaPC[6])) {
            $colorePc = explode(",", $listaPC[5]);

            $colori = " <label id='productColor' for='colore'>Colore:</label><select id=\"colore\">";

            foreach ($colorePc as $color) {
                $selected = ($color == 'nero') ? 'selected' : '';
                $colori .= "<option $selected tabindex=\"$i\">" . $color . "</option>";
                $i++;
            }

            $colori .= "</select>";
        }

        $disponibilita = "<dt class=\"disponibilita\"> " . ($listaPC[6] > 0 ? "Disponibilità: "  .  $listaPC[6] : "Non disponibile") . "</dt>";

        $quantita = $listaPC[6] > 0 ? "<dd>Quantità</dd><div class=\"qty-container\"><div class=\"qty-input\">
            <input id=\"minus\" type=\"button\" value=\"-\" class=\"qty-count qty-count--minus \">
            <input id=\"qty\" type=\"number\" max=\"" . $listaPC[6] . "\" value=\"" . ($listaPC[6] > 0 ? 1 : 0) . "\" inputmode=\"numeric\" class=\"product-quantity quantity\" >

            <input id=\"add\" type=\"button\" value=\"+\" class=\" qty-count qty-count--plus \">
            </div></div>" : "";

        $path_image = $listaPC[7];
        $riferimento = $listaPC[8];
    } else {
        $stringaPC = "<p>Errore</p>";
    }
} else {
    header("HTTP/1.0 404 Not Found");
    include("../pages/404.html");
    exit;
}

$connection->closeDBConnection();

$percorsoSostituzione = array(
    '{nomePC}', '{tipo}', '{prezzo}', '{colore}', '{Disponibilità}', '{quantita}', '{descrizione}', 'download1.jpg',
    'src/php/getProduct.php', 'src/pages/contacts.html', '{count_cart}', 'cart.html',
    'catalog.html?categoria=kbd', 'catalog.html?categoria=pc', 'faq.html', 'news.html', 'profile.html',
    'tos.html', 'privacy.html', 'cookies.html', 'login.html', 'signup.html', 'src/php/getCatalog.php?categoria=kbd&riferimento=',
    'src/php/getCatalog.php?categoria=pc&riferimento=', '<script src="../js/accessoriesHandler.js">', '<script src="../js/cart.js">'
);

$percorsoSostituzioneRelativo = array(
    $stringaPC, $tipoPC, $prezzoPc, $colori, $disponibilita, $quantita, $descrizione, $path_image,
    'getProduct.php', '../pages/contacts.html', $cartCounter, 'cart.php',
    'getCatalog.php?categoria=kbd&riferimento=', 'getCatalog.php?categoria=pc&riferimento=', '../pages/faq.html',
    '../pages/news.html', '../pages/profile.html', '../pages/tos.html', '../pages/privacy.html', '../pages/cookies.html',
    '../pages/login.html', '../pages/signup.html', 'getCatalog.php?categoria=kbd&riferimento=',
    'getCatalog.php?categoria=pc&riferimento=', '<script src="../js/accessoriesHandler.js" data-categoria="' . $_GET['categoria'] . '" data-riferimento="' . $_GET['categoria'] . '" >',
    '<script src="../js/cart.js" data-id="' . $_GET['id'] . '" data-categoria="' . $_GET['categoria'] . '">'
);

$paginaHTML = str_replace($percorsoSostituzione, $percorsoSostituzioneRelativo, $paginaHTML);

echo $paginaHTML;
