<?php
include_once("../../modelo/php_conexion.php");

$obCon=new conexion(1);

if(isset($_REQUEST['Login'])){
    $key=$obCon->normalizar($_REQUEST['Login']);
    $sql="SELECT Login FROM usuarios WHERE Login LIKE '$key'";
    $consulta=$obCon->Query($sql);
    $Datos=$obCon->FetchArray($consulta);
    if($Datos["Login"]<>''){
        print("Error");
    }else{
        print("OK");
    }
}
