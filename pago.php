<?php
session_start();

// Si el usuario no ha iniciado sesión, redirigir al login
if (!isset($_SESSION['nombre'])) {
    header("Location: index_login.php");
    exit();
}

include 'conexion.php'; // Incluye tu conexión a la base de datos

$numero = "";
$vencimiento = "";
$cvv = "";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM Metodos_Pago WHERE ID_Metodo_Pago = " . $id . ";";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    if ($row['ID_Usuario'] != $_SESSION['ID_Usuario']) {
        header("Location: perfil.php");
    }
    $numero = $row['Numero_Tarjeta'];
    $vencimiento = $row['Fecha_Vencimiento'];
    $cvv = $row['CVV'];
}

$errores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $numero = $_POST['numero'];
    $vencimiento = $_POST['vencimiento'];
    $cvv = $_POST['cvv'];

    if (!$numero) {
        $errores[] = 'El numero de tarjeta es obligatorio';
    }

    if (!$vencimiento) {
        $errores[] = 'La fecha de vencimiento es obligatoria';
    }

    if (!$cvv) {
        $errores[] = 'El CVV es obligatorio';
    }

    if (empty($errores)) {
        $sql = isset($id) ?
        "UPDATE Metodos_Pago SET Numero_Tarjeta='$numero', Fecha_Vencimiento='$vencimiento', CVV='$cvv' WHERE ID_Metodo_Pago = $id;" :
        "INSERT INTO Metodos_Pago (Numero_Tarjeta, Fecha_Vencimiento, CVV, ID_Usuario) VALUES ('$numero', '$vencimiento', '$cvv', " . $_SESSION['ID_Usuario'] . ");";
        $conn->query($sql);
        echo '<script> alert("Se han guardado los cambios");</script>';
        if (!isset($id)) {
            echo '<script> window.location.href = "perfil.php";</script>';
        }
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
        <h2><center> Editar direccion </center></h2>
        <a href="perfil.php" class="boton">Volver</a>
        <?php foreach ($errores as $error): ?>
            <div class="alerta">
                <?php echo $error; ?>
            </div>
        <?php endforeach; ?>
        <form class="formulario" method="POST" style="margin-top: 20px;">
            <div class="info">
                <label for="numero">Número de tarjeta: </label>
                <input type="number" value="<?= $numero; ?>" id="numero" name="numero" placeholder="Numero de tarjeta" maxlength="16">

                <label for="vencimiento">Fecha de vencimiento: </label>
                <input type="date" value="<?= $vencimiento; ?>" id="vencimiento" name="vencimiento" placeholder="Fecha de vencimiento">

                <label for="cvv">CVV: </label>
                <input type="password" value="<?= $cvv; ?>" id="cvv" name="cvv" placeholder="CVV" maxlength="3">
            </div>
            <input type="submit" value="Guardar" class="boton">
        </form>
        <form action="dar_baja.php" method="POST">
        <?php if (isset($id)) { ?>
            <input type="hidden" name="id" value="<?= $id; ?>">
            <input type="hidden" name="opcion" value="2">
            <input type="submit" value="Eliminar metodo de pago" class="boton eliminar">
        <?php } ?>
        </form>
    </main>
</body>

</html>