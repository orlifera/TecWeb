<?php
require_once "DBAccess.php";


use DB\DBAccess;

session_start();
$cartCounter = isset($_SESSION['cart_counter']) ? $_SESSION['cart_counter'] : 0;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
setlocale(LC_ALL, 'it_IT');

$paginaHTML = file_get_contents(__DIR__ . "/../pages/catalog.html");
$indexHTML = file_get_contents(__DIR__ . "../../index.html");

$listaPC = "";
$stringaPC = "";
$nomePc = "";
$prezzoPc = "";
$path_image = "";
$categoria = $_GET['categoria'];
$riferimento = $_GET['riferimento'];
$sku = "";
$htmlProdotti = "";

//dona
$indexProdotti = "";

$connection = new DBAccess();
$connectionOk = $connection->openDBConnection();
if ($connectionOk) {
    if (!empty($riferimento)) {
        $listaPC = $connection->getNamePricePath1($categoria, $riferimento);
        if ($listaPC != null) {
            foreach ($listaPC as $pc) {
                $stringaPC .= "<dt class=\"pName\">" . $pc['Nome'] . "</dt>,";
                $prezzoPc .= "<dt class=\"pPrice\">&euro;" . $pc['Prezzo'] . "</dt>,";
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
        $listaPC = $connection->getNamePricePath($categoria);

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
    }
} else {

    $stringaPC = "<p>I sistemi sono momentaneamente fuori servizio, ci scusiamo per il disagio</p>";
}
$connection->closeDBConnection();
if ($nomePc != null) {
    foreach ($nomePc as $i => $nome) {
        if ($nome != null) {
            // $prova = "<li>\n" . ""
            $prova = "<a class=\"product-card\" href=\"getProduct.php?categoria=" . $categoria . "&id=" . $sku1[$i] . "\">\n" . "<img src=\"" . $path[$i] . "\"" . "alt=\"image\">\n"  .  $nome .   $prezzo[$i]  . "</a>\n";
            // $prova = "<div class=\"cell\">\n" . "<a class=\"\" href=\"getProduct.php?categoria=" . $categoria . "&id=" . $sku1[$i] . "\">\n" . "<img src=\"" . $path[$i] . "\"" . "alt=\"image\">\n" . "<dt>" .  $nome .  "</dt>" . "<dd>" . $prezzo[$i] . "</dd>\n" . "</a>\n" . "</div>\n";
            //variabile in più per concatenare i vari prodotti
            $htmlProdotti .= $prova;
        }
    }
} else {
    $htmlProdotti = "<p>Siamo spiacenti, i prodotti che cerca momentaneamente esauriti, ci scusiamo per il disagio</p>";
}

//dona
if ($nomePc != null) {
    $prodotto1 = "<a class=\"product-card\" href=\"getProduct.php?categoria=pc" . "&id=" . $sku1[1] . "\">\n" . "<img src=\"" . $path[1] . "\"" . "alt=\"image\">\n"  .  $nomePc[1] .   $prezzo[1]  . "</a>\n";
    $prodotto2 = "<a class=\"product-card\" href=\"getProduct.php?categoria=kbd" . "&id=" . $sku1[11] . "\">\n" . "<img src=\"" . $path[5] . "\"" . "alt=\"image\">\n"  .  $nomePc[5] .   $prezzo[5]  . "</a>\n";
    $prodotto3 = "<a class=\"product-card\" href=\"getProduct.php?categoria=pc" . "&id=" . $sku1[5] . "\">\n" . "<img src=\"" . $path[11] . "\"" . "alt=\"image\">\n"  .  $nomePc[11] .   $prezzo[11]  . "</a>\n";
    $indexProdotti .= $prodotto1 . $prodotto2 . $prodotto3;
} else {
    $indexProdotti = "<p>Siamo spiacenti, i prodotti che cerca momentaneamente esauriti, ci scusiamo per il disagio</p>";
}

$paginaHTML = str_replace('{prodotto}', $htmlProdotti, $paginaHTML);
$paginaHTML = str_replace('cart.html', 'cart.php', $paginaHTML);
$paginaHTML = str_replace('src/php/getCatalog.php?categoria=kbd&riferimento=', 'getCatalog.php?categoria=kbd&riferimento=', $paginaHTML);
$paginaHTML = str_replace('src/php/getCatalog.php?categoria=pc&riferimento=', 'getCatalog.php?categoria=pc&riferimento=', $paginaHTML);

$paginaHTML = str_replace('catalog.html?categoria=kbd', 'getCatalog.php?categoria=kbd&riferimento=', $paginaHTML);
$paginaHTML = str_replace('catalog.html?categoria=pc', 'getCatalog.php?categoria=pc&riferimento=', $paginaHTML);
$paginaHTML = str_replace('{count_cart}', $cartCounter, $paginaHTML);


$paginaHTML = str_replace('src/pages/contacts.html', '../pages/contacts.html', $paginaHTML);
$paginaHTML = str_replace('catalog.html', '../pages/catalog.html', $paginaHTML);
$paginaHTML = str_replace('faq.html', '../pages/faq.html', $paginaHTML);
$paginaHTML = str_replace('news.html', '../pages/news.html', $paginaHTML);
$paginaHTML = str_replace('profile.html', '../pages/profile.html', $paginaHTML);
$paginaHTML = str_replace('tos.html', '../pages/tos.html', $paginaHTML);
$paginaHTML = str_replace('privacy.html', '../pages/privacy.html', $paginaHTML);
$paginaHTML = str_replace('cookies.html', '../pages/cookies.html', $paginaHTML);

$paginaHTML = str_replace('login.html', '../pages/login.html', $paginaHTML);
$paginaHTML = str_replace('signup.html', '../pages/signup.html', $paginaHTML);

$indexHTML = str_replace('{prodotto}', $indexProdotti, $indexHTML);

echo($indexHTML);
echo($paginaHTML);
