-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 22, 2024 at 01:16 AM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ak_store`
--

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `Product_ID` int(11) NOT NULL,
  `Product_Name` varchar(100) NOT NULL,
  `Barcode` varchar(100) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `Link_To_CTN` int(11) NOT NULL,
  `Buy_Price` int(11) NOT NULL,
  `Sell_Price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`Product_ID`, `Product_Name`, `Barcode`, `Quantity`, `Link_To_CTN`, `Buy_Price`, `Sell_Price`) VALUES
(1, 'Change 330', '11', 528, 5, 1500, 1600);

-- --------------------------------------------------------

--
-- Table structure for table `product_latkar`
--

CREATE TABLE `product_latkar` (
  `Product_ID` int(11) NOT NULL,
  `Product_Name` varchar(50) NOT NULL,
  `Barcode` varchar(120) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `Quantity_Per_Package` int(11) NOT NULL,
  `Buy_Price` int(11) NOT NULL,
  `Sell_Price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_latkar`
--

INSERT INTO `product_latkar` (`Product_ID`, `Product_Name`, `Barcode`, `Quantity`, `Quantity_Per_Package`, `Buy_Price`, `Sell_Price`) VALUES
(2, 'Chang Bottle', '1 23', 8, 18, 40000, 44000),
(3, 'Change (500)', '12', 5, 25, 35000, 39000),
(4, 'Tiger', '123421342123121', 20, 24, 30000, 35000),
(5, 'Chang 330 CTN', '1234', 10, 24, 32000, 33000);

-- --------------------------------------------------------

--
-- Table structure for table `sale`
--

CREATE TABLE `sale` (
  `Sale_ID` int(11) NOT NULL,
  `Product_ID` int(11) NOT NULL,
  `Buy_Quantity` int(11) NOT NULL,
  `Total_Amount` int(11) NOT NULL,
  `Date` date NOT NULL,
  `Time` time NOT NULL,
  `Status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sale`
--

INSERT INTO `sale` (`Sale_ID`, `Product_ID`, `Buy_Quantity`, `Total_Amount`, `Date`, `Time`, `Status`) VALUES
(8, 3, 2, 78000, '2024-06-20', '00:00:16', 1),
(11, 2, 1, 44000, '2024-06-21', '00:00:02', 1),
(15, 3, 1, 39000, '2024-06-21', '00:00:02', 1),
(16, 3, 3, 117000, '2024-06-21', '00:00:02', 1),
(17, 3, 3, 117000, '2024-06-21', '00:00:02', 1),
(18, 3, 1, 39000, '2024-06-21', '00:00:02', 1),
(19, 2, 1, 44000, '2024-06-21', '00:00:07', 1),
(23, 1, 1, 33000, '2024-06-21', '07:48:09', 1),
(25, 3, 1, 39000, '2024-06-22', '05:36:19', 1),
(26, 1, 1, 1600, '2024-06-22', '05:41:57', 0);

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `Supplier_ID` int(11) NOT NULL,
  `Supplier_Name` varchar(50) NOT NULL,
  `Phone` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`Supplier_ID`, `Supplier_Name`, `Phone`) VALUES
(1, 'Ko Kyaw', 1423);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`Product_ID`);

--
-- Indexes for table `product_latkar`
--
ALTER TABLE `product_latkar`
  ADD PRIMARY KEY (`Product_ID`);

--
-- Indexes for table `sale`
--
ALTER TABLE `sale`
  ADD PRIMARY KEY (`Sale_ID`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`Supplier_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `Product_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sale`
--
ALTER TABLE `sale`
  MODIFY `Sale_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
