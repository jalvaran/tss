<?php

$myTabla="vista_salud_registro_devoluciones_facturas_reporte";
$idTabla="ID";
$myPage="salud_registro_devoluciones_facturas.php";
$myTitulo="Historial de Devoluciones de Facturas";


/////Asigno Datos necesarios para la visualizacion de la tabla en el formato que se desea
////
///
//print($statement);
$Vector["Tabla"]=$myTabla;          //Tabla
$Vector["Titulo"]=$myTitulo;        //Titulo
$Vector["VerDesde"]=$startpoint;    //Punto desde donde empieza
$Vector["Limit"]=$limit;            //Numero de Registros a mostrar
$Vector["Soporte"]["Link"]=1;   //Indico que esta columna tendra un vinculo
/*
 * Deshabilito Acciones
 * 
 */

        
$Vector["NuevoRegistro"]["Deshabilitado"]=1;            
$Vector["VerRegistro"]["Deshabilitado"]=1;                      
$Vector["EditarRegistro"]["Deshabilitado"]=1; 


/*
 * Datos vinculados
 * 
 */


/*
 * 
 * Requeridos
 */


///Filtros y orden
$Vector["Order"]=" $idTabla DESC ";   //Orden
?>