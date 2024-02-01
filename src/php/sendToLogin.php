<?php
session_start();
if (!isset($_SESSION['user'])) {
  header('Location: ../pages/login.html');
  exit;
} else {
  header('Location: ../php/profile.php');
}
