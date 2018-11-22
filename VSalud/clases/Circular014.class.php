<?php
/* 
 * Clase donde se realizaran procesos de compras u otros modulos.
 * Julian Alvaran
 * Techno Soluciones SAS
 */
//include_once '../../php_conexion.php';
class Circular014 extends conexion{
    public function CrearCircular014($MesRadicado,$AnioRadicado,$Vector) {
        $DatosIPS=$this->DevuelveValores("empresapro", "idEmpresaPro", 1);
        $Nit=$DatosIPS["NIT"];
        $FechaInicial="$AnioRadicado-$MesRadicado-01";
        $FechaFinal="$AnioRadicado-$MesRadicado-21";        
        $NombreCircular=$Nit.$DatosIPS["DV"].$MesRadicado.$AnioRadicado."179.txt";
        $nombre_archivo = "../ArchivosTemporales/$NombreCircular";
        //Si existe el archivo lo borro
        if(file_exists($nombre_archivo)){
            unlink($nombre_archivo);
        }
        
        $sql="SELECT *, (SELECT DV FROM empresapro WHERE empresapro.CodigoPrestadora=salud_archivo_facturacion_mov_generados.cod_prest_servicio LIMIT 1) AS DV,"
                . "(SELECT CodigoDANE FROM empresapro WHERE empresapro.CodigoPrestadora=salud_archivo_facturacion_mov_generados.cod_prest_servicio LIMIT 1) AS CodigoDANE "
                . " FROM salud_archivo_facturacion_mov_generados WHERE fecha_radicado >= '$FechaInicial' AND fecha_radicado <= '$FechaFinal'";
                
        $consulta=$this->Query($sql);
        if($archivo = fopen($nombre_archivo, "a")){
            $mensaje="";
            
            while($Datos014= $this->FetchArray($consulta)){
                $TipoNegociacion=1;
                if($Datos014["tipo_negociacion"]<>'capita'){
                    $TipoNegociacion=2;
                }
                $mensaje.=$Datos014["num_ident_prest_servicio"].",";
                $mensaje.=$Datos014["DV"].",";
                $mensaje.=$MesRadicado.",";
                $mensaje.=$AnioRadicado.",";
                $mensaje.=$TipoNegociacion.",";
                $mensaje.=round($Datos014["valor_neto_pagar"]).",";
                $mensaje.=$Datos014["cod_enti_administradora"].",";
                $mensaje.=$Datos014["CodigoDANE"].",";
                $mensaje.="0";//Averiguar que dato debe ir
                
                $mensaje.="\r\n";
            }
            $mensaje=substr($mensaje, 0, -2);
            
            fwrite($archivo, $mensaje);
            fclose($archivo);
        }
        return($NombreCircular);
    }
    
    //Fin Clases
}