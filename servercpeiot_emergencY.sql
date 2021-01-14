-- phpMyAdmin SQL Dump
-- version OVH
-- https://www.phpmyadmin.net/
--
-- Hôte : nassimkfcolocat.mysql.db
-- Généré le :  ven. 15 jan. 2021 à 00:46
-- Version du serveur :  5.6.50-log
-- Version de PHP :  7.3.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `nassimkfcolocat`
--

-- --------------------------------------------------------

--
-- Structure de la table `Camion`
--

CREATE TABLE `Camion` (
  `id_camion` int(11) NOT NULL,
  `positionX_camion` float NOT NULL,
  `positionY_camion` float NOT NULL,
  `immatriculation` varchar(10) NOT NULL,
  `capacite` int(11) NOT NULL,
  `id_feu` int(11) DEFAULT NULL,
  `id_caserne` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `Camion`
--

INSERT INTO `Camion` (`id_camion`, `positionX_camion`, `positionY_camion`, `immatriculation`, `capacite`, `id_feu`, `id_caserne`) VALUES
(1, 45.6994, 4.80032, '666-6BR', 8, 2467, 2),
(2, 45.746, 4.84718, '666-BRR', 6, 2469, 3),
(3, 45.7122, 4.97647, '909-BRR', 4, 2470, 2);

-- --------------------------------------------------------

--
-- Structure de la table `Caserne`
--

CREATE TABLE `Caserne` (
  `id_caserne` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `positionX_caserne` float NOT NULL,
  `positionY_caserne` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `Caserne`
--

INSERT INTO `Caserne` (`id_caserne`, `nom`, `positionX_caserne`, `positionY_caserne`) VALUES
(1, 'CASERNE DE MEYZIEU', 45.7706, 4.98805),
(2, 'CASERNE DE GENAS', 45.7207, 4.98538),
(3, 'CASERNE DE LYON 03', 45.7628, 4.84393),
(4, 'CASERNE DE VILLEURBANNE', 45.7788, 4.87832);

-- --------------------------------------------------------

--
-- Structure de la table `Feu`
--

CREATE TABLE `Feu` (
  `id_feu` int(11) NOT NULL,
  `intensite` int(11) NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date DEFAULT NULL,
  `id_position` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `Position`
--

CREATE TABLE `Position` (
  `id_position` int(11) NOT NULL,
  `positionX` varchar(20) NOT NULL,
  `positionY` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `Camion`
--
ALTER TABLE `Camion`
  ADD PRIMARY KEY (`id_camion`),
  ADD UNIQUE KEY `immatriculation` (`immatriculation`),
  ADD KEY `Camion_fk0` (`id_feu`),
  ADD KEY `Camion_fk1` (`id_caserne`);

--
-- Index pour la table `Caserne`
--
ALTER TABLE `Caserne`
  ADD PRIMARY KEY (`id_caserne`),
  ADD UNIQUE KEY `positionX_caserne` (`positionX_caserne`,`positionY_caserne`);

--
-- Index pour la table `Feu`
--
ALTER TABLE `Feu`
  ADD PRIMARY KEY (`id_feu`),
  ADD UNIQUE KEY `UNQ_id_position` (`id_position`),
  ADD KEY `Feu_fk0` (`id_position`);

--
-- Index pour la table `Position`
--
ALTER TABLE `Position`
  ADD PRIMARY KEY (`id_position`),
  ADD UNIQUE KEY `positionX` (`positionX`,`positionY`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `Camion`
--
ALTER TABLE `Camion`
  MODIFY `id_camion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `Caserne`
--
ALTER TABLE `Caserne`
  MODIFY `id_caserne` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `Feu`
--
ALTER TABLE `Feu`
  MODIFY `id_feu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2718;

--
-- AUTO_INCREMENT pour la table `Position`
--
ALTER TABLE `Position`
  MODIFY `id_position` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2829;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
