SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `mayookha`
--

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE IF NOT EXISTS `departments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `score` int(11) NOT NULL DEFAULT '0',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `score`, `updated_at`) VALUES
(1, 'CSE/IT', 26, '2016-11-02 16:43:01'),
(2, 'ECE', 5, '2016-11-02 16:43:14'),
(3, 'EEE', 18, '2016-11-02 16:43:22'),
(4, 'ME', 15, '2016-11-02 16:43:30'),
(5, 'CE', 5, '2016-11-02 16:43:35');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE IF NOT EXISTS `items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(120) NOT NULL,
  `is_group` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=50 ;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `name`, `is_group`) VALUES
(1, 'Nadan pattu', 1),
(2, 'Bharathanattyam', 0),
(3, 'Group dance', 1),
(4, 'Kuchuppudi', 0),
(5, 'Parichamuttukali', 1),
(6, 'Mimicri', 0),
(7, 'Flute', 0),
(8, 'Folk dance', 1),
(9, 'Thiruvathira', 1),
(10, 'Daff muttu', 1),
(11, 'Kolkkali', 1),
(12, 'Oppana', 1),
(13, 'vattapattu', 1),
(14, 'Mime', 1),
(15, 'Malayalam skit', 1),
(16, 'Fashion walk', 0),
(17, 'Recitation(urdu)', 0),
(18, 'Recitation(arabic)', 0),
(19, 'Recitation(malayalam)', 0),
(20, 'group song(indian)', 1),
(21, 'Carnatic song', 0),
(22, 'Tabla', 0),
(23, 'Light music', 0),
(24, 'gazal', 0),
(25, 'Synchronized dance', 1),
(26, 'Western music', 1),
(27, 'guitar', 0),
(28, 'Voilin', 0),
(29, 'English drama', 1),
(30, 'Arabanamuttu', 1),
(31, 'Mridangam', 0),
(32, 'recitation(hindi)', 0),
(33, 'poorakkali', 1),
(34, 'Harmonium', 0),
(35, 'Group song(western)', 1),
(36, 'jass', 0),
(37, 'Kearala nadanam', 0),
(38, 'Kadhaprasangam', 0),
(39, 'Extempore(malayalam)', 0),
(40, 'Extempore(english)', 0),
(41, 'Debate(malayalam)', 1),
(42, 'Debate(english)', 1),
(43, 'Recittion(english)', 0),
(44, 'Recitation(kannada)', 0),
(45, 'Mappilapattu(single)', 0),
(46, 'Mappilapattu(group)', 1),
(47, 'Monoact', 0),
(48, 'Chenda', 0),
(49, 'Photography', 0);

-- --------------------------------------------------------

--
-- Table structure for table `result`
--

CREATE TABLE IF NOT EXISTS `result` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `student_name` varchar(120) NOT NULL,
  `department_id` int(11) NOT NULL,
  `semester` tinyint(4) DEFAULT NULL,
  `position` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `result`
--

INSERT INTO `result` (`id`, `item_id`, `student_name`, `department_id`, `semester`, `position`) VALUES
(1, 10, 'Vishnu Prasad', 1, 7, 1),
(2, 10, 'Nechu', 1, 5, 2),
(3, 10, 'Soman', 1, 3, 3),
(4, 2, 'vishnu maya', 2, 1, 1),
(5, 2, 'Mehna', 4, 3, 1),
(6, 2, 'Shibi', 3, 1, 2),
(7, 4, 'Krishnan', 5, 3, 1),
(8, 4, 'AkhilChandran', 1, 6, 2),
(9, 9, 'Devi', 4, 1, 1),
(10, 9, 'Revathi', 1, 1, 2),
(11, 14, 'Mehabu', 3, 3, 1),
(12, 14, 'Rajeesh', 3, 3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `roles` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`. default password is foo
--

INSERT INTO `users` (`id`, `username`, `password`, `roles`) VALUES
(1, 'admin', '$2y$13$tsvaR0aMaNzzWF/GjipyneA3Yu4qEskAHwq2OgkUsaBTHFk1fADgq', 'ROLE_ADMIN');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
