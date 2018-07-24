-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 24, 2018 at 04:56 AM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 5.6.35

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tss`
--

--
-- Dumping data for table `salud_estado_glosas`
--

INSERT INTO `salud_estado_glosas` (`ID`, `Estado_glosa`, `idUser`, `Updated`, `Sync`) VALUES
(1, 'Glosada', 5, '2018-07-17 23:08:42', '0000-00-00 00:00:00'),
(2, 'Glosa Respondida', 5, '2018-07-17 23:08:42', '0000-00-00 00:00:00'),
(3, 'Glosa Contra Glosada', 5, '2018-07-17 23:08:42', '0000-00-00 00:00:00'),
(4, 'Glosa Contra glosada respondida', 5, '2018-07-17 23:08:42', '0000-00-00 00:00:00'),
(5, 'Glosa Conciliada', 5, '2018-07-17 23:08:42', '0000-00-00 00:00:00'),
(6, 'Glosa X Conciliar', 5, '2018-07-20 00:12:11', '0000-00-00 00:00:00'),
(7, 'Glosa Aceptada', 5, '2018-07-17 23:08:42', '0000-00-00 00:00:00'),
(8, 'Radicada Cxc', 5, '2018-07-17 23:08:42', '0000-00-00 00:00:00'),
(9, 'Devolucion', 5, '2018-07-17 23:08:42', '0000-00-00 00:00:00'),
(10, 'Devolucion Corregida', 5, '2018-07-17 23:08:42', '0000-00-00 00:00:00'),
(11, 'Pagada', 1, '2018-07-18 14:22:53', '0000-00-00 00:00:00');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
