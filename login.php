<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include('conexion.php');

    $usuario = $_POST['correo'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM Admin WHERE Usuario = '$usuario'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        // Verificar la contraseña
        if ($password == $row['Password']) {
            echo "Acceso De Administrador Correcto.";
            header("Location: ./admin/admin.php"); // Redirigir a la página principal
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        $sql = "SELECT * FROM Usuarios WHERE Correo = '$usuario'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            // Verificar la contraseña
            if (password_verify($password, $row['Password'])) {
                $_SESSION['nombre'] = $row['Nombre'];
                $_SESSION['apellido'] = $row['Apellido'];
                $_SESSION['ID_Usuario'] = $row['ID_Usuario'];
                $_SESSION['correo'] = $row['Correo'];
                header("Location: tienda.php"); // Redirigir a la página principal
            } else {
                echo "Contraseña incorrecta.";
            }
        } else {
            echo "El correo no está registrado.";
        }
    }

    $conn->close();
}

