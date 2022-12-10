-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-12-2022 a las 03:42:45
-- Versión del servidor: 10.4.25-MariaDB
-- Versión de PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `proyecto_db`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_actualizar_producto` (IN `param1` INT, IN `param2` VARCHAR(50), IN `param3` VARCHAR(25), IN `param4` VARCHAR(15), IN `param5` DECIMAL(8,2), IN `param6` INT)   BEGIN
	UPDATE productos SET productos.nombre = param2, productos.numero_producto = param3, productos.color = param4, productos.precio_unitario = param5 WHERE productos.id = param1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_eliminar_orden` (IN `param1` INT)   BEGIN
	DELETE FROM ordenes WHERE ordenes.id = param1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_eliminar_producto` (IN `param1` INT)   BEGIN
	DELETE FROM productos WHERE productos.id = param1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_eliminar_usuario` (IN `param1` INT)   BEGIN
	DELETE FROM usuario WHERE usuario.id = param1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_listar_orden` (IN `param1` INT)   BEGIN
	SELECT ordenes.id, productos.nombre, ordenes.cliente, ordenes.cantidad, ordenes.precio, ordenes.itbms, ordenes.precio_total FROM ordenes INNER JOIN productos ON productos.id = ordenes.id_producto WHERE ordenes.id = param1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_listar_ordenes` ()   BEGIN
	SELECT * FROM ordenes;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_listar_productos` ()   BEGIN
	SELECT * FROM productos;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_loguear_usuario` (IN `param1` VARCHAR(50), IN `param2` VARCHAR(50))   BEGIN
	IF(SELECT usuario.id FROM usuario WHERE usuario.nombre = param1 AND usuario.contrasena = param2) THEN
		UPDATE usuario SET usuario.ultima_sesion = CURRENT_TIMESTAMP() WHERE usuario.nombre = param1;
        SELECT * FROM usuario WHERE usuario.nombre = param1;
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_registrar_orden` (IN `param1` INT, IN `param2` VARCHAR(50), IN `param3` INT, IN `param4` DECIMAL(8,2), IN `param5` DECIMAL(8,2), IN `param6` DECIMAL(8,2))   BEGIN
IF((SELECT productos.cantidad_inventario FROM productos WHERE productos.id = param1)>0) THEN
	INSERT INTO ordenes(ordenes.id_producto, ordenes.cliente, ordenes.cantidad, ordenes.precio, ordenes.itbms, ordenes.precio_total)
    VALUES(param1, param2, param3, param4, param5, param6);
    UPDATE productos SET productos.cantidad_inventario = productos.cantidad_inventario - param3 WHERE productos.id = param1;
END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_registrar_producto` (IN `param1` VARCHAR(50), IN `param2` VARCHAR(25), IN `param3` VARCHAR(15), IN `param4` DECIMAL(8,2), IN `param5` INT)   BEGIN
	INSERT INTO productos(nombre, numero_producto, color, precio_unitario, cantidad_inventario)
    VALUES(param1, param2, param3, param4, param5);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_registrar_usuario` (IN `param1` VARCHAR(50), IN `param2` VARCHAR(50), IN `param3` VARCHAR(150))   BEGIN
	INSERT INTO usuario(usuario.nombre, usuario.contrasena, usuario.tipo)
    VALUES(param1, param2, param3);
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ordenes`
--

CREATE TABLE `ordenes` (
  `id` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cliente` varchar(50) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio` decimal(8,2) NOT NULL,
  `itbms` decimal(8,2) DEFAULT NULL,
  `precio_total` decimal(8,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `ordenes`
--

INSERT INTO `ordenes` (`id`, `id_producto`, `cliente`, `cantidad`, `precio`, `itbms`, `precio_total`, `created_at`, `updated_at`) VALUES
(1, 1, 'Manuel Jimenez', 1, '1431.50', '0.00', '1431.50', '2022-12-10 02:15:17', '2022-12-10 02:15:17');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `numero_producto` varchar(25) DEFAULT NULL,
  `color` varchar(15) DEFAULT NULL,
  `precio_unitario` decimal(8,2) DEFAULT NULL,
  `cantidad_inventario` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `numero_producto`, `color`, `precio_unitario`, `cantidad_inventario`, `created_at`, `updated_at`) VALUES
(1, 'HL Road Frame - Black, 58', 'FR-R92B-58', 'Black', '1431.50', 9, '2022-12-09 03:14:45', '2022-12-10 02:15:17'),
(2, 'Sport-100 Helmet, Black', 'HL-U508', 'Black', '34.99', 49, '2022-12-10 01:23:40', '2022-12-10 02:15:17');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `contrasena` varchar(50) NOT NULL,
  `tipo` varchar(150) NOT NULL,
  `ultima_sesion` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `nombre`, `contrasena`, `tipo`, `ultima_sesion`, `created_at`, `updated_at`) VALUES
(1, 'lueunbii98', 'P@ssword12345', 'user', '2022-12-10 01:01:37', '2022-12-10 00:41:00', '2022-12-10 01:01:37');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `ordenes`
--
ALTER TABLE `ordenes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `ordenes`
--
ALTER TABLE `ordenes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
