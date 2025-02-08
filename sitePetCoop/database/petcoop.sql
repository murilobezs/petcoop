-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 22, 2025 at 01:55 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12
SET
  SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

START TRANSACTION;

SET
  time_zone = "";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;

/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;

/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;

/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `petcoop`
--
CREATE DATABASE IF NOT EXISTS `petcoop` DEFAULT CHARACTER
SET
  utf8mb4 COLLATE utf8mb4_general_ci;

USE `petcoop`;

-- --------------------------------------------------------
--
-- Table structure for table `produtos`
--
CREATE TABLE IF NOT EXISTS `produtos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `marca` varchar(50) NOT NULL,
  `categoria` enum (
    'cães',
    'gatos',
    'peixes',
    'pássaros',
    'furões',
    'roedores'
  ) NOT NULL,
  `tipo` enum ('ração', 'remédio', 'acessório', 'casa') NOT NULL,
  `estoque` int(11) DEFAULT 0,
  `descricao` text NOT NULL,
  `imagem` varchar(255) NOT NULL,
  `preco` decimal(10, 2) NOT NULL,
  `promocao` tinyint (1) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB AUTO_INCREMENT = 6 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;