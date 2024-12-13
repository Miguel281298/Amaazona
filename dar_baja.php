<?php
include 'conexion.php';

$opcion = $_POST["opcion"];

if ($opcion == 1) {
    $id_direccion = $_POST["id"];

    $query = "DELETE FROM Direcciones_Entrega WHERE ID_Direccion_Entrega = $id_direccion";

    $result = $conn->query($query);

    if ($result) {
        echo "<script>alert('Se elimino la direccion correctamente');</script>";
    } else {
        echo mysqli_error($conn);
    }
} else if ($opcion == 2) {
    $id_metodo = $_POST["id"];

    $query = "DELETE FROM Metodos_Pago WHERE ID_Metodo_Pago = $id_metodo";

    $result = $conn->query($query);

    if ($result) {
        echo "<script>alert('Se elimino el metodo de pago correctamente');</script>";
    } else {
        echo mysqli_error($conn);
    }
}

echo '<script> window.location.href = "perfil.php";</script>';
?>