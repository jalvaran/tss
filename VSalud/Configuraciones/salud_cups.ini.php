<?php

$myTabla="salud_cups";
$idTabla="ID";
$myPage="salud_cups.php";
$myTitulo="CUPS";



/////Asigno Datos necesarios para la visualizacion de la tabla en el formato que se desea
////
///
//print($statement);
$Vector["Tabla"]=$myTabla;          //Tabla
$Vector["Titulo"]=$myTitulo;        //Titulo
$Vector["VerDesde"]=$startpoint;    //Punto desde donde empieza
$Vector["Limit"]=$limit;            //Numero de Registros a mostrar

/*
 * Deshabilito Acciones
 * 
 */

$Vector["Excluir"]["fecha_hora_registro"]=1;   //Indico que esta columna no se mostrará
$Vector["Excluir"]["user"]=1;   //Indico que esta columna no se mostrará
       
$Vector["VerRegistro"]["Deshabilitado"]=1; 
///Filtros y orden
$Vector["Order"]=" $idTabla DESC ";   //Orden
?>