-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 27, 2022 at 04:02 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gamecard`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `aid` int(10) UNSIGNED NOT NULL,
  `uid` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `fullname` varchar(255) NOT NULL DEFAULT '',
  `phone` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(100) NOT NULL,
  `company` varchar(255) NOT NULL DEFAULT '',
  `street` varchar(255) NOT NULL DEFAULT '',
  `city` varchar(255) NOT NULL DEFAULT '',
  `postal_code` varchar(255) NOT NULL DEFAULT '',
  `country` varchar(20) NOT NULL,
  `created` int(11) NOT NULL DEFAULT '0',
  `modified` int(11) NOT NULL DEFAULT '0',
  `country_code` varchar(2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `country_id` int(10) NOT NULL COMMENT 'Three-digit country number (ISO 3166-1 numeric)',
  `country_iso_code_2` char(2) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Two-letter country code (ISO 3166-1 alpha-2)',
  `country_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'English country name',
  `country_full_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Full English country name',
  `country_iso_code_3` char(3) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Three-letter country code (ISO 3166-1 alpha-3)',
  `country_currency` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `currency_name` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `currrency_symbol` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `continent_code` char(2) COLLATE utf8_unicode_ci DEFAULT NULL,
  `flag` varchar(6) COLLATE utf8_unicode_ci DEFAULT NULL,
  `version` smallint(6) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `currencyapi`
--

CREATE TABLE `currencyapi` (
  `currency_from` varchar(10) NOT NULL DEFAULT '',
  `currency_to` varchar(10) NOT NULL DEFAULT '',
  `rate` float NOT NULL DEFAULT '0',
  `timestamp` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `easyii_admins`
--

CREATE TABLE `easyii_admins` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(64) NOT NULL,
  `author_data` varchar(1000) NOT NULL,
  `auth_key` varchar(128) NOT NULL,
  `access_token` varchar(128) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `easyii_article_categories`
--

CREATE TABLE `easyii_article_categories` (
  `category_id` int(11) NOT NULL,
  `title` varchar(128) NOT NULL,
  `image` varchar(128) DEFAULT NULL,
  `order_num` int(11) NOT NULL,
  `slug` varchar(128) DEFAULT NULL,
  `tree` int(11) NOT NULL,
  `lft` int(11) NOT NULL,
  `rgt` int(11) NOT NULL,
  `depth` int(11) NOT NULL,
  `status` tinyint(1) DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `easyii_article_items`
--

CREATE TABLE `easyii_article_items` (
  `item_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `title` varchar(128) NOT NULL,
  `image` varchar(128) DEFAULT NULL,
  `images` varchar(128) DEFAULT NULL,
  `short` varchar(1024) DEFAULT NULL,
  `text` longtext NOT NULL,
  `slug` varchar(128) DEFAULT NULL,
  `time` int(11) DEFAULT '0',
  `views` int(11) DEFAULT '0',
  `status` tinyint(1) DEFAULT '1',
  `highlights` tinyint(1) NOT NULL,
  `id_khuyenmai` tinyint(4) NOT NULL COMMENT '0 Tất cả 1 Khuyến mãi dành cho khách Việt Nam 2 Khuyến mãi dành cho khách Nước Ngoài'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `easyii_carousel`
--

CREATE TABLE `easyii_carousel` (
  `carousel_id` int(11) NOT NULL,
  `image` varchar(128) NOT NULL,
  `link` varchar(255) NOT NULL,
  `title` varchar(128) DEFAULT NULL,
  `text` text,
  `order_num` int(11) NOT NULL,
  `status` tinyint(1) DEFAULT '1',
  `id_khuyenmai` tinyint(4) NOT NULL COMMENT '0 Tất cả 1 Khuyến mãi dành cho khách Việt Nam 2 Khuyến mãi dành cho khách Nước Ngoài'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `easyii_catalog_categories`
--

CREATE TABLE `easyii_catalog_categories` (
  `category_id` int(11) NOT NULL,
  `title` varchar(128) NOT NULL,
  `image` varchar(128) DEFAULT NULL,
  `images` varchar(128) DEFAULT NULL,
  `fields` text NOT NULL,
  `slug` varchar(128) DEFAULT NULL,
  `tree` int(11) NOT NULL,
  `lft` int(11) NOT NULL,
  `rgt` int(11) NOT NULL,
  `depth` int(11) NOT NULL,
  `order_num` int(11) NOT NULL,
  `status` tinyint(1) DEFAULT '1',
  `descriptstion` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `easyii_catalog_items`
--

CREATE TABLE `easyii_catalog_items` (
  `item_id` int(11) NOT NULL,
  `sku` varchar(100) NOT NULL,
  `category_id` int(11) NOT NULL,
  `title` varchar(128) NOT NULL,
  `description` text,
  `available` int(11) DEFAULT '1',
  `price` float DEFAULT '0',
  `discount` int(11) DEFAULT '0',
  `data` text NOT NULL,
  `image` varchar(128) DEFAULT NULL,
  `slug` varchar(128) DEFAULT NULL,
  `time` int(11) DEFAULT '0',
  `status` tinyint(1) DEFAULT '1',
  `quatang` tinyint(1) DEFAULT '0',
  `combo` tinyint(1) NOT NULL DEFAULT '0',
  `string_items` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `easyii_catalog_items_price`
--

CREATE TABLE `easyii_catalog_items_price` (
  `price_id` bigint(20) UNSIGNED NOT NULL,
  `price` decimal(20,5) NOT NULL,
  `country` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `notation` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'VND',
  `items_id` bigint(20) NOT NULL,
  `price_default` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `easyii_catalog_item_data`
--

CREATE TABLE `easyii_catalog_item_data` (
  `data_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `value` varchar(1024) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `easyii_doituyen`
--

CREATE TABLE `easyii_doituyen` (
  `doituyen_id` int(11) UNSIGNED NOT NULL,
  `title` varchar(128) NOT NULL,
  `image` varchar(128) DEFAULT NULL,
  `images` varchar(128) DEFAULT NULL,
  `short` varchar(1024) DEFAULT NULL,
  `text` text NOT NULL,
  `slug` varchar(128) DEFAULT NULL,
  `time` int(11) DEFAULT '0',
  `views` int(11) DEFAULT '0',
  `status` tinyint(1) DEFAULT '1',
  `thutu` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `easyii_dudoan`
--

CREATE TABLE `easyii_dudoan` (
  `dudoan_id` int(11) UNSIGNED NOT NULL,
  `trandau_id` int(10) UNSIGNED NOT NULL,
  `doituyen_id1` int(10) UNSIGNED NOT NULL,
  `banthang1` int(10) UNSIGNED NOT NULL,
  `doituyen_id2` int(10) UNSIGNED NOT NULL,
  `banthang2` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `email` text NOT NULL,
  `luotdudoangiongban` int(10) UNSIGNED NOT NULL,
  `vongdau` int(11) NOT NULL,
  `title` varchar(128) NOT NULL,
  `image` varchar(128) DEFAULT NULL,
  `images` varchar(128) DEFAULT NULL,
  `short` varchar(1024) DEFAULT NULL,
  `text` text NOT NULL,
  `slug` varchar(128) DEFAULT NULL,
  `time` int(11) DEFAULT '0',
  `views` int(11) DEFAULT '0',
  `status` tinyint(1) DEFAULT '1',
  `thutu` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `easyii_eventcard`
--

CREATE TABLE `easyii_eventcard` (
  `eventcard_id` int(11) NOT NULL,
  `title` varchar(128) NOT NULL,
  `image` varchar(128) DEFAULT NULL,
  `images` varchar(128) DEFAULT NULL,
  `short` varchar(1024) DEFAULT NULL,
  `text` text NOT NULL,
  `slug` varchar(128) DEFAULT NULL,
  `time` int(11) DEFAULT '0',
  `views` int(11) DEFAULT '0',
  `status` tinyint(1) DEFAULT '1',
  `thutu` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `easyii_faq`
--

CREATE TABLE `easyii_faq` (
  `faq_id` int(11) NOT NULL,
  `question` text NOT NULL,
  `answer` text NOT NULL,
  `order_num` int(11) NOT NULL,
  `status` tinyint(1) DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `easyii_feedback`
--

CREATE TABLE `easyii_feedback` (
  `feedback_id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `email` varchar(128) NOT NULL,
  `phone` varchar(64) DEFAULT NULL,
  `title` varchar(128) DEFAULT NULL,
  `text` text NOT NULL,
  `answer_subject` varchar(128) DEFAULT NULL,
  `answer_text` text,
  `time` int(11) DEFAULT '0',
  `ip` varchar(16) NOT NULL,
  `status` tinyint(1) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `easyii_files`
--

CREATE TABLE `easyii_files` (
  `file_id` int(11) NOT NULL,
  `title` varchar(128) NOT NULL,
  `file` varchar(255) NOT NULL,
  `size` int(11) NOT NULL,
  `slug` varchar(128) DEFAULT NULL,
  `downloads` int(11) DEFAULT '0',
  `time` int(11) DEFAULT '0',
  `order_num` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `easyii_gallery_categories`
--

CREATE TABLE `easyii_gallery_categories` (
  `category_id` int(11) NOT NULL,
  `title` varchar(128) NOT NULL,
  `image` varchar(128) DEFAULT NULL,
  `slug` varchar(128) DEFAULT NULL,
  `tree` int(11) NOT NULL,
  `lft` int(11) NOT NULL,
  `rgt` int(11) NOT NULL,
  `depth` int(11) NOT NULL,
  `order_num` int(11) NOT NULL,
  `status` tinyint(1) DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `easyii_guestbook`
--

CREATE TABLE `easyii_guestbook` (
  `guestbook_id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `title` varchar(128) DEFAULT NULL,
  `text` text NOT NULL,
  `answer` text NOT NULL,
  `email` varchar(128) DEFAULT NULL,
  `time` int(11) DEFAULT '0',
  `ip` varchar(16) NOT NULL,
  `new` tinyint(1) DEFAULT '0',
  `status` tinyint(1) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `easyii_loginform`
--

CREATE TABLE `easyii_loginform` (
  `log_id` int(11) NOT NULL,
  `username` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `ip` varchar(16) NOT NULL,
  `user_agent` varchar(1024) NOT NULL,
  `time` int(11) DEFAULT '0',
  `success` tinyint(1) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `easyii_migration`
--

CREATE TABLE `easyii_migration` (
  `version` varchar(180) COLLATE utf32_unicode_ci NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `easyii_modules`
--

CREATE TABLE `easyii_modules` (
  `module_id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `class` varchar(128) NOT NULL,
  `title` varchar(128) NOT NULL,
  `icon` varchar(32) NOT NULL,
  `settings` text NOT NULL,
  `notice` int(11) DEFAULT '0',
  `order_num` int(11) NOT NULL,
  `status` tinyint(1) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `easyii_news`
--

CREATE TABLE `easyii_news` (
  `news_id` int(11) NOT NULL,
  `title` varchar(128) NOT NULL,
  `image` varchar(128) DEFAULT NULL,
  `short` varchar(1024) DEFAULT NULL,
  `text` text NOT NULL,
  `slug` varchar(128) DEFAULT NULL,
  `time` int(11) DEFAULT '0',
  `views` int(11) DEFAULT '0',
  `status` tinyint(1) DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `easyii_nhanvat`
--

CREATE TABLE `easyii_nhanvat` (
  `nhanvat_id` int(11) NOT NULL,
  `title` varchar(128) NOT NULL,
  `image` varchar(128) DEFAULT NULL,
  `short` varchar(1024) DEFAULT NULL,
  `text` text NOT NULL,
  `slug` varchar(128) DEFAULT NULL,
  `time` int(11) DEFAULT '0',
  `views` int(11) DEFAULT '0',
  `status` tinyint(1) DEFAULT '1',
  `frequency` int(10) NOT NULL,
  `code` varchar(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `easyii_nhanvat_orderluotgui`
--

CREATE TABLE `easyii_nhanvat_orderluotgui` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `easyii_nhanvat_user`
--

CREATE TABLE `easyii_nhanvat_user` (
  `nhanvat_user_id` int(11) NOT NULL,
  `time` int(11) DEFAULT '0',
  `nhanvat_id` int(10) UNSIGNED NOT NULL,
  `namenv` varchar(50) DEFAULT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `email` varchar(150) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `easyii_nvuser_list`
--

CREATE TABLE `easyii_nvuser_list` (
  `nvuser_list_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `email` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `listnhanvatnhan` text COLLATE utf8_unicode_ci NOT NULL,
  `number_img` int(10) UNSIGNED NOT NULL,
  `timegiaiba` int(11) UNSIGNED DEFAULT NULL,
  `timegiainhi` int(11) UNSIGNED DEFAULT NULL,
  `timegiainhat` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `easyii_pages`
--

CREATE TABLE `easyii_pages` (
  `page_id` int(11) NOT NULL,
  `title` varchar(128) NOT NULL,
  `text` text NOT NULL,
  `slug` varchar(128) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `easyii_payment`
--

CREATE TABLE `easyii_payment` (
  `payment_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `payment_fee` int(10) NOT NULL,
  `status` tinyint(1) DEFAULT '1',
  `currency` varchar(50) NOT NULL,
  `order_num` int(11) NOT NULL,
  `list_user_chan` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `easyii_photos`
--

CREATE TABLE `easyii_photos` (
  `photo_id` int(11) NOT NULL,
  `class` varchar(128) NOT NULL,
  `item_id` int(11) NOT NULL,
  `image` varchar(128) NOT NULL,
  `description` varchar(1024) NOT NULL,
  `order_num` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `easyii_seotext`
--

CREATE TABLE `easyii_seotext` (
  `seotext_id` int(11) NOT NULL,
  `class` varchar(128) NOT NULL,
  `item_id` int(11) NOT NULL,
  `h1` varchar(300) DEFAULT NULL,
  `title` varchar(300) DEFAULT NULL,
  `keywords` varchar(500) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `easyii_settings`
--

CREATE TABLE `easyii_settings` (
  `setting_id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `title` varchar(128) NOT NULL,
  `value` varchar(1024) NOT NULL,
  `visibility` tinyint(1) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `easyii_shopcart_goods`
--

CREATE TABLE `easyii_shopcart_goods` (
  `good_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `sku` varchar(100) NOT NULL,
  `count` int(11) NOT NULL,
  `options` varchar(255) NOT NULL,
  `price` decimal(20,5) DEFAULT '0.00000',
  `discount` int(11) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `easyii_shopcart_orders`
--

CREATE TABLE `easyii_shopcart_orders` (
  `order_id` int(11) NOT NULL,
  `order_code` varchar(20) NOT NULL,
  `user_id` int(10) NOT NULL,
  `email` varchar(128) NOT NULL,
  `order_zing_id` varchar(100) DEFAULT NULL,
  `name` varchar(64) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(100) NOT NULL,
  `country` varchar(50) NOT NULL,
  `zipcode` varchar(30) NOT NULL,
  `payment_method` varchar(100) NOT NULL,
  `data` text,
  `info_payer` text,
  `store_currency` varchar(3) NOT NULL,
  `sale_currency` varchar(3) NOT NULL,
  `order_total` decimal(20,2) NOT NULL,
  `order_fee` decimal(20,2) NOT NULL,
  `phone` varchar(64) NOT NULL,
  `comment` varchar(1024) NOT NULL,
  `remark` varchar(1024) NOT NULL,
  `access_token` varchar(32) NOT NULL,
  `ip` varchar(128) NOT NULL,
  `time` int(11) DEFAULT '0',
  `new` text COMMENT 'list item if combo card',
  `status` varchar(50) DEFAULT 'in_checkout',
  `workflow` int(10) NOT NULL,
  `type_submit` tinyint(4) DEFAULT NULL,
  `delivery_name` varchar(100) DEFAULT NULL,
  `delivery_phone` varchar(100) DEFAULT NULL,
  `delivery_company` varchar(500) DEFAULT NULL,
  `delivery_address` text,
  `delivery_city` varchar(500) DEFAULT NULL,
  `delivery_message` text,
  `delivery_date` int(11) DEFAULT NULL,
  `delivery_fee` decimal(20,2) DEFAULT NULL,
  `delivery_transport` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `easyii_subscribe_history`
--

CREATE TABLE `easyii_subscribe_history` (
  `history_id` int(11) NOT NULL,
  `subject` varchar(128) NOT NULL,
  `body` text NOT NULL,
  `sent` int(11) DEFAULT '0',
  `time` int(11) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `easyii_subscribe_subscribers`
--

CREATE TABLE `easyii_subscribe_subscribers` (
  `subscriber_id` int(11) NOT NULL,
  `email` varchar(128) NOT NULL,
  `ip` varchar(16) NOT NULL,
  `time` int(11) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `easyii_tags`
--

CREATE TABLE `easyii_tags` (
  `tag_id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `frequency` int(11) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `easyii_tags_assign`
--

CREATE TABLE `easyii_tags_assign` (
  `class` varchar(128) NOT NULL,
  `item_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `easyii_test`
--

CREATE TABLE `easyii_test` (
  `id_test` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `easyii_testm`
--

CREATE TABLE `easyii_testm` (
  `testm_id` int(11) NOT NULL,
  `title` varchar(128) NOT NULL,
  `image` varchar(128) DEFAULT NULL,
  `short` varchar(1024) DEFAULT NULL,
  `text` text NOT NULL,
  `slug` varchar(128) DEFAULT NULL,
  `time` int(11) DEFAULT '0',
  `views` int(11) DEFAULT '0',
  `status` tinyint(1) DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `easyii_texts`
--

CREATE TABLE `easyii_texts` (
  `text_id` int(11) NOT NULL,
  `text` text NOT NULL,
  `slug` varchar(128) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `easyii_trandau`
--

CREATE TABLE `easyii_trandau` (
  `trandau_id` int(11) UNSIGNED NOT NULL,
  `doituyen_id1` int(10) UNSIGNED NOT NULL,
  `doituyen_id2` int(10) UNSIGNED NOT NULL,
  `title` varchar(128) NOT NULL,
  `image` varchar(128) DEFAULT NULL,
  `images` varchar(128) DEFAULT NULL,
  `short` varchar(1024) DEFAULT NULL,
  `text` text NOT NULL,
  `slug` varchar(128) DEFAULT NULL,
  `time` int(11) DEFAULT '0',
  `views` int(11) DEFAULT '0',
  `status` tinyint(1) DEFAULT '1',
  `thutu` int(11) NOT NULL,
  `vongdau` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `easyii_userluotdoan`
--

CREATE TABLE `easyii_userluotdoan` (
  `userluotdoan_id` int(11) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `email` varchar(128) DEFAULT NULL,
  `title` varchar(128) NOT NULL,
  `image` varchar(128) DEFAULT NULL,
  `images` varchar(128) DEFAULT NULL,
  `short` varchar(1024) DEFAULT NULL,
  `text` text NOT NULL,
  `slug` varchar(128) DEFAULT NULL,
  `time` int(11) DEFAULT '0',
  `views` int(11) DEFAULT '0',
  `status` tinyint(1) DEFAULT '1',
  `thutu` int(11) NOT NULL,
  `luotdoan` int(11) UNSIGNED NOT NULL,
  `vongduocdoan` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `eventorder`
--

CREATE TABLE `eventorder` (
  `id` int(10) UNSIGNED NOT NULL,
  `email` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `date_created` int(11) NOT NULL,
  `eventcard` int(11) NOT NULL,
  `namecard` varchar(128) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gxc_user`
--

CREATE TABLE `gxc_user` (
  `id` bigint(20) NOT NULL,
  `username` varchar(128) NOT NULL,
  `user_url` varchar(128) DEFAULT NULL,
  `display_name` varchar(255) NOT NULL,
  `password` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `fbuid` bigint(20) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_time` int(11) NOT NULL,
  `updated_time` int(11) NOT NULL,
  `recent_login` int(11) NOT NULL,
  `user_activation_key` varchar(255) NOT NULL DEFAULT '',
  `confirmed` tinyint(2) NOT NULL DEFAULT '0',
  `gender` varchar(10) DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `bio` text,
  `birthday_month` varchar(50) DEFAULT NULL,
  `birthday_day` varchar(2) DEFAULT NULL,
  `birthday_year` varchar(4) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `email_site_news` tinyint(1) NOT NULL DEFAULT '1',
  `email_search_alert` tinyint(1) NOT NULL DEFAULT '1',
  `email_recover_key` varchar(255) DEFAULT NULL,
  `group` int(10) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `gxc_user_addresses`
--

CREATE TABLE `gxc_user_addresses` (
  `aid` int(10) UNSIGNED NOT NULL,
  `uid` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `first_name` varchar(255) NOT NULL DEFAULT '',
  `last_name` varchar(255) DEFAULT NULL,
  `phone` varchar(255) NOT NULL DEFAULT '',
  `company` varchar(255) DEFAULT NULL,
  `street1` varchar(255) NOT NULL DEFAULT '',
  `street2` varchar(255) DEFAULT NULL,
  `city` varchar(255) NOT NULL DEFAULT '',
  `zone` mediumint(9) NOT NULL DEFAULT '0',
  `state` int(11) NOT NULL,
  `postal_code` varchar(255) NOT NULL DEFAULT '',
  `country` mediumint(8) UNSIGNED NOT NULL DEFAULT '0',
  `address_name` varchar(20) DEFAULT NULL,
  `created` int(11) NOT NULL DEFAULT '0',
  `modified` int(11) DEFAULT NULL,
  `country_code` varchar(2) NOT NULL,
  `country_name` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `gxc_user_countries`
--

CREATE TABLE `gxc_user_countries` (
  `country_id` int(10) NOT NULL COMMENT 'Three-digit country number (ISO 3166-1 numeric)',
  `country_iso_code_2` char(2) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Two-letter country code (ISO 3166-1 alpha-2)',
  `country_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'English country name',
  `country_full_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Full English country name',
  `country_iso_code_3` char(3) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Three-letter country code (ISO 3166-1 alpha-3)',
  `country_currency` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `currency_name` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `currrency_symbol` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `continent_code` char(2) COLLATE utf8_unicode_ci DEFAULT NULL,
  `flag` varchar(6) COLLATE utf8_unicode_ci DEFAULT NULL,
  `version` smallint(6) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gxc_zones`
--

CREATE TABLE `gxc_zones` (
  `zone_id` int(10) UNSIGNED NOT NULL,
  `zone_country_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `zone_code` varchar(32) NOT NULL DEFAULT '',
  `zone_name` varchar(255) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ipaddress`
--

CREATE TABLE `ipaddress` (
  `ipAddress` varchar(20) NOT NULL,
  `data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `manager_ctv`
--

CREATE TABLE `manager_ctv` (
  `id` int(10) UNSIGNED NOT NULL,
  `ctv_id` int(11) NOT NULL,
  `customer_ip` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `country_code` varchar(2) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `price_id` int(10) UNSIGNED NOT NULL,
  `price` int(10) UNSIGNED NOT NULL,
  `forumsurl` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `user_agent` varchar(1024) COLLATE utf8_unicode_ci NOT NULL,
  `spam` tinyint(1) NOT NULL DEFAULT '0',
  `note` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `month` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `year` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `stringday` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `created` int(11) NOT NULL,
  `randonkey` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 visitor 1 register 2 shoping',
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `currency` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tigia` int(11) DEFAULT NULL,
  `thanhtien` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) COLLATE utf32_unicode_ci NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_item`
--

CREATE TABLE `order_item` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `price` decimal(19,4) DEFAULT NULL,
  `order_total_price` decimal(19,4) NOT NULL,
  `item_id` int(11) DEFAULT NULL,
  `quantity` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_luotdoan`
--

CREATE TABLE `order_luotdoan` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_user_item_cart`
--

CREATE TABLE `order_user_item_cart` (
  `id` int(10) NOT NULL,
  `order_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `content` text NOT NULL,
  `created` int(10) NOT NULL,
  `note` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pay_ctv`
--

CREATE TABLE `pay_ctv` (
  `id` int(10) UNSIGNED NOT NULL,
  `admins_id` int(10) UNSIGNED NOT NULL,
  `money` int(10) UNSIGNED NOT NULL,
  `ngaypay` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `created` int(10) UNSIGNED NOT NULL,
  `admins_admins` int(10) UNSIGNED NOT NULL,
  `note` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `price_ctv`
--

CREATE TABLE `price_ctv` (
  `id` int(10) UNSIGNED NOT NULL,
  `visitor` int(10) UNSIGNED NOT NULL,
  `register` int(10) UNSIGNED NOT NULL,
  `shoping` int(10) UNSIGNED NOT NULL,
  `created` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

CREATE TABLE `profile` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `create_time` timestamp NULL DEFAULT NULL,
  `update_time` timestamp NULL DEFAULT NULL,
  `full_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `create_time` timestamp NULL DEFAULT NULL,
  `update_time` timestamp NULL DEFAULT NULL,
  `can_admin` smallint(6) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `savestatususer`
--

CREATE TABLE `savestatususer` (
  `idStatus` int(12) NOT NULL,
  `ipStatus` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `time` double NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sharefb`
--

CREATE TABLE `sharefb` (
  `id` int(20) NOT NULL,
  `email` varchar(225) NOT NULL,
  `time` int(20) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `totalvote`
--

CREATE TABLE `totalvote` (
  `id` int(10) UNSIGNED NOT NULL,
  `news_id` int(11) NOT NULL,
  `news_title` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `totalvotemiss` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transport_fee`
--

CREATE TABLE `transport_fee` (
  `transport_id` int(11) NOT NULL,
  `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `price` double NOT NULL,
  `status` int(1) NOT NULL,
  `currency` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `number_use` int(11) NOT NULL,
  `order_num` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `status` smallint(6) NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `new_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `auth_key` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `api_key` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `login_ip` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `login_time` timestamp NULL DEFAULT NULL,
  `create_ip` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `create_time` timestamp NULL DEFAULT NULL,
  `update_time` timestamp NULL DEFAULT NULL,
  `ban_time` timestamp NULL DEFAULT NULL,
  `ban_reason` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_auth`
--

CREATE TABLE `user_auth` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `provider` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `provider_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `provider_attributes` text COLLATE utf8_unicode_ci NOT NULL,
  `create_time` timestamp NULL DEFAULT NULL,
  `update_time` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_history_money`
--

CREATE TABLE `user_history_money` (
  `id` int(10) UNSIGNED NOT NULL,
  `money_send` decimal(20,2) NOT NULL,
  `currency_send` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `payment_method` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `currency_payment_method` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `date` int(11) UNSIGNED NOT NULL,
  `uid` int(10) UNSIGNED NOT NULL,
  `status` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `fee_send` decimal(20,2) NOT NULL,
  `money_payment_method` decimal(20,2) NOT NULL,
  `total_payment_method` decimal(20,2) NOT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `rounding` tinyint(4) DEFAULT NULL,
  `workflow` int(11) NOT NULL,
  `ip` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `money_usd` decimal(20,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_key`
--

CREATE TABLE `user_key` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` smallint(6) NOT NULL,
  `key_value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `create_time` timestamp NULL DEFAULT NULL,
  `consume_time` timestamp NULL DEFAULT NULL,
  `expire_time` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_money`
--

CREATE TABLE `user_money` (
  `id` int(11) NOT NULL,
  `uid` int(10) UNSIGNED NOT NULL,
  `money` decimal(20,2) NOT NULL,
  `currency` varchar(3) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vote_missgame`
--

CREATE TABLE `vote_missgame` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `email` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `news_id` int(11) NOT NULL,
  `news_title` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `time` int(11) NOT NULL,
  `date` int(11) DEFAULT NULL,
  `month` int(11) DEFAULT NULL,
  `year` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `zones`
--

CREATE TABLE `zones` (
  `zone_id` int(10) UNSIGNED NOT NULL,
  `zone_country_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `zone_code` varchar(32) NOT NULL DEFAULT '',
  `zone_name` varchar(255) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`aid`),
  ADD KEY `aid_uid_idx` (`aid`,`uid`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`country_id`);

--
-- Indexes for table `currencyapi`
--
ALTER TABLE `currencyapi`
  ADD PRIMARY KEY (`currency_from`,`currency_to`);

--
-- Indexes for table `easyii_admins`
--
ALTER TABLE `easyii_admins`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `access_token` (`access_token`);

--
-- Indexes for table `easyii_article_categories`
--
ALTER TABLE `easyii_article_categories`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `easyii_article_items`
--
ALTER TABLE `easyii_article_items`
  ADD PRIMARY KEY (`item_id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `easyii_carousel`
--
ALTER TABLE `easyii_carousel`
  ADD PRIMARY KEY (`carousel_id`);

--
-- Indexes for table `easyii_catalog_categories`
--
ALTER TABLE `easyii_catalog_categories`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `easyii_catalog_items`
--
ALTER TABLE `easyii_catalog_items`
  ADD PRIMARY KEY (`item_id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `easyii_catalog_items_price`
--
ALTER TABLE `easyii_catalog_items_price`
  ADD PRIMARY KEY (`price_id`);

--
-- Indexes for table `easyii_catalog_item_data`
--
ALTER TABLE `easyii_catalog_item_data`
  ADD PRIMARY KEY (`data_id`),
  ADD KEY `item_id_name` (`item_id`,`name`),
  ADD KEY `value` (`value`(333));

--
-- Indexes for table `easyii_doituyen`
--
ALTER TABLE `easyii_doituyen`
  ADD PRIMARY KEY (`doituyen_id`);

--
-- Indexes for table `easyii_dudoan`
--
ALTER TABLE `easyii_dudoan`
  ADD PRIMARY KEY (`dudoan_id`);

--
-- Indexes for table `easyii_eventcard`
--
ALTER TABLE `easyii_eventcard`
  ADD PRIMARY KEY (`eventcard_id`);

--
-- Indexes for table `easyii_faq`
--
ALTER TABLE `easyii_faq`
  ADD PRIMARY KEY (`faq_id`);

--
-- Indexes for table `easyii_feedback`
--
ALTER TABLE `easyii_feedback`
  ADD PRIMARY KEY (`feedback_id`);

--
-- Indexes for table `easyii_files`
--
ALTER TABLE `easyii_files`
  ADD PRIMARY KEY (`file_id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `easyii_gallery_categories`
--
ALTER TABLE `easyii_gallery_categories`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `easyii_guestbook`
--
ALTER TABLE `easyii_guestbook`
  ADD PRIMARY KEY (`guestbook_id`);

--
-- Indexes for table `easyii_loginform`
--
ALTER TABLE `easyii_loginform`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `easyii_migration`
--
ALTER TABLE `easyii_migration`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `easyii_modules`
--
ALTER TABLE `easyii_modules`
  ADD PRIMARY KEY (`module_id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `easyii_news`
--
ALTER TABLE `easyii_news`
  ADD PRIMARY KEY (`news_id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `easyii_nhanvat`
--
ALTER TABLE `easyii_nhanvat`
  ADD PRIMARY KEY (`nhanvat_id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `easyii_nhanvat_orderluotgui`
--
ALTER TABLE `easyii_nhanvat_orderluotgui`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `easyii_nhanvat_user`
--
ALTER TABLE `easyii_nhanvat_user`
  ADD PRIMARY KEY (`nhanvat_user_id`);

--
-- Indexes for table `easyii_nvuser_list`
--
ALTER TABLE `easyii_nvuser_list`
  ADD PRIMARY KEY (`nvuser_list_id`);

--
-- Indexes for table `easyii_pages`
--
ALTER TABLE `easyii_pages`
  ADD PRIMARY KEY (`page_id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `easyii_payment`
--
ALTER TABLE `easyii_payment`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `easyii_photos`
--
ALTER TABLE `easyii_photos`
  ADD PRIMARY KEY (`photo_id`),
  ADD KEY `model_item` (`class`,`item_id`);

--
-- Indexes for table `easyii_seotext`
--
ALTER TABLE `easyii_seotext`
  ADD PRIMARY KEY (`seotext_id`),
  ADD UNIQUE KEY `model_item` (`class`,`item_id`);

--
-- Indexes for table `easyii_settings`
--
ALTER TABLE `easyii_settings`
  ADD PRIMARY KEY (`setting_id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `easyii_shopcart_goods`
--
ALTER TABLE `easyii_shopcart_goods`
  ADD PRIMARY KEY (`good_id`);

--
-- Indexes for table `easyii_shopcart_orders`
--
ALTER TABLE `easyii_shopcart_orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `easyii_subscribe_history`
--
ALTER TABLE `easyii_subscribe_history`
  ADD PRIMARY KEY (`history_id`);

--
-- Indexes for table `easyii_subscribe_subscribers`
--
ALTER TABLE `easyii_subscribe_subscribers`
  ADD PRIMARY KEY (`subscriber_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `easyii_tags`
--
ALTER TABLE `easyii_tags`
  ADD PRIMARY KEY (`tag_id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `easyii_tags_assign`
--
ALTER TABLE `easyii_tags_assign`
  ADD KEY `class` (`class`),
  ADD KEY `item_tag` (`item_id`,`tag_id`);

--
-- Indexes for table `easyii_test`
--
ALTER TABLE `easyii_test`
  ADD PRIMARY KEY (`id_test`);

--
-- Indexes for table `easyii_testm`
--
ALTER TABLE `easyii_testm`
  ADD PRIMARY KEY (`testm_id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `easyii_texts`
--
ALTER TABLE `easyii_texts`
  ADD PRIMARY KEY (`text_id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `easyii_trandau`
--
ALTER TABLE `easyii_trandau`
  ADD PRIMARY KEY (`trandau_id`);

--
-- Indexes for table `easyii_userluotdoan`
--
ALTER TABLE `easyii_userluotdoan`
  ADD PRIMARY KEY (`userluotdoan_id`);

--
-- Indexes for table `eventorder`
--
ALTER TABLE `eventorder`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gxc_user`
--
ALTER TABLE `gxc_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`),
  ADD KEY `email` (`email`);

--
-- Indexes for table `gxc_user_addresses`
--
ALTER TABLE `gxc_user_addresses`
  ADD PRIMARY KEY (`aid`),
  ADD KEY `aid_uid_idx` (`aid`,`uid`);

--
-- Indexes for table `gxc_user_countries`
--
ALTER TABLE `gxc_user_countries`
  ADD PRIMARY KEY (`country_id`);

--
-- Indexes for table `gxc_zones`
--
ALTER TABLE `gxc_zones`
  ADD PRIMARY KEY (`zone_id`),
  ADD KEY `zone_code` (`zone_code`),
  ADD KEY `zone_country_id` (`zone_country_id`);

--
-- Indexes for table `ipaddress`
--
ALTER TABLE `ipaddress`
  ADD PRIMARY KEY (`ipAddress`);

--
-- Indexes for table `manager_ctv`
--
ALTER TABLE `manager_ctv`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `order_item`
--
ALTER TABLE `order_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk-order_item-order_id-order-id` (`order_id`),
  ADD KEY `fk-order_item-product_id-product-id` (`item_id`);

--
-- Indexes for table `order_luotdoan`
--
ALTER TABLE `order_luotdoan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_user_item_cart`
--
ALTER TABLE `order_user_item_cart`
  ADD PRIMARY KEY (`id`,`order_id`,`user_id`);

--
-- Indexes for table `pay_ctv`
--
ALTER TABLE `pay_ctv`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `price_ctv`
--
ALTER TABLE `price_ctv`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`id`),
  ADD KEY `profile_user_id` (`user_id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `savestatususer`
--
ALTER TABLE `savestatususer`
  ADD PRIMARY KEY (`idStatus`);

--
-- Indexes for table `sharefb`
--
ALTER TABLE `sharefb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `totalvote`
--
ALTER TABLE `totalvote`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transport_fee`
--
ALTER TABLE `transport_fee`
  ADD PRIMARY KEY (`transport_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_email` (`email`),
  ADD UNIQUE KEY `user_username` (`username`),
  ADD KEY `user_role_id` (`role_id`);

--
-- Indexes for table `user_auth`
--
ALTER TABLE `user_auth`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_auth_provider_id` (`provider_id`),
  ADD KEY `user_auth_user_id` (`user_id`);

--
-- Indexes for table `user_history_money`
--
ALTER TABLE `user_history_money`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_key`
--
ALTER TABLE `user_key`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_key_key` (`key_value`),
  ADD KEY `user_key_user_id` (`user_id`);

--
-- Indexes for table `user_money`
--
ALTER TABLE `user_money`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vote_missgame`
--
ALTER TABLE `vote_missgame`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zones`
--
ALTER TABLE `zones`
  ADD PRIMARY KEY (`zone_id`),
  ADD KEY `zone_code` (`zone_code`),
  ADD KEY `zone_country_id` (`zone_country_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `aid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `easyii_admins`
--
ALTER TABLE `easyii_admins`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `easyii_article_categories`
--
ALTER TABLE `easyii_article_categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `easyii_article_items`
--
ALTER TABLE `easyii_article_items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `easyii_carousel`
--
ALTER TABLE `easyii_carousel`
  MODIFY `carousel_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `easyii_catalog_categories`
--
ALTER TABLE `easyii_catalog_categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `easyii_catalog_items`
--
ALTER TABLE `easyii_catalog_items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `easyii_catalog_items_price`
--
ALTER TABLE `easyii_catalog_items_price`
  MODIFY `price_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `easyii_catalog_item_data`
--
ALTER TABLE `easyii_catalog_item_data`
  MODIFY `data_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `easyii_doituyen`
--
ALTER TABLE `easyii_doituyen`
  MODIFY `doituyen_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `easyii_dudoan`
--
ALTER TABLE `easyii_dudoan`
  MODIFY `dudoan_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `easyii_eventcard`
--
ALTER TABLE `easyii_eventcard`
  MODIFY `eventcard_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `easyii_faq`
--
ALTER TABLE `easyii_faq`
  MODIFY `faq_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `easyii_feedback`
--
ALTER TABLE `easyii_feedback`
  MODIFY `feedback_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `easyii_files`
--
ALTER TABLE `easyii_files`
  MODIFY `file_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `easyii_gallery_categories`
--
ALTER TABLE `easyii_gallery_categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `easyii_guestbook`
--
ALTER TABLE `easyii_guestbook`
  MODIFY `guestbook_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `easyii_loginform`
--
ALTER TABLE `easyii_loginform`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `easyii_modules`
--
ALTER TABLE `easyii_modules`
  MODIFY `module_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `easyii_news`
--
ALTER TABLE `easyii_news`
  MODIFY `news_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `easyii_nhanvat`
--
ALTER TABLE `easyii_nhanvat`
  MODIFY `nhanvat_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `easyii_nhanvat_orderluotgui`
--
ALTER TABLE `easyii_nhanvat_orderluotgui`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `easyii_nhanvat_user`
--
ALTER TABLE `easyii_nhanvat_user`
  MODIFY `nhanvat_user_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `easyii_nvuser_list`
--
ALTER TABLE `easyii_nvuser_list`
  MODIFY `nvuser_list_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `easyii_pages`
--
ALTER TABLE `easyii_pages`
  MODIFY `page_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `easyii_payment`
--
ALTER TABLE `easyii_payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `easyii_photos`
--
ALTER TABLE `easyii_photos`
  MODIFY `photo_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `easyii_seotext`
--
ALTER TABLE `easyii_seotext`
  MODIFY `seotext_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `easyii_settings`
--
ALTER TABLE `easyii_settings`
  MODIFY `setting_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `easyii_shopcart_goods`
--
ALTER TABLE `easyii_shopcart_goods`
  MODIFY `good_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `easyii_shopcart_orders`
--
ALTER TABLE `easyii_shopcart_orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `easyii_subscribe_history`
--
ALTER TABLE `easyii_subscribe_history`
  MODIFY `history_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `easyii_subscribe_subscribers`
--
ALTER TABLE `easyii_subscribe_subscribers`
  MODIFY `subscriber_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `easyii_tags`
--
ALTER TABLE `easyii_tags`
  MODIFY `tag_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `easyii_test`
--
ALTER TABLE `easyii_test`
  MODIFY `id_test` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `easyii_testm`
--
ALTER TABLE `easyii_testm`
  MODIFY `testm_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `easyii_texts`
--
ALTER TABLE `easyii_texts`
  MODIFY `text_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `easyii_trandau`
--
ALTER TABLE `easyii_trandau`
  MODIFY `trandau_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `easyii_userluotdoan`
--
ALTER TABLE `easyii_userluotdoan`
  MODIFY `userluotdoan_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `eventorder`
--
ALTER TABLE `eventorder`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gxc_user`
--
ALTER TABLE `gxc_user`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gxc_user_addresses`
--
ALTER TABLE `gxc_user_addresses`
  MODIFY `aid` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gxc_zones`
--
ALTER TABLE `gxc_zones`
  MODIFY `zone_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `manager_ctv`
--
ALTER TABLE `manager_ctv`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_item`
--
ALTER TABLE `order_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_luotdoan`
--
ALTER TABLE `order_luotdoan`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_user_item_cart`
--
ALTER TABLE `order_user_item_cart`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pay_ctv`
--
ALTER TABLE `pay_ctv`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `price_ctv`
--
ALTER TABLE `price_ctv`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `profile`
--
ALTER TABLE `profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `savestatususer`
--
ALTER TABLE `savestatususer`
  MODIFY `idStatus` int(12) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sharefb`
--
ALTER TABLE `sharefb`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `totalvote`
--
ALTER TABLE `totalvote`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transport_fee`
--
ALTER TABLE `transport_fee`
  MODIFY `transport_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_auth`
--
ALTER TABLE `user_auth`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_history_money`
--
ALTER TABLE `user_history_money`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_key`
--
ALTER TABLE `user_key`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_money`
--
ALTER TABLE `user_money`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vote_missgame`
--
ALTER TABLE `vote_missgame`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `zones`
--
ALTER TABLE `zones`
  MODIFY `zone_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `profile`
--
ALTER TABLE `profile`
  ADD CONSTRAINT `profile_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_role_id` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`);

--
-- Constraints for table `user_auth`
--
ALTER TABLE `user_auth`
  ADD CONSTRAINT `user_auth_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
