--
-- 1.  Vista para ver las facturas pagas
--
DROP VIEW IF EXISTS `vista_salud_facturas_pagas`;
CREATE VIEW vista_salud_facturas_pagas AS 
SELECT t1.`id_fac_mov_generados` as id_factura_generada,t1.`cod_prest_servicio`,t1.`razon_social`,t1.`num_factura`,t1.`fecha_factura`,
t1.`cod_enti_administradora`,t1.`nom_enti_administradora`,t1.`valor_neto_pagar`,t2.`id_pagados` as id_factura_pagada,t2.`fecha_pago_factura`,t2.`valor_pagado`,t2.`num_pago` ,t1.`tipo_negociacion`,
t1.`dias_pactados`,t1.`fecha_radicado`,t1.`numero_radicado`,t1.`Soporte` 
FROM salud_archivo_facturacion_mov_generados t1 INNER JOIN salud_archivo_facturacion_mov_pagados t2 ON t1.`num_factura`=t2.`num_factura`
WHERE t1.estado='PAGADA';
--
-- 2. Vista para seleccionar lo que se pagó pero no fue generado
--
DROP VIEW IF EXISTS `vista_salud_facturas_no_pagas`;
CREATE VIEW vista_salud_facturas_no_pagas AS 
SELECT t1.`id_fac_mov_generados` as id_factura_generada, 
(SELECT DATEDIFF(now(),t1.`fecha_radicado` ) - t1.`dias_pactados`) as DiasMora ,t1.`cod_prest_servicio`,t1.`razon_social`,t1.`num_factura`,
t1.`fecha_factura`, t1.`fecha_radicado`,t1.`numero_radicado`,t1.`cod_enti_administradora`,t1.`nom_enti_administradora`,t1.`valor_neto_pagar` ,t1.`tipo_negociacion`, 
t1.`dias_pactados`,t1.`Soporte`,t1.`EstadoCobro`
FROM salud_archivo_facturacion_mov_generados t1 WHERE t1.tipo_negociacion='evento' AND (t1.estado='RADICADO' OR t1.estado=''); 
--
-- 3. Vista para ver las facturas con diferencias
--
DROP VIEW IF EXISTS `vista_salud_facturas_diferencias`;
CREATE VIEW vista_salud_facturas_diferencias AS 
SELECT t1.`id_fac_mov_generados` as id_factura_generada,t1.`cod_prest_servicio`,t1.`razon_social`,t1.`num_factura`,t1.`fecha_factura`,
t1.`cod_enti_administradora`,t1.`nom_enti_administradora`,t1.`valor_neto_pagar`,t2.`id_pagados` as id_factura_pagada,t2.`fecha_pago_factura`,t2.`valor_pagado`,t2.`num_pago` ,
(SELECT t1.`valor_neto_pagar`-t2.`valor_pagado`) as DiferenciaEnPago ,t1.`tipo_negociacion`,
t1.`dias_pactados`,t1.`fecha_radicado`,t1.`numero_radicado`,t1.`Soporte` 
FROM salud_archivo_facturacion_mov_generados t1 INNER JOIN salud_archivo_facturacion_mov_pagados t2 ON t1.`num_factura`=t2.`num_factura`
WHERE t1.estado='DIFERENCIA' AND t1.tipo_negociacion='evento';

--
-- 4. Vista para seleccionar lo que se pagó pero no fue generado
--
DROP VIEW IF EXISTS `vista_salud_pagas_no_generadas`;
CREATE VIEW vista_salud_pagas_no_generadas AS 
Select T1.* From salud_archivo_facturacion_mov_pagados T1 
Left Outer Join salud_archivo_facturacion_mov_generados T2 ON T1.num_factura = T2.num_factura 
where T2.num_factura is null ;
--
-- 5. Vista para ver los cobros prejuridicos
--

DROP VIEW IF EXISTS `vista_salud_facturas_prejuridicos`;
CREATE VIEW vista_salud_facturas_prejuridicos AS 
SELECT t2.`id_fac_mov_generados` as ID,t1.idCobroPrejuridico,t2.`num_factura`,`cod_prest_servicio`,`razon_social`,`num_ident_prest_servicio`,`fecha_factura`,`cod_enti_administradora`,`nom_enti_administradora`,`valor_neto_pagar`,`tipo_negociacion`,`fecha_radicado`,`numero_radicado`,`Soporte` as SoporteRadicado,(SELECT Soporte FROM salud_cobros_prejuridicos WHERE ID=t1.idCobroPrejuridico) AS SoporteCobro,`estado` as EstadoFactura,`EstadoCobro` FROM `salud_cobros_prejuridicos_relaciones` t1 
INNER JOIN salud_archivo_facturacion_mov_generados t2 ON t1.`num_factura`=t2.`num_factura`
WHERE t2.EstadoCobro='PREJURIDICO1' OR t2.EstadoCobro='PREJURIDICO2';

--
-- 6. Vista para los procesos gerenciales
--
DROP VIEW IF EXISTS `vista_salud_procesos_gerenciales`;
CREATE VIEW vista_salud_procesos_gerenciales AS 
SELECT t1.`ID` as ID,t1.`idProceso` as idProceso,t1.`Fecha` as Fecha,
(SELECT nombre_completo FROM salud_eps WHERE cod_pagador_min=t2.EPS) as EPS,
t2.`NombreProceso`,t2.`Concepto`,t1.`Observaciones`,t1.`Soporte`
FROM `salud_procesos_gerenciales_archivos` t1 
INNER JOIN salud_procesos_gerenciales t2 ON t1.`idProceso`=t2.`ID`;

DROP VIEW IF EXISTS `vista_af`;
CREATE VIEW vista_af AS
SELECT *,(SELECT Genera030 FROM salud_eps WHERE salud_eps.cod_pagador_min=`salud_archivo_facturacion_mov_generados`. cod_enti_administradora) as GeneraCircular FROM `salud_archivo_facturacion_mov_generados` ;


DROP VIEW IF EXISTS `vista_SIHO`;
CREATE VIEW vista_SIHO AS 
SELECT t1.`id_fac_mov_generados` as id_factura_generada, (SELECT dias_convenio FROM salud_eps WHERE salud_eps.cod_pagador_min=t1.cod_enti_administradora) as diasPago,
(SELECT DATEDIFF('2018-05-02',t1.`fecha_radicado` ) - (SELECT(diasPago))) as DiasMora ,t1.`cod_prest_servicio`,t1.`razon_social`,t1.`num_factura`,
t1.`fecha_factura`, t1.`fecha_radicado`,t1.`numero_radicado`,t1.`cod_enti_administradora`,t1.`nom_enti_administradora`,t1.`valor_neto_pagar` ,t1.`tipo_negociacion`, 
 t1.estado
FROM salud_archivo_facturacion_mov_generados t1 WHERE (t1.estado != 'PAGADA' AND t1.estado != 'DEVUELTA'  AND t1.estado != ''); 


DROP VIEW IF EXISTS `vista_af_duplicados`;
CREATE VIEW vista_af_duplicados AS 
SELECT t2.`id_fac_mov_generados` as ID,t1.`num_factura`,t1.`fecha_factura`,t1.`LineaArchivo`,t2.CuentaGlobal, t2.CuentaRIPS,
t2.EstadoGlosa,t2.fecha_cargue FROM `salud_rips_facturas_generadas_temp` t1 
INNER JOIN salud_archivo_facturacion_mov_generados t2 ON t1.`num_factura`=t2.`num_factura` 
WHERE t2.`EstadoGlosa`<>9;


DROP VIEW IF EXISTS `vista_af_devueltos`;
CREATE VIEW vista_af_devueltos AS 
SELECT t2.`id_fac_mov_generados` as ID,t1.`num_factura`,t1.`fecha_factura`,t1.`LineaArchivo`,t2.CuentaGlobal, t2.CuentaRIPS,
t2.EstadoGlosa,t2.fecha_cargue FROM `salud_rips_facturas_generadas_temp` t1 
INNER JOIN salud_archivo_facturacion_mov_generados t2 ON t1.`num_factura`=t2.`num_factura` 
WHERE t2.`EstadoGlosa`=9;


DROP VIEW IF EXISTS `vista_salud_cuentas_rips`;
CREATE VIEW vista_salud_cuentas_rips AS 
SELECT `CuentaRIPS`,CuentaGlobal ,`cod_enti_administradora`,`nom_enti_administradora`,
(SELECT sigla_nombre FROM salud_eps WHERE salud_eps.cod_pagador_min = cod_enti_administradora) as NombreCortoEPS,
(SELECT MIN(`fecha_factura`)) AS FechaDesde,
(SELECT MAX(`fecha_factura`)) AS FechaHasta,`fecha_radicado`,`numero_radicado`, 
(COUNT(`id_fac_mov_generados`)) AS NumFacturas,sum(`valor_neto_pagar`) as Total, MIN(EstadoGlosa) as idEstadoGlosa,
(SELECT Estado_glosa FROM salud_estado_glosas WHERE salud_estado_glosas.ID = MIN(`EstadoGlosa`)) as EstadoGlosa

FROM `salud_archivo_facturacion_mov_generados` GROUP BY `CuentaRIPS`;


DROP VIEW IF EXISTS `vista_salud_facturas_glosas`;
CREATE VIEW vista_salud_facturas_glosas AS 
SELECT `CuentaRIPS`,CuentaGlobal ,`cod_enti_administradora`,`nom_enti_administradora`,
`fecha_radicado` as FechaRadicado,`numero_radicado`, num_factura,fecha_factura,fecha_radicado,EstadoGlosa,
(SELECT tipo_ident_usuario FROM salud_archivo_consultas WHERE salud_archivo_consultas.num_factura = salud_archivo_facturacion_mov_generados.num_factura LIMIT 1) as TipoID,
(SELECT num_ident_usuario FROM salud_archivo_consultas WHERE salud_archivo_consultas.num_factura = salud_archivo_facturacion_mov_generados.num_factura LIMIT 1) as NumIdentificacion

FROM `salud_archivo_facturacion_mov_generados`;


DROP VIEW IF EXISTS `vista_salud_glosas_masivas`;
CREATE VIEW vista_salud_glosas_masivas AS 
SELECT `ID`,FechaIPS,FechaAuditoria,ValorGlosado,Analizado,GlosaInicial,GlosaControlRespuestas,CodigoActividad,Observaciones,Soporte,
(SELECT num_factura FROM salud_archivo_facturacion_mov_generados WHERE `salud_glosas_masivas_temp`.`num_factura`=salud_archivo_facturacion_mov_generados.num_factura) AS Factura,
(SELECT `CuentaRips` FROM salud_archivo_facturacion_mov_generados WHERE `salud_glosas_masivas_temp`.`num_factura`=salud_archivo_facturacion_mov_generados.num_factura AND `salud_glosas_masivas_temp`.`CuentaRips`=salud_archivo_facturacion_mov_generados.CuentaRIPS) AS CuentaRIPS,
(SELECT cod_enti_administradora FROM salud_archivo_facturacion_mov_generados WHERE salud_glosas_masivas_temp.`ID_EPS`=salud_archivo_facturacion_mov_generados.cod_enti_administradora AND `salud_glosas_masivas_temp`.`num_factura`=salud_archivo_facturacion_mov_generados.num_factura) AS CodEps,
(SELECT nit FROM salud_eps WHERE `salud_glosas_masivas_temp`.`NIT_EPS`=salud_eps.nit AND `salud_glosas_masivas_temp`.`ID_EPS`=salud_eps.cod_pagador_min) AS NIT,
(SELECT cod_glosa FROM salud_archivo_conceptos_glosas WHERE `salud_glosas_masivas_temp`.`CodigoGlosa`=salud_archivo_conceptos_glosas.cod_glosa) AS CodigoGlosa,

(SELECT cod_medicamento FROM salud_archivo_medicamentos WHERE salud_archivo_medicamentos.num_factura=salud_glosas_masivas_temp.num_factura 
AND salud_archivo_medicamentos.cod_medicamento=salud_glosas_masivas_temp.CodigoActividad LIMIT 1) AS CodigoActividadAM,
(SELECT nom_medicamento FROM salud_archivo_medicamentos WHERE salud_archivo_medicamentos.num_factura=salud_glosas_masivas_temp.num_factura 
AND salud_archivo_medicamentos.cod_medicamento=salud_glosas_masivas_temp.CodigoActividad LIMIT 1) AS NombreActividadAM,
(SELECT SUM(valor_total_medic) FROM salud_archivo_medicamentos WHERE salud_archivo_medicamentos.num_factura=salud_glosas_masivas_temp.num_factura 
AND salud_archivo_medicamentos.cod_medicamento=salud_glosas_masivas_temp.CodigoActividad LIMIT 1) AS TotalAM,

(SELECT cod_servicio FROM salud_archivo_otros_servicios WHERE salud_archivo_otros_servicios.num_factura=salud_glosas_masivas_temp.num_factura 
AND salud_archivo_otros_servicios.cod_servicio=salud_glosas_masivas_temp.CodigoActividad LIMIT 1) AS CodigoActividadAT,
(SELECT nom_servicio FROM salud_archivo_otros_servicios WHERE salud_archivo_otros_servicios.num_factura=salud_glosas_masivas_temp.num_factura 
AND salud_archivo_otros_servicios.cod_servicio=salud_glosas_masivas_temp.CodigoActividad LIMIT 1) AS NombreActividadAT,

(SELECT SUM(valor_total_material) FROM salud_archivo_otros_servicios WHERE salud_archivo_otros_servicios.num_factura=salud_glosas_masivas_temp.num_factura 
AND salud_archivo_otros_servicios.cod_servicio=salud_glosas_masivas_temp.CodigoActividad LIMIT 1) AS TotalAT,

(SELECT cod_procedimiento FROM salud_archivo_procedimientos WHERE salud_archivo_procedimientos.num_factura=salud_glosas_masivas_temp.num_factura 
AND salud_archivo_procedimientos.cod_procedimiento=salud_glosas_masivas_temp.CodigoActividad LIMIT 1) AS CodigoActividadAP,

(SELECT descripcion_cups FROM salud_cups WHERE salud_cups.codigo_sistema=salud_glosas_masivas_temp.CodigoActividad LIMIT 1) AS NombreActividad,

(SELECT SUM(valor_procedimiento) FROM salud_archivo_procedimientos WHERE salud_archivo_procedimientos.num_factura=salud_glosas_masivas_temp.num_factura 
AND salud_archivo_procedimientos.cod_procedimiento=salud_glosas_masivas_temp.CodigoActividad LIMIT 1) AS TotalAP,


(SELECT cod_consulta FROM salud_archivo_consultas WHERE salud_archivo_consultas.num_factura=salud_glosas_masivas_temp.num_factura 
AND salud_archivo_consultas.cod_consulta=salud_glosas_masivas_temp.CodigoActividad LIMIT 1) AS CodigoActividadAC,
(SELECT SUM(valor_consulta) FROM salud_archivo_consultas WHERE salud_archivo_consultas.num_factura=salud_glosas_masivas_temp.num_factura 
AND salud_archivo_consultas.cod_consulta=salud_glosas_masivas_temp.CodigoActividad LIMIT 1) AS TotalAC,

(SELECT ID FROM salud_glosas_iniciales WHERE salud_glosas_iniciales.num_factura=salud_glosas_masivas_temp.num_factura 
AND salud_glosas_iniciales.CodigoActividad=salud_glosas_masivas_temp.CodigoActividad 
AND salud_glosas_iniciales.CodigoGlosa=salud_glosas_masivas_temp.CodigoGlosa LIMIT 1) AS idGlosa,

(SELECT ID FROM salud_glosas_iniciales_temp WHERE salud_glosas_iniciales_temp.num_factura=salud_glosas_masivas_temp.num_factura 
AND salud_glosas_iniciales_temp.CodigoActividad=salud_glosas_masivas_temp.CodigoActividad 
AND salud_glosas_iniciales_temp.CodigoGlosa=salud_glosas_masivas_temp.CodigoGlosa LIMIT 1) AS idGlosaTemp

FROM `salud_glosas_masivas_temp`;



DROP VIEW IF EXISTS `vista_salud_consolidaciones_masivas`;
CREATE VIEW vista_salud_consolidaciones_masivas AS 
SELECT `ID`,FechaConciliacion,CuentaRIPS as CuentaRIPSTemp,num_factura,CodigoActividad,ValorLevantado,ValorAceptado,Observaciones,Soporte,Conciliada,
(SELECT FechaConciliacion>NOW()) AS Extemporanea,(SELECT ValorLevantado>0) AS ValorLevantadoPositivo,(SELECT ValorAceptado>0) AS ValorAceptadoPositivo,
(SELECT num_factura FROM salud_archivo_facturacion_mov_generados WHERE `salud_conciliaciones_masivas_temp`.`num_factura`=salud_archivo_facturacion_mov_generados.num_factura) AS Factura,
(SELECT `CuentaRips` FROM salud_archivo_facturacion_mov_generados WHERE `salud_conciliaciones_masivas_temp`.`num_factura`=salud_archivo_facturacion_mov_generados.num_factura AND `salud_conciliaciones_masivas_temp`.`CuentaRips`=salud_archivo_facturacion_mov_generados.CuentaRIPS) AS CuentaRIPS,

(SELECT cod_medicamento FROM salud_archivo_medicamentos WHERE salud_archivo_medicamentos.num_factura=salud_conciliaciones_masivas_temp.num_factura 
AND salud_archivo_medicamentos.cod_medicamento=salud_conciliaciones_masivas_temp.CodigoActividad LIMIT 1) AS CodigoActividadAM,
(SELECT nom_medicamento FROM salud_archivo_medicamentos WHERE salud_archivo_medicamentos.num_factura=salud_conciliaciones_masivas_temp.num_factura 
AND salud_archivo_medicamentos.cod_medicamento=salud_conciliaciones_masivas_temp.CodigoActividad LIMIT 1) AS NombreActividadAM,
(SELECT EstadoGlosa FROM salud_archivo_medicamentos WHERE salud_archivo_medicamentos.num_factura=salud_conciliaciones_masivas_temp.num_factura 
AND salud_archivo_medicamentos.cod_medicamento=salud_conciliaciones_masivas_temp.CodigoActividad LIMIT 1) AS EstadoGlosaAM,
(SELECT SUM(valor_total_medic) FROM salud_archivo_medicamentos WHERE salud_archivo_medicamentos.num_factura=salud_conciliaciones_masivas_temp.num_factura 
AND salud_archivo_medicamentos.cod_medicamento=salud_conciliaciones_masivas_temp.CodigoActividad LIMIT 1) AS TotalAM,


(SELECT cod_servicio FROM salud_archivo_otros_servicios WHERE salud_archivo_otros_servicios.num_factura=salud_conciliaciones_masivas_temp.num_factura 
AND salud_archivo_otros_servicios.cod_servicio=salud_conciliaciones_masivas_temp.CodigoActividad LIMIT 1) AS CodigoActividadAT,
(SELECT nom_servicio FROM salud_archivo_otros_servicios WHERE salud_archivo_otros_servicios.num_factura=salud_conciliaciones_masivas_temp.num_factura 
AND salud_archivo_otros_servicios.cod_servicio=salud_conciliaciones_masivas_temp.CodigoActividad LIMIT 1) AS NombreActividadAT,
(SELECT EstadoGlosa FROM salud_archivo_otros_servicios WHERE salud_archivo_otros_servicios.num_factura=salud_conciliaciones_masivas_temp.num_factura 
AND salud_archivo_otros_servicios.cod_servicio=salud_conciliaciones_masivas_temp.CodigoActividad LIMIT 1) AS EstadoGlosaAT,
(SELECT SUM(valor_total_material) FROM salud_archivo_otros_servicios WHERE salud_archivo_otros_servicios.num_factura=salud_conciliaciones_masivas_temp.num_factura 
AND salud_archivo_otros_servicios.cod_servicio=salud_conciliaciones_masivas_temp.CodigoActividad LIMIT 1) AS TotalAT,


(SELECT cod_procedimiento FROM salud_archivo_procedimientos WHERE salud_archivo_procedimientos.num_factura=salud_conciliaciones_masivas_temp.num_factura 
AND salud_archivo_procedimientos.cod_procedimiento=salud_conciliaciones_masivas_temp.CodigoActividad LIMIT 1) AS CodigoActividadAP,
(SELECT EstadoGlosa FROM salud_archivo_procedimientos WHERE salud_archivo_procedimientos.num_factura=salud_conciliaciones_masivas_temp.num_factura 
AND salud_archivo_procedimientos.cod_procedimiento=salud_conciliaciones_masivas_temp.CodigoActividad LIMIT 1) AS EstadoGlosaAP,
(SELECT SUM(valor_procedimiento) FROM salud_archivo_procedimientos WHERE salud_archivo_procedimientos.num_factura=salud_conciliaciones_masivas_temp.num_factura 
AND salud_archivo_procedimientos.cod_procedimiento=salud_conciliaciones_masivas_temp.CodigoActividad LIMIT 1) AS TotalAP,

(SELECT descripcion_cups FROM salud_cups WHERE salud_cups.codigo_sistema=salud_conciliaciones_masivas_temp.CodigoActividad LIMIT 1) AS NombreActividad,

(SELECT cod_consulta FROM salud_archivo_consultas WHERE salud_archivo_consultas.num_factura=salud_conciliaciones_masivas_temp.num_factura 
AND salud_archivo_consultas.cod_consulta=salud_conciliaciones_masivas_temp.CodigoActividad LIMIT 1) AS CodigoActividadAC,
(SELECT EstadoGlosa FROM salud_archivo_consultas WHERE salud_archivo_consultas.num_factura=salud_conciliaciones_masivas_temp.num_factura 
AND salud_archivo_consultas.cod_consulta=salud_conciliaciones_masivas_temp.CodigoActividad LIMIT 1) AS EstadoGlosaAC,
(SELECT SUM(valor_consulta) FROM salud_archivo_consultas WHERE salud_archivo_consultas.num_factura=salud_conciliaciones_masivas_temp.num_factura 
AND salud_archivo_consultas.cod_consulta=salud_conciliaciones_masivas_temp.CodigoActividad LIMIT 1) AS TotalAC


FROM `salud_conciliaciones_masivas_temp`;



DROP VIEW IF EXISTS `vista_glosas_iniciales`;
CREATE VIEW vista_glosas_iniciales AS 
SELECT *, (SELECT (DATEDIFF(NOW(),FechaIPS))) AS DiasTranscurridos,
(SELECT CuentaRIPS FROM salud_archivo_facturacion_mov_generados 
WHERE salud_archivo_facturacion_mov_generados.num_factura=salud_glosas_iniciales.num_factura) as CuentaRIPS
FROM salud_glosas_iniciales;

DROP VIEW IF EXISTS `vista_salud_cuentas_rips`;
CREATE VIEW vista_salud_cuentas_rips AS 
SELECT `CuentaRIPS`,CuentaGlobal ,`cod_enti_administradora`,`nom_enti_administradora`,(SELECT MIN(`fecha_factura`)) AS FechaDesde,
(SELECT MAX(`fecha_factura`)) AS FechaHasta,`fecha_radicado`,`numero_radicado`, 
(COUNT(`id_fac_mov_generados`)) AS NumFacturas,sum(`valor_neto_pagar`) as Total, MIN(EstadoGlosa) as idEstadoGlosa,
(SELECT Estado_glosa FROM salud_estado_glosas WHERE salud_estado_glosas.ID = MIN(`EstadoGlosa`)) as EstadoGlosa,
(SELECT MAX(DiasTranscurridos) FROM vista_glosas_iniciales WHERE vista_glosas_iniciales.CuentaRIPS=salud_archivo_facturacion_mov_generados.CuentaRIPS) as Dias
FROM `salud_archivo_facturacion_mov_generados` GROUP BY `CuentaRIPS`;

DROP VIEW IF EXISTS `vista_af_semaforo`;
CREATE VIEW vista_af_semaforo AS
SELECT *,
(SELECT MAX(DiasTranscurridos) FROM vista_glosas_iniciales 
WHERE vista_glosas_iniciales.num_factura=salud_archivo_facturacion_mov_generados.num_factura 
AND vista_glosas_iniciales.EstadoGlosa=1) AS Dias
FROM `salud_archivo_facturacion_mov_generados`;


