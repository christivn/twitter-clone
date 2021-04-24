-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-04-2021 a las 03:07:06
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

--
-- Volcado de datos para la tabla `comments`
--

INSERT INTO `comments` (`tweet_id`, `user_id`, `content`, `date`) VALUES
('J2VwsTImUVmS31Ez', 23, '3MENDO 🔥', '2021-04-18 23:36:28'),
('UI1TnFmK6rwiCCwS', 23, 'klk manin', '2021-04-24 01:38:22');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `favs`
--

CREATE TABLE `favs` (
  `tweet_id` varchar(16) NOT NULL,
  `user_fav_id` int(7) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `favs`
--

INSERT INTO `favs` (`tweet_id`, `user_fav_id`, `date`) VALUES
('GBA3Cz2E3NwFSUJR', 23, '2021-04-24 01:49:46'),
('GiGKGuuzWGST5RnC', 4, '2021-04-24 00:59:44'),
('GiGKGuuzWGST5RnC', 23, '2021-04-24 01:43:06'),
('J2VwsTImUVmS31Ez', 4, '2021-04-18 15:22:47'),
('J2VwsTImUVmS31Ez', 23, '2021-04-24 01:38:13'),
('mAZnJGLMD5A2Kzt7', 23, '2021-04-19 01:05:55');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `follows`
--

CREATE TABLE `follows` (
  `following_user_id` int(7) NOT NULL,
  `followed_user_id` int(7) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `follows`
--

INSERT INTO `follows` (`following_user_id`, `followed_user_id`, `date`) VALUES
(4, 23, '2021-04-24 02:06:56'),
(4, 30, '2021-04-24 01:27:53'),
(23, 4, '2021-04-24 01:28:14');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notifications`
--

CREATE TABLE `notifications` (
  `user_id` int(7) NOT NULL,
  `feed_notification` bit(1) NOT NULL,
  `general_notification` bit(1) NOT NULL
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

--
-- Volcado de datos para la tabla `rt`
--

INSERT INTO `rt` (`tweet_id`, `user_rt_id`, `date`) VALUES
('R2wKK5j5tWjQm3GG', 23, '2021-04-24 01:38:14');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tweets`
--

CREATE TABLE `tweets` (
  `user_id` int(7) NOT NULL,
  `tweet_id` varchar(16) NOT NULL,
  `date` datetime NOT NULL,
  `content` varchar(144) NOT NULL,
  `img_url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tweets`
--

INSERT INTO `tweets` (`user_id`, `tweet_id`, `date`, `content`, `img_url`) VALUES
(4, '6V8iwYTVinJsN0Ju', '2021-04-24 02:59:33', 'TWEET TEST', ''),
(4, 'CjBJVEBCRu95ESzK', '2021-04-19 00:48:52', 'Testeo Uno', ''),
(23, 'GiGKGuuzWGST5RnC', '2021-04-19 01:07:45', 'Aki con er ma mejo coxe der mundo', 'https://i.ibb.co/vmQzP1S/Screenshot-10.png'),
(4, 'J2VwsTImUVmS31Ez', '2021-04-18 02:41:13', 'Ejemplo de tweet con una imagen', 'https://concepto.de/wp-content/uploads/2015/03/paisaje-e1549600034372.jpg'),
(23, 'mAZnJGLMD5A2Kzt7', '2021-04-19 01:05:13', 'k disen lo jipis', 'https://i.ibb.co/qYk5Cyh/20210306192237-1-copia.jpg'),
(4, 'R2wKK5j5tWjQm3GG', '2021-04-19 00:52:42', 'Testeo de foto', 'https://librosostenibilidad.files.wordpress.com/2017/03/paisaje-cultura-sostenibilidad.jpg'),
(4, 'UI1TnFmK6rwiCCwS', '2021-04-18 02:38:45', 'Texto de ejemplo', ''),
(31, 'VeLZtzmXIEUCjmUC', '2021-04-19 01:03:31', 'Mi primer tweet :D', '');

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
(4, 'christivn', '𝔠𝔥𝔯𝔦𝔰𝔱𝔦𝔞𝔫', '81dc9bdb52d04dc20036dbd8313ed055', 'NKP6HVEImB1tOVui', '2021-03-21 03:15:56', 'Richar Moreno'),
(5, 'testeo', 'Aweonao', '81dc9bdb52d04dc20036dbd8313ed055', 'QSGH7CJznKTzzSTE', '2021-04-10 00:07:48', ''),
(6, 'usuario', 'SendNudes', '81dc9bdb52d04dc20036dbd8313ed055', 'DHK8Cn3ur2wKmstV', '2021-04-10 00:46:01', ''),
(23, 'Kaki', 'Kaki', '81dc9bdb52d04dc20036dbd8313ed055', '3rVEHmQRWnSnKPSQ', '2021-04-10 03:44:57', ''),
(25, 'SeñorIncognito', 'SeñorIncognito', '81dc9bdb52d04dc20036dbd8313ed055', 'JJVCSwNYiVPA52LC', '2021-04-18 18:55:55', ''),
(26, 'Fulanito', 'Fulanito', '81dc9bdb52d04dc20036dbd8313ed055', 'sGGLzAVEGQLZ135F', '2021-04-18 18:56:48', ''),
(30, 'Menganito', 'Menganito', '81dc9bdb52d04dc20036dbd8313ed055', 'TGwjG7iBVnRnGJm0', '2021-04-18 19:13:04', ''),
(31, 'nuevo', 'nuevo', '81dc9bdb52d04dc20036dbd8313ed055', 'VE6DEmTCeJRVPrHD', '2021-04-19 00:22:36', '');

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
(1, '', 'img/default.png', 'img/banner.jpg'),
(2, '', 'img/default.png', 'img/banner.jpg'),
(3, '', 'img/default.png', 'img/banner.jpg'),
(4, '🛡️ Usuario administrador 🛡️', '/backend/img/4_avatar.jpg', '/backend/img/4_banner.jpg'),
(5, 'Lorem ipsum dolor', '/backend/img/5_avatar.jpg', 'img/banner.jpg'),
(6, '', '/backend/img/6_avatar.jpg', 'img/banner.jpg'),
(7, '', 'img/default.png', 'img/banner.jpg'),
(8, '', 'img/default.png', 'img/banner.jpg'),
(9, '', 'img/default.png', 'img/banner.jpg'),
(10, '', 'img/default.png', 'img/banner.jpg'),
(11, '', 'img/default.png', 'img/banner.jpg'),
(12, '', 'img/default.png', 'img/banner.jpg'),
(13, '', 'img/default.png', 'img/banner.jpg'),
(14, '', 'img/default.png', 'img/banner.jpg'),
(15, '', 'img/default.png', 'img/banner.jpg'),
(16, '', 'img/default.png', 'img/banner.jpg'),
(17, '', 'img/default.png', 'img/banner.jpg'),
(18, '', 'img/default.png', 'img/banner.jpg'),
(19, '', 'img/default.png', 'img/banner.jpg'),
(20, '', 'img/default.png', 'img/banner.jpg'),
(21, '', 'img/default.png', 'img/banner.jpg'),
(22, '', 'img/default.png', 'img/banner.jpg'),
(23, '', '/backend/img/23_avatar.jpg', '/backend/img/23_banner.jpg'),
(25, '', '/backend/img/25_avatar.jpg', 'img/banner.jpg'),
(26, '', '/backend/img/26_avatar.jpg', 'img/banner.jpg'),
(27, '', 'img/default.png', 'img/banner.jpg'),
(30, '', '/backend/img/30_avatar.jpg', 'img/banner.jpg'),
(31, '', 'img/default.png', 'img/banner.jpg');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`tweet_id`,`content`,`user_id`) USING BTREE;

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
  MODIFY `id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `user_bio`
--
ALTER TABLE `user_bio`
  MODIFY `user_id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
