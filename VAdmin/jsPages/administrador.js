/**
 * Controlador para el administrador
 * JULIAN ALVARAN 2018-07-19
 * TECHNO SOLUCIONES SAS EN ASOCIACION CON SITIS SA
 * 317 774 0609
 */



/*
 * Dibuja los administradores
 * @returns {undefined}
 */
function DibujaAdministradores(){
    var form_data = new FormData();
        form_data.append('Accion', 1);
        
        $.ajax({
        url: './Consultas/administrador.draw.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
           
          if (data != "") { 
              document.getElementById('DivMenuLateralModulos').innerHTML=data;
              
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
 * Dibuja los Filtros
 * @returns {undefined}
 */
function DibujaFiltros(){
    var Tabla = document.getElementById('TxtTabla').value;
    
    var form_data = new FormData();
        form_data.append('Accion', 3);
        form_data.append('Tabla', Tabla);
        $.ajax({
        url: './Consultas/administrador.draw.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
           
          if (data != "") { 
              document.getElementById('DivOpciones1').innerHTML=data;
              
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
 * Selecciona la tabla a dibujar
 * @param {type} Tabla
 * @returns {undefined}
 */
function SeleccionarTabla(Tabla){
    document.getElementById('TxtTabla').value=Tabla;
    var Condicion = document.getElementById('TxtCondicion').value;
    var OrdenColumna = document.getElementById('TxtOrdenNombreColumna').value;
    var Orden = document.getElementById('TxtOrdenTabla').value;
    var Limit = document.getElementById('TxtLimit').value;
    var Page = document.getElementById('TxtPage').value;
    var form_data = new FormData();
        form_data.append('Accion', 2);
        form_data.append('Tabla', Tabla);
        form_data.append('Condicion', Condicion);
        form_data.append('OrdenColumna', OrdenColumna);
        form_data.append('Orden', Orden);
        form_data.append('Limit', Limit);
        form_data.append('Page', Page);
        $.ajax({
        url: './Consultas/administrador.draw.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
           
          if (data != "") { 
              document.getElementById('tabla').innerHTML=data;
              DibujaFiltros();
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

function EscribirEnCaja(idCaja,Valor){
    document.getElementById(idCaja).value=Valor;
}

function CambiarOrden(){
    var OrdenActual=document.getElementById('TxtOrdenTabla').value;
    if(OrdenActual=='DESC'){
        document.getElementById('TxtOrdenTabla').value='ASC';
    }else{
        document.getElementById('TxtOrdenTabla').value='DESC';
    }
}

function DibujeTabla(){
    var Tabla = document.getElementById('TxtTabla').value;
    SeleccionarTabla(Tabla);
}

function LimpiarFiltros(){
    document.getElementById('TxtOrdenTabla').value='DESC';
    document.getElementById('TxtCondicion').value='';
    document.getElementById('TxtOrdenNombreColumna').value='';
    document.getElementById('TxtPage').value='1';
}

function MuestraOcultaMenu(){
    var id='DivSubMenuLateral';
    estado=document.getElementById(id).style.display;
    if(estado=="none" | estado==""){
        document.getElementById(id).style.display="block";
    }
    if(estado=="block"){
        document.getElementById(id).style.display="none";
    }
    
}


$(document).on("click",function(e) {
    var id='DivSubMenuLateral';              
    var container = $("#DivSubMenuLateral");
    var container2 = $("#aMenuPrincipal");

       if (!container.is(e.target) && container.has(e.target).length === 0) { 
           if(!container2.is(e.target) && container2.has(e.target).length === 0){
               document.getElementById(id).style.display="none";
           }
                       
       }
});
     
DibujaAdministradores();