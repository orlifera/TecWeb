<?php

function login() {

    if (isset($_POST['submit'])) {
        require_once("connessionedb.php");

        $username = htmlentities(substr($_POST["username"],0,255));
        $password = substr($_POST["password"],0,255);

        $stmt = $connessione->prepare("SELECT * FROM utente WHERE username = ?");
        $stmt->bind_param("s", $username);
        $result = $stmt->execute();

        if($result === TRUE) {
            $result = $stmt->get_result()->fetch_assoc();

            if($result >= 1) {
                if(password_verify($password, $result["password"])) {
                    $_SESSION["username"] = $result["username"];
                    $_SESSION["password"] = $result["password"];
                    header('Location: ../../index.html');
                }
            } else {
                echo '<p class="error">password errati</p>'; //Nome utente o 
            }
        } else {
            echo '<p class ="error">Nome utente errato</p>'; //o password errati
        }
    }
}

// Inizia una sessione
session_start();

if(isset($_SESSION['username'])) {
    header('Location: ../../index.html');
    die();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    login();
}

// Chiudi la connessione solo dopo che tutte le operazioni sono state eseguite
$connessione->close();
    
?>
