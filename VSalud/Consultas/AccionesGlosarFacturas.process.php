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
                   exit("No se recibieron los valores esperados");
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
            
            $idGlosa=$obGlosas->RegistrarGlosaInicialTemporal($TipoArchivo,$idFactura, $idActividad,$TotalActividad, $FechaIPS, $FechaAuditoria, $CodigoGlosa, $ValorEPS, $ValorAceptado, $ValorConciliar,$Observaciones,$destino, "");
            print("Glosa inicial registrada en la tabla temporal");
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
            
            $idGlosa=$obGlosas->RegistrarGlosaInicialTemporal($TipoArchivo,$idFactura, $idActividad,$TotalActividad, $FechaIPS, $FechaAuditoria, $CodigoGlosa, $ValorEPS, $ValorAceptado, $ValorConciliar,$Observaciones,$destino, "",$DatosGlosaTemp["ValorGlosado"]);
            $obGlosas->EliminarGlosaTemporal($idGlosaTemp);
            print("Glosa inicial editada en la tabla temporal");
        break;
        
        case 5:// Guarda las glosas de la tabla temporal a la real
            $obGlosas->GuardaGlosasTemporalesAIniciales($idUser, "");
            print("Glosas Registradas");
        break;

        
    }
          
}else{
    print("No se enviaron parametros");
}
?>