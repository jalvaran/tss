<?php

$myTabla="empresapro";
$idTabla="idEmpresaPro";
$myPage="empresapro.php";
$myTitulo="Empresas";



/////Asigno Datos necesarios para la visualizacion de la tabla en el formato que se desea
////
///
//print($statement);
$Vector["Tabla"]=$myTabla;          //Tabla
$Vector["Titulo"]=$myTitulo;        //Titulo
$Vector["VerDesde"]=$startpoint;    //Punto desde donde empieza
$Vector["Limit"]=$limit;            //Numero de Registros a mostrar


$Vector["Ciudad"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector["Ciudad"]["TablaVinculo"]="cod_municipios_dptos";  //tabla de donde se vincula
$Vector["Ciudad"]["IDTabla"]="Ciudad"; //id de la tabla que se vincula
$Vector["Ciudad"]["Display"]="Ciudad"; 
/*
 * Deshabilito Acciones
 * 
 */

        
$Vector["VerRegistro"]["Deshabilitado"]=1; 
///Filtros y orden
$Vector["Order"]=" $idTabla DESC ";   //Orden
?>