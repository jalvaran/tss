
if ($('#Login').length) {
    
    document.getElementById("Login").addEventListener("change", VerificaLogin);
    
}

if ($('#RutaImagen').length) {
    
    document.getElementById("RutaImagen").addEventListener("change", ValideImagenEmpresa);
    
}

function VerificaLogin(){
    var form_data = new FormData();
        form_data.append('idAccion', 1);
        form_data.append('Login', $('#Login').val());
      
    $.ajax({
        
        url: 'buscadores/ConsultarLogin.search.php',
        //dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(data){
            console.log(data)
           if(data=="Error"){
                alertify.alert("El usuario ya Existe");
                document.getElementById('BtnGuardarRegistro').disabled=true;
            }else{
                alertify.success("Usuario disponible");
                document.getElementById('BtnGuardarRegistro').disabled=false;
            }
            
        },
        error: function (xhr, ajaxOptions, thrownError) {
            //alert("Error al tratar de borrar el archivo");
            alert(xhr.status);
            alert(thrownError);
          }
      })
}


function ValideImagenEmpresa(){
    var fileInput = document.getElementById('RutaImagen');
    var filePath = fileInput.value;
    var allowedExtensions = /(.jpg|.jpeg|.png|.gif)$/i;
    if(!allowedExtensions.exec(filePath)){
        alertify.alert('Solo se permiten archivos con extension .jpeg/.jpg/.png/.gif');
        fileInput.value = '';
        document.getElementById('BtnGuardarRegistro').disabled=true;
        return false;
    }else{
        document.getElementById('BtnGuardarRegistro').disabled=false;
        alertify.success("Imagen permitida");
    }
}
