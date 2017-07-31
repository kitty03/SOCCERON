-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 31-07-2017 a las 05:15:52
-- Versión del servidor: 10.1.21-MariaDB
-- Versión de PHP: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `socceron`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `canchas`
--

CREATE TABLE `canchas` (
  `id_ca` int(11) NOT NULL,
  `descripcion_ca` varchar(50) NOT NULL,
  `sector_ca` varchar(30) DEFAULT NULL,
  `tipo_ca` char(20) DEFAULT NULL,
  `latitud_ca` decimal(8,2) NOT NULL,
  `longitu_ca` decimal(8,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipos`
--

CREATE TABLE `equipos` (
  `id_pa` int(11) NOT NULL,
  `id_ju` int(11) NOT NULL,
  `fecha_co` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jugadores`
--

CREATE TABLE `jugadores` (
  `id_ju` int(11) NOT NULL,
  `nombre_ju` varchar(200) NOT NULL,
  `contrasena_ju` char(60) NOT NULL,
  `correo_ju` varchar(200) NOT NULL,
  `token_ju` char(100) DEFAULT NULL,
  `fb_ju` varchar(300) DEFAULT NULL,
  `estado_ju` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `partidas`
--

CREATE TABLE `partidas` (
  `id_pa` int(11) NOT NULL,
  `id_ca` int(11) NOT NULL,
  `empieza_pa` datetime DEFAULT NULL,
  `estado_pa` tinyint(1) DEFAULT '1',
  `jugadores_pa` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `canchas`
--
ALTER TABLE `canchas`
  ADD PRIMARY KEY (`id_ca`);

--
-- Indices de la tabla `equipos`
--
ALTER TABLE `equipos`
  ADD KEY `fk_conformado2` (`id_pa`),
  ADD KEY `fk_conforman` (`id_ju`);

--
-- Indices de la tabla `jugadores`
--
ALTER TABLE `jugadores`
  ADD PRIMARY KEY (`id_ju`);

--
-- Indices de la tabla `partidas`
--
ALTER TABLE `partidas`
  ADD PRIMARY KEY (`id_pa`),
  ADD KEY `fk_utilizan` (`id_ca`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `canchas`
--
ALTER TABLE `canchas`
  MODIFY `id_ca` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `jugadores`
--
ALTER TABLE `jugadores`
  MODIFY `id_ju` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `partidas`
--
ALTER TABLE `partidas`
  MODIFY `id_pa` int(11) NOT NULL AUTO_INCREMENT;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `equipos`
--
ALTER TABLE `equipos`
  ADD CONSTRAINT `fk_conformado2` FOREIGN KEY (`id_pa`) REFERENCES `partidas` (`id_pa`),
  ADD CONSTRAINT `fk_conforman` FOREIGN KEY (`id_ju`) REFERENCES `jugadores` (`id_ju`);

--
-- Filtros para la tabla `partidas`
--
ALTER TABLE `partidas`
  ADD CONSTRAINT `fk_utilizan` FOREIGN KEY (`id_ca`) REFERENCES `canchas` (`id_ca`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
