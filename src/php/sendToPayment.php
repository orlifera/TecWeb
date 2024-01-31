<?php
session_start();
if (isset($_POST['processOrder'])) {
    if(isset($_SESSION['user'])) {
        header('Location: ../pages/payments.html');
    } else {
        header('Location: ../pages/checkout.html');
    }
}