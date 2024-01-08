<?php
if(!isset($_SESSION['username'])){
  header('Location: ../pages/login.html');
  exit;
}
?>
