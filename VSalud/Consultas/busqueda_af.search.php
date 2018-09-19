<?php

session_start();
if (!isset($_SESSION['username'])){
  exit("<a href='../index.php' ><img src='../images/401.png'>Iniciar Sesion </a>");
  
}
$idUser=$_SESSION['idUser'];
$TipoUser=$_SESSION['tipouser'];
//$myPage="titulos_comisiones.php";
include_once("../../modelo/php_conexion.php");

include_once("../css_construct.php");


if( !empty($_REQUEST["idFactura"]) or !empty($_REQUEST["CuentaRIPS"]) or !empty($_REQUEST["FechaInicial"]) or !empty($_REQUEST["FechaFinal"]) or !empty($_REQUEST["idEstadoGlosas"]) or !empty($_REQUEST["Page"]) or !empty($_REQUEST["st"]) ){
    $css =  new CssIni("id",0);
    $obGlosas = new conexion($idUser);
        
    // Consultas enviadas a traves de la URL
    $statement="";
    
    //////////////////
    $CuentaRIPS=$obGlosas->normalizar($_REQUEST['CuentaRIPS']);
    $CuentaRIPS=str_pad($CuentaRIPS, 6, "0", STR_PAD_LEFT);
        
    $statement=" `vista_af_semaforo` WHERE `CuentaRIPS`='$CuentaRIPS' ";
    //Busco por Cuenta Numero de Factura
    if(isset($_REQUEST["idFactura"]) and !empty($_REQUEST["idFactura"])){
        $NumFactura=$obGlosas->normalizar($_REQUEST['idFactura']);
        //$css->CrearNotificacionRoja("Cuentas que contienen la factura: ".$NumFactura, 16);        
        $statement=" `vista_af_semaforo` WHERE `num_factura`='$NumFactura'";
    }
    /*
    if(isset($_REQUEST["CuentaRIPS"]) and !empty($_REQUEST["CuentaRIPS"])){
        $CuentaRIPS=$obGlosas->normalizar($_REQUEST['CuentaRIPS']);
        $CuentaRIPS=str_pad($CuentaRIPS, 6, "0", STR_PAD_LEFT);
        $statement=" `vista_af_semaforo` WHERE `CuentaRIPS`='$CuentaRIPS'";
    }
     * 
     */
    $FechaInicial=date("Y-m-d");
    $FechaFinal=date("Y-m-d");
    if(isset($_REQUEST["FechaInicial"])){
        $FechaInicial=$obGlosas->normalizar($_REQUEST["FechaInicial"]);
        $FechaFinal=$obGlosas->normalizar($_REQUEST["FechaFinal"]);
        $statement.=" AND `fecha_factura`>='$FechaInicial' AND `fecha_factura`<='$FechaFinal'";
    }
    $idEstadoGlosa='';
    if(isset($_REQUEST["idEstadoGlosas"]) and !empty($_REQUEST["idEstadoGlosas"])){
        $idEstadoGlosa=$obGlosas->normalizar($_REQUEST["idEstadoGlosas"]);        
        $statement.=" AND `EstadoGlosa`=$idEstadoGlosa";
    }
    //print($statement);
    $css->CrearTabla();
            $css->FilaTabla(16);
                $css->ColTabla("<strong>Criterios de Búsqueda</strong>", 3);
            $css->CierraFilaTabla();
            $css->FilaTabla(12);
                $css->ColTabla("<strong>Fecha Inicial</strong>", 1);
                $css->ColTabla("<strong>Fecha Final</strong>", 1);
                $css->ColTabla("<strong>Filtrar por Estado de Glosas</strong>", 1);
                $css->ColTabla("<strong>Filtrar</strong>", 1);
            $css->CierraFilaTabla();
            $css->FilaTabla(12);
                print("<td>");
                    
                    $css->CrearInputText("FiltroFechaInicial", "date", "", $FechaInicial, "", "", "", "", 150, 30, 0, 0);
                print("</td>");
                print("<td>");
                    $css->CrearInputText("FiltroFechaFinal", "date", "", $FechaFinal, "", "", "", "", 150, 30, 0, 0);
                print("</td>");
                print("<td>");
                //$css->CrearTableChosen("CmbEstadoGlosaFacturas", "salud_estado_glosas", "", "ID", "ID", "Estado_glosa", "ID", 200, 0, "", "");
                //$css->CrearSelectTable("CmbEstadoGlosaFacturas", "salud_estado_glosas", "", "ID", "ID", "Estado_glosa", "onChange", "FiltreFacturasXEstadoGlosa()", "", 0);
                $css->CrearSelectTable("CmbEstadoGlosaFacturas", "salud_estado_glosas", "", "ID", "ID", "Estado_glosa", "", "", "", $idEstadoGlosa);
                print("</td>");
                print("<td>");
                    $css->CrearBotonEvento("BtnFiltroFecha", "Filtrar", 1, "onClick", "FiltreRangoFechas()", "naranja", "");
                print("</td>");
                
            $css->CierraFilaTabla();
        $css->CerrarTabla();
        //print($statement);
    //Paginacion
        
        
    if(isset($_REQUEST['st'])){

        $statement= base64_decode($_REQUEST['st']);
        //print($statement);
    }
    
    //Paginacion
    if(isset($_REQUEST['Page'])){
        $NumPage=$obGlosas->normalizar($_REQUEST['Page']);
    }else{
        $NumPage=1;
    }
    
    $limit = 10;
    $startpoint = ($NumPage * $limit) - $limit;
    $VectorST = explode("LIMIT", $statement);
    $statement = $VectorST[0]; 
    $query = "SELECT COUNT(*) as `num` FROM {$statement}";
    $row = $obGlosas->FetchArray($obGlosas->Query($query));
    $ResultadosTotales = $row['num'];
    $statementPage=$statement;
    $statement.=" ORDER BY Dias DESC LIMIT $startpoint,$limit";
    
    
    //print("st:$statement");
    $query="SELECT identificacion_usuario,cod_prest_servicio,Dias,CuentaRIPS,CuentaGlobal,num_factura,fecha_factura,valor_neto_pagar,EstadoGlosa as idGlosa,"
            . " (SELECT Estado_glosa FROM salud_estado_glosas WHERE salud_estado_glosas.ID = `EstadoGlosa`) as EstadoGlosa  ";
    $consulta=$obGlosas->Query("$query FROM $statement");
    if($obGlosas->NumRows($consulta)){
        
        $Resultados=$obGlosas->NumRows($consulta);
        
        $css->CrearTabla();
        //Paginacion
        if($Resultados){
            
            $st= base64_encode($statementPage);
            $css->CrearDiv("DivActualizar", "", "center", 0, 1);
                $Page="Consultas/busqueda_af.search.php?st=$st&Page=1&CuentaRIPS=$CuentaRIPS&Carry=";
                $FuncionJS="EnvieObjetoConsulta(`$Page`,`idEPS`,`DivFacturas`,`5`);return false ;";

                $css->CrearBotonEvento("BtnActualizarFacturas", "Actualizar", 1, "onclick", $FuncionJS, "naranja", "");
            $css->CerrarDiv();
            
            if($ResultadosTotales>$limit){
                
                $css->FilaTabla(16);
                print("<td colspan='2' style=text-align:center>");
                if($NumPage>1){
                    
                    
                    $NumPage1=$NumPage-1;
                    $Page="Consultas/busqueda_af.search.php?st=$st&Page=$NumPage1&CuentaRIPS=$CuentaRIPS&Carry=";
                    $FuncionJS="EnvieObjetoConsulta(`$Page`,`idEPS`,`DivFacturas`,`5`);return false ;";
                    
                    $css->CrearBotonEvento("BtnMas", "Página $NumPage1", 1, "onclick", $FuncionJS, "rojo", "");
                    
                }
                print("</td>");
                $TotalPaginas= ceil($ResultadosTotales/$limit);
                print("<td colspan=5 style=text-align:center>");
                print("<strong>Página: </strong>");
                                
                $Page="Consultas/busqueda_af.search.php?st=$st&CuentaRIPS=$CuentaRIPS&Page=";
                $FuncionJS="EnvieObjetoConsulta(`$Page`,`CmbPage`,`DivFacturas`,`5`);return false ;";
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
                    $Page="Consultas/busqueda_af.search.php?st=$st&Page=$NumPage1&CuentaRIPS=$CuentaRIPS&Carry=";
                    $FuncionJS="EnvieObjetoConsulta(`$Page`,`idEPS`,`DivFacturas`,`5`);return false ;";
                    $css->CrearBotonEvento("BtnMas", "Página $NumPage1", 1, "onclick", $FuncionJS, "verde", "");
                }
                print("</td>");
               $css->CierraFilaTabla(); 
            }
        }   
        $css->FilaTabla(12);
            $css->ColTabla("<strong>Fecha</strong>", 1);
            $css->ColTabla("<strong>IPS</strong>", 1);
            $css->ColTabla("<strong>Cuenta RIPS</strong>", 1);
            $css->ColTabla("<strong>Cuenta Global</strong>", 1);
            $css->ColTabla("<strong>Numero de Factura</strong>", 1);
            $css->ColTabla("<strong>Identificación</strong>", 1);
            $css->ColTabla("<strong>Valor</strong>", 1);
            $css->ColTabla("<strong>Estado</strong>", 1);
            $css->ColTabla("<strong>Semáforo</strong>", 1);
            $css->ColTabla("<strong>Abrir</strong>", 1);
            
            
        $css->CierraFilaTabla();
        
        while($DatosCuenta=$obGlosas->FetchArray($consulta)){
            
            $css->FilaTabla(12);
                $css->ColTabla($DatosCuenta["fecha_factura"], 1);
                $css->ColTabla($DatosCuenta["cod_prest_servicio"], 1);
                $css->ColTabla($DatosCuenta["CuentaRIPS"], 1);
                $css->ColTabla($DatosCuenta["CuentaGlobal"], 1);
                $css->ColTabla($DatosCuenta["num_factura"], 1);
                $css->ColTabla($DatosCuenta["identificacion_usuario"], 1);
                $css->ColTabla(number_format($DatosCuenta["valor_neto_pagar"]), 1);
                print("<td><div id='EstadoGlosaFactura_$DatosCuenta[num_factura]'>");
                    print($DatosCuenta["EstadoGlosa"]);
                print("</td></div>");
                
                
                    print("<td style='text-align:center'>");
                        print("<div id='DivSemaforoFactura_$DatosCuenta[num_factura]'>");
                            if($DatosCuenta["Dias"]>=0 and $DatosCuenta["Dias"]<=5 and $DatosCuenta["idGlosa"]==1){
                                $imagerute="../images/verde.png";
                                $css->CrearImage("ImgSemaforo", $imagerute, "", 50, 20);
                            }
                            if($DatosCuenta["Dias"]>=6 and $DatosCuenta["Dias"]<=10 and $DatosCuenta["idGlosa"]==1){
                                $imagerute="../images/naranja.png";
                                $css->CrearImage("ImgSemaforo", $imagerute, "", 50, 20);
                            }
                            if($DatosCuenta["Dias"]>=11 and  $DatosCuenta["idGlosa"]==1){
                                $imagerute="../images/rojo.png";
                                $css->CrearImage("ImgSemaforo", $imagerute, "", 50, 20);
                            }
                    print("</td>");
                print("</td>");
                $idFactura=$DatosCuenta["num_factura"];   
                print("<td style='text-align:center'>");
                     $css->CrearBotonEvento("BtnMostrar_$idFactura", "ver factura", 1, "onClick", "MostrarActividades('$DatosCuenta[num_factura]');CambiarColorBtnFacturas('BtnMostrar_$idFactura');", "verde", "");
                print("</td>");
            $css->CierraFilaTabla();
        }
        $css->CerrarTabla();
    }else{
        $css->CrearNotificacionRoja("No se encontraron datos", 16);
    }
    
}else{
    print("No se enviaron parametros");
}
?>