-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 20, 2023 at 07:39 PM
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
  `purchase_date` date NOT NULL,
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

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `first_name`, `last_name`, `email`, `phone`, `area_code`) VALUES
(1, 'Sally', 'Bell', 'sellybell@gmail.com', '438-438-1111', 'H1H H1H'),
(2, 'Elisabeth', 'Walker', 'elisabethwalker@gmail.com', '438-438-2222', 'H2H H2H'),
(3, 'Kayla', 'Brooks', 'kaylabrooks@gmail.com', '438-438-3333', 'H3H H3H'),
(4, 'Jay', 'Belanger', 'jaybelanger@gmail.com', '438-438-4444', 'H4H H4H'),
(5, 'Rose', 'Ward', 'roseward@gmail.com', '438-438-5555', 'H5H H5H');

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
(1, 'Mercedes-Benz, LLC', 'Canada', 'Calgary', '1926', 'https://www.mercedes-benz.ca/en/home'),
(2, 'Mercedes-Benz, LLC', 'Canada', 'Kelowna', '1926', 'https://www.mercedes-benz.ca/en/home'),
(3, 'Ford Motor Company', 'Canada', 'Weston', '1903', 'https://www.ford.ca/'),
(4, 'Jayco, Inc.', 'Canada', 'St-Jerome', '1968', 'https://www.jayco.com/'),
(5, 'Harley-Davidson Motor Company', 'Canada', 'Winnipeg', '1903', 'https://www.harley-davidson.com/ca/en/index.html');

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

--
-- Dumping data for table `models`
--

INSERT INTO `models` (`model_id`, `manufacturer_id`, `year`, `vehicle_type`, `fuel_type`, `transmission_type`, `engine`, `power_type`) VALUES
(1, 1, 2023, 'sports', 'premium', 'automatic', 'V8', 'gasoline'),
(2, 2, 2022, 'suv', 'N/A', 'single speed', 'N/A', 'electricity'),
(3, 3, 2022, 'suv', 'regular', 'automatic', 'inline 4', 'gasoline'),
(4, 4, 2024, 'rv', 'regular', 'automatic', 'V8', 'gasoline'),
(5, 5, 2023, 'motorcycle', 'premium', 'manual', '121ci', 'gasoline');

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
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
  MODIFY `model_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `recalls`
--
ALTER TABLE `recalls`
  MODIFY `recall_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
