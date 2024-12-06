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


$query= "INSERT IGNORE INTO Proveedores (Nombre,Telefono,Calle,Numero_Interior,Numero_Exterior,Estado,Municipio,Codigo_Postal)".
        "VALUES ('".$nombre."',".$telefono.",'".$calle."',".$numInterior.",".$numExterior.",'".$estado."','".$municipio."',".$codigoPostal.");";

$conn->query($query);

// Get back to admin screen
header("Location: admin.php");

$conn->close();
?>