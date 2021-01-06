-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: mysqldb
-- Generation Time: Jan 06, 2021 at 01:40 AM
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
CREATE DATABASE IF NOT EXISTS `ticketswap` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `ticketswap`;

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

--
-- Dumping data for table `artists`
--

INSERT INTO `artists` (`artist_id`, `name`, `description`, `age`, `country`) VALUES
(1, 'Bastille', 'Bastille is een Britse alternatieve-rockband uit Londen. Het kwartet bestaat, naast Dan Smith, uit Chris Wood, Kyle Simmons en Will Farquarson.', '34', 'UK'),
(2, 'Muse', 'Muse is een Britse rockband uit Teignmouth die in 1994 is opgericht. De band bestaat uit zanger, gitarist en pianist Matthew Bellamy, drummer Dominic Howard en bassist Christopher Wolstenholme.', '42', 'UK'),
(3, 'Twenty One Pilots', 'De band werd in 2009 gevormd en bestond toen uit Tyler Joseph, Nick Thomas en Chris Salih. In 2011 zijn Thomas en Salih weggegaan en vervangen door Josh Dun.', '32', 'USA'),
(4, 'Headhunterz', 'Willem Rebergen (geboren op 12 september 1985), beter bekend onder zijn artiestennaam Headhunterz, is een Nederlandse DJ en muziekproducent. Rebergen is ook een stemacteur.', '35', 'Nederland'),
(5, 'AJR', 'AJR is een Amerikaanse indiepop-band bestaande uit de multi-instrumentalistische broers Adam, Jack en Ryan Met. De band is een popgroep die z\'n eigen nummers schrijft, produceert en mixt in de woonkamer van hun appartement in Chelsea.', '30', 'USA'),
(6, 'Panic! at the Disco', 'Panic! at the Disco werd onder de naam \"Pat Salamander\" opgericht door Ryan Ross en Spencer Smith. Ze speelden covers van Blink-182, met Brent Wilson en hun vriend Trevor. Later kwam ook zanger Brendon Urie bij de band.', '33', 'USA'),
(7, 'Zedd', 'Zedd, artiestennaam van Anton Zaslavski (Saratov, Rusland, 2 september 1989), is een Russisch-Duits producer en dj van Russische komaf. Hij produceert vooral electrohousemuziek, maar ook, progressive house, complextro en dubstep.', '31', 'Rusland'),
(8, 'John Williams', 'John Towner Williams (New York, 8 februari 1932) is een Amerikaans componist van filmmuziek.Bekende films waar hij de muziek voor schreef zijn: Star Wars, Superman, Indiana Jones, Jaws, Jurassic Park en de Harry Potter-films.', '88', 'USA'),
(9, 'Fox Stevenson', 'Stanley Stevenson Byrne, beter bekend onder zijn artiestennaam Fox Stevenson (voorheen Stan SB, Leeds, 25 januari 1993) is een Engels singer-songwriter en producer van indie elektronische dancemuziek.', '27', 'UK'),
(10, 'Dimitri Vegas & Like Mike', 'Dimitri Vegas & Like Mike (DV&LM) is een Belgisch dj- en producerduo, bestaande uit de twee broers Dimitri Thivaios en Michael Thivaios. In 2015 en 2019 behaalden zij de nummer 1-positie in de jaarlijkse DJ Mag top 100.', '38', 'België'),
(11, 'Lewis Capaldi', 'Lewis Marc Capaldi (Whitburn (West Lothian), 7 oktober 1996) is een Schotse singer-songwriter. Eind 2018 scoorde hij een nummer-één-hit in de Engelse hitlijsten met Someone you loved. Ook in Nederland en Vlaanderen haalde deze single de hitlijsten.', '24', 'UK'),
(12, 'Snow Patrol', 'Snow Patrol is een Noord-Ierse/Schotse alternatieve-rockband, bestaande uit voorman Gary Lightbody (zanger, songwriter en gitarist), Scot Paul Wilson, Nathan Connolly, Tom Simpson en Jonny Quinn.\r\n\r\n', '44', 'Noord-Ierland'),
(13, 'The streets', 'Mike Skinner (Barnet, 27 november 1978), beter bekend als The Streets, is een Britse rapper en muzikant. The Streets is tevens de naam van het muzikale project dat door Skinner geleid werd.', '42', 'UK'),
(14, 'Red Hot Chili Peppers', 'Red Hot Chili Peppers is een Amerikaanse band die funk, rap, punk en pop combineert met rock. De band is in 1983 opgericht in de Californische stad Los Angeles.', '58', 'USA'),
(15, 'Rag\'n Bone Man', 'Rory Graham (Uckfield, 29 januari 1985) beter bekend onder zijn artiestennaam Rag\'n\'Bone Man is een Brits singer-songwriter.', '35', 'UK');

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
(1, 'Pukkelpop', 200, '2020-08-19 08:00:00', '2020-12-22 23:59:59', 'Kiewit', 'Dit is het alom bekende Limburgse festival, dit festival mikt vooral op jonge mensen.'),
(2, 'Werchter', 340, '2021-07-01 08:00:00', '2021-07-04 23:00:00', 'Werchter', 'Rock Werchter is een pop- en rockfestival dat elk jaar plaatsvindt in het dorpje Werchter, een deelgemeente van het Vlaams-Brabantse Rotselaar. Het Belgische muziekfestival vindt plaats in het laatste weekend van juni of het eerste van juli.'),
(9, 'Latitude 2021', 250, '2021-07-22 09:00:00', '2021-07-25 23:00:00', 'Southwold', 'Latitude Festival is an annual British music festival that takes place in Henham Park, Suffolk, in July.\r\n\r\nFormed in 2006, the festival offers live music, theatre, comedy and dance across four stages and plays host to 35,000 punters every year.'),
(10, 'Muse Concert', 75, '2021-07-04 20:00:00', '2021-07-04 23:00:00', 'Belfort france', 'Dit is een live concert van Muse op het festival: Les Eurockéennes De Belfort'),
(11, 'Concert The Streets', 110, '2021-07-02 08:00:00', '2021-07-02 23:59:59', 'Werchter', 'dit is een concert tijdens Rock-Werchter'),
(12, 'Rag\'n Bone Man Concert', 110, '2021-07-01 08:00:00', '2021-01-06 23:59:59', 'Werchter', 'dit is een concert tijdens Rock-Werchter'),
(13, 'Red Hot Chili Peppers Concert', 110, '2021-07-01 08:00:00', '2021-07-01 23:59:59', 'Werchter', 'dit is een concert tijdens Rock-Werchter'),
(14, 'Twenty One Pilots Concert', 110, '2021-07-03 08:00:00', '2021-07-03 23:59:59', 'Werchter', 'dit is een concert tijdens Rock-Werchter'),
(15, 'Panic! at the Disco concert', 80, '2021-02-17 20:00:00', '2021-01-06 23:00:00', 'Schijnpoortweg 119, 2170 Antwerpen', 'een concert van Panic! at the Disco in de Lotto Arena'),
(16, 'Zedd', 75, '2021-08-18 20:00:00', '2021-08-18 23:59:59', 'Schijnpoortweg 119, 2170 Antwerpen', 'Een concert van Zedd in het Sportpaleis'),
(17, 'Headhunterz Concert', 50, '2021-04-01 22:00:00', '2021-04-02 01:30:00', 'Amsterdam', 'Dit is een concert van Headhunterz'),
(18, 'AJR Concert', 65, '2021-05-05 20:00:00', '2021-01-06 23:00:00', 'Schijnpoortweg 119, 2170 Antwerpen', 'Een concert van AJR in het Sportpaleis'),
(19, 'Bastille Concert', 75, '2021-11-24 19:30:00', '2021-11-24 23:00:00', 'Schijnpoortweg 119, 2170 Antwerpen', 'Dit is een concert van Bastille in het sportpaleis, zeker de moeite waard!');

-- --------------------------------------------------------

--
-- Table structure for table `events_has_artists`
--

CREATE TABLE `events_has_artists` (
  `event_id` int(11) NOT NULL,
  `artist_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `events_has_artists`
--

INSERT INTO `events_has_artists` (`event_id`, `artist_id`) VALUES
(9, 1),
(19, 1),
(10, 2),
(2, 3),
(14, 3),
(17, 4),
(18, 5),
(15, 6),
(16, 7),
(1, 8),
(1, 9),
(1, 10),
(9, 11),
(9, 12),
(2, 13),
(11, 13),
(2, 14),
(13, 14),
(1, 15),
(2, 15),
(12, 15);

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `ticket_id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `ticket_price` float NOT NULL,
  `amount` int(11) NOT NULL,
  `sale_reason` varchar(255) NOT NULL,
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
(2, 'Combiticket Werchter ', 350, 1, 'Deze datum kan ik niet aanwezig zijn', 2, 4, 1, 'Combiticket'),
(3, 'Dagticket Pukkelpop', 100, 2, 'Deze datum kan ik niet aanwezig zijn', 1, NULL, 1, 'Dagticket'),
(4, 'Concert Bastille', 85, 1, 'Deze datum kan ik niet aanwezig zijn', 19, 5, 23, 'Concert'),
(21, 'Headhunterz Concert', 70, 1, 'Deze datum kan ik niet aanwezig zijn', 17, NULL, 20, 'Concert'),
(22, 'Muse Concert', 125, 1, 'Had me miskocht, ik kan die dag nie naar Frankrijk', 10, NULL, 27, 'Concert'),
(23, 'Bastille Concert', 95, 1, 'Ik ben bang van corona :\'(', 19, NULL, 19, 'Concert'),
(24, 'Rock Werchter Combiticket', 530, 1, 'Ik heb herexamens dus ik kan die dag niet komen', 2, NULL, 14, 'Combiticket'),
(25, 'Ragn Bone Man Concert', 130, 1, 'ik wist niet dat dit op  pukkelpop was', 12, NULL, 21, 'Dagticket'),
(26, 'Pukkelpop Dagticket', 130, 1, 'Mijn vrienden willen niet mee gaan', 1, NULL, 26, 'Dagticket'),
(27, 'Pukkelpop Combiticket', 560, 1, 'Ik wou een dagticket kopen maar ik had me miskocht', 1, NULL, 22, 'Combiticket'),
(28, 'Twenty One Pilots Concert', 130, 1, 'Ik heb me bedacht en wil dze groep toch niet gaan zien', 14, NULL, 24, 'Dagticket');

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
(4, '2020-12-09 00:04:17', 1, 14, 2),
(5, '2021-01-06 02:19:39', 23, 14, 4);

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
(13, 'a@a.a', '$2y$10$L2dAhvI3z44wTRcg2q2cGOc5Il39d/YZjJzDkonjXlNwCgvg/hLse'),
(14, 'moise.vankeymeulen@student.odisee.be', '$2y$10$psjOr5Eq.R7cISgUiSOh1esqrf/Eg5QDQPu6fK.ZW6xxPfOsgB/Lu'),
(16, 'laurens.decock@odisee.be', '$2y$10$CXHsAXYbveh0TUbAj09dg.uhGP/ixF6fDiI4bbG19wJ5J6NEyOwLC'),
(19, 'anakin.skywalker@lucasfilm.com', '$2y$10$GHKJdl32LRh5ICF3RbwKD.wNJMyUJd2ix27X7H4z/SMXs6clc8GA.'),
(20, 'obi-wan.kenobi@lucasfilm.com', '$2y$10$Sh1FVmND4A3Cw5Qq6UwdM.hhUNbxIHpmJ3xoENgdtz/Nv09UVyEf.'),
(21, 'george.lucas@lucasfilm.com', '$2y$10$ffRjS4dJmM77HPcIXk.ka.G2BbPDjP.QoiTx.ljQWZi9tM7xW5HgC'),
(22, 'luke.skywalker@lucasfilm.com', '$2y$10$MrgT13Mi80Q2VXrxc7BRnuU30s7nm6lovDt1VjJuy/zOYHB.SWXTW'),
(23, 'sheldon.cooper@bbt.com', '$2y$10$ksSnh2I8zhdrmrjjcwZIseiJKovgDD/a1ILfghIjpxjXqI2UAbJ9u'),
(24, 'leonard.hofsteader@bbt.com', '$2y$10$.yIUpua.SPDh.Xpzy.4uiONersSzyXWLR2fi06uVz5oeHovNXFNOG'),
(25, 'penny.lastname@bbt.com', '$2y$10$RF/OpKA.0kqPputciEwvg.Pb1bGy0I2mM4U7X0i.gFW3h1yhMeade'),
(26, 'howard.wolowitz@bbt.com', '$2y$10$ZOAgPWqMTZ1p20o4ryPw7.BFzYH8iL36/6ZkMays.tjnAG31RcPU.'),
(27, 'rajesh.kootrapali@bbt.com', '$2y$10$ffSIKcu4FEbzBEQMdM3wquFmQvKv8niNNJxWtnUH9eNnGsQ168dO6');

-- --------------------------------------------------------

--
-- Table structure for table `user_data`
--

CREATE TABLE `user_data` (
  `user_id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL DEFAULT 'Naamloos',
  `last_name` varchar(45) DEFAULT 'Doe',
  `friends_invited` int(11) DEFAULT '0',
  `tickets_sold` int(11) DEFAULT '0',
  `tickets_bought` varchar(45) DEFAULT '0',
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
(13, 'Naamloos', 'Doe', 0, 0, '0', NULL, NULL, NULL, 6),
(14, 'Moïse', 'VanKeymeulen', 0, 1, '2', 'Hugo Verrieststraat 23', 'Eeklo', 'Belgium', 7),
(16, 'Naamloos', 'Doe', 0, 0, '0', NULL, NULL, NULL, 9),
(19, 'Anakin', 'Skywalker', 0, 0, '0', 'Jedi Temple', 'Coruscant', 'Coruscant', 12),
(20, 'Obi-Wan (Ben)', 'Kenobi', 0, 0, '0', 'Jedi Temple', 'Coruscant', 'Coruscant', 13),
(21, 'George', 'Lucas', 0, 0, '0', 'Skywalker Ranch Rd', 'Nicasio', 'USA', 14),
(22, 'Luke', 'Skywalker', 0, 0, '0', 'Nurse Village', 'Ach-To', 'France', 15),
(23, 'Sheldon', 'Cooper', 0, 0, '0', '2311 North Los Robles Avenue', 'Pasadena', 'USA', 16),
(24, 'Leonard', 'Hofsteader', 0, 0, '0', '2311 North Los Robles Avenue', 'Pasadena', 'USA', 17),
(25, 'Penny', 'Unknown', 0, 0, '0', '2311 North Los Robles Avenue', 'Pasadena', 'USA', 18),
(26, 'Howard', 'Wolowitz', 0, 0, '0', 'Idk where he lives', 'Pasadena', 'USA', 19),
(27, 'Rajesh', 'Kootrapali', 0, 0, '0', 'Idk either', 'Pasadena', 'USA', 20);

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
  MODIFY `artist_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `ticket_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `user_data`
--
ALTER TABLE `user_data`
  MODIFY `data_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

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
