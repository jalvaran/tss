-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 24, 2018 at 04:49 AM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 5.6.35

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tss`
--

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`ID`, `Nombre`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES
(1, 'Administrar', 1, 'Admin.php', '_BLANK', 1, 'admin.png', 1, '2018-07-13 20:42:31', '2018-07-13 15:42:31'),
(2, 'RIPS', 1, 'MnuRIPS.php', '_BLANK', 1, 'archivos.png', 2, '2018-07-13 20:42:31', '2018-07-13 15:42:31'),
(3, 'Contratación', 1, 'MnuContratacion.php', '_BLANK', 1, 'contratacion.png', 3, '2018-07-13 22:12:16', '2018-07-13 15:42:31'),
(4, 'Facturacion', 1, 'MnuFacturacion.php', '_BLANK', 0, 'factura.png', 4, '2018-07-13 20:42:31', '2018-07-13 15:42:31'),
(5, 'Auditoria', 1, 'MnuAuditoria.php', '_BLANK', 1, 'auditoria.png', 5, '2018-07-13 23:55:11', '2018-07-13 15:42:31'),
(6, 'Cartera', 1, 'MnuCartera.php', '_BLANK', 1, 'egresos.png', 6, '2018-07-13 20:42:31', '2018-07-13 15:42:31'),
(7, 'Juridica', 1, 'MnuJuridica.php', '_BLANK', 1, 'juridica.png', 7, '2018-07-13 22:14:38', '2018-07-13 15:42:31'),
(8, 'Tesorería', 1, 'MnuTesoreria.php', '_BLANK', 1, 'tesoreria.png', 8, '2018-07-13 22:17:39', '2018-07-13 15:42:31'),
(9, 'Almacen Farmaceutico', 3, 'clientes.php', '_BLANK', 0, 'clientes.png', 9, '2018-07-13 20:42:31', '2018-07-13 15:42:31'),
(10, 'Contabilidad', 3, 'proveedores.php', '_BLANK', 0, 'proveedores.png', 10, '2018-07-13 20:42:31', '2018-07-13 15:42:31'),
(11, 'Presupuesto', 1, 'MnuCuentasxPagar.php', '_BLANK', 0, 'cuentasxpagar.png', 11, '2018-07-13 20:42:31', '2018-07-13 15:42:31'),
(12, 'Ajustes y Servicios Generales', 1, 'MnuAjustes.php', '_BLANK', 1, 'ajustes.png', 12, '2018-07-13 20:42:31', '2018-07-13 15:42:31'),
(13, 'Salir', 2, 'destruir.php', '_BLANK', 1, 'salir.png', 13, '2018-07-13 20:42:31', '2018-07-13 15:42:31'),
(14, 'Almacen Farmaceutico', 1, 'MnuAlmacenFarma.php', '_BLANK', 1, 'farmacia.png', 12, '2018-07-13 20:42:31', '2018-07-13 15:42:31'),
(15, 'Contabilidad', 1, 'MnuContabilidad.php', '_BLANK', 1, 'finanzas.png', 12, '2018-07-13 20:42:31', '2018-07-13 15:42:31'),
(16, 'Presupuesto', 1, 'MnuPresupuesto.php', '_BLANK', 1, 'presupuestos.png', 12, '2018-07-13 20:42:31', '2018-07-13 15:42:31'),
(17, 'Gestion Gerencial', 1, 'MnuGestionGerencia.php', '_BLANK', 1, 'gestiondocger.png', 12, '2018-07-13 22:27:55', '2018-07-13 15:42:31');

--
-- Dumping data for table `menu_carpetas`
--

INSERT INTO `menu_carpetas` (`ID`, `Ruta`, `Updated`, `Sync`) VALUES
(1, '', '2018-07-13 20:42:32', '2018-07-13 15:42:32'),
(2, '../', '2018-07-13 20:42:32', '2018-07-13 15:42:32'),
(3, '../VAtencion/', '2018-07-13 20:42:32', '2018-07-13 15:42:32'),
(4, '../VMenu/', '2018-07-13 20:42:32', '2018-07-13 15:42:32'),
(5, '../Graficos/', '2018-07-13 20:42:32', '2018-07-13 15:42:32'),
(6, '../VSalud/', '2018-07-13 20:42:32', '2018-07-13 15:42:32');

--
-- Dumping data for table `menu_pestanas`
--

INSERT INTO `menu_pestanas` (`ID`, `Nombre`, `idMenu`, `Orden`, `Estado`, `Updated`, `Sync`) VALUES
(1, 'Empresa', 1, 1, b'1', '2018-07-13 20:42:33', '2018-07-13 15:42:33'),
(2, 'Usuarios', 1, 2, b'1', '2018-07-13 20:42:33', '2018-07-13 15:42:33'),
(3, 'Crear', 1, 3, b'1', '2018-07-13 20:42:33', '2018-07-13 15:42:33'),
(4, 'Carga', 2, 1, b'1', '2018-07-13 20:42:33', '2018-07-13 15:42:33'),
(5, 'Archivos', 2, 2, b'1', '2018-07-13 20:42:33', '2018-07-13 15:42:33'),
(12, 'Facturacion', 3, 1, b'1', '2018-07-13 20:42:33', '2018-07-13 15:42:33'),
(13, 'Gestion de Glosas', 5, 1, b'1', '2018-07-18 01:26:26', '2018-07-13 15:42:33'),
(15, 'Cuentas X Pagar', 11, 1, b'1', '2018-07-13 20:42:33', '2018-07-13 15:42:33'),
(16, 'Gestion', 17, 1, b'1', '2018-07-13 22:28:40', '2018-07-13 15:42:33'),
(22, 'Backups', 12, 1, b'1', '2018-07-13 20:42:33', '2018-07-13 15:42:33'),
(29, 'Requerimientos', 18, 1, b'1', '2018-07-13 20:42:33', '2018-07-13 15:42:33'),
(30, 'Restaurante', 16, 1, b'1', '2018-07-13 20:42:33', '2018-07-13 15:42:33'),
(31, 'Configuracion', 16, 2, b'1', '2018-07-13 20:42:33', '2018-07-13 15:42:33'),
(32, 'Titulos', 15, 1, b'1', '2018-07-13 20:42:33', '2018-07-13 15:42:33'),
(33, 'Traslados', 24, 1, b'1', '2018-07-13 20:42:33', '2018-07-13 15:42:33'),
(34, 'Seguimiento', 24, 2, b'1', '2018-07-13 20:42:33', '2018-07-13 15:42:33'),
(35, 'Publicidad', 25, 1, b'1', '2018-07-13 20:42:33', '2018-07-13 15:42:33'),
(36, 'RIPS', 6, 1, b'1', '2018-07-13 20:42:33', '2018-07-13 15:42:33'),
(37, 'Reportes', 5, 2, b'1', '2018-07-18 01:26:34', '2018-07-13 15:42:33'),
(39, 'Legal', 7, 3, b'1', '2018-07-13 20:42:33', '2018-07-13 15:42:33'),
(40, 'Informes Gerenciales', 6, 2, b'1', '2018-07-13 20:42:33', '2018-07-13 15:42:33'),
(42, 'Ventas', 28, 1, b'1', '2018-07-13 20:42:33', '2018-07-13 15:42:33'),
(43, 'Tesoreria', 8, 1, b'1', '2018-07-13 20:42:33', '2018-07-13 15:42:33'),
(44, 'Reservas', 29, 1, b'1', '2018-07-13 20:42:33', '2018-07-13 15:42:33'),
(45, 'Modelos', 30, 1, b'1', '2018-07-13 20:42:33', '2018-07-13 15:42:33'),
(46, 'Historicos', 5, 3, b'1', '2018-07-18 01:26:34', '2018-07-13 15:42:33'),
(47, 'Configuraciones', 5, 4, b'1', '2018-07-18 01:27:54', '2018-07-13 15:42:33');

--
-- Dumping data for table `menu_submenus`
--

INSERT INTO `menu_submenus` (`ID`, `Nombre`, `idPestana`, `idCarpeta`, `Pagina`, `Target`, `Estado`, `Image`, `Orden`, `Updated`, `Sync`) VALUES
(1, 'Crear/Editar Empresa', 1, 3, 'empresapro.php', '_SELF', b'1', 'empresa.png', 1, '2018-07-13 20:42:34', '2018-07-13 15:42:34'),
(2, 'Crear/Editar sedes', 1, 3, 'empresa_pro_sucursales.php', '_SELF', b'1', 'sucursal.png', 2, '2018-07-13 20:42:34', '2018-07-13 15:42:34'),
(3, 'Formatos de Calidad', 1, 3, 'formatos_calidad.php', '_SELF', b'1', 'notacredito.png', 4, '2018-07-13 20:42:34', '2018-07-13 15:42:34'),
(4, 'Centros de Costos', 1, 3, 'centrocosto.php', '_SELF', b'1', 'centrocostos.png', 5, '2018-07-13 20:42:34', '2018-07-13 15:42:34'),
(8, 'Costos operativos', 1, 3, 'costos.php', '_SELF', b'1', 'costos.png', 8, '2018-07-13 20:42:34', '2018-07-13 15:42:34'),
(9, 'Crear/Editar un Usuario', 2, 3, 'usuarios.php', '_SELF', b'1', 'usuarios.png', 1, '2018-07-13 20:42:34', '2018-07-13 15:42:34'),
(10, 'Crear/Editar un Tipo de Usuario', 2, 3, 'usuarios_tipo.php', '_SELF', b'1', 'usuariostipo.png', 2, '2018-07-13 20:42:34', '2018-07-13 15:42:34'),
(11, 'Politicas de Acceso', 2, 3, 'paginas_bloques.php', '_SELF', b'1', 'seguridadinformatica.png', 4, '2018-07-13 20:42:34', '2018-07-13 15:42:34'),
(12, 'Listado de EPS', 3, 6, 'salud_eps.php', '_SELF', b'1', 'eps.png', 8, '2018-07-13 20:42:34', '2018-07-13 15:42:34'),
(13, 'Subir RIPS Generados', 4, 6, 'Salud_SubirRips.php', '_SELF', b'1', 'upload2.png', 1, '2018-07-13 20:42:34', '2018-07-13 15:42:34'),
(14, 'Archivo de Consultas AC', 5, 6, 'salud_archivo_consultas.php', '_SELF', b'1', 'ac.png', 7, '2018-07-13 20:42:34', '2018-07-13 15:42:34'),
(15, 'Archivo de Hospitalizaciones AH', 5, 6, 'salud_archivo_hospitalizaciones.php', '_SELF', b'1', 'ah.png', 7, '2018-07-13 20:42:34', '2018-07-13 15:42:34'),
(16, 'Archivo de Medicamentos AM', 5, 6, 'salud_archivo_medicamentos.php', '_SELF', b'1', 'am.png', 3, '2018-07-13 20:42:34', '2018-07-13 15:42:34'),
(17, 'Otros Servicios AT', 5, 6, 'salud_archivo_otros_servicios.php', '_SELF', b'1', 'at.png', 4, '2018-07-13 20:42:34', '2018-07-13 15:42:34'),
(18, 'Archivo de Procedimientos AP', 5, 6, 'salud_archivo_procedimientos.php', '_SELF', b'1', 'ap.jpg', 5, '2018-07-13 20:42:34', '2018-07-13 15:42:34'),
(19, 'Archivo de usuarios US', 5, 6, 'salud_archivo_usuarios.php', '_SELF', b'1', 'us.png', 6, '2018-07-13 20:42:34', '2018-07-13 15:42:34'),
(20, 'Facturacion Generada AF', 5, 6, 'salud_archivo_facturacion_mov_generados.php', '_SELF', b'1', 'af.png', 7, '2018-07-13 20:42:34', '2018-07-13 15:42:34'),
(21, 'Facturacion Recaudada AR', 5, 6, 'salud_archivo_facturacion_mov_pagados.php', '_SELF', b'1', 'ar.png', 8, '2018-07-13 20:42:34', '2018-07-13 15:42:34'),
(22, 'Generar Prejuridicos', 39, 6, 'SaludPrejuridicos.php', '_SELF', b'1', 'prejuridico.jpg', 1, '2018-07-13 20:42:34', '2018-07-13 15:42:34'),
(23, 'Historial Prejuridicos', 39, 6, 'salud_cobros_prejuridicos.php', '_SELF', b'1', 'historial.png', 1, '2018-07-13 20:42:34', '2018-07-13 15:42:34'),
(24, 'Verificar Disponibilidad Local', 22, 3, 'AgregueParametros.php', '_SELF', b'1', 'database.png', 1, '2018-07-13 20:42:34', '2018-07-13 15:42:34'),
(25, 'Crear Backup', 22, 3, 'backups.php', '_SELF', b'1', 'backup.png', 2, '2018-07-13 20:42:34', '2018-07-13 15:42:34'),
(26, 'Procesos Gerenciales', 16, 6, 'salud_procesos_gerenciales.php', '_SELF', b'1', 'gestion.png', 1, '2018-07-13 22:32:09', '2018-07-13 15:42:34'),
(27, 'Subir RIPS de pago', 36, 6, 'Salud_SubirRipsPagos.php', '_SELF', b'1', 'upload.png', 3, '2018-07-13 22:35:12', '2018-07-13 15:42:34'),
(28, 'Radicar Facturas', 36, 6, 'salud_radicacion_facturas.php', '_SELF', b'1', 'radicar.jpg', 2, '2018-07-13 22:35:17', '2018-07-13 15:42:34'),
(29, 'Historial de Facturas Pagas', 36, 6, 'vista_salud_facturas_pagas.php', '_SELF', b'1', 'historial.png', 4, '2018-07-13 22:35:20', '2018-07-13 15:42:34'),
(30, 'Historial de Facturas NO Pagadas', 36, 6, 'vista_salud_facturas_no_pagas.php', '_SELF', b'1', 'historial2.png', 5, '2018-07-13 22:35:24', '2018-07-13 15:42:34'),
(31, 'Historial de Facturas Con Diferencias', 36, 6, 'vista_salud_facturas_diferencias.php', '_SELF', b'1', 'historial3.png', 6, '2018-07-13 22:35:28', '2018-07-13 15:42:34'),
(32, 'Pagos de posibles VIGENCIAS ANTERIORES', 36, 6, 'vista_salud_pagas_no_generadas.php', '_SELF', b'1', 'factura3.png', 8, '2018-07-13 22:35:31', '2018-07-13 15:42:34'),
(33, 'Informe de Estado de Rips', 40, 6, 'SaludInformeEstadoRips.php', '_SELF', b'1', 'estadorips.png', 1, '2018-07-13 22:37:42', '2018-07-13 15:42:34'),
(34, 'Cartera X Edades', 40, 6, 'salud_edad_cartera.php', '_SELF', b'1', 'cartera.png', 2, '2018-07-13 22:37:46', '2018-07-13 15:42:34'),
(35, 'Circular 030', 40, 6, 'salud_genere_circular_030.php', '_SELF', b'1', '030.jpg', 3, '2018-07-13 22:37:50', '2018-07-13 15:42:34'),
(36, 'SIHO', 40, 6, 'SIHO.php', '_SELF', b'1', 'siho.png', 4, '2018-07-13 22:37:54', '2018-07-13 15:42:34'),
(37, 'Diagnostico de RIPS Circular 030', 40, 6, 'salud_edad_cartera.php', '_SELF', b'1', 'diagnostico.png', 3, '2018-07-13 22:37:58', '2018-07-13 15:42:34'),
(38, 'Subir Circular 030 inicial', 40, 6, 'salud_subir_circular_030_inicial.php', '_SELF', b'1', '030_inicial.png', 2, '2018-07-13 22:38:02', '2018-07-13 15:42:34'),
(53, 'Auditoria de Documentos', 21, 3, 'AuditoriaDocumentos.php', '_SELF', b'1', 'auditoria.png', 1, '2018-07-13 20:42:34', '2018-07-13 15:42:34'),
(54, 'Historial de Ediciones', 21, 3, 'registra_ediciones.php', '_SELF', b'1', 'registros.png', 2, '2018-07-13 20:42:34', '2018-07-13 15:42:34'),
(55, 'Historial de pagos ingresados por tesoreria', 43, 6, 'salud_tesoreria.php', '_SELF', b'1', 'historial2.png', 1, '2018-07-13 22:39:50', '2018-07-13 15:42:34'),
(56, 'Registrar Pago', 43, 6, 'Salud_Ingresar_Pago_Tesoreria.php', '_SELF', b'1', 'pago.png', 2, '2018-07-13 22:39:54', '2018-07-13 15:42:34'),
(57, 'Gestion de Glosas', 13, 6, 'SaludGestionGlosas.php', '_SELF', b'1', 'glosas.png', 1, '2018-07-13 20:42:34', '2018-07-13 15:42:34');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
