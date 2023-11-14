-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 22, 2023 at 01:28 AM
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
-- Table structure for table `instances`
--

CREATE TABLE `instances` (
  `instances_id` int(11) NOT NULL,
  `recall_id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `notification_date` date NOT NULL,
  `instances_note` varchar(100) NOT NULL,
  `bring_in_date` date NOT NULL,
  `expected_leave` date NOT NULL,
  `job_done` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `instances`
--
ALTER TABLE `instances`
  ADD PRIMARY KEY (`instances_id`),
  ADD KEY `instances_recall_id` (`recall_id`),
  ADD KEY `instances_car_id` (`car_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `instances`
--
ALTER TABLE `instances`
  MODIFY `instances_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `instances`
--
ALTER TABLE `instances`
  ADD CONSTRAINT `instances_car_id` FOREIGN KEY (`car_id`) REFERENCES `cars` (`car_id`),
  ADD CONSTRAINT `instances_recall_id` FOREIGN KEY (`recall_id`) REFERENCES `recalls` (`recall_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;



-- insert data into instances table

-- autofill table data, different data for each row, give different instances_note for each row
INSERT INTO instances (recall_id, car_id, notification_date, instances_note, bring_in_date, expected_leave, job_done)
VALUES (1, 1, '2021-10-22', 'ECU failure', '2021-10-25', '2021-10-26', 0),
(2, 2, '2021-10-22', 'airbag failure', '2021-10-25', '2021-10-26', 0),
(3, 3, '2021-10-22', 'seatbelt failure', '2021-10-25', '2021-10-26', 0),
(4, 4, '2021-10-22', 'seatbelt failure', '2021-10-25', '2021-10-26', 0),
(5, 5, '2021-10-22', 'engine spark plug defective', '2021-10-25', '2021-10-26', 0),
(6, 6, '2021-10-22', 'wrong firmware', '2021-10-25', '2021-10-26', 0),
(7, 7, '2021-10-22', 'bug in system', '2021-10-25', '2021-10-26', 0),
(8, 8, '2021-10-22', 'faulty door handle', '2021-10-25', '2021-10-26', 0);