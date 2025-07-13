-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июл 09 2025 г., 12:46
-- Версия сервера: 10.4.26-MariaDB-log
-- Версия PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `uploader`
--

-- --------------------------------------------------------

--
-- Структура таблицы `files`
--

CREATE TABLE `files` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `filename` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `upload_date` timestamp NOT NULL,
  `size` int(11) NOT NULL,
  `password` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `files`
--

INSERT INTO `files` (`id`, `name`, `description`, `filename`, `upload_date`, `size`, `password`) VALUES
(1, 'Попурри', 'None', 'Попурри.mp3', '2025-06-30 04:59:54', 1024, '123'),
(2, 'bKMZ', 'fyfuyf', 'ДИАГРАММА.xlsx', '2025-07-04 08:34:09', 31358, '123'),
(3, 'Без пароля', 'Без пароля', 'task14.xlsx', '2025-07-05 16:47:25', 31347, ''),
(47, 'Попурри', 'без', 'task14 (11).xlsx', '2025-07-08 08:13:04', 31347, ''),
(48, 'Калькулятор', 'простой калькулятор', '772720.torrent', '2025-07-08 18:02:23', 14397, '123');

-- --------------------------------------------------------

--
-- Структура таблицы `statistic_of_downloads`
--

CREATE TABLE `statistic_of_downloads` (
  `id` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `download_date` timestamp NOT NULL,
  `IP_address` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `statistic_of_downloads`
--

INSERT INTO `statistic_of_downloads` (`id`, `download_date`, `IP_address`) VALUES
('1', '2025-06-30 04:59:54', '159.168.75.40'),
('3', '2025-07-07 21:27:07', '127.0.0.1'),
('1', '2025-07-07 21:27:57', '127.0.0.1'),
('47', '2025-07-08 17:51:30', '127.0.0.1'),
('47', '2025-07-08 17:51:34', '127.0.0.1'),
('47', '2025-07-08 17:51:38', '127.0.0.1'),
('48', '2025-07-08 18:02:34', '127.0.0.1'),
('48', '2025-07-08 18:02:36', '127.0.0.1'),
('48', '2025-07-08 18:02:37', '127.0.0.1'),
('48', '2025-07-08 18:02:37', '127.0.0.1'),
('48', '2025-07-08 18:02:37', '127.0.0.1'),
('48', '2025-07-08 18:02:38', '127.0.0.1');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `filename` (`filename`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `files`
--
ALTER TABLE `files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
