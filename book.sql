-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 24, 2026 at 08:26 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `book`
--

-- --------------------------------------------------------

--
-- Table structure for table `book`
--

CREATE TABLE `book` (
  `b_id` int(11) NOT NULL,
  `c_id` int(11) NOT NULL,
  `book_name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `book`
--

INSERT INTO `book` (`b_id`, `c_id`, `book_name`, `description`, `price`, `image`) VALUES
(1, 1, 'The Changeling Incident', 'A Gaslamp Epic Fantasy Series, Book 0.1 of The Cursed Mage Case Files\r\nA magical mystery ignites in a gaslit world of intrigue.\r\n\r\n', 100.00, '1784561381_p1.jpeg'),
(2, 2, 'Wings Of Fire An Autobiography', 'Every common man who by his sheer grit and hard work achieves success should share his story with the rest for they may find inspiration and strength to go on, in his story. The \'Wings of Fire\' is one such autobiography by visionary scientist Dr. APJ Abdul Kalam, who from very humble beginnings rose to be the President of India.', 249.00, '1784639753_1.jpeg'),
(7, 2, 'STEVE JOBS (PB): THE EXCLUSIVE BIOGRAPHY', 'Based on more than forty interviews with Steve Jobs conducted over two years - as well as interviews with more than a hundred family members, friends, adversaries, , and colleagues - this is the acclaimed, internationally bestselling biography of the ultimate icon of inventiveness.\r\n', 461.00, '1784640533_2.jpg'),
(8, 2, 'M. K. Gandhi An Autobiography - The Story Of My Experiments With Truth', 'MAHATMA GANDHI AN AUTOBIOGRAPHY, also known simply as The Story of My Experiments with Truth, is the autobiography of Mohandas K. Gandhi, covering his life from early childhood through to 1921.', 100.00, '1784640785_3.jpeg'),
(9, 2, 'Einstein: His Life and Universe', 'Einstein is the great icon of our age: the kindly refugee from oppression whose wild halo of hair, twinkling eyes, engaging humanity and extraordinary brilliance made his face a symbol and his name a synonym for genius.', 306.00, '1784640992_4.jpeg'),
(10, 1, 'Reckless + Powerless + Powerful + Fearless – 4 Book Set By Lauren Roberts ', 'Enter the kingdom of Ilya, where power is everything — and being ordinary can cost you your life. This stunning 4-book collector’s set brings together the full fantasy romance phenomenon that readers around the world have fallen in love with. Packed with danger, secrets, slow-burn chemistry, and heart-stopping twists, the Powerless universe delivers a story you’ll think about long after the final page.', 1499.00, '1784641230_2.jpeg'),
(11, 1, 'The Time Machine by H. G. Wells ', 'Embark on a captivating adventure with H.G. Wells\' The Time Machine. Witness humanity\'s future, explore the depths of time, and ponder on profound questions. This unabridged edition guarantees an immersive experience.\r\n\r\n', 129.00, '1784641443_time machine.jpg'),
(12, 1, '1984 George Orwell [Premium Paperback] ', '1984 by George Orwell is a compelling work of political fiction and one of the greatest modern classics ever written. Set in a dystopian world dominated by surveillance, propaganda, and oppressive control, it tells the story of Winston Smith, a man who dares to seek truth in a society ruled by lies. With its timeless themes of resistance, power, and individuality, this book offers profound insights into the struggles for freedom and identity.\r\n\r\n', 158.00, '1784641582_4.jpeg'),
(13, 4, 'Ancient India by R. C. Majumdar (Author) ', 'This is a comprehensive, intelligible and interesting portrait of Ancient Indian History and Civilization from a national historical point of view. The work is divided into three broad divisions of the natural course of cultural development in Ancient India: (1) From the prehistoric age to 600 B.C., (2) From 600 B.C. to 300 A.D., (3) From 300 A.D. to 1200 A.D.\r\n', 371.00, '1784641785_1.jpg'),
(14, 4, 'India that is Bharat: Coloniality, Civilisation, Constitution by J Sai Deepak (Author) ', 'India, That Is Bharat, the first book of a comprehensive trilogy, explores the influence of European \'colonial consciousness\' (or \'coloniality\'), in particular its religious and racial roots, on Bharat as the successor state to the Indic civilisation and the origins of the Indian Constitution. It lays the foundation for its sequels by covering the period between the Age of Discovery, marked by Christopher Columbus\' expedition in 1492, and the reshaping of Bharat through a British-made constitution-the Government of India Act of 1919.', 539.00, '1784641944_h2.jpeg'),
(15, 4, 'Early India: A Concise History by D.N. Jha', 'Reading books is a kind of enjoyment. Reading books is a good habit. We bring you a different kinds of books. You can carry this book where ever you want. It is easy to carry. It can be an ideal gift to yourself and to your loved ones. Care instruction keep away from fire.\r\n', 335.00, '1784642091_3.jpg'),
(16, 4, 'A Short History of the Mughal Empire (Short Histories)', 'The Mughal Empire dominated India politically, culturally, socially, economically and environmentally, from its foundation by Babur, a Central Asian adventurer, in 1526 to the final trial and exile of the last emperor Bahadur Shah Zafar at the hands of the British in 1858. Throughout the empire\'s three centuries of rise, preeminence and decline, it remained a dynamic and complex entity within and against which diverse peoples and interests conflicted.', 1199.00, '1784644846_4.jpg'),
(17, 3, 'That Night: Four Friends. Twenty Years. One Haunting Secret. | A psychological thriller novel that r', 'Natasha, Riya, Anjali and Katherine were best friends in college - each different from the other yet inseparable - until that night.\r\n\r\nIt was the night that began with a bottle of whisky and a game of Ouija but ended with the death of Sania, their unlikeable hostel mate. The friends vowed never to discuss that fateful night, a pact that had kept their friendship and guilt dormant for the last twenty years.\r\n', 177.00, '1784645044_m1.jpeg'),
(18, 3, 'Five Survive: A CrimeFest Award-Winning YA Thriller of Mystery and Suspense', 'Eighteen year old Red and her friends are on a road trip in an RV, heading to the beach for Spring Break.\r\n\r\nIt’s a long drive but spirits are high. Until the RV breaks down in the middle of nowhere. And as the wheels are shot out, one by one, the friends realise that this is no accident.\r\n\r\nThere’s a sniper out there. He’s watching them and he knows exactly who they are. One of the group has a secret that the sniper is willing to kill for.\r\n\r\n', 302.00, '1784645207_m2.jpg'),
(19, 3, 'THE SILENT PATIENT by Alex Michaelides (Author) ', 'Alicia Berenson lived a seemingly perfect life until one day six years ago.\r\n\r\nWhen she shot her husband in the head five times.\r\n\r\nSince then she hasn\'t spoken a single word.\r\n\r\nIt\'s time to find out why.\r\n', 399.00, '1784645350_m3.jpg'),
(20, 3, 'All the Missing Girls: A Novel by Megan Miranda (Author) ', 'It’s been ten years since Nicolette Farrell left her rural hometown after her best friend, Corinne, disappeared from Cooley Ridge without a trace. Back again to tie up loose ends and care for her ailing father, Nic is soon plunged into a shocking drama that reawakens Corinne’s case and breaks open old wounds long since stitched.\r\n', 1589.00, '1784645482_m4.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `b_id` int(11) NOT NULL,
  `book_name` varchar(100) NOT NULL,
  `book_price` decimal(10,2) NOT NULL,
  `quality` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `book_image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `user_id`, `b_id`, `book_name`, `book_price`, `quality`, `total_price`, `book_image`) VALUES
(1, 3, 11, 'The Time Machine by H. G. Wells ', 0.00, 1, 129.00, '1784641443_time machine.jpg'),
(2, 3, 14, 'India that is Bharat: Coloniality, Civilisation, Constitution by J Sai Deepak (Author) ', 0.00, 1, 539.00, '1784641944_h2.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `c_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`c_id`, `name`, `created_at`) VALUES
(1, 'Fantasy & Science', '2026-07-20 13:31:24'),
(2, 'Biography & Memoir', '2026-07-20 13:31:45'),
(3, 'Mystery & Thriller', '2026-07-20 13:32:23'),
(4, 'History', '2026-07-20 13:32:35');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id`, `name`, `email`, `message`) VALUES
(1, 'Diya Bhimani', 'diyubhimani1904@gmail.com', 'hiii');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `b_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `book_price` decimal(10,2) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `book_name` varchar(255) NOT NULL,
  `book_image` varchar(255) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `b_id`, `quantity`, `book_price`, `payment_method`, `book_name`, `book_image`, `order_date`) VALUES
(1, 1, 19, 3, 399.00, 'Cash On Delivery', 'THE SILENT PATIENT by Alex Michaelides (Author) ', '1784645350_m3.jpg', '2026-07-22 06:14:25'),
(2, 1, 17, 1, 177.00, 'Cash On Delivery', 'That Night: Four Friends. Twenty Years. One Haunting Secret. | A psychological thriller novel that r', '1784645044_m1.jpeg', '2026-07-22 06:14:25'),
(3, 1, 17, 1, 177.00, 'Cash On Delivery', 'That Night: Four Friends. Twenty Years. One Haunting Secret. | A psychological thriller novel that r', '1784645044_m1.jpeg', '2026-07-22 06:28:41'),
(4, 1, 18, 1, 302.00, 'Bank Transfer', 'Five Survive: A CrimeFest Award-Winning YA Thriller of Mystery and Suspense', '1784645207_m2.jpg', '2026-07-23 05:22:07'),
(5, 1, 14, 1, 539.00, 'UPI', 'India that is Bharat: Coloniality, Civilisation, Constitution by J Sai Deepak (Author) ', '1784641944_h2.jpeg', '2026-07-23 05:26:24'),
(6, 1, 18, 2, 302.00, 'Cash On Delivery', 'Five Survive: A CrimeFest Award-Winning YA Thriller of Mystery and Suspense', '1784645207_m2.jpg', '2026-10-13 12:17:29'),
(7, 1, 19, 2, 399.00, 'Cash On Delivery', 'THE SILENT PATIENT by Alex Michaelides (Author) ', '1784645350_m3.jpg', '2026-10-13 12:17:29'),
(8, 1, 18, 1, 302.00, 'Cash On Delivery', 'Five Survive: A CrimeFest Award-Winning YA Thriller of Mystery and Suspense', '1784645207_m2.jpg', '2026-10-16 06:41:07'),
(9, 1, 20, 1, 1589.00, 'Cash on Delivery', 'All the Missing Girls: A Novel by Megan Miranda (Author) ', '1784645482_m4.jpg', '2026-10-24 06:15:38'),
(10, 1, 19, 1, 399.00, 'Cash on Delivery', 'THE SILENT PATIENT by Alex Michaelides (Author) ', '1784645350_m3.jpg', '2026-10-24 06:15:38');

-- --------------------------------------------------------

--
-- Table structure for table `shipping`
--

CREATE TABLE `shipping` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `phone` varchar(15) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shipping`
--

INSERT INTO `shipping` (`id`, `user_id`, `order_id`, `name`, `email`, `address`, `phone`, `created_at`) VALUES
(1, 1, 2, 'Diya', 'db@gmail.com', 'morbi', '1234567890', '2026-07-22 06:14:25'),
(2, 1, 3, 'Diya Bhimani', 'diyubhimani1904@gmail.com', 'morbi', '1234567890', '2026-07-22 06:28:41'),
(3, 1, 4, 'Diya Bhimani', 'diyubhimani1904@gmail.com', 'morbi', '1234567890', '2026-07-23 05:22:07'),
(4, 1, 5, 'Diya Bhimani', 'diyubhimani1904@gmail.com', 'morbi', '1234567890', '2026-07-23 05:26:24'),
(5, 1, 6, 'Diya Bhimani', 'diyubhimani1904@gmail.com', 'morbi', '1234567890', '2026-10-13 12:17:29'),
(6, 1, 7, 'Diya Bhimani', 'diyubhimani1904@gmail.com', 'morbi', '1234567890', '2026-10-13 12:17:29'),
(7, 1, 8, 'dhruvi kansagra', 'dhruvi@gmail.com', 'bopal', '9426179528', '2026-10-16 06:41:07'),
(8, 1, 9, 'Diya Bhimani', 'diyabhimani2004@gmail.com', 'morbi -2', '1234567890', '2026-10-24 06:15:38'),
(9, 1, 10, 'Diya Bhimani', 'diyabhimani2004@gmail.com', 'morbi -2', '1234567890', '2026-10-24 06:15:38');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email_id` varchar(30) NOT NULL,
  `mobile_no` int(12) NOT NULL,
  `city` varchar(50) NOT NULL,
  `pincode` int(6) NOT NULL,
  `address` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `email_id`, `mobile_no`, `city`, `pincode`, `address`) VALUES
(1, 'Diya', '$2y$10$KBD86is4mBUmFwE5j2pjfOF/TlP8xrPxOL0Q7FzfMm3VQGEs.F4iu', 'db123@gmail.com', 1234567890, 'morbi', 363642, 'morbi');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`b_id`),
  ADD KEY `c_id` (`c_id`) USING BTREE;

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `b_id` (`b_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`c_id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `b_id` (`b_id`);

--
-- Indexes for table `shipping`
--
ALTER TABLE `shipping`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `book`
--
ALTER TABLE `book`
  MODIFY `b_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `shipping`
--
ALTER TABLE `shipping`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
