<?php
session_start();
include 'conexion.php'; // Asegúrate de que este archivo contiene la conexión a la base de datos

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['ID_Usuario'])) {
    header("Location: index_login.php");
    exit();
}

$usuario_id = $_SESSION['ID_Usuario'];

// Consulta para obtener los productos en el carrito del usuario
$sql = "
    SELECT 
        c.ID_Producto,
        p.Nombre,
        p.Descripcion,
        p.Precio,
        c.Cantidad,
        p.Stock,
        (p.Precio * c.Cantidad) AS Subtotal
    FROM Carrito_Compra c
    JOIN Productos p ON c.ID_Producto = p.ID_Producto
    WHERE c.ID_Usuario = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();

$total = 0;
$articulos = 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de compras</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/carrito.css">
</head>

<body>
    <header>

    </header>

    <div class="card">
        <div class="row">
            <div class="col-md-8 cart">
                <div class="title">
                    <div class="row">
                        <div class="col">
                            <h4><b>Mi Carrito</b></h4>
                        </div>
                    </div>
                </div>

                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="row border-top border-bottom">
                        <div class="row main align-items-center">
                            <div class="col-2">
                                <img class="img-fluid" src="<?= 'img/productos/' . $row['ID_Producto'] . '.png' ?>" alt="<?= $row['Nombre'] ?>">
                            </div>
                            <div class="col">
                                <div class="row text-muted"><?= $row['Nombre'] ?></div>
                            </div>
                            <div class="col">
                                <input type="text" class="cantidad-input border" value="<?= $row['Cantidad'] ?>" readonly>
                                <button onclick="adjustQuantity(this, -1, <?= $row['ID_Producto'] ?>, <?= $row['Stock'] ?>)">-</button>
                                <button onclick="adjustQuantity(this, 1, <?= $row['ID_Producto'] ?>, <?= $row['Stock'] ?>)">+</button>
                            </div>
                            <div class="col">
                                <span><?= number_format($row['Precio'], 2) ?> MXN</span>
                                <span class="subtotal">Subtotal: <?= number_format($row['Subtotal'], 2) ?> MXN</span>
                            </div>
                        </div>
                    </div>
                    <?php
                    $total += $row['Subtotal'];
                    $articulos += $row['Cantidad'];
                    ?>
                <?php endwhile; ?>
            </div>
            <div class="col-md-4 summary">
                <div>
                    <h5><b>TOTAL DE LA COMPRA</b></h5>
                </div>
                <hr>
                <div class="row">
                    <div class="col" style="padding-left:0;">ARTÍCULOS: <span class="articulos"><?= $articulos ?></span></div>

                </div>
                <form>
                    <p>ENVÍO</p>
                    <select id="envio" onchange="updateTotal()">
                        <option value="99">Envío estándar - 99.00 MXN</option>
                        <option value="159">Envío rápido - 159.00 MXN</option>
                    </select>
                    <p>MÉTODO DE PAGO</p>
                    <select>
                        <option class="text-muted">Tarjeta 1</option>
                        <option class="text-muted">Tarjeta 2</option>
                    </select>
                </form>
                <div class="row" style="border-top: 1px solid rgba(0,0,0,.1); padding: 2vh 0;">
                    <div class="col">TOTAL</div>
                    <div class="col text-right total"><?= number_format($total, 2) ?> MXN</div>
                </div>
                <button class="btn">PAGAR</button>
            </div>
        </div>
    </div>

    <footer></footer>

    <script>
        function adjustQuantity(button, amount, productId, stock) {
            let quantityInput = button.parentElement.querySelector('.cantidad-input');
            let quantity = parseInt(quantityInput.value) + amount;
            quantity = Math.min(Math.max(1, quantity), stock); // Limita entre 1 y stock
            quantityInput.value = quantity;

            // Enviar la actualización al servidor
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'update_cart.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        let subtotalElement = button.parentElement.parentElement.querySelector('.subtotal');
                        subtotalElement.innerText = 'Subtotal: ' + response.newSubtotal + ' MXN';
                        updateTotal();
                    } else {
                        alert(response.error);
                    }
                }
            };
            xhr.send(`product_id=${productId}&quantity=${quantity}`);
        }

        function updateTotal() {
            let total = 0;
            let articulos = 0;

            // Suma todos los subtotales
            document.querySelectorAll('.cantidad-input').forEach(function(input) {
                articulos += parseInt(input.value);
            });
            document.querySelectorAll('.subtotal').forEach(function(subtotalElement) {
                let subtotal = parseFloat(subtotalElement.innerText.replace(/[^\d.-]/g, '').trim());

                total += subtotal;
            });

            // Obtiene el costo del envío seleccionado
            const envio = parseFloat(document.getElementById('envio').value);

            // Suma el costo del envío al total
            total += envio;

            // Actualiza los elementos en la página
            document.querySelector('.total').innerText = total.toFixed(2) + ' MXN';
            document.querySelector('.articulos').innerText = articulos;
        }
    </script>
</body>

</html>

<?php
$stmt->close();
$conn->close();
?>