-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Tempo de geração: 22/03/2021 às 06:50
-- Versão do servidor: 8.0.22-0ubuntu0.20.04.3
-- Versão do PHP: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `marketplace`
--
CREATE DATABASE IF NOT EXISTS `marketplace` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `marketplace`;

-- --------------------------------------------------------

--
-- Estrutura para tabela `addresses`
--

CREATE TABLE `addresses` (
  `id` int NOT NULL,
  `public_place` varchar(100) NOT NULL,
  `number` varchar(10) NOT NULL,
  `neighborhood` varchar(100) NOT NULL,
  `complement` varchar(100) DEFAULT NULL,
  `city` varchar(100) NOT NULL,
  `uf` varchar(2) NOT NULL,
  `zip_code` varchar(10) NOT NULL,
  `id_store` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Despejando dados para a tabela `addresses`
--

INSERT INTO `addresses` (`id`, `public_place`, `number`, `neighborhood`, `complement`, `city`, `uf`, `zip_code`, `id_store`) VALUES
(1, 'Travessa Zequinha de Abreu', '514', 'Chácaras Califórnia', NULL, 'Araçatuba', 'SP', '16026-650', 1),
(2, 'Rua Antônio Carlos Alves', '104', 'Residencial Espanha editado', NULL, 'Guratinguetá', 'SP', '12510-564', 2),
(3, 'Rua Manuel Iglésias Pila', '990', 'Jardim Esplanada', '', 'Indaiatuba', 'SP', '13331-504', 3),
(4, 'Rua Marina Vieira de Carvalho Mesquita', '613', 'Baronesa', '', 'Osasco', 'SP', '06268-130', 4),
(6, 'Rua Dona Adélia Mansur Zaiet', '799', 'Vila Império', '', 'São Paulo', 'SP', '04406-170', 6),
(7, 'Travessa Romulo Riva', '350', 'Vila Residencial Morini', '', 'Votuporanga', 'SP', '15503-218', 7),
(8, 'Viaduto dos Imigrantes', '644', 'Parque Ibirapuera', '', 'São Paulo', 'SP', '04094-040', 8),
(9, 'Rua Sequóia', '901', 'Jardim Santa Maria', '', 'São Paulo', 'SP', '03575-050', 13),
(10, 'Rua Lázaro Alves da Silva', '456', 'Ponte Seca', '', 'Ribeirão Pires', 'SP', '09411-770', 14),
(11, 'Rua São Salvador', '534', 'Vila São Benedito', '', 'Lins', 'SP', '16401-085', 15);

-- --------------------------------------------------------

--
-- Estrutura para tabela `categories`
--

CREATE TABLE `categories` (
  `id` int NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Despejando dados para a tabela `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Áudio'),
(2, 'Artesanato'),
(3, 'Artigos de Festa'),
(4, 'Bebês'),
(5, 'Beleza e Perfumaria'),
(6, 'Brinquedos'),
(7, 'Cama, Mesa e Banho'),
(8, 'Celulares'),
(9, 'Decoração'),
(10, 'Eletrodomèsticos'),
(11, 'Esporte e Lazer'),
(12, 'Jogos'),
(13, 'Informática'),
(14, 'Instrumentos Musicais'),
(15, 'Livros'),
(16, 'Móveis'),
(17, 'Papelaria'),
(18, 'Relógios'),
(19, 'Vestuário');

-- --------------------------------------------------------

--
-- Estrutura para tabela `products`
--

CREATE TABLE `products` (
  `id` int NOT NULL,
  `name` varchar(150) NOT NULL,
  `description` text,
  `picture` varchar(100) DEFAULT NULL,
  `availability` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `id_category` int NOT NULL,
  `id_store` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Despejando dados para a tabela `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `picture`, `availability`, `price`, `id_category`, `id_store`) VALUES
(1, 'Notebook', 'lorem ipsum', '', 5, '4000.00', 13, 2),
(3, 'Jacaré edit', 'lorem ipsum', '', 5, '55.00', 6, 2),
(4, 'Smartphone', 'lorem ipsum', '', 5, '1000.00', 8, 2),
(5, 'Caderno', 'lorem ipsum', '', 20, '35.00', 17, 2),
(6, 'Notebook Asus', 'lorem ipsum', '', 3, '3500.00', 13, 2);

-- --------------------------------------------------------

--
-- Estrutura para tabela `stores`
--

CREATE TABLE `stores` (
  `id` int NOT NULL,
  `fantasy_name` varchar(150) NOT NULL,
  `cnpj` varchar(100) NOT NULL,
  `company_name` varchar(150) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `cell_phone` varchar(20) NOT NULL,
  `responsible_contact` varchar(100) NOT NULL,
  `rating` tinyint DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Despejando dados para a tabela `stores`
--

INSERT INTO `stores` (`id`, `fantasy_name`, `cnpj`, `company_name`, `phone`, `cell_phone`, `responsible_contact`, `rating`, `email`, `password`) VALUES
(1, 'Evelyn e Luciana Fotografias', '42.523.118/0001-44', 'Evelyn e Luciana Fotografias ME', '(18) 3866-9656', '(18) 99184-3154', 'Luciana', 5, 'contato@evelynelucianafotografiasme.com.br', 'luciana'),
(2, 'André Moura Coder', '42.523.118/0001-44', 'Andre Moura Coder LTDA', '(12) 3333-3333', '(12) 99999-7777', 'André', NULL, 'andre@teste.com', '$2y$10$lLPJYTpK.gUsBqB4vRZnqeUPdPhdmpNC8SBXbAI8eB/rT877x.jhi'),
(3, 'Marlene e Francisco Doces & Salgados', '11.583.190/0001-33', 'Marlene e Francisco Doces & Salgados Ltda', '(19) 2845-9092', '(19) 99231-9738', 'Marlene', NULL, 'producao@marleneefranciscodocessalgadosltda.com.br', '$2y$10$F1jyAarKhkZXYj8.uwq7feZiMclecXsfQVbZZjSajPyPi6u5boy4u'),
(4, 'Yuri e Agatha Doces & Salgados', '30.731.798/0001-02', 'Yuri e Agatha Doces & Salgados Ltda', '(11) 2566-1269', '(11) 99105-3222', 'Yuri', NULL, 'manutencao@yurieagathadocessalgadosltda.com.br', '$2y$10$9W3h7c7zdkXsRM1ARtACgu//TTsILBDYvfiTxDuBr/9kc2dXXi462'),
(6, 'Antônia e Eduardo Mudanças', '91.852.504/0001-95', 'Antônia e Eduardo Mudanças Ltda', '(11) 3881-3708', '(11) 98198-5146', 'Antônia', NULL, 'seguranca@antoniaeeduardomudancasltda.com.br', '$2y$10$AnaFlQpTCRULP4HK3hWL0OeWHhXme/fwcErcXbbBuN1g/rbgIHe9O'),
(7, 'Bernardo e Kaique Comercio de Bebidas Ltda', '61.963.546/0001-32', 'Bernardo e Kaique Comercio de Bebidas Ltda', '(17) 3596-5654', '(17) 98252-8883', 'Bernardo', NULL, 'rh@bernardoekaiquecomerciodebebidasltda.com.br', '$2y$10$d3ajU7TxPgDpIXQKb0aTGe4IPmlML6Bpd.99eywb9Oe9k9sh.rpGm'),
(8, 'Cauê e João Marcenaria', '60.981.330/0001-37', 'Cauê e João Marcenaria ME', '(11) 2791-6928', '(11) 98982-7950', 'Yuri', NULL, 'rh@caueejoaomarcenariame.com.br', '$2y$10$y0/6wcvJQY99RXi0aoUreOKRd2yUV8QeN7Y9p0i8hXoFT5/.tUbgK'),
(13, 'Aline e Luiza Gráfica ME', '68.625.021/0001-36', 'Aline e Luiza Gráfica ME', '(11) 3824-3058', '(11) 98270-4316', 'Aline', NULL, 'tesouraria@alineeluizagraficame.com.br', '$2y$10$dZXkDRfdszTKqXCI6YTNvu2MAK8SxSbHJ/MZkieuUIVN7mtFNECHy'),
(14, 'Erick e Bruna Fotografias ME', '21.560.443/0001-07', 'Erick e Bruna Fotografias ME', '(11) 3622-3036', '(11) 99684-2897', 'Erick', NULL, 'sistema@erickebrunafotografiasme.com.br', '$2y$10$mfXqIkY7oh6ZpubKEtJPf.4pl8OWuTnGg4.CQgUciJVvLuR9oZLXK'),
(15, 'Bruna e Alice Restaurante ME', '04.481.604/0001-58', 'Bruna e Alice Restaurante ME', '(14) 3911-4299', '(14) 98147-9530', 'Bruna', NULL, 'diretoria@brunaealicerestauranteme.com.br', '$2y$10$jhW2/Zw.ICFSmKckSkKCkO2ZSrSyiqk53UrZxBFuU1Di5bSLpyFG.');

--
-- Índices de tabelas apagadas
--

--
-- Índices de tabela `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_store_idx` (`id_store`);

--
-- Índices de tabela `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_category` (`id_category`),
  ADD KEY `id_store` (`id_store`);

--
-- Índices de tabela `stores`
--
ALTER TABLE `stores`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas apagadas
--

--
-- AUTO_INCREMENT de tabela `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de tabela `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `stores`
--
ALTER TABLE `stores`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Restrições para dumps de tabelas
--

--
-- Restrições para tabelas `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `id_store` FOREIGN KEY (`id_store`) REFERENCES `stores` (`id`);

--
-- Restrições para tabelas `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`id_category`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`id_store`) REFERENCES `stores` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
