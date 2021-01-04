-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: mysqldb
-- Generation Time: Jan 04, 2021 at 10:18 AM
-- Server version: 5.7.31
-- PHP Version: 7.4.9

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

-- --------------------------------------------------------

--
-- Table structure for table `artists`
--

CREATE TABLE `artists` (
  `artist_id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `description` varchar(255) NOT NULL,
  `age` varchar(45) NOT NULL,
  `country` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

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
-- Dumping data for table `events`
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
-- Table structure for table `events_has_artists`
--

CREATE TABLE `events_has_artists` (
  `event_id` int(11) NOT NULL,
  `artist_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `ticket_id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `ticket_price` float NOT NULL,
  `amount` int(11) NOT NULL,
  `sale_reason` varchar(45) NOT NULL,
  `event_id` int(11) NOT NULL,
  `transaction_id` int(11) DEFAULT NULL,
  `seller_id` int(11) NOT NULL,
  `ticket_type` enum('Combiticket','Dagticket','Concert','') NOT NULL DEFAULT 'Concert'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`ticket_id`, `name`, `ticket_price`, `amount`, `sale_reason`, `event_id`, `transaction_id`, `seller_id`, `ticket_type`) VALUES
(1, 'Combiticket Pukkelpop', 350, 1, 'Deze datum kan ik niet aanwezig zijn', 1, 1, 1, 'Combiticket'),
(2, 'Combiticket Werchter ', 350, 1, 'Deze datum kan ik niet aanwezig zijn', 2, 4, 1, 'Combiticket');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `transaction_id` int(11) NOT NULL,
  `date_transaction` datetime NOT NULL,
  `seller_id` int(11) NOT NULL,
  `buyer_id` int(11) DEFAULT NULL,
  `ticket_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`transaction_id`, `date_transaction`, `seller_id`, `buyer_id`, `ticket_id`) VALUES
(1, '2021-01-03 17:39:35', 1, 14, 1),
(3, '2021-01-01 12:07:26', 14, 1, 4),
(4, '2020-12-09 00:04:17', 1, 14, 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` char(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `email`, `password`) VALUES
(1, 'jonathan@jon-it.be', '$2y$10$UkdaZpTirdlhj615SOw8f.3cxriaXGWDMtWY0iLRCwmAtFGTVNON2'),
(2, 'pat1@pat.com', '$2y$10$EFUCfhgNzRKoeZmNTrEi4.RnsG6tQFXoixWZ4qRox27JUl6LVtmsy'),
(13, 'a@a.a', '$2y$10$L2dAhvI3z44wTRcg2q2cGOc5Il39d/YZjJzDkonjXlNwCgvg/hLse'),
(14, 'moise.vankeymeulen@student.odisee.be', '$2y$10$psjOr5Eq.R7cISgUiSOh1esqrf/Eg5QDQPu6fK.ZW6xxPfOsgB/Lu');

-- --------------------------------------------------------

--
-- Table structure for table `user_data`
--

CREATE TABLE `user_data` (
  `user_id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL DEFAULT 'Naamloos',
  `last_name` varchar(45) DEFAULT 'Doe',
  `friends_invited` int(11) DEFAULT NULL,
  `tickets_sold` int(11) DEFAULT NULL,
  `tickets_bought` varchar(45) DEFAULT NULL,
  `address` varchar(45) DEFAULT NULL,
  `city` varchar(45) DEFAULT NULL,
  `country` varchar(45) DEFAULT NULL,
  `data_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_data`
--

INSERT INTO `user_data` (`user_id`, `name`, `last_name`, `friends_invited`, `tickets_sold`, `tickets_bought`, `address`, `city`, `country`, `data_id`) VALUES
(1, 'Jonathan', 'De Mangelaere', 2, 5, '2', 'Rue du Commerce 32', 'Mamer', 'Luxembourg', 1),
(2, '', '', NULL, NULL, NULL, '', '', '', 3),
(13, 'Naamloos', 'Doe', NULL, NULL, NULL, NULL, NULL, NULL, 6),
(14, 'Naamloos', 'Doe', NULL, NULL, NULL, NULL, NULL, NULL, 7);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `artists`
--
ALTER TABLE `artists`
  ADD PRIMARY KEY (`artist_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `events_has_artists`
--
ALTER TABLE `events_has_artists`
  ADD PRIMARY KEY (`event_id`,`artist_id`),
  ADD KEY `fk_events_has_artists_artists1_idx` (`artist_id`),
  ADD KEY `fk_events_has_artists_events1_idx` (`event_id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`ticket_id`),
  ADD KEY `fk_tickets_events1_idx` (`event_id`),
  ADD KEY `fk_tickets_transactions1_idx` (`transaction_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `fk_transactions_users1_idx` (`seller_id`),
  ADD KEY `fk_transactions_users2_idx` (`buyer_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_data`
--
ALTER TABLE `user_data`
  ADD PRIMARY KEY (`data_id`),
  ADD KEY `fk_user_data_users1_idx` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `artists`
--
ALTER TABLE `artists`
  MODIFY `artist_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `ticket_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `user_data`
--
ALTER TABLE `user_data`
  MODIFY `data_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `events_has_artists`
--
ALTER TABLE `events_has_artists`
  ADD CONSTRAINT `fk_events_has_artists_artists1` FOREIGN KEY (`artist_id`) REFERENCES `artists` (`artist_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_events_has_artists_events1` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `fk_tickets_events1` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tickets_transactions1` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`transaction_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `fk_transactions_users1` FOREIGN KEY (`seller_id`) REFERENCES `users` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_transactions_users2` FOREIGN KEY (`buyer_id`) REFERENCES `users` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `user_data`
--
ALTER TABLE `user_data`
  ADD CONSTRAINT `fk_user_data_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
