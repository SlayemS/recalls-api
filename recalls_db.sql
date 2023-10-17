-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 17, 2023 at 03:09 AM
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
-- Table structure for table `cars`
--

CREATE TABLE `cars` (
  `car_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `model` int(11) NOT NULL,
  `purchase_date` int(11) NOT NULL,
  `dealership` varchar(50) NOT NULL,
  `insurance_nb` varchar(9) NOT NULL,
  `mileage` int(11) NOT NULL,
  `color` varchar(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `area_code` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

-- --------------------------------------------------------

--
-- Table structure for table `manufacturers`
--

CREATE TABLE `manufacturers` (
  `manufacturer_id` int(11) NOT NULL,
  `manufacturer_name` varchar(100) NOT NULL,
  `country` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `founded_year` varchar(50) NOT NULL,
  `website` varchar(75) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `manufacturers`
--

INSERT INTO `manufacturers` (`manufacturer_id`, `manufacturer_name`, `country`, `city`, `founded_year`, `website`) VALUES
(1, 'Daimler Trucks North America, LLC', 'Canada', 'Calgary', '1942', 'https://northamerica.daimlertruck.com/'),
(2, 'Daimler Trucks North America, LLC', 'Canada', 'Mississauga', '1942', 'https://northamerica.daimlertruck.com/'),
(3, 'Mercedes-Benz USA, LLC', 'Canada', 'Kelowna', '1926', 'https://shop.mercedes-benz.com/en-ca/connect'),
(4, 'Winnebago Industries, Inc.', 'Canada', 'Cornwall', '1958', 'https://www.winnebago.com'),
(5, 'PACCAR Incorporated', 'Canada', 'Bellevue', '1905', 'https://www.paccar.com/');

-- --------------------------------------------------------

--
-- Table structure for table `models`
--

CREATE TABLE `models` (
  `model_id` int(11) NOT NULL,
  `manufacturer_id` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `vehicle_type` varchar(50) NOT NULL,
  `fuel_type` varchar(50) NOT NULL,
  `transmission_type` varchar(30) NOT NULL,
  `engine` varchar(30) NOT NULL,
  `power_type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

-- --------------------------------------------------------

--
-- Table structure for table `repairs`
--

CREATE TABLE `repairs` (
  `repair_id` int(11) NOT NULL,
  `repair_date` date NOT NULL,
  `repair_description` varchar(100) NOT NULL,
  `repair_cost` decimal(10,0) NOT NULL,
  `repair_status` varchar(50) NOT NULL,
  `repair_estimate_time` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`car_id`),
  ADD KEY `cars_customer_id` (`customer_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `instances`
--
ALTER TABLE `instances`
  ADD PRIMARY KEY (`instances_id`),
  ADD KEY `instances_recall_id` (`recall_id`),
  ADD KEY `instances_car_id` (`car_id`);

--
-- Indexes for table `manufacturers`
--
ALTER TABLE `manufacturers`
  ADD PRIMARY KEY (`manufacturer_id`);

--
-- Indexes for table `models`
--
ALTER TABLE `models`
  ADD PRIMARY KEY (`model_id`),
  ADD KEY `models_manufacturer_id` (`manufacturer_id`);

--
-- Indexes for table `recalls`
--
ALTER TABLE `recalls`
  ADD PRIMARY KEY (`recall_id`),
  ADD KEY `recalls_models_id` (`model_id`);

--
-- Indexes for table `repairs`
--
ALTER TABLE `repairs`
  ADD PRIMARY KEY (`repair_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `car_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `instances`
--
ALTER TABLE `instances`
  MODIFY `instances_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `manufacturers`
--
ALTER TABLE `manufacturers`
  MODIFY `manufacturer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `models`
--
ALTER TABLE `models`
  MODIFY `model_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `recalls`
--
ALTER TABLE `recalls`
  MODIFY `recall_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `repairs`
--
ALTER TABLE `repairs`
  MODIFY `repair_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cars`
--
ALTER TABLE `cars`
  ADD CONSTRAINT `cars_customer_id` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`);

--
-- Constraints for table `instances`
--
ALTER TABLE `instances`
  ADD CONSTRAINT `instances_car_id` FOREIGN KEY (`car_id`) REFERENCES `cars` (`car_id`),
  ADD CONSTRAINT `instances_recall_id` FOREIGN KEY (`recall_id`) REFERENCES `recalls` (`recall_id`);

--
-- Constraints for table `models`
--
ALTER TABLE `models`
  ADD CONSTRAINT `models_manufacturer_id` FOREIGN KEY (`manufacturer_id`) REFERENCES `manufacturers` (`manufacturer_id`);

--
-- Constraints for table `recalls`
--
ALTER TABLE `recalls`
  ADD CONSTRAINT `recalls_models_id` FOREIGN KEY (`model_id`) REFERENCES `models` (`model_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
