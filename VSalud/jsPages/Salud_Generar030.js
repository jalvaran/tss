/*
 * Controlador para generar la circular 030
 */

function GenereRadicadosEnPeriodo(Contador="",TotalRegistros=''){
    if(Contador==''){
        document.getElementById("DivProcess").innerHTML='<div id="GifProcess">Procesando...<br><img   src="../images/process.gif" alt="Cargando" height="100" width="100"></div>';
    }
    var TxtFechaInicial = document.getElementById('TxtFechaInicial').value;
    var TxtFechaFinal = document.getElementById('TxtFechaFinal').value;
    var CmbAdicional = document.getElementById('CmbAdicional').value;
    var DivDestino =  'DivMensajesCircular';
    
    var form_data = new FormData();
        form_data.append('idAccion', 1)
        form_data.append('TxtFechaInicial', TxtFechaInicial)
        form_data.append('TxtFechaFinal', TxtFechaFinal)
        form_data.append('CmbAdicional', CmbAdicional)
        form_data.append('Contador', Contador)
        form_data.append('TotalRegistros', TotalRegistros)
                
        $.ajax({
        //async:false,
        url: 'procesadores/Salud_Genere030.process.php',
        //dataType: "json",
        cache: false,
        processData: false,
        contentType: false,
        data: form_data,
        type: 'POST',
        success: (data) =>{   
            console.log(data);
            var respuestas = data.split(';');            
            if(respuestas[0]=='OK'){
                var TotalRegistros=respuestas[1];
                var RegistrosRealizados=respuestas[2];
                var Termina=respuestas[3];
                var porcentaje = Math.round((11/TotalRegistros)*RegistrosRealizados);
                $('.progress-bar').css('width',porcentaje+'%').attr('aria-valuenow', porcentaje);  
                document.getElementById('LyProgresoCMG').innerHTML=porcentaje+"%";
                document.getElementById(DivDestino).innerHTML=RegistrosRealizados+' Registros guardados de '+TotalRegistros+", del AF En estado Radicado en el periodo seleccionado.<br>Total de Registros hasta el momento: "+RegistrosRealizados;
                if(Termina==''){
                    GenereRadicadosEnPeriodo(RegistrosRealizados,TotalRegistros);
                }
                
                if(Termina=='Fin'){
                   // document.getElementById("DivProcess").innerHTML='';
                    GenereJuridicosEnPeriodo("","",RegistrosRealizados);
                }
                                    
            }else{
                document.getElementById(DivDestino).innerHTML=data;
                document.getElementById("DivProcess").innerHTML='';
            }
            
                        
        },
        error: function(xhr, ajaxOptions, thrownError){
          alert(xhr.status);
          alert(thrownError);
        }
      })
        
}
/**
 * Busque los registros en estado de cobro juridico durante el periodo seleccionado
 * @param {type} Contador
 * @param {type} TotalRegistros
 * @returns {undefined}
 */
function GenereJuridicosEnPeriodo(Contador="",TotalRegistros='',ContadorGeneral){    
    
    var TxtFechaInicial = document.getElementById('TxtFechaInicial').value;
    var TxtFechaFinal = document.getElementById('TxtFechaFinal').value;
    var CmbAdicional = document.getElementById('CmbAdicional').value;
    var DivDestino =  'DivMensajesCircular';
    
    var form_data = new FormData();
        form_data.append('idAccion', 2)
        form_data.append('TxtFechaInicial', TxtFechaInicial)
        form_data.append('TxtFechaFinal', TxtFechaFinal)
        form_data.append('CmbAdicional', CmbAdicional)
        form_data.append('Contador', Contador)
        form_data.append('TotalRegistros', TotalRegistros)
        form_data.append('ContadorGeneral', ContadorGeneral)   
        $.ajax({
        //async:false,
        url: 'procesadores/Salud_Genere030.process.php',
        //dataType: "json",
        cache: false,
        processData: false,
        contentType: false,
        data: form_data,
        type: 'POST',
        success: (data) =>{   
            console.log(data);
            var respuestas = data.split(';');            
            if(respuestas[0]=='OK'){
                var TotalRegistros=respuestas[1];
                var RegistrosRealizados=respuestas[2];
                var ContadorGeneral=respuestas[4];
                var Termina=respuestas[3];
                if(TotalRegistros==0){
                    var Divisor=1;
                }else{
                    var Divisor=TotalRegistros;
                }
                var porcentaje = Math.round((22/Divisor)*RegistrosRealizados);
                porcentaje=porcentaje+11;
                $('.progress-bar').css('width',porcentaje+'%').attr('aria-valuenow', porcentaje);  
                document.getElementById('LyProgresoCMG').innerHTML=porcentaje+"%";
                document.getElementById(DivDestino).innerHTML=RegistrosRealizados+' Registros guardados de '+TotalRegistros+", del AF En estado De Cobro Juridico en el periodo seleccionado.<br>Total de Registros hasta el momento"+ContadorGeneral;
                if(Termina==''){
                    GenereJuridicosEnPeriodo(RegistrosRealizados,TotalRegistros,ContadorGeneral);
                }
                if(Termina=='Fin'){
                    porcentaje=22;
                    $('.progress-bar').css('width',porcentaje+'%').attr('aria-valuenow', porcentaje);  
                    document.getElementById('LyProgresoCMG').innerHTML=porcentaje+"%";
                    GenereRadicadosAnteriores('','',ContadorGeneral);
                }                    
            }else{
                document.getElementById(DivDestino).innerHTML=data;
                document.getElementById("DivProcess").innerHTML='';
            }
            
                        
        },
        error: function(xhr, ajaxOptions, thrownError){
          alert(xhr.status);
          alert(thrownError);
        }
      })
        
}


/**
 * Busque los registros en estado de radicados anterior al periodo seleccionado
 * @param {type} Contador
 * @param {type} TotalRegistros
 * @returns {undefined}
 */
function GenereRadicadosAnteriores(Contador="",TotalRegistros='',ContadorGeneral){    
    
    var TxtFechaInicial = document.getElementById('TxtFechaInicial').value;
    var TxtFechaFinal = document.getElementById('TxtFechaFinal').value;
    var CmbAdicional = document.getElementById('CmbAdicional').value;
    var DivDestino =  'DivMensajesCircular';
    
    var form_data = new FormData();
        form_data.append('idAccion', 3)
        form_data.append('TxtFechaInicial', TxtFechaInicial)
        form_data.append('TxtFechaFinal', TxtFechaFinal)
        form_data.append('CmbAdicional', CmbAdicional)
        form_data.append('Contador', Contador)
        form_data.append('TotalRegistros', TotalRegistros)
        form_data.append('ContadorGeneral', ContadorGeneral)        
        $.ajax({
        //async:false,
        url: 'procesadores/Salud_Genere030.process.php',
        //dataType: "json",
        cache: false,
        processData: false,
        contentType: false,
        data: form_data,
        type: 'POST',
        success: (data) =>{   
            console.log(data);
            var respuestas = data.split(';');            
            if(respuestas[0]=='OK'){
                var TotalRegistros=respuestas[1];
                var RegistrosRealizados=respuestas[2];
                var ContadorGeneral=respuestas[4];
                var Termina=respuestas[3];
                if(TotalRegistros==0){
                    var Divisor=1;
                }else{
                    var Divisor=TotalRegistros;
                }
                var porcentaje = Math.round((33/Divisor)*RegistrosRealizados);
                porcentaje=porcentaje+22;
                $('.progress-bar').css('width',porcentaje+'%').attr('aria-valuenow', porcentaje);  
                document.getElementById('LyProgresoCMG').innerHTML=porcentaje+"%";
                document.getElementById(DivDestino).innerHTML=RegistrosRealizados+' Registros guardados de '+TotalRegistros+", del AF En estado De Radicado anteriores al periodo seleccionado.<br>Total de Registros hasta el momento "+ContadorGeneral;
                if(Termina==''){
                    GenereRadicadosAnteriores(RegistrosRealizados,TotalRegistros,ContadorGeneral);
                }
                if(Termina=='Fin'){
                    porcentaje=33;
                    $('.progress-bar').css('width',porcentaje+'%').attr('aria-valuenow', porcentaje);  
                    document.getElementById('LyProgresoCMG').innerHTML=porcentaje+"%";
                    document.getElementById("DivProcess").innerHTML='';
                    //GenereJuridicosEnPeriodo();
                }                    
            }else{
                document.getElementById(DivDestino).innerHTML=data;
                document.getElementById("DivProcess").innerHTML='';
            }
            
                        
        },
        error: function(xhr, ajaxOptions, thrownError){
          alert(xhr.status);
          alert(thrownError);
        }
      })
        
}