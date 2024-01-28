<?php
require_once "DBAccess.php";


use DB\DBAccess;

session_start();
$cartCounter = isset($_SESSION['cart_counter']) ? $_SESSION['cart_counter'] : 0;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
setlocale(LC_ALL, 'it_IT');

$paginaHTML = file_get_contents(__DIR__ . "/../pages/productAdmin.html");


$listaPC = "";
$stringaPC = "";
$nomePc = "";
$tipoPC = "";
$descrizionePC = "";
$prezzoPc = "";
$colorePc = "";
$disponibilita = "";
$path_image = "";
$categoria = "";
$riferimento = "";
$sku = "";
$prodottiPcKbd = "";
$prodottiTotali = "";
$prodottiAcc = "";
$ordini = "";

$connection = new DBAccess();
$connectionOk = "";
$connectionOk = $connection->openDBConnection();
if ($connectionOk) {
    $listaPC = $connection->getProductPcKbd();
    $length = count($listaPC);
    if ($listaPC != null) {
        foreach ($listaPC as $pc) {
            $sku .=  $pc['sku'] . ",";
            $nomePc .= $pc['nome'] . ",";
            $tipoPC .= $pc['tipo'] . ",";
            $descrizionePC .= $pc['descrizione'] . ",";
            $prezzoPc .= "&euro;" . $pc['prezzo'] . ",";
            $colorePc .= $pc['colore'] . ",";
            $disponibilita .= $pc['disponibilita'] . ",";
            $path_image .= $pc['path_immagine'] . ",";
            $categoria .=  $pc['categoria'] . ",";
            $riferimento .= $pc['riferimento'] . ",";
        }
        $sku = explode(",", $sku);
        $nomePc = explode(",", $nomePc);
        $tipoPC = explode(",", $tipoPC);
        $descrizionePC = explode(",", $descrizionePC);
        $prezzoPc = explode(",", $prezzoPc);
        $colorePc = explode(",", $colorePc);
        $disponibilita = explode(",", $disponibilita);
        $path_image = explode(",", $path_image);
        $categoria = explode(",", $categoria);
        $riferimento = explode(",", $riferimento);
    } else {
        $stringaPC = "<p>Errore</p>";
    }
} else {

    header("HTTP/1.0 404 Not Found");
    include("../pages/404.html");
    exit;
}
$connection->closeDBConnection();


//$nome contiene il valore corrente mentre $i contiene l'indice corrente, $nomePc è l'array dove itero
foreach ($nomePc as $i => $nome) {
    if ($nome != null) {
        $prova = "<li>\n" .
            "<a class=\"\" href=\"getProduct.php?categoria=" . $categoria[$i] . "&id=" . $sku[$i] . "\">" .
            "<input type=\"checkbox\" class=\"" . $categoria[$i] . "\" id=\"" . $sku[$i] . "\">\n" .
            "<label for=\"" . $sku[$i] . "\">" . $nome . "</label>\n" .
            "</a>\n" .
            "</li>\n";
        $prodottiPcKbd .= $prova;
    }
}
unset($sku, $nomePc, $tipoPC, $descrizionePC, $prezzoPc, $colorePc, $disponibilita, $path_image, $categoria, $riferimento);

/* PARTE  */
$sku = $nomePc = $tipoPC = $descrizionePC = $prezzoPc = $colorePc = $disponibilita = $path_image = $categoria = $riferimento = "";

$connectionOk = $connection->openDBConnection();
if ($connectionOk) {
    $listaPC = $connection->getProductAcc();
    $length = count($listaPC);
    if ($listaPC != null) {
        foreach ($listaPC as $pc) {
            $sku .=  $pc['sku'] . ",";
            $nomePc .= $pc['nome'] . ",";
            $tipoPC .= $pc['tipo'] . ",";
            $descrizionePC .= $pc['descrizione'] . ",";
            $prezzoPc .= "&euro;" . $pc['prezzo'] . ",";
            $colorePc .= $pc['colore'] . ",";
            $disponibilita .= $pc['disponibilita'] . ",";
            $path_image .= $pc['path_immagine'] . ",";
            $categoria .=  $pc['categoria'] . ",";
            $riferimento .= $pc['riferimento'] . ",";
        }
        $sku = explode(",", $sku);
        $nomePc = explode(",", $nomePc);
        $tipoPC = explode(",", $tipoPC);
        $descrizionePC = explode(",", $descrizionePC);
        $prezzoPc = explode(",", $prezzoPc);
        $colorePc = explode(",", $colorePc);
        $disponibilita = explode(",", $disponibilita);
        $path_image = explode(",", $path_image);
        $categoria = explode(",", $categoria);
        $riferimento = explode(",", $riferimento);
    } else {
        $stringaPC = "<p>Errore</p>";
    }
} else {

    header("HTTP/1.0 404 Not Found");
    include("../pages/404.html");
    exit;
}
$connection->closeDBConnection();

foreach ($nomePc as $i => $nome) {
    if ($nome != null) {
        $prova = "<li>\n" .
            "<a class=\"\" href=\"getProduct.php?categoria=" . $categoria[$i] . "&id=" . $sku[$i] . "\">" .
            "<input type=\"checkbox\" class=\"" . $categoria[$i] . "\" id=\"" . $sku[$i] . "\">\n" .
            "<label for=\"" . $sku[$i] . "\">" . $nome . "</label>\n" .
            "</a>\n" .
            "</li>\n";
        $prodottiAcc .= $prova;
    }
}
/* FINE PARTE ACCESSORI */

/* PARTE SCONTI */

$sconti = "";
$codiceSconto = "";
$emissioneSconto = "";
$scadenzaSconto = "";
$usernameSconto = "";
$isUsedSconto = "";
$valoreSconto = "";

$connectionOk = $connection->openDBConnection();
if ($connectionOk) {
    $listaPC = $connection->getSconti();
    $length = count($listaPC);
    if ($listaPC != null) {
        foreach ($listaPC as $pc) {
            $codiceSconto .=  $pc['codice'] . ",";
            $emissioneSconto .= $pc['data_emissione'] . ",";
            $scadenzaSconto .= $pc['data_scadenza'] . ",";
            $usernameSconto .= $pc['username'] . ",";
            $isUsedSconto .= $pc['isUsed'] . ",";
            $valoreSconto .= $pc['valore'] . ",";
        }
        $codiceSconto = explode(",", $codiceSconto);
        $emissioneSconto = explode(",", $emissioneSconto);
        $scadenzaSconto = explode(",", $scadenzaSconto);
        $usernameSconto = explode(",", $usernameSconto);
        $isUsedSconto = explode(",", $isUsedSconto);
        $valoreSconto = explode(",", $valoreSconto);
    } else {
        $stringaPC = "<p>Errore</p>";
    }
} else {

    header("HTTP/1.0 404 Not Found");
    include("../pages/404.html");
    exit;
}
$connection->closeDBConnection();


foreach ($codiceSconto as $i => $nome) {
    if ($nome != null) {
        $prova = "<li>\n" .  "<input type=\"checkbox\" class=\"sail\"id=\"" . $nome . "\">\n" . "<label for=\"" . $nome . "\">" . $nome . " " . $emissioneSconto[$i] . " " . $scadenzaSconto[$i] . " " . $usernameSconto[$i] . " " . ($isUsedSconto[$i] == 0 ? "Buono non usato" : "Buono usato") . " " . $valoreSconto[$i] . "</label>\n</li>\n";
        $sconti .= $prova;
    }
}

/* PARTE ORDINI */
$id = "";
$utente = "";
$quantitaOrdinata = "";
$indirizzo = "";
$prezzoTotale = "";

$connectionOk = $connection->openDBConnection();
if ($connectionOk) {
    $listaPC = $connection->getOrdini();
    $length = count($listaPC);
    if ($listaPC != null) {
        foreach ($listaPC as $pc) {
            $id .=  $pc['id'] . ",";
            $utente .= $pc['utente'] . ",";
            $quantitaOrdinata .= $pc['quantitaOrdinata'] . ",";
            $indirizzo .= $pc['indirizzo'] . ",";
            $prezzoTotale .= $pc['prezzo'] . ",";
        }
        $id = explode(",", $id);
        $utente = explode(",", $utente);
        $quantitaOrdinata = explode(",", $quantitaOrdinata);
        $indirizzo = explode(",", $indirizzo);
        $prezzoTotale = explode(",", $prezzoTotale);
    } else {
        $stringaPC = "<p>Errore</p>";
    }
} else {

    header("HTTP/1.0 404 Not Found");
    include("../pages/404.html");
    exit;
}
$connection->closeDBConnection();

foreach ($id as $i => $nome) {
    if ($nome != null) {
        $prova = "<li>\n<dl>\n<dd>\n" .  "<input type=\"checkbox\" class=\"order\"id=\"" . $nome . "\">\n" . "<label for=\"" . $nome . "\">" . $nome . " " . $utente[$i] . " " . $quantitaOrdinata[$i] . " " . $indirizzo[$i] . " " . $prezzoTotale[$i] . "</label>\n</dd>\n</dl>\n</li>\n";
        $ordini .= $prova;
    }
}
/* FINE PARTE ORDINI */

$prodottiTotali .= "<strong>PRODOTTI</strong><br>" . $prodottiPcKbd .   $prodottiAcc .
    "<input type=\"button\" name=\"insertProduct\" id=\"insertProduct\" value=\"Inserisci nuovo\">" .
    "<input type=\"button\" name=\"removeProduct\" id=\"removeProduct\" value=\"Rimuovi\">" .
    "<input type=\"button\" name=\"modifyProduct\" id=\"modifyProduct\" value=\"Modifica\">" .
    "<input type=\"button\" name=\"selectAllProduct\" id=\"selectAllProduct\" value=\"Seleziona tutti\">" .
    "<input type=\"button\" name=\"deselectAllProduct\" id=\"deselectAllProduct\" value=\"Deseleziona tutti\"><br>" .
    "<strong>SCONTI</strong><br>" . $sconti .
    "<input type=\"button\" name=\"insertSconto\" id=\"insertSconto\" value=\"Aggiungi sconto\">" .
    "<input type=\"button\" name=\"removeSconto\" id=\"removeSconto\" value=\"Rimuovi sconto\">" .
    "<input type=\"button\" name=\"modifySconto\" id=\"modifySconto\" value=\"Modifica sconto\">" .
    "<input type=\"button\" name=\"selectAllSail\" id=\"selectAllSail\" value=\"Seleziona tutti\">" .
    "<input type=\"button\" name=\"deselectAllSail\" id=\"deselectAllSail\" value=\"Deseleziona tutti\"><br>" .
    "<strong>ORDINI</strong><br>" . $ordini .
    "<input type=\"button\" name=\"insertOrder\" id=\"insertOrder\" value=\"Aggiungi Ordine\">" .
    "<input type=\"button\" name=\"removeOrder\" id=\"removeOrder\" value=\"Rimuovi Ordine\">" .
    "<input type=\"button\" name=\"modifyOrder\" id=\"modifyOrder\" value=\"Modifica Ordine\">" .
    "<input type=\"button\" name=\"selectAllOrder\" id=\"selectAllOrder\" value=\"Seleziona tutti\">" .
    "<input type=\"button\" name=\"deselectAllOrder\" id=\"deselectAllOrder\" value=\"Deseleziona tutti\"><br>";

$paginaHTML = str_replace('{prodotti}', $prodottiTotali, $paginaHTML);
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


echo ($paginaHTML);
