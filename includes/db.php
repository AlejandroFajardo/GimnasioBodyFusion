<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);


$host = 'localhost';
$user = 'root'; // Cambia si tu usuario es diferente
$pass = '';     // Contraseña de tu MySQL
$db = 'gimnasio';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die('Error de conexión: ' . $conn->connect_error);
}
?>
