<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit();
}

// Puedes usar $_SESSION['role'] para verificar si es admin o user
