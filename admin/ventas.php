<?php
include '../conexion.php';

header("Cache-Control: no-cache, must-revalidate"); // HTTP 1.1
header("Pragma: no-cache"); // HTTP 1.0
header("Expires: 0"); // Proxies

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compras</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../css/carrito.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../fonts/icomoon/style.css">
    <link rel="stylesheet" href="../css/footer.css">

</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a href="admin.php" class="navbar-brand" style="padding-left: 20px">
                    <img src="../img/amaazona.png" alt="Bootstrap" width="100" height="30">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link">
                                <img src="../img/user.png" alt="Bootstrap" width="28" height="28">
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Administrador
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="compras.php">Mis Compras</a></li>
                                <li><a class="dropdown-item" href="ventas.php">Mis Ventas</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="../logout.php">Cerrar sesión</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <?php
    $sql = "SELECT * FROM Venta";
    $result = $conn->query($sql);

    if ($result->num_rows > 0):
        while ($venta = $result->fetch_assoc()): ?>
            <?php
            $id_usuario = $venta['ID_Usuario'];
            $query = "SELECT * FROM Usuarios WHERE ID_Usuario = $id_usuario";
            $nombre = $conn->query($query);
            $nombre = $nombre->fetch_assoc();
            ?>
            <div class="card" style="padding: 20px 0;">
                <div class="row" style="margin: 0 30px;">
                    <div class="title">
                        <div class="row">
                            <div class="col">
                                <h4><b>Usuario: <?php echo $nombre['Nombre'] ?> </b></h4>
                            </div>
                        </div>
                    </div>

                    <?php
                    $total = 0;
                    $id_venta = $venta['ID_Venta'];
                    $sql2 = "SELECT * FROM Detalle_Venta WHERE ID_Venta = $id_venta";
                    $result2 = $conn->query($sql2);
                    ?>

                    <div class="titulos">
                        <label>Imagen</label>
                        <label>Nombre</label>
                        <label>Cantidad</label>
                        <label>Precio</label>
                        <label>Subtotal</label>
                    </div>

                    <?php
                    while ($row = $result2->fetch_assoc()):
                        $id_producto = $row['ID_Producto'];
                        $cantidad = $row['Cantidad'];
                        $precio = $row['Precio']; ?>
                        <div class="row border-top border-bottom">
                            <div class="row main align-items-center">
                                <div class="col-2">
                                    <img class="img-fluid" src="<?= '../img/productos/' . $id_producto . '.png' ?>">
                                </div>
                                <div class="col">
                                    <?php $sql3 = "SELECT Nombre FROM Productos WHERE ID_Producto = $id_producto";
                                    $result3 = $conn->query($sql3);
                                    $result3 = $result3->fetch_assoc();
                                    ?>
                                    <div class="row text-muted nombre"><?= $result3['Nombre'] ?></div>
                                </div>
                                <div class="col" style="text-align: center;">
                                    <label style="text-align: center;" class="cantidad-input cant_prod"> <?= $cantidad ?></label>
                                </div>
                                <div class="col" style="font-weight: bold;">
                                    <span><?= $precio ?> MXN</span>
                                </div>
                                <div class="col" style="font-weight: bold;">
                                    <span>$ <?= $precio * $cantidad ?> MXN</span>
                                </div>
                            </div>
                        </div>
                        <?php
                        $total += $cantidad * $precio;
                        ?>
                    <?php endwhile; ?>
                    <label class="total"> TOTAL: $ <?php echo $total; ?></label>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No hay compras</p>
    <?php endif; ?>

    <footer class="footer-16371">
        <div class="row justify-content-center">
            <div class="col-md-9 text-center">
                <div class="footer-site-logo mb-4">
                    <a href="#"><img src="../img/logo.png" alt="Bootstrap" width="130" height="130"></a>
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

</body>

</html>

<?php
$stmt->close();
$conn->close();
?>