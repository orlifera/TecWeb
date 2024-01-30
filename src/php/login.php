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
                if (isset($_SESSION['user'])) {
                    header('Location: ../php/profile.php');
                } else {
                    echo '<p>Non va la sessione</p>';
                }
                exit();
            } else {
                $errormsg = "<div class=\"errorDati\">Email o Password non coincidono</div>";
                $paginaHTML = str_replace('<div id="errorDati"></div>', $errormsg, $paginaHTML);
                $strReplace = " <a href=\"../pages/signup.html\" class=\"login-btn\">Registrati</a>";
                $paginaHTML = str_replace('<a href="signup.html" class="login-btn">Registrati</a>', $strReplace, $paginaHTML);
                echo ($paginaHTML);
            }
        } else {
            $errormsg = "<div class=\"errorDati\">Email o Password non coincidono</div>";
            $paginaHTML = str_replace('<div id="errorDati"></div>', $errormsg, $paginaHTML);
            $strReplace = " <a href=\"../pages/signup.html\" class=\"login-btn\">Registrati</a>";
            $paginaHTML = str_replace('<a href="signup.html" class="login-btn">Registrati</a>', $strReplace, $paginaHTML);
            echo ($paginaHTML);
        }
        $connessione->close();
    }
}
