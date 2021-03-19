-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 19-Mar-2021 às 15:38
-- Versão do servidor: 10.1.34-MariaDB
-- PHP Version: 7.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `marketplace`
--
CREATE DATABASE IF NOT EXISTS `marketplace` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `marketplace`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `addresses`
--

CREATE TABLE `addresses` (
  `id` int(11) NOT NULL,
  `public_place` varchar(100) NOT NULL,
  `number` varchar(10) NOT NULL,
  `neighborhood` varchar(100) NOT NULL,
  `complement` varchar(100) DEFAULT NULL,
  `city` varchar(100) NOT NULL,
  `uf` varchar(2) NOT NULL,
  `zip_code` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `addresses`
--

INSERT INTO `addresses` (`id`, `public_place`, `number`, `neighborhood`, `complement`, `city`, `uf`, `zip_code`) VALUES
(1, 'Travessa Zequinha de Abreu', '514', 'Chácaras Califórnia', NULL, 'Araçatuba', 'SP', '16026-650');

-- --------------------------------------------------------

--
-- Estrutura da tabela `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `description` text,
  `picture` varchar(100) DEFAULT NULL,
  `availability` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `id_category` int(11) NOT NULL,
  `id_store` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `stores`
--

CREATE TABLE `stores` (
  `id` int(11) NOT NULL,
  `fantasy_name` varchar(150) NOT NULL,
  `cnpj` varchar(100) NOT NULL,
  `company_name` varchar(150) NOT NULL,
  `id_address` int(11) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `cell_phone` varchar(20) NOT NULL,
  `responsible_contact` varchar(100) NOT NULL,
  `rating` tinyint(4) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `stores`
--

INSERT INTO `stores` (`id`, `fantasy_name`, `cnpj`, `company_name`, `id_address`, `phone`, `cell_phone`, `responsible_contact`, `rating`, `email`, `password`) VALUES
(1, 'Evelyn e Luciana Fotografias', '42.523.118/0001-44', 'Evelyn e Luciana Fotografias ME', 1, '(18) 3866-9656', '(18) 99184-3154', 'Luciana', 5, 'contato@evelynelucianafotografiasme.com.br', 'luciana');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_category` (`id_category`),
  ADD KEY `id_store` (`id_store`);

--
-- Indexes for table `stores`
--
ALTER TABLE `stores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_address` (`id_address`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stores`
--
ALTER TABLE `stores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`id_category`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`id_store`) REFERENCES `stores` (`id`);

--
-- Limitadores para a tabela `stores`
--
ALTER TABLE `stores`
  ADD CONSTRAINT `stores_ibfk_1` FOREIGN KEY (`id_address`) REFERENCES `addresses` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
