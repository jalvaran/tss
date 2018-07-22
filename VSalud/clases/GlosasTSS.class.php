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
    public function DevolverFactura($idFactura,$ValorFactura,$FechaDevolucion,$FechaAuditoria,$Observaciones,$CodigoGlosa,$idUser,$Soporte,$Vector) {
        //////Hago el registro en la tabla             
        $tab="salud_registro_devoluciones_facturas";
        $NumRegistros=9;

        $Columnas[0]="FechaDevolucion";         $Valores[0]=$FechaDevolucion;
        $Columnas[1]="num_factura";             $Valores[1]=$idFactura;
        $Columnas[2]="Observaciones";           $Valores[2]=$Observaciones;
        $Columnas[3]="CodGlosa";                $Valores[3]=$CodigoGlosa;
        $Columnas[4]="idUser";                  $Valores[4]=$idUser;
        $Columnas[5]="Soporte";                 $Valores[5]=$Soporte;
        $Columnas[6]="FechaReciboAuditoria";    $Valores[6]=$FechaAuditoria;
        $Columnas[7]="FechaRegistro";           $Valores[7]=date("Y-m-d");
        $Columnas[8]="ValorFactura";            $Valores[8]=$ValorFactura;
        
        $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
        
        $this->ActualizaRegistro("salud_archivo_facturacion_mov_generados", "EstadoGlosa", 9, "num_factura", $idFactura);
        $this->ActualizaRegistro("salud_archivo_consultas", "EstadoGlosa", 9, "num_factura", $idFactura);
        $this->ActualizaRegistro("salud_archivo_procedimientos", "EstadoGlosa", 9, "num_factura", $idFactura);
        $this->ActualizaRegistro("salud_archivo_otros_servicios", "EstadoGlosa", 9, "num_factura", $idFactura);
        $this->ActualizaRegistro("salud_archivo_medicamentos", "EstadoGlosa", 9, "num_factura", $idFactura);
        $this->ActualizaRegistro("salud_archivo_control_glosas_respuestas", "EstadoGlosa", 9, "num_factura", $idFactura);
        
    }
    /**
     * Registra una glosa inicial temporal para ir agregando hasta que el auditor termine
     * @param type $idFactura
     * @param type $idActividad
     * @param type $FechaIPS
     * @param type $FechaAuditoria
     * 
     * @param type $CodigoGlosa
     * @param type $ValorEPS
     * @param type $ValorAceptado
     * @param type $ValorConciliar
     * 
     * @param type $Vector
     */
    public function RegistrarGlosaInicialTemporal($TipoArchivo,$idFactura, $idActividad,$TotalActividad, $FechaIPS, $FechaAuditoria, $CodigoGlosa, $ValorEPS, $ValorAceptado, $ValorConciliar,$Observaciones,$destino,$Vector) {
        $TotalGlosasExistentes=$this->Sume("salud_glosas_iniciales", "ValorGlosado", " WHERE num_factura='$idFactura' AND CodigoActividad='$idActividad'");
        $TotalGlosasTemporal=$this->Sume("salud_glosas_iniciales_temp", "ValorGlosado", " WHERE num_factura='$idFactura' AND CodigoActividad='$idActividad'");
        $TotalGlosasExistentes=$TotalGlosasExistentes+$TotalGlosasTemporal;
        if(($TotalGlosasExistentes+$ValorEPS)>$TotalActividad){
            exit("El valor Glosado Excede el total de la actividad.");
        }
        $FechaRegistro=date("Y-m-d");
        $tab="salud_glosas_iniciales_temp";
        $NumRegistros=16;

        $Columnas[0]="FechaIPS";                $Valores[0]=$FechaIPS;
        $Columnas[1]="FechaAuditoria";          $Valores[1]=$FechaAuditoria;
        $Columnas[2]="FechaRegistro";           $Valores[2]=$FechaRegistro;
        $Columnas[3]="CodigoGlosa";             $Valores[3]=$CodigoGlosa;
        $Columnas[4]="num_factura";             $Valores[4]=$idFactura;
        $Columnas[5]="CodigoActividad";         $Valores[5]=$idActividad;
        $Columnas[6]="EstadoGlosa";             $Valores[6]=1;
        $Columnas[7]="ValorGlosado";            $Valores[7]=$ValorEPS;
        $Columnas[8]="ValorLevantado";          $Valores[8]=0;
        $Columnas[9]="ValorAceptado";           $Valores[9]=$ValorAceptado;
        $Columnas[10]="ValorXConciliar";        $Valores[10]=$ValorEPS;
        $Columnas[11]="ValorConciliado";        $Valores[11]=0;
        $Columnas[12]="ValorActividad";         $Valores[12]=$TotalActividad;
        $Columnas[13]="TipoArchivo";            $Valores[13]=$TipoArchivo;
        $Columnas[14]="Observaciones";          $Valores[14]=$Observaciones;
        $Columnas[15]="Soporte";                $Valores[15]=$destino;
        
        $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
        $idGlosa=$this->ObtenerMAX($tab, "ID", 1, "");
        
        return($idGlosa);
        
    }
    /**
     * Registre una glosa inicial
     * @param type $idFactura
     * @param type $idActividad
     * @param type $ValorActividad
     * @param type $FechaIPS
     * @param type $FechaAuditoria
     * @param type $CodigoGlosa
     * @param type $ValorEPS
     * @param type $ValorAceptado
     * @param type $ValorConciliar
     * @param type $Vector
     * @return type
     */
    public function RegistrarGlosaInicial($idFactura,$idActividad,$ValorActividad,$FechaIPS,$FechaAuditoria,$CodigoGlosa,$ValorEPS,$ValorAceptado,$ValorConciliar,$Vector) {
        $TotalGlosasExistentes=$this->Sume("salud_glosas_iniciales", "ValorGlosado", " WHERE num_factura='$idFactura' AND CodigoActividad='$idActividad'");
        
        if(($TotalGlosasExistentes+$ValorEPS)>$ValorActividad){
            exit("El valor Glosado Excede el total de la actividad.");
        }
        $FechaRegistro=date("Y-m-d");
        $tab="salud_glosas_iniciales";
        $NumRegistros=13;

        $Columnas[0]="FechaIPS";                $Valores[0]=$FechaIPS;
        $Columnas[1]="FechaAuditoria";          $Valores[1]=$FechaAuditoria;
        $Columnas[2]="FechaRegistro";           $Valores[2]=$FechaRegistro;
        $Columnas[3]="CodigoGlosa";             $Valores[3]=$CodigoGlosa;
        $Columnas[4]="num_factura";             $Valores[4]=$idFactura;
        $Columnas[5]="CodigoActividad";         $Valores[5]=$idActividad;
        $Columnas[6]="EstadoGlosa";             $Valores[6]=1;
        $Columnas[7]="ValorGlosado";            $Valores[7]=$ValorEPS;
        $Columnas[8]="ValorLevantado";          $Valores[8]=0;
        $Columnas[9]="ValorAceptado";           $Valores[9]=$ValorAceptado;
        $Columnas[10]="ValorXConciliar";        $Valores[10]=$ValorEPS;
        $Columnas[11]="ValorConciliado";        $Valores[11]=0;
        $Columnas[12]="ValorActividad";         $Valores[12]=$ValorActividad;
        
        $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
        $idGlosa=$this->ObtenerMAX($tab, "ID", 1, "");
        
        return($idGlosa);
        
    }
    
    /**
     * Registra los datos para realizar una glosa, contraglosa o respuesta
     * 
     * @param type $TipoArchivo
     * @param type $idGlosa
     * @param type $idFactura
     * @param type $idActividad
     * @param type $TotalActividad
     * @param type $EstadoGlosa
     * @param type $FechaIPS
     * @param type $FechaAuditoria
     * @param type $Observaciones
     * @param type $CodigoGlosa
     * @param type $ValorEPS
     * @param type $ValorAceptado
     * @param type $ValorLevantado
     * @param type $ValorConciliar
     * @param type $destino
     * @param type $idUser
     * @param type $Vector
     */
    public function RegistraGlosaRespuesta($TipoArchivo,$idGlosa,$idFactura,$idActividad,$TotalActividad,$EstadoGlosa,$FechaIPS,$FechaAuditoria,$Observaciones,$CodigoGlosa,$ValorEPS,$ValorAceptado,$ValorLevantado,$ValorConciliar,$destino,$idUser,$Vector) {
        $DatosFactura= $this->ValorActual("salud_archivo_facturacion_mov_generados", " CuentaGlobal,CuentaRIPS ", " num_factura='$idFactura'");
        $DatosGlosaInicial= $this->ValorActual("salud_glosas_iniciales", " ValorXConciliar ", " ID='$idGlosa'");
        
        $FechaRegistro=date("Y-m-d");
        $tab="salud_archivo_control_glosas_respuestas";
        $NumRegistros=20;

        $Columnas[0]="num_factura";             $Valores[0]=$idFactura;
        $Columnas[1]="idGlosa";                 $Valores[1]=$idGlosa;
        $Columnas[2]="CuentaGlobal";            $Valores[2]=$DatosFactura["CuentaGlobal"];
        $Columnas[3]="CuentaRIPS";              $Valores[3]=$DatosFactura["CuentaRIPS"];
        $Columnas[4]="cod_glosa_general";       $Valores[4]=substr($CodigoGlosa,0,1);
        $Columnas[5]="cod_glosa_especifico";    $Valores[5]=substr($CodigoGlosa,1,2);
        $Columnas[6]="id_cod_glosa";            $Valores[6]=$CodigoGlosa;
        $Columnas[7]="CodigoActividad";         $Valores[7]=$idActividad;
        $Columnas[8]="EstadoGlosa";             $Valores[8]=$EstadoGlosa;
        $Columnas[9]="FechaIPS";                $Valores[9]=$FechaIPS;
        $Columnas[10]="FechaAuditoria";         $Valores[10]=$FechaAuditoria;
        $Columnas[11]="valor_actividad";        $Valores[11]=$TotalActividad;
        
        $Columnas[12]="valor_glosado_eps";      $Valores[12]=$ValorEPS;
        $Columnas[13]="valor_levantado_eps";    $Valores[13]=$ValorLevantado;
        $Columnas[14]="valor_aceptado_ips";     $Valores[14]=$ValorAceptado;
        $Columnas[15]="observacion_auditor";    $Valores[15]=$Observaciones;
        $Columnas[16]="Soporte";                $Valores[16]=$destino;
        $Columnas[17]="fecha_registo";          $Valores[17]=$FechaRegistro;
        $Columnas[18]="TipoArchivo";            $Valores[18]=$TipoArchivo;
        $Columnas[19]="idUser";                 $Valores[19]=$idUser;
        
        $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
    }
    
    //Fin Clases
}