-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2020-12-07 22:34:35
-- 伺服器版本： 10.4.14-MariaDB
-- PHP 版本： 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `final_fantasy`
--

-- --------------------------------------------------------

--
-- 資料表結構 `member`
--

CREATE TABLE `member` (
  `playerId` int(11) NOT NULL,
  `userName` varchar(20) NOT NULL,
  `passWord` varchar(40) DEFAULT NULL,
  `eMail` varchar(20) NOT NULL,
  `userPic` varchar(24) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `member`
--

INSERT INTO `member` (`playerId`, `userName`, `passWord`, `eMail`, `userPic`) VALUES
(1, 'james', '3345678', 'aaa@gmail.com', 'big500_0000_S_001.jpg'),
(2, 'judy', '55688', 'qwer@gmail.com', 'FF-cute.JPG'),
(32, 'qwer', 'qwer', 'qwer@gmail.com', 'pffcocn.png');

-- --------------------------------------------------------

--
-- 資料表結構 `store`
--

CREATE TABLE `store` (
  `productsId` int(11) NOT NULL,
  `productsName` varchar(20) DEFAULT NULL,
  `price` int(10) DEFAULT NULL,
  `picture` varchar(30) DEFAULT NULL,
  `playerId` int(11) DEFAULT NULL,
  `update_time` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `store`
--

INSERT INTO `store` (`productsId`, `productsName`, `price`, `picture`, `playerId`, `update_time`) VALUES
(1, 'Final_Fantasy7', 199, 'FF7.JPG.png', 1, '2020-09-30 20:35:59'),
(2, 'Final_Fantasy8', 299, 'FF8.JPG.png', 1, '2020-10-02 02:35:59'),
(3, 'Final_Fantasy9', 399, 'FF9.JPG.png', 1, '2020-10-03 03:35:59'),
(4, 'FinalFantasy10', 499, 'FF10.JPG.png', 2, '2020-10-04 01:35:59'),
(5, 'FinalFantasy11', 599, 'FF11.JPG.png', 2, '2020-10-05 01:35:59'),
(6, 'FinalFantasy12', 699, 'FF12.JPG.png', 2, '2020-10-06 01:35:59'),
(7, 'FinalFantasy13', 799, 'FF13.JPG.png', 13, '2020-10-07 01:35:59'),
(8, 'FinalFantasy14', 899, 'FF14.JPG.png', 13, '2020-10-07 01:03:00'),
(9, 'FinalFantasy15', 999, 'FF15.JPG.png', 13, '2020-10-07 01:35:59'),
(136, 'Final_Fantasy8', 299, 'FF8.JPG.png', 32, '2020-10-08 06:57:28'),
(137, 'FinalFantasy11', 599, 'FF11.JPG.png', 32, '2020-10-08 06:57:28');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`playerId`);

--
-- 資料表索引 `store`
--
ALTER TABLE `store`
  ADD PRIMARY KEY (`productsId`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `member`
--
ALTER TABLE `member`
  MODIFY `playerId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `store`
--
ALTER TABLE `store`
  MODIFY `productsId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=138;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
