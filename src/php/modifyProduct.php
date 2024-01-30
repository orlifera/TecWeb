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
                    $prova = "<h2 class=\"headings\">{$stringa}</h2>" .
                        "<div class=\"info-container\">" .
                        "<div class=\"text-fields\">
                            <label for=\"nome\">Nome</label>
                            <input type=\"text\" id=\"nome\" placeholder=\"{$stringa}\">
                        </div>\n" .
                        "<div class=\"text-fields\">
                            <label for=\"tipo\">Tipo</label>
                            <input type=\"text\" id=\"tipo\" placeholder=\"{$tipoPC[$i]}\">
                        </div>\n" .
                        "</div>" .
                        "<div class=\"info-container\" >" .
                        "<div class=\"text-fields\">
                                <label for=\"path_image\">Immagine (path)</label><input type=\"text\" id=\"path_image\" placeholder=\"{$path_image[$i]}\">
                            </div>\n" .
                        "<div class=\"text-fields\">
                            <label for=\"prezzo\">Prezzo</label>
                            <input type=\"text\" id=\"prezzo\" placeholder=\"{$prezzoPc[$i]}\">
                            </div>\n" .
                        "</div>" .
                        "<div class=\"info-container\" >" .
                        "<div class=\"text-fields\">
                        <label for=\"colore\">Colore</label>
                        <input type=\"text\" id=\"colore\" placeholder=\"{$colorePc[$i]}\">
                        </div>\n" .
                        "<div class=\"text-fields\">
                        <label for=\"disponibilità\">Disponibilità</label>
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
                $prova = "<label>{$data['codice']}</label><br>" .
                    "<input type=\"text\" id=\"data_emissione\" placeholder=\"{$data['data_emissione']}\">\n" .
                    "<input type=\"text\" id=\"data_scadenza\" placeholder=\"{$data['data_scadenza']}\">\n" .
                    "<input type=\"text\" id=\"username\" placeholder=\"{$data['username']}\">\n<br>" .
                    "<input type=\"text\" id=\"isUsed\" placeholder=\"" . ($data['isUsed'] == 0 ? "Buono non usato" : "Buono usato") . "\">\n" .
                    "<input type=\"text\" id=\"valore\" placeholder=\"{$data['valore']}\">\n<br><br>";
                $htmlProdotti .= $prova;
            }
        }
        $paginaHTML = str_replace('<script src="../js/modify.js">', '<script src="../js/modify.js" data-categoria="sale" data-id="' . $codice . '" >', $paginaHTML);
    } else {
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
                        'utente' => $listaordini[1],
                        'quantitaOrdinata' => $listaordini[2],
                        'indirizzo' => $listaordini[3],
                        'prezzo' => $listaordini[4],
                    ];
                } else {
                    $result[$code] = ['id' => "<p>Errore</p>"];
                }
            } catch (Exception $e) {
                echo 'Errore durante l\'ottenimento degli sconti.';
            }
        }

        foreach ($result as $code => $data) {
            if (isset($data['id'])) {
                $prova = "<label>{$data['id']}</label><br>" .
                    "<input type=\"text\" id=\"utente\" placeholder=\"{$data['utente']}\">\n" .
                    "<input type=\"text\" id=\"quantitaOrdinata\" placeholder=\"{$data['quantitaOrdinata']}\">\n" .
                    "<input type=\"text\" id=\"indirizzo\" placeholder=\"{$data['indirizzo']}\">\n" .
                    "<input type=\"text\" id=\"prezzo\" placeholder=\"{$data['prezzo']}\">\n<br><br>";
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
