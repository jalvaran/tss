/**
 * Controlador para la gestion de glosas
 * JULIAN ALVARAN 2018-07-19
 * TECHNO SOLUCIONES SAS EN ASOCIACION CON SITIS SA
 * 317 774 0609
 */

function ValidarFecha(idTxtFecha){
    var FechaValidar = document.getElementById(idTxtFecha).value;
    var hoy             = new Date();
    var fechaFormulario = new Date(FechaValidar);

    // Compara solo las fechas => no las horas!!
    hoy.setHours(0,0,0,0);

    if (fechaFormulario > hoy ) {
        return 1;    
    }else{
        return 0;
    }
}

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
    //document.getElementById('BtnModalFacturas').click();
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
            if(ValidarFecha('FechaDevolucion')){
                alertify.error("La fecha de devolucion seleccionada es mayor a la actual, por favor seleccione una fecha válida");
                return;
            }
            if(ValidarFecha('FechaAuditoria')){
                alertify.error("La fecha de Recibo de auditoría seleccionada es mayor a la actual, por favor seleccione una fecha válida");
                return;
            }
            AccionesGlosarFacturas(idFactura,1);
                        
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
        document.getElementById('BtnModalGlosar').click();
        var form_data = new FormData();       
        
        form_data.append('idFactura', idFactura);
        form_data.append('idFormulario', idFormulario);
        $.ajax({
        //async:false,
        url: './Consultas/GlosasFormularios.draw.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            
            if (data != "") { 
            document.getElementById("DivGlosar").innerHTML=data;
            
            for (var selector in config) {
                $(selector).chosen(config[selector]);
            }
            
            document.getElementById("CodigoGlosa_chosen").style.width = "400px";      
        }
            
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
            
            var form_data = getInfoFormDevoluciones();
            if(form_data==0){
                return;
            }
        }
        
        if(idAccion==2){ //Glosar una actividad inicial
           
            if(ValidarFecha('FechaIPS')==1){
                console.log(ValidarFecha('FechaIPS'));
                alertify.alert("La fecha de IPS no puede ser mayor a la de hoy");
                document.getElementById('FechaIPS').focus();
                return;
            }
            if(ValidarFecha('FechaAuditoria')==1){
                alertify.alert("La fecha de Auditoria no puede ser mayor a la de hoy");
                document.getElementById('FechaAuditoria').focus();
                return;
            }
            var form_data = getInfoFormGlosasRespuestas();
            if(form_data==0){
                return;
            }
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
            if(idAccion==1){
                document.getElementById("DivGlosar").innerHTML="<strong>Devolucion Realizada!</strong>";
                //document.getElementById('BtnModalGlosar').click();
                BuscarUsuarioFactura(idFactura);
                BuscarActividadesFactura(idFactura);
                alertify.success("Se realizó la devolucion de la factura "+idFactura);
            }
            
            if(idAccion==2){
                DibujeFormularioActividades('',idActividad,idFactura,3)
                alertify.success(data);
                //document.getElementById("DivGlosar").innerHTML="Tarea Registrada";
                
                //alertify.success("Se realizó el registro de la glosa inicial ");
            }

        },
        error: function (xhr, ajaxOptions, thrownError) {
            alertify.error("Error al tratar de devolver la factura "+idFactura,0);
            alert(xhr.status);
            alert(thrownError);
          }
      })
}


/**
 * 
 * Captura la informacion del Formulario de devoluciones
 */
function getInfoFormDevoluciones(){
    if($('#FechaAuditoria').val()=='' || $('#FechaDevolucion').val()=='' || $('#CodigoGlosa').val()=='' || $('#Observaciones').val()==''){
        alertify.set({ labels: {
                ok     : "OK",
                cancel : "Cancelar"
            } });
        alertify.alert("Todos los campos son obligatorios");
        return 0;
    }
    var form_data = new FormData();
    form_data.append('FechaAuditoria', $('#FechaAuditoria').val());
    form_data.append('FechaDevolucion', $('#FechaDevolucion').val());
    form_data.append('CodigoGlosa', $('#CodigoGlosa').val());
    form_data.append('Observaciones', $('#Observaciones').val());
    form_data.append('ValorFactura', $('#ValorFacturaDevolucion').val());
    form_data.append('Soporte', $('#UpSoporteDevolucion').prop('files')[0]);    
    return form_data;
}

/**
 * Funcion que espera el evento Click sobre el boton de Glosar actividad
 * para Glosar una actividad en especifico
 * @param {type} Tabla ->tabla de donde viene la actividad
 * @param {type} idActividad -> id de la actividad que se va a glosar
 * @returns {undefined}
 */
function GlosarActividad(TipoArchivo,idActividad,idFactura){
    document.getElementById('BtnModalGlosar').click();
    DibujeFormularioActividades(TipoArchivo,idActividad,idFactura,2);
    DibujeFormularioActividades(TipoArchivo,idActividad,idFactura,3);
    
}

/**
 * Dibuja los diferentes formularios donde se capturará la gestion de glosas de las actividades
 * @param {type} idFormulario
 * @param {type} idFactura
 * @returns {undefined}
 */
function DibujeFormularioActividades(TipoArchivo,idActividad,idFactura,idFormulario){
        
        var form_data = new FormData();       
        
        form_data.append('TipoArchivo', TipoArchivo);
        form_data.append('idActividad', idActividad);
        form_data.append('idFormulario', idFormulario);
        form_data.append('idFactura', idFactura);
        
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
            
            if (data != "") { 
                if(idFormulario==3){
                    document.getElementById("DivHistorialGlosas").innerHTML=data;
                }else{
                    document.getElementById("DivGlosar").innerHTML=data;
                }
                
            
            for (var selector in config) {
                $(selector).chosen(config[selector]);
            }
            
            document.getElementById("CodigoGlosa_chosen").style.width = "400px";      
        }
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alertify.error("Error al tratar de dibujar el formulario de glosar la actividad "+idActividad,0);
            alert(xhr.status);
            alert(thrownError);
          }
      })
}


/**
 * 
 * Captura la informacion del Formulario de devoluciones
 */
function getInfoFormGlosasRespuestas(){
    if($('#FechaIPS').val()=='' || $('#FechaAuditoria').val()=='' || $('#ValorEPS').val()=='' || $('#ValorAceptado').val()=='' || $('#CodigoGlosa').val()=='' || $('#Observaciones').val()==''){
        alertify.set({ labels: {
                ok     : "OK",
                cancel : "Cancelar"
            } });
        alertify.alert("Todos los campos son obligatorios");
        return 0;
    }
    var form_data = new FormData();
    form_data.append('FechaAuditoria', $('#FechaAuditoria').val());
    form_data.append('FechaIPS', $('#FechaIPS').val());
    form_data.append('CodigoGlosa', $('#CodigoGlosa').val());
    form_data.append('Observaciones', $('#Observaciones').val());
    form_data.append('idActividad', $('#idActividad').val());
    form_data.append('TipoArchivo', $('#TipoArchivo').val());
    form_data.append('ValorEPS', $('#ValorEPS').val());
    form_data.append('ValorAceptado', $('#ValorAceptado').val());
    form_data.append('ValorConciliar', $('#ValorConciliar').val());
    form_data.append('TotalActividad', $('#TotalActividad').val());
    form_data.append('Soporte', $('#UpSoporteGlosa').prop('files')[0]);    
    return form_data;
}
/**
 * Valida que no se ingrese un mayor valor a glosar y  calcula el valor a conciliar
 * @param {type} ValorMaximoAGlosar
 * @returns {undefined}
 */
function ValidaValorGlosa(ValorMaximoAGlosar){
    var ValorGlosado = document.getElementById('ValorEPS').value;
    if(ValorMaximoAGlosar<ValorGlosado){
        alertify.alert("El valor de la glosa digitado es mayor al que se puede Glosar");
        return 1;
    }
    document.getElementById('ValorConciliar').value=document.getElementById('ValorEPS').value-document.getElementById('ValorAceptado').value;
    return 0;
}