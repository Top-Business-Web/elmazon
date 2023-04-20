-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 20, 2023 at 10:14 AM
-- Server version: 8.0.31
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `students`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
CREATE TABLE IF NOT EXISTS `admins` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admins_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `image`, `created_at`, `updated_at`) VALUES
(1, 'eldapour', 'admin@admin.com', '$2y$10$qkVihXeX7E7ytPLF7LgoN.OhLpRJdUPvhTZaJINDqOWjElYPzhizS', 'assets/uploads/admins/90951681985436.webp', '2023-02-23 06:05:54', '2023-04-20 10:10:36');

-- --------------------------------------------------------

--
-- Table structure for table `ads`
--

DROP TABLE IF EXISTS `ads`;
CREATE TABLE IF NOT EXISTS `ads` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `link` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('true','false') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'true',
  `type` enum('image','video') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'image',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `all_exams`
--

DROP TABLE IF EXISTS `all_exams`;
CREATE TABLE IF NOT EXISTS `all_exams` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name_ar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_en` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_exam` date NOT NULL,
  `quize_minute` int NOT NULL,
  `trying_number` int NOT NULL,
  `degree` int NOT NULL,
  `note` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `season_id` bigint UNSIGNED NOT NULL,
  `term_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `all_exams_season_id_foreign` (`season_id`),
  KEY `all_exams_term_id_foreign` (`term_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `all_exams`
--

INSERT INTO `all_exams` (`id`, `name_ar`, `name_en`, `date_exam`, `quize_minute`, `trying_number`, `degree`, `note`, `created_at`, `updated_at`, `season_id`, `term_id`) VALUES
(1, '1امتحان شامل علي الفصل ', 'Full Exam about 1', '2023-03-20', 40, 10, 40, 'يرجي الالتزام بالتعليمات والارشادات للامتحانات الشامله', '2023-02-23 06:05:56', '2023-02-23 06:05:56', 1, 1),
(2, '2امتحان شامل علي الفصل ', 'Full Exam about 2', '2023-03-20', 50, 10, 40, 'يرجي الالتزام بالتعليمات والارشادات للامتحانات الشامله', '2023-02-23 06:05:56', '2023-02-23 06:05:56', 1, 1),
(3, '3امتحان شامل علي الفصل ', 'Full Exam about 3', '2023-03-20', 70, 10, 40, 'يرجي الالتزام بالتعليمات والارشادات للامتحانات الشامله', '2023-02-23 06:05:56', '2023-02-23 06:05:56', 1, 1),
(4, '4امتحان شامل علي الفصل ', 'Full Exam about 4', '2023-03-20', 70, 10, 40, 'يرجي الالتزام بالتعليمات والارشادات للامتحانات الشامله', '2023-02-23 06:05:57', '2023-02-23 06:05:57', 1, 1),
(5, '5امتحان شامل علي الفصل ', 'Full Exam about 5', '2023-03-20', 80, 10, 40, 'يرجي الالتزام بالتعليمات والارشادات للامتحانات الشامله', '2023-02-23 06:05:57', '2023-02-23 06:05:57', 1, 1),
(6, '6امتحان شامل علي الفصل ', 'Full Exam about 6', '2023-03-20', 90, 10, 40, 'يرجي الالتزام بالتعليمات والارشادات للامتحانات الشامله', '2023-02-23 06:05:57', '2023-02-23 06:05:57', 1, 1),
(7, '7امتحان شامل علي الفصل ', 'Full Exam about 7', '2023-03-20', 100, 10, 40, 'يرجي الالتزام بالتعليمات والارشادات للامتحانات الشامله', '2023-02-23 06:05:57', '2023-02-23 06:05:57', 1, 1),
(8, '8امتحان شامل علي الفصل ', 'Full Exam about 8', '2023-03-20', 90, 10, 40, 'يرجي الالتزام بالتعليمات والارشادات للامتحانات الشامله', '2023-02-23 06:05:57', '2023-02-23 06:05:57', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

DROP TABLE IF EXISTS `answers`;
CREATE TABLE IF NOT EXISTS `answers` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `answer` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `answer_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `answer_status` enum('correct','un_correct') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'correct' COMMENT 'Answer status',
  `note` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `question_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `answers_question_id_foreign` (`question_id`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`id`, `answer`, `answer_number`, `answer_status`, `note`, `question_id`, `created_at`, `updated_at`) VALUES
(1, '0.1', '(ا)', 'correct', NULL, 1, '2023-03-06 07:56:03', '2023-03-06 07:56:03'),
(2, '0.2', '(ب)', 'un_correct', NULL, 1, '2023-03-06 07:56:03', '2023-03-06 07:56:03'),
(3, '0.5', '(ج)', 'un_correct', NULL, 1, '2023-03-06 07:56:03', '2023-03-06 07:56:03'),
(4, '7', '(د)', 'un_correct', NULL, 1, '2023-03-06 07:56:03', '2023-03-06 07:56:03'),
(5, '0.03', '(ا)', 'correct', NULL, 2, '2023-03-06 07:56:03', '2023-03-06 07:56:03'),
(6, '0.04', '(ب)', 'un_correct', NULL, 2, '2023-03-06 07:56:03', '2023-03-06 07:56:03'),
(7, '0.06', '(ج)', 'un_correct', NULL, 2, '2023-03-06 07:56:03', '2023-03-06 07:56:03'),
(8, '0.08', '(د)', 'un_correct', NULL, 2, '2023-03-06 07:56:03', '2023-03-06 07:56:03'),
(9, '0.25%', '(ا)', 'correct', NULL, 3, '2023-03-06 07:56:03', '2023-03-06 07:56:03'),
(10, '0.40%', '(ب)', 'un_correct', NULL, 3, '2023-03-06 07:56:03', '2023-03-06 07:56:03'),
(11, '0.60%', '(ج)', 'un_correct', NULL, 3, '2023-03-06 07:56:03', '2023-03-06 07:56:03'),
(12, '0.80%', '(د)', 'un_correct', NULL, 3, '2023-03-06 07:56:03', '2023-03-06 07:56:03'),
(13, '70', '(ا)', 'correct', NULL, 5, '2023-03-06 07:56:03', '2023-03-06 07:56:03'),
(14, '120', '(ب)', 'un_correct', NULL, 5, '2023-03-06 07:56:03', '2023-03-06 07:56:03'),
(15, '15', '(ج)', 'un_correct', NULL, 5, '2023-03-06 07:56:03', '2023-03-06 07:56:03'),
(16, '110', '(د)', 'un_correct', NULL, 5, '2023-03-06 07:56:03', '2023-03-06 07:56:03'),
(17, '5', '(ا)', 'correct', NULL, 6, '2023-03-06 07:56:03', '2023-03-06 07:56:03'),
(18, '10', '(ب)', 'un_correct', NULL, 6, '2023-03-06 07:56:03', '2023-03-06 07:56:03'),
(19, '15', '(ج)', 'un_correct', NULL, 6, '2023-03-06 07:56:03', '2023-03-06 07:56:03'),
(20, '20', '(د)', 'un_correct', NULL, 6, '2023-03-06 07:56:03', '2023-03-06 07:56:03'),
(21, '3', '(ا)', 'correct', NULL, 7, '2023-03-06 07:56:03', '2023-03-06 07:56:03'),
(22, '16', '(ب)', 'un_correct', NULL, 7, '2023-03-06 07:56:03', '2023-03-06 07:56:03'),
(23, '18', '(ج)', 'un_correct', NULL, 7, '2023-03-06 07:56:03', '2023-03-06 07:56:03'),
(24, '25', '(د)', 'un_correct', NULL, 7, '2023-03-06 07:56:03', '2023-03-06 07:56:03'),
(25, '90', '(ا)', 'correct', NULL, 8, '2023-03-06 07:56:03', '2023-03-06 07:56:03'),
(26, '100', '(ب)', 'un_correct', NULL, 8, '2023-03-06 07:56:03', '2023-03-06 07:56:03'),
(27, '110', '(ج)', 'un_correct', NULL, 8, '2023-03-06 07:56:03', '2023-03-06 07:56:03'),
(28, '120', '(د)', 'un_correct', NULL, 8, '2023-03-06 07:56:03', '2023-03-06 07:56:03'),
(29, '200', '(ا)', 'correct', NULL, 10, '2023-03-06 07:56:03', '2023-03-06 07:56:03'),
(30, '300', '(ب)', 'un_correct', NULL, 10, '2023-03-06 07:56:03', '2023-03-06 07:56:03'),
(31, '400', '(ج)', 'un_correct', NULL, 10, '2023-03-06 07:56:03', '2023-03-06 07:56:03'),
(32, '500', '(د)', 'un_correct', NULL, 10, '2023-03-06 07:56:03', '2023-03-06 07:56:03'),
(33, '6.6', '(ا)', 'correct', NULL, 11, '2023-03-06 07:56:03', '2023-03-06 07:56:03'),
(34, '6.8', '(ب)', 'un_correct', NULL, 11, '2023-03-06 07:56:03', '2023-03-06 07:56:03'),
(35, '6.9', '(ج)', 'un_correct', NULL, 11, '2023-03-06 07:56:03', '2023-03-06 07:56:03'),
(36, '6.1', '(د)', 'un_correct', NULL, 11, '2023-03-06 07:56:03', '2023-03-06 07:56:03'),
(37, '90', '(ا)', 'correct', NULL, 9, '2023-03-06 07:56:03', '2023-03-06 07:56:03'),
(38, '36', '(ب)', 'un_correct', NULL, 9, '2023-03-06 07:56:03', '2023-03-06 07:56:03'),
(39, '20', '(ج)', 'un_correct', NULL, 9, '2023-03-06 07:56:03', '2023-03-06 07:56:03'),
(40, '17', '(د)', 'un_correct', NULL, 9, '2023-03-06 07:56:03', '2023-03-06 07:56:03'),
(41, 'صفر', '(ا)', 'correct', NULL, 12, '2023-03-06 07:56:03', '2023-03-06 07:56:03'),
(42, ' محيط الدائرة ', '(ب)', 'un_correct', NULL, 12, '2023-03-06 07:56:03', '2023-03-06 07:56:03'),
(43, 'قطر الدائرة ', '(ج)', 'un_correct', NULL, 12, '2023-03-06 07:56:03', '2023-03-06 07:56:03'),
(44, 'نصف قطر الدائرة', '(د)', 'un_correct', NULL, 12, '2023-03-06 07:56:03', '2023-03-06 07:56:03'),
(45, '360', '(ا)', 'correct', NULL, 13, '2023-03-06 07:56:03', '2023-03-06 07:56:03'),
(46, '0.5', '(ب)', 'un_correct', NULL, 13, '2023-03-06 07:56:03', '2023-03-06 07:56:03'),
(47, ' 2م', '(ج)', 'un_correct', NULL, 13, '2023-03-06 07:56:03', '2023-03-06 07:56:03'),
(48, '3.0', '(د)', 'un_correct', NULL, 13, '2023-03-06 07:56:03', '2023-03-06 07:56:03'),
(49, '0.25', '(ا)', 'correct', NULL, 14, '2023-03-06 07:56:03', '2023-03-06 07:56:03'),
(50, '0.5', '(ب)', 'un_correct', NULL, 14, '2023-03-06 07:56:03', '2023-03-06 07:56:03'),
(51, '2م', '(ج)', 'un_correct', NULL, 14, '2023-03-06 07:56:03', '2023-03-06 07:56:03'),
(52, '7.0', '(د)', 'un_correct', NULL, 14, '2023-03-06 07:56:03', '2023-03-06 07:56:03'),
(53, 'الدينمومتر', '(ا)', 'correct', NULL, 15, '2023-03-06 07:56:03', '2023-03-06 07:56:03'),
(54, 'الترمومتر', '(ب)', 'un_correct', NULL, 15, '2023-03-06 07:56:03', '2023-03-06 07:56:03'),
(55, 'الأميتر', '(ج)', 'un_correct', NULL, 15, '2023-03-06 07:56:03', '2023-03-06 07:56:03'),
(56, 'الآفومتر', '(د)', 'un_correct', NULL, 15, '2023-03-06 07:56:03', '2023-03-06 07:56:03'),
(57, 'تعيين درجة حرارة الجو', '(ا)', 'correct', NULL, 16, '2023-03-06 07:56:03', '2023-03-06 07:56:03'),
(58, 'قياس ارتفاعات الأبراج', '(ب)', 'un_correct', NULL, 16, '2023-03-06 07:56:03', '2023-03-06 07:56:03'),
(59, 'تعيين السرعة الزاوية لجسم.', '(ج)', 'un_correct', NULL, 16, '2023-03-06 07:56:03', '2023-03-06 07:56:03'),
(60, 'تعيين سرعة الكواكب', '(د)', 'un_correct', NULL, 16, '2023-03-06 07:56:03', '2023-03-06 07:56:03');

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

DROP TABLE IF EXISTS `cities`;
CREATE TABLE IF NOT EXISTS `cities` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name_ar` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_en` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `name_ar`, `name_en`, `created_at`, `updated_at`) VALUES
(1, 'القاهره', 'Cairo', '2023-04-18 12:38:45', '2023-04-18 12:38:45');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `comment` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `audio` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `image` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `type` enum('text','audio','file') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `video_part_id` bigint UNSIGNED NOT NULL,
  `video_basic_id` bigint UNSIGNED DEFAULT NULL,
  `video_resource_id` bigint UNSIGNED DEFAULT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `comments_video_part_id_foreign` (`video_part_id`),
  KEY `comments_user_id_foreign` (`user_id`),
  KEY `comments_video_basic_id_foreign` (`video_basic_id`),
  KEY `comments_video_resource_id_foreign` (`video_resource_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `comment`, `audio`, `image`, `type`, `video_part_id`, `video_basic_id`, `video_resource_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'المعادله صعبه جدا', NULL, NULL, 'text', 1, NULL, NULL, 1, '2023-02-26 11:10:00', '2023-03-08 04:13:50'),
(6, 'برضو جزء معادله الحركه مش فاهمها اوي', NULL, NULL, 'text', 1, NULL, NULL, 1, '2023-02-26 10:28:00', '2023-02-26 10:28:00'),
(7, 'برضو جزء معادله الحركه مش فاهمها اوي', NULL, NULL, 'text', 1, NULL, NULL, 1, '2023-02-26 11:11:20', '2023-02-26 11:11:20'),
(8, 'برضو جزء معادله الحركه مش فاهمها اوي', NULL, NULL, 'text', 1, NULL, NULL, 1, '2023-02-26 11:11:23', '2023-02-26 11:11:23'),
(9, 'برضو جزء معادله الحركه مش فاهمها اوي', NULL, NULL, 'text', 1, NULL, NULL, 1, '2023-02-26 11:11:25', '2023-02-26 11:11:25'),
(10, NULL, NULL, '20230308044856.png', 'file', 1, NULL, NULL, 1, '2023-02-26 11:11:27', '2023-03-08 02:48:56'),
(11, 'برضو جزء معادله الحركه مش فاهمها اوي', NULL, NULL, 'text', 1, NULL, NULL, 1, '2023-02-26 11:11:30', '2023-02-26 11:11:30'),
(12, 'برضو جزء معادله الحركه مش فاهمها اوي', NULL, NULL, 'text', 1, NULL, NULL, 1, '2023-02-26 11:11:32', '2023-02-26 11:11:32'),
(13, 'برضو جزء معادله الحركه مش فاهمها اوي', NULL, NULL, 'text', 1, NULL, NULL, 1, '2023-02-26 11:53:48', '2023-02-26 11:53:48'),
(14, NULL, NULL, '20230302071203.jpg', 'file', 1, NULL, NULL, 1, '2023-03-02 05:12:03', '2023-03-02 05:12:03');

-- --------------------------------------------------------

--
-- Table structure for table `comment_replays`
--

DROP TABLE IF EXISTS `comment_replays`;
CREATE TABLE IF NOT EXISTS `comment_replays` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `comment` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `audio` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `image` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `type` enum('text','audio','file') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `student_id` bigint UNSIGNED DEFAULT NULL,
  `teacher_id` bigint UNSIGNED DEFAULT NULL,
  `comment_id` bigint UNSIGNED NOT NULL,
  `user_type` enum('student','teacher') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'student',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `comment_replays_student_id_foreign` (`student_id`),
  KEY `comment_replays_teacher_id_foreign` (`teacher_id`),
  KEY `comment_replays_comment_id_foreign` (`comment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comment_replays`
--

INSERT INTO `comment_replays` (`id`, `comment`, `audio`, `image`, `type`, `student_id`, `teacher_id`, `comment_id`, `user_type`, `created_at`, `updated_at`) VALUES
(1, 'مش فاهم انهي جزئيه بالزبط في المعادلات', NULL, NULL, 'text', NULL, 1, 13, 'teacher', '2023-02-26 11:25:10', '2023-02-26 11:25:10'),
(8, 'تمام انا كده فهمت', NULL, NULL, 'file', 1, NULL, 1, 'student', '2023-03-02 07:33:29', '2023-03-02 07:33:29');

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

DROP TABLE IF EXISTS `countries`;
CREATE TABLE IF NOT EXISTS `countries` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name_ar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'اسم المحافظه بالعربي',
  `name_en` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'اسم المحافظه بالانجليزي',
  `city_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `city_id_cons` (`city_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name_ar`, `name_en`, `city_id`, `created_at`, `updated_at`) VALUES
(1, 'الجيزه', 'Elgeza', 1, '2023-02-23 06:05:55', '2023-02-23 06:05:55'),
(2, 'المنوفيه', 'Elmonofia', 1, '2023-02-23 06:05:55', '2023-02-23 06:05:55'),
(3, 'القاهره', 'Cairo', 1, '2023-02-23 06:05:55', '2023-02-23 06:05:55'),
(4, 'الدقهليه', 'Daqhlia', 1, '2023-02-23 06:05:55', '2023-02-23 06:05:55'),
(5, 'الاسماعليه', 'Esmalia', 1, '2023-02-23 06:05:55', '2023-02-23 06:05:55'),
(6, 'كفر الشيخ', 'Kafr El-Sheikh', 1, '2023-02-23 06:05:55', '2023-02-23 06:05:55');

-- --------------------------------------------------------

--
-- Table structure for table `degrees`
--

DROP TABLE IF EXISTS `degrees`;
CREATE TABLE IF NOT EXISTS `degrees` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `question_id` bigint UNSIGNED NOT NULL,
  `online_exam_id` bigint UNSIGNED DEFAULT NULL,
  `all_exam_id` bigint UNSIGNED DEFAULT NULL,
  `life_exam_id` bigint UNSIGNED DEFAULT NULL,
  `type` enum('text','choice') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `degree` int NOT NULL,
  `status` enum('completed','not_completed') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `degrees_user_id_foreign` (`user_id`),
  KEY `degrees_question_id_foreign` (`question_id`),
  KEY `degrees_online_exam_id_foreign` (`online_exam_id`),
  KEY `degrees_all_exam_id_foreign` (`all_exam_id`),
  KEY `life_exam_cons_2` (`life_exam_id`)
) ENGINE=InnoDB AUTO_INCREMENT=425 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `degrees`
--

INSERT INTO `degrees` (`id`, `user_id`, `question_id`, `online_exam_id`, `all_exam_id`, `life_exam_id`, `type`, `degree`, `status`, `created_at`, `updated_at`) VALUES
(259, 1, 1, 4, NULL, NULL, 'choice', 20, 'completed', '2023-03-18 06:30:11', '2023-03-18 06:30:11'),
(260, 1, 2, 4, NULL, NULL, 'choice', 0, 'completed', '2023-03-18 06:30:11', '2023-03-18 06:30:11'),
(261, 1, 3, 4, NULL, NULL, 'choice', 20, 'completed', '2023-03-18 06:30:11', '2023-03-18 06:30:11'),
(262, 1, 4, 4, NULL, NULL, 'text', 20, 'completed', '2023-03-18 06:30:11', '2023-03-18 06:30:11'),
(267, 2, 1, 4, NULL, NULL, 'choice', 20, 'completed', '2023-03-18 06:42:56', '2023-03-18 06:42:56'),
(268, 2, 2, 4, NULL, NULL, 'choice', 20, 'completed', '2023-03-18 06:42:56', '2023-03-18 06:42:56'),
(269, 2, 3, 4, NULL, NULL, 'choice', 20, 'completed', '2023-03-18 06:42:56', '2023-03-18 06:42:56'),
(270, 2, 4, 4, NULL, NULL, 'text', 10, 'completed', '2023-03-18 06:42:56', '2023-03-18 06:42:56'),
(275, 6, 1, 4, NULL, NULL, 'choice', 20, 'completed', '2023-03-18 10:30:14', '2023-03-18 10:30:14'),
(276, 6, 2, 4, NULL, NULL, 'choice', 0, 'completed', '2023-03-18 10:30:15', '2023-03-18 10:30:15'),
(277, 6, 3, 4, NULL, NULL, 'choice', 20, 'completed', '2023-03-18 10:30:15', '2023-03-18 10:30:15'),
(278, 6, 4, 4, NULL, NULL, 'text', 15, 'completed', '2023-03-18 10:30:15', '2023-03-18 10:30:15'),
(283, 10, 1, 4, NULL, NULL, 'choice', 20, 'completed', '2023-03-18 10:35:14', '2023-03-18 10:35:14'),
(284, 10, 2, 4, NULL, NULL, 'choice', 20, 'completed', '2023-03-18 10:35:14', '2023-03-18 10:35:14'),
(285, 10, 3, 4, NULL, NULL, 'choice', 20, 'completed', '2023-03-18 10:35:14', '2023-03-18 10:35:14'),
(286, 10, 4, 4, NULL, NULL, 'text', 20, 'completed', '2023-03-18 10:35:14', '2023-03-18 10:35:14'),
(291, 9, 1, 4, NULL, NULL, 'choice', 20, 'completed', '2023-03-18 10:40:59', '2023-03-18 10:40:59'),
(292, 9, 2, 4, NULL, NULL, 'choice', 0, 'completed', '2023-03-18 10:40:59', '2023-03-18 10:40:59'),
(293, 9, 3, 4, NULL, NULL, 'choice', 20, 'completed', '2023-03-18 10:40:59', '2023-03-18 10:40:59'),
(294, 9, 4, 4, NULL, NULL, 'text', 7, 'completed', '2023-03-18 10:40:59', '2023-03-18 10:40:59'),
(297, 5, 1, 2, NULL, NULL, 'choice', 20, 'completed', '2023-03-19 05:41:05', '2023-03-19 05:41:05'),
(298, 5, 2, 2, NULL, NULL, 'choice', 20, 'completed', '2023-03-19 05:41:06', '2023-03-19 05:41:06'),
(346, 1, 7, 2, NULL, NULL, 'choice', 30, 'completed', '2023-03-21 09:48:20', '2023-03-21 09:48:20'),
(347, 1, 8, 2, NULL, NULL, 'choice', 30, 'completed', '2023-03-21 09:48:20', '2023-03-21 09:48:20'),
(348, 1, 9, 2, NULL, NULL, 'choice', 40, 'completed', '2023-03-21 09:48:20', '2023-03-21 09:48:20'),
(384, 1, 12, NULL, NULL, 1, 'choice', 40, 'completed', '2023-03-26 08:30:19', '2023-03-26 08:30:19'),
(385, 1, 13, NULL, NULL, 1, 'choice', 40, 'completed', '2023-03-26 08:30:39', '2023-03-26 08:30:39'),
(386, 1, 14, NULL, NULL, 1, 'choice', 40, 'completed', '2023-03-26 08:30:52', '2023-03-26 08:30:52'),
(387, 1, 15, NULL, NULL, 1, 'choice', 40, 'completed', '2023-03-26 08:31:10', '2023-03-26 08:31:10'),
(388, 1, 16, NULL, NULL, 1, 'choice', 40, 'completed', '2023-03-26 08:31:50', '2023-03-26 08:31:50'),
(400, 9, 12, NULL, NULL, 1, 'choice', 40, 'completed', '2023-03-27 12:33:34', '2023-03-27 12:33:34'),
(401, 9, 13, NULL, NULL, 1, 'choice', 40, 'completed', '2023-03-27 12:33:49', '2023-03-27 12:33:49'),
(402, 9, 14, NULL, NULL, 1, 'choice', 40, 'completed', '2023-03-27 12:34:06', '2023-03-27 12:34:06'),
(403, 9, 15, NULL, NULL, 1, 'choice', 0, 'completed', '2023-03-27 12:34:38', '2023-03-27 12:34:38'),
(404, 9, 16, NULL, NULL, 1, 'choice', 0, 'completed', '2023-03-27 12:34:52', '2023-03-27 12:34:52'),
(410, 13, 12, NULL, NULL, 1, 'choice', 40, 'completed', '2023-03-28 09:26:19', '2023-03-28 09:26:19'),
(411, 13, 13, NULL, NULL, 1, 'choice', 40, 'completed', '2023-03-28 09:26:50', '2023-03-28 09:26:50'),
(412, 13, 14, NULL, NULL, 1, 'choice', 40, 'completed', '2023-03-28 09:27:22', '2023-03-28 09:27:22'),
(413, 13, 15, NULL, NULL, 1, 'choice', 40, 'completed', '2023-03-28 09:27:48', '2023-03-28 09:27:48'),
(414, 13, 16, NULL, NULL, 1, 'choice', 0, 'completed', '2023-03-28 09:28:00', '2023-03-28 09:28:00'),
(420, 4, 12, NULL, NULL, 1, 'choice', 40, 'completed', '2023-03-28 11:34:19', '2023-03-28 11:34:19'),
(421, 4, 13, NULL, NULL, 1, 'choice', 40, 'completed', '2023-03-28 11:34:44', '2023-03-28 11:34:44'),
(422, 4, 14, NULL, NULL, 1, 'choice', 40, 'completed', '2023-03-28 11:35:10', '2023-03-28 11:35:10'),
(423, 4, 15, NULL, NULL, 1, 'choice', 40, 'completed', '2023-03-28 11:35:21', '2023-03-28 11:35:21'),
(424, 4, 16, NULL, NULL, 1, 'choice', 0, 'completed', '2023-03-28 11:35:37', '2023-03-28 11:35:37');

-- --------------------------------------------------------

--
-- Table structure for table `exam_degree_depends`
--

DROP TABLE IF EXISTS `exam_degree_depends`;
CREATE TABLE IF NOT EXISTS `exam_degree_depends` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `online_exam_id` bigint UNSIGNED DEFAULT NULL,
  `all_exam_id` bigint UNSIGNED DEFAULT NULL,
  `life_exam_id` bigint UNSIGNED DEFAULT NULL,
  `full_degree` int NOT NULL,
  `exam_depends` enum('yes','no') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `exam_degree_depends_user_id_foreign` (`user_id`),
  KEY `exam_degree_depends_online_exam_id_foreign` (`online_exam_id`),
  KEY `exam_degree_depends_all_exam_id_foreign` (`all_exam_id`),
  KEY `life_exam_cons_5` (`life_exam_id`)
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `exam_degree_depends`
--

INSERT INTO `exam_degree_depends` (`id`, `user_id`, `online_exam_id`, `all_exam_id`, `life_exam_id`, `full_degree`, `exam_depends`, `created_at`, `updated_at`) VALUES
(27, 1, 4, NULL, NULL, 60, 'no', '2023-03-18 06:29:26', '2023-03-18 06:29:26'),
(30, 2, 4, NULL, NULL, 70, 'yes', '2023-03-18 06:42:56', '2023-03-18 06:42:56'),
(31, 1, 4, NULL, NULL, 80, 'yes', '2023-03-18 06:42:56', '2023-04-11 10:51:13'),
(32, 2, 4, NULL, NULL, 40, 'no', '2023-03-18 06:42:56', '2023-03-18 06:42:56'),
(33, 6, 4, NULL, NULL, 75, 'yes', '2023-03-18 10:29:57', '2023-03-18 10:29:57'),
(34, 6, 4, NULL, NULL, 40, 'no', '2023-03-18 10:30:15', '2023-03-18 10:30:15'),
(35, 10, 4, NULL, NULL, 40, 'no', '2023-03-18 10:34:57', '2023-03-18 10:34:57'),
(36, 10, 4, NULL, NULL, 80, 'yes', '2023-03-18 10:35:14', '2023-03-18 10:35:14'),
(37, 9, 4, NULL, NULL, 67, 'yes', '2023-03-18 10:40:48', '2023-03-18 10:40:48'),
(38, 9, 4, NULL, NULL, 40, 'no', '2023-03-18 10:40:59', '2023-03-18 10:40:59'),
(39, 5, 2, NULL, NULL, 0, 'no', '2023-03-18 11:56:15', '2023-03-18 11:56:15'),
(40, 5, 2, NULL, NULL, 40, 'yes', '2023-03-19 05:41:06', '2023-03-19 05:41:06'),
(55, 1, 2, NULL, NULL, 40, 'no', '2023-03-21 09:47:23', '2023-03-21 09:47:23'),
(56, 1, 2, NULL, NULL, 100, 'yes', '2023-03-21 09:48:21', '2023-03-21 09:48:21'),
(72, 1, NULL, NULL, 1, 200, 'yes', '2023-03-26 08:30:19', '2023-03-26 08:31:50'),
(75, 9, NULL, NULL, 1, 120, 'no', '2023-03-27 12:33:34', '2023-03-27 12:34:06'),
(77, 13, NULL, NULL, 1, 160, 'yes', '2023-03-28 09:26:19', '2023-03-28 09:28:01'),
(79, 4, NULL, NULL, 1, 160, 'yes', '2023-03-28 11:34:19', '2023-03-28 11:35:37');

-- --------------------------------------------------------

--
-- Table structure for table `exam_instructions`
--

DROP TABLE IF EXISTS `exam_instructions`;
CREATE TABLE IF NOT EXISTS `exam_instructions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `instruction` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `number_of_question` int NOT NULL,
  `all_exam_id` bigint UNSIGNED DEFAULT NULL,
  `online_exam_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `online` (`all_exam_id`),
  KEY `full_exam` (`online_exam_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `exam_instructions`
--

INSERT INTO `exam_instructions` (`id`, `instruction`, `number_of_question`, `all_exam_id`, `online_exam_id`, `created_at`, `updated_at`) VALUES
(1, '1- بامكان الطالب الضغط على تاجيل السؤال\n            ليظهر بلون مختلف ويمكن الرجوع للحل مرة\n            اخرى .', 3, 1, NULL, '2023-02-23 06:05:57', '2023-02-23 06:05:57'),
(2, '1- بامكان الطالب الضغط على تاجيل السؤال\r\n            ليظهر بلون مختلف ويمكن الرجوع للحل مرة\r\n            اخرى .', 3, 2, NULL, '2023-02-23 06:05:57', '2023-02-23 06:05:57'),
(3, '1- بامكان الطالب الضغط على تاجيل السؤال\r\n            ليظهر بلون مختلف ويمكن الرجوع للحل مرة\r\n            اخرى .', 3, NULL, 2, '2023-02-23 06:05:57', '2023-02-23 06:05:57'),
(5, '1- بامكان الطالب الضغط على تاجيل السؤال\r\n            ليظهر بلون مختلف ويمكن الرجوع للحل مرة\r\n            اخرى .', 3, NULL, 4, '2023-02-23 06:05:57', '2023-02-23 06:05:57'),
(6, '1- بامكان الطالب الضغط على تاجيل السؤال\r\n            ليظهر بلون مختلف ويمكن الرجوع للحل مرة\r\n            اخرى .', 3, 3, NULL, '2023-02-23 06:05:57', '2023-02-23 06:05:57'),
(7, '1- بامكان الطالب الضغط على تاجيل السؤال\r\n            ليظهر بلون مختلف ويمكن الرجوع للحل مرة\r\n            اخرى .', 3, 4, NULL, '2023-02-23 06:05:57', '2023-02-23 06:05:57'),
(8, '1- بامكان الطالب الضغط على تاجيل السؤال\r\n            ليظهر بلون مختلف ويمكن الرجوع للحل مرة\r\n            اخرى .', 3, 5, NULL, '2023-02-23 06:05:57', '2023-02-23 06:05:57'),
(9, '1- بامكان الطالب الضغط على تاجيل السؤال\r\n            ليظهر بلون مختلف ويمكن الرجوع للحل مرة\r\n            اخرى .', 3, 6, NULL, '2023-02-23 06:05:57', '2023-02-23 06:05:57'),
(10, '1- بامكان الطالب الضغط على تاجيل السؤال\r\n            ليظهر بلون مختلف ويمكن الرجوع للحل مرة\r\n            اخرى .', 3, 7, NULL, '2023-02-23 06:05:57', '2023-02-23 06:05:57'),
(11, '1- بامكان الطالب الضغط على تاجيل السؤال\r\n            ليظهر بلون مختلف ويمكن الرجوع للحل مرة\r\n            اخرى .', 3, 8, NULL, '2023-02-23 06:05:57', '2023-02-23 06:05:57'),
(12, '1- بامكان الطالب الضغط على تاجيل السؤال\r\n            ليظهر بلون مختلف ويمكن الرجوع للحل مرة\r\n            اخرى .', 3, NULL, 1, '2023-02-23 06:05:57', '2023-02-23 06:05:57');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `guides`
--

DROP TABLE IF EXISTS `guides`;
CREATE TABLE IF NOT EXISTS `guides` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `title_ar` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_en` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_ar` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `description_en` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `from_id` bigint UNSIGNED DEFAULT NULL,
  `file` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `icon` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `season_id` bigint UNSIGNED DEFAULT NULL,
  `term_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `guides_season_id_foreign` (`season_id`),
  KEY `guides_term_id_foreign` (`term_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `guides`
--

INSERT INTO `guides` (`id`, `title_ar`, `title_en`, `description_ar`, `description_en`, `from_id`, `file`, `icon`, `season_id`, `term_id`, `created_at`, `updated_at`) VALUES
(1, 'حل دورات', 'Solve cycles', 'سلسة صفحات من اهم الاسئلة مع الحل', 'A series of pages of the most important questions with the solution', NULL, NULL, NULL, 1, 1, '2023-03-15 07:00:01', '2023-03-15 07:00:01'),
(2, 'حل القسم الاول', 'Solve the first section', 'مقرر محلول بأهم الاسئلة1', 'Solved decision with the most important questions 1', 1, 'Resume.pdf', NULL, NULL, NULL, '2023-03-15 07:08:07', '2023-03-15 07:08:07'),
(3, 'حل القسم الثاني', 'The solution of the second section', 'مقرر بأهم الاسئلة 2', 'Decided on the most important questions 2', 1, 'Resume.pdf', NULL, NULL, NULL, '2023-03-15 07:08:46', '2023-03-15 07:08:46'),
(4, 'اسئلة منوعة', 'Miscellaneous questions', 'اسئلة مفيدة للطالب', 'Useful questions for the student', NULL, NULL, NULL, 2, 2, '2023-03-15 07:09:30', '2023-03-15 07:09:30'),
(5, 'حل الاسئلة المنوعة', 'Solve interesting questions', 'العديد من الاسئلة', 'Many questions', 4, 'Resume.pdf', NULL, NULL, NULL, '2023-03-15 07:10:14', '2023-03-15 07:10:14');

-- --------------------------------------------------------

--
-- Table structure for table `lessons`
--

DROP TABLE IF EXISTS `lessons`;
CREATE TABLE IF NOT EXISTS `lessons` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `background_color` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_ar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_en` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_ar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_en` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject_class_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lessons_subject_class_id_foreign` (`subject_class_id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lessons`
--

INSERT INTO `lessons` (`id`, `background_color`, `title_ar`, `title_en`, `name_ar`, `name_en`, `note`, `subject_class_id`, `created_at`, `updated_at`) VALUES
(1, '#FFEAD7', 'الدرس الاول', 'lesson one', 'تعريفات وحدات النظام الدولي', 'Definitions of SI units', 'تعريفات وحدات النظام الدولي', 1, '2023-02-23 06:05:56', '2023-02-23 06:05:56'),
(2, '#D7EAF9', 'الدرس التاني', 'lesson two', 'وحدات قياس الكميات', 'Quantitative units', 'وحدات قياس الكميات', 1, '2023-02-23 06:05:56', '2023-02-23 06:05:56'),
(3, '#E3D2FE', 'الدرس التالت', 'lesson three', 'التحليل البُعدي', 'Dimensional analysis', 'التحليل البُعدي', 1, '2023-02-23 06:05:56', '2023-02-23 06:05:56'),
(4, '#FFEAD7', 'الدرس الرابع', 'lesson four', 'تمثيل القِيَم الكبيرة للكميات الفيزيائية', 'Representing large values of physical quantities', 'تمثيل القِيَم الكبيرة للكميات الفيزيائية', 1, '2023-02-23 06:05:56', '2023-02-23 06:05:56'),
(5, '#FFEAD7', 'الدرس الاول', 'lesson one', 'تمثيل القِيَم الصغيرة للكميات الفيزيائية', 'Representation of small values of physical quantities', 'تمثيل القِيَم الصغيرة للكميات الفيزيائية', 2, '2023-02-23 06:05:56', '2023-02-23 06:05:56'),
(6, '#D7EAF9', 'الدرس التاني', 'lesson two', 'أدوات القياس', 'Measurement tools', 'أدوات القياس', 2, '2023-02-23 06:05:56', '2023-02-23 06:05:56'),
(7, '#E3D2FE', 'الدرس التالت', 'lesson three', 'الشكُّ في القياس ودقة فصْل أداة القياس', 'Measurement tools', 'الشكُّ في القياس ودقة فصْل أداة القياس', 2, '2023-02-23 06:05:56', '2023-02-23 06:05:56'),
(8, '#D7EAF9', 'الدرس الرابع', 'lesson four', 'دمج قيم الشك', 'Incorporate uncertainty values', 'دمج قيم الشك', 2, '2023-02-23 06:05:56', '2023-02-23 06:05:56'),
(9, '#E3D2FE', 'الدرس الخامس', 'lesson five', 'قياس الأطوال', 'Measure lengths', 'قياس الأطوال', 2, '2023-02-23 06:05:56', '2023-02-23 06:05:56'),
(10, '#D7EAF9', 'الدرس السادس', 'lesson six', 'قياس درجات الحرارة', 'Measure temperatures', 'قياس درجات الحرارة', 2, '2023-02-23 06:05:56', '2023-02-23 06:05:56'),
(11, '#FFEAD7', 'الدرس الاول', 'lesson one', 'ضبط القياس ودقته', 'Measurement and accuracy', 'ضبط القياس ودقته', 3, '2023-02-23 06:05:56', '2023-02-23 06:05:56'),
(12, '#D7EAF9', 'الدرس التاني', 'lesson two', 'الخطأ في القياس', 'measurement error', 'الخطأ في القياس', 3, '2023-02-23 06:05:56', '2023-02-23 06:05:56'),
(13, '#E3D2FE', 'الدرس التالت', 'lesson three', 'الكميات القياسية والمتجهة', 'scalar and vector quantities', 'الكميات القياسية والمتجهة', 3, '2023-02-23 06:05:56', '2023-02-23 06:05:56'),
(14, '#FFEAD7', 'الدرس الرابع', 'lesson four', 'الرسم بمقياس رسم', 'Drawing to scale', 'الرسم بمقياس رسم', 3, '2023-02-23 06:05:56', '2023-02-23 06:05:56'),
(15, '#E3D2FE', 'الدرس الخامس', 'lesson five', 'إيجاد مركِّبات متجه', 'Find the components of a vector', 'إيجاد مركِّبات متجه', 3, '2023-02-23 06:05:56', '2023-02-23 06:05:56'),
(16, '#FFEAD7', 'الدرس الاول', 'lesson one', 'جمع المتجهات', 'Vector collection', 'جمع المتجهات', 4, '2023-02-23 06:05:56', '2023-02-23 06:05:56'),
(17, '#D7EAF9', 'الدرس التاني', 'lesson two', 'طرح المتجهات', 'Subtract vectors', 'طرح المتجهات', 4, '2023-02-23 06:05:56', '2023-02-23 06:05:56'),
(18, '#E3D2FE', 'الدرس التالت', 'lesson three', 'الضرب القياسي لمتجهين', 'The scalar product of two vectors', 'الضرب القياسي لمتجهين', 4, '2023-02-23 06:05:56', '2023-02-23 06:05:56'),
(19, '#FFEAD7', 'الدرس الرابع', 'lesson four', 'الضرب الاتجاهي لمتجهين', 'Cross product of two vectors', 'الضرب الاتجاهي لمتجهين', 4, '2023-02-23 06:05:56', '2023-02-23 06:05:56'),
(20, '#FFEAD7', 'الدرس الخامس', 'lesson five', 'المسافة والإزاحة', 'distance and offset', 'المسافة والإزاحة', 4, '2023-02-23 06:05:56', '2023-02-23 06:05:56'),
(21, '#E3D2FE', 'الدرس السادس', 'lesson six', 'السرعة', 'the speed', 'السرعة', 4, '2023-02-23 06:05:56', '2023-02-23 06:05:56'),
(22, '#FFEAD7', 'الدرس الاول', 'lesson one', ' التمثيل البياني للسرعة', 'Graph of speed', ' التمثيل البياني للسرعة', 5, '2023-02-23 06:05:56', '2023-02-23 06:05:56'),
(23, '#D7EAF9', 'الدرس التاني', 'lesson two', 'وحدات السرعة', 'speed units', 'وحدات السرعة', 5, '2023-02-23 06:05:56', '2023-02-23 06:05:56'),
(24, '#E3D2FE', 'الدرس التالت', 'lesson three', 'السرعة المتجهة', 'velocity', 'السرعة المتجهة', 5, '2023-02-23 06:05:56', '2023-02-23 06:05:56'),
(25, '#FFEAD7', 'الدرس الرابع', 'lesson four', 'التمثيل البياني للسرعة المتجهة', 'Graph of velocity', 'التمثيل البياني للسرعة المتجهة', 5, '2023-02-23 06:05:56', '2023-02-23 06:05:56'),
(26, '#E3D2FE', 'الدرس الخامس', 'lesson five', 'السرعة اللحظية', 'instantaneous speed', 'السرعة اللحظية', 5, '2023-02-23 06:05:56', '2023-02-23 06:05:56'),
(27, '#E3D2FE', 'الدرس السادس', 'lesson six', 'الحركة بعجلة خلال الزمن', 'Acceleration through time', 'الحركة بعجلة خلال الزمن', 5, '2023-02-23 06:05:56', '2023-02-23 06:05:56'),
(28, '#E3D2FE', 'الدرس السابع', 'lesson seven', 'الحركة بعجلة خلال المسافة والزمن', 'Acceleration through distance and time', 'الحركة بعجلة خلال المسافة والزمن', 5, '2023-02-23 06:05:56', '2023-02-23 06:05:56'),
(29, '#FFEAD7', 'الدرس الاول', 'lesson one', 'الحركة بعجلة لمسافة معيَّنة', 'Acceleration for a certain distance', 'الحركة بعجلة لمسافة معيَّنة', 6, '2023-02-23 06:05:56', '2023-02-23 06:05:56'),
(30, '#D7EAF9', 'الدرس التاني', 'lesson two', 'زمن الاستجابة', 'response time', 'زمن الاستجابة', 6, '2023-02-23 06:05:56', '2023-02-23 06:05:56'),
(31, '#E3D2FE', 'الدرس التالت', 'lesson three', 'المقذوفات', 'ballistics', 'المقذوفات', 6, '2023-02-23 06:05:56', '2023-02-23 06:05:56'),
(32, '#FFEAD7', 'الدرس الرابع', 'lesson four', 'حركة المقذوفات', 'Projectile movement', 'حركة المقذوفات', 6, '2023-02-23 06:05:56', '2023-02-23 06:05:56'),
(33, '#E3D2FE', 'الدرس الخامس', 'lesson five', 'قانون نيوتن الأول للحركة', 'Newton\'s first law of motion', 'قانون نيوتن الأول للحركة', 6, '2023-02-23 06:05:56', '2023-02-23 06:05:56');

-- --------------------------------------------------------

--
-- Table structure for table `life_exams`
--

DROP TABLE IF EXISTS `life_exams`;
CREATE TABLE IF NOT EXISTS `life_exams` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name_ar` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_en` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_exam` date NOT NULL,
  `time_start` time NOT NULL,
  `time_end` time NOT NULL,
  `quiz_minute` int NOT NULL,
  `trying` int NOT NULL DEFAULT '1',
  `degree` int NOT NULL,
  `season_id` bigint UNSIGNED NOT NULL,
  `term_id` bigint UNSIGNED DEFAULT NULL,
  `note` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `life_exams_season_id_foreign` (`season_id`),
  KEY `life_exams_term_id_foreign` (`term_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `life_exams`
--

INSERT INTO `life_exams` (`id`, `name_ar`, `name_en`, `date_exam`, `time_start`, `time_end`, `quiz_minute`, `trying`, `degree`, `season_id`, `term_id`, `note`, `created_at`, `updated_at`) VALUES
(1, 'امتحان لايف علي الفصل الاول والتاني من الحلركه الجزئيه', 'Live exam on chapters one and two of molecular motion', '2023-04-09', '16:10:00', '18:10:00', 60, 1, 200, 1, 1, 'يجب الانتظام بالوقت المحدد للامتحان لانه لا يوجد غير محاوله واحده', '2023-03-21 12:10:46', '2023-03-21 12:10:46');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=100 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_10_075055_create_seasons_table', 1),
(2, '2014_10_11_114021_create_countries_table', 1),
(3, '2014_10_12_000000_create_users_table', 1),
(4, '2014_10_12_100000_create_password_resets_table', 1),
(5, '2019_08_19_000000_create_failed_jobs_table', 1),
(6, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(7, '2022_03_20_123415_create_admins_table', 1),
(8, '2023_02_18_081046_create_terms_table', 1),
(9, '2023_02_20_080842_create_subject_classes_table', 1),
(10, '2023_02_20_080947_create_lessons_table', 1),
(11, '2023_02_21_081951_create_settings_table', 1),
(12, '2023_02_21_082008_create_phone_communications_table', 1),
(13, '2023_02_21_124257_add_type_type_to_lessons_table', 1),
(14, '2023_02_21_132800_create_all_exams_table', 1),
(15, '2023_02_21_133320_create_video_parts_table', 1),
(16, '2023_02_27_133653_create_exam_instructions_table', 1),
(17, '2023_04_09_135353_create_comments_table', 1),
(18, '2023_04_09_140554_create_comment_replays_table', 1),
(19, '2023_02_22_075823_add_season_and_term_to_all_exams_table', 1),
(21, '2023_02_22_111826_create_online_exams_table', 1),
(22, '2023_02_22_113053_create_phone_tokens_table', 1),
(23, '2023_02_22_113136_create_questions_table', 1),
(24, '2023_02_22_114203_create_answers_table', 1),
(26, '2023_02_22_115334_create_online_exam_users_table', 1),
(27, '2023_02_22_131743_create_online_exam_questions_table', 1),
(29, '2023_02_22_132451_create_sections_table', 1),
(30, '2023_02_22_132923_create_papel_sheet_exams_table', 1),
(31, '2023_02_22_133343_create_papel_sheet_exam_times_table', 1),
(32, '2023_02_22_133816_create_papel_sheet_exam_users_table', 1),
(33, '2023_02_22_134512_create_video_watches_table', 1),
(36, '2023_02_27_084130_create_suggestions_table', 3),
(40, '2023_02_27_111823_create_notifications_table', 4),
(41, '2023_03_05_064915_create_monthly_plans_table', 5),
(43, '2023_03_12_092852_create_text_exam_users_table', 6),
(45, '2023_03_12_092936_create_degrees_table', 7),
(47, '2023_03_13_131011_create_guides_table', 8),
(48, '2023_03_15_064020_create_timers_table', 9),
(49, '2023_03_15_105858_create_papel_sheet_exam_degrees_table', 10),
(50, '2023_03_16_080906_create_exam_degree_depends_table', 11),
(51, '2023_03_18_074700_create_ads_table', 12),
(52, '2023_03_20_083007_create_open_lessons_table', 12),
(53, '2023_03_13_073949_create_subscribes_table', 13),
(54, '2023_02_21_110928_create_life_exams_table', 14),
(55, '2023_03_20_082022_create_user_subscribes_table', 14),
(56, '2023_03_20_082902_create_payments_table', 14),
(57, '2023_02_22_132300_create_sliders_table', 15),
(58, '2023_04_03_100553_create_video_rates_table', 16),
(59, '2023_04_03_104239_add_season_id_and_term_id_to_monthly_plans_table', 17),
(61, '2023_04_03_113820_add_year_and_month_to_video_parts_table', 17),
(62, '2023_04_03_115836_add_year_to_table_subscribes', 18),
(63, '2023_04_03_133232_add_year_to_user_subscribes_table', 19),
(64, '2023_04_05_091607_create_user_screen_shots_table', 20),
(65, '2023_04_05_092901_add_login_status_to_users_table', 20),
(66, '2023_04_05_131036_add_image_and_audio_to_suggestions_table', 21),
(67, '2023_04_05_135618_add_user_id_to_notifications_table', 22),
(68, '2023_04_04_145819_create_on_boardings_table', 23),
(82, '2023_04_08_133041_create_video_resources_table', 24),
(83, '2023_04_09_130005_create_video_basics_table', 24),
(84, '2023_04_09_132241_create_video_basic_pdf_uploads_table', 24),
(85, '2023_04_09_133931_create_video_favorites_table', 24),
(86, '2023_04_09_141004_add_video_basic_id_and_video_resource_id_to_comments_table', 24),
(88, '2023_04_10_120509_add_degree_and_degree_status_to_online_exam_users_table', 26),
(89, '2023_04_10_120801_add_degree_and_degree_status_to_text_exam_users_table', 26),
(90, '2023_04_13_120754_add_videos_resource_active_to_settings_table', 27),
(91, '2023_04_16_095248_add_background_color_to_subject_classes_table', 28),
(92, '2023_04_16_095800_add_background_color_to_video_basics_table', 28),
(93, '2023_04_16_095906_add_background_color_to_video_resources_table', 28),
(95, '2023_04_16_115949_add_image_to_video_resources_table', 30),
(96, '2023_04_16_142253_add_type_and_pdf_to_video_resources_table', 31),
(97, '2023_04_17_093810_create_reports_table', 32),
(98, '2023_04_17_104842_add_twitter_link_and_website_link_and_instgram_link_to_settings_table', 33),
(99, '2014_10_10_142457_create_cities_table', 34);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
CREATE TABLE IF NOT EXISTS `model_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
CREATE TABLE IF NOT EXISTS `model_has_roles` (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\Admin', 1);

-- --------------------------------------------------------

--
-- Table structure for table `monthly_plans`
--

DROP TABLE IF EXISTS `monthly_plans`;
CREATE TABLE IF NOT EXISTS `monthly_plans` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `background_color` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_ar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_en` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_ar` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_en` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `start` date NOT NULL,
  `end` date NOT NULL,
  `season_id` bigint UNSIGNED DEFAULT NULL,
  `term_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `monthly_plans_season_id_foreign` (`season_id`),
  KEY `monthly_plans_term_id_foreign` (`term_id`)
) ENGINE=InnoDB AUTO_INCREMENT=132 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `monthly_plans`
--

INSERT INTO `monthly_plans` (`id`, `background_color`, `title_ar`, `title_en`, `description_ar`, `description_en`, `start`, `end`, `season_id`, `term_id`, `created_at`, `updated_at`) VALUES
(59, '#FFEAD7', 'مراجعه الفصل الاول', 'Review the first chapter', 'يجب مشاهده الدرس الاول والدرس التاني', 'you must watch lesson one and lesson two', '2023-04-19', '2023-04-20', 1, 1, '2023-04-19 09:49:44', '2023-04-19 09:49:44'),
(60, '#D7EAF9', 'مراجعه الفصل الاول', 'Review the first chapter', 'يجب مشاهده الدرس الاول والدرس التاني', 'you must watch lesson one and lesson two', '2023-04-19', '2023-04-20', 1, 1, '2023-04-19 09:49:44', '2023-04-19 09:49:44'),
(61, '#E3D2FE', 'مراجعه الفصل الاول', 'Review the first chapter', 'يجب مشاهده الدرس الاول والدرس التاني', 'you must watch lesson one and lesson two', '2023-04-19', '2023-04-20', 1, 1, '2023-04-19 09:49:45', '2023-04-19 09:49:45'),
(62, '#D7EAF9', 'مراجعه الفصل الاول', 'Review the first chapter', 'يجب مشاهده الدرس الاول والدرس التاني', 'you must watch lesson one and lesson two', '2023-04-22', '2023-04-23', 1, 1, '2023-04-19 09:49:45', '2023-04-19 09:49:45'),
(63, '#FFEAD7', 'مراجعه الفصل الاول', 'Review the first chapter', 'يجب مشاهده الدرس الاول والدرس التاني', 'you must watch lesson one and lesson two', '2023-04-23', '2023-04-24', 1, 1, '2023-04-19 09:49:45', '2023-04-19 09:49:45'),
(64, '#E3D2FE', 'مراجعه الفصل الاول', 'Review the first chapter', 'يجب مشاهده الدرس الاول والدرس التاني', 'you must watch lesson one and lesson two', '2023-04-24', '2023-04-25', 1, 1, '2023-04-19 09:49:45', '2023-04-19 09:49:45'),
(65, '#FFEAD7', 'مراجعه الفصل الاول', 'Review the first chapter', 'يجب مشاهده الدرس الاول والدرس التاني', 'you must watch lesson one and lesson two', '2023-04-25', '2023-04-26', 1, 1, '2023-04-19 09:49:45', '2023-04-19 09:49:45'),
(66, '#FFEAD7', 'مراجعه الفصل الاول', 'Review the first chapter', 'يجب مشاهده الدرس الاول والدرس التاني', 'you must watch lesson one and lesson two', '2023-04-26', '2023-04-27', 1, 1, '2023-04-19 09:49:45', '2023-04-19 09:49:45'),
(67, '#FFEAD7', 'مراجعه الفصل الاول', 'Review the first chapter', 'يجب مشاهده الدرس الاول والدرس التاني', 'you must watch lesson one and lesson two', '2023-04-27', '2023-04-28', 1, 1, '2023-04-19 09:49:45', '2023-04-19 09:49:45'),
(68, '#FFEAD7', 'مراجعه الفصل الاول', 'Review the first chapter', 'يجب مشاهده الدرس الاول والدرس التاني', 'you must watch lesson one and lesson two', '2023-04-28', '2023-04-29', 1, 1, '2023-04-19 09:49:45', '2023-04-19 09:49:45'),
(69, '#FFEAD7', 'مراجعه الفصل الاول', 'Review the first chapter', 'يجب مشاهده الدرس الاول والدرس التاني', 'you must watch lesson one and lesson two', '2023-04-29', '2023-04-30', 1, 1, '2023-04-19 09:49:45', '2023-04-19 09:49:45'),
(70, '#FFEAD7', 'مراجعه الفصل الاول', 'Review the first chapter', 'يجب مشاهده الدرس الاول والدرس التاني', 'you must watch lesson one and lesson two', '2023-04-30', '2023-05-01', 1, 1, '2023-04-19 09:49:45', '2023-04-19 09:49:45'),
(71, '#FFEAD7', 'مراجعه الفصل الاول', 'Review the first chapter', 'يجب مشاهده الدرس الاول والدرس التاني', 'you must watch lesson one and lesson two', '2023-05-01', '2023-05-02', 1, 1, '2023-04-19 09:49:45', '2023-04-19 09:49:45'),
(72, '#FFEAD7', 'مراجعه الفصل الاول', 'Review the first chapter', 'يجب مشاهده الدرس الاول والدرس التاني', 'you must watch lesson one and lesson two', '2023-05-02', '2023-05-03', 1, 1, '2023-04-19 09:49:45', '2023-04-19 09:49:45'),
(73, '#FFEAD7', 'مراجعه الفصل الاول', 'Review the first chapter', 'يجب مشاهده الدرس الاول والدرس التاني', 'you must watch lesson one and lesson two', '2023-05-03', '2023-05-04', 1, 1, '2023-04-19 09:49:46', '2023-04-19 09:49:46'),
(74, '#FFEAD7', 'مراجعه الفصل الاول', 'Review the first chapter', 'يجب مشاهده الدرس الاول والدرس التاني', 'you must watch lesson one and lesson two', '2023-05-04', '2023-05-05', 1, 1, '2023-04-19 09:49:46', '2023-04-19 09:49:46'),
(75, '#FFEAD7', 'مراجعه الفصل الاول', 'Review the first chapter', 'يجب مشاهده الدرس الاول والدرس التاني', 'you must watch lesson one and lesson two', '2023-05-05', '2023-05-06', 1, 1, '2023-04-19 09:49:46', '2023-04-19 09:49:46'),
(76, '#FFEAD7', 'مراجعه الفصل الاول', 'Review the first chapter', 'يجب مشاهده الدرس الاول والدرس التاني', 'you must watch lesson one and lesson two', '2023-05-06', '2023-05-07', 1, 1, '2023-04-19 09:49:46', '2023-04-19 09:49:46'),
(77, '#FFEAD7', 'مراجعه الفصل الاول', 'Review the first chapter', 'يجب مشاهده الدرس الاول والدرس التاني', 'you must watch lesson one and lesson two', '2023-05-07', '2023-05-08', 1, 1, '2023-04-19 09:49:46', '2023-04-19 09:49:46'),
(78, '#FFEAD7', 'مراجعه الفصل الاول', 'Review the first chapter', 'يجب مشاهده الدرس الاول والدرس التاني', 'you must watch lesson one and lesson two', '2023-05-08', '2023-05-09', 1, 1, '2023-04-19 09:49:46', '2023-04-19 09:49:46'),
(79, '#FFEAD7', 'مراجعه الفصل الاول', 'Review the first chapter', 'يجب مشاهده الدرس الاول والدرس التاني', 'you must watch lesson one and lesson two', '2023-05-09', '2023-05-10', 1, 1, '2023-04-19 09:49:46', '2023-04-19 09:49:46'),
(80, '#FFEAD7', 'مراجعه الفصل الاول', 'Review the first chapter', 'يجب مشاهده الدرس الاول والدرس التاني', 'you must watch lesson one and lesson two', '2023-05-10', '2023-05-11', 1, 1, '2023-04-19 09:49:46', '2023-04-19 09:49:46'),
(81, '#FFEAD7', 'مراجعه الفصل الاول', 'Review the first chapter', 'يجب مشاهده الدرس الاول والدرس التاني', 'you must watch lesson one and lesson two', '2023-05-11', '2023-05-12', 1, 1, '2023-04-19 09:49:46', '2023-04-19 09:49:46'),
(82, '#FFEAD7', 'مراجعه الفصل الاول', 'Review the first chapter', 'يجب مشاهده الدرس الاول والدرس التاني', 'you must watch lesson one and lesson two', '2023-05-12', '2023-05-13', 1, 1, '2023-04-19 09:49:46', '2023-04-19 09:49:46'),
(83, '#FFEAD7', 'مراجعه الفصل الاول', 'Review the first chapter', 'يجب مشاهده الدرس الاول والدرس التاني', 'you must watch lesson one and lesson two', '2023-05-13', '2023-05-14', 1, 1, '2023-04-19 09:49:46', '2023-04-19 09:49:46'),
(84, '#FFEAD7', 'مراجعه الفصل الاول', 'Review the first chapter', 'يجب مشاهده الدرس الاول والدرس التاني', 'you must watch lesson one and lesson two', '2023-05-14', '2023-05-15', 1, 1, '2023-04-19 09:49:46', '2023-04-19 09:49:46'),
(85, '#FFEAD7', 'مراجعه الفصل الاول', 'Review the first chapter', 'يجب مشاهده الدرس الاول والدرس التاني', 'you must watch lesson one and lesson two', '2023-05-15', '2023-05-16', 1, 1, '2023-04-19 09:49:46', '2023-04-19 09:49:46'),
(86, '#FFEAD7', 'مراجعه الفصل الاول', 'Review the first chapter', 'يجب مشاهده الدرس الاول والدرس التاني', 'you must watch lesson one and lesson two', '2023-05-16', '2023-05-17', 1, 1, '2023-04-19 09:49:46', '2023-04-19 09:49:46'),
(87, '#FFEAD7', 'مراجعه الفصل الاول', 'Review the first chapter', 'يجب مشاهده الدرس الاول والدرس التاني', 'you must watch lesson one and lesson two', '2023-05-17', '2023-05-18', 1, 1, '2023-04-19 09:49:47', '2023-04-19 09:49:47'),
(88, '#FFEAD7', 'مراجعه الفصل الاول', 'Review the first chapter', 'يجب مشاهده الدرس الاول والدرس التاني', 'you must watch lesson one and lesson two', '2023-05-18', '2023-05-19', 1, 1, '2023-04-19 09:49:47', '2023-04-19 09:49:47'),
(89, '#FFEAD7', 'مراجعه الفصل الاول', 'Review the first chapter', 'يجب مشاهده الدرس الاول والدرس التاني', 'you must watch lesson one and lesson two', '2023-05-19', '2023-05-20', 1, 1, '2023-04-19 09:49:47', '2023-04-19 09:49:47'),
(90, '#FFEAD7', 'مراجعه الفصل الاول', 'Review the first chapter', 'يجب مشاهده الدرس الاول والدرس التاني', 'you must watch lesson one and lesson two', '2023-05-20', '2023-05-21', 1, 1, '2023-04-19 09:49:47', '2023-04-19 09:49:47'),
(91, '#FFEAD7', 'مراجعه الفصل الاول', 'Review the first chapter', 'يجب مشاهده الدرس الاول والدرس التاني', 'you must watch lesson one and lesson two', '2023-05-21', '2023-05-22', 1, 1, '2023-04-19 09:49:47', '2023-04-19 09:49:47'),
(92, '#FFEAD7', 'مراجعه الفصل الاول', 'Review the first chapter', 'يجب مشاهده الدرس الاول والدرس التاني', 'you must watch lesson one and lesson two', '2023-05-22', '2023-05-23', 1, 1, '2023-04-19 09:49:47', '2023-04-19 09:49:47'),
(93, '#FFEAD7', 'مراجعه الفصل الاول', 'Review the first chapter', 'يجب مشاهده الدرس الاول والدرس التاني', 'you must watch lesson one and lesson two', '2023-05-23', '2023-05-24', 1, 1, '2023-04-19 09:49:47', '2023-04-19 09:49:47'),
(94, '#FFEAD7', 'مراجعه الفصل الاول', 'Review the first chapter', 'يجب مشاهده الدرس الاول والدرس التاني', 'you must watch lesson one and lesson two', '2023-05-24', '2023-05-25', 1, 1, '2023-04-19 09:49:47', '2023-04-19 09:49:47'),
(95, '#FFEAD7', 'مراجعه الفصل الاول', 'Review the first chapter', 'يجب مشاهده الدرس الاول والدرس التاني', 'you must watch lesson one and lesson two', '2023-05-25', '2023-05-26', 1, 1, '2023-04-19 09:49:47', '2023-04-19 09:49:47'),
(96, '#FFEAD7', 'مراجعه الفصل الاول', 'Review the first chapter', 'يجب مشاهده الدرس الاول والدرس التاني', 'you must watch lesson one and lesson two', '2023-05-26', '2023-05-27', 1, 1, '2023-04-19 09:49:47', '2023-04-19 09:49:47'),
(97, '#FFEAD7', 'مراجعه الفصل الاول', 'Review the first chapter', 'يجب مشاهده الدرس الاول والدرس التاني', 'you must watch lesson one and lesson two', '2023-05-27', '2023-05-28', 1, 1, '2023-04-19 09:49:47', '2023-04-19 09:49:47'),
(98, '#FFEAD7', 'مراجعه الفصل الاول', 'Review the first chapter', 'يجب مشاهده الدرس الاول والدرس التاني', 'you must watch lesson one and lesson two', '2023-05-28', '2023-05-29', 1, 1, '2023-04-19 09:49:47', '2023-04-19 09:49:47'),
(99, '#FFEAD7', 'مراجعه الفصل الاول', 'Review the first chapter', 'يجب مشاهده الدرس الاول والدرس التاني', 'you must watch lesson one and lesson two', '2023-05-29', '2023-05-30', 1, 1, '2023-04-19 09:49:47', '2023-04-19 09:49:47'),
(100, '#FFEAD7', 'مراجعه الفصل الاول', 'Review the first chapter', 'يجب مشاهده الدرس الاول والدرس التاني', 'you must watch lesson one and lesson two', '2023-05-30', '2023-05-31', 1, 1, '2023-04-19 09:49:47', '2023-04-19 09:49:47'),
(101, '#FFEAD7', 'مراجعه الفصل الاول', 'Review the first chapter', 'يجب مشاهده الدرس الاول والدرس التاني', 'you must watch lesson one and lesson two', '2023-05-31', '2023-06-01', 1, 1, '2023-04-19 09:49:47', '2023-04-19 09:49:47'),
(102, '#FFEAD7', 'مراجعه الفصل الاول', 'Review the first chapter', 'يجب مشاهده الدرس الاول والدرس التاني', 'you must watch lesson one and lesson two', '2023-06-01', '2023-06-02', 1, 1, '2023-04-19 09:49:47', '2023-04-19 09:49:47'),
(103, '#FFEAD7', 'مراجعه الفصل الاول', 'Review the first chapter', 'يجب مشاهده الدرس الاول والدرس التاني', 'you must watch lesson one and lesson two', '2023-06-02', '2023-06-03', 1, 1, '2023-04-19 09:49:47', '2023-04-19 09:49:47'),
(104, '#FFEAD7', 'مراجعه الفصل الاول', 'Review the first chapter', 'يجب مشاهده الدرس الاول والدرس التاني', 'you must watch lesson one and lesson two', '2023-06-03', '2023-06-04', 1, 1, '2023-04-19 09:49:48', '2023-04-19 09:49:48'),
(105, '#FFEAD7', 'مراجعه الفصل الاول', 'Review the first chapter', 'يجب مشاهده الدرس الاول والدرس التاني', 'you must watch lesson one and lesson two', '2023-06-04', '2023-06-05', 1, 1, '2023-04-19 09:49:48', '2023-04-19 09:49:48'),
(106, '#FFEAD7', 'مراجعه الفصل الاول', 'Review the first chapter', 'يجب مشاهده الدرس الاول والدرس التاني', 'you must watch lesson one and lesson two', '2023-06-05', '2023-06-06', 1, 1, '2023-04-19 09:49:48', '2023-04-19 09:49:48'),
(107, '#FFEAD7', 'مراجعه الفصل الاول', 'Review the first chapter', 'يجب مشاهده الدرس الاول والدرس التاني', 'you must watch lesson one and lesson two', '2023-06-06', '2023-06-07', 1, 1, '2023-04-19 09:49:48', '2023-04-19 09:49:48'),
(108, '#FFEAD7', 'مراجعه الفصل الاول', 'Review the first chapter', 'يجب مشاهده الدرس الاول والدرس التاني', 'you must watch lesson one and lesson two', '2023-06-07', '2023-06-08', 1, 1, '2023-04-19 09:49:48', '2023-04-19 09:49:48'),
(109, '#FFEAD7', 'مراجعه الفصل الاول', 'Review the first chapter', 'يجب مشاهده الدرس الاول والدرس التاني', 'you must watch lesson one and lesson two', '2023-06-08', '2023-06-09', 1, 1, '2023-04-19 09:49:48', '2023-04-19 09:49:48'),
(110, '#FFEAD7', 'مراجعه الفصل الاول', 'Review the first chapter', 'يجب مشاهده الدرس الاول والدرس التاني', 'you must watch lesson one and lesson two', '2023-06-09', '2023-06-10', 1, 1, '2023-04-19 09:49:48', '2023-04-19 09:49:48'),
(111, '#FFEAD7', 'مراجعه الفصل الاول', 'Review the first chapter', 'يجب مشاهده الدرس الاول والدرس التاني', 'you must watch lesson one and lesson two', '2023-06-10', '2023-06-11', 1, 1, '2023-04-19 09:49:48', '2023-04-19 09:49:48'),
(112, '#FFEAD7', 'مراجعه الفصل الاول', 'Review the first chapter', 'يجب مشاهده الدرس الاول والدرس التاني', 'you must watch lesson one and lesson two', '2023-06-11', '2023-06-12', 1, 1, '2023-04-19 09:49:48', '2023-04-19 09:49:48'),
(113, '#FFEAD7', 'مراجعه الفصل الاول', 'Review the first chapter', 'يجب مشاهده الدرس الاول والدرس التاني', 'you must watch lesson one and lesson two', '2023-06-12', '2023-06-13', 1, 1, '2023-04-19 09:49:48', '2023-04-19 09:49:48'),
(114, '#FFEAD7', 'مراجعه الفصل الاول', 'Review the first chapter', 'يجب مشاهده الدرس الاول والدرس التاني', 'you must watch lesson one and lesson two', '2023-06-13', '2023-06-14', 1, 1, '2023-04-19 09:49:48', '2023-04-19 09:49:48'),
(115, '#FFEAD7', 'مراجعه الفصل الاول', 'Review the first chapter', 'يجب مشاهده الدرس الاول والدرس التاني', 'you must watch lesson one and lesson two', '2023-06-14', '2023-06-15', 1, 1, '2023-04-19 09:49:48', '2023-04-19 09:49:48'),
(116, '#FFEAD7', 'مراجعه الفصل الاول', 'Review the first chapter', 'يجب مشاهده الدرس الاول والدرس التاني', 'you must watch lesson one and lesson two', '2023-06-15', '2023-06-16', 1, 1, '2023-04-19 09:49:48', '2023-04-19 09:49:48'),
(117, '#FFEAD7', 'مراجعه الفصل الاول', 'Review the first chapter', 'يجب مشاهده الدرس الاول والدرس التاني', 'you must watch lesson one and lesson two', '2023-06-16', '2023-06-17', 1, 1, '2023-04-19 09:49:49', '2023-04-19 09:49:49'),
(118, '#FFEAD7', 'مراجعه الفصل الاول', 'Review the first chapter', 'يجب مشاهده الدرس الاول والدرس التاني', 'you must watch lesson one and lesson two', '2023-06-17', '2023-06-18', 1, 1, '2023-04-19 09:49:49', '2023-04-19 09:49:49'),
(119, '#FFEAD7', 'مراجعه الفصل الاول', 'Review the first chapter', 'يجب مشاهده الدرس الاول والدرس التاني', 'you must watch lesson one and lesson two', '2023-06-18', '2023-06-19', 1, 1, '2023-04-19 09:49:49', '2023-04-19 09:49:49'),
(120, '#FFEAD7', 'مراجعه الفصل الاول', 'Review the first chapter', 'يجب مشاهده الدرس الاول والدرس التاني', 'you must watch lesson one and lesson two', '2023-06-19', '2023-06-20', 1, 1, '2023-04-19 09:49:49', '2023-04-19 09:49:49'),
(121, '#FFEAD7', 'مراجعه الفصل الاول', 'Review the first chapter', 'يجب مشاهده الدرس الاول والدرس التاني', 'you must watch lesson one and lesson two', '2023-06-20', '2023-06-21', 1, 1, '2023-04-19 09:49:49', '2023-04-19 09:49:49'),
(122, '#FFEAD7', 'مراجعه الفصل الاول', 'Review the first chapter', 'يجب مشاهده الدرس الاول والدرس التاني', 'you must watch lesson one and lesson two', '2023-06-21', '2023-06-22', 1, 1, '2023-04-19 09:49:49', '2023-04-19 09:49:49'),
(123, '#FFEAD7', 'مراجعه الفصل الاول', 'Review the first chapter', 'يجب مشاهده الدرس الاول والدرس التاني', 'you must watch lesson one and lesson two', '2023-06-22', '2023-06-23', 1, 1, '2023-04-19 09:49:49', '2023-04-19 09:49:49'),
(124, '#FFEAD7', 'مراجعه الفصل الاول', 'Review the first chapter', 'يجب مشاهده الدرس الاول والدرس التاني', 'you must watch lesson one and lesson two', '2023-06-23', '2023-06-24', 1, 1, '2023-04-19 09:49:49', '2023-04-19 09:49:49'),
(125, '#FFEAD7', 'مراجعه الفصل الاول', 'Review the first chapter', 'يجب مشاهده الدرس الاول والدرس التاني', 'you must watch lesson one and lesson two', '2023-06-24', '2023-06-25', 1, 1, '2023-04-19 09:49:49', '2023-04-19 09:49:49'),
(126, '#FFEAD7', 'مراجعه الفصل الاول', 'Review the first chapter', 'يجب مشاهده الدرس الاول والدرس التاني', 'you must watch lesson one and lesson two', '2023-06-25', '2023-06-26', 1, 1, '2023-04-19 09:49:49', '2023-04-19 09:49:49'),
(127, '#FFEAD7', 'مراجعه الفصل الاول', 'Review the first chapter', 'يجب مشاهده الدرس الاول والدرس التاني', 'you must watch lesson one and lesson two', '2023-06-26', '2023-06-27', 1, 1, '2023-04-19 09:49:49', '2023-04-19 09:49:49'),
(128, '#FFEAD7', 'مراجعه الفصل الاول', 'Review the first chapter', 'يجب مشاهده الدرس الاول والدرس التاني', 'you must watch lesson one and lesson two', '2023-06-27', '2023-06-28', 1, 1, '2023-04-19 09:49:49', '2023-04-19 09:49:49'),
(129, '#FFEAD7', 'مراجعه الفصل الاول', 'Review the first chapter', 'يجب مشاهده الدرس الاول والدرس التاني', 'you must watch lesson one and lesson two', '2023-06-28', '2023-06-29', 1, 1, '2023-04-19 09:49:49', '2023-04-19 09:49:49'),
(130, '#FFEAD7', 'مراجعه الفصل الاول', 'Review the first chapter', 'يجب مشاهده الدرس الاول والدرس التاني', 'you must watch lesson one and lesson two', '2023-06-29', '2023-06-30', 1, 1, '2023-04-19 09:49:50', '2023-04-19 09:49:50'),
(131, '#FFEAD7', 'مراجعه الفصل الاول', 'Review the first chapter', 'يجب مشاهده الدرس الاول والدرس التاني', 'you must watch lesson one and lesson two', '2023-06-30', '2023-07-01', 1, 1, '2023-04-19 09:49:50', '2023-04-19 09:49:50');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `season_id` bigint UNSIGNED NOT NULL,
  `term_id` bigint UNSIGNED NOT NULL,
  `image` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_season_id_foreign` (`season_id`),
  KEY `notifications_term_id_foreign` (`term_id`),
  KEY `notifications_user_id_foreign` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `title`, `body`, `season_id`, `term_id`, `image`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'اشعار جديد', 'يرجي متابعه الاجزاء القادمه من جزء الليزر', 1, 1, NULL, NULL, '2023-03-01 07:10:59', '2023-03-01 07:10:59'),
(2, 'اشعار جديد', 'يرجي متابعه الاجزاء القادمه من جزء الليزر', 1, 1, NULL, NULL, '2023-03-01 07:10:59', '2023-03-01 07:10:59'),
(3, 'اشعار جديد', 'يرجي متابعه الاجزاء القادمه من جزء الليزر', 1, 1, NULL, NULL, '2023-03-01 07:10:59', '2023-03-01 07:10:59'),
(4, 'اشعار جديد', 'يرجي متابعه الاجزاء القادمه من جزء الليزر', 1, 1, NULL, NULL, '2023-03-01 07:10:59', '2023-03-01 07:10:59'),
(5, 'اشعار جديد', 'يرجي متابعه الاجزاء القادمه من جزء الليزر', 1, 1, NULL, NULL, '2023-03-01 07:10:59', '2023-03-01 07:10:59'),
(6, 'اشعار جديد', 'يرجي متابعه الاجزاء القادمه من جزء الليزر', 1, 1, NULL, NULL, '2023-03-01 07:10:59', '2023-03-01 07:10:59'),
(7, 'اشعار جديد', 'يرجي متابعه الاجزاء القادمه من جزء الليزر', 1, 1, NULL, NULL, '2023-03-01 07:10:59', '2023-03-01 07:10:59'),
(8, 'اشعار جديد', 'يرجي متابعه الاجزاء القادمه من جزء الليزر', 1, 1, NULL, NULL, '2023-03-01 07:10:59', '2023-03-01 07:10:59'),
(9, 'اشعار جديد', 'يرجي متابعه الاجزاء القادمه من جزء الليزر', 1, 1, NULL, NULL, '2023-03-01 07:10:59', '2023-03-01 07:10:59'),
(10, 'اشعار جديد', 'يرجي متابعه الاجزاء القادمه من جزء الليزر', 1, 1, NULL, NULL, '2023-03-01 07:10:59', '2023-03-01 07:10:59'),
(11, 'اشعار جديد', 'تم تنزيل فيديو جديد لشرح المقاومه الحركيه', 1, 1, NULL, NULL, '2023-03-01 07:11:00', '2023-03-01 07:11:00'),
(12, 'اشعار جديد', 'عاااااش يا وحوش', 1, 1, NULL, NULL, '2023-03-29 11:45:14', '2023-03-29 11:45:14'),
(13, 'اشعار جديد', 'Section number 1واسم القاعه  Address 1ومكان الامتحان  2023-04-10تاريخ الامتحان', 1, 1, NULL, 13, '2023-04-05 12:18:33', '2023-04-05 12:18:33'),
(14, 'اشعار جديد', '07:00:00وموعد الامتحان  3قاعه رقم واسم القاعه  الجيزهومكان الامتحان  2023-04-10تاريخ الامتحان', 1, 1, NULL, 14, '2023-04-05 12:46:48', '2023-04-05 12:46:48');

-- --------------------------------------------------------

--
-- Table structure for table `online_exams`
--

DROP TABLE IF EXISTS `online_exams`;
CREATE TABLE IF NOT EXISTS `online_exams` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `exam_type` enum('pdf','online') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'online',
  `pdf_file_upload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `answer_pdf_file` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `answer_video_file` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `name_ar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_en` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_exam` date NOT NULL,
  `quize_minute` int NOT NULL,
  `trying_number` int NOT NULL,
  `degree` int NOT NULL,
  `type` enum('lesson','class','video') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `season_id` bigint UNSIGNED DEFAULT NULL,
  `term_id` bigint UNSIGNED DEFAULT NULL,
  `class_id` bigint UNSIGNED DEFAULT NULL,
  `lesson_id` bigint UNSIGNED DEFAULT NULL,
  `video_id` bigint UNSIGNED DEFAULT NULL,
  `instruction_ar` json DEFAULT NULL,
  `instruction_en` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `online_exams_season_id_foreign` (`season_id`),
  KEY `online_exams_term_id_foreign` (`term_id`),
  KEY `class_id_cons` (`class_id`),
  KEY `lesson_id_const` (`lesson_id`),
  KEY `video_id_const` (`video_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `online_exams`
--

INSERT INTO `online_exams` (`id`, `exam_type`, `pdf_file_upload`, `answer_pdf_file`, `answer_video_file`, `name_ar`, `name_en`, `date_exam`, `quize_minute`, `trying_number`, `degree`, `type`, `season_id`, `term_id`, `class_id`, `lesson_id`, `video_id`, `instruction_ar`, `instruction_en`, `created_at`, `updated_at`) VALUES
(1, 'online', NULL, NULL, NULL, 'امتحان شامل علي الليزر', 'Exam about Lizer', '2023-03-20', 30, 2, 40, 'class', 1, 1, 1, NULL, NULL, NULL, NULL, '2023-02-23 08:25:36', '2023-02-23 08:25:36'),
(2, 'online', NULL, NULL, NULL, 'امتحان علي الدرس الاول', 'Exam about lesson1', '2023-03-20', 30, 100, 100, 'lesson', 1, 1, NULL, 1, NULL, NULL, NULL, '2023-02-23 08:25:36', '2023-02-23 08:25:36'),
(3, 'online', NULL, NULL, NULL, 'امتحان علي الدرس الاول جزء المعادلات', 'Exam about lesson1', '2023-03-20', 30, 2, 50, 'lesson', 1, 1, NULL, 1, NULL, NULL, NULL, '2023-02-23 08:25:36', '2023-02-23 08:25:36'),
(4, 'online', NULL, NULL, NULL, 'امتحان علي الفيديو الاول', 'Exam for part 1', '2023-03-20', 30, 20, 80, 'video', 1, 1, NULL, NULL, 1, NULL, NULL, '2023-02-23 08:25:36', '2023-02-23 08:25:36'),
(5, 'online', NULL, NULL, NULL, 'امتحان علي المقاومه الكهربائيه', 'Electrical resistance test', '2023-03-20', 30, 9, 40, 'class', 1, 1, 1, NULL, NULL, NULL, NULL, '2023-02-23 08:25:36', '2023-02-23 08:25:36');

-- --------------------------------------------------------

--
-- Table structure for table `online_exam_questions`
--

DROP TABLE IF EXISTS `online_exam_questions`;
CREATE TABLE IF NOT EXISTS `online_exam_questions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `online_exam_id` bigint UNSIGNED DEFAULT NULL,
  `all_exam_id` bigint UNSIGNED DEFAULT NULL,
  `life_exam_id` bigint UNSIGNED DEFAULT NULL,
  `question_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `online_exam_questions_all_exam_id_foreign` (`all_exam_id`),
  KEY `online_exam_questions_online_exam_id_foreign` (`online_exam_id`),
  KEY `online_exam_questions_question_id_foreign` (`question_id`),
  KEY `life_exam_cons_3` (`life_exam_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `online_exam_questions`
--

INSERT INTO `online_exam_questions` (`id`, `online_exam_id`, `all_exam_id`, `life_exam_id`, `question_id`, `created_at`, `updated_at`) VALUES
(5, 4, NULL, NULL, 1, '2023-03-13 08:21:51', '2023-03-13 08:21:51'),
(6, 4, NULL, NULL, 2, '2023-03-13 08:21:51', '2023-03-13 08:21:51'),
(7, 4, NULL, NULL, 3, '2023-03-13 08:21:51', '2023-03-13 08:21:51'),
(8, 4, NULL, NULL, 4, '2023-03-13 08:21:51', '2023-03-13 08:21:51'),
(9, NULL, 1, NULL, 5, '2023-03-13 08:21:51', '2023-03-13 08:21:51'),
(10, NULL, 1, NULL, 6, '2023-03-13 08:21:51', '2023-03-13 08:21:51'),
(11, 2, NULL, NULL, 7, '2023-03-13 08:21:51', '2023-03-13 08:21:51'),
(12, 2, NULL, NULL, 8, '2023-03-13 08:21:51', '2023-03-13 08:21:51'),
(13, 1, NULL, NULL, 10, '2023-03-13 08:21:51', '2023-03-13 08:21:51'),
(14, 1, NULL, NULL, 11, '2023-03-13 08:21:51', '2023-03-13 08:21:51'),
(15, 2, NULL, NULL, 9, '2023-03-13 08:21:51', '2023-03-13 08:21:51'),
(16, NULL, NULL, 1, 12, '2023-03-13 08:21:51', '2023-03-13 08:21:51'),
(17, NULL, NULL, 1, 13, '2023-03-13 08:21:51', '2023-03-13 08:21:51'),
(18, NULL, NULL, 1, 14, '2023-03-13 08:21:51', '2023-03-13 08:21:51'),
(19, NULL, NULL, 1, 15, '2023-03-13 08:21:51', '2023-03-13 08:21:51'),
(20, NULL, NULL, 1, 16, '2023-03-13 08:21:51', '2023-03-13 08:21:51'),
(21, 4, NULL, NULL, 17, '2023-03-13 08:21:51', '2023-03-13 08:21:51');

-- --------------------------------------------------------

--
-- Table structure for table `online_exam_users`
--

DROP TABLE IF EXISTS `online_exam_users`;
CREATE TABLE IF NOT EXISTS `online_exam_users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `question_id` bigint UNSIGNED NOT NULL,
  `answer_id` bigint UNSIGNED DEFAULT NULL,
  `online_exam_id` bigint UNSIGNED DEFAULT NULL,
  `all_exam_id` bigint UNSIGNED DEFAULT NULL,
  `life_exam_id` bigint UNSIGNED DEFAULT NULL,
  `degree` int NOT NULL DEFAULT '0',
  `degree_status` enum('completed') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'completed',
  `status` enum('solved','leave','un_correct') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `online_exam_users_user_id_foreign` (`user_id`),
  KEY `online_exam_users_question_id_foreign` (`question_id`),
  KEY `online_exam_users_answer_id_foreign` (`answer_id`),
  KEY `online_exam_users_all_exam_id_foreign` (`all_exam_id`),
  KEY `online_exam_users_online_exam_id_foreign` (`online_exam_id`),
  KEY `life_exam_cons_1` (`life_exam_id`)
) ENGINE=InnoDB AUTO_INCREMENT=479 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `online_exam_users`
--

INSERT INTO `online_exam_users` (`id`, `user_id`, `question_id`, `answer_id`, `online_exam_id`, `all_exam_id`, `life_exam_id`, `degree`, `degree_status`, `status`, `created_at`, `updated_at`) VALUES
(322, 1, 1, 1, 4, NULL, NULL, 20, 'completed', 'solved', '2023-03-18 06:30:11', '2023-03-18 06:30:11'),
(323, 1, 2, 2, 4, NULL, NULL, 0, 'completed', 'un_correct', '2023-03-18 06:30:11', '2023-03-18 06:30:11'),
(324, 1, 3, 1, 4, NULL, NULL, 20, 'completed', 'solved', '2023-03-18 06:30:11', '2023-03-18 06:30:11'),
(328, 2, 1, 1, 4, NULL, NULL, 20, 'completed', 'solved', '2023-03-18 06:42:56', '2023-03-18 06:42:56'),
(329, 2, 2, 1, 4, NULL, NULL, 20, 'completed', 'solved', '2023-03-18 06:42:56', '2023-03-18 06:42:56'),
(330, 2, 3, 1, 4, NULL, NULL, 20, 'completed', 'solved', '2023-03-18 06:42:56', '2023-03-18 06:42:56'),
(334, 6, 1, 1, 4, NULL, NULL, 20, 'completed', 'solved', '2023-03-18 10:30:14', '2023-03-18 10:30:14'),
(335, 6, 2, 2, 4, NULL, NULL, 0, 'completed', 'un_correct', '2023-03-18 10:30:15', '2023-03-18 10:30:15'),
(336, 6, 3, 1, 4, NULL, NULL, 20, 'completed', 'solved', '2023-03-18 10:30:15', '2023-03-18 10:30:15'),
(340, 10, 1, 1, 4, NULL, NULL, 20, 'completed', 'solved', '2023-03-18 10:35:14', '2023-03-18 10:35:14'),
(341, 10, 2, 1, 4, NULL, NULL, 20, 'completed', 'solved', '2023-03-18 10:35:14', '2023-03-18 10:35:14'),
(342, 10, 3, 1, 4, NULL, NULL, 20, 'completed', 'solved', '2023-03-18 10:35:14', '2023-03-18 10:35:14'),
(346, 9, 1, 1, 4, NULL, NULL, 20, 'completed', 'solved', '2023-03-18 10:40:59', '2023-03-18 10:40:59'),
(347, 9, 2, 2, 4, NULL, NULL, 0, 'completed', 'un_correct', '2023-03-18 10:40:59', '2023-03-18 10:40:59'),
(348, 9, 3, 1, 4, NULL, NULL, 20, 'completed', 'solved', '2023-03-18 10:40:59', '2023-03-18 10:40:59'),
(351, 5, 1, 1, 2, NULL, NULL, 20, 'completed', 'solved', '2023-03-19 05:41:05', '2023-03-19 05:41:05'),
(352, 5, 2, 1, 2, NULL, NULL, 20, 'completed', 'solved', '2023-03-19 05:41:05', '2023-03-19 05:41:05'),
(400, 1, 7, 21, 2, NULL, NULL, 30, 'completed', 'solved', '2023-03-21 09:48:20', '2023-03-21 09:48:20'),
(401, 1, 8, 25, 2, NULL, NULL, 30, 'completed', 'solved', '2023-03-21 09:48:20', '2023-03-21 09:48:20'),
(402, 1, 9, 37, 2, NULL, NULL, 40, 'completed', 'solved', '2023-03-21 09:48:20', '2023-03-21 09:48:20'),
(438, 1, 12, 41, NULL, NULL, 1, 40, 'completed', 'solved', '2023-03-26 08:30:19', '2023-03-26 08:30:19'),
(439, 1, 13, 45, NULL, NULL, 1, 40, 'completed', 'solved', '2023-03-26 08:30:39', '2023-03-26 08:30:39'),
(440, 1, 14, 49, NULL, NULL, 1, 40, 'completed', 'solved', '2023-03-26 08:30:52', '2023-03-26 08:30:52'),
(441, 1, 15, 53, NULL, NULL, 1, 40, 'completed', 'solved', '2023-03-26 08:31:10', '2023-03-26 08:31:10'),
(442, 1, 16, 57, NULL, NULL, 1, 40, 'completed', 'solved', '2023-03-26 08:31:50', '2023-03-26 08:31:50'),
(454, 9, 12, 41, NULL, NULL, 1, 40, 'completed', 'solved', '2023-03-27 12:33:34', '2023-03-27 12:33:34'),
(455, 9, 13, 45, NULL, NULL, 1, 40, 'completed', 'solved', '2023-03-27 12:33:49', '2023-03-27 12:33:49'),
(456, 9, 14, 49, NULL, NULL, 1, 40, 'completed', 'solved', '2023-03-27 12:34:06', '2023-03-27 12:34:06'),
(457, 9, 15, 56, NULL, NULL, 1, 0, 'completed', 'un_correct', '2023-03-27 12:34:37', '2023-03-27 12:34:37'),
(458, 9, 16, 60, NULL, NULL, 1, 0, 'completed', 'un_correct', '2023-03-27 12:34:52', '2023-03-27 12:34:52'),
(464, 13, 12, 41, NULL, NULL, 1, 40, 'completed', 'solved', '2023-03-28 09:26:19', '2023-03-28 09:26:19'),
(465, 13, 13, 45, NULL, NULL, 1, 40, 'completed', 'solved', '2023-03-28 09:26:50', '2023-03-28 09:26:50'),
(466, 13, 14, 49, NULL, NULL, 1, 40, 'completed', 'solved', '2023-03-28 09:27:22', '2023-03-28 09:27:22'),
(467, 13, 15, 53, NULL, NULL, 1, 40, 'completed', 'solved', '2023-03-28 09:27:48', '2023-03-28 09:27:48'),
(468, 13, 16, 60, NULL, NULL, 1, 0, 'completed', 'un_correct', '2023-03-28 09:28:00', '2023-03-28 09:28:00'),
(474, 4, 12, 41, NULL, NULL, 1, 40, 'completed', 'solved', '2023-03-28 11:34:19', '2023-03-28 11:34:19'),
(475, 4, 13, 45, NULL, NULL, 1, 40, 'completed', 'solved', '2023-03-28 11:34:44', '2023-03-28 11:34:44'),
(476, 4, 14, 49, NULL, NULL, 1, 40, 'completed', 'solved', '2023-03-28 11:35:10', '2023-03-28 11:35:10'),
(477, 4, 15, 53, NULL, NULL, 1, 40, 'completed', 'solved', '2023-03-28 11:35:21', '2023-03-28 11:35:21'),
(478, 4, 16, 60, NULL, NULL, 1, 0, 'completed', 'un_correct', '2023-03-28 11:35:37', '2023-03-28 11:35:37');

-- --------------------------------------------------------

--
-- Table structure for table `on_boardings`
--

DROP TABLE IF EXISTS `on_boardings`;
CREATE TABLE IF NOT EXISTS `on_boardings` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `title_ar` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_en` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_ar` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_en` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `on_boardings`
--

INSERT INTO `on_boardings` (`id`, `title_ar`, `title_en`, `description_ar`, `description_en`, `image`, `created_at`, `updated_at`) VALUES
(1, 'مرحبا بك عزيزى الطالب', 'Welcome, dear student', 'هنساعك تتعلم الفيزياء بطريقة سهلة ومبسطة', 'We will help you learn physics in an easy and simplified way', 'assets/uploads/onBoarding/image/62131681719342.png', '2023-04-17 08:15:42', '2023-04-17 08:15:42'),
(2, 'اشترك واحصل على المراجعات', 'Subscribe and get reviews', 'ادخل كود الاشتراك , وابدأ رحلتك التعليمية', 'Enter the subscription code, and start your educational journey', 'assets/uploads/onBoarding/image/61681719401.png', '2023-04-17 08:16:41', '2023-04-17 08:16:41'),
(3, 'الفيزياء بطريقة جديدة وممتعة', 'Physics in a new and fun way', 'أفضل نظام متابعة من متتخصصين معاك لحظة بلحظة', 'The best follow-up system from specialists with you, moment by moment', 'assets/uploads/onBoarding/image/34651681719449.png', '2023-04-17 08:17:29', '2023-04-17 08:17:29');

-- --------------------------------------------------------

--
-- Table structure for table `open_lessons`
--

DROP TABLE IF EXISTS `open_lessons`;
CREATE TABLE IF NOT EXISTS `open_lessons` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `lesson_id` bigint UNSIGNED DEFAULT NULL,
  `subject_class_id` bigint UNSIGNED DEFAULT NULL,
  `status` enum('opened') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `open_lessons_user_id_foreign` (`user_id`),
  KEY `open_lessons_lesson_id_foreign` (`lesson_id`),
  KEY `open_lessons_subject_class_id_foreign` (`subject_class_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `open_lessons`
--

INSERT INTO `open_lessons` (`id`, `user_id`, `lesson_id`, `subject_class_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, 1, 'opened', '2023-03-26 08:16:42', '2023-03-26 08:16:42'),
(2, 1, 1, NULL, 'opened', '2023-03-26 08:16:42', '2023-03-26 08:16:42'),
(3, 9, NULL, 1, 'opened', '2023-03-27 12:05:36', '2023-03-27 12:05:36'),
(4, 9, 1, NULL, 'opened', '2023-03-27 12:05:37', '2023-03-27 12:05:37'),
(5, 4, NULL, 1, 'opened', '2023-03-28 11:31:17', '2023-03-28 11:31:17'),
(6, 4, 1, NULL, 'opened', '2023-03-28 11:31:17', '2023-03-28 11:31:17'),
(7, 2, NULL, 1, 'opened', '2023-03-30 09:40:48', '2023-03-30 09:40:48'),
(8, 2, 1, NULL, 'opened', '2023-03-30 09:40:49', '2023-03-30 09:40:49');

-- --------------------------------------------------------

--
-- Table structure for table `papel_sheet_exams`
--

DROP TABLE IF EXISTS `papel_sheet_exams`;
CREATE TABLE IF NOT EXISTS `papel_sheet_exams` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name_ar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_en` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `degree` int NOT NULL,
  `season_id` bigint UNSIGNED NOT NULL,
  `term_id` bigint UNSIGNED NOT NULL,
  `from` date NOT NULL,
  `to` date NOT NULL,
  `date_exam` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `papel_sheet_exams_season_id_foreign` (`season_id`),
  KEY `papel_sheet_exams_term_id_foreign` (`term_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `papel_sheet_exams`
--

INSERT INTO `papel_sheet_exams` (`id`, `name_ar`, `name_en`, `description`, `degree`, `season_id`, `term_id`, `from`, `to`, `date_exam`, `created_at`, `updated_at`) VALUES
(1, 'امتحان ورقي علي الوحده الاولي', 'Paper exam on the first unit', 'يجب الانتظام في القاعات وعدم النظر الي الطالب بجانبك', 80, 1, 1, '2023-04-05', '2023-04-08', '2023-04-10', '2023-02-27 09:54:04', '2023-02-27 09:54:04');

-- --------------------------------------------------------

--
-- Table structure for table `papel_sheet_exam_degrees`
--

DROP TABLE IF EXISTS `papel_sheet_exam_degrees`;
CREATE TABLE IF NOT EXISTS `papel_sheet_exam_degrees` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `papel_sheet_exam_id` bigint UNSIGNED NOT NULL,
  `degree` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `papel_sheet_exam_degrees_user_id_foreign` (`user_id`),
  KEY `papel_sheet_exam_degrees_papel_sheet_exam_id_foreign` (`papel_sheet_exam_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `papel_sheet_exam_degrees`
--

INSERT INTO `papel_sheet_exam_degrees` (`id`, `user_id`, `papel_sheet_exam_id`, `degree`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 68, '2023-03-15 11:31:42', '2023-03-15 11:31:42'),
(2, 2, 1, 65, '2023-03-15 11:31:42', '2023-03-15 11:31:42'),
(3, 4, 1, 60, '2023-03-15 11:31:42', '2023-03-15 11:31:42'),
(4, 5, 1, 70, '2023-03-15 11:31:42', '2023-03-15 11:31:42'),
(5, 6, 1, 78, '2023-03-15 11:31:42', '2023-03-15 11:31:42'),
(6, 8, 1, 63, '2023-03-15 11:31:42', '2023-03-15 11:31:42'),
(7, 9, 1, 75, '2023-03-15 11:31:42', '2023-03-15 11:31:42'),
(8, 10, 1, 80, '2023-03-15 11:31:42', '2023-03-15 11:31:42');

-- --------------------------------------------------------

--
-- Table structure for table `papel_sheet_exam_times`
--

DROP TABLE IF EXISTS `papel_sheet_exam_times`;
CREATE TABLE IF NOT EXISTS `papel_sheet_exam_times` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `from` time NOT NULL,
  `to` time NOT NULL,
  `papel_sheet_exam_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `papel_sheet_exam_times_papel_sheet_exam_id_foreign` (`papel_sheet_exam_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `papel_sheet_exam_times`
--

INSERT INTO `papel_sheet_exam_times` (`id`, `from`, `to`, `papel_sheet_exam_id`, `created_at`, `updated_at`) VALUES
(1, '07:00:00', '08:00:00', 1, '2023-03-01 07:29:00', '2023-03-01 07:29:00'),
(2, '08:00:00', '09:00:00', 1, '2023-03-01 07:29:00', '2023-03-01 07:29:00'),
(3, '09:00:00', '10:00:00', 1, '2023-03-01 07:29:00', '2023-03-01 07:29:00'),
(4, '10:00:00', '11:00:00', 1, '2023-03-01 07:29:00', '2023-03-01 07:29:00'),
(5, '11:00:00', '12:00:00', 1, '2023-03-01 07:29:00', '2023-03-01 07:29:00');

-- --------------------------------------------------------

--
-- Table structure for table `papel_sheet_exam_users`
--

DROP TABLE IF EXISTS `papel_sheet_exam_users`;
CREATE TABLE IF NOT EXISTS `papel_sheet_exam_users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `section_id` bigint UNSIGNED NOT NULL,
  `papel_sheet_exam_id` bigint UNSIGNED NOT NULL,
  `papel_sheet_exam_time_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `papel_sheet_exam_users_papel_sheet_exam_id_foreign` (`papel_sheet_exam_id`),
  KEY `user_cons` (`user_id`),
  KEY `section_cons` (`section_id`),
  KEY `papel_sheet_exam_users_papel_sheet_exam_time_id_foreign` (`papel_sheet_exam_time_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `papel_sheet_exam_users`
--

INSERT INTO `papel_sheet_exam_users` (`id`, `user_id`, `section_id`, `papel_sheet_exam_id`, `papel_sheet_exam_time_id`, `created_at`, `updated_at`) VALUES
(7, 1, 1, 1, 1, '2023-03-07 09:41:48', '2023-03-07 09:41:48'),
(8, 2, 1, 1, 1, '2023-03-07 09:41:48', '2023-03-07 09:41:48'),
(9, 4, 1, 1, 1, '2023-03-07 09:41:48', '2023-03-07 09:41:48'),
(10, 5, 1, 1, 1, '2023-03-07 09:41:48', '2023-03-07 09:41:48'),
(11, 6, 1, 1, 1, '2023-03-07 09:41:48', '2023-03-07 09:41:48'),
(12, 8, 1, 1, 1, '2023-03-07 09:41:48', '2023-03-07 09:41:48'),
(13, 9, 1, 1, 1, '2023-03-07 09:41:48', '2023-03-07 09:41:48'),
(14, 10, 1, 1, 1, '2023-03-07 09:41:48', '2023-03-07 09:41:48'),
(15, 13, 1, 1, 1, '2023-04-05 12:18:33', '2023-04-05 12:18:33'),
(16, 14, 3, 1, 1, '2023-04-05 12:46:48', '2023-04-05 12:46:48');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
CREATE TABLE IF NOT EXISTS `payments` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `payment_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payer_email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `payment_id`, `payer_email`, `currency`, `user_id`, `status`, `amount`, `created_at`, `updated_at`) VALUES
(1, 'ch_3MqbRmHb7WBZjgxw1KNH4fnw', NULL, 'usd', '12', 'succeeded', 325, '2023-03-28 12:16:19', '2023-03-28 12:16:19'),
(2, 'ch_3MqbgUHb7WBZjgxw1P9Ln3tL', NULL, 'usd', '12', 'succeeded', 325, '2023-03-28 12:31:31', '2023-03-28 12:31:31'),
(3, 'ch_3MqbmJHb7WBZjgxw0u6z3aDe', NULL, 'usd', '1', 'succeeded', 325, '2023-03-28 12:37:31', '2023-03-28 12:37:31'),
(4, 'ch_3MqbojHb7WBZjgxw0EiO929p', NULL, 'usd', '1', 'succeeded', 325, '2023-03-28 12:40:02', '2023-03-28 12:40:02');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(125) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(125) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=MyISAM AUTO_INCREMENT=62 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(51, 'الاعدادات', 'admin', '2023-04-19 13:00:44', '2023-04-19 13:00:44'),
(50, 'القاعات', 'admin', '2023-04-19 13:00:44', '2023-04-19 13:00:44'),
(49, 'سلايدر', 'admin', '2023-04-19 13:00:44', '2023-04-19 13:00:44'),
(48, 'الشاشات الافتتاحيه', 'admin', '2023-04-19 13:00:44', '2023-04-19 13:00:44'),
(47, 'الاتصالات الهاتفية', 'admin', '2023-04-19 13:00:44', '2023-04-19 13:00:44'),
(46, 'كل الامتحانات', 'admin', '2023-04-19 13:00:44', '2023-04-19 13:00:44'),
(45, 'امتحانات الورقية', 'admin', '2023-04-19 13:00:44', '2023-04-19 13:00:44'),
(44, 'امتحانات اللايف', 'admin', '2023-04-19 13:00:44', '2023-04-19 13:00:44'),
(43, 'امتحانات الاونلاين', 'admin', '2023-04-19 13:00:44', '2023-04-19 13:00:44'),
(42, 'الاقتراحات', 'admin', '2023-04-19 13:00:44', '2023-04-19 13:00:44'),
(41, 'الخطة الشهرية', 'admin', '2023-04-19 13:00:44', '2023-04-19 13:00:44'),
(40, 'الفيديوهات الاساسية ملفات ورقية', 'admin', '2023-04-19 13:00:44', '2023-04-19 13:00:44'),
(39, 'مصادر الفيديوهات', 'admin', '2023-04-19 13:00:44', '2023-04-19 13:00:44'),
(38, 'الفيديوهات الاساسية', 'admin', '2023-04-19 13:00:44', '2023-04-19 13:00:44'),
(37, 'اقسام الفيديوهات', 'admin', '2023-04-19 13:00:44', '2023-04-19 13:00:44'),
(36, 'الاشعارات', 'admin', '2023-04-19 13:00:44', '2023-04-19 13:00:44'),
(35, 'الطلاب', 'admin', '2023-04-19 13:00:44', '2023-04-19 13:00:44'),
(34, 'الدروس', 'admin', '2023-04-19 13:00:44', '2023-04-19 13:00:44'),
(33, 'الترم', 'admin', '2023-04-19 13:00:44', '2023-04-19 13:00:44'),
(32, 'الوحدات', 'admin', '2023-04-19 13:00:44', '2023-04-19 13:00:44'),
(31, 'الصفوف الدراسيه', 'admin', '2023-04-19 13:00:44', '2023-04-19 13:00:44'),
(52, 'الدليل', 'admin', '2023-04-19 13:00:44', '2023-04-19 13:00:44'),
(53, 'ملفات ورقية', 'admin', '2023-04-19 13:00:44', '2023-04-19 13:00:44'),
(54, 'بنك الأسئلة', 'admin', '2023-04-19 13:00:44', '2023-04-19 13:00:44'),
(55, 'الباقات', 'admin', '2023-04-19 13:00:44', '2023-04-19 13:00:44'),
(56, 'المدن', 'admin', '2023-04-19 13:00:44', '2023-04-19 13:00:44'),
(57, 'التعليقات', 'admin', '2023-04-19 13:00:44', '2023-04-19 13:00:44'),
(58, 'الاعلانات', 'admin', '2023-04-19 13:00:44', '2023-04-19 13:00:44'),
(59, 'الادمن', 'admin', '2023-04-19 13:00:44', '2023-04-19 13:00:44'),
(60, 'الادوار و الصلاحيات', 'admin', '2023-04-19 13:00:44', '2023-04-19 13:00:44'),
(61, 'الرئيسية', 'admin', '2023-04-20 08:53:44', '2023-04-20 08:53:44');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `phone_communications`
--

DROP TABLE IF EXISTS `phone_communications`;
CREATE TABLE IF NOT EXISTS `phone_communications` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `phone_communications`
--

INSERT INTO `phone_communications` (`id`, `phone`, `note`, `created_at`, `updated_at`) VALUES
(1, '01062933181', 'تواصل مع السكرتاريه', '2023-02-23 06:05:56', '2023-02-23 06:05:56'),
(2, '01062933182', 'تواصل مع السكرتاريه', '2023-02-23 06:05:56', '2023-02-23 06:05:56'),
(3, '01062933183', 'تواصل مع السكرتاريه', '2023-02-23 06:05:56', '2023-02-23 06:05:56');

-- --------------------------------------------------------

--
-- Table structure for table `phone_tokens`
--

DROP TABLE IF EXISTS `phone_tokens`;
CREATE TABLE IF NOT EXISTS `phone_tokens` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `token` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_type` enum('android','ios') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `phone_tokens_user_id_foreign` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `phone_tokens`
--

INSERT INTO `phone_tokens` (`id`, `token`, `phone_type`, `user_id`, `created_at`, `updated_at`) VALUES
(2, 'eXZZX6HkSkS4gSjfnRUxd_:APA91bEFsgd6UuB8-8ziCUf2_x8IoqfL3pVijI5JuhxxO8t2yWS6AVQyv6Sb1fqg_t6NtOK2XmNGG8yXtEe9nVkc2BTd1ABVfAQxgrJW-9OF_d_ScKe8WV2zQzV2gsRhzwPhQ4AV3q6x', 'android', 2, '2023-03-29 08:17:48', '2023-03-29 08:17:48'),
(3, 'cDD5MWuPRNOBIuKJpHYCvf:APA91bGiOFewosEsiFOeBinNMalz1hx4h5NMhCnyOvkMoyN1caLuxfQ0bqjfF84_lczRKG-XS5c3TjMCMtYM1CqIQ3_iAJkUSqEyjkLypTOWxfflir_ZmfUkx-MNbn8kklrwlAXvgBz1', 'android', 1, '2023-03-29 11:52:42', '2023-03-29 11:52:42');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

DROP TABLE IF EXISTS `questions`;
CREATE TABLE IF NOT EXISTS `questions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `question` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `type` enum('video','lesson','all_exam','subject_class','life_exam') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `file_type` enum('image','text') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'text',
  `question_type` enum('choice','text') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'choice',
  `degree` int NOT NULL,
  `note` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `season_id` bigint UNSIGNED NOT NULL,
  `term_id` bigint UNSIGNED NOT NULL,
  `examable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `examable_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `questions_examable_type_examable_id_index` (`examable_type`,`examable_id`),
  KEY `questions_season_id_foreign` (`season_id`),
  KEY `questions_term_id_foreign` (`term_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `question`, `type`, `image`, `file_type`, `question_type`, `degree`, `note`, `season_id`, `term_id`, `examable_type`, `examable_id`, `created_at`, `updated_at`) VALUES
(1, 'إذا كانت نسبة الخطأ في قياس طول قلم هي 2% وكان مقدار الخطأ يساوي 0.1 سم فإن طول القلم الحقيقي يساوي .......... سم', 'video', NULL, 'text', 'choice', 20, 'اقراء السؤال بعنايه', 1, 1, 'App\\Models\\VideoParts', 1, '2023-03-06 07:43:37', '2023-03-06 07:43:37'),
(2, 'إذا كان الخطأ النسبي في قياس الكتلة = 0.01 والخطأ النسبي في قياس العجلة = 0.03 فإن الخطأ النسبي في قياس القوة = .......... (القوة = كتلة في عجلة )', 'video', NULL, 'text', 'choice', 20, 'اقراء السؤال بعنايه', 1, 1, 'App\\Models\\VideoParts', 1, '2023-03-06 09:56:25', '2023-03-06 09:56:30'),
(3, 'إذا كان الخطأ النسبي في قياس نصف قطر كرة %5.0 فان الخطأ النسبي الكلي في قياس حجمها', 'video', NULL, 'text', 'choice', 20, 'اقراء السؤال بعنايه', 1, 1, 'App\\Models\\VideoParts', 1, '2023-03-06 07:54:14', '2023-03-06 07:54:15'),
(4, 'بداءت سياره حركتها من السكون وفي خط مستقيم وعجله منتظمه فاذا كانت سرعتها المتوسطه خلال 20s هي (2m/s) فان سرعتها بعد 25 ثانيه هي ', 'video', NULL, 'text', 'text', 20, 'اقراء السؤال بعنايه', 1, 1, 'App\\Models\\VideoParts', 1, '2023-03-06 07:54:14', '2023-03-06 07:54:15'),
(5, 'المقدار الحركي للمقاومه اثناء الحركه المستقيمه', 'all_exam', NULL, 'text', 'choice', 20, 'اقراء السؤال بعنايه', 1, 1, 'App\\Models\\AllExam', 1, '2023-03-06 07:43:37', '2023-03-06 07:43:37'),
(6, 'الخطاء النسبي = سم', 'all_exam', NULL, 'text', 'choice', 20, 'اقراء السؤال بعنايه', 1, 1, 'App\\Models\\AllExam', 1, '2023-03-06 07:43:37', '2023-03-06 07:43:37'),
(7, 'الحركه التفاعليه للمقاومه النسبيه هي تقاس ب ', 'lesson', NULL, 'text', 'choice', 30, 'اقراء السؤال بعنايه', 1, 1, 'App\\Models\\Lesson', 2, '2023-03-06 07:43:37', '2023-03-06 07:43:37'),
(8, 'اذا كانت سرعه الفهد عند السير في الغابه هي 1 كيلومتر علي الساعه فكم سرعته في اليوم', 'lesson', NULL, 'text', 'choice', 30, 'اقراء السؤال بعنايه', 1, 1, 'App\\Models\\Lesson', 2, '2023-03-06 07:43:37', '2023-03-06 07:43:37'),
(9, 'سرعه المقاومه للبندول عند السكون كام حركه', 'lesson', NULL, 'text', 'choice', 40, 'اقراء السؤال بعنايه', 1, 1, 'App\\Models\\Lesson', 2, '2023-03-06 07:43:37', '2023-03-06 07:43:37'),
(10, 'الطول المعياري لسلك الالمنويوم كام متر ', 'subject_class', NULL, 'text', 'choice', 20, 'اقراء السؤال بعنايه', 1, 1, 'App\\Models\\SubjectClass', 1, '2023-03-06 07:43:37', '2023-03-06 07:43:37'),
(11, 'الحركه المستقيمه للانسان تعادل كام من حركه الحيوان', 'subject_class', NULL, 'text', 'choice', 20, 'اقراء السؤال بعنايه', 1, 1, 'App\\Models\\SubjectClass', 1, '2023-03-06 07:43:37', '2023-03-06 07:43:37'),
(12, 'إذا تحرك جسم علي محيط دائرة دورة كاملة فإن إزاحة الجسم تساوي:', 'life_exam', NULL, 'text', 'choice', 40, 'اقراء السؤال بعنايه', 1, 1, 'App\\Models\\LifeExam', 1, '2023-03-06 07:43:37', '2023-03-06 07:43:37'),
(13, 'إذا تحرك جسم علي محيط دائرة دورة كاملة فإن الزاوية التي قطعها بالراديان تساوي:', 'life_exam', NULL, 'text', 'choice', 40, 'اقراء السؤال بعنايه', 1, 1, 'App\\Models\\LifeExam', 1, '2023-03-06 07:43:37', '2023-03-06 07:43:37'),
(14, 'إذا تحرك جسم علي محيط دائرة بسرعة خطية 3.14م/ث فقطع دورة كاملة في ثانيتين يكون نصف قطر الدائرة يساوي:-', 'life_exam', NULL, 'text', 'choice', 40, 'اقراء السؤال بعنايه', 1, 1, 'App\\Models\\LifeExam', 1, '2023-03-06 07:43:37', '2023-03-06 07:43:37'),
(15, ' تقاس القوة في المختبرات بجهاز يسمي:', 'life_exam', NULL, 'text', 'choice', 40, 'اقراء السؤال بعنايه', 1, 1, 'App\\Models\\LifeExam', 1, '2023-03-06 07:43:37', '2023-03-06 07:43:37'),
(16, 'من استخدامات البندول البسيط:', 'life_exam', NULL, 'text', 'choice', 40, 'اقراء السؤال بعنايه', 1, 1, 'App\\Models\\LifeExam', 1, '2023-03-06 07:43:37', '2023-03-06 07:43:37'),
(17, 'كتابة الصورة العشرية أكثر من مرة ستأخذ مساحة كبيرة، وتزيد من احتمال نسيان صفر أو اثنين؛ لذا، عند التعامل مع أعداد صغيرة جدًّا مثل هذه، تُستخدم الصيغة العلمية بدلًا من ذلك.', 'video', NULL, 'text', 'text', 20, 'اقراء السؤال بعنايه', 1, 1, 'App\\Models\\VideoParts', 1, '2023-03-06 07:54:14', '2023-03-06 07:54:15');

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

DROP TABLE IF EXISTS `reports`;
CREATE TABLE IF NOT EXISTS `reports` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `report` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `type` enum('video_resource','video_basic','video_part') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'فيديو شرح اساسيات او فيديو مراجعه او فيديو شرح',
  `video_part_id` bigint UNSIGNED DEFAULT NULL,
  `video_basic_id` bigint UNSIGNED DEFAULT NULL,
  `video_resource_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reports_user_id_foreign` (`user_id`),
  KEY `reports_video_part_id_foreign` (`video_part_id`),
  KEY `reports_video_basic_id_foreign` (`video_basic_id`),
  KEY `reports_video_resource_id_foreign` (`video_resource_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`id`, `report`, `user_id`, `type`, `video_part_id`, `video_basic_id`, `video_resource_id`, `created_at`, `updated_at`) VALUES
(2, 'جزء معادله الحركه دي الناتج طلع غلط مع حضرتك', 1, 'video_part', 1, NULL, NULL, '2023-04-17 10:37:39', '2023-04-17 10:37:39');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(125) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(125) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'سوبر ادمن', 'admin', '2023-04-20 08:34:16', '2023-04-20 08:34:16');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE IF NOT EXISTS `role_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(31, 1),
(31, 2),
(32, 1),
(32, 2),
(33, 1),
(34, 1),
(35, 1),
(36, 1),
(37, 1),
(38, 1),
(38, 2),
(39, 1),
(40, 1),
(41, 1),
(42, 1),
(42, 2),
(43, 1),
(44, 1),
(45, 1),
(46, 1),
(46, 2),
(47, 1),
(48, 1),
(49, 1),
(50, 1),
(51, 1),
(52, 1),
(53, 1),
(54, 1),
(55, 1),
(56, 1),
(57, 1),
(58, 1),
(59, 1),
(60, 1),
(61, 1);

-- --------------------------------------------------------

--
-- Table structure for table `seasons`
--

DROP TABLE IF EXISTS `seasons`;
CREATE TABLE IF NOT EXISTS `seasons` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name_ar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_en` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `seasons`
--

INSERT INTO `seasons` (`id`, `name_ar`, `name_en`, `created_at`, `updated_at`) VALUES
(1, 'الصف الثانوي 1', 'Season 1', '2023-02-23 06:05:54', '2023-02-23 06:05:54'),
(2, 'الصف الثانوي 2', 'Season 2', '2023-02-23 06:05:54', '2023-02-23 06:05:54'),
(3, 'الصف الثانوي 3', 'Season 3', '2023-02-23 06:05:55', '2023-02-23 06:05:55');

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

DROP TABLE IF EXISTS `sections`;
CREATE TABLE IF NOT EXISTS `sections` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `section_name_ar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `section_name_en` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `capacity` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sections`
--

INSERT INTO `sections` (`id`, `section_name_ar`, `section_name_en`, `address`, `capacity`, `created_at`, `updated_at`) VALUES
(1, '1قاعه رقم ', 'Section number 1', 'منوف', 2, '2023-03-01 09:11:03', '2023-03-01 09:11:03'),
(3, '3قاعه رقم ', 'Section number 3', 'الجيزه', 2, '2023-03-01 09:11:03', '2023-03-01 09:11:03'),
(13, '1قاعه رقم ', 'Section number 1', 'القاهره', 2, '2023-03-02 05:38:35', '2023-03-02 05:38:35'),
(14, '2قاعه رقم ', 'Section number 2', 'الاسماعليه', 2, '2023-03-02 05:38:35', '2023-03-02 05:38:35'),
(15, '3قاعه رقم ', 'Section number 3', 'السويس', 2, '2023-03-02 05:38:35', '2023-03-02 05:38:35'),
(16, '4قاعه رقم ', 'Section number 4', 'البحيره', 2, '2023-03-02 05:38:35', '2023-03-02 05:38:35'),
(17, '5قاعه رقم', 'Section number 5', 'الشرقيه', 2, '2023-03-02 05:38:35', '2023-03-28 11:40:36'),
(18, '6قاعه رقم ', 'Section number 6', 'التجمس الخامس', 2, '2023-03-02 05:38:35', '2023-03-02 05:38:35'),
(19, '7قاعه رقم ', 'Section number 7', 'التجمع التالت', 2, '2023-03-02 05:38:35', '2023-03-02 05:38:35'),
(20, '8قاعه رقم ', 'Section number 8', 'شبين الكوم', 2, '2023-03-02 05:38:35', '2023-03-02 05:38:35'),
(21, '9قاعه رقم ', 'Section number 9', 'التجمع التالت', 2, '2023-03-02 05:38:35', '2023-03-02 05:38:35'),
(22, '10قاعه رقم ', 'Section number 10', 'الشيخ زايد', 2, '2023-03-02 05:38:35', '2023-03-02 05:38:35'),
(23, '11قاعه رقم ', 'Section number 11', 'المعادي-صقر قريش', 2, '2023-03-02 05:38:35', '2023-03-02 05:38:35'),
(24, '12قاعه رقم ', 'Section number 12', 'الهرم-الطالبيه', 2, '2023-03-02 05:38:36', '2023-03-02 05:38:36');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
CREATE TABLE IF NOT EXISTS `settings` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `facebook_link` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `youtube_link` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `twitter_link` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `instagram_link` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `website_link` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `videos_resource_active` enum('active','not_active') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'not_active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `facebook_link`, `youtube_link`, `twitter_link`, `instagram_link`, `website_link`, `videos_resource_active`, `created_at`, `updated_at`) VALUES
(2, 'https://www.facebook.com/', 'https://www.youtube.com/', 'https://www.twitter.com/', 'https://www.instagram.com/', 'https://www.booking.com/', 'not_active', '2023-04-17 08:51:59', '2023-04-17 08:51:59');

-- --------------------------------------------------------

--
-- Table structure for table `sliders`
--

DROP TABLE IF EXISTS `sliders`;
CREATE TABLE IF NOT EXISTS `sliders` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `file` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('image','video') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'image',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sliders`
--

INSERT INTO `sliders` (`id`, `file`, `link`, `type`, `created_at`, `updated_at`) VALUES
(1, '1.jpg', 'https://www.facebook.com/', 'image', '2023-03-26 10:49:24', '2023-03-26 10:49:24'),
(2, '2.jpg', 'https://www.facebook.com/', 'image', '2023-03-26 10:49:24', '2023-03-26 10:49:24'),
(3, '3.jpg', 'https://www.facebook.com/', 'image', '2023-03-26 10:49:24', '2023-03-26 10:49:24');

-- --------------------------------------------------------

--
-- Table structure for table `subject_classes`
--

DROP TABLE IF EXISTS `subject_classes`;
CREATE TABLE IF NOT EXISTS `subject_classes` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `title_ar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_en` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name_ar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_en` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `background_color` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#48B8E0',
  `term_id` bigint UNSIGNED DEFAULT NULL,
  `season_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `subject_classes_term_id_foreign` (`term_id`),
  KEY `subject_classes_season_id_foreign` (`season_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subject_classes`
--

INSERT INTO `subject_classes` (`id`, `title_ar`, `title_en`, `name_ar`, `name_en`, `note`, `image`, `background_color`, `term_id`, `season_id`, `created_at`, `updated_at`) VALUES
(1, 'الفصل الاول', 'class one', 'القياسات الفيزيائية', 'Physical measurements', 'الفصل الاول', '1.png', '#48B8E0', 1, 1, '2023-02-23 06:05:55', '2023-02-23 06:05:55'),
(2, 'الفصل التاني', 'class two', 'الكميات القياسية والمتجهة', 'scalar and vector quantities', 'الفصل التاني', '2.png', '#E4312A', 1, 1, '2023-02-23 06:05:55', '2023-02-23 06:05:55'),
(3, 'الفصل التالت', 'class three', 'الحركة في خط مستقيم', 'Movement in a straight line', 'الفصل التالت', '3.png', '#009541', 1, 1, '2023-02-23 06:05:55', '2023-02-23 06:05:55'),
(4, 'الفصل الرابع', 'class four', 'الحركة بعجلة منتظمة', 'Motion with regular acceleration', 'الفصل الرابع', '4.png', '#48B8E0', 1, 1, '2023-02-23 06:05:56', '2023-02-23 06:05:56'),
(5, 'الفصل الخامس', 'class five', 'القوة والحركة', 'force and motion', 'الفصل الخامس', '5.png', '#E4312A', 1, 1, '2023-02-23 06:05:56', '2023-02-23 06:05:56'),
(6, 'الفصل السادس', 'class six', 'قوانين الحركة الدائرية', 'The laws of circular motion', 'الفصل السادس', '6.png', '#009541', 1, 1, '2023-02-23 06:05:56', '2023-02-23 06:05:56');

-- --------------------------------------------------------

--
-- Table structure for table `subscribes`
--

DROP TABLE IF EXISTS `subscribes`;
CREATE TABLE IF NOT EXISTS `subscribes` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `price_in_center` double(10,2) NOT NULL,
  `price_out_center` double(10,2) NOT NULL,
  `month` int NOT NULL,
  `free` enum('yes','no') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no',
  `season_id` bigint UNSIGNED DEFAULT NULL,
  `term_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `year` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `subscribes_season_id_foreign` (`season_id`),
  KEY `subscribes_term_id_foreign` (`term_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subscribes`
--

INSERT INTO `subscribes` (`id`, `price_in_center`, `price_out_center`, `month`, `free`, `season_id`, `term_id`, `created_at`, `updated_at`, `year`) VALUES
(1, 125.00, 200.00, 1, 'no', 1, 1, '2023-03-15 11:51:02', '2023-03-22 11:51:06', '2023'),
(2, 200.00, 300.00, 2, 'no', 1, 1, '2023-03-22 11:51:09', '2023-03-16 11:51:12', '2023');

-- --------------------------------------------------------

--
-- Table structure for table `suggestions`
--

DROP TABLE IF EXISTS `suggestions`;
CREATE TABLE IF NOT EXISTS `suggestions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `suggestion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `type` enum('text','audio','file') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `audio` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `suggestions_user_id_foreign` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suggestions`
--

INSERT INTO `suggestions` (`id`, `suggestion`, `user_id`, `created_at`, `updated_at`, `type`, `image`, `audio`) VALUES
(9, 'يا ريت ننزل امتحان كل اسبوع', 1, '2023-04-05 11:32:46', '2023-04-05 11:32:46', 'text', NULL, NULL),
(11, NULL, 1, '2023-04-05 11:36:28', '2023-04-05 11:36:28', 'text', '20230405133628.jpg', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `terms`
--

DROP TABLE IF EXISTS `terms`;
CREATE TABLE IF NOT EXISTS `terms` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name_ar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_en` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('active','not_active') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `season_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `season_id_constr` (`season_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `terms`
--

INSERT INTO `terms` (`id`, `name_ar`, `name_en`, `note`, `status`, `season_id`, `created_at`, `updated_at`) VALUES
(1, 'الصف الاول الثانوي تيرم اول', 'First year of high school, first term', NULL, 'active', 1, '2023-02-23 06:05:55', '2023-02-23 06:05:55'),
(2, 'الصف الاول الثانوي تيرم تاني', 'First year of high school, second term', NULL, 'not_active', 1, '2023-02-23 06:05:55', '2023-02-23 06:05:55'),
(3, 'الصف الثاني الثانوي تيرم اول', 'Second year secondary school first term', NULL, 'active', 2, '2023-02-23 06:05:55', '2023-02-23 06:05:55'),
(4, 'الصف الثاني الثانوي تيرم تاني', 'Second year secondary school second term', NULL, 'not_active', 2, '2023-02-23 06:05:55', '2023-02-23 06:05:55'),
(5, 'الصف الثالث الثانوي', 'Third year secondary school', NULL, 'active', 3, '2023-02-23 06:05:55', '2023-04-10 07:57:42');

-- --------------------------------------------------------

--
-- Table structure for table `text_exam_users`
--

DROP TABLE IF EXISTS `text_exam_users`;
CREATE TABLE IF NOT EXISTS `text_exam_users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `question_id` bigint UNSIGNED NOT NULL,
  `online_exam_id` bigint UNSIGNED DEFAULT NULL,
  `all_exam_id` bigint UNSIGNED DEFAULT NULL,
  `answer` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `image` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `audio` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `answer_type` enum('text','file','audio') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `degree` int NOT NULL DEFAULT '0',
  `degree_status` enum('completed','un_completed') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'un_completed',
  `status` enum('solved','leave') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `text_exam_users_user_id_foreign` (`user_id`),
  KEY `text_exam_users_question_id_foreign` (`question_id`),
  KEY `text_exam_users_all_exam_id_foreign` (`all_exam_id`),
  KEY `text_exam_users_online_exam_id_foreign` (`online_exam_id`)
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `text_exam_users`
--

INSERT INTO `text_exam_users` (`id`, `user_id`, `question_id`, `online_exam_id`, `all_exam_id`, `answer`, `image`, `audio`, `answer_type`, `degree`, `degree_status`, `status`, `created_at`, `updated_at`) VALUES
(64, 1, 4, 4, NULL, 'اذا كانت السرعه 2m/s فان السرعه سوف تكون عند ال 20 ثانيه هي 5m/s', NULL, NULL, 'text', 10, 'completed', 'solved', '2023-03-18 06:30:11', '2023-04-11 10:51:00'),
(66, 2, 4, 4, NULL, 'اذا كانت السرعه 2m/s فان السرعه سوف تكون عند ال 20 ثانيه هي 5m/s', NULL, NULL, 'text', 10, 'completed', 'solved', '2023-03-18 06:42:56', '2023-03-18 06:42:56'),
(68, 6, 4, 4, NULL, 'اذا كانت السرعه 2m/s فان السرعه سوف تكون عند ال 20 ثانيه هي 5m/s', NULL, NULL, 'text', 10, 'completed', 'solved', '2023-03-18 10:30:15', '2023-03-18 10:30:15'),
(70, 10, 4, 4, NULL, 'اذا كانت السرعه 2m/s فان السرعه سوف تكون عند ال 20 ثانيه هي 5m/s', NULL, NULL, 'text', 10, 'completed', 'solved', '2023-03-18 10:35:14', '2023-03-18 10:35:14'),
(72, 9, 4, 4, NULL, 'اذا كانت السرعه 2m/s فان السرعه سوف تكون عند ال 20 ثانيه هي 5m/s', NULL, NULL, 'text', 10, 'completed', 'solved', '2023-03-18 10:40:59', '2023-03-18 10:40:59'),
(73, 1, 17, 4, NULL, 'يمكِّننا استخدام الصيغة العلمية من كتابة قيم صغيرة جدًّا بطريقة مرتبة. هذه شحنة البروتون معبَّر عنها بالصيغة العلمية:\n𝑞\n=\n1\n.\n6\n×\n1\n0\n.\nﺑ\nﺮ\nو\nﺗ\nﻮ\nن\n\n\n\nC', NULL, NULL, 'text', 10, 'completed', 'solved', '2023-03-18 06:31:11', '2023-04-11 10:51:07'),
(74, 2, 17, 4, NULL, 'يمكِّننا استخدام الصيغة العلمية من كتابة قيم صغيرة جدًّا بطريقة مرتبة. هذه شحنة البروتون معبَّر عنها بالصيغة العلمية:\r\n𝑞\r\n=\r\n1\r\n.\r\n6\r\n×\r\n1\r\n0\r\n.\r\nﺑ\r\nﺮ\r\nو\r\nﺗ\r\nﻮ\r\nن\r\n\r\n\r\n\r\nC', NULL, NULL, 'text', 10, 'completed', 'solved', '2023-03-18 06:30:11', '2023-04-10 12:57:52'),
(75, 6, 17, 4, NULL, 'يمكِّننا استخدام الصيغة العلمية من كتابة قيم صغيرة جدًّا بطريقة مرتبة. هذه شحنة البروتون معبَّر عنها بالصيغة العلمية:\r\n𝑞\r\n=\r\n1\r\n.\r\n6\r\n×\r\n1\r\n0\r\n.\r\nﺑ\r\nﺮ\r\nو\r\nﺗ\r\nﻮ\r\nن\r\n\r\n\r\n\r\nC', NULL, NULL, 'text', 10, 'completed', 'solved', '2023-03-18 06:30:11', '2023-04-10 12:57:52'),
(76, 9, 17, 4, NULL, 'يمكِّننا استخدام الصيغة العلمية من كتابة قيم صغيرة جدًّا بطريقة مرتبة. هذه شحنة البروتون معبَّر عنها بالصيغة العلمية:\r\n𝑞\r\n=\r\n1\r\n.\r\n6\r\n×\r\n1\r\n0\r\n.\r\nﺑ\r\nﺮ\r\nو\r\nﺗ\r\nﻮ\r\nن\r\n\r\n\r\n\r\nC', NULL, NULL, 'text', 10, 'completed', 'solved', '2023-03-18 06:30:11', '2023-04-10 12:57:52'),
(77, 10, 17, 4, NULL, 'يمكِّننا استخدام الصيغة العلمية من كتابة قيم صغيرة جدًّا بطريقة مرتبة. هذه شحنة البروتون معبَّر عنها بالصيغة العلمية:\r\n𝑞\r\n=\r\n1\r\n.\r\n6\r\n×\r\n1\r\n0\r\n.\r\nﺑ\r\nﺮ\r\nو\r\nﺗ\r\nﻮ\r\nن\r\n\r\n\r\n\r\nC', NULL, NULL, 'text', 10, 'completed', 'solved', '2023-03-18 06:30:11', '2023-04-10 12:57:52');

-- --------------------------------------------------------

--
-- Table structure for table `timers`
--

DROP TABLE IF EXISTS `timers`;
CREATE TABLE IF NOT EXISTS `timers` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `online_exam_id` bigint UNSIGNED DEFAULT NULL,
  `all_exam_id` bigint UNSIGNED DEFAULT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `timer` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `timers_online_exam_id_foreign` (`online_exam_id`),
  KEY `timers_all_exam_id_foreign` (`all_exam_id`),
  KEY `timers_user_id_foreign` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `timers`
--

INSERT INTO `timers` (`id`, `online_exam_id`, `all_exam_id`, `user_id`, `timer`, `created_at`, `updated_at`) VALUES
(43, 4, NULL, 1, '10', '2023-03-18 06:29:26', '2023-03-18 06:29:26'),
(44, 4, NULL, 1, '20', '2023-03-18 06:30:11', '2023-03-18 06:30:11'),
(45, 4, NULL, 2, '10', '2023-03-18 06:42:29', '2023-03-18 06:42:29'),
(46, 4, NULL, 2, '10', '2023-03-18 06:42:56', '2023-03-18 06:42:56'),
(47, 4, NULL, 6, '10', '2023-03-18 10:29:57', '2023-03-18 10:29:57'),
(48, 4, NULL, 6, '10', '2023-03-18 10:30:15', '2023-03-18 10:30:15'),
(49, 4, NULL, 10, '10', '2023-03-18 10:34:56', '2023-03-18 10:34:56'),
(50, 4, NULL, 10, '10', '2023-03-18 10:35:14', '2023-03-18 10:35:14'),
(51, 4, NULL, 9, '10', '2023-03-18 10:40:48', '2023-03-18 10:40:48'),
(52, 4, NULL, 9, '10', '2023-03-18 10:40:59', '2023-03-18 10:40:59'),
(53, 2, NULL, 5, '10', '2023-03-18 11:56:14', '2023-03-18 11:56:14'),
(54, 2, NULL, 5, '10', '2023-03-19 05:41:06', '2023-03-19 05:41:06'),
(55, 2, NULL, 1, '10', '2023-03-19 09:16:40', '2023-03-19 09:16:40'),
(56, 2, NULL, 1, '10', '2023-03-19 09:19:10', '2023-03-19 09:19:10'),
(57, 2, NULL, 1, '10', '2023-03-19 09:20:53', '2023-03-19 09:20:53'),
(58, 2, NULL, 1, '10', '2023-03-19 09:21:14', '2023-03-19 09:21:14'),
(59, 2, NULL, 1, '10', '2023-03-20 12:19:43', '2023-03-20 12:19:43'),
(60, 2, NULL, 1, '10', '2023-03-20 12:22:54', '2023-03-20 12:22:54'),
(61, 2, NULL, 1, '10', '2023-03-20 12:25:57', '2023-03-20 12:25:57'),
(62, 2, NULL, 1, '10', '2023-03-20 12:28:31', '2023-03-20 12:28:31'),
(63, 2, NULL, 1, '10', '2023-03-20 12:29:24', '2023-03-20 12:29:24'),
(64, 2, NULL, 1, '10', '2023-03-20 12:32:10', '2023-03-20 12:32:10'),
(65, 2, NULL, 1, '10', '2023-03-20 12:33:34', '2023-03-20 12:33:34'),
(66, 2, NULL, 1, '10', '2023-03-20 12:36:10', '2023-03-20 12:36:10'),
(67, 2, NULL, 1, '10', '2023-03-20 12:38:01', '2023-03-20 12:38:01'),
(68, 2, NULL, 1, '10', '2023-03-20 12:47:31', '2023-03-20 12:47:31'),
(69, 2, NULL, 1, '10', '2023-03-20 12:50:13', '2023-03-20 12:50:13'),
(70, 2, NULL, 1, '10', '2023-03-20 12:50:44', '2023-03-20 12:50:44'),
(71, 2, NULL, 1, '10', '2023-03-21 09:47:23', '2023-03-21 09:47:23'),
(72, 2, NULL, 1, '10', '2023-03-21 09:48:20', '2023-03-21 09:48:20');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `login_status` tinyint(1) NOT NULL DEFAULT '0',
  `season_id` bigint UNSIGNED NOT NULL,
  `country_id` bigint UNSIGNED NOT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `father_phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `center` enum('in','out') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'in',
  `user_status` enum('active','not_active') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_start_code` date NOT NULL COMMENT 'تاريخ بدايه الاشتراك',
  `date_end_code` date NOT NULL COMMENT 'تاريخ نهايه الاشتراك',
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_code_unique` (`code`),
  KEY `users_season_id_foreign` (`season_id`),
  KEY `users_country_id_foreign` (`country_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `login_status`, `season_id`, `country_id`, `phone`, `father_phone`, `image`, `center`, `user_status`, `code`, `date_start_code`, `date_end_code`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'اسلام محمد', 1, 1, 1, '01062933188', '1005717155', '20230312141208.jpg', 'in', 'active', '295', '2022-02-20', '2022-07-20', NULL, NULL, '$2y$10$Xdgyzpdc6owFBmGBCHyqL.0Ivc7XkuH83tcTCOQf4seEAV5Eeu1QS', NULL, '2023-02-23 06:05:55', '2023-04-09 08:23:11'),
(2, 'احمد يحي', 1, 1, 2, '0190439660', '1005717144', 'avatar2.jpg', 'in', 'active', '333', '2022-02-20', '2022-07-20', NULL, NULL, '$2y$10$Xdgyzpdc6owFBmGBCHyqL.0Ivc7XkuH83tcTCOQf4seEAV5Eeu1QS', NULL, '2023-02-23 06:05:55', '2023-04-18 12:50:49'),
(4, 'اسامه عرفه', 0, 1, 6, '0190439699', '1005717133', 'avatar3.jpg', 'in', 'active', '444', '2022-02-20', '2022-07-20', NULL, NULL, '$2y$10$Xdgyzpdc6owFBmGBCHyqL.0Ivc7XkuH83tcTCOQf4seEAV5Eeu1QS', NULL, '2023-02-23 06:05:55', '2023-04-05 12:24:50'),
(5, 'عبدالله دبور', 0, 1, 1, '0190439600', '1005717100', 'avatar3.jpg', 'in', 'active', '2714', '2022-02-20', '2022-07-20', NULL, NULL, '$2y$10$Xdgyzpdc6owFBmGBCHyqL.0Ivc7XkuH83tcTCOQf4seEAV5Eeu1QS', NULL, '2023-02-23 06:05:55', '2023-02-23 06:05:55'),
(6, 'راضي فتح الله', 0, 1, 3, '0190439890', '1005717666', 'avatar3.jpg', 'in', 'active', '2715', '2022-02-20', '2022-07-20', NULL, NULL, '$2y$10$Xdgyzpdc6owFBmGBCHyqL.0Ivc7XkuH83tcTCOQf4seEAV5Eeu1QS', NULL, '2023-02-23 06:05:55', '2023-04-05 12:25:32'),
(8, 'عبدالله حمصي', 0, 1, 1, '0190439880', '1005717660', 'avatar3.jpg', 'in', 'active', '2711', '2022-02-20', '2022-07-20', NULL, NULL, '$2y$10$Xdgyzpdc6owFBmGBCHyqL.0Ivc7XkuH83tcTCOQf4seEAV5Eeu1QS', NULL, '2023-02-23 06:05:55', '2023-02-23 06:05:55'),
(9, 'احمد سعد', 0, 1, 4, '0190439960', '1005717664', 'avatar3.jpg', 'in', 'active', '62734', '2022-02-20', '2022-07-20', NULL, NULL, '$2y$10$Xdgyzpdc6owFBmGBCHyqL.0Ivc7XkuH83tcTCOQf4seEAV5Eeu1QS', NULL, '2023-02-23 06:05:55', '2023-04-05 12:23:42'),
(10, 'علاء محمد', 0, 1, 5, '0190439330', '1005717440', 'avatar3.jpg', 'in', 'active', '9026487', '2022-02-20', '2022-07-20', NULL, NULL, '$2y$10$Xdgyzpdc6owFBmGBCHyqL.0Ivc7XkuH83tcTCOQf4seEAV5Eeu1QS', NULL, '2023-02-23 06:05:55', '2023-02-23 06:05:55'),
(11, 'جمال عبد العزيز', 0, 3, 6, '01062933000', '1005717209', '20230312141208.jpg', 'in', 'active', '8320987', '2022-02-20', '2022-07-20', NULL, NULL, '$2y$10$Xdgyzpdc6owFBmGBCHyqL.0Ivc7XkuH83tcTCOQf4seEAV5Eeu1QS', NULL, '2023-02-23 06:05:55', '2023-03-12 12:12:08'),
(12, 'عبد الله حمصي', 0, 1, 6, '01062933099', '1005717208', '20230312141208.jpg', 'in', 'active', '6666', '2022-02-20', '2022-07-20', NULL, NULL, '$2y$10$Xdgyzpdc6owFBmGBCHyqL.0Ivc7XkuH83tcTCOQf4seEAV5Eeu1QS', NULL, '2023-02-23 06:05:55', '2023-03-12 12:12:08'),
(13, 'عبد الله منصور', 0, 1, 6, '01062933022', '1005717255', '20230312141208.jpg', 'in', 'active', '890890', '2022-02-20', '2022-07-20', NULL, NULL, '$2y$10$Xdgyzpdc6owFBmGBCHyqL.0Ivc7XkuH83tcTCOQf4seEAV5Eeu1QS', NULL, '2023-02-23 06:05:55', '2023-04-05 12:57:44'),
(14, 'شادي محمد', 0, 1, 6, '01062933777', '1005717530', '20230312141208.jpg', 'in', 'active', '11111', '2022-02-20', '2022-07-20', NULL, NULL, '$2y$10$Xdgyzpdc6owFBmGBCHyqL.0Ivc7XkuH83tcTCOQf4seEAV5Eeu1QS', NULL, '2023-02-23 06:05:55', '2023-04-05 12:46:27');

-- --------------------------------------------------------

--
-- Table structure for table `user_screen_shots`
--

DROP TABLE IF EXISTS `user_screen_shots`;
CREATE TABLE IF NOT EXISTS `user_screen_shots` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `count_screen_shots` tinyint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_screen_shots_user_id_foreign` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_subscribes`
--

DROP TABLE IF EXISTS `user_subscribes`;
CREATE TABLE IF NOT EXISTS `user_subscribes` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `price` double(10,2) NOT NULL,
  `month` int NOT NULL,
  `student_id` bigint UNSIGNED DEFAULT NULL,
  `year` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `student_cons` (`student_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_subscribes`
--

INSERT INTO `user_subscribes` (`id`, `price`, `month`, `student_id`, `year`, `created_at`, `updated_at`) VALUES
(1, 125.00, 1, 12, '2023', '2023-03-28 10:16:19', '2023-03-28 10:16:19'),
(2, 200.00, 2, 12, '2023', '2023-03-28 10:16:19', '2023-03-28 10:16:19'),
(3, 125.00, 1, 12, '2023', '2023-03-28 10:31:31', '2023-03-28 10:31:31'),
(4, 200.00, 2, 12, '2023', '2023-03-28 10:31:31', '2023-03-28 10:31:31'),
(5, 125.00, 1, 1, '2023', '2023-03-28 10:37:31', '2023-03-28 10:37:31'),
(6, 200.00, 2, 1, '2023', '2023-03-28 10:37:31', '2023-03-28 10:37:31'),
(7, 125.00, 3, 1, '2023', '2023-03-28 10:40:02', '2023-03-28 10:40:02'),
(8, 200.00, 4, 1, '2023', '2023-03-28 10:40:02', '2023-03-28 10:40:02');

-- --------------------------------------------------------

--
-- Table structure for table `video_basics`
--

DROP TABLE IF EXISTS `video_basics`;
CREATE TABLE IF NOT EXISTS `video_basics` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name_ar` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_en` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `background_color` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#48B8E0',
  `time` int NOT NULL COMMENT 'زمن الفيديو',
  `video_link` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `video_basics`
--

INSERT INTO `video_basics` (`id`, `name_ar`, `name_en`, `background_color`, `time`, `video_link`, `created_at`, `updated_at`) VALUES
(1, 'اساسيات الفيزياء', 'Physics Basic', '#48B8E0', 10, 'v1.mp4', '2023-04-09 12:51:55', '2023-04-09 12:51:55'),
(2, 'معادلات الحركه', 'motion equations', '#E4312A', 10, 'v2.mp4', '2023-04-09 12:51:55', '2023-04-09 12:51:55'),
(3, 'معادلات المقاومه', 'resistance equations', '#009541', 10, 'v3.mp4', '2023-04-09 12:51:55', '2023-04-09 12:51:55'),
(4, 'قوانين البندول', 'Pendulum laws', '#FF9201', 10, 'v4.mp4', '2023-04-09 12:51:55', '2023-04-09 12:51:55'),
(5, 'قوانين الحركه', 'Movement laws', '#4455D7', 10, 'v5.mp4', '2023-04-09 12:51:55', '2023-04-09 12:51:55');

-- --------------------------------------------------------

--
-- Table structure for table `video_basic_pdf_uploads`
--

DROP TABLE IF EXISTS `video_basic_pdf_uploads`;
CREATE TABLE IF NOT EXISTS `video_basic_pdf_uploads` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name_ar` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_en` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pdf_links` json NOT NULL,
  `type` enum('video_basic','video_resource') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `video_basic_id` bigint UNSIGNED DEFAULT NULL,
  `video_resource_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `video_basic_pdf_uploads_video_basic_id_foreign` (`video_basic_id`),
  KEY `video_basic_pdf_uploads_video_resource_id_foreign` (`video_resource_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `video_basic_pdf_uploads`
--

INSERT INTO `video_basic_pdf_uploads` (`id`, `name_ar`, `name_en`, `pdf_links`, `type`, `video_basic_id`, `video_resource_id`, `created_at`, `updated_at`) VALUES
(1, 'مراجعه الفصل الاول يا شباب', 'Check out the first chapter guys', '[\"first.pdf\", \"second.pdf\"]', 'video_resource', NULL, 1, '2023-04-09 13:05:27', '2023-04-09 13:05:27');

-- --------------------------------------------------------

--
-- Table structure for table `video_favorites`
--

DROP TABLE IF EXISTS `video_favorites`;
CREATE TABLE IF NOT EXISTS `video_favorites` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `video_basic_id` bigint UNSIGNED DEFAULT NULL,
  `video_resource_id` bigint UNSIGNED DEFAULT NULL,
  `video_part_id` bigint UNSIGNED DEFAULT NULL,
  `favorite` enum('favorite','un_favorite') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `favorite_type` enum('video_basic','video_resource','video_part') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `video_favorites_user_id_foreign` (`user_id`),
  KEY `video_favorites_video_basic_id_foreign` (`video_basic_id`),
  KEY `video_favorites_video_resource_id_foreign` (`video_resource_id`),
  KEY `video_favorites_video_part_id_foreign` (`video_part_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `video_parts`
--

DROP TABLE IF EXISTS `video_parts`;
CREATE TABLE IF NOT EXISTS `video_parts` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name_ar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name_en` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ordered` int NOT NULL,
  `note` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `lesson_id` bigint UNSIGNED NOT NULL,
  `link` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('video','pdf','audio') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `video_time` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `month` tinyint DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `video_parts_lesson_id_foreign` (`lesson_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `video_parts`
--

INSERT INTO `video_parts` (`id`, `name_ar`, `name_en`, `ordered`, `note`, `lesson_id`, `link`, `type`, `video_time`, `created_at`, `updated_at`, `month`) VALUES
(1, 'فيديو شرح الليزر', 'lizar description', 1, 'يرجي متابعه جزء المعادلات جيدا', 1, 'v1.mp4', 'video', '10', '2023-02-26 09:13:32', '2023-02-26 09:13:32', 4),
(2, 'فيديو شرح الليزر الجزء التاني', 'lizar 2 description', 2, 'يرجي متابعه جزء معادله الحركه جيدا', 1, 'v2.mp4', 'video', '15', '2023-02-26 09:13:32', '2023-02-26 09:13:32', 4),
(3, 'فيديو شرح الليزر الجزء التالت', 'lizar 3 description', 3, 'يرجي متابعه جزء معادله الجسم جيدا', 1, 'v3.mp4', 'video', '10', '2023-02-26 09:13:32', '2023-02-26 09:13:32', 4),
(4, 'شرح جزء الليزر بالكامل', 'lizar all description', 4, 'يرجي متابعه جزء معادله الجسم جيدا', 1, 'pd.pdf', 'pdf', NULL, '2023-02-26 09:13:32', '2023-02-26 09:13:32', 4),
(5, 'جزء مقلتوش في الليزر', 'A part that was not covered in the laser', 5, 'يرجي متابعه جزء معادله الجسم جيدا', 1, 'au.ogg', 'audio', NULL, '2023-02-26 09:13:32', '2023-02-26 09:13:32', 4),
(6, 'فيديو المعادله الحركيه', 'Kinematic equation video', 1, 'يرجي متابعه جزء المعادلات جيدا', 2, 'v2.mp4', 'video', '10', '2023-02-26 09:13:32', '2023-02-26 09:13:32', 4);

-- --------------------------------------------------------

--
-- Table structure for table `video_rates`
--

DROP TABLE IF EXISTS `video_rates`;
CREATE TABLE IF NOT EXISTS `video_rates` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `video_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `action` enum('like','dislike','no_rate') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `video_rates_user_id_foreign` (`user_id`),
  KEY `video_rates_video_id_foreign` (`video_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `video_rates`
--

INSERT INTO `video_rates` (`id`, `video_id`, `user_id`, `action`, `created_at`, `updated_at`) VALUES
(3, 1, 1, 'like', '2023-04-03 09:07:31', '2023-04-03 09:08:12');

-- --------------------------------------------------------

--
-- Table structure for table `video_resources`
--

DROP TABLE IF EXISTS `video_resources`;
CREATE TABLE IF NOT EXISTS `video_resources` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name_ar` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_en` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `background_color` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#48B8E0',
  `time` int DEFAULT NULL COMMENT 'زمن الفيديو',
  `video_link` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `type` enum('video','pdf') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'video',
  `pdf_file` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `season_id` bigint UNSIGNED NOT NULL,
  `term_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `video_resources_season_id_foreign` (`season_id`),
  KEY `video_resources_term_id_foreign` (`term_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `video_resources`
--

INSERT INTO `video_resources` (`id`, `name_ar`, `name_en`, `image`, `background_color`, `time`, `video_link`, `type`, `pdf_file`, `season_id`, `term_id`, `created_at`, `updated_at`) VALUES
(1, 'مراجعه شامله علي الفصل الاول', 'Comprehensive review on the first chapter', '1.png', '#48B8E0', 10, 'v1.mp4', 'video', NULL, 1, 1, '2023-04-09 12:52:12', '2023-04-09 12:52:12'),
(2, 'مراجعه شامله علي الفصل الثاني', 'Comprehensive review on the second chapter', '2.png', '#E4312A', 10, 'v2.mp4', 'video', NULL, 1, 1, '2023-04-09 12:52:12', '2023-04-09 12:52:12'),
(3, 'مراجعه شامله علي الفصل الثالث', 'Comprehensive review on the third chapter', '3.png', '#009541', 10, 'v3.mp4', 'video', NULL, 1, 1, '2023-04-09 12:52:12', '2023-04-09 12:52:12'),
(4, 'مراجعه شامله علي الفصل الرابع', 'Comprehensive review on the fourth chapter', '4.png', '#FF9201', 10, 'v4.mp4', 'video', NULL, 1, 1, '2023-04-09 12:52:12', '2023-04-09 12:52:12'),
(5, 'مراجعه شامله علي الفصل الخامس', 'Comprehensive review on the five chapter', '5.png', '#4455D7', 10, 'v5.mp4', 'video', NULL, 1, 1, '2023-04-09 12:52:12', '2023-04-09 12:52:12'),
(6, 'مراجعه شامله علي الفصل السادس', 'Comprehensive review on the six chapter', '6.png', '#009541', NULL, '', 'pdf', '1.pdf', 1, 1, '2023-04-09 12:52:12', '2023-04-09 12:52:12');

-- --------------------------------------------------------

--
-- Table structure for table `video_watches`
--

DROP TABLE IF EXISTS `video_watches`;
CREATE TABLE IF NOT EXISTS `video_watches` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `video_part_id` bigint UNSIGNED NOT NULL,
  `status` enum('opened','watched') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `video_watches_user_id_foreign` (`user_id`),
  KEY `video_watches_video_part_id_foreign` (`video_part_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `video_watches`
--

INSERT INTO `video_watches` (`id`, `user_id`, `video_part_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'watched', '2023-04-16 08:58:28', '2023-04-16 08:58:42'),
(2, 1, 2, 'watched', '2023-04-16 08:58:42', '2023-04-16 09:23:23'),
(3, 1, 3, 'watched', '2023-04-16 09:23:23', '2023-04-16 09:23:26'),
(4, 1, 4, 'watched', '2023-04-16 09:23:26', '2023-04-16 09:23:26'),
(5, 1, 5, 'watched', '2023-04-16 09:23:27', '2023-04-16 09:23:27'),
(6, 2, 1, 'watched', '2023-04-18 12:51:45', '2023-04-18 12:52:05'),
(7, 2, 2, 'opened', '2023-04-18 12:52:05', '2023-04-18 12:52:05');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `all_exams`
--
ALTER TABLE `all_exams`
  ADD CONSTRAINT `all_exams_season_id_foreign` FOREIGN KEY (`season_id`) REFERENCES `seasons` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `all_exams_term_id_foreign` FOREIGN KEY (`term_id`) REFERENCES `terms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `answers`
--
ALTER TABLE `answers`
  ADD CONSTRAINT `answers_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_video_basic_id_foreign` FOREIGN KEY (`video_basic_id`) REFERENCES `video_basics` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_video_part_id_foreign` FOREIGN KEY (`video_part_id`) REFERENCES `video_parts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_video_resource_id_foreign` FOREIGN KEY (`video_resource_id`) REFERENCES `video_resources` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `comment_replays`
--
ALTER TABLE `comment_replays`
  ADD CONSTRAINT `comment_replays_comment_id_foreign` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_replays_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_replays_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `countries`
--
ALTER TABLE `countries`
  ADD CONSTRAINT `city_id_cons` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `degrees`
--
ALTER TABLE `degrees`
  ADD CONSTRAINT `degrees_all_exam_id_foreign` FOREIGN KEY (`all_exam_id`) REFERENCES `all_exams` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `degrees_online_exam_id_foreign` FOREIGN KEY (`online_exam_id`) REFERENCES `online_exams` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `degrees_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `degrees_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `life_exam_cons_2` FOREIGN KEY (`life_exam_id`) REFERENCES `life_exams` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `exam_degree_depends`
--
ALTER TABLE `exam_degree_depends`
  ADD CONSTRAINT `exam_degree_depends_all_exam_id_foreign` FOREIGN KEY (`all_exam_id`) REFERENCES `all_exams` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `exam_degree_depends_online_exam_id_foreign` FOREIGN KEY (`online_exam_id`) REFERENCES `online_exams` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `exam_degree_depends_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `life_exam_cons_5` FOREIGN KEY (`life_exam_id`) REFERENCES `life_exams` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `exam_instructions`
--
ALTER TABLE `exam_instructions`
  ADD CONSTRAINT `full_exam` FOREIGN KEY (`online_exam_id`) REFERENCES `online_exams` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `online` FOREIGN KEY (`all_exam_id`) REFERENCES `all_exams` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `guides`
--
ALTER TABLE `guides`
  ADD CONSTRAINT `guides_season_id_foreign` FOREIGN KEY (`season_id`) REFERENCES `seasons` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `guides_term_id_foreign` FOREIGN KEY (`term_id`) REFERENCES `terms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `lessons`
--
ALTER TABLE `lessons`
  ADD CONSTRAINT `lessons_subject_class_id_foreign` FOREIGN KEY (`subject_class_id`) REFERENCES `subject_classes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `life_exams`
--
ALTER TABLE `life_exams`
  ADD CONSTRAINT `life_exams_season_id_foreign` FOREIGN KEY (`season_id`) REFERENCES `seasons` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `life_exams_term_id_foreign` FOREIGN KEY (`term_id`) REFERENCES `terms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `monthly_plans`
--
ALTER TABLE `monthly_plans`
  ADD CONSTRAINT `monthly_plans_season_id_foreign` FOREIGN KEY (`season_id`) REFERENCES `seasons` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `monthly_plans_term_id_foreign` FOREIGN KEY (`term_id`) REFERENCES `terms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_season_id_foreign` FOREIGN KEY (`season_id`) REFERENCES `seasons` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `notifications_term_id_foreign` FOREIGN KEY (`term_id`) REFERENCES `terms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `online_exams`
--
ALTER TABLE `online_exams`
  ADD CONSTRAINT `class_id_cons` FOREIGN KEY (`class_id`) REFERENCES `subject_classes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `lesson_id_const` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `online_exams_season_id_foreign` FOREIGN KEY (`season_id`) REFERENCES `seasons` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `online_exams_term_id_foreign` FOREIGN KEY (`term_id`) REFERENCES `terms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `video_id_const` FOREIGN KEY (`video_id`) REFERENCES `video_parts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `online_exam_questions`
--
ALTER TABLE `online_exam_questions`
  ADD CONSTRAINT `life_exam_cons_3` FOREIGN KEY (`life_exam_id`) REFERENCES `life_exams` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `online_exam_questions_all_exam_id_foreign` FOREIGN KEY (`all_exam_id`) REFERENCES `all_exams` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `online_exam_questions_online_exam_id_foreign` FOREIGN KEY (`online_exam_id`) REFERENCES `online_exams` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `online_exam_questions_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `online_exam_users`
--
ALTER TABLE `online_exam_users`
  ADD CONSTRAINT `life_exam_cons_1` FOREIGN KEY (`life_exam_id`) REFERENCES `life_exams` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `online_exam_users_all_exam_id_foreign` FOREIGN KEY (`all_exam_id`) REFERENCES `all_exams` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `online_exam_users_answer_id_foreign` FOREIGN KEY (`answer_id`) REFERENCES `answers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `online_exam_users_online_exam_id_foreign` FOREIGN KEY (`online_exam_id`) REFERENCES `online_exams` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `online_exam_users_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `online_exam_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `open_lessons`
--
ALTER TABLE `open_lessons`
  ADD CONSTRAINT `open_lessons_lesson_id_foreign` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `open_lessons_subject_class_id_foreign` FOREIGN KEY (`subject_class_id`) REFERENCES `subject_classes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `open_lessons_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `papel_sheet_exams`
--
ALTER TABLE `papel_sheet_exams`
  ADD CONSTRAINT `papel_sheet_exams_season_id_foreign` FOREIGN KEY (`season_id`) REFERENCES `seasons` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `papel_sheet_exams_term_id_foreign` FOREIGN KEY (`term_id`) REFERENCES `terms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `papel_sheet_exam_degrees`
--
ALTER TABLE `papel_sheet_exam_degrees`
  ADD CONSTRAINT `papel_sheet_exam_degrees_papel_sheet_exam_id_foreign` FOREIGN KEY (`papel_sheet_exam_id`) REFERENCES `papel_sheet_exams` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `papel_sheet_exam_degrees_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `papel_sheet_exam_times`
--
ALTER TABLE `papel_sheet_exam_times`
  ADD CONSTRAINT `papel_sheet_exam_times_papel_sheet_exam_id_foreign` FOREIGN KEY (`papel_sheet_exam_id`) REFERENCES `papel_sheet_exams` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `papel_sheet_exam_users`
--
ALTER TABLE `papel_sheet_exam_users`
  ADD CONSTRAINT `papel_sheet_exam_users_papel_sheet_exam_id_foreign` FOREIGN KEY (`papel_sheet_exam_id`) REFERENCES `papel_sheet_exams` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `papel_sheet_exam_users_papel_sheet_exam_time_id_foreign` FOREIGN KEY (`papel_sheet_exam_time_id`) REFERENCES `papel_sheet_exam_times` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `section_cons` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_cons` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `phone_tokens`
--
ALTER TABLE `phone_tokens`
  ADD CONSTRAINT `phone_tokens_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_season_id_foreign` FOREIGN KEY (`season_id`) REFERENCES `seasons` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `questions_term_id_foreign` FOREIGN KEY (`term_id`) REFERENCES `terms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reports_video_basic_id_foreign` FOREIGN KEY (`video_basic_id`) REFERENCES `video_basics` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reports_video_part_id_foreign` FOREIGN KEY (`video_part_id`) REFERENCES `video_parts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reports_video_resource_id_foreign` FOREIGN KEY (`video_resource_id`) REFERENCES `video_resources` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `subject_classes`
--
ALTER TABLE `subject_classes`
  ADD CONSTRAINT `subject_classes_season_id_foreign` FOREIGN KEY (`season_id`) REFERENCES `seasons` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `subject_classes_term_id_foreign` FOREIGN KEY (`term_id`) REFERENCES `terms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `subscribes`
--
ALTER TABLE `subscribes`
  ADD CONSTRAINT `subscribes_season_id_foreign` FOREIGN KEY (`season_id`) REFERENCES `seasons` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `subscribes_term_id_foreign` FOREIGN KEY (`term_id`) REFERENCES `terms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `suggestions`
--
ALTER TABLE `suggestions`
  ADD CONSTRAINT `suggestions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `terms`
--
ALTER TABLE `terms`
  ADD CONSTRAINT `season_id_constr` FOREIGN KEY (`season_id`) REFERENCES `seasons` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `text_exam_users`
--
ALTER TABLE `text_exam_users`
  ADD CONSTRAINT `text_exam_users_all_exam_id_foreign` FOREIGN KEY (`all_exam_id`) REFERENCES `all_exams` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `text_exam_users_online_exam_id_foreign` FOREIGN KEY (`online_exam_id`) REFERENCES `online_exams` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `text_exam_users_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `text_exam_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `timers`
--
ALTER TABLE `timers`
  ADD CONSTRAINT `timers_all_exam_id_foreign` FOREIGN KEY (`all_exam_id`) REFERENCES `all_exams` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `timers_online_exam_id_foreign` FOREIGN KEY (`online_exam_id`) REFERENCES `online_exams` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `timers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `users_season_id_foreign` FOREIGN KEY (`season_id`) REFERENCES `seasons` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_screen_shots`
--
ALTER TABLE `user_screen_shots`
  ADD CONSTRAINT `user_screen_shots_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_subscribes`
--
ALTER TABLE `user_subscribes`
  ADD CONSTRAINT `student_cons` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `video_basic_pdf_uploads`
--
ALTER TABLE `video_basic_pdf_uploads`
  ADD CONSTRAINT `video_basic_pdf_uploads_video_basic_id_foreign` FOREIGN KEY (`video_basic_id`) REFERENCES `video_basics` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `video_basic_pdf_uploads_video_resource_id_foreign` FOREIGN KEY (`video_resource_id`) REFERENCES `video_resources` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `video_favorites`
--
ALTER TABLE `video_favorites`
  ADD CONSTRAINT `video_favorites_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `video_favorites_video_basic_id_foreign` FOREIGN KEY (`video_basic_id`) REFERENCES `video_basics` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `video_favorites_video_part_id_foreign` FOREIGN KEY (`video_part_id`) REFERENCES `video_parts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `video_favorites_video_resource_id_foreign` FOREIGN KEY (`video_resource_id`) REFERENCES `video_resources` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `video_parts`
--
ALTER TABLE `video_parts`
  ADD CONSTRAINT `video_parts_lesson_id_foreign` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `video_rates`
--
ALTER TABLE `video_rates`
  ADD CONSTRAINT `video_rates_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `video_rates_video_id_foreign` FOREIGN KEY (`video_id`) REFERENCES `video_parts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `video_resources`
--
ALTER TABLE `video_resources`
  ADD CONSTRAINT `video_resources_season_id_foreign` FOREIGN KEY (`season_id`) REFERENCES `seasons` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `video_resources_term_id_foreign` FOREIGN KEY (`term_id`) REFERENCES `terms` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `video_watches`
--
ALTER TABLE `video_watches`
  ADD CONSTRAINT `video_watches_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `video_watches_video_part_id_foreign` FOREIGN KEY (`video_part_id`) REFERENCES `video_parts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
