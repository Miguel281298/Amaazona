<?php
include '../conexion.php';

$nombre= $_POST["proveedor_name"];
$telefono= $_POST["proveedor_telefono"];
$calle= $_POST["proveedor_calle"];
$numInterior= $_POST["proveedor_numInterior"];
$numExterior= $_POST["proveedor_numExterior"];
$estado= $_POST["proveedor_estado"];
$municipio= $_POST["proveedor_municipio"];
$codigoPostal= $_POST["proveedor_codigoPostal"];
$idProductos= $_POST["id-products"];

// Alta Proveedor
$query= "INSERT IGNORE INTO Proveedores (Nombre,Telefono,Calle,Numero_Interior,Numero_Exterior,Estado,Municipio,Codigo_Postal)".
        "VALUES ('".$nombre."',".$telefono.",'".$calle."',".$numInterior.",".$numExterior.",'".$estado."','".$municipio."',".$codigoPostal.");";
$conn->query($query);

// ID Proveedor query
$proveedor_query= "SELECT ID_Proveedor FROM Proveedores ". 
        "WHERE Nombre='".$nombre."' AND Telefono=".$telefono." AND Codigo_Postal=".$codigoPostal.";";
$result= $conn->query($proveedor_query) or die(mysqli_error($conn));

/* 
        Dar de alta los productos que el proveedor 
        ofrecera, registrando el ID_Proveedor y los 
        correspondientes ID_Producto.
*/
if ($result->num_rows > 0)
{       
        $id_proveedor= $result->fetch_assoc()["ID_Proveedor"];

        foreach($idProductos as $idProducto)
        {
                if (!is_int($idProducto))
                {
                        continue;
                }

                // Execute query
                $id_proveedor = intval($id_proveedor); 
                $idProducto0 = intval($idProducto[0]);

                $query = "INSERT IGNORE INTO Proveedores_Productos (ID_Proveedor, ID_Producto) VALUES (?, ?)";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("ii", $id_proveedor, $idProducto0);
                $stmt->execute();
                $stmt->close();
                
                // In case something went wrong, display the error.
                echo mysqli_error($conn);
        }
}       
else
{
        echo "No results found.";
}

// Roll back to admin screen
header("Location: admin.php");

$conn->close();
?>