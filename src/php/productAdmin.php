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
$scontiTotali = "";
$ordiniTotali = "";

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

//$nome contiene il valore corrente mentre $i contiene l'indice corrente, $nomePc è l'array dove itero
foreach ($nomePc as $i => $nome) {
    if ($nome != null) {
        $prova = "<li class=\"product-item\">\n" .
            "<a class=\"\" href=\"getProduct.php?categoria=" . $categoria[$i] . "&id=" . $sku[$i] . "\">" .

            "<label for=\"" . $sku[$i] . "\">" . $nome . "</label>\n" .
            "</a>\n" .
            "<div class=\"dropdown-options\">
                        <button class=\"dropbtn\">&#8942;</button>
                        <div class=\"dropdown-content hidden\">
                            <input type=\"button\" name=\"removeProduct\" value=\"Rimuovi\" class=\"removeItem\" data-id=\"" . $sku[$i] . "\" data-categoria=\"prodotti\">
                            <input type=\"button\" name=\"modifyProduct\" value=\"Modifica\" class=\"modifyItem\" data-id=\"" . $sku[$i] . "\" data-categoria=\"prodotti\">
                        </div>
                    </div>" .
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
        $prova = "<li class=\"product-item\">\n" .
            "<a class=\"\" href=\"getProduct.php?categoria=" . $categoria[$i] . "&id=" . $sku[$i] . "\">" .
            "<label for=\"" . $sku[$i] . "\">" . $nome . "</label>\n" .
            "</a>\n" .
            "<div class=\"dropdown-options\">
                    <button class=\"dropbtn\">&#8942;</button>
                    <div class=\"dropdown-content hidden\">
                    <input type=\"button\" name=\"removeProduct\" value=\"Rimuovi\" class=\"removeItem\" data-id=\"" . $sku[$i] . "\"
                    data-categoria=\"prodotti\">
                    <input type=\"button\" name=\"modifyProduct\" value=\"Modifica\" class=\"modifyItem\" data-id=\"" . $sku[$i] . "\" data-categoria=\"prodotti\">
                    </div>
                </div>" .
            "</li>\n";
        $prodottiAcc .= $prova;
    }
}
$prodottiTotali .=  $prodottiPcKbd .   $prodottiAcc .
    "<input type=\"button\" name=\"insertProduct\" class=\"insertItem\" value=\"Inserisci nuovo\" data-categoria=\"prodotti\">";

/* sconti */
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
        $prova = "<li>\n<ul>\n" .
            "<li>" . $nome . "</li>\n" .
            "<li>" . $emissioneSconto[$i] . "</li>\n" .
            "<li>" . $scadenzaSconto[$i] . "</li>\n" .
            "<li>" . $usernameSconto[$i] . "</li>\n" .
            "<li>" . ($isUsedSconto[$i] == 0 ? "Buono non usato" : "Buono usato") . "</li>\n</ul>\n" .

            "<div class=\"dropdown-options\">
                    <button class=\"dropbtn\">⋮</button>
                    <div class=\"dropdown-content hidden\">
                    <input type=\"button\" name=\"removeProduct\" value=\"Rimuovi\" class=\"removeItem\" data-id=\"" . $nome . "\" data-categoria=\"sconti\">
                    <input type=\"button\" name=\"modifyProduct\" value=\"Modifica\" class=\"modifyItem\" data-id=\"" . $nome . "\" data-categoria=\"sconti\">
                    </div>
                </div> " . "
            </li>\n";
        $sconti .= $prova;
    }
}
$scontiTotali .=    $sconti .
    "<input type=\"button\" name=\"insertSconto\" class=\"insertItem\" value=\"Aggiungi sconto\" data-categoria=\"sconti\">";

/* ordini */
$id = "";
$nomeUtente = "";
$cognomeUtente = "";
$emailUtente = "";
$phoneUtente = "";
$indirizzoUtente = "";
$cittaUtente = "";
$capUtente = "";
$quantitaOrdinata = "";
$prezzoTotale = "";

$connectionOk = $connection->openDBConnection();
if ($connectionOk) {
    $listaPC = $connection->getOrdini();
    $length = count($listaPC);
    if ($listaPC != null) {
        foreach ($listaPC as $pc) {
            $id .=  $pc['id'] . ",";
            $nomeUtente .= $pc['nome'] . ",";
            $cognomeUtente .= $pc['cognome'] . ",";
            $emailUtente .= $pc['email'] . ",";
            $phoneUtente .= $pc['numero'] . ",";
            $indirizzoUtente .= $pc['indirizzo'] . ",";
            $cittaUtente .= $pc['citta'] . ",";
            $capUtente .= $pc['cap'] . ",";
            $quantitaOrdinata .= $pc['quantitaOrdinata'] . ",";
            $prezzoTotale .= $pc['prezzo'] . ",";
        }
        $id = explode(",", $id);
        $nomeUtente = explode(",", $nomeUtente);
        $cognomeUtente = explode(",", $cognomeUtente);
        $emailUtente = explode(",", $emailUtente);
        $phoneUtente = explode(",", $phoneUtente);
        $indirizzo = explode(",", $indirizzoUtente);
        $cittaUtente = explode(",", $cittaUtente);
        $capUtente = explode(",", $capUtente);
        $quantitaOrdinata = explode(",", $quantitaOrdinata);
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
        $prova = "<li>\n <ul>" .
            "<li> " . $nome . " </li>\n" .
            "<li> " . $nomeUtente[$i] . "</li>\n" .
            "<li>" . $cognomeUtente[$i] . "</li>\n" .
            "<li>" . $emailUtente[$i] . "</li>\n" .
            "<li>" . $phoneUtente[$i] . "</li>\n" .
            "<li>" . $indirizzo[$i] . "</li>\n" .
            "<li>" . $cittaUtente[$i] . "</li>\n" .
            "<li>" . $capUtente[$i] . "</li>\n" .
            "<li>" . $quantitaOrdinata[$i] . "</li>\n" .
            "<li>" . $prezzoTotale[$i] . "</li>\n</ul>\n" .

            "<div class=\"dropdown-options\">
                    <button class=\"dropbtn\">⋮</button>
                    <div class=\"dropdown-content hidden\">
                    <input type=\"button\" name=\"removeProduct\" value=\"Rimuovi\" class=\"removeItem\" data-id=\"" . $nome . "\"
                    data-categoria=\"ordini\">
                    <input type=\"button\" name=\"modifyProduct\" value=\"Modifica\" class=\"modifyItem\" data-id=\"" . $nome . "\"  data-categoria=\"ordini\">
                    </div>
                </div>" .
            "</li>\n";
        $ordini .= $prova;
    }
}
$ordiniTotali .= $ordini .


    $connection->closeDBConnection();

$paginaHTML = str_replace('{prodotti}', $prodottiTotali, $paginaHTML);
$paginaHTML = str_replace('{sconti}', $scontiTotali, $paginaHTML);
$paginaHTML = str_replace('{ordini}', $ordiniTotali, $paginaHTML);
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
