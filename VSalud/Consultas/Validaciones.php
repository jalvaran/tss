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
            $obValidacion= new Validacion($idUser);
            $CuentaRIPS=$obCon->normalizar($_REQUEST["CuentaRIPS"]);
            $CuentaRIPS=str_pad($CuentaRIPS, 6, "0", STR_PAD_LEFT);
            $DatosCuentaRIPS=$obCon->DevuelveValores("salud_archivo_ct", "CuentaRIPS", $CuentaRIPS);
            $DatosCuentaRIPS["msg"]="OK";
            
            echo json_encode($DatosCuentaRIPS);
        break;
    }
    
}
?>