-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 11 dec 2018 om 11:32
-- Serverversie: 10.1.37-MariaDB
-- PHP-versie: 7.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `myvending`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `about`
--

CREATE TABLE `about` (
  `id` int(11) NOT NULL,
  `img` text NOT NULL,
  `title` text NOT NULL,
  `text` text NOT NULL,
  `facebook` text NOT NULL,
  `instagram` text NOT NULL,
  `linkedin` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `about`
--

INSERT INTO `about` (`id`, `img`, `title`, `text`, `facebook`, `instagram`, `linkedin`) VALUES
(1, 'max.jpg', 'Max van den Boom', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa.', 'https://www.facebook.com/max.vandenboom.1', 'https://www.instagram.com/maxvdboom1/', ''),
(2, 'maarten.jpg', 'Maarten Jakobs', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa.', 'https://www.facebook.com/maarten.jakobs14', 'https://www.instagram.com/maarten.jakobs/', '');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `categories`
--

CREATE TABLE `categories` (
  `id` int(255) NOT NULL,
  `name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Drinken'),
(2, 'Eten'),
(3, 'Aanwezig');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `filters`
--

CREATE TABLE `filters` (
  `id` int(255) NOT NULL,
  `name` text NOT NULL,
  `type` text NOT NULL,
  `query` text NOT NULL,
  `extra` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `filters`
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

CREATE TABLE `mycard` (
  `id` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `product_id` int(255) NOT NULL,
  `vending_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `mycard`
--

INSERT INTO `mycard` (`id`, `user_id`, `product_id`, `vending_id`) VALUES
(63, 0, 3, 1),
(67, 0, 2, 1),
(68, 0, 3, 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `products`
--

CREATE TABLE `products` (
  `id` int(255) NOT NULL,
  `name` text NOT NULL,
  `price` decimal(5,2) NOT NULL,
  `img` text NOT NULL,
  `background` text NOT NULL,
  `cat_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `img`, `background`, `cat_id`) VALUES
(1, 'Red Bull The Blue Edition', '1.99', 'https://static-images.jumbo.com/product_images/126884BLK-1_360x360.png', '#4b60a9', 1),
(2, 'Red Bull The Yellow Edition', '1.99', 'https://static-images.jumbo.com/product_images/154921BLK-1_360x360.png', '#fbd171', 1),
(3, 'Coca-Cola', '0.70', 'https://static-images.jumbo.com/product_images/510416BLK-1_360x360.png', '#da1317c7', 1),
(4, 'Autodrop Cadillacs ', '1.50', 'https://static-images.jumbo.com/product_images/168169DS-1_360x360.png', '#e95258d6', 2),
(5, 'M&M\'s Chocolate Minis', '0.40', 'https://static-images.jumbo.com/product_images/124582ZK-1_360x360.png', '#4d2e21e6', 2),
(6, 'Fuze Tea Black Tea Peach Hibiscus', '1.00', 'https://static-images.jumbo.com/product_images/100820181445_196524FLS-1_360x360.png', '#e56c7b', 1),
(7, 'Fuze Tea Green Tea', '1.00', 'https://static-images.jumbo.com/product_images/100820181445_196522FLS-1_360x360.png', '#e5e445', 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `transactions`
--

CREATE TABLE `transactions` (
  `id` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `price` decimal(4,2) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `product_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `transactions`
--

INSERT INTO `transactions` (`id`, `user_id`, `price`, `date`, `product_id`) VALUES
(5, 5, '1.00', '2018-12-05 10:33:52', 6),
(6, 5, '1.00', '2018-12-05 12:29:08', 6),
(7, 5, '1.00', '2018-12-05 12:29:58', 4),
(8, 5, '1.00', '2018-12-05 12:29:58', 6),
(9, 5, '1.00', '2018-12-07 08:26:38', 6),
(10, 5, '1.00', '2018-12-07 08:28:12', 6),
(11, 5, '1.00', '2018-12-07 08:29:05', 6),
(12, 5, '1.00', '2018-12-07 08:30:08', 6),
(13, 5, '1.00', '2018-12-07 08:30:39', 6),
(14, 5, '1.00', '2018-12-07 08:31:27', 6),
(15, 5, '1.00', '2018-12-07 08:32:28', 6),
(16, 5, '1.00', '2018-12-07 08:32:55', 6),
(17, 5, '1.00', '2018-12-07 08:33:28', 6),
(18, 5, '1.00', '2018-12-07 08:33:49', 6),
(19, 5, '1.00', '2018-12-07 08:37:20', 6);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `user_password` varchar(100) NOT NULL,
  `user_email` varchar(500) NOT NULL,
  `user_rank` int(11) NOT NULL,
  `user_forgotpasscode` text NOT NULL,
  `user_credit` decimal(4,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_password`, `user_email`, `user_rank`, `user_forgotpasscode`, `user_credit`) VALUES
(5, 'maarten', '005147622d52a589c71d48564cabc35e', 'maarten.jakobs@gmail.com', 0, '', '59.00');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `vendingassortiment`
--

CREATE TABLE `vendingassortiment` (
  `id` int(255) NOT NULL,
  `machine_id` int(255) NOT NULL,
  `product_id` int(255) NOT NULL,
  `position` int(2) NOT NULL,
  `stock` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `vendingassortiment`
--

INSERT INTO `vendingassortiment` (`id`, `machine_id`, `product_id`, `position`, `stock`) VALUES
(1, 2, 1, 11, 0),
(2, 1, 2, 13, 10),
(3, 1, 3, 15, 10),
(4, 1, 4, 17, 9),
(5, 1, 6, 42, -18);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `vendingmachines`
--

CREATE TABLE `vendingmachines` (
  `id` int(255) NOT NULL,
  `name` text NOT NULL,
  `lat` text NOT NULL,
  `long` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `vendingmachines`
--

INSERT INTO `vendingmachines` (`id`, `name`, `lat`, `long`) VALUES
(1, 'ROC Ter AA', '51.486370', '5.657790'),
(2, 'Helmond Station', '51.475680', '5.661700');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `about`
--
ALTER TABLE `about`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `filters`
--
ALTER TABLE `filters`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `mycard`
--
ALTER TABLE `mycard`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexen voor tabel `vendingassortiment`
--
ALTER TABLE `vendingassortiment`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `vendingmachines`
--
ALTER TABLE `vendingmachines`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `about`
--
ALTER TABLE `about`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT voor een tabel `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT voor een tabel `filters`
--
ALTER TABLE `filters`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT voor een tabel `mycard`
--
ALTER TABLE `mycard`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT voor een tabel `products`
--
ALTER TABLE `products`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT voor een tabel `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT voor een tabel `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT voor een tabel `vendingassortiment`
--
ALTER TABLE `vendingassortiment`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT voor een tabel `vendingmachines`
--
ALTER TABLE `vendingmachines`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
