-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 21, 2021 at 06:24 PM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blooddonatedb`
--

-- --------------------------------------------------------

--
-- Table structure for table `blooddata`
--

CREATE TABLE `blooddata` (
  `id` int(11) NOT NULL,
  `hospitalname` varchar(255) NOT NULL,
  `bloodtype` varchar(255) NOT NULL,
  `availability` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `blooddata`
--

INSERT INTO `blooddata` (`id`, `hospitalname`, `bloodtype`, `availability`) VALUES
(1, 'KIMS', 'A+', '100'),
(2, 'AIMS', 'B+', '  1400 '),
(3, 'TMH', 'O', '  300 '),
(6, 'KIMS', 'AB+', '1500'),
(7, 'KIMS', 'B+-', '100'),
(8, 'AIMS', 'B-', '  100 '),
(10, 'KIMS', 'O', '400'),
(11, 'AIMS', 'AB+', '  300 '),
(12, 'KIMS', 'A-', '2500'),
(13, 'GOV', 'A+', '  100 ');

-- --------------------------------------------------------

--
-- Table structure for table `hospitalreg`
--

CREATE TABLE `hospitalreg` (
  `id` int(11) NOT NULL,
  `hospitalname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hospitalreg`
--

INSERT INTO `hospitalreg` (`id`, `hospitalname`, `email`, `password`) VALUES
(1, 'KIMS', 'kims@mail.com', '$2y$10$c48Q8XPvIzIRUMWEnwTGtugGL.Yyw7.ctzRY4wOHu1LHrdibmJRRe'),
(2, 'AIMS', 'aims@mail.com', '$2y$10$bqdgi5.1696CkdcYAwQ8TOaGRmMmndppgvbqfoEPTmQSDCVCDB9g.'),
(3, 'TMH', 'tmh@mail.com', '$2y$10$G7Ezan00KqFWcFC4MRAOluNtV72vcPGIAOga4hSfLqcgN3qnRakN6'),
(6, 'GOV', 'gov@mail.com', '$2y$10$3n381O7K0E2XKfGsTKGuFuqNFiQ9d5RC4Iu..n.DPME0fChSFSOPm');

-- --------------------------------------------------------

--
-- Table structure for table `receiverdata`
--

CREATE TABLE `receiverdata` (
  `id` int(11) NOT NULL,
  `hospitalname` varchar(255) NOT NULL,
  `bloodtype` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `hospital_id` int(11) NOT NULL,
  `useremail` varchar(255) NOT NULL,
  `volume` varchar(255) NOT NULL,
  `isPending` tinyint(1) NOT NULL DEFAULT 1,
  `isAccepted` tinyint(1) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `receiverdata`
--

INSERT INTO `receiverdata` (`id`, `hospitalname`, `bloodtype`, `user_id`, `hospital_id`, `useremail`, `volume`, `isPending`, `isAccepted`, `timestamp`) VALUES
(192, 'AIMS', 'B+', 1, 2, 'anurag@mail.com', '100', 0, 1, '2021-07-21 08:09:28'),
(193, 'AIMS', 'AB+', 1, 11, 'anurag@mail.com', '200', 0, 1, '2021-07-21 08:09:17'),
(194, 'AIMS', 'B-', 3, 8, 'mikun@mail.com', '900', 0, 1, '2021-07-21 08:14:55'),
(196, 'GOV', 'A+', 7, 13, 'mobile@mail.com', '1300', 0, 1, '2021-07-21 09:07:34'),
(198, 'GOV', 'A+', 4, 13, 'rohan@mail.com', '100', 0, 1, '2021-07-21 16:07:14');

-- --------------------------------------------------------

--
-- Table structure for table `receiverreg`
--

CREATE TABLE `receiverreg` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `cpassword` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `receiverreg`
--

INSERT INTO `receiverreg` (`id`, `name`, `email`, `password`, `cpassword`) VALUES
(1, 'Anurag ', 'anurag@mail.com', '$2y$10$GA.RTYoX8pwlCz8qjA1Ad.vZIizz1TmKkPzVc6ox4XiWrpkTQyPAi', '$2y$10$fQb6koryeU41kB70Bih7puBb.EXUNo65C0fXH65B9J299mYDRv3da'),
(3, 'Mikun', 'mikun@mail.com', '$2y$10$Ksf0NjvcyeKXhhonfTgsteXcM5KlgDNafTkrlmvnZdaYrTgPiiey2', '$2y$10$.JO.cf3rTaHnb2Vs2UindeE1O8mzihZGUQbi0xfWZkdwUGZUEUJ5m'),
(4, 'Rohan', 'rohan@mail.com', '$2y$10$tjIvgDpcZaKR5zxvijWXtevrIEgxPjuHmaZ23TPerWCTVV/ad.dNK', '$2y$10$osL.eoT9NlVoXAXlqF/kd.67SQ581Me3.08U0e5xqddIT7rwG7Oxq'),
(5, 'sunny', 'sunny@mail.com', '$2y$10$3xPbqDjIwUCIXDNO2jMYBeTkLRjGGWUqlQ4IVwiQxHRsD2cdcPNy.', '$2y$10$baB7s5tCVCDQ9zuu4syIKeqJg.zDtkrt1XbISfgWaJix7G/OPBrla'),
(6, 'mohan', 'mohan@mail.com', '$2y$10$eTQLFoh6htAqkZeanULyBuOcGTur.a78LKLn9cB1WMAf9a5LX2bOu', '$2y$10$qiPZL7t3xghJ441bBF/0g.UMJgJlXjK1QNkCLxs.pQrSLi28MRfba'),
(7, 'Mobile', 'mobile@mail.com', '$2y$10$l2jUmYpDwF39F47Nsi4z6.8IW6n6SRa7LNfMO6Xo5dYvHMr7RI1lu', '$2y$10$NNQvGNcgONMLZOGenV9BpeENDiGE4UhH/jZHKuCdjNnjt.lumwY7.');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blooddata`
--
ALTER TABLE `blooddata`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hospitalreg`
--
ALTER TABLE `hospitalreg`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `receiverdata`
--
ALTER TABLE `receiverdata`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `receiverreg`
--
ALTER TABLE `receiverreg`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blooddata`
--
ALTER TABLE `blooddata`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `hospitalreg`
--
ALTER TABLE `hospitalreg`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `receiverdata`
--
ALTER TABLE `receiverdata`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=199;

--
-- AUTO_INCREMENT for table `receiverreg`
--
ALTER TABLE `receiverreg`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
