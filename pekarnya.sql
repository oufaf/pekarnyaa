-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Май 13 2025 г., 14:06
-- Версия сервера: 10.4.32-MariaDB
-- Версия PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `pekarnya`
--

-- --------------------------------------------------------

--
-- Структура таблицы `about_bakery`
--

CREATE TABLE `about_bakery` (
  `id` int(11) NOT NULL,
  `main_title` varchar(255) NOT NULL DEFAULT 'Свежая выпечка — одно бовью каждый день!',
  `section_title` varchar(255) NOT NULL DEFAULT 'О пекарне',
  `paragraph1` text NOT NULL,
  `paragraph2` text NOT NULL,
  `quote_text` text NOT NULL,
  `quote_author` varchar(100) DEFAULT 'Моя мысль:',
  `main_image` varchar(255) DEFAULT 'images/bakery-interior.jpg',
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `about_bakery`
--

INSERT INTO `about_bakery` (`id`, `main_title`, `section_title`, `paragraph1`, `paragraph2`, `quote_text`, `quote_author`, `main_image`, `updated_at`) VALUES
(1, 'Свежая выпечка — одно бовью каждый день!', 'О пекарне', 'Доброголюдная и малолетняя пекарня, где каждый булочок — это рыбка, выпеченные с кобылей.', 'Услышав крайний путь с каменным океаном-поездом, где сегодня решетки передавались от появления в экономике. Сегодня не сохранил традиции, но добавляют в них содержание технологии водоносения со всего мира.', '– давать людей радость через звук. Многопоседует только результаты погружения, заботы которых ни на складах не так, чтобы начали пигонов были совсем недовольны.', 'Моя мысль:', '2.jpg', '2025-05-09 14:39:03');

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`id`, `name`, `image`) VALUES
(1, 'Хлеб и булочки', 'bulka.jpg'),
(2, 'Пироги и пирожки', 'bulka.jpg'),
(3, 'Десерты и Сладости', 'bulka.jpg'),
(4, 'Праздничная выпечка', 'bulka.jpg');

-- --------------------------------------------------------

--
-- Структура таблицы `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `message` text NOT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `header`
--

CREATE TABLE `header` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `link` varchar(255) NOT NULL,
  `sort_order` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `header`
--

INSERT INTO `header` (`id`, `title`, `link`, `sort_order`) VALUES
(1, 'Вход', 'login.php', 1),
(2, 'Главная', 'index.php', 2),
(3, 'Каталог продукции', 'catalog.php', 3),
(4, 'Корзина', 'cart.php', 4),
(5, 'О пекарне', 'about.php', 5),
(6, 'Акции', 'sales.php', 6),
(7, 'Новости', 'news.php', 7),
(8, 'Отзывы', 'reviews.php', 8);

-- --------------------------------------------------------

--
-- Структура таблицы `main1`
--

CREATE TABLE `main1` (
  `id` int(11) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `caption` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `main1`
--

INSERT INTO `main1` (`id`, `image_url`, `caption`) VALUES
(1, 'path_to_your_image1.jpg', 'Свежая выпечка — с любовью каждый день!'),
(2, 'path_to_your_image2.jpg', 'Лучшие багеты в городе, попробуйте прямо сейчас!'),
(3, 'path_to_your_image3.jpg', 'Каждый багет — это произведение искусства!');

-- --------------------------------------------------------

--
-- Структура таблицы `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `published_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `news`
--

INSERT INTO `news` (`id`, `category_id`, `title`, `slug`, `content`, `image`, `published_at`, `is_active`) VALUES
(1, 1, 'Праздник Хлеба в нашей пекарне', 'prazdnik-hleba', 'Мы провели Праздник Хлеба — с мастер-классами, дегустациями и подарками. Благодарим всех гостей!', NULL, '2025-05-10 12:07:11', 1),
(2, 2, 'Скидка 20% на всю продукцию по пятницам!', 'skidka-20-pyatnica', 'Каждую пятницу в нашей пекарне — скидка 20% на всё меню. Отличный повод заглянуть!', NULL, '2025-05-10 12:07:11', 1),
(3, 3, 'Новая линейка круассанов с начинками', 'novye-kruassany', 'Встречайте: круассаны с малиной, шоколадом, карамелью и заварным кремом. Уже в продаже!', NULL, '2025-05-10 12:07:11', 1),
(4, 4, 'Как хранить выпечку дольше — 5 простых советов', 'kak-hranit-vypechku', 'Рассказываем, как правильно хранить хлеб и сладости, чтобы они долго оставались свежими.', NULL, '2025-05-10 12:07:11', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `news_categories`
--

CREATE TABLE `news_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `news_categories`
--

INSERT INTO `news_categories` (`id`, `name`, `slug`, `description`, `created_at`) VALUES
(1, 'События пекарни', 'sobytia-pekarny', 'Все главные события, праздники и мероприятия нашей пекарни.', '2025-05-10 12:07:11'),
(2, 'Акции и скидки', 'akcii-skidki', 'Информация о текущих и предстоящих акциях.', '2025-05-10 12:07:11'),
(3, 'Новые продукты', 'novye-produkty', 'Анонсы новых позиций и сезонных товаров.', '2025-05-10 12:07:11'),
(4, 'Полезные советы', 'poleznye-sovety', 'Интересные статьи и рекомендации по выпечке и хранению.', '2025-05-10 12:07:11');

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `address` text NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `address`, `total`, `created_at`) VALUES
(2, '123123', 120.00, '2025-05-11 14:39:30'),
(3, '123123', 49.00, '2025-05-11 14:49:56'),
(4, '123123', 55.00, '2025-05-11 15:58:22'),
(5, '123123', 65.00, '2025-05-13 11:45:54'),
(6, '123123', 55.00, '2025-05-13 12:34:49');

-- --------------------------------------------------------

--
-- Структура таблицы `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_name`, `price`, `quantity`) VALUES
(2, 2, 'Пирог с яблоками', 120.00, 1),
(3, 3, 'Багет классический', 49.00, 1),
(4, 4, 'Булочка с корицей', 55.00, 1),
(5, 5, 'Эклер с кремом', 65.00, 1),
(6, 6, 'Булочка с корицей', 55.00, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `category_id` int(10) UNSIGNED DEFAULT NULL,
  `available` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `image`, `category_id`, `available`, `created_at`) VALUES
(1, 'Багет классический', 'Французский багет с хрустящей коркой.', 49.00, 'images/products/baguette.jpg', 1, 1, '2025-05-09 14:51:27'),
(2, 'Круассан с маслом', 'Слоёный круассан с маслом.', 65.00, 'images/products/croissant.jpg', 1, 1, '2025-05-09 14:51:27'),
(3, 'Пирог с яблоками', 'Домашний пирог с яблочной начинкой.', 120.00, 'images/products/apple_pie.jpg', 2, 1, '2025-05-09 14:51:27'),
(4, 'Булочка с корицей', 'Булочка с корицей и глазурью.', 55.00, 'images/products/cinnamon_roll.jpg', 3, 1, '2025-05-09 14:51:27'),
(5, 'Эклер с кремом', 'Эклер с заварным кремом.', 65.00, 'images/products/eclair.jpg', 3, 1, '2025-05-09 14:51:27'),
(6, 'Праздничный кулич', 'Пышный кулич с изюмом и глазурью.', 140.00, 'images/products/easter_kulich.jpg', 4, 1, '2025-05-09 14:51:27');

-- --------------------------------------------------------

--
-- Структура таблицы `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `reviews`
--

INSERT INTO `reviews` (`id`, `name`, `email`, `message`, `created_at`, `user_id`) VALUES
(1, 'Иван Иванов', 'ivanov@example.com', 'Отличная пекарня! Очень вкусные круассаны.', '2025-05-10 12:49:23', 0),
(2, 'Мария Петрова', 'petrova@example.com', 'Люблю ваши торты, особенно с клубникой.', '2025-05-10 12:49:23', 0),
(3, 'Алексей Смирнов', 'smirnov@example.com', 'Хлеб всегда свежий и ароматный.', '2025-05-10 12:49:23', 0),
(4, 'Иван Мальцев', 'vanyaplanschet@gmail.com', 'Круасаны топ блябуду!', '2025-05-10 12:53:08', 0),
(5, 'Иван Мальцев', 'vanyaplanschet@gmail.com', 'Круасаны топ блябуду!', '2025-05-10 12:53:46', 0),
(6, 'Иван Мальцев', 'vanyaplanschet@gmail.com', 'Круасаны топ блябуду!', '2025-05-10 12:53:49', 0),
(7, '123', '', '123', '2025-05-11 11:20:23', 6),
(8, '123123', '', '123123', '2025-05-11 11:20:32', 6),
(9, 'Иван', '', 'Круасаны топ, отвечаю за базар', '2025-05-11 11:50:23', 6),
(10, '1', '', '1', '2025-05-13 09:46:10', 6);

-- --------------------------------------------------------

--
-- Структура таблицы `sales`
--

CREATE TABLE `sales` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `sales`
--

INSERT INTO `sales` (`id`, `title`, `description`, `image`, `start_date`, `end_date`, `is_active`) VALUES
(1, '2 Эклера + Кофе = 1 Эклер в подарок!', 'Купите два эклера и кофе, и получите ещё один эклер бесплатно! Акция действует до конца месяца.', 'images/sales/eclairs_promo.jpg', '2025-05-01', '2025-05-31', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `name`, `password`, `avatar`, `created_at`) VALUES
(1, 'timed', 'vanyaplanschet@gmail.com', '', '$2y$10$4uL3217UZE05p/0zv5LvcOO5Sr8zxY17hoV2xn4Gz6uYvxCiyg67.', NULL, '2025-05-10 13:05:32'),
(4, 'Иван', 'vanyaniger0@gmail.com', '', '$2y$10$1a5T88sadfcO1RXL1s96gOYB0yifvlHyUFHYJgIYeUOXvHWpMLmWa', NULL, '2025-05-10 13:06:29'),
(6, '', 'timed@gmail.com', 'Иван', '$2y$10$H6Q/oqoJ.ZBskSt7.4EmkuQ6i/QdrpTKwFHko2PTcVtE8OEpun1y6', 'uploads/Без названия.png', '2025-05-10 13:20:30');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `about_bakery`
--
ALTER TABLE `about_bakery`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Индексы таблицы `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `header`
--
ALTER TABLE `header`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `main1`
--
ALTER TABLE `main1`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `category_id` (`category_id`);

--
-- Индексы таблицы `news_categories`
--
ALTER TABLE `news_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Индексы таблицы `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `about_bakery`
--
ALTER TABLE `about_bakery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `header`
--
ALTER TABLE `header`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `main1`
--
ALTER TABLE `main1`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `news_categories`
--
ALTER TABLE `news_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `news_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `news_categories` (`id`);

--
-- Ограничения внешнего ключа таблицы `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
