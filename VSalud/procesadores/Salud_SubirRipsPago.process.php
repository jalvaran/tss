<?php

session_start();
if (!isset($_SESSION['username'])){
  exit("<a href='../index.php' ><img src='../images/401.png'>Iniciar Sesion </a>");
  
}
$idUser=$_SESSION['idUser'];
$TipoUser=$_SESSION['tipouser'];
include_once("../../modelo/php_conexion.php");
include_once("../css_construct.php");
include_once("../clases/SaludRips.class.php");


$obCon = new Rips($idUser);
if($_REQUEST["idAccion"]){
    $css =  new CssIni("id",0);
    $obRips = new Rips($idUser);
    switch ($_REQUEST["idAccion"]){
        case 1: //Subir el archivo, renombrarlo con la el numero del giro y guardarlo en la carpeta archivos
            
            $Separador=$obRips->normalizar($_REQUEST["CmbSeparador"]);
            $TipoGiro=$obRips->normalizar($_REQUEST["CmbTipoGiro"]);
            $FechaGiro=$obRips->normalizar($_REQUEST["TxtFechaGira"]);
            $FechaCargue=date("Y-m-d H:i:s");
            $destino="";
            if(!empty($_FILES['UpSoporte']['name'])){
                
                //echo "<script>alert ('entra foto')</script>";
                $Atras="../";
                $carpeta="SoportesSalud/SoportesAR/";
                opendir($Atras.$Atras.$carpeta);
                $Name=str_replace(' ','_',$_FILES['UpSoporte']['name']);  
                $destino=$carpeta.$Name;
                move_uploaded_file($_FILES['UpSoporte']['tmp_name'],$Atras.$Atras.$destino);
            }
            if(!empty($_FILES['UpPago']['name'])){
                $Atras="../";
                $carpeta=$Atras."ArchivosTemporales/";
                opendir($carpeta);
                $NombreArchivo=str_replace(' ','_',$_FILES['UpPago']['name']);  
                move_uploaded_file($_FILES['UpPago']['tmp_name'],$carpeta.$NombreArchivo);
                
                $handle = fopen($carpeta.$NombreArchivo, "r");
                //print($carpeta.$NombreArchivo);
                if($Separador==1){
                    $SeparadorT=";"; 
                 }else{
                    $SeparadorT=",";  
                 }
                 //print($SeparadorT);
                $i=0;
                while (($data = fgetcsv($handle, 1000, $SeparadorT)) !== FALSE) {
                    $i++;
                    if(!isset($data[10])){
                        exit("El archivo no es válido");
                    }
                    if($i==2){
                        $Giro=str_replace(".","",$data[10]);
                        $Giro=str_replace(",00","",$Giro);
                        
                    }
                }
                fclose($handle);
                
                $NombreAR="AR".$Giro.".txt";
                $destinoAR="../archivos/".$NombreAR;
                copy($carpeta.$NombreArchivo,$destinoAR);
                unlink($carpeta.$NombreArchivo);
              
                $obRips->VaciarTabla("salud_pagos_temporal"); //Vacío la tabla de subida temporal
                                
            }
            
            //Verificamos si el archivo ya fue subido
            
            $DatosUploads=$obRips->DevuelveValores("salud_upload_control", "nom_cargue", $NombreAR);
            
            if($DatosUploads["id_upload_control"]==''){
                $obRips->VaciarTabla("salud_subir_rips_pago_control");
                $Datos["ArchivoActual"]=$NombreAR;
                $Datos["idUser"]=$idUser;
                $Datos["Separador"]=$Separador;
                $Datos["Destino"]=$destino;
                $Datos["FechaGiro"]=$FechaGiro;
                $Datos["FechaCargue"]=$FechaCargue;
                $Datos["TipoGiro"]=$TipoGiro;
                $sql=$obRips->getSQLInsert("salud_subir_rips_pago_control", $Datos);
                $obRips->Query($sql);
                print("OK");
                
            }else{
                $css->CrearNotificacionAzul("El archivo ya fue subido el $DatosUploads[fecha_cargue], por el usuario $DatosUploads[idUser]",16);
            }
            
            
        break;
        case 2: //insertar rips a tabla temporal
            
            $DatosArchivoActual=$obRips->DevuelveValores("salud_subir_rips_pago_control", "ID", 1);
            $obRips->InsertarRipsPagosAdres($DatosArchivoActual["ArchivoActual"],$DatosArchivoActual["Separador"], $DatosArchivoActual["FechaCargue"], $idUser,$DatosArchivoActual["Destino"],$DatosArchivoActual["FechaGiro"],$DatosArchivoActual["TipoGiro"], "");
            $obRips->AnaliceInsercionFacturasPagadasAdres("");
            print("OK");
            
        break;  
        case 3://Encuentre Facturas Pagadas con diferencia
            $obCon->EncuentreFacturasPagadasConDiferencia("");
            print("OK");
            
        break;
    
        case 4://Encuentre Facturas Pagas
            $obCon->EncuentreFacturasPagadas("");
            print("OK");
            
        break;
    
               
    }
    
}else{
    
    print("No se recibieron parametros");
}
    
    

?>