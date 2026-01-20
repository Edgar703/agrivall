-- MySQL dump 10.13  Distrib 8.4.7, for Linux (x86_64)
--
-- Host: localhost    Database: agrivall
-- ------------------------------------------------------
-- Server version	8.4.7

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `linea_pedido`
--

DROP TABLE IF EXISTS `linea_pedido`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `linea_pedido` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `pedido_id` bigint unsigned NOT NULL,
  `producto_id` bigint unsigned NOT NULL,
  `formato` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cantidad` int DEFAULT NULL,
  `precio_unitario` decimal(8,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `linea_pedido_pedido_id_foreign` (`pedido_id`),
  KEY `linea_pedido_producto_id_foreign` (`producto_id`),
  CONSTRAINT `linea_pedido_pedido_id_foreign` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`) ON DELETE CASCADE,
  CONSTRAINT `linea_pedido_producto_id_foreign` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `linea_pedido`
--

LOCK TABLES `linea_pedido` WRITE;
/*!40000 ALTER TABLE `linea_pedido` DISABLE KEYS */;
/*!40000 ALTER TABLE `linea_pedido` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_01_09_191445_create_productos_table',1),(5,'2026_01_09_191449_create_pedidos_table',1),(6,'2026_01_09_191450_create_tipo_post_table',1),(7,'2026_01_09_191452_create_linea_pedido_table',1),(8,'2026_01_09_191452_create_postsblog_table',1),(9,'2026_01_09_191452_create_semanascasilla_table',1),(10,'2026_01_20_134656_rename_users_to_usuarios_table',2),(17,'2026_01_20_135238_add_role_to_usuarios_table',3),(18,'2026_01_20_194028_add_fk_to_tipo_post_id_on_posts_table',3);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pedidos`
--

DROP TABLE IF EXISTS `pedidos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pedidos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `fecha_pedido` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `nombre_cliente` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_cliente` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tlf_cliente` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `metodo_pago` enum('Visa','Efectivo','Bizzum','Transferencia') COLLATE utf8mb4_unicode_ci NOT NULL,
  `direccion_envio` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `precio_pedido` decimal(8,2) NOT NULL,
  `estado` enum('Pendiente','Pagado','Enviado','Cancelado') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pendiente',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pedidos`
--

LOCK TABLES `pedidos` WRITE;
/*!40000 ALTER TABLE `pedidos` DISABLE KEYS */;
/*!40000 ALTER TABLE `pedidos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `posts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `titulo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contenido` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `imagen` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `categoria` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `publicado_en` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tipo_post_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `posts_tipo_post_id_foreign` (`tipo_post_id`),
  CONSTRAINT `posts_tipo_post_id_foreign` FOREIGN KEY (`tipo_post_id`) REFERENCES `tipo_post` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES (1,1,'test','Proyecto de gestin agrcola desarrollado con Laravel.Proyecto de gestin agrcola desarrollado con Laravel.Proyecto de gestin agrcola desarrollado con Laravel.Proyecto de gestin agrcola desarrollado con Laravel.Proyecto de gestin agrcola desarrollado con Laravel.Proyecto de gestin agrcola desarrollado con Laravel.Proyecto de gestin agrcola desarrollado con Laravel.','','noticia','2026-01-20 18:45:20','2026-01-20 18:45:20',NULL,1),(2,1,'Arranca la nueva temporada agrcola','Comenzamos una nueva temporada con mucha ilusin. Este ao apostamos por cultivos ms sostenibles y una produccin de mayor calidad.',NULL,'noticia','2026-01-20 18:45:20','2026-01-20 18:45:20',NULL,1),(3,2,'Mejoras en el sistema de riego','Durante las ltimas semanas se han realizado mejoras en el sistema de riego para optimizar el consumo de agua y reducir el impacto ambiental.',NULL,'noticia','2026-01-20 18:45:20','2026-01-20 18:45:20',NULL,1),(4,1,'Consejos para el cuidado del suelo','Mantener un suelo sano es clave para una buena cosecha. Rotacin de cultivos y abonos naturales son algunas de las prcticas recomendadas.',NULL,'blog','2026-01-20 18:45:20','2026-01-20 18:45:20',NULL,1),(5,2,'La importancia del producto local','Consumir producto local no solo apoya a los agricultores, sino que tambin garantiza frescura y reduce la huella de carbono.',NULL,'blog','2026-01-20 18:45:20','2026-01-20 18:45:20',NULL,1),(6,1,'Nueva variedad en el catlogo','Incorporamos una nueva variedad a nuestro catlogo, seleccionada por su sabor y resistencia natural a plagas.',NULL,'noticia','2026-01-20 18:45:20','2026-01-20 18:45:20',NULL,1),(7,2,'Cmo identificar un producto de calidad','El color, la textura y el aroma son claves para reconocer un producto fresco y de calidad directamente del campo.',NULL,'blog','2026-01-20 18:45:20','2026-01-20 18:45:20',NULL,1),(8,1,'Preparando la tierra para la primavera','La preparacin del terreno antes de la primavera es fundamental para asegurar un crecimiento ptimo de los cultivos.',NULL,'blog','2026-01-20 18:45:20','2026-01-20 18:45:20',NULL,1),(9,2,'Jornada de trabajo en el campo','Hoy ha sido una jornada intensa en el campo, con tareas de poda y revisin general de los cultivos.',NULL,'noticia','2026-01-20 18:45:20','2026-01-20 18:45:20',NULL,1),(10,1,'Compromiso con la agricultura sostenible','Seguimos comprometidos con una agricultura respetuosa con el medio ambiente y con las personas.',NULL,'blog','2026-01-20 18:45:20','2026-01-20 18:45:20',NULL,1),(11,2,'Resultados positivos esta semana','Los resultados de esta semana han sido muy positivos, con una mejora notable en la calidad de la produccin.',NULL,'noticia','2026-01-20 18:45:20','2026-01-20 18:45:20',NULL,1),(12,1,'Beneficios de una alimentacin saludable','Una alimentacin basada en productos frescos y naturales aporta numerosos beneficios para la salud.',NULL,'blog','2026-01-20 18:45:20','2026-01-20 18:45:20',NULL,1),(13,2,'Control natural de plagas','Aplicamos mtodos naturales para el control de plagas, evitando el uso de productos qumicos agresivos.',NULL,'blog','2026-01-20 18:45:20','2026-01-20 18:45:20',NULL,1),(14,1,'Visita a los campos de cultivo','Hemos recibido una visita para conocer de primera mano cmo trabajamos nuestros campos y procesos.',NULL,'noticia','2026-01-20 18:45:20','2026-01-20 18:45:20',NULL,1),(15,2,'Planificacin de la prxima cosecha','Ya estamos planificando la prxima cosecha, ajustando tiempos y recursos para mejorar resultados.',NULL,'noticia','2026-01-20 18:45:20','2026-01-20 18:45:20',NULL,1),(16,1,'Trabajo diario y esfuerzo constante','Detrs de cada producto hay un gran trabajo diario y un esfuerzo constante por hacer las cosas bien.',NULL,'blog','2026-01-20 18:45:20','2026-01-20 18:45:20',NULL,1);
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `postsblog`
--

DROP TABLE IF EXISTS `postsblog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `postsblog` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tipo_post_id` bigint unsigned NOT NULL,
  `titulo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `noticia` text COLLATE utf8mb4_unicode_ci,
  `imagen` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_public` datetime DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `postsblog_tipo_post_id_foreign` (`tipo_post_id`),
  CONSTRAINT `postsblog_tipo_post_id_foreign` FOREIGN KEY (`tipo_post_id`) REFERENCES `tipo_post` (`id`) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `postsblog`
--

LOCK TABLES `postsblog` WRITE;
/*!40000 ALTER TABLE `postsblog` DISABLE KEYS */;
/*!40000 ALTER TABLE `postsblog` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productos`
--

DROP TABLE IF EXISTS `productos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `productos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `variedad` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `formato` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `precio` decimal(8,2) DEFAULT NULL,
  `imagen` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `disponible` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productos`
--

LOCK TABLES `productos` WRITE;
/*!40000 ALTER TABLE `productos` DISABLE KEYS */;
INSERT INTO `productos` VALUES (1,'Manzanas','Golden','Kg',1.45,'productos/3Yhf61wnKjRwMJS6cye0PqeHOQMp7EhU7KbEDBIv.jpg',1,'2026-01-09 22:02:25','2026-01-09 22:02:25'),(2,'Manzanas','Golden','Kg',1.45,'productos/3Yhf61wnKjRwMJS6cye0PqeHOQMp7EhU7KbEDBIv.jpg',1,'2026-01-09 22:02:25','2026-01-09 22:02:25'),(3,'Manzanas','Golden','Kg',1.45,'productos/3Yhf61wnKjRwMJS6cye0PqeHOQMp7EhU7KbEDBIv.jpg',1,'2026-01-09 22:02:25','2026-01-09 22:02:25'),(4,'Manzanas','Golden','Kg',1.45,'productos/3Yhf61wnKjRwMJS6cye0PqeHOQMp7EhU7KbEDBIv.jpg',1,'2026-01-09 22:02:25','2026-01-09 22:02:25'),(5,'Manzanas','Golden','Kg',1.45,'productos/3Yhf61wnKjRwMJS6cye0PqeHOQMp7EhU7KbEDBIv.jpg',1,'2026-01-09 22:02:25','2026-01-09 22:02:25'),(6,'Manzanas','Golden','Kg',1.45,'productos/3Yhf61wnKjRwMJS6cye0PqeHOQMp7EhU7KbEDBIv.jpg',1,'2026-01-09 22:02:25','2026-01-09 22:02:25'),(7,'Manzanas','Golden','Kg',1.45,'productos/3Yhf61wnKjRwMJS6cye0PqeHOQMp7EhU7KbEDBIv.jpg',1,'2026-01-09 22:02:25','2026-01-09 22:02:25'),(8,'Manzanas','Golden','Kg',1.45,'productos/3Yhf61wnKjRwMJS6cye0PqeHOQMp7EhU7KbEDBIv.jpg',1,'2026-01-09 22:02:25','2026-01-09 22:02:25'),(9,'Manzanas','Golden','Kg',1.45,'productos/3Yhf61wnKjRwMJS6cye0PqeHOQMp7EhU7KbEDBIv.jpg',1,'2026-01-09 22:02:25','2026-01-09 22:02:25'),(10,'Melones','nose','Kg',2.00,'productos/sVB6D51vIMUA8WWzm4IuH1YlToEFQfe2CuUscUxD.jpg',1,'2026-01-09 22:08:20','2026-01-09 22:08:26'),(11,'Sandia','Malaga','Kg',2.45,'productos/8ChdCPWZ2rmbnc8GDANB0EMGhy82Y73kSbxxdaSJ.jpg',1,'2026-01-09 22:09:08','2026-01-09 22:09:08'),(12,'Uvas','Blanca','Kg',4.50,'productos/mNjmKoI6tsDDqTQfFDiGWGy7IzH1LL7cynADspV0.jpg',1,'2026-01-09 22:10:50','2026-01-20 17:50:08'),(13,'Naranjas','Normales','Kg',6.00,'productos/BoGDQlEJemAIEcKpxzTcrBPrvt9OiXg7Rx1Pk8Mk.jpg',0,'2026-01-09 22:12:02','2026-01-09 22:12:02'),(14,'Peras','Peras','Kg',3.50,'productos/JeKG5UxCa0qxNIZYYAIRugStT0bgerir7SLR9fWn.jpg',0,'2026-01-09 22:12:32','2026-01-20 18:19:50');
/*!40000 ALTER TABLE `productos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `semanascasilla`
--

DROP TABLE IF EXISTS `semanascasilla`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `semanascasilla` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `anio` smallint NOT NULL,
  `numero_sem` tinyint NOT NULL,
  `descriptor` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `estado` enum('libre','reservado') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `semanascasilla`
--

LOCK TABLES `semanascasilla` WRITE;
/*!40000 ALTER TABLE `semanascasilla` DISABLE KEYS */;
/*!40000 ALTER TABLE `semanascasilla` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('AjnzoXGtuljKCCzKHsSoIWtAmBHM68oDbRWzcP2D',2,'172.19.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZjc0YzJ0elN3U2p4RUV5QXJnb3JuNkhMbFFCaUNBUHVlTXNPejhleSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjg6Imh0dHA6Ly9sb2NhbGhvc3QvcHJvZHVjdG9zLzEiO3M6NToicm91dGUiO3M6MTQ6InByb2R1Y3Rvcy5zaG93Ijt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mjt9',1768941859);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_post`
--

DROP TABLE IF EXISTS `tipo_post`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipo_post` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tipo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_post`
--

LOCK TABLES `tipo_post` WRITE;
/*!40000 ALTER TABLE `tipo_post` DISABLE KEYS */;
INSERT INTO `tipo_post` VALUES (1,'Noticia',NULL,NULL);
/*!40000 ALTER TABLE `tipo_post` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'Admin','admin@test.com',NULL,'$2y$12$6IIvxl7k5gb7Vo1cdJBPVe40dvEtt6HMcrEJA8DB4Bh1DBRNZoiYa','tDBl1IxvtqGYAgRXiADXLiLbz1NGDa8qxQyDTBciM8tD7UaDCa380WTA8As9','2026-01-20 14:01:39','2026-01-20 14:01:39','user'),(2,'Edgar Moreno','edgmormel@gmail.com',NULL,'$2y$12$6nFaCU2j93TZSJyjScOipOrTLcgFpu11ClATFdN6FllcMbj0ea5la','8nsIK00XOCtJioEbzgDHlQzbgC3vjTKoi766eyJ63Km3HRXNlYmOapb1FnrD','2026-01-20 15:00:37','2026-01-20 15:00:37','user');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-01-20 22:11:48
