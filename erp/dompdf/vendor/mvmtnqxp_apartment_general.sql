-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 29, 2023 at 07:45 PM
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
-- Database: `mvmtnqxp_apartment_general`
--

-- --------------------------------------------------------

--
-- Table structure for table `apartments`
--

CREATE TABLE `apartments` (
  `apt_id` varchar(50) NOT NULL,
  `owner_id` varchar(250) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `pictures` text DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'nrented',
  `rent` varchar(60) NOT NULL,
  `expenses` varchar(10) NOT NULL,
  `city` varchar(25) NOT NULL,
  `moveindate` date NOT NULL,
  `moveoutdate` date NOT NULL,
  `no_of_rooms` int(10) NOT NULL,
  `no_of_bathrooms` int(1) NOT NULL,
  `no_of_bedrooms` int(10) NOT NULL,
  `details_of_building` text NOT NULL DEFAULT '\'{}\'',
  `details_of_furnishings` text NOT NULL DEFAULT '\'{}\'',
  `floor_no` int(2) NOT NULL,
  `zipcode` int(50) NOT NULL,
  `surfacearea` int(10) NOT NULL,
  `addressline1` varchar(250) NOT NULL,
  `addressline2` varchar(250) NOT NULL,
  `docs` varchar(5000) NOT NULL,
  `preferred_tenants` text NOT NULL,
  `posted_on` date NOT NULL,
  `no_of_proposals` int(10) NOT NULL DEFAULT 0,
  `distances` text NOT NULL,
  `rentalperiod` varchar(10) NOT NULL,
  `neighbourhood` text NOT NULL,
  `contmoveoutdate` date NOT NULL,
  `cmoveoutdate_all` varchar(50) NOT NULL,
  `rentedTo` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `apartments`
--

INSERT INTO `apartments` (`apt_id`, `owner_id`, `title`, `description`, `pictures`, `status`, `rent`, `expenses`, `city`, `moveindate`, `moveoutdate`, `no_of_rooms`, `no_of_bathrooms`, `no_of_bedrooms`, `details_of_building`, `details_of_furnishings`, `floor_no`, `zipcode`, `surfacearea`, `addressline1`, `addressline2`, `docs`, `preferred_tenants`, `posted_on`, `no_of_proposals`, `distances`, `rentalperiod`, `neighbourhood`, `contmoveoutdate`, `cmoveoutdate_all`, `rentedTo`) VALUES
('da166638e062c89fda', 'da16638dfde806720689108065', '4piÃ¨ces Nice centre', 'Nice centre 4p de 86M2 au 1er Ã©tage d\'un immeuble bourgeois avec ascenseur. Bon Ã©tat, 3 chambres, cuisine separÃ©e, deux sdb. Proche transports ', '[\"638e05ddf3e6e3.69144576.jpg\",\"638e05f8adb110.62689254.jpg\",\"638e060d4a1445.01911906.jpg\",\"638e060f1764e1.79946245.jpg\"]', 'available', '1500', '300', 'Nice', '2023-01-01', '0000-00-00', 4, 2, 3, '{\"basement\":false,\"electricalvehiclecharger\":false,\"elevator\":true,\"guardian\":false,\"handicapaccessible\":false,\"swimmingpool\":false,\"parking\":false,\"fitnessroom\":false,\"bicyclegarage\":false}', '{\"internet\":true,\"opticalfibre\":true,\"washingmachine\":true,\"dryer\":false,\"workingspace\":true,\"tv\":true,\"terrace\":false,\"alarmsystem\":false,\"nosmoking\":false,\"petfriendly\":false,\"garden\":false}', 1, 6000, 86, 'Rue Alphonse Karr', '23', '[[\"DossierFacile \",true],[\"Identity Document \",true],[\"Proof of Address \",false],[\"Proof of Earnings \",false],[\"Working Contract \",false]]', '{\"graduate\":true,\"learningcontract\":true,\"businesstransfer\":true,\"stage\":true,\"vocationaltraining\":true,\"voluntarycommitmentunderacivilservice\":true,\"temporarymissioninthecontextofprofessionalactivity\":true}', '2022-12-05', 0, '[\"5\",\"0.5\",\"0.2\"]', '-', 'Quartier trÃ©s prisÃ©', '0000-00-00', '', ''),
('da1666400d61e2af0a', 'da16638dfde806720689108065', 'Studio Nice', 'Studio Nice centre ville 25M2 refait a neuf 1er Ã©tage avec parking et balcon. 700 euro par mois + 50 charges. ', '[\"6400d603e85418.85247645.jpg\",\"6400d603e8ae25.66033000.jpg\",\"6400d60415a452.08393742.jpg\"]', 'available', '700', '50', 'Nice', '2023-03-02', '0000-00-00', 1, 1, 0, '{\"basement\":false,\"electricalvehiclecharger\":false,\"elevator\":false,\"guardian\":false,\"handicapaccessible\":false,\"swimmingpool\":false,\"parking\":true,\"fitnessroom\":false,\"bicyclegarage\":false}', '{\"internet\":true,\"opticalfibre\":true,\"washingmachine\":false,\"dryer\":false,\"workingspace\":false,\"tv\":false,\"terrace\":true,\"alarmsystem\":false,\"nosmoking\":false,\"petfriendly\":false,\"garden\":false}', 1, 6300, 25, '4', 'Avenue de la republique', '[[\"DossierFacile \",true],[\"Identity Document \",true],[\"Proof of Address \",false],[\"Proof of Earnings \",false],[\"Working Contract \",false]]', '{\"graduate\":true,\"learningcontract\":true,\"businesstransfer\":true,\"stage\":true,\"vocationaltraining\":true,\"voluntarycommitmentunderacivilservice\":true,\"temporarymissioninthecontextofprofessionalactivity\":true}', '2023-03-02', 0, '[\"14\",\"5\",\"0.5\"]', '-', 'Nice centre ville proche de transports et plages. Quartier tres prisÃ©', '0000-00-00', '', ''),
('el052637b750c51b18', 'el052637b71ede8c6a436139206', 'Riquier, grand 2/3 pieces avec', 'Grand 2/3 pieces avec mezzanine au 4eme etage d\'un immeuble situe a Riquier. Grand salon avec cuisine americaine et balcon, chambre primcipale avec salle de bains et balcon, et et petite chambre de rangement dans l\'etage inferieur. En haut, chambre d\'appoint avec salle de bains complÃ¨te, vestiaire et trois placards.\r\nParking privÃ© en sous sol Ã  50m.', '[\"63d7c1f0890191.02730650.jpg\",\"63d7c226d6a425.76126661.jpg\",\"63d7c2275c4be7.01357164.jpg\",\"63d7c251c2d835.38097972.jpg\",\"63d7c252486947.84874199.jpg\"]', 'available', '1500', '200', 'Nice', '2022-11-25', '2023-01-31', 4, 2, 2, '{\"basement\":false,\"electricalvehiclecharger\":false,\"elevator\":false,\"guardian\":false,\"handicapaccessible\":false,\"swimmingpool\":false,\"parking\":true,\"fitnessroom\":true,\"bicyclegarage\":false}', '{\"internet\":true,\"opticalfibre\":true,\"washingmachine\":true,\"dryer\":false,\"workingspace\":true,\"tv\":true,\"terrace\":true,\"alarmsystem\":true,\"nosmoking\":false,\"petfriendly\":true,\"garden\":false}', 4, 6300, 70, '20', 'Rue Docteur Pierre Richelmi', '[[\"DossierFacile \",true],[\"Identity Document \",true],[\"Proof of Address \",false],[\"Proof of Earnings \",true],[\"Working Contract \",false]]', '{\"graduate\":true,\"learningcontract\":false,\"businesstransfer\":true,\"stage\":true,\"vocationaltraining\":false,\"voluntarycommitmentunderacivilservice\":false,\"temporarymissioninthecontextofprofessionalactivity\":true}', '2022-11-21', 0, '[\"10km\",\"50m\",\"-\"]', '2', 'La gare de trains est environ 200 metres de l\'appartement. Centre commercial Carrefour Ã  environ 200 m.', '0000-00-00', '', ''),
('el146638e386099c87', 'el14638e343920dd7060835630', 'Charmant 3P Ã  Riquier', 'Charmant 3P traversant au 4Ã¨me/5Ã¨me Ã©tage (sans ascenseur), Chambre principal avec balcon et salle de bains complÃ¨te, Salon avec cuisine amÃ©ricaine, chambre noire et balcon, et dans la mezzanine espace pour chambre d\'appoint ou bureau ou chambre de linge, avec salle de bains complÃ¨te et environ 20m2 despace de rangement. \r\nLa cuisine est totalement Ã©quipÃ©e, et l\'appartement est totalement climatisÃ©. ', '[\"638e382539ef23.22930165.jpg\",\"638e3836968e98.87041319.jpg\",\"638e383b2bb4e4.61463379.jpg\"]', 'available', '1300', '200', 'Nice', '2023-01-01', '0000-00-00', 4, 2, 3, '{\"basement\":false,\"electricalvehiclecharger\":false,\"elevator\":false,\"guardian\":false,\"handicapaccessible\":false,\"swimmingpool\":false,\"parking\":true,\"fitnessroom\":true,\"bicyclegarage\":false}', '{\"internet\":true,\"opticalfibre\":true,\"washingmachine\":true,\"dryer\":false,\"workingspace\":true,\"tv\":true,\"terrace\":true,\"alarmsystem\":false,\"nosmoking\":false,\"petfriendly\":true,\"garden\":false}', 4, 6300, 75, '20', 'Rue Docteur Pierre Richelmi', '[[\"DossierFacile \",true],[\"Identity Document \",true],[\"Proof of Address \",true],[\"Proof of Earnings \",true],[\"Working Contract \",true]]', '{\"graduate\":false,\"learningcontract\":false,\"businesstransfer\":true,\"stage\":false,\"vocationaltraining\":false,\"voluntarycommitmentunderacivilservice\":false,\"temporarymissioninthecontextofprofessionalactivity\":true}', '2022-12-05', 0, '[\"10km\",\"50m\",\"-\"]', '-', 'Le parc est environ 200 metres de l\'appartement. Le march est galement environ 200 m tres.', '0000-00-00', '', ''),
('lu637640674b193203', 'lu637dd5729a046052033572', 'New test apartment from Luca', 'SituÃ© Ã  AsniÃ¨res-sur-Seine, ce T3 non meublÃ© se trouve Quai Aulagnier. Non loin de la gare Les GrÃ©sillons, le logement est proche de la Seine et dispose dâ€™un balcon. \r\n\r\nLâ€™appartement est composÃ© dâ€™une entrÃ©e avec un placard et dâ€™un salon donnant accÃ¨s au balcon. \r\n\r\nDeux chambres Ã  disposition et la salle de bain est Ã©quipÃ©e dâ€™une baignoire.\r\n Les WC sont sÃ©parÃ©s. \r\n\r\nLe logement est Ã©quipÃ© d\'un lave-vaisselle, d\'un micro-ondes, d\'un four, plaques Ã  induction, rÃ©frigÃ©rateur et hotte aspirante.\r\n\r\nCette adresse aux portes de Paris par le RER C, dans l\'Ã©co-quartier Seine Ouest, rÃ©unit tous les Ã©quipements et services propices Ã  votre quotidien.\r\n\r\nCe joli T3 nâ€™attend que vous ! ', '[\"6406749979d092.17414256.png\",\"64067499ef8656.83061329.png\",\"64067499ef92a3.45807350.png\"]', 'available', '1000', '250', 'Nice', '2023-03-31', '0000-00-00', 3, 1, 2, '{\"basement\":true,\"electricalvehiclecharger\":false,\"elevator\":true,\"guardian\":true,\"handicapaccessible\":false,\"swimmingpool\":false,\"parking\":true,\"fitnessroom\":false,\"bicyclegarage\":false}', '{\"internet\":true,\"opticalfibre\":true,\"washingmachine\":true,\"dryer\":false,\"workingspace\":true,\"tv\":true,\"terrace\":true,\"alarmsystem\":false,\"nosmoking\":true,\"petfriendly\":false,\"garden\":false}', 4, 6100, 76, '65', 'Boulevard de Cessole', '[[\"DossierFacile \",true],[\"Identity Document \",false],[\"Proof of Address \",false],[\"Proof of Earnings \",false],[\"Working Contract \",false]]', '{\"graduate\":true,\"learningcontract\":true,\"businesstransfer\":true,\"stage\":true,\"vocationaltraining\":true,\"voluntarycommitmentunderacivilservice\":true,\"temporarymissioninthecontextofprofessionalactivity\":true}', '2023-03-07', 0, '[\"5\",\"0.5\",\"0\"]', '-', 'Quartier Cessole', '0000-00-00', '', ''),
('pr6516379ab21a2c70', 'pr6516377fd84a01e0920812860', 'Sample Title(edited tested * 2)', 'a very good and random description which has no meaning a very good and random description which has no meaning a very good and random description which has no meaning a very good and random description which has no meaning a very good and random desa very good and random description which has no meaning a very good and random description which has no meaning a very good and random description which has no meaning a very good and random description which has no meaning a very good and random des', '[\"6379aac14030c8.19643403.jpg\",\"6379ab003e3e13.85402391.jpg\",\"6379ab003e4f53.44331015.jpg\",\"63cef2073706f7.71471687.jpg\",\"63d7cb8fb13951.38208588.jpeg\"]', 'available', '450', '100', 'les pavillons-sous-bois', '2023-02-27', '2023-09-30', 1, 1, 2, '{\"basement\":true,\"electricalvehiclecharger\":false,\"elevator\":true,\"guardian\":true,\"handicapaccessible\":true,\"swimmingpool\":false,\"parking\":true,\"fitnessroom\":true,\"bicyclegarage\":true}', '{\"internet\":true,\"opticalfibre\":false,\"washingmachine\":false,\"dryer\":true,\"workingspace\":true,\"tv\":false,\"terrace\":true,\"alarmsystem\":false,\"nosmoking\":false,\"petfriendly\":true,\"garden\":true}', 2, 226024, 63, '500', 'new street france', '[[\"DossierFacile \",true],[\"Identity Document \",true],[\"Proof of Address \",false],[\"Proof of Earnings \",true],[\"Working Contract \",true],[\"custom doc2 \",false],[\"custom doc  \",false]]', '{\"graduate\":true,\"learningcontract\":false,\"businesstransfer\":false,\"stage\":true,\"vocationaltraining\":true,\"voluntarycommitmentunderacivilservice\":false,\"temporarymissioninthecontextofprofessionalactivity\":false}', '2022-11-20', 1, '[\"50\",\"70\",\"5\"]', '1', 'Le parc est environ 200 metres de l\'appartement. Le march est galement environ 200 m tres.', '0000-00-00', '', ''),
('pr651638b53b97138c', 'pr6516377fd84a01e0920812860', 'very very very long very very very long v very very very long very very very long v', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Itaque tempora blanditiis similique rem, architecto ea aperiam voluptatibus vero alias laudantium consectetur dicta vitae fuga sequi ipsa saepe voluptates ratione accusantium?Lorem ipsum dolor Lorem ipsum dolor sit amet consecteturLorem ipsum dolor sit amet consectetur adipisicing elit. Itaque tempora blanditiis similique rem, architecto ea aperiam voluptatibus vero alias laudantium consectetur dicta vitae fuga sequi ipsa saepe voluptates ratione accusantium?Lorem ipsum dolor Lorem ipsum dolor sit amet consectetur', '[\"638b53a50c53b8.56120662.jpg\",\"638b53a50c8753.11446337.jpg\",\"638b53a5bfa2a8.15311093.jpg\",\"638b53a5bfcfc1.05824863.jpg\"]', 'available', '660', '100', 'gennevilliers', '2022-12-17', '0000-00-00', 1, 1, 1, '{\"basement\":true,\"electricalvehiclecharger\":false,\"elevator\":false,\"guardian\":true,\"handicapaccessible\":true,\"swimmingpool\":false,\"parking\":true,\"fitnessroom\":false,\"bicyclegarage\":true}', '{\"internet\":true,\"opticalfibre\":false,\"washingmachine\":true,\"dryer\":true,\"workingspace\":false,\"tv\":false,\"terrace\":true,\"alarmsystem\":true,\"nosmoking\":true,\"petfriendly\":false,\"garden\":true}', 3, 226024, 55, '58', 'new street, france', '[[\"DossierFacile \",true],[\"Identity Document \",false],[\"Proof of Address \",false],[\"Proof of Earnings \",true],[\"Working Contract \",false]]', '{\"graduate\":true,\"learningcontract\":false,\"businesstransfer\":true,\"stage\":true,\"vocationaltraining\":true,\"voluntarycommitmentunderacivilservice\":true,\"temporarymissioninthecontextofprofessionalactivity\":false}', '2022-12-03', 0, '[\"50\",\"80\",\"70\"]', '-', 'Le parc est environ 200 metres de l\'appartement. Le march est galement environ 200 m tres.', '2023-05-09', '1680287720', '[[\"pr69638cb4c7a46ad754521425\",\"prakharraone066@gmail.com\",\"https://lebailmobilite.com/profilepics/6400de8ecafe3.jpg\",\"09 May, 23\",\"Prakhar Sinha\"]]'),
('pr651639f14d5cc851', 'pr6516377fd84a01e0920812860', 'New apartment test by prakhar with a moderate length title', 'Description for a very good apartment Description for a very good apartment Description for a very good apartment Description for a very good apartment Description for a very good apartment Description for a very good apartment Description for a very good apartment Description for a very good apartment ', '[\"639f14bb27e8d3.65373013.jpg\",\"639f14bb280754.20576256.jpg\",\"639f14bb283790.29660287.jpg\",\"639f14bb286028.03146697.jpg\"]', 'available', '700', '150', 'clichy', '2022-12-18', '0000-00-00', 1, 1, 1, '{\"basement\":true,\"electricalvehiclecharger\":false,\"elevator\":true,\"guardian\":true,\"handicapaccessible\":true,\"swimmingpool\":false,\"parking\":true,\"fitnessroom\":false,\"bicyclegarage\":true}', '{\"internet\":true,\"opticalfibre\":false,\"washingmachine\":true,\"dryer\":true,\"workingspace\":true,\"tv\":true,\"terrace\":true,\"alarmsystem\":true,\"nosmoking\":true,\"petfriendly\":true,\"garden\":true}', 3, 226024, 75, 'Street 15', '75006 Paris, France (', '[[\"DossierFacile \",true],[\"Identity Document \",false],[\"Proof of Address \",false],[\"Proof of Earnings \",true],[\"Working Contract \",false]]', '{\"graduate\":true,\"learningcontract\":false,\"businesstransfer\":true,\"stage\":true,\"vocationaltraining\":false,\"voluntarycommitmentunderacivilservice\":true,\"temporarymissioninthecontextofprofessionalactivity\":true}', '2022-12-18', 0, '[\"60\",\"80\",\"5\"]', '-', 'Description for a very good apartment Description for a very good apartment Description for a very good apartment Description for a very good apartment Description for a very good apartment Description for a very good apartment Description for a very good apartment Description for a very good apartment ', '2023-04-01', '1680365136', ''),
('pr65164009ad18803e', 'pr6516377fd84a01e0920812860', 'new apartment for test', 'new apartment for testnew apartment for testnew apartment for testnew apartment for testnew apartment for test', '[\"64009a781735a8.20452496.jpg\",\"64009a78905ad9.42732277.jpg\",\"64009a78c89223.27026317.jpg\"]', 'available', '800', '150', 'niort', '2023-03-30', '0000-00-00', 1, 1, 1, '{\"basement\":true,\"electricalvehiclecharger\":false,\"elevator\":false,\"guardian\":false,\"handicapaccessible\":true,\"swimmingpool\":false,\"parking\":false,\"fitnessroom\":false,\"bicyclegarage\":true}', '{\"internet\":true,\"opticalfibre\":false,\"washingmachine\":true,\"dryer\":true,\"workingspace\":false,\"tv\":true,\"terrace\":false,\"alarmsystem\":true,\"nosmoking\":true,\"petfriendly\":false,\"garden\":false}', 2, 226024, 42, 'new street, paris', '50', '[[\"DossierFacile \",true],[\"Identity Document \",false],[\"Proof of Address \",false],[\"Proof of Earnings \",false],[\"Working Contract \",false]]', '{\"graduate\":true,\"learningcontract\":false,\"businesstransfer\":false,\"stage\":true,\"vocationaltraining\":false,\"voluntarycommitmentunderacivilservice\":true,\"temporarymissioninthecontextofprofessionalactivity\":true}', '2023-03-02', 0, '[\"50\",\"60\",\"70\"]', '1', 'new apartment for testnew apartment for testnew apartment for test', '2023-03-31', '1680286841', '');

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

CREATE TABLE `profiles` (
  `profileid` varchar(50) NOT NULL,
  `profilepic` varchar(120) NOT NULL,
  `fullname` varchar(30) NOT NULL,
  `email` varchar(35) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `password` varchar(50) NOT NULL,
  `last_msg_status` varchar(12) NOT NULL,
  `acc_type` varchar(10) NOT NULL,
  `profession` varchar(60) NOT NULL DEFAULT '-',
  `otp` varchar(100) DEFAULT NULL,
  `last_login` varchar(50) DEFAULT NULL,
  `last_msgid` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `profiles`
--

INSERT INTO `profiles` (`profileid`, `profilepic`, `fullname`, `email`, `phone`, `password`, `last_msg_status`, `acc_type`, `profession`, `otp`, `last_login`, `last_msgid`) VALUES
('pr6516377fd84a01e0920812860', 'https://lebailmobilite.com/profilepics/6400de8ecafe3.jpg', 'Prakhar Sinha', 'myprakhar96@gmail.com', '9646416428', '3f093c3f21a4cc6fbfe270dd9ed08aa9', 'read', 'landlord', '-', '00bbfc613cb899a27f38113d85ecbe79', '1680111947', NULL),
('te6416378003a6e20a714026755', 'http://lebailmobilite.com/profilepics/default.jpg', 'Test User', 'testuser@gmail.com', '9646416427', '3f093c3f21a4cc6fbfe270dd9ed08aa9', 'read', 'tenant', 'Vocational_Training', '306b6eee209a200baa2e43124b1c322b', '1679075548', NULL),
('lu4646378abd456ce7028627457', 'http://lebailmobilite.com/profilepics/default.jpg', 'luca mala', 'luca@gmail.com', '9864646648', '5024569af101611d81e42ce519c4ef7a', 'read', 'landlord', '-', '', NULL, NULL),
('te6379a140e15d2799049081', 'http://lebailmobilite.com/profilepics/default.jpg', 'testuser1', 'testuser1@gmail.com', '-', '3a6cef12d6ba9d02f9eaab9349b04ea3', 'read', 'tenant', 'Graduate', '', NULL, NULL),
('el052637b71ede8c6a436139206', 'http://lebailmobilite.com/profilepics/default.jpg', 'Eloy Alonso Gomez', 'eloyalonsogomez@gmail.com', '699052233', '2af3c302015fc897d1ff2a109c6c07f9', 'read', 'landlord', '-', '97b1cd9c9cbc90db92665ef799e99f17', NULL, NULL),
('pr651637d05609e9b6805465449', 'http://lebailmobilite.com/profilepics/default.jpg', 'Prakhar Sinha', 'prakhar@gmail.com', '8756516427', '3f093c3f21a4cc6fbfe270dd9ed08aa9', 'read', 'landlord', '-', '', NULL, NULL),
('lu637dd5729a046052033572', 'https://www.lebailmobilite.com/profilepics/63b2ac78b511d.png', 'Luca Malandrino', 'luca.malandrino@gmail.com', '-', 'd05d223c29087bb390c15dcb42cd0e99', 'read', 'landlord', '-', '15bebd58a577ddfb7184acdfa01ea0ae', '1678659795', NULL),
('pr68638b42eebb38c188842386', 'http://lebailmobilite.com/profilepics/default.jpg', 'Prakhar Sinha', 'prakharsinha@gmail.com', '-', '3f093c3f21a4cc6fbfe270dd9ed08aa9', 'read', 'tenant', 'Vocational_Training', '-', NULL, NULL),
('pr69638cb4c7a46ad754521425', 'https://lebailmobilite.com/profilepics/6400b697a9fd0.jpeg', 'Prakhar Sinha', 'prakharraone066@gmail.com', '699913659', '3f093c3f21a4cc6fbfe270dd9ed08aa9', 'read', 'tenant', 'Learning Contract', '45997df4b4f9d46832f83ac23b3d6751', '1680111907', NULL),
('is48638cb72b80012974718211', 'http://lebailmobilite.com/profilepics/default.jpg', 'Ishaan Bansal', 'ishanb734@gmail.com', '0699913659', '3f093c3f21a4cc6fbfe270dd9ed08aa9', 'read', 'tenant', 'Voluntary commitment under a civil service', '-', NULL, NULL),
('lu74638db4d76f740330185983', 'http://lebailmobilite.com/profilepics/default.jpg', 'Luca Malandrino', 'lucamala@hotmail.it', '0699913659', 'd05d223c29087bb390c15dcb42cd0e99', 'read', 'tenant', 'Learning Contract', 'ec88dd6f2929b8009621136a19a1761a', '1678656918', NULL),
('da16638dfde806720689108065', 'http://lebailmobilite.com/profilepics/default.jpg', 'Daniele Pardu', 'daniele.pardu@yahoo.it', '0663625380', 'ff5f35d0cde0881a00a6449f3cd9de9a', 'read', 'landlord', '-', '-', '1680110801', NULL),
('sa16638e088261c4b858389808', 'http://lebailmobilite.com/profilepics/default.jpg', 'Sanchez Ortega  Alicia', 'alidanibnb@gmail.com', '0631915165', 'ff5f35d0cde0881a00a6449f3cd9de9a', 'read', 'tenant', 'Business Transfer', '-', NULL, NULL),
('el14638e343920dd7060835630', 'http://lebailmobilite.com/profilepics/default.jpg', 'Eloy Alonso', 'eluaalonzo@gmail.com', '0699052233', 'f49fbf141c81c2d3e8047aad08bf98d7', 'read', 'landlord', '-', '-', NULL, NULL),
('pr80638f4133c4e67142771073', 'http://lebailmobilite.com/profilepics/default.jpg', 'Prakhar Sinha', 'prakhar@makes360.in', '-', '3f093c3f21a4cc6fbfe270dd9ed08aa9', 'read', 'tenant', 'Voluntary commitment under a civil service', '71e838e87dcf21205855fd66b09fb549', '1679950023', NULL),
('pr98638f5eb6be6cc409018623', 'http://lebailmobilite.com/profilepics/default.jpg', 'Prakhar  Sinha', 'thesecretinspiration@gmail.com', '8756516427', '3f093c3f21a4cc6fbfe270dd9ed08aa9', 'read', 'landlord', '-', '-', NULL, NULL),
('pr586390d3238d165961100540', 'http://lebailmobilite.com/profilepics/default.jpg', 'Prakhar Sinha', 'prakhar96sinha@gmail.com', '8756516427', '3f093c3f21a4cc6fbfe270dd9ed08aa9', 'read', 'landlord', '-', '-', '1677768060', NULL),
('du7563b08adcbabe6984096373', 'https://lebailmobilite.com/profilepics/63b08d69cd126.jpg', 'Dummy  Userone', 'prakharraone020@gmail.com', '8756516427', '3f093c3f21a4cc6fbfe270dd9ed08aa9', 'read', 'landlord', '-', 'da651dacde0f1a177e11d20ff58c983f', NULL, NULL),
('or4263fe41229b0f9756491529', 'http://lebailmobilite.com/profilepics/default.jpg', 'ORTEGA LOPEZ Maria Dolores', 'alisaor87@hotmail.com', '0631915165', '6793bb5f15819cccad847135e0a35a8a', 'read', 'tenant', 'Graduate', '-', '1677772590', NULL),
('pi85640ee7e302887820055289', 'http://lebailmobilite.com/profilepics/default.jpg', 'piyush gupta', 'guptapiyush1301@gmail.com', '-', '721940efc6d1b3d6081a0dc15dd0aa8e', 'read', 'landlord', '-', '-', '1678698479', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `apartments`
--
ALTER TABLE `apartments`
  ADD PRIMARY KEY (`apt_id`),
  ADD KEY `ownerid` (`owner_id`),
  ADD KEY `city` (`city`),
  ADD KEY `rent` (`rent`),
  ADD KEY `surface_area` (`surfacearea`),
  ADD KEY `no_of_rooms` (`no_of_rooms`),
  ADD KEY `rentalperiod` (`rentalperiod`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
