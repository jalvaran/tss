<?php

session_start();
if (!isset($_SESSION['username'])){
  exit("<a href='../index.php' ><img src='../images/401.png'>Iniciar Sesion </a>");
  
}
$idUser=$_SESSION['idUser'];

include_once("../clases/administrador.class.php");
include_once("../../constructores/paginas_constructor.php");

if( !empty($_REQUEST["Accion"]) ){
    $css =  new PageConstruct("", "", 1, "", 1, 0);
    $obCon = new Administrador($idUser);
    
    switch ($_REQUEST["Accion"]) {
        case 1: //dibujar la lista de administradores
            //$consulta=$obCon->ConsultarTabla("plataforma_administradores", "WHERE Habilitado=1");
            $consulta=$obCon->ConsultarTabla("menu_submenus", "WHERE Estado=1 AND idMenu=1");
            while($DatosConsulta=$obCon->FetchAssoc($consulta)){
               
                print('<li><a href="#" onclick="LimpiarFiltros();SeleccionarTabla(`'.$DatosConsulta["TablaAsociada"].'`);"><i class="fa fa-circle-o"></i> '.$DatosConsulta["Nombre"].'</a></li>');
            }
        break; 
        case 2: //dibuja los datos de la tabla
            $Tabla=$obCon->normalizar($_REQUEST["Tabla"]);
            $Condicion=$obCon->normalizar($_REQUEST["Condicion"]);
            $OrdenColumna=$obCon->normalizar($_REQUEST["OrdenColumna"]);
            $AscDesc=$obCon->normalizar($_REQUEST["Orden"]);
            $NumPage=$obCon->normalizar($_REQUEST["Page"]);
            $limit=$obCon->normalizar($_REQUEST["Limit"]);
            
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
            //print($sql);
            //print_r($ColumnasSeleccionadas["Field"]);
            $Orden=" ORDER BY $OrdenColumna $AscDesc ";
            $Limite="LIMIT $startpoint,$limit";
            $js="";
            $Seleccion="";
            $QueryCompleto=$sql." ".$Condicion." ".$Orden." ".$Limite;
            
            $css->CrearTabla($Tabla, $Tabla, "100%", $js, "");
                $css->CabeceraTabla($TituloTabla,$ColumnasSeleccionadas, $js, "");
                
                $consulta=$obCon->Query($QueryCompleto);
                //$consulta=$obCon->ConsultarTabla($Tabla, " $Condicion $Orden  $Limite");    
                while($DatosConsulta=$obCon->FetchAssoc($consulta)){
                    $css->FilaTabla($Tabla,$DatosConsulta, "", "");
                }    
            $css->CerrarTabla();
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
            
            $css->select("CmbColumna", "form-control", "CmbColumna", "Buscar: ", "", $js,"style=width:Auto");
            foreach ($Columnas["Field"] as $key => $value) {
                $css->option("", "", $value, $value, "", "");
                    print(utf8_encode($Columnas["Visualiza"][$key]));
                $css->Coption();
            }
            $css->Cselect();
            
            $css->select("CmbCondicion", "form-control", "CmbCondicion", " ", "", $js,"style=width:Auto");
                $value="=";
                $css->option("", "", $value, $value, "", "");
                    print($value);
                $css->Coption();
            
            $css->Cselect();
            
        break; 
    }
    
    
          
}else{
    print("No se enviaron parametros");
}
?>