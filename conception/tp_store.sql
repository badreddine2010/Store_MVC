-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 22, 2020 at 08:52 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.2.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tp_store`
--

-- --------------------------------------------------------
DROP DATABASE IF EXISTS tp_store;

CREATE DATABASE tp_store;

USE tp_store;

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'Fruits'),
(2, 'Légumes'),
(3, 'Boissons');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id_prod` int(11) NOT NULL,
  `name` text NOT NULL,
  `category_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id_prod`, `name`, `category_id`, `quantity`, `unit_price`) VALUES
(1,'Orange', 1,8, 2.25),
(2,'Banane',1,7, 1.75),
(3,'Pomme de terre',2,5 , 1.45),
(4,'Tomate', 2,4, 2.23),
(5,'Soda', 3,3,0.98),
(6,'eau',3,7, 0.55);


CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nom` varchar(150) NOT NULL,
  `prenom` varchar(150) NOT NULL,
  `email` varchar(200) NOT NULL,
  `passwd` varchar(180) NOT NULL,
  `statut` int(11) NOT NULL
  
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `user` (`id`, `nom`, `prenom`, `email`, `passwd`,`statut`) VALUES
(1,'Durand', 'Alain','durand.alain@gmail.com', '123',1),
(2,'Dupont', 'Eric','dupont.eric@gmail.com', '123',2),
(3,'Smith', 'Adam','smith.adam@gmail.com', '123',2);


CREATE TABLE `user_statut` (
  `id` int(11) NOT NULL,
  `nom` varchar(150) NOT NULL
  
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


INSERT INTO `user_statut` (`id`, `nom`) VALUES
(1,'Admin'),
(2,'Costumer');

--
-- Structure de la table `commande`
--

CREATE TABLE IF NOT EXISTS `commande` (
  `id_commande` int(3) NOT NULL AUTO_INCREMENT,
  `ref_commande` varchar(150) NOT NULL,
  `id_user` int(3) DEFAULT NULL,
  `montant` float(6) NOT NULL,
  `date_enregistrement` date NOT NULL,
  `etat` enum('en cours de traitement','envoyé','livré') NOT NULL,
  PRIMARY KEY (`id_commande`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `commande`
--


-- --------------------------------------------------------

--
-- Structure de la table `details_commande`
--

CREATE TABLE IF NOT EXISTS `details_commande` (
  `id_details_commande` int(3) NOT NULL AUTO_INCREMENT,
  `id_commande` int(3) DEFAULT NULL,
  `id_produit` int(3) DEFAULT NULL,
  `designation` varchar(250) NOT NULL,
  `quantite` int(3) NOT NULL,
  `prix` float(6) NOT NULL,
  PRIMARY KEY (`id_details_commande`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;


-- --------------------------------------------------------

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id_prod`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `user_statut`
  ADD PRIMARY KEY (`id`);
--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id_prod` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

  -- AUTO_INCREMENT for table `user_statut`
--
ALTER TABLE `user_statut`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Contraintes pour la table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `products` (`id_prod`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
