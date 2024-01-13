-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 05, 2023 at 08:16 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `school_inventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `admininfo`
--

CREATE TABLE `admininfo` (
  `UserID` varchar(5) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `email` text NOT NULL,
  `PhoneNum` text NOT NULL,
  `IC` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admininfo`
--

INSERT INTO `admininfo` (`UserID`, `gender`, `email`, `PhoneNum`, `IC`) VALUES
('A001', 'Female', 'bVRUQ1NCM1JqaGU0YzhMWUE5VGJkSW52MUFYVlI3NW9UVUVCL1JCMmVqOD06OoKQQKXFmLHX4zt1hsW0bAg=', 'MG45YnRSSWlHaGIrMmJCSi92WWtpZz09Ojpp5uobQutoBaoRiPoAgSgM', 'WVpnZXE1bVFheVJOMkN5NTJ3T3ZXUT09Ojoy50XcxuZHYmCY/M9wOXSF');

-- --------------------------------------------------------

--
-- Table structure for table `editlog`
--

CREATE TABLE `editlog` (
  `LogID` int(7) NOT NULL,
  `DateTime` datetime NOT NULL,
  `UserID` varchar(8) NOT NULL,
  `Details` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `editlog`
--

INSERT INTO `editlog` (`LogID`, `DateTime`, `UserID`, `Details`) VALUES
(50, '2023-07-02 06:03:35', 'A001', 'FullName:NUR SYAZWANI;gender:Female;Email:NEVrekcwMG1HUVJVbUFtV2Z2U2ZCTDcvK21NSUdiZDd4VFU2M0lrUHJuST06OgOOa07CmdBOuST0LgeKSl0=;Phone:T0ZwdkdnUWtwaHVUVFo0SzlGeDR1QT09OjrCvQiofcmTFe6/cgDmczJ8;IC:NGhuL3pYdjJqdVcvMSs0QjYxNkNRQT09OjqJDpKKbflX2X53vjO1AIo5;'),
(51, '2023-07-02 06:06:57', 'A001', 'FullName:NUR SYAZWANI;gender:Female;Email:dk1WOGE5aks3MWd6REdoMDFFNzJ1dG5ET2hTSnpCaW4yT1p3U2ZBd1V3bz06OpBJM0cbtH8WftN2im6OfyY=;Phone:aWRYdW5ZWFdUUkRRdGVGRElmUXlzZz09Ojph3R0jEPXpZ44NvR2h2mGe;IC:Y0RyTkNxOHRjZDhPVWRUM0tHRWIxdz09OjpE/WiKYJ03SNscwrZSkx6B;'),
(52, '2023-07-02 06:39:50', 'A001', 'FullName:NUR SYAZWANI;gender:Female;Email:UTZiR1pVWmUrRjJBNnFDUGw2NklIUWhtMHRjNllXN1FqRGF1MzMzUjY3ST06OgNLB+Iasr4dc/8vjnhRJq8=;Phone:NGhDZ0tZWHpwUnBWVlJld0pKT1JwUT09Ojp92Z5UgltHHBB1x77SMQgg;IC:S0pNOS9SelhFajN6bUsxTktud0tMUT09Ojoownrmj0LlGGmN0FQu0N+P;'),
(53, '2023-07-02 07:45:42', 'A001', 'FullName:0127245057;gender:Female;Email:bVRUQ1NCM1JqaGU0YzhMWUE5VGJkSW52MUFYVlI3NW9UVUVCL1JCMmVqOD06OoKQQKXFmLHX4zt1hsW0bAg=;Phone:MG45YnRSSWlHaGIrMmJCSi92WWtpZz09Ojpp5uobQutoBaoRiPoAgSgM;IC:WVpnZXE1bVFheVJOMkN5NTJ3T3ZXUT09Ojoy50XcxuZHYmCY/M9wOXSF;');

-- --------------------------------------------------------

--
-- Table structure for table `editproduct`
--

CREATE TABLE `editproduct` (
  `LogID` int(7) NOT NULL,
  `DateTime` datetime NOT NULL,
  `ProductID` varchar(7) NOT NULL,
  `Details` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `UserID` varchar(8) NOT NULL,
  `FullName` varchar(30) NOT NULL,
  `UserPass` text NOT NULL,
  `Pass` text NOT NULL,
  `TypeName` varchar(10) NOT NULL,
  `status` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`UserID`, `FullName`, `UserPass`, `Pass`, `TypeName`, `status`) VALUES
('A001', 'Syazwani', '$2y$10$MvG9tWULSy8N0hBHIWb4wupTT2zqxB30082583i1MOnzFZ6QzECji', '$2y$10$ZxbyItc7I9jUDa6ABPw9yO78floGqNuJ1WWKZ3Eh1hpykNiKyAfAe', 'admin', 'active'),
('S001', 'Syazwana', '$2y$10$uYEzXmfZsenrQYL9ipe2cudHi2CL72hhrAEiC7tDohnfLZSQvlEfy', '$2y$10$uYEzXmfZsenrQYL9ipe2cudHi2CL72hhrAEiC7tDohnfLZSQvlEfy', 'student', 'active'),
('S002', 'Najmi', '$2y$10$qxDmhXRwN6Vm90KnaetsHer95DR2xLyZkyxjmli.hZCvgwex24956', '$2y$10$iLg0ZEtfuPGyu9hXaVoX7.a8k03FJHwGAfTh0N0G.66SoWNDEmLym', 'student', 'active'),
('S003', 'Hazwani Hanum', '$2y$10$4Dyac7fipV0dEH7GDOwA/Ofb5ZEHUeYwqxgxhX5U6jybfb9Nr3Wv6', '$2y$10$4Dyac7fipV0dEH7GDOwA/Ofb5ZEHUeYwqxgxhX5U6jybfb9Nr3Wv6', 'student', 'active'),
('S004', 'Hanisah', '$2y$10$lmOu.7NFUiSZUOR5DxwddeyA/8MZp1cbUXMWaTcfK5uHuu2F3J4KC', '$2y$10$lmOu.7NFUiSZUOR5DxwddeyA/8MZp1cbUXMWaTcfK5uHuu2F3J4KC', 'student', 'active'),
('T001', 'Seri Mersing', '$2y$10$HU7X3bw3STv.pcNMUeiNsunLc5CKB/JQpqr50DMCx/TYU.3BuoCsi', '$2y$10$9OCuk78V3J9VmfsOzVP3QO/guelard5YLuPdDG9GvW/giCkwBet9q', 'teacher', 'inactive'),
('T002', 'Maisarah', '$2y$10$scX6G9oGqh6mBljffIbcUORvwrDb1I9SBNWIZjkRwaksbdg8G4rLa', '$2y$10$6Kx2XaY4HbN/5L0uOcKyOOdhPw2Qsn6PldKetuavkqrm9gBA0f6sK', 'teacher', 'active'),
('T003', 'Norahayu', '$2y$10$tM39PnX9gc1CdbY8dNXc9OHdC2IQESFbv8setaS6jYFVboup1hOpi', '$2y$10$tXZK6YdOrRrVuP/AzIJf6.cm/7Jl9qSk4p2JoeJN4LZyh/ZNySOPi', 'teacher', 'active'),
('T004', 'Luqman Hakim', '$2y$10$z0xJB3igc55/x9OWa/gCpeVL5b0d01dG0nk7ZVtHaBSwJ2qrQJwdS', '$2y$10$z0xJB3igc55/x9OWa/gCpeVL5b0d01dG0nk7ZVtHaBSwJ2qrQJwdS', 'teacher', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `probar`
--

CREATE TABLE `probar` (
  `ProductCode` varchar(20) NOT NULL,
  `ProductID` varchar(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `probar`
--

INSERT INTO `probar` (`ProductCode`, `ProductID`) VALUES
('9557950610373', 'PRO0001'),
('8993242597037', 'PRO003'),
('4902430738064', 'PRO004'),
('9557368043015', 'PRO005'),
('9556283201548', 'PRO006'),
('0000000001', 'PRO007'),
('9690767265', 'PRO008'),
('5423253994', 'PRO009'),
('4549131077445', 'PRO010'),
('9555024502555', 'PRO011');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `ProductID` varchar(7) NOT NULL,
  `ProductName` varchar(50) NOT NULL,
  `status` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`ProductID`, `ProductName`, `status`) VALUES
('PRO0001', 'A4 Paper', 'active'),
('PRO003', 'Baju Sukan', 'active'),
('PRO004', 'roti', 'active'),
('PRO005', 'Pen', 'active'),
('PRO006', 'Tudung Sekolah', 'active'),
('PRO007', 'Mineral Water', 'active'),
('PRO008', 'English book', 'active'),
('PRO009', 'lexus', 'active'),
('PRO010', 'seluar sekolah', 'active'),
('PRO011', 'paper clip', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `productinfo`
--

CREATE TABLE `productinfo` (
  `ProductID` varchar(7) NOT NULL,
  `SellPrice` decimal(4,2) NOT NULL,
  `BuyPrice` decimal(4,2) NOT NULL,
  `Categoryname` varchar(20) NOT NULL,
  `lowLevel` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `productinfo`
--

INSERT INTO `productinfo` (`ProductID`, `SellPrice`, `BuyPrice`, `Categoryname`, `lowLevel`) VALUES
('PRO0001', '13.00', '10.00', 'Book/Paper', 4),
('PRO003', '15.00', '12.00', 'Cloth', 5),
('PRO004', '4.00', '3.00', 'Food', 5),
('PRO005', '3.00', '2.00', 'Stationary', 5),
('PRO006', '7.00', '5.00', 'Cloth', 5),
('PRO007', '1.50', '1.00', 'Food', 9),
('PRO008', '20.00', '18.00', 'Book/Paper', 5),
('PRO009', '2.50', '2.00', 'Food', 5),
('PRO010', '5.00', '4.00', 'Cloth', 10),
('PRO011', '1.00', '0.50', 'Stationary', 10);

-- --------------------------------------------------------

--
-- Table structure for table `purchase`
--

CREATE TABLE `purchase` (
  `Purchase_D_ID` varchar(13) NOT NULL,
  `Quantity` int(10) NOT NULL,
  `PurchaseDate` date NOT NULL,
  `TotalPrice` decimal(4,2) NOT NULL,
  `PayType` varchar(5) NOT NULL,
  `UserID` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `purchase`
--

INSERT INTO `purchase` (`Purchase_D_ID`, `Quantity`, `PurchaseDate`, `TotalPrice`, `PayType`, `UserID`) VALUES
('PCH0630175319', 2, '2023-06-30', '22.00', 'Cash', 'T002'),
('PCH0630175913', 3, '2023-06-30', '4.50', 'Cash', 'T002'),
('PCH0702195524', 2, '2023-07-02', '4.00', 'Cash', 'T002'),
('PCH0703100030', 3, '2023-07-03', '6.50', 'Cash', 'T002'),
('PCH0703102829', 1, '2023-07-03', '1.50', 'Cash', 'T002');

-- --------------------------------------------------------

--
-- Table structure for table `purchasedetail`
--

CREATE TABLE `purchasedetail` (
  `TransID` int(5) NOT NULL,
  `Purchase_D_ID` varchar(13) NOT NULL,
  `ProductID` varchar(7) NOT NULL,
  `noItem` int(5) NOT NULL,
  `Price` decimal(4,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `purchasedetail`
--

INSERT INTO `purchasedetail` (`TransID`, `Purchase_D_ID`, `ProductID`, `noItem`, `Price`) VALUES
(70, 'PCH0630175319', 'PRO008', 1, '20.00'),
(71, 'PCH0630175319', 'PRO007', 1, '2.00'),
(72, 'PCH0630175913', 'PRO007', 3, '1.50'),
(73, 'PCH0702195524', 'PRO007', 1, '1.50'),
(74, 'PCH0702195524', 'PRO009', 1, '2.50'),
(75, 'PCH0703100030', 'PRO007', 1, '1.50'),
(76, 'PCH0703100030', 'PRO009', 2, '2.50'),
(77, 'PCH0703102829', 'PRO007', 1, '1.50');

-- --------------------------------------------------------

--
-- Table structure for table `rollback`
--

CREATE TABLE `rollback` (
  `ID` int(11) NOT NULL,
  `UserID` varchar(8) NOT NULL,
  `Datetime` datetime NOT NULL,
  `Details` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rollback`
--

INSERT INTO `rollback` (`ID`, `UserID`, `Datetime`, `Details`) VALUES
(5, 'T003', '2023-06-22 09:03:26', 'FullName:Norahayu;gender:Female;Email:NVJFMGhtWTZJbmU3Wmp3ZnozZFNUVENybXFidDR2K3pGc2g2OC8zajFpST06Oo+IPMauvK0LiucUm4Ek53k=;Phone:T2tqTURaZlI4ajlJeXg5N05HQ21qZz09OjolaqhNloKECFkBYtTDuDAl;IC:bC9DVjRmL21LbGoyWkFFdkpGMXBHZz09OjoKHid45dXouqqlXtZ51m0c;'),
(6, 'S002', '2023-06-22 09:08:40', 'FullName:Najmi;gender:female;Email:YUwyb1lLTEJVM0h6aFVmaTFFaWh5ZENFWjNkNzFvL0VKOUZUcFpGWFJaND06OiHA20/dD2n2Abv6NuGQe08=;Phone:WFY1QkRnZ2doMi90d295alI3U3VRQT09OjozG3Yq2OJrYB11V3UcR6mL;IC:Mmg4ME9iMGRab1loVmJSaUoyNitJUT09Ojp+TnqrVlJJYpUcdHyvqvjY;'),
(7, 'T001', '2023-07-03 01:47:57', 'FullName:Seri Mersing;gender:Female;Email:NVJFMGhtWTZJbmU3Wmp3ZnozZFNUVENybXFidDR2K3pGc2g2OC8zajFpST06Oo+IPMauvK0LiucUm4Ek53k=;Phone:T2tqTURaZlI4ajlJeXg5N05HQ21qZz09OjolaqhNloKECFkBYtTDuDAl;IC:bC9DVjRmL21LbGoyWkFFdkpGMXBHZz09OjoKHid45dXouqqlXtZ51m0c;'),
(8, 'S001', '2023-07-03 01:48:43', 'FullName:Syazwana;gender:female;Email:a2lhNEpCT0U0K21vbXE1eXJqMUk4UT09OjrdkUfJ47wgB7OFSQ9wkvLH;Phone:SmUxL2oyc2h3c2Ztd3RrTUNzeFZHdz09OjoP5Bd+5OhOh17A7cA5F0kW;IC:VTlvaEJDc0hBV2djY0R5SVBwM0lJUT09Ojo1OnZf10vBSBJW52OtU4M5;'),
(9, 'T001', '2023-07-03 10:14:24', 'FullName:Seri Mersing;gender:Female;Email:NVJFMGhtWTZJbmU3Wmp3ZnozZFNUVENybXFidDR2K3pGc2g2OC8zajFpST06Oo+IPMauvK0LiucUm4Ek53k=;Phone:T2tqTURaZlI4ajlJeXg5N05HQ21qZz09OjolaqhNloKECFkBYtTDuDAl;IC:bC9DVjRmL21LbGoyWkFFdkpGMXBHZz09OjoKHid45dXouqqlXtZ51m0c;'),
(10, 'T001', '2023-07-03 15:54:35', 'FullName:Seri Mersing;gender:Female;Email:NVJFMGhtWTZJbmU3Wmp3ZnozZFNUVENybXFidDR2K3pGc2g2OC8zajFpST06Oo+IPMauvK0LiucUm4Ek53k=;Phone:T2tqTURaZlI4ajlJeXg5N05HQ21qZz09OjolaqhNloKECFkBYtTDuDAl;IC:bC9DVjRmL21LbGoyWkFFdkpGMXBHZz09OjoKHid45dXouqqlXtZ51m0c;'),
(11, 'T002', '2023-07-03 16:24:33', 'FullName:Maisarah;gender:Female;Email:NVJFMGhtWTZJbmU3Wmp3ZnozZFNUVENybXFidDR2K3pGc2g2OC8zajFpST06Oo+IPMauvK0LiucUm4Ek53k=;Phone:T2tqTURaZlI4ajlJeXg5N05HQ21qZz09OjolaqhNloKECFkBYtTDuDAl;IC:bC9DVjRmL21LbGoyWkFFdkpGMXBHZz09OjoKHid45dXouqqlXtZ51m0c;'),
(12, 'T002', '2023-07-04 12:07:05', 'FullName:Maisarah;gender:Female;Email:NVJFMGhtWTZJbmU3Wmp3ZnozZFNUVENybXFidDR2K3pGc2g2OC8zajFpST06Oo+IPMauvK0LiucUm4Ek53k=;Phone:T2tqTURaZlI4ajlJeXg5N05HQ21qZz09OjolaqhNloKECFkBYtTDuDAl;IC:bC9DVjRmL21LbGoyWkFFdkpGMXBHZz09OjoKHid45dXouqqlXtZ51m0c;');

-- --------------------------------------------------------

--
-- Table structure for table `rollbackproduct`
--

CREATE TABLE `rollbackproduct` (
  `ID` int(11) NOT NULL,
  `After` varchar(6) NOT NULL,
  `ProductID` varchar(7) NOT NULL,
  `DateTime` datetime NOT NULL,
  `Details` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rollbackproduct`
--

INSERT INTO `rollbackproduct` (`ID`, `After`, `ProductID`, `DateTime`, `Details`) VALUES
(1, 'Edit', 'PRO007', '2023-06-22 21:23:36', 'Name:Mineral Water;SellPrice:1.50;BuyPrice:1.20;Category:Food;MinLevel:9;'),
(2, 'Edit', 'PRO009', '2023-07-03 01:52:29', 'Name:lexus;SellPrice:2.50;BuyPrice:2.00;Category:Food;MinLevel:5;');

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `ProductID` varchar(7) NOT NULL,
  `quantity` int(15) NOT NULL,
  `expired` text DEFAULT NULL,
  `date_In` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`ProductID`, `quantity`, `expired`, `date_In`) VALUES
('PRO0001', 8, '', '2023-06-30'),
('PRO003', 5, '', '2023-05-28'),
('PRO004', 6, '2023-05-29', '2023-05-27'),
('PRO005', 3, '', '2023-05-28'),
('PRO006', 11, '', '2023-05-27'),
('PRO007', 12, '', '2023-06-22'),
('PRO008', 10, '', '2023-07-03'),
('PRO009', 17, '2023-07-15', '2023-07-03'),
('PRO010', 0, NULL, ''),
('PRO011', 0, NULL, '');

-- --------------------------------------------------------

--
-- Table structure for table `studentinfo`
--

CREATE TABLE `studentinfo` (
  `UserID` varchar(8) NOT NULL,
  `gender` varchar(15) NOT NULL,
  `email` text NOT NULL,
  `PhoneNum` text NOT NULL,
  `IC` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `studentinfo`
--

INSERT INTO `studentinfo` (`UserID`, `gender`, `email`, `PhoneNum`, `IC`) VALUES
('S001', 'female', 'a2lhNEpCT0U0K21vbXE1eXJqMUk4UT09OjrdkUfJ47wgB7OFSQ9wkvLH', 'SmUxL2oyc2h3c2Ztd3RrTUNzeFZHdz09OjoP5Bd+5OhOh17A7cA5F0kW', 'VTlvaEJDc0hBV2djY0R5SVBwM0lJUT09Ojo1OnZf10vBSBJW52OtU4M5'),
('S002', 'female', 'YUwyb1lLTEJVM0h6aFVmaTFFaWh5ZENFWjNkNzFvL0VKOUZUcFpGWFJaND06OiHA20/dD2n2Abv6NuGQe08=', 'WFY1QkRnZ2doMi90d295alI3U3VRQT09OjozG3Yq2OJrYB11V3UcR6mL', 'Mmg4ME9iMGRab1loVmJSaUoyNitJUT09Ojp+TnqrVlJJYpUcdHyvqvjY'),
('S003', 'Female', 'eUlmTW9STzVYUUlFUHJRa1JackJIWXpxQ3dCbHFWYnhWU1FTOWYxQUVtND06Ogr2I3O9RuqRuh2mNWb9nYk=', 'WWZmd3ZhbkFQdGtNSHRyWks1RVpMdz09Ojp7PoAa28g7+K1QfdVellmj', 'Q1VHblNld2gvemsva3dDSC81TEs0Zz09OjqwvGglvBCVZAGzR3bg1foQ'),
('S004', 'Female', 'T1FwSkNubjBUTSsxQjZOSG42MjZlN3IwdmRGMjVwV0U2VTlRc01ia1lDVT06OjdcBhsJdyrvD6VVAg4tjDY=', 'L2thbXY3ZS9rYUlrN3ZNVVVlSWtTZz09OjrVB1/Wn/nXzbpYXL5An1wL', 'YktDOC9LR09GWXptWHpGNnlrMlREUT09OjrGeN9IYz8nq8KPoJK5cWPP');

-- --------------------------------------------------------

--
-- Table structure for table `teacherinfo`
--

CREATE TABLE `teacherinfo` (
  `UserID` varchar(8) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `email` text NOT NULL,
  `PhoneNum` text NOT NULL,
  `IC` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `teacherinfo`
--

INSERT INTO `teacherinfo` (`UserID`, `gender`, `email`, `PhoneNum`, `IC`) VALUES
('T001', 'Female', 'NVJFMGhtWTZJbmU3Wmp3ZnozZFNUVENybXFidDR2K3pGc2g2OC8zajFpST06Oo+IPMauvK0LiucUm4Ek53k=', 'T2tqTURaZlI4ajlJeXg5N05HQ21qZz09OjolaqhNloKECFkBYtTDuDAl', 'bC9DVjRmL21LbGoyWkFFdkpGMXBHZz09OjoKHid45dXouqqlXtZ51m0c'),
('T002', 'Female', 'NVJFMGhtWTZJbmU3Wmp3ZnozZFNUVENybXFidDR2K3pGc2g2OC8zajFpST06Oo+IPMauvK0LiucUm4Ek53k=', 'T2tqTURaZlI4ajlJeXg5N05HQ21qZz09OjolaqhNloKECFkBYtTDuDAl', 'bC9DVjRmL21LbGoyWkFFdkpGMXBHZz09OjoKHid45dXouqqlXtZ51m0c'),
('T003', 'Female', 'NVJFMGhtWTZJbmU3Wmp3ZnozZFNUVENybXFidDR2K3pGc2g2OC8zajFpST06Oo+IPMauvK0LiucUm4Ek53k=', 'T2tqTURaZlI4ajlJeXg5N05HQ21qZz09OjolaqhNloKECFkBYtTDuDAl', 'bC9DVjRmL21LbGoyWkFFdkpGMXBHZz09OjoKHid45dXouqqlXtZ51m0c'),
('T004', 'Male', 'WktYbmZacnQrNk8venJvZ0pWZWM4M1NFVzVwc0FLbVpVd1NQaFIzZ1hjbz06OlKXSzm/qiY5if8Daq6YucE=', 'dVYyMkdmY3pHWlRJc3YzNit5MmZFZz09Ojr0HJmy4kHtphSntgpJUa4E', 'dFU0R3dBd0FJY0I1LytFM3kyZEx6dz09Ojq9u6O8RQKBTWUfWU9sB0e8');

-- --------------------------------------------------------

--
-- Table structure for table `token`
--

CREATE TABLE `token` (
  `UserID` varchar(8) NOT NULL,
  `exp_date` varchar(30) NOT NULL,
  `reset_link_token` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `token`
--

INSERT INTO `token` (`UserID`, `exp_date`, `reset_link_token`) VALUES
('A001', '', ''),
('S001', '', ''),
('S002', '', ''),
('S003', '', ''),
('S004', '', ''),
('T001', '', ''),
('T002', '', ''),
('T003', '', ''),
('T004', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admininfo`
--
ALTER TABLE `admininfo`
  ADD PRIMARY KEY (`UserID`);

--
-- Indexes for table `editlog`
--
ALTER TABLE `editlog`
  ADD PRIMARY KEY (`LogID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `editproduct`
--
ALTER TABLE `editproduct`
  ADD PRIMARY KEY (`LogID`),
  ADD KEY `ProductID` (`ProductID`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`UserID`);

--
-- Indexes for table `probar`
--
ALTER TABLE `probar`
  ADD PRIMARY KEY (`ProductCode`),
  ADD KEY `ProductID` (`ProductID`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`ProductID`);

--
-- Indexes for table `productinfo`
--
ALTER TABLE `productinfo`
  ADD PRIMARY KEY (`ProductID`);

--
-- Indexes for table `purchase`
--
ALTER TABLE `purchase`
  ADD PRIMARY KEY (`Purchase_D_ID`),
  ADD KEY `UsedID` (`UserID`);

--
-- Indexes for table `purchasedetail`
--
ALTER TABLE `purchasedetail`
  ADD PRIMARY KEY (`TransID`),
  ADD KEY `Purchase_D_ID` (`Purchase_D_ID`),
  ADD KEY `ProductID` (`ProductID`);

--
-- Indexes for table `rollback`
--
ALTER TABLE `rollback`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `rollbackproduct`
--
ALTER TABLE `rollbackproduct`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ProductID` (`ProductID`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`ProductID`);

--
-- Indexes for table `studentinfo`
--
ALTER TABLE `studentinfo`
  ADD PRIMARY KEY (`UserID`);

--
-- Indexes for table `teacherinfo`
--
ALTER TABLE `teacherinfo`
  ADD PRIMARY KEY (`UserID`);

--
-- Indexes for table `token`
--
ALTER TABLE `token`
  ADD PRIMARY KEY (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `editlog`
--
ALTER TABLE `editlog`
  MODIFY `LogID` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `editproduct`
--
ALTER TABLE `editproduct`
  MODIFY `LogID` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `purchasedetail`
--
ALTER TABLE `purchasedetail`
  MODIFY `TransID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `rollback`
--
ALTER TABLE `rollback`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `rollbackproduct`
--
ALTER TABLE `rollbackproduct`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admininfo`
--
ALTER TABLE `admininfo`
  ADD CONSTRAINT `admininfo_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `login` (`UserID`);

--
-- Constraints for table `editlog`
--
ALTER TABLE `editlog`
  ADD CONSTRAINT `editlog_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `login` (`UserID`);

--
-- Constraints for table `editproduct`
--
ALTER TABLE `editproduct`
  ADD CONSTRAINT `editproduct_ibfk_1` FOREIGN KEY (`ProductID`) REFERENCES `product` (`ProductID`);

--
-- Constraints for table `probar`
--
ALTER TABLE `probar`
  ADD CONSTRAINT `probar_ibfk_1` FOREIGN KEY (`ProductID`) REFERENCES `product` (`ProductID`);

--
-- Constraints for table `productinfo`
--
ALTER TABLE `productinfo`
  ADD CONSTRAINT `productinfo_ibfk_1` FOREIGN KEY (`ProductID`) REFERENCES `product` (`ProductID`);

--
-- Constraints for table `purchase`
--
ALTER TABLE `purchase`
  ADD CONSTRAINT `purchase_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `login` (`UserID`);

--
-- Constraints for table `purchasedetail`
--
ALTER TABLE `purchasedetail`
  ADD CONSTRAINT `purchasedetail_ibfk_1` FOREIGN KEY (`Purchase_D_ID`) REFERENCES `purchase` (`Purchase_D_ID`),
  ADD CONSTRAINT `purchasedetail_ibfk_2` FOREIGN KEY (`ProductID`) REFERENCES `product` (`ProductID`);

--
-- Constraints for table `rollback`
--
ALTER TABLE `rollback`
  ADD CONSTRAINT `rollback_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `login` (`UserID`);

--
-- Constraints for table `rollbackproduct`
--
ALTER TABLE `rollbackproduct`
  ADD CONSTRAINT `rollbackproduct_ibfk_1` FOREIGN KEY (`ProductID`) REFERENCES `product` (`ProductID`);

--
-- Constraints for table `stock`
--
ALTER TABLE `stock`
  ADD CONSTRAINT `stock_ibfk_1` FOREIGN KEY (`ProductID`) REFERENCES `product` (`ProductID`);

--
-- Constraints for table `studentinfo`
--
ALTER TABLE `studentinfo`
  ADD CONSTRAINT `studentinfo_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `login` (`UserID`);

--
-- Constraints for table `teacherinfo`
--
ALTER TABLE `teacherinfo`
  ADD CONSTRAINT `teacherinfo_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `login` (`UserID`);

--
-- Constraints for table `token`
--
ALTER TABLE `token`
  ADD CONSTRAINT `token_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `login` (`UserID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
