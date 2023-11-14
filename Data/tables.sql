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