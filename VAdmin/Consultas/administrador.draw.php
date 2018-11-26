<?php

session_start();
if (!isset($_SESSION['username'])){
  exit("<a href='../index.php' ><img src='../images/401.png'>Iniciar Sesion </a>");
  
}
$idUser=$_SESSION['idUser'];

include_once("../../modelo/php_conexion.php");
include_once("../../constructores/pages_construct.php");

if( !empty($_REQUEST["Accion"]) ){
    $css =  new PageConstruct("", "", 1, "", 1, 0);
    $obCon = new conexion($idUser);
    
    switch ($_REQUEST["Accion"]) {
        case 1: //dibujar la lista de administradores
            $consulta=$obCon->ConsultarTabla("plataforma_administradores", "WHERE Habilitado=1");    
            while($DatosConsulta=$obCon->FetchAssoc($consulta)){
                print('<li><a href="#" onclick="LimpiarFiltros();SeleccionarTabla(`'.$DatosConsulta["Tabla"].'`);">'.$DatosConsulta["Nombre"].'</a></li>');
            }
        break; 
        case 2: //dibuja los datos de la tabla
            $Tabla=$obCon->normalizar($_REQUEST["Tabla"]);
            $Condicion=$obCon->normalizar($_REQUEST["Condicion"]);
            $OrdenColumna=$obCon->normalizar($_REQUEST["OrdenColumna"]);
            $AscDesc=$obCon->normalizar($_REQUEST["Orden"]);
            $NumPage=$obCon->normalizar($_REQUEST["Page"]);
            $limit=$obCon->normalizar($_REQUEST["Limit"]);
            $startpoint = ($NumPage * $limit) - $limit;
            unset($Columnas);
            $Columnas=$obCon->ShowColums($Tabla);
            $idTabla=$Columnas["Field"][0];
            $Condicion;
            if($Condicion<>""){
                $Condicion=" WHERE ".$Condicion;
            }
            if($OrdenColumna==''){
                $OrdenColumna=$idTabla;
            }
            $Orden=" ORDER BY $OrdenColumna $AscDesc ";
            $Limite="LIMIT $startpoint,$limit";
            $js="";
            $css->CrearTabla($Tabla, $Tabla, "100%", $js, "");
                $css->CabeceraTabla($Tabla,$Columnas["Field"], $js, "");
                $idTabla=$Columnas["Field"][0];
                $consulta=$obCon->ConsultarTabla($Tabla, " $Condicion $Orden  $Limite");    
                while($DatosConsulta=$obCon->FetchAssoc($consulta)){
                    $css->FilaTabla($Tabla,$DatosConsulta, "", "");
                }    
            $css->CerrarTabla();
            /*
            $consulta=$obCon->ConsultarTabla("$Tabla", "");    
            while($DatosConsulta=$obCon->FetchAssoc($consulta)){
                print('<li><a href="#" onclick="SeleccionarTabla(`'.$DatosConsulta["Tabla"].'`)">'.$DatosConsulta["Nombre"].'</a></li>');
            }
             * 
             */
        break; 
        
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>