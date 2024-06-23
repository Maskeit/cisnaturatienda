-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:8889
-- Tiempo de generación: 22-06-2024 a las 03:50:32
-- Versión del servidor: 5.7.39
-- Versión de PHP: 8.2.0

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `api`
--

CREATE TABLE `api` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `value` varchar(150) DEFAULT NULL,
  `date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `binnacle`
--

INSERT INTO `binnacle` (`id`, `module`, `message`, `type`, `_from`, `date`) VALUES
(557, 'autorization middleware', 'Urgent request denied, this user doesn´t have permissions to execute the next request: /cisnaturatienda/app/services/routes/home.route.php?_lp', 'URGENT id: 82', 'system', '2024-06-21 20:31:16');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito`
--

CREATE TABLE `carrito` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `productId` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `privileges`
--

CREATE TABLE `privileges` (
  `id` int(11) NOT NULL,
  `route` varchar(100) NOT NULL,
  `access` int(11) NOT NULL DEFAULT '1',
  `user_type` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `privileges`
--

INSERT INTO `privileges` (`id`, `route`, `access`, `user_type`) VALUES
(1, '/cisnaturatienda/app/services/routes/home.route.php?_lp', 1, 2),
(4, '/cisnaturatienda/app/services/routes/catalogo.route.php?_tp', 1, 2),
(6, '/cisnaturatienda/app/services/routes/catalogo.route.php', 1, 2),
(8, '/cisnaturatienda/app/services/routes/catalogo.route.php?_np', 1, 2),
(9, '/cisnaturatienda/app/services/routes/carrito.route.php?_tc', 1, 2),
(10, '/cisnaturatienda/app/services/routes/carrito.route.php', 1, 2),
(11, '/cisnaturatienda/app/services/routes/catalogo.route.php?_ap', 1, 2),
(12, '/cisnaturatienda/app/services/routes/home.route.php?_ap', 1, 2),
(13, '/cisnaturatienda/app/services/routes/main.route.php?_aname', 1, 2),
(16, '/cisnaturatienda/app/services/routes/main.route.php?_closeSession', 1, 2),
(17, '/cisnaturatienda/app/services/routes/ad.route.php?_posts', 1, 1),
(19, '/cisnaturatienda/app/services/routes/mainAdmin.route.php?_closeSession', 1, 1),
(20, '/cisnaturatienda/app/services/routes/mainAdmin.route.php?_aname', 1, 1),
(21, '/cisnaturatienda/app/services/routes/ad.route.php?_editproduct', 1, 1),
(22, '/cisnaturatienda/app/services/routes/ad.route.php?_dp', 1, 1),
(23, '/cisnaturatienda/app/services/routes/ad.route.php', 1, 1),
(24, '/cisnaturatienda/app/services/routes/create.route.php?_create', 1, 1);

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
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted` tinyint(4) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sessions`
--

CREATE TABLE `sessions` (
  `id` int(11) NOT NULL,
  `user` int(11) DEFAULT NULL,
  `json` varchar(500) DEFAULT NULL,
  `date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `sessions`
--

INSERT INTO `sessions` (`id`, `user`, `json`, `date`) VALUES
(215, 82, '9e6784dda9eeae5d53b54f5b7baa40cccdb30173.json', '2024-06-21 19:21:34'),
(216, 76, '44d6f190d264a7f2eb6bdd88d62ecd3042b3bae5.json', '2024-06-21 19:30:53'),
(217, 82, '5a9c13c92f7b05a51dfde84b3edb6a151bae1769.json', '2024-06-21 19:32:11'),
(218, 76, 'e7d234636958a40723a572c7dc23de8e37349599.json', '2024-06-21 19:43:19'),
(219, 82, '6824c653335933c8860aab0e7595f9740864c18c.json', '2024-06-21 20:31:46'),
(220, 82, 'dc92451c9a9840ce410db17df9b6c7d24d37b6e1.json', '2024-06-21 20:42:37');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `passwd` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `tipo` tinyint(4) NOT NULL DEFAULT '2',
  `active` tinyint(4) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `passwd`, `tipo`, `active`, `created_at`) VALUES
(76, 'Miguel Agustin', 'malejandre@ucol.mx', '$2y$10$Rz7CIqQfcbCjQujfIEv/COBPz7L4eg44gX2jVY8SIs6ZkOyr660CW', 2, 1, '2024-02-24 21:37:24'),
(82, 'Sofia', 'sofiageovana@gmail.com', '$2y$10$XZXQ9xVIrWXDqogZjCAVJOtYTQrEZUghkjVAESoXPOlS8CgiPJsaS', 1, 1, '2024-06-15 22:38:53'),
(83, 'Miguel', 'miguelagustin182@gmail.com', '$2y$10$xYW.1c1eUfWXPXeqQ3Au6ullQe9Y10ZJDBEzXDPF2U5/N/I4FwrVy', 1, 1, '2024-06-17 00:57:48');

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
  ADD PRIMARY KEY (`id`),
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=558;

--
-- AUTO_INCREMENT de la tabla `carrito`
--
ALTER TABLE `carrito`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=533;

--
-- AUTO_INCREMENT de la tabla `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT de la tabla `privileges`
--
ALTER TABLE `privileges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=221;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

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
