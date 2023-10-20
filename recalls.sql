-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 20, 2023 at 07:34 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `recalls_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `recalls`
--

CREATE TABLE `recalls` (
  `recall_id` int(11) NOT NULL,
  `model_id` int(11) NOT NULL,
  `description` varchar(150) NOT NULL,
  `issue_date` date NOT NULL,
  `fix_date` date NOT NULL,
  `subject` varchar(100) NOT NULL,
  `component` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recalls`
--

INSERT INTO `recalls` (`recall_id`, `model_id`, `description`, `issue_date`, `fix_date`, `subject`, `component`) VALUES
(1, 1, 'Volkswagen Group of America, Inc. (Volkswagen) is recalling certain 2024 Atlas PA2 and Atlas Cross Sport PA vehicles.  The engine connecting rod beari', '2023-08-23', '2023-08-30', 'Engine Failure', 'Engine and engine cooling'),
(2, 2, 'Outfitter Manufacturing (Outfitter) is recalling certain 2021-2022 Caribou Lite 6.5, Caribou Lite 8, Caribou 6.5, Apex 8, 2021 Apex 8 LB, and 2022 Car', '2023-08-21', '2023-08-28', 'Cooktop Gas Valves May Fracture Causing Gas Leak', 'Equipment'),
(3, 3, 'Aluminum Trailer Company (ATC) is recalling certain 2022-2023 PL700 trailers.  The wire connections in the transfer switch may be tightened improperly', '2023-08-21', '2023-08-28', 'Loose Wire Connections in Transfer Switch', 'Electrical system'),
(4, 4, 'Hyundai Motor America (Hyundai) is recalling certain 2021-2023 Elantra HEV vehicles.  A software error in the motor control unit may cause unintended ', '2023-08-18', '2023-08-25', 'Software Error May Cause Unintended Acceleration', 'Electrical system'),
(5, 5, 'Navistar, Inc. (Navistar) is recalling certain 2023 International MV and International HV vehicles.  The driveshafts can break under certain loading c', '2023-08-17', '2023-08-24', 'Driveshaft May Break', 'Power train');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `recalls`
--
ALTER TABLE `recalls`
  ADD PRIMARY KEY (`recall_id`),
  ADD KEY `recalls_models_id` (`model_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `recalls`
--
ALTER TABLE `recalls`
  MODIFY `recall_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `recalls`
--
ALTER TABLE `recalls`
  ADD CONSTRAINT `recalls_models_id` FOREIGN KEY (`model_id`) REFERENCES `models` (`model_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
