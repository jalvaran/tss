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
    
    switch ($_REQUEST["TipoReporte"]) {
        case 1: //Glosas pendientes por conciliar
            
            $TipoReporte=$obGlosas->normalizar($_REQUEST["TipoReporte"]);
            $idEPS="";
            if(isset($_REQUEST["idEPS"])){
                $idEPS=$obGlosas->normalizar($_REQUEST["idEPS"]);
            }
            $FechaInicial="";
            if(isset($_REQUEST["FechaInicial"])){
                $FechaInicial=$obGlosas->normalizar($_REQUEST["FechaInicial"]);
            }
            $FechaFinal="";
            if(isset($_REQUEST["FechaFinal"])){
                $FechaFinal=$obGlosas->normalizar($_REQUEST["FechaFinal"]);
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
            $Condicional=" WHERE `cod_estado`= 1 or `cod_estado`= 3 ";
            if($idEPS<>''){
                $Condicional=$Condicional." AND cod_administrador='$idEPS'";
            }
            if($FechaInicial<>''){
                $Condicional=$Condicional." AND fecha_factura >= '$FechaInicial' ";
            }
            if($FechaFinal<>''){
                $Condicional=$Condicional." AND fecha_factura <= '$FechaFinal' ";
            }
            if($CuentaRIPS<>'000000'){
                $Condicional=$Condicional." AND cuenta = '$CuentaRIPS' ";
            }
            $statement=" `vista_salud_respuestas` $Condicional ";
            
            if(isset($_REQUEST['st'])){

                $statement= base64_decode($_REQUEST['st']);
                //print($statement);
            }
            $limit = 10;
            $startpoint = ($NumPage * $limit) - $limit;
            $VectorST = explode("LIMIT", $statement);
            $statement = $VectorST[0]; 
            $query = "SELECT COUNT(*) as `num` FROM {$statement}";
            $row = $obGlosas->FetchArray($obGlosas->Query($query));
            $ResultadosTotales = $row['num'];
            $st_reporte=$statement;
            $statement.=" LIMIT $startpoint,$limit";
            
            $query="SELECT cuenta,factura,nombre_administrador,fecha_factura,cod_prestador, identificacion, descripcion_estado ";
            $consulta=$obGlosas->Query("$query FROM $statement");
            //print("$query FROM $statement");
            if($obGlosas->NumRows($consulta)){
                
                $Resultados=$obGlosas->NumRows($consulta);
        
                $css->CrearTabla();
                $css->FilaTabla(14);
                    print("<td colspan=7>");
                        $st1= base64_encode($st_reporte);
                        $css->CrearImageLink("PDF_Documentos.php?idDocumento=2&TipoReporte=$TipoReporte&st=$st1", "../images/pdf.png", "_blank", 30, 100);

                    print("</td>");
                $css->CierraFilaTabla();
                //Paginacion
                if($Resultados){

                    $st= base64_encode($statement);
                    if($ResultadosTotales>$limit){

                        $css->FilaTabla(14);
                            print("<td colspan='2' style=text-align:center>");
                            if($NumPage>1){
                                $NumPage1=$NumPage-1;
                                $Page="Consultas/SaludReportesGlosas.draw.php?st=$st&Page=$NumPage1&TipoReporte=$TipoReporte&Carry=";
                                $FuncionJS="EnvieObjetoConsulta(`$Page`,`idEPS`,`DivConsultas`,`5`);return false ;";

                                $css->CrearBotonEvento("BtnMas", "Page $NumPage1", 1, "onclick", $FuncionJS, "rojo", "");

                            }
                            print("</td>");
                            $TotalPaginas= ceil($ResultadosTotales/$limit);
                            print("<td colspan=3 style=text-align:center>");
                            print("<strong>Pagina: </strong>");

                            $Page="Consultas/SaludReportesGlosas.draw.php?st=$st&TipoReporte=$TipoReporte&Page=";
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
                            
                            print("<td colspan='2' style=text-align:center>");
                            if($ResultadosTotales>($startpoint+$limit)){
                                $NumPage1=$NumPage+1;
                                $Page="Consultas/SaludReportesGlosas.draw.php?st=$st&Page=$NumPage1&TipoReporte=$TipoReporte&Carry=";
                                $FuncionJS="EnvieObjetoConsulta(`$Page`,`idEPS`,`DivConsultas`,`5`);return false ;";
                                $css->CrearBotonEvento("BtnMas", "Page $NumPage1", 1, "onclick", $FuncionJS, "verde", "");
                            }
                            print("</td>");
                           $css->CierraFilaTabla(); 
                        }
                    }   
                    
                    $css->FilaTabla(14);
                        $css->ColTabla("<strong>CUENTA</strong>", 1);
                        $css->ColTabla("<strong>ENTIDAD</strong>", 1);
                        $css->ColTabla("<strong>FECHA FACTURA</strong>", 1);
                        $css->ColTabla("<strong>PRESTADOR</strong>", 1);
                        $css->ColTabla("<strong>NUMERO DE FACTURA</strong>", 1);
                        $css->ColTabla("<strong>IDENTIFICACION</strong>", 1);
                        $css->ColTabla("<strong>ESTADO</strong>", 1);
                        
                    $css->CierraFilaTabla();
                    
                    while($DatosConsulta=$obGlosas->FetchAssoc($consulta)){
                        $css->FilaTabla(12);
                            $css->ColTabla($DatosConsulta["cuenta"], 1);
                            $css->ColTabla($DatosConsulta["nombre_administrador"], 1);
                            $css->ColTabla($DatosConsulta["fecha_factura"], 1);
                            $css->ColTabla($DatosConsulta["cod_prestador"], 1);
                            $css->ColTabla($DatosConsulta["factura"], 1);
                            $css->ColTabla($DatosConsulta["identificacion"], 1);
                            $css->ColTabla($DatosConsulta["descripcion_estado"], 1);
                        
                        $css->CierraFilaTabla();
                    }
                    
                    $css->CerrarTabla();
                    
                }else{
                    $css->CrearNotificacionAzul("No hay resultados", 14);
                }
        break;
    
        case 2: //Formulario para el registro de una glosa
            $TipoReporte=$obGlosas->normalizar($_REQUEST["TipoReporte"]);
            $idEPS="";
            if(isset($_REQUEST["idEPS"])){
                $idEPS=$obGlosas->normalizar($_REQUEST["idEPS"]);
            }
            $FechaInicial="";
            if(isset($_REQUEST["FechaInicial"])){
                $FechaInicial=$obGlosas->normalizar($_REQUEST["FechaInicial"]);
            }
            $FechaFinal="";
            if(isset($_REQUEST["FechaFinal"])){
                $FechaFinal=$obGlosas->normalizar($_REQUEST["FechaFinal"]);
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
            $Condicional=" WHERE (`cod_estado`= 1 or `cod_estado`= 3 or `cod_estado`= 9) AND Tratado=0";
            if($idEPS<>''){
                $Condicional=$Condicional." AND cod_administrador='$idEPS'";
            }
            if($FechaInicial<>''){
                $Condicional=$Condicional." AND fecha_factura >= '$FechaInicial' ";
            }
            if($FechaFinal<>''){
                $Condicional=$Condicional." AND fecha_factura <= '$FechaFinal' ";
            }
            if($CuentaRIPS<>'000000'){
                $Condicional=$Condicional." AND cuenta = '$CuentaRIPS' ";
            }
            $statement=" `vista_salud_respuestas` $Condicional ";
            
            if(isset($_REQUEST['st'])){

                $statement= base64_decode($_REQUEST['st']);
                //print($statement);
            }
            $limit = 10;
            $startpoint = ($NumPage * $limit) - $limit;
            $VectorST = explode("LIMIT", $statement);
            $statement = $VectorST[0]; 
            $query = "SELECT COUNT(*) as `num` FROM {$statement}";
            $row = $obGlosas->FetchArray($obGlosas->Query($query));
            $ResultadosTotales = $row['num'];
            $st_reporte=$statement;
            $statement.=" LIMIT $startpoint,$limit";
            
            $query="SELECT cuenta,factura,nombre_administrador,fecha_factura,cod_prestador, identificacion, descripcion_estado ";
            $consulta=$obGlosas->Query("$query FROM $statement");
            //print("$query FROM $statement");
            if($obGlosas->NumRows($consulta)){
                
                $Resultados=$obGlosas->NumRows($consulta);
        
                $css->CrearTabla();
                $css->FilaTabla(14);
                    print("<td colspan=7>");
                        $st1= base64_encode($st_reporte);
                        $css->CrearImageLink("PDF_Documentos.php?idDocumento=2&TipoReporte=$TipoReporte&st=$st1", "../images/pdf.png", "_blank", 30, 100);

                    print("</td>");
                $css->CierraFilaTabla();
                //Paginacion
                if($Resultados){

                    $st= base64_encode($statement);
                    if($ResultadosTotales>$limit){

                        $css->FilaTabla(14);
                            print("<td colspan='2' style=text-align:center>");
                            if($NumPage>1){
                                $NumPage1=$NumPage-1;
                                $Page="Consultas/SaludReportesGlosas.draw.php?st=$st&Page=$NumPage1&TipoReporte=$TipoReporte&Carry=";
                                $FuncionJS="EnvieObjetoConsulta(`$Page`,`idEPS`,`DivConsultas`,`5`);return false ;";

                                $css->CrearBotonEvento("BtnMas", "Page $NumPage1", 1, "onclick", $FuncionJS, "rojo", "");

                            }
                            print("</td>");
                            $TotalPaginas= ceil($ResultadosTotales/$limit);
                            print("<td colspan=3 style=text-align:center>");
                            print("<strong>Pagina: </strong>");

                            $Page="Consultas/SaludReportesGlosas.draw.php?st=$st&TipoReporte=$TipoReporte&Page=";
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
                            
                            print("<td colspan='2' style=text-align:center>");
                            if($ResultadosTotales>($startpoint+$limit)){
                                $NumPage1=$NumPage+1;
                                $Page="Consultas/SaludReportesGlosas.draw.php?st=$st&Page=$NumPage1&TipoReporte=$TipoReporte&Carry=";
                                $FuncionJS="EnvieObjetoConsulta(`$Page`,`idEPS`,`DivConsultas`,`5`);return false ;";
                                $css->CrearBotonEvento("BtnMas", "Page $NumPage1", 1, "onclick", $FuncionJS, "verde", "");
                            }
                            print("</td>");
                           $css->CierraFilaTabla(); 
                        }
                    }   
                    
                    $css->FilaTabla(14);
                        $css->ColTabla("<strong>CUENTA</strong>", 1);
                        $css->ColTabla("<strong>ENTIDAD</strong>", 1);
                        $css->ColTabla("<strong>FECHA FACTURA</strong>", 1);
                        $css->ColTabla("<strong>PRESTADOR</strong>", 1);
                        $css->ColTabla("<strong>NUMERO DE FACTURA</strong>", 1);
                        $css->ColTabla("<strong>IDENTIFICACION</strong>", 1);
                        $css->ColTabla("<strong>ESTADO</strong>", 1);
                        
                    $css->CierraFilaTabla();
                    
                    while($DatosConsulta=$obGlosas->FetchAssoc($consulta)){
                        $css->FilaTabla(12);
                            $css->ColTabla($DatosConsulta["cuenta"], 1);
                            $css->ColTabla($DatosConsulta["nombre_administrador"], 1);
                            $css->ColTabla($DatosConsulta["fecha_factura"], 1);
                            $css->ColTabla($DatosConsulta["cod_prestador"], 1);
                            $css->ColTabla($DatosConsulta["factura"], 1);
                            $css->ColTabla($DatosConsulta["identificacion"], 1);
                            $css->ColTabla($DatosConsulta["descripcion_estado"], 1);
                        
                        $css->CierraFilaTabla();
                    }
                    
                    $css->CerrarTabla();
                    
                }else{
                    $css->CrearNotificacionAzul("No hay resultados", 14);
                }
           
        break;
        
        case 3: //Formulario para ver la tabla temporal de glosas iniciales
            $TipoReporte=$obGlosas->normalizar($_REQUEST["TipoReporte"]);
            $idEPS="";
            if(isset($_REQUEST["idEPS"])){
                $idEPS=$obGlosas->normalizar($_REQUEST["idEPS"]);
            }
            $FechaInicial="";
            if(isset($_REQUEST["FechaInicial"])){
                $FechaInicial=$obGlosas->normalizar($_REQUEST["FechaInicial"]);
            }
            $FechaFinal="";
            if(isset($_REQUEST["FechaFinal"])){
                $FechaFinal=$obGlosas->normalizar($_REQUEST["FechaFinal"]);
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
            $Condicional=" WHERE (`cod_estado`= 5 or `cod_estado`= 6) ";
            
            if($FechaInicial<>''){
                $Condicional=$Condicional." AND fecha_factura >= '$FechaInicial' ";
            }
            if($FechaFinal<>''){
                $Condicional=$Condicional." AND fecha_factura <= '$FechaFinal' ";
            }
            if($CuentaRIPS<>'000000'){
                //$Condicional=$Condicional." AND cuenta = '$CuentaRIPS' ";
            }
            $statement=" `vista_salud_respuestas` $Condicional ";
            
            if(isset($_REQUEST['st'])){

                $statement= base64_decode($_REQUEST['st']);
                //print($statement);
            }
            $limit = 10;
            $startpoint = ($NumPage * $limit) - $limit;
            $VectorST = explode("LIMIT", $statement);
            $statement = $VectorST[0]; 
            $query = "SELECT COUNT(*) as `num` FROM {$statement}";
            $row = $obGlosas->FetchArray($obGlosas->Query($query));
            $ResultadosTotales = $row['num'];
            $st_reporte=$statement;
            $statement.=" GROUP BY cod_administrador LIMIT $startpoint,$limit";
            
            $query="SELECT cod_administrador,nombre_administrador,nit_administrador,"
                    . " (SELECT SUM(valor_neto_pagar) FROM salud_archivo_facturacion_mov_generados WHERE cod_enti_administradora=cod_administrador) AS TotalFacturado,"
                    . "SUM(valor_glosado_eps - valor_levantado_eps) AS TotalGlosado ";
            $consulta=$obGlosas->Query("$query FROM $statement");
            //print("$query FROM $statement");
            if($obGlosas->NumRows($consulta)){
                
                $Resultados=$obGlosas->NumRows($consulta);
        
                $css->CrearTabla();
                $css->FilaTabla(14);
                    print("<td colspan=7>");
                        $st1= base64_encode($st_reporte);
                        $css->CrearImageLink("PDF_Documentos.php?idDocumento=2&TipoReporte=$TipoReporte&st=$st1", "../images/pdf.png", "_blank", 30, 100);

                    print("</td>");
                $css->CierraFilaTabla();
                //Paginacion
                if($Resultados){

                    $st= base64_encode($statement);
                    if($ResultadosTotales>$limit){

                        $css->FilaTabla(14);
                            print("<td colspan='2' style=text-align:center>");
                            if($NumPage>1){
                                $NumPage1=$NumPage-1;
                                $Page="Consultas/SaludReportesGlosas.draw.php?st=$st&Page=$NumPage1&TipoReporte=$TipoReporte&Carry=";
                                $FuncionJS="EnvieObjetoConsulta(`$Page`,`idEPS`,`DivConsultas`,`5`);return false ;";

                                $css->CrearBotonEvento("BtnMas", "Page $NumPage1", 1, "onclick", $FuncionJS, "rojo", "");

                            }
                            print("</td>");
                            $TotalPaginas= ceil($ResultadosTotales/$limit);
                            print("<td colspan=2 style=text-align:center>");
                            print("<strong>Pagina: </strong>");

                            $Page="Consultas/SaludReportesGlosas.draw.php?st=$st&TipoReporte=$TipoReporte&Page=";
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
                            
                            print("<td colspan='2' style=text-align:center>");
                            if($ResultadosTotales>($startpoint+$limit)){
                                $NumPage1=$NumPage+1;
                                $Page="Consultas/SaludReportesGlosas.draw.php?st=$st&Page=$NumPage1&TipoReporte=$TipoReporte&Carry=";
                                $FuncionJS="EnvieObjetoConsulta(`$Page`,`idEPS`,`DivConsultas`,`5`);return false ;";
                                $css->CrearBotonEvento("BtnMas", "Page $NumPage1", 1, "onclick", $FuncionJS, "verde", "");
                            }
                            print("</td>");
                           $css->CierraFilaTabla(); 
                        }
                    }   
                    
                    $css->FilaTabla(14);
                        $css->ColTabla("<strong>CODIGO ENTIDAD</strong>", 1);
                        $css->ColTabla("<strong>NOMBRE ENTIDAD</strong>", 1);
                        $css->ColTabla("<strong>NIT</strong>", 1);
                        $css->ColTabla("<strong>TOTAL FACTURADO</strong>", 1);
                        $css->ColTabla("<strong>TOTAL GLOSADO</strong>", 1);
                        $css->ColTabla("<strong>PORCENTAJE</strong>", 1);
                                                
                    $css->CierraFilaTabla();
                    
                    while($DatosConsulta=$obGlosas->FetchAssoc($consulta)){
                        $css->FilaTabla(12);
                            $css->ColTabla($DatosConsulta["cod_administrador"], 1);
                            $css->ColTabla($DatosConsulta["nombre_administrador"], 1);
                            $css->ColTabla($DatosConsulta["nit_administrador"], 1);
                            $css->ColTabla(number_format($DatosConsulta["TotalFacturado"]), 1);
                            $css->ColTabla(number_format($DatosConsulta["TotalGlosado"]), 1);
                            print("<td>");
                                $Porcentaje=ROUND((100/$DatosConsulta["TotalFacturado"])*$DatosConsulta["TotalGlosado"],2);
                                print("$Porcentaje%");
                            print("</td>");
                        
                        $css->CierraFilaTabla();
                    }
                    
                    $css->CerrarTabla();
                    
                }else{
                    $css->CrearNotificacionAzul("No hay resultados", 14);
                }
        break;
        
        case 4: //Formulario para la edicion de una glosa temporal
            
            $TipoReporte=$obGlosas->normalizar($_REQUEST["TipoReporte"]);
            $idEPS="";
            if(isset($_REQUEST["idEPS"])){
                $idEPS=$obGlosas->normalizar($_REQUEST["idEPS"]);
            }
            $FechaInicial="";
            if(isset($_REQUEST["FechaInicial"])){
                $FechaInicial=$obGlosas->normalizar($_REQUEST["FechaInicial"]);
            }
            $FechaFinal="";
            if(isset($_REQUEST["FechaFinal"])){
                $FechaFinal=$obGlosas->normalizar($_REQUEST["FechaFinal"]);
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
            $Condicional=" WHERE (`cod_estado`= 5 or `cod_estado`= 6) ";
            
            if($FechaInicial<>''){
                $Condicional=$Condicional." AND fecha_factura >= '$FechaInicial' ";
            }
            if($FechaFinal<>''){
                $Condicional=$Condicional." AND fecha_factura <= '$FechaFinal' ";
            }
            if($CuentaRIPS<>'000000'){
                //$Condicional=$Condicional." AND cuenta = '$CuentaRIPS' ";
            }
            $statement=" `vista_salud_respuestas` $Condicional ";
            
            if(isset($_REQUEST['st'])){

                $statement= base64_decode($_REQUEST['st']);
                //print($statement);
            }
            $limit = 10;
            $startpoint = ($NumPage * $limit) - $limit;
            $VectorST = explode("LIMIT", $statement);
            $statement = $VectorST[0]; 
            $query = "SELECT COUNT(*) as `num` FROM {$statement}";
            $row = $obGlosas->FetchArray($obGlosas->Query($query));
            $ResultadosTotales = $row['num'];
            $st_reporte=$statement;
            $statement.=" GROUP BY cod_prestador LIMIT $startpoint,$limit";
            
            $query="SELECT cod_prestador,nombre_prestador,nit_prestador,"
                    . " (SELECT SUM(valor_neto_pagar) FROM salud_archivo_facturacion_mov_generados WHERE cod_prest_servicio=cod_prestador) AS TotalFacturado,"
                    . "SUM(valor_glosado_eps - valor_levantado_eps) AS TotalGlosado ";
            $consulta=$obGlosas->Query("$query FROM $statement");
            //print("$query FROM $statement");
            if($obGlosas->NumRows($consulta)){
                
                $Resultados=$obGlosas->NumRows($consulta);
        
                $css->CrearTabla();
                $css->FilaTabla(14);
                    print("<td colspan=7>");
                        $st1= base64_encode($st_reporte);
                        $css->CrearImageLink("PDF_Documentos.php?idDocumento=2&TipoReporte=$TipoReporte&st=$st1", "../images/pdf.png", "_blank", 30, 100);

                    print("</td>");
                $css->CierraFilaTabla();
                //Paginacion
                if($Resultados){

                    $st= base64_encode($statement);
                    if($ResultadosTotales>$limit){

                        $css->FilaTabla(14);
                            print("<td colspan='2' style=text-align:center>");
                            if($NumPage>1){
                                $NumPage1=$NumPage-1;
                                $Page="Consultas/SaludReportesGlosas.draw.php?st=$st&Page=$NumPage1&TipoReporte=$TipoReporte&Carry=";
                                $FuncionJS="EnvieObjetoConsulta(`$Page`,`idEPS`,`DivConsultas`,`5`);return false ;";

                                $css->CrearBotonEvento("BtnMas", "Page $NumPage1", 1, "onclick", $FuncionJS, "rojo", "");

                            }
                            print("</td>");
                            $TotalPaginas= ceil($ResultadosTotales/$limit);
                            print("<td colspan=2 style=text-align:center>");
                            print("<strong>Pagina: </strong>");

                            $Page="Consultas/SaludReportesGlosas.draw.php?st=$st&TipoReporte=$TipoReporte&Page=";
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
                            
                            print("<td colspan='2' style=text-align:center>");
                            if($ResultadosTotales>($startpoint+$limit)){
                                $NumPage1=$NumPage+1;
                                $Page="Consultas/SaludReportesGlosas.draw.php?st=$st&Page=$NumPage1&TipoReporte=$TipoReporte&Carry=";
                                $FuncionJS="EnvieObjetoConsulta(`$Page`,`idEPS`,`DivConsultas`,`5`);return false ;";
                                $css->CrearBotonEvento("BtnMas", "Page $NumPage1", 1, "onclick", $FuncionJS, "verde", "");
                            }
                            print("</td>");
                           $css->CierraFilaTabla(); 
                        }
                    }   
                    
                    $css->FilaTabla(14);
                        $css->ColTabla("<strong>CODIGO PRESTADOR</strong>", 1);
                        $css->ColTabla("<strong>NOMBRE PRESTADOR</strong>", 1);
                        $css->ColTabla("<strong>NIT</strong>", 1);
                        $css->ColTabla("<strong>TOTAL FACTURADO IPS</strong>", 1);
                        $css->ColTabla("<strong>TOTAL GLOSADO A IPS</strong>", 1);
                        $css->ColTabla("<strong>PORCENTAJE</strong>", 1);
                                                
                    $css->CierraFilaTabla();
                    
                    while($DatosConsulta=$obGlosas->FetchAssoc($consulta)){
                        $css->FilaTabla(12);
                            $css->ColTabla($DatosConsulta["cod_prestador"], 1);
                            $css->ColTabla($DatosConsulta["nombre_prestador"], 1);
                            $css->ColTabla($DatosConsulta["nit_prestador"], 1);
                            $css->ColTabla(number_format($DatosConsulta["TotalFacturado"]), 1);
                            $css->ColTabla(number_format($DatosConsulta["TotalGlosado"]), 1);
                            print("<td>");
                                $Porcentaje=ROUND((100/$DatosConsulta["TotalFacturado"])*$DatosConsulta["TotalGlosado"],2);
                                print("$Porcentaje%");
                            print("</td>");
                        
                        $css->CierraFilaTabla();
                    }
                    
                    $css->CerrarTabla();
                    
                }else{
                    $css->CrearNotificacionAzul("No hay resultados", 14);
                }
            
        break;
        case 5:
            $TipoReporte=$obGlosas->normalizar($_REQUEST["TipoReporte"]);
            $idEPS="";
            if(isset($_REQUEST["idEPS"])){
                $idEPS=$obGlosas->normalizar($_REQUEST["idEPS"]);
            }
            $FechaInicial="";
            if(isset($_REQUEST["FechaInicial"])){
                $FechaInicial=$obGlosas->normalizar($_REQUEST["FechaInicial"]);
            }
            $FechaFinal="";
            if(isset($_REQUEST["FechaFinal"])){
                $FechaFinal=$obGlosas->normalizar($_REQUEST["FechaFinal"]);
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
            $Condicional=" WHERE (`cod_estado`= 5 or `cod_estado`= 6) ";
            
            if($FechaInicial<>''){
                $Condicional=$Condicional." AND fecha_factura >= '$FechaInicial' ";
            }
            if($FechaFinal<>''){
                $Condicional=$Condicional." AND fecha_factura <= '$FechaFinal' ";
            }
            if($CuentaRIPS<>'000000'){
                //$Condicional=$Condicional." AND cuenta = '$CuentaRIPS' ";
            }
            $statement=" `vista_salud_respuestas` $Condicional ";
            
            if(isset($_REQUEST['st'])){

                $statement= base64_decode($_REQUEST['st']);
                //print($statement);
            }
            $limit = 10;
            $startpoint = ($NumPage * $limit) - $limit;
            $VectorST = explode("LIMIT", $statement);
            $statement = $VectorST[0]; 
            $query = "SELECT COUNT(*) as `num` FROM {$statement}";
            $row = $obGlosas->FetchArray($obGlosas->Query($query));
            $ResultadosTotales = $row['num'];
            $st_reporte=$statement;
            $statement.=" GROUP BY regimen_eps LIMIT $startpoint,$limit";
            
            $query="SELECT regimen_eps,"
                    . "SUM(valor_glosado_eps) AS TotalGlosado,"
                    . "SUM(valor_glosado_eps - valor_levantado_eps) AS TotalGlosadoDefinitivo ";
            $consulta=$obGlosas->Query("$query FROM $statement");
            //print("$query FROM $statement");
            if($obGlosas->NumRows($consulta)){
                
                $Resultados=$obGlosas->NumRows($consulta);
        
                $css->CrearTabla();
                $css->FilaTabla(14);
                    print("<td colspan=7>");
                        $st1= base64_encode($st_reporte);
                        $css->CrearImageLink("PDF_Documentos.php?idDocumento=2&TipoReporte=$TipoReporte&st=$st1", "../images/pdf.png", "_blank", 30, 100);

                    print("</td>");
                $css->CierraFilaTabla();
                //Paginacion
                if($Resultados){

                    $st= base64_encode($statement);
                    if($ResultadosTotales>$limit){

                        $css->FilaTabla(14);
                            print("<td colspan='1' style=text-align:center>");
                            if($NumPage>1){
                                $NumPage1=$NumPage-1;
                                $Page="Consultas/SaludReportesGlosas.draw.php?st=$st&Page=$NumPage1&TipoReporte=$TipoReporte&Carry=";
                                $FuncionJS="EnvieObjetoConsulta(`$Page`,`idEPS`,`DivConsultas`,`5`);return false ;";

                                $css->CrearBotonEvento("BtnMas", "Page $NumPage1", 1, "onclick", $FuncionJS, "rojo", "");

                            }
                            print("</td>");
                            $TotalPaginas= ceil($ResultadosTotales/$limit);
                            print("<td colspan=2 style=text-align:center>");
                            print("<strong>Pagina: </strong>");

                            $Page="Consultas/SaludReportesGlosas.draw.php?st=$st&TipoReporte=$TipoReporte&Page=";
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
                            
                            print("<td colspan='1' style=text-align:center>");
                            if($ResultadosTotales>($startpoint+$limit)){
                                $NumPage1=$NumPage+1;
                                $Page="Consultas/SaludReportesGlosas.draw.php?st=$st&Page=$NumPage1&TipoReporte=$TipoReporte&Carry=";
                                $FuncionJS="EnvieObjetoConsulta(`$Page`,`idEPS`,`DivConsultas`,`5`);return false ;";
                                $css->CrearBotonEvento("BtnMas", "Page $NumPage1", 1, "onclick", $FuncionJS, "verde", "");
                            }
                            print("</td>");
                           $css->CierraFilaTabla(); 
                        }
                    }   
                    
                    $css->FilaTabla(14);
                        $css->ColTabla("<strong>REGIMEN</strong>", 1);
                        $css->ColTabla("<strong>TOTAL GLOSADO</strong>", 1);
                        $css->ColTabla("<strong>TOTAL GLOSADO DEFINITIVO</strong>", 1);
                        $css->ColTabla("<strong>DIFERENCIA</strong>", 1);
                        
                                                
                    $css->CierraFilaTabla();
                    
                    while($DatosConsulta=$obGlosas->FetchAssoc($consulta)){
                        $css->FilaTabla(12);
                            $css->ColTabla($DatosConsulta["regimen_eps"], 1);
                            
                            $css->ColTabla(number_format($DatosConsulta["TotalGlosado"]), 1);
                            $css->ColTabla(number_format($DatosConsulta["TotalGlosadoDefinitivo"]), 1);
                            $css->ColTabla(number_format($DatosConsulta["TotalGlosado"]-$DatosConsulta["TotalGlosadoDefinitivo"]), 1);
                            
                        
                        $css->CierraFilaTabla();
                    }
                    
                    $css->CerrarTabla();
                    
                }else{
                    $css->CrearNotificacionAzul("No hay resultados", 14);
                }
        break;        
        
        case 6: //Glosas frecuentes
            $TipoReporte=$obGlosas->normalizar($_REQUEST["TipoReporte"]);
            $idEPS="";
            if(isset($_REQUEST["idEPS"])){
                $idEPS=$obGlosas->normalizar($_REQUEST["idEPS"]);
            }
            $FechaInicial="";
            if(isset($_REQUEST["FechaInicial"])){
                $FechaInicial=$obGlosas->normalizar($_REQUEST["FechaInicial"]);
            }
            $FechaFinal="";
            if(isset($_REQUEST["FechaFinal"])){
                $FechaFinal=$obGlosas->normalizar($_REQUEST["FechaFinal"]);
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
            $Condicional=" WHERE (`cod_glosa_inicial`<>'') ";
            
            if($FechaInicial<>''){
                $Condicional=$Condicional." AND fecha_factura >= '$FechaInicial' ";
            }
            if($FechaFinal<>''){
                $Condicional=$Condicional." AND fecha_factura <= '$FechaFinal' ";
            }
            if($CuentaRIPS<>'000000'){
                //$Condicional=$Condicional." AND cuenta = '$CuentaRIPS' ";
            }
            $statement=" `vista_salud_respuestas` $Condicional ";
            
            if(isset($_REQUEST['st'])){

                $statement= base64_decode($_REQUEST['st']);
                //print($statement);
            }
            $limit = 10;
            $startpoint = ($NumPage * $limit) - $limit;
            $VectorST = explode("LIMIT", $statement);
            $statement = $VectorST[0]; 
            $query = "SELECT COUNT(*) as `num` FROM {$statement}";
            $row = $obGlosas->FetchArray($obGlosas->Query($query));
            $ResultadosTotales = $row['num'];
            $st_reporte=$statement;
            $statement.=" GROUP BY cod_glosa_inicial ORDER BY (COUNT(cod_glosa_inicial)) DESC LIMIT $startpoint,$limit";
            
            $query="SELECT cod_glosa_inicial, descripcion_glosa_inicial,"
                    . "COUNT(cod_glosa_inicial) AS Cantidad ";
            //print("$query FROM $statement");      
            $consulta=$obGlosas->Query("$query FROM $statement");
            
            if($obGlosas->NumRows($consulta)){
                
                $Resultados=$obGlosas->NumRows($consulta);
        
                $css->CrearTabla();
                $css->FilaTabla(14);
                    print("<td colspan=7>");
                        $st1= base64_encode($st_reporte);
                        $css->CrearImageLink("PDF_Documentos.php?idDocumento=2&TipoReporte=$TipoReporte&st=$st1", "../images/pdf.png", "_blank", 30, 100);

                    print("</td>");
                $css->CierraFilaTabla();
                //Paginacion
                if($Resultados){

                    $st= base64_encode($statement);
                    if($ResultadosTotales>$limit){

                        $css->FilaTabla(14);
                            print("<td colspan='1' style=text-align:center>");
                            if($NumPage>1){
                                $NumPage1=$NumPage-1;
                                $Page="Consultas/SaludReportesGlosas.draw.php?st=$st&Page=$NumPage1&TipoReporte=$TipoReporte&Carry=";
                                $FuncionJS="EnvieObjetoConsulta(`$Page`,`idEPS`,`DivConsultas`,`5`);return false ;";

                                $css->CrearBotonEvento("BtnMas", "Page $NumPage1", 1, "onclick", $FuncionJS, "rojo", "");

                            }
                            print("</td>");
                            $TotalPaginas= ceil($ResultadosTotales/$limit);
                            print("<td colspan=1 style=text-align:center>");
                            print("<strong>Pagina: </strong>");

                            $Page="Consultas/SaludReportesGlosas.draw.php?st=$st&TipoReporte=$TipoReporte&Page=";
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
                            
                            print("<td colspan='1' style=text-align:center>");
                            if($ResultadosTotales>($startpoint+$limit)){
                                $NumPage1=$NumPage+1;
                                $Page="Consultas/SaludReportesGlosas.draw.php?st=$st&Page=$NumPage1&TipoReporte=$TipoReporte&Carry=";
                                $FuncionJS="EnvieObjetoConsulta(`$Page`,`idEPS`,`DivConsultas`,`5`);return false ;";
                                $css->CrearBotonEvento("BtnMas", "Page $NumPage1", 1, "onclick", $FuncionJS, "verde", "");
                            }
                            print("</td>");
                           $css->CierraFilaTabla(); 
                        }
                    }   
                    
                    $css->FilaTabla(14);
                        $css->ColTabla("<strong>CODIGO GLOSA</strong>", 1);
                        $css->ColTabla("<strong>DESCRIPCION</strong>", 1);
                        $css->ColTabla("<strong>CANTIDAD</strong>", 1);
                        
                                                
                    $css->CierraFilaTabla();
                    
                    while($DatosConsulta=$obGlosas->FetchAssoc($consulta)){
                        $css->FilaTabla(12);
                            $css->ColTabla($DatosConsulta["cod_glosa_inicial"], 1);
                            
                            $css->ColTabla(utf8_encode($DatosConsulta["descripcion_glosa_inicial"]),1);
                            $css->ColTabla(number_format($DatosConsulta["Cantidad"]), 1);
                            
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