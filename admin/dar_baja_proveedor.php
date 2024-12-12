<?php
include '../conexion.php';

if(isset($_POST["user_id"]))
{
    $proveedor_id= $_POST["user_id"];

    /*
        Drop the the Proveedor row (Proveedores)
    */
    $query= "DELETE FROM Proveedores WHERE ID_Proveedor=?;";

    $stmt= $conn->prepare($query);
    $stmt->bind_param("i", $proveedor_id);
    if($stmt->execute())
    {
        echo "Row removed successfully (Proveedores)";
    }
    else
    {
        echo mysqli_error($conn);
    }
    $stmt->close();
    /*
        Remove the products of the proveedor (Proveedores_Productos)
    */
    $query= "DELETE FROM Proveedores_Productos WHERE ID_Proveedor=?;";
    $stmt2= $conn->prepare($query);
    $stmt2->bind_param("i", $proveedor_id);
    if($stmt2->execute())
    {
        echo "Row removed successfully (Proveedores & Productos)";
    }
    else
    {
        echo mysqli_error($conn);
    }
    $stmt2->close();

    header("Location: admin.php");
}

?>