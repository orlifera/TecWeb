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

$variabile_dec = "ordini";


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
if ($variabile_dec == "prodotti") {
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
    $prodottiTotali .= "<strong>PRODOTTI</strong><br>" . $prodottiPcKbd .   $prodottiAcc .
        "<input type=\"button\" name=\"insertProduct\" id=\"insertItem\" value=\"Inserisci nuovo\">" .
        "<input type=\"button\" name=\"removeProduct\" id=\"removeItem\" value=\"Rimuovi\">" .
        "<input type=\"button\" name=\"modifyProduct\" id=\"modifyItem\" value=\"Modifica\">" .
        "<input type=\"button\" name=\"selectAllProduct\" id=\"selectAllItem\" value=\"Seleziona tutti\">" .
        "<input type=\"button\" name=\"deselectAllProduct\" id=\"deselectAllItem\" value=\"Deseleziona tutti\"><br>";
} else if ($variabile_dec == "sconti") {
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
    foreach ($codiceSconto as $i => $nome) {
        if ($nome != null) {
            $prova = "<li>\n" .  "<input type=\"checkbox\" class=\"sail\"id=\"" . $nome . "\">\n" . "<label for=\"" . $nome . "\">" . $nome . " " . $emissioneSconto[$i] . " " . $scadenzaSconto[$i] . " " . $usernameSconto[$i] . " " . ($isUsedSconto[$i] == 0 ? "Buono non usato" : "Buono usato") . " " . $valoreSconto[$i] . "</label>\n</li>\n";
            $sconti .= $prova;
        }
    }
    $prodottiTotali .= "<strong>SCONTI</strong><br>" . $prodottiPcKbd .   $sconti .
        "<input type=\"button\" name=\"insertSconto\" id=\"insertItem\" value=\"Aggiungi sconto\">" .
        "<input type=\"button\" name=\"removeSconto\"  id=\"removeItem\" value=\"Rimuovi sconto\">" .
        "<input type=\"button\" name=\"modifySconto\" id=\"modifyItem\" value=\"Modifica sconto\">" .
        "<input type=\"button\" name=\"selectAllSail\" id=\"selectAllItem\" value=\"Seleziona tutti\">" .
        "<input type=\"button\" name=\"deselectAllSail\" id=\"deselectAllItem\" value=\"Deseleziona tutti\"><br>";
} else if ($variabile_dec == "ordini") {

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

    foreach ($id as $i => $nome) {
        if ($nome != null) {
            $prova = "<li>\n<dl>\n<dd>\n" .  "<input type=\"checkbox\" class=\"order\"id=\"" . $nome . "\">\n" . "<label for=\"" . $nome . "\">" . $nome . " " . $utente[$i] . " " . $quantitaOrdinata[$i] . " " . $indirizzo[$i] . " " . $prezzoTotale[$i] . "</label>\n</dd>\n</dl>\n</li>\n";
            $ordini .= $prova;
        }
    }
    $prodottiTotali .= "<strong>ORDINI</strong><br>" . $prodottiPcKbd .   $ordini .
        "<input type=\"button\" name=\"insertOrder\" id=\"insertItem\" value=\"Aggiungi Ordine\">" .
        "<input type=\"button\" name=\"removeOrder\" id=\"removeItem\" value=\"Rimuovi Ordine\">" .
        "<input type=\"button\" name=\"modifyOrder\" id=\"modifyItem\" value=\"Modifica Ordine\">" .
        "<input type=\"button\" name=\"selectAllOrder\" id=\"selectAllItem\" value=\"Seleziona tutti\">" .
        "<input type=\"button\" name=\"deselectAllOrder\" id=\"deselectAllItem\" value=\"Deseleziona tutti\"><br>";
}

$connection->closeDBConnection();

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
$paginaHTML = str_replace('<script src="../JS/admin.js"></script>', '<script src="../JS/admin.js" data-categoria="' . $variabile_dec . '"></script>', $paginaHTML);


echo ($paginaHTML);
