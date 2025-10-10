-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Oct 10, 2025 at 07:06 AM
-- Server version: 8.0.40
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `draft-shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Smartphones', 'Tous les smartphones modernes', '2025-10-01 11:01:26', '2025-10-01 11:01:26'),
(2, 'Ordinateurs', 'PC portables et fixes', '2025-10-01 11:01:26', '2025-10-01 11:01:26'),
(3, 'Tablettes', 'Tablettes tactiles et hybrides', '2025-10-01 11:01:26', '2025-10-01 11:01:26'),
(4, 'Accessoires', 'Accessoires pour ordinateurs et téléphones', '2025-10-01 11:01:26', '2025-10-01 11:01:26'),
(5, 'Montres', 'Montres connectées et classiques', '2025-10-01 11:01:26', '2025-10-01 11:01:26'),
(6, 'Casques Audio', 'Casques et écouteurs', '2025-10-01 11:01:26', '2025-10-01 11:01:26'),
(7, 'TV & Vidéo', 'Télévisions, projecteurs et supports vidéo', '2025-10-01 11:01:26', '2025-10-01 11:01:26'),
(8, 'Jeux Vidéo', 'Consoles et jeux', '2025-10-01 11:01:26', '2025-10-01 11:01:26'),
(9, 'Photo & Caméra', 'Appareils photo et caméras', '2025-10-01 11:01:26', '2025-10-01 11:01:26'),
(10, 'Maison Connectée', 'Objets connectés pour la maison', '2025-10-01 11:01:26', '2025-10-01 11:01:26');

-- --------------------------------------------------------

--
-- Table structure for table `clothing`
--

CREATE TABLE `clothing` (
  `product_id` int UNSIGNED NOT NULL,
  `size` varchar(10) DEFAULT NULL,
  `color` varchar(50) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `material_fee` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `clothing`
--

INSERT INTO `clothing` (`product_id`, `size`, `color`, `type`, `material_fee`) VALUES
(61, 'L', 'Bleu', 'Sport', 5),
(62, 'L', 'Blue', 'T-Shirt', 5),
(64, 'L', 'Blue', 'T-Shirt', 5),
(66, 'L', 'Noir', 'T-shirt', 5),
(67, 'L', 'Noir', 'T-shirt', 5),
(69, 'L', 'Noir', 'T-shirt', 5),
(71, 'L', 'Noir', 'T-shirt', 5),
(73, 'L', 'Noir', 'T-shirt', 5),
(75, 'L', 'Noir', 'T-shirt', 5);

-- --------------------------------------------------------

--
-- Table structure for table `electronic`
--

CREATE TABLE `electronic` (
  `product_id` int UNSIGNED NOT NULL,
  `brand` varchar(100) DEFAULT NULL,
  `warranty_fee` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `electronic`
--

INSERT INTO `electronic` (`product_id`, `brand`, `warranty_fee`) VALUES
(63, 'BrandX', 12),
(65, 'BrandX', 12),
(68, 'BrandY', 24),
(70, 'BrandY', 24),
(72, 'BrandY', 24),
(74, 'BrandY', 24),
(76, 'BrandY', 24);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `photos` text,
  `price` decimal(10,2) NOT NULL,
  `description` text,
  `quantity` int UNSIGNED DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `category_id` int UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `photos`, `price`, `description`, `quantity`, `created_at`, `updated_at`, `category_id`) VALUES
(21, 'unknown', '[\"https:\\/\\/picsum.photos\\/200\\/300\"]', 0.00, 'No description', 0, '2025-10-02 14:17:24', '2025-10-02 14:17:24', NULL),
(22, 'Test product', '[\"https:\\/\\/picsum.photos\\/200\\/300\"]', 99.99, 'This is a test product', 10, '2025-10-03 08:26:52', '2025-10-03 08:26:52', 1),
(23, 'Test product', '[\"https:\\/\\/picsum.photos\\/200\\/300\"]', 99.99, 'This is a test product', 10, '2025-10-03 09:34:47', '2025-10-03 09:34:47', 1),
(24, 'Test product', '[\"https:\\/\\/picsum.photos\\/200\\/300\"]', 99.99, 'This is a test product', 10, '2025-10-03 11:32:33', '2025-10-03 11:32:33', 1),
(25, 'Test product', '[\"https:\\/\\/picsum.photos\\/200\\/300\"]', 99.99, 'This is a test product', 10, '2025-10-03 11:33:02', '2025-10-03 11:33:02', 1),
(26, 'Test product', '[\"https:\\/\\/picsum.photos\\/200\\/300\"]', 99.99, 'This is a test product', 10, '2025-10-03 11:37:35', '2025-10-03 11:37:35', 1),
(28, 'Produit mis à jour', '[\"https:\\/\\/picsum.photos\\/200\\/300\",\"https:\\/\\/picsum.photos\\/200\\/301\"]', 149.99, 'This is a test product', 20, '2025-10-03 12:04:24', '2025-10-03 12:04:24', 1),
(61, 'T-shirt Nike', '[\"https:\\/\\/picsum.photos\\/200\\/300\",\"https:\\/\\/picsum.photos\\/200\\/300\"]', 29.99, 'T-shirt de sport confortable', 100, '2025-10-07 10:05:26', '2025-10-07 10:05:26', 1),
(62, 'T-Shirt Test', '[\"https:\\/\\/picsum.photos\\/200\\/300\",\"https:\\/\\/picsum.photos\\/200\\/301\"]', 29.99, 'T-shirt de test', 10, '2025-10-07 10:18:50', '2025-10-07 10:18:50', 1),
(63, 'Casque Test', '[\"https:\\/\\/picsum.photos\\/200\\/310\"]', 99.99, 'Casque de test', 5, '2025-10-07 10:18:50', '2025-10-07 10:18:50', 2),
(64, 'T-Shirt Test', '[\"https:\\/\\/picsum.photos\\/200\\/300\",\"https:\\/\\/picsum.photos\\/200\\/301\"]', 29.99, 'T-shirt de test', 10, '2025-10-08 08:32:31', '2025-10-08 08:32:31', 1),
(65, 'Casque Test', '[\"https:\\/\\/picsum.photos\\/200\\/310\"]', 99.99, 'Casque de test', 5, '2025-10-08 08:32:31', '2025-10-08 08:32:31', 2),
(66, 'T-shirt noir', '[\"https:\\/\\/picsum.photos\\/200\\/300\"]', 19.99, 'T-shirt 100% coton', 10, '2025-10-08 12:53:43', '2025-10-08 12:53:43', 1),
(67, 'T-shirt noir', '[\"https:\\/\\/picsum.photos\\/200\\/300\"]', 19.99, 'T-shirt 100% coton', 10, '2025-10-08 13:40:51', '2025-10-08 13:40:51', 1),
(68, 'Smartphone XYZ', '[\"https:\\/\\/picsum.photos\\/201\"]', 499.99, 'Smartphone avec écran HD', 15, '2025-10-08 13:40:51', '2025-10-08 13:40:51', 2),
(69, 'T-shirt noir', '[\"https:\\/\\/picsum.photos\\/200\\/300\"]', 19.99, 'T-shirt 100% coton', 10, '2025-10-08 13:52:03', '2025-10-08 13:52:03', 1),
(70, 'Smartphone XYZ', '[\"https:\\/\\/picsum.photos\\/201\"]', 499.99, 'Smartphone avec écran HD', 15, '2025-10-08 13:52:03', '2025-10-08 13:52:03', 2),
(71, 'T-shirt noir', '[\"https:\\/\\/picsum.photos\\/200\\/300\"]', 19.99, 'T-shirt 100% coton', 10, '2025-10-08 14:20:38', '2025-10-08 14:20:38', 1),
(72, 'Smartphone XYZ', '[\"https:\\/\\/picsum.photos\\/201\"]', 499.99, 'Smartphone avec écran HD', 15, '2025-10-08 14:20:38', '2025-10-08 14:20:38', 2),
(73, 'T-shirt noir', '[\"https:\\/\\/picsum.photos\\/200\\/300\"]', 19.99, 'T-shirt 100% coton', 10, '2025-10-08 14:20:45', '2025-10-08 14:20:45', 1),
(74, 'Smartphone XYZ', '[\"https:\\/\\/picsum.photos\\/201\"]', 499.99, 'Smartphone avec écran HD', 15, '2025-10-08 14:20:45', '2025-10-08 14:20:45', 2),
(75, 'T-shirt noir', '[\"https:\\/\\/picsum.photos\\/200\\/300\"]', 19.99, 'T-shirt 100% coton', 10, '2025-10-08 14:29:22', '2025-10-08 14:29:22', 1),
(76, 'Smartphone XYZ', '[\"https:\\/\\/picsum.photos\\/201\"]', 499.99, 'Smartphone avec écran HD', 15, '2025-10-08 14:29:22', '2025-10-08 14:29:22', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clothing`
--
ALTER TABLE `clothing`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `electronic`
--
ALTER TABLE `electronic`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `clothing`
--
ALTER TABLE `clothing`
  ADD CONSTRAINT `clothing_fk_product` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `electronic`
--
ALTER TABLE `electronic`
  ADD CONSTRAINT `electronic_fk_product` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
