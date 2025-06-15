-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 15 Jun 2025 pada 15.40
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `zombos_skateshop`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `quantity`, `added_at`) VALUES
(20, 5, 1, 2, '2025-06-15 10:14:15');

-- --------------------------------------------------------

--
-- Struktur dari tabel `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` enum('pending','processing','shipped','delivered','cancelled') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_amount`, `status`, `created_at`) VALUES
(1, 4, 340.50, 'pending', '2025-06-15 05:29:35'),
(2, 4, 113.50, 'pending', '2025-06-15 05:58:10'),
(3, 1, 113.50, 'pending', '2025-06-15 06:31:15'),
(4, 1, 232.50, 'pending', '2025-06-15 07:43:02'),
(5, 1, 1721.09, 'pending', '2025-06-15 13:08:16');

-- --------------------------------------------------------

--
-- Struktur dari tabel `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(1, 1, 1, 3, 113.50),
(2, 2, 1, 1, 113.50),
(3, 3, 1, 1, 113.50),
(4, 4, 2, 2, 59.50),
(5, 4, 3, 1, 113.50),
(6, 5, 3, 1, 113.50),
(7, 5, 9, 2, 119.90),
(8, 5, 10, 2, 589.90),
(9, 5, 21, 1, 14.99),
(10, 5, 5, 1, 59.50),
(11, 5, 1, 1, 113.50);

-- --------------------------------------------------------

--
-- Struktur dari tabel `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `category` enum('skateboard','shoes','clothing','accessories') NOT NULL,
  `brand` varchar(50) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `stock_quantity` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `category`, `brand`, `image_path`, `stock_quantity`, `created_at`, `updated_at`) VALUES
(1, 'Dead Low Pro Show', 'High-performance skate shoes with durable construction and excellent board feel', 113.50, 'shoes', 'NINE 50', 'img/Shoes/174379-0-NikeSB-DunkLowProB.jpg', 50, '2025-06-14 21:37:48', '2025-06-14 21:37:48'),
(2, '482-000', 'Classic skate shoes with vulcanized sole for better board control', 59.50, 'shoes', 'NEW BALANCE NUMERIC', 'img/Shoes/172127-0-NewBalanceNumeric-480.jpg', 75, '2025-06-14 21:37:48', '2025-06-14 21:37:48'),
(3, 'Chief Company OMs Sheva', 'Premium skate shoes with suede upper and cushioned insole', 113.50, 'shoes', 'ADIDAS', 'img/Shoes/172203-0-adidas-SkateboardingTyshawnII.jpg', 40, '2025-06-14 21:37:48', '2025-06-14 21:37:48'),
(4, '1011 Hope Sheva', 'Professional skate shoes with impact-absorbing technology', 109.50, 'shoes', 'NEW BALANCE NUMERIC', 'img/Shoes/172127-0-NewBalanceNumeric-480.jpg', 60, '2025-06-14 21:37:48', '2025-06-14 21:37:48'),
(5, 'Stationomogy Pupi Sheva', 'Affordable entry-level skate shoes with good durability', 59.50, 'shoes', 'ADIDAS', 'img/Shoes/137134-0-adidas-SkateboardingGazelleADV.jpg', 85, '2025-06-14 21:37:48', '2025-06-14 21:37:48'),
(6, 'Stationomogy Typhoon & Sheva', 'Lightweight shoes designed for street skating', 59.50, 'shoes', 'ADIDAS', 'img/Shoes/173901-0-NikeSB-DunkLowPro.jpg', 65, '2025-06-14 21:37:48', '2025-06-14 21:37:48'),
(7, 'Dead Low Pro Show V2', 'Updated version with improved cushioning and durability', 113.50, 'shoes', 'NINE 50', 'img/Shoes/174379-0-NikeSB-DunkLowProB.jpg', 55, '2025-06-14 21:37:48', '2025-06-14 21:37:48'),
(8, 'Skate Pro 5000', 'Professional skate shoes with advanced cushioning technology and durable suede upper', 129.99, 'shoes', 'VANS', 'img/Shoes/173901-0-NikeSB-DunkLowPro.jpg', 45, '2025-06-14 21:37:48', '2025-06-14 21:37:48'),
(9, 'Atlas T-Shirt', 'Antix Atlas graphic t-shirt', 119.90, 'clothing', 'Antix', 'img/Clothing/165067-3-Antix-Atlas.jpg', 10, '2025-06-15 08:35:20', '2025-06-15 08:35:20'),
(10, 'Slack Hoodie', 'Antix Slack pullover hoodie', 589.90, 'clothing', 'Antix', 'img/Clothing/133242-2-Antix-Slack.jpg', 10, '2025-06-15 08:35:20', '2025-06-15 08:35:20'),
(11, 'Sunessy Sweater', 'Aniell Sunessy knitted sweater', 589.90, 'clothing', 'ANIELL', 'img/Clothing/174775-0-Anuell-Sunessy.jpg', 10, '2025-06-15 08:35:20', '2025-06-15 08:35:20'),
(12, 'Lightessy Sweater', 'Aniell Lightessy lightweight knit', 589.90, 'clothing', 'ANIELL', 'img/Clothing/174776-0-Anuell-Lightessy.jpg', 10, '2025-06-15 08:35:20', '2025-06-15 08:35:20'),
(13, 'Herber Organic T-Shirt', 'Aniell Herber organic cotton tee', 589.90, 'clothing', 'ANIELL', 'img/Clothing/174121-0-Anuell-HerberOrganic.jpg', 10, '2025-06-15 08:35:20', '2025-06-15 08:35:20'),
(14, 'Femina Organic Knit', 'Antix Femina organic knit top', 118.90, 'clothing', 'Antix', 'img/Clothing/171030-0-Antix-FeminaOrganicKnit.jpg', 10, '2025-06-15 08:35:20', '2025-06-15 08:35:20'),
(15, 'Majesty Light Organic', 'Aniell Majesty Light organic knit', 119.90, 'clothing', 'ANIELL', 'img/Clothing/174595-0-Anuell-MajestyLightOrganicKnit.jpg', 10, '2025-06-15 08:35:20', '2025-06-15 08:35:20'),
(16, 'Riley II Coach Jacket', 'Vans Riley II coach jacket', 119.90, 'clothing', 'Vans', 'img/Clothing/169646-5-Vans-RileyIICoach.jpg', 10, '2025-06-15 08:35:20', '2025-06-15 08:35:20'),
(17, 'Scriptum Mid Socks 3 Pack', 'Antix Scriptum Mid socks (3 pairs)', 14.99, 'accessories', 'ANTIX', 'img/Accesories/171495-0-Antix-ScriptumMid.jpg', 20, '2025-06-15 08:35:20', '2025-06-15 08:35:20'),
(18, 'Athletic Socks 3 Pack', 'Skatedeluxe Athletic socks (3 pairs)', 14.99, 'accessories', 'SKATEDELUX', 'img/Accesories/171483-0-skatedeluxe-Athletic.jpg', 20, '2025-06-15 08:35:20', '2025-06-15 08:35:20'),
(19, 'Plain Boxer Shorts', 'Lousy Livin plain black boxers', 14.99, 'accessories', 'Lousy Livin', 'img/Accesories/173165-0-LousyLivin-Plain.jpg', 20, '2025-06-15 08:35:20', '2025-06-15 08:35:20'),
(20, 'Script Leather Belt', 'Carhartt WIP script leather belt', 14.99, 'accessories', 'CARHARTT WIP', 'img/Accesories/157392-0-CarharttWIP-ScriptLeather.jpg', 20, '2025-06-15 08:35:20', '2025-06-15 08:35:20'),
(21, 'Avocado Boxer Shorts', 'Lousy Livin avocado print boxers', 14.99, 'accessories', 'Lousy Livin', 'img/Accesories/130697-0-LousyLivinUnderwear-Avocado.jpg', 20, '2025-06-15 08:35:20', '2025-06-15 08:35:20'),
(22, 'Flowers Boxer Shorts', 'Lousy Livin psychedelic flower boxers', 14.99, 'accessories', 'Lousy Livin', 'img/Accesories/167395-0-LousyLivin-Flowers.jpg', 20, '2025-06-15 08:35:20', '2025-06-15 08:35:20'),
(23, 'Aper Boxer Shorts', 'Aniell Aper swirl print boxers', 14.99, 'accessories', 'ANIELL', 'img/Accesories/167405-0-Anuell-Aper.jpg', 20, '2025-06-15 08:35:20', '2025-06-15 08:35:20'),
(24, 'Sculp Boxer Shorts', 'Antix Sculp gothic print boxers', 14.99, 'accessories', 'Antix', 'img/Accesories/167406-0-Antix-Sculp.jpg', 20, '2025-06-15 08:35:20', '2025-06-15 08:35:20'),
(25, 'Bird Kids Deck', 'Skatedeluxe Bird Kids skateboard deck', 99.00, 'skateboard', 'SKATEDELUX', 'img/Skate/173949-0-skatedeluxe-BirdKids.jpg', 15, '2025-06-15 10:24:52', '2025-06-15 10:24:52'),
(26, 'Mystery Deck', 'Skatedeluxe Mystery skateboard deck', 99.00, 'skateboard', 'SKATEDELUX', 'img/Skate/173951-0-skatedeluxe-Mystery.jpg', 15, '2025-06-15 10:24:52', '2025-06-15 10:24:52'),
(27, 'Panther Old School Deck', 'Panther Old School skateboard deck', 99.00, 'skateboard', 'PANTHER', 'img/Skate/173952-0-Panther-Oldschool.jpg', 15, '2025-06-15 10:24:52', '2025-06-15 10:24:52'),
(28, 'Fisherman Egg Deck', 'Skatedeluxe Fisherman Egg skateboard deck', 99.00, 'skateboard', 'SKATEDELUX', 'img/Skate/177144-0-skatedeluxe-FishermanEgg.jpg', 15, '2025-06-15 10:24:52', '2025-06-15 10:24:52');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_admin` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `first_name`, `last_name`, `address`, `phone`, `created_at`, `is_admin`) VALUES
(1, 'deva', 'variskid@gmail.com', '$2y$10$JAlZfCc/xOKaHkGcYZ28Oudms7PKFx8Tn7.vc3WYIcU0P4XkCjo5q', NULL, NULL, NULL, NULL, '2025-06-14 22:50:55', 0),
(2, 'variski', 'oceangts@gmail.com', '$2y$10$TIW1LBmKp6PwKyhQ51fX8OS9iE82t/32Zy9maUknrHEE9ObjJlL1S', NULL, NULL, NULL, NULL, '2025-06-15 05:04:05', 0),
(3, 'eka', 'variski123@gmail.com', '$2y$10$gOUb9zggjtzA4mBIQypcWuyXZNd0lRyiHaD4T3WM.U.l3iSDSgJeO', NULL, NULL, NULL, NULL, '2025-06-15 05:09:38', 0),
(4, 'billy', 'billy@gmail.com', '$2y$10$2cCtrBa/TJATS2dSOyrcyel47KMm/JDF7mcQyc9vOft7hov.bAOUe', NULL, NULL, NULL, NULL, '2025-06-15 05:14:27', 0),
(5, 'wezssa', 'wezssa@gmail.com', '$2y$10$CRWWqZ3.wSMX630sMkJ8/Oq1uG9HGgVmi0vfxqK.TBRG7C6DjxeCW', NULL, NULL, NULL, NULL, '2025-06-15 07:44:15', 0);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indeks untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indeks untuk tabel `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT untuk tabel `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Ketidakleluasaan untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
