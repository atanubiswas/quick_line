-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 25, 2024 at 07:50 AM
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
CREATE DATABASE IF NOT EXISTS `quick_line` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `quick_line`;

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
(2, 'Centre', NULL, 'fa-flask', '#', 0, 0, NULL, NULL),
(3, 'Add New Centre', 'admin/add-laboratory', 'fa-file-import', 'admin.addLab', 2, 1, NULL, NULL),
(4, 'View Centre', 'admin/view-laboratory', 'fa-list-alt', 'admin.viewLab', 2, 2, NULL, NULL),
(5, 'Users', NULL, 'fa-user', '#', 0, 0, NULL, NULL),
(6, 'Add New Users', 'admin/add-user', 'fa-file-import', 'admin.addUser', 5, 1, NULL, NULL),
(7, 'View Users', 'admin/view-users', 'fa-list-alt', 'admin.viewUser', 5, 2, NULL, NULL);

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
(1, 1, 1, 1, NULL, NULL),
(2, 2, 1, 2, NULL, NULL),
(3, 5, 1, 3, NULL, NULL);

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
(5, 'modality', 'Modality', NULL, 0, 'multiselect'),
(6, 'account_department_number', 'Accounts Department Phone Number', NULL, 0, 'phone'),
(7, 'installation_date', 'Installation Date', NULL, 0, 'date'),
(8, 'special_suggestion', 'Special Suggestion', NULL, 0, 'textarea');

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
(8, 3, 8);

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
(1, 'Balaji Diagnostic Centre Halisahar Unit 2', 'balajihalisahar@gmail.com', 'Kancharapara', 2, 1, '9896-587-897', NULL, '2024-10-02 17:47:27', '2024-10-20 08:45:57'),
(2, 'Naihati Diagnostics', 'naihati_diagnostics@gmail.com', 'Naihati', 3, 1, '8978-965-880', NULL, '2024-10-05 14:17:09', '2024-10-20 08:52:21');

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
(32, 'active', 2, 'The Centre, Naihati Diagnostics was Active by Pranab Karmakar on 20th of Oct, 2024 at 2:22 PM', 1, NULL, NULL, NULL, '2024-10-20 08:52:21', '2024-10-20 08:52:21');

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
(16, 8, 'Provide report ASAP', 2, 1, '2024-10-05 18:54:07', '2024-10-05 18:54:07');

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
(1, 1, 0, '5E7QTSEKHSAEPW7Y', '2024-10-20 18:40:55', '2024-10-22 18:11:58');

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
(30, '2024_01_21_053316_create_user_documents_table', 14);

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
(5, 'Manager', NULL, NULL);

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
(5, 2, 5, '2024-10-23 19:23:42', '2024-10-23 19:23:42');

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
  `status` smallint(6) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `remember_token`, `created_at`, `updated_at`, `access_type`, `mobile_number`, `login_count`, `last_login_at`, `user_image`, `status`) VALUES
(1, 'Pranab Karmakar', 'admin@gmail.com', NULL, '$2y$12$vOOotr9uG2G3bR6SvyxMAuOVd9UwDda6fW4HEoCz.jd4QpAsDgNY6', NULL, NULL, NULL, 'kUhjBpmBJ9Qj1chWBmUN60vyhrgXKepeEuFVpyv6AyD1bUGl8YMASOPpyrye', NULL, '2024-10-22 18:11:48', 'admin', NULL, 20, '2024-10-23 18:48:41', 'https://ui-avatars.com/api/?name=Pranab+Karmakar&background=2ff8ff&color=000000&size=150', 1),
(2, 'Balaji Diagnostic Centre Halisahar Unit 2', 'balajihalisahar@gmail.com', NULL, '$2y$12$iBVKrz57splYQmgyeDS1leD3Kb9j13oMMGIlBVv57rH61mVMwfZ.u', NULL, NULL, NULL, NULL, '2024-10-02 17:47:27', '2024-10-20 08:45:57', 'user', NULL, 0, '2024-10-20 08:45:57', 'https://ui-avatars.com/api/?name=balaji+diagnostic+centre+halisahar&background=fc7a60&color=000000&size=150', 1),
(3, 'Naihati Diagnostics', 'naihati_diagnostics@gmail.com', NULL, '$2y$12$KGps2HKllObMQBLUA/fEC.2XmGWSIL65J5GE7FGGVks62TvmNE7XW', NULL, NULL, NULL, NULL, '2024-10-05 14:17:09', '2024-10-20 08:52:21', 'user', NULL, 0, '2024-10-20 08:52:21', 'https://ui-avatars.com/api/?name=Naihati+Diagnostics&background=fb5350&color=000000&size=150', 1),
(4, 'Rohit Saha', 'rohit_saha@gmail.com', NULL, '$2y$12$Nv158LA2bSXT20duOrNiT.u2EXQnMXJliM2.CmvzI/It/RKYWzKK.', NULL, NULL, NULL, NULL, '2024-10-23 19:18:36', '2024-10-23 19:18:36', 'Manager', '9865-321-100', 0, '2024-10-23 19:18:36', 'https://ui-avatars.com/api/?name=Rohit+Saha&background=0cc88d&color=000000&size=150', 1),
(5, 'Poulomi Biswas', 'pbiswas@gmail.com', NULL, '$2y$12$Qrpt0SlCHngYOmS09BGXLeuo/FN1jwUFN5GeOOIgwk5IaV0XXQwWy', NULL, NULL, NULL, NULL, '2024-10-23 19:23:42', '2024-10-23 19:23:42', 'Quality Controller', '9632-512-022', 0, '2024-10-23 19:23:42', 'https://ui-avatars.com/api/?name=Poulomi+Biswas&background=b96ed4&color=000000&size=150', 1);

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
-- Indexes for table `lab_form_field_values`
--
ALTER TABLE `lab_form_field_values`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lab_form_field_values_form_field_id_foreign` (`form_field_id`),
  ADD KEY `lab_form_field_values_laboratorie_id_foreign` (`laboratorie_id`),
  ADD KEY `lab_form_field_values_updated_by_foreign` (`updated_by`);

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `admin_menu_roles`
--
ALTER TABLE `admin_menu_roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `form_fields`
--
ALTER TABLE `form_fields`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `form_field_options`
--
ALTER TABLE `form_field_options`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `form_field_roles`
--
ALTER TABLE `form_field_roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `laboratory_logs`
--
ALTER TABLE `laboratory_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `lab_form_field_values`
--
ALTER TABLE `lab_form_field_values`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `login_securities`
--
ALTER TABLE `login_securities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

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
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `role_users`
--
ALTER TABLE `role_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
-- Constraints for table `lab_form_field_values`
--
ALTER TABLE `lab_form_field_values`
  ADD CONSTRAINT `lab_form_field_values_form_field_id_foreign` FOREIGN KEY (`form_field_id`) REFERENCES `form_fields` (`id`),
  ADD CONSTRAINT `lab_form_field_values_laboratorie_id_foreign` FOREIGN KEY (`laboratorie_id`) REFERENCES `laboratories` (`id`),
  ADD CONSTRAINT `lab_form_field_values_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `role_users`
--
ALTER TABLE `role_users`
  ADD CONSTRAINT `role_users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`),
  ADD CONSTRAINT `role_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `user_documents`
--
ALTER TABLE `user_documents`
  ADD CONSTRAINT `user_documents_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
