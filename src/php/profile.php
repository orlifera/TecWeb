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

    if(isset($_POST['personalInfo'])) {
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $listaInfo[5];
        $phone = $_POST['phone'];
        $connection->updatePersonalInfo($fname, $lname, $email, $phone);
        header('Location: profile.php');
    }

    if(isset($_POST['address'])) {
        $email = $listaInfo[5];
        $city = $_POST['city'];
        $address = $_POST['address'];
        $cap = $_POST['cap'];
        $connection->updateAddressInfo($email, $city, $address, $cap);
        header('Location: profile.php');
    }

    if(isset($_POST['changepsw'])) {
        $email = $listaInfo[5];
        $op = $_POST['pwd'];
        $np = $_POST['password'];
        $cnp = $_POST['password-confirm'];
        if(password_verify($op, $listaInfo[6]) && $np == $cnp) {
            $np = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $connection->updatePsw($email, $np);
        }
    }

    if($listaInfo != null) {
        $fname = "<input type=\"text\" name=\"fname\" id=\"fname\" value=\"". $listaInfo[0] ."\" required>";
        $lname = "<input type=\"text\" name=\"lname\" id=\"lname\" value=\"". $listaInfo[1] ."\" required>";
        $email = "<input type=\"email\" name=\"email\" id=\"email\" value=\"". $listaInfo[5] ."\" disabled>";
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