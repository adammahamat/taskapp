-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Май 21 2020 г., 04:58
-- Версия сервера: 5.7.21-20-beget-5.7.21-20-1-log
-- Версия PHP: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `hadam1kt_task`
--

-- --------------------------------------------------------

--
-- Структура таблицы `tasks`
--
-- Создание: Май 21 2020 г., 01:51
-- Последнее обновление: Май 21 2020 г., 01:57
--

DROP TABLE IF EXISTS `tasks`;
CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `body` varchar(255) NOT NULL,
  `completed` int(11) DEFAULT NULL,
  `redacted` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `tasks`
--

INSERT INTO `tasks` (`id`, `name`, `email`, `body`, `completed`, `redacted`) VALUES
(1, 'admin', 'admin@gmail.com', 'admin test', 1, NULL),
(2, 'john', 'john@gmail.com', 'test', NULL, NULL),
(3, 'mahamat', 'mahamat@mail.com', 'task', NULL, NULL),
(4, 'Vadim', 'vadim@mail.com', 'test Vadim', NULL, NULL),
(5, 'Zakaria', 'zakaria@hotmail.com', 'Zakaria test', NULL, NULL),
(6, 'Roland', 'roland@gmail.com', 'Roland 123', NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--
-- Создание: Май 21 2020 г., 01:51
-- Последнее обновление: Май 21 2020 г., 01:54
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(128) NOT NULL,
  `admin` varchar(255) DEFAULT NULL,
  `remember_token` varchar(128) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `admin`, `remember_token`) VALUES
(5, '', '', '12345', '1', '10\r\n'),
(6, '', '', '123', 'admin@mail.ru', '1'),
(7, 'admin', 'admin@mail.com', '$2y$10$Njg0xvd9vip.rS4kyCCE4uspH0WJ3WEp3S5WH3Ls7eHwwbRhr0Tby', NULL, '');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
