<?php
include '../conexion.php';

if(isset($_POST["action"]) && isset($_POST["user_id"]))
{   
    $proveedor_id= $_POST["user_id"];

    if($_POST["action"]) // Modify the inventory
    {

        $idProductos= $_POST["id-producto"];
        $cantidadProductos= $_POST["cantidad-producto"];
        $precioProductos= $_POST["precio-producto"];

        // Initialize arrays to store the filtered results
        $uniqueIds = [];
        $filteredIds = [];
        $filteredCantidad = [];
        $filteredPrecio = [];

        // Iterate through the product IDs
        foreach ($idProductos as $index => $id) {
            if (!is_numeric($id))
            {
                continue;
            }

            if(empty($id) || empty($cantidadProductos[$index]) || empty($precioProductos[$index]))
            {
                echo "Los datos no estan completos";
                header("Location: admin.php");
                exit();
            }

            // Check if the product ID has already been processed
            if (!in_array($id, $uniqueIds)) {
                // Add to unique IDs and the filtered arrays
                $uniqueIds[] = $id;
                $filteredIds[] = $id;
                $filteredCantidad[] = $cantidadProductos[$index];
                $filteredPrecio[] = $precioProductos[$index];
            }
        }

        if(!empty($filteredIds))
        {
            // Consult the last ID
            $query= "SELECT MAX(ID_Compras) FROM Compras";
            $result= $conn->query($query) or die(mysqli_error($conn));
            $lastID= ($result->num_rows > 0)? $result->fetch_assoc()["MAX(ID_Compras)"] + 1 : 0;

            // Compute the total
            $total= 0;
            foreach ($filteredIds as $index => $value) {
                $total= $total + ($filteredCantidad[$index] * $filteredPrecio[$index]);
            }

            // Register the purchased
            $query= "INSERT IGNORE INTO Compras(ID_Compras,ID_Proveedor,Total) VALUES ($lastID,$proveedor_id,$total);"; 
            $conn->query($query) or die(mysqli_error($conn));

            // Insert the purchased products
            $query= "INSERT INTO Detalle_Compras (ID_Producto,ID_Compras,Cantidad,Precio) VALUES ";
            foreach ($filteredIds as $index => $value) {
                $query= $query . "($value,$lastID,$filteredCantidad[$index],$filteredPrecio[$index]),";
            }
            $query= substr($query,0,-1);
            $query= $query.";";
            $conn->query($query) or die(mysqli_error($conn));

            // Update the stock
            foreach ($filteredIds as $index => $value) {
                $query= "UPDATE Productos SET Stock=Stock+$filteredCantidad[$index] WHERE ID_Producto=$value;";
                $conn->query($query) or die(mysqli_error($conn));
            }   
        }

        header("Location: admin.php");

    }
    else    // Consult the products that the proveedor suply
    {
        $query= "SELECT ID_Producto FROM Proveedores_Productos WHERE ID_Proveedor=$proveedor_id";
        $result_prod= $conn->query($query);

        $products= [];
        if($result_prod->num_rows > 0)
        {
            while($p= $result_prod->fetch_assoc())
            {
                $products[]= $p;
            }
        }

        echo json_encode($products);
    }
}




?>