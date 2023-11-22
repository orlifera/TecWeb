<?php
  // Controlla se il form è stato inviato
  if (isset($_POST['submit'])) {
    // Controlla che le password corrispondano
    if ($_POST['password'] != $_POST['password-confirm']) {
      echo '<p class="error">Le password non corrispondono.</p>';
    } else {
      // Salva i dati dell'utente nel database
      $nome = $_POST['nome'];
      $cognome = $_POST['cognome'];
      $email = $_POST['email'];
      $username = $_POST['username'];
      $password = md5($_POST['password']);

      // Connetti al database
      require_once("connessionedb.php");

      // Esegui la query di inserimento
      $sql = "INSERT INTO utenti (username, nome, cognome, email, password) VALUES ('$username', '$nome', '$cognome', '$email', '$password')";
      $conn->query($sql);

      // Chiude la connessione al database
      $conn->close();

      // Ridirige l'utente alla pagina di login
      header('Location: login.php');
    }
  }
?>
