-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-06-2024 a las 01:23:04
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `cisnaturatienda`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `address`
--

CREATE TABLE `address` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `fullName` text NOT NULL,
  `telefono` text NOT NULL,
  `colonia` text NOT NULL,
  `calle` text NOT NULL,
  `estado` text NOT NULL,
  `ciudad` text NOT NULL,
  `postalcode` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `api`
--

CREATE TABLE `api` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `value` varchar(150) DEFAULT NULL,
  `date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `api`
--

INSERT INTO `api` (`id`, `name`, `value`, `date`) VALUES
(1, 'api status', 'enabled', '2024-02-22 23:05:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `binnacle`
--

CREATE TABLE `binnacle` (
  `id` int(11) NOT NULL,
  `module` varchar(200) DEFAULT NULL,
  `message` varchar(2500) DEFAULT NULL,
  `type` varchar(200) DEFAULT NULL,
  `_from` varchar(200) DEFAULT NULL,
  `date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `binnacle`
--

INSERT INTO `binnacle` (`id`, `module`, `message`, `type`, `_from`, `date`) VALUES
(225, 'autorization middleware', 'session file not found: c12b2d6b6a81682161255358311f16b7289a83e8', 'premature', 'system', '2024-05-13 16:50:05'),
(226, 'autorization middleware', 'session file not found: 0d36c08efe7b4386a4b320c63fb34629adef3a56', 'premature', 'system', '2024-05-23 21:17:49'),
(227, 'autorization middleware', 'the property User-Agent has been denied, json: d6f479c9bbadc05685c84f6aad166f614bcc8a9c, headers: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:126.0) Gecko/20100101 Firefox/126.0', 'user agent id:76', 'system', '2024-05-23 21:22:51'),
(228, 'autorization middleware', 'the property User-Agent has been denied, json: d6f479c9bbadc05685c84f6aad166f614bcc8a9c, headers: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:126.0) Gecko/20100101 Firefox/126.0', 'user agent id:76', 'system', '2024-05-23 21:22:57'),
(229, 'autorization middleware', 'the property User-Agent has been denied, json: d6f479c9bbadc05685c84f6aad166f614bcc8a9c, headers: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:126.0) Gecko/20100101 Firefox/126.0', 'user agent id:76', 'system', '2024-05-23 21:23:06'),
(230, 'autorization middleware', 'the property User-Agent has been denied, json: 6ef91d87dcddfe07e9ccc270bc06c419ae5f7fb3, headers: Mozilla/5.0 (Linux; Android 11; SAMSUNG SM-G973U) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/14.2 Chrome/87.0.4280.141 Mobile Safari/537.36', 'user agent id:76', 'system', '2024-05-24 20:45:45'),
(231, 'autorization middleware', 'the property User-Agent has been denied, json: 6ef91d87dcddfe07e9ccc270bc06c419ae5f7fb3, headers: Mozilla/5.0 (iPhone; CPU iPhone OS 14_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0.3 Mobile/15E148 Safari/604.1', 'user agent id:76', 'system', '2024-05-24 20:47:52'),
(232, 'autorization middleware', 'the property User-Agent has been denied, json: 6ef91d87dcddfe07e9ccc270bc06c419ae5f7fb3, headers: Mozilla/5.0 (iPhone; CPU iPhone OS 14_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0.3 Mobile/15E148 Safari/604.1', 'user agent id:76', 'system', '2024-05-24 20:47:52'),
(233, 'autorization middleware', 'the property User-Agent has been denied, json: 6ef91d87dcddfe07e9ccc270bc06c419ae5f7fb3, headers: Mozilla/5.0 (iPhone; CPU iPhone OS 14_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0.3 Mobile/15E148 Safari/604.1', 'user agent id:76', 'system', '2024-05-24 20:47:54'),
(234, 'autorization middleware', 'the property User-Agent has been denied, json: 6ef91d87dcddfe07e9ccc270bc06c419ae5f7fb3, headers: Mozilla/5.0 (iPhone; CPU iPhone OS 14_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0.3 Mobile/15E148 Safari/604.1', 'user agent id:76', 'system', '2024-05-24 20:47:54'),
(235, 'autorization middleware', 'the property User-Agent has been denied, json: 6ef91d87dcddfe07e9ccc270bc06c419ae5f7fb3, headers: Mozilla/5.0 (iPhone; CPU iPhone OS 14_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0.3 Mobile/15E148 Safari/604.1', 'user agent id:76', 'system', '2024-05-24 20:48:03'),
(236, 'autorization middleware', 'the property User-Agent has been denied, json: 6ef91d87dcddfe07e9ccc270bc06c419ae5f7fb3, headers: Mozilla/5.0 (iPhone; CPU iPhone OS 14_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0.3 Mobile/15E148 Safari/604.1', 'user agent id:76', 'system', '2024-05-24 20:48:03'),
(237, 'autorization middleware', 'session file not found: 6ef91d87dcddfe07e9ccc270bc06c419ae5f7fb3', 'premature', 'system', '2024-05-24 20:48:04'),
(238, 'autorization middleware', 'the property User-Agent has been denied, json: 6ef91d87dcddfe07e9ccc270bc06c419ae5f7fb3, headers: Mozilla/5.0 (iPhone; CPU iPhone OS 14_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0.3 Mobile/15E148 Safari/604.1', 'user agent id:76', 'system', '2024-05-24 20:48:14'),
(239, 'autorization middleware', 'the property User-Agent has been denied, json: 6ef91d87dcddfe07e9ccc270bc06c419ae5f7fb3, headers: Mozilla/5.0 (iPhone; CPU iPhone OS 14_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0.3 Mobile/15E148 Safari/604.1', 'user agent id:76', 'system', '2024-05-24 20:48:14'),
(240, 'autorization middleware', 'the property User-Agent has been denied, json: 6ef91d87dcddfe07e9ccc270bc06c419ae5f7fb3, headers: Mozilla/5.0 (iPhone; CPU iPhone OS 14_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0.3 Mobile/15E148 Safari/604.1', 'user agent id:76', 'system', '2024-05-24 20:50:13'),
(241, 'autorization middleware', 'the property User-Agent has been denied, json: 6ef91d87dcddfe07e9ccc270bc06c419ae5f7fb3, headers: Mozilla/5.0 (iPhone; CPU iPhone OS 14_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0.3 Mobile/15E148 Safari/604.1', 'user agent id:76', 'system', '2024-05-24 20:50:13'),
(242, 'autorization middleware', 'the property User-Agent has been denied, json: 6ef91d87dcddfe07e9ccc270bc06c419ae5f7fb3, headers: Mozilla/5.0 (iPhone; CPU iPhone OS 14_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0.3 Mobile/15E148 Safari/604.1', 'user agent id:76', 'system', '2024-05-24 20:50:15'),
(243, 'autorization middleware', 'the property User-Agent has been denied, json: 6ef91d87dcddfe07e9ccc270bc06c419ae5f7fb3, headers: Mozilla/5.0 (iPhone; CPU iPhone OS 14_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0.3 Mobile/15E148 Safari/604.1', 'user agent id:76', 'system', '2024-05-24 20:50:15'),
(244, 'autorization middleware', 'the property User-Agent has been denied, json: 6ef91d87dcddfe07e9ccc270bc06c419ae5f7fb3, headers: Mozilla/5.0 (iPhone; CPU iPhone OS 14_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0.3 Mobile/15E148 Safari/604.1', 'user agent id:76', 'system', '2024-05-24 20:50:15'),
(245, 'autorization middleware', 'the property User-Agent has been denied, json: 6ef91d87dcddfe07e9ccc270bc06c419ae5f7fb3, headers: Mozilla/5.0 (iPhone; CPU iPhone OS 14_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0.3 Mobile/15E148 Safari/604.1', 'user agent id:76', 'system', '2024-05-24 20:50:15'),
(246, 'autorization middleware', 'the property User-Agent has been denied, json: 6ef91d87dcddfe07e9ccc270bc06c419ae5f7fb3, headers: Mozilla/5.0 (iPhone; CPU iPhone OS 14_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0.3 Mobile/15E148 Safari/604.1', 'user agent id:76', 'system', '2024-05-24 20:50:15'),
(247, 'autorization middleware', 'the property User-Agent has been denied, json: 6ef91d87dcddfe07e9ccc270bc06c419ae5f7fb3, headers: Mozilla/5.0 (iPhone; CPU iPhone OS 14_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0.3 Mobile/15E148 Safari/604.1', 'user agent id:76', 'system', '2024-05-24 20:50:15'),
(248, 'autorization middleware', 'the property User-Agent has been denied, json: 6ef91d87dcddfe07e9ccc270bc06c419ae5f7fb3, headers: Mozilla/5.0 (iPhone; CPU iPhone OS 14_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0.3 Mobile/15E148 Safari/604.1', 'user agent id:76', 'system', '2024-05-24 20:50:15'),
(249, 'autorization middleware', 'the property User-Agent has been denied, json: 6ef91d87dcddfe07e9ccc270bc06c419ae5f7fb3, headers: Mozilla/5.0 (iPhone; CPU iPhone OS 14_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0.3 Mobile/15E148 Safari/604.1', 'user agent id:76', 'system', '2024-05-24 20:50:15'),
(250, 'autorization middleware', 'the property User-Agent has been denied, json: 6ef91d87dcddfe07e9ccc270bc06c419ae5f7fb3, headers: Mozilla/5.0 (iPhone; CPU iPhone OS 14_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0.3 Mobile/15E148 Safari/604.1', 'user agent id:76', 'system', '2024-05-24 20:50:16'),
(251, 'autorization middleware', 'the property User-Agent has been denied, json: 6ef91d87dcddfe07e9ccc270bc06c419ae5f7fb3, headers: Mozilla/5.0 (iPhone; CPU iPhone OS 14_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0.3 Mobile/15E148 Safari/604.1', 'user agent id:76', 'system', '2024-05-24 20:50:16'),
(252, 'autorization middleware', 'the property User-Agent has been denied, json: 6ef91d87dcddfe07e9ccc270bc06c419ae5f7fb3, headers: Mozilla/5.0 (iPhone; CPU iPhone OS 14_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0.3 Mobile/15E148 Safari/604.1', 'user agent id:76', 'system', '2024-05-24 20:50:16'),
(253, 'autorization middleware', 'the property User-Agent has been denied, json: 6ef91d87dcddfe07e9ccc270bc06c419ae5f7fb3, headers: Mozilla/5.0 (iPhone; CPU iPhone OS 14_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0.3 Mobile/15E148 Safari/604.1', 'user agent id:76', 'system', '2024-05-24 20:50:16'),
(254, 'autorization middleware', 'the property User-Agent has been denied, json: 6ef91d87dcddfe07e9ccc270bc06c419ae5f7fb3, headers: Mozilla/5.0 (iPhone; CPU iPhone OS 14_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0.3 Mobile/15E148 Safari/604.1', 'user agent id:76', 'system', '2024-05-24 20:50:30'),
(255, 'autorization middleware', 'the property User-Agent has been denied, json: 6ef91d87dcddfe07e9ccc270bc06c419ae5f7fb3, headers: Mozilla/5.0 (iPhone; CPU iPhone OS 14_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0.3 Mobile/15E148 Safari/604.1', 'user agent id:76', 'system', '2024-05-24 20:50:30'),
(256, 'autorization middleware', 'session file not found: 8891639c2a8e9e4b77e5f6e9971249c92428749d', 'premature', 'system', '2024-06-03 16:16:44'),
(257, 'autorization middleware', 'session file not found: 8891639c2a8e9e4b77e5f6e9971249c92428749d', 'premature', 'system', '2024-06-03 16:16:44'),
(258, 'autorization middleware', 'session file not found: 8891639c2a8e9e4b77e5f6e9971249c92428749d', 'premature', 'system', '2024-06-03 16:16:45');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito`
--

CREATE TABLE `carrito` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `productId` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `carrito`
--

INSERT INTO `carrito` (`id`, `userId`, `productId`, `cantidad`, `created_at`, `updated_at`) VALUES
(405, 76, 33, 3, '2024-05-25 02:17:24', '2024-05-25 02:17:24'),
(406, 76, 34, 4, '2024-05-25 02:17:29', '2024-05-25 02:17:29'),
(407, 76, 35, 2, '2024-05-25 03:28:29', '2024-05-25 03:28:29'),
(408, 76, 37, 1, '2024-06-03 22:13:41', '2024-06-03 22:13:41'),
(409, 76, 36, 1, '2024-06-03 22:13:42', '2024-06-03 22:13:42');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `payment`
--

CREATE TABLE `payment` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `customer_name` varchar(50) NOT NULL,
  `customer_email` varchar(50) DEFAULT NULL,
  `item_desc` text NOT NULL,
  `subtotal` float NOT NULL,
  `envio` float NOT NULL,
  `paid_amount` float NOT NULL,
  `payment_status` varchar(25) NOT NULL,
  `address_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `privileges`
--

CREATE TABLE `privileges` (
  `id` int(11) NOT NULL,
  `route` varchar(100) NOT NULL,
  `access` int(11) NOT NULL DEFAULT 1,
  `user_type` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `privileges`
--

INSERT INTO `privileges` (`id`, `route`, `access`, `user_type`) VALUES
(1, '/cisnaturatienda/app/services/routes/home.route.php?_lp', 1, 2),
(2, '/cisnaturatienda/resources/views/catalogo.php', 1, 2),
(4, '/cisnaturatienda/app/services/routes/catalogo.route.php?_tp=todo', 1, 2),
(6, '/cisnaturatienda/app/services/routes/catalogo.route.php?_ap&', 1, 2),
(8, '/cisnaturatienda/app/services/routes/catalogo.route.php?_np', 1, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `thumb` text NOT NULL,
  `price` varchar(10) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  `deleted` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `products`
--

INSERT INTO `products` (`id`, `type`, `product_name`, `description`, `thumb`, `price`, `active`, `created_at`, `updated_at`, `deleted`) VALUES
(33, 'tintura', 'Tintura de Yumel', 'Tintura para nadota', 'TINTURA DE YUMEL.jpeg', '500', 1, '2023-07-17 22:10:39', NULL, 0),
(34, 'tintura', 'Tintura de Boldo', 'Tintura de Boldo', 'BOPLDUS.jpeg', '90', 1, '2023-07-17 22:33:44', NULL, 0),
(35, 'tintura', 'Albicans', 'Tintura de Albicans', 'ALBICANS.jpeg', '90', 1, '2023-07-17 22:34:17', NULL, 0),
(36, 'tintura', 'Tintura de Castella', 'Maecenas ultrices vestibulum ullamcorper. Pellentesque vitae ullamcorper dui. Vivamus id felis non eros dignissim commodo. Donec placerat maximus pharetra. Praesent eget tincidunt arcu, vitae laoreet purus. Nullam auctor pellentesque commodo. Maecenas semper libero pulvinar, tempor elit vitae, viverra quam. Vestibulum purus ex, varius at metus nec, congue gravida turpis. Praesent pulvinar auctor odio a lobortis. ', 'CASTELLA.jpeg', '95', 1, '2023-07-17 22:34:33', NULL, 0),
(37, 'tintura', 'Tintura de Camellia', '0.-Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur porta bibendum diam, a efficitur nunc tincidunt vitae. Fusce congue hendrerit suscipit. &#13;&#10;&#13;&#10;1.-Aenean commodo eros non metus scelerisque hendrerit eget id ligula. Pellentesque cursus ullamcorper est sit amet cursus. Aliquam pellentesque risus dui, at elementum sapien vestibulum mattis. &#13;&#10;&#13;&#10;2.-Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus feugiat ligula et semper ullamcorper. ', 'CAMELLIA.jpeg', '90', 1, '2023-07-17 22:34:55', NULL, 0),
(41, 'tintura', 'Tintura de Blanco', 'Esa una tintura de Blanco que sirve para muchas otras cosas', 'TINTURA DE BLANCO.jpeg', '95', 1, '2023-07-20 04:40:54', NULL, 0),
(42, 'cds', 'CDS', 'Hola mas', 'PhotoRoom-20230711_142915.png', '200', 1, '2023-08-01 01:50:48', NULL, 0),
(45, 'tintura', 'Oppuntia', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse at condimentum metus, eget faucibus tortor. Nunc dui lorem, ullamcorper sit amet nulla et, sagittis dapibus neque. Pellentesque scelerisque elit in leo placerat, nec facilisis ligula sagittis. Nunc sit amet lorem vitae erat gravida volutpat.', 'OPUNTIA.jpeg', '80', 1, '2023-09-02 20:04:07', NULL, 0),
(46, 'tintura', 'Meyenii', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse at condimentum metus, eget faucibus tortor. Nunc dui lorem, ullamcorper sit amet nulla et, sagittis dapibus neque. Pellentesque scelerisque elit in leo placerat, nec facilisis ligula sagittis. Nunc sit amet lorem vitae erat gravida volutpat.', 'MEYENII.jpeg', '95', 1, '2023-09-02 20:04:49', NULL, 0),
(47, 'cds', 'Duo Citrico', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse at condimentum metus, eget faucibus tortor. Nunc dui lorem, ullamcorper sit amet nulla et, sagittis dapibus neque. Pellentesque scelerisque elit in leo placerat, nec facilisis ligula sagittis. Nunc sit amet lorem vitae erat gravida volutpat.', 'DUO CITRICO.jpeg', '250', 1, '2023-09-02 20:05:24', NULL, 0),
(48, 'cds', 'Dmso', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse at condimentum metus, eget faucibus tortor. Nunc dui lorem, ullamcorper sit amet nulla et, sagittis dapibus neque. Pellentesque scelerisque elit in leo placerat, nec facilisis ligula sagittis. Nunc sit amet lorem vitae erat gravida volutpat.', 'CDS Y DMSO OCULAR.jpeg', '200', 1, '2023-09-02 20:05:49', NULL, 0),
(49, 'cds', 'Dioxido de Cloro', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse at condimentum metus, eget faucibus tortor. Nunc dui lorem, ullamcorper sit amet nulla et, sagittis dapibus neque. Pellentesque scelerisque elit in leo placerat, nec facilisis ligula sagittis. Nunc sit amet lorem vitae erat gravida volutpat.', '7242a3fb-c59e-4fee-aebd-41b207b87e54.jpg', '190', 1, '2023-09-02 20:06:07', NULL, 0),
(50, 'otro', 'Agua de ', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse at condimentum metus, eget faucibus tortor. Nunc dui lorem, ullamcorper sit amet nulla et, sagittis dapibus neque. Pellentesque scelerisque elit in leo placerat, nec facilisis ligula sagittis. Nunc sit amet lorem vitae erat gravida volutpat.', 'AGUA DE MAR HIPERTONICA.jpeg', '140', 1, '2023-09-02 20:06:48', NULL, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product_order`
--

CREATE TABLE `product_order` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `productsData` text NOT NULL,
  `subtotal` float NOT NULL,
  `envio` float NOT NULL,
  `total` float NOT NULL,
  `order_status` varchar(25) NOT NULL DEFAULT 'incomplete',
  `address_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sessions`
--

CREATE TABLE `sessions` (
  `_id` int(11) NOT NULL,
  `user` int(11) DEFAULT NULL,
  `json` varchar(500) DEFAULT NULL,
  `date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `passwd` varchar(100) NOT NULL,
  `tipo` tinyint(4) NOT NULL DEFAULT 2,
  `active` tinyint(4) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `passwd`, `tipo`, `active`, `created_at`) VALUES
(66, 'Manuel', 'manuel@gmail.com', '$2y$10$zuB0i4rsmNCXrwrIfJ1gkuU7sS5MtEkZ63FJqO/Qnl4fkX/7Fx7ne', 2, 1, '2024-02-15 03:13:22'),
(76, 'Miguel Agustin', 'malejandre@ucol.mx', '$2y$10$Rz7CIqQfcbCjQujfIEv/COBPz7L4eg44gX2jVY8SIs6ZkOyr660CW', 2, 1, '2024-02-24 21:37:24'),
(77, 'Sofia', 'sofiageovana@gmail.com', '$2y$10$uXrym6IrTYhq3fNPiGIJhOkmYlsLUX6jwyGebUtxC/4CCqISQJpE6', 1, 1, '2024-03-09 22:16:16');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_user_id` (`userId`);

--
-- Indices de la tabla `api`
--
ALTER TABLE `api`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `binnacle`
--
ALTER TABLE `binnacle`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_carrito_user` (`userId`),
  ADD KEY `fk_carrito_product` (`productId`);

--
-- Indices de la tabla `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userId` (`userId`),
  ADD KEY `fk_address_id` (`address_id`);

--
-- Indices de la tabla `privileges`
--
ALTER TABLE `privileges`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `product_order`
--
ALTER TABLE `product_order`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`_id`),
  ADD KEY `user` (`user`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `address`
--
ALTER TABLE `address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `binnacle`
--
ALTER TABLE `binnacle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=259;

--
-- AUTO_INCREMENT de la tabla `carrito`
--
ALTER TABLE `carrito`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=410;

--
-- AUTO_INCREMENT de la tabla `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT de la tabla `privileges`
--
ALTER TABLE `privileges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT de la tabla `product_order`
--
ALTER TABLE `product_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT de la tabla `sessions`
--
ALTER TABLE `sessions`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `FK_user_id` FOREIGN KEY (`userId`) REFERENCES `user` (`id`);

--
-- Filtros para la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD CONSTRAINT `fk_carrito_product` FOREIGN KEY (`productId`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `fk_carrito_user` FOREIGN KEY (`userId`) REFERENCES `user` (`id`);

--
-- Filtros para la tabla `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `fk_address_id` FOREIGN KEY (`address_id`) REFERENCES `address` (`id`),
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`id`);

--
-- Filtros para la tabla `sessions`
--
ALTER TABLE `sessions`
  ADD CONSTRAINT `ssd_user_id` FOREIGN KEY (`user`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
