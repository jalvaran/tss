<?php

session_start();
$idUser=$_SESSION['idUser'];
$TipoUser=$_SESSION['tipouser'];
include_once("../../modelo/php_conexion.php");
include_once("../clases/SaludRips.class.php");


$obCon = new conexion($idUser);
if($_REQUEST["idEPS"]){
    $obRips = new Rips($idUser);
    $idEPS=$obRips->normalizar($_REQUEST["idEPS"]);
    $Separador=$obRips->normalizar($_REQUEST["CmbSeparador"]);
    $TipoNegociacion=$obRips->normalizar($_REQUEST["CmbTipoNegociacion"]);
    $FechaCargue=date("Y-m-d H:i:s");
    $Archivos="";
    if(!empty($_FILES['ArchivosZip']['type'])){
        
        $carpeta="../archivos/";
        opendir($carpeta);
        $NombreArchivo=str_replace(' ','_',$_FILES['ArchivosZip']['name']); 
        
        $Archivos=$obRips->VerificarZip($_FILES['ArchivosZip']['tmp_name'],$idUser, "");
    }
    $Mensaje["msg"]="OK";
    $Mensaje["Archivos"]=$Archivos;
    print(json_encode($Mensaje));
}else{
    $Mensaje["msg"]="Error";
    $Mensaje["error"]="No se ha seleccionado la EPS";
    print(json_encode($Mensaje));
}
    
    

?>