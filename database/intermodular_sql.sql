-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-05-2025 a las 19:50:20
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `intermodular`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `actualizar_stock` (IN `producto_id` INT, IN `cantidad_comprada` INT)   BEGIN
    UPDATE productos SET stock = stock - cantidad_comprada WHERE id = producto_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `agregar_instrumental` (IN `i_titulo` VARCHAR(100), IN `i_bpm` INT)   BEGIN
	INSERT INTO instrumentales(titulo, bpm)
    VALUES(i_titulo, i_bpm);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `agregar_producto` (IN `nombre` VARCHAR(255), IN `precio` DECIMAL(10,2), IN `stock` INT)   BEGIN
    INSERT INTO productos (nombre, precio, stock) VALUES (nombre, precio, stock);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `agregar_usuario` (IN `u_nombre` VARCHAR(255), IN `u_correo` VARCHAR(100), IN `u_telefono` INT, IN `u_contrasenya` VARCHAR(255))   BEGIN
	INSERT INTO usuarios (Nombre, correo, telefono, contrasenya)
    VALUES (u_nombre, u_correo, u_telefono, u_contrasenya);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `eliminar_producto_sin_ventas` (IN `producto_id` INT)   BEGIN
    IF NOT EXISTS (SELECT 1 FROM pedidos_productos WHERE producto_id = producto_id) THEN
        DELETE FROM productos WHERE id = producto_id;
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `pedidos_cliente` (IN `cliente_id` INT)   BEGIN
    SELECT * FROM pedidos WHERE cliente_id = cliente_id;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `productos_bajo_stock` ()   BEGIN
    SELECT * FROM productos WHERE stock < 5;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `registrar_cliente` (IN `nombre` VARCHAR(255), IN `correo` VARCHAR(255), IN `direccion` TEXT)   BEGIN
    INSERT INTO clientes (nombre, correo, direccion) VALUES (nombre, correo, direccion);
END$$

--
-- Funciones
--
CREATE DEFINER=`root`@`localhost` FUNCTION `calcular_total_pedido` (`pedido_id` INT) RETURNS DECIMAL(10,2) DETERMINISTIC BEGIN
    DECLARE total DECIMAL(10,2);
    SELECT SUM(p.cantidad * prod.precio) INTO total
    FROM pedidos_productos p
    JOIN productos prod ON p.producto_id = prod.id
    WHERE p.pedido_id = pedido_id;
    RETURN IFNULL(total, 0);
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `cliente_existe` (`email` VARCHAR(255)) RETURNS TINYINT(1) DETERMINISTIC BEGIN
    DECLARE existe BOOLEAN;
    SELECT COUNT(*) > 0 INTO existe FROM clientes WHERE correo = email;
    RETURN existe;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `producto_mas_vendido` () RETURNS VARCHAR(255) CHARSET utf8mb4 COLLATE utf8mb4_general_ci DETERMINISTIC BEGIN
    DECLARE prod_nombre VARCHAR(255);
    SELECT p.nombre INTO prod_nombre
    FROM productos p
    JOIN pedidos_productos pp ON p.id = pp.producto_id
    GROUP BY p.id
    ORDER BY SUM(pp.cantidad) DESC
    LIMIT 1;
    RETURN prod_nombre;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `total_ventas_producto` (`producto_id` INT) RETURNS DECIMAL(10,2) DETERMINISTIC BEGIN
    DECLARE total DECIMAL(10,2);
    SELECT SUM(p.cantidad * prod.precio) INTO total
    FROM pedidos_productos p
    JOIN productos prod ON p.producto_id = prod.id
    WHERE p.producto_id = producto_id;
    RETURN IFNULL(total, 0);
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoría`
--

CREATE TABLE `categoría` (
  `ID` int(11) NOT NULL,
  `Nombre_Categoría` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `ID` int(11) NOT NULL,
  `ÚltimaCompra` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `ID` int(11) NOT NULL,
  `ID_Cliente` int(11) DEFAULT NULL,
  `FechaTransacción` date DEFAULT NULL,
  `CantidadTotal` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contacto`
--

CREATE TABLE `contacto` (
  `email` varchar(100) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `mensaje` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `contacto`
--

INSERT INTO `contacto` (`email`, `nombre`, `mensaje`) VALUES
('ico440829@gmail.com', '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `descargar`
--

CREATE TABLE `descargar` (
  `ID_Usuario` int(11) NOT NULL,
  `ID_Instrumental` int(11) NOT NULL,
  `Fecha_Descarga` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ganar`
--

CREATE TABLE `ganar` (
  `ID_Premio` int(11) NOT NULL,
  `ID_Instrumental` int(11) DEFAULT NULL,
  `ID_Categoría` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `genero_musical`
--

CREATE TABLE `genero_musical` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `genero_musical`
--

INSERT INTO `genero_musical` (`id`, `nombre`) VALUES
(1, 'Hip-Hop'),
(2, 'Trap'),
(3, 'Reggaeton'),
(4, 'Lo-Fi'),
(5, 'Drill'),
(6, 'Synthwave'),
(7, 'RnB'),
(8, 'Tech House'),
(9, 'Afrobeat'),
(10, 'Boom Bap');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `instrumentales`
--

CREATE TABLE `instrumentales` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) DEFAULT NULL,
  `bpm` int(11) DEFAULT NULL,
  `fecha_creacion` date DEFAULT NULL,
  `id_productor` int(11) DEFAULT NULL,
  `imagen` text NOT NULL,
  `audio` text DEFAULT NULL,
  `precio` decimal(4,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `instrumentales`
--

INSERT INTO `instrumentales` (`id`, `titulo`, `bpm`, `fecha_creacion`, `id_productor`, `imagen`, `audio`, `precio`) VALUES
(15, 'Cailé', 128, '2025-02-06', 3, 'uploads/imagen5beat.jpg', NULL, 20.99),
(18, 'Retro\'s', 145, '2025-02-11', 1, 'uploads/imagen4beat.jpg', NULL, 14.99),
(20, 'Bulletproof', 145, '2025-02-13', 1, 'uploads/imagen2beat.jpg', NULL, 9.99),
(22, 'Miami', 160, '2025-02-13', 10, 'uploads/imagen1beat.jpg', NULL, 40.00),
(24, 'No Mercy', 140, '2025-02-13', 3, 'uploads/imagen8beat.jpg', NULL, 6.99),
(25, 'Dákiti', 180, '2025-02-13', 11, 'uploads/imagen9beat.jpg', NULL, 1.98),
(26, 'Feroz', 80, '2025-02-24', 11, 'uploads/imagen10beat.jpg', NULL, 19.99),
(27, 'Fuera de Comfort', 94, '2025-02-25', 1, 'uploads/imagen11beat.jpg', 'audiouploads/FueraDeComfort.mp3', 14.99);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `licencia`
--

CREATE TABLE `licencia` (
  `ID` int(11) NOT NULL,
  `Nombre` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `licencia_de_pago`
--

CREATE TABLE `licencia_de_pago` (
  `ID` int(11) NOT NULL,
  `Precio` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `licencia_gratuita`
--

CREATE TABLE `licencia_gratuita` (
  `ID` int(11) NOT NULL,
  `Duración_Prueba` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pertenecer`
--

CREATE TABLE `pertenecer` (
  `id_instrumental` int(11) NOT NULL,
  `id_genero` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pertenecer`
--

INSERT INTO `pertenecer` (`id_instrumental`, `id_genero`) VALUES
(15, 5),
(18, 4),
(20, 2),
(22, 2),
(24, 5),
(25, 3),
(26, 3),
(27, 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `premios`
--

CREATE TABLE `premios` (
  `ID` int(11) NOT NULL,
  `Nombre` varchar(255) DEFAULT NULL,
  `Fecha_Premio` date DEFAULT NULL,
  `ID_Categoría` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productores`
--

CREATE TABLE `productores` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productores`
--

INSERT INTO `productores` (`id`, `nombre`) VALUES
(1, 'Jxice'),
(2, 'Metro Boomin'),
(3, 'D.A Got That Dope'),
(11, 'Tainy');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productores_colaboran`
--

CREATE TABLE `productores_colaboran` (
  `ID_Productor1` int(11) NOT NULL,
  `ID_Productor2` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recibo`
--

CREATE TABLE `recibo` (
  `ID` int(11) NOT NULL,
  `ID_Compra` int(11) DEFAULT NULL,
  `FechaGeneración` date DEFAULT NULL,
  `Descripción` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `seguir`
--

CREATE TABLE `seguir` (
  `ID_Usuario1` int(11) NOT NULL,
  `ID_Usuario2` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tener`
--

CREATE TABLE `tener` (
  `ID_Instrumental` int(11) NOT NULL,
  `ID_Licencia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('admin','user') NOT NULL,
  `fecha_creacion` date DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `email`, `password`, `role`, `fecha_creacion`) VALUES
(1, 'Alejandro Sánchez Ruiz', 'ico440829@gmail.com', '$2y$10$vCl1rs0FXeZcbC7HPI7k3u5GcFhubhmQpFiznDW7jsl', 'admin', '2025-02-25'),
(2, 'Ricardo Reñones Domrachev', 'alexsanchezgradomedio@gmail.com', '$2y$10$wKwVnt3oVnXa7ZMcPhdoGeNsrGZnGhmtaXsdHpeHk1T', 'user', '2025-02-25'),
(10, 'Alejandro', 'prueba1@gmail.com', '$2y$10$aEOkOO2oVbeVz8a1evtWce8ymDCIy.KoqbjnIRdYoc/OGMwRJzJ4K', 'user', '2025-05-15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `valoraciones`
--

CREATE TABLE `valoraciones` (
  `id` int(11) NOT NULL,
  `comentario` text DEFAULT NULL,
  `fecha_valoracion` date DEFAULT current_timestamp(),
  `num_valoracion` int(11) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `valoraciones`
--

INSERT INTO `valoraciones` (`id`, `comentario`, `fecha_valoracion`, `num_valoracion`, `id_usuario`) VALUES
(4, 'Caca', '2025-05-15', 1, 10),
(5, 'Mierdon de pagina', '2025-05-15', 1, 10),
(6, 'aenaerykms', '2025-05-15', 5, 10);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoría`
--
ALTER TABLE `categoría`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_Cliente` (`ID_Cliente`);

--
-- Indices de la tabla `contacto`
--
ALTER TABLE `contacto`
  ADD PRIMARY KEY (`email`);

--
-- Indices de la tabla `descargar`
--
ALTER TABLE `descargar`
  ADD PRIMARY KEY (`ID_Usuario`,`ID_Instrumental`),
  ADD KEY `ID_Instrumental` (`ID_Instrumental`);

--
-- Indices de la tabla `ganar`
--
ALTER TABLE `ganar`
  ADD PRIMARY KEY (`ID_Premio`,`ID_Categoría`),
  ADD KEY `ID_Instrumental` (`ID_Instrumental`),
  ADD KEY `ID_Categoría` (`ID_Categoría`);

--
-- Indices de la tabla `genero_musical`
--
ALTER TABLE `genero_musical`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `instrumentales`
--
ALTER TABLE `instrumentales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ID_Productor` (`id_productor`);

--
-- Indices de la tabla `licencia`
--
ALTER TABLE `licencia`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `licencia_de_pago`
--
ALTER TABLE `licencia_de_pago`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `licencia_gratuita`
--
ALTER TABLE `licencia_gratuita`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `pertenecer`
--
ALTER TABLE `pertenecer`
  ADD PRIMARY KEY (`id_instrumental`,`id_genero`),
  ADD KEY `ID_Genero` (`id_genero`);

--
-- Indices de la tabla `premios`
--
ALTER TABLE `premios`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_Categoría` (`ID_Categoría`);

--
-- Indices de la tabla `productores`
--
ALTER TABLE `productores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productores_colaboran`
--
ALTER TABLE `productores_colaboran`
  ADD PRIMARY KEY (`ID_Productor1`,`ID_Productor2`),
  ADD KEY `ID_Productor2` (`ID_Productor2`);

--
-- Indices de la tabla `recibo`
--
ALTER TABLE `recibo`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_Compra` (`ID_Compra`);

--
-- Indices de la tabla `seguir`
--
ALTER TABLE `seguir`
  ADD PRIMARY KEY (`ID_Usuario1`,`ID_Usuario2`),
  ADD KEY `ID_Usuario2` (`ID_Usuario2`);

--
-- Indices de la tabla `tener`
--
ALTER TABLE `tener`
  ADD PRIMARY KEY (`ID_Instrumental`,`ID_Licencia`),
  ADD KEY `ID_Licencia` (`ID_Licencia`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `valoraciones`
--
ALTER TABLE `valoraciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_valoraciones_usuario` (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoría`
--
ALTER TABLE `categoría`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `genero_musical`
--
ALTER TABLE `genero_musical`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `instrumentales`
--
ALTER TABLE `instrumentales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `licencia`
--
ALTER TABLE `licencia`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `premios`
--
ALTER TABLE `premios`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `productores`
--
ALTER TABLE `productores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `recibo`
--
ALTER TABLE `recibo`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `valoraciones`
--
ALTER TABLE `valoraciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD CONSTRAINT `clientes_ibfk_1` FOREIGN KEY (`ID`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `compras`
--
ALTER TABLE `compras`
  ADD CONSTRAINT `compras_ibfk_1` FOREIGN KEY (`ID_Cliente`) REFERENCES `clientes` (`ID`);

--
-- Filtros para la tabla `descargar`
--
ALTER TABLE `descargar`
  ADD CONSTRAINT `descargar_ibfk_1` FOREIGN KEY (`ID_Usuario`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `descargar_ibfk_2` FOREIGN KEY (`ID_Instrumental`) REFERENCES `instrumentales` (`id`);

--
-- Filtros para la tabla `ganar`
--
ALTER TABLE `ganar`
  ADD CONSTRAINT `ganar_ibfk_1` FOREIGN KEY (`ID_Premio`) REFERENCES `premios` (`ID`),
  ADD CONSTRAINT `ganar_ibfk_2` FOREIGN KEY (`ID_Instrumental`) REFERENCES `instrumentales` (`id`),
  ADD CONSTRAINT `ganar_ibfk_3` FOREIGN KEY (`ID_Categoría`) REFERENCES `categoría` (`ID`);

--
-- Filtros para la tabla `licencia_de_pago`
--
ALTER TABLE `licencia_de_pago`
  ADD CONSTRAINT `licencia_de_pago_ibfk_1` FOREIGN KEY (`ID`) REFERENCES `licencia` (`ID`);

--
-- Filtros para la tabla `licencia_gratuita`
--
ALTER TABLE `licencia_gratuita`
  ADD CONSTRAINT `licencia_gratuita_ibfk_1` FOREIGN KEY (`ID`) REFERENCES `licencia` (`ID`);

--
-- Filtros para la tabla `pertenecer`
--
ALTER TABLE `pertenecer`
  ADD CONSTRAINT `pertenecer_ibfk_1` FOREIGN KEY (`id_instrumental`) REFERENCES `instrumentales` (`id`),
  ADD CONSTRAINT `pertenecer_ibfk_2` FOREIGN KEY (`id_genero`) REFERENCES `genero_musical` (`id`);

--
-- Filtros para la tabla `premios`
--
ALTER TABLE `premios`
  ADD CONSTRAINT `premios_ibfk_1` FOREIGN KEY (`ID_Categoría`) REFERENCES `categoría` (`ID`);

--
-- Filtros para la tabla `productores_colaboran`
--
ALTER TABLE `productores_colaboran`
  ADD CONSTRAINT `productores_colaboran_ibfk_1` FOREIGN KEY (`ID_Productor1`) REFERENCES `productores` (`id`),
  ADD CONSTRAINT `productores_colaboran_ibfk_2` FOREIGN KEY (`ID_Productor2`) REFERENCES `productores` (`id`);

--
-- Filtros para la tabla `recibo`
--
ALTER TABLE `recibo`
  ADD CONSTRAINT `recibo_ibfk_1` FOREIGN KEY (`ID_Compra`) REFERENCES `compras` (`ID`);

--
-- Filtros para la tabla `seguir`
--
ALTER TABLE `seguir`
  ADD CONSTRAINT `seguir_ibfk_1` FOREIGN KEY (`ID_Usuario1`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `seguir_ibfk_2` FOREIGN KEY (`ID_Usuario2`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `tener`
--
ALTER TABLE `tener`
  ADD CONSTRAINT `tener_ibfk_1` FOREIGN KEY (`ID_Instrumental`) REFERENCES `instrumentales` (`id`),
  ADD CONSTRAINT `tener_ibfk_2` FOREIGN KEY (`ID_Licencia`) REFERENCES `licencia` (`ID`);

--
-- Filtros para la tabla `valoraciones`
--
ALTER TABLE `valoraciones`
  ADD CONSTRAINT `fk_valoraciones_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
