<?php
$host = "localhost";
$user = "root"; 
$password = "";
$dbname = "amazonas";

$conn = new mysqli($host, $user, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

