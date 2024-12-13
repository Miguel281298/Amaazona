<?php
session_start();

// Si el usuario no ha iniciado sesión, redirigir al login
if (!isset($_SESSION['nombre'])) {
    header("Location: index_login.php");
    exit();
}

include 'conexion.php'; // Incluye tu conexión a la base de datos

$errores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $contrasena = $_POST['contrasena'];
    $contrasena_nueva = $_POST['contrasena_nueva'];

    if (!$nombre) {
        $errores[] = 'El nombre es obligatorio';
    }

    if (!$apellido) {
        $errores[] = 'El apellido es obligatorio';
    }

    if ($contrasena_nueva) {
        if (!$contrasena) {
            $errores[] = 'Debes confirmar tu contrasena para actualizarla';
        } else {
            $sql = "SELECT Password FROM Usuarios WHERE ID_Usuario = " . $_SESSION['ID_Usuario'] . ";";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            if (!password_verify($contrasena, $row['Password'])) {
                $errores[] = 'La contrasena es incorrecta';
            }
        }
    }

    if (empty($errores)) {
        $sql = "UPDATE Usuarios SET Nombre = '$nombre', Apellido = '$apellido' WHERE ID_Usuario = " . $_SESSION['ID_Usuario'] . ";";
        $conn->query($sql);
        $_SESSION['nombre'] = $nombre;
        $_SESSION['apellido'] = $apellido;

        if ($contrasena && $contrasena_nueva) {
            $sql = "UPDATE Usuarios SET Password = '" . password_hash($contrasena_nueva, PASSWORD_BCRYPT) . "' WHERE ID_Usuario = " . $_SESSION['ID_Usuario'] . ";";
            $conn->query($sql);
        }
        echo '<script> alert("Se han guardado los cambios");</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amaazona</title>
    <link rel="stylesheet" href="css/perfil.css">
</head>

<body>

    <main class="container">
        <h2><center> Mi perfil </center></h2>
        <a href="tienda.php" class="boton">Volver</a>
        <?php foreach ($errores as $error): ?>
            <div class="alerta">
                <?php echo $error; ?>
            </div>
        <?php endforeach; ?>
        <form class="formulario" method="POST">
            <fieldset>
                <legend>Datos personales</legend>
                    <div class="info">
                        <label for="nombre">Nombre: </label>
                        <input type="text" value="<?= $_SESSION['nombre']; ?>" id="nombre" name="nombre" placeholder="Nombre">

                        <label for="apellido">Apellido:</label>
                        <input type="text" value="<?= $_SESSION['apellido']; ?>" id="apellido" name="apellido" placeholder="Apellido">
                        <p style="margin: 0 0 20px;"><b>CORREO:</b> <?= $_SESSION['correo']; ?></p>
                    </div>
            </fieldset>
            <fieldset>
                <legend>Contraseña</legend>
                <div class="info">
                    <label for="contrasena">Confirma tu contraseña: </label>
                    <input type="password" id="contrasena" name="contrasena" placeholder="Contraseña actual">

                    <label for="contrasena_nueva">Nueva contraseña:</label>
                    <input type="password" id="contrasena_nueva" name="contrasena_nueva" placeholder="Contraseña nueva">
                </div>
            </fieldset>
            <input type="submit" value="Guardar" class="boton">
        </form>
        <fieldset>
            <legend>Direcciones de entrega</legend>
            <ul>
                <?php
                    $sql = "SELECT * FROM Direcciones_Entrega WHERE ID_Usuario = " . $_SESSION['ID_Usuario'];
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($direccion = $result->fetch_assoc()) {
                            echo '<li>';
                            echo '<p>' . $direccion['Calle'] . ' #' . $direccion['Num_Exterior'] . ', ' . $direccion['Estado'] . '</p>';
                            echo '<a class="boton editar" href="direccion.php?id=' . $direccion['ID_Direccion_Entrega'] . '">Editar</a>';
                            echo '</li>';
                        }
                    } else {
                        echo '<li>';
                        echo '<p>No tienes direcciones de entrega registradas</p>';
                        echo '</li>';
                    }
                ?>
                <li>
                    <a class="boton" href="direccion.php" style="margin: auto;">Agregar nueva</a>
                </li>
            </ul>
        </fieldset>
        <fieldset>
            <legend>Metodos de pago</legend>
            <ul>
                <?php
                    $sql = "SELECT * FROM Metodos_Pago WHERE ID_Usuario = " . $_SESSION['ID_Usuario'];
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($metodo = $result->fetch_assoc()) {
                            echo '<li>';
                            echo '<p>' . str_replace(range(0,9), "*", substr($metodo['Numero_Tarjeta'], 0, -4)) .  substr($metodo['Numero_Tarjeta'], -4) . '</p>';
                            echo '<a class="boton editar" href="pago.php?id=' . $metodo['ID_Metodo_Pago'] . '">Editar</a>';
                            echo '</li>';
                        }
                    } else {
                        echo '<li>';
                        echo '<p>No tienes metodos de pago registrados</p>';
                        echo '</li>';
                    }
                ?>
                <li>
                    <a class="boton" href="pago.php" style="margin: auto;">Agregar nueva</a>
                </li>
            </ul>
        </fieldset>
    </main>
</body>

</html>