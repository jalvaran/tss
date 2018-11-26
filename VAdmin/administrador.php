<?php
$myPage="administrador.php";
$myTitulo="Administrador TSS";
include_once("../sesiones/php_control.php");

include_once("../constructores/pages_construct.php");

$css =  new PageConstruct($myTitulo, "");
$css->body("");
//Cabecera
$css->CrearDiv("wrapper", "", "", 1, 1);
$css->CabeceraIni($myTitulo); //Inicia la cabecera de la pagina
    $css->NotificacionTareas();
    $css->NotificacionAlertas();
    $css->Logout();
    $css->CrearDiv("DivMenuLateral", "", "", 1, 1);
    $css->MenuLateral(1);
        $css->MenuLateralAdministradores();
        $css->MenuLateralModulos();        
    $css->CMenuLateral();
    $css->CerrarDiv();
$css->CabeceraFin(); 
$css->CerrarDiv();

$css->CrearDiv("page-wrapper", "", "", 1, 1);
$css->CrearInputText("TxtTabla", "text", "", "", "", "", "", "", 300, 30, 0, 0,"1em");
$css->CrearInputText("TxtCondicion", "text", "", "", "", "", "", "", 300, 30, 0, 0,"1em");
$css->CrearInputText("TxtOrdenNombreColumna", "text", "", "", "", "", "", "", 300, 30, 0, 0,"1em");
$css->CrearInputText("TxtOrdenTabla", "text", "", "DESC", "", "", "", "", 300, 30, 0, 0,"1em");
$css->CrearInputText("TxtLimit", "text", "", "10", "", "", "", "", 300, 30, 0, 0,"1em");
$css->CrearInputText("TxtPage", "text", "", "1", "", "", "", "", 300, 30, 0, 0,"1em");

print('<div id="tabla" style="overflow-x: auto;">');

$css->CerrarDiv();
$css->CerrarDiv();
$css->AgregaJS();
print('<script src="jsPages/administrador.js"></script>');     
$css->Cbody();
$css->Chtml();

?>