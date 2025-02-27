-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 27, 2025 at 05:58 PM
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
-- Table structure for table `completed_events`
--

CREATE TABLE `completed_events` (
  `CompletedEventID` int(11) NOT NULL,
  `EventName` varchar(255) NOT NULL,
  `EventDescription` text NOT NULL,
  `EventDate` date NOT NULL,
  `EventTime` time NOT NULL,
  `Location` varchar(255) NOT NULL,
  `Organizer` varchar(255) NOT NULL,
  `Rules` text DEFAULT NULL,
  `Rating` tinyint(4) NOT NULL CHECK (`Rating` between 1 and 10),
  `Feedback` text DEFAULT NULL,
  `CompletedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `completed_events`
--

INSERT INTO `completed_events` (`CompletedEventID`, `EventName`, `EventDescription`, `EventDate`, `EventTime`, `Location`, `Organizer`, `Rules`, `Rating`, `Feedback`, `CompletedAt`) VALUES
(1, 'Event', 'wojowj', '2025-02-20', '12:31:00', 'Mangalore', 'ojqow', NULL, 9, 'hel', '2025-02-08 12:35:29'),
(2, 'Event', 'wojowj', '2025-02-20', '12:31:00', 'Mangalore', 'ojqow', NULL, 8, '2', '2025-02-08 12:36:00'),
(3, 'hi', 'hkvik', '2025-02-21', '06:28:00', 'Udupi', 'kwndw', NULL, 9, 'ok', '2025-02-10 15:46:05');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('Pending','Read') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE `history` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `status` varchar(50) NOT NULL,
  `marked_read_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `history`
--

INSERT INTO `history` (`id`, `name`, `email`, `message`, `status`, `marked_read_at`) VALUES
(1, 'qs', 'hi@gmail.com', 'qs', 'Read', '2025-02-07 15:25:46'),
(2, '', '', '', 'Read', '2025-02-07 15:26:20');

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
(3, 'Joyston', 'Joyston@gmail.com', '$2y$10$u92ChtyK0FJmce.gYVgjR.iM70.UXFGBHMVXfYKy6VVH0LR9iFqQm', '2025-01-14 05:00:59'),
(4, 'Joyston', 'joyston123@gmail.com', '$2y$10$q0qy2cNhFQOZnzw0wpqocOjkcKEcM/Noh6EwknvWN.c7qInqNSZp.', '2025-02-07 10:07:48'),
(5, 'Test', 'Test@gmail.com', '$2y$10$L39t1zAJ48xtIajK5Z47uO3ixW7NHGaT316Z3R8XKEaQv4w9YpkRm', '2025-02-08 12:23:15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `completed_events`
--
ALTER TABLE `completed_events`
  ADD PRIMARY KEY (`CompletedEventID`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Events`
--
ALTER TABLE `Events`
  ADD PRIMARY KEY (`EventID`);

--
-- Indexes for table `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `completed_events`
--
ALTER TABLE `completed_events`
  MODIFY `CompletedEventID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `Events`
--
ALTER TABLE `Events`
  MODIFY `EventID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `history`
--
ALTER TABLE `history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `Participations`
--
ALTER TABLE `Participations`
  MODIFY `ParticipationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `UpcomingEvents`
--
ALTER TABLE `UpcomingEvents`
  MODIFY `UpcomingEventID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Users`
--
ALTER TABLE `Users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
