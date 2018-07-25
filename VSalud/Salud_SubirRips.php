<?php 
$myPage="Salud_SubirRips.php";
include_once("../sesiones/php_control.php");
include_once("clases/SaludRips.class.php");
include_once("css_construct.php");
$obVenta = new conexion($idUser);
$obRips = new Rips($idUser);
//////Si recibo un cliente

	
print("<html>");
print("<head>");
$css =  new CssIni("Archivos Internos");

print("</head>");
print("<body>");
       
    $css->CabeceraIni("Subir RIPS"); //Inicia la cabecera de la pagina
    
    //////////Creamos el formulario de busqueda de remisiones
    /////
    /////
    
   
    
    $css->CabeceraFin(); 
    ///////////////Creamos el contenedor
    /////
    /////
    $css->CrearDiv("principal", "container", "center",1,1);
    //include_once("procesadores/Salud_SubirRips.process.php");
    print("<br>");
    
    
    ///////////////Se crea el DIV que servirá de contenedor secundario
    /////
    /////
    $css->CrearInputText("Parar", "hidden", "", 0, "", "", "", "", 100, 30, 0, 1);
     $css->CrearDiv("Secundario", "container", "center",1,1);
     $css->CrearDiv("DivConsultas", "container", "center", 1, 1);
    $css->CerrarDiv();
    
    //////////////////////////Se dibujan los campos para la anulacion de la factura
    /////
    /////
    $css->CrearNotificacionAzul("Suba los archivos", 16);
        //$css->CrearForm2("FrmArchivosZip", $myPage, "post", "_self");
        $css->CrearTabla();
            $css->FilaTabla(16);
                $css->ColTabla("<strong>SUBIR RIPS EN .ZIP</strong>", 4);
            $css->CierraFilaTabla();
            $css->FilaTabla(16);
                $css->ColTabla("<strong>EPS *</strong>", 1);
                $css->ColTabla("<strong>Fecha de Radicado *</strong>", 1);
                $css->ColTabla("<strong>No. de Radicado *</strong>", 1);
                $css->ColTabla("<strong>Cuenta Global</strong>", 1);
                $css->ColTabla("<strong>Escenario *</strong>", 1);
            $css->CierraFilaTabla(); 
            $css->FilaTabla(16);
                print("<td>");
                    $css->CrearTableChosen("idEPS", "salud_eps", "", "cod_pagador_min", "nombre_completo", "nit", "cod_pagador_min", 200, 1, "EPS", "");
                    $TxtFuncion="ValidaCuentaRIPS();";
                    print("<br><br>");
                    $css->CrearInputText("CuentaRIPS", "text", "", "", "CuentaRIPS", "", "onBlur", $TxtFuncion, 200, 30, 0, 1);
                print("</td>");
                print("<td>");
                    $css->CrearInputText("FechaRadicado", "date", "", date("Y-m-d"), "Fecha Radicado", "", "", "", 150, 30, 0, 1);
              
                print("</td>");
                print("<td>");
                    $css->CrearInputText("NumeroRadicado", "text", "", "", "No. Radicado", "", "", "", 150, 30, 0, 1);
                print("</td>");
                print("<td>");
                    $css->CrearInputText("CuentaGlobal", "text", "", "", "CuentaGlobal", "", "", "", 150, 30, 0, 1);
                print("</td>");
                print("<td>");
                    $css->CrearSelect("CmbEscenario", "");
                        $css->CrearOptionSelect("NA", "No Aplica", 1);
                        $css->CrearOptionSelect("PYP", "P Y P", 0);
                        $css->CrearOptionSelect("Recuperacion", "Recuperacion", 0);
                    $css->CerrarSelect();
                print("</td>");
            $css->CierraFilaTabla();     
            $css->FilaTabla(16);
                
                $css->ColTabla("<strong>Soporte Radicado</strong>", 1);
                $css->ColTabla("<strong>Separador *</strong>", 1);
                $css->ColTabla("<strong>Tipo de Negociacion *</strong>", 1);
                $css->ColTabla("<strong>ZIP *</strong>", 1);
                $css->ColTabla("<strong>Enviar</strong>", 1);
            $css->CierraFilaTabla();   
            $css->FilaTabla(16);
                print("<td>");
                    $css->CrearUpload("UpSoporteRadicado");
                print("</td>");
                print("<td>");
                    $css->CrearSelect("CmbSeparador", "",200);
                    $css->CrearOptionSelect("", "Selecciones el Separador de los archivos", 0);
                    $css->CrearOptionSelect(1, "punto y coma (;)", 0);
                    $css->CrearOptionSelect(2, "Coma (,)", 1);
                $css->CerrarSelect();
                print("</td>");
                print("<td>");
                    $css->CrearSelect("CmbTipoNegociacion", "",200);
                    $css->CrearOptionSelect("", "Tipo de Negociacion", 0);
                    $css->CrearOptionSelect("evento", "Evento", 0);
                    $css->CrearOptionSelect("capita", "Capita", 0);
                $css->CerrarSelect();
                print("</td>");
                print("<td>");
                    $css->CrearUpload("ArchivosZip");
                print("</td>");
                print("<td>");
                    $js="onClick=submitInfo();";
                    $css->CrearBotonEvento("BtnSubirZip", "Enviar", 1, "onclick", $js, "naranja", "");
                   // $css->CrearBotonNaranja("BtnSubirZip", "Subir",$js);
                print("</td>");
                
               
            $css->CierraFilaTabla();   
            $css->CerrarTabla();
        //$css->CerrarForm();
            
    $css->CerrarDiv();//Cerramos contenedor Secundario
    
    $css->CerrarDiv();//Cerramos contenedor Principal
    $css->AgregaJS(); //Agregamos javascripts
    print('<script type="text/javascript" src="jsPages/Salud_SubirRips.js"></script>');
    $css->AgregaSubir();
    $css->Footer();
    print("</body></html>");
    ob_end_flush();
?>