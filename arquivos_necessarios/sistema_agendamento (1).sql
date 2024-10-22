-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 22/10/2024 às 04:10
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `sistema_agendamento`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `area_code` int(11) DEFAULT NULL,
  `user_res` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `customers`
--

INSERT INTO `customers` (`id`, `user_id`, `name`, `surname`, `email`, `phone`, `area_code`, `user_res`, `created_at`, `updated_at`) VALUES
(1, 5, 'João da Silva', NULL, 'joao@example.com', '11987654321', NULL, NULL, '2024-09-16 03:43:19', '2024-09-16 03:43:19'),
(2, 5, 'Cliente João', 'Paulo', 'marlon.pauloo@gmail.com', '18997039914', 55, 5, '2024-09-19 10:57:45', '2024-09-19 10:57:45'),
(4, 5, 'Marlon cliente', 'Paulo', 'marlon.paulo@email.com', '18997039914', 21, 5, '2024-10-22 05:01:49', '2024-10-22 05:01:49');

-- --------------------------------------------------------

--
-- Estrutura para tabela `failed_jobs`
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
-- Estrutura para tabela `holidays`
--

CREATE TABLE `holidays` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `user` bigint(20) NOT NULL,
  `holiday` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `holidays`
--

INSERT INTO `holidays` (`id`, `user_id`, `user`, `holiday`) VALUES
(1, 1, 1, '2024-12-25'),
(2, 2, 2, '2024-01-01'),
(3, 1, 1, '2024-07-04');

-- --------------------------------------------------------

--
-- Estrutura para tabela `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2022_03_02_115431_create_reservations_table', 1),
(6, '2022_03_11_152421_create_notifications_table', 1),
(7, '2022_03_11_152430_create_notifications_status_table', 1),
(8, '2022_03_14_090010_create_renewals_table', 1),
(9, '2022_03_20_100736_create_holidays_table', 1),
(10, '2022_03_21_111235_create_sms_settings_table', 1),
(11, '2022_03_31_110623_sms_marketing_table', 1),
(12, '2022_03_31_155853_sms_marketing_send_status_table', 1),
(13, '2024_09_14_032117_create_websites_table', 2),
(14, '2024_09_14_040222_create_settings_table', 3),
(15, '2024_09_14_040557_create_photos_table', 4),
(16, '2024_09_14_213904_create_services_categories_table', 5),
(17, '2024_09_14_213919_create_profiles_table', 5),
(18, '2024_09_14_214132_create_services_table', 5),
(19, '2024_09_14_214429_create_phone_area_codes_table', 5),
(20, '2024_09_14_214748_create_websites_table', 6),
(21, '2024_09_14_221226_create_work_hours_table', 7),
(22, '2024_09_16_004232_create_customers_table', 8),
(23, '2024_09_16_020902_create_my_services_table', 9),
(24, '2024_09_16_181851_create_profiles_table', 10),
(25, '2024_09_17_011622_create_reviews_table', 11),
(26, '2024_09_17_015210_create_vacations_table', 12),
(27, '2024_09_17_015527_create_vacations_table', 13),
(28, '2024_09_17_015726_create_vacations_table', 14),
(29, '2024_09_17_022038_create_work_times_table', 15);

-- --------------------------------------------------------

--
-- Estrutura para tabela `my_services`
--

CREATE TABLE `my_services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `user_res` bigint(20) UNSIGNED NOT NULL,
  `service_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `my_services`
--

INSERT INTO `my_services` (`id`, `user_id`, `user_res`, `service_id`, `created_at`, `updated_at`) VALUES
(7, 5, 2, 6, '2024-09-16 05:38:20', '2024-09-16 05:38:20'),
(8, 5, 5, 7, '2024-09-16 05:38:20', '2024-09-16 05:38:20'),
(9, 5, 2, 8, '2024-09-16 05:38:20', '2024-09-16 05:38:20');

-- --------------------------------------------------------

--
-- Estrutura para tabela `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `msg` text NOT NULL,
  `created` datetime NOT NULL,
  `important` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `notifications`
--

INSERT INTO `notifications` (`id`, `title`, `msg`, `created`, `important`) VALUES
(1, 'Manutenção Programada', 'Manutenção programada para o próximo fim de semana.', '2024-09-14 00:53:41', 1),
(2, 'Novo Post no Blog', 'Verifique o nosso novo post no blog.', '2024-09-14 00:53:41', 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `notifications_status`
--

CREATE TABLE `notifications_status` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user` bigint(20) NOT NULL,
  `notification` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `personal_access_tokens`
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
-- Estrutura para tabela `phone_area_codes`
--

CREATE TABLE `phone_area_codes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `area_code` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `phone_area_codes`
--

INSERT INTO `phone_area_codes` (`id`, `area_code`, `created_at`, `updated_at`) VALUES
(1, '11', '2024-09-15 00:53:26', '2024-09-15 00:53:26'),
(2, '21', '2024-09-15 00:53:26', '2024-09-15 00:53:26');

-- --------------------------------------------------------

--
-- Estrutura para tabela `photos`
--

CREATE TABLE `photos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `photo_1` varchar(255) DEFAULT NULL,
  `photo_2` varchar(255) DEFAULT NULL,
  `photo_3` varchar(255) DEFAULT NULL,
  `photo_4` varchar(255) DEFAULT NULL,
  `photo_5` varchar(255) DEFAULT NULL,
  `photo_6` varchar(255) DEFAULT NULL,
  `photo_7` varchar(255) DEFAULT NULL,
  `photo_8` varchar(255) DEFAULT NULL,
  `photo_9` varchar(255) DEFAULT NULL,
  `photo_10` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `photos`
--

INSERT INTO `photos` (`id`, `user_id`, `photo_1`, `photo_2`, `photo_3`, `photo_4`, `photo_5`, `photo_6`, `photo_7`, `photo_8`, `photo_9`, `photo_10`, `created_at`, `updated_at`) VALUES
(3, 2, 'https://example.com/foto1.jpg', 'https://example.com/foto2.jpg', 'https://example.com/foto3.jpg', 'https://example.com/foto4.jpg', 'https://example.com/foto5.jpg', 'https://example.com/foto6.jpg', 'https://example.com/foto7.jpg', 'https://example.com/foto8.jpg', 'https://example.com/foto9.jpg', 'https://example.com/foto10.jpg', '2024-09-14 07:08:58', '2024-09-14 07:08:58'),
(4, 3, 'https://example.com/imagem1.png', 'https://example.com/imagem2.png', 'https://example.com/imagem3.png', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2024-09-14 07:08:58', '2024-09-14 07:08:58');

-- --------------------------------------------------------

--
-- Estrutura para tabela `profiles`
--

CREATE TABLE `profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) DEFAULT NULL,
  `occupation` varchar(255) DEFAULT NULL,
  `privilege` int(11) NOT NULL,
  `area_code` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `about` text DEFAULT NULL,
  `include_profile` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `profiles`
--

INSERT INTO `profiles` (`id`, `user_id`, `profile_image`, `name`, `surname`, `occupation`, `privilege`, `area_code`, `phone`, `about`, `include_profile`, `created_at`, `updated_at`) VALUES
(1, 5, '98438ba6b29ea0d4b943adeef7c07e41c1bb0cf3.png', 'Marlon Colaborador', 'Paulo da Silva', NULL, 1, NULL, NULL, NULL, 0, NULL, NULL),
(2, 2, '98438ba6b29ea0d4b943adeef7c07e41c1bb0cf3.png', 'Marlon Colaborador', 'Paulo da Silva', NULL, 1, NULL, NULL, NULL, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `renewals`
--

CREATE TABLE `renewals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user` bigint(20) NOT NULL,
  `notified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `reservations`
--

CREATE TABLE `reservations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `user_res` int(11) NOT NULL,
  `customer` bigint(20) NOT NULL,
  `service` varchar(255) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `reservations`
--

INSERT INTO `reservations` (`id`, `user_id`, `user_res`, `customer`, `service`, `price`, `start`, `end`) VALUES
(1, 1, 0, 1, 'Corte de cabelo', 0.00, '2024-09-15 09:00:00', '2024-09-15 10:00:00'),
(2, 2, 0, 2, 'Massagem', 0.00, '2024-09-16 11:00:00', '2024-09-16 12:00:00'),
(3, 5, 5, 2, 'Massagem', 0.00, '2024-09-16 11:00:00', '2024-09-16 13:00:00'),
(4, 5, 5, 4, 'Hidratação Capilar', 25.00, '2024-10-23 09:30:00', '2024-10-23 10:14:59'),
(5, 5, 5, 4, 'Hidratação Capilar', 25.00, '2024-10-23 10:45:00', '2024-10-23 11:29:59');

-- --------------------------------------------------------

--
-- Estrutura para tabela `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `review` text NOT NULL,
  `vote` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `name`, `review`, `vote`, `status`, `created_at`, `updated_at`) VALUES
(1, 5, 'John Doe', 'Great product! I love it.', 5, 2, '2024-09-17 04:17:36', '2024-09-17 04:17:36');

-- --------------------------------------------------------

--
-- Estrutura para tabela `services`
--

CREATE TABLE `services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `category` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `price` decimal(8,2) DEFAULT NULL,
  `duration` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `services`
--

INSERT INTO `services` (`id`, `user_id`, `category`, `title`, `price`, `duration`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 'Corte Simples', NULL, '00:30', '2024-09-15 00:53:26', '2024-09-15 00:53:26'),
(2, 2, 2, 'Manicure Completa', NULL, '01:00', '2024-09-15 00:53:26', '2024-09-15 00:53:26'),
(3, 5, 1, 'Corte Masculino', 20.00, '00:30', NULL, NULL),
(4, 5, 1, 'Corte Feminino', 30.00, '01:00', NULL, NULL),
(5, 5, 2, 'Barba Completa', 15.00, '00:20', NULL, NULL),
(6, 5, 2, 'Aparar Barba', 10.00, '00:15', NULL, NULL),
(7, 5, 3, 'Hidratação Capilar', 25.00, '00:45', NULL, NULL),
(8, 5, 3, 'Reconstrução Capilar', 40.00, '01:30', NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `services_categories`
--

CREATE TABLE `services_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `services_categories`
--

INSERT INTO `services_categories` (`id`, `user_id`, `title`, `created_at`, `updated_at`) VALUES
(1, 2, 'Corte de Cabelo', '2024-09-15 00:53:26', '2024-09-15 00:53:26'),
(2, 2, 'Manicure', '2024-09-15 00:53:26', '2024-09-15 00:53:26'),
(3, 5, 'Corte de Cabelo', NULL, NULL),
(4, 5, 'Barba', NULL, NULL),
(5, 5, 'Tratamentos Capilares', NULL, NULL),
(6, 5, 'Corte de Cabelo', NULL, NULL),
(7, 5, 'Barba', NULL, NULL),
(8, 5, 'Tratamentos Capilares', NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `company` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `zip` varchar(255) DEFAULT NULL,
  `site_email` varchar(255) DEFAULT NULL,
  `site_phone` varchar(255) DEFAULT NULL,
  `booking` int(11) NOT NULL DEFAULT 4,
  `currency_sign` varchar(255) NOT NULL DEFAULT '$',
  `area_code` int(11) NOT NULL DEFAULT 15,
  `currency_format` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `settings`
--

INSERT INTO `settings` (`id`, `user_id`, `company`, `address`, `city`, `zip`, `site_email`, `site_phone`, `booking`, `currency_sign`, `area_code`, `currency_format`, `created_at`, `updated_at`) VALUES
(3, 2, 'Empresa Exemplo Ltda', 'Rua Exemplo, 123', 'Cidade Exemplo', '12345-678', 'contato@exemplo.com', '(11) 1234-5678', 4, 'R$', 11, 1, '2024-09-14 07:03:55', '2024-09-14 07:03:55'),
(4, 3, 'Outra Empresa S/A', 'Avenida Teste, 456', 'Outra Cidade', '98765-432', 'info@outraempresa.com', '(21) 8765-4321', 6, '€', 21, 2, '2024-09-14 07:03:55', '2024-09-14 07:03:55'),
(5, 5, 'Empresa Exemplo Ltda', 'Rua Exemplo, 123', 'Cidade Exemplo', '12345-678', 'contato@exemplo.com', '(11) 1234-5678', 4, 'R$', 11, 1, '2024-09-14 07:03:55', '2024-09-14 07:03:55');

-- --------------------------------------------------------

--
-- Estrutura para tabela `sms_marketing`
--

CREATE TABLE `sms_marketing` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `area_code` int(11) NOT NULL,
  `enabled` tinyint(4) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `sms_marketing`
--

INSERT INTO `sms_marketing` (`id`, `user_id`, `title`, `message`, `area_code`, `enabled`, `created_at`) VALUES
(1, 1, 'Promoção de Outono', 'Descontos incríveis para este outono!', 123, 1, '2024-09-14 00:53:35'),
(2, 2, 'Ofertas de Natal', 'Ofertas especiais para o Natal!', 456, 1, '2024-09-14 00:53:35');

-- --------------------------------------------------------

--
-- Estrutura para tabela `sms_marketing_send_status`
--

CREATE TABLE `sms_marketing_send_status` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `campaign` bigint(20) NOT NULL,
  `customer` bigint(20) NOT NULL,
  `sent` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `sms_marketing_send_status`
--

INSERT INTO `sms_marketing_send_status` (`id`, `user_id`, `campaign`, `customer`, `sent`) VALUES
(1, 1, 1, 1, 0),
(2, 2, 2, 2, 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `sms_settings`
--

CREATE TABLE `sms_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `balance` bigint(20) NOT NULL,
  `notify` int(11) NOT NULL,
  `enabled` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `sms_settings`
--

INSERT INTO `sms_settings` (`id`, `user_id`, `balance`, `notify`, `enabled`) VALUES
(1, 1, 1000, 1, 1),
(2, 2, 500, 0, 1),
(3, 5, 500, 0, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `occupation` varchar(255) DEFAULT NULL,
  `area_code` int(11) DEFAULT NULL,
  `phone` int(11) DEFAULT NULL,
  `about` text DEFAULT NULL,
  `include_profile` tinyint(4) DEFAULT NULL,
  `valid_to` datetime DEFAULT NULL,
  `privilege` tinyint(4) DEFAULT 1,
  `member` bigint(20) DEFAULT NULL,
  `template` varchar(255) DEFAULT 'default',
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `users`
--

INSERT INTO `users` (`id`, `name`, `surname`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `url`, `profile_image`, `occupation`, `area_code`, `phone`, `about`, `include_profile`, `valid_to`, `privilege`, `member`, `template`, `deleted_at`) VALUES
(2, 'Marlon Paulo', '', 'marlon.pauloo@gmail.com', NULL, 'senha123', NULL, '2024-09-14 06:51:51', '2024-09-14 06:51:51', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 'default', NULL),
(3, 'Bob Smith', '', 'bob.smith@example.com', NULL, 'password456', NULL, '2024-09-14 06:51:51', '2024-09-14 06:51:51', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 'default', NULL),
(4, 'Marlon Paulo 1', '', 'marlon.pauloo1@gmail.com', NULL, 'senha1123', NULL, '2024-09-14 06:51:51', '2024-09-14 06:51:51', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 'default', NULL),
(5, 'Marlon Paulo da Silva', '', 'marlon.paulo.silva@outlook.com', NULL, '$2y$10$rU4ZN0bfb2NsaPNnAVP8PuBhbujtEx2N//wVk40g72lzfixeedvJq', NULL, '2024-09-16 06:30:40', '2024-09-16 06:30:40', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, 'default', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `vacations`
--

CREATE TABLE `vacations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `user_res` bigint(20) UNSIGNED NOT NULL,
  `date_from` date DEFAULT NULL,
  `date_to` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `vacations`
--

INSERT INTO `vacations` (`id`, `user_id`, `user_res`, `date_from`, `date_to`, `created_at`, `updated_at`) VALUES
(1, 5, 2, '2024-09-17', '2024-09-30', '2024-09-17 05:03:32', '2024-09-17 05:03:32');

-- --------------------------------------------------------

--
-- Estrutura para tabela `websites`
--

CREATE TABLE `websites` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `domain` varchar(255) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `color` int(11) NOT NULL DEFAULT 4,
  `address` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `websites`
--

INSERT INTO `websites` (`id`, `user_id`, `title`, `domain`, `logo`, `facebook`, `twitter`, `instagram`, `color`, `address`, `created_at`, `updated_at`) VALUES
(1, 5, NULL, 'barbeariamarlon.site', '/images/profile_images/4f95371739208b3fcfe5ee48655cccc6b5651fa1.png', 'https://facebook.com/meusite', 'https://twitter.com/meusite', 'https://instagram.com/meusite', 5, 'Rua Exemplo, 123, Cidade Exemplo', '2024-09-15 00:53:26', '2024-09-15 00:53:26');

-- --------------------------------------------------------

--
-- Estrutura para tabela `work_hours`
--

CREATE TABLE `work_hours` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `mon_closed` tinyint(1) NOT NULL DEFAULT 0,
  `tue_closed` tinyint(1) NOT NULL DEFAULT 0,
  `wed_closed` tinyint(1) NOT NULL DEFAULT 0,
  `thu_closed` tinyint(1) NOT NULL DEFAULT 0,
  `fri_closed` tinyint(1) NOT NULL DEFAULT 0,
  `sat_closed` tinyint(1) NOT NULL DEFAULT 1,
  `sun_closed` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `work_hours`
--

INSERT INTO `work_hours` (`id`, `user_id`, `mon_closed`, `tue_closed`, `wed_closed`, `thu_closed`, `fri_closed`, `sat_closed`, `sun_closed`, `created_at`, `updated_at`) VALUES
(1, 5, 0, 0, 0, 0, 0, 1, 1, '2024-09-15 01:13:12', '2024-09-15 01:13:12'),
(2, 5, 0, 0, 0, 0, 0, 1, 1, '2024-09-15 01:13:12', '2024-09-15 01:13:12');

-- --------------------------------------------------------

--
-- Estrutura para tabela `work_times`
--

CREATE TABLE `work_times` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `user_res` bigint(20) UNSIGNED DEFAULT NULL,
  `date_from` date NOT NULL,
  `date_to` date NOT NULL,
  `time_from` time NOT NULL,
  `time_to` time NOT NULL,
  `lunch_from` time DEFAULT NULL,
  `lunch_to` time DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `work_times`
--

INSERT INTO `work_times` (`id`, `user_id`, `user_res`, `date_from`, `date_to`, `time_from`, `time_to`, `lunch_from`, `lunch_to`, `created_at`, `updated_at`) VALUES
(1, 5, 5, '2024-09-19', '2025-01-01', '09:00:00', '17:00:00', '12:00:00', '13:00:00', '2024-09-17 05:21:45', '2024-09-17 05:21:45');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customers_email_unique` (`email`),
  ADD KEY `customers_user_id_foreign` (`user_id`);
ALTER TABLE `customers` ADD FULLTEXT KEY `name` (`name`,`surname`);

--
-- Índices de tabela `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Índices de tabela `holidays`
--
ALTER TABLE `holidays`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `my_services`
--
ALTER TABLE `my_services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `my_services_user_id_foreign` (`user_id`),
  ADD KEY `my_services_user_res_foreign` (`user_res`),
  ADD KEY `my_services_service_id_foreign` (`service_id`);

--
-- Índices de tabela `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `notifications_status`
--
ALTER TABLE `notifications_status`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Índices de tabela `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Índices de tabela `phone_area_codes`
--
ALTER TABLE `phone_area_codes`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `photos`
--
ALTER TABLE `photos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `photos_user_id_foreign` (`user_id`);

--
-- Índices de tabela `profiles`
--
ALTER TABLE `profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `profiles_user_id_foreign` (`user_id`);

--
-- Índices de tabela `renewals`
--
ALTER TABLE `renewals`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviews_user_id_foreign` (`user_id`);

--
-- Índices de tabela `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `services_categories`
--
ALTER TABLE `services_categories`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `settings_user_id_foreign` (`user_id`);

--
-- Índices de tabela `sms_marketing`
--
ALTER TABLE `sms_marketing`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `sms_marketing_send_status`
--
ALTER TABLE `sms_marketing_send_status`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `sms_settings`
--
ALTER TABLE `sms_settings`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Índices de tabela `vacations`
--
ALTER TABLE `vacations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vacations_user_pro_foreign` (`user_res`);

--
-- Índices de tabela `websites`
--
ALTER TABLE `websites`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `websites_domain_unique` (`domain`),
  ADD KEY `websites_user_id_foreign` (`user_id`);

--
-- Índices de tabela `work_hours`
--
ALTER TABLE `work_hours`
  ADD PRIMARY KEY (`id`),
  ADD KEY `work_hours_user_id_foreign` (`user_id`);

--
-- Índices de tabela `work_times`
--
ALTER TABLE `work_times`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `holidays`
--
ALTER TABLE `holidays`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de tabela `my_services`
--
ALTER TABLE `my_services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `notifications_status`
--
ALTER TABLE `notifications_status`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `phone_area_codes`
--
ALTER TABLE `phone_area_codes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `photos`
--
ALTER TABLE `photos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `profiles`
--
ALTER TABLE `profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `renewals`
--
ALTER TABLE `renewals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `services_categories`
--
ALTER TABLE `services_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `sms_settings`
--
ALTER TABLE `sms_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `vacations`
--
ALTER TABLE `vacations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `work_times`
--
ALTER TABLE `work_times`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `profiles`
--
ALTER TABLE `profiles`
  ADD CONSTRAINT `profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `vacations`
--
ALTER TABLE `vacations`
  ADD CONSTRAINT `vacations_user_pro_foreign` FOREIGN KEY (`user_res`) REFERENCES `profiles` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `work_times`
--
ALTER TABLE `work_times`
  ADD CONSTRAINT `work_times_employee_id_foreign` FOREIGN KEY (`user_res`) REFERENCES `profiles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `work_times_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
