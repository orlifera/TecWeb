<?php
ob_start();
// require_once('connessionedb.php');

function registrazione() {

    // Controlla se la form è stata inviata
    if (isset($_POST['submit'])) {
        
        // controlla che le password corrispondano
        if ($_POST['password'] != $_POST['password-confirm']) {
            echo '<p class="error">Le password non corrispondono.</p>';
        } else {
            // salva i dati dell'utente nel database
            $username = htmlentities(substr($_POST['username'], 0, 255));
            $nome = htmlentities(substr($_POST['nome'], 0, 255));
            $cognome = htmlentities(substr($_POST['cognome'], 0, 255));
            $email = htmlentities(substr($_POST['email'], 0, 255));
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            
            // Richiede la connessione al database
            require_once("connessionedb.php");
            
            // controlla se esiste già un utente con quel nome utente
            $stmt = $connessione->prepare("SELECT * FROM utente WHERE username = ? LIMIT 1");
            $stmt->bind_param("s", $username);
            $result = $stmt->execute();
            
            $result = $stmt->get_result()->fetch_assoc();
            
            // se esiste già un utente con quel nome utente, mostra un messaggio di errore
            if ($result >= 1) {
                echo '<p class="error">E\' già presente questo nome utente.</p>';
            } else {
                // inserisce il nuovo utente nel database
                $stmt = $connessione->prepare("INSERT INTO utente (username, nome, cognome, email, password) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("sssss", $username, $nome, $cognome, $email, $password);
                $result = $stmt->execute();
                
                // se la query ha avuto successo, reindirizza l'utente alla pagina di login
                if ($result) {
                    header('Location: ../pages/login.html');
                    die();
                } else {
                    // Commento: se la query non ha avuto successo, mostra un messaggio di errore
                    echo '<p class="error">Errore durante la registrazione: ' . $connessione->error . '</p>';
                }
            }
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
    registrazione();
}

// Chiudi la connessione solo dopo che tutte le operazioni sono state eseguite
$connessione->close();
    
?>
