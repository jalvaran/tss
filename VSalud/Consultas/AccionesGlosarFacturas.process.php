<?php

session_start();
if (!isset($_SESSION['username'])){
  exit("<a href='../index.php' ><img src='../images/401.png'>Iniciar Sesion </a>");
  
}
$idUser=$_SESSION['idUser'];

include_once("../../modelo/php_conexion.php");
include_once("../css_construct.php");
include_once("../clases/GlosasTSS.class.php");


if( !empty($_REQUEST["idAccion"]) ){
    $css =  new CssIni("id",0);
    $obGlosas = new Glosas($idUser);
    
    switch ($_REQUEST["idAccion"]) {
        case 1: //Registra la devolucion de una factura
            if(!empty($_REQUEST["idFactura"]) or !empty($_REQUEST["FechaDevolucion"]) or !empty($_REQUEST["FechaAuditoria"]) or !empty($_REQUEST["Observaciones"]) or !empty($_REQUEST["CodigoGlosa"]) ){
                exit("No se recibieron los valores esperados");
            }
            $idFactura=$obGlosas->normalizar($_REQUEST["idFactura"]);
            $FechaDevolucion=$obGlosas->normalizar($_REQUEST["FechaDevolucion"]);
            $FechaAuditoria=$obGlosas->normalizar($_REQUEST["FechaAuditoria"]);
            $Observaciones=$obGlosas->normalizar($_REQUEST["Observaciones"]);
            $CodigoGlosa=$obGlosas->normalizar($_REQUEST["CodigoGlosa"]);
            $ValorFactura=$obGlosas->normalizar($_REQUEST["ValorFactura"]);
            $destino='';
            if(!empty($_FILES['Soporte']['name'])){
            
                $Atras="../";
                $carpeta="SoportesSalud/SoportesDevoluciones/";
                opendir($Atras.$Atras.$carpeta);
                $Name=str_replace(' ','_',$FechaDevolucion."_".$idFactura."_".$_FILES['Soporte']['name']);
                $destino=$carpeta.$Name;
                move_uploaded_file($_FILES['Soporte']['tmp_name'],$Atras.$Atras.$destino);
            }
            $obGlosas->DevolverFactura($idFactura,$ValorFactura, $FechaDevolucion,$FechaAuditoria, $Observaciones, $CodigoGlosa, $idUser, $destino, "");
        
        break;
        
        case 2: //Registra las glosas iniciales en la tabla temporal
            if(empty($_REQUEST["idActividad"]) or empty($_REQUEST["idFactura"]) or empty($_REQUEST["FechaIPS"]) or empty($_REQUEST["FechaAuditoria"]) or empty($_REQUEST["Observaciones"]) or empty($_REQUEST["ValorEPS"]) ){
                   
                   $Mensaje["msg"]="No se recibieron los valores esperados";
                   $Mensaje["Error"]=1;
                   exit($Mensaje);
            }
            $idFactura=$obGlosas->normalizar($_REQUEST["idFactura"]);
            $idActividad=$obGlosas->normalizar($_REQUEST["idActividad"]);
            $TipoArchivo=$obGlosas->normalizar($_REQUEST["TipoArchivo"]);
            $FechaIPS=$obGlosas->normalizar($_REQUEST["FechaIPS"]);
            $FechaAuditoria=$obGlosas->normalizar($_REQUEST["FechaAuditoria"]);
            
            $Observaciones=$obGlosas->normalizar($_REQUEST["Observaciones"]);
            $CodigoGlosa=$obGlosas->normalizar($_REQUEST["CodigoGlosa"]);
            $ValorEPS=$obGlosas->normalizar($_REQUEST["ValorEPS"]);
            $ValorAceptado=$obGlosas->normalizar($_REQUEST["ValorAceptado"]);
            $ValorConciliar=$obGlosas->normalizar($_REQUEST["ValorConciliar"]);
            $TotalActividad=$obGlosas->normalizar($_REQUEST["TotalActividad"]);
            
            $destino='';
            if(!empty($_FILES['Soporte']['name'])){
            
                $Atras="../";
                $carpeta="SoportesSalud/SoportesGlosas/";
                opendir($Atras.$Atras.$carpeta);
                $Name=str_replace(' ','_',$FechaIPS."_".$idActividad."_".$idFactura."_".$_FILES['Soporte']['name']);
                $destino=$carpeta.$Name;
                move_uploaded_file($_FILES['Soporte']['tmp_name'],$Atras.$Atras.$destino);
            }
            
            $Mensaje=$obGlosas->RegistrarGlosaInicialTemporal($TipoArchivo,$idFactura, $idActividad,$TotalActividad, $FechaIPS, $FechaAuditoria, $CodigoGlosa, $ValorEPS, $ValorAceptado, $ValorConciliar,$Observaciones,$destino, "");
            print(json_encode($Mensaje));
        break;
        case 3://eliminar un registro de la tabla temporal de glosas
            $idGlosa=$obGlosas->normalizar($_REQUEST["idGlosa"]);
            $obGlosas->EliminarGlosaTemporal($idGlosa);
            print("La glosa temporal ha sido eliminada");
        break;
        case 4://Se reciben los parametros para editar una glosa
            if(empty($_REQUEST["idGlosaTemp"]) or empty($_REQUEST["CodigoGlosa"]) or empty($_REQUEST["FechaIPS"]) or empty($_REQUEST["FechaAuditoria"]) or empty($_REQUEST["Observaciones"]) or empty($_REQUEST["ValorEPS"]) ){
                   exit("No se recibieron los valores esperados");
            }
            $idGlosaTemp=$obGlosas->normalizar($_REQUEST["idGlosaTemp"]);
            $DatosGlosaTemp=$obGlosas->DevuelveValores("salud_glosas_iniciales_temp", "ID", $idGlosaTemp);
            $idFactura=$DatosGlosaTemp["num_factura"];
            
            $idActividad=$DatosGlosaTemp["idArchivo"];
            $TipoArchivo=$DatosGlosaTemp["TipoArchivo"];
            $FechaIPS=$obGlosas->normalizar($_REQUEST["FechaIPS"]);
            $FechaAuditoria=$obGlosas->normalizar($_REQUEST["FechaAuditoria"]);
            
            $Observaciones=$obGlosas->normalizar($_REQUEST["Observaciones"]);
            $CodigoGlosa=$obGlosas->normalizar($_REQUEST["CodigoGlosa"]);
            $ValorEPS=$obGlosas->normalizar($_REQUEST["ValorEPS"]);
            $ValorAceptado=$obGlosas->normalizar($_REQUEST["ValorAceptado"]);
            $ValorConciliar=$obGlosas->normalizar($_REQUEST["ValorConciliar"]);
            $TotalActividad=$obGlosas->normalizar($_REQUEST["TotalActividad"]);
            
            $destino='';
            if(!empty($_FILES['Soporte']['name'])){
            
                $Atras="../";
                $carpeta="SoportesSalud/SoportesGlosas/";
                opendir($Atras.$Atras.$carpeta);
                $Name=str_replace(' ','_',$FechaIPS."_".$idActividad."_".$idFactura."_".$_FILES['Soporte']['name']);
                $destino=$carpeta.$Name;
                move_uploaded_file($_FILES['Soporte']['tmp_name'],$Atras.$Atras.$destino);
            }
            $idGlosa=$obGlosas->EditaGlosaRespuestaTemporal($idGlosaTemp,$TipoArchivo,$DatosGlosaTemp["idArchivo"],$idFactura,$DatosGlosaTemp["CodigoActividad"],$DatosGlosaTemp["NombreActividad"],$TotalActividad,$DatosGlosaTemp["EstadoGlosa"],$FechaIPS,$FechaAuditoria,$Observaciones,$CodigoGlosa,$ValorEPS,$ValorAceptado,0,$ValorConciliar,$destino,$idUser,"");
            //$idGlosa=$obGlosas->RegistraGlosaRespuestaTemporal($idGlosaTemp,$TipoArchivo,$idFactura, $idActividad,$TotalActividad, $FechaIPS, $FechaAuditoria, $CodigoGlosa, $ValorEPS, $ValorAceptado, $ValorConciliar,$Observaciones,$destino, $idUser,"");
            //$obGlosas->EliminarGlosaTemporal($idGlosaTemp);
            print("Glosa inicial editada en la tabla temporal");
        break;
        
        case 5:// Guarda las glosas de la tabla temporal a la real
            $obGlosas->GuardaGlosasTemporalesAIniciales($idUser, "");
            print("Glosas Registradas");
        break;
    
        case 6:// Guarda las repuestas a glosas a la tabla temporal 
            $idGlosaTemp=$obGlosas->normalizar($_REQUEST["idGlosa"]);
            
            $DatosGlosa=$obGlosas->DevuelveValores("salud_archivo_control_glosas_respuestas", "ID", $idGlosaTemp);
            $CuentaRIPS=$DatosGlosa["CuentaRIPS"];
            $TipoArchivo=$DatosGlosa["TipoArchivo"];
            $CodActividad=$DatosGlosa["CodigoActividad"];            
            $idFactura=$DatosGlosa["num_factura"];
            $idGlosa=$DatosGlosa["idGlosa"];
            $CodGlosa=$DatosGlosa["id_cod_glosa"];
            $sql="SELECT ID FROM salud_archivo_control_glosas_respuestas_temp WHERE idGlosa='$idGlosa'  AND EstadoGlosa=2";
            $consulta=$obGlosas->Query($sql);
            $DatosExistentes=$obGlosas->FetchArray($consulta);
            if($DatosExistentes["ID"]<>''){
                exit("<h4 style='color:red'>Ya exite una respuesta agregada a esta Glosa $idGlosa en la tabla temporal</h4>");
            }
            $sql="SELECT ID FROM salud_archivo_control_glosas_respuestas WHERE idGlosa='$idGlosa' AND id_cod_glosa='$CodGlosa' AND EstadoGlosa=2";
            $consulta=$obGlosas->Query($sql);
            $DatosExistentes=$obGlosas->FetchArray($consulta);
            if($DatosExistentes["ID"]<>''){
                exit("<h4 style='color:red'>Ya exite una respuesta agregada a esta Glosa $idGlosa</h4>");
            }
            //$DatosFactura=$obGlosas->ValorActual("salud_archivo_facturacion_mov_generados", "valor_neto_pagar,valor_total_pago,CuentaGlobal,CuentaRIPS ", "num_factura='$idFactura'");
            
            $TotalActividad=$DatosGlosa["valor_actividad"];            
            $TotalGlosado=$DatosGlosa["valor_glosado_eps"];
            
            $Descripcion= utf8_encode($DatosGlosa["DescripcionActividad"]);
            
            $FechaIPS=$obGlosas->normalizar($_REQUEST["FechaIPS"]);
            $FechaAuditoria=$obGlosas->normalizar($_REQUEST["FechaAuditoria"]);
            
            $Observaciones=$obGlosas->normalizar($_REQUEST["Observaciones"]);
            $CodigoGlosa=$obGlosas->normalizar($_REQUEST["CodigoGlosa"]);
            $ValorEPS=$obGlosas->normalizar($_REQUEST["ValorEPS"]);
            $ValorAceptado=$obGlosas->normalizar($_REQUEST["ValorAceptado"]);
            $ValorConciliar=$obGlosas->normalizar($_REQUEST["ValorConciliar"]);
                        
            $destino='';
            if(!empty($_FILES['Soporte']['name'])){
            
                $Atras="../";
                $carpeta="SoportesSalud/SoportesGlosas/";
                opendir($Atras.$Atras.$carpeta);
                $Name=str_replace(' ','_',"Respuesta_".$FechaIPS."_".$CuentaRIPS."_$idFactura"."_".$_FILES['Soporte']['name']);
                $destino=$carpeta.$Name;
                move_uploaded_file($_FILES['Soporte']['tmp_name'],$Atras.$Atras.$destino);
            }
            
            $obGlosas->RegistraGlosaRespuestaTemporal('',$TipoArchivo, $idGlosa, $idFactura, $CodActividad, $Descripcion, $TotalActividad, 2, $FechaIPS, $FechaAuditoria, $Observaciones, $CodigoGlosa, $ValorEPS, $ValorAceptado, 0, $ValorConciliar, $destino, $idUser, "");
            
            print("<h4 style='color:blue'>Respuesta a Glosas Registrada en la tabla temporal</h4>");
        break;
        
        case 7://Elimina una respuesta a glosa de la tabla temporal
            $idGlosaTemp=$obGlosas->normalizar($_REQUEST["idGlosa"]);
            $obGlosas->BorraReg("salud_archivo_control_glosas_respuestas_temp", "ID", $idGlosaTemp);
            print("Respuesta a Glosa temporal eliminada");
        break;    
        case 8:// Edita las repuestas a glosas a la tabla temporal 
            $idGlosa=$obGlosas->normalizar($_REQUEST["idGlosa"]);
            
            $DatosGlosa=$obGlosas->DevuelveValores("salud_archivo_control_glosas_respuestas_temp", "ID", $idGlosa);
            $CuentaRIPS=$DatosGlosa["CuentaRIPS"];
            $TipoArchivo=$DatosGlosa["TipoArchivo"];
            $CodActividad=$DatosGlosa["CodigoActividad"];            
            $idFactura=$DatosGlosa["num_factura"];
            
            $TotalActividad=$DatosGlosa["valor_actividad"];            
            $TotalGlosado=$DatosGlosa["valor_glosado_eps"];
                        
            $Descripcion= utf8_encode($DatosGlosa["DescripcionActividad"]);
            
            $FechaIPS=$obGlosas->normalizar($_REQUEST["FechaIPS"]);
            $FechaAuditoria=$obGlosas->normalizar($_REQUEST["FechaAuditoria"]);
            
            $Observaciones=$obGlosas->normalizar($_REQUEST["Observaciones"]);
            $CodigoGlosa=$obGlosas->normalizar($_REQUEST["CodigoGlosa"]);
            $ValorEPS=$obGlosas->normalizar($_REQUEST["ValorEPS"]);
            $ValorAceptado=$obGlosas->normalizar($_REQUEST["ValorAceptado"]);
            $ValorConciliar=$obGlosas->normalizar($_REQUEST["ValorConciliar"]);
            $ValorLevantado=$obGlosas->normalizar($_REQUEST["ValorLevantado"]);     
            $destino='';
            if(!empty($_FILES['Soporte']['name'])){
            
                $Atras="../";
                $carpeta="SoportesSalud/SoportesGlosas/";
                opendir($Atras.$Atras.$carpeta);
                $Name=str_replace(' ','_',"Respuesta_".$FechaIPS."_".$CuentaRIPS."_$idFactura"."_".$_FILES['Soporte']['name']);
                $destino=$carpeta.$Name;
                move_uploaded_file($_FILES['Soporte']['tmp_name'],$Atras.$Atras.$destino);
            }
            
            $obGlosas->RegistraGlosaRespuestaTemporal($idGlosa,$TipoArchivo, $DatosGlosa["idGlosa"], $idFactura, $CodActividad, $Descripcion, $TotalActividad, $DatosGlosa["EstadoGlosa"], $FechaIPS, $FechaAuditoria, $Observaciones, $CodigoGlosa, $ValorEPS, $ValorAceptado, $ValorLevantado, $ValorConciliar, $destino, $idUser, "");
            
            print("<h4 style='color:orange'>Respuesta a Glosas Editada en la tabla temporal</h4>");
        break;
        case 9:// Guarda las respuesta de las glosas de la tabla temporal a la real
            $obGlosas->GuardaConciliacionesTemporalAReal($idUser, "");
            $obGlosas->GuardaRespuestaContraGlosasTemporalAReal($idUser, "");
            $obGlosas->GuardaContraGlosasTemporalAReal($idUser, "");
            $obGlosas->GuardaRespuestasGlosasTemporalAReal($idUser, "");
            $obGlosas->VaciarTabla("salud_archivo_control_glosas_respuestas_temp");
            print("Respuestas a Glosas Registradas");
        break;
    
        case 10:// Guarda contra glosa a la tabla temporal de respuestas
            $idGlosaTemp=$obGlosas->normalizar($_REQUEST["idGlosa"]);
            
            $DatosGlosa=$obGlosas->DevuelveValores("salud_archivo_control_glosas_respuestas", "ID", $idGlosaTemp);
            $CuentaRIPS=$DatosGlosa["CuentaRIPS"];
            $TipoArchivo=$DatosGlosa["TipoArchivo"];
            $CodActividad=$DatosGlosa["CodigoActividad"];            
            $idFactura=$DatosGlosa["num_factura"];
            $idGlosa=$DatosGlosa["idGlosa"];
            $CodGlosa=$DatosGlosa["id_cod_glosa"];
            $sql="SELECT ID FROM salud_archivo_control_glosas_respuestas_temp WHERE idGlosa='$idGlosa'  AND EstadoGlosa=3";
            $consulta=$obGlosas->Query($sql);
            $DatosExistentes=$obGlosas->FetchArray($consulta);
            if($DatosExistentes["ID"]<>''){
                exit("<h4 style='color:red'>Ya exite una respuesta agregada a esta Glosa $idGlosa en la tabla temporal</h4>");
            }
            $sql="SELECT ID FROM salud_archivo_control_glosas_respuestas WHERE idGlosa='$idGlosa' AND id_cod_glosa='$CodGlosa' AND EstadoGlosa=3";
            $consulta=$obGlosas->Query($sql);
            $DatosExistentes=$obGlosas->FetchArray($consulta);
            if($DatosExistentes["ID"]<>''){
                exit("<h4 style='color:red'>Ya exite una respuesta agregada a esta Glosa $idGlosa</h4>");
            }
            //$DatosFactura=$obGlosas->ValorActual("salud_archivo_facturacion_mov_generados", "valor_neto_pagar,valor_total_pago,CuentaGlobal,CuentaRIPS ", "num_factura='$idFactura'");
            
            $TotalActividad=$DatosGlosa["valor_actividad"];            
            $TotalGlosado=$DatosGlosa["valor_glosado_eps"];
            
            $Descripcion= utf8_encode($DatosGlosa["DescripcionActividad"]);
            
            $FechaIPS=$obGlosas->normalizar($_REQUEST["FechaIPS"]);
            $FechaAuditoria=$obGlosas->normalizar($_REQUEST["FechaAuditoria"]);
            
            $Observaciones=$obGlosas->normalizar($_REQUEST["Observaciones"]);
            $CodigoGlosa=$obGlosas->normalizar($_REQUEST["CodigoGlosa"]);
            $ValorEPS=$obGlosas->normalizar($_REQUEST["ValorEPS"]);
            $ValorAceptado=$obGlosas->normalizar($_REQUEST["ValorAceptado"]);
            $ValorConciliar=$obGlosas->normalizar($_REQUEST["ValorConciliar"]);
            $ValorLevantado=$obGlosas->normalizar($_REQUEST["ValorLevantado"]);
                        
            $destino='';
            if(!empty($_FILES['Soporte']['name'])){
            
                $Atras="../";
                $carpeta="SoportesSalud/SoportesGlosas/";
                opendir($Atras.$Atras.$carpeta);
                $Name=str_replace(' ','_',"Respuesta_".$FechaIPS."_".$CuentaRIPS."_$idFactura"."_".$_FILES['Soporte']['name']);
                $destino=$carpeta.$Name;
                move_uploaded_file($_FILES['Soporte']['tmp_name'],$Atras.$Atras.$destino);
            }
            
            $obGlosas->RegistraGlosaRespuestaTemporal('',$TipoArchivo, $idGlosa, $idFactura, $CodActividad, $Descripcion, $TotalActividad, 3, $FechaIPS, $FechaAuditoria, $Observaciones, $CodigoGlosa, $ValorEPS, $ValorAceptado, $ValorLevantado, $ValorConciliar, $destino, $idUser, "");
            
            print("<h4 style='color:blue'>Respuesta a Glosas Registrada en la tabla temporal</h4>");
        break;
        
        case 11:// Guarda las repuestas a glosas a la tabla temporal 
            $idGlosaTemp=$obGlosas->normalizar($_REQUEST["idGlosa"]);
            
            $DatosGlosa=$obGlosas->DevuelveValores("salud_archivo_control_glosas_respuestas", "ID", $idGlosaTemp);
            $CuentaRIPS=$DatosGlosa["CuentaRIPS"];
            $TipoArchivo=$DatosGlosa["TipoArchivo"];
            $CodActividad=$DatosGlosa["CodigoActividad"];            
            $idFactura=$DatosGlosa["num_factura"];
            $idGlosa=$DatosGlosa["idGlosa"];
            $CodGlosa=$DatosGlosa["id_cod_glosa"];
            $sql="SELECT ID FROM salud_archivo_control_glosas_respuestas_temp WHERE idGlosa='$idGlosa'  AND EstadoGlosa=4";
            $consulta=$obGlosas->Query($sql);
            $DatosExistentes=$obGlosas->FetchArray($consulta);
            if($DatosExistentes["ID"]<>''){
                exit("<h4 style='color:red'>Ya exite una respuesta agregada a esta Contra Glosa $idGlosa en la tabla temporal</h4>");
            }
            $sql="SELECT ID FROM salud_archivo_control_glosas_respuestas WHERE idGlosa='$idGlosa' AND id_cod_glosa='$CodGlosa' AND EstadoGlosa=4";
            $consulta=$obGlosas->Query($sql);
            $DatosExistentes=$obGlosas->FetchArray($consulta);
            if($DatosExistentes["ID"]<>''){
                exit("<h4 style='color:red'>Ya exite una respuesta agregada a esta Contra Glosa $idGlosa</h4>");
            }
            
            $TotalActividad=$DatosGlosa["valor_actividad"];            
            $TotalGlosado=$DatosGlosa["valor_glosado_eps"];
            
            $Descripcion= utf8_encode($DatosGlosa["DescripcionActividad"]);
            
            $FechaIPS=$obGlosas->normalizar($_REQUEST["FechaIPS"]);
            $FechaAuditoria=$obGlosas->normalizar($_REQUEST["FechaAuditoria"]);
            
            $Observaciones=$obGlosas->normalizar($_REQUEST["Observaciones"]);
            $CodigoGlosa=$obGlosas->normalizar($_REQUEST["CodigoGlosa"]);
            $ValorEPS=$obGlosas->normalizar($_REQUEST["ValorEPS"]);
            $ValorAceptado=$obGlosas->normalizar($_REQUEST["ValorAceptado"]);
            $ValorConciliar=$obGlosas->normalizar($_REQUEST["ValorConciliar"]);
            $ValorLevantado=$obGlosas->normalizar($_REQUEST["ValorLevantado"]);
                        
            $destino='';
            if(!empty($_FILES['Soporte']['name'])){
            
                $Atras="../";
                $carpeta="SoportesSalud/SoportesGlosas/";
                opendir($Atras.$Atras.$carpeta);
                $Name=str_replace(' ','_',"RespuestaContraGlosa_".$FechaIPS."_".$CuentaRIPS."_$idFactura"."_".$_FILES['Soporte']['name']);
                $destino=$carpeta.$Name;
                move_uploaded_file($_FILES['Soporte']['tmp_name'],$Atras.$Atras.$destino);
            }
            
            $obGlosas->RegistraGlosaRespuestaTemporal('',$TipoArchivo, $idGlosa, $idFactura, $CodActividad, $Descripcion, $TotalActividad, 4, $FechaIPS, $FechaAuditoria, $Observaciones, $CodigoGlosa, $ValorEPS, $ValorAceptado, $ValorLevantado, $ValorConciliar, $destino, $idUser, "");
            
            print("<h4 style='color:blue'>Respuesta a Glosas Registrada en la tabla temporal</h4>");
        break;
        
        case 12:// Guarda las conciliaciones en la tabla temporal
            $idGlosaTemp=$obGlosas->normalizar($_REQUEST["idGlosa"]);
            
            $DatosGlosa=$obGlosas->DevuelveValores("salud_archivo_control_glosas_respuestas", "ID", $idGlosaTemp);
            $CuentaRIPS=$DatosGlosa["CuentaRIPS"];
            $TipoArchivo=$DatosGlosa["TipoArchivo"];
            $CodActividad=$DatosGlosa["CodigoActividad"];            
            $idFactura=$DatosGlosa["num_factura"];
            $idGlosa=$DatosGlosa["idGlosa"];
            $CodGlosa=$DatosGlosa["id_cod_glosa"];
            $sql="SELECT ID FROM salud_archivo_control_glosas_respuestas_temp WHERE idGlosa='$idGlosa'  AND EstadoGlosa=5";
            $consulta=$obGlosas->Query($sql);
            $DatosExistentes=$obGlosas->FetchArray($consulta);
            if($DatosExistentes["ID"]<>''){
                exit("<h4 style='color:red'>Ya exite una conciliacion agregada a esta Contra Glosa $idGlosa en la tabla temporal</h4>");
            }
            $sql="SELECT ID FROM salud_archivo_control_glosas_respuestas WHERE idGlosa='$idGlosa' AND id_cod_glosa='$CodGlosa' AND EstadoGlosa=5";
            $consulta=$obGlosas->Query($sql);
            $DatosExistentes=$obGlosas->FetchArray($consulta);
            if($DatosExistentes["ID"]<>''){
                exit("<h4 style='color:red'>Ya exite una conciliacion agregada a esta Contra Glosa $idGlosa</h4>");
            }
            
            $TotalActividad=$DatosGlosa["valor_actividad"];            
            $TotalGlosado=$DatosGlosa["valor_glosado_eps"];
            
            $Descripcion= utf8_encode($DatosGlosa["DescripcionActividad"]);
            
            $FechaIPS=$obGlosas->normalizar($_REQUEST["FechaIPS"]);
            $FechaAuditoria=$obGlosas->normalizar($_REQUEST["FechaAuditoria"]);
            
            $Observaciones=$obGlosas->normalizar($_REQUEST["Observaciones"]);
            $CodigoGlosa=$obGlosas->normalizar($_REQUEST["CodigoGlosa"]);
            $ValorEPS=$obGlosas->normalizar($_REQUEST["ValorEPS"]);
            $ValorAceptado=$obGlosas->normalizar($_REQUEST["ValorAceptado"]);
            $ValorConciliar=$obGlosas->normalizar($_REQUEST["ValorConciliar"]);
            $ValorLevantado=$obGlosas->normalizar($_REQUEST["ValorLevantado"]);
                        
            $destino='';
            if(!empty($_FILES['Soporte']['name'])){
            
                $Atras="../";
                $carpeta="SoportesSalud/SoportesGlosas/";
                opendir($Atras.$Atras.$carpeta);
                $Name=str_replace(' ','_',"Conciliacion_".$FechaIPS."_".$CuentaRIPS."_$idFactura"."_".$_FILES['Soporte']['name']);
                $destino=$carpeta.$Name;
                move_uploaded_file($_FILES['Soporte']['tmp_name'],$Atras.$Atras.$destino);
            }
            
            $obGlosas->RegistraGlosaRespuestaTemporal('',$TipoArchivo, $idGlosa, $idFactura, $CodActividad, $Descripcion, $TotalActividad, 5, $FechaIPS, $FechaAuditoria, $Observaciones, $CodigoGlosa, $ValorEPS, $ValorAceptado, $ValorLevantado, $ValorConciliar, $destino, $idUser, "");
            
            print("<h4 style='color:blue'>Conciliacion de la Glosa Registrada en la tabla temporal</h4>");
        break;
    }
          
}else{
    print("No se enviaron parametros");
}
?>