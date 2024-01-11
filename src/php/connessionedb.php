<?php 
    $servername = "localhost";
    $db_username = "root";
    $db_password = "";
    $db_name = "tecweb";

    $connessione = new mysqli($servername, $db_username, $db_password, $db_name);

    if ($connessione->connect_error) {
        echo "Connessione fallita (". $connessione->connect_errno. "): ". $connessione->connect_error;
        exit();
    }
?>