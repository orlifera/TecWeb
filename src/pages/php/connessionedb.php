<?php 
    $servername = "localhost";
    $db_username = "postgres";
    $db_password = "Qwe1234"; // mettete la vostra password che altrimenti non va
    $db_name = "techweb";

    $connessione = new mysqli($servername, $db_username, $db_password, $db_name);

    if ($connessione->connect_error) {
        die("connessione fallita");
    }
?>