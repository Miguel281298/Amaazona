<?php
include 'conexion.php'; // Incluye tu conexión a la base de datos

$sql = "SELECT * FROM productos ORDER BY RAND() LIMIT 6"; // Cambia el número según cuántos productos quieras mostrar
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Salida de cada fila
    while($row = $result->fetch_assoc()) {
        echo '<div class="producto">';
        echo '<a href="producto.php?id=' . $row['ID_producto'] . '">';
        echo '<div class="producto__imagen">';
        echo '<img src="productos/' . $row['nombre_imagen'] . '" alt="' . $row['nombre'] . '">';
        echo '</div>';
        echo '<div class="producto__informacion">';
        echo '<p class="producto__nombre">' . $row['nombre'] . '</p>';
        echo '<p class="producto__precio">$' . $row['precio'] . '</p>';
        echo '<p class="producto__envio"><span class="icon-rayo">⚡</span> Envío rápido</p>';
        echo '</div>';
        echo '</a>';
        echo '</div>';
    }
} else {
    echo "No hay productos disponibles.";
}

$conn->close(); // Cierra la conexión
?>
