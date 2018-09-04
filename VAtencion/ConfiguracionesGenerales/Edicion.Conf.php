<?php

$TablaConfig="usuarios";
$Vector[$TablaConfig]["Password"]["TipoText"]="password";


/*
 * Tabla librodiario
 * 
 * Campos Requridos
 */
$TablaConfig="librodiario";
$Vector[$TablaConfig]["Required"]["idEmpresa"]=1;
$Vector[$TablaConfig]["Required"]["idCentroCosto"]=1;

$TablaConfig="usuarios";

$Vector[$TablaConfig]["TipoUser"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector[$TablaConfig]["TipoUser"]["TablaVinculo"]="usuarios_tipo";  //tabla de donde se vincula
$Vector[$TablaConfig]["TipoUser"]["IDTabla"]="Tipo"; //id de la tabla que se vincula
$Vector[$TablaConfig]["TipoUser"]["Display"]="Tipo"; //Columna que quiero mostrar
//$Vector[$TablaConfig]["TipoUser"]["Predeterminado"]="Tipo";
?>