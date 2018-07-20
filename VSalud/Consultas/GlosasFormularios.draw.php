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
            $DatosFactura=$obGlosas->ValorActual("salud_archivo_facturacion_mov_generados", "valor_total_pago,valor_neto_pagar ", "  num_factura='$idFactura'");
            $TotalFactura=$DatosFactura["valor_total_pago"]+$DatosFactura["valor_neto_pagar"];
            $css->CrearInputText("ValorFacturaDevolucion", "hidden", "", $DatosFactura["valor_neto_pagar"], "", "", "", "", 0, 0, 1, 0);
            $css->CrearTabla();
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>Realizar la devolución de la Factura $idFactura</strong><br>Total Aseguradora: $".number_format($DatosFactura["valor_neto_pagar"])."<br>Total Usuario: $".number_format($DatosFactura["valor_total_pago"])."<br>Total de la Factura: $".number_format($TotalFactura), 1);
                $css->CierraFilaTabla();
                $css->FilaTabla(16);
                    
                    print("<td style='text-align:center'>");
                    
                        $css->CrearInputText("FechaDevolucion", "date", "Fecha de Devolución<br>", date("Y-m-d"), "Fecha de Devolucion", "", "", "", 150, 30, 0, 1);
                        print("</br>");
                        $css->CrearInputText("FechaAuditoria", "date", "Fecha de Auditoría<br>", date("Y-m-d"), "Fecha de Auditoria", "", "", "", 150, 30, 0, 1);
                       
                    print("</td>");
                $css->CierraFilaTabla();
                $css->FilaTabla(16);
                    print("<td style='text-align:center'>");
                    //$css->CrearSelectTable("CodigoGlosa", "salud_archivo_conceptos_glosas", "", "cod_glosa", "descrpcion_concep_especifico", "aplicacion", "", "", "cod_glosa", 0);
                        $css->CrearDiv("DivChousen", "", "center", 1, 1);
                            $css->CrearTableChosen("CodigoGlosa", "salud_archivo_conceptos_glosas", "", "cod_glosa", "descrpcion_concep_especifico", "aplicacion", "cod_glosa", 400, 0, "Codigo Glosa", "");
                        $css->CerrarDiv();
                        
                    print("</td>");
                $css->CierraFilaTabla();
                $css->FilaTabla(16);
                   
                    print("<td style='text-align:center'>");
                        $css->CrearTextArea("Observaciones", "", "", "Observaciones", "", "", "", 400, 60, 0, 1);
                    print("</td>");
                $css->CierraFilaTabla();
                
                $css->FilaTabla(16);
                    print("<td style='text-align:center'>");
                        print("<strong>Soporte de devolución:</strong><br>");
                        $css->CrearUpload("UpSoporteDevolucion");
                        print("<br>");
                        $css->CrearBotonEvento("BtnEnviarDevolucion", "Enviar", 1, "onClick", "DevolverFactura('$idFactura')", "rojo", "");
                        
                    print("</td>");
                    
                $css->CierraFilaTabla();
            $css->CerrarTabla();
        break;

        
    }
          
}else{
    print("No se enviaron parametros");
}
?>