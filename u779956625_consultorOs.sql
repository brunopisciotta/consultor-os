-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 12/01/2026 às 17:35
-- Versão do servidor: 11.8.3-MariaDB-log
-- Versão do PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `u779956625_consultorOs`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `interactions`
--

CREATE TABLE `interactions` (
  `id` int(11) NOT NULL,
  `lead_id` int(11) NOT NULL,
  `type` enum('note','call','whatsapp','meeting') NOT NULL,
  `content` text NOT NULL,
  `interaction_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `leads`
--

CREATE TABLE `leads` (
  `id` int(11) NOT NULL,
  `consultant_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `objective` enum('imovel','auto','investimento','outro') DEFAULT 'outro',
  `message` text DEFAULT NULL,
  `status` varchar(20) DEFAULT 'new',
  `income_range` varchar(50) DEFAULT NULL,
  `interest_level` tinyint(4) DEFAULT 1,
  `notes` text DEFAULT NULL,
  `origin` varchar(50) DEFAULT 'landing_page',
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `leads`
--

INSERT INTO `leads` (`id`, `consultant_id`, `name`, `phone`, `email`, `objective`, `message`, `status`, `income_range`, `interest_level`, `notes`, `origin`, `created_at`) VALUES
(14, 1, 'Gustavo da Silva', '12988127481', 'gs6498190@gmail.com', 'investimento', 'O Gustavo é um menino novo que pensa em ultilizar sua carta como investimento para seu futuro. Cota dele 212', 'closed', NULL, 1, NULL, 'manual', '2026-01-09 15:02:51'),
(15, 1, 'Valkiria', '43988629456', 'valquiria123nascimento@gmail.com', 'imovel', 'Ela quer comprar o terreno da sogra e construir, reformar e quer fazer dinheiro com a carta também', 'new', NULL, 1, NULL, 'manual', '2026-01-11 18:23:55');

-- --------------------------------------------------------

--
-- Estrutura para tabela `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `title`, `message`, `is_read`, `created_at`) VALUES
(1, 1, 'Bem-vindo ao ConsultorOS', 'Seu sistema está pronto para uso.', 1, '2026-01-08 04:18:42'),
(2, 1, 'Lead Pendente', 'Renata Ramos aguarda seu contato.', 1, '2026-01-08 04:18:42'),
(3, 1, 'Novo Lead!', 'Um novo cliente chegou via Site.', 1, '2026-01-08 06:47:45'),
(4, 1, 'Novo Lead!', 'Um novo cliente chegou via Site.', 1, '2026-01-08 06:58:20'),
(5, 1, 'Novo Lead!', 'Um novo cliente chegou via Site.', 1, '2026-01-08 15:58:37'),
(6, 1, 'Novo Lead!', 'Um novo cliente chegou via Site.', 0, '2026-01-08 20:05:24'),
(7, 1, 'Novo Lead!', 'Um novo cliente chegou via Site.', 0, '2026-01-09 15:02:51'),
(8, 1, 'Novo Lead!', 'Um novo cliente chegou via Site.', 0, '2026-01-11 18:23:55');

-- --------------------------------------------------------

--
-- Estrutura para tabela `performance_metrics`
--

CREATE TABLE `performance_metrics` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `month_year` varchar(7) NOT NULL,
  `calls_made` int(11) DEFAULT 0,
  `whatsapp_sent` int(11) DEFAULT 0,
  `video_calls` int(11) DEFAULT 0,
  `visits_made` int(11) DEFAULT 0,
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `performance_metrics`
--

INSERT INTO `performance_metrics` (`id`, `user_id`, `month_year`, `calls_made`, `whatsapp_sent`, `video_calls`, `visits_made`, `updated_at`) VALUES
(1, 1, '2026-01', 4, 0, 1, 0, '2026-01-12 12:00:44');

-- --------------------------------------------------------

--
-- Estrutura para tabela `simulations`
--

CREATE TABLE `simulations` (
  `id` int(11) NOT NULL,
  `lead_id` int(11) DEFAULT NULL,
  `type` enum('imovel','auto','servico') NOT NULL,
  `credit_value` decimal(15,2) NOT NULL,
  `term_months` int(11) NOT NULL,
  `financing_term_months` int(11) DEFAULT NULL,
  `consortium_rate` decimal(5,2) DEFAULT NULL,
  `consortium_parcel` decimal(15,2) DEFAULT NULL,
  `bid_suggestion` decimal(15,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `has_insurance` tinyint(1) DEFAULT 0,
  `consortium_total` decimal(15,2) DEFAULT NULL,
  `financing_total` decimal(15,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `simulations`
--

INSERT INTO `simulations` (`id`, `lead_id`, `type`, `credit_value`, `term_months`, `financing_term_months`, `consortium_rate`, `consortium_parcel`, `bid_suggestion`, `created_at`, `has_insurance`, `consortium_total`, `financing_total`) VALUES
(1, NULL, 'imovel', 200000.00, 200, 200, 22.00, 1220.00, 0.00, '2026-01-07 18:31:54', 0, NULL, NULL),
(4, NULL, 'imovel', 800000.00, 600, 600, 22.00, 1476.67, 90000.00, '2026-01-08 07:00:03', 0, NULL, NULL),
(5, NULL, 'imovel', 200000.00, 200, 200, 12.00, 1196.00, 0.00, '2026-01-08 15:03:13', 1, 239200.00, 400826.95),
(6, NULL, 'imovel', 200000.00, 200, 200, 12.00, 1196.00, 0.00, '2026-01-08 15:03:13', 1, 239200.00, 400826.95),
(7, NULL, 'imovel', 200000.00, 200, 200, 12.00, 1196.00, 0.00, '2026-01-08 15:03:13', 1, 239200.00, 400826.95),
(8, NULL, 'imovel', 200000.00, 200, 200, 12.00, 1196.00, 0.00, '2026-01-08 15:03:13', 1, 239200.00, 400826.95),
(9, NULL, 'imovel', 200000.00, 200, 200, 12.00, 1196.00, 0.00, '2026-01-08 15:03:13', 1, 239200.00, 400826.95),
(10, NULL, 'imovel', 200000.00, 200, 200, 12.00, 1196.00, 0.00, '2026-01-08 15:03:13', 1, 239200.00, 400826.95),
(11, NULL, 'imovel', 450000.00, 200, 200, 12.00, 2520.00, 0.00, '2026-01-08 15:51:08', 0, 504000.00, 901860.65),
(12, NULL, 'imovel', 620000.00, 200, 200, 12.00, 3472.00, 0.00, '2026-01-08 15:57:52', 0, 694400.00, 1242563.56),
(13, NULL, 'imovel', 200000.00, 200, 200, 13.00, 1206.00, 0.00, '2026-01-08 16:06:36', 1, 241200.00, 400826.95),
(14, NULL, 'imovel', 610000.00, 200, 200, 13.00, 3446.50, 0.00, '2026-01-08 18:50:34', 0, 689300.00, 1222522.21),
(15, NULL, 'imovel', 350000.00, 200, 420, 13.00, 1627.50, 70000.00, '2026-01-08 19:57:47', 0, 395500.00, 1215449.32),
(16, NULL, 'imovel', 500000.00, 200, 420, 19.00, 2225.00, 150000.00, '2026-01-08 20:02:04', 0, 595000.00, 1736356.17),
(19, NULL, 'imovel', 200000.00, 200, 360, 22.00, 1220.00, 0.00, '2026-01-09 14:57:15', 0, 244000.00, 609041.39),
(20, 14, 'imovel', 70000.00, 200, 360, 22.00, 427.00, 0.00, '2026-01-09 15:04:11', 0, 85400.00, 213164.49),
(21, 15, 'imovel', 160000.00, 200, 420, 23.00, 984.00, 0.00, '2026-01-11 18:24:26', 0, 196800.00, 697595.56);

-- --------------------------------------------------------

--
-- Estrutura para tabela `system_settings`
--

CREATE TABLE `system_settings` (
  `id` int(11) NOT NULL,
  `category` varchar(50) NOT NULL,
  `adm_rate` decimal(5,2) DEFAULT 20.00,
  `reserve_fund` decimal(5,2) DEFAULT 2.00,
  `adhesion_fee` decimal(5,2) DEFAULT 2.00,
  `life_insurance` decimal(5,4) DEFAULT 0.0380,
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `system_settings`
--

INSERT INTO `system_settings` (`id`, `category`, `adm_rate`, `reserve_fund`, `adhesion_fee`, `life_insurance`, `updated_at`) VALUES
(1, 'imovel', 22.00, 2.00, 0.00, 0.0380, '2026-01-07 17:55:31'),
(2, 'auto', 20.00, 2.00, 2.00, 0.0380, '2026-01-07 17:55:31');

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT 'default.png',
  `role` enum('admin','consultant') DEFAULT 'consultant',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `phone` varchar(20) DEFAULT '11999999999',
  `default_financing_rate` decimal(5,2) DEFAULT 10.50,
  `default_consortium_rate` decimal(5,2) DEFAULT 22.00,
  `commission_rate` decimal(5,2) DEFAULT 1.00,
  `sales_goal` decimal(15,2) DEFAULT 100000.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `avatar`, `role`, `created_at`, `updated_at`, `phone`, `default_financing_rate`, `default_consortium_rate`, `commission_rate`, `sales_goal`) VALUES
(1, 'Lucas Moraes', 'lucas.morais@gmr.com.br', '$2a$12$U2vwLVg7sevAiUJEDwZ.vOqqBkkg4LJ9pXxbi7T7k60.ObNVaHxLC', 'avatar_1_1767855544.png', 'consultant', '2026-01-07 18:28:31', '2026-01-12 12:00:24', '12982279206', 10.00, 22.00, 0.60, 10000000.00);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `interactions`
--
ALTER TABLE `interactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lead_id` (`lead_id`);

--
-- Índices de tabela `leads`
--
ALTER TABLE `leads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `consultant_id` (`consultant_id`);

--
-- Índices de tabela `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Índices de tabela `performance_metrics`
--
ALTER TABLE `performance_metrics`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_user_month` (`user_id`,`month_year`);

--
-- Índices de tabela `simulations`
--
ALTER TABLE `simulations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lead_id` (`lead_id`);

--
-- Índices de tabela `system_settings`
--
ALTER TABLE `system_settings`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `interactions`
--
ALTER TABLE `interactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `leads`
--
ALTER TABLE `leads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de tabela `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `performance_metrics`
--
ALTER TABLE `performance_metrics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT de tabela `simulations`
--
ALTER TABLE `simulations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de tabela `system_settings`
--
ALTER TABLE `system_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `interactions`
--
ALTER TABLE `interactions`
  ADD CONSTRAINT `interactions_ibfk_1` FOREIGN KEY (`lead_id`) REFERENCES `leads` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `leads`
--
ALTER TABLE `leads`
  ADD CONSTRAINT `leads_ibfk_1` FOREIGN KEY (`consultant_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `performance_metrics`
--
ALTER TABLE `performance_metrics`
  ADD CONSTRAINT `performance_metrics_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `simulations`
--
ALTER TABLE `simulations`
  ADD CONSTRAINT `simulations_ibfk_1` FOREIGN KEY (`lead_id`) REFERENCES `leads` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
