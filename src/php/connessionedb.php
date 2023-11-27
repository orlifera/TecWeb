<?php 
    $servername = "localhost";
    $db_username = "root";
    $db_password = "";
    $db_name = "techweb";

    $connessione = new mysqli($servername, $db_username, $db_password, $db_name);

    if ($connessione->connect_error) {
        die("connessione fallita");
    }
?>