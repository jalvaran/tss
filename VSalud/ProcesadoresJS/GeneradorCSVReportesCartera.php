<?php 
if(isset($_REQUEST["Opcion"])){
    $myPage="GeneradorCSVReportesCartera.php";
    include_once("../../modelo/php_conexion.php");
    
    session_start();    
    $idUser=$_SESSION['idUser'];
    $obCon = new conexion($idUser);
    $DatosRuta=$obCon->DevuelveValores("configuracion_general", "ID", 1);
    $OuputFile=$DatosRuta["Valor"];
    $Link1=substr($OuputFile, -17);
    $Link="../../".$Link1;
    //print($Link);
    $a='"';
    $Enclosed=" ENCLOSED BY '$a' ";
    $Opcion=$_REQUEST["Opcion"];
    
    switch ($Opcion){
        case 1: //Exportar Facturas Pagadas
            if(file_exists($Link)){
                unlink($Link);
            }
            
            
            $statement=$obCon->normalizar(urldecode($_REQUEST["st"]));
            $Separador=$obCon->normalizar($_REQUEST["sp"]);
            if($Separador==1){
                $Separador=';';
            }else{
                $Separador=',';
            }
            $sqlColumnas="SELECT 'CuentaRIPS','CuentaGlobal','IPS','FACTURA','FECHA DE FACTURA','FECHA DE PAGO DE LA FACTURA',"
                    . "'CODIGO EPS','EPS','VALOR PAGADO','NEGOCIACION'";
            $CamposShow=" CuentaRIPS,CuentaGlobal,razon_social,num_factura,fecha_factura,fecha_pago_factura,"
                    . "cod_enti_administradora,nom_enti_administradora,ROUND(valor_pagado) AS valor_pagado,tipo_negociacion ";
            $sqlColumnas.=" UNION ALL ";
            
            //print($Indice);
            $sql=$sqlColumnas."SELECT $CamposShow FROM $statement INTO OUTFILE '$OuputFile' FIELDS TERMINATED BY '$Separador' $Enclosed LINES TERMINATED BY '\r\n';";
            $obCon->Query($sql);
            print("<a href='$Link' target='_top'><img src='../../images/download.gif'>Download</img></a>");
            break;
        case 2: //Exportar Facturas Pagadas
            if(file_exists($Link)){
                unlink($Link);
            }
            
            
            $statement=$obCon->normalizar(urldecode($_REQUEST["st"]));
            $Separador=$obCon->normalizar($_REQUEST["sp"]);
            if($Separador==1){
                $Separador=';';
            }else{
                $Separador=',';
            }
            $sqlColumnas="SELECT 'Cuenta RIPS','Cuenta Global','IPS','FACTURA','FECHA DE FACTURA','FECHA RADICADO',"
                    . "'DIAS EN MORA','CODIGO EPS','EPS','VALOR X PAGAR','NEGOCIACION'";
            $query=" CuentaRIPS,CuentaGlobal,razon_social,num_factura,fecha_factura,fecha_radicado,DiasMora,"
                    . "cod_enti_administradora,nom_enti_administradora,ROUND(valor_neto_pagar) AS valor_neto_pagar,tipo_negociacion ";
            $sqlColumnas.=" UNION ALL ";
            
            //print($Indice);
            $sql=$sqlColumnas."SELECT $query FROM $statement INTO OUTFILE '$OuputFile' FIELDS TERMINATED BY '$Separador' $Enclosed LINES TERMINATED BY '\r\n';";
            $obCon->Query($sql);
            print("<a href='$Link' target='_top'><img src='../../images/download.gif'>Download</img></a>");
            break;
        case 3: //Exportar Facturas Pagadas con diferencias
            if(file_exists($Link)){
                unlink($Link);
            }
            
            
            $statement=$obCon->normalizar(urldecode($_REQUEST["st"]));
            $Separador=$obCon->normalizar($_REQUEST["sp"]);
            if($Separador==1){
                $Separador=';';
            }else{
                $Separador=',';
            }
            $sqlColumnas="SELECT 'Cuenta RIPS','Cuenta Global','IPS','FACTURA','FECHA DE FACTURA','FECHA DE PAGO DE LA FACTURA',"
                    . "'CODIGO EPS','EPS','VALOR NETO A PAGAR','VALOR PAGADO','DIFERENCIA'";
            $CamposShow=" CuentaRIPS,CuentaGlobal,razon_social,num_factura,fecha_factura,fecha_pago_factura,"
                    . "cod_enti_administradora,nom_enti_administradora,ROUND(valor_neto_pagar) AS valor_neto_pagar,ROUND(valor_pagado) as valor_pagado,ROUND(DiferenciaEnPago) as DiferenciaEnPago ";
            $sqlColumnas.=" UNION ALL ";
            
            //print($Indice);
            $sql=$sqlColumnas."SELECT $CamposShow FROM $statement INTO OUTFILE '$OuputFile' FIELDS TERMINATED BY '$Separador' $Enclosed LINES TERMINATED BY '\r\n';";
            $obCon->Query($sql);
            print("<a href='$Link' target='_top'><img src='../../images/download.gif'>Download</img></a>");
            break;
        case 4: //Exportar Facturas Pagadas que no han sido generadas
            if(file_exists($Link)){
                unlink($Link);
            }
            
            
            $statement=$obCon->normalizar(urldecode($_REQUEST["st"]));
            $Separador=$obCon->normalizar($_REQUEST["sp"]);
            if($Separador==1){
                $Separador=';';
            }else{
                $Separador=',';
            }
            $sqlColumnas="SELECT 'FACTURA','FECHA DE PAGO','VALOR PAGADO',"
                    . "'CODIGO EPS','EPS'";
            $CamposShow=" num_factura,fecha_pago_factura,ROUND(valor_pagado) as valor_pagado,"
                    . "idEPS,nom_enti_administradora ";
            $sqlColumnas.=" UNION ALL ";
            
            //print($Indice);
            $sql=$sqlColumnas."SELECT $CamposShow FROM $statement INTO OUTFILE '$OuputFile' FIELDS TERMINATED BY '$Separador' $Enclosed LINES TERMINATED BY '\r\n';";
            $obCon->Query($sql);
            print("<a href='$Link' target='_top'><img src='../../images/download.gif'>Download</img></a>");
            break;
            
        case 5: //Exportar Cartera X Edades
            if(file_exists($Link)){
                unlink($Link);
            }
            
            
            
            $Separador=$obCon->normalizar($_REQUEST["sp"]);
            if($Separador==1){
                $Separador=';';
            }else{
                $Separador=',';
            }
            $sqlColumnas="SELECT 'REGIMEN','CODIGO EPS','NIT EPS','EPS','FACTURAS DE 1 A 30 DIAS', 'VALOR DE 1 A 30 DIAS','FACTURAS DE 31 A 60 DIAS','VALOR DE 31 A 60 DIAS',"
                    . "'FACTURAS DE 61 A 90 DIAS','VALOR DE 61 A 90 DIAS','FACTURAS DE 91 A 120 DIAS','VALOR DE 91 A 120 DIAS',"
                    . "'FACTURAS DE 121 A 180 DIAS','VALOR DE 121 A 180 DIAS','FACTURAS DE 181 A 360 DIAS','VALOR DE 181 A 360 DIAS','FACTURAS MAYOR A 360','VALOR MAYOR A 360',"
                    . "'CANTIDAD DE FACTURAS','TOTAL'";
            $CamposShow=" RegimenEPS,idEPS,NIT_EPS,RazonSocialEPS,Cantidad_1_30,Valor_1_30,Cantidad_31_60,Valor_31_60,Cantidad_61_90,Valor_61_90,"
                    . "Cantidad_91_120,Valor_91_120,Cantidad_121_180,Valor_121_180,Cantidad_181_360,Valor_181_360,Cantidad_360,"
                    . "Valor_360,TotalFacturas,Total";
            $sqlColumnas.=" UNION ALL ";
            
            //print($Indice);
            $sql=$sqlColumnas."SELECT $CamposShow FROM salud_cartera_x_edades_temp INTO OUTFILE '$OuputFile' FIELDS TERMINATED BY '$Separador' $Enclosed LINES TERMINATED BY '\r\n';";
            $obCon->Query($sql);
            print("<a href='$Link' target='_top'><img src='../../images/download.gif'>Download</img></a>");
            break;
            
            case 6: //Exportar Facturas Pagadas
            if(file_exists($Link)){
                unlink($Link);
            }
            
            
            $statement=$obCon->normalizar(urldecode($_REQUEST["st"]));
            $Separador=$obCon->normalizar($_REQUEST["sp"]);
            if($Separador==1){
                $Separador=';';
            }else{
                $Separador=',';
            }
            $sqlColumnas="SELECT 'Cuenta RIPS','Cuenta Global','IPS','FACTURA','FECHA DE FACTURA','FECHA RADICADO','FECHA DE VENCIMIENTO',"
                    . "'DIAS EN MORA','CODIGO EPS','EPS','REGIMEN','VALOR TOTAL','GLOSA INICIAL','GLOSA LEVANTADA','GLOSA ACEPTADA',"
                    . "'TOTAL PAGOS','SALDO','NEGOCIACION'";
            $query=" CuentaRIPS,CuentaGlobal,razon_social,num_factura,fecha_factura,fecha_radicado,FechaVencimiento,DiasMora,"
                    . "cod_enti_administradora,nom_enti_administradora,RegimenEPS,ROUND(valor_neto_pagar) AS valor_neto_pagar,ValorGlosaInicial"
                    . ",ValorGlosaLevantada,ValorGlosaAceptada,TotalPagos,SaldoFinalFactura,tipo_negociacion ";
            $sqlColumnas.=" UNION ALL ";
            
            //print($Indice);
            $sql=$sqlColumnas."SELECT $query FROM $statement INTO OUTFILE '$OuputFile' FIELDS TERMINATED BY '$Separador' $Enclosed LINES TERMINATED BY '\r\n';";
            $obCon->Query($sql);
            print("<a href='$Link' target='_top'><img src='../../images/download.gif'>Download</img></a>");
            break;
        }
}else{
    print("No se recibió parametro de opcion");
}

?>