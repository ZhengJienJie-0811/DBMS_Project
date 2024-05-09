-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1:3306
-- 產生時間： 2024-05-06 16:46:45
-- 伺服器版本： 10.4.32-MariaDB
-- PHP 版本： 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `dbms_project`
--

-- --------------------------------------------------------

--
-- 資料表結構 `inventory`
--

CREATE TABLE `inventory` (
  `plan_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `document_code` varchar(50) NOT NULL,
  `inventory_number` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `plan_number` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `budget_subject` varchar(50) NOT NULL,
  `print_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `receipt_explanation`
--

CREATE TABLE `receipt_explanation` (
  `cost_category` varchar(50) NOT NULL,
  `note` varchar(50) NOT NULL,
  `invoice_number` varchar(50) NOT NULL,
  `total_amount_of_receipt` int(50) NOT NULL,
  `purpose` varchar(50) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `receipt_keeping_list`
--

CREATE TABLE `receipt_keeping_list` (
  `total_amount` int(50) NOT NULL,
  `plan_number` varchar(50) NOT NULL,
  `budget_subject` varchar(50) NOT NULL,
  `document_amount` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `status`
--

CREATE TABLE `status` (
  `ispass` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `user`
--

CREATE TABLE `user` (
  `employee_number` varchar(50) NOT NULL,
  `account` varchar(50) NOT NULL,
  `password` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
