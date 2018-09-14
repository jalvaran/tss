<?php
$myPage="CrearPoliticasAcceso.php";
include_once("../sesiones/php_control.php");

include_once("css_construct.php");
print("<html>");
print("<head>");

$css =  new CssIni("Crear Politicas de Acceso");
print("</head>");
print("<body>");
//Cabecera
$css->CabeceraIni("Crear Politicas de Acceso"); 
    
    
$css->CabeceraFin(); 


$css->CrearDiv("principal", "container", "center",1,1);

    
   $css->CrearDiv("DivTipoUsuario", "", "center", 1, 1);
        $Page="Consultas/Menus.draw.php?idTipo=";
        $FuncionJS="EnvieObjetoConsulta(`$Page`,`CmbTipoUser`,`DivMenusConfig`,`2`);return false;";
        print("<strong>Tipo de Usuario:</strong><br>");
        $css->CrearSelectTable("CmbTipoUser", "usuarios_tipo", " WHERE Tipo<>'administrador'", "ID", "Tipo", "ID", "onChange", $FuncionJS, "", "");
   $css->CerrarDiv();
   $css->CrearDiv("DivMenusConfig", "", "left", 1, 1);
   $css->CerrarDiv();
   

$css->CerrarDiv();//Cerramos contenedor Principal
//$css->Footer();
$css->AgregaJS(); //Agregamos javascripts
//$css->AgregaSubir();    
////Fin HTML  
print("</body></html>");


?>