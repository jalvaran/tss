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
            $this->html("es","","",$ng_app);
            $this->head();
                print("<meta http-equiv=Content-Type content=text/html charset='UTF-8' />");
                print('<meta http-equiv="X-UA-Compatible" content="IE=edge">');
                print('<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">');
                print("<meta name='description' content='Software de Techno Soluciones'>");
                print("<meta name='author' content='Techno Soluciones SAS'>");
                $this->title();
                print($Titulo);
                $this->Ctitle();
                if($CssFramework==1){
                    print('<link rel="stylesheet" href="../../bower_components/bootstrap/dist/css/bootstrap.min.css">');

                }
                print("<link rel='shortcut icon' href='../../images/technoIco.ico'>");
                print('<link rel="stylesheet" href="../../bower_components/font-awesome/css/font-awesome.min.css">');
                print('<link rel="stylesheet" href="../../bower_components/Ionicons/css/ionicons.min.css">');
                print('<link rel="stylesheet" href="../../bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">');
                print('<link rel="stylesheet" href="../../dist/css/AdminLTE.css">');
                print('<link rel="stylesheet" href="../../dist/css/skins/_all-skins.min.css">');
                print('<link rel="stylesheet" href="../../bower_components/fonts/css.css">');
                print('<link rel="stylesheet" href="../../bower_components/techno/checkts/checkts.css">');
                
                print("<link rel='stylesheet' href='../../bower_components/alertify/themes/alertify.core.css' />");
                print("<link rel='stylesheet' href='../../bower_components/alertify/themes/alertify.default.css' id='toggleCSS' />");


            $this->Chead();
            $this->body("", "hold-transition skin-blue sidebar-mini");
            $this->CrearDiv("wrapper", "", "", 1, 1);
        }
    }   
    
    /**
     * Inicio de la cabecera
     * @param type $Title
     */
    function CabeceraIni($Title,$Link="#",$js=""){
        
        print('
            <header class="main-header">
                <!-- Logo -->
                <a href="../index.php" class="logo">
                  <!-- mini logo for sidebar mini 50x50 pixels -->
                  <span class="logo-mini"><b>T</b>SS</span>
                  <!-- logo for regular state and mobile devices -->
                  <span class="logo-lg"><b>'.$Title.'</b></span>
                </a>
                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top">
                  <!-- Sidebar toggle button-->
                  <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                  </a>
                
               <div class="navbar-custom-menu">            
            <ul class="nav navbar-nav">
            
        ');
    }
	
	
    function CabeceraFin(){

        print('</ul></div></nav></header>');
    }
    
    /**
     * Area para notificacion de Mensajes
     */
    public function NotificacionMensajes() {
        print('<!-- Messages: style can be found in dropdown.less-->
          <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-envelope-o"></i>
              <span class="label label-success">4</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 4 messages</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li><!-- start message -->
                    <a href="#">
                      <div class="pull-left">
                        <img src="../../dist/img/user.png" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        Support Team
                        <small><i class="fa fa-clock-o"></i> 5 mins</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                  <!-- end message -->
                  <li>
                    <a href="#">
                      <div class="pull-left">
                        <img src="../dist/img/user3-128x128.jpg" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        AdminLTE Design Team
                        <small><i class="fa fa-clock-o"></i> 2 hours</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="pull-left">
                        <img src="../dist/img/user4-128x128.jpg" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        Developers
                        <small><i class="fa fa-clock-o"></i> Today</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="pull-left">
                        <img src="../dist/img/user3-128x128.jpg" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        Sales Department
                        <small><i class="fa fa-clock-o"></i> Yesterday</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="pull-left">
                        <img src="../dist/img/user4-128x128.jpg" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        Reviewers
                        <small><i class="fa fa-clock-o"></i> 2 days</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="footer"><a href="#">See All Messages</a></li>
            </ul>
          </li>');
    }
    /**
     * Area para notificacion de Tareas
     */
    public function NotificacionTareas() {
        print('<!-- Tasks: style can be found in dropdown.less -->
          <li class="dropdown tasks-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-flag-o"></i>
              <span id="spTareas" class="label label-danger"></span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">Lista de tareas</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <div id="DivNotificacionTareas">
                  </div>
                  <!-- end task item -->
                </ul>
              </li>
              <li class="footer">
                <a href="#">Ver todas las tareas</a>
              </li>
            </ul>
          </li>');
    }
    /**
     * Area para notificacion de Alertas
     */
    public function NotificacionAlertas() {
        print('<!-- Notifications: style can be found in dropdown.less -->
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span id="spNotificacionAlertas" class="label label-warning"></span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">Notificaciones</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <div id="DivNotificacionAlertas">
                  </div>
                </ul>
              </li>
              <li class="footer"><a href="#">Ver Todas</a></li>
            </ul>
          </li>');
    }
    
    /**
     * Area para salir
     */
    public function InfoCuenta($NombreUsuario) {
        print('<!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="../../dist/img/user.png" class="user-image" alt="User Image">
              <span class="hidden-xs">'.$NombreUsuario.'</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="../../dist/img/user.png" class="img-circle" alt="User Image">

                <p>
                  '.$NombreUsuario.'
                </p>
              </li>
              
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="../../VMenu/Menu.php" class="btn btn-default btn-flat">Inicio</a>
                </div>
                <div class="pull-right">
                  <a href="../../destruir.php" class="btn btn-default btn-flat">Salir</a>
                </div>
              </li>
            </ul>
          </li>');
    }
    /**
     * Inicia todos los elementos de la pagina en general
     * @param type $myTitulo
     */
    public function PageInit($myTitulo) {
        $NombreUsuario=$_SESSION["nombre"];
        $idUser=$_SESSION["idUser"];
        $this->CabeceraIni($myTitulo,"",""); //Inicia la cabecera de la pagina
            //$css->NotificacionMensajes();
        
            $this->NotificacionTareas();
            $this->NotificacionAlertas();
            $this->InfoCuenta($NombreUsuario);
            //$css->ControlesGenerales();

        $this->CabeceraFin();
        $this->ConstruirMenuLateral($idUser, "");
        $this->CrearDiv("principal", "", "left", 1, 1);    
        $this->CrearDiv("Contenido", "content-wrapper", "", 1, 1);
    }
                
    /**
     * Fin de la pagina
     */
    public function PageFin() {
        $this->CerrarDiv();
        $this->FooterPage();
        $this->CrearDiv("DivBarraControles", "", "", 0, 0);
            $this->BarraControles();
        $this->CerrarDiv();
        $this->AgregaJS();
    }
    /**
     * Controles generales del AdminLTE
     */
    public function ControlesGenerales() {
        print('<!-- Control Sidebar Toggle Button -->
                <li>
                  <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li>');
    }
    /**
     * Inicia el menu lateral
     */
    public function MenuLateralInit() {
        print('<aside class="main-sidebar"><section class="sidebar">');
    }
    /**
     * Finaliza el menu lateral
     */
    public function MenuLateralFin() {
        print('</section></aside>');
    }
    /**
     * Panel para visualizar el nombre del usuario
     * @param type $NombreUsuario
     */
    public function PanelInfoUser($NombreUsuario) {
        print('<!-- Sidebar user panel -->
            <div class="user-panel">
              <div class="pull-left image">
                <img src="../../dist/img/user.png" class="img-circle" alt="User Image">
              </div>
              <div class="pull-left info">
                <p>'.$NombreUsuario.'</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
              </div>
            </div>');
    }
    /**
     * Panel de busqueda para uso futuro
     */
    public function PanelBusqueda() {
        print('<!-- search form -->
            <form action="#" method="get" class="sidebar-form">
              <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
                      <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                      </button>
                    </span>
              </div>
            </form>');
    }
    /**
     * Inicia el panel lateral
     * @param type $Titulo
     */
    public function PanelLateralInit($Titulo) {
        print('<!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu" data-widget="tree">
              <li class="header">'.$Titulo.'</li>');
    }
    /**
     * Cierra el panel lateral
     */
    public function CPanelLateral() {
        print('</ul>');
    }
    
    /**
     *Opciones del layout 
     */
    public function PanelLayoutOptions() {
        print('<li class="treeview">
                <a href="#">
                  <i class="fa fa-files-o"></i>
                  <span>Layout Options</span>
                  <span class="pull-right-container">
                    <span class="label label-primary pull-right">4</span>
                  </span>
                </a>
                <ul class="treeview-menu">
                  <li><a href="../layout/top-nav.html"><i class="fa fa-circle-o"></i> Top Navigation</a></li>
                  <li><a href="../layout/boxed.html"><i class="fa fa-circle-o"></i> Boxed</a></li>
                  <li><a href="../layout/fixed.html"><i class="fa fa-circle-o"></i> Fixed</a></li>
                  <li><a href="../layout/collapsed-sidebar.html"><i class="fa fa-circle-o"></i> Collapsed Sidebar</a></li>
                </ul>
              </li>');
    }
    /**
     * Informacion del usuario que inicia sesion
     * @param type $TituloGrande
     * @param type $TituloPequeno
     */
    public function SesionInfoPage($TituloGrande,$TituloPequeno) {
        print('<section class="content-header">
                <h1>
                  '.$TituloGrande.'
                  <small>'.$TituloPequeno.'</small>
                </h1>
                <ol class="breadcrumb">
                  <li><a href="../index.php"><i class="fa fa-dashboard"></i> Inicio</a></li>

                </ol>
              </section>');
    }
    /**
     * Pie de pagina
     */
    public function FooterPage() {
        $anio=date("Y");
        print('<!-- /.content-wrapper -->
            <footer class="main-footer">
              <div class="pull-right hidden-xs">
                <b>Version</b> 2.0
              </div>
              <strong>Copyright &copy; 2006-'.$anio.' <a href="http://technosoluciones.com.co">Techno Soluciones SAS</a>.</strong> All rights
              reserved.
            </footer>');
    }
    /**
     * Barra de controles
     */
    public function BarraControles() {
        print('<!-- Control Sidebar -->
            <aside class="control-sidebar control-sidebar-dark">
              <!-- Create the tabs -->
              <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
                <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
                <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
              </ul>
              <!-- Tab panes -->
              <div class="tab-content">
                <!-- Home tab content -->
                <div class="tab-pane" id="control-sidebar-home-tab">
                  <h3 class="control-sidebar-heading">Recent Activity</h3>
                  <ul class="control-sidebar-menu">
                    <li>
                      <a href="javascript:void(0)">
                        <i class="menu-icon fa fa-birthday-cake bg-red"></i>

                        <div class="menu-info">
                          <h4 class="control-sidebar-subheading">Langdons Birthday</h4>

                          <p>Will be 23 on April 24th</p>
                        </div>
                      </a>
                    </li>
                    <li>
                      <a href="javascript:void(0)">
                        <i class="menu-icon fa fa-user bg-yellow"></i>

                        <div class="menu-info">
                          <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>

                          <p>New phone +1(800)555-1234</p>
                        </div>
                      </a>
                    </li>
                    <li>
                      <a href="javascript:void(0)">
                        <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>

                        <div class="menu-info">
                          <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>

                          <p>nora@example.com</p>
                        </div>
                      </a>
                    </li>
                    <li>
                      <a href="javascript:void(0)">
                        <i class="menu-icon fa fa-file-code-o bg-green"></i>

                        <div class="menu-info">
                          <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>

                          <p>Execution time 5 seconds</p>
                        </div>
                      </a>
                    </li>
                  </ul>
                  <!-- /.control-sidebar-menu -->

                  <h3 class="control-sidebar-heading">Tasks Progress</h3>
                  <ul class="control-sidebar-menu">
                    <li>
                      <a href="javascript:void(0)">
                        <h4 class="control-sidebar-subheading">
                          Custom Template Design
                          <span class="label label-danger pull-right">70%</span>
                        </h4>

                        <div class="progress progress-xxs">
                          <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
                        </div>
                      </a>
                    </li>
                    <li>
                      <a href="javascript:void(0)">
                        <h4 class="control-sidebar-subheading">
                          Update Resume
                          <span class="label label-success pull-right">95%</span>
                        </h4>

                        <div class="progress progress-xxs">
                          <div class="progress-bar progress-bar-success" style="width: 95%"></div>
                        </div>
                      </a>
                    </li>
                    <li>
                      <a href="javascript:void(0)">
                        <h4 class="control-sidebar-subheading">
                          Laravel Integration
                          <span class="label label-warning pull-right">50%</span>
                        </h4>

                        <div class="progress progress-xxs">
                          <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
                        </div>
                      </a>
                    </li>
                    <li>
                      <a href="javascript:void(0)">
                        <h4 class="control-sidebar-subheading">
                          Back End Framework
                          <span class="label label-primary pull-right">68%</span>
                        </h4>

                        <div class="progress progress-xxs">
                          <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
                        </div>
                      </a>
                    </li>
                  </ul>
                  <!-- /.control-sidebar-menu -->

                </div>
                <!-- /.tab-pane -->
                <!-- Stats tab content -->
                <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
                <!-- /.tab-pane -->
                <!-- Settings tab content -->
                <div class="tab-pane" id="control-sidebar-settings-tab">
                  <form method="post">
                    <h3 class="control-sidebar-heading">General Settings</h3>

                    <div class="form-group">
                      <label class="control-sidebar-subheading">
                        Report panel usage
                        <input type="checkbox" class="pull-right" checked>
                      </label>

                      <p>
                        Some information about this general settings option
                      </p>
                    </div>
                    <!-- /.form-group -->

                    <div class="form-group">
                      <label class="control-sidebar-subheading">
                        Allow mail redirect
                        <input type="checkbox" class="pull-right" checked>
                      </label>

                      <p>
                        Other sets of options are available
                      </p>
                    </div>
                    <!-- /.form-group -->

                    <div class="form-group">
                      <label class="control-sidebar-subheading">
                        Expose author name in posts
                        <input type="checkbox" class="pull-right" checked>
                      </label>

                      <p>
                        Allow the user to show his name in blog posts
                      </p>
                    </div>
                    <!-- /.form-group -->

                    <h3 class="control-sidebar-heading">Chat Settings</h3>

                    <div class="form-group">
                      <label class="control-sidebar-subheading">
                        Show me as online
                        <input type="checkbox" class="pull-right" checked>
                      </label>
                    </div>
                    <!-- /.form-group -->

                    <div class="form-group">
                      <label class="control-sidebar-subheading">
                        Turn off notifications
                        <input type="checkbox" class="pull-right">
                      </label>
                    </div>
                    <!-- /.form-group -->

                    <div class="form-group">
                      <label class="control-sidebar-subheading">
                        Delete chat history
                        <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
                      </label>
                    </div>
                    <!-- /.form-group -->
                  </form>
                </div>
                <!-- /.tab-pane -->
              </div>
            </aside>
            <!-- /.control-sidebar -->
            <!-- Add the sidebars background. This div must be placed
                 immediately after the control sidebar -->
            <div class="control-sidebar-bg"></div>');
    }
    
    /**
     * Agrega los JavaScripts Necesarios
     */
    public function AgregaJS(){
        print('<script src="../../bower_components/jquery/dist/jquery.min.js"></script>');
        print('<script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>');
        print('<script src="../../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>');
        print('<script src="../../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>');
        print('<script src="../../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>');
        print('<script src="../../bower_components/fastclick/lib/fastclick.js"></script>');
        print('<script src="../../bower_components/alertify/lib/alertify.min.js"></script>');
        //print('<script src="../../plugins/iCheck/icheck.min.js"></script>');
        print('<script src="../../dist/js/adminlte.min.js"></script>');
        print('<script src="../../dist/js/admintss.js"></script>');
        
       
        //print('<script type="text/javascript" src="../ext/jquery/jquery-1.11.0.min.js"></script>');
        
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
    /**
     * Cierra un div
     */
    function CerrarDiv(){
        print("</div>");
		
    }
    /**
     * Dibuja una tabla desde la base de datos
     * @param type $Titulo
     * @param type $id
     * @param type $Ancho
     * @param type $js
     * @param type $Vector
     */
    function CrearTablaDB($Titulo,$id,$Ancho,$js,$Vector) {
        print('<div class="row">');
        print('<div class="col-lg-12">');
        //print('<div class="panel panel-default">');
        //print('<div class="panel-heading">'.$Titulo.'</div>');
        print('<div class="panel-body">');
        print('<table width="'.$Ancho.'" class="table table-striped table-bordered table-hover" id="'.$id.'" '.$js.'>');
    }
    /**
     * Cabecera para las tablas
     * @param type $Tabla
     * @param type $Limite
     * @param type $Titulo
     * @param type $Columnas
     * @param type $js
     * @param type $TotalRegistros
     * @param type $NumPage
     * @param type $Vector
     */
    function CabeceraTabla($Tabla,$Limite,$Titulo,$Columnas,$js,$TotalRegistros,$NumPage,$Vector){
        $obCon=new conexion(1);
        print("<thead><tr>");
        $ColSpanTitulo=count($Columnas["Field"]);
         
        $this->th("", "", 2, 1, "", "");    
            $this->select("CmbLimit", "form-control", "CmbLimit", "", "", "onchange=CambiarLimiteTablas()", "style=width:200px");
                $Sel=0;
                if($Limite==10){
                    $Sel=1;
                }
                $this->option("", "", "", 10, "", "",$Sel);
                     print("Mostrar 10 Registros");
                $this->Coption();
                $Sel=0;
                if($Limite==25){
                    $Sel=1;
                }
                $this->option("", "", "", 25, "", "",$Sel);
                     print("Mostrar 25 Registros");
                $this->Coption();
                $Sel=0;
                if($Limite==50){
                    $Sel=1;
                }
                $this->option("", "", "", 50, "", "",$Sel);
                     print("Mostrar 50 Registros");
                $this->Coption();
                $Sel=0;
                if($Limite==100){
                    $Sel=1;
                }
                $this->option("", "", "", 100, "", "",$Sel);
                     print("Mostrar 100 Registros");
                $this->Coption();
            $this->Cselect();
        
        $this->Cth();
        $this->th("", "", $ColSpanTitulo-2, 1, "", "");
            print("<strong>$Titulo </strong>");
        $this->Cth();
        $this->tr("", "", 1, 1, "", "");
        foreach ($Columnas["Field"] as $key => $value) {
            
            $NombreColumna=utf8_encode($Columnas["Visualiza"][$key]);
            $this->th("", "", 1, 1, "", "");
                $js="onclick=EscribirEnCaja('TxtOrdenNombreColumna','$value');CambiarOrden();SeleccionarTabla('$Tabla');";
                $this->a("", "", "#", "", "", "", $js);
                    print("<strong>$NombreColumna</strong>");
                $this->Ca();
            $this->Cth();
                
            
        }
        print("</tr></thead>");
    }
    /**
     * Crea una Fila de la tabla
     * @param type $tabla
     * @param type $Datos
     * @param type $js
     * @param type $Vector
     */
    function FilaTablaDB($tabla,$Datos,$js,$Vector){
        $obCon=new conexion(1);
        print('<tr class="odd gradeX">');
        foreach ($Datos as $key => $value) {
            
            $value= utf8_encode($value);
            print("<td>$value</td>");
            
        }
        print("</tr>");
    }
    /**
     * Cierra la tabla
     */
    function CerrarTablaDB() {
        print('</table></div></div></div>');
    }
    /**
     * Crear un input text
     * @param type $nombre
     * @param type $type
     * @param type $label
     * @param type $value
     * @param type $placeh
     * @param type $color
     * @param type $TxtEvento
     * @param type $TxtFuncion
     * @param type $Ancho
     * @param type $Alto
     * @param type $ReadOnly
     * @param type $Required
     * @param type $ToolTip
     * @param type $Max
     * @param type $Min
     * @param type $TFont
     */
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
    /**
     * Crea un input text con un boton al lado
     * @param type $type
     * @param type $idText
     * @param type $idButton
     * @param type $class
     * @param type $name
     * @param type $nameButton
     * @param type $title
     * @param type $titleButton
     * @param type $value
     * @param type $valueButton
     * @param type $placeholder
     * @param type $autocomplete
     * @param type $vectorhtml
     * @param type $Script
     * @param type $ScriptButton
     * @param type $styles
     * @param type $np_app
     */
    public function CrearInputTextButton($type, $idText, $idButton, $class, $name,$nameButton, $title,$titleButton, $value,$valueButton, $placeholder, $autocomplete, $vectorhtml, $Script,$ScriptButton, $styles, $np_app) {
        $this->div("", "input-group", "", "", "", "", "");
            $this->input($type, $idText, $class, $name, $title, $value, $placeholder, $autocomplete, $vectorhtml, $Script, $styles, $np_app);
            $this->span("", "input-group-btn", "", "");
                print('<button id='.$idButton.' type="button" class="btn btn-success btn-flat" '.$ScriptButton.'>'.$valueButton.'</button>');
                //$this->boton($idButton, "btn btn-info btn-flat", "button", $nameButton, $titleButton, $valueButton, "", $ScriptButton);
            $this->Cspan();
        $this->Cdiv();
    }
    
    /**
     * crea un boton con eventos javascript
     * @param type $nombre
     * @param type $value
     * @param type $enabled
     * @param type $evento
     * @param type $funcion
     * @param type $Color
     * @param type $VectorBoton
     */
    function CrearBotonEvento($nombre,$value,$enabled,$evento,$funcion,$Color,$VectorBoton){
            
            switch ($Color){
                case "verde":
                    $Clase="btn btn-success";
                    break;
                case "naranja":
                    $Clase="btn btn-warning";
                    break;
                case "rojo":
                    $Clase="btn btn-danger";
                    break;
                case "blanco":
                    $Clase="btn";
                    break;
                case "azulclaro":
                    $Clase="btn btn-info";
                    break;
                case "azul":
                    $Clase="btn btn-block btn-primary";
                    break;
            }
            if($enabled==1){
                print('<input type="submit" id="'.$nombre.'"  name="'.$nombre.'" value="'.$value.'" '.$evento.'="'.$funcion.' ; return false" class="'.$Clase.'">');
            }else{
                print('<input type="submit" id="'.$nombre.'" disabled="true" name="'.$nombre.'" value="'.$value.'" '.$evento.'="'.$funcion.' ; return false" class="'.$Clase.'">');  
            }
		
		
	}
        /**
         * inicia el Paginador de las tablas
         */
        public function PaginadorTablasInit() {
            print('<div class="col-sm-7">
                    <div class="dataTables_paginate paging_simple_numbers" id="example1_paginate">
                        <ul class="pagination">
                            ');
        }
        /**
         * Pagina anterior
         * @param type $Estado
         * @param type $js
         */
        public function PaginadorAnterior($Estado,$js) {
            
            if($Estado==0){
                $Estado="disabled";
            }else{
                $Estado="";
            }
            print('<li class="paginate_button previous '.$Estado.'" id="example1_previous">
                    <a href="#" aria-controls="example1" data-dt-idx="0" tabindex="0" '.$js.'>Anterior</a>
                   </li>');
        }
        /**
         * Boton del paginador
         * @param type $Estado
         * @param type $Numero
         */
        public function PaginadorBoton($Estado,$Numero) {
            
            if($Estado==1){
                $Estado="active";
            }else{
                $Estado="";
            }
            print('<li class="paginate_button '.$Estado.'">
                    <a href="#" aria-controls="example1" data-dt-idx="1" tabindex="0" onclick=CambiaPagina('.$Numero.')>'.$Numero.'</a>
                </li>');
        }
        
        /**
         * Pagina siguiente
         * @param type $Estado
         * @param type $js
         */
        public function PaginadorSiguiente($Estado,$js) {
            if($Estado==0){
                $Estado="disabled";
            }else{
                $Estado="";
            }
            print('<li class="paginate_button next '.$Estado.'" id="example1_next">
                        <a href="#" aria-controls="example1" data-dt-idx="7" tabindex="0" '.$js.'>Siguiente</a>
                    </li>');
        }
        /**
         * Fin del paginador
         */
        public function PaginadorFin() {
            print('</ul></div></div>');
        }
        /**
         * Paginador para las tablas
         * @param type $Tabla
         * @param type $Limit
         * @param type $PaginaActual
         * @param type $TotalRegistros
         * @param type $Color
         * @param type $js
         * @param type $vector
         */
        public function PaginadorTablas($Tabla,$Limit,$PaginaActual,$TotalRegistros,$vector) {
            $this->div("", "col-lg-12", "", "", "", "", "");
            $this->div("", "btn-group-vertical", "", "", "", "", "");
            
            $Estado="disabled";
            $js="";
            if($PaginaActual<>1){
                $Estado="";
                $js="onclick=RetrocederPagina();";
            }
            $this->input("submit", "BtnRetroceder", "btn btn-block btn-warning btn-xs $Estado", "BtnRetroceder", "Atrás", "Atrás", "", "", "", $js);
            
            $TotalPaginas=ceil($TotalRegistros/$Limit);
            
            $this->select("CmbPage", "btn btn-default btn-xs", "CmbPage", "", "", "onchange=SeleccionaPagina();", "");
            for($i=1;$i<=$TotalPaginas;$i++){
                $Estado=0;
                if($PaginaActual==$i){
                    $Estado=1;
                }
                
                $this->option("", "", $i, $i, "", "",$Estado);
                    print("$i");
                $this->Coption();
            }
            $this->Cselect();
            $Estado="";
            $js="onclick=AvanzarPagina();";
            if($TotalPaginas==$PaginaActual){
                $Estado="disabled";
                $js="";
            }
            $this->input("submit", "BtnAvanzar", "btn btn-block btn-warning btn-xs $Estado", "BtnAvanzar", "Avanzar", "Avanzar", "", "", "", $js);
            $this->Cdiv();
            $this->Cdiv();
        }
        
        /**
         * Construye un Menu general en el panel lateral
         * @param type $Nombre
         * @param type $Clase
         * @param type $Activo
         * @param type $vector
         */
        public function PanelMenuGeneralInit($Nombre,$Clase,$Activo,$vector) {
            if($Activo==1){
                $Activo="active";
            }else{
                $Activo="";
            }
            print('<li class="treeview '.$Activo.'">
                <a href="#">
                  <i class="'.$Clase.'"></i> <span>'.$Nombre.'</span>
                  <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                      </span>
                </a>
                
                ');
        }
        /**
         * Cierra el menu general
         */
        public function PanelMenuGeneralFin() {
            $this->Cli();
        }
        /**
         * Inicia el panel de las pestañas en el menu
         */
        public function PanelPestanaInit() {
            print('<ul class="treeview-menu">');
        }
        /**
         * Pestaña para el menu
         * @param type $Nombre
         * @param type $Clase
         * @param type $vector
         */
        public function PanelPestana($Nombre,$Clase,$vector) {
            print('<li class="treeview">
                    <a href="#"><i class="'.$Clase.'"></i> '.$Nombre.'
                      <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                      </span>
                    </a>
                    
                  ');
        }
        /**
         * Fin de la pestaña
         */
        public function PanelPestanaFin() {
            print('</li></ul>');
                  
        }
        /**
         * inicia el Submenu en el panel  
         */
        public function PanelSubMenuInit() {
            print('<ul class="treeview-menu">');
        }
        /**
         * Finaliza el submenu
         */
        public function PanelSubMenuFin() {
            print('</ul>');
        }
        /**
         * Submenu
         * @param type $Nombre
         * @param type $Link
         * @param type $js
         * @param type $Clase
         */
        public function PanelSubMenu($Nombre,$Link,$js,$Clase) {
            print('<li><a href="'.$Link.'" '.$js.'><i class="'.$Clase.'"></i> '.$Nombre.'</a></li>');
        }
        /**
         * Construye el menu lateral dibujando solo lo que el usuario por su tipo tiene permitido
         * @param type $idUsuario
         * @param type $vector
         */
        public function ConstruirMenuLateral($idUsuario,$vector) {
            $obCon=new conexion($idUsuario);
            $sql="SELECT Nombre,Apellido,Identificacion,TipoUser FROM usuarios WHERE idUsuarios='$idUsuario'";
            $Consulta=$obCon->Query($sql);
            $DatosUsuario=$obCon->FetchAssoc($Consulta);
            $NombreUsuario=$DatosUsuario["Nombre"]." ".$DatosUsuario["Apellido"];
            
            $this->MenuLateralInit();    
                $this->PanelInfoUser($NombreUsuario);
                //$css->PanelBusqueda(); //uso futuro
                $this->PanelLateralInit("MENU GENERAL");
                    $Consulta=$obCon->ConsultarTabla("menu"," WHERE Estado=1 ORDER BY Orden ASC");
                    while($DatosMenu=$obCon->FetchArray($Consulta)){
                        $idMenu=$DatosMenu["ID"];
                        $this->PanelMenuGeneralInit(utf8_encode($DatosMenu["Nombre"]),$DatosMenu["CSS_Clase"],0,"");
                            $ConsultaPestanas=$obCon->ConsultarTabla("menu_pestanas"," WHERE idMenu='$idMenu' AND Estado=1 ORDER BY Orden ASC");
                            $this->PanelPestanaInit();
                            while($DatosPestanas=$obCon->FetchAssoc($ConsultaPestanas)){
                                $idPestana=$DatosPestanas["ID"];
                                $this->PanelPestana(utf8_encode($DatosPestanas["Nombre"]), "fa fa-circle-o text-red", "");
                                $this->PanelSubMenuInit();
                                $ConsultaSubmenus=$obCon->ConsultarTabla("menu_submenus"," WHERE idPestana='$idPestana' AND Estado=1 ORDER BY Orden ASC");
                                while($DatosSubMenu=$obCon->FetchAssoc($ConsultaSubmenus)){
                                    $js="";
                                    $Ruta="#";
                                    $this->PanelSubMenu(utf8_encode($DatosSubMenu["Nombre"]), $Ruta, $DatosSubMenu["JavaScript"], "fa fa-circle-o text-aqua");
                                }
                                $this->PanelSubMenuFin();
                            }
                            $this->PanelPestanaFin();
                            
                        $this->PanelMenuGeneralFin();
                    }
                    
                $this->CPanelLateral();
            $this->MenuLateralFin();
            
        }
        /**
         * Crea una tabla
         */
        public function CrearTabla(){
            print('<div class="table-responsive"><table class="table table-bordered table table-hover" >');		
	}
        
        /**
         * Fila tabla
         * @param type $FontSize
         */
	function FilaTabla($FontSize){
            print('<tr style="font-size:'.$FontSize.'px">');
		
	}
	/**
         * Cierra una Fila de una tabla
         */
	function CierraFilaTabla(){
            print('</tr>');
		
	}
	
	/**
         * Columna de una tabla
         * @param type $Contenido
         * @param type $ColSpan
         * @param type $align-> alineacion: L izquierda, R Derecha, C centro
         */
	function ColTabla($Contenido,$ColSpan,$align="L"){
            if($align=="L"){
              $align="left";  
            }
            if($align=="R"){
              $align="right";  
            }
            if($align=="C"){
              $align="center";  
            }
            print('<td colspan="'.$ColSpan.' " style="text-align:'.$align.'"   >'.$Contenido.'</td>');
		
	}
	/**
         * Cierre columna de tabla
         */
	function CierraColTabla(){
            print('</td>');		
	}
	/**
         * Cierra la tabla
         */
	function CerrarTabla(){
            print('</table></div>');		
	}
        /**
         * Check box con css
         * @param type $Nombre
         * @param type $id
         * @param type $Leyenda
         * @param type $Estado-> 1 para chequeado 0 para no
         * @param type $Habilitado-> 0 para deshabilitar
         * @param type $js->JavaScript
         * @param type $Style
         * @param type $ng_app
         * @param type $vector
         */
        function CheckBoxTS($Nombre,$id,$Leyenda,$Estado,$Habilitado,$js,$Style,$ng_app,$vector) {
            
            if($Estado==1){
                $Estado="checked";
            }else{
                $Estado="";
            }
            
            if($Habilitado==0){
                $Habilitado="disabled";
            }else{
                $Habilitado="";
            }
                        
            print('<label class="checkts">'.$Leyenda.'<input name='.$Nombre.' id='.$id.' type="checkbox" '.$Estado.' '.$Habilitado.' '.$Style.' '.$js.'  '.$ng_app.'><span class="checkmark"></span></label>');        
        }
        
        //////////////////////////////////FIN
}
	
	

?>