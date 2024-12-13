<?php
session_start();
include 'conexion.php';
if (!isset($_SESSION['ID_Usuario'])) {
    header("Location: index_login.php");
    exit();
}
$usuario_id = $_SESSION['ID_Usuario'];

$sql = "SELECT * FROM Carrito_Compra WHERE ID_Usuario = $usuario_id";
$result = $conn->query($sql);
if ($result->num_rows == 0) {
    header("Location: carrito.php");
    exit();
}
while ($row = $result->fetch_assoc()) {
    $productos[] = $row['ID_Producto'];
    $cantidades[] = $row['Cantidad'];
}

foreach ($productos as $index => $value) {
    $sql = "SELECT * FROM Productos WHERE ID_Producto = $value";
    $result = $conn->query($sql);
    $producto = $result->fetch_assoc();
    $stock = $producto['Stock'];
    $precios[$index] = $producto['Precio'];
    if ($stock < $cantidades[$index]) {
        echo '<script> alert("No hay stock suficiente para alguno de los productos"); window.location.href = "carrito.php"; </script>';
        exit();
    }
    $sql = $stock == $cantidades[$index] ?
    "DELETE FROM Productos WHERE ID_Producto = $value" :
    "UPDATE Productos SET Stock = $stock - $cantidades[$index] WHERE ID_Producto = $value";
    $conn->query($sql);
}

$total = $_POST['total'];
$metodo_pago = $_POST['metodo_pago'];
$direccion = $_POST['direccion'];

$sql = "SELECT * FROM Direcciones_Entrega WHERE ID_Direccion_Entrega = $direccion";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $direccion = $result->fetch_assoc();
    $calle = $direccion['Calle'];
    $numeroInterior = $direccion['Num_Interior'];
    $numeroExterior = $direccion['Num_Exterior'];
    $fracc = $direccion['Fraccionamiento_Colonia'];
    $codigoPostal = $direccion['Codigo_Postal'];
    $estado = $direccion['Estado'];
    $municipio = $direccion['Municipio'];
    $localidad = $direccion['Localidad'];
}


$sql = "INSERT INTO Venta (Total, ID_Metodo_Pago, ID_Usuario, Calle, Num_Interior, Num_Exterior, Fraccionamiento_Colonia, Codigo_Postal, Estado, Municipio, Localidad) VALUES ($total, $metodo_pago, $usuario_id, '$calle'," . ($numeroInterior ? "'$numeroInterior'" : "NULL") . ", '$numeroExterior', '$fracc', '$codigoPostal', '$estado', '$municipio', '$localidad');";
$conn->query($sql);
$venta_id = $conn->insert_id;

foreach ($productos as $index => $value) {
    $sql = "INSERT INTO Detalle_Venta (ID_Venta, ID_Producto, Cantidad, Precio) VALUES ($venta_id, $value, $cantidades[$index], $precios[$index]);";
    $conn->query($sql);
}

$sql = "DELETE FROM Carrito_Compra WHERE ID_Usuario = $usuario_id";
$conn->query($sql);

echo '<script> alert("Compra realizada con exito");</script>';
echo '<script> window.location.href = "ventas.php";</script>';
?>