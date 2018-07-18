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
    

    $css->CrearDiv("principal", "container", "center",1,1);
    //Modal Glosas
    $Titulo="Buscar";
    $Nombre="ImgBuscar";
    $RutaImage="../images/buscar.png";
    $javascript="";
    $VectorBim["f"]=0;
    $target="#DialBusquedaGlosas";
    $css->CrearBotonImagen($Titulo,$Nombre,$target,"","",1,1,"fixed","right:10px;bottom:80",$VectorBim);
    
    $css->CrearCuadroDeDialogo("DialBusquedaGlosas","Buscar Glosa");
    $css->CrearTabla();
    
    
        $css->FilaTabla(16);
            print("<td>");
            $css->CrearInputText("CajaAsigna", "hidden", "", "", "", "", "", "", 100, 30, 0, 0);
                $VarSelect["Ancho"]="200";
                $VarSelect["PlaceHolder"]="Conceptos Glosas";
                $VarSelect["Required"]=1;
                $css->CrearSelectChosen("CmbGlosas", $VarSelect);
                $css->CrearOptionSelect("", "Seleccione una Glosas" , 1);
                    $sql="SELECT * FROM salud_archivo_conceptos_glosas";
                    $Consulta=$obGlosas->Query($sql);
                    while($DatosGlosas=$obGlosas->FetchArray($Consulta)){

                           $css->CrearOptionSelect("$DatosGlosas[cod_glosa]", "$DatosGlosas[cod_glosa] / $DatosGlosas[descrpcion_concep_especifico] / $DatosGlosas[aplicacion]" , 0);
                       }

                $css->CerrarSelect();
            print("</td>");
            print("<td>");
                $funcion="CopiarCodigoGlosa();ClickElement('ImgBuscar');";
                $css->CrearBotonEvento("BtnAsignar", "Asignar", 1, "onClick", $funcion, "naranja", "");    
            print("</td>");
        $css->CierraFilaTabla();
    $css->CerrarTabla();
       
        
        print("<br> <br> <br> <br> <br> <br> <br> <br><br><br><br><br><br>");
    $css->CerrarCuadroDeDialogo();
    
    $css->CrearTabla();
    $css->FilaTabla(16);
        $css->ColTabla("<strong>Opciones de Busqueda</strong>", 4);
    $css->CierraFilaTabla();
        $css->FilaTabla(16);
            $css->ColTabla("<strong>EPS</strong>", 1);
            $css->ColTabla("<strong>Factura</strong>", 1);
            $css->ColTabla("<strong>Cuenta RIPS</strong>", 1);
            $css->ColTabla("<strong>Cuenta Global</strong>", 1);
        $css->CierraFilaTabla();
        $css->FilaTabla(16);
            print("<td>");
                $Page="Consultas/BuscarFacturasDiferencias.php?st= &idEPS=";
                $FuncionJS="EnvieObjetoConsulta(`$Page`,`idEps`,`DivFacturasDif`,`5`);return false ;";
                //$css->CrearSelectTable("idEps", "salud_eps", " ORDER BY nombre_completo", "cod_pagador_min", "nombre_completo", "cod_pagador_min", "onchange", $FuncionJS, "", 1,"Seleccione una EPS");
                $css->CrearTableChosen("idEps", "salud_eps", " ORDER BY nombre_completo", "cod_pagador_min", "nombre_completo", "cod_pagador_min", "cod_pagador_min", 300, 1, "EPS", "");
                $css->CrearBotonEvento("BtnMostrar", "Buscar", 1, "onClick", "EnvieObjetoConsulta(`$Page`,`idEps`,`DivDatosFactura`,``);return false;", "naranja", "");
            print("</td>"); 
            print("<td>");
            
                $Page="Consultas/BuscarFacturasDiferencias.php?idFactura=";
                $css->CrearInputText("TxtBuscarFact","text","","","Factura","black","onchange","EnvieObjetoConsulta(`$Page`,`TxtBuscarFact`,`DivFacturasDif`,`5`);return false;",200,30,0,0);
        
            print("</td>");
            print("<td>");
            
                $Page="Consultas/BuscarFacturasDiferencias.php?idFactura=";
                $css->CrearInputText("TxtBuscarCuentaRIPS","text","","","Cuenta RIPS","black","onchange","EnvieObjetoConsulta(`$Page`,`TxtBuscarFact`,`DivFacturasDif`,`5`);return false;",200,30,0,0);
        
            print("</td>");
            print("<td>");
            
                $Page="Consultas/BuscarFacturasDiferencias.php?idFactura=";
                $css->CrearInputText("TxtBuscarCuentaGlobal","text","","","Cuenta Global","black","onchange","EnvieObjetoConsulta(`$Page`,`TxtBuscarFact`,`DivFacturasDif`,`5`);return false;",200,30,0,0);
        
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
            $css->CrearDiv("DivCuentas", "", "center", 1, 1);
            $css->CerrarDiv();
        print("</td>");
        $css->CierraFilaTabla();
        $css->FilaTabla(16);
        print("<td colspan=4>");
            $css->CrearNotificacionNaranja("Detalle de Facturas", 16);
            $css->CrearDiv("DivCuentas", "", "center", 1, 1);
            $css->CerrarDiv();
        print("</td>");
       $css->CierraFilaTabla();
    $css->CerrarTabla();
    
    $css->CrearDiv("DivDatosFactura", "", "center", 1, 1);
    
    $css->CerrarDiv();
            
    $css->CerrarDiv();//Cerramos contenedor Principal
    $css->AgregaJS(); //Agregamos javascripts
    $css->AnchoElemento("CmbGlosas_chosen", 420);
    $css->AgregaSubir();
    $css->Footer();
    if(isset($_REQUEST["idFactura"])){
        $idFactura=$obGlosas->normalizar($_REQUEST["idFactura"]);
        
        $Page="Consultas/SaludFacturasGlosas.php?idFactura=$idFactura&t=";
        print("<script>EnvieObjetoConsulta(`$Page`,`idEps`,`DivDatosFactura`,``);</script>");

    }
    print("</body></html>");
    ob_end_flush();
?>