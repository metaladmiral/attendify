-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 29, 2023 at 07:46 PM
-- Server version: 10.3.37-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mvmtnqxp_admin`
--

-- --------------------------------------------------------

--
-- Table structure for table `contracts`
--

CREATE TABLE `contracts` (
  `id` int(11) NOT NULL,
  `propid` varchar(50) NOT NULL,
  `aptid` varchar(100) NOT NULL,
  `lname` varchar(100) NOT NULL,
  `llid` varchar(100) NOT NULL,
  `tname` varchar(100) NOT NULL,
  `ttid` varchar(100) NOT NULL,
  `amount` varchar(100) NOT NULL,
  `rentalperiod` varchar(100) NOT NULL,
  `note` varchar(300) NOT NULL,
  `moveoutdate` date DEFAULT NULL,
  `ldate` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contracts`
--

INSERT INTO `contracts` (`id`, `propid`, `aptid`, `lname`, `llid`, `tname`, `ttid`, `amount`, `rentalperiod`, `note`, `moveoutdate`, `ldate`) VALUES
(18, 'pr69664232f9f4884f', 'pr65164009ad18803e', 'Prakhar Sinha', 'pr6516377fd84a01e0920812860', 'Prakhar Sinha', 'pr69638cb4c7a46ad754521425', '3200.00', '120', 'apartmente wjrqwijoidd asdoaskdopaps asoiaosdqw hollaaaa aswith the e apartme tn nerjaskldksld askjasdajskqioe qeiqweapartmente wjrqwijoidd asdoaskdopaps asoiaosdqw hollaaaa aswith the e apartme tn nerjaskldksld askjajskqioe qeiqweasdasdaasdas', '2023-07-28', '1680286841'),
(20, 'pr6966424613bbee27', 'pr651639f14d5cc851', 'Prakhar Sinha', 'pr6516377fd84a01e0920812860', 'Prakhar Sinha', 'pr69638cb4c7a46ad754521425', '7862.40', '273', 'sendringasdf asdjuaiosdu arsasrproposal asdasudansd asdassendringasdf asdjuaihjkhjkosdu arsasrpropos1234234al ashkdasuasddansd asdassendringasdf asdjuaiosdu arsasrproposal asdasudansd asdfkhjhjkdas', '2023-12-29', '1680365136');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contracts`
--
ALTER TABLE `contracts`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contracts`
--
ALTER TABLE `contracts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
