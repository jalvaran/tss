<?php
include_once 'html_estruct_class.php';
if(file_exists('../../modelo/php_conexion.php')){
    include_once '../../modelo/php_conexion.php';
}
/**
 * Description of pages_construct Clase para generar paginas
 *
 * @author Julian Andres Alvaran
 */	

class PageConstruct extends html_estruct_class{
    /**
     * Constructor
     * @param type $Titulo ->Titulo de la pagina
     * @param type $ng_app ->Se define si se desea ingresar un modulo del framework angular
     * @param type $Vector -> uso futuro
     */
    function __construct($Titulo,$Vector,$Angular='',$ng_app='',$CssFramework=1,$Inicializar=1){
        if($Inicializar==1){
            $this->tipo_html();
            $this->html("es",$ng_app,"",$ng_app);
            $this->head();
                print("<meta http-equiv=Content-Type content=text/html charset='UTF-8' />");
                print("<meta name='viewport' content='width=device-width, initial-scale=1.0'>");
                print("<meta name='description' content='Software de Techno Soluciones'>");
                print("<meta name='author' content='Techno Soluciones SAS'>");
                print("<title>$Titulo</title>");
                if($CssFramework==1){
                    print('<link href="../ext/bootstrap/css/bootstrap.min.css" rel="stylesheet">');

                }
                print("<link rel='shortcut icon' href='../images/technoIco.ico'>");
                print('<link href="../ext/metisMenu/metisMenu.min.css" rel="stylesheet">');
                print('<link href="../ext/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">');
                print('<link href="../ext/datatables-responsive/dataTables.responsive.css" rel="stylesheet">');
                print('<link href="../ext/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">');
                print('<link href="../dist/css/sb-admin-2.css" rel="stylesheet">');

                print("<link rel='stylesheet' href='../ext/alertify/themes/alertify.core.css' />");
                print("<link rel='stylesheet' href='../ext/alertify/themes/alertify.default.css' id='toggleCSS' />");


            $this->Chead();
        }
    }   
    
    /**
     * Inicio de la cabecera
     * @param type $Title
     */
    function CabeceraIni($Title){
        
        print('<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="../VMenu/Menu.php">'.$Title.'</a>
            </div> 
            
            <ul class="nav navbar-top-links navbar-right">
            
        ');
    }
	
	
    function CabeceraFin(){

        print('</ul></nav>');
    }
    /**
     * Area para notificacion de Tareas
     */
    public function NotificacionTareas() {
        print('<!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" >
                        <i class="fa fa-tasks fa-fw"></i><span id="spanNumTareas" class="label label-warning"></span> <i class="fa fa-caret-down"></i>
                    </a>
                    
                    <ul class="dropdown-menu dropdown-tasks">
                    
                        <li class="divider"></li>
                        <div id="DivNotificacionTareas">
                            <div class="alert alert-success fade in" align="center" style="font-size:14px">
                                <strong>No hay tareas pendientes</strong>
                            </div>    
                        </div>
                    </ul>
                    <!-- /.dropdown-tasks -->
                </li>');
    }
    /**
     * Area para notificacion de Mensajes
     */
    public function NotificacionMensajes() {
        print('<!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" >
                        <i class="fa fa-envelope fa-fw"></i><span id="spanNumMensajes" class="label label-success"></span> <i class="fa fa-caret-down"></i>
                    </a>
                    
                    <ul class="dropdown-menu dropdown-tasks">
                    
                        <li class="divider"></li>
                        <div id="DivNotificacionMensajes">
                            <div class="alert alert-success fade in" align="center" style="font-size:14px">
                                <strong>No hay Mensajes pendientes</strong>
                            </div>    
                        </div>
                    </ul>
                    <!-- /.dropdown-tasks -->
                </li>');
    }
    
    /**
     * Area para notificacion de Alertas
     */
    public function NotificacionAlertas() {
        print('<!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" >
                        <i class="fa fa-bell fa-fw"></i><span id="spanNumTareas" class="label label-danger"></span> <i class="fa fa-caret-down"></i>
                    </a>
                    
                    <ul class="dropdown-menu dropdown-alerts">
                    
                        <li class="divider"></li>
                        <div id="DivNotificacionTareas">
                            <div class="alert alert-success fade in" align="center" style="font-size:14px">
                                <strong>No hay Alertas</strong>
                            </div>    
                        </div>
                    </ul>
                    <!-- /.dropdown-tasks -->
                </li>');
    }
    
    /**
     * Area para salir
     */
    public function Logout() {
        print('<!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" >
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">                        
                        <li><a href="../destruir.php"><i class="fa fa-sign-out fa-fw"></i> Salir</a>
                    </li>
                    </ul>
                    
                    <!-- /.dropdown-tasks -->
                </li></ul>');
    }
    
    public function MenuLateral(){
        
        print('<div class="navbar-default sidebar" role="navigation">');
        print('<div class="sidebar-nav navbar-collapse">');
            print('<ul class="nav" id="side-menu">');
                
            
        
    }
    
    public function MenuLateralModulos() {
        print('<li><a href="#"><i class="fa fa-dashboard fa-fw"></i> Módulos<span class="fa arrow"></span></a>
        <ul class="nav nav-second-level">
            <div id="DivMenuLateralModulos">
                
            </div>    
        </ul></li>');
    }
    
    public function MenuLateralAdministradores() {
        print('<li><a href="#"><i class="fa fa-table fa-fw"></i> Administradores<span class="fa arrow"></span></a>
        <ul class="nav nav-second-level">
            <div id="DivMenuLateralModulos">
                
            </div>    
        </ul></li>');
    }
    
    public function CMenuLateral() {
        print('</ul>');
        print("</div></div>");
    }
    /**
     * Agrega los JavaScripts Necesarios
     */
    public function AgregaJS(){
        print('<script src="../ext/jquery/jquery.min.js"></script>');
        print('<script src="../ext/bootstrap/js/bootstrap.min.js"></script>');
        print('<script src="../ext/metisMenu/metisMenu.min.js"></script>');
        print('<script src="../ext/datatables/js/jquery.dataTables.min.js"></script>');
        print('<script src="../ext/datatables-plugins/dataTables.bootstrap.min.js"></script>');
        print('<script src="../ext/datatables-responsive/dataTables.responsive.js"></script>');
        print('<script src="../dist/js/sb-admin-2.js"></script>');
        print('<script src="../ext/alertify/lib/alertify.min.js"></script>');
        //print('<script type="text/javascript" src="../ext/jquery/jquery-1.11.0.min.js"></script>');
        
    }
    /**
     * Agrega CSS y JS para el objeto Select 2
     */
    public function AgregaCssJSSelect2() {
        print("<link rel='stylesheet' type='text/css' href='../ext/select2\dist\css/select2.min.css' />");
        print('<script src="../ext/select2\vendor\jquery-2.1.0.js"></script>');
        print('<script src="../ext/select2\dist\js/select2.min.js"></script>');     

    }
    /**
     * Crea una barra de progreso
     * @param type $NombreBarra -> Nombre
     * @param type $NombreLeyenda -> Nombre de la leyenda
     * @param type $Tipo
     * @param type $Valor
     * @param type $Min
     * @param type $Max
     * @param type $Ancho
     * @param type $Leyenda
     * @param type $Color
     * @param type $Vector
     */
    public function ProgressBar($NombreBarra,$NombreLeyenda,$Tipo,$Valor,$Min,$Max,$Ancho,$Leyenda,$Color,$Vector) {
        print('<div class="progress">
                <div id="'.$NombreBarra.'" name="'.$NombreBarra.'" class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="'.$Valor.'" aria-valuemin="'.$Min.'" aria-valuemax="'.$Max.'" style="width:'.$Ancho.'%">
                  <div id="'.$NombreLeyenda.'" name="'.$NombreLeyenda.'"">'.$Leyenda.'</div>
                </div>
              </div>');
    }
    
    /**
     * Crear un Div 
     * @param type $ID->ID del DIV
     * @param type $Class-> Clase del div
     * @param type $Alineacion-> Alineacion
     * @param type $Visible-> 1 para hacer visible 0 para no hacerlo visible
     * @param type $Habilitado-> Habilitar
     * @param type $ng_angular-> Controladores de angular
     * @param type $Styles-> Mas estilos
     */
    function CrearDiv($ID, $Class, $Alineacion,$Visible,$Habilitado,$ng_angular='',$Styles=""){
        if($Visible==1)
            $V="block";
        else
            $V="none";

        if($Habilitado==1) ///pensado a futuro, aun no esta en uso
            $H="true";
        else
            $H="false";
        print("<div id='$ID' class='$Class' align='$Alineacion' style='display:$V;$Styles' $ng_angular>");

    }
    
    function CerrarDiv(){
        print("</div>");
		
    }
    
    function CrearTabla($Titulo,$id,$Ancho,$js,$Vector) {
        print('<div class="row">');
        print('<div class="col-lg-12">');
        //print('<div class="panel panel-default">');
        //print('<div class="panel-heading">'.$Titulo.'</div>');
        print('<div class="panel-body">');
        print('<table width="'.$Ancho.'" class="table table-striped table-bordered table-hover" id="'.$id.'" '.$js.'>');
    }
    
    function CabeceraTabla($tabla,$Columnas,$js,$Vector){
        $obCon=new conexion(1);
        print("<thead><tr>");
        foreach ($Columnas as $key => $value) {
            $Consulta=$obCon->ConsultarTabla("tablas_campos_control", "WHERE NombreTabla='$tabla' AND Campo='$value' AND Visible=0");
            $DatosExcluidas=$obCon->FetchAssoc($Consulta);
            if($DatosExcluidas["ID"]==''){
                $DatosNombres=$obCon->DevuelveValores("configuraciones_nombres_campos", "NombreDB", $value);
                $NombreColumna=$value;
                if($DatosNombres["ID"]<>""){
                    $NombreColumna=utf8_encode($DatosNombres["Visualiza"]);
                    $this->th("", "", 1, 1, "", "");
                    $js="onclick=EscribirEnCaja('TxtOrdenNombreColumna','$value');CambiarOrden();DibujeTabla();";
                    $this->a("", "", "#", "", "", "", $js);
                    print($NombreColumna);
                    $this->Ca();
                $this->Cth();
                }
                
                
            }
            
        }
        print("</tr></thead>");
    }
    
    function FilaTabla($tabla,$Datos,$js,$Vector){
        $obCon=new conexion(1);
        print('<tr class="odd gradeX">');
        foreach ($Datos as $key => $value) {
            $Consulta=$obCon->ConsultarTabla("tablas_campos_control", "WHERE NombreTabla='$tabla' AND Campo='$key' AND Visible=0");
            $DatosExcluidas=$obCon->FetchAssoc($Consulta);
            if($DatosExcluidas["ID"]==''){
                $value= utf8_encode($value);
                print("<td>$value</td>");
            }
        }
        print("</tr>");
    }
    
    function CerrarTabla() {
        print('</table></div></div></div>');
    }
    
    function CrearInputText($nombre,$type,$label,$value,$placeh,$color,$TxtEvento,$TxtFuncion,$Ancho,$Alto,$ReadOnly,$Required,$ToolTip='Rellena este Campo',$Max="",$Min="",$TFont='1em'){
		   
        if($ReadOnly==1)
                $ReadOnly="readonly";
        else
                $ReadOnly="";

        if($Required==1)
                $Required="required";
        else
                $Required="";
        
        $JavaScript=$TxtEvento.' = '.$TxtFuncion;
        $OtrasOpciones="";
        if($Max<>''){
            $OtrasOpciones="max=$Max min=$Min";
        }

        print('<strong style="color:'.$color.'">'.$label.'<input name="'.$nombre.'" class="form-control" value="'.$value.'" type="'.$type.'" id="'.$nombre.'" '.$OtrasOpciones.' placeholder="'.$placeh.'" '.$JavaScript.' 
        '.$ReadOnly.' '.$Required.' autocomplete="off" style="width: '.$Ancho.'px;height: '.$Alto.'px; font-size: '.$TFont.' ;data-toggle="tooltip" title="'.$ToolTip.'" "></strong>');

    }
    
        //////////////////////////////////FIN
}
	
	

?>