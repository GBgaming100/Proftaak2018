-- phpMyAdmin SQL Dump
-- version 4.0.4.2
-- http://www.phpmyadmin.net
--
-- Machine: localhost
-- Genereertijd: 20 nov 2018 om 14:50
-- Serverversie: 5.6.13
-- PHP-versie: 5.4.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databank: `myvending`
--
CREATE DATABASE IF NOT EXISTS `myvending` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `myvending`;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `about`
--

CREATE TABLE IF NOT EXISTS `about` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `img` text NOT NULL,
  `title` text NOT NULL,
  `text` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Gegevens worden uitgevoerd voor tabel `about`
--

INSERT INTO `about` (`id`, `img`, `title`, `text`) VALUES
(1, 'img/about/max.jpg', 'Max van den Boom', 'Gangsters uit Gmert'),
(2, 'img/about/maarten.jpg', 'Maarten Jakobs', 'Die gast die alles heeft gemaakt\r\n'),
(3, 'img/about/rocteraa.jpeg', 'ROC Ter-AA', 'Die ene school waar je alles zelf moet doen');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Gegevens worden uitgevoerd voor tabel `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Drinken'),
(2, 'Eten'),
(3, 'Aanwezig');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `filters`
--

CREATE TABLE IF NOT EXISTS `filters` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `type` text NOT NULL,
  `query` text NOT NULL,
  `extra` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Gegevens worden uitgevoerd voor tabel `filters`
--

INSERT INTO `filters` (`id`, `name`, `type`, `query`, `extra`) VALUES
(1, 'Naam a/z', 'filter', 'ORDER BY p.name ASC', 'checked'),
(2, 'Naam z/a', 'filter', 'ORDER BY p.name DESC', ''),
(3, 'Prijs laag/hoog', 'filter', 'ORDER BY p.price ASC', ''),
(4, 'Prijs hoog/laag', 'filter', 'ORDER BY p.price DESC', '');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `mycard`
--

CREATE TABLE IF NOT EXISTS `mycard` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `user_id` int(255) NOT NULL,
  `product_id` int(255) NOT NULL,
  `vending_id` int(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=76 ;

--
-- Gegevens worden uitgevoerd voor tabel `mycard`
--

INSERT INTO `mycard` (`id`, `user_id`, `product_id`, `vending_id`) VALUES
(63, 0, 3, 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `price` decimal(5,2) NOT NULL,
  `img` text NOT NULL,
  `background` text NOT NULL,
  `cat_id` int(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Gegevens worden uitgevoerd voor tabel `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `img`, `background`, `cat_id`) VALUES
(1, 'Red Bull The Blue Edition', '1.99', 'https://static-images.jumbo.com/product_images/126884BLK-1_360x360.png', '#4b60a9', 1),
(2, 'Red Bull The Yellow Edition', '1.99', 'https://static-images.jumbo.com/product_images/154921BLK-1_360x360.png', '#fbd171', 1),
(3, 'Coca-Cola', '0.70', 'https://static-images.jumbo.com/product_images/510416BLK-1_360x360.png', '#da1317c7', 1),
(4, 'Autodrop Cadillacs ', '1.50', 'https://static-images.jumbo.com/product_images/168169DS-1_360x360.png', '#e95258d6', 2),
(5, 'M&M''s Chocolate Minis', '0.40', 'https://static-images.jumbo.com/product_images/124582ZK-1_360x360.png', '#4d2e21e6', 2),
(6, 'Fuze Tea Black Tea Peach Hibiscus', '1.00', 'https://static-images.jumbo.com/product_images/100820181445_196524FLS-1_360x360.png', '#e56c7b', 1),
(7, 'Fuze Tea Green Tea', '1.00', 'https://static-images.jumbo.com/product_images/100820181445_196522FLS-1_360x360.png', '#e5e445', 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(100) NOT NULL,
  `user_password` varchar(100) NOT NULL,
  `user_email` varchar(500) NOT NULL,
  `user_rank` int(11) NOT NULL,
  `user_forgotpasscode` text NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Gegevens worden uitgevoerd voor tabel `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_password`, `user_email`, `user_rank`, `user_forgotpasscode`) VALUES
(5, 'maarten', '005147622d52a589c71d48564cabc35e', 'maarten.jakobs@gmail.com', 0, '');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `vendingassortiment`
--

CREATE TABLE IF NOT EXISTS `vendingassortiment` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `machine_id` int(255) NOT NULL,
  `product_id` int(255) NOT NULL,
  `position` int(2) NOT NULL,
  `stock` int(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Gegevens worden uitgevoerd voor tabel `vendingassortiment`
--

INSERT INTO `vendingassortiment` (`id`, `machine_id`, `product_id`, `position`, `stock`) VALUES
(1, 2, 1, 11, 0),
(2, 1, 2, 13, 10),
(3, 1, 3, 15, 10),
(4, 1, 4, 17, 10);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `vendingmachines`
--

CREATE TABLE IF NOT EXISTS `vendingmachines` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Gegevens worden uitgevoerd voor tabel `vendingmachines`
--

INSERT INTO `vendingmachines` (`id`, `name`) VALUES
(1, 'ROC Ter AA'),
(2, 'Helmond Station');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
