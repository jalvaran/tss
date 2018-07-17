<?php

session_start();
$idUser=$_SESSION['idUser'];
$TipoUser=$_SESSION['tipouser'];
include_once("../../modelo/php_conexion.php");
include_once("../clases/validaciones.class.php");

if(!empty($_REQUEST["idValidacion"])){
    
    $obCon = new conexion($idUser);
    $idValidacion=$obCon->normalizar($_REQUEST["idValidacion"]);
    switch ($idValidacion){
        case 1: //Verifique si una cuenta RIPS Existe
            $DatosCuentaRIPS["msg"]="OK";
            $obValidacion= new Validacion($idUser);
            $CuentaRIPS=$obCon->normalizar($_REQUEST["CuentaRIPS"]);
            $CuentaRIPS=str_pad($CuentaRIPS, 6, "0", STR_PAD_LEFT);
            $sql="SELECT CuentaRIPS FROM salud_archivo_facturacion_mov_generados WHERE CuentaRIPS='$CuentaRIPS' LIMIT 1";
            $consulta=$obCon->Query($sql);
            $DatosConsulta=$obCon->FetchArray($consulta);
            if($DatosConsulta["CuentaRIPS"]==$CuentaRIPS){
                $DatosCuentaRIPS["msg"]="Error";
            }
                        
            echo json_encode($DatosCuentaRIPS);
        break;
    }
    
}
?>