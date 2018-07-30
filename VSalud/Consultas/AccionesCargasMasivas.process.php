<?php

session_start();
if (!isset($_SESSION['username'])){
  exit("<a href='../index.php' ><img src='../images/401.png'>Iniciar Sesion </a>");
  
}
$idUser=$_SESSION['idUser'];

include_once("../../modelo/php_conexion.php");
include_once("../css_construct.php");
include_once("../clases/GlosasCargasMasivas.class.php");


if( !empty($_REQUEST["idAccion"]) ){
    $css =  new CssIni("id",0);
    $obGlosas = new GlosasMasivas($idUser);
    
    switch ($_REQUEST["idAccion"]) {
        case 1: //Recibe el archivo
            $Fecha=date("Y-m-d");
            $destino='';
            $Name='';
            $Extension="";
            if(!empty($_FILES['UpCargaMasivaGlosas']['name'])){
                
                $info = new SplFileInfo($_FILES['UpCargaMasivaGlosas']['name']);
                $Extension=($info->getExtension());
                $Atras="../";
                $carpeta="SoportesSalud/CargasMasivasGlosas/";
                opendir($Atras.$Atras.$carpeta);
                $Name=str_replace(' ','CargaGlosas_',$Fecha."_".$_FILES['UpCargaMasivaGlosas']['name']);
                $destino=$carpeta.$Name;
                move_uploaded_file($_FILES['UpCargaMasivaGlosas']['tmp_name'],$Atras.$Atras.$destino);
            }
            $obGlosas->RegistreArchivoSubido($Fecha, $destino,$Extension, $idUser);
            print("OK");
        break;
        case 2://Borra la carga del ultimo archivo en caso de errores
            $sql="DELETE FROM salud_control_glosas_masivas WHERE Analizado=0";
            $obGlosas->Query($sql);
            print("Carga Borrada");
        break; 
        case 3://Leer Archivo y llevarlo a la tabla temporal
            
            $obGlosas->LeerArchivo("");
            print("OK");
        break; 
        
        
    }
          
}else{
    print("No se enviaron parametros");
}
?>