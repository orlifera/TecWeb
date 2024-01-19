<?php

session_start();
$paginaHTML = file_get_contents(__DIR__ . "/../pages/login.html");

if (isset($_SESSION['user']) && $_SESSION['user'] !== '') {
    header('Location: ../php/profile.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submit']) && isset($_POST['user']) && isset($_POST['password'])) {
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
                $_SESSION["user"] = $user_data["username"];
                if(isset($_SESSION['user'])) {
                    header('Location: ../php/profile.php');
                } else {
                    echo '<p>Non va la sessione</p>';
                }
                exit();
            } else {
                // echo "<div id=\"error\">username o password errati</div>";
                $errormsg="<div class=\"error\">Email o Password non coincidono</div>";
                $paginaHTML = str_replace('{errore}', $errormsg, $paginaHTML);
                echo($paginaHTML);
                // $_SESSION['error'] = $errormsg;
                // echo "<script>document.getElementById('error').innerHTML='$errormsg'</script>";
                // header('Location: ../pages/login.html');
                // $error = "Password errata";
            }
        } else {
            // echo "<div id=\"error\">username o password errati</div>";
            
            
            
            // $errormsg="<div class=\"error>\"Email o Password non coincidono</div>";
            $errormsg="<div class=\"error\">Email o Password non coincidono</div>";
            $paginaHTML = str_replace('<div id="error"></div>', $errormsg, $paginaHTML);
            echo($paginaHTML);
            
            
            
            // $_SESSION['error'] = $errormsg;
            // echo "<script>document.getElementById('error').innerHTML='$errormsg'</script>";
            // header('Location: ../pages/login.html');
            // $error = "Password errata";
            // if ($errormsg) {
            //     $error_html = str_replace("{errore}", $errormsg, '<div id="error">{errore}</div>');
            //     echo $error_html;
            // }
        }
        $connessione->close();
    }
}