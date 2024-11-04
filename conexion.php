<?php
$host = "bousqgpxzzqtmjnjwawg-mysql.services.clever-cloud.com";
$user = "uawcytjipzqvk5hg"; 
$password = "wCiF6juaxbeCzvn8RpyQ";
$dbname = "bousqgpxzzqtmjnjwawg";

$conn = new mysqli($host, $user, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

