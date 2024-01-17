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

$connection = new DBAccess();
$connectionOk = $connection->openDBConnection();

if($connectionOk) {
        $username = "<h2 id=\"nav-title\">Ciao, " .$user. "!</h2>";
  
    //$username = "<h2 id=\"nav-title\">Ciao, " .$_SESSION['user']. "!</h2>";

}

$paginaHTML = str_replace('{username}', $username, $paginaHTML);

echo($paginaHTML);

?>