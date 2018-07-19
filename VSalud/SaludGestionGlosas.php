<?php 
$myPage="SaludGestionGlosas.php";
include_once("../sesiones/php_control.php");
include_once("clases/Glosas.class.php");
include_once("css_construct.php");
$obGlosas = new Glosas($idUser);
//////Si recibo un cliente
$NumFactura="";

print("<html>");
print("<head>");
$css =  new CssIni("Glosas");

print("</head>");
print("<body>");
  
    
    $css->CabeceraIni("Glosas"); //Inicia la cabecera de la pagina
    
    $css->CabeceraFin(); 
    ///////////////Creamos el contenedor
    /////
    /////
    $css->CrearDiv("DivButtons", "", "", 0, 0);
    
        $css->CreaBotonDesplegable("DialFacturasDetalle", "Abrir","BtnModalFacturas");
        $css->CreaBotonDesplegable("ModalGlosar", "Abrir","BtnModalGlosar");
        
    $css->CerrarDiv();
    
    $css->CrearCuadroDeDialogoAmplio("DialFacturasDetalle", "Actividades de esta factura");
        $css->CrearDiv("DivDetallesUsuario", "container", "center", 1, 1);
        $css->CerrarDiv();
        $css->CrearDiv("DivActividadesFacturas", "container", "center", 1, 1);
        $css->CerrarDiv();
    $css->CerrarCuadroDeDialogoAmplio();
    
    $css->CrearModal("ModalGlosar", "Glosar", "");
        $css->CrearDiv("DivGlosar", "", "center", 1, 1);
        $css->CerrarDiv();
    $css->CerrarModal();
    
    $css->CrearDiv("principal", "container", "center",1,1);
    
    $css->CrearTabla();
    $css->FilaTabla(16);
        $css->ColTabla("<strong>Opciones de Busqueda</strong>", 2);
        print("<td colspan=2>");
            print("<strong>Carga Masiva: </strong>");
            $css->CrearUpload("UpCargaMasiva");
            
            $css->CrearBotonEvento("BtnEnviarCargaMasiva", "Cargar", 1, "onClick", "EnviarCargaMasiva()", "rojo", "");
        print("</td>");
    $css->CierraFilaTabla();
        $css->FilaTabla(16);
            $css->ColTabla("<strong>EPS</strong>", 1);
            $css->ColTabla("<strong>Factura</strong>", 1);
            $css->ColTabla("<strong>X Cuentas</strong>", 1);
            $css->ColTabla("<strong>Estado de Glosas</strong>", 1);
        $css->CierraFilaTabla();
        $css->FilaTabla(16);
            print("<td>");
                $css->CrearTableChosen("idEPS", "salud_eps", " ORDER BY nombre_completo", "cod_pagador_min", "nombre_completo", "cod_pagador_min", "cod_pagador_min", 300, 1, "EPS", "");
                $css->CrearBotonEvento("BtnMostrar", "Buscar", 1, "onClick", "BuscarCuentaXCriterio(5)", "naranja", "");
            print("</td>"); 
            print("<td>");
            
                $css->CrearInputText("TxtBuscarFact","text","","","Factura","black","onChange","BuscarCuentaXCriterio(1)",200,30,0,0);
        
            print("</td>");
            print("<td>");
            
                $css->CrearInputText("TxtBuscarCuentaRIPS","text","","","Cuenta RIPS","black","onChange","BuscarCuentaXCriterio(2)",150,30,0,0);
                $css->CrearInputText("TxtBuscarCuentaGlobal","text","","","Cuenta Global","black","onChange","BuscarCuentaXCriterio(3)",150,30,0,0);
        
            print("</td>");
            print("<td>");
            
                $css->CrearSelectTable("CmdEstadoGlosa", "salud_estado_glosas", "", "ID", "ID", "Estado_glosa", "onChange", "BuscarCuentaXCriterio(4)", "", 0);
                
            print("</td>");
            
        $css->CierraFilaTabla();
        $css->FilaTabla(16);
        
        print("<td colspan=4>");
            $css->CrearNotificacionAzul("Cuentas", 16);
            $css->CrearDiv("DivCuentas", "", "center", 1, 1);
            $css->CerrarDiv();
        print("</td>");
        $css->CierraFilaTabla();
        $css->FilaTabla(16);
        print("<td colspan=4>");
            $css->CrearNotificacionVerde("Facturas", 16);
            $css->CrearDiv("DivFacturas", "", "center", 1, 1);
            $css->CerrarDiv();
        print("</td>");
        $css->CierraFilaTabla();
        $css->FilaTabla(16);
        print("<td colspan=4>");
            $css->CrearNotificacionNaranja("Detalle de Facturas", 16);
            $css->CrearDiv("DivActividades", "", "center", 1, 1);
            $css->CerrarDiv();
        print("</td>");
       $css->CierraFilaTabla();
    $css->CerrarTabla();
              
    $css->CerrarDiv();//Cerramos contenedor Principal
    $css->AgregaJS(); //Agregamos javascripts
   
    print('<script type="text/javascript" src="jsPages/Glosas.js"></script>');
    $css->AgregaSubir();
    $css->Footer();
    
    print("</body></html>");
    ob_end_flush();
?>