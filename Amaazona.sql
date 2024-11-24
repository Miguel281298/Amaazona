CREATE TABLE `Admin` (
  `Usuario` varchar(255),
  `Password` varchar(255)
);

CREATE TABLE `Usuarios` (
  `ID_Usuario` int AUTO_INCREMENT PRIMARY KEY,
  `Nombre` varchar(255),
  `Apellido` varchar(255),
  `Correo` varchar(255),
  `Password` varchar(255)
);

CREATE TABLE `Productos` (
  `ID_Producto` int AUTO_INCREMENT PRIMARY KEY,
  `Nombre` varchar(255),
  `Descripcion` varchar(255) COMMENT 'Descripcion del producto.',
  `Precio` float,
  `Categoria` varchar(255),
  `Stock` int
);

CREATE TABLE `Categorias` (
  `ID_Categoria` int AUTO_INCREMENT PRIMARY KEY,
  `Nombre` varchar(255)
);

CREATE TABLE `Proveedores` (
  `ID_Proveedor` int AUTO_INCREMENT PRIMARY KEY,
  `Nombre` varchar(255),
  `Telefono` int,
  `Calle` varchar(255),
  `Numero_Interior` int,
  `Numero_Exterior` int,
  `Estado` varchar(255),
  `Municipio` varchar(255),
  `Codigo_Postal` varchar(255)
);

CREATE TABLE `Venta` (
  `ID_Venta` int AUTO_INCREMENT PRIMARY KEY,
  `Total` int,
  `ID_Metodo_Pago` int,
  `ID_Usuario` int,
  `Calle` varchar(255),
  `Num_Interior` int,
  `Num_Exterior` int,
  `Fraccionamiento_Colonia` varchar(255),
  `Codigo_Postal` int,
  `Estado` varchar(255),
  `Municipio` varchar(255),
  `Localidad` varchar(255)
);

CREATE TABLE `Direcciones_Entrega` (
  `ID_Direccion_Entrega` int AUTO_INCREMENT PRIMARY KEY,
  `Calle` varchar(255),
  `Num_Interior` int,
  `Num_Exterior` int,
  `Fraccionamiento_Colonia` varchar(255),
  `Codigo_Postal` int,
  `Estado` varchar(255),
  `Municipio` varchar(255),
  `Localidad` varchar(255),
  `Referencia` varchar(255),
  `ID_Usuario` int
);

CREATE TABLE `Detalle_Venta` (
  `ID_Venta` int,
  `ID_Producto` int,
  `Cantidad` int,
  `Precio` float
);

CREATE TABLE `Carrito_Compra` (
  `ID_Usuario` int,
  `ID_Producto` int,
  `Cantidad` int
);

CREATE TABLE `Categorias_Productos` (
  `ID_Categoria` int,
  `ID_Producto` int
);

CREATE TABLE `Metodos_Pago` (
  `ID_Metodo_Pago` int AUTO_INCREMENT PRIMARY KEY,
  `Numero_Tarjeta` int,
  `Fecha_Vencimiento` date,
  `CVV` int,
  `ID_Usuario` int
);

CREATE TABLE `Compras` (
  `ID_Producto` int,
  `ID_Compras` int,
  `Cantidad` int,
  `Precio` float
);

CREATE TABLE `Detalle_Compras` (
  `ID_Compras` int AUTO_INCREMENT PRIMARY KEY,
  `ID_Proveedor` int,
  `Total` float
);

ALTER TABLE `Venta` ADD FOREIGN KEY (`ID_Usuario`) REFERENCES `Usuarios` (`ID_Usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `Metodos_Pago` ADD FOREIGN KEY (`ID_Usuario`) REFERENCES `Usuarios` (`ID_Usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `Carrito_Compra` ADD FOREIGN KEY (`ID_Usuario`) REFERENCES `Usuarios` (`ID_Usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `Direcciones_Entrega` ADD FOREIGN KEY (`ID_Usuario`) REFERENCES `Usuarios` (`ID_Usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `Carrito_Compra` ADD FOREIGN KEY (`ID_Producto`) REFERENCES `Productos` (`ID_Producto`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `Categorias_Productos` ADD FOREIGN KEY (`ID_Producto`) REFERENCES `Productos` (`ID_Producto`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `Detalle_Venta` ADD FOREIGN KEY (`ID_Producto`) REFERENCES `Productos` (`ID_Producto`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `Compras` ADD FOREIGN KEY (`ID_Producto`) REFERENCES `Productos` (`ID_Producto`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `Venta` ADD FOREIGN KEY (`ID_Metodo_Pago`) REFERENCES `Metodos_Pago` (`ID_Metodo_Pago`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `Detalle_Venta` ADD FOREIGN KEY (`ID_Venta`) REFERENCES `Venta` (`ID_Venta`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `Categorias_Productos` ADD FOREIGN KEY (`ID_Categoria`) REFERENCES `Categorias` (`ID_Categoria`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `Detalle_Compras` ADD FOREIGN KEY (`ID_Proveedor`) REFERENCES `Proveedores` (`ID_Proveedor`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `Compras` ADD FOREIGN KEY (`ID_Compras`) REFERENCES `Detalle_Compras` (`ID_Compras`) ON DELETE CASCADE ON UPDATE CASCADE;
