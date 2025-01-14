-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 14, 2025 at 05:15 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

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
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Participations`
--

CREATE TABLE `Participations` (
  `ParticipationID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `EventID` int(11) NOT NULL,
  `RegisteredAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `UpcomingEvents`
--

CREATE TABLE `UpcomingEvents` (
  `UpcomingEventID` int(11) NOT NULL,
  `EventName` varchar(150) NOT NULL,
  `EventDescription` text NOT NULL,
  `EventDate` date NOT NULL,
  `EventTime` time NOT NULL,
  `Location` varchar(255) DEFAULT NULL,
  `Organizer` varchar(100) DEFAULT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE `Users` (
  `UserID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Email` varchar(150) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`UserID`, `Name`, `Email`, `Password`, `CreatedAt`) VALUES
(1, 'Albert', 'Albert2323@gmail.com', '$2y$10$nd6UwXAdYv4Ydbf0.TwaqO9D7YS56G0wdykp2HdPTZjPbmTnXZplW', '2025-01-14 04:47:39'),
(2, 'Test', 'AlbertTest@gmail.com', '$2y$10$Na0/ChUs9z4y7G74PluOa.EGYBrEUUUz8OXMqjTWW7nojW.GlszFi', '2025-01-14 04:48:50'),
(3, 'Joyston', 'Joyston@gmail.com', '$2y$10$u92ChtyK0FJmce.gYVgjR.iM70.UXFGBHMVXfYKy6VVH0LR9iFqQm', '2025-01-14 05:00:59');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Events`
--
ALTER TABLE `Events`
  ADD PRIMARY KEY (`EventID`);

--
-- Indexes for table `Participations`
--
ALTER TABLE `Participations`
  ADD PRIMARY KEY (`ParticipationID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `EventID` (`EventID`);

--
-- Indexes for table `UpcomingEvents`
--
ALTER TABLE `UpcomingEvents`
  ADD PRIMARY KEY (`UpcomingEventID`);

--
-- Indexes for table `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Events`
--
ALTER TABLE `Events`
  MODIFY `EventID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Participations`
--
ALTER TABLE `Participations`
  MODIFY `ParticipationID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `UpcomingEvents`
--
ALTER TABLE `UpcomingEvents`
  MODIFY `UpcomingEventID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Users`
--
ALTER TABLE `Users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Participations`
--
ALTER TABLE `Participations`
  ADD CONSTRAINT `Participations_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `Users` (`UserID`) ON DELETE CASCADE,
  ADD CONSTRAINT `Participations_ibfk_2` FOREIGN KEY (`EventID`) REFERENCES `Events` (`EventID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
