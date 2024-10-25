-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 07, 2024 at 04:49 PM
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
-- Database: `quickOnMed`
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
(2, 'Doctor', NULL, 'fa-user-md', '#', 0, 0, NULL, NULL),
(3, 'Add New Doctor', 'admin/add-doctor', 'fa-file-import', 'admin.addDoctor', 2, 1, NULL, NULL),
(4, 'View Doctor', 'admin/view-doctor', 'fa-list-alt', 'admin.viewDoctor', 2, 2, NULL, NULL),
(5, 'Laboratory', NULL, 'fa-flask', '#', 0, 0, NULL, NULL),
(6, 'Add New Lab', 'admin/add-laboratory', 'fa-file-import', 'admin.addLab', 5, 1, NULL, NULL),
(7, 'View Lab', 'admin/view-laboratory', 'fa-list-alt', 'admin.viewLab', 5, 2, NULL, NULL),
(8, 'Collector', NULL, 'fa-user-nurse', '#', 0, 0, NULL, NULL),
(9, 'Add New Collector', 'admin/add-collector', 'fa-file-import', 'admin.addCollector', 8, 1, NULL, NULL),
(10, 'View Collector', 'admin/view-collector', 'fa-list-alt', 'admin.viewCollector', 8, 2, NULL, NULL),
(11, 'Coupon', NULL, 'fa-receipt', '#', 0, 0, NULL, NULL),
(12, 'Add New Coupon', 'admin/add-coupon', 'fa-file-import', 'admin.addCoupon', 11, 1, NULL, NULL),
(13, 'View Coupon', 'admin/view-coupon', 'fa-list-alt', 'admin.viewCoupon', 11, 2, NULL, NULL),
(14, 'Notification', NULL, 'fa-bell', '#', 0, 0, NULL, NULL),
(15, 'Add New Notifications', 'admin/add-notification', 'fa-file-import', 'admin.addNotification', 14, 1, NULL, NULL),
(16, 'Documents', NULL, 'fa-id-card', '#', 0, 0, NULL, NULL),
(17, 'Add New Document', 'admin/add-document', 'fa-file-import', 'admin.addDocument', 16, 1, NULL, NULL),
(18, 'View Uploaded Documents', 'admin/view-document', 'fa-list-alt', 'admin.viewDocument', 16, 2, NULL, NULL),
(19, 'Pathology Test', NULL, 'fa-vials', '#', 0, 0, NULL, NULL),
(20, 'Add Pathology Test', 'admin/add-pathology-test', 'fa-file-import', 'admin.addPathologyTest', 19, 1, NULL, NULL),
(21, 'View Pathology Test', 'admin/view-pathology-test', 'fa-list-alt', 'admin.viewPathologyTest', 19, 2, NULL, NULL),
(22, 'Pathology Test', NULL, 'fa-vials', '#', 0, 0, NULL, NULL),
(23, 'View Pathology Test', 'admin/view-pathology-test', 'fa-list-alt', 'admin.viewPathologyTest', 22, 1, NULL, NULL),
(24, 'Create Package', 'admin/add-pathology-test-package', 'fa-file-import', 'admin.addPathologyTestPackage', 22, 2, NULL, NULL),
(25, 'Pathology Test', NULL, 'fa-vials', '#', 0, 0, NULL, NULL),
(26, 'View Pathology Test', 'admin/view-pathology-test', 'fa-list-alt', 'admin.viewPathologyTest', 25, 1, NULL, NULL),
(27, 'View Wallet', 'admin/view-wallet', 'fa-wallet', 'admin.viewWallet', 0, 0, NULL, NULL),
(28, 'View Laboratory', 'admin/view-laboratory', 'fa-flask', 'admin.viewLab', 0, 0, NULL, NULL),
(29, 'View Applied Collector', 'admin/view-applied-collector', 'fa-user-nurse', 'admin.appliedCollector', 0, 0, NULL, NULL);

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
(2, 1, 4, 1, NULL, NULL),
(3, 2, 1, 3, NULL, NULL),
(4, 5, 1, 2, NULL, NULL),
(5, 8, 1, 4, NULL, NULL),
(6, 11, 1, 5, NULL, NULL),
(7, 14, 1, 6, NULL, NULL),
(8, 16, 4, 2, NULL, NULL),
(9, 19, 1, 7, NULL, NULL),
(10, 22, 4, 3, NULL, NULL),
(11, 16, 6, 2, NULL, NULL),
(12, 25, 6, 3, NULL, NULL),
(13, 27, 6, 5, NULL, NULL),
(14, 1, 6, 1, NULL, NULL),
(15, 28, 6, 4, NULL, NULL),
(16, 29, 4, 4, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `collectors`
--

CREATE TABLE `collectors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `collector_name` varchar(255) NOT NULL,
  `collector_login_email` varchar(255) NOT NULL,
  `collector_primary_location` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT 1,
  `deactivated_by` int(11) NOT NULL DEFAULT 0,
  `deactivated_on` datetime DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `collectors`
--

INSERT INTO `collectors` (`id`, `collector_name`, `collector_login_email`, `collector_primary_location`, `user_id`, `status`, `deactivated_by`, `deactivated_on`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Ratan Konar', 'c@gm', 'Sealdah', 19, 1, 0, NULL, NULL, '2024-01-29 19:53:55', '2024-03-11 12:12:19'),
(2, 'Swapan Kumar', 'skumar@gmail.com', 'Kolkata', 21, 1, 0, NULL, NULL, '2024-03-16 15:12:45', '2024-03-16 15:12:45');

-- --------------------------------------------------------

--
-- Table structure for table `collector_form_field_values`
--

CREATE TABLE `collector_form_field_values` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `form_field_id` bigint(20) UNSIGNED NOT NULL,
  `value` varchar(255) DEFAULT NULL,
  `collector_id` bigint(20) UNSIGNED NOT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `collector_form_field_values`
--

INSERT INTO `collector_form_field_values` (`id`, `form_field_id`, `value`, `collector_id`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 13, 'male', 1, 1, '2024-03-03 03:31:43', '2024-03-03 12:08:01'),
(2, 13, 'male', 2, 1, '2024-03-16 15:12:45', '2024-03-16 15:12:45');

-- --------------------------------------------------------

--
-- Table structure for table `collector_lab_associations`
--

CREATE TABLE `collector_lab_associations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `laboratories_id` bigint(20) UNSIGNED NOT NULL,
  `collector_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('applied','processed','approved','rejected') NOT NULL DEFAULT 'applied',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `collector_lab_associations`
--

INSERT INTO `collector_lab_associations` (`id`, `laboratories_id`, `collector_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 13, 1, 'applied', '2024-04-11 19:57:58', '2024-04-11 19:57:58'),
(2, 8, 1, 'applied', '2024-04-11 19:57:59', '2024-04-11 19:57:59'),
(3, 12, 1, 'applied', '2024-04-11 19:58:00', '2024-04-11 19:58:00'),
(4, 9, 1, 'applied', '2024-04-11 19:58:01', '2024-04-11 19:58:01'),
(5, 8, 1, 'approved', '2024-04-11 19:58:01', '2024-04-19 19:01:36'),
(6, 1, 1, 'approved', '2024-04-11 19:58:02', '2024-06-30 17:27:45'),
(7, 5, 2, 'approved', '2024-04-12 18:59:22', '2024-04-21 09:06:26'),
(8, 9, 2, 'applied', '2024-04-12 19:29:03', '2024-04-12 19:29:03'),
(9, 12, 2, 'applied', '2024-04-12 19:31:11', '2024-04-12 19:31:11'),
(10, 8, 2, 'applied', '2024-04-27 10:40:10', '2024-04-27 10:40:10');

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `object_type` varchar(255) NOT NULL,
  `vendor_id` int(11) DEFAULT NULL,
  `code` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `amount` double(12,2) NOT NULL,
  `minimum_spend` double(12,2) DEFAULT NULL,
  `maximum_spend` double(12,2) DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `use_limit` int(11) DEFAULT NULL,
  `same_ip_limit` int(11) DEFAULT NULL,
  `use_limit_per_user` int(11) DEFAULT NULL,
  `use_device` varchar(255) DEFAULT NULL,
  `multiple_use` enum('yes','no') NOT NULL DEFAULT 'no',
  `total_use` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `object_type`, `vendor_id`, `code`, `type`, `amount`, `minimum_spend`, `maximum_spend`, `start_date`, `end_date`, `use_limit`, `same_ip_limit`, `use_limit_per_user`, `use_device`, `multiple_use`, `total_use`, `status`, `created_at`, `updated_at`) VALUES
(1, 'product', NULL, '6CPC-MEBO-FHZZ-4PCH', 'percentage', 20.00, 0.00, 50000000.00, '2024-01-17', '2024-01-30', 100, NULL, NULL, NULL, 'no', 0, 1, '2024-01-17 12:43:30', '2024-01-17 12:43:44'),
(2, 'product', NULL, '123', 'percentage', 500.00, 0.00, 50000000.00, '2024-12-01', '2024-12-01', 100, NULL, NULL, NULL, 'no', 0, 0, '2024-01-29 20:00:18', '2024-01-29 20:02:02'),
(3, 'product', NULL, 'dsfd', 'percentage', 298.00, 200.00, 50000000.00, '2024-03-14', '2024-01-16', 2, NULL, NULL, NULL, 'no', 0, 1, '2024-01-29 20:38:22', '2024-01-29 20:38:45'),
(4, 'product', NULL, 'TXRI-AW9R-PTM4-U9RR', 'percentage', 5.00, 0.00, 50000000.00, '2024-03-01', '2024-03-30', 0, NULL, NULL, NULL, 'no', 0, 1, '2024-03-23 21:26:54', '2024-03-23 21:26:54');

-- --------------------------------------------------------

--
-- Table structure for table `coupon_histories`
--

CREATE TABLE `coupon_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `coupon_id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `object_type` varchar(255) NOT NULL,
  `discount_amount` double(12,2) NOT NULL,
  `user_ip` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `doc_name` varchar(255) NOT NULL,
  `doc_login_email` varchar(255) NOT NULL,
  `doc_primary_location` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT 1,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deactivated_by` int(11) NOT NULL DEFAULT 0,
  `deactivated_on` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`id`, `doc_name`, `doc_login_email`, `doc_primary_location`, `user_id`, `status`, `deleted_at`, `created_at`, `updated_at`, `deactivated_by`, `deactivated_on`) VALUES
(3, 'Rajib Biswas', 'rbiswas@gmail.com', 'Halisahar', 13, 1, NULL, '2024-01-08 21:56:58', '2024-01-09 01:48:07', 0, NULL),
(4, 'H. S. Pathak', 'pathak@gmail.com', 'Naihati', 15, 1, NULL, '2024-01-14 17:51:51', '2024-01-14 17:51:51', 0, NULL),
(5, 'D.K. Gupta', 'dkg@gmail', 'Sealdha', 17, 0, NULL, '2024-01-29 19:10:23', '2024-01-29 19:51:38', 1, '2024-01-29 12:51:38');

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
(1, 12, 'MBBS, FRCS', 3, 1, '2024-01-08 21:56:58', '2024-01-08 23:05:43'),
(2, 13, 'male', 3, 1, '2024-01-08 21:56:58', '2024-01-08 23:05:43'),
(3, 12, 'MBBS', 4, 1, '2024-01-14 17:51:51', '2024-01-14 17:51:51'),
(4, 13, 'male', 4, 1, '2024-01-14 17:51:51', '2024-01-14 17:51:51'),
(5, 12, 'MMBS', 5, 1, '2024-01-29 19:10:23', '2024-01-29 19:10:23'),
(6, 13, 'male', 5, 1, '2024-01-29 19:10:23', '2024-01-29 19:10:23');

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
(1, 'lab_street_address', 'Lab Street Address', NULL, 0, 'textarea'),
(2, 'lab_post_office', 'Lab Post Office', NULL, 0, 'text'),
(3, 'lab_district', 'Lab District', NULL, 0, 'text'),
(4, 'lab_state', 'Lab State', NULL, 0, 'text'),
(5, 'lab_pin_code', 'Lab Pin Code', NULL, 0, 'text'),
(6, 'lab_email', 'Lab Email', NULL, 0, 'text'),
(7, 'lab_phone_number', 'Lab Phone Number', NULL, 1, 'text'),
(8, 'owner_name', 'Owner Name', NULL, 0, 'text'),
(9, 'owner_address', 'Owner Address', NULL, 0, 'textarea'),
(10, 'owner_email', 'Owner Email', NULL, 0, 'text'),
(11, 'owner_phone_number', 'Owner Phone Number', NULL, 0, 'text'),
(12, 'doc_qualification', 'Doctor\'s Qualification', NULL, 1, 'text'),
(13, 'gender', 'Gender', NULL, 1, 'select');

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
(1, 13, 'Select Gender', NULL, 1, NULL, NULL),
(2, 13, 'Male', 'male', 0, NULL, NULL),
(3, 13, 'Female', 'female', 0, NULL, NULL),
(4, 13, 'Others', 'others', 0, NULL, NULL);

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
(1, 4, 1),
(2, 4, 2),
(3, 4, 3),
(4, 4, 4),
(5, 4, 5),
(6, 4, 6),
(7, 4, 7),
(8, 4, 8),
(9, 4, 9),
(10, 4, 10),
(11, 4, 11),
(12, 5, 12),
(13, 5, 13),
(15, 6, 13);

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
-- Table structure for table `laboratories`
--

CREATE TABLE `laboratories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `lab_name` varchar(255) NOT NULL,
  `lab_login_email` varchar(255) NOT NULL,
  `lab_primary_location` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT 1,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deactivated_by` int(11) NOT NULL DEFAULT 0,
  `deactivated_on` datetime DEFAULT NULL,
  `income_percentge` smallint(6) NOT NULL DEFAULT 5
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `laboratories`
--

INSERT INTO `laboratories` (`id`, `lab_name`, `lab_login_email`, `lab_primary_location`, `user_id`, `status`, `deleted_at`, `created_at`, `updated_at`, `deactivated_by`, `deactivated_on`, `income_percentge`) VALUES
(1, 'SRL Diagonastics Halisahar', 'srl_naihati@gmail.com', 'Halisahar', 2, 1, NULL, '2023-12-17 04:17:44', '2023-12-30 14:19:31', 0, NULL, 5),
(5, 'Netralok Lab', 'netralok-naihati@gmail.com', 'Naihati', 6, 1, NULL, '2023-12-30 06:17:59', '2024-01-08 21:48:56', 0, NULL, 5),
(8, 'Agelus Lab Shyamnagar', 'agelus.shyamnagar@gmail.com', 'Shyamnagar', 9, 1, NULL, '2024-01-07 23:00:30', '2024-01-08 22:32:44', 0, NULL, 5),
(9, 'Dr Lal Path Lab', 'drlal.halisahar@gmail.com', 'Halisahar', 10, 1, NULL, '2024-01-07 23:07:38', '2024-01-07 23:22:39', 0, NULL, 5),
(10, 'Balaji Diagnostic', 'balaji.halisahar@gmail.com', 'Halisahar', 14, 0, NULL, '2024-01-09 01:37:22', '2024-01-14 23:53:38', 1, '2024-01-14 16:53:38', 5),
(11, 'Lab Apolo New', 'apolo@gmail.com', 'Sealdha', 16, 0, NULL, '2024-01-29 18:59:54', '2024-07-14 11:22:28', 1, '2024-01-29 12:07:13', 25),
(12, 'asds', 'ab@gmail', 'sadf', 18, 1, NULL, '2024-01-29 19:11:11', '2024-01-29 19:11:11', 0, NULL, 5),
(13, 'Agelus', 'agelus.halisahar@gmail.com', 'Halisahar', 20, 1, NULL, '2024-03-02 13:37:09', '2024-07-14 14:29:31', 0, NULL, 45),
(14, 'New Lab', 'newlab@gmail.com', 'Kolkata', 22, 1, NULL, '2024-05-22 05:09:57', '2024-07-14 11:22:15', 0, NULL, 25);

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
(1, 1, 'RBC Road Naihati', 1, 1, '2023-12-16 22:47:44', '2023-12-30 08:43:08'),
(2, 2, 'Halisahar', 1, 1, '2023-12-16 22:47:44', '2023-12-30 08:43:08'),
(3, 3, '24 PGS (N)', 1, 1, '2023-12-16 22:47:44', '2023-12-30 08:43:08'),
(4, 4, 'West Bengal', 1, 1, '2023-12-16 22:47:44', '2023-12-30 08:43:08'),
(5, 5, '743135', 1, 1, '2023-12-16 22:47:44', '2023-12-30 08:43:08'),
(6, 6, 'srl_naihati@gmail.com', 1, 1, '2023-12-16 22:47:44', '2023-12-30 08:43:08'),
(7, 7, '9874563210', 1, 1, '2023-12-16 22:47:44', '2023-12-30 08:43:08'),
(8, 8, 'Mr S. Rajamouli', 1, 1, '2023-12-16 22:47:44', '2023-12-30 08:43:08'),
(9, 7, '9874563210', 5, 1, '2023-12-30 00:47:59', '2024-01-08 21:48:56'),
(10, 9, NULL, 1, 1, '2023-12-30 08:39:30', '2023-12-30 08:43:08'),
(11, 10, 'newowner@gmail.com', 1, 1, '2023-12-30 08:43:08', '2023-12-30 08:43:08'),
(12, 7, '9895963214', 8, 1, '2024-01-07 17:30:30', '2024-01-07 17:30:59'),
(13, 1, 'Shyamnagar Chowmatha', 8, 1, '2024-01-07 17:30:59', '2024-01-07 17:30:59'),
(14, 2, 'Halisahar', 9, 1, '2024-01-07 23:07:38', '2024-01-07 23:22:39'),
(15, 7, '7896541230', 9, 1, '2024-01-07 23:07:38', '2024-01-07 23:22:39'),
(16, 1, 'Near Chowmatha Bazar', 9, 1, '2024-01-07 23:22:39', '2024-01-07 23:22:39'),
(17, 2, 'Garifa', 5, 1, '2024-01-08 21:48:56', '2024-01-08 21:48:56'),
(18, 7, '9874563657', 10, 1, '2024-01-09 01:37:22', '2024-01-09 01:37:42'),
(19, 2, 'Halisahar', 10, 1, '2024-01-09 01:37:42', '2024-01-09 01:37:42'),
(20, 1, 'Near Sealdha Station', 11, 1, '2024-01-29 18:59:54', '2024-07-14 11:22:28'),
(21, 2, 'Seladha PO', 11, 1, '2024-01-29 18:59:54', '2024-07-14 11:22:28'),
(22, 3, '24 PGS N', 11, 1, '2024-01-29 18:59:54', '2024-07-14 11:22:28'),
(23, 4, 'WB', 11, 1, '2024-01-29 18:59:54', '2024-07-14 11:22:28'),
(24, 5, '123456', 11, 1, '2024-01-29 18:59:54', '2024-07-14 11:22:28'),
(25, 6, 'apolo@gmail.com', 11, 1, '2024-01-29 18:59:54', '2024-07-14 11:22:28'),
(26, 7, '1234567890', 11, 1, '2024-01-29 18:59:54', '2024-07-14 11:22:28'),
(27, 8, 'Name 1', 11, 1, '2024-01-29 18:59:54', '2024-07-14 11:22:28'),
(28, 9, 'Same address', 11, 1, '2024-01-29 18:59:54', '2024-07-14 11:22:28'),
(29, 7, 'sdfs', 12, 1, '2024-01-29 19:11:11', '2024-01-29 19:11:11'),
(30, 1, 'Halisahar', 13, 1, '2024-03-02 13:37:09', '2024-07-14 14:29:31'),
(31, 7, '9874563215', 13, 1, '2024-03-02 13:37:09', '2024-07-14 14:29:31'),
(32, 7, '9874563210', 14, 1, '2024-05-22 05:09:57', '2024-07-14 11:22:15');

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
(2, 1, 0, 'P4Z3JKS2ZY4FBODX', '2024-03-02 01:55:14', '2024-05-25 09:33:43'),
(3, 6, 0, '6WFY2SU4RPPG5Q2W', '2024-04-12 19:03:21', '2024-04-12 19:05:08');

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
(15, '2014_10_12_000000_create_users_table', 1),
(16, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(17, '2014_10_12_200000_add_two_factor_columns_to_users_table', 1),
(18, '2016_06_01_000001_create_oauth_auth_codes_table', 1),
(19, '2016_06_01_000002_create_oauth_access_tokens_table', 1),
(20, '2016_06_01_000003_create_oauth_refresh_tokens_table', 1),
(21, '2016_06_01_000004_create_oauth_clients_table', 1),
(22, '2016_06_01_000005_create_oauth_personal_access_clients_table', 1),
(23, '2019_08_19_000000_create_failed_jobs_table', 1),
(24, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(25, '2023_11_21_050229_alter_users_add_access_type', 1),
(26, '2023_11_26_072623_create_roles_table', 1),
(27, '2023_11_26_072647_create_role_users_table', 1),
(28, '2023_11_26_141543_alter_users_add_user_iamge', 1),
(29, '2023_11_26_170809_create_login_securities_table', 1),
(32, '2023_12_10_072903_create_form_field_roles_table', 3),
(33, '2023_12_16_144836_create_laboratories_table', 4),
(35, '2023_12_30_142600_alter_laboratories_add_deactivated_by', 6),
(36, '2023_12_31_115610_create_notifications_table', 7),
(37, '2024_01_06_142902_create_doctors_table', 8),
(38, '2024_01_07_151952_create_form_field_options_table', 8),
(40, '2023_12_09_125118_create_form_fields_table', 10),
(41, '2023_12_17_090900_create_lab_form_field_values_table', 11),
(42, '2024_01_09_031958_create_doc_form_field_values_table', 12),
(43, '2024_01_09_033611_alter_users_add_status', 13),
(44, '2024_01_09_035553_alter_doctors_add_deactivated_columns', 14),
(45, '2023_12_17_090900_create_form_field_values_table', 15),
(46, '2024_01_11_185627_create_sessions_table', 15),
(47, '2024_01_14_085957_create_collectors_table', 15),
(48, '2024_01_14_114033_create_collector_form_field_values_table', 15),
(49, '2024_01_15_110315_create_coupons_table', 15),
(50, '2024_01_15_110316_create_coupon_histories_table', 15),
(51, '2024_01_20_152438_create_admin_menus_table', 16),
(53, '2024_01_20_172904_create_admin_menu_roles_table', 16),
(54, '2024_01_21_053316_create_user_documents_table', 16),
(55, '2024_03_02_155604_create_wallet_users_table', 17),
(58, '2024_03_02_155635_create_transactions_table', 18),
(59, '2024_03_16_222115_create_pathology_test_categories_table', 19),
(60, '2024_03_16_222305_create_pathology_tests_table', 20),
(61, '2024_04_11_174415_create_collector_lab_associations_table', 21),
(63, '2024_05_11_012946_create_patients_table', 22),
(68, '2024_05_12_111511_alter_patients_add_coordinates', 25),
(70, '2024_05_19_214128_alter_transactions_add_status', 27),
(71, '2024_07_14_123625_alter_laboratories_add_income_percentage', 28),
(74, '2024_05_11_124351_create_orders_table', 29),
(75, '2024_05_11_131554_create_order_tests_table', 30),
(76, '2024_07_21_181028_alter_patients_add_user_id', 30);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `notification` text NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `notification_type` varchar(255) NOT NULL,
  `notification_time` datetime NOT NULL,
  `viewed` int(11) NOT NULL DEFAULT 0,
  `added_by` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `notification`, `user_id`, `notification_type`, `notification_time`, `viewed`, `added_by`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Test', 2, 'text', '2024-01-06 13:50:56', 0, 1, 1, '2024-01-06 08:20:56', '2024-01-06 08:20:56'),
(2, 'Test', 6, 'text', '2024-01-06 13:50:56', 0, 1, 1, '2024-01-06 08:20:56', '2024-01-06 08:20:56'),
(3, 'New Notifications', 2, 'text', '2024-01-06 13:59:50', 0, 1, 1, '2024-01-06 08:29:50', '2024-01-06 08:29:50'),
(4, 'New Notifications', 6, 'text', '2024-01-06 13:59:50', 0, 1, 1, '2024-01-06 08:29:50', '2024-01-06 08:29:50');

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

--
-- Dumping data for table `oauth_access_tokens`
--

INSERT INTO `oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
('00b99c3730dbdc2eaf6c193cc9124a165285e25b37954af701f6f355c1d6e3e18e8ce70522890380', NULL, 3, NULL, '[]', 0, '2024-04-21 18:20:41', '2024-04-21 18:20:41', '2024-05-06 23:50:41'),
('0d98811bb3d225483a651d5475c9e714c95d26fb4cc7f6541c2c21ce7bc35f8a096a0830a9282a88', NULL, 3, NULL, '[]', 0, '2024-04-21 07:34:13', '2024-04-21 07:34:13', '2024-05-06 13:04:13'),
('2043679a7a5d62805b67f20e7c63299b8b06a615b3e4e5385a5c6efd1e7f27d4e5b6c1141805e01a', NULL, 3, NULL, '[]', 0, '2024-04-21 07:32:52', '2024-04-21 07:32:52', '2024-05-06 13:02:52'),
('291ecdd2ed9e5857a3a65d1bc37e2dbb4cca4c66ddb6d60f293c9881696a88a8382c220a53e51e05', NULL, 3, NULL, '[]', 0, '2024-04-21 09:14:20', '2024-04-21 09:14:20', '2024-05-06 14:44:20'),
('36a26775b7054b0151a10285586e63203a946592f70f0de966c93ff5467fd53bc33e910dd8651007', 1, 2, 'Personal Access Token', '[]', 0, '2024-05-04 19:12:48', '2024-05-04 19:12:48', '2025-05-05 00:42:48'),
('4e5b2df5e246e94e668f7bc2b5ba4769c774cc650092dcca4832cf18957c4d18e47874518f962315', 1, 2, 'Personal Access Token', '[]', 0, '2024-05-04 19:31:36', '2024-05-04 19:31:36', '2025-05-05 01:01:36'),
('506e5d8fc8f32e73633347a24d0c5759dfd0e25ebeed542a117cf98e544ad25cd9829684960768d6', 1, 2, 'Personal Access Token', '[]', 0, '2024-05-04 19:39:54', '2024-05-04 19:39:54', '2025-05-05 01:09:54'),
('550d67523c0973891dea36ff0732cf14ab28503fec97f93ea2ee12a488adb07f423a8fe76bfa1377', 1, 2, 'Personal Access Token', '[]', 0, '2024-05-04 19:40:14', '2024-05-04 19:40:14', '2025-05-05 01:10:14'),
('65a3cd233f24927f90b353f5aecda5569a1371d83a11681eb8201921ccbf5b61b0c63bc387dc0ff6', NULL, 3, NULL, '[]', 0, '2024-04-21 07:32:18', '2024-04-21 07:32:18', '2024-05-06 13:02:18'),
('851233408bd628d8c9309b331ba92976e1053ec98df72a3aaa6736bec51555c6a47c43a9fe3de41a', NULL, 3, NULL, '[]', 0, '2024-04-21 08:57:06', '2024-04-21 08:57:06', '2024-05-06 14:27:06'),
('92c1cc876364786a9d30a6b0cd9d8ea94d7b3b358c5f0221f39d0c08c7c81865edc17ae677973140', 1, 2, 'Personal Access Token', '[]', 0, '2024-05-04 19:39:24', '2024-05-04 19:39:24', '2025-05-05 01:09:24'),
('999a4f85d1b833d518fb9739f7e032e195b573d6958878a89900bdf33c6d9596af0139dca5a0e6a6', NULL, 3, NULL, '[]', 0, '2024-04-21 09:12:07', '2024-04-21 09:12:07', '2024-05-06 14:42:07'),
('a067716ceb16f4c6b8398ff5d0af417e74f31df0d8bfe85d46da1d405fe2fbeda39315383cdd94a4', NULL, 3, NULL, '[]', 0, '2024-04-21 07:32:47', '2024-04-21 07:32:47', '2024-05-06 13:02:47'),
('aee007b8de328863ab07ca5e517f4280ec9e70f5ef235796d71daa7a3ed7001c83cde1e40c0adbda', NULL, 3, NULL, '[]', 0, '2024-04-21 18:19:19', '2024-04-21 18:19:19', '2024-05-06 23:49:19'),
('d8e1226de7254c81f72e8c8b9d61460d9fdb0368037c997b1d6eb106a15ab27239f2833ae88c5301', NULL, 3, NULL, '[]', 0, '2024-04-21 07:32:45', '2024-04-21 07:32:45', '2024-05-06 13:02:45'),
('eda45225bd44b1160322c88bfd4efc183b2cdca94bfbf065737e0927e349771b40ea0adcdc9421da', NULL, 3, NULL, '[]', 0, '2024-04-21 07:33:21', '2024-04-21 07:33:21', '2024-05-06 13:03:21');

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

--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `provider`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Laravel Personal Access Client', 'saA9VCmQf1QAgBjxEqod2Yo1GcmUOXUlE9FNUHin', NULL, 'http://localhost', 1, 0, 0, '2024-04-20 07:03:35', '2024-04-20 07:03:35'),
(2, NULL, 'Laravel Personal Access Client', '30fLADOzCBTwGe9Nj5IpueQePHtEfU7bMiZD3wy4', NULL, 'http://localhost', 1, 0, 0, '2024-04-20 07:06:23', '2024-04-20 07:06:23'),
(3, NULL, 'Laravel Password Grant Client', 'zS4EHlYkEXvD5G8vAPuLEZdyEZ9t7bIckr56YElG', 'users', 'http://localhost', 0, 1, 0, '2024-04-20 07:06:23', '2024-04-20 07:06:23'),
(4, NULL, 'PassportClient', 'JWWPW7g6QUWPW21TKxeX3kDj2YEDuGBmwVOyqp1W', NULL, 'http://localhost/auth/callback', 0, 0, 0, '2024-04-20 08:50:58', '2024-04-20 08:50:58'),
(5, NULL, 'public client', NULL, NULL, 'http://localhost/auth/callback', 0, 0, 0, '2024-04-21 08:03:34', '2024-04-21 08:03:34'),
(6, NULL, 'Public', NULL, NULL, 'http://localhost/auth/callback', 0, 0, 0, '2024-04-21 08:26:17', '2024-04-21 08:26:17');

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

--
-- Dumping data for table `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2024-04-20 07:03:35', '2024-04-20 07:03:35'),
(2, 2, '2024-04-20 07:06:23', '2024-04-20 07:06:23');

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
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `laboratorie_id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `collector_id` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `appointment_time` datetime NOT NULL,
  `collection_address` text NOT NULL,
  `collection_charge` double(8,2) NOT NULL,
  `prescription_1` varchar(255) NOT NULL,
  `prescription_2` varchar(255) NOT NULL,
  `doctor_name` varchar(255) NOT NULL,
  `order_number` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `total_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `discounted_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `payable_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status` enum('pending','processing','pickup','submitted_to_lab','testing','completed','cancelled') NOT NULL DEFAULT 'pending',
  `ordered_at` timestamp NULL DEFAULT NULL,
  `processed_at` timestamp NULL DEFAULT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `laboratorie_id`, `patient_id`, `collector_id`, `appointment_time`, `collection_address`, `collection_charge`, `prescription_1`, `prescription_2`, `doctor_name`, `order_number`, `description`, `total_amount`, `discounted_amount`, `payable_amount`, `status`, `ordered_at`, `processed_at`, `completed_at`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 0, '2024-07-28 07:00:00', '5th RDC Road', 100.00, 'ddd', 'ddd', 'Dr Amit jana', '86e45c52-e296-4eaf-ac38-314cee9bf6a3', '', 5000.00, 200.00, 4800.00, 'pending', '2024-07-28 07:36:50', NULL, NULL, '2024-07-28 07:36:50', '2024-07-28 07:36:50'),
(2, 1, 1, 0, '2024-07-28 07:00:00', '5th RDC Road', 100.00, 'ddd', 'ddd', 'Dr Amit jana', 'f4a7188d-b2fe-4940-bfec-7e35402f6f4c', '', 5000.00, 200.00, 4800.00, 'pending', '2024-07-28 07:38:53', NULL, NULL, '2024-07-28 07:38:53', '2024-07-28 07:38:53'),
(3, 1, 101, 0, '2024-07-28 07:00:00', 'Kashi Bose Lane', 100.00, 'ddd', 'ddd', 'Dr Amit jana', 'a8db81ce-fe9b-4fd2-bdb7-4ccb5b4c2fd8', '', 5000.00, 200.00, 4800.00, 'pending', '2024-07-28 08:42:26', NULL, NULL, '2024-07-28 08:42:26', '2024-07-28 08:42:26');

-- --------------------------------------------------------

--
-- Table structure for table `order_tests`
--

CREATE TABLE `order_tests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `pathology_test_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
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
-- Table structure for table `pathology_tests`
--

CREATE TABLE `pathology_tests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `test_name` varchar(255) NOT NULL,
  `test_code` varchar(255) DEFAULT NULL,
  `pathology_test_categorie_id` bigint(20) UNSIGNED NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `sample_type` varchar(255) NOT NULL,
  `normal_range` varchar(255) DEFAULT NULL,
  `units` varchar(255) NOT NULL,
  `turnaround_time` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pathology_tests`
--

INSERT INTO `pathology_tests` (`id`, `test_name`, `test_code`, `pathology_test_categorie_id`, `description`, `price`, `sample_type`, `normal_range`, `units`, `turnaround_time`, `created_at`, `updated_at`) VALUES
(1, 'Blood Test 1', 'BT1', 1, NULL, 530.00, 'Type1', NULL, '33', NULL, NULL, NULL),
(2, 'Blood Test 2', 'BT2', 1, NULL, 540.00, 'Type1', NULL, '33', NULL, NULL, NULL),
(3, 'Blood Test 3', 'BT3', 1, NULL, 550.00, 'Type1', NULL, '33', NULL, NULL, NULL),
(4, 'Blood Test 4', 'BT4', 1, NULL, 560.00, 'Type1', NULL, '33', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pathology_test_categories`
--

CREATE TABLE `pathology_test_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pathology_test_categories`
--

INSERT INTO `pathology_test_categories` (`id`, `category_name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Blood Test', NULL, NULL, NULL),
(2, 'X-Ray', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mobile_number` varchar(255) NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `address` text NOT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `postal_code` varchar(255) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `lat` varchar(255) DEFAULT NULL,
  `long` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`id`, `first_name`, `last_name`, `full_name`, `email`, `mobile_number`, `date_of_birth`, `gender`, `address`, `city`, `state`, `country`, `postal_code`, `notes`, `created_at`, `updated_at`, `lat`, `long`, `user_id`) VALUES
(1, 'Amit', 'Barui', 'Amit Barui', 'amit.b@gmail.com', '9873252563', '2024-08-05', 'male', '5th RDC Road', 'Kolkata', 'West Bengal', 'India', '700057', 'Ipsa provident perspiciatis sed autem. Sint ab nostrum consequuntur quia voluptas possimus. Et sed cumque et.', '2024-07-27 08:09:11', '2024-07-27 15:04:17', NULL, NULL, 23),
(2, 'Madhu', 'Sama', 'Madhu Sama', 'pandit.tejaswani@example.com', '+91 7152211718', '2001-06-10', 'male', '40, Veena Chowk, Pune - 426431', 'Indore', 'Telangana', 'Saint Kitts and Nevis', '403501', 'Sequi quas tempora corporis est iusto. Officia sed dolores nulla ex consequatur. Omnis molestiae et rerum eos. Dolor ipsum natus voluptatem velit.', '2024-07-27 08:09:11', '2024-07-27 08:09:11', NULL, NULL, 24),
(3, 'Sushant', 'Gour', 'Sushant Gour', 'kapadia.mohit@example.com', '08639140057', '2004-08-30', 'male', '34, Vijay Society, Cyber City Alwar - 468322', 'Srinagar', 'Punjab', 'Congo', '294738', 'Cupiditate voluptatum explicabo consequuntur sunt est. Laboriosam qui blanditiis alias alias modi harum. Reprehenderit iure voluptas accusantium optio eaque.', '2024-07-27 08:09:11', '2024-07-27 08:09:11', NULL, NULL, 25),
(4, 'Nishi', 'Aurora', 'Nishi Aurora', 'elias51@example.com', '07080332112', '2010-11-23', 'female', '51, Jagdish Villas, Ram Nagar Darjeeling - 102434', 'Bengaluru', 'Himachal Pradesh', 'Congo', '237974', 'Ut enim cupiditate ullam quis ea quo omnis. Est est ipsum culpa fugit sunt aut est. Est animi velit dolore qui non at.', '2024-07-27 08:09:12', '2024-07-27 08:09:12', NULL, NULL, 26),
(5, 'Charu', 'Apte', 'Charu Apte', 'asen@example.org', '+91 9579297399', '2020-04-06', 'male', '36, Andheri, Jaipur - 520691', 'Guwahati', 'West Bengal', 'Wallis and Futuna', '211001', 'Praesentium eos debitis voluptatem dolor sunt aspernatur quia. Odit exercitationem eligendi expedita. Qui enim dolores doloribus nemo repellendus et.', '2024-07-27 08:09:12', '2024-07-27 08:09:12', NULL, NULL, 27),
(6, 'Sirish', 'Sen', 'Sirish Sen', 'ishroff@example.com', '+91 7991400284', '1971-04-29', 'male', '74, Zeenat Nagar, Noida - 426103', 'Darjeeling', 'Meghalaya', 'Bulgaria', '399907', 'Nulla consequatur earum vel est. Corporis provident esse in voluptatum aperiam quae in est. Et excepturi nostrum est et.', '2024-07-27 08:09:12', '2024-07-27 08:09:12', NULL, NULL, 28),
(7, 'Jiya', 'Bali', 'Jiya Bali', 'peri.manish@example.net', '09011949373', '1987-07-15', 'female', '81, Chinchwad, Trichy - 134961', 'Vadodara', 'Manipur', 'Guernsey', '382881', 'Adipisci modi exercitationem incidunt cupiditate veniam amet eos. Aperiam dicta alias odit velit minus. Mollitia nemo id et ex expedita. Rerum rem alias repellendus nostrum ex quae.', '2024-07-27 08:09:12', '2024-07-27 08:09:12', NULL, NULL, 29),
(8, 'Radhe', 'Subramaniam', 'Radhe Subramaniam', 'eramesh@example.org', '08667269910', '2011-08-09', 'female', '32, Aundh, Jammu - 228939', 'Bhubhaneshwar', 'Chhattisgarh', 'Oman', '235747', 'Culpa possimus exercitationem sapiente aut omnis voluptas. Eveniet laudantium consequatur autem quo eligendi. Dolorem et maxime consectetur expedita officia. Quasi et molestias id modi aut esse.', '2024-07-27 08:09:13', '2024-07-27 08:09:13', NULL, NULL, 30),
(9, 'Dhiraj', 'Tiwari', 'Dhiraj Tiwari', 'dinesh85@example.com', '+91 9609727659', '2015-03-29', 'female', '80, Pranay Society, Vikhroli Kota - 498891', 'Kochi', 'Daman and Diu', 'Madagascar', '443367', 'Quam aut ipsam eum doloremque. Consequatur et aspernatur enim quos. Et culpa ratione explicabo architecto facere. Distinctio autem provident quaerat iste.', '2024-07-27 08:09:13', '2024-07-27 08:09:13', NULL, NULL, 31),
(10, 'Sumit', 'Badal', 'Sumit Badal', 'ajinkya02@example.net', '09459164110', '2009-04-19', 'female', '83, Manjari Heights, Chinchwad Jodhpur - 523966', 'Raipur', 'Puducherry', 'Jersey', '374138', 'Et consequatur ab iusto nostrum consequuntur. Ea quae autem at aliquam. Laborum officiis est consectetur facere sunt. Dolorum veritatis laboriosam est iste voluptas. Explicabo vel rem sequi et.', '2024-07-27 08:09:13', '2024-07-27 08:09:13', NULL, NULL, 32),
(11, 'Sheetal', 'Devan', 'Sheetal Devan', 'krishnan.ramesh@example.com', '+91 7546568221', '1973-05-23', 'male', '27, Azhar Villas, RaginiGarh Kota - 527088', 'Kota', 'Punjab', 'Mauritius', '476776', 'In nesciunt sapiente et et. Ex non non excepturi velit. Optio velit et quo voluptatum error. Sit assumenda et deleniti dignissimos id nesciunt. Numquam sit amet fugit deserunt.', '2024-07-27 08:09:14', '2024-07-27 08:09:14', NULL, NULL, 33),
(12, 'Jack', 'Divan', 'Jack Divan', 'chana.giaan@example.net', '07518713894', '2002-12-05', 'male', '13, AlaknandaGarh, Pune - 260125', 'Kolkata', 'Nagaland', 'Hungary', '481626', 'Fuga tempora veniam est voluptatem eaque ducimus vel. Facilis suscipit vel sed tempora quia veniam. Ea delectus rerum repellat vel.', '2024-07-27 08:09:14', '2024-07-27 08:09:14', NULL, NULL, 34),
(13, 'Amrita', 'Bhagat', 'Amrita Bhagat', 'payal13@example.org', '+91 9598242906', '2005-11-08', 'female', '92, Rahim Society, BinitaPur Jodhpur - 524195', 'Surat', 'Andaman and Nicobar Islands', 'Mexico', '287543', 'Voluptatum molestiae qui necessitatibus recusandae sapiente. Facilis enim perferendis architecto quia et aliquam. Nisi deserunt aspernatur debitis earum est ut et necessitatibus.', '2024-07-27 08:09:14', '2024-07-27 08:09:14', NULL, NULL, 35),
(14, 'Balaji', 'Amin', 'Balaji Amin', 'isha.sane@example.net', '+91 8745647568', '1975-06-25', 'female', '65, Manpreet Heights, CharandeepGunj Gangtok - 544787', 'Bhopal', 'Bihar', 'Trinidad and Tobago', '218152', 'Pariatur ut libero voluptatibus odit quas. Possimus aut aut eos delectus libero placeat autem nisi. Expedita quasi totam sunt architecto omnis ut non. Dolorum nulla ullam amet rem earum nam.', '2024-07-27 08:09:14', '2024-07-27 08:09:14', NULL, NULL, 36),
(15, 'Lalit', 'Biswas', 'Lalit Biswas', 'nutan72@example.com', '09061224121', '1971-01-16', 'female', '26, Mukund Apartments, Vikhroli New Delhi - 125655', 'Delhi', 'Maharashtra', 'Gibraltar', '535648', 'Dolorem temporibus ullam rerum in. Dolorem minus earum incidunt in deserunt quisquam. Ut necessitatibus autem voluptatibus sed et.', '2024-07-27 08:09:15', '2024-07-27 08:09:15', NULL, NULL, 37),
(16, 'Kalpana', 'Narula', 'Kalpana Narula', 'kailash81@example.org', '+91 8173112877', '2009-08-26', 'male', '90, Karim Nagar, Pondicherry - 120446', 'Udaipur', 'Karnataka', 'Burundi', '534833', 'Voluptatem temporibus molestiae eum aspernatur possimus sunt vel sed. Dolorem ad ut quisquam aperiam omnis cupiditate. Quam expedita explicabo accusantium. At sunt est totam odio.', '2024-07-27 08:09:15', '2024-07-27 08:09:15', NULL, NULL, 38),
(17, 'Kasturba', 'Chana', 'Kasturba Chana', 'ambika.maharaj@example.net', '08238793234', '2002-08-15', 'female', '40, Mohan Nagar, Hisar - 444034', 'Kota', 'Manipur', 'Armenia', '174458', 'Aliquam et ea ex quidem est. Saepe incidunt eos sed odit fugiat blanditiis. Ducimus omnis tempora vel et ipsum.', '2024-07-27 08:09:15', '2024-07-27 08:09:15', NULL, NULL, 39),
(18, 'Kim', 'Saha', 'Kim Saha', 'kchadha@example.net', '+91 8959583030', '1970-07-29', 'female', '72, Trishana Heights, Chinchwad Simla - 545212', 'Vishakhapattanam', 'Haryana', 'Norfolk Island', '371210', 'Alias similique neque aspernatur eligendi. Et temporibus sed enim repellendus tempore ea aliquid. Inventore voluptatem aut ex beatae. Consequatur provident necessitatibus rerum.', '2024-07-27 08:09:16', '2024-07-27 08:09:16', NULL, NULL, 40),
(19, 'Anshula', 'Sethi', 'Anshula Sethi', 'navami.chakraborty@example.net', '07730107979', '1991-05-31', 'female', '24, Bagwati Heights, Deccan Gymkhana Meerut - 510260', 'Delhi', 'Himachal Pradesh', 'Iceland', '586915', 'Neque amet sed atque ad. Sed explicabo similique nesciunt tempore inventore ipsam architecto.', '2024-07-27 08:09:16', '2024-07-27 08:09:16', NULL, NULL, 41),
(20, 'Kalpana', 'Gupta', 'Kalpana Gupta', 'ajay.chawla@example.com', '+91 7489414376', '1983-08-07', 'female', '17, Sodala, Jammu - 313306', 'Ajmer', 'Manipur', 'Isle of Man', '474854', 'Dolor corporis sint natus. Repellat consequatur sint accusamus laboriosam. In quia et qui. Saepe sapiente et atque in cumque harum. Voluptas non magni voluptates ipsum vel necessitatibus nostrum vel.', '2024-07-27 08:09:16', '2024-07-27 08:09:16', NULL, NULL, 42),
(21, 'Harpreet', 'Ramnarine', 'Harpreet Ramnarine', 'xswaminathan@example.com', '+91 9745325696', '1992-01-17', 'female', '87, Aundh, Faridabad - 190359', 'Jaipur', 'Chhattisgarh', 'Svalbard & Jan Mayen Islands', '215382', 'Ut et deleniti praesentium excepturi delectus qui. Voluptas fugiat suscipit ut. Est possimus quia velit doloremque est voluptatem.', '2024-07-27 08:09:16', '2024-07-27 08:09:16', NULL, NULL, 43),
(22, 'Ram Gopal', 'Chauhan', 'Ram Gopal Chauhan', 'xmore@example.com', '+91 9938798314', '1970-01-01', 'female', '48, AzharPur, Hisar - 501084', 'Kanpur', 'Puducherry', 'Central African Republic', '459676', 'Nulla itaque amet est quo corporis fuga unde. Magni optio consequuntur perferendis mollitia rem provident ut.', '2024-07-27 08:09:17', '2024-07-27 08:09:17', NULL, NULL, 44),
(23, 'Babita', 'Deol', 'Babita Deol', 'qrana@example.org', '08990409064', '1985-11-28', 'female', '63, NishitaGunj, Darjeeling - 562938', 'Lucknow', 'Meghalaya', 'Kenya', '578528', 'Ullam sint dolores doloremque ratione. Unde ullam odio enim. Ad minus esse nostrum debitis modi et illo. Incidunt voluptatem ipsa totam sint exercitationem voluptatem.', '2024-07-27 08:09:17', '2024-07-27 08:09:17', NULL, NULL, 45),
(24, 'Aslam', 'Chakraborty', 'Aslam Chakraborty', 'pparmer@example.com', '+91 8451607075', '2004-05-22', 'male', '58, AkankshaPur, Chennai - 579496', 'Ratlam', 'Gujarat', 'Poland', '243264', 'Inventore et nihil labore non molestiae accusamus corporis. Repellat dignissimos non maiores repellendus. Aut et placeat amet modi explicabo enim temporibus nisi.', '2024-07-27 08:09:17', '2024-07-27 08:09:17', NULL, NULL, 46),
(25, 'Urvashi', 'Bhatti', 'Urvashi Bhatti', 'kalyani56@example.net', '+91 8594127759', '1989-01-12', 'male', '75, Rosey Villas, Parvez Nagar Indore - 196816', 'Ranchi', 'Andhra Pradesh', 'Switzerland', '189104', 'Corrupti voluptate odio dolorum. Quo earum eaque quo suscipit non ea aut nemo. Et ipsum at expedita ex corrupti. Itaque hic provident neque voluptas rerum ea dolorem.', '2024-07-27 08:09:17', '2024-07-27 08:09:17', NULL, NULL, 47),
(26, 'Arun', 'Varma', 'Arun Varma', 'supriya01@example.net', '08761350516', '2018-01-27', 'female', '72, Aayushi Society, Hinjewadi Srinagar - 332143', 'Udaipur', 'Dadra and Nagar Haveli', 'United States Minor Outlying Islands', '374730', 'Et sed et necessitatibus pariatur. Voluptatum quibusdam suscipit sunt in ad alias a. Tempore ducimus consequatur fuga omnis eos qui culpa. Dignissimos itaque dolorem nihil et sint.', '2024-07-27 08:09:18', '2024-07-27 08:09:18', NULL, NULL, 48),
(27, 'Kalpit', 'Subramaniam', 'Kalpit Subramaniam', 'sumit82@example.org', '08933207733', '1973-12-09', 'female', '77, Atul Heights, Andheri Ludhiana - 193268', 'Srinagar', 'Andaman and Nicobar Islands', 'Palau', '493798', 'Non culpa molestiae modi temporibus eum. Velit sed non deleniti nisi impedit ipsum est quae. Et officiis sit odio accusamus iure quia. A ducimus et ut neque nesciunt.', '2024-07-27 08:09:18', '2024-07-27 08:09:18', NULL, NULL, 49),
(28, 'Chhaya', 'Mahal', 'Chhaya Mahal', 'jagdish59@example.com', '08530165503', '1987-12-19', 'female', '91, Tushar Villas, Marathahalli Nashik - 190212', 'Jabalpur', 'Uttarakhand', 'Cook Islands', '405745', 'Cumque qui sunt nemo dolores explicabo ea quam. Voluptas odit cupiditate eum totam consequuntur magni tenetur. Sint vel id voluptas voluptas facilis in.', '2024-07-27 08:09:18', '2024-07-27 08:09:18', NULL, NULL, 50),
(29, 'Urvashi', 'Wali', 'Urvashi Wali', 'meda.shanti@example.org', '+91 7869017919', '1980-04-19', 'male', '53, Anshula Heights, FaisalPur Nashik - 437749', 'Faridabad', 'Daman and Diu', 'United Kingdom', '342034', 'Nostrum totam reiciendis eveniet ratione quo. Quae veritatis quisquam voluptate quia id eum tempora. Placeat voluptas repudiandae suscipit illum. Consequuntur sit molestias voluptates cumque.', '2024-07-27 08:09:19', '2024-07-27 08:09:19', NULL, NULL, 51),
(30, 'Sharad', 'Bandi', 'Sharad Bandi', 'surya.naik@example.com', '+91 7806262836', '1997-01-11', 'female', '87, Chhavi Heights, Yerwada Gangtok - 448009', 'Chennai', 'Himachal Pradesh', 'Malawi', '438841', 'Est rem et quos sunt sit. Totam perspiciatis laborum qui id. Porro aspernatur nulla optio enim. Delectus et omnis totam quibusdam temporibus aut.', '2024-07-27 08:09:19', '2024-07-27 08:09:19', NULL, NULL, 52),
(31, 'Madhavi', 'Comar', 'Madhavi Comar', 'qagarwal@example.org', '07611177132', '1974-10-29', 'female', '86, Aarif Apartments, Bandra New Delhi - 373389', 'Kolkata', 'Maharashtra', 'Lithuania', '481077', 'Ea deserunt esse cumque error quia voluptate ex. Minus aut at optio sint.', '2024-07-27 08:09:19', '2024-07-27 08:09:19', NULL, NULL, 53),
(32, 'Mukti', 'Bahri', 'Mukti Bahri', 'chandni70@example.com', '+91 9242787868', '1978-08-29', 'female', '85, Babita Chowk, Mumbai - 314790', 'Srinagar', 'Himachal Pradesh', 'Saint Vincent and the Grenadines', '333059', 'Quia voluptas quia ut aliquam aut laborum blanditiis. Esse iure et in tempore amet. Qui occaecati ab blanditiis aliquid voluptas dolor laborum.', '2024-07-27 08:09:19', '2024-07-27 08:09:19', NULL, NULL, 54),
(33, 'Abdul', 'Mohabir', 'Abdul Mohabir', 'jagruti71@example.net', '+91 9615031116', '2005-10-06', 'male', '36, BishnuPur, Guwahati - 212942', 'Mumbai', 'Punjab', 'Vietnam', '233480', 'Ipsam excepturi ipsam error id laboriosam. Sint quos tempora minima cumque esse. Eum voluptates omnis iste. Consectetur illo sequi voluptatem a.', '2024-07-27 08:09:20', '2024-07-27 08:09:20', NULL, NULL, 55),
(34, 'Bijoy', 'Mohanty', 'Bijoy Mohanty', 'shobha15@example.com', '+91 7683100990', '1974-06-23', 'female', '99, Qadim Society, NarayanPur Pondicherry - 415497', 'Udaipur', 'Meghalaya', 'Iceland', '402990', 'Et ea quia explicabo molestias nesciunt. Natus aliquid ea illum. Quis dolorum et sunt doloribus ullam temporibus reprehenderit.', '2024-07-27 08:09:20', '2024-07-27 08:09:20', NULL, NULL, 56),
(35, 'Nilima', 'Sahni', 'Nilima Sahni', 'narayan.master@example.net', '07058058633', '1982-01-01', 'male', '10, Andheri, Pune - 592854', 'Dehra Dun', 'Delhi', 'Netherlands Antilles', '145328', 'Corrupti tenetur laudantium aut. Sed quod est ex est.', '2024-07-27 08:09:20', '2024-07-27 08:09:20', NULL, NULL, 57),
(36, 'Deep', 'Chohan', 'Deep Chohan', 'vivek.acharya@example.net', '08559436716', '1992-12-31', 'male', '43, Mukti Apartments, Darpan Chowk Darjeeling - 320176', 'Pune', 'Puducherry', 'Bangladesh', '180177', 'Quis nisi sequi ex iste. Quibusdam rerum quis aut officia. Fugit quidem corrupti sed ea excepturi consequuntur odit.', '2024-07-27 08:09:21', '2024-07-27 08:09:21', NULL, NULL, 58),
(37, 'Nalini', 'Iyer', 'Nalini Iyer', 'acontractor@example.com', '+91 8033380373', '1980-11-19', 'male', '58, Ghalib Society, Andheri Chandigarh - 456744', 'Srinagar', 'Daman and Diu', 'Equatorial Guinea', '517066', 'Omnis dolores aliquid deserunt. Ea sit vel doloribus. Ea quasi nesciunt quam reprehenderit et quas facilis. Expedita quia itaque nisi dolor quod.', '2024-07-27 08:09:21', '2024-07-27 08:09:21', NULL, NULL, 59),
(38, 'Sid', 'Mitter', 'Sid Mitter', 'sara18@example.com', '+91 9123815592', '2020-09-05', 'male', '63, Malad, Bhubhaneshwar - 556658', 'Kanpur', 'Mizoram', 'American Samoa', '384586', 'Quis dolorem est atque nostrum sequi vero non hic. Ipsa dolore voluptatem voluptatem modi provident incidunt. Suscipit culpa modi modi repudiandae consequatur non non.', '2024-07-27 08:09:21', '2024-07-27 08:09:21', NULL, NULL, 60),
(39, 'Ekbal', 'Somani', 'Ekbal Somani', 'vimala.thaker@example.com', '07777026913', '2010-11-19', 'male', '20, Cyber City, Jammu - 589879', 'Noida', 'Jharkhand', 'Uganda', '238267', 'Ipsa in et omnis accusantium debitis aut. Et dolores quia quam omnis mollitia dolor dolores. Debitis neque earum ut qui possimus aliquid.', '2024-07-27 08:09:21', '2024-07-27 08:09:21', NULL, NULL, 61),
(40, 'Megha', 'Rau', 'Megha Rau', 'mona23@example.org', '07331026700', '1982-03-16', 'female', '55, Urmi Heights, RickyGarh Panaji - 133944', 'Surat', 'Rajasthan', 'Ireland', '263826', 'Voluptatem vel ratione placeat velit. Dolor ullam rerum eos sapiente rerum. Assumenda quo ab consequatur qui ut aut. Ut ex nisi et excepturi unde itaque quo voluptate.', '2024-07-27 08:09:22', '2024-07-27 08:09:22', NULL, NULL, 62),
(41, 'Suresh', 'Batra', 'Suresh Batra', 'chhavi.garg@example.org', '07936618680', '1987-07-14', 'male', '75, Jamshed Society, Harmada Panaji - 447288', 'Meerut', 'Goa', 'Slovenia', '285986', 'Consequatur quam quos est fugiat. Id excepturi facilis adipisci non cumque et architecto atque. Dolores iste autem impedit saepe ut dolore harum.', '2024-07-27 08:09:22', '2024-07-27 08:09:22', NULL, NULL, 63),
(42, 'Nirmal', 'Seshadri', 'Nirmal Seshadri', 'bagwati65@example.com', '+91 8877394452', '1988-08-28', 'female', '58, SavitaGarh, Jabalpur - 557565', 'Thiruvananthapuram', 'Bihar', 'Uganda', '151408', 'Sed sed debitis voluptate dolores eum quia. Debitis eum laborum neque adipisci qui. Facilis recusandae tempore quas aut sunt cupiditate dicta.', '2024-07-27 08:09:22', '2024-07-27 08:09:22', NULL, NULL, 64),
(43, 'Abhinav', 'Dugar', 'Abhinav Dugar', 'gayatri36@example.net', '07961224941', '2001-09-16', 'male', '33, Nupur Apartments, AarushiGunj Faridabad - 354125', 'Warangal', 'Andhra Pradesh', 'Benin', '220579', 'Voluptatem corporis eveniet et labore. Iste laudantium quos qui. Quidem qui quaerat harum quidem distinctio in natus. In facere magnam fugiat.', '2024-07-27 08:09:22', '2024-07-27 08:09:22', NULL, NULL, 65),
(44, 'Naval', 'Kurian', 'Naval Kurian', 'mody.zara@example.com', '08829021886', '1995-05-08', 'male', '22, Model Town, Hisar - 405690', 'Vadodara', 'Sikkim', 'Barbados', '332510', 'Nemo quibusdam ut aut voluptatem veniam soluta sequi. Ut non dicta quidem dolores deserunt eius vero. Cupiditate explicabo quidem aperiam minus veniam. Ea occaecati quia asperiores debitis.', '2024-07-27 08:09:23', '2024-07-27 08:09:23', NULL, NULL, 66),
(45, 'Avantika', 'Mahadeo', 'Avantika Mahadeo', 'rosey.sur@example.net', '08193664445', '1974-10-02', 'male', '60, Sabina Apartments, MahmoodGunj Agra - 480348', 'Indore', 'Gujarat', 'Netherlands Antilles', '288921', 'Ipsum ad ullam amet. Minima quo est laboriosam rerum. Suscipit dolorem deleniti sed dignissimos. Quidem rem dolor quod et quibusdam suscipit ut.', '2024-07-27 08:09:23', '2024-07-27 08:09:23', NULL, NULL, 67),
(46, 'Chhavi', 'Dass', 'Chhavi Dass', 'twason@example.net', '09127575488', '2010-11-14', 'female', '43, Sid Villas, Harmada Nashik - 330910', 'Simla', 'Andaman and Nicobar Islands', 'El Salvador', '520451', 'Ut asperiores asperiores nobis. Consequatur nam aut dolores. Ut autem rerum beatae aperiam quia dolorum. Voluptas tenetur quaerat voluptatibus harum impedit fugiat.', '2024-07-27 08:09:23', '2024-07-27 08:09:23', NULL, NULL, 68),
(47, 'Baalkrishan', 'Kade', 'Baalkrishan Kade', 'subramaniam.sabina@example.com', '+91 9787697148', '1988-12-31', 'male', '94, Aisha Heights, Model Town Indore - 499236', 'Gurgaon', 'Gujarat', 'Uganda', '101450', 'Consequatur odit non quis et molestiae numquam. Dolores debitis quisquam non hic asperiores ut. Consectetur accusantium est reprehenderit eius fugiat. Corporis asperiores quis dolor nihil hic et.', '2024-07-27 08:09:24', '2024-07-27 08:09:24', NULL, NULL, 69),
(48, 'Alex', 'Char', 'Alex Char', 'edutta@example.org', '+91 9776561832', '2008-03-13', 'female', '92, Babita Heights, Vikhroli Gangtok - 347820', 'Jabalpur', 'Rajasthan', 'Holy See (Vatican City State)', '422528', 'Nesciunt sit sint quidem voluptatum ipsam. Voluptate nemo dolores nihil debitis. Beatae nulla dolorem voluptatum corporis temporibus nihil.', '2024-07-27 08:09:24', '2024-07-27 08:09:24', NULL, NULL, 70),
(49, 'Yogesh', 'Butala', 'Yogesh Butala', 'harbhajan05@example.com', '+91 9949785727', '1984-04-24', 'male', '82, Gayatri Apartments, Hinjewadi Panaji - 240532', 'Jodhpur', 'Meghalaya', 'Iran', '599980', 'Expedita molestiae omnis ipsam. Illo quas perferendis quibusdam dolorum. Voluptates autem consequatur dolor porro sint ab.', '2024-07-27 08:09:24', '2024-07-27 08:09:24', NULL, NULL, 71),
(50, 'Pushpa', 'Khatri', 'Pushpa Khatri', 'sha.laveena@example.net', '08770893153', '2022-09-11', 'male', '49, Devika Society, Dadar Ajmer - 599827', 'Dehra Dun', 'Kerala', 'Japan', '549685', 'Quisquam facilis facilis accusantium. Voluptate eum autem recusandae sit alias qui est. Distinctio iste illum saepe et.', '2024-07-27 08:09:24', '2024-07-27 08:09:24', NULL, NULL, 72),
(51, 'Kalpit', 'Shankar', 'Kalpit Shankar', 'singh.riddhi@example.net', '+91 7569316200', '1975-09-07', 'male', '96, Shobha Chowk, Guwahati - 497573', 'Agra', 'West Bengal', 'Niger', '213011', 'Aliquam possimus sunt ut praesentium saepe alias placeat. Enim et minima dignissimos voluptas nihil incidunt. Fugit debitis suscipit accusantium aut cum eos autem.', '2024-07-27 08:09:25', '2024-07-27 08:09:25', NULL, NULL, 73),
(52, 'Krishna', 'Nagi', 'Krishna Nagi', 'suresh.malpani@example.com', '+91 8523692646', '1979-05-30', 'female', '34, Charandeep Villas, Borivali Meerut - 175104', 'Jodhpur', 'Odisha', 'Belgium', '474371', 'Porro minima aperiam quae impedit tempore fugiat. Enim omnis tempore beatae itaque. Vel maxime excepturi aut culpa. Sequi aliquam vitae voluptate consequatur magnam rerum eius.', '2024-07-27 08:09:25', '2024-07-27 08:09:25', NULL, NULL, 74),
(53, 'Sheetal', 'Rajagopalan', 'Sheetal Rajagopalan', 'ydoshi@example.com', '09669590216', '2015-09-26', 'male', '29, Qabeel Heights, BalajiPur Dehra Dun - 598273', 'Dehra Dun', 'Daman and Diu', 'Seychelles', '410472', 'Officiis eius ut atque ut. Temporibus omnis animi praesentium et voluptatem provident.', '2024-07-27 08:09:25', '2024-07-27 08:09:25', NULL, NULL, 75),
(54, 'Vijay', 'Varughese', 'Vijay Varughese', 'heer11@example.org', '09823824110', '1973-12-25', 'male', '81, NupurGunj, Guwahati - 502679', 'Bengaluru', 'Punjab', 'Faroe Islands', '385987', 'Temporibus eum libero occaecati corrupti dolorem. Aut itaque dicta totam et consequatur eos ut.', '2024-07-27 08:09:26', '2024-07-27 08:09:26', NULL, NULL, 76),
(55, 'Kiran', 'Konda', 'Kiran Konda', 'hemendra27@example.net', '07095010161', '1984-11-24', 'female', '57, Azhar Nagar, Delhi - 420261', 'Gandhinagar', 'Madhya Pradesh', 'Chile', '282792', 'Et nobis eos et est debitis. Consequatur ex nulla hic. Aut autem nihil ex et. Quis quasi rem aut tenetur ad. Placeat deserunt ut eum iste eum fugiat. Delectus non quae doloribus ratione.', '2024-07-27 08:09:26', '2024-07-27 08:09:26', NULL, NULL, 77),
(56, 'Avantika', 'Edwin', 'Avantika Edwin', 'ramgopal.anne@example.net', '+91 7571251889', '1972-01-15', 'male', '98, Amrita Chowk, Udaipur - 363249', 'Raipur', 'Delhi', 'Central African Republic', '148908', 'Autem eos ea fugiat sunt in vel amet. Minima maiores voluptatem quia enim. Dolorem ut velit quas magnam nihil.', '2024-07-27 08:09:26', '2024-07-27 08:09:26', NULL, NULL, 78),
(57, 'Akhila', 'Mani', 'Akhila Mani', 'shan.chitranjan@example.org', '07457898100', '1986-07-06', 'male', '97, SaraPur, Ranchi - 473698', 'Indore', 'Punjab', 'Svalbard & Jan Mayen Islands', '345191', 'Ea dolore nostrum repellendus. Voluptatum est dignissimos in nam voluptas nostrum. Ut deleniti veritatis soluta quis error eius. Et nulla nam eveniet vero quam.', '2024-07-27 08:09:26', '2024-07-27 08:09:26', NULL, NULL, 79),
(58, 'Tabeed', 'Venkatesh', 'Tabeed Venkatesh', 'bagate@example.net', '+91 9427744416', '2000-07-08', 'male', '80, Binita Chowk, Alwar - 446485', 'Indore', 'West Bengal', 'Saint Vincent and the Grenadines', '342125', 'Fugit quidem beatae fugiat aut. Modi quidem facilis molestiae. Odio facilis nihil saepe asperiores. Dolorum est quia sit accusantium fuga adipisci non. Qui ipsa quam sunt rerum magnam.', '2024-07-27 08:09:27', '2024-07-27 08:09:27', NULL, NULL, 80),
(59, 'Mridula', 'Shenoy', 'Mridula Shenoy', 'gauransh33@example.net', '08673924985', '1993-12-26', 'male', '42, Sweta Society, Churchgate Bhopal - 434901', 'Patna', 'Delhi', 'Kenya', '360733', 'Facere assumenda autem ea dolores. Vel id velit corporis et vitae magni. Consequatur dolorum aperiam perferendis dicta. Omnis esse facilis voluptates natus officia laborum.', '2024-07-27 08:09:27', '2024-07-27 08:09:27', NULL, NULL, 81),
(60, 'Venkat', 'Chaudhuri', 'Venkat Chaudhuri', 'wagle.hanuman@example.com', '+91 8914058538', '1970-01-05', 'female', '63, Mohan Nagar, Gangtok - 496081', 'Jaipur', 'Uttar Pradesh', 'Kiribati', '146286', 'Ratione quo labore perspiciatis qui vero. A a mollitia sapiente quia quia labore dolorem vero. Ipsa et nisi tempore non omnis labore non qui. Minus aut eveniet quaerat corrupti.', '2024-07-27 08:09:27', '2024-07-27 08:09:27', NULL, NULL, 82),
(61, 'Damini', 'Chohan', 'Damini Chohan', 'kajol53@example.com', '+91 8579883252', '2002-10-15', 'female', '32, Deccan Gymkhana, Ranchi - 224474', 'Pune', 'Chandigarh', 'Finland', '399352', 'Ea sit consectetur doloribus vero aliquam laudantium sequi. Sunt eos omnis ullam maiores quisquam. Similique officiis eos perspiciatis cum aut. Vitae quas expedita dolor voluptas voluptas occaecati.', '2024-07-27 08:09:28', '2024-07-27 08:09:28', NULL, NULL, 83),
(62, 'Chirag', 'Gera', 'Chirag Gera', 'nutan29@example.com', '07607356428', '2002-07-05', 'male', '17, Dhiraj Chowk, Hyderabad - 174436', 'Trichy', 'Odisha', 'Netherlands Antilles', '101660', 'Laboriosam ea facilis voluptatibus sed assumenda. Ut iste fuga voluptatibus qui unde illum libero. Nesciunt et explicabo facere enim voluptate voluptatum est.', '2024-07-27 08:09:28', '2024-07-27 08:09:28', NULL, NULL, 84),
(63, 'Siddharth', 'Jani', 'Siddharth Jani', 'raja.prabhat@example.net', '+91 9108631313', '2003-12-26', 'male', '54, Cyber City, Jammu - 579665', 'Pondicherry', 'Andhra Pradesh', 'Greece', '416263', 'Illum et et est blanditiis vel corrupti. Rerum dolorem quibusdam mollitia. Iusto ut ab quasi. Nesciunt nisi fuga fugiat corrupti eaque.', '2024-07-27 08:09:28', '2024-07-27 08:09:28', NULL, NULL, 85),
(64, 'Balaji', 'Chawla', 'Balaji Chawla', 'ichana@example.net', '07871576066', '2008-04-15', 'female', '23, Jasmin Villas, Aundh Ludhiana - 396969', 'Alwar', 'Sikkim', 'Uruguay', '290521', 'Autem quo voluptas voluptas qui culpa sunt quis in. Sed quod quibusdam sit cupiditate at cum illum. Eos qui omnis ab quas consequuntur quas maiores.', '2024-07-27 08:09:28', '2024-07-27 08:09:28', NULL, NULL, 86),
(65, 'Nayan', 'Palan', 'Nayan Palan', 'ssura@example.net', '+91 8819564315', '1989-12-04', 'male', '13, Falguni Villas, Borivali Pune - 153629', 'Ahmedabad', 'Rajasthan', 'Maldives', '100487', 'Rerum ut architecto vel doloribus. Suscipit aut quae a dolorum optio aspernatur. Soluta perspiciatis cupiditate deserunt dolor. Sint maiores illum quaerat ea tempora facere sit autem.', '2024-07-27 08:09:29', '2024-07-27 08:09:29', NULL, NULL, 87),
(66, 'Kalyani', 'Sangha', 'Kalyani Sangha', 'ajeet.dara@example.net', '09090979301', '1989-06-12', 'female', '26, AnshuGunj, Rajkot - 331966', 'Jabalpur', 'Punjab', 'French Southern Territories', '563302', 'Et autem quia qui nobis praesentium aut. Optio ex tempora ipsum et quasi. Earum possimus aspernatur velit aut totam omnis. Minima earum culpa aut et.', '2024-07-27 08:09:29', '2024-07-27 08:09:29', NULL, NULL, 88),
(67, 'Laveena', 'Suresh', 'Laveena Suresh', 'thakur.leelawati@example.org', '07932025364', '1976-11-08', 'male', '62, Aruna Society, Yerwada Ludhiana - 209762', 'Ludhiana', 'Manipur', 'Jamaica', '238627', 'Voluptatem quia et saepe nobis aut quam et. At aspernatur cupiditate maiores fugiat explicabo. Iure iusto necessitatibus natus corrupti a itaque.', '2024-07-27 08:09:29', '2024-07-27 08:09:29', NULL, NULL, 89),
(68, 'Natwar', 'Venkataraman', 'Natwar Venkataraman', 'gala.kirti@example.org', '+91 9043268762', '1990-01-06', 'female', '94, Jack Chowk, Bhubhaneshwar - 216269', 'Vadodara', 'Puducherry', 'Algeria', '515728', 'Aliquam at placeat ut perspiciatis voluptatem vel non. Culpa voluptas beatae voluptas incidunt. Molestias soluta cupiditate non autem. Ut ut architecto repudiandae iste rerum.', '2024-07-27 08:09:30', '2024-07-27 08:09:30', NULL, NULL, 90),
(69, 'Julie', 'Puri', 'Julie Puri', 'brahmbhatt.mitesh@example.org', '+91 9147570593', '1985-01-27', 'male', '92, Preet Villas, HinaGunj Raipur - 414756', 'Meerut', 'Punjab', 'Christmas Island', '527234', 'Et et eveniet numquam et necessitatibus saepe. Veniam suscipit ut ea impedit et aut ut.', '2024-07-27 08:09:30', '2024-07-27 08:09:30', NULL, NULL, 91),
(70, 'Anees', 'Sarma', 'Anees Sarma', 'rakhi62@example.net', '08851568098', '1980-06-29', 'male', '69, SubhashGarh, Nagpur - 496092', 'Jabalpur', 'Madhya Pradesh', 'Chile', '131181', 'Dignissimos hic dolor nulla dolor sequi fugit doloribus. Recusandae itaque laudantium quam tenetur omnis. Et voluptatem aliquam ducimus quisquam quasi rem mollitia.', '2024-07-27 08:09:30', '2024-07-27 08:09:30', NULL, NULL, 92),
(71, 'Sid', 'Shukla', 'Sid Shukla', 'tata.krishna@example.com', '07870490438', '1996-11-06', 'male', '49, Atul Villas, Malad Pune - 514352', 'Lucknow', 'Meghalaya', 'Qatar', '594145', 'Qui magni velit minima. Et voluptas delectus quas ut non aperiam ducimus. Delectus architecto corporis sunt eos voluptatum et et. Excepturi sunt unde quibusdam aliquam.', '2024-07-27 08:09:30', '2024-07-27 08:09:30', NULL, NULL, 93),
(72, 'Aayushman', 'Usman', 'Aayushman Usman', 'laveena.salvi@example.com', '+91 7312642376', '2004-11-15', 'male', '18, BagwatiPur, Delhi - 558976', 'Kanpur', 'Uttar Pradesh', 'Sierra Leone', '209995', 'Omnis modi asperiores et. Et eligendi aliquam nemo natus rerum ut. Nulla omnis et sed dolore. Dolorem autem perferendis veritatis. Dolore sint eos nihil molestias suscipit.', '2024-07-27 08:09:31', '2024-07-27 08:09:31', NULL, NULL, 94),
(73, 'Sona', 'Korpal', 'Sona Korpal', 'rvarma@example.net', '+91 9040030620', '2019-12-20', 'male', '74, NidhiGunj, Guwahati - 276137', 'Panaji', 'Puducherry', 'Turks and Caicos Islands', '223490', 'Rerum saepe dolorem ad. Dolorum sint temporibus facilis reprehenderit quia. Quis alias quidem ut mollitia. Qui adipisci quidem temporibus.', '2024-07-27 08:09:31', '2024-07-27 08:09:31', NULL, NULL, 95),
(74, 'Madhavi', 'Handa', 'Madhavi Handa', 'aayushman.nanda@example.org', '09315510797', '1982-02-08', 'female', '45, Satish Society, Rahim Nagar Thiruvananthapuram - 316326', 'Meerut', 'West Bengal', 'British Virgin Islands', '111500', 'Aperiam accusamus quisquam laudantium distinctio incidunt. Et possimus deleniti iusto itaque accusantium ipsum et.', '2024-07-27 08:09:31', '2024-07-27 08:09:31', NULL, NULL, 96),
(75, 'Harpreet', 'Sandal', 'Harpreet Sandal', 'ndash@example.com', '+91 9654666516', '1990-02-16', 'male', '98, Mansarovar, Srinagar - 383489', 'Nashik', 'Delhi', 'Togo', '577295', 'Omnis aut totam eos praesentium beatae necessitatibus. Enim et eveniet qui nulla minus optio laboriosam quibusdam. Nostrum velit est maiores rerum quia. Ut dolores vel ut nam sunt earum.', '2024-07-27 08:09:32', '2024-07-27 08:09:32', NULL, NULL, 97),
(76, 'Rashid', 'Nagarajan', 'Rashid Nagarajan', 'himesh.bajwa@example.net', '+91 8948755570', '1986-09-17', 'male', '35, Akshay Society, EkbalGunj Chennai - 156545', 'Jammu', 'Mizoram', 'Norway', '221963', 'Natus ut accusamus vel. Dolorem et reprehenderit et minus iure fugiat. Voluptas vitae similique incidunt commodi sunt. Nobis commodi consequatur quo quidem repudiandae sit.', '2024-07-27 08:09:32', '2024-07-27 08:09:32', NULL, NULL, 98),
(77, 'Amir', 'Narula', 'Amir Narula', 'bahadur04@example.com', '+91 7453496942', '1979-08-05', 'male', '54, Vikhroli, Jabalpur - 271103', 'Srinagar', 'Telangana', 'Switzerland', '210064', 'Dolores autem perferendis blanditiis error est eveniet repellat. Dolorum dicta pariatur nihil quia. Beatae rem at quo. Quasi amet incidunt repellendus omnis culpa asperiores dolorem.', '2024-07-27 08:09:32', '2024-07-27 08:09:32', NULL, NULL, 99),
(78, 'Jayshree', 'Srinivas', 'Jayshree Srinivas', 'mgarg@example.net', '08217750453', '2013-10-01', 'male', '62, Naina Heights, Marathahalli Meerut - 488781', 'Nashik', 'Daman and Diu', 'Paraguay', '552764', 'Voluptatem consectetur pariatur nemo at omnis aut. Modi dolores alias non quo ea aut impedit inventore. Laboriosam in at atque error vel distinctio doloribus.', '2024-07-27 08:09:32', '2024-07-27 08:09:32', NULL, NULL, 100),
(79, 'Pinky', 'Cherian', 'Pinky Cherian', 'lbhatt@example.org', '+91 7291411975', '1971-11-10', 'female', '12, BagwatiGarh, Vadodara - 510006', 'Lucknow', 'Gujarat', 'Lebanon', '207305', 'Nihil suscipit suscipit natus autem sunt. Omnis velit quia voluptatem. Dolore ut doloribus quo quam iusto in. Nihil vel ut necessitatibus voluptatum.', '2024-07-27 08:09:33', '2024-07-27 08:09:33', NULL, NULL, 101),
(80, 'Pamela', 'Mangat', 'Pamela Mangat', 'cdhawan@example.org', '+91 7558566661', '1998-10-07', 'female', '52, Biren Nagar, Simla - 576692', 'Gurgaon', 'Telangana', 'Niue', '426677', 'Et et officia ea nemo est quo. Id consequuntur ducimus sunt amet. Consequatur illo qui maiores doloremque consequatur quis laboriosam.', '2024-07-27 08:09:33', '2024-07-27 08:09:33', NULL, NULL, 102),
(81, 'Yadunandan', 'Dhillon', 'Yadunandan Dhillon', 'monica.singhal@example.com', '+91 8620849594', '2006-05-20', 'female', '51, Marathahalli, Nashik - 434196', 'Jammu', 'Mizoram', 'Romania', '509712', 'Velit magni delectus reiciendis explicabo aut alias fuga temporibus. Magnam quasi tenetur consequuntur deleniti. Qui aliquam deserunt exercitationem fuga.', '2024-07-27 08:09:33', '2024-07-27 08:09:33', NULL, NULL, 103),
(82, 'Baber', 'Chia', 'Baber Chia', 'sid.sodhani@example.net', '08877650439', '2019-06-22', 'female', '30, RadhikaGunj, Kanpur - 189817', 'Vishakhapattanam', 'Assam', 'India', '169655', 'Temporibus dignissimos quaerat molestiae quo omnis quibusdam modi. Aut neque praesentium autem quia. Eum vel ipsum sequi. Numquam asperiores eaque dolorem est.', '2024-07-27 08:09:33', '2024-07-27 08:09:33', NULL, NULL, 104),
(83, 'Jyoti', 'Sama', 'Jyoti Sama', 'hsuresh@example.com', '09965003024', '2019-02-26', 'male', '37, Jasmin Society, Cyber City Alwar - 153678', 'Alwar', 'Andaman and Nicobar Islands', 'French Guiana', '202462', 'Molestiae et animi velit voluptatum et nulla. Nam minima ut soluta non. Consequatur doloribus in omnis maxime rem quam aut.', '2024-07-27 08:09:34', '2024-07-27 08:09:34', NULL, NULL, 105),
(84, 'Anshula', 'Oak', 'Anshula Oak', 'faraz32@example.net', '+91 7380801037', '1998-08-01', 'male', '79, Karim Apartments, YogeshPur Delhi - 357729', 'Kanpur', 'Karnataka', 'Niger', '496895', 'Distinctio vel sed nesciunt aut facere tempore ipsum. Pariatur veniam aut voluptatem saepe. Praesentium voluptatibus minima excepturi laboriosam nulla omnis aut.', '2024-07-27 08:09:34', '2024-07-27 08:09:34', NULL, NULL, 106),
(85, 'Taahid', 'Salvi', 'Taahid Salvi', 'upasana64@example.net', '+91 9018440162', '1977-12-15', 'female', '27, Mona Villas, AkhilPur Hisar - 106914', 'Agra', 'Delhi', 'Oman', '420595', 'Delectus temporibus quibusdam hic laudantium facilis. Numquam cumque laudantium animi perspiciatis ipsa eius. Non est quaerat delectus voluptas qui.', '2024-07-27 08:09:34', '2024-07-27 08:09:34', NULL, NULL, 107),
(86, 'Elias', 'Cherian', 'Elias Cherian', 'sahota.yasmin@example.org', '+91 9514937466', '2010-05-28', 'female', '79, Chinmay Heights, Kormangala Bhopal - 380371', 'Hisar', 'Himachal Pradesh', 'Denmark', '228315', 'Voluptatem nulla est quia sed error illum eveniet. At et impedit eligendi eius ab atque est. Est asperiores omnis rerum qui fugiat.', '2024-07-27 08:09:35', '2024-07-27 08:09:35', NULL, NULL, 108),
(87, 'Aarushi', 'Saini', 'Aarushi Saini', 'saraf.madhu@example.com', '07938232919', '2009-06-19', 'female', '86, Virat Villas, BrockGarh Kanpur - 368412', 'Hisar', 'Gujarat', 'Switzerland', '184777', 'Occaecati animi dolore est quia cupiditate enim voluptas. Et porro et maiores impedit odit vitae. Similique omnis ipsum quia occaecati molestiae. Nemo et et accusamus fuga qui ipsum pariatur dolorem.', '2024-07-27 08:09:35', '2024-07-27 08:09:35', NULL, NULL, 109),
(88, 'Lakshmi', 'Gala', 'Lakshmi Gala', 'kirti.dugar@example.com', '07377169001', '2012-06-28', 'male', '29, Nishi Heights, IndiraPur Gurgaon - 549135', 'Raipur', 'Manipur', 'Wallis and Futuna', '126238', 'Laboriosam dolor necessitatibus soluta fugit. Rerum non vel minus amet necessitatibus. Rerum consequatur hic quia autem sit repellat et. Id dolorem earum eum alias dolor laboriosam.', '2024-07-27 08:09:35', '2024-07-27 08:09:35', NULL, NULL, 110),
(89, 'Peter', 'Sha', 'Peter Sha', 'varughese.fardeen@example.org', '+91 7150199230', '1998-07-23', 'female', '41, Sai Chowk, Udaipur - 235757', 'Kanpur', 'Bihar', 'Mayotte', '499014', 'Magnam reiciendis repellat omnis. Et animi porro inventore et. Ea sunt commodi eum enim nihil. Eius maiores rerum magnam reprehenderit nihil.', '2024-07-27 08:09:35', '2024-07-27 08:09:35', NULL, NULL, 111),
(90, 'Sushmita', 'Date', 'Sushmita Date', 'diya10@example.org', '09588974422', '2012-12-05', 'male', '57, Wafiq Heights, Yeshwanthpura Srinagar - 267375', 'Thiruvananthapuram', 'Sikkim', 'El Salvador', '315973', 'Iusto repellendus natus pariatur ut ratione iusto. Ut qui delectus rerum nihil doloribus. Laudantium aut accusamus voluptatibus numquam et est tempora qui. Quidem natus reiciendis delectus quod quam.', '2024-07-27 08:09:36', '2024-07-27 08:09:36', NULL, NULL, 112),
(91, 'Farah', 'Manne', 'Farah Manne', 'gulzar07@example.com', '07616274928', '1974-05-23', 'female', '48, Madhu Apartments, Andheri Bhubhaneshwar - 175613', 'Surat', 'Odisha', 'Brazil', '554878', 'Nihil quas eos recusandae minus facilis. Sapiente aperiam asperiores repudiandae eaque tenetur. Rem doloremque quo quia amet ut maxime minus. Culpa molestiae quasi at dicta ut.', '2024-07-27 08:09:36', '2024-07-27 08:09:36', NULL, NULL, 113),
(92, 'Pradeep', 'Pandit', 'Pradeep Pandit', 'bose.zaad@example.org', '07219839281', '1989-12-15', 'male', '43, Babita Villas, Drishti Chowk Bhopal - 428711', 'Lucknow', 'West Bengal', 'Cote d\'Ivoire', '520939', 'Recusandae reiciendis possimus sed. Nihil ut natus fugiat ab quia corporis impedit voluptas. Suscipit ducimus provident qui. Aspernatur modi est rerum tempora atque.', '2024-07-27 08:09:36', '2024-07-27 08:09:36', NULL, NULL, 114),
(93, 'Aditi', 'Master', 'Aditi Master', 'pirzada.sangha@example.com', '+91 9753732908', '1971-03-28', 'female', '69, Mustafa Society, IndiraPur Hisar - 531452', 'Kolkata', 'Punjab', 'Paraguay', '433596', 'Ipsum consequatur voluptatem consequatur omnis pariatur facere. Rerum ut commodi nam in. Tenetur omnis deserunt non laudantium quia itaque. Dolorum omnis et rem voluptas laborum placeat.', '2024-07-27 08:09:37', '2024-07-27 08:09:37', NULL, NULL, 115),
(94, 'Bahadur', 'Bajwa', 'Bahadur Bajwa', 'ekibe@example.com', '+91 9724859580', '1992-03-26', 'female', '58, Sweta Society, PrabhatGunj Delhi - 205519', 'Jamnagar', 'Goa', 'Liberia', '228303', 'Aut earum eaque officia ullam. Et id dolore delectus exercitationem. Nulla modi id aut quia nobis.', '2024-07-27 08:09:37', '2024-07-27 08:09:37', NULL, NULL, 116),
(95, 'Nalini', 'Sarna', 'Nalini Sarna', 'ahluwalia.emran@example.net', '08112308459', '1980-05-27', 'male', '61, Pravin Society, IshaPur Kanpur - 331563', 'Hisar', 'Punjab', 'El Salvador', '480151', 'Et quisquam dolores repudiandae sed eligendi et quia. Consequuntur culpa repellat possimus quibusdam fugit. Aperiam nobis rerum eos blanditiis.', '2024-07-27 08:09:37', '2024-07-27 08:09:37', NULL, NULL, 117),
(96, 'Nancy', 'Ben', 'Nancy Ben', 'abiyani@example.net', '08882698098', '2023-01-07', 'female', '68, Sneha Villas, AdityaGarh Gangtok - 101921', 'Guwahati', 'Odisha', 'Reunion', '269173', 'Temporibus sunt minus deleniti ut qui et. Odio esse et nostrum quo adipisci dolores.', '2024-07-27 08:09:37', '2024-07-27 08:09:37', NULL, NULL, 118),
(97, 'Radheshyam', 'Mukherjee', 'Radheshyam Mukherjee', 'payal.ramanathan@example.net', '07231873269', '1991-08-30', 'male', '32, Aarif Villas, Dadar Jabalpur - 209786', 'Simla', 'Telangana', 'Central African Republic', '241991', 'Laboriosam dicta et occaecati est nihil. Eum aut fuga nisi quasi similique. Unde voluptas est laborum nulla mollitia enim similique. Rem at quae eum hic.', '2024-07-27 08:09:38', '2024-07-27 08:09:38', NULL, NULL, 119),
(98, 'Mona', 'Oza', 'Mona Oza', 'varghese.akanksha@example.net', '09162312263', '1996-11-29', 'male', '73, Ganesh Heights, Bandra Thiruvananthapuram - 477294', 'Guwahati', 'Sikkim', 'Bosnia and Herzegovina', '349447', 'Aut hic consequatur voluptatem. Quia sunt aut nisi aperiam recusandae. Ipsum et ut quia a est nulla molestiae.', '2024-07-27 08:09:38', '2024-07-27 08:09:38', NULL, NULL, 120),
(99, 'Harbhajan', 'Chana', 'Harbhajan Chana', 'omagar@example.org', '09069181745', '1976-12-20', 'male', '27, Pinky Apartments, Churchgate Pilani - 182495', 'Darjeeling', 'Andaman and Nicobar Islands', 'Monaco', '231190', 'Nemo fugiat ut dolorum. Modi quod fuga accusamus ut voluptatem. Itaque aspernatur aliquid harum alias nihil et.', '2024-07-27 08:09:38', '2024-07-27 08:09:38', NULL, NULL, 121),
(100, 'Giaan', 'Ranganathan', 'Giaan Ranganathan', 'supriya62@example.org', '+91 9813883724', '1989-09-24', 'male', '97, Raju Society, Vikhroli Nashik - 326364', 'Ratlam', 'Andhra Pradesh', 'Nepal', '226712', 'Recusandae sit reiciendis vitae consequuntur fugiat fugiat. Tempora cupiditate est est et amet. Dolore occaecati sequi qui quo ut asperiores.', '2024-07-27 08:09:39', '2024-07-27 08:09:39', NULL, NULL, 122),
(101, 'Sunil', 'Saha', 'Sunil Saha', 'ss@gmail.com', '+91 87875 69623', '1980-06-07', 'male', 'Kashi Bose Lane', 'Kolkata', 'West Bengal', 'India', '700025', NULL, '2024-07-28 07:13:17', '2024-07-28 07:18:28', NULL, NULL, 123);

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

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 1, 'Personal Access Token', '9ffaf6463cff2b85407ffaea22300f8be2a8bde42ca52d7c2da085eba30a4c35', '[\"*\"]', NULL, NULL, '2024-05-04 19:52:51', '2024-05-04 19:52:51'),
(2, 'App\\Models\\User', 1, 'Personal Access Token', '2df83b618775fee285caebc8027c5545d244e2e39ddaec8d0bfa9890f78215d6', '[\"*\"]', NULL, NULL, '2024-05-04 19:52:55', '2024-05-04 19:52:55'),
(3, 'App\\Models\\User', 1, 'Personal Access Token', '389dccf37baab936df8a9392d69f55e18b203b2d4e3702662625e06901a01abb', '[\"*\"]', NULL, NULL, '2024-05-04 19:52:58', '2024-05-04 19:52:58'),
(4, 'App\\Models\\User', 1, 'Personal Access Token', '0b2b00dd4d7ad6d5fc1514b55738dc5b52e3829ff11d7e377bb3602daa48e6f2', '[\"*\"]', NULL, NULL, '2024-05-04 19:53:02', '2024-05-04 19:53:02'),
(5, 'App\\Models\\User', 1, 'Personal Access Token', '8976081c05b2a22c12e171f44ac8939b2a9bdbc3008401dba6a66d7caaa60df6', '[\"*\"]', NULL, NULL, '2024-05-04 19:54:28', '2024-05-04 19:54:28'),
(6, 'App\\Models\\User', 1, 'Personal Access Token', '1911d446355357f6eb13a235c528751e73dc5850f24047edf2aab777512ec239', '[\"*\"]', NULL, NULL, '2024-05-04 19:55:32', '2024-05-04 19:55:32'),
(7, 'App\\Models\\User', 1, 'Personal Access Token', '332ae695b681662df70bb620f4dd7185365683c0a083c5e10881b65ffc37bdca', '[\"*\"]', NULL, NULL, '2024-05-05 07:18:50', '2024-05-05 07:18:50'),
(8, 'App\\Models\\User', 1, 'Personal Access Token', '118264cfaa94e667b67dc77143dfb386da3efb90f5cad9beabcbb990a1364947', '[\"*\"]', NULL, NULL, '2024-05-05 07:57:45', '2024-05-05 07:57:45'),
(9, 'App\\Models\\User', 1, 'Personal Access Token', 'aa72351a6be6825c34710422a02667caa2cab4cc7c9614ee34838d0e7649719d', '[\"*\"]', NULL, NULL, '2024-05-05 08:05:00', '2024-05-05 08:05:00'),
(10, 'App\\Models\\User', 1, 'Personal Access Token', '5993a300ff4dedc88bb35b3a5c0e72d6138cdaa6b626f140e11d0eab5f4678e8', '[\"*\"]', NULL, NULL, '2024-05-05 08:05:37', '2024-05-05 08:05:37'),
(11, 'App\\Models\\User', 1, 'Personal Access Token', '316667fc370f2a731e40e61b80e7469a82817b5527a8cbcf813e56118d306f1d', '[\"user_role:supar_admin\"]', NULL, NULL, '2024-05-05 13:04:09', '2024-05-05 13:04:09'),
(12, 'App\\Models\\User', 1, 'Personal Access Token', '1a6316053702b3d34f68e9a9fbf6ed482480d27ca10e9af615e23ae9d269e2ce', '[\"user_role:supar_admin\",\"user_id:1\",\"user_email:admin@gmail.com\",\"user_role_name:supar_admin\"]', NULL, NULL, '2024-05-05 13:06:22', '2024-05-05 13:06:22'),
(13, 'App\\Models\\User', 1, 'Personal Access Token', '07dc5c44eb5f7bb7f7b5a6740e0008e24a3d79b75a481c8af32f1d49fb74cb7f', '[\"user_role:supar_admin\",\"user_id:1\",\"user_email:admin@gmail.com\",\"user_role_name:supar_admin\"]', NULL, NULL, '2024-05-05 13:07:46', '2024-05-05 13:07:46'),
(14, 'App\\Models\\User', 1, 'Personal Access Token', 'd8054013d2ae8ea1c3bce86da3551884f9249f8356f92d9777925e44c4fae6a2', '[\"user_role:supar_admin\",\"user_id:1\",\"user_email:admin@gmail.com\",\"user_role_name:supar_admin\"]', NULL, NULL, '2024-05-05 17:46:16', '2024-05-05 17:46:16'),
(15, 'App\\Models\\User', 19, 'Personal Access Token', 'ba0f19d2fdeea12f0239a14aaa2fca3d2fb9368a1d94340b9d1ae4ffb2bdb978', '[\"user_role:collector\",\"user_id:19\",\"user_email:c@gm\",\"user_role_name:collector\"]', NULL, NULL, '2024-05-05 17:47:46', '2024-05-05 17:47:46'),
(16, 'App\\Models\\User', 19, 'Personal Access Token', '065a36cf1c67970f50f9e83bd1a2e74bba30fd7abca68a6e001b57b5199c70f5', '[\"user_role:collector\",\"user_id:19\",\"user_email:c@gm\",\"user_role_name:collector\"]', '2024-05-05 20:15:22', NULL, '2024-05-05 18:29:10', '2024-05-05 20:15:22'),
(17, 'App\\Models\\User', 19, 'Personal Access Token', '92499e37a6113c603a789b641f0cb9008f93cea3657e633e951c2a3cc9984800', '[\"user_role:collector\",\"user_id:19\",\"user_email:c@gm\",\"user_role_name:collector\"]', '2024-05-05 20:21:08', NULL, '2024-05-05 20:19:46', '2024-05-05 20:21:08'),
(18, 'App\\Models\\User', 19, 'Personal Access Token', 'a58325d56185606b6b56c95c06018311e66bcc30a81f5804b6bb6147004cd87b', '[\"user_role:collector\",\"user_id:19\",\"user_email:c@gm\",\"user_role_name:collector\"]', '2024-05-12 08:27:28', NULL, '2024-05-11 11:07:12', '2024-05-12 08:27:28'),
(19, 'App\\Models\\User', 19, 'Personal Access Token', '1f7ec7025438dfc78333480b196aee62bf34d4498727442b8089d40217f885fc', '[\"user_role:collector\",\"user_id:19\",\"user_email:c@gm\",\"user_role_name:collector\"]', NULL, NULL, '2024-05-11 17:04:40', '2024-05-11 17:04:40'),
(20, 'App\\Models\\User', 19, 'Personal Access Token', '0b03a78419aed02f1cdcb742084ea2328d547dff46449a6cef3d387e15efad6c', '[\"user_role:collector\",\"user_id:19\",\"user_email:c@gm\",\"user_role_name:collector\"]', '2024-05-19 18:04:11', NULL, '2024-05-19 17:55:37', '2024-05-19 18:04:11'),
(21, 'App\\Models\\User', 2, 'Personal Access Token', '87c3f8db39e77485b217feccb53db3720b09f1e11dfee78f24356ea0a056f018', '[\"user_role:laboratory\",\"user_id:2\",\"user_email:srl_naihati@gmail.com\",\"user_role_name:laboratory\"]', NULL, NULL, '2024-07-14 15:03:51', '2024-07-14 15:03:51'),
(22, 'App\\Models\\User', 23, 'Personal Access Token', '6621fdd8892810ff3eb1bb4dadf4dc373f76f3265167bbce0f7131382f34f3e4', '[\"user_role:user\",\"user_id:23\",\"user_email:+91 98304 73119\",\"user_role_name:7\"]', NULL, NULL, '2024-07-16 18:11:55', '2024-07-16 18:11:55'),
(23, 'App\\Models\\User', 23, 'Personal Access Token', '0a71c6462ea1ed10d1a9fd482592748c93cef863e091b3894ce20a285913ce1d', '[\"user_role:user\",\"user_id:23\",\"user_email:+91 98304 73119\",\"user_role_name:7\"]', NULL, NULL, '2024-07-16 18:16:51', '2024-07-16 18:16:51'),
(24, 'App\\Models\\User', 23, 'Personal Access Token', 'de6afea001977669ad08498410f2c96140d4230444536fc2320a2ba6cdbe9ce0', '[\"user_role:user\",\"user_id:23\",\"user_email:+91 98304 73119\",\"user_role_name:7\"]', NULL, NULL, '2024-07-16 18:17:05', '2024-07-16 18:17:05'),
(25, 'App\\Models\\User', 24, 'Personal Access Token', 'a7a12022aff5b043073cb0106cf7fd6ae40cb094b46b868ebcfec03da9a5ca69', '[\"user_role:user\",\"user_id:24\",\"user_email:+91 98304 73120\",\"user_role_name:7\"]', NULL, NULL, '2024-07-16 18:17:17', '2024-07-16 18:17:17'),
(26, 'App\\Models\\User', 24, 'Personal Access Token', 'f41c7468a525131f9355dbe0a7be2e4c80c9bf2308e8c1f082662187af784207', '[\"user_role:user\",\"user_id:24\",\"user_email:+91 98304 73120\",\"user_role_name:7\"]', NULL, NULL, '2024-07-16 18:17:30', '2024-07-16 18:17:30'),
(27, 'App\\Models\\User', 24, 'Personal Access Token', 'da3f45a1a87088832993115879b2f418f4e4f6e83378b4f68c9842a040ed78d3', '[\"user_role:user\",\"user_id:24\",\"user_email:+91 98304 73120\",\"user_role_name:7\"]', NULL, NULL, '2024-07-16 18:17:35', '2024-07-16 18:17:35'),
(28, 'App\\Models\\User', 24, 'Personal Access Token', 'efe1f6ac3a00180a8f6de976dac26d6d25d006ac1cf473669d7995e12ced663b', '[\"user_role:user\",\"user_id:24\",\"user_email:+91 98304 73120\",\"user_role_name:7\"]', NULL, NULL, '2024-07-16 18:17:37', '2024-07-16 18:17:37'),
(29, 'App\\Models\\User', 25, 'Personal Access Token', 'e370074e38d11f8902310d4d39c9d9b201636c94cff26165a5832a404d474c2f', '[\"user_role:user\",\"user_id:25\",\"user_email:+91 87777 34169\",\"user_role_name:7\"]', '2024-07-20 14:26:38', NULL, '2024-07-20 14:24:55', '2024-07-20 14:26:38'),
(30, 'App\\Models\\User', 30, 'Personal Access Token', '440fc2f9ff87d1688dbc734425f96b08bfe621a4d319d3e82818c4eb06c19043', '[\"user_role:user\",\"user_id:30\",\"user_email:+91 71256 87281\",\"user_role_name:7\"]', NULL, NULL, '2024-07-21 13:17:22', '2024-07-21 13:17:22'),
(31, 'App\\Models\\User', 123, 'Personal Access Token', '8295294fd86c14d9cbdf32e480b6616a78924fa62f3fcb201a91d9b870303a69', '[\"user_role:user\",\"user_id:123\",\"user_email:+91 70896 62454\",\"user_role_name:7\"]', NULL, NULL, '2024-07-26 20:41:24', '2024-07-26 20:41:24'),
(32, 'App\\Models\\User', 123, 'Personal Access Token', '90138aaf5c3af7af5bcbe25d064003575359ddde0a8ec52746f90e3791f211a9', '[\"user_role:user\",\"user_id:123\",\"user_email:+91 70896 62454\",\"user_role_name:7\"]', NULL, NULL, '2024-07-26 20:41:46', '2024-07-26 20:41:46'),
(33, 'App\\Models\\User', 123, 'Personal Access Token', 'cf240186ca8558e70e51cfba94cbbb46c1de03475645b49c9410f89242bc5672', '[\"user_role:user\",\"user_id:123\",\"user_email:+91 70896 62454\",\"user_role_name:7\"]', NULL, NULL, '2024-07-26 20:41:51', '2024-07-26 20:41:51'),
(34, 'App\\Models\\User', 123, 'Personal Access Token', '04135c4d38ad1d0d6033b37960c4c354926e24e51bd0432756659a1fd0d98c71', '[\"user_role:user\",\"user_id:123\",\"user_email:+91 70896 62454\",\"user_role_name:7\"]', NULL, NULL, '2024-07-26 20:41:53', '2024-07-26 20:41:53'),
(35, 'App\\Models\\User', 23, 'Personal Access Token', '717eaf75e6c3f8e1632a1f0058479ee16595ceb9943028fdaa96b719e43f892b', '[\"user_role:user\",\"user_id:23\",\"user_email:xkhurana@example.org\",\"user_role_name:7\"]', '2024-07-27 17:45:13', NULL, '2024-07-27 09:14:17', '2024-07-27 17:45:13'),
(36, 'App\\Models\\User', 123, 'Personal Access Token', '4d576a05071f548367451344cc58e1f3975e1f4d7e7f913ec64f093086e5a26f', '[\"user_role:user\",\"user_id:123\",\"user_email:+91 84464 18279\",\"user_role_name:7\"]', '2024-07-28 18:17:26', NULL, '2024-07-28 07:13:17', '2024-07-28 18:17:26'),
(37, 'App\\Models\\User', 1, 'Personal Access Token', '6c979b90f7c055bcd1985addb33380d4ce0fbf03c63adcf7414c21795e751a67', '[\"user_role:supar_admin\",\"user_id:1\",\"user_email:admin@gmail.com\",\"user_role_name:supar_admin\"]', '2024-08-30 18:56:51', NULL, '2024-08-30 18:56:27', '2024-08-30 18:56:51');

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
(1, 'supar_admin', NULL, NULL),
(2, 'admin', NULL, NULL),
(3, 'manager', NULL, NULL),
(4, 'laboratory', NULL, NULL),
(5, 'doctor', NULL, NULL),
(6, 'collector', NULL, NULL),
(7, 'user', NULL, NULL);

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
(2, 4, 2, '2023-12-17 04:17:44', '2023-12-17 04:17:44'),
(6, 4, 6, '2023-12-30 06:17:59', '2023-12-30 06:17:59'),
(9, 4, 9, '2024-01-07 23:00:30', '2024-01-07 23:00:30'),
(10, 4, 10, '2024-01-07 23:07:38', '2024-01-07 23:07:38'),
(13, 5, 13, '2024-01-08 21:56:58', '2024-01-08 21:56:58'),
(14, 4, 14, '2024-01-09 01:37:22', '2024-01-09 01:37:22'),
(15, 5, 15, '2024-01-14 17:51:51', '2024-01-14 17:51:51'),
(16, 4, 16, '2024-01-29 18:59:54', '2024-01-29 18:59:54'),
(17, 5, 17, '2024-01-29 19:10:23', '2024-01-29 19:10:23'),
(18, 4, 18, '2024-01-29 19:11:11', '2024-01-29 19:11:11'),
(19, 6, 19, '2024-01-29 19:53:55', '2024-01-29 19:53:55'),
(20, 4, 20, '2024-03-02 13:37:09', '2024-03-02 13:37:09'),
(21, 6, 21, '2024-03-16 15:12:45', '2024-03-16 15:12:45'),
(22, 4, 22, '2024-05-22 05:09:57', '2024-05-22 05:09:57'),
(23, 7, 23, '2024-07-21 13:14:21', '2024-07-21 13:14:21'),
(24, 7, 24, '2024-07-21 13:14:22', '2024-07-21 13:14:22'),
(25, 7, 25, '2024-07-21 13:14:22', '2024-07-21 13:14:22'),
(26, 7, 26, '2024-07-21 13:14:22', '2024-07-21 13:14:22'),
(27, 7, 27, '2024-07-21 13:14:23', '2024-07-21 13:14:23'),
(28, 7, 28, '2024-07-21 13:14:23', '2024-07-21 13:14:23'),
(29, 7, 29, '2024-07-21 13:14:23', '2024-07-21 13:14:23'),
(30, 7, 30, '2024-07-21 13:14:23', '2024-07-21 13:14:23'),
(31, 7, 31, '2024-07-21 13:14:24', '2024-07-21 13:14:24'),
(32, 7, 32, '2024-07-21 13:14:24', '2024-07-21 13:14:24'),
(33, 7, 33, '2024-07-21 13:14:24', '2024-07-21 13:14:24'),
(34, 7, 34, '2024-07-21 13:14:25', '2024-07-21 13:14:25'),
(35, 7, 35, '2024-07-21 13:14:25', '2024-07-21 13:14:25'),
(36, 7, 36, '2024-07-21 13:14:25', '2024-07-21 13:14:25'),
(37, 7, 37, '2024-07-21 13:14:25', '2024-07-21 13:14:25'),
(38, 7, 38, '2024-07-21 13:14:26', '2024-07-21 13:14:26'),
(39, 7, 39, '2024-07-21 13:14:26', '2024-07-21 13:14:26'),
(40, 7, 40, '2024-07-21 13:14:26', '2024-07-21 13:14:26'),
(41, 7, 41, '2024-07-21 13:14:26', '2024-07-21 13:14:26'),
(42, 7, 42, '2024-07-21 13:14:27', '2024-07-21 13:14:27'),
(43, 7, 43, '2024-07-21 13:14:27', '2024-07-21 13:14:27'),
(44, 7, 44, '2024-07-21 13:14:27', '2024-07-21 13:14:27'),
(45, 7, 45, '2024-07-21 13:14:28', '2024-07-21 13:14:28'),
(46, 7, 46, '2024-07-21 13:14:28', '2024-07-21 13:14:28'),
(47, 7, 47, '2024-07-21 13:14:28', '2024-07-21 13:14:28'),
(48, 7, 48, '2024-07-21 13:14:28', '2024-07-21 13:14:28'),
(49, 7, 49, '2024-07-21 13:14:29', '2024-07-21 13:14:29'),
(50, 7, 50, '2024-07-21 13:14:29', '2024-07-21 13:14:29'),
(51, 7, 51, '2024-07-21 13:14:29', '2024-07-21 13:14:29'),
(52, 7, 52, '2024-07-21 13:14:30', '2024-07-21 13:14:30'),
(53, 7, 53, '2024-07-21 13:14:30', '2024-07-21 13:14:30'),
(54, 7, 54, '2024-07-21 13:14:30', '2024-07-21 13:14:30'),
(55, 7, 55, '2024-07-21 13:14:30', '2024-07-21 13:14:30'),
(56, 7, 56, '2024-07-21 13:14:31', '2024-07-21 13:14:31'),
(57, 7, 57, '2024-07-21 13:14:31', '2024-07-21 13:14:31'),
(58, 7, 58, '2024-07-21 13:14:31', '2024-07-21 13:14:31'),
(59, 7, 59, '2024-07-21 13:14:32', '2024-07-21 13:14:32'),
(60, 7, 60, '2024-07-21 13:14:32', '2024-07-21 13:14:32'),
(61, 7, 61, '2024-07-21 13:14:32', '2024-07-21 13:14:32'),
(62, 7, 62, '2024-07-21 13:14:32', '2024-07-21 13:14:32'),
(63, 7, 63, '2024-07-21 13:14:33', '2024-07-21 13:14:33'),
(64, 7, 64, '2024-07-21 13:14:33', '2024-07-21 13:14:33'),
(65, 7, 65, '2024-07-21 13:14:33', '2024-07-21 13:14:33'),
(66, 7, 66, '2024-07-21 13:14:34', '2024-07-21 13:14:34'),
(67, 7, 67, '2024-07-21 13:14:34', '2024-07-21 13:14:34'),
(68, 7, 68, '2024-07-21 13:14:34', '2024-07-21 13:14:34'),
(69, 7, 69, '2024-07-21 13:14:34', '2024-07-21 13:14:34'),
(70, 7, 70, '2024-07-21 13:14:35', '2024-07-21 13:14:35'),
(71, 7, 71, '2024-07-21 13:14:35', '2024-07-21 13:14:35'),
(72, 7, 72, '2024-07-21 13:14:35', '2024-07-21 13:14:35'),
(73, 7, 73, '2024-07-21 13:14:36', '2024-07-21 13:14:36'),
(74, 7, 74, '2024-07-21 13:14:36', '2024-07-21 13:14:36'),
(75, 7, 75, '2024-07-21 13:14:36', '2024-07-21 13:14:36'),
(76, 7, 76, '2024-07-21 13:14:36', '2024-07-21 13:14:36'),
(77, 7, 77, '2024-07-21 13:14:37', '2024-07-21 13:14:37'),
(78, 7, 78, '2024-07-21 13:14:37', '2024-07-21 13:14:37'),
(79, 7, 79, '2024-07-21 13:14:37', '2024-07-21 13:14:37'),
(80, 7, 80, '2024-07-21 13:14:38', '2024-07-21 13:14:38'),
(81, 7, 81, '2024-07-21 13:14:38', '2024-07-21 13:14:38'),
(82, 7, 82, '2024-07-21 13:14:39', '2024-07-21 13:14:39'),
(83, 7, 83, '2024-07-21 13:14:39', '2024-07-21 13:14:39'),
(84, 7, 84, '2024-07-21 13:14:40', '2024-07-21 13:14:40'),
(85, 7, 85, '2024-07-21 13:14:40', '2024-07-21 13:14:40'),
(86, 7, 86, '2024-07-21 13:14:40', '2024-07-21 13:14:40'),
(87, 7, 87, '2024-07-21 13:14:40', '2024-07-21 13:14:40'),
(88, 7, 88, '2024-07-21 13:14:41', '2024-07-21 13:14:41'),
(89, 7, 89, '2024-07-21 13:14:41', '2024-07-21 13:14:41'),
(90, 7, 90, '2024-07-21 13:14:41', '2024-07-21 13:14:41'),
(91, 7, 91, '2024-07-21 13:14:42', '2024-07-21 13:14:42'),
(92, 7, 92, '2024-07-21 13:14:42', '2024-07-21 13:14:42'),
(93, 7, 93, '2024-07-21 13:14:42', '2024-07-21 13:14:42'),
(94, 7, 94, '2024-07-21 13:14:42', '2024-07-21 13:14:42'),
(95, 7, 95, '2024-07-21 13:14:43', '2024-07-21 13:14:43'),
(96, 7, 96, '2024-07-21 13:14:43', '2024-07-21 13:14:43'),
(97, 7, 97, '2024-07-21 13:14:43', '2024-07-21 13:14:43'),
(98, 7, 98, '2024-07-21 13:14:43', '2024-07-21 13:14:43'),
(99, 7, 99, '2024-07-21 13:14:44', '2024-07-21 13:14:44'),
(100, 7, 100, '2024-07-21 13:14:44', '2024-07-21 13:14:44'),
(101, 7, 101, '2024-07-21 13:14:44', '2024-07-21 13:14:44'),
(102, 7, 102, '2024-07-21 13:14:45', '2024-07-21 13:14:45'),
(103, 7, 103, '2024-07-21 13:14:45', '2024-07-21 13:14:45'),
(104, 7, 104, '2024-07-21 13:14:45', '2024-07-21 13:14:45'),
(105, 7, 105, '2024-07-21 13:14:45', '2024-07-21 13:14:45'),
(106, 7, 106, '2024-07-21 13:14:46', '2024-07-21 13:14:46'),
(107, 7, 107, '2024-07-21 13:14:46', '2024-07-21 13:14:46'),
(108, 7, 108, '2024-07-21 13:14:46', '2024-07-21 13:14:46'),
(109, 7, 109, '2024-07-21 13:14:47', '2024-07-21 13:14:47'),
(110, 7, 110, '2024-07-21 13:14:47', '2024-07-21 13:14:47'),
(111, 7, 111, '2024-07-21 13:14:47', '2024-07-21 13:14:47'),
(112, 7, 112, '2024-07-21 13:14:47', '2024-07-21 13:14:47'),
(113, 7, 113, '2024-07-21 13:14:48', '2024-07-21 13:14:48'),
(114, 7, 114, '2024-07-21 13:14:48', '2024-07-21 13:14:48'),
(115, 7, 115, '2024-07-21 13:14:48', '2024-07-21 13:14:48'),
(116, 7, 116, '2024-07-21 13:14:49', '2024-07-21 13:14:49'),
(117, 7, 117, '2024-07-21 13:14:49', '2024-07-21 13:14:49'),
(118, 7, 118, '2024-07-21 13:14:49', '2024-07-21 13:14:49'),
(119, 7, 119, '2024-07-21 13:14:49', '2024-07-21 13:14:49'),
(120, 7, 120, '2024-07-21 13:14:50', '2024-07-21 13:14:50'),
(121, 7, 121, '2024-07-21 13:14:50', '2024-07-21 13:14:50'),
(122, 7, 122, '2024-07-21 13:14:50', '2024-07-21 13:14:50'),
(123, 7, 123, '2024-07-26 20:41:24', '2024-07-26 20:41:24'),
(124, 7, 23, '2024-07-27 08:09:11', '2024-07-27 08:09:11'),
(125, 7, 24, '2024-07-27 08:09:11', '2024-07-27 08:09:11'),
(126, 7, 25, '2024-07-27 08:09:11', '2024-07-27 08:09:11'),
(127, 7, 26, '2024-07-27 08:09:12', '2024-07-27 08:09:12'),
(128, 7, 27, '2024-07-27 08:09:12', '2024-07-27 08:09:12'),
(129, 7, 28, '2024-07-27 08:09:12', '2024-07-27 08:09:12'),
(130, 7, 29, '2024-07-27 08:09:12', '2024-07-27 08:09:12'),
(131, 7, 30, '2024-07-27 08:09:13', '2024-07-27 08:09:13'),
(132, 7, 31, '2024-07-27 08:09:13', '2024-07-27 08:09:13'),
(133, 7, 32, '2024-07-27 08:09:13', '2024-07-27 08:09:13'),
(134, 7, 33, '2024-07-27 08:09:14', '2024-07-27 08:09:14'),
(135, 7, 34, '2024-07-27 08:09:14', '2024-07-27 08:09:14'),
(136, 7, 35, '2024-07-27 08:09:14', '2024-07-27 08:09:14'),
(137, 7, 36, '2024-07-27 08:09:14', '2024-07-27 08:09:14'),
(138, 7, 37, '2024-07-27 08:09:15', '2024-07-27 08:09:15'),
(139, 7, 38, '2024-07-27 08:09:15', '2024-07-27 08:09:15'),
(140, 7, 39, '2024-07-27 08:09:15', '2024-07-27 08:09:15'),
(141, 7, 40, '2024-07-27 08:09:16', '2024-07-27 08:09:16'),
(142, 7, 41, '2024-07-27 08:09:16', '2024-07-27 08:09:16'),
(143, 7, 42, '2024-07-27 08:09:16', '2024-07-27 08:09:16'),
(144, 7, 43, '2024-07-27 08:09:16', '2024-07-27 08:09:16'),
(145, 7, 44, '2024-07-27 08:09:17', '2024-07-27 08:09:17'),
(146, 7, 45, '2024-07-27 08:09:17', '2024-07-27 08:09:17'),
(147, 7, 46, '2024-07-27 08:09:17', '2024-07-27 08:09:17'),
(148, 7, 47, '2024-07-27 08:09:17', '2024-07-27 08:09:17'),
(149, 7, 48, '2024-07-27 08:09:18', '2024-07-27 08:09:18'),
(150, 7, 49, '2024-07-27 08:09:18', '2024-07-27 08:09:18'),
(151, 7, 50, '2024-07-27 08:09:18', '2024-07-27 08:09:18'),
(152, 7, 51, '2024-07-27 08:09:19', '2024-07-27 08:09:19'),
(153, 7, 52, '2024-07-27 08:09:19', '2024-07-27 08:09:19'),
(154, 7, 53, '2024-07-27 08:09:19', '2024-07-27 08:09:19'),
(155, 7, 54, '2024-07-27 08:09:19', '2024-07-27 08:09:19'),
(156, 7, 55, '2024-07-27 08:09:20', '2024-07-27 08:09:20'),
(157, 7, 56, '2024-07-27 08:09:20', '2024-07-27 08:09:20'),
(158, 7, 57, '2024-07-27 08:09:20', '2024-07-27 08:09:20'),
(159, 7, 58, '2024-07-27 08:09:21', '2024-07-27 08:09:21'),
(160, 7, 59, '2024-07-27 08:09:21', '2024-07-27 08:09:21'),
(161, 7, 60, '2024-07-27 08:09:21', '2024-07-27 08:09:21'),
(162, 7, 61, '2024-07-27 08:09:21', '2024-07-27 08:09:21'),
(163, 7, 62, '2024-07-27 08:09:22', '2024-07-27 08:09:22'),
(164, 7, 63, '2024-07-27 08:09:22', '2024-07-27 08:09:22'),
(165, 7, 64, '2024-07-27 08:09:22', '2024-07-27 08:09:22'),
(166, 7, 65, '2024-07-27 08:09:22', '2024-07-27 08:09:22'),
(167, 7, 66, '2024-07-27 08:09:23', '2024-07-27 08:09:23'),
(168, 7, 67, '2024-07-27 08:09:23', '2024-07-27 08:09:23'),
(169, 7, 68, '2024-07-27 08:09:23', '2024-07-27 08:09:23'),
(170, 7, 69, '2024-07-27 08:09:24', '2024-07-27 08:09:24'),
(171, 7, 70, '2024-07-27 08:09:24', '2024-07-27 08:09:24'),
(172, 7, 71, '2024-07-27 08:09:24', '2024-07-27 08:09:24'),
(173, 7, 72, '2024-07-27 08:09:24', '2024-07-27 08:09:24'),
(174, 7, 73, '2024-07-27 08:09:25', '2024-07-27 08:09:25'),
(175, 7, 74, '2024-07-27 08:09:25', '2024-07-27 08:09:25'),
(176, 7, 75, '2024-07-27 08:09:25', '2024-07-27 08:09:25'),
(177, 7, 76, '2024-07-27 08:09:26', '2024-07-27 08:09:26'),
(178, 7, 77, '2024-07-27 08:09:26', '2024-07-27 08:09:26'),
(179, 7, 78, '2024-07-27 08:09:26', '2024-07-27 08:09:26'),
(180, 7, 79, '2024-07-27 08:09:26', '2024-07-27 08:09:26'),
(181, 7, 80, '2024-07-27 08:09:27', '2024-07-27 08:09:27'),
(182, 7, 81, '2024-07-27 08:09:27', '2024-07-27 08:09:27'),
(183, 7, 82, '2024-07-27 08:09:27', '2024-07-27 08:09:27'),
(184, 7, 83, '2024-07-27 08:09:28', '2024-07-27 08:09:28'),
(185, 7, 84, '2024-07-27 08:09:28', '2024-07-27 08:09:28'),
(186, 7, 85, '2024-07-27 08:09:28', '2024-07-27 08:09:28'),
(187, 7, 86, '2024-07-27 08:09:28', '2024-07-27 08:09:28'),
(188, 7, 87, '2024-07-27 08:09:29', '2024-07-27 08:09:29'),
(189, 7, 88, '2024-07-27 08:09:29', '2024-07-27 08:09:29'),
(190, 7, 89, '2024-07-27 08:09:29', '2024-07-27 08:09:29'),
(191, 7, 90, '2024-07-27 08:09:30', '2024-07-27 08:09:30'),
(192, 7, 91, '2024-07-27 08:09:30', '2024-07-27 08:09:30'),
(193, 7, 92, '2024-07-27 08:09:30', '2024-07-27 08:09:30'),
(194, 7, 93, '2024-07-27 08:09:30', '2024-07-27 08:09:30'),
(195, 7, 94, '2024-07-27 08:09:31', '2024-07-27 08:09:31'),
(196, 7, 95, '2024-07-27 08:09:31', '2024-07-27 08:09:31'),
(197, 7, 96, '2024-07-27 08:09:31', '2024-07-27 08:09:31'),
(198, 7, 97, '2024-07-27 08:09:32', '2024-07-27 08:09:32'),
(199, 7, 98, '2024-07-27 08:09:32', '2024-07-27 08:09:32'),
(200, 7, 99, '2024-07-27 08:09:32', '2024-07-27 08:09:32'),
(201, 7, 100, '2024-07-27 08:09:32', '2024-07-27 08:09:32'),
(202, 7, 101, '2024-07-27 08:09:33', '2024-07-27 08:09:33'),
(203, 7, 102, '2024-07-27 08:09:33', '2024-07-27 08:09:33'),
(204, 7, 103, '2024-07-27 08:09:33', '2024-07-27 08:09:33'),
(205, 7, 104, '2024-07-27 08:09:33', '2024-07-27 08:09:33'),
(206, 7, 105, '2024-07-27 08:09:34', '2024-07-27 08:09:34'),
(207, 7, 106, '2024-07-27 08:09:34', '2024-07-27 08:09:34'),
(208, 7, 107, '2024-07-27 08:09:34', '2024-07-27 08:09:34'),
(209, 7, 108, '2024-07-27 08:09:35', '2024-07-27 08:09:35'),
(210, 7, 109, '2024-07-27 08:09:35', '2024-07-27 08:09:35'),
(211, 7, 110, '2024-07-27 08:09:35', '2024-07-27 08:09:35'),
(212, 7, 111, '2024-07-27 08:09:35', '2024-07-27 08:09:35'),
(213, 7, 112, '2024-07-27 08:09:36', '2024-07-27 08:09:36'),
(214, 7, 113, '2024-07-27 08:09:36', '2024-07-27 08:09:36'),
(215, 7, 114, '2024-07-27 08:09:36', '2024-07-27 08:09:36'),
(216, 7, 115, '2024-07-27 08:09:37', '2024-07-27 08:09:37'),
(217, 7, 116, '2024-07-27 08:09:37', '2024-07-27 08:09:37'),
(218, 7, 117, '2024-07-27 08:09:37', '2024-07-27 08:09:37'),
(219, 7, 118, '2024-07-27 08:09:37', '2024-07-27 08:09:37'),
(220, 7, 119, '2024-07-27 08:09:38', '2024-07-27 08:09:38'),
(221, 7, 120, '2024-07-27 08:09:38', '2024-07-27 08:09:38'),
(222, 7, 121, '2024-07-27 08:09:38', '2024-07-27 08:09:38'),
(223, 7, 122, '2024-07-27 08:09:39', '2024-07-27 08:09:39'),
(224, 7, 123, '2024-07-28 07:13:17', '2024-07-28 07:13:17');

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

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `wallet_user_id` bigint(20) UNSIGNED NOT NULL,
  `previous_amount` decimal(10,2) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `after_amount` decimal(10,2) NOT NULL,
  `direction` enum('Credit','Debit') NOT NULL,
  `transaction_date` datetime NOT NULL,
  `notes` text DEFAULT NULL,
  `transaction_type` text NOT NULL,
  `uuid` varchar(50) NOT NULL,
  `transaction_by` bigint(20) UNSIGNED NOT NULL,
  `transaction_by_type` enum('Admin','Self') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` enum('pending','done','rejcted') NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `user_id`, `wallet_user_id`, `previous_amount`, `amount`, `after_amount`, `direction`, `transaction_date`, `notes`, `transaction_type`, `uuid`, `transaction_by`, `transaction_by_type`, `created_at`, `updated_at`, `status`) VALUES
(1, 19, 12, 0.00, 5200.00, 5200.00, 'Credit', '2024-02-16 19:11:09', NULL, 'Added Balance to the Wallet.', '6526ad71-a2e3-44c6-a2d5-0347f5bc5cb1', 1, 'Admin', '2024-03-09 13:41:09', '2024-03-09 13:41:09', 'done'),
(2, 19, 12, 5200.00, 340.00, 5540.00, 'Credit', '2024-03-11 19:11:33', NULL, 'Added Balance to the Wallet.', 'da09e49a-7c54-4567-92bb-ca5ff6ad30c5', 1, 'Admin', '2024-03-11 13:41:33', '2024-03-11 13:41:33', 'done'),
(3, 19, 12, 5540.00, 560.00, 6100.00, 'Credit', '2024-03-11 20:30:19', NULL, 'Added Balance to the Wallet.', '0704a3a3-ede4-41a0-9756-df8ff6d407c9', 1, 'Admin', '2024-03-11 15:00:19', '2024-03-11 15:00:19', 'done'),
(4, 19, 12, 6100.00, 100.00, 6000.00, 'Debit', '2024-03-11 20:30:44', NULL, 'Spend on Test', 'c322a656-60c6-4c0f-ba0f-dbd09fb7ad56', 19, 'Self', '2024-03-11 15:00:44', '2024-03-11 15:00:44', 'done'),
(5, 19, 12, 6200.00, 5600.00, 11800.00, 'Credit', '2024-03-15 18:14:54', NULL, 'Added Balance to the Wallet.', 'f5cfe7c8-58c0-496a-8417-b9100c7d391e', 1, 'Admin', '2024-03-15 12:44:54', '2024-03-15 12:44:54', 'done'),
(6, 19, 12, 11800.00, 120.00, 11920.00, 'Credit', '2024-03-15 18:22:56', NULL, 'Added Balance to the Wallet.', 'a7e61c0a-5cc5-416c-8c81-952f852a350b', 1, 'Admin', '2024-03-15 12:52:56', '2024-03-15 12:52:56', 'done'),
(7, 19, 12, 11920.00, 240.00, 12160.00, 'Credit', '2024-03-15 18:23:04', NULL, 'Added Balance to the Wallet.', '1847b279-f03c-480d-8a04-487e974bc2af', 1, 'Admin', '2024-03-15 12:53:04', '2024-03-15 12:53:04', 'done'),
(8, 19, 12, 12160.00, 360.00, 12520.00, 'Credit', '2024-03-15 18:23:12', NULL, 'Added Balance to the Wallet.', '480d9697-0986-4d32-ad40-322286308da7', 1, 'Admin', '2024-03-15 12:53:12', '2024-03-15 12:53:12', 'done'),
(9, 19, 12, 12520.00, 520.00, 13040.00, 'Credit', '2024-03-15 18:23:31', NULL, 'Added Balance to the Wallet.', 'a038ba3d-e98c-4690-8012-f529485a606d', 1, 'Admin', '2024-03-15 12:53:31', '2024-03-15 12:53:31', 'done'),
(10, 19, 12, 13040.00, 750.00, 13790.00, 'Credit', '2024-03-15 18:23:51', NULL, 'Added Balance to the Wallet.', 'b8c93e34-4b6b-4f4c-87ad-8f36ef2c0a67', 1, 'Admin', '2024-03-15 12:53:51', '2024-03-15 12:53:51', 'done'),
(11, 19, 12, 13790.00, 1210.00, 15000.00, 'Credit', '2024-03-15 18:24:16', NULL, 'Added Balance to the Wallet.', 'babfb616-6283-4a2e-8a9a-9784c6c9bceb', 1, 'Admin', '2024-03-15 12:54:16', '2024-03-15 12:54:16', 'done'),
(12, 19, 12, 15000.00, 5000.00, 20000.00, 'Credit', '2024-03-16 15:02:27', NULL, 'Added Balance to the Wallet.', '3f683697-bfc8-49b2-9c46-47a0078b4444', 1, 'Admin', '2024-03-16 09:32:27', '2024-03-16 09:32:27', 'done'),
(13, 19, 12, 20000.00, 2360.00, 22360.00, 'Credit', '2024-03-18 20:39:15', NULL, 'Added Balance to the Wallet.', '66a03b34-a43e-4b51-a72d-c99f03d2bf52', 1, 'Admin', '2024-03-16 15:09:15', '2024-03-16 15:09:15', 'done'),
(14, 21, 14, 0.00, 500.00, 500.00, 'Credit', '2024-03-16 20:43:06', NULL, 'Added Balance to the Wallet.', 'f26f766c-2473-4764-985b-9b6c60ef14d2', 1, 'Admin', '2024-03-16 15:13:06', '2024-03-16 15:13:06', 'done'),
(15, 19, 12, 22360.00, 40.00, 22400.00, 'Credit', '2024-03-21 01:21:38', NULL, 'Added Balance to the Wallet.', 'c7f7a66e-17e8-4c6e-a2ce-ee6647c6d970', 1, 'Admin', '2024-03-20 19:51:38', '2024-03-20 19:51:38', 'done'),
(16, 21, 14, 500.00, 2300.00, 2800.00, 'Credit', '2024-03-21 01:22:33', NULL, 'Added Balance to the Wallet.', '2c916f20-9600-4922-9b0d-bdf6c06a7feb', 1, 'Admin', '2024-03-20 19:52:33', '2024-03-20 19:52:33', 'done'),
(17, 21, 14, 2800.00, 560.00, 2240.00, 'Debit', '2024-03-21 01:22:44', NULL, 'Spend on Test', 'd7f67dc1-67c0-42cf-b2d3-c852092f4595', 1, 'Admin', '2024-03-20 19:52:44', '2024-03-20 19:52:44', 'done'),
(18, 21, 14, 2240.00, 100.00, 2140.00, 'Debit', '2024-03-21 01:26:51', NULL, 'Spend on Test', '25d976ce-dd41-4de8-8c8f-9e7935df288c', 1, 'Admin', '2024-03-20 19:56:51', '2024-03-20 19:56:51', 'done'),
(19, 19, 12, 22400.00, 1500.00, 22400.00, 'Credit', '2024-05-19 23:30:17', NULL, 'Added Balance to the Wallet.', 'ac6b6ab6-ae25-4aa5-9c37-2a6367682f21', 19, 'Admin', '2024-05-19 18:00:17', '2024-05-19 18:00:17', 'pending'),
(20, 19, 12, 22400.00, 1500.00, 22400.00, 'Credit', '2024-05-19 23:34:11', NULL, 'Added Balance to the Wallet.', '6ba604dd-af8c-4a9f-90e6-6b834e8394e4', 19, 'Self', '2024-05-19 18:04:11', '2024-05-19 18:04:11', 'pending');

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
(1, 'Pranab Karmakar', 'admin@gmail.com', NULL, '$2y$12$.cwOro4cMUOhJKL5M2zlguK3LuAFJ4fkPZ09N6BlHbNv2w1PCcmju', NULL, NULL, NULL, '44q70O3nfR2IDKivPUInqNIJASvQeG4Tiwxv2q8EBCPOX6uxGidRiJrzVwhc', '2023-12-15 04:17:44', '2024-08-30 18:53:55', 'user', NULL, 141, '2024-08-30 18:54:02', 'https://ui-avatars.com/api/?name=Pranab+Karmakar&background=f8ff2f&color=000000&size=150', 1),
(2, 'SRL Diagonastics Halisahar', 'srl_naihati@gmail.com', NULL, '$2y$10$73KA8j4cnbKqNHxKcdRwT.wqbNWRbbGycxcB.Xsjo7QFciXKwSmPm', NULL, NULL, NULL, NULL, '2023-12-17 04:17:44', '2024-07-08 18:25:58', 'user', NULL, 17, '2024-07-08 18:25:58', 'https://ui-avatars.com/api/?name=SRL+Diagonastics&background=fd474d&color=ffffff&size=150', 1),
(6, 'Netralok Lab', 'netralok-naihati@gmail.com', NULL, '$2y$10$buBciPkuWx0P6VqVKE/QoeXQLjyxmvNS2oxzpBdaFCFhlO8YsKQPq', NULL, NULL, NULL, NULL, '2023-12-30 06:17:59', '2024-04-27 10:42:21', 'user', NULL, 22, '2024-04-27 10:42:21', 'https://ui-avatars.com/api/?name=Netralok+Lab&background=8572b8&color=000000&size=150', 1),
(9, 'Agelus Lab Shyamnagar', 'agelus.shyamnagar@gmail.com', NULL, '$2y$10$xlA8BLlfHoa8CHNsmYGTaO.77zFjl0kmK4YFfTRsR3p.bpiSF5fmu', NULL, NULL, NULL, NULL, '2024-01-07 23:00:30', '2024-01-08 22:32:44', 'user', NULL, 0, '2024-01-09 04:02:44', 'https://ui-avatars.com/api/?name=Agelus+Lab+Shyamnagar&background=f94620&color=ffffff&size=150', 1),
(10, 'Dr Lal Path Lab', 'drlal.halisahar@gmail.com', NULL, '$2y$10$sTYFezrvA0jvBLPMMWbF6O0hQ1ZxJ9mKGNUUkIR.t6Z58B.YeMq/i', NULL, NULL, NULL, NULL, '2024-01-07 23:07:38', '2024-01-07 23:22:39', 'user', NULL, 0, '2024-01-08 04:52:39', 'https://ui-avatars.com/api/?name=Dr+Lal+Path+Lab&background=ef1ad5&color=ffffff&size=150', 1),
(13, 'Rajib Biswas', 'rbiswas@gmail.com', NULL, '$2y$10$jf8pdZO2/K3kpwW8c16Wou5K8xEgWqew4vLC0fiKxAoo8J4vcwDp.', NULL, NULL, NULL, NULL, '2024-01-08 21:56:58', '2024-01-09 01:48:07', 'user', NULL, 0, '2024-01-09 07:18:07', 'https://ui-avatars.com/api/?name=Rajib+Biswas&background=2a8ee3&color=ffffff&size=150', 1),
(14, 'Balaji Diagnostic', 'balaji.halisahar@gmail.com', NULL, '$2y$10$GECKE/Uc7CdLX4NZ4Ev5Le9Dh1zFAWqQ9Faem3WQHSwRTKDZ4eYNu', NULL, NULL, NULL, NULL, '2024-01-09 01:37:22', '2024-01-14 23:53:38', 'user', NULL, 0, '2024-01-14 16:53:38', 'https://ui-avatars.com/api/?name=Balaji+Diagnostic&background=45a11a&color=ffffff&size=150', 0),
(15, 'H. S. Pathak', 'pathak@gmail.com', NULL, '$2y$10$U8lHvSKzm/I4lZrVFMpWguxiAgmPU5nlfgkJjIViMSQPuxEISOA3u', NULL, NULL, NULL, NULL, '2024-01-14 17:51:51', '2024-01-14 17:51:51', 'user', NULL, 0, '2024-01-14 10:51:51', 'https://ui-avatars.com/api/?name=H.+S.+Pathak&background=af26e1&color=ffffff&size=150', 1),
(16, 'Lab Apolo New', 'apolo@gmail.com', NULL, '$2y$10$mctrtDCQCpCMk/H.eTfi/esB5onbo2wwg5u5RwIf3MkqP4YboafGy', NULL, NULL, NULL, NULL, '2024-01-29 18:59:54', '2024-07-14 11:22:28', 'user', NULL, 0, '2024-07-14 11:22:28', 'https://ui-avatars.com/api/?name=Lab+Apolo&background=ad9b5d&color=000000&size=150', 0),
(17, 'D.K. Gupta', 'dkg@gmail', NULL, '$2y$10$oXnXZKrl7jvlH6omRBdUtOYvTN26dOpN9NMkqYUkaiSKeEy0N8VbS', NULL, NULL, NULL, NULL, '2024-01-29 19:10:23', '2024-01-29 19:51:38', 'user', NULL, 0, '2024-01-29 12:51:38', 'https://ui-avatars.com/api/?name=D.K.+Gupta&background=eaa0da&color=000000&size=150', 0),
(18, 'asds', 'ab@gmail', NULL, '$2y$10$vlGAKk2StcsSeMt4jZ8vLOIEfrf.O0zbDZzZU5SownXSJ5ySLtWTK', NULL, NULL, NULL, NULL, '2024-01-29 19:11:11', '2024-01-29 19:11:11', 'user', NULL, 0, '2024-01-29 12:11:11', 'https://ui-avatars.com/api/?name=asds&background=a359d2&color=ffffff&size=150', 1),
(19, 'Ratan Konar', 'c@gm', NULL, '$2y$10$UTtZeFfQHYAGD5hhfzCP2ufpNlfjDB/m53whd7pfjDTM0gau4t6Eu', NULL, NULL, NULL, NULL, '2024-01-29 19:53:55', '2024-05-25 10:25:32', 'user', NULL, 40, '2024-05-25 10:25:32', 'https://ui-avatars.com/api/?name=Ratan+Konar&background=7317ce&color=ffffff&size=150', 1),
(20, 'Agelus', 'agelus.halisahar@gmail.com', NULL, '$2y$12$en2npfObxsFLEQ.5o4Xzku0gfshXO4P8AATSNxRh3TS5lmH72w8o2', NULL, NULL, NULL, NULL, '2024-03-02 13:37:09', '2024-07-14 14:29:31', 'user', NULL, 0, '2024-07-14 14:29:31', 'https://ui-avatars.com/api/?name=Agelus&background=12e212&color=000000&size=150', 1),
(21, 'Swapan Kumar', 'skumar@gmail.com', NULL, '$2y$12$HBA9oxXND1hjBidDq5kYxOLCmSQARpOXhNvAoZlTzN/ltx4T0pUuC', NULL, NULL, NULL, NULL, '2024-03-16 15:12:45', '2024-04-27 10:40:03', 'user', NULL, 10, '2024-04-27 10:40:03', 'https://ui-avatars.com/api/?name=Swapan+Kumar&background=f608ca&color=ffffff&size=150', 1),
(22, 'New Lab', 'newlab@gmail.com', NULL, '$2y$12$1iYQKXs05Ey6jSmnU5ClQOnBrLi.COhYtv.0Ns9OE6IGns7/ScZ9C', NULL, NULL, NULL, NULL, '2024-05-22 05:09:57', '2024-07-14 11:22:15', 'user', NULL, 1, '2024-07-14 11:22:15', 'https://ui-avatars.com/api/?name=New+Lab&background=556988&color=ffffff&size=150', 1),
(23, 'Amit Barui', 'amit.b@gmail.com', NULL, '$2y$12$AkXjw61lLcllrqM5ule/l.CpwEFLa3lX8m37nNqWfHrUM0togiFKS', NULL, NULL, NULL, NULL, '2024-07-27 08:09:11', '2024-07-27 15:04:17', 'user', '9873252563', 0, '2024-07-27 15:04:17', 'http://localhost/images/default.png', 1),
(24, 'Madhu Sama', 'pandit.tejaswani@example.com', NULL, '$2y$12$Pfv5K/eeNgZDmmAXVQY0e./lH0SyqWWDVHDmN5bXhslFroXjjr5Jq', NULL, NULL, NULL, NULL, '2024-07-27 08:09:11', '2024-07-27 08:09:11', 'user', '+91 78138 48979', 0, '2024-07-27 08:09:11', 'http://localhost/images/default.png', 1),
(25, 'Sushant Gour', 'kapadia.mohit@example.com', NULL, '$2y$12$PvkYPcARwuMFXleanyPwe.5QpX6Ysy46u3RjxvS90wR3kgcpLYYdK', NULL, NULL, NULL, NULL, '2024-07-27 08:09:11', '2024-07-27 08:09:11', 'user', '+91 94386 72548', 0, '2024-07-27 08:09:11', 'http://localhost/images/default.png', 1),
(26, 'Nishi Aurora', 'elias51@example.com', NULL, '$2y$12$PLZ8EfRJ1s1XMit30.Pf2u0q71sH2P9YlCm8oFGRZL.xgJQ/9wzFS', NULL, NULL, NULL, NULL, '2024-07-27 08:09:12', '2024-07-27 08:09:12', 'user', '+91 76756 43450', 0, '2024-07-27 08:09:12', 'http://localhost/images/default.png', 1),
(27, 'Charu Apte', 'asen@example.org', NULL, '$2y$12$TwgKN4FVNYCNUYV.mrV2dOTmY5BDMCcXCcUF8seiCq13kwYQKIxBi', NULL, NULL, NULL, NULL, '2024-07-27 08:09:12', '2024-07-27 08:09:12', 'user', '+91 74940 52115', 0, '2024-07-27 08:09:12', 'http://localhost/images/default.png', 1),
(28, 'Sirish Sen', 'ishroff@example.com', NULL, '$2y$12$0QgPyBl2PBP3x5H6PQKZie6lks/JEzcmLXtcQ9n1pQD8mRRt6qAKG', NULL, NULL, NULL, NULL, '2024-07-27 08:09:12', '2024-07-27 08:09:12', 'user', '+91 98055 85803', 0, '2024-07-27 08:09:12', 'http://localhost/images/default.png', 1),
(29, 'Jiya Bali', 'peri.manish@example.net', NULL, '$2y$12$5ogT58ahX5V6uUGDGN2el.aZqlfYVhQgHma3GGsuJbnvNltd6Smvy', NULL, NULL, NULL, NULL, '2024-07-27 08:09:12', '2024-07-27 08:09:12', 'user', '+91 98423 01410', 0, '2024-07-27 08:09:12', 'http://localhost/images/default.png', 1),
(30, 'Radhe Subramaniam', 'eramesh@example.org', NULL, '$2y$12$2sfJSSislwAUOYSpbuPlsOdLiThTRYM4V3Dlob49z/WxVbQQd8zzm', NULL, NULL, NULL, NULL, '2024-07-27 08:09:13', '2024-07-27 08:09:13', 'user', '+91 95936 54397', 0, '2024-07-27 08:09:13', 'http://localhost/images/default.png', 1),
(31, 'Dhiraj Tiwari', 'dinesh85@example.com', NULL, '$2y$12$G5RkPWURZs/J/FXe8Wnm9uqPyzKCjOIeaMG7yYDjulgZJqeZWKikS', NULL, NULL, NULL, NULL, '2024-07-27 08:09:13', '2024-07-27 08:09:13', 'user', '+91 72127 10065', 0, '2024-07-27 08:09:13', 'http://localhost/images/default.png', 1),
(32, 'Sumit Badal', 'ajinkya02@example.net', NULL, '$2y$12$8rKyKdxfi.YVOJLBY2WvKeJbKqDWcxFt8cIyJiyLCcczVe40qUNMy', NULL, NULL, NULL, NULL, '2024-07-27 08:09:13', '2024-07-27 08:09:13', 'user', '+91 95257 94305', 0, '2024-07-27 08:09:13', 'http://localhost/images/default.png', 1),
(33, 'Sheetal Devan', 'krishnan.ramesh@example.com', NULL, '$2y$12$ugnNOM46aLuRk3cJo65ZJ.9orj0A9gF.aB0LVVTIue8Bhff/LzW36', NULL, NULL, NULL, NULL, '2024-07-27 08:09:14', '2024-07-27 08:09:14', 'user', '+91 70412 33412', 0, '2024-07-27 08:09:14', 'http://localhost/images/default.png', 1),
(34, 'Jack Divan', 'chana.giaan@example.net', NULL, '$2y$12$aDPg2o6NbegqJtSxMhDBredlxZazE4shSd7awaw1KrXuLEFPbSpL2', NULL, NULL, NULL, NULL, '2024-07-27 08:09:14', '2024-07-27 08:09:14', 'user', '+91 75811 58833', 0, '2024-07-27 08:09:14', 'http://localhost/images/default.png', 1),
(35, 'Amrita Bhagat', 'payal13@example.org', NULL, '$2y$12$YyEUJ7Esx2xS3T/wtZW5E.LSoJpTagU7M7tdwq7lPsY8ZvglMK81a', NULL, NULL, NULL, NULL, '2024-07-27 08:09:14', '2024-07-27 08:09:14', 'user', '+91 81731 25964', 0, '2024-07-27 08:09:14', 'http://localhost/images/default.png', 1),
(36, 'Balaji Amin', 'isha.sane@example.net', NULL, '$2y$12$c3FpsDLFeLm3e6WW42iR2uCTd0vFPfJ64WcPYMtg9YYpuzW5yd2xW', NULL, NULL, NULL, NULL, '2024-07-27 08:09:14', '2024-07-27 08:09:14', 'user', '+91 72549 63846', 0, '2024-07-27 08:09:14', 'http://localhost/images/default.png', 1),
(37, 'Lalit Biswas', 'nutan72@example.com', NULL, '$2y$12$NgtPNrizoqXmHbDfwXbAw.4larsig3N9KkkWi3nQSJvtbSitxofVi', NULL, NULL, NULL, NULL, '2024-07-27 08:09:15', '2024-07-27 08:09:15', 'user', '+91 98609 33451', 0, '2024-07-27 08:09:15', 'http://localhost/images/default.png', 1),
(38, 'Kalpana Narula', 'kailash81@example.org', NULL, '$2y$12$6SR/eqrqn4C4OkgDRVh41.6e/kwl1WTvG/M8pb.Ab/mrb75a76yHW', NULL, NULL, NULL, NULL, '2024-07-27 08:09:15', '2024-07-27 08:09:15', 'user', '+91 85577 26255', 0, '2024-07-27 08:09:15', 'http://localhost/images/default.png', 1),
(39, 'Kasturba Chana', 'ambika.maharaj@example.net', NULL, '$2y$12$KDsWpgobWxd2T8m0F1GbpeC/kQjVv52BBa4/9BTFOUD13PTnlMIRi', NULL, NULL, NULL, NULL, '2024-07-27 08:09:15', '2024-07-27 08:09:15', 'user', '+91 80135 34298', 0, '2024-07-27 08:09:15', 'http://localhost/images/default.png', 1),
(40, 'Kim Saha', 'kchadha@example.net', NULL, '$2y$12$20WeB6yYCtJ2WGiQdRvVjuvIhT/GAJQrkZv19QtIoITytI4YzOjYK', NULL, NULL, NULL, NULL, '2024-07-27 08:09:16', '2024-07-27 08:09:16', 'user', '+91 90081 21853', 0, '2024-07-27 08:09:16', 'http://localhost/images/default.png', 1),
(41, 'Anshula Sethi', 'navami.chakraborty@example.net', NULL, '$2y$12$UmFM1k.HUGtfrYCB0ePkCuuOlmsbYGRWjK4ao3py5MQ23UmE.Urfy', NULL, NULL, NULL, NULL, '2024-07-27 08:09:16', '2024-07-27 08:09:16', 'user', '+91 87944 20141', 0, '2024-07-27 08:09:16', 'http://localhost/images/default.png', 1),
(42, 'Kalpana Gupta', 'ajay.chawla@example.com', NULL, '$2y$12$4OA4iohwcl4GO6JH/0zRveaZbaMZ6RwgdWi6D2vLUfGQqR3.UcvEO', NULL, NULL, NULL, NULL, '2024-07-27 08:09:16', '2024-07-27 08:09:16', 'user', '+91 84737 80231', 0, '2024-07-27 08:09:16', 'http://localhost/images/default.png', 1),
(43, 'Harpreet Ramnarine', 'xswaminathan@example.com', NULL, '$2y$12$IlT3SANZAlSz/ULuggRTk.T4qrIM8zOCbOkXa5DtOzDhX7CAslOlq', NULL, NULL, NULL, NULL, '2024-07-27 08:09:16', '2024-07-27 08:09:16', 'user', '+91 73186 67100', 0, '2024-07-27 08:09:16', 'http://localhost/images/default.png', 1),
(44, 'Ram Gopal Chauhan', 'xmore@example.com', NULL, '$2y$12$Zvk08in2aMXc6M6HfZ2H8O5s8V/J5//A9kLI8EHv46yxeBf6NVbVa', NULL, NULL, NULL, NULL, '2024-07-27 08:09:17', '2024-07-27 08:09:17', 'user', '+91 90776 35795', 0, '2024-07-27 08:09:17', 'http://localhost/images/default.png', 1),
(45, 'Babita Deol', 'qrana@example.org', NULL, '$2y$12$/eyqeM9GpWgmZ4c3Ox.eW.oNTTttYVi6gWZ3r1vBpR3i4zNip1Haa', NULL, NULL, NULL, NULL, '2024-07-27 08:09:17', '2024-07-27 08:09:17', 'user', '+91 82558 31636', 0, '2024-07-27 08:09:17', 'http://localhost/images/default.png', 1),
(46, 'Aslam Chakraborty', 'pparmer@example.com', NULL, '$2y$12$QEcZ.HBKG12cB9PAwCOChe29GQqVtBgrWi0WuSnDPsrbatpJSx0em', NULL, NULL, NULL, NULL, '2024-07-27 08:09:17', '2024-07-27 08:09:17', 'user', '+91 86163 47669', 0, '2024-07-27 08:09:17', 'http://localhost/images/default.png', 1),
(47, 'Urvashi Bhatti', 'kalyani56@example.net', NULL, '$2y$12$fpO5pLg9dbln.coKzIEcBuUDmTPTrPurs5StTZkW8q6BMKlh3Orpi', NULL, NULL, NULL, NULL, '2024-07-27 08:09:17', '2024-07-27 08:09:17', 'user', '+91 74681 50593', 0, '2024-07-27 08:09:17', 'http://localhost/images/default.png', 1),
(48, 'Arun Varma', 'supriya01@example.net', NULL, '$2y$12$EdD/.pMr7DZdArTWrwsEm.PP2kKceLpbC718hsfkTeTM2XV2Xj.xW', NULL, NULL, NULL, NULL, '2024-07-27 08:09:18', '2024-07-27 08:09:18', 'user', '+91 79197 07311', 0, '2024-07-27 08:09:18', 'http://localhost/images/default.png', 1),
(49, 'Kalpit Subramaniam', 'sumit82@example.org', NULL, '$2y$12$CNSjtc7P0MO6kwnCGVZy5u7X9hEDfA24saSYAjlPL7WFFxATJyI7a', NULL, NULL, NULL, NULL, '2024-07-27 08:09:18', '2024-07-27 08:09:18', 'user', '+91 73720 53846', 0, '2024-07-27 08:09:18', 'http://localhost/images/default.png', 1),
(50, 'Chhaya Mahal', 'jagdish59@example.com', NULL, '$2y$12$XBVLMP9yyf05SyZomYRVrulPidCaO5pAdFIUAr1Aql9/6Xbcdf146', NULL, NULL, NULL, NULL, '2024-07-27 08:09:18', '2024-07-27 08:09:18', 'user', '+91 88749 14295', 0, '2024-07-27 08:09:18', 'http://localhost/images/default.png', 1),
(51, 'Urvashi Wali', 'meda.shanti@example.org', NULL, '$2y$12$8wSSzq3HeqdQVX6uaU9eVuYkAuMquR8cgFAfws6SRrxpnqFPfHfXe', NULL, NULL, NULL, NULL, '2024-07-27 08:09:19', '2024-07-27 08:09:19', 'user', '+91 81690 56822', 0, '2024-07-27 08:09:19', 'http://localhost/images/default.png', 1),
(52, 'Sharad Bandi', 'surya.naik@example.com', NULL, '$2y$12$kFu.3rLFrMZSZ.psJveA2OGkaOkR9QcjILNKQAa3KqWkFlVQ7muBy', NULL, NULL, NULL, NULL, '2024-07-27 08:09:19', '2024-07-27 08:09:19', 'user', '+91 86030 59198', 0, '2024-07-27 08:09:19', 'http://localhost/images/default.png', 1),
(53, 'Madhavi Comar', 'qagarwal@example.org', NULL, '$2y$12$E4SQWN6J7TwWhyj0lSpxm.XO.M9ccGn0DLrnb/FB49yFO3X4dcQcu', NULL, NULL, NULL, NULL, '2024-07-27 08:09:19', '2024-07-27 08:09:19', 'user', '+91 84990 31612', 0, '2024-07-27 08:09:19', 'http://localhost/images/default.png', 1),
(54, 'Mukti Bahri', 'chandni70@example.com', NULL, '$2y$12$1UI.K4XhQWtcz.uutOxf5.wEgvHDC.zIjDfU19wx0moUV2p6W/8YO', NULL, NULL, NULL, NULL, '2024-07-27 08:09:19', '2024-07-27 08:09:19', 'user', '+91 75751 55821', 0, '2024-07-27 08:09:19', 'http://localhost/images/default.png', 1),
(55, 'Abdul Mohabir', 'jagruti71@example.net', NULL, '$2y$12$qKuWtB7coNBFyP1pKZk3vu8IqPIRvn5Lbk7pTb4g9J8LWImno3fEy', NULL, NULL, NULL, NULL, '2024-07-27 08:09:20', '2024-07-27 08:09:20', 'user', '+91 79452 86691', 0, '2024-07-27 08:09:20', 'http://localhost/images/default.png', 1),
(56, 'Bijoy Mohanty', 'shobha15@example.com', NULL, '$2y$12$ihNGaul3tY9CdY7hasHV4uqJi.HFjKMd7F/gy1Quwl8yRAsu6Zqse', NULL, NULL, NULL, NULL, '2024-07-27 08:09:20', '2024-07-27 08:09:20', 'user', '+91 80946 60634', 0, '2024-07-27 08:09:20', 'http://localhost/images/default.png', 1),
(57, 'Nilima Sahni', 'narayan.master@example.net', NULL, '$2y$12$WH.wNZwRCF4hHxMrNNi.kOpINt6yoJgBjfPCl.VuB4x2C5SIx0S8S', NULL, NULL, NULL, NULL, '2024-07-27 08:09:20', '2024-07-27 08:09:20', 'user', '+91 95498 53405', 0, '2024-07-27 08:09:20', 'http://localhost/images/default.png', 1),
(58, 'Deep Chohan', 'vivek.acharya@example.net', NULL, '$2y$12$GDTTHPecYsfEiBn3CRUll.Auk4mWq1FYJXBheuhxZUNqpvKvzZkEC', NULL, NULL, NULL, NULL, '2024-07-27 08:09:21', '2024-07-27 08:09:21', 'user', '+91 87727 03863', 0, '2024-07-27 08:09:21', 'http://localhost/images/default.png', 1),
(59, 'Nalini Iyer', 'acontractor@example.com', NULL, '$2y$12$woNTLFUZ3DkOWbkI3wcYNerdHket0c7ZF/7VuIzK33TRUOM9hA0MC', NULL, NULL, NULL, NULL, '2024-07-27 08:09:21', '2024-07-27 08:09:21', 'user', '+91 94605 61464', 0, '2024-07-27 08:09:21', 'http://localhost/images/default.png', 1),
(60, 'Sid Mitter', 'sara18@example.com', NULL, '$2y$12$5NrILY/DLw.UDQ6Mncrik.FPKMmMbtg7t9cbdvs66rOMrTsdb9ISe', NULL, NULL, NULL, NULL, '2024-07-27 08:09:21', '2024-07-27 08:09:21', 'user', '+91 80588 95833', 0, '2024-07-27 08:09:21', 'http://localhost/images/default.png', 1),
(61, 'Ekbal Somani', 'vimala.thaker@example.com', NULL, '$2y$12$EGb1bVOBAwNE/86AiJuz1elNBbHAJsilw4gzD8AIjPmxSmIIGvnay', NULL, NULL, NULL, NULL, '2024-07-27 08:09:21', '2024-07-27 08:09:21', 'user', '+91 93951 82176', 0, '2024-07-27 08:09:21', 'http://localhost/images/default.png', 1),
(62, 'Megha Rau', 'mona23@example.org', NULL, '$2y$12$71IWj6HPNvQV00gKnu/N3O6sfjlzDH86/yITj8fAvz8/qEPA7YBg2', NULL, NULL, NULL, NULL, '2024-07-27 08:09:22', '2024-07-27 08:09:22', 'user', '+91 86502 44965', 0, '2024-07-27 08:09:22', 'http://localhost/images/default.png', 1),
(63, 'Suresh Batra', 'chhavi.garg@example.org', NULL, '$2y$12$Z0exkmOv28pUfpzXnZ8RR.ao3ezC9UNDmy1DbjyBSw8Fq3icZUQPa', NULL, NULL, NULL, NULL, '2024-07-27 08:09:22', '2024-07-27 08:09:22', 'user', '+91 72176 95927', 0, '2024-07-27 08:09:22', 'http://localhost/images/default.png', 1),
(64, 'Nirmal Seshadri', 'bagwati65@example.com', NULL, '$2y$12$4wLSQS9fQTZa0heHNZle.OIPZ3mHP7JjS.3pO4hEeDT65YCuO749a', NULL, NULL, NULL, NULL, '2024-07-27 08:09:22', '2024-07-27 08:09:22', 'user', '+91 75961 79773', 0, '2024-07-27 08:09:22', 'http://localhost/images/default.png', 1),
(65, 'Abhinav Dugar', 'gayatri36@example.net', NULL, '$2y$12$384sZcFQJwGnXUvRLgWnYe009aUanfa6owMYq5boxpntj.AMofCIq', NULL, NULL, NULL, NULL, '2024-07-27 08:09:22', '2024-07-27 08:09:22', 'user', '+91 75000 20843', 0, '2024-07-27 08:09:22', 'http://localhost/images/default.png', 1),
(66, 'Naval Kurian', 'mody.zara@example.com', NULL, '$2y$12$ZiApcN4i4KxJ6Eky2Lf0TOpUBQGNyqoIe/cnc6Ek7YhddKt.xBGl2', NULL, NULL, NULL, NULL, '2024-07-27 08:09:23', '2024-07-27 08:09:23', 'user', '+91 79461 03307', 0, '2024-07-27 08:09:23', 'http://localhost/images/default.png', 1),
(67, 'Avantika Mahadeo', 'rosey.sur@example.net', NULL, '$2y$12$OY5et34BWVxnMJO3lm1rh.Ac.sMBwTRqv4fONW69hc2GhVJT.RhcK', NULL, NULL, NULL, NULL, '2024-07-27 08:09:23', '2024-07-27 08:09:23', 'user', '+91 76809 00002', 0, '2024-07-27 08:09:23', 'http://localhost/images/default.png', 1),
(68, 'Chhavi Dass', 'twason@example.net', NULL, '$2y$12$HgyMcvBMMit6roaXy2/V/OKi7kFykA3FMBf4xgykoe4RCAQfX4g5K', NULL, NULL, NULL, NULL, '2024-07-27 08:09:23', '2024-07-27 08:09:23', 'user', '+91 94322 61394', 0, '2024-07-27 08:09:23', 'http://localhost/images/default.png', 1),
(69, 'Baalkrishan Kade', 'subramaniam.sabina@example.com', NULL, '$2y$12$1IpY1L./RGg.e.tIw94eYORy3qgrG3UKCKjkli7yDdQQFGkm/yC6C', NULL, NULL, NULL, NULL, '2024-07-27 08:09:24', '2024-07-27 08:09:24', 'user', '+91 81045 81669', 0, '2024-07-27 08:09:24', 'http://localhost/images/default.png', 1),
(70, 'Alex Char', 'edutta@example.org', NULL, '$2y$12$uioGywZxySJo05Z7Yhv8de0PIt.ZlxlIbFr.qxpGEWd5.t4rnbdpu', NULL, NULL, NULL, NULL, '2024-07-27 08:09:24', '2024-07-27 08:09:24', 'user', '+91 89228 42100', 0, '2024-07-27 08:09:24', 'http://localhost/images/default.png', 1),
(71, 'Yogesh Butala', 'harbhajan05@example.com', NULL, '$2y$12$WEJSK/phCwiPA1ygRAuwDeTyHRz9kLhIgFWedw8lKb9vd8e5bnrJ6', NULL, NULL, NULL, NULL, '2024-07-27 08:09:24', '2024-07-27 08:09:24', 'user', '+91 79844 41970', 0, '2024-07-27 08:09:24', 'http://localhost/images/default.png', 1),
(72, 'Pushpa Khatri', 'sha.laveena@example.net', NULL, '$2y$12$aEjT6XM24q0G4mgY.LmBxuZkOqCA0BywURk7Uo.xltrWTvrUuAFPa', NULL, NULL, NULL, NULL, '2024-07-27 08:09:24', '2024-07-27 08:09:24', 'user', '+91 71237 88317', 0, '2024-07-27 08:09:24', 'http://localhost/images/default.png', 1),
(73, 'Kalpit Shankar', 'singh.riddhi@example.net', NULL, '$2y$12$EOAyxp4JXZZS0WhHq45RqO7bUhKt.wubfZyqDUqcC/32vJJoe9a8u', NULL, NULL, NULL, NULL, '2024-07-27 08:09:25', '2024-07-27 08:09:25', 'user', '+91 81825 50883', 0, '2024-07-27 08:09:25', 'http://localhost/images/default.png', 1),
(74, 'Krishna Nagi', 'suresh.malpani@example.com', NULL, '$2y$12$wCXnUG3CwS5WZmhjZTM/qOUmf9IDlqJSTQVDR0rX6qZmGjBDW4Qx2', NULL, NULL, NULL, NULL, '2024-07-27 08:09:25', '2024-07-27 08:09:25', 'user', '+91 92231 49687', 0, '2024-07-27 08:09:25', 'http://localhost/images/default.png', 1),
(75, 'Sheetal Rajagopalan', 'ydoshi@example.com', NULL, '$2y$12$9S0jfKgScQCvEK39KaRk9e1.xLzeLdN6RxT0A2.P.DgN5gK4TfJcO', NULL, NULL, NULL, NULL, '2024-07-27 08:09:25', '2024-07-27 08:09:25', 'user', '+91 83561 79425', 0, '2024-07-27 08:09:25', 'http://localhost/images/default.png', 1),
(76, 'Vijay Varughese', 'heer11@example.org', NULL, '$2y$12$Jq40oTlsQCAFG34CrVi05uiNX49UaeU/vp7oWPzQd1SrdDLjRIkGa', NULL, NULL, NULL, NULL, '2024-07-27 08:09:26', '2024-07-27 08:09:26', 'user', '+91 90802 97088', 0, '2024-07-27 08:09:26', 'http://localhost/images/default.png', 1),
(77, 'Kiran Konda', 'hemendra27@example.net', NULL, '$2y$12$FIYY.UT.GBeAM59JfPkXLumSUPb8TJAlEpT6B8YbZMeENUudWuY.O', NULL, NULL, NULL, NULL, '2024-07-27 08:09:26', '2024-07-27 08:09:26', 'user', '+91 79693 10289', 0, '2024-07-27 08:09:26', 'http://localhost/images/default.png', 1),
(78, 'Avantika Edwin', 'ramgopal.anne@example.net', NULL, '$2y$12$7kWJKaxRega4ES8NtwU03OS8FWAHatd3V40.j5a59XSb/Ykfp3NkW', NULL, NULL, NULL, NULL, '2024-07-27 08:09:26', '2024-07-27 08:09:26', 'user', '+91 71232 74820', 0, '2024-07-27 08:09:26', 'http://localhost/images/default.png', 1),
(79, 'Akhila Mani', 'shan.chitranjan@example.org', NULL, '$2y$12$080itWzhuHq8KBtyHtlUiOikXx6mUSRZ1hOpEzGwAqWUC16A1hGgG', NULL, NULL, NULL, NULL, '2024-07-27 08:09:26', '2024-07-27 08:09:26', 'user', '+91 86587 87070', 0, '2024-07-27 08:09:26', 'http://localhost/images/default.png', 1),
(80, 'Tabeed Venkatesh', 'bagate@example.net', NULL, '$2y$12$pazJORrfLz1mpEIGxy2fTeSSBd1.Q1K5YFQ2dG3ZHZk.M.AApAgfe', NULL, NULL, NULL, NULL, '2024-07-27 08:09:27', '2024-07-27 08:09:27', 'user', '+91 90994 36835', 0, '2024-07-27 08:09:27', 'http://localhost/images/default.png', 1),
(81, 'Mridula Shenoy', 'gauransh33@example.net', NULL, '$2y$12$x0LydMZ7.Tf/rTa3fD3/meJ6ILIyHOermgrubUa3ucWZBOazZxSBS', NULL, NULL, NULL, NULL, '2024-07-27 08:09:27', '2024-07-27 08:09:27', 'user', '+91 93080 46545', 0, '2024-07-27 08:09:27', 'http://localhost/images/default.png', 1),
(82, 'Venkat Chaudhuri', 'wagle.hanuman@example.com', NULL, '$2y$12$zXpu.KZFpJhRFR5TuSUWHeAU9biSVnrpVe5ED8BMWr6GqM3I1f9TK', NULL, NULL, NULL, NULL, '2024-07-27 08:09:27', '2024-07-27 08:09:27', 'user', '+91 85687 74322', 0, '2024-07-27 08:09:27', 'http://localhost/images/default.png', 1),
(83, 'Damini Chohan', 'kajol53@example.com', NULL, '$2y$12$Q81FOXpf7lr3lGUCD3APduxdcDnk5.D25TzCY0SXp/EYEPEVuWjB.', NULL, NULL, NULL, NULL, '2024-07-27 08:09:28', '2024-07-27 08:09:28', 'user', '+91 92046 22987', 0, '2024-07-27 08:09:28', 'http://localhost/images/default.png', 1),
(84, 'Chirag Gera', 'nutan29@example.com', NULL, '$2y$12$YNMcQfSZZsIcreX5inrhqObTc9d7trxnSL3UFXTwLDn2RCoQaQ9qe', NULL, NULL, NULL, NULL, '2024-07-27 08:09:28', '2024-07-27 08:09:28', 'user', '+91 77896 74664', 0, '2024-07-27 08:09:28', 'http://localhost/images/default.png', 1),
(85, 'Siddharth Jani', 'raja.prabhat@example.net', NULL, '$2y$12$5PW6spjYWLFnnCEE.p5.OuNl7u5VKIbOH8GKRZ0pZBw0e85LF2ziG', NULL, NULL, NULL, NULL, '2024-07-27 08:09:28', '2024-07-27 08:09:28', 'user', '+91 74285 65365', 0, '2024-07-27 08:09:28', 'http://localhost/images/default.png', 1),
(86, 'Balaji Chawla', 'ichana@example.net', NULL, '$2y$12$9dsyo2buzVMMERyTaAKgQe90t.E3s2CHf7E2hELhJyjRq/NTd389O', NULL, NULL, NULL, NULL, '2024-07-27 08:09:28', '2024-07-27 08:09:28', 'user', '+91 94046 63877', 0, '2024-07-27 08:09:28', 'http://localhost/images/default.png', 1),
(87, 'Nayan Palan', 'ssura@example.net', NULL, '$2y$12$./yOOkMyS3PFwb0ExOImdugKksUjKSTsSlgkymPLwus/XKGnxAirS', NULL, NULL, NULL, NULL, '2024-07-27 08:09:29', '2024-07-27 08:09:29', 'user', '+91 93319 06960', 0, '2024-07-27 08:09:29', 'http://localhost/images/default.png', 1),
(88, 'Kalyani Sangha', 'ajeet.dara@example.net', NULL, '$2y$12$0SI.x46r6ie1tyZa9BMQguJeMbZrxACZ3JqMH965lR7HfMGk4sBRi', NULL, NULL, NULL, NULL, '2024-07-27 08:09:29', '2024-07-27 08:09:29', 'user', '+91 78909 70863', 0, '2024-07-27 08:09:29', 'http://localhost/images/default.png', 1),
(89, 'Laveena Suresh', 'thakur.leelawati@example.org', NULL, '$2y$12$PS52q6dtuPAQnIfZqC/NBuaiMLTa20DYvyEW/0bjoXfPIfA5RjR/S', NULL, NULL, NULL, NULL, '2024-07-27 08:09:29', '2024-07-27 08:09:29', 'user', '+91 72075 25473', 0, '2024-07-27 08:09:29', 'http://localhost/images/default.png', 1),
(90, 'Natwar Venkataraman', 'gala.kirti@example.org', NULL, '$2y$12$F5kzl9wyta5NmnJbQ9SuuuEBJJ4tXNZHZtca6D/gBSoz24mnOZuNK', NULL, NULL, NULL, NULL, '2024-07-27 08:09:30', '2024-07-27 08:09:30', 'user', '+91 99436 17841', 0, '2024-07-27 08:09:30', 'http://localhost/images/default.png', 1),
(91, 'Julie Puri', 'brahmbhatt.mitesh@example.org', NULL, '$2y$12$f/aj/NmokkkqXbxo4BchXOEuU4UP.EXlZlPy4goJGyqYDNfF5ul5e', NULL, NULL, NULL, NULL, '2024-07-27 08:09:30', '2024-07-27 08:09:30', 'user', '+91 87605 79920', 0, '2024-07-27 08:09:30', 'http://localhost/images/default.png', 1),
(92, 'Anees Sarma', 'rakhi62@example.net', NULL, '$2y$12$dkqAFWvNqVHTb9aiTlo4LOdiJcTKtK48VW3UgkKdU.QsUFyvANPCe', NULL, NULL, NULL, NULL, '2024-07-27 08:09:30', '2024-07-27 08:09:30', 'user', '+91 73194 79218', 0, '2024-07-27 08:09:30', 'http://localhost/images/default.png', 1),
(93, 'Sid Shukla', 'tata.krishna@example.com', NULL, '$2y$12$yP2cNOt5AfDzXZoXz6KU9OIOgKmYGHyfHepdEHie94DBAGFvP5YzO', NULL, NULL, NULL, NULL, '2024-07-27 08:09:30', '2024-07-27 08:09:30', 'user', '+91 88469 78586', 0, '2024-07-27 08:09:30', 'http://localhost/images/default.png', 1),
(94, 'Aayushman Usman', 'laveena.salvi@example.com', NULL, '$2y$12$Cuv8.K5fGe4UE5DEN9KPdeZiBgIpK9BbZkFLD.J1RXL8yg17.cscS', NULL, NULL, NULL, NULL, '2024-07-27 08:09:31', '2024-07-27 08:09:31', 'user', '+91 83839 21053', 0, '2024-07-27 08:09:31', 'http://localhost/images/default.png', 1),
(95, 'Sona Korpal', 'rvarma@example.net', NULL, '$2y$12$cv3jRryXJJKzhgxbX/ZFweGKiut.94QewY0YQuZN46LfKSow3sUZu', NULL, NULL, NULL, NULL, '2024-07-27 08:09:31', '2024-07-27 08:09:31', 'user', '+91 92321 42142', 0, '2024-07-27 08:09:31', 'http://localhost/images/default.png', 1),
(96, 'Madhavi Handa', 'aayushman.nanda@example.org', NULL, '$2y$12$eHZ50ZH3mmE..7WBpqKW3.FP2TMyk.Jvqr.L/cmP3CuHKcdX7lpxW', NULL, NULL, NULL, NULL, '2024-07-27 08:09:31', '2024-07-27 08:09:31', 'user', '+91 82355 19167', 0, '2024-07-27 08:09:31', 'http://localhost/images/default.png', 1),
(97, 'Harpreet Sandal', 'ndash@example.com', NULL, '$2y$12$Daq0UaijpGCaBPIXcUN72eNQXVU1PEfLQnCkj9.E9phcmcg6EYnvG', NULL, NULL, NULL, NULL, '2024-07-27 08:09:32', '2024-07-27 08:09:32', 'user', '+91 87864 11692', 0, '2024-07-27 08:09:32', 'http://localhost/images/default.png', 1),
(98, 'Rashid Nagarajan', 'himesh.bajwa@example.net', NULL, '$2y$12$5P5iD7YOFD/y0kIIxE6b6O4/zRBTJMamPz5ktPVtCUubkTcd0evSe', NULL, NULL, NULL, NULL, '2024-07-27 08:09:32', '2024-07-27 08:09:32', 'user', '+91 92806 09489', 0, '2024-07-27 08:09:32', 'http://localhost/images/default.png', 1),
(99, 'Amir Narula', 'bahadur04@example.com', NULL, '$2y$12$hzHv.j.TjrFZ1A9EHTxCLOKfEeEZCouK62byd/Z954Uh667.ux/A6', NULL, NULL, NULL, NULL, '2024-07-27 08:09:32', '2024-07-27 08:09:32', 'user', '+91 81158 98014', 0, '2024-07-27 08:09:32', 'http://localhost/images/default.png', 1),
(100, 'Jayshree Srinivas', 'mgarg@example.net', NULL, '$2y$12$2zTkx4.IEfQQLutta9lYWOLV0cAczgNBwBMKdO7bXQtBzQgazLsTO', NULL, NULL, NULL, NULL, '2024-07-27 08:09:32', '2024-07-27 08:09:32', 'user', '+91 86157 51737', 0, '2024-07-27 08:09:32', 'http://localhost/images/default.png', 1),
(101, 'Pinky Cherian', 'lbhatt@example.org', NULL, '$2y$12$DKaC/8dBLS0I6ft9IpQ.1eYx95M9.Y9EjnXRxonuVXeVgr2.egwfW', NULL, NULL, NULL, NULL, '2024-07-27 08:09:33', '2024-07-27 08:09:33', 'user', '+91 81051 34162', 0, '2024-07-27 08:09:33', 'http://localhost/images/default.png', 1),
(102, 'Pamela Mangat', 'cdhawan@example.org', NULL, '$2y$12$oaeF9za..zntAXDVSj1l..ssLIzf0Hes1yd36FQFpP647q5hvdFRa', NULL, NULL, NULL, NULL, '2024-07-27 08:09:33', '2024-07-27 08:09:33', 'user', '+91 85649 72695', 0, '2024-07-27 08:09:33', 'http://localhost/images/default.png', 1),
(103, 'Yadunandan Dhillon', 'monica.singhal@example.com', NULL, '$2y$12$F/4g0R.BTSLTQ3HGGEUTxuHb.Gpr5YA6kTNu.48LmupOpGR3Pg8pO', NULL, NULL, NULL, NULL, '2024-07-27 08:09:33', '2024-07-27 08:09:33', 'user', '+91 93418 19096', 0, '2024-07-27 08:09:33', 'http://localhost/images/default.png', 1),
(104, 'Baber Chia', 'sid.sodhani@example.net', NULL, '$2y$12$OAV5/OUYwpByKqO7sKhi..Q2a/WKTzNbM3c6wCDj5Q0neJtRfc0QG', NULL, NULL, NULL, NULL, '2024-07-27 08:09:33', '2024-07-27 08:09:33', 'user', '+91 77966 27807', 0, '2024-07-27 08:09:33', 'http://localhost/images/default.png', 1),
(105, 'Jyoti Sama', 'hsuresh@example.com', NULL, '$2y$12$rHHLY5052nMoOwHsKMcCZusKBNQnmjRS7pV0xmUxpDUatA/p9jgoS', NULL, NULL, NULL, NULL, '2024-07-27 08:09:34', '2024-07-27 08:09:34', 'user', '+91 78881 64909', 0, '2024-07-27 08:09:34', 'http://localhost/images/default.png', 1),
(106, 'Anshula Oak', 'faraz32@example.net', NULL, '$2y$12$GsVETrcjQweio1vTaX96oOiaMTV5tREHiW8MQ5n7JtKgzMgv8x.LO', NULL, NULL, NULL, NULL, '2024-07-27 08:09:34', '2024-07-27 08:09:34', 'user', '+91 74437 68698', 0, '2024-07-27 08:09:34', 'http://localhost/images/default.png', 1),
(107, 'Taahid Salvi', 'upasana64@example.net', NULL, '$2y$12$1hTQ6z0XufzWRyhELfu5AePuvowIc2lVMZqcIkpnqI68tZqIsd.Km', NULL, NULL, NULL, NULL, '2024-07-27 08:09:34', '2024-07-27 08:09:34', 'user', '+91 89854 59546', 0, '2024-07-27 08:09:34', 'http://localhost/images/default.png', 1),
(108, 'Elias Cherian', 'sahota.yasmin@example.org', NULL, '$2y$12$RiJseYmBGeCeeQvLk5C7LOocPwuZR2ohzTdp1trQR9Uk5AHBmr3Lu', NULL, NULL, NULL, NULL, '2024-07-27 08:09:35', '2024-07-27 08:09:35', 'user', '+91 92669 75714', 0, '2024-07-27 08:09:35', 'http://localhost/images/default.png', 1),
(109, 'Aarushi Saini', 'saraf.madhu@example.com', NULL, '$2y$12$8Labkwx4PCsOBN2i8LmfDO3yDGXio6hwskkdHW3lJY1FOHExkmyju', NULL, NULL, NULL, NULL, '2024-07-27 08:09:35', '2024-07-27 08:09:35', 'user', '+91 70382 01567', 0, '2024-07-27 08:09:35', 'http://localhost/images/default.png', 1),
(110, 'Lakshmi Gala', 'kirti.dugar@example.com', NULL, '$2y$12$slSJOYjCKwQqSQTYUOAUtehG7WgoEFjL3BDKbyIgF1cdmSaQQ2xO.', NULL, NULL, NULL, NULL, '2024-07-27 08:09:35', '2024-07-27 08:09:35', 'user', '+91 95655 85097', 0, '2024-07-27 08:09:35', 'http://localhost/images/default.png', 1),
(111, 'Peter Sha', 'varughese.fardeen@example.org', NULL, '$2y$12$7.fjA3zhWj5MRIXrR6N89uA2JjuPFDLS4tHYPqXD9S6m32KBDJ6U6', NULL, NULL, NULL, NULL, '2024-07-27 08:09:35', '2024-07-27 08:09:35', 'user', '+91 84855 26355', 0, '2024-07-27 08:09:35', 'http://localhost/images/default.png', 1),
(112, 'Sushmita Date', 'diya10@example.org', NULL, '$2y$12$A8xSOcxhSsd3b6nnQdB7Eernb2.EIMhAtPnfWp39gUm5goszPDb9S', NULL, NULL, NULL, NULL, '2024-07-27 08:09:36', '2024-07-27 08:09:36', 'user', '+91 83312 23259', 0, '2024-07-27 08:09:36', 'http://localhost/images/default.png', 1),
(113, 'Farah Manne', 'gulzar07@example.com', NULL, '$2y$12$fCVweYoTYgHek6sfeQ5zYOxqV0w7iV2HnPInHoI2xofLLjUPWn74e', NULL, NULL, NULL, NULL, '2024-07-27 08:09:36', '2024-07-27 08:09:36', 'user', '+91 83956 79794', 0, '2024-07-27 08:09:36', 'http://localhost/images/default.png', 1),
(114, 'Pradeep Pandit', 'bose.zaad@example.org', NULL, '$2y$12$l2wWeD1Nm6n/51CjrS1fluJnjFjyyb1Ako41l2.lYaaOs4cZjNeom', NULL, NULL, NULL, NULL, '2024-07-27 08:09:36', '2024-07-27 08:09:36', 'user', '+91 78216 85243', 0, '2024-07-27 08:09:36', 'http://localhost/images/default.png', 1),
(115, 'Aditi Master', 'pirzada.sangha@example.com', NULL, '$2y$12$zv2yE6flpO3wQkS3ahVvVeUeTkDXYAi.RFVjqlmsXiNbjBtHyPM96', NULL, NULL, NULL, NULL, '2024-07-27 08:09:37', '2024-07-27 08:09:37', 'user', '+91 98160 60657', 0, '2024-07-27 08:09:37', 'http://localhost/images/default.png', 1),
(116, 'Bahadur Bajwa', 'ekibe@example.com', NULL, '$2y$12$Q5rUXLd.Mt/nM5Q9vYuy5OwZylY/IX/KzOHbmXqAgrBwXhBd9y8V2', NULL, NULL, NULL, NULL, '2024-07-27 08:09:37', '2024-07-27 08:09:37', 'user', '+91 74817 80464', 0, '2024-07-27 08:09:37', 'http://localhost/images/default.png', 1),
(117, 'Nalini Sarna', 'ahluwalia.emran@example.net', NULL, '$2y$12$mtrL1rWvSivjii6rL5E5vu6kcmYY1HsvqUr/wpYnEwIo6JPyszhC6', NULL, NULL, NULL, NULL, '2024-07-27 08:09:37', '2024-07-27 08:09:37', 'user', '+91 83925 36051', 0, '2024-07-27 08:09:37', 'http://localhost/images/default.png', 1),
(118, 'Nancy Ben', 'abiyani@example.net', NULL, '$2y$12$qpI1PSbzngd0AZBjAGuLSuZpIbV5HBdQxhvOlBt4fXuVbc6P6QdTW', NULL, NULL, NULL, NULL, '2024-07-27 08:09:37', '2024-07-27 08:09:37', 'user', '+91 83256 58020', 0, '2024-07-27 08:09:37', 'http://localhost/images/default.png', 1),
(119, 'Radheshyam Mukherjee', 'payal.ramanathan@example.net', NULL, '$2y$12$MNdax07S94J3bZR8m6De4uil3ewxH8LhjZCuq2aN1D0jnTNY8Fnie', NULL, NULL, NULL, NULL, '2024-07-27 08:09:38', '2024-07-27 08:09:38', 'user', '+91 92167 61297', 0, '2024-07-27 08:09:38', 'http://localhost/images/default.png', 1),
(120, 'Mona Oza', 'varghese.akanksha@example.net', NULL, '$2y$12$ShPlqXT0n5ajw2EVT.kHpuSIxg6QrDbgKtGj6tUE0xGq6j5GrfzYS', NULL, NULL, NULL, NULL, '2024-07-27 08:09:38', '2024-07-27 08:09:38', 'user', '+91 90706 63843', 0, '2024-07-27 08:09:38', 'http://localhost/images/default.png', 1),
(121, 'Harbhajan Chana', 'omagar@example.org', NULL, '$2y$12$eMAovvwp72ehfAUqLkLAO.VpjrNhyE5FVzkbmoSRBc98ltOGLH5ve', NULL, NULL, NULL, NULL, '2024-07-27 08:09:38', '2024-07-27 08:09:38', 'user', '+91 91963 45298', 0, '2024-07-27 08:09:38', 'http://localhost/images/default.png', 1),
(122, 'Giaan Ranganathan', 'supriya62@example.org', NULL, '$2y$12$0g89TRz3.zrzgo3P/7NROOSy6LPfmmwSB2X62o/4r7i2W28sUKoau', NULL, NULL, NULL, NULL, '2024-07-27 08:09:39', '2024-07-27 08:09:39', 'user', '+91 99915 26003', 0, '2024-07-27 08:09:39', 'http://localhost/images/default.png', 1),
(123, 'Sunil Saha', 'ss@gmail.com', NULL, '$2y$12$pQAPde5MK88d64onqPbsQu67sKl8n4.X9ZSmGIKV4wr4QIhKhosuq', NULL, NULL, NULL, NULL, '2024-07-28 07:13:17', '2024-07-28 07:18:28', 'user', '+91 87875 69623', 0, '2024-07-28 07:18:28', 'http://127.0.0.1:8001/images/default.png', 1);

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
(1, 'Aadhar Card', '4454-5658-9658-4785', 'uploads/store_manager/SRL_Diagonastics_Halisahar/1711175343.png', NULL, NULL, NULL, 2, 1, 1, '2024-03-23', NULL, '2024-03-23 06:29:03', '2024-03-23 10:56:15'),
(2, 'Pan Card', 'FDUIK0667R', 'uploads/collector/Ratan_Konar/1711175407.jpg', NULL, NULL, NULL, 19, 1, 1, '2024-03-23', NULL, '2024-03-23 06:30:07', '2024-03-23 10:56:33'),
(3, 'Pan Card', 'DDD888DD', 'uploads/store_manager/Netralok_Lab/1711190482.jpg', NULL, NULL, NULL, 6, 2, 1, '2024-03-23', NULL, '2024-03-23 10:41:22', '2024-03-23 10:44:52'),
(4, 'Aadhar Card', '8767-0965-0985-4029', 'uploads/collector/Ratan_Konar/1711214978.png', NULL, '1990-01-02', '2026-06-07', 19, 1, 1, '2024-04-11', NULL, '2024-03-23 17:29:38', '2024-04-11 12:07:44'),
(5, 'Aadhar Card 2', '4525-9658-4859-9632', 'uploads/collector/Ratan_Konar/1711215196.png', NULL, '2024-01-03', '2026-06-03', 19, 2, 1, '2024-04-11', NULL, '2024-03-23 17:33:16', '2024-04-11 12:07:50'),
(6, 'Aadhar Card 3', '4455-2345-4543-3233', 'uploads/collector/Ratan_Konar/1711215711.png', NULL, '2024-03-01', '2024-03-24', 19, 1, 1, '2024-04-11', NULL, '2024-03-23 17:41:51', '2024-04-11 12:07:55'),
(7, 'Aadhar Card 4', '5458-6598-3254-4578', 'uploads/collector/Ratan_Konar/1711217620.png', 'uploads/collector/Ratan_Konar/1711217620.jpg', NULL, NULL, 19, 1, 1, '2024-04-11', NULL, '2024-03-23 18:13:40', '2024-04-11 12:07:59'),
(8, 'Aadhar Card 5', '5485-9658-6325-5412', 'uploads/collector/Ratan_Konar/1711217791.jpg', 'uploads/collector/Ratan_Konar/1711217791.png', '2024-01-10', '2024-03-30', 19, 0, 0, NULL, NULL, '2024-03-23 18:16:31', '2024-03-23 18:16:31'),
(9, 'Aadhar Card 6', '4521-9658-6325-4523', 'uploads/collector/Ratan_Konar/1711217841.jpg', 'uploads/collector/Ratan_Konar/1711217841.png', '2023-11-01', '2024-03-31', 19, 0, 0, NULL, NULL, '2024-03-23 18:17:21', '2024-03-23 18:17:21');

-- --------------------------------------------------------

--
-- Table structure for table `wallet_users`
--

CREATE TABLE `wallet_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `balance` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wallet_users`
--

INSERT INTO `wallet_users` (`id`, `user_id`, `balance`, `created_at`, `updated_at`) VALUES
(1, 1, 0.00, NULL, NULL),
(2, 2, 0.00, NULL, NULL),
(3, 6, 0.00, NULL, NULL),
(4, 9, 0.00, NULL, NULL),
(5, 10, 0.00, NULL, NULL),
(6, 13, 0.00, NULL, NULL),
(7, 14, 0.00, NULL, NULL),
(8, 15, 0.00, NULL, NULL),
(9, 16, 0.00, NULL, NULL),
(10, 17, 0.00, NULL, NULL),
(11, 18, 0.00, NULL, NULL),
(12, 19, 22400.00, NULL, '2024-03-20 19:51:38'),
(13, 20, 0.00, '2024-03-02 13:37:09', '2024-03-02 13:37:09'),
(14, 21, 2140.00, '2024-03-16 15:12:45', '2024-03-20 19:56:51'),
(15, 22, 0.00, '2024-05-22 05:09:57', '2024-05-22 05:09:57');

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
-- Indexes for table `collectors`
--
ALTER TABLE `collectors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `collectors_user_id_foreign` (`user_id`);

--
-- Indexes for table `collector_form_field_values`
--
ALTER TABLE `collector_form_field_values`
  ADD PRIMARY KEY (`id`),
  ADD KEY `collector_form_field_values_form_field_id_foreign` (`form_field_id`),
  ADD KEY `collector_form_field_values_collector_id_foreign` (`collector_id`),
  ADD KEY `collector_form_field_values_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `collector_lab_associations`
--
ALTER TABLE `collector_lab_associations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `collector_lab_associations_laboratories_id_foreign` (`laboratories_id`),
  ADD KEY `collector_lab_associations_collector_id_foreign` (`collector_id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupon_histories`
--
ALTER TABLE `coupon_histories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `doctors_user_id_foreign` (`user_id`);

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
  ADD KEY `form_field_values_form_field_id_foreign` (`form_field_id`),
  ADD KEY `form_field_values_laboratorie_id_foreign` (`laboratorie_id`),
  ADD KEY `form_field_values_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `laboratories`
--
ALTER TABLE `laboratories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `laboratories_user_id_foreign` (`user_id`);

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
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_user_id_foreign` (`user_id`);

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
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_order_number_unique` (`order_number`),
  ADD KEY `orders_laboratorie_id_foreign` (`laboratorie_id`),
  ADD KEY `orders_patient_id_foreign` (`patient_id`);

--
-- Indexes for table `order_tests`
--
ALTER TABLE `order_tests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_tests_order_id_foreign` (`order_id`),
  ADD KEY `order_tests_pathology_test_id_foreign` (`pathology_test_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `pathology_tests`
--
ALTER TABLE `pathology_tests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pathology_tests_pathology_test_categorie_id_foreign` (`pathology_test_categorie_id`);

--
-- Indexes for table `pathology_test_categories`
--
ALTER TABLE `pathology_test_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `patients_mobile_number_unique` (`mobile_number`),
  ADD KEY `patients_user_id_foreign` (`user_id`);

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
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transactions_user_id_foreign` (`user_id`),
  ADD KEY `transactions_wallet_user_id_foreign` (`wallet_user_id`);

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
-- Indexes for table `wallet_users`
--
ALTER TABLE `wallet_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wallet_users_user_id_foreign` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_menus`
--
ALTER TABLE `admin_menus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `admin_menu_roles`
--
ALTER TABLE `admin_menu_roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `collectors`
--
ALTER TABLE `collectors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `collector_form_field_values`
--
ALTER TABLE `collector_form_field_values`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `collector_lab_associations`
--
ALTER TABLE `collector_lab_associations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `coupon_histories`
--
ALTER TABLE `coupon_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `doc_form_field_values`
--
ALTER TABLE `doc_form_field_values`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `form_fields`
--
ALTER TABLE `form_fields`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `form_field_options`
--
ALTER TABLE `form_field_options`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `form_field_roles`
--
ALTER TABLE `form_field_roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `form_field_values`
--
ALTER TABLE `form_field_values`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `laboratories`
--
ALTER TABLE `laboratories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `lab_form_field_values`
--
ALTER TABLE `lab_form_field_values`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `login_securities`
--
ALTER TABLE `login_securities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `order_tests`
--
ALTER TABLE `order_tests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pathology_tests`
--
ALTER TABLE `pathology_tests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pathology_test_categories`
--
ALTER TABLE `pathology_test_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `role_users`
--
ALTER TABLE `role_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=225;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=124;

--
-- AUTO_INCREMENT for table `user_documents`
--
ALTER TABLE `user_documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `wallet_users`
--
ALTER TABLE `wallet_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

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
-- Constraints for table `collectors`
--
ALTER TABLE `collectors`
  ADD CONSTRAINT `collectors_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `collector_form_field_values`
--
ALTER TABLE `collector_form_field_values`
  ADD CONSTRAINT `collector_form_field_values_collector_id_foreign` FOREIGN KEY (`collector_id`) REFERENCES `collectors` (`id`),
  ADD CONSTRAINT `collector_form_field_values_form_field_id_foreign` FOREIGN KEY (`form_field_id`) REFERENCES `form_fields` (`id`),
  ADD CONSTRAINT `collector_form_field_values_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `collector_lab_associations`
--
ALTER TABLE `collector_lab_associations`
  ADD CONSTRAINT `collector_lab_associations_collector_id_foreign` FOREIGN KEY (`collector_id`) REFERENCES `collectors` (`id`),
  ADD CONSTRAINT `collector_lab_associations_laboratories_id_foreign` FOREIGN KEY (`laboratories_id`) REFERENCES `laboratories` (`id`);

--
-- Constraints for table `doctors`
--
ALTER TABLE `doctors`
  ADD CONSTRAINT `doctors_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

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
  ADD CONSTRAINT `form_field_values_form_field_id_foreign` FOREIGN KEY (`form_field_id`) REFERENCES `form_fields` (`id`),
  ADD CONSTRAINT `form_field_values_laboratorie_id_foreign` FOREIGN KEY (`laboratorie_id`) REFERENCES `laboratories` (`id`),
  ADD CONSTRAINT `form_field_values_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `laboratories`
--
ALTER TABLE `laboratories`
  ADD CONSTRAINT `laboratories_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `lab_form_field_values`
--
ALTER TABLE `lab_form_field_values`
  ADD CONSTRAINT `lab_form_field_values_form_field_id_foreign` FOREIGN KEY (`form_field_id`) REFERENCES `form_fields` (`id`),
  ADD CONSTRAINT `lab_form_field_values_laboratorie_id_foreign` FOREIGN KEY (`laboratorie_id`) REFERENCES `laboratories` (`id`),
  ADD CONSTRAINT `lab_form_field_values_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_laboratorie_id_foreign` FOREIGN KEY (`laboratorie_id`) REFERENCES `laboratories` (`id`),
  ADD CONSTRAINT `orders_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`);

--
-- Constraints for table `order_tests`
--
ALTER TABLE `order_tests`
  ADD CONSTRAINT `order_tests_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_tests_pathology_test_id_foreign` FOREIGN KEY (`pathology_test_id`) REFERENCES `pathology_tests` (`id`);

--
-- Constraints for table `pathology_tests`
--
ALTER TABLE `pathology_tests`
  ADD CONSTRAINT `pathology_tests_pathology_test_categorie_id_foreign` FOREIGN KEY (`pathology_test_categorie_id`) REFERENCES `pathology_test_categories` (`id`);

--
-- Constraints for table `patients`
--
ALTER TABLE `patients`
  ADD CONSTRAINT `patients_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `role_users`
--
ALTER TABLE `role_users`
  ADD CONSTRAINT `role_users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`),
  ADD CONSTRAINT `role_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `transactions_wallet_user_id_foreign` FOREIGN KEY (`wallet_user_id`) REFERENCES `wallet_users` (`id`);

--
-- Constraints for table `user_documents`
--
ALTER TABLE `user_documents`
  ADD CONSTRAINT `user_documents_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `wallet_users`
--
ALTER TABLE `wallet_users`
  ADD CONSTRAINT `wallet_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
