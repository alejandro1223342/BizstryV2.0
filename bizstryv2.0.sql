-- MySQL dump 10.13  Distrib 8.0.38, for Win64 (x86_64)
--
-- Host: localhost    Database: bizstryv2
-- ------------------------------------------------------
-- Server version	8.0.39

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `catalogo`
--

DROP TABLE IF EXISTS `catalogo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `catalogo` (
  `cat_id` int NOT NULL AUTO_INCREMENT,
  `cat_nombre` varchar(200) DEFAULT NULL,
  `cat_descripcion` text,
  `cat_padre` int DEFAULT NULL,
  `cat_estado` tinyint DEFAULT '1',
  PRIMARY KEY (`cat_id`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `catalogo`
--

LOCK TABLES `catalogo` WRITE;
/*!40000 ALTER TABLE `catalogo` DISABLE KEYS */;
INSERT INTO `catalogo` VALUES (1,'ROLES',NULL,0,1),(2,'ADMINISTRADOR',NULL,1,1),(3,'ATENCION AL CLIENTE',NULL,1,1),(4,'CONTADOR',NULL,1,1),(5,'DESPACHO',NULL,1,1),(6,'GENERO',NULL,1,1),(7,'MASCULINO',NULL,6,1),(8,'FEMENINO',NULL,6,1),(9,'PROVINCIA',NULL,0,1),(10,'IMBABURA',NULL,9,1),(11,'IBARRA','CIUDAD DE IMBABURA',10,1),(12,'BANCOS','',0,1),(13,'BANCO PICHINCHA','1234567891',12,1),(14,'FORMA DE PAGO',NULL,0,1),(15,'DEPOSITO',NULL,14,1),(16,'CONTRA ENTREGA',NULL,14,1),(17,'PAQUETERIAS',NULL,0,1),(18,'SERVIENTREGA',NULL,17,1),(19,'DROPI SERVIENTREGA',NULL,17,1),(20,'POR COBRAR',NULL,12,1),(21,'ESTADO PEDIDOS',NULL,0,1),(22,'PENDIENTE DE APROBACIÓN',NULL,21,1),(23,'APROBADO',NULL,21,1),(24,'MEDIDAS',NULL,0,1),(25,'XS',NULL,24,1),(26,'S',NULL,24,1),(27,'M',NULL,24,1),(28,'L',NULL,24,1),(29,'COLORES',NULL,0,1),(30,'ROJO',NULL,29,1),(31,'TIPO DE PRENDA',NULL,0,1),(32,'HOODIE',NULL,31,1),(33,'PROMOCIONES',NULL,0,1),(34,'HOODIE x4',NULL,33,1),(35,'TIPO DISEÑO',NULL,0,1),(36,'TRANSFER',NULL,35,1),(37,'SERIGRAFIA',NULL,35,1),(38,'RECHAZADO',NULL,21,1);
/*!40000 ALTER TABLE `catalogo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cliente`
--

DROP TABLE IF EXISTS `cliente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cliente` (
  `cli_id` int NOT NULL AUTO_INCREMENT,
  `cli_codigo` varchar(45) NOT NULL,
  `cli_numCodigo` int NOT NULL,
  `cli_nombre` varchar(100) DEFAULT NULL,
  `cli_cedula` varchar(10) DEFAULT NULL,
  `cli_telefono` varchar(10) DEFAULT NULL,
  `cli_telefonoDos` varchar(10) DEFAULT NULL,
  `cli_correo` varchar(100) DEFAULT NULL,
  `cat_id_provincia` int DEFAULT NULL,
  `cat_id_ciudad` int DEFAULT NULL,
  `cli_direccion` varchar(200) DEFAULT NULL,
  `cat_id_genero` int DEFAULT NULL,
  `cli_estado` int NOT NULL,
  `cli_fechaReg` date NOT NULL,
  `usu_id_reg` int NOT NULL,
  PRIMARY KEY (`cli_id`),
  KEY `usuariosfk_cliente_idx` (`usu_id_reg`),
  KEY `catalogoProvinciaFK_cliente_idx` (`cat_id_provincia`),
  KEY `catalogoCiudadFK_cliente_idx` (`cat_id_ciudad`),
  KEY `catalogoGeneroFK_cliente_idx` (`cat_id_genero`),
  CONSTRAINT `catalogoCiudadFK_cliente` FOREIGN KEY (`cat_id_ciudad`) REFERENCES `catalogo` (`cat_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `catalogoGeneroFK_cliente` FOREIGN KEY (`cat_id_genero`) REFERENCES `catalogo` (`cat_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `catalogoProvinciaFK_cliente` FOREIGN KEY (`cat_id_provincia`) REFERENCES `catalogo` (`cat_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `usuariosfk_cliente` FOREIGN KEY (`usu_id_reg`) REFERENCES `usuarios` (`usu_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cliente`
--

LOCK TABLES `cliente` WRITE;
/*!40000 ALTER TABLE `cliente` DISABLE KEYS */;
INSERT INTO `cliente` VALUES (4,'CB',1,'ALEJANDRO MUÑOZ','1050518594','0989650479','','alejomuoss@gmail.com',10,11,'Venezuela 4-73 y Uruguay',7,1,'2025-04-11',1),(5,'CB',2,'SILVIA PUETATE','1002364527','0994434857','','silvia@gmail.com',10,11,'ALPACHACA MACHALA Y ZAMORA',8,1,'2025-04-11',1);
/*!40000 ALTER TABLE `cliente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detalle_pedidos`
--

DROP TABLE IF EXISTS `detalle_pedidos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `detalle_pedidos` (
  `det_id` int NOT NULL AUTO_INCREMENT,
  `ped_id` int NOT NULL,
  `pre_id` int NOT NULL,
  `dis_id` int NOT NULL,
  `det_cantidad` int DEFAULT NULL,
  `det_precioUnitario` decimal(4,2) DEFAULT NULL,
  `cat_id_promocion` int DEFAULT NULL,
  `det_descuento` decimal(4,2) DEFAULT NULL,
  `det_subtotal` decimal(4,2) DEFAULT NULL,
  PRIMARY KEY (`det_id`),
  KEY `pedidosFK_detallePedidos_idx` (`ped_id`),
  KEY `prendasFK_detallePedidos_idx` (`pre_id`),
  KEY `diseniosFK_detallePedidos_idx` (`dis_id`),
  KEY `catalogoPromocionesFK_detallePedidos_idx` (`cat_id_promocion`),
  CONSTRAINT `catalogoPromocionesFK_detallePedidos` FOREIGN KEY (`cat_id_promocion`) REFERENCES `catalogo` (`cat_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `diseniosFK_detallePedidos` FOREIGN KEY (`dis_id`) REFERENCES `disenios` (`dis_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `pedidosFK_detallePedidos` FOREIGN KEY (`ped_id`) REFERENCES `pedidos` (`ped_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `prendasFK_detallePedidos` FOREIGN KEY (`pre_id`) REFERENCES `prendas` (`pre_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detalle_pedidos`
--

LOCK TABLES `detalle_pedidos` WRITE;
/*!40000 ALTER TABLE `detalle_pedidos` DISABLE KEYS */;
INSERT INTO `detalle_pedidos` VALUES (1,1,1,1,1,40.00,34,10.00,30.00),(2,1,1,2,1,40.00,34,10.00,30.00),(3,1,1,3,1,40.00,34,10.00,30.00),(4,1,1,4,1,40.00,34,10.00,30.00),(5,2,1,1,1,40.00,34,10.00,30.00),(6,2,1,2,1,40.00,34,10.00,30.00),(7,2,1,3,1,40.00,34,10.00,30.00),(8,2,1,4,1,40.00,34,10.00,30.00);
/*!40000 ALTER TABLE `detalle_pedidos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `disenios`
--

DROP TABLE IF EXISTS `disenios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `disenios` (
  `dis_id` int NOT NULL AUTO_INCREMENT,
  `dis_nombre` varchar(200) NOT NULL,
  `dis_descripcion` varchar(200) DEFAULT NULL,
  `cat_id_tipo` int NOT NULL,
  `dis_stock` int NOT NULL,
  `dis_estado` tinyint NOT NULL DEFAULT '1',
  PRIMARY KEY (`dis_id`),
  KEY `catalogoFK_disenios_idx` (`cat_id_tipo`),
  CONSTRAINT `catalogoFK_disenios` FOREIGN KEY (`cat_id_tipo`) REFERENCES `catalogo` (`cat_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `disenios`
--

LOCK TABLES `disenios` WRITE;
/*!40000 ALTER TABLE `disenios` DISABLE KEYS */;
INSERT INTO `disenios` VALUES (1,'SIFU',NULL,36,100,1),(2,'DRAGON BALL',NULL,37,100,1),(3,'DEATH NOTE',NULL,36,100,1),(4,'BLEACH',NULL,37,100,1);
/*!40000 ALTER TABLE `disenios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `modulos`
--

DROP TABLE IF EXISTS `modulos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `modulos` (
  `mod_id` int NOT NULL AUTO_INCREMENT,
  `mod_nombre` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`mod_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `modulos`
--

LOCK TABLES `modulos` WRITE;
/*!40000 ALTER TABLE `modulos` DISABLE KEYS */;
INSERT INTO `modulos` VALUES (1,'Dashboard'),(2,'Acceso'),(3,'Reportes'),(4,'Contador'),(5,'Atención al Cliente');
/*!40000 ALTER TABLE `modulos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pedidos`
--

DROP TABLE IF EXISTS `pedidos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pedidos` (
  `ped_id` int NOT NULL AUTO_INCREMENT,
  `cli_id` int NOT NULL,
  `cat_id_banco` int NOT NULL,
  `cat_id_formaPago` int NOT NULL,
  `cat_id_origenPagoBanco` int NOT NULL,
  `ped_numComprobante` varchar(13) DEFAULT NULL,
  `cat_id_paqueteria` int NOT NULL,
  `ped_envio` decimal(4,2) NOT NULL,
  `ped_totalSinDescuento` decimal(6,2) DEFAULT NULL,
  `ped_descuento` decimal(4,2) DEFAULT NULL,
  `ped_total` decimal(6,2) NOT NULL,
  `ped_saldoPendiente` decimal(6,2) DEFAULT NULL,
  `cat_id_estadoActual` int DEFAULT NULL,
  `usu_id_vendedor` int NOT NULL,
  PRIMARY KEY (`ped_id`),
  KEY `catalogoBancoFK_pedidos_idx` (`cat_id_banco`),
  KEY `catalogoFormaPagoFK_pedidos_idx` (`cat_id_formaPago`),
  KEY `catalogoOrigenPagoBancoFK_pedidos_idx` (`cat_id_origenPagoBanco`),
  KEY `catalogoPaqueteriaFK_pedidos_idx` (`cat_id_paqueteria`),
  KEY `usuarioFK_pedidos_idx` (`usu_id_vendedor`),
  KEY `clienteFK_pedidos_idx` (`cli_id`),
  KEY `catalogoEstadoActualFK_pedidos_idx` (`cat_id_estadoActual`),
  CONSTRAINT `catalogoBancoFK_pedidos` FOREIGN KEY (`cat_id_banco`) REFERENCES `catalogo` (`cat_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `catalogoEstadoActualFK_pedidos` FOREIGN KEY (`cat_id_estadoActual`) REFERENCES `catalogo` (`cat_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `catalogoFormaPagoFK_pedidos` FOREIGN KEY (`cat_id_formaPago`) REFERENCES `catalogo` (`cat_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `catalogoOrigenPagoBancoFK_pedidos` FOREIGN KEY (`cat_id_origenPagoBanco`) REFERENCES `catalogo` (`cat_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `catalogoPaqueteriaFK_pedidos` FOREIGN KEY (`cat_id_paqueteria`) REFERENCES `catalogo` (`cat_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `clienteFK_pedidos` FOREIGN KEY (`cli_id`) REFERENCES `cliente` (`cli_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `usuarioFK_pedidos` FOREIGN KEY (`usu_id_vendedor`) REFERENCES `usuarios` (`usu_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pedidos`
--

LOCK TABLES `pedidos` WRITE;
/*!40000 ALTER TABLE `pedidos` DISABLE KEYS */;
INSERT INTO `pedidos` VALUES (1,4,13,15,13,'123456789',18,7.00,120.00,0.00,120.00,0.00,23,1),(2,5,20,16,20,NULL,19,7.00,120.00,0.00,120.00,120.00,22,1);
/*!40000 ALTER TABLE `pedidos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pedidos_estado`
--

DROP TABLE IF EXISTS `pedidos_estado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pedidos_estado` (
  `pedEstado_id` int NOT NULL AUTO_INCREMENT,
  `ped_id` int DEFAULT NULL,
  `cat_id_estado` int DEFAULT NULL,
  `pedEstado_observaciones` varchar(200) DEFAULT NULL,
  `pedEstado_fecha` datetime DEFAULT NULL,
  `usu_id_reg` int DEFAULT NULL,
  PRIMARY KEY (`pedEstado_id`),
  KEY `pedidosFK_pedidosEstado_idx` (`ped_id`),
  KEY `catalogoFK_pedidosEstado_idx` (`cat_id_estado`),
  KEY `usuariosFk_pedidoEstado_idx` (`usu_id_reg`),
  CONSTRAINT `catalogoFK_pedidosEstado` FOREIGN KEY (`cat_id_estado`) REFERENCES `catalogo` (`cat_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `pedidosFK_pedidosEstado` FOREIGN KEY (`ped_id`) REFERENCES `pedidos` (`ped_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `usuariosFk_pedidoEstado` FOREIGN KEY (`usu_id_reg`) REFERENCES `usuarios` (`usu_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pedidos_estado`
--

LOCK TABLES `pedidos_estado` WRITE;
/*!40000 ALTER TABLE `pedidos_estado` DISABLE KEYS */;
INSERT INTO `pedidos_estado` VALUES (1,1,22,'PEDIDO REGISTRADO','2025-04-11 20:19:11',1),(2,2,22,'PEDIDO REGISTRADO','2025-04-11 20:19:11',1),(6,1,23,'SIN OBSERVACIONES','2025-04-13 23:35:22',1);
/*!40000 ALTER TABLE `pedidos_estado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permisos`
--

DROP TABLE IF EXISTS `permisos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permisos` (
  `per_id` int NOT NULL AUTO_INCREMENT,
  `cat_id_rol` int NOT NULL,
  `mod_id` int NOT NULL,
  `per_ver` int DEFAULT NULL,
  `per_agregar` int DEFAULT NULL,
  `per_editar` int DEFAULT NULL,
  `per_eliminar` int DEFAULT NULL,
  PRIMARY KEY (`per_id`),
  KEY `catalogofk_permisos_idx` (`cat_id_rol`),
  KEY `modulosfk_permisos_idx` (`mod_id`),
  CONSTRAINT `catalogofk_permisos` FOREIGN KEY (`cat_id_rol`) REFERENCES `catalogo` (`cat_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `modulosfk_permisos` FOREIGN KEY (`mod_id`) REFERENCES `modulos` (`mod_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permisos`
--

LOCK TABLES `permisos` WRITE;
/*!40000 ALTER TABLE `permisos` DISABLE KEYS */;
INSERT INTO `permisos` VALUES (1,2,1,1,1,1,1),(2,2,2,1,1,1,1),(3,2,3,1,1,1,1),(4,2,4,1,1,1,1),(5,2,5,1,1,1,1);
/*!40000 ALTER TABLE `permisos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prendas`
--

DROP TABLE IF EXISTS `prendas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `prendas` (
  `pre_id` int NOT NULL AUTO_INCREMENT,
  `cat_id_tipoPrenda` int NOT NULL,
  `cat_id_color` int NOT NULL,
  `cat_id_medida` int NOT NULL,
  `pre_costoProduccion` decimal(4,2) NOT NULL,
  `pre_precioVenta` decimal(4,2) NOT NULL,
  `pre_stock` int NOT NULL,
  `pre_estado` tinyint NOT NULL DEFAULT '1',
  PRIMARY KEY (`pre_id`),
  KEY `catalogoTipoPrendaFK_prendas_idx` (`cat_id_tipoPrenda`),
  KEY `catalogoColorFK_prendas_idx` (`cat_id_color`),
  KEY `catalogoMedida_prendas_idx` (`cat_id_medida`),
  CONSTRAINT `catalogoColorFK_prendas` FOREIGN KEY (`cat_id_color`) REFERENCES `catalogo` (`cat_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `catalogoMedida_prendas` FOREIGN KEY (`cat_id_medida`) REFERENCES `catalogo` (`cat_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `catalogoTipoPrendaFK_prendas` FOREIGN KEY (`cat_id_tipoPrenda`) REFERENCES `catalogo` (`cat_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prendas`
--

LOCK TABLES `prendas` WRITE;
/*!40000 ALTER TABLE `prendas` DISABLE KEYS */;
INSERT INTO `prendas` VALUES (1,32,30,28,15.00,40.00,200,1);
/*!40000 ALTER TABLE `prendas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `usu_id` int NOT NULL AUTO_INCREMENT,
  `usu_nombre` text NOT NULL,
  `usu_cedula` varchar(10) DEFAULT NULL,
  `usu_telefono` varchar(10) DEFAULT NULL,
  `usu_correo` varchar(100) DEFAULT NULL,
  `cat_id_rol` int NOT NULL,
  `usu_login` varchar(20) NOT NULL,
  `usu_clave` text NOT NULL,
  `usu_fechaReg` date DEFAULT NULL,
  `usu_estado` tinyint DEFAULT '1',
  PRIMARY KEY (`usu_id`),
  KEY `catalogofk_usuarios_idx` (`cat_id_rol`),
  CONSTRAINT `catalogofk_usuarios` FOREIGN KEY (`cat_id_rol`) REFERENCES `catalogo` (`cat_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'ALEJANDRO MUÑOZ','1','1','alejomuoss@gmail.com',2,'admin','a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3','2025-03-11',1);
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'bizstryv2'
--

--
-- Dumping routines for database 'bizstryv2'
--
/*!50003 DROP PROCEDURE IF EXISTS `sp_acciones` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_acciones`(
    IN op INT, 
    IN cargo INT, 
    IN permiso INT, 
    IN leer INT, 
    IN escribir INT, 
    IN editar INT, 
    IN eliminar INT
)
BEGIN
    IF op = 1 THEN
        -- Si el permiso no existe, lo inserta
        IF NOT EXISTS (SELECT 1 FROM `acciones` WHERE `cat_id_cargo` = cargo AND `per_id` = permiso) THEN
            INSERT INTO `acciones` (`cat_id_cargo`, `per_id`, `acc_leer`, `acc_escribir`, `acc_editar`, `acc_eliminar`)
            VALUES (cargo, permiso, leer, escribir, editar, eliminar);
        ELSE
            -- Si el permiso ya existe, actualiza los valores de permisos
            UPDATE `acciones`
            SET `acc_leer` = leer,
                `acc_escribir` = escribir,
                `acc_editar` = editar,
                `acc_eliminar` = eliminar
            WHERE `cat_id_cargo` = cargo AND `per_id` = permiso
            AND (leer != acc_leer OR escribir != acc_escribir OR editar != acc_editar OR eliminar != acc_eliminar);
	
        END IF;
        
    ELSEIF op = 2 THEN
        SELECT 
            per.per_id,
            per.per_nombre,
            COALESCE(acc.acc_leer, 0) AS acc_leer,
            COALESCE(acc.acc_escribir, 0) AS acc_escribir,
            COALESCE(acc.acc_editar, 0) AS acc_editar,
            COALESCE(acc.acc_eliminar, 0) AS acc_eliminar
        FROM permisos per
        LEFT JOIN acciones acc 
            ON acc.per_id = per.per_id 
            AND acc.cat_id_cargo = cargo;
	ELSEIF op = 3 then
    
    select cat_id_cargo,per.per_id,per.per_nombre,acc_leer,acc_escribir,acc_editar,acc_eliminar from acciones acc
		inner join permisos per on per.per_id = acc.per_id
		where acc.cat_id_cargo =  cargo;
    END IF;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_catalgo` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_catalgo`(in op varchar(100),in id int, in nombre varchar(100),in descr varchar(100),in padre int)
BEGIN

declare sig int;

 
if op='list' then
SELECT c.cat_id,c.cat_nombre,c.cat_descripcion,
( SELECT cat_nombre FROM catalogo p WHERE p.cat_id = c.cat_padre) AS padre, cat_estado
FROM catalogo c; 
   
elseif op='spa' then
	SELECT cat_id, cat_nombre
FROM catalogo
WHERE cat_padre = padre
    AND cat_id IN (18, 28) ;
    
elseif op='spa2' then
	SELECT cat_id, cat_nombre,cat_descripcion
	FROM catalogo
	WHERE cat_padre = padre and cat_estado = 1
    ORDER BY cat_nombre ASC;  
    
elseif op='spa3' then
	SELECT cat_id, cat_nombre
	FROM catalogo
	WHERE cat_padre = padre and cat_estado = 1;
elseif op = 'spa4' then
SELECT cat_id, cat_nombre
	FROM catalogo
	WHERE cat_padre = padre and cat_estado = 1 and cat_id in(1090,1091)
    ORDER BY cat_nombre ASC;  
    
elseif op='ing' then

INSERT INTO `catalogo`(`cat_nombre`,`cat_descripcion`,`cat_padre`,`cat_estado`)
VALUES
(nombre,descr,padre,1);

elseif op='act' then
        UPDATE `catalogo` SET `cat_estado` = '1' WHERE (`cat_id` = id);
elseif op='des' then
        UPDATE `catalogo` SET `cat_estado` = '0' WHERE (`cat_id` = id);
elseif op='mod' then

UPDATE `catalogo` SET `cat_nombre` = nombre, `cat_descripcion` = descr, `cat_padre` = padre WHERE (`cat_id` = id);

elseif op='edit' then
	select * from catalogo where cat_id=id;
elseif op = 1 then
SELECT c.cat_id,c.cat_nombre,c.cat_descripcion,
( SELECT cat_nombre FROM catalogo p WHERE p.cat_id = c.cat_padre) AS padre, cat_estado
FROM catalogo c where cat_padre <> 8
AND NOT (cat_padre BETWEEN 37 AND 70);

elseif op = 2 then
SELECT cat_id, cat_nombre,cat_descripcion,cat_stock
	FROM catalogo
	WHERE cat_padre in (1099,1103)  and cat_estado = 1
    ORDER BY cat_nombre ASC;
    
    elseif op = 3 then 
select * from catalogo where cat_padre = 4;
end if;



END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_clientes` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_clientes`(in op int,in codigo text ,in nombre varchar(200),in cedula varchar(13),
in telefono varchar(10), in telefonoDos varchar(10),
in correo varchar(100),in provincia int,in ciudad int, in direccion varchar(200),in genero int,in usuario int)
BEGIN
DECLARE nuevoCodigoNum INT;

if op = 0 then

SELECT IFNULL(MAX(cli_numCodigo), 0) + 1 INTO nuevoCodigoNum FROM cliente;

INSERT INTO `cliente`
(`cli_codigo`,`cli_numCodigo`,`cli_nombre`,
`cli_cedula`,`cli_telefono`,cli_telefonoDos,`cli_correo`,`cat_id_provincia`,
`cat_id_ciudad`,`cli_direccion`,`cat_id_genero`,`cli_estado`,cli_fechaReg,usu_id_reg)
VALUES
(
'CB',
nuevoCodigoNum,
nombre,
cedula,
telefono,
telefonoDos,
correo,
provincia,
ciudad,
direccion,
genero,
1,CURDATE(),usuario);

elseif op = 1 then

select cli_id,concat(cli_codigo,cli_numCodigo) as codigo,cli_nombre,cli_cedula as identificacion,
CONCAT(COALESCE(cli_telefono, ''), ' - ', COALESCE(cli_telefonoDos, '')) AS cli_telefono,
cli_correo,cat_prov.cat_nombre as provincia
,cat_parr.cat_nombre as parroquia,cli_direccion,cat_gen.cat_nombre as genero, cli_estado from cliente cli
inner join catalogo cat_prov on cat_prov.cat_id=cli.cat_id_provincia
inner join catalogo cat_parr on cat_parr.cat_id=cli.cat_id_ciudad
inner join catalogo cat_gen on cat_gen.cat_id=cli.cat_id_genero;

elseif op = 2 then
select cli_id,concat(cli_codigo,cli_numCodigo) as codigo,cli_nombre,cli_cedula as identificacion,
CONCAT(COALESCE(cli_telefono, ''), ' - ', COALESCE(cli_telefonoDos, '')) AS cli_telefono,cli_correo,concat(cat_prov.cat_nombre,"-",cat_parr.cat_nombre,"-",cli_direccion) as cli_direccion,
cat_gen.cat_nombre as genero, cli_estado from cliente cli
inner join catalogo cat_prov on cat_prov.cat_id=cli.cat_id_provincia
inner join catalogo cat_parr on cat_parr.cat_id=cli.cat_id_parroquia
inner join catalogo cat_gen on cat_gen.cat_id=cli.cat_id_tipo_genero
where CONCAT(cli.cli_codigo, cli.cli_numCodigo) = codigo;

elseif op = 3 then

UPDATE `cliente` SET `cli_estado` = '0' WHERE (`cli_id` = usuario);
elseif op = 4 then
UPDATE `cliente` SET `cli_estado` = '1' WHERE (`cli_id` = usuario);

elseif op = 5 then
SELECT `cli_id`,
    concat(`cli_codigo`,`cli_numCodigo`) as codigo,
    `cli_nombre`,
    `cli_cedula`,
    `cli_telefono`,
    `cli_telefonoDos`,
    `cli_correo`,
    `cat_id_provincia`,
    `cat_id_ciudad`,
    `cli_direccion`,
    `cat_id_genero`
FROM `cliente` where cli_id = usuario;

elseif op = 6 then
UPDATE `cliente`
SET
`cli_nombre` = nombre,
`cli_cedula` = identificacion,
`cli_telefono` = telefono,
`cli_telefonoDos` = telefonoDos,
`cli_correo` = cli_correo,
`cat_id_provincia` = provincia,
`cat_id_parroquia` = parroquia,
`cli_direccion` = direccion,
`cat_id_tipo_genero` = genero
WHERE `cli_id` = usuario;
elseif op = 7 then 

SELECT 
cab_id,
concat(cli.cli_codigo,cli_numCodigo)as codigo,
cli.cli_nombre,
cli.cli_direccion,
concat(cli_telefono,' - ', cli.cli_telefonoDos) as telefono,
cat_id_banco,
cat_id_tipoPago,
cat_id_origenPago,
cab_numComprobante,
cab_paqueteria,
cat_id_canalVenta,
cab_totalSinEnvio,
cab_costoEnvio,
cab_descuento,
cab_total,
cab_abono,
cab_abonoTotal,
cab_usuVenta,
cli.cli_id
FROM cabecera_pedidos cp
INNER JOIN 
	usuario usu on usu.usu_id = cp.usu_id_registro
INNER JOIN 
	cliente cli on cli.cli_id = cp.cli_id 
WHERE cp.cab_id = codigo;

end if;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_logeo` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_logeo`(in usuario varchar(50), in clave varchar(100))
BEGIN

SELECT usu_id,usu_cedula,usu_nombre,usu_correo,cat_id_rol,usu_telefono,usu_login,usu_clave,usu_estado
FROM usuarios
WHERE usu_login=usuario AND usu_clave=clave AND usu_estado='1';

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_pedidos` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_pedidos`(in op int, in pedido_id int)
BEGIN
IF op = 1 then
-- Listar Pedidos en DataTable
SELECT pedi.ped_id, 
concat(cli.cli_nombre,' / ',cat_provincia.cat_nombre,' - ',cat_ciudad.cat_nombre,' / ', cli.cli_direccion) as cliente,
cat_paqueteria.cat_nombre as paqueteria, cat_formaPago.cat_nombre as formaPago, cat_estadoActual.cat_nombre as estadoActual 
FROM pedidos AS pedi
INNER JOIN cliente cli ON cli.cli_id = pedi.cli_id
INNER JOIN catalogo cat_provincia ON cat_provincia.cat_id = cli.cat_id_provincia
INNER JOIN catalogo cat_ciudad ON cat_ciudad.cat_id = cli.cat_id_ciudad
INNER JOIN catalogo cat_banco ON cat_banco.cat_id = pedi.cat_id_banco
INNER JOIN catalogo cat_formaPago ON cat_formaPago.cat_id = pedi.cat_id_formaPago
INNER JOIN catalogo cat_paqueteria ON cat_paqueteria.cat_id = pedi.cat_id_paqueteria
INNER JOIN catalogo cat_estadoActual ON cat_estadoActual.cat_id = pedi.cat_id_estadoActual;

ELSEIF op = 2 then
-- Listar pedido para ver Detalle del pedido
SELECT pedi.ped_id,
pedi.ped_numComprobante,
cli.cli_nombre, 
cli.cli_direccion, 
concat(cat_provincia.cat_nombre,',',cat_ciudad.cat_nombre) as ciudad,
cat_formaPago.cat_nombre as formaPago, 
cat_paqueteria.cat_nombre as paqueteria, 
cat_banco.cat_nombre as banco, 
cat_origenPagoBanco.cat_nombre as origenPagoBanco 
FROM pedidos pedi
INNER JOIN cliente cli ON cli.cli_id = pedi.cli_id
INNER JOIN catalogo cat_provincia ON cat_provincia.cat_id = cli.cat_id_provincia
INNER JOIN catalogo cat_ciudad ON cat_ciudad.cat_id = cli.cat_id_ciudad
INNER JOIN catalogo cat_banco ON cat_banco.cat_id = pedi.cat_id_banco
INNER JOIN catalogo cat_formaPago ON cat_formaPago.cat_id = pedi.cat_id_formaPago
INNER JOIN catalogo cat_origenPagoBanco ON cat_origenPagoBanco.cat_id = pedi.cat_id_origenPagoBanco
INNER JOIN catalogo cat_paqueteria ON cat_paqueteria.cat_id = pedi.cat_id_paqueteria
INNER JOIN catalogo cat_estadoActual ON cat_estadoActual.cat_id = pedi.cat_id_estadoActual 
WHERE pedi.ped_id = pedido_id;
ELSEIF op = 3 then
SELECT dp.det_cantidad,
concat(catalogo_prendas.cat_nombre,' ', catalogo_color.cat_nombre,' ',catalogo_medida.cat_nombre) as producto,
catalogo_promociones.cat_nombre as promocion,
dp.det_precioUnitario,
dp.det_descuento,
dp.det_subtotal 
FROM detalle_pedidos AS dp
INNER JOIN pedidos pedi ON pedi.ped_id = dp.ped_id
INNER JOIN prendas pre ON pre.pre_id = dp.pre_id
INNER JOIN catalogo catalogo_prendas ON catalogo_prendas.cat_id = pre.cat_id_tipoPrenda
INNER JOIN catalogo catalogo_color ON catalogo_color.cat_id = pre.cat_id_color
INNER JOIN catalogo catalogo_medida ON catalogo_medida.cat_id = pre.cat_id_medida
INNER JOIN catalogo catalogo_promociones ON catalogo_promociones.cat_id = dp.cat_id_promocion
INNER JOIN disenios dis ON dis.dis_id = dp.dis_id
WHERE pedi.ped_id = pedido_id;
-- Listar detalle del pedido para Detalle del pedido

END IF;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_pedidos_estado` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_pedidos_estado`(in op int, in pedido_id int, in estado int, in observaciones varchar(100), in usuario int)
BEGIN

IF op = 1 then

INSERT INTO `pedidos_estado`
(`ped_id`,
`cat_id_estado`,
`pedEstado_observaciones`,
`pedEstado_fecha`,
`usu_id_reg`)
VALUES
(pedido_id,
estado,
observaciones,
now(),
usuario);

 UPDATE `pedidos`
        SET `cat_id_estadoActual` = estado
        WHERE `ped_id` = pedido_id;
END IF;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `sp_permisos` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_permisos`(
    IN op INT, 
    IN rol INT, 
    IN modulo INT, 
    IN ver INT, 
    IN agregar INT, 
    IN editar INT, 
    IN eliminar INT
)
BEGIN
     IF op = 1 THEN
        -- Si el permiso no existe, lo inserta
        IF NOT EXISTS (SELECT 1 FROM `permisos` WHERE `cat_id_rol` = rol AND `mod_id` = modulo) THEN
            INSERT INTO `permisos` (`cat_id_rol`, `mod_id`, `per_ver`, `per_agregar`, `per_editar`, `per_eliminar`)
            VALUES (rol, modulo, ver, agregar, editar, eliminar);
        ELSE
            -- Si el permiso ya existe, actualiza los valores de permisos
            UPDATE `permisos`
            SET `per_ver` = ver,
                `per_agregar` = agregar,
                `per_editar` = editar,
                `per_eliminar` = eliminar
            WHERE `cat_id_rol` = rol AND `mod_id` = modulo
            AND (ver != per_ver OR agregar != per_agregar OR editar != per_editar OR eliminar != per_eliminar);
	
        END IF;
        
    ELSEIF op = 2 THEN
        SELECT 
            modu.mod_id,
            modu.mod_nombre,
            COALESCE(per.per_ver, 0) AS per_ver,
            COALESCE(per.per_agregar, 0) AS per_agregar,
            COALESCE(per.per_editar, 0) AS per_editar,
            COALESCE(per.per_eliminar, 0) AS per_eliminar
        FROM modulos modu
        LEFT JOIN permisos per 
            ON per.mod_id = modu.mod_id 
            AND per.cat_id_rol = rol;
	ELSEIF op = 3 then
    
    select cat_id_rol,modu.mod_id,modu.mod_nombre,per_ver,per_agregar,per_editar,per_eliminar from permisos per
		inner join modulos modu on modu.mod_id = per.mod_id
		where per.cat_id_rol =  rol;
    END IF;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-04-14 14:32:39
