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



