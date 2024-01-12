<?php

if (isset($_SESSION['user']) && $_SESSION['user'] !== '') {
    header('Location: ../../pages/profile.html');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submit'])) {
        require_once("connessionedb.php");

        $username = htmlentities(substr($_POST['user'], 0, 255));
        $password = substr($_POST['password'], 0, 255);

        $stmt = $connessione->prepare("SELECT * FROM utente WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user_data = $result->fetch_assoc();
            if (password_verify($password, $user_data["password"])) {
                session_start();
                // session_regenerate_id();
                $_SESSION["user"] = $user_data["user"];
                // print_r($_SESSION);
                // var_dump($_SESSION);
                // $_SESSION["password"] = $user_data["password"];
                if(isset($_SESSION['user'])) {

                    header('Location: ../pages/profile.html');
                } else {
                    echo '<p>Non va la sessione di merda</p>';
                    // phpinfo();
                }
                exit();
            } else {
                $error = "Password errata";
            }
        } else {
            $error = "Nome utente non trovato";
        }
        $connessione->close();
    }
}

// UTILIZZO QUESTO PER VEDERE L'ID DELLA SESSIONE SALVATO NEL COOKIE
// document.cookie
// document.cookie.split(';')
