<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include('conexion.php');

    $correo = $_POST['correo'];
    $contrasenia = $_POST['contrasenia'];

    $sql = "SELECT * FROM usuarios WHERE Correo = '$correo'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Verificar la contraseña
        if (password_verify($contrasenia, $row['Contrasenia'])) {
            $_SESSION['nombre'] = $row['Nombre'];
            $_SESSION['apellido'] = $row['Apellido'];
            header("Location: tienda.php"); // Redirigir a la página principal
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        echo "El correo no está registrado.";
    }

    $conn->close();
}

