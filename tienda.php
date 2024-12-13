<?php
session_start();

// Si el usuario no ha iniciado sesión, redirigir al login
if (!isset($_SESSION['nombre'])) {
    header("Location: index_login.php");
    exit();
}

$nombre_usuario = $_SESSION['nombre'] . " " . $_SESSION['apellido'];

if (isset($_GET['categoria'])) {
    $id_categoria = $_GET['categoria'];
    $id_categoria = filter_var($id_categoria, FILTER_VALIDATE_INT); // Sanitizar los datos
}


include 'conexion.php'; // Incluye tu conexión a la base de datos
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amaazona</title>
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="fonts/icomoon/style.css">
    <link rel="stylesheet" href="css/tienda.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/swiper.css">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a href="tienda.php" class="navbar-brand" style="padding-left: 20px">
                    <img src="img/amaazona.png" alt="Bootstrap" width="100" height="30">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link">
                                <img src="img/user.png" alt="Bootstrap" width="28" height="28">
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <?php echo $nombre_usuario; ?>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="perfil.php">Mi perfil</a></li>
                                <li><a class="dropdown-item" href="ventas.php">Mis compras</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="logout.php">Cerrar sesión</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="tienda.php">Tienda</a>
                        </li>
                    </ul>
                    <form class="d-flex" role="search">
                        <a href="carrito.php"><img src="img/cart.png" alt="Bootstrap" width="23" height="23" style="margin-top: 1vh; margin-right:2vh"></a>
                        <input class="form-control me-2" type="search" placeholder="Necesito..." aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Buscar</button>
                    </form>
                </div>
            </div>
        </nav>
    </header>

    <!-- Carrusel de categorías -->
    <div class="container">
        <div class="slide-container">
            <div class="card-wrapper swiper-wrapper">
                <?php
                $sql = "SELECT * FROM Categorias";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($categoria = $result->fetch_assoc()) {
                        echo '<div class="card swiper-slide">';
                        echo '<div class="image-box">';
                        echo '<a href="tienda.php?categoria=' . $categoria['ID_Categoria'] . '"><img src="img/categorias/' . $categoria['ID_Categoria'] . '.jpg" alt=""></a>';
                        echo '</div>';
                        echo '<h3 class="name-category">' . $categoria['Nombre'] . '</h3>';
                        echo '</div>';
                    }
                } else {
                    echo "No hay categorias disponibles.";
                }
                ?>
            </div>
        </div>
        <div class="movimiento">
            <div class="swiper-button-prev swiper-navBtn"></div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-next swiper-navBtn"></div>
        </div>
    </div>

    <!-- Productos aleatorios -->
    <div class="container">
        <main class="contenedor">
            <div class="grid">
                <?php

                if (isset($id_categoria) and $id_categoria > 0) {
                    $sql = "SELECT * FROM Productos JOIN Categorias_Productos ON Productos.ID_Producto = Categorias_Productos.ID_Producto
                    WHERE Categorias_Productos.ID_Categoria = $id_categoria";
                } else {
                    $sql = "SELECT * FROM Productos ORDER BY RAND()";
                }
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="producto">';
                        echo '<a href="producto.php?id=' . $row['ID_Producto'] . '" class="producto__link">';
                        echo '<div class="producto__imagen">';
                        echo '<img src="img/productos/' . $row['ID_Producto'] . ".png" . '" alt="' . $row['Nombre'] . '" style="width: 100%; height: auto;">';
                        echo '</div>';
                        echo '<div class="producto__informacion" style="text-align: center;">';
                        echo '<p class="producto__nombre">' . $row['Nombre'] . '</p>';
                        echo '<p class="producto__precio">$' . $row['Precio'] . '</p>';
                        echo '<p class="producto__envio"><span class="icon-rayo">⚡</span> Envío rápido</p>';
                        echo '</div>';
                        echo '</a>';

                        // Controles de cantidad y botón de añadir al carrito
                        echo '<div class="producto__cantidad">';
                        echo '<button class="btn btn-outline-secondary btn-sm decrease" onclick="adjustQuantity(this, -1, ' . $row['ID_Producto'] . ',' . $row['Stock'] . ')">-</button>';
                        echo '<input type="number" class="cantidad-input" value="1" min="1" style="width: 75px; text-align: center; margin: auto 5px" readonly>';
                        echo '<button class="btn btn-outline-secondary btn-sm increase" onclick="adjustQuantity(this, 1, ' . $row['ID_Producto'] . ', ' . $row['Stock'] . ')">+</button>';
                        echo '</div>';
                        echo '<button class="btn btn-primary add-to-cart" onclick="addToCart(' . $row['ID_Producto'] . ', this)">Añadir al carrito</button>';
                        echo '<div class="added-to-cart" style="display: none; color: green; margin-top: 5px;">✓ Añadido</div>';
                        echo '</div>';
                    }
                } else {
                    echo "No hay productos disponibles.";
                }

                $conn->close();
                ?>
            </div>
        </main>
    </div>

    <footer class="footer-16371">
        <div class="row justify-content-center">
            <div class="col-md-9 text-center">
                <div class="footer-site-logo mb-4">
                    <a href="#"><img src="img/logo.png" alt="Bootstrap" width="130" height="130"></a>
                </div>
                <ul class="list-unstyled nav-links mb-5">
                    <li><a href="#">Sobre nosotros</a></li>
                    <li><a href="#">Servicios</a></li>
                    <li><a href="#">Ubicación</a></li>
                    <li><a href="#">Contacto</a></li>
                    <li><a href="#">Legal</a></li>
                </ul>

                <div class="social mb-4">
                    <h3>Contáctanos</h3>
                    <ul class="list-unstyled">
                        <li class="in"><a href="#"><span class="icon-instagram"></span></a></li>
                        <li class="fb"><a href="#"><span class="icon-facebook"></span></a></li>
                        <li class="tw"><a href="#"><span class="icon-twitter"></span></a></li>
                        <li class="pin"><a href="#"><span class="icon-google"></span></a></li>
                        <li class="dr"><a href="#"><span class="icon-whatsapp"></span></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <script>
        function addToCart(id_producto, button) {
            // Obtener la cantidad seleccionada
            var cantidad = button.closest('.producto').querySelector('.cantidad-input').value;

            // Crear la solicitud AJAX
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "agregar_carrito.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            // Enviar los datos a PHP
            xhr.send("id_producto=" + id_producto + "&cantidad=" + cantidad);

            // Manejar la respuesta
            xhr.onload = function() {
                if (xhr.status == 200 || xhr.status == 500) {
                    // Mostrar el mensaje de éxito como un alert
                    alert(xhr.responseText); // Mostrar el mensaje de éxito que se envía desde PHP
                } else {
                    console.log(xhr.status);
                    alert("Hubo un error al agregar el producto al carrito.");
                }
            };
        }

        function adjustQuantity(button, amount, productId, stock) {
            let quantityInput = button.parentElement.querySelector('.cantidad-input');
            let quantity = parseInt(quantityInput.value) + amount;
            quantity = Math.min(Math.max(1, quantity), stock); // Limita entre 1 y stock
            quantityInput.value = quantity;
        }
    </script>
    <script src="js/swiper.js"></script>
    <script src="js/script.js"></script>

</body>

</html>