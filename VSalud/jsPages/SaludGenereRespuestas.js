/**
 * Controlador para la gestion de respuestas
 * JULIAN ALVARAN 2018-08-03
 * TECHNO SOLUCIONES SAS EN ASOCIACION CON SITIS SA
 * 317 774 0609
 */
/**
 * Envia el archivo de carga de glosas masivas al servidor
 * @returns {undefined}
 */
$(document).ready(function() {
    $('#Cuentas').select2({
		  
                placeholder: 'Busque una CuentaRIPS o EPS',
                ajax: {
                  url: './buscadores/CuentaRIPS.querys.php',
                  dataType: 'json',
                  delay: 250,
                  processResults: function (data) {
                    return {
                      results: data
                    };
                  },
                  cache: true
                }
              });
});
/**
 * Borra la ultima carga en caso de no pasar alguna validacion o que e produzca algun error
 * @returns {undefined}
 */
function BorrarCarga(){
    var form_data = new FormData();
        form_data.append('idAccion', 2);
        
      
    $.ajax({
        //async:false,
        url: './Consultas/SaludGenereRespuestas.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            
           if(data==="OK"){
                
                document.getElementById("DivProcess").innerHTML="Carga Borrada";
                alertify.error("Carga Borrada");
            }else{
                document.getElementById("DivProcess").innerHTML="No se pudo borrar la carga";
                
            }
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alertify.alert("Error al tratar de borrar el archivo",0);
            alert(xhr.status);
            alert(thrownError);
          }
      })
}

/**
 * Envía la peticion para generar respuestas a las cuentas
 * @returns {undefined}
 */
function EnviarCuentas(){
    
    if($('#Cuentas').val()==null || $('#Cuentas').val()==''){
          alertify.alert("por favor seleccione una o varias cuentas");          
          return;
    } 
    
    
    var form_data = new FormData();
        form_data.append('idAccion', 1);
        form_data.append('Cuentas', $('#Cuentas').val());
      
    $.ajax({
        //async:false,
        url: './Consultas/SaludGenereRespuestas.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            
           if(data==="OK"){
                $('.progress-bar').css('width','4%').attr('aria-valuenow', 4);  
                document.getElementById('LyProgresoCMG').innerHTML="4%";
                document.getElementById("DivConsultas").innerHTML="<h4 style='color:green'>Se recibieron las cuentas solicitadas</h4>";
                CrearArchivoRespuestas();
            }else{
                document.getElementById("DivProcess").innerHTML='';
                document.getElementById("DivConsultas").innerHTML=data;                
                BorrarCarga();
                
            }
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alertify.alert("Error al tratar de borrar el archivo",0);
            alert(xhr.status);
            alert(thrownError);
          }
      })
    
}
/**
 * Crea el archivo donde se van a almacenar todas las respuestas
 * @returns {undefined}
 */
function CrearArchivoRespuestas(){
    var form_data = new FormData();
        form_data.append('idAccion', 3);
        
      
    $.ajax({
        //async:false,
        url: './Consultas/SaludGenereRespuestas.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            
           if(data==="OK"){
                $('.progress-bar').css('width','8%').attr('aria-valuenow', 8);  
                document.getElementById('LyProgresoCMG').innerHTML="8%";
                document.getElementById("DivConsultas").innerHTML="<h4 style='color:green'>Archivo de Respuestas Preparado</h4>";
                EscribaRespuestasFacturasEnExcel();
            }else{
                document.getElementById("DivProcess").innerHTML='';
                document.getElementById("DivConsultas").innerHTML=data;                
                BorrarCarga();
                
            }
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alertify.alert("Error al tratar de borrar el archivo",0);
            alert(xhr.status);
            alert(thrownError);
          }
      })
}
/**
 * Envía la orden para realizar la escritura en el archivo de excel
 * @returns {undefined}
 */
function EscribaRespuestasFacturasEnExcel(){
    var form_data = new FormData();
        form_data.append('idAccion', 4);
        
      
    $.ajax({
        //async:false,
        url: './Consultas/SaludGenereRespuestas.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
           var respuestas = data.split(';');
           if(respuestas[0]==="OK"){
                var Porcentaje = respuestas[3]; 
                var msg="Registradas "+respuestas[2]+" Respuestas de un total de "+respuestas[1];
                Porcentaje=parseInt(Porcentaje)+8;
                document.getElementById('DivConsultas').innerHTML=msg;
                $('.progress-bar').css('width',Porcentaje+'%').attr('aria-valuenow', Porcentaje);  
                document.getElementById('LyProgresoCMG').innerHTML=Porcentaje+"%";                
                //EscribaRespuestasFacturasEnExcel();
            }else{
                document.getElementById("DivProcess").innerHTML='';
                document.getElementById("DivConsultas").innerHTML=data;                
                BorrarCarga();
                
            }
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alertify.alert("Error al tratar de borrar el archivo",0);
            alert(xhr.status);
            alert(thrownError);
          }
      })
}