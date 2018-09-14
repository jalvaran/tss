<?php

$TablaConfig="salud_archivo_conceptos_glosas";
$Vector[$TablaConfig]["cod_concepto_general"]["Excluir"]=1;
$Vector[$TablaConfig]["descripcion_concepto_general"]["Excluir"]=1;
$Vector[$TablaConfig]["tipo_concepto_general"]["Excluir"]=1;
$Vector[$TablaConfig]["aplicacion_concepto_general"]["Excluir"]=1;

$TablaConfig="usuarios";
$Vector[$TablaConfig]["Password"]["TipoText"]="password";
$Vector[$TablaConfig]["Excluir"]["Role"]=1;

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

$TablaConfig="empresapro";

$Vector[$TablaConfig]["Regimen"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector[$TablaConfig]["Regimen"]["TablaVinculo"]="empresapro_regimenes";  //tabla de donde se vincula
$Vector[$TablaConfig]["Regimen"]["IDTabla"]="Regimen"; //id de la tabla que se vincula
$Vector[$TablaConfig]["Regimen"]["Display"]="Regimen"; //Columna que quiero mostrar
/*
$Vector[$TablaConfig]["Ciudad"]["Vinculo"]=1;   //Indico que esta columna tendra un vinculo
$Vector[$TablaConfig]["Ciudad"]["TablaVinculo"]="cod_municipios_dptos";  //tabla de donde se vincula
$Vector[$TablaConfig]["Ciudad"]["IDTabla"]="Ciudad"; //id de la tabla que se vincula
$Vector[$TablaConfig]["Ciudad"]["Display"]="Ciudad"; //Columna que quiero mostrar
 * 
 */
?>