-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Creato il: Mag 23, 2026 alle 17:10
-- Versione del server: 8.0.45
-- Versione PHP: 8.0.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `my_smiccafe`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `products`
--

CREATE TABLE `products` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `available` tinyint(1) DEFAULT '1',
  `price` float DEFAULT '0',
  `category` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `products`
--

INSERT INTO `products` (`id`, `name`, `create_at`, `available`, `price`, `category`) VALUES
(3, 'Cappuccino', '2026-05-06 16:29:11', 1, 2.5, 'Caffetteria'),
(4, 'Espresso', '2026-05-06 16:29:11', 1, 1.2, 'Caffetteria'),
(5, 'Latte Macchiato', '2026-05-06 16:29:11', 1, 2.8, 'Caffetteria'),
(6, 'Caffè Americano', '2026-05-06 16:29:11', 1, 2, 'Caffetteria'),
(7, 'Orzo', '2026-05-06 16:29:11', 1, 2.2, 'Caffetteria'),
(8, 'Acqua Naturale', '2026-05-06 16:29:11', 1, 1, 'Bevande'),
(9, 'Acqua Frizzante', '2026-05-06 16:29:11', 1, 1, 'Bevande'),
(10, 'Coca Cola', '2026-05-06 16:29:11', 1, 2.5, 'Bevande'),
(11, 'Fanta', '2026-05-06 16:29:11', 1, 2.5, 'Bevande'),
(12, 'Tè Freddo', '2026-05-06 16:29:11', 1, 2.5, 'Bevande'),
(13, 'Gelato Cioccolato', '2026-05-06 16:31:55', 1, 3, 'Gelati'),
(14, 'Gelato Vaniglia', '2026-05-06 16:31:55', 1, 3, 'Gelati'),
(15, 'Gelato Fragola', '2026-05-06 16:31:55', 1, 3, 'Gelati'),
(16, 'Gelato Pistacchio', '2026-05-06 16:31:55', 1, 3.5, 'Gelati'),
(17, 'Gelato Nocciola', '2026-05-06 16:31:55', 1, 3.5, 'Gelati'),
(18, 'Gelato Stracciatella', '2026-05-06 16:31:55', 1, 3.5, 'Gelati'),
(19, 'Gelato Limone', '2026-05-06 16:31:55', 1, 3, 'Gelati'),
(20, 'Gelato Mango', '2026-05-06 16:31:55', 1, 3.5, 'Gelati'),
(21, 'Gelato Cocco', '2026-05-06 16:31:55', 1, 3.5, 'Gelati'),
(22, 'Gelato Amarena', '2026-05-06 16:31:55', 1, 3.5, 'Gelati'),
(23, 'Coppa Gelato Piccola', '2026-05-06 16:31:55', 1, 4, 'Gelati'),
(24, 'Coppa Gelato Grande', '2026-05-06 16:31:55', 1, 5.5, 'Gelati'),
(25, 'Cono Gelato Piccolo', '2026-05-06 16:31:55', 1, 3, 'Gelati'),
(26, 'Cono Gelato Grande', '2026-05-06 16:31:55', 1, 4.5, 'Gelati'),
(27, 'Affogato al Caffè', '2026-05-06 16:31:55', 1, 4.5, 'Gelati'),
(28, 'Gelato Kinder', '2026-05-06 16:31:55', 1, 4, 'Gelati'),
(29, 'Gelato Nutella', '2026-05-06 16:31:55', 1, 4, 'Gelati'),
(30, 'Gelato Yogurt', '2026-05-06 16:31:55', 1, 3.5, 'Gelati'),
(31, 'Sorbetto Limone', '2026-05-06 16:31:55', 1, 3, 'Gelati'),
(32, 'Sorbetto Fragola', '2026-05-06 16:31:55', 1, 3, 'Gelati');

-- --------------------------------------------------------

--
-- Struttura della tabella `users`
--

CREATE TABLE `users` (
  `uuid` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `name` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_general_ci,
  `phone` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `users`
--

INSERT INTO `users` (`uuid`, `email`, `password`, `name`, `address`, `phone`, `created_at`) VALUES
('69fb6fd88d593', 'john@example.com', '$2y$10$MaLed4hoEf5TjYiv/apioeg/ORK6QUeVfKiRKoSxAB9b54OGlnHfW', 'John Doe', '123 Main St', '555-1234', '2026-05-06 16:44:08');

-- --------------------------------------------------------

--
-- Struttura della tabella `variants`
--

CREATE TABLE `variants` (
  `id` int NOT NULL,
  `id_product` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `available` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uuid`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indici per le tabelle `variants`
--
ALTER TABLE `variants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_product` (`id_product`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT per la tabella `variants`
--
ALTER TABLE `variants`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `variants`
--
ALTER TABLE `variants`
  ADD CONSTRAINT `variants_ibfk_1` FOREIGN KEY (`id_product`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
