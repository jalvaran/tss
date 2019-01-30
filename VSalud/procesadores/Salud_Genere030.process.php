<?php

session_start();
if (!isset($_SESSION['username'])){
  exit("<a href='../index.php' ><img src='../images/401.png'>Iniciar Sesion </a>");
  
}
$idUser=$_SESSION['idUser'];
$TipoUser=$_SESSION['tipouser'];
include_once("../../modelo/php_conexion.php");
include_once("../css_construct.php");
include_once("../clases/Circular030.class.php");

if($_REQUEST["idAccion"]){
    $css =  new CssIni("id",0);
    $obCon = new Circular030($idUser);
    switch ($_REQUEST["idAccion"]){
        case 1:
                        
            $TxtFechaInicial=$obCon->normalizar($_REQUEST["TxtFechaInicial"]);
            $TxtFechaFinal=$obCon->normalizar($_REQUEST["TxtFechaFinal"]);
            $CmbAdicional=$obCon->normalizar($_REQUEST["CmbAdicional"]);
            $Contador=$obCon->normalizar($_REQUEST["Contador"]);
            $TotalRegistros=$obCon->normalizar($_REQUEST["TotalRegistros"]);
            if($TotalRegistros==''){
                $sql="SELECT COUNT(*) as TotalRegistros FROM vista_circular030_1_radicados "
                        . "WHERE FechaPresentacion>='$TxtFechaInicial' AND FechaPresentacion<='$TxtFechaFinal'";
                $consulta=$obCon->Query($sql);
                $DatosRegistros=$obCon->FetchAssoc($consulta);
                $TotalRegistros=$DatosRegistros["TotalRegistros"];
            }
            $TotalRegistrosRealizados=$obCon->Escribir030_Radicados_Rango($TxtFechaInicial, $TxtFechaFinal, $Contador, $CmbAdicional, "");
            $Fin="";
            if($TotalRegistrosRealizados==$TotalRegistros){
                $Fin="Fin";
            }
            print("OK;$TotalRegistros;$TotalRegistrosRealizados;$Fin");
            
        break;
        case 2:// registro los juridicos
                        
            $TxtFechaInicial=$obCon->normalizar($_REQUEST["TxtFechaInicial"]);
            $TxtFechaFinal=$obCon->normalizar($_REQUEST["TxtFechaFinal"]);
            $CmbAdicional=$obCon->normalizar($_REQUEST["CmbAdicional"]);
            $Contador=$obCon->normalizar($_REQUEST["Contador"]);
            $TotalRegistros=$obCon->normalizar($_REQUEST["TotalRegistros"]);
            $ContadorGeneral=$obCon->normalizar($_REQUEST["ContadorGeneral"]);
            if($ContadorGeneral==''){
                $ContadorGeneral=0;
            }
            if($TotalRegistros==''){
                $sql="SELECT COUNT(*) as TotalRegistros FROM vista_circular030_2_juridicos "
                        . "WHERE FechaPresentacion>='$TxtFechaInicial' AND FechaPresentacion<='$TxtFechaFinal'";
                $consulta=$obCon->Query($sql);
                $DatosRegistros=$obCon->FetchAssoc($consulta);
                $TotalRegistros=$DatosRegistros["TotalRegistros"];
            }
            $Contadores=$obCon->Escribir030_Juridicos_Rango($TxtFechaInicial, $TxtFechaFinal, $Contador, $CmbAdicional,$ContadorGeneral, "");
            $TotalRegistrosRealizados=$Contadores[0];
            $Fin="";
            if($TotalRegistrosRealizados==$TotalRegistros){
                $Fin="Fin";
            }
            $ContadorGeneral=$Contadores[1];
            print("OK;$TotalRegistros;$TotalRegistrosRealizados;$Fin;$ContadorGeneral");
            
        break;//Fin caso 2
        case 3:
                        
            $TxtFechaInicial=$obCon->normalizar($_REQUEST["TxtFechaInicial"]);
            $TxtFechaFinal=$obCon->normalizar($_REQUEST["TxtFechaFinal"]);
            $CmbAdicional=$obCon->normalizar($_REQUEST["CmbAdicional"]);
            $Contador=$obCon->normalizar($_REQUEST["Contador"]);
            $TotalRegistros=$obCon->normalizar($_REQUEST["TotalRegistros"]);
            $ContadorGeneral=$obCon->normalizar($_REQUEST["ContadorGeneral"]);
            
            if($TotalRegistros==''){
                $sql="SELECT COUNT(*) as TotalRegistros FROM vista_circular030_1_radicados "
                        . "WHERE FechaPresentacion<'$TxtFechaInicial'";
                $consulta=$obCon->Query($sql);
                $DatosRegistros=$obCon->FetchAssoc($consulta);
                $TotalRegistros=$DatosRegistros["TotalRegistros"];
            }
            $Contadores=$obCon->Escribir030_Radicados_Iniciales($TxtFechaInicial, $TxtFechaFinal, $Contador, $CmbAdicional,$ContadorGeneral, "");
            $TotalRegistrosRealizados=$Contadores[0];
            $Fin="";
            if($TotalRegistrosRealizados==$TotalRegistros){
                $Fin="Fin";
            }
            $ContadorGeneral=$Contadores[1];
            print("OK;$TotalRegistros;$TotalRegistrosRealizados;$Fin;$ContadorGeneral");
            
        break;
               
    }
    
}else{
    
    print("No se recibieron parametros");
}
    
    

?>