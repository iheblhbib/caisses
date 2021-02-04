-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : sam. 26 déc. 2020 à 00:21
-- Version du serveur :  10.4.14-MariaDB
-- Version de PHP : 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `testing4`
--

-- --------------------------------------------------------

--
-- Structure de la table `chargejour`
--

CREATE TABLE `chargejour` (
  `id` int(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `coutm` decimal(10,2) NOT NULL,
  `coutj` decimal(10,2) NOT NULL,
  `totalem` decimal(10,2) NOT NULL,
  `totalj` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `chargejour`
--

INSERT INTO `chargejour` (`id`, `name`, `coutm`, `coutj`, `totalem`, `totalj`) VALUES
(1, 'exp', '10.00', '0.33', '43.00', '1.43'),
(2, 'popopp', '22.00', '0.73', '43.00', '1.43'),
(3, NULL, '11.00', '0.37', '43.00', '1.43');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `chargejour`
--
ALTER TABLE `chargejour`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `chargejour`
--
ALTER TABLE `chargejour`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
