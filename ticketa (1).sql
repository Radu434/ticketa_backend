-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 01, 2024 at 12:44 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ticketa`
--

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `description` varchar(2048) NOT NULL,
  `photo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`id`, `name`, `location`, `date`, `description`, `photo`) VALUES
(8, 'eee', 'Party with polar bears and pinvins', '2024-06-07 09:29:40', 'Party with polar bears and pinvins', 'https://iili.io/JZwUZOv.jpg'),
(19, 'party bobel', 'la bogdan', '2024-06-19 21:00:00', 'fain tare ', 'https://iili.io/JmBudMl.png'),
(20, 'miau la andr', 'casa mea', '2024-08-31 21:00:00', 'se propune un miau la resedinta doamnei andr', 'https://iili.io/JpRAFx1.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `ticket`
--

CREATE TABLE `ticket` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `price` float NOT NULL,
  `type` varchar(128) NOT NULL DEFAULT 'Standard'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ticket`
--

INSERT INTO `ticket` (`id`, `event_id`, `price`, `type`) VALUES
(8, 8, 62.3, 'Standard'),
(20, 8, 33.33, 'Frozen Ticket'),
(25, 8, 1, 'expenisve'),
(30, 19, 21, 'tenis'),
(31, 19, 44, 'loja'),
(32, 20, 69420, 'vip in miau'),
(33, 20, 42069, 'pe sarakie');

-- --------------------------------------------------------

--
-- Table structure for table `ticket_transaction`
--

CREATE TABLE `ticket_transaction` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ticket_transaction`
--

INSERT INTO `ticket_transaction` (`id`, `user_id`, `ticket_id`, `date`) VALUES
(3, 4, 8, '2024-05-29 08:45:54'),
(4, 4, 20, '2024-05-29 09:09:59'),
(13, 4, 31, '2024-06-02 16:54:34'),
(14, 32, 31, '2024-06-05 13:24:17'),
(15, 32, 33, '2024-06-05 13:36:18'),
(16, 32, 33, '2024-06-05 13:36:22'),
(17, 4, 33, '2024-06-17 17:58:39');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `password`, `username`) VALUES
(4, 'b', 'b', 'marian'),
(5, 'bossu99@yahoo.com', 'Katanaa3', 'Negoita'),
(11, 'masinistu@yahoo.com', 'abracadabra', 'bibanu'),
(13, 'raduionut@gmail.com', 'radu343', 'barabula12'),
(26, 'craioveanu@hotmail.com', 'bacalbasaunicat', 'maimutarealaoriginala'),
(27, 'grigo@gmail.com', 'Ampulamare27', 'grigoreanu'),
(28, 'mihai@gmail.ro', 'Bobonete4', 'misulica'),
(29, 'marian@enescu.cc', 'Candeala99', 'barobosu'),
(30, 'farcasdiana@email.ceva', 'Parola999', 'dia'),
(31, 'asddsa@sdfsd.com', 'Abcdef12', '1234567'),
(32, 'andrafarcas@yahoo.com', 'dsfgsfsfsdf', 'andrafarcas');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_id_2` (`event_id`);

--
-- Indexes for table `ticket_transaction`
--
ALTER TABLE `ticket_transaction`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userFk` (`user_id`),
  ADD KEY `ticketFk` (`ticket_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `ticket`
--
ALTER TABLE `ticket`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `ticket_transaction`
--
ALTER TABLE `ticket_transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ticket`
--
ALTER TABLE `ticket`
  ADD CONSTRAINT `eventcorrelationfk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ticket_transaction`
--
ALTER TABLE `ticket_transaction`
  ADD CONSTRAINT `ticketFk` FOREIGN KEY (`ticket_id`) REFERENCES `ticket` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `userFk` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
