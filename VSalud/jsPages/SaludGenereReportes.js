/**
 * Controlador para la gestion de reportes
 * JULIAN ALVARAN 2018-08-03
 * TECHNO SOLUCIONES SAS EN ASOCIACION CON SITIS SA
 * 317 774 0609
 */


/**
 * Envía la peticion para generar respuestas a las cuentas
 * @returns {undefined}
 */
function getInfoForm(){
    
    var form_data = new FormData();
        form_data.append('TipoReporte', $('#TipoReporte').val());
        form_data.append('idEPS', $('#idEPS').val());
        form_data.append('FechaInicial', $('#FechaInicial').val());
        form_data.append('FechaFinal', $('#FechaFinal').val());
        form_data.append('CuentaRIPS', $('#CuentaRIPS').val());
    
    return form_data;
}
/**
 * Cambia el la fecha minima para seleccionar en una fecha final
 * @returns {undefined}
 */
function CambiarFechaFinal(){
    var FechaInicial = document.getElementById("FechaInicial").value;
    $('#FechaFinal').attr("min", FechaInicial); 
}
/**
 * Envia las facturas para analizarlas
 * @returns {undefined}
 */
function DibujeReporte(){
    document.getElementById("DivConsultas").innerHTML='<div id="GifProcess">Procesando...<br><img   src="../images/process.gif" alt="Cargando" height="100" width="100"></div>';
   
    var form_data = getInfoForm();
              
    $.ajax({
        //async:false,
        url: './Consultas/SaludReportesGlosas.draw.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
                
            document.getElementById("DivConsultas").innerHTML=data;
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alertify.alert("Error al tratar de realizar la consulta",0);
            alert(xhr.status);
            alert(thrownError);
          }
      })
    
}

