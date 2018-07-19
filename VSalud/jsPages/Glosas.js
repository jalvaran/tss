/**
 * Controlador para la gestion de glosas
 * JULIAN ALVARAN 2018-07-19
 * TECHNO SOLUCIONES SAS EN ASOCIACION CON SITIS SA
 * 317 774 0609
 */


/**
 * Buscar una cuenta RIPS por diferentes criterios
 * @param {type} event
 * @returns {undefined}
 */
function BuscarCuentaXCriterio(Criterio=1){
  document.getElementById("DivCuentas").innerHTML='<div id="GifProcess">Procesando...<br><img   src="../images/cargando.gif" alt="Cargando" height="100" width="100"></div>';
         
  var form_data = new FormData();
     if(Criterio==1){//Si se busca por numero de factura
         form_data.append('idFactura', $('#TxtBuscarFact').val());
         MostrarFacturas('',$('#TxtBuscarFact').val());
         document.getElementById("TxtBuscarCuentaGlobal").value="";
         document.getElementById("TxtBuscarCuentaRIPS").value="";
         document.getElementById("CmdEstadoGlosa").value="";
         document.getElementById("idEPS").value="";
         
     }
     if(Criterio==2){//Si se busca por Cuenta RIPS
         form_data.append('CuentaRIPS', $('#TxtBuscarCuentaRIPS').val());
         document.getElementById("TxtBuscarCuentaGlobal").value="";
         document.getElementById("TxtBuscarFact").value="";
         document.getElementById("CmdEstadoGlosa").value="";
         document.getElementById("idEPS").value="";
         
     } 
     if(Criterio==3){//Si se busca por Cuenta Global
         form_data.append('CuentaGlobal', $('#TxtBuscarCuentaGlobal').val());
         document.getElementById("TxtBuscarCuentaRIPS").value="";
         document.getElementById("TxtBuscarFact").value="";
         document.getElementById("CmdEstadoGlosa").value="";
         document.getElementById("idEPS").value="";
         
     }
     if(Criterio==4){//Si se busca por Estado de GLosa 
         form_data.append('CmdEstadoGlosa', $('#CmdEstadoGlosa').val());
         document.getElementById("TxtBuscarCuentaRIPS").value="";
         document.getElementById("TxtBuscarFact").value="";
         document.getElementById("TxtBuscarCuentaGlobal").value="";
         document.getElementById("idEPS").value="";
         
     }
     if(Criterio==5){//Si se busca por EPS
         form_data.append('idEPS', $('#idEPS').val());
         document.getElementById("TxtBuscarCuentaRIPS").value="";
         document.getElementById("TxtBuscarFact").value="";
         document.getElementById("TxtBuscarCuentaGlobal").value="";
         document.getElementById("CmdEstadoGlosa").value="";
         
     }
  $.ajax({
    url: './Consultas/vista_salud_cuentas_rips.search.php',
    //dataType: 'json',
    cache: false,
    contentType: false,
    processData: false,
    data: form_data,
    type: 'post',
    success: function(data){
        console.log(data)
      if (data != "") { 
          document.getElementById('DivCuentas').innerHTML=data;
                  
      }else {
        alert("No hay resultados para la consulta");
      }
    },
    error: function (xhr, ajaxOptions, thrownError) {
        alert(xhr.status);
        alert(thrownError);
      }
  })
}
/*
 * Muestra las facturas que corresponden a una cuenta RIPS, o a un numero de factura en particular
 * @param {type} CuentaRIPS
 * @param {type} NumFactura
 * @returns {undefined}
 */
function MostrarFacturas(CuentaRIPS,NumFactura=''){
    document.getElementById("DivFacturas").innerHTML='<div id="GifProcess">Buscando...<br><img   src="../images/cargando.gif" alt="Cargando" height="100" width="100"></div>';
    var form_data = new FormData();
        form_data.append('CuentaRIPS', CuentaRIPS);
        form_data.append('idFactura', NumFactura);
        $.ajax({
        url: './Consultas/busqueda_af.search.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            console.log(data)
          if (data != "") { 
              document.getElementById('DivFacturas').innerHTML=data;
              
          }else {
            alert("No hay resultados para la consulta");
          }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      })        
}  
/*
 * Filtra las facturas por rango de fechas 
 * @returns {undefined}
 */
function FiltreRangoFechas(){
     var form_data = new FormData();
        form_data.append('FechaInicial', $('#FiltroFechaInicial').val());
        form_data.append('FechaFinal', $('#FiltroFechaFinal').val());
        document.getElementById("DivFacturas").innerHTML='<div id="GifProcess">Buscando...<br><img   src="../images/cargando.gif" alt="Cargando" height="100" width="100"></div>';
   
        $.ajax({
        url: './Consultas/busqueda_af.search.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            console.log(data)
          if (data != "") { 
              document.getElementById('DivFacturas').innerHTML=data;
              
          }else {
            alert("No hay resultados para la consulta");
          }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      })        
}  

/**
 * Filtra las facturas por estado de la glosa
 * @returns {undefined}
 */
function FiltreFacturasXEstadoGlosa(){
     var form_data = new FormData();
        form_data.append('idEstadoGlosas', $('#CmbEstadoGlosaFacturas').val());
        
        document.getElementById("DivFacturas").innerHTML='<div id="GifProcess">Buscando...<br><img   src="../images/cargando.gif" alt="Cargando" height="100" width="100"></div>';
   
        $.ajax({
        url: './Consultas/busqueda_af.search.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            console.log(data)
          if (data != "") { 
              document.getElementById('DivFacturas').innerHTML=data;
              
          }else {
            alert("No hay resultados para la consulta");
          }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      })        
}  
/**
 * Funcion que espera el evento Click sobre el boton de mostrar factura
 * para buscar el usuario y datos de la misma y dibujarlos en la interfaz de glosar 
 * @param {type} idFactura
 * @returns {undefined}
 */
function MostrarActividades(idFactura){
    document.getElementById('BtnModalFacturas').click();
    BuscarUsuarioFactura(idFactura);
    BuscarActividadesFactura(idFactura);
}
/**
 * Busca el Usuario o Paciente al que se le realizó una factura, y los valores de la factura
 * @param {type} idFactura
 * @returns {undefined}
 */
function BuscarUsuarioFactura(idFactura){
    var form_data = new FormData();
        form_data.append('idFactura', idFactura);
        document.getElementById('DivDetallesUsuario').innerHTML="Buscando Paciente...";
        $.ajax({
        url: './Consultas/PacienteFactura.search.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            console.log(data)
          if (data != "") { 
              document.getElementById('DivDetallesUsuario').innerHTML=data;
              
          }else {
            alert("No hay resultados para la consulta");
          }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      })   
}
/**
 * Busca las actividades asociadas a una factura
 * @param {type} idFactura
 * @returns {undefined}
 */
function BuscarActividadesFactura(idFactura){
    var form_data = new FormData();
        form_data.append('idFactura', idFactura);
        document.getElementById('DivActividadesFacturas').innerHTML="Buscando Actividades...";
        $.ajax({
        url: './Consultas/ActividadesFactura.search.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            console.log(data)
          if (data != "") { 
              document.getElementById('DivActividadesFacturas').innerHTML=data;
              
          }else {
            alert("No hay resultados para la consulta");
          }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
          }
      })   
}
/**
 * Esta funcion realizará todas las peticiones necesarias al servidor para la devolucion de una factura
 * @param {type} idFactura
 * @returns {undefined}
 */    
function DevolverFactura(idFactura){
    alertify.set({ labels: {
                ok     : "Devolver",
                cancel : "Cancelar"
            } });
    alertify.confirm("Estás seguro que deseas devolver la Factura "+idFactura+"?<br><strong>NOTA: Esta acción es irreversible. <strong>",
    function (e) {
        if (e) {
            document.getElementById('BtnModalGlosar').click();
            DibujeFormulario(1,idFactura);
            AccionesGlosarFacturas(idFactura,1);
            alertify.success("Se realizó la devolucion de la factura"+idFactura);            
        } else {
            alertify.error("Se canceló la devolucion de la factura"+idFactura);
            

        }
    });
}
/**
 * Dibuja los diferentes formularios donde se capturará la gestion de glosas
 * @param {type} idFormulario
 * @param {type} idFactura
 * @returns {undefined}
 */
function DibujeFormulario(idFormulario,idFactura){
    
        var form_data = new FormData();       
        
        form_data.append('idFactura', idFactura);
        form_data.append('idFormulario', idFormulario);
        $.ajax({
        async:false,
        url: './Consultas/GlosasFormularios.draw.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            document.getElementById("DivGlosar").innerHTML=data;
            
            var config = {
              '.chosen-select'           : {},
              '.chosen-select-deselect'  : {allow_single_deselect:true},
              '.chosen-select-no-single' : {disable_search_threshold:10},
              '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
              '.chosen-select-width'     : {width:"200px"}
            }
            for (var selector in config) {
              $(selector).chosen(config[selector]);
            }
            document.getElementById("CodigoGlosa_chosen").style.width = "400px";  

        },
        error: function (xhr, ajaxOptions, thrownError) {
            alertify.error("Error al tratar de devolver la factura "+idFactura,0);
            alert(xhr.status);
            alert(thrownError);
          }
      })
}
/**
 * Realiza todas las acciones que se ejecutaran para el sistema de glosado de facturas
 * @param {type} idFactura -> El numero de factura que se realizará la glosa
 * @param {type} idAccion  -> La accion a realizar 1: Devolucion de una factura
 * @returns {undefined}
 */
function AccionesGlosarFacturas(idFactura,idAccion){
        if(idAccion==1){
            var form_data = new FormData();
        }
        
        form_data.append('idAccion', idAccion); //Devolver una factura
        form_data.append('idFactura', idFactura);
        $.ajax({
        async:false,
        url: './Consultas/AccionesGlosarFacturas.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            if(data.msg==="OK"){
                alertify.alert("Se Devolvió la factura "+idFactura);
            }

        },
        error: function (xhr, ajaxOptions, thrownError) {
            alertify.error("Error al tratar de devolver la factura "+idFactura,0);
            alert(xhr.status);
            alert(thrownError);
          }
      })
}