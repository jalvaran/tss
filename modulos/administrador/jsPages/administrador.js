/**
 * Controlador para el administrador
 * JULIAN ALVARAN 2018-07-19
 * TECHNO SOLUCIONES SAS EN ASOCIACION CON SITIS SA
 * 317 774 0609
 */


/*
 * Dibuja los Filtros
 * @returns {undefined}
 */
function DibujaFiltros(Tabla){
       
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
 * Escribe en una caja de texto
 * @param {type} idCaja
 * @param {type} Valor
 * @returns {undefined}
 */
function EscribirEnCaja(idCaja,Valor){
    document.getElementById(idCaja).value=Valor;
}
/**
 * Funcion para cambiar la palabra desc x asc y viceversa en la caja de texto utilizada para enviar el orden al dobujador de la tabla
 * @returns {undefined}
 */
function CambiarOrden(){
    var OrdenActual=document.getElementById('TxtOrdenTabla').value;
    if(OrdenActual=='DESC'){
        document.getElementById('TxtOrdenTabla').value='ASC';
    }else{
        document.getElementById('TxtOrdenTabla').value='DESC';
    }
}

/**
 * Dibuja una tabla con todos sus componentes
 * @param {type} Tabla
 * @returns {undefined}
 */
function DibujeTabla(Tabla=''){
    if(Tabla==''){
        var Tabla = document.getElementById('TxtTabla').value;
    }
    LimpiarFiltros();
    SeleccionarTabla(Tabla);
    DibujaAccionesTablas(Tabla);
    DibujaFiltros(Tabla);
}
/**
 * Limpia las cajas de texto utilizadas para los filtros
 * @returns {undefined}
 */
function LimpiarFiltros(){
    document.getElementById('TxtOrdenTabla').value='DESC';
    document.getElementById('TxtCondicion').value='';
    document.getElementById('TxtOrdenNombreColumna').value='';
    document.getElementById('TxtPage').value='1';
    if ($('#DivFiltrosAplicados').length){
        document.getElementById('DivFiltrosAplicados').innerHTML='';
        var Tabla = document.getElementById('TxtTabla').value
        SeleccionarTabla(Tabla);
    }
    
}
/**
 * Muestra u oculta un elemento por su id
 * @param {type} id
 * @returns {undefined}
 */

function MuestraOcultaXID(id){
    
    var estado=document.getElementById(id).style.display;
    if(estado=="none" | estado==""){
        document.getElementById(id).style.display="block";
    }
    if(estado=="block"){
        document.getElementById(id).style.display="none";
    }
    
}

/*
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
*/

/**
 * Agrega un condicional a la caja de texto utilizada para ese fin
 * @returns {undefined}
 */
function AgregaCondicional(){
   
    var Tabla = document.getElementById('TxtTabla').value
    var Columna = document.getElementById('CmbColumna').value
    var Condicional = document.getElementById('CmbCondicion').value
    var Busqueda = document.getElementById('TxtBusquedaTablas').value
    var CondicionActual = document.getElementById('TxtCondicion').value
    var CondicionFinal="";
    var Operador = "";
    var combo = document.getElementById("CmbColumna");
    var ColumnaSeleccionada = combo.options[combo.selectedIndex].text;
    document.getElementById('TxtPage').value=1;
    if(CondicionActual != ''){
        Operador = " AND ";
    }
    switch(Condicional) {
        case '=':            
            CondicionFinal= Operador + Columna + " = '" + Busqueda + "'";            
            break;
        case '*':            
            CondicionFinal= Operador + Columna + " LIKE '%" + Busqueda + "%'";            
            break;
        case '>':            
            CondicionFinal= Operador + Columna + " > '" + Busqueda + "'";            
            break;
        case '<':            
            CondicionFinal= Operador + Columna + " < '" + Busqueda + "'";            
            break;
        case '>=':            
            CondicionFinal= Operador + Columna + " >= '" + Busqueda + "'";            
            break;
        case '<=':            
            CondicionFinal= Operador + Columna + " <= '" + Busqueda + "'";            
            break;
        case '#%':            
            CondicionFinal= Operador + Columna + " LIKE '" + Busqueda + "%'";            
            break;
        case '<>':            
            CondicionFinal= Operador + Columna + " <> '" + Busqueda + "'";            
            break;    
    } 
    document.getElementById('TxtCondicion').value=document.getElementById('TxtCondicion').value+" "+CondicionFinal;
    
    SeleccionarTabla(Tabla);
    if(document.getElementById('DivFiltrosAplicados').innerHTML==''){
        document.getElementById('DivFiltrosAplicados').innerHTML='<a href="#" id="aBorrarFiltros" onclick="LimpiarFiltros();" style="color:green"><span class="btn btn-block btn-primary btn-xs"><strong>Limpiar Filtros</strong></span></a> <strong>Filtros Aplicados: </strong><br>';
    }
    var lista='<i class="fa fa-circle-o text-aqua"></i><span> '+ColumnaSeleccionada+' '+ Condicional + ' '+Busqueda+' </span><br>';
    document.getElementById('DivFiltrosAplicados').innerHTML=document.getElementById('DivFiltrosAplicados').innerHTML+" "+lista;
    
}

/*
 * Dibuja las acciones que se pueden realizar en una tabla
 * @returns {undefined}
 */
function DibujaAccionesTablas(Tabla){
       
    var form_data = new FormData();
        form_data.append('Accion', 4);
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
              document.getElementById('DivOpciones2').innerHTML=data;
              
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
 * Envia la peticion para realizar una consulta proveniente de las acciones
 * @returns {undefined}
 */
function ConsultaAccionesTablas(){
       
    var Tabla = document.getElementById('TxtTabla').value
    var Columna = document.getElementById('CmbColumnaAcciones').value
    var AccionTabla = document.getElementById('CmbAccionTabla').value
    var CondicionActual = document.getElementById('TxtCondicion').value    
    var combo = document.getElementById("CmbColumnaAcciones");
    var ColumnaSeleccionada = combo.options[combo.selectedIndex].text;   
    
    var combo2 = document.getElementById("CmbAccionTabla");
    var TxtAccionSeleccionada = combo2.options[combo2.selectedIndex].text;   
       
    var form_data = new FormData();
        form_data.append('Accion', 5);
        form_data.append('Tabla', Tabla);
        form_data.append('Columna', Columna);
        form_data.append('AccionTabla', AccionTabla);
        form_data.append('CondicionActual', CondicionActual);
        form_data.append('ColumnaSeleccionada', ColumnaSeleccionada);
        form_data.append('TxtAccionSeleccionada', TxtAccionSeleccionada);
        
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
                if(document.getElementById('DivResultadosAcciones').innerHTML==''){
                    document.getElementById('DivResultadosAcciones').innerHTML='<strong>Resultados: </strong><br>';
                }
                
                document.getElementById('DivResultadosAcciones').innerHTML=document.getElementById('DivResultadosAcciones').innerHTML+" "+data;
              
              
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
 * Cambia el limite de las tablas
 * @returns {undefined}
 */
function CambiarLimiteTablas(){
    var Tabla = document.getElementById('TxtTabla').value;
    var Limite = document.getElementById('CmbLimit').value;
    document.getElementById('TxtPage').value=1;
    document.getElementById('TxtLimit').value=Limite;
    SeleccionarTabla(Tabla);
}

function AvanzarPagina(){
    var Tabla = document.getElementById('TxtTabla').value;
    var PaginaActual = document.getElementById('TxtPage').value;
    PaginaActual++;
    document.getElementById('TxtPage').value=PaginaActual;
    SeleccionarTabla(Tabla);
}

function RetrocederPagina(){
    var Tabla = document.getElementById('TxtTabla').value;
    var PaginaActual = document.getElementById('TxtPage').value;
    PaginaActual--;
    if(PaginaActual>0){
        document.getElementById('TxtPage').value=PaginaActual;
        SeleccionarTabla(Tabla);
    }
}

function SeleccionaPagina(){
    var Tabla = document.getElementById('TxtTabla').value;
    var PaginaActual = document.getElementById('CmbPage').value;
    document.getElementById('TxtPage').value=PaginaActual;
    SeleccionarTabla(Tabla);
}
