<?php
include '../conexion.php';

if (isset($_POST['user_id']) && isset($_POST['action'])) {

    $action= $_POST["action"];
    $idProveedor= $_POST["user_id"];
    /*
        If action is:
            - 0. We will consult the user_id information.
            - 1. We will edit the information of the user_id row.
    */
    if ($action)
    {}
    else
    {
        $query= "SELECT * FROM Proveedores WHERE ID_Proveedor=".$idProveedor.";";
        $result= $conn->query($query);

        if($result->num_rows > 0)
        {
            $data= $result->fetch_assoc();

            echo json_encode($data);
        }
    }
}


$conn->close();
?>