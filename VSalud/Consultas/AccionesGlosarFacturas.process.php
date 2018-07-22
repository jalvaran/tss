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
        
        case 2: //Registra las glosas iniciales
            if(empty($_REQUEST["CodigoGlosa"]) or empty($_REQUEST["idFactura"]) or empty($_REQUEST["FechaIPS"]) or empty($_REQUEST["FechaAuditoria"]) or empty($_REQUEST["Observaciones"]) or empty($_REQUEST["ValorEPS"]) ){
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
            //$obGlosas->RegistraGlosaRespuesta($TipoArchivo, $idGlosa, $idFactura, $idActividad, $TotalActividad, 1, $FechaIPS, $FechaAuditoria, $Observaciones, $CodigoGlosa, $ValorEPS, $ValorAceptado, 0, $ValorConciliar, $destino, $idUser, "");
            print("Glosa inicial registrada en la tabla temporal");
        break;

        
    }
          
}else{
    print("No se enviaron parametros");
}
?>