<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// session_start();
require_once("connessionedb.php");

session_start();
if (isset($_SESSION['user']) && $_SESSION['user'] !== '') {
    header('Location: ../pages/profile.html');
    exit();
}

if($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['submit'])) { 
        
        if ($_POST['password'] != $_POST['password-confirm']) {
            // echo '<p class="error">Le password non corrispondono.</p>';
            echo '<script>alert("Le password non corrispondono.");</script>';
            echo 'Debug: psw diverse';
        } else {
            // salva i dati dell'utente nel database
            $nome = htmlentities(substr($_POST['fname'], 0, 255));
            $cognome = htmlentities(substr($_POST['lname'], 0, 255));
            // $dataNascita = DateTime::createFromFormat('d/m/Y', $_POST['dob'])->format('Y-m-d');
            // $dataNascita = $_POST['dob'];
            $dataNascita = strtotime($_POST['dob']);
            $dataNascita = date('Y-m-d H:i:s', $dataNascita);
            $genere = htmlentities($_POST['gender']);
            $username = htmlentities(substr($_POST['user'], 0, 255));
            $email = htmlentities(substr($_POST['email'], 0, 255));
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $telefono = htmlentities(substr($_POST['phone'], 0, 16));
            $citta = htmlentities(substr($_POST['city'], 0, 255));
            $indirizzo = htmlentities(substr($_POST['address'], 0, 255));
            $cap = htmlentities(substr($_POST['cap'], 0, 5));

            // Tenta di creare un oggetto DateTime dalla data inviata
// $dateOfBirth = DateTime::createFromFormat('d/m/Y', $_POST['dob']);

// // Verifica se la creazione dell'oggetto DateTime ha avuto successo
// if ($dateOfBirth !== false) {
//     // Se ha successo, formatta la data nel formato richiesto
//     $dataNascita = $dateOfBirth->format('Y-m-d');
// } else {
//     // Se fallisce, mostra un messaggio di errore
//     echo '<p class="error">Formato data di nascita non valido. Utilizzare il formato gg/mm/aaaa.</p>';
//     // Puoi decidere di terminare lo script o gestire l'errore in altro modo
//     exit();
// }
            
            // Richiede la connessione al database
            // require_once("connessionedb.php");
            
            // controlla se esiste già un utente con quel nome utente e quella mail
            $stmt = $connessione->prepare("SELECT * FROM utente WHERE username = ? OR email = ? LIMIT 1");
            $stmt->bind_param("ss", $username, $email);
            $result = $stmt->execute();
            
            // $result = $stmt->get_result()->fetch_assoc();
            $result = $stmt->get_result();
            
            // se esiste già un utente con quel nome utente, mostra un messaggio di errore
            if ($result->num_rows > 0) {
                echo '<p class="error">E\' già presente un utente con questo nome utente o email.</p>';
            } else {
                // inserisce il nuovo utente nel database
                $stmt = $connessione->prepare("INSERT INTO utente (nome, cognome, dataNascita, genere, username, email, password, telefono, citta, indirizzo, cap) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("sssssssssss", $nome, $cognome, $dataNascita, $genere, $username, $email, $password, $telefono, $citta, $indirizzo, $cap);
                $result = $stmt->execute();
                
                // se la query ha avuto successo, reindirizza l'utente alla pagina di login
                if ($result) {
                    // session_unset();
                    // session_destroy();
                    header('Location: ../pages/login.html');
                    die();
                } else {
                    // Commento: se la query non ha avuto successo, mostra un messaggio di errore
                    echo '<p class="error">Errore durante la registrazione: ' . $connessione->error . '</p>';
                }
            }
        }
    }
    $connessione->close();
    // session_unset();
    // session_destroy();
}

?>