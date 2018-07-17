-- Adminer 4.2.5 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `centrocosto`;
CREATE TABLE `centrocosto` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `EmpresaPro` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `ciuu`;
CREATE TABLE `ciuu` (
  `Codigo` int(11) NOT NULL,
  `Descripcion` varchar(300) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`Codigo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `clasecuenta`;
CREATE TABLE `clasecuenta` (
  `PUC` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Clase` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Valor` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`PUC`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `configuracion_general`;
CREATE TABLE `configuracion_general` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Descripcion` text COLLATE latin1_spanish_ci NOT NULL,
  `Valor` text COLLATE latin1_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;


DROP TABLE IF EXISTS `cuentas`;
CREATE TABLE `cuentas` (
  `idPUC` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `Nombre` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `Valor` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci DEFAULT NULL,
  `GupoCuentas_PUC` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idPUC`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `cuentasfrecuentes`;
CREATE TABLE `cuentasfrecuentes` (
  `CuentaPUC` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Nombre` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `ClaseCuenta` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `UsoFuturo` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`CuentaPUC`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `empresapro`;
CREATE TABLE `empresapro` (
  `idEmpresaPro` int(11) NOT NULL AUTO_INCREMENT,
  `RazonSocial` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `NIT` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `CodigoPrestadora` bigint(20) NOT NULL,
  `Direccion` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Telefono` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Celular` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Ciudad` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ResolucionDian` text COLLATE utf8_spanish_ci NOT NULL,
  `Regimen` enum('SIMPLIFICADO','COMUN') COLLATE utf8_spanish_ci DEFAULT 'SIMPLIFICADO',
  `Email` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `WEB` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ObservacionesLegales` text COLLATE utf8_spanish_ci NOT NULL,
  `PuntoEquilibrio` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `DatosBancarios` text COLLATE utf8_spanish_ci NOT NULL,
  `RutaImagen` varchar(200) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'LogosEmpresas/logotipo1.png',
  `FacturaSinInventario` varchar(2) COLLATE utf8_spanish_ci NOT NULL,
  `CXPAutomaticas` varchar(2) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'SI',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idEmpresaPro`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `empresa_pro_sucursales`;
CREATE TABLE `empresa_pro_sucursales` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `Ciudad` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Direccion` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `idEmpresaPro` int(11) NOT NULL,
  `Visible` varchar(2) COLLATE utf8_spanish2_ci NOT NULL,
  `Actual` varchar(1) COLLATE utf8_spanish2_ci NOT NULL,
  `idServidor` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `estadosfinancieros_mayor_temporal`;
CREATE TABLE `estadosfinancieros_mayor_temporal` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `FechaCorte` date NOT NULL,
  `Clase` int(11) NOT NULL,
  `CuentaPUC` bigint(20) NOT NULL,
  `NombreCuenta` varchar(80) COLLATE utf8_spanish2_ci NOT NULL,
  `SaldoAnterior` double NOT NULL,
  `Neto` double NOT NULL,
  `SaldoFinal` double NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `formatos_calidad`;
CREATE TABLE `formatos_calidad` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` text COLLATE utf8_spanish2_ci NOT NULL,
  `Version` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Codigo` text COLLATE utf8_spanish2_ci NOT NULL,
  `Fecha` date NOT NULL,
  `CuerpoFormato` text CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `NotasPiePagina` text COLLATE utf8_spanish2_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `gupocuentas`;
CREATE TABLE `gupocuentas` (
  `PUC` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Nombre` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Valor` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `ClaseCuenta_PUC` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`PUC`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `librodiario`;
CREATE TABLE `librodiario` (
  `idLibroDiario` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date DEFAULT NULL,
  `Tipo_Documento_Intero` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Num_Documento_Interno` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish2_ci DEFAULT NULL,
  `Num_Documento_Externo` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Tercero_Tipo_Documento` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Tercero_Identificacion` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Tercero_DV` varchar(3) COLLATE utf8_spanish_ci NOT NULL,
  `Tercero_Primer_Apellido` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Tercero_Segundo_Apellido` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Tercero_Primer_Nombre` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Tercero_Otros_Nombres` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Tercero_Razon_Social` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Tercero_Direccion` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Tercero_Cod_Dpto` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `Tercero_Cod_Mcipio` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `Tercero_Pais_Domicilio` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `Concepto` varchar(500) COLLATE utf8_spanish_ci NOT NULL,
  `CuentaPUC` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `NombreCuenta` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Detalle` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Debito` double DEFAULT NULL,
  `Credito` double DEFAULT NULL,
  `Neto` double DEFAULT NULL,
  `Mayor` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Esp` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idCentroCosto` int(11) NOT NULL,
  `idEmpresa` int(11) NOT NULL,
  `idSucursal` int(11) NOT NULL,
  `Estado` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idLibroDiario`),
  KEY `Tipo_Documento_Intero` (`Tipo_Documento_Intero`),
  KEY `Tercero_Identificacion` (`Tercero_Identificacion`),
  KEY `Num_Documento_Interno` (`Num_Documento_Interno`),
  KEY `CuentaPUC` (`CuentaPUC`),
  KEY `Fecha` (`Fecha`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `libromayorbalances`;
CREATE TABLE `libromayorbalances` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `FechaInicial` date NOT NULL,
  `FechaFinal` date NOT NULL,
  `CuentaPUC` bigint(20) DEFAULT NULL,
  `NombreCuenta` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `SaldoAnterior` double NOT NULL,
  `Debito` double DEFAULT NULL,
  `Credito` double DEFAULT NULL,
  `NuevoSaldo` double NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `menu`;
CREATE TABLE `menu` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(80) COLLATE latin1_spanish_ci NOT NULL,
  `idCarpeta` int(11) NOT NULL,
  `Pagina` varchar(80) COLLATE latin1_spanish_ci NOT NULL,
  `Target` varchar(10) COLLATE latin1_spanish_ci NOT NULL DEFAULT '_SELF',
  `Estado` int(1) NOT NULL DEFAULT '1',
  `Image` text COLLATE latin1_spanish_ci NOT NULL,
  `Orden` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;


DROP TABLE IF EXISTS `menu_carpetas`;
CREATE TABLE `menu_carpetas` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Ruta` varchar(90) COLLATE latin1_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;


DROP TABLE IF EXISTS `menu_pestanas`;
CREATE TABLE `menu_pestanas` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(45) COLLATE latin1_spanish_ci NOT NULL,
  `idMenu` int(11) NOT NULL,
  `Orden` int(11) NOT NULL,
  `Estado` bit(1) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;


DROP TABLE IF EXISTS `menu_submenus`;
CREATE TABLE `menu_submenus` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(100) COLLATE latin1_spanish_ci NOT NULL,
  `idPestana` int(11) NOT NULL,
  `idCarpeta` int(11) NOT NULL,
  `Pagina` varchar(100) COLLATE latin1_spanish_ci NOT NULL,
  `Target` varchar(10) COLLATE latin1_spanish_ci NOT NULL,
  `Estado` bit(1) NOT NULL,
  `Image` varchar(200) COLLATE latin1_spanish_ci NOT NULL,
  `Orden` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;


DROP TABLE IF EXISTS `paginas`;
CREATE TABLE `paginas` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `TipoPagina` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Visible` tinyint(1) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `paginas_bloques`;
CREATE TABLE `paginas_bloques` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TipoUsuario` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Pagina` varchar(50) COLLATE utf8_spanish2_ci NOT NULL,
  `Habilitado` varchar(2) COLLATE utf8_spanish2_ci NOT NULL DEFAULT 'SI',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `parametros_contables`;
CREATE TABLE `parametros_contables` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Descripcion` text COLLATE utf8_spanish2_ci NOT NULL,
  `CuentaPUC` bigint(20) NOT NULL,
  `NombreCuenta` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `parametros_generales`;
CREATE TABLE `parametros_generales` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `KardexCotizacion` bit(1) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;


DROP TABLE IF EXISTS `plataforma_tablas`;
CREATE TABLE `plataforma_tablas` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `registra_ediciones`;
CREATE TABLE `registra_ediciones` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Hora` time NOT NULL,
  `Tabla` varchar(200) COLLATE utf8_spanish2_ci NOT NULL,
  `Campo` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `ValorAnterior` text COLLATE utf8_spanish2_ci NOT NULL,
  `ValorNuevo` text COLLATE utf8_spanish2_ci NOT NULL,
  `ConsultaRealizada` text COLLATE utf8_spanish2_ci NOT NULL,
  `idUsuario` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `registra_eliminaciones`;
CREATE TABLE `registra_eliminaciones` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `Hora` time NOT NULL,
  `Campo` text COLLATE latin1_spanish_ci NOT NULL,
  `Valor` text COLLATE latin1_spanish_ci NOT NULL,
  `Causal` text COLLATE latin1_spanish_ci NOT NULL,
  `TablaOrigen` varchar(100) COLLATE latin1_spanish_ci NOT NULL,
  `idTabla` varchar(45) COLLATE latin1_spanish_ci NOT NULL,
  `idItemEliminado` varchar(45) COLLATE latin1_spanish_ci NOT NULL,
  `idUsuario` bigint(20) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `TablaOrigen` (`TablaOrigen`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;


DROP TABLE IF EXISTS `respuestas_condicional`;
CREATE TABLE `respuestas_condicional` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Valor` varchar(4) COLLATE utf8_spanish2_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


DROP TABLE IF EXISTS `salud_archivo_conceptos_glosas`;
CREATE TABLE `salud_archivo_conceptos_glosas` (
  `id_concepto_glosa` int(20) NOT NULL AUTO_INCREMENT,
  `cod_glosa` int(3) NOT NULL COMMENT 'Codigo de glosa, Devolucion o Respuestas',
  `cod_concepto_general` int(1) NOT NULL COMMENT 'Concepto general de la glosa',
  `cod_concepto_especifico` int(2) unsigned zerofill NOT NULL COMMENT 'Concepto especifico de la glosa',
  `descrpcion_concep_especifico` text CHARACTER SET utf8 NOT NULL COMMENT 'Descripción de la glosa ',
  `aplicacion` text CHARACTER SET utf8 NOT NULL COMMENT 'Aplica cuando:',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id_concepto_glosa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=COMPACT COMMENT='manual unico glosas,devoluciones y resp Ver Anexo tecn #6';


DROP TABLE IF EXISTS `salud_archivo_consultas`;
CREATE TABLE `salud_archivo_consultas` (
  `id_consultas` int(20) NOT NULL AUTO_INCREMENT,
  `num_factura` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Número de la factura " Ver Alineamientos tecnicos para ips ver pag 12"',
  `cod_prest_servicio` bigint(12) NOT NULL COMMENT 'Código del prestador de servicios de salud " Ver Alineamientos tecnicos para ips ver pag 12"',
  `tipo_ident_usuario` enum('CC','CE','PA','RC','TI','AS','MS') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Tipo de identificación del usuario " Ver Alineamientos tecnicos para ips ver pag 14"',
  `num_ident_usuario` bigint(16) NOT NULL COMMENT 'Número de identificación del usuario del sistema " Ver Alineamientos tecnicos para ips ver pag 16"',
  `fecha_consulta` date NOT NULL COMMENT 'Fecha de la consulta " Ver Alineamientos tecnicos para ips ver pag 20"',
  `num_autorizacion` int(15) DEFAULT NULL COMMENT 'Número de autorización " Ver Alineamientos tecnicos para ips ver pag 20" ',
  `cod_consulta` varchar(7) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Código de la consulta " Ver Alineamientos tecnicos para ips ver pag 20"',
  `finalidad_consulta` enum('01','02','03','04','05','06','07','08','09','10') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Finalidad de la consulta " Ver Alineamientos tecnicos para ips ver pag 25"',
  `causa_externa` enum('01','02','03','04','05','06','07','08','09','10','11','12','13','14','15') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Causa externa " Ver Alineamientos tecnicos para ips ver pag 26"',
  `cod_diagnostico_principal` varchar(4) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Código del diagnóstico principal " Ver Alineamientos tecnicos para ips ver pag 26"',
  `cod_diagnostico_relacionado1` varchar(4) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Código del diagnóstico relacionado No. 1 " Ver Alineamientos tecnicos para ips ver pag 27"',
  `cod_diagnostico_relacionado2` varchar(4) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Código del diagnóstico relacionado No. 2 " Ver Alineamientos tecnicos para ips ver pag 27"',
  `cod_diagnostico_relacionado3` varchar(4) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Código del diagnóstico relacionado No. 3 " Ver Alineamientos tecnicos para ips ver pag 27"',
  `tipo_diagn_principal` enum('1','2','3') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Tipo de diagnóstico principal " Ver Alineamientos tecnicos para ips ver pag 28"',
  `valor_consulta` double(15,2) NOT NULL COMMENT 'Valor de la consulta " Ver Alineamientos tecnicos para ips ver pag 28"',
  `valor_cuota_moderadora` double(15,2) NOT NULL COMMENT 'Valor de la cuota moderadora " Ver Alineamientos tecnicos para ips ver pag 28"',
  `valor_neto_pagar_consulta` double(15,2) NOT NULL COMMENT 'Valor neto a pagar por la consulta " Ver Alineamientos tecnicos para ips ver pag 28"',
  `tipo_negociacion` enum('evento','capita') COLLATE utf8_spanish_ci NOT NULL,
  `nom_cargue` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre del archivo con el que se carga',
  `fecha_cargue` datetime NOT NULL COMMENT 'Fecha en que se carga',
  `idUser` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id_consultas`),
  KEY `num_factura` (`num_factura`),
  KEY `nom_cargue` (`nom_cargue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Archivo de cosnultas AC';


DROP TABLE IF EXISTS `salud_archivo_consultas_temp`;
CREATE TABLE `salud_archivo_consultas_temp` (
  `id_consultas` varchar(1) COLLATE utf8_spanish_ci NOT NULL,
  `num_factura` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Número de la factura " Ver Alineamientos tecnicos para ips ver pag 12"',
  `cod_prest_servicio` bigint(12) NOT NULL COMMENT 'Código del prestador de servicios de salud " Ver Alineamientos tecnicos para ips ver pag 12"',
  `tipo_ident_usuario` enum('CC','CE','PA','RC','TI','AS','MS') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Tipo de identificación del usuario " Ver Alineamientos tecnicos para ips ver pag 14"',
  `num_ident_usuario` bigint(16) NOT NULL COMMENT 'Número de identificación del usuario del sistema " Ver Alineamientos tecnicos para ips ver pag 16"',
  `fecha_consulta` date NOT NULL COMMENT 'Fecha de la consulta " Ver Alineamientos tecnicos para ips ver pag 20"',
  `num_autorizacion` int(15) DEFAULT NULL COMMENT 'Número de autorización " Ver Alineamientos tecnicos para ips ver pag 20" ',
  `cod_consulta` varchar(7) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Código de la consulta " Ver Alineamientos tecnicos para ips ver pag 20"',
  `finalidad_consulta` enum('01','02','03','04','05','06','07','08','09','10') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Finalidad de la consulta " Ver Alineamientos tecnicos para ips ver pag 25"',
  `causa_externa` enum('01','02','03','04','05','06','07','08','09','10','11','12','13','14','15') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Causa externa " Ver Alineamientos tecnicos para ips ver pag 26"',
  `cod_diagnostico_principal` varchar(4) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Código del diagnóstico principal " Ver Alineamientos tecnicos para ips ver pag 26"',
  `cod_diagnostico_relacionado1` varchar(4) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Código del diagnóstico relacionado No. 1 " Ver Alineamientos tecnicos para ips ver pag 27"',
  `cod_diagnostico_relacionado2` varchar(4) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Código del diagnóstico relacionado No. 2 " Ver Alineamientos tecnicos para ips ver pag 27"',
  `cod_diagnostico_relacionado3` varchar(4) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Código del diagnóstico relacionado No. 3 " Ver Alineamientos tecnicos para ips ver pag 27"',
  `tipo_diagn_principal` enum('1','2','3') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Tipo de diagnóstico principal " Ver Alineamientos tecnicos para ips ver pag 28"',
  `valor_consulta` double(15,2) NOT NULL COMMENT 'Valor de la consulta " Ver Alineamientos tecnicos para ips ver pag 28"',
  `valor_cuota_moderadora` double(15,2) NOT NULL COMMENT 'Valor de la cuota moderadora " Ver Alineamientos tecnicos para ips ver pag 28"',
  `valor_neto_pagar_consulta` double(15,2) NOT NULL COMMENT 'Valor neto a pagar por la consulta " Ver Alineamientos tecnicos para ips ver pag 28"',
  `tipo_negociacion` enum('evento','capita') COLLATE utf8_spanish_ci NOT NULL,
  `nom_cargue` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre del archivo con el que se carga',
  `fecha_cargue` datetime NOT NULL COMMENT 'Fecha en que se carga',
  `idUser` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `id_consultas` (`id_consultas`),
  KEY `num_factura` (`num_factura`),
  KEY `nom_cargue` (`nom_cargue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Archivo de cosnultas AC';


DROP TABLE IF EXISTS `salud_archivo_ct`;
CREATE TABLE `salud_archivo_ct` (
  `ID` int(20) NOT NULL AUTO_INCREMENT,
  `cod_prest_servicio` bigint(12) NOT NULL COMMENT 'Código del prestador de servicios de salud " Ver Alineamientos tecnicos para ips ver pag 12"',
  `fecha_emision` date NOT NULL COMMENT 'Fecha de envio de datos " Ver Alineamientos tecnicos para ips ver pag 12"',
  `cod_archivo` varchar(6) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre del archivo con el numero de cuenta asociado "Ver Alineamientos tecnicos para ips ver pag 12"',
  `total_registros` int(11) NOT NULL COMMENT 'cantidad de registros por acrhivo Ver Alineamientos tecnicos para ips ver pag 12',
  `CuentaRIPS` int(6) unsigned zerofill NOT NULL,
  `idUser` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Archivo de control';


DROP TABLE IF EXISTS `salud_archivo_facturacion_mov_generados`;
CREATE TABLE `salud_archivo_facturacion_mov_generados` (
  `id_fac_mov_generados` int(20) NOT NULL AUTO_INCREMENT,
  `cod_prest_servicio` bigint(12) NOT NULL COMMENT 'Código del prestador de servicios de salud " Ver Alineamientos tecnicos para ips ver pag 12"',
  `razon_social` varchar(60) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Razón social o apellidos y nombre del prestado  " Ver Alineamientos tecnicos para ips ver pag 12"',
  `tipo_ident_prest_servicio` enum('NI','CC','CE','PA') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Tipo de identificación del prestador de servicios de salud " Ver Alineamientos tecnicos para ips ver pag 12"',
  `num_ident_prest_servicio` bigint(20) NOT NULL COMMENT 'Número de identificación del prestador de servicios de salud " Ver Alineamientos tecnicos para ips ver pag 12"',
  `num_factura` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Número de la factura " Ver Alineamientos tecnicos para ips ver pag 12"',
  `fecha_factura` date NOT NULL COMMENT 'Fecha de expedición de la factura " Ver Alineamientos tecnicos para ips ver pag 13"',
  `fecha_inicio` date NOT NULL COMMENT 'Fecha de inicio " Ver Alineamientos tecnicos para ips ver pag 13"',
  `fecha_final` date NOT NULL COMMENT 'Fecha final " Ver Alineamientos tecnicos para ips ver pag 13"',
  `cod_enti_administradora` varchar(6) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Código entidad administradora " Ver Alineamientos tecnicos para ips ver pag 13"',
  `nom_enti_administradora` varchar(200) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre entidad administradora " Ver Alineamientos tecnicos para ips ver pag 13" ',
  `num_contrato` varchar(15) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Número del contrato " Ver Alineamientos tecnicos para ips ver pag 13"',
  `plan_beneficios` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Plan de beneficios " Ver Alineamientos tecnicos para ips ver pag 13"',
  `num_poliza` varchar(10) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Número de la póliza " Ver Alineamientos tecnicos para ips ver pag 13" ',
  `valor_total_pago` double(15,2) NOT NULL COMMENT 'Valor total del pago compartido copago " Ver Alineamientos tecnicos para ips ver pag 14"',
  `valor_comision` double(15,2) NOT NULL COMMENT 'Valor de la comisión " Ver Alineamientos tecnicos para ips ver pag 14"',
  `valor_descuentos` double(15,2) NOT NULL COMMENT 'Valor total de descuentos " Ver Alineamientos tecnicos para ips ver pag 14"',
  `valor_neto_pagar` double(15,2) NOT NULL COMMENT 'Valor neto a pagar por la entidad contratante " Ver Alineamientos tecnicos para ips ver pag 14"',
  `tipo_negociacion` enum('evento','capita') COLLATE utf8_spanish_ci NOT NULL,
  `nom_cargue` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre con el que se hizo el cargue al sistema de cartera',
  `fecha_cargue` datetime NOT NULL COMMENT 'Fecha Y Hora que se hizo el cargue',
  `idUser` int(11) NOT NULL,
  `eps_radicacion` varchar(50) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Eps en la que se radico la factura',
  `dias_pactados` int(2) DEFAULT NULL COMMENT 'Dias que se pactaron para el pago de la factura con eps',
  `fecha_radicado` date DEFAULT NULL COMMENT 'Fecha de la radicacion de la factura',
  `numero_radicado` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Numero con que se radico la factura',
  `Soporte` varchar(200) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Ruta de Archivo de comprobación de radicado',
  `estado` varchar(50) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Indica en que tabla esta el registro en un momento dado ',
  `EstadoCobro` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `Arma030Anterior` enum('S','N') COLLATE utf8_spanish_ci NOT NULL DEFAULT 'N',
  `Escenario` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `CuentaGlobal` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `CuentaRIPS` int(6) unsigned zerofill NOT NULL,
  `EstadoGlosa` int(2) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id_fac_mov_generados`),
  UNIQUE KEY `num_factura` (`num_factura`),
  KEY `estado` (`estado`),
  KEY `tipo_negociacion` (`tipo_negociacion`),
  KEY `Updated` (`Updated`),
  KEY `EstadoCobro` (`EstadoCobro`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Archivo de transacciones_AF_generadas';


DROP TABLE IF EXISTS `salud_archivo_facturacion_mov_pagados`;
CREATE TABLE `salud_archivo_facturacion_mov_pagados` (
  `id_pagados` bigint(20) NOT NULL AUTO_INCREMENT,
  `num_factura` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Número de la factura ',
  `fecha_pago_factura` date NOT NULL COMMENT 'Fecha de pago de la factura',
  `num_pago` int(10) NOT NULL COMMENT 'Número del comprobante del pago ',
  `valor_bruto_pagar` double(15,2) NOT NULL COMMENT 'Valor bruto a pagar',
  `valor_descuento` double(15,2) NOT NULL COMMENT 'Valor descuento',
  `valor_iva` double(15,2) NOT NULL COMMENT 'Valor iva',
  `valor_retefuente` double(15,2) NOT NULL COMMENT 'Valor retefuente',
  `valor_reteiva` double(15,2) NOT NULL COMMENT 'Valor reteiva',
  `valor_reteica` double(15,2) NOT NULL COMMENT 'Valor reteica',
  `valor_otrasretenciones` double(15,2) NOT NULL COMMENT 'Valor otras retenciones',
  `valor_cruces` double(15,2) NOT NULL COMMENT 'Valor de cruces posible glosas ',
  `valor_anticipos` double(15,2) NOT NULL COMMENT 'Valor de anticipos ',
  `valor_pagado` double(15,2) NOT NULL COMMENT 'Valor transferidoa banco ',
  `nom_cargue` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `fecha_cargue` datetime NOT NULL,
  `Estado` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `Soporte` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idUser` int(11) NOT NULL,
  `Arma030Anterior` enum('S','N') COLLATE utf8_spanish_ci NOT NULL DEFAULT 'N',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id_pagados`),
  KEY `num_factura` (`num_factura`),
  KEY `nom_cargue` (`nom_cargue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Archivo de transacciones_AF_pagadas';


DROP TABLE IF EXISTS `salud_archivo_facturacion_mov_pagados_temp`;
CREATE TABLE `salud_archivo_facturacion_mov_pagados_temp` (
  `id_pagados` varchar(1) COLLATE utf8_spanish_ci NOT NULL,
  `num_factura` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Número de la factura ',
  `fecha_pago_factura` date NOT NULL COMMENT 'Fecha de pago de la factura',
  `num_pago` int(10) NOT NULL COMMENT 'Número del comprobante del pago ',
  `valor_bruto_pagar` double(15,2) NOT NULL COMMENT 'Valor bruto a pagar',
  `valor_descuento` double(15,2) NOT NULL COMMENT 'Valor descuento',
  `valor_iva` double(15,2) NOT NULL COMMENT 'Valor iva',
  `valor_retefuente` double(15,2) NOT NULL COMMENT 'Valor retefuente',
  `valor_reteiva` double(15,2) NOT NULL COMMENT 'Valor reteiva',
  `valor_reteica` double(15,2) NOT NULL COMMENT 'Valor reteica',
  `valor_otrasretenciones` double(15,2) NOT NULL COMMENT 'Valor otras retenciones',
  `valor_cruces` double(15,2) NOT NULL COMMENT 'Valor de cruces posible glosas ',
  `valor_anticipos` double(15,2) NOT NULL COMMENT 'Valor de anticipos ',
  `valor_pagado` double(15,2) NOT NULL COMMENT 'Valor transferidoa banco ',
  `nom_cargue` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `fecha_cargue` datetime NOT NULL,
  `Estado` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `Soporte` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `idUser` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `id_temp_rips_pagados` (`id_pagados`),
  KEY `nom_cargue` (`nom_cargue`),
  KEY `num_factura` (`num_factura`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Archivo temporal de rips pagados';


DROP TABLE IF EXISTS `salud_archivo_hospitalizaciones`;
CREATE TABLE `salud_archivo_hospitalizaciones` (
  `id_hospitalizacion` int(20) NOT NULL AUTO_INCREMENT,
  `num_factura` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Número de la factura " Ver Alineamientos tecnicos para ips ver pag 12"',
  `cod_prest_servicio` bigint(12) NOT NULL COMMENT 'Código del prestador de servicios de salud " Ver Alineamientos tecnicos para ips ver pag 12"',
  `tipo_ident_usuario` enum('CC','CE','PA','RC','TI','AS','MS') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Tipo de identificación del usuario " Ver Alineamientos tecnicos para ips ver pag 14"',
  `num_ident_usuario` bigint(16) NOT NULL COMMENT 'Número de identificación del usuario del sistema " Ver Alineamientos tecnicos para ips ver pag 16"',
  `via_ingreso` enum('1','2','3','4') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Vía de ingreso a la institución " Ver Alineamientos tecnicos para ips ver pag 35"',
  `fecha_ingreso_hospi` date NOT NULL COMMENT 'Fecha de ingreso del usuario a la institución " Ver Alineamientos tecnicos para ips ver pag 35"',
  `hora_ingreso` time NOT NULL COMMENT 'Hora de ingreso del usuario a la\r\nInstitución " Ver Alineamientos tecnicos para ips ver pag 35"',
  `num_autorizacion` int(15) DEFAULT NULL COMMENT 'Número de autorización " Ver Alineamientos tecnicos para ips ver pag 32" ',
  `causa_externa` enum('01','02','03','04','05','06','07','08','09','10','11','12','13','14','15') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Causa externa " Ver Alineamientos tecnicos para ips ver pag 32"',
  `diagn_princ_ingreso` varchar(4) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Diagnóstico principal de ingreso " Ver Alineamientos tecnicos para ips ver pag 36"',
  `diagn_princ_egreso` varchar(4) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Diagnóstico principal de egreso " Ver Alineamientos tecnicos para ips ver pag 37"',
  `diagn_relac1_egreso` varchar(4) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Diagnóstico relacionado Nro. 1 de egreso " Ver Alineamientos tecnicos para ips ver pag 37"',
  `diagn_relac2_egreso` varchar(4) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Diagnóstico relacionado Nro. 2 de egreso " Ver Alineamientos tecnicos para ips ver pag 37"',
  `diagn_relac3_egreso` varchar(4) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Diagnóstico relacionado Nro. 3 de egreso " Ver Alineamientos tecnicos para ips ver pag 38"',
  `diagn_complicacion` varchar(4) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Diagnóstico de la complicación " Ver Alineamientos tecnicos para ips ver pag 38"',
  `estado_salida_hospi` enum('1','2') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Estado a la salida " Ver Alineamientos tecnicos para ips ver pag 38"',
  `diagn_causa_muerte` varchar(4) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Diagnóstico de la causa básica de muerte " Ver Alineamientos tecnicos para ips ver pag 38"',
  `fecha_salida_hospi` date NOT NULL COMMENT 'Fecha de egreso del usuario a la institución " Ver Alineamientos tecnicos para ips ver pag 38"',
  `hora_salida_hospi` time NOT NULL COMMENT 'Hora de egreso del usuario de la institución " Ver Alineamientos tecnicos para ips ver pag 38"',
  `tipo_negociacion` enum('evento','capita') COLLATE utf8_spanish_ci NOT NULL,
  `nom_cargue` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre del archivo con el que se carga',
  `fecha_cargue` datetime NOT NULL COMMENT 'Fecha en que se carga',
  `idUser` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id_hospitalizacion`),
  KEY `num_factura` (`num_factura`),
  KEY `nom_cargue` (`nom_cargue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Archivo de hospitalización AH';


DROP TABLE IF EXISTS `salud_archivo_hospitalizaciones_temp`;
CREATE TABLE `salud_archivo_hospitalizaciones_temp` (
  `id_hospitalizacion` varchar(1) COLLATE utf8_spanish_ci NOT NULL,
  `num_factura` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Número de la factura " Ver Alineamientos tecnicos para ips ver pag 12"',
  `cod_prest_servicio` bigint(12) NOT NULL COMMENT 'Código del prestador de servicios de salud " Ver Alineamientos tecnicos para ips ver pag 12"',
  `tipo_ident_usuario` enum('CC','CE','PA','RC','TI','AS','MS') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Tipo de identificación del usuario " Ver Alineamientos tecnicos para ips ver pag 14"',
  `num_ident_usuario` bigint(16) NOT NULL COMMENT 'Número de identificación del usuario del sistema " Ver Alineamientos tecnicos para ips ver pag 16"',
  `via_ingreso` enum('1','2','3','4') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Vía de ingreso a la institución " Ver Alineamientos tecnicos para ips ver pag 35"',
  `fecha_ingreso_hospi` date NOT NULL COMMENT 'Fecha de ingreso del usuario a la institución " Ver Alineamientos tecnicos para ips ver pag 35"',
  `hora_ingreso` time NOT NULL COMMENT 'Hora de ingreso del usuario a la\r\nInstitución " Ver Alineamientos tecnicos para ips ver pag 35"',
  `num_autorizacion` int(15) DEFAULT NULL COMMENT 'Número de autorización " Ver Alineamientos tecnicos para ips ver pag 32" ',
  `causa_externa` enum('01','02','03','04','05','06','07','08','09','10','11','12','13','14','15') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Causa externa " Ver Alineamientos tecnicos para ips ver pag 32"',
  `diagn_princ_ingreso` varchar(4) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Diagnóstico principal de ingreso " Ver Alineamientos tecnicos para ips ver pag 36"',
  `diagn_princ_egreso` varchar(4) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Diagnóstico principal de egreso " Ver Alineamientos tecnicos para ips ver pag 37"',
  `diagn_relac1_egreso` varchar(4) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Diagnóstico relacionado Nro. 1 de egreso " Ver Alineamientos tecnicos para ips ver pag 37"',
  `diagn_relac2_egreso` varchar(4) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Diagnóstico relacionado Nro. 2 de egreso " Ver Alineamientos tecnicos para ips ver pag 37"',
  `diagn_relac3_egreso` varchar(4) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Diagnóstico relacionado Nro. 3 de egreso " Ver Alineamientos tecnicos para ips ver pag 38"',
  `diagn_complicacion` varchar(4) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Diagnóstico de la complicación " Ver Alineamientos tecnicos para ips ver pag 38"',
  `estado_salida_hospi` enum('1','2') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Estado a la salida " Ver Alineamientos tecnicos para ips ver pag 38"',
  `diagn_causa_muerte` varchar(4) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Diagnóstico de la causa básica de muerte " Ver Alineamientos tecnicos para ips ver pag 38"',
  `fecha_salida_hospi` date NOT NULL COMMENT 'Fecha de egreso del usuario a la institución " Ver Alineamientos tecnicos para ips ver pag 38"',
  `hora_salida_hospi` time NOT NULL COMMENT 'Hora de egreso del usuario de la institución " Ver Alineamientos tecnicos para ips ver pag 38"',
  `tipo_negociacion` enum('evento','capita') COLLATE utf8_spanish_ci NOT NULL,
  `nom_cargue` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre del archivo con el que se carga',
  `fecha_cargue` datetime NOT NULL COMMENT 'Fecha en que se carga',
  `idUser` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `id_hospitalizacion` (`id_hospitalizacion`),
  KEY `num_factura` (`num_factura`),
  KEY `nom_cargue` (`nom_cargue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Archivo de hospitalización AH';


DROP TABLE IF EXISTS `salud_archivo_medicamentos`;
CREATE TABLE `salud_archivo_medicamentos` (
  `id_medicamentos` bigint(20) NOT NULL AUTO_INCREMENT,
  `num_factura` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Número de la factura " Ver Alineamientos tecnicos para ips ver pag 12"',
  `cod_prest_servicio` bigint(12) NOT NULL COMMENT 'Código del prestador de servicios de salud " Ver Alineamientos tecnicos para ips ver pag 12"',
  `tipo_ident_usuario` enum('CC','CE','PA','RC','TI','AS','MS') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Tipo de identificación del usuario " Ver Alineamientos tecnicos para ips ver pag 14"',
  `num_ident_usuario` bigint(16) NOT NULL COMMENT 'Número de identificación del usuario del sistema " Ver Alineamientos tecnicos para ips ver pag 16"',
  `num_autorizacion` int(15) DEFAULT NULL COMMENT 'Número de autorización " Ver Alineamientos tecnicos para ips ver pag 20" ',
  `cod_medicamento` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Código del medicamento " Ver Alineamientos tecnicos para ips ver pag 41"',
  `tipo_medicamento` enum('1','2') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Tipo de medicamento " Ver Alineamientos tecnicos para ips ver pag 41"',
  `forma_farmaceutica` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Forma farmacéutica" Ver Alineamientos tecnicos para ips ver pag 41"',
  `nom_medicamento` varchar(30) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre genérico del medicamento " Ver Alineamientos tecnicos para ips ver pag 41"',
  `concentracion_medic` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Concentración del medicamento" Ver Alineamientos tecnicos para ips ver pag 41"',
  `um_medicamento` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Unidad de medida del medicamento" Ver Alineamientos tecnicos para ips ver pag 41"',
  `num_und_medic` int(5) NOT NULL COMMENT 'Número de unidades" Ver Alineamientos tecnicos para ips ver pag 41"',
  `valor_unit_medic` double(15,2) NOT NULL COMMENT 'Valor unitario de medicamento " Ver Alineamientos tecnicos para ips ver pag 42"',
  `valor_total_medic` double(15,2) NOT NULL COMMENT 'Valor total del medicamento " Ver Alineamientos tecnicos para ips ver pag 42"',
  `tipo_negociacion` enum('evento','capita') COLLATE utf8_spanish_ci NOT NULL,
  `nom_cargue` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre del archivo con el que se carga',
  `fecha_cargue` datetime NOT NULL COMMENT 'Fecha en que se carga',
  `idUser` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id_medicamentos`),
  KEY `num_factura` (`num_factura`),
  KEY `nom_cargue` (`nom_cargue`),
  KEY `nom_cargue_2` (`nom_cargue`),
  KEY `num_factura_2` (`num_factura`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Archivo de medicamentos AM';


DROP TABLE IF EXISTS `salud_archivo_medicamentos_temp`;
CREATE TABLE `salud_archivo_medicamentos_temp` (
  `id_medicamentos` varchar(1) COLLATE utf8_spanish_ci NOT NULL,
  `num_factura` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Número de la factura " Ver Alineamientos tecnicos para ips ver pag 12"',
  `cod_prest_servicio` bigint(12) NOT NULL COMMENT 'Código del prestador de servicios de salud " Ver Alineamientos tecnicos para ips ver pag 12"',
  `tipo_ident_usuario` enum('CC','CE','PA','RC','TI','AS','MS') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Tipo de identificación del usuario " Ver Alineamientos tecnicos para ips ver pag 14"',
  `num_ident_usuario` bigint(16) NOT NULL COMMENT 'Número de identificación del usuario del sistema " Ver Alineamientos tecnicos para ips ver pag 16"',
  `num_autorizacion` int(15) DEFAULT NULL COMMENT 'Número de autorización " Ver Alineamientos tecnicos para ips ver pag 20" ',
  `cod_medicamento` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Código del medicamento " Ver Alineamientos tecnicos para ips ver pag 41"',
  `tipo_medicamento` enum('1','2') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Tipo de medicamento " Ver Alineamientos tecnicos para ips ver pag 41"',
  `forma_farmaceutica` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Forma farmacéutica" Ver Alineamientos tecnicos para ips ver pag 41"',
  `nom_medicamento` varchar(30) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre genérico del medicamento " Ver Alineamientos tecnicos para ips ver pag 41"',
  `concentracion_medic` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Concentración del medicamento" Ver Alineamientos tecnicos para ips ver pag 41"',
  `um_medicamento` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Unidad de medida del medicamento" Ver Alineamientos tecnicos para ips ver pag 41"',
  `num_und_medic` int(5) NOT NULL COMMENT 'Número de unidades" Ver Alineamientos tecnicos para ips ver pag 41"',
  `valor_unit_medic` double(15,2) NOT NULL COMMENT 'Valor unitario de medicamento " Ver Alineamientos tecnicos para ips ver pag 42"',
  `valor_total_medic` double(15,2) NOT NULL COMMENT 'Valor total del medicamento " Ver Alineamientos tecnicos para ips ver pag 42"',
  `tipo_negociacion` enum('evento','capita') COLLATE utf8_spanish_ci NOT NULL,
  `nom_cargue` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre del archivo con el que se carga',
  `fecha_cargue` datetime NOT NULL COMMENT 'Fecha en que se carga',
  `idUser` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `id_medicamentos` (`id_medicamentos`),
  KEY `num_factura` (`num_factura`),
  KEY `nom_cargue` (`nom_cargue`),
  KEY `nom_cargue_2` (`nom_cargue`),
  KEY `num_factura_2` (`num_factura`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Archivo de medicamentos AM';


DROP TABLE IF EXISTS `salud_archivo_nacidos`;
CREATE TABLE `salud_archivo_nacidos` (
  `id_recien_nacido` int(20) NOT NULL AUTO_INCREMENT,
  `num_factura` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Número de la factura " Ver Alineamientos tecnicos para ips ver pag 12"',
  `cod_prest_servicio` bigint(12) NOT NULL COMMENT 'Código del prestador de servicios de salud " Ver Alineamientos tecnicos para ips ver pag 12"',
  `tipo_ident_usuario` enum('CC','CE','PA','RC','TI','AS','MS') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Tipo de identificación de la madre " Ver Alineamientos tecnicos para ips ver pag 14"',
  `num_ident_usuario` bigint(16) NOT NULL COMMENT 'Número de identificación de la madre en el Sistema " Ver Alineamientos tecnicos para ips ver pag 39"',
  `fecha_nacimiento_rn` date NOT NULL COMMENT 'Fecha de nacimiento del recién nacido " Ver Alineamientos tecnicos para ips ver pag 39"',
  `hora_nacimiento_rc` time NOT NULL COMMENT 'Hora de nacimiento " Ver Alineamientos tecnicos para ips ver pag 39"',
  `edad_gestacional` int(2) NOT NULL COMMENT 'Edad gestacional " Ver Alineamientos tecnicos para ips ver pag 39 "',
  `control_prenatal` enum('1','2') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Control prenatal " Ver Alineamientos tecnicos para ips ver pag 39"',
  `sexo_rc` enum('1','2') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Sexo del recien nacido " Ver Alineamientos tecnicos para ips ver pag 39"',
  `peso_rc` int(4) NOT NULL COMMENT 'Peso del recien nacido " Ver Alineamientos tecnicos para ips ver pag 39"',
  `diagn_rc` varchar(4) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Diagnóstico del recién nacido " Ver Alineamientos tecnicos para ips ver pag 39"',
  `causa_muerte_rc` varchar(4) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Causa básica de muerte recien nacido " Ver Alineamientos tecnicos para ips ver pag 40"',
  `fecha_muerte_rc` date NOT NULL COMMENT 'Fecha de muerte del recién nacido " Ver Alineamientos tecnicos para ips ver pag 40"',
  `hora_muerte_rc` time NOT NULL COMMENT 'Hora de muerte del recién nacido " Ver Alineamientos tecnicos para ips ver pag 40"',
  `tipo_negociacion` enum('evento','capita') COLLATE utf8_spanish_ci NOT NULL,
  `nom_cargue` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre del archivo con el que se carga',
  `fecha_cargue` datetime NOT NULL COMMENT 'Fecha en que se carga',
  `idUser` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id_recien_nacido`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Archivo de recien nacidos AN';


DROP TABLE IF EXISTS `salud_archivo_nacidos_temp`;
CREATE TABLE `salud_archivo_nacidos_temp` (
  `id_recien_nacido` varchar(1) COLLATE utf8_spanish_ci NOT NULL,
  `num_factura` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Número de la factura " Ver Alineamientos tecnicos para ips ver pag 12"',
  `cod_prest_servicio` bigint(12) NOT NULL COMMENT 'Código del prestador de servicios de salud " Ver Alineamientos tecnicos para ips ver pag 12"',
  `tipo_ident_usuario` enum('CC','CE','PA','RC','TI','AS','MS') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Tipo de identificación de la madre " Ver Alineamientos tecnicos para ips ver pag 14"',
  `num_ident_usuario` bigint(16) NOT NULL COMMENT 'Número de identificación de la madre en el Sistema " Ver Alineamientos tecnicos para ips ver pag 39"',
  `fecha_nacimiento_rn` date NOT NULL COMMENT 'Fecha de nacimiento del recién nacido " Ver Alineamientos tecnicos para ips ver pag 39"',
  `hora_nacimiento_rc` time NOT NULL COMMENT 'Hora de nacimiento " Ver Alineamientos tecnicos para ips ver pag 39"',
  `edad_gestacional` int(2) NOT NULL COMMENT 'Edad gestacional " Ver Alineamientos tecnicos para ips ver pag 39 "',
  `control_prenatal` enum('1','2') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Control prenatal " Ver Alineamientos tecnicos para ips ver pag 39"',
  `sexo_rc` enum('1','2') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Sexo del recien nacido " Ver Alineamientos tecnicos para ips ver pag 39"',
  `peso_rc` int(4) NOT NULL COMMENT 'Peso del recien nacido " Ver Alineamientos tecnicos para ips ver pag 39"',
  `diagn_rc` varchar(4) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Diagnóstico del recién nacido " Ver Alineamientos tecnicos para ips ver pag 39"',
  `causa_muerte_rc` varchar(4) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Causa básica de muerte recien nacido " Ver Alineamientos tecnicos para ips ver pag 40"',
  `fecha_muerte_rc` date NOT NULL COMMENT 'Fecha de muerte del recién nacido " Ver Alineamientos tecnicos para ips ver pag 40"',
  `hora_muerte_rc` time NOT NULL COMMENT 'Hora de muerte del recién nacido " Ver Alineamientos tecnicos para ips ver pag 40"',
  `tipo_negociacion` enum('evento','capita') COLLATE utf8_spanish_ci NOT NULL,
  `nom_cargue` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre del archivo con el que se carga',
  `fecha_cargue` datetime NOT NULL COMMENT 'Fecha en que se carga',
  `idUser` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `id_recien_nacido` (`id_recien_nacido`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Archivo de recien nacidos AN';


DROP TABLE IF EXISTS `salud_archivo_otros_servicios`;
CREATE TABLE `salud_archivo_otros_servicios` (
  `id_otro_servicios` int(20) NOT NULL AUTO_INCREMENT,
  `num_factura` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Número de la factura " Ver Alineamientos tecnicos para ips ver pag 12"',
  `cod_prest_servicio` bigint(12) NOT NULL COMMENT 'Código del prestador de servicios de salud " Ver Alineamientos tecnicos para ips ver pag 12"',
  `tipo_ident_usuario` enum('CC','CE','PA','RC','TI','AS','MS') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Tipo de identificación del usuario " Ver Alineamientos tecnicos para ips ver pag 14"',
  `num_ident_usuario` bigint(16) NOT NULL COMMENT 'Número de identificación del usuario del sistema " Ver Alineamientos tecnicos para ips ver pag 16"',
  `num_autorizacion` int(15) DEFAULT NULL COMMENT 'Número de autorización " Ver Alineamientos tecnicos para ips ver pag 20" ',
  `tipo_servicio` enum('1','2','3','4') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Tipo de servicio " Ver Alineamientos tecnicos para ips ver pag 43"',
  `cod_servicio` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Código del servicio " Ver Alineamientos tecnicos para ips ver pag 44"',
  `nom_servicio` varchar(30) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre del servicio " Ver Alineamientos tecnicos para ips ver pag 44"',
  `cantidad` int(5) NOT NULL COMMENT 'Cantidad" Ver Alineamientos tecnicos para ips ver pag 44"',
  `valor_unit_material` double(15,2) NOT NULL COMMENT 'Valor unitario del material e insumo " Ver Alineamientos tecnicos para ips ver pag 45"',
  `valor_total_material` double(15,2) NOT NULL COMMENT 'Valor total del material e insumo " Ver Alineamientos tecnicos para ips ver pag 45"',
  `tipo_negociacion` enum('evento','capita') COLLATE utf8_spanish_ci NOT NULL,
  `nom_cargue` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre del archivo con el que se carga',
  `fecha_cargue` datetime NOT NULL COMMENT 'Fecha en que se carga',
  `idUser` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id_otro_servicios`),
  KEY `nom_cargue` (`nom_cargue`),
  KEY `num_factura` (`num_factura`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Archivo de otros servicios AT';


DROP TABLE IF EXISTS `salud_archivo_otros_servicios_temp`;
CREATE TABLE `salud_archivo_otros_servicios_temp` (
  `id_otro_servicios` varchar(1) COLLATE utf8_spanish_ci NOT NULL,
  `num_factura` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Número de la factura " Ver Alineamientos tecnicos para ips ver pag 12"',
  `cod_prest_servicio` bigint(12) NOT NULL COMMENT 'Código del prestador de servicios de salud " Ver Alineamientos tecnicos para ips ver pag 12"',
  `tipo_ident_usuario` enum('CC','CE','PA','RC','TI','AS','MS') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Tipo de identificación del usuario " Ver Alineamientos tecnicos para ips ver pag 14"',
  `num_ident_usuario` bigint(16) NOT NULL COMMENT 'Número de identificación del usuario del sistema " Ver Alineamientos tecnicos para ips ver pag 16"',
  `num_autorizacion` int(15) DEFAULT NULL COMMENT 'Número de autorización " Ver Alineamientos tecnicos para ips ver pag 20" ',
  `tipo_servicio` enum('1','2','3','4') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Tipo de servicio " Ver Alineamientos tecnicos para ips ver pag 43"',
  `cod_servicio` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Código del servicio " Ver Alineamientos tecnicos para ips ver pag 44"',
  `nom_servicio` varchar(30) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre del servicio " Ver Alineamientos tecnicos para ips ver pag 44"',
  `cantidad` int(5) NOT NULL COMMENT 'Cantidad" Ver Alineamientos tecnicos para ips ver pag 44"',
  `valor_unit_material` double(15,2) NOT NULL COMMENT 'Valor unitario del material e insumo " Ver Alineamientos tecnicos para ips ver pag 45"',
  `valor_total_material` double(15,2) NOT NULL COMMENT 'Valor total del material e insumo " Ver Alineamientos tecnicos para ips ver pag 45"',
  `tipo_negociacion` enum('evento','capita') COLLATE utf8_spanish_ci NOT NULL,
  `nom_cargue` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre del archivo con el que se carga',
  `fecha_cargue` datetime NOT NULL COMMENT 'Fecha en que se carga',
  `idUser` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `id_otro_servicios` (`id_otro_servicios`),
  KEY `nom_cargue` (`nom_cargue`),
  KEY `num_factura` (`num_factura`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Archivo de otros servicios AT';


DROP TABLE IF EXISTS `salud_archivo_procedimientos`;
CREATE TABLE `salud_archivo_procedimientos` (
  `id_procedimiento` int(20) NOT NULL AUTO_INCREMENT,
  `num_factura` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Número de la factura " Ver Alineamientos tecnicos para ips ver pag 12"',
  `cod_prest_servicio` bigint(12) NOT NULL COMMENT 'Código del prestador de servicios de salud " Ver Alineamientos tecnicos para ips ver pag 12"',
  `tipo_ident_usuario` enum('CC','CE','PA','RC','TI','AS','MS') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Tipo de identificación del usuario " Ver Alineamientos tecnicos para ips ver pag 14"',
  `num_ident_usuario` bigint(16) NOT NULL COMMENT 'Número de identificación del usuario del sistema " Ver Alineamientos tecnicos para ips ver pag 16"',
  `fecha_procedimiento` date NOT NULL COMMENT 'Fecha del procedimiento " Ver Alineamientos tecnicos para ips ver pag 29"',
  `num_autorizacion` int(15) DEFAULT NULL COMMENT 'Número de autorización " Ver Alineamientos tecnicos para ips ver pag 20" ',
  `cod_procedimiento` varchar(7) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Código del procedimiento " Ver Alineamientos tecnicos para ips ver pag 29"',
  `ambito_reali_procedimiento` enum('1','2','3') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Ámbito de realización del procedimiento " Ver Alineamientos tecnicos para ips ver pag 29"',
  `finalidad_procedimiento` enum('1','2','3','4','5') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Finalidad del procedimiento " Ver Alineamientos tecnicos para ips ver pag 29"',
  `personal_atiende` enum('1','2','3','4','5') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Personal que atiende " Ver Alineamientos tecnicos para ips ver pag 29"',
  `cod_diagn_princ_procedimiento` varchar(4) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Diagnóstico principal " Ver Alineamientos tecnicos para ips ver pag 29"',
  `cod_diagn_relac_procedimiento` varchar(4) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Código del diagnóstico relacionado " Ver Alineamientos tecnicos para ips ver pag 30"',
  `complicaciones` varchar(4) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Complicación " Ver Alineamientos tecnicos para ips ver pag 30"',
  `realizacion_quirurgico` enum('1','2','3','4','5') COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Forma de realización del acto quirúrgico " Ver Alineamientos tecnicos para ips ver pag 30"',
  `valor_procedimiento` double(15,2) DEFAULT NULL COMMENT 'Valor del procedimiento " Ver Alineamientos tecnicos para ips ver pag 31"',
  `tipo_negociacion` enum('evento','capita') COLLATE utf8_spanish_ci NOT NULL,
  `nom_cargue` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre del archivo con el que se carga',
  `fecha_cargue` datetime NOT NULL COMMENT 'Fecha en que se carga',
  `idUser` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id_procedimiento`),
  KEY `nom_cargue` (`nom_cargue`),
  KEY `num_factura` (`num_factura`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Archivo de procedimientos AP';


DROP TABLE IF EXISTS `salud_archivo_procedimientos_temp`;
CREATE TABLE `salud_archivo_procedimientos_temp` (
  `id_procedimiento` varchar(1) COLLATE utf8_spanish_ci NOT NULL,
  `num_factura` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Número de la factura " Ver Alineamientos tecnicos para ips ver pag 12"',
  `cod_prest_servicio` bigint(12) NOT NULL COMMENT 'Código del prestador de servicios de salud " Ver Alineamientos tecnicos para ips ver pag 12"',
  `tipo_ident_usuario` enum('CC','CE','PA','RC','TI','AS','MS') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Tipo de identificación del usuario " Ver Alineamientos tecnicos para ips ver pag 14"',
  `num_ident_usuario` bigint(16) NOT NULL COMMENT 'Número de identificación del usuario del sistema " Ver Alineamientos tecnicos para ips ver pag 16"',
  `fecha_procedimiento` date NOT NULL COMMENT 'Fecha del procedimiento " Ver Alineamientos tecnicos para ips ver pag 29"',
  `num_autorizacion` int(15) DEFAULT NULL COMMENT 'Número de autorización " Ver Alineamientos tecnicos para ips ver pag 20" ',
  `cod_procedimiento` varchar(7) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Código del procedimiento " Ver Alineamientos tecnicos para ips ver pag 29"',
  `ambito_reali_procedimiento` enum('1','2','3') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Ámbito de realización del procedimiento " Ver Alineamientos tecnicos para ips ver pag 29"',
  `finalidad_procedimiento` enum('1','2','3','4','5') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Finalidad del procedimiento " Ver Alineamientos tecnicos para ips ver pag 29"',
  `personal_atiende` enum('1','2','3','4','5') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Personal que atiende " Ver Alineamientos tecnicos para ips ver pag 29"',
  `cod_diagn_princ_procedimiento` varchar(4) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Diagnóstico principal " Ver Alineamientos tecnicos para ips ver pag 29"',
  `cod_diagn_relac_procedimiento` varchar(4) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Código del diagnóstico relacionado " Ver Alineamientos tecnicos para ips ver pag 30"',
  `complicaciones` varchar(4) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Complicación " Ver Alineamientos tecnicos para ips ver pag 30"',
  `realizacion_quirurgico` enum('1','2','3','4','5') COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Forma de realización del acto quirúrgico " Ver Alineamientos tecnicos para ips ver pag 30"',
  `valor_procedimiento` double(15,2) DEFAULT NULL COMMENT 'Valor del procedimiento " Ver Alineamientos tecnicos para ips ver pag 31"',
  `tipo_negociacion` enum('evento','capita') COLLATE utf8_spanish_ci NOT NULL,
  `nom_cargue` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre del archivo con el que se carga',
  `fecha_cargue` datetime NOT NULL COMMENT 'Fecha en que se carga',
  `idUser` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `id_procedimiento` (`id_procedimiento`),
  KEY `nom_cargue` (`nom_cargue`),
  KEY `num_factura` (`num_factura`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Archivo de procedimientos AP';


DROP TABLE IF EXISTS `salud_archivo_urgencias`;
CREATE TABLE `salud_archivo_urgencias` (
  `id_urgencias` int(20) NOT NULL AUTO_INCREMENT,
  `num_factura` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Número de la factura " Ver Alineamientos tecnicos para ips ver pag 12"',
  `cod_prest_servicio` bigint(12) NOT NULL COMMENT 'Código del prestador de servicios de salud " Ver Alineamientos tecnicos para ips ver pag 12"',
  `tipo_ident_usuario` enum('CC','CE','PA','RC','TI','AS','MS') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Tipo de identificación del usuario " Ver Alineamientos tecnicos para ips ver pag 14"',
  `num_ident_usuario` bigint(16) NOT NULL COMMENT 'Número de identificación del usuario del sistema " Ver Alineamientos tecnicos para ips ver pag 16"',
  `fecha_ingreso` date NOT NULL COMMENT 'Fecha de ingreso del usuario a observación " Ver Alineamientos tecnicos para ips ver pag 31"',
  `hora_ingreso` time NOT NULL COMMENT 'Hora de ingreso del usuario a observación " Ver Alineamientos tecnicos para ips ver pag 31"',
  `num_autorizacion` int(15) DEFAULT NULL COMMENT 'Número de autorización " Ver Alineamientos tecnicos para ips ver pag 32" ',
  `causa_externa` enum('01','02','03','04','05','06','07','08','09','10','11','12','13','14','15') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Causa externa " Ver Alineamientos tecnicos para ips ver pag 32"',
  `diagnostico_salida` varchar(4) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Diagnóstico a la salida " Ver Alineamientos tecnicos para ips ver pag 32"',
  `diagn_relac1_salida` varchar(4) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Diagnóstico relacionado Nro. 1 a la salida " Ver Alineamientos tecnicos para ips ver pag 33"',
  `diagn_relac2_salida` varchar(4) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Diagnóstico relacionado Nro. 2 a la salida " Ver Alineamientos tecnicos para ips ver pag 33"',
  `diagn_relac3_salida` varchar(4) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Diagnóstico relacionado Nro. 3 a la salida " Ver Alineamientos tecnicos para ips ver pag 33"',
  `destino_usuario` enum('1','2','3') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Destino del usuario a la salida de observacion " Ver Alineamientos tecnicos para ips ver pag 29"',
  `estado_salida` enum('1','2') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Estado a la salida " Ver Alineamientos tecnicos para ips ver pag 34"',
  `causa_muerte` varchar(4) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Causa básica de muerte en urgencias " Ver Alineamientos tecnicos para ips ver pag 34"',
  `fecha_salida` date NOT NULL COMMENT 'Fecha de la salida del usuario en observación " Ver Alineamientos tecnicos para ips ver pag 34"',
  `hora_salida` time NOT NULL COMMENT 'Hora de la salida del usuario en observación " Ver Alineamientos tecnicos para ips ver pag 31"',
  `tipo_negociacion` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `nom_cargue` varchar(15) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre del archivo con el que se carga',
  `fecha_cargue` datetime NOT NULL COMMENT 'Fecha en que se carga',
  `idUser` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id_urgencias`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Archivo de urgencias AU';


DROP TABLE IF EXISTS `salud_archivo_urgencias_temp`;
CREATE TABLE `salud_archivo_urgencias_temp` (
  `id_urgencias` varchar(1) COLLATE utf8_spanish_ci NOT NULL,
  `num_factura` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Número de la factura " Ver Alineamientos tecnicos para ips ver pag 12"',
  `cod_prest_servicio` bigint(12) NOT NULL COMMENT 'Código del prestador de servicios de salud " Ver Alineamientos tecnicos para ips ver pag 12"',
  `tipo_ident_usuario` enum('CC','CE','PA','RC','TI','AS','MS') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Tipo de identificación del usuario " Ver Alineamientos tecnicos para ips ver pag 14"',
  `num_ident_usuario` bigint(16) NOT NULL COMMENT 'Número de identificación del usuario del sistema " Ver Alineamientos tecnicos para ips ver pag 16"',
  `fecha_ingreso` date NOT NULL COMMENT 'Fecha de ingreso del usuario a observación " Ver Alineamientos tecnicos para ips ver pag 31"',
  `hora_ingreso` time NOT NULL COMMENT 'Hora de ingreso del usuario a observación " Ver Alineamientos tecnicos para ips ver pag 31"',
  `num_autorizacion` int(15) DEFAULT NULL COMMENT 'Número de autorización " Ver Alineamientos tecnicos para ips ver pag 32" ',
  `causa_externa` enum('01','02','03','04','05','06','07','08','09','10','11','12','13','14','15') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Causa externa " Ver Alineamientos tecnicos para ips ver pag 32"',
  `diagnostico_salida` varchar(4) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Diagnóstico a la salida " Ver Alineamientos tecnicos para ips ver pag 32"',
  `diagn_relac1_salida` varchar(4) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Diagnóstico relacionado Nro. 1 a la salida " Ver Alineamientos tecnicos para ips ver pag 33"',
  `diagn_relac2_salida` varchar(4) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Diagnóstico relacionado Nro. 2 a la salida " Ver Alineamientos tecnicos para ips ver pag 33"',
  `diagn_relac3_salida` varchar(4) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Diagnóstico relacionado Nro. 3 a la salida " Ver Alineamientos tecnicos para ips ver pag 33"',
  `destino_usuario` enum('1','2','3') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Destino del usuario a la salida de observacion " Ver Alineamientos tecnicos para ips ver pag 29"',
  `estado_salida` enum('1','2') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Estado a la salida " Ver Alineamientos tecnicos para ips ver pag 34"',
  `causa_muerte` varchar(4) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Causa básica de muerte en urgencias " Ver Alineamientos tecnicos para ips ver pag 34"',
  `fecha_salida` date NOT NULL COMMENT 'Fecha de la salida del usuario en observación " Ver Alineamientos tecnicos para ips ver pag 34"',
  `hora_salida` time NOT NULL COMMENT 'Hora de la salida del usuario en observación " Ver Alineamientos tecnicos para ips ver pag 31"',
  `tipo_negociacion` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `nom_cargue` varchar(15) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre del archivo con el que se carga',
  `fecha_cargue` datetime NOT NULL COMMENT 'Fecha en que se carga',
  `idUser` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Archivo de urgencias AU';


DROP TABLE IF EXISTS `salud_archivo_usuarios`;
CREATE TABLE `salud_archivo_usuarios` (
  `id_usuarios_salud` int(20) NOT NULL AUTO_INCREMENT,
  `tipo_ident_usuario` enum('CC','CE','PA','RC','TI','AS','MS') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Tipo de identificación del usuario " Ver Alineamientos tecnicos para ips ver pag 14"',
  `num_ident_usuario` bigint(16) NOT NULL COMMENT 'Número de identificación del usuario del sistema " Ver Alineamientos tecnicos para ips ver pag 16"',
  `cod_ident_adm_pb` varchar(6) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Código entidad administradora de planes de beneficio (EPS) " Ver Alineamientos tecnicos para ips ver pag 16"',
  `tipo_usuario` enum('1','2','3','4','5','6','7','8') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Tipo de usuario " Ver Alineamientos tecnicos para ips ver pag 16"',
  `primer_ape_usuario` varchar(30) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Primer apellido del usuario " Ver Alineamientos tecnicos para ips ver pag 17"',
  `segundo_ape_usuario` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Segundo apellido del usuario " Ver Alineamientos tecnicos para ips ver pag 17"',
  `primer_nom_usuario` varchar(30) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Primer nombre del usuario " Ver Alineamientos tecnicos para ips ver pag 17"',
  `segundo_nom_usuario` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Segundo nombre del usuario " Ver Alineamientos tecnicos para ips ver pag 17"',
  `edad` int(3) NOT NULL COMMENT 'Edad " Ver Alineamientos tecnicos para ips ver pag 17 "',
  `unidad_medida_edad` enum('1','2','3') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Unidad de medida de la edad " Ver Alineamientos tecnicos para ips ver pag 17"',
  `sexo` enum('M','F') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Sexo del usuario " Ver Alineamientos tecnicos para ips ver pag 18"',
  `cod_depa_residencial` int(2) NOT NULL COMMENT 'Código del departamento de residencia habitual " Ver Alineamientos tecnicos para ips ver pag 18"',
  `cod_muni_residencial` int(3) NOT NULL COMMENT 'Código del municipio de residencia habitual " Ver Alineamientos tecnicos para ips ver pag 18"',
  `zona_residencial` enum('U','R') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Zona de residencia habitual " Ver Alineamientos tecnicos para ips ver pag 18"',
  `nom_cargue` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre del archivo con el que se carga',
  `fecha_cargue` datetime NOT NULL COMMENT 'Fecha en que se carga',
  `idUser` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id_usuarios_salud`),
  KEY `num_ident_usuario` (`num_ident_usuario`),
  KEY `primer_ape_usuario` (`primer_ape_usuario`),
  KEY `segundo_ape_usuario` (`segundo_ape_usuario`),
  KEY `primer_nom_usuario` (`primer_nom_usuario`),
  KEY `segundo_nom_usuario` (`segundo_nom_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=COMPACT COMMENT='Archivo de usuarios US';


DROP TABLE IF EXISTS `salud_archivo_usuarios_temp`;
CREATE TABLE `salud_archivo_usuarios_temp` (
  `id_usuarios_salud` varchar(1) COLLATE utf8_spanish_ci NOT NULL DEFAULT '',
  `tipo_ident_usuario` enum('CC','CE','PA','RC','TI','AS','MS') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Tipo de identificación del usuario " Ver Alineamientos tecnicos para ips ver pag 14"',
  `num_ident_usuario` bigint(16) NOT NULL COMMENT 'Número de identificación del usuario del sistema " Ver Alineamientos tecnicos para ips ver pag 16"',
  `cod_ident_adm_pb` varchar(6) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Código entidad administradora de planes de beneficio (EPS) " Ver Alineamientos tecnicos para ips ver pag 16"',
  `tipo_usuario` enum('1','2','3','4','5','6','7','8') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Tipo de usuario " Ver Alineamientos tecnicos para ips ver pag 16"',
  `primer_ape_usuario` varchar(30) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Primer apellido del usuario " Ver Alineamientos tecnicos para ips ver pag 17"',
  `segundo_ape_usuario` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Segundo apellido del usuario " Ver Alineamientos tecnicos para ips ver pag 17"',
  `primer_nom_usuario` varchar(30) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Primer nombre del usuario " Ver Alineamientos tecnicos para ips ver pag 17"',
  `segundo_nom_usuario` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Segundo nombre del usuario " Ver Alineamientos tecnicos para ips ver pag 17"',
  `edad` int(3) NOT NULL COMMENT 'Edad " Ver Alineamientos tecnicos para ips ver pag 17 "',
  `unidad_medida_edad` enum('1','2','3') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Unidad de medida de la edad " Ver Alineamientos tecnicos para ips ver pag 17"',
  `sexo` enum('M','F') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Sexo del usuario " Ver Alineamientos tecnicos para ips ver pag 18"',
  `cod_depa_residencial` int(2) NOT NULL COMMENT 'Código del departamento de residencia habitual " Ver Alineamientos tecnicos para ips ver pag 18"',
  `cod_muni_residencial` int(3) NOT NULL COMMENT 'Código del municipio de residencia habitual " Ver Alineamientos tecnicos para ips ver pag 18"',
  `zona_residencial` enum('U','R') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Zona de residencia habitual " Ver Alineamientos tecnicos para ips ver pag 18"',
  `nom_cargue` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre del archivo con el que se carga',
  `fecha_cargue` datetime NOT NULL COMMENT 'Fecha en que se carga',
  `idUser` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `id_usuarios_salud` (`id_usuarios_salud`),
  KEY `num_ident_usuario` (`num_ident_usuario`),
  KEY `primer_ape_usuario` (`primer_ape_usuario`),
  KEY `segundo_ape_usuario` (`segundo_ape_usuario`),
  KEY `primer_nom_usuario` (`primer_nom_usuario`),
  KEY `segundo_nom_usuario` (`segundo_nom_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=COMPACT COMMENT='Archivo de usuarios US';


DROP TABLE IF EXISTS `salud_bancos`;
CREATE TABLE `salud_bancos` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `nit_banco` bigint(12) NOT NULL COMMENT 'NIT del banco',
  `banco_transaccion` varchar(45) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre del banco donde entra la transaccion',
  `tipo_cuenta` enum('ahorros','corriente') COLLATE utf8_spanish_ci NOT NULL COMMENT 'tipo de cuenta',
  `num_cuenta_banco` varchar(30) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Numero de cuenta en la cual entra la transaccion',
  `observacion` text COLLATE utf8_spanish_ci COMMENT 'observaciones de diagnostico ',
  `fecha_hora_registro` datetime DEFAULT NULL COMMENT 'fecha y hora del registro',
  `user` int(2) DEFAULT NULL COMMENT 'usuario que registra',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Archivo de banco';


DROP TABLE IF EXISTS `salud_cie10`;
CREATE TABLE `salud_cie10` (
  `ID` int(20) NOT NULL,
  `codigo_sistema` varchar(4) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'SubCategoria de diagnostico ',
  `descripcion_cups` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Descrpcion de la Clasificacion internacional de Emfermedades ',
  `observacion` varchar(6) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'observaciones de CIE ',
  `fecha_hora_registro` datetime DEFAULT NULL COMMENT 'fecha y hora del registro',
  `user` int(2) DEFAULT NULL COMMENT 'usuario que registra',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Archivo de Clasificacion internacional de Emfermedades CIE10';


DROP TABLE IF EXISTS `salud_circular030_inicial`;
CREATE TABLE `salud_circular030_inicial` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `TipoRegistro` int(1) NOT NULL,
  `Consecutivo` int(10) NOT NULL,
  `tipo_ident_erp` enum('NI','MU','DE','DI') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Tipo de ERP Empresa responsable del pago" Ver circulra 030 anexo tecnico 2"',
  `num_ident_erp` bigint(12) NOT NULL COMMENT 'Número de identificación de ERP Empresa responsable del pago" Ver circulra 030 anexo tecnico 2"',
  `razon_social` varchar(250) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Razón social de ERP Empresa responsable del pago" Ver circulra 030 anexo tecnico 2"',
  `tipo_ident_ips` enum('NI') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Tipo de identificación de ips " Ver circulra 030 anexo tecnico 2"',
  `num_ident_ips` bigint(12) NOT NULL COMMENT 'Número de identificación de ips " Ver circulra 030 anexo tecnico 2"',
  `tipo_cobro` enum('F','R') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Tipo de cobro " Ver circulra 030 anexo tecnico 2"',
  `pref_factura` varchar(6) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Prefijo factura o recobro " Ver circulra 030 anexo tecnico 2"',
  `num_factura` int(20) NOT NULL COMMENT 'Número de la factura o recobro " Ver circulra 030 anexo tecnico 2"',
  `indic_act_fact` enum('I','A','E') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Prefijo factura o recobro "Ver circulra 030 anexo tecnico 2"',
  `valor_factura` double(15,2) NOT NULL COMMENT 'Valor de la factura o recobro " Ver circulra 030 anexo tecnico 2"',
  `fecha_factura` date NOT NULL COMMENT 'Fecha de expedición de la factura " Ver circulra 030 anexo tecnico 2"',
  `fecha_radicado` date NOT NULL COMMENT 'Fecha de la radicacion de la factura " Ver circulra 030 anexo tecnico 2"',
  `fecha_devolucion` date DEFAULT NULL COMMENT 'Fecha de la devolucion de la factura " Ver circulra 030 anexo tecnico 2"',
  `valor_total_pagos` double(15,2) NOT NULL COMMENT 'Valor total de los pagos aplicados a la factura o recobro " Ver circulra 030 anexo tecnico 2"',
  `valor_glosa_acept` double(15,2) NOT NULL COMMENT 'Valor glosa aceptada de la factura o recobro segun la notificacion de la glosa de la ERP " Ver circulra 030 anexo tecnico 2"',
  `glosa_respondida` enum('SI','NO') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Glosa fue respondida " Ver circulra 030 anexo tecnico 2"',
  `saldo_factura` double(15,2) NOT NULL COMMENT 'Saldo pendiente de la cancelacion de la factura o recobro debe ser igual al valor de la factura o recobro menos la glosa aceptada y menos los pagos aplicados "Ver circulra 030 anexo tecnico 2"',
  `cobro_juridico` enum('SI','NO') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Factura o recobro se encuentra en cobro juridico" Ver circulra 030 anexo tecnico 2"',
  `etapa_proceso` enum('0','1','2','3','4','5','6','7','8') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Etapa en que se encuentra el proceso "Ver circulra 030 anexo tecnico 2"',
  `numero_factura` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `fecha_cargue` datetime NOT NULL,
  `idUser` int(11) NOT NULL,
  `Cod_Entidad_Administradora` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Circular 030 inicial, esta debe ser otorgada por el cliente';


DROP TABLE IF EXISTS `salud_circular_030_control`;
CREATE TABLE `salud_circular_030_control` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `TipoRegistro` int(1) NOT NULL,
  `TipoIdentificacion` varchar(2) COLLATE latin1_spanish_ci NOT NULL DEFAULT 'NI',
  `NumIdentificacion` bigint(20) NOT NULL,
  `RazonSocial` varchar(250) COLLATE latin1_spanish_ci NOT NULL,
  `FechaInicial` date NOT NULL,
  `FechaFinal` date NOT NULL,
  `NumRegistros` bigint(10) NOT NULL,
  `idUser` int(11) NOT NULL,
  `FechaGeneracion` datetime NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;


DROP TABLE IF EXISTS `salud_cobros_prejuridicos`;
CREATE TABLE `salud_cobros_prejuridicos` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `TipoCobro` enum('1','2','3','4') COLLATE latin1_spanish_ci NOT NULL,
  `Fecha` date NOT NULL,
  `Observaciones` text COLLATE latin1_spanish_ci NOT NULL,
  `idUser` int(11) NOT NULL,
  `Soporte` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `Fecha` (`Fecha`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;


DROP TABLE IF EXISTS `salud_cobros_prejuridicos_relaciones`;
CREATE TABLE `salud_cobros_prejuridicos_relaciones` (
  `idCobroPrejuridico` int(11) NOT NULL,
  `num_factura` varchar(45) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `idCobroPrejuridico` (`idCobroPrejuridico`),
  KEY `num_factura` (`num_factura`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;


DROP TABLE IF EXISTS `salud_cups`;
CREATE TABLE `salud_cups` (
  `ID` int(20) NOT NULL,
  `grupo` varchar(2) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Grupo de diagnostico ',
  `subgrupo` varchar(1) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'SubGrupo de diagnostico ',
  `categoria` varchar(1) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Categoria de diagnostico ',
  `subcategoria` varchar(2) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'SubCategoria de diagnostico ',
  `codigo_ley` varchar(9) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'SubCategoria de diagnostico ',
  `codigo_sistema` varchar(6) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'SubCategoria de diagnostico ',
  `descripcion_cups` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Descrpcion del C.U.P.S ',
  `observacion` varchar(6) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'observaciones de diagnostico ',
  `fecha_hora_registro` datetime DEFAULT NULL COMMENT 'fecha y hora del registro',
  `user` int(2) DEFAULT NULL COMMENT 'usuario que registra',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  KEY `codigo_sistema` (`codigo_sistema`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Archivo de cups';


DROP TABLE IF EXISTS `salud_dias_habiles`;
CREATE TABLE `salud_dias_habiles` (
  `fecha_dia` date NOT NULL COMMENT 'fecha del dia',
  `dia` enum('lunes','martes','miercoles','jueves','viernes','sabado','domingo') COLLATE utf8_spanish_ci NOT NULL COMMENT 'dia de la semana',
  `tipo_dia` enum('festivo','dominical','sabatino','normal','') COLLATE utf8_spanish_ci NOT NULL COMMENT 'tipo de dia',
  `estado_dia` enum('habil','no habil','','') COLLATE utf8_spanish_ci NOT NULL COMMENT 'estado de dia es habil o no lo es',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='tabla para controlar los días hábiles';


DROP TABLE IF EXISTS `salud_eps`;
CREATE TABLE `salud_eps` (
  `ID` int(20) NOT NULL AUTO_INCREMENT,
  `cod_pagador_min` varchar(6) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Codigo del pagador ante el ministerio de salud ',
  `nit` bigint(20) NOT NULL,
  `sigla_nombre` varchar(120) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre corto del pagador del servicio salud',
  `nombre_completo` varchar(50) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre completo del pagador del servicio',
  `tipo_regimen` enum('SUBSIDIADO','CONTRIBUTIVO','REGIMEN ESPECIAL','ENTE TERRITORIAL','ENTE MUNICIPAL','OTRAS ENTIDADES','ENTIDAD EN LIQUIDACION') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Tipo de regimen',
  `dias_convenio` int(11) NOT NULL,
  `Nombre_gerente` varchar(50) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre del gerente del pagador',
  `saldo_inicial` double NOT NULL,
  `fecha_saldo_inicial` date NOT NULL,
  `Genera030` varchar(1) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'S',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `cod_pagador_min` (`cod_pagador_min`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='directorio de empresas promotoras de salud (EPS)';


DROP TABLE IF EXISTS `salud_facturas_radicacion_numero`;
CREATE TABLE `salud_facturas_radicacion_numero` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idFactura` bigint(20) NOT NULL,
  `idUser` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;


DROP TABLE IF EXISTS `salud_pagos_temporal`;
CREATE TABLE `salud_pagos_temporal` (
  `id_temp_rips_generados` varchar(1) COLLATE latin1_spanish_ci NOT NULL,
  `Proceso` varchar(45) COLLATE latin1_spanish_ci NOT NULL,
  `CodigoEPS` varchar(10) COLLATE latin1_spanish_ci NOT NULL,
  `NombreEPS` varchar(100) COLLATE latin1_spanish_ci NOT NULL,
  `FormaContratacion` enum('Evento','Capitacion') COLLATE latin1_spanish_ci NOT NULL,
  `Departamento` varchar(100) COLLATE latin1_spanish_ci NOT NULL,
  `Municipio` varchar(100) COLLATE latin1_spanish_ci NOT NULL,
  `FechaFactura` date NOT NULL,
  `PrefijoFactura` varchar(10) COLLATE latin1_spanish_ci NOT NULL,
  `NumeroFactura` bigint(20) NOT NULL,
  `ValorGiro` double NOT NULL,
  `FechaPago` date NOT NULL,
  `NumeroGiro` bigint(20) NOT NULL,
  `nom_cargue` varchar(20) COLLATE latin1_spanish_ci NOT NULL,
  `fecha_cargue` datetime NOT NULL,
  `Soporte` varchar(200) COLLATE latin1_spanish_ci NOT NULL,
  `numero_factura` varchar(45) COLLATE latin1_spanish_ci NOT NULL,
  `idUser` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;


DROP TABLE IF EXISTS `salud_procesos_gerenciales`;
CREATE TABLE `salud_procesos_gerenciales` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Fecha` date NOT NULL,
  `EPS` varchar(20) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `NombreProceso` text COLLATE latin1_spanish_ci NOT NULL,
  `Concepto` varchar(45) COLLATE latin1_spanish_ci NOT NULL,
  `idUser` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;


DROP TABLE IF EXISTS `salud_procesos_gerenciales_archivos`;
CREATE TABLE `salud_procesos_gerenciales_archivos` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `idProceso` int(11) NOT NULL,
  `Fecha` date NOT NULL,
  `Observaciones` text COLLATE latin1_spanish_ci NOT NULL,
  `Soporte` varchar(200) COLLATE latin1_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;


DROP TABLE IF EXISTS `salud_procesos_gerenciales_conceptos`;
CREATE TABLE `salud_procesos_gerenciales_conceptos` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Concepto` varchar(45) COLLATE latin1_spanish_ci NOT NULL,
  `Observaciones` text COLLATE latin1_spanish_ci NOT NULL,
  `idUser` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;


DROP TABLE IF EXISTS `salud_registro_glosas`;
CREATE TABLE `salud_registro_glosas` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `num_factura` varchar(30) COLLATE latin1_spanish_ci NOT NULL,
  `PrefijoArchivo` enum('AC','AM','AP','AT','AF') COLLATE latin1_spanish_ci NOT NULL COMMENT 'AC, AM, AP, AT,AF',
  `idArchivo` bigint(20) NOT NULL COMMENT 'id de la tabla',
  `TipoGlosa` enum('1','2','3','4','5') COLLATE latin1_spanish_ci NOT NULL COMMENT '1 inicial, 2 levantada, 3 aceptada, 4 X Conciliar,5 Devuelta',
  `CodigoGlosa` int(11) NOT NULL COMMENT 'Codigo de la glosa',
  `FechaReporte` date NOT NULL COMMENT 'Fecha de reporte o gestion',
  `GlosaEPS` double NOT NULL COMMENT 'Valor que La EPS dice que hay Glosa',
  `GlosaAceptada` double NOT NULL COMMENT 'Valor que la IPS esta dispuesta a perder',
  `Soporte` varchar(100) COLLATE latin1_spanish_ci NOT NULL COMMENT 'Documento que soporta la decision o gestion',
  `Observaciones` text COLLATE latin1_spanish_ci NOT NULL COMMENT 'Lo que el gestor gestionó',
  `cod_enti_administradora` varchar(20) COLLATE latin1_spanish_ci NOT NULL,
  `fecha_factura` date NOT NULL,
  `idUser` int(11) NOT NULL COMMENT 'usuario que ingresó el registro',
  `TablaOrigen` varchar(45) COLLATE latin1_spanish_ci NOT NULL COMMENT 'tabla donde esta el archiv',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;


DROP TABLE IF EXISTS `salud_rips_facturas_generadas_temp`;
CREATE TABLE `salud_rips_facturas_generadas_temp` (
  `id_temp_rips_generados` varchar(1) COLLATE utf8_spanish_ci NOT NULL,
  `cod_prest_servicio` bigint(12) NOT NULL COMMENT 'Código del prestador de servicios de salud " Ver Alineamientos tecnicos para ips ver pag 12"',
  `razon_social` varchar(60) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Razón social o apellidos y nombre del prestado " Ver Alineamientos tecnicos para ips ver pag 12"',
  `tipo_ident_prest_servicio` enum('NI','CC','CE','PA') COLLATE utf8_spanish_ci NOT NULL COMMENT 'Tipo de identificación del prestador de servicios de salud " Ver Alineamientos tecnicos para ips ver pag 12"',
  `num_ident_prest_servicio` bigint(20) NOT NULL COMMENT 'Número de identificación del prestador de servicios de salud " Ver Alineamientos tecnicos para ips ver pag 12"',
  `num_factura` varchar(20) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Número de la factura " Ver Alineamientos tecnicos para ips ver pag 12"',
  `fecha_factura` date NOT NULL COMMENT 'Fecha de expedición de la factura " Ver Alineamientos tecnicos para ips ver pag 13"',
  `fecha_inicio` date NOT NULL COMMENT 'Fecha de inicio " Ver Alineamientos tecnicos para ips ver pag 13"',
  `fecha_final` date NOT NULL COMMENT 'Fecha final " Ver Alineamientos tecnicos para ips ver pag 13"',
  `cod_enti_administradora` varchar(6) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Código entidad administradora " Ver Alineamientos tecnicos para ips ver pag 13"',
  `nom_enti_administradora` varchar(30) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre entidad administradora " Ver Alineamientos tecnicos para ips ver pag 13" ',
  `num_contrato` varchar(15) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Número del contrato " Ver Alineamientos tecnicos para ips ver pag 13"',
  `plan_beneficios` varchar(30) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Plan de beneficios " Ver Alineamientos tecnicos para ips ver pag 13"',
  `num_poliza` varchar(10) COLLATE utf8_spanish_ci DEFAULT NULL COMMENT 'Número de la póliza " Ver Alineamientos tecnicos para ips ver pag 13" ',
  `valor_total_pago` double(15,2) NOT NULL COMMENT 'Valor total del pago compartido copago " Ver Alineamientos tecnicos para ips ver pag 14"',
  `valor_comision` double(15,2) NOT NULL COMMENT 'Valor de la comisión " Ver Alineamientos tecnicos para ips ver pag 14"',
  `valor_descuentos` double(15,2) NOT NULL COMMENT 'Valor total de descuentos " Ver Alineamientos tecnicos para ips ver pag 14"',
  `valor_neto_pagar` double(15,2) NOT NULL COMMENT 'Valor neto a pagar por la entidad contratante " Ver Alineamientos tecnicos para ips ver pag 14"',
  `tipo_negociacion` enum('evento','capita') COLLATE utf8_spanish_ci NOT NULL,
  `fecha_radicado` date NOT NULL,
  `numero_radicado` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Soporte` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `Escenario` varchar(15) COLLATE utf8_spanish_ci NOT NULL,
  `CuentaGlobal` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `CuentaRIPS` int(6) unsigned zerofill NOT NULL,
  `nom_cargue` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `fecha_cargue` datetime NOT NULL,
  `idUser` int(11) NOT NULL,
  `LineaArchivo` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `id_temp_rips_generados` (`id_temp_rips_generados`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Archivo temporal de rips generados';


DROP TABLE IF EXISTS `salud_tesoreria`;
CREATE TABLE `salud_tesoreria` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `cod_enti_administradora` varchar(6) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Código entidad que paga',
  `nom_enti_administradora` varchar(30) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre entidad que paga',
  `fecha_transaccion` date NOT NULL COMMENT 'fecha entra el dinero al banco',
  `num_transaccion` varchar(45) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Numero de la transaccion con la cual entra al banco',
  `banco_transaccion` varchar(10) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre del banco donde entra la transaccion',
  `num_cuenta_banco` varchar(30) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Numero de cuenta en la cual entra la transaccion',
  `valor_transaccion` double(15,2) NOT NULL COMMENT 'Valor de transaccion ',
  `Soporte` varchar(200) COLLATE utf8_spanish_ci NOT NULL COMMENT 'Soporte que argumenta  o justifica el pago',
  `observacion` text COLLATE utf8_spanish_ci COMMENT 'observaciones de diagnostico ',
  `fecha_hora_registro` datetime DEFAULT NULL COMMENT 'fecha y hora del registro',
  `idUser` int(11) DEFAULT NULL COMMENT 'usuario que registra',
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci COMMENT='Archivo de tesoreria';


DROP TABLE IF EXISTS `salud_tipo_glosas`;
CREATE TABLE `salud_tipo_glosas` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TipoGlosa` varchar(15) COLLATE latin1_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;


DROP TABLE IF EXISTS `salud_upload_control`;
CREATE TABLE `salud_upload_control` (
  `id_upload_control` bigint(20) NOT NULL AUTO_INCREMENT,
  `nom_cargue` varchar(45) COLLATE latin1_spanish_ci NOT NULL,
  `fecha_cargue` datetime NOT NULL,
  `idUser` int(11) NOT NULL,
  `Analizado` bit(1) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id_upload_control`),
  KEY `nom_cargue` (`nom_cargue`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;


DROP TABLE IF EXISTS `servidores`;
CREATE TABLE `servidores` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `IP` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Nombre` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Usuario` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `Password` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `DataBase` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `subcuentas`;
CREATE TABLE `subcuentas` (
  `PUC` int(11) NOT NULL,
  `Nombre` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Valor` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Cuentas_idPUC` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`PUC`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `tablas_campos_control`;
CREATE TABLE `tablas_campos_control` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `NombreTabla` varchar(100) COLLATE latin1_spanish_ci NOT NULL,
  `Campo` varchar(100) COLLATE latin1_spanish_ci NOT NULL,
  `Visible` int(1) NOT NULL,
  `Editable` int(1) NOT NULL,
  `Habilitado` int(1) NOT NULL,
  `TipoUser` varchar(45) COLLATE latin1_spanish_ci NOT NULL,
  `idUser` int(11) NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;


DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `idUsuarios` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Apellido` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Identificacion` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  `Telefono` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Login` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Password` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `TipoUser` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Email` varchar(45) COLLATE utf8_spanish_ci DEFAULT NULL,
  `Role` varchar(45) COLLATE utf8_spanish_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`idUsuarios`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


DROP TABLE IF EXISTS `usuarios_tipo`;
CREATE TABLE `usuarios_tipo` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Tipo` varchar(45) COLLATE utf8_spanish2_ci NOT NULL,
  `Updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Sync` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;


-- 2018-07-17 14:10:30
