-- phpMyAdmin SQL Dump
-- version 4.1.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 24, 2014 at 08:19 PM
-- Server version: 5.1.73-cll
-- PHP Version: 5.4.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 
--

-- --------------------------------------------------------

--
-- Table structure for table `jela`
--

CREATE TABLE IF NOT EXISTS `jela` (
  `jid` int(3) NOT NULL AUTO_INCREMENT,
  `sort` int(3) NOT NULL,
  `broj` varchar(6) COLLATE utf8_bin NOT NULL,
  `naziv` text COLLATE utf8_bin NOT NULL,
  `naziv_en` text COLLATE utf8_bin NOT NULL,
  `cijena` varchar(10) COLLATE utf8_bin NOT NULL,
  `mid` int(3) NOT NULL,
  PRIMARY KEY (`jid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=133 ;

--
-- Dumping data for table `jela`
--

INSERT INTO `jela` (`jid`, `sort`, `broj`, `naziv`, `naziv_en`, `cijena`, `mid`) VALUES
(1, 3, '1.', 'Miješana salata\r\n', 'Mixed salad', '12,00', 1),
(122, 0, '2', 'Salata od   zelja (ljuto)', 'Cabbage salad (hot)', '11,00', 1),
(3, 0, '3', 'Salata od mahunovih klica\r\n', 'Bean sprouts salad', '12,00', 1),
(4, 0, '4', 'Salata od zelja s tri vrste mesa (ljuto)', 'Cabbage salad with three kinds of meat', '15,00', 1),
(5, 0, '5', 'Salata od oslića (ljuto)', 'Fish salad', '15,00', 1),
(6, 0, '6.', 'Salata od sojinih klica i škampi', 'Bean sprouts salad with scampi', '42,00', 1),
(7, 0, '7', 'Salata od sojinih klica i piletine', 'Bean sprout salad with chicken', '17,00', 1),
(131, 0, '8.', 'Salata od zelja i junetine', 'Cabbage salad with beef', '17,00', 1),
(10, 2, '10.', 'Kiselo - ljuta juha', 'Hot and sour soup', '12,00', 2),
(11, 2, '11.', 'Juha od jaja i kukuruza', 'Corn and egg soup', '12,00', 2),
(12, 0, '14', 'Juha od povrća', 'Vegetable soup', '12,00', 2),
(13, 0, '15.', 'Pileća juha s tjesteninom', 'Chicken and noodle soup', '13,00', 2),
(14, 0, '16.', 'Juha od rajčice', 'Tomato soup', '13,00', 2),
(15, 0, '17.', 'Juha od bambusa i kineskih gljiva', 'Bamboo soup with chinese mushrooms', '14,00', 2),
(16, 3, '18.', 'Juha od plodova mora', 'Sea-fruits soup', '16,00', 2),
(17, 0, '19.', 'Juha "Szechuan"(ljuto)', 'Soup "Szechuan" style (hot)', '13,00', 2),
(18, 0, '20.', 'Proljetna rolada', 'Spring rolls ', '15,00', 3),
(19, 0, '21.', 'Przeno povrće', 'Fried vegetable', '14,00', 3),
(20, 0, '22.', 'Čips od jastoga', 'Lobster chips', '17,00', 3),
(21, 0, '23.', 'Pirjani domaći mesni ravioli', 'Filled dumplings with minced meat', '22,00', 3),
(22, 0, '24.', 'Prženi Wan-tan', 'Fried Wan-tan', '14,00', 3),
(23, 0, '25.', 'Pržene lignje', 'Fried cuttlefish', '18,00', 3),
(24, 0, '26.', 'Pržena pileća krilca', 'Fried chicken wings', '28,00', 3),
(25, 0, '27.', 'Pržena svinjska rebrica  ', 'Fried spare ribbs', '29,00', 3),
(26, 0, '28.', 'Prženi krumpirići ', 'Pommesfrites', '10,00', 3),
(27, 0, '29.', 'Vegeterijanske rolade', 'Vegetarian rolls', '15,00', 3),
(28, 0, '30.', 'Riba sa povrćem', 'Fish with vegetables', '42,00', 4),
(29, 0, '31.', 'Riba s bambusom i kineskim gljivama', 'Fish with bamboo and chinese mushrooms', '47,00', 4),
(30, 0, '32.', 'Riba ''''Szechuan'''' (ljuto)', 'Fish ''''Szechuan'''' style (hot)', '42,00', 4),
(31, 0, '33.', 'Riba u kiselo - slatkom umaku', 'Fish in sweet and sour sauce', '42,00', 4),
(32, 0, '106..', 'Orada s povrćem ', 'Gilthead with vegetables', '65,00', 4),
(33, 0, '107.', 'Orada s bambusom i kineskim gljivama', 'Gilthead with bamboo and chinese mushrooms', '70,00', 4),
(34, 0, '108.', 'Orada "Szechuan"', 'Gilthead "Szechuan" style', '65,00', 4),
(35, 0, '38.', 'Lignje sa povrćem', 'Cuttle fish with vegetable', '47.00', 4),
(36, 0, '39.', 'Lignje ''''Szechuan'''' (ljuto)', 'Cuttele fish ''''Szechuan'''' style (hot)', '47.00', 4),
(37, 0, '40.', 'Pohane lignje u kiselo - slatkom umaku', 'Fried cuttele fish in sweet and sour sauce', '47.00', 4),
(38, 0, '113.', 'Lignje s bambusom i kineskim gljivama', 'Cuttele fish with bamboo and chinese mushrooms', '52,00', 4),
(39, 0, '34.', 'Škampi s s indijskim orasima', 'Prawns with cashew nuts', '125,00', 5),
(40, 0, '35.', 'Škampi s bambusom i kineskim gljivama', 'Prawns with bamboo and chinese mushrooms', '125,00', 5),
(41, 0, '36.', 'Škampi ''''Szechuan'''' (ljuto)', 'Prawns ''''Szechuan'''' style (hot)', '125,00', 5),
(42, 0, '37.', 'Škampi u kiselo - slatkom umaku', 'Prawns in sweet and sour sauce ', '125,00', 5),
(43, 0, '120.', 'Kozice s indijskim orasima', 'Shrimps with cashew nuts', '115,00', 5),
(44, 0, '121.', 'Kozice s bambusom i kineskim gljivama', 'Shrimps with bamboo and chinese mushrooms', '115,00', 5),
(45, 0, '122.', 'Kozice ''''Szechuan'''' (ljuto)', 'Shrimps ''''Szechuan'''' style (hot)', '115,00', 5),
(46, 0, '123.', 'Kozice u kiselo - slatkom umaku', 'Shrimps in sweet and sour sauce', '115,00', 5),
(47, 0, '124.', 'Kozice "Peking"', 'Shrimps "Peking" style', '115,00', 5),
(48, 0, '41.', 'Piletina s indijskim orasima', 'Chicken with cashew nuts', '57.00', 6),
(49, 0, '42.', 'Piletina s bambusom i kineskim gljivama', 'Chicken with bamboo and chinese mushrooms', '57.00', 6),
(50, 0, '43.', 'Piletina u umaku od školjki', 'Chicken in oyster sauce', '51.00', 6),
(51, 0, '44.', 'Piletina sa povrćem ', 'Chicken with vegetable', '50.00', 6),
(52, 0, '45.', 'Piletina ''''Gombao'''' (ljuto)', 'Chicken ''''Gombao'''' style (hot)', '57.00', 6),
(53, 0, '46.', 'Piletina s curryem', 'Chicken with curry', '50.00', 6),
(54, 0, '47.', 'Pohana piletina u kiselo - slatkom umaku', 'Chicken in sweet and sour sauce', '50.00', 6),
(55, 0, '49.', 'Piletina s sojinim klicama i mrkvom', 'Chicken with beansporouts and carrot', '51.00', 6),
(56, 0, '112.', 'Piletina ''''Szechuan'''' (ljuto)', 'Chicken ''''Szechuan'''' style (hot)', '51.00', 6),
(57, 0, '115.', 'Piletina ''''Gambian'''' (ljuto)', 'Chicken ''''Gambian'''' style (hot)', '51.00', 6),
(58, 0, '149.', 'Piletina "Yuxiang"(Ljuto)', 'Chicken "Yuxiang" style (hot)', '51,00', 6),
(59, 0, '48.', 'Hrskava piletina sa kiselo - slatkim umakom', 'Fried chicken with sweet and sour sauce', '57.00', 6),
(60, 0, '141.', 'Hrskava piletina "Szechuan" (ljuto)', 'Fried chicken "Szechuan" style (hot)', '57,00', 6),
(61, 0, '142.', 'Hrskava piletina s bambusom i kineskim gljivama', 'Fried chicken with bamboo and chinese mushrooms', '62,00', 6),
(62, 0, '143.', 'Hrskava piletina s kriškama limuna', 'Fried chicken with slices of lemon', '57,00', 6),
(63, 0, '144.', 'Hrskava piletina s povrćem', 'Fried chicken with vegetable', '57,00', 6),
(64, 0, '50.', 'Hrskava patka sa kiselo - slatkim umaku', 'Fried duck with sweet and sour sauce', '91.00', 7),
(65, 0, '51.', 'Hrskava patka ''''Szechuan'''' (ljuto)', 'Fried duck ''''Szechuan'''' style (hot)', '91.00', 7),
(66, 0, '52.', 'Hrskava patka s bambusom i kineskim gljivama', 'Fried duck with bamboo and chinese\r\nmushrooms', '97.00', 7),
(67, 0, '54.', 'Hrskava patka ''''Peking'''' sa palačinkama i kineskim umakom', 'Fried duck ''''Peking'''' with pancake and chinese sauce', '99.00', 7),
(68, 0, '150.', 'Hrskava patka s kriškama limuna', 'Fried duck with slices of lemon', '91,00', 7),
(69, 0, '55.', 'Svinjetina s bambusom i kineskim gljivama', 'Pork with bamboo and chinese mushrooms', '54,00', 8),
(70, 0, '56.', 'Svinjetina ''''Yuxiang'''' (ljuto)', 'Pork ''''Yuxiang'''' style (hot)', '47,00', 8),
(71, 0, '57.', 'Pohana svinjetina u kiselo - slatkom umaku', 'Pork in sweet and sour sauce', '47,00', 8),
(72, 0, '58.', 'Svinjetina s mahunovim klicama', 'Pork with beansporouts', '47,00', 8),
(73, 0, '59.', 'Svinjetina ''''Gambian'''' (ljuto)', 'Pork ''''Gambian'''' style (hot)', '49,00', 8),
(74, 0, '60.', 'Svinjetina ''''Szechuan'''' (ljuto)', 'Pork ''''Szechuan'''' style (hot)', '47,00', 8),
(75, 0, '114.', 'Svinjetina sa povrćem', 'Pork with vegetable', '47,00', 8),
(76, 0, '62.', 'Junetina ''''Gambian'''' (ljuto)', 'Beef ''''Gambian'''' style (hot)', '57,00', 9),
(77, 0, '63.', 'Junetina sa povrćem', 'Beef with vegetable', '52,00', 9),
(78, 0, '64.', 'Junetina s curryem', 'Beef with curry', '52,00', 9),
(79, 0, '65.', 'Junetina s bambusom i kineskim gljivama', 'Beef with bamboo and chinese mushrooms', '57,00', 9),
(80, 0, '66.', 'Junetina s lukom ', 'Beef with onion', '52,00', 9),
(81, 0, '67.', 'Junetina ''''Szechuan'''' (ljuto)', 'Beef ''''Szechuan'''' style (hot)', '52,00', 9),
(82, 0, '68.', 'Junetina ''''Sa-tsa''''', 'Beef ''''Sa-tsa'''' style', '57,00', 9),
(83, 0, '70.', 'Tie-pan junetina u umaku od školjki', 'Tie-pan with beef in oyster sauce', '62,00', 10),
(84, 0, '71.', 'Tie-pan sa plodovima mora', 'Tie-pan with sea fruits', '80,00', 10),
(85, 0, '72.', 'Tie-pan sa škampima', 'Tie-pan with prawns', '125,00', 10),
(86, 0, '73.', 'Tie-pan s tri vrste mesa', 'Tie-pan with three kinds of meat', '62,00', 10),
(87, 0, '74.', 'Tie-pan ''''Osam blaga'''' (ljuto)', 'Tie-pan eight treasure style (hot)', '62,00', 10),
(88, 0, '75.', 'Tie-pan s kozicama ', 'Tie-pan with shrimps', '115,00', 10),
(89, 0, '76.', 'Tie-pan piletina', 'Tie-pan chicken', '62,00', 10),
(90, 0, '148.', 'Tie-pan pileći ražnjici u kikiriki umaku ', 'Tie-pan chicken skewer in peanut sauce', '62,00', 10),
(91, 0, '95.', 'Tie-pan stakleni rezanci', 'Tie -pan glass noodles', '55,00', 10),
(92, 0, '77.', 'Pirjani domaći rezanci sa povrćem', 'Home made noodles with vegetable', '29.00', 11),
(93, 0, '78.', 'Pirjani domaći rezanci s tri vrste mesa', 'Home made noodles with three kinds of meat', '39,00', 11),
(94, 0, '79.', 'Pirjani domaći rezanci s piletinom i curryem', 'Home made noodles with chicken and curry', '39,00', 11),
(95, 0, '80.', 'Pirjani domaći rezanci sa škampima', 'Home made noodles with prawns', '60,00', 11),
(96, 0, '81.', 'Juha od domaćih rezanaca s tri vrste mesa', 'Noddles soup with three kinds of mea', '42,00', 11),
(97, 0, '82.', 'Stakleni rezanci s tri vrste mesa', 'Glassnoodles with three kinds of meat', '50,00', 11),
(98, 0, '89.', 'Pirjani domaći rezanci s kozicama', 'Home made noodles with shrimps', '55,00', 11),
(99, 0, '119.	', 'Pirjani domaći rezanci s piletinom', 'Home made noodles with chicken', '39,00', 11),
(100, 0, '83.', 'Pirjana riža s jajima i povrćem', 'Fried rice with eggs and vegetable', '27,00', 12),
(101, 0, '84.', 'Pirjana riža s tri vrste mesa', 'Fried rice with three kinds of meat', '37,00', 12),
(102, 0, '85.', 'Pirjana riža s piletinom i curryem', 'Fried rice with chicken and curry', '37,00', 12),
(103, 0, '86.', 'Pirjana riža sa škampima', 'Fried rice with prawns', '60,00', 12),
(104, 0, '87.', 'Pirjana riža "Peking"', 'Fried rice "Peking" style', '32,00', 12),
(105, 0, '88.', 'Riža', 'Rice', '8,00', 12),
(106, 0, '90.', 'Pirjana riža s kozicama', 'Fried rice with shrimps', '55,00', 12),
(107, 0, '91.', 'Miješano povrće', 'Mixed vegetable', '35,00', 13),
(108, 0, '92.', 'Pirjani bambus s kineskim gljivama', 'Bamboo with chinese mushrooms', '46,00', 13),
(109, 0, '93.', 'Pirjane mahunove klice ', 'Beansporouts', '35,00', 13),
(110, 0, '94.', 'Stakleni rezanci sa povrćem', 'Glassnoodles with vegetable', '40,00', 13),
(111, 0, '130.', 'Tofu sa povrćem ', 'Tofu with vegetable', '42,00', 13),
(112, 0, '131.', 'Tofu s bambusom i kineskim gljivama ', 'Tofu with bamboo and chinese mushrooms', '45,00', 13),
(113, 0, '132.	', 'Mapu tofu (ljuto)', 'Mapu tofu (hot)', '45,00', 13),
(114, 0, '133.', 'Tofu sa piletinom', 'Tofu with chicken', '45,00', 13),
(115, 0, '134.	', 'Tofu "Szechuan"(ljuto)', 'Tofu "Szechuan" style(hot)', '45,00', 13),
(116, 0, '100.', 'Pečeni sladoled', 'Fried ice-cream', '16,00', 14),
(117, 0, '101.', 'Pečene banane', 'Fried bananas', '13,00', 14),
(118, 0, '102.	', 'Pečene jabuke', 'Fried apples', '13,00', 14),
(119, 0, '103.	', 'Pečeni ananas ', 'Fried pineapples', '13,00', 14),
(120, 0, '104.', 'Sladoled', 'Ice-cream', '15,00', 14),
(121, 0, '105.', 'Kineski kompot (Litchi)', 'Chinese fruit (Litchi)', '18,00', 14),
(130, 0, '12.', 'Wan-tan juha', 'Wan-tan soup', '12,00', 2),
(132, 0, '9.', 'Salata od sojinih klica i kozice', 'Bean sprouts salad with shrimps', '36,00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `meni`
--

CREATE TABLE IF NOT EXISTS `meni` (
  `mid` int(3) NOT NULL AUTO_INCREMENT,
  `meni_ime` varchar(30) COLLATE utf8_bin NOT NULL,
  `en_ime` varchar(30) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`mid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=21 ;

--
-- Dumping data for table `meni`
--

INSERT INTO `meni` (`mid`, `meni_ime`, `en_ime`) VALUES
(1, 'Hladna predjela', ' / Cold appetizers'),
(2, 'Juhe', ' / Soups'),
(3, 'Topla predjela', ' / Hot appetizers'),
(4, 'Ribe i mekušci', ' / Fish and cuttle fish'),
(11, 'Tjestenina', ' / Noodles'),
(10, '"Tie pan"', ''),
(9, 'Junetina', ' / Beef'),
(8, 'Svinjetina', ' / Pork'),
(6, 'Piletina', ' / Chicken'),
(7, 'Patka', ' / Duck'),
(5, 'Škampi i kozice', ' / Prawns and shrimps'),
(12, 'Riža', ' / Rice'),
(13, 'Povrće i tofu', ' / Vegetables and tofu'),
(14, 'Slastice', ' / Desserts');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) COLLATE utf8_bin NOT NULL,
  `password` varchar(15) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=3 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `username`, `password`) VALUES
(1, 'liang', 'liang3peking'),
(2, 'jan', 'janking2');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
