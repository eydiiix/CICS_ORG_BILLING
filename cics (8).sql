-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 07, 2022 at 01:09 PM
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
-- Database: `cics`
--

-- --------------------------------------------------------

--
-- Table structure for table `access`
--

CREATE TABLE `access` (
  `username` varchar(30) NOT NULL,
  `srcode` varchar(255) NOT NULL,
  `year` varchar(4) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `access`
--

INSERT INTO `access` (`username`, `srcode`, `year`, `status`) VALUES
('access', '20-04057', '3rd ', 'Unpaid');

-- --------------------------------------------------------

--
-- Table structure for table `cics-sc`
--

CREATE TABLE `cics-sc` (
  `username` varchar(30) NOT NULL,
  `srcode` varchar(255) NOT NULL,
  `year` varchar(4) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cics-sc`
--

INSERT INTO `cics-sc` (`username`, `srcode`, `year`, `status`) VALUES
('cics', '20-02328', '3rd ', 'Unpaid'),
('cics', '20-04057', '3rd ', 'Paid'),
('cics', '20-08087', '3rd ', 'Unpaid'),
('cics', '20-08173', '3rd ', 'Unpaid'),
('cics', '20-09196', '3rd ', 'Unpaid');

-- --------------------------------------------------------

--
-- Table structure for table `intess`
--

CREATE TABLE `intess` (
  `username` varchar(30) NOT NULL,
  `srcode` varchar(255) NOT NULL,
  `year` varchar(4) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `intess`
--

INSERT INTO `intess` (`username`, `srcode`, `year`, `status`) VALUES
('intess', '20-02328', '3rd ', 'Paid'),
('intess', '20-08087', '3rd ', 'Unpaid'),
('intess', '20-08173', '3rd ', 'Unpaid'),
('intess', '20-09196', '3rd ', 'Unpaid');

-- --------------------------------------------------------

--
-- Table structure for table `jpcs`
--

CREATE TABLE `jpcs` (
  `username` varchar(30) NOT NULL,
  `srcode` varchar(255) NOT NULL,
  `year` varchar(4) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `username` varchar(30) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `orgname` varchar(255) NOT NULL,
  `filename` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`username`, `password`, `orgname`, `filename`) VALUES
('access', '$2y$10$g/0xLU5/Za1hd9WfRRoFD.jm1ITLDKLOuMOS76yi0GEKOx3SSC50O', 'Association of Committed Computer Science Students', 'access.jpg'),
('cics', '$2y$10$ujwo9M1U9sk3JErR/hXozOhzm5H/0QGPGNv.WBSG8PnFjRVERPVBW', 'College of Informatics and Computer Science', 'cics-sc.jpg'),
('intess', '$2y$10$ciVOSn6x9Zpqd1mC53o35.EBQIze1UqZ3ZWa2gB4wk0egHu8pUnpW', 'Integrated Information Technology Student Society', 'intess.jpg'),
('jpcs', '$2y$10$Fqvv70kjrHNDktq2eO.40O4sHqcgdIxuso4VAVJhYNElt9yxCCSAG', 'Junior Philippine Computer Society', 'jpcs.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `organizations`
--

CREATE TABLE `organizations` (
  `username` varchar(30) NOT NULL,
  `fee` int(30) NOT NULL,
  `orgname` varchar(255) NOT NULL,
  `accufunds` int(255) NOT NULL,
  `availfunds` int(255) NOT NULL,
  `filename` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `organizations`
--

INSERT INTO `organizations` (`username`, `fee`, `orgname`, `accufunds`, `availfunds`, `filename`) VALUES
('jpcs', 100, 'Junior Philippine Computer Society', 0, 0, 'jpcs.jpg'),
('access', 100, 'Association of Committed Computer Science Students', 0, 0, 'access.jpg'),
('intess', 70, 'Integrated Information Technology Student Society', 70, 70, 'intess.jpg'),
('cics', 80, 'College of Informatics and Computer Science', 80, 80, 'cics2.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `orginvoice`
--

CREATE TABLE `orginvoice` (
  `username` varchar(30) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `amount` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orginvoice`
--

INSERT INTO `orginvoice` (`username`, `title`, `description`, `amount`) VALUES
('cics', 'Intramurals', '- booths', '100'),
('cics', 'Bejeweled', '- If sdas', '500');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `srcode` varchar(8) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `mname` varchar(255) NOT NULL,
  `suffix` varchar(255) NOT NULL,
  `program` varchar(255) NOT NULL,
  `section` varchar(15) NOT NULL,
  `year` varchar(4) NOT NULL,
  `sPhoto` varchar(100) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`srcode`, `email`, `password`, `lname`, `fname`, `mname`, `suffix`, `program`, `section`, `year`, `sPhoto`, `status`) VALUES
('20-02328', '20-02328@g.batstate-u.edu.ph', '$2y$10$4LKtt.aCtGCTG/Fuqm9nAOCCvSeCyiI7yyquyDWRanUvtWKfh0BJG', 'Estrada', 'Adriane', 'Masangkay', '', 'BS in Information Technology', 'IT-NT-3101', '3rd ', 'defaultimg.jpg', 'enrolled'),
('20-04057', '20-04057@g.batstate-u.edu.ph', '$2y$10$pBxB6CSlT0cyryVTZsAjWOfMWlSKWHyN/4JGlYq4nxvWLRQMYT.vO', 'Calica', 'Cristine Joy', 'Magsino', '', 'BS in Computer Sciences', 'CS-3101', '3rd ', 'calica.jpg', 'enrolled'),
('20-08087', '20-08087@g.batstate-u.edu.ph', '$2y$10$E1raFwGaFc0le3sPkwvmK.Pn3Tk.2rkv3euUF/hN8qGW.erhfhK3i', 'Mangampat', 'John Joseph', 'Soronia', '', 'BS in Information Technology', 'IT-3101', '3rd ', 'defaultimg.jpg', 'enrolled'),
('20-08173', '20-08173@g.batstate-u.edu.ph', '$2y$10$3Ng32XFz2hAyyBFH2uhTBO2XMncY0ue02DvKc5wJ6XnehE1V3EcRC', 'Dela Calzada', 'Carl Daniel', 'E.', '', 'BS in Information Technology', 'IT-3102', '3rd ', 'carl.jpg', 'enrolled'),
('20-09196', '20-09196@g.batstate-u.edu.ph', '$2y$10$btSJ4W1L9pZRhJSYTgi2rOayRU7ps1z/Q1TsgQS3yRaxO/MQgd..S', 'Ceniza', 'Liane Raine', 'Macaraig', '', 'BS in Information Technology', 'IT-3101', '3rd ', 'defaultimg.jpg', 'enrolled');

-- --------------------------------------------------------

--
-- Table structure for table `superadmin`
--

CREATE TABLE `superadmin` (
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `superadmin`
--

INSERT INTO `superadmin` (`username`, `password`) VALUES
('cics', '$2y$10$ujwo9M1U9sk3JErR/hXozOhzm5H/0QGPGNv.WBSG8PnFjRVERPVBW');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `access`
--
ALTER TABLE `access`
  ADD UNIQUE KEY `srcode` (`srcode`),
  ADD KEY `orgname` (`username`),
  ADD KEY `year` (`year`);

--
-- Indexes for table `cics-sc`
--
ALTER TABLE `cics-sc`
  ADD UNIQUE KEY `srcode` (`srcode`),
  ADD KEY `orgname` (`username`),
  ADD KEY `year` (`year`);

--
-- Indexes for table `intess`
--
ALTER TABLE `intess`
  ADD UNIQUE KEY `srcode` (`srcode`),
  ADD KEY `orgname` (`username`),
  ADD KEY `year` (`year`);

--
-- Indexes for table `jpcs`
--
ALTER TABLE `jpcs`
  ADD UNIQUE KEY `srcode` (`srcode`),
  ADD KEY `orgname` (`username`),
  ADD KEY `year` (`year`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`username`),
  ADD UNIQUE KEY `password` (`password`),
  ADD KEY `orgname` (`orgname`);

--
-- Indexes for table `organizations`
--
ALTER TABLE `organizations`
  ADD KEY `username` (`username`),
  ADD KEY `orgname` (`orgname`),
  ADD KEY `filename` (`filename`);

--
-- Indexes for table `orginvoice`
--
ALTER TABLE `orginvoice`
  ADD KEY `username` (`username`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`srcode`),
  ADD KEY `year` (`year`);

--
-- Indexes for table `superadmin`
--
ALTER TABLE `superadmin`
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `password` (`password`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `access`
--
ALTER TABLE `access`
  ADD CONSTRAINT `access_ibfk_1` FOREIGN KEY (`username`) REFERENCES `organizations` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `access_ibfk_2` FOREIGN KEY (`srcode`) REFERENCES `students` (`srcode`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `access_ibfk_3` FOREIGN KEY (`year`) REFERENCES `students` (`year`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cics-sc`
--
ALTER TABLE `cics-sc`
  ADD CONSTRAINT `cics-sc_ibfk_1` FOREIGN KEY (`username`) REFERENCES `organizations` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cics-sc_ibfk_2` FOREIGN KEY (`srcode`) REFERENCES `students` (`srcode`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cics-sc_ibfk_3` FOREIGN KEY (`year`) REFERENCES `students` (`year`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `intess`
--
ALTER TABLE `intess`
  ADD CONSTRAINT `intess_ibfk_1` FOREIGN KEY (`username`) REFERENCES `organizations` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `intess_ibfk_2` FOREIGN KEY (`srcode`) REFERENCES `students` (`srcode`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `intess_ibfk_3` FOREIGN KEY (`year`) REFERENCES `students` (`year`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `jpcs`
--
ALTER TABLE `jpcs`
  ADD CONSTRAINT `jpcs_ibfk_1` FOREIGN KEY (`username`) REFERENCES `organizations` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `jpcs_ibfk_2` FOREIGN KEY (`srcode`) REFERENCES `students` (`srcode`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `jpcs_ibfk_3` FOREIGN KEY (`year`) REFERENCES `students` (`year`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `organizations`
--
ALTER TABLE `organizations`
  ADD CONSTRAINT `organizations_ibfk_1` FOREIGN KEY (`username`) REFERENCES `login` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `organizations_ibfk_2` FOREIGN KEY (`orgname`) REFERENCES `login` (`orgname`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orginvoice`
--
ALTER TABLE `orginvoice`
  ADD CONSTRAINT `orginvoice_ibfk_1` FOREIGN KEY (`username`) REFERENCES `organizations` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `superadmin`
--
ALTER TABLE `superadmin`
  ADD CONSTRAINT `superadmin_ibfk_1` FOREIGN KEY (`username`) REFERENCES `login` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `superadmin_ibfk_2` FOREIGN KEY (`password`) REFERENCES `login` (`password`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
