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
-- Table structure for table `comentarios`
--

DROP TABLE IF EXISTS `comentarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comentarios` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `post_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `contenido` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `comentarios_post_id_foreign` (`post_id`),
  KEY `comentarios_user_id_foreign` (`user_id`),
  CONSTRAINT `comentarios_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `comentarios_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comentarios`
--

LOCK TABLES `comentarios` WRITE;
/*!40000 ALTER TABLE `comentarios` DISABLE KEYS */;
/*!40000 ALTER TABLE `comentarios` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_01_09_191445_create_productos_table',1),(5,'2026_01_09_191449_create_pedidos_table',1),(6,'2026_01_09_191450_create_tipo_post_table',1),(7,'2026_01_09_191452_create_linea_pedido_table',1),(8,'2026_01_09_191452_create_postsblog_table',1),(9,'2026_01_09_191452_create_semanascasilla_table',1),(10,'2026_01_20_134656_rename_users_to_usuarios_table',1),(11,'2026_01_20_135238_add_role_to_usuarios_table',1),(12,'2026_02_14_000001_add_user_id_to_posts_table',1),(13,'2026_02_14_000002_create_comentarios_table',1),(14,'2026_02_14_191100_add_contenido_and_categoria_to_posts_table',2),(15,'2026_02_14_200000_create_reservas_table',3),(16,'2026_02_15_000001_add_contenido_and_categoria_to_posts_table',4),(17,'2026_02_15_000002_make_tipo_post_id_nullable_on_posts_table',5),(18,'2026_02_15_000003_create_posts_table',6),(19,'2026_02_15_000004_drop_imagen_from_posts_table',6);
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
  `tipo_post_id` bigint unsigned DEFAULT NULL,
  `titulo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `noticia` text COLLATE utf8mb4_unicode_ci,
  `fecha_public` datetime DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `contenido` text COLLATE utf8mb4_unicode_ci,
  `categoria` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `posts_user_id_foreign` (`user_id`),
  KEY `posts_tipo_post_id_foreign` (`tipo_post_id`),
  CONSTRAINT `posts_tipo_post_id_foreign` FOREIGN KEY (`tipo_post_id`) REFERENCES `tipo_post` (`id`) ON DELETE SET NULL,
  CONSTRAINT `posts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES (1,1,NULL,'Titulo del post',NULL,'2026-02-14 23:18:28','2026-02-14 23:18:28','2026-02-14 23:18:28','Lorem ipsum, dolor sit amet consectetur adipisicing elit. Mollitia ad quam temporibus beatae repellat perspiciatis accusamus minima? Provident ratione tenetur dolore unde? Quis reiciendis reprehenderit, enim accusantium qui aspernatur eligendi!','noticia'),(21,1,NULL,'Nueva plataforma lanzada','Lanzamiento oficial','2026-02-14 23:37:22','2026-02-14 23:37:22','2026-02-14 23:37:22','Hoy lanzamos nuestra nueva plataforma.','Noticia'),(22,1,NULL,'Mejoras de rendimiento','Sistema optimizado','2026-02-14 23:37:22','2026-02-14 23:37:22','2026-02-14 23:37:22','Se optimiz el tiempo de carga.','Noticia'),(23,1,NULL,'Cambio de polticas','Actualizacin legal','2026-02-14 23:37:22','2026-02-14 23:37:22','2026-02-14 23:37:22','Hemos actualizado nuestras polticas.','Noticia'),(24,1,NULL,'Nuevo equipo de trabajo','Se suman talentos','2026-02-14 23:37:22','2026-02-14 23:37:22','2026-02-14 23:37:22','Presentamos al nuevo equipo.','Noticia'),(25,1,NULL,'Nueva seccin disponible','Nueva funcionalidad','2026-02-14 23:37:22','2026-02-14 23:37:22','2026-02-14 23:37:22','Se agreg una nueva seccin.','Noticia'),(26,1,NULL,'Mantenimiento programado','Aviso importante','2026-02-14 23:37:22','2026-02-14 23:37:22','2026-02-14 23:37:22','Habr mantenimiento este fin de semana.','Noticia'),(27,1,NULL,'Crecimiento de usuarios','Buenas noticias','2026-02-14 23:37:22','2026-02-14 23:37:22','2026-02-14 23:37:22','Superamos los 10k usuarios.','Noticia'),(28,1,NULL,'Evento de lanzamiento','Evento especial','2026-02-14 23:37:22','2026-02-14 23:37:22','2026-02-14 23:37:22','Te invitamos al evento de lanzamiento.','Evento'),(29,1,NULL,'Webinar gratuito','Capacitacin online','2026-02-14 23:37:22','2026-02-14 23:37:22','2026-02-14 23:37:22','Aprende a usar la plataforma.','Evento'),(30,1,NULL,'Charla tcnica','Tecnologa y futuro','2026-02-14 23:37:22','2026-02-14 23:37:22','2026-02-14 23:37:22','Charla con expertos del sector.','Evento'),(31,1,NULL,'Meetup presencial','Encuentro de usuarios','2026-02-14 23:37:22','2026-02-14 23:37:22','2026-02-14 23:37:22','Nos reunimos para compartir experiencias.','Evento'),(32,1,NULL,'Hackathon 2026','Competencia de desarrollo','2026-02-14 23:37:22','2026-02-14 23:37:22','2026-02-14 23:37:22','Participa en nuestro hackathon.','Evento'),(33,1,NULL,'Conferencia anual','Evento principal','2026-02-14 23:37:22','2026-02-14 23:37:22','2026-02-14 23:37:22','Nuestra conferencia ms importante.','Evento'),(34,1,NULL,'Actualizacin de seguridad','Parche aplicado','2026-02-14 23:37:22','2026-02-14 23:37:22','2026-02-14 23:37:22','Se corrigieron vulnerabilidades.','Actualizacin'),(35,1,NULL,'Nueva versin 2.1','Release oficial','2026-02-14 23:37:22','2026-02-14 23:37:22','2026-02-14 23:37:22','Disponible la versin 2.1.','Actualizacin'),(36,1,NULL,'Edicin de publicaciones','Nueva funcin','2026-02-14 23:37:22','2026-02-14 23:37:22','2026-02-14 23:37:22','Ahora puedes editar publicaciones.','Actualizacin'),(37,1,NULL,'Mejoras en el panel','UX optimizado','2026-02-14 23:37:22','2026-02-14 23:37:22','2026-02-14 23:37:22','Interfaz ms intuitiva.','Actualizacin'),(38,1,NULL,'Correccin de errores','Bugfixes','2026-02-14 23:37:22','2026-02-14 23:37:22','2026-02-14 23:37:22','Se corrigieron errores menores.','Actualizacin'),(39,1,NULL,'Optimizacin de base de datos','Mejor rendimiento','2026-02-14 23:37:22','2026-02-14 23:37:22','2026-02-14 23:37:22','Consultas ms rpidas.','Actualizacin');
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productos`
--

LOCK TABLES `productos` WRITE;
/*!40000 ALTER TABLE `productos` DISABLE KEYS */;
INSERT INTO `productos` VALUES (3,'Manzanas','Golden','Kg',719.16,'productos/1771097894_manzana.jpg',1,'2026-02-14 19:38:14','2026-02-14 19:50:04'),(4,'Sandia','Golden','Kg',53.00,'productos/1771098785_sandia.jpeg',1,'2026-02-14 19:52:52','2026-02-14 19:53:05'),(5,'Uvas','Verdes','Kg',12.00,'productos/1771098857_uvas.jpeg',1,'2026-02-14 19:54:17','2026-02-14 19:55:01'),(6,'Platanos','Canarias','Pack 6',5.30,'productos/1771098942_platanos.jpeg',1,'2026-02-14 19:55:42','2026-02-14 19:55:42'),(7,'Kiwi','Verde','Malla',4.35,'productos/1771099873_kiwi.jpeg',1,'2026-02-14 20:11:13','2026-02-14 21:21:49'),(8,'Naranjas','Valencia','Kg',2.80,'productos/1771112758_descarga.jpeg',1,'2026-02-14 23:45:26','2026-02-14 23:45:58'),(9,'Limones','Fino','Kg',2.20,'productos/1771112778_limones.jpeg',1,'2026-02-14 23:45:26','2026-02-14 23:46:18'),(10,'Peras','Conferencia','Kg',3.10,'productos/1771112789_peras.jpeg',1,'2026-02-14 23:45:26','2026-02-14 23:46:29'),(11,'Fresas','Temporada','Bandeja 500g',4.50,'productos/1771112806_fresas.jpeg',1,'2026-02-14 23:45:26','2026-02-14 23:46:46'),(12,'Melón','Piel de Sapo','Unidad',6.90,'productos/1771112843_melon.jpeg',1,'2026-02-14 23:45:26','2026-02-14 23:47:23'),(13,'Aguacates','Hass','Pack 4',5.75,'productos/1771112860_aguacates.jpeg',1,'2026-02-14 23:45:26','2026-02-14 23:47:40'),(14,'Tomates','Rama','Kg',2.95,'productos/1771112884_tomates.jpeg',1,'2026-02-14 23:45:26','2026-02-14 23:48:04'),(15,'Lechuga','Romana','Unidad',1.40,'productos/1771112915_lechuga.jpeg',1,'2026-02-14 23:45:26','2026-02-14 23:48:35'),(16,'Zanahorias','Nacional','Bolsa 1Kg',1.85,'productos/1771112937_zanahoria.jpeg',1,'2026-02-14 23:45:26','2026-02-14 23:48:57'),(17,'Pimientos','Verdes','Kg',3.60,'productos/1771112961_pimineto verde.jpeg',1,'2026-02-14 23:45:26','2026-02-14 23:49:21');
/*!40000 ALTER TABLE `productos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reservas`
--

DROP TABLE IF EXISTS `reservas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reservas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `num_personas` tinyint NOT NULL DEFAULT '1',
  `comentario` text COLLATE utf8mb4_unicode_ci,
  `estado` enum('pendiente','confirmada','cancelada') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pendiente',
  `precio_total` decimal(8,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reservas_user_id_foreign` (`user_id`),
  CONSTRAINT `reservas_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservas`
--

LOCK TABLES `reservas` WRITE;
/*!40000 ALTER TABLE `reservas` DISABLE KEYS */;
/*!40000 ALTER TABLE `reservas` ENABLE KEYS */;
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
INSERT INTO `sessions` VALUES ('oGup2tmpFS9fxvr9tO03ImTAWOIuJBihazXp4gsu',1,'172.20.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiV05vdDFpeWN6QW5GellJWVNIdUVUU0c0a1loY2dFNHNpYmR1V09lSCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3QvY2FzYS1ydXJhbCI7czo1OiJyb3V0ZSI7czoxMDoiY2FzYS1ydXJhbCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==',1771114816),('OMVOQOITkFQ5bXiOn39SDWdwLBTCv4xiGKJ1WxmZ',NULL,'172.20.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36','YTozOntzOjY6Il90b2tlbiI7czo0MDoiZjZHNmVZNzVsQjdDTW9BOUt3MGR6UGdrcllwNzNNbzZ2bEtLd1o1QiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTY6Imh0dHA6Ly9sb2NhbGhvc3QiO3M6NToicm91dGUiO3M6NToiaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1771108051);
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_post`
--

LOCK TABLES `tipo_post` WRITE;
/*!40000 ALTER TABLE `tipo_post` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'Edgar Moreno','edgmormel@gmail.com',NULL,'$2y$12$UHmUn0rXohQ4wk5BdtdZsOj9EgPcRg5o81108xaQ7uIcEpSb3vKAO','SRhXPQKLSWLrUjHKROguVHeHFdM6sYiXAUzkXxSgzSBYYQXffwPXJpvFnl5j','2026-02-14 19:02:18','2026-02-14 19:02:18','admin');
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

-- Dump completed on 2026-02-15  0:34:30
