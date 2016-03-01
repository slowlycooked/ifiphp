-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 28, 2015 at 08:40 AM
-- Server version: 5.6.27
-- PHP Version: 5.6.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `zenfi`
--

-- --------------------------------------------------------

--
-- Table structure for table `BOOKS`
--

CREATE TABLE `BOOKS` (
  `OID` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `BID` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `BNAME` varchar(250) COLLATE utf8_unicode_ci NOT NULL COMMENT 'BOOK NAME'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `BOOKS`
--

INSERT INTO `BOOKS` (`OID`, `BID`, `BNAME`) VALUES
('001', '001', '碗筷流水'),
('001', '002', '饭店流水'),
('001', '003', '测试账本1');

-- --------------------------------------------------------

--
-- Table structure for table `CLIENT`
--

CREATE TABLE `CLIENT` (
  `OID` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `BID` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `CID` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `NAME` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `CONTACT` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `PHONE` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `TYPE` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `STATUS` varchar(45) COLLATE utf8_unicode_ci DEFAULT 'A',
  `LASTUP` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `CLIENT`
--

INSERT INTO `CLIENT` (`OID`, `BID`, `CID`, `NAME`, `CONTACT`, `PHONE`, `TYPE`, `STATUS`, `LASTUP`) VALUES
('001', '001', '000E', '山里人家', '张三', '0000', 'Type', 'A', '2015-10-02 22:18:39'),
('001', '001', '0011', '好吃婆婆', '张三', '0000', 'Type', 'A', '2015-10-02 22:18:39'),
('001', '001', '0012', '潇湘酒家', '张三', '0000', 'Type', 'A', '2015-10-02 22:18:39'),
('001', '001', '0013', '方家坪', '张三', '0000', 'Type', 'A', '2015-10-27 10:44:02'),
('001', '001', '0014', '宏利', '张三', '0000', 'Type', 'A', '2015-10-02 22:18:39'),
('001', '001', '0015', '地婆', '张三', '0000', 'Type', 'A', '2015-10-02 22:18:39'),
('001', '001', '0017', '福兴', '张三', '0000', 'Type', 'A', '2015-10-02 22:18:39'),
('001', '001', '0018', '屈原土莱', '张三', '0000', 'Type', 'A', '2015-10-02 22:18:39'),
('001', '001', '001B', '交通饭店', '张三', '0000', 'Type', 'A', '2015-10-02 22:18:39'),
('001', '001', '001C', '渔公渔婆', '张三', '0000', 'Type', 'A', '2015-10-02 22:18:39'),
('001', '001', '001E', '公园土菜', '张三', '0000', 'Type', 'A', '2015-10-02 22:18:39'),
('001', '001', '001F', '金鑫', '张三', '0000', 'Type', 'A', '2015-10-02 22:18:39'),
('001', '001', '0020', '杨胖子', '张三', '0000', 'Type', 'A', '2015-10-02 22:18:39'),
('001', '001', '0022', '乡里土菜', '张三', '0000', 'Type', 'A', '2015-10-02 22:18:39'),
('001', '001', '0026', '安乡九三鸭霸王', '张三', '0000', 'Type', 'A', '2015-10-02 22:18:39'),
('001', '001', '002B', '开开三宝', '张三', '0000', 'Type', 'A', '2015-10-02 22:18:39'),
('001', '001', '002E', '白水饭店', '张三', '0000', 'Type', 'A', '2015-10-02 22:18:39'),
('001', '001', '002F', '八哥私房菜', '张三', '0000', 'Type', 'A', '2015-10-02 22:18:39'),
('001', '001', '0032', '天域', '张三', '0000', 'Type', 'A', '2015-10-02 22:18:39'),
('001', '001', '0033', '酒席', '张三', '0000', 'Type', 'A', '2015-10-02 22:18:39'),
('001', '001', '0035', '大家庭', '张三', '0000', 'Type', 'A', '2015-10-02 22:18:39'),
('001', '001', '0039', '步步高', '张三', '0000', 'Type', 'A', '2015-10-02 22:18:39'),
('001', '001', '003A', '鱼米香', '张三', '0000', 'Type', 'A', '2015-10-02 22:18:39'),
('001', '001', '003B', '鸿福楼', '张三', '0000', 'Type', 'A', '2015-10-02 22:18:39'),
('001', '001', '003C', '好滋味', '张三', '0000', 'Type', 'A', '2015-10-02 22:18:39'),
('001', '001', '003D', '喜洋洋', '张三', '0000', 'Type', 'A', '2015-10-02 22:18:39'),
('001', '001', '003E', '杨裕兴', '张三', '0000', 'Type', 'A', '2015-10-02 22:18:39'),
('001', '001', '003F', '双圹大酒店', '张三', '0000', 'Type', 'A', '2015-10-02 22:18:39'),
('001', '001', '0040', '夜夜宵夜', '张三', '0000', 'Type', 'A', '2015-10-02 22:18:39'),
('001', '001', '0048', '天虾河蟹', '', '', NULL, 'A', '2015-10-27 10:18:19'),
('001', '001', '0057', '1234', '', '', NULL, 'A', '2015-10-27 11:04:50'),
('001', '002', '0051', '煤气', '', '', NULL, 'A', '2015-10-07 17:57:45'),
('001', '002', '0052', '电费', '', '', NULL, 'A', '2015-10-07 17:57:55'),
('001', '002', '0053', '工资', '', '', NULL, 'A', '2015-10-07 17:58:00'),
('001', '002', '0054', '1111111', '', '', NULL, 'A', '2015-10-09 23:03:18'),
('001', '003', '0050', '测试a', '', '', NULL, 'A', '2015-10-07 17:56:17'),
('001', '003', '0055', '', '', '', NULL, 'A', '2015-10-09 23:50:02');

-- --------------------------------------------------------

--
-- Table structure for table `LOGINLOG`
--

CREATE TABLE `LOGINLOG` (
  `USERNAME` varchar(32) NOT NULL,
  `TIME` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `LOGINLOG`
--

INSERT INTO `LOGINLOG` (`USERNAME`, `TIME`) VALUES
('1', '2015-10-27 02:22:00'),
('', '2015-10-27 03:32:33'),
('', '2015-10-27 03:33:59'),
('3', '2015-10-27 03:35:01');

-- --------------------------------------------------------

--
-- Table structure for table `TRANSC`
--

CREATE TABLE `TRANSC` (
  `OID` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `BID` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `CID` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `TID` varchar(13) COLLATE utf8_unicode_ci NOT NULL,
  `DATE` datetime DEFAULT CURRENT_TIMESTAMP,
  `DEBIT` decimal(13,2) DEFAULT '0.00',
  `CREDIT` decimal(13,2) DEFAULT '0.00',
  `BAD` decimal(13,2) DEFAULT '0.00',
  `COMMENT` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `TRANSC`
--

INSERT INTO `TRANSC` (`OID`, `BID`, `CID`, `TID`, `DATE`, `DEBIT`, `CREDIT`, `BAD`, `COMMENT`) VALUES
('001', '001', '0001', '55B75D9F4626E', '2015-07-28 18:46:45', '1000.00', '0.00', '0.00', NULL),
('001', '001', '0001', '55B765BC01763', '2015-07-28 19:21:19', '0.00', '500.00', '0.00', NULL),
('001', '001', '0001', '55B878B45631B', '2015-07-29 14:53:26', '1528.00', '0.00', '0.00', NULL),
('001', '001', '0001', '55B878DD494A2', '2015-07-29 14:54:44', '1258.00', '0.00', '0.00', NULL),
('001', '001', '0001', '55B87901EA686', '2015-07-29 14:55:25', '0.00', '12588.00', '0.00', NULL),
('001', '001', '0001', '55BDE3D2426EB', '2015-08-02 17:32:51', '1000.00', '0.00', '0.00', NULL),
('001', '001', '0001', '560D2D6957431', '2015-10-01 20:56:01', '100.00', '0.00', '0.00', NULL),
('001', '001', '0002', '53C9B3E8B0F68', '2014-07-19 07:55:14', '10.00', '0.00', '0.00', NULL),
('001', '001', '0002', '53C9B3ECEE703', '2014-07-19 07:55:20', '0.00', '5.00', '0.00', NULL),
('001', '001', '0004', '559A3CBE05893', '2015-07-06 16:30:39', '100.00', '0.00', '0.00', NULL),
('001', '001', '0004', '559A3CD58E39C', '2015-07-06 16:30:54', '0.00', '99.00', '1.00', NULL),
('001', '001', '0006', '560E9F835E77E', '2015-10-02 23:14:54', '1.00', '0.00', '0.00', NULL),
('001', '001', '0006', '560E9F8C09C10', '2015-10-02 23:15:19', '1.00', '0.00', '0.00', NULL),
('001', '001', '0006', '560EA007AEAFC', '2015-10-02 23:17:23', '1.00', '0.00', '0.00', NULL),
('001', '001', '0006', '560EA0E73FBAB', '2015-10-02 23:21:06', '1.00', '0.00', '0.00', NULL),
('001', '001', '0006', '560EA148A3D83', '2015-10-02 23:22:46', '1.00', '0.00', '0.00', NULL),
('001', '001', '0007', '560EA77F95878', '2015-10-02 23:49:15', '1.10', '0.00', '0.00', NULL),
('001', '001', '0007', '560EA78FC2DC1', '2015-10-02 23:49:27', '2.00', '0.00', '0.00', NULL),
('001', '001', '000E', '560D318998F80', '2015-10-01 21:13:35', '100.00', '0.00', '0.00', NULL),
('001', '001', '000E', '560D31B5D6C27', '2015-10-01 21:13:45', '0.00', '50.00', '0.00', NULL),
('001', '001', '000E', '560D31E4DCF21', '2015-10-01 21:14:30', '0.00', '0.00', '50.00', NULL),
('001', '001', '0013', '562EE4F25A58C', '2015-10-27 10:43:54', '110.00', '0.00', '0.00', NULL),
('001', '001', '0046', '560E90DC97E2B', '2015-10-02 22:12:39', '100.00', '0.00', '0.00', NULL),
('001', '001', '0048', '560D321C5030F', '2015-10-01 21:15:42', '1800.00', '1800.00', '0.00', NULL),
('001', '001', '0048', '560EA2AC4ACA4', '2015-10-02 23:28:40', '1000.00', '0.00', '0.00', NULL),
('001', '001', '0056', '5626FF531A4B2', '2015-10-21 10:58:22', '111.00', '0.00', '0.00', NULL),
('001', '001', '0056', '5626FF638DC9B', '2015-10-21 10:58:34', '0.00', '111.00', '0.00', NULL),
('001', '001', '0056', '5627566F51941', '2015-10-21 17:10:04', '1.00', '0.00', '0.00', NULL),
('001', '002', '004E', '5614EC0213B62', '2015-10-07 17:55:07', '2.00', '0.00', '0.00', NULL),
('001', '002', '004F', '5614EBD3BD35F', '2015-10-07 17:54:22', '118.00', '0.00', '0.00', NULL),
('001', '002', '0052', '5614ECC2DF498', '2015-10-07 17:58:14', '1000.00', '0.00', '0.00', NULL),
('001', '002', '0053', '5614ECAE09B10', '2015-10-07 17:58:02', '1000.00', '0.00', '0.00', NULL),
('001', '003', '0050', '5614EC70467F2', '2015-10-07 17:57:02', '1.00', '0.00', '0.00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `USER`
--

CREATE TABLE `USER` (
  `USERNAME` varchar(32) NOT NULL,
  `PASSWORD` varchar(512) NOT NULL,
  `SALT` varchar(512) NOT NULL,
  `OID` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `USER`
--

INSERT INTO `USER` (`USERNAME`, `PASSWORD`, `SALT`, `OID`) VALUES
('1', '8f7949a91135725e2d5dba60eebbcfcb306d30c781d63c87692b041ba6ec3b33d2a7c0d0aee8033c72b26782b144c666de433bc8029dddaf602ee319aac6e9d1', 'acaea0fd344dc4d7137d4d5c4cc6084e22c1ce240c0d15c2d4647853dade12b360e040fa7c1287affd1a2ef1ff6764fb51207b51e644c80748870233057f7153', '001');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `BOOKS`
--
ALTER TABLE `BOOKS`
  ADD PRIMARY KEY (`OID`,`BID`);

--
-- Indexes for table `CLIENT`
--
ALTER TABLE `CLIENT`
  ADD PRIMARY KEY (`OID`,`BID`,`CID`);

--
-- Indexes for table `TRANSC`
--
ALTER TABLE `TRANSC`
  ADD PRIMARY KEY (`OID`,`BID`,`CID`,`TID`);

--
-- Indexes for table `USER`
--
ALTER TABLE `USER`
  ADD PRIMARY KEY (`USERNAME`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
