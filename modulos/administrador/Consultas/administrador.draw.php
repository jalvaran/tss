<?php

session_start();
if (!isset($_SESSION['username'])){
  exit("<a href='../../index.php' ><img src='../images/401.png'>Iniciar Sesion </a>");
  
}
$idUser=$_SESSION['idUser'];

include_once("../clases/administrador.class.php");
include_once("../../../constructores/paginas_constructor.php");

if( !empty($_REQUEST["Accion"]) ){
    $css =  new PageConstruct("", "", 1, "", 1, 0);
    $obCon = new Administrador($idUser);
    
    switch ($_REQUEST["Accion"]) {
        case 1: //dibujar la lista de administradores
            //$consulta=$obCon->ConsultarTabla("plataforma_administradores", "WHERE Habilitado=1");
            $consulta=$obCon->ConsultarTabla("menu_submenus", "WHERE Estado=1 AND idMenu=1");
            while($DatosConsulta=$obCon->FetchAssoc($consulta)){               
                print('<li><a href="#" onclick="DibujeTabla(`'.$DatosConsulta["TablaAsociada"].'`);"><i class="fa fa-circle-o"></i> '.$DatosConsulta["Nombre"].'</a></li>');
            }
        break; 
        case 2: //dibuja los datos de la tabla
            $Tabla=$obCon->normalizar($_REQUEST["Tabla"]);
            $Condicion=$obCon->normalizar($_REQUEST["Condicion"]);
            $OrdenColumna=$obCon->normalizar($_REQUEST["OrdenColumna"]);
            $AscDesc=$obCon->normalizar($_REQUEST["Orden"]);
            $NumPage=$obCon->normalizar($_REQUEST["Page"]);
            $limit=$obCon->normalizar($_REQUEST["Limit"]);
            $Condicion= utf8_decode($Condicion);
            $DatosSubMenu=$obCon->DevuelveValores("menu_submenus", "TablaAsociada", $Tabla);
            $TituloTabla=$DatosSubMenu["Nombre"];
            $startpoint = ($NumPage * $limit) - $limit;
            $ColumnasSeleccionadas=$obCon->getColumnasVisibles($Tabla, "");
            
            $idTabla=$ColumnasSeleccionadas["Field"][0];
            //print_r($ColumnasSeleccionadas);
            if($Condicion<>""){
                $Condicion=" WHERE ".$Condicion;
            }
            if($OrdenColumna==''){
                $OrdenColumna=$idTabla;
            }
            $sql="SELECT ";
            foreach ($ColumnasSeleccionadas["Field"] as $key => $value) {
                $sql.="$value,";
            }
            $sql = substr($sql, 0, -1);
            $sql = $sql." FROM $Tabla ";
            
            $sqlConteo="SELECT COUNT(*) as TotalRegistros FROM $Tabla $Condicion";
            $consulta=$obCon->Query($sqlConteo);
            $DatosConteo=$obCon->FetchAssoc($consulta);
            $TotalRegistros=$DatosConteo["TotalRegistros"];
            
            $Orden=" ORDER BY $OrdenColumna $AscDesc ";
            $Limite="LIMIT $startpoint,$limit";
            $js="";
            $Seleccion="";
            $QueryCompleto=$sql." ".$Condicion." ".$Orden." ".$Limite;
            
            if($TotalRegistros>$limit){                
                $css->PaginadorTablas($Tabla, $limit, $NumPage, $TotalRegistros, "");
            }
            
            $css->CrearTablaDB($Tabla, $Tabla, "100%", $js, "");
            
                $css->CabeceraTabla($Tabla,$limit,$TituloTabla,$ColumnasSeleccionadas, $js,$TotalRegistros,$NumPage, "");
                
                $consulta=$obCon->Query($QueryCompleto);
                //$consulta=$obCon->ConsultarTabla($Tabla, " $Condicion $Orden  $Limite");    
                while($DatosConsulta=$obCon->FetchAssoc($consulta)){
                    $css->FilaTabla($Tabla,$DatosConsulta, "", "");
                }    
            $css->CerrarTablaDB();
            
            
            /*
            $consulta=$obCon->ConsultarTabla("$Tabla", "");    
            while($DatosConsulta=$obCon->FetchAssoc($consulta)){
                print('<li><a href="#" onclick="SeleccionarTabla(`'.$DatosConsulta["Tabla"].'`)">'.$DatosConsulta["Nombre"].'</a></li>');
            }
             * 
             */
        break; 
        case 3: //dibujar los filtros
            
            $Tabla=$obCon->normalizar($_REQUEST["Tabla"]); 
            $Columnas=$obCon->getColumnasVisibles($Tabla, "");
                   
            $js="";
            
            $css->fieldset("fBuscar", "", "fBuscar", "", "Buscar", "");
            $css->legend("", "");
                print("<a href='#' onclick='MuestraOcultaXID(`DivBusquedasTablas`)'>Buscar</a>");
            $css->Clegend();   
            $css->CrearDiv("DivBusquedasTablas", "", "", 0, 0);
            $css->select("CmbColumna", "form-control", "CmbColumna", "", "", $js,"style=width:Auto");
            foreach ($Columnas["Field"] as $key => $value) {
                $css->option("", "", $value, $value, "", "");
                    print(utf8_encode($Columnas["Visualiza"][$key]));
                $css->Coption();
            }
            $css->Cselect();
            
            $css->select("CmbCondicion", "form-control", "CmbCondicion", " ", "", $js,"style=width:Auto");
                $value="=";
                $Display="=";
                $css->option("", "", $value, $Display, "", "");
                    print($value);
                $css->Coption();
                
                $value="*";
                $Display="*";
                $css->option("", "", $value, $Display, "", "");
                    print($value);
                $css->Coption();
                
                $value=">";
                $Display=">";
                $css->option("", "", $value, $Display, "", "");
                    print($value);
                $css->Coption();
                
                $value="<";
                $Display="<";
                $css->option("", "", $value, $Display, "", "");
                    print($value);
                $css->Coption();
                
                
                $value=">=";
                $Display=">=";
                $css->option("", "", $value, $Display, "", "");
                    print($value);
                $css->Coption();
                
                
                $value="<=";
                $Display="<=";
                $css->option("", "", $value, $Display, "", "");
                    print($value);
                $css->Coption();
                
                $value="#%";
                $Display="#%";
                $css->option("", "", $value, $Display, "", "");
                    print($value);
                $css->Coption();
                
                $value="<>";
                $Display="<>";
                $css->option("", "", $value, $Display, "", "");
                    print($value);
                $css->Coption();
                    
            $css->Cselect();
            //$css->input("text", "TxtBusquedaTablas", "form-control", "TxtBusquedaTablas", "Valor", "", "", "", "", "");
            $Script="";
            
            $ScriptButton="onclick='AgregaCondicional()'";
            //$Script="onchange='AgregaCondicional()'";
            $css->CrearInputTextButton("text", "TxtBusquedaTablas", "BtnBuscarEnTabla", "form-control", "TxtBusquedaTablas", "BtnBuscarEnTabla", "Buscar", "Buscar", "", "Buscar", "", "", "", $Script, $ScriptButton, "", "");
            
            $css->CrearDiv("DivFiltrosAplicados", "", "", 1, 1);
                    
            $css->CerrarDiv();
            
            $css->CerrarDiv();
            
            $css->Cfieldset();
            
            
        break; 
        
        case 4: //Acciones
            $Tabla=$obCon->normalizar($_REQUEST["Tabla"]); 
            $Columnas=$obCon->getColumnasVisibles($Tabla, "");
                   
            $js="";
            
            $css->fieldset("fAcciones", "", "fAcciones", "", "Acciones", "");
            $css->legend("", "");
                print("<a href='#' onclick='MuestraOcultaXID(`DivAccionesTablas`)'>Acciones</a>");
            $css->Clegend();   
            $css->CrearDiv("DivAccionesTablas", "", "", 0, 0);
            
            $css->select("CmbAccionTabla", "form-control", "CmbAccionTabla", " ", "", $js,"style=width:Auto");
                $value="SUM";
                $Display="SUMAR";
                $css->option("", "", $Display,$value, "", "");
                    print($Display);
                $css->Coption();
                
                $value="COUNT";
                $Display="CONTAR";
                $css->option("", "", $Display,$value, "", "");
                    print($Display);
                $css->Coption();
                
                $value="AVG";
                $Display="PROMEDIAR";
                $css->option("", "", $Display,$value, "", "");
                    print($Display);
                $css->Coption();
                
                $value="MAX";
                $Display="MAXIMO";
                $css->option("", "", $Display,$value, "", "");
                    print($Display);
                $css->Coption();
                
                $value="MIN";
                $Display="MINIMO";
                $css->option("", "", $Display,$value, "", "");
                    print($Display);
                $css->Coption();
                
                
            $css->Cselect();    
            $css->select("CmbColumnaAcciones", "form-control", "CmbColumnaAcciones", "", "", $js,"style=width:Auto");
            foreach ($Columnas["Field"] as $key => $value) {
                $css->option("", "", $value, $value, "", "");
                    print(utf8_encode($Columnas["Visualiza"][$key]));
                $css->Coption();
            }
            $css->Cselect();
            
            $Script="";
            
            $ScriptButton="ConsultaAccionesTablas()";
            $css->CrearBotonEvento("BtnAccionTabla", "Ejecutar", 1, "onclick", $ScriptButton, "verde", "");
            $css->CrearDiv("DivResultadosAcciones", "", "", 1, 1);
                    
            $css->CerrarDiv();
            
            $css->CerrarDiv();
            
            $css->Cfieldset();
        break;
        
        case 5: //Realiza las consultas solicitadas
            $Tabla=$obCon->normalizar($_REQUEST["Tabla"]); 
            $Columna=$obCon->normalizar($_REQUEST["Columna"]); 
            $AccionTabla=$obCon->normalizar($_REQUEST["AccionTabla"]); 
            $CondicionActual=$obCon->normalizar($_REQUEST["CondicionActual"]); 
            $ColumnaSeleccionada=$obCon->normalizar($_REQUEST["ColumnaSeleccionada"]); 
            $TxtAccionSeleccionada=$obCon->normalizar($_REQUEST["TxtAccionSeleccionada"]); 
            $Condicion="";
            if($CondicionActual<>''){
                $Condicion=" WHERE $CondicionActual";
            }
            $sql="SELECT $AccionTabla($Columna) AS Resultado FROM $Tabla $Condicion";
            //print($sql);
            
            $Consulta=$obCon->Query($sql);
            $DatosConsulta=$obCon->FetchAssoc($Consulta);
            if(is_numeric($DatosConsulta["Resultado"])){
                $Resultado=number_format($DatosConsulta["Resultado"],2);
            }else{
                $Resultado=$DatosConsulta["Resultado"];
            }
            $Mensaje='<i class="fa fa-circle-o text-red"></i><span> '.$TxtAccionSeleccionada;
            $Mensaje.=" ".$ColumnaSeleccionada." = ".$Resultado;
            $Mensaje.="</span><br>";
            print($Mensaje);
             
            break;
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>