-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Хост: mysql:3306
-- Время создания: Дек 06 2025 г., 19:14
-- Версия сервера: 8.4.6
-- Версия PHP: 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `laravel`
--

-- --------------------------------------------------------

--
-- Структура таблицы `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE `comments` (
  `id` bigint UNSIGNED NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `post_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `images`
--

CREATE TABLE `images` (
  `id` bigint UNSIGNED NOT NULL,
  `filename` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mime_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `size` int DEFAULT NULL,
  `order` int NOT NULL DEFAULT '0',
  `imageable_id` bigint UNSIGNED NOT NULL,
  `imageable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `images`
--

INSERT INTO `images` (`id`, `filename`, `path`, `mime_type`, `size`, `order`, `imageable_id`, `imageable_type`, `created_at`, `updated_at`) VALUES
(1, 'anime1.jpg', 'posts/N0Z7JlDt7jPFhWR0BNqcamr2YQ7ec2Uf02Buf69T.jpg', 'image/jpeg', 96507, 0, 9, 'App\\Models\\Post', '2025-12-06 18:20:02', '2025-12-06 18:20:02'),
(2, 'anime2.jpg', 'posts/OVbhg4wMTdVckyKmJtJ5XhJJIgnbhGQGKf1tmRJd.jpg', 'image/jpeg', 101762, 0, 9, 'App\\Models\\Post', '2025-12-06 18:20:02', '2025-12-06 18:20:02'),
(3, 'anime3.jpg', 'posts/soCnWQo6fxYLYDMpS22Te16odk7NrHw3Mip5P3KL.jpg', 'image/jpeg', 144950, 0, 9, 'App\\Models\\Post', '2025-12-06 18:20:02', '2025-12-06 18:20:02'),
(4, 'anime1.jpg', 'posts/IXIIVwWIJFGF1nGf2vNuaxH9HDn61RhyEvS3zT00.jpg', 'image/jpeg', 96507, 0, 10, 'App\\Models\\Post', '2025-12-06 18:21:30', '2025-12-06 18:21:30'),
(5, 'anime2.jpg', 'posts/ZN5i4S1GQOqrvQo9q5E8WzkUvPCOUEry952s2ZL7.jpg', 'image/jpeg', 101762, 0, 10, 'App\\Models\\Post', '2025-12-06 18:21:30', '2025-12-06 18:21:30'),
(6, 'anime3.jpg', 'posts/9YPyD5OMmLoxkrulQVkMOqOj5Uo0Dxsxm5SLXFxq.jpg', 'image/jpeg', 144950, 0, 10, 'App\\Models\\Post', '2025-12-06 18:21:30', '2025-12-06 18:21:30'),
(7, 'anime1.jpg', 'posts/MH7zuP3RuEcMS3oWhYHONB3VrlAAEK2dg9MNxSaB.jpg', 'image/jpeg', 96507, 0, 11, 'App\\Models\\Post', '2025-12-06 18:21:30', '2025-12-06 18:21:30'),
(8, 'anime2.jpg', 'posts/YqEyj2JAsh80CWsgSHWxaKCAdJOc75OQrZ0lNeo3.jpg', 'image/jpeg', 101762, 0, 11, 'App\\Models\\Post', '2025-12-06 18:21:30', '2025-12-06 18:21:30'),
(9, 'anime3.jpg', 'posts/ZpsqO11YMy6vVu8LarkbXvwZeTas9oIGgyycAJhb.jpg', 'image/jpeg', 144950, 0, 11, 'App\\Models\\Post', '2025-12-06 18:21:30', '2025-12-06 18:21:30');

-- --------------------------------------------------------

--
-- Структура таблицы `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_10_14_121507_create_personal_access_tokens_table', 1),
(5, '2025_11_15_113816_create_posts_table', 1),
(6, '2025_11_15_114350_create_comments_table', 1),
(7, '2025_11_15_114537_create_images_table', 1),
(8, '2025_11_15_134825_create_tags_table', 1),
(9, '2025_11_15_140058_create_post_tag_table', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(2, 'App\\Models\\User', 42, 'login_token', '4aa9a9d721a9040273d8830c98f325f1a26503d586cbba556978060a06112b92', '[\"*\"]', '2025-12-06 18:59:58', '2025-12-13 18:06:56', '2025-12-06 18:06:56', '2025-12-06 18:59:58');

-- --------------------------------------------------------

--
-- Структура таблицы `posts`
--

CREATE TABLE `posts` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `likes` int NOT NULL DEFAULT '0',
  `views` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `title`, `content`, `likes`, `views`, `created_at`, `updated_at`) VALUES
(1, 42, 'Геншин пост', 'Пост про геншин с тремя тегами с двумя картинками', 0, 0, '2025-12-06 18:15:54', '2025-12-06 18:15:54'),
(2, 42, 'Геншин пост', 'Пост про геншин с тремя тегами с двумя картинками', 0, 0, '2025-12-06 18:17:10', '2025-12-06 18:17:10'),
(3, 42, 'Геншин пост', 'Пост про геншин с тремя тегами с двумя картинками', 0, 0, '2025-12-06 18:17:11', '2025-12-06 18:17:11'),
(4, 42, 'Геншин пост', 'Пост про геншин с тремя тегами с двумя картинками', 0, 0, '2025-12-06 18:17:12', '2025-12-06 18:17:12'),
(5, 42, 'Геншин пост', 'Пост про геншин с тремя тегами с двумя картинками', 0, 0, '2025-12-06 18:17:12', '2025-12-06 18:17:12'),
(6, 42, 'Геншин пост', 'Пост про геншин с тремя тегами с двумя картинками', 0, 0, '2025-12-06 18:17:28', '2025-12-06 18:17:28'),
(7, 42, 'Геншин пост', 'Пост про геншин с тремя тегами с двумя картинками', 0, 0, '2025-12-06 18:17:29', '2025-12-06 18:17:29'),
(8, 42, 'Геншин пост', 'Пост про геншин с тремя тегами с двумя картинками', 0, 0, '2025-12-06 18:18:38', '2025-12-06 18:18:38'),
(9, 42, 'Геншин пост', 'Пост про геншин с тремя тегами с двумя картинками', 0, 0, '2025-12-06 18:20:02', '2025-12-06 18:20:02'),
(10, 42, 'Геншин пост', 'Пост про геншин с тремя тегами с двумя картинками', 0, 0, '2025-12-06 18:21:30', '2025-12-06 18:21:30'),
(11, 42, 'Геншин пост', 'Пост про геншин с тремя тегами с двумя картинками', 0, 0, '2025-12-06 18:21:30', '2025-12-06 18:21:30');

-- --------------------------------------------------------

--
-- Структура таблицы `post_tag`
--

CREATE TABLE `post_tag` (
  `id` bigint UNSIGNED NOT NULL,
  `post_id` bigint UNSIGNED NOT NULL,
  `tag_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `post_tag`
--

INSERT INTO `post_tag` (`id`, `post_id`, `tag_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL),
(2, 1, 2, NULL, NULL),
(3, 1, 3, NULL, NULL),
(4, 2, 1, NULL, NULL),
(5, 2, 2, NULL, NULL),
(6, 2, 3, NULL, NULL),
(7, 3, 1, NULL, NULL),
(8, 3, 2, NULL, NULL),
(9, 3, 3, NULL, NULL),
(10, 4, 1, NULL, NULL),
(11, 4, 2, NULL, NULL),
(12, 4, 3, NULL, NULL),
(13, 5, 1, NULL, NULL),
(14, 5, 2, NULL, NULL),
(15, 5, 3, NULL, NULL),
(16, 6, 1, NULL, NULL),
(17, 6, 2, NULL, NULL),
(18, 6, 3, NULL, NULL),
(19, 7, 1, NULL, NULL),
(20, 7, 2, NULL, NULL),
(21, 7, 3, NULL, NULL),
(22, 8, 1, NULL, NULL),
(23, 8, 2, NULL, NULL),
(24, 8, 3, NULL, NULL),
(25, 9, 1, NULL, NULL),
(26, 9, 2, NULL, NULL),
(27, 9, 3, NULL, NULL),
(28, 10, 1, NULL, NULL),
(29, 10, 2, NULL, NULL),
(30, 10, 3, NULL, NULL),
(31, 11, 1, NULL, NULL),
(32, 11, 2, NULL, NULL),
(33, 11, 3, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `tags`
--

CREATE TABLE `tags` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `tags`
--

INSERT INTO `tags` (`id`, `name`, `slug`, `color`, `description`, `created_at`, `updated_at`) VALUES
(1, 'фурина1', 'furina1', '#4ECDC4', NULL, '2025-12-06 18:15:54', '2025-12-06 18:15:54'),
(2, 'косплей', 'kosplei', '#4ECDC4', NULL, '2025-12-06 18:15:54', '2025-12-06 18:15:54'),
(3, 'арт', 'art', '#9B59B6', NULL, '2025-12-06 18:15:54', '2025-12-06 18:15:54');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `login` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('user','admin','superadmin') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `status` enum('pending','active','inactive','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `login`, `email`, `type`, `status`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(42, 'mirita', 'miri1ta', 'mirita@gmail.com', 'user', 'active', '2025-12-06 12:50:34', '$2y$12$fFAXf5G67ySfItI/8E05KOTyr02MJaVZuS9xJnde0UoEl5BT7Cfai', NULL, '2025-12-06 12:50:27', '2025-12-06 12:50:34');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Индексы таблицы `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Индексы таблицы `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_user_id_foreign` (`user_id`),
  ADD KEY `comments_post_id_foreign` (`post_id`);

--
-- Индексы таблицы `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Индексы таблицы `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `images_imageable_type_imageable_id_index` (`imageable_type`,`imageable_id`);

--
-- Индексы таблицы `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Индексы таблицы `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Индексы таблицы `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Индексы таблицы `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `posts_user_id_foreign` (`user_id`);

--
-- Индексы таблицы `post_tag`
--
ALTER TABLE `post_tag`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `post_tag_post_id_tag_id_unique` (`post_id`,`tag_id`),
  ADD KEY `post_tag_tag_id_foreign` (`tag_id`);

--
-- Индексы таблицы `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Индексы таблицы `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tags_name_unique` (`name`),
  ADD UNIQUE KEY `tags_slug_unique` (`slug`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_login_unique` (`login`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `images`
--
ALTER TABLE `images`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT для таблицы `post_tag`
--
ALTER TABLE `post_tag`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT для таблицы `tags`
--
ALTER TABLE `tags`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `post_tag`
--
ALTER TABLE `post_tag`
  ADD CONSTRAINT `post_tag_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `post_tag_tag_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
