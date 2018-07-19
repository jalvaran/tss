/**
 * Controlador para la gestion de glosas
 */


/**
 * Buscar una cuenta por diferentes criterios
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

function MostrarActividades(idFactura){
    document.getElementById('BtnModalFacturas').click();
    BuscarUsuarioFactura(idFactura);
    BuscarActividadesFactura(idFactura);
}

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
    
