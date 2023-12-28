<?php
require_once "DBAccess.php";

use DB\DBAccess;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
setlocale(LC_ALL, 'it_IT');

$paginaHTML = file_get_contents(__DIR__ . "/../pages/accInfo.html");

$stringaPC = "";
$listaPC = "";
$prezzoPc = "";
$colorePc = "";
$disponibilita = "";
$path_image = "";
$tipoPC = "";
$descrizione = "";
$sku = $_GET['id'];

$colori = "";


// function pulisciInput($value){
//     //elimina gli spazi
//     $value = trim($value);
//     //rimuove tag html, a volte è rischioso perchè rischi di perdere tutta la pagina. 
//     $value = strip_tags($value);// di può mettere , + tutta la lista dei tag consentiti
//     //converte i caratteri speciali in entità html
//     $value = htmlentities($value);
//     return $value;
// }

$connection = new DBAccess();
$connectionOk = $connection->openDBConnection();

if ($connectionOk) {
    $listaPC = $connection->getPc($sku);
    if ($listaPC != null) {
        //caso in cui l'album esiste
        $stringaPC = "<dt> Nome: " . $listaPC[1] . "</dt>";
        $tipoPC = "<dt> Tipo: " . $listaPC[2] . "</dt>";
        $descrizione = "<dt>" . $listaPC[3] . "</dt>";
        $prezzoPc = "<dt> Prezzo: €" . $listaPC[4] . "</dt>";

        if ($listaPC[5] != null) {
            $colorePc = explode(",", $listaPC[5]);

            $colori = "<select>";

            while (!empty($colorePc)) {
                $color = array_shift($colorePc);
                $colori = $colori . "<option>" . $color . "</option>";
            }

            $colori = $colori . "</select>";
        } else {
            $colori = "<label for='name'>Colore:</label>
                          <select>
                            <option>Valore predefinito o vuoto</option>
                          </select>";

            echo ($colori);
        }

        $disponibilita = "<dt> Disponibilità: " . $listaPC[6] . "</dt>";
        $path_image =  $listaPC[7];
    } else {
        $stringaPC = "<p>Errore</p>";
    }
} else {

    $stringaPC = "<p>I sistemi sono momentaneamente fuori servizio, ci scusiamo per il disagio</p>";
}
$connection->closeDBConnection();


$paginaHTML = str_replace('{nomeAcc}', $stringaPC, $paginaHTML);
$paginaHTML = str_replace('{tipo}', $tipoPC, $paginaHTML);
$paginaHTML = str_replace('{prezzo}', $prezzoPc, $paginaHTML);
$paginaHTML = str_replace('{Bianco}', $colori, $paginaHTML);
$paginaHTML = str_replace('{Disponibilità}', $disponibilita, $paginaHTML);
$paginaHTML = str_replace('{descrizione}', $descrizione, $paginaHTML);
$paginaHTML = str_replace('download1.jpg', $path_image, $paginaHTML);
$paginaHTML = str_replace('src/php/getProduct.php', 'getProduct.php', $paginaHTML);

echo ($paginaHTML);
