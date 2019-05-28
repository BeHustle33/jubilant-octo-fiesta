-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Апр 10 2019 г., 13:31
-- Версия сервера: 5.7.23
-- Версия PHP: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `task_manager`
--

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `createdate` datetime NOT NULL,
  `color` enum('red','green','blue','white','black') NOT NULL DEFAULT 'white',
  `user_create_id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`id`, `name`, `createdate`, `color`, `user_create_id`, `parent_id`) VALUES
(1, 'Личное', '2019-03-25 02:57:38', 'red', 1, NULL),
(2, 'Работа', '2019-03-25 02:58:30', 'green', 2, NULL),
(3, 'Важное', '2019-03-25 22:28:13', 'blue', 2, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `groups`
--

CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `desription` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `groups`
--

INSERT INTO `groups` (`id`, `name`, `desription`) VALUES
(1, 'Зарегистрированные пользователи', 'Необходима модерация перед написанием сообщения'),
(2, 'Пользователи с правом писать сообщения', 'Возможно писать сообщения без модерации');

-- --------------------------------------------------------

--
-- Структура таблицы `group_user`
--

CREATE TABLE `group_user` (
  `user_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `group_user`
--

INSERT INTO `group_user` (`user_id`, `group_id`) VALUES
(1, 1),
(2, 1),
(2, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `caption` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `createdate` datetime NOT NULL,
  `user_create_id` int(11) NOT NULL,
  `user_receive_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `subcategory_id` int(11) DEFAULT NULL,
  `was_read` enum('yes','no') NOT NULL DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `messages`
--

INSERT INTO `messages` (`id`, `caption`, `content`, `createdate`, `user_create_id`, `user_receive_id`, `category_id`, `subcategory_id`, `was_read`) VALUES
(1, 'Химки кампания', 'dasdsa', '2019-03-25 23:05:27', 2, 2, 1, NULL, 'no'),
(2, 'Теплый кампания', 'ВВВВВВВВВВВВВВВВВВВВВВВВВ', '2019-03-25 23:16:16', 1, 2, 1, NULL, 'yes'),
(3, 'Империя Кампания', 'dsadsadsa', '2019-03-25 23:16:30', 2, 2, 2, NULL, 'yes'),
(4, 'Тест сообщений', 'Какой-то текст', '2019-03-25 23:16:51', 2, 2, 3, NULL, 'no'),
(5, 'Химки кампания', 'dsadas', '2019-03-31 21:09:47', 2, 3, 2, NULL, 'no'),
(6, 'Химки кампания', 'asdas', '2019-03-31 21:16:57', 2, 3, 1, NULL, 'no'),
(7, 'Название', 'Контент', '2019-03-31 21:38:31', 2, 1, 1, NULL, 'yes'),
(8, 'fsdfsd', 'fdsfds', '2019-03-31 21:41:36', 2, 3, 1, NULL, 'no'),
(9, 'Химки кампания', 'dasdas', '2019-03-31 21:49:50', 2, 3, 1, NULL, 'no'),
(10, 'Химки кампания', 'DASDAS', '2019-03-31 21:52:35', 2, 3, 1, NULL, 'no'),
(11, 'Dfff', 'asds', '2019-03-31 22:03:50', 2, 3, 1, NULL, 'no'),
(12, 'dasdasd', 'dasdsa', '2019-04-03 21:47:32', 2, 3, 2, NULL, 'no'),
(13, 'dasdasd', 'dasdsa', '2019-04-03 21:48:14', 2, 3, 2, NULL, 'no'),
(14, 'fdsf', 'sdfds', '2019-04-05 00:40:09', 2, 3, 1, NULL, 'no'),
(15, 'DDDDDD', '^D :D ))', '2019-04-09 23:09:27', 2, 3, 2, NULL, 'no');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `isactive` enum('yes','no') NOT NULL DEFAULT 'yes',
  `surname` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `patronymic` varchar(255) DEFAULT NULL,
  `phone` varchar(20) NOT NULL,
  `password` varchar(32) NOT NULL,
  `issubscribe` enum('yes','no') NOT NULL DEFAULT 'yes'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `email`, `isactive`, `surname`, `name`, `patronymic`, `phone`, `password`, `issubscribe`) VALUES
(1, 'vlad@server.ru', 'yes', 'Клева', 'Владислав', 'Андреевич', '89776724767', '827ccb0eea8a706c4c34a16891f84e7b', 'yes'),
(2, 'admin@localhost', 'yes', 'Admin', 'Admin', NULL, '89997899999', '202cb962ac59075b964b07152d234b70', 'yes'),
(3, 'i.vlad.kleva@gmail.com', 'yes', 'Админов', 'Админ', 'Админович', '9258271400', '25d55ad283aa400af464c76d713c07ad', 'no');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `category_user_id` (`user_create_id`),
  ADD KEY `category_parent_id` (`parent_id`);

--
-- Индексы таблицы `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `group_user`
--
ALTER TABLE `group_user`
  ADD PRIMARY KEY (`group_id`,`user_id`),
  ADD KEY `group_user_user_id` (`user_id`);

--
-- Индексы таблицы `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `messages_category_id` (`category_id`),
  ADD KEY `messages_subcategory_id` (`subcategory_id`),
  ADD KEY `messages_user_create_id` (`user_create_id`),
  ADD KEY `messages_user_receive_id` (`user_receive_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `category_parent_id` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `category_user_id` FOREIGN KEY (`user_create_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `group_user`
--
ALTER TABLE `group_user`
  ADD CONSTRAINT `group_user_group_id` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `group_user_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_category_id` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `messages_subcategory_id` FOREIGN KEY (`subcategory_id`) REFERENCES `subcategories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `messages_user_create_id` FOREIGN KEY (`user_create_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `messages_user_receive_id` FOREIGN KEY (`user_receive_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
