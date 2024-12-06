<?php
include '../conexion.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amaazona</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../fonts/icomoon/style.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="css/admin.css?v=<?php echo time(); ?>">
</head>
<body>

    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a href="tienda.php" class="navbar-brand" style="padding-left: 20px">
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
                                <li><a class="dropdown-item" href="#"> Compras</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="./../logout.php">Cerrar sesión</a></li>
                            </ul>
                        </li>
                    </ul>
                    <ul class="nav nav-pills nav-fill gap-2 p-1 small bg-primary rounded-5 shadow-sm" id="pillNav2" role="tablist" 
                        style="--bs-nav-link-color: var(--bs-white); --bs-nav-pills-link-active-color: var(--bs-primary); --bs-nav-pills-link-active-bg: var(--bs-white);">
                        <li class="nav-item" role="presentation">
                            <button id="show-products" class="nav-link active rounded-5" data-bs-toggle="tab" data-bs-target="#productos_container" 
                                    type="button" role="tab" aria-selected="true">Productos</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button id="show-suppliers" class="nav-link rounded-5" data-bs-toggle="tab" data-bs-target="#proveedores_container" 
                                    type="button" role="tab" aria-selected="false">Proveedores</button>
                        </li>
                    </ul>
                    <!-- <form class="d-flex" role="search">
                        <input class="form-control me-2" type="search" placeholder="Necesito..." aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Buscar</button>
                    </form> -->
                </div>
            </div>
        </nav>
    </header>

    <main class="container mt-3">
        <div class="tab-content">
            <!-- Productos Container -->
            <div id="productos_container" class="tab-pane fade show active" role="tabpanel" aria-labelledby="show-products">
                <div class="section">
                    <h2 class="text-center">Categorías</h2>
                    <!-- PHP: Categorias Content -->
                    <?php
                    $sql = "SELECT * FROM Categorias";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        echo '<div class="categoria" style="margin-left: 70px; font-weight: bold;">';
                        echo '<p>Imagen</p>';
                        echo '<p>Nombre</p>';
                        echo '</div>';
                        while ($categoria = $result->fetch_assoc()) {
                            echo '<div class="categoria">';
                            echo '<img src="../img/categorias/' . $categoria['ID_Categoria'] . '.jpg" alt="">';
                            echo '<p>' . $categoria['Nombre'] . '</p>';
                            echo '<a class="btn btn-primary editar" href="categoria.php?ID=' . $categoria['ID_Categoria'] . '">Editar</a>';
                            echo '<button class="btn btn-danger eliminar">Eliminar</button>';
                            echo '</div>';
                        }
                    } else {
                        echo "No hay categorías disponibles.";
                    }
                    ?>
                    <div class="contenedor">
                        <a href="categoria.php" class="btn btn-success">Añadir Categoría</a>
                    </div>
                </div>
                <!-- Productos Section -->
                <div class="section">
                    <h2 class="text-center">Productos</h2>
                    <?php
                    $sql = "SELECT * FROM Productos";
                    $result = $conn->query($sql);

                    $productos= [];
                    while ($producto = $result->fetch_assoc())
                    {
                        $productos[]= $producto; 
                    }

                    if ($result->num_rows > 0) {
                        echo '<div class="producto" style="margin-left: 70px; font-weight: bold;">';
                        echo '<p>Imagen</p>';
                        echo '<p>Nombre</p>';
                        echo '<p>Precio</p>';
                        echo '<p>Stock</p>';
                        echo '</div>';
                        foreach($productos as $producto) {
                            echo '<div class="producto">';
                            echo '<img src="../img/productos/' . $producto['ID_Producto'] . '.jpg" alt="">';
                            echo '<p>' . $producto['Nombre'] . '</p>';
                            echo '<p> $' . $producto['Precio'] . '</p>';
                            echo '<p>' . $producto['Stock'] . ' Pzas </p>';
                            echo '<a class="btn btn-primary editar" href="producto.php?ID=' . $producto['ID_Producto'] . '">Editar</a>';
                            echo '<button class="btn btn-danger eliminar">Eliminar</button>';
                            echo '</div>';
                        }
                    } else {
                        echo "No hay productos disponibles.";
                    }
                    $conn->close();
                    ?>
                    <div class="contenedor">
                        <a href="producto.php" class="btn btn-success">Añadir Producto</a>
                    </div>
                </div>
            </div>

            <!-- Proveedores Container -->
            <div id="proveedores_container" class="tab-pane fade" role="tabpanel" aria-labelledby="show-suppliers">
                <div class="d-flex flex-column justify-content-center">
                    <h1 class="fs-1 lh-lg text-center">Administración de Proveedores</h1>
                    <!-- Dat de Alta Proveedor Section -->
                    <button class= "btn btn-outline-success mb-3 shadow" data-bs-toggle="collapse" href= "#dar-alta" role= "button" aria-expanded="false" aria-controls="dar-alta">Dar de Alta Proveedor</button>
                    <section id= "dar-alta" class="collapse">
                        <form action= "alta_proveedor.php" method= "POST" class= "align-items-center">
                            <label class= "text-start fs-3 p-1">Ingrese los datos del proveedor</label>
                            <div class="input-group input-group-sm mb-3">
                                <span class="input-group-text">Nombre</span>
                                <input name= "proveedor_name" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                            </div>
                            <div class="input-group input-group-sm mb-3">
                                <span class="input-group-text">Telefono</span>
                                <input name= "proveedor_telefono" type="number" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                            </div>
                            <div class="input-group input-group-sm mb-3">
                                <span class="input-group-text">Calle</span>
                                <input name= "proveedor_calle" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                            </div>
                            <div class="input-group input-group-sm mb-3">
                                <span class="input-group-text">Num. Interior (opc)</span>
                                <input name= "proveedor_numInterior" type="number" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                            </div>
                            <div class="input-group input-group-sm mb-3">
                                <span class="input-group-text">Num. Exterior</span>
                                <input name= "proveedor_numExterior" type="number" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                            </div>
                            <div class="input-group input-group-sm mb-3">
                                <span class="input-group-text">Estado</span>
                                <input name= "proveedor_estado" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                            </div>
                            <div class="input-group input-group-sm mb-3">
                                <span class="input-group-text">Municipio</span>
                                <input name= "proveedor_municipio" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                            </div>
                            <div class="input-group input-group-sm mb-3">
                                <span class="input-group-text">Codigo Postal</span>
                                <input name= "proveedor_codigoPostal" type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm">
                            </div>
                            <div class="text-center">
                                <div id="container-container" class="row row-cols-3">
                                    <div id="select-product" class="col my-2">
                                        <select name="id-products[]" class="form-select" aria-label="Default select example">
                                            <option selected>Producto...</option>
                                            <?php 
                                                foreach($productos as $producto)
                                                {
                                                    echo '<option value="'.$producto["ID_Producto"].'">'.$producto["Nombre"].'</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col my-2">
                                        <button id="add-product-bttn" type="button" class="btn btn-success">Añadir Producto</button>
                                    </div>
                                </div>
                            </div>
                            <button class= "btn btn-primary btn-lg m-2 w-25">Enviar</button>
                        </form>
                    </section>
                    <button class= "btn btn-outline-danger mb-3 shadow" data-bs-toggle="collapse" href= "#agregar-inventario" role= "button" aria-expanded="false" aria-controls="agregar-inventario">Agregar Inventario</button>
                    <section id= "agregar-inventario" class="collapse">
                        <form class= "d-flex flex-column justify-content-center" method= "POST">
                            <label class= "text-start">Ingrese los datos del proveedor.</label>
                            <input type="text" placeholder="Nombre" class="m-1">
                            <input type="number" placeholder="Telefono" class="m-1">
                            <input type="text" placeholder="Calle" class="m-1">
                            <input type="number" placeholder="Num. Interior (opc)" class="m-1">
                            <input type="number" placeholder="Num. Exterior" class="m-1">
                            <input type="text" placeholder="Estado" class="m-1">
                            <input type="text" placeholder="Municipio" class="m-1">
                            <input type="number" placeholder="Codigo Postal" class="m-1">
                            <button class= "btn btn-outline-primary m-2">Enviar</button>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </main>
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
    <script src="js/admin.js"></script>
</body>
</html>