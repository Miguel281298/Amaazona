<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include('conexion.php');
    session_start();

    // Obtener los datos del formulario
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $correo = $_POST['correo'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Encriptar contraseña

    // Consulta para insertar el nuevo usuario en la base de datos
    $sql = "INSERT INTO Usuarios (Nombre, Apellido, Correo, Password) VALUES ('$nombre', '$apellido', '$correo', '$password')";

    if ($conn->query($sql) === TRUE) {
        // Iniciar sesión automáticamente al registrar el usuario
        $_SESSION['nombre'] = $nombre;
        $_SESSION['apellido'] = $apellido;
        $_SESSION['ID_Usuario'] = $resultado['ID_Usuario'];

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
