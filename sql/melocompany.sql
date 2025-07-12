-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 12, 2025 at 06:34 PM
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
(9, 'Jhon', 'Lambo ', 'El mejor carro', '$100/hora', 5, 'img/autos/Jhon_1750873557_16530388017130.jpg', '2025-06-25 17:45:57', 'Deportivo', 'boca chica'),
(10, 'Juan David', 'TEST', 'dadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawd', '8', 5, 'img/autos/Juan David_1751819698_Captura de pantalla 2025-07-04 125000.png', '2025-07-06 16:34:58', 'Económico', 'bayaguana'),
(11, 'Juan David', 'dadadaw', 'adwadadadwddddddddddddddddddddddddddd\r\na\r\na\r\na\r\na\r\na\r\na\r\na\r\na\r\na\r\na\r\na\r\na', '2', 5, 'img/autos/Juan David_1751820923_Captura de pantalla 2024-01-11 135833.png', '2025-07-06 16:55:23', 'Eléctrico', 'bayaguana');

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
(0, 'Michael de santa', 'Juan David', 4, '2025-06-25 16:37:10'),
(0, 'Juan David', 'Jhon', 4, '2025-07-06 14:59:29');

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
(2, 4, 'Quendry', 'Creo \"creo\" (creo) solo sospecho... que eso no es un caballo', '2025-06-28 18:40:43'),
(3, 7, 'Juan David', 'HOLA', '2025-07-06 14:13:44'),
(4, 7, 'Juan David', 'kkk;\'\r\nk;kiljijhi', '2025-07-06 14:18:17'),
(5, 7, 'Juan David', 'dadawd\r\nadsadwadsawdsadw', '2025-07-06 14:57:16'),
(6, 7, 'Juan David', 'Bueno la verdad es que xd', '2025-07-06 14:58:00'),
(7, 11, 'Juan David', 'kpkklñklñ', '2025-07-06 22:48:06'),
(8, 7, 'Juan David', 'ijiojiij', '2025-07-06 23:05:19'),
(9, 11, 'Michael de santa', 'ssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss', '2025-07-09 13:36:01'),
(10, 8, 'Manuel', 'exelente', '2025-07-09 16:02:06'),
(11, 8, 'Manuel', 'nooi9hoi', '2025-07-12 15:15:58'),
(12, 7, 'Juan David', 'ssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss', '2025-07-12 16:14:13'),
(13, 7, 'Juan David', 'hd;waijjd;haw;daw;iwdh;wah;fhaw;fh;hwalhf;alwwf;lawhfkhawlhf;lwafh;klwahk;flawhkl\'fh;awfhk;awh;kfh;awhkfklawfhkawwk;hf;ahwfhawk;hfka;wf;hkaf', '2025-07-12 16:19:09');

-- --------------------------------------------------------

--
-- Table structure for table `denuncias`
--

CREATE TABLE `denuncias` (
  `id` int(11) NOT NULL,
  `id_auto` int(11) NOT NULL,
  `usuario` varchar(100) NOT NULL,
  `descripcion` text NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `denuncias`
--

INSERT INTO `denuncias` (`id`, `id_auto`, `usuario`, `descripcion`, `fecha`) VALUES
(1, 5, 'Quendry', 'eso no es un carro me siento re ofendido por dios maten a este hombre machista', '2025-07-04 21:20:16');

-- --------------------------------------------------------

--
-- Table structure for table `mensajes`
--

CREATE TABLE `mensajes` (
  `id` int(11) NOT NULL,
  `emisor` varchar(50) NOT NULL,
  `receptor` varchar(50) NOT NULL,
  `mensaje` text NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mensajes`
--

INSERT INTO `mensajes` (`id`, `emisor`, `receptor`, `mensaje`, `fecha`) VALUES
(1, 'Dylan', 'Juan David Santana', 'Momo esta buenisima', '2025-07-07 02:56:03'),
(2, 'Dylan', 'Juan David', 'tu mami', '2025-07-07 02:58:09');

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
(41, 'Jhon', 'Jhon@gmail.com', '$2y$10$rmo8BFjR3f0qB9CC5ZzFNuhUhOrywirMBCrr338h1uUUFujOsnk32', 'uploads/perfiles/perfil_685c357d34fce.jpg', 'img/perfiles/fondo_Jhon_landscape-photography-settings-164919.png'),
(42, 'Manuel', 'iwi@gmail.com', '$2y$10$XHzo43SqAnrkPKrwngkS5.FbR1nKaxqumORVSFhzIOj/y9Mme4Cte', NULL, NULL);

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
(3, 'Juan David', 'Juan David', 4, '2025-07-12 15:33:04'),
(4, 'Juan', 'Juan', 4, '2025-06-23 14:36:41'),
(5, 'Juan David Santana', 'Juan David Santana', 4, '2025-06-23 14:41:59'),
(6, 'Michael de santa', 'Michael de santa', 3, '2025-06-25 16:36:32'),
(7, 'Juan David', 'Michael de santa', 4, '2025-06-25 16:37:10'),
(8, 'Jhon', 'Juan David', 4, '2025-07-06 14:59:29');

-- --------------------------------------------------------

--
-- Table structure for table `valorarauto`
--

CREATE TABLE `valorarauto` (
  `id` int(11) NOT NULL,
  `id_auto` int(11) NOT NULL,
  `usuario` varchar(100) NOT NULL,
  `valor` int(11) NOT NULL CHECK (`valor` between 1 and 5),
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `valorarauto`
--

INSERT INTO `valorarauto` (`id`, `id_auto`, `usuario`, `valor`, `fecha`) VALUES
(1, 7, 'Juan David', 4, '2025-07-06 13:28:40'),
(2, 8, 'Juan David', 5, '2025-07-06 14:58:54'),
(3, 9, 'Juan David Santana', 4, '2025-07-06 15:32:53'),
(4, 10, 'Juan David', 1, '2025-07-06 16:45:31'),
(5, 9, 'Juan David', 3, '2025-07-06 22:22:09'),
(6, 7, 'Michael de santa', 5, '2025-07-06 23:10:39'),
(7, 10, 'Michael de santa', 5, '2025-07-06 23:10:53'),
(8, 8, 'Michael de santa', 4, '2025-07-06 23:14:38'),
(9, 7, 'Juan David Santana', 2, '2025-07-07 00:49:52'),
(10, 10, 'Juan David Santana', 5, '2025-07-07 00:50:49'),
(11, 11, 'Michael de santa', 5, '2025-07-09 13:36:51'),
(12, 11, 'Juan David', 2, '2025-07-09 13:37:26'),
(13, 8, 'Manuel', 2, '2025-07-09 16:01:24');

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
-- Indexes for table `denuncias`
--
ALTER TABLE `denuncias`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mensajes`
--
ALTER TABLE `mensajes`
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
-- Indexes for table `valorarauto`
--
ALTER TABLE `valorarauto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_auto` (`id_auto`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `autos`
--
ALTER TABLE `autos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `denuncias`
--
ALTER TABLE `denuncias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `mensajes`
--
ALTER TABLE `mensajes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `registro`
--
ALTER TABLE `registro`
  MODIFY `ID_Registro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `valoraciones`
--
ALTER TABLE `valoraciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `valorarauto`
--
ALTER TABLE `valorarauto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `valorarauto`
--
ALTER TABLE `valorarauto`
  ADD CONSTRAINT `valorarauto_ibfk_1` FOREIGN KEY (`id_auto`) REFERENCES `autos` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
