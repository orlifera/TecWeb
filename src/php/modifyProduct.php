<?php
require_once "DBAccess.php";


use DB\DBAccess;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
setlocale(LC_ALL, 'it_IT');
$paginaHTML = file_get_contents(__DIR__ . "/../pages/modifyProduct.html");

$result = array();
$connection = new DBAccess();
$connectionOk = "";
$connectionOk = $connection->openDBConnection();
$htmlProdotti = "";

$category = $_GET['category'];
if ($connectionOk) {
    if ($category == "product") {
        $id = $_GET['id'];
        $ids = explode(",", $id);
        $result = [];
        $stringaPC = [];

        foreach ($ids as $id) {
            $listaPC = $connection->getProductAdmin($id);

            if ($listaPC !== null) {
                $result[$id] = [
                    'stringaPC' => $listaPC[1],
                    'tipoPC' => $listaPC[2],
                    'descrizione' => $listaPC[3],
                    'prezzoPc' => $listaPC[4],
                    'colorePc' => $listaPC[5],
                    'disponibilita' => $listaPC[7],
                    'path_image' => $listaPC[8],
                    'categoria' => $listaPC[6],
                    'riferimento' => $listaPC[9],
                ];
            } else {
                $result[$id] = ['stringaPC' => "<p>Errore</p>"];
            }
        }

        if (is_array($ids) && count($ids) > 0) {
            $fields = ['stringaPC', 'tipoPC', 'descrizione', 'prezzoPc', 'colorePc', 'disponibilita', 'path_image', 'categoria', 'riferimento'];

            foreach ($fields as $field) {
                ${$field} = implode(",", array_column($result, $field));
                ${$field} = rtrim(${$field}, ',');
            }

            foreach ($fields as $field) {
                ${$field} = explode(",", ${$field});
            }

            foreach ($stringaPC as $i => $stringa) {
                if ($stringa !== null) {
                    $prova = "<h2 class=\"headings admin\">{$stringa}</h2>" .
                        "<div class=\"info-container\">" .
                        "<div class=\"text-fields prod-name\">
                            <label for=\"nome\">Nome</label>
                            <input type=\"text\" id=\"nome\" placeholder=\"{$stringa}\">
                        </div>\n" .
                        "<div class=\"text-fields prod-type\">
                            <label for=\"tipo\">Tipo</label>
                            <input type=\"text\" id=\"tipo\" placeholder=\"{$tipoPC[$i]}\">
                        </div>\n" .
                        "</div>" .
                        "<div class=\"info-container\" >" .
                        "<div class=\"text-fields prod-description\">
                                <label for=\"path_image\">Percorso Immagine</label>
                                <textarea  rowz=\"100\" cols=\"80\" id=\"path_image\" name=\"path_image\" placeholder=\"{$path_image[$i]}\"></textarea>
                            </div>\n" .
                        "<div class=\"text-fields prod-price\">
                            <label for=\"prezzo\">Prezzo</label>
                            <input type=\"text\" id=\"prezzo\" placeholder=\"{$prezzoPc[$i]}\">
                            </div>\n" .
                        "</div>" .
                        "<div class=\"info-container\" >" .
                        "<div class=\"text-fields prod-color\">
                        <label for=\"colore\">Colore</label>
                        <input type=\"text\" id=\"colore\" placeholder=\"{$colorePc[$i]}\">
                        </div>\n" .
                        "<div class=\"text-fields prod-availability\">
                        <label for=\"disponibilita\">Disponibilità</label>
                        <input type=\"text\" id=\"disponibilita\" placeholder=\"{$disponibilita[$i]}\">
                        </div>\n" .
                        "</div>" .
                        "<div class=\"info-container\" >" .

                        "<div class=\"text-fields prod-category\"><label for=\"categoria\">Categoria</label><input type=\"text\" id=\"categoria\" placeholder=\"{$categoria[$i]}\"></div>\n" . "</div>" .
                        "<div class=\"text-fields prod-description\"><label for=\"descrizione\">Descrizione</label>
                                <textarea id=\"descrizione\" rows=\"10\" cols=\"100\"  placeholder=\"{$descrizione[$i]}\"></textarea></div>\n";

                    $htmlProdotti .= $prova;
                }
            }

            $paginaHTML = str_replace('<script src="../js/modify.js">', '<script src="../js/modify.js" data-id="' . $id . '" data-categoria="product" data-riferimento="' . $riferimento[0] . '" >', $paginaHTML);
        } else {
            echo ("Errore: l'ID non è un array. Risolvi questo problema su modifyProduct.php, riga 76 circa");
        }
    } else if ($category == "sale") {
        //se è uno sconto sono qui

        $codice = $_GET['id'];
        $ids = explode(",", $codice);
        $result = [];
        $htmlProdotti = '';

        foreach ($ids as $code) {
            try {
                $listaSconti = $connection->getScontiAdmin($code);

                if ($listaSconti !== null) {
                    $result[$code] = [
                        'codice' => $listaSconti[0],
                        'data_emissione' => $listaSconti[1],
                        'data_scadenza' => $listaSconti[2],
                        'username' => $listaSconti[3],
                        'isUsed' => $listaSconti[4],
                        'valore' => $listaSconti[5],
                    ];
                } else {
                    $result[$code] = ['codice' => "<p>Errore</p>"];
                }
            } catch (Exception $e) {
                echo 'Errore durante l\'ottenimento degli sconti.';
            }
        }

        foreach ($result as $code => $data) {
            if (isset($data['codice'])) {
                $prova = "<h2 class=\"headings admin\">{$data['codice']}</h2>" . "<div class=\"info-container\" >" .
                    "<div class=\"text-fields\">
                                <label for=\"data_emissione\">Data Inizio</label><input type=\"text\" id=\"data_emissione\" placeholder=\"{$data['data_emissione']}\"></div>\n" .
                    "<div class=\"text-fields\">
                                <label for=\"data_scadenza\">Data Scadenza</label><input type=\"text\" id=\"data_scadenza\" placeholder=\"{$data['data_scadenza']}\"></div>\n" . "</div>" . "<div class=\"info-container\" >" .
                    "<div class=\"text-fields\">
                                <label for=\"username\">Username</label><input type=\"text\" id=\"username\" placeholder=\"{$data['username']}\"></div>\n" .
                    "<div class=\"text-fields\">
                                <label for=\"isUsed\">Utilizzo</label><input type=\"text\" id=\"isUsed\" placeholder=\"" . ($data['isUsed'] == 0 ? "Buono non usato" : "Buono usato") . "\"></div></div>\n" .
                    "<div class=\"text-fields\">
                                <label for=\"valore\">Valore</label><input type=\"text\" id=\"valore\" placeholder=\"{$data['valore']}\"></div>\n";
                $htmlProdotti .= $prova;
            }
        }
        $paginaHTML = str_replace('<script src="../js/modify.js">', '<script src="../js/modify.js" data-categoria="sale" data-id="' . $codice . '" >', $paginaHTML);
    } else if ($category == "order") {
        //SE È UN ORDINE SONO QUI
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

        foreach ($result as $code => $data) {
            if (isset($data['id'])) {
                $prova = "<h2 class=\"headings admin\">Ordine {$data['id']}</h2>" .
                    "<div class=\"info-container\">" .
                    "<div class=\"text-fields\">
                    <label for=\"nome\">Nome</label><input type=\"text\" id=\"nome\" placeholder=\"{$data['nome']}\"></div>\n" .
                    "<div class=\"text-fields\">
                    <label for=\"cognome\">Cognome</label><input type=\"text\" id=\"cognome\" placeholder=\"{$data['cognome']}\">
                 </div>" . "</div>" . "<div class=\"info-container\">" .
                    "<div class=\"text-fields\">
                    <label for=\"email\">Email</label><input type=\"text\" id=\"email\" placeholder=\"{$data['email']}\">
                 </div>" .
                    "<div class=\"text-fields\">
                    <label for=\"numero\">Numero</label><input type=\"text\" id=\"numero\" placeholder=\"{$data['numero']}\"></div></div>" . "<div class=\"info-container\" >" .
                    "<div class=\"text-fields\">
                    <label for=\"indirizzo\">Indirizzo</label><input type=\"text\" id=\"indirizzo\" placeholder=\"{$data['indirizzo']}\"></div>" .
                    "<div class=\"text-fields\">
                    <label for=\"citta\">Città</label><input type=\"text\" id=\"citta\" placeholder=\"{$data['citta']}\">
                 </div></div>" . "<div class=\"info-container\" >" .
                    "<div class=\"text-fields\">
                                <label for=\"quantitaOrdinata\">Quantita</label><input type=\"text\" id=\"quantitaOrdinata\" placeholder=\"{$data['quantitaOrdinata']}\"></div>\n" . "</div>" . "<div class=\"info-container\" >" .
                    "<div class=\"text-fields\">
                                <label for=\"prezzo\">Prezzo</label><input type=\"text\" id=\"prezzo\" placeholder=\"{$data['prezzo']}\"></div>\n" . "</div>";
                $htmlProdotti .= $prova;
            }
        }

        $paginaHTML = str_replace('<script src="../js/modify.js">', '<script src="../js/modify.js" data-categoria="order" data-id="' . $codice . '" >', $paginaHTML);
    }
} else {
    header("HTTP/1.0 404 Not Found");
    include("../pages/404.html");
    exit;
}

$connection->closeDBConnection();

$paginaHTML = str_replace('{nome}', $htmlProdotti, $paginaHTML);

$paginaHTML = str_replace('cart.html', 'cart.php', $paginaHTML);
$paginaHTML = str_replace('src/php/getCatalog.php?categoria=kbd&riferimento=', 'getCatalog.php?categoria=kbd&riferimento=', $paginaHTML);
$paginaHTML = str_replace('src/php/getCatalog.php?categoria=pc&riferimento=', 'getCatalog.php?categoria=pc&riferimento=', $paginaHTML);
$paginaHTML = str_replace('catalog.html?categoria=kbd', 'getCatalog.php?categoria=kbd&riferimento=', $paginaHTML);
$paginaHTML = str_replace('catalog.html?categoria=pc', 'getCatalog.php?categoria=pc&riferimento=', $paginaHTML);

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
