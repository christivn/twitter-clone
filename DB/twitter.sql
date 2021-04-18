-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-04-2021 a las 01:04:33
-- Versión del servidor: 10.4.14-MariaDB
-- Versión de PHP: 7.2.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `twitter`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comments`
--

CREATE TABLE `comments` (
  `tweet_id` varchar(16) NOT NULL,
  `user_id` int(7) NOT NULL,
  `content` varchar(144) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `favs`
--

CREATE TABLE `favs` (
  `tweet_id` varchar(16) NOT NULL,
  `user_fav_id` int(7) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `follows`
--

CREATE TABLE `follows` (
  `following_user_id` int(7) NOT NULL,
  `followed_user_id` int(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `follows`
--

INSERT INTO `follows` (`following_user_id`, `followed_user_id`) VALUES
(4, 9),
(4, 21);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notifications`
--

CREATE TABLE `notifications` (
  `user_id` int(7) NOT NULL,
  `follow_notification` bit(1) NOT NULL,
  `fav_notification` bit(1) NOT NULL,
  `rt_notification` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rt`
--

CREATE TABLE `rt` (
  `tweet_id` varchar(16) NOT NULL,
  `user_rt_id` int(7) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tweets`
--

CREATE TABLE `tweets` (
  `user_id` int(7) NOT NULL,
  `tweet_id` varchar(16) NOT NULL,
  `date` datetime NOT NULL,
  `content` varchar(144) NOT NULL,
  `img_url` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `id` int(7) NOT NULL,
  `nick` varchar(15) NOT NULL,
  `name_twitter` varchar(20) NOT NULL,
  `pass_hash` varchar(32) NOT NULL,
  `api_key` varchar(16) NOT NULL,
  `reg_date` datetime NOT NULL,
  `name_ic` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id`, `nick`, `name_twitter`, `pass_hash`, `api_key`, `reg_date`, `name_ic`) VALUES
(3, 'test1', 'test1', '81dc9bdb52d04dc20036dbd8313ed055', 'u2KEjFPM0tnrTO5u', '2021-03-11 23:23:01', ''),
(4, 'test', 'Usuario de testeo', '81dc9bdb52d04dc20036dbd8313ed055', 'TnPAWsnPwNTGt0F0', '2021-03-21 03:15:56', 'Richar Moreno'),
(5, 'testeo', 'testeo', '81dc9bdb52d04dc20036dbd8313ed055', 'KHMVtKmM6JrY0U5T', '2021-04-10 00:07:48', ''),
(6, 'usuario', 'usuario', '81dc9bdb52d04dc20036dbd8313ed055', 'VPSUZDK5VEr6zEDP', '2021-04-10 00:46:01', ''),
(7, 'asdasdasd', 'asdasdasd', '81dc9bdb52d04dc20036dbd8313ed055', '3YH1GwMFStCrECD5', '2021-04-10 00:48:19', ''),
(8, 'asdasdasd1', 'asdasdasd1', '81dc9bdb52d04dc20036dbd8313ed055', 'SSLJsIsIJRjGGKXI', '2021-04-10 00:49:20', ''),
(9, 'sdsdf234', 'sdsdf234', '81dc9bdb52d04dc20036dbd8313ed055', 'RE5QStNVGTS2VAP5', '2021-04-10 00:49:36', ''),
(10, 'sdfsadfasdf32', 'sdfsadfasdf32', '81dc9bdb52d04dc20036dbd8313ed055', 'n8F69GGJeYTQYtHJ', '2021-04-10 00:50:18', ''),
(11, 'sad43feds23', 'sad43feds23', '81dc9bdb52d04dc20036dbd8313ed055', 'wzJGQXezQKTVEALE', '2021-04-10 00:53:08', ''),
(12, 'dfdsf34gds', 'dfdsf34gds', '81dc9bdb52d04dc20036dbd8313ed055', 'DCws7GUPEGVEneuT', '2021-04-10 00:54:21', ''),
(13, 'test1234', 'test1234', '81dc9bdb52d04dc20036dbd8313ed055', 'MPYDJOGSVumjGVTT', '2021-04-10 00:55:16', ''),
(14, 'dsfsf234dsf', 'dsfsf234dsf', '81dc9bdb52d04dc20036dbd8313ed055', 'wJGTZmiJeTeC98GH', '2021-04-10 01:00:49', ''),
(15, 'gbfbcer54dfv34', 'gbfbcer54dfv34', '81dc9bdb52d04dc20036dbd8313ed055', '26tunG6SwtrM2E6t', '2021-04-10 01:05:53', ''),
(16, 'gbfbcer54dfv344', 'gbfbcer54dfv344', '81dc9bdb52d04dc20036dbd8313ed055', 'I5ZCDCLm2ZwK5SUD', '2021-04-10 01:06:26', ''),
(17, 'sad23fe432', 'sad23fe432', '81dc9bdb52d04dc20036dbd8313ed055', 'NJHMCZDHBnZEYEPr', '2021-04-10 01:07:07', ''),
(18, 'sdfsdf234dsf', 'sdfsdf234dsf', '81dc9bdb52d04dc20036dbd8313ed055', 'SVwET3rtwuE55WMP', '2021-04-10 01:09:56', ''),
(19, 'hh54edf', 'hh54edf', '81dc9bdb52d04dc20036dbd8313ed055', 'M0DKiKR2w28QT20w', '2021-04-10 01:10:27', ''),
(20, 'dfgdfg5', 'dfgdfg5', '81dc9bdb52d04dc20036dbd8313ed055', 'RusE2DStrOmKJGHG', '2021-04-10 01:11:08', ''),
(21, 'sdfsdf2fs', 'sdfsdf2fs', '81dc9bdb52d04dc20036dbd8313ed055', '0JMzJ0jKUCZTKeOi', '2021-04-10 01:12:01', ''),
(22, 'test67865', 'test67865', '81dc9bdb52d04dc20036dbd8313ed055', 'JHGCWJCGFVY2TGsw', '2021-04-10 01:14:46', ''),
(23, 'Kaki', 'Kaki', 'e10adc3949ba59abbe56e057f20f883e', 'SUPtCRmsL5SiO2zG', '2021-04-10 03:44:57', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_bio`
--

CREATE TABLE `user_bio` (
  `user_id` int(7) NOT NULL,
  `bio` varchar(150) NOT NULL,
  `avatar_url` varchar(150) NOT NULL,
  `banner_url` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `user_bio`
--

INSERT INTO `user_bio` (`user_id`, `bio`, `avatar_url`, `banner_url`) VALUES
(1, '', 'https://i.imgur.com/KO6w2dw.jpeg', 'img/banner.jpg'),
(2, '', 'https://i.imgur.com/7xXa5xi.jpeg', 'img/banner.jpg'),
(3, '', 'https://i.imgur.com/IbQoTd4.png', 'img/banner.jpg'),
(4, 'Esto es una biografía de ejemplo', 'https://i.imgur.com/TrmqA6a.jpeg', 'https://img.freepik.com/vector-gratis/tecnologia-azul-oscuro-fondo-banner-abstracto-alta-tecnologia_28629-1326.jpg?size=626&ext=jpg'),
(5, 'Lorem ipsum dolor', 'https://i.imgur.com/CLJHPra.png', 'img/banner.jpg'),
(6, '', 'https://i.imgur.com/bW2TMgK.png', 'img/banner.jpg'),
(7, '', 'https://i.imgur.com/CLJHPra.png', 'img/banner.jpg'),
(8, '', 'https://i.imgur.com/CLJHPra.png', 'img/banner.jpg'),
(9, '', 'https://i.imgur.com/zWksbug.jpeg', 'img/banner.jpg'),
(10, '', 'https://i.imgur.com/xg11fVh.jpeg', 'img/banner.jpg'),
(11, '', 'https://i.imgur.com/CLJHPra.png', 'img/banner.jpg'),
(12, '', 'https://i.imgur.com/CLJHPra.png', 'img/banner.jpg'),
(13, '', 'https://i.imgur.com/CLJHPra.png', 'img/banner.jpg'),
(14, '', 'https://i.imgur.com/CLJHPra.png', 'img/banner.jpg'),
(15, '', 'https://i.imgur.com/zu9r5hT.jpeg', 'img/banner.jpg'),
(16, '', 'https://i.imgur.com/CLJHPra.png', 'img/banner.jpg'),
(17, '', 'https://i.imgur.com/ovegWkT.jpeg', 'img/banner.jpg'),
(18, '', 'https://i.imgur.com/CLJHPra.png', 'img/banner.jpg'),
(19, '', 'https://i.imgur.com/CLJHPra.png', 'img/banner.jpg'),
(20, '', 'https://i.imgur.com/EA3XYjE.jpeg', 'img/banner.jpg'),
(21, '', 'https://i.imgur.com/JN7cL6H.jpeg', 'img/banner.jpg'),
(22, '', 'https://i.imgur.com/7xZGLxY.jpeg', 'img/banner.jpg'),
(23, '', 'https://i.imgur.com/CLJHPra.png', 'img/banner.jpg');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`tweet_id`,`content`) USING BTREE;

--
-- Indices de la tabla `favs`
--
ALTER TABLE `favs`
  ADD PRIMARY KEY (`tweet_id`,`user_fav_id`);

--
-- Indices de la tabla `follows`
--
ALTER TABLE `follows`
  ADD PRIMARY KEY (`following_user_id`,`followed_user_id`);

--
-- Indices de la tabla `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`user_id`);

--
-- Indices de la tabla `rt`
--
ALTER TABLE `rt`
  ADD PRIMARY KEY (`tweet_id`,`user_rt_id`);

--
-- Indices de la tabla `tweets`
--
ALTER TABLE `tweets`
  ADD PRIMARY KEY (`tweet_id`) USING BTREE;

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`,`nick`) USING BTREE;

--
-- Indices de la tabla `user_bio`
--
ALTER TABLE `user_bio`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `user_bio`
--
ALTER TABLE `user_bio`
  MODIFY `user_id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
