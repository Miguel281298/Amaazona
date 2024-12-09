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
    if ($action == "1")
    {
        // Proveedor new info
        $nombre= $_POST["proveedor_name"];
        $telefono= $_POST["proveedor_telefono"];
        $calle= $_POST["proveedor_calle"];
        $numInterior= $_POST["proveedor_numInterior"];
        $numExterior= $_POST["proveedor_numExterior"];
        $estado= $_POST["proveedor_estado"];
        $municipio= $_POST["proveedor_municipio"];
        $codigoPostal= $_POST["proveedor_codigoPostal"];
        $idProductos= $_POST["id-products"];

        $setIdProductos= [];
        foreach($idProductos as $id)
        {
            if(!is_numeric($id))
                continue;

            $setIdProductos[$id]= true;
        }


        /* Updating proveedor info */
        $query= "
                UPDATE Proveedores 
                SET Nombre=?, Telefono=?, Calle=?, Numero_Interior=?, Numero_Exterior=?, Estado=?, Municipio=?, Codigo_Postal=?
                WHERE ID_Proveedor = ?
        ";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sisiissii", $nombre,$telefono,$calle,$numInterior,$numExterior,$estado,$municipio,$codigoPostal,$idProveedor);            
        // Execute the query
        if ($stmt->execute()) {
            echo "Row updated successfully!";
        } else {
            echo "Error updating row: " . $stmt->error;
        }

        /* Updating proveedor products */
        // Get the products in the DB
        $query= "
                SELECT ID_Producto FROM Proveedores_Productos WHERE ID_Proveedor=$idProveedor;
        ";
        $result= $conn->query($query);
        if($result->num_rows > 0)
        {
            // Check if the products in the form are already in DB
            $inDB= [];
            while($prod= $result->fetch_assoc())
            {   
                print_r($prod);
                if (array_key_exists($prod["ID_Producto"], $setIdProductos))
                {
                    unset($setIdProductos[$prod["ID_Producto"]]);
                    continue;
                }
                $inDB[]= $prod["ID_Producto"];
            }

            // The products in $inDb are going to be removed
            if(!empty($inDB))
            {
                $query= "DELETE FROM Proveedores_Productos WHERE ID_Proveedor = $idProveedor AND (0";
                foreach($inDB as $id)
                {
                    $query= $query." OR ID_Producto=".$id;
                }
                $query= $query.");";
                echo $query;
                $conn->query($query) or die("Error on first query ".mysqli_error($conn));
            }
            
            // The products in $setIdProductos are going to be added
            if(!empty($setIdProductos))
            {
                $query= "INSERT IGNORE INTO Proveedores_Productos (ID_Proveedor, ID_Producto) VALUES ";
                foreach($setIdProductos as $key => $id)
                {
                    if (!is_int($key))
                    {
                        continue;
                    }
                    
                    $query= $query."($idProveedor,$key),";
                }
                $query= substr($query,0,-1);
                $query= $query.";";
                $conn->query($query) or die("Error on second Query. ".mysqli_error($conn));
            }
            
            // Roll back to admin screen
            header("Location: admin.php");
        }
    }
    else
    {
        // Consult the proveedor information 
        $query= "SELECT * FROM Proveedores WHERE ID_Proveedor=".$idProveedor.";";
        $result= $conn->query($query);
        // Consult the products tha the Proveedor supply
        $query_prod = "
                        SELECT ID_Producto 
                        FROM Proveedores_Productos 
                        WHERE ID_Proveedor = $idProveedor;
                    ";
        $result_prod= $conn->query($query_prod);

        $products= [];
        if($result_prod->num_rows > 0)
        {
            while($p= $result_prod->fetch_assoc())
            {
                $products[]= $p;
            }
        }

        if($result->num_rows > 0)
        {
            $data= $result->fetch_assoc();
            $data["products"]= $products;

            echo json_encode($data);
        }
    }
}

$conn->close();
?>