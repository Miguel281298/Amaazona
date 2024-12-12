<?php
include '../conexion.php';

$productos = [];

if (isset($_GET['ID'])) {
    $id_categoria = $_GET['ID'];
    $id_categoria = filter_var($id_categoria, FILTER_VALIDATE_INT); // Sanitizar los datos

    $sql = "SELECT * FROM Categorias WHERE ID_Categoria = $id_categoria";
    $result = $conn->query($sql);
    $categoria = $result->fetch_assoc();

    $sql = "SELECT ID_Producto FROM Categorias_Productos WHERE ID_Categoria = $id_categoria";
    $result = $conn->query($sql);
    $temp = $result->fetch_all();
    foreach ($temp as $producto) {
        $productos[] = $producto[0];
    }
}

$errores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $imagen = $_FILES['imagen'];

    if (!$nombre) {
        $errores[] = "El nombre es obligatorio";
    }

    if (!isset($categoria) && !$imagen['name']) {
        $errores[] = 'La imagen es obligatoria';
    }

    if (empty($errores)) {
        $query = isset($categoria) ?
            "UPDATE Categorias SET Nombre = '" . $_POST['nombre'] . "' WHERE ID_Categoria = " . $_POST['id'] . ";" :
            "INSERT INTO Categorias (Nombre) VALUES ('" . $_POST['nombre'] . "');";
        $conn->query($query);

        if (!isset($categoria)) {
            $sql = "SELECT MAX(ID_Categoria) AS ultimo_id FROM Categorias";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            $id_categoria = $row['ultimo_id'];
        }
        move_uploaded_file($imagen['tmp_name'], '../img/categorias/' . $id_categoria . '.jpg');

        if (isset($categoria)) {
            $sql = "DELETE FROM Categorias_Productos WHERE ID_Categoria = $id_categoria";
            $conn->query($sql);
        }
        $sql = "";
        foreach ($_POST['productos'] as $producto) {
            $sql .= "INSERT INTO Categorias_Productos (ID_Categoria, ID_Producto) VALUES ($id_categoria, $producto);";
        }
        $conn->multi_query($sql);

        echo '<script> alert("Se han guardado los cambios"); window.location.href = "admin.php"; </script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amaazona</title>
    <link rel="stylesheet" href="css/formularios.css">
</head>

<body>

    <main class="container">
        <h2><center> <?= isset($categoria) ? 'Editar Categoria' : 'Añadir Categoria'; ?> </center></h2>
        <a href="admin.php" class="boton">Volver</a>

        <?php foreach ($errores as $error): ?>
            <div class="alerta">
                <?php echo $error; ?>
            </div>
        <?php endforeach; ?>

        <form class="formulario" method="POST" enctype="multipart/form-data">
            <fieldset>
                <legend>Información Categoria</legend>
                <div class="info">
                    <label for="nombre">Nombre: </label>
                    <input type="text" value="<?= isset($categoria) ? $categoria['Nombre'] : ''; ?>" id="nombre" name="nombre" placeholder="Nombre del Producto">

                    <label for="imagen">Imagen:</label>
                    <input type="file" id="imagen" name="imagen" accept="image/jpeg">
                </div>
            </fieldset>

            <fieldset>
                <legend>Productos que pertenecen</legend>
                <div class="opciones">
                    <?php
                    $sql = "SELECT * FROM Productos";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($producto = $result->fetch_assoc()) {
                            echo '<div class="producto">';
                            echo '<input type="checkbox" name="productos[]" id="producto' . $producto['ID_Producto'] . '" value="' . $producto['ID_Producto'] . '"' . (in_array($producto['ID_Producto'], $productos) ? ' checked' : '') .  '>';
                            echo '<label for="producto' . $producto['ID_Producto'] . '">' . $producto['Nombre'] . '</label>';
                            echo '</div>';
                        }
                    } else {
                        echo "No hay productos disponibles.";
                    }
                    ?>
                </div>
            </fieldset>
            <input name="tipo" type="hidden" value="<?php echo isset($_GET['ID']) ? 'U' : 'I' ?>">
            <input name="id" type="hidden" value="<?php echo $id_categoria ?>">
            <input class="boton" type="submit" value="Guardar Categoria" onclick="">
        </form>
    </main>
</body>

</html>