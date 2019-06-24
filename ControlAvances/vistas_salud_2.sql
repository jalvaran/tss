DROP VIEW IF EXISTS `vista_salud_facturas_pagas`;
CREATE VIEW vista_salud_facturas_pagas AS 
SELECT t1.`id_fac_mov_generados` as id_factura_generada,t1.`CuentaRIPS` as CuentaRIPS,t1.`CuentaGlobal` as CuentaGlobal,t1.`cod_prest_servicio`,t1.`razon_social`,t1.`num_factura`,t1.`fecha_factura`,
t1.`cod_enti_administradora`,t1.`nom_enti_administradora`,t1.`valor_neto_pagar`,t2.`id_pagados` as id_factura_pagada,t2.`fecha_pago_factura`,t2.`valor_pagado`,t2.`num_pago` ,t1.`tipo_negociacion`,
t1.`dias_pactados`,t1.`fecha_radicado`,t1.`numero_radicado`,t1.`Soporte`
FROM salud_archivo_facturacion_mov_generados t1 INNER JOIN salud_archivo_facturacion_mov_pagados t2 ON t1.`num_factura`=t2.`num_factura`
WHERE t1.estado='PAGADA';

DROP VIEW IF EXISTS `vista_salud_facturas_no_pagas`;
CREATE VIEW vista_salud_facturas_no_pagas AS 
SELECT t1.`id_fac_mov_generados` as id_factura_generada, 
(SELECT DATEDIFF(now(),t1.`fecha_radicado` ) - t1.`dias_pactados`) as DiasMora ,t1.`CuentaRIPS` as CuentaRIPS,t1.`CuentaGlobal` as CuentaGlobal,t1.`cod_prest_servicio`,t1.`razon_social`,t1.`num_factura`,
t1.`fecha_factura`, t1.`fecha_radicado`,t1.`numero_radicado`,t1.`cod_enti_administradora`,t1.`nom_enti_administradora`,t1.`valor_neto_pagar` ,t1.`tipo_negociacion`, 
t1.`dias_pactados`,t1.`Soporte`,t1.`EstadoCobro`
FROM salud_archivo_facturacion_mov_generados t1 WHERE t1.tipo_negociacion='evento' AND (t1.estado='RADICADO' OR t1.estado=''); 

DROP VIEW IF EXISTS `vista_salud_facturas_diferencias`;
CREATE VIEW vista_salud_facturas_diferencias AS 
SELECT t1.`id_fac_mov_generados` as id_factura_generada,t1.`CuentaRIPS` as CuentaRIPS,t1.`CuentaGlobal` as CuentaGlobal,t1.`cod_prest_servicio`,t1.`razon_social`,t1.`num_factura`,t1.`fecha_factura`,
t1.`cod_enti_administradora`,t1.`nom_enti_administradora`,t1.`valor_neto_pagar`,t2.`id_pagados` as id_factura_pagada,t2.`fecha_pago_factura`,t2.`valor_pagado`,t2.`num_pago` ,
(SELECT t1.`valor_neto_pagar`-t2.`valor_pagado`) as DiferenciaEnPago ,t1.`tipo_negociacion`,
t1.`dias_pactados`,t1.`fecha_radicado`,t1.`numero_radicado`,t1.`Soporte` 
FROM salud_archivo_facturacion_mov_generados t1 INNER JOIN salud_archivo_facturacion_mov_pagados t2 ON t1.`num_factura`=t2.`num_factura`
WHERE t1.estado='DIFERENCIA' AND t1.tipo_negociacion='evento';

DROP VIEW IF EXISTS `vista_cartera_x_edades`;
CREATE VIEW vista_cartera_x_edades AS 

SELECT 'T' as RangoDias,cod_enti_administradora AS idEPS, nom_enti_administradora,SUM(valor_neto_pagar) AS TotalCartera,COUNT(num_factura) as TotalItems,
(SELECT dias_convenio FROM salud_eps WHERE salud_eps.cod_pagador_min=vista_salud_facturas_no_pagas.cod_enti_administradora LIMIT 1) AS DiasPactados

FROM vista_salud_facturas_no_pagas  GROUP BY cod_enti_administradora

union all

SELECT '1' as RangoDias,cod_enti_administradora AS idEPS, nom_enti_administradora,SUM(valor_neto_pagar) AS TotalCartera,COUNT(num_factura) as TotalItems,
(SELECT dias_convenio FROM salud_eps WHERE salud_eps.cod_pagador_min=vista_salud_facturas_no_pagas.cod_enti_administradora LIMIT 1) AS DiasPactados

FROM vista_salud_facturas_no_pagas WHERE DiasMora<(1) GROUP BY cod_enti_administradora


union all

SELECT '1_30' as RangoDias,cod_enti_administradora AS idEPS, nom_enti_administradora,SUM(valor_neto_pagar) AS TotalCartera,COUNT(num_factura) as TotalItems,
(SELECT dias_convenio FROM salud_eps WHERE salud_eps.cod_pagador_min=vista_salud_facturas_no_pagas.cod_enti_administradora LIMIT 1) AS DiasPactados

FROM vista_salud_facturas_no_pagas WHERE DiasMora>=(1) AND DiasMora<=(30) GROUP BY cod_enti_administradora

union all

SELECT '31_60' as RangoDias,cod_enti_administradora AS idEPS, nom_enti_administradora,SUM(valor_neto_pagar) AS TotalCartera,COUNT(num_factura) as TotalItems,
(SELECT dias_convenio FROM salud_eps WHERE salud_eps.cod_pagador_min=vista_salud_facturas_no_pagas.cod_enti_administradora LIMIT 1) AS DiasPactados

FROM vista_salud_facturas_no_pagas WHERE DiasMora>=(31) AND DiasMora<=(60) GROUP BY cod_enti_administradora

union all

SELECT '61_90' as RangoDias,cod_enti_administradora AS idEPS, nom_enti_administradora,SUM(valor_neto_pagar) AS TotalCartera,COUNT(num_factura) as TotalItems,
(SELECT dias_convenio FROM salud_eps WHERE salud_eps.cod_pagador_min=vista_salud_facturas_no_pagas.cod_enti_administradora LIMIT 1) AS DiasPactados

FROM vista_salud_facturas_no_pagas WHERE DiasMora>=(61) AND DiasMora<=(90) GROUP BY cod_enti_administradora

union all

SELECT '91_120' as RangoDias,cod_enti_administradora AS idEPS, nom_enti_administradora,SUM(valor_neto_pagar) AS TotalCartera,COUNT(num_factura) as TotalItems,
(SELECT dias_convenio FROM salud_eps WHERE salud_eps.cod_pagador_min=vista_salud_facturas_no_pagas.cod_enti_administradora LIMIT 1) AS DiasPactados

FROM vista_salud_facturas_no_pagas WHERE DiasMora>=(91) AND DiasMora<=(120) GROUP BY cod_enti_administradora

union all

SELECT '121_180' as RangoDias,cod_enti_administradora AS idEPS, nom_enti_administradora,SUM(valor_neto_pagar) AS TotalCartera,COUNT(num_factura) as TotalItems,
(SELECT dias_convenio FROM salud_eps WHERE salud_eps.cod_pagador_min=vista_salud_facturas_no_pagas.cod_enti_administradora LIMIT 1) AS DiasPactados

FROM vista_salud_facturas_no_pagas WHERE DiasMora>=(121) AND DiasMora<=(180) GROUP BY cod_enti_administradora

union all

SELECT '181_360' as RangoDias,cod_enti_administradora AS idEPS, nom_enti_administradora,SUM(valor_neto_pagar) AS TotalCartera,COUNT(num_factura) as TotalItems,
(SELECT dias_convenio FROM salud_eps WHERE salud_eps.cod_pagador_min=vista_salud_facturas_no_pagas.cod_enti_administradora LIMIT 1) AS DiasPactados

FROM vista_salud_facturas_no_pagas WHERE DiasMora>=(181) AND DiasMora<=(360) GROUP BY cod_enti_administradora

union all

SELECT '360' as RangoDias,cod_enti_administradora AS idEPS, nom_enti_administradora,SUM(valor_neto_pagar) AS TotalCartera,COUNT(num_factura) as TotalItems,
(SELECT dias_convenio FROM salud_eps WHERE salud_eps.cod_pagador_min=vista_salud_facturas_no_pagas.cod_enti_administradora LIMIT 1) AS DiasPactados

FROM vista_salud_facturas_no_pagas WHERE DiasMora>=(360) GROUP BY cod_enti_administradora;


DROP VIEW IF EXISTS `vista_salud_procesos_gerenciales`;
CREATE VIEW vista_salud_procesos_gerenciales AS 
SELECT t1.`ID` as ID,t1.`idProceso` as idProceso,t1.`Fecha` as Fecha,
(SELECT RazonSocial FROM empresapro WHERE idEmpresaPro=t2.IPS LIMIT 1) as IPS,
(SELECT nombre_completo FROM salud_eps WHERE cod_pagador_min=t2.EPS LIMIT 1) as EPS,

t2.`NombreProceso`,t2.`Concepto`,t1.`Observaciones`,t1.`Soporte`
FROM `salud_procesos_gerenciales_archivos` t1 
INNER JOIN salud_procesos_gerenciales t2 ON t1.`idProceso`=t2.`ID`;



DROP VIEW IF EXISTS `vista_salud_facturas_no_pagas`;
CREATE VIEW vista_salud_facturas_no_pagas AS 
SELECT t1.`id_fac_mov_generados` as id_factura_generada, 
(SELECT DATEDIFF(now(),t1.`fecha_radicado` ) - t1.`dias_pactados`) as DiasMora ,t1.`CuentaRIPS` as CuentaRIPS,t1.`CuentaGlobal` as CuentaGlobal,t1.`cod_prest_servicio`,t1.`razon_social`,t1.`num_factura`,
t1.`fecha_factura`, t1.`fecha_radicado`,t1.`numero_radicado`,t1.`cod_enti_administradora`,t1.`nom_enti_administradora`,t1.`valor_neto_pagar` ,t1.`tipo_negociacion`, 
t1.`dias_pactados`,t1.`Soporte`,t1.`EstadoCobro`
FROM salud_archivo_facturacion_mov_generados t1 WHERE (t1.estado='RADICADO' OR t1.estado=''); 

DROP VIEW IF EXISTS `vista_salud_facturas_diferencias`;
CREATE VIEW vista_salud_facturas_diferencias AS 
SELECT t1.`id_fac_mov_generados` as id_factura_generada,t1.`CuentaRIPS` as CuentaRIPS,t1.`CuentaGlobal` as CuentaGlobal,t1.`cod_prest_servicio`,t1.`razon_social`,t1.`num_factura`,t1.`fecha_factura`,
t1.`cod_enti_administradora`,t1.`nom_enti_administradora`,t1.`valor_neto_pagar`,t2.`id_pagados` as id_factura_pagada,t2.`fecha_pago_factura`,t2.`valor_pagado`,t2.`num_pago` ,
(SELECT t1.`valor_neto_pagar`-t2.`valor_pagado`) as DiferenciaEnPago ,t1.`tipo_negociacion`,
t1.`dias_pactados`,t1.`fecha_radicado`,t1.`numero_radicado`,t1.`Soporte` 
FROM salud_archivo_facturacion_mov_generados t1 INNER JOIN salud_archivo_facturacion_mov_pagados t2 ON t1.`num_factura`=t2.`num_factura`
WHERE t1.estado='DIFERENCIA';

DROP VIEW IF EXISTS `vista_circular_07`;
CREATE VIEW vista_circular_07 AS 
SELECT t1.`id_fac_mov_generados` as id_factura_generada, 
(SELECT DATEDIFF(now(),t1.`fecha_radicado` ) - t1.`dias_pactados`) as DiasMora ,t1.`CuentaRIPS` as CuentaRIPS,t1.`CuentaGlobal` as CuentaGlobal,t1.`cod_prest_servicio`,t1.`razon_social`,t1.`num_factura`,
t1.`fecha_factura`, t1.`fecha_radicado`,t1.`numero_radicado`,
(SELECT DATE_ADD(t1.`fecha_radicado`, INTERVAL (SELECT t1.`dias_pactados`) DAY)) AS FechaVencimiento,
t1.`cod_enti_administradora`,t1.`nom_enti_administradora`,
(SELECT tipo_regimen FROM salud_eps WHERE salud_eps.cod_pagador_min=t1.`cod_enti_administradora`) as RegimenEPS,
(SELECT Genera07 FROM salud_eps WHERE salud_eps.cod_pagador_min=t1.`cod_enti_administradora`) as Genera07,
t1.`valor_neto_pagar` ,t1.`tipo_negociacion`, 
t1.`dias_pactados`,t1.`Soporte`,t1.`EstadoCobro`,
(SELECT IFNULL((SELECT SUM(ValorGlosado) FROM salud_glosas_iniciales WHERE salud_glosas_iniciales.num_factura=t1.num_factura AND salud_glosas_iniciales.EstadoGlosa<=7),0)) as ValorGlosaInicial,
(SELECT IFNULL((SELECT SUM(ValorLevantado) FROM salud_glosas_iniciales WHERE salud_glosas_iniciales.num_factura=t1.num_factura AND salud_glosas_iniciales.EstadoGlosa<=7),0)) as ValorGlosaLevantada,
(SELECT IFNULL((SELECT SUM(ValorAceptado) FROM salud_glosas_iniciales WHERE salud_glosas_iniciales.num_factura=t1.num_factura AND salud_glosas_iniciales.EstadoGlosa<=7),0)) as ValorGlosaAceptada,
(SELECT IFNULL((SELECT SUM(ValorXConciliar) FROM salud_glosas_iniciales WHERE salud_glosas_iniciales.num_factura=t1.num_factura AND salud_glosas_iniciales.EstadoGlosa<=7),0)) as ValorGlosaXConciliar,
(SELECT IFNULL((SELECT SUM(valor_pagado) FROM salud_archivo_facturacion_mov_pagados WHERE salud_archivo_facturacion_mov_pagados.num_factura=t1.num_factura),0)) as TotalPagos,
(SELECT t1.`valor_neto_pagar` - (SELECT ValorGlosaAceptada) - (SELECT TotalPagos)) AS SaldoFinalFactura
FROM salud_archivo_facturacion_mov_generados t1 WHERE t1.estado<>'' AND t1.estado<>'PAGADA'; 



DROP VIEW IF EXISTS `vista_salud_respuestas`;
CREATE VIEW vista_salud_respuestas AS 
SELECT salud_archivo_control_glosas_respuestas.ID as ID,
       salud_archivo_control_glosas_respuestas.CuentaRIPS as cuenta,
       salud_archivo_control_glosas_respuestas.num_factura as factura,
       salud_archivo_control_glosas_respuestas.Tratado as Tratado,
       salud_archivo_control_glosas_respuestas.Soporte as Soporte,
       salud_archivo_control_glosas_respuestas.valor_glosado_eps,
       salud_archivo_control_glosas_respuestas.valor_levantado_eps,
       salud_archivo_control_glosas_respuestas.valor_aceptado_ips,
       salud_archivo_control_glosas_respuestas.EstadoGlosa as cod_estado,
       (salud_archivo_control_glosas_respuestas.valor_glosado_eps-salud_archivo_control_glosas_respuestas.valor_levantado_eps-salud_archivo_control_glosas_respuestas.valor_aceptado_ips) AS valor_x_conciliar,
       salud_archivo_control_glosas_respuestas.observacion_auditor,
       salud_archivo_control_glosas_respuestas.fecha_registo as fecha_respuesta,
       salud_archivo_control_glosas_respuestas.id_cod_glosa as cod_glosa_respuesta,
       salud_archivo_control_glosas_respuestas.CodigoActividad as cod_actividad,
       salud_archivo_control_glosas_respuestas.DescripcionActividad as descripcion_actividad,
       salud_archivo_control_glosas_respuestas.valor_actividad as valor_total_actividad,
       salud_archivo_control_glosas_respuestas.idGlosa as id_glosa_inicial,
       salud_archivo_control_glosas_respuestas.EstadoGlosaHistorico as EstadoGlosaHistorico,

       (SELECT fecha_factura FROM salud_archivo_facturacion_mov_generados WHERE salud_archivo_facturacion_mov_generados.num_factura=salud_archivo_control_glosas_respuestas.num_factura LIMIT 1) as fecha_factura, 
       (SELECT numero_radicado FROM salud_archivo_facturacion_mov_generados WHERE salud_archivo_facturacion_mov_generados.num_factura=salud_archivo_control_glosas_respuestas.num_factura LIMIT 1) as numero_radicado, 
       (SELECT fecha_radicado FROM salud_archivo_facturacion_mov_generados WHERE salud_archivo_facturacion_mov_generados.num_factura=salud_archivo_control_glosas_respuestas.num_factura LIMIT 1) as fecha_radicado, 
       (SELECT valor_neto_pagar FROM salud_archivo_facturacion_mov_generados WHERE salud_archivo_facturacion_mov_generados.num_factura=salud_archivo_control_glosas_respuestas.num_factura LIMIT 1) as valor_factura, 
       (SELECT cod_enti_administradora FROM salud_archivo_facturacion_mov_generados WHERE salud_archivo_facturacion_mov_generados.num_factura=salud_archivo_control_glosas_respuestas.num_factura LIMIT 1) as cod_administrador, 
       (SELECT nom_enti_administradora FROM salud_archivo_facturacion_mov_generados WHERE salud_archivo_facturacion_mov_generados.num_factura=salud_archivo_control_glosas_respuestas.num_factura LIMIT 1) as nombre_administrador, 
       (SELECT cod_prest_servicio FROM salud_archivo_facturacion_mov_generados WHERE salud_archivo_facturacion_mov_generados.num_factura=salud_archivo_control_glosas_respuestas.num_factura LIMIT 1) as cod_prestador, 
       (SELECT razon_social FROM salud_archivo_facturacion_mov_generados WHERE salud_archivo_facturacion_mov_generados.num_factura=salud_archivo_control_glosas_respuestas.num_factura LIMIT 1) as nombre_prestador, 
       (SELECT num_ident_prest_servicio FROM salud_archivo_facturacion_mov_generados WHERE salud_archivo_facturacion_mov_generados.num_factura=salud_archivo_control_glosas_respuestas.num_factura LIMIT 1) as nit_prestador, 
       
       (SELECT nit FROM salud_eps WHERE salud_eps.cod_pagador_min=(SELECT cod_administrador) LIMIT 1) as nit_administrador,
       (SELECT tipo_regimen FROM salud_eps WHERE salud_eps.cod_pagador_min=(SELECT cod_administrador) LIMIT 1) as regimen_eps,
       
       (SELECT num_ident_usuario FROM vista_salud_facturas_usuarios WHERE vista_salud_facturas_usuarios.num_factura=(SELECT factura) LIMIT 1) as identificacion,
       
       (SELECT tipo_ident_usuario FROM salud_archivo_usuarios WHERE salud_archivo_usuarios.num_ident_usuario=(SELECT identificacion) LIMIT 1) as tipo_identificacion,
       (SELECT edad FROM salud_archivo_usuarios WHERE salud_archivo_usuarios.num_ident_usuario=(SELECT identificacion) LIMIT 1) as edad_usuario,
       (SELECT unidad_medida_edad FROM salud_archivo_usuarios WHERE salud_archivo_usuarios.num_ident_usuario=(SELECT identificacion) LIMIT 1) as unidad_medida_edad,
       (SELECT sexo FROM salud_archivo_usuarios WHERE salud_archivo_usuarios.num_ident_usuario=(SELECT identificacion) LIMIT 1) as sexo_usuario,
       
       (SELECT CodigoGlosa FROM salud_glosas_iniciales WHERE salud_archivo_control_glosas_respuestas.idGlosa=salud_glosas_iniciales.ID LIMIT 1) AS cod_glosa_inicial,
       
       (SELECT descrpcion_concep_especifico FROM salud_archivo_conceptos_glosas WHERE (SELECT cod_glosa_inicial)= salud_archivo_conceptos_glosas.cod_glosa LIMIT 1) as descripcion_glosa_inicial,
       
       (SELECT descrpcion_concep_especifico FROM salud_archivo_conceptos_glosas WHERE salud_archivo_conceptos_glosas.cod_glosa= salud_archivo_control_glosas_respuestas.id_cod_glosa LIMIT 1) as descripcion_glosa_respuesta,
       
        (SELECT Estado_glosa FROM salud_estado_glosas WHERE salud_archivo_control_glosas_respuestas.EstadoGlosa=salud_estado_glosas.ID LIMIT 1) as descripcion_estado,
       (SELECT Estado_glosa FROM salud_estado_glosas WHERE salud_archivo_control_glosas_respuestas.EstadoGlosaHistorico=salud_estado_glosas.ID LIMIT 1) as descripcion_estado_historico
       
       
FROM salud_archivo_control_glosas_respuestas;



DROP VIEW IF EXISTS `vista_salud_facturas_usuarios`;
CREATE VIEW vista_salud_facturas_usuarios AS 
SELECT num_factura, num_ident_usuario FROM salud_archivo_consultas 
UNION ALL
SELECT num_factura, num_ident_usuario FROM salud_archivo_procedimientos
UNION ALL
SELECT num_factura, num_ident_usuario FROM salud_archivo_otros_servicios
UNION ALL
SELECT num_factura, num_ident_usuario FROM salud_archivo_medicamentos;


DROP VIEW IF EXISTS `vista_af_semaforo`;
CREATE VIEW vista_af_semaforo AS
SELECT *,
(SELECT MAX(DiasTranscurridos) FROM vista_glosas_iniciales
WHERE vista_glosas_iniciales.num_factura=salud_archivo_facturacion_mov_generados.num_factura 
AND vista_glosas_iniciales.EstadoGlosa=1) AS Dias,
(SELECT IFNULL((SELECT num_ident_usuario FROM salud_archivo_consultas 
WHERE salud_archivo_consultas.num_factura=salud_archivo_facturacion_mov_generados.num_factura LIMIT 1),
(SELECT IFNULL((SELECT num_ident_usuario FROM salud_archivo_procedimientos 
WHERE salud_archivo_procedimientos.num_factura=salud_archivo_facturacion_mov_generados.num_factura LIMIT 1),

(SELECT IFNULL((SELECT num_ident_usuario FROM salud_archivo_otros_servicios 
WHERE salud_archivo_otros_servicios.num_factura=salud_archivo_facturacion_mov_generados.num_factura LIMIT 1),

(SELECT num_ident_usuario FROM salud_archivo_medicamentos 
WHERE salud_archivo_medicamentos.num_factura=salud_archivo_facturacion_mov_generados.num_factura LIMIT 1)))))))
 AS identificacion_usuario  

FROM `salud_archivo_facturacion_mov_generados`;



DROP VIEW IF EXISTS `vista_circular030_1_radicados`;
CREATE VIEW vista_circular030_1_radicados AS 

SELECT '2' as TipoRegistro,
            tipo_ident_prest_servicio as TipoIdentificacionERP, 
            (SELECT nit FROM salud_eps WHERE salud_eps.cod_pagador_min=t1.cod_enti_administradora) as NumeroIdentificacionERP, 
            nom_enti_administradora as RazonSocialIPS, 
            'NI' as TipoIdentificacionIPS, 
            (SELECT NIT FROM empresapro WHERE idEmpresaPro=1) as NumeroIdentificacionIPS, 
            'F' as TipoCobro,num_factura,'I' as IndicadorActualizacion,valor_neto_pagar as Valor,
            fecha_factura as FechaEmision,fecha_radicado as FechaPresentacion,'' as FechaDevolucion,
            '0' as ValorPagado,'0' as ValorGlosaAceptada,'NO' as GlosaRespondida, 
            (SELECT Valor-ValorPagado-ValorGlosaAceptada) as SaldoFactura, 'NO' as CobroJuridico, '0' as EtapaCobroJuridico
            FROM vista_af t1 
            WHERE  t1.GeneraCircular='S' AND t1.estado='RADICADO';
                

DROP VIEW IF EXISTS `vista_circular030_2_juridicos`;
CREATE VIEW vista_circular030_2_juridicos AS 

SELECT '2' as TipoRegistro,
            tipo_ident_prest_servicio as TipoIdentificacionERP, 
            (SELECT nit FROM salud_eps WHERE salud_eps.cod_pagador_min=t1.cod_enti_administradora) as NumeroIdentificacionERP, 
            nom_enti_administradora as RazonSocialIPS, 
            'NI' as TipoIdentificacionIPS, 
            (SELECT NIT FROM empresapro WHERE idEmpresaPro=1) as NumeroIdentificacionIPS, 
            'F' as TipoCobro,num_factura,'I' as IndicadorActualizacion,valor_neto_pagar as Valor,
            fecha_factura as FechaEmision,fecha_radicado as FechaPresentacion,'' as FechaDevolucion,
            '0' as ValorPagado,'0' as ValorGlosaAceptada,'NO' as GlosaRespondida, 
            (SELECT Valor-ValorPagado-ValorGlosaAceptada) as SaldoFactura, 'NO' as CobroJuridico, '0' as EtapaCobroJuridico
            FROM vista_af t1 
            WHERE  t1.GeneraCircular='S' AND t1.estado='JURIDICO';





