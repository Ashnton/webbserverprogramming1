-- --------------------------------------------------------
-- Värd:                         127.0.0.1
-- Serverversion:                8.0.30 - MySQL Community Server - GPL
-- Server-OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumpar databasstruktur för antonlm
CREATE DATABASE IF NOT EXISTS `antonlm` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `antonlm`;

-- Dumpar struktur för tabell antonlm.ajax_tabell
CREATE TABLE IF NOT EXISTS `ajax_tabell` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `score` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumpar data för tabell antonlm.ajax_tabell: ~10 rows (ungefär)
INSERT INTO `ajax_tabell` (`id`, `name`, `score`) VALUES
	(1, 'Anton', 100),
	(2, 'Filip', 1000),
	(3, 'Leo', 10),
	(4, 'David', 70),
	(5, 'Noah', 150),
	(6, 'Tobias', 500),
	(7, 'Dexter', 10000),
	(8, 'Niclas', 270),
	(9, 'Tyra', 50),
	(10, 'Viggo', 140);

-- Dumpar struktur för tabell antonlm.car
CREATE TABLE IF NOT EXISTS `car` (
  `carid` int NOT NULL AUTO_INCREMENT,
  `regnr` varchar(255) NOT NULL,
  `color` varchar(255) DEFAULT NULL,
  `garage` int DEFAULT NULL,
  `owner` int DEFAULT NULL,
  PRIMARY KEY (`carid`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumpar data för tabell antonlm.car: ~2 rows (ungefär)
INSERT INTO `car` (`carid`, `regnr`, `color`, `garage`, `owner`) VALUES
	(1, 'Hej123', 'blå', 1, 1),
	(2, 'hej433', 'grön', 2, 3),
	(3, 'hej431', 'röd', 2, 1);

-- Dumpar struktur för tabell antonlm.garage
CREATE TABLE IF NOT EXISTS `garage` (
  `garageid` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`garageid`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumpar data för tabell antonlm.garage: ~2 rows (ungefär)
INSERT INTO `garage` (`garageid`, `name`) VALUES
	(1, 'Filips garage'),
	(2, 'Antons garage');

-- Dumpar struktur för tabell antonlm.min_tabell
CREATE TABLE IF NOT EXISTS `min_tabell` (
  `id` int DEFAULT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumpar data för tabell antonlm.min_tabell: ~0 rows (ungefär)

-- Dumpar struktur för tabell antonlm.min_tabell2
CREATE TABLE IF NOT EXISTS `min_tabell2` (
  `id` int DEFAULT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumpar data för tabell antonlm.min_tabell2: ~0 rows (ungefär)

-- Dumpar struktur för tabell antonlm.owner
CREATE TABLE IF NOT EXISTS `owner` (
  `ownerid` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`ownerid`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumpar data för tabell antonlm.owner: ~3 rows (ungefär)
INSERT INTO `owner` (`ownerid`, `name`) VALUES
	(1, 'Filip'),
	(2, 'Anton'),
	(3, 'Noah');

-- Dumpar struktur för tabell antonlm.slutprojekt_admin_users
CREATE TABLE IF NOT EXISTS `slutprojekt_admin_users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(320) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumpar data för tabell antonlm.slutprojekt_admin_users: ~0 rows (ungefär)

-- Dumpar struktur för tabell antonlm.slutprojekt_hungry_users
CREATE TABLE IF NOT EXISTS `slutprojekt_hungry_users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(320) NOT NULL,
  `phonenumber` varchar(17) NOT NULL,
  `password` varchar(255) NOT NULL,
  `reg_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `latest_login` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `login_token` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumpar data för tabell antonlm.slutprojekt_hungry_users: ~2 rows (ungefär)
INSERT INTO `slutprojekt_hungry_users` (`id`, `email`, `phonenumber`, `password`, `reg_date`, `latest_login`, `login_token`) VALUES
	(3, 'antonlm@varmdogymnasium.se', '0761045862', '$2y$10$jJ6Lcyg09TBwoZpy/B05Q.BxtiURG.5LemRbWuP86uTZAtS6L8dKG', '2025-03-21 10:58:25', '2025-04-25 10:41:19', ''),
	(4, 'noahet@varmdogymnasium.se', '0758384545', '$2y$10$vfff38jArcDyNujIPd6Rx.o1ituMhEWazdo.r0ZnZN7qimikmpVPC', '2025-04-23 15:28:23', '2025-04-23 13:28:23', '838793c1da2e2cc99fbd3190d4d0317039b237c1');

-- Dumpar struktur för tabell antonlm.slutprojekt_menu_items
CREATE TABLE IF NOT EXISTS `slutprojekt_menu_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `restaurant_id` int NOT NULL,
  `item_name` varchar(50) NOT NULL,
  `item_description` text NOT NULL,
  `item_price` decimal(10,2) NOT NULL,
  `item_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `item_image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `restaurant_id` (`restaurant_id`),
  CONSTRAINT `slutprojekt_menu_items_ibfk_1` FOREIGN KEY (`restaurant_id`) REFERENCES `slutprojekt_restaurants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumpar data för tabell antonlm.slutprojekt_menu_items: ~0 rows (ungefär)
INSERT INTO `slutprojekt_menu_items` (`id`, `restaurant_id`, `item_name`, `item_description`, `item_price`, `item_enabled`, `item_image`) VALUES
	(1, 1, 'Bacon och äggpizza', 'Bacon, ägg, ost, tomatsås', 129.00, 1, 'baconagg.png');

-- Dumpar struktur för tabell antonlm.slutprojekt_orders
CREATE TABLE IF NOT EXISTS `slutprojekt_orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `item_id` int NOT NULL,
  `customer_id` int NOT NULL,
  `restaurant_id` int NOT NULL,
  `status` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`),
  KEY `customer_id` (`customer_id`),
  KEY `restaurant_id` (`restaurant_id`),
  CONSTRAINT `slutprojekt_orders_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `slutprojekt_menu_items` (`id`) ON DELETE CASCADE,
  CONSTRAINT `slutprojekt_orders_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `slutprojekt_hungry_users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `slutprojekt_orders_ibfk_3` FOREIGN KEY (`restaurant_id`) REFERENCES `slutprojekt_restaurants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumpar data för tabell antonlm.slutprojekt_orders: ~15 rows (ungefär)
INSERT INTO `slutprojekt_orders` (`id`, `item_id`, `customer_id`, `restaurant_id`, `status`, `price`, `token`, `created_at`) VALUES
	(1, 1, 3, 1, 'Slutförd', 129.00, '80d17a71f9a675e3780aea7d3676d328364f589e', '2025-04-01 14:10:45'),
	(4, 1, 3, 1, 'Order placerad', 129.00, 'e8dee67b492056f38f4b0fb107fa0253b855b04a', '2025-04-01 14:12:02'),
	(6, 1, 3, 1, 'Slutförd', 129.00, '8f85b7dfeb44008a9d5f729c7f0cf5ff2efceb41', '2025-04-01 14:26:03'),
	(7, 1, 3, 1, 'Order placerad', 129.00, 'ff531bb29fb568d359a5010901a6d2228d2a4a7c', '2025-04-01 14:27:20'),
	(8, 1, 3, 1, 'Slutförd', 129.00, 'd105391d858588e1385d72dbda92c57877e564d9', '2025-04-01 14:28:07'),
	(9, 1, 3, 1, 'Tillagas', 129.00, 'bde7d12962faa4246680568c561bd28baa5acbda', '2025-04-01 14:29:54'),
	(10, 1, 3, 1, 'Order placerad', 129.00, 'db7c9bc6b89703d3e35fe8549bd424f0e8af7910', '2025-04-01 14:30:16'),
	(11, 1, 3, 1, 'Order placerad', 129.00, '37cb046c86d3a5226a3970fa75d11b330e50990f', '2025-04-01 14:30:21'),
	(12, 1, 3, 1, 'Order placerad', 129.00, 'cdaed572eb0cdb837a960b585622258bbd8f4850', '2025-04-01 14:30:28'),
	(13, 1, 3, 1, 'Order placerad', 129.00, '82aa2996272c8cd8654c7f34e21c09f2d2ad6664', '2025-04-01 14:30:28'),
	(14, 1, 3, 1, 'Order placerad', 129.00, '9c6e4ad1543e7cb7c972f43055602b5cb642f21a', '2025-04-01 14:30:29'),
	(15, 1, 3, 1, 'Order placerad', 129.00, 'a6a1e8a98252d6e2aea197ae414413e142d76256', '2025-04-01 14:31:11'),
	(16, 1, 3, 1, 'Order placerad', 129.00, 'a0640ddaa8ac2f9737a5b2fdb50cd9293d1b22ed', '2025-04-01 14:32:00'),
	(17, 1, 3, 1, 'Order placerad', 129.00, 'd91a30446b0910d5a3e0339028e1078feb935005', '2025-04-11 10:24:21'),
	(18, 1, 3, 1, 'Order placerad', 129.00, 'ee81541aefe242a308b897071f1cc404bf050ddf', '2025-04-11 10:44:27'),
	(19, 1, 3, 1, 'Tillagas', 129.00, 'a6a1e8a98252d6e2aea197ae414413e142d76256', '2025-04-01 14:31:11'),
	(20, 1, 3, 1, 'Tillagas', 129.00, 'efebdf01d0dd98cbb82a589b164a197f6559fa8f', '2025-04-22 15:19:25'),
	(21, 1, 4, 1, 'Order placerad', 129.00, '47240a63808add43cb1a6d4879da6275bf4ffc39', '2025-04-23 15:30:23'),
	(22, 1, 4, 1, 'Order placerad', 129.00, '86ee577aaf8ecf60feff4e43485932884e13a715', '2025-04-23 15:30:34'),
	(23, 1, 3, 1, 'Order placerad', 129.00, 'e7cb495061403fd36550252b8f1ff2ce60878ce5', '2025-04-25 10:41:35');

-- Dumpar struktur för tabell antonlm.slutprojekt_restaurants
CREATE TABLE IF NOT EXISTS `slutprojekt_restaurants` (
  `id` int NOT NULL AUTO_INCREMENT,
  `restaurant_name` varchar(255) NOT NULL,
  `restaurant_enabled` tinyint(1) NOT NULL,
  `logotype_url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumpar data för tabell antonlm.slutprojekt_restaurants: ~0 rows (ungefär)
INSERT INTO `slutprojekt_restaurants` (`id`, `restaurant_name`, `restaurant_enabled`, `logotype_url`) VALUES
	(1, 'Bamses pizzeria', 1, 'bamses.png');

-- Dumpar struktur för tabell antonlm.slutprojekt_restaurant_users
CREATE TABLE IF NOT EXISTS `slutprojekt_restaurant_users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `restaurant_id` int NOT NULL,
  `email` varchar(320) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `restaurant_id` (`restaurant_id`),
  CONSTRAINT `slutprojekt_restaurant_users_ibfk_1` FOREIGN KEY (`restaurant_id`) REFERENCES `slutprojekt_restaurants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumpar data för tabell antonlm.slutprojekt_restaurant_users: ~2 rows (ungefär)
INSERT INTO `slutprojekt_restaurant_users` (`id`, `restaurant_id`, `email`, `password`) VALUES
	(1, 1, 'bamses@bamses.se', '$2y$10$Rucyq7PJ0KPe9zHGOsZGuuCz3z3UkkTi/xjM2jsK34PltGP0PcAzK'),
	(2, 1, 'bamses@bamses.se', '$2y$10$KyfIlSNsRXu0CYxYOaaRFOow8XekjnFwOUFVfhlFan2rK8mA0Azcm');

-- Dumpar struktur för tabell antonlm.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `date_changed` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumpar data för tabell antonlm.users: ~0 rows (ungefär)
INSERT INTO `users` (`id`, `firstname`, `lastname`, `username`, `password`, `type`, `date_changed`) VALUES
	(1, 'Anton', 'Lidström', 'Anton', '12345678', 'admin', '2024-11-22');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
