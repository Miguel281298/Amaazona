<?php
session_start();
include('conexion.php'); // Incluir la conexión a la base de datos

// Verificar si el usuario está autenticado
if (!isset($_SESSION['ID_Usuario'])) {
    echo "No estás autenticado. Por favor, inicia sesión.";
    exit;
}

// Obtener los datos enviados por AJAX
$id_producto = $_POST['id_producto'];
$cantidad = $_POST['cantidad'];
$id_usuario = $_SESSION['ID_Usuario'];

// Verificar si el producto ya está en el carrito
$sql_check = "SELECT * FROM Carrito_Compra WHERE ID_Producto = ? AND ID_Usuario = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("ii", $id_producto, $id_usuario);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows > 0) {
    // Si el producto ya está en el carrito, actualizar la cantidad
    $sql_update = "UPDATE Carrito_Compra SET Cantidad = Cantidad + ? WHERE ID_Producto = ? AND ID_Usuario = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("iii", $cantidad, $id_producto, $id_usuario);
    $stmt_update->execute();
    echo "Producto actualizado en el carrito";
} else {
    // Si el producto no está en el carrito, agregarlo
    $sql_insert = "INSERT INTO Carrito_Compra (ID_Producto, ID_Usuario, Cantidad) VALUES (?, ?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("iii", $id_producto, $id_usuario, $cantidad);
    $stmt_insert->execute();
    echo "Producto agregado al carrito";
}

$stmt_check->close();
$stmt_insert->close();
$stmt_update->close();
$conn->close();
?>
