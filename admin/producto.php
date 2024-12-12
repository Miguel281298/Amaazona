<?php
include '../conexion.php';

$categorias = [];

if (isset($_GET['ID'])) {
    $id_producto = $_GET['ID'];
    $id_producto = filter_var($id_producto, FILTER_VALIDATE_INT); // Sanitizar los datos

    $sql = "SELECT * FROM Productos WHERE ID_Producto = $id_producto";
    $result = $conn->query($sql);
    $producto = $result->fetch_assoc();

    $sql = "SELECT ID_Categoria FROM Categorias_Productos WHERE ID_Producto = $id_producto";
    $result = $conn->query($sql);
    $temp = $result->fetch_all();
    foreach ($temp as $categoria) {
        $categorias[] = $categoria[0];
    }
}

$errores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $descripcion = $_POST['descripcion'];
    $imagen = $_FILES['imagen'];

    if (!$nombre) {
        $errores[] = "El nombre es obligatorio";
    }

    if (!$precio) {
        $errores[] = 'El precio es obligatorio';
    }

    if (!$stock) {
        $errores[] = 'El stock es obligatorio';
    }

    if (!isset($producto) && !$imagen['name']) {
        $errores[] = 'La imagen es obligatoria';
    }

    if (strlen($descripcion) < 2) {
        $errores[] = 'La descripción es obligatoria';
    }

    if (empty($errores)) {
        $query = $producto ?
            "UPDATE Productos SET Nombre = '" . $nombre . "', Precio = '" . $precio . "', Stock = '" . $stock . "', Descripcion = '" . $descripcion . "' WHERE ID_Producto = " . $producto['ID_Producto'] . "" :
            "INSERT INTO Productos (Nombre, Precio, Stock, Descripcion) VALUES ('$nombre', '$precio', '$stock', '$descripcion')";
        $conn->query($query);

        if (!isset($producto)) {
            $sql = "SELECT MAX(ID_Producto) AS ultimo_id FROM Productos";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            $id_producto = $row['ultimo_id'];
        }
        move_uploaded_file($imagen['tmp_name'], '../img/productos/' . $id_producto . '.png');

        if (isset($producto)) {
            $sql = "DELETE FROM Categorias_Productos WHERE ID_Producto = $id_producto";
            $conn->query($sql);
        }
        $sql = "";
        foreach ($_POST['categorias'] as $categoria) {
            $sql .= "INSERT INTO Categorias_Productos (ID_Categoria, ID_Producto) VALUES ($categoria, $id_producto);";
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
        <h2>
            <center> <?= isset($producto) ? 'Editar Producto' : 'Añadir Producto'; ?> </center>
        </h2>
        <a href="admin.php" class="boton">Volver</a>

        <?php foreach ($errores as $error): ?>
            <div class="alerta">
                <?php echo $error; ?>
            </div>
        <?php endforeach; ?>

        <form class="formulario" method="POST" enctype="multipart/form-data">
            <fieldset>
                <legend>Información Producto</legend>
                <div class="info">
                    <label for="nombre">Nombre: </label>
                    <input type="text" value="<?= isset($producto) ? $producto['Nombre'] : ''; ?>" id="nombre" name="nombre" placeholder="Nombre del Producto">

                    <label for="precio">Precio: </label>
                    <input type="number" value="<?= isset($producto) ? $producto['Precio'] : ''; ?>" id="precio" name="precio" step="0.01" placeholder="Precio" min="0">

                    <label for="stock">Stock: </label>
                    <input type="number" value="<?= isset($producto) ? $producto['Stock'] : ''; ?>" id="stock" name="stock" placeholder="Stock en existencia" min="0">

                    <label for="imagen">Imagen:</label>
                    <input type="file" id="imagen" name="imagen" accept="image/jpeg">

                    <label for="descripcion">Descripción:</label>
                    <textarea name="descripcion" id="descripcion"><?= isset($producto) ? $producto['Descripcion'] : ''; ?> </textarea>
                </div>
            </fieldset>

            <fieldset>
                <legend>Pertenencia a Categorias</legend>
                <div class="opciones">
                    <?php
                    $sql = "SELECT * FROM Categorias";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($categoria = $result->fetch_assoc()) {
                            echo '<div class="categoria">';
                            echo '<input type="checkbox" name="categorias[]" id="categoria' . $categoria['ID_Categoria'] . '"value="' . $categoria['ID_Categoria'] . '"' . (in_array($categoria['ID_Categoria'], $categorias) ? ' checked' : '') . '>';
                            echo '<label for="categoria' . $categoria['ID_Categoria'] . '">' . $categoria['Nombre'] . '</label>';
                            echo '</div>';
                        }
                    } else {
                        echo "No hay categorias disponibles.";
                    }
                    ?>
                </div>
            </fieldset>
            <input name="tipo" type="hidden" value="<?php echo isset($_GET['ID']) ? 'U' : 'I' ?>">
            <input name="id" type="hidden" value="<?php echo $id_producto ?>">
            <input class="boton" type="submit" value="Guardar Producto">
        </form>
    </main>

</body>

</html>