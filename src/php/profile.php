<?php

require_once "DBAccess.php";

use DB\DBAccess;

session_start();
$user = $_SESSION['user'];

if (isset($_SESSION['confirmation_message']) && $_SESSION['confirmation_message']) {
    echo '<p class="confirmDati banner">Aggiornamento dei dati avvenuto.</p><svg id="succ" class="cross-msg" width="30" height="30" viewBox="0 0 24 24" fill="none"> <path d="M19 5L4.99998 19M5.00001 5L19 19" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg>';
    // Resetta la variabile di sessione per evitare la visualizzazione ripetuta
    $_SESSION['confirmation_message'] = false;
}
if (isset($_SESSION['error_message']) && $_SESSION['error_message']) {
    echo '<p class="banner errorDati">Uno dei campi non è corretto</p><svg id="err" class="cross-msg" width="30" height="30" viewBox="0 0 24 24" fill="none"> <path d="M19 5L4.99998 19M5.00001 5L19 19" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg>';
    // Resetta la variabile di sessione per evitare la visualizzazione ripetuta
    $_SESSION['error_message'] = false;
}

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

if ($connectionOk) {
    $username = "<h2 id=\"nav-title\">Ciao, " . $user . "!</h2>";
    $listaInfo = $connection->getProfileInfo($user);

    if (isset($_POST['personalInfo'])) {
        if ($_POST['fname'] != null && $_POST['lname'] != null && $_POST['phone'] != null) {
            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $email = $listaInfo[5];
            $phone = $_POST['phone'];
            $connection->updatePersonalInfo($fname, $lname, $email, $phone);
            header('Location: profile.php?section=personalInfo');
        }
    } else if (isset($_POST['changepsw'])) {
        if ($_POST['pwd'] != null && $_POST['password'] != null && $_POST['password-confirm'] != null) {
            $email = $listaInfo[5];
            $op = $_POST['pwd'];
            $np = $_POST['password'];
            $cnp = $_POST['password-confirm'];
            if (password_verify($op, $listaInfo[6]) && $np == $cnp) {
                $np = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $connection->updatePsw($email, $np);
                header('Location: profile.php?section=changepsw');
            } else {
                $_SESSION['error_message'] = true;
                header('Location: profile.php?section=changepsw');
            }
        } else {
            echo '<p class="banner errorDati">Compila tutti i dati</p><svg id="err" class="cross-msg" width="30" height="30" viewBox="0 0 24 24" fill="none"> <path d="M19 5L4.99998 19M5.00001 5L19 19" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg>';

        }
    } else if (isset($_POST['addressbtn'])) {
        if ($_POST['city'] != null && $_POST['address'] != null && $_POST['cap'] != null) {
            $email = $listaInfo[5];
            $city = $_POST['city'];
            $address = $_POST['address'];
            $cap = $_POST['cap'];
            $connection->updateAddressInfo($email, $city, $address, $cap);
            header('Location: profile.php?section=change-address');
        }
    }

    if ($listaInfo != null) {
        $fname = "<input class=\"dataHolder\" type=\"text\" name=\"fname\" id=\"fname\" value=\"" . $listaInfo[0] . "\" required>";
        $lname = "<input class=\"dataHolder\" type=\"text\" name=\"lname\" id=\"lname\" value=\"" . $listaInfo[1] . "\" required>";
        $email = "<input class=\"dataHolder\" type=\"email\" name=\"email\" id=\"email\" value=\"" . $listaInfo[5] . "\" disabled>";
        $phone = "<input class=\"dataHolder\" type=\"tel\" inputmode=\"numeric\" name=\"phone\" id=\"phone\" value=\"" . $listaInfo[7] . "\" required>";
        $dob = "<input class=\"dataHolder\" type=\"date\" name=\"dob\" id=\"dob\" value=\"" . $listaInfo[2] . "\" required>";
        $city = "<input class=\"dataHolder\" type=\"text\" name=\"city\" id=\"city\" value=\"" . $listaInfo[8] . "\" required>";
        $address = "<input class=\"dataHolder\" type=\"text\" name=\"address\" id=\"address\" value=\"" . $listaInfo[9] . "\" required>";
        $cap = "<input class=\"dataHolder\" type=\"text\" name=\"cap\" id=\"cap\" value=\"" . $listaInfo[10] . "\" required>";

        if($listaInfo[11] == "A") {
            $admin = "<li class=\"\"><a href=\"productAdmin.php\" target=\"_blank\"><span lang=\"en\">Dashboard</span></a></li>";
            $paginaHTML = str_replace('<li class="adminListItem"></li>', $admin, $paginaHTML);
        }
    }
}
/*
0. nome
1. cognome
2. data
3. genere
4. username
5. email
7. telefono
8. città
9. indirzzo
10 cap
11. tipo
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


echo ($paginaHTML);
