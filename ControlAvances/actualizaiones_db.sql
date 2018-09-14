INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) 
VALUES (63, 'Historial de Facturas devueltas', '46', '6', 'salud_registro_devoluciones_facturas.php', '_SELF', b'1', 'historial.png', '1', '2018-08-03 23:54:16', '2018-07-13 15:42:34');

INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES
(64, 'Circular 014', 40, 6, 'salud_genere_circular_030.php', '_SELF', b'1', 'listasprecios.png', 6, '2018-09-03 11:49:36', '2018-07-13 15:42:34');

ALTER TABLE `salud_archivo_conceptos_glosas` ADD `descripcion_concepto_general` TEXT NOT NULL AFTER `cod_concepto_general`, ADD `tipo_concepto_general` VARCHAR(30) NOT NULL AFTER `descripcion_concepto_general`;
ALTER TABLE `salud_archivo_conceptos_glosas` ADD `aplicacion_concepto_general` TEXT NOT NULL AFTER `tipo_concepto_general`;

ALTER TABLE `usuarios` ADD `Habilitado` VARCHAR(2) NOT NULL DEFAULT 'SI' AFTER `Email`;

ALTER TABLE `salud_glosas_iniciales_temp` ADD `idUser` INT NOT NULL AFTER `Soporte`;

ALTER TABLE `salud_cups` CHANGE `ID` `ID` INT(20) NOT NULL AUTO_INCREMENT;

