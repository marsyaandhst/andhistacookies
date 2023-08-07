


CREATE DATABASE IF NOT EXISTS `cookie`;
USE `cookie`;


CREATE TABLE IF NOT EXISTS `carts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT '0000-00-00 00:00:00',
  `updated_at` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4;


INSERT INTO `carts` (`id`, `user_id`, `created_at`, `updated_at`) VALUES
	(12, 6, '2023-07-23 16:24:48', '2023-07-23 16:24:48');


CREATE TABLE IF NOT EXISTS `cart_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cart_id` int NOT NULL,
  `product_id` int DEFAULT NULL,
  `quantity` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 ;


INSERT INTO `cart_items` (`id`, `cart_id`, `product_id`, `quantity`, `created_at`, `updated_at`) VALUES
	(45, 12, 1, 2, '2023-07-23 16:24:48', '2023-07-23 16:24:48');


CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;


INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_resets_table', 1),
	(3, '2019_08_19_000000_create_failed_jobs_table', 1),
	(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(5, '2023_07_06_040553_create_products_table', 1),
	(6, '2023_07_06_140020_create_orders_table', 2),
	(7, '2023_07_06_140518_create_orders_table', 3);

CREATE TABLE IF NOT EXISTS `orders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_user` bigint unsigned NOT NULL,
  `namapenerima` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nohp` varchar(14) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `namakue` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `totalitem` int NOT NULL,
  `totalharga` int NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `buktipembayaran` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status_pembayaran` enum('Menunggu Pembayaran','Pembayaran Diterima','Pembayaran Ditolak') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Menunggu Pembayaran',
  PRIMARY KEY (`id`),
  KEY `id_user` (`id_user`),
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4;


INSERT INTO `orders` (`id`, `id_user`, `namapenerima`, `nohp`, `namakue`, `totalitem`, `totalharga`, `alamat`, `buktipembayaran`, `created_at`, `updated_at`, `status_pembayaran`) VALUES
	(28, 6, 'test', '082114701347', 'Kue Sagu Keju', 1, 65000, 'gtefefefe', 'test.jpg', NULL, NULL, 'Menunggu Pembayaran');


CREATE TABLE IF NOT EXISTS `order_details` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int DEFAULT NULL,
  `product_id` bigint unsigned DEFAULT NULL,
  `qty` int unsigned DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_order_details_products` (`product_id`),
  KEY `FK_order_details_order_headers` (`order_id`),
  CONSTRAINT `FK_order_details_order_headers` FOREIGN KEY (`order_id`) REFERENCES `order_headers` (`id`),
  CONSTRAINT `FK_order_details_products` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 ;


INSERT INTO `order_details` (`id`, `order_id`, `product_id`, `qty`, `created_at`, `updated_at`) VALUES
	(1, 11, 4, 5, '2023-07-23 16:05:16', '2023-07-23 16:05:16'),
	(2, 11, 3, 3, '2023-07-23 16:05:16', '2023-07-23 16:05:16'),
	(3, 11, 2, 2, '2023-07-23 16:05:16', '2023-07-23 16:05:16'),
	(4, 12, 2, 3, '2023-07-23 16:11:53', '2023-07-23 16:11:53'),
	(5, 13, 2, 4, '2023-07-23 16:13:38', '2023-07-23 16:13:38'),
	(6, 14, 4, 4, '2023-07-23 16:15:40', '2023-07-23 16:15:40'),
	(7, 15, 1, 10, '2023-07-23 16:16:12', '2023-07-23 16:16:12'),
	(8, 16, 1, 5, '2023-07-23 16:19:27', '2023-07-23 16:19:27'),
	(9, 17, 4, 2, '2023-07-23 16:21:03', '2023-07-23 16:21:03'),
	(10, 18, 4, 10, '2023-07-23 16:22:36', '2023-07-23 16:22:36');


CREATE TABLE IF NOT EXISTS `order_headers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_user` bigint unsigned NOT NULL,
  `invoice_no` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `namapenerima` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `nohp` varchar(14) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `totalharga` double NOT NULL,
  `alamat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `buktipembayaran` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `tanggalpembelian` datetime NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status_pembayaran` enum('Menunggu Pembayaran','Pembayaran Diterima','Pembayaran Ditolak') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'Menunggu Pembayaran',
  PRIMARY KEY (`id`),
  KEY `FK_order_headers_users` (`id_user`),
  CONSTRAINT `FK_order_headers_users` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4;


INSERT INTO `order_headers` (`id`, `id_user`, `invoice_no`, `namapenerima`, `nohp`, `totalharga`, `alamat`, `buktipembayaran`, `tanggalpembelian`, `created_at`, `updated_at`, `status_pembayaran`) VALUES
	(11, 6, 'INV-20230723160516-8608', 'test', '082114701347', 505000, 'test', 'test.jpg', '2023-07-23 16:05:16', '2023-07-23 16:05:16', '2023-07-23 16:05:16', 'Menunggu Pembayaran'),
	(12, 6, 'INV-20230723161153-4078', 'test', '082114701347', 195000, 'test', 'test.jpg', '2023-07-23 16:11:53', '2023-07-23 16:11:53', '2023-07-23 16:11:53', 'Menunggu Pembayaran'),
	(13, 6, 'INV-20230723161338-5163', 'test', '08211401237', 260000, 'teasda', 'test.jpg', '2023-07-23 16:13:38', '2023-07-23 16:13:38', '2023-07-23 16:13:38', 'Menunggu Pembayaran'),
	(14, 6, 'INV-20230723161540-4726', 'test', '082114701236', 180000, 'test', 'test.jpg', '2023-07-23 16:15:40', '2023-07-23 16:15:40', '2023-07-23 16:15:40', 'Menunggu Pembayaran'),
	(15, 6, 'INV-20230723161612-8421', 'test', '082114701236', 650000, 'test', 'test.jpg', '2023-07-23 16:16:12', '2023-07-23 16:16:12', '2023-07-23 16:16:12', 'Menunggu Pembayaran'),
	(16, 6, 'INV-20230723161927-6781', 'test', '082114701347', 325000, 'test', 'test.jpg', '2023-07-23 16:19:27', '2023-07-23 16:19:27', '2023-07-23 16:19:27', 'Menunggu Pembayaran'),
	(17, 6, 'INV-20230723162103-6511', 'tsest', '082114701347', 90000, 'test', 'tsest.jpg', '2023-07-23 16:21:03', '2023-07-23 16:21:03', '2023-07-23 16:21:03', 'Menunggu Pembayaran'),
	(18, 6, 'INV-20230723162236-1681', 'test', '082114701347', 450000, 'test', 'test.jpg', '2023-07-23 16:22:36', '2023-07-23 16:22:36', '2023-07-23 16:22:36', 'Menunggu Pembayaran');


CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE IF NOT EXISTS `products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `no` int NOT NULL,
  `namakue` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga` int NOT NULL,
  `stock` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4;


INSERT INTO `products` (`id`, `no`, `namakue`, `photo`, `deskripsi`, `harga`, `stock`, `created_at`, `updated_at`) VALUES
	(1, 1, 'Kue Nastar', 'kue 1.jpg', 'Nikmati kelezatan istimewa dalam setiap gigitan dengan nastar kami yang luar biasa! Dibuat dengan cinta dan keahlian, nastar kami adalah perpaduan sempurna antara kelembutan kue klasik nan lezat dengan isi nanas manis yang meleleh di mulut. Setiap butiran kecil dipenuhi dengan rasa autentik yang memikat dan aroma yang menggoda selera. Dengan tampilan yang menggoda mata dan cita rasa yang tak terlupakan, nastar kami adalah sajian sempurna untuk menyempurnakan momen istimewa dan menyenangkan lidah setiap penggemar manis. Segera rasakan keajaiban rasa dalam setiap gigitan nastar kami dan biarkan diri Anda terbuai dalam kenikmatan tak tergantikan ini!', 65000, 1235, NULL, '2023-07-23 09:19:27'),
	(2, 2, 'Kue Sagu Keju', 'kue 2.jpg', 'Rasakan kenikmatan yang tak tergantikan dengan kue sagu kami yang luar biasa! Dibuat dengan hati-hati dan menggunakan resep turun-temurun, kue sagu kami memiliki kelembutan yang menggoda dan kelezatan yang tak tertandingi. Dengan tekstur lembut dan lezat yang hampir mencair di mulut, setiap gigitan kue sagu kami memanjakan lidah dengan rasa manis yang khas dan aroma yang menggugah selera. Dipadukan dengan sentuhan klasik, kue sagu kami adalah hidangan yang sempurna untuk menikmati bersama teh atau kopi di tengah suasana santai atau saat bersama orang-orang tercinta. Biarkan kue sagu kami menghantarkan Anda dalam perjalanan rasa yang memukau dan memberikan kepuasan tak terlupakan. Segera nikmati kelezatan yang autentik dan nikmati sensasi kue sagu kami yang mewah!', 65000, 1000, NULL, '2023-07-23 09:13:38'),
	(3, 3, 'Choco Cips', 'Choco Cips.jpg', 'Jelajahi dunia rasa yang menggoda dengan choco chips kami yang luar biasa! Dengan setiap gigitan, Anda akan menemukan kombinasi sempurna antara kelembutan kue dengan kenikmatan lumeran cokelat. Choco chips kami dibuat dengan hati-hati menggunakan bahan-bahan pilihan, dan setiap cips cokelatnya menawarkan aroma kaya dan lezat yang memikat. Nikmati kelezatan mewah ini dalam setiap gigitan dengan cokelat yang meleleh di mulut dan rasa manis yang memanjakan lidah. Tampilan menggoda choco chips kami juga menambahkan sentuhan istimewa, menjadikannya pilihan sempurna untuk dinikmati sendiri atau dibagikan dengan orang terkasih. Segera rasakan kenikmatan indulgent ini dan biarkan choco chips kami memanjakan Anda dengan cita rasa cokelat yang tak terlupakan!', 50000, 534, NULL, '2023-07-23 09:05:16'),
	(4, 4, 'Kue Kacang Tanah', 'Kue Kacang Tanah.jpg', 'Nikmati kelezatan yang renyah dan lezat dengan kue kacang tanah kami yang luar biasa! Dibuat dengan keahlian dan bahan-bahan pilihan, setiap gigitan kue kacang tanah kami mempersembahkan perpaduan sempurna antara kelembutan kue dan kelezatan kacang tanah yang kaya akan rasa dan tekstur. Rasakan kegurihan kacang tanah yang digiling halus dan tercampur merata dalam adonan yang lembut, menciptakan cita rasa yang autentik dan menggugah selera. Dengan tampilan yang mengundang dan aroma yang menggoda, kue kacang tanah kami menjadi hidangan yang sempurna untuk menemani secangkir teh atau kopi di waktu santai. Segera nikmati sensasi kue kacang tanah yang memanjakan lidah dan biarkan diri Anda terpesona oleh kenikmatan yang tak terlupakan ini!', 45000, 235, NULL, '2023-07-23 09:22:36');


CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;


INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
	(6, 'admin', 'admin@gmail.com', NULL, '$2y$10$VF9L3u8Y7xGipl6a2.7MOeqS9ilTIdujNV2QMxksmnZlIhE.1Xnmy', 0, NULL, '2023-07-19 10:31:38', '2023-07-19 10:31:38');


