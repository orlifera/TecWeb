<?php
session_start();
if (isset($_POST['processOrder'])) {
    if (isset($_SESSION['user'])) {
        header('Location: ../php/order.php');
    } else {
        header('Location: ../pages/checkout.html');
    }
}
