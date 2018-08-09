-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-08-2018 a las 20:24:01
-- Versión del servidor: 10.1.34-MariaDB
-- Versión de PHP: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `pruebagoltratec`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_vivienda`
--

CREATE TABLE `tipos_vivienda` (
  `id_tipo` int(11) NOT NULL,
  `nombre_tipo` text COLLATE latin1_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `tipos_vivienda`
--

INSERT INTO `tipos_vivienda` (`id_tipo`, `nombre_tipo`) VALUES
(1, 'Unifamiliar'),
(2, 'Duplex'),
(3, 'Atico'),
(4, 'Local'),
(5, 'Rústica'),
(6, 'Plnta Baja'),
(7, 'Chalet');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `email` varchar(80) COLLATE latin1_spanish_ci NOT NULL,
  `password` varchar(250) COLLATE latin1_spanish_ci NOT NULL,
  `authKey` varchar(250) COLLATE latin1_spanish_ci NOT NULL,
  `accessToken` varchar(250) COLLATE latin1_spanish_ci NOT NULL,
  `activate` tinyint(1) NOT NULL DEFAULT '0',
  `verification_code` varchar(250) COLLATE latin1_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `authKey`, `accessToken`, `activate`, `verification_code`) VALUES
(1, 'usuario1', 'javioque@ono.com', 'dfdyztyDBxP/k', 'a163af40d435effaf78fe19ed996bfd7172c8912a374af5e0ee191fab1072fe135fe4e34f30eadfc19aa9d95caaf401e3671319e9177e3f39d5873d5c53631978a14beae26f9312c9d223b42d2aaeb36e3ddd119cb768cbd3b8c4dc577b8b8e6980f0b88', '04b2c33e88d9c0717232d13acb79c68853c8d22b9226a2791a6c55d7c1fe96ad21e101170b16937f004b178906f46274fd8b62e63c5695177e9e9a64d43cba39398f6afcd74262ec9fe7c021f2c9fd948283cb073cef5f91264b081b2b906b7245ad2cd6', 1, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `viviendas`
--

CREATE TABLE `viviendas` (
  `id_vivienda` int(11) NOT NULL,
  `id_tipo` int(11) NOT NULL,
  `propietario` text COLLATE latin1_spanish_ci NOT NULL,
  `direccion` text COLLATE latin1_spanish_ci NOT NULL,
  `localidad` text COLLATE latin1_spanish_ci NOT NULL,
  `habitaciones` int(11) NOT NULL,
  `aseos` int(11) NOT NULL,
  `superficie` float(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Volcado de datos para la tabla `viviendas`
--

INSERT INTO `viviendas` (`id_vivienda`, `id_tipo`, `propietario`, `direccion`, `localidad`, `habitaciones`, `aseos`, `superficie`) VALUES
(1, 1, 'Javier Pérez Royo', 'Avenida del Pais Valenciano', 'Elche', 6, 2, 125.50),
(2, 1, 'Andrea López Gómez', 'Calle  La Purisima 25 3º - 2', 'Catral', 4, 1, 50.25),
(3, 2, 'Rosario García Antón', 'Calle Maissonave 3, 1º Derecha', 'Alicante', 5, 2, 95.00),
(4, 2, 'Rosa López rodríguez', 'Avenida de la Libertad 44, 7º - izda.', 'Elche', 5, 2, 105.25),
(5, 4, 'Pedro Hernandez Gómez', 'Avenida de Novelda 72, 4º - 1', 'Elche', 5, 2, 82.45),
(6, 3, 'Juan Gómez Fernández', 'Calle La Purisima, 51', 'Catral', 4, 2, 75.40),
(7, 3, 'Juan Gómez Fernández', 'Calle La Purisima, 51', 'Catral', 4, 2, 75.40),
(8, 3, 'Juan Gómez Fernández', 'Calle La Purisima, 51', 'Catral', 4, 2, 75.40);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tipos_vivienda`
--
ALTER TABLE `tipos_vivienda`
  ADD PRIMARY KEY (`id_tipo`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `viviendas`
--
ALTER TABLE `viviendas`
  ADD PRIMARY KEY (`id_vivienda`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tipos_vivienda`
--
ALTER TABLE `tipos_vivienda`
  MODIFY `id_tipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `viviendas`
--
ALTER TABLE `viviendas`
  MODIFY `id_vivienda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
