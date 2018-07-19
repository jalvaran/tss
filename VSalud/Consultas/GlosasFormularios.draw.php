<?php

session_start();
if (!isset($_SESSION['username'])){
  exit("<a href='../index.php' ><img src='../images/401.png'>Iniciar Sesion </a>");
  
}
$idUser=$_SESSION['idUser'];

include_once("../../modelo/php_conexion.php");
include_once("../css_construct.php");

if( !empty($_REQUEST["idFormulario"]) ){
    $css =  new CssIni("id",0);
    $obGlosas = new conexion($idUser);
    
    switch ($_REQUEST["idFormulario"]) {
        case 1: //Formulario para el registro de una devolucion
            
            $idFactura=$obGlosas->normalizar($_REQUEST["idFactura"]);
            $css->CrearTabla();
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>Realizar la devolucion de la Factura $idFactura</strong>", 1);
                $css->CierraFilaTabla();
                $css->FilaTabla(16);
                    
                    print("<td style='text-align:center'>");
                        $css->CrearInputText("FechaDevolucion", "date", "Fecha de Devolucion<br>", date("Y-m-d"), "Fecha de Devolucion", "", "", "", 150, 30, 0, 1);
                    print("</td>");
                $css->CierraFilaTabla();
                $css->FilaTabla(16);
                    print("<td style='text-align:center'>");
                        $css->CrearTableChosen("CodigoGlosa", "salud_archivo_conceptos_glosas", "", "cod_glosa", "descrpcion_concep_especifico", "aplicacion", "cod_glosa", 300, 1, "Codigo Glosa", "");
                    print("</td>");
                $css->CierraFilaTabla();
                $css->FilaTabla(16);
                   
                    print("<td style='text-align:center'>");
                        $css->CrearTextArea("Observaciones", "", "", "Observaciones", "", "", "", 200, 60, 0, 1);
                    print("</td>");
                $css->CierraFilaTabla();
                
                $css->FilaTabla(16);
                    print("<td style='text-align:center'>");
                        print("<strong>Soporte de devolucion:</strong><br>");
                        $css->CrearUpload("Soporte");
                        print("<br>");
                        $css->CrearBotonEvento("BtnEnviarDevolucion", "Enviar", 1, "onClick", "EnviaDevolucion()", "rojo", "");
                    
                    print("</td>");
                    
                $css->CierraFilaTabla();
            $css->CerrarTabla();
        break;

        
    }
          
}else{
    print("No se enviaron parametros");
}
?>