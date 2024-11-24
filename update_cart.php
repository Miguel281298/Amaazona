<?php
session_start();
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario_id = $_SESSION['ID_Usuario'];
    $product_id = intval($_POST['product_id']);
    $quantity = intval($_POST['quantity']);

    if ($quantity > 0) {
        $sql = "UPDATE Carrito_Compra SET Cantidad = ? WHERE ID_Usuario = ? AND ID_Producto = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iii", $quantity, $usuario_id, $product_id);
        $stmt->execute();

        $sql = "
            SELECT (p.Precio * c.Cantidad) AS Subtotal
            FROM Carrito_Compra c
            JOIN Productos p ON c.ID_Producto = p.ID_Producto
            WHERE c.ID_Usuario = ? AND c.ID_Producto = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $usuario_id, $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        echo json_encode(['success' => true, 'newSubtotal' => number_format($row['Subtotal'], 2)]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Cantidad inválida.']);
    }
}
$conn->close();
?>
