-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 27, 2025 at 02:47 PM
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
-- Database: `College_Event`
--

-- --------------------------------------------------------

--
-- Table structure for table `Events`
--

CREATE TABLE `Events` (
  `EventID` int(11) NOT NULL,
  `EventName` varchar(150) NOT NULL,
  `EventDescription` text NOT NULL,
  `EventDate` date NOT NULL,
  `EventTime` time NOT NULL,
  `Location` varchar(255) DEFAULT NULL,
  `Organizer` varchar(100) DEFAULT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `rules` text DEFAULT NULL,
  `EventType` enum('Single','Group') NOT NULL DEFAULT 'Single',
  `MaxParticipants` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Events`
--

INSERT INTO `Events` (`EventID`, `EventName`, `EventDescription`, `EventDate`, `EventTime`, `Location`, `Organizer`, `CreatedAt`, `rules`, `EventType`, `MaxParticipants`) VALUES
(5, 'Dance', 'A dance baila', '2025-02-28', '19:00:00', 'Mangalore', 'Tehc', '2025-02-13 09:02:28', 'Mo rules', 'Group', 4),
(6, 'Sing', 'leqbfowe', '2025-02-28', '12:04:00', 'Manglore', 'KBdid', '2025-02-27 13:02:35', 'IHEiwe', 'Single', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Events`
--
ALTER TABLE `Events`
  ADD PRIMARY KEY (`EventID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Events`
--
ALTER TABLE `Events`
  MODIFY `EventID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
