-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: mysql-servercpeiot.alwaysdata.net
-- Generation Time: Jan 15, 2021 at 12:42 AM
-- Server version: 10.5.5-MariaDB
-- PHP Version: 7.2.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `servercpeiot_simulation`
--

-- --------------------------------------------------------

--
-- Table structure for table `Feu`
--

CREATE TABLE `Feu` (
  `id_feu` int(11) NOT NULL,
  `intensite` int(11) NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date DEFAULT NULL,
  `id_position` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Feu`
--

INSERT INTO `Feu` (`id_feu`, `intensite`, `date_debut`, `date_fin`, `id_position`) VALUES
(184, 8, '2021-01-14', NULL, 181);

-- --------------------------------------------------------

--
-- Table structure for table `Position`
--

CREATE TABLE `Position` (
  `id_position` int(11) NOT NULL,
  `positionX` varchar(20) NOT NULL,
  `positionY` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Position`
--

INSERT INTO `Position` (`id_position`, `positionX`, `positionY`) VALUES
(184, '45.72', '4.89'),
(181, '45.73', '4.77'),
(182, '45.75', '4.85'),
(185, '45.76', '4.81'),
(183, '45.76', '4.93');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Feu`
--
ALTER TABLE `Feu`
  ADD PRIMARY KEY (`id_feu`),
  ADD UNIQUE KEY `UQ_id_pos` (`id_position`),
  ADD KEY `Feu_fk0` (`id_position`);

--
-- Indexes for table `Position`
--
ALTER TABLE `Position`
  ADD PRIMARY KEY (`id_position`),
  ADD UNIQUE KEY `positionX` (`positionX`,`positionY`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Feu`
--
ALTER TABLE `Feu`
  MODIFY `id_feu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=185;

--
-- AUTO_INCREMENT for table `Position`
--
ALTER TABLE `Position`
  MODIFY `id_position` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=186;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Feu`
--
ALTER TABLE `Feu`
  ADD CONSTRAINT `Feu_fk0` FOREIGN KEY (`id_position`) REFERENCES `Position` (`id_position`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
