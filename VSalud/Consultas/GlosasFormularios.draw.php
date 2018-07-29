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
            $TotalGlosasExistentes=$obGlosas->Sume("salud_glosas_iniciales", "ValorGlosado", " WHERE num_factura='$idFactura' AND CodigoActividad='$CodActividad' AND EstadoGlosa<>12");
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
                    $css->CrearInputText("ValorXGlosarMax", "hidden", "", $TotalXGlosar, "", "", "", "", 150, 30, 0, 0);
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
        
        case 5: //Formulario para ver la tabla de control de glosas
            $idFactura=$obGlosas->normalizar($_REQUEST["idFactura"]);             
            $CodActividad=$obGlosas->normalizar($_REQUEST["CodActividad"]);
            $sql="SELECT TipoArchivo,ID,num_factura,FechaIPS,id_cod_glosa AS CodigoGlosa,CodigoActividad,observacion_auditor,idGlosa,"
                    . "(SELECT descrpcion_concep_especifico FROM salud_archivo_conceptos_glosas WHERE cod_glosa=id_cod_glosa ) AS DescripcionGlosa,"
                    . "valor_glosado_eps,valor_levantado_eps,valor_aceptado_ips,EstadoGlosa,"
                    . "(SELECT valor_glosado_eps-valor_aceptado_ips-valor_levantado_eps) AS ValorXConciliar,"
                    . "(SELECT Estado_glosa FROM salud_estado_glosas WHERE salud_estado_glosas.ID=EstadoGlosa) as Estado "
                    . "FROM salud_archivo_control_glosas_respuestas "
                    . "WHERE "
                    . "  num_factura='$idFactura' AND CodigoActividad='$CodActividad' AND EstadoGlosa<5 AND Tratado=0 ORDER BY ID LIMIT 100";
            
            
            $Consulta=$obGlosas->Query($sql);
            $css->CrearTabla();
                $css->FilaTabla(12);
                    $css->ColTabla("<h4 style='color:blue'><strong>Glosas realizadas a la Actividad: $CodActividad de la factura: $idFactura</strong></h4>", 6);
                $css->CierraFilaTabla();    
            
                $css->FilaTabla(12);
                    $css->ColTabla("<strong>Fecha IPS</strong>", 1);
                    $css->ColTabla("<strong>Numero de Factura</strong>", 1);
                    $css->ColTabla("<strong>Codigo de Actividad</strong>", 1);
                    $css->ColTabla("<strong>Codigo Glosa</strong>", 1);
                    $css->ColTabla("<strong>Descripcion Glosa</strong>", 1);
                    $css->ColTabla("<strong>Observaciones</strong>", 1);
                    $css->ColTabla("<strong>Valor Glosado</strong>", 1);
                    $css->ColTabla("<strong>Valor Levantado</strong>", 1);
                    $css->ColTabla("<strong>Valor Aceptado</strong>", 1);
                    $css->ColTabla("<strong>Valor X Conciliar</strong>", 1);
                    $css->ColTabla("<strong>Estado</strong>", 1);
                    $css->ColTabla("<strong>Acción</strong>", 1);
                    
                $css->CierraFilaTabla();
            while($DatosActividad=$obGlosas->FetchArray($Consulta)){
                $idGlosa=$DatosActividad["ID"];
                $idGlosaInicial=$DatosActividad["idGlosa"];
                $TipoArchivo=$DatosActividad["TipoArchivo"];
                $idFactura=$DatosActividad["num_factura"];
                $CodActividad=$DatosActividad["CodigoActividad"];
                $EstadoGlosa=$DatosActividad["EstadoGlosa"];
                $Descripcion=$DatosActividad["DescripcionGlosa"];
                $css->FilaTabla(12);
                    $css->ColTabla($DatosActividad["FechaIPS"], 1);
                    $css->ColTabla($DatosActividad["num_factura"], 1);
                    $css->ColTabla($DatosActividad["CodigoActividad"], 1);
                    $css->ColTabla($DatosActividad["CodigoGlosa"], 1);
                    $css->ColTabla(utf8_encode($DatosActividad["DescripcionGlosa"]), 1);
                    $css->ColTabla($DatosActividad["observacion_auditor"], 1);
                    $css->ColTabla($DatosActividad["valor_glosado_eps"], 1);
                    $css->ColTabla($DatosActividad["valor_levantado_eps"], 1);
                    $css->ColTabla($DatosActividad["valor_aceptado_ips"], 1);
                    $css->ColTabla($DatosActividad["ValorXConciliar"], 1);
                    $css->ColTabla($DatosActividad["Estado"], 1);
                    print("<td>");
                        if($DatosActividad["EstadoGlosa"]==1){
                           $css->CrearBotonEvento("RespondeGlosa", "Responder Glosa", 1, "onClick", "RespuestaGlosa('$idGlosa')", "verde", "");
          
                        }
                        if($DatosActividad["EstadoGlosa"]==2){
                            $css->CrearBotonEvento("ContraGlosa", "Contra Glosa", 1, "onClick", "RespuestaGlosa('$idGlosa','9')", "naranja", "");
          
                        }
                        if($DatosActividad["EstadoGlosa"]==3){
                            $css->CrearBotonEvento("BtnContraGlosa", "Respuesta Contra Glosa", 1, "onClick", "RespuestaGlosa('$idGlosa','10')", "verde", "");
          
                        }
                        if($DatosActividad["EstadoGlosa"]==4){
                            $css->CrearBotonEvento("BtnGlosaXConciliar", "Conciliar", 1, "onClick", "RespuestaGlosa('$idGlosa','11')", "naranja", "");
          
                        }
                        print("<br><br>");
                        $jsEditar="MuestraEditarGlosaInicial('$idGlosaInicial')";
                        $jsAnular="AnularGlosa('$idGlosaInicial','$idFactura','$CodActividad','$TipoArchivo')";
                        if($DatosActividad["EstadoGlosa"]==2){
                            $jsEditar="MuestraEditarGlosaRespondida('$idGlosa',13)";
                            $jsAnular="AnularRespuestaGlosa('$idGlosa','$idFactura','$CodActividad','$TipoArchivo')";
                       
                        }
                        if($DatosActividad["EstadoGlosa"]==3 or $DatosActividad["EstadoGlosa"]==4){
                            $jsEditar="MuestraEditarGlosaRespondida('$idGlosa',14)";
                            $jsAnular="AnularRespuestaGlosa('$idGlosa','$idFactura','$CodActividad','$TipoArchivo')";
                       
                        }
                        $css->CrearBotonEvento("BtnEditar", "Editar ".$DatosActividad["Estado"], 1, "onClick", $jsEditar, "verde", "");
                        print("<br><br>");
                        $css->CrearBotonEvento("BtnAnular", "Anular ".$DatosActividad["Estado"], 1, "onClick", $jsAnular, "rojo", "");
          
                        print("</td>");
                    
                $css->CierraFilaTabla();
            }
              
            $css->CerrarTabla();
        break;
        case 6: //Formulario para responder a una glosa
            $idGlosa=$obGlosas->normalizar($_REQUEST["idGlosa"]);
            
            $DatosGlosa=$obGlosas->DevuelveValores("salud_archivo_control_glosas_respuestas", "ID", $idGlosa);
            
            $TipoArchivo=$DatosGlosa["TipoArchivo"];
            $CodActividad=$DatosGlosa["CodigoActividad"];            
            $idFactura=$DatosGlosa["num_factura"];
            //$DatosFactura=$obGlosas->ValorActual("salud_archivo_facturacion_mov_generados", "valor_neto_pagar,valor_total_pago,CuentaGlobal,CuentaRIPS ", "num_factura='$idFactura'");
            
            $TotalActividad=$DatosGlosa["valor_actividad"];            
            $TotalGlosado=$DatosGlosa["valor_glosado_eps"];
            
            $Descripcion= utf8_encode($DatosGlosa["DescripcionActividad"]);
            
            $css->CrearTabla();
                $css->FilaTabla(14);
                    $css->CrearInputText("idGlosa", "hidden", "", $idGlosa, "", "", "", "", 0, 0, 0, 0);
                    $css->CrearInputText("TotalGlosado", "hidden", "", $TotalGlosado, "", "", "", "", 0, 0, 0, 0);
                    $css->ColTabla("<h4 style='color:green'><strong>Responder Glosa de la actividad $CodActividad $Descripcion.</strong></h4>", 5);
                    //$css->ColTabla("Total Glosado: <strong>".number_format($TotalGlosado)."</strong><br>Valor X Conciliar: <strong>".number_format($TotalXGlosar)."</strong>",1);
                    
                $css->CierraFilaTabla();
                $css->FilaTabla(14);
                    
                    print("<td style='text-align:center'>");
                    
                        $css->CrearInputText("FechaIPS", "date", "Fecha IPS<br>", date("Y-m-d"), "Fecha IPS", "", "", "", 150, 30, 1, 1);
                        print("</td>");
                        print("<td style='text-align:center'>");
                        
                        $css->CrearInputText("FechaAuditoria", "date", "Fecha de Auditoría<br>", date("Y-m-d"), "Fecha de Auditoria", "", "", "", 150, 30, 1, 1);
                       
                    print("</td>");
                
                    print("<td style='text-align:center' colspan=3>");
                         $css->CrearDiv("DivChousen", "", "center", 1, 1);
                            $css->CrearTableChosen("CodigoGlosa", "salud_archivo_conceptos_glosas", "", "cod_glosa", "descrpcion_concep_especifico", "aplicacion", "cod_glosa", 400, 0, "Codigo Glosa", "Código de la Respuesta:");
                        $css->CerrarDiv();                        
                    print("</td>");
                    print("<td style='text-align:center'>");
                        print("<strong>Soporte de la Respuesta:</strong><br>");
                        $css->CrearUpload("UpSoporteGlosa");
                    print("</td>");
                    $css->CierraFilaTabla();
                    $css->FilaTabla(14);
                    print("<td style='text-align:center'>");
                        
                        $css->CrearInputNumber("ValorEPS", "number", "Valor Glosado X EPS:<br>", $DatosGlosa["valor_glosado_eps"], "Valor EPS", "", "", "", 150, 30, 1, 1, 0, "", 1);
                        $css->CrearInputNumber("ValorLevantado", "hidden", "", $DatosGlosa["valor_levantado_eps"], "Valor EPS", "", "", "", 150, 30, 1, 1, 0, "", 1);
                       
                        print("</td>");
                        print("<td style='text-align:center'>");
                        $css->CrearInputNumber("ValorAceptado", "number", "Valor Aceptado X IPS:<br>", 0, "Valor Aceptado EPS", "", "onChange", "ValidaValorXConciliar()", 150, 30, 0, 1, 0, $DatosGlosa["valor_glosado_eps"], 1);
                        print("</td>");
                        
                        print("<td style='text-align:center' colspan=2>");
                        $css->CrearInputNumber("ValorConciliar", "number", "Valor X Conciliar<br>", $DatosGlosa["valor_glosado_eps"], "Valor Conciliar", "", "", "", 150, 30, 1, 1, 0, $DatosGlosa["valor_glosado_eps"], 1);
                        
                    print("</td>");
                
                    print("<td style='text-align:center'>");
                        $css->CrearTextArea("Observaciones", "", "", "Observaciones", "", "", "", 200, 60, 0, 1);
                    print("</td>");
                    print("<td style='text-align:center'>");
                        
                        print("<br>");
                        $css->CrearBotonEvento("BtnResponderGlosa", "Responder esta Glosa", 1, "onClick", "AgregarRespuestaGlosaTemporal('$idGlosa')", "verde", "");
                        
                    print("</td>");
                $css->CierraFilaTabla();
                
                
            $css->CerrarTabla();
        break;  
    
        case 7: //Respuestas agregadas a la tabla temporal
                        
            $idGlosa=$obGlosas->normalizar($_REQUEST["idGlosa"]);
            $Condicion="";
            if($idGlosa<>""){
                $Condicion=" WHERE idGlosa='$idGlosa'";
            }
            
            
            $css->CrearTabla();
                $css->FilaTabla(12);
                    $css->ColTabla("<strong>Respuestas a Glosas Agregadas a la Tabla Temporal</strong>", 6);
                    print("<td colspan='3' style='text-align:center'>");
                        $css->CrearBotonEvento("BtnRegistrarRepuestasGlosas", "Guardar todas las Respuestas Temporales", 1, "onClick", "GuadarRespuestasTemporales('$idGlosa')", "azulclaro", "");
                    print("</td>");
                $css->CierraFilaTabla();    
            
                $css->FilaTabla(12);
                    $css->ColTabla("<strong>Fecha</strong>", 1);
                    $css->ColTabla("<strong>Numero de Factura</strong>", 1);
                    $css->ColTabla("<strong>Codigo de Actividad</strong>", 1);
                    $css->ColTabla("<strong>Codigo Glosa</strong>", 1);
                    $css->ColTabla("<strong>Descripcion Glosa</strong>", 1);
                    $css->ColTabla("<strong>Valor Glosado</strong>", 1);
                    $css->ColTabla("<strong>Valor Levantada</strong>", 1);
                    $css->ColTabla("<strong>Valor Aceptado</strong>", 1);
                    
                    $css->ColTabla("<strong>Valor X Conciliar</strong>", 1);
                    $css->ColTabla("<strong>Estado</strong>", 1);
                    $css->ColTabla("<strong>Editar</strong>", 1);
                    $css->ColTabla("<strong>Eliminar</strong>", 1);
                $css->CierraFilaTabla();
                $idFactura="";
                $idActividad='';
            //$Consulta=$obGlosas->ConsultarTabla("salud_archivo_control_glosas_respuestas_temp", $Condicion);
            $sql="SELECT *, (SELECT descrpcion_concep_especifico FROM salud_archivo_conceptos_glosas WHERE cod_glosa=id_cod_glosa ) AS DescripcionGlosa "
                    . "FROM salud_archivo_control_glosas_respuestas_temp $Condicion";
            $Consulta=$obGlosas->Query($sql);
            while($DatosActividad=$obGlosas->FetchArray($Consulta)){
                $idGlosaTemp=$DatosActividad["ID"];
                
                $css->FilaTabla(12);
                    $idFactura=$DatosActividad["num_factura"];
                    $idActividad=$DatosActividad["CodigoActividad"];
                    $css->ColTabla($DatosActividad["FechaIPS"], 1);
                    $css->ColTabla($DatosActividad["num_factura"], 1);
                    $css->ColTabla($DatosActividad["CodigoActividad"], 1);
                    $css->ColTabla($DatosActividad["id_cod_glosa"], 1);
                    $css->ColTabla(utf8_encode($DatosActividad["DescripcionGlosa"]), 1);
                    $css->ColTabla(number_format($DatosActividad["valor_glosado_eps"]), 1);
                    $css->ColTabla(number_format($DatosActividad["valor_levantado_eps"]), 1);
                    $css->ColTabla(number_format($DatosActividad["valor_aceptado_ips"]), 1);
                    $css->ColTabla(number_format($DatosActividad["valor_glosado_eps"]-$DatosActividad["valor_aceptado_ips"]-$DatosActividad["valor_levantado_eps"]), 1);
                    $css->ColTabla(number_format($DatosActividad["EstadoGlosa"]), 1);
                    print("<td>");
                        $css->CrearBotonEvento("EditarGlosaTemp", "Editar", 1, "onClick", "DibujeFormularioEdicionRespuestas('$idGlosaTemp','8')", "verde", "");
                    print("</td>");
                    print("<td>");
                        $css->CrearBotonEvento("DelGlosaTemp", "X", 1, "onClick", "EliminarRepuestaGlosaTemporal('$idGlosaTemp','7')", "rojo", "");
                    print("</td>");
                $css->CierraFilaTabla();
            }
                           
            $css->CerrarTabla();
            $css->CrearInputText("TxtNumFactura", "hidden", "", $idFactura, "", "", "", "", 100, 30, 0, 0);
            $css->CrearInputText("TxtCodActividad", "hidden", "", $idActividad, "", "", "", "", 100, 30, 0, 0);
             
        break;
        case 8: //Edicion de una respuesta a una glosa
            $idGlosa=$obGlosas->normalizar($_REQUEST["idGlosa"]);
            
            $DatosGlosa=$obGlosas->DevuelveValores("salud_archivo_control_glosas_respuestas_temp", "ID", $idGlosa);
            $Estado=$DatosGlosa["EstadoGlosa"];
            $TipoArchivo=$DatosGlosa["TipoArchivo"];
            $CodActividad=$DatosGlosa["CodigoActividad"];            
            $idFactura=$DatosGlosa["num_factura"];
            //$DatosFactura=$obGlosas->ValorActual("salud_archivo_facturacion_mov_generados", "valor_neto_pagar,valor_total_pago,CuentaGlobal,CuentaRIPS ", "num_factura='$idFactura'");
            
            $TotalActividad=$DatosGlosa["valor_actividad"];            
            $TotalGlosado=$DatosGlosa["valor_glosado_eps"];
            
            $Descripcion= utf8_encode($DatosGlosa["DescripcionActividad"]);
            $css->CrearTabla();
                $css->FilaTabla(14);
                    $css->CrearInputText("idGlosa", "hidden", "", $idGlosa, "", "", "", "", 0, 0, 0, 0);
                    $css->CrearInputText("TotalGlosado", "hidden", "", $TotalGlosado, "", "", "", "", 0, 0, 0, 0);
                    $css->ColTabla("<h4 style='color:orange'><strong>Editar respuesta a Glosa de la actividad $CodActividad $Descripcion.</strong></h4>", 5);
                    //$css->ColTabla("Total Glosado: <strong>".number_format($TotalGlosado)."</strong><br>Valor X Conciliar: <strong>".number_format($TotalXGlosar)."</strong>",1);
                    
                $css->CierraFilaTabla();
                $css->FilaTabla(14);
                    $ColSpan=1;
                    if($Estado==5){
                        $ColSpan=2;
                    }
                    print("<td style='text-align:center' colspan=$ColSpan>");
                            $ReadOnly=1;
                        if($Estado==3){
                            $ReadOnly=0;
                        }
                        if($Estado==5){
                            $css->CrearInputText("FechaIPS", "date", "Fecha Conciliación<br>", $DatosGlosa["FechaIPS"], "Fecha IPS", "", "", "", 150, 30, 0, 1);
                            $TipoCajaFecha="hidden";
                            $TituloCajaFecha="";
                        }else{
                            $css->CrearInputText("FechaIPS", "date", "Fecha IPS<br>", $DatosGlosa["FechaIPS"], "Fecha IPS", "", "", "", 150, 30, $ReadOnly, 1);
                            $TipoCajaFecha="date";
                            $TituloCajaFecha="Fecha de Auditoría<br>";
                        }
                        print("</td>");
                        if($Estado<>5){
                            print("<td style='text-align:center'>");
                        }
                        $css->CrearInputText("FechaAuditoria", $TipoCajaFecha, $TituloCajaFecha, $DatosGlosa["FechaAuditoria"], "Fecha de Auditoria", "", "", "", 150, 30, $ReadOnly, 1);
                     if($Estado<>5){  
                        print("</td>");
                    }
                    print("<td style='text-align:center' colspan=3>");
                         $css->CrearDiv("DivChousen", "", "center", 1, 1);
                            $css->CrearTableChosen("CodigoGlosa", "salud_archivo_conceptos_glosas", "", "cod_glosa", "descrpcion_concep_especifico", "aplicacion", "cod_glosa", 400, 0, "Codigo Glosa", "Código:",$DatosGlosa["id_cod_glosa"]);
                        $css->CerrarDiv();                        
                    print("</td>");
                    print("<td style='text-align:center'>");
                        print("<strong>Soporte:</strong><br>");
                        $css->CrearUpload("UpSoporteGlosa");
                    print("</td>");
                    $css->CierraFilaTabla();
                    $css->FilaTabla(14);
                    print("<td style='text-align:center'>");
                        
                        $css->CrearInputNumber("ValorEPS", "number", "Valor Glosado X EPS:<br>", $DatosGlosa["valor_glosado_eps"], "Valor EPS", "", "", "", 150, 30, 1, 1, 0, "", 1);
                        $js="ValidaValorLevantado()";
                        if($Estado==3 or $Estado==4 or $Estado==5){
                            
                            $ReadOnly=0;
                            if($Estado==4){
                                $ReadOnly=1;
                            }
                            if($Estado==5){
                                $js="ValidaValoresConciliacion()";
                            }
                            $css->CrearInputNumber("ValorLevantado", "number", "<br>Valor Levantado X EPS:<br>", $DatosGlosa["valor_levantado_eps"], "Valor Levantado x EPS", "", "onChange", $js, 150, 30, $ReadOnly, 1, 0, "", 1);
                        }
                        print("</td>");
                        print("<td style='text-align:center'>");
                        $ReadOnly=0;
                        if($Estado==3){
                            $ReadOnly=1;
                        }
                        $css->CrearInputNumber("ValorAceptado", "number", "Valor Aceptado X IPS:<br>", $DatosGlosa["valor_aceptado_ips"], "Valor Aceptado EPS", "", "onChange", $js, 150, 30, $ReadOnly, 1, 0, $DatosGlosa["valor_glosado_eps"], 1);
                        print("</td>");
                        
                        print("<td style='text-align:center' colspan=2>");
                        $css->CrearInputNumber("ValorConciliar", "number", "Valor X Conciliar<br>", $DatosGlosa["valor_glosado_eps"]-$DatosGlosa["valor_aceptado_ips"]-$DatosGlosa["valor_levantado_eps"], "Valor Conciliar", "", "", "", 150, 30, 1, 1, 0, $DatosGlosa["valor_glosado_eps"], 1);
                        
                    print("</td>");
                
                    print("<td style='text-align:center'>");
                        $css->CrearTextArea("Observaciones", "", $DatosGlosa["observacion_auditor"], "Observaciones", "", "", "", 200, 60, 0, 1);
                    print("</td>");
                    print("<td style='text-align:center'>");
                        
                        print("<br>");
                        $css->CrearBotonEvento("BtnResponderGlosa", "Editar esta Respuesta", 1, "onClick", "EditarRespuestaGlosaTemporal('$idGlosa')", "naranja", "");
                        print("<h4 style='color:orange'>Modo Edicion</h4>");
                    print("</td>");
                $css->CierraFilaTabla();
                
                
            $css->CerrarTabla();
        break;
    
        case 9: //Formulario para Contra Glosar
            $idGlosa=$obGlosas->normalizar($_REQUEST["idGlosa"]);
            
            $DatosGlosa=$obGlosas->DevuelveValores("salud_archivo_control_glosas_respuestas", "ID", $idGlosa);
            
            $TipoArchivo=$DatosGlosa["TipoArchivo"];
            $CodActividad=$DatosGlosa["CodigoActividad"];            
            $idFactura=$DatosGlosa["num_factura"];
            //$DatosFactura=$obGlosas->ValorActual("salud_archivo_facturacion_mov_generados", "valor_neto_pagar,valor_total_pago,CuentaGlobal,CuentaRIPS ", "num_factura='$idFactura'");
            
            $TotalActividad=$DatosGlosa["valor_actividad"];            
            $TotalGlosado=$DatosGlosa["valor_glosado_eps"];
            
            $Descripcion= utf8_encode($DatosGlosa["DescripcionActividad"]);
            $css->CrearTabla();
                $css->FilaTabla(14);
                    $css->CrearInputText("idGlosa", "hidden", "", $idGlosa, "", "", "", "", 0, 0, 0, 0);
                    $css->CrearInputText("TotalGlosado", "hidden", "", $TotalGlosado, "", "", "", "", 0, 0, 0, 0);
                    $css->ColTabla("<h4 style='color:orange'><strong>Contra Glosa de la actividad $CodActividad $Descripcion.</strong></h4>", 5);
                    //$css->ColTabla("Total Glosado: <strong>".number_format($TotalGlosado)."</strong><br>Valor X Conciliar: <strong>".number_format($TotalXGlosar)."</strong>",1);
                    
                $css->CierraFilaTabla();
                $css->FilaTabla(14);
                    
                    print("<td style='text-align:center'>");
                    
                        $css->CrearInputText("FechaIPS", "date", "Fecha IPS<br>", date("Y-m-d"), "Fecha IPS", "", "onChange", "ValidarFecha(`FechaIPS`)", 150, 30, 0, 1);
                        print("</td>");
                        print("<td style='text-align:center'>");
                        
                        $css->CrearInputText("FechaAuditoria", "date", "Fecha de Auditoría<br>", date("Y-m-d"), "Fecha de Auditoria", "", "", "", 150, 30, 0, 1);
                       
                    print("</td>");
                
                    print("<td style='text-align:center' colspan=3>");
                         $css->CrearDiv("DivChousen", "", "center", 1, 1);
                            $css->CrearTableChosen("CodigoGlosa", "salud_archivo_conceptos_glosas", "", "cod_glosa", "descrpcion_concep_especifico", "aplicacion", "cod_glosa", 400, 0, "Codigo Glosa", "Código de la Contra Glosa:");
                        $css->CerrarDiv();                        
                    print("</td>");
                    print("<td style='text-align:center'>");
                        print("<strong>Soporte de la Contra Glosa:</strong><br>");
                        $css->CrearUpload("UpSoporteGlosa");
                    print("</td>");
                    $css->CierraFilaTabla();
                    $css->FilaTabla(14);
                    print("<td style='text-align:center'>");
                        
                        $css->CrearInputNumber("ValorEPS", "number", "Valor Glosado X EPS:<br>", $DatosGlosa["valor_glosado_eps"], "Valor EPS", "", "", "", 150, 30, 1, 1, 0, "", 1);
                        $css->CrearInputNumber("ValorLevantado", "number", "<br>Valor Levantado X EPS:<br>", 0, "Valor Levantado EPS", "", "onChange", "ValidaValorLevantado()", 150, 30, 0, 1, 0, $DatosGlosa["valor_glosado_eps"], 1);
                       
                        print("</td>");
                        print("<td style='text-align:center'>");
                        $css->CrearInputNumber("ValorAceptado", "number", "Valor Aceptado X IPS:<br>", $DatosGlosa["valor_aceptado_ips"], "Valor Aceptado EPS", "", "", "", 150, 30, 1, 1, 0, $DatosGlosa["valor_glosado_eps"], 1);
                        
                        print("</td>");
                        
                        print("<td style='text-align:center' colspan=2>");
                        $css->CrearInputNumber("ValorConciliar", "number", "Valor X Conciliar<br>", $DatosGlosa["valor_glosado_eps"]-$DatosGlosa["valor_aceptado_ips"], "Valor Conciliar", "", "", "", 150, 30, 1, 1, 0, $DatosGlosa["valor_glosado_eps"], 1);
                        
                    print("</td>");
                
                    print("<td style='text-align:center'>");
                        $css->CrearTextArea("Observaciones", "", "", "Observaciones", "", "", "", 200, 60, 0, 1);
                    print("</td>");
                    print("<td style='text-align:center'>");
                        
                        print("<br>");
                        $css->CrearBotonEvento("BtnContraGlosar", "Contra Glosar", 1, "onClick", "AgregarRespuestaGlosaTemporal('$idGlosa','10')", "naranja", "");
                        
                    print("</td>");
                $css->CierraFilaTabla();
                
                
            $css->CerrarTabla();
        break;
    
        case 10: //Formulario para responder a una contra glosa
            $idGlosa=$obGlosas->normalizar($_REQUEST["idGlosa"]);
            
            $DatosGlosa=$obGlosas->DevuelveValores("salud_archivo_control_glosas_respuestas", "ID", $idGlosa);
            
            $TipoArchivo=$DatosGlosa["TipoArchivo"];
            $CodActividad=$DatosGlosa["CodigoActividad"];            
            $idFactura=$DatosGlosa["num_factura"];
            //$DatosFactura=$obGlosas->ValorActual("salud_archivo_facturacion_mov_generados", "valor_neto_pagar,valor_total_pago,CuentaGlobal,CuentaRIPS ", "num_factura='$idFactura'");
            
            $TotalActividad=$DatosGlosa["valor_actividad"];            
            $TotalGlosado=$DatosGlosa["valor_glosado_eps"];
            
            $Descripcion= utf8_encode($DatosGlosa["DescripcionActividad"]);
            $css->CrearTabla();
                $css->FilaTabla(14);
                    $css->CrearInputText("idGlosa", "hidden", "", $idGlosa, "", "", "", "", 0, 0, 0, 0);
                    $css->CrearInputText("TotalGlosado", "hidden", "", $TotalGlosado, "", "", "", "", 0, 0, 0, 0);
                    $css->ColTabla("<h4 style='color:green'><strong>Responder a contra Glosa de la actividad $CodActividad $Descripcion.</strong></h4>", 5);
                    //$css->ColTabla("Total Glosado: <strong>".number_format($TotalGlosado)."</strong><br>Valor X Conciliar: <strong>".number_format($TotalXGlosar)."</strong>",1);
                    
                $css->CierraFilaTabla();
                $css->FilaTabla(14);
                    
                    print("<td style='text-align:center'>");
                    
                        $css->CrearInputText("FechaIPS", "date", "Fecha IPS<br>", date("Y-m-d"), "Fecha IPS", "", "", "", 150, 30, 1, 1);
                        print("</td>");
                        print("<td style='text-align:center'>");
                        
                        $css->CrearInputText("FechaAuditoria", "date", "Fecha de Auditoría<br>", date("Y-m-d"), "Fecha de Auditoria", "", "", "", 150, 30, 1, 1);
                       
                    print("</td>");
                
                    print("<td style='text-align:center' colspan=3>");
                         $css->CrearDiv("DivChousen", "", "center", 1, 1);
                            $css->CrearTableChosen("CodigoGlosa", "salud_archivo_conceptos_glosas", "", "cod_glosa", "descrpcion_concep_especifico", "aplicacion", "cod_glosa", 400, 0, "Codigo Glosa", "Código de la Respuesta:");
                        $css->CerrarDiv();                        
                    print("</td>");
                    print("<td style='text-align:center'>");
                        print("<strong>Soporte de la Respuesta:</strong><br>");
                        $css->CrearUpload("UpSoporteGlosa");
                    print("</td>");
                    $css->CierraFilaTabla();
                    $css->FilaTabla(14);
                    print("<td style='text-align:center'>");
                        
                        $css->CrearInputNumber("ValorEPS", "number", "Valor Glosado X EPS:<br>", $DatosGlosa["valor_glosado_eps"], "Valor EPS", "", "", "", 150, 30, 1, 1, 0, "", 1);
                        $css->CrearInputNumber("ValorLevantado", "number", "<br>Valor Levantado X EPS:<br>", $DatosGlosa["valor_levantado_eps"], "Valor EPS", "", "", "", 150, 30, 1, 1, 0, "", 1);
                       
                        print("</td>");
                        print("<td style='text-align:center'>");
                        $css->CrearInputNumber("ValorAceptado", "number", "Valor Aceptado X IPS:<br>",$DatosGlosa["valor_aceptado_ips"], "Valor Aceptado EPS", "", "onChange", "ValidaValorLevantado()", 150, 30, 0, 1, 0, $DatosGlosa["valor_glosado_eps"], 1);
                        print("</td>");
                        
                        print("<td style='text-align:center' colspan=2>");
                        $css->CrearInputNumber("ValorConciliar", "number", "Valor X Conciliar<br>", $DatosGlosa["valor_glosado_eps"]-$DatosGlosa["valor_levantado_eps"]-$DatosGlosa["valor_aceptado_ips"], "Valor Conciliar", "", "", "", 150, 30, 1, 1, 0, $DatosGlosa["valor_glosado_eps"], 1);
                        
                    print("</td>");
                
                    print("<td style='text-align:center'>");
                        $css->CrearTextArea("Observaciones", "", "", "Observaciones", "", "", "", 200, 60, 0, 1);
                    print("</td>");
                    print("<td style='text-align:center'>");
                        
                        print("<br>");
                        $css->CrearBotonEvento("BtnResponderGlosa", "Responder esta Contra Glosa", 1, "onClick", "AgregarRespuestaGlosaTemporal('$idGlosa','11')", "verde", "");
                        
                    print("</td>");
                $css->CierraFilaTabla();
                
                
            $css->CerrarTabla();
        break;  
        case 11: //Formulario para Conciliar
            $idGlosa=$obGlosas->normalizar($_REQUEST["idGlosa"]);
            
            $DatosGlosa=$obGlosas->DevuelveValores("salud_archivo_control_glosas_respuestas", "ID", $idGlosa);
            
            $TipoArchivo=$DatosGlosa["TipoArchivo"];
            $CodActividad=$DatosGlosa["CodigoActividad"];            
            $idFactura=$DatosGlosa["num_factura"];
            //$DatosFactura=$obGlosas->ValorActual("salud_archivo_facturacion_mov_generados", "valor_neto_pagar,valor_total_pago,CuentaGlobal,CuentaRIPS ", "num_factura='$idFactura'");
            
            $TotalActividad=$DatosGlosa["valor_actividad"];            
            $TotalGlosado=$DatosGlosa["valor_glosado_eps"];
            
            $Descripcion= utf8_encode($DatosGlosa["DescripcionActividad"]);
            $css->CrearTabla();
                $css->FilaTabla(14);
                    $css->CrearInputText("idGlosa", "hidden", "", $idGlosa, "", "", "", "", 0, 0, 0, 0);
                    $css->CrearInputText("TotalGlosado", "hidden", "", $TotalGlosado, "", "", "", "", 0, 0, 0, 0);
                    $css->ColTabla("<h4 style='color:orange'><strong>Conciliar Glosa de la actividad $CodActividad $Descripcion.</strong></h4>", 5);
                    //$css->ColTabla("Total Glosado: <strong>".number_format($TotalGlosado)."</strong><br>Valor X Conciliar: <strong>".number_format($TotalXGlosar)."</strong>",1);
                    
                $css->CierraFilaTabla();
                $css->FilaTabla(14);
                    
                    print("<td style='text-align:center' colspan=2>");
                        //Para este caso la Fecha IPS será la fecha de conciliacion
                        $css->CrearInputText("FechaIPS", "date", "Fecha Conciliación<br>", date("Y-m-d"), "Fecha IPS", "", "onChange", "ValidarFecha(`FechaIPS`)", 150, 30, 0, 1);
                        print("</td>");
                        //print("<td style='text-align:center'>");
                        
                        $css->CrearInputText("FechaAuditoria", "hidden", "", date("Y-m-d"), "Fecha de Auditoria", "", "", "", 150, 30, 0, 1);
                       
                    //print("</td>");
                
                    print("<td style='text-align:center' colspan=3>");
                         $css->CrearDiv("DivChousen", "", "center", 1, 1);
                            $css->CrearTableChosen("CodigoGlosa", "salud_archivo_conceptos_glosas", "", "cod_glosa", "descrpcion_concep_especifico", "aplicacion", "cod_glosa", 400, 0, "Código Glosa", "Código de la Conciliación:");
                        $css->CerrarDiv();                        
                    print("</td>");
                    print("<td style='text-align:center'>");
                        print("<strong>Soporte de la Concilición:</strong><br>");
                        $css->CrearUpload("UpSoporteGlosa");
                    print("</td>");
                    $css->CierraFilaTabla();
                    $css->FilaTabla(14);
                    print("<td style='text-align:center'>");
                        $css->CrearInputNumber("ValorLevantado", "number", "Valor Levantado X EPS:<br>", $DatosGlosa["valor_levantado_eps"], "Valor Levantado EPS", "", "onChange", "ValidaValoresConciliacion()", 150, 30, 0, 1, 0, $DatosGlosa["valor_glosado_eps"], 1);
                       
                        $css->CrearInputNumber("ValorEPS", "number", "<br>Valor Glosado X EPS:<br>", $DatosGlosa["valor_glosado_eps"], "Valor EPS", "", "", "", 150, 30, 1, 1, 0, "", 1);
                        
                        print("</td>");
                        print("<td style='text-align:center'>");
                        $css->CrearInputNumber("ValorAceptado", "number", "Valor Aceptado X IPS:<br>", $DatosGlosa["valor_aceptado_ips"], "Valor Aceptado EPS", "", "onChange", "ValidaValoresConciliacion()", 150, 30, 0, 1, 0, $DatosGlosa["valor_glosado_eps"], 1);
                        
                        print("</td>");
                        
                        print("<td style='text-align:center' colspan=2>");
                        $css->CrearInputNumber("ValorConciliar", "number", "Valor X Conciliar<br>", $DatosGlosa["valor_glosado_eps"]-$DatosGlosa["valor_aceptado_ips"]-$DatosGlosa["valor_levantado_eps"], "Valor Conciliar", "", "", "", 150, 30, 1, 1, 0, $DatosGlosa["valor_glosado_eps"], 1);
                        
                    print("</td>");
                
                    print("<td style='text-align:center'>");
                        $css->CrearTextArea("Observaciones", "", "", "Observaciones", "", "", "", 200, 60, 0, 1);
                    print("</td>");
                    print("<td style='text-align:center'>");
                        
                        print("<br>");
                        $css->CrearBotonEvento("BtnConciliarGlosa", "Contra Glosar", 1, "onClick", "AgregarRespuestaGlosaTemporal('$idGlosa','12')", "naranja", "");
                        
                    print("</td>");
                $css->CierraFilaTabla();
                
                
            $css->CerrarTabla();
        break;
        case 12: //Formulario Editar una Glosa Inicial
            $idGlosa=$obGlosas->normalizar($_REQUEST["idGlosa"]);
           
            $CodActividad=$obGlosas->normalizar($_REQUEST["CodActividad"]);
            
            $DatosGlosa=$obGlosas->DevuelveValores("salud_glosas_iniciales", "ID", $idGlosa);
            $DatosRespuestaGlosa=$obGlosas->ValorActual("salud_archivo_control_glosas_respuestas", "ID,observacion_auditor as Observaciones,DescripcionActividad", " idGlosa='$idGlosa' AND EstadoGlosa='1'");
            $Descripcion=$DatosRespuestaGlosa["DescripcionActividad"];
            $idFactura=$DatosGlosa["num_factura"];
            
            $DatosFactura=$obGlosas->ValorActual("salud_archivo_facturacion_mov_generados", "valor_neto_pagar,valor_total_pago,CuentaGlobal,CuentaRIPS ", "  num_factura='$idFactura'");
            
            
            $CodActividad=$DatosGlosa["CodigoActividad"];
            $TotalActividad=$DatosGlosa["ValorActividad"];
            $TotalGlosasExistentes=$obGlosas->Sume("salud_glosas_iniciales", "ValorGlosado", " WHERE num_factura='$idFactura' AND CodigoActividad='$CodActividad' AND EstadoGlosa<>12");
            $TotalGlosasExistentesTemp=$obGlosas->Sume("salud_glosas_iniciales_temp", "ValorGlosado", " WHERE num_factura='$idFactura' AND CodigoActividad='$CodActividad'");
            $TotalGlosado=$TotalGlosasExistentesTemp+$TotalGlosasExistentes;
            $TotalXGlosar=$TotalActividad-$TotalGlosado;
            
            $css->CrearTabla();
                $css->FilaTabla(14);
                      $css->CrearInputText("TotalActividad", "hidden", "", $TotalActividad, "", "", "", "", 0, 0, 0, 0);
                    
                    $css->ColTabla("<h4 style='color:blue'><strong>Glosar la actividad $CodActividad $Descripcion. </strong></h4>", 5);
                    $css->ColTabla("Total Actividad: <strong>".number_format($TotalActividad)."</strong><br>Total Glosado X Ahora: <strong>".number_format($TotalGlosado)."</strong><br>Total Disponible X Glosar: <strong>".number_format($TotalXGlosar)."</strong>",1);
                    $css->CrearInputText("ValorXGlosarMax", "hidden", "", $TotalXGlosar, "", "", "", "", 150, 30, 0, 0);
                $css->CierraFilaTabla();
                $css->FilaTabla(14);
                    
                    print("<td style='text-align:center'>");
                    
                        $css->CrearInputText("FechaIPS", "date", "Fecha IPS<br>", $DatosGlosa["FechaIPS"], "Fecha IPS", "", "", "", 150, 30, 0, 1);
                        print("</td>");
                        print("<td style='text-align:center'>");
                        
                        $css->CrearInputText("FechaAuditoria", "date", "Fecha de Auditoría<br>", $DatosGlosa["FechaAuditoria"], "Fecha de Auditoria", "", "", "", 150, 30, 0, 1);
                       
                    print("</td>");
                
                    print("<td style='text-align:center' colspan=3>");
                         $css->CrearDiv("DivChousen", "", "center", 1, 1);
                            $css->CrearTableChosen("CodigoGlosa", "salud_archivo_conceptos_glosas", "", "cod_glosa", "descrpcion_concep_especifico", "aplicacion", "cod_glosa", 400, 0, "Codigo Glosa", "Código de la Glosa:",$DatosGlosa["CodigoGlosa"]);
                        $css->CerrarDiv();                        
                    print("</td>");
                    print("<td style='text-align:center'>");
                        print("<strong>Soporte de Glosa:</strong><br>");
                        $css->CrearUpload("UpSoporteGlosa");
                    print("</td>");
                    $css->CierraFilaTabla();
                    $css->FilaTabla(14);
                    print("<td style='text-align:center'>");
                        
                        $css->CrearInputNumber("ValorEPS", "number", "Valor Glosado X EPS:<br>", $DatosGlosa["ValorGlosado"], "Valor EPS", "", "onChange", "ValidaValorGlosa()", 150, 30, 0, 1, 0, $TotalActividad, 1);
                        print("</td>");
                        print("<td style='text-align:center'>");
                        $css->CrearInputNumber("ValorAceptado", "number", "Valor Aceptado X IPS:<br>", $DatosGlosa["ValorAceptado"], "Valor Aceptado EPS", "", "onChange", "ValidaValorGlosa()", 150, 30, 1, 1, 0, $TotalActividad, 1);
                        print("</td>");
                        
                        print("<td style='text-align:center' colspan=2>");
                        $css->CrearInputNumber("ValorConciliar", "number", "Valor X Conciliar<br>", $DatosGlosa["ValorXConciliar"], "Valor Conciliar", "", "onChange", "CalculeValorConciliar()", 150, 30, 1, 1, 0, $TotalActividad, 1);
                        
                    print("</td>");
                
                    print("<td style='text-align:center'>");
                        $css->CrearTextArea("Observaciones", "", $DatosRespuestaGlosa["Observaciones"], "Observaciones", "", "", "", 200, 60, 0, 1);
                    print("</td>");
                    print("<td style='text-align:center'>");
                        
                        print("<br>");
                        $idGlosaRespuesta=$DatosRespuestaGlosa["ID"];
                        $css->CrearBotonEvento("BtnEditarGlosa", "Editar", 1, "onClick", "EditarGlosaInicial('$idGlosa','$idGlosaRespuesta')", "naranja", "");
                        
                    print("</td>");
                $css->CierraFilaTabla();
                
                
            $css->CerrarTabla();
        break;    
        case 13://Formulario para editar una respuesta a una glosa
            $idGlosa=$obGlosas->normalizar($_REQUEST["idGlosa"]);
            
            $DatosGlosa=$obGlosas->DevuelveValores("salud_archivo_control_glosas_respuestas", "ID", $idGlosa);
            $Estado=$DatosGlosa["EstadoGlosa"];
            $TipoArchivo=$DatosGlosa["TipoArchivo"];
            $CodActividad=$DatosGlosa["CodigoActividad"];            
            $idFactura=$DatosGlosa["num_factura"];
            //$DatosFactura=$obGlosas->ValorActual("salud_archivo_facturacion_mov_generados", "valor_neto_pagar,valor_total_pago,CuentaGlobal,CuentaRIPS ", "num_factura='$idFactura'");
            
            $TotalActividad=$DatosGlosa["valor_actividad"];            
            $TotalGlosado=$DatosGlosa["valor_glosado_eps"];
            
            $Descripcion= utf8_encode($DatosGlosa["DescripcionActividad"]);
            $css->CrearTabla();
                $css->FilaTabla(14);
                    $css->CrearInputText("idGlosa", "hidden", "", $idGlosa, "", "", "", "", 0, 0, 0, 0);
                    $css->CrearInputText("TotalGlosado", "hidden", "", $TotalGlosado, "", "", "", "", 0, 0, 0, 0);
                    $css->ColTabla("<h4 style='color:orange'><strong>Editar respuesta a Glosa de la actividad $CodActividad $Descripcion.</strong></h4>", 5);
                    //$css->ColTabla("Total Glosado: <strong>".number_format($TotalGlosado)."</strong><br>Valor X Conciliar: <strong>".number_format($TotalXGlosar)."</strong>",1);
                    
                $css->CierraFilaTabla();
                $css->FilaTabla(14);
                    $ColSpan=1;
                    if($Estado==5){
                        $ColSpan=2;
                    }
                    print("<td style='text-align:center' colspan=$ColSpan>");
                            $ReadOnly=1;
                        if($Estado==3){
                            $ReadOnly=0;
                        }
                        if($Estado==5){
                            $css->CrearInputText("FechaIPS", "date", "Fecha Conciliación<br>", $DatosGlosa["FechaIPS"], "Fecha IPS", "", "", "", 150, 30, 0, 1);
                            $TipoCajaFecha="hidden";
                            $TituloCajaFecha="";
                        }else{
                            $css->CrearInputText("FechaIPS", "date", "Fecha IPS<br>", $DatosGlosa["FechaIPS"], "Fecha IPS", "", "", "", 150, 30, $ReadOnly, 1);
                            $TipoCajaFecha="date";
                            $TituloCajaFecha="Fecha de Auditoría<br>";
                        }
                        print("</td>");
                        if($Estado<>5){
                            print("<td style='text-align:center'>");
                        }
                        $css->CrearInputText("FechaAuditoria", $TipoCajaFecha, $TituloCajaFecha, $DatosGlosa["FechaAuditoria"], "Fecha de Auditoria", "", "", "", 150, 30, $ReadOnly, 1);
                     if($Estado<>5){  
                        print("</td>");
                    }
                    print("<td style='text-align:center' colspan=3>");
                         $css->CrearDiv("DivChousen", "", "center", 1, 1);
                            $css->CrearTableChosen("CodigoGlosa", "salud_archivo_conceptos_glosas", "", "cod_glosa", "descrpcion_concep_especifico", "aplicacion", "cod_glosa", 400, 0, "Codigo Glosa", "Código:",$DatosGlosa["id_cod_glosa"]);
                        $css->CerrarDiv();                        
                    print("</td>");
                    print("<td style='text-align:center'>");
                        print("<strong>Soporte:</strong><br>");
                        $css->CrearUpload("UpSoporteGlosa");
                    print("</td>");
                    $css->CierraFilaTabla();
                    $css->FilaTabla(14);
                    print("<td style='text-align:center'>");
                        
                        $css->CrearInputNumber("ValorEPS", "number", "Valor Glosado X EPS:<br>", $DatosGlosa["valor_glosado_eps"], "Valor EPS", "", "", "", 150, 30, 1, 1, 0, "", 1);
                        $js="ValidaValorLevantado()";
                        if($Estado==3 or $Estado==4 or $Estado==5){
                            
                            $ReadOnly=0;
                            if($Estado==4){
                                $ReadOnly=1;
                            }
                            if($Estado==5){
                                $js="ValidaValoresConciliacion()";
                            }
                            $css->CrearInputNumber("ValorLevantado", "number", "<br>Valor Levantado X EPS:<br>", $DatosGlosa["valor_levantado_eps"], "Valor Levantado x EPS", "", "onChange", $js, 150, 30, $ReadOnly, 1, 0, "", 1);
                        }
                        print("</td>");
                        print("<td style='text-align:center'>");
                        $ReadOnly=0;
                        if($Estado==3){
                            $ReadOnly=1;
                        }
                        $css->CrearInputNumber("ValorAceptado", "number", "Valor Aceptado X IPS:<br>", $DatosGlosa["valor_aceptado_ips"], "Valor Aceptado EPS", "", "onChange", $js, 150, 30, $ReadOnly, 1, 0, $DatosGlosa["valor_glosado_eps"], 1);
                        print("</td>");
                        
                        print("<td style='text-align:center' colspan=2>");
                        $css->CrearInputNumber("ValorConciliar", "number", "Valor X Conciliar<br>", $DatosGlosa["valor_glosado_eps"]-$DatosGlosa["valor_aceptado_ips"]-$DatosGlosa["valor_levantado_eps"], "Valor Conciliar", "", "", "", 150, 30, 1, 1, 0, $DatosGlosa["valor_glosado_eps"], 1);
                        
                    print("</td>");
                
                    print("<td style='text-align:center'>");
                        $css->CrearTextArea("Observaciones", "", $DatosGlosa["observacion_auditor"], "Observaciones", "", "", "", 200, 60, 0, 1);
                    print("</td>");
                    print("<td style='text-align:center'>");
                        
                        print("<br>");
                        $css->CrearBotonEvento("BtnResponderGlosa", "Editar esta Respuesta", 1, "onClick", "EditarRespuestaGlosa('$idGlosa')", "naranja", "");
                        print("<h4 style='color:orange'>Modo Edicion</h4>");
                    print("</td>");
                $css->CierraFilaTabla();
                
                
            $css->CerrarTabla();
        break;    
        case 14://Formulario para editar una contraglosa
            $idGlosa=$obGlosas->normalizar($_REQUEST["idGlosa"]);
            
            $DatosGlosa=$obGlosas->DevuelveValores("salud_archivo_control_glosas_respuestas", "ID", $idGlosa);
            $Estado=$DatosGlosa["EstadoGlosa"];
            $TipoArchivo=$DatosGlosa["TipoArchivo"];
            $CodActividad=$DatosGlosa["CodigoActividad"];            
            $idFactura=$DatosGlosa["num_factura"];
            //$DatosFactura=$obGlosas->ValorActual("salud_archivo_facturacion_mov_generados", "valor_neto_pagar,valor_total_pago,CuentaGlobal,CuentaRIPS ", "num_factura='$idFactura'");
            
            $TotalActividad=$DatosGlosa["valor_actividad"];            
            $TotalGlosado=$DatosGlosa["valor_glosado_eps"];
            
            $Descripcion= utf8_encode($DatosGlosa["DescripcionActividad"]);
            $css->CrearTabla();
                $css->FilaTabla(14);
                    $css->CrearInputText("idGlosa", "hidden", "", $idGlosa, "", "", "", "", 0, 0, 0, 0);
                    $css->CrearInputText("TotalGlosado", "hidden", "", $TotalGlosado, "", "", "", "", 0, 0, 0, 0);
                    $css->ColTabla("<h4 style='color:orange'><strong>Editar respuesta a Glosa de la actividad $CodActividad $Descripcion.</strong></h4>", 5);
                    //$css->ColTabla("Total Glosado: <strong>".number_format($TotalGlosado)."</strong><br>Valor X Conciliar: <strong>".number_format($TotalXGlosar)."</strong>",1);
                    
                $css->CierraFilaTabla();
                $css->FilaTabla(14);
                    $ColSpan=1;
                    if($Estado==5){
                        $ColSpan=2;
                    }
                    print("<td style='text-align:center' colspan=$ColSpan>");
                            $ReadOnly=1;
                        if($Estado==3){
                            $ReadOnly=0;
                        }
                        if($Estado==5){
                            $css->CrearInputText("FechaIPS", "date", "Fecha Conciliación<br>", $DatosGlosa["FechaIPS"], "Fecha IPS", "", "", "", 150, 30, 0, 1);
                            $TipoCajaFecha="hidden";
                            $TituloCajaFecha="";
                        }else{
                            $css->CrearInputText("FechaIPS", "date", "Fecha IPS<br>", $DatosGlosa["FechaIPS"], "Fecha IPS", "", "", "", 150, 30, $ReadOnly, 1);
                            $TipoCajaFecha="date";
                            $TituloCajaFecha="Fecha de Auditoría<br>";
                        }
                        print("</td>");
                        if($Estado<>5){
                            print("<td style='text-align:center'>");
                        }
                        $css->CrearInputText("FechaAuditoria", $TipoCajaFecha, $TituloCajaFecha, $DatosGlosa["FechaAuditoria"], "Fecha de Auditoria", "", "", "", 150, 30, $ReadOnly, 1);
                     if($Estado<>5){  
                        print("</td>");
                    }
                    print("<td style='text-align:center' colspan=3>");
                         $css->CrearDiv("DivChousen", "", "center", 1, 1);
                            $css->CrearTableChosen("CodigoGlosa", "salud_archivo_conceptos_glosas", "", "cod_glosa", "descrpcion_concep_especifico", "aplicacion", "cod_glosa", 400, 0, "Codigo Glosa", "Código:",$DatosGlosa["id_cod_glosa"]);
                        $css->CerrarDiv();                        
                    print("</td>");
                    print("<td style='text-align:center'>");
                        print("<strong>Soporte:</strong><br>");
                        $css->CrearUpload("UpSoporteGlosa");
                    print("</td>");
                    $css->CierraFilaTabla();
                    $css->FilaTabla(14);
                    print("<td style='text-align:center'>");
                        
                        $css->CrearInputNumber("ValorEPS", "number", "Valor Glosado X EPS:<br>", $DatosGlosa["valor_glosado_eps"], "Valor EPS", "", "", "", 150, 30, 1, 1, 0, "", 1);
                        $js="ValidaValorLevantado()";
                        if($Estado==3 or $Estado==4 or $Estado==5){
                            
                            $ReadOnly=0;
                            if($Estado==4){
                                $ReadOnly=1;
                            }
                            if($Estado==5){
                                $js="ValidaValoresConciliacion()";
                            }
                            $css->CrearInputNumber("ValorLevantado", "number", "<br>Valor Levantado X EPS:<br>", $DatosGlosa["valor_levantado_eps"], "Valor Levantado x EPS", "", "onChange", $js, 150, 30, $ReadOnly, 1, 0, "", 1);
                        }
                        print("</td>");
                        print("<td style='text-align:center'>");
                        $ReadOnly=0;
                        if($Estado==3){
                            $ReadOnly=1;
                        }
                        $css->CrearInputNumber("ValorAceptado", "number", "Valor Aceptado X IPS:<br>", $DatosGlosa["valor_aceptado_ips"], "Valor Aceptado EPS", "", "onChange", $js, 150, 30, $ReadOnly, 1, 0, $DatosGlosa["valor_glosado_eps"], 1);
                        print("</td>");
                        
                        print("<td style='text-align:center' colspan=2>");
                        $css->CrearInputNumber("ValorConciliar", "number", "Valor X Conciliar<br>", $DatosGlosa["valor_glosado_eps"]-$DatosGlosa["valor_aceptado_ips"]-$DatosGlosa["valor_levantado_eps"], "Valor Conciliar", "", "", "", 150, 30, 1, 1, 0, $DatosGlosa["valor_glosado_eps"], 1);
                        
                    print("</td>");
                
                    print("<td style='text-align:center'>");
                        $css->CrearTextArea("Observaciones", "", $DatosGlosa["observacion_auditor"], "Observaciones", "", "", "", 200, 60, 0, 1);
                    print("</td>");
                    print("<td style='text-align:center'>");
                        
                        print("<br>");
                        $css->CrearBotonEvento("BtnResponderGlosa", "Editar esta Respuesta", 1, "onClick", "EditarRespuestaGlosa('$idGlosa')", "naranja", "");
                        print("<h4 style='color:orange'>Modo Edicion</h4>");
                    print("</td>");
                $css->CierraFilaTabla();
                
                
            $css->CerrarTabla();
        break;
    }
          
}else{
    print("No se enviaron parametros");
}
?>