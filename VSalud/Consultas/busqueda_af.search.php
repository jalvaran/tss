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


if( !empty($_REQUEST["idFactura"]) or !empty($_REQUEST["CuentaRIPS"]) or !empty($_REQUEST["FechaInicial"]) or !empty($_REQUEST["FechaFinal"]) or !empty($_REQUEST["idEstadoGlosas"]) or !empty($_REQUEST["Page"]) ){
    $css =  new CssIni("id",0);
    $obGlosas = new conexion($idUser);
        
    // Consultas enviadas a traves de la URL
    $statement="";
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
    
    //////////////////
    
    //Busco por Cuenta Numero de Factura
    if(isset($_REQUEST["idFactura"]) and !empty($_REQUEST["idFactura"])){
        $NumFactura=$obGlosas->normalizar($_REQUEST['idFactura']);
        //$css->CrearNotificacionRoja("Cuentas que contienen la factura: ".$NumFactura, 16);        
        $statement=" `salud_archivo_facturacion_mov_generados` WHERE `num_factura`='$NumFactura'";
    }
    //Busco por Cuenta RIPS
    if(isset($_REQUEST["CuentaRIPS"]) and !empty($_REQUEST["CuentaRIPS"])){
        $CuentaRIPS=$obGlosas->normalizar($_REQUEST['CuentaRIPS']);
        $statement=" `salud_archivo_facturacion_mov_generados` WHERE `CuentaRIPS`='$CuentaRIPS'";
    }
    if(isset($_REQUEST["FechaInicial"])){
        $FechaInicial=$obGlosas->normalizar($_REQUEST["FechaInicial"]);
        $FechaFinal=$obGlosas->normalizar($_REQUEST["FechaFinal"]);
        $statement=" `salud_archivo_facturacion_mov_generados` WHERE `fecha_factura`>='$FechaInicial' AND `fecha_factura`<='$FechaFinal'";
    }
    if(isset($_REQUEST["idEstadoGlosas"])){
        $idEstadoGlosa=$obGlosas->normalizar($_REQUEST["idEstadoGlosas"]);        
        $statement=" `salud_archivo_facturacion_mov_generados` WHERE `EstadoGlosa`='$idEstadoGlosa'";
    }
    
    $css->CrearTabla();
            $css->FilaTabla(16);
                $css->ColTabla("<strong>Criterios de Búsqueda</strong>", 3);
            $css->CierraFilaTabla();
            $css->FilaTabla(12);
                $css->ColTabla("Fecha Inicial", 1);
                $css->ColTabla("Fecha Final", 2);
                $css->ColTabla("Filtrar por Estado de Glosas", 1);
            $css->CierraFilaTabla();
            $css->FilaTabla(12);
                print("<td>");
                    
                    $css->CrearInputText("FiltroFechaInicial", "date", "", date("Y-m-d"), "", "", "", "", 150, 30, 0, 0);
                print("</td>");
                print("<td>");
                    $css->CrearInputText("FiltroFechaFinal", "date", "", date("Y-m-d"), "", "", "", "", 150, 30, 0, 0);
                print("</td>");
                print("<td>");
                    $css->CrearBotonEvento("BtnFiltroFecha", "Filtrar por Rango", 1, "onClick", "FiltreRangoFechas()", "naranja", "");
                print("</td>");
                print("<td>");
                //$css->CrearTableChosen("CmbEstadoGlosaFacturas", "salud_estado_glosas", "", "ID", "ID", "Estado_glosa", "ID", 200, 0, "", "");
                $css->CrearSelectTable("CmbEstadoGlosaFacturas", "salud_estado_glosas", "", "ID", "ID", "Estado_glosa", "onChange", "FiltreFacturasXEstadoGlosa()", "", 0);
                print("</td>");
            $css->CierraFilaTabla();
        $css->CerrarTabla();
        //print($statement);
    //Paginacion
    $limit = 10;
    $startpoint = ($NumPage * $limit) - $limit;
    $VectorST = explode("LIMIT", $statement);
    $statement = $VectorST[0]; 
    $query = "SELECT COUNT(*) as `num` FROM {$statement}";
    $row = $obGlosas->FetchArray($obGlosas->Query($query));
    $ResultadosTotales = $row['num'];
        
    $statement.=" LIMIT $startpoint,$limit";
    
    
    //print("st:$statement");
    $query="SELECT cod_prest_servicio,CuentaRIPS,CuentaGlobal,num_factura,fecha_factura,valor_neto_pagar,EstadoGlosa as idGlosa,"
            . " (SELECT Estado_glosa FROM salud_estado_glosas WHERE salud_estado_glosas.ID = `EstadoGlosa`) as EstadoGlosa  ";
    $consulta=$obGlosas->Query("$query FROM $statement");
    if($obGlosas->NumRows($consulta)){
        
        $Resultados=$obGlosas->NumRows($consulta);
        
        $css->CrearTabla();
        //Paginacion
        if($Resultados){
            
            $st= base64_encode($statement);
            if($ResultadosTotales>$limit){
                
                $css->FilaTabla(16);
                print("<td colspan='2' style=text-align:center>");
                if($NumPage>1){
                    $NumPage1=$NumPage-1;
                    $Page="Consultas/busqueda_af.search.php?st=$st&Page=$NumPage1&Carry=";
                    $FuncionJS="EnvieObjetoConsulta(`$Page`,`idEPS`,`DivFacturas`,`5`);return false ;";
                    
                    $css->CrearBotonEvento("BtnMas", "Page $NumPage1", 1, "onclick", $FuncionJS, "rojo", "");
                    
                }
                print("</td>");
                $TotalPaginas= ceil($ResultadosTotales/$limit);
                print("<td colspan=4 style=text-align:center>");
                print("<strong>Pagina: </strong>");
                                
                $Page="Consultas/busqueda_af.search.php?st=$st&Page=";
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
                    $Page="Consultas/busqueda_af.search.php?st=$st&Page=$NumPage1&Carry=";
                    $FuncionJS="EnvieObjetoConsulta(`$Page`,`idEPS`,`DivFacturas`,`5`);return false ;";
                    $css->CrearBotonEvento("BtnMas", "Page $NumPage1", 1, "onclick", $FuncionJS, "verde", "");
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
            $css->ColTabla("<strong>Valor</strong>", 1);
            $css->ColTabla("<strong>Estado</strong>", 1);
            $css->ColTabla("<strong>Abrir</strong>", 1);
            
            
        $css->CierraFilaTabla();
        
        while($DatosCuenta=$obGlosas->FetchArray($consulta)){
            
            $css->FilaTabla(12);
                $css->ColTabla($DatosCuenta["fecha_factura"], 1);
                $css->ColTabla($DatosCuenta["cod_prest_servicio"], 1);
                $css->ColTabla($DatosCuenta["CuentaRIPS"], 1);
                $css->ColTabla($DatosCuenta["CuentaGlobal"], 1);
                $css->ColTabla($DatosCuenta["num_factura"], 1);
                $css->ColTabla(number_format($DatosCuenta["valor_neto_pagar"]), 1);
                $css->ColTabla($DatosCuenta["EstadoGlosa"], 1);
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