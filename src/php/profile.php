<?php

require_once "DBAccess.php";
// require_once "sendToLogin.php";

use DB\DBAccess;

session_start();
$user = $_SESSION['user'];

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
setlocale(LC_ALL, 'it_IT');

$paginaHTML = file_get_contents(__DIR__ . "/../pages/profile.html");

$username = "";
$fname = "";
$lname = "";
$email = "";
$phone = "";
$dob = "";
$city = "";
$address = "";
$cap = "";

$connection = new DBAccess();
$connectionOk = $connection->openDBConnection();

if($connectionOk) {
    $username = "<h2 id=\"nav-title\">Ciao, " .$user. "!</h2>";
    $listaInfo = $connection->getProfileInfo($user);

    if($listaInfo != null) {
        $fname = "<input type=\"text\" name=\"fname\" id=\"fname\" value=\"". $listaInfo[0] ."\" required>";
        $lname = "<input type=\"text\" name=\"lname\" id=\"lname\" value=\"". $listaInfo[1] ."\" required>";
        $email = "<input type=\"email\" name=\"email\" id=\"email\" value=\"". $listaInfo[5] ."\" required>";
        $phone = "<input type=\"phone\" name=\"phone\" id=\"phone\" value=\"". $listaInfo[7] ."\" required>";
        $dob = "<input type=\"date\" name=\"dob\" id=\"dob\" value=\"". $listaInfo[2] ."\" required>";
        $city = "<input type=\"text\" name=\"city\" id=\"city\" value=\"". $listaInfo[8] ."\" required>";
        $address = "<input type=\"text\" name=\"address\" id=\"address\" value=\"". $listaInfo[9] ."\" required>";
        $cap = "<input type=\"text\" name=\"cap\" id=\"cap\" value=\"". $listaInfo[10] ."\" required>";
       
        
    }
}
/*
0. nome
1. cognome
2. data
3. genere
4. username
5. email
6. password
7. telefono
8. città
9. indirzzo
10 cap
*/

$paginaHTML = str_replace('{username}', $username, $paginaHTML);
$paginaHTML = str_replace('{nome}', $fname, $paginaHTML);
$paginaHTML = str_replace('{cognome}', $lname, $paginaHTML);
$paginaHTML = str_replace('{email}', $email, $paginaHTML);
$paginaHTML = str_replace('{phone}', $phone, $paginaHTML);
$paginaHTML = str_replace('{dob}', $dob, $paginaHTML);
$paginaHTML = str_replace('{city}', $city, $paginaHTML);
$paginaHTML = str_replace('{address}', $address, $paginaHTML);
$paginaHTML = str_replace('{cap}', $cap, $paginaHTML);


echo($paginaHTML);

?>