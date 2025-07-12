-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 06, 2025 at 03:26 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `melocompany`
--

-- --------------------------------------------------------

--
-- Table structure for table `autos`
--

CREATE TABLE `autos` (
  `id` int(11) NOT NULL,
  `usuario` varchar(100) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` varchar(50) DEFAULT NULL,
  `estrellas` int(11) DEFAULT 5,
  `imagen` varchar(255) DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `categoria` varchar(50) DEFAULT 'General',
  `ubicacion` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `autos`
--

INSERT INTO `autos` (`id`, `usuario`, `nombre`, `descripcion`, `precio`, `estrellas`, `imagen`, `fecha_creacion`, `categoria`, `ubicacion`) VALUES
(7, 'Juan David', 'JiYue Robo X Electric Hypercar', 'Muy buen, veiculo, vistoso y llamativo', '$40/hora', 5, 'img/autos/Juan David_1750868297_DAZBHNH7XJFRBPVNZHTWF5DTHM.jpg', '2025-06-25 16:18:17', 'Eléctrico', 'El faro, Santo Domingo Este'),
(8, 'Michael de santa', 'El Honda CR-V', 'Carro moderno', '$20/hora', 5, 'img/autos/Michael de santa_1750869138_m_174560943802513139.jpg', '2025-06-25 16:32:18', 'SUV', 'condominio el rosal I, apartamento 1B, Santo Domingo Este'),
(9, 'Jhon', 'Lambo ', 'El mejor carro', '$100/hora', 5, 'img/autos/Jhon_1750873557_16530388017130.jpg', '2025-06-25 17:45:57', 'Deportivo', 'boca chica');

-- --------------------------------------------------------

--
-- Table structure for table `calificausuario`
--

CREATE TABLE `calificausuario` (
  `id` int(11) NOT NULL,
  `usuario_que_valora` varchar(100) NOT NULL,
  `usuario_valorado` varchar(100) NOT NULL,
  `estrellas` int(11) NOT NULL CHECK (`estrellas` between 1 and 5),
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `calificausuario`
--

INSERT INTO `calificausuario` (`id`, `usuario_que_valora`, `usuario_valorado`, `estrellas`, `fecha`) VALUES
(0, 'Michael de santa', 'Juan David', 4, '2025-06-25 16:37:10');

-- --------------------------------------------------------

--
-- Table structure for table `comentarios`
--

CREATE TABLE `comentarios` (
  `id` int(11) NOT NULL,
  `id_auto` int(11) NOT NULL,
  `usuario` varchar(100) NOT NULL,
  `comentario` text NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comentarios`
--

INSERT INTO `comentarios` (`id`, `id_auto`, `usuario`, `comentario`, `fecha`) VALUES
(1, 4, 'Quendry', 'pinche auto pedorro', '2025-06-28 18:06:25'),
(2, 4, 'Quendry', 'Creo \"creo\" (creo) solo sospecho... que eso no es un caballo', '2025-06-28 18:40:43');

-- --------------------------------------------------------

--
-- Table structure for table `registro`
--

CREATE TABLE `registro` (
  `ID_Registro` int(11) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `CorreoElectronico` varchar(100) NOT NULL,
  `Contrasena` varchar(100) NOT NULL,
  `imagen_perfil` varchar(255) DEFAULT NULL,
  `imagen_fondo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registro`
--

INSERT INTO `registro` (`ID_Registro`, `Nombre`, `CorreoElectronico`, `Contrasena`, `imagen_perfil`, `imagen_fondo`) VALUES
(1, 'Quendry', 'quendry@gmail.com', '$2y$10$waQyo/IYs68FxScGUUecPOcNz.C.ftp27p.wGbzfr/94ulgVRHizi', NULL, NULL),
(2, 'quendry viloria soto', 'jquendry@gmail.com', '$2y$10$TfPzDwD8ySJ88AHVKTBoLOfZZqQLMxeZVQEsD6duZ3YIX5gWJRtky', NULL, NULL),
(37, 'Juan David', 'JuandavidMRT@gmail.com', '$2y$10$Y424d4TGLV77znUMdJKTjurXhqG3OmvSEJ2Thkc7r358oOOdMEY3u', 'uploads/perfiles/perfil_685c203d2730e.png', 'img/perfiles/fondo_Juan David_190253-1.jpg'),
(38, 'Juan', 'JuandavidMsT@gmail.com', '$2y$10$BMZlp2hi.Q3hENu9rhTkd.GO9w4dX21SKL7thPJVX5HNOmRZD3dhO', 'uploads/perfiles/perfil_68596612d601e.png', 'img/perfiles/fondo_Juan_Ccff7r Screenshot 2025.02.21 - 19.16.55.13.png'),
(39, 'Juan David Santana', 'Juandavid2RT@gmail.com', '$2y$10$I7VTSFgFaN0MnY3CrOxctOLsrL2WsUL3JwwS4JsdPqdmIipOECQPW', 'uploads/perfiles/perfil_685967ac83680.png', 'img/perfiles/fondo_Juan David Santana_Death Stranding Screenshot 2024.11.28 - 21.04.26.22.png'),
(40, 'Michael de santa', 'Michaelds@gmail.com', '$2y$10$HuFzzZOVUABj/9kGcJMyUuonD44U/h9KuAUlwLHLAKvGRankTa9Pm', 'uploads/perfiles/perfil_685c235e6dfe1.png', 'img/perfiles/fondo_Michael de santa_nduksi52zrs41.webp'),
(41, 'Jhon', 'Jhon@gmail.com', '$2y$10$rmo8BFjR3f0qB9CC5ZzFNuhUhOrywirMBCrr338h1uUUFujOsnk32', 'uploads/perfiles/perfil_685c357d34fce.jpg', 'img/perfiles/fondo_Jhon_landscape-photography-settings-164919.png');

-- --------------------------------------------------------

--
-- Table structure for table `valoraciones`
--

CREATE TABLE `valoraciones` (
  `id` int(11) NOT NULL,
  `usuario_valorado` varchar(100) NOT NULL,
  `usuario_que_valora` varchar(100) NOT NULL,
  `estrellas` int(11) NOT NULL CHECK (`estrellas` between 1 and 5),
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `valoraciones`
--

INSERT INTO `valoraciones` (`id`, `usuario_valorado`, `usuario_que_valora`, `estrellas`, `fecha`) VALUES
(1, 'JuanDavidYTZ', 'JuanDavidYTZ', 5, '2025-06-23 04:18:29'),
(2, 'JuanDavidMRT', 'JuanDavidMRT', 4, '2025-06-23 04:28:04'),
(3, 'Juan David', 'Juan David', 2, '2025-06-25 04:04:42'),
(4, 'Juan', 'Juan', 4, '2025-06-23 14:36:41'),
(5, 'Juan David Santana', 'Juan David Santana', 4, '2025-06-23 14:41:59'),
(6, 'Michael de santa', 'Michael de santa', 3, '2025-06-25 16:36:32'),
(7, 'Juan David', 'Michael de santa', 4, '2025-06-25 16:37:10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `autos`
--
ALTER TABLE `autos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registro`
--
ALTER TABLE `registro`
  ADD PRIMARY KEY (`ID_Registro`);

--
-- Indexes for table `valoraciones`
--
ALTER TABLE `valoraciones`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `autos`
--
ALTER TABLE `autos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `registro`
--
ALTER TABLE `registro`
  MODIFY `ID_Registro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `valoraciones`
--
ALTER TABLE `valoraciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
