-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 24, 2025 at 12:30 PM
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
-- Database: `quick_line`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_menus`
--

CREATE TABLE `admin_menus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `menu_name` varchar(255) NOT NULL,
  `request` varchar(255) DEFAULT NULL,
  `icon` varchar(255) NOT NULL,
  `route` varchar(255) NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT 0,
  `menu_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_menus`
--

INSERT INTO `admin_menus` (`id`, `menu_name`, `request`, `icon`, `route`, `parent_id`, `menu_order`, `created_at`, `updated_at`) VALUES
(1, 'Dashboard', 'admin/dashboard', 'fa-tachometer-alt', 'admin.dashboard', 0, 0, NULL, NULL),
(2, 'Centres', NULL, 'fa-flask', '#', 0, 0, NULL, NULL),
(3, 'Add New Centre', 'admin/add-laboratory', 'fa-file-import', 'admin.addLab', 2, 1, NULL, NULL),
(4, 'View Centre', 'admin/view-laboratory', 'fa-list-alt', 'admin.viewLab', 2, 2, NULL, NULL),
(5, 'Users', NULL, 'fa-user', '#', 0, 0, NULL, NULL),
(6, 'Add New Users', 'admin/add-user', 'fa-file-import', 'admin.addUser', 5, 1, NULL, NULL),
(7, 'View Users', 'admin/view-users', 'fa-list-alt', 'admin.viewUser', 5, 2, NULL, NULL),
(8, 'Doctors', NULL, 'fa-user-md', '#', 0, 0, NULL, NULL),
(9, 'Add Doctor', 'admin/add-doctor', 'fa-file-import', 'admin.addDoctor', 8, 1, '2024-11-06 18:07:15', '2024-11-06 18:07:15'),
(10, 'View Doctor', 'admin/view-doctor', 'fa-list-alt', 'admin.viewDoctor', 8, 2, '2024-11-03 17:44:17', '2024-11-03 17:44:17'),
(11, 'Case Studies', 'admin/view-case-study', 'fa-notes-medical', 'admin.viewCaseStudy', 0, 0, '2025-02-08 12:55:26', '2025-02-08 12:55:26'),
(12, 'Study Layouts', NULL, 'fa-file-pdf', '#', 0, 0, NULL, NULL),
(13, 'Add Study Layout', 'admin/add-study-layout', 'fa-file-import', 'admin.addStudyLayout', 12, 1, '2024-11-06 18:07:15', '2024-11-06 18:07:15'),
(14, 'View Study Layouts', 'admin/view-study-layout', 'fa-list-alt', 'admin.viewStudyLayout', 12, 2, '2024-11-03 17:44:17', '2024-11-03 17:44:17');

-- --------------------------------------------------------

--
-- Table structure for table `admin_menu_roles`
--

CREATE TABLE `admin_menu_roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `admin_menu_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `menu_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_menu_roles`
--

INSERT INTO `admin_menu_roles` (`id`, `admin_menu_id`, `role_id`, `menu_order`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, '2024-11-03 17:44:17', '2024-11-03 17:44:17'),
(2, 2, 1, 4, '2024-11-03 17:44:17', '2024-11-03 17:44:17'),
(3, 5, 1, 6, '2024-11-03 17:44:17', '2024-11-03 17:44:17'),
(4, 1, 3, 1, '2024-11-03 17:44:17', '2024-11-03 17:44:17'),
(5, 1, 4, 1, '2024-11-03 17:44:17', '2024-11-03 17:44:17'),
(6, 1, 2, 1, '2024-11-03 17:44:17', '2024-11-03 17:44:17'),
(7, 1, 5, 1, '2024-11-03 17:44:17', '2024-11-03 17:44:17'),
(8, 2, 5, 2, '2024-11-03 17:44:17', '2024-11-03 17:44:17'),
(9, 5, 5, 4, '2024-11-03 17:44:17', '2024-11-03 17:44:17'),
(10, 8, 1, 5, '2024-11-06 18:07:15', '2024-11-06 18:07:15'),
(11, 8, 5, 3, '2024-11-13 18:32:42', '2024-11-13 18:32:42'),
(12, 1, 6, 1, '2024-11-03 17:44:17', '2024-11-03 17:44:17'),
(13, 11, 1, 2, NULL, NULL),
(14, 11, 5, 5, NULL, NULL),
(15, 11, 6, 2, NULL, NULL),
(16, 12, 1, 3, NULL, NULL),
(17, 12, 5, 6, NULL, NULL),
(18, 12, 6, 5, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `case_studies`
--

CREATE TABLE `case_studies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `laboratory_id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `doctor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `qc_id` bigint(20) UNSIGNED DEFAULT NULL,
  `assigner_id` bigint(20) UNSIGNED DEFAULT NULL,
  `clinical_history` text DEFAULT NULL,
  `is_emergency` smallint(6) NOT NULL DEFAULT 0,
  `is_post_operative` smallint(6) NOT NULL DEFAULT 0,
  `is_follow_up` smallint(6) NOT NULL DEFAULT 0,
  `is_subspecialty` smallint(6) NOT NULL DEFAULT 0,
  `is_callback` smallint(6) NOT NULL DEFAULT 0,
  `study_status_id` bigint(20) UNSIGNED NOT NULL,
  `status_updated_on` datetime NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `case_study_id` varchar(255) NOT NULL,
  `modality_id` bigint(20) UNSIGNED NOT NULL,
  `added_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `case_studies`
--

INSERT INTO `case_studies` (`id`, `laboratory_id`, `patient_id`, `doctor_id`, `qc_id`, `assigner_id`, `clinical_history`, `is_emergency`, `is_post_operative`, `is_follow_up`, `is_subspecialty`, `is_callback`, `study_status_id`, `status_updated_on`, `created_at`, `updated_at`, `case_study_id`, `modality_id`, `added_by`) VALUES
(1, 1, 24, NULL, NULL, 4, 'Low BP', 1, 0, 0, 0, 0, 1, '2025-03-16 13:17:03', '2025-03-10 04:59:04', '2025-03-23 12:39:27', 'QL-CS-378277', 1, 1),
(2, 1, 25, 8, NULL, 1, 'BP', 0, 0, 1, 0, 0, 5, '2025-03-15 17:52:11', '2025-03-15 12:11:33', '2025-03-16 06:18:23', 'QL-CS-891287', 1, 1),
(3, 7, 26, 33, NULL, 4, 'Test', 1, 0, 0, 0, 0, 2, '2025-03-23 17:59:51', '2025-03-23 12:26:59', '2025-03-23 12:29:51', 'QL-CS-873059', 1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`id`, `name`, `email`, `phone_number`, `user_id`, `status`, `created_at`, `updated_at`) VALUES
(4, 'Rajib Biswas.', 'rbiswas@gmail.com', '9632-596-326', 11, '1', '2024-11-11 04:59:24', '2024-11-17 19:50:27'),
(7, 'Dipankar Bannerjee', 'drbannerjee@gmail.com', '9635-489-635', 14, '1', '2024-11-11 06:00:04', '2024-11-17 19:54:08'),
(8, 'Aapto Biswas', 'aapto@gmail.com', '9658-789-655', 16, '1', '2024-12-02 17:03:53', '2025-02-08 19:02:09'),
(9, 'Colt Connelly', 'mlang@gmail.com', '+15029639344', 17, '1', '2024-12-02 17:32:02', '2024-12-02 17:32:02'),
(10, 'Rhett Hansen', 'stamm.hassie@bins.org', '1-480-206-5262', 18, '1', '2024-12-02 17:32:03', '2024-12-02 17:32:03'),
(11, 'Tate Considine', 'emory77@hotmail.com', '516.255.9883', 19, '1', '2024-12-02 17:32:03', '2024-12-02 17:32:03'),
(12, 'Mr. Ibrahim Fisher Jr.', 'gussie34@rohan.com', '1-920-301-6888', 20, '1', '2024-12-02 17:32:03', '2024-12-02 17:32:03'),
(13, 'Madyson Conn', 'ykulas@gmail.com', '+1 (856) 425-7080', 21, '1', '2024-12-02 17:32:03', '2024-12-02 17:32:03'),
(14, 'Stone Marvin', 'wiza.kaylin@gmail.com', '+1.228.287.5646', 22, '1', '2024-12-02 17:32:04', '2024-12-02 17:32:04'),
(15, 'Tristin Koch', 'delbert48@reichert.com', '701.455.8097', 23, '1', '2024-12-02 17:32:04', '2024-12-02 17:32:04'),
(16, 'Laverne Runte DDS', 'lela73@mohr.info', '859-677-9038', 24, '1', '2024-12-02 17:32:04', '2024-12-02 17:32:04'),
(17, 'Ms. Emmalee Goodwin II', 'brain32@yahoo.com', '+1.217.213.9802', 25, '1', '2024-12-02 17:32:04', '2024-12-02 17:32:04'),
(18, 'Prof. Andy Schultz MD', 'gkovacek@yahoo.com', '+1 (458) 661-2346', 26, '1', '2024-12-02 17:32:04', '2024-12-02 17:32:04'),
(19, 'Dr. Lorena Hintz', 'dakota.emard@gmail.com', '304-251-9769', 27, '1', '2024-12-02 17:32:05', '2024-12-02 17:32:05'),
(20, 'Prof. Irwin Kozey', 'qreichel@gmail.com', '267.208.2374', 28, '1', '2024-12-02 17:32:05', '2024-12-02 17:32:05'),
(21, 'Margret Muller', 'awill@yahoo.com', '+14454576974', 29, '1', '2024-12-02 17:32:05', '2024-12-02 17:32:05'),
(22, 'Aurelia Flatley', 'hreichel@yahoo.com', '1906-233-717', 30, '1', '2024-12-02 17:32:05', '2025-02-08 19:01:56'),
(23, 'Mrs. Lilian Miller Sr.', 'twhite@oreilly.org', '(872) 254-3236', 31, '1', '2024-12-02 17:32:05', '2024-12-02 17:32:05'),
(24, 'Chyna Erdman', 'cooper.reynolds@gmail.com', '414.254.5116', 32, '1', '2024-12-02 17:32:06', '2024-12-02 17:32:06'),
(25, 'Janiya Ullrich', 'conn.eino@zulauf.com', '+1-870-292-6370', 33, '1', '2024-12-02 17:32:06', '2024-12-02 17:32:06'),
(26, 'Celestine Rice', 'kiehn.johathan@muller.com', '+1 (951) 385-3495', 34, '1', '2024-12-02 17:32:06', '2024-12-02 17:32:06'),
(27, 'Mr. Jovanny Stokes II', 'vswift@greenholt.info', '(838) 342-6211', 35, '1', '2024-12-02 17:32:06', '2024-12-02 17:32:06'),
(28, 'Cassandra Gislason', 'gladys93@mccullough.com', '+1 (469) 360-8317', 36, '1', '2024-12-02 17:32:07', '2024-12-02 17:32:07'),
(29, 'Maynard Stiedemann V', 'kuhn.lincoln@fadel.biz', '534-417-0782', 37, '1', '2024-12-02 17:32:07', '2024-12-02 17:32:07'),
(30, 'Neil Reichel', 'hdurgan@gmail.com', '(430) 863-8253', 38, '1', '2024-12-02 17:32:07', '2024-12-02 17:32:07'),
(31, 'Dangelo Jerde DDS', 'hkuvalis@koch.com', '1-531-683-4279', 39, '1', '2024-12-02 17:32:07', '2024-12-02 17:44:59'),
(32, 'Eldora Towne', 'darby18@blick.biz', '(484) 367-0970', 40, '1', '2024-12-02 17:32:07', '2024-12-02 17:32:07'),
(33, 'Chelsea Torp', 'lera.balistreri@conroy.net', '+1-910-913-6327', 41, '1', '2024-12-02 17:32:08', '2024-12-02 17:32:08'),
(34, 'Billie Schiller', 'walsh.fae@little.net', '1-618-679-4075', 42, '1', '2024-12-02 17:32:08', '2024-12-02 17:32:08'),
(35, 'Mia Pouros', 'ledner.breana@price.com', '872-446-6256', 43, '1', '2024-12-02 17:32:08', '2024-12-02 17:32:08'),
(36, 'Lucy Heathcote MD', 'roma45@moore.com', '530.470.6818', 44, '1', '2024-12-02 17:32:08', '2024-12-02 17:32:08'),
(37, 'Jayda Legros', 'kris98@leffler.biz', '(818) 502-8658', 45, '1', '2024-12-02 17:32:08', '2024-12-02 17:32:08'),
(38, 'Dr. Vito Parker', 'marcel.johns@nader.com', '+1-870-932-7175', 46, '1', '2024-12-02 17:32:09', '2024-12-02 17:32:09'),
(39, 'Maxine Mann', 'streich.paris@king.org', '+18658220318', 47, '1', '2024-12-02 17:32:09', '2024-12-02 17:32:09'),
(40, 'Dr. Simeon Cummings MD', 'yschimmel@paucek.biz', '(347) 605-6982', 48, '1', '2024-12-02 17:32:09', '2024-12-02 17:32:09'),
(41, 'Miss Cortney Barrows V', 'queen.lesch@walker.com', '(978) 653-9692', 49, '1', '2024-12-02 17:32:09', '2024-12-02 17:32:09'),
(42, 'Dr. Meredith Adams V', 'bvon@carroll.biz', '+1-910-998-9352', 50, '1', '2024-12-02 17:32:09', '2024-12-02 17:32:09'),
(43, 'Leonel Hirthe', 'conn.daisy@kuvalis.com', '+17324144816', 51, '1', '2024-12-02 17:32:10', '2024-12-02 17:32:10'),
(44, 'Myrtice Bednar', 'dariana.huels@hotmail.com', '985.752.4012', 52, '1', '2024-12-02 17:32:10', '2024-12-02 17:32:10'),
(45, 'Freda Waters', 'krunte@hotmail.com', '(267) 793-7218', 53, '1', '2024-12-02 17:32:10', '2024-12-02 17:32:10'),
(46, 'Rhea Luettgen', 'danielle55@kling.info', '1-347-214-7353', 54, '1', '2024-12-02 17:32:10', '2024-12-02 17:32:10'),
(47, 'Lolita Rath', 'daron.morar@mayert.biz', '+1-731-764-2859', 55, '1', '2024-12-02 17:32:11', '2024-12-02 17:32:11'),
(48, 'Christian Stamm', 'alfreda54@wiza.net', '+1 (586) 325-6359', 56, '1', '2024-12-02 17:32:11', '2024-12-02 17:32:11'),
(49, 'Dennis Wehner PhD', 'jamaal.konopelski@strosin.com', '+1-856-672-9353', 57, '1', '2024-12-02 17:32:11', '2024-12-02 17:32:11'),
(50, 'Katelyn Streich II', 'reta57@gmail.com', '541.350.8364', 58, '1', '2024-12-02 17:32:11', '2024-12-02 17:32:11'),
(51, 'Vallie Simonis', 'alfonzo.mclaughlin@gmail.com', '341-525-9913', 59, '1', '2024-12-02 17:32:11', '2024-12-02 17:32:11'),
(52, 'Mr. Ali Schmidt', 'dstanton@hotmail.com', '+12766873620', 60, '1', '2024-12-02 17:32:12', '2024-12-02 17:32:12'),
(53, 'Jordon Lind', 'vernie.wehner@stoltenberg.com', '+1-212-831-8256', 61, '1', '2024-12-02 17:32:12', '2024-12-02 17:32:12'),
(54, 'Flo Hauck', 'skuphal@hotmail.com', '1-843-593-7167', 62, '1', '2024-12-02 17:32:12', '2024-12-02 17:32:12'),
(55, 'Keaton Parisian V', 'runte.elyse@yahoo.com', '+1-262-300-3574', 63, '1', '2024-12-02 17:32:12', '2024-12-02 17:32:12'),
(56, 'Orion Beer', 'doyle.jewell@koch.com', '+1-469-843-2227', 64, '1', '2024-12-02 17:32:12', '2024-12-02 17:32:12'),
(57, 'Mr. Steve Hane', 'kessler.amina@considine.com', '+1 (808) 688-8649', 65, '1', '2024-12-02 17:32:13', '2024-12-02 17:32:13'),
(58, 'Samson Hane IV', 'nicolas.berry@hotmail.com', '(715) 813-1322', 66, '1', '2024-12-02 17:32:13', '2024-12-02 17:32:13');

-- --------------------------------------------------------

--
-- Table structure for table `doctor_logs`
--

CREATE TABLE `doctor_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('add','update','delete','active','inactive') NOT NULL DEFAULT 'add',
  `doctor_id` bigint(20) UNSIGNED NOT NULL,
  `log` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `column_name` varchar(255) DEFAULT NULL,
  `old_value` varchar(255) DEFAULT NULL,
  `new_value` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `doctor_logs`
--

INSERT INTO `doctor_logs` (`id`, `type`, `doctor_id`, `log`, `user_id`, `column_name`, `old_value`, `new_value`, `created_at`, `updated_at`) VALUES
(1, 'add', 7, 'New Doctor added by Pranab Karmakar on 11th of Nov, 2024 at 11:30 AM', 1, NULL, NULL, NULL, '2024-11-11 06:00:04', '2024-11-11 06:00:04'),
(2, 'add', 4, 'New Doctor added by Pranab Karmakar on 11th of Nov, 2024 at 11:30 AM', 1, NULL, NULL, NULL, '2024-11-11 06:00:04', '2024-11-11 06:00:04'),
(3, 'update', 4, 'Modality was updated from \'Radiology, Cardiology, Veterinary\' to \'Radiology, Cardiology, Uromatric, Veterinary\' by John Doe on 16th of Nov, 2024 at 11:52 PM', 7, 'Modality', 'Radiology, Cardiology, Veterinary', 'Radiology, Cardiology, Uromatric, Veterinary', '2024-11-16 18:22:57', '2024-11-16 18:22:57'),
(4, 'update', 4, 'Qualification was updated from \'N/A\' to \'M.B.B.S\' by John Doe on 16th of Nov, 2024 at 11:52 PM', 7, 'qualification', 'N/A', 'M.B.B.S', '2024-11-16 18:22:57', '2024-11-16 18:22:57'),
(5, 'update', 4, 'Description was updated from \'This is the Description of Dr Rajib Biswas.\' to \'This is the Description of Dr Rajib Biswas, Edited\' by John Doe on 16th of Nov, 2024 at 11:52 PM', 7, 'description', 'This is the Description of Dr Rajib Biswas.', 'This is the Description of Dr Rajib Biswas, Edited', '2024-11-16 18:22:57', '2024-11-16 18:22:57'),
(6, 'update', 4, 'Modality was updated from \'Radiology, Uromatric, Cardiology, Veterinary\' to \'Radiology\' by John Doe on 16th of Nov, 2024 at 11:54 PM', 7, 'Modality', 'Radiology, Uromatric, Cardiology, Veterinary', 'Radiology', '2024-11-16 18:24:10', '2024-11-16 18:24:10'),
(7, 'update', 7, 'Qualification was updated from \'M.B.B.S\' to \'M.B.B.S, F.R.C.S\' by John Doe on 16th of Nov, 2024 at 11:54 PM', 7, 'qualification', 'M.B.B.S', 'M.B.B.S, F.R.C.S', '2024-11-16 18:24:36', '2024-11-16 18:24:36'),
(8, 'inactive', 7, 'The Doctor, Dipankar Bannerjee was Disable by John Doe on 18th of Nov, 2024 at 1:17 AM', 7, NULL, NULL, NULL, '2024-11-17 19:47:44', '2024-11-17 19:47:44'),
(9, 'inactive', 4, 'The Doctor, Rajib Biswas. was Disable by John Doe on 18th of Nov, 2024 at 1:18 AM', 7, NULL, NULL, NULL, '2024-11-17 19:48:59', '2024-11-17 19:48:59'),
(10, 'active', 7, 'The Doctor, Dipankar Bannerjee was Active by John Doe on 18th of Nov, 2024 at 1:20 AM', 7, NULL, NULL, NULL, '2024-11-17 19:50:24', '2024-11-17 19:50:24'),
(11, 'active', 4, 'The Doctor, Rajib Biswas. was Active by John Doe on 18th of Nov, 2024 at 1:20 AM', 7, NULL, NULL, NULL, '2024-11-17 19:50:27', '2024-11-17 19:50:27'),
(12, 'inactive', 7, 'The Doctor, Dipankar Bannerjee was Disable by John Doe on 18th of Nov, 2024 at 1:21 AM', 7, NULL, NULL, NULL, '2024-11-17 19:51:17', '2024-11-17 19:51:17'),
(13, 'add', 8, 'New Doctor added by Pranab Karmakar on 2nd of Dec, 2024 at 10:33 PM', 1, NULL, NULL, NULL, '2024-12-02 17:03:53', '2024-12-02 17:03:53'),
(14, 'inactive', 31, 'The Doctor, Dangelo Jerde DDS was Disable by Pranab Karmakar on 2nd of Dec, 2024 at 11:14 PM', 1, NULL, NULL, NULL, '2024-12-02 17:44:55', '2024-12-02 17:44:55'),
(15, 'active', 31, 'The Doctor, Dangelo Jerde DDS was Active by Pranab Karmakar on 2nd of Dec, 2024 at 11:14 PM', 1, NULL, NULL, NULL, '2024-12-02 17:44:59', '2024-12-02 17:44:59'),
(16, 'update', 22, 'Phone Number was updated from \'+1 (906) 233-7179\' to \'1906-233-717\' by Pranab Karmakar on 9th of Feb, 2025 at 12:31 AM', 1, 'Phone Number', '+1 (906) 233-7179', '1906-233-717', '2025-02-08 19:01:56', '2025-02-08 19:01:56'),
(17, 'update', 22, 'Modality was updated from \'Radiology, Neurology, Cardiology\' to \'Radiology, Cardiology\' by Pranab Karmakar on 9th of Feb, 2025 at 12:31 AM', 1, 'Modality', 'Radiology, Neurology, Cardiology', 'Radiology, Cardiology', '2025-02-08 19:01:56', '2025-02-08 19:01:56'),
(18, 'update', 8, 'Modality was updated from \'Neurology, Veterinary\' to \'Radiology, Neurology, Veterinary\' by Pranab Karmakar on 9th of Feb, 2025 at 12:32 AM', 1, 'Modality', 'Neurology, Veterinary', 'Radiology, Neurology, Veterinary', '2025-02-08 19:02:09', '2025-02-08 19:02:09');

-- --------------------------------------------------------

--
-- Table structure for table `doctor_modalities`
--

CREATE TABLE `doctor_modalities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `doctor_id` bigint(20) UNSIGNED NOT NULL,
  `modality_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `doctor_modalities`
--

INSERT INTO `doctor_modalities` (`id`, `doctor_id`, `modality_id`, `created_at`, `updated_at`, `status`) VALUES
(1, 4, 1, '2024-11-11 04:59:24', '2024-11-16 18:24:10', '1'),
(2, 7, 1, '2024-11-11 06:00:04', '2024-11-16 18:24:36', '1'),
(3, 7, 2, '2024-11-11 06:00:04', '2024-11-16 18:24:36', '1'),
(6, 7, 4, '2024-11-14 19:07:47', '2024-11-16 18:24:36', '0'),
(7, 7, 4, '2024-11-14 19:08:29', '2024-11-16 18:24:36', '0'),
(8, 7, 3, '2024-11-16 14:35:52', '2024-11-16 18:24:36', '0'),
(9, 4, 4, '2024-11-16 14:36:04', '2024-11-16 18:24:10', '0'),
(10, 4, 2, '2024-11-16 16:46:52', '2024-11-16 18:24:10', '0'),
(11, 4, 4, '2024-11-16 16:56:52', '2024-11-16 18:24:10', '0'),
(12, 8, 3, '2024-12-02 17:03:53', '2025-02-08 19:02:09', '1'),
(13, 8, 4, '2024-12-02 17:03:53', '2025-02-08 19:02:09', '1'),
(14, 9, 3, '2024-12-02 17:32:02', '2024-12-02 17:32:02', '1'),
(15, 9, 4, '2024-12-02 17:32:02', '2024-12-02 17:32:02', '1'),
(16, 9, 1, '2024-12-02 17:32:02', '2024-12-02 17:32:02', '1'),
(17, 9, 4, '2024-12-02 17:32:02', '2024-12-02 17:32:02', '1'),
(18, 10, 3, '2024-12-02 17:32:03', '2024-12-02 17:32:03', '1'),
(19, 10, 4, '2024-12-02 17:32:03', '2024-12-02 17:32:03', '1'),
(20, 10, 2, '2024-12-02 17:32:03', '2024-12-02 17:32:03', '1'),
(21, 11, 1, '2024-12-02 17:32:03', '2024-12-02 17:32:03', '1'),
(22, 11, 3, '2024-12-02 17:32:03', '2024-12-02 17:32:03', '1'),
(23, 11, 4, '2024-12-02 17:32:03', '2024-12-02 17:32:03', '1'),
(24, 11, 4, '2024-12-02 17:32:03', '2024-12-02 17:32:03', '1'),
(25, 12, 2, '2024-12-02 17:32:03', '2024-12-02 17:32:03', '1'),
(26, 12, 4, '2024-12-02 17:32:03', '2024-12-02 17:32:03', '1'),
(27, 12, 3, '2024-12-02 17:32:03', '2024-12-02 17:32:03', '1'),
(28, 13, 4, '2024-12-02 17:32:03', '2024-12-02 17:32:03', '1'),
(29, 13, 2, '2024-12-02 17:32:03', '2024-12-02 17:32:03', '1'),
(30, 14, 2, '2024-12-02 17:32:04', '2024-12-02 17:32:04', '1'),
(31, 14, 3, '2024-12-02 17:32:04', '2024-12-02 17:32:04', '1'),
(32, 14, 4, '2024-12-02 17:32:04', '2024-12-02 17:32:04', '1'),
(33, 15, 1, '2024-12-02 17:32:04', '2024-12-02 17:32:04', '1'),
(34, 15, 3, '2024-12-02 17:32:04', '2024-12-02 17:32:04', '1'),
(35, 15, 4, '2024-12-02 17:32:04', '2024-12-02 17:32:04', '1'),
(36, 15, 4, '2024-12-02 17:32:04', '2024-12-02 17:32:04', '1'),
(37, 16, 4, '2024-12-02 17:32:04', '2024-12-02 17:32:04', '1'),
(38, 16, 1, '2024-12-02 17:32:04', '2024-12-02 17:32:04', '1'),
(39, 17, 2, '2024-12-02 17:32:04', '2024-12-02 17:32:04', '1'),
(40, 17, 1, '2024-12-02 17:32:04', '2024-12-02 17:32:04', '1'),
(41, 17, 4, '2024-12-02 17:32:04', '2024-12-02 17:32:04', '1'),
(42, 17, 3, '2024-12-02 17:32:04', '2024-12-02 17:32:04', '1'),
(43, 18, 3, '2024-12-02 17:32:04', '2024-12-02 17:32:04', '1'),
(44, 18, 4, '2024-12-02 17:32:04', '2024-12-02 17:32:04', '1'),
(45, 19, 1, '2024-12-02 17:32:05', '2024-12-02 17:32:05', '1'),
(46, 19, 4, '2024-12-02 17:32:05', '2024-12-02 17:32:05', '1'),
(47, 19, 4, '2024-12-02 17:32:05', '2024-12-02 17:32:05', '1'),
(48, 20, 4, '2024-12-02 17:32:05', '2024-12-02 17:32:05', '1'),
(49, 20, 2, '2024-12-02 17:32:05', '2024-12-02 17:32:05', '1'),
(50, 20, 3, '2024-12-02 17:32:05', '2024-12-02 17:32:05', '1'),
(51, 21, 4, '2024-12-02 17:32:05', '2024-12-02 17:32:05', '1'),
(52, 21, 2, '2024-12-02 17:32:05', '2024-12-02 17:32:05', '1'),
(53, 21, 1, '2024-12-02 17:32:05', '2024-12-02 17:32:05', '1'),
(54, 22, 1, '2024-12-02 17:32:05', '2025-02-08 19:01:56', '1'),
(55, 22, 3, '2024-12-02 17:32:05', '2025-02-08 19:01:56', '0'),
(56, 22, 2, '2024-12-02 17:32:05', '2025-02-08 19:01:56', '1'),
(57, 23, 4, '2024-12-02 17:32:05', '2024-12-02 17:32:05', '1'),
(58, 23, 4, '2024-12-02 17:32:05', '2024-12-02 17:32:05', '1'),
(59, 23, 1, '2024-12-02 17:32:05', '2024-12-02 17:32:05', '1'),
(60, 24, 2, '2024-12-02 17:32:06', '2024-12-02 17:32:06', '1'),
(61, 24, 1, '2024-12-02 17:32:06', '2024-12-02 17:32:06', '1'),
(62, 24, 3, '2024-12-02 17:32:06', '2024-12-02 17:32:06', '1'),
(63, 24, 4, '2024-12-02 17:32:06', '2024-12-02 17:32:06', '1'),
(64, 25, 1, '2024-12-02 17:32:06', '2024-12-02 17:32:06', '1'),
(65, 25, 3, '2024-12-02 17:32:06', '2024-12-02 17:32:06', '1'),
(66, 26, 4, '2024-12-02 17:32:06', '2024-12-02 17:32:06', '1'),
(67, 26, 3, '2024-12-02 17:32:06', '2024-12-02 17:32:06', '1'),
(68, 27, 4, '2024-12-02 17:32:06', '2024-12-02 17:32:06', '1'),
(69, 27, 3, '2024-12-02 17:32:06', '2024-12-02 17:32:06', '1'),
(70, 27, 1, '2024-12-02 17:32:06', '2024-12-02 17:32:06', '1'),
(71, 28, 1, '2024-12-02 17:32:07', '2024-12-02 17:32:07', '1'),
(72, 28, 4, '2024-12-02 17:32:07', '2024-12-02 17:32:07', '1'),
(73, 28, 5, '2024-12-02 17:32:07', '2024-12-02 17:32:07', '1'),
(74, 29, 4, '2024-12-02 17:32:07', '2024-12-02 17:32:07', '1'),
(75, 29, 2, '2024-12-02 17:32:07', '2024-12-02 17:32:07', '1'),
(76, 29, 3, '2024-12-02 17:32:07', '2024-12-02 17:32:07', '1'),
(77, 29, 1, '2024-12-02 17:32:07', '2024-12-02 17:32:07', '1'),
(78, 30, 2, '2024-12-02 17:32:07', '2024-12-02 17:32:07', '1'),
(79, 30, 3, '2024-12-02 17:32:07', '2024-12-02 17:32:07', '1'),
(80, 31, 4, '2024-12-02 17:32:07', '2024-12-02 17:32:07', '1'),
(81, 31, 2, '2024-12-02 17:32:07', '2024-12-02 17:32:07', '1'),
(82, 31, 1, '2024-12-02 17:32:07', '2024-12-02 17:32:07', '1'),
(83, 31, 3, '2024-12-02 17:32:07', '2024-12-02 17:32:07', '1'),
(84, 32, 2, '2024-12-02 17:32:07', '2024-12-02 17:32:07', '1'),
(85, 32, 1, '2024-12-02 17:32:07', '2024-12-02 17:32:07', '1'),
(86, 32, 4, '2024-12-02 17:32:07', '2024-12-02 17:32:07', '1'),
(87, 33, 4, '2024-12-02 17:32:08', '2024-12-02 17:32:08', '1'),
(88, 33, 2, '2024-12-02 17:32:08', '2024-12-02 17:32:08', '1'),
(89, 33, 1, '2024-12-02 17:32:08', '2024-12-02 17:32:08', '1'),
(90, 34, 4, '2024-12-02 17:32:08', '2024-12-02 17:32:08', '1'),
(91, 34, 2, '2024-12-02 17:32:08', '2024-12-02 17:32:08', '1'),
(92, 34, 1, '2024-12-02 17:32:08', '2024-12-02 17:32:08', '1'),
(93, 35, 3, '2024-12-02 17:32:08', '2024-12-02 17:32:08', '1'),
(94, 35, 4, '2024-12-02 17:32:08', '2024-12-02 17:32:08', '1'),
(95, 35, 4, '2024-12-02 17:32:08', '2024-12-02 17:32:08', '1'),
(96, 35, 1, '2024-12-02 17:32:08', '2024-12-02 17:32:08', '1'),
(97, 36, 4, '2024-12-02 17:32:08', '2024-12-02 17:32:08', '1'),
(98, 36, 2, '2024-12-02 17:32:08', '2024-12-02 17:32:08', '1'),
(99, 36, 4, '2024-12-02 17:32:08', '2024-12-02 17:32:08', '1'),
(100, 36, 3, '2024-12-02 17:32:08', '2024-12-02 17:32:08', '1'),
(101, 37, 3, '2024-12-02 17:32:08', '2024-12-02 17:32:08', '1'),
(102, 37, 1, '2024-12-02 17:32:08', '2024-12-02 17:32:08', '1'),
(103, 37, 2, '2024-12-02 17:32:08', '2024-12-02 17:32:08', '1'),
(104, 37, 4, '2024-12-02 17:32:08', '2024-12-02 17:32:08', '1'),
(105, 38, 1, '2024-12-02 17:32:09', '2024-12-02 17:32:09', '1'),
(106, 38, 4, '2024-12-02 17:32:09', '2024-12-02 17:32:09', '1'),
(107, 39, 2, '2024-12-02 17:32:09', '2024-12-02 17:32:09', '1'),
(108, 39, 3, '2024-12-02 17:32:09', '2024-12-02 17:32:09', '1'),
(109, 39, 1, '2024-12-02 17:32:09', '2024-12-02 17:32:09', '1'),
(110, 40, 1, '2024-12-02 17:32:09', '2024-12-02 17:32:09', '1'),
(111, 40, 4, '2024-12-02 17:32:09', '2024-12-02 17:32:09', '1'),
(112, 41, 4, '2024-12-02 17:32:09', '2024-12-02 17:32:09', '1'),
(113, 41, 1, '2024-12-02 17:32:09', '2024-12-02 17:32:09', '1'),
(114, 41, 4, '2024-12-02 17:32:09', '2024-12-02 17:32:09', '1'),
(115, 41, 2, '2024-12-02 17:32:09', '2024-12-02 17:32:09', '1'),
(116, 42, 1, '2024-12-02 17:32:09', '2024-12-02 17:32:09', '1'),
(117, 42, 3, '2024-12-02 17:32:09', '2024-12-02 17:32:09', '1'),
(118, 43, 1, '2024-12-02 17:32:10', '2024-12-02 17:32:10', '1'),
(119, 43, 3, '2024-12-02 17:32:10', '2024-12-02 17:32:10', '1'),
(120, 43, 4, '2024-12-02 17:32:10', '2024-12-02 17:32:10', '1'),
(121, 44, 4, '2024-12-02 17:32:10', '2024-12-02 17:32:10', '1'),
(122, 44, 3, '2024-12-02 17:32:10', '2024-12-02 17:32:10', '1'),
(123, 45, 4, '2024-12-02 17:32:10', '2024-12-02 17:32:10', '1'),
(124, 45, 4, '2024-12-02 17:32:10', '2024-12-02 17:32:10', '1'),
(125, 46, 1, '2024-12-02 17:32:10', '2024-12-02 17:32:10', '1'),
(126, 46, 2, '2024-12-02 17:32:10', '2024-12-02 17:32:10', '1'),
(127, 47, 1, '2024-12-02 17:32:11', '2024-12-02 17:32:11', '1'),
(128, 47, 4, '2024-12-02 17:32:11', '2024-12-02 17:32:11', '1'),
(129, 48, 4, '2024-12-02 17:32:11', '2024-12-02 17:32:11', '1'),
(130, 48, 4, '2024-12-02 17:32:11', '2024-12-02 17:32:11', '1'),
(131, 48, 2, '2024-12-02 17:32:11', '2024-12-02 17:32:11', '1'),
(132, 48, 1, '2024-12-02 17:32:11', '2024-12-02 17:32:11', '1'),
(133, 49, 4, '2024-12-02 17:32:11', '2024-12-02 17:32:11', '1'),
(134, 49, 1, '2024-12-02 17:32:11', '2024-12-02 17:32:11', '1'),
(135, 49, 3, '2024-12-02 17:32:11', '2024-12-02 17:32:11', '1'),
(136, 50, 4, '2024-12-02 17:32:11', '2024-12-02 17:32:11', '1'),
(137, 50, 2, '2024-12-02 17:32:11', '2024-12-02 17:32:11', '1'),
(138, 50, 4, '2024-12-02 17:32:11', '2024-12-02 17:32:11', '1'),
(139, 51, 3, '2024-12-02 17:32:11', '2024-12-02 17:32:11', '1'),
(140, 51, 4, '2024-12-02 17:32:11', '2024-12-02 17:32:11', '1'),
(141, 52, 4, '2024-12-02 17:32:12', '2024-12-02 17:32:12', '1'),
(142, 52, 3, '2024-12-02 17:32:12', '2024-12-02 17:32:12', '1'),
(143, 53, 3, '2024-12-02 17:32:12', '2024-12-02 17:32:12', '1'),
(144, 53, 2, '2024-12-02 17:32:12', '2024-12-02 17:32:12', '1'),
(145, 53, 4, '2024-12-02 17:32:12', '2024-12-02 17:32:12', '1'),
(146, 54, 1, '2024-12-02 17:32:12', '2024-12-02 17:32:12', '1'),
(147, 54, 2, '2024-12-02 17:32:12', '2024-12-02 17:32:12', '1'),
(148, 54, 3, '2024-12-02 17:32:12', '2024-12-02 17:32:12', '1'),
(149, 55, 2, '2024-12-02 17:32:12', '2024-12-02 17:32:12', '1'),
(150, 55, 1, '2024-12-02 17:32:12', '2024-12-02 17:32:12', '1'),
(151, 55, 4, '2024-12-02 17:32:12', '2024-12-02 17:32:12', '1'),
(152, 55, 3, '2024-12-02 17:32:12', '2024-12-02 17:32:12', '1'),
(153, 56, 4, '2024-12-02 17:32:12', '2024-12-02 17:32:12', '1'),
(154, 56, 4, '2024-12-02 17:32:12', '2024-12-02 17:32:12', '1'),
(155, 56, 2, '2024-12-02 17:32:12', '2024-12-02 17:32:12', '1'),
(156, 57, 4, '2024-12-02 17:32:13', '2024-12-02 17:32:13', '1'),
(157, 57, 4, '2024-12-02 17:32:13', '2024-12-02 17:32:13', '1'),
(158, 57, 3, '2024-12-02 17:32:13', '2024-12-02 17:32:13', '1'),
(159, 57, 2, '2024-12-02 17:32:13', '2024-12-02 17:32:13', '1'),
(160, 58, 4, '2024-12-02 17:32:13', '2024-12-02 17:32:13', '1'),
(161, 58, 3, '2024-12-02 17:32:13', '2024-12-02 17:32:13', '1'),
(162, 58, 2, '2024-12-02 17:32:13', '2024-12-02 17:32:13', '1'),
(163, 58, 1, '2024-12-02 17:32:13', '2024-12-02 17:32:13', '1'),
(164, 8, 1, '2025-02-08 19:02:09', '2025-02-08 19:02:09', '1');

-- --------------------------------------------------------

--
-- Table structure for table `doc_form_field_values`
--

CREATE TABLE `doc_form_field_values` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `form_field_id` bigint(20) UNSIGNED NOT NULL,
  `value` varchar(255) DEFAULT NULL,
  `doctor_id` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `doc_form_field_values`
--

INSERT INTO `doc_form_field_values` (`id`, `form_field_id`, `value`, `doctor_id`, `updated_by`, `created_at`, `updated_at`) VALUES
(2, 11, '9658965478', 4, 7, '2024-11-16 16:47:25', '2024-11-16 17:00:13'),
(3, 10, 'This is the Description of Dr Rajib Biswas, Edited', 4, 7, '2024-11-16 16:49:11', '2024-11-16 18:22:57'),
(4, 9, 'M.B.B.S, F.R.C.S', 7, 7, '2024-11-16 16:56:32', '2024-11-16 18:24:36'),
(5, 10, 'This is a test text', 7, 7, '2024-11-16 16:57:32', '2024-11-16 16:57:32'),
(6, 9, 'M.B.B.S', 4, 7, '2024-11-16 18:22:57', '2024-11-16 18:22:57'),
(7, 9, 'MBBS', 8, 1, '2024-12-02 17:03:53', '2024-12-02 17:03:53');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `form_fields`
--

CREATE TABLE `form_fields` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `field_name` varchar(255) NOT NULL,
  `field_alise` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `required` int(11) NOT NULL DEFAULT 0,
  `element_type` varchar(255) NOT NULL DEFAULT 'text'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `form_fields`
--

INSERT INTO `form_fields` (`id`, `field_name`, `field_alise`, `description`, `required`, `element_type`) VALUES
(1, 'owner_name', 'Owner Name', NULL, 1, 'text'),
(2, 'owner_phone_number', 'Owner Phone Number', NULL, 0, 'phone'),
(3, 'technician_name', 'Technician Name', NULL, 0, 'text'),
(4, 'technician_phone_number', 'Technician Phone Number', NULL, 0, 'phone'),
(5, 'modality_old', 'Modality', NULL, 0, 'multiselect'),
(6, 'account_department_number', 'Accounts Department Phone Number', NULL, 0, 'phone'),
(7, 'installation_date', 'Installation Date', NULL, 0, 'date'),
(8, 'special_suggestion', 'Special Suggestion', NULL, 0, 'textarea'),
(9, 'qualification', 'Qualification', NULL, 0, 'text'),
(10, 'description', 'Description', NULL, 0, 'textarea'),
(11, 'registration_number', 'Registration Number', NULL, 0, 'text');

-- --------------------------------------------------------

--
-- Table structure for table `form_field_options`
--

CREATE TABLE `form_field_options` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `form_field_id` bigint(20) UNSIGNED NOT NULL,
  `option_text` varchar(255) NOT NULL,
  `option_value` varchar(255) DEFAULT NULL,
  `is_selected` smallint(6) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `form_field_options`
--

INSERT INTO `form_field_options` (`id`, `form_field_id`, `option_text`, `option_value`, `is_selected`, `created_at`, `updated_at`) VALUES
(2, 5, 'X-RAY', 'xray', 0, NULL, NULL),
(3, 5, 'CT', 'ct', 0, NULL, NULL),
(4, 5, 'MRI', 'mri', 0, NULL, NULL),
(5, 5, 'ECG', 'ecg', 0, NULL, NULL),
(6, 5, 'TMT', 'tmt', 0, NULL, NULL),
(7, 5, 'EEG', 'eeg', 0, NULL, NULL),
(8, 5, 'HOLTER', 'holter', 0, NULL, NULL),
(9, 5, 'PFT', 'pft', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `form_field_roles`
--

CREATE TABLE `form_field_roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `form_field_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `form_field_roles`
--

INSERT INTO `form_field_roles` (`id`, `role_id`, `form_field_id`) VALUES
(1, 3, 1),
(2, 3, 2),
(3, 3, 3),
(4, 3, 4),
(6, 3, 6),
(7, 3, 7),
(8, 3, 8),
(9, 4, 9),
(10, 4, 11),
(11, 4, 10);

-- --------------------------------------------------------

--
-- Table structure for table `form_field_values`
--

CREATE TABLE `form_field_values` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `form_field_id` bigint(20) UNSIGNED NOT NULL,
  `value` varchar(255) DEFAULT NULL,
  `laboratorie_id` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `laboratories`
--

CREATE TABLE `laboratories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `lab_name` varchar(255) NOT NULL,
  `lab_login_email` varchar(255) NOT NULL,
  `lab_primary_location` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT 1,
  `lab_phone_number` varchar(255) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `laboratories`
--

INSERT INTO `laboratories` (`id`, `lab_name`, `lab_login_email`, `lab_primary_location`, `user_id`, `status`, `lab_phone_number`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Balaji Diagnostic Centre Halisahar Unit 2', 'balajihalisahar@gmail.com', 'Kancharapara', 2, 1, '9896-587-899', NULL, '2024-10-02 17:47:27', '2025-02-24 03:39:53'),
(2, 'Naihati Diagnostics', 'naihati_diagnostics@gmail.com', 'Naihati', 3, 0, '8978-965-880', NULL, '2024-10-05 14:17:09', '2024-11-22 19:16:36'),
(3, 'New Rapoo', 'rapoo@gmail.com', 'Palta', 15, 1, '9632-563-212', NULL, '2024-12-02 17:03:00', '2025-02-09 17:18:49'),
(7, 'Naihati Pathology', 'naihati_pathology@gmail.com', 'Naihati', 70, 1, '9866-563-256', NULL, '2025-02-08 18:46:12', '2025-02-08 18:46:12');

-- --------------------------------------------------------

--
-- Table structure for table `laboratory_logs`
--

CREATE TABLE `laboratory_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('add','update','delete','active','inactive') NOT NULL DEFAULT 'add',
  `laboratorie_id` bigint(20) UNSIGNED NOT NULL,
  `log` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `column_name` varchar(255) DEFAULT NULL,
  `old_value` varchar(255) DEFAULT NULL,
  `new_value` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `laboratory_logs`
--

INSERT INTO `laboratory_logs` (`id`, `type`, `laboratorie_id`, `log`, `user_id`, `column_name`, `old_value`, `new_value`, `created_at`, `updated_at`) VALUES
(1, 'add', 1, 'New Centre, Balaji Diagnostic Centre Halisahar added by Pranab Karmakar on 2nd of Oct, 2024 at 11:17 PM', 1, NULL, NULL, NULL, '2024-09-20 17:47:27', '2024-10-02 17:47:27'),
(2, 'update', 1, 'Centre Name was updated from \'Balaji Diagnostic Centre Halisahar\' to \'Balaji Diagnostic Centre Halisahar Unit 2 by Pranab Karmakar on 3rd of Oct, 2024 at 12:34 AM', 1, 'Centre Name', 'Balaji Diagnostic Centre Halisahar', 'Balaji Diagnostic Centre Halisahar Unit 2', '2024-10-02 19:04:05', '2024-10-02 19:04:05'),
(3, 'update', 1, 'Centre Location was updated from \'Halisahar\' to \'Kancharapara by Pranab Karmakar on 3rd of Oct, 2024 at 12:36 AM', 1, 'Centre Location', 'Halisahar', 'Kancharapara', '2024-10-02 19:06:04', '2024-10-02 19:06:04'),
(4, 'update', 1, 'special_suggestion was updated from \'This is some test suggestion 2\' to \'This is some test suggestion for Balaji by Pranab Karmakar on 3rd of Oct, 2024 at 12:50 AM', 1, 'special_suggestion', 'This is some test suggestion 2', 'This is some test suggestion for Balaji', '2024-10-02 19:20:40', '2024-10-02 19:20:40'),
(5, 'update', 1, 'installation_date was updated from \'N/A\' to \'03/10/2024\' by Pranab Karmakar on 3rd of Oct, 2024 at 12:51 AM', 1, 'installation_date', 'N/A', '03/10/2024', '2024-10-02 19:21:46', '2024-10-02 19:21:46'),
(6, 'update', 1, 'Centre Location was updated from \'Kancharapara\' to \'Halisahar\' by Pranab Karmakar on 3rd of Oct, 2024 at 12:52 AM', 1, 'Centre Location', 'Kancharapara', 'Halisahar', '2024-10-02 19:22:48', '2024-10-02 19:22:48'),
(7, 'update', 1, 'Centre Phone Number was updated from \'9896-587-896\' to \'9896-587-897\' by Pranab Karmakar on 3rd of Oct, 2024 at 12:52 AM', 1, 'Centre Phon Number', '9896-587-896', '9896-587-897', '2024-10-02 19:22:48', '2024-10-02 19:22:48'),
(8, 'update', 1, 'owner_phone_number was updated from \'9685-632-566\' to \'9685-632-567\' by Pranab Karmakar on 3rd of Oct, 2024 at 12:52 AM', 1, 'owner_phone_number', '9685-632-566', '9685-632-567', '2024-10-02 19:22:49', '2024-10-02 19:22:49'),
(9, 'update', 1, 'technician_phone_number was updated from \'7896-589-654\' to \'7896-589-657\' by Pranab Karmakar on 3rd of Oct, 2024 at 12:52 AM', 1, 'technician_phone_number', '7896-589-654', '7896-589-657', '2024-10-02 19:22:49', '2024-10-02 19:22:49'),
(10, 'update', 1, 'account_department_number was updated from \'7452-369-856\' to \'7452-369-857\' by Pranab Karmakar on 3rd of Oct, 2024 at 12:52 AM', 1, 'account_department_number', '7452-369-856', '7452-369-857', '2024-10-02 19:22:49', '2024-10-02 19:22:49'),
(11, 'update', 1, 'installation_date was updated from \'03/10/2024\' to \'01/10/2024\' by Pranab Karmakar on 3rd of Oct, 2024 at 12:52 AM', 1, 'installation_date', '03/10/2024', '01/10/2024', '2024-10-02 19:22:49', '2024-10-02 19:22:49'),
(12, 'update', 1, 'Centre Location was updated from \'Halisahar\' to \'Kancharapara\' by Pranab Karmakar on 5th of Oct, 2024 at 7:39 PM', 1, 'Centre Location', 'Halisahar', 'Kancharapara', '2024-10-05 14:09:59', '2024-10-05 14:09:59'),
(13, 'add', 2, 'New Centre added by Pranab Karmakar on 5th of Oct, 2024 at 7:47 PM', 1, NULL, NULL, NULL, '2024-10-05 14:17:09', '2024-10-05 14:17:09'),
(14, 'update', 2, 'owner_phone_number was updated from \'N/A\' to \'5847-895-658\' by Pranab Karmakar on 5th of Oct, 2024 at 7:48 PM', 1, 'owner_phone_number', 'N/A', '5847-895-658', '2024-10-05 14:18:02', '2024-10-05 14:18:02'),
(15, 'update', 2, 'technician_name was updated from \'N/A\' to \'Rahul Roy\' by Pranab Karmakar on 5th of Oct, 2024 at 8:36 PM', 1, 'technician_name', 'N/A', 'Rahul Roy', '2024-10-05 15:06:42', '2024-10-05 15:06:42'),
(16, 'update', 2, 'technician_phone_number was updated from \'N/A\' to \'4545-565-896\' by Pranab Karmakar on 5th of Oct, 2024 at 9:24 PM', 1, 'technician_phone_number', 'N/A', '4545-565-896', '2024-10-05 15:54:07', '2024-10-05 15:54:07'),
(17, 'update', 2, 'Account_department_number was updated from \'N/A\' to \'9896-589-658\' by Pranab Karmakar on 5th of Oct, 2024 at 9:32 PM', 1, 'account_department_number', 'N/A', '9896-589-658', '2024-10-05 16:02:21', '2024-10-05 16:02:21'),
(18, 'update', 2, 'Technician_name was updated from \'Rahul Roy\' to \'Rahul Das\' by Pranab Karmakar on 5th of Oct, 2024 at 9:36 PM', 1, 'technician_name', 'Rahul Roy', 'Rahul Das', '2024-10-05 16:06:07', '2024-10-05 16:06:07'),
(19, 'update', 2, 'Special_suggestion was updated from \'N/A\' to \'Provide report ASAP\' by Pranab Karmakar on 6th of Oct, 2024 at 12:24 AM', 1, 'special_suggestion', 'N/A', 'Provide report ASAP', '2024-10-05 18:54:07', '2024-10-05 18:54:07'),
(20, 'update', 2, 'Centre Phone Number was updated from \'8978-965-874\' to \'8978-965-880\' by Pranab Karmakar on 6th of Oct, 2024 at 12:33 AM', 1, 'Centre Phon Number', '8978-965-874', '8978-965-880', '2024-10-05 19:03:24', '2024-10-05 19:03:24'),
(21, 'add', 1, 'New Document added by Pranab Karmakar on 6th of Oct, 2024 at 1:48 AM', 1, NULL, NULL, NULL, '2024-10-05 20:18:55', '2024-10-05 20:18:55'),
(22, 'add', 1, 'New Document added by Pranab Karmakar on 6th of Oct, 2024 at 1:49 AM', 1, NULL, NULL, NULL, '2024-10-05 20:19:07', '2024-10-05 20:19:07'),
(23, 'add', 1, 'New Document, Epic Card added by Pranab Karmakar on 6th of Oct, 2024 at 1:52 AM', 1, NULL, NULL, NULL, '2024-10-05 20:22:51', '2024-10-05 20:22:51'),
(24, 'add', 1, 'New Document, Admin Card added by Pranab Karmakar on 6th of Oct, 2024 at 1:54 AM', 1, NULL, NULL, NULL, '2024-10-05 20:24:32', '2024-10-05 20:24:32'),
(25, 'update', 1, 'Special_suggestion was updated from \'This is some test suggestion for Balaji\' to \'This is some test suggestion for Balaji 2\' by Pranab Karmakar on 6th of Oct, 2024 at 10:49 PM', 1, 'special_suggestion', 'This is some test suggestion for Balaji', 'This is some test suggestion for Balaji 2', '2024-10-06 17:19:18', '2024-10-06 17:19:18'),
(26, 'add', 1, 'New Document, Driving Licence added by Pranab Karmakar on 19th of Oct, 2024 at 10:43 PM', 1, NULL, NULL, NULL, '2024-10-19 17:13:32', '2024-10-19 17:13:32'),
(27, 'add', 1, 'New Document, DL New Format added by Pranab Karmakar on 20th of Oct, 2024 at 1:36 PM', 1, NULL, NULL, NULL, '2024-10-20 08:06:35', '2024-10-20 08:06:35'),
(28, 'active', 1, 'The Centre, Balaji Diagnostic Centre Halisahar Unit 2 was Active by Pranab Karmakar on 20th of Oct, 2024 at 1:56 PM', 1, NULL, NULL, NULL, '2024-10-20 08:26:08', '2024-10-20 08:26:08'),
(29, 'inactive', 1, 'The Centre, Balaji Diagnostic Centre Halisahar Unit 2 was Disable by Pranab Karmakar on 20th of Oct, 2024 at 2:05 PM', 1, NULL, NULL, NULL, '2024-10-20 08:35:24', '2024-10-20 08:35:24'),
(30, 'active', 1, 'The Centre, Balaji Diagnostic Centre Halisahar Unit 2 was Active by Pranab Karmakar on 20th of Oct, 2024 at 2:15 PM', 1, NULL, NULL, NULL, '2024-10-20 08:45:57', '2024-10-20 08:45:57'),
(31, 'inactive', 2, 'The Centre, Naihati Diagnostics was Disable by Pranab Karmakar on 20th of Oct, 2024 at 2:20 PM', 1, NULL, NULL, NULL, '2024-10-20 08:50:05', '2024-10-20 08:50:05'),
(32, 'active', 2, 'The Centre, Naihati Diagnostics was Active by Pranab Karmakar on 20th of Oct, 2024 at 2:22 PM', 1, NULL, NULL, NULL, '2024-10-20 08:52:21', '2024-10-20 08:52:21'),
(33, 'update', 1, 'Centre Phone Number was updated from \'9896-587-897\' to \'9896-587-898\' by Rohit Saha on 6th of Nov, 2024 at 11:21 AM', 4, 'Centre Phon Number', '9896-587-897', '9896-587-898', '2024-11-06 05:51:30', '2024-11-06 05:51:30'),
(34, 'inactive', 1, 'The Centre, Balaji Diagnostic Centre Halisahar Unit 2 was Disable by Pranab Karmakar on 6th of Nov, 2024 at 12:28 PM', 1, NULL, NULL, NULL, '2024-11-06 06:58:54', '2024-11-06 06:58:54'),
(35, 'active', 1, 'The Centre, Balaji Diagnostic Centre Halisahar Unit 2 was Active by Pranab Karmakar on 13th of Nov, 2024 at 1:00 AM', 1, NULL, NULL, NULL, '2024-11-12 19:30:44', '2024-11-12 19:30:44'),
(36, 'update', 1, 'Centre Phone Number was updated from \'9896-587-898\' to \'9896-587-899\' by John Doe on 18th of Nov, 2024 at 1:10 AM', 7, 'Centre Phon Number', '9896-587-898', '9896-587-899', '2024-11-17 19:40:16', '2024-11-17 19:40:16'),
(37, 'inactive', 2, 'The Centre, Naihati Diagnostics was Disable by Pranab Karmakar on 23rd of Nov, 2024 at 12:32 AM', 1, NULL, NULL, NULL, '2024-11-22 19:02:36', '2024-11-22 19:02:36'),
(38, 'active', 2, 'The Centre, Naihati Diagnostics was Active by Pranab Karmakar on 23rd of Nov, 2024 at 12:34 AM', 1, NULL, NULL, NULL, '2024-11-22 19:04:00', '2024-11-22 19:04:00'),
(39, 'inactive', 2, 'The Centre, Naihati Diagnostics was Disable by Pranab Karmakar on 23rd of Nov, 2024 at 12:46 AM', 1, NULL, NULL, NULL, '2024-11-22 19:16:36', '2024-11-22 19:16:36'),
(40, 'add', 3, 'New Centre added by Pranab Karmakar on 2nd of Dec, 2024 at 10:33 PM', 1, NULL, NULL, NULL, '2024-12-02 17:03:00', '2024-12-02 17:03:00'),
(44, 'add', 7, 'New Centre added by Pranab Karmakar on 9th of Feb, 2025 at 12:16 AM', 1, NULL, NULL, NULL, '2025-02-08 18:46:12', '2025-02-08 18:46:12');

-- --------------------------------------------------------

--
-- Table structure for table `lab_black_listed_doctors`
--

CREATE TABLE `lab_black_listed_doctors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `laboratorie_id` bigint(20) UNSIGNED NOT NULL,
  `doctor_id` bigint(20) UNSIGNED NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lab_black_listed_doctors`
--

INSERT INTO `lab_black_listed_doctors` (`id`, `laboratorie_id`, `doctor_id`, `status`, `created_at`, `updated_at`) VALUES
(13, 1, 8, 0, '2025-03-15 11:16:16', '2025-03-15 11:26:47'),
(14, 1, 22, 0, '2025-03-15 11:16:16', '2025-03-15 11:26:47'),
(15, 1, 34, 0, '2025-03-15 11:16:16', '2025-03-15 11:26:47'),
(16, 1, 26, 0, '2025-03-15 11:22:20', '2025-03-15 11:26:47'),
(17, 1, 33, 0, '2025-03-15 11:22:36', '2025-03-15 11:26:47'),
(18, 1, 48, 0, '2025-03-15 11:22:36', '2025-03-15 11:26:47'),
(19, 1, 9, 0, '2025-03-15 11:22:36', '2025-03-15 11:26:47'),
(20, 1, 7, 0, '2025-03-15 11:22:53', '2025-03-15 11:26:47'),
(21, 1, 4, 0, '2025-03-15 11:25:53', '2025-03-15 11:26:47');

-- --------------------------------------------------------

--
-- Table structure for table `lab_form_field_values`
--

CREATE TABLE `lab_form_field_values` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `form_field_id` bigint(20) UNSIGNED NOT NULL,
  `value` varchar(255) DEFAULT NULL,
  `laboratorie_id` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lab_form_field_values`
--

INSERT INTO `lab_form_field_values` (`id`, `form_field_id`, `value`, `laboratorie_id`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 1, 'Animesh Kundu', 1, 1, '2024-10-02 17:47:27', '2024-10-02 19:17:11'),
(2, 2, '9685-632-567', 1, 1, '2024-10-02 17:47:27', '2024-10-02 19:22:49'),
(3, 3, 'Bimal Pal', 1, 1, '2024-10-02 17:47:27', '2024-10-02 19:17:11'),
(4, 4, '7896-589-657', 1, 1, '2024-10-02 17:47:27', '2024-10-02 19:22:49'),
(5, 6, '7452-369-857', 1, 1, '2024-10-02 17:47:27', '2024-10-02 19:22:49'),
(7, 8, 'This is some test suggestion for Balaji 2', 1, 1, '2024-10-02 17:47:27', '2024-10-06 17:19:18'),
(9, 7, '01/10/2024', 1, 1, '2024-10-02 19:21:46', '2024-10-02 19:22:49'),
(10, 1, 'Mr Anup Rathor', 2, 1, '2024-10-05 14:17:09', '2024-10-05 14:17:09'),
(11, 7, '05/10/2024', 2, 1, '2024-10-05 14:17:09', '2024-10-05 14:17:09'),
(12, 2, '5847-895-658', 2, 1, '2024-10-05 14:18:02', '2024-10-05 14:18:02'),
(13, 3, 'Rahul Das', 2, 1, '2024-10-05 15:06:42', '2024-10-05 16:06:07'),
(14, 4, '4545-565-896', 2, 1, '2024-10-05 15:54:07', '2024-10-05 15:54:07'),
(15, 6, '9896-589-658', 2, 1, '2024-10-05 16:02:21', '2024-10-05 16:02:21'),
(16, 8, 'Provide report ASAP', 2, 1, '2024-10-05 18:54:07', '2024-10-05 18:54:07'),
(17, 1, 'Rishab Panth', 3, 1, '2024-12-02 17:03:00', '2024-12-02 17:03:00'),
(18, 2, '9656-325-458', 3, 1, '2024-12-02 17:03:00', '2024-12-02 17:03:00'),
(19, 7, '02/12/2024', 3, 1, '2024-12-02 17:03:00', '2024-12-02 17:03:00'),
(30, 1, 'P. K. Saha', 7, 1, '2025-02-08 18:46:12', '2025-02-08 18:46:12'),
(31, 7, '09/02/2025', 7, 1, '2025-02-08 18:46:12', '2025-02-08 18:46:12');

-- --------------------------------------------------------

--
-- Table structure for table `lab_modalities`
--

CREATE TABLE `lab_modalities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `laboratory_id` bigint(20) UNSIGNED NOT NULL,
  `modality_id` bigint(20) UNSIGNED NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lab_modalities`
--

INSERT INTO `lab_modalities` (`id`, `laboratory_id`, `modality_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, NULL, '2025-02-24 03:39:53'),
(2, 2, 1, 1, NULL, NULL),
(3, 3, 1, 1, NULL, '2025-02-09 17:18:49'),
(4, 7, 1, 1, '2025-02-08 18:46:12', '2025-02-08 18:46:12'),
(10, 1, 2, 0, '2025-02-09 17:18:11', '2025-02-24 03:39:53'),
(11, 3, 5, 0, '2025-02-09 17:18:40', '2025-02-09 17:18:49');

-- --------------------------------------------------------

--
-- Table structure for table `lab_preferred_doctors`
--

CREATE TABLE `lab_preferred_doctors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `laboratorie_id` bigint(20) UNSIGNED NOT NULL,
  `doctor_id` bigint(20) UNSIGNED NOT NULL,
  `modality_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lab_preferred_doctors`
--

INSERT INTO `lab_preferred_doctors` (`id`, `laboratorie_id`, `doctor_id`, `modality_id`, `created_at`, `updated_at`) VALUES
(1, 7, 48, 2, '2025-03-15 08:49:21', '2025-03-15 08:49:21'),
(2, 7, 26, 3, '2025-03-15 08:49:21', '2025-03-15 08:49:21'),
(6, 1, 49, 4, '2025-03-15 08:49:47', '2025-03-15 08:49:47'),
(7, 1, 28, 5, '2025-03-15 08:49:47', '2025-03-15 08:49:47'),
(12, 1, 24, 3, '2025-03-15 09:06:05', '2025-03-15 09:06:05'),
(13, 1, 31, 1, '2025-03-15 09:06:05', '2025-03-15 09:06:05'),
(14, 3, 34, 2, '2025-03-16 06:01:14', '2025-03-16 06:01:14');

-- --------------------------------------------------------

--
-- Table structure for table `login_securities`
--

CREATE TABLE `login_securities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `google2fa_enable` tinyint(1) NOT NULL DEFAULT 0,
  `google2fa_secret` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `login_securities`
--

INSERT INTO `login_securities` (`id`, `user_id`, `google2fa_enable`, `google2fa_secret`, `created_at`, `updated_at`) VALUES
(1, 1, 0, '5E7QTSEKHSAEPW7Y', '2024-10-20 18:40:55', '2024-10-22 18:11:58'),
(2, 7, 0, '6DPBMIGYLJBHJ6FQ', '2024-11-22 17:22:06', '2024-11-22 17:22:06');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2014_10_12_000000_create_users_table', 2),
(5, '2014_10_12_100000_create_password_reset_tokens_table', 3),
(6, '2014_10_12_200000_add_two_factor_columns_to_users_table', 4),
(7, '2016_06_01_000001_create_oauth_auth_codes_table', 4),
(8, '2016_06_01_000002_create_oauth_access_tokens_table', 4),
(9, '2016_06_01_000003_create_oauth_refresh_tokens_table', 4),
(10, '2016_06_01_000004_create_oauth_clients_table', 4),
(11, '2016_06_01_000005_create_oauth_personal_access_clients_table', 4),
(12, '2019_08_19_000000_create_failed_jobs_table', 5),
(13, '2019_12_14_000001_create_personal_access_tokens_table', 6),
(14, '2023_11_21_050229_alter_users_add_access_type', 6),
(15, '2023_11_26_072623_create_roles_table', 6),
(16, '2023_11_26_072647_create_role_users_table', 6),
(17, '2023_11_26_141543_alter_users_add_user_iamge', 6),
(18, '2024_01_09_033611_alter_users_add_status', 6),
(19, '2024_01_20_152438_create_admin_menus_table', 7),
(20, '2024_01_20_172904_create_admin_menu_roles_table', 7),
(21, '2023_11_26_170809_create_login_securities_table', 8),
(22, '2023_12_09_125118_create_form_fields_table', 9),
(23, '2023_12_10_072903_create_form_field_roles_table', 9),
(24, '2023_12_16_144836_create_laboratories_table', 10),
(25, '2023_12_17_090900_create_lab_form_field_values_table', 11),
(26, '2024_09_29_003717_create_form_field_options_table', 11),
(27, '2024_09_30_174226_alter_laboratories_add_extra_columns', 12),
(29, '2024_10_02_164009_create_laboratory_logs_table', 13),
(30, '2024_01_21_053316_create_user_documents_table', 14),
(31, '2024_11_03_232213_alter_users_add_is_first_login', 15),
(32, '2024_11_07_003815_create_modalities_table', 16),
(33, '2024_11_11_093107_create_doctors_table', 17),
(34, '2024_11_11_092532_create_doctor_modalities_table', 18),
(35, '2024_11_11_101731_doc_form_field_values', 19),
(36, '2024_11_11_111733_create_doctor_logs_table', 20),
(37, '2024_11_16_195748_alter_doctor_modalities_add_status', 21),
(38, '2024_12_29_125048_alter_users_add_is_outsider', 22),
(39, '2025_02_08_232046_create_lab_modalities_table', 23),
(40, '2025_02_10_111646_create_patients_table', 24),
(41, '2025_02_15_181538_create_study_statuses_table', 25),
(42, '2025_02_15_175404_create_case_studies_table', 26),
(44, '2025_02_15_183839_create_study_types_table', 27),
(45, '2025_02_15_175429_create_studies_table', 28),
(46, '2025_02_15_175506_create_study_images_table', 29),
(47, '2025_02_16_002313_alter_case_studies_add_case_id', 30),
(48, '2025_03_08_193146_alter_studies_add_case_study_id', 31),
(49, '2025_03_10_100250_alter_case_studies_add_modality_id', 32),
(50, '2025_03_15_114620_create_lab_preferred_doctors_table', 33),
(52, '2025_03_15_114642_create_lab_black_listed_doctors_table', 34),
(53, '2025_03_18_233954_create_modality_study_layouts_table', 35),
(54, '2025_03_22_113548_alter_case_studies_add_added_by', 36);

-- --------------------------------------------------------

--
-- Table structure for table `modalities`
--

CREATE TABLE `modalities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `modalities`
--

INSERT INTO `modalities` (`id`, `name`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Radiology', NULL, '1', '2024-11-06 19:15:44', '2024-11-06 19:15:44'),
(2, 'Cardiology', NULL, '1', '2024-11-06 19:18:09', '2024-11-06 19:18:09'),
(3, 'Neurology', NULL, '1', '2024-11-06 19:18:49', '2024-11-06 19:18:49'),
(4, 'Uromatric', NULL, '1', '2024-11-06 19:18:49', '2024-11-06 19:18:49'),
(5, 'Veterinary', NULL, '1', '2024-11-03 17:44:17', '2024-11-03 17:44:17');

-- --------------------------------------------------------

--
-- Table structure for table `modality_study_layouts`
--

CREATE TABLE `modality_study_layouts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `study_type_id` bigint(20) UNSIGNED NOT NULL,
  `layout` text NOT NULL,
  `description` text DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `modality_study_layouts`
--

INSERT INTO `modality_study_layouts` (`id`, `study_type_id`, `layout`, `description`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 2, '<p class=\"MsoNormal\"><span lang=\"EN-US\" style=\"font-size:14.0pt;font-family:&quot;Arial Narrow&quot;,&quot;sans-serif&quot;;\r\nmso-fareast-font-family:&quot;Times New Roman&quot;;mso-bidi-font-family:Tahoma\">Vault,\r\nsella and sutures appear normal.<b><o:p></o:p></b></span></p><p class=\"MsoNormal\"><span lang=\"EN-US\" style=\"font-size:14.0pt;font-family:&quot;Arial Narrow&quot;,&quot;sans-serif&quot;;\r\nmso-fareast-font-family:&quot;Times New Roman&quot;;mso-bidi-font-family:Tahoma\">No\r\nevidence of bony injury seen.<o:p></o:p></span></p><p class=\"MsoNormal\"><span lang=\"EN-US\" style=\"font-size:14.0pt;font-family:&quot;Arial Narrow&quot;,&quot;sans-serif&quot;;\r\nmso-fareast-font-family:&quot;Times New Roman&quot;;mso-bidi-font-family:Tahoma\">No\r\nabnormal intracranial calcification is seen.<b><o:p></o:p></b></span></p><p>\r\n\r\n\r\n\r\n\r\n\r\n</p><p class=\"MsoNormal\"><span lang=\"EN-US\" style=\"font-size:14.0pt;font-family:&quot;Arial Narrow&quot;,&quot;sans-serif&quot;;\r\nmso-fareast-font-family:&quot;Times New Roman&quot;;mso-bidi-font-family:Tahoma\">No\r\nobvious soft tissue abnormality noted.<o:p></o:p></span></p>', NULL, 1, NULL, '2025-03-22 12:43:16', '2025-03-22 12:43:16'),
(2, 2, '<p class=\"MsoNormal\"><span lang=\"EN-US\" style=\"font-size:14.0pt;font-family:&quot;Arial Narrow&quot;,&quot;sans-serif&quot;;\r\nmso-fareast-font-family:&quot;Times New Roman&quot;;mso-bidi-font-family:Tahoma\">Vault,\r\nsella and sutures appear normal.<b><o:p></o:p></b></span></p><p class=\"MsoNormal\"><span lang=\"EN-US\" style=\"font-size:14.0pt;font-family:&quot;Arial Narrow&quot;,&quot;sans-serif&quot;;\r\nmso-fareast-font-family:&quot;Times New Roman&quot;;mso-bidi-font-family:Tahoma\">No\r\nevidence of bony injury seen.<o:p></o:p></span></p><p class=\"MsoNormal\"><span lang=\"EN-US\" style=\"font-size:14.0pt;font-family:&quot;Arial Narrow&quot;,&quot;sans-serif&quot;;\r\nmso-fareast-font-family:&quot;Times New Roman&quot;;mso-bidi-font-family:Tahoma\">No\r\nabnormal intracranial calcification is seen.<b><o:p></o:p></b></span></p><p>\r\n\r\n\r\n\r\n\r\n\r\n</p><p class=\"MsoNormal\"><span lang=\"EN-US\" style=\"font-size:14.0pt;font-family:&quot;Arial Narrow&quot;,&quot;sans-serif&quot;;\r\nmso-fareast-font-family:&quot;Times New Roman&quot;;mso-bidi-font-family:Tahoma\">No\r\nobvious soft tissue abnormality noted.<o:p></o:p></span></p>', NULL, 1, NULL, '2025-03-22 12:45:14', '2025-03-22 12:45:14'),
(4, 2, '<p class=\"MsoNormal\"><span lang=\"EN-US\" style=\"font-size:14.0pt;font-family:&quot;Arial Narrow&quot;,&quot;sans-serif&quot;;\r\nmso-fareast-font-family:&quot;Times New Roman&quot;;mso-bidi-font-family:Tahoma\">Vault,\r\nsella and sutures appear normal.<b><o:p></o:p></b></span></p><p class=\"MsoNormal\"><span lang=\"EN-US\" style=\"font-size:14.0pt;font-family:&quot;Arial Narrow&quot;,&quot;sans-serif&quot;;\r\nmso-fareast-font-family:&quot;Times New Roman&quot;;mso-bidi-font-family:Tahoma\">No\r\nevidence of bony injury seen.<o:p></o:p></span></p><p class=\"MsoNormal\"><span lang=\"EN-US\" style=\"font-size:14.0pt;font-family:&quot;Arial Narrow&quot;,&quot;sans-serif&quot;;\r\nmso-fareast-font-family:&quot;Times New Roman&quot;;mso-bidi-font-family:Tahoma\">No\r\nabnormal intracranial calcification is seen.<b><o:p></o:p></b></span></p><p>\r\n\r\n\r\n\r\n\r\n\r\n</p><p class=\"MsoNormal\"><span lang=\"EN-US\" style=\"font-size:14.0pt;font-family:&quot;Arial Narrow&quot;,&quot;sans-serif&quot;;\r\nmso-fareast-font-family:&quot;Times New Roman&quot;;mso-bidi-font-family:Tahoma\">No\r\nobvious soft tissue abnormality noted.<o:p></o:p></span></p>', NULL, 1, 16, '2025-03-22 12:49:40', '2025-03-22 12:49:40');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `scopes` text DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `scopes` text DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `secret` varchar(100) DEFAULT NULL,
  `provider` varchar(255) DEFAULT NULL,
  `redirect` text NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) NOT NULL,
  `access_token_id` varchar(100) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `age` smallint(6) NOT NULL,
  `gender` varchar(255) NOT NULL,
  `clinical_history` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`id`, `patient_id`, `name`, `age`, `gender`, `clinical_history`, `created_at`, `updated_at`) VALUES
(1, 'QL-PT-108384', 'Dulal Mukherjee', 45, 'male', 'High BP', '2024-11-03 17:44:17', '2024-11-03 17:44:17'),
(15, 'QL-PT-473797', 'Nirmalya Bannerjee', 33, 'male', 'High BP', '2025-03-08 15:51:02', '2025-03-08 15:51:02'),
(16, 'QL-PT-703062', 'Sankar Basu', 45, 'male', 'High Sugar', '2025-03-08 15:53:49', '2025-03-08 15:53:49'),
(17, 'QL-PT-268956', 'Kanta Swami', 78, 'male', 'Test', '2025-03-08 18:51:10', '2025-03-08 18:51:10'),
(18, 'QL-PT-442575', 'Sunil Basu', 63, 'male', 'Test', '2025-03-08 18:55:43', '2025-03-08 18:55:43'),
(19, 'QL-PT-264039', 'Susil Saha', 63, 'male', 'Test', '2025-03-08 18:57:17', '2025-03-08 18:57:17'),
(20, 'QL-PT-712292', 'Prasun Bannerjee', 45, 'male', 'Test', '2025-03-08 19:00:33', '2025-03-08 19:00:33'),
(21, 'QL-PT-106647', 'Test Patient', 45, 'male', 'tewst', '2025-03-08 19:29:30', '2025-03-08 19:29:30'),
(22, 'QL-PT-667124', 'Kusum Konar', 23, 'female', 'Low BP', '2025-03-08 20:22:48', '2025-03-08 20:22:48'),
(24, 'QL-PT-749187', 'Nirmalya Bannerjee', 33, 'male', 'Low BP', '2025-03-10 04:59:04', '2025-03-10 04:59:04'),
(25, 'QL-PT-034422', 'Sujit Nandi', 45, 'male', 'BP', '2025-03-15 12:11:33', '2025-03-15 12:11:33'),
(26, 'QL-PT-100434', 'Susil Saha', 63, 'male', 'Test', '2025-03-23 12:26:59', '2025-03-23 12:26:59');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Admin', NULL, NULL),
(2, 'Quality Controller', NULL, NULL),
(3, 'Centre', NULL, NULL),
(4, 'Doctor', NULL, NULL),
(5, 'Manager', NULL, NULL),
(6, 'Assigner', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role_users`
--

CREATE TABLE `role_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_users`
--

INSERT INTO `role_users` (`id`, `role_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL),
(2, 3, 2, '2024-10-02 17:47:27', '2024-10-02 17:47:27'),
(3, 3, 3, '2024-10-05 14:17:09', '2024-10-05 14:17:09'),
(4, 5, 4, '2024-10-23 19:18:36', '2024-10-23 19:18:36'),
(5, 2, 5, '2024-10-23 19:23:42', '2024-10-23 19:23:42'),
(6, 2, 6, '2024-11-03 17:57:09', '2024-11-03 17:57:09'),
(7, 5, 7, '2024-11-06 17:23:49', '2024-11-06 17:23:49'),
(11, 4, 11, '2024-11-11 04:59:24', '2024-11-11 04:59:24'),
(14, 4, 14, '2024-11-11 06:00:04', '2024-11-11 06:00:04'),
(15, 6, 15, '2024-12-02 17:03:00', '2024-12-02 17:03:00'),
(16, 4, 16, '2024-12-02 17:03:53', '2024-12-02 17:03:53'),
(17, 4, 17, '2024-12-02 17:32:02', '2024-12-02 17:32:02'),
(18, 4, 18, '2024-12-02 17:32:03', '2024-12-02 17:32:03'),
(19, 4, 19, '2024-12-02 17:32:03', '2024-12-02 17:32:03'),
(20, 4, 20, '2024-12-02 17:32:03', '2024-12-02 17:32:03'),
(21, 4, 21, '2024-12-02 17:32:03', '2024-12-02 17:32:03'),
(22, 4, 22, '2024-12-02 17:32:04', '2024-12-02 17:32:04'),
(23, 4, 23, '2024-12-02 17:32:04', '2024-12-02 17:32:04'),
(24, 4, 24, '2024-12-02 17:32:04', '2024-12-02 17:32:04'),
(25, 4, 25, '2024-12-02 17:32:04', '2024-12-02 17:32:04'),
(26, 4, 26, '2024-12-02 17:32:04', '2024-12-02 17:32:04'),
(27, 4, 27, '2024-12-02 17:32:05', '2024-12-02 17:32:05'),
(28, 4, 28, '2024-12-02 17:32:05', '2024-12-02 17:32:05'),
(29, 4, 29, '2024-12-02 17:32:05', '2024-12-02 17:32:05'),
(30, 4, 30, '2024-12-02 17:32:05', '2024-12-02 17:32:05'),
(31, 4, 31, '2024-12-02 17:32:05', '2024-12-02 17:32:05'),
(32, 4, 32, '2024-12-02 17:32:06', '2024-12-02 17:32:06'),
(33, 4, 33, '2024-12-02 17:32:06', '2024-12-02 17:32:06'),
(34, 4, 34, '2024-12-02 17:32:06', '2024-12-02 17:32:06'),
(35, 4, 35, '2024-12-02 17:32:06', '2024-12-02 17:32:06'),
(36, 4, 36, '2024-12-02 17:32:07', '2024-12-02 17:32:07'),
(37, 4, 37, '2024-12-02 17:32:07', '2024-12-02 17:32:07'),
(38, 4, 38, '2024-12-02 17:32:07', '2024-12-02 17:32:07'),
(39, 4, 39, '2024-12-02 17:32:07', '2024-12-02 17:32:07'),
(40, 4, 40, '2024-12-02 17:32:07', '2024-12-02 17:32:07'),
(41, 4, 41, '2024-12-02 17:32:08', '2024-12-02 17:32:08'),
(42, 4, 42, '2024-12-02 17:32:08', '2024-12-02 17:32:08'),
(43, 4, 43, '2024-12-02 17:32:08', '2024-12-02 17:32:08'),
(44, 4, 44, '2024-12-02 17:32:08', '2024-12-02 17:32:08'),
(45, 4, 45, '2024-12-02 17:32:08', '2024-12-02 17:32:08'),
(46, 4, 46, '2024-12-02 17:32:09', '2024-12-02 17:32:09'),
(47, 4, 47, '2024-12-02 17:32:09', '2024-12-02 17:32:09'),
(48, 4, 48, '2024-12-02 17:32:09', '2024-12-02 17:32:09'),
(49, 4, 49, '2024-12-02 17:32:09', '2024-12-02 17:32:09'),
(50, 4, 50, '2024-12-02 17:32:09', '2024-12-02 17:32:09'),
(51, 4, 51, '2024-12-02 17:32:10', '2024-12-02 17:32:10'),
(52, 4, 52, '2024-12-02 17:32:10', '2024-12-02 17:32:10'),
(53, 4, 53, '2024-12-02 17:32:10', '2024-12-02 17:32:10'),
(54, 4, 54, '2024-12-02 17:32:10', '2024-12-02 17:32:10'),
(55, 4, 55, '2024-12-02 17:32:11', '2024-12-02 17:32:11'),
(56, 4, 56, '2024-12-02 17:32:11', '2024-12-02 17:32:11'),
(57, 4, 57, '2024-12-02 17:32:11', '2024-12-02 17:32:11'),
(58, 4, 58, '2024-12-02 17:32:11', '2024-12-02 17:32:11'),
(59, 4, 59, '2024-12-02 17:32:11', '2024-12-02 17:32:11'),
(60, 4, 60, '2024-12-02 17:32:12', '2024-12-02 17:32:12'),
(61, 4, 61, '2024-12-02 17:32:12', '2024-12-02 17:32:12'),
(62, 4, 62, '2024-12-02 17:32:12', '2024-12-02 17:32:12'),
(63, 4, 63, '2024-12-02 17:32:12', '2024-12-02 17:32:12'),
(64, 4, 64, '2024-12-02 17:32:12', '2024-12-02 17:32:12'),
(65, 4, 65, '2024-12-02 17:32:13', '2024-12-02 17:32:13'),
(66, 4, 66, '2024-12-02 17:32:13', '2024-12-02 17:32:13'),
(70, 3, 70, '2025-02-08 18:46:12', '2025-02-08 18:46:12'),
(71, 6, 71, '2025-03-09 11:53:04', '2025-03-09 11:53:04'),
(72, 6, 72, '2025-03-18 18:28:19', '2025-03-18 18:28:19');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('G0ivdj4eJcYrxJAT7TdVmasKzIHDDhLqoXE4Plkg', NULL, '127.0.0.1', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:130.0) Gecko/20100101 Firefox/130.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVnBtY1FJamt4a29nVDhsaVNqNXZEaUxMcXNpR0JHbllUQkFhQXNZcyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1726412297),
('IQuYZ5UwkSeeYtk1NlAJ0ngQpLKBsLOCXCXceueX', NULL, '127.0.0.1', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:130.0) Gecko/20100101 Firefox/130.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiN0ZDRXUyTnlqSHZZdWx4ekZuVUpiYzB6WG5HTHhqU2dQVWJUc0R6QSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1726388899),
('j7n6UioG7KHmR3ZbGEFQPGtJkCPZ8EsRdIPo0Gwj', NULL, '127.0.0.1', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:130.0) Gecko/20100101 Firefox/130.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTmhGWWhiaUJpelJoRXZ0ODQxWDE2ZVlVVWNkaW1nZmU2QkQzT2x0RSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1726911158);

-- --------------------------------------------------------

--
-- Table structure for table `studies`
--

CREATE TABLE `studies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `study_type_id` bigint(20) UNSIGNED NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `case_study_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `studies`
--

INSERT INTO `studies` (`id`, `study_type_id`, `description`, `created_at`, `updated_at`, `case_study_id`) VALUES
(1, 14, 'Test', '2025-03-10 04:59:04', '2025-03-10 04:59:04', 1),
(2, 50, NULL, '2025-03-15 12:11:33', '2025-03-15 12:11:33', 2),
(3, 2, 'dfdfdf', '2025-03-23 12:26:59', '2025-03-23 12:26:59', 3),
(4, 9, 'fdgdfgdf', '2025-03-23 12:26:59', '2025-03-23 12:26:59', 3),
(5, 13, 'dfgdfgdf', '2025-03-23 12:26:59', '2025-03-23 12:26:59', 3);

-- --------------------------------------------------------

--
-- Table structure for table `study_images`
--

CREATE TABLE `study_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `study_id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `study_images`
--

INSERT INTO `study_images` (`id`, `study_id`, `image`, `created_at`, `updated_at`) VALUES
(1, 1, 'D:\\xampp\\htdocs\\quick_line\\storage\\app\\uploads\\Balaji Diagnostic Centre Halisahar Unit 2\\Nirmalya Bannerjee\\1741582744_dog.jpg', '2025-03-10 04:59:04', '2025-03-10 04:59:04'),
(2, 2, 'D:\\xampp\\htdocs\\quick_line\\storage\\app\\uploads\\Balaji Diagnostic Centre Halisahar Unit 2\\Sujit Nandi\\1742040693_dog.jpg', '2025-03-15 12:11:33', '2025-03-15 12:11:33'),
(3, 5, 'D:\\xampp\\htdocs\\quick_line\\storage\\app\\uploads\\Naihati Pathology\\Susil Saha\\1742732819_dog.jpg', '2025-03-23 12:26:59', '2025-03-23 12:26:59'),
(4, 5, 'D:\\xampp\\htdocs\\quick_line\\storage\\app\\uploads\\Naihati Pathology\\Susil Saha\\1742732819_lion.webp', '2025-03-23 12:26:59', '2025-03-23 12:26:59');

-- --------------------------------------------------------

--
-- Table structure for table `study_statuses`
--

CREATE TABLE `study_statuses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `study_statuses`
--

INSERT INTO `study_statuses` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Unread', NULL, NULL),
(2, 'Pending', NULL, NULL),
(3, 'QA Pending', NULL, NULL),
(4, 'Re-Work', NULL, NULL),
(5, 'Finished', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `study_types`
--

CREATE TABLE `study_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `modality_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `study_types`
--

INSERT INTO `study_types` (`id`, `modality_id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'ACU (SPECIAL STUDY)', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(2, 1, 'ANKLE AP', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(3, 1, 'ANKLE LATERAL', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(4, 1, 'APICAL LORDOTIC', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(5, 1, 'BARIUM', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(6, 1, 'BARIUM ENEMA', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(7, 1, 'BARIUM MEAL FOLLOW THROUGH', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(8, 1, 'BARIUM MEAL ILOCECAL REGION', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(9, 1, 'BARIUM MEAL STOMACH & DUODENUM', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(10, 1, 'BARIUM STUDIES', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(11, 1, 'BARIUM SWALLOW OESOPHAGUS', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(12, 1, 'BILATERAL HIPS', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(13, 1, 'BREASTBONE LATERAL', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(14, 1, 'BREASTBONE PA', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(15, 1, 'CALCANEUS AXIAL', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(16, 1, 'CALCANEUS LATERAL', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(17, 1, 'CARPAL BRIDGE', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(18, 1, 'CARPAL TUNNEL', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(19, 1, 'CAVUM (ADENOIDAL HETEROTROPHY)', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(20, 1, 'CHEST LATERAL', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(21, 1, 'CHEST PA', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(22, 1, 'CLAVICLE', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(23, 1, 'CLAVICLE AXIAL', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(24, 1, 'COCCYX AP', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(25, 1, 'COCCYX LATERAL', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(26, 1, 'CERVICAL SPINE (FLEXION & EXTENSION)', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(27, 1, 'CERVICAL SPINE (LEFT & RIGHT)', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(28, 1, 'CERVICAL SPINE AP/LAT', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(29, 1, 'CERVICAL SPINE OBLIQUE', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(30, 1, 'CERVIVOTHORACIC REGION LATERAL', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(31, 1, 'DIRECT ABDOMEN ERECT', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(32, 1, 'DIRECT ABDOMINAL (DECUBITUS POSITION)', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(33, 1, 'ELBOW AP', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(34, 1, 'ELBOW LATERAL', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(35, 1, 'ELBOW OBLIQUE', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(36, 1, 'FEMUR AP', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(37, 1, 'FEMUR LATERAL', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(38, 1, 'FERGUSSON TECHNIQUE (L5-S1)', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(39, 1, 'FISTULA', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(40, 1, 'FISTULAGRAM', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(41, 1, 'FOOT (LOADED)', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(42, 1, 'FOOT AP', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(43, 1, 'FOOT LATERAL', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(44, 1, 'FOOT OBLIQUE', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(45, 1, 'FOREARM AP', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(46, 1, 'FOREARM LATERAL', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(47, 1, 'HAND LATERAL', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(48, 1, 'HAND PA', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(49, 1, 'HSG', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(50, 1, 'HIP JOINT AP', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(51, 1, 'HIP JOINT LATERAL', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(52, 1, 'HIRTZ', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(53, 1, 'HUMERUS AP', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(54, 1, 'HUMERUS LATERAL', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(55, 1, 'HUMERUS TRANSTHORACIC', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(56, 1, 'INTERCONDYAL FOSSA', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(57, 1, 'IN LET', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(58, 1, 'IVP/IVU', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(59, 1, 'JAROSCHY AXIAL', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(60, 1, 'KNEE AP', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(61, 1, 'KNEE LATERAL', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(62, 1, 'KNEE LATERAL (LOADED)', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(63, 1, 'KNEE OBLIQUE', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(64, 1, 'KNEE SKYLINE VIEW', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(65, 1, 'KUB', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(66, 1, 'LEG AP', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(67, 1, 'LEG LATEAL', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(68, 1, 'LEFT OBLIQUE', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(69, 1, 'LUMBAR SPINE (LEFT & RIGHT TILTED)', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(70, 1, 'LUMBAR SPINE (FLEXION & EXTENSION)', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(71, 1, 'LUMBAR SPINE AP', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(72, 1, 'LUMBAR SPINE LATERAL', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(73, 1, 'LUMBAR SPINE SPINE (FLEXION & EXTENSION)', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(74, 1, 'MANDIBLE LATERAL', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(75, 1, 'MANDIBLE PA', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(76, 1, 'MASTOID LATERAL', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(77, 1, 'MAMMOGRAPHY', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(78, 1, 'MCU', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(79, 1, 'NASOPHARYNX', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(80, 1, 'NOSE LATERAL', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(81, 1, 'OBLIQUE HAND', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(82, 1, 'OBLIQUE HAND (NORGAARD)', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(83, 1, 'OBLIQUE LUMBAR', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(84, 1, 'ODONTOID PROCESS AP', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(85, 1, 'OPG', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(86, 1, 'ORBITS LATERAL', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(87, 1, 'ORBIT PA', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(88, 1, 'OUTLET', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(89, 1, 'OTTENELLO METHOD', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(90, 1, 'PATELLA AXIAL', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(91, 1, 'PATELLA LATERAL', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(92, 1, 'PATELLA PA', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(93, 1, 'PELVIS AP', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(94, 1, 'PELVIS JUDET (ILIAC)', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(95, 1, 'PELVIS JUDET (OBTURATOR)', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(96, 1, 'PENIS', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(97, 1, 'PNS OPEN MOUTH VIEW', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(98, 1, 'PNS WATERS VIEW', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(99, 1, 'PULMONARY VERTEX', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(100, 1, 'RGU', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(101, 1, 'RIGHT OBLIQUE', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(102, 1, 'RIBS AP', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(103, 1, 'RIBS PA', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(104, 1, 'SACRUM AP', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(105, 1, 'SACRUM AXIAL', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(106, 1, 'SACRUM LATERAL', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(107, 1, 'SCAPHOID', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(108, 1, 'SCAPULA AP', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(109, 1, 'SCAPULA LATERAL', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(110, 1, 'SCANOGRAM', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(111, 1, 'SCHULLER I', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36'),
(112, 1, 'SCHULLER II', 1, '2025-02-16 05:20:36', '2025-02-16 05:20:36');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `two_factor_secret` text DEFAULT NULL,
  `two_factor_recovery_codes` text DEFAULT NULL,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `access_type` varchar(255) NOT NULL DEFAULT 'user',
  `mobile_number` varchar(255) DEFAULT NULL,
  `login_count` int(11) NOT NULL DEFAULT 0,
  `last_login_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user_image` varchar(255) DEFAULT NULL,
  `status` smallint(6) NOT NULL DEFAULT 1,
  `is_first_login` enum('0','1') NOT NULL DEFAULT '1',
  `is_outsider` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `remember_token`, `created_at`, `updated_at`, `access_type`, `mobile_number`, `login_count`, `last_login_at`, `user_image`, `status`, `is_first_login`, `is_outsider`) VALUES
(1, 'Pranab Karmakar', 'admin@gmail.com', NULL, '$2y$12$vOOotr9uG2G3bR6SvyxMAuOVd9UwDda6fW4HEoCz.jd4QpAsDgNY6', NULL, NULL, NULL, 'IFcCqrStIga8RqEj18JWJIyuzuJQOJJjPbURWZ0VD1qOrfBNyT3GD5QVHYTe', NULL, '2025-03-18 18:27:34', 'admin', NULL, 48, '2025-03-23 12:19:37', 'https://ui-avatars.com/api/?name=Pranab+Karmakar&background=2ff8ff&color=000000&size=150', 1, '0', 0),
(2, 'Balaji Diagnostic Centre Halisahar Unit 2', 'balajihalisahar@gmail.com', NULL, '$2y$12$Vrbwc.xvu8ToXUGmySVImeVcs1EXj1i8UUOpvSTgAIM1eXXpjCAOa', NULL, NULL, NULL, NULL, '2024-10-02 17:47:27', '2025-02-24 03:39:53', 'user', NULL, 0, '2025-02-24 03:39:53', 'https://ui-avatars.com/api/?name=balaji+diagnostic+centre+halisahar&background=fc7a60&color=000000&size=150', 1, '1', 0),
(3, 'Naihati Diagnostics', 'naihati_diagnostics@gmail.com', NULL, '$2y$12$Vrbwc.xvu8ToXUGmySVImeVcs1EXj1i8UUOpvSTgAIM1eXXpjCAOa', NULL, NULL, NULL, NULL, '2024-10-05 14:17:09', '2024-11-22 19:16:36', 'user', NULL, 0, '2024-11-22 19:16:36', 'https://ui-avatars.com/api/?name=Naihati+Diagnostics&background=fb5350&color=000000&size=150', 0, '1', 0),
(4, 'Rohit Saha', 'rohit_saha@gmail.com', NULL, '$2y$12$HhaSFwyMgMJgZGGndth17eYBNaaw0PJBv006VL.exL7HOVU93EEym', NULL, NULL, NULL, 'ltnTG2clLHyq4qKA8FUEv1vLe5IIH4TmXOC6lMRfRKLIuqgOK6F2TAhaVR80', '2024-10-23 19:18:36', '2025-03-16 17:29:14', 'Manager', '9865-321-100', 16, '2025-03-23 12:41:03', 'https://ui-avatars.com/api/?name=Rohit+Saha&background=0cc88d&color=000000&size=150', 1, '0', 0),
(5, 'Poulomi Biswas', 'pbiswas@gmail.com', NULL, '$2y$12$XHxS7NuVzzzFu3kvE3Gn3.bi1jZVUQJdZP/WwxrjyDZwagquY0icy', NULL, NULL, NULL, '2Cr6amg3fP8lDo3yCXGaJ801EOXmUKoBcSSSailP506qmXpLLdHRZRfrQht9', '2024-10-23 19:23:42', '2025-03-15 12:20:39', 'Quality Controller', '9632-512-022', 9, '2025-03-15 12:20:44', 'https://ui-avatars.com/api/?name=Poulomi+Biswas&background=b96ed4&color=000000&size=150', 1, '0', 1),
(6, 'Rahul Sinha', 'rsinha@gmail.com', NULL, '$2y$12$S6N3sQu1/JEmFeaRwF1B8OHAjoSokiRy8qMccXQVKakJhebiM.FP.', NULL, NULL, NULL, 'QSrJuN2nKArfuhXBxiwsqZXxpjumNkDK2YhFvJh5QSOmBpALxNotFThXGjir', '2024-11-03 17:57:09', '2025-03-15 12:20:48', 'Quality Controller', '9656-325-658', 5, '2025-03-15 12:20:52', 'https://ui-avatars.com/api/?name=Rahul+Sinha&background=c7074f&color=ffffff&size=150', 1, '0', 0),
(7, 'John Doe', 'johnd@gmail.com', NULL, '$2y$12$Xo6ZWNYj9ff2mKl/SJBS6u6Dd8FKp9pCCrHpwwJ0H7.m5HmAcgXEO', NULL, NULL, NULL, 'x9rilrEWwrzCTUZLSwTJN057MACRFo2GKxQQVd4Z3saMzV7JkwUgAt0KyXs5', '2024-11-06 17:23:49', '2025-03-09 11:50:36', 'Manager', '9656-325-632', 3, '2025-03-09 11:53:27', 'https://ui-avatars.com/api/?name=John+Doe&background=8c2314&color=ffffff&size=150', 1, '0', 0),
(11, 'Rajib Biswas.', 'rbiswas@gmail.com', NULL, '$2y$12$mqlcDjWhSFMYWjnVCAAa6OyGSdEmYgWmlaPvh.Vq6GJppGQ40v4CG', NULL, NULL, NULL, 'bYiXGg9HPtG81edeSQkywmsKK17Dn58cY0Pc9jbGSsr38eUQHZKpQK5ZKmcm', '2024-11-11 04:59:24', '2024-11-17 19:49:42', 'Doctor', NULL, 1, '2024-12-02 16:59:27', 'https://ui-avatars.com/api/?name=Rajib+Biswas&background=8dcb49&color=000000&size=150', 1, '0', 0),
(14, 'Dipankar Bannerjee', 'drbannerjee@gmail.com', NULL, '$2y$12$j/DJwWoXo8C5lpBDL2aTQOL.wdtaDcoAHrngaiAsdE1mBKOM1COxq', NULL, NULL, NULL, NULL, '2024-11-11 06:00:04', '2024-11-16 18:24:36', 'Doctor', NULL, 0, '2024-12-02 16:59:34', 'https://ui-avatars.com/api/?name=Dipankar+Bannerjee&background=a0b754&color=000000&size=150', 1, '1', 0),
(15, 'New Rapoo', 'rapoo@gmail.com', NULL, '$2y$12$Y78DhHObBFktEUfvAKNfGuHciyFMbg/JAhDThXh0Cwb2T0lh7q4G2', NULL, NULL, NULL, NULL, '2024-12-02 17:03:00', '2025-02-09 17:18:49', 'Assigner', '9865-666-888', 0, '2025-02-09 17:18:49', 'https://ui-avatars.com/api/?name=Sunil+Kumar&background=976557&color=ffffff&size=150', 1, '1', 0),
(16, 'Aapto Biswas', 'aapto@gmail.com', NULL, '$2y$12$pe2GjXKGdfVQI538P5SXKOTmKGPBo0fivDjg/csbpI/oQXNFdVeX.', NULL, NULL, NULL, NULL, '2024-12-02 17:03:53', '2025-02-08 19:02:09', 'Doctor', NULL, 0, '2025-02-08 19:02:09', 'https://ui-avatars.com/api/?name=Aapto+Biswas&background=c5b68c&color=000000&size=150', 1, '1', 0),
(17, 'Colt Connelly', 'mlang@gmail.com', NULL, '$2y$12$t4OdDURbHIogo5Xr2NBpcOHOB69JifMzJ8VbSUw/p4TNhHpJulb2e', NULL, NULL, NULL, NULL, '2024-12-02 17:32:02', '2024-12-02 17:32:02', 'Doctor', NULL, 0, '2024-12-02 17:32:02', 'https://ui-avatars.com/api/?name=Colt+Connelly&background=97c6f0&color=000000&size=150', 1, '1', 0),
(18, 'Rhett Hansen', 'stamm.hassie@bins.org', NULL, '$2y$12$nj8wK7dfirX2FzCNPZTDJeCJFYkEp2IwQxSUTv1E9TXBIgYWhnKIe', NULL, NULL, NULL, NULL, '2024-12-02 17:32:03', '2024-12-02 17:32:03', 'Doctor', NULL, 0, '2024-12-02 17:32:03', 'https://ui-avatars.com/api/?name=Rhett+Hansen&background=59f3d5&color=000000&size=150', 1, '1', 0),
(19, 'Tate Considine', 'emory77@hotmail.com', NULL, '$2y$12$MD651HRnEUPtHBjXrndfYOavJ8H13ecxUC7Pays8mWdWlWroQVfNi', NULL, NULL, NULL, NULL, '2024-12-02 17:32:03', '2024-12-02 17:32:03', 'Doctor', NULL, 0, '2024-12-02 17:32:03', 'https://ui-avatars.com/api/?name=Tate+Considine&background=71dee7&color=000000&size=150', 1, '1', 0),
(20, 'Mr. Ibrahim Fisher Jr.', 'gussie34@rohan.com', NULL, '$2y$12$ijlE665yBNiHc25va7dsueR7Uqp/Dp4lP8DIaFEVs0Eqk0a3fcJTm', NULL, NULL, NULL, NULL, '2024-12-02 17:32:03', '2024-12-02 17:32:03', 'Doctor', NULL, 0, '2024-12-02 17:32:03', 'https://ui-avatars.com/api/?name=Mr.+Ibrahim+Fisher+Jr.&background=931103&color=ffffff&size=150', 1, '1', 0),
(21, 'Madyson Conn', 'ykulas@gmail.com', NULL, '$2y$12$mM660YnmYfEYydHJEAxCQuO2V3j5WWpvu45F99SkQbv9PTCoL9fYG', NULL, NULL, NULL, NULL, '2024-12-02 17:32:03', '2024-12-02 17:32:03', 'Doctor', NULL, 0, '2024-12-02 17:32:03', 'https://ui-avatars.com/api/?name=Madyson+Conn&background=dcfb8d&color=000000&size=150', 1, '1', 0),
(22, 'Stone Marvin', 'wiza.kaylin@gmail.com', NULL, '$2y$12$OwMCAPkpcopnrpEEhKnsf.SY7K7kVnwGF7rjRkg57LLruy.Jjdz/u', NULL, NULL, NULL, NULL, '2024-12-02 17:32:04', '2024-12-02 17:32:04', 'Doctor', NULL, 0, '2024-12-02 17:32:04', 'https://ui-avatars.com/api/?name=Stone+Marvin&background=c1e77c&color=000000&size=150', 1, '1', 0),
(23, 'Tristin Koch', 'delbert48@reichert.com', NULL, '$2y$12$egR2vZ0T9LbWMPKciVMWdOh3qxBS/szm9rAR4uWPVWWlRSiHtcoAC', NULL, NULL, NULL, NULL, '2024-12-02 17:32:04', '2024-12-02 17:32:04', 'Doctor', NULL, 0, '2024-12-02 17:32:04', 'https://ui-avatars.com/api/?name=Tristin+Koch&background=17af3a&color=ffffff&size=150', 1, '1', 0),
(24, 'Laverne Runte DDS', 'lela73@mohr.info', NULL, '$2y$12$tzEB.7B5VFjruw1tSVzbTeIdZ3A.uFa2pDFu9qIHMJlxuz7fFTbny', NULL, NULL, NULL, NULL, '2024-12-02 17:32:04', '2024-12-02 17:32:04', 'Doctor', NULL, 0, '2024-12-02 17:32:04', 'https://ui-avatars.com/api/?name=Laverne+Runte+DDS&background=9c1269&color=ffffff&size=150', 1, '1', 0),
(25, 'Ms. Emmalee Goodwin II', 'brain32@yahoo.com', NULL, '$2y$12$lDIzmjX5DrHZZn1ls9uylOUob.i0rUnNEdWlmUoPehx9m50PGyaUC', NULL, NULL, NULL, NULL, '2024-12-02 17:32:04', '2024-12-02 17:32:04', 'Doctor', NULL, 0, '2024-12-02 17:32:04', 'https://ui-avatars.com/api/?name=Ms.+Emmalee+Goodwin+II&background=da0747&color=ffffff&size=150', 1, '1', 0),
(26, 'Prof. Andy Schultz MD', 'gkovacek@yahoo.com', NULL, '$2y$12$8gxjO.CfOpFYdS4KUierD.h5Lm8g1GQgbx9qq8AVUrgMUSjAl9Cm6', NULL, NULL, NULL, NULL, '2024-12-02 17:32:04', '2024-12-02 17:32:04', 'Doctor', NULL, 0, '2024-12-02 17:32:04', 'https://ui-avatars.com/api/?name=Prof.+Andy+Schultz+MD&background=8aaa13&color=000000&size=150', 1, '1', 0),
(27, 'Dr. Lorena Hintz', 'dakota.emard@gmail.com', NULL, '$2y$12$Rvo8K8pIqu9l6xRQQ0AhrOPmigDqNzeZfQPv67Wm.B3IpxI95MNpe', NULL, NULL, NULL, NULL, '2024-12-02 17:32:05', '2024-12-02 17:32:05', 'Doctor', NULL, 0, '2024-12-02 17:32:05', 'https://ui-avatars.com/api/?name=Dr.+Lorena+Hintz&background=ecac12&color=000000&size=150', 1, '1', 0),
(28, 'Prof. Irwin Kozey', 'qreichel@gmail.com', NULL, '$2y$12$Hs10011naaogu2JugDnLiu.3LVtAAo4mj.6vj3ff/rdvyeZBVxV/6', NULL, NULL, NULL, NULL, '2024-12-02 17:32:05', '2024-12-02 17:32:05', 'Doctor', NULL, 0, '2024-12-02 17:32:05', 'https://ui-avatars.com/api/?name=Prof.+Irwin+Kozey&background=8a2249&color=ffffff&size=150', 1, '1', 0),
(29, 'Margret Muller', 'awill@yahoo.com', NULL, '$2y$12$qe1ril2Ih9NjTu93Omv2feZUExDH4ei7rYC7Oa4n9TbcdPjibsjNq', NULL, NULL, NULL, NULL, '2024-12-02 17:32:05', '2024-12-02 17:32:05', 'Doctor', NULL, 0, '2024-12-02 17:32:05', 'https://ui-avatars.com/api/?name=Margret+Muller&background=29e633&color=000000&size=150', 1, '1', 0),
(30, 'Aurelia Flatley', 'hreichel@yahoo.com', NULL, '$2y$12$Q2yXV8f0TF.6K5PMdrRSyuQvs.8pHTSJbYRNzlOls/dBFyxAZuhda', NULL, NULL, NULL, NULL, '2024-12-02 17:32:05', '2025-02-08 19:01:56', 'Doctor', NULL, 0, '2025-02-08 19:01:56', 'https://ui-avatars.com/api/?name=Aurelia+Flatley&background=ddebeb&color=000000&size=150', 1, '1', 0),
(31, 'Mrs. Lilian Miller Sr.', 'twhite@oreilly.org', NULL, '$2y$12$nX1ly7QGBhs0qGv5ywEdv.9WdJ71rVtB6i1vZpEz9on8pJyLENeza', NULL, NULL, NULL, NULL, '2024-12-02 17:32:05', '2024-12-02 17:32:05', 'Doctor', NULL, 0, '2024-12-02 17:32:05', 'https://ui-avatars.com/api/?name=Mrs.+Lilian+Miller+Sr.&background=be3974&color=ffffff&size=150', 1, '1', 0),
(32, 'Chyna Erdman', 'cooper.reynolds@gmail.com', NULL, '$2y$12$eGTeXgZWP0LDf3/lUKuxN.5K9nGDMl.kEtavikrF8Ntg2leuszav2', NULL, NULL, NULL, NULL, '2024-12-02 17:32:06', '2024-12-02 17:32:06', 'Doctor', NULL, 0, '2024-12-02 17:32:06', 'https://ui-avatars.com/api/?name=Chyna+Erdman&background=6cc600&color=000000&size=150', 1, '1', 0),
(33, 'Janiya Ullrich', 'conn.eino@zulauf.com', NULL, '$2y$12$Ihs9tzobOM0Zoqi2OHI1luZQFNTVu62T8N98m3t52OLgJJI4asQAy', NULL, NULL, NULL, NULL, '2024-12-02 17:32:06', '2024-12-02 17:32:06', 'Doctor', NULL, 0, '2024-12-02 17:32:06', 'https://ui-avatars.com/api/?name=Janiya+Ullrich&background=94e481&color=000000&size=150', 1, '1', 0),
(34, 'Celestine Rice', 'kiehn.johathan@muller.com', NULL, '$2y$12$m8GEej/gmm7YcVdfrpI0tu05TA/4tGmqDkE2TWeVfj4cK3Ncc5cRG', NULL, NULL, NULL, NULL, '2024-12-02 17:32:06', '2024-12-02 17:32:06', 'Doctor', NULL, 0, '2024-12-02 17:32:06', 'https://ui-avatars.com/api/?name=Celestine+Rice&background=02db70&color=000000&size=150', 1, '1', 0),
(35, 'Mr. Jovanny Stokes II', 'vswift@greenholt.info', NULL, '$2y$12$U8GIFR8LAc5SOVVHw4Hg4u4cDtTS8WsrrorbHy0ogypBQk/eLoTbO', NULL, NULL, NULL, NULL, '2024-12-02 17:32:06', '2024-12-02 17:32:06', 'Doctor', NULL, 0, '2024-12-02 17:32:06', 'https://ui-avatars.com/api/?name=Mr.+Jovanny+Stokes+II&background=37dd93&color=000000&size=150', 1, '1', 0),
(36, 'Cassandra Gislason', 'gladys93@mccullough.com', NULL, '$2y$12$gRexitaGJGT9OsrKmDOoduE2cIlAiazawxRFrbTx2l7rBEeF9tBZ2', NULL, NULL, NULL, NULL, '2024-12-02 17:32:07', '2024-12-02 17:32:07', 'Doctor', NULL, 0, '2024-12-02 17:32:07', 'https://ui-avatars.com/api/?name=Cassandra+Gislason&background=9f69fb&color=000000&size=150', 1, '1', 0),
(37, 'Maynard Stiedemann V', 'kuhn.lincoln@fadel.biz', NULL, '$2y$12$iebEG7QUEPudZhmoOzb4vOyxyOgLR.hWjn/7yfuQhp7ywKVs7fTIW', NULL, NULL, NULL, NULL, '2024-12-02 17:32:07', '2024-12-02 17:32:07', 'Doctor', NULL, 0, '2024-12-02 17:32:07', 'https://ui-avatars.com/api/?name=Maynard+Stiedemann+V&background=81f324&color=000000&size=150', 1, '1', 0),
(38, 'Neil Reichel', 'hdurgan@gmail.com', NULL, '$2y$12$E8VZJwQ4bQToI6Spsz5FLOlqhHEuIDulYKIEIQi7p9xdmiBs4dH3K', NULL, NULL, NULL, NULL, '2024-12-02 17:32:07', '2024-12-02 17:32:07', 'Doctor', NULL, 0, '2024-12-02 17:32:07', 'https://ui-avatars.com/api/?name=Neil+Reichel&background=e5b0d1&color=000000&size=150', 1, '1', 0),
(39, 'Dangelo Jerde DDS', 'hkuvalis@koch.com', NULL, '$2y$12$h4Qte9t9dc2hxPx7gL/u/e62Nw3Ef9lk5RTuEzEH63KzyK8bdQbCq', NULL, NULL, NULL, NULL, '2024-12-02 17:32:07', '2024-12-02 17:32:07', 'Doctor', NULL, 0, '2024-12-02 17:32:07', 'https://ui-avatars.com/api/?name=Dangelo+Jerde+DDS&background=7d053b&color=ffffff&size=150', 1, '1', 0),
(40, 'Eldora Towne', 'darby18@blick.biz', NULL, '$2y$12$OctQd5PyapL.jQFy9WwQ/.UKrWfomVSL65KoiE008Vhmi.lpGpKou', NULL, NULL, NULL, NULL, '2024-12-02 17:32:07', '2024-12-02 17:32:07', 'Doctor', NULL, 0, '2024-12-02 17:32:07', 'https://ui-avatars.com/api/?name=Eldora+Towne&background=a75f68&color=ffffff&size=150', 1, '1', 0),
(41, 'Chelsea Torp', 'lera.balistreri@conroy.net', NULL, '$2y$12$7ypFPGuyGsHDWO6KbkI67eE24FQW8EiPz0SjE.uwo5dgg0PY6Q782', NULL, NULL, NULL, NULL, '2024-12-02 17:32:08', '2024-12-02 17:32:08', 'Doctor', NULL, 0, '2024-12-02 17:32:08', 'https://ui-avatars.com/api/?name=Chelsea+Torp&background=978753&color=000000&size=150', 1, '1', 0),
(42, 'Billie Schiller', 'walsh.fae@little.net', NULL, '$2y$12$wqNl7Fq/4ZXiY6YVagmFCeHNvgsFe5GKsd/goDbJcW2BQC6NMyfZ6', NULL, NULL, NULL, NULL, '2024-12-02 17:32:08', '2024-12-02 17:32:08', 'Doctor', NULL, 0, '2024-12-02 17:32:08', 'https://ui-avatars.com/api/?name=Billie+Schiller&background=80d241&color=000000&size=150', 1, '1', 0),
(43, 'Mia Pouros', 'ledner.breana@price.com', NULL, '$2y$12$kC1ujH8DQ7GIHfSQ2HO4nuLWIqubfYVBotkgM7thoT4s4P4TIBr4q', NULL, NULL, NULL, NULL, '2024-12-02 17:32:08', '2024-12-02 17:32:08', 'Doctor', NULL, 0, '2024-12-02 17:32:08', 'https://ui-avatars.com/api/?name=Mia+Pouros&background=3a9d17&color=ffffff&size=150', 1, '1', 0),
(44, 'Lucy Heathcote MD', 'roma45@moore.com', NULL, '$2y$12$g/4phXXnNikQz4.x4g6q2.DBCjlLbehEA6I2.ekctytVAOPBwlOX2', NULL, NULL, NULL, NULL, '2024-12-02 17:32:08', '2024-12-02 17:32:08', 'Doctor', NULL, 0, '2024-12-02 17:32:08', 'https://ui-avatars.com/api/?name=Lucy+Heathcote+MD&background=85800e&color=ffffff&size=150', 1, '1', 0),
(45, 'Jayda Legros', 'kris98@leffler.biz', NULL, '$2y$12$K6C/0lRCUwbVn/cbeL2O9.7tgts0ZIHICLJLw0Rnr3LciZQTsTmvm', NULL, NULL, NULL, NULL, '2024-12-02 17:32:08', '2024-12-02 17:32:08', 'Doctor', NULL, 0, '2024-12-02 17:32:08', 'https://ui-avatars.com/api/?name=Jayda+Legros&background=849c96&color=000000&size=150', 1, '1', 0),
(46, 'Dr. Vito Parker', 'marcel.johns@nader.com', NULL, '$2y$12$0j0eAd5xk31bk0Z.W4jtQuGbkuLSP3gKzdk1AWKJ9Igsl4Arpxeee', NULL, NULL, NULL, NULL, '2024-12-02 17:32:09', '2024-12-02 17:32:09', 'Doctor', NULL, 0, '2024-12-02 17:32:09', 'https://ui-avatars.com/api/?name=Dr.+Vito+Parker&background=893ef2&color=ffffff&size=150', 1, '1', 0),
(47, 'Maxine Mann', 'streich.paris@king.org', NULL, '$2y$12$ye/QFX8qddEGWROVPS1Sfu5twbGb1f.BkAwarQRId2HS47iG65VIq', NULL, NULL, NULL, NULL, '2024-12-02 17:32:09', '2024-12-02 17:32:09', 'Doctor', NULL, 0, '2024-12-02 17:32:09', 'https://ui-avatars.com/api/?name=Maxine+Mann&background=3ad991&color=000000&size=150', 1, '1', 0),
(48, 'Dr. Simeon Cummings MD', 'yschimmel@paucek.biz', NULL, '$2y$12$H5Ll/Eceyheyrtp1nEMEqOEeoIbDtrirCnsyysZevVBcBWAFOQlmS', NULL, NULL, NULL, NULL, '2024-12-02 17:32:09', '2024-12-02 17:32:09', 'Doctor', NULL, 0, '2024-12-02 17:32:09', 'https://ui-avatars.com/api/?name=Dr.+Simeon+Cummings+MD&background=76d5ae&color=000000&size=150', 1, '1', 0),
(49, 'Miss Cortney Barrows V', 'queen.lesch@walker.com', NULL, '$2y$12$fW9R1VE3Kq/PqBodTmkrwufS5FnUTvoFtyX59scFGsdho7y7MPQCC', NULL, NULL, NULL, NULL, '2024-12-02 17:32:09', '2024-12-02 17:32:09', 'Doctor', NULL, 0, '2024-12-02 17:32:09', 'https://ui-avatars.com/api/?name=Miss+Cortney+Barrows+V&background=028cfd&color=ffffff&size=150', 1, '1', 0),
(50, 'Dr. Meredith Adams V', 'bvon@carroll.biz', NULL, '$2y$12$ZpRbIW5VHFsXFddTydjKNOwUzjIpR0ccGilYkTiXj/ci7.v5Bqfse', NULL, NULL, NULL, NULL, '2024-12-02 17:32:09', '2024-12-02 17:32:09', 'Doctor', NULL, 0, '2024-12-02 17:32:09', 'https://ui-avatars.com/api/?name=Dr.+Meredith+Adams+V&background=74b147&color=000000&size=150', 1, '1', 0),
(51, 'Leonel Hirthe', 'conn.daisy@kuvalis.com', NULL, '$2y$12$bbrCGOuzVo3kcXPfFe/5HO3jdQ.E9kLKimmUuR7M.F4RFCj12ylAe', NULL, NULL, NULL, NULL, '2024-12-02 17:32:10', '2024-12-02 17:32:10', 'Doctor', NULL, 0, '2024-12-02 17:32:10', 'https://ui-avatars.com/api/?name=Leonel+Hirthe&background=f156e6&color=000000&size=150', 1, '1', 0),
(52, 'Myrtice Bednar', 'dariana.huels@hotmail.com', NULL, '$2y$12$cyIOXBGpvA/FrGvMkmP/x.6LQ1vr4Xc2mTlFij7HZdFN9mKs1jmlm', NULL, NULL, NULL, NULL, '2024-12-02 17:32:10', '2024-12-02 17:32:10', 'Doctor', NULL, 0, '2024-12-02 17:32:10', 'https://ui-avatars.com/api/?name=Myrtice+Bednar&background=118dff&color=ffffff&size=150', 1, '1', 0),
(53, 'Freda Waters', 'krunte@hotmail.com', NULL, '$2y$12$TjnsG7Kwnp8eBU.dHh00zunRa.crD2IMUqFtPkxaKAB.BV0pmSrhS', NULL, NULL, NULL, NULL, '2024-12-02 17:32:10', '2024-12-02 17:32:10', 'Doctor', NULL, 0, '2024-12-02 17:32:10', 'https://ui-avatars.com/api/?name=Freda+Waters&background=316f32&color=ffffff&size=150', 1, '1', 0),
(54, 'Rhea Luettgen', 'danielle55@kling.info', NULL, '$2y$12$B52vudzGTyplOkmnQcnUXOet7iqxUbtK.H7vTt5RD88itAcHEmkq.', NULL, NULL, NULL, NULL, '2024-12-02 17:32:10', '2024-12-02 17:32:10', 'Doctor', NULL, 0, '2024-12-02 17:32:10', 'https://ui-avatars.com/api/?name=Rhea+Luettgen&background=19e0eb&color=000000&size=150', 1, '1', 0),
(55, 'Lolita Rath', 'daron.morar@mayert.biz', NULL, '$2y$12$TuB5LueuoCa5WEi8mmkR6eu0OSDxdGyqUF7GaXFXwjIggutiACBfO', NULL, NULL, NULL, NULL, '2024-12-02 17:32:11', '2024-12-02 17:32:11', 'Doctor', NULL, 0, '2024-12-02 17:32:11', 'https://ui-avatars.com/api/?name=Lolita+Rath&background=cfb6a5&color=000000&size=150', 1, '1', 0),
(56, 'Christian Stamm', 'alfreda54@wiza.net', NULL, '$2y$12$MLc37NSePsVjbGTnAl3exuXEwPYoE1X7W9gZHSGauuehgwjmYyuw2', NULL, NULL, NULL, NULL, '2024-12-02 17:32:11', '2024-12-02 17:32:11', 'Doctor', NULL, 0, '2024-12-02 17:32:11', 'https://ui-avatars.com/api/?name=Christian+Stamm&background=f6a670&color=000000&size=150', 1, '1', 0),
(57, 'Dennis Wehner PhD', 'jamaal.konopelski@strosin.com', NULL, '$2y$12$zvYtSuQZeU1nZQtudnssz.ucFurw7TMC02ZPbDEO1.nMTSkK6EzEy', NULL, NULL, NULL, NULL, '2024-12-02 17:32:11', '2024-12-02 17:32:11', 'Doctor', NULL, 0, '2024-12-02 17:32:11', 'https://ui-avatars.com/api/?name=Dennis+Wehner+PhD&background=2931ba&color=ffffff&size=150', 1, '1', 0),
(58, 'Katelyn Streich II', 'reta57@gmail.com', NULL, '$2y$12$RyydRHx.Bja.ysD5ExRLk.iJG.QijF53Y/lLGiLZuS65q9aedTlG2', NULL, NULL, NULL, NULL, '2024-12-02 17:32:11', '2024-12-02 17:32:11', 'Doctor', NULL, 0, '2024-12-02 17:32:11', 'https://ui-avatars.com/api/?name=Katelyn+Streich+II&background=d8c8fd&color=000000&size=150', 1, '1', 0),
(59, 'Vallie Simonis', 'alfonzo.mclaughlin@gmail.com', NULL, '$2y$12$QVgzJsIENvi7QnDHgq9G6upuwIkkNrn0vL70QLHKR47JODESf85We', NULL, NULL, NULL, NULL, '2024-12-02 17:32:11', '2024-12-02 17:32:11', 'Doctor', NULL, 0, '2024-12-02 17:32:11', 'https://ui-avatars.com/api/?name=Vallie+Simonis&background=e2e44c&color=000000&size=150', 1, '1', 0),
(60, 'Mr. Ali Schmidt', 'dstanton@hotmail.com', NULL, '$2y$12$mZ.lQQdJgmPv6lC2TIAipuSasZfQm4ZsGNHLcUm7oZczv1KpF5CMa', NULL, NULL, NULL, NULL, '2024-12-02 17:32:12', '2024-12-02 17:32:12', 'Doctor', NULL, 0, '2024-12-02 17:32:12', 'https://ui-avatars.com/api/?name=Mr.+Ali+Schmidt&background=82fdd6&color=000000&size=150', 1, '1', 0),
(61, 'Jordon Lind', 'vernie.wehner@stoltenberg.com', NULL, '$2y$12$.P1iAJRz2tEbM0ggkZZdMOovhOjUagTqqbTDHndTiO5IMaWSuBkH.', NULL, NULL, NULL, NULL, '2024-12-02 17:32:12', '2024-12-02 17:32:12', 'Doctor', NULL, 0, '2024-12-02 17:32:12', 'https://ui-avatars.com/api/?name=Jordon+Lind&background=d2cf52&color=000000&size=150', 1, '1', 0),
(62, 'Flo Hauck', 'skuphal@hotmail.com', NULL, '$2y$12$Ha7v5eBlXN2iHgUNTxHFp.bJgRohC72oZn0KWN8TzqxBYtnlQ4U1G', NULL, NULL, NULL, NULL, '2024-12-02 17:32:12', '2024-12-02 17:32:12', 'Doctor', NULL, 0, '2024-12-02 17:32:12', 'https://ui-avatars.com/api/?name=Flo+Hauck&background=e1c468&color=000000&size=150', 1, '1', 0),
(63, 'Keaton Parisian V', 'runte.elyse@yahoo.com', NULL, '$2y$12$FCS2.ItU57l.bOD6.Brv.O6aPTaiqSlJ/MI9wwspbPAxjMfFUll2q', NULL, NULL, NULL, NULL, '2024-12-02 17:32:12', '2024-12-02 17:32:12', 'Doctor', NULL, 0, '2024-12-02 17:32:12', 'https://ui-avatars.com/api/?name=Keaton+Parisian+V&background=bf79cc&color=000000&size=150', 1, '1', 0),
(64, 'Orion Beer', 'doyle.jewell@koch.com', NULL, '$2y$12$MXC1IWjmF6EmsS7tBUGHa.Kk7ua2iqPx9DxTiMWRIN0QbJTslKtoO', NULL, NULL, NULL, NULL, '2024-12-02 17:32:12', '2024-12-02 17:32:12', 'Doctor', NULL, 0, '2024-12-02 17:32:12', 'https://ui-avatars.com/api/?name=Orion+Beer&background=810250&color=ffffff&size=150', 1, '1', 0),
(65, 'Mr. Steve Hane', 'kessler.amina@considine.com', NULL, '$2y$12$kqjR.avdixwI0AwG7EYhLePMcewYZyyHqnDpAW8RsW4Z6x9NhrWXO', NULL, NULL, NULL, NULL, '2024-12-02 17:32:13', '2024-12-02 17:32:13', 'Doctor', NULL, 0, '2024-12-02 17:32:13', 'https://ui-avatars.com/api/?name=Mr.+Steve+Hane&background=8a04cd&color=ffffff&size=150', 1, '1', 0),
(66, 'Samson Hane IV', 'nicolas.berry@hotmail.com', NULL, '$2y$12$fq3T.NBNlWEMA42PvhCfJ.4.P1eimB2OH8Mhpj1bWTmPaRixdqF6W', NULL, NULL, NULL, NULL, '2024-12-02 17:32:13', '2024-12-02 17:32:13', 'Doctor', NULL, 0, '2024-12-02 17:32:13', 'https://ui-avatars.com/api/?name=Samson+Hane+IV&background=f98d4f&color=000000&size=150', 1, '1', 0),
(70, 'Naihati Pathology', 'naihati_pathology@gmail.com', NULL, '$2y$12$8RtdX8AL/XjirhzCdE/y2.QgDQkUJWVTLIbQgVBESZ3/rBB5F22n6', NULL, NULL, NULL, NULL, '2025-02-08 18:46:12', '2025-02-08 18:46:12', 'Laboratory', NULL, 0, '2025-02-08 18:46:12', 'https://ui-avatars.com/api/?name=Naihati+Pathology&background=20bd7b&color=000000&size=150', 1, '1', 0),
(71, 'Soumitra Sarkar', 'ss@gmail.com', NULL, '$2y$12$HhaSFwyMgMJgZGGndth17eYBNaaw0PJBv006VL.exL7HOVU93EEym', NULL, NULL, NULL, '6NrVabayqIeWemeLphWguaCFAIvB0j74Jxy4QlfIVTQxXNYf8KxpskMuNXUt', '2025-03-09 11:53:04', '2025-03-16 17:28:50', 'Assigner', '9658-996-366', 2, '2025-03-16 17:28:50', 'https://ui-avatars.com/api/?name=Soumitra+Sarkar&background=a5acc5&color=000000&size=150', 1, '0', 0),
(72, 'Jamil Sekh', 'sk@gmail.com', NULL, '$2y$12$iE9JDyDLdFIi.Z6pFf4V2.6APfbS20H7qkka.s9ZbEA5ID0vas7Pa', NULL, NULL, NULL, 'WU2GY08N4yHXO4Ru8mkN5X3Or6pkeCEF8tsWMVWaPHFtek3KOyQSzOltYV5x', '2025-03-18 18:28:19', '2025-03-18 19:09:44', 'Assigner', '9865-330-256', 16, '2025-03-22 06:03:22', 'https://ui-avatars.com/api/?name=Jamil+Sekh&background=219a42&color=ffffff&size=150', 1, '0', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_documents`
--

CREATE TABLE `user_documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `document_type` varchar(255) NOT NULL,
  `document_number` varchar(255) NOT NULL,
  `document_front_image` varchar(255) NOT NULL,
  `document_back_image` varchar(255) DEFAULT NULL,
  `document_start_date` date DEFAULT NULL,
  `document_end_date` date DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT 0,
  `approved_by` int(11) NOT NULL DEFAULT 0,
  `approved_on` date DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_documents`
--

INSERT INTO `user_documents` (`id`, `document_type`, `document_number`, `document_front_image`, `document_back_image`, `document_start_date`, `document_end_date`, `user_id`, `status`, `approved_by`, `approved_on`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Driving Licence', 'D89658965D', 'uploads/Centre/Balaji_Diagnostic_Centre_Halisahar_Unit_2/6713e8bc1a6c6.jpg', 'uploads/Centre/Balaji_Diagnostic_Centre_Halisahar_Unit_2/6713e8bc1a73f.jpg', NULL, NULL, 2, 0, 0, NULL, NULL, '2024-10-19 17:13:32', '2024-10-19 17:13:32'),
(2, 'DL New Format', '99DOJ89FF', 'uploads/Centre/Balaji_Diagnostic_Centre_Halisahar_Unit_2/6714ba0bb8baa.jpg', 'uploads/Centre/Balaji_Diagnostic_Centre_Halisahar_Unit_2/6714ba0bb8c20.jpg', NULL, NULL, 2, 1, 1, '2024-10-20', NULL, '2024-10-20 08:06:35', '2024-10-20 08:06:35');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_menus`
--
ALTER TABLE `admin_menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_menu_roles`
--
ALTER TABLE `admin_menu_roles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_menu_roles_admin_menu_id_foreign` (`admin_menu_id`),
  ADD KEY `admin_menu_roles_role_id_foreign` (`role_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `case_studies`
--
ALTER TABLE `case_studies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `case_studies_laboratory_id_foreign` (`laboratory_id`),
  ADD KEY `case_studies_patient_id_foreign` (`patient_id`),
  ADD KEY `case_studies_doctor_id_foreign` (`doctor_id`),
  ADD KEY `case_studies_qc_id_foreign` (`qc_id`),
  ADD KEY `case_studies_assigner_id_foreign` (`assigner_id`),
  ADD KEY `case_studies_study_status_id_foreign` (`study_status_id`),
  ADD KEY `case_studies_modality_id_foreign` (`modality_id`),
  ADD KEY `case_studies_added_by_foreign` (`added_by`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `doctors_user_id_foreign` (`user_id`);

--
-- Indexes for table `doctor_logs`
--
ALTER TABLE `doctor_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `doctor_logs_doctor_id_foreign` (`doctor_id`),
  ADD KEY `doctor_logs_user_id_foreign` (`user_id`);

--
-- Indexes for table `doctor_modalities`
--
ALTER TABLE `doctor_modalities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `doctor_modalities_doctor_id_foreign` (`doctor_id`),
  ADD KEY `doctor_modalities_modality_id_foreign` (`modality_id`);

--
-- Indexes for table `doc_form_field_values`
--
ALTER TABLE `doc_form_field_values`
  ADD PRIMARY KEY (`id`),
  ADD KEY `doc_form_field_values_form_field_id_foreign` (`form_field_id`),
  ADD KEY `doc_form_field_values_doctor_id_foreign` (`doctor_id`),
  ADD KEY `doc_form_field_values_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `form_fields`
--
ALTER TABLE `form_fields`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `form_field_options`
--
ALTER TABLE `form_field_options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `form_field_options_form_field_id_foreign` (`form_field_id`);

--
-- Indexes for table `form_field_roles`
--
ALTER TABLE `form_field_roles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `form_field_roles_role_id_foreign` (`role_id`),
  ADD KEY `form_field_roles_form_field_id_foreign` (`form_field_id`);

--
-- Indexes for table `form_field_values`
--
ALTER TABLE `form_field_values`
  ADD PRIMARY KEY (`id`),
  ADD KEY `form_field_values_form_field_id_foreign` (`form_field_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `laboratories`
--
ALTER TABLE `laboratories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `laboratories_user_id_foreign` (`user_id`);

--
-- Indexes for table `laboratory_logs`
--
ALTER TABLE `laboratory_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `laboratory_logs_laboratorie_id_foreign` (`laboratorie_id`),
  ADD KEY `laboratory_logs_user_id_foreign` (`user_id`);

--
-- Indexes for table `lab_black_listed_doctors`
--
ALTER TABLE `lab_black_listed_doctors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lab_black_listed_doctors_laboratorie_id_foreign` (`laboratorie_id`),
  ADD KEY `lab_black_listed_doctors_doctor_id_foreign` (`doctor_id`);

--
-- Indexes for table `lab_form_field_values`
--
ALTER TABLE `lab_form_field_values`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lab_form_field_values_form_field_id_foreign` (`form_field_id`),
  ADD KEY `lab_form_field_values_laboratorie_id_foreign` (`laboratorie_id`),
  ADD KEY `lab_form_field_values_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `lab_modalities`
--
ALTER TABLE `lab_modalities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lab_modalities_laboratory_id_foreign` (`laboratory_id`),
  ADD KEY `lab_modalities_modality_id_foreign` (`modality_id`);

--
-- Indexes for table `lab_preferred_doctors`
--
ALTER TABLE `lab_preferred_doctors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lab_preferred_doctors_laboratorie_id_foreign` (`laboratorie_id`),
  ADD KEY `lab_preferred_doctors_doctor_id_foreign` (`doctor_id`),
  ADD KEY `lab_preferred_doctors_modality_id_foreign` (`modality_id`);

--
-- Indexes for table `login_securities`
--
ALTER TABLE `login_securities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `modalities`
--
ALTER TABLE `modalities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `modality_study_layouts`
--
ALTER TABLE `modality_study_layouts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `modality_study_layouts_study_type_id_foreign` (`study_type_id`),
  ADD KEY `modality_study_layouts_created_by_foreign` (`created_by`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_auth_codes_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `patients_patient_id_unique` (`patient_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indexes for table `role_users`
--
ALTER TABLE `role_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_users_role_id_foreign` (`role_id`),
  ADD KEY `role_users_user_id_foreign` (`user_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `studies`
--
ALTER TABLE `studies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `studies_study_type_id_foreign` (`study_type_id`),
  ADD KEY `studies_case_study_id_foreign` (`case_study_id`);

--
-- Indexes for table `study_images`
--
ALTER TABLE `study_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `study_images_study_id_foreign` (`study_id`);

--
-- Indexes for table `study_statuses`
--
ALTER TABLE `study_statuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `study_types`
--
ALTER TABLE `study_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `study_types_modality_id_foreign` (`modality_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_documents`
--
ALTER TABLE `user_documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_documents_user_id_foreign` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_menus`
--
ALTER TABLE `admin_menus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `admin_menu_roles`
--
ALTER TABLE `admin_menu_roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `case_studies`
--
ALTER TABLE `case_studies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `doctor_logs`
--
ALTER TABLE `doctor_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `doctor_modalities`
--
ALTER TABLE `doctor_modalities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=165;

--
-- AUTO_INCREMENT for table `doc_form_field_values`
--
ALTER TABLE `doc_form_field_values`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `form_fields`
--
ALTER TABLE `form_fields`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `form_field_options`
--
ALTER TABLE `form_field_options`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `form_field_roles`
--
ALTER TABLE `form_field_roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `form_field_values`
--
ALTER TABLE `form_field_values`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `laboratories`
--
ALTER TABLE `laboratories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `laboratory_logs`
--
ALTER TABLE `laboratory_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `lab_black_listed_doctors`
--
ALTER TABLE `lab_black_listed_doctors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `lab_form_field_values`
--
ALTER TABLE `lab_form_field_values`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `lab_modalities`
--
ALTER TABLE `lab_modalities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `lab_preferred_doctors`
--
ALTER TABLE `lab_preferred_doctors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `login_securities`
--
ALTER TABLE `login_securities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `modalities`
--
ALTER TABLE `modalities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `modality_study_layouts`
--
ALTER TABLE `modality_study_layouts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `role_users`
--
ALTER TABLE `role_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `studies`
--
ALTER TABLE `studies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `study_images`
--
ALTER TABLE `study_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `study_statuses`
--
ALTER TABLE `study_statuses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `study_types`
--
ALTER TABLE `study_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `user_documents`
--
ALTER TABLE `user_documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin_menu_roles`
--
ALTER TABLE `admin_menu_roles`
  ADD CONSTRAINT `admin_menu_roles_admin_menu_id_foreign` FOREIGN KEY (`admin_menu_id`) REFERENCES `admin_menus` (`id`),
  ADD CONSTRAINT `admin_menu_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);

--
-- Constraints for table `case_studies`
--
ALTER TABLE `case_studies`
  ADD CONSTRAINT `case_studies_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `case_studies_assigner_id_foreign` FOREIGN KEY (`assigner_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `case_studies_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`),
  ADD CONSTRAINT `case_studies_laboratory_id_foreign` FOREIGN KEY (`laboratory_id`) REFERENCES `laboratories` (`id`),
  ADD CONSTRAINT `case_studies_modality_id_foreign` FOREIGN KEY (`modality_id`) REFERENCES `modalities` (`id`),
  ADD CONSTRAINT `case_studies_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`),
  ADD CONSTRAINT `case_studies_qc_id_foreign` FOREIGN KEY (`qc_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `case_studies_study_status_id_foreign` FOREIGN KEY (`study_status_id`) REFERENCES `study_statuses` (`id`);

--
-- Constraints for table `doctors`
--
ALTER TABLE `doctors`
  ADD CONSTRAINT `doctors_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `doctor_logs`
--
ALTER TABLE `doctor_logs`
  ADD CONSTRAINT `doctor_logs_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`),
  ADD CONSTRAINT `doctor_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `doctor_modalities`
--
ALTER TABLE `doctor_modalities`
  ADD CONSTRAINT `doctor_modalities_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `doctor_modalities_modality_id_foreign` FOREIGN KEY (`modality_id`) REFERENCES `modalities` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `doc_form_field_values`
--
ALTER TABLE `doc_form_field_values`
  ADD CONSTRAINT `doc_form_field_values_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`),
  ADD CONSTRAINT `doc_form_field_values_form_field_id_foreign` FOREIGN KEY (`form_field_id`) REFERENCES `form_fields` (`id`),
  ADD CONSTRAINT `doc_form_field_values_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `form_field_options`
--
ALTER TABLE `form_field_options`
  ADD CONSTRAINT `form_field_options_form_field_id_foreign` FOREIGN KEY (`form_field_id`) REFERENCES `form_fields` (`id`);

--
-- Constraints for table `form_field_roles`
--
ALTER TABLE `form_field_roles`
  ADD CONSTRAINT `form_field_roles_form_field_id_foreign` FOREIGN KEY (`form_field_id`) REFERENCES `form_fields` (`id`),
  ADD CONSTRAINT `form_field_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);

--
-- Constraints for table `form_field_values`
--
ALTER TABLE `form_field_values`
  ADD CONSTRAINT `form_field_values_form_field_id_foreign` FOREIGN KEY (`form_field_id`) REFERENCES `form_fields` (`id`);

--
-- Constraints for table `laboratories`
--
ALTER TABLE `laboratories`
  ADD CONSTRAINT `laboratories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `laboratory_logs`
--
ALTER TABLE `laboratory_logs`
  ADD CONSTRAINT `laboratory_logs_laboratorie_id_foreign` FOREIGN KEY (`laboratorie_id`) REFERENCES `laboratories` (`id`),
  ADD CONSTRAINT `laboratory_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `lab_black_listed_doctors`
--
ALTER TABLE `lab_black_listed_doctors`
  ADD CONSTRAINT `lab_black_listed_doctors_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`),
  ADD CONSTRAINT `lab_black_listed_doctors_laboratorie_id_foreign` FOREIGN KEY (`laboratorie_id`) REFERENCES `laboratories` (`id`);

--
-- Constraints for table `lab_form_field_values`
--
ALTER TABLE `lab_form_field_values`
  ADD CONSTRAINT `lab_form_field_values_form_field_id_foreign` FOREIGN KEY (`form_field_id`) REFERENCES `form_fields` (`id`),
  ADD CONSTRAINT `lab_form_field_values_laboratorie_id_foreign` FOREIGN KEY (`laboratorie_id`) REFERENCES `laboratories` (`id`),
  ADD CONSTRAINT `lab_form_field_values_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `lab_modalities`
--
ALTER TABLE `lab_modalities`
  ADD CONSTRAINT `lab_modalities_laboratory_id_foreign` FOREIGN KEY (`laboratory_id`) REFERENCES `laboratories` (`id`),
  ADD CONSTRAINT `lab_modalities_modality_id_foreign` FOREIGN KEY (`modality_id`) REFERENCES `modalities` (`id`);

--
-- Constraints for table `lab_preferred_doctors`
--
ALTER TABLE `lab_preferred_doctors`
  ADD CONSTRAINT `lab_preferred_doctors_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`),
  ADD CONSTRAINT `lab_preferred_doctors_laboratorie_id_foreign` FOREIGN KEY (`laboratorie_id`) REFERENCES `laboratories` (`id`),
  ADD CONSTRAINT `lab_preferred_doctors_modality_id_foreign` FOREIGN KEY (`modality_id`) REFERENCES `modalities` (`id`);

--
-- Constraints for table `modality_study_layouts`
--
ALTER TABLE `modality_study_layouts`
  ADD CONSTRAINT `modality_study_layouts_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `modality_study_layouts_study_type_id_foreign` FOREIGN KEY (`study_type_id`) REFERENCES `study_types` (`id`);

--
-- Constraints for table `role_users`
--
ALTER TABLE `role_users`
  ADD CONSTRAINT `role_users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`),
  ADD CONSTRAINT `role_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `studies`
--
ALTER TABLE `studies`
  ADD CONSTRAINT `studies_case_study_id_foreign` FOREIGN KEY (`case_study_id`) REFERENCES `case_studies` (`id`),
  ADD CONSTRAINT `studies_study_type_id_foreign` FOREIGN KEY (`study_type_id`) REFERENCES `study_types` (`id`);

--
-- Constraints for table `study_images`
--
ALTER TABLE `study_images`
  ADD CONSTRAINT `study_images_study_id_foreign` FOREIGN KEY (`study_id`) REFERENCES `studies` (`id`);

--
-- Constraints for table `study_types`
--
ALTER TABLE `study_types`
  ADD CONSTRAINT `study_types_modality_id_foreign` FOREIGN KEY (`modality_id`) REFERENCES `modalities` (`id`);

--
-- Constraints for table `user_documents`
--
ALTER TABLE `user_documents`
  ADD CONSTRAINT `user_documents_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
