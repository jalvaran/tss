/*
 * Archivo JS que se encargará de realizar las consultas, validaciones y envío  de la informacion
 * correspondiente a la carga de RIPS de Forma Manual
 */
/**
 * 
 * Funcion para validar si existe una cuenta RIPS
 */
function ValidaCuentaRIPS(){
    
    var CuentaRIPS = document.getElementById('CuentaRIPS').value;
    var DivDestino =  'DivConsultas';
    var form_data = new FormData();
        form_data.append('idValidacion', 1)
        form_data.append('CuentaRIPS', CuentaRIPS)
                
        $.ajax({
        url: 'Consultas/Validaciones.php',
        dataType: "json",
        cache: false,
        processData: false,
        contentType: false,
        data: form_data,
        type: 'POST',
        success: (data) =>{
            //console.log(data);
            
            if(data.msg==='OK'){
                console.log(data); 
                document.getElementById('BtnSubirZip').disabled=false;
                if(data.ID){
                    alertify.alert("El numero de Cuenta ya Existe!");
                    document.getElementById('BtnSubirZip').disabled=true;
                }
                    
            }
            
            if(data.msg==='Error'){
                //alertify.alert("Debes completar todos los campos");
                alert(data.error);
                //DibujePedidos();
            }
            
        },
        error: function(xhr, ajaxOptions, thrownError){
          alert(xhr.status);
          alert(thrownError);
        }
      })
        
}
/**
 * 
 * Captura la informacion del formulario
 */
function getInfoForm(){
          
    var form_data = new FormData();
    form_data.append('idEPS', $('#idEPS').val());
    form_data.append('CuentaRIPS', $('#CuentaRIPS').val());
    form_data.append('FechaRadicado', $('#FechaRadicado').val());
    form_data.append('NumeroRadicado', $('#NumeroRadicado').val());
    form_data.append('CuentaGlobal', $('#CuentaGlobal').val());
    form_data.append('CmbEscenario', $('#CmbEscenario').val());
    form_data.append('CmbSeparador', $('#CmbSeparador').val());
    form_data.append('CmbTipoNegociacion', $('#CmbTipoNegociacion').val());    
    form_data.append('UpSoporteRadicado', $('#UpSoporteRadicado').prop('files')[0]);
    form_data.append('ArchivosZip', $('#ArchivosZip').prop('files')[0]);
    return form_data;
}
/**
 * Envía la informacion 
 * @param {type} event
 * @returns {undefined}
 */
function submitInfo(event){
  if($('#idEPS').val()=='' || $('#CuentaRIPS').val()=='' || $('#FechaRadicado').val()=='' || $('#NumeroRadicado').val()=='' || $('#CmbTipoNegociacion').val()=='' || $('#ArchivosZip').val()==''){
        alertify.alert("Los campos indicados con * son obligatorios");
        return;
  }  
  //event.preventDefault();
  var form_data = getInfoForm();
  $.ajax({
    url: './Consultas/Salud_SubirRips.info.php',
    dataType: 'json',
    cache: false,
    contentType: false,
    processData: false,
    data: form_data,
    type: 'post',
    success: function(data){
        console.log(data);
        var DivConsultas=document.getElementById("DivConsultas");
        document.getElementById("DivConsultas").innerHTML="Recibiendo";
        for(i=0;data.Archivos.length;i++){
            
            document.getElementById("DivConsultas").innerHTML=data.Archivos[i];
        }
     
    },
    error: function (xhr, ajaxOptions, thrownError) {
        alert(xhr.status);
        alert(thrownError);
      }
  })
}
