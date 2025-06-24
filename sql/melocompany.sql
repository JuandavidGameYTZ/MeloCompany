-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 24, 2025 at 10:05 PM
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
(1, 'Juan David', 'AUTO', 'AWDADAWDA', '12', 3, 'img/autos/Juan David_1750689042_Hibiki Screenshot 2024.10.26 - 20.29.20.40.png', '2025-06-23 14:30:42', 'General', NULL),
(2, 'Juan', 'Carro chino', 'El mejorl carro chino', '12', 3, 'img/autos/Juan_1750689366_DAZBHNH7XJFRBPVNZHTWF5DTHM.jpg', '2025-06-23 14:36:06', 'General', NULL),
(3, 'Juan David Santana', 'Roadster', 'Carro en buenas condiciones de death stranding', '18', 5, 'img/autos/Juan David Santana_1750689873_Roadster.png', '2025-06-23 14:44:33', 'General', NULL),
(4, 'Juan David', 'JuanMovil', 'El mejor carro de todos los tiempos', '12/hora', 5, 'img/autos/Juan David_1750691507_Red Dead Redemption 2 Screenshot 2024.05.30 - 21.41.17.58.png', '2025-06-23 15:11:47', 'General', NULL),
(5, 'Juan David', 'caballo', 'buenas condiciones', '$8/hora', 5, 'img/autos/Juan David_1750770810_Red Dead Redemption 2 Screenshot 2024.05.30 - 00.18.28.84.png', '2025-06-24 13:13:30', 'Deportivo', NULL),
(6, 'Juan David', 'Carro deportivo', 'Lo que sea bro', '$9/hora', 5, 'img/autos/Juan David_1750773401_16432233107875.jpg', '2025-06-24 13:56:41', 'Deportivo', 'av. 27 de febrero santo domingo');

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
(37, 'Juan David', 'JuandavidMRT@gmail.com', '$2y$10$Y424d4TGLV77znUMdJKTjurXhqG3OmvSEJ2Thkc7r358oOOdMEY3u', 'uploads/perfiles/perfil_685965eb504f0.png', 'img/perfiles/fondo_Juan David_Hibiki Screenshot 2024.10.27 - 12.26.23.51.png'),
(38, 'Juan', 'JuandavidMsT@gmail.com', '$2y$10$BMZlp2hi.Q3hENu9rhTkd.GO9w4dX21SKL7thPJVX5HNOmRZD3dhO', 'uploads/perfiles/perfil_68596612d601e.png', 'img/perfiles/fondo_Juan_Ccff7r Screenshot 2025.02.21 - 19.16.55.13.png'),
(39, 'Juan David Santana', 'Juandavid2RT@gmail.com', '$2y$10$I7VTSFgFaN0MnY3CrOxctOLsrL2WsUL3JwwS4JsdPqdmIipOECQPW', 'uploads/perfiles/perfil_685967ac83680.png', 'img/perfiles/fondo_Juan David Santana_Death Stranding Screenshot 2024.11.28 - 21.04.26.22.png');

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
(3, 'Juan David', 'Juan David', 1, '2025-06-23 14:11:36'),
(4, 'Juan', 'Juan', 4, '2025-06-23 14:36:41'),
(5, 'Juan David Santana', 'Juan David Santana', 4, '2025-06-23 14:41:59');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `autos`
--
ALTER TABLE `autos`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `registro`
--
ALTER TABLE `registro`
  MODIFY `ID_Registro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `valoraciones`
--
ALTER TABLE `valoraciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
