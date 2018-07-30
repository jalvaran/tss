/**
 * Controlador para la gestion de cargas masivas de glosas
 * JULIAN ALVARAN 2018-07-29
 * TECHNO SOLUCIONES SAS EN ASOCIACION CON SITIS SA
 * 317 774 0609
 */
/**
 * Envia el archivo de carga de glosas masivas al servidor
 * @returns {undefined}
 */
function CargarArchivoGlosasMasivas(){
    document.getElementById('BtnEnviarCargaMasiva').disabled=true;
    var form_data = new FormData();
    form_data.append('UpCargaMasivaGlosas', $('#UpCargaMasivaGlosas').prop('files')[0]);
    form_data.append('idAccion',1);
    $.ajax({
        async:false,
        url: './Consultas/AccionesCargasMasivas.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
                        
            alertify.success(data);            
            
            if(data==='OK'){
                document.getElementById('EstadoProgresoGlosasMasivas').innerHTML="Archivo Cargado";
                $('.progress-bar').css('width','1%').attr('aria-valuenow', 1);  
                document.getElementById('LyProgresoCMG').innerHTML="1%";
                LeerArchivo();
            }else{
                BorrarCarga();//Elimina los registros de la tabla Control de cargas
                document.getElementById('BtnEnviarCargaMasiva').disabled=false;
                document.getElementById('EstadoProgresoGlosasMasivas').innerHTML=data;
            }
            
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alertify.alert("Error al tratar de subir el archivo",0);
            alert(xhr.status);
            alert(thrownError);
          }
      })
}

function BorrarCarga(){
    var form_data = new FormData();
    form_data.append('idAccion',2);
    $.ajax({
        async:false,
        url: './Consultas/AccionesCargasMasivas.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            
            alertify.error(data); 
            document.getElementById('EstadoProgresoGlosasMasivas').innerHTML=data;
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alertify.alert("Error al tratar de borrar el archivo",0);
            alert(xhr.status);
            alert(thrownError);
          }
      })
}

function LeerArchivo(){
    var form_data = new FormData();
    form_data.append('idAccion',3);
    $.ajax({
        async:false,
        url: './Consultas/AccionesCargasMasivas.process.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            
            if(data==='OK'){
                var msg="Archivo leido";
                alertify.success(msg); 
                document.getElementById('EstadoProgresoGlosasMasivas').innerHTML=msg;
                $('.progress-bar').css('width','2%').attr('aria-valuenow', 2);  
                document.getElementById('LyProgresoCMG').innerHTML="2%";
                //LeerArchivo();
            }else{
                BorrarCarga();//Elimina los registros de la tabla Control de cargas
                document.getElementById('BtnEnviarCargaMasiva').disabled=false;
                document.getElementById('EstadoProgresoGlosasMasivas').innerHTML=data;
            }
            
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alertify.alert("Error al tratar de leer el archivo",0);
            alert(xhr.status);
            alert(thrownError);
          }
      })
}