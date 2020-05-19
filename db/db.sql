-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 19, 2020 at 07:57 AM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `edfi_address_book`
--
CREATE DATABASE IF NOT EXISTS `edfi_address_book` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `edfi_address_book`;

-- --------------------------------------------------------

--
-- Table structure for table `address_book`
--

CREATE TABLE `address_book` (
  `id` int(11) NOT NULL,
  `id_city` int(11) NOT NULL,
  `last_name` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `first_name` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `street` varchar(350) COLLATE utf8_unicode_ci NOT NULL,
  `zipcode` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `tags` text COLLATE utf8_unicode_ci NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` int(11) NOT NULL,
  `id_country` int(11) NOT NULL,
  `name` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `format_code` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contacts_groups`
--

CREATE TABLE `contacts_groups` (
  `id` int(11) NOT NULL,
  `id_contact` int(11) NOT NULL,
  `id_group` int(11) NOT NULL,
  `inherited` tinyint(1) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contacts_groups_inherited`
--

CREATE TABLE `contacts_groups_inherited` (
  `id` int(11) NOT NULL,
  `id_contact_group_parent` int(11) NOT NULL,
  `id_contact_group_child` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` int(11) NOT NULL,
  `name` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name`, `date`) VALUES(1, 'UNITED STATES OF AMERICA', '2020-05-07 04:00:00');
INSERT INTO `countries` (`id`, `name`, `date`) VALUES(2, 'CANADA', '2020-05-07 04:00:00');
INSERT INTO `countries` (`id`, `name`, `date`) VALUES(3, 'MEXICO', '2020-05-07 04:00:00');
INSERT INTO `countries` (`id`, `name`, `date`) VALUES(4, 'EL SALVADOR', '2020-05-07 04:00:00');
INSERT INTO `countries` (`id`, `name`, `date`) VALUES(5, 'ARGENTINA', '2020-05-07 04:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `name` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address_book`
--
ALTER TABLE `address_book`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_city` (`id_city`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_country` (`id_country`);

--
-- Indexes for table `contacts_groups`
--
ALTER TABLE `contacts_groups`
  ADD PRIMARY KEY (`id_contact`,`id_group`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `fk_addbook_ref_idgroup` (`id_group`);

--
-- Indexes for table `contacts_groups_inherited`
--
ALTER TABLE `contacts_groups_inherited`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_contgpinh_id_child` (`id_contact_group_child`),
  ADD KEY `fk_contgpinh_id_parent` (`id_contact_group_parent`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `address_book`
--
ALTER TABLE `address_book`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contacts_groups`
--
ALTER TABLE `contacts_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contacts_groups_inherited`
--
ALTER TABLE `contacts_groups_inherited`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `address_book`
--
ALTER TABLE `address_book`
  ADD CONSTRAINT `address_book_ibfk_1` FOREIGN KEY (`id_city`) REFERENCES `cities` (`id`);

--
-- Constraints for table `cities`
--
ALTER TABLE `cities`
  ADD CONSTRAINT `cities_ibfk_1` FOREIGN KEY (`id_country`) REFERENCES `countries` (`id`);

--
-- Constraints for table `contacts_groups`
--
ALTER TABLE `contacts_groups`
  ADD CONSTRAINT `fk_addbook_ref_idcontact` FOREIGN KEY (`id_contact`) REFERENCES `address_book` (`id`),
  ADD CONSTRAINT `fk_addbook_ref_idgroup` FOREIGN KEY (`id_group`) REFERENCES `groups` (`id`);

--
-- Constraints for table `contacts_groups_inherited`
--
ALTER TABLE `contacts_groups_inherited`
  ADD CONSTRAINT `fk_contgpinh_id_child` FOREIGN KEY (`id_contact_group_child`) REFERENCES `contacts_groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_contgpinh_id_parent` FOREIGN KEY (`id_contact_group_parent`) REFERENCES `contacts_groups` (`id`) ON DELETE CASCADE;
COMMIT;
