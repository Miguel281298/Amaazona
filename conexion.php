<?php
// Datos de conexión a la base de datos
$host = "bousqgpxzzqtmjnjwawg-mysql.services.clever-cloud.com";
$user = "uawcytjipzqvk5hg"; 
$password = "wCiF6juaxbeCzvn8RpyQ";
$dbname = "bousqgpxzzqtmjnjwawg";

/**
 * Función para establecer una conexión a la base de datos.
 * Utiliza una conexión única para optimizar el uso de recursos.
 */
function conectarBD() {
    global $host, $user, $password, $dbname;
    
    // Usar una variable estática para una única conexión persistente
    static $conn;

    // Verifica si ya existe una conexión abierta
    if ($conn === null) {
        try {
            // Intentar crear una nueva conexión
            $conn = new mysqli($host, $user, $password, $dbname);

            // Verificar si la conexión fue exitosa
            if ($conn->connect_error) {
                // Registrar el error en un log y mostrar un mensaje genérico al usuario
                error_log("Error de conexión: " . $conn->connect_error);
                die("No se pudo conectar a la base de datos en este momento.");
            }
            
            // Configurar para que use UTF-8
            $conn->set_charset("utf8");
            
        } catch (Exception $e) {
            // Manejo de excepción en caso de error crítico
            error_log("Excepción en la conexión: " . $e->getMessage());
            die("Error inesperado. Intente más tarde.");
        }
    }

    return $conn;
}

// Ejemplo de uso
$conn = conectarBD();
