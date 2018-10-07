<?php

session_start();
if (!isset($_SESSION['username'])){
  exit("<a href='../index.php' ><img src='../images/401.png'>Iniciar Sesion </a>");
  
}
$idUser=$_SESSION['idUser'];

include_once("../../modelo/php_conexion.php");
include_once("../css_construct.php");

if( !empty($_REQUEST["TipoReporte"]) ){
    $css =  new CssIni("id",0);
    $obGlosas = new conexion($idUser);
    $TipoReporte=$obGlosas->normalizar($_REQUEST["TipoReporte"]);
    switch ($_REQUEST["TipoReporte"]) {
        case 1: //Pagos totales
            
            $TipoReporte=$obGlosas->normalizar($_REQUEST["TipoReporte"]);
            $idEPS="";
            if(isset($_REQUEST["idEPS"])){
                $idEPS=$obGlosas->normalizar($_REQUEST["idEPS"]);
            }
            $CuentaGlobal='';
            if(isset($_REQUEST["CuentaGlobal"])){
                $CuentaGlobal=$obGlosas->normalizar($_REQUEST["CuentaGlobal"]);
            }
            $FechaInicial="";
            if(isset($_REQUEST["FechaInicial"])){
                $FechaInicial=$obGlosas->normalizar($_REQUEST["FechaInicial"]);
            }
            $FechaFinal="";
            if(isset($_REQUEST["FechaFinal"])){
                $FechaFinal=$obGlosas->normalizar($_REQUEST["FechaFinal"]);
            }
            $Separador="";
            if(isset($_REQUEST["Separador"])){
                $Separador=$obGlosas->normalizar($_REQUEST["Separador"]);
            }
            if(isset($_REQUEST["sp"])){
                $Separador=$obGlosas->normalizar($_REQUEST["sp"]);
            }
            $CuentaRIPS="000000";
            if(isset($_REQUEST["CuentaRIPS"])){
                $CuentaRIPS=str_pad($obGlosas->normalizar($_REQUEST["CuentaRIPS"]),6,'0',STR_PAD_LEFT);
            }
            
            //Paginacion
            if(isset($_REQUEST['Page'])){
                $NumPage=$obGlosas->normalizar($_REQUEST['Page']);
            }else{
                $NumPage=1;
            }
            $Condicional=" WHERE (`cod_prest_servicio`<> '') ";
            $Condicional2="";
            if($idEPS<>''){
                $Condicional2=" AND cod_enti_administradora='$idEPS'";
            }
            if($FechaInicial<>''){
                $Condicional2.=$Condicional2." AND fecha_pago_factura >= '$FechaInicial' ";
            }
            if($FechaFinal<>''){
                $Condicional2.=$Condicional2." AND fecha_pago_factura <= '$FechaFinal' ";
            }
            if($CuentaRIPS<>'000000'){
                $Condicional2.=$Condicional2." AND CuentaRIPS = '$CuentaRIPS' ";
            }
            if($CuentaGlobal<>''){
                $Condicional2.=$Condicional2." AND CuentaGlobal = '$CuentaGlobal' ";
            }
            
            $statement=" `vista_salud_facturas_pagas` $Condicional $Condicional2";
            
            if(isset($_REQUEST['st'])){

                $statement= urldecode($_REQUEST['st']);
                //print($statement);
            }
            $limit = 10;
            $startpoint = ($NumPage * $limit) - $limit;
            $VectorST = explode("LIMIT", $statement);
            $statement = $VectorST[0]; 
            $query = "SELECT COUNT(*) as `num`,SUM(valor_pagado) AS TotalPagado FROM {$statement}";
            $row = $obGlosas->FetchArray($obGlosas->Query($query));
            $ResultadosTotales = $row['num'];
            $TotalPagado=$row['TotalPagado'];
            $st_reporte=$statement;
            $Limit=" ORDER BY fecha_pago_factura,fecha_factura LIMIT $startpoint,$limit";
            
            $query="SELECT CuentaRIPS,CuentaGlobal,razon_social,num_factura,fecha_factura,fecha_pago_factura,"
                    . "cod_enti_administradora,nom_enti_administradora,ROUND(valor_pagado) AS valor_pagado ";
            $consulta=$obGlosas->Query("$query FROM $statement $Limit");
            //print("$query FROM $statement");
            if($obGlosas->NumRows($consulta)){
                
                $Resultados=$obGlosas->NumRows($consulta);
        
                $css->CrearTabla();
                $css->FilaTabla(14);
                    print("<td style='text-align:center'>");
                        print("<strong>Registros:</strong> <h4 style=color:green>". number_format($ResultadosTotales)."</h4>");
                    print("</td>");
                    print("<td style='text-align:center'>");
                        print("<strong>Total Pagos:</strong> <h4 style=color:green>". number_format($TotalPagado)."</h4>");
                    print("</td>");
                    print("<td colspan='4'>");
                        $css->CrearNotificacionVerde("Facturas Pagadas", 16);
                    print("</td>");
                    print("<td colspan='2' style='text-align:center'>");
                        $st1= urlencode($st_reporte);
                        $css->CrearImageLink("ProcesadoresJS/GeneradorCSVReportesCartera.php?Opcion=1&sp=$Separador&st=$st1", "../images/csv.png", "_blank", 50, 50);

                    print("</td>");
                $css->CierraFilaTabla();
                //Paginacion
                if($Resultados){

                    $st= urlencode($st_reporte);
                    if($ResultadosTotales>$limit){

                        $css->FilaTabla(14);
                            print("<td colspan='2' style=text-align:center>");
                            if($NumPage>1){
                                $NumPage1=$NumPage-1;
                                $Page="Consultas/SaludReportesCartera.draw.php?st=$st&sp=$Separador&Page=$NumPage1&TipoReporte=$TipoReporte&Carry=";
                                $FuncionJS="EnvieObjetoConsulta(`$Page`,`idEPS`,`DivConsultas`,`5`);return false ;";

                                $css->CrearBotonEvento("BtnMas", "Página $NumPage1", 1, "onclick", $FuncionJS, "rojo", "");

                            }
                            print("</td>");
                            $TotalPaginas= ceil($ResultadosTotales/$limit);
                            print("<td colspan=4 style=text-align:center>");
                            print("<strong>Página: </strong>");

                            $Page="Consultas/SaludReportesCartera.draw.php?st=$st&sp=$Separador&TipoReporte=$TipoReporte&Page=";
                            $FuncionJS="EnvieObjetoConsulta(`$Page`,`CmbPage`,`DivConsultas`,`5`);return false ;";
                            $css->CrearSelect("CmbPage", $FuncionJS,70);
                                for($p=1;$p<=$TotalPaginas;$p++){
                                    if($p==$NumPage){
                                        $sel=1;
                                    }else{
                                        $sel=0;
                                    }
                                    $css->CrearOptionSelect($p, "$p", $sel);
                                }

                            $css->CerrarSelect();
                            print("</td>");
                            
                            print("<td colspan='3' style=text-align:center>");
                            if($ResultadosTotales>($startpoint+$limit)){
                                $NumPage1=$NumPage+1;
                                $Page="Consultas/SaludReportesCartera.draw.php?st=$st&sp=$Separador&Page=$NumPage1&TipoReporte=$TipoReporte&Carry=";
                                $FuncionJS="EnvieObjetoConsulta(`$Page`,`idEPS`,`DivConsultas`,`5`);return false ;";
                                $css->CrearBotonEvento("BtnMas", "Página $NumPage1", 1, "onclick", $FuncionJS, "verde", "");
                            }
                            print("</td>");
                           $css->CierraFilaTabla(); 
                        }
                    }   
                    
                    $css->FilaTabla(14);
                        $css->ColTabla("<strong>CUENTA RIPS</strong>", 1);
                        $css->ColTabla("<strong>CUENTA GLOBAL</strong>", 1);
                        $css->ColTabla("<strong>CÓDIGO EPS</strong>", 1);
                        $css->ColTabla("<strong>EPS</strong>", 1);
                        $css->ColTabla("<strong>FACTURA</strong>", 1);
                        $css->ColTabla("<strong>FECHA FACTURA</strong>", 1);
                        $css->ColTabla("<strong>FECHA PAGO</strong>", 1);
                        $css->ColTabla("<strong>VALOR PAGADO</strong>", 1);
                                                
                    $css->CierraFilaTabla();
                    
                    while($DatosConsulta=$obGlosas->FetchAssoc($consulta)){
                        $css->FilaTabla(12);
                            $css->ColTabla($DatosConsulta["CuentaRIPS"], 1);
                            $css->ColTabla($DatosConsulta["CuentaGlobal"], 1);
                            $css->ColTabla($DatosConsulta["cod_enti_administradora"], 1);
                            $css->ColTabla(utf8_encode($DatosConsulta["nom_enti_administradora"]), 1);
                            $css->ColTabla($DatosConsulta["num_factura"], 1);
                            $css->ColTabla($DatosConsulta["fecha_factura"], 1);
                            $css->ColTabla($DatosConsulta["fecha_pago_factura"], 1);
                            $css->ColTabla($DatosConsulta["valor_pagado"], 1);
                                                    
                        $css->CierraFilaTabla();
                    }
                    
                    $css->CerrarTabla();
                    
                }else{
                    $css->CrearNotificacionAzul("No hay resultados", 14);
                }
        break;
    
        case 2: // Facturas no pagas
            
            
            $idEPS="";
            if(isset($_REQUEST["idEPS"])){
                $idEPS=$obGlosas->normalizar($_REQUEST["idEPS"]);
            }
            $CuentaGlobal='';
            if(isset($_REQUEST["CuentaGlobal"])){
                $CuentaGlobal=$obGlosas->normalizar($_REQUEST["CuentaGlobal"]);
            }
            $FechaInicial="";
            if(isset($_REQUEST["FechaInicial"])){
                $FechaInicial=$obGlosas->normalizar($_REQUEST["FechaInicial"]);
            }
            $FechaFinal="";
            if(isset($_REQUEST["FechaFinal"])){
                $FechaFinal=$obGlosas->normalizar($_REQUEST["FechaFinal"]);
            }
            $Separador="";
            if(isset($_REQUEST["Separador"])){
                $Separador=$obGlosas->normalizar($_REQUEST["Separador"]);
            }
            if(isset($_REQUEST["sp"])){
                $Separador=$obGlosas->normalizar($_REQUEST["sp"]);
            }
            
            $CuentaRIPS="000000";
            if(isset($_REQUEST["CuentaRIPS"])){
                $CuentaRIPS=str_pad($obGlosas->normalizar($_REQUEST["CuentaRIPS"]),6,'0',STR_PAD_LEFT);
            }
            
            //Paginacion
            if(isset($_REQUEST['Page'])){
                $NumPage=$obGlosas->normalizar($_REQUEST['Page']);
            }else{
                $NumPage=1;
            }
            $Condicional=" WHERE (`cod_prest_servicio`<> '') ";
            $Condicional2="";
            if($idEPS<>''){
                $Condicional2=" AND cod_enti_administradora='$idEPS'";
            }
            if($FechaInicial<>''){
                $Condicional2.=$Condicional2." AND fecha_radicado >= '$FechaInicial' ";
            }
            if($FechaFinal<>''){
                $Condicional2.=$Condicional2." AND fecha_radicado <= '$FechaFinal' ";
            }
            if($CuentaRIPS<>'000000'){
                $Condicional2.=$Condicional2." AND CuentaRIPS = '$CuentaRIPS' ";
            }
            if($CuentaGlobal<>''){
                $Condicional2.=$Condicional2." AND CuentaGlobal = '$CuentaGlobal' ";
            }
            
            $statement=" `vista_salud_facturas_no_pagas` $Condicional $Condicional2";
            
            if(isset($_REQUEST['st'])){

                $statement= urldecode($_REQUEST['st']);
                //print($statement);
            }
            $limit = 10;
            $startpoint = ($NumPage * $limit) - $limit;
            $VectorST = explode("LIMIT", $statement);
            $statement = $VectorST[0]; 
            $query = "SELECT COUNT(*) as `num`,SUM(valor_neto_pagar) AS TotalXPagar FROM {$statement}";
            $row = $obGlosas->FetchArray($obGlosas->Query($query));
            $ResultadosTotales = $row['num'];
            $TotalXPagar=$row['TotalXPagar'];
            $st_reporte=$statement;
            $Limit=" ORDER BY fecha_factura LIMIT $startpoint,$limit";
            
            $query="SELECT CuentaRIPS,CuentaGlobal,razon_social,num_factura,fecha_factura,fecha_radicado,DiasMora,"
                    . "cod_enti_administradora,nom_enti_administradora,ROUND(valor_neto_pagar) AS valor_neto_pagar ";
            $consulta=$obGlosas->Query("$query FROM $statement $Limit");
            //print("$query FROM $statement");
            if($obGlosas->NumRows($consulta)){
                
                $Resultados=$obGlosas->NumRows($consulta);
        
                $css->CrearTabla();
                $css->FilaTabla(14);
                    print("<td style='text-align:center'>");
                        print("<strong>Registros:</strong> <h4 style=color:red>". number_format($ResultadosTotales)."</h4>");
                    print("</td>");
                    print("<td style='text-align:center'>");
                        print("<strong>Facturas Sin pagar:</strong> <h4 style=color:red>". number_format($TotalXPagar)."</h4>");
                    print("</td>");
                    print("<td colspan='5'>");
                        $css->CrearNotificacionRoja("Facturas No Pagadas", 16);
                    print("</td>");
                    print("<td colspan='2' style='text-align:center'>");
                        $st1= urlencode($st_reporte);
                        $css->CrearImageLink("ProcesadoresJS/GeneradorCSVReportesCartera.php?Opcion=$TipoReporte&sp=$Separador&st=$st1", "../images/csv.png", "_blank", 50, 50);

                    print("</td>");
                $css->CierraFilaTabla();
                //Paginacion
                if($Resultados){

                    $st= urlencode($st_reporte);
                    if($ResultadosTotales>$limit){

                        $css->FilaTabla(14);
                            print("<td colspan='2' style=text-align:center>");
                            if($NumPage>1){
                                $NumPage1=$NumPage-1;
                                $Page="Consultas/SaludReportesCartera.draw.php?st=$st&sp=$Separador&Page=$NumPage1&TipoReporte=$TipoReporte&Carry=";
                                $FuncionJS="EnvieObjetoConsulta(`$Page`,`idEPS`,`DivConsultas`,`5`);return false ;";

                                $css->CrearBotonEvento("BtnMas", "Página $NumPage1", 1, "onclick", $FuncionJS, "rojo", "");

                            }
                            print("</td>");
                            $TotalPaginas= ceil($ResultadosTotales/$limit);
                            print("<td colspan=5 style=text-align:center>");
                            print("<strong>Página: </strong>");

                            $Page="Consultas/SaludReportesCartera.draw.php?st=$st&sp=$Separador&TipoReporte=$TipoReporte&Page=";
                            $FuncionJS="EnvieObjetoConsulta(`$Page`,`CmbPage`,`DivConsultas`,`5`);return false ;";
                            $css->CrearSelect("CmbPage", $FuncionJS,70);
                                for($p=1;$p<=$TotalPaginas;$p++){
                                    if($p==$NumPage){
                                        $sel=1;
                                    }else{
                                        $sel=0;
                                    }
                                    $css->CrearOptionSelect($p, "$p", $sel);
                                }

                            $css->CerrarSelect();
                            print("</td>");
                            
                            print("<td colspan='3' style=text-align:center>");
                            if($ResultadosTotales>($startpoint+$limit)){
                                $NumPage1=$NumPage+1;
                                $Page="Consultas/SaludReportesCartera.draw.php?st=$st&sp=$Separador&Page=$NumPage1&TipoReporte=$TipoReporte&Carry=";
                                $FuncionJS="EnvieObjetoConsulta(`$Page`,`idEPS`,`DivConsultas`,`5`);return false ;";
                                $css->CrearBotonEvento("BtnMas", "Página $NumPage1", 1, "onclick", $FuncionJS, "verde", "");
                            }
                            print("</td>");
                           $css->CierraFilaTabla(); 
                        }
                    }   
                    
                    $css->FilaTabla(14);
                        $css->ColTabla("<strong>CUENTA RIPS</strong>", 1);
                        $css->ColTabla("<strong>CUENTA GLOBAL</strong>", 1);
                        $css->ColTabla("<strong>CÓDIGO EPS</strong>", 1);
                        $css->ColTabla("<strong>EPS</strong>", 1);
                        $css->ColTabla("<strong>FACTURA</strong>", 1);
                        $css->ColTabla("<strong>FECHA FACTURA</strong>", 1);
                        $css->ColTabla("<strong>FECHA RADICADO</strong>", 1);
                        $css->ColTabla("<strong>DIAS EN MORA</strong>", 1);
                        $css->ColTabla("<strong>VALOR NETO A PAGAR</strong>", 1);
                                                
                    $css->CierraFilaTabla();
                    
                    while($DatosConsulta=$obGlosas->FetchAssoc($consulta)){
                        $css->FilaTabla(12);
                            $css->ColTabla($DatosConsulta["CuentaRIPS"], 1);
                            $css->ColTabla($DatosConsulta["CuentaGlobal"], 1);
                            $css->ColTabla($DatosConsulta["cod_enti_administradora"], 1);
                            $css->ColTabla(utf8_encode($DatosConsulta["nom_enti_administradora"]), 1);
                            $css->ColTabla($DatosConsulta["num_factura"], 1);
                            $css->ColTabla($DatosConsulta["fecha_factura"], 1);
                            $css->ColTabla($DatosConsulta["fecha_radicado"], 1);
                            $css->ColTabla($DatosConsulta["DiasMora"], 1);
                            $css->ColTabla($DatosConsulta["valor_neto_pagar"], 1);
                                                    
                        $css->CierraFilaTabla();
                    }
                    
                    $css->CerrarTabla();
                    
                }else{
                    $css->CrearNotificacionAzul("No hay resultados", 14);
                }
        break;
       
    }
          
}else{
    print("No se enviaron parametros");
}
?>