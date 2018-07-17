/*
 * Archivo JS que se encargará de realizar las consultas, validaciones y envío  de la informacion
 * correspondiente a la carga de RIPS de Forma Manual
 */
/**
 * 
 * Funcion para validar si existe una cuenta RIPS
 */
var ErroresArchivos=0;
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
  document.getElementById('BtnSubirZip').disabled=true; 
  if($('#idEPS').val()=='' || $('#CuentaRIPS').val()=='' || $('#FechaRadicado').val()=='' || $('#NumeroRadicado').val()=='' || $('#CmbTipoNegociacion').val()=='' || $('#ArchivosZip').val()==''){
        alertify.alert("Los campos indicados con * son obligatorios");
        return;
  }  
  //event.preventDefault();
  var form_data = getInfoForm();
      form_data.append('idAccion', 1);
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
        document.getElementById("DivConsultas").innerHTML='<div id="GifProcess">Procesando...<br><img   src="../images/process.gif" alt="Cargando" height="100" width="100"></div>';
        if(data.CT == 0){
           
            alertify.error("No se recibió ningún archivo CT",0);
            return;
            
        }
        VerificarCT(data.Separador); //Se verifica que el CT contenga todos los archivos enviados
        ErroresArchivos=document.getElementById("Parar").value;
        
        if(ErroresArchivos==1){
            return;
        }
        
        for(i=0;i<data.Archivos.length;i++){ //Guarda los archivos en las tablas temporales
            var prefijo = data.Archivos[i].substr(0,2);
            
            if(prefijo!="CT" && prefijo!="AD"){

                GrabarArchivoEnTemporal(data.Archivos[i],0);
            }
           
            
        }
        
        ErroresArchivos=document.getElementById("Parar").value;
        
        if(ErroresArchivos==1){
            return;
        }
        
        //Se valida Si una factura ya está cargada y si es así para y muestra cuales
        
        
        //Se va a enviar para guardar en el repositorio final
        for(i=0;i<data.Archivos.length;i++){
            var prefijo = data.Archivos[i].substr(0,2);
                
            if((data.Archivos.length-1)==i){
                
                AnalizaArchivos(data.Archivos[i],1);
                  
            }else{
                if(prefijo!="CT" && prefijo!="AD"){
                    
                    AnalizaArchivos(data.Archivos[i],0);
                }
            }
            
            
        }
        
    },
    error: function (xhr, ajaxOptions, thrownError) {
        alert(xhr.status);
        alert(thrownError);
      }
  })
}

/**
 * 
 * Verifica los archivos que tenga el CT
 */
function VerificarCT(Separador){
    
    var form_data = new FormData();
    form_data.append('idAccion', 2);
    form_data.append('Separador', Separador);
    $.ajax({
    url: './Consultas/Salud_SubirRips.info.php',
    dataType: 'json',
    cache: false,
    contentType: false,
    processData: false,
    data: form_data,
    type: 'post',
    success: function(data){
        if(data.Errores>0){
            for(i=1;i<=data.Errores;i++){
                
                alertify.error("El Archivo "+data.ArchivosNE[i]+" No Existe en los Archivos cargados",0);
            }
        document.getElementById("Parar").value=1; 
        }
             
    },
    error: function (xhr, ajaxOptions, thrownError) {
        alert(xhr.status);
        alert(thrownError);
      }
  })
  
}

/**
 * 
 * Modificar Autoincrementables
 */
function ModificaAI(){
    
    var form_data = new FormData();
    form_data.append('idAccion', 5);
    
    $.ajax({
    url: './Consultas/Salud_SubirRips.info.php',
    dataType: 'json',
    cache: false,
    contentType: false,
    processData: false,
    data: form_data,
    type: 'post',
    success: function(data){
        
        if(data.msg==="OK"){        
            alertify.success("Los autoincrementables se han modificado");
        }    
        
             
    },
    error: function (xhr, ajaxOptions, thrownError) {
        alert(xhr.status);
        alert(thrownError);
      }
  })
  
}

/**
 * 
 * Enviar archivo para grabarlo en temporal
 */
function GrabarArchivoEnTemporal(Archivo,Fin){
    
    var form_data = getInfoForm();
    form_data.append('idAccion', 3);
    form_data.append('NombreArchivo', Archivo);
    $.ajax({
    url: './Consultas/Salud_SubirRips.info.php',
    dataType: 'json',
    cache: false,
    contentType: false,
    processData: false,
    data: form_data,
    type: 'post',
    success: function(data){
        if(data.msg==='OK'){
            alertify.success("Archivo "+Archivo+" sin errores");     
            document.getElementById("DivConsultas").innerHTML=document.getElementById("DivConsultas").innerHTML+"<li>Archivo "+Archivo+" Subido a tabla Temporal";
            if(Fin===1){
                document.getElementById("GifProcess").innerHTML="";
                document.getElementById('BtnSubirZip').disabled=false;
            }
        }
        if(data.msg==='Error'){
            document.getElementById("Parar").value=1;
            document.getElementById("GifProcess").innerHTML="";
            document.getElementById('BtnSubirZip').disabled=false;
            document.getElementById("DivConsultas").innerHTML=document.getElementById("DivConsultas").innerHTML+"<li>Archivo "+Archivo+" Contiene errores";
           
            if(data.Error.Pos===1){
                alertify.error("La Prestadora No Existe - Error en las lineas: "+data.Error.Lines,0);
            }
            if(data.Error.Pos===9){
                alertify.error("La Aseguradora No Coincide- Error en las lineas: "+data.Error.Lines,0);
            }
        }
             
    },
    error: function (xhr, ajaxOptions, thrownError) {
        alert(xhr.status);
        alert(thrownError);
      }
  })
  
}

/**
 * 
 * Analiza Archivos para Subirlos a los repositorios reales
 */
function AnalizaArchivos(Archivo,Fin){
    
    var form_data = new FormData();
    form_data.append('idAccion', 4);
    form_data.append('Archivo', Archivo);
    $.ajax({
    url: './Consultas/Salud_SubirRips.info.php',
    dataType: 'json',
    cache: false,
    contentType: false,
    processData: false,
    data: form_data,
    type: 'post',
    success: function(data){
        if(data.msg==="OK"){
            document.getElementById("DivConsultas").innerHTML=document.getElementById("DivConsultas").innerHTML+"<li>Archivo "+Archivo+" Guardado Correctamente";
            if(Fin===1){
                ModificaAI();
                document.getElementById("GifProcess").innerHTML="";
                document.getElementById('BtnSubirZip').disabled=false;
            }
        }
             
    },
    error: function (xhr, ajaxOptions, thrownError) {
        alert(xhr.status);
        alert(thrownError);
      }
  })
  
}