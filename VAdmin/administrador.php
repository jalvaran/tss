<?php
$myPage="administrador.php";
$myTitulo="Menú TSS";
include_once("../sesiones/php_control.php");

include_once("../constructores/pages_construct.php");

$css =  new PageConstruct($myTitulo, "");
$css->body("");
//Cabecera
$css->CrearDiv("wrapper", "", "", 1, 1);
$css->CabeceraIni($myTitulo,"#","onclick=MuestraOcultaMenu()"); //Inicia la cabecera de la pagina
    $css->NotificacionTareas();
    $css->NotificacionAlertas();
    $css->Logout();
    
    $css->div("DivMenuLateral", "", "", "", "", "", "style='display: block;'");
    //$css->CrearDiv("DivMenuLateral", "", "", 1, 1);
    $css->MenuLateral(0);
        $css->MenuLateralAdministradores();
        $css->MenuLateralModulos();        
    $css->CMenuLateral();
    $css->CerrarDiv();
     
$css->CabeceraFin(); 
$css->CerrarDiv();
$css->CrearDiv("principal", "container", "left", 1, 1);
$css->CrearDiv("DivOpcionesTablas", "", "left", 1, 1);
    
    $css->CrearDiv("DivOpciones1", "col-sm-4", "left", 1, 1);
        
    $css->CerrarDiv();
    $css->CrearDiv("DivOpciones2", "col-sm-2", "left", 1, 1);
    
    $css->CerrarDiv();
    $css->CrearDiv("DivOpciones3", "col-sm-2", "left", 1, 1);
    
    $css->CerrarDiv();
    $css->CrearDiv("DivOpciones4", "col-sm-4", "left", 1, 1);
    
    $css->CerrarDiv();
$css->CerrarDiv();

$css->CerrarDiv();
$css->CrearDiv("page-wrapper", "", "", 1, 1);
$css->CrearInputText("TxtTabla", "text", "", "", "", "", "", "", 300, 30, 0, 0,"1em");
$css->CrearInputText("TxtCondicion", "text", "", "", "", "", "", "", 300, 30, 0, 0,"1em");
$css->CrearInputText("TxtOrdenNombreColumna", "text", "", "", "", "", "", "", 300, 30, 0, 0,"1em");
$css->CrearInputText("TxtOrdenTabla", "text", "", "DESC", "", "", "", "", 300, 30, 0, 0,"1em");
$css->CrearInputText("TxtLimit", "text", "", "10", "", "", "", "", 300, 30, 0, 0,"1em");
$css->CrearInputText("TxtPage", "text", "", "1", "", "", "", "", 300, 30, 0, 0,"1em");

print('<div id="tabla">');

$css->CerrarDiv();
$css->CerrarDiv();
$css->AgregaJS();
print('<script src="jsPages/administrador.js"></script>');     
$css->Cbody();
$css->Chtml();

?>