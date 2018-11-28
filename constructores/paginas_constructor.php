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
                    print('<link rel="stylesheet" href="../bower_components/bootstrap/dist/css/bootstrap.min.css">');

                }
                print("<link rel='shortcut icon' href='../images/technoIco.ico'>");
                print('<link rel="stylesheet" href="../bower_components/font-awesome/css/font-awesome.min.css">');
                print('<link rel="stylesheet" href="../bower_components/Ionicons/css/ionicons.min.css">');
                print('<link rel="stylesheet" href="../bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">');
                print('<link rel="stylesheet" href="../dist/css/AdminLTE.css">');
                print('<link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">');
                print('<link rel="stylesheet" href="../bower_components/fonts/css.css">');
                
                print("<link rel='stylesheet' href='../bower_components/alertify/themes/alertify.core.css' />");
                print("<link rel='stylesheet' href='../bower_components/alertify/themes/alertify.default.css' id='toggleCSS' />");


            $this->Chead();
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
                        <img src="../dist/img/user.png" class="img-circle" alt="User Image">
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
              <img src="../dist/img/user.png" class="user-image" alt="User Image">
              <span class="hidden-xs">'.$NombreUsuario.'</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="../dist/img/user.png" class="img-circle" alt="User Image">

                <p>
                  '.$NombreUsuario.'
                </p>
              </li>
              
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="../VMenu/Menu.php" class="btn btn-default btn-flat">Inicio</a>
                </div>
                <div class="pull-right">
                  <a href="../destruir.php" class="btn btn-default btn-flat">Salir</a>
                </div>
              </li>
            </ul>
          </li>');
    }
    
    public function ControlesGenerales() {
        print('<!-- Control Sidebar Toggle Button -->
                <li>
                  <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li>');
    }
    
    public function MenuLateralInit() {
        print('<aside class="main-sidebar"><section class="sidebar">');
    }
    
    public function MenuLateralFin() {
        print('</section></aside>');
    }
    
    public function PanelInfoUser($NombreUsuario) {
        print('<!-- Sidebar user panel -->
            <div class="user-panel">
              <div class="pull-left image">
                <img src="../dist/img/user.png" class="img-circle" alt="User Image">
              </div>
              <div class="pull-left info">
                <p>'.$NombreUsuario.'</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
              </div>
            </div>');
    }
    
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
    
    public function PanelLateralInit($Titulo) {
        print('<!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu" data-widget="tree">
              <li class="header">'.$Titulo.'</li>');
    }
    
    public function CPanelLateral() {
        print('</ul>');
    }
    
    public function PanelMenuAdministrador() {
        print('<li class="treeview active">
                <a href="#">
                  <i class="fa fa-table"></i> <span>Administrador</span>
                  <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                      </span>
                </a>
                <ul id="DivMenuLateralModulos" class="treeview-menu">
                                       
                </ul>
              </li>');
    }
    
    public function PanelDashboard() {
        print('<li class="treeview">
                <a href="#">
                  <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                  <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
                <ul class="treeview-menu">
                  <li><a href="../index.php"><i class="fa fa-circle-o"></i> Dashboard v1</a></li>
                  <li><a href="../index.php"><i class="fa fa-circle-o"></i> Dashboard v2</a></li>
                </ul>
              </li>');
    }
    
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
    
    public function PanelWidgets() {
        print('<li>
                <a href="../widgets.html">
                  <i class="fa fa-th"></i> <span>Widgets</span>
                  <span class="pull-right-container">
                    <small class="label pull-right bg-green">new</small>
                  </span>
                </a>
              </li>');
    }
    
    public function PanelGraficos() {
        print('<li class="treeview">
                <a href="#">
                  <i class="fa fa-pie-chart"></i>
                  <span>Charts</span>
                  <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                      </span>
                </a>
                <ul class="treeview-menu">
                  <li><a href="../charts/chartjs.html"><i class="fa fa-circle-o"></i> ChartJS</a></li>
                  <li><a href="../charts/morris.html"><i class="fa fa-circle-o"></i> Morris</a></li>
                  <li><a href="../charts/flot.html"><i class="fa fa-circle-o"></i> Flot</a></li>
                  <li><a href="../charts/inline.html"><i class="fa fa-circle-o"></i> Inline charts</a></li>
                </ul>
              </li>');
    }
    
    public function PanelUIElements() {
        print('<li class="treeview">
                <a href="#">
                  <i class="fa fa-laptop"></i>
                  <span>UI Elements</span>
                  <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                      </span>
                </a>
                <ul class="treeview-menu">
                  <li><a href="../UI/general.html"><i class="fa fa-circle-o"></i> General</a></li>
                  <li><a href="../UI/icons.html"><i class="fa fa-circle-o"></i> Icons</a></li>
                  <li><a href="../UI/buttons.html"><i class="fa fa-circle-o"></i> Buttons</a></li>
                  <li><a href="../UI/sliders.html"><i class="fa fa-circle-o"></i> Sliders</a></li>
                  <li><a href="../UI/timeline.html"><i class="fa fa-circle-o"></i> Timeline</a></li>
                  <li><a href="../UI/modals.html"><i class="fa fa-circle-o"></i> Modals</a></li>
                </ul>
              </li>');
    }
    
    public function PanelForms() {
        print('<li class="treeview">
                <a href="#">
                  <i class="fa fa-edit"></i> <span>Forms</span>
                  <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                      </span>
                </a>
                <ul class="treeview-menu">
                  <li><a href="../forms/general.html"><i class="fa fa-circle-o"></i> General Elements</a></li>
                  <li><a href="../forms/advanced.html"><i class="fa fa-circle-o"></i> Advanced Elements</a></li>
                  <li><a href="../forms/editors.html"><i class="fa fa-circle-o"></i> Editors</a></li>
                </ul>
              </li>');
    }
    
    public function PanelCalendario() {
        print('<li>
                <a href="../calendar.html">
                  <i class="fa fa-calendar"></i> <span>Calendar</span>
                  <span class="pull-right-container">
                    <small class="label pull-right bg-red">3</small>
                    <small class="label pull-right bg-blue">17</small>
                  </span>
                </a>
              </li>');
    }
    
    public function PanelMail() {
        print('<li>
                <a href="../mailbox/mailbox.html">
                  <i class="fa fa-envelope"></i> <span>Mailbox</span>
                  <span class="pull-right-container">
                    <small class="label pull-right bg-yellow">12</small>
                    <small class="label pull-right bg-green">16</small>
                    <small class="label pull-right bg-red">5</small>
                  </span>
                </a>
              </li>');
    }
    
    public function PanelPaginas() {
        print('<li class="treeview">
                <a href="#">
                  <i class="fa fa-folder"></i> <span>Examples</span>
                  <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                      </span>
                </a>
                <ul class="treeview-menu">
                  <li><a href="../examples/invoice.html"><i class="fa fa-circle-o"></i> Invoice</a></li>
                  <li><a href="../examples/profile.html"><i class="fa fa-circle-o"></i> Profile</a></li>
                  <li><a href="../examples/login.html"><i class="fa fa-circle-o"></i> Login</a></li>
                  <li><a href="../examples/register.html"><i class="fa fa-circle-o"></i> Register</a></li>
                  <li><a href="../examples/lockscreen.html"><i class="fa fa-circle-o"></i> Lockscreen</a></li>
                  <li><a href="../examples/404.html"><i class="fa fa-circle-o"></i> 404 Error</a></li>
                  <li><a href="../examples/500.html"><i class="fa fa-circle-o"></i> 500 Error</a></li>
                  <li><a href="../examples/blank.html"><i class="fa fa-circle-o"></i> Blank Page</a></li>
                  <li><a href="../examples/pace.html"><i class="fa fa-circle-o"></i> Pace Page</a></li>
                </ul>
              </li>');
    }
    
    public function PanelModulos() {
        print('<li class="treeview">
                <a href="#">
                  <i class="fa fa-share"></i> <span>Módulos</span>
                  <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                      </span>
                </a>
                <ul class="treeview-menu">
                  <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
                  <li class="treeview">
                    <a href="#"><i class="fa fa-circle-o"></i> Level One
                      <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                      </span>
                    </a>
                    <ul class="treeview-menu">
                      <li><a href="#"><i class="fa fa-circle-o"></i> Level Two</a></li>
                      <li class="treeview">
                        <a href="#"><i class="fa fa-circle-o"></i> Level Two
                          <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                          </span>
                        </a>
                        <ul class="treeview-menu">
                          <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
                          <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
                        </ul>
                      </li>
                    </ul>
                  </li>
                  <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
                </ul>
              </li>');
    }
    
    
    public function PanelDocumentacion() {
        print('<li><a href="https://adminlte.io/docs"><i class="fa fa-book"></i> <span>Documentation</span></a></li>');
    }
    
    
    public function PanelLabels() {
        print('<li class="header">LABELS</li>
              <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li>
              <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>
              <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li>
            ');
    }
    
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
        print('<script src="../bower_components/jquery/dist/jquery.min.js"></script>');
        print('<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>');
        print('<script src="../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>');
        print('<script src="../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>');
        print('<script src="../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>');
        print('<script src="../bower_components/fastclick/lib/fastclick.js"></script>');
        print('<script src="../dist/js/adminlte.min.js"></script>');
        print('<script src="../dist/js/admintss.js"></script>');
        
       
        //print('<script type="text/javascript" src="../ext/jquery/jquery-1.11.0.min.js"></script>');
        
    }
    /**
     * Agrega CSS y JS para el objeto Select 2
     */
    public function AgregaCssJSSelect2() {
        print("<link rel='stylesheet' type='text/css' href='../bower_components/select2\dist\css/select2.min.css' />");
        print('<script src="../bower_components/select2\vendor\jquery-2.1.0.js"></script>');
        print('<script src="../bower_components/select2\dist\js/select2.min.js"></script>');     

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
    
    function CrearTablaDB($Titulo,$id,$Ancho,$js,$Vector) {
        print('<div class="row">');
        print('<div class="col-lg-12">');
        //print('<div class="panel panel-default">');
        //print('<div class="panel-heading">'.$Titulo.'</div>');
        print('<div class="panel-body">');
        print('<table width="'.$Ancho.'" class="table table-striped table-bordered table-hover" id="'.$id.'" '.$js.'>');
    }
    
    function CabeceraTabla($Titulo,$Columnas,$js,$Vector){
        $obCon=new conexion(1);
        print("<thead><tr>");
        $ColSpanTitulo=count($Columnas["Field"]);
        $this->th("", "", $ColSpanTitulo, 1, "", "");
        print("<strong>$Titulo<strong>");
        $this->Cth();
        $this->tr("", "", 1, 1, "", "");
        foreach ($Columnas["Field"] as $key => $value) {
            
            $NombreColumna=utf8_encode($Columnas["Visualiza"][$key]);
            $this->th("", "", 1, 1, "", "");
                $js="onclick=EscribirEnCaja('TxtOrdenNombreColumna','$value');CambiarOrden();DibujeTabla();";
                $this->a("", "", "#", "", "", "", $js);
                    print("<strong>$NombreColumna</strong>");
                $this->Ca();
            $this->Cth();
                
            
        }
        print("</tr></thead>");
    }
    
    function FilaTabla($tabla,$Datos,$js,$Vector){
        $obCon=new conexion(1);
        print('<tr class="odd gradeX">');
        foreach ($Datos as $key => $value) {
            
            $value= utf8_encode($value);
            print("<td>$value</td>");
            
        }
        print("</tr>");
    }
    
    function CerrarTablaDB() {
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
    
    public function CrearInputTextButton($type, $idText, $idButton, $class, $name,$nameButton, $title,$titleButton, $value,$valueButton, $placeholder, $autocomplete, $vectorhtml, $Script,$ScriptButton, $styles, $np_app) {
        $this->div("", "input-group", "", "", "", "", "");
            $this->input($type, $idText, $class, $name, $title, $value, $placeholder, $autocomplete, $vectorhtml, $Script, $styles, $np_app);
            $this->span("", "input-group-btn", "", "");
                print('<button id='.$idButton.' type="button" class="btn btn-success btn-flat" '.$ScriptButton.'>'.$valueButton.'</button>');
                //$this->boton($idButton, "btn btn-info btn-flat", "button", $nameButton, $titleButton, $valueButton, "", $ScriptButton);
            $this->Cspan();
        $this->Cdiv();
    }
    
    
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
                    $Clase="btn btn-info";
                    break;
            }
            if($enabled==1){
                print('<input type="submit" id="'.$nombre.'"  name="'.$nombre.'" value="'.$value.'" '.$evento.'="'.$funcion.' ; return false" class="'.$Clase.'">');
            }else{
                print('<input type="submit" id="'.$nombre.'" disabled="true" name="'.$nombre.'" value="'.$value.'" '.$evento.'="'.$funcion.' ; return false" class="'.$Clase.'">');  
            }
		
		
	}
        
        //////////////////////////////////FIN
}
	
	

?>