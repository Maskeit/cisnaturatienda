-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-06-2024 a las 21:11:58
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
(23, '/cisnaturatienda/app/services/routes/ad.route.php?_dp', 1, 1),
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
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  `deleted` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `products`
--

INSERT INTO `products` (`id`, `type`, `product_name`, `description`, `thumb`, `price`, `active`, `created_at`, `updated_at`, `deleted`) VALUES
(89, 'tintura', 'Yumel', '<p>Tintura de yumel</p>', 'TINTURA DE YUMEL.jpeg', '100', 1, '2024-06-27 03:18:14', '2024-06-27 03:18:14', 0),
(90, 'cds', 'Dioxido de cloro', '<p>Dioxido de cloro</p>', '7242a3fb-c59e-4fee-aebd-41b207b87e54.jpg', '200', 1, '2024-06-27 03:19:19', '2024-06-27 03:19:19', 0);

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
  `id` int(11) NOT NULL,
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
(76, 'Miguel Agustin', 'malejandre@ucol.mx', '$2y$10$Rz7CIqQfcbCjQujfIEv/COBPz7L4eg44gX2jVY8SIs6ZkOyr660CW', 2, 1, '2024-02-24 21:37:24'),
(82, 'Sofia', 'sofiageovana@gmail.com', '$2y$10$XZXQ9xVIrWXDqogZjCAVJOtYTQrEZUghkjVAESoXPOlS8CgiPJsaS', 1, 1, '2024-06-15 22:38:53'),
(83, 'Miguel', 'miguelagustin182@gmail.com', '$2y$10$xYW.1c1eUfWXPXeqQ3Au6ullQe9Y10ZJDBEzXDPF2U5/N/I4FwrVy', 1, 1, '2024-06-17 00:57:48'),
(84, 'Agustin', 'agustin@gmail.com', '$2y$10$A3uIStCzLMrLygvHkvN25O4yIdLHWP3s/QfqKM5Q.fB38l.dVV.IS', 2, 1, '2024-06-24 00:20:32');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=570;

--
-- AUTO_INCREMENT de la tabla `carrito`
--
ALTER TABLE `carrito`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=534;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT de la tabla `product_order`
--
ALTER TABLE `product_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT de la tabla `sessions`
--
ALTER TABLE `sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=242;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

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
