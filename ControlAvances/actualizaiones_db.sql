INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) 
VALUES (63, 'Historial de Facturas devueltas', '46', '6', 'salud_registro_devoluciones_facturas.php', '_SELF', b'1', 'historial.png', '1', '2018-08-03 23:54:16', '2018-07-13 15:42:34');

INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES
(64, 'Circular 014', 40, 6, 'salud_genere_circular_030.php', '_SELF', b'1', 'listasprecios.png', 6, '2018-09-03 11:49:36', '2018-07-13 15:42:34');

ALTER TABLE `salud_archivo_conceptos_glosas` ADD `descripcion_concepto_general` TEXT NOT NULL AFTER `cod_concepto_general`, ADD `tipo_concepto_general` VARCHAR(30) NOT NULL AFTER `descripcion_concepto_general`;
ALTER TABLE `salud_archivo_conceptos_glosas` ADD `aplicacion_concepto_general` TEXT NOT NULL AFTER `tipo_concepto_general`;

ALTER TABLE `usuarios` ADD `Habilitado` VARCHAR(2) NOT NULL DEFAULT 'SI' AFTER `Email`;

ALTER TABLE `salud_glosas_iniciales_temp` ADD `idUser` INT NOT NULL AFTER `Soporte`;

ALTER TABLE `salud_cups` CHANGE `ID` `ID` INT(20) NOT NULL AUTO_INCREMENT;

INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (65, 'Crear politicas de Acceso', '2', '3', 'CrearPoliticasAcceso.php', '_SELF', b'1', 'seguridadinformatica.png', '5', '2018-07-13 15:42:34', '2018-07-13 15:42:34');

UPDATE `menu_submenus` SET `Image` = 'historial2.png' WHERE `menu_submenus`.`ID` = 11;
UPDATE `menu_submenus` SET `Nombre` = 'Consolidado de Politicas de Acceso' WHERE `menu_submenus`.`ID` = 11;

DELETE FROM `menu_submenus` WHERE `menu_submenus`.`ID` = 2 

ALTER TABLE `salud_eps`
  DROP `saldo_inicial`,
  DROP `fecha_saldo_inicial`;

ALTER TABLE `salud_eps` ADD `RepresentanteLegal` VARCHAR(45) NOT NULL AFTER `Nombre_gerente`, ADD `NumeroRepresentanteLegal` VARCHAR(45) NOT NULL AFTER `RepresentanteLegal`;

DROP TABLE IF EXISTS `salud_manuales_tarifarios`;
CREATE TABLE `salud_manuales_tarifarios` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `salud_manuales_tarifarios` (`ID`, `Nombre`) VALUES
(1,	'SOAT'),
(2,	'CUPS'),
(3,	'ISS 2004'),
(4,	'Medicamentos'),
(5,	'Insumos'),
(6,	'ISS'),
(7,	'Act propias');

ALTER TABLE `salud_cups` ADD `Manual` INT NOT NULL DEFAULT '2' AFTER `descripcion_cups`;

DROP TABLE IF EXISTS `salud_regimen`;
CREATE TABLE `salud_regimen` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Regimen` varchar(45) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `salud_regimen` (`ID`, `Regimen`) VALUES
(1,	'CONTRIBUTIVO'),
(2,	'SUBSIDIADO'),
(3,	'OTRAS ENTIDADES'),
(4,	'ENTE TERRITORIAL'),
(5,	'ENTE MUNICIPAL'),
(6,	'ENTIDAD EN LIQUIDACION');


ALTER TABLE `salud_archivo_control_glosas_respuestas` ADD `EstadoGlosaHistorico` INT(3) NOT NULL AFTER `Tratado`;

DROP TABLE IF EXISTS `salud_upload_control_ct`;
CREATE TABLE `salud_upload_control_ct` (
  `id_upload_control` bigint(20) NOT NULL AUTO_INCREMENT,
  `nom_cargue` varchar(45) COLLATE latin1_spanish_ci NOT NULL,
  `fecha_cargue` datetime NOT NULL,
  `idUser` int(11) NOT NULL,
  `Analizado` bit(1) NOT NULL,
  `CargadoTemp` bit(1) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id_upload_control`),
  KEY `nom_cargue` (`nom_cargue`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

DROP TABLE IF EXISTS `empresapro_regimenes`;
CREATE TABLE `empresapro_regimenes` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Regimen` varchar(20) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `empresapro_regimenes` (`ID`, `Regimen`) VALUES
(1,	'COMUN'),
(2,	'SIMPLIFICADO');

INSERT INTO `menu_pestanas` (`ID`, `Nombre`, `idMenu`, `Orden`, `Estado`, `Updated`, `Sync`) VALUES
(49,	'Reportes',	6,	6,	CONV('1', 2, 10) + 0,	'2018-07-13 15:42:33',	'2018-07-13 15:42:33');

UPDATE `menu_pestanas` SET `Orden` = '3' WHERE `menu_pestanas`.`ID` = 40;
UPDATE `menu_pestanas` SET `Orden` = '2' WHERE `menu_pestanas`.`ID` = 49;

UPDATE `menu_submenus` SET `Estado` = b'0' WHERE `menu_submenus`.`ID` = 37;
UPDATE `menu_submenus` SET `Estado` = b'0' WHERE `menu_submenus`.`ID` = 36;
INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (66, 'Reportes', '49', '6', 'ReportesCartera.php', '_SELF', 1, 'reportes.jpg', '1', '2018-10-07 07:53:03', '2018-07-13 15:42:34');


ALTER TABLE `salud_archivo_facturacion_mov_pagados` ADD `tipo_negociacion` VARCHAR(25) NOT NULL AFTER `valor_pagado`;

ALTER TABLE `salud_archivo_facturacion_mov_pagados` ADD `idEPS` VARCHAR(25) NOT NULL AFTER `num_factura`, ADD `nom_enti_administradora` VARCHAR(100) NOT NULL AFTER `idEPS`;

DROP TABLE IF EXISTS `salud_cartera_x_edades_temp`;
CREATE TABLE `salud_cartera_x_edades_temp` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `idEPS` varchar(25) NOT NULL,
  `RazonSocialEPS` varchar(45) NOT NULL,
  `Cantidad_1_30` int(11) NOT NULL,
  `Valor_1_30` double NOT NULL,
  `Cantidad_31_60` int(11) NOT NULL,
  `Valor_31_60` double NOT NULL,
  `Cantidad_61_90` int(11) NOT NULL,
  `Valor_61_90` double NOT NULL,
  `Cantidad_91_120` int(11) NOT NULL,
  `Valor_91_120` double NOT NULL,
  `Cantidad_121_180` int(11) NOT NULL,
  `Valor_121_180` double NOT NULL,
  `Cantidad_181_360` int(11) NOT NULL,
  `Valor_181_360` double NOT NULL,
  `Cantidad_360` int(11) NOT NULL,
  `Valor_360` double NOT NULL,
  `TotalFacturas` int(11) NOT NULL,
  `Total` double NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `empresapro` ADD `DV` INT NOT NULL AFTER `NIT`;
ALTER TABLE `empresapro` ADD `CodigoDANE` INT NOT NULL AFTER `Ciudad`;
ALTER TABLE `empresapro` CHANGE `NIT` `NIT` BIGINT NULL DEFAULT NULL;

UPDATE `menu_submenus` SET `Nombre` = 'Circular 030 y 014' WHERE `menu_submenus`.`ID` = 35;
ALTER TABLE `salud_procesos_gerenciales` ADD `IPS` INT NOT NULL AFTER `Fecha`;

INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (67, 'Listado de Bancos', '3', '6', 'salud_bancos.php', '_SELF', b'1', 'bancos.png', '4', '2018-08-05 23:09:34', '2018-07-13 15:42:34');
INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (68, 'Conceptos Procesos', '3', '6', 'salud_procesos_gerenciales_conceptos.php', '_SELF', b'1', 'proyectos.png', '9', '2018-08-05 23:09:34', '2018-07-13 15:42:34');



ALTER TABLE `salud_archivo_facturacion_mov_pagados` CHANGE `Soporte` `Soporte` TEXT CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL;

ALTER TABLE `salud_archivo_facturacion_mov_pagados` ADD `NumeroFacturaAdres` VARCHAR(45) NOT NULL AFTER `Arma030Anterior`;

INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES (69, 'Devolver una factura', '13', '6', 'SaludDevolucionFactura.php', '_SELF', b'1', 'devolucion2.png', '2', '2018-07-13 15:42:34', '2018-07-13 15:42:34');

DROP TABLE IF EXISTS `configuraciones_nombres_campos`;
CREATE TABLE `configuraciones_nombres_campos` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `NombreDB` varchar(50) NOT NULL,
  `Visualiza` varchar(50) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `configuraciones_nombres_campos` (`ID`, `NombreDB`, `Visualiza`, `Updated`, `Sync`) VALUES
(1,	'id_medicamentos',	'ID',	'2018-11-06 15:11:32',	'0000-00-00 00:00:00'),
(2,	'TipoUser',	'Tipo de Usuario',	'2018-11-06 15:11:32',	'0000-00-00 00:00:00'),
(3,	'idUsuarios',	'ID',	'2018-11-06 15:11:32',	'0000-00-00 00:00:00'),
(4,	'Identificacion',	'Identificación',	'2018-11-06 15:11:32',	'0000-00-00 00:00:00'),
(5,	'Telefono',	'Teléfono',	'2018-11-06 15:11:32',	'0000-00-00 00:00:00'),
(6,	'idEmpresaPro',	'ID',	'2018-11-06 15:19:27',	'0000-00-00 00:00:00'),
(7,	'RazonSocial',	'Razón Social',	'2018-11-06 15:19:42',	'0000-00-00 00:00:00'),
(8,	'CodigoPrestadora',	'Código de Prestadora',	'2018-11-06 15:20:20',	'0000-00-00 00:00:00'),
(9,	'Direccion',	'Dirección',	'2018-11-06 15:20:39',	'0000-00-00 00:00:00'),
(10,	'ResolucionDian',	'Resolución',	'2018-11-06 15:21:13',	'0000-00-00 00:00:00'),
(11,	'Regimen',	'Régimen',	'2018-11-06 15:21:36',	'0000-00-00 00:00:00'),
(12,	'ObservacionesLegales',	'Observaciones Legales',	'2018-11-06 15:22:01',	'0000-00-00 00:00:00'),
(13,	'PuntoEquilibrio',	'Punto de Equilibrio',	'2018-11-06 15:22:20',	'0000-00-00 00:00:00'),
(14,	'DatosBancarios',	'Datos Bancarios',	'2018-11-06 15:22:35',	'0000-00-00 00:00:00'),
(15,	'RutaImagen',	'Imagen',	'2018-11-06 15:23:17',	'0000-00-00 00:00:00'),
(16,	'id_concepto_glosa',	'ID',	'2018-11-06 15:30:12',	'0000-00-00 00:00:00'),
(17,	'cod_glosa',	'Código de Glosa',	'2018-11-06 15:30:28',	'0000-00-00 00:00:00'),
(18,	'cod_concepto_especifico',	'Código del Concepto Específico',	'2018-11-06 15:31:45',	'0000-00-00 00:00:00'),
(19,	'descrpcion_concep_especifico',	'Descripción del Concepto Específico',	'2018-11-06 15:32:28',	'0000-00-00 00:00:00'),
(20,	'aplicacion',	'Aplicación',	'2018-11-06 15:32:44',	'0000-00-00 00:00:00'),
(21,	'cod_pagador_min',	'Código de Administradora',	'2018-11-06 15:37:48',	'0000-00-00 00:00:00'),
(22,	'nit',	'NIT',	'2018-11-06 15:38:07',	'0000-00-00 00:00:00'),
(23,	'sigla_nombre',	'Sigla del Nombre',	'2018-11-06 15:38:21',	'0000-00-00 00:00:00'),
(24,	'nombre_completo',	'Nombre Completo',	'2018-11-06 15:38:35',	'0000-00-00 00:00:00'),
(25,	'telefonos',	'Teléfonos',	'2018-11-06 15:38:52',	'0000-00-00 00:00:00'),
(26,	'email',	'Email',	'2018-11-06 15:39:04',	'0000-00-00 00:00:00'),
(27,	'tipo_regimen',	'Régimen',	'2018-11-06 15:39:23',	'0000-00-00 00:00:00'),
(28,	'dias_convenio',	'Convenio en Días',	'2018-11-06 15:39:41',	'0000-00-00 00:00:00'),
(29,	'Nombre_gerente',	'Nombre del Gerente',	'2018-11-06 15:39:56',	'0000-00-00 00:00:00'),
(30,	'RepresentanteLegal',	'Representante Legal',	'2018-11-06 15:40:07',	'0000-00-00 00:00:00'),
(31,	'NumeroRepresentanteLegal',	'Celular del Representante Legal',	'2018-11-06 15:40:30',	'0000-00-00 00:00:00'),
(32,	'Genera030',	'Genera Circular 030?',	'2018-11-06 15:41:00',	'0000-00-00 00:00:00'),
(33,	'codigo_sistema',	'Código',	'2018-11-06 15:45:00',	'0000-00-00 00:00:00'),
(34,	'descripcion_cups',	'Descripción',	'2018-11-06 15:45:18',	'0000-00-00 00:00:00'),
(35,	'observacion',	'Observaciones',	'2018-11-06 15:45:44',	'0000-00-00 00:00:00');

ALTER TABLE `menu_submenus` ADD `idMenu` INT NOT NULL AFTER `idCarpeta`, ADD `TablaAsociada` VARCHAR(45) NOT NULL AFTER `idMenu`;

ALTER TABLE `menu` ADD `CSS_Clase` VARCHAR(20) NOT NULL AFTER `Image`;

UPDATE `menu` SET `CSS_Clase`='fa fa-share';



