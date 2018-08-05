<?php 
$myPage="SaludGenereRespuestas.php";
include_once("../sesiones/php_control.php");
//include_once("clases/Glosas.class.php");
include_once("css_construct.php");
$obGlosas = new conexion($idUser);
//////Si recibo un cliente
$NumFactura="";

print("<html>");
print("<head>");
$css =  new CssIni("Glosas");

print("</head>");
print("<body>");
  
    
    $css->CabeceraIni("Respuestas"); //Inicia la cabecera de la pagina
    
    $css->CabeceraFin(); 
    ///////////////Creamos el contenedor
    /////
    /////
    
    $css->CrearDiv("DivPrincipal", "container", "center", 1, 1);
    $css->CrearDiv("DivProcess", "container", "center", 1, 1);
    $css->CerrarDiv();
    
    $css->CrearNotificacionAzul("Seleccione el tipo de Respuesta que desea", 16);
    $css->ProgressBar("PgProgresoUp", "LyProgresoCMG", "", 0, 0, 100, 0, "0%", "", "");
    
            $css->CrearTabla();
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>Generar reporte por cuentas</strong>", 1);
                    $css->ColTabla("<strong>Acción</strong>", 1);
                    
                $css->CierraFilaTabla();
                $css->FilaTabla(16);
                    print("<td>");
                        print('<select class="js-example-basic-multiple" name="Cuentas[]" id="Cuentas" multiple="multiple" style=width:900px;>');
                            print('<option value=""></option>');
                        print('</select>');
                        //$css->CrearMultiSelectTable("Cuentas", "vista_salud_cuentas_rips", "", "CuentaRIPS", "CuentaRIPS", "nom_enti_administradora", "", "", "", 1,900);
                    print("</td>");
                    print("<td>");
                        $css->CrearBotonEvento("BtnRespuestaXCuenta", "Generar", 1, "onClick", "EnviarCuentas()", "naranja", "");
                    print("</td>");
                    
                $css->CierraFilaTabla();
            $css->CerrarTabla();
       
        
       
            $css->CrearTabla();
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>Generar reporte por facturas</strong>", 1);
                    $css->ColTabla("<strong>Acción</strong>", 1);
                $css->CierraFilaTabla();
            $css->CerrarTabla();
        
        
        
            $css->CrearTabla();
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>Generar por rango de fecha de Facturas</strong>", 1);
                    $css->ColTabla("<strong>Acción</strong>", 1);
                $css->CierraFilaTabla();
            $css->CerrarTabla();
        
        
        
            $css->CrearTabla();
                $css->FilaTabla(16);
                    $css->ColTabla("<strong>Generar por rango de fecha de Radicado</strong>", 1);
                    $css->ColTabla("<strong>Acción</strong>", 1);
                $css->CierraFilaTabla();
            $css->CerrarTabla();
        
    $css->CrearDiv("DivConsultas", "container", "center", 1, 1);
    $css->CerrarDiv();    
    $css->CerrarDiv();//Cerramos contenedor Principal
    $css->AgregaJS(); //Agregamos javascripts
    $css->AgregaCssJSSelect2(); //Agregamos CSS y JS de Select2
    
    print('<script type="text/javascript" src="jsPages/SaludGenereRespuestas.js"></script>');
    $css->AgregaSubir();
    		
    $css->Footer();
    
    print("</body></html>");
    ob_end_flush();
?>