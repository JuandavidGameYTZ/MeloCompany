-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-06-2025 a las 00:51:18
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
-- Base de datos: `melocompany`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calificausuario`
--

CREATE TABLE `calificausuario` (
  `id` int(11) NOT NULL,
  `usuario_que_valora` varchar(100) NOT NULL,
  `usuario_valorado` varchar(100) NOT NULL,
  `estrellas` int(11) NOT NULL CHECK (`estrellas` between 1 and 5),
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `calificausuario`
--

INSERT INTO `calificausuario` (`id`, `usuario_que_valora`, `usuario_valorado`, `estrellas`, `fecha`) VALUES
(1, 'Quendry', 'Juan David', 1, '2025-06-24 22:25:06'),
(2, 'Quendry', 'Juan David Santana', 4, '2025-06-24 22:29:03');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `calificausuario`
--
ALTER TABLE `calificausuario`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `calificausuario`
--
ALTER TABLE `calificausuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
