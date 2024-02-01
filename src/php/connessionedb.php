<?php 
    $servername = "localhost";
    $db_username = "root";
    $db_password = "";
    $db_name = "tecweb";

    $connessione = new mysqli($servername, $db_username, $db_password, $db_name);

    if ($connessione->connect_error) {
        // die("Connessione fallita: " . $connessione->connect_error);
        header("HTTP/1.0 404 Not Found");
        include("../pages/404.html");
        exit;
    }
?>