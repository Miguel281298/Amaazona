<?php
include '../conexion.php';

$opcion = $_GET['tipo'];

if ($opcion == 1) {
    $id_categoria = $_POST["id"];

    $query = "DELETE FROM Categorias WHERE ID_Categoria = $id_categoria";

    $result = $conn->query($query);

    if ($result) {
        echo "Se elimino la categoria correctamente";
        unlink('../img/categorias/'.$id_categoria.'.jpg');
    } else {
        echo mysqli_error($conn);
    }
} else if ($opcion == 2) {
    $id_producto = $_POST["id"];

    $query = "DELETE FROM Productos WHERE ID_Producto = $id_producto";
    
    $result = $conn->query($query);

    if ($result) {
        echo "Se elimino el producto correctamente";
        unlink('../img/productos/'.$id_producto.'.png');
    } else {
        echo mysqli_error($conn);
    }
}

header("Location: admin.php");
?>