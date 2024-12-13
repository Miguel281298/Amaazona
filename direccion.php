<?php
session_start();

// Si el usuario no ha iniciado sesión, redirigir al login
if (!isset($_SESSION['nombre'])) {
    header("Location: index_login.php");
    exit();
}

include 'conexion.php'; // Incluye tu conexión a la base de datos

$calle = "";
$numeroInterior = "";
$numeroExterior = "";
$fracc = "";
$codigoPostal = "";
$estado = "";
$municipio = "";
$localidad = "";
$referencia = "";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM Direcciones_Entrega WHERE ID_Direccion_Entrega = " . $id . ";";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    if ($row['ID_Usuario'] != $_SESSION['ID_Usuario']) {
        header("Location: perfil.php");
    }
    $calle = $row['Calle'];
    $numeroInterior = $row['Num_Interior'];
    $numeroExterior = $row['Num_Exterior'];
    $fracc = $row['Fraccionamiento_Colonia'];
    $codigoPostal = $row['Codigo_Postal'];
    $estado = $row['Estado'];
    $municipio = $row['Municipio'];
    $localidad = $row['Localidad'];
    $referencia = $row['Referencia'];
}

$errores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $calle = $_POST['calle'];
    $numeroInterior = $_POST['num_interior'];
    $numeroExterior = $_POST['num_exterior'];
    $fracc = $_POST['fraccionamiento'];
    $codigoPostal = $_POST['cp'];
    $estado = $_POST['estado'];
    $municipio = $_POST['municipio'];
    $localidad = $_POST['localidad'];
    $referencia = $_POST['referencia'];

    if (!$calle) {
        $errores[] = 'La calle es obligatoria';
    }

    if (!$numeroExterior) {
        $errores[] = 'El numero exterior es obligatorio';
    }

    if (!$fracc) {
        $errores[] = 'El fraccionamiento o colonia es obligatori@';
    }

    if (!$codigoPostal) {
        $errores[] = 'El codigo postal es obligatorio';
    }

    if (!$estado) {
        $errores[] = 'El estado es obligatorio';
    }

    if (!$municipio) {
        $errores[] = 'El municipio es obligatorio';
    }

    if (!$localidad) {
        $errores[] = 'La localidad es obligatoria';
    }

    if (empty($errores)) {
        $sql = isset($id) ?
        "UPDATE Direcciones_Entrega SET Calle='$calle', Num_Interior=" . ($numeroInterior ? "'$numeroInterior'" : "NULL") . ", Num_Exterior='$numeroExterior', Fraccionamiento_Colonia='$fracc', Codigo_Postal='$codigoPostal', Estado='$estado', Municipio='$municipio', Localidad='$localidad', Referencia='$referencia' WHERE ID_Direccion_Entrega = $id;" :
        "INSERT INTO Direcciones_Entrega (Calle, Num_Interior, Num_Exterior, Fraccionamiento_Colonia, Codigo_Postal, Estado, Municipio, Localidad, Referencia, ID_Usuario) VALUES ('$calle', ". ($numeroInterior ? "'$numeroInterior'" : "NULL") . ", '$numeroExterior', '$fracc', '$codigoPostal', '$estado', '$municipio', '$localidad', '$referencia', '$_SESSION[ID_Usuario]');";
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
                <label for="calle">Calle: </label>
                <input type="text" value="<?= $calle; ?>" id="calle" name="calle" placeholder="Calle">

                <label for="no_interior">N° Interior: </label>
                <input type="number" value="<?= $numeroInterior; ?>" id="no_interior" name="num_interior" placeholder="Num. Interior">

                <label for="no_exterior">N° Exterior: </label>
                <input type="number" value="<?= $numeroExterior; ?>" id="no_exterior" name="num_exterior" placeholder="Num. Exterior">

                <label for="fraccionamiento">Fraccionamiento/Colonia: </label>
                <input type="text" value="<?= $fracc; ?>" id="fraccionamiento" name="fraccionamiento" placeholder="Fraccionamiento/Colonia">

                <label for="cp">C.P.: </label>
                <input type="number" value="<?= $codigoPostal; ?>" id="cp" name="cp" placeholder="Codigo Postal" maxlength="5">

                <label for="estado">Estado: </label>
                <input type="text" value="<?= $estado; ?>" id="estado" name="estado" placeholder="Estado">

                <label for="municipio">Municipio: </label>
                <input type="text" value="<?= $municipio; ?>" id="municipio" name="municipio" placeholder="Municipio">

                <label for="localidad">Localidad: </label>
                <input type="text" value="<?= $localidad; ?>" id="localidad" name="localidad" placeholder="Localidad">

                <label for="referencia">Referencia: </label>
                <textarea  id="referencia" name="referencia" placeholder="Referencia" rows="5" cols="60"><?= $referencia; ?></textarea>
            </div>
            <input type="submit" value="Guardar" class="boton">
        </form>
    </main>
</body>

</html>