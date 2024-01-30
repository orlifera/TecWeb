<?php
require_once "DBAccess.php";

use DB\DBAccess;

session_start();
$cartCounter = empty($_SESSION['cart_counter']) ? 0 : $_SESSION['cart_counter'];

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
$categoria = $_GET['categoria'];
$riferimento = $_GET['riferimento'];
$sku = "";
$htmlProdotti = "";

$connection = new DBAccess();
$connectionOk = "";
$connectionOk = $connection->openDBConnection();

if ($connectionOk) {
    if (!empty($riferimento)) {
        $listaPC = $connection->getNamePricePath1($categoria, $riferimento);
    } else {
        $listaPC = $connection->getNamePricePath($categoria);
    }

    if ($listaPC != null) {
        foreach ($listaPC as $pc) {
            $stringaPC .= "<dt class=\"pName\">" . $pc['Nome'] . "</dt>,";
            $prezzoPc .= "<dt class=\"pPrice\">&euro;" . $pc['Prezzo'] . "</dt>,";
            $path_image .= $pc['path_immagine'] . ",";
            $sku .= $pc['SKU'] . ",";
        }

        $nomePc = explode(",", $stringaPC);
        $prezzo = explode(",", $prezzoPc);
        $path = explode(",", $path_image);
        $sku1 = explode(",", $sku);
    } else {
        $stringaPC = "<p>Errore</p>";
    }
} else {
    header("HTTP/1.0 404 Not Found");
    include("../pages/404.html");
    exit;
}

$connection->closeDBConnection();

if ($nomePc != null) {
    foreach ($nomePc as $i => $nome) {
        if ($nome != null) {
            $prova = "<a class=\"product-card\" href=\"getProduct.php?categoria=" . $categoria . "&id=" . $sku1[$i] . "\">\n" . "<img src=\"" . $path[$i] . "\"" . "alt=\"image\">\n"  .  $nome .   $prezzo[$i]  . "</a>\n";
            $htmlProdotti .= $prova;
        }
    }
} else {
    $htmlProdotti = "<p>Siamo spiacenti, i prodotti che cerca momentaneamente esauriti, ci scusiamo per il disagio</p>";
}

$ricerca = array('cart.html', 'src/php/getCatalog.php?categoria=kbd&riferimento=', 'src/php/getCatalog.php?categoria=pc&riferimento=');
$sostituzione = array('cart.php', 'getCatalog.php?categoria=kbd&riferimento=', 'getCatalog.php?categoria=pc&riferimento=');
$paginaHTML = str_replace($ricerca, $sostituzione, $paginaHTML);

$percorsoSostituzione = array(
    'src/pages/contacts.html', 'catalog.html', 'faq.html', 'news.html', 'profile.html',
    'tos.html', 'privacy.html', 'cookies.html', 'login.html', 'signup.html'
);

$percorsoSostituzioneRelativo = array(
    '../pages/contacts.html', '../pages/catalog.html', '../pages/faq.html', '../pages/news.html',
    '../pages/profile.html', '../pages/tos.html', '../pages/privacy.html', '../pages/cookies.html',
    '../pages/login.html', '../pages/signup.html'
);

$paginaHTML = str_replace($percorsoSostituzione, $percorsoSostituzioneRelativo, $paginaHTML);

$paginaHTML = str_replace('{prodotto}', $htmlProdotti, $paginaHTML);
$paginaHTML = str_replace('{count_cart}', $cartCounter, $paginaHTML);

echo $paginaHTML;
