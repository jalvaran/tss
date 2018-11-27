<?php
/**
 * Pagina base para la plataforma TSS
 * 2018-11-27
 * para cambiar el skin base debe realizarse desde la ultima parte en el archivo dist/js/admintss.js
 */
$myPage="admintss.php";
$myTitulo="Plataforma TSS";
include_once("../sesiones/php_control.php");
include_once("../constructores/paginas_constructor.php");

$css =  new PageConstruct($myTitulo, "");
$css->body("", "hold-transition skin-blue sidebar-mini");

//Cabecera
$css->CrearDiv("wrapper", "", "", 1, 1);
$css->CabeceraIni($myTitulo,"",""); //Inicia la cabecera de la pagina
    $css->NotificacionMensajes();
    $css->NotificacionTareas();
    $css->NotificacionAlertas();
    $css->InfoCuenta();
    $css->ControlesGenerales();
     
$css->CabeceraFin();

$css->MenuLateralInit();
    $NombreUsuario="Julian";
    $css->PanelInfoUser($NombreUsuario);
    $css->PanelBusqueda();
    $css->PanelMenuModulos();
    //$css->MenuLateralAdministradores();
$css->MenuLateralFin();


$css->CrearDiv("principal", "container", "left", 1, 1);
    
    $css->CrearDiv("Contenido", "content-wrapper", "", 1, 1);
        $css->SesionInfoPage("TSS", "Administrador");
        
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
        
        $css->CrearInputText("TxtTabla", "text", "", "", "", "", "", "", 300, 30, 0, 0,"1em");
            $css->CrearInputText("TxtCondicion", "text", "", "", "", "", "", "", 300, 30, 0, 0,"1em");
            $css->CrearInputText("TxtOrdenNombreColumna", "text", "", "", "", "", "", "", 300, 30, 0, 0,"1em");
            $css->CrearInputText("TxtOrdenTabla", "text", "", "DESC", "", "", "", "", 300, 30, 0, 0,"1em");
            $css->CrearInputText("TxtLimit", "text", "", "10", "", "", "", "", 300, 30, 0, 0,"1em");
            $css->CrearInputText("TxtPage", "text", "", "1", "", "", "", "", 300, 30, 0, 0,"1em");

            print('<div id="tabla">');

            $css->CerrarDiv();
    $css->CerrarDiv();


 
$css->CerrarDiv();
$css->FooterPage();
$css->CrearDiv("DivBarraControles", "", "", 0, 0);
    $css->BarraControles();
$css->CerrarDiv();
/**
 * $css->div("DivMenuLateral", "", "", "", "", "", "style='display: block;'");
    //$css->CrearDiv("DivMenuLateral", "", "", 1, 1);
    $css->MenuLateral(0);
        $css->MenuLateralAdministradores();
        $css->MenuLateralModulos();        
    $css->CMenuLateral();
    $css->CerrarDiv();
 
//$css->CerrarDiv();
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

print('<script src="jsPages/administrador.js"></script>');     
 * 
 * 
 */

$css->AgregaJS();
print('<script src="jsPages/administrador.js"></script>');  
$css->Cbody();
$css->Chtml();

?>