<?php
session_start();

// Si el usuario no ha iniciado sesión, redirigir al login
if (!isset($_SESSION['nombre'])) {
    header("Location: index_login.php");
    exit();
}

$nombre_usuario = $_SESSION['nombre'] . " " . $_SESSION['apellido'];

include 'conexion.php'; // Incluye tu conexión a la base de datos
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amaazona</title>
    <link rel="stylesheet" href="css/tienda.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="fonts/icomoon/style.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/swiper.css">
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" style="padding-left: 20px">
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
                                <li><a class="dropdown-item" href="#">Mi perfil</a></li>
                                <li><a class="dropdown-item" href="#">Mis compras</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="logout.php">Cerrar sesión</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Tienda</a>
                        </li>
                    </ul>
                    <form class="d-flex" role="search">
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
                <div class="card swiper-slide">
                    <div class="image-box">
                        <a href="">
                            <img src="img/categorias/1.jpg" alt="">
                        </a>
                    </div>
                    <h3 class="name-category">Ropa</h3>
                </div>
                <div class="card swiper-slide">
                    <div class="image-box">
                        <a href="">
                            <img src="img/categorias/2.jpg" alt="">
                        </a>
                    </div>
                    <h3 class="name-category">Artículos deportivos</h3>
                </div>
                <div class="card swiper-slide">
                    <div class="image-box">
                        <a href="">
                            <img src="img/categorias/3.jpg" alt="">
                        </a>
                    </div>
                    <h3 class="name-category">Hogar</h3>
                </div>
                <div class="card swiper-slide">
                    <div class="image-box">
                        <a href="">
                            <img src="img/categorias/4.jpg" alt="">
                        </a>
                    </div>
                    <h3 class="name-category">Electrónica</h3>
                </div>
                <div class="card swiper-slide">
                    <div class="image-box">
                        <a href="">
                            <img src="img/categorias/5.jpg" alt="">
                        </a>
                    </div>
                    <h3 class="name-category">Juguetes</h3>
                </div>
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
                $sql = "SELECT * FROM productos ORDER BY RAND() LIMIT 12"; 
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo '<div class="producto">';
                        echo '<a href="producto.php?id=' . $row['ID_producto'] . '" class="producto__link">';
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

    <script src="js/swiper.js"></script>
    <script src="js/script.js"></script>
</body>
</html>
