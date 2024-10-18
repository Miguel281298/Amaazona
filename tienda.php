<?php
session_start();

// Si el usuario no ha iniciado sesión, redirigir al login
if (!isset($_SESSION['nombre'])) {
    header("Location: index_login.php");
    exit();
}

$nombre_usuario = $_SESSION['nombre'] . " " . $_SESSION['apellido'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Amaazona </title>
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/tienda.css">
    <!-- CSS to FOOTER -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="fonts/icomoon/style.css">
    <link rel="stylesheet" href="css/footer.css">
    <!-- Swiper css -->
    <link rel="stylesheet" href="css/swiper.css">
    <!-- NavBar -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid" bis_skin_checked="1">
            <a class="navbar-brand" style="padding-left: 20px">
                <img src="img/amaazona.png" alt="Bootstrap" width="100" height="30">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent" bis_skin_checked="1">
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
                    <h3 class="name-category">Articulos deportivos</h3>
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

                <div class="card swiper-slide">
                    <div class="image-box">
                        <a href="">
                            <img src="img/categorias/1.jpg" alt="">
                        </a>
                    </div>
                    <h3 class="name-category">Papeleria y oficina</h3>
                </div>

                <div class="card swiper-slide">
                    <div class="image-box">
                        <a href="">
                            <img src="img/categorias/2.jpg" alt="">
                        </a>
                    </div>
                    <h3 class="name-category">Bebés y niños</h3>
                </div>

                <div class="card swiper-slide">
                    <div class="image-box">
                        <a href="">
                            <img src="img/categorias/3.jpg" alt="">
                        </a>
                    </div>
                    <h3 class="name-category">Fotografia y video</h3>
                </div>

                <div class="card swiper-slide">
                    <div class="image-box">
                        <a href="">
                            <img src="img/categorias/4.jpg" alt="">
                        </a>
                    </div>
                    <h3 class="name-category">Jardineria</h3>
                </div>
            </div>
        </div>
        <div class="movimiento">
            <div class="swiper-button-prev swiper-navBtn"></div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-next swiper-navBtn"></div>
        </div>
    </div>

    <main class="contenedor">
        <div class="grid">
            <div class="producto">
                <a href="producto.html">
                    <div class="producto__imagen">
                        <img src="img/productos/1.jpg" alt="imagen camisa">
                    </div>
                    <div class="producto__informacion">
                        <p class="producto__nombre" name="producto1"> Redux </p>
                        <p class="producto__precio" name="precio1"> $299 </p>
                    </div>
                </a>
            </div>
            <div class="producto">
                <a href="producto.html">
                    <div class="producto__imagen">
                        <img src="img/productos/2.jpg" alt="imagen camisa">
                    </div>
                    <div class="producto__informacion">
                        <p class="producto__nombre" name="producto2"> React </label>
                        <p class="producto__precio" name="precio2"> $299 </label>
                    </div>
                </a>
            </div>
            <div class="producto">
                <a href="producto.html">
                    <div class="producto__imagen">
                        <img src="img/productos/3.jpg" alt="imagen camisa">
                    </div>
                    <div class="producto__informacion">
                        <p class="producto__nombre" name="producto3"> Drupal </label>
                        <p class="producto__precio" name="precio3"> $299 </label>
                    </div>
                </a>
            </div>
            <div class="producto">
                <a href="producto.html">
                    <div class="producto__imagen">
                        <img src="img/productos/4.jpg" alt="imagen camisa">
                    </div>
                    <div class="producto__informacion">
                        <p class="producto__nombre" name="producto1"> HTML </p>
                        <p class="producto__precio" name="precio1"> $299 </p>
                    </div>
                </a>
            </div>
            <div class="producto">
                <a href="producto.html">
                    <div class="producto__imagen">
                        <img src="img/productos/5.jpg" alt="imagen camisa">
                    </div>
                    <div class="producto__informacion">
                        <p class="producto__nombre" name="producto2"> Github </label>
                        <p class="producto__precio" name="precio2"> $299 </label>
                    </div>
                </a>
            </div>
            <div class="producto">
                <a href="producto.html">
                    <div class="producto__imagen">
                        <img src="img/productos/6.jpg" alt="imagen camisa">
                    </div>
                    <div class="producto__informacion">
                        <p class="producto__nombre" name="producto3"> Bulma </label>
                        <p class="producto__precio" name="precio3"> $299 </label>
                    </div>
                </a>
            </div>
        </div>
    </main>

    <footer class="footer-16371">
          <div class="row justify-content-center">
            <div class="col-md-9 text-center">
              <div class="footer-site-logo mb-4">
                <a>Amaazona</a>
              </div>
              <ul class="list-unstyled nav-links mb-5">
                <li><a href="#">About</a></li>
                <li><a href="#">Services</a></li>
                <li><a href="#">Press</a></li>
                <li><a href="#">Careers</a></li>
                <li><a href="#">FAQ</a></li>
                <li><a href="#">Legal</a></li>
                <li><a href="#">Contact</a></li>
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
              <div class="copyright">
                <p class="mb-0"><small>&copy; Amaazona. All Rights Reserved.</small></p>
              </div>
            </div>
          </div>
      </footer>

    <script src="js/swiper.js"></script>
    <script src="js/script.js"></script>
</body>
</html>