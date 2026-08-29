-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 28, 2026 at 05:53 PM
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
-- Database: `novadrop`
--

-- --------------------------------------------------------

--
-- Table structure for table `abandoned_cart_log`
--

CREATE TABLE `abandoned_cart_log` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cart_id` char(36) NOT NULL,
  `step_id` int(10) UNSIGNED NOT NULL,
  `sent_at` datetime DEFAULT NULL,
  `status` enum('pending','sent','failed','converted') NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `abandoned_cart_log`
--

INSERT INTO `abandoned_cart_log` (`id`, `cart_id`, `step_id`, `sent_at`, `status`) VALUES
(1, 'test-cart-6a858f5c388c0', 1, '2026-08-19 16:41:24', 'sent'),
(2, 'test-cart-6a858f7630725', 1, '2026-08-19 16:41:50', 'sent'),
(3, 'b0ac54eb-4c55-436f-a4a2-e4fcb92bc639', 1, '2026-08-19 16:47:11', 'sent'),
(4, 'b78dacec-3cb2-4649-9667-64ed9a745dc9', 1, '2026-08-25 21:56:57', 'sent'),
(5, 'e48063bd-68f8-47b2-9bc5-76d65643e044', 1, '2026-08-25 21:56:57', 'sent'),
(6, 'f047d48d-4699-4f5d-8ee6-ac5b1c5bc4f3', 1, '2026-08-25 21:56:57', 'sent'),
(7, 'b78dacec-3cb2-4649-9667-64ed9a745dc9', 4, '2026-08-25 21:57:23', 'sent'),
(8, 'e48063bd-68f8-47b2-9bc5-76d65643e044', 4, '2026-08-25 21:57:23', 'sent'),
(9, 'f047d48d-4699-4f5d-8ee6-ac5b1c5bc4f3', 4, '2026-08-25 21:57:23', 'sent'),
(10, 'e48063bd-68f8-47b2-9bc5-76d65643e044', 2, '2026-08-25 21:57:54', 'sent'),
(11, 'e48063bd-68f8-47b2-9bc5-76d65643e044', 5, '2026-08-25 21:58:10', 'sent'),
(12, 'e48063bd-68f8-47b2-9bc5-76d65643e044', 3, '2026-08-25 21:58:10', 'sent'),
(13, 'e48063bd-68f8-47b2-9bc5-76d65643e044', 6, '2026-08-25 21:58:37', 'sent'),
(14, 'f047d48d-4699-4f5d-8ee6-ac5b1c5bc4f3', 2, '2026-08-26 21:31:04', 'sent');

-- --------------------------------------------------------

--
-- Table structure for table `abandoned_cart_sequences`
--

CREATE TABLE `abandoned_cart_sequences` (
  `id` int(10) UNSIGNED NOT NULL,
  `store_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(120) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `abandoned_cart_sequences`
--

INSERT INTO `abandoned_cart_sequences` (`id`, `store_id`, `name`, `is_active`) VALUES
(1, 1, 'Default Recovery', 1);

-- --------------------------------------------------------

--
-- Table structure for table `abandoned_cart_steps`
--

CREATE TABLE `abandoned_cart_steps` (
  `id` int(10) UNSIGNED NOT NULL,
  `sequence_id` int(10) UNSIGNED NOT NULL,
  `delay_minutes` int(11) NOT NULL DEFAULT 60,
  `channel` enum('email','whatsapp','sms') NOT NULL DEFAULT 'email',
  `template_key` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `abandoned_cart_steps`
--

INSERT INTO `abandoned_cart_steps` (`id`, `sequence_id`, `delay_minutes`, `channel`, `template_key`) VALUES
(1, 1, 60, 'email', 'abandoned_cart_1'),
(2, 1, 1440, 'email', 'abandoned_cart_2'),
(3, 1, 4320, 'email', 'abandoned_cart_3'),
(4, 1, 60, 'email', 'abandoned_cart_1'),
(5, 1, 1440, 'email', 'abandoned_cart_2'),
(6, 1, 4320, 'email', 'abandoned_cart_3');

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `id` int(10) UNSIGNED NOT NULL,
  `store_id` int(10) UNSIGNED NOT NULL,
  `customer_id` int(10) UNSIGNED DEFAULT NULL,
  `first_name` varchar(80) NOT NULL,
  `last_name` varchar(80) NOT NULL,
  `company` varchar(120) DEFAULT NULL,
  `address1` varchar(255) NOT NULL,
  `address2` varchar(255) DEFAULT NULL,
  `city` varchar(80) NOT NULL,
  `state` varchar(80) NOT NULL,
  `pincode` varchar(10) NOT NULL,
  `country` char(2) NOT NULL DEFAULT 'IN',
  `phone` varchar(20) DEFAULT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`id`, `store_id`, `customer_id`, `first_name`, `last_name`, `company`, `address1`, `address2`, `city`, `state`, `pincode`, `country`, `phone`, `is_default`, `created_at`) VALUES
(1, 1, NULL, 'Asmit', 'Uniyal', NULL, 'NG Suncity Phase 2', NULL, 'Mumbai', 'Maharashtra', '400101', 'IN', '9702359244', 0, '2026-08-19 18:58:41'),
(2, 1, NULL, 'Asmit', 'Uniyal', NULL, 'NG Suncity Phase 2', NULL, 'Mumbai', 'Maharashtra', '400101', 'IN', '9702359244', 0, '2026-08-19 19:01:35'),
(3, 1, NULL, 'Asmit', 'Uniyal', NULL, 'NG Suncity Phase 2', NULL, 'Mumbai', 'Maharashtra', '400101', 'IN', '9702359244', 0, '2026-08-19 19:01:48'),
(4, 1, NULL, 'Asmit', 'Uniyal', NULL, 'NG Suncity Phase 2', NULL, 'Mumbai', 'State', '400101', 'IN', '9702359244', 0, '2026-08-26 18:12:09'),
(5, 1, NULL, 'Asmit', 'Uniyal', NULL, 'NG Suncity Phase 2', NULL, 'Mumbai', 'State', '400101', 'IN', '9702359244', 0, '2026-08-26 18:35:01');

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `admid` varchar(64) NOT NULL,
  `astat` varchar(30) DEFAULT 'admin',
  `perm` varchar(30) DEFAULT 'admin',
  `name` varchar(150) DEFAULT 'Administrator',
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `date` datetime DEFAULT current_timestamp(),
  `adate` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `admid`, `astat`, `perm`, `name`, `username`, `password`, `date`, `adate`) VALUES
(1, '67ac7cf58dfc4', 'madmin', 'admin', 'Administrator', 'admin', '$2y$10$dlmK0kr6D2liuiaSzthOhuheuPy6z/f8VnaM4WsoKfGLQ64eyJWae', '2026-08-19 14:27:08', '2026-08-28 16:35:49');

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int(10) UNSIGNED NOT NULL,
  `store_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(120) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `totp_secret` varchar(80) DEFAULT NULL,
  `totp_enabled` tinyint(1) NOT NULL DEFAULT 0,
  `last_login_at` datetime DEFAULT NULL,
  `last_login_ip` varchar(45) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`id`, `store_id`, `role_id`, `name`, `email`, `password_hash`, `totp_secret`, `totp_enabled`, `last_login_at`, `last_login_ip`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Super Admin', 'admin@novadrop.in', '$2y$10$Pzozop8umo1EyUKK5ikZf.OfhgokYKQ.17ITuc6Rjf2GnyDT0Dxu6', NULL, 0, '2026-08-19 10:31:46', '::1', 1, '2026-08-19 11:35:28', '2026-08-25 22:15:51');

-- --------------------------------------------------------

--
-- Table structure for table `ad_campaigns`
--

CREATE TABLE `ad_campaigns` (
  `id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT 1,
  `product_id` int(11) NOT NULL,
  `platform` varchar(50) DEFAULT 'Meta Instagram',
  `angle` varchar(100) DEFAULT 'Luxury Aesthetic',
  `headline` varchar(255) NOT NULL,
  `primary_text` text NOT NULL,
  `target_audience` varchar(255) DEFAULT 'High-Net-Worth Fashion Lovers 22-45',
  `est_roas` decimal(4,2) DEFAULT 4.20,
  `status` enum('active','draft','paused') DEFAULT 'active',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `affiliate_payouts`
--

CREATE TABLE `affiliate_payouts` (
  `id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT 1,
  `referrer_id` int(11) NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `method` varchar(50) DEFAULT 'bank',
  `status` enum('pending','approved','paid','rejected') DEFAULT 'pending',
  `note` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ai_agent_tasks`
--

CREATE TABLE `ai_agent_tasks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `store_id` int(10) UNSIGNED DEFAULT NULL,
  `agent` varchar(60) NOT NULL,
  `input_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`input_json`)),
  `output_text` longtext DEFAULT NULL,
  `status` enum('pending','running','done','failed','awaiting_approval') NOT NULL DEFAULT 'pending',
  `approved_by` int(10) UNSIGNED DEFAULT NULL,
  `approved_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ai_agent_tasks`
--

INSERT INTO `ai_agent_tasks` (`id`, `store_id`, `agent`, `input_json`, `output_text`, `status`, `approved_by`, `approved_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'seo_content_generator', '{\"collection\":\"Ergonomic Desks\",\"slug\":\"buyers-guide-ergonomic-desks-2026\",\"title\":\"The Ultimate 2026 Buyer\'s Guide to Ergonomic Desks: Ergonomics, Durability & Performance\",\"schema\":{\"@context\":\"https:\\/\\/schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Ergonomic Desks products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}}', '<div class=\'seo-buyers-guide\'><h2>Why Quality Matters in Ergonomic Desks</h2><p>Choosing the right gear isn\'t just about aesthetics — it directly impacts your daily stamina, comfort, and productivity. In this guide, our engineering and ergonomics team breaks down the key factors to evaluate before investing.</p><h3>Top Recommended Options:</h3><div class=\'product-comparison-grid\'><div class=\'comparison-item\'><h4>AeroWave Pro Active Noise Cancelling Headphones (₹2,499.00)</h4><p>Custom 40mm dynamic drivers deliver pristine acoustic clarity and deep bass....</p></div></div><h3>Frequently Asked Questions</h3><div class=\'faq-accordion\'><div class=\'faq-q\'><strong>Q: What warranty is included?</strong><p>A: Full 1-year replacement warranty and 7-day returns.</p></div></div><script type=\'application/ld+json\'>{\"@context\":\"https://schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Ergonomic Desks products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}</script></div>', 'done', NULL, NULL, '2026-08-19 18:51:48', '2026-08-19 18:51:48'),
(2, 1, 'seo_content_generator', '{\"collection\":\"Pro Audio & ANC\",\"slug\":\"buyers-guide-pro-audio-anc-2026\",\"title\":\"The Ultimate 2026 Buyer\'s Guide to Pro Audio & ANC: Ergonomics, Durability & Performance\",\"schema\":{\"@context\":\"https:\\/\\/schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Pro Audio & ANC products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}}', '<div class=\'seo-buyers-guide\'><h2>Why Quality Matters in Pro Audio & ANC</h2><p>Choosing the right gear isn\'t just about aesthetics — it directly impacts your daily stamina, comfort, and productivity. In this guide, our engineering and ergonomics team breaks down the key factors to evaluate before investing.</p><h3>Top Recommended Options:</h3><div class=\'product-comparison-grid\'><div class=\'comparison-item\'><h4>Minimalist Chronograph Matte Black Watch (₹1,899.00)</h4><p>Sleek Scandinavian design meets precision Japanese quartz movement. Built with surgical-grade 316L stainless steel, sapphire crystal glass, ...</p></div><div class=\'comparison-item\'><h4>Urban Canvas Waterproof Commuter Backpack (₹1,599.00)</h4><p>Engineered for modern commuters. Features a dedicated 16&quot; padded laptop sleeve, hidden anti-theft pockets, waterproof zippers, and ergonomic...</p></div></div><h3>Frequently Asked Questions</h3><div class=\'faq-accordion\'><div class=\'faq-q\'><strong>Q: What warranty is included?</strong><p>A: Full 1-year replacement warranty and 7-day returns.</p></div></div><script type=\'application/ld+json\'>{\"@context\":\"https://schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Pro Audio & ANC products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}</script></div>', 'done', NULL, NULL, '2026-08-19 18:51:48', '2026-08-19 18:51:48'),
(3, 1, 'seo_content_generator', '{\"collection\":\"Workstation Lights\",\"slug\":\"buyers-guide-workstation-lights-2026\",\"title\":\"The Ultimate 2026 Buyer\'s Guide to Workstation Lights: Ergonomics, Durability & Performance\",\"schema\":{\"@context\":\"https:\\/\\/schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Workstation Lights products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}}', '<div class=\'seo-buyers-guide\'><h2>Why Quality Matters in Workstation Lights</h2><p>Choosing the right gear isn\'t just about aesthetics — it directly impacts your daily stamina, comfort, and productivity. In this guide, our engineering and ergonomics team breaks down the key factors to evaluate before investing.</p><h3>Top Recommended Options:</h3><div class=\'product-comparison-grid\'><div class=\'comparison-item\'><h4>Smart Ambient RGB Desk Atmosphere Lamp (₹1,299.00)</h4><p>Transform your workspace with 16 million colors, music sync visualization, and custom sunrise alarm schedules. Control seamlessly via app or...</p></div></div><h3>Frequently Asked Questions</h3><div class=\'faq-accordion\'><div class=\'faq-q\'><strong>Q: What warranty is included?</strong><p>A: Full 1-year replacement warranty and 7-day returns.</p></div></div><script type=\'application/ld+json\'>{\"@context\":\"https://schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Workstation Lights products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}</script></div>', 'done', NULL, NULL, '2026-08-19 18:51:48', '2026-08-19 18:51:48'),
(4, 1, 'daily_digest', '{\"gross_revenue\":0,\"orders_count\":0,\"aov\":0,\"low_stock_count\":0,\"failed_payments\":0,\"top_skus\":[]}', '📊 NovaDrop Daily Executive Digest [19 Aug 2026]:\n• Gross GMV: ₹0.00 across 0 orders (AOV: ₹0.00)\n• Estimated Net Profit: ₹0.00 (Margin ~62.6%)\n• Top Products: No items sold yet today.\n• Critical Low-Stock SKUs: 0 items\n• Failed Payment Alerts: 0', 'done', NULL, NULL, '2026-08-19 18:51:48', '2026-08-19 18:51:48'),
(5, 1, 'finance_reconciliation', '{\"audited_count\":4,\"total_revenue\":12028.92,\"mismatches_count\":4,\"mismatches\":[{\"order_id\":1,\"order_number\":\"#ND-1001\",\"type\":\"UNDERPAYMENT_OR_UNMATCHED_GATEWAY_RECORD\",\"order_total\":2948.82,\"captured\":0,\"variance\":2948.82},{\"order_id\":2,\"order_number\":\"#ND-1002\",\"type\":\"UNDERPAYMENT_OR_UNMATCHED_GATEWAY_RECORD\",\"order_total\":2240.82,\"captured\":0,\"variance\":2240.82},{\"order_id\":3,\"order_number\":\"#ND-1003\",\"type\":\"UNDERPAYMENT_OR_UNMATCHED_GATEWAY_RECORD\",\"order_total\":3065.64,\"captured\":0,\"variance\":3065.64},{\"order_id\":4,\"order_number\":\"#ND-1004\",\"type\":\"UNDERPAYMENT_OR_UNMATCHED_GATEWAY_RECORD\",\"order_total\":3773.64,\"captured\":0,\"variance\":3773.64}],\"reconciliation_code\":\"MISMATCH_DETECTED\"}', '💰 Finance Reconciliation Statement [19 Aug 2026]:\n• Orders Audited: 4 (Total Value: ₹12,028.92)\n• Mismatches / Leaks: 4\n• Total Variance Delta: ₹12,028.92\n• Reconciliation Status: MISMATCH_DETECTED', 'done', NULL, NULL, '2026-08-19 18:51:48', '2026-08-19 18:51:48'),
(6, 1, 'seo_content_generator', '{\"collection\":\"Ergonomic Desks\",\"slug\":\"buyers-guide-ergonomic-desks-2026\",\"title\":\"The Ultimate 2026 Buyer\'s Guide to Ergonomic Desks: Ergonomics, Durability & Performance\",\"schema\":{\"@context\":\"https:\\/\\/schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Ergonomic Desks products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}}', '<div class=\'seo-buyers-guide\'><h2>Why Quality Matters in Ergonomic Desks</h2><p>Choosing the right gear isn\'t just about aesthetics — it directly impacts your daily stamina, comfort, and productivity. In this guide, our engineering and ergonomics team breaks down the key factors to evaluate before investing.</p><h3>Top Recommended Options:</h3><div class=\'product-comparison-grid\'><div class=\'comparison-item\'><h4>AeroWave Pro Active Noise Cancelling Headphones (₹2,499.00)</h4><p>Custom 40mm dynamic drivers deliver pristine acoustic clarity and deep bass....</p></div></div><h3>Frequently Asked Questions</h3><div class=\'faq-accordion\'><div class=\'faq-q\'><strong>Q: What warranty is included?</strong><p>A: Full 1-year replacement warranty and 7-day returns.</p></div></div><script type=\'application/ld+json\'>{\"@context\":\"https://schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Ergonomic Desks products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}</script></div>', 'done', NULL, NULL, '2026-08-19 18:52:32', '2026-08-19 18:52:32'),
(7, 1, 'seo_content_generator', '{\"collection\":\"Pro Audio & ANC\",\"slug\":\"buyers-guide-pro-audio-anc-2026\",\"title\":\"The Ultimate 2026 Buyer\'s Guide to Pro Audio & ANC: Ergonomics, Durability & Performance\",\"schema\":{\"@context\":\"https:\\/\\/schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Pro Audio & ANC products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}}', '<div class=\'seo-buyers-guide\'><h2>Why Quality Matters in Pro Audio & ANC</h2><p>Choosing the right gear isn\'t just about aesthetics — it directly impacts your daily stamina, comfort, and productivity. In this guide, our engineering and ergonomics team breaks down the key factors to evaluate before investing.</p><h3>Top Recommended Options:</h3><div class=\'product-comparison-grid\'><div class=\'comparison-item\'><h4>Minimalist Chronograph Matte Black Watch (₹1,899.00)</h4><p>Sleek Scandinavian design meets precision Japanese quartz movement. Built with surgical-grade 316L stainless steel, sapphire crystal glass, ...</p></div><div class=\'comparison-item\'><h4>Urban Canvas Waterproof Commuter Backpack (₹1,599.00)</h4><p>Engineered for modern commuters. Features a dedicated 16&quot; padded laptop sleeve, hidden anti-theft pockets, waterproof zippers, and ergonomic...</p></div></div><h3>Frequently Asked Questions</h3><div class=\'faq-accordion\'><div class=\'faq-q\'><strong>Q: What warranty is included?</strong><p>A: Full 1-year replacement warranty and 7-day returns.</p></div></div><script type=\'application/ld+json\'>{\"@context\":\"https://schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Pro Audio & ANC products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}</script></div>', 'done', NULL, NULL, '2026-08-19 18:52:32', '2026-08-19 18:52:32'),
(8, 1, 'seo_content_generator', '{\"collection\":\"Workstation Lights\",\"slug\":\"buyers-guide-workstation-lights-2026\",\"title\":\"The Ultimate 2026 Buyer\'s Guide to Workstation Lights: Ergonomics, Durability & Performance\",\"schema\":{\"@context\":\"https:\\/\\/schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Workstation Lights products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}}', '<div class=\'seo-buyers-guide\'><h2>Why Quality Matters in Workstation Lights</h2><p>Choosing the right gear isn\'t just about aesthetics — it directly impacts your daily stamina, comfort, and productivity. In this guide, our engineering and ergonomics team breaks down the key factors to evaluate before investing.</p><h3>Top Recommended Options:</h3><div class=\'product-comparison-grid\'><div class=\'comparison-item\'><h4>Smart Ambient RGB Desk Atmosphere Lamp (₹1,299.00)</h4><p>Transform your workspace with 16 million colors, music sync visualization, and custom sunrise alarm schedules. Control seamlessly via app or...</p></div></div><h3>Frequently Asked Questions</h3><div class=\'faq-accordion\'><div class=\'faq-q\'><strong>Q: What warranty is included?</strong><p>A: Full 1-year replacement warranty and 7-day returns.</p></div></div><script type=\'application/ld+json\'>{\"@context\":\"https://schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Workstation Lights products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}</script></div>', 'done', NULL, NULL, '2026-08-19 18:52:32', '2026-08-19 18:52:32'),
(9, 1, 'daily_digest', '{\"gross_revenue\":0,\"orders_count\":0,\"aov\":0,\"low_stock_count\":0,\"failed_payments\":0,\"top_skus\":[]}', '📊 NovaDrop Daily Executive Digest [19 Aug 2026]:\n• Gross GMV: ₹0.00 across 0 orders (AOV: ₹0.00)\n• Estimated Net Profit: ₹0.00 (Margin ~62.6%)\n• Top Products: No items sold yet today.\n• Critical Low-Stock SKUs: 0 items\n• Failed Payment Alerts: 0', 'done', NULL, NULL, '2026-08-19 18:52:32', '2026-08-19 18:52:32'),
(10, 1, 'finance_reconciliation', '{\"audited_count\":4,\"total_revenue\":12028.92,\"mismatches_count\":4,\"mismatches\":[{\"order_id\":1,\"order_number\":\"#ND-1001\",\"type\":\"UNDERPAYMENT_OR_UNMATCHED_GATEWAY_RECORD\",\"order_total\":2948.82,\"captured\":0,\"variance\":2948.82},{\"order_id\":2,\"order_number\":\"#ND-1002\",\"type\":\"UNDERPAYMENT_OR_UNMATCHED_GATEWAY_RECORD\",\"order_total\":2240.82,\"captured\":0,\"variance\":2240.82},{\"order_id\":3,\"order_number\":\"#ND-1003\",\"type\":\"UNDERPAYMENT_OR_UNMATCHED_GATEWAY_RECORD\",\"order_total\":3065.64,\"captured\":0,\"variance\":3065.64},{\"order_id\":4,\"order_number\":\"#ND-1004\",\"type\":\"UNDERPAYMENT_OR_UNMATCHED_GATEWAY_RECORD\",\"order_total\":3773.64,\"captured\":0,\"variance\":3773.64}],\"reconciliation_code\":\"MISMATCH_DETECTED\"}', '💰 Finance Reconciliation Statement [19 Aug 2026]:\n• Orders Audited: 4 (Total Value: ₹12,028.92)\n• Mismatches / Leaks: 4\n• Total Variance Delta: ₹12,028.92\n• Reconciliation Status: MISMATCH_DETECTED', 'done', NULL, NULL, '2026-08-19 18:52:32', '2026-08-19 18:52:32'),
(11, 1, 'seo_content_generator', '{\"collection\":\"Ergonomic Desks\",\"slug\":\"buyers-guide-ergonomic-desks-2026\",\"title\":\"The Ultimate 2026 Buyer\'s Guide to Ergonomic Desks: Ergonomics, Durability & Performance\",\"schema\":{\"@context\":\"https:\\/\\/schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Ergonomic Desks products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}}', '<div class=\'seo-buyers-guide\'><h2>Why Quality Matters in Ergonomic Desks</h2><p>Choosing the right gear isn\'t just about aesthetics — it directly impacts your daily stamina, comfort, and productivity. In this guide, our engineering and ergonomics team breaks down the key factors to evaluate before investing.</p><h3>Top Recommended Options:</h3><div class=\'product-comparison-grid\'><div class=\'comparison-item\'><h4>AeroWave Pro Active Noise Cancelling Headphones (₹2,499.00)</h4><p>Custom 40mm dynamic drivers deliver pristine acoustic clarity and deep bass....</p></div></div><h3>Frequently Asked Questions</h3><div class=\'faq-accordion\'><div class=\'faq-q\'><strong>Q: What warranty is included?</strong><p>A: Full 1-year replacement warranty and 7-day returns.</p></div></div><script type=\'application/ld+json\'>{\"@context\":\"https://schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Ergonomic Desks products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}</script></div>', 'done', NULL, NULL, '2026-08-19 18:52:50', '2026-08-19 18:52:50'),
(12, 1, 'seo_content_generator', '{\"collection\":\"Pro Audio & ANC\",\"slug\":\"buyers-guide-pro-audio-anc-2026\",\"title\":\"The Ultimate 2026 Buyer\'s Guide to Pro Audio & ANC: Ergonomics, Durability & Performance\",\"schema\":{\"@context\":\"https:\\/\\/schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Pro Audio & ANC products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}}', '<div class=\'seo-buyers-guide\'><h2>Why Quality Matters in Pro Audio & ANC</h2><p>Choosing the right gear isn\'t just about aesthetics — it directly impacts your daily stamina, comfort, and productivity. In this guide, our engineering and ergonomics team breaks down the key factors to evaluate before investing.</p><h3>Top Recommended Options:</h3><div class=\'product-comparison-grid\'><div class=\'comparison-item\'><h4>Minimalist Chronograph Matte Black Watch (₹1,899.00)</h4><p>Sleek Scandinavian design meets precision Japanese quartz movement. Built with surgical-grade 316L stainless steel, sapphire crystal glass, ...</p></div><div class=\'comparison-item\'><h4>Urban Canvas Waterproof Commuter Backpack (₹1,599.00)</h4><p>Engineered for modern commuters. Features a dedicated 16&quot; padded laptop sleeve, hidden anti-theft pockets, waterproof zippers, and ergonomic...</p></div></div><h3>Frequently Asked Questions</h3><div class=\'faq-accordion\'><div class=\'faq-q\'><strong>Q: What warranty is included?</strong><p>A: Full 1-year replacement warranty and 7-day returns.</p></div></div><script type=\'application/ld+json\'>{\"@context\":\"https://schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Pro Audio & ANC products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}</script></div>', 'done', NULL, NULL, '2026-08-19 18:52:50', '2026-08-19 18:52:50'),
(13, 1, 'seo_content_generator', '{\"collection\":\"Workstation Lights\",\"slug\":\"buyers-guide-workstation-lights-2026\",\"title\":\"The Ultimate 2026 Buyer\'s Guide to Workstation Lights: Ergonomics, Durability & Performance\",\"schema\":{\"@context\":\"https:\\/\\/schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Workstation Lights products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}}', '<div class=\'seo-buyers-guide\'><h2>Why Quality Matters in Workstation Lights</h2><p>Choosing the right gear isn\'t just about aesthetics — it directly impacts your daily stamina, comfort, and productivity. In this guide, our engineering and ergonomics team breaks down the key factors to evaluate before investing.</p><h3>Top Recommended Options:</h3><div class=\'product-comparison-grid\'><div class=\'comparison-item\'><h4>Smart Ambient RGB Desk Atmosphere Lamp (₹1,299.00)</h4><p>Transform your workspace with 16 million colors, music sync visualization, and custom sunrise alarm schedules. Control seamlessly via app or...</p></div></div><h3>Frequently Asked Questions</h3><div class=\'faq-accordion\'><div class=\'faq-q\'><strong>Q: What warranty is included?</strong><p>A: Full 1-year replacement warranty and 7-day returns.</p></div></div><script type=\'application/ld+json\'>{\"@context\":\"https://schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Workstation Lights products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}</script></div>', 'done', NULL, NULL, '2026-08-19 18:52:50', '2026-08-19 18:52:50'),
(14, 1, 'daily_digest', '{\"gross_revenue\":0,\"orders_count\":0,\"aov\":0,\"low_stock_count\":0,\"failed_payments\":0,\"top_skus\":[]}', '📊 NovaDrop Daily Executive Digest [19 Aug 2026]:\n• Gross GMV: ₹0.00 across 0 orders (AOV: ₹0.00)\n• Estimated Net Profit: ₹0.00 (Margin ~62.6%)\n• Top Products: No items sold yet today.\n• Critical Low-Stock SKUs: 0 items\n• Failed Payment Alerts: 0', 'done', NULL, NULL, '2026-08-19 18:52:50', '2026-08-19 18:52:50'),
(15, 1, 'finance_reconciliation', '{\"audited_count\":4,\"total_revenue\":12028.92,\"mismatches_count\":4,\"mismatches\":[{\"order_id\":1,\"order_number\":\"#ND-1001\",\"type\":\"UNDERPAYMENT_OR_UNMATCHED_GATEWAY_RECORD\",\"order_total\":2948.82,\"captured\":0,\"variance\":2948.82},{\"order_id\":2,\"order_number\":\"#ND-1002\",\"type\":\"UNDERPAYMENT_OR_UNMATCHED_GATEWAY_RECORD\",\"order_total\":2240.82,\"captured\":0,\"variance\":2240.82},{\"order_id\":3,\"order_number\":\"#ND-1003\",\"type\":\"UNDERPAYMENT_OR_UNMATCHED_GATEWAY_RECORD\",\"order_total\":3065.64,\"captured\":0,\"variance\":3065.64},{\"order_id\":4,\"order_number\":\"#ND-1004\",\"type\":\"UNDERPAYMENT_OR_UNMATCHED_GATEWAY_RECORD\",\"order_total\":3773.64,\"captured\":0,\"variance\":3773.64}],\"reconciliation_code\":\"MISMATCH_DETECTED\"}', '💰 Finance Reconciliation Statement [19 Aug 2026]:\n• Orders Audited: 4 (Total Value: ₹12,028.92)\n• Mismatches / Leaks: 4\n• Total Variance Delta: ₹12,028.92\n• Reconciliation Status: MISMATCH_DETECTED', 'done', NULL, NULL, '2026-08-19 18:52:50', '2026-08-19 18:52:50'),
(16, 1, 'seo_content_generator', '{\"collection\":\"Ergonomic Desks\",\"slug\":\"buyers-guide-ergonomic-desks-2026\",\"title\":\"The Ultimate 2026 Buyer\'s Guide to Ergonomic Desks: Ergonomics, Durability & Performance\",\"schema\":{\"@context\":\"https:\\/\\/schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Ergonomic Desks products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}}', '<div class=\'seo-buyers-guide\'><h2>Why Quality Matters in Ergonomic Desks</h2><p>Choosing the right gear isn\'t just about aesthetics — it directly impacts your daily stamina, comfort, and productivity. In this guide, our engineering and ergonomics team breaks down the key factors to evaluate before investing.</p><h3>Top Recommended Options:</h3><div class=\'product-comparison-grid\'><div class=\'comparison-item\'><h4>AeroWave Pro Active Noise Cancelling Headphones (₹2,499.00)</h4><p>Custom 40mm dynamic drivers deliver pristine acoustic clarity and deep bass....</p></div></div><h3>Frequently Asked Questions</h3><div class=\'faq-accordion\'><div class=\'faq-q\'><strong>Q: What warranty is included?</strong><p>A: Full 1-year replacement warranty and 7-day returns.</p></div></div><script type=\'application/ld+json\'>{\"@context\":\"https://schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Ergonomic Desks products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}</script></div>', 'done', NULL, NULL, '2026-08-19 18:52:57', '2026-08-19 18:52:57'),
(17, 1, 'seo_content_generator', '{\"collection\":\"Pro Audio & ANC\",\"slug\":\"buyers-guide-pro-audio-anc-2026\",\"title\":\"The Ultimate 2026 Buyer\'s Guide to Pro Audio & ANC: Ergonomics, Durability & Performance\",\"schema\":{\"@context\":\"https:\\/\\/schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Pro Audio & ANC products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}}', '<div class=\'seo-buyers-guide\'><h2>Why Quality Matters in Pro Audio & ANC</h2><p>Choosing the right gear isn\'t just about aesthetics — it directly impacts your daily stamina, comfort, and productivity. In this guide, our engineering and ergonomics team breaks down the key factors to evaluate before investing.</p><h3>Top Recommended Options:</h3><div class=\'product-comparison-grid\'><div class=\'comparison-item\'><h4>Minimalist Chronograph Matte Black Watch (₹1,899.00)</h4><p>Sleek Scandinavian design meets precision Japanese quartz movement. Built with surgical-grade 316L stainless steel, sapphire crystal glass, ...</p></div><div class=\'comparison-item\'><h4>Urban Canvas Waterproof Commuter Backpack (₹1,599.00)</h4><p>Engineered for modern commuters. Features a dedicated 16&quot; padded laptop sleeve, hidden anti-theft pockets, waterproof zippers, and ergonomic...</p></div></div><h3>Frequently Asked Questions</h3><div class=\'faq-accordion\'><div class=\'faq-q\'><strong>Q: What warranty is included?</strong><p>A: Full 1-year replacement warranty and 7-day returns.</p></div></div><script type=\'application/ld+json\'>{\"@context\":\"https://schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Pro Audio & ANC products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}</script></div>', 'done', NULL, NULL, '2026-08-19 18:52:57', '2026-08-19 18:52:57'),
(18, 1, 'seo_content_generator', '{\"collection\":\"Workstation Lights\",\"slug\":\"buyers-guide-workstation-lights-2026\",\"title\":\"The Ultimate 2026 Buyer\'s Guide to Workstation Lights: Ergonomics, Durability & Performance\",\"schema\":{\"@context\":\"https:\\/\\/schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Workstation Lights products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}}', '<div class=\'seo-buyers-guide\'><h2>Why Quality Matters in Workstation Lights</h2><p>Choosing the right gear isn\'t just about aesthetics — it directly impacts your daily stamina, comfort, and productivity. In this guide, our engineering and ergonomics team breaks down the key factors to evaluate before investing.</p><h3>Top Recommended Options:</h3><div class=\'product-comparison-grid\'><div class=\'comparison-item\'><h4>Smart Ambient RGB Desk Atmosphere Lamp (₹1,299.00)</h4><p>Transform your workspace with 16 million colors, music sync visualization, and custom sunrise alarm schedules. Control seamlessly via app or...</p></div></div><h3>Frequently Asked Questions</h3><div class=\'faq-accordion\'><div class=\'faq-q\'><strong>Q: What warranty is included?</strong><p>A: Full 1-year replacement warranty and 7-day returns.</p></div></div><script type=\'application/ld+json\'>{\"@context\":\"https://schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Workstation Lights products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}</script></div>', 'done', NULL, NULL, '2026-08-19 18:52:57', '2026-08-19 18:52:57'),
(19, 1, 'seo_content_generator', '{\"collection\":\"Ergonomic Desks\",\"slug\":\"buyers-guide-ergonomic-desks-2026\",\"title\":\"The Ultimate 2026 Buyer\'s Guide to Ergonomic Desks: Ergonomics, Durability & Performance\",\"schema\":{\"@context\":\"https:\\/\\/schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Ergonomic Desks products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}}', '<div class=\'seo-buyers-guide\'><h2>Why Quality Matters in Ergonomic Desks</h2><p>Choosing the right gear isn\'t just about aesthetics — it directly impacts your daily stamina, comfort, and productivity. In this guide, our engineering and ergonomics team breaks down the key factors to evaluate before investing.</p><h3>Top Recommended Options:</h3><div class=\'product-comparison-grid\'><div class=\'comparison-item\'><h4>AeroWave Pro Active Noise Cancelling Headphones (₹2,499.00)</h4><p>Custom 40mm dynamic drivers deliver pristine acoustic clarity and deep bass....</p></div></div><h3>Frequently Asked Questions</h3><div class=\'faq-accordion\'><div class=\'faq-q\'><strong>Q: What warranty is included?</strong><p>A: Full 1-year replacement warranty and 7-day returns.</p></div></div><script type=\'application/ld+json\'>{\"@context\":\"https://schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Ergonomic Desks products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}</script></div>', 'done', NULL, NULL, '2026-08-19 18:53:06', '2026-08-19 18:53:06'),
(20, 1, 'seo_content_generator', '{\"collection\":\"Pro Audio & ANC\",\"slug\":\"buyers-guide-pro-audio-anc-2026\",\"title\":\"The Ultimate 2026 Buyer\'s Guide to Pro Audio & ANC: Ergonomics, Durability & Performance\",\"schema\":{\"@context\":\"https:\\/\\/schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Pro Audio & ANC products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}}', '<div class=\'seo-buyers-guide\'><h2>Why Quality Matters in Pro Audio & ANC</h2><p>Choosing the right gear isn\'t just about aesthetics — it directly impacts your daily stamina, comfort, and productivity. In this guide, our engineering and ergonomics team breaks down the key factors to evaluate before investing.</p><h3>Top Recommended Options:</h3><div class=\'product-comparison-grid\'><div class=\'comparison-item\'><h4>Minimalist Chronograph Matte Black Watch (₹1,899.00)</h4><p>Sleek Scandinavian design meets precision Japanese quartz movement. Built with surgical-grade 316L stainless steel, sapphire crystal glass, ...</p></div><div class=\'comparison-item\'><h4>Urban Canvas Waterproof Commuter Backpack (₹1,599.00)</h4><p>Engineered for modern commuters. Features a dedicated 16&quot; padded laptop sleeve, hidden anti-theft pockets, waterproof zippers, and ergonomic...</p></div></div><h3>Frequently Asked Questions</h3><div class=\'faq-accordion\'><div class=\'faq-q\'><strong>Q: What warranty is included?</strong><p>A: Full 1-year replacement warranty and 7-day returns.</p></div></div><script type=\'application/ld+json\'>{\"@context\":\"https://schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Pro Audio & ANC products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}</script></div>', 'done', NULL, NULL, '2026-08-19 18:53:06', '2026-08-19 18:53:06'),
(21, 1, 'seo_content_generator', '{\"collection\":\"Workstation Lights\",\"slug\":\"buyers-guide-workstation-lights-2026\",\"title\":\"The Ultimate 2026 Buyer\'s Guide to Workstation Lights: Ergonomics, Durability & Performance\",\"schema\":{\"@context\":\"https:\\/\\/schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Workstation Lights products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}}', '<div class=\'seo-buyers-guide\'><h2>Why Quality Matters in Workstation Lights</h2><p>Choosing the right gear isn\'t just about aesthetics — it directly impacts your daily stamina, comfort, and productivity. In this guide, our engineering and ergonomics team breaks down the key factors to evaluate before investing.</p><h3>Top Recommended Options:</h3><div class=\'product-comparison-grid\'><div class=\'comparison-item\'><h4>Smart Ambient RGB Desk Atmosphere Lamp (₹1,299.00)</h4><p>Transform your workspace with 16 million colors, music sync visualization, and custom sunrise alarm schedules. Control seamlessly via app or...</p></div></div><h3>Frequently Asked Questions</h3><div class=\'faq-accordion\'><div class=\'faq-q\'><strong>Q: What warranty is included?</strong><p>A: Full 1-year replacement warranty and 7-day returns.</p></div></div><script type=\'application/ld+json\'>{\"@context\":\"https://schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Workstation Lights products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}</script></div>', 'done', NULL, NULL, '2026-08-19 18:53:06', '2026-08-19 18:53:06'),
(22, 1, 'daily_digest', '{\"gross_revenue\":0,\"orders_count\":0,\"aov\":0,\"low_stock_count\":0,\"failed_payments\":0,\"top_skus\":[]}', '📊 NovaDrop Daily Executive Digest [19 Aug 2026]:\n• Gross GMV: ₹0.00 across 0 orders (AOV: ₹0.00)\n• Estimated Net Profit: ₹0.00 (Margin ~62.6%)\n• Top Products: No items sold yet today.\n• Critical Low-Stock SKUs: 0 items\n• Failed Payment Alerts: 0', 'done', NULL, NULL, '2026-08-19 18:53:06', '2026-08-19 18:53:06'),
(23, 1, 'finance_reconciliation', '{\"audited_count\":4,\"total_revenue\":12028.92,\"mismatches_count\":4,\"mismatches\":[{\"order_id\":1,\"order_number\":\"#ND-1001\",\"type\":\"UNDERPAYMENT_OR_UNMATCHED_GATEWAY_RECORD\",\"order_total\":2948.82,\"captured\":0,\"variance\":2948.82},{\"order_id\":2,\"order_number\":\"#ND-1002\",\"type\":\"UNDERPAYMENT_OR_UNMATCHED_GATEWAY_RECORD\",\"order_total\":2240.82,\"captured\":0,\"variance\":2240.82},{\"order_id\":3,\"order_number\":\"#ND-1003\",\"type\":\"UNDERPAYMENT_OR_UNMATCHED_GATEWAY_RECORD\",\"order_total\":3065.64,\"captured\":0,\"variance\":3065.64},{\"order_id\":4,\"order_number\":\"#ND-1004\",\"type\":\"UNDERPAYMENT_OR_UNMATCHED_GATEWAY_RECORD\",\"order_total\":3773.64,\"captured\":0,\"variance\":3773.64}],\"reconciliation_code\":\"MISMATCH_DETECTED\"}', '💰 Finance Reconciliation Statement [19 Aug 2026]:\n• Orders Audited: 4 (Total Value: ₹12,028.92)\n• Mismatches / Leaks: 4\n• Total Variance Delta: ₹12,028.92\n• Reconciliation Status: MISMATCH_DETECTED', 'done', NULL, NULL, '2026-08-19 18:53:06', '2026-08-19 18:53:06'),
(24, 1, 'vendor_whatsapp_dispatch', '{\"vendor_id\":2,\"phone\":\"+919870330064\",\"order_id\":5}', 'Hello Kenji Takahashi! 🚀 New Order *#01001* has been assigned to *Okayama Selvedge Guild*.\n\nItems to Dispatch:\n• The Atelier Cashmere Cocoon Coat (x1)\n\nTotal: ₹7,499.00 (Net: ₹6,599.12)\nPlease log in to your Seller Portal to generate shipping label & dispatch:\n👉 http://localhost/Dropshipping/vendor/orders', 'done', NULL, NULL, '2026-08-19 22:28:41', '2026-08-19 22:28:41'),
(25, 1, 'vendor_whatsapp_dispatch', '{\"vendor_id\":2,\"phone\":\"+919870330064\",\"order_id\":6}', 'Hello Kenji Takahashi! 🚀 New Order *#02002* has been assigned to *Okayama Selvedge Guild*.\n\nItems to Dispatch:\n• The Atelier Cashmere Cocoon Coat (x1)\n\nTotal: ₹7,499.00 (Net: ₹6,599.12)\nPlease log in to your Seller Portal to generate shipping label & dispatch:\n👉 http://localhost/Dropshipping/vendor/orders', 'done', NULL, NULL, '2026-08-19 22:31:35', '2026-08-19 22:31:35'),
(26, 1, 'vendor_whatsapp_dispatch', '{\"vendor_id\":2,\"phone\":\"+919870330064\",\"order_id\":7}', 'Hello Kenji Takahashi! 🚀 New Order *#03003* has been assigned to *Okayama Selvedge Guild*.\n\nItems to Dispatch:\n• The Atelier Cashmere Cocoon Coat (x1)\n\nTotal: ₹7,499.00 (Net: ₹6,599.12)\nPlease log in to your Seller Portal to generate shipping label & dispatch:\n👉 http://localhost/Dropshipping/vendor/orders', 'done', NULL, NULL, '2026-08-19 22:31:48', '2026-08-19 22:31:48'),
(27, 1, 'vendor_whatsapp_dispatch', '{\"vendor_id\":2,\"phone\":\"+919870330064\",\"order_id\":5}', 'Hello Kenji Takahashi! 🚀 New Order *#01001* has been assigned to *Okayama Selvedge Guild*.\n\nItems to Dispatch:\n• The Atelier Cashmere Cocoon Coat (x1)\n\nTotal: ₹7,499.00 (Net: ₹6,599.12)\nPlease log in to your Seller Portal to generate shipping label & dispatch:\n👉 http://localhost/Dropshipping/vendor/orders', 'done', NULL, NULL, '2026-08-25 21:33:09', '2026-08-25 21:33:09'),
(28, 1, 'vendor_whatsapp_dispatch', '{\"vendor_id\":2,\"phone\":\"+919870330064\",\"order_id\":6}', 'Hello Kenji Takahashi! 🚀 New Order *#02002* has been assigned to *Okayama Selvedge Guild*.\n\nItems to Dispatch:\n• The Atelier Cashmere Cocoon Coat (x1)\n\nTotal: ₹7,499.00 (Net: ₹6,599.12)\nPlease log in to your Seller Portal to generate shipping label & dispatch:\n👉 http://localhost/Dropshipping/vendor/orders', 'done', NULL, NULL, '2026-08-25 21:33:09', '2026-08-25 21:33:09'),
(29, 1, 'vendor_whatsapp_dispatch', '{\"vendor_id\":2,\"phone\":\"+919870330064\",\"order_id\":7}', 'Hello Kenji Takahashi! 🚀 New Order *#03003* has been assigned to *Okayama Selvedge Guild*.\n\nItems to Dispatch:\n• The Atelier Cashmere Cocoon Coat (x1)\n\nTotal: ₹7,499.00 (Net: ₹6,599.12)\nPlease log in to your Seller Portal to generate shipping label & dispatch:\n👉 http://localhost/Dropshipping/vendor/orders', 'done', NULL, NULL, '2026-08-25 21:33:09', '2026-08-25 21:33:09'),
(30, 1, 'seo_content_generator', '{\"collection\":\"Outerwear & Cashmere\",\"slug\":\"buyers-guide-outerwear-2026\",\"title\":\"The Ultimate 2026 Buyer\'s Guide to Outerwear & Cashmere: Ergonomics, Durability & Performance\",\"schema\":{\"@context\":\"https:\\/\\/schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Outerwear & Cashmere products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}}', '<div class=\'seo-buyers-guide\'><h2>Why Quality Matters in Outerwear & Cashmere</h2><p>Choosing the right gear isn\'t just about aesthetics — it directly impacts your daily stamina, comfort, and productivity. In this guide, our engineering and ergonomics team breaks down the key factors to evaluate before investing.</p><h3>Top Recommended Options:</h3><div class=\'product-comparison-grid\'><div class=\'comparison-item\'><h4>The Atelier Cashmere Cocoon Coat (₹4,399.00)</h4><p>Hand-cut from 700 GSM Grade-A Mongolian cashmere with double-faced seams and water buffalo horn buttons. Museum-grade thermal efficiency wit...</p></div><div class=\'comparison-item\'><h4>Double-Breasted Melton Wool Peacoat (₹5,699.00)</h4><p>Architectural virgin wool peacoat with anchor-embossed horn buttons and deep fleece-lined hand warmer pockets....</p></div></div><h3>Frequently Asked Questions</h3><div class=\'faq-accordion\'><div class=\'faq-q\'><strong>Q: What warranty is included?</strong><p>A: Full 1-year replacement warranty and 7-day returns.</p></div></div><script type=\'application/ld+json\'>{\"@context\":\"https://schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Outerwear & Cashmere products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}</script></div>', 'done', NULL, NULL, '2026-08-25 21:54:59', '2026-08-25 21:54:59');
INSERT INTO `ai_agent_tasks` (`id`, `store_id`, `agent`, `input_json`, `output_text`, `status`, `approved_by`, `approved_at`, `created_at`, `updated_at`) VALUES
(31, 1, 'seo_content_generator', '{\"collection\":\"Okayama Selvedge Denim\",\"slug\":\"buyers-guide-denim-2026\",\"title\":\"The Ultimate 2026 Buyer\'s Guide to Okayama Selvedge Denim: Ergonomics, Durability & Performance\",\"schema\":{\"@context\":\"https:\\/\\/schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Okayama Selvedge Denim products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}}', '<div class=\'seo-buyers-guide\'><h2>Why Quality Matters in Okayama Selvedge Denim</h2><p>Choosing the right gear isn\'t just about aesthetics — it directly impacts your daily stamina, comfort, and productivity. In this guide, our engineering and ergonomics team breaks down the key factors to evaluate before investing.</p><h3>Top Recommended Options:</h3><div class=\'product-comparison-grid\'><div class=\'comparison-item\'><h4>Vintage Okayama 14.5oz Selvedge Trousers (₹4,299.00)</h4><p>Custom shuttle-loomed denim with vintage copper hardware and chain-stitched hems that develop personalized honeycombs and whiskers over time...</p></div><div class=\'comparison-item\'><h4>Type II Shuttle-Loom Denim Jacket (₹5,299.00)</h4><p>Iconic Type II jacket silhouette crafted on vintage Toyoda shuttle looms with red-line selvedge along the interior placket....</p></div></div><h3>Frequently Asked Questions</h3><div class=\'faq-accordion\'><div class=\'faq-q\'><strong>Q: What warranty is included?</strong><p>A: Full 1-year replacement warranty and 7-day returns.</p></div></div><script type=\'application/ld+json\'>{\"@context\":\"https://schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Okayama Selvedge Denim products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}</script></div>', 'done', NULL, NULL, '2026-08-25 21:54:59', '2026-08-25 21:54:59'),
(32, 1, 'seo_content_generator', '{\"collection\":\"Mulberry Silk Eveningwear\",\"slug\":\"buyers-guide-silk-2026\",\"title\":\"The Ultimate 2026 Buyer\'s Guide to Mulberry Silk Eveningwear: Ergonomics, Durability & Performance\",\"schema\":{\"@context\":\"https:\\/\\/schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Mulberry Silk Eveningwear products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}}', '<div class=\'seo-buyers-guide\'><h2>Why Quality Matters in Mulberry Silk Eveningwear</h2><p>Choosing the right gear isn\'t just about aesthetics — it directly impacts your daily stamina, comfort, and productivity. In this guide, our engineering and ergonomics team breaks down the key factors to evaluate before investing.</p><h3>Top Recommended Options:</h3><div class=\'product-comparison-grid\'><div class=\'comparison-item\'><h4>22-Momme Mulberry Silk Bias Slip Dress (₹4,999.00)</h4><p>Sandwashed pure Mulberry silk that drapes organically along bodily contours with liquid sheen and adjustable silk-cord straps....</p></div><div class=\'comparison-item\'><h4>Sandwashed Silk Charmeuse Blouse (₹3,799.00)</h4><p>Ultra-soft sandwashed silk charmeuse blouse with French cuffs and concealed placket for effortless sartorial styling....</p></div></div><h3>Frequently Asked Questions</h3><div class=\'faq-accordion\'><div class=\'faq-q\'><strong>Q: What warranty is included?</strong><p>A: Full 1-year replacement warranty and 7-day returns.</p></div></div><script type=\'application/ld+json\'>{\"@context\":\"https://schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Mulberry Silk Eveningwear products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}</script></div>', 'done', NULL, NULL, '2026-08-25 21:54:59', '2026-08-25 21:54:59'),
(33, 1, 'seo_content_generator', '{\"collection\":\"Outerwear & Cashmere\",\"slug\":\"buyers-guide-outerwear-2026\",\"title\":\"The Ultimate 2026 Buyer\'s Guide to Outerwear & Cashmere: Ergonomics, Durability & Performance\",\"schema\":{\"@context\":\"https:\\/\\/schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Outerwear & Cashmere products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}}', '<div class=\'seo-buyers-guide\'><h2>Why Quality Matters in Outerwear & Cashmere</h2><p>Choosing the right gear isn\'t just about aesthetics — it directly impacts your daily stamina, comfort, and productivity. In this guide, our engineering and ergonomics team breaks down the key factors to evaluate before investing.</p><h3>Top Recommended Options:</h3><div class=\'product-comparison-grid\'><div class=\'comparison-item\'><h4>The Atelier Cashmere Cocoon Coat (₹4,399.00)</h4><p>Hand-cut from 700 GSM Grade-A Mongolian cashmere with double-faced seams and water buffalo horn buttons. Museum-grade thermal efficiency wit...</p></div><div class=\'comparison-item\'><h4>Double-Breasted Melton Wool Peacoat (₹5,699.00)</h4><p>Architectural virgin wool peacoat with anchor-embossed horn buttons and deep fleece-lined hand warmer pockets....</p></div></div><h3>Frequently Asked Questions</h3><div class=\'faq-accordion\'><div class=\'faq-q\'><strong>Q: What warranty is included?</strong><p>A: Full 1-year replacement warranty and 7-day returns.</p></div></div><script type=\'application/ld+json\'>{\"@context\":\"https://schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Outerwear & Cashmere products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}</script></div>', 'done', NULL, NULL, '2026-08-25 21:55:19', '2026-08-25 21:55:19'),
(34, 1, 'seo_content_generator', '{\"collection\":\"Okayama Selvedge Denim\",\"slug\":\"buyers-guide-denim-2026\",\"title\":\"The Ultimate 2026 Buyer\'s Guide to Okayama Selvedge Denim: Ergonomics, Durability & Performance\",\"schema\":{\"@context\":\"https:\\/\\/schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Okayama Selvedge Denim products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}}', '<div class=\'seo-buyers-guide\'><h2>Why Quality Matters in Okayama Selvedge Denim</h2><p>Choosing the right gear isn\'t just about aesthetics — it directly impacts your daily stamina, comfort, and productivity. In this guide, our engineering and ergonomics team breaks down the key factors to evaluate before investing.</p><h3>Top Recommended Options:</h3><div class=\'product-comparison-grid\'><div class=\'comparison-item\'><h4>Vintage Okayama 14.5oz Selvedge Trousers (₹4,299.00)</h4><p>Custom shuttle-loomed denim with vintage copper hardware and chain-stitched hems that develop personalized honeycombs and whiskers over time...</p></div><div class=\'comparison-item\'><h4>Type II Shuttle-Loom Denim Jacket (₹5,299.00)</h4><p>Iconic Type II jacket silhouette crafted on vintage Toyoda shuttle looms with red-line selvedge along the interior placket....</p></div></div><h3>Frequently Asked Questions</h3><div class=\'faq-accordion\'><div class=\'faq-q\'><strong>Q: What warranty is included?</strong><p>A: Full 1-year replacement warranty and 7-day returns.</p></div></div><script type=\'application/ld+json\'>{\"@context\":\"https://schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Okayama Selvedge Denim products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}</script></div>', 'done', NULL, NULL, '2026-08-25 21:55:19', '2026-08-25 21:55:19'),
(35, 1, 'seo_content_generator', '{\"collection\":\"Mulberry Silk Eveningwear\",\"slug\":\"buyers-guide-silk-2026\",\"title\":\"The Ultimate 2026 Buyer\'s Guide to Mulberry Silk Eveningwear: Ergonomics, Durability & Performance\",\"schema\":{\"@context\":\"https:\\/\\/schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Mulberry Silk Eveningwear products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}}', '<div class=\'seo-buyers-guide\'><h2>Why Quality Matters in Mulberry Silk Eveningwear</h2><p>Choosing the right gear isn\'t just about aesthetics — it directly impacts your daily stamina, comfort, and productivity. In this guide, our engineering and ergonomics team breaks down the key factors to evaluate before investing.</p><h3>Top Recommended Options:</h3><div class=\'product-comparison-grid\'><div class=\'comparison-item\'><h4>22-Momme Mulberry Silk Bias Slip Dress (₹4,999.00)</h4><p>Sandwashed pure Mulberry silk that drapes organically along bodily contours with liquid sheen and adjustable silk-cord straps....</p></div><div class=\'comparison-item\'><h4>Sandwashed Silk Charmeuse Blouse (₹3,799.00)</h4><p>Ultra-soft sandwashed silk charmeuse blouse with French cuffs and concealed placket for effortless sartorial styling....</p></div></div><h3>Frequently Asked Questions</h3><div class=\'faq-accordion\'><div class=\'faq-q\'><strong>Q: What warranty is included?</strong><p>A: Full 1-year replacement warranty and 7-day returns.</p></div></div><script type=\'application/ld+json\'>{\"@context\":\"https://schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Mulberry Silk Eveningwear products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}</script></div>', 'done', NULL, NULL, '2026-08-25 21:55:19', '2026-08-25 21:55:19'),
(36, 1, 'seo_content_generator', '{\"collection\":\"Outerwear & Cashmere\",\"slug\":\"buyers-guide-outerwear-2026\",\"title\":\"The Ultimate 2026 Buyer\'s Guide to Outerwear & Cashmere: Ergonomics, Durability & Performance\",\"schema\":{\"@context\":\"https:\\/\\/schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Outerwear & Cashmere products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}}', '<div class=\'seo-buyers-guide\'><h2>Why Quality Matters in Outerwear & Cashmere</h2><p>Choosing the right gear isn\'t just about aesthetics — it directly impacts your daily stamina, comfort, and productivity. In this guide, our engineering and ergonomics team breaks down the key factors to evaluate before investing.</p><h3>Top Recommended Options:</h3><div class=\'product-comparison-grid\'><div class=\'comparison-item\'><h4>The Atelier Cashmere Cocoon Coat (₹4,399.00)</h4><p>Hand-cut from 700 GSM Grade-A Mongolian cashmere with double-faced seams and water buffalo horn buttons. Museum-grade thermal efficiency wit...</p></div><div class=\'comparison-item\'><h4>Double-Breasted Melton Wool Peacoat (₹5,699.00)</h4><p>Architectural virgin wool peacoat with anchor-embossed horn buttons and deep fleece-lined hand warmer pockets....</p></div></div><h3>Frequently Asked Questions</h3><div class=\'faq-accordion\'><div class=\'faq-q\'><strong>Q: What warranty is included?</strong><p>A: Full 1-year replacement warranty and 7-day returns.</p></div></div><script type=\'application/ld+json\'>{\"@context\":\"https://schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Outerwear & Cashmere products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}</script></div>', 'done', NULL, NULL, '2026-08-25 21:56:00', '2026-08-25 21:56:00'),
(37, 1, 'seo_content_generator', '{\"collection\":\"Okayama Selvedge Denim\",\"slug\":\"buyers-guide-denim-2026\",\"title\":\"The Ultimate 2026 Buyer\'s Guide to Okayama Selvedge Denim: Ergonomics, Durability & Performance\",\"schema\":{\"@context\":\"https:\\/\\/schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Okayama Selvedge Denim products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}}', '<div class=\'seo-buyers-guide\'><h2>Why Quality Matters in Okayama Selvedge Denim</h2><p>Choosing the right gear isn\'t just about aesthetics — it directly impacts your daily stamina, comfort, and productivity. In this guide, our engineering and ergonomics team breaks down the key factors to evaluate before investing.</p><h3>Top Recommended Options:</h3><div class=\'product-comparison-grid\'><div class=\'comparison-item\'><h4>Vintage Okayama 14.5oz Selvedge Trousers (₹4,299.00)</h4><p>Custom shuttle-loomed denim with vintage copper hardware and chain-stitched hems that develop personalized honeycombs and whiskers over time...</p></div><div class=\'comparison-item\'><h4>Type II Shuttle-Loom Denim Jacket (₹5,299.00)</h4><p>Iconic Type II jacket silhouette crafted on vintage Toyoda shuttle looms with red-line selvedge along the interior placket....</p></div></div><h3>Frequently Asked Questions</h3><div class=\'faq-accordion\'><div class=\'faq-q\'><strong>Q: What warranty is included?</strong><p>A: Full 1-year replacement warranty and 7-day returns.</p></div></div><script type=\'application/ld+json\'>{\"@context\":\"https://schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Okayama Selvedge Denim products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}</script></div>', 'done', NULL, NULL, '2026-08-25 21:56:00', '2026-08-25 21:56:00'),
(38, 1, 'seo_content_generator', '{\"collection\":\"Mulberry Silk Eveningwear\",\"slug\":\"buyers-guide-silk-2026\",\"title\":\"The Ultimate 2026 Buyer\'s Guide to Mulberry Silk Eveningwear: Ergonomics, Durability & Performance\",\"schema\":{\"@context\":\"https:\\/\\/schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Mulberry Silk Eveningwear products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}}', '<div class=\'seo-buyers-guide\'><h2>Why Quality Matters in Mulberry Silk Eveningwear</h2><p>Choosing the right gear isn\'t just about aesthetics — it directly impacts your daily stamina, comfort, and productivity. In this guide, our engineering and ergonomics team breaks down the key factors to evaluate before investing.</p><h3>Top Recommended Options:</h3><div class=\'product-comparison-grid\'><div class=\'comparison-item\'><h4>22-Momme Mulberry Silk Bias Slip Dress (₹4,999.00)</h4><p>Sandwashed pure Mulberry silk that drapes organically along bodily contours with liquid sheen and adjustable silk-cord straps....</p></div><div class=\'comparison-item\'><h4>Sandwashed Silk Charmeuse Blouse (₹3,799.00)</h4><p>Ultra-soft sandwashed silk charmeuse blouse with French cuffs and concealed placket for effortless sartorial styling....</p></div></div><h3>Frequently Asked Questions</h3><div class=\'faq-accordion\'><div class=\'faq-q\'><strong>Q: What warranty is included?</strong><p>A: Full 1-year replacement warranty and 7-day returns.</p></div></div><script type=\'application/ld+json\'>{\"@context\":\"https://schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Mulberry Silk Eveningwear products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}</script></div>', 'done', NULL, NULL, '2026-08-25 21:56:00', '2026-08-25 21:56:00'),
(39, 1, 'listing_writer', '{\"product_id\":1,\"raw_title\":\"The Atelier Cashmere Cocoon Coat\",\"supplier_data\":[]}', '{\"raw_ai_generation\":{\"title\":\"The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition\",\"bullet_points\":[\"\\u26a1 Superior Ergonomics & Build: Crafted with aircraft-grade durability and sleek modern aesthetics.\",\"\\ud83d\\udee1\\ufe0f Certified Quality: 100% inspected and verified for peak performance and longevity.\",\"\\ud83d\\ude9a Express Free Shipping: Dispatched from certified fulfillment hubs with live AWB tracking.\",\"\\ud83d\\udc8e 7-Day Replacement Guarantee: Zero-risk shopping backed by 24\\/7 dedicated support.\"],\"long_description\":\"<div class=\'product-story\'><h3>Engineered for Excellence<\\/h3><p>Experience unmatched reliability and performance with the <strong>The Atelier Cashmere Cocoon Coat<\\/strong>. Designed specifically for contemporary living, it seamlessly integrates advanced functionality with minimalist design aesthetics.<\\/p><h4>Key Highlights:<\\/h4><ul><li>High-efficiency performance tailored for demanding everyday tasks.<\\/li><li>Premium scratch-resistant and tactile finish.<\\/li><li>Backed by full NovaDrop manufacturer warranty.<\\/li><\\/ul><\\/div>\",\"seo_title\":\"The Atelier Cashmere Cocoon Coat | Buy Online Best Price | NovaDrop\",\"seo_description\":\"Shop The Atelier Cashmere Cocoon Coat online at NovaDrop India. Free express delivery, cash on delivery, and exclusive discount codes available today!\",\"image_alt_text\":\"The Atelier Cashmere Cocoon Coat product hero image showcase - NovaDrop Commerce\"},\"moderation_passed\":true,\"flags_triggered\":[],\"approved_copy\":{\"title\":\"The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition\",\"seo_title\":\"The Atelier Cashmere Cocoon Coat | Buy Online Best Price | NovaDrop\",\"seo_description\":\"Shop The Atelier Cashmere Cocoon Coat online at NovaDrop India. Free express delivery, cash on delivery, and exclusive discount codes available today!\",\"bullet_features_html\":\"<ul class=\'nova-bullet-features\'><li>\\u26a1 Superior Ergonomics &amp; Build: Crafted with aircraft-grade durability and sleek modern aesthetics.<\\/li><li>\\ud83d\\udee1\\ufe0f Certified Quality: 100% inspected and verified for peak performance and longevity.<\\/li><li>\\ud83d\\ude9a Express Free Shipping: Dispatched from certified fulfillment hubs with live AWB tracking.<\\/li><li>\\ud83d\\udc8e 7-Day Replacement Guarantee: Zero-risk shopping backed by 24\\/7 dedicated support.<\\/li><\\/ul>\",\"full_html_description\":\"<ul class=\'nova-bullet-features\'><li>\\u26a1 Superior Ergonomics &amp; Build: Crafted with aircraft-grade durability and sleek modern aesthetics.<\\/li><li>\\ud83d\\udee1\\ufe0f Certified Quality: 100% inspected and verified for peak performance and longevity.<\\/li><li>\\ud83d\\ude9a Express Free Shipping: Dispatched from certified fulfillment hubs with live AWB tracking.<\\/li><li>\\ud83d\\udc8e 7-Day Replacement Guarantee: Zero-risk shopping backed by 24\\/7 dedicated support.<\\/li><\\/ul><div class=\'nova-product-description\'><div class=\'product-story\'><h3>Engineered for Excellence<\\/h3><p>Experience unmatched reliability and performance with the <strong>The Atelier Cashmere Cocoon Coat<\\/strong>. Designed specifically for contemporary living, it seamlessly integrates advanced functionality with minimalist design aesthetics.<\\/p><h4>Key Highlights:<\\/h4><ul><li>High-efficiency performance tailored for demanding everyday tasks.<\\/li><li>Premium scratch-resistant and tactile finish.<\\/li><li>Backed by full NovaDrop manufacturer warranty.<\\/li><\\/ul><\\/div><\\/div>\",\"image_alt_text\":\"The Atelier Cashmere Cocoon Coat product hero image showcase - NovaDrop Commerce\"}}', 'done', NULL, NULL, '2026-08-25 21:56:00', '2026-08-25 21:56:00'),
(40, 1, 'seo_content_generator', '{\"collection\":\"Outerwear & Cashmere\",\"slug\":\"buyers-guide-outerwear-2026\",\"title\":\"The Ultimate 2026 Buyer\'s Guide to Outerwear & Cashmere: Ergonomics, Durability & Performance\",\"schema\":{\"@context\":\"https:\\/\\/schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Outerwear & Cashmere products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}}', '<div class=\'seo-buyers-guide\'><h2>Why Quality Matters in Outerwear & Cashmere</h2><p>Choosing the right gear isn\'t just about aesthetics — it directly impacts your daily stamina, comfort, and productivity. In this guide, our engineering and ergonomics team breaks down the key factors to evaluate before investing.</p><h3>Top Recommended Options:</h3><div class=\'product-comparison-grid\'><div class=\'comparison-item\'><h4>The Atelier Cashmere Cocoon Coat — Next-Gen Edition (₹4,399.00)</h4><p>⚡ Superior Ergonomics &amp;amp; Build: Crafted with aircraft-grade durability and sleek modern aesthetics.🛡️ Certified Quality: 100% insp...</p></div><div class=\'comparison-item\'><h4>Double-Breasted Melton Wool Peacoat (₹5,699.00)</h4><p>Architectural virgin wool peacoat with anchor-embossed horn buttons and deep fleece-lined hand warmer pockets....</p></div></div><h3>Frequently Asked Questions</h3><div class=\'faq-accordion\'><div class=\'faq-q\'><strong>Q: What warranty is included?</strong><p>A: Full 1-year replacement warranty and 7-day returns.</p></div></div><script type=\'application/ld+json\'>{\"@context\":\"https://schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Outerwear & Cashmere products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}</script></div>', 'done', NULL, NULL, '2026-08-25 21:56:20', '2026-08-25 21:56:20'),
(41, 1, 'seo_content_generator', '{\"collection\":\"Okayama Selvedge Denim\",\"slug\":\"buyers-guide-denim-2026\",\"title\":\"The Ultimate 2026 Buyer\'s Guide to Okayama Selvedge Denim: Ergonomics, Durability & Performance\",\"schema\":{\"@context\":\"https:\\/\\/schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Okayama Selvedge Denim products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}}', '<div class=\'seo-buyers-guide\'><h2>Why Quality Matters in Okayama Selvedge Denim</h2><p>Choosing the right gear isn\'t just about aesthetics — it directly impacts your daily stamina, comfort, and productivity. In this guide, our engineering and ergonomics team breaks down the key factors to evaluate before investing.</p><h3>Top Recommended Options:</h3><div class=\'product-comparison-grid\'><div class=\'comparison-item\'><h4>Vintage Okayama 14.5oz Selvedge Trousers (₹4,299.00)</h4><p>Custom shuttle-loomed denim with vintage copper hardware and chain-stitched hems that develop personalized honeycombs and whiskers over time...</p></div><div class=\'comparison-item\'><h4>Type II Shuttle-Loom Denim Jacket (₹5,299.00)</h4><p>Iconic Type II jacket silhouette crafted on vintage Toyoda shuttle looms with red-line selvedge along the interior placket....</p></div></div><h3>Frequently Asked Questions</h3><div class=\'faq-accordion\'><div class=\'faq-q\'><strong>Q: What warranty is included?</strong><p>A: Full 1-year replacement warranty and 7-day returns.</p></div></div><script type=\'application/ld+json\'>{\"@context\":\"https://schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Okayama Selvedge Denim products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}</script></div>', 'done', NULL, NULL, '2026-08-25 21:56:20', '2026-08-25 21:56:20'),
(42, 1, 'seo_content_generator', '{\"collection\":\"Mulberry Silk Eveningwear\",\"slug\":\"buyers-guide-silk-2026\",\"title\":\"The Ultimate 2026 Buyer\'s Guide to Mulberry Silk Eveningwear: Ergonomics, Durability & Performance\",\"schema\":{\"@context\":\"https:\\/\\/schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Mulberry Silk Eveningwear products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}}', '<div class=\'seo-buyers-guide\'><h2>Why Quality Matters in Mulberry Silk Eveningwear</h2><p>Choosing the right gear isn\'t just about aesthetics — it directly impacts your daily stamina, comfort, and productivity. In this guide, our engineering and ergonomics team breaks down the key factors to evaluate before investing.</p><h3>Top Recommended Options:</h3><div class=\'product-comparison-grid\'><div class=\'comparison-item\'><h4>22-Momme Mulberry Silk Bias Slip Dress (₹4,999.00)</h4><p>Sandwashed pure Mulberry silk that drapes organically along bodily contours with liquid sheen and adjustable silk-cord straps....</p></div><div class=\'comparison-item\'><h4>Sandwashed Silk Charmeuse Blouse (₹3,799.00)</h4><p>Ultra-soft sandwashed silk charmeuse blouse with French cuffs and concealed placket for effortless sartorial styling....</p></div></div><h3>Frequently Asked Questions</h3><div class=\'faq-accordion\'><div class=\'faq-q\'><strong>Q: What warranty is included?</strong><p>A: Full 1-year replacement warranty and 7-day returns.</p></div></div><script type=\'application/ld+json\'>{\"@context\":\"https://schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Mulberry Silk Eveningwear products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}</script></div>', 'done', NULL, NULL, '2026-08-25 21:56:20', '2026-08-25 21:56:20'),
(43, 1, 'listing_writer', '{\"product_id\":1,\"raw_title\":\"The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition\",\"supplier_data\":[]}', '{\"raw_ai_generation\":{\"title\":\"The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition\",\"bullet_points\":[\"\\u26a1 Superior Ergonomics & Build: Crafted with aircraft-grade durability and sleek modern aesthetics.\",\"\\ud83d\\udee1\\ufe0f Certified Quality: 100% inspected and verified for peak performance and longevity.\",\"\\ud83d\\ude9a Express Free Shipping: Dispatched from certified fulfillment hubs with live AWB tracking.\",\"\\ud83d\\udc8e 7-Day Replacement Guarantee: Zero-risk shopping backed by 24\\/7 dedicated support.\"],\"long_description\":\"<div class=\'product-story\'><h3>Engineered for Excellence<\\/h3><p>Experience unmatched reliability and performance with the <strong>The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition<\\/strong>. Designed specifically for contemporary living, it seamlessly integrates advanced functionality with minimalist design aesthetics.<\\/p><h4>Key Highlights:<\\/h4><ul><li>High-efficiency performance tailored for demanding everyday tasks.<\\/li><li>Premium scratch-resistant and tactile finish.<\\/li><li>Backed by full NovaDrop manufacturer warranty.<\\/li><\\/ul><\\/div>\",\"seo_title\":\"The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition | Buy Online Best Price | NovaDrop\",\"seo_description\":\"Shop The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition online at NovaDrop India. Free express delivery, cash on delivery, and exclusive discount codes available today!\",\"image_alt_text\":\"The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition product hero image showcase - NovaDrop Commerce\"},\"moderation_passed\":true,\"flags_triggered\":[],\"approved_copy\":{\"title\":\"The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition\",\"seo_title\":\"The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition | Buy Online Bes\",\"seo_description\":\"Shop The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition online at NovaDrop India. Free express delivery, cash on delivery, and exclusive discount codes avail\",\"bullet_features_html\":\"<ul class=\'nova-bullet-features\'><li>\\u26a1 Superior Ergonomics &amp; Build: Crafted with aircraft-grade durability and sleek modern aesthetics.<\\/li><li>\\ud83d\\udee1\\ufe0f Certified Quality: 100% inspected and verified for peak performance and longevity.<\\/li><li>\\ud83d\\ude9a Express Free Shipping: Dispatched from certified fulfillment hubs with live AWB tracking.<\\/li><li>\\ud83d\\udc8e 7-Day Replacement Guarantee: Zero-risk shopping backed by 24\\/7 dedicated support.<\\/li><\\/ul>\",\"full_html_description\":\"<ul class=\'nova-bullet-features\'><li>\\u26a1 Superior Ergonomics &amp; Build: Crafted with aircraft-grade durability and sleek modern aesthetics.<\\/li><li>\\ud83d\\udee1\\ufe0f Certified Quality: 100% inspected and verified for peak performance and longevity.<\\/li><li>\\ud83d\\ude9a Express Free Shipping: Dispatched from certified fulfillment hubs with live AWB tracking.<\\/li><li>\\ud83d\\udc8e 7-Day Replacement Guarantee: Zero-risk shopping backed by 24\\/7 dedicated support.<\\/li><\\/ul><div class=\'nova-product-description\'><div class=\'product-story\'><h3>Engineered for Excellence<\\/h3><p>Experience unmatched reliability and performance with the <strong>The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition<\\/strong>. Designed specifically for contemporary living, it seamlessly integrates advanced functionality with minimalist design aesthetics.<\\/p><h4>Key Highlights:<\\/h4><ul><li>High-efficiency performance tailored for demanding everyday tasks.<\\/li><li>Premium scratch-resistant and tactile finish.<\\/li><li>Backed by full NovaDrop manufacturer warranty.<\\/li><\\/ul><\\/div><\\/div>\",\"image_alt_text\":\"The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition product hero image showcase - NovaDrop Commerce\"}}', 'done', NULL, NULL, '2026-08-25 21:56:20', '2026-08-25 21:56:20'),
(44, 1, 'seo_content_generator', '{\"collection\":\"Outerwear & Cashmere\",\"slug\":\"buyers-guide-outerwear-2026\",\"title\":\"The Ultimate 2026 Buyer\'s Guide to Outerwear & Cashmere: Ergonomics, Durability & Performance\",\"schema\":{\"@context\":\"https:\\/\\/schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Outerwear & Cashmere products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}}', '<div class=\'seo-buyers-guide\'><h2>Why Quality Matters in Outerwear & Cashmere</h2><p>Choosing the right gear isn\'t just about aesthetics — it directly impacts your daily stamina, comfort, and productivity. In this guide, our engineering and ergonomics team breaks down the key factors to evaluate before investing.</p><h3>Top Recommended Options:</h3><div class=\'product-comparison-grid\'><div class=\'comparison-item\'><h4>The Atelier Cashmere Cocoon Coat — Next-Gen Edition — Next-Gen Edition (₹4,399.00)</h4><p>⚡ Superior Ergonomics &amp;amp; Build: Crafted with aircraft-grade durability and sleek modern aesthetics.🛡️ Certified Quality: 100% insp...</p></div><div class=\'comparison-item\'><h4>Double-Breasted Melton Wool Peacoat (₹5,699.00)</h4><p>Architectural virgin wool peacoat with anchor-embossed horn buttons and deep fleece-lined hand warmer pockets....</p></div></div><h3>Frequently Asked Questions</h3><div class=\'faq-accordion\'><div class=\'faq-q\'><strong>Q: What warranty is included?</strong><p>A: Full 1-year replacement warranty and 7-day returns.</p></div></div><script type=\'application/ld+json\'>{\"@context\":\"https://schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Outerwear & Cashmere products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}</script></div>', 'done', NULL, NULL, '2026-08-25 21:56:57', '2026-08-25 21:56:57'),
(45, 1, 'seo_content_generator', '{\"collection\":\"Okayama Selvedge Denim\",\"slug\":\"buyers-guide-denim-2026\",\"title\":\"The Ultimate 2026 Buyer\'s Guide to Okayama Selvedge Denim: Ergonomics, Durability & Performance\",\"schema\":{\"@context\":\"https:\\/\\/schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Okayama Selvedge Denim products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}}', '<div class=\'seo-buyers-guide\'><h2>Why Quality Matters in Okayama Selvedge Denim</h2><p>Choosing the right gear isn\'t just about aesthetics — it directly impacts your daily stamina, comfort, and productivity. In this guide, our engineering and ergonomics team breaks down the key factors to evaluate before investing.</p><h3>Top Recommended Options:</h3><div class=\'product-comparison-grid\'><div class=\'comparison-item\'><h4>Vintage Okayama 14.5oz Selvedge Trousers (₹4,299.00)</h4><p>Custom shuttle-loomed denim with vintage copper hardware and chain-stitched hems that develop personalized honeycombs and whiskers over time...</p></div><div class=\'comparison-item\'><h4>Type II Shuttle-Loom Denim Jacket (₹5,299.00)</h4><p>Iconic Type II jacket silhouette crafted on vintage Toyoda shuttle looms with red-line selvedge along the interior placket....</p></div></div><h3>Frequently Asked Questions</h3><div class=\'faq-accordion\'><div class=\'faq-q\'><strong>Q: What warranty is included?</strong><p>A: Full 1-year replacement warranty and 7-day returns.</p></div></div><script type=\'application/ld+json\'>{\"@context\":\"https://schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Okayama Selvedge Denim products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}</script></div>', 'done', NULL, NULL, '2026-08-25 21:56:57', '2026-08-25 21:56:57'),
(46, 1, 'seo_content_generator', '{\"collection\":\"Mulberry Silk Eveningwear\",\"slug\":\"buyers-guide-silk-2026\",\"title\":\"The Ultimate 2026 Buyer\'s Guide to Mulberry Silk Eveningwear: Ergonomics, Durability & Performance\",\"schema\":{\"@context\":\"https:\\/\\/schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Mulberry Silk Eveningwear products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}}', '<div class=\'seo-buyers-guide\'><h2>Why Quality Matters in Mulberry Silk Eveningwear</h2><p>Choosing the right gear isn\'t just about aesthetics — it directly impacts your daily stamina, comfort, and productivity. In this guide, our engineering and ergonomics team breaks down the key factors to evaluate before investing.</p><h3>Top Recommended Options:</h3><div class=\'product-comparison-grid\'><div class=\'comparison-item\'><h4>22-Momme Mulberry Silk Bias Slip Dress (₹4,999.00)</h4><p>Sandwashed pure Mulberry silk that drapes organically along bodily contours with liquid sheen and adjustable silk-cord straps....</p></div><div class=\'comparison-item\'><h4>Sandwashed Silk Charmeuse Blouse (₹3,799.00)</h4><p>Ultra-soft sandwashed silk charmeuse blouse with French cuffs and concealed placket for effortless sartorial styling....</p></div></div><h3>Frequently Asked Questions</h3><div class=\'faq-accordion\'><div class=\'faq-q\'><strong>Q: What warranty is included?</strong><p>A: Full 1-year replacement warranty and 7-day returns.</p></div></div><script type=\'application/ld+json\'>{\"@context\":\"https://schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Mulberry Silk Eveningwear products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}</script></div>', 'done', NULL, NULL, '2026-08-25 21:56:57', '2026-08-25 21:56:57'),
(47, 1, 'listing_writer', '{\"product_id\":1,\"raw_title\":\"The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition\",\"supplier_data\":[]}', '{\"raw_ai_generation\":{\"title\":\"The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition\",\"bullet_points\":[\"\\u26a1 Superior Ergonomics & Build: Crafted with aircraft-grade durability and sleek modern aesthetics.\",\"\\ud83d\\udee1\\ufe0f Certified Quality: 100% inspected and verified for peak performance and longevity.\",\"\\ud83d\\ude9a Express Free Shipping: Dispatched from certified fulfillment hubs with live AWB tracking.\",\"\\ud83d\\udc8e 7-Day Replacement Guarantee: Zero-risk shopping backed by 24\\/7 dedicated support.\"],\"long_description\":\"<div class=\'product-story\'><h3>Engineered for Excellence<\\/h3><p>Experience unmatched reliability and performance with the <strong>The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition<\\/strong>. Designed specifically for contemporary living, it seamlessly integrates advanced functionality with minimalist design aesthetics.<\\/p><h4>Key Highlights:<\\/h4><ul><li>High-efficiency performance tailored for demanding everyday tasks.<\\/li><li>Premium scratch-resistant and tactile finish.<\\/li><li>Backed by full NovaDrop manufacturer warranty.<\\/li><\\/ul><\\/div>\",\"seo_title\":\"The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition | Buy Online Best Price | NovaDrop\",\"seo_description\":\"Shop The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition online at NovaDrop India. Free express delivery, cash on delivery, and exclusive discount codes available today!\",\"image_alt_text\":\"The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition product hero image showcase - NovaDrop Commerce\"},\"moderation_passed\":true,\"flags_triggered\":[],\"approved_copy\":{\"title\":\"The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition\",\"seo_title\":\"The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edi\",\"seo_description\":\"Shop The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition online at NovaDrop India. Free express delivery, cash on delivery, and exclusive\",\"bullet_features_html\":\"<ul class=\'nova-bullet-features\'><li>\\u26a1 Superior Ergonomics &amp; Build: Crafted with aircraft-grade durability and sleek modern aesthetics.<\\/li><li>\\ud83d\\udee1\\ufe0f Certified Quality: 100% inspected and verified for peak performance and longevity.<\\/li><li>\\ud83d\\ude9a Express Free Shipping: Dispatched from certified fulfillment hubs with live AWB tracking.<\\/li><li>\\ud83d\\udc8e 7-Day Replacement Guarantee: Zero-risk shopping backed by 24\\/7 dedicated support.<\\/li><\\/ul>\",\"full_html_description\":\"<ul class=\'nova-bullet-features\'><li>\\u26a1 Superior Ergonomics &amp; Build: Crafted with aircraft-grade durability and sleek modern aesthetics.<\\/li><li>\\ud83d\\udee1\\ufe0f Certified Quality: 100% inspected and verified for peak performance and longevity.<\\/li><li>\\ud83d\\ude9a Express Free Shipping: Dispatched from certified fulfillment hubs with live AWB tracking.<\\/li><li>\\ud83d\\udc8e 7-Day Replacement Guarantee: Zero-risk shopping backed by 24\\/7 dedicated support.<\\/li><\\/ul><div class=\'nova-product-description\'><div class=\'product-story\'><h3>Engineered for Excellence<\\/h3><p>Experience unmatched reliability and performance with the <strong>The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition<\\/strong>. Designed specifically for contemporary living, it seamlessly integrates advanced functionality with minimalist design aesthetics.<\\/p><h4>Key Highlights:<\\/h4><ul><li>High-efficiency performance tailored for demanding everyday tasks.<\\/li><li>Premium scratch-resistant and tactile finish.<\\/li><li>Backed by full NovaDrop manufacturer warranty.<\\/li><\\/ul><\\/div><\\/div>\",\"image_alt_text\":\"The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition product hero image showcase - NovaDrop Commer\"}}', 'done', NULL, NULL, '2026-08-25 21:56:57', '2026-08-25 21:56:57');
INSERT INTO `ai_agent_tasks` (`id`, `store_id`, `agent`, `input_json`, `output_text`, `status`, `approved_by`, `approved_at`, `created_at`, `updated_at`) VALUES
(48, 1, 'seo_content_generator', '{\"collection\":\"Outerwear & Cashmere\",\"slug\":\"buyers-guide-outerwear-2026\",\"title\":\"The Ultimate 2026 Buyer\'s Guide to Outerwear & Cashmere: Ergonomics, Durability & Performance\",\"schema\":{\"@context\":\"https:\\/\\/schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Outerwear & Cashmere products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}}', '<div class=\'seo-buyers-guide\'><h2>Why Quality Matters in Outerwear & Cashmere</h2><p>Choosing the right gear isn\'t just about aesthetics — it directly impacts your daily stamina, comfort, and productivity. In this guide, our engineering and ergonomics team breaks down the key factors to evaluate before investing.</p><h3>Top Recommended Options:</h3><div class=\'product-comparison-grid\'><div class=\'comparison-item\'><h4>The Atelier Cashmere Cocoon Coat — Next-Gen Edition — Next-Gen Edition — Next-Gen Edition (₹4,399.00)</h4><p>⚡ Superior Ergonomics &amp;amp; Build: Crafted with aircraft-grade durability and sleek modern aesthetics.🛡️ Certified Quality: 100% insp...</p></div><div class=\'comparison-item\'><h4>Double-Breasted Melton Wool Peacoat (₹5,699.00)</h4><p>Architectural virgin wool peacoat with anchor-embossed horn buttons and deep fleece-lined hand warmer pockets....</p></div></div><h3>Frequently Asked Questions</h3><div class=\'faq-accordion\'><div class=\'faq-q\'><strong>Q: What warranty is included?</strong><p>A: Full 1-year replacement warranty and 7-day returns.</p></div></div><script type=\'application/ld+json\'>{\"@context\":\"https://schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Outerwear & Cashmere products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}</script></div>', 'done', NULL, NULL, '2026-08-25 21:57:23', '2026-08-25 21:57:23'),
(49, 1, 'seo_content_generator', '{\"collection\":\"Okayama Selvedge Denim\",\"slug\":\"buyers-guide-denim-2026\",\"title\":\"The Ultimate 2026 Buyer\'s Guide to Okayama Selvedge Denim: Ergonomics, Durability & Performance\",\"schema\":{\"@context\":\"https:\\/\\/schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Okayama Selvedge Denim products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}}', '<div class=\'seo-buyers-guide\'><h2>Why Quality Matters in Okayama Selvedge Denim</h2><p>Choosing the right gear isn\'t just about aesthetics — it directly impacts your daily stamina, comfort, and productivity. In this guide, our engineering and ergonomics team breaks down the key factors to evaluate before investing.</p><h3>Top Recommended Options:</h3><div class=\'product-comparison-grid\'><div class=\'comparison-item\'><h4>Vintage Okayama 14.5oz Selvedge Trousers (₹4,299.00)</h4><p>Custom shuttle-loomed denim with vintage copper hardware and chain-stitched hems that develop personalized honeycombs and whiskers over time...</p></div><div class=\'comparison-item\'><h4>Type II Shuttle-Loom Denim Jacket (₹5,299.00)</h4><p>Iconic Type II jacket silhouette crafted on vintage Toyoda shuttle looms with red-line selvedge along the interior placket....</p></div></div><h3>Frequently Asked Questions</h3><div class=\'faq-accordion\'><div class=\'faq-q\'><strong>Q: What warranty is included?</strong><p>A: Full 1-year replacement warranty and 7-day returns.</p></div></div><script type=\'application/ld+json\'>{\"@context\":\"https://schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Okayama Selvedge Denim products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}</script></div>', 'done', NULL, NULL, '2026-08-25 21:57:23', '2026-08-25 21:57:23'),
(50, 1, 'seo_content_generator', '{\"collection\":\"Mulberry Silk Eveningwear\",\"slug\":\"buyers-guide-silk-2026\",\"title\":\"The Ultimate 2026 Buyer\'s Guide to Mulberry Silk Eveningwear: Ergonomics, Durability & Performance\",\"schema\":{\"@context\":\"https:\\/\\/schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Mulberry Silk Eveningwear products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}}', '<div class=\'seo-buyers-guide\'><h2>Why Quality Matters in Mulberry Silk Eveningwear</h2><p>Choosing the right gear isn\'t just about aesthetics — it directly impacts your daily stamina, comfort, and productivity. In this guide, our engineering and ergonomics team breaks down the key factors to evaluate before investing.</p><h3>Top Recommended Options:</h3><div class=\'product-comparison-grid\'><div class=\'comparison-item\'><h4>22-Momme Mulberry Silk Bias Slip Dress (₹4,999.00)</h4><p>Sandwashed pure Mulberry silk that drapes organically along bodily contours with liquid sheen and adjustable silk-cord straps....</p></div><div class=\'comparison-item\'><h4>Sandwashed Silk Charmeuse Blouse (₹3,799.00)</h4><p>Ultra-soft sandwashed silk charmeuse blouse with French cuffs and concealed placket for effortless sartorial styling....</p></div></div><h3>Frequently Asked Questions</h3><div class=\'faq-accordion\'><div class=\'faq-q\'><strong>Q: What warranty is included?</strong><p>A: Full 1-year replacement warranty and 7-day returns.</p></div></div><script type=\'application/ld+json\'>{\"@context\":\"https://schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Mulberry Silk Eveningwear products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}</script></div>', 'done', NULL, NULL, '2026-08-25 21:57:23', '2026-08-25 21:57:23'),
(51, 1, 'listing_writer', '{\"product_id\":1,\"raw_title\":\"The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition\",\"supplier_data\":[]}', '{\"raw_ai_generation\":{\"title\":\"The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition\",\"bullet_points\":[\"\\u26a1 Superior Ergonomics & Build: Crafted with aircraft-grade durability and sleek modern aesthetics.\",\"\\ud83d\\udee1\\ufe0f Certified Quality: 100% inspected and verified for peak performance and longevity.\",\"\\ud83d\\ude9a Express Free Shipping: Dispatched from certified fulfillment hubs with live AWB tracking.\",\"\\ud83d\\udc8e 7-Day Replacement Guarantee: Zero-risk shopping backed by 24\\/7 dedicated support.\"],\"long_description\":\"<div class=\'product-story\'><h3>Engineered for Excellence<\\/h3><p>Experience unmatched reliability and performance with the <strong>The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition<\\/strong>. Designed specifically for contemporary living, it seamlessly integrates advanced functionality with minimalist design aesthetics.<\\/p><h4>Key Highlights:<\\/h4><ul><li>High-efficiency performance tailored for demanding everyday tasks.<\\/li><li>Premium scratch-resistant and tactile finish.<\\/li><li>Backed by full NovaDrop manufacturer warranty.<\\/li><\\/ul><\\/div>\",\"seo_title\":\"The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition | Buy Online Best Price | NovaDrop\",\"seo_description\":\"Shop The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition online at NovaDrop India. Free express delivery, cash on delivery, and exclusive discount codes available today!\",\"image_alt_text\":\"The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition product hero image showcase - NovaDrop Commerce\"},\"moderation_passed\":true,\"flags_triggered\":[],\"approved_copy\":{\"title\":\"The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition\",\"seo_title\":\"The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edi\",\"seo_description\":\"Shop The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition online at NovaDrop India. Free express delivery, cash on de\",\"bullet_features_html\":\"<ul class=\'nova-bullet-features\'><li>\\u26a1 Superior Ergonomics &amp; Build: Crafted with aircraft-grade durability and sleek modern aesthetics.<\\/li><li>\\ud83d\\udee1\\ufe0f Certified Quality: 100% inspected and verified for peak performance and longevity.<\\/li><li>\\ud83d\\ude9a Express Free Shipping: Dispatched from certified fulfillment hubs with live AWB tracking.<\\/li><li>\\ud83d\\udc8e 7-Day Replacement Guarantee: Zero-risk shopping backed by 24\\/7 dedicated support.<\\/li><\\/ul>\",\"full_html_description\":\"<ul class=\'nova-bullet-features\'><li>\\u26a1 Superior Ergonomics &amp; Build: Crafted with aircraft-grade durability and sleek modern aesthetics.<\\/li><li>\\ud83d\\udee1\\ufe0f Certified Quality: 100% inspected and verified for peak performance and longevity.<\\/li><li>\\ud83d\\ude9a Express Free Shipping: Dispatched from certified fulfillment hubs with live AWB tracking.<\\/li><li>\\ud83d\\udc8e 7-Day Replacement Guarantee: Zero-risk shopping backed by 24\\/7 dedicated support.<\\/li><\\/ul><div class=\'nova-product-description\'><div class=\'product-story\'><h3>Engineered for Excellence<\\/h3><p>Experience unmatched reliability and performance with the <strong>The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition<\\/strong>. Designed specifically for contemporary living, it seamlessly integrates advanced functionality with minimalist design aesthetics.<\\/p><h4>Key Highlights:<\\/h4><ul><li>High-efficiency performance tailored for demanding everyday tasks.<\\/li><li>Premium scratch-resistant and tactile finish.<\\/li><li>Backed by full NovaDrop manufacturer warranty.<\\/li><\\/ul><\\/div><\\/div>\",\"image_alt_text\":\"The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition product hero image showc\"}}', 'done', NULL, NULL, '2026-08-25 21:57:23', '2026-08-25 21:57:23'),
(52, 1, 'seo_content_generator', '{\"collection\":\"Outerwear & Cashmere\",\"slug\":\"buyers-guide-outerwear-2026\",\"title\":\"The Ultimate 2026 Buyer\'s Guide to Outerwear & Cashmere: Ergonomics, Durability & Performance\",\"schema\":{\"@context\":\"https:\\/\\/schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Outerwear & Cashmere products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}}', '<div class=\'seo-buyers-guide\'><h2>Why Quality Matters in Outerwear & Cashmere</h2><p>Choosing the right gear isn\'t just about aesthetics — it directly impacts your daily stamina, comfort, and productivity. In this guide, our engineering and ergonomics team breaks down the key factors to evaluate before investing.</p><h3>Top Recommended Options:</h3><div class=\'product-comparison-grid\'><div class=\'comparison-item\'><h4>The Atelier Cashmere Cocoon Coat — Next-Gen Edition — Next-Gen Edition — Next-Gen Edition — Next-Gen Edition (₹4,399.00)</h4><p>⚡ Superior Ergonomics &amp;amp; Build: Crafted with aircraft-grade durability and sleek modern aesthetics.🛡️ Certified Quality: 100% insp...</p></div><div class=\'comparison-item\'><h4>Double-Breasted Melton Wool Peacoat (₹5,699.00)</h4><p>Architectural virgin wool peacoat with anchor-embossed horn buttons and deep fleece-lined hand warmer pockets....</p></div></div><h3>Frequently Asked Questions</h3><div class=\'faq-accordion\'><div class=\'faq-q\'><strong>Q: What warranty is included?</strong><p>A: Full 1-year replacement warranty and 7-day returns.</p></div></div><script type=\'application/ld+json\'>{\"@context\":\"https://schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Outerwear & Cashmere products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}</script></div>', 'done', NULL, NULL, '2026-08-25 21:57:54', '2026-08-25 21:57:54'),
(53, 1, 'seo_content_generator', '{\"collection\":\"Okayama Selvedge Denim\",\"slug\":\"buyers-guide-denim-2026\",\"title\":\"The Ultimate 2026 Buyer\'s Guide to Okayama Selvedge Denim: Ergonomics, Durability & Performance\",\"schema\":{\"@context\":\"https:\\/\\/schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Okayama Selvedge Denim products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}}', '<div class=\'seo-buyers-guide\'><h2>Why Quality Matters in Okayama Selvedge Denim</h2><p>Choosing the right gear isn\'t just about aesthetics — it directly impacts your daily stamina, comfort, and productivity. In this guide, our engineering and ergonomics team breaks down the key factors to evaluate before investing.</p><h3>Top Recommended Options:</h3><div class=\'product-comparison-grid\'><div class=\'comparison-item\'><h4>Vintage Okayama 14.5oz Selvedge Trousers (₹4,299.00)</h4><p>Custom shuttle-loomed denim with vintage copper hardware and chain-stitched hems that develop personalized honeycombs and whiskers over time...</p></div><div class=\'comparison-item\'><h4>Type II Shuttle-Loom Denim Jacket (₹5,299.00)</h4><p>Iconic Type II jacket silhouette crafted on vintage Toyoda shuttle looms with red-line selvedge along the interior placket....</p></div></div><h3>Frequently Asked Questions</h3><div class=\'faq-accordion\'><div class=\'faq-q\'><strong>Q: What warranty is included?</strong><p>A: Full 1-year replacement warranty and 7-day returns.</p></div></div><script type=\'application/ld+json\'>{\"@context\":\"https://schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Okayama Selvedge Denim products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}</script></div>', 'done', NULL, NULL, '2026-08-25 21:57:54', '2026-08-25 21:57:54'),
(54, 1, 'seo_content_generator', '{\"collection\":\"Mulberry Silk Eveningwear\",\"slug\":\"buyers-guide-silk-2026\",\"title\":\"The Ultimate 2026 Buyer\'s Guide to Mulberry Silk Eveningwear: Ergonomics, Durability & Performance\",\"schema\":{\"@context\":\"https:\\/\\/schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Mulberry Silk Eveningwear products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}}', '<div class=\'seo-buyers-guide\'><h2>Why Quality Matters in Mulberry Silk Eveningwear</h2><p>Choosing the right gear isn\'t just about aesthetics — it directly impacts your daily stamina, comfort, and productivity. In this guide, our engineering and ergonomics team breaks down the key factors to evaluate before investing.</p><h3>Top Recommended Options:</h3><div class=\'product-comparison-grid\'><div class=\'comparison-item\'><h4>22-Momme Mulberry Silk Bias Slip Dress (₹4,999.00)</h4><p>Sandwashed pure Mulberry silk that drapes organically along bodily contours with liquid sheen and adjustable silk-cord straps....</p></div><div class=\'comparison-item\'><h4>Sandwashed Silk Charmeuse Blouse (₹3,799.00)</h4><p>Ultra-soft sandwashed silk charmeuse blouse with French cuffs and concealed placket for effortless sartorial styling....</p></div></div><h3>Frequently Asked Questions</h3><div class=\'faq-accordion\'><div class=\'faq-q\'><strong>Q: What warranty is included?</strong><p>A: Full 1-year replacement warranty and 7-day returns.</p></div></div><script type=\'application/ld+json\'>{\"@context\":\"https://schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Mulberry Silk Eveningwear products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}</script></div>', 'done', NULL, NULL, '2026-08-25 21:57:54', '2026-08-25 21:57:54'),
(55, 1, 'listing_writer', '{\"product_id\":1,\"raw_title\":\"The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition\",\"supplier_data\":[]}', '{\"raw_ai_generation\":{\"title\":\"The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition\",\"bullet_points\":[\"\\u26a1 Superior Ergonomics & Build: Crafted with aircraft-grade durability and sleek modern aesthetics.\",\"\\ud83d\\udee1\\ufe0f Certified Quality: 100% inspected and verified for peak performance and longevity.\",\"\\ud83d\\ude9a Express Free Shipping: Dispatched from certified fulfillment hubs with live AWB tracking.\",\"\\ud83d\\udc8e 7-Day Replacement Guarantee: Zero-risk shopping backed by 24\\/7 dedicated support.\"],\"long_description\":\"<div class=\'product-story\'><h3>Engineered for Excellence<\\/h3><p>Experience unmatched reliability and performance with the <strong>The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition<\\/strong>. Designed specifically for contemporary living, it seamlessly integrates advanced functionality with minimalist design aesthetics.<\\/p><h4>Key Highlights:<\\/h4><ul><li>High-efficiency performance tailored for demanding everyday tasks.<\\/li><li>Premium scratch-resistant and tactile finish.<\\/li><li>Backed by full NovaDrop manufacturer warranty.<\\/li><\\/ul><\\/div>\",\"seo_title\":\"The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition | Buy Online Best Price | NovaDrop\",\"seo_description\":\"Shop The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition online at NovaDrop India. Free express delivery, cash on delivery, and exclusive discount codes available today!\",\"image_alt_text\":\"The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition product hero image showcase - NovaDrop Commerce\"},\"moderation_passed\":true,\"flags_triggered\":[],\"approved_copy\":{\"title\":\"The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition\",\"seo_title\":\"The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edi\",\"seo_description\":\"Shop The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition online at NovaDrop India. Free express\",\"bullet_features_html\":\"<ul class=\'nova-bullet-features\'><li>\\u26a1 Superior Ergonomics &amp; Build: Crafted with aircraft-grade durability and sleek modern aesthetics.<\\/li><li>\\ud83d\\udee1\\ufe0f Certified Quality: 100% inspected and verified for peak performance and longevity.<\\/li><li>\\ud83d\\ude9a Express Free Shipping: Dispatched from certified fulfillment hubs with live AWB tracking.<\\/li><li>\\ud83d\\udc8e 7-Day Replacement Guarantee: Zero-risk shopping backed by 24\\/7 dedicated support.<\\/li><\\/ul>\",\"full_html_description\":\"<ul class=\'nova-bullet-features\'><li>\\u26a1 Superior Ergonomics &amp; Build: Crafted with aircraft-grade durability and sleek modern aesthetics.<\\/li><li>\\ud83d\\udee1\\ufe0f Certified Quality: 100% inspected and verified for peak performance and longevity.<\\/li><li>\\ud83d\\ude9a Express Free Shipping: Dispatched from certified fulfillment hubs with live AWB tracking.<\\/li><li>\\ud83d\\udc8e 7-Day Replacement Guarantee: Zero-risk shopping backed by 24\\/7 dedicated support.<\\/li><\\/ul><div class=\'nova-product-description\'><div class=\'product-story\'><h3>Engineered for Excellence<\\/h3><p>Experience unmatched reliability and performance with the <strong>The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition<\\/strong>. Designed specifically for contemporary living, it seamlessly integrates advanced functionality with minimalist design aesthetics.<\\/p><h4>Key Highlights:<\\/h4><ul><li>High-efficiency performance tailored for demanding everyday tasks.<\\/li><li>Premium scratch-resistant and tactile finish.<\\/li><li>Backed by full NovaDrop manufacturer warranty.<\\/li><\\/ul><\\/div><\\/div>\",\"image_alt_text\":\"The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition pro\"}}', 'done', NULL, NULL, '2026-08-25 21:57:54', '2026-08-25 21:57:54'),
(56, 1, 'listing_writer', '{\"product_id\":1,\"raw_title\":\"The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition\",\"supplier_data\":[]}', '{\"raw_ai_generation\":{\"title\":\"The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition\",\"bullet_points\":[\"\\u26a1 Superior Ergonomics & Build: Crafted with aircraft-grade durability and sleek modern aesthetics.\",\"\\ud83d\\udee1\\ufe0f Certified Quality: 100% inspected and verified for peak performance and longevity.\",\"\\ud83d\\ude9a Express Free Shipping: Dispatched from certified fulfillment hubs with live AWB tracking.\",\"\\ud83d\\udc8e 7-Day Replacement Guarantee: Zero-risk shopping backed by 24\\/7 dedicated support.\"],\"long_description\":\"<div class=\'product-story\'><h3>Engineered for Excellence<\\/h3><p>Experience unmatched reliability and performance with the <strong>The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition<\\/strong>. Designed specifically for contemporary living, it seamlessly integrates advanced functionality with minimalist design aesthetics.<\\/p><h4>Key Highlights:<\\/h4><ul><li>High-efficiency performance tailored for demanding everyday tasks.<\\/li><li>Premium scratch-resistant and tactile finish.<\\/li><li>Backed by full NovaDrop manufacturer warranty.<\\/li><\\/ul><\\/div>\",\"seo_title\":\"The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition | Buy Online Best Price | NovaDrop\",\"seo_description\":\"Shop The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition online at NovaDrop India. Free express delivery, cash on delivery, and exclusive discount codes available today!\",\"image_alt_text\":\"The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition product hero image showcase - NovaDrop Commerce\"},\"moderation_passed\":true,\"flags_triggered\":[],\"approved_copy\":{\"title\":\"The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition\",\"seo_title\":\"The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edi\",\"seo_description\":\"Shop The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition online at NovaDro\",\"bullet_features_html\":\"<ul class=\'nova-bullet-features\'><li>\\u26a1 Superior Ergonomics &amp; Build: Crafted with aircraft-grade durability and sleek modern aesthetics.<\\/li><li>\\ud83d\\udee1\\ufe0f Certified Quality: 100% inspected and verified for peak performance and longevity.<\\/li><li>\\ud83d\\ude9a Express Free Shipping: Dispatched from certified fulfillment hubs with live AWB tracking.<\\/li><li>\\ud83d\\udc8e 7-Day Replacement Guarantee: Zero-risk shopping backed by 24\\/7 dedicated support.<\\/li><\\/ul>\",\"full_html_description\":\"<ul class=\'nova-bullet-features\'><li>\\u26a1 Superior Ergonomics &amp; Build: Crafted with aircraft-grade durability and sleek modern aesthetics.<\\/li><li>\\ud83d\\udee1\\ufe0f Certified Quality: 100% inspected and verified for peak performance and longevity.<\\/li><li>\\ud83d\\ude9a Express Free Shipping: Dispatched from certified fulfillment hubs with live AWB tracking.<\\/li><li>\\ud83d\\udc8e 7-Day Replacement Guarantee: Zero-risk shopping backed by 24\\/7 dedicated support.<\\/li><\\/ul><div class=\'nova-product-description\'><div class=\'product-story\'><h3>Engineered for Excellence<\\/h3><p>Experience unmatched reliability and performance with the <strong>The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition<\\/strong>. Designed specifically for contemporary living, it seamlessly integrates advanced functionality with minimalist design aesthetics.<\\/p><h4>Key Highlights:<\\/h4><ul><li>High-efficiency performance tailored for demanding everyday tasks.<\\/li><li>Premium scratch-resistant and tactile finish.<\\/li><li>Backed by full NovaDrop manufacturer warranty.<\\/li><\\/ul><\\/div><\\/div>\",\"image_alt_text\":\"The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014\"}}', 'done', NULL, NULL, '2026-08-25 21:57:54', '2026-08-25 21:57:54'),
(57, 1, 'finance_reconciliation', '{\"audited_count\":4,\"total_revenue\":25445.82,\"mismatches_count\":1,\"mismatches\":[{\"order_id\":1,\"order_number\":\"#ND-1001\",\"type\":\"UNDERPAYMENT_OR_UNMATCHED_GATEWAY_RECORD\",\"order_total\":2948.82,\"captured\":0,\"variance\":2948.82}],\"reconciliation_code\":\"MISMATCH_DETECTED\"}', '💰 Finance Reconciliation Statement [25 Aug 2026]:\n• Orders Audited: 4 (Total Value: ₹25,445.82)\n• Mismatches / Leaks: 1\n• Total Variance Delta: ₹2,948.82\n• Reconciliation Status: MISMATCH_DETECTED', 'done', NULL, NULL, '2026-08-25 21:57:54', '2026-08-25 21:57:54'),
(58, 1, 'seo_content_generator', '{\"collection\":\"Outerwear & Cashmere\",\"slug\":\"buyers-guide-outerwear-2026\",\"title\":\"The Ultimate 2026 Buyer\'s Guide to Outerwear & Cashmere: Ergonomics, Durability & Performance\",\"schema\":{\"@context\":\"https:\\/\\/schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Outerwear & Cashmere products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}}', '<div class=\'seo-buyers-guide\'><h2>Why Quality Matters in Outerwear & Cashmere</h2><p>Choosing the right gear isn\'t just about aesthetics — it directly impacts your daily stamina, comfort, and productivity. In this guide, our engineering and ergonomics team breaks down the key factors to evaluate before investing.</p><h3>Top Recommended Options:</h3><div class=\'product-comparison-grid\'><div class=\'comparison-item\'><h4>The Atelier Cashmere Cocoon Coat — Next-Gen Edition — Next-Gen Edition — Next-Gen Edition — Next-Gen Edition — Next-Gen Edition — Next-Gen Edition (₹4,399.00)</h4><p>⚡ Superior Ergonomics &amp;amp; Build: Crafted with aircraft-grade durability and sleek modern aesthetics.🛡️ Certified Quality: 100% insp...</p></div><div class=\'comparison-item\'><h4>Double-Breasted Melton Wool Peacoat (₹5,699.00)</h4><p>Architectural virgin wool peacoat with anchor-embossed horn buttons and deep fleece-lined hand warmer pockets....</p></div></div><h3>Frequently Asked Questions</h3><div class=\'faq-accordion\'><div class=\'faq-q\'><strong>Q: What warranty is included?</strong><p>A: Full 1-year replacement warranty and 7-day returns.</p></div></div><script type=\'application/ld+json\'>{\"@context\":\"https://schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Outerwear & Cashmere products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}</script></div>', 'done', NULL, NULL, '2026-08-25 21:58:09', '2026-08-25 21:58:09'),
(59, 1, 'seo_content_generator', '{\"collection\":\"Okayama Selvedge Denim\",\"slug\":\"buyers-guide-denim-2026\",\"title\":\"The Ultimate 2026 Buyer\'s Guide to Okayama Selvedge Denim: Ergonomics, Durability & Performance\",\"schema\":{\"@context\":\"https:\\/\\/schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Okayama Selvedge Denim products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}}', '<div class=\'seo-buyers-guide\'><h2>Why Quality Matters in Okayama Selvedge Denim</h2><p>Choosing the right gear isn\'t just about aesthetics — it directly impacts your daily stamina, comfort, and productivity. In this guide, our engineering and ergonomics team breaks down the key factors to evaluate before investing.</p><h3>Top Recommended Options:</h3><div class=\'product-comparison-grid\'><div class=\'comparison-item\'><h4>Vintage Okayama 14.5oz Selvedge Trousers (₹4,299.00)</h4><p>Custom shuttle-loomed denim with vintage copper hardware and chain-stitched hems that develop personalized honeycombs and whiskers over time...</p></div><div class=\'comparison-item\'><h4>Type II Shuttle-Loom Denim Jacket (₹5,299.00)</h4><p>Iconic Type II jacket silhouette crafted on vintage Toyoda shuttle looms with red-line selvedge along the interior placket....</p></div></div><h3>Frequently Asked Questions</h3><div class=\'faq-accordion\'><div class=\'faq-q\'><strong>Q: What warranty is included?</strong><p>A: Full 1-year replacement warranty and 7-day returns.</p></div></div><script type=\'application/ld+json\'>{\"@context\":\"https://schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Okayama Selvedge Denim products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}</script></div>', 'done', NULL, NULL, '2026-08-25 21:58:09', '2026-08-25 21:58:09'),
(60, 1, 'seo_content_generator', '{\"collection\":\"Mulberry Silk Eveningwear\",\"slug\":\"buyers-guide-silk-2026\",\"title\":\"The Ultimate 2026 Buyer\'s Guide to Mulberry Silk Eveningwear: Ergonomics, Durability & Performance\",\"schema\":{\"@context\":\"https:\\/\\/schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Mulberry Silk Eveningwear products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}}', '<div class=\'seo-buyers-guide\'><h2>Why Quality Matters in Mulberry Silk Eveningwear</h2><p>Choosing the right gear isn\'t just about aesthetics — it directly impacts your daily stamina, comfort, and productivity. In this guide, our engineering and ergonomics team breaks down the key factors to evaluate before investing.</p><h3>Top Recommended Options:</h3><div class=\'product-comparison-grid\'><div class=\'comparison-item\'><h4>22-Momme Mulberry Silk Bias Slip Dress (₹4,999.00)</h4><p>Sandwashed pure Mulberry silk that drapes organically along bodily contours with liquid sheen and adjustable silk-cord straps....</p></div><div class=\'comparison-item\'><h4>Sandwashed Silk Charmeuse Blouse (₹3,799.00)</h4><p>Ultra-soft sandwashed silk charmeuse blouse with French cuffs and concealed placket for effortless sartorial styling....</p></div></div><h3>Frequently Asked Questions</h3><div class=\'faq-accordion\'><div class=\'faq-q\'><strong>Q: What warranty is included?</strong><p>A: Full 1-year replacement warranty and 7-day returns.</p></div></div><script type=\'application/ld+json\'>{\"@context\":\"https://schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Mulberry Silk Eveningwear products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}</script></div>', 'done', NULL, NULL, '2026-08-25 21:58:09', '2026-08-25 21:58:09'),
(61, 1, 'listing_writer', '{\"product_id\":1,\"raw_title\":\"The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition\",\"supplier_data\":[]}', '{\"raw_ai_generation\":{\"title\":\"The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition\",\"bullet_points\":[\"\\u26a1 Superior Ergonomics & Build: Crafted with aircraft-grade durability and sleek modern aesthetics.\",\"\\ud83d\\udee1\\ufe0f Certified Quality: 100% inspected and verified for peak performance and longevity.\",\"\\ud83d\\ude9a Express Free Shipping: Dispatched from certified fulfillment hubs with live AWB tracking.\",\"\\ud83d\\udc8e 7-Day Replacement Guarantee: Zero-risk shopping backed by 24\\/7 dedicated support.\"],\"long_description\":\"<div class=\'product-story\'><h3>Engineered for Excellence<\\/h3><p>Experience unmatched reliability and performance with the <strong>The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition<\\/strong>. Designed specifically for contemporary living, it seamlessly integrates advanced functionality with minimalist design aesthetics.<\\/p><h4>Key Highlights:<\\/h4><ul><li>High-efficiency performance tailored for demanding everyday tasks.<\\/li><li>Premium scratch-resistant and tactile finish.<\\/li><li>Backed by full NovaDrop manufacturer warranty.<\\/li><\\/ul><\\/div>\",\"seo_title\":\"The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition | Buy Online Best Price | NovaDrop\",\"seo_description\":\"Shop The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition online at NovaDrop India. Free express delivery, cash on delivery, and exclusive discount codes available today!\",\"image_alt_text\":\"The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition product hero image showcase - NovaDrop Commerce\"},\"moderation_passed\":true,\"flags_triggered\":[],\"approved_copy\":{\"title\":\"The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition\",\"seo_title\":\"The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edi\",\"seo_description\":\"Shop The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edit\",\"bullet_features_html\":\"<ul class=\'nova-bullet-features\'><li>\\u26a1 Superior Ergonomics &amp; Build: Crafted with aircraft-grade durability and sleek modern aesthetics.<\\/li><li>\\ud83d\\udee1\\ufe0f Certified Quality: 100% inspected and verified for peak performance and longevity.<\\/li><li>\\ud83d\\ude9a Express Free Shipping: Dispatched from certified fulfillment hubs with live AWB tracking.<\\/li><li>\\ud83d\\udc8e 7-Day Replacement Guarantee: Zero-risk shopping backed by 24\\/7 dedicated support.<\\/li><\\/ul>\",\"full_html_description\":\"<ul class=\'nova-bullet-features\'><li>\\u26a1 Superior Ergonomics &amp; Build: Crafted with aircraft-grade durability and sleek modern aesthetics.<\\/li><li>\\ud83d\\udee1\\ufe0f Certified Quality: 100% inspected and verified for peak performance and longevity.<\\/li><li>\\ud83d\\ude9a Express Free Shipping: Dispatched from certified fulfillment hubs with live AWB tracking.<\\/li><li>\\ud83d\\udc8e 7-Day Replacement Guarantee: Zero-risk shopping backed by 24\\/7 dedicated support.<\\/li><\\/ul><div class=\'nova-product-description\'><div class=\'product-story\'><h3>Engineered for Excellence<\\/h3><p>Experience unmatched reliability and performance with the <strong>The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition<\\/strong>. Designed specifically for contemporary living, it seamlessly integrates advanced functionality with minimalist design aesthetics.<\\/p><h4>Key Highlights:<\\/h4><ul><li>High-efficiency performance tailored for demanding everyday tasks.<\\/li><li>Premium scratch-resistant and tactile finish.<\\/li><li>Backed by full NovaDrop manufacturer warranty.<\\/li><\\/ul><\\/div><\\/div>\",\"image_alt_text\":\"The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014\"}}', 'done', NULL, NULL, '2026-08-25 21:58:09', '2026-08-25 21:58:09'),
(62, 1, 'listing_writer', '{\"product_id\":1,\"raw_title\":\"The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition\",\"supplier_data\":[]}', '{\"raw_ai_generation\":{\"title\":\"The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition\",\"bullet_points\":[\"\\u26a1 Superior Ergonomics & Build: Crafted with aircraft-grade durability and sleek modern aesthetics.\",\"\\ud83d\\udee1\\ufe0f Certified Quality: 100% inspected and verified for peak performance and longevity.\",\"\\ud83d\\ude9a Express Free Shipping: Dispatched from certified fulfillment hubs with live AWB tracking.\",\"\\ud83d\\udc8e 7-Day Replacement Guarantee: Zero-risk shopping backed by 24\\/7 dedicated support.\"],\"long_description\":\"<div class=\'product-story\'><h3>Engineered for Excellence<\\/h3><p>Experience unmatched reliability and performance with the <strong>The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition<\\/strong>. Designed specifically for contemporary living, it seamlessly integrates advanced functionality with minimalist design aesthetics.<\\/p><h4>Key Highlights:<\\/h4><ul><li>High-efficiency performance tailored for demanding everyday tasks.<\\/li><li>Premium scratch-resistant and tactile finish.<\\/li><li>Backed by full NovaDrop manufacturer warranty.<\\/li><\\/ul><\\/div>\",\"seo_title\":\"The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition | Buy Online Best Price | NovaDrop\",\"seo_description\":\"Shop The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition online at NovaDrop India. Free express delivery, cash on delivery, and exclusive discount codes available today!\",\"image_alt_text\":\"The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition product hero image showcase - NovaDrop Commerce\"},\"moderation_passed\":true,\"flags_triggered\":[],\"approved_copy\":{\"title\":\"The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition\",\"seo_title\":\"The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edi\",\"seo_description\":\"Shop The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edit\",\"bullet_features_html\":\"<ul class=\'nova-bullet-features\'><li>\\u26a1 Superior Ergonomics &amp; Build: Crafted with aircraft-grade durability and sleek modern aesthetics.<\\/li><li>\\ud83d\\udee1\\ufe0f Certified Quality: 100% inspected and verified for peak performance and longevity.<\\/li><li>\\ud83d\\ude9a Express Free Shipping: Dispatched from certified fulfillment hubs with live AWB tracking.<\\/li><li>\\ud83d\\udc8e 7-Day Replacement Guarantee: Zero-risk shopping backed by 24\\/7 dedicated support.<\\/li><\\/ul>\",\"full_html_description\":\"<ul class=\'nova-bullet-features\'><li>\\u26a1 Superior Ergonomics &amp; Build: Crafted with aircraft-grade durability and sleek modern aesthetics.<\\/li><li>\\ud83d\\udee1\\ufe0f Certified Quality: 100% inspected and verified for peak performance and longevity.<\\/li><li>\\ud83d\\ude9a Express Free Shipping: Dispatched from certified fulfillment hubs with live AWB tracking.<\\/li><li>\\ud83d\\udc8e 7-Day Replacement Guarantee: Zero-risk shopping backed by 24\\/7 dedicated support.<\\/li><\\/ul><div class=\'nova-product-description\'><div class=\'product-story\'><h3>Engineered for Excellence<\\/h3><p>Experience unmatched reliability and performance with the <strong>The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition<\\/strong>. Designed specifically for contemporary living, it seamlessly integrates advanced functionality with minimalist design aesthetics.<\\/p><h4>Key Highlights:<\\/h4><ul><li>High-efficiency performance tailored for demanding everyday tasks.<\\/li><li>Premium scratch-resistant and tactile finish.<\\/li><li>Backed by full NovaDrop manufacturer warranty.<\\/li><\\/ul><\\/div><\\/div>\",\"image_alt_text\":\"The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014\"}}', 'done', NULL, NULL, '2026-08-25 21:58:10', '2026-08-25 21:58:10'),
(63, 1, 'finance_reconciliation', '{\"audited_count\":4,\"total_revenue\":25445.82,\"mismatches_count\":1,\"mismatches\":[{\"order_id\":1,\"order_number\":\"#ND-1001\",\"type\":\"UNDERPAYMENT_OR_UNMATCHED_GATEWAY_RECORD\",\"order_total\":2948.82,\"captured\":0,\"variance\":2948.82}],\"reconciliation_code\":\"MISMATCH_DETECTED\"}', '💰 Finance Reconciliation Statement [25 Aug 2026]:\n• Orders Audited: 4 (Total Value: ₹25,445.82)\n• Mismatches / Leaks: 1\n• Total Variance Delta: ₹2,948.82\n• Reconciliation Status: MISMATCH_DETECTED', 'done', NULL, NULL, '2026-08-25 21:58:10', '2026-08-25 21:58:10');
INSERT INTO `ai_agent_tasks` (`id`, `store_id`, `agent`, `input_json`, `output_text`, `status`, `approved_by`, `approved_at`, `created_at`, `updated_at`) VALUES
(64, 1, 'vendor_whatsapp_dispatch', '{\"vendor_id\":2,\"phone\":\"+919870330064\",\"order_id\":7}', 'Hello Kenji Takahashi! 🚀 New Order *#03003* has been assigned to *Okayama Selvedge Guild*.\n\nItems to Dispatch:\n• The Atelier Cashmere Cocoon Coat (x1)\n\nTotal: ₹7,499.00 (Net: ₹6,599.12)\nPlease log in to your Seller Portal to generate shipping label & dispatch:\n👉 http://localhost/Dropshipping/vendor/orders', 'done', NULL, NULL, '2026-08-25 21:58:10', '2026-08-25 21:58:10'),
(65, 1, 'daily_digest', '{\"gross_revenue\":0,\"orders_count\":0,\"aov\":0,\"low_stock_count\":0,\"failed_payments\":0,\"top_skus\":[]}', '📊 NovaDrop Daily Executive Digest [25 Aug 2026]:\n• Gross GMV: ₹0.00 across 0 orders (AOV: ₹0.00)\n• Estimated Net Profit: ₹0.00 (Margin ~62.6%)\n• Top Products: No items sold yet today.\n• Critical Low-Stock SKUs: 0 items\n• Failed Payment Alerts: 0', 'done', NULL, NULL, '2026-08-25 21:58:10', '2026-08-25 21:58:10'),
(66, 1, 'finance_reconciliation', '{\"audited_count\":4,\"total_revenue\":25445.82,\"mismatches_count\":1,\"mismatches\":[{\"order_id\":1,\"order_number\":\"#ND-1001\",\"type\":\"UNDERPAYMENT_OR_UNMATCHED_GATEWAY_RECORD\",\"order_total\":2948.82,\"captured\":0,\"variance\":2948.82}],\"reconciliation_code\":\"MISMATCH_DETECTED\"}', '💰 Finance Reconciliation Statement [25 Aug 2026]:\n• Orders Audited: 4 (Total Value: ₹25,445.82)\n• Mismatches / Leaks: 1\n• Total Variance Delta: ₹2,948.82\n• Reconciliation Status: MISMATCH_DETECTED', 'done', NULL, NULL, '2026-08-25 21:58:10', '2026-08-25 21:58:10'),
(67, 1, 'vendor_whatsapp_dispatch', '{\"vendor_id\":2,\"phone\":\"+919870330064\",\"order_id\":7}', 'Hello Kenji Takahashi! 🚀 New Order *#03003* has been assigned to *Okayama Selvedge Guild*.\n\nItems to Dispatch:\n• The Atelier Cashmere Cocoon Coat (x1)\n\nTotal: ₹7,499.00 (Net: ₹6,599.12)\nPlease log in to your Seller Portal to generate shipping label & dispatch:\n👉 http://localhost/Dropshipping/vendor/orders', 'done', NULL, NULL, '2026-08-25 21:58:10', '2026-08-25 21:58:10'),
(68, 1, 'seo_content_generator', '{\"collection\":\"Outerwear & Cashmere\",\"slug\":\"buyers-guide-outerwear-2026\",\"title\":\"The Ultimate 2026 Buyer\'s Guide to Outerwear & Cashmere: Ergonomics, Durability & Performance\",\"schema\":{\"@context\":\"https:\\/\\/schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Outerwear & Cashmere products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}}', '<div class=\'seo-buyers-guide\'><h2>Why Quality Matters in Outerwear & Cashmere</h2><p>Choosing the right gear isn\'t just about aesthetics — it directly impacts your daily stamina, comfort, and productivity. In this guide, our engineering and ergonomics team breaks down the key factors to evaluate before investing.</p><h3>Top Recommended Options:</h3><div class=\'product-comparison-grid\'><div class=\'comparison-item\'><h4>The Atelier Cashmere Cocoon Coat — Next-Gen Edition — Next-Gen Edition — Next-Gen Edition — Next-Gen Edition — Next-Gen Edition — Next-Gen Edition — Next-Gen Edition — Next-Gen Edition (₹4,399.00)</h4><p>⚡ Superior Ergonomics &amp;amp; Build: Crafted with aircraft-grade durability and sleek modern aesthetics.🛡️ Certified Quality: 100% insp...</p></div><div class=\'comparison-item\'><h4>Double-Breasted Melton Wool Peacoat (₹5,699.00)</h4><p>Architectural virgin wool peacoat with anchor-embossed horn buttons and deep fleece-lined hand warmer pockets....</p></div></div><h3>Frequently Asked Questions</h3><div class=\'faq-accordion\'><div class=\'faq-q\'><strong>Q: What warranty is included?</strong><p>A: Full 1-year replacement warranty and 7-day returns.</p></div></div><script type=\'application/ld+json\'>{\"@context\":\"https://schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Outerwear & Cashmere products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}</script></div>', 'done', NULL, NULL, '2026-08-25 21:58:10', '2026-08-25 21:58:10'),
(69, 1, 'seo_content_generator', '{\"collection\":\"Okayama Selvedge Denim\",\"slug\":\"buyers-guide-denim-2026\",\"title\":\"The Ultimate 2026 Buyer\'s Guide to Okayama Selvedge Denim: Ergonomics, Durability & Performance\",\"schema\":{\"@context\":\"https:\\/\\/schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Okayama Selvedge Denim products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}}', '<div class=\'seo-buyers-guide\'><h2>Why Quality Matters in Okayama Selvedge Denim</h2><p>Choosing the right gear isn\'t just about aesthetics — it directly impacts your daily stamina, comfort, and productivity. In this guide, our engineering and ergonomics team breaks down the key factors to evaluate before investing.</p><h3>Top Recommended Options:</h3><div class=\'product-comparison-grid\'><div class=\'comparison-item\'><h4>Vintage Okayama 14.5oz Selvedge Trousers (₹4,299.00)</h4><p>Custom shuttle-loomed denim with vintage copper hardware and chain-stitched hems that develop personalized honeycombs and whiskers over time...</p></div><div class=\'comparison-item\'><h4>Type II Shuttle-Loom Denim Jacket (₹5,299.00)</h4><p>Iconic Type II jacket silhouette crafted on vintage Toyoda shuttle looms with red-line selvedge along the interior placket....</p></div></div><h3>Frequently Asked Questions</h3><div class=\'faq-accordion\'><div class=\'faq-q\'><strong>Q: What warranty is included?</strong><p>A: Full 1-year replacement warranty and 7-day returns.</p></div></div><script type=\'application/ld+json\'>{\"@context\":\"https://schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Okayama Selvedge Denim products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}</script></div>', 'done', NULL, NULL, '2026-08-25 21:58:10', '2026-08-25 21:58:10'),
(70, 1, 'seo_content_generator', '{\"collection\":\"Mulberry Silk Eveningwear\",\"slug\":\"buyers-guide-silk-2026\",\"title\":\"The Ultimate 2026 Buyer\'s Guide to Mulberry Silk Eveningwear: Ergonomics, Durability & Performance\",\"schema\":{\"@context\":\"https:\\/\\/schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Mulberry Silk Eveningwear products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}}', '<div class=\'seo-buyers-guide\'><h2>Why Quality Matters in Mulberry Silk Eveningwear</h2><p>Choosing the right gear isn\'t just about aesthetics — it directly impacts your daily stamina, comfort, and productivity. In this guide, our engineering and ergonomics team breaks down the key factors to evaluate before investing.</p><h3>Top Recommended Options:</h3><div class=\'product-comparison-grid\'><div class=\'comparison-item\'><h4>22-Momme Mulberry Silk Bias Slip Dress (₹4,999.00)</h4><p>Sandwashed pure Mulberry silk that drapes organically along bodily contours with liquid sheen and adjustable silk-cord straps....</p></div><div class=\'comparison-item\'><h4>Sandwashed Silk Charmeuse Blouse (₹3,799.00)</h4><p>Ultra-soft sandwashed silk charmeuse blouse with French cuffs and concealed placket for effortless sartorial styling....</p></div></div><h3>Frequently Asked Questions</h3><div class=\'faq-accordion\'><div class=\'faq-q\'><strong>Q: What warranty is included?</strong><p>A: Full 1-year replacement warranty and 7-day returns.</p></div></div><script type=\'application/ld+json\'>{\"@context\":\"https://schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Mulberry Silk Eveningwear products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}</script></div>', 'done', NULL, NULL, '2026-08-25 21:58:10', '2026-08-25 21:58:10'),
(71, 1, 'listing_writer', '{\"product_id\":1,\"raw_title\":\"The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition\",\"supplier_data\":[]}', '{\"raw_ai_generation\":{\"title\":\"The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition\",\"bullet_points\":[\"\\u26a1 Superior Ergonomics & Build: Crafted with aircraft-grade durability and sleek modern aesthetics.\",\"\\ud83d\\udee1\\ufe0f Certified Quality: 100% inspected and verified for peak performance and longevity.\",\"\\ud83d\\ude9a Express Free Shipping: Dispatched from certified fulfillment hubs with live AWB tracking.\",\"\\ud83d\\udc8e 7-Day Replacement Guarantee: Zero-risk shopping backed by 24\\/7 dedicated support.\"],\"long_description\":\"<div class=\'product-story\'><h3>Engineered for Excellence<\\/h3><p>Experience unmatched reliability and performance with the <strong>The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition<\\/strong>. Designed specifically for contemporary living, it seamlessly integrates advanced functionality with minimalist design aesthetics.<\\/p><h4>Key Highlights:<\\/h4><ul><li>High-efficiency performance tailored for demanding everyday tasks.<\\/li><li>Premium scratch-resistant and tactile finish.<\\/li><li>Backed by full NovaDrop manufacturer warranty.<\\/li><\\/ul><\\/div>\",\"seo_title\":\"The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition | Buy Online Best Price | NovaDrop\",\"seo_description\":\"Shop The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition online at NovaDrop India. Free express delivery, cash on delivery, and exclusive discount codes available today!\",\"image_alt_text\":\"The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition product hero image showcase - NovaDrop Commerce\"},\"moderation_passed\":true,\"flags_triggered\":[],\"approved_copy\":{\"title\":\"The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition\",\"seo_title\":\"The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edi\",\"seo_description\":\"Shop The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edit\",\"bullet_features_html\":\"<ul class=\'nova-bullet-features\'><li>\\u26a1 Superior Ergonomics &amp; Build: Crafted with aircraft-grade durability and sleek modern aesthetics.<\\/li><li>\\ud83d\\udee1\\ufe0f Certified Quality: 100% inspected and verified for peak performance and longevity.<\\/li><li>\\ud83d\\ude9a Express Free Shipping: Dispatched from certified fulfillment hubs with live AWB tracking.<\\/li><li>\\ud83d\\udc8e 7-Day Replacement Guarantee: Zero-risk shopping backed by 24\\/7 dedicated support.<\\/li><\\/ul>\",\"full_html_description\":\"<ul class=\'nova-bullet-features\'><li>\\u26a1 Superior Ergonomics &amp; Build: Crafted with aircraft-grade durability and sleek modern aesthetics.<\\/li><li>\\ud83d\\udee1\\ufe0f Certified Quality: 100% inspected and verified for peak performance and longevity.<\\/li><li>\\ud83d\\ude9a Express Free Shipping: Dispatched from certified fulfillment hubs with live AWB tracking.<\\/li><li>\\ud83d\\udc8e 7-Day Replacement Guarantee: Zero-risk shopping backed by 24\\/7 dedicated support.<\\/li><\\/ul><div class=\'nova-product-description\'><div class=\'product-story\'><h3>Engineered for Excellence<\\/h3><p>Experience unmatched reliability and performance with the <strong>The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition<\\/strong>. Designed specifically for contemporary living, it seamlessly integrates advanced functionality with minimalist design aesthetics.<\\/p><h4>Key Highlights:<\\/h4><ul><li>High-efficiency performance tailored for demanding everyday tasks.<\\/li><li>Premium scratch-resistant and tactile finish.<\\/li><li>Backed by full NovaDrop manufacturer warranty.<\\/li><\\/ul><\\/div><\\/div>\",\"image_alt_text\":\"The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014\"}}', 'done', NULL, NULL, '2026-08-25 21:58:10', '2026-08-25 21:58:10'),
(72, 1, 'seo_content_generator', '{\"collection\":\"Outerwear & Cashmere\",\"slug\":\"buyers-guide-outerwear-2026\",\"title\":\"The Ultimate 2026 Buyer\'s Guide to Outerwear & Cashmere: Ergonomics, Durability & Performance\",\"schema\":{\"@context\":\"https:\\/\\/schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Outerwear & Cashmere products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}}', '<div class=\'seo-buyers-guide\'><h2>Why Quality Matters in Outerwear & Cashmere</h2><p>Choosing the right gear isn\'t just about aesthetics — it directly impacts your daily stamina, comfort, and productivity. In this guide, our engineering and ergonomics team breaks down the key factors to evaluate before investing.</p><h3>Top Recommended Options:</h3><div class=\'product-comparison-grid\'><div class=\'comparison-item\'><h4>The Atelier Cashmere Cocoon Coat — Next-Gen Edition — Next-Gen Edition — Next-Gen Edition — Next-Gen Edition — Next-Gen Edition — Next-Gen Edition — Next-Gen Edition — Next-Gen Edition — Next-Gen Edition (₹4,399.00)</h4><p>⚡ Superior Ergonomics &amp;amp; Build: Crafted with aircraft-grade durability and sleek modern aesthetics.🛡️ Certified Quality: 100% insp...</p></div><div class=\'comparison-item\'><h4>Double-Breasted Melton Wool Peacoat (₹5,699.00)</h4><p>Architectural virgin wool peacoat with anchor-embossed horn buttons and deep fleece-lined hand warmer pockets....</p></div></div><h3>Frequently Asked Questions</h3><div class=\'faq-accordion\'><div class=\'faq-q\'><strong>Q: What warranty is included?</strong><p>A: Full 1-year replacement warranty and 7-day returns.</p></div></div><script type=\'application/ld+json\'>{\"@context\":\"https://schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Outerwear & Cashmere products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}</script></div>', 'done', NULL, NULL, '2026-08-25 21:58:37', '2026-08-25 21:58:37'),
(73, 1, 'seo_content_generator', '{\"collection\":\"Okayama Selvedge Denim\",\"slug\":\"buyers-guide-denim-2026\",\"title\":\"The Ultimate 2026 Buyer\'s Guide to Okayama Selvedge Denim: Ergonomics, Durability & Performance\",\"schema\":{\"@context\":\"https:\\/\\/schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Okayama Selvedge Denim products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}}', '<div class=\'seo-buyers-guide\'><h2>Why Quality Matters in Okayama Selvedge Denim</h2><p>Choosing the right gear isn\'t just about aesthetics — it directly impacts your daily stamina, comfort, and productivity. In this guide, our engineering and ergonomics team breaks down the key factors to evaluate before investing.</p><h3>Top Recommended Options:</h3><div class=\'product-comparison-grid\'><div class=\'comparison-item\'><h4>Vintage Okayama 14.5oz Selvedge Trousers (₹4,299.00)</h4><p>Custom shuttle-loomed denim with vintage copper hardware and chain-stitched hems that develop personalized honeycombs and whiskers over time...</p></div><div class=\'comparison-item\'><h4>Type II Shuttle-Loom Denim Jacket (₹5,299.00)</h4><p>Iconic Type II jacket silhouette crafted on vintage Toyoda shuttle looms with red-line selvedge along the interior placket....</p></div></div><h3>Frequently Asked Questions</h3><div class=\'faq-accordion\'><div class=\'faq-q\'><strong>Q: What warranty is included?</strong><p>A: Full 1-year replacement warranty and 7-day returns.</p></div></div><script type=\'application/ld+json\'>{\"@context\":\"https://schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Okayama Selvedge Denim products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}</script></div>', 'done', NULL, NULL, '2026-08-25 21:58:37', '2026-08-25 21:58:37'),
(74, 1, 'seo_content_generator', '{\"collection\":\"Mulberry Silk Eveningwear\",\"slug\":\"buyers-guide-silk-2026\",\"title\":\"The Ultimate 2026 Buyer\'s Guide to Mulberry Silk Eveningwear: Ergonomics, Durability & Performance\",\"schema\":{\"@context\":\"https:\\/\\/schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Mulberry Silk Eveningwear products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}}', '<div class=\'seo-buyers-guide\'><h2>Why Quality Matters in Mulberry Silk Eveningwear</h2><p>Choosing the right gear isn\'t just about aesthetics — it directly impacts your daily stamina, comfort, and productivity. In this guide, our engineering and ergonomics team breaks down the key factors to evaluate before investing.</p><h3>Top Recommended Options:</h3><div class=\'product-comparison-grid\'><div class=\'comparison-item\'><h4>22-Momme Mulberry Silk Bias Slip Dress (₹4,999.00)</h4><p>Sandwashed pure Mulberry silk that drapes organically along bodily contours with liquid sheen and adjustable silk-cord straps....</p></div><div class=\'comparison-item\'><h4>Sandwashed Silk Charmeuse Blouse (₹3,799.00)</h4><p>Ultra-soft sandwashed silk charmeuse blouse with French cuffs and concealed placket for effortless sartorial styling....</p></div></div><h3>Frequently Asked Questions</h3><div class=\'faq-accordion\'><div class=\'faq-q\'><strong>Q: What warranty is included?</strong><p>A: Full 1-year replacement warranty and 7-day returns.</p></div></div><script type=\'application/ld+json\'>{\"@context\":\"https://schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Mulberry Silk Eveningwear products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}</script></div>', 'done', NULL, NULL, '2026-08-25 21:58:37', '2026-08-25 21:58:37'),
(75, 1, 'listing_writer', '{\"product_id\":1,\"raw_title\":\"The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition\",\"supplier_data\":[]}', '{\"raw_ai_generation\":{\"title\":\"The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition\",\"bullet_points\":[\"\\u26a1 Superior Ergonomics & Build: Crafted with aircraft-grade durability and sleek modern aesthetics.\",\"\\ud83d\\udee1\\ufe0f Certified Quality: 100% inspected and verified for peak performance and longevity.\",\"\\ud83d\\ude9a Express Free Shipping: Dispatched from certified fulfillment hubs with live AWB tracking.\",\"\\ud83d\\udc8e 7-Day Replacement Guarantee: Zero-risk shopping backed by 24\\/7 dedicated support.\"],\"long_description\":\"<div class=\'product-story\'><h3>Engineered for Excellence<\\/h3><p>Experience unmatched reliability and performance with the <strong>The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition<\\/strong>. Designed specifically for contemporary living, it seamlessly integrates advanced functionality with minimalist design aesthetics.<\\/p><h4>Key Highlights:<\\/h4><ul><li>High-efficiency performance tailored for demanding everyday tasks.<\\/li><li>Premium scratch-resistant and tactile finish.<\\/li><li>Backed by full NovaDrop manufacturer warranty.<\\/li><\\/ul><\\/div>\",\"seo_title\":\"The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition | Buy Online Best Price | NovaDrop\",\"seo_description\":\"Shop The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition online at NovaDrop India. Free express delivery, cash on delivery, and exclusive discount codes available today!\",\"image_alt_text\":\"The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition product hero image showcase - NovaDrop Commerce\"},\"moderation_passed\":true,\"flags_triggered\":[],\"approved_copy\":{\"title\":\"The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition\",\"seo_title\":\"The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edi\",\"seo_description\":\"Shop The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edit\",\"bullet_features_html\":\"<ul class=\'nova-bullet-features\'><li>\\u26a1 Superior Ergonomics &amp; Build: Crafted with aircraft-grade durability and sleek modern aesthetics.<\\/li><li>\\ud83d\\udee1\\ufe0f Certified Quality: 100% inspected and verified for peak performance and longevity.<\\/li><li>\\ud83d\\ude9a Express Free Shipping: Dispatched from certified fulfillment hubs with live AWB tracking.<\\/li><li>\\ud83d\\udc8e 7-Day Replacement Guarantee: Zero-risk shopping backed by 24\\/7 dedicated support.<\\/li><\\/ul>\",\"full_html_description\":\"<ul class=\'nova-bullet-features\'><li>\\u26a1 Superior Ergonomics &amp; Build: Crafted with aircraft-grade durability and sleek modern aesthetics.<\\/li><li>\\ud83d\\udee1\\ufe0f Certified Quality: 100% inspected and verified for peak performance and longevity.<\\/li><li>\\ud83d\\ude9a Express Free Shipping: Dispatched from certified fulfillment hubs with live AWB tracking.<\\/li><li>\\ud83d\\udc8e 7-Day Replacement Guarantee: Zero-risk shopping backed by 24\\/7 dedicated support.<\\/li><\\/ul><div class=\'nova-product-description\'><div class=\'product-story\'><h3>Engineered for Excellence<\\/h3><p>Experience unmatched reliability and performance with the <strong>The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition<\\/strong>. Designed specifically for contemporary living, it seamlessly integrates advanced functionality with minimalist design aesthetics.<\\/p><h4>Key Highlights:<\\/h4><ul><li>High-efficiency performance tailored for demanding everyday tasks.<\\/li><li>Premium scratch-resistant and tactile finish.<\\/li><li>Backed by full NovaDrop manufacturer warranty.<\\/li><\\/ul><\\/div><\\/div>\",\"image_alt_text\":\"The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014\"}}', 'done', NULL, NULL, '2026-08-25 21:58:37', '2026-08-25 21:58:37'),
(76, 1, 'listing_writer', '{\"product_id\":1,\"raw_title\":\"The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition\",\"supplier_data\":[]}', '{\"raw_ai_generation\":{\"title\":\"The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition\",\"bullet_points\":[\"\\u26a1 Superior Ergonomics & Build: Crafted with aircraft-grade durability and sleek modern aesthetics.\",\"\\ud83d\\udee1\\ufe0f Certified Quality: 100% inspected and verified for peak performance and longevity.\",\"\\ud83d\\ude9a Express Free Shipping: Dispatched from certified fulfillment hubs with live AWB tracking.\",\"\\ud83d\\udc8e 7-Day Replacement Guarantee: Zero-risk shopping backed by 24\\/7 dedicated support.\"],\"long_description\":\"<div class=\'product-story\'><h3>Engineered for Excellence<\\/h3><p>Experience unmatched reliability and performance with the <strong>The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition<\\/strong>. Designed specifically for contemporary living, it seamlessly integrates advanced functionality with minimalist design aesthetics.<\\/p><h4>Key Highlights:<\\/h4><ul><li>High-efficiency performance tailored for demanding everyday tasks.<\\/li><li>Premium scratch-resistant and tactile finish.<\\/li><li>Backed by full NovaDrop manufacturer warranty.<\\/li><\\/ul><\\/div>\",\"seo_title\":\"The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition | Buy Online Best Price | NovaDrop\",\"seo_description\":\"Shop The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition online at NovaDrop India. Free express delivery, cash on delivery, and exclusive discount codes available today!\",\"image_alt_text\":\"The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition product hero image showcase - NovaDrop Commerce\"},\"moderation_passed\":true,\"flags_triggered\":[],\"approved_copy\":{\"title\":\"The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition\",\"seo_title\":\"The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edi\",\"seo_description\":\"Shop The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edit\",\"bullet_features_html\":\"<ul class=\'nova-bullet-features\'><li>\\u26a1 Superior Ergonomics &amp; Build: Crafted with aircraft-grade durability and sleek modern aesthetics.<\\/li><li>\\ud83d\\udee1\\ufe0f Certified Quality: 100% inspected and verified for peak performance and longevity.<\\/li><li>\\ud83d\\ude9a Express Free Shipping: Dispatched from certified fulfillment hubs with live AWB tracking.<\\/li><li>\\ud83d\\udc8e 7-Day Replacement Guarantee: Zero-risk shopping backed by 24\\/7 dedicated support.<\\/li><\\/ul>\",\"full_html_description\":\"<ul class=\'nova-bullet-features\'><li>\\u26a1 Superior Ergonomics &amp; Build: Crafted with aircraft-grade durability and sleek modern aesthetics.<\\/li><li>\\ud83d\\udee1\\ufe0f Certified Quality: 100% inspected and verified for peak performance and longevity.<\\/li><li>\\ud83d\\ude9a Express Free Shipping: Dispatched from certified fulfillment hubs with live AWB tracking.<\\/li><li>\\ud83d\\udc8e 7-Day Replacement Guarantee: Zero-risk shopping backed by 24\\/7 dedicated support.<\\/li><\\/ul><div class=\'nova-product-description\'><div class=\'product-story\'><h3>Engineered for Excellence<\\/h3><p>Experience unmatched reliability and performance with the <strong>The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition<\\/strong>. Designed specifically for contemporary living, it seamlessly integrates advanced functionality with minimalist design aesthetics.<\\/p><h4>Key Highlights:<\\/h4><ul><li>High-efficiency performance tailored for demanding everyday tasks.<\\/li><li>Premium scratch-resistant and tactile finish.<\\/li><li>Backed by full NovaDrop manufacturer warranty.<\\/li><\\/ul><\\/div><\\/div>\",\"image_alt_text\":\"The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014\"}}', 'done', NULL, NULL, '2026-08-25 21:58:38', '2026-08-25 21:58:38'),
(77, 1, 'finance_reconciliation', '{\"audited_count\":4,\"total_revenue\":25445.82,\"mismatches_count\":1,\"mismatches\":[{\"order_id\":1,\"order_number\":\"#ND-1001\",\"type\":\"UNDERPAYMENT_OR_UNMATCHED_GATEWAY_RECORD\",\"order_total\":2948.82,\"captured\":0,\"variance\":2948.82}],\"reconciliation_code\":\"MISMATCH_DETECTED\"}', '💰 Finance Reconciliation Statement [25 Aug 2026]:\n• Orders Audited: 4 (Total Value: ₹25,445.82)\n• Mismatches / Leaks: 1\n• Total Variance Delta: ₹2,948.82\n• Reconciliation Status: MISMATCH_DETECTED', 'done', NULL, NULL, '2026-08-25 21:58:38', '2026-08-25 21:58:38'),
(78, 1, 'vendor_whatsapp_dispatch', '{\"vendor_id\":2,\"phone\":\"+919870330064\",\"order_id\":7}', 'Hello Kenji Takahashi! 🚀 New Order *#03003* has been assigned to *Okayama Selvedge Guild*.\n\nItems to Dispatch:\n• The Atelier Cashmere Cocoon Coat (x1)\n\nTotal: ₹7,499.00 (Net: ₹6,599.12)\nPlease log in to your Seller Portal to generate shipping label & dispatch:\n👉 http://localhost/Dropshipping/vendor/orders', 'done', NULL, NULL, '2026-08-25 21:58:38', '2026-08-25 21:58:38'),
(79, 1, 'daily_digest', '{\"gross_revenue\":0,\"orders_count\":0,\"aov\":0,\"low_stock_count\":0,\"failed_payments\":0,\"top_skus\":[]}', '📊 NovaDrop Daily Executive Digest [25 Aug 2026]:\n• Gross GMV: ₹0.00 across 0 orders (AOV: ₹0.00)\n• Estimated Net Profit: ₹0.00 (Margin ~62.6%)\n• Top Products: No items sold yet today.\n• Critical Low-Stock SKUs: 0 items\n• Failed Payment Alerts: 0', 'done', NULL, NULL, '2026-08-25 21:58:38', '2026-08-25 21:58:38'),
(80, 1, 'finance_reconciliation', '{\"audited_count\":4,\"total_revenue\":25445.82,\"mismatches_count\":1,\"mismatches\":[{\"order_id\":1,\"order_number\":\"#ND-1001\",\"type\":\"UNDERPAYMENT_OR_UNMATCHED_GATEWAY_RECORD\",\"order_total\":2948.82,\"captured\":0,\"variance\":2948.82}],\"reconciliation_code\":\"MISMATCH_DETECTED\"}', '💰 Finance Reconciliation Statement [25 Aug 2026]:\n• Orders Audited: 4 (Total Value: ₹25,445.82)\n• Mismatches / Leaks: 1\n• Total Variance Delta: ₹2,948.82\n• Reconciliation Status: MISMATCH_DETECTED', 'done', NULL, NULL, '2026-08-25 21:58:38', '2026-08-25 21:58:38'),
(81, 1, 'vendor_whatsapp_dispatch', '{\"vendor_id\":2,\"phone\":\"+919870330064\",\"order_id\":7}', 'Hello Kenji Takahashi! 🚀 New Order *#03003* has been assigned to *Okayama Selvedge Guild*.\n\nItems to Dispatch:\n• The Atelier Cashmere Cocoon Coat (x1)\n\nTotal: ₹7,499.00 (Net: ₹6,599.12)\nPlease log in to your Seller Portal to generate shipping label & dispatch:\n👉 http://localhost/Dropshipping/vendor/orders', 'done', NULL, NULL, '2026-08-25 21:58:38', '2026-08-25 21:58:38'),
(82, 1, 'seo_content_generator', '{\"collection\":\"Outerwear & Cashmere\",\"slug\":\"buyers-guide-outerwear-2026\",\"title\":\"The Ultimate 2026 Buyer\'s Guide to Outerwear & Cashmere: Ergonomics, Durability & Performance\",\"schema\":{\"@context\":\"https:\\/\\/schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Outerwear & Cashmere products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}}', '<div class=\'seo-buyers-guide\'><h2>Why Quality Matters in Outerwear & Cashmere</h2><p>Choosing the right gear isn\'t just about aesthetics — it directly impacts your daily stamina, comfort, and productivity. In this guide, our engineering and ergonomics team breaks down the key factors to evaluate before investing.</p><h3>Top Recommended Options:</h3><div class=\'product-comparison-grid\'><div class=\'comparison-item\'><h4>The Atelier Cashmere Cocoon Coat — Next-Gen Edition — Next-Gen Edition — Next-Gen Edition — Next-Gen Edition — Next-Gen Edition — Next-Gen Edition — Next-Gen Edition — Next-Gen Edition — Next-Gen Edition — Next-Gen Edition — Next-Gen Edition (₹4,399.00)</h4><p>⚡ Superior Ergonomics &amp;amp; Build: Crafted with aircraft-grade durability and sleek modern aesthetics.🛡️ Certified Quality: 100% insp...</p></div><div class=\'comparison-item\'><h4>Double-Breasted Melton Wool Peacoat (₹5,699.00)</h4><p>Architectural virgin wool peacoat with anchor-embossed horn buttons and deep fleece-lined hand warmer pockets....</p></div></div><h3>Frequently Asked Questions</h3><div class=\'faq-accordion\'><div class=\'faq-q\'><strong>Q: What warranty is included?</strong><p>A: Full 1-year replacement warranty and 7-day returns.</p></div></div><script type=\'application/ld+json\'>{\"@context\":\"https://schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Outerwear & Cashmere products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}</script></div>', 'done', NULL, NULL, '2026-08-25 21:58:38', '2026-08-25 21:58:38'),
(83, 1, 'seo_content_generator', '{\"collection\":\"Okayama Selvedge Denim\",\"slug\":\"buyers-guide-denim-2026\",\"title\":\"The Ultimate 2026 Buyer\'s Guide to Okayama Selvedge Denim: Ergonomics, Durability & Performance\",\"schema\":{\"@context\":\"https:\\/\\/schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Okayama Selvedge Denim products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}}', '<div class=\'seo-buyers-guide\'><h2>Why Quality Matters in Okayama Selvedge Denim</h2><p>Choosing the right gear isn\'t just about aesthetics — it directly impacts your daily stamina, comfort, and productivity. In this guide, our engineering and ergonomics team breaks down the key factors to evaluate before investing.</p><h3>Top Recommended Options:</h3><div class=\'product-comparison-grid\'><div class=\'comparison-item\'><h4>Vintage Okayama 14.5oz Selvedge Trousers (₹4,299.00)</h4><p>Custom shuttle-loomed denim with vintage copper hardware and chain-stitched hems that develop personalized honeycombs and whiskers over time...</p></div><div class=\'comparison-item\'><h4>Type II Shuttle-Loom Denim Jacket (₹5,299.00)</h4><p>Iconic Type II jacket silhouette crafted on vintage Toyoda shuttle looms with red-line selvedge along the interior placket....</p></div></div><h3>Frequently Asked Questions</h3><div class=\'faq-accordion\'><div class=\'faq-q\'><strong>Q: What warranty is included?</strong><p>A: Full 1-year replacement warranty and 7-day returns.</p></div></div><script type=\'application/ld+json\'>{\"@context\":\"https://schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Okayama Selvedge Denim products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}</script></div>', 'done', NULL, NULL, '2026-08-25 21:58:38', '2026-08-25 21:58:38'),
(84, 1, 'seo_content_generator', '{\"collection\":\"Mulberry Silk Eveningwear\",\"slug\":\"buyers-guide-silk-2026\",\"title\":\"The Ultimate 2026 Buyer\'s Guide to Mulberry Silk Eveningwear: Ergonomics, Durability & Performance\",\"schema\":{\"@context\":\"https:\\/\\/schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Mulberry Silk Eveningwear products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}}', '<div class=\'seo-buyers-guide\'><h2>Why Quality Matters in Mulberry Silk Eveningwear</h2><p>Choosing the right gear isn\'t just about aesthetics — it directly impacts your daily stamina, comfort, and productivity. In this guide, our engineering and ergonomics team breaks down the key factors to evaluate before investing.</p><h3>Top Recommended Options:</h3><div class=\'product-comparison-grid\'><div class=\'comparison-item\'><h4>22-Momme Mulberry Silk Bias Slip Dress (₹4,999.00)</h4><p>Sandwashed pure Mulberry silk that drapes organically along bodily contours with liquid sheen and adjustable silk-cord straps....</p></div><div class=\'comparison-item\'><h4>Sandwashed Silk Charmeuse Blouse (₹3,799.00)</h4><p>Ultra-soft sandwashed silk charmeuse blouse with French cuffs and concealed placket for effortless sartorial styling....</p></div></div><h3>Frequently Asked Questions</h3><div class=\'faq-accordion\'><div class=\'faq-q\'><strong>Q: What warranty is included?</strong><p>A: Full 1-year replacement warranty and 7-day returns.</p></div></div><script type=\'application/ld+json\'>{\"@context\":\"https://schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Mulberry Silk Eveningwear products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}</script></div>', 'done', NULL, NULL, '2026-08-25 21:58:38', '2026-08-25 21:58:38');
INSERT INTO `ai_agent_tasks` (`id`, `store_id`, `agent`, `input_json`, `output_text`, `status`, `approved_by`, `approved_at`, `created_at`, `updated_at`) VALUES
(85, 1, 'listing_writer', '{\"product_id\":1,\"raw_title\":\"The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition\",\"supplier_data\":[]}', '{\"raw_ai_generation\":{\"title\":\"The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition\",\"bullet_points\":[\"\\u26a1 Superior Ergonomics & Build: Crafted with aircraft-grade durability and sleek modern aesthetics.\",\"\\ud83d\\udee1\\ufe0f Certified Quality: 100% inspected and verified for peak performance and longevity.\",\"\\ud83d\\ude9a Express Free Shipping: Dispatched from certified fulfillment hubs with live AWB tracking.\",\"\\ud83d\\udc8e 7-Day Replacement Guarantee: Zero-risk shopping backed by 24\\/7 dedicated support.\"],\"long_description\":\"<div class=\'product-story\'><h3>Engineered for Excellence<\\/h3><p>Experience unmatched reliability and performance with the <strong>The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition<\\/strong>. Designed specifically for contemporary living, it seamlessly integrates advanced functionality with minimalist design aesthetics.<\\/p><h4>Key Highlights:<\\/h4><ul><li>High-efficiency performance tailored for demanding everyday tasks.<\\/li><li>Premium scratch-resistant and tactile finish.<\\/li><li>Backed by full NovaDrop manufacturer warranty.<\\/li><\\/ul><\\/div>\",\"seo_title\":\"The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition | Buy Online Best Price | NovaDrop\",\"seo_description\":\"Shop The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition online at NovaDrop India. Free express delivery, cash on delivery, and exclusive discount codes available today!\",\"image_alt_text\":\"The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition product hero image showcase - NovaDrop Commerce\"},\"moderation_passed\":true,\"flags_triggered\":[],\"approved_copy\":{\"title\":\"The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition\",\"seo_title\":\"The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edi\",\"seo_description\":\"Shop The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edit\",\"bullet_features_html\":\"<ul class=\'nova-bullet-features\'><li>\\u26a1 Superior Ergonomics &amp; Build: Crafted with aircraft-grade durability and sleek modern aesthetics.<\\/li><li>\\ud83d\\udee1\\ufe0f Certified Quality: 100% inspected and verified for peak performance and longevity.<\\/li><li>\\ud83d\\ude9a Express Free Shipping: Dispatched from certified fulfillment hubs with live AWB tracking.<\\/li><li>\\ud83d\\udc8e 7-Day Replacement Guarantee: Zero-risk shopping backed by 24\\/7 dedicated support.<\\/li><\\/ul>\",\"full_html_description\":\"<ul class=\'nova-bullet-features\'><li>\\u26a1 Superior Ergonomics &amp; Build: Crafted with aircraft-grade durability and sleek modern aesthetics.<\\/li><li>\\ud83d\\udee1\\ufe0f Certified Quality: 100% inspected and verified for peak performance and longevity.<\\/li><li>\\ud83d\\ude9a Express Free Shipping: Dispatched from certified fulfillment hubs with live AWB tracking.<\\/li><li>\\ud83d\\udc8e 7-Day Replacement Guarantee: Zero-risk shopping backed by 24\\/7 dedicated support.<\\/li><\\/ul><div class=\'nova-product-description\'><div class=\'product-story\'><h3>Engineered for Excellence<\\/h3><p>Experience unmatched reliability and performance with the <strong>The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition<\\/strong>. Designed specifically for contemporary living, it seamlessly integrates advanced functionality with minimalist design aesthetics.<\\/p><h4>Key Highlights:<\\/h4><ul><li>High-efficiency performance tailored for demanding everyday tasks.<\\/li><li>Premium scratch-resistant and tactile finish.<\\/li><li>Backed by full NovaDrop manufacturer warranty.<\\/li><\\/ul><\\/div><\\/div>\",\"image_alt_text\":\"The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014\"}}', 'done', NULL, NULL, '2026-08-25 21:58:38', '2026-08-25 21:58:38'),
(86, 1, 'daily_digest', '{\"gross_revenue\":0,\"orders_count\":0,\"aov\":0,\"low_stock_count\":0,\"failed_payments\":0,\"top_skus\":[]}', '📊 NovaDrop Daily Executive Digest [25 Aug 2026]:\n• Gross GMV: ₹0.00 across 0 orders (AOV: ₹0.00)\n• Estimated Net Profit: ₹0.00 (Margin ~62.6%)\n• Top Products: No items sold yet today.\n• Critical Low-Stock SKUs: 0 items\n• Failed Payment Alerts: 0', 'done', NULL, NULL, '2026-08-25 22:09:06', '2026-08-25 22:09:06'),
(87, 1, 'finance_reconciliation', '{\"audited_count\":4,\"total_revenue\":25445.82,\"mismatches_count\":1,\"mismatches\":[{\"order_id\":1,\"order_number\":\"#ND-1001\",\"type\":\"UNDERPAYMENT_OR_UNMATCHED_GATEWAY_RECORD\",\"order_total\":2948.82,\"captured\":0,\"variance\":2948.82}],\"reconciliation_code\":\"MISMATCH_DETECTED\"}', '💰 Finance Reconciliation Statement [25 Aug 2026]:\n• Orders Audited: 4 (Total Value: ₹25,445.82)\n• Mismatches / Leaks: 1\n• Total Variance Delta: ₹2,948.82\n• Reconciliation Status: MISMATCH_DETECTED', 'done', NULL, NULL, '2026-08-25 22:09:06', '2026-08-25 22:09:06'),
(88, 1, 'vendor_whatsapp_dispatch', '{\"vendor_id\":2,\"phone\":\"+919870330064\",\"order_id\":7}', 'Hello Kenji Takahashi! 🚀 New Order *#03003* has been assigned to *Okayama Selvedge Guild*.\n\nItems to Dispatch:\n• The Atelier Cashmere Cocoon Coat (x1)\n\nTotal: ₹7,499.00 (Net: ₹6,599.12)\nPlease log in to your Seller Portal to generate shipping label & dispatch:\n👉 http://localhost/Dropshipping/vendor/orders', 'done', NULL, NULL, '2026-08-25 22:09:06', '2026-08-25 22:09:06'),
(89, 1, 'seo_content_generator', '{\"collection\":\"Outerwear & Cashmere\",\"slug\":\"buyers-guide-outerwear-2026\",\"title\":\"The Ultimate 2026 Buyer\'s Guide to Outerwear & Cashmere: Ergonomics, Durability & Performance\",\"schema\":{\"@context\":\"https:\\/\\/schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Outerwear & Cashmere products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}}', '<div class=\'seo-buyers-guide\'><h2>Why Quality Matters in Outerwear & Cashmere</h2><p>Choosing the right gear isn\'t just about aesthetics — it directly impacts your daily stamina, comfort, and productivity. In this guide, our engineering and ergonomics team breaks down the key factors to evaluate before investing.</p><h3>Top Recommended Options:</h3><div class=\'product-comparison-grid\'><div class=\'comparison-item\'><h4>The Atelier Cashmere Cocoon Coat — Next-Gen Edition — Next-Gen Edition — Next-Gen Edition — Next-Gen Edition — Next-Gen Edition — Next-Gen Edition — Next-Gen Edition — Next-Gen Edition — Next-Gen Edition — Next-Gen Edition — Next-Gen Edition — Next-Gen Edition (₹4,399.00)</h4><p>⚡ Superior Ergonomics &amp;amp; Build: Crafted with aircraft-grade durability and sleek modern aesthetics.🛡️ Certified Quality: 100% insp...</p></div><div class=\'comparison-item\'><h4>Double-Breasted Melton Wool Peacoat (₹5,699.00)</h4><p>Architectural virgin wool peacoat with anchor-embossed horn buttons and deep fleece-lined hand warmer pockets....</p></div></div><h3>Frequently Asked Questions</h3><div class=\'faq-accordion\'><div class=\'faq-q\'><strong>Q: What warranty is included?</strong><p>A: Full 1-year replacement warranty and 7-day returns.</p></div></div><script type=\'application/ld+json\'>{\"@context\":\"https://schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Outerwear & Cashmere products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}</script></div>', 'done', NULL, NULL, '2026-08-25 22:09:06', '2026-08-25 22:09:06'),
(90, 1, 'seo_content_generator', '{\"collection\":\"Okayama Selvedge Denim\",\"slug\":\"buyers-guide-denim-2026\",\"title\":\"The Ultimate 2026 Buyer\'s Guide to Okayama Selvedge Denim: Ergonomics, Durability & Performance\",\"schema\":{\"@context\":\"https:\\/\\/schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Okayama Selvedge Denim products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}}', '<div class=\'seo-buyers-guide\'><h2>Why Quality Matters in Okayama Selvedge Denim</h2><p>Choosing the right gear isn\'t just about aesthetics — it directly impacts your daily stamina, comfort, and productivity. In this guide, our engineering and ergonomics team breaks down the key factors to evaluate before investing.</p><h3>Top Recommended Options:</h3><div class=\'product-comparison-grid\'><div class=\'comparison-item\'><h4>Vintage Okayama 14.5oz Selvedge Trousers (₹4,299.00)</h4><p>Custom shuttle-loomed denim with vintage copper hardware and chain-stitched hems that develop personalized honeycombs and whiskers over time...</p></div><div class=\'comparison-item\'><h4>Type II Shuttle-Loom Denim Jacket (₹5,299.00)</h4><p>Iconic Type II jacket silhouette crafted on vintage Toyoda shuttle looms with red-line selvedge along the interior placket....</p></div></div><h3>Frequently Asked Questions</h3><div class=\'faq-accordion\'><div class=\'faq-q\'><strong>Q: What warranty is included?</strong><p>A: Full 1-year replacement warranty and 7-day returns.</p></div></div><script type=\'application/ld+json\'>{\"@context\":\"https://schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Okayama Selvedge Denim products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}</script></div>', 'done', NULL, NULL, '2026-08-25 22:09:06', '2026-08-25 22:09:06'),
(91, 1, 'seo_content_generator', '{\"collection\":\"Mulberry Silk Eveningwear\",\"slug\":\"buyers-guide-silk-2026\",\"title\":\"The Ultimate 2026 Buyer\'s Guide to Mulberry Silk Eveningwear: Ergonomics, Durability & Performance\",\"schema\":{\"@context\":\"https:\\/\\/schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Mulberry Silk Eveningwear products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}}', '<div class=\'seo-buyers-guide\'><h2>Why Quality Matters in Mulberry Silk Eveningwear</h2><p>Choosing the right gear isn\'t just about aesthetics — it directly impacts your daily stamina, comfort, and productivity. In this guide, our engineering and ergonomics team breaks down the key factors to evaluate before investing.</p><h3>Top Recommended Options:</h3><div class=\'product-comparison-grid\'><div class=\'comparison-item\'><h4>22-Momme Mulberry Silk Bias Slip Dress (₹4,999.00)</h4><p>Sandwashed pure Mulberry silk that drapes organically along bodily contours with liquid sheen and adjustable silk-cord straps....</p></div><div class=\'comparison-item\'><h4>Sandwashed Silk Charmeuse Blouse (₹3,799.00)</h4><p>Ultra-soft sandwashed silk charmeuse blouse with French cuffs and concealed placket for effortless sartorial styling....</p></div></div><h3>Frequently Asked Questions</h3><div class=\'faq-accordion\'><div class=\'faq-q\'><strong>Q: What warranty is included?</strong><p>A: Full 1-year replacement warranty and 7-day returns.</p></div></div><script type=\'application/ld+json\'>{\"@context\":\"https://schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Mulberry Silk Eveningwear products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}</script></div>', 'done', NULL, NULL, '2026-08-25 22:09:07', '2026-08-25 22:09:07'),
(92, 1, 'listing_writer', '{\"product_id\":1,\"raw_title\":\"The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition\",\"supplier_data\":[]}', '{\"raw_ai_generation\":{\"title\":\"The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition\",\"bullet_points\":[\"\\u26a1 Superior Ergonomics & Build: Crafted with aircraft-grade durability and sleek modern aesthetics.\",\"\\ud83d\\udee1\\ufe0f Certified Quality: 100% inspected and verified for peak performance and longevity.\",\"\\ud83d\\ude9a Express Free Shipping: Dispatched from certified fulfillment hubs with live AWB tracking.\",\"\\ud83d\\udc8e 7-Day Replacement Guarantee: Zero-risk shopping backed by 24\\/7 dedicated support.\"],\"long_description\":\"<div class=\'product-story\'><h3>Engineered for Excellence<\\/h3><p>Experience unmatched reliability and performance with the <strong>The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition<\\/strong>. Designed specifically for contemporary living, it seamlessly integrates advanced functionality with minimalist design aesthetics.<\\/p><h4>Key Highlights:<\\/h4><ul><li>High-efficiency performance tailored for demanding everyday tasks.<\\/li><li>Premium scratch-resistant and tactile finish.<\\/li><li>Backed by full NovaDrop manufacturer warranty.<\\/li><\\/ul><\\/div>\",\"seo_title\":\"The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition | Buy Online Best Price | NovaDrop\",\"seo_description\":\"Shop The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition online at NovaDrop India. Free express delivery, cash on delivery, and exclusive discount codes available today!\",\"image_alt_text\":\"The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition product hero image showcase - NovaDrop Commerce\"},\"moderation_passed\":true,\"flags_triggered\":[],\"approved_copy\":{\"title\":\"The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition\",\"seo_title\":\"The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edi\",\"seo_description\":\"Shop The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edit\",\"bullet_features_html\":\"<ul class=\'nova-bullet-features\'><li>\\u26a1 Superior Ergonomics &amp; Build: Crafted with aircraft-grade durability and sleek modern aesthetics.<\\/li><li>\\ud83d\\udee1\\ufe0f Certified Quality: 100% inspected and verified for peak performance and longevity.<\\/li><li>\\ud83d\\ude9a Express Free Shipping: Dispatched from certified fulfillment hubs with live AWB tracking.<\\/li><li>\\ud83d\\udc8e 7-Day Replacement Guarantee: Zero-risk shopping backed by 24\\/7 dedicated support.<\\/li><\\/ul>\",\"full_html_description\":\"<ul class=\'nova-bullet-features\'><li>\\u26a1 Superior Ergonomics &amp; Build: Crafted with aircraft-grade durability and sleek modern aesthetics.<\\/li><li>\\ud83d\\udee1\\ufe0f Certified Quality: 100% inspected and verified for peak performance and longevity.<\\/li><li>\\ud83d\\ude9a Express Free Shipping: Dispatched from certified fulfillment hubs with live AWB tracking.<\\/li><li>\\ud83d\\udc8e 7-Day Replacement Guarantee: Zero-risk shopping backed by 24\\/7 dedicated support.<\\/li><\\/ul><div class=\'nova-product-description\'><div class=\'product-story\'><h3>Engineered for Excellence<\\/h3><p>Experience unmatched reliability and performance with the <strong>The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition<\\/strong>. Designed specifically for contemporary living, it seamlessly integrates advanced functionality with minimalist design aesthetics.<\\/p><h4>Key Highlights:<\\/h4><ul><li>High-efficiency performance tailored for demanding everyday tasks.<\\/li><li>Premium scratch-resistant and tactile finish.<\\/li><li>Backed by full NovaDrop manufacturer warranty.<\\/li><\\/ul><\\/div><\\/div>\",\"image_alt_text\":\"The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014 Next-Gen Edition \\u2014\"}}', 'done', NULL, NULL, '2026-08-25 22:09:07', '2026-08-25 22:09:07'),
(93, 1, 'daily_digest', '{\"gross_revenue\":0,\"orders_count\":0,\"aov\":0,\"low_stock_count\":0,\"failed_payments\":0,\"top_skus\":[]}', '📊 NovaDrop Daily Executive Digest [26 Aug 2026]:\n• Gross GMV: ₹0.00 across 0 orders (AOV: ₹0.00)\n• Estimated Net Profit: ₹0.00 (Margin ~62.6%)\n• Top Products: No items sold yet today.\n• Critical Low-Stock SKUs: 0 items\n• Failed Payment Alerts: 0', 'done', NULL, NULL, '2026-08-26 21:31:04', '2026-08-26 21:31:04'),
(94, 1, 'finance_reconciliation', '{\"audited_count\":3,\"total_revenue\":22497,\"mismatches_count\":0,\"mismatches\":[],\"reconciliation_code\":\"CLEARED\"}', '💰 Finance Reconciliation Statement [26 Aug 2026]:\n• Orders Audited: 3 (Total Value: ₹22,497.00)\n• Mismatches / Leaks: 0\n• Total Variance Delta: ₹0.00\n• Reconciliation Status: CLEARED', 'done', NULL, NULL, '2026-08-26 21:31:04', '2026-08-26 21:31:04'),
(95, 1, 'vendor_whatsapp_dispatch', '{\"vendor_id\":2,\"phone\":\"+919870330064\",\"order_id\":7}', 'Hello Kenji Takahashi! 🚀 New Order *#03003* has been assigned to *Okayama Selvedge Guild*.\n\nItems to Dispatch:\n• The Atelier Cashmere Cocoon Coat (x1)\n\nTotal: ₹7,499.00 (Net: ₹6,599.12)\nPlease log in to your Seller Portal to generate shipping label & dispatch:\n👉 http://localhost/Dropshipping/vendor/orders', 'done', NULL, NULL, '2026-08-26 21:31:04', '2026-08-26 21:31:04'),
(96, 1, 'seo_content_generator', '{\"collection\":\"Outerwear & Cashmere\",\"slug\":\"buyers-guide-outerwear-2026\",\"title\":\"The Ultimate 2026 Buyer\'s Guide to Outerwear & Cashmere: Ergonomics, Durability & Performance\",\"schema\":{\"@context\":\"https:\\/\\/schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Outerwear & Cashmere products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}}', '<div class=\'seo-buyers-guide\'><h2>Why Quality Matters in Outerwear & Cashmere</h2><p>Choosing the right gear isn\'t just about aesthetics — it directly impacts your daily stamina, comfort, and productivity. In this guide, our engineering and ergonomics team breaks down the key factors to evaluate before investing.</p><h3>Top Recommended Options:</h3><div class=\'product-comparison-grid\'><div class=\'comparison-item\'><h4>The Atelier Cashmere Cocoon Coat (₹4,399.00)</h4><p>Hand-cut from 700 GSM Grade-A Mongolian cashmere with double-faced seams and water buffalo horn buttons. Museum-grade thermal efficiency wit...</p></div><div class=\'comparison-item\'><h4>Double-Breasted Melton Wool Peacoat (₹5,699.00)</h4><p>Architectural virgin wool peacoat with anchor-embossed horn buttons and deep fleece-lined hand warmer pockets....</p></div></div><h3>Frequently Asked Questions</h3><div class=\'faq-accordion\'><div class=\'faq-q\'><strong>Q: What warranty is included?</strong><p>A: Full 1-year replacement warranty and 7-day returns.</p></div></div><script type=\'application/ld+json\'>{\"@context\":\"https://schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Outerwear & Cashmere products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}</script></div>', 'done', NULL, NULL, '2026-08-26 21:31:04', '2026-08-26 21:31:04'),
(97, 1, 'seo_content_generator', '{\"collection\":\"Okayama Selvedge Denim\",\"slug\":\"buyers-guide-denim-2026\",\"title\":\"The Ultimate 2026 Buyer\'s Guide to Okayama Selvedge Denim: Ergonomics, Durability & Performance\",\"schema\":{\"@context\":\"https:\\/\\/schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Okayama Selvedge Denim products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}}', '<div class=\'seo-buyers-guide\'><h2>Why Quality Matters in Okayama Selvedge Denim</h2><p>Choosing the right gear isn\'t just about aesthetics — it directly impacts your daily stamina, comfort, and productivity. In this guide, our engineering and ergonomics team breaks down the key factors to evaluate before investing.</p><h3>Top Recommended Options:</h3><div class=\'product-comparison-grid\'><div class=\'comparison-item\'><h4>Vintage Okayama 14.5oz Selvedge Trousers (₹4,299.00)</h4><p>Custom shuttle-loomed denim with vintage copper hardware and chain-stitched hems that develop personalized honeycombs and whiskers over time...</p></div><div class=\'comparison-item\'><h4>Type II Shuttle-Loom Denim Jacket (₹5,299.00)</h4><p>Iconic Type II jacket silhouette crafted on vintage Toyoda shuttle looms with red-line selvedge along the interior placket....</p></div></div><h3>Frequently Asked Questions</h3><div class=\'faq-accordion\'><div class=\'faq-q\'><strong>Q: What warranty is included?</strong><p>A: Full 1-year replacement warranty and 7-day returns.</p></div></div><script type=\'application/ld+json\'>{\"@context\":\"https://schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Okayama Selvedge Denim products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}</script></div>', 'done', NULL, NULL, '2026-08-26 21:31:04', '2026-08-26 21:31:04'),
(98, 1, 'seo_content_generator', '{\"collection\":\"Mulberry Silk Eveningwear\",\"slug\":\"buyers-guide-silk-2026\",\"title\":\"The Ultimate 2026 Buyer\'s Guide to Mulberry Silk Eveningwear: Ergonomics, Durability & Performance\",\"schema\":{\"@context\":\"https:\\/\\/schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Mulberry Silk Eveningwear products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}}', '<div class=\'seo-buyers-guide\'><h2>Why Quality Matters in Mulberry Silk Eveningwear</h2><p>Choosing the right gear isn\'t just about aesthetics — it directly impacts your daily stamina, comfort, and productivity. In this guide, our engineering and ergonomics team breaks down the key factors to evaluate before investing.</p><h3>Top Recommended Options:</h3><div class=\'product-comparison-grid\'><div class=\'comparison-item\'><h4>22-Momme Mulberry Silk Bias Slip Dress (₹4,999.00)</h4><p>Sandwashed pure Mulberry silk that drapes organically along bodily contours with liquid sheen and adjustable silk-cord straps....</p></div><div class=\'comparison-item\'><h4>Sandwashed Silk Charmeuse Blouse (₹3,799.00)</h4><p>Ultra-soft sandwashed silk charmeuse blouse with French cuffs and concealed placket for effortless sartorial styling....</p></div></div><h3>Frequently Asked Questions</h3><div class=\'faq-accordion\'><div class=\'faq-q\'><strong>Q: What warranty is included?</strong><p>A: Full 1-year replacement warranty and 7-day returns.</p></div></div><script type=\'application/ld+json\'>{\"@context\":\"https://schema.org\",\"@type\":\"FAQPage\",\"mainEntity\":[{\"@type\":\"Question\",\"name\":\"What warranty is included with NovaDrop Mulberry Silk Eveningwear products?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Every NovaDrop product includes our standard 1-year replacement warranty and 7-day hassle-free return guarantee.\"}},{\"@type\":\"Question\",\"name\":\"How fast is shipping across India?\",\"acceptedAnswer\":{\"@type\":\"Answer\",\"text\":\"Orders are dispatched via BlueDart and Delhivery Express with typical delivery within 3\\u20135 business days.\"}}]}</script></div>', 'done', NULL, NULL, '2026-08-26 21:31:04', '2026-08-26 21:31:04'),
(99, 1, 'listing_writer', '{\"product_id\":1,\"raw_title\":\"The Atelier Cashmere Cocoon Coat\",\"supplier_data\":[]}', '{\"raw_ai_generation\":{\"title\":\"The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition\",\"bullet_points\":[\"\\u26a1 Superior Ergonomics & Build: Crafted with aircraft-grade durability and sleek modern aesthetics.\",\"\\ud83d\\udee1\\ufe0f Certified Quality: 100% inspected and verified for peak performance and longevity.\",\"\\ud83d\\ude9a Express Free Shipping: Dispatched from certified fulfillment hubs with live AWB tracking.\",\"\\ud83d\\udc8e 7-Day Replacement Guarantee: Zero-risk shopping backed by 24\\/7 dedicated support.\"],\"long_description\":\"<div class=\'product-story\'><h3>Engineered for Excellence<\\/h3><p>Experience unmatched reliability and performance with the <strong>The Atelier Cashmere Cocoon Coat<\\/strong>. Designed specifically for contemporary living, it seamlessly integrates advanced functionality with minimalist design aesthetics.<\\/p><h4>Key Highlights:<\\/h4><ul><li>High-efficiency performance tailored for demanding everyday tasks.<\\/li><li>Premium scratch-resistant and tactile finish.<\\/li><li>Backed by full NovaDrop manufacturer warranty.<\\/li><\\/ul><\\/div>\",\"seo_title\":\"The Atelier Cashmere Cocoon Coat | Buy Online Best Price | NovaDrop\",\"seo_description\":\"Shop The Atelier Cashmere Cocoon Coat online at NovaDrop India. Free express delivery, cash on delivery, and exclusive discount codes available today!\",\"image_alt_text\":\"The Atelier Cashmere Cocoon Coat product hero image showcase - NovaDrop Commerce\"},\"moderation_passed\":true,\"flags_triggered\":[],\"approved_copy\":{\"title\":\"The Atelier Cashmere Cocoon Coat \\u2014 Next-Gen Edition\",\"seo_title\":\"The Atelier Cashmere Cocoon Coat | Buy Online Best Price | NovaDrop\",\"seo_description\":\"Shop The Atelier Cashmere Cocoon Coat online at NovaDrop India. Free express delivery, cash on delivery, and exclusive discount codes available today!\",\"bullet_features_html\":\"<ul class=\'nova-bullet-features\'><li>\\u26a1 Superior Ergonomics &amp; Build: Crafted with aircraft-grade durability and sleek modern aesthetics.<\\/li><li>\\ud83d\\udee1\\ufe0f Certified Quality: 100% inspected and verified for peak performance and longevity.<\\/li><li>\\ud83d\\ude9a Express Free Shipping: Dispatched from certified fulfillment hubs with live AWB tracking.<\\/li><li>\\ud83d\\udc8e 7-Day Replacement Guarantee: Zero-risk shopping backed by 24\\/7 dedicated support.<\\/li><\\/ul>\",\"full_html_description\":\"<ul class=\'nova-bullet-features\'><li>\\u26a1 Superior Ergonomics &amp; Build: Crafted with aircraft-grade durability and sleek modern aesthetics.<\\/li><li>\\ud83d\\udee1\\ufe0f Certified Quality: 100% inspected and verified for peak performance and longevity.<\\/li><li>\\ud83d\\ude9a Express Free Shipping: Dispatched from certified fulfillment hubs with live AWB tracking.<\\/li><li>\\ud83d\\udc8e 7-Day Replacement Guarantee: Zero-risk shopping backed by 24\\/7 dedicated support.<\\/li><\\/ul><div class=\'nova-product-description\'><div class=\'product-story\'><h3>Engineered for Excellence<\\/h3><p>Experience unmatched reliability and performance with the <strong>The Atelier Cashmere Cocoon Coat<\\/strong>. Designed specifically for contemporary living, it seamlessly integrates advanced functionality with minimalist design aesthetics.<\\/p><h4>Key Highlights:<\\/h4><ul><li>High-efficiency performance tailored for demanding everyday tasks.<\\/li><li>Premium scratch-resistant and tactile finish.<\\/li><li>Backed by full NovaDrop manufacturer warranty.<\\/li><\\/ul><\\/div><\\/div>\",\"image_alt_text\":\"The Atelier Cashmere Cocoon Coat product hero image showcase - NovaDrop Commerce\"}}', 'done', NULL, NULL, '2026-08-26 21:31:04', '2026-08-26 21:31:04'),
(100, 1, 'vendor_whatsapp_dispatch', '{\"vendor_id\":2,\"phone\":\"+919870330064\",\"order_id\":8}', 'Hello Kenji Takahashi! 🚀 New Order *#04004* has been assigned to *Okayama Selvedge Guild*.\n\nItems to Dispatch:\n• Sculpted 500 GSM Terry Hoodie (x1)\n\nTotal: ₹2,899.00 (Net: ₹2,551.12)\nPlease log in to your Seller Portal to generate shipping label & dispatch:\n👉 http://localhost/Dropshipping/vendor/orders', 'done', NULL, NULL, '2026-08-26 21:42:09', '2026-08-26 21:42:09'),
(101, 1, 'vendor_whatsapp_dispatch', '{\"vendor_id\":2,\"phone\":\"+919870330064\",\"order_id\":9}', 'Hello Kenji Takahashi! 🚀 New Order *#05005* has been assigned to *Okayama Selvedge Guild*.\n\nItems to Dispatch:\n• Sculpted 500 GSM Terry Hoodie (x2)\n\nTotal: ₹5,798.00 (Net: ₹5,102.24)\nPlease log in to your Seller Portal to generate shipping label & dispatch:\n👉 http://localhost/Dropshipping/vendor/orders', 'done', NULL, NULL, '2026-08-26 22:05:01', '2026-08-26 22:05:01');

-- --------------------------------------------------------

--
-- Table structure for table `ai_autopilot_configs`
--

CREATE TABLE `ai_autopilot_configs` (
  `id` int(10) UNSIGNED NOT NULL,
  `store_id` int(10) UNSIGNED NOT NULL,
  `autopilot_enabled` tinyint(1) NOT NULL DEFAULT 1,
  `auto_pricing` tinyint(1) NOT NULL DEFAULT 1,
  `auto_seo` tinyint(1) NOT NULL DEFAULT 1,
  `auto_fraud` tinyint(1) NOT NULL DEFAULT 1,
  `auto_cart_recovery` tinyint(1) NOT NULL DEFAULT 1,
  `min_consensus` decimal(4,3) NOT NULL DEFAULT 0.850,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ai_autopilot_configs`
--

INSERT INTO `ai_autopilot_configs` (`id`, `store_id`, `autopilot_enabled`, `auto_pricing`, `auto_seo`, `auto_fraud`, `auto_cart_recovery`, `min_consensus`, `updated_at`) VALUES
(1, 1, 1, 1, 1, 1, 1, 0.850, '2026-08-19 11:46:06');

-- --------------------------------------------------------

--
-- Table structure for table `ai_orchestrator_config`
--

CREATE TABLE `ai_orchestrator_config` (
  `setting_key` varchar(80) NOT NULL,
  `setting_value` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ai_orchestrator_config`
--

INSERT INTO `ai_orchestrator_config` (`setting_key`, `setting_value`, `description`, `updated_at`) VALUES
('autonomy_level', 'supervised', 'Mode: supervised (awaiting approval) or full_auto', '2026-08-19 17:14:24'),
('max_ad_spend_shift_daily', '2000', 'Maximum daily INR budget shift suggested or applied autonomously', '2026-08-19 17:14:24'),
('max_autonomous_discount_pct', '15', 'Maximum discount percentage the AI can offer without human approval', '2026-08-19 17:14:24'),
('notification_recipient_email', 'admin@novadrop.in', 'Recipient for weekly plain-English AI decision digests', '2026-08-19 17:14:24');

-- --------------------------------------------------------

--
-- Table structure for table `ai_orchestrator_runs`
--

CREATE TABLE `ai_orchestrator_runs` (
  `id` bigint(20) NOT NULL,
  `run_at` datetime DEFAULT current_timestamp(),
  `decisions_json` longtext NOT NULL,
  `actions_taken_json` longtext NOT NULL,
  `status` enum('completed','partial','failed') DEFAULT 'completed',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ai_swarm_telemetry`
--

CREATE TABLE `ai_swarm_telemetry` (
  `id` int(10) UNSIGNED NOT NULL,
  `store_id` int(10) UNSIGNED NOT NULL,
  `agent_name` varchar(80) NOT NULL,
  `action` varchar(120) NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`payload`)),
  `consensus_score` decimal(4,3) NOT NULL DEFAULT 0.950,
  `status` enum('active','completed','failed','pending_approval') NOT NULL DEFAULT 'completed',
  `impact_summary` varchar(500) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ai_swarm_telemetry`
--

INSERT INTO `ai_swarm_telemetry` (`id`, `store_id`, `agent_name`, `action`, `payload`, `consensus_score`, `status`, `impact_summary`, `created_at`) VALUES
(1, 1, 'SourcingAgent', 'CATALOG_AUDIT_&_TREND_RADAR', '{\"active_skus\":4,\"recommended_trends\":[\"Wireless Magnetic Powerbanks\",\"Ergonomic Vertical Mice\",\"Smart LED Lightstrips\"],\"target_margin\":\"68.5%\"}', 0.980, 'completed', 'Audited 4 active SKUs. Identified 3 high-velocity winning opportunities in Electronics & Lifestyle.', '2026-08-19 08:18:29'),
(2, 1, 'PricingAgent', 'DYNAMIC_MARGIN_OPTIMIZE', '{\"optimized_count\":4,\"fx_rate\":84.5,\"target_markup\":\"280%\"}', 0.960, 'completed', 'Rebalanced 4 product pricing curves for optimal conversion elasticity and net yield.', '2026-08-19 08:18:29'),
(3, 1, 'MarketingSEOAgent', 'GEO_&_SCHEMA_MICRODATA_SYNC', '{\"optimized_pages\":4,\"schema_format\":\"Product+Offer+AggregateRating\"}', 0.990, 'completed', 'Synchronized Schema.org JSON-LD and search vectors across 4 product pages.', '2026-08-19 08:18:29'),
(4, 1, 'FraudRiskAgent', 'CHECKOUT_RISK_SURVEILLANCE', '{\"scanned_orders\":0,\"risk_distribution\":{\"low\":0,\"med\":0,\"high\":0}}', 0.970, 'completed', 'Scanned 0 recent transactions. 0 suspicious velocity triggers, 100% orders cleared for auto-fulfillment.', '2026-08-19 08:18:29'),
(5, 1, 'SourcingAgent', 'CATALOG_AUDIT_&_TREND_RADAR', '{\"active_skus\":4,\"recommended_trends\":[\"Wireless Magnetic Powerbanks\",\"Ergonomic Vertical Mice\",\"Smart LED Lightstrips\"],\"target_margin\":\"68.5%\"}', 0.980, 'completed', 'Audited 4 active SKUs. Identified 3 high-velocity winning opportunities in Electronics & Lifestyle.', '2026-08-19 08:18:54'),
(6, 1, 'PricingAgent', 'DYNAMIC_MARGIN_OPTIMIZE', '{\"optimized_count\":4,\"fx_rate\":84.5,\"target_markup\":\"280%\"}', 0.960, 'completed', 'Rebalanced 4 product pricing curves for optimal conversion elasticity and net yield.', '2026-08-19 08:18:54'),
(7, 1, 'MarketingSEOAgent', 'GEO_&_SCHEMA_MICRODATA_SYNC', '{\"optimized_pages\":0,\"schema_format\":\"Product+Offer+AggregateRating\"}', 0.990, 'completed', 'Synchronized Schema.org JSON-LD and search vectors across 0 product pages.', '2026-08-19 08:18:54'),
(8, 1, 'FraudRiskAgent', 'CHECKOUT_RISK_SURVEILLANCE', '{\"scanned_orders\":0,\"risk_distribution\":{\"low\":0,\"med\":0,\"high\":0}}', 0.970, 'completed', 'Scanned 0 recent transactions. 0 suspicious velocity triggers, 100% orders cleared for auto-fulfillment.', '2026-08-19 08:18:54'),
(9, 1, 'InventoryRecoveryAgent', 'RECOVERY_&_DISPATCH_ORCHESTRATOR', '{\"abandoned_detected\":0,\"reengagement_discount\":\"SAVE10\"}', 0.950, 'completed', 'Audited cart sessions. Enqueued 0 recovery sequences; all stock thresholds verified healthy.', '2026-08-19 08:18:54');

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` int(11) NOT NULL,
  `text` varchar(500) NOT NULL,
  `link_url` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`id`, `text`, `link_url`, `is_active`, `created_at`) VALUES
(1, '⚡ FREE Express Delivery on all Prepaid Orders above ₹999 | Use Code NOVA50', '/shop', 1, '2026-08-19 15:03:36');

-- --------------------------------------------------------

--
-- Table structure for table `api_keys`
--

CREATE TABLE `api_keys` (
  `id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT 1,
  `owner_type` enum('admin','vendor','app') NOT NULL DEFAULT 'admin',
  `owner_id` int(11) DEFAULT 1,
  `name` varchar(150) NOT NULL,
  `key_prefix` varchar(16) NOT NULL,
  `key_hash` varchar(64) NOT NULL,
  `scopes_json` longtext NOT NULL,
  `rate_limit_per_min` int(11) NOT NULL DEFAULT 60,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `last_used_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `api_keys`
--

INSERT INTO `api_keys` (`id`, `store_id`, `owner_type`, `owner_id`, `name`, `key_prefix`, `key_hash`, `scopes_json`, `rate_limit_per_min`, `is_active`, `last_used_at`, `created_at`) VALUES
(1, 1, 'admin', 1, 'Master Production Integration Key', 'nova_sk_live_ate', 'e09c047925e3ea2d6ebd996132abaa7c71f00e352910c602978928c91f0c1368', '[\"products:read\",\"products:write\",\"orders:read\",\"orders:write\",\"inventory:read\",\"inventory:write\",\"customers:read\",\"webhooks:manage\"]', 120, 1, '2026-08-19 18:50:26', '2026-08-19 18:50:07');

-- --------------------------------------------------------

--
-- Table structure for table `api_request_log`
--

CREATE TABLE `api_request_log` (
  `id` bigint(20) NOT NULL,
  `api_key_id` int(11) NOT NULL,
  `endpoint` varchar(255) NOT NULL,
  `method` varchar(10) NOT NULL,
  `status_code` int(11) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `latency_ms` decimal(8,2) NOT NULL DEFAULT 0.00,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `api_request_log`
--

INSERT INTO `api_request_log` (`id`, `api_key_id`, `endpoint`, `method`, `status_code`, `ip_address`, `latency_ms`, `created_at`) VALUES
(1, 1, 'products', 'GET', 200, '127.0.0.1', 196.20, '2026-08-19 18:50:16'),
(2, 1, 'products', 'GET', 200, '127.0.0.1', 169.27, '2026-08-19 18:50:26');

-- --------------------------------------------------------

--
-- Table structure for table `audit_log`
--

CREATE TABLE `audit_log` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `store_id` int(10) UNSIGNED DEFAULT NULL,
  `actor_type` enum('admin','system','customer','api') NOT NULL DEFAULT 'admin',
  `actor_id` int(10) UNSIGNED DEFAULT NULL,
  `action` varchar(120) NOT NULL,
  `details` longtext DEFAULT NULL,
  `entity_type` varchar(60) DEFAULT NULL,
  `entity_id` int(10) UNSIGNED DEFAULT NULL,
  `meta_json` longtext DEFAULT NULL,
  `old_values` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`old_values`)),
  `new_values` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`new_values`)),
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` varchar(500) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `audit_log`
--

INSERT INTO `audit_log` (`id`, `store_id`, `actor_type`, `actor_id`, `action`, `details`, `entity_type`, `entity_id`, `meta_json`, `old_values`, `new_values`, `ip_address`, `user_agent`, `created_at`) VALUES
(1, 1, 'system', NULL, 'admin.login.failed', NULL, 'admin_users', NULL, NULL, NULL, '{\"email\":\"admin@novadrop.in\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-19 08:15:23'),
(2, 1, 'system', NULL, 'admin.login.failed', NULL, 'admin_users', NULL, NULL, NULL, '{\"email\":\"admin@novadrop.in\"}', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-19 08:15:35'),
(3, 1, 'system', NULL, 'admin.login.success', NULL, 'admin_users', 1, NULL, NULL, NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-19 10:31:46'),
(7, NULL, '', 0, 'FULL_SWARM_CYCLE_EXECUTED', '{\"cycle_id\":\"CYC-5C0C2BAA\",\"timestamp\":\"2026-08-19 12:16:09\",\"consensus_score\":\"98.7%\",\"agents_executed\":7,\"total_actions\":20,\"telemetry\":[{\"agent\":\"SourcingAgent\",\"task\":\"Winning Product Trend Radar\",\"status\":\"SUCCESS\",\"score\":0.99,\"summary\":\"Scanned 8 active catalog items. Identified 4 high-margin trend opportunities (Smart LED Gadgets, Ergonomic Accessories, Activewear).\"},{\"agent\":\"PricingOptimizerAgent\",\"task\":\"Dynamic Margin & Psychological Pricing\",\"status\":\"SUCCESS\",\"score\":0.98,\"summary\":\"Audited price elasticity. Rebalanced 12 SKUs to optimal psychological price points (.99 \\/ \\u20b9999 tier) protecting a 65%+ gross margin.\"},{\"agent\":\"SEOCopywriterAgent\",\"task\":\"Schema.org & Meta Tags Generation\",\"status\":\"SUCCESS\",\"score\":0.97,\"summary\":\"Injected JSON-LD product microdata and generated high-converting benefit bullet points for all active storefront products.\"},{\"agent\":\"CartRecoveryAgent\",\"task\":\"Autonomous Abandoned Cart Recovery\",\"status\":\"SUCCESS\",\"score\":0.96,\"summary\":\"Detected 0 stalled checkouts. Prepared personalized WhatsApp recovery payloads with 1-click checkout links and promo code NOVA10.\"},{\"agent\":\"FraudRiskSentinel\",\"task\":\"Transaction Risk & Anomaly Scoring\",\"status\":\"SUCCESS\",\"score\":0.99,\"summary\":\"Audited 1 orders. 0 high-risk transactions detected. Geolocation and IP integrity verified.\"},{\"agent\":\"InventoryWatchdog\",\"task\":\"Low-Stock Safeguard & Supplier Sync\",\"status\":\"SUCCESS\",\"score\":0.98,\"summary\":\"Catalog inventory verified. All core SKUs meet minimum safety threshold (>15 units available across all active variants).\"},{\"agent\":\"SupportTriageAgent\",\"task\":\"Customer Inquiry Auto-Categorization\",\"status\":\"SUCCESS\",\"score\":0.97,\"summary\":\"Processed support queue. Auto-tagged inquiries into Shipping, Sizing, and Product Specs categories with draft responses ready.\"}]}', 'system', 0, NULL, NULL, NULL, '127.0.0.1', NULL, '2026-08-19 15:46:09'),
(8, NULL, '', 0, 'FULL_SWARM_CYCLE_EXECUTED', '{\"cycle_id\":\"CYC-5C7FD1D8\",\"timestamp\":\"2026-08-19 12:16:23\",\"consensus_score\":\"98.7%\",\"agents_executed\":7,\"total_actions\":20,\"telemetry\":[{\"agent\":\"SourcingAgent\",\"task\":\"Winning Product Trend Radar\",\"status\":\"SUCCESS\",\"score\":0.99,\"summary\":\"Scanned 8 active catalog items. Identified 4 high-margin trend opportunities (Smart LED Gadgets, Ergonomic Accessories, Activewear).\"},{\"agent\":\"PricingOptimizerAgent\",\"task\":\"Dynamic Margin & Psychological Pricing\",\"status\":\"SUCCESS\",\"score\":0.98,\"summary\":\"Audited price elasticity. Rebalanced 12 SKUs to optimal psychological price points (.99 \\/ \\u20b9999 tier) protecting a 65%+ gross margin.\"},{\"agent\":\"SEOCopywriterAgent\",\"task\":\"Schema.org & Meta Tags Generation\",\"status\":\"SUCCESS\",\"score\":0.97,\"summary\":\"Injected JSON-LD product microdata and generated high-converting benefit bullet points for all active storefront products.\"},{\"agent\":\"CartRecoveryAgent\",\"task\":\"Autonomous Abandoned Cart Recovery\",\"status\":\"SUCCESS\",\"score\":0.96,\"summary\":\"Detected 0 stalled checkouts. Prepared personalized WhatsApp recovery payloads with 1-click checkout links and promo code NOVA10.\"},{\"agent\":\"FraudRiskSentinel\",\"task\":\"Transaction Risk & Anomaly Scoring\",\"status\":\"SUCCESS\",\"score\":0.99,\"summary\":\"Audited 1 orders. 0 high-risk transactions detected. Geolocation and IP integrity verified.\"},{\"agent\":\"InventoryWatchdog\",\"task\":\"Low-Stock Safeguard & Supplier Sync\",\"status\":\"SUCCESS\",\"score\":0.98,\"summary\":\"Catalog inventory verified. All core SKUs meet minimum safety threshold (>15 units available across all active variants).\"},{\"agent\":\"SupportTriageAgent\",\"task\":\"Customer Inquiry Auto-Categorization\",\"status\":\"SUCCESS\",\"score\":0.97,\"summary\":\"Processed support queue. Auto-tagged inquiries into Shipping, Sizing, and Product Specs categories with draft responses ready.\"}]}', 'system', 0, NULL, NULL, NULL, '127.0.0.1', NULL, '2026-08-19 15:46:23'),
(9, NULL, '', 0, 'FULL_SWARM_CYCLE_EXECUTED', '{\"cycle_id\":\"CYC-8B21817F\",\"timestamp\":\"2026-08-19 12:18:57\",\"consensus_score\":\"99.4%\",\"agents_executed\":7,\"total_actions\":24,\"telemetry\":[{\"agent\":\"OrchestratorAgent\",\"task\":\"Swarm Consensus & Mesh Coordination\",\"status\":\"SUCCESS\",\"score\":0.99,\"summary\":\"Synchronized 7 specialized worker agents. Consensus threshold reached at 99.4% confidence.\"},{\"agent\":\"PricingOptimizerAgent\",\"task\":\"Dynamic Margin & Psychological Pricing\",\"status\":\"SUCCESS\",\"score\":0.99,\"summary\":\"Audited all active SKUs. Enforced 65%+ gross margin floor and psychological pricing (.99 \\/ \\u20b9999 tier).\"},{\"agent\":\"SEOCopywriterAgent\",\"task\":\"Schema.org & Google Rich Snippets Ingestion\",\"status\":\"SUCCESS\",\"score\":0.98,\"summary\":\"Generated JSON-LD microdata and SEO conversion bullet points for all active storefront products.\"},{\"agent\":\"CartRecoveryAgent\",\"task\":\"Autonomous Abandoned Cart Recovery\",\"status\":\"SUCCESS\",\"score\":0.97,\"summary\":\"Detected 0 stalled checkouts. Prepared personalized WhatsApp recovery payloads with 1-click checkout links.\"},{\"agent\":\"FraudRiskSentinel\",\"task\":\"Checkout Anomaly & IP Geolocation Scoring\",\"status\":\"SUCCESS\",\"score\":0.99,\"summary\":\"Audited 1 orders. 0 high-risk transactions detected. Geolocation and IP integrity verified.\"},{\"agent\":\"SupplierDispatchAgent\",\"task\":\"Supplier API Auto-Routing & AWB Assignment\",\"status\":\"SUCCESS\",\"score\":0.99,\"summary\":\"Synchronized fulfillment pipelines with supplier APIs. Auto-assigned courier tracking numbers to all paid orders.\"},{\"agent\":\"SupportTriageAgent\",\"task\":\"Customer Inquiry Auto-Categorization & SLA\",\"status\":\"SUCCESS\",\"score\":0.98,\"summary\":\"Processed support queue. Auto-tagged inquiries into Shipping, Sizing, and Refunds with draft replies ready.\"}]}', 'system', 0, NULL, NULL, NULL, '127.0.0.1', NULL, '2026-08-19 15:48:57'),
(10, NULL, '', 0, 'FULL_SWARM_CYCLE_EXECUTED', '{\"cycle_id\":\"CYC-2B676CA2\",\"timestamp\":\"2026-08-19 12:20:31\",\"consensus_score\":\"99.4%\",\"agents_executed\":7,\"total_actions\":24,\"telemetry\":[{\"agent\":\"OrchestratorAgent\",\"task\":\"Swarm Consensus & Mesh Coordination\",\"status\":\"SUCCESS\",\"score\":0.99,\"summary\":\"Synchronized 7 specialized worker agents. Consensus threshold reached at 99.4% confidence.\"},{\"agent\":\"PricingOptimizerAgent\",\"task\":\"Dynamic Margin & Psychological Pricing\",\"status\":\"SUCCESS\",\"score\":0.99,\"summary\":\"Audited all active SKUs. Enforced 65%+ gross margin floor and psychological pricing (.99 \\/ \\u20b9999 tier).\"},{\"agent\":\"SEOCopywriterAgent\",\"task\":\"Schema.org & Google Rich Snippets Ingestion\",\"status\":\"SUCCESS\",\"score\":0.98,\"summary\":\"Generated JSON-LD microdata and SEO conversion bullet points for all active storefront products.\"},{\"agent\":\"CartRecoveryAgent\",\"task\":\"Autonomous Abandoned Cart Recovery\",\"status\":\"SUCCESS\",\"score\":0.97,\"summary\":\"Detected 0 stalled checkouts. Prepared personalized WhatsApp recovery payloads with 1-click checkout links.\"},{\"agent\":\"FraudRiskSentinel\",\"task\":\"Checkout Anomaly & IP Geolocation Scoring\",\"status\":\"SUCCESS\",\"score\":0.99,\"summary\":\"Audited 1 orders. 0 high-risk transactions detected. Geolocation and IP integrity verified.\"},{\"agent\":\"SupplierDispatchAgent\",\"task\":\"Supplier API Auto-Routing & AWB Assignment\",\"status\":\"SUCCESS\",\"score\":0.99,\"summary\":\"Synchronized fulfillment pipelines with supplier APIs. Auto-assigned courier tracking numbers to all paid orders.\"},{\"agent\":\"SupportTriageAgent\",\"task\":\"Customer Inquiry Auto-Categorization & SLA\",\"status\":\"SUCCESS\",\"score\":0.98,\"summary\":\"Processed support queue. Auto-tagged inquiries into Shipping, Sizing, and Refunds with draft replies ready.\"}]}', 'system', 0, NULL, NULL, NULL, '127.0.0.1', NULL, '2026-08-19 15:50:31'),
(11, NULL, '', 0, 'FULL_SWARM_CYCLE_EXECUTED', '{\"cycle_id\":\"CYC-251375F0\",\"timestamp\":\"2026-08-19 12:21:48\",\"consensus_score\":\"99.6%\",\"agents_executed\":7,\"total_actions\":24,\"telemetry\":[{\"agent\":\"Swarm Orchestrator\",\"task\":\"Consensus & Multi-Agent Mesh Coordination\",\"status\":\"SUCCESS\",\"score\":0.99,\"summary\":\"Synchronized all 7 specialized agents. Full consensus reached at 99.6% optimal threshold.\"},{\"agent\":\"PricingOptimizerAgent\",\"task\":\"Dynamic Margin & Psychological Pricing\",\"status\":\"SUCCESS\",\"score\":0.99,\"summary\":\"Audited 8 catalog SKUs. Enforced 65%+ gross profit margin floor and psychological pricing.\"},{\"agent\":\"SEOCopywriterAgent\",\"task\":\"Schema.org & Google Rich Snippets Ingestion\",\"status\":\"SUCCESS\",\"score\":0.98,\"summary\":\"Injected JSON-LD product microdata and high-CTR benefit bullet points for all active storefront products.\"},{\"agent\":\"CartRecoveryAgent\",\"task\":\"Autonomous Abandoned Cart Recovery\",\"status\":\"SUCCESS\",\"score\":0.97,\"summary\":\"Identified 0 stalled checkouts. Prepared personalized WhatsApp recovery payloads with 1-click checkout links.\"},{\"agent\":\"FraudRiskSentinel\",\"task\":\"Checkout Anomaly & IP Geolocation Scoring\",\"status\":\"SUCCESS\",\"score\":0.99,\"summary\":\"Audited 1 orders. 0 high-risk transactions detected. Geolocation, proxy, and velocity integrity verified.\"},{\"agent\":\"SupplierDispatchAgent\",\"task\":\"Supplier API Auto-Routing & AWB Assignment\",\"status\":\"SUCCESS\",\"score\":0.99,\"summary\":\"Synchronized fulfillment pipelines with supplier APIs. Auto-assigned courier tracking numbers to all paid orders.\"},{\"agent\":\"SupportTriageAgent\",\"task\":\"Customer Inquiry Auto-Categorization & SLA\",\"status\":\"SUCCESS\",\"score\":0.98,\"summary\":\"Processed support queue. Auto-tagged inquiries into Shipping, Sizing, and Refunds with draft replies ready.\"}]}', 'system', 0, NULL, NULL, NULL, '127.0.0.1', NULL, '2026-08-19 15:51:48'),
(12, NULL, '', 0, 'FULL_SWARM_CYCLE_EXECUTED', '{\"cycle_id\":\"CYC-FB8C09A5\",\"timestamp\":\"2026-08-19 12:22:26\",\"consensus_score\":\"99.6%\",\"agents_executed\":7,\"total_actions\":24,\"telemetry\":[{\"agent\":\"Swarm Orchestrator\",\"task\":\"Consensus & Multi-Agent Mesh Coordination\",\"status\":\"SUCCESS\",\"score\":0.99,\"summary\":\"Synchronized all 7 specialized agents. Full consensus reached at 99.6% optimal threshold.\"},{\"agent\":\"PricingOptimizerAgent\",\"task\":\"Dynamic Margin & Psychological Pricing\",\"status\":\"SUCCESS\",\"score\":0.99,\"summary\":\"Audited 8 catalog SKUs. Enforced 65%+ gross profit margin floor and psychological pricing.\"},{\"agent\":\"SEOCopywriterAgent\",\"task\":\"Schema.org & Google Rich Snippets Ingestion\",\"status\":\"SUCCESS\",\"score\":0.98,\"summary\":\"Injected JSON-LD product microdata and high-CTR benefit bullet points for all active storefront products.\"},{\"agent\":\"CartRecoveryAgent\",\"task\":\"Autonomous Abandoned Cart Recovery\",\"status\":\"SUCCESS\",\"score\":0.97,\"summary\":\"Identified 0 stalled checkouts. Prepared personalized WhatsApp recovery payloads with 1-click checkout links.\"},{\"agent\":\"FraudRiskSentinel\",\"task\":\"Checkout Anomaly & IP Geolocation Scoring\",\"status\":\"SUCCESS\",\"score\":0.99,\"summary\":\"Audited 1 orders. 0 high-risk transactions detected. Geolocation, proxy, and velocity integrity verified.\"},{\"agent\":\"SupplierDispatchAgent\",\"task\":\"Supplier API Auto-Routing & AWB Assignment\",\"status\":\"SUCCESS\",\"score\":0.99,\"summary\":\"Synchronized fulfillment pipelines with supplier APIs. Auto-assigned courier tracking numbers to all paid orders.\"},{\"agent\":\"SupportTriageAgent\",\"task\":\"Customer Inquiry Auto-Categorization & SLA\",\"status\":\"SUCCESS\",\"score\":0.98,\"summary\":\"Processed support queue. Auto-tagged inquiries into Shipping, Sizing, and Refunds with draft replies ready.\"}]}', 'system', 0, NULL, NULL, NULL, '127.0.0.1', NULL, '2026-08-19 15:52:26'),
(13, NULL, '', 0, 'FULL_SWARM_CYCLE_EXECUTED', '{\"cycle_id\":\"CYC-A434BA57\",\"timestamp\":\"2026-08-19 12:22:55\",\"consensus_score\":\"99.6%\",\"agents_executed\":7,\"total_actions\":24,\"telemetry\":[{\"agent\":\"Swarm Orchestrator\",\"task\":\"Consensus & Multi-Agent Mesh Coordination\",\"status\":\"SUCCESS\",\"score\":0.99,\"summary\":\"Synchronized all 7 specialized agents. Full consensus reached at 99.6% optimal threshold.\"},{\"agent\":\"PricingOptimizerAgent\",\"task\":\"Dynamic Margin & Psychological Pricing\",\"status\":\"SUCCESS\",\"score\":0.99,\"summary\":\"Audited 8 catalog SKUs. Enforced 65%+ gross profit margin floor and psychological pricing.\"},{\"agent\":\"SEOCopywriterAgent\",\"task\":\"Schema.org & Google Rich Snippets Ingestion\",\"status\":\"SUCCESS\",\"score\":0.98,\"summary\":\"Injected JSON-LD product microdata and high-CTR benefit bullet points for all active storefront products.\"},{\"agent\":\"CartRecoveryAgent\",\"task\":\"Autonomous Abandoned Cart Recovery\",\"status\":\"SUCCESS\",\"score\":0.97,\"summary\":\"Identified 0 stalled checkouts. Prepared personalized WhatsApp recovery payloads with 1-click checkout links.\"},{\"agent\":\"FraudRiskSentinel\",\"task\":\"Checkout Anomaly & IP Geolocation Scoring\",\"status\":\"SUCCESS\",\"score\":0.99,\"summary\":\"Audited 1 orders. 0 high-risk transactions detected. Geolocation, proxy, and velocity integrity verified.\"},{\"agent\":\"SupplierDispatchAgent\",\"task\":\"Supplier API Auto-Routing & AWB Assignment\",\"status\":\"SUCCESS\",\"score\":0.99,\"summary\":\"Synchronized fulfillment pipelines with supplier APIs. Auto-assigned courier tracking numbers to all paid orders.\"},{\"agent\":\"SupportTriageAgent\",\"task\":\"Customer Inquiry Auto-Categorization & SLA\",\"status\":\"SUCCESS\",\"score\":0.98,\"summary\":\"Processed support queue. Auto-tagged inquiries into Shipping, Sizing, and Refunds with draft replies ready.\"}]}', 'system', 0, NULL, NULL, NULL, '127.0.0.1', NULL, '2026-08-19 15:52:55'),
(14, NULL, '', 0, 'FULL_SWARM_CYCLE_EXECUTED', '{\"cycle_id\":\"CYC-814C0E65\",\"timestamp\":\"2026-08-19 12:23:09\",\"consensus_score\":\"99.6%\",\"agents_executed\":7,\"total_actions\":24,\"telemetry\":[{\"agent\":\"Swarm Orchestrator\",\"task\":\"Consensus & Multi-Agent Mesh Coordination\",\"status\":\"SUCCESS\",\"score\":0.99,\"summary\":\"Synchronized all 7 specialized agents. Full consensus reached at 99.6% optimal threshold.\"},{\"agent\":\"PricingOptimizerAgent\",\"task\":\"Dynamic Margin & Psychological Pricing\",\"status\":\"SUCCESS\",\"score\":0.99,\"summary\":\"Audited 8 catalog SKUs. Enforced 65%+ gross profit margin floor and psychological pricing.\"},{\"agent\":\"SEOCopywriterAgent\",\"task\":\"Schema.org & Google Rich Snippets Ingestion\",\"status\":\"SUCCESS\",\"score\":0.98,\"summary\":\"Injected JSON-LD product microdata and high-CTR benefit bullet points for all active storefront products.\"},{\"agent\":\"CartRecoveryAgent\",\"task\":\"Autonomous Abandoned Cart Recovery\",\"status\":\"SUCCESS\",\"score\":0.97,\"summary\":\"Identified 0 stalled checkouts. Prepared personalized WhatsApp recovery payloads with 1-click checkout links.\"},{\"agent\":\"FraudRiskSentinel\",\"task\":\"Checkout Anomaly & IP Geolocation Scoring\",\"status\":\"SUCCESS\",\"score\":0.99,\"summary\":\"Audited 1 orders. 0 high-risk transactions detected. Geolocation, proxy, and velocity integrity verified.\"},{\"agent\":\"SupplierDispatchAgent\",\"task\":\"Supplier API Auto-Routing & AWB Assignment\",\"status\":\"SUCCESS\",\"score\":0.99,\"summary\":\"Synchronized fulfillment pipelines with supplier APIs. Auto-assigned courier tracking numbers to all paid orders.\"},{\"agent\":\"SupportTriageAgent\",\"task\":\"Customer Inquiry Auto-Categorization & SLA\",\"status\":\"SUCCESS\",\"score\":0.98,\"summary\":\"Processed support queue. Auto-tagged inquiries into Shipping, Sizing, and Refunds with draft replies ready.\"}]}', 'system', 0, NULL, NULL, NULL, '127.0.0.1', NULL, '2026-08-19 15:53:09'),
(15, NULL, '', 0, 'FULL_SWARM_CYCLE_EXECUTED', '{\"cycle_id\":\"CYC-F81CF59F\",\"timestamp\":\"2026-08-19 12:24:06\",\"consensus_score\":\"99.6%\",\"agents_executed\":7,\"total_actions\":24,\"telemetry\":[{\"agent\":\"Swarm Orchestrator\",\"task\":\"Consensus & Multi-Agent Mesh Coordination\",\"status\":\"SUCCESS\",\"score\":0.99,\"summary\":\"Synchronized all 7 specialized agents. Full consensus reached at 99.6% optimal threshold.\"},{\"agent\":\"PricingOptimizerAgent\",\"task\":\"Dynamic Margin & Psychological Pricing\",\"status\":\"SUCCESS\",\"score\":0.99,\"summary\":\"Audited 8 catalog SKUs. Enforced 65%+ gross profit margin floor and psychological pricing.\"},{\"agent\":\"SEOCopywriterAgent\",\"task\":\"Schema.org & Google Rich Snippets Ingestion\",\"status\":\"SUCCESS\",\"score\":0.98,\"summary\":\"Injected JSON-LD product microdata and high-CTR benefit bullet points for all active storefront products.\"},{\"agent\":\"CartRecoveryAgent\",\"task\":\"Autonomous Abandoned Cart Recovery\",\"status\":\"SUCCESS\",\"score\":0.97,\"summary\":\"Identified 0 stalled checkouts. Prepared personalized WhatsApp recovery payloads with 1-click checkout links.\"},{\"agent\":\"FraudRiskSentinel\",\"task\":\"Checkout Anomaly & IP Geolocation Scoring\",\"status\":\"SUCCESS\",\"score\":0.99,\"summary\":\"Audited 1 orders. 0 high-risk transactions detected. Geolocation, proxy, and velocity integrity verified.\"},{\"agent\":\"SupplierDispatchAgent\",\"task\":\"Supplier API Auto-Routing & AWB Assignment\",\"status\":\"SUCCESS\",\"score\":0.99,\"summary\":\"Synchronized fulfillment pipelines with supplier APIs. Auto-assigned courier tracking numbers to all paid orders.\"},{\"agent\":\"SupportTriageAgent\",\"task\":\"Customer Inquiry Auto-Categorization & SLA\",\"status\":\"SUCCESS\",\"score\":0.98,\"summary\":\"Processed support queue. Auto-tagged inquiries into Shipping, Sizing, and Refunds with draft replies ready.\"}]}', 'system', 0, NULL, NULL, NULL, '127.0.0.1', NULL, '2026-08-19 15:54:06'),
(16, NULL, '', 0, 'FULL_SWARM_CYCLE_EXECUTED', '{\"cycle_id\":\"CYC-0A2EDA76\",\"timestamp\":\"2026-08-19 12:24:39\",\"consensus_score\":\"99.6%\",\"agents_executed\":7,\"total_actions\":24,\"telemetry\":[{\"agent\":\"Swarm Orchestrator\",\"task\":\"Consensus & Multi-Agent Mesh Coordination\",\"status\":\"SUCCESS\",\"score\":0.99,\"summary\":\"Synchronized all 7 specialized agents. Full consensus reached at 99.6% optimal threshold.\"},{\"agent\":\"PricingOptimizerAgent\",\"task\":\"Dynamic Margin & Psychological Pricing\",\"status\":\"SUCCESS\",\"score\":0.99,\"summary\":\"Audited 8 catalog SKUs. Enforced 65%+ gross profit margin floor and psychological pricing.\"},{\"agent\":\"SEOCopywriterAgent\",\"task\":\"Schema.org & Google Rich Snippets Ingestion\",\"status\":\"SUCCESS\",\"score\":0.98,\"summary\":\"Injected JSON-LD product microdata and high-CTR benefit bullet points for all active storefront products.\"},{\"agent\":\"CartRecoveryAgent\",\"task\":\"Autonomous Abandoned Cart Recovery\",\"status\":\"SUCCESS\",\"score\":0.97,\"summary\":\"Identified 0 stalled checkouts. Prepared personalized WhatsApp recovery payloads with 1-click checkout links.\"},{\"agent\":\"FraudRiskSentinel\",\"task\":\"Checkout Anomaly & IP Geolocation Scoring\",\"status\":\"SUCCESS\",\"score\":0.99,\"summary\":\"Audited 1 orders. 0 high-risk transactions detected. Geolocation, proxy, and velocity integrity verified.\"},{\"agent\":\"SupplierDispatchAgent\",\"task\":\"Supplier API Auto-Routing & AWB Assignment\",\"status\":\"SUCCESS\",\"score\":0.99,\"summary\":\"Synchronized fulfillment pipelines with supplier APIs. Auto-assigned courier tracking numbers to all paid orders.\"},{\"agent\":\"SupportTriageAgent\",\"task\":\"Customer Inquiry Auto-Categorization & SLA\",\"status\":\"SUCCESS\",\"score\":0.98,\"summary\":\"Processed support queue. Auto-tagged inquiries into Shipping, Sizing, and Refunds with draft replies ready.\"}]}', 'system', 0, NULL, NULL, NULL, '127.0.0.1', NULL, '2026-08-19 15:54:39'),
(17, NULL, '', 0, 'FULL_SWARM_CYCLE_EXECUTED', '{\"cycle_id\":\"CYC-94E4A507\",\"timestamp\":\"2026-08-19 13:16:41\",\"consensus_score\":\"99.6%\",\"agents_executed\":7,\"total_actions\":24,\"telemetry\":[{\"agent\":\"Swarm Orchestrator\",\"task\":\"Consensus & Multi-Agent Mesh Coordination\",\"status\":\"SUCCESS\",\"score\":0.99,\"summary\":\"Synchronized all 7 specialized agents. Full consensus reached at 99.6% optimal threshold.\"},{\"agent\":\"PricingOptimizerAgent\",\"task\":\"Dynamic Margin & Psychological Pricing\",\"status\":\"SUCCESS\",\"score\":0.99,\"summary\":\"Audited 10 catalog SKUs. Enforced 65%+ gross profit margin floor and psychological pricing.\"},{\"agent\":\"SEOCopywriterAgent\",\"task\":\"Schema.org & Google Rich Snippets Ingestion\",\"status\":\"SUCCESS\",\"score\":0.98,\"summary\":\"Injected JSON-LD product microdata and high-CTR benefit bullet points for all active storefront products.\"},{\"agent\":\"CartRecoveryAgent\",\"task\":\"Autonomous Abandoned Cart Recovery\",\"status\":\"SUCCESS\",\"score\":0.97,\"summary\":\"Identified 1 stalled checkouts. Prepared personalized WhatsApp recovery payloads with 1-click checkout links.\"},{\"agent\":\"FraudRiskSentinel\",\"task\":\"Checkout Anomaly & IP Geolocation Scoring\",\"status\":\"SUCCESS\",\"score\":0.99,\"summary\":\"Audited 7 orders. 0 high-risk transactions detected. Geolocation, proxy, and velocity integrity verified.\"},{\"agent\":\"SupplierDispatchAgent\",\"task\":\"Supplier API Auto-Routing & AWB Assignment\",\"status\":\"SUCCESS\",\"score\":0.99,\"summary\":\"Synchronized fulfillment pipelines with supplier APIs. Auto-assigned courier tracking numbers to all paid orders.\"},{\"agent\":\"SupportTriageAgent\",\"task\":\"Customer Inquiry Auto-Categorization & SLA\",\"status\":\"SUCCESS\",\"score\":0.98,\"summary\":\"Processed support queue. Auto-tagged inquiries into Shipping, Sizing, and Refunds with draft replies ready.\"}]}', 'system', 0, NULL, NULL, NULL, '127.0.0.1', NULL, '2026-08-19 16:46:42'),
(18, NULL, '', 0, 'FULL_SWARM_CYCLE_EXECUTED', '{\"cycle_id\":\"CYC-21E9BB4E\",\"timestamp\":\"2026-08-19 13:17:11\",\"consensus_score\":\"100.0%\",\"agents_executed\":7,\"total_actions\":24,\"telemetry\":[{\"agent\":\"DynamicPricingAgent\",\"task\":\"Real-Time Margin Guard & Elasticity Rebalance\",\"status\":\"SUCCESS\",\"score\":1,\"summary\":\"Audited 22 catalog SKUs. Enforced 40% Margin Guard floor with atomic DB transactions.\"},{\"agent\":\"DataMoatScoringJob\",\"task\":\"First-Party Conversion & RTO Feedback Moat\",\"status\":\"SUCCESS\",\"score\":0.99,\"summary\":\"Synchronized first-party CVR, CTR, and RTO return rates back into product_performance_metrics and winning score algorithms.\"},{\"agent\":\"FinanceReconciliationJob\",\"task\":\"Gateway Settlement & Revenue Leak Audit\",\"status\":\"SUCCESS\",\"score\":0.99,\"summary\":\"Audited all active payment authorizations against orders.total and refunds to ensure 0 silent revenue leaks.\"},{\"agent\":\"AbandonedCartJob\",\"task\":\"Multi-Stage Omnichannel Recovery\",\"status\":\"SUCCESS\",\"score\":0.98,\"summary\":\"Executed staged recovery sequence (SAVE10 \\/ FREESHIP \\/ RECOVER15) across active abandoned sessions.\"},{\"agent\":\"SubscriptionBillingJob\",\"task\":\"Subscribe & Save Recurring Replenishment\",\"status\":\"SUCCESS\",\"score\":1,\"summary\":\"Scanned active replenishment subscriptions and dispatched recurring orders.\"},{\"agent\":\"DailyDigestJob\",\"task\":\"Executive P&L Intelligence Rollup\",\"status\":\"SUCCESS\",\"score\":1,\"summary\":\"Aggregated gross GMV, AOV, top-selling SKUs, and inventory stockout risk metrics.\"},{\"agent\":\"Swarm Coordinator\",\"task\":\"Master Autonomous Mesh Synchronization\",\"status\":\"SUCCESS\",\"score\":1,\"summary\":\"All 24 autonomous engines synchronized and logged to automation_runs table.\"}]}', 'system', 0, NULL, NULL, NULL, '127.0.0.1', NULL, '2026-08-19 16:47:11'),
(19, NULL, '', 0, 'FULL_SWARM_CYCLE_EXECUTED', '{\"cycle_id\":\"CYC-7BF6C89C\",\"timestamp\":\"2026-08-19 15:21:48\",\"consensus_score\":\"100.0%\",\"agents_executed\":7,\"total_actions\":24,\"telemetry\":[{\"agent\":\"DynamicPricingAgent\",\"task\":\"Real-Time Margin Guard & Elasticity Rebalance\",\"status\":\"SUCCESS\",\"score\":1,\"summary\":\"Audited 22 catalog SKUs. Enforced 40% Margin Guard floor with atomic DB transactions.\"},{\"agent\":\"DataMoatScoringJob\",\"task\":\"First-Party Conversion & RTO Feedback Moat\",\"status\":\"SUCCESS\",\"score\":0.99,\"summary\":\"Synchronized first-party CVR, CTR, and RTO return rates back into product_performance_metrics and winning score algorithms.\"},{\"agent\":\"FinanceReconciliationJob\",\"task\":\"Gateway Settlement & Revenue Leak Audit\",\"status\":\"SUCCESS\",\"score\":0.99,\"summary\":\"Audited all active payment authorizations against orders.total and refunds to ensure 0 silent revenue leaks.\"},{\"agent\":\"AbandonedCartJob\",\"task\":\"Multi-Stage Omnichannel Recovery\",\"status\":\"SUCCESS\",\"score\":0.98,\"summary\":\"Executed staged recovery sequence (SAVE10 \\/ FREESHIP \\/ RECOVER15) across active abandoned sessions.\"},{\"agent\":\"SubscriptionBillingJob\",\"task\":\"Subscribe & Save Recurring Replenishment\",\"status\":\"SUCCESS\",\"score\":1,\"summary\":\"Scanned active replenishment subscriptions and dispatched recurring orders.\"},{\"agent\":\"DailyDigestJob\",\"task\":\"Executive P&L Intelligence Rollup\",\"status\":\"SUCCESS\",\"score\":1,\"summary\":\"Aggregated gross GMV, AOV, top-selling SKUs, and inventory stockout risk metrics.\"},{\"agent\":\"Swarm Coordinator\",\"task\":\"Master Autonomous Mesh Synchronization\",\"status\":\"SUCCESS\",\"score\":1,\"summary\":\"All 24 autonomous engines synchronized and logged to automation_runs table.\"}]}', 'system', 0, NULL, NULL, NULL, '127.0.0.1', NULL, '2026-08-19 18:51:48'),
(20, NULL, '', 0, 'FULL_SWARM_CYCLE_EXECUTED', '{\"cycle_id\":\"CYC-C4E884D5\",\"timestamp\":\"2026-08-19 15:22:32\",\"consensus_score\":\"100.0%\",\"agents_executed\":7,\"total_actions\":24,\"telemetry\":[{\"agent\":\"DynamicPricingAgent\",\"task\":\"Real-Time Margin Guard & Elasticity Rebalance\",\"status\":\"SUCCESS\",\"score\":1,\"summary\":\"Audited 22 catalog SKUs. Enforced 40% Margin Guard floor with atomic DB transactions.\"},{\"agent\":\"DataMoatScoringJob\",\"task\":\"First-Party Conversion & RTO Feedback Moat\",\"status\":\"SUCCESS\",\"score\":0.99,\"summary\":\"Synchronized first-party CVR, CTR, and RTO return rates back into product_performance_metrics and winning score algorithms.\"},{\"agent\":\"FinanceReconciliationJob\",\"task\":\"Gateway Settlement & Revenue Leak Audit\",\"status\":\"SUCCESS\",\"score\":0.99,\"summary\":\"Audited all active payment authorizations against orders.total and refunds to ensure 0 silent revenue leaks.\"},{\"agent\":\"AbandonedCartJob\",\"task\":\"Multi-Stage Omnichannel Recovery\",\"status\":\"SUCCESS\",\"score\":0.98,\"summary\":\"Executed staged recovery sequence (SAVE10 \\/ FREESHIP \\/ RECOVER15) across active abandoned sessions.\"},{\"agent\":\"SubscriptionBillingJob\",\"task\":\"Subscribe & Save Recurring Replenishment\",\"status\":\"SUCCESS\",\"score\":1,\"summary\":\"Scanned active replenishment subscriptions and dispatched recurring orders.\"},{\"agent\":\"DailyDigestJob\",\"task\":\"Executive P&L Intelligence Rollup\",\"status\":\"SUCCESS\",\"score\":1,\"summary\":\"Aggregated gross GMV, AOV, top-selling SKUs, and inventory stockout risk metrics.\"},{\"agent\":\"Swarm Coordinator\",\"task\":\"Master Autonomous Mesh Synchronization\",\"status\":\"SUCCESS\",\"score\":1,\"summary\":\"All 24 autonomous engines synchronized and logged to automation_runs table.\"}]}', 'system', 0, NULL, NULL, NULL, '127.0.0.1', NULL, '2026-08-19 18:52:32'),
(21, NULL, '', 0, 'FULL_SWARM_CYCLE_EXECUTED', '{\"cycle_id\":\"CYC-93293C5F\",\"timestamp\":\"2026-08-19 15:22:50\",\"consensus_score\":\"100.0%\",\"agents_executed\":7,\"total_actions\":24,\"telemetry\":[{\"agent\":\"DynamicPricingAgent\",\"task\":\"Real-Time Margin Guard & Elasticity Rebalance\",\"status\":\"SUCCESS\",\"score\":1,\"summary\":\"Audited 22 catalog SKUs. Enforced 40% Margin Guard floor with atomic DB transactions.\"},{\"agent\":\"DataMoatScoringJob\",\"task\":\"First-Party Conversion & RTO Feedback Moat\",\"status\":\"SUCCESS\",\"score\":0.99,\"summary\":\"Synchronized first-party CVR, CTR, and RTO return rates back into product_performance_metrics and winning score algorithms.\"},{\"agent\":\"FinanceReconciliationJob\",\"task\":\"Gateway Settlement & Revenue Leak Audit\",\"status\":\"SUCCESS\",\"score\":0.99,\"summary\":\"Audited all active payment authorizations against orders.total and refunds to ensure 0 silent revenue leaks.\"},{\"agent\":\"AbandonedCartJob\",\"task\":\"Multi-Stage Omnichannel Recovery\",\"status\":\"SUCCESS\",\"score\":0.98,\"summary\":\"Executed staged recovery sequence (SAVE10 \\/ FREESHIP \\/ RECOVER15) across active abandoned sessions.\"},{\"agent\":\"SubscriptionBillingJob\",\"task\":\"Subscribe & Save Recurring Replenishment\",\"status\":\"SUCCESS\",\"score\":1,\"summary\":\"Scanned active replenishment subscriptions and dispatched recurring orders.\"},{\"agent\":\"DailyDigestJob\",\"task\":\"Executive P&L Intelligence Rollup\",\"status\":\"SUCCESS\",\"score\":1,\"summary\":\"Aggregated gross GMV, AOV, top-selling SKUs, and inventory stockout risk metrics.\"},{\"agent\":\"Swarm Coordinator\",\"task\":\"Master Autonomous Mesh Synchronization\",\"status\":\"SUCCESS\",\"score\":1,\"summary\":\"All 24 autonomous engines synchronized and logged to automation_runs table.\"}]}', 'system', 0, NULL, NULL, NULL, '127.0.0.1', NULL, '2026-08-19 18:52:50'),
(22, NULL, '', 0, 'FULL_SWARM_CYCLE_EXECUTED', '{\"cycle_id\":\"CYC-D43DF612\",\"timestamp\":\"2026-08-19 15:23:06\",\"consensus_score\":\"100.0%\",\"agents_executed\":7,\"total_actions\":24,\"telemetry\":[{\"agent\":\"DynamicPricingAgent\",\"task\":\"Real-Time Margin Guard & Elasticity Rebalance\",\"status\":\"SUCCESS\",\"score\":1,\"summary\":\"Audited 22 catalog SKUs. Enforced 40% Margin Guard floor with atomic DB transactions.\"},{\"agent\":\"DataMoatScoringJob\",\"task\":\"First-Party Conversion & RTO Feedback Moat\",\"status\":\"SUCCESS\",\"score\":0.99,\"summary\":\"Synchronized first-party CVR, CTR, and RTO return rates back into product_performance_metrics and winning score algorithms.\"},{\"agent\":\"FinanceReconciliationJob\",\"task\":\"Gateway Settlement & Revenue Leak Audit\",\"status\":\"SUCCESS\",\"score\":0.99,\"summary\":\"Audited all active payment authorizations against orders.total and refunds to ensure 0 silent revenue leaks.\"},{\"agent\":\"AbandonedCartJob\",\"task\":\"Multi-Stage Omnichannel Recovery\",\"status\":\"SUCCESS\",\"score\":0.98,\"summary\":\"Executed staged recovery sequence (SAVE10 \\/ FREESHIP \\/ RECOVER15) across active abandoned sessions.\"},{\"agent\":\"SubscriptionBillingJob\",\"task\":\"Subscribe & Save Recurring Replenishment\",\"status\":\"SUCCESS\",\"score\":1,\"summary\":\"Scanned active replenishment subscriptions and dispatched recurring orders.\"},{\"agent\":\"DailyDigestJob\",\"task\":\"Executive P&L Intelligence Rollup\",\"status\":\"SUCCESS\",\"score\":1,\"summary\":\"Aggregated gross GMV, AOV, top-selling SKUs, and inventory stockout risk metrics.\"},{\"agent\":\"Swarm Coordinator\",\"task\":\"Master Autonomous Mesh Synchronization\",\"status\":\"SUCCESS\",\"score\":1,\"summary\":\"All 24 autonomous engines synchronized and logged to automation_runs table.\"}]}', 'system', 0, NULL, NULL, NULL, '127.0.0.1', NULL, '2026-08-19 18:53:06'),
(23, NULL, '', 0, 'FULL_SWARM_CYCLE_EXECUTED', '{\"cycle_id\":\"SWARM-1572BD28\",\"timestamp\":\"2026-08-25 18:28:38\",\"consensus_score\":\"100.0%\",\"agents_executed\":12,\"total_actions\":28,\"telemetry\":[{\"agent\":\"DynamicPricingAgent\",\"task\":\"Real-Time Margin Guard & Elasticity Rebalance\",\"status\":\"SUCCESS\",\"score\":1,\"summary\":\"Audited 10 catalog SKUs. Enforced 40% Margin Guard floor with atomic DB transactions.\"},{\"agent\":\"DataMoatScoringJob\",\"task\":\"First-Party Conversion & RTO Feedback Moat\",\"status\":\"SUCCESS\",\"score\":0.99,\"summary\":\"Synchronized first-party CVR, CTR, and RTO return rates back into product_performance_metrics and winning score algorithms.\"},{\"agent\":\"FinanceReconciliationJob\",\"task\":\"Gateway Settlement & Revenue Leak Audit\",\"status\":\"SUCCESS\",\"score\":1,\"summary\":\"Audited all active payment authorizations against orders.total to ensure 0 silent revenue leaks.\"},{\"agent\":\"AbandonedCartJob\",\"task\":\"Multi-Stage Omnichannel Recovery Sequence\",\"status\":\"SUCCESS\",\"score\":0.98,\"summary\":\"Executed staged recovery sequence (SAVE10 \\/ FREESHIP \\/ RECOVER15) across active abandoned sessions.\"},{\"agent\":\"VendorOrderRoutingJob\",\"task\":\"Multi-Vendor Commission Split & Ledger\",\"status\":\"SUCCESS\",\"score\":1,\"summary\":\"Routed new customer order line items to registered vendor portals with automated commission calculation.\"},{\"agent\":\"RetentionWinbackJob\",\"task\":\"RFM Segmentation & Dormant User Reactivation\",\"status\":\"SUCCESS\",\"score\":0.97,\"summary\":\"Scanned inactive buyers (>45 days) and scheduled automated 20% win-back incentive vouchers.\"},{\"agent\":\"SubscriptionBillingJob\",\"task\":\"Subscribe & Save Replenishment Dispatcher\",\"status\":\"SUCCESS\",\"score\":1,\"summary\":\"Scanned active replenishment subscriptions and generated automated renewal orders.\"},{\"agent\":\"ListingWriterJob\",\"task\":\"AI Product Listing & Luxury Provenance Copy\",\"status\":\"SUCCESS\",\"score\":0.99,\"summary\":\"Generated sensory bullet points, fabric specifications, and bespoke storytelling across catalog items.\"},{\"agent\":\"SeoContentGeneratorJob\",\"task\":\"Schema.org JSON-LD & Meta Tag Ingestor\",\"status\":\"SUCCESS\",\"score\":1,\"summary\":\"Injected Product, AggregateRating, Offers, and FAQPage microdata into database for Google Rich Snippets.\"},{\"agent\":\"SearchSyncJob\",\"task\":\"Fulltext Vector & Autocomplete Search Index\",\"status\":\"SUCCESS\",\"score\":1,\"summary\":\"Rebuilt internal product search vectors, keyword tokens, and typo-tolerant index.\"},{\"agent\":\"DailyDigestJob\",\"task\":\"Executive P&L Intelligence & Stockout Rollup\",\"status\":\"SUCCESS\",\"score\":1,\"summary\":\"Aggregated gross GMV, AOV, top-performing capsules, and inventory stockout risk metrics.\"},{\"agent\":\"Swarm Coordinator\",\"task\":\"Master Autonomous Mesh Synchronization\",\"status\":\"SUCCESS\",\"score\":1,\"summary\":\"All 28 autonomous engines synchronized and logged to automation_runs table.\"}]}', 'system', 0, NULL, NULL, NULL, '127.0.0.1', NULL, '2026-08-25 21:58:38'),
(24, NULL, '', 0, 'FULL_SWARM_CYCLE_EXECUTED', '{\"cycle_id\":\"SWARM-71AE4BE9\",\"timestamp\":\"2026-08-25 18:39:06\",\"consensus_score\":\"100.0%\",\"agents_executed\":12,\"total_actions\":28,\"telemetry\":[{\"agent\":\"DynamicPricingAgent\",\"task\":\"Real-Time Margin Guard & Elasticity Rebalance\",\"status\":\"SUCCESS\",\"score\":1,\"summary\":\"Audited 10 catalog SKUs. Enforced 40% Margin Guard floor with atomic DB transactions.\"},{\"agent\":\"DataMoatScoringJob\",\"task\":\"First-Party Conversion & RTO Feedback Moat\",\"status\":\"SUCCESS\",\"score\":0.99,\"summary\":\"Synchronized first-party CVR, CTR, and RTO return rates back into product_performance_metrics and winning score algorithms.\"},{\"agent\":\"FinanceReconciliationJob\",\"task\":\"Gateway Settlement & Revenue Leak Audit\",\"status\":\"SUCCESS\",\"score\":1,\"summary\":\"Audited all active payment authorizations against orders.total to ensure 0 silent revenue leaks.\"},{\"agent\":\"AbandonedCartJob\",\"task\":\"Multi-Stage Omnichannel Recovery Sequence\",\"status\":\"SUCCESS\",\"score\":0.98,\"summary\":\"Executed staged recovery sequence (SAVE10 \\/ FREESHIP \\/ RECOVER15) across active abandoned sessions.\"},{\"agent\":\"VendorOrderRoutingJob\",\"task\":\"Multi-Vendor Commission Split & Ledger\",\"status\":\"SUCCESS\",\"score\":1,\"summary\":\"Routed new customer order line items to registered vendor portals with automated commission calculation.\"},{\"agent\":\"RetentionWinbackJob\",\"task\":\"RFM Segmentation & Dormant User Reactivation\",\"status\":\"SUCCESS\",\"score\":0.97,\"summary\":\"Scanned inactive buyers (>45 days) and scheduled automated 20% win-back incentive vouchers.\"},{\"agent\":\"SubscriptionBillingJob\",\"task\":\"Subscribe & Save Replenishment Dispatcher\",\"status\":\"SUCCESS\",\"score\":1,\"summary\":\"Scanned active replenishment subscriptions and generated automated renewal orders.\"},{\"agent\":\"ListingWriterJob\",\"task\":\"AI Product Listing & Luxury Provenance Copy\",\"status\":\"SUCCESS\",\"score\":0.99,\"summary\":\"Generated sensory bullet points, fabric specifications, and bespoke storytelling across catalog items.\"},{\"agent\":\"SeoContentGeneratorJob\",\"task\":\"Schema.org JSON-LD & Meta Tag Ingestor\",\"status\":\"SUCCESS\",\"score\":1,\"summary\":\"Injected Product, AggregateRating, Offers, and FAQPage microdata into database for Google Rich Snippets.\"},{\"agent\":\"SearchSyncJob\",\"task\":\"Fulltext Vector & Autocomplete Search Index\",\"status\":\"SUCCESS\",\"score\":1,\"summary\":\"Rebuilt internal product search vectors, keyword tokens, and typo-tolerant index.\"},{\"agent\":\"DailyDigestJob\",\"task\":\"Executive P&L Intelligence & Stockout Rollup\",\"status\":\"SUCCESS\",\"score\":1,\"summary\":\"Aggregated gross GMV, AOV, top-performing capsules, and inventory stockout risk metrics.\"},{\"agent\":\"Swarm Coordinator\",\"task\":\"Master Autonomous Mesh Synchronization\",\"status\":\"SUCCESS\",\"score\":1,\"summary\":\"All 28 autonomous engines synchronized and logged to automation_runs table.\"}]}', 'system', 0, NULL, NULL, NULL, '127.0.0.1', NULL, '2026-08-25 22:09:07');

-- --------------------------------------------------------

--
-- Table structure for table `automation_runs`
--

CREATE TABLE `automation_runs` (
  `id` bigint(20) NOT NULL,
  `store_id` int(11) DEFAULT 1,
  `job_name` varchar(120) NOT NULL,
  `status` enum('running','success','failed') NOT NULL DEFAULT 'running',
  `started_at` datetime NOT NULL DEFAULT current_timestamp(),
  `finished_at` datetime DEFAULT NULL,
  `duration_ms` decimal(10,2) DEFAULT 0.00,
  `affected_rows` int(11) DEFAULT 0,
  `payload_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`payload_json`)),
  `error_message` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `automation_runs`
--

INSERT INTO `automation_runs` (`id`, `store_id`, `job_name`, `status`, `started_at`, `finished_at`, `duration_ms`, `affected_rows`, `payload_json`, `error_message`, `created_at`) VALUES
(1, 1, 'send_email', 'success', '2026-08-19 16:41:50', '2026-08-19 16:41:52', 2456.16, 1, '{\"job\":\"send_email\",\"order_id\":3,\"template\":\"order_shipped\",\"tracking\":\"CJIND1140648BD\",\"carrier\":\"BlueDart \\/ Delhivery Surface\",\"tracking_url\":\"https:\\/\\/track.cjdropshipping.com\\/tracking?num=CJIND\"}', NULL, '2026-08-19 16:41:52'),
(2, 1, 'send_email', 'success', '2026-08-19 16:41:50', '2026-08-19 16:41:52', 1.25, 1, '{\"job\":\"send_email\",\"to\":\"noreply@novadrop.in\",\"name\":\"Store Administrator\",\"subject\":\"\\ud83d\\udcc8 NovaDrop Daily Performance Digest \\u2014 19 Aug 2026\",\"template\":\"daily_digest\",\"summary\":\"\\ud83d\\udcca NovaDrop Daily Executive Digest [19 Aug 2026]:\\n\\u2022 Gross GMV: \\u20b94,998.00 across 2 orders (AOV: \\u20b92,499.00)\\n\\u2022 Estimated Net Profit: \\u20b93,130.75 (Margin ~62.6%)\\n\\u2022 Top Products: 1. UltraFast Magnetic Qi2 Wireless Powerbank (1 units \\u00b7 \\u20b92,499.00) \\n\\u2022 Critical Low-Stock SKUs: 0 items\\n\\u2022 Failed Payment Alerts: 0\"}', NULL, '2026-08-19 16:41:52'),
(3, 1, 'finance_reconciliation', 'success', '2026-08-19 16:41:50', '2026-08-19 16:41:52', 5.63, 1, '{\"job\":\"finance_reconciliation\"}', NULL, '2026-08-19 16:41:52'),
(4, 1, 'daily_digest', 'success', '2026-08-19 16:41:50', '2026-08-19 16:41:52', 6.78, 1, '{\"job\":\"daily_digest\"}', NULL, '2026-08-19 16:41:52'),
(5, 1, 'send_email', 'success', '2026-08-19 16:41:50', '2026-08-19 16:41:52', 1.21, 1, '{\"job\":\"send_email\",\"to\":\"noreply@novadrop.in\",\"name\":\"Store Administrator\",\"subject\":\"\\ud83d\\udcc8 NovaDrop Daily Performance Digest \\u2014 19 Aug 2026\",\"template\":\"daily_digest\",\"summary\":\"\\ud83d\\udcca NovaDrop Daily Executive Digest [19 Aug 2026]:\\n\\u2022 Gross GMV: \\u20b917,498.00 across 3 orders (AOV: \\u20b95,832.67)\\n\\u2022 Estimated Net Profit: \\u20b910,960.75 (Margin ~62.6%)\\n\\u2022 Top Products: 1. UltraFast Magnetic Qi2 Wireless Powerbank (1 units \\u00b7 \\u20b92,499.00) \\n\\u2022 Critical Low-Stock SKUs: 0 items\\n\\u2022 Failed Payment Alerts: 0\"}', NULL, '2026-08-19 16:41:52'),
(6, 1, 'send_email', 'success', '2026-08-19 16:41:50', '2026-08-19 16:41:52', 1.45, 1, '{\"job\":\"send_email\",\"to\":\"customer@example.com\",\"name\":\"Valued Customer\",\"subject\":\"\\ud83d\\udc4b Valued Customer, you left something in your NovaDrop cart!\",\"template\":\"cart_recovery\",\"promo_code\":\"SAVE10\",\"discount\":\"10% OFF\",\"recovery_url\":\"http:\\/\\/localhost\\/Dropshipping\\/cart?recover=test-cart-6a858f5c388c0&code=SAVE10\"}', NULL, '2026-08-19 16:41:52'),
(7, 1, 'send_email', 'success', '2026-08-19 16:41:50', '2026-08-19 16:41:52', 1.20, 1, '{\"job\":\"send_email\",\"to\":\"noreply@novadrop.in\",\"name\":\"Store Administrator\",\"subject\":\"\\ud83d\\udcc8 NovaDrop Daily Performance Digest \\u2014 19 Aug 2026\",\"template\":\"daily_digest\",\"summary\":\"\\ud83d\\udcca NovaDrop Daily Executive Digest [19 Aug 2026]:\\n\\u2022 Gross GMV: \\u20b917,498.00 across 3 orders (AOV: \\u20b95,832.67)\\n\\u2022 Estimated Net Profit: \\u20b910,960.75 (Margin ~62.6%)\\n\\u2022 Top Products: 1. UltraFast Magnetic Qi2 Wireless Powerbank (1 units \\u00b7 \\u20b92,499.00) \\n\\u2022 Critical Low-Stock SKUs: 0 items\\n\\u2022 Failed Payment Alerts: 0\"}', NULL, '2026-08-19 16:41:52'),
(8, 1, 'finance_reconciliation', 'success', '2026-08-19 16:41:50', '2026-08-19 16:41:52', 3.14, 1, '{\"job\":\"finance_reconciliation\"}', NULL, '2026-08-19 16:41:52'),
(9, 1, 'daily_digest', 'success', '2026-08-19 16:41:50', '2026-08-19 16:41:52', 4.89, 1, '{\"job\":\"daily_digest\"}', NULL, '2026-08-19 16:41:52'),
(10, 1, 'send_email', 'success', '2026-08-19 16:41:50', '2026-08-19 16:41:52', 1.16, 1, '{\"job\":\"send_email\",\"to\":\"customer@example.com\",\"name\":\"Valued Customer\",\"subject\":\"\\ud83d\\udc4b Valued Customer, you left something in your NovaDrop cart!\",\"template\":\"cart_recovery\",\"promo_code\":\"SAVE10\",\"discount\":\"10% OFF\",\"recovery_url\":\"http:\\/\\/localhost\\/Dropshipping\\/cart?recover=test-cart-6a858f7630725&code=SAVE10\"}', NULL, '2026-08-19 16:41:52'),
(11, 1, 'send_email', 'success', '2026-08-19 16:45:06', '2026-08-19 16:45:06', 1.34, 1, '{\"job\":\"send_email\",\"to\":\"noreply@novadrop.in\",\"name\":\"Store Administrator\",\"subject\":\"\\ud83d\\udcc8 NovaDrop Daily Performance Digest \\u2014 19 Aug 2026\",\"template\":\"daily_digest\",\"summary\":\"\\ud83d\\udcca NovaDrop Daily Executive Digest [19 Aug 2026]:\\n\\u2022 Gross GMV: \\u20b929,998.00 across 4 orders (AOV: \\u20b97,499.50)\\n\\u2022 Estimated Net Profit: \\u20b918,790.75 (Margin ~62.6%)\\n\\u2022 Top Products: 1. UltraFast Magnetic Qi2 Wireless Powerbank (1 units \\u00b7 \\u20b92,499.00) \\n\\u2022 Critical Low-Stock SKUs: 0 items\\n\\u2022 Failed Payment Alerts: 0\"}', NULL, '2026-08-19 16:45:06'),
(12, 1, 'finance_reconciliation', 'success', '2026-08-19 16:45:06', '2026-08-19 16:45:06', 4.83, 1, '{\"job\":\"finance_reconciliation\"}', NULL, '2026-08-19 16:45:06'),
(13, 1, 'daily_digest', 'success', '2026-08-19 16:45:06', '2026-08-19 16:45:06', 10.28, 1, '{\"job\":\"daily_digest\"}', NULL, '2026-08-19 16:45:06'),
(14, 1, 'send_email', 'success', '2026-08-19 16:45:06', '2026-08-19 16:45:06', 4.65, 1, '{\"job\":\"send_email\",\"to\":\"noreply@novadrop.in\",\"name\":\"Store Administrator\",\"subject\":\"\\ud83d\\udcc8 NovaDrop Daily Performance Digest \\u2014 19 Aug 2026\",\"template\":\"daily_digest\",\"summary\":\"\\ud83d\\udcca NovaDrop Daily Executive Digest [19 Aug 2026]:\\n\\u2022 Gross GMV: \\u20b942,498.00 across 5 orders (AOV: \\u20b98,499.60)\\n\\u2022 Estimated Net Profit: \\u20b926,620.75 (Margin ~62.6%)\\n\\u2022 Top Products: 1. UltraFast Magnetic Qi2 Wireless Powerbank (1 units \\u00b7 \\u20b92,499.00) \\n\\u2022 Critical Low-Stock SKUs: 0 items\\n\\u2022 Failed Payment Alerts: 0\"}', NULL, '2026-08-19 16:45:06'),
(15, 1, 'send_email', 'success', '2026-08-19 16:45:06', '2026-08-19 16:45:06', 1.55, 1, '{\"job\":\"send_email\",\"to\":\"noreply@novadrop.in\",\"name\":\"Store Administrator\",\"subject\":\"\\ud83d\\udcc8 NovaDrop Daily Performance Digest \\u2014 19 Aug 2026\",\"template\":\"daily_digest\",\"summary\":\"\\ud83d\\udcca NovaDrop Daily Executive Digest [19 Aug 2026]:\\n\\u2022 Gross GMV: \\u20b942,498.00 across 5 orders (AOV: \\u20b98,499.60)\\n\\u2022 Estimated Net Profit: \\u20b926,620.75 (Margin ~62.6%)\\n\\u2022 Top Products: 1. UltraFast Magnetic Qi2 Wireless Powerbank (1 units \\u00b7 \\u20b92,499.00) \\n\\u2022 Critical Low-Stock SKUs: 0 items\\n\\u2022 Failed Payment Alerts: 0\"}', NULL, '2026-08-19 16:45:06'),
(16, 1, 'push_order_to_supplier', 'success', '2026-08-19 16:45:06', '2026-08-19 16:45:06', 18.71, 1, '{\"job\":\"push_order_to_supplier\",\"order_id\":8}', NULL, '2026-08-19 16:45:06'),
(17, 1, 'send_email', 'success', '2026-08-19 16:45:06', '2026-08-19 16:45:06', 1.17, 1, '{\"job\":\"send_email\",\"to\":\"atelier.collector.a07b@gmail.com\",\"name\":\"Atelier Google Collector\",\"subject\":\"\\ud83d\\udd04 Your Subscription Order #SUB-REC-13887 is Confirmed! \\u2014 NovaDrop\",\"template\":\"subscription_renewed\"}', NULL, '2026-08-19 16:45:06'),
(18, 1, 'push_order_to_supplier', 'success', '2026-08-19 16:45:06', '2026-08-19 16:45:06', 2.35, 1, '{\"job\":\"push_order_to_supplier\",\"order_id\":9}', NULL, '2026-08-19 16:45:06'),
(19, 1, 'seo_content', 'success', '2026-08-19 16:45:06', '2026-08-19 16:45:06', 11.10, 1, '{\"job\":\"seo_content\"}', NULL, '2026-08-19 16:45:06'),
(20, 1, 'data_moat_scoring', 'success', '2026-08-19 16:45:06', '2026-08-19 16:45:07', 19.71, 1, '{\"job\":\"data_moat_scoring\"}', NULL, '2026-08-19 16:45:07'),
(21, 1, 'send_email', 'success', '2026-08-19 17:11:56', '2026-08-19 17:11:56', 3.92, 1, '{\"job\":\"send_email\",\"to\":\"noreply@novadrop.in\",\"name\":\"Store Administrator\",\"subject\":\"\\ud83d\\udcc8 NovaDrop Daily Performance Digest \\u2014 19 Aug 2026\",\"template\":\"daily_digest\",\"summary\":\"\\ud83d\\udcca NovaDrop Daily Executive Digest [19 Aug 2026]:\\n\\u2022 Gross GMV: \\u20b944,197.00 across 6 orders (AOV: \\u20b97,366.17)\\n\\u2022 Estimated Net Profit: \\u20b927,685.00 (Margin ~62.6%)\\n\\u2022 Top Products: 1. AeroWave Pro Active Noise Cancelling Headphones [Subscribe & Save Replenishment] (1 units \\u00b7 \\u20b91,699.00) 2. UltraFast Magnetic Qi2 Wireless Powerbank (1 units \\u00b7 \\u20b92,499.00) \\n\\u2022 Critical Low-Stock SKUs: 0 items\\n\\u2022 Failed Payment Alerts: 0\"}', NULL, '2026-08-19 17:11:56'),
(22, 1, 'send_email', 'success', '2026-08-19 17:11:56', '2026-08-19 17:11:58', 1439.23, 1, '{\"job\":\"send_email\",\"order_id\":8,\"template\":\"order_shipped\",\"tracking\":\"CJINDB2A6DA7FF\",\"carrier\":\"BlueDart \\/ Delhivery Surface\",\"tracking_url\":\"https:\\/\\/track.cjdropshipping.com\\/tracking?num=CJIND\"}', NULL, '2026-08-19 17:11:58'),
(23, 1, 'send_email', 'success', '2026-08-19 17:11:56', '2026-08-19 17:11:58', 1.63, 1, '{\"job\":\"send_email\",\"to\":\"noreply@novadrop.in\",\"name\":\"Store Administrator\",\"subject\":\"\\ud83d\\udcc8 NovaDrop Daily Performance Digest \\u2014 19 Aug 2026\",\"template\":\"daily_digest\",\"summary\":\"\\ud83d\\udcca NovaDrop Daily Executive Digest [19 Aug 2026]:\\n\\u2022 Gross GMV: \\u20b944,197.00 across 6 orders (AOV: \\u20b97,366.17)\\n\\u2022 Estimated Net Profit: \\u20b927,685.00 (Margin ~62.6%)\\n\\u2022 Top Products: 1. AeroWave Pro Active Noise Cancelling Headphones [Subscribe & Save Replenishment] (1 units \\u00b7 \\u20b91,699.00) 2. UltraFast Magnetic Qi2 Wireless Powerbank (1 units \\u00b7 \\u20b92,499.00) \\n\\u2022 Critical Low-Stock SKUs: 0 items\\n\\u2022 Failed Payment Alerts: 0\"}', NULL, '2026-08-19 17:11:58'),
(24, 1, 'send_email', 'success', '2026-08-19 17:11:56', '2026-08-19 17:11:58', 1.49, 1, '{\"job\":\"send_email\",\"to\":\"aarav@novatech.in\",\"name\":\"Aarav Mehta\",\"subject\":\"\\ud83d\\udce6 New Order Assigned: ##MV-ORD-11734 \\u2014 NovaTech Innovations\",\"template\":\"vendor_order_notification\",\"order_number\":\"#MV-ORD-11734\",\"items\":\"Wireless Mechanical Ergo Keyboard (x1)\",\"vendor_subtotal\":2000,\"action_url\":\"http:\\/\\/localhost\\/Dropshipping\\/vendor\\/orders\\/view\\/10\"}', NULL, '2026-08-19 17:11:58'),
(25, 1, 'send_email', 'success', '2026-08-19 17:11:56', '2026-08-19 17:11:58', 1.32, 1, '{\"job\":\"send_email\",\"to\":\"priya@ergodesk.in\",\"name\":\"Priya Sen\",\"subject\":\"\\ud83d\\udce6 New Order Assigned: ##MV-ORD-11734 \\u2014 ErgoDesk Direct\",\"template\":\"vendor_order_notification\",\"order_number\":\"#MV-ORD-11734\",\"items\":\"Adjustable Pneumatic Laptop Desk Riser (x1)\",\"vendor_subtotal\":3500,\"action_url\":\"http:\\/\\/localhost\\/Dropshipping\\/vendor\\/orders\\/view\\/10\"}', NULL, '2026-08-19 17:11:58'),
(26, 1, 'send_email', 'success', '2026-08-19 17:11:56', '2026-08-19 17:11:58', 1.52, 1, '{\"job\":\"send_email\",\"to\":\"customer@example.com\",\"subject\":\"\\ud83d\\ude9a Package Dispatched by NovaTech Innovations for Order #MV-ORD-11734\",\"template\":\"vendor_shipment_notice\",\"seller\":\"NovaTech Innovations\",\"carrier\":\"BlueDart\",\"tracking_number\":\"HACK-123\"}', NULL, '2026-08-19 17:11:58'),
(27, 1, 'send_email', 'success', '2026-08-19 17:11:56', '2026-08-19 17:11:58', 1.34, 1, '{\"job\":\"send_email\",\"to\":\"customer@example.com\",\"subject\":\"\\ud83d\\ude9a Package Dispatched by NovaTech Innovations for Order #MV-ORD-11734\",\"template\":\"vendor_shipment_notice\",\"seller\":\"NovaTech Innovations\",\"carrier\":\"BlueDart Express\",\"tracking_number\":\"BD-NOVA-8812\"}', NULL, '2026-08-19 17:11:58'),
(28, 1, 'send_email', 'success', '2026-08-19 17:17:59', '2026-08-19 17:17:59', 2.11, 1, '{\"job\":\"send_email\",\"to\":\"founder_test@startup.io\",\"subject\":\"Welcome to NovaDrop \\u2014 Elevate Your Daily Performance\",\"body_html\":\"<h2>Welcome to NovaDrop, Aman!<\\/h2><p>We craft ergonomic essentials and precision tools for the modern high-performer.<\\/p><p><a href=\'http:\\/\\/localhost\\/Dropshipping\\/shop\' style=\'background:#4338ca;color:#fff;padding:10px 20px;text-decoration:none;border-radius:6px;\'>Explore Collection &rarr;<\\/a><\\/p>\"}', NULL, '2026-08-19 17:17:59'),
(29, 1, 'send_email', 'success', '2026-08-19 17:17:59', '2026-08-19 17:17:59', 1.30, 1, '{\"job\":\"send_email\",\"to\":\"founder_test@startup.io\",\"subject\":\"Here is your exclusive 10% First Order Welcome Gift: WELCOME10\",\"body_html\":\"<h2>Your Welcome Gift Awaits<\\/h2><p>Use code <strong>WELCOME10<\\/strong> at checkout for 10% off your first order.<\\/p><p><a href=\'http:\\/\\/localhost\\/Dropshipping\\/shop?coupon=WELCOME10\'>Claim Your 10% Discount &rarr;<\\/a><\\/p>\"}', NULL, '2026-08-19 17:17:59'),
(30, 1, 'send_email', 'success', '2026-08-19 17:17:59', '2026-08-19 17:17:59', 1.32, 1, '{\"job\":\"send_email\",\"to\":\"founder_test@startup.io\",\"subject\":\"Welcome to NovaDrop \\u2014 Elevate Your Daily Performance\",\"body_html\":\"<h2>Welcome to NovaDrop, Aman!<\\/h2><p>We craft ergonomic essentials and precision tools for the modern high-performer.<\\/p><p><a href=\'http:\\/\\/localhost\\/Dropshipping\\/shop\' style=\'background:#4338ca;color:#fff;padding:10px 20px;text-decoration:none;border-radius:6px;\'>Explore Collection &rarr;<\\/a><\\/p>\"}', NULL, '2026-08-19 17:17:59'),
(31, 1, 'send_email', 'success', '2026-08-19 17:17:59', '2026-08-19 17:17:59', 1.26, 1, '{\"job\":\"send_email\",\"to\":\"founder_test@startup.io\",\"subject\":\"Here is your exclusive 10% First Order Welcome Gift: WELCOME10\",\"body_html\":\"<h2>Your Welcome Gift Awaits<\\/h2><p>Use code <strong>WELCOME10<\\/strong> at checkout for 10% off your first order.<\\/p><p><a href=\'http:\\/\\/localhost\\/Dropshipping\\/shop?coupon=WELCOME10\'>Claim Your 10% Discount &rarr;<\\/a><\\/p>\"}', NULL, '2026-08-19 17:17:59'),
(32, 1, 'send_email', 'success', '2026-08-19 17:17:59', '2026-08-19 17:17:59', 1.43, 1, '{\"job\":\"send_email\",\"to\":\"founder_test@startup.io\",\"subject\":\"Welcome to NovaDrop \\u2014 Elevate Your Daily Performance\",\"body_html\":\"<h2>Welcome to NovaDrop, Aman!<\\/h2><p>We craft ergonomic essentials and precision tools for the modern high-performer.<\\/p><p><a href=\'http:\\/\\/localhost\\/Dropshipping\\/shop\' style=\'background:#4338ca;color:#fff;padding:10px 20px;text-decoration:none;border-radius:6px;\'>Explore Collection &rarr;<\\/a><\\/p>\"}', NULL, '2026-08-19 17:17:59'),
(33, 1, 'send_email', 'success', '2026-08-19 17:17:59', '2026-08-19 17:17:59', 1.11, 1, '{\"job\":\"send_email\",\"to\":\"founder_test@startup.io\",\"subject\":\"Here is your exclusive 10% First Order Welcome Gift: WELCOME10\",\"body_html\":\"<h2>Your Welcome Gift Awaits<\\/h2><p>Use code <strong>WELCOME10<\\/strong> at checkout for 10% off your first order.<\\/p><p><a href=\'http:\\/\\/localhost\\/Dropshipping\\/shop?coupon=WELCOME10\'>Claim Your 10% Discount &rarr;<\\/a><\\/p>\"}', NULL, '2026-08-19 17:17:59'),
(34, 1, 'send_email', 'success', '2026-08-19 17:17:59', '2026-08-19 17:17:59', 1.12, 1, '{\"job\":\"send_email\",\"to\":\"founder_test@startup.io\",\"subject\":\"Welcome to NovaDrop \\u2014 Elevate Your Daily Performance\",\"body_html\":\"<h2>Welcome to NovaDrop, Aman!<\\/h2><p>We craft ergonomic essentials and precision tools for the modern high-performer.<\\/p><p><a href=\'http:\\/\\/localhost\\/Dropshipping\\/shop\' style=\'background:#4338ca;color:#fff;padding:10px 20px;text-decoration:none;border-radius:6px;\'>Explore Collection &rarr;<\\/a><\\/p>\"}', NULL, '2026-08-19 17:17:59'),
(35, 1, 'send_email', 'success', '2026-08-19 17:17:59', '2026-08-19 17:17:59', 1.11, 1, '{\"job\":\"send_email\",\"to\":\"founder_test@startup.io\",\"subject\":\"Here is your exclusive 10% First Order Welcome Gift: WELCOME10\",\"body_html\":\"<h2>Your Welcome Gift Awaits<\\/h2><p>Use code <strong>WELCOME10<\\/strong> at checkout for 10% off your first order.<\\/p><p><a href=\'http:\\/\\/localhost\\/Dropshipping\\/shop?coupon=WELCOME10\'>Claim Your 10% Discount &rarr;<\\/a><\\/p>\"}', NULL, '2026-08-19 17:17:59'),
(36, 1, 'send_email', 'success', '2026-08-19 17:17:59', '2026-08-19 17:17:59', 1.18, 1, '{\"job\":\"send_email\",\"to\":\"founder_test@startup.io\",\"subject\":\"Welcome to NovaDrop \\u2014 Elevate Your Daily Performance\",\"body_html\":\"<h2>Welcome to NovaDrop, Aman!<\\/h2><p>We craft ergonomic essentials and precision tools for the modern high-performer.<\\/p><p><a href=\'http:\\/\\/localhost\\/Dropshipping\\/shop\' style=\'background:#4338ca;color:#fff;padding:10px 20px;text-decoration:none;border-radius:6px;\'>Explore Collection &rarr;<\\/a><\\/p>\"}', NULL, '2026-08-19 17:17:59'),
(37, 1, 'send_email', 'success', '2026-08-19 17:17:59', '2026-08-19 17:17:59', 1.14, 1, '{\"job\":\"send_email\",\"to\":\"founder_test@startup.io\",\"subject\":\"Here is your exclusive 10% First Order Welcome Gift: WELCOME10\",\"body_html\":\"<h2>Your Welcome Gift Awaits<\\/h2><p>Use code <strong>WELCOME10<\\/strong> at checkout for 10% off your first order.<\\/p><p><a href=\'http:\\/\\/localhost\\/Dropshipping\\/shop?coupon=WELCOME10\'>Claim Your 10% Discount &rarr;<\\/a><\\/p>\"}', NULL, '2026-08-19 17:17:59'),
(38, 1, 'send_email', 'success', '2026-08-19 17:48:37', '2026-08-19 17:48:37', 1.52, 1, '{\"job\":\"send_email\",\"to\":\"founder_test@startup.io\",\"subject\":\"\\u26a1 This Week at NovaDrop: New Ergonomic Releases\",\"body_html\":\"<div style=\'font-family:sans-serif;max-width:600px;margin:auto;\'><h1 style=\'color:#4338ca;\'>NovaDrop Weekly Innovation Digest<\\/h1><p>Here is what\'s new and trending this week in our high-performance workspace catalog:<\\/p><ul><li><strong>AeroWave Active Noise Cancelling Studio Earbuds<\\/strong> \\u2014 \\u20b93,099.00 (<a href=\'http:\\/\\/localhost\\/Dropshipping\\/product\\/aerowave-active-noise-cancelling-studio-earbuds-C-02\'>View Details<\\/a>)<\\/li><li><strong>UltraFast Magnetic Qi2 Wireless Powerbank 10000mAh \\u2014 Next-Gen Edition<\\/strong> \\u2014 \\u20b91,899.00 (<a href=\'http:\\/\\/localhost\\/Dropshipping\\/product\\/ultrafast-magnetic-qi2-wireless-powerbank-10000mah-2-01\'>View Details<\\/a>)<\\/li><li><strong>Mulberry Silk Bias-Cut Slip Dress<\\/strong> \\u2014 \\u20b95,699.00 (<a href=\'http:\\/\\/localhost\\/Dropshipping\\/product\\/mulberry-silk-bias-slip-dress\'>View Details<\\/a>)<\\/li><\\/ul><p><a href=\'http:\\/\\/localhost\\/Dropshipping\\/shop\' style=\'background:#4338ca;color:#fff;padding:10px 18px;text-decoration:none;border-radius:6px;\'>Shop All New Arrivals &rarr;<\\/a><\\/p><hr><small style=\'color:#888;\'>You are receiving this because you subscribed to NovaDrop updates. <a href=\'http:\\/\\/localhost\\/Dropshipping\\/unsubscribe\'>Unsubscribe<\\/a><\\/small><\\/div>\"}', NULL, '2026-08-19 17:48:37'),
(39, 1, 'send_email', 'success', '2026-08-19 18:53:10', '2026-08-19 18:53:12', 1600.86, 1, '{\"job\":\"send_email\",\"order_id\":1,\"template\":\"order_shipped\",\"tracking\":\"CJINDB54D34CCD\",\"carrier\":\"BlueDart \\/ Delhivery Surface\",\"tracking_url\":\"https:\\/\\/track.cjdropshipping.com\\/tracking?num=CJIND\"}', NULL, '2026-08-19 18:53:12'),
(40, 1, 'send_email', 'success', '2026-08-19 18:53:10', '2026-08-19 18:53:13', 1446.36, 1, '{\"job\":\"send_email\",\"order_id\":3,\"template\":\"order_shipped\",\"tracking\":\"CJIND1140648BD\",\"carrier\":\"BlueDart \\/ Delhivery Surface\",\"tracking_url\":\"https:\\/\\/track.cjdropshipping.com\\/tracking?num=CJIND\"}', NULL, '2026-08-19 18:53:13'),
(41, 1, 'send_email', 'success', '2026-08-19 18:53:10', '2026-08-19 18:53:14', 1218.04, 1, '{\"job\":\"send_email\",\"order_id\":4,\"template\":\"order_shipped\",\"tracking\":\"CJIND169A230CF\",\"carrier\":\"BlueDart \\/ Delhivery Surface\",\"tracking_url\":\"https:\\/\\/track.cjdropshipping.com\\/tracking?num=CJIND\"}', NULL, '2026-08-19 18:53:14'),
(42, 1, 'send_email', 'success', '2026-08-19 18:53:10', '2026-08-19 18:53:14', 1.85, 1, '{\"job\":\"send_email\",\"to\":\"noreply@novadrop.in\",\"name\":\"Store Administrator\",\"subject\":\"\\ud83d\\udcc8 NovaDrop Daily Performance Digest \\u2014 19 Aug 2026\",\"template\":\"daily_digest\",\"summary\":\"\\ud83d\\udcca NovaDrop Daily Executive Digest [19 Aug 2026]:\\n\\u2022 Gross GMV: \\u20b90.00 across 0 orders (AOV: \\u20b90.00)\\n\\u2022 Estimated Net Profit: \\u20b90.00 (Margin ~62.6%)\\n\\u2022 Top Products: No items sold yet today.\\n\\u2022 Critical Low-Stock SKUs: 0 items\\n\\u2022 Failed Payment Alerts: 0\"}', NULL, '2026-08-19 18:53:14'),
(43, 1, 'send_email', 'success', '2026-08-19 18:53:10', '2026-08-19 18:53:14', 1.54, 1, '{\"job\":\"send_email\",\"to\":\"noreply@novadrop.in\",\"name\":\"Store Administrator\",\"subject\":\"\\ud83d\\udcc8 NovaDrop Daily Performance Digest \\u2014 19 Aug 2026\",\"template\":\"daily_digest\",\"summary\":\"\\ud83d\\udcca NovaDrop Daily Executive Digest [19 Aug 2026]:\\n\\u2022 Gross GMV: \\u20b90.00 across 0 orders (AOV: \\u20b90.00)\\n\\u2022 Estimated Net Profit: \\u20b90.00 (Margin ~62.6%)\\n\\u2022 Top Products: No items sold yet today.\\n\\u2022 Critical Low-Stock SKUs: 0 items\\n\\u2022 Failed Payment Alerts: 0\"}', NULL, '2026-08-19 18:53:14'),
(44, 1, 'send_email', 'success', '2026-08-19 18:53:10', '2026-08-19 18:53:14', 3.75, 1, '{\"job\":\"send_email\",\"to\":\"noreply@novadrop.in\",\"name\":\"Store Administrator\",\"subject\":\"\\ud83d\\udcc8 NovaDrop Daily Performance Digest \\u2014 19 Aug 2026\",\"template\":\"daily_digest\",\"summary\":\"\\ud83d\\udcca NovaDrop Daily Executive Digest [19 Aug 2026]:\\n\\u2022 Gross GMV: \\u20b90.00 across 0 orders (AOV: \\u20b90.00)\\n\\u2022 Estimated Net Profit: \\u20b90.00 (Margin ~62.6%)\\n\\u2022 Top Products: No items sold yet today.\\n\\u2022 Critical Low-Stock SKUs: 0 items\\n\\u2022 Failed Payment Alerts: 0\"}', NULL, '2026-08-19 18:53:14'),
(45, 1, 'send_email', 'success', '2026-08-19 18:53:10', '2026-08-19 18:53:14', 1.45, 1, '{\"job\":\"send_email\",\"to\":\"noreply@novadrop.in\",\"name\":\"Store Administrator\",\"subject\":\"\\ud83d\\udcc8 NovaDrop Daily Performance Digest \\u2014 19 Aug 2026\",\"template\":\"daily_digest\",\"summary\":\"\\ud83d\\udcca NovaDrop Daily Executive Digest [19 Aug 2026]:\\n\\u2022 Gross GMV: \\u20b90.00 across 0 orders (AOV: \\u20b90.00)\\n\\u2022 Estimated Net Profit: \\u20b90.00 (Margin ~62.6%)\\n\\u2022 Top Products: No items sold yet today.\\n\\u2022 Critical Low-Stock SKUs: 0 items\\n\\u2022 Failed Payment Alerts: 0\"}', NULL, '2026-08-19 18:53:14'),
(46, 1, 'vendor_order_routing', 'success', '2026-08-25 21:33:09', '2026-08-25 21:33:09', 24.49, 1, '{\"job\":\"vendor_order_routing\",\"order_id\":5}', NULL, '2026-08-25 21:33:09'),
(47, 1, 'send_email', 'success', '2026-08-25 21:33:09', '2026-08-25 21:33:09', 2.09, 1, '{\"job\":\"send_email\",\"to\":\"kenji@okayama-denim.jp\",\"name\":\"Kenji Takahashi\",\"subject\":\"\\ud83d\\udce6 New Order Assigned: ##01001 \\u2014 Okayama Selvedge Guild\",\"template\":\"vendor_order_notification\",\"order_number\":\"#01001\",\"items\":\"The Atelier Cashmere Cocoon Coat (x1)\",\"vendor_subtotal\":7499,\"action_url\":\"http:\\/\\/localhost\\/Dropshipping\\/vendor\\/orders\\/view\\/5\"}', NULL, '2026-08-25 21:33:09'),
(48, 1, 'vendor_order_routing', 'success', '2026-08-25 21:33:09', '2026-08-25 21:33:09', 8.91, 1, '{\"job\":\"vendor_order_routing\",\"order_id\":6}', NULL, '2026-08-25 21:33:09'),
(49, 1, 'send_email', 'success', '2026-08-25 21:33:09', '2026-08-25 21:33:09', 1.19, 1, '{\"job\":\"send_email\",\"to\":\"kenji@okayama-denim.jp\",\"name\":\"Kenji Takahashi\",\"subject\":\"\\ud83d\\udce6 New Order Assigned: ##02002 \\u2014 Okayama Selvedge Guild\",\"template\":\"vendor_order_notification\",\"order_number\":\"#02002\",\"items\":\"The Atelier Cashmere Cocoon Coat (x1)\",\"vendor_subtotal\":7499,\"action_url\":\"http:\\/\\/localhost\\/Dropshipping\\/vendor\\/orders\\/view\\/6\"}', NULL, '2026-08-25 21:33:09'),
(50, 1, 'vendor_order_routing', 'success', '2026-08-25 21:33:09', '2026-08-25 21:33:09', 9.42, 1, '{\"job\":\"vendor_order_routing\",\"order_id\":7}', NULL, '2026-08-25 21:33:09'),
(51, 1, 'send_email', 'success', '2026-08-25 21:33:09', '2026-08-25 21:33:09', 1.47, 1, '{\"job\":\"send_email\",\"to\":\"kenji@okayama-denim.jp\",\"name\":\"Kenji Takahashi\",\"subject\":\"\\ud83d\\udce6 New Order Assigned: ##03003 \\u2014 Okayama Selvedge Guild\",\"template\":\"vendor_order_notification\",\"order_number\":\"#03003\",\"items\":\"The Atelier Cashmere Cocoon Coat (x1)\",\"vendor_subtotal\":7499,\"action_url\":\"http:\\/\\/localhost\\/Dropshipping\\/vendor\\/orders\\/view\\/7\"}', NULL, '2026-08-25 21:33:09'),
(52, 1, 'retention_winback', 'success', '2026-08-25 21:57:54', '2026-08-25 21:57:54', 0.00, 0, '{\"browse_abandonment\":{\"type\":\"browse_abandonment\",\"dispatched\":0},\"back_in_stock\":{\"type\":\"back_in_stock\",\"dispatched\":0},\"price_drop_alerts\":{\"type\":\"price_drop\",\"dispatched\":0},\"post_delivery_review\":{\"type\":\"post_delivery_reviews\",\"dispatched\":0},\"replenishment\":{\"type\":\"replenishment\",\"dispatched\":0},\"winback_dormant\":{\"type\":\"winback\",\"dispatched\":0},\"failed_payment_retry\":{\"type\":\"failed_payment_retry\",\"dispatched\":0},\"vip_milestones\":{\"type\":\"vip_milestones\",\"dispatched\":0}}', NULL, '2026-08-25 21:57:54'),
(53, 1, 'retention_winback', 'success', '2026-08-25 21:58:10', '2026-08-25 21:58:10', 0.00, 0, '{\"browse_abandonment\":{\"type\":\"browse_abandonment\",\"dispatched\":0},\"back_in_stock\":{\"type\":\"back_in_stock\",\"dispatched\":0},\"price_drop_alerts\":{\"type\":\"price_drop\",\"dispatched\":0},\"post_delivery_review\":{\"type\":\"post_delivery_reviews\",\"dispatched\":0},\"replenishment\":{\"type\":\"replenishment\",\"dispatched\":0},\"winback_dormant\":{\"type\":\"winback\",\"dispatched\":0},\"failed_payment_retry\":{\"type\":\"failed_payment_retry\",\"dispatched\":0},\"vip_milestones\":{\"type\":\"vip_milestones\",\"dispatched\":0}}', NULL, '2026-08-25 21:58:10'),
(54, 1, 'retention_winback', 'success', '2026-08-25 21:58:10', '2026-08-25 21:58:10', 0.00, 0, '{\"browse_abandonment\":{\"type\":\"browse_abandonment\",\"dispatched\":0},\"back_in_stock\":{\"type\":\"back_in_stock\",\"dispatched\":0},\"price_drop_alerts\":{\"type\":\"price_drop\",\"dispatched\":0},\"post_delivery_review\":{\"type\":\"post_delivery_reviews\",\"dispatched\":0},\"replenishment\":{\"type\":\"replenishment\",\"dispatched\":0},\"winback_dormant\":{\"type\":\"winback\",\"dispatched\":0},\"failed_payment_retry\":{\"type\":\"failed_payment_retry\",\"dispatched\":0},\"vip_milestones\":{\"type\":\"vip_milestones\",\"dispatched\":0}}', NULL, '2026-08-25 21:58:10'),
(55, 1, 'retention_winback', 'success', '2026-08-25 21:58:38', '2026-08-25 21:58:38', 0.00, 0, '{\"browse_abandonment\":{\"type\":\"browse_abandonment\",\"dispatched\":0},\"back_in_stock\":{\"type\":\"back_in_stock\",\"dispatched\":0},\"price_drop_alerts\":{\"type\":\"price_drop\",\"dispatched\":0},\"post_delivery_review\":{\"type\":\"post_delivery_reviews\",\"dispatched\":0},\"replenishment\":{\"type\":\"replenishment\",\"dispatched\":0},\"winback_dormant\":{\"type\":\"winback\",\"dispatched\":0},\"failed_payment_retry\":{\"type\":\"failed_payment_retry\",\"dispatched\":0},\"vip_milestones\":{\"type\":\"vip_milestones\",\"dispatched\":0}}', NULL, '2026-08-25 21:58:38'),
(56, 1, 'retention_winback', 'success', '2026-08-25 21:58:38', '2026-08-25 21:58:38', 0.00, 0, '{\"browse_abandonment\":{\"type\":\"browse_abandonment\",\"dispatched\":0},\"back_in_stock\":{\"type\":\"back_in_stock\",\"dispatched\":0},\"price_drop_alerts\":{\"type\":\"price_drop\",\"dispatched\":0},\"post_delivery_review\":{\"type\":\"post_delivery_reviews\",\"dispatched\":0},\"replenishment\":{\"type\":\"replenishment\",\"dispatched\":0},\"winback_dormant\":{\"type\":\"winback\",\"dispatched\":0},\"failed_payment_retry\":{\"type\":\"failed_payment_retry\",\"dispatched\":0},\"vip_milestones\":{\"type\":\"vip_milestones\",\"dispatched\":0}}', NULL, '2026-08-25 21:58:38'),
(57, 1, 'full_ai_swarm_mesh', 'success', '2026-08-25 21:58:38', '2026-08-25 21:58:38', 100.07, 28, '{\"cycle_id\":\"SWARM-1572BD28\",\"timestamp\":\"2026-08-25 18:28:38\",\"consensus_score\":\"100.0%\",\"agents_executed\":12,\"total_actions\":28,\"telemetry\":[{\"agent\":\"DynamicPricingAgent\",\"task\":\"Real-Time Margin Guard & Elasticity Rebalance\",\"status\":\"SUCCESS\",\"score\":1,\"summary\":\"Audited 10 catalog SKUs. Enforced 40% Margin Guard floor with atomic DB transactions.\"},{\"agent\":\"DataMoatScoringJob\",\"task\":\"First-Party Conversion & RTO Feedback Moat\",\"status\":\"SUCCESS\",\"score\":0.99,\"summary\":\"Synchronized first-party CVR, CTR, and RTO return rates back into product_performance_metrics and winning score algorithms.\"},{\"agent\":\"FinanceReconciliationJob\",\"task\":\"Gateway Settlement & Revenue Leak Audit\",\"status\":\"SUCCESS\",\"score\":1,\"summary\":\"Audited all active payment authorizations against orders.total to ensure 0 silent revenue leaks.\"},{\"agent\":\"AbandonedCartJob\",\"task\":\"Multi-Stage Omnichannel Recovery Sequence\",\"status\":\"SUCCESS\",\"score\":0.98,\"summary\":\"Executed staged recovery sequence (SAVE10 \\/ FREESHIP \\/ RECOVER15) across active abandoned sessions.\"},{\"agent\":\"VendorOrderRoutingJob\",\"task\":\"Multi-Vendor Commission Split & Ledger\",\"status\":\"SUCCESS\",\"score\":1,\"summary\":\"Routed new customer order line items to registered vendor portals with automated commission calculation.\"},{\"agent\":\"RetentionWinbackJob\",\"task\":\"RFM Segmentation & Dormant User Reactivation\",\"status\":\"SUCCESS\",\"score\":0.97,\"summary\":\"Scanned inactive buyers (>45 days) and scheduled automated 20% win-back incentive vouchers.\"},{\"agent\":\"SubscriptionBillingJob\",\"task\":\"Subscribe & Save Replenishment Dispatcher\",\"status\":\"SUCCESS\",\"score\":1,\"summary\":\"Scanned active replenishment subscriptions and generated automated renewal orders.\"},{\"agent\":\"ListingWriterJob\",\"task\":\"AI Product Listing & Luxury Provenance Copy\",\"status\":\"SUCCESS\",\"score\":0.99,\"summary\":\"Generated sensory bullet points, fabric specifications, and bespoke storytelling across catalog items.\"},{\"agent\":\"SeoContentGeneratorJob\",\"task\":\"Schema.org JSON-LD & Meta Tag Ingestor\",\"status\":\"SUCCESS\",\"score\":1,\"summary\":\"Injected Product, AggregateRating, Offers, and FAQPage microdata into database for Google Rich Snippets.\"},{\"agent\":\"SearchSyncJob\",\"task\":\"Fulltext Vector & Autocomplete Search Index\",\"status\":\"SUCCESS\",\"score\":1,\"summary\":\"Rebuilt internal product search vectors, keyword tokens, and typo-tolerant index.\"},{\"agent\":\"DailyDigestJob\",\"task\":\"Executive P&L Intelligence & Stockout Rollup\",\"status\":\"SUCCESS\",\"score\":1,\"summary\":\"Aggregated gross GMV, AOV, top-performing capsules, and inventory stockout risk metrics.\"},{\"agent\":\"Swarm Coordinator\",\"task\":\"Master Autonomous Mesh Synchronization\",\"status\":\"SUCCESS\",\"score\":1,\"summary\":\"All 28 autonomous engines synchronized and logged to automation_runs table.\"}]}', NULL, '2026-08-25 21:58:38'),
(58, 1, 'retention_winback', 'success', '2026-08-25 22:09:06', '2026-08-25 22:09:06', 0.00, 0, '{\"browse_abandonment\":{\"type\":\"browse_abandonment\",\"dispatched\":0},\"back_in_stock\":{\"type\":\"back_in_stock\",\"dispatched\":0},\"price_drop_alerts\":{\"type\":\"price_drop\",\"dispatched\":0},\"post_delivery_review\":{\"type\":\"post_delivery_reviews\",\"dispatched\":0},\"replenishment\":{\"type\":\"replenishment\",\"dispatched\":0},\"winback_dormant\":{\"type\":\"winback\",\"dispatched\":0},\"failed_payment_retry\":{\"type\":\"failed_payment_retry\",\"dispatched\":0},\"vip_milestones\":{\"type\":\"vip_milestones\",\"dispatched\":0}}', NULL, '2026-08-25 22:09:06'),
(59, 1, 'full_ai_swarm_mesh', 'success', '2026-08-25 22:09:07', '2026-08-25 22:09:07', 242.47, 28, '{\"cycle_id\":\"SWARM-71AE4BE9\",\"timestamp\":\"2026-08-25 18:39:06\",\"consensus_score\":\"100.0%\",\"agents_executed\":12,\"total_actions\":28,\"telemetry\":[{\"agent\":\"DynamicPricingAgent\",\"task\":\"Real-Time Margin Guard & Elasticity Rebalance\",\"status\":\"SUCCESS\",\"score\":1,\"summary\":\"Audited 10 catalog SKUs. Enforced 40% Margin Guard floor with atomic DB transactions.\"},{\"agent\":\"DataMoatScoringJob\",\"task\":\"First-Party Conversion & RTO Feedback Moat\",\"status\":\"SUCCESS\",\"score\":0.99,\"summary\":\"Synchronized first-party CVR, CTR, and RTO return rates back into product_performance_metrics and winning score algorithms.\"},{\"agent\":\"FinanceReconciliationJob\",\"task\":\"Gateway Settlement & Revenue Leak Audit\",\"status\":\"SUCCESS\",\"score\":1,\"summary\":\"Audited all active payment authorizations against orders.total to ensure 0 silent revenue leaks.\"},{\"agent\":\"AbandonedCartJob\",\"task\":\"Multi-Stage Omnichannel Recovery Sequence\",\"status\":\"SUCCESS\",\"score\":0.98,\"summary\":\"Executed staged recovery sequence (SAVE10 \\/ FREESHIP \\/ RECOVER15) across active abandoned sessions.\"},{\"agent\":\"VendorOrderRoutingJob\",\"task\":\"Multi-Vendor Commission Split & Ledger\",\"status\":\"SUCCESS\",\"score\":1,\"summary\":\"Routed new customer order line items to registered vendor portals with automated commission calculation.\"},{\"agent\":\"RetentionWinbackJob\",\"task\":\"RFM Segmentation & Dormant User Reactivation\",\"status\":\"SUCCESS\",\"score\":0.97,\"summary\":\"Scanned inactive buyers (>45 days) and scheduled automated 20% win-back incentive vouchers.\"},{\"agent\":\"SubscriptionBillingJob\",\"task\":\"Subscribe & Save Replenishment Dispatcher\",\"status\":\"SUCCESS\",\"score\":1,\"summary\":\"Scanned active replenishment subscriptions and generated automated renewal orders.\"},{\"agent\":\"ListingWriterJob\",\"task\":\"AI Product Listing & Luxury Provenance Copy\",\"status\":\"SUCCESS\",\"score\":0.99,\"summary\":\"Generated sensory bullet points, fabric specifications, and bespoke storytelling across catalog items.\"},{\"agent\":\"SeoContentGeneratorJob\",\"task\":\"Schema.org JSON-LD & Meta Tag Ingestor\",\"status\":\"SUCCESS\",\"score\":1,\"summary\":\"Injected Product, AggregateRating, Offers, and FAQPage microdata into database for Google Rich Snippets.\"},{\"agent\":\"SearchSyncJob\",\"task\":\"Fulltext Vector & Autocomplete Search Index\",\"status\":\"SUCCESS\",\"score\":1,\"summary\":\"Rebuilt internal product search vectors, keyword tokens, and typo-tolerant index.\"},{\"agent\":\"DailyDigestJob\",\"task\":\"Executive P&L Intelligence & Stockout Rollup\",\"status\":\"SUCCESS\",\"score\":1,\"summary\":\"Aggregated gross GMV, AOV, top-performing capsules, and inventory stockout risk metrics.\"},{\"agent\":\"Swarm Coordinator\",\"task\":\"Master Autonomous Mesh Synchronization\",\"status\":\"SUCCESS\",\"score\":1,\"summary\":\"All 28 autonomous engines synchronized and logged to automation_runs table.\"}]}', NULL, '2026-08-25 22:09:07'),
(60, 1, 'retention_winback', 'success', '2026-08-26 21:31:04', '2026-08-26 21:31:04', 0.00, 0, '{\"browse_abandonment\":{\"type\":\"browse_abandonment\",\"dispatched\":0},\"back_in_stock\":{\"type\":\"back_in_stock\",\"dispatched\":0},\"price_drop_alerts\":{\"type\":\"price_drop\",\"dispatched\":0},\"post_delivery_review\":{\"type\":\"post_delivery_reviews\",\"dispatched\":0},\"replenishment\":{\"type\":\"replenishment\",\"dispatched\":0},\"winback_dormant\":{\"type\":\"winback\",\"dispatched\":0},\"failed_payment_retry\":{\"type\":\"failed_payment_retry\",\"dispatched\":0},\"vip_milestones\":{\"type\":\"vip_milestones\",\"dispatched\":0}}', NULL, '2026-08-26 21:31:04'),
(61, 1, 'full_ai_swarm_mesh', 'success', '2026-08-26 21:31:04', '2026-08-26 21:31:04', 358.31, 28, '{\"cycle_id\":\"SWARM-897D0E9F\",\"timestamp\":\"2026-08-26 18:01:04\",\"consensus_score\":\"100.0%\",\"agents_executed\":12,\"total_actions\":28,\"telemetry\":[{\"agent\":\"DynamicPricingAgent\",\"task\":\"Real-Time Margin Guard & Elasticity Rebalance\",\"status\":\"SUCCESS\",\"score\":1,\"summary\":\"Audited 10 catalog SKUs. Enforced 40% Margin Guard floor with atomic DB transactions.\"},{\"agent\":\"DataMoatScoringJob\",\"task\":\"First-Party Conversion & RTO Feedback Moat\",\"status\":\"SUCCESS\",\"score\":0.99,\"summary\":\"Synchronized first-party CVR, CTR, and RTO return rates back into product_performance_metrics and winning score algorithms.\"},{\"agent\":\"FinanceReconciliationJob\",\"task\":\"Gateway Settlement & Revenue Leak Audit\",\"status\":\"SUCCESS\",\"score\":1,\"summary\":\"Audited all active payment authorizations against orders.total to ensure 0 silent revenue leaks.\"},{\"agent\":\"AbandonedCartJob\",\"task\":\"Multi-Stage Omnichannel Recovery Sequence\",\"status\":\"SUCCESS\",\"score\":0.98,\"summary\":\"Executed staged recovery sequence (SAVE10 \\/ FREESHIP \\/ RECOVER15) across active abandoned sessions.\"},{\"agent\":\"VendorOrderRoutingJob\",\"task\":\"Multi-Vendor Commission Split & Ledger\",\"status\":\"SUCCESS\",\"score\":1,\"summary\":\"Routed new customer order line items to registered vendor portals with automated commission calculation.\"},{\"agent\":\"RetentionWinbackJob\",\"task\":\"RFM Segmentation & Dormant User Reactivation\",\"status\":\"SUCCESS\",\"score\":0.97,\"summary\":\"Scanned inactive buyers (>45 days) and scheduled automated 20% win-back incentive vouchers.\"},{\"agent\":\"SubscriptionBillingJob\",\"task\":\"Subscribe & Save Replenishment Dispatcher\",\"status\":\"SUCCESS\",\"score\":1,\"summary\":\"Scanned active replenishment subscriptions and generated automated renewal orders.\"},{\"agent\":\"ListingWriterJob\",\"task\":\"AI Product Listing & Luxury Provenance Copy\",\"status\":\"SUCCESS\",\"score\":0.99,\"summary\":\"Generated sensory bullet points, fabric specifications, and bespoke storytelling across catalog items.\"},{\"agent\":\"SeoContentGeneratorJob\",\"task\":\"Schema.org JSON-LD & Meta Tag Ingestor\",\"status\":\"SUCCESS\",\"score\":1,\"summary\":\"Injected Product, AggregateRating, Offers, and FAQPage microdata into database for Google Rich Snippets.\"},{\"agent\":\"SearchSyncJob\",\"task\":\"Fulltext Vector & Autocomplete Search Index\",\"status\":\"SUCCESS\",\"score\":1,\"summary\":\"Rebuilt internal product search vectors, keyword tokens, and typo-tolerant index.\"},{\"agent\":\"DailyDigestJob\",\"task\":\"Executive P&L Intelligence & Stockout Rollup\",\"status\":\"SUCCESS\",\"score\":1,\"summary\":\"Aggregated gross GMV, AOV, top-performing capsules, and inventory stockout risk metrics.\"},{\"agent\":\"Swarm Coordinator\",\"task\":\"Master Autonomous Mesh Synchronization\",\"status\":\"SUCCESS\",\"score\":1,\"summary\":\"All 28 autonomous engines synchronized and logged to automation_runs table.\"}]}', NULL, '2026-08-26 21:31:04');

-- --------------------------------------------------------

--
-- Table structure for table `back_in_stock_log`
--

CREATE TABLE `back_in_stock_log` (
  `id` bigint(20) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `restocked_qty` int(11) NOT NULL,
  `sent_at` datetime DEFAULT NULL,
  `status` enum('pending','sent','purchased') DEFAULT 'pending',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blog_posts`
--

CREATE TABLE `blog_posts` (
  `id` int(11) NOT NULL,
  `blgid` varchar(64) DEFAULT '',
  `title` varchar(255) DEFAULT '',
  `content` text DEFAULT NULL,
  `c_order` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `browse_abandonment_log`
--

CREATE TABLE `browse_abandonment_log` (
  `id` bigint(20) NOT NULL,
  `contact_identity_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `viewed_count` int(11) NOT NULL DEFAULT 1,
  `viewed_at` datetime DEFAULT current_timestamp(),
  `followup_step` int(11) NOT NULL DEFAULT 1,
  `sent_at` datetime DEFAULT NULL,
  `status` enum('pending','sent','converted','opt_out') DEFAULT 'pending',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` char(36) NOT NULL,
  `store_id` int(10) UNSIGNED NOT NULL,
  `customer_id` int(10) UNSIGNED DEFAULT NULL,
  `session_token` varchar(80) DEFAULT NULL,
  `discount_code` varchar(80) DEFAULT NULL,
  `discount_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `notes` text DEFAULT NULL,
  `last_activity` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `store_id`, `customer_id`, `session_token`, `discount_code`, `discount_amount`, `notes`, `last_activity`, `created_at`) VALUES
('079461c3-c9d1-49b0-9a62-c2366e410b81', 1, NULL, NULL, NULL, 0.00, NULL, '2026-08-28 01:35:24', '2026-08-27 22:05:24'),
('083792f2-2aa8-4d3e-ad2d-03337638a13e', 1, NULL, NULL, NULL, 0.00, NULL, '2026-08-25 20:43:09', '2026-08-25 17:13:09'),
('0954dde4-a050-46cc-abd6-af67f9c94b90', 1, NULL, NULL, NULL, 0.00, NULL, '2026-08-19 20:11:44', '2026-08-19 16:41:44'),
('1593639b-0422-4feb-859b-65cf2150c608', 1, NULL, NULL, NULL, 0.00, NULL, '2026-08-28 01:35:40', '2026-08-27 22:05:40'),
('24e14c95-69cc-458c-900d-3f8643152ce3', 1, NULL, NULL, NULL, 0.00, NULL, '2026-08-19 20:11:57', '2026-08-19 16:41:57'),
('2882944f-0984-416b-be3a-34c4e8b373e5', 1, NULL, NULL, NULL, 0.00, NULL, '2026-08-19 22:31:35', '2026-08-19 19:01:35'),
('2dbfff97-aba0-4513-877b-4a9e082bcab4', 1, NULL, NULL, NULL, 0.00, NULL, '2026-08-19 20:11:57', '2026-08-19 16:41:57'),
('3f8891bd-e1d0-42bd-a563-bba0286eb11d', 1, NULL, NULL, NULL, 0.00, NULL, '2026-08-24 00:57:55', '2026-08-23 21:27:55'),
('414c70bc-aaf2-42e9-ba0f-b74f77e3e6da', 1, NULL, NULL, NULL, 0.00, NULL, '2026-08-19 22:28:33', '2026-08-19 18:58:33'),
('44472d16-82a6-4918-800a-643f695095d8', 1, NULL, NULL, NULL, 0.00, NULL, '2026-08-19 22:28:41', '2026-08-19 18:58:41'),
('4a46ef52-51db-4781-8b9a-56f85ee891ed', 1, NULL, NULL, NULL, 0.00, NULL, '2026-08-19 22:31:48', '2026-08-19 19:01:48'),
('529264ce-962c-4cd8-b720-901b6d14b569', 1, NULL, NULL, NULL, 0.00, NULL, '2026-08-19 22:28:04', '2026-08-19 18:58:04'),
('7930b0bb-4d18-462d-898e-9301b2abf1cc', 1, NULL, NULL, NULL, 0.00, NULL, '2026-08-19 22:31:36', '2026-08-19 19:01:36'),
('93d0536c-acab-41b8-8eb0-276c1205f5cc', 1, NULL, NULL, NULL, 0.00, NULL, '2026-08-28 01:35:25', '2026-08-27 22:05:25'),
('a1b88338-774a-449c-b5c8-97d8d49c186f', 1, NULL, NULL, NULL, 0.00, NULL, '2026-08-19 22:31:25', '2026-08-19 19:01:25'),
('ad0e2cb1-4856-41af-8bbd-11a89acc5ca0', 1, NULL, NULL, NULL, 0.00, NULL, '2026-08-19 22:31:40', '2026-08-19 19:01:40'),
('b78dacec-3cb2-4649-9667-64ed9a745dc9', 1, NULL, NULL, NULL, 0.00, NULL, '2026-08-27 21:17:07', '2026-08-25 17:12:12'),
('c33aa356-40bf-46f6-bbe6-f89702c2b78b', 1, NULL, NULL, NULL, 0.00, NULL, '2026-08-28 10:43:58', '2026-08-28 07:13:58'),
('c3600631-1721-4739-81c5-feb273480530', 1, NULL, NULL, NULL, 0.00, NULL, '2026-08-28 01:35:40', '2026-08-27 22:05:40'),
('c7cb30a7-dd90-4606-a7d9-c80e4dd9a848', 1, NULL, NULL, NULL, 0.00, NULL, '2026-08-19 22:28:42', '2026-08-19 18:58:42'),
('d8b18542-c068-4825-af6b-a3c83b28fbe5', 1, NULL, NULL, NULL, 0.00, NULL, '2026-08-19 22:28:51', '2026-08-19 18:58:51'),
('e1e222ba-b42d-4a77-8990-e823fd6d810b', 1, NULL, NULL, NULL, 0.00, NULL, '2026-08-19 22:30:52', '2026-08-19 19:00:52'),
('e27e31be-8294-48fc-9161-0da4204e21f5', 1, NULL, NULL, NULL, 0.00, NULL, '2026-08-24 00:57:55', '2026-08-23 21:27:55'),
('e48063bd-68f8-47b2-9bc5-76d65643e044', 1, NULL, NULL, NULL, 0.00, NULL, '2026-08-19 20:28:24', '2026-08-19 19:36:24'),
('e4d7c972-b431-4c05-9611-f9f62c14771b', 1, NULL, NULL, NULL, 0.00, NULL, '2026-08-19 22:31:30', '2026-08-19 19:01:30'),
('f047d48d-4699-4f5d-8ee6-ac5b1c5bc4f3', 1, NULL, NULL, NULL, 0.00, NULL, '2026-08-25 05:56:27', '2026-08-25 05:46:09'),
('f2e2f30c-5ba2-4625-92a6-7cfd376f6275', 1, NULL, NULL, NULL, 0.00, NULL, '2026-08-19 20:11:44', '2026-08-19 16:41:44');

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `cart_id` char(36) NOT NULL,
  `variant_id` int(10) UNSIGNED NOT NULL,
  `quantity` smallint(6) NOT NULL DEFAULT 1,
  `unit_price` decimal(12,2) NOT NULL,
  `added_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cart_items`
--

INSERT INTO `cart_items` (`id`, `cart_id`, `variant_id`, `quantity`, `unit_price`, `added_at`) VALUES
(1, 'b0ac54eb-4c55-436f-a4a2-e4fcb92bc639', 9, 1, 7499.00, '2026-08-19 18:58:03'),
(2, 'e48063bd-68f8-47b2-9bc5-76d65643e044', 1, 1, 2499.00, '2026-08-19 19:36:24'),
(3, 'e48063bd-68f8-47b2-9bc5-76d65643e044', 6, 1, 7499.00, '2026-08-19 19:39:06'),
(4, 'e48063bd-68f8-47b2-9bc5-76d65643e044', 3, 1, 1899.00, '2026-08-19 20:28:24'),
(5, 'f047d48d-4699-4f5d-8ee6-ac5b1c5bc4f3', 321, 3, 6499.00, '2026-08-25 05:46:09'),
(6, 'f047d48d-4699-4f5d-8ee6-ac5b1c5bc4f3', 361, 1, 6499.00, '2026-08-25 05:56:27'),
(15, 'b78dacec-3cb2-4649-9667-64ed9a745dc9', 458, 2, 2899.00, '2026-08-26 18:12:08'),
(16, 'b78dacec-3cb2-4649-9667-64ed9a745dc9', 456, 2, 4399.00, '2026-08-27 21:16:20');

-- --------------------------------------------------------

--
-- Table structure for table `catgory`
--

CREATE TABLE `catgory` (
  `id` int(11) NOT NULL,
  `admid` varchar(64) DEFAULT NULL,
  `ctid` varchar(64) NOT NULL,
  `category` varchar(150) NOT NULL,
  `descp` text DEFAULT NULL,
  `ctimg` longblob DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `catgory`
--

INSERT INTO `catgory` (`id`, `admid`, `ctid`, `category`, `descp`, `ctimg`, `created_at`) VALUES
(1, '67ac7cf58dfc4', 'col_4', 'Atelier Apparel', 'Handcrafted garments and modern silhouettes tailored from organic sustainable fabrics.', NULL, '2026-08-19 14:27:08');

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ci_sessions`
--

INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('08brghtnlj9n89u242k2oqc508i6tfh8', '::1', 1787861125, 0x5f5f63695f6c6173745f726567656e65726174657c693a313738373836313132353b636172745f69647c733a33363a2239336430353336632d616361622d343162382d386562302d323736633132303566356363223b),
('0bm7f57e4eaumf8gn8q34mip4lk8pqq3', '::1', 1787861139, 0x5f5f63695f6c6173745f726567656e65726174657c693a313738373836313133393b),
('0ej7pu3nea54ufoq8b991fs71k7gf793', '::1', 1787894823, 0x5f5f63695f6c6173745f726567656e65726174657c693a313738373839343832333b636172745f69647c733a33363a2263333361613335362d343062662d343666362d626265362d663839373032633262373862223b),
('0hbp1l6kmh1249c5ojb64u217n646d41', '::1', 1787861126, 0x5f5f63695f6c6173745f726567656e65726174657c693a313738373836313132363b),
('1f58brp5i4mo7e040276h9on9ophp5fg', '::1', 1787861127, 0x5f5f63695f6c6173745f726567656e65726174657c693a313738373836313132373b),
('1umrd6irna9ipkbqeb079kp62paqn5gk', '::1', 1787858577, 0x5f5f63695f6c6173745f726567656e65726174657c693a313738373835383537373b636172745f69647c733a33363a2262373864616365632d336362322d343634392d393636372d363465643961373435646339223b),
('2j3vjb0a7utgh5jterogu6d44iar5upb', '::1', 1787910168, 0x5f5f63695f6c6173745f726567656e65726174657c693a313738373931303136383b636172745f69647c733a33363a2263333361613335362d343062662d343666362d626265362d663839373032633262373862223b),
('2lgopaj09vdrrq38db5fakfii2bksn0p', '::1', 1787861123, 0x5f5f63695f6c6173745f726567656e65726174657c693a313738373836313132333b),
('2o961j7k3jvvttdpcee5653mjuf4k08n', '::1', 1787861141, 0x5f5f63695f6c6173745f726567656e65726174657c693a313738373836313134313b),
('40tkra5pc1nvnvjhh6s1d6f2iu4ao5vh', '::1', 1787861142, 0x5f5f63695f6c6173745f726567656e65726174657c693a313738373836313134323b),
('51rpedrr3em5usva5os99nrttsk05n3m', '::1', 1787859936, 0x5f5f63695f6c6173745f726567656e65726174657c693a313738373835393933363b636172745f69647c733a33363a2262373864616365632d336362322d343634392d393636372d363465643961373435646339223b),
('78a3cogoncu59617nu3dqln5vi0m2n9h', '::1', 1787861126, 0x5f5f63695f6c6173745f726567656e65726174657c693a313738373836313132363b),
('7oo0g6vnelssee1739asq8laqt7f6260', '::1', 1787857078, 0x5f5f63695f6c6173745f726567656e65726174657c693a313738373835373037383b636172745f69647c733a33363a2262373864616365632d336362322d343634392d393636372d363465643961373435646339223b),
('a4cmj4oqrq6q5i1kfijedsbggnqv08uj', '::1', 1787910176, 0x5f5f63695f6c6173745f726567656e65726174657c693a313738373931303136383b636172745f69647c733a33363a2263333361613335362d343062662d343666362d626265362d663839373032633262373862223b),
('bk86v8rtq496q4f5i8polg2rftu9sdmp', '::1', 1787905749, 0x5f5f63695f6c6173745f726567656e65726174657c693a313738373930353734393b636172745f69647c733a33363a2263333361613335362d343062662d343666362d626265362d663839373032633262373862223b),
('d0kleqntn7d0qqbmosspfoelbsfeja85', '::1', 1787860691, 0x5f5f63695f6c6173745f726567656e65726174657c693a313738373836303639313b636172745f69647c733a33363a2262373864616365632d336362322d343634392d393636372d363465643961373435646339223b),
('eq7dqglhcd52ivhn6cdka1fdv2ojnfre', '::1', 1787861138, 0x5f5f63695f6c6173745f726567656e65726174657c693a313738373836313133383b),
('fekofjvit5dekan27bps5iq7dvjt196v', '::1', 1787900911, 0x5f5f63695f6c6173745f726567656e65726174657c693a313738373930303931313b636172745f69647c733a33363a2263333361613335362d343062662d343666362d626265362d663839373032633262373862223b),
('fihfb841nvkkmvhrjfmjifficivbateh', '::1', 1787861142, 0x5f5f63695f6c6173745f726567656e65726174657c693a313738373836313134323b),
('gl8ho9rsaok0v63lvp222r4a264fuhe2', '::1', 1787861127, 0x5f5f63695f6c6173745f726567656e65726174657c693a313738373836313132373b),
('gqsp0pnf8v0dtg7rf7hqjq9pehslfsd0', '::1', 1787857862, 0x5f5f63695f6c6173745f726567656e65726174657c693a313738373835373836323b636172745f69647c733a33363a2262373864616365632d336362322d343634392d393636372d363465643961373435646339223b),
('hlafmkb8tripmcl757cec3dj9geg10lc', '::1', 1787860908, 0x5f5f63695f6c6173745f726567656e65726174657c693a313738373836303639313b636172745f69647c733a33363a2262373864616365632d336362322d343634392d393636372d363465643961373435646339223b),
('iqovj7c5kbljtbu548h1lts8fl2skcsp', '::1', 1787858163, 0x5f5f63695f6c6173745f726567656e65726174657c693a313738373835383136333b636172745f69647c733a33363a2262373864616365632d336362322d343634392d393636372d363465643961373435646339223b),
('k0jtt3476ab16q4oe5j9kngrvammopgq', '::1', 1787858901, 0x5f5f63695f6c6173745f726567656e65726174657c693a313738373835383930313b636172745f69647c733a33363a2262373864616365632d336362322d343634392d393636372d363465643961373435646339223b),
('ku2ko8houap973hpo78a2qr9ut45ieio', '::1', 1787861122, 0x5f5f63695f6c6173745f726567656e65726174657c693a313738373836313132323b),
('l2s75q915buod77eik3tfg72hj4f4m2b', '::1', 1787861127, 0x5f5f63695f6c6173745f726567656e65726174657c693a313738373836313132373b),
('lb5oho6cuptq58uiurrs7m05bme2cep4', '::1', 1787895145, 0x5f5f63695f6c6173745f726567656e65726174657c693a313738373839353134323b),
('n2rm062lij749n6762r930m6v9e46grf', '::1', 1787861125, 0x5f5f63695f6c6173745f726567656e65726174657c693a313738373836313132353b),
('nf0etd15idis38aevnm7gj22et3ra5g9', '::1', 1787861140, 0x5f5f63695f6c6173745f726567656e65726174657c693a313738373836313134303b636172745f69647c733a33363a2263333630303633312d313732312d343733392d383163352d666562323733343830353330223b),
('ns2bt4sbgsrvjonrdgq7bqqohc4vih7p', '::1', 1787861124, 0x5f5f63695f6c6173745f726567656e65726174657c693a313738373836313132343b636172745f69647c733a33363a2230373934363163332d633964312d343962302d396136322d633233363665343130623831223b),
('o3d6upijkpm2q0mto8licnmtmm1r388l', '::1', 1787861141, 0x5f5f63695f6c6173745f726567656e65726174657c693a313738373836313134313b),
('p28ca50h9puotl55ra8pdi4r4qoru0vm', '::1', 1787857503, 0x5f5f63695f6c6173745f726567656e65726174657c693a313738373835373530333b636172745f69647c733a33363a2262373864616365632d336362322d343634392d393636372d363465643961373435646339223b),
('qcfbqvt3ev3v99c6flkrod805umqnq8l', '::1', 1787861140, 0x5f5f63695f6c6173745f726567656e65726174657c693a313738373836313134303b),
('r9e182uufobd3ieegfsce3tvaemn35n5', '::1', 1787861140, 0x5f5f63695f6c6173745f726567656e65726174657c693a313738373836313134303b636172745f69647c733a33363a2231353933363339622d303432322d346665622d383539622d363563663231353063363038223b),
('rfgv19f1r7lrrd62qj2toc7oe82chk06', '::1', 1787861127, 0x5f5f63695f6c6173745f726567656e65726174657c693a313738373836313132373b),
('sedqkgm504h6dunddig3uo86paqtq9ek', '::1', 1787859237, 0x5f5f63695f6c6173745f726567656e65726174657c693a313738373835393233373b636172745f69647c733a33363a2262373864616365632d336362322d343634392d393636372d363465643961373435646339223b),
('t3g2rltrr4esv2mcanq43c6ad8q5bkhq', '::1', 1787859539, 0x5f5f63695f6c6173745f726567656e65726174657c693a313738373835393533393b636172745f69647c733a33363a2262373864616365632d336362322d343634392d393636372d363465643961373435646339223b),
('umma441ec46hsaskinuet6quu2gfqp2a', '::1', 1787860334, 0x5f5f63695f6c6173745f726567656e65726174657c693a313738373836303333343b636172745f69647c733a33363a2262373864616365632d336362322d343634392d393636372d363465643961373435646339223b);

-- --------------------------------------------------------

--
-- Table structure for table `collections`
--

CREATE TABLE `collections` (
  `id` int(10) UNSIGNED NOT NULL,
  `store_id` int(10) UNSIGNED NOT NULL,
  `parent_id` int(10) UNSIGNED DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image_url` varchar(500) DEFAULT NULL,
  `show_on_homepage` tinyint(1) DEFAULT 1,
  `homepage_position` int(11) DEFAULT 0,
  `icon_style` enum('photo','illustration') DEFAULT 'photo',
  `seo_title` varchar(255) DEFAULT NULL,
  `seo_description` varchar(500) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `collections`
--

INSERT INTO `collections` (`id`, `store_id`, `parent_id`, `title`, `slug`, `description`, `image_url`, `show_on_homepage`, `homepage_position`, `icon_style`, `seo_title`, `seo_description`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, 'Outerwear & Cashmere', 'outerwear', 'Architectural 700 GSM Mongolian Cashmere & Melton Wool Coats', 'http://localhost/Dropshipping/img/cashmere_cocoon_coat.jpg', 1, 1, 'photo', NULL, NULL, 1, 1, '2026-08-28 15:12:49', '2026-08-28 15:12:49'),
(2, 1, NULL, 'Okayama Selvedge Denim', 'denim', '14.5oz Shuttle-Loomed Japanese Natural Indigo Denim', 'http://localhost/Dropshipping/img/okayama_selvedge_denim.jpg', 1, 2, 'photo', NULL, NULL, 2, 1, '2026-08-28 15:12:49', '2026-08-28 15:12:49'),
(3, 1, NULL, 'Mulberry Silk Eveningwear', 'silk', 'Fluid 22-Momme Sandwashed Pure Mulberry Silk', 'http://localhost/Dropshipping/img/mulberry_silk_dress.jpg', 1, 3, 'photo', NULL, NULL, 3, 1, '2026-08-28 15:12:49', '2026-08-28 15:12:49'),
(4, 1, NULL, 'Tailored Blazers & Suiting', 'tailoring', 'Super 150s Italian Virgin Wool Bespoke Suiting', 'http://localhost/Dropshipping/img/wool_blazer_luxury.jpg', 1, 4, 'photo', NULL, NULL, 4, 1, '2026-08-28 15:12:50', '2026-08-28 15:12:50'),
(5, 1, NULL, 'Heavyweight French Terry', 'knitwear', '500 GSM Custom Knit Loopback Essentials', 'http://localhost/Dropshipping/img/terry_hoodie_luxury.jpg', 1, 5, 'photo', NULL, NULL, 5, 1, '2026-08-28 15:12:50', '2026-08-28 15:12:50'),
(6, 1, NULL, 'Fine Knitwear & Cashmere', 'cashmere', 'Pure Mongolian Virgin Cashmere Ribbed Sweaters', 'http://localhost/Dropshipping/img/cashmere_turtleneck_knit.jpg', 1, 6, 'photo', NULL, NULL, 6, 1, '2026-08-28 15:12:50', '2026-08-28 15:12:50');

-- --------------------------------------------------------

--
-- Table structure for table `collection_products`
--

CREATE TABLE `collection_products` (
  `collection_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `position` int(10) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact_identities`
--

CREATE TABLE `contact_identities` (
  `id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT 1,
  `customer_id` int(11) DEFAULT NULL,
  `session_id` varchar(120) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `email` varchar(191) DEFAULT NULL,
  `whatsapp_opted_in` tinyint(1) DEFAULT 1,
  `captured_via` enum('checkout','popup','login','order','browse') DEFAULT 'browse',
  `last_active_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `currency_rates`
--

CREATE TABLE `currency_rates` (
  `id` int(11) NOT NULL,
  `code` char(3) NOT NULL,
  `symbol` varchar(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `exchange_rate` decimal(10,4) NOT NULL,
  `is_enabled` tinyint(1) DEFAULT 1,
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `currency_rates`
--

INSERT INTO `currency_rates` (`id`, `code`, `symbol`, `name`, `exchange_rate`, `is_enabled`, `updated_at`) VALUES
(1, 'INR', '₹', 'Indian Rupee', 1.0000, 1, '2026-08-26 00:58:12'),
(2, 'USD', '$', 'US Dollar', 0.0120, 1, '2026-08-26 00:58:12'),
(3, 'EUR', '€', 'Euro', 0.0110, 1, '2026-08-26 00:58:12'),
(4, 'GBP', '£', 'British Pound', 0.0095, 1, '2026-08-26 00:58:12'),
(5, 'AED', 'د.إ', 'UAE Dirham', 0.0440, 1, '2026-08-26 00:58:12'),
(6, 'CAD', '$', 'Canadian Dollar', 0.0160, 1, '2026-08-26 00:58:12'),
(7, 'AUD', '$', 'Australian Dollar', 0.0180, 1, '2026-08-26 00:58:12');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(10) UNSIGNED NOT NULL,
  `store_id` int(10) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `name` varchar(120) NOT NULL,
  `password_hash` varchar(255) DEFAULT NULL,
  `email_verified` tinyint(1) NOT NULL DEFAULT 0,
  `wallet_balance` decimal(12,2) NOT NULL DEFAULT 0.00,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `tags` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`tags`)),
  `meta_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`meta_json`)),
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `loyalty_points` int(11) DEFAULT 0,
  `loyalty_tier` varchar(50) DEFAULT 'Silver'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `store_id`, `email`, `phone`, `name`, `password_hash`, `email_verified`, `wallet_balance`, `is_active`, `tags`, `meta_json`, `created_at`, `updated_at`, `loyalty_points`, `loyalty_tier`) VALUES
(6, 1, 'customer@novadrop.in', '9870330063', 'Alexander Vance', '$2y$12$7KRZTE9xygI6jz/RcRrS8O0IcDte3c3h1rql937JZfdtsWg5gSQT6', 1, 0.00, 1, NULL, NULL, '2026-08-25 22:15:51', '2026-08-25 22:15:51', 0, 'Silver'),
(8, 1, 'atelier.collector.1286@gmail.com', NULL, 'Atelier Google Collector', '$2y$12$CMqY3W/dkqK9eT704Dyi1uEX1Rt/KMtCSBurke8OchBCVoVHw7A0m', 1, 0.00, 1, NULL, '{\"provider\":\"google\",\"google_id\":\"goog_1787762232\",\"avatar\":\"https:\\/\\/images.unsplash.com\\/photo-1534528741775-53994a69daeb?w=150&q=80\",\"whatsapp_optin\":true}', '2026-08-26 18:37:13', '2026-08-26 22:07:13', 0, 'Silver');

-- --------------------------------------------------------

--
-- Table structure for table `customer_addresses`
--

CREATE TABLE `customer_addresses` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `address_line1` varchar(255) NOT NULL,
  `address_line2` varchar(255) DEFAULT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `postal_code` varchar(20) NOT NULL,
  `country` varchar(50) DEFAULT 'India',
  `is_default` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_subscriptions`
--

CREATE TABLE `customer_subscriptions` (
  `id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT 1,
  `customer_id` int(11) NOT NULL,
  `plan_id` int(11) NOT NULL,
  `status` enum('active','paused','cancelled','past_due') DEFAULT 'active',
  `next_billing_date` date NOT NULL,
  `total_billed_cycles` int(11) DEFAULT 1,
  `last_payment_status` varchar(50) DEFAULT 'paid',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `description`
--

CREATE TABLE `description` (
  `id` int(11) NOT NULL,
  `admid` varchar(64) DEFAULT NULL,
  `pcid` varchar(64) NOT NULL,
  `despid` varchar(64) NOT NULL,
  `decph` varchar(255) NOT NULL,
  `descp` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `discount`
--

CREATE TABLE `discount` (
  `id` int(11) NOT NULL,
  `admid` varchar(64) DEFAULT NULL,
  `discid` varchar(64) DEFAULT '',
  `disc` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `discounts`
--

CREATE TABLE `discounts` (
  `id` int(10) UNSIGNED NOT NULL,
  `store_id` int(10) UNSIGNED NOT NULL,
  `code` varchar(80) DEFAULT NULL,
  `type` enum('percentage','flat','bogo','free_shipping') NOT NULL,
  `value` decimal(12,2) NOT NULL DEFAULT 0.00,
  `min_cart_amount` decimal(12,2) DEFAULT NULL,
  `max_uses` int(10) UNSIGNED DEFAULT NULL,
  `uses_count` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `max_uses_per_user` int(10) UNSIGNED DEFAULT 1,
  `first_order_only` tinyint(1) NOT NULL DEFAULT 0,
  `applies_to` enum('all','collection','product') NOT NULL DEFAULT 'all',
  `applies_to_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`applies_to_ids`)),
  `starts_at` datetime DEFAULT NULL,
  `ends_at` datetime DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `discounts`
--

INSERT INTO `discounts` (`id`, `store_id`, `code`, `type`, `value`, `min_cart_amount`, `max_uses`, `uses_count`, `max_uses_per_user`, `first_order_only`, `applies_to`, `applies_to_ids`, `starts_at`, `ends_at`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 1, 'WELCOME10', 'percentage', 10.00, 499.00, NULL, 0, 1, 0, 'all', NULL, NULL, NULL, 1, '2026-08-19 10:43:05', '2026-08-19 14:13:05');

-- --------------------------------------------------------

--
-- Table structure for table `disimg`
--

CREATE TABLE `disimg` (
  `id` int(11) NOT NULL,
  `admid` varchar(64) DEFAULT NULL,
  `discid` varchar(64) DEFAULT '',
  `image` longblob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `email_campaigns`
--

CREATE TABLE `email_campaigns` (
  `id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT 1,
  `name` varchar(150) NOT NULL,
  `segment_id` int(11) DEFAULT NULL,
  `subject` varchar(255) NOT NULL,
  `body_html` longtext NOT NULL,
  `status` enum('draft','scheduled','sending','sent') DEFAULT 'draft',
  `scheduled_at` datetime DEFAULT NULL,
  `sent_count` int(11) DEFAULT 0,
  `open_count` int(11) DEFAULT 0,
  `click_count` int(11) DEFAULT 0,
  `revenue_attributed` decimal(12,2) DEFAULT 0.00,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `email_lists`
--

CREATE TABLE `email_lists` (
  `id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT 1,
  `name` varchar(150) NOT NULL,
  `type` enum('all_customers','segment','manual') DEFAULT 'all_customers',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `email_segments`
--

CREATE TABLE `email_segments` (
  `id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT 1,
  `name` varchar(150) NOT NULL,
  `rule_json` longtext NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `email_subscribers`
--

CREATE TABLE `email_subscribers` (
  `id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT 1,
  `customer_id` int(11) DEFAULT NULL,
  `email` varchar(191) NOT NULL,
  `subscribed` tinyint(1) DEFAULT 1,
  `source` enum('signup','checkout','popup','manual') DEFAULT 'signup',
  `unsubscribed_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `email_templates`
--

CREATE TABLE `email_templates` (
  `id` int(10) UNSIGNED NOT NULL,
  `store_id` int(10) UNSIGNED NOT NULL,
  `key_name` varchar(80) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `body_html` longtext NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `error_log`
--

CREATE TABLE `error_log` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `store_id` int(10) UNSIGNED DEFAULT NULL,
  `severity` enum('debug','info','warning','error','critical') NOT NULL DEFAULT 'error',
  `context` varchar(120) DEFAULT NULL,
  `message` text NOT NULL,
  `trace` longtext DEFAULT NULL,
  `file` varchar(500) DEFAULT NULL,
  `line` int(11) DEFAULT NULL,
  `extra_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`extra_json`)),
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `error_log`
--

INSERT INTO `error_log` (`id`, `store_id`, `severity`, `context`, `message`, `trace`, `file`, `line`, `extra_json`, `created_at`) VALUES
(1, 1, 'error', 'Dashboard::live_ticker', 'Column \'created_at\' in field list is ambiguous', '#0 C:\\xampp\\htdocs\\Dropshipping\\system\\database\\drivers\\mysqli\\mysqli_driver.php(307): mysqli->query(\'SELECT `order_n...\')\n#1 C:\\xampp\\htdocs\\Dropshipping\\system\\database\\DB_driver.php(791): CI_DB_mysqli_driver->_execute(\'SELECT `order_n...\')\n#2 C:\\xampp\\htdocs\\Dropshipping\\system\\database\\DB_driver.php(654): CI_DB_driver->simple_query(\'SELECT `order_n...\')\n#3 C:\\xampp\\htdocs\\Dropshipping\\system\\database\\DB_query_builder.php(1383): CI_DB_driver->query(\'SELECT `order_n...\')\n#4 C:\\xampp\\htdocs\\Dropshipping\\application\\modules\\admin\\controllers\\Dashboard.php(116): CI_DB_query_builder->get()\n#5 C:\\xampp\\htdocs\\Dropshipping\\system\\core\\CodeIgniter.php(533): Dashboard->live_ticker()\n#6 C:\\xampp\\htdocs\\Dropshipping\\index.php(163): require_once(\'C:\\\\xampp\\\\htdocs...\')\n#7 {main}', 'C:\\xampp\\htdocs\\Dropshipping\\system\\database\\drivers\\mysqli\\mysqli_driver.php', 307, NULL, '2026-08-19 10:33:55'),
(2, 1, 'error', 'Dashboard::live_ticker', 'Column \'created_at\' in field list is ambiguous', '#0 C:\\xampp\\htdocs\\Dropshipping\\system\\database\\drivers\\mysqli\\mysqli_driver.php(307): mysqli->query(\'SELECT `order_n...\')\n#1 C:\\xampp\\htdocs\\Dropshipping\\system\\database\\DB_driver.php(791): CI_DB_mysqli_driver->_execute(\'SELECT `order_n...\')\n#2 C:\\xampp\\htdocs\\Dropshipping\\system\\database\\DB_driver.php(654): CI_DB_driver->simple_query(\'SELECT `order_n...\')\n#3 C:\\xampp\\htdocs\\Dropshipping\\system\\database\\DB_query_builder.php(1383): CI_DB_driver->query(\'SELECT `order_n...\')\n#4 C:\\xampp\\htdocs\\Dropshipping\\application\\modules\\admin\\controllers\\Dashboard.php(116): CI_DB_query_builder->get()\n#5 C:\\xampp\\htdocs\\Dropshipping\\system\\core\\CodeIgniter.php(533): Dashboard->live_ticker()\n#6 C:\\xampp\\htdocs\\Dropshipping\\index.php(163): require_once(\'C:\\\\xampp\\\\htdocs...\')\n#7 {main}', 'C:\\xampp\\htdocs\\Dropshipping\\system\\database\\drivers\\mysqli\\mysqli_driver.php', 307, NULL, '2026-08-19 10:34:25'),
(3, 1, 'error', 'Dashboard::live_ticker', 'Column \'created_at\' in field list is ambiguous', '#0 C:\\xampp\\htdocs\\Dropshipping\\system\\database\\drivers\\mysqli\\mysqli_driver.php(307): mysqli->query(\'SELECT `order_n...\')\n#1 C:\\xampp\\htdocs\\Dropshipping\\system\\database\\DB_driver.php(791): CI_DB_mysqli_driver->_execute(\'SELECT `order_n...\')\n#2 C:\\xampp\\htdocs\\Dropshipping\\system\\database\\DB_driver.php(654): CI_DB_driver->simple_query(\'SELECT `order_n...\')\n#3 C:\\xampp\\htdocs\\Dropshipping\\system\\database\\DB_query_builder.php(1383): CI_DB_driver->query(\'SELECT `order_n...\')\n#4 C:\\xampp\\htdocs\\Dropshipping\\application\\modules\\admin\\controllers\\Dashboard.php(116): CI_DB_query_builder->get()\n#5 C:\\xampp\\htdocs\\Dropshipping\\system\\core\\CodeIgniter.php(533): Dashboard->live_ticker()\n#6 C:\\xampp\\htdocs\\Dropshipping\\index.php(163): require_once(\'C:\\\\xampp\\\\htdocs...\')\n#7 {main}', 'C:\\xampp\\htdocs\\Dropshipping\\system\\database\\drivers\\mysqli\\mysqli_driver.php', 307, NULL, '2026-08-19 10:34:55'),
(4, 1, 'error', 'Dashboard::live_ticker', 'Column \'created_at\' in field list is ambiguous', '#0 C:\\xampp\\htdocs\\Dropshipping\\system\\database\\drivers\\mysqli\\mysqli_driver.php(307): mysqli->query(\'SELECT `order_n...\')\n#1 C:\\xampp\\htdocs\\Dropshipping\\system\\database\\DB_driver.php(791): CI_DB_mysqli_driver->_execute(\'SELECT `order_n...\')\n#2 C:\\xampp\\htdocs\\Dropshipping\\system\\database\\DB_driver.php(654): CI_DB_driver->simple_query(\'SELECT `order_n...\')\n#3 C:\\xampp\\htdocs\\Dropshipping\\system\\database\\DB_query_builder.php(1383): CI_DB_driver->query(\'SELECT `order_n...\')\n#4 C:\\xampp\\htdocs\\Dropshipping\\application\\modules\\admin\\controllers\\Dashboard.php(116): CI_DB_query_builder->get()\n#5 C:\\xampp\\htdocs\\Dropshipping\\system\\core\\CodeIgniter.php(533): Dashboard->live_ticker()\n#6 C:\\xampp\\htdocs\\Dropshipping\\index.php(163): require_once(\'C:\\\\xampp\\\\htdocs...\')\n#7 {main}', 'C:\\xampp\\htdocs\\Dropshipping\\system\\database\\drivers\\mysqli\\mysqli_driver.php', 307, NULL, '2026-08-19 10:35:25'),
(5, 1, 'error', 'Dashboard::live_ticker', 'Column \'created_at\' in field list is ambiguous', '#0 C:\\xampp\\htdocs\\Dropshipping\\system\\database\\drivers\\mysqli\\mysqli_driver.php(307): mysqli->query(\'SELECT `order_n...\')\n#1 C:\\xampp\\htdocs\\Dropshipping\\system\\database\\DB_driver.php(791): CI_DB_mysqli_driver->_execute(\'SELECT `order_n...\')\n#2 C:\\xampp\\htdocs\\Dropshipping\\system\\database\\DB_driver.php(654): CI_DB_driver->simple_query(\'SELECT `order_n...\')\n#3 C:\\xampp\\htdocs\\Dropshipping\\system\\database\\DB_query_builder.php(1383): CI_DB_driver->query(\'SELECT `order_n...\')\n#4 C:\\xampp\\htdocs\\Dropshipping\\application\\modules\\admin\\controllers\\Dashboard.php(116): CI_DB_query_builder->get()\n#5 C:\\xampp\\htdocs\\Dropshipping\\system\\core\\CodeIgniter.php(533): Dashboard->live_ticker()\n#6 C:\\xampp\\htdocs\\Dropshipping\\index.php(163): require_once(\'C:\\\\xampp\\\\htdocs...\')\n#7 {main}', 'C:\\xampp\\htdocs\\Dropshipping\\system\\database\\drivers\\mysqli\\mysqli_driver.php', 307, NULL, '2026-08-19 10:35:55'),
(6, 1, 'error', 'Dashboard::live_ticker', 'Column \'created_at\' in field list is ambiguous', '#0 C:\\xampp\\htdocs\\Dropshipping\\system\\database\\drivers\\mysqli\\mysqli_driver.php(307): mysqli->query(\'SELECT `order_n...\')\n#1 C:\\xampp\\htdocs\\Dropshipping\\system\\database\\DB_driver.php(791): CI_DB_mysqli_driver->_execute(\'SELECT `order_n...\')\n#2 C:\\xampp\\htdocs\\Dropshipping\\system\\database\\DB_driver.php(654): CI_DB_driver->simple_query(\'SELECT `order_n...\')\n#3 C:\\xampp\\htdocs\\Dropshipping\\system\\database\\DB_query_builder.php(1383): CI_DB_driver->query(\'SELECT `order_n...\')\n#4 C:\\xampp\\htdocs\\Dropshipping\\application\\modules\\admin\\controllers\\Dashboard.php(116): CI_DB_query_builder->get()\n#5 C:\\xampp\\htdocs\\Dropshipping\\system\\core\\CodeIgniter.php(533): Dashboard->live_ticker()\n#6 C:\\xampp\\htdocs\\Dropshipping\\index.php(163): require_once(\'C:\\\\xampp\\\\htdocs...\')\n#7 {main}', 'C:\\xampp\\htdocs\\Dropshipping\\system\\database\\drivers\\mysqli\\mysqli_driver.php', 307, NULL, '2026-08-19 10:36:25'),
(7, 1, 'error', 'Dashboard::live_ticker', 'Column \'created_at\' in field list is ambiguous', '#0 C:\\xampp\\htdocs\\Dropshipping\\system\\database\\drivers\\mysqli\\mysqli_driver.php(307): mysqli->query(\'SELECT `order_n...\')\n#1 C:\\xampp\\htdocs\\Dropshipping\\system\\database\\DB_driver.php(791): CI_DB_mysqli_driver->_execute(\'SELECT `order_n...\')\n#2 C:\\xampp\\htdocs\\Dropshipping\\system\\database\\DB_driver.php(654): CI_DB_driver->simple_query(\'SELECT `order_n...\')\n#3 C:\\xampp\\htdocs\\Dropshipping\\system\\database\\DB_query_builder.php(1383): CI_DB_driver->query(\'SELECT `order_n...\')\n#4 C:\\xampp\\htdocs\\Dropshipping\\application\\modules\\admin\\controllers\\Dashboard.php(116): CI_DB_query_builder->get()\n#5 C:\\xampp\\htdocs\\Dropshipping\\system\\core\\CodeIgniter.php(533): Dashboard->live_ticker()\n#6 C:\\xampp\\htdocs\\Dropshipping\\index.php(163): require_once(\'C:\\\\xampp\\\\htdocs...\')\n#7 {main}', 'C:\\xampp\\htdocs\\Dropshipping\\system\\database\\drivers\\mysqli\\mysqli_driver.php', 307, NULL, '2026-08-19 10:37:28'),
(8, 1, 'error', 'Dashboard::live_ticker', 'Column \'created_at\' in field list is ambiguous', '#0 C:\\xampp\\htdocs\\Dropshipping\\system\\database\\drivers\\mysqli\\mysqli_driver.php(307): mysqli->query(\'SELECT `order_n...\')\n#1 C:\\xampp\\htdocs\\Dropshipping\\system\\database\\DB_driver.php(791): CI_DB_mysqli_driver->_execute(\'SELECT `order_n...\')\n#2 C:\\xampp\\htdocs\\Dropshipping\\system\\database\\DB_driver.php(654): CI_DB_driver->simple_query(\'SELECT `order_n...\')\n#3 C:\\xampp\\htdocs\\Dropshipping\\system\\database\\DB_query_builder.php(1383): CI_DB_driver->query(\'SELECT `order_n...\')\n#4 C:\\xampp\\htdocs\\Dropshipping\\application\\modules\\admin\\controllers\\Dashboard.php(116): CI_DB_query_builder->get()\n#5 C:\\xampp\\htdocs\\Dropshipping\\system\\core\\CodeIgniter.php(533): Dashboard->live_ticker()\n#6 C:\\xampp\\htdocs\\Dropshipping\\index.php(163): require_once(\'C:\\\\xampp\\\\htdocs...\')\n#7 {main}', 'C:\\xampp\\htdocs\\Dropshipping\\system\\database\\drivers\\mysqli\\mysqli_driver.php', 307, NULL, '2026-08-19 10:38:28'),
(9, 1, 'error', 'Dashboard::live_ticker', 'Column \'created_at\' in field list is ambiguous', '#0 C:\\xampp\\htdocs\\Dropshipping\\system\\database\\drivers\\mysqli\\mysqli_driver.php(307): mysqli->query(\'SELECT `order_n...\')\n#1 C:\\xampp\\htdocs\\Dropshipping\\system\\database\\DB_driver.php(791): CI_DB_mysqli_driver->_execute(\'SELECT `order_n...\')\n#2 C:\\xampp\\htdocs\\Dropshipping\\system\\database\\DB_driver.php(654): CI_DB_driver->simple_query(\'SELECT `order_n...\')\n#3 C:\\xampp\\htdocs\\Dropshipping\\system\\database\\DB_query_builder.php(1383): CI_DB_driver->query(\'SELECT `order_n...\')\n#4 C:\\xampp\\htdocs\\Dropshipping\\application\\modules\\admin\\controllers\\Dashboard.php(116): CI_DB_query_builder->get()\n#5 C:\\xampp\\htdocs\\Dropshipping\\system\\core\\CodeIgniter.php(533): Dashboard->live_ticker()\n#6 C:\\xampp\\htdocs\\Dropshipping\\index.php(163): require_once(\'C:\\\\xampp\\\\htdocs...\')\n#7 {main}', 'C:\\xampp\\htdocs\\Dropshipping\\system\\database\\drivers\\mysqli\\mysqli_driver.php', 307, NULL, '2026-08-19 10:39:28'),
(10, 1, 'error', 'Storefront/Home', 'Table \'novadrop.home_settings\' doesn\'t exist', '#0 C:\\xampp\\htdocs\\Dropshipping\\system\\database\\drivers\\mysqli\\mysqli_driver.php(307): mysqli->query(\'SELECT *\\nFROM `...\')\n#1 C:\\xampp\\htdocs\\Dropshipping\\system\\database\\DB_driver.php(791): CI_DB_mysqli_driver->_execute(\'SELECT *\\nFROM `...\')\n#2 C:\\xampp\\htdocs\\Dropshipping\\system\\database\\DB_driver.php(654): CI_DB_driver->simple_query(\'SELECT *\\nFROM `...\')\n#3 C:\\xampp\\htdocs\\Dropshipping\\system\\database\\DB_query_builder.php(1383): CI_DB_driver->query(\'SELECT *\\nFROM `...\')\n#4 C:\\xampp\\htdocs\\Dropshipping\\application\\modules\\storefront\\controllers\\Home.php(112): CI_DB_query_builder->get(\'home_settings\')\n#5 C:\\xampp\\htdocs\\Dropshipping\\system\\core\\CodeIgniter.php(533): Home->index()\n#6 C:\\xampp\\htdocs\\Dropshipping\\index.php(163): require_once(\'C:\\\\xampp\\\\htdocs...\')\n#7 {main}', 'C:\\xampp\\htdocs\\Dropshipping\\system\\database\\drivers\\mysqli\\mysqli_driver.php', 307, NULL, '2026-08-25 17:47:21'),
(11, 1, 'error', 'Storefront/Home', 'Table \'novadrop.home_settings\' doesn\'t exist', '#0 C:\\xampp\\htdocs\\Dropshipping\\system\\database\\drivers\\mysqli\\mysqli_driver.php(307): mysqli->query(\'SELECT *\\nFROM `...\')\n#1 C:\\xampp\\htdocs\\Dropshipping\\system\\database\\DB_driver.php(791): CI_DB_mysqli_driver->_execute(\'SELECT *\\nFROM `...\')\n#2 C:\\xampp\\htdocs\\Dropshipping\\system\\database\\DB_driver.php(654): CI_DB_driver->simple_query(\'SELECT *\\nFROM `...\')\n#3 C:\\xampp\\htdocs\\Dropshipping\\system\\database\\DB_query_builder.php(1383): CI_DB_driver->query(\'SELECT *\\nFROM `...\')\n#4 C:\\xampp\\htdocs\\Dropshipping\\application\\modules\\storefront\\controllers\\Home.php(112): CI_DB_query_builder->get(\'home_settings\')\n#5 C:\\xampp\\htdocs\\Dropshipping\\system\\core\\CodeIgniter.php(533): Home->index()\n#6 C:\\xampp\\htdocs\\Dropshipping\\index.php(163): require_once(\'C:\\\\xampp\\\\htdocs...\')\n#7 {main}', 'C:\\xampp\\htdocs\\Dropshipping\\system\\database\\drivers\\mysqli\\mysqli_driver.php', 307, NULL, '2026-08-25 18:10:49');

-- --------------------------------------------------------

--
-- Table structure for table `flash_sales`
--

CREATE TABLE `flash_sales` (
  `id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT 1,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `discount_type` enum('percent','fixed') DEFAULT 'percent',
  `discount_value` decimal(10,2) NOT NULL DEFAULT 0.00,
  `min_purchase` decimal(10,2) DEFAULT 0.00,
  `max_uses` int(11) DEFAULT NULL,
  `uses_count` int(11) DEFAULT 0,
  `product_ids` text DEFAULT NULL COMMENT 'comma-separated product IDs, empty=all',
  `category_ids` text DEFAULT NULL,
  `starts_at` datetime NOT NULL,
  `ends_at` datetime NOT NULL,
  `is_active` tinyint(4) DEFAULT 1,
  `show_timer` tinyint(4) DEFAULT 1,
  `show_stock_bar` tinyint(4) DEFAULT 1,
  `badge_text` varchar(50) DEFAULT 'FLASH DEAL',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gamification_spins`
--

CREATE TABLE `gamification_spins` (
  `id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT 1,
  `wheel_id` int(11) NOT NULL,
  `lead_email` varchar(255) DEFAULT NULL,
  `lead_phone` varchar(30) DEFAULT NULL,
  `reward_label` varchar(255) NOT NULL,
  `coupon_code` varchar(50) DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `is_redeemed` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gamification_spins`
--

INSERT INTO `gamification_spins` (`id`, `store_id`, `wheel_id`, `lead_email`, `lead_phone`, `reward_label`, `coupon_code`, `ip_address`, `is_redeemed`, `created_at`) VALUES
(1, 1, 1, 'vip_shopper@example.com', '+91 98765 43210', '25% VIP Discount', 'VIP25', NULL, 1, '2026-08-26 01:17:44'),
(2, 1, 1, 'vip_shopper@example.com', '+91 98765 43210', '25% VIP Discount', 'VIP25', NULL, 1, '2026-08-26 01:17:48'),
(3, 1, 1, 'vip_shopper@example.com', '+91 98765 43210', '25% VIP Discount', 'VIP25', NULL, 1, '2026-08-26 01:17:49'),
(4, 1, 1, 'vip_shopper@example.com', '+91 98765 43210', '25% VIP Discount', 'VIP25', NULL, 1, '2026-08-26 01:17:49'),
(5, 1, 1, 'shopper_770@example.com', '+91 9813052182', '25% VIP Discount', 'VIP25', NULL, 1, '2026-08-26 01:22:25'),
(6, 1, 1, 'vip_customer_316@example.com', '+91 9853051215', 'Free Express Shipping', 'FREESHIP', NULL, 1, '2026-08-26 01:22:36'),
(7, 1, 1, 'vip_customer_941@example.com', '+91 9831580598', 'Better Luck Next Time', '', NULL, 1, '2026-08-26 01:22:44'),
(8, 1, 1, 'vip_customer_800@example.com', '+91 9866566578', 'Better Luck Next Time', '', NULL, 1, '2026-08-26 21:38:54');

-- --------------------------------------------------------

--
-- Table structure for table `gamification_wheels`
--

CREATE TABLE `gamification_wheels` (
  `id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT 1,
  `title` varchar(255) NOT NULL,
  `trigger_event` enum('exit_intent','time_delay','scroll_depth','manual_click') DEFAULT 'exit_intent',
  `trigger_value` int(11) DEFAULT 5 COMMENT 'Seconds delay or percentage scroll',
  `slices_json` text DEFAULT NULL COMMENT 'JSON of wheel segments, probabilities, and coupon codes',
  `require_email` tinyint(1) DEFAULT 1,
  `require_phone` tinyint(1) DEFAULT 1,
  `total_spins` int(11) DEFAULT 0,
  `total_leads_collected` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gamification_wheels`
--

INSERT INTO `gamification_wheels` (`id`, `store_id`, `title`, `trigger_event`, `trigger_value`, `slices_json`, `require_email`, `require_phone`, `total_spins`, `total_leads_collected`, `is_active`, `created_at`) VALUES
(1, 1, 'Lucky Atelier Wheel of Fortune', 'manual_click', 5, '[{\"label\":\"15% OFF Sitewide\",\"color\":\"#f59e0b\",\"code\":\"LUCKY15\",\"win_chance\":30},{\"label\":\"Free Express Shipping\",\"color\":\"#3b82f6\",\"code\":\"FREESHIP\",\"win_chance\":25},{\"label\":\"u20b9500 Cash Voucher\",\"color\":\"#10b981\",\"code\":\"CASH500\",\"win_chance\":15},{\"label\":\"Better Luck Next Time\",\"color\":\"#64748b\",\"code\":\"\",\"win_chance\":5},{\"label\":\"25% VIP Discount\",\"color\":\"#8b5cf6\",\"code\":\"VIP25\",\"win_chance\":20},{\"label\":\"Mystery Atelier Gift\",\"color\":\"#ec4899\",\"code\":\"MYSTERYGIFT\",\"win_chance\":5}]', 1, 1, 8, 8, 1, '2026-08-26 01:15:00');

-- --------------------------------------------------------

--
-- Table structure for table `gift_cards`
--

CREATE TABLE `gift_cards` (
  `id` int(11) NOT NULL,
  `code` varchar(60) NOT NULL,
  `initial_balance` decimal(12,2) NOT NULL,
  `current_balance` decimal(12,2) NOT NULL,
  `currency` varchar(10) DEFAULT 'INR',
  `customer_id` int(11) DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  `status` enum('active','redeemed','expired','disabled') DEFAULT 'active',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `group_buy_campaigns`
--

CREATE TABLE `group_buy_campaigns` (
  `id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT 1,
  `title` varchar(255) NOT NULL,
  `product_id` int(11) NOT NULL,
  `team_size_required` int(11) NOT NULL DEFAULT 3 COMMENT 'Number of friends required to unlock price',
  `discount_percent` decimal(5,2) NOT NULL DEFAULT 40.00,
  `group_price` decimal(12,2) NOT NULL DEFAULT 0.00,
  `single_price` decimal(12,2) NOT NULL DEFAULT 0.00,
  `time_limit_hours` int(11) NOT NULL DEFAULT 24,
  `total_teams_created` int(11) DEFAULT 0,
  `total_teams_completed` int(11) DEFAULT 0,
  `total_viral_shoppers` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `group_buy_teams`
--

CREATE TABLE `group_buy_teams` (
  `id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT 1,
  `campaign_id` int(11) NOT NULL,
  `team_code` varchar(32) NOT NULL,
  `leader_customer_id` int(11) NOT NULL,
  `members_joined` int(11) DEFAULT 1,
  `status` enum('forming','completed','expired') DEFAULT 'forming',
  `expires_at` datetime NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `home_settings`
--

CREATE TABLE `home_settings` (
  `id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT 1,
  `announcement_text` varchar(500) DEFAULT 'Complimentary White-Glove Air Dispatch on All Pieces · Apply VIP Code: LUMINA50',
  `announcement_bg_color` varchar(30) DEFAULT '#0a0b0e',
  `announcement_text_color` varchar(30) DEFAULT '#e9c176',
  `announcement_link` varchar(500) DEFAULT '',
  `announcement_enabled` tinyint(1) DEFAULT 1,
  `hero_label` varchar(200) DEFAULT 'Exclusive VIP Release · Live Catalog',
  `hero_headline` varchar(300) DEFAULT 'Form Without Compromise.',
  `hero_subheadline` varchar(300) DEFAULT '',
  `hero_body` text DEFAULT NULL,
  `hero_bg_image` varchar(500) DEFAULT 'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?w=1920&q=85',
  `hero_cta_text` varchar(100) DEFAULT 'Explore Boutique',
  `hero_cta_url` varchar(500) DEFAULT '/shop',
  `hero_product_id` int(11) DEFAULT 1,
  `flash_section_enabled` tinyint(1) DEFAULT 1,
  `flash_section_title` varchar(200) DEFAULT 'Today''s VIP Flash Deals.',
  `flash_section_subtitle` varchar(400) DEFAULT 'These curated atelier pieces are available at privilege pricing for members only.',
  `flash_timer_hours` int(11) DEFAULT 7,
  `featured_section_title` varchar(200) DEFAULT 'Curated Wardrobe',
  `featured_section_subtitle` varchar(300) DEFAULT 'The Current Collection',
  `featured_section_enabled` tinyint(1) DEFAULT 1,
  `arrivals_section_title` varchar(200) DEFAULT 'Just Arrived in the Atelier',
  `arrivals_section_subtitle` varchar(300) DEFAULT 'Explore signature silhouettes crafted from raw organic fibers.',
  `arrivals_section_enabled` tinyint(1) DEFAULT 1,
  `sticky_bar_product_id` int(11) DEFAULT 1,
  `sticky_bar_enabled` tinyint(1) DEFAULT 1,
  `whatsapp_number` varchar(20) DEFAULT '919999999999',
  `whatsapp_message` varchar(300) DEFAULT 'Hi! I found your Lumina Atelier store and need styling help.',
  `whatsapp_enabled` tinyint(1) DEFAULT 1,
  `trust_badge_1` varchar(100) DEFAULT 'Verified',
  `trust_badge_2` varchar(100) DEFAULT '7-Day Return',
  `trust_badge_3` varchar(100) DEFAULT 'White-Glove Delivery',
  `brand_name` varchar(100) DEFAULT 'LUMINA',
  `brand_tagline` text DEFAULT NULL,
  `copyright_text` varchar(300) DEFAULT '© 2026 LUMINA ATELIER COLLECTIVE. ALL RIGHTS RESERVED.',
  `contact_email` varchar(255) DEFAULT 'concierge@lumina-atelier.com',
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `home_settings`
--

INSERT INTO `home_settings` (`id`, `store_id`, `announcement_text`, `announcement_bg_color`, `announcement_text_color`, `announcement_link`, `announcement_enabled`, `hero_label`, `hero_headline`, `hero_subheadline`, `hero_body`, `hero_bg_image`, `hero_cta_text`, `hero_cta_url`, `hero_product_id`, `flash_section_enabled`, `flash_section_title`, `flash_section_subtitle`, `flash_timer_hours`, `featured_section_title`, `featured_section_subtitle`, `featured_section_enabled`, `arrivals_section_title`, `arrivals_section_subtitle`, `arrivals_section_enabled`, `sticky_bar_product_id`, `sticky_bar_enabled`, `whatsapp_number`, `whatsapp_message`, `whatsapp_enabled`, `trust_badge_1`, `trust_badge_2`, `trust_badge_3`, `brand_name`, `brand_tagline`, `copyright_text`, `contact_email`, `updated_at`) VALUES
(1, 1, 'Complimentary White-Glove Air Dispatch on All Pieces · Apply VIP Code: LUMINA50', '#0a0b0e', '#e9c176', '', 1, 'Exclusive VIP Release · Live Catalog', 'Form Without Compromise.', '', NULL, 'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?w=1920&q=85', 'Explore Boutique', '/shop', 1, 1, 'Today\'s VIP Flash Deals.', 'These curated atelier pieces are available at privilege pricing for members only.', 6, 'Curated Wardrobe', 'The Current Collection', 1, 'Just Arrived in the Atelier', 'Explore signature silhouettes crafted from raw organic fibers.', 1, 1, 1, '919999999999', 'Hi! I found your Lumina Atelier store and need styling help.', 1, 'Verified', '7-Day Return', 'White-Glove Delivery', 'LUMINA', 'Curated luxury garments and architectural objects for the considered space. Designed with intention, crafted to last.', '© 2026 LUMINA ATELIER COLLECTIVE. ALL RIGHTS RESERVED.', 'concierge@lumina-atelier.com', '2026-08-25 21:54:23');

-- --------------------------------------------------------

--
-- Table structure for table `influencers`
--

CREATE TABLE `influencers` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `handle` varchar(150) NOT NULL,
  `platform` varchar(50) DEFAULT 'instagram',
  `followers` int(11) DEFAULT 0,
  `engagement_rate` decimal(5,2) DEFAULT 0.00,
  `collab_type` enum('gifted','paid','affiliate') DEFAULT 'affiliate',
  `commission_pct` decimal(5,2) DEFAULT 10.00,
  `referral_code` varchar(50) DEFAULT NULL,
  `status` enum('prospect','active','paused') DEFAULT 'prospect',
  `total_sales` decimal(12,2) DEFAULT 0.00,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `influencers`
--

INSERT INTO `influencers` (`id`, `name`, `handle`, `platform`, `followers`, `engagement_rate`, `collab_type`, `commission_pct`, `referral_code`, `status`, `total_sales`, `created_at`) VALUES
(1, 'Priya Mehta', '@priya.aesthetic', 'instagram', 142000, 4.80, 'affiliate', 12.00, 'PRIYA12', 'active', 48320.00, '2026-08-26 01:35:55'),
(2, 'Rihaan Styles', '@rihaanstyles', 'youtube', 890000, 3.20, 'affiliate', 15.00, 'RIHAAN15', 'active', 123500.00, '2026-08-26 01:35:55'),
(3, 'Kavya Looks', '@kavya.looks', 'instagram', 28000, 6.10, 'affiliate', 10.00, 'KAVYA10', 'active', 18900.00, '2026-08-26 01:35:55'),
(4, 'Arjun Fits', '@arjunfits', 'youtube', 55000, 5.40, 'affiliate', 10.00, 'ARJUN10', 'prospect', 0.00, '2026-08-26 01:35:55');

-- --------------------------------------------------------

--
-- Table structure for table `jobs_queue`
--

CREATE TABLE `jobs_queue` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `store_id` int(10) UNSIGNED DEFAULT NULL,
  `queue` varchar(60) NOT NULL DEFAULT 'default',
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`payload`)),
  `attempts` tinyint(4) NOT NULL DEFAULT 0,
  `max_attempts` tinyint(4) NOT NULL DEFAULT 3,
  `status` enum('pending','running','done','failed') NOT NULL DEFAULT 'pending',
  `available_at` datetime NOT NULL DEFAULT current_timestamp(),
  `started_at` datetime DEFAULT NULL,
  `finished_at` datetime DEFAULT NULL,
  `error_message` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jobs_queue`
--

INSERT INTO `jobs_queue` (`id`, `store_id`, `queue`, `payload`, `attempts`, `max_attempts`, `status`, `available_at`, `started_at`, `finished_at`, `error_message`, `created_at`) VALUES
(1, 1, 'email', '{\"job\":\"send_email\",\"order_id\":3,\"template\":\"order_shipped\",\"tracking\":\"CJIND1140648BD\",\"carrier\":\"BlueDart \\/ Delhivery Surface\",\"tracking_url\":\"https:\\/\\/track.cjdropshipping.com\\/tracking?num=CJIND\"}', 0, 3, 'done', '2026-08-19 16:38:10', '2026-08-19 16:41:50', '2026-08-19 16:41:52', NULL, '2026-08-19 16:38:10'),
(2, 1, 'email', '{\"job\":\"send_email\",\"to\":\"noreply@novadrop.in\",\"name\":\"Store Administrator\",\"subject\":\"\\ud83d\\udcc8 NovaDrop Daily Performance Digest \\u2014 19 Aug 2026\",\"template\":\"daily_digest\",\"summary\":\"\\ud83d\\udcca NovaDrop Daily Executive Digest [19 Aug 2026]:\\n\\u2022 Gross GMV: \\u20b94,998.00 across 2 orders (AOV: \\u20b92,499.00)\\n\\u2022 Estimated Net Profit: \\u20b93,130.75 (Margin ~62.6%)\\n\\u2022 Top Products: 1. UltraFast Magnetic Qi2 Wireless Powerbank (1 units \\u00b7 \\u20b92,499.00) \\n\\u2022 Critical Low-Stock SKUs: 0 items\\n\\u2022 Failed Payment Alerts: 0\"}', 0, 3, 'done', '2026-08-19 16:40:06', '2026-08-19 16:41:50', '2026-08-19 16:41:52', NULL, '2026-08-19 16:40:06'),
(3, 1, 'default', '{\"job\":\"finance_reconciliation\"}', 0, 3, 'done', '2026-08-19 16:40:06', '2026-08-19 16:41:50', '2026-08-19 16:41:52', NULL, '2026-08-19 16:40:06'),
(4, 1, 'default', '{\"job\":\"daily_digest\"}', 0, 3, 'done', '2026-08-19 16:40:06', '2026-08-19 16:41:50', '2026-08-19 16:41:52', NULL, '2026-08-19 16:40:06'),
(5, 1, 'email', '{\"job\":\"send_email\",\"to\":\"noreply@novadrop.in\",\"name\":\"Store Administrator\",\"subject\":\"\\ud83d\\udcc8 NovaDrop Daily Performance Digest \\u2014 19 Aug 2026\",\"template\":\"daily_digest\",\"summary\":\"\\ud83d\\udcca NovaDrop Daily Executive Digest [19 Aug 2026]:\\n\\u2022 Gross GMV: \\u20b917,498.00 across 3 orders (AOV: \\u20b95,832.67)\\n\\u2022 Estimated Net Profit: \\u20b910,960.75 (Margin ~62.6%)\\n\\u2022 Top Products: 1. UltraFast Magnetic Qi2 Wireless Powerbank (1 units \\u00b7 \\u20b92,499.00) \\n\\u2022 Critical Low-Stock SKUs: 0 items\\n\\u2022 Failed Payment Alerts: 0\"}', 0, 3, 'done', '2026-08-19 16:41:00', '2026-08-19 16:41:50', '2026-08-19 16:41:52', NULL, '2026-08-19 16:41:00'),
(6, 1, 'email', '{\"job\":\"send_email\",\"to\":\"customer@example.com\",\"name\":\"Valued Customer\",\"subject\":\"\\ud83d\\udc4b Valued Customer, you left something in your NovaDrop cart!\",\"template\":\"cart_recovery\",\"promo_code\":\"SAVE10\",\"discount\":\"10% OFF\",\"recovery_url\":\"http:\\/\\/localhost\\/Dropshipping\\/cart?recover=test-cart-6a858f5c388c0&code=SAVE10\"}', 0, 3, 'done', '2026-08-19 16:41:24', '2026-08-19 16:41:50', '2026-08-19 16:41:52', NULL, '2026-08-19 16:41:24'),
(7, 1, 'email', '{\"job\":\"send_email\",\"to\":\"noreply@novadrop.in\",\"name\":\"Store Administrator\",\"subject\":\"\\ud83d\\udcc8 NovaDrop Daily Performance Digest \\u2014 19 Aug 2026\",\"template\":\"daily_digest\",\"summary\":\"\\ud83d\\udcca NovaDrop Daily Executive Digest [19 Aug 2026]:\\n\\u2022 Gross GMV: \\u20b917,498.00 across 3 orders (AOV: \\u20b95,832.67)\\n\\u2022 Estimated Net Profit: \\u20b910,960.75 (Margin ~62.6%)\\n\\u2022 Top Products: 1. UltraFast Magnetic Qi2 Wireless Powerbank (1 units \\u00b7 \\u20b92,499.00) \\n\\u2022 Critical Low-Stock SKUs: 0 items\\n\\u2022 Failed Payment Alerts: 0\"}', 0, 3, 'done', '2026-08-19 16:41:24', '2026-08-19 16:41:50', '2026-08-19 16:41:52', NULL, '2026-08-19 16:41:24'),
(8, 1, 'default', '{\"job\":\"finance_reconciliation\"}', 0, 3, 'done', '2026-08-19 16:41:24', '2026-08-19 16:41:50', '2026-08-19 16:41:52', NULL, '2026-08-19 16:41:24'),
(9, 1, 'default', '{\"job\":\"daily_digest\"}', 0, 3, 'done', '2026-08-19 16:41:24', '2026-08-19 16:41:50', '2026-08-19 16:41:52', NULL, '2026-08-19 16:41:24'),
(10, 1, 'email', '{\"job\":\"send_email\",\"to\":\"customer@example.com\",\"name\":\"Valued Customer\",\"subject\":\"\\ud83d\\udc4b Valued Customer, you left something in your NovaDrop cart!\",\"template\":\"cart_recovery\",\"promo_code\":\"SAVE10\",\"discount\":\"10% OFF\",\"recovery_url\":\"http:\\/\\/localhost\\/Dropshipping\\/cart?recover=test-cart-6a858f7630725&code=SAVE10\"}', 0, 3, 'done', '2026-08-19 16:41:50', '2026-08-19 16:41:50', '2026-08-19 16:41:52', NULL, '2026-08-19 16:41:50'),
(11, 1, 'email', '{\"job\":\"send_email\",\"to\":\"noreply@novadrop.in\",\"name\":\"Store Administrator\",\"subject\":\"\\ud83d\\udcc8 NovaDrop Daily Performance Digest \\u2014 19 Aug 2026\",\"template\":\"daily_digest\",\"summary\":\"\\ud83d\\udcca NovaDrop Daily Executive Digest [19 Aug 2026]:\\n\\u2022 Gross GMV: \\u20b929,998.00 across 4 orders (AOV: \\u20b97,499.50)\\n\\u2022 Estimated Net Profit: \\u20b918,790.75 (Margin ~62.6%)\\n\\u2022 Top Products: 1. UltraFast Magnetic Qi2 Wireless Powerbank (1 units \\u00b7 \\u20b92,499.00) \\n\\u2022 Critical Low-Stock SKUs: 0 items\\n\\u2022 Failed Payment Alerts: 0\"}', 0, 3, 'done', '2026-08-19 16:41:50', '2026-08-19 16:45:06', '2026-08-19 16:45:06', NULL, '2026-08-19 16:41:50'),
(12, 1, 'default', '{\"job\":\"finance_reconciliation\"}', 0, 3, 'done', '2026-08-19 16:41:50', '2026-08-19 16:45:06', '2026-08-19 16:45:06', NULL, '2026-08-19 16:41:50'),
(13, 1, 'default', '{\"job\":\"daily_digest\"}', 0, 3, 'done', '2026-08-19 16:41:50', '2026-08-19 16:45:06', '2026-08-19 16:45:06', NULL, '2026-08-19 16:41:50'),
(14, 1, 'email', '{\"job\":\"send_email\",\"to\":\"noreply@novadrop.in\",\"name\":\"Store Administrator\",\"subject\":\"\\ud83d\\udcc8 NovaDrop Daily Performance Digest \\u2014 19 Aug 2026\",\"template\":\"daily_digest\",\"summary\":\"\\ud83d\\udcca NovaDrop Daily Executive Digest [19 Aug 2026]:\\n\\u2022 Gross GMV: \\u20b942,498.00 across 5 orders (AOV: \\u20b98,499.60)\\n\\u2022 Estimated Net Profit: \\u20b926,620.75 (Margin ~62.6%)\\n\\u2022 Top Products: 1. UltraFast Magnetic Qi2 Wireless Powerbank (1 units \\u00b7 \\u20b92,499.00) \\n\\u2022 Critical Low-Stock SKUs: 0 items\\n\\u2022 Failed Payment Alerts: 0\"}', 0, 3, 'done', '2026-08-19 16:41:52', '2026-08-19 16:45:06', '2026-08-19 16:45:06', NULL, '2026-08-19 16:41:52'),
(15, 1, 'email', '{\"job\":\"send_email\",\"to\":\"noreply@novadrop.in\",\"name\":\"Store Administrator\",\"subject\":\"\\ud83d\\udcc8 NovaDrop Daily Performance Digest \\u2014 19 Aug 2026\",\"template\":\"daily_digest\",\"summary\":\"\\ud83d\\udcca NovaDrop Daily Executive Digest [19 Aug 2026]:\\n\\u2022 Gross GMV: \\u20b942,498.00 across 5 orders (AOV: \\u20b98,499.60)\\n\\u2022 Estimated Net Profit: \\u20b926,620.75 (Margin ~62.6%)\\n\\u2022 Top Products: 1. UltraFast Magnetic Qi2 Wireless Powerbank (1 units \\u00b7 \\u20b92,499.00) \\n\\u2022 Critical Low-Stock SKUs: 0 items\\n\\u2022 Failed Payment Alerts: 0\"}', 0, 3, 'done', '2026-08-19 16:41:52', '2026-08-19 16:45:06', '2026-08-19 16:45:06', NULL, '2026-08-19 16:41:52'),
(16, 1, 'fulfillment', '{\"job\":\"push_order_to_supplier\",\"order_id\":8}', 0, 3, 'done', '2026-08-19 16:45:06', '2026-08-19 16:45:06', '2026-08-19 16:45:06', NULL, '2026-08-19 16:45:06'),
(17, 1, 'email', '{\"job\":\"send_email\",\"to\":\"atelier.collector.a07b@gmail.com\",\"name\":\"Atelier Google Collector\",\"subject\":\"\\ud83d\\udd04 Your Subscription Order #SUB-REC-13887 is Confirmed! \\u2014 NovaDrop\",\"template\":\"subscription_renewed\"}', 0, 3, 'done', '2026-08-19 16:45:06', '2026-08-19 16:45:06', '2026-08-19 16:45:06', NULL, '2026-08-19 16:45:06'),
(18, 1, 'fulfillment', '{\"job\":\"push_order_to_supplier\",\"order_id\":9}', 0, 3, 'done', '2026-08-19 16:45:06', '2026-08-19 16:45:06', '2026-08-19 16:45:06', NULL, '2026-08-19 16:45:06'),
(19, 1, 'default', '{\"job\":\"seo_content\"}', 0, 3, 'done', '2026-08-19 16:45:06', '2026-08-19 16:45:06', '2026-08-19 16:45:06', NULL, '2026-08-19 16:45:06'),
(20, 1, 'default', '{\"job\":\"data_moat_scoring\"}', 0, 3, 'done', '2026-08-19 16:45:06', '2026-08-19 16:45:06', '2026-08-19 16:45:06', NULL, '2026-08-19 16:45:06'),
(21, 1, 'email', '{\"job\":\"send_email\",\"to\":\"noreply@novadrop.in\",\"name\":\"Store Administrator\",\"subject\":\"\\ud83d\\udcc8 NovaDrop Daily Performance Digest \\u2014 19 Aug 2026\",\"template\":\"daily_digest\",\"summary\":\"\\ud83d\\udcca NovaDrop Daily Executive Digest [19 Aug 2026]:\\n\\u2022 Gross GMV: \\u20b944,197.00 across 6 orders (AOV: \\u20b97,366.17)\\n\\u2022 Estimated Net Profit: \\u20b927,685.00 (Margin ~62.6%)\\n\\u2022 Top Products: 1. AeroWave Pro Active Noise Cancelling Headphones [Subscribe & Save Replenishment] (1 units \\u00b7 \\u20b91,699.00) 2. UltraFast Magnetic Qi2 Wireless Powerbank (1 units \\u00b7 \\u20b92,499.00) \\n\\u2022 Critical Low-Stock SKUs: 0 items\\n\\u2022 Failed Payment Alerts: 0\"}', 0, 3, 'done', '2026-08-19 16:45:06', '2026-08-19 17:11:56', '2026-08-19 17:11:56', NULL, '2026-08-19 16:45:06'),
(22, 1, 'email', '{\"job\":\"send_email\",\"order_id\":8,\"template\":\"order_shipped\",\"tracking\":\"CJINDB2A6DA7FF\",\"carrier\":\"BlueDart \\/ Delhivery Surface\",\"tracking_url\":\"https:\\/\\/track.cjdropshipping.com\\/tracking?num=CJIND\"}', 0, 3, 'done', '2026-08-19 16:45:06', '2026-08-19 17:11:56', '2026-08-19 17:11:58', NULL, '2026-08-19 16:45:06'),
(23, 1, 'email', '{\"job\":\"send_email\",\"to\":\"noreply@novadrop.in\",\"name\":\"Store Administrator\",\"subject\":\"\\ud83d\\udcc8 NovaDrop Daily Performance Digest \\u2014 19 Aug 2026\",\"template\":\"daily_digest\",\"summary\":\"\\ud83d\\udcca NovaDrop Daily Executive Digest [19 Aug 2026]:\\n\\u2022 Gross GMV: \\u20b944,197.00 across 6 orders (AOV: \\u20b97,366.17)\\n\\u2022 Estimated Net Profit: \\u20b927,685.00 (Margin ~62.6%)\\n\\u2022 Top Products: 1. AeroWave Pro Active Noise Cancelling Headphones [Subscribe & Save Replenishment] (1 units \\u00b7 \\u20b91,699.00) 2. UltraFast Magnetic Qi2 Wireless Powerbank (1 units \\u00b7 \\u20b92,499.00) \\n\\u2022 Critical Low-Stock SKUs: 0 items\\n\\u2022 Failed Payment Alerts: 0\"}', 0, 3, 'done', '2026-08-19 16:47:11', '2026-08-19 17:11:56', '2026-08-19 17:11:58', NULL, '2026-08-19 16:47:11'),
(24, 1, 'email', '{\"job\":\"send_email\",\"to\":\"aarav@novatech.in\",\"name\":\"Aarav Mehta\",\"subject\":\"\\ud83d\\udce6 New Order Assigned: ##MV-ORD-11734 \\u2014 NovaTech Innovations\",\"template\":\"vendor_order_notification\",\"order_number\":\"#MV-ORD-11734\",\"items\":\"Wireless Mechanical Ergo Keyboard (x1)\",\"vendor_subtotal\":2000,\"action_url\":\"http:\\/\\/localhost\\/Dropshipping\\/vendor\\/orders\\/view\\/10\"}', 0, 3, 'done', '2026-08-19 16:54:01', '2026-08-19 17:11:56', '2026-08-19 17:11:58', NULL, '2026-08-19 16:54:01'),
(25, 1, 'email', '{\"job\":\"send_email\",\"to\":\"priya@ergodesk.in\",\"name\":\"Priya Sen\",\"subject\":\"\\ud83d\\udce6 New Order Assigned: ##MV-ORD-11734 \\u2014 ErgoDesk Direct\",\"template\":\"vendor_order_notification\",\"order_number\":\"#MV-ORD-11734\",\"items\":\"Adjustable Pneumatic Laptop Desk Riser (x1)\",\"vendor_subtotal\":3500,\"action_url\":\"http:\\/\\/localhost\\/Dropshipping\\/vendor\\/orders\\/view\\/10\"}', 0, 3, 'done', '2026-08-19 16:54:01', '2026-08-19 17:11:56', '2026-08-19 17:11:58', NULL, '2026-08-19 16:54:01'),
(26, 1, 'email', '{\"job\":\"send_email\",\"to\":\"customer@example.com\",\"subject\":\"\\ud83d\\ude9a Package Dispatched by NovaTech Innovations for Order #MV-ORD-11734\",\"template\":\"vendor_shipment_notice\",\"seller\":\"NovaTech Innovations\",\"carrier\":\"BlueDart\",\"tracking_number\":\"HACK-123\"}', 0, 3, 'done', '2026-08-19 16:54:01', '2026-08-19 17:11:56', '2026-08-19 17:11:58', NULL, '2026-08-19 16:54:01'),
(27, 1, 'email', '{\"job\":\"send_email\",\"to\":\"customer@example.com\",\"subject\":\"\\ud83d\\ude9a Package Dispatched by NovaTech Innovations for Order #MV-ORD-11734\",\"template\":\"vendor_shipment_notice\",\"seller\":\"NovaTech Innovations\",\"carrier\":\"BlueDart Express\",\"tracking_number\":\"BD-NOVA-8812\"}', 0, 3, 'done', '2026-08-19 16:54:01', '2026-08-19 17:11:56', '2026-08-19 17:11:58', NULL, '2026-08-19 16:54:01'),
(28, 1, 'send_email', '{\"job\":\"send_email\",\"to\":\"founder_test@startup.io\",\"subject\":\"Welcome to NovaDrop \\u2014 Elevate Your Daily Performance\",\"body_html\":\"<h2>Welcome to NovaDrop, Aman!<\\/h2><p>We craft ergonomic essentials and precision tools for the modern high-performer.<\\/p><p><a href=\'http:\\/\\/localhost\\/Dropshipping\\/shop\' style=\'background:#4338ca;color:#fff;padding:10px 20px;text-decoration:none;border-radius:6px;\'>Explore Collection &rarr;<\\/a><\\/p>\"}', 0, 3, 'done', '2026-08-19 17:15:35', '2026-08-19 17:17:59', '2026-08-19 17:17:59', NULL, '2026-08-19 17:15:35'),
(29, 1, 'send_email', '{\"job\":\"send_email\",\"to\":\"founder_test@startup.io\",\"subject\":\"Here is your exclusive 10% First Order Welcome Gift: WELCOME10\",\"body_html\":\"<h2>Your Welcome Gift Awaits<\\/h2><p>Use code <strong>WELCOME10<\\/strong> at checkout for 10% off your first order.<\\/p><p><a href=\'http:\\/\\/localhost\\/Dropshipping\\/shop?coupon=WELCOME10\'>Claim Your 10% Discount &rarr;<\\/a><\\/p>\"}', 0, 3, 'done', '2026-08-19 17:15:35', '2026-08-19 17:17:59', '2026-08-19 17:17:59', NULL, '2026-08-19 17:15:35'),
(30, 1, 'send_email', '{\"job\":\"send_email\",\"to\":\"founder_test@startup.io\",\"subject\":\"Welcome to NovaDrop \\u2014 Elevate Your Daily Performance\",\"body_html\":\"<h2>Welcome to NovaDrop, Aman!<\\/h2><p>We craft ergonomic essentials and precision tools for the modern high-performer.<\\/p><p><a href=\'http:\\/\\/localhost\\/Dropshipping\\/shop\' style=\'background:#4338ca;color:#fff;padding:10px 20px;text-decoration:none;border-radius:6px;\'>Explore Collection &rarr;<\\/a><\\/p>\"}', 0, 3, 'done', '2026-08-19 17:15:50', '2026-08-19 17:17:59', '2026-08-19 17:17:59', NULL, '2026-08-19 17:15:50'),
(31, 1, 'send_email', '{\"job\":\"send_email\",\"to\":\"founder_test@startup.io\",\"subject\":\"Here is your exclusive 10% First Order Welcome Gift: WELCOME10\",\"body_html\":\"<h2>Your Welcome Gift Awaits<\\/h2><p>Use code <strong>WELCOME10<\\/strong> at checkout for 10% off your first order.<\\/p><p><a href=\'http:\\/\\/localhost\\/Dropshipping\\/shop?coupon=WELCOME10\'>Claim Your 10% Discount &rarr;<\\/a><\\/p>\"}', 0, 3, 'done', '2026-08-19 17:15:50', '2026-08-19 17:17:59', '2026-08-19 17:17:59', NULL, '2026-08-19 17:15:50'),
(32, 1, 'send_email', '{\"job\":\"send_email\",\"to\":\"founder_test@startup.io\",\"subject\":\"Welcome to NovaDrop \\u2014 Elevate Your Daily Performance\",\"body_html\":\"<h2>Welcome to NovaDrop, Aman!<\\/h2><p>We craft ergonomic essentials and precision tools for the modern high-performer.<\\/p><p><a href=\'http:\\/\\/localhost\\/Dropshipping\\/shop\' style=\'background:#4338ca;color:#fff;padding:10px 20px;text-decoration:none;border-radius:6px;\'>Explore Collection &rarr;<\\/a><\\/p>\"}', 0, 3, 'done', '2026-08-19 17:16:00', '2026-08-19 17:17:59', '2026-08-19 17:17:59', NULL, '2026-08-19 17:16:00'),
(33, 1, 'send_email', '{\"job\":\"send_email\",\"to\":\"founder_test@startup.io\",\"subject\":\"Here is your exclusive 10% First Order Welcome Gift: WELCOME10\",\"body_html\":\"<h2>Your Welcome Gift Awaits<\\/h2><p>Use code <strong>WELCOME10<\\/strong> at checkout for 10% off your first order.<\\/p><p><a href=\'http:\\/\\/localhost\\/Dropshipping\\/shop?coupon=WELCOME10\'>Claim Your 10% Discount &rarr;<\\/a><\\/p>\"}', 0, 3, 'done', '2026-08-19 17:16:00', '2026-08-19 17:17:59', '2026-08-19 17:17:59', NULL, '2026-08-19 17:16:00'),
(34, 1, 'send_email', '{\"job\":\"send_email\",\"to\":\"founder_test@startup.io\",\"subject\":\"Welcome to NovaDrop \\u2014 Elevate Your Daily Performance\",\"body_html\":\"<h2>Welcome to NovaDrop, Aman!<\\/h2><p>We craft ergonomic essentials and precision tools for the modern high-performer.<\\/p><p><a href=\'http:\\/\\/localhost\\/Dropshipping\\/shop\' style=\'background:#4338ca;color:#fff;padding:10px 20px;text-decoration:none;border-radius:6px;\'>Explore Collection &rarr;<\\/a><\\/p>\"}', 0, 3, 'done', '2026-08-19 17:16:34', '2026-08-19 17:17:59', '2026-08-19 17:17:59', NULL, '2026-08-19 17:16:34'),
(35, 1, 'send_email', '{\"job\":\"send_email\",\"to\":\"founder_test@startup.io\",\"subject\":\"Here is your exclusive 10% First Order Welcome Gift: WELCOME10\",\"body_html\":\"<h2>Your Welcome Gift Awaits<\\/h2><p>Use code <strong>WELCOME10<\\/strong> at checkout for 10% off your first order.<\\/p><p><a href=\'http:\\/\\/localhost\\/Dropshipping\\/shop?coupon=WELCOME10\'>Claim Your 10% Discount &rarr;<\\/a><\\/p>\"}', 0, 3, 'done', '2026-08-19 17:16:34', '2026-08-19 17:17:59', '2026-08-19 17:17:59', NULL, '2026-08-19 17:16:34'),
(36, 1, 'send_email', '{\"job\":\"send_email\",\"to\":\"founder_test@startup.io\",\"subject\":\"Welcome to NovaDrop \\u2014 Elevate Your Daily Performance\",\"body_html\":\"<h2>Welcome to NovaDrop, Aman!<\\/h2><p>We craft ergonomic essentials and precision tools for the modern high-performer.<\\/p><p><a href=\'http:\\/\\/localhost\\/Dropshipping\\/shop\' style=\'background:#4338ca;color:#fff;padding:10px 20px;text-decoration:none;border-radius:6px;\'>Explore Collection &rarr;<\\/a><\\/p>\"}', 0, 3, 'done', '2026-08-19 17:17:11', '2026-08-19 17:17:59', '2026-08-19 17:17:59', NULL, '2026-08-19 17:17:11'),
(37, 1, 'send_email', '{\"job\":\"send_email\",\"to\":\"founder_test@startup.io\",\"subject\":\"Here is your exclusive 10% First Order Welcome Gift: WELCOME10\",\"body_html\":\"<h2>Your Welcome Gift Awaits<\\/h2><p>Use code <strong>WELCOME10<\\/strong> at checkout for 10% off your first order.<\\/p><p><a href=\'http:\\/\\/localhost\\/Dropshipping\\/shop?coupon=WELCOME10\'>Claim Your 10% Discount &rarr;<\\/a><\\/p>\"}', 0, 3, 'done', '2026-08-19 17:17:11', '2026-08-19 17:17:59', '2026-08-19 17:17:59', NULL, '2026-08-19 17:17:11'),
(38, 1, 'send_email', '{\"job\":\"send_email\",\"to\":\"founder_test@startup.io\",\"subject\":\"\\u26a1 This Week at NovaDrop: New Ergonomic Releases\",\"body_html\":\"<div style=\'font-family:sans-serif;max-width:600px;margin:auto;\'><h1 style=\'color:#4338ca;\'>NovaDrop Weekly Innovation Digest<\\/h1><p>Here is what\'s new and trending this week in our high-performance workspace catalog:<\\/p><ul><li><strong>AeroWave Active Noise Cancelling Studio Earbuds<\\/strong> \\u2014 \\u20b93,099.00 (<a href=\'http:\\/\\/localhost\\/Dropshipping\\/product\\/aerowave-active-noise-cancelling-studio-earbuds-C-02\'>View Details<\\/a>)<\\/li><li><strong>UltraFast Magnetic Qi2 Wireless Powerbank 10000mAh \\u2014 Next-Gen Edition<\\/strong> \\u2014 \\u20b91,899.00 (<a href=\'http:\\/\\/localhost\\/Dropshipping\\/product\\/ultrafast-magnetic-qi2-wireless-powerbank-10000mah-2-01\'>View Details<\\/a>)<\\/li><li><strong>Mulberry Silk Bias-Cut Slip Dress<\\/strong> \\u2014 \\u20b95,699.00 (<a href=\'http:\\/\\/localhost\\/Dropshipping\\/product\\/mulberry-silk-bias-slip-dress\'>View Details<\\/a>)<\\/li><\\/ul><p><a href=\'http:\\/\\/localhost\\/Dropshipping\\/shop\' style=\'background:#4338ca;color:#fff;padding:10px 18px;text-decoration:none;border-radius:6px;\'>Shop All New Arrivals &rarr;<\\/a><\\/p><hr><small style=\'color:#888;\'>You are receiving this because you subscribed to NovaDrop updates. <a href=\'http:\\/\\/localhost\\/Dropshipping\\/unsubscribe\'>Unsubscribe<\\/a><\\/small><\\/div>\"}', 0, 3, 'done', '2026-08-19 17:25:23', '2026-08-19 17:48:37', '2026-08-19 17:48:37', NULL, '2026-08-19 17:25:23'),
(39, 1, 'email', '{\"job\":\"send_email\",\"order_id\":1,\"template\":\"order_shipped\",\"tracking\":\"CJINDB54D34CCD\",\"carrier\":\"BlueDart \\/ Delhivery Surface\",\"tracking_url\":\"https:\\/\\/track.cjdropshipping.com\\/tracking?num=CJIND\"}', 0, 3, 'done', '2026-08-19 18:51:48', '2026-08-19 18:53:10', '2026-08-19 18:53:12', NULL, '2026-08-19 18:51:48'),
(40, 1, 'email', '{\"job\":\"send_email\",\"order_id\":3,\"template\":\"order_shipped\",\"tracking\":\"CJIND1140648BD\",\"carrier\":\"BlueDart \\/ Delhivery Surface\",\"tracking_url\":\"https:\\/\\/track.cjdropshipping.com\\/tracking?num=CJIND\"}', 0, 3, 'done', '2026-08-19 18:51:48', '2026-08-19 18:53:10', '2026-08-19 18:53:13', NULL, '2026-08-19 18:51:48'),
(41, 1, 'email', '{\"job\":\"send_email\",\"order_id\":4,\"template\":\"order_shipped\",\"tracking\":\"CJIND169A230CF\",\"carrier\":\"BlueDart \\/ Delhivery Surface\",\"tracking_url\":\"https:\\/\\/track.cjdropshipping.com\\/tracking?num=CJIND\"}', 0, 3, 'done', '2026-08-19 18:51:48', '2026-08-19 18:53:10', '2026-08-19 18:53:14', NULL, '2026-08-19 18:51:48'),
(42, 1, 'email', '{\"job\":\"send_email\",\"to\":\"noreply@novadrop.in\",\"name\":\"Store Administrator\",\"subject\":\"\\ud83d\\udcc8 NovaDrop Daily Performance Digest \\u2014 19 Aug 2026\",\"template\":\"daily_digest\",\"summary\":\"\\ud83d\\udcca NovaDrop Daily Executive Digest [19 Aug 2026]:\\n\\u2022 Gross GMV: \\u20b90.00 across 0 orders (AOV: \\u20b90.00)\\n\\u2022 Estimated Net Profit: \\u20b90.00 (Margin ~62.6%)\\n\\u2022 Top Products: No items sold yet today.\\n\\u2022 Critical Low-Stock SKUs: 0 items\\n\\u2022 Failed Payment Alerts: 0\"}', 0, 3, 'done', '2026-08-19 18:51:48', '2026-08-19 18:53:10', '2026-08-19 18:53:14', NULL, '2026-08-19 18:51:48'),
(43, 1, 'email', '{\"job\":\"send_email\",\"to\":\"noreply@novadrop.in\",\"name\":\"Store Administrator\",\"subject\":\"\\ud83d\\udcc8 NovaDrop Daily Performance Digest \\u2014 19 Aug 2026\",\"template\":\"daily_digest\",\"summary\":\"\\ud83d\\udcca NovaDrop Daily Executive Digest [19 Aug 2026]:\\n\\u2022 Gross GMV: \\u20b90.00 across 0 orders (AOV: \\u20b90.00)\\n\\u2022 Estimated Net Profit: \\u20b90.00 (Margin ~62.6%)\\n\\u2022 Top Products: No items sold yet today.\\n\\u2022 Critical Low-Stock SKUs: 0 items\\n\\u2022 Failed Payment Alerts: 0\"}', 0, 3, 'done', '2026-08-19 18:52:32', '2026-08-19 18:53:10', '2026-08-19 18:53:14', NULL, '2026-08-19 18:52:32'),
(44, 1, 'email', '{\"job\":\"send_email\",\"to\":\"noreply@novadrop.in\",\"name\":\"Store Administrator\",\"subject\":\"\\ud83d\\udcc8 NovaDrop Daily Performance Digest \\u2014 19 Aug 2026\",\"template\":\"daily_digest\",\"summary\":\"\\ud83d\\udcca NovaDrop Daily Executive Digest [19 Aug 2026]:\\n\\u2022 Gross GMV: \\u20b90.00 across 0 orders (AOV: \\u20b90.00)\\n\\u2022 Estimated Net Profit: \\u20b90.00 (Margin ~62.6%)\\n\\u2022 Top Products: No items sold yet today.\\n\\u2022 Critical Low-Stock SKUs: 0 items\\n\\u2022 Failed Payment Alerts: 0\"}', 0, 3, 'done', '2026-08-19 18:52:50', '2026-08-19 18:53:10', '2026-08-19 18:53:14', NULL, '2026-08-19 18:52:50'),
(45, 1, 'email', '{\"job\":\"send_email\",\"to\":\"noreply@novadrop.in\",\"name\":\"Store Administrator\",\"subject\":\"\\ud83d\\udcc8 NovaDrop Daily Performance Digest \\u2014 19 Aug 2026\",\"template\":\"daily_digest\",\"summary\":\"\\ud83d\\udcca NovaDrop Daily Executive Digest [19 Aug 2026]:\\n\\u2022 Gross GMV: \\u20b90.00 across 0 orders (AOV: \\u20b90.00)\\n\\u2022 Estimated Net Profit: \\u20b90.00 (Margin ~62.6%)\\n\\u2022 Top Products: No items sold yet today.\\n\\u2022 Critical Low-Stock SKUs: 0 items\\n\\u2022 Failed Payment Alerts: 0\"}', 0, 3, 'done', '2026-08-19 18:53:06', '2026-08-19 18:53:10', '2026-08-19 18:53:14', NULL, '2026-08-19 18:53:06'),
(46, 1, 'fulfillment', '{\"job\":\"vendor_order_routing\",\"order_id\":5}', 0, 3, 'done', '2026-08-19 18:58:41', '2026-08-25 21:33:09', '2026-08-25 21:33:09', NULL, '2026-08-19 18:58:41'),
(47, 1, 'email', '{\"job\":\"send_email\",\"to\":\"kenji@okayama-denim.jp\",\"name\":\"Kenji Takahashi\",\"subject\":\"\\ud83d\\udce6 New Order Assigned: ##01001 \\u2014 Okayama Selvedge Guild\",\"template\":\"vendor_order_notification\",\"order_number\":\"#01001\",\"items\":\"The Atelier Cashmere Cocoon Coat (x1)\",\"vendor_subtotal\":7499,\"action_url\":\"http:\\/\\/localhost\\/Dropshipping\\/vendor\\/orders\\/view\\/5\"}', 0, 3, 'done', '2026-08-19 22:28:41', '2026-08-25 21:33:09', '2026-08-25 21:33:09', NULL, '2026-08-19 22:28:41'),
(48, 1, 'fulfillment', '{\"job\":\"vendor_order_routing\",\"order_id\":6}', 0, 3, 'done', '2026-08-19 19:01:35', '2026-08-25 21:33:09', '2026-08-25 21:33:09', NULL, '2026-08-19 19:01:35'),
(49, 1, 'email', '{\"job\":\"send_email\",\"to\":\"kenji@okayama-denim.jp\",\"name\":\"Kenji Takahashi\",\"subject\":\"\\ud83d\\udce6 New Order Assigned: ##02002 \\u2014 Okayama Selvedge Guild\",\"template\":\"vendor_order_notification\",\"order_number\":\"#02002\",\"items\":\"The Atelier Cashmere Cocoon Coat (x1)\",\"vendor_subtotal\":7499,\"action_url\":\"http:\\/\\/localhost\\/Dropshipping\\/vendor\\/orders\\/view\\/6\"}', 0, 3, 'done', '2026-08-19 22:31:35', '2026-08-25 21:33:09', '2026-08-25 21:33:09', NULL, '2026-08-19 22:31:35'),
(50, 1, 'fulfillment', '{\"job\":\"vendor_order_routing\",\"order_id\":7}', 0, 3, 'done', '2026-08-19 19:01:48', '2026-08-25 21:33:09', '2026-08-25 21:33:09', NULL, '2026-08-19 19:01:48'),
(51, 1, 'email', '{\"job\":\"send_email\",\"to\":\"kenji@okayama-denim.jp\",\"name\":\"Kenji Takahashi\",\"subject\":\"\\ud83d\\udce6 New Order Assigned: ##03003 \\u2014 Okayama Selvedge Guild\",\"template\":\"vendor_order_notification\",\"order_number\":\"#03003\",\"items\":\"The Atelier Cashmere Cocoon Coat (x1)\",\"vendor_subtotal\":7499,\"action_url\":\"http:\\/\\/localhost\\/Dropshipping\\/vendor\\/orders\\/view\\/7\"}', 0, 3, 'done', '2026-08-19 22:31:48', '2026-08-25 21:33:09', '2026-08-25 21:33:09', NULL, '2026-08-19 22:31:48'),
(52, 1, 'email', '{\"job\":\"send_email\",\"to\":\"kenji@okayama-denim.jp\",\"name\":\"Kenji Takahashi\",\"subject\":\"\\ud83d\\udce6 New Order Assigned: ##01001 \\u2014 Okayama Selvedge Guild\",\"template\":\"vendor_order_notification\",\"order_number\":\"#01001\",\"items\":\"The Atelier Cashmere Cocoon Coat (x1)\",\"vendor_subtotal\":7499,\"action_url\":\"http:\\/\\/localhost\\/Dropshipping\\/vendor\\/orders\\/view\\/5\"}', 0, 3, 'pending', '2026-08-25 21:33:09', NULL, NULL, NULL, '2026-08-25 21:33:09'),
(53, 1, 'email', '{\"job\":\"send_email\",\"to\":\"kenji@okayama-denim.jp\",\"name\":\"Kenji Takahashi\",\"subject\":\"\\ud83d\\udce6 New Order Assigned: ##02002 \\u2014 Okayama Selvedge Guild\",\"template\":\"vendor_order_notification\",\"order_number\":\"#02002\",\"items\":\"The Atelier Cashmere Cocoon Coat (x1)\",\"vendor_subtotal\":7499,\"action_url\":\"http:\\/\\/localhost\\/Dropshipping\\/vendor\\/orders\\/view\\/6\"}', 0, 3, 'pending', '2026-08-25 21:33:09', NULL, NULL, NULL, '2026-08-25 21:33:09'),
(54, 1, 'email', '{\"job\":\"send_email\",\"to\":\"kenji@okayama-denim.jp\",\"name\":\"Kenji Takahashi\",\"subject\":\"\\ud83d\\udce6 New Order Assigned: ##03003 \\u2014 Okayama Selvedge Guild\",\"template\":\"vendor_order_notification\",\"order_number\":\"#03003\",\"items\":\"The Atelier Cashmere Cocoon Coat (x1)\",\"vendor_subtotal\":7499,\"action_url\":\"http:\\/\\/localhost\\/Dropshipping\\/vendor\\/orders\\/view\\/7\"}', 0, 3, 'pending', '2026-08-25 21:33:09', NULL, NULL, NULL, '2026-08-25 21:33:09'),
(55, 1, 'email', '{\"job\":\"send_email\",\"to\":\"kenji@okayama-denim.jp\",\"name\":\"Kenji Takahashi\",\"subject\":\"\\ud83d\\udce6 New Order Assigned: ##03003 \\u2014 Okayama Selvedge Guild\",\"template\":\"vendor_order_notification\",\"order_number\":\"#03003\",\"items\":\"The Atelier Cashmere Cocoon Coat (x1)\",\"vendor_subtotal\":7499,\"action_url\":\"http:\\/\\/localhost\\/Dropshipping\\/vendor\\/orders\\/view\\/7\"}', 0, 3, 'pending', '2026-08-25 21:58:10', NULL, NULL, NULL, '2026-08-25 21:58:10'),
(56, 1, 'email', '{\"job\":\"send_email\",\"to\":\"noreply@novadrop.in\",\"name\":\"Store Administrator\",\"subject\":\"\\ud83d\\udcc8 NovaDrop Daily Performance Digest \\u2014 25 Aug 2026\",\"template\":\"daily_digest\",\"summary\":\"\\ud83d\\udcca NovaDrop Daily Executive Digest [25 Aug 2026]:\\n\\u2022 Gross GMV: \\u20b90.00 across 0 orders (AOV: \\u20b90.00)\\n\\u2022 Estimated Net Profit: \\u20b90.00 (Margin ~62.6%)\\n\\u2022 Top Products: No items sold yet today.\\n\\u2022 Critical Low-Stock SKUs: 0 items\\n\\u2022 Failed Payment Alerts: 0\"}', 0, 3, 'pending', '2026-08-25 21:58:10', NULL, NULL, NULL, '2026-08-25 21:58:10'),
(57, 1, 'email', '{\"job\":\"send_email\",\"to\":\"kenji@okayama-denim.jp\",\"name\":\"Kenji Takahashi\",\"subject\":\"\\ud83d\\udce6 New Order Assigned: ##03003 \\u2014 Okayama Selvedge Guild\",\"template\":\"vendor_order_notification\",\"order_number\":\"#03003\",\"items\":\"The Atelier Cashmere Cocoon Coat (x1)\",\"vendor_subtotal\":7499,\"action_url\":\"http:\\/\\/localhost\\/Dropshipping\\/vendor\\/orders\\/view\\/7\"}', 0, 3, 'pending', '2026-08-25 21:58:10', NULL, NULL, NULL, '2026-08-25 21:58:10'),
(58, 1, 'email', '{\"job\":\"send_email\",\"to\":\"kenji@okayama-denim.jp\",\"name\":\"Kenji Takahashi\",\"subject\":\"\\ud83d\\udce6 New Order Assigned: ##03003 \\u2014 Okayama Selvedge Guild\",\"template\":\"vendor_order_notification\",\"order_number\":\"#03003\",\"items\":\"The Atelier Cashmere Cocoon Coat (x1)\",\"vendor_subtotal\":7499,\"action_url\":\"http:\\/\\/localhost\\/Dropshipping\\/vendor\\/orders\\/view\\/7\"}', 0, 3, 'pending', '2026-08-25 21:58:38', NULL, NULL, NULL, '2026-08-25 21:58:38'),
(59, 1, 'email', '{\"job\":\"send_email\",\"to\":\"noreply@novadrop.in\",\"name\":\"Store Administrator\",\"subject\":\"\\ud83d\\udcc8 NovaDrop Daily Performance Digest \\u2014 25 Aug 2026\",\"template\":\"daily_digest\",\"summary\":\"\\ud83d\\udcca NovaDrop Daily Executive Digest [25 Aug 2026]:\\n\\u2022 Gross GMV: \\u20b90.00 across 0 orders (AOV: \\u20b90.00)\\n\\u2022 Estimated Net Profit: \\u20b90.00 (Margin ~62.6%)\\n\\u2022 Top Products: No items sold yet today.\\n\\u2022 Critical Low-Stock SKUs: 0 items\\n\\u2022 Failed Payment Alerts: 0\"}', 0, 3, 'pending', '2026-08-25 21:58:38', NULL, NULL, NULL, '2026-08-25 21:58:38'),
(60, 1, 'email', '{\"job\":\"send_email\",\"to\":\"kenji@okayama-denim.jp\",\"name\":\"Kenji Takahashi\",\"subject\":\"\\ud83d\\udce6 New Order Assigned: ##03003 \\u2014 Okayama Selvedge Guild\",\"template\":\"vendor_order_notification\",\"order_number\":\"#03003\",\"items\":\"The Atelier Cashmere Cocoon Coat (x1)\",\"vendor_subtotal\":7499,\"action_url\":\"http:\\/\\/localhost\\/Dropshipping\\/vendor\\/orders\\/view\\/7\"}', 0, 3, 'pending', '2026-08-25 21:58:38', NULL, NULL, NULL, '2026-08-25 21:58:38'),
(61, 1, 'email', '{\"job\":\"send_email\",\"to\":\"noreply@novadrop.in\",\"name\":\"Store Administrator\",\"subject\":\"\\ud83d\\udcc8 NovaDrop Daily Performance Digest \\u2014 25 Aug 2026\",\"template\":\"daily_digest\",\"summary\":\"\\ud83d\\udcca NovaDrop Daily Executive Digest [25 Aug 2026]:\\n\\u2022 Gross GMV: \\u20b90.00 across 0 orders (AOV: \\u20b90.00)\\n\\u2022 Estimated Net Profit: \\u20b90.00 (Margin ~62.6%)\\n\\u2022 Top Products: No items sold yet today.\\n\\u2022 Critical Low-Stock SKUs: 0 items\\n\\u2022 Failed Payment Alerts: 0\"}', 0, 3, 'pending', '2026-08-25 22:09:06', NULL, NULL, NULL, '2026-08-25 22:09:06'),
(62, 1, 'email', '{\"job\":\"send_email\",\"to\":\"kenji@okayama-denim.jp\",\"name\":\"Kenji Takahashi\",\"subject\":\"\\ud83d\\udce6 New Order Assigned: ##03003 \\u2014 Okayama Selvedge Guild\",\"template\":\"vendor_order_notification\",\"order_number\":\"#03003\",\"items\":\"The Atelier Cashmere Cocoon Coat (x1)\",\"vendor_subtotal\":7499,\"action_url\":\"http:\\/\\/localhost\\/Dropshipping\\/vendor\\/orders\\/view\\/7\"}', 0, 3, 'pending', '2026-08-25 22:09:06', NULL, NULL, NULL, '2026-08-25 22:09:06'),
(63, 1, 'email', '{\"job\":\"send_email\",\"to\":\"admin@novadrop.in\",\"name\":\"Store Administrator\",\"subject\":\"\\ud83d\\udcc8 NovaDrop Daily Performance Digest \\u2014 26 Aug 2026\",\"template\":\"daily_digest\",\"summary\":\"\\ud83d\\udcca NovaDrop Daily Executive Digest [26 Aug 2026]:\\n\\u2022 Gross GMV: \\u20b90.00 across 0 orders (AOV: \\u20b90.00)\\n\\u2022 Estimated Net Profit: \\u20b90.00 (Margin ~62.6%)\\n\\u2022 Top Products: No items sold yet today.\\n\\u2022 Critical Low-Stock SKUs: 0 items\\n\\u2022 Failed Payment Alerts: 0\"}', 0, 3, 'pending', '2026-08-26 21:31:04', NULL, NULL, NULL, '2026-08-26 21:31:04'),
(64, 1, 'email', '{\"job\":\"send_email\",\"to\":\"kenji@okayama-denim.jp\",\"name\":\"Kenji Takahashi\",\"subject\":\"\\ud83d\\udce6 New Order Assigned: ##03003 \\u2014 Okayama Selvedge Guild\",\"template\":\"vendor_order_notification\",\"order_number\":\"#03003\",\"items\":\"The Atelier Cashmere Cocoon Coat (x1)\",\"vendor_subtotal\":7499,\"action_url\":\"http:\\/\\/localhost\\/Dropshipping\\/vendor\\/orders\\/view\\/7\"}', 0, 3, 'pending', '2026-08-26 21:31:04', NULL, NULL, NULL, '2026-08-26 21:31:04'),
(65, 1, 'fulfillment', '{\"job\":\"vendor_order_routing\",\"order_id\":8}', 0, 3, 'pending', '2026-08-26 18:12:09', NULL, NULL, NULL, '2026-08-26 18:12:09'),
(66, 1, 'email', '{\"job\":\"send_email\",\"to\":\"kenji@okayama-denim.jp\",\"name\":\"Kenji Takahashi\",\"subject\":\"\\ud83d\\udce6 New Order Assigned: ##04004 \\u2014 Okayama Selvedge Guild\",\"template\":\"vendor_order_notification\",\"order_number\":\"#04004\",\"items\":\"Sculpted 500 GSM Terry Hoodie (x1)\",\"vendor_subtotal\":2899,\"action_url\":\"http:\\/\\/localhost\\/Dropshipping\\/vendor\\/orders\\/view\\/8\"}', 0, 3, 'pending', '2026-08-26 21:42:09', NULL, NULL, NULL, '2026-08-26 21:42:09'),
(67, 1, 'fulfillment', '{\"job\":\"vendor_order_routing\",\"order_id\":9}', 0, 3, 'pending', '2026-08-26 18:35:01', NULL, NULL, NULL, '2026-08-26 18:35:01'),
(68, 1, 'email', '{\"job\":\"send_email\",\"to\":\"kenji@okayama-denim.jp\",\"name\":\"Kenji Takahashi\",\"subject\":\"\\ud83d\\udce6 New Order Assigned: ##05005 \\u2014 Okayama Selvedge Guild\",\"template\":\"vendor_order_notification\",\"order_number\":\"#05005\",\"items\":\"Sculpted 500 GSM Terry Hoodie (x2)\",\"vendor_subtotal\":5798,\"action_url\":\"http:\\/\\/localhost\\/Dropshipping\\/vendor\\/orders\\/view\\/9\"}', 0, 3, 'pending', '2026-08-26 22:05:01', NULL, NULL, NULL, '2026-08-26 22:05:01');

-- --------------------------------------------------------

--
-- Table structure for table `loyalty_points`
--

CREATE TABLE `loyalty_points` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `points_balance` int(11) NOT NULL DEFAULT 0,
  `lifetime_earned` int(11) NOT NULL DEFAULT 0,
  `lifetime_spent` int(11) NOT NULL DEFAULT 0,
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `loyalty_tiers`
--

CREATE TABLE `loyalty_tiers` (
  `id` int(11) NOT NULL,
  `tier_code` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `min_spend` decimal(12,2) NOT NULL DEFAULT 0.00,
  `points_multiplier` decimal(4,2) NOT NULL DEFAULT 1.00,
  `cashback_percent` decimal(5,2) NOT NULL DEFAULT 5.00,
  `perks` text DEFAULT NULL,
  `color_badge` varchar(50) DEFAULT 'secondary'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `loyalty_tiers`
--

INSERT INTO `loyalty_tiers` (`id`, `tier_code`, `name`, `min_spend`, `points_multiplier`, `cashback_percent`, `perks`, `color_badge`) VALUES
(1, 'silver', 'Silver Member', 0.00, 1.00, 5.00, '5% Point Cashback, Seasonal Lookbooks', 'secondary'),
(2, 'gold', 'Gold Connoisseur', 15000.00, 1.50, 7.50, '1.5x Points Multiplier, 24H Early Access to Drops', 'warning'),
(3, 'platinum', 'Platinum Atelier', 50000.00, 2.00, 10.00, '2.0x Points Multiplier, Free Express Shipping, Stylist Consultation', 'primary'),
(4, 'diamond', 'Black Diamond VIP', 150000.00, 3.00, 15.00, '3.0x Points Multiplier, Bespoke Atelier Sizing, Dedicated Concierge', 'dark');

-- --------------------------------------------------------

--
-- Table structure for table `loyalty_transactions`
--

CREATE TABLE `loyalty_transactions` (
  `id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT 1,
  `customer_id` int(11) NOT NULL,
  `points` int(11) NOT NULL,
  `type` enum('credit','debit') DEFAULT 'credit',
  `reason` varchar(255) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `message_frequency_log`
--

CREATE TABLE `message_frequency_log` (
  `id` bigint(20) NOT NULL,
  `recipient_phone` varchar(30) NOT NULL,
  `recipient_email` varchar(191) DEFAULT NULL,
  `channel` enum('whatsapp','sms','email') NOT NULL DEFAULT 'whatsapp',
  `automation_type` varchar(80) NOT NULL,
  `template_key` varchar(80) NOT NULL,
  `sent_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mystery_drops`
--

CREATE TABLE `mystery_drops` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `tier` varchar(50) DEFAULT 'gold',
  `price` decimal(10,2) DEFAULT 1299.00,
  `qty_total` int(11) DEFAULT 50,
  `qty_sold` int(11) DEFAULT 0,
  `reveal_at` datetime NOT NULL DEFAULT (current_timestamp() + interval 7 day),
  `status` enum('upcoming','live','revealed','sold_out') DEFAULT 'upcoming',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mystery_drops`
--

INSERT INTO `mystery_drops` (`id`, `name`, `tier`, `price`, `qty_total`, `qty_sold`, `reveal_at`, `status`, `created_at`) VALUES
(1, 'Atelier Obsidian Mystery Box', 'black_diamond', 2499.00, 30, 18, '2026-08-28 01:35:55', 'live', '2026-08-26 01:35:55'),
(2, 'Lumina Gold Capsule Collection', 'gold', 1299.00, 50, 44, '2026-08-31 01:35:55', 'live', '2026-08-26 01:35:55'),
(3, 'Silver Wardrobe Surprise Drop', 'silver', 799.00, 100, 67, '2026-09-05 01:35:55', 'upcoming', '2026-08-26 01:35:55');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(10) UNSIGNED NOT NULL,
  `store_id` int(10) UNSIGNED NOT NULL,
  `customer_id` int(10) UNSIGNED DEFAULT NULL,
  `guest_email` varchar(255) DEFAULT NULL,
  `order_number` varchar(30) NOT NULL,
  `status` enum('pending','paid','processing','shipped','delivered','refunded','cancelled','on_hold') NOT NULL DEFAULT 'pending',
  `payment_status` enum('unpaid','paid','partially_refunded','fully_refunded','voided') NOT NULL DEFAULT 'unpaid',
  `fulfillment_status` enum('unfulfilled','partial','fulfilled','returned') NOT NULL DEFAULT 'unfulfilled',
  `subtotal` decimal(12,2) NOT NULL DEFAULT 0.00,
  `discount_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `shipping_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `tax_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `cgst_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `sgst_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `igst_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `total` decimal(12,2) NOT NULL DEFAULT 0.00,
  `currency` char(3) NOT NULL DEFAULT 'INR',
  `payment_method` varchar(60) DEFAULT 'razorpay',
  `shipping_address_json` longtext DEFAULT NULL,
  `billing_address_id` int(10) UNSIGNED DEFAULT NULL,
  `shipping_address_id` int(10) UNSIGNED DEFAULT NULL,
  `tracking_number` varchar(120) DEFAULT NULL,
  `discount_code` varchar(80) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `tags` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`tags`)),
  `risk_level` enum('low','medium','high') NOT NULL DEFAULT 'low',
  `risk_flags` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`risk_flags`)),
  `source` varchar(30) NOT NULL DEFAULT 'storefront',
  `cart_id` char(36) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` varchar(500) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `store_id`, `customer_id`, `guest_email`, `order_number`, `status`, `payment_status`, `fulfillment_status`, `subtotal`, `discount_amount`, `shipping_amount`, `tax_amount`, `cgst_amount`, `sgst_amount`, `igst_amount`, `total`, `currency`, `payment_method`, `shipping_address_json`, `billing_address_id`, `shipping_address_id`, `tracking_number`, `discount_code`, `notes`, `tags`, `risk_level`, `risk_flags`, `source`, `cart_id`, `ip_address`, `user_agent`, `created_at`, `updated_at`) VALUES
(5, 1, NULL, 'uniyalasmit864@gmail.com', '#01001', 'pending', 'unpaid', 'unfulfilled', 7499.00, 0.00, 0.00, 1143.92, 571.96, 571.96, 0.00, 7499.00, 'INR', 'razorpay', NULL, 1, 1, NULL, NULL, NULL, NULL, 'low', NULL, 'storefront', 'b0ac54eb-4c55-436f-a4a2-e4fcb92bc639', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-19 18:58:41', '2026-08-19 18:58:41'),
(6, 1, NULL, 'uniyalasmit864@gmail.com', '#02002', 'pending', 'unpaid', 'unfulfilled', 7499.00, 0.00, 0.00, 1143.92, 571.96, 571.96, 0.00, 7499.00, 'INR', 'razorpay', NULL, 2, 2, NULL, NULL, NULL, NULL, 'low', NULL, 'storefront', 'b0ac54eb-4c55-436f-a4a2-e4fcb92bc639', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-19 19:01:35', '2026-08-19 19:01:35'),
(7, 1, NULL, 'uniyalasmit864@gmail.com', '#03003', 'processing', 'unpaid', 'fulfilled', 7499.00, 0.00, 0.00, 1143.92, 571.96, 571.96, 0.00, 7499.00, 'INR', 'razorpay', NULL, 3, 3, 'CJ-AWB-756121', NULL, NULL, NULL, 'medium', '[\"High-value first-time purchase (\\u20b97,499.00) with 0 prior transaction history\"]', 'storefront', 'b0ac54eb-4c55-436f-a4a2-e4fcb92bc639', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-19 19:01:48', '2026-08-25 21:58:38'),
(8, 1, NULL, '9702359244@lumina-atelier.com', '#04004', 'pending', 'unpaid', 'unfulfilled', 2899.00, 0.00, 0.00, 442.22, 0.00, 0.00, 442.22, 2899.00, 'INR', 'razorpay', NULL, 4, 4, NULL, NULL, NULL, NULL, 'low', NULL, 'storefront', 'b78dacec-3cb2-4649-9667-64ed9a745dc9', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-26 18:12:09', '2026-08-26 18:12:09'),
(9, 1, NULL, '9702359244@lumina-atelier.com', '#05005', 'pending', 'unpaid', 'unfulfilled', 5798.00, 0.00, 0.00, 884.44, 0.00, 0.00, 884.44, 5798.00, 'INR', 'razorpay', NULL, 5, 5, NULL, NULL, NULL, NULL, 'low', NULL, 'storefront', 'b78dacec-3cb2-4649-9667-64ed9a745dc9', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', '2026-08-26 18:35:01', '2026-08-26 18:35:01');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED NOT NULL,
  `vendor_id` int(11) DEFAULT NULL,
  `variant_id` int(10) UNSIGNED DEFAULT NULL,
  `product_title` varchar(500) NOT NULL,
  `variant_title` varchar(255) DEFAULT NULL,
  `sku` varchar(120) DEFAULT NULL,
  `quantity` smallint(6) NOT NULL,
  `unit_price` decimal(12,2) NOT NULL,
  `total_price` decimal(12,2) NOT NULL,
  `vendor_commission_amount` decimal(12,2) DEFAULT 0.00,
  `vendor_fulfillment_status` enum('unfulfilled','processing','shipped','delivered','cancelled') DEFAULT 'unfulfilled',
  `vendor_carrier` varchar(80) DEFAULT NULL,
  `vendor_tracking_number` varchar(120) DEFAULT NULL,
  `vendor_shipped_at` datetime DEFAULT NULL,
  `cost_price` decimal(12,2) DEFAULT NULL,
  `fulfillment_status` enum('unfulfilled','fulfilled','returned') NOT NULL DEFAULT 'unfulfilled'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `vendor_id`, `variant_id`, `product_title`, `variant_title`, `sku`, `quantity`, `unit_price`, `total_price`, `vendor_commission_amount`, `vendor_fulfillment_status`, `vendor_carrier`, `vendor_tracking_number`, `vendor_shipped_at`, `cost_price`, `fulfillment_status`) VALUES
(5, 5, 2, 9, 'The Atelier Cashmere Cocoon Coat', 'Medium / Midnight Black', 'LUM-ATELI-E23F', 1, 7499.00, 7499.00, 899.88, 'unfulfilled', NULL, NULL, NULL, 2999.60, 'unfulfilled'),
(6, 6, 2, 9, 'The Atelier Cashmere Cocoon Coat', 'Medium / Midnight Black', 'LUM-ATELI-E23F', 1, 7499.00, 7499.00, 899.88, 'unfulfilled', NULL, NULL, NULL, 2999.60, 'unfulfilled'),
(7, 7, 2, 9, 'The Atelier Cashmere Cocoon Coat', 'Medium / Midnight Black', 'LUM-ATELI-E23F', 1, 7499.00, 7499.00, 899.88, 'unfulfilled', NULL, NULL, NULL, 2999.60, 'unfulfilled'),
(8, 8, 2, 458, 'Sculpted 500 GSM Terry Hoodie', 'Tailored Standard', 'LUMINA-003', 1, 2899.00, 2899.00, 347.88, 'unfulfilled', NULL, NULL, NULL, 1154.65, 'unfulfilled'),
(9, 9, 2, 458, 'Sculpted 500 GSM Terry Hoodie', 'Tailored Standard', 'LUMINA-003', 2, 2899.00, 5798.00, 695.76, 'unfulfilled', NULL, NULL, NULL, 1154.65, 'unfulfilled');

-- --------------------------------------------------------

--
-- Table structure for table `order_timeline`
--

CREATE TABLE `order_timeline` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED NOT NULL,
  `actor_type` enum('system','admin','customer','supplier') NOT NULL DEFAULT 'system',
  `actor_id` int(10) UNSIGNED DEFAULT NULL,
  `event` varchar(120) NOT NULL,
  `detail` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_timeline`
--

INSERT INTO `order_timeline` (`id`, `order_id`, `actor_type`, `actor_id`, `event`, `detail`, `created_at`) VALUES
(1, 1, 'system', NULL, 'order.created', 'Order #ND-1001 created and payment verified via UPI.', '2026-08-18 18:50:07'),
(2, 2, 'system', NULL, 'order.created', 'Order #ND-1002 created and payment verified via UPI.', '2026-08-17 18:50:07'),
(3, 2, '', NULL, 'order.shipped', 'Dispatched by vendor via BlueDart Express (AWB: BD982347101IN)', '2026-08-19 18:50:07'),
(4, 3, 'system', NULL, 'order.created', 'Order #ND-1003 created and payment verified via UPI.', '2026-08-16 18:50:07'),
(5, 4, 'system', NULL, 'order.created', 'Order #ND-1004 created and payment verified via UPI.', '2026-08-15 18:50:07'),
(6, 1, 'system', NULL, 'fulfillment.supplier_pushed', 'Order pushed to supplier fulfillment hub. Reference ID: CJ-ORD-3BDF57AA6D', '2026-08-19 18:51:48'),
(7, 1, 'system', NULL, 'fulfillment.dispatched', 'Package handed over to BlueDart / Delhivery Surface. Tracking AWB: CJINDB54D34CCD', '2026-08-19 18:51:48'),
(8, 3, 'system', NULL, 'fulfillment.dispatched', 'Package handed over to BlueDart / Delhivery Surface. Tracking AWB: CJIND1140648BD', '2026-08-19 18:51:48'),
(9, 4, 'system', NULL, 'fulfillment.supplier_pushed', 'Order pushed to supplier fulfillment hub. Reference ID: CJ-ORD-588EB02EAD', '2026-08-19 18:51:48'),
(10, 4, 'system', NULL, 'fulfillment.dispatched', 'Package handed over to BlueDart / Delhivery Surface. Tracking AWB: CJIND169A230CF', '2026-08-19 18:51:48'),
(11, 5, 'system', NULL, 'order.created', 'Order #01001 created.', '2026-08-19 18:58:41'),
(12, 5, 'system', NULL, 'vendor.order_routed', 'Order routed to Marketplace Seller \'Okayama Selvedge Guild\' (1 item(s)).', '2026-08-19 22:28:41'),
(13, 6, 'system', NULL, 'order.created', 'Order #02002 created.', '2026-08-19 19:01:35'),
(14, 6, 'system', NULL, 'vendor.order_routed', 'Order routed to Marketplace Seller \'Okayama Selvedge Guild\' (1 item(s)).', '2026-08-19 22:31:35'),
(15, 7, 'system', NULL, 'order.created', 'Order #03003 created.', '2026-08-19 19:01:48'),
(16, 7, 'system', NULL, 'vendor.order_routed', 'Order routed to Marketplace Seller \'Okayama Selvedge Guild\' (1 item(s)).', '2026-08-19 22:31:48'),
(17, 5, 'system', NULL, 'vendor.order_routed', 'Order routed to Marketplace Seller \'Okayama Selvedge Guild\' (1 item(s)).', '2026-08-25 21:33:09'),
(18, 6, 'system', NULL, 'vendor.order_routed', 'Order routed to Marketplace Seller \'Okayama Selvedge Guild\' (1 item(s)).', '2026-08-25 21:33:09'),
(19, 7, 'system', NULL, 'vendor.order_routed', 'Order routed to Marketplace Seller \'Okayama Selvedge Guild\' (1 item(s)).', '2026-08-25 21:33:09'),
(20, 7, 'system', NULL, 'vendor.order_routed', 'Order routed to Marketplace Seller \'Okayama Selvedge Guild\' (1 item(s)).', '2026-08-25 21:58:10'),
(21, 7, 'system', NULL, 'vendor.order_routed', 'Order routed to Marketplace Seller \'Okayama Selvedge Guild\' (1 item(s)).', '2026-08-25 21:58:10'),
(22, 7, 'system', NULL, 'vendor.order_routed', 'Order routed to Marketplace Seller \'Okayama Selvedge Guild\' (1 item(s)).', '2026-08-25 21:58:38'),
(23, 7, 'system', NULL, 'vendor.order_routed', 'Order routed to Marketplace Seller \'Okayama Selvedge Guild\' (1 item(s)).', '2026-08-25 21:58:38'),
(24, 7, 'system', NULL, 'vendor.order_routed', 'Order routed to Marketplace Seller \'Okayama Selvedge Guild\' (1 item(s)).', '2026-08-25 22:09:06'),
(25, 7, 'system', NULL, 'vendor.order_routed', 'Order routed to Marketplace Seller \'Okayama Selvedge Guild\' (1 item(s)).', '2026-08-26 21:31:04'),
(26, 8, 'system', NULL, 'order.created', 'Order #04004 created.', '2026-08-26 18:12:09'),
(27, 8, 'system', NULL, 'vendor.order_routed', 'Order routed to Marketplace Seller \'Okayama Selvedge Guild\' (1 item(s)).', '2026-08-26 21:42:09'),
(28, 9, 'system', NULL, 'order.created', 'Order #05005 created.', '2026-08-26 18:35:01'),
(29, 9, 'system', NULL, 'vendor.order_routed', 'Order routed to Marketplace Seller \'Okayama Selvedge Guild\' (1 item(s)).', '2026-08-26 22:05:01');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(11) NOT NULL,
  `pageid` varchar(64) DEFAULT '',
  `funord` int(11) DEFAULT 0,
  `position` varchar(50) DEFAULT 'sidebar',
  `pname` varchar(255) DEFAULT '',
  `url` varchar(255) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `page_views`
--

CREATE TABLE `page_views` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `store_id` int(10) UNSIGNED NOT NULL,
  `session_id` varchar(64) NOT NULL,
  `customer_id` int(10) UNSIGNED DEFAULT NULL,
  `path` varchar(500) NOT NULL,
  `referrer` varchar(500) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED NOT NULL,
  `store_id` int(10) UNSIGNED NOT NULL,
  `gateway` enum('razorpay','stripe','cod','wallet') NOT NULL,
  `gateway_payment_id` varchar(120) DEFAULT NULL,
  `gateway_order_id` varchar(120) DEFAULT NULL,
  `amount` decimal(12,2) NOT NULL,
  `currency` char(3) NOT NULL DEFAULT 'INR',
  `status` enum('created','authorized','captured','failed','refunded') NOT NULL DEFAULT 'created',
  `webhook_verified` tinyint(1) NOT NULL DEFAULT 0,
  `raw_response` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`raw_response`)),
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `order_id`, `store_id`, `gateway`, `gateway_payment_id`, `gateway_order_id`, `amount`, `currency`, `status`, `webhook_verified`, `raw_response`, `created_at`, `updated_at`) VALUES
(1, 7, 1, 'cod', NULL, NULL, 7499.00, 'INR', 'created', 0, NULL, '2026-08-19 19:01:48', '2026-08-19 22:31:48'),
(2, 8, 1, 'cod', NULL, NULL, 2899.00, 'INR', 'created', 0, NULL, '2026-08-26 18:12:09', '2026-08-26 21:42:09'),
(3, 9, 1, 'cod', NULL, NULL, 5798.00, 'INR', 'created', 0, NULL, '2026-08-26 18:35:01', '2026-08-26 22:05:01');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(120) NOT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `description`) VALUES
(1, '*', 'Full access'),
(2, 'products.view', 'View products'),
(3, 'products.edit', 'Create and edit products'),
(4, 'products.delete', 'Delete products'),
(5, 'orders.view', 'View orders'),
(6, 'orders.edit', 'Edit order status'),
(7, 'orders.refund', 'Process refunds'),
(8, 'customers.view', 'View customers'),
(9, 'customers.edit', 'Edit customers'),
(10, 'discounts.edit', 'Create/edit discounts'),
(11, 'suppliers.edit', 'Manage suppliers'),
(12, 'settings.edit', 'Edit store settings'),
(13, 'users.edit', 'Manage admin users'),
(14, 'audit.view', 'View audit log'),
(15, 'analytics.view', 'View analytics');

-- --------------------------------------------------------

--
-- Table structure for table `pimage`
--

CREATE TABLE `pimage` (
  `id` int(11) NOT NULL,
  `admid` varchar(64) DEFAULT NULL,
  `pcid` varchar(64) NOT NULL,
  `ccid` varchar(64) NOT NULL,
  `imid` varchar(64) NOT NULL,
  `category` varchar(64) DEFAULT NULL,
  `iname` varchar(255) DEFAULT NULL,
  `image` longblob DEFAULT NULL,
  `date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pre_orders`
--

CREATE TABLE `pre_orders` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT 0,
  `product_name` varchar(255) NOT NULL,
  `price` decimal(10,2) DEFAULT 999.00,
  `deposit_pct` int(11) DEFAULT 25,
  `expected_ship` date NOT NULL,
  `total_reserved` int(11) DEFAULT 0,
  `qty_limit` int(11) DEFAULT 100,
  `status` enum('open','closed','shipped') DEFAULT 'open',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pre_orders`
--

INSERT INTO `pre_orders` (`id`, `product_id`, `product_name`, `price`, `deposit_pct`, `expected_ship`, `total_reserved`, `qty_limit`, `status`, `created_at`) VALUES
(1, 0, 'Lumina Autumn Collection 2026', 2999.00, 30, '2026-09-20', 67, 100, 'open', '2026-08-26 01:35:55'),
(2, 0, 'Obsidian Winter Capsule', 4999.00, 25, '2026-10-10', 38, 50, 'open', '2026-08-26 01:35:55'),
(3, 0, 'Spring Lookbook Pre-Drop', 1299.00, 20, '2026-09-10', 120, 200, 'closed', '2026-08-26 01:35:55');

-- --------------------------------------------------------

--
-- Table structure for table `price_drop_alert_log`
--

CREATE TABLE `price_drop_alert_log` (
  `id` bigint(20) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `wishlist_price` decimal(12,2) NOT NULL,
  `drop_price` decimal(12,2) NOT NULL,
  `sent_at` datetime DEFAULT NULL,
  `status` enum('pending','sent','purchased') DEFAULT 'pending',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pricing_audit_log`
--

CREATE TABLE `pricing_audit_log` (
  `id` bigint(20) NOT NULL,
  `store_id` int(11) DEFAULT 1,
  `product_id` int(11) NOT NULL,
  `variant_id` int(11) DEFAULT NULL,
  `old_price` decimal(12,2) NOT NULL,
  `new_price` decimal(12,2) NOT NULL,
  `old_compare_price` decimal(12,2) DEFAULT NULL,
  `new_compare_price` decimal(12,2) DEFAULT NULL,
  `cost_price` decimal(12,2) DEFAULT NULL,
  `margin_pct` decimal(6,2) DEFAULT NULL,
  `reason` varchar(255) NOT NULL,
  `actor_type` varchar(60) NOT NULL DEFAULT 'DynamicPricingAgent',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pricing_audit_log`
--

INSERT INTO `pricing_audit_log` (`id`, `store_id`, `product_id`, `variant_id`, `old_price`, `new_price`, `old_compare_price`, `new_compare_price`, `cost_price`, `margin_pct`, `reason`, `actor_type`, `created_at`) VALUES
(1, 1, 14, NULL, 1999.00, 3999.00, NULL, NULL, 1800.00, 60.00, 'Supplier Cost Surge - Automated Margin Guard Protection', 'CjSupplierAdapter', '2026-08-19 16:38:10'),
(2, 1, 14, 24, 3999.00, 1899.00, 5399.00, 2564.00, 750.00, 60.51, 'Autonomous Elasticity Optimization (Margin: 60.51%, Floor: 40%)', 'DynamicPricingAgent', '2026-08-19 16:38:10'),
(3, 1, 15, 25, 3199.00, 3099.00, 4319.00, 4184.00, 1200.00, 61.28, 'Autonomous Elasticity Optimization (Margin: 61.28%, Floor: 40%)', 'DynamicPricingAgent', '2026-08-19 16:47:11'),
(4, 1, 1, 1, 2499.99, 2499.00, 3499.00, 3374.00, 999.60, 60.00, 'Autonomous Elasticity Optimization (Margin: 60%, Floor: 40%)', 'DynamicPricingAgent', '2026-08-19 16:47:11'),
(5, 1, 3, 3, 1899.99, 1899.00, 2564.00, 2564.00, 759.60, 60.00, 'Autonomous Elasticity Optimization (Margin: 60%, Floor: 40%)', 'DynamicPricingAgent', '2026-08-19 16:47:11'),
(6, 1, 4, 4, 1299.99, 1299.00, 1754.00, 1754.00, 519.60, 60.00, 'Autonomous Elasticity Optimization (Margin: 60%, Floor: 40%)', 'DynamicPricingAgent', '2026-08-19 16:47:11'),
(7, 1, 5, 5, 1599.99, 1599.00, 2159.00, 2159.00, 639.60, 60.00, 'Autonomous Elasticity Optimization (Margin: 60%, Floor: 40%)', 'DynamicPricingAgent', '2026-08-19 16:47:11'),
(8, 1, 6, 6, 7499.99, 7499.00, 10124.00, 10124.00, 2999.60, 60.00, 'Autonomous Elasticity Optimization (Margin: 60%, Floor: 40%)', 'DynamicPricingAgent', '2026-08-19 16:47:11'),
(9, 1, 6, 7, 7499.99, 7499.00, 10124.00, 10124.00, 2999.60, 60.00, 'Autonomous Elasticity Optimization (Margin: 60%, Floor: 40%)', 'DynamicPricingAgent', '2026-08-19 16:47:11'),
(10, 1, 6, 8, 7499.99, 7499.00, 10124.00, 10124.00, 2999.60, 60.00, 'Autonomous Elasticity Optimization (Margin: 60%, Floor: 40%)', 'DynamicPricingAgent', '2026-08-19 16:47:11'),
(11, 1, 6, 9, 7499.99, 7499.00, 10124.00, 10124.00, 2999.60, 60.00, 'Autonomous Elasticity Optimization (Margin: 60%, Floor: 40%)', 'DynamicPricingAgent', '2026-08-19 16:47:11'),
(12, 1, 7, 10, 3299.99, 3299.00, 4454.00, 4454.00, 1319.60, 60.00, 'Autonomous Elasticity Optimization (Margin: 60%, Floor: 40%)', 'DynamicPricingAgent', '2026-08-19 16:47:11'),
(13, 1, 7, 11, 3299.99, 3299.00, 4454.00, 4454.00, 1319.60, 60.00, 'Autonomous Elasticity Optimization (Margin: 60%, Floor: 40%)', 'DynamicPricingAgent', '2026-08-19 16:47:11'),
(14, 1, 7, 12, 3299.99, 3299.00, 4454.00, 4454.00, 1319.60, 60.00, 'Autonomous Elasticity Optimization (Margin: 60%, Floor: 40%)', 'DynamicPricingAgent', '2026-08-19 16:47:11'),
(15, 1, 7, 13, 3299.99, 3299.00, 4454.00, 4454.00, 1319.60, 60.00, 'Autonomous Elasticity Optimization (Margin: 60%, Floor: 40%)', 'DynamicPricingAgent', '2026-08-19 16:47:11'),
(16, 1, 8, 14, 4899.99, 4899.00, 6614.00, 6614.00, 1959.60, 60.00, 'Autonomous Elasticity Optimization (Margin: 60%, Floor: 40%)', 'DynamicPricingAgent', '2026-08-19 16:47:11'),
(17, 1, 8, 15, 4899.99, 4899.00, 6614.00, 6614.00, 1959.60, 60.00, 'Autonomous Elasticity Optimization (Margin: 60%, Floor: 40%)', 'DynamicPricingAgent', '2026-08-19 16:47:11'),
(18, 1, 8, 16, 4899.99, 4899.00, 6614.00, 6614.00, 1959.60, 60.00, 'Autonomous Elasticity Optimization (Margin: 60%, Floor: 40%)', 'DynamicPricingAgent', '2026-08-19 16:47:11'),
(19, 1, 8, 17, 4899.99, 4899.00, 6614.00, 6614.00, 1959.60, 60.00, 'Autonomous Elasticity Optimization (Margin: 60%, Floor: 40%)', 'DynamicPricingAgent', '2026-08-19 16:47:11'),
(20, 1, 9, 18, 5699.99, 5699.00, 7694.00, 7694.00, 2279.60, 60.00, 'Autonomous Elasticity Optimization (Margin: 60%, Floor: 40%)', 'DynamicPricingAgent', '2026-08-19 16:47:11'),
(21, 1, 9, 19, 5699.99, 5699.00, 7694.00, 7694.00, 2279.60, 60.00, 'Autonomous Elasticity Optimization (Margin: 60%, Floor: 40%)', 'DynamicPricingAgent', '2026-08-19 16:47:11'),
(22, 1, 9, 20, 5699.99, 5699.00, 7694.00, 7694.00, 2279.60, 60.00, 'Autonomous Elasticity Optimization (Margin: 60%, Floor: 40%)', 'DynamicPricingAgent', '2026-08-19 16:47:11'),
(23, 1, 9, 21, 5699.99, 5699.00, 7694.00, 7694.00, 2279.60, 60.00, 'Autonomous Elasticity Optimization (Margin: 60%, Floor: 40%)', 'DynamicPricingAgent', '2026-08-19 16:47:11'),
(24, 1, 1, 456, 4999.00, 4399.00, 8999.00, 5939.00, 1749.65, 60.23, 'Autonomous Elasticity Optimization (Margin: 60.23%, Floor: 40%)', 'DynamicPricingAgent', '2026-08-25 21:52:37'),
(25, 1, 2, 457, 4899.00, 4299.00, 7999.00, 5804.00, 1714.65, 60.12, 'Autonomous Elasticity Optimization (Margin: 60.12%, Floor: 40%)', 'DynamicPricingAgent', '2026-08-25 21:52:37'),
(26, 1, 3, 458, 3299.00, 2899.00, 5499.00, 3914.00, 1154.65, 60.17, 'Autonomous Elasticity Optimization (Margin: 60.17%, Floor: 40%)', 'DynamicPricingAgent', '2026-08-25 21:52:37'),
(27, 1, 4, 459, 5699.00, 4999.00, 9499.00, 6749.00, 1994.65, 60.10, 'Autonomous Elasticity Optimization (Margin: 60.1%, Floor: 40%)', 'DynamicPricingAgent', '2026-08-25 21:52:37'),
(28, 1, 5, 460, 7999.00, 6999.00, 13999.00, 9449.00, 2799.65, 60.00, 'Autonomous Elasticity Optimization (Margin: 60%, Floor: 40%)', 'DynamicPricingAgent', '2026-08-25 21:52:37'),
(29, 1, 6, 461, 6499.00, 5699.00, 11999.00, 7694.00, 2274.65, 60.09, 'Autonomous Elasticity Optimization (Margin: 60.09%, Floor: 40%)', 'DynamicPricingAgent', '2026-08-25 21:52:37'),
(30, 1, 7, 462, 3899.00, 3499.00, 6999.00, 4724.00, 1364.65, 61.00, 'Autonomous Elasticity Optimization (Margin: 61%, Floor: 40%)', 'DynamicPricingAgent', '2026-08-25 21:52:37'),
(31, 1, 8, 463, 5999.00, 5299.00, 9999.00, 7154.00, 2099.65, 60.38, 'Autonomous Elasticity Optimization (Margin: 60.38%, Floor: 40%)', 'DynamicPricingAgent', '2026-08-25 21:52:37'),
(32, 1, 9, 464, 4299.00, 3799.00, 6999.00, 5129.00, 1504.65, 60.39, 'Autonomous Elasticity Optimization (Margin: 60.39%, Floor: 40%)', 'DynamicPricingAgent', '2026-08-25 21:52:37'),
(33, 1, 10, 465, 3999.00, 3499.00, 6999.00, 4724.00, 1399.65, 60.00, 'Autonomous Elasticity Optimization (Margin: 60%, Floor: 40%)', 'DynamicPricingAgent', '2026-08-25 21:52:37'),
(34, 1, 10, 465, 399.00, 3499.00, 4724.00, 4724.00, 1399.65, 60.00, 'Autonomous Elasticity Optimization (Margin: 60%, Floor: 40%)', 'DynamicPricingAgent', '2026-08-26 21:31:04');

-- --------------------------------------------------------

--
-- Table structure for table `pricing_rules`
--

CREATE TABLE `pricing_rules` (
  `id` int(10) UNSIGNED NOT NULL,
  `store_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(120) NOT NULL,
  `type` enum('percentage','fixed','tiered') NOT NULL,
  `cost_min` decimal(12,2) DEFAULT NULL,
  `cost_max` decimal(12,2) DEFAULT NULL,
  `markup_value` decimal(10,4) NOT NULL,
  `rounding` enum('none','up_9','up_99','up_0') NOT NULL DEFAULT 'up_99',
  `currency_from` char(3) NOT NULL DEFAULT 'USD',
  `currency_to` char(3) NOT NULL DEFAULT 'INR',
  `fx_rate` decimal(12,6) NOT NULL DEFAULT 1.000000,
  `fx_updated_at` datetime DEFAULT NULL,
  `priority` tinyint(4) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pricing_rules`
--

INSERT INTO `pricing_rules` (`id`, `store_id`, `name`, `type`, `cost_min`, `cost_max`, `markup_value`, `rounding`, `currency_from`, `currency_to`, `fx_rate`, `fx_updated_at`, `priority`, `is_active`, `created_at`) VALUES
(1, 1, 'Default 3x Markup (USD→INR)', 'percentage', NULL, NULL, 300.0000, 'up_99', 'USD', 'INR', 84.000000, NULL, 0, 1, '2026-08-19 11:35:29'),
(2, 1, 'Default 3x Markup (USD→INR)', 'percentage', NULL, NULL, 300.0000, 'up_99', 'USD', 'INR', 84.000000, NULL, 0, 1, '2026-08-19 11:42:28');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `admid` varchar(64) DEFAULT NULL,
  `pcid` varchar(64) NOT NULL,
  `ccid` varchar(64) NOT NULL,
  `keyword` varchar(255) DEFAULT NULL,
  `category` varchar(64) NOT NULL,
  `pname` varchar(255) NOT NULL,
  `descp` text DEFAULT NULL,
  `color` varchar(100) DEFAULT 'Default',
  `ccode` varchar(50) DEFAULT '#000000',
  `mrp` decimal(10,2) NOT NULL DEFAULT 0.00,
  `disc` decimal(10,2) NOT NULL DEFAULT 0.00,
  `date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `admid`, `pcid`, `ccid`, `keyword`, `category`, `pname`, `descp`, `color`, `ccode`, `mrp`, `disc`, `date`) VALUES
(1, '67ac7cf58dfc4', 'cat_1', 'prod_1', NULL, 'cat_1', 'The Atelier Cashmere Cocoon Coat', 'Hand-cut from 700 GSM Grade-A Mongolian cashmere with double-faced seams and water buffalo horn buttons. Museum-grade thermal efficiency with zero synthetic chemicals.', 'Default', '#000000', 399.00, 0.00, '2026-08-19 14:52:00'),
(2, '67ac7cf58dfc4', 'cat_2', 'prod_3', NULL, 'cat_2', 'Minimalist Chronograph Matte Black Watch', 'Sleek Scandinavian design meets precision Japanese quartz movement. Built with surgical-grade 316L stainless steel, sapphire crystal glass, and interchangeable Italian leather straps.', 'Default', '#000000', 1899.00, 0.00, '2026-08-19 14:52:00'),
(3, '67ac7cf58dfc4', 'cat_3', 'prod_4', NULL, 'cat_3', 'Smart Ambient RGB Desk Atmosphere Lamp', 'Transform your workspace with 16 million colors, music sync visualization, and custom sunrise alarm schedules. Control seamlessly via app or voice.', 'Default', '#000000', 1299.00, 0.00, '2026-08-19 14:52:00'),
(4, '67ac7cf58dfc4', 'cat_2', 'prod_5', NULL, 'cat_2', 'Urban Canvas Waterproof Commuter Backpack', 'Engineered for modern commuters. Features a dedicated 16\" padded laptop sleeve, hidden anti-theft pockets, waterproof zippers, and ergonomic ventilated shoulder straps.', 'Default', '#000000', 1599.00, 0.00, '2026-08-19 14:52:00'),
(5, '67ac7cf58dfc4', 'cat_4', 'prod_6', NULL, 'cat_4', 'The Atelier Cashmere Cocoon Coat', 'Meticulously crafted from 100% double-faced Mongolian cashmere. Features relaxed drop shoulders, hand-stitched horn buttons, deep welt pockets, and a dramatic sculptural silhouette designed for effortless layering.', 'Default', '#000000', 7499.00, 0.00, '2026-08-19 14:52:00'),
(6, '67ac7cf58dfc4', 'cat_4', 'prod_7', NULL, 'cat_4', 'Sculpted Heavyweight French Terry Hoodie', 'Constructed from 480GSM organic cotton French terry with pre-shrunk density. Features a double-layered structured hood, seamless kangaroo pocket, and ribbed side gussets for enhanced drape and longevity.', 'Default', '#000000', 3299.00, 0.00, '2026-08-19 14:52:00'),
(7, '67ac7cf58dfc4', 'cat_4', 'prod_8', NULL, 'cat_4', 'Tailored Raw Japanese Selvedge Trousers', 'Woven on vintage shuttle looms in Okayama, Japan. 13.5oz ring-spun raw cotton with custom brass hardware, chain-stitched hems, and a relaxed wide-leg architectural cut.', 'Default', '#000000', 4899.00, 0.00, '2026-08-19 14:52:00'),
(8, '67ac7cf58dfc4', 'cat_4', 'prod_9', NULL, 'cat_4', 'Mulberry Silk Bias-Cut Slip Dress', 'Cut on the bias from 22-momme Grade 6A mulberry silk to flatter natural movement. Features delicate adjustable spaghetti straps, French seams, and a soft sandwashed satin sheen.', 'Default', '#000000', 5699.00, 0.00, '2026-08-19 14:52:00'),
(1772, '67ac7cf58dfc4', 'cat_5', 'prod_14', NULL, 'cat_5', 'UltraFast Magnetic Qi2 Wireless Powerbank 10000mAh — Next-Gen Edition', '<ul class=\'nova-bullet-features\'><li>⚡ Superior Ergonomics &amp; Build: Crafted with aircraft-grade durability and sleek modern aesthetics.</li><li>🛡️ Certified Quality: 100% inspected and verified for peak performance and longevity.</li><li>🚚 Express Free Shipping: Dispatched from certified fulfillment hubs with live AWB tracking.</li><li>💎 7-Day Replacement Guarantee: Zero-risk shopping backed by 24/7 dedicated support.</li></ul><div class=\'nova-product-description\'><div class=\'product-story\'><h3>Engineered for Excellence</h3><p>Experience unmatched reliability and performance with the <strong>UltraFast Magnetic Qi2 Wireless Powerbank 10000mAh</strong>. Designed specifically for contemporary living, it seamlessly integrates advanced functionality with minimalist design aesthetics.</p><h4>Key Highlights:</h4><ul><li>High-efficiency performance tailored for demanding everyday tasks.</li><li>Premium scratch-resistant and tactile finish.</li><li>Backed by full NovaDrop manufacturer warranty.</li></ul></div></div>', 'Default', '#000000', 1899.00, 0.00, '2026-08-19 16:40:06'),
(1773, '67ac7cf58dfc4', 'cat_6', 'prod_15', NULL, 'cat_6', 'AeroWave Active Noise Cancelling Studio Earbuds', 'Elevate your lifestyle with the AeroWave Active Noise Cancelling Studio Earbuds. Engineered for maximum durability, style, and everyday performance.', 'Default', '#000000', 3199.00, 0.00, '2026-08-19 16:40:06'),
(2635, '67ac7cf58dfc4', 'cat_2', 'prod_2', NULL, 'cat_2', 'Vintage Okayama 14.5oz Selvedge Trousers', 'Custom shuttle-loomed denim with vintage copper hardware and chain-stitched hems that develop personalized honeycombs and whiskers over time.', 'Default', '#000000', 4899.00, 0.00, '2026-08-25 09:21:59'),
(2643, '67ac7cf58dfc4', 'cat_4', 'prod_10', NULL, 'cat_4', 'Italian Pleated Wool Trousers', 'High-rise relaxed tailoring trousers in mid-weight Italian wool with curtained waistband and unhemmed cuffs for bespoke fitting.', 'Default', '#000000', 399.00, 0.00, '2026-08-25 09:21:59'),
(3104, '67ac7cf58dfc4', 'cat_1', 'prod_11', NULL, 'cat_1', 'Handcrafted Italian Chelsea Boots', '', 'Default', '#000000', 5999.00, 0.00, '2026-08-26 00:34:59'),
(3270, '67ac7cf58dfc4', 'cat_1', 'prod_16', NULL, 'cat_1', 'Atelier Double-Breasted Wool Peacoat', '✦ Tailored bespoke construction crafted in premium heavyweight textile.\r\n✦ Precision drop-shoulder architecture with structural canvas interfacing.\r\n✦ Temperature-regulating micro-climate lining engineered for comfort.\r\n✦ Reinforced double-needle stitching and tonal horn button fastening.', 'Default', '#000000', 4199.00, 0.00, '2026-08-26 00:45:57');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(10) UNSIGNED NOT NULL,
  `store_id` int(10) UNSIGNED NOT NULL,
  `collection_id` int(10) UNSIGNED DEFAULT NULL,
  `title` varchar(500) NOT NULL,
  `slug` varchar(500) NOT NULL,
  `description` longtext DEFAULT NULL,
  `short_description` text DEFAULT NULL,
  `product_type` enum('physical','digital') NOT NULL DEFAULT 'physical',
  `status` enum('draft','active','archived') NOT NULL DEFAULT 'draft',
  `vendor` varchar(120) DEFAULT NULL,
  `tags` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`tags`)),
  `seo_title` varchar(255) DEFAULT NULL,
  `seo_description` varchar(500) DEFAULT NULL,
  `og_image_url` varchar(500) DEFAULT NULL,
  `base_price` decimal(12,2) NOT NULL DEFAULT 0.00,
  `compare_at_price` decimal(10,2) DEFAULT NULL,
  `cost_price` decimal(10,2) DEFAULT 0.00,
  `weight_grams` int(10) UNSIGNED DEFAULT NULL,
  `requires_shipping` tinyint(1) NOT NULL DEFAULT 1,
  `is_taxable` tinyint(1) NOT NULL DEFAULT 1,
  `tax_rate_pct` decimal(6,3) NOT NULL DEFAULT 18.000,
  `track_inventory` tinyint(1) NOT NULL DEFAULT 1,
  `low_stock_threshold` int(10) UNSIGNED NOT NULL DEFAULT 5,
  `views_count` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `search_vector` text DEFAULT NULL,
  `meilisearch_synced` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `store_id`, `collection_id`, `title`, `slug`, `description`, `short_description`, `product_type`, `status`, `vendor`, `tags`, `seo_title`, `seo_description`, `og_image_url`, `base_price`, `compare_at_price`, `cost_price`, `weight_grams`, `requires_shipping`, `is_taxable`, `tax_rate_pct`, `track_inventory`, `low_stock_threshold`, `views_count`, `search_vector`, `meilisearch_synced`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'The Atelier Cashmere Cocoon Coat', 'the-atelier-cashmere-cocoon-coat', 'Hand-cut from 700 GSM Grade-A Mongolian cashmere with double-faced seams and water buffalo horn buttons. Museum-grade thermal efficiency with zero synthetic chemicals.', 'An architectural double-faced silhouette hand-cut from 700 GSM pure Mongolian cashmere with fluid drop shoulders, unlined horn button closures, and sculpted welt pockets.', 'physical', 'active', 'Lumina Atelier Milano', NULL, NULL, 'Discover The Atelier Cashmere Cocoon Coat — Next-Gen Edition — Next-Gen Edition. Bespoke tailoring and architectural luxury silhouettes handcrafted in generational European ateliers.', 'http://localhost/Dropshipping/img/cashmere_cocoon_coat.jpg', 4399.00, 5939.00, 0.00, NULL, 1, 1, 18.000, 1, 5, 1249, NULL, 0, '2026-08-25 20:49:38', '2026-08-28 01:35:42'),
(2, 1, 2, 'Vintage Okayama 14.5oz Selvedge Trousers', 'vintage-okayama-selvedge-trousers', 'Custom shuttle-loomed denim with vintage copper hardware and chain-stitched hems that develop personalized honeycombs and whiskers over time.', '14.5oz shuttle-loomed selvedge denim from Okayama, Japan, rope-dyed in authentic natural indigo vats with red-line selvedge ID.', 'physical', 'active', 'Lumina Denim Lab', NULL, NULL, 'Discover Vintage Okayama 14.5oz Selvedge Trousers. Bespoke tailoring and architectural luxury silhouettes handcrafted in generational European ateliers.', 'http://localhost/Dropshipping/img/okayama_selvedge_denim.jpg', 4299.00, 5804.00, 0.00, NULL, 1, 1, 18.000, 1, 5, 982, NULL, 0, '2026-08-25 20:49:38', '2026-08-26 01:39:06'),
(3, 1, 5, 'Sculpted 500 GSM Terry Hoodie', 'sculpted-heavyweight-terry-hoodie', 'Heavyweight 500 GSM loopback cotton hoodie with double-layered crossover hood and flatlock reinforced seams for lifelong structure.', 'Substantial 500 GSM loopback cotton jersey garments, custom garment-dyed in muted architectural tones for effortless daily poise.', 'physical', 'active', 'Lumina Essentials', NULL, NULL, 'Discover Sculpted 500 GSM Terry Hoodie. Bespoke tailoring and architectural luxury silhouettes handcrafted in generational European ateliers.', 'http://localhost/Dropshipping/img/terry_hoodie_luxury.jpg', 2899.00, 3914.00, 0.00, NULL, 1, 1, 18.000, 1, 5, 843, NULL, 0, '2026-08-25 20:49:38', '2026-08-28 00:56:14'),
(4, 1, 3, '22-Momme Mulberry Silk Bias Slip Dress', 'mulberry-silk-bias-slip-dress', 'Sandwashed pure Mulberry silk that drapes organically along bodily contours with liquid sheen and adjustable silk-cord straps.', 'Fluid bias-cut evening dresses crafted from certified 22-momme Mulberry silk with exquisite hand-rolled French seams.', 'physical', 'active', 'Lumina Haute Couture', NULL, NULL, 'Discover 22-Momme Mulberry Silk Bias Slip Dress. Bespoke tailoring and architectural luxury silhouettes handcrafted in generational European ateliers.', 'http://localhost/Dropshipping/img/mulberry_silk_dress.jpg', 4999.00, 6749.00, 0.00, NULL, 1, 1, 18.000, 1, 5, 1120, NULL, 0, '2026-08-25 20:49:38', '2026-08-25 22:15:51'),
(5, 1, 4, 'Super 150s Double-Breasted Wool Blazer', 'super-150s-double-breasted-blazer', 'Woven in Biella, Italy with peak lapels, cupro sleeve lining, and floating canvas that molds to the wearer’s physique.', 'Double-breasted blazers cut from Super 150s Italian virgin wool with floating horsehair canvas construction.', 'physical', 'active', 'Lumina Sartoria', NULL, NULL, 'Discover Super 150s Double-Breasted Wool Blazer. Bespoke tailoring and architectural luxury silhouettes handcrafted in generational European ateliers.', 'http://localhost/Dropshipping/img/wool_blazer_luxury.jpg', 6999.00, 9449.00, 0.00, NULL, 1, 1, 18.000, 1, 5, 950, NULL, 0, '2026-08-25 20:49:38', '2026-08-25 22:15:51'),
(6, 1, 1, 'Double-Breasted Melton Wool Peacoat', 'double-breasted-melton-wool-peacoat', 'Architectural virgin wool peacoat with anchor-embossed horn buttons and deep fleece-lined hand warmer pockets.', 'Tailored from heavyweight structured virgin Melton wool for severe sub-zero thermal protection with sharp nautical lapels.', 'physical', 'active', 'Lumina Atelier Milano', NULL, NULL, 'Discover Double-Breasted Melton Wool Peacoat. Bespoke tailoring and architectural luxury silhouettes handcrafted in generational European ateliers.', 'http://localhost/Dropshipping/img/melton_wool_peacoat.jpg', 5699.00, 7694.00, 0.00, NULL, 1, 1, 18.000, 1, 5, 780, NULL, 0, '2026-08-25 20:49:38', '2026-08-25 22:15:51'),
(7, 1, 6, 'Mongolian Ribbed Turtleneck Knit', 'mongolian-ribbed-turtleneck-knit', 'Chunky 7-gauge cashmere turtleneck sweater with ribbed cuffs and hem, combed humanely from Inner Mongolian goats.', 'Grade-A virgin cashmere knit with 7-gauge fisherman ribbing for plush, featherlight warmth.', 'physical', 'active', 'Lumina Knitwear', NULL, NULL, 'Discover Mongolian Ribbed Turtleneck Knit. Bespoke tailoring and architectural luxury silhouettes handcrafted in generational European ateliers.', 'http://localhost/Dropshipping/img/cashmere_turtleneck_knit.jpg', 3499.00, 4724.00, 0.00, NULL, 1, 1, 18.000, 1, 5, 891, NULL, 0, '2026-08-25 20:49:38', '2026-08-26 21:42:47'),
(8, 1, 2, 'Type II Shuttle-Loom Denim Jacket', 'type-ii-shuttle-loom-denim-jacket', 'Iconic Type II jacket silhouette crafted on vintage Toyoda shuttle looms with red-line selvedge along the interior placket.', '15oz raw indigo shuttle-loomed Japanese selvedge denim jacket with boxy pleat architecture.', 'physical', 'active', 'Lumina Denim Lab', NULL, NULL, 'Discover Type II Shuttle-Loom Denim Jacket. Bespoke tailoring and architectural luxury silhouettes handcrafted in generational European ateliers.', 'http://localhost/Dropshipping/img/denim_jacket_type2.jpg', 5299.00, 7154.00, 0.00, NULL, 1, 1, 18.000, 1, 5, 720, NULL, 0, '2026-08-25 20:49:38', '2026-08-25 22:15:51'),
(9, 1, 3, 'Sandwashed Silk Charmeuse Blouse', 'sandwashed-silk-charmeuse-blouse', 'Ultra-soft sandwashed silk charmeuse blouse with French cuffs and concealed placket for effortless sartorial styling.', 'Grade 6A Mulberry silk blouse with fluid liquid drape and mother-of-pearl button closures.', 'physical', 'active', 'Lumina Haute Couture', NULL, NULL, 'Discover Sandwashed Silk Charmeuse Blouse. Bespoke tailoring and architectural luxury silhouettes handcrafted in generational European ateliers.', 'http://localhost/Dropshipping/img/silk_charmeuse_blouse.jpg', 3799.00, 5129.00, 0.00, NULL, 1, 1, 18.000, 1, 5, 650, NULL, 0, '2026-08-25 20:49:38', '2026-08-25 22:15:51'),
(10, 1, 4, 'Italian Pleated Wool Trousers', 'italian-pleated-wool-trousers', 'High-rise relaxed tailoring trousers in mid-weight Italian wool with curtained waistband and unhemmed cuffs for bespoke fitting.', 'Biella Italian virgin wool trousers with deep reverse pleats and side tab adjusters.', 'physical', 'active', 'Lumina Sartoria', NULL, 'Italian Pleated Wool Trousers', 'Discover Italian Pleated Wool Trousers. Bespoke tailoring and architectural luxury silhouettes handcrafted in generational European ateliers.', 'http://localhost/Dropshipping/img/italian_pleated_trousers.jpg', 3499.00, 4724.00, 0.00, NULL, 1, 1, 18.000, 1, 5, 810, NULL, 0, '2026-08-25 20:49:38', '2026-08-26 21:31:04');

-- --------------------------------------------------------

--
-- Table structure for table `product_bundles`
--

CREATE TABLE `product_bundles` (
  `id` int(11) NOT NULL,
  `bundle_product_id` int(11) NOT NULL,
  `discount_percentage` decimal(5,2) DEFAULT 15.00,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `title` varchar(255) NOT NULL DEFAULT 'Smart Bundle',
  `bundle_type` enum('combo','frequently_bought','bogo','volume_tier') DEFAULT 'combo',
  `discount_type` enum('percentage','fixed_price','fixed_discount') DEFAULT 'percentage',
  `discount_value` decimal(10,2) NOT NULL DEFAULT 15.00,
  `primary_product_id` int(11) DEFAULT NULL,
  `items_json` text DEFAULT NULL,
  `badge_text` varchar(50) DEFAULT 'BUNDLE & SAVE',
  `total_sold` int(11) DEFAULT 0,
  `total_revenue` decimal(12,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_bundles`
--

INSERT INTO `product_bundles` (`id`, `bundle_product_id`, `discount_percentage`, `is_active`, `created_at`, `title`, `bundle_type`, `discount_type`, `discount_value`, `primary_product_id`, `items_json`, `badge_text`, `total_sold`, `total_revenue`) VALUES
(999, 99, 15.00, 1, '2026-08-19 17:00:26', 'Curated Ensemble Set #999', 'combo', 'percentage', 20.00, NULL, '[1, 2, 3]', 'LOOKBOOK COMBO', 0, 0.00),
(1000, 1, 20.00, 1, '2026-08-25 21:54:23', 'Curated Ensemble Set #1000', 'combo', 'percentage', 20.00, NULL, '[1, 2, 3]', 'LOOKBOOK COMBO', 0, 0.00),
(1001, 1, 20.00, 1, '2026-08-25 21:54:59', 'Curated Ensemble Set #1001', 'combo', 'percentage', 20.00, NULL, '[1, 2, 3]', 'LOOKBOOK COMBO', 0, 0.00),
(1002, 1, 20.00, 1, '2026-08-25 21:55:19', 'Curated Ensemble Set #1002', 'combo', 'percentage', 20.00, NULL, '[1, 2, 3]', 'LOOKBOOK COMBO', 0, 0.00),
(1003, 1, 20.00, 1, '2026-08-25 21:56:00', 'Curated Ensemble Set #1003', 'combo', 'percentage', 20.00, NULL, '[1, 2, 3]', 'LOOKBOOK COMBO', 0, 0.00),
(1004, 1, 20.00, 1, '2026-08-25 21:56:19', 'Curated Ensemble Set #1004', 'combo', 'percentage', 20.00, NULL, '[1, 2, 3]', 'LOOKBOOK COMBO', 0, 0.00),
(1005, 1, 20.00, 1, '2026-08-25 21:56:57', 'Curated Ensemble Set #1005', 'combo', 'percentage', 20.00, NULL, '[1, 2, 3]', 'LOOKBOOK COMBO', 0, 0.00),
(1006, 1, 20.00, 1, '2026-08-25 21:57:23', 'Curated Ensemble Set #1006', 'combo', 'percentage', 20.00, NULL, '[1, 2, 3]', 'LOOKBOOK COMBO', 0, 0.00),
(1007, 1, 20.00, 1, '2026-08-25 21:57:53', 'Curated Ensemble Set #1007', 'combo', 'percentage', 20.00, NULL, '[1, 2, 3]', 'LOOKBOOK COMBO', 0, 0.00),
(1008, 1, 20.00, 1, '2026-08-25 21:58:09', 'Curated Ensemble Set #1008', 'combo', 'percentage', 20.00, NULL, '[1, 2, 3]', 'LOOKBOOK COMBO', 0, 0.00),
(1009, 1, 20.00, 1, '2026-08-25 21:58:37', 'Curated Ensemble Set #1009', 'combo', 'percentage', 20.00, NULL, '[1, 2, 3]', 'LOOKBOOK COMBO', 0, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `product_bundle_items`
--

CREATE TABLE `product_bundle_items` (
  `id` int(11) NOT NULL,
  `bundle_id` int(11) NOT NULL,
  `component_product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_bundle_items`
--

INSERT INTO `product_bundle_items` (`id`, `bundle_id`, `component_product_id`, `quantity`) VALUES
(1, 999, 1, 2),
(2, 1000, 2, 1),
(3, 1001, 2, 1),
(4, 1002, 2, 1),
(5, 1003, 2, 1),
(6, 1004, 2, 1),
(7, 1005, 2, 1),
(8, 1006, 2, 1),
(9, 1007, 2, 1),
(10, 1008, 2, 1),
(11, 1009, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `url` varchar(500) NOT NULL,
  `alt_text` varchar(255) DEFAULT NULL,
  `position` smallint(6) NOT NULL DEFAULT 0,
  `is_primary` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `url`, `alt_text`, `position`, `is_primary`, `created_at`) VALUES
(441, 1, 'http://localhost/Dropshipping/img/cashmere_cocoon_coat.jpg', 'The Atelier Cashmere Cocoon Coat product hero image showcase - NovaDrop Commerce', 1, 1, '2026-08-25 09:50:14'),
(442, 2, 'http://localhost/Dropshipping/img/okayama_selvedge_denim.jpg', NULL, 1, 1, '2026-08-25 09:50:14'),
(443, 3, 'http://localhost/Dropshipping/img/terry_hoodie_luxury.jpg', NULL, 1, 1, '2026-08-25 09:50:14'),
(444, 4, 'http://localhost/Dropshipping/img/mulberry_silk_dress.jpg', NULL, 1, 1, '2026-08-25 09:50:14'),
(445, 5, 'http://localhost/Dropshipping/img/wool_blazer_luxury.jpg', NULL, 1, 1, '2026-08-25 09:50:14'),
(446, 6, 'http://localhost/Dropshipping/img/melton_wool_peacoat.jpg', NULL, 1, 1, '2026-08-25 09:50:14'),
(447, 7, 'http://localhost/Dropshipping/img/cashmere_turtleneck_knit.jpg', NULL, 1, 1, '2026-08-25 09:50:14'),
(448, 8, 'http://localhost/Dropshipping/img/denim_jacket_type2.jpg', NULL, 1, 1, '2026-08-25 09:50:14'),
(449, 9, 'http://localhost/Dropshipping/img/silk_charmeuse_blouse.jpg', NULL, 1, 1, '2026-08-25 09:50:14'),
(450, 10, 'http://localhost/Dropshipping/img/italian_pleated_trousers.jpg', NULL, 1, 1, '2026-08-25 09:50:14');

-- --------------------------------------------------------

--
-- Table structure for table `product_options`
--

CREATE TABLE `product_options` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(60) NOT NULL,
  `position` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_option_values`
--

CREATE TABLE `product_option_values` (
  `id` int(10) UNSIGNED NOT NULL,
  `option_id` int(10) UNSIGNED NOT NULL,
  `value` varchar(120) NOT NULL,
  `position` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_performance_metrics`
--

CREATE TABLE `product_performance_metrics` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `views_count` int(11) DEFAULT 0,
  `cart_adds_count` int(11) DEFAULT 0,
  `purchases_count` int(11) DEFAULT 0,
  `rto_returns_count` int(11) DEFAULT 0,
  `ctr_pct` decimal(5,2) DEFAULT 0.00,
  `conversion_rate_pct` decimal(5,2) DEFAULT 0.00,
  `gross_margin_yield` decimal(12,2) DEFAULT 0.00,
  `data_moat_score` decimal(6,2) DEFAULT 0.00,
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_performance_metrics`
--

INSERT INTO `product_performance_metrics` (`id`, `product_id`, `views_count`, `cart_adds_count`, `purchases_count`, `rto_returns_count`, `ctr_pct`, `conversion_rate_pct`, `gross_margin_yield`, `data_moat_score`, `updated_at`) VALUES
(1, 1, 1246, 0, 0, 0, 0.00, 0.00, 0.00, 50.00, '2026-08-26 21:31:04'),
(2, 3, 840, 0, 0, 0, 0.00, 0.00, 0.00, 50.00, '2026-08-26 21:31:04'),
(3, 4, 1120, 0, 0, 0, 0.00, 0.00, 0.00, 50.00, '2026-08-26 21:31:04'),
(4, 5, 950, 0, 0, 0, 0.00, 0.00, 0.00, 50.00, '2026-08-26 21:31:04'),
(5, 6, 780, 0, 0, 0, 0.00, 0.00, 0.00, 50.00, '2026-08-26 21:31:04'),
(6, 7, 890, 0, 0, 0, 0.00, 0.00, 0.00, 50.00, '2026-08-26 21:31:04'),
(7, 8, 720, 0, 0, 0, 0.00, 0.00, 0.00, 50.00, '2026-08-26 21:31:04'),
(8, 9, 650, 0, 0, 0, 0.00, 0.00, 0.00, 50.00, '2026-08-26 21:31:04'),
(9, 14, 1, 0, 0, 0, 0.00, 0.00, 0.00, 50.00, '2026-08-19 18:53:06'),
(10, 15, 1, 0, 0, 0, 0.00, 0.00, 0.00, 50.00, '2026-08-19 18:53:06'),
(112, 2, 982, 0, 0, 0, 0.00, 0.00, 0.00, 50.00, '2026-08-26 21:31:04'),
(120, 10, 810, 0, 0, 0, 0.00, 0.00, 0.00, 50.00, '2026-08-26 21:31:04');

-- --------------------------------------------------------

--
-- Table structure for table `product_reviews`
--

CREATE TABLE `product_reviews` (
  `id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT 1,
  `product_id` int(11) NOT NULL,
  `author_name` varchar(150) NOT NULL,
  `author_location` varchar(100) DEFAULT 'Mumbai, India',
  `rating` int(11) DEFAULT 5,
  `title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `fit_feedback` varchar(50) DEFAULT 'True to Size',
  `is_verified_buyer` tinyint(1) DEFAULT 1,
  `status` enum('approved','pending','hidden') DEFAULT 'approved',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_variants`
--

CREATE TABLE `product_variants` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `sku` varchar(120) NOT NULL,
  `title` varchar(255) NOT NULL,
  `option1_value` varchar(120) DEFAULT NULL,
  `option2_value` varchar(120) DEFAULT NULL,
  `option3_value` varchar(120) DEFAULT NULL,
  `price` decimal(12,2) NOT NULL,
  `compare_price` decimal(12,2) DEFAULT NULL,
  `cost_price` decimal(12,2) DEFAULT NULL,
  `inventory_qty` int(11) NOT NULL DEFAULT 0,
  `weight_grams` int(10) UNSIGNED DEFAULT NULL,
  `barcode` varchar(80) DEFAULT NULL,
  `image_id` int(10) UNSIGNED DEFAULT NULL,
  `position` smallint(6) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_variants`
--

INSERT INTO `product_variants` (`id`, `product_id`, `sku`, `title`, `option1_value`, `option2_value`, `option3_value`, `price`, `compare_price`, `cost_price`, `inventory_qty`, `weight_grams`, `barcode`, `image_id`, `position`, `is_active`, `created_at`, `updated_at`) VALUES
(456, 1, 'LUMINA-001', 'Tailored Standard', NULL, NULL, NULL, 4399.00, 5939.00, 1749.65, 12, NULL, NULL, NULL, 0, 1, '2026-08-25 09:50:14', '2026-08-25 21:52:37'),
(457, 2, 'LUMINA-002', 'Tailored Standard', NULL, NULL, NULL, 4299.00, 5804.00, 1714.65, 12, NULL, NULL, NULL, 0, 1, '2026-08-25 09:50:14', '2026-08-25 21:52:37'),
(458, 3, 'LUMINA-003', 'Tailored Standard', NULL, NULL, NULL, 2899.00, 3914.00, 1154.65, 9, NULL, NULL, NULL, 0, 1, '2026-08-25 09:50:14', '2026-08-26 22:05:01'),
(459, 4, 'LUMINA-004', 'Tailored Standard', NULL, NULL, NULL, 4999.00, 6749.00, 1994.65, 12, NULL, NULL, NULL, 0, 1, '2026-08-25 09:50:14', '2026-08-25 21:52:37'),
(460, 5, 'LUMINA-005', 'Tailored Standard', NULL, NULL, NULL, 6999.00, 9449.00, 2799.65, 12, NULL, NULL, NULL, 0, 1, '2026-08-25 09:50:14', '2026-08-25 21:52:37'),
(461, 6, 'LUMINA-006', 'Tailored Standard', NULL, NULL, NULL, 5699.00, 7694.00, 2274.65, 12, NULL, NULL, NULL, 0, 1, '2026-08-25 09:50:14', '2026-08-25 21:52:37'),
(462, 7, 'LUMINA-007', 'Tailored Standard', NULL, NULL, NULL, 3499.00, 4724.00, 1364.65, 12, NULL, NULL, NULL, 0, 1, '2026-08-25 09:50:14', '2026-08-25 21:52:37'),
(463, 8, 'LUMINA-008', 'Tailored Standard', NULL, NULL, NULL, 5299.00, 7154.00, 2099.65, 12, NULL, NULL, NULL, 0, 1, '2026-08-25 09:50:14', '2026-08-25 21:52:37'),
(464, 9, 'LUMINA-009', 'Tailored Standard', NULL, NULL, NULL, 3799.00, 5129.00, 1504.65, 12, NULL, NULL, NULL, 0, 1, '2026-08-25 09:50:14', '2026-08-25 21:52:37'),
(465, 10, 'LUMINA-010', 'Tailored Standard', NULL, NULL, NULL, 3499.00, 4724.00, 1399.65, 12, NULL, NULL, NULL, 0, 1, '2026-08-25 09:50:14', '2026-08-26 21:31:04');

-- --------------------------------------------------------

--
-- Table structure for table `product_waitlist`
--

CREATE TABLE `product_waitlist` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `name` varchar(150) DEFAULT NULL,
  `notified` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_waitlist`
--

INSERT INTO `product_waitlist` (`id`, `product_id`, `email`, `name`, `notified`, `created_at`) VALUES
(1, 1, 'priya.sharma@gmail.com', 'Priya Sharma', 0, '2026-08-26 01:35:55'),
(2, 1, 'ananya.m@outlook.com', 'Ananya M.', 0, '2026-08-26 01:35:55'),
(3, 1, 'rohit.k@yahoo.com', 'Rohit K.', 0, '2026-08-26 01:35:55'),
(4, 2, 'deepa.r@gmail.com', 'Deepa R.', 0, '2026-08-26 01:35:55'),
(5, 2, 'kavya.n@gmail.com', 'Kavya N.', 0, '2026-08-26 01:35:55'),
(6, 3, 'arjun.p@gmail.com', 'Arjun Patel', 0, '2026-08-26 01:35:55'),
(7, 3, 'meera.s@gmail.com', 'Meera S.', 0, '2026-08-26 01:35:55'),
(8, 1, 'vishal.g@gmail.com', 'Vishal G.', 0, '2026-08-26 01:35:55');

-- --------------------------------------------------------

--
-- Table structure for table `product_winning_scores`
--

CREATE TABLE `product_winning_scores` (
  `id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT 1,
  `product_id` int(11) DEFAULT NULL,
  `supplier_product_id` varchar(120) NOT NULL,
  `cost_price` decimal(12,2) NOT NULL DEFAULT 0.00,
  `selling_price` decimal(12,2) NOT NULL DEFAULT 0.00,
  `gross_margin_pct` decimal(6,2) NOT NULL DEFAULT 0.00,
  `shipping_days` int(11) NOT NULL DEFAULT 7,
  `rating` decimal(3,2) NOT NULL DEFAULT 4.50,
  `review_count` int(11) NOT NULL DEFAULT 0,
  `trend_index` decimal(5,2) NOT NULL DEFAULT 50.00,
  `winning_score` decimal(6,2) NOT NULL DEFAULT 0.00,
  `is_flagged_winner` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_winning_scores`
--

INSERT INTO `product_winning_scores` (`id`, `store_id`, `product_id`, `supplier_product_id`, `cost_price`, `selling_price`, `gross_margin_pct`, `shipping_days`, `rating`, `review_count`, `trend_index`, `winning_score`, `is_flagged_winner`, `created_at`, `updated_at`) VALUES
(1, 1, 14, 'CJ-TEST-QI2-01', 750.00, 1999.00, 62.48, 4, 4.90, 240, 95.00, 50.00, 0, '2026-08-19 16:38:09', '2026-08-19 18:53:06'),
(2, 1, 15, 'CJ-TEST-ANC-02', 1200.00, 3199.00, 62.49, 3, 4.85, 410, 92.00, 50.00, 0, '2026-08-19 16:38:10', '2026-08-19 18:53:06');

-- --------------------------------------------------------

--
-- Table structure for table `promo`
--

CREATE TABLE `promo` (
  `id` int(11) NOT NULL,
  `prmoid` varchar(64) DEFAULT '',
  `code` varchar(50) DEFAULT '',
  `disc` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `promo`
--

INSERT INTO `promo` (`id`, `prmoid`, `code`, `disc`) VALUES
(1, 'PRM-BUY2', 'BUY2GET10', 10.00),
(2, 'PRM-BUY3', 'BUY3GET20', 20.00),
(3, 'PRM-BUY2', 'BUY2GET10', 10.00),
(4, 'PRM-BUY3', 'BUY3GET20', 20.00),
(5, 'PRM-BUY2', 'BUY2GET10', 10.00),
(6, 'PRM-BUY3', 'BUY3GET20', 20.00),
(7, 'PRM-BUY2', 'BUY2GET10', 10.00),
(8, 'PRM-BUY3', 'BUY3GET20', 20.00),
(9, 'PRM-BUY2', 'BUY2GET10', 10.00),
(10, 'PRM-BUY3', 'BUY3GET20', 20.00),
(11, 'PRM-VIP15', 'VIP15', 15.00),
(12, 'PRM-WELCOME5', 'WELCOME5', 5.00),
(13, 'PRM-BUY2', 'BUY2GET10', 10.00),
(14, 'PRM-BUY3', 'BUY3GET20', 20.00),
(15, 'PRM-VIP15', 'VIP15', 15.00),
(16, 'PRM-WELCOME5', 'WELCOME5', 5.00),
(17, 'PRM-BUY2', 'BUY2GET10', 10.00),
(18, 'PRM-BUY3', 'BUY3GET20', 20.00),
(19, 'PRM-VIP15', 'VIP15', 15.00),
(20, 'PRM-WELCOME5', 'WELCOME5', 5.00),
(21, 'PRM-BUY2', 'BUY2GET10', 10.00),
(22, 'PRM-BUY3', 'BUY3GET20', 20.00),
(23, 'PRM-VIP15', 'VIP15', 15.00),
(24, 'PRM-WELCOME5', 'WELCOME5', 5.00),
(25, 'PRM-BUY2', 'BUY2GET10', 10.00),
(26, 'PRM-BUY3', 'BUY3GET20', 20.00),
(27, 'PRM-VIP15', 'VIP15', 15.00),
(28, 'PRM-WELCOME5', 'WELCOME5', 5.00);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_orders`
--

CREATE TABLE `purchase_orders` (
  `id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT 1,
  `po_number` varchar(50) NOT NULL,
  `supplier_name` varchar(150) NOT NULL,
  `total_units` int(11) NOT NULL,
  `total_cost` decimal(12,2) NOT NULL,
  `status` enum('draft','issued','in_transit','received','cancelled') DEFAULT 'issued',
  `tracking_awb` varchar(100) DEFAULT NULL,
  `expected_delivery` date DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `atype` varchar(64) DEFAULT 'all',
  `title` varchar(255) DEFAULT '',
  `details` text DEFAULT NULL,
  `status` varchar(30) DEFAULT 'open',
  `date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `referrals`
--

CREATE TABLE `referrals` (
  `id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT 1,
  `referrer_id` int(11) NOT NULL COMMENT 'customer who referred',
  `referee_id` int(11) DEFAULT NULL COMMENT 'customer who signed up via referral',
  `referral_code` varchar(32) NOT NULL,
  `clicks` int(11) DEFAULT 0,
  `conversions` int(11) DEFAULT 0,
  `earnings` decimal(12,2) DEFAULT 0.00,
  `pending_payout` decimal(12,2) DEFAULT 0.00,
  `total_paid_out` decimal(12,2) DEFAULT 0.00,
  `tier` tinyint(4) DEFAULT 1 COMMENT '1=standard 2=super 3=elite',
  `is_active` tinyint(4) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `refunds`
--

CREATE TABLE `refunds` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED NOT NULL,
  `payment_id` int(10) UNSIGNED NOT NULL,
  `initiated_by` int(10) UNSIGNED DEFAULT NULL,
  `amount` decimal(12,2) NOT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `gateway_refund_id` varchar(120) DEFAULT NULL,
  `status` enum('pending','processed','failed') NOT NULL DEFAULT 'pending',
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `replenishment_log`
--

CREATE TABLE `replenishment_log` (
  `id` bigint(20) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `last_order_date` datetime NOT NULL,
  `expected_depletion_date` datetime NOT NULL,
  `sent_at` datetime DEFAULT NULL,
  `status` enum('pending','sent','reordered','ignored') DEFAULT 'pending',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `return_requests`
--

CREATE TABLE `return_requests` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `order_item_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `reason` varchar(255) NOT NULL,
  `status` enum('requested','approved','rejected','received','refunded') DEFAULT 'requested',
  `refund_amount` decimal(12,2) DEFAULT 0.00,
  `admin_notes` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(10) UNSIGNED NOT NULL,
  `store_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `customer_id` int(10) UNSIGNED DEFAULT NULL,
  `name` varchar(80) DEFAULT NULL,
  `rating` tinyint(4) NOT NULL,
  `title` varchar(200) DEFAULT NULL,
  `body` text DEFAULT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT 0,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `store_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(60) NOT NULL,
  `guard` varchar(30) NOT NULL DEFAULT 'admin',
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `store_id`, `name`, `guard`, `created_at`) VALUES
(1, 1, 'Super Admin', 'admin', '2026-08-19 11:35:27'),
(2, 1, 'Manager', 'admin', '2026-08-19 11:35:27'),
(3, 1, 'Staff', 'admin', '2026-08-19 11:35:27');

-- --------------------------------------------------------

--
-- Table structure for table `role_permissions`
--

CREATE TABLE `role_permissions` (
  `role_id` int(10) UNSIGNED NOT NULL,
  `permission_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_permissions`
--

INSERT INTO `role_permissions` (`role_id`, `permission_id`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `rto_risk_evaluations`
--

CREATE TABLE `rto_risk_evaluations` (
  `id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT 1,
  `order_id` int(11) NOT NULL,
  `cod_amount` decimal(12,2) NOT NULL,
  `rto_risk_score` decimal(4,2) NOT NULL DEFAULT 0.00,
  `risk_tier` enum('low','medium','high') NOT NULL DEFAULT 'low',
  `is_confirmed_via_whatsapp` tinyint(1) NOT NULL DEFAULT 0,
  `confirmation_token` varchar(64) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `confirmed_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rto_risk_evaluations`
--

INSERT INTO `rto_risk_evaluations` (`id`, `store_id`, `order_id`, `cod_amount`, `rto_risk_score`, `risk_tier`, `is_confirmed_via_whatsapp`, `confirmation_token`, `created_at`, `confirmed_at`) VALUES
(1, 1, 9, 3499.00, 0.85, 'high', 1, 'd16d83ed4f2c9f16d230fa0f31915a49', '2026-08-19 16:45:06', '2026-08-19 16:45:06');

-- --------------------------------------------------------

--
-- Table structure for table `shipments`
--

CREATE TABLE `shipments` (
  `id` int(10) UNSIGNED NOT NULL,
  `store_id` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED NOT NULL,
  `carrier` varchar(60) DEFAULT NULL,
  `carrier_shipment_id` varchar(120) DEFAULT NULL,
  `tracking_number` varchar(120) DEFAULT NULL,
  `tracking_url` varchar(500) DEFAULT NULL,
  `label_url` varchar(500) DEFAULT NULL,
  `status` enum('pending','label_created','picked_up','in_transit','delivered','returned','failed') NOT NULL DEFAULT 'pending',
  `shipped_at` datetime DEFAULT NULL,
  `delivered_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shipments`
--

INSERT INTO `shipments` (`id`, `store_id`, `order_id`, `carrier`, `carrier_shipment_id`, `tracking_number`, `tracking_url`, `label_url`, `status`, `shipped_at`, `delivered_at`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'BlueDart / Delhivery Surface', NULL, 'CJINDB54D34CCD', 'https://track.cjdropshipping.com/tracking?num=CJIND', NULL, 'in_transit', '2026-08-19 18:51:48', NULL, '2026-08-19 18:51:48', '2026-08-19 18:51:48'),
(2, 1, 3, 'BlueDart / Delhivery Surface', NULL, 'CJIND1140648BD', 'https://track.cjdropshipping.com/tracking?num=CJIND', NULL, 'in_transit', '2026-08-19 18:51:48', NULL, '2026-08-19 18:51:48', '2026-08-19 18:51:48'),
(3, 1, 4, 'BlueDart / Delhivery Surface', NULL, 'CJIND169A230CF', 'https://track.cjdropshipping.com/tracking?num=CJIND', NULL, 'in_transit', '2026-08-19 18:51:48', NULL, '2026-08-19 18:51:48', '2026-08-19 18:51:48');

-- --------------------------------------------------------

--
-- Table structure for table `shipment_items`
--

CREATE TABLE `shipment_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `shipment_id` int(10) UNSIGNED NOT NULL,
  `order_item_id` int(10) UNSIGNED NOT NULL,
  `quantity` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shipment_items`
--

INSERT INTO `shipment_items` (`id`, `shipment_id`, `order_item_id`, `quantity`) VALUES
(1, 1, 1, 1),
(2, 2, 2, 1),
(3, 1, 1, 1),
(4, 2, 3, 2),
(5, 3, 4, 2);

-- --------------------------------------------------------

--
-- Table structure for table `shipping_rates`
--

CREATE TABLE `shipping_rates` (
  `id` int(10) UNSIGNED NOT NULL,
  `zone_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(80) NOT NULL,
  `type` enum('flat','weight_based','price_based') NOT NULL,
  `min_value` decimal(10,2) DEFAULT NULL,
  `max_value` decimal(10,2) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `is_free` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shipping_rates`
--

INSERT INTO `shipping_rates` (`id`, `zone_id`, `name`, `type`, `min_value`, `max_value`, `price`, `is_free`) VALUES
(1, 1, 'Standard Shipping', 'flat', NULL, NULL, 60.00, 0),
(2, 1, 'Free Shipping (above ₹500)', 'price_based', 500.00, NULL, 0.00, 1),
(3, 1, 'Standard Shipping', 'flat', NULL, NULL, 60.00, 0),
(4, 1, 'Free Shipping (above ₹500)', 'price_based', 500.00, NULL, 0.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `shipping_zones`
--

CREATE TABLE `shipping_zones` (
  `id` int(10) UNSIGNED NOT NULL,
  `store_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(80) NOT NULL,
  `states` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`states`)),
  `countries` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`countries`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shipping_zones`
--

INSERT INTO `shipping_zones` (`id`, `store_id`, `name`, `states`, `countries`) VALUES
(1, 1, 'All India', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `size`
--

CREATE TABLE `size` (
  `id` int(11) NOT NULL,
  `admid` varchar(64) DEFAULT NULL,
  `pcid` varchar(64) NOT NULL,
  `ccid` varchar(64) NOT NULL,
  `szid` varchar(64) NOT NULL,
  `size` varchar(50) NOT NULL,
  `qty` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sliders`
--

CREATE TABLE `sliders` (
  `id` int(11) NOT NULL,
  `image` longblob DEFAULT NULL,
  `heading` varchar(255) DEFAULT '',
  `subheading` varchar(255) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stores`
--

CREATE TABLE `stores` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(120) NOT NULL,
  `domain` varchar(255) NOT NULL,
  `currency` char(3) NOT NULL DEFAULT 'INR',
  `timezone` varchar(60) NOT NULL DEFAULT 'Asia/Kolkata',
  `settings_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`settings_json`)),
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stores`
--

INSERT INTO `stores` (`id`, `name`, `domain`, `currency`, `timezone`, `settings_json`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'NovaDrop', 'localhost', 'INR', 'Asia/Kolkata', NULL, 1, '2026-08-19 11:35:27', '2026-08-19 11:35:27');

-- --------------------------------------------------------

--
-- Table structure for table `store_positioning`
--

CREATE TABLE `store_positioning` (
  `id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT 1,
  `brand_name` varchar(150) NOT NULL DEFAULT 'NovaDrop ErgoFlow',
  `tagline` varchar(255) NOT NULL DEFAULT 'Elevate Your Workspace & Peak Performance Lifestyle',
  `niche_category` varchar(120) NOT NULL DEFAULT 'Premium Workspace Ergonomics & High-Performance Gadgets',
  `founder_story` text DEFAULT NULL,
  `hero_bundle_title` varchar(255) NOT NULL DEFAULT 'The Executive Workspace Mastery Bundle',
  `hero_bundle_discount_pct` decimal(5,2) NOT NULL DEFAULT 25.00,
  `mission_statement` text DEFAULT NULL,
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `store_positioning`
--

INSERT INTO `store_positioning` (`id`, `store_id`, `brand_name`, `tagline`, `niche_category`, `founder_story`, `hero_bundle_title`, `hero_bundle_discount_pct`, `mission_statement`, `updated_at`) VALUES
(1, 1, 'NovaDrop ErgoFlow', 'Elevate Your Workspace & Peak Performance Lifestyle', 'Workspace Ergonomics & High-End Tech', 'Built for remote founders, engineers, and creators tired of cheap plastic dropshipped junk. NovaDrop engineers rigorously tested ergonomic tools and magnetic power accessories built to endure 14-hour deep work sessions.', 'The Executive Workspace Mastery Bundle (Ergo Mouse + Qi2 Powerbank + Atmosphere Lamp)', 25.00, 'Empowering 100,000+ creators and professionals across India with thoughtfully designed, high-durability tools that eliminate fatigue and accelerate daily focus.', '2026-08-19 16:45:06');

-- --------------------------------------------------------

--
-- Table structure for table `store_settings`
--

CREATE TABLE `store_settings` (
  `id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT 1,
  `key` varchar(100) NOT NULL,
  `value` longtext DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subscriptions`
--

CREATE TABLE `subscriptions` (
  `id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT 1,
  `customer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `variant_id` int(11) DEFAULT NULL,
  `plan_interval` enum('30_days','60_days','90_days') NOT NULL DEFAULT '30_days',
  `discount_pct` decimal(5,2) NOT NULL DEFAULT 15.00,
  `price_per_cycle` decimal(12,2) NOT NULL,
  `status` enum('active','paused','cancelled') NOT NULL DEFAULT 'active',
  `next_charge_at` datetime NOT NULL,
  `last_charged_at` datetime DEFAULT NULL,
  `gateway_subscription_id` varchar(120) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subscriptions`
--

INSERT INTO `subscriptions` (`id`, `store_id`, `customer_id`, `product_id`, `variant_id`, `plan_interval`, `discount_pct`, `price_per_cycle`, `status`, `next_charge_at`, `last_charged_at`, `gateway_subscription_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, NULL, '30_days', 15.00, 1699.00, 'active', '2026-09-18 13:15:06', '2026-08-19 16:45:06', NULL, '2026-08-19 16:45:06', '2026-08-19 16:45:06');

-- --------------------------------------------------------

--
-- Table structure for table `subscription_plans`
--

CREATE TABLE `subscription_plans` (
  `id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT 1,
  `title` varchar(255) NOT NULL,
  `billing_interval` enum('weekly','monthly','quarterly','yearly') DEFAULT 'monthly',
  `price` decimal(12,2) NOT NULL DEFAULT 999.00,
  `compare_at_price` decimal(12,2) DEFAULT 1499.00,
  `discount_on_store` decimal(5,2) DEFAULT 15.00 COMMENT 'Subscribers get extra discount on entire store',
  `free_shipping` tinyint(1) DEFAULT 1,
  `box_contents_desc` text DEFAULT NULL,
  `subscribers_count` int(11) DEFAULT 0,
  `mrr` decimal(12,2) DEFAULT 0.00 COMMENT 'Monthly Recurring Revenue contribution',
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int(10) UNSIGNED NOT NULL,
  `store_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(120) NOT NULL,
  `adapter` varchar(60) NOT NULL,
  `api_key` varchar(255) DEFAULT NULL,
  `api_secret` varchar(255) DEFAULT NULL,
  `settings_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`settings_json`)),
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `store_id`, `name`, `adapter`, `api_key`, `api_secret`, `settings_json`, `is_active`, `created_at`) VALUES
(1, 1, 'Mock Global Supplier (Demo)', 'MockSupplierAdapter', NULL, NULL, NULL, 1, '2026-08-19 10:32:34');

-- --------------------------------------------------------

--
-- Table structure for table `supplier_orders`
--

CREATE TABLE `supplier_orders` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED NOT NULL,
  `supplier_id` int(10) UNSIGNED NOT NULL,
  `supplier_order_id` varchar(120) DEFAULT NULL,
  `status` enum('pending','pushed','confirmed','shipped','delivered','failed') NOT NULL DEFAULT 'pending',
  `push_attempts` tinyint(4) NOT NULL DEFAULT 0,
  `last_attempt_at` datetime DEFAULT NULL,
  `response_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`response_json`)),
  `tracking_number` varchar(120) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `supplier_orders`
--

INSERT INTO `supplier_orders` (`id`, `order_id`, `supplier_id`, `supplier_order_id`, `status`, `push_attempts`, `last_attempt_at`, `response_json`, `tracking_number`, `created_at`, `updated_at`) VALUES
(1, 3, 1, 'CJ-ORD-F1A9CD524E', 'pushed', 1, NULL, '{\"success\":true,\"supplier_order_id\":\"CJ-ORD-F1A9CD524E\",\"estimated_ship_date\":\"2026-08-21\",\"raw_response\":{\"code\":200,\"message\":\"Order successfully accepted by supplier fulfillment center\",\"order_id\":\"CJ-ORD-F1A9CD524E\"}}', NULL, '2026-08-19 16:38:10', '2026-08-19 16:38:10'),
(2, 8, 1, 'CJ-ORD-C092AFDED1', 'pushed', 1, NULL, '{\"success\":true,\"supplier_order_id\":\"CJ-ORD-C092AFDED1\",\"estimated_ship_date\":\"2026-08-21\",\"raw_response\":{\"code\":200,\"message\":\"Order successfully accepted by supplier fulfillment center\",\"order_id\":\"CJ-ORD-C092AFDED1\"}}', NULL, '2026-08-19 16:45:06', '2026-08-19 16:45:06'),
(3, 1, 1, 'CJ-ORD-3BDF57AA6D', 'pushed', 1, NULL, '{\"success\":true,\"supplier_order_id\":\"CJ-ORD-3BDF57AA6D\",\"estimated_ship_date\":\"2026-08-21\",\"raw_response\":{\"code\":200,\"message\":\"Order successfully accepted by supplier fulfillment center\",\"order_id\":\"CJ-ORD-3BDF57AA6D\"}}', NULL, '2026-08-19 18:51:48', '2026-08-19 18:51:48'),
(4, 4, 1, 'CJ-ORD-588EB02EAD', 'pushed', 1, NULL, '{\"success\":true,\"supplier_order_id\":\"CJ-ORD-588EB02EAD\",\"estimated_ship_date\":\"2026-08-21\",\"raw_response\":{\"code\":200,\"message\":\"Order successfully accepted by supplier fulfillment center\",\"order_id\":\"CJ-ORD-588EB02EAD\"}}', NULL, '2026-08-19 18:51:48', '2026-08-19 18:51:48');

-- --------------------------------------------------------

--
-- Table structure for table `supplier_products`
--

CREATE TABLE `supplier_products` (
  `id` int(10) UNSIGNED NOT NULL,
  `supplier_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED DEFAULT NULL,
  `supplier_product_id` varchar(120) NOT NULL,
  `title` varchar(500) DEFAULT NULL,
  `supplier_price` decimal(12,2) DEFAULT NULL,
  `supplier_stock` int(11) DEFAULT NULL,
  `data_json` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`data_json`)),
  `last_synced_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `supplier_products`
--

INSERT INTO `supplier_products` (`id`, `supplier_id`, `product_id`, `supplier_product_id`, `title`, `supplier_price`, `supplier_stock`, `data_json`, `last_synced_at`, `created_at`, `updated_at`) VALUES
(1, 1, 14, 'CJ-TEST-QI2-01', 'UltraFast Magnetic Qi2 Wireless Powerbank 10000mAh', 750.00, 300, '{\"supplier_product_id\":\"CJ-TEST-QI2-01\",\"title\":\"UltraFast Magnetic Qi2 Wireless Powerbank 10000mAh\",\"category\":\"Electronics & Gadgets\",\"price\":750,\"stock\":300,\"shipping_days\":4,\"rating\":4.9,\"reviews\":240,\"trend_index\":95}', '2026-08-19 16:38:09', '2026-08-19 16:38:09', '2026-08-19 16:38:09'),
(2, 1, 15, 'CJ-TEST-ANC-02', 'AeroWave Active Noise Cancelling Studio Earbuds', 1200.00, 150, '{\"supplier_product_id\":\"CJ-TEST-ANC-02\",\"title\":\"AeroWave Active Noise Cancelling Studio Earbuds\",\"category\":\"Audio & Lifestyle\",\"price\":1200,\"stock\":150,\"shipping_days\":3,\"rating\":4.85,\"reviews\":410,\"trend_index\":92}', '2026-08-19 16:38:09', '2026-08-19 16:38:09', '2026-08-19 16:38:09');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` int(11) NOT NULL,
  `tid` varchar(64) NOT NULL,
  `uid` varchar(64) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `status` varchar(30) DEFAULT 'Pending',
  `created_at` datetime DEFAULT current_timestamp(),
  `customer_id` int(11) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `priority` varchar(30) DEFAULT 'Normal',
  `intent` varchar(60) DEFAULT 'General',
  `reply` text DEFAULT NULL,
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ucontact`
--

CREATE TABLE `ucontact` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT '',
  `email` varchar(255) DEFAULT '',
  `subject` varchar(255) DEFAULT '',
  `message` text DEFAULT NULL,
  `date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `upsell_offers`
--

CREATE TABLE `upsell_offers` (
  `id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT 1,
  `trigger_product_id` int(11) DEFAULT NULL,
  `offer_product_id` int(11) NOT NULL,
  `headline` varchar(255) NOT NULL,
  `discount_pct` decimal(5,2) NOT NULL DEFAULT 30.00,
  `special_price` decimal(12,2) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `impressions_count` int(11) DEFAULT 0,
  `conversions_count` int(11) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `uid` varchar(64) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `date` datetime DEFAULT current_timestamp(),
  `lsdate` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `uid`, `username`, `password`, `date`, `lsdate`) VALUES
(592, 'cust_6', 'customer', '$2y$12$7KRZTE9xygI6jz/RcRrS8O0IcDte3c3h1rql937JZfdtsWg5gSQT6', '2026-08-25 22:15:51', '2026-08-25 22:15:51'),
(780, 'cust_8', 'atelier.collector.1286', '$2y$12$CMqY3W/dkqK9eT704Dyi1uEX1Rt/KMtCSBurke8OchBCVoVHw7A0m', '2026-08-26 18:37:13', '2026-08-26 18:37:13');

-- --------------------------------------------------------

--
-- Table structure for table `userdet`
--

CREATE TABLE `userdet` (
  `id` int(11) NOT NULL,
  `uid` varchar(64) NOT NULL,
  `username` varchar(100) NOT NULL,
  `fname` varchar(100) DEFAULT '',
  `lname` varchar(100) DEFAULT '',
  `phone` varchar(30) DEFAULT '',
  `email` varchar(255) NOT NULL,
  `disc` decimal(10,2) NOT NULL DEFAULT 0.00,
  `addr1` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userdet`
--

INSERT INTO `userdet` (`id`, `uid`, `username`, `fname`, `lname`, `phone`, `email`, `disc`, `addr1`) VALUES
(592, 'cust_6', 'customer', '', '', '9870330063', 'customer@novadrop.in', 0.00, ''),
(780, 'cust_8', 'atelier.collector.1286', '', '', '', 'atelier.collector.1286@gmail.com', 0.00, '');

-- --------------------------------------------------------

--
-- Table structure for table `vendors`
--

CREATE TABLE `vendors` (
  `id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT 1,
  `business_name` varchar(191) NOT NULL,
  `contact_name` varchar(150) NOT NULL,
  `email` varchar(191) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `status` enum('pending','approved','suspended') DEFAULT 'pending',
  `commission_type` enum('percent','flat') DEFAULT 'percent',
  `commission_value` decimal(8,2) DEFAULT 15.00,
  `payout_method` enum('bank','upi','paypal') DEFAULT 'bank',
  `payout_details_json` longtext DEFAULT NULL,
  `gstin` varchar(30) DEFAULT NULL,
  `kyc_status` enum('pending','verified','rejected') DEFAULT 'pending',
  `kyc_docs_json` longtext DEFAULT NULL,
  `rating` decimal(3,2) DEFAULT 5.00,
  `total_orders_fulfilled` int(11) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vendors`
--

INSERT INTO `vendors` (`id`, `store_id`, `business_name`, `contact_name`, `email`, `phone`, `status`, `commission_type`, `commission_value`, `payout_method`, `payout_details_json`, `gstin`, `kyc_status`, `kyc_docs_json`, `rating`, `total_orders_fulfilled`, `created_at`, `updated_at`) VALUES
(1, 1, 'Lumina Atelier Milano', 'Alessandro Rossi', 'alessandro@lumina-atelier.com', '+919870330063', 'approved', 'percent', 15.00, 'bank', NULL, '27AAACL1234A1Z5', 'verified', NULL, 4.95, 48, '2026-08-19 18:50:07', '2026-08-19 18:50:07'),
(2, 1, 'Okayama Selvedge Guild', 'Kenji Takahashi', 'kenji@okayama-denim.jp', '+919870330064', 'approved', 'percent', 12.00, 'bank', NULL, '27AAACT5678B1Z2', 'verified', NULL, 4.88, 32, '2026-08-19 18:50:07', '2026-08-19 18:50:07'),
(3, 1, 'Kashmir Heritage Weaves', 'Tariq Mir', 'tariq@kashmircashmere.in', '+919870330065', 'approved', 'percent', 15.00, 'upi', NULL, '01AAACK9012C1Z8', 'verified', NULL, 4.92, 64, '2026-08-19 18:50:07', '2026-08-19 18:50:07');

-- --------------------------------------------------------

--
-- Table structure for table `vendor_order_notifications`
--

CREATE TABLE `vendor_order_notifications` (
  `id` int(11) NOT NULL,
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `channel` enum('email','whatsapp','webhook','dashboard') NOT NULL,
  `payload_json` longtext DEFAULT NULL,
  `sent_at` datetime DEFAULT current_timestamp(),
  `acknowledged_at` datetime DEFAULT NULL,
  `status` enum('pending','sent','acknowledged','escalated') DEFAULT 'sent',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vendor_order_notifications`
--

INSERT INTO `vendor_order_notifications` (`id`, `order_item_id`, `order_id`, `vendor_id`, `channel`, `payload_json`, `sent_at`, `acknowledged_at`, `status`, `created_at`) VALUES
(1, 5, 5, 2, 'dashboard', '{\"order_number\":\"#01001\",\"item_title\":\"The Atelier Cashmere Cocoon Coat\",\"quantity\":1,\"price\":\"7499.00\",\"commission\":899.88,\"net_payable\":6599.12}', '2026-08-19 22:28:41', NULL, 'sent', '2026-08-19 22:28:41'),
(2, 6, 6, 2, 'dashboard', '{\"order_number\":\"#02002\",\"item_title\":\"The Atelier Cashmere Cocoon Coat\",\"quantity\":1,\"price\":\"7499.00\",\"commission\":899.88,\"net_payable\":6599.12}', '2026-08-19 22:31:35', NULL, 'sent', '2026-08-19 22:31:35'),
(3, 7, 7, 2, 'dashboard', '{\"order_number\":\"#03003\",\"item_title\":\"The Atelier Cashmere Cocoon Coat\",\"quantity\":1,\"price\":\"7499.00\",\"commission\":899.88,\"net_payable\":6599.12}', '2026-08-19 22:31:48', NULL, 'sent', '2026-08-19 22:31:48'),
(4, 5, 5, 2, 'dashboard', '{\"order_number\":\"#01001\",\"item_title\":\"The Atelier Cashmere Cocoon Coat\",\"quantity\":1,\"price\":\"7499.00\",\"commission\":899.88,\"net_payable\":6599.12}', '2026-08-25 21:33:09', NULL, 'sent', '2026-08-25 21:33:09'),
(5, 6, 6, 2, 'dashboard', '{\"order_number\":\"#02002\",\"item_title\":\"The Atelier Cashmere Cocoon Coat\",\"quantity\":1,\"price\":\"7499.00\",\"commission\":899.88,\"net_payable\":6599.12}', '2026-08-25 21:33:09', NULL, 'sent', '2026-08-25 21:33:09'),
(6, 7, 7, 2, 'dashboard', '{\"order_number\":\"#03003\",\"item_title\":\"The Atelier Cashmere Cocoon Coat\",\"quantity\":1,\"price\":\"7499.00\",\"commission\":899.88,\"net_payable\":6599.12}', '2026-08-25 21:33:09', NULL, 'sent', '2026-08-25 21:33:09'),
(7, 7, 7, 2, 'dashboard', '{\"order_number\":\"#03003\",\"item_title\":\"The Atelier Cashmere Cocoon Coat\",\"quantity\":1,\"price\":\"7499.00\",\"commission\":899.88,\"net_payable\":6599.12}', '2026-08-25 21:58:10', NULL, 'sent', '2026-08-25 21:58:10'),
(8, 7, 7, 2, 'dashboard', '{\"order_number\":\"#03003\",\"item_title\":\"The Atelier Cashmere Cocoon Coat\",\"quantity\":1,\"price\":\"7499.00\",\"commission\":899.88,\"net_payable\":6599.12}', '2026-08-25 21:58:10', NULL, 'sent', '2026-08-25 21:58:10'),
(9, 7, 7, 2, 'dashboard', '{\"order_number\":\"#03003\",\"item_title\":\"The Atelier Cashmere Cocoon Coat\",\"quantity\":1,\"price\":\"7499.00\",\"commission\":899.88,\"net_payable\":6599.12}', '2026-08-25 21:58:38', NULL, 'sent', '2026-08-25 21:58:38'),
(10, 7, 7, 2, 'dashboard', '{\"order_number\":\"#03003\",\"item_title\":\"The Atelier Cashmere Cocoon Coat\",\"quantity\":1,\"price\":\"7499.00\",\"commission\":899.88,\"net_payable\":6599.12}', '2026-08-25 21:58:38', NULL, 'sent', '2026-08-25 21:58:38'),
(11, 7, 7, 2, 'dashboard', '{\"order_number\":\"#03003\",\"item_title\":\"The Atelier Cashmere Cocoon Coat\",\"quantity\":1,\"price\":\"7499.00\",\"commission\":899.88,\"net_payable\":6599.12}', '2026-08-25 22:09:06', NULL, 'sent', '2026-08-25 22:09:06'),
(12, 7, 7, 2, 'dashboard', '{\"order_number\":\"#03003\",\"item_title\":\"The Atelier Cashmere Cocoon Coat\",\"quantity\":1,\"price\":\"7499.00\",\"commission\":899.88,\"net_payable\":6599.12}', '2026-08-26 21:31:04', NULL, 'sent', '2026-08-26 21:31:04'),
(13, 8, 8, 2, 'dashboard', '{\"order_number\":\"#04004\",\"item_title\":\"Sculpted 500 GSM Terry Hoodie\",\"quantity\":1,\"price\":\"2899.00\",\"commission\":347.88,\"net_payable\":2551.12}', '2026-08-26 21:42:09', NULL, 'sent', '2026-08-26 21:42:09'),
(14, 9, 9, 2, 'dashboard', '{\"order_number\":\"#05005\",\"item_title\":\"Sculpted 500 GSM Terry Hoodie\",\"quantity\":2,\"price\":\"5798.00\",\"commission\":695.76,\"net_payable\":5102.24}', '2026-08-26 22:05:01', NULL, 'sent', '2026-08-26 22:05:01');

-- --------------------------------------------------------

--
-- Table structure for table `vendor_payouts`
--

CREATE TABLE `vendor_payouts` (
  `id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `period_start` datetime NOT NULL,
  `period_end` datetime NOT NULL,
  `gross_sales` decimal(12,2) NOT NULL,
  `commission_amount` decimal(12,2) NOT NULL,
  `net_payable` decimal(12,2) NOT NULL,
  `status` enum('pending','processing','paid','failed') DEFAULT 'pending',
  `paid_at` datetime DEFAULT NULL,
  `reference` varchar(120) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vendor_payouts`
--

INSERT INTO `vendor_payouts` (`id`, `vendor_id`, `period_start`, `period_end`, `gross_sales`, `commission_amount`, `net_payable`, `status`, `paid_at`, `reference`, `notes`, `created_at`) VALUES
(1, 2, '2026-08-01 00:00:00', '2026-08-19 23:59:59', 1899.00, 227.88, 1671.12, 'pending', NULL, 'PAY-9819E694', NULL, '2026-08-19 18:51:42');

-- --------------------------------------------------------

--
-- Table structure for table `vendor_payout_items`
--

CREATE TABLE `vendor_payout_items` (
  `id` int(11) NOT NULL,
  `payout_id` int(11) NOT NULL,
  `order_item_id` int(11) NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `commission` decimal(12,2) NOT NULL,
  `net_amount` decimal(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vendor_payout_items`
--

INSERT INTO `vendor_payout_items` (`id`, `payout_id`, `order_item_id`, `amount`, `commission`, `net_amount`) VALUES
(1, 1, 2, 1899.00, 227.88, 1671.12);

-- --------------------------------------------------------

--
-- Table structure for table `vendor_products`
--

CREATE TABLE `vendor_products` (
  `id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `vendor_sku` varchar(100) DEFAULT NULL,
  `vendor_price` decimal(12,2) NOT NULL,
  `vendor_stock` int(11) DEFAULT 0,
  `approval_status` enum('pending','approved','rejected') DEFAULT 'pending',
  `rejection_reason` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vendor_products`
--

INSERT INTO `vendor_products` (`id`, `vendor_id`, `product_id`, `vendor_sku`, `vendor_price`, `vendor_stock`, `approval_status`, `rejection_reason`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'VSKU-AERO-1', 2499.00, 118, 'approved', NULL, '2026-08-19 18:50:07', '2026-08-19 18:50:07'),
(2, 2, 3, 'VSKU-MINI-3', 1899.00, 65, 'approved', NULL, '2026-08-19 18:50:07', '2026-08-19 18:50:07'),
(3, 3, 4, 'VSKU-SMAR-4', 1299.00, 67, 'approved', NULL, '2026-08-19 18:50:07', '2026-08-19 18:50:07'),
(4, 1, 5, 'VSKU-URBA-5', 1599.00, 53, 'approved', NULL, '2026-08-19 18:50:07', '2026-08-19 18:50:07'),
(5, 2, 6, 'VSKU-THEA-6', 7499.00, 89, 'approved', NULL, '2026-08-19 18:50:07', '2026-08-19 18:50:07'),
(6, 3, 7, 'VSKU-SCUL-7', 3299.00, 36, 'approved', NULL, '2026-08-19 18:50:07', '2026-08-19 18:50:07'),
(7, 1, 8, 'VSKU-TAIL-8', 4899.00, 92, 'approved', NULL, '2026-08-19 18:50:07', '2026-08-19 18:50:07'),
(8, 2, 9, 'VSKU-MULB-9', 5699.00, 26, 'approved', NULL, '2026-08-19 18:50:07', '2026-08-19 18:50:07'),
(9, 3, 14, 'VSKU-ULTR-14', 1899.00, 117, 'approved', NULL, '2026-08-19 18:50:07', '2026-08-19 18:50:07'),
(10, 1, 15, 'VSKU-AERO-15', 3099.00, 77, 'approved', NULL, '2026-08-19 18:50:07', '2026-08-19 18:50:07');

-- --------------------------------------------------------

--
-- Table structure for table `vendor_users`
--

CREATE TABLE `vendor_users` (
  `id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `email` varchar(191) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('owner','staff') DEFAULT 'owner',
  `is_active` tinyint(1) DEFAULT 1,
  `last_login_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vendor_users`
--

INSERT INTO `vendor_users` (`id`, `vendor_id`, `name`, `email`, `password_hash`, `role`, `is_active`, `last_login_at`, `created_at`) VALUES
(1, 1, 'Alessandro Rossi', 'alessandro@lumina-atelier.com', '$2y$10$NI6/92i58aNdy.HOdxdAMuH8/xoLEbI6BhsHAA3WT4k4T1hMGPCRm', 'owner', 1, NULL, '2026-08-19 18:50:07'),
(2, 2, 'Kenji Takahashi', 'kenji@okayama-denim.jp', '$2y$10$NI6/92i58aNdy.HOdxdAMuH8/xoLEbI6BhsHAA3WT4k4T1hMGPCRm', 'owner', 1, NULL, '2026-08-19 18:50:07'),
(3, 3, 'Tariq Mir', 'tariq@kashmircashmere.in', '$2y$10$NI6/92i58aNdy.HOdxdAMuH8/xoLEbI6BhsHAA3WT4k4T1hMGPCRm', 'owner', 1, NULL, '2026-08-19 18:50:07');

-- --------------------------------------------------------

--
-- Table structure for table `wallet_transactions`
--

CREATE TABLE `wallet_transactions` (
  `id` int(10) UNSIGNED NOT NULL,
  `store_id` int(10) UNSIGNED NOT NULL,
  `customer_id` int(10) UNSIGNED NOT NULL,
  `type` enum('credit','debit') NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `balance_after` decimal(12,2) NOT NULL,
  `reference_type` varchar(30) DEFAULT NULL,
  `reference_id` int(10) UNSIGNED DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `warehouses`
--

CREATE TABLE `warehouses` (
  `id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT 1,
  `code` varchar(50) NOT NULL,
  `name` varchar(150) NOT NULL,
  `location` varchar(150) NOT NULL,
  `country` varchar(100) DEFAULT 'India',
  `capacity_units` int(11) DEFAULT 10000,
  `active_stock_units` int(11) DEFAULT 2400,
  `is_primary` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `warehouses`
--

INSERT INTO `warehouses` (`id`, `store_id`, `code`, `name`, `location`, `country`, `capacity_units`, `active_stock_units`, `is_primary`, `created_at`) VALUES
(1, 1, 'WH-BOM-01', 'Mumbai Central White-Glove Depot', 'Bhiwandi Hub, Mumbai', 'India', 15000, 4850, 1, '2026-08-26 00:58:12'),
(2, 1, 'WH-SZX-02', 'Shenzhen CJ Air-Dispatch Terminal', 'Baoan District, Shenzhen', 'China', 50000, 18200, 0, '2026-08-26 00:58:12'),
(3, 1, 'WH-LON-03', 'London Mayfair European Atelier', 'Westminster, London', 'UK', 8000, 1420, 0, '2026-08-26 00:58:12');

-- --------------------------------------------------------

--
-- Table structure for table `webhooks_log`
--

CREATE TABLE `webhooks_log` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `store_id` int(10) UNSIGNED DEFAULT NULL,
  `source` varchar(40) NOT NULL,
  `event` varchar(80) NOT NULL,
  `payload_hash` varchar(64) NOT NULL,
  `raw_body` mediumtext DEFAULT NULL,
  `headers` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`headers`)),
  `hmac_valid` tinyint(1) NOT NULL DEFAULT 0,
  `processed` tinyint(1) NOT NULL DEFAULT 0,
  `error` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `webhook_deliveries`
--

CREATE TABLE `webhook_deliveries` (
  `id` bigint(20) NOT NULL,
  `subscription_id` int(11) NOT NULL,
  `event` varchar(80) NOT NULL,
  `payload_json` longtext NOT NULL,
  `response_code` int(11) DEFAULT NULL,
  `response_body` text DEFAULT NULL,
  `attempt` int(11) NOT NULL DEFAULT 1,
  `delivered_at` datetime DEFAULT NULL,
  `status` enum('pending','delivered','failed') NOT NULL DEFAULT 'pending',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `webhook_subscriptions`
--

CREATE TABLE `webhook_subscriptions` (
  `id` int(11) NOT NULL,
  `store_id` int(11) DEFAULT 1,
  `owner_type` enum('admin','vendor','app') NOT NULL DEFAULT 'admin',
  `owner_id` int(11) DEFAULT 1,
  `event` varchar(80) NOT NULL,
  `target_url` varchar(255) NOT NULL,
  `secret` varchar(64) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `failure_count` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `winback_log`
--

CREATE TABLE `winback_log` (
  `id` bigint(20) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `days_inactive` int(11) NOT NULL,
  `offer_code` varchar(50) NOT NULL,
  `sent_at` datetime DEFAULT NULL,
  `status` enum('pending','sent','recovered','ignored') DEFAULT 'pending',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wishlists`
--

CREATE TABLE `wishlists` (
  `id` int(10) UNSIGNED NOT NULL,
  `customer_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `variant_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `abandoned_cart_log`
--
ALTER TABLE `abandoned_cart_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_acl_cart` (`cart_id`),
  ADD KEY `idx_acl_status` (`status`);

--
-- Indexes for table `abandoned_cart_sequences`
--
ALTER TABLE `abandoned_cart_sequences`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `abandoned_cart_steps`
--
ALTER TABLE `abandoned_cart_steps`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_acs_seq` (`sequence_id`);

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_addr_customer` (`customer_id`),
  ADD KEY `idx_addr_store` (`store_id`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admid` (`admid`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_admin_email_store` (`store_id`,`email`),
  ADD KEY `idx_admin_store` (`store_id`),
  ADD KEY `idx_admin_role` (`role_id`);

--
-- Indexes for table `ad_campaigns`
--
ALTER TABLE `ad_campaigns`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `affiliate_payouts`
--
ALTER TABLE `affiliate_payouts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ai_agent_tasks`
--
ALTER TABLE `ai_agent_tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_aat_store_agent` (`store_id`,`agent`),
  ADD KEY `idx_aat_status` (`status`);

--
-- Indexes for table `ai_autopilot_configs`
--
ALTER TABLE `ai_autopilot_configs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_ap_store` (`store_id`);

--
-- Indexes for table `ai_orchestrator_config`
--
ALTER TABLE `ai_orchestrator_config`
  ADD PRIMARY KEY (`setting_key`);

--
-- Indexes for table `ai_orchestrator_runs`
--
ALTER TABLE `ai_orchestrator_runs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ai_swarm_telemetry`
--
ALTER TABLE `ai_swarm_telemetry`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_swarm_store` (`store_id`),
  ADD KEY `idx_swarm_agent` (`agent_name`),
  ADD KEY `idx_swarm_created` (`created_at`);

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `api_keys`
--
ALTER TABLE `api_keys`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `key_hash` (`key_hash`),
  ADD KEY `idx_ak_hash` (`key_hash`),
  ADD KEY `idx_ak_owner` (`owner_type`,`owner_id`);

--
-- Indexes for table `api_request_log`
--
ALTER TABLE `api_request_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_arl_key_time` (`api_key_id`,`created_at`);

--
-- Indexes for table `audit_log`
--
ALTER TABLE `audit_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_al_store_action` (`store_id`,`action`),
  ADD KEY `idx_al_entity` (`entity_type`,`entity_id`),
  ADD KEY `idx_al_actor` (`actor_type`,`actor_id`),
  ADD KEY `idx_al_created` (`created_at`);

--
-- Indexes for table `automation_runs`
--
ALTER TABLE `automation_runs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_ar_job_status` (`job_name`,`status`),
  ADD KEY `idx_ar_created` (`created_at`);

--
-- Indexes for table `back_in_stock_log`
--
ALTER TABLE `back_in_stock_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_bis_prod` (`product_id`);

--
-- Indexes for table `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `browse_abandonment_log`
--
ALTER TABLE `browse_abandonment_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_bal_status` (`status`,`viewed_at`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_cart_customer` (`customer_id`),
  ADD KEY `idx_cart_store` (`store_id`),
  ADD KEY `idx_cart_session` (`session_token`),
  ADD KEY `idx_cart_activity` (`last_activity`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_ci_cart` (`cart_id`),
  ADD KEY `idx_ci_variant` (`variant_id`);

--
-- Indexes for table `catgory`
--
ALTER TABLE `catgory`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ctid` (`ctid`);

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Indexes for table `collections`
--
ALTER TABLE `collections`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_col_slug_store` (`store_id`,`slug`),
  ADD KEY `idx_col_store_active` (`store_id`,`is_active`),
  ADD KEY `idx_col_parent` (`parent_id`);

--
-- Indexes for table `collection_products`
--
ALTER TABLE `collection_products`
  ADD PRIMARY KEY (`collection_id`,`product_id`),
  ADD KEY `idx_cp_product` (`product_id`);

--
-- Indexes for table `contact_identities`
--
ALTER TABLE `contact_identities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_ci_phone` (`phone`),
  ADD KEY `idx_ci_cust` (`customer_id`),
  ADD KEY `idx_ci_sess` (`session_id`);

--
-- Indexes for table `currency_rates`
--
ALTER TABLE `currency_rates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_cust_email_store` (`store_id`,`email`),
  ADD KEY `idx_cust_store` (`store_id`),
  ADD KEY `idx_cust_phone` (`phone`),
  ADD KEY `idx_cust_store_active` (`store_id`,`is_active`);

--
-- Indexes for table `customer_addresses`
--
ALTER TABLE `customer_addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_ca_cust` (`customer_id`);

--
-- Indexes for table `customer_subscriptions`
--
ALTER TABLE `customer_subscriptions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `description`
--
ALTER TABLE `description`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `despid` (`despid`);

--
-- Indexes for table `discount`
--
ALTER TABLE `discount`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `discounts`
--
ALTER TABLE `discounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_disc_code_store` (`store_id`,`code`),
  ADD KEY `idx_disc_store_active` (`store_id`,`is_active`),
  ADD KEY `idx_disc_dates` (`starts_at`,`ends_at`);

--
-- Indexes for table `disimg`
--
ALTER TABLE `disimg`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_campaigns`
--
ALTER TABLE `email_campaigns`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_ec_status` (`status`);

--
-- Indexes for table `email_lists`
--
ALTER TABLE `email_lists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_segments`
--
ALTER TABLE `email_segments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email_subscribers`
--
ALTER TABLE `email_subscribers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_es_email` (`email`),
  ADD KEY `idx_es_status` (`subscribed`);

--
-- Indexes for table `email_templates`
--
ALTER TABLE `email_templates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_et_key_store` (`store_id`,`key_name`);

--
-- Indexes for table `error_log`
--
ALTER TABLE `error_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_el_severity` (`severity`),
  ADD KEY `idx_el_context` (`context`),
  ADD KEY `idx_el_created` (`created_at`);

--
-- Indexes for table `flash_sales`
--
ALTER TABLE `flash_sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gamification_spins`
--
ALTER TABLE `gamification_spins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gamification_wheels`
--
ALTER TABLE `gamification_wheels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gift_cards`
--
ALTER TABLE `gift_cards`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`),
  ADD KEY `idx_gc_code` (`code`);

--
-- Indexes for table `group_buy_campaigns`
--
ALTER TABLE `group_buy_campaigns`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `group_buy_teams`
--
ALTER TABLE `group_buy_teams`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `team_code` (`team_code`);

--
-- Indexes for table `home_settings`
--
ALTER TABLE `home_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `influencers`
--
ALTER TABLE `influencers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs_queue`
--
ALTER TABLE `jobs_queue`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_jq_status_available` (`status`,`available_at`),
  ADD KEY `idx_jq_queue_status` (`queue`,`status`);

--
-- Indexes for table `loyalty_points`
--
ALTER TABLE `loyalty_points`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customer_id` (`customer_id`),
  ADD KEY `idx_lp_cust` (`customer_id`);

--
-- Indexes for table `loyalty_tiers`
--
ALTER TABLE `loyalty_tiers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tier_code` (`tier_code`);

--
-- Indexes for table `loyalty_transactions`
--
ALTER TABLE `loyalty_transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message_frequency_log`
--
ALTER TABLE `message_frequency_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_mfl_phone_time` (`recipient_phone`,`sent_at`),
  ADD KEY `idx_mfl_type` (`automation_type`);

--
-- Indexes for table `mystery_drops`
--
ALTER TABLE `mystery_drops`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_order_number` (`store_id`,`order_number`),
  ADD KEY `idx_order_store_status` (`store_id`,`status`),
  ADD KEY `idx_order_store_status_date` (`store_id`,`status`,`created_at`),
  ADD KEY `idx_order_customer` (`customer_id`),
  ADD KEY `idx_order_guest_email` (`guest_email`),
  ADD KEY `idx_order_created` (`created_at`),
  ADD KEY `idx_order_payment_status` (`store_id`,`payment_status`),
  ADD KEY `idx_order_fulfillment` (`store_id`,`fulfillment_status`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_oi_order` (`order_id`),
  ADD KEY `idx_oi_variant` (`variant_id`),
  ADD KEY `idx_oi_vendor` (`vendor_id`);

--
-- Indexes for table `order_timeline`
--
ALTER TABLE `order_timeline`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_ot_order` (`order_id`),
  ADD KEY `idx_ot_created` (`created_at`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `page_views`
--
ALTER TABLE `page_views`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_pv_store_created` (`store_id`,`created_at`),
  ADD KEY `idx_pv_session` (`session_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_pay_order` (`order_id`),
  ADD KEY `idx_pay_store` (`store_id`),
  ADD KEY `idx_pay_gateway_id` (`gateway_payment_id`),
  ADD KEY `idx_pay_gateway_order` (`gateway_order_id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `pimage`
--
ALTER TABLE `pimage`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `imid` (`imid`);

--
-- Indexes for table `pre_orders`
--
ALTER TABLE `pre_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `price_drop_alert_log`
--
ALTER TABLE `price_drop_alert_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_pda_cust` (`customer_id`);

--
-- Indexes for table `pricing_audit_log`
--
ALTER TABLE `pricing_audit_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_pal_prod` (`product_id`),
  ADD KEY `idx_pal_created` (`created_at`);

--
-- Indexes for table `pricing_rules`
--
ALTER TABLE `pricing_rules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_pr_store` (`store_id`),
  ADD KEY `idx_pr_active` (`store_id`,`is_active`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ccid` (`ccid`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_prod_slug_store` (`store_id`,`slug`),
  ADD KEY `idx_prod_store_status` (`store_id`,`status`),
  ADD KEY `idx_prod_store_status_created` (`store_id`,`status`,`created_at`),
  ADD KEY `idx_prod_collection` (`collection_id`),
  ADD KEY `idx_prod_search_sync` (`meilisearch_synced`);
ALTER TABLE `products` ADD FULLTEXT KEY `idx_prod_fulltext` (`title`,`search_vector`);

--
-- Indexes for table `product_bundles`
--
ALTER TABLE `product_bundles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_pb_prod` (`bundle_product_id`);

--
-- Indexes for table `product_bundle_items`
--
ALTER TABLE `product_bundle_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_pbi_bundle` (`bundle_id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_pimg_product` (`product_id`);

--
-- Indexes for table `product_options`
--
ALTER TABLE `product_options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_popt_product` (`product_id`);

--
-- Indexes for table `product_option_values`
--
ALTER TABLE `product_option_values`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_poptv_option` (`option_id`);

--
-- Indexes for table `product_performance_metrics`
--
ALTER TABLE `product_performance_metrics`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_id` (`product_id`),
  ADD KEY `idx_ppm_moat` (`data_moat_score`);

--
-- Indexes for table `product_reviews`
--
ALTER TABLE `product_reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `status` (`status`);

--
-- Indexes for table `product_variants`
--
ALTER TABLE `product_variants`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_pvar_sku` (`sku`),
  ADD KEY `idx_pvar_product` (`product_id`),
  ADD KEY `idx_pvar_product_active` (`product_id`,`is_active`);

--
-- Indexes for table `product_waitlist`
--
ALTER TABLE `product_waitlist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `product_winning_scores`
--
ALTER TABLE `product_winning_scores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_pws_score` (`winning_score`),
  ADD KEY `idx_pws_winner` (`is_flagged_winner`);

--
-- Indexes for table `promo`
--
ALTER TABLE `promo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `po_number` (`po_number`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `referrals`
--
ALTER TABLE `referrals`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `referral_code` (`referral_code`);

--
-- Indexes for table `refunds`
--
ALTER TABLE `refunds`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_ref_order` (`order_id`),
  ADD KEY `idx_ref_payment` (`payment_id`);

--
-- Indexes for table `replenishment_log`
--
ALTER TABLE `replenishment_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_rpl_status` (`status`);

--
-- Indexes for table `return_requests`
--
ALTER TABLE `return_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_rr_order` (`order_id`),
  ADD KEY `idx_rr_cust` (`customer_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_rev_product` (`product_id`),
  ADD KEY `idx_rev_store_status` (`store_id`,`status`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_roles_store` (`store_id`);

--
-- Indexes for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD PRIMARY KEY (`role_id`,`permission_id`),
  ADD KEY `idx_rp_perm` (`permission_id`);

--
-- Indexes for table `rto_risk_evaluations`
--
ALTER TABLE `rto_risk_evaluations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_rto_order` (`order_id`),
  ADD KEY `idx_rto_token` (`confirmation_token`);

--
-- Indexes for table `shipments`
--
ALTER TABLE `shipments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_shp_order` (`order_id`),
  ADD KEY `idx_shp_store` (`store_id`),
  ADD KEY `idx_shp_tracking` (`tracking_number`);

--
-- Indexes for table `shipment_items`
--
ALTER TABLE `shipment_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_shi_shipment` (`shipment_id`);

--
-- Indexes for table `shipping_rates`
--
ALTER TABLE `shipping_rates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_sr_zone` (`zone_id`);

--
-- Indexes for table `shipping_zones`
--
ALTER TABLE `shipping_zones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_sz_store` (`store_id`);

--
-- Indexes for table `size`
--
ALTER TABLE `size`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `szid` (`szid`);

--
-- Indexes for table `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stores`
--
ALTER TABLE `stores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `domain` (`domain`);

--
-- Indexes for table `store_positioning`
--
ALTER TABLE `store_positioning`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `store_id` (`store_id`);

--
-- Indexes for table `store_settings`
--
ALTER TABLE `store_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_store_key` (`store_id`,`key`);

--
-- Indexes for table `subscriptions`
--
ALTER TABLE `subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_sub_customer` (`customer_id`),
  ADD KEY `idx_sub_charge` (`status`,`next_charge_at`);

--
-- Indexes for table `subscription_plans`
--
ALTER TABLE `subscription_plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_sup_store` (`store_id`);

--
-- Indexes for table `supplier_orders`
--
ALTER TABLE `supplier_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_sord_order` (`order_id`),
  ADD KEY `idx_sord_supplier` (`supplier_id`),
  ADD KEY `idx_sord_status` (`status`);

--
-- Indexes for table `supplier_products`
--
ALTER TABLE `supplier_products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_sprod_supplier_pid` (`supplier_id`,`supplier_product_id`),
  ADD KEY `idx_sprod_supplier` (`supplier_id`),
  ADD KEY `idx_sprod_product` (`product_id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tid` (`tid`);

--
-- Indexes for table `ucontact`
--
ALTER TABLE `ucontact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `upsell_offers`
--
ALTER TABLE `upsell_offers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uid` (`uid`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `userdet`
--
ALTER TABLE `userdet`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uid` (`uid`);

--
-- Indexes for table `vendors`
--
ALTER TABLE `vendors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_v_status` (`status`);

--
-- Indexes for table `vendor_order_notifications`
--
ALTER TABLE `vendor_order_notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_von_vendor` (`vendor_id`),
  ADD KEY `idx_von_order` (`order_id`);

--
-- Indexes for table `vendor_payouts`
--
ALTER TABLE `vendor_payouts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_vp_vend_status` (`vendor_id`,`status`);

--
-- Indexes for table `vendor_payout_items`
--
ALTER TABLE `vendor_payout_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_vpi_payout` (`payout_id`),
  ADD KEY `idx_vpi_item` (`order_item_id`);

--
-- Indexes for table `vendor_products`
--
ALTER TABLE `vendor_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_vp_vendor` (`vendor_id`),
  ADD KEY `idx_vp_prod` (`product_id`),
  ADD KEY `idx_vp_status` (`approval_status`);

--
-- Indexes for table `vendor_users`
--
ALTER TABLE `vendor_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_vu_vendor` (`vendor_id`);

--
-- Indexes for table `wallet_transactions`
--
ALTER TABLE `wallet_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_wtx_customer` (`customer_id`),
  ADD KEY `idx_wtx_store` (`store_id`);

--
-- Indexes for table `warehouses`
--
ALTER TABLE `warehouses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `webhooks_log`
--
ALTER TABLE `webhooks_log`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_whl_hash` (`payload_hash`),
  ADD KEY `idx_whl_source_event` (`source`,`event`),
  ADD KEY `idx_whl_created` (`created_at`);

--
-- Indexes for table `webhook_deliveries`
--
ALTER TABLE `webhook_deliveries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_wd_sub` (`subscription_id`),
  ADD KEY `idx_wd_status` (`status`);

--
-- Indexes for table `webhook_subscriptions`
--
ALTER TABLE `webhook_subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_ws_event` (`event`,`is_active`);

--
-- Indexes for table `winback_log`
--
ALTER TABLE `winback_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_wbl_cust` (`customer_id`);

--
-- Indexes for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_wl_cust_prod` (`customer_id`,`product_id`),
  ADD KEY `idx_wl_product` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `abandoned_cart_log`
--
ALTER TABLE `abandoned_cart_log`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `abandoned_cart_sequences`
--
ALTER TABLE `abandoned_cart_sequences`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `abandoned_cart_steps`
--
ALTER TABLE `abandoned_cart_steps`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ad_campaigns`
--
ALTER TABLE `ad_campaigns`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `affiliate_payouts`
--
ALTER TABLE `affiliate_payouts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ai_agent_tasks`
--
ALTER TABLE `ai_agent_tasks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `ai_autopilot_configs`
--
ALTER TABLE `ai_autopilot_configs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ai_orchestrator_runs`
--
ALTER TABLE `ai_orchestrator_runs`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ai_swarm_telemetry`
--
ALTER TABLE `ai_swarm_telemetry`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `api_keys`
--
ALTER TABLE `api_keys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `api_request_log`
--
ALTER TABLE `api_request_log`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `audit_log`
--
ALTER TABLE `audit_log`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `automation_runs`
--
ALTER TABLE `automation_runs`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `back_in_stock_log`
--
ALTER TABLE `back_in_stock_log`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blog_posts`
--
ALTER TABLE `blog_posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `browse_abandonment_log`
--
ALTER TABLE `browse_abandonment_log`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `catgory`
--
ALTER TABLE `catgory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `collections`
--
ALTER TABLE `collections`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `contact_identities`
--
ALTER TABLE `contact_identities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `currency_rates`
--
ALTER TABLE `currency_rates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2503;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `customer_addresses`
--
ALTER TABLE `customer_addresses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_subscriptions`
--
ALTER TABLE `customer_subscriptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `description`
--
ALTER TABLE `description`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `discount`
--
ALTER TABLE `discount`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `discounts`
--
ALTER TABLE `discounts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `disimg`
--
ALTER TABLE `disimg`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `email_campaigns`
--
ALTER TABLE `email_campaigns`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `email_lists`
--
ALTER TABLE `email_lists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `email_segments`
--
ALTER TABLE `email_segments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `email_subscribers`
--
ALTER TABLE `email_subscribers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `email_templates`
--
ALTER TABLE `email_templates`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `error_log`
--
ALTER TABLE `error_log`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `flash_sales`
--
ALTER TABLE `flash_sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gamification_spins`
--
ALTER TABLE `gamification_spins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `gamification_wheels`
--
ALTER TABLE `gamification_wheels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `gift_cards`
--
ALTER TABLE `gift_cards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `group_buy_campaigns`
--
ALTER TABLE `group_buy_campaigns`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `group_buy_teams`
--
ALTER TABLE `group_buy_teams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `home_settings`
--
ALTER TABLE `home_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `influencers`
--
ALTER TABLE `influencers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `jobs_queue`
--
ALTER TABLE `jobs_queue`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `loyalty_points`
--
ALTER TABLE `loyalty_points`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loyalty_tiers`
--
ALTER TABLE `loyalty_tiers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1364;

--
-- AUTO_INCREMENT for table `loyalty_transactions`
--
ALTER TABLE `loyalty_transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `message_frequency_log`
--
ALTER TABLE `message_frequency_log`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mystery_drops`
--
ALTER TABLE `mystery_drops`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `order_timeline`
--
ALTER TABLE `order_timeline`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `page_views`
--
ALTER TABLE `page_views`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `pimage`
--
ALTER TABLE `pimage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pre_orders`
--
ALTER TABLE `pre_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `price_drop_alert_log`
--
ALTER TABLE `price_drop_alert_log`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pricing_audit_log`
--
ALTER TABLE `pricing_audit_log`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `pricing_rules`
--
ALTER TABLE `pricing_rules`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7135;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `product_bundles`
--
ALTER TABLE `product_bundles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1010;

--
-- AUTO_INCREMENT for table `product_bundle_items`
--
ALTER TABLE `product_bundle_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=454;

--
-- AUTO_INCREMENT for table `product_options`
--
ALTER TABLE `product_options`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_option_values`
--
ALTER TABLE `product_option_values`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_performance_metrics`
--
ALTER TABLE `product_performance_metrics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=241;

--
-- AUTO_INCREMENT for table `product_reviews`
--
ALTER TABLE `product_reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_variants`
--
ALTER TABLE `product_variants`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=472;

--
-- AUTO_INCREMENT for table `product_waitlist`
--
ALTER TABLE `product_waitlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `product_winning_scores`
--
ALTER TABLE `product_winning_scores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `promo`
--
ALTER TABLE `promo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `purchase_orders`
--
ALTER TABLE `purchase_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `referrals`
--
ALTER TABLE `referrals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `refunds`
--
ALTER TABLE `refunds`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `replenishment_log`
--
ALTER TABLE `replenishment_log`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `return_requests`
--
ALTER TABLE `return_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `rto_risk_evaluations`
--
ALTER TABLE `rto_risk_evaluations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `shipments`
--
ALTER TABLE `shipments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `shipment_items`
--
ALTER TABLE `shipment_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `shipping_rates`
--
ALTER TABLE `shipping_rates`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `shipping_zones`
--
ALTER TABLE `shipping_zones`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `size`
--
ALTER TABLE `size`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stores`
--
ALTER TABLE `stores`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `store_positioning`
--
ALTER TABLE `store_positioning`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=522;

--
-- AUTO_INCREMENT for table `store_settings`
--
ALTER TABLE `store_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subscriptions`
--
ALTER TABLE `subscriptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `subscription_plans`
--
ALTER TABLE `subscription_plans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `supplier_orders`
--
ALTER TABLE `supplier_orders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `supplier_products`
--
ALTER TABLE `supplier_products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ucontact`
--
ALTER TABLE `ucontact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `upsell_offers`
--
ALTER TABLE `upsell_offers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1333;

--
-- AUTO_INCREMENT for table `userdet`
--
ALTER TABLE `userdet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1333;

--
-- AUTO_INCREMENT for table `vendors`
--
ALTER TABLE `vendors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `vendor_order_notifications`
--
ALTER TABLE `vendor_order_notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `vendor_payouts`
--
ALTER TABLE `vendor_payouts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `vendor_payout_items`
--
ALTER TABLE `vendor_payout_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `vendor_products`
--
ALTER TABLE `vendor_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `vendor_users`
--
ALTER TABLE `vendor_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `wallet_transactions`
--
ALTER TABLE `wallet_transactions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `warehouses`
--
ALTER TABLE `warehouses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1075;

--
-- AUTO_INCREMENT for table `webhooks_log`
--
ALTER TABLE `webhooks_log`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `webhook_deliveries`
--
ALTER TABLE `webhook_deliveries`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `webhook_subscriptions`
--
ALTER TABLE `webhook_subscriptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `winback_log`
--
ALTER TABLE `winback_log`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
