<?php

require_once "DBAccess.php";


use DB\DBAccess;

session_start();
$cartCounter = $_SESSION['cart_counter'] = isset($_SESSION['cart_counter']) ? $_SESSION['cart_counter'] : 0;


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
$connectionOk = $connection->openDBConnection();

if ($connectionOk) {
    $listaPC = $connection->getProduct($categoria, $sku);
    if ($listaPC != null) {
        $stringaPC = "<dt id=\"nome\">" . $listaPC[1] . "</dt>";
        $tipoPC = "<dd id=\"tipo\"> Tipologia: " . $listaPC[2] . "</dd>";
        $descrizione = "<dd id=\"descrizione\">" . $listaPC[3] . "</dd>";
        $prezzoPc = "<dd id=\"prezzo\"> Prezzo: €" . $listaPC[4] . "</dd>";

        if (!empty($listaPC[5]) && !empty($listaPC[6])) {
            $colorePc = explode(",", $listaPC[5]);

            $colori = " <label id='productColor' for='colore'>Colore:</label><select id=\"colore\">";

            while (!empty($colorePc)) {

                $color = array_shift($colorePc);
                $selected = ($color == 'nero') ? 'selected' : '';
                $colori = $colori . "<option $selected tabindex=\"$i\">" . $color . "</option>";
                $i = $i + 1;
            }

            $colori = $colori . "</select>";
        } else {
        }

        $disponibilita = "<dd id=\"disponibilita\"> " . ($listaPC[6] > 0 ? "Disponibilità: "  .  $listaPC[6] : "Non disponibile") . "</dd>";

        $quantita = $listaPC[6] > 0 ? "<dd>Quantità</dd><div><div class=\"\">
            <input type=\"button\" value=\"-\" class=\"minus\">
            <input type=\"number\" max=\"" . $listaPC[6] . "\" value=\"" . ($listaPC[6] > 0 ? 1 : 0) . "\" inputmode=\"numeric\" class=\"quantity\" disabled>

            <input type=\"button\" value=\"+\" class=\"plus\">
            </div></div>" : "";

        $path_image = $listaPC[7];
        $riferimento = $listaPC[8];
    } else {
        $stringaPC = "<p>Errore</p>";
    }
} else {
    $stringaPC = "<p>I sistemi sono momentaneamente fuori servizio, ci scusiamo per il disagio</p>";
}
$connection->closeDBConnection();


$paginaHTML = str_replace('{nomePC}', $stringaPC, $paginaHTML);
$paginaHTML = str_replace('{tipo}', $tipoPC, $paginaHTML);
$paginaHTML = str_replace('{prezzo}', $prezzoPc, $paginaHTML);
$paginaHTML = str_replace('{colore}', $colori, $paginaHTML);
$paginaHTML = str_replace('{Disponibilità}', $disponibilita, $paginaHTML);
$paginaHTML = str_replace('{quantita}', $quantita, $paginaHTML);
$paginaHTML = str_replace('{descrizione}', $descrizione, $paginaHTML);
$paginaHTML = str_replace('download1.jpg', $path_image, $paginaHTML);
$paginaHTML = str_replace('src/php/getProduct.php', 'getProduct.php', $paginaHTML);
$paginaHTML = str_replace('src/pages/contacts.html', '../pages/contacts.html', $paginaHTML);
$paginaHTML = str_replace('{count_cart}', $cartCounter, $paginaHTML);
$paginaHTML = str_replace('cart.html', 'cart.php', $paginaHTML);
$paginaHTML = str_replace('catalog.html?categoria=kbd', 'getCatalog.php?categoria=kbd&riferimento=', $paginaHTML);
$paginaHTML = str_replace('catalog.html?categoria=pc', 'getCatalog.php?categoria=pc&riferimento=', $paginaHTML);
$paginaHTML = str_replace('faq.html', '../pages/faq.html', $paginaHTML);
$paginaHTML = str_replace('news.html', '../pages/news.html', $paginaHTML);
$paginaHTML = str_replace('profile.html', '../pages/profile.html', $paginaHTML);
$paginaHTML = str_replace('tos.html', '../pages/tos.html', $paginaHTML);
$paginaHTML = str_replace('privacy.html', '../pages/privacy.html', $paginaHTML);
$paginaHTML = str_replace('cookies.html', '../pages/cookies.html', $paginaHTML);
$paginaHTML = str_replace('login.html', '../pages/login.html', $paginaHTML);
$paginaHTML = str_replace('signup.html', '../pages/signup.html', $paginaHTML);

$paginaHTML = str_replace('src/php/getCatalog.php?categoria=kbd&riferimento=', 'getCatalog.php?categoria=kbd&riferimento=', $paginaHTML);
$paginaHTML = str_replace('src/php/getCatalog.php?categoria=pc&riferimento=', 'getCatalog.php?categoria=pc&riferimento=', $paginaHTML);


$paginaHTML = str_replace('<script src="../js/accessoriesHandler.js">', '<script src="../js/accessoriesHandler.js" data-categoria="' . $_GET['categoria'] . '" data-riferimento="' . $riferimento . '" >', $paginaHTML);

$paginaHTML = str_replace('<script src="../js/cart.js">', '<script src="../js/cart.js" data-id="' . $_GET['id'] . '" data-categoria="' . $_GET['categoria'] . '">', $paginaHTML);


echo ($paginaHTML);
