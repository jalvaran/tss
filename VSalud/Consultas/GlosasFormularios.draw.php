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
    
        case 2: //Formulario para el registro de una glosa
            
            $TipoArchivo=$obGlosas->normalizar($_REQUEST["TipoArchivo"]);
            $idActividad=$obGlosas->normalizar($_REQUEST["idActividad"]);
            
            
            $idFactura=$obGlosas->normalizar($_REQUEST["idFactura"]);
            
            $DatosFactura=$obGlosas->ValorActual("salud_archivo_facturacion_mov_generados", "valor_neto_pagar,valor_total_pago,CuentaGlobal,CuentaRIPS ", "  num_factura='$idFactura'");
            if($TipoArchivo=='AC'){
                $Tabla="salud_archivo_consultas";
                $idTabla="id_consultas";
                $sql="SELECT cod_consulta as Codigo,"
                    . "(SELECT descripcion_cups FROM salud_cups WHERE salud_cups.codigo_sistema=salud_archivo_consultas.cod_consulta) as Descripcion,"
                    . "`valor_consulta` as Total,EstadoGlosa, "
                    . "(SELECT Estado_glosa FROM salud_estado_glosas WHERE salud_estado_glosas.ID=salud_archivo_consultas.EstadoGlosa) as Estado "
                    . "FROM `salud_archivo_consultas` WHERE `$idTabla`='$idActividad'";
            }
            
            if($TipoArchivo=='AP'){
                $Tabla="salud_archivo_procedimientos";
                $idTabla="id_procedimiento";
                $sql="SELECT  cod_procedimiento  as Codigo,"
                    . "(SELECT descripcion_cups FROM salud_cups WHERE salud_cups.codigo_sistema=$Tabla.cod_procedimiento) as Descripcion,"
                    . "`valor_procedimiento` as Total,EstadoGlosa, "
                    . "(SELECT Estado_glosa FROM salud_estado_glosas WHERE salud_estado_glosas.ID=$Tabla.EstadoGlosa) as Estado "
                    . "FROM `$Tabla` WHERE `$idTabla`='$idActividad'";
            }
            
            if($TipoArchivo=='AT'){
                $Tabla="salud_archivo_otros_servicios";
                $idTabla="id_otro_servicios";
                $sql="SELECT  cod_servicio  as Codigo,"
                    . "nom_servicio as Descripcion,"
                    . "SUM(`valor_total_material`) as Total,EstadoGlosa, "
                    . "(SELECT Estado_glosa FROM salud_estado_glosas WHERE salud_estado_glosas.ID=$Tabla.EstadoGlosa) as Estado "
                    . "FROM `$Tabla` WHERE `$idTabla`='$idActividad' GROUP BY $idTabla";
            }
            
            if($TipoArchivo=='AM'){
                $Tabla="salud_archivo_medicamentos";
                $idTabla="id_medicamentos";
                $sql="SELECT  cod_medicamento  as Codigo,"
                    . "(nom_medicamento) as Descripcion,"
                    . "SUM(`valor_total_medic`) as Total,EstadoGlosa, "
                    . "(SELECT Estado_glosa FROM salud_estado_glosas WHERE salud_estado_glosas.ID=$Tabla.EstadoGlosa) as Estado "
                    . "FROM `$Tabla` WHERE `$idTabla`='$idActividad' GROUP BY $idTabla";
            }
            
            $Consulta=$obGlosas->Query($sql);
            $DatosActividad=$obGlosas->FetchArray($Consulta);
            $CodActividad=$DatosActividad["Codigo"];
            $TotalActividad=$DatosActividad["Total"];
            $TotalGlosasExistentes=$obGlosas->Sume("salud_glosas_iniciales", "ValorGlosado", " WHERE num_factura='$idFactura' AND CodigoActividad='$CodActividad'");
            $TotalGlosasExistentesTemp=$obGlosas->Sume("salud_glosas_iniciales_temp", "ValorGlosado", " WHERE num_factura='$idFactura' AND CodigoActividad='$CodActividad'");
            $TotalGlosado=$TotalGlosasExistentesTemp+$TotalGlosasExistentes;
            $TotalXGlosar=$TotalActividad-$TotalGlosado;
            $Descripcion= utf8_encode($DatosActividad["Descripcion"]);
            $css->CrearTabla();
                $css->FilaTabla(14);
                    $css->CrearInputText("idActividad", "hidden", "", $idActividad, "", "", "", "", 0, 0, 0, 0);
                    $css->CrearInputText("TotalActividad", "hidden", "", $TotalActividad, "", "", "", "", 0, 0, 0, 0);
                    $css->CrearInputText("TipoArchivo", "hidden", "", $TipoArchivo, "", "", "", "", 0, 0, 0, 0);
                    
                    $css->ColTabla("<h4 style='color:blue'><strong>Glosar la actividad $DatosActividad[Codigo] $Descripcion. </strong></h4>", 5);
                    $css->ColTabla("Total Actividad: <strong>".number_format($TotalActividad)."</strong><br>Total Glosado X Ahora: <strong>".number_format($TotalGlosado)."</strong><br>Total Disponible X Glosar: <strong>".number_format($TotalXGlosar)."</strong>",1);
                    $css->CrearInputText("ValorXGlosarMax", "text", "", $TotalXGlosar, "", "", "", "", 150, 30, 0, 0);
                $css->CierraFilaTabla();
                $css->FilaTabla(14);
                    
                    print("<td style='text-align:center'>");
                    
                        $css->CrearInputText("FechaIPS", "date", "Fecha IPS<br>", date("Y-m-d"), "Fecha IPS", "", "", "", 150, 30, 0, 1);
                        print("</td>");
                        print("<td style='text-align:center'>");
                        
                        $css->CrearInputText("FechaAuditoria", "date", "Fecha de Auditoría<br>", date("Y-m-d"), "Fecha de Auditoria", "", "", "", 150, 30, 0, 1);
                       
                    print("</td>");
                
                    print("<td style='text-align:center' colspan=3>");
                         $css->CrearDiv("DivChousen", "", "center", 1, 1);
                            $css->CrearTableChosen("CodigoGlosa", "salud_archivo_conceptos_glosas", "", "cod_glosa", "descrpcion_concep_especifico", "aplicacion", "cod_glosa", 400, 0, "Codigo Glosa", "Código de la Glosa:");
                        $css->CerrarDiv();                        
                    print("</td>");
                    print("<td style='text-align:center'>");
                        print("<strong>Soporte de Glosa:</strong><br>");
                        $css->CrearUpload("UpSoporteGlosa");
                    print("</td>");
                    $css->CierraFilaTabla();
                    $css->FilaTabla(14);
                    print("<td style='text-align:center'>");
                        
                        $css->CrearInputNumber("ValorEPS", "number", "Valor Glosado X EPS:<br>", "", "Valor EPS", "", "onChange", "ValidaValorGlosa()", 150, 30, 0, 1, 0, $TotalActividad, 1);
                        print("</td>");
                        print("<td style='text-align:center'>");
                        $css->CrearInputNumber("ValorAceptado", "number", "Valor Aceptado X IPS:<br>", 0, "Valor Aceptado EPS", "", "onChange", "ValidaValorGlosa()", 150, 30, 1, 1, 0, $TotalActividad, 1);
                        print("</td>");
                        
                        print("<td style='text-align:center' colspan=2>");
                        $css->CrearInputNumber("ValorConciliar", "number", "Valor X Conciliar<br>", "", "Valor Conciliar", "", "onChange", "CalculeValorConciliar()", 150, 30, 1, 1, 0, $TotalActividad, 1);
                        
                    print("</td>");
                
                    print("<td style='text-align:center'>");
                        $css->CrearTextArea("Observaciones", "", "", "Observaciones", "", "", "", 200, 60, 0, 1);
                    print("</td>");
                    print("<td style='text-align:center'>");
                        
                        print("<br>");
                        $css->CrearBotonEvento("BtnEnviarGlosa", "Registrar", 1, "onClick", "AccionesGlosarFacturas('$idFactura',2,'$TipoArchivo','$idActividad')", "naranja", "");
                        
                    print("</td>");
                $css->CierraFilaTabla();
                
                
            $css->CerrarTabla();
        break;
        
        case 3: //Formulario para ver la tabla temporal de glosas iniciales
            $idFactura=$obGlosas->normalizar($_REQUEST["idFactura"]);   
            $TipoArchivo=$obGlosas->normalizar($_REQUEST["TipoArchivo"]);
            $idActividad=$obGlosas->normalizar($_REQUEST["idActividad"]);
            
            $sql="SELECT ID,CodigoGlosa,ValorGlosado,ValorXConciliar,FechaIPS,num_factura,CodigoActividad,"
                    . "(SELECT descrpcion_concep_especifico FROM salud_archivo_conceptos_glosas WHERE cod_glosa=CodigoGlosa ) AS DescripcionGlosa "
                    . "FROM salud_glosas_iniciales_temp ORDER BY ID DESC";
            $Consulta=$obGlosas->Query($sql);
            $css->CrearTabla();
                $css->FilaTabla(12);
                    $css->ColTabla("<strong>Glosas Iniciales Agregadas a la Tabla Temporal</strong>", 6);
                    print("<td colspan='3' style='text-align:center'>");
                        $css->CrearBotonEvento("BtnRegistrarGlosas", "Guardar todas las Glosas Temporales", 1, "onClick", "GuadarGlosasTemporales('$idFactura')", "azulclaro", "");
                    print("</td>");
                $css->CierraFilaTabla();    
            
                $css->FilaTabla(12);
                    $css->ColTabla("<strong>Fecha IPS</strong>", 1);
                    $css->ColTabla("<strong>Numero de Factura</strong>", 1);
                    $css->ColTabla("<strong>Codigo de Actividad</strong>", 1);
                    $css->ColTabla("<strong>Codigo Glosa</strong>", 1);
                    $css->ColTabla("<strong>Descripcion Glosa</strong>", 1);
                    $css->ColTabla("<strong>Valor Glosado</strong>", 1);
                    $css->ColTabla("<strong>Valor Conciliar</strong>", 1);
                    $css->ColTabla("<strong>Editar</strong>", 1);
                    $css->ColTabla("<strong>Eliminar</strong>", 1);
                $css->CierraFilaTabla();
            while($DatosActividad=$obGlosas->FetchArray($Consulta)){
                $idGlosaTemp=$DatosActividad["ID"];
                $css->FilaTabla(12);
                    $css->ColTabla($DatosActividad["FechaIPS"], 1);
                    $css->ColTabla($DatosActividad["num_factura"], 1);
                    $css->ColTabla($DatosActividad["CodigoActividad"], 1);
                    $css->ColTabla($DatosActividad["CodigoGlosa"], 1);
                    $css->ColTabla(utf8_encode($DatosActividad["DescripcionGlosa"]), 1);
                    $css->ColTabla($DatosActividad["ValorGlosado"], 1);
                    $css->ColTabla($DatosActividad["ValorXConciliar"], 1);
                    print("<td>");
                        $css->CrearBotonEvento("EditarGlosaTemp", "Editar", 1, "onClick", "DibujeFormularioEdicionActividades('$idGlosaTemp','4')", "verde", "");
                    print("</td>");
                    print("<td>");
                        $css->CrearBotonEvento("DelGlosaTemp", "X", 1, "onClick", "EliminarGlosaTemporal('$idGlosaTemp','$idFactura','$idActividad','$TipoArchivo')", "rojo", "");
                    print("</td>");
                $css->CierraFilaTabla();
            }
              
            $css->CerrarTabla();
        break;
        
        case 4: //Formulario para la edicion de una glosa temporal
            
            $idGlosaTemp=$obGlosas->normalizar($_REQUEST["idGlosa"]);
            
            $DatosGlosaTemp=$obGlosas->DevuelveValores("salud_glosas_iniciales_temp", "ID", $idGlosaTemp);
            
            $TipoArchivo=$DatosGlosaTemp["TipoArchivo"];
            $idActividad=$DatosGlosaTemp["idArchivo"];
            
            $idFactura=$DatosGlosaTemp["num_factura"];
            $DatosFactura=$obGlosas->ValorActual("salud_archivo_facturacion_mov_generados", "valor_neto_pagar,valor_total_pago,CuentaGlobal,CuentaRIPS ", "  num_factura='$idFactura'");
            if($TipoArchivo=='AC'){
                $Tabla="salud_archivo_consultas";
                $idTabla="id_consultas";
                $sql="SELECT cod_consulta as Codigo,"
                    . "(SELECT descripcion_cups FROM salud_cups WHERE salud_cups.codigo_sistema=salud_archivo_consultas.cod_consulta) as Descripcion,"
                    . "`valor_consulta` as Total,EstadoGlosa, "
                    . "(SELECT Estado_glosa FROM salud_estado_glosas WHERE salud_estado_glosas.ID=salud_archivo_consultas.EstadoGlosa) as Estado "
                    . "FROM `salud_archivo_consultas` WHERE `$idTabla`='$idActividad'";
            }
            
            if($TipoArchivo=='AP'){
                $Tabla="salud_archivo_procedimientos";
                $idTabla="id_procedimiento";
                $sql="SELECT  cod_procedimiento  as Codigo,"
                    . "(SELECT descripcion_cups FROM salud_cups WHERE salud_cups.codigo_sistema=$Tabla.cod_procedimiento) as Descripcion,"
                    . "`valor_procedimiento` as Total,EstadoGlosa, "
                    . "(SELECT Estado_glosa FROM salud_estado_glosas WHERE salud_estado_glosas.ID=$Tabla.EstadoGlosa) as Estado "
                    . "FROM `$Tabla` WHERE `$idTabla`='$idActividad'";
            }
            
            if($TipoArchivo=='AT'){
                $Tabla="salud_archivo_otros_servicios";
                $idTabla="id_otro_servicios";
                $sql="SELECT  cod_servicio  as Codigo,"
                    . "nom_servicio as Descripcion,"
                    . "SUM(`valor_total_material`) as Total,EstadoGlosa, "
                    . "(SELECT Estado_glosa FROM salud_estado_glosas WHERE salud_estado_glosas.ID=$Tabla.EstadoGlosa) as Estado "
                    . "FROM `$Tabla` WHERE `$idTabla`='$idActividad' GROUP BY $idTabla";
            }
            
            if($TipoArchivo=='AM'){
                $Tabla="salud_archivo_medicamentos";
                $idTabla="id_medicamentos";
                $sql="SELECT  cod_medicamento  as Codigo,"
                    . "(nom_medicamento) as Descripcion,"
                    . "SUM(`valor_total_medic`) as Total,EstadoGlosa, "
                    . "(SELECT Estado_glosa FROM salud_estado_glosas WHERE salud_estado_glosas.ID=$Tabla.EstadoGlosa) as Estado "
                    . "FROM `$Tabla` WHERE `$idTabla`='$idActividad' GROUP BY $idTabla";
            }
            
            $Consulta=$obGlosas->Query($sql);
            $DatosActividad=$obGlosas->FetchArray($Consulta);
            $CodActividad=$DatosActividad["Codigo"];
            $TotalActividad=$DatosActividad["Total"];
            $TotalGlosasExistentes=$obGlosas->Sume("salud_glosas_iniciales", "ValorGlosado", " WHERE num_factura='$idFactura' AND CodigoActividad='$CodActividad'");
            $TotalGlosasExistentesTemp=$obGlosas->Sume("salud_glosas_iniciales_temp", "ValorGlosado", " WHERE num_factura='$idFactura' AND CodigoActividad='$CodActividad'");
            $TotalGlosado=$TotalGlosasExistentesTemp+$TotalGlosasExistentes-$DatosGlosaTemp["ValorGlosado"];
            
            $TotalXGlosar=$TotalActividad-$TotalGlosado;
            $Descripcion= utf8_encode($DatosActividad["Descripcion"]);
            $css->CrearTabla();
                $css->FilaTabla(14);
                    $css->CrearInputText("idGlosaEditar", "hidden", "", $idGlosaTemp, "", "", "", "", 0, 0, 0, 0);
                    $css->CrearInputText("idActividad", "hidden", "", $idActividad, "", "", "", "", 0, 0, 0, 0);
                    $css->CrearInputText("TotalActividad", "hidden", "", $TotalActividad, "", "", "", "", 0, 0, 0, 0);
                    $css->CrearInputText("TipoArchivo", "hidden", "", $TipoArchivo, "", "", "", "", 0, 0, 0, 0);
                    $css->CrearInputText("ValorXGlosarMax", "hidden", "", $TotalXGlosar, "", "", "", "", 0, 0, 0, 0);
              
                    
                    $css->ColTabla("<h4 style='color:green'><strong>Editar la Glosa de la actividad $DatosActividad[Codigo] $Descripcion.</strong></h4>", 5);
                    $css->ColTabla("Total Actividad: <strong>".number_format($TotalActividad)."</strong><br>Total Glosado X Ahora: <strong>".number_format($TotalGlosado)."</strong><br>Total Disponible X Glosar: <strong>".number_format($TotalXGlosar)."</strong>",1);
                    
                $css->CierraFilaTabla();
                $css->FilaTabla(14);
                    
                    print("<td style='text-align:center'>");
                    
                        $css->CrearInputText("FechaIPS", "date", "Fecha IPS<br>", $DatosGlosaTemp["FechaIPS"], "Fecha IPS", "", "", "", 150, 30, 0, 1);
                        print("</td>");
                        print("<td style='text-align:center'>");
                        
                        $css->CrearInputText("FechaAuditoria", "date", "Fecha de Auditoría<br>", $DatosGlosaTemp["FechaAuditoria"], "Fecha de Auditoria", "", "", "", 150, 30, 0, 1);
                       
                    print("</td>");
                
                    print("<td style='text-align:center' colspan=3>");
                         $css->CrearDiv("DivChousen", "", "center", 1, 1);
                            $css->CrearTableChosen("CodigoGlosa", "salud_archivo_conceptos_glosas", "", "cod_glosa", "descrpcion_concep_especifico", "aplicacion", "cod_glosa", 400, 0, "Codigo Glosa", "Código de la Glosa:",$DatosGlosaTemp["CodigoGlosa"]);
                        $css->CerrarDiv();                        
                    print("</td>");
                    print("<td style='text-align:center'>");
                        print("<strong>Soporte de Glosa:</strong><br>");
                        $css->CrearUpload("UpSoporteGlosa");
                    print("</td>");
                    $css->CierraFilaTabla();
                    $css->FilaTabla(14);
                    print("<td style='text-align:center'>");
                        
                        $css->CrearInputNumber("ValorEPS", "number", "Valor Glosado X EPS:<br>", $DatosGlosaTemp["ValorGlosado"], "Valor EPS", "", "onChange", "ValidaValorGlosa()", 150, 30, 0, 1, 0, $TotalActividad, 1);
                        print("</td>");
                        print("<td style='text-align:center'>");
                        $css->CrearInputNumber("ValorAceptado", "number", "Valor Aceptado X IPS:<br>", 0, "Valor Aceptado EPS", "", "onChange", "", 150, 30, 1, 1, 0, $TotalActividad, 1);
                        print("</td>");
                        
                        print("<td style='text-align:center' colspan=2>");
                        $css->CrearInputNumber("ValorConciliar", "number", "Valor X Conciliar<br>", $DatosGlosaTemp["ValorGlosado"], "Valor Conciliar", "", "", "", 150, 30, 1, 1, 0, $TotalActividad, 1);
                        
                    print("</td>");
                
                    print("<td style='text-align:center'>");
                        $css->CrearTextArea("Observaciones", "", $DatosGlosaTemp["Observaciones"], "Observaciones", "", "", "", 200, 60, 0, 1);
                    print("</td>");
                    print("<td style='text-align:center'>");
                        
                        print("<br>");
                        $css->CrearBotonEvento("BtnEditarGlosa", "Editar esta Glosa", 1, "onClick", "EditarGlosaTemporal('$idGlosaTemp',4,'$TipoArchivo','$idActividad','$idFactura')", "verde", "");
                        
                    print("</td>");
                $css->CierraFilaTabla();
                
                
            $css->CerrarTabla();
        break;
        
    }
          
}else{
    print("No se enviaron parametros");
}
?>