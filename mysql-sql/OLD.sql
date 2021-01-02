-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: mysqldb
-- Gegenereerd op: 07 dec 2020 om 21:21
-- Serverversie: 5.7.31
-- PHP-versie: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ticketswap`
--
DROP DATABASE IF EXISTS `ticketswap`;
CREATE DATABASE IF NOT EXISTS `ticketswap` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `ticketswap`;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `artists`
--

DROP TABLE IF EXISTS `artists`;
CREATE TABLE `artists` (
  `artist_id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `description` varchar(255) NOT NULL,
  `age` varchar(45) NOT NULL,
  `country` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `events`
--

DROP TABLE IF EXISTS `events`;
CREATE TABLE `events` (
  `event_id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `ticketprice_standard` float NOT NULL,
  `begin_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `location` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `events`
--

INSERT INTO `events` (`event_id`, `name`, `ticketprice_standard`, `begin_time`, `end_time`, `location`, `description`) VALUES
(1, 'Pukkelpop', 200, '2020-08-01 15:48:43', '2020-12-09 15:48:43', 'Geen idee', 'Dit is een test evenement'),
(2, 'Werchter', 340, '2020-12-01 15:48:43', '2020-12-09 15:48:43', 'Werchter', 'Dit is nog een test event'),
(3, 'TestEvent', 200, '2020-08-01 15:48:43', '2020-12-09 15:48:43', 'Knokke', 'Dit is een test evenement'),
(5, 'Jonathan', 500, '2020-12-02 15:02:01', '2020-12-17 15:02:01', 'Zelzate', 'sdfghjy;jgdsfdfngdhhgvbv '),
(6, 'Nog ene test', 750, '2021-01-28 15:02:01', '2021-01-30 15:02:01', 'Antwerpen', 'sdlfnjoqsfjvb'),
(7, 'Jonathan', 500, '2020-12-02 15:02:01', '2020-12-17 15:02:01', 'Zelzate', 'sdfghjy;jgdsfdfngdhhgvbv '),
(8, 'Laatste event', 1500, '2021-01-28 15:02:01', '2021-01-30 15:02:01', 'Antwerpen', 'sdlfnjoqsfjvb');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `events_has_artists`
--

DROP TABLE IF EXISTS `events_has_artists`;
CREATE TABLE `events_has_artists` (
  `event_id` int(11) NOT NULL,
  `artist_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `tickets`
--

DROP TABLE IF EXISTS `tickets`;
CREATE TABLE `tickets` (
  `ticket_id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `ticket_price` float NOT NULL,
  `amount` int(11) NOT NULL,
  `sale_reason` varchar(45) NOT NULL,
  `event_id` int(11) NOT NULL,
  `transaction_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `transactions`
--

DROP TABLE IF EXISTS `transactions`;
CREATE TABLE `transactions` (
  `transaction_id` int(11) NOT NULL,
  `date_transaction` datetime NOT NULL,
  `seller_id` int(11) NOT NULL,
  `buyer_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` char(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `users`
--

INSERT INTO `users` (`user_id`, `email`, `password`) VALUES
(1, 'jonathan@jon-it.be', '$2y$10$UkdaZpTirdlhj615SOw8f.3cxriaXGWDMtWY0iLRCwmAtFGTVNON2'),
(2, 'pat1@pat.com', '$2y$10$EFUCfhgNzRKoeZmNTrEi4.RnsG6tQFXoixWZ4qRox27JUl6LVtmsy'),
(3, 'laurens.decock@odisee.be', '$2y$10$DBTN8XzQVNM1yiAHLmbBDODglsRN5QXQ7hSgqA/h3p7Y8PWPaM/gS'),
(4, 'pat1@gmail.com', '$2y$10$R4RGuHLe.74bRgHEC7H2t.m1ZXe2ucOD3p4fZLKGlnTq2VGiXmfq6');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `user_data`
--

DROP TABLE IF EXISTS `user_data`;
CREATE TABLE `user_data` (
  `user_id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `last_name` varchar(45) NOT NULL,
  `friends_invited` int(11) DEFAULT NULL,
  `tickets_sold` int(11) DEFAULT NULL,
  `tickets_bought` varchar(45) DEFAULT NULL,
  `address` varchar(45) NOT NULL,
  `city` varchar(45) NOT NULL,
  `country` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `artists`
--
ALTER TABLE `artists`
  ADD PRIMARY KEY (`artist_id`);

--
-- Indexen voor tabel `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`event_id`);

--
-- Indexen voor tabel `events_has_artists`
--
ALTER TABLE `events_has_artists`
  ADD PRIMARY KEY (`event_id`,`artist_id`),
  ADD KEY `fk_events_has_artists_artists1_idx` (`artist_id`),
  ADD KEY `fk_events_has_artists_events1_idx` (`event_id`);

--
-- Indexen voor tabel `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`ticket_id`),
  ADD KEY `fk_tickets_events1_idx` (`event_id`),
  ADD KEY `fk_tickets_transactions1_idx` (`transaction_id`);

--
-- Indexen voor tabel `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `fk_transactions_users1_idx` (`seller_id`),
  ADD KEY `fk_transactions_users2_idx` (`buyer_id`);

--
-- Indexen voor tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexen voor tabel `user_data`
--
ALTER TABLE `user_data`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `fk_user_data_users1_idx` (`user_id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `artists`
--
ALTER TABLE `artists`
  MODIFY `artist_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT voor een tabel `tickets`
--
ALTER TABLE `tickets`
  MODIFY `ticket_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `transactions`
--
ALTER TABLE `transactions`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `events_has_artists`
--
ALTER TABLE `events_has_artists`
  ADD CONSTRAINT `fk_events_has_artists_artists1` FOREIGN KEY (`artist_id`) REFERENCES `artists` (`artist_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_events_has_artists_events1` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Beperkingen voor tabel `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `fk_tickets_events1` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tickets_transactions1` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`transaction_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Beperkingen voor tabel `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `fk_transactions_users1` FOREIGN KEY (`seller_id`) REFERENCES `users` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_transactions_users2` FOREIGN KEY (`buyer_id`) REFERENCES `users` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Beperkingen voor tabel `user_data`
--
ALTER TABLE `user_data`
  ADD CONSTRAINT `fk_user_data_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
