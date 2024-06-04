-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1:3306
-- 產生時間： 2024-06-04 21:26:16
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
  `print_date` date NOT NULL,
  `title` varchar(50) NOT NULL,
  `account` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `inventory`
--

INSERT INTO `inventory` (`plan_name`, `document_code`, `inventory_number`, `plan_number`, `budget_subject`, `print_date`, `title`, `account`) VALUES
('該合作還是與之為敵？資源短缺下臺灣軟體科技新創加速成長中的資源重配置與競合決策流程探討', 'dd4174d8-c33b-46ab-9406-3b0bee9784ff', '4b365b70b5', '111B111037', '住宿費', '2024-06-05', '國立政治', '111306086');

-- --------------------------------------------------------

--
-- 資料表結構 `plan`
--

CREATE TABLE `plan` (
  `plan_name` varchar(50) NOT NULL,
  `plan_number` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `plan`
--

INSERT INTO `plan` (`plan_name`, `plan_number`) VALUES
('該合作還是與之為敵？資源短缺下臺灣軟體科技新創加速成長中的資源重配置與競合決策流程探討', '111B111037'),
('社交人形機器人於輕度認知障礙之高齡照護探討：結合可用性評估和機器學習於輔助科技之應用(1/3)', '111B111057'),
('人工智慧模型的軟體驗證與資訊安全', '112B112113'),
('數據轉換系統的正確性與可解釋性的自動推論(1/3)', '112B112151'),
('破解TikTok直播商務成功的密碼：一種多模態特徵粹取方法', '112B112243');

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
  `date` date NOT NULL,
  `inventory_number` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `receipt_keeping_list`
--

CREATE TABLE `receipt_keeping_list` (
  `total_amount` int(50) NOT NULL,
  `plan_number` varchar(50) NOT NULL,
  `budget_subject` varchar(50) NOT NULL,
  `document_amount` int(50) NOT NULL,
  `inventory_number` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `receipt_keeping_list`
--

INSERT INTO `receipt_keeping_list` (`total_amount`, `plan_number`, `budget_subject`, `document_amount`, `inventory_number`) VALUES
(2000, '111B111037', '住宿費', 2000, '4b365b70b5');

-- --------------------------------------------------------

--
-- 資料表結構 `status`
--

CREATE TABLE `status` (
  `ispass` tinyint(1) NOT NULL,
  `inventory_number` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `user`
--

CREATE TABLE `user` (
  `password` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `name` varchar(50) NOT NULL,
  `account` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `user`
--

INSERT INTO `user` (`password`, `name`, `account`) VALUES
('111', '', ''),
('0811', 'ZJJ', '086'),
('1234', '', ''),
('0811', '鄭建捷', '111306086');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`inventory_number`);

--
-- 資料表索引 `plan`
--
ALTER TABLE `plan`
  ADD PRIMARY KEY (`plan_number`);

--
-- 資料表索引 `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`inventory_number`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
