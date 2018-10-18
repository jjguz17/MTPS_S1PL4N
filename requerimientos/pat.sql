/*
Navicat MySQL Data Transfer

Source Server         : localhostIP
Source Server Version : 50540
Source Host           : 127.0.0.1:3306
Source Database       : mtps

Target Server Type    : MYSQL
Target Server Version : 50540
File Encoding         : 65001

Date: 2015-06-29 10:00:05
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for pat_actividad
-- ----------------------------
DROP TABLE IF EXISTS `pat_actividad`;
CREATE TABLE `pat_actividad` (
  `id_actividad` int(11) NOT NULL AUTO_INCREMENT,
  `id_item` int(11) NOT NULL,
  `meta_actividad` float NOT NULL,
  `unidad_medida` varchar(255) NOT NULL,
  `anio_meta` int(11) NOT NULL,
  `meta_enero` float NOT NULL,
  `meta_febrero` float NOT NULL,
  `meta_marzo` float NOT NULL,
  `meta_abril` float NOT NULL,
  `meta_mayo` float NOT NULL,
  `meta_junio` float NOT NULL,
  `meta_julio` float NOT NULL,
  `meta_agosto` float NOT NULL,
  `meta_septiembre` float NOT NULL,
  `meta_octubre` float NOT NULL,
  `meta_noviembre` float NOT NULL,
  `meta_diciembre` float NOT NULL,
  `recursos_actividad` varchar(255) DEFAULT NULL,
  `observaciones_actividad` text,
  `id_seccion` int(11) NOT NULL,
  `fecha_creacion` datetime NOT NULL,
  `id_usuario_crea` int(11) NOT NULL,
  `fecha_modificacion` datetime DEFAULT NULL,
  `id_usuario_modifica` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_actividad`),
  KEY `fk_actividad_item` (`id_item`),
  CONSTRAINT `fk_actividad_item` FOREIGN KEY (`id_item`) REFERENCES `pat_item` (`id_item`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pat_actividad
-- ----------------------------
INSERT INTO `pat_actividad` VALUES ('3', '124', '78', 'Personas', '2015', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '100', '', '42', '2015-06-16 01:52:02', '22', '2015-06-23 07:52:26', '22');
INSERT INTO `pat_actividad` VALUES ('4', '125', '100', 'Empelados', '2015', '0', '0', '0', '0', '100', '0', '0', '0', '0', '0', '0', '0', '500', 'Se cambió de acción estratégica', '42', '2015-06-16 02:17:02', '22', '2015-06-17 16:53:09', '22');
INSERT INTO `pat_actividad` VALUES ('5', '126', '30', 'Cacaguates', '2015', '0', '30', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '100', '', '42', '2015-06-16 03:01:31', '22', '2015-06-24 15:59:12', '22');
INSERT INTO `pat_actividad` VALUES ('6', '127', '500', 'Piñas', '2015', '0', '0', '0', '0', '500', '0', '0', '0', '0', '0', '0', '0', '250.56', 'Cuidado con puyarse con las espinas', '42', '2015-06-16 03:02:28', '22', '2015-06-17 16:33:57', '22');
INSERT INTO `pat_actividad` VALUES ('7', '128', '1', 'Pelotas', '2015', '1', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '100', '', '42', '2015-06-16 03:03:32', '22', null, null);
INSERT INTO `pat_actividad` VALUES ('10', '131', '12', 'Meses', '2015', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '10', 'ccccc', '42', '2015-06-16 03:14:06', '22', '2015-06-24 15:51:52', '22');
INSERT INTO `pat_actividad` VALUES ('12', '135', '36', 'Pelotas', '2015', '0', '0', '0', '0', '0', '0', '12', '12', '12', '0', '0', '0', '5.36', 'Son nuevas', '42', '2015-06-18 16:43:17', '22', '2015-06-24 15:59:09', '22');
INSERT INTO `pat_actividad` VALUES ('13', '138', '12', 'Melones', '2015', '12', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '10000', '', '42', '2015-06-19 09:24:58', '22', null, null);
INSERT INTO `pat_actividad` VALUES ('14', '139', '36', 'Actividades', '2015', '12', '0', '0', '0', '12', '0', '0', '0', '12', '0', '0', '0', '10000', '', '42', '2015-06-19 16:59:06', '54', null, null);
INSERT INTO `pat_actividad` VALUES ('15', '140', '31', 'Personas', '2015', '0', '0', '0', '0', '31', '0', '0', '0', '0', '0', '0', '0', '10000', 'Observación de prueba', '59', '2015-06-22 15:39:49', '52', '2015-06-22 16:40:28', '22');
INSERT INTO `pat_actividad` VALUES ('16', '141', '12', 'Unidades', '2015', '12', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '123234', '', '59', '2015-06-22 15:42:43', '22', '2015-06-24 12:10:31', '52');
INSERT INTO `pat_actividad` VALUES ('17', '142', '435', 'Carros', '2015', '0', '435', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '123123', '', '59', '2015-06-22 15:46:04', '22', '2015-06-24 11:56:45', '52');
INSERT INTO `pat_actividad` VALUES ('18', '143', '23', 'Melones', '2015', '0', '0', '0', '0', '23', '0', '0', '0', '0', '0', '0', '0', '432213', '', '59', '2015-06-22 15:51:57', '22', '2015-06-24 12:02:18', '52');
INSERT INTO `pat_actividad` VALUES ('19', '160', '120', 'Personas', '2015', '10', '10', '10', '10', '10', '10', '10', '10', '10', '10', '10', '10', '1000', '', '59', '2015-06-23 08:35:32', '52', '2015-06-24 13:38:47', '52');
INSERT INTO `pat_actividad` VALUES ('20', '161', '50', 'Empleos', '2015', '0', '0', '0', '0', '50', '0', '0', '0', '0', '0', '0', '0', '1500', '', '59', '2015-06-23 08:36:53', '52', null, null);
INSERT INTO `pat_actividad` VALUES ('21', '162', '175', 'Manzanas', '2015', '0', '175', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '25', '', '59', '2015-06-23 08:39:22', '52', '2015-06-23 08:39:32', '52');
INSERT INTO `pat_actividad` VALUES ('22', '163', '600', 'Melones', '2015', '0', '0', '0', '0', '0', '600', '0', '0', '0', '0', '0', '0', '55', '', '59', '2015-06-23 08:41:08', '52', null, null);
INSERT INTO `pat_actividad` VALUES ('23', '164', '101', 'Alumnos', '2015', '0', '0', '0', '0', '0', '0', '0', '1', '100', '0', '0', '0', '5000', '', '59', '2015-06-23 08:42:44', '52', '2015-06-23 08:49:13', '52');
INSERT INTO `pat_actividad` VALUES ('24', '165', '450', 'Pelotas', '2015', '0', '0', '0', '450', '0', '0', '0', '0', '0', '0', '0', '0', '85', '', '59', '2015-06-23 08:48:56', '52', null, null);
INSERT INTO `pat_actividad` VALUES ('25', '166', '250', 'Peroles', '2015', '250', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '400', '', '59', '2015-06-23 08:51:16', '52', null, null);
INSERT INTO `pat_actividad` VALUES ('26', '167', '500', 'Sandías', '2015', '0', '0', '0', '0', '500', '0', '0', '0', '0', '0', '0', '0', '500', '', '59', '2015-06-23 08:51:43', '52', null, null);
INSERT INTO `pat_actividad` VALUES ('27', '168', '100', 'Computadoras', '2015', '0', '0', '100', '0', '0', '0', '0', '0', '0', '0', '0', '0', '3000', '', '59', '2015-06-23 08:52:34', '52', null, null);
INSERT INTO `pat_actividad` VALUES ('28', '169', '150', 'Loncheras', '2015', '0', '150', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '99', '', '59', '2015-06-23 08:53:07', '52', '2015-06-24 12:12:42', '52');
INSERT INTO `pat_actividad` VALUES ('29', '170', '36', 'Motos', '2015', '12', '0', '0', '0', '12', '0', '0', '12', '0', '0', '0', '0', '3000', '', '59', '2015-06-24 15:08:24', '52', '2015-06-24 15:09:59', '52');
INSERT INTO `pat_actividad` VALUES ('30', '190', '12', 'Logros', '2015', '0', '0', '0', '0', '12', '0', '0', '0', '0', '0', '0', '0', '2000', '', '42', '2015-06-26 09:54:15', '22', null, null);
INSERT INTO `pat_actividad` VALUES ('31', '232', '12', 'Personas', '2015', '0', '0', '0', '0', '0', '0', '0', '12', '0', '0', '0', '0', '350', 'Se redujo presupuesto', '59', '2015-06-29 08:16:12', '52', '2015-06-29 08:17:27', '52');
INSERT INTO `pat_actividad` VALUES ('32', '242', '1', 'Marco Teórico', '2015', '0', '0', '0', '0', '0', '1', '0', '0', '0', '0', '0', '0', '15', '', '59', '2015-06-29 09:01:58', '52', null, null);
INSERT INTO `pat_actividad` VALUES ('33', '243', '2', 'Documento de diseño', '2015', '0', '0', '0', '0', '0', '0', '1', '1', '0', '0', '0', '0', '10', 'Se redujo el presupuesto al 50% inicial', '59', '2015-06-29 09:03:02', '52', '2015-06-29 09:19:26', '22');
INSERT INTO `pat_actividad` VALUES ('34', '244', '1', 'APA         ', '2015', '0', '0', '0', '0', '0', '0', '0', '1', '0', '0', '0', '0', '18', 'Se debe utilizar APA 6', '59', '2015-06-29 09:04:00', '52', '2015-06-29 09:04:11', '52');

-- ----------------------------
-- Table structure for pat_documento
-- ----------------------------
DROP TABLE IF EXISTS `pat_documento`;
CREATE TABLE `pat_documento` (
  `id_documento` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_pei` varchar(250) NOT NULL,
  `fecha_aprobacion` date NOT NULL,
  `nombre_documento` varchar(250) NOT NULL,
  `inicio_periodo` int(11) NOT NULL,
  `fin_periodo` int(11) NOT NULL,
  `observacion` text,
  `fecha_creacion` datetime NOT NULL,
  `id_usuario_crea` int(11) NOT NULL,
  `fecha_modificacion` datetime DEFAULT NULL,
  `id_usuario_modifica` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_documento`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pat_documento
-- ----------------------------
INSERT INTO `pat_documento` VALUES ('7', 'PEI 2014-2019', '2015-05-04', 'PEI_2014_-_2019.pdf', '2014', '2019', '', '2015-05-14 20:42:19', '22', '2015-06-19 09:25:29', '22');
INSERT INTO `pat_documento` VALUES ('8', 'Prueba PEI', '2015-06-23', 'BR_SC_MAS_ALLA_DEL_SERV.pdf', '2014', '2016', 'Este PEI es para probar todo el proceso desarrollado hasta la fecha de aprobación', '2015-06-23 08:18:39', '22', '2015-06-29 08:13:49', '22');
INSERT INTO `pat_documento` VALUES ('9', 'Tesis MTPS', '2015-06-29', 'FICHA_INTEGRAL.pdf', '2014', '2019', '', '2015-06-29 08:48:44', '22', '2015-06-29 09:24:57', '22');

-- ----------------------------
-- Table structure for pat_estado
-- ----------------------------
DROP TABLE IF EXISTS `pat_estado`;
CREATE TABLE `pat_estado` (
  `id_estado` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion_estado` varchar(255) NOT NULL,
  PRIMARY KEY (`id_estado`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pat_estado
-- ----------------------------
INSERT INTO `pat_estado` VALUES ('1', 'Creado');
INSERT INTO `pat_estado` VALUES ('2', 'Enviado');
INSERT INTO `pat_estado` VALUES ('3', 'Aprobado');
INSERT INTO `pat_estado` VALUES ('4', 'Rechazado');
INSERT INTO `pat_estado` VALUES ('5', 'Corregido');

-- ----------------------------
-- Table structure for pat_estado_actividad
-- ----------------------------
DROP TABLE IF EXISTS `pat_estado_actividad`;
CREATE TABLE `pat_estado_actividad` (
  `id_actividad` int(11) NOT NULL,
  `id_estado` int(11) NOT NULL,
  `observacion_estado_actividad` text,
  `fecha_creacion` datetime NOT NULL,
  `id_usuario_crea` int(11) NOT NULL,
  KEY `fk_actividad` (`id_actividad`),
  KEY `fk_estado` (`id_estado`),
  CONSTRAINT `fk_actividad` FOREIGN KEY (`id_actividad`) REFERENCES `pat_actividad` (`id_actividad`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_estado` FOREIGN KEY (`id_estado`) REFERENCES `pat_estado` (`id_estado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pat_estado_actividad
-- ----------------------------
INSERT INTO `pat_estado_actividad` VALUES ('3', '1', '', '2015-06-16 01:52:02', '22');
INSERT INTO `pat_estado_actividad` VALUES ('4', '1', '', '2015-06-16 02:17:02', '22');
INSERT INTO `pat_estado_actividad` VALUES ('5', '1', '', '2015-06-16 03:01:31', '22');
INSERT INTO `pat_estado_actividad` VALUES ('6', '1', '', '2015-06-16 03:02:28', '22');
INSERT INTO `pat_estado_actividad` VALUES ('7', '1', '', '2015-06-16 03:03:32', '22');
INSERT INTO `pat_estado_actividad` VALUES ('10', '1', '', '2015-06-16 03:14:06', '22');
INSERT INTO `pat_estado_actividad` VALUES ('6', '5', '', '2015-06-17 16:26:23', '22');
INSERT INTO `pat_estado_actividad` VALUES ('6', '3', '', '2015-06-17 16:33:57', '22');
INSERT INTO `pat_estado_actividad` VALUES ('3', '5', '', '2015-06-17 16:34:34', '22');
INSERT INTO `pat_estado_actividad` VALUES ('4', '5', '', '2015-06-17 16:52:06', '22');
INSERT INTO `pat_estado_actividad` VALUES ('4', '3', '', '2015-06-17 16:53:09', '22');
INSERT INTO `pat_estado_actividad` VALUES ('5', '4', 'Mala redacción', '2015-06-17 21:14:01', '22');
INSERT INTO `pat_estado_actividad` VALUES ('7', '2', '', '2015-06-18 11:10:01', '22');
INSERT INTO `pat_estado_actividad` VALUES ('5', '5', '', '2015-06-18 11:25:11', '22');
INSERT INTO `pat_estado_actividad` VALUES ('12', '1', '', '2015-06-18 16:43:17', '22');
INSERT INTO `pat_estado_actividad` VALUES ('12', '5', '', '2015-06-18 16:43:50', '22');
INSERT INTO `pat_estado_actividad` VALUES ('13', '1', '', '2015-06-19 09:24:58', '22');
INSERT INTO `pat_estado_actividad` VALUES ('14', '1', '', '2015-06-19 16:59:06', '54');
INSERT INTO `pat_estado_actividad` VALUES ('15', '1', '', '2015-06-22 15:39:49', '52');
INSERT INTO `pat_estado_actividad` VALUES ('16', '1', '', '2015-06-22 15:42:43', '22');
INSERT INTO `pat_estado_actividad` VALUES ('17', '1', '', '2015-06-22 15:46:04', '22');
INSERT INTO `pat_estado_actividad` VALUES ('18', '1', '', '2015-06-22 15:51:57', '22');
INSERT INTO `pat_estado_actividad` VALUES ('18', '3', 'Se autorizó inmediatamente por crearse con usuario Administrador', '2015-06-22 15:51:57', '22');
INSERT INTO `pat_estado_actividad` VALUES ('18', '5', '', '2015-06-22 16:00:57', '22');
INSERT INTO `pat_estado_actividad` VALUES ('18', '3', 'Se autorizó inmediatamente por crearse con usuario Administrador', '2015-06-22 16:00:57', '22');
INSERT INTO `pat_estado_actividad` VALUES ('16', '5', '', '2015-06-22 16:05:40', '22');
INSERT INTO `pat_estado_actividad` VALUES ('16', '3', 'Se autorizó inmediatamente por crearse con usuario Administrador', '0000-00-00 00:00:00', '22');
INSERT INTO `pat_estado_actividad` VALUES ('15', '5', '', '2015-06-22 16:10:02', '22');
INSERT INTO `pat_estado_actividad` VALUES ('15', '3', 'Se autorizó inmediatamente por crearse con usuario Administrador', '2015-06-22 16:10:02', '22');
INSERT INTO `pat_estado_actividad` VALUES ('15', '5', '', '2015-06-22 16:11:05', '22');
INSERT INTO `pat_estado_actividad` VALUES ('15', '3', 'Se autorizó inmediatamente por crearse con usuario Administrador', '2015-06-22 16:11:05', '22');
INSERT INTO `pat_estado_actividad` VALUES ('15', '5', '', '2015-06-22 16:38:41', '22');
INSERT INTO `pat_estado_actividad` VALUES ('15', '3', 'Se autorizó inmediatamente por crearse con usuario Administrador', '2015-06-22 16:38:41', '22');
INSERT INTO `pat_estado_actividad` VALUES ('15', '5', '', '2015-06-22 16:40:28', '22');
INSERT INTO `pat_estado_actividad` VALUES ('15', '3', 'Se autorizó inmediatamente por crearse con usuario Administrador', '2015-06-22 16:40:29', '22');
INSERT INTO `pat_estado_actividad` VALUES ('17', '5', '', '2015-06-22 16:41:44', '22');
INSERT INTO `pat_estado_actividad` VALUES ('17', '3', 'Se autorizó inmediatamente por crearse con usuario Administrador', '2015-06-22 16:41:45', '22');
INSERT INTO `pat_estado_actividad` VALUES ('3', '5', '', '2015-06-23 07:52:26', '22');
INSERT INTO `pat_estado_actividad` VALUES ('3', '3', 'Se autorizó inmediatamente por crearse con usuario Administrador', '2015-06-23 07:52:27', '22');
INSERT INTO `pat_estado_actividad` VALUES ('19', '1', '', '2015-06-23 08:35:32', '52');
INSERT INTO `pat_estado_actividad` VALUES ('19', '2', '', '2015-06-23 08:35:45', '52');
INSERT INTO `pat_estado_actividad` VALUES ('20', '1', '', '2015-06-23 08:36:53', '52');
INSERT INTO `pat_estado_actividad` VALUES ('20', '2', '', '2015-06-23 08:37:04', '52');
INSERT INTO `pat_estado_actividad` VALUES ('21', '1', '', '2015-06-23 08:39:22', '52');
INSERT INTO `pat_estado_actividad` VALUES ('21', '5', '', '2015-06-23 08:39:32', '52');
INSERT INTO `pat_estado_actividad` VALUES ('21', '2', '', '2015-06-23 08:39:40', '52');
INSERT INTO `pat_estado_actividad` VALUES ('22', '1', '', '2015-06-23 08:41:08', '52');
INSERT INTO `pat_estado_actividad` VALUES ('22', '2', '', '2015-06-23 08:42:13', '52');
INSERT INTO `pat_estado_actividad` VALUES ('23', '1', '', '2015-06-23 08:42:44', '52');
INSERT INTO `pat_estado_actividad` VALUES ('23', '5', '', '2015-06-23 08:42:57', '52');
INSERT INTO `pat_estado_actividad` VALUES ('23', '5', '', '2015-06-23 08:44:07', '52');
INSERT INTO `pat_estado_actividad` VALUES ('23', '5', '', '2015-06-23 08:45:54', '52');
INSERT INTO `pat_estado_actividad` VALUES ('23', '5', '', '2015-06-23 08:47:18', '52');
INSERT INTO `pat_estado_actividad` VALUES ('24', '1', '', '2015-06-23 08:48:56', '52');
INSERT INTO `pat_estado_actividad` VALUES ('23', '5', '', '2015-06-23 08:49:13', '52');
INSERT INTO `pat_estado_actividad` VALUES ('25', '1', '', '2015-06-23 08:51:16', '52');
INSERT INTO `pat_estado_actividad` VALUES ('26', '1', '', '2015-06-23 08:51:43', '52');
INSERT INTO `pat_estado_actividad` VALUES ('27', '1', '', '2015-06-23 08:52:34', '52');
INSERT INTO `pat_estado_actividad` VALUES ('28', '1', '', '2015-06-23 08:53:07', '52');
INSERT INTO `pat_estado_actividad` VALUES ('28', '5', '', '2015-06-23 08:53:31', '52');
INSERT INTO `pat_estado_actividad` VALUES ('28', '2', '', '2015-06-23 08:53:35', '52');
INSERT INTO `pat_estado_actividad` VALUES ('19', '3', '', '2015-06-24 11:01:02', '22');
INSERT INTO `pat_estado_actividad` VALUES ('20', '4', '', '2015-06-24 11:01:51', '22');
INSERT INTO `pat_estado_actividad` VALUES ('21', '4', '', '2015-06-24 11:01:51', '22');
INSERT INTO `pat_estado_actividad` VALUES ('28', '3', '', '2015-06-24 11:01:51', '22');
INSERT INTO `pat_estado_actividad` VALUES ('28', '4', '', '2015-06-24 11:24:21', '22');
INSERT INTO `pat_estado_actividad` VALUES ('17', '4', '', '2015-06-24 11:44:38', '22');
INSERT INTO `pat_estado_actividad` VALUES ('7', '4', '', '2015-06-24 11:48:42', '22');
INSERT INTO `pat_estado_actividad` VALUES ('7', '3', '', '2015-06-24 11:51:24', '22');
INSERT INTO `pat_estado_actividad` VALUES ('18', '4', '', '2015-06-24 11:52:51', '22');
INSERT INTO `pat_estado_actividad` VALUES ('17', '5', '', '2015-06-24 11:56:45', '52');
INSERT INTO `pat_estado_actividad` VALUES ('17', '2', '', '2015-06-24 11:56:50', '52');
INSERT INTO `pat_estado_actividad` VALUES ('17', '3', '', '2015-06-24 11:57:17', '22');
INSERT INTO `pat_estado_actividad` VALUES ('18', '5', '', '2015-06-24 12:02:18', '52');
INSERT INTO `pat_estado_actividad` VALUES ('16', '5', '', '2015-06-24 12:10:31', '52');
INSERT INTO `pat_estado_actividad` VALUES ('16', '2', '', '2015-06-24 12:10:33', '52');
INSERT INTO `pat_estado_actividad` VALUES ('18', '2', '', '2015-06-24 12:10:34', '52');
INSERT INTO `pat_estado_actividad` VALUES ('23', '2', '', '2015-06-24 12:11:48', '52');
INSERT INTO `pat_estado_actividad` VALUES ('24', '2', '', '2015-06-24 12:12:18', '52');
INSERT INTO `pat_estado_actividad` VALUES ('25', '2', '', '2015-06-24 12:12:23', '52');
INSERT INTO `pat_estado_actividad` VALUES ('26', '2', '', '2015-06-24 12:12:27', '52');
INSERT INTO `pat_estado_actividad` VALUES ('27', '2', '', '2015-06-24 12:12:36', '52');
INSERT INTO `pat_estado_actividad` VALUES ('28', '5', '', '2015-06-24 12:12:42', '52');
INSERT INTO `pat_estado_actividad` VALUES ('28', '2', '', '2015-06-24 12:12:44', '52');
INSERT INTO `pat_estado_actividad` VALUES ('20', '3', '', '2015-06-24 12:13:23', '22');
INSERT INTO `pat_estado_actividad` VALUES ('21', '3', '', '2015-06-24 12:13:23', '22');
INSERT INTO `pat_estado_actividad` VALUES ('23', '3', '', '2015-06-24 12:13:23', '22');
INSERT INTO `pat_estado_actividad` VALUES ('22', '3', '', '2015-06-24 12:13:23', '22');
INSERT INTO `pat_estado_actividad` VALUES ('24', '3', '', '2015-06-24 12:13:23', '22');
INSERT INTO `pat_estado_actividad` VALUES ('25', '3', '', '2015-06-24 12:13:23', '22');
INSERT INTO `pat_estado_actividad` VALUES ('26', '3', '', '2015-06-24 12:13:23', '22');
INSERT INTO `pat_estado_actividad` VALUES ('27', '3', '', '2015-06-24 12:13:23', '22');
INSERT INTO `pat_estado_actividad` VALUES ('28', '3', '', '2015-06-24 12:13:23', '22');
INSERT INTO `pat_estado_actividad` VALUES ('19', '4', '', '2015-06-24 12:55:48', '22');
INSERT INTO `pat_estado_actividad` VALUES ('19', '3', '', '2015-06-24 13:08:52', '22');
INSERT INTO `pat_estado_actividad` VALUES ('19', '4', 'No me gusta esta actividad', '2015-06-24 13:28:00', '22');
INSERT INTO `pat_estado_actividad` VALUES ('19', '5', '', '2015-06-24 13:38:47', '52');
INSERT INTO `pat_estado_actividad` VALUES ('19', '2', '', '2015-06-24 13:38:51', '52');
INSERT INTO `pat_estado_actividad` VALUES ('19', '3', 'Todo Ok!', '2015-06-24 13:39:12', '22');
INSERT INTO `pat_estado_actividad` VALUES ('29', '1', '', '2015-06-24 15:08:24', '52');
INSERT INTO `pat_estado_actividad` VALUES ('29', '5', '', '2015-06-24 15:09:59', '52');
INSERT INTO `pat_estado_actividad` VALUES ('29', '2', '', '2015-06-24 15:10:21', '52');
INSERT INTO `pat_estado_actividad` VALUES ('29', '4', 'Porque Juancito no le gusta', '2015-06-24 15:12:01', '22');
INSERT INTO `pat_estado_actividad` VALUES ('10', '5', '', '2015-06-24 15:51:52', '22');
INSERT INTO `pat_estado_actividad` VALUES ('10', '3', 'Se autorizó inmediatamente por crearse con usuario Administrador', '2015-06-24 15:51:53', '22');
INSERT INTO `pat_estado_actividad` VALUES ('12', '5', '', '2015-06-24 15:59:09', '22');
INSERT INTO `pat_estado_actividad` VALUES ('12', '3', 'Se autorizó inmediatamente por crearse con usuario Administrador', '2015-06-24 15:59:10', '22');
INSERT INTO `pat_estado_actividad` VALUES ('5', '5', '', '2015-06-24 15:59:12', '22');
INSERT INTO `pat_estado_actividad` VALUES ('5', '3', 'Se autorizó inmediatamente por crearse con usuario Administrador', '2015-06-24 15:59:13', '22');
INSERT INTO `pat_estado_actividad` VALUES ('29', '3', '', '2015-06-24 16:52:56', '22');
INSERT INTO `pat_estado_actividad` VALUES ('30', '1', '', '2015-06-26 09:54:15', '22');
INSERT INTO `pat_estado_actividad` VALUES ('30', '3', 'Se autorizó inmediatamente por crearse con usuario Administrador', '2015-06-26 09:54:16', '22');
INSERT INTO `pat_estado_actividad` VALUES ('31', '1', '', '2015-06-29 08:16:12', '52');
INSERT INTO `pat_estado_actividad` VALUES ('31', '5', '', '2015-06-29 08:16:20', '52');
INSERT INTO `pat_estado_actividad` VALUES ('31', '2', '', '2015-06-29 08:16:27', '52');
INSERT INTO `pat_estado_actividad` VALUES ('31', '4', 'No me gusta', '2015-06-29 08:17:00', '22');
INSERT INTO `pat_estado_actividad` VALUES ('31', '5', '', '2015-06-29 08:17:27', '52');
INSERT INTO `pat_estado_actividad` VALUES ('31', '2', '', '2015-06-29 08:18:15', '52');
INSERT INTO `pat_estado_actividad` VALUES ('31', '3', 'Todo Ok!', '2015-06-29 08:18:36', '22');
INSERT INTO `pat_estado_actividad` VALUES ('32', '1', '', '2015-06-29 09:01:58', '52');
INSERT INTO `pat_estado_actividad` VALUES ('33', '1', '', '2015-06-29 09:03:02', '52');
INSERT INTO `pat_estado_actividad` VALUES ('34', '1', '', '2015-06-29 09:04:00', '52');
INSERT INTO `pat_estado_actividad` VALUES ('34', '5', '', '2015-06-29 09:04:11', '52');
INSERT INTO `pat_estado_actividad` VALUES ('34', '2', '', '2015-06-29 09:04:15', '52');
INSERT INTO `pat_estado_actividad` VALUES ('33', '2', '', '2015-06-29 09:04:17', '52');
INSERT INTO `pat_estado_actividad` VALUES ('32', '2', '', '2015-06-29 09:04:18', '52');
INSERT INTO `pat_estado_actividad` VALUES ('32', '3', '', '2015-06-29 09:05:15', '22');
INSERT INTO `pat_estado_actividad` VALUES ('33', '4', 'Mucho dinero, reducir costos', '2015-06-29 09:05:15', '22');
INSERT INTO `pat_estado_actividad` VALUES ('33', '5', '', '2015-06-29 09:06:20', '52');
INSERT INTO `pat_estado_actividad` VALUES ('33', '2', '', '2015-06-29 09:17:05', '52');
INSERT INTO `pat_estado_actividad` VALUES ('33', '3', 'Ok! Perfecto', '2015-06-29 09:17:36', '22');
INSERT INTO `pat_estado_actividad` VALUES ('34', '3', '', '2015-06-29 09:17:36', '22');
INSERT INTO `pat_estado_actividad` VALUES ('33', '5', '', '2015-06-29 09:19:26', '22');
INSERT INTO `pat_estado_actividad` VALUES ('33', '3', 'Se autorizó inmediatamente por crearse con usuario Administrador', '2015-06-29 09:19:27', '22');

-- ----------------------------
-- Table structure for pat_indicador
-- ----------------------------
DROP TABLE IF EXISTS `pat_indicador`;
CREATE TABLE `pat_indicador` (
  `id_indicador` int(11) NOT NULL AUTO_INCREMENT,
  `id_item` int(11) NOT NULL,
  `correlativo_indicador` varchar(20) NOT NULL,
  `descripcion_indicador` text NOT NULL,
  `id_padre` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_indicador`),
  KEY `fk_item_indicador` (`id_item`),
  CONSTRAINT `fk_item_indicador` FOREIGN KEY (`id_item`) REFERENCES `pat_item` (`id_item`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pat_indicador
-- ----------------------------

-- ----------------------------
-- Table structure for pat_item
-- ----------------------------
DROP TABLE IF EXISTS `pat_item`;
CREATE TABLE `pat_item` (
  `id_item` int(11) NOT NULL AUTO_INCREMENT,
  `id_nivel` int(11) NOT NULL,
  `id_seccion` int(50) DEFAULT NULL,
  `correlativo_item` varchar(20) NOT NULL,
  `descripcion_item` text NOT NULL,
  `id_padre` int(11) DEFAULT NULL,
  `fecha_creacion` datetime NOT NULL,
  `id_usuario_crea` int(11) NOT NULL,
  `fecha_modificacion` datetime DEFAULT NULL,
  `id_usuario_modifica` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_item`),
  KEY `fk_nivel_item` (`id_nivel`),
  KEY `fk_item` (`id_padre`),
  CONSTRAINT `fk_item` FOREIGN KEY (`id_padre`) REFERENCES `pat_item` (`id_item`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_nivel_item` FOREIGN KEY (`id_nivel`) REFERENCES `pat_nivel` (`id_nivel`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=245 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pat_item
-- ----------------------------
INSERT INTO `pat_item` VALUES ('68', '18', null, 'OE1', 'Promover oportunidades de acceso a Empleo digno.', null, '2015-06-05 04:29:07', '22', '2015-06-10 20:59:57', '22');
INSERT INTO `pat_item` VALUES ('69', '18', null, 'OE2', 'Garantizar la efectiva verificación del cumplimiento de los derechos laborales y condiciones de trabajo digno.', null, '2015-06-05 04:29:07', '22', '2015-06-10 20:59:57', '22');
INSERT INTO `pat_item` VALUES ('70', '18', null, 'OE3', 'Fortalecer los mecanismos e instrumentos de diálogo entre sector empleador, trabajadoras y trabajadores.', null, '2015-06-05 04:29:07', '22', '2015-06-10 20:59:57', '22');
INSERT INTO `pat_item` VALUES ('71', '18', null, 'OE4', 'Contribuir a que el Estado Salvadoreño cumpla con los tratados internacionales en materia laboral.', null, '2015-06-05 04:29:07', '22', '2015-06-10 20:59:57', '22');
INSERT INTO `pat_item` VALUES ('72', '18', null, 'OE5', 'Posicionar al MTPS como una institución moderna, centrada en la gestión de servicios laborales de calidad, calidez, incluyentes e igualitarios.', null, '2015-06-05 04:29:07', '22', '2015-06-14 18:49:45', '22');
INSERT INTO `pat_item` VALUES ('73', '19', null, 'R1.OE1', 'Implementado el Sistema Nacional de Empleo, promoviendo el acceso a empleos.', '68', '2015-06-05 04:30:28', '22', '2015-06-10 21:07:38', '22');
INSERT INTO `pat_item` VALUES ('74', '19', null, 'R2.OE1', 'Promovida la cultura de prevención de riesgos ocupacionales con perspectiva de género.', '68', '2015-06-05 04:30:28', '22', '2015-06-10 21:07:38', '22');
INSERT INTO `pat_item` VALUES ('75', '19', null, 'R3.OE2', 'Inspecciones centradas en trabajadoras y trabajadores y en la garantía de la tutela de sus derechos fundamentales, coadyuvante al logro de un trabajo digno.', '69', '2015-06-05 04:30:28', '22', '2015-06-10 21:07:38', '22');
INSERT INTO `pat_item` VALUES ('76', '19', null, 'R4.OE3', 'Se cuenta con un mecanismo de asesoría de derechos laborales colectivos para\r\nlas Organizaciones sindicales.', '70', '2015-06-05 04:30:28', '22', '2015-06-10 21:07:38', '22');
INSERT INTO `pat_item` VALUES ('77', '19', null, 'R5.OE3', 'Fomentadas relaciones laborales respetuosas de los derechos entre personas empleadoras y trabajadoras.', '70', '2015-06-05 04:30:28', '22', '2015-06-10 21:07:38', '22');
INSERT INTO `pat_item` VALUES ('78', '19', null, 'R6.OE4', 'Impulsado el proceso de ratificación y cumplimiento de Convenios que contribuyen al fortalecimiento de los derechos laborales y de igualdad de género.', '71', '2015-06-05 04:30:28', '22', '2015-06-10 21:07:38', '22');
INSERT INTO `pat_item` VALUES ('79', '19', null, 'R7.OE4', 'El Salvador posicionado como un país que cumple los compromisos ante los organismos internacionales.', '71', '2015-06-05 04:30:28', '22', '2015-06-10 21:07:38', '22');
INSERT INTO `pat_item` VALUES ('80', '20', '22', 'I-1.R1.OE1', 'Suscrito Pacto Nacional y estrategia por el empleo y la productividad, a final de 2015', '73', '2015-06-05 04:33:30', '22', '2015-06-10 21:30:28', '22');
INSERT INTO `pat_item` VALUES ('81', '20', '22', 'I-2.R1.OE1', 'Política Nacional de Empleo aprobada y en marcha, a partir de 2016.', '73', '2015-06-05 04:33:30', '22', '2015-06-10 21:30:28', '22');
INSERT INTO `pat_item` VALUES ('82', '20', '22', 'I-3.R1.OE1', 'Política de Empleo Juvenil y Plan de Acción presentada para su aprobación en el 2015.', '73', '2015-06-05 04:33:30', '22', null, null);
INSERT INTO `pat_item` VALUES ('83', '20', '22', 'I-4.R1.OE1', 'Propuestas de reforma a la Ley de Incentivo para la creación del primer empleo de  las personas jóvenes en el sector privado, presentadas a la Asamblea Legislativa  en 2016.', '73', '2015-06-05 04:33:30', '22', '2015-06-10 21:30:28', '22');
INSERT INTO `pat_item` VALUES ('84', '20', '22', 'I-5.R1.OE1', 'Hacia el 2019, 75 mil personas estarán colocadas a través del Sistema Nacional de Empleo (SISNE), con énfasis en juventudes y mujeres.', '73', '2015-06-05 04:33:30', '22', '2015-06-10 21:30:28', '22');
INSERT INTO `pat_item` VALUES ('85', '20', '22', 'I-6.R2.OE1', 'A partir del 2015 Incrementar el acceso al autoempleo en un 25% en los municipios priorizados para la prevención de violencia.', '74', '2015-06-05 04:33:30', '22', '2015-06-09 00:59:42', '22');
INSERT INTO `pat_item` VALUES ('86', '20', '22', 'I-7.R2.OE1', 'Propuestas de Reformas a la Ley General de Prevención de Riesgos en los Lugares de Trabajo y sus Reglamentos desde una perspectiva de género, presentadas para su aprobación en 2016.', '74', '2015-06-05 04:33:30', '22', '2015-06-05 04:34:34', '22');
INSERT INTO `pat_item` VALUES ('87', '20', '22', 'I-8.R2.OE1', '100% de solicitudes de acreditación de Empresas Asesoras en Prevención de Riesgos Ocupacionales y personas naturales que solicitan acreditación como Peritos en áreas especializadas en Seguridad y Salud Ocupacional, resueltas oportunamente.', '74', '2015-06-05 04:33:30', '22', null, null);
INSERT INTO `pat_item` VALUES ('88', '20', '22', 'I-9.R3.OE2', 'Sector empleador público y privado, trabajadoras y trabajadores, asesorados técnicamente con enfoque de género para prevenir y disminuir los riesgos ocupacionales, a partir de 2015.', '75', '2015-06-05 04:33:30', '22', null, null);
INSERT INTO `pat_item` VALUES ('90', '21', null, 'A1.I-1.R1.OE1', 'Formular una estrategia de coordinación y consenso con los diferentes sectores  económicos para el Pacto Nacional por el Empleo.', '80', '2015-06-05 20:13:09', '22', '2015-06-10 22:15:49', '22');
INSERT INTO `pat_item` VALUES ('91', '21', null, 'A2.I-2.R1.OE1', 'Desarrollar un proceso de consulta para la formulación y aprobación de la Política Nacional de Empleo.', '81', '2015-06-06 15:42:13', '22', '2015-06-10 21:49:31', '22');
INSERT INTO `pat_item` VALUES ('92', '21', null, 'A3.I-3.R1.OE1', 'Desarrollar Estrategia interinstitucional y sectorial para implementar la Política y el Plan de Acción Nacional de Empleo Juvenil.', '82', '2015-06-06 16:18:11', '22', '2015-06-10 21:49:31', '22');
INSERT INTO `pat_item` VALUES ('93', '21', null, 'A4.I-4.R1.OE1', 'Desarrollar un proceso de consulta con los sectores involucrados para las  propuestas de reformas a la Ley de Incentivo para la creación del primer empleo de las personas jóvenes en el sector privado.', '83', '2015-06-06 16:18:29', '22', '2015-06-10 21:49:31', '22');
INSERT INTO `pat_item` VALUES ('94', '21', null, 'A5.I-5.R1.OE1', 'Realizar un diagnóstico de identificación de oportunidades de empleo por departamento.', '84', '2015-06-06 16:18:43', '22', '2015-06-10 21:49:31', '22');
INSERT INTO `pat_item` VALUES ('95', '21', null, 'A6.I-5.R1.OE1', 'Desarrollo de un marco de articulación interinstitucional para la implementación de programas de empleo, empleabilidad y emprendimiento.', '84', '2015-06-06 16:19:02', '22', '2015-06-10 21:49:31', '22');
INSERT INTO `pat_item` VALUES ('96', '21', null, 'A7.I-5.R1.OE1\r', 'Formular una hoja de ruta para el incremento de participación de las empresas  privadas, sector público y autónomas, que ofrecen ofertas de empleo.', '84', '2015-06-06 16:19:17', '22', '2015-06-10 21:49:31', '22');
INSERT INTO `pat_item` VALUES ('97', '21', null, 'A8.I-6.R2.OE1\r', 'Proponer reformas a los reglamentos de la Ley General de Prevención de Riesgos en los Lugares de Trabajo.', '85', '2015-06-06 16:19:28', '22', '2015-06-10 21:49:31', '22');
INSERT INTO `pat_item` VALUES ('98', '21', null, 'A9.I-7.R2.OE1', 'Establecer un protocolo para la promoción,\r\nasesoraría y supervisión del cumplimiento de la LGPRLT y sus Reglamentos, desde una perspectiva de género.', '86', '2015-06-06 16:22:02', '22', '2015-06-10 21:49:31', '22');
INSERT INTO `pat_item` VALUES ('99', '21', null, 'A10.I-8.R2.OE1', 'Revisar y actualizar el proceso de acreditación de peritos y empresas asesoras en prevención de riesgos ocupacionales.', '87', '2015-06-06 16:22:25', '22', '2015-06-10 21:49:31', '22');
INSERT INTO `pat_item` VALUES ('100', '21', null, 'A11.I-9.R3.OE2', 'Revisar y evaluar el proceso de diligencias de solicitud de inspección para su rediseño, considerando reducir los tiempos de respuesta y elaborar un Plan para el seguimiento, monitoreo y evaluación (incluye definir sistema de indicadores a evaluar).', '88', '2015-06-06 16:25:26', '22', '2015-06-10 21:49:31', '22');
INSERT INTO `pat_item` VALUES ('101', '21', null, 'A12.I-9.R3.OE2', 'Anualmente, implementar 10 planes preventivos de inspección de verificación de derechos laborales (sectoriales, territoriales, enfocados en grupos prioritarios, etc.).', '88', '2015-06-06 16:25:26', '22', '2015-06-10 21:49:31', '22');
INSERT INTO `pat_item` VALUES ('102', '21', null, 'A13.I-9.R3.OE2\r', 'Fortalecer mecanismo de diálogo y participación ciudadana.', '88', '2015-06-06 16:25:26', '22', '2015-06-10 21:49:31', '22');
INSERT INTO `pat_item` VALUES ('113', '19', null, 'R8.OE5', 'Institucionalizado el proceso de transversalización de género en el MTPS (interno y externo).', '72', '2015-06-10 21:07:38', '22', null, null);
INSERT INTO `pat_item` VALUES ('114', '19', null, 'R9.OE5', 'Fortalecida la oferta de servicios institucionales con calidad y calidez para la ciudadanía, con una administración presupuestaria eficiente.', '72', '2015-06-10 21:07:38', '22', null, null);
INSERT INTO `pat_item` VALUES ('115', '19', null, 'R10.OE5', 'Promovida la participación ciudadana, transparencia y acceso a la información pública.', '72', '2015-06-10 21:07:38', '22', null, null);
INSERT INTO `pat_item` VALUES ('116', '19', null, 'R11.OE5', 'Fortalecido el MTPS como una Institución referente de estadísticas laborales.', '72', '2015-06-10 21:07:38', '22', null, null);
INSERT INTO `pat_item` VALUES ('117', '19', null, 'R12.OE5', 'Realizado diagnóstico de reformas de ley y actualización a la normativa laboral.', '72', '2015-06-10 21:07:38', '22', null, null);
INSERT INTO `pat_item` VALUES ('124', '22', null, '', 'Actividad 1', '90', '2015-06-16 01:52:02', '22', '2015-06-23 07:52:26', '22');
INSERT INTO `pat_item` VALUES ('125', '22', null, '', 'Actividad 1', '91', '2015-06-16 02:17:02', '22', '2015-06-17 16:53:09', '22');
INSERT INTO `pat_item` VALUES ('126', '22', null, '', 'Compra de cacaguates', '90', '2015-06-16 03:01:31', '22', '2015-06-24 15:59:12', '22');
INSERT INTO `pat_item` VALUES ('127', '22', null, '', 'Actividad 5 (Compra de piñas)', '90', '2015-06-16 03:02:28', '22', '2015-06-17 16:33:57', '22');
INSERT INTO `pat_item` VALUES ('128', '22', null, '', 'Actividad 4 (Compra de piñas)', '90', '2015-06-16 03:03:32', '22', '2015-06-17 16:26:23', '22');
INSERT INTO `pat_item` VALUES ('131', '22', null, '', 'Actividad 4 (Compra de piñas)', '94', '2015-06-16 03:14:06', '22', '2015-06-24 15:51:52', '22');
INSERT INTO `pat_item` VALUES ('135', '22', null, '', 'Actividad Nueva', '90', '2015-06-18 16:43:17', '22', '2015-06-24 15:59:09', '22');
INSERT INTO `pat_item` VALUES ('138', '22', null, '', 'Actividad 2', '91', '2015-06-19 09:24:58', '22', null, null);
INSERT INTO `pat_item` VALUES ('139', '22', null, '', 'Actividad de una departamental', '101', '2015-06-19 16:59:06', '54', null, null);
INSERT INTO `pat_item` VALUES ('140', '22', null, '', 'Actividad de San Vicente', '100', '2015-06-22 15:39:49', '52', '2015-06-22 16:40:28', '22');
INSERT INTO `pat_item` VALUES ('141', '22', null, '', 'Actividad de San Vicente creada por CDI', '100', '2015-06-22 15:42:43', '22', '2015-06-24 12:10:31', '52');
INSERT INTO `pat_item` VALUES ('142', '22', null, '', 'Segunda actividad de San Vicente creada por CDI', '100', '2015-06-22 15:46:04', '22', '2015-06-24 11:56:45', '52');
INSERT INTO `pat_item` VALUES ('143', '22', null, '', 'Tercera actividad de prueba', '100', '2015-06-22 15:51:57', '22', '2015-06-24 12:02:18', '52');
INSERT INTO `pat_item` VALUES ('145', '23', null, 'A1', 'Descripción proceso A1', null, '2015-06-23 08:22:01', '22', null, null);
INSERT INTO `pat_item` VALUES ('146', '23', null, 'A2', 'Descripción proceso A2', null, '2015-06-23 08:22:01', '22', null, null);
INSERT INTO `pat_item` VALUES ('147', '23', null, 'A3', 'Descripción proceso A3', null, '2015-06-23 08:22:01', '22', null, null);
INSERT INTO `pat_item` VALUES ('148', '24', null, 'B1.A1', 'Descripción proceso B1', '145', '2015-06-23 08:23:00', '22', null, null);
INSERT INTO `pat_item` VALUES ('149', '24', null, 'B2.A1', 'Descripción proceso B2', '145', '2015-06-23 08:23:00', '22', null, null);
INSERT INTO `pat_item` VALUES ('150', '24', null, 'B3.A2', 'Descripción proceso B3', '146', '2015-06-23 08:23:00', '22', null, null);
INSERT INTO `pat_item` VALUES ('151', '24', null, 'B4.A2', 'Descripción proceso B4', '146', '2015-06-23 08:23:00', '22', null, null);
INSERT INTO `pat_item` VALUES ('152', '24', null, 'B5.A4', 'Descripción proceso B5', '171', '2015-06-23 08:23:00', '22', '2015-06-29 09:45:18', '22');
INSERT INTO `pat_item` VALUES ('153', '25', null, 'C1.B1.A1', 'Descripción proceso C1', '148', '2015-06-23 08:23:36', '22', null, null);
INSERT INTO `pat_item` VALUES ('154', '25', null, 'C2.B1.A1', 'Descripción proceso C2', '148', '2015-06-23 08:23:48', '22', null, null);
INSERT INTO `pat_item` VALUES ('155', '25', null, 'C3.B2.A1', 'Descripción proceso C3', '149', '2015-06-23 08:24:11', '22', null, null);
INSERT INTO `pat_item` VALUES ('156', '25', null, 'C4.B3.A2', 'Descripción proceso C4', '150', '2015-06-23 08:24:23', '22', null, null);
INSERT INTO `pat_item` VALUES ('157', '25', null, 'C5.B3.A2', 'Descripción proceso C5', '150', '2015-06-23 08:24:29', '22', null, null);
INSERT INTO `pat_item` VALUES ('158', '25', null, 'C6.B4.A2', 'Descripción proceso C6', '151', '2015-06-23 08:24:37', '22', null, null);
INSERT INTO `pat_item` VALUES ('159', '25', null, 'C7.B5.A3', 'Descripción proceso C7', '152', '2015-06-23 08:24:48', '22', null, null);
INSERT INTO `pat_item` VALUES ('160', '26', null, '', 'Descripción proceso D1', '153', '2015-06-23 08:35:32', '52', '2015-06-24 13:38:47', '52');
INSERT INTO `pat_item` VALUES ('161', '26', null, '', 'Descripción proceso D2', '153', '2015-06-23 08:36:53', '52', null, null);
INSERT INTO `pat_item` VALUES ('162', '26', null, '', 'Descripción proceso D3', '153', '2015-06-23 08:39:22', '52', '2015-06-23 08:39:32', '52');
INSERT INTO `pat_item` VALUES ('163', '26', null, '', 'Descripción proceso D4', '154', '2015-06-23 08:41:08', '52', null, null);
INSERT INTO `pat_item` VALUES ('164', '26', null, '', 'Descripción proceso D5', '153', '2015-06-23 08:42:44', '52', '2015-06-23 08:49:13', '52');
INSERT INTO `pat_item` VALUES ('165', '26', null, '', 'Descripción proceso D6', '154', '2015-06-23 08:48:56', '52', null, null);
INSERT INTO `pat_item` VALUES ('166', '26', null, '', 'Descripción proceso D7', '155', '2015-06-23 08:51:16', '52', null, null);
INSERT INTO `pat_item` VALUES ('167', '26', null, '', 'Descripción proceso D8', '156', '2015-06-23 08:51:43', '52', null, null);
INSERT INTO `pat_item` VALUES ('168', '26', null, '', 'Descripción proceso D9', '157', '2015-06-23 08:52:34', '52', null, null);
INSERT INTO `pat_item` VALUES ('169', '26', null, '', 'Descripción proceso D10', '157', '2015-06-23 08:53:07', '52', '2015-06-24 12:12:42', '52');
INSERT INTO `pat_item` VALUES ('170', '26', null, '', 'Descripción proceso D15', '153', '2015-06-24 15:08:24', '52', '2015-06-24 15:09:59', '52');
INSERT INTO `pat_item` VALUES ('171', '23', '5', 'A4', 'Descripción proceso A4', null, '2015-06-25 15:46:10', '22', '2015-06-29 09:26:04', '22');
INSERT INTO `pat_item` VALUES ('172', '23', null, 'A5', 'Descripción proceso A5', null, '2015-06-25 16:28:12', '22', null, null);
INSERT INTO `pat_item` VALUES ('173', '23', null, 'A6', 'Descripción proceso A6', null, '2015-06-25 16:29:42', '22', '2015-06-29 09:26:11', '22');
INSERT INTO `pat_item` VALUES ('174', '23', null, 'A7', 'Descripción proceso A7', null, '2015-06-25 16:30:10', '22', '2015-06-29 09:26:16', '22');
INSERT INTO `pat_item` VALUES ('175', '23', null, 'A8', 'Descripción proceso A8', null, '2015-06-25 16:31:49', '22', '2015-06-29 09:26:22', '22');
INSERT INTO `pat_item` VALUES ('190', '22', null, '', 'Actividad de prueba para ver si guarda el año de la actividad', '97', '2015-06-26 09:54:15', '22', null, null);
INSERT INTO `pat_item` VALUES ('192', '23', null, 'A9', 'Descripción proceso A9', null, '2015-06-29 07:35:49', '22', '2015-06-29 09:32:23', '22');
INSERT INTO `pat_item` VALUES ('193', '23', null, 'A10', 'Descripción proceso A10', null, '2015-06-29 07:36:53', '22', null, null);
INSERT INTO `pat_item` VALUES ('232', '22', null, '', 'Actividad Nueva', '102', '2015-06-29 08:16:12', '52', '2015-06-29 08:17:27', '52');
INSERT INTO `pat_item` VALUES ('233', '27', null, 'T1', 'Sistema Informático para MTPS', null, '2015-06-29 08:50:00', '22', null, null);
INSERT INTO `pat_item` VALUES ('234', '28', null, 'OG1.T1', 'Desarrollar Sistema Informático para MTPS', '233', '2015-06-29 08:51:04', '22', null, null);
INSERT INTO `pat_item` VALUES ('235', '29', null, 'OE1.OG1.T1', 'Planificar Documentación', '234', '2015-06-29 08:51:26', '22', null, null);
INSERT INTO `pat_item` VALUES ('236', '29', null, 'OE2.OG1.T1', 'Planificar desarrollo de sistema', '234', '2015-06-29 08:51:39', '22', null, null);
INSERT INTO `pat_item` VALUES ('237', '30', null, 'A1.OE1.OG1.T1', 'Hacer Perfil', '235', '2015-06-29 08:52:04', '22', null, null);
INSERT INTO `pat_item` VALUES ('238', '30', null, 'A2.OE1.OG1.T1', 'Hacer anteproyecto', '235', '2015-06-29 08:52:16', '22', null, null);
INSERT INTO `pat_item` VALUES ('239', '30', null, 'A3.OE2.OG1.T1', 'Hacer análisis', '236', '2015-06-29 08:52:34', '22', null, null);
INSERT INTO `pat_item` VALUES ('240', '30', null, 'A4.OE2.OG1.T1', 'Hacer diseño', '236', '2015-06-29 08:52:49', '22', null, null);
INSERT INTO `pat_item` VALUES ('241', '30', null, 'A5.OE2.OG1.T1', 'Programación', '236', '2015-06-29 08:53:09', '22', null, null);
INSERT INTO `pat_item` VALUES ('242', '31', null, '', 'Escribir Marco Teórico', '238', '2015-06-29 09:01:58', '52', null, null);
INSERT INTO `pat_item` VALUES ('243', '31', null, '', 'Describir Diseño a utilizar', '238', '2015-06-29 09:03:02', '52', '2015-06-29 09:19:26', '22');
INSERT INTO `pat_item` VALUES ('244', '31', null, '', 'Definir APA a utilizar', '238', '2015-06-29 09:04:00', '52', '2015-06-29 09:04:11', '52');

-- ----------------------------
-- Table structure for pat_item_seccion
-- ----------------------------
DROP TABLE IF EXISTS `pat_item_seccion`;
CREATE TABLE `pat_item_seccion` (
  `id_item` int(11) NOT NULL,
  `id_seccion` int(11) NOT NULL,
  `id_tipo_apoyo` int(11) NOT NULL,
  KEY `fk_unidad_item` (`id_item`),
  CONSTRAINT `fk_unidad_item` FOREIGN KEY (`id_item`) REFERENCES `pat_item` (`id_item`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pat_item_seccion
-- ----------------------------
INSERT INTO `pat_item_seccion` VALUES ('90', '42', '1');
INSERT INTO `pat_item_seccion` VALUES ('91', '42', '1');
INSERT INTO `pat_item_seccion` VALUES ('92', '40', '1');
INSERT INTO `pat_item_seccion` VALUES ('93', '42', '1');
INSERT INTO `pat_item_seccion` VALUES ('93', '1', '2');
INSERT INTO `pat_item_seccion` VALUES ('94', '42', '1');
INSERT INTO `pat_item_seccion` VALUES ('95', '42', '1');
INSERT INTO `pat_item_seccion` VALUES ('96', '42', '1');
INSERT INTO `pat_item_seccion` VALUES ('97', '42', '1');
INSERT INTO `pat_item_seccion` VALUES ('97', '37', '2');
INSERT INTO `pat_item_seccion` VALUES ('97', '116', '2');
INSERT INTO `pat_item_seccion` VALUES ('98', '42', '1');
INSERT INTO `pat_item_seccion` VALUES ('98', '37', '2');
INSERT INTO `pat_item_seccion` VALUES ('98', '116', '2');
INSERT INTO `pat_item_seccion` VALUES ('99', '42', '1');
INSERT INTO `pat_item_seccion` VALUES ('99', '107', '2');
INSERT INTO `pat_item_seccion` VALUES ('101', '37', '1');
INSERT INTO `pat_item_seccion` VALUES ('101', '10000', '1');
INSERT INTO `pat_item_seccion` VALUES ('101', '10001', '1');
INSERT INTO `pat_item_seccion` VALUES ('102', '37', '1');
INSERT INTO `pat_item_seccion` VALUES ('102', '10000', '1');
INSERT INTO `pat_item_seccion` VALUES ('102', '10001', '1');
INSERT INTO `pat_item_seccion` VALUES ('102', '107', '2');
INSERT INTO `pat_item_seccion` VALUES ('153', '107', '1');
INSERT INTO `pat_item_seccion` VALUES ('153', '10000', '1');
INSERT INTO `pat_item_seccion` VALUES ('153', '10001', '1');
INSERT INTO `pat_item_seccion` VALUES ('154', '107', '1');
INSERT INTO `pat_item_seccion` VALUES ('154', '10000', '1');
INSERT INTO `pat_item_seccion` VALUES ('154', '10001', '1');
INSERT INTO `pat_item_seccion` VALUES ('155', '107', '1');
INSERT INTO `pat_item_seccion` VALUES ('155', '10000', '1');
INSERT INTO `pat_item_seccion` VALUES ('155', '10001', '1');
INSERT INTO `pat_item_seccion` VALUES ('156', '107', '1');
INSERT INTO `pat_item_seccion` VALUES ('156', '10000', '1');
INSERT INTO `pat_item_seccion` VALUES ('156', '10001', '1');
INSERT INTO `pat_item_seccion` VALUES ('157', '107', '1');
INSERT INTO `pat_item_seccion` VALUES ('157', '10000', '1');
INSERT INTO `pat_item_seccion` VALUES ('157', '10001', '1');
INSERT INTO `pat_item_seccion` VALUES ('158', '107', '1');
INSERT INTO `pat_item_seccion` VALUES ('159', '107', '1');
INSERT INTO `pat_item_seccion` VALUES ('237', '107', '1');
INSERT INTO `pat_item_seccion` VALUES ('238', '107', '1');
INSERT INTO `pat_item_seccion` VALUES ('238', '10000', '2');
INSERT INTO `pat_item_seccion` VALUES ('238', '10001', '2');
INSERT INTO `pat_item_seccion` VALUES ('239', '42', '1');
INSERT INTO `pat_item_seccion` VALUES ('239', '107', '1');
INSERT INTO `pat_item_seccion` VALUES ('239', '10000', '2');
INSERT INTO `pat_item_seccion` VALUES ('239', '10001', '2');
INSERT INTO `pat_item_seccion` VALUES ('240', '10000', '1');
INSERT INTO `pat_item_seccion` VALUES ('240', '10001', '1');
INSERT INTO `pat_item_seccion` VALUES ('241', '10000', '1');
INSERT INTO `pat_item_seccion` VALUES ('241', '10001', '1');
INSERT INTO `pat_item_seccion` VALUES ('100', '37', '1');
INSERT INTO `pat_item_seccion` VALUES ('100', '10000', '1');
INSERT INTO `pat_item_seccion` VALUES ('100', '10001', '1');
INSERT INTO `pat_item_seccion` VALUES ('100', '107', '2');
INSERT INTO `pat_item_seccion` VALUES ('100', '116', '2');

-- ----------------------------
-- Table structure for pat_logro
-- ----------------------------
DROP TABLE IF EXISTS `pat_logro`;
CREATE TABLE `pat_logro` (
  `id_logro` int(11) NOT NULL AUTO_INCREMENT,
  `id_actividad` int(11) NOT NULL,
  `mes_logro` int(11) NOT NULL,
  `anio_logro` int(11) NOT NULL,
  `cantidad_logro` int(11) NOT NULL,
  `gasto_logro` float NOT NULL DEFAULT '0',
  `observaciones_logro` text,
  `fecha_creacion` datetime NOT NULL,
  `id_usuario_crea` int(11) NOT NULL,
  `fecha_modificacion` datetime DEFAULT NULL,
  `id_usuario_modifica` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_logro`),
  KEY `fk_logro_actividad` (`id_actividad`),
  CONSTRAINT `fk_logro_actividad` FOREIGN KEY (`id_actividad`) REFERENCES `pat_actividad` (`id_actividad`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pat_logro
-- ----------------------------
INSERT INTO `pat_logro` VALUES ('1', '15', '6', '2015', '70', '0', null, '2015-06-25 09:23:47', '22', '2015-06-25 12:49:24', '52');
INSERT INTO `pat_logro` VALUES ('2', '17', '6', '2015', '15', '0', null, '2015-06-25 09:23:47', '22', '2015-06-25 11:48:34', '22');
INSERT INTO `pat_logro` VALUES ('9', '20', '6', '2015', '9', '0', null, '2015-06-25 12:02:38', '52', '2015-06-25 12:35:44', '22');
INSERT INTO `pat_logro` VALUES ('11', '25', '6', '2015', '10001', '0', null, '2015-06-25 12:03:17', '52', '2015-06-25 12:50:44', '22');
INSERT INTO `pat_logro` VALUES ('14', '21', '6', '2015', '13', '0', null, '2015-06-25 12:35:44', '22', null, null);
INSERT INTO `pat_logro` VALUES ('15', '19', '5', '2015', '115', '0', null, '2015-06-25 12:39:58', '22', null, null);
INSERT INTO `pat_logro` VALUES ('16', '24', '4', '2015', '450', '0', null, '2015-06-25 12:41:01', '22', null, null);
INSERT INTO `pat_logro` VALUES ('17', '19', '4', '2015', '11', '0', null, '2015-06-25 12:41:13', '22', null, null);
INSERT INTO `pat_logro` VALUES ('18', '24', '1', '2015', '200', '0', null, '2015-06-25 12:42:12', '22', null, null);
INSERT INTO `pat_logro` VALUES ('19', '25', '1', '2015', '200', '0', null, '2015-06-25 12:42:20', '22', null, null);
INSERT INTO `pat_logro` VALUES ('20', '19', '2', '2015', '9', '0', null, '2015-06-25 12:42:54', '22', null, null);
INSERT INTO `pat_logro` VALUES ('21', '20', '2', '2015', '1', '0', null, '2015-06-25 12:43:01', '22', null, null);
INSERT INTO `pat_logro` VALUES ('22', '20', '3', '2015', '1', '0', null, '2015-06-25 12:44:37', '22', null, null);
INSERT INTO `pat_logro` VALUES ('23', '15', '1', '2015', '10', '0', null, '2015-06-25 12:45:19', '22', '2015-06-25 12:45:27', '22');
INSERT INTO `pat_logro` VALUES ('24', '17', '1', '2015', '3', '0', null, '2015-06-25 12:45:22', '22', null, null);
INSERT INTO `pat_logro` VALUES ('25', '17', '2', '2015', '422', '0', null, '2015-06-25 12:48:55', '22', null, null);
INSERT INTO `pat_logro` VALUES ('26', '15', '3', '2015', '18', '0', null, '2015-06-25 12:49:10', '22', null, null);
INSERT INTO `pat_logro` VALUES ('27', '23', '6', '2015', '99', '0', null, '2015-06-25 12:49:39', '52', null, null);
INSERT INTO `pat_logro` VALUES ('28', '3', '6', '2015', '7', '0', null, '2015-06-25 13:12:33', '22', null, null);
INSERT INTO `pat_logro` VALUES ('29', '7', '6', '2015', '1', '0', null, '2015-06-25 13:17:28', '22', '2015-06-25 13:17:40', '22');
INSERT INTO `pat_logro` VALUES ('30', '5', '6', '2015', '9', '0', null, '2015-06-26 11:33:41', '22', null, null);
INSERT INTO `pat_logro` VALUES ('31', '5', '5', '2015', '0', '0', null, '2015-06-26 11:33:56', '22', '2015-06-26 14:05:03', '22');
INSERT INTO `pat_logro` VALUES ('32', '3', '5', '2015', '12', '0', null, '2015-06-26 14:05:03', '22', null, null);
INSERT INTO `pat_logro` VALUES ('33', '4', '5', '2015', '88', '0', 'Prueba de Observaciones', '2015-06-26 14:31:36', '22', '2015-06-26 14:42:08', '22');
INSERT INTO `pat_logro` VALUES ('40', '31', '6', '2015', '42', '0', '', '2015-06-29 08:28:04', '22', null, null);
INSERT INTO `pat_logro` VALUES ('41', '32', '6', '2015', '1', '0', '', '2015-06-29 09:18:22', '52', null, null);
INSERT INTO `pat_logro` VALUES ('42', '33', '6', '2015', '0', '0', '', '2015-06-29 09:18:22', '52', '2015-06-29 09:18:32', '52');

-- ----------------------------
-- Table structure for pat_nivel
-- ----------------------------
DROP TABLE IF EXISTS `pat_nivel`;
CREATE TABLE `pat_nivel` (
  `id_nivel` int(11) NOT NULL AUTO_INCREMENT,
  `id_documento` int(11) NOT NULL,
  `tipo_nivel` int(11) NOT NULL,
  `nivel` int(11) NOT NULL,
  `nombre_nivel` varchar(250) NOT NULL,
  `indicador` int(11) NOT NULL,
  `abreviacion` varchar(10) NOT NULL,
  `id_padre` int(11) DEFAULT NULL,
  `agrupar_numeracion` int(11) NOT NULL DEFAULT '1',
  `agregar_separador` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_nivel`),
  KEY `fk_documento_nivel` (`id_documento`),
  KEY `fk_nivel` (`id_padre`),
  CONSTRAINT `fk_documento_nivel` FOREIGN KEY (`id_documento`) REFERENCES `pat_documento` (`id_documento`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_nivel` FOREIGN KEY (`id_padre`) REFERENCES `pat_nivel` (`id_nivel`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pat_nivel
-- ----------------------------
INSERT INTO `pat_nivel` VALUES ('18', '7', '1', '1', 'OBJETIVOS ESTRATÉGICOS', '0', 'OE', null, '1', '0');
INSERT INTO `pat_nivel` VALUES ('19', '7', '1', '2', 'RESULTADOS ESTRATÉGICOS', '0', 'R', '18', '0', '0');
INSERT INTO `pat_nivel` VALUES ('20', '7', '1', '3', 'INDICADORES ESTRATÉGICOS', '0', 'I', '19', '0', '1');
INSERT INTO `pat_nivel` VALUES ('21', '7', '1', '4', 'ACCIONES ESTRATÉGICAS', '1', 'A', '20', '0', '0');
INSERT INTO `pat_nivel` VALUES ('22', '7', '2', '1', 'ACTIVIDADES', '0', 'AC', '21', '0', '0');
INSERT INTO `pat_nivel` VALUES ('23', '8', '1', '1', 'Proceso A', '0', 'A', null, '0', '0');
INSERT INTO `pat_nivel` VALUES ('24', '8', '1', '2', 'Proceso B', '0', 'B', '23', '0', '0');
INSERT INTO `pat_nivel` VALUES ('25', '8', '1', '3', 'Proceso C', '1', 'C', '24', '0', '0');
INSERT INTO `pat_nivel` VALUES ('26', '8', '2', '1', 'Proceso D ', '0', 'D', '25', '1', '0');
INSERT INTO `pat_nivel` VALUES ('27', '9', '1', '1', 'TEMA', '0', 'T', null, '1', '0');
INSERT INTO `pat_nivel` VALUES ('28', '9', '1', '2', 'OBJETIVO GENERAL', '0', 'OG', '27', '1', '0');
INSERT INTO `pat_nivel` VALUES ('29', '9', '1', '3', 'OBJETIVOS ESPECIFICOS', '0', 'OE', '28', '1', '0');
INSERT INTO `pat_nivel` VALUES ('30', '9', '1', '4', 'ALCANCES', '1', 'A', '29', '0', '0');
INSERT INTO `pat_nivel` VALUES ('31', '9', '2', '1', 'TAREA      ', '0', 'TA', '30', '1', '0');

-- ----------------------------
-- Table structure for pat_presupuesto
-- ----------------------------
DROP TABLE IF EXISTS `pat_presupuesto`;
CREATE TABLE `pat_presupuesto` (
  `id_presupuesto` int(11) NOT NULL AUTO_INCREMENT,
  `id_item` int(11) NOT NULL,
  `clasificacion_gasto` varchar(255) DEFAULT NULL,
  `anio` int(11) NOT NULL,
  `presupuesto` decimal(18,2) NOT NULL,
  `fecha_creacion` datetime NOT NULL,
  `id_usuario_crea` int(11) NOT NULL,
  `fecha_modificacion` datetime DEFAULT NULL,
  `id_usuario_modifica` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_presupuesto`),
  KEY `fk_presupuesto_item` (`id_item`),
  CONSTRAINT `fk_presupuesto_item` FOREIGN KEY (`id_item`) REFERENCES `pat_item` (`id_item`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=145 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pat_presupuesto
-- ----------------------------
INSERT INTO `pat_presupuesto` VALUES ('1', '90', '', '2015', '400000.00', '2015-06-06 17:22:04', '22', '2015-06-10 23:13:45', '22');
INSERT INTO `pat_presupuesto` VALUES ('6', '91', '', '2015', '300000.00', '2015-06-06 17:50:57', '22', '2015-06-10 23:14:19', '22');
INSERT INTO `pat_presupuesto` VALUES ('11', '92', '', '2015', '300000.00', '2015-06-06 17:51:19', '22', '2015-06-10 23:14:39', '22');
INSERT INTO `pat_presupuesto` VALUES ('17', '93', '', '2016', '300000.00', '2015-06-06 17:51:34', '22', '2015-06-10 23:15:55', '22');
INSERT INTO `pat_presupuesto` VALUES ('28', '95', '', '2017', '300000.00', '2015-06-06 17:52:21', '22', '2015-06-10 23:17:44', '22');
INSERT INTO `pat_presupuesto` VALUES ('34', '96', '', '2018', '300000.00', '2015-06-06 17:52:58', '22', '2015-06-10 23:18:28', '22');
INSERT INTO `pat_presupuesto` VALUES ('45', '98', '', '2019', '300000.00', '2015-06-06 17:53:29', '22', '2015-06-10 23:21:26', '22');
INSERT INTO `pat_presupuesto` VALUES ('46', '99', '', '2015', '300000.00', '2015-06-06 17:54:59', '22', '2015-06-10 23:22:15', '22');
INSERT INTO `pat_presupuesto` VALUES ('52', '100', '', '2016', '300000.00', '2015-06-06 17:55:42', '22', '2015-06-29 09:57:51', '22');
INSERT INTO `pat_presupuesto` VALUES ('53', '100', '', '2017', '300000.00', '2015-06-06 17:55:42', '22', '2015-06-29 09:57:51', '22');
INSERT INTO `pat_presupuesto` VALUES ('54', '100', '', '2018', '300000.00', '2015-06-06 17:55:42', '22', '2015-06-29 09:57:51', '22');
INSERT INTO `pat_presupuesto` VALUES ('55', '100', '', '2019', '300000.00', '2015-06-06 17:55:42', '22', '2015-06-29 09:57:51', '22');
INSERT INTO `pat_presupuesto` VALUES ('58', '101', '', '2017', '300000.00', '2015-06-06 17:55:55', '22', '2015-06-10 23:29:32', '22');
INSERT INTO `pat_presupuesto` VALUES ('65', '102', '', '2019', '300000.00', '2015-06-06 17:56:11', '22', '2015-06-10 23:31:44', '22');
INSERT INTO `pat_presupuesto` VALUES ('70', '91', '', '2016', '300000.00', '2015-06-10 23:14:19', '22', null, null);
INSERT INTO `pat_presupuesto` VALUES ('71', '92', '', '2016', '300000.00', '2015-06-10 23:14:39', '22', null, null);
INSERT INTO `pat_presupuesto` VALUES ('72', '93', '', '2015', '300000.00', '2015-06-10 23:15:55', '22', null, null);
INSERT INTO `pat_presupuesto` VALUES ('73', '94', '', '2015', '300000.00', '2015-06-10 23:16:14', '22', null, null);
INSERT INTO `pat_presupuesto` VALUES ('74', '94', '', '2016', '300000.00', '2015-06-10 23:16:14', '22', null, null);
INSERT INTO `pat_presupuesto` VALUES ('75', '97', '', '2015', '300000.00', '2015-06-10 23:16:46', '22', '2015-06-10 23:20:47', '22');
INSERT INTO `pat_presupuesto` VALUES ('76', '97', '', '2016', '300000.00', '2015-06-10 23:16:46', '22', '2015-06-10 23:20:47', '22');
INSERT INTO `pat_presupuesto` VALUES ('79', '95', '', '2015', '300000.00', '2015-06-10 23:17:44', '22', null, null);
INSERT INTO `pat_presupuesto` VALUES ('80', '95', '', '2016', '300000.00', '2015-06-10 23:17:44', '22', null, null);
INSERT INTO `pat_presupuesto` VALUES ('81', '95', '', '2018', '300000.00', '2015-06-10 23:17:44', '22', null, null);
INSERT INTO `pat_presupuesto` VALUES ('82', '95', '', '2019', '300000.00', '2015-06-10 23:17:44', '22', null, null);
INSERT INTO `pat_presupuesto` VALUES ('83', '96', '', '2015', '300000.00', '2015-06-10 23:18:28', '22', null, null);
INSERT INTO `pat_presupuesto` VALUES ('84', '96', '', '2016', '300000.00', '2015-06-10 23:18:28', '22', null, null);
INSERT INTO `pat_presupuesto` VALUES ('85', '96', '', '2017', '300000.00', '2015-06-10 23:18:28', '22', null, null);
INSERT INTO `pat_presupuesto` VALUES ('86', '96', '', '2019', '300000.00', '2015-06-10 23:18:28', '22', null, null);
INSERT INTO `pat_presupuesto` VALUES ('87', '98', '', '2015', '300000.00', '2015-06-10 23:21:26', '22', null, null);
INSERT INTO `pat_presupuesto` VALUES ('88', '98', '', '2016', '300000.00', '2015-06-10 23:21:26', '22', null, null);
INSERT INTO `pat_presupuesto` VALUES ('89', '98', '', '2017', '300000.00', '2015-06-10 23:21:26', '22', null, null);
INSERT INTO `pat_presupuesto` VALUES ('90', '98', '', '2018', '300000.00', '2015-06-10 23:21:26', '22', null, null);
INSERT INTO `pat_presupuesto` VALUES ('91', '99', '', '2016', '300000.00', '2015-06-10 23:22:15', '22', null, null);
INSERT INTO `pat_presupuesto` VALUES ('93', '101', '', '2015', '300000.00', '2015-06-10 23:25:23', '22', '2015-06-10 23:29:32', '22');
INSERT INTO `pat_presupuesto` VALUES ('94', '101', '', '2016', '300000.00', '2015-06-10 23:25:23', '22', '2015-06-10 23:29:32', '22');
INSERT INTO `pat_presupuesto` VALUES ('95', '101', '', '2018', '300000.00', '2015-06-10 23:25:23', '22', '2015-06-10 23:29:32', '22');
INSERT INTO `pat_presupuesto` VALUES ('96', '101', '', '2019', '300000.00', '2015-06-10 23:25:23', '22', '2015-06-10 23:29:32', '22');
INSERT INTO `pat_presupuesto` VALUES ('97', '102', '', '2015', '300000.00', '2015-06-10 23:25:52', '22', '2015-06-10 23:31:44', '22');
INSERT INTO `pat_presupuesto` VALUES ('98', '102', '', '2016', '300000.00', '2015-06-10 23:25:52', '22', '2015-06-10 23:31:44', '22');
INSERT INTO `pat_presupuesto` VALUES ('99', '102', '', '2017', '300000.00', '2015-06-10 23:25:52', '22', '2015-06-10 23:31:44', '22');
INSERT INTO `pat_presupuesto` VALUES ('100', '102', '', '2018', '300000.00', '2015-06-10 23:25:52', '22', '2015-06-10 23:31:44', '22');
INSERT INTO `pat_presupuesto` VALUES ('101', '153', '', '2021', '10000.00', '2015-06-23 08:26:25', '22', null, null);
INSERT INTO `pat_presupuesto` VALUES ('102', '153', '', '2022', '10000.00', '2015-06-23 08:26:25', '22', null, null);
INSERT INTO `pat_presupuesto` VALUES ('103', '153', '', '2023', '10000.00', '2015-06-23 08:26:25', '22', null, null);
INSERT INTO `pat_presupuesto` VALUES ('104', '153', '', '2024', '10000.00', '2015-06-23 08:26:25', '22', null, null);
INSERT INTO `pat_presupuesto` VALUES ('105', '153', '', '2025', '10000.00', '2015-06-23 08:26:25', '22', null, null);
INSERT INTO `pat_presupuesto` VALUES ('106', '154', '', '2021', '10500.00', '2015-06-23 08:27:09', '22', null, null);
INSERT INTO `pat_presupuesto` VALUES ('107', '154', '', '2022', '10500.00', '2015-06-23 08:27:09', '22', null, null);
INSERT INTO `pat_presupuesto` VALUES ('108', '154', '', '2023', '10500.00', '2015-06-23 08:27:09', '22', null, null);
INSERT INTO `pat_presupuesto` VALUES ('109', '154', '', '2024', '10500.00', '2015-06-23 08:27:09', '22', null, null);
INSERT INTO `pat_presupuesto` VALUES ('110', '154', '', '2025', '10500.00', '2015-06-23 08:27:09', '22', null, null);
INSERT INTO `pat_presupuesto` VALUES ('111', '155', '', '2021', '11000.00', '2015-06-23 08:27:45', '22', null, null);
INSERT INTO `pat_presupuesto` VALUES ('112', '155', '', '2022', '11000.00', '2015-06-23 08:27:45', '22', null, null);
INSERT INTO `pat_presupuesto` VALUES ('113', '155', '', '2023', '11000.00', '2015-06-23 08:27:45', '22', null, null);
INSERT INTO `pat_presupuesto` VALUES ('114', '155', '', '2024', '11000.00', '2015-06-23 08:27:45', '22', null, null);
INSERT INTO `pat_presupuesto` VALUES ('115', '155', '', '2025', '11000.00', '2015-06-23 08:27:45', '22', null, null);
INSERT INTO `pat_presupuesto` VALUES ('116', '156', '', '2021', '11500.00', '2015-06-23 08:28:16', '22', null, null);
INSERT INTO `pat_presupuesto` VALUES ('117', '156', '', '2022', '11500.00', '2015-06-23 08:28:16', '22', null, null);
INSERT INTO `pat_presupuesto` VALUES ('118', '156', '', '2023', '11500.00', '2015-06-23 08:28:16', '22', null, null);
INSERT INTO `pat_presupuesto` VALUES ('119', '156', '', '2024', '11500.00', '2015-06-23 08:28:16', '22', null, null);
INSERT INTO `pat_presupuesto` VALUES ('120', '156', '', '2025', '11500.00', '2015-06-23 08:28:16', '22', null, null);
INSERT INTO `pat_presupuesto` VALUES ('121', '157', '', '2021', '12000.00', '2015-06-23 08:29:03', '22', null, null);
INSERT INTO `pat_presupuesto` VALUES ('122', '157', '', '2022', '12000.00', '2015-06-23 08:29:03', '22', null, null);
INSERT INTO `pat_presupuesto` VALUES ('123', '157', '', '2023', '12000.00', '2015-06-23 08:29:03', '22', null, null);
INSERT INTO `pat_presupuesto` VALUES ('124', '157', '', '2024', '12000.00', '2015-06-23 08:29:03', '22', null, null);
INSERT INTO `pat_presupuesto` VALUES ('125', '157', '', '2025', '12000.00', '2015-06-23 08:29:03', '22', null, null);
INSERT INTO `pat_presupuesto` VALUES ('126', '158', '', '2021', '15000.00', '2015-06-23 08:29:34', '22', null, null);
INSERT INTO `pat_presupuesto` VALUES ('127', '158', '', '2022', '15000.00', '2015-06-23 08:29:34', '22', null, null);
INSERT INTO `pat_presupuesto` VALUES ('128', '158', '', '2023', '15000.00', '2015-06-23 08:29:34', '22', null, null);
INSERT INTO `pat_presupuesto` VALUES ('129', '158', '', '2024', '15000.00', '2015-06-23 08:29:34', '22', null, null);
INSERT INTO `pat_presupuesto` VALUES ('130', '158', '', '2025', '15000.00', '2015-06-23 08:29:34', '22', null, null);
INSERT INTO `pat_presupuesto` VALUES ('131', '159', '', '2021', '20000.00', '2015-06-23 08:29:54', '22', null, null);
INSERT INTO `pat_presupuesto` VALUES ('132', '159', '', '2022', '20000.00', '2015-06-23 08:29:54', '22', null, null);
INSERT INTO `pat_presupuesto` VALUES ('133', '159', '', '2023', '20000.00', '2015-06-23 08:29:54', '22', null, null);
INSERT INTO `pat_presupuesto` VALUES ('134', '159', '', '2024', '20000.00', '2015-06-23 08:29:54', '22', null, null);
INSERT INTO `pat_presupuesto` VALUES ('135', '159', '', '2025', '20000.00', '2015-06-23 08:29:54', '22', null, null);
INSERT INTO `pat_presupuesto` VALUES ('136', '237', '', '2015', '1000.00', '2015-06-29 08:54:39', '22', null, null);
INSERT INTO `pat_presupuesto` VALUES ('137', '238', '', '2015', '30000.00', '2015-06-29 08:55:28', '22', null, null);
INSERT INTO `pat_presupuesto` VALUES ('138', '238', '', '2016', '30000.00', '2015-06-29 08:55:28', '22', null, null);
INSERT INTO `pat_presupuesto` VALUES ('139', '239', '', '2016', '40000.00', '2015-06-29 08:56:17', '22', null, null);
INSERT INTO `pat_presupuesto` VALUES ('140', '240', '', '2017', '10000.00', '2015-06-29 08:57:11', '22', null, null);
INSERT INTO `pat_presupuesto` VALUES ('141', '240', '', '2018', '10000.00', '2015-06-29 08:57:11', '22', null, null);
INSERT INTO `pat_presupuesto` VALUES ('142', '241', '', '2018', '50000.00', '2015-06-29 08:57:41', '22', null, null);
INSERT INTO `pat_presupuesto` VALUES ('143', '241', '', '2019', '50000.00', '2015-06-29 08:57:41', '22', null, null);
INSERT INTO `pat_presupuesto` VALUES ('144', '100', '', '2015', '300000.00', '2015-06-29 09:57:51', '22', null, null);
