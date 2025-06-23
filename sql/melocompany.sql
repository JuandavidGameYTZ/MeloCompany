-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 23, 2025 at 04:08 AM
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
(15, 'JuanDavid', 'JuandavidMRT@gmail.com', '$2y$10$cQE2M7lvWmTSJPQH6aqJ1uVHnSY1d2BwtAUu/mE3wVI/vrtFPsr/C', NULL, NULL),
(16, 'Juandavid', 'JuandavidMRT@gmail.com', '$2y$10$qj3J1hCJ9S/XKbmhyiOYq.TbDFKjXYu/7M8ztuXb0KMhUS1s6I1dq', NULL, NULL),
(17, 'Juandavid', 'JuandavidMRT@gmail.com', '$2y$10$iTWGEqXRdHVJT.FAfu6Ehu0kmHaY7jDi6IMG3X8HC4jeWUslwnQbe', NULL, NULL),
(18, 'awdaw', 'JuandavidMRT@gmail.com', '$2y$10$MkPkvtAd706tMzud.JJY6uE/KFFL1lvVw5fUVepbzQWD7GLxSu1im', NULL, NULL),
(19, 'Juandavid', 'JuandavidMRT@gmail.com', '$2y$10$cbsH0BHVP1bNf.c0b48M/OIb3VfFVeYvOxwqXZljK9JrAXbD4WJau', NULL, NULL),
(20, 'JuanDavid', 'JuandavidMRT@gmail.com', '$2y$10$O69cub3LezQ1lFyBvHKYB.NyyLlntQ/yyB6yKJxyjqbJ8wO1D6J5a', NULL, NULL),
(21, 'AJJDAWD', 'JuandavidMRT@gmail.com', '$2y$10$KoSO5IkHifunqAjGP/UwMudqvygPg5/TqBFsTsgPCaD.w8vrrWYIK', NULL, NULL),
(22, 'JuanDavid', 'JuandavidMRT@gmail.com', '$2y$10$l.ptC2fhftmiWUfzBGMHE.gNqC/.2YBVBPcF.K81pfujbtkjPoTeK', NULL, NULL),
(23, 'qdawdqawd', 'JuandavidMRT@gmail.com', '$2y$10$4Q4J2iDTvjKFLDoLv6f4TOPoC7zGCILM6Vsmb9veL8GoG8Sx4KwOq', 'img/perfiles/qdawdqawd_default.png', 'img/perfiles/fondo_qdawdqawd_default-bg.png'),
(24, 'JuanDavidYTZ', 'JuandavidMRT@gmail.com', '$2y$10$SQJc3azPIGiHQFbTgxQXauVweOEjSB26iEVEeJUyZ3Lmd4t0mc36C', 'img/perfiles/JuanDavidYTZ_Hibiki Screenshot 2024.10.24 - 10.23.41.94.png', 'img/perfiles/fondo_qdawdqawd_default-bg.png'),
(25, 'wadawdaw', 'JuandavidMRT@gmail.com', '$2y$10$rLqNod7hXl3GtskJed34oucia4SppYHhrS5GcOhyBkBBRkVwdAPWq', 'img/perfiles/wadawdaw_Hibiki Screenshot 2024.10.26 - 22.11.22.30.png', 'img/perfiles/fondo_wadawdaw_Ccff7r Screenshot 2025.02.21 - 19.16.55.13.png'),
(26, 'Juan David Santana Castillo', 'JuandavidMRT@gmail.com', '$2y$10$Q0dwOwfSDURjMB1Fwkz1lOpyE62ZidGgIFSSbjztReF5j2aadacfe', NULL, NULL),
(27, 'Juan David', 'JuandavidMRT@gmail.com', '$2y$10$H6tk.MXZmWSDl7S2KMOry.xb582bJxEpq3VbuDU7X74FrAa.2IulS', 'img/perfiles/Juan David_Hibiki Screenshot 2024.10.24 - 10.23.41.94.png', NULL),
(28, 'qdawdqawd', 'JuandavidMRT@gmail.com', '$2y$10$8c3nV1zqt2D6fdIWEu.fXuimaRJoo1.GCtLiref.3Kz7kIgcMD2Gq', NULL, NULL),
(29, 'JuanDavidYTZ', 'JuandavidMRT@gmail.com', '$2y$10$c4SB/X6TqkiOS/u/FyHGjOvBmJAUVkuQwHSwIlBaykHoHX4KtdN8O', 'img/perfiles/JuanDavidYTZ_Hibiki Screenshot 2024.10.24 - 10.23.41.94.png', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `registro`
--
ALTER TABLE `registro`
  ADD PRIMARY KEY (`ID_Registro`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `registro`
--
ALTER TABLE `registro`
  MODIFY `ID_Registro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
