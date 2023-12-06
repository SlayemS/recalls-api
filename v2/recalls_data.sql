-- Recalls Database Data

SET NAMES utf8mb4;
SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';
SET @old_autocommit=@@autocommit;

USE recalls_db;

--
-- Dumping data for table `manufacturers`
--

INSERT INTO `manufacturers` (`manufacturer_id`, `manufacturer_name`, `country`, `city`, `founded_year`, `website`) VALUES
(1, 'Audi', 'Germany', 'Ingolstadt', 1909, 'https://www.audi.com'),
(2, 'Hyundai', 'South Korea', 'Seoul', 1967, 'https://www.hyundai.com'),
(3, 'Volkswagen', 'Germany', 'Wolfsburg', 1937, 'https://www.vw.com'),
(4, 'Ford', 'United States', 'Dearborn', 1903, 'https://www.ford.com'),
(5, 'Honda', 'Japan', 'Tokyo', 1948, 'https://www.honda.com');

--
-- Dumping data for table `models`
--

INSERT INTO `models` (`model_id`, `manufacturer_id`, `year`, `vehicle_type`, `fuel_type`, `transmission_type`, `engine`, `power_type`) VALUES
(1, 1, 2018, 'sports', 'premium', 'automatic', 'V8', 'gasoline'),
(2, 2, 2019, 'suv', 'N/A', 'single speed', 'N/A', 'electricity'),
(3, 3, 2020, 'suv', 'regular', 'automatic', 'inline 4', 'gasoline'),
(4, 4, 2024, 'rv', 'regular', 'automatic', 'V8', 'gasoline'),
(5, 5, 2022, 'motorcycle', 'premium', 'manual', '121ci', 'gasoline');

--
-- Dumping data for table `recalls`
--

INSERT INTO `recalls` (`recall_id`, `model_id`, `description`, `issue_date`, `fix_date`, `subject`, `component`) VALUES
(1, 1, 'Volkswagen Group of America, Inc. (Volkswagen) is recalling certain 2024 Atlas PA2 and Atlas Cross Sport PA vehicles.  The engine connecting rod beari', '2023-08-23', '2023-08-30', 'Engine Failure', 'Engine and engine cooling'),
(2, 2, 'Outfitter Manufacturing (Outfitter) is recalling certain 2021-2022 Caribou Lite 6.5, Caribou Lite 8, Caribou 6.5, Apex 8, 2021 Apex 8 LB, and 2022 Car', '2021-08-21', '2021-08-28', 'Cooktop Gas Valves May Fracture Causing Gas Leak', 'Equipment'),
(3, 3, 'Aluminum Trailer Company (ATC) is recalling certain 2022-2023 PL700 trailers.  The wire connections in the transfer switch may be tightened improperly', '2022-08-21', '2022-08-28', 'Loose Wire Connections in Transfer Switch', 'Electrical system'),
(4, 4, 'Hyundai Motor America (Hyundai) is recalling certain 2021-2023 Elantra HEV vehicles.  A software error in the motor control unit may cause unintended ', '2023-08-18', '2023-08-25', 'Software Error May Cause Unintended Acceleration', 'Electrical system'),
(5, 5, 'Navistar, Inc. (Navistar) is recalling certain 2023 International MV and International HV vehicles.  The driveshafts can break under certain loading c', '2023-08-17', '2023-08-24', 'Driveshaft May Break', 'Power train');

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `first_name`, `last_name`, `email`, `phone`, `area_code`) VALUES
(1, 'Sally', 'Bell', 'sellybell@gmail.com', '438-438-1111', 'H1H H1H'),
(2, 'Elisabeth', 'Walker', 'elisabethwalker@gmail.com', '438-438-2222', 'H2H H2H'),
(3, 'Kayla', 'Brooks', 'kaylabrooks@gmail.com', '438-438-3333', 'H3H H3H'),
(4, 'Jay', 'Belanger', 'jaybelanger@gmail.com', '438-438-4444', 'H4H H4H'),
(5, 'Rose', 'Ward', 'roseward@gmail.com', '438-438-5555', 'H5H H5H');

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`car_id`, `customer_id`, `model_id`, `purchase_date`, `dealership`, `mileage`, `color`)
VALUES (1, 1, 1, '2021-10-22', 'BMW', 130000, 'black'),
(2, 1, 2, '2023-10-22', 'Audi', 80000, 'matte blue'),
(3, 1, 3, '2021-01-22', 'Volkswagen', 130000, 'black'),
(4, 2, 4, '2015-09-12', 'Toyota', 130000, 'yellow'),
(5, 5, 5, '2016-02-16', 'Honda', 2000, 'black'),
(6, 2, 2, '2017-06-15', 'Ford', 13000, 'red'),
(7, 4, 1, '2012-11-22', 'Chevrolet', 46000, 'red'),
(8, 3, 4, '2011-10-22', 'Nissan', 204000, 'green');

--
-- Dumping data for table `instances`
--

INSERT INTO `instances` (`instance_id`, `recall_id`, `car_id`, `notification_date`, `instances_note`, `bring_in_date`, `expected_leave_date`, `job_done`)
VALUES (1, 2, 2, '2021-05-03', 'airbag failure', '2021-10-25', '2021-10-26', true),
(2, 3, 3, '2020-07-03', 'seatbelt failure', '2021-10-25', '2021-10-26', false),
(3, 4, 4, '2021-06-29', 'seatbelt failure', '2021-10-25', '2021-10-26', false),
(4, 5, 5, '2018-10-22', 'engine spark plug defective', '2021-10-25', '2021-10-26', true),
(5, 1, 6, '2021-04-04', 'wrong firmware', '2021-10-25', '2021-10-26', false),
(6, 2, 7, '2021-10-20', 'bug in system', '2021-10-25', '2021-10-26', false),
(7, 5, 8, '2019-06-23', 'faulty door handle', '2021-10-25', '2021-10-26', true),
(8, 1, 1, '2020-02-16', 'ECU failure', '2021-10-25', '2021-10-26', true);

--
-- Dumping data for table `instances`
--

INSERT INTO `repairs` (`repair_id`, `instance_id`, `repair_date`, `cost`, `status`, `estimate_time`)
VALUES (1, 1, '2023-10-22', 150.00, 'Completed', '1 day'),
(2, 2, '2021-10-23', 250.00, 'In Progress', '2 days'),
(3, 3, '2022-4-24', 400.00, 'Pending', '3 days'),
(4, 4, '2018-10-21', 180.00, 'Completed', '1 day'),
(5, 5, '2023-07-15', 60.00, 'In Progress', '2 days'),
(6, 6, '2021-03-27', 300.00, 'Pending', '3 days'),
(7, 7, '2023-06-28', 120.00, 'Completed', '1 day'),
(8, 8, '2022-10-05', 210.00, 'In Progress', '2 days'),
(9, 9, '2020-10-04', 80.00, 'Pending', '3 days'),
(10, 10, '2023-10-03', 270.00, 'Completed', '1 day');
