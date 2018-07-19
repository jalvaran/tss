<?php
/* 
 * Clase donde se realizaran procesos de para Devolver o Glosar Facturas 
 * Julian Andres Alvaran
 * Techno Soluciones SAS en asociacion con SITIS SAS
 * 2018-07-19
 */

class Glosas extends conexion{
   /**
    * Clase para devolver una factura
    * @param type $idFactura
    * @param type $FechaDevolucion
    * @param type $Observaciones
    * @param type $CodigoGlosa
    * @param type $idUser
    * @param type $Soporte
    * @param type $Vector
    * Creada: 2018-07-19 Julian Alvaran
    */
    public function DevolverFactura($idFactura,$FechaDevolucion,$Observaciones,$CodigoGlosa,$idUser,$Soporte,$Vector) {
        //////Hago el registro en la tabla             
        $tab="salud_registro_devoluciones_facturas";
        $NumRegistros=6;

        $Columnas[0]="FechaDevolucion";	$Valores[0]=$FechaDevolucion;
        $Columnas[1]="num_factura";     $Valores[1]=$idFactura;
        $Columnas[2]="Observaciones";   $Valores[2]=$Observaciones;
        $Columnas[3]="CodGlosa";        $Valores[3]=$CodigoGlosa;
        $Columnas[4]="idUser";          $Valores[4]=$idUser;
        $Columnas[5]="Soporte";         $Valores[5]=$Soporte;
        
        $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
        
        $this->ActualizaRegistro("salud_archivo_facturacion_mov_generados", "EstadoGlosa", 9, "num_factura", $idFactura);
        $this->ActualizaRegistro("salud_archivo_consultas", "EstadoGlosa", 9, "num_factura", $idFactura);
        $this->ActualizaRegistro("salud_archivo_procedimientos", "EstadoGlosa", 9, "num_factura", $idFactura);
        $this->ActualizaRegistro("salud_archivo_otros_servicios", "EstadoGlosa", 9, "num_factura", $idFactura);
        $this->ActualizaRegistro("salud_archivo_medicamentos", "EstadoGlosa", 9, "num_factura", $idFactura);
        $this->ActualizaRegistro("salud_archivo_control_glosas_respuestas", "EstadoGlosa", 9, "num_factura", $idFactura);
        
    }
    
    //Fin Clases
}