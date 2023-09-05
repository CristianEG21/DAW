-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 22, 2022 at 02:59 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `practicaunidad5`
--
CREATE DATABASE IF NOT EXISTS `plantilla` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `plantilla`;

-- --------------------------------------------------------

--
-- Table structure for table `jugadores`
--

DROP TABLE IF EXISTS `jugadores`;
CREATE TABLE `jugadores` (
  `id` int(11) NOT NULL,
  `nombre` varchar(40) NOT NULL,
  `apellidos` varchar(60) NOT NULL,
  `dorsal` int(11) DEFAULT NULL,
  `posicion` enum('Portero','Defensa','Lateral Izquierdo','Lateral Derecho','Central','Delantero') DEFAULT NULL,
  `barcode` varchar(13) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jugadores`
--

INSERT INTO `jugadores` (`id`, `nombre`, `apellidos`, `dorsal`, `posicion`, `barcode`) VALUES
(32, 'Omar', 'Aparicio Zayas', 43, 'Delantero', '7149149443583'),
(33, 'Rodrigo', 'Tovar Ordoñez', 7, 'Central', '9596524604066'),
(34, 'Nicolás', 'Pedraza Alarcón', 52, 'Defensa', '5416037585161'),
(35, 'Óscar', 'Lázaro Riera', 50, 'Delantero', '6072821611141'),
(36, 'Eduardo', 'Zamudio Vigil', 22, 'Portero', '4258912636831'),
(37, 'Nadia', 'Caraballo Delafuente', 58, 'Delantero', '3130272381747'),
(38, 'Guillem', 'Vega Esparza', 18, 'Lateral Derecho', '8967958930808'),
(39, 'Ander', 'Meléndez Luna', 10, 'Delantero', '8362258370314'),
(40, 'Nerea', 'Carranza Cobo', 55, 'Lateral Derecho', '8395007293480'),
(41, 'Josefa', 'Aguado Méndez', 49, 'Lateral Derecho', '2960244817087'),
(42, 'Amparo', 'Angulo Bermejo', 20, 'Lateral Izquierdo', '4544652186690'),
(43, 'David', 'Gálvez Berríos', 1, 'Portero', '6167027817791'),
(44, 'Ismael', 'Luevano Urrutia', 34, 'Portero', '4612767883992'),
(45, 'Laura', 'Pantoja Barajas', 15, 'Delantero', '4738124275115'),
(46, 'Ángel', 'Llamas Rodarte', 27, 'Lateral Derecho', '6049803135322'),
(47, 'Juan', 'Pérez', 45, 'Defensa', '0221379857242'),
(48, 'Juan', 'Pérez', 2, 'Portero', '6140352248287'),
(49, 'Juan', 'Ruiz', 5, 'Lateral Izquierdo', '0107310575409');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jugadores`
--
ALTER TABLE `jugadores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `barcode` (`barcode`),
  ADD UNIQUE KEY `dorsal` (`dorsal`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jugadores`
--
ALTER TABLE `jugadores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
