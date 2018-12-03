<?php

session_start();
if (!isset($_SESSION['username'])){
  exit("<a href='../../index.php' ><img src='../images/401.png'>Iniciar Sesion </a>");
  
}
$idUser=$_SESSION['idUser'];

include_once("../clases/administrador.class.php");
include_once("../../../constructores/paginas_constructor.php");

if( !empty($_REQUEST["idAccion"]) ){
    $css =  new PageConstruct("", "", 1, "", 1, 0);
    $obCon = new Administrador($idUser);
    
    switch ($_REQUEST["idAccion"]) {
        
        case 1: //insertar datos en una tabla
            $Tabla=$obCon->normalizar($_REQUEST["Tabla"]);            
            $Columnas=$obCon->getColumnasVisibles($Tabla, ""); 
            foreach($Columnas["Field"] as $key => $value) {
                if($key>0){
                    $Datos[$value]=$obCon->normalizar($_REQUEST["$value"]);   
                    if($value=="Password"){
                        $Datos[$value]= md5($obCon->normalizar($_REQUEST["$value"]));
                    }
                    
                }
            }
            $sql=$obCon->getSQLInsert($Tabla, $Datos);
            $obCon->Query($sql);
            
            print("OK");
            
        break; 
         
        
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>