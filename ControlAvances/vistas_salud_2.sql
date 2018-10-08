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


