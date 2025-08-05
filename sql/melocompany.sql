-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 05, 2025 at 02:02 AM
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
  `ubicacion` varchar(255) DEFAULT NULL,
  `oculto` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `autos`
--

INSERT INTO `autos` (`id`, `usuario`, `nombre`, `descripcion`, `precio`, `estrellas`, `imagen`, `fecha_creacion`, `categoria`, `ubicacion`, `oculto`) VALUES
(7, 'Juan David', 'JiYue Robo X Electric Hypercar', 'Muy buen, veiculo, vistoso y llamativo', '$40/hora', 5, 'img/autos/Juan David_1750868297_DAZBHNH7XJFRBPVNZHTWF5DTHM.jpg', '2025-06-25 16:18:17', 'Eléctrico', 'El faro, Santo Domingo Este', 1),
(8, 'Michael de santa', 'El Honda CR-V', 'Carro moderno', '$20/hora', 5, 'img/autos/Michael de santa_1750869138_m_174560943802513139.jpg', '2025-06-25 16:32:18', 'SUV', 'condominio el rosal I, apartamento 1B, Santo Domingo Este', 0),
(9, 'Jhon', 'Lambo ', 'El mejor carro', '$100/hora', 5, 'img/autos/Jhon_1750873557_16530388017130.jpg', '2025-06-25 17:45:57', 'Deportivo', 'boca chica', 0),
(10, 'Juan David', 'TEST', 'dadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawddadadadadawd', '8', 5, 'img/autos/Juan David_1751819698_Captura de pantalla 2025-07-04 125000.png', '2025-07-06 16:34:58', 'Económico', 'bayaguana', 0),
(11, 'Juan David', 'dadadaw', 'adwadadadwddddddddddddddddddddddddddd\r\na\r\na\r\na\r\na\r\na\r\na\r\na\r\na\r\na\r\na\r\na\r\na', '2', 5, 'img/autos/Juan David_1751820923_Captura de pantalla 2024-01-11 135833.png', '2025-07-06 16:55:23', 'Eléctrico', 'bayaguana', 1),
(12, 'Holabuenas', 'fefsefsef', 'sefsefsefse', '77', 5, 'img/autos/Holabuenas_1753054743_ChatGPT Image Jul 6, 2025, 09_01_51 PM.png', '2025-07-20 23:39:03', 'Eléctrico', 'bayaguana', 0),
(13, 'Juan David', 'Holaaaa', 'ADWAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADAWDAWAWAWD', '7', 5, 'img/autos/Juan David_1753575015_ChatGPT Image Jul 6, 2025, 08_54_59 PM.png', '2025-07-27 00:10:15', 'Eléctrico', '18.470394, -69.889374', 0),
(14, 'Juan David', 'JAJWDAWDAW', 'ADAWDAWDAWDAWDAWD', '12', 5, 'img/autos/Juan David_1753575242_ChatGPT Image Jul 6, 2025, 08_54_59 PM.png', '2025-07-27 00:14:02', 'Eléctrico', 'credigas, Avenida Charles de Gaulle, Juan Lopez, Valle del Este, Santo Domingo Este, Santo Domingo, 11508, Dominican Republic (18.479739, -69.827267)', 0),
(15, 'Juan David', 'aawwaawdaw', 'uibhuhuiho', 'wa', 5, 'img/autos/Juan David_1753575419_ChatGPT Image Jul 6, 2025, 08_54_59 PM.png', '2025-07-27 00:16:59', 'Eléctrico', '18.440139, -69.961141', 0),
(16, 'Michael de santa', 'dawawdawaw', 'wadawawdaw', '123213', 5, 'img/autos/Michael de santa_1753575659_ChatGPT Image Jul 6, 2025, 08_54_59 PM.png', '2025-07-27 00:20:59', 'Eléctrico', '18.477232, -69.894549', 0),
(17, 'Michael de santa', 'wdawawawaw', 'dwadawdawdawdaw', '2312321321', 5, 'img/autos/Michael de santa_1753575684_ChatGPT Image Jul 6, 2025, 08_54_59 PM.png', '2025-07-27 00:21:24', 'Eléctrico', '18.473976, -69.940048', 0),
(18, 'Jose manuela', 'WDAWDAWDWA', 'DWADAWAWDWAD', '1321321', 5, 'img/autos/Jose manuela_1754329164_Death Stranding Screenshot 2024.11.28 - 18.21.59.72.png', '2025-08-04 17:39:24', 'Deportivo', '18.472185, -69.920975', 0);

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
(0, 'Juan David', 'Jhon', 3, '2025-07-27 23:52:43'),
(0, 'Juan David', 'Michael de santa', 1, '2025-08-04 17:26:49'),
(0, 'Juan David', 'Jose manuel', 4, '2025-07-27 17:51:03'),
(0, 'Juan David', 'Holabuenas', 5, '2025-08-04 17:30:23'),
(0, 'Mauricio Guillermo Alejandro Sebastián', 'Juan David', 3, '2025-08-04 22:32:13'),
(0, 'Jose manuela', 'Juan David', 5, '2025-08-04 22:53:15');

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
(13, 7, 'Juan David', 'hd;waijjd;haw;daw;iwdh;wah;fhaw;fh;hwalhf;alwwf;lawhfkhawlhf;lwafh;klwahk;flawhkl\'fh;awfhk;awh;kfh;awhkfklawfhkawwk;hf;ahwfhawk;hfka;wf;hkaf', '2025-07-12 16:19:09'),
(14, 10, 'Juan David', 'BJKJGKGJGKJGKJ', '2025-07-12 17:35:45'),
(15, 10, 'Juan David', 'KKAKDADAWDAW', '2025-07-12 17:35:51'),
(16, 7, 'Juan David', 'adawdaw', '2025-07-12 20:58:24'),
(17, 7, 'Juan David', 'ssss', '2025-07-12 20:58:29'),
(18, 7, 'Juan David', 'xsssssssxsssssssxsssssssxsssssssxsssssssxsssssssxsssssssxsssssssxsssssssxsssssssxsssssssxsssssssxsssssssxsssssssxsssssssxsssssssxsssssssxsssssssxsssssssxsssssssxsssssssxsssssssxsssssssxsssssssxsssssssxsssssssxsssssssxsssssssxsssssssxsssssssxsssssssxs', '2025-07-12 20:58:43'),
(19, 8, 'Juan David', 'dadwdwa', '2025-07-21 13:52:18'),
(20, 9, 'Juan David', 'nljkjlkklk', '2025-07-29 15:55:34'),
(21, 9, 'Juan David', 'klkkllk', '2025-07-29 15:55:39'),
(22, 16, 'Juan David', 'lnjljj;j;ljl;;\'k\'', '2025-07-29 15:55:48'),
(23, 16, 'Juan David', 'Muy buen carro', '2025-07-29 15:56:01'),
(24, 17, 'Michael de santa', 'huhuhuuhuuh', '2025-08-04 15:11:20'),
(25, 18, 'Jose manuela', 'Hola como estas', '2025-08-04 21:04:41'),
(26, 17, 'Mauricio Guillermo Alejandro Sebastián', 'imjjiij', '2025-08-04 22:31:32');

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
(1, 5, 'Quendry', 'eso no es un carro me siento re ofendido por dios maten a este hombre machista', '2025-07-04 21:20:16'),
(2, 17, 'Juan David', 'dawdawdawdawdawdaw', '2025-07-27 19:06:28'),
(3, 12, 'Jose manuela', 'PIYGFIGUIGÑIHO´HÓIHOOÑIHOI´H´HIOHÓIHIOIHIOHIOOIHHIOIHHIIHHIIHHIIHOPÑIIIIIIIIIIIIIIIIIIIIII', '2025-07-27 21:14:52'),
(4, 16, 'Juan David', 'jawijdjaipwdapwijdijawijoawojdjoiawodawjiodoiawjoiawoidijoawidawawdaw', '2025-07-27 21:15:16');

-- --------------------------------------------------------

--
-- Table structure for table `mensajes`
--

CREATE TABLE `mensajes` (
  `id` int(11) NOT NULL,
  `emisor` varchar(50) NOT NULL,
  `receptor` varchar(50) NOT NULL,
  `mensaje` text NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `tipo` enum('texto','imagen') DEFAULT 'texto',
  `hora` datetime DEFAULT current_timestamp(),
  `leido` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mensajes`
--

INSERT INTO `mensajes` (`id`, `emisor`, `receptor`, `mensaje`, `fecha`, `tipo`, `hora`, `leido`) VALUES
(3, 'Juan David', 'Jhon', 'fafaf', '2025-07-12 17:33:51', 'texto', '2025-07-20 19:49:50', 0),
(4, 'Juan David', 'Jhon', 'cCWDADAWDAWD', '2025-07-12 17:33:55', 'texto', '2025-07-20 19:49:50', 0),
(5, 'Juan David', 'Michael de santa', 'HOIPHUHOIOHPIHOI', '2025-07-12 17:35:12', 'texto', '2025-07-20 19:49:50', 1),
(6, 'Jose manuel', 'Juan David', 'segawfawd', '2025-07-20 21:05:28', 'texto', '2025-07-20 19:49:50', 1),
(7, 'Juan David', 'Jose manuel', 'Hey tu SAJWDJAJWFJWAF no yo DJWADAWJDAWS', '2025-07-20 21:08:01', 'texto', '2025-07-20 19:49:50', 0),
(8, 'Jose manuela', 'Juan David', 'kigugoipbi', '2025-07-20 21:10:20', 'texto', '2025-07-20 19:49:50', 1),
(9, 'Juan David', 'Jose manuela', 'WEAWDAWDAW', '2025-07-20 21:45:36', 'texto', '2025-07-20 19:49:50', 1),
(10, 'Juan David', 'Jose manuela', 'AWDAWAWDAW', '2025-07-20 21:45:38', 'texto', '2025-07-20 19:49:50', 1),
(11, 'Juan David', 'Michael de santa', 'dawdawa', '2025-07-20 21:49:57', 'texto', '2025-07-20 19:49:50', 1),
(12, 'Juan David', 'Jose manuela', 'aawdawdwa', '2025-07-20 21:52:53', 'texto', '2025-07-20 19:49:50', 1),
(13, 'Juan David', 'Jose manuela', 'awdawd', '2025-07-20 21:52:53', 'texto', '2025-07-20 19:49:50', 1),
(14, 'Juan David', 'Jose manuela', 'a', '2025-07-20 21:52:54', 'texto', '2025-07-20 19:49:50', 1),
(15, 'Juan David', 'Jose manuela', 'a', '2025-07-20 21:52:54', 'texto', '2025-07-20 19:49:50', 1),
(16, 'Juan David', 'Jose manuela', 'a', '2025-07-20 21:52:55', 'texto', '2025-07-20 19:49:50', 1),
(17, 'Juan David', 'Jose manuela', 'a', '2025-07-20 21:52:55', 'texto', '2025-07-20 19:49:50', 1),
(18, 'Juan David', 'Jose manuela', 'a', '2025-07-20 21:52:55', 'texto', '2025-07-20 19:49:50', 1),
(19, 'Juan David', 'Jose manuela', 'a', '2025-07-20 21:52:55', 'texto', '2025-07-20 19:49:50', 1),
(20, 'Juan David', 'Jose manuela', 'a', '2025-07-20 21:52:56', 'texto', '2025-07-20 19:49:50', 1),
(21, 'Juan David', 'Jose manuela', 'a', '2025-07-20 21:52:56', 'texto', '2025-07-20 19:49:50', 1),
(22, 'Juan David', 'Jose manuela', 'a', '2025-07-20 21:52:56', 'texto', '2025-07-20 19:49:50', 1),
(23, 'Juan David', 'Jose manuela', 'a', '2025-07-20 21:52:57', 'texto', '2025-07-20 19:49:50', 1),
(24, 'Juan David', 'Jose manuela', 'a', '2025-07-20 21:52:57', 'texto', '2025-07-20 19:49:50', 1),
(25, 'Juan David', 'Jose manuela', 'a', '2025-07-20 21:52:57', 'texto', '2025-07-20 19:49:50', 1),
(26, 'Juan David', 'Jose manuela', 'a', '2025-07-20 21:52:57', 'texto', '2025-07-20 19:49:50', 1),
(27, 'Jose manuela', 'Jhon', 'awdawdawd', '2025-07-20 22:08:55', 'texto', '2025-07-20 19:49:50', 0),
(28, 'Juan David', 'Michael de santa', 'aadawda', '2025-07-20 22:14:19', 'texto', '2025-07-20 19:49:50', 1),
(29, 'Jose manuela', 'Jhon', 'awdawdaw', '2025-07-20 22:18:34', 'texto', '2025-07-20 19:49:50', 0),
(30, 'Jose manuela', 'Juan David', 'DADAWDA', '2025-07-20 22:19:08', 'texto', '2025-07-20 19:49:50', 1),
(31, 'Juan David', 'Jose manuela', 'dada', '2025-07-20 22:42:36', 'texto', '2025-07-20 19:49:50', 1),
(32, 'Juan David', 'Jose manuela', 'aawdaw', '2025-07-20 22:42:37', 'texto', '2025-07-20 19:49:50', 1),
(33, 'Juan David', 'Jose manuela', 'Hola', '2025-07-20 22:45:27', 'texto', '2025-07-20 19:49:50', 1),
(34, 'Juan David', 'Michael de santa', 'HOLA', '2025-07-20 22:53:27', 'texto', '2025-07-20 19:49:50', 1),
(35, 'Juan David', 'Michael de santa', 'dawdawdwa', '2025-07-20 22:53:31', 'texto', '2025-07-20 19:49:50', 1),
(36, 'Juan David', 'Michael de santa', 'awdawdawd', '2025-07-20 22:53:32', 'texto', '2025-07-20 19:49:50', 1),
(37, 'Juan David', 'Michael de santa', 'awdawdawd', '2025-07-20 22:53:33', 'texto', '2025-07-20 19:49:50', 1),
(38, 'Juan David', 'Michael de santa', 'awdawaw', '2025-07-20 22:53:34', 'texto', '2025-07-20 19:49:50', 1),
(39, 'Juan David', 'Michael de santa', 'aa', '2025-07-20 22:53:35', 'texto', '2025-07-20 19:49:50', 1),
(40, 'Juan David', 'Michael de santa', 'a', '2025-07-20 22:53:35', 'texto', '2025-07-20 19:49:50', 1),
(41, 'Juan David', 'Michael de santa', 'a', '2025-07-20 22:53:35', 'texto', '2025-07-20 19:49:50', 1),
(42, 'Juan David', 'Michael de santa', 'a', '2025-07-20 22:53:36', 'texto', '2025-07-20 19:49:50', 1),
(43, 'Juan David', 'Michael de santa', 'aa', '2025-07-20 22:53:36', 'texto', '2025-07-20 19:49:50', 1),
(44, 'Juan David', 'Michael de santa', 'a', '2025-07-20 22:53:36', 'texto', '2025-07-20 19:49:50', 1),
(45, 'Juan David', 'Michael de santa', 'a', '2025-07-20 22:53:36', 'texto', '2025-07-20 19:49:50', 1),
(46, 'Juan David', 'Michael de santa', 'a', '2025-07-20 22:53:36', 'texto', '2025-07-20 19:49:50', 1),
(47, 'Juan David', 'Michael de santa', 'a', '2025-07-20 22:53:37', 'texto', '2025-07-20 19:49:50', 1),
(48, 'Juan David', 'Michael de santa', 'a', '2025-07-20 22:53:37', 'texto', '2025-07-20 19:49:50', 1),
(49, 'Juan David', 'Michael de santa', 'a', '2025-07-20 22:53:37', 'texto', '2025-07-20 19:49:50', 1),
(50, 'Juan David', 'Michael de santa', 'a', '2025-07-20 22:53:37', 'texto', '2025-07-20 19:49:50', 1),
(51, 'Juan David', 'Michael de santa', 'a', '2025-07-20 22:53:37', 'texto', '2025-07-20 19:49:50', 1),
(52, 'Juan David', 'Michael de santa', 'a', '2025-07-20 22:53:37', 'texto', '2025-07-20 19:49:50', 1),
(53, 'Juan David', 'Michael de santa', 'a', '2025-07-20 22:53:37', 'texto', '2025-07-20 19:49:50', 1),
(54, 'Juan David', 'Michael de santa', 'a', '2025-07-20 22:53:38', 'texto', '2025-07-20 19:49:50', 1),
(55, 'Juan David', 'Michael de santa', 'a', '2025-07-20 22:53:38', 'texto', '2025-07-20 19:49:50', 1),
(56, 'Juan David', 'Jose manuel', 'AWDWAJAWNDNAW', '2025-07-20 23:16:15', 'texto', '2025-07-20 19:49:50', 0),
(57, 'Juan David', 'Jose manuel', 'DAWMNDIAWDWA', '2025-07-20 23:16:16', 'texto', '2025-07-20 19:49:50', 0),
(58, 'Juan David', 'Jose manuel', 'NAWIDIAWNDW', '2025-07-20 23:16:17', 'texto', '2025-07-20 19:49:50', 0),
(59, 'Juan David', 'Jose manuel', 'adwadawdawaw', '2025-07-20 23:44:42', 'texto', '2025-07-20 19:49:50', 0),
(60, 'Juan David', 'Jose manuel', 'fwfafawfwa', '2025-07-20 23:44:44', 'texto', '2025-07-20 19:49:50', 0),
(61, 'Juan David', 'Jose manuel', 'afawfawf', '2025-07-20 23:44:47', 'texto', '2025-07-20 19:49:50', 0),
(62, 'Juan David', 'Jose manuel', 'wawdawdawwa', '2025-07-20 23:45:09', 'texto', '2025-07-20 19:49:50', 0),
(63, 'Juan David', 'Michael de santa', 'dwadawdawd', '2025-07-20 23:45:20', 'texto', '2025-07-20 19:49:50', 1),
(64, 'Juan David', 'Michael de santa', 'klllkl', '2025-07-20 23:45:24', 'texto', '2025-07-20 19:49:50', 1),
(65, 'Jose manuela', 'Juan David', 'adawda', '2025-07-21 00:58:12', 'texto', '2025-07-20 20:58:12', 1),
(66, 'Jose manuela', 'Juan David', 'awawdwa', '2025-07-21 00:58:16', 'texto', '2025-07-20 20:58:16', 1),
(67, 'Juan David', 'Jose manuela', 'Lol, no me digas', '2025-07-21 01:10:45', 'texto', '2025-07-20 21:10:45', 1),
(68, 'Juan David', 'Jose manuela', 'XD', '2025-07-21 01:10:47', 'texto', '2025-07-20 21:10:47', 1),
(69, 'Juan David', 'Jose manuela', 'Es que no', '2025-07-21 01:10:50', 'texto', '2025-07-20 21:10:50', 1),
(70, 'Juan David', 'Jose manuela', 'Lol', '2025-07-21 01:10:51', 'texto', '2025-07-20 21:10:51', 1),
(71, 'Juan David', 'Jose manuela', 'bueno si', '2025-07-21 01:10:53', 'texto', '2025-07-20 21:10:53', 1),
(72, 'Juan David', 'Jose manuela', 'pero no', '2025-07-21 01:10:55', 'texto', '2025-07-20 21:10:55', 1),
(73, 'Juan David', 'Jose manuela', 'Pero si', '2025-07-21 01:10:57', 'texto', '2025-07-20 21:10:57', 1),
(74, 'Juan David', 'Jose manuela', 'Pero no', '2025-07-21 01:11:00', 'texto', '2025-07-20 21:11:00', 1),
(75, 'Juan David', 'Jose manuela', 'Pero si', '2025-07-21 01:11:01', 'texto', '2025-07-20 21:11:01', 1),
(76, 'Juan David', 'Jose manuela', 'Pero no', '2025-07-21 01:11:03', 'texto', '2025-07-20 21:11:03', 1),
(77, 'Juan David', 'Jose manuela', 'XD', '2025-07-21 01:11:04', 'texto', '2025-07-20 21:11:04', 1),
(78, 'Jose manuela', 'Juan David', 'Hey shut up', '2025-07-21 01:11:18', 'texto', '2025-07-20 21:11:18', 1),
(79, 'Jose manuela', 'Juan David', 'What', '2025-07-21 01:11:40', 'texto', '2025-07-20 21:11:40', 1),
(80, 'Juan David', 'Jose manuela', 'No you shut up', '2025-07-21 01:11:47', 'texto', '2025-07-20 21:11:47', 1),
(81, 'Jose manuela', 'Juan David', 'En fin', '2025-07-21 01:12:04', 'texto', '2025-07-20 21:12:04', 1),
(82, 'Jose manuela', 'Juan David', 'Cosas de la vida', '2025-07-21 01:12:06', 'texto', '2025-07-20 21:12:06', 1),
(83, 'Juan David', 'Jhon', 'ahdhwadadhwada4', '2025-07-26 22:49:01', 'texto', '2025-07-26 18:49:01', 0),
(84, 'Jose manuela', 'Juan David', 'ahdjkwgkdagjdkgakjdgkjwjdgajwdkgwagdjkawduawpdja;dlawdj;awljdl;;awl;aw;jawfhfl;hawfhaw;lfhlawfwa', '2025-07-26 22:52:19', 'texto', '2025-07-26 18:52:19', 1),
(85, 'Jose manuela', 'Juan David', 'd', '2025-07-26 22:52:23', 'texto', '2025-07-26 18:52:23', 1),
(86, 'Jose manuela', 'Juan David', 'dawawd', '2025-07-26 22:52:25', 'texto', '2025-07-26 18:52:25', 1),
(87, 'Jose manuela', 'Juan David', 'dwadawdaw', '2025-07-26 22:52:26', 'texto', '2025-07-26 18:52:26', 1),
(88, 'Jose manuela', 'Juan David', 'dwdawdaw', '2025-07-26 22:52:27', 'texto', '2025-07-26 18:52:27', 1),
(89, 'Jose manuela', 'Juan David', 'wadawdaw', '2025-07-26 22:52:28', 'texto', '2025-07-26 18:52:28', 1),
(90, 'Jose manuela', 'Juan David', 'awdawd', '2025-07-26 22:52:29', 'texto', '2025-07-26 18:52:29', 1),
(91, 'Jose manuela', 'Juan David', 'Hola', '2025-07-27 00:45:37', 'texto', '2025-07-26 20:45:37', 1),
(92, 'Juan David', 'Jose manuel', 'dwdwwdwdw', '2025-07-27 16:16:33', 'texto', '2025-07-27 12:16:33', 0),
(93, 'Juan David', 'Jose manuel', 'dwdw', '2025-07-27 16:16:35', 'texto', '2025-07-27 12:16:35', 0),
(94, 'Juan David', 'Jose manuel', 'dwdwdw', '2025-07-27 16:16:36', 'texto', '2025-07-27 12:16:36', 0),
(95, 'Jose manuela', 'Juan David', 'lkk', '2025-07-27 16:32:34', 'texto', '2025-07-27 12:32:34', 1),
(96, 'Jose manuela', 'Jhon', 'aaa', '2025-07-27 17:07:29', 'texto', '2025-07-27 13:07:29', 0),
(97, 'Juan David', 'Jose manuela', 'nope', '2025-07-27 17:07:49', 'texto', '2025-07-27 13:07:49', 1),
(98, 'Juan David', 'Jhon', 'adawdaw', '2025-07-27 17:10:59', 'texto', '2025-07-27 13:10:59', 0),
(99, 'Juan David', 'Jose manuel', 'Hola', '2025-07-27 17:11:43', 'texto', '2025-07-27 13:11:43', 0),
(100, 'Juan David', 'Jose manuela', 'Hola bro', '2025-07-27 17:39:56', 'texto', '2025-07-27 13:39:56', 1),
(101, 'Juan David', 'Jose manuela', 'Como estas', '2025-07-27 17:40:02', 'texto', '2025-07-27 13:40:02', 1),
(102, 'Jose manuela', 'Juan David', 'jajdjwajdjawjdwa', '2025-07-27 21:50:32', 'texto', '2025-07-27 17:50:32', 1),
(103, 'Jose manuela', 'Jhon', 'JAJJWAJDJAWAWJWAJD', '2025-07-27 21:51:23', 'texto', '2025-07-27 17:51:23', 0),
(104, 'Jose manuela', 'Jhon', 'hahhwahawhdwa', '2025-07-27 21:51:25', 'texto', '2025-07-27 17:51:25', 0),
(105, 'Jose manuela', 'Jhon', 'JDWAJDAWJ', '2025-07-27 21:51:27', 'texto', '2025-07-27 17:51:27', 0),
(106, 'Jose manuela', 'Jhon', 'Hola', '2025-07-27 21:51:30', 'texto', '2025-07-27 17:51:30', 0),
(107, 'Jose manuela', 'Jhon', 'yggggghhkjkk', '2025-07-27 21:51:41', 'texto', '2025-07-27 17:51:41', 0),
(108, 'Manuel', 'Jhon', 'hahdahwhaw', '2025-07-27 23:25:13', 'texto', '2025-07-27 19:25:13', 0),
(109, 'Manuel', 'Michael de santa', 'adawdawdw', '2025-07-27 23:25:22', 'texto', '2025-07-27 19:25:22', 1),
(110, 'Juan David', 'Jose manuela', 'gfhfhrthfthfthft', '2025-07-28 19:57:07', 'texto', '2025-07-28 15:57:07', 1),
(111, 'Juan David', 'Jose manuela', 'fthfthfthfhfthfthfthfth', '2025-07-28 19:57:11', 'texto', '2025-07-28 15:57:11', 1),
(112, 'Juan David', 'Jose manuela', 'kkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkk', '2025-07-28 20:46:01', 'texto', '2025-07-28 16:46:01', 1),
(113, 'Juan David', 'Jose manuela', 'hahahhaaaaaaaaaaaaaahahahhaaaaaaaaaaaaaahahahhaaaaaaaaaaaaaahahahhaaaaaaaaaaaaaahahahhaaaaaaaaaaaaaahahahhaaaaaaaaaaaaaahahahhaaaaaaaaaaaaaahahahhaaaaaaaaaaaaaahahahhaaaaaaaaaaaaaahahahhaaaaaaaaaaaaaahahahhaaaaaaaaaaaaaahahahhaaaaaaaaaaaaaahahahhaaaaaaaaaaaaaahahahhaaaaaaaaaaaaaahahahhaaaaaaaaaaaaaahahahhaaaaaaaaaaaaaahahahhaaaaaaaaaaaaaahahahhaaaaaaaaaaaaaahahahhaaaaaaaaaaaaaahahahhaaaaaaaaaaaaaahahahhaaaaaaaaaaaaaahahahhaaaaaaaaaaaaaahahahhaaaaaaaaaaaaaahahahhaaaaaaaaaaaaaahahahhaaaaaaaaaaaaaahahahhaaaaaaaaaaaaaahahahhaaaaaaaaaaaaaahahahhaaaaaaaaaaaaaahahahhaaaaaaaaaaaaaahahahhaaaaaaaaaaaaaahahahhaaaaaaaaaaaaaahahahhaaaaaaaaaaaaaahahahhaaaaaaaaaaaaaahahahhaaaaaaaaaaaaaahahahhaaaaaaaaaaaaaahahahhaaaaaaaaaaaaaahahahhaaaaaaaaaaaaaahahahhaaaaaaaaaaaaaahahahhaaaaaaaaaaaaaahahahhaaaaaaaaaaaaaahahahhaaaaaaaaaaaaaahahahhaaaaaaaaaaaaaahahahhaaaaaaaaaaaaaahahahhaaaaaaaaaaaaaahahahhaaaaaaaaaaaaaahahahhaaaaaaaaaaaaaahahahhaaaaaaaaaaaaaahahahhaaaaaaaaaaaaaahahahhaaaaaaaaaaaaaahahahhaaaaaaaaaaaaaahahahhaaaaaaaaaaaaaahahahhaaaaaaaaaaaaaahahahhaaaaaaaaaaaaaahahahhaaaaaaaaaaaaaahahahhaaaaaaaaaaaaaahahahhaaaaaaaaaaaaaahahahhaaaaaaaaaaaaaa', '2025-07-28 20:46:14', 'texto', '2025-07-28 16:46:14', 1),
(114, 'Michael de santa', 'Manuel', 'hhghhhhh', '2025-08-04 15:26:44', 'texto', '2025-08-04 11:26:44', 1),
(115, 'Juan David', 'Michael de santa', 'akwjdjawjdwialldkhawldhjawdkhawkjhlawhjjñawhdkahwllkhawhkhklawlkhhawklhklawhklawhkaw', '2025-08-04 15:30:22', 'texto', '2025-08-04 11:30:22', 1),
(116, 'Juan David', 'Michael de santa', 'aawdawdawdw', '2025-08-04 15:30:24', 'texto', '2025-08-04 11:30:24', 1),
(117, 'Juan David', 'Michael de santa', 'awadawawadawdaw', '2025-08-04 15:30:26', 'texto', '2025-08-04 11:30:26', 1),
(118, 'Manuel', 'Michael de santa', 'iwiopwjlwjjwajdjklawkjkaw', '2025-08-04 15:31:07', 'texto', '2025-08-04 11:31:07', 1),
(119, 'Manuel', 'Michael de santa', 'awjdawjjawjdkjawdjkawñjaw', '2025-08-04 15:31:09', 'texto', '2025-08-04 11:31:09', 1),
(120, 'Manuel', 'Michael de santa', 'awkjdjawññjawkañwjñlawjlñdñw', '2025-08-04 15:31:10', 'texto', '2025-08-04 11:31:10', 1),
(121, 'Jose manuela', 'Juan David', 'ndwldhwlhjhwlhjwjhlkwhjlaw', '2025-08-04 15:34:16', 'texto', '2025-08-04 11:34:16', 1),
(122, 'Juan David', 'Jose manuela', 'uhwhhlw', '2025-08-04 15:34:44', 'texto', '2025-08-04 11:34:44', 1),
(123, 'Juan David', 'Jose manuela', 'wdhildwhwñhw', '2025-08-04 15:35:07', 'texto', '2025-08-04 11:35:07', 1),
(124, 'Juan David', 'Jose manuela', 'hghfhgfhfghfgh', '2025-08-04 15:35:31', 'texto', '2025-08-04 11:35:31', 1),
(125, 'Jose manuela', 'Juan David', 'thfthfhtfthfthtf', '2025-08-04 15:44:45', 'texto', '2025-08-04 11:44:45', 1),
(126, 'Jose manuela', 'Juan David', 'riytfukyyufyoyfoyfoufoyfyfopyfyfyulukyffyyfy\\', '2025-08-04 15:45:21', 'texto', '2025-08-04 11:45:21', 1),
(127, 'Jose manuela', 'Juan David', 'kglighgjlhkjlgghjlgkhjghkj', '2025-08-04 15:45:23', 'texto', '2025-08-04 11:45:23', 1),
(128, 'Jose manuela', 'Juan David', 'hvgglkgkl', '2025-08-04 15:45:24', 'texto', '2025-08-04 11:45:24', 1),
(129, 'Jose manuela', 'Juan David', 'kggkkgjgkj\\]oih\\77', '2025-08-04 16:02:48', 'texto', '2025-08-04 12:02:48', 1),
(130, 'Jose manuela', 'Juan David', 'dwwwawawawdaw', '2025-08-04 16:02:59', 'texto', '2025-08-04 12:02:59', 1),
(131, 'Juan David', 'Jose manuela', 'wwdwdwdwdw', '2025-08-04 16:06:30', 'texto', '2025-08-04 12:06:30', 1),
(132, 'Michael de santa', 'Juan David', 'jwjdiwiwjaawjjiawijjiaijawijawjiawijjaw', '2025-08-04 16:12:19', 'texto', '2025-08-04 12:12:19', 1),
(133, 'Jose manuela', 'Juan David', 'wdwdwdwadawdawdawdwa', '2025-08-04 16:12:50', 'texto', '2025-08-04 12:12:50', 1),
(134, 'Jose manuela', 'Juan David', 'dwddwdwdw', '2025-08-04 16:28:37', 'texto', '2025-08-04 12:28:37', 1),
(135, 'Jose manuela', 'Juan David', 'wwdwadwad', '2025-08-04 16:28:39', 'texto', '2025-08-04 12:28:39', 1),
(136, 'Jose manuela', 'Juan David', 'wdwdwdwdw', '2025-08-04 16:29:50', 'texto', '2025-08-04 12:29:50', 1),
(137, 'Jose manuela', 'Juan David', 'wdawwad', '2025-08-04 16:29:52', 'texto', '2025-08-04 12:29:52', 1),
(138, 'Jose manuela', 'Juan David', 'wdawawdawawdaw', '2025-08-04 16:32:49', 'texto', '2025-08-04 12:32:49', 1),
(139, 'Jose manuela', 'Juan David', 'a', '2025-08-04 16:32:57', 'texto', '2025-08-04 12:32:57', 1),
(140, 'Jose manuela', 'Juan David', 'aa', '2025-08-04 16:32:59', 'texto', '2025-08-04 12:32:59', 1),
(141, 'Jose manuela', 'Juan David', 'a', '2025-08-04 16:33:03', 'texto', '2025-08-04 12:33:03', 1),
(142, 'Jose manuela', 'Juan David', 'wdawawdwaawdw', '2025-08-04 16:35:16', 'texto', '2025-08-04 12:35:16', 1),
(143, 'Jose manuela', 'Juan David', 'aawdawd', '2025-08-04 16:35:18', 'texto', '2025-08-04 12:35:18', 1),
(144, 'Jose manuela', 'Juan David', 'dwadwawwdw', '2025-08-04 16:47:17', 'texto', '2025-08-04 12:47:17', 1),
(145, 'Juan David', 'Jose manuela', 'hiouhoyyhiolo', '2025-08-04 16:48:15', 'texto', '2025-08-04 12:48:15', 1),
(146, 'Juan David', 'Jose manuela', 'ihkgkgkhglgkj', '2025-08-04 16:48:26', 'texto', '2025-08-04 12:48:26', 1),
(147, 'Jose manuela', 'Juan David', 'hlhjlhkjhlkjhlkhljgkh', '2025-08-04 16:48:49', 'texto', '2025-08-04 12:48:49', 1),
(148, 'Jose manuela', 'Juan David', 'nmbkhbkbhkbj', '2025-08-04 16:49:54', 'texto', '2025-08-04 12:49:54', 1),
(149, 'Jose manuela', 'Juan David', 'hkhkjjj', '2025-08-04 16:50:16', 'texto', '2025-08-04 12:50:16', 1),
(150, 'Juan David', 'Jose manuela', 'Hola', '2025-08-04 16:54:49', 'texto', '2025-08-04 12:54:49', 1),
(151, 'Jose manuela', 'Jhon', 'Hola Jhon', '2025-08-04 16:55:04', 'texto', '2025-08-04 12:55:04', 0),
(152, 'Jose manuela', 'Juan David', 'Hola', '2025-08-04 16:55:15', 'texto', '2025-08-04 12:55:15', 1),
(153, 'Jose manuela', 'Juan David', 'Hola', '2025-08-04 16:56:07', 'texto', '2025-08-04 12:56:07', 1),
(154, 'Jose manuela', 'Juan David', 'Como estas', '2025-08-04 16:56:10', 'texto', '2025-08-04 12:56:10', 1),
(155, 'Juan David', 'Jose manuela', 'Todo bien bro', '2025-08-04 16:56:38', 'texto', '2025-08-04 12:56:38', 1),
(156, 'Jose manuela', 'Jhon', 'waawaw', '2025-08-04 16:56:44', 'texto', '2025-08-04 12:56:44', 0),
(157, 'Jose manuela', 'Jhon', 'HOLA', '2025-08-04 16:56:46', 'texto', '2025-08-04 12:56:46', 0),
(158, 'Jose manuela', 'Jhon', 'HOLA', '2025-08-04 16:56:47', 'texto', '2025-08-04 12:56:47', 0),
(159, 'Jose manuela', 'Jhon', 'HOLA', '2025-08-04 16:56:48', 'texto', '2025-08-04 12:56:48', 0),
(160, 'Jose manuela', 'Jhon', 'HOLA', '2025-08-04 16:56:48', 'texto', '2025-08-04 12:56:48', 0),
(161, 'Jose manuela', 'Juan David', 'Increible', '2025-08-04 16:57:05', 'texto', '2025-08-04 12:57:05', 1),
(162, 'Jose manuela', 'Juan David', 'akwjdaihwhawda', '2025-08-04 16:57:31', 'texto', '2025-08-04 12:57:31', 1),
(163, 'Jose manuela', 'Juan David', 'jwadoawodwaool', '2025-08-04 16:57:36', 'texto', '2025-08-04 12:57:36', 1),
(164, 'Juan David', 'Michael de santa', 'jlijwajklwawaklwahhlkwa', '2025-08-04 17:14:34', 'texto', '2025-08-04 13:14:34', 1),
(165, 'Juan David', 'Michael de santa', 'jdwjdjwadjawdwa', '2025-08-04 17:14:37', 'texto', '2025-08-04 13:14:37', 1),
(166, 'Juan David', 'Michael de santa', 'kdawdkawkwa', '2025-08-04 17:14:38', 'texto', '2025-08-04 13:14:38', 1),
(167, 'Jose manuela', 'Juan David', 'wdwahdkawgdlkwagiwa', '2025-08-04 22:14:58', 'texto', '2025-08-04 18:14:58', 1),
(168, 'Michael de santa', 'Juan David', 'wdaawoindawohiohawoihjohiawohiaw', '2025-08-04 22:17:35', 'texto', '2025-08-04 18:17:35', 1),
(169, 'Michael de santa', 'Juan David', 'awnidijawjijawijaw', '2025-08-04 22:17:36', 'texto', '2025-08-04 18:17:36', 1),
(170, 'Michael de santa', 'Juan David', 'awjdpjawjpjoawjofj\'a', '2025-08-04 22:17:37', 'texto', '2025-08-04 18:17:37', 1),
(171, 'Michael de santa', 'Juan David', 'awjdawj;jawjdj\'aw', '2025-08-04 22:17:38', 'texto', '2025-08-04 18:17:38', 1),
(172, 'Michael de santa', 'Juan David', 'awjawj\'', '2025-08-04 22:17:38', 'texto', '2025-08-04 18:17:38', 1),
(173, 'Michael de santa', 'Juan David', 'akwkaw', '2025-08-04 22:17:39', 'texto', '2025-08-04 18:17:39', 1),
(174, 'Michael de santa', 'Juan David', 'aw', '2025-08-04 22:17:39', 'texto', '2025-08-04 18:17:39', 1),
(175, 'Michael de santa', 'Juan David', 'aw', '2025-08-04 22:17:39', 'texto', '2025-08-04 18:17:39', 1),
(176, 'Michael de santa', 'Juan David', 'd', '2025-08-04 22:17:39', 'texto', '2025-08-04 18:17:39', 1),
(177, 'Michael de santa', 'Juan David', 'aw', '2025-08-04 22:17:39', 'texto', '2025-08-04 18:17:39', 1),
(178, 'Juan David', 'Jhon', 'hola buenas como esta', '2025-08-04 22:20:40', 'texto', '2025-08-04 18:20:40', 0),
(179, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:25', 'texto', '2025-08-04 18:27:25', 1),
(180, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:25', 'texto', '2025-08-04 18:27:25', 1),
(181, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:25', 'texto', '2025-08-04 18:27:25', 1),
(182, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:25', 'texto', '2025-08-04 18:27:25', 1),
(183, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:25', 'texto', '2025-08-04 18:27:25', 1),
(184, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:26', 'texto', '2025-08-04 18:27:26', 1),
(185, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:26', 'texto', '2025-08-04 18:27:26', 1),
(186, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:26', 'texto', '2025-08-04 18:27:26', 1),
(187, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:26', 'texto', '2025-08-04 18:27:26', 1),
(188, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:26', 'texto', '2025-08-04 18:27:26', 1),
(189, 'Michael de santa', 'Juan David', 'ss', '2025-08-04 22:27:27', 'texto', '2025-08-04 18:27:27', 1),
(190, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:27', 'texto', '2025-08-04 18:27:27', 1),
(191, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:27', 'texto', '2025-08-04 18:27:27', 1),
(192, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:28', 'texto', '2025-08-04 18:27:28', 1),
(193, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:28', 'texto', '2025-08-04 18:27:28', 1),
(194, 'Michael de santa', 'Juan David', 'ss', '2025-08-04 22:27:28', 'texto', '2025-08-04 18:27:28', 1),
(195, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:28', 'texto', '2025-08-04 18:27:28', 1),
(196, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:28', 'texto', '2025-08-04 18:27:28', 1),
(197, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:29', 'texto', '2025-08-04 18:27:29', 1),
(198, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:29', 'texto', '2025-08-04 18:27:29', 1),
(199, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:29', 'texto', '2025-08-04 18:27:29', 1),
(200, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:29', 'texto', '2025-08-04 18:27:29', 1),
(201, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:29', 'texto', '2025-08-04 18:27:29', 1),
(202, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:30', 'texto', '2025-08-04 18:27:30', 1),
(203, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:30', 'texto', '2025-08-04 18:27:30', 1),
(204, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:30', 'texto', '2025-08-04 18:27:30', 1),
(205, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:30', 'texto', '2025-08-04 18:27:30', 1),
(206, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:30', 'texto', '2025-08-04 18:27:30', 1),
(207, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:31', 'texto', '2025-08-04 18:27:31', 1),
(208, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:31', 'texto', '2025-08-04 18:27:31', 1),
(209, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:31', 'texto', '2025-08-04 18:27:31', 1),
(210, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:31', 'texto', '2025-08-04 18:27:31', 1),
(211, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:31', 'texto', '2025-08-04 18:27:31', 1),
(212, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:31', 'texto', '2025-08-04 18:27:31', 1),
(213, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:32', 'texto', '2025-08-04 18:27:32', 1),
(214, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:32', 'texto', '2025-08-04 18:27:32', 1),
(215, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:32', 'texto', '2025-08-04 18:27:32', 1),
(216, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:32', 'texto', '2025-08-04 18:27:32', 1),
(217, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:32', 'texto', '2025-08-04 18:27:32', 1),
(218, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:33', 'texto', '2025-08-04 18:27:33', 1),
(219, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:33', 'texto', '2025-08-04 18:27:33', 1),
(220, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:33', 'texto', '2025-08-04 18:27:33', 1),
(221, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:33', 'texto', '2025-08-04 18:27:33', 1),
(222, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:33', 'texto', '2025-08-04 18:27:33', 1),
(223, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:33', 'texto', '2025-08-04 18:27:33', 1),
(224, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:34', 'texto', '2025-08-04 18:27:34', 1),
(225, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:34', 'texto', '2025-08-04 18:27:34', 1),
(226, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:34', 'texto', '2025-08-04 18:27:34', 1),
(227, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:34', 'texto', '2025-08-04 18:27:34', 1),
(228, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:34', 'texto', '2025-08-04 18:27:34', 1),
(229, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:34', 'texto', '2025-08-04 18:27:34', 1),
(230, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:35', 'texto', '2025-08-04 18:27:35', 1),
(231, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:35', 'texto', '2025-08-04 18:27:35', 1),
(232, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:35', 'texto', '2025-08-04 18:27:35', 1),
(233, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:35', 'texto', '2025-08-04 18:27:35', 1),
(234, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:35', 'texto', '2025-08-04 18:27:35', 1),
(235, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:36', 'texto', '2025-08-04 18:27:36', 1),
(236, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:36', 'texto', '2025-08-04 18:27:36', 1),
(237, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:36', 'texto', '2025-08-04 18:27:36', 1),
(238, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:36', 'texto', '2025-08-04 18:27:36', 1),
(239, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:36', 'texto', '2025-08-04 18:27:36', 1),
(240, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:36', 'texto', '2025-08-04 18:27:36', 1),
(241, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:37', 'texto', '2025-08-04 18:27:37', 1),
(242, 'Michael de santa', 'Juan David', 'ss', '2025-08-04 22:27:37', 'texto', '2025-08-04 18:27:37', 1),
(243, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:37', 'texto', '2025-08-04 18:27:37', 1),
(244, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:37', 'texto', '2025-08-04 18:27:37', 1),
(245, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:38', 'texto', '2025-08-04 18:27:38', 1),
(246, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:38', 'texto', '2025-08-04 18:27:38', 1),
(247, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:38', 'texto', '2025-08-04 18:27:38', 1),
(248, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:38', 'texto', '2025-08-04 18:27:38', 1),
(249, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:38', 'texto', '2025-08-04 18:27:38', 1),
(250, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:38', 'texto', '2025-08-04 18:27:38', 1),
(251, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:39', 'texto', '2025-08-04 18:27:39', 1),
(252, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:39', 'texto', '2025-08-04 18:27:39', 1),
(253, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:39', 'texto', '2025-08-04 18:27:39', 1),
(254, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:39', 'texto', '2025-08-04 18:27:39', 1),
(255, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:40', 'texto', '2025-08-04 18:27:40', 1),
(256, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:40', 'texto', '2025-08-04 18:27:40', 1),
(257, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:40', 'texto', '2025-08-04 18:27:40', 1),
(258, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:40', 'texto', '2025-08-04 18:27:40', 1),
(259, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:40', 'texto', '2025-08-04 18:27:40', 1),
(260, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:41', 'texto', '2025-08-04 18:27:41', 1),
(261, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:41', 'texto', '2025-08-04 18:27:41', 1),
(262, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:41', 'texto', '2025-08-04 18:27:41', 1),
(263, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:41', 'texto', '2025-08-04 18:27:41', 1),
(264, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:41', 'texto', '2025-08-04 18:27:41', 1),
(265, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:42', 'texto', '2025-08-04 18:27:42', 1),
(266, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:42', 'texto', '2025-08-04 18:27:42', 1),
(267, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:42', 'texto', '2025-08-04 18:27:42', 1),
(268, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:42', 'texto', '2025-08-04 18:27:42', 1),
(269, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:42', 'texto', '2025-08-04 18:27:42', 1),
(270, 'Michael de santa', 'Juan David', 'ss', '2025-08-04 22:27:43', 'texto', '2025-08-04 18:27:43', 1),
(271, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:43', 'texto', '2025-08-04 18:27:43', 1),
(272, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:43', 'texto', '2025-08-04 18:27:43', 1),
(273, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:43', 'texto', '2025-08-04 18:27:43', 1),
(274, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:44', 'texto', '2025-08-04 18:27:44', 1),
(275, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:44', 'texto', '2025-08-04 18:27:44', 1),
(276, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:44', 'texto', '2025-08-04 18:27:44', 1),
(277, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:44', 'texto', '2025-08-04 18:27:44', 1),
(278, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:44', 'texto', '2025-08-04 18:27:44', 1),
(279, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:44', 'texto', '2025-08-04 18:27:44', 1),
(280, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:45', 'texto', '2025-08-04 18:27:45', 1),
(281, 'Michael de santa', 'Juan David', 'ss', '2025-08-04 22:27:45', 'texto', '2025-08-04 18:27:45', 1),
(282, 'Michael de santa', 'Juan David', 'sss', '2025-08-04 22:27:45', 'texto', '2025-08-04 18:27:45', 1),
(283, 'Michael de santa', 'Juan David', 'sss', '2025-08-04 22:27:47', 'texto', '2025-08-04 18:27:47', 1),
(284, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:48', 'texto', '2025-08-04 18:27:48', 1),
(285, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:48', 'texto', '2025-08-04 18:27:48', 1),
(286, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:48', 'texto', '2025-08-04 18:27:48', 1),
(287, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:48', 'texto', '2025-08-04 18:27:48', 1),
(288, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:49', 'texto', '2025-08-04 18:27:49', 1),
(289, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:49', 'texto', '2025-08-04 18:27:49', 1),
(290, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:49', 'texto', '2025-08-04 18:27:49', 1),
(291, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:49', 'texto', '2025-08-04 18:27:49', 1),
(292, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:50', 'texto', '2025-08-04 18:27:50', 1),
(293, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:50', 'texto', '2025-08-04 18:27:50', 1),
(294, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:50', 'texto', '2025-08-04 18:27:50', 1),
(295, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:51', 'texto', '2025-08-04 18:27:51', 1),
(296, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:51', 'texto', '2025-08-04 18:27:51', 1),
(297, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:51', 'texto', '2025-08-04 18:27:51', 1),
(298, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:51', 'texto', '2025-08-04 18:27:51', 1),
(299, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:51', 'texto', '2025-08-04 18:27:51', 1),
(300, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:52', 'texto', '2025-08-04 18:27:52', 1),
(301, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:52', 'texto', '2025-08-04 18:27:52', 1),
(302, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:52', 'texto', '2025-08-04 18:27:52', 1),
(303, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:52', 'texto', '2025-08-04 18:27:52', 1),
(304, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:53', 'texto', '2025-08-04 18:27:53', 1),
(305, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:53', 'texto', '2025-08-04 18:27:53', 1),
(306, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:53', 'texto', '2025-08-04 18:27:53', 1),
(307, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:53', 'texto', '2025-08-04 18:27:53', 1),
(308, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:53', 'texto', '2025-08-04 18:27:53', 1),
(309, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:54', 'texto', '2025-08-04 18:27:54', 1),
(310, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:54', 'texto', '2025-08-04 18:27:54', 1),
(311, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:54', 'texto', '2025-08-04 18:27:54', 1),
(312, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:54', 'texto', '2025-08-04 18:27:54', 1),
(313, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:54', 'texto', '2025-08-04 18:27:54', 1),
(314, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:54', 'texto', '2025-08-04 18:27:54', 1),
(315, 'Michael de santa', 'Juan David', 'ss', '2025-08-04 22:27:55', 'texto', '2025-08-04 18:27:55', 1),
(316, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:55', 'texto', '2025-08-04 18:27:55', 1),
(317, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:55', 'texto', '2025-08-04 18:27:55', 1),
(318, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:55', 'texto', '2025-08-04 18:27:55', 1),
(319, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:56', 'texto', '2025-08-04 18:27:56', 1),
(320, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:56', 'texto', '2025-08-04 18:27:56', 1),
(321, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:56', 'texto', '2025-08-04 18:27:56', 1),
(322, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:56', 'texto', '2025-08-04 18:27:56', 1),
(323, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:56', 'texto', '2025-08-04 18:27:56', 1),
(324, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:56', 'texto', '2025-08-04 18:27:56', 1),
(325, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:57', 'texto', '2025-08-04 18:27:57', 1),
(326, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:57', 'texto', '2025-08-04 18:27:57', 1),
(327, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:57', 'texto', '2025-08-04 18:27:57', 1),
(328, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:57', 'texto', '2025-08-04 18:27:57', 1),
(329, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:57', 'texto', '2025-08-04 18:27:57', 1),
(330, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:57', 'texto', '2025-08-04 18:27:57', 1),
(331, 'Michael de santa', 'Juan David', 'ss', '2025-08-04 22:27:58', 'texto', '2025-08-04 18:27:58', 1),
(332, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:58', 'texto', '2025-08-04 18:27:58', 1),
(333, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:58', 'texto', '2025-08-04 18:27:58', 1),
(334, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:58', 'texto', '2025-08-04 18:27:58', 1),
(335, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:58', 'texto', '2025-08-04 18:27:58', 1),
(336, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:58', 'texto', '2025-08-04 18:27:58', 1),
(337, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:59', 'texto', '2025-08-04 18:27:59', 1),
(338, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:59', 'texto', '2025-08-04 18:27:59', 1),
(339, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:59', 'texto', '2025-08-04 18:27:59', 1),
(340, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:27:59', 'texto', '2025-08-04 18:27:59', 1),
(341, 'Michael de santa', 'Juan David', 'ss', '2025-08-04 22:28:00', 'texto', '2025-08-04 18:28:00', 1),
(342, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:28:00', 'texto', '2025-08-04 18:28:00', 1),
(343, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:28:00', 'texto', '2025-08-04 18:28:00', 1),
(344, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:28:00', 'texto', '2025-08-04 18:28:00', 1),
(345, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:28:00', 'texto', '2025-08-04 18:28:00', 1),
(346, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:28:00', 'texto', '2025-08-04 18:28:00', 1),
(347, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:28:01', 'texto', '2025-08-04 18:28:01', 1),
(348, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:28:01', 'texto', '2025-08-04 18:28:01', 1),
(349, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:28:01', 'texto', '2025-08-04 18:28:01', 1),
(350, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:28:01', 'texto', '2025-08-04 18:28:01', 1),
(351, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:28:01', 'texto', '2025-08-04 18:28:01', 1),
(352, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:28:01', 'texto', '2025-08-04 18:28:01', 1),
(353, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:28:01', 'texto', '2025-08-04 18:28:01', 1),
(354, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:28:01', 'texto', '2025-08-04 18:28:01', 1),
(355, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:28:02', 'texto', '2025-08-04 18:28:02', 1),
(356, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:28:02', 'texto', '2025-08-04 18:28:02', 1),
(357, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:28:02', 'texto', '2025-08-04 18:28:02', 1),
(358, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:28:02', 'texto', '2025-08-04 18:28:02', 1),
(359, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:28:02', 'texto', '2025-08-04 18:28:02', 1),
(360, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:28:02', 'texto', '2025-08-04 18:28:02', 1),
(361, 'Michael de santa', 'Juan David', 's', '2025-08-04 22:28:02', 'texto', '2025-08-04 18:28:02', 1),
(362, 'Mauricio Guillermo Alejandro Sebastián', 'Juan David', 'hola', '2025-08-04 22:32:22', 'texto', '2025-08-04 18:32:22', 1),
(363, 'Mauricio Guillermo Alejandro Sebastián', 'Juan David', 'como esta', '2025-08-04 22:34:33', 'texto', '2025-08-04 18:34:33', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notificaciones`
--

CREATE TABLE `notificaciones` (
  `id` int(11) NOT NULL,
  `usuario_destino` varchar(100) DEFAULT NULL,
  `tipo` varchar(50) DEFAULT NULL,
  `mensaje` text DEFAULT NULL,
  `url` text DEFAULT NULL,
  `leida` tinyint(1) DEFAULT 0,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(37, 'Juan David', 'JuandavidMRT@gmail.com', '$2y$10$GNmlEJxDueuKYj4ZdUibD.be1IsMrrIxgVD1Ngu.FHXwfRuwkuQmK', 'uploads/perfiles/perfil_685c203d2730e.png', 'img/perfiles/fondo_Juan David_190253-1.jpg'),
(38, 'Juan', 'JuandavidMsT@gmail.com', '$2y$10$BMZlp2hi.Q3hENu9rhTkd.GO9w4dX21SKL7thPJVX5HNOmRZD3dhO', 'uploads/perfiles/perfil_68596612d601e.png', 'img/perfiles/fondo_Juan_Ccff7r Screenshot 2025.02.21 - 19.16.55.13.png'),
(39, 'Juan David Santana', 'Juandavid2RT@gmail.com', '$2y$10$I7VTSFgFaN0MnY3CrOxctOLsrL2WsUL3JwwS4JsdPqdmIipOECQPW', 'uploads/perfiles/perfil_685967ac83680.png', 'img/perfiles/fondo_Juan David Santana_Death Stranding Screenshot 2024.11.28 - 21.04.26.22.png'),
(40, 'Michael de santa', 'Michaelds@gmail.com', '$2y$10$HuFzzZOVUABj/9kGcJMyUuonD44U/h9KuAUlwLHLAKvGRankTa9Pm', 'uploads/perfiles/perfil_685c235e6dfe1.png', 'img/perfiles/fondo_Michael de santa_nduksi52zrs41.webp'),
(41, 'Jhon', 'Jhon@gmail.com', '$2y$10$rmo8BFjR3f0qB9CC5ZzFNuhUhOrywirMBCrr338h1uUUFujOsnk32', 'uploads/perfiles/perfil_685c357d34fce.jpg', 'img/perfiles/fondo_Jhon_landscape-photography-settings-164919.png'),
(42, 'Manuel', 'iwi@gmail.com', '$2y$10$XHzo43SqAnrkPKrwngkS5.FbR1nKaxqumORVSFhzIOj/y9Mme4Cte', NULL, NULL),
(43, 'awdawdaw', 'q39ztt294@mozmail.com', '$2y$10$9d9SAEU/fM6iHCxiaqWYFemkjhQ/J28mV0w/NQLul9sqezHuzEJWK', NULL, NULL),
(44, 'Jose manuel', 'JAUDNAWDNA@gmail.com', '$2y$10$Na0Koz7FhBKAld2/hnKfj.7OQn1s.gCeVSKh2IhnSrDwLHoRQN6jO', NULL, NULL),
(45, 'Jose manuela', 'JAJAJA@gmaill.com', '$2y$10$ogc2DAJSEU/cXaekqWlrpOws5VZVrkR7xdY.NxbYOBMewoykVmqn.', NULL, NULL),
(46, 'Holabuenas', 'Holabuneas@gmail.com', '$2y$10$31V7RI9bMEu3c1hTbeJ8EOY9gz0DbXtWVxA7cDkazfZdFNqqzYN2y', NULL, NULL),
(47, 'Juan David WOW', 'Juanwow@gmail.com', '$2y$10$0Pjn.Q1piVuea02siLPLzeq..NFgOAq9K6btiHGci45.KWNmOyDZ6', NULL, NULL),
(48, 'Mauricio Guillermo Alejandro Sebastián', 'maurio@gmail.com', '$2y$10$.4EWJbkRJR5WPsccHvmJ7OQxCQKopr.cplkDAKe7dsQZGTFw5k.VO', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `rentas`
--

CREATE TABLE `rentas` (
  `id` int(11) NOT NULL,
  `auto_id` int(11) NOT NULL,
  `cliente` varchar(100) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(3, 'Juan David', 'Juan David', 1, '2025-07-13 01:28:21'),
(4, 'Juan', 'Juan', 4, '2025-06-23 14:36:41'),
(5, 'Juan David Santana', 'Juan David Santana', 4, '2025-06-23 14:41:59'),
(6, 'Michael de santa', 'Michael de santa', 3, '2025-06-25 16:36:32'),
(7, 'Juan David', 'Michael de santa', 4, '2025-06-25 16:37:10'),
(8, 'Jhon', 'Juan David', 5, '2025-07-12 17:33:40'),
(9, 'Michael de santa', 'Juan David', 2, '2025-07-12 17:33:31'),
(10, 'awdawdaw', 'awdawdaw', 4, '2025-07-13 01:34:33'),
(11, 'Manuel', 'Manuel', 2, '2025-07-13 02:50:01');

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
(13, 8, 'Manuel', 2, '2025-07-09 16:01:24'),
(14, 7, 'Manuel', 5, '2025-07-13 02:49:54'),
(15, 12, 'Juan David', 4, '2025-07-21 13:52:35'),
(16, 11, 'Manuel', 5, '2025-07-21 13:57:49'),
(17, 13, 'Juan David', 4, '2025-07-27 00:10:40'),
(18, 15, 'Juan David', 5, '2025-07-27 00:17:34'),
(19, 13, 'Michael de santa', 1, '2025-07-27 00:20:17'),
(20, 14, 'Michael de santa', 4, '2025-07-27 00:20:27'),
(21, 17, 'Jose manuela', 4, '2025-07-27 00:46:42'),
(22, 8, 'Jose manuela', 4, '2025-07-27 00:47:48'),
(23, 16, 'Manuel', 2, '2025-07-27 23:25:02'),
(24, 17, 'Juan David', 2, '2025-07-29 15:54:08'),
(25, 16, 'Juan David', 4, '2025-08-04 17:21:06'),
(26, 12, 'Jose manuela', 3, '2025-08-04 17:37:49'),
(27, 18, 'Jose manuela', 4, '2025-08-04 17:39:48');

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
-- Indexes for table `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registro`
--
ALTER TABLE `registro`
  ADD PRIMARY KEY (`ID_Registro`);

--
-- Indexes for table `rentas`
--
ALTER TABLE `rentas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `auto_id` (`auto_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `denuncias`
--
ALTER TABLE `denuncias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `mensajes`
--
ALTER TABLE `mensajes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=364;

--
-- AUTO_INCREMENT for table `notificaciones`
--
ALTER TABLE `notificaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `registro`
--
ALTER TABLE `registro`
  MODIFY `ID_Registro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `rentas`
--
ALTER TABLE `rentas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `valoraciones`
--
ALTER TABLE `valoraciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `valorarauto`
--
ALTER TABLE `valorarauto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `rentas`
--
ALTER TABLE `rentas`
  ADD CONSTRAINT `rentas_ibfk_1` FOREIGN KEY (`auto_id`) REFERENCES `autos` (`id`);

--
-- Constraints for table `valorarauto`
--
ALTER TABLE `valorarauto`
  ADD CONSTRAINT `valorarauto_ibfk_1` FOREIGN KEY (`id_auto`) REFERENCES `autos` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
