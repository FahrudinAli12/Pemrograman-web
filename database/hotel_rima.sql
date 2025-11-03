-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 17, 2025 at 09:16 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hotel_rima`
--

-- --------------------------------------------------------

--
-- Table structure for table `hotels`
--

CREATE TABLE `hotels` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `lokasi` varchar(100) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `rating` float DEFAULT NULL,
  `ulasan` int(11) DEFAULT NULL,
  `jumlah_kamar` int(11) DEFAULT NULL,
  `jumlah_tamu` int(11) DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hotels`
--

INSERT INTO `hotels` (`id`, `nama`, `lokasi`, `harga`, `rating`, `ulasan`, `jumlah_kamar`, `jumlah_tamu`, `gambar`) VALUES
(1, 'Hotel Mutiara Malang', 'Malang', 150000, 4.4, 413, 3, 6, 'https://picsum.photos/seed/malang1/300/180'),
(2, 'Grand Tidar Malang', 'Malang', 190000, 4.1, 180, 1, 2, 'https://quadrasurface.com/assets/uploads/2023/10/VYH_6192-HDR-min-min.jpg'),
(3, 'Hotel Citra Klojen', 'Malang', 120000, 4.7, 214, 2, 4, 'https://picsum.photos/seed/malang3/300/180'),
(4, 'Villa Puncak Arjuna', 'Malang', 175000, 4.1, 238, 2, 4, 'https://picsum.photos/seed/malang4/300/180'),
(5, 'Hotel Ken Dedes Malang', 'Malang', 120000, 4.5, 182, 2, 4, 'https://picsum.photos/seed/malang5/300/180'),
(6, 'Hotel RedDoorz Sawojajar', 'Malang', 150000, 4.4, 483, 1, 2, 'https://picsum.photos/seed/malang6/300/180'),
(7, 'Griya Malang Syariah', 'Malang', 150000, 4.6, 476, 1, 2, 'https://picsum.photos/seed/malang7/300/180'),
(8, 'Hotel Bahagia Malang', 'Malang', 100000, 4.4, 416, 1, 2, 'https://picsum.photos/seed/malang8/300/180'),
(9, 'Hotel Sahabat Family Malang', 'Malang', 190000, 4.3, 164, 1, 2, 'https://picsum.photos/seed/malang9/300/180'),
(10, 'Hotel Tugu Blitar', 'Blitar', 135000, 4.3, 226, 1, 2, 'https://picsum.photos/seed/blitar1/300/180'),
(11, 'Hotel Istana Blitar', 'Blitar', 190000, 4.5, 301, 3, 6, 'https://picsum.photos/seed/blitar2/300/180'),
(12, 'RedDoorz Blitar Center', 'Blitar', 150000, 4.5, 407, 2, 4, 'https://picsum.photos/seed/blitar3/300/180'),
(13, 'Hotel Kharisma Blitar', 'Blitar', 175000, 4.3, 552, 2, 4, 'https://picsum.photos/seed/blitar4/300/180'),
(14, 'Hotel Mawar Indah Blitar', 'Blitar', 190000, 4.3, 207, 2, 4, 'https://picsum.photos/seed/blitar5/300/180'),
(15, 'Hotel Sri Rejeki Blitar', 'Blitar', 190000, 4.2, 409, 1, 2, 'https://picsum.photos/seed/blitar6/300/180'),
(16, 'Griya Asri Blitar', 'Blitar', 150000, 4.6, 561, 1, 2, 'https://picsum.photos/seed/blitar7/300/180'),
(17, 'Hotel Cendana Blitar', 'Blitar', 135000, 4.7, 484, 3, 6, 'https://picsum.photos/seed/blitar8/300/180'),
(18, 'Villa Tirto Blitar', 'Blitar', 190000, 4.1, 206, 2, 4, 'https://picsum.photos/seed/blitar9/300/180'),
(19, 'Hotel Istana Tulungagung', 'Tulungagung', 150000, 4.1, 355, 3, 6, 'https://picsum.photos/seed/tulungagung1/300/180'),
(20, 'Hotel Tulip Tulungagung', 'Tulungagung', 190000, 4.6, 579, 2, 4, 'https://picsum.photos/seed/tulungagung2/300/180'),
(21, 'RedDoorz Tulungagung', 'Tulungagung', 150000, 4.7, 382, 2, 4, 'https://picsum.photos/seed/tulungagung3/300/180'),
(22, 'Hotel Ratna Indah Tulungagung', 'Tulungagung', 190000, 4.2, 406, 3, 6, 'https://picsum.photos/seed/tulungagung4/300/180'),
(23, 'Hotel Puspa Indah Tulungagung', 'Tulungagung', 150000, 4.2, 330, 2, 4, 'https://picsum.photos/seed/tulungagung5/300/180'),
(24, 'Griya Asih Tulungagung', 'Tulungagung', 175000, 4.2, 318, 3, 6, 'https://picsum.photos/seed/tulungagung6/300/180'),
(25, 'Hotel Santika Tulungagung', 'Tulungagung', 150000, 4.1, 94, 3, 6, 'https://picsum.photos/seed/tulungagung7/300/180'),
(26, 'Hotel Seruni Tulungagung', 'Tulungagung', 100000, 4.2, 567, 2, 4, 'https://picsum.photos/seed/tulungagung8/300/180'),
(27, 'Hotel Nirwana Tulungagung', 'Tulungagung', 160000, 4.1, 262, 3, 6, 'https://picsum.photos/seed/tulungagung9/300/180'),
(28, 'Hotel Bukit Daun Kediri', 'Kediri', 175000, 4.7, 217, 3, 6, 'https://picsum.photos/seed/kediri1/300/180'),
(29, 'Hotel Merdeka Kediri', 'Kediri', 135000, 4.1, 127, 3, 6, 'https://picsum.photos/seed/kediri2/300/180'),
(30, 'Hotel Lotus Garden Kediri', 'Kediri', 160000, 4.6, 417, 3, 6, 'https://picsum.photos/seed/kediri3/300/180'),
(31, 'RedDoorz Kediri Town', 'Kediri', 135000, 4.7, 484, 2, 4, 'https://picsum.photos/seed/kediri4/300/180'),
(32, 'Hotel Taman Sari Kediri', 'Kediri', 190000, 4, 351, 2, 4, 'https://picsum.photos/seed/kediri5/300/180'),
(33, 'Hotel Nirwana Kediri', 'Kediri', 150000, 4.1, 195, 3, 6, 'https://picsum.photos/seed/kediri6/300/180'),
(34, 'Villa Asri Kediri', 'Kediri', 150000, 4.5, 509, 2, 4, 'https://picsum.photos/seed/kediri7/300/180'),
(35, 'Hotel Mawar Asih Kediri', 'Kediri', 150000, 4.5, 234, 3, 6, 'https://picsum.photos/seed/kediri8/300/180'),
(36, 'Hotel Pelangi Kediri', 'Kediri', 175000, 4.2, 552, 1, 2, 'https://picsum.photos/seed/kediri9/300/180'),
(37, 'Hotel Majapahit Surabaya', 'Surabaya', 135000, 4.1, 466, 2, 4, 'https://picsum.photos/seed/surabaya1/300/180'),
(38, 'RedDoorz Darmo Park Surabaya', 'Surabaya', 100000, 4.5, 235, 2, 4, 'https://picsum.photos/seed/surabaya2/300/180'),
(39, 'Hotel Sahid Surabaya', 'Surabaya', 120000, 4.4, 512, 1, 2, 'https://picsum.photos/seed/surabaya3/300/180'),
(40, 'Griya Gubeng Surabaya', 'Surabaya', 100000, 4.5, 218, 1, 2, 'https://picsum.photos/seed/surabaya4/300/180'),
(41, 'Hotel Kampung Lawas Surabaya', 'Surabaya', 160000, 4.3, 481, 1, 2, 'https://picsum.photos/seed/surabaya5/300/180'),
(42, 'Hotel Grand Kalimas Surabaya', 'Surabaya', 150000, 4.7, 433, 3, 6, 'https://picsum.photos/seed/surabaya6/300/180'),
(43, 'Hotel Pacific Palace Surabaya', 'Surabaya', 160000, 4, 255, 3, 6, 'https://picsum.photos/seed/surabaya7/300/180'),
(44, 'Hotel Tanjung Emas Surabaya', 'Surabaya', 100000, 4.6, 298, 2, 4, 'https://picsum.photos/seed/surabaya8/300/180'),
(45, 'Hotel Galaxy Surabaya', 'Surabaya', 100000, 4.7, 300, 3, 6, 'https://picsum.photos/seed/surabaya9/300/180'),
(46, 'Hotel asik Blitar', 'Blitar', 190000, 4.4, 180, 1, 2, 'https://events.rumah123.com/wp-content/uploads/sites/38/2023/10/03141852/Desain-Kamar-Tidur-Minimalis-1024x614.jpg'),
(47, 'Hotel asik Blitar', 'Blitar', 190000, 4.4, 180, 1, 2, 'https://events.rumah123.com/wp-content/uploads/sites/38/2023/10/03141852/Desain-Kamar-Tidur-Minimalis-1024x614.jpg'),
(48, 'Hotel asik Blitar', 'Blitar', 190000, 4.4, 413, 1, 2, 'https://asset.kompas.com/crops/-_yClPxOOzIS8QeoV7WlMK5FPCU=/120x80:1000x667/1200x800/data/photo/2023/06/07/6480672a9465c.jpg'),
(49, 'hotel asik malang', 'Malang', 190000, 4.4, 180, 1, 2, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSn4wyIpDVj9O_JvKzDJMR4GGChT8LWGqGLlg&s');

-- --------------------------------------------------------

--
-- Table structure for table `hotel_gambar`
--

CREATE TABLE `hotel_gambar` (
  `id` int(11) NOT NULL,
  `hotel_id` int(11) DEFAULT NULL,
  `url` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hotel_gambar`
--

INSERT INTO `hotel_gambar` (`id`, `hotel_id`, `url`) VALUES
(7, 3, 'https://picsum.photos/seed/hotel3a/600/400'),
(8, 3, 'https://picsum.photos/seed/hotel3b/600/400'),
(9, 3, 'https://picsum.photos/seed/hotel3c/600/400'),
(10, 4, 'https://picsum.photos/seed/hotel4a/600/400'),
(11, 4, 'https://picsum.photos/seed/hotel4b/600/400'),
(12, 4, 'https://picsum.photos/seed/hotel4c/600/400'),
(13, 5, 'https://picsum.photos/seed/hotel5a/600/400'),
(14, 5, 'https://picsum.photos/seed/hotel5b/600/400'),
(15, 5, 'https://picsum.photos/seed/hotel5c/600/400'),
(16, 6, 'https://picsum.photos/seed/hotel6a/600/400'),
(17, 6, 'https://picsum.photos/seed/hotel6b/600/400'),
(18, 6, 'https://picsum.photos/seed/hotel6c/600/400'),
(19, 7, 'https://picsum.photos/seed/hotel7a/600/400'),
(20, 7, 'https://picsum.photos/seed/hotel7b/600/400'),
(21, 7, 'https://picsum.photos/seed/hotel7c/600/400'),
(22, 8, 'https://picsum.photos/seed/hotel8a/600/400'),
(23, 8, 'https://picsum.photos/seed/hotel8b/600/400'),
(24, 8, 'https://picsum.photos/seed/hotel8c/600/400'),
(25, 9, 'https://picsum.photos/seed/hotel9a/600/400'),
(26, 9, 'https://picsum.photos/seed/hotel9b/600/400'),
(27, 9, 'https://picsum.photos/seed/hotel9c/600/400'),
(28, 10, 'https://picsum.photos/seed/hotel10a/600/400'),
(29, 10, 'https://picsum.photos/seed/hotel10b/600/400'),
(30, 10, 'https://picsum.photos/seed/hotel10c/600/400'),
(31, 11, 'https://picsum.photos/seed/hotel11a/600/400'),
(32, 11, 'https://picsum.photos/seed/hotel11b/600/400'),
(33, 11, 'https://picsum.photos/seed/hotel11c/600/400'),
(34, 12, 'https://picsum.photos/seed/hotel12a/600/400'),
(35, 12, 'https://picsum.photos/seed/hotel12b/600/400'),
(36, 12, 'https://picsum.photos/seed/hotel12c/600/400'),
(37, 13, 'https://picsum.photos/seed/hotel13a/600/400'),
(38, 13, 'https://picsum.photos/seed/hotel13b/600/400'),
(39, 13, 'https://picsum.photos/seed/hotel13c/600/400'),
(40, 14, 'https://picsum.photos/seed/hotel14a/600/400'),
(41, 14, 'https://picsum.photos/seed/hotel14b/600/400'),
(42, 14, 'https://picsum.photos/seed/hotel14c/600/400'),
(43, 15, 'https://picsum.photos/seed/hotel15a/600/400'),
(44, 15, 'https://picsum.photos/seed/hotel15b/600/400'),
(45, 15, 'https://picsum.photos/seed/hotel15c/600/400'),
(46, 16, 'https://picsum.photos/seed/hotel16a/600/400'),
(47, 16, 'https://picsum.photos/seed/hotel16b/600/400'),
(48, 16, 'https://picsum.photos/seed/hotel16c/600/400'),
(49, 17, 'https://picsum.photos/seed/hotel17a/600/400'),
(50, 17, 'https://picsum.photos/seed/hotel17b/600/400'),
(51, 17, 'https://picsum.photos/seed/hotel17c/600/400'),
(52, 18, 'https://picsum.photos/seed/hotel18a/600/400'),
(53, 18, 'https://picsum.photos/seed/hotel18b/600/400'),
(54, 18, 'https://picsum.photos/seed/hotel18c/600/400'),
(55, 19, 'https://picsum.photos/seed/hotel19a/600/400'),
(56, 19, 'https://picsum.photos/seed/hotel19b/600/400'),
(57, 19, 'https://picsum.photos/seed/hotel19c/600/400'),
(58, 20, 'https://picsum.photos/seed/hotel20a/600/400'),
(59, 20, 'https://picsum.photos/seed/hotel20b/600/400'),
(60, 20, 'https://picsum.photos/seed/hotel20c/600/400'),
(61, 21, 'https://picsum.photos/seed/hotel21a/600/400'),
(62, 21, 'https://picsum.photos/seed/hotel21b/600/400'),
(63, 21, 'https://picsum.photos/seed/hotel21c/600/400'),
(64, 22, 'https://picsum.photos/seed/hotel22a/600/400'),
(65, 22, 'https://picsum.photos/seed/hotel22b/600/400'),
(66, 22, 'https://picsum.photos/seed/hotel22c/600/400'),
(67, 23, 'https://picsum.photos/seed/hotel23a/600/400'),
(68, 23, 'https://picsum.photos/seed/hotel23b/600/400'),
(69, 23, 'https://picsum.photos/seed/hotel23c/600/400'),
(70, 24, 'https://picsum.photos/seed/hotel24a/600/400'),
(71, 24, 'https://picsum.photos/seed/hotel24b/600/400'),
(72, 24, 'https://picsum.photos/seed/hotel24c/600/400'),
(73, 25, 'https://picsum.photos/seed/hotel25a/600/400'),
(74, 25, 'https://picsum.photos/seed/hotel25b/600/400'),
(75, 25, 'https://picsum.photos/seed/hotel25c/600/400'),
(76, 26, 'https://picsum.photos/seed/hotel26a/600/400'),
(77, 26, 'https://picsum.photos/seed/hotel26b/600/400'),
(78, 26, 'https://picsum.photos/seed/hotel26c/600/400'),
(79, 27, 'https://picsum.photos/seed/hotel27a/600/400'),
(80, 27, 'https://picsum.photos/seed/hotel27b/600/400'),
(81, 27, 'https://picsum.photos/seed/hotel27c/600/400'),
(82, 28, 'https://picsum.photos/seed/hotel28a/600/400'),
(83, 28, 'https://picsum.photos/seed/hotel28b/600/400'),
(84, 28, 'https://picsum.photos/seed/hotel28c/600/400'),
(85, 29, 'https://picsum.photos/seed/hotel29a/600/400'),
(86, 29, 'https://picsum.photos/seed/hotel29b/600/400'),
(87, 29, 'https://picsum.photos/seed/hotel29c/600/400'),
(88, 30, 'https://picsum.photos/seed/hotel30a/600/400'),
(89, 30, 'https://picsum.photos/seed/hotel30b/600/400'),
(90, 30, 'https://picsum.photos/seed/hotel30c/600/400'),
(91, 31, 'https://picsum.photos/seed/hotel31a/600/400'),
(92, 31, 'https://picsum.photos/seed/hotel31b/600/400'),
(93, 31, 'https://picsum.photos/seed/hotel31c/600/400'),
(94, 32, 'https://picsum.photos/seed/hotel32a/600/400'),
(95, 32, 'https://picsum.photos/seed/hotel32b/600/400'),
(96, 32, 'https://picsum.photos/seed/hotel32c/600/400'),
(97, 33, 'https://picsum.photos/seed/hotel33a/600/400'),
(98, 33, 'https://picsum.photos/seed/hotel33b/600/400'),
(99, 33, 'https://picsum.photos/seed/hotel33c/600/400'),
(100, 34, 'https://picsum.photos/seed/hotel34a/600/400'),
(101, 34, 'https://picsum.photos/seed/hotel34b/600/400'),
(102, 34, 'https://picsum.photos/seed/hotel34c/600/400'),
(103, 35, 'https://picsum.photos/seed/hotel35a/600/400'),
(104, 35, 'https://picsum.photos/seed/hotel35b/600/400'),
(105, 35, 'https://picsum.photos/seed/hotel35c/600/400'),
(106, 36, 'https://picsum.photos/seed/hotel36a/600/400'),
(107, 36, 'https://picsum.photos/seed/hotel36b/600/400'),
(108, 36, 'https://picsum.photos/seed/hotel36c/600/400'),
(109, 37, 'https://picsum.photos/seed/hotel37a/600/400'),
(110, 37, 'https://picsum.photos/seed/hotel37b/600/400'),
(111, 37, 'https://picsum.photos/seed/hotel37c/600/400'),
(112, 38, 'https://picsum.photos/seed/hotel38a/600/400'),
(113, 38, 'https://picsum.photos/seed/hotel38b/600/400'),
(114, 38, 'https://picsum.photos/seed/hotel38c/600/400'),
(115, 39, 'https://picsum.photos/seed/hotel39a/600/400'),
(116, 39, 'https://picsum.photos/seed/hotel39b/600/400'),
(117, 39, 'https://picsum.photos/seed/hotel39c/600/400'),
(118, 40, 'https://picsum.photos/seed/hotel40a/600/400'),
(119, 40, 'https://picsum.photos/seed/hotel40b/600/400'),
(120, 40, 'https://picsum.photos/seed/hotel40c/600/400'),
(121, 41, 'https://picsum.photos/seed/hotel41a/600/400'),
(122, 41, 'https://picsum.photos/seed/hotel41b/600/400'),
(123, 41, 'https://picsum.photos/seed/hotel41c/600/400'),
(124, 42, 'https://picsum.photos/seed/hotel42a/600/400'),
(125, 42, 'https://picsum.photos/seed/hotel42b/600/400'),
(126, 42, 'https://picsum.photos/seed/hotel42c/600/400'),
(127, 43, 'https://picsum.photos/seed/hotel43a/600/400'),
(128, 43, 'https://picsum.photos/seed/hotel43b/600/400'),
(129, 43, 'https://picsum.photos/seed/hotel43c/600/400'),
(130, 44, 'https://picsum.photos/seed/hotel44a/600/400'),
(131, 44, 'https://picsum.photos/seed/hotel44b/600/400'),
(132, 44, 'https://picsum.photos/seed/hotel44c/600/400'),
(133, 45, 'https://picsum.photos/seed/hotel45a/600/400'),
(134, 45, 'https://picsum.photos/seed/hotel45b/600/400'),
(135, 45, 'https://picsum.photos/seed/hotel45c/600/400'),
(136, 1, 'https://picsum.photos/seed/hotel1a/600/400'),
(137, 1, 'https://picsum.photos/seed/hotel1b/600/400'),
(138, 1, 'https://picsum.photos/seed/hotel1c/600/400'),
(148, 46, 'https://asset.kompas.com/crops/-_yClPxOOzIS8QeoV7WlMK5FPCU=/120x80:1000x667/1200x800/data/photo/2023/06/07/6480672a9465c.jpg'),
(149, 46, 'https://asset.morefurniture.id/NEWS/2023/3/Kamar%20Tidur%20Minimalis%20Japandi.jpg'),
(150, 46, 'https://media.dekoruma.com/article/2024/11/19142322/desain-kamar-tidur-minimalis-1.jpg?fit=300%2C225&ssl=1'),
(151, 47, 'https://asset.kompas.com/crops/-_yClPxOOzIS8QeoV7WlMK5FPCU=/120x80:1000x667/1200x800/data/photo/2023/06/07/6480672a9465c.jpg'),
(152, 47, 'https://asset.kompas.com/crops/-_yClPxOOzIS8QeoV7WlMK5FPCU=/120x80:1000x667/1200x800/data/photo/2023/06/07/6480672a9465c.jpg'),
(153, 47, 'https://asset.kompas.com/crops/-_yClPxOOzIS8QeoV7WlMK5FPCU=/120x80:1000x667/1200x800/data/photo/2023/06/07/6480672a9465c.jpg'),
(154, 48, 'https://asset.kompas.com/crops/-_yClPxOOzIS8QeoV7WlMK5FPCU=/120x80:1000x667/1200x800/data/photo/2023/06/07/6480672a9465c.jpg'),
(155, 48, 'https://asset.kompas.com/crops/-_yClPxOOzIS8QeoV7WlMK5FPCU=/120x80:1000x667/1200x800/data/photo/2023/06/07/6480672a9465c.jpg'),
(156, 48, 'https://asset.kompas.com/crops/-_yClPxOOzIS8QeoV7WlMK5FPCU=/120x80:1000x667/1200x800/data/photo/2023/06/07/6480672a9465c.jpg'),
(157, 49, 'https://asset.kompas.com/crops/-_yClPxOOzIS8QeoV7WlMK5FPCU=/120x80:1000x667/1200x800/data/photo/2023/06/07/6480672a9465c.jpg'),
(158, 49, 'https://asset.kompas.com/crops/-_yClPxOOzIS8QeoV7WlMK5FPCU=/120x80:1000x667/1200x800/data/photo/2023/06/07/6480672a9465c.jpg'),
(159, 49, 'https://asset.kompas.com/crops/-_yClPxOOzIS8QeoV7WlMK5FPCU=/120x80:1000x667/1200x800/data/photo/2023/06/07/6480672a9465c.jpg'),
(160, 2, 'https://picsum.photos/seed/hotel2a/600/400'),
(161, 2, 'https://picsum.photos/seed/hotel2b/600/400'),
(162, 2, 'https://picsum.photos/seed/hotel2c/600/400');

-- --------------------------------------------------------

--
-- Table structure for table `pemesanan`
--

CREATE TABLE `pemesanan` (
  `id` int(11) NOT NULL,
  `hotel_id` int(11) DEFAULT NULL,
  `nama_hotel` varchar(255) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `checkin` date DEFAULT NULL,
  `checkout` date DEFAULT NULL,
  `jumlah_kamar` int(11) DEFAULT NULL,
  `jumlah_tamu` int(11) DEFAULT NULL,
  `total_harga` int(11) DEFAULT NULL,
  `tanggal_pesan` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int(11) NOT NULL,
  `promo` varchar(50) DEFAULT NULL,
  `promo_nominal` int(11) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `title` varchar(10) DEFAULT NULL,
  `nama_depan` varchar(50) DEFAULT NULL,
  `nama_belakang` varchar(50) DEFAULT NULL,
  `no_telp` varchar(20) DEFAULT NULL,
  `gambar` text DEFAULT NULL,
  `nama_hotel` varchar(100) DEFAULT NULL,
  `lokasi` varchar(100) DEFAULT NULL,
  `checkin` date DEFAULT NULL,
  `checkout` date DEFAULT NULL,
  `jumlah_kamar` int(11) DEFAULT NULL,
  `jumlah_tamu` int(11) DEFAULT NULL,
  `harga_per_malam` int(11) DEFAULT NULL,
  `total_malam` int(11) DEFAULT NULL,
  `promo_value` int(11) DEFAULT NULL,
  `total_bayar` int(11) DEFAULT NULL,
  `metode_pembayaran` varchar(50) DEFAULT NULL,
  `waktu_transaksi` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id`, `promo`, `promo_nominal`, `email`, `title`, `nama_depan`, `nama_belakang`, `no_telp`, `gambar`, `nama_hotel`, `lokasi`, `checkin`, `checkout`, `jumlah_kamar`, `jumlah_tamu`, `harga_per_malam`, `total_malam`, `promo_value`, `total_bayar`, `metode_pembayaran`, `waktu_transaksi`) VALUES
(40, '50k', 50000, 'moch.fahrudinalinugroho@gmail.com', 'Mr', 'Fahru', 'Al', '0987654321', 'https://picsum.photos/seed/blitar4/300/180', 'Hotel Kharisma Blitar', 'Blitar', '2025-07-15', '0000-00-00', 2, 4, 175000, 3, 50000, 475000, 'BRI', '2025-07-14 15:12:53'),
(41, '50k', 50000, 'rimazulita2@gmail.com', 'Ms', 'Rimaa', 'zulll', '0987654321', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSn4wyIpDVj9O_JvKzDJMR4GGChT8LWGqGLlg&s', 'Grand Tidar Malang', 'Malang', '2025-07-16', '0000-00-00', 1, 2, 190000, 2, 50000, 330000, 'BCA', '2025-07-15 03:34:49'),
(42, '50k', 50000, 'moch.fahrudinalinugroho@gmail.com', 'Mr', 'Rimaa', 'maa', '7653875467', 'https://picsum.photos/seed/malang8/300/180', 'Hotel Bahagia Malang', 'Malang', '2025-07-16', '0000-00-00', 1, 2, 100000, 2, 50000, 150000, 'BRI', '2025-07-15 07:33:08'),
(43, '50k', 50000, 'rimazulita2@gmail.com', 'Ms', 'Rimaa', 'Zulitaaa', '5674893213', 'https://quadrasurface.com/assets/uploads/2023/10/VYH_6192-HDR-min-min.jpg', 'Grand Tidar Malang', 'Malang', '2025-07-16', '0000-00-00', 1, 2, 190000, 2, 50000, 330000, 'BNI', '2025-07-15 08:52:34'),
(44, '50k', 50000, 'rimazulita2@gmail.com', 'Ms', 'Rima', 'Zulita', '08765201738', 'https://quadrasurface.com/assets/uploads/2023/10/VYH_6192-HDR-min-min.jpg', 'Grand Tidar Malang', 'Malang', '2025-07-17', '0000-00-00', 1, 2, 190000, 2, 50000, 330000, 'BCA', '2025-07-16 06:18:20'),
(45, 'none', 0, 'moch.fahrudinalinugroho@gmail.com', 'Ms', 'Rima', 'Zulita', '08765201738', 'https://quadrasurface.com/assets/uploads/2023/10/VYH_6192-HDR-min-min.jpg', 'Grand Tidar Malang', 'Malang', '2025-07-17', '0000-00-00', 1, 2, 190000, 2, 0, 380000, 'BCA', '2025-07-16 06:19:28'),
(46, 'none', 0, 'moch.fahrudinalinugroho@gmail.com', 'Mr', 'Rima', 'Zulita', '08765201738', 'https://quadrasurface.com/assets/uploads/2023/10/VYH_6192-HDR-min-min.jpg', 'Grand Tidar Malang', 'Malang', '2025-07-17', '0000-00-00', 1, 2, 190000, 2, 0, 380000, 'BCA', '2025-07-16 09:21:33'),
(47, '50k', 50000, 'rimazulita2@gmail.com', 'Ms', 'ahay', 'cihuy', '08765201738', 'https://quadrasurface.com/assets/uploads/2023/10/VYH_6192-HDR-min-min.jpg', 'Grand Tidar Malang', 'Malang', '2025-07-17', '0000-00-00', 1, 2, 190000, 2, 50000, 330000, 'BCA', '2025-07-16 11:46:24'),
(48, '50k', 50000, '', 'Mr', '', '', '', 'https://picsum.photos/seed/malang7/300/180', 'Griya Malang Syariah', 'Malang', '2025-07-17', '0000-00-00', 1, 2, 150000, 3, 50000, 400000, 'DANA', '2025-07-16 11:48:27'),
(49, '50k', 50000, 'rimazulita2@gmail.com', 'Ms', 'Rima', 'Zulita', '08765201738', 'https://quadrasurface.com/assets/uploads/2023/10/VYH_6192-HDR-min-min.jpg', 'Grand Tidar Malang', 'Malang', '2025-07-17', '0000-00-00', 1, 2, 190000, 3, 50000, 520000, 'BCA', '2025-07-16 11:54:11');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `token_expired` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `email`, `password`, `reset_token`, `token_expired`) VALUES
(3, 'Rimaa', 'rimazulita2@gmail.com', 'user123', NULL, NULL),
(4, 'Fahrudin', 'moch.fahrudinalinugroho@gmail.com', 'haha123', NULL, NULL),
(5, 'ngisom', 'mfahrudinali7@gmail.com', 'user123', NULL, NULL),
(6, 'Administrator', 'admin@gmail.com', 'admin123', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `hotels`
--
ALTER TABLE `hotels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hotel_gambar`
--
ALTER TABLE `hotel_gambar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hotel_id` (`hotel_id`);

--
-- Indexes for table `pemesanan`
--
ALTER TABLE `pemesanan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `hotels`
--
ALTER TABLE `hotels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `hotel_gambar`
--
ALTER TABLE `hotel_gambar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=163;

--
-- AUTO_INCREMENT for table `pemesanan`
--
ALTER TABLE `pemesanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `hotel_gambar`
--
ALTER TABLE `hotel_gambar`
  ADD CONSTRAINT `hotel_gambar_ibfk_1` FOREIGN KEY (`hotel_id`) REFERENCES `hotels` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
