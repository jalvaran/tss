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
$NombreUsuario=$_SESSION["nombre"]." ".$_SESSION["apellido"];
$css =  new PageConstruct($myTitulo, "");
$css->body("", "hold-transition skin-blue sidebar-mini");

//Cabecera
$css->CrearDiv("wrapper", "", "", 1, 1);
$css->CabeceraIni($myTitulo,"",""); //Inicia la cabecera de la pagina
    //$css->NotificacionMensajes();
    $css->NotificacionTareas();
    $css->NotificacionAlertas();
    $css->InfoCuenta($NombreUsuario);
    //$css->ControlesGenerales();
     
$css->CabeceraFin();

$css->MenuLateralInit();
    
    $css->PanelInfoUser($NombreUsuario);
    $css->PanelBusqueda();
    $css->PanelLateralInit("MENU GENERAL");
        $css->PanelMenuAdministrador();
        $css->PanelModulos();
        
    $css->CPanelLateral();
    
$css->MenuLateralFin();


$css->CrearDiv("principal", "", "left", 1, 1);
    
    $css->CrearDiv("Contenido", "content-wrapper", "", 1, 1);
        //$css->SesionInfoPage("TSS", "Administrador");
        
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
        
        $css->CrearDiv("DivParametrosTablas", "", "", 0, 0);
            $css->CrearInputText("TxtTabla", "text", "", "", "", "", "", "", 300, 30, 0, 0,"1em");
            $css->CrearInputText("TxtCondicion", "text", "", "", "", "", "", "", 300, 30, 0, 0,"1em");
            $css->CrearInputText("TxtOrdenNombreColumna", "text", "", "", "", "", "", "", 300, 30, 0, 0,"1em");
            $css->CrearInputText("TxtOrdenTabla", "text", "", "DESC", "", "", "", "", 300, 30, 0, 0,"1em");
            $css->CrearInputText("TxtLimit", "text", "", "10", "", "", "", "", 300, 30, 0, 0,"1em");
            $css->CrearInputText("TxtPage", "text", "", "1", "", "", "", "", 300, 30, 0, 0,"1em");
        $css->CerrarDiv();    
        print('<div id="tabla">');

        $css->CerrarDiv();
    $css->CerrarDiv();


 
$css->CerrarDiv();
$css->FooterPage();
$css->CrearDiv("DivBarraControles", "", "", 0, 0);
    $css->BarraControles();
$css->CerrarDiv();

$css->AgregaJS();
print('<script src="jsPages/administrador.js"></script>');  
$css->Cbody();
$css->Chtml();

?>