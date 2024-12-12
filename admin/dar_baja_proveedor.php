<?php
include '../conexion.php';

if(isset($_POST["user_id"]))
{
    $proveedor_id= $_POST["user_id"];

    /*
        Drop the the Proveedor row
    */
    $query= "DELETE FROM Proveedores WHERE ID_Proveedor=?";
    $stmt= $conn->prepare($query);
    $stmt->bind_param("i", $proveedor_id);
    
    if($stmt->execute())
    {
        echo "Row removed successfully";
    }
    else
    {
        echo mysqli_error($conn);
    }
    header("Location: admin.php");
}

?>