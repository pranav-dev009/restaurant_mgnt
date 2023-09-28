-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 10, 2021 at 09:31 AM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `restaurant`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `name` varchar(225) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(500) NOT NULL,
  `created_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `email`, `password`, `created_date`) VALUES
(9, 'admin', 'admin@gmail.com', 'YWRtaW4=', '2021-05-03'),
(10, 'pranav', 'pranav@gmail.com', 'cHJhbmF2', '2021-05-03');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `menu_type` varchar(100) NOT NULL,
  `sort_order` int(3) NOT NULL,
  `status` enum('0','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `menu_type`, `sort_order`, `status`) VALUES
(1, 'Punjabi', 1, '1'),
(2, 'Chinese', 2, '1'),
(3, 'South Indian', 3, '1'),
(4, 'Gujrati', 4, '1');

-- --------------------------------------------------------

--
-- Table structure for table `cms`
--

CREATE TABLE `cms` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `page_title` varchar(255) NOT NULL,
  `page_desc` varchar(1000) NOT NULL,
  `meta_title` varchar(255) NOT NULL,
  `meta_keywords` varchar(100) NOT NULL,
  `meta_desc` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cms`
--

INSERT INTO `cms` (`id`, `name`, `page_title`, `page_desc`, `meta_title`, `meta_keywords`, `meta_desc`) VALUES
(1, 'index.php', 'Index Page', 'Introduction of our system, listing all items. Nullam sed leo risus. Ut tellus leo faucibus vitae tortor sed, euismod disnissim ex. Cras non mi vitae enim faucibus dignissim. Praesent scelerisque condimentum elit, non congue metus lacinia malesuada. Vestibulum purus arcu, molestie in mattis sit amet, aliquet eget est. Ut mollis enim est, eu fermentum nisi viverra hendrerit. Fusce sed est ac ante posuere convallis.Vivamus egestas mauris sit amet lobortis cursus. Vestibulum hendrerit molestie sagittis. ', '<b>Index</b>', 'Overview', 'Overview of our system'),
(3, 'MenuListing.php', 'Menu Listing Page', 'Nullam sed leo risus.Ut tellus leo faucibus vitae tortor sed, euismod disnissim ex. Cras non mi vitae enim faucibus dignissim. Praesent scelerisque condimentum elit, non congue metus lacinia malesuada. Vestibulum purus arcu, molestie in mattis sit amet, aliquet eget est. Ut mollis enim est, eu fermentum nisi viverra hendrerit. Fusce sed est ac ante posuere convallis.Vivamus egestas mauris sit amet lobortis cursus. Vestibulum hendrerit molestie sagittis. Ut mollis enim est, eu fermentum nisi viverra hendrerit. Fusce sed est ac ante posuere convallis.Vivamus egestas mauris sit amet lobortis cursus. Vestibulum hendrerit molestie sagittis.Ut mollis enim est, eu fermentum nisi viverra hendrerit. Fusce sed est ac ante posuere convallis.Vivamus egestas mauris sit amet lobortis cursus. Vestibulum hendrerit molestie sagittis. ', 'Menu List', 'Menu, timings, information', 'Information about various food items'),
(4, 'MenuItem.php', 'Item Details Page', 'Nullam sed leo risus.Ut tellus leo faucibus vitae tortor sed, euismod disnissim ex. Cras non mi vitae enim faucibus dignissim. Praesent scelerisque condimentum elit, non congue metus lacinia malesuada. Vestibulum purus arcu, molestie in mattis sit amet, aliquet eget est. Ut mollis enim est, eu fermentum nisi viverra hendrerit. Fusce sed est ac ante posuere convallis.Vivamus egestas mauris sit amet lobortis cursus. Vestibulum hendrerit molestie sagittis. Ut mollis enim est, eu fermentum nisi viverra hendrerit. Fusce sed est ac ante posuere convallis.Vivamus egestas mauris sit amet lobortis cursus. Vestibulum hendrerit molestie sagittis.Ut mollis enim est, eu fermentum nisi viverra hendrerit. Fusce sed est ac ante posuere convallis.Vivamus egestas mauris sit amet lobortis cursus. Vestibulum hendrerit molestie sagittis.', 'Item Details', 'Item Information', 'All details about particular item'),
(5, 'contact_us.php', 'Contact Us Page', 'Nullam sed leo risus.Ut tellus leo faucibus vitae tortor sed, euismod disnissim ex. Cras non mi vitae enim faucibus dignissim. Praesent scelerisque condimentum elit, non congue metus lacinia malesuada. Vestibulum purus arcu, molestie in mattis sit amet, aliquet eget est. Ut mollis enim est, eu fermentum nisi viverra hendrerit. Fusce sed est ac ante posuere convallis.Vivamus egestas mauris sit amet lobortis cursus. Vestibulum hendrerit molestie sagittis. Ut mollis enim est, eu fermentum nisi viverra hendrerit. Fusce sed est ac ante posuere convallis.Vivamus egestas mauris sit amet lobortis cursus. Vestibulum hendrerit molestie sagittis.Ut mollis enim est, eu fermentum nisi viverra hendrerit. Fusce sed est ac ante posuere convallis.Vivamus egestas mauris sit amet lobortis cursus. Vestibulum hendrerit molestie sagittis.', 'Contact Us', 'User Details', 'For any queries, please submit the form and connect with us');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `image` varchar(100) NOT NULL,
  `description` varchar(500) NOT NULL,
  `price` int(4) NOT NULL,
  `item_availabel_to` varchar(255) NOT NULL,
  `status` enum('0','1') NOT NULL,
  `sort_order` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `category_id`, `name`, `image`, `description`, `price`, `item_availabel_to`, `status`, `sort_order`) VALUES
(1, 2, 'Dry Manchurian', 'manchurian_2021-04-29.jpg', 'Dry Manchurian is a delicious indo-chinese appetizer. It is prepared by coating fried vegetable balls in a juicy, tangy, and sweet sauce. It’s essentially fried vegetable balls coated in a sticky, tangy-sweet sauce. The sauce itself is the essence of this dish because it’s full of umami inducing ingredients. The sauteed ginger, garlic and onions along with the saucy and sticky soy sauce , vinegar, hot sauce and corn starch slurry is what makes this sauce so temping.', 90, 'Lunch,Dinner', '1', 1),
(2, 4, 'Dhokla', 'dhokla_2021-05-01.jpg', 'Dhokla is a vegetarian culinary dish that is found mainly in the Indian state of Gujarat and parts of adjacent states. It is made with a fermented batter derived from rice, ground urad dal, and chickpea flour. Dhokla can be eaten for breakfast, as a main course, as a side dish, or as a snack. Dhokla is very similar to Khaman, however Dhokla is made of batter derived from mixture of rice flour and chickpea flour, whereas Khaman is typically made from Chickpeas gram and looks yellow in color', 40, 'Breakfast', '1', 2),
(3, 4, 'Kathiyawadi', 'kathiyawadi_2021-05-01.jpg', 'Kathiyawadi thali is often only described as a more spicy and greasy variant of a Gujarati Thali, Buttermilk or lassi forms an essential part of the Kathiawari thali, instead of the aam ras, which usually starts as an opener for a Gujarati Thali. In winters, the region has to battle severe dip in temperature and this spicy platter helps them keep up with inhospitable weather conditions.', 120, 'Lunch', '1', 3),
(4, 3, 'Medu wada', 'meduwada_2021-05-01.jpg', 'Medu vada – Crispy, fluffy and delicious vada that goes very well with coconut chutney or sambar. These urad dal vada are also known as Garelu in Andhra, Uzhunnu Vada in Kerala and Medhu Vadai in Tamil Nadu.These doughnuts shaped fritters are made with black gram, herbs, coconut and spices. Even though the main ingredient is urad dal (black gram) but the herbs and spices can vary. You can also add vegetables like onions or grated carrots or grated beetroot.', 70, 'Breakfast,Dinner', '1', 4),
(5, 3, 'Dosa', 'dosa_2021-05-01.jpg', 'A dosai or dosa or dose is a thin pancake or crepe, originating from South India, made from a fermented batter predominantly consisting of lentils and rice. It is somewhat similar to a crepe in appearance, although savoury flavours are generally emphasized (sweet variants also exist). Its main ingredients are rice and black gram, ground together in a fine, smooth batter with a dash of salt, then fermented. Dosas are a common dish in South Indian cuisine, but now have become popular all over the ', 80, 'Breakfast,Lunch,Dinner', '1', 5),
(6, 1, 'Aalo Paratha', 'paratha_2021-05-01.jpg', 'Aloo Ka Paratha served with dollops of white butter, curd, pickle and chutney.ecipe is wheat flour, boiled potatoes, green chillies, coriander leaves, red chilli powder, black pepper and asafoetida along with little carom seeds and garam masala. This recipe has used both carom seeds and asafoetida. The key to making flawless, tastier and soft Aloo Paratha is to mash the potatoes well using a masher or you can also grate the potatoes for giving a fine touch to mashed potatoes. ', 100, 'Breakfast,Lunch', '1', 3),
(7, 1, 'Paneer Butter Masala', 'pannerbuttermasala_2021-05-01.jpg', 'Paneer butter masala is a North Indian delicacy that translates to”cubes of Indian cottage cheese cooked in a rich and creamy onion-tomato-cashew sauce.” Paneer Butter Masala can be found in most Indian restaurants worldwide, sometimes listed as Paneer Makhani, butter paneer, Paneer Makhanwala, or Shahi paneer. Whatever the name, this Punjabi paneer curry is worth trying, and its buttery taste will blow your mind. ', 120, 'Lunch,Dinner', '1', 1),
(8, 2, 'Noodles', 'noodles_2021-05-01.jpg', 'The one pan Manchurian noodles are a wonderful Indo Chinese snack you can enjoy any time. It has a crunch of veggies and softness of noodles. This noodle is full of flavors along with an ample amount of nutrition. It is easy to prepare.', 70, 'Dinner', '1', 4);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone_no` varchar(13) NOT NULL,
  `details` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone_no`, `details`) VALUES
(1, 'pranav', 'pranav.kolharkar1752@gmail.com', '8238220136', 'Studying MCA in GLS university'),
(4, 'Ravi', 'ravi853@gmail.com', '1234567890', 'Studying MCA in Nirma'),
(5, 'Jay', 'jay1@gmail.com', '0987654321', 'Studying MscIT in GLS university');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms`
--
ALTER TABLE `cms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `cms`
--
ALTER TABLE `cms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
