<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include('conexion.php');
    session_start();

    // Obtener los datos del formulario
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $correo = $_POST['correo'];
    $contrasenia = password_hash($_POST['contrasenia'], PASSWORD_BCRYPT); // Encriptar contraseña

    // Consulta para insertar el nuevo usuario en la base de datos
    $sql = "INSERT INTO usuarios (Nombre, Apellido, Correo, Contrasenia) VALUES ('$nombre', '$apellido', '$correo', '$contrasenia')";

    if ($conn->query($sql) === TRUE) {
        // Iniciar sesión automáticamente al registrar el usuario
        $_SESSION['nombre'] = $nombre;
        $_SESSION['apellido'] = $apellido;

        // Redirigir a la tienda con un mensaje emergente
        echo '<script>
        alert("Te has registrado exitosamente");
        window.location.href = "tienda.php";
        </script>';
    } else {
        echo '<script>
        alert("Algo ha salido mal, inténtalo de nuevo.");
        window.location.href = "index_login.php";
        </script>';
    }

    // Cerrar la conexión
    $conn->close();
}
