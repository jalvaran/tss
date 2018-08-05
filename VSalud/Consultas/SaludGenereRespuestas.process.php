<?php

session_start();
if (!isset($_SESSION['username'])){
  exit("<a href='../index.php' ><img src='../images/401.png'>Iniciar Sesion </a>");
  
}
$idUser=$_SESSION['idUser'];
$TipoUser=$_SESSION['tipouser'];
include_once("../../modelo/php_conexion.php");
include_once("../css_construct.php");
include_once("../clases/SaludReportes.class.php");


$obCon = new Reportes($idUser);
if($_REQUEST["idAccion"]){
    $css =  new CssIni("id",0);
    
    switch ($_REQUEST["idAccion"]){
        case 1://Se reciben las cuentas y se llevan las facturas con respuestas a la tabla para iniciar el proceso de consulta de respuestas y regostro en el excel
                        
            $CuentaRIPS=explode(",",$obCon->normalizar($_REQUEST["Cuentas"]));
           
            foreach ($CuentaRIPS as $key){
                $sql="SELECT num_factura,"
                        . " (SELECT cod_enti_administradora FROM salud_archivo_facturacion_mov_generados"
                        . " WHERE salud_archivo_facturacion_mov_generados.num_factura=salud_archivo_control_glosas_respuestas.num_factura) as idEPS"
                        . " FROM salud_archivo_control_glosas_respuestas WHERE CuentaRIPS='$key' and (EstadoGlosa='2' or EstadoGlosa='4') GROUP BY num_factura";
                $consulta=$obCon->Query($sql);
                while($DatosFacturas=$obCon->FetchArray($consulta)){
                    $obCon->CargaFacturasAResponder($key,$DatosFacturas["num_factura"], $DatosFacturas["idEPS"], "");
                }
               
            }
            $sql="SELECT idEPS FROM salud_control_generacion_respuestas_excel GROUP BY idEPS";
            $consulta=$obCon->Query($sql);
            
            if($obCon->NumRows($consulta)==1){
                print("OK");
            }else if($obCon->NumRows($consulta)==0){
                print("<h4 style='color:orange'>No se encontraron respuestas para las facturas asociadas a las cuentas seleccionadas</h4>");
            }else{
                print("<h4 style='color:red'>Se seleccionaron cuentas de dos o mas EPS, Sólo es posible seleccionar cuentas de una EPS</h4>");
           
            }
            
        break;
        
        case 2://Se borra el control de respuestas en caso de que ocurra un error
            $obCon->VaciarTabla("salud_control_generacion_respuestas_excel");
            print("OK");
        break;
    
        case 3://Crear el archivo y Carpeta
            $obCon->CrearArchivoRespuestas("Respuestas.xlsx", 0, "");
            print("OK");
        break;
        
        case 4://Crear las respuestas para cada Factura
            $sql="SELECT count(num_factura) as Total FROM salud_control_generacion_respuestas_excel";
            $consulta=$obCon->Query($sql);
            $DatosFacturas=$obCon->FetchArray($consulta);
            $TotalFacturas=$DatosFacturas["Total"];
            
            
            $NombreArchivo="Respuestas.xlsx";
            $obCon->RegistreRespuestasFacturaExcel($NombreArchivo,"");
            
            $sql="SELECT COUNT(*) as Total FROM salud_control_generacion_respuestas_excel WHERE Generada=1";
            $consulta=$obCon->Query($sql);
            $DatosFacturas=$obCon->FetchArray($consulta);
            $TotalFacturasRegistradas=$DatosFacturas["Total"];
            if($TotalFacturasRegistradas==0){
                $TotalFacturasRegistradas=1;
            }
            $Porcentaje=round((50/$TotalFacturas)*$TotalFacturasRegistradas);
            
            if($Porcentaje==50){
                               
                print("FIN;");
            }else{
                print("OK;$TotalFacturas;$TotalFacturasRegistradas;$Porcentaje");
            }
            
            
        break;
        
               
    }
    
}else{
    
    print("No se recibieron parametros");
}
    
    

?>