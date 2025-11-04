-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 04-11-2025 a las 05:28:53
-- Versión del servidor: 11.4.8-MariaDB-ubu2404
-- Versión de PHP: 8.3.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `josemanuelsantamargarita_practica_final_php`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Categorias`
--

CREATE TABLE `Categorias` (
  `indice_cat` int(3) NOT NULL,
  `nombre_cat` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Volcado de datos para la tabla `Categorias`
--

INSERT INTO `Categorias` (`indice_cat`, `nombre_cat`) VALUES
(1, 'Pádel'),
(2, 'Tenis');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Clientes`
--

CREATE TABLE `Clientes` (
  `Cod_cliente` int(3) NOT NULL,
  `Nombre` varchar(50) NOT NULL,
  `Apellidos` varchar(50) NOT NULL,
  `Telefono` int(9) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Volcado de datos para la tabla `Clientes`
--

INSERT INTO `Clientes` (`Cod_cliente`, `Nombre`, `Apellidos`, `Telefono`, `Email`, `Password`) VALUES
(100, 'Admin', 'Admin', 123456789, 'admin@example.com', '$2y$10$BICxHc9sTUL6ejy4G8c21u6wIEns/MWv2Tfb5iXTRXUkxCr4zCyEC'),
(101, 'Jose', 'Perez', 678932451, 'jose@example.com', '$2y$10$PpugoUlSId5NLVtO0aa5tOwyQDZl2VyO77ECMzPPWJL2RLbaK3LI.'),
(102, 'Lucía', 'Casans', 634512978, 'lucia@example.com', '$2y$10$j.IQuLMMD9nmbEOVNFtvc.NAtebo0/hSgceXzF50yguN5I5h57f2u'),
(103, 'Abril', 'Nieto', 658947312, 'abril@example.com', '$2y$10$Olx5O3AtAxXCYYgzAg6eguu2olE5TOdPkZhjk8RxFgvMOEhCWGcsK');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `Productos`
--

CREATE TABLE `Productos` (
  `Cod_producto` int(3) NOT NULL,
  `Categoria` int(3) NOT NULL,
  `Modelo` varchar(50) NOT NULL,
  `Marca` varchar(50) NOT NULL,
  `Peso` int(3) NOT NULL,
  `Precio` float NOT NULL,
  `Stock` int(3) NOT NULL,
  `Visitas` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Volcado de datos para la tabla `Productos`
--

INSERT INTO `Productos` (`Cod_producto`, `Categoria`, `Modelo`, `Marca`, `Peso`, `Precio`, `Stock`, `Visitas`) VALUES
(201, 1, 'PR OPEN Rojo', 'Kuikma', 320, 29.99, 12, 20),
(202, 1, 'Cross IT Light', 'Adidas', 375, 229.99, 3, 21),
(203, 1, 'Technical Veron', 'Babolat', 365, 179.99, 8, 20),
(204, 1, 'Speed Motion', 'Head', 355, 159.99, 5, 31),
(205, 1, 'Blade Elite V2', 'Wilson', 365, 99.95, 6, 48),
(301, 2, 'Pure drive', 'Babolat', 285, 179.99, 14, 66),
(302, 2, 'Boost Rafa', 'Babolat', 260, 119.99, 8, 19),
(303, 2, 'Spark ELITE', 'Head', 286, 59.95, 21, 17),
(304, 2, 'BLADE 98', 'Wilson', 305, 189.49, 2, 39),
(305, 2, 'BURN 100LS', 'Wilson', 280, 109.49, 13, 13);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `Categorias`
--
ALTER TABLE `Categorias`
  ADD PRIMARY KEY (`indice_cat`);

--
-- Indices de la tabla `Clientes`
--
ALTER TABLE `Clientes`
  ADD PRIMARY KEY (`Cod_cliente`),
  ADD UNIQUE KEY `UNIQUE` (`Email`) USING BTREE;

--
-- Indices de la tabla `Productos`
--
ALTER TABLE `Productos`
  ADD PRIMARY KEY (`Cod_producto`),
  ADD KEY `FOREIGN` (`Categoria`) USING BTREE;

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `Categorias`
--
ALTER TABLE `Categorias`
  MODIFY `indice_cat` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `Clientes`
--
ALTER TABLE `Clientes`
  MODIFY `Cod_cliente` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `Productos`
--
ALTER TABLE `Productos`
  ADD CONSTRAINT `Foreign key` FOREIGN KEY (`Categoria`) REFERENCES `Categorias` (`indice_cat`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
