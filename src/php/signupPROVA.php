<?php

// Richiedi la connessione al database
require_once("connessionedb.php");

  // Controlla se il form è stato inviato
  if (isset($_POST['submit'])) {
    // Controlla che le password corrispondano
    if ($_POST['password'] != $_POST['password-confirm']) {
      echo '<p class="error">Le password non corrispondono.</p>';
    } else {
      // Salva i dati dell'utente nel database
      $username = htmlentities(substr($_POST['username'], 0, 255));
      $nome = htmlentities(substr($_POST['nome'], 0, 255));
      $cognome = htmlentities(substr($_POST['cognome'], 0, 255));
      $email = htmlentities(substr($_POST['email'], 0, 255));
      $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

      // controlla se esiste già un utente con quel nome utente
      // $stmt = $connessione->prepare("SELECT * FROM utente WHERE username = ? LIMIT 1");
      // $stmt->bind_param("s", $username);
      // $result = $stmt->execute();

      // Esegui la query di inserimento
      $sql = "INSERT INTO utente (username, nome, cognome, email, password) VALUES ('$username', '$nome', '$cognome', '$email', '$password')";
      $conn->query($sql);

      // Chiude la connessione al database
      $conn->close();

      // Ridirige l'utente alla pagina di login
      header('Location: login.php');
    }
  }
?>