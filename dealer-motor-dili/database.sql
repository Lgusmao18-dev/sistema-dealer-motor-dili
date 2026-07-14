-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 09, 2026 at 07:59 AM
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
-- Database: `db_dealer_motor_dili`
--

-- --------------------------------------------------------

--
-- Table structure for table `dealer_motor`
--

CREATE TABLE `dealer_motor` (
  `id` int(11) NOT NULL,
  `nama_dealer` varchar(200) NOT NULL,
  `marka` varchar(100) NOT NULL DEFAULT '',
  `presu` decimal(12,2) DEFAULT 0.00,
  `alamat` text NOT NULL,
  `latitude` decimal(10,8) NOT NULL,
  `longitude` decimal(11,8) NOT NULL,
  `jam_buka` varchar(50) NOT NULL DEFAULT '08:00 - 17:00',
  `telepon` varchar(30) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dealer_motor`
--

INSERT INTO `dealer_motor` (`id`, `nama_dealer`, `marka`, `presu`, `alamat`, `latitude`, `longitude`, `jam_buka`, `telepon`, `email`, `facebook`, `instagram`, `deskripsi`, `foto`, `created_at`, `updated_at`) VALUES
(1, 'DEALER HONDA MEFA-OSSO-MESSA', 'Honda', 2500.00, 'R. Dom Luís dos Reis Noronha, Díli', -8.55756190, 125.57133500, '07:30 - 23:59', '+670 7700 1111', 'mefa.osso@hondadealer.tl', 'fb.com/mefaossomessa', '@mefa_osso', 'Dealer resmi Honda iha area Motael.', 'honda_mefa.png', '2026-05-16 17:41:24', '2026-05-17 02:35:17'),
(2, 'DEALER HONDA DIOGO MOTO FORTE', 'Honda', 2800.00, 'Colmera, Vera Cruz, Díli (Blok B1 No. A8)', -8.55449380, 125.57468390, '09:00 - 17:00', '+670 7700 2222', 'diogo.moto@hondadealer.tl', 'fb.com/diogomotoforte', '@diogo_moto', 'Dealer resmi Honda — Diogo Moto Forte.', 'Honda diego.png', '2026-05-16 17:41:24', '2026-05-17 02:35:17'),
(3, 'Cedars Motor', 'Honda', 2300.00, 'Av. Liberdade de Imprensa, Díli', -8.55627600, 125.58661700, '08:00 - 17:00', '+670 7700 3333', 'cedars.motor@hondadealer.tl', 'fb.com/cedarsmotor', '@cedars_motor', 'Dealer resmi Honda iha Santa Cruz.', 'cedars.png', '2026-05-16 17:41:24', '2026-05-17 02:35:17'),
(4, 'Gilsanrem Unipessoal Lda', 'Honda', 2100.00, 'Estr. de Balide, Díli', -8.56577240, 125.57484010, '08:00 - 17:00', '+670 7700 4444', 'gilsanrem@hondadealer.tl', 'fb.com/gilsanrem', '@gilsanrem', 'Dealer resmi Honda — Gilsanrem Unipessoal.', 'gilsanren.png', '2026-05-16 17:41:24', '2026-05-17 02:35:17'),
(5, 'Palma Motor – Dili Timor Leste', 'Honda', 2600.00, 'Lecidere, Bidau Lecidere, Díli', -8.55219800, 125.58427620, '08:30 - 17:30', '+670 7700 5555', 'palma.motor@hondadealer.tl', 'fb.com/palmamotor', '@palma_motor', 'Dealer resmi Honda iha area Bidau.', 'palm_motor.png', '2026-05-16 17:41:24', '2026-05-17 02:35:17'),
(6, 'Dealer Honda Caibete Motor Dili', 'Yamaha', 2450.00, 'Avenida de Hudi Laran, Delta 2, Díli', -8.56150000, 125.54500000, '08:00 - 17:00', '+670 7700 6666', 'caibete.motor@hondadealer.tl', 'fb.com/caibetemotor', '@caibete_motor', 'Dealer resmi Honda — Caibete Motor iha area Hudi Laran.', 'caibete.png', '2026-05-17 03:11:36', '2026-06-08 02:02:17');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `name`, `email`, `subject`, `message`, `created_at`) VALUES
(4, 'Pedro dos Reis', 'pedrodejesusdosreis34@gmail.com', 'Hola motr', 'Ajuda share Loc', '2026-06-08 02:15:51'),
(5, 'Lucas Gusmão do Nascimento', 'gusmaolucas394@gmail.com', 'fdgrgre', 'gtrgtrgtrg', '2026-06-08 06:27:39');

-- --------------------------------------------------------

--
-- Table structure for table `motor_models`
--

CREATE TABLE `motor_models` (
  `id` int(11) NOT NULL,
  `nama_model` varchar(200) NOT NULL,
  `marka` varchar(100) NOT NULL,
  `presu` decimal(12,2) NOT NULL DEFAULT 0.00,
  `deskrisaun` text DEFAULT NULL,
  `especificasaun` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `dealer_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `motor_models`
--

INSERT INTO `motor_models` (`id`, `nama_model`, `marka`, `presu`, `deskrisaun`, `especificasaun`, `foto`, `dealer_id`, `created_at`, `updated_at`) VALUES
(1, 'Honda Beat Deluxe', 'Honda', 1950.00, 'Motor matic irit Honda.', '110cc, CBS, ISS', 'beat.jfif', 1, '2026-05-16 17:46:59', '2026-05-16 17:46:59'),
(2, 'Honda Scoopy', 'Honda', 2100.00, 'Motor matic stylish retro.', '110cc, Keyless, USB Charger', 'scoopy.jfif', 1, '2026-05-16 17:47:00', '2026-05-16 17:47:00'),
(3, 'Honda ADV 160', 'Honda', 3600.00, 'Motor matic adventure premium.', '160cc, HSTC, ABS', 'adv.jfif', 1, '2026-05-16 17:47:00', '2026-05-16 17:47:00'),
(4, 'Honda PCX 160', 'Honda', 3500.00, 'Motor matic besar comfort.', '160cc, ABS, HSTC', 'pcx.jfif', 1, '2026-05-16 17:47:00', '2026-05-16 17:47:00'),
(5, 'Honda Vario 160', 'Honda', 2850.00, 'Motor matic premium Honda 160cc.', '160cc, Keyless, ABS', 'vario.jfif', 2, '2026-05-16 17:47:00', '2026-05-16 17:47:00'),
(6, 'Honda Scoopy', 'Honda', 2100.00, 'Motor matic stylish retro.', '110cc, Keyless, USB Charger', 'scoopy.jfif', 2, '2026-05-16 17:47:00', '2026-05-16 17:47:00'),
(7, 'Honda ADV 160', 'Honda', 3600.00, 'Motor matic adventure premium.', '160cc, HSTC, ABS', 'adv.jfif', 2, '2026-05-16 17:47:00', '2026-05-16 17:47:00'),
(8, 'Honda PCX 160', 'Honda', 3500.00, 'Motor matic besar comfort.', '160cc, ABS, HSTC', 'pcx.jfif', 2, '2026-05-16 17:47:00', '2026-05-16 17:47:00'),
(9, 'Honda Vario 160', 'Honda', 2850.00, 'Motor matic premium Honda 160cc.', '160cc, Keyless, ABS', 'vario.jfif', 3, '2026-05-16 17:47:00', '2026-05-16 17:47:00'),
(10, 'Honda ADV 160', 'Honda', 3600.00, 'Motor matic adventure premium.', '160cc, HSTC, ABS', 'adv.jfif', 3, '2026-05-16 17:47:00', '2026-05-16 17:47:00'),
(11, 'Honda CRF150L', 'Honda', 3200.00, 'Motor on-off road handal.', '150cc, Injeksi, Upside Down', 'crf.jfif', 3, '2026-05-16 17:47:00', '2026-05-16 17:47:00'),
(12, 'Honda PCX 160', 'Honda', 3500.00, 'Motor matic besar comfort.', '160cc, ABS, HSTC', 'pcx.jfif', 3, '2026-05-16 17:47:00', '2026-05-16 17:47:00'),
(13, 'Honda Beat Deluxe', 'Honda', 1950.00, 'Motor matic irit Honda.', '110cc, CBS, ISS', 'beat.jfif', 4, '2026-05-16 17:47:00', '2026-05-16 17:47:00'),
(14, 'Honda CRF150L', 'Honda', 3200.00, 'Motor on-off road handal.', '150cc, Injeksi, Upside Down', 'crf.jfif', 4, '2026-05-16 17:47:00', '2026-05-16 17:47:00'),
(15, 'Honda PCX 160', 'Honda', 3500.00, 'Motor matic besar comfort.', '160cc, ABS, HSTC', 'pcx.jfif', 4, '2026-05-16 17:47:00', '2026-05-16 17:47:00'),
(16, 'Honda CBR150R', 'Honda', 3800.00, 'Motor sport fairing Honda.', '150cc, DOHC, 6-Speed', 'cbr150.jfif', 4, '2026-05-16 17:47:00', '2026-05-16 17:47:00'),
(17, 'Honda Vario 160', 'Honda', 2850.00, 'Motor matic premium Honda 160cc.', '160cc, Keyless, ABS', 'vario.jfif', 5, '2026-05-16 17:47:00', '2026-05-16 17:47:00'),
(18, 'Honda Scoopy', 'Honda', 2100.00, 'Motor matic stylish retro.', '110cc, Keyless, USB Charger', 'scoopy.jfif', 5, '2026-05-16 17:47:00', '2026-05-16 17:47:00'),
(19, 'Honda CRF150L', 'Honda', 3200.00, 'Motor on-off road handal.', '150cc, Injeksi, Upside Down', 'crf.jfif', 5, '2026-05-16 17:47:00', '2026-05-16 17:47:00'),
(20, 'Honda CBR150R', 'Honda', 3800.00, 'Motor sport fairing Honda.', '150cc, DOHC, 6-Speed', 'cbr150.jfif', 5, '2026-05-16 17:47:00', '2026-05-16 17:47:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'admin', '$2y$10$wW58PsYNiirSWZJzMMjXIuJYuwQdBmeG1vz.G9YlBAsFIJaTnXWQ2', '2026-04-19 02:09:02'),
(2, 'Lucas', '$2y$10$sEMLu5hfJfyYDmONzMt3UO7SpRxMaLQbM5RjUTVEbBmFbNSxirT1a', '2026-05-19 05:43:55');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dealer_motor`
--
ALTER TABLE `dealer_motor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `motor_models`
--
ALTER TABLE `motor_models`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dealer_id` (`dealer_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dealer_motor`
--
ALTER TABLE `dealer_motor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `motor_models`
--
ALTER TABLE `motor_models`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `motor_models`
--
ALTER TABLE `motor_models`
  ADD CONSTRAINT `motor_models_ibfk_1` FOREIGN KEY (`dealer_id`) REFERENCES `dealer_motor` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
