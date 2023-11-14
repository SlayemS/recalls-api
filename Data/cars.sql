-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 22, 2023 at 12:53 AM
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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `car_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cars`
--
ALTER TABLE `cars`
  ADD CONSTRAINT `cars_customer_id` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;



-- insert data into cars table

-- insert bmw, customer 1, and fill the other fields
-- also insert, audi, voswagen, toyota, honda, ford, chevrolet, and nissan, and auto fill the other fields
INSERT INTO cars (customer_id, model, purchase_date, dealership, insurance_nb, mileage, color)
VALUES (1, 1, '2021-10-22', 'BMW', '123456789', 130000, 'black'),
(1, 2, '2023-10-22', 'Audi', '123456789', 80000, 'blue'),
(1, 3, '2021-01-22', 'Voswagen', '123456789', 130000, 'black'),
(2, 4, '2015-09-12', 'Toyota', '123456789', 130000, 'yellow'),
(5, 5, '2016-02-16', 'Honda', '123456789', 2000, 'matt-black'),
(2, 6, '2017-06-15', 'Ford', '123456789', 13000, 'red'),
(4, 7, '2012-11-22', 'Chevrolet', '123456789', 46000, 'red'),
(3, 8, '2011-10-22', 'Nissan', '123456789', 204000, 'green');
