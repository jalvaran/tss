<?php

/*
 * Tabla Usuarios
 * Tipo de Texto
 */
$TablaConfig="usuarios";
$VarInsert[$TablaConfig]["Password"]["TipoText"]="password";
$VarInsert[$TablaConfig]["Nombre"]["Required"]=1;
$VarInsert[$TablaConfig]["Apellido"]["Required"]=1;
$VarInsert[$TablaConfig]["Identificacion"]["Required"]=1;
$VarInsert[$TablaConfig]["Telefono"]["Required"]=1;
$VarInsert[$TablaConfig]["Login"]["Required"]=1;
$VarInsert[$TablaConfig]["Password"]["Required"]=1;
$VarInsert[$TablaConfig]["TipoUser"]["Required"]=1;

$TablaConfig="empresa_pro";

$VarInsert[$TablaConfig]["RazonSocial"]["Required"]=1;
$VarInsert[$TablaConfig]["NIT"]["Required"]=1;
$VarInsert[$TablaConfig]["CodigoPrestadora"]["Required"]=1;
$VarInsert[$TablaConfig]["Direccion"]["Required"]=1;
$VarInsert[$TablaConfig]["Telefono"]["Required"]=1;
$VarInsert[$TablaConfig]["Celular"]["Required"]=1;
$VarInsert[$TablaConfig]["Ciudad"]["Required"]=1;

$VarInsert[$TablaConfig]["ResolucionDian"]["Required"]=1;
$VarInsert[$TablaConfig]["Regimen"]["Required"]=1;
$VarInsert[$TablaConfig]["Email"]["Required"]=1;
$VarInsert[$TablaConfig]["WEB"]["Required"]=1;


?>