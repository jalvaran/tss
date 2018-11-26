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
print('<div id="tabla" style="overflow-x: auto;">');

    print("dsadsa dddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddddd");
$css->CerrarDiv();
$css->CerrarDiv();
$css->AgregaJS();
$css->Cbody();
$css->Chtml();

?>