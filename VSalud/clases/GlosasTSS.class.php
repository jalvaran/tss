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
        if($TipoArchivo=='AC'){
            $CodigoActivida=$this->ValorActual("salud_archivo_consultas", "cod_consulta as Codigo", " id_consultas='$idActividad'");
            $Codigo=$CodigoActivida["Codigo"];
            $DatosDescripcion=$this->ValorActual("salud_cups", "descripcion_cups as Descripcion", " codigo_sistema='$Codigo'");
            $Descripcion=$DatosDescripcion["Descripcion"];
        }
        if($TipoArchivo=='AP'){
            $CodigoActivida=$this->ValorActual("salud_archivo_procedimientos", "cod_procedimiento as Codigo", " id_procedimiento='$idActividad'");
            $Codigo=$CodigoActivida["Codigo"];
            $DatosDescripcion=$this->ValorActual("salud_cups", "descripcion_cups as Descripcion", " codigo_sistema='$Codigo'");
            $Descripcion=$DatosDescripcion["Descripcion"];
            
        }
        if($TipoArchivo=='AT'){
            $CodigoActivida=$this->ValorActual("salud_archivo_otros_servicios", "cod_servicio  as Codigo,nom_servicio as Descripcion", " id_otro_servicios='$idActividad'");
            $Codigo=$CodigoActivida["Codigo"];
            $Descripcion=$CodigoActivida["Descripcion"];
            
        }
        if($TipoArchivo=='AM'){
            $CodigoActivida=$this->ValorActual("salud_archivo_medicamentos", "cod_medicamento as Codigo,nom_medicamento as Descripcion", " id_medicamentos='$idActividad'");
            $Codigo=$CodigoActivida["Codigo"];
            $Descripcion=$CodigoActivida["Descripcion"];
            
        }
        if(($TotalGlosasExistentes+$ValorEPS)>$TotalActividad){
            exit("El valor Glosado Excede el total de la actividad.");
        }
        $sql="SELECT ID FROM salud_glosas_iniciales WHERE num_factura='$idFactura' AND CodigoActividad='$Codigo' AND CodigoGlosa='$CodigoGlosa'";
        $consulta=$this->Query($sql);
        $DatosGlosasIniciales= $this->FetchArray($consulta);
        if($DatosGlosasIniciales["ID"]<>''){
            $Mensaje["msg"]="El codigo de Glosa $CodigoGlosa ya fue registrado a la factura $idFactura y codigo de actividad $Codigo";
            $Mensaje["Error"]=1;
            exit(json_encode($Mensaje));
        }
        $sql="SELECT ID FROM salud_glosas_iniciales_temp WHERE num_factura='$idFactura' AND CodigoActividad='$Codigo' AND CodigoGlosa='$CodigoGlosa'";
        $consulta=$this->Query($sql);
        $DatosGlosasIniciales= $this->FetchArray($consulta);
        if($DatosGlosasIniciales["ID"]<>''){
            $Mensaje["msg"]="El codigo de Glosa $CodigoGlosa ya fue registrado a la factura $idFactura y codigo de actividad $Codigo";
            $Mensaje["Error"]=1;
            exit(json_encode($Mensaje));
        }
        $FechaRegistro=date("Y-m-d");
        $tab="salud_glosas_iniciales_temp";
        $NumRegistros=18;

        $Columnas[0]="FechaIPS";                $Valores[0]=$FechaIPS;
        $Columnas[1]="FechaAuditoria";          $Valores[1]=$FechaAuditoria;
        $Columnas[2]="FechaRegistro";           $Valores[2]=$FechaRegistro;
        $Columnas[3]="CodigoGlosa";             $Valores[3]=$CodigoGlosa;
        $Columnas[4]="num_factura";             $Valores[4]=$idFactura;
        $Columnas[5]="CodigoActividad";         $Valores[5]=$Codigo;
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
        $Columnas[16]="idArchivo";              $Valores[16]=$idActividad;
        $Columnas[17]="NombreActividad";        $Valores[17]=$Descripcion;
        
        $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
        $idGlosa=$this->ObtenerMAX($tab, "ID", 1, "");
        $Mensaje["msg"]="Glosa Agregada a la tabla temporal";
        return($Mensaje);
        
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
    public function RegistrarGlosaInicial($idFactura,$idActividad,$ValorActividad,$FechaIPS,$FechaAuditoria,$CodigoGlosa,$ValorEPS,$ValorAceptado,$ValorConciliar,$Vector,$ValorEdicion=0) {
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
    public function RegistraGlosaRespuesta($TipoArchivo,$idGlosa,$idFactura,$idActividad,$NombreActividad,$TotalActividad,$EstadoGlosa,$FechaIPS,$FechaAuditoria,$Observaciones,$CodigoGlosa,$ValorEPS,$ValorAceptado,$ValorLevantado,$ValorConciliar,$destino,$idUser,$Vector) {
        $DatosFactura= $this->ValorActual("salud_archivo_facturacion_mov_generados", " CuentaGlobal,CuentaRIPS ", " num_factura='$idFactura'");
        $DatosGlosaInicial= $this->ValorActual("salud_glosas_iniciales", " ValorXConciliar ", " ID='$idGlosa'");
        
        $FechaRegistro=date("Y-m-d");
        $tab="salud_archivo_control_glosas_respuestas";
        $NumRegistros=21;

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
        $Columnas[20]="DescripcionActividad";   $Valores[20]= utf8_decode($NombreActividad);
        
        $this->InsertarRegistro($tab,$NumRegistros,$Columnas,$Valores);
    }
    /**
     * Elimina una glosa temporal
     * @param type $idGlosa
     */
    public function EliminarGlosaTemporal($idGlosa) {
        $this->BorraReg("salud_glosas_iniciales_temp", "ID", $idGlosa);
    }
    /**
     * Guarda las glosas temporales en la tabla real, en la tabla de registros de respuesta y elimina de la tabla temporal
     * @param type $Vector
     */
    public function GuardaGlosasTemporalesAIniciales($idUser,$Vector) {
        $consulta=$this->ConsultarTabla("salud_glosas_iniciales_temp", "");
        $Estado=12;
        while($DatosGlosaTemporal=$this->FetchArray($consulta)){
            $NumFactura=$DatosGlosaTemporal["num_factura"];
            $CodActividad=$DatosGlosaTemporal["CodigoActividad"];
            $idGlosa=$this->RegistrarGlosaInicial($DatosGlosaTemporal["num_factura"], $DatosGlosaTemporal["CodigoActividad"], $DatosGlosaTemporal["ValorActividad"], $DatosGlosaTemporal["FechaIPS"], $DatosGlosaTemporal["FechaAuditoria"], $DatosGlosaTemporal["CodigoGlosa"], $DatosGlosaTemporal["ValorGlosado"], $DatosGlosaTemporal["ValorAceptado"], $DatosGlosaTemporal["ValorXConciliar"], "");
            $this->RegistraGlosaRespuesta($DatosGlosaTemporal["TipoArchivo"], $idGlosa, $DatosGlosaTemporal["num_factura"], $DatosGlosaTemporal["CodigoActividad"],$DatosGlosaTemporal["NombreActividad"], $DatosGlosaTemporal["ValorActividad"], 1, $DatosGlosaTemporal["FechaIPS"], $DatosGlosaTemporal["FechaAuditoria"], $DatosGlosaTemporal["Observaciones"], $DatosGlosaTemporal["CodigoGlosa"], $DatosGlosaTemporal["ValorGlosado"], $DatosGlosaTemporal["ValorAceptado"], 0, $DatosGlosaTemporal["ValorXConciliar"], $DatosGlosaTemporal["Soporte"], $idUser, "");
            $this->BorraReg("salud_glosas_iniciales_temp", "ID", $DatosGlosaTemporal["ID"]);
            if($DatosGlosaTemporal["TipoArchivo"]=="AC"){
                
                $TablaArchivo="salud_archivo_consultas";
                $ColCodigo="cod_consulta";
                $this->update($TablaArchivo, "EstadoGlosa", 1, "WHERE num_factura='$NumFactura' AND $ColCodigo='$CodActividad'");
                $this->ActualizaRegistro("salud_archivo_facturacion_mov_generados", "EstadoGlosa", 1, "num_factura", $NumFactura);
      
            }
            
            if($DatosGlosaTemporal["TipoArchivo"]=="AT"){
                
                $TablaArchivo="salud_archivo_otros_servicios";
                $ColCodigo="cod_servicio";
                $this->update($TablaArchivo, "EstadoGlosa", 1, "WHERE num_factura='$NumFactura' AND $ColCodigo='$CodActividad'");
                $this->ActualizaRegistro("salud_archivo_facturacion_mov_generados", "EstadoGlosa", 1, "num_factura", $NumFactura);
      
            }
            
            if($DatosGlosaTemporal["TipoArchivo"]=="AP"){
                
                $TablaArchivo="salud_archivo_procedimientos";
                $ColCodigo="cod_procedimiento";
                $this->update($TablaArchivo, "EstadoGlosa", 1, "WHERE num_factura='$NumFactura' AND $ColCodigo='$CodActividad'");
                $this->ActualizaRegistro("salud_archivo_facturacion_mov_generados", "EstadoGlosa", 1, "num_factura", $NumFactura);
      
            }
            
            if($DatosGlosaTemporal["TipoArchivo"]=="AM"){
                
                $TablaArchivo="salud_archivo_medicamentos";
                $ColCodigo="cod_medicamento";
                $this->update($TablaArchivo, "EstadoGlosa", 1, "WHERE num_factura='$NumFactura' AND $ColCodigo='$CodActividad'");
                $this->ActualizaRegistro("salud_archivo_facturacion_mov_generados", "EstadoGlosa", 1, "num_factura", $NumFactura);
      
            }
            
       
        }
        $this->VaciarTabla("salud_glosas_iniciales_temp");
        
    }
    /**
     * Registra respuestas en tabla temporal
     * @param type $TipoArchivo
     * @param type $idGlosa
     * @param type $idFactura
     * @param type $idActividad
     * @param type $NombreActividad
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
    public function RegistraGlosaRespuestaTemporal($idReplace,$TipoArchivo,$idGlosa,$idFactura,$idActividad,$NombreActividad,$TotalActividad,$EstadoGlosa,$FechaIPS,$FechaAuditoria,$Observaciones,$CodigoGlosa,$ValorEPS,$ValorAceptado,$ValorLevantado,$ValorConciliar,$destino,$idUser,$Vector) {
        $DatosFactura= $this->ValorActual("salud_archivo_facturacion_mov_generados", " CuentaGlobal,CuentaRIPS ", " num_factura='$idFactura'");
        //$DatosGlosaInicial= $this->ValorActual("salud_glosas_iniciales", " ValorXConciliar ", " ID='$idGlosa'");
        
        $FechaRegistro=date("Y-m-d");
        $tab="salud_archivo_control_glosas_respuestas_temp";
        $Datos["ID"]=$idReplace;               
        $Datos["num_factura"]=$idFactura;
        $Datos["idGlosa"]=$idGlosa;
        $Datos["CuentaGlobal"]=$DatosFactura["CuentaGlobal"];
        $Datos["CuentaRIPS"]=$DatosFactura["CuentaRIPS"];
        $Datos["cod_glosa_general"]=substr($CodigoGlosa,0,1);
        $Datos["cod_glosa_especifico"]=substr($CodigoGlosa,1,2);
        $Datos["id_cod_glosa"]=$CodigoGlosa;
        $Datos["CodigoActividad"]=$idActividad;
        $Datos["EstadoGlosa"]=$EstadoGlosa;
        $Datos["FechaIPS"]=$FechaIPS;
        $Datos["FechaAuditoria"]=$FechaAuditoria;
        $Datos["valor_actividad"]=$TotalActividad;
        $Datos["valor_glosado_eps"]=$ValorEPS;
        $Datos["valor_levantado_eps"]=$ValorLevantado;
        $Datos["valor_aceptado_ips"]=$ValorAceptado;
        $Datos["observacion_auditor"]=$Observaciones;
        $Datos["Soporte"]=$destino;
        $Datos["fecha_registo"]=$FechaRegistro;
        $Datos["TipoArchivo"]=$TipoArchivo;
        $Datos["idUser"]=$idUser;
        $Datos["DescripcionActividad"]=$NombreActividad;
        if($idReplace=''){
            $sql=$this->getSQLInsert($tab, $Datos);
        }else{
            $sql=$this->getSQLReeplace($tab, $Datos);
        }
        
        $this->Query($sql);
               
    }
    public function EditaGlosaRespuestaTemporal($idGlosaTemp,$TipoArchivo,$idArchivo,$idFactura,$idActividad,$NombreActividad,$TotalActividad,$EstadoGlosa,$FechaIPS,$FechaAuditoria,$Observaciones,$CodigoGlosa,$ValorEPS,$ValorAceptado,$ValorLevantado,$ValorConciliar,$destino,$idUser,$Vector) {
        $DatosFactura= $this->ValorActual("salud_archivo_facturacion_mov_generados", " CuentaGlobal,CuentaRIPS ", " num_factura='$idFactura'");
        //$DatosGlosaInicial= $this->ValorActual("salud_glosas_iniciales", " ValorXConciliar ", " ID='$idGlosa'");
        
        $FechaRegistro=date("Y-m-d");
        $tab="salud_glosas_iniciales_temp";
        $Datos["ID"]=$idGlosaTemp;    //            
        $Datos["num_factura"]=$idFactura;//
        //$Datos["idGlosa"]=$idGlosa;//
        $Datos["ValorConciliado"]=$ValorConciliar;
        
        
        $Datos["CodigoGlosa"]=$CodigoGlosa;//
        $Datos["CodigoActividad"]=$idActividad;//
        $Datos["EstadoGlosa"]=$EstadoGlosa;//
        $Datos["FechaIPS"]=$FechaIPS;//
        $Datos["FechaAuditoria"]=$FechaAuditoria;//
        $Datos["ValorActividad"]=$TotalActividad;//
        $Datos["ValorGlosado"]=$ValorEPS;//
        $Datos["ValorLevantado"]=$ValorLevantado;//
        $Datos["ValorAceptado"]=$ValorAceptado;//
        $Datos["ValorXConciliar"]=$ValorEPS-$ValorAceptado-$ValorLevantado;//
        $Datos["NombreActividad"]=$NombreActividad;
        $Datos["FechaRegistro"]=$FechaRegistro;//
        $Datos["TipoArchivo"]=$TipoArchivo;//
        $Datos["idArchivo"]=$idArchivo;//
        $Datos["Observaciones"]=$Observaciones;//
        $Datos["Soporte"]=$destino;//
               
        $sql=$this->getSQLReeplace($tab, $Datos);
        
        
        $this->Query($sql);
               
    }
    /**
     * Guarda las respuestas de las glosas que estan en la temporal a la real
     * @param type $idUser
     * @param type $Vector
     */
    public function GuardaRespuestasGlosasTemporalAReal($idUser,$Vector){
        
        //Copio las respuestas cuyo valor Glosado sea diferente al aceptado
        $sql="INSERT INTO salud_archivo_control_glosas_respuestas (num_factura, idGlosa,CuentaGlobal,CuentaRIPS,cod_glosa_general,"
                . "cod_glosa_especifico,id_cod_glosa,CodigoActividad,DescripcionActividad,EstadoGlosa,FechaIPS,FechaAuditoria,valor_actividad,"
                . "valor_glosado_eps,valor_levantado_eps,valor_aceptado_ips,observacion_auditor,Soporte,fecha_registo,TipoArchivo,idUser) "
                . "SELECT "
                . "num_factura, idGlosa,CuentaGlobal,CuentaRIPS,cod_glosa_general,"
                . "cod_glosa_especifico,id_cod_glosa,CodigoActividad,DescripcionActividad,EstadoGlosa,FechaIPS,FechaAuditoria,valor_actividad,"
                . "valor_glosado_eps,valor_levantado_eps,valor_aceptado_ips,observacion_auditor,Soporte,fecha_registo,TipoArchivo,idUser "
                . "FROM salud_archivo_control_glosas_respuestas_temp WHERE EstadoGlosa=2 AND valor_glosado_eps <> valor_aceptado_ips" ;
        
        $this->Query($sql);
        //Copio las respuestas en estado 2 (respondida) cuyo valor Glosado sea igual al aceptado pero con la columna tratado =1
        $sql="INSERT INTO salud_archivo_control_glosas_respuestas (num_factura, idGlosa,CuentaGlobal,CuentaRIPS,cod_glosa_general,"
                . "cod_glosa_especifico,id_cod_glosa,CodigoActividad,DescripcionActividad,EstadoGlosa,FechaIPS,FechaAuditoria,valor_actividad,"
                . "valor_glosado_eps,valor_levantado_eps,valor_aceptado_ips,observacion_auditor,Soporte,fecha_registo,TipoArchivo,idUser,Tratado) "
                . "SELECT "
                . "num_factura, idGlosa,CuentaGlobal,CuentaRIPS,cod_glosa_general,"
                . "cod_glosa_especifico,id_cod_glosa,CodigoActividad,DescripcionActividad,'2',FechaIPS,FechaAuditoria,valor_actividad,"
                . "valor_glosado_eps,valor_levantado_eps,valor_aceptado_ips,observacion_auditor,Soporte,fecha_registo,TipoArchivo,idUser,'1' "
                . "FROM salud_archivo_control_glosas_respuestas_temp WHERE EstadoGlosa=2 AND valor_glosado_eps=valor_aceptado_ips" ;
        
        $this->Query($sql);
        
        //Copio las respuestas en estado 7 (Aceptada) cuyo valor Glosado sea igual al aceptado pero con la columna tratado =1
      
        $sql="INSERT INTO salud_archivo_control_glosas_respuestas (num_factura, idGlosa,CuentaGlobal,CuentaRIPS,cod_glosa_general,"
                . "cod_glosa_especifico,id_cod_glosa,CodigoActividad,DescripcionActividad,EstadoGlosa,FechaIPS,FechaAuditoria,valor_actividad,"
                . "valor_glosado_eps,valor_levantado_eps,valor_aceptado_ips,observacion_auditor,Soporte,fecha_registo,TipoArchivo,idUser) "
                . "SELECT "
                . "num_factura, idGlosa,CuentaGlobal,CuentaRIPS,cod_glosa_general,"
                . "cod_glosa_especifico,id_cod_glosa,CodigoActividad,DescripcionActividad,'7',FechaIPS,FechaAuditoria,valor_actividad,"
                . "valor_glosado_eps,valor_levantado_eps,valor_aceptado_ips,observacion_auditor,Soporte,fecha_registo,TipoArchivo,idUser "
                . "FROM salud_archivo_control_glosas_respuestas_temp WHERE EstadoGlosa=2 AND valor_glosado_eps=valor_aceptado_ips" ;
        
        $this->Query($sql);
        
        $sql="SELECT *,valor_aceptado_ips AS ValorIPS FROM salud_archivo_control_glosas_respuestas_temp WHERE EstadoGlosa=2 ";
        $consulta= $this->Query($sql);
        while($DatosTemp=$this->FetchArray($consulta)){
            $ValorAceptadoIPS=$DatosTemp["ValorIPS"];
            $ValorGlosado=$DatosTemp["valor_glosado_eps"];
            $Estado=2;
            if($ValorAceptadoIPS==$ValorGlosado){
                $Estado=7;
            }
            $NumFactura=$DatosTemp["num_factura"];
            $CodigoActividad=$DatosTemp["CodigoActividad"];
            $idGlosa=$DatosTemp["idGlosa"];
            //Actualizo los datos de las glosas iniciales
            $sql="UPDATE salud_glosas_iniciales SET EstadoGlosa='$Estado',ValorAceptado='$ValorAceptadoIPS',ValorXConciliar=ValorGlosado-ValorAceptado WHERE ID='$idGlosa'";
            $this->Query($sql);
            //Actualizo la columna tratado de las respuestas para saber que ya se trató ese registro
            $sql="UPDATE salud_archivo_control_glosas_respuestas SET Tratado=1 WHERE idGlosa='$idGlosa' AND EstadoGlosa=1";
            $this->Query($sql);
            //Actualizo el estado de las facturas
            $sql="SELECT MIN(EstadoGlosa) as MinEstado FROM salud_archivo_control_glosas_respuestas WHERE num_factura='$NumFactura' AND Tratado=0";
            $Datos=$this->Query($sql);
            $Datos= $this->FetchArray($Datos);
            $EstadoGlosaFactura=$Datos["MinEstado"];
            
            $this->ActualizaRegistro("salud_archivo_facturacion_mov_generados", "EstadoGlosa", $EstadoGlosaFactura, "num_factura", $NumFactura);
            $TipoArchivo=$DatosTemp["TipoArchivo"];
            //Actualizo el estado de las actividades
            if($TipoArchivo=="AC"){
                
                $this->update("salud_archivo_consultas", "EstadoGlosa", $Estado, " WHERE num_factura='$NumFactura' AND cod_consulta='$CodigoActividad'");
                
            }
            if($TipoArchivo=="AP"){
               
                $this->update("salud_archivo_procedimientos", "EstadoGlosa", $Estado, " WHERE num_factura='$NumFactura' AND cod_procedimiento='$CodigoActividad'");
                
            }
            if($TipoArchivo=="AT"){
               
                $this->update("salud_archivo_otros_servicios", "EstadoGlosa", $Estado, " WHERE num_factura='$NumFactura' AND cod_servicio='$CodigoActividad'");
                
            }
            if($TipoArchivo=="AM"){
               
                $this->update("salud_archivo_medicamentos", "EstadoGlosa", $Estado, " WHERE num_factura='$NumFactura' AND cod_medicamento='$CodigoActividad'");
                
            }
        }
        
        //$this->VaciarTabla("salud_archivo_control_glosas_respuestas_temp");
        
       }
     /**
     * Guarda las  contra glosas que estan en la temporal a la real
     * @param type $idUser
     * @param type $Vector
     */
    public function GuardaContraGlosasTemporalAReal($idUser,$Vector){
        
        //Copio las contra Glosas cuando el valor a conciliar es diferente a cero
        $sql="INSERT INTO salud_archivo_control_glosas_respuestas (num_factura, idGlosa,CuentaGlobal,CuentaRIPS,cod_glosa_general,"
                . "cod_glosa_especifico,id_cod_glosa,CodigoActividad,DescripcionActividad,EstadoGlosa,FechaIPS,FechaAuditoria,valor_actividad,"
                . "valor_glosado_eps,valor_levantado_eps,valor_aceptado_ips,observacion_auditor,Soporte,fecha_registo,TipoArchivo,idUser) "
                . "SELECT "
                . "num_factura, idGlosa,CuentaGlobal,CuentaRIPS,cod_glosa_general,"
                . "cod_glosa_especifico,id_cod_glosa,CodigoActividad,DescripcionActividad,EstadoGlosa,FechaIPS,FechaAuditoria,valor_actividad,"
                . "valor_glosado_eps,valor_levantado_eps,valor_aceptado_ips,observacion_auditor,Soporte,fecha_registo,TipoArchivo,idUser "
                . "FROM salud_archivo_control_glosas_respuestas_temp WHERE EstadoGlosa=3 AND valor_levantado_eps <> valor_glosado_eps-valor_aceptado_ips" ;
        
        $this->Query($sql);
        //Copio las contra Glosas en estado 3 (ContraGlosado) cuando el valor x conciliar sea cero, pero con la columna tratado =1
        $sql="INSERT INTO salud_archivo_control_glosas_respuestas (num_factura, idGlosa,CuentaGlobal,CuentaRIPS,cod_glosa_general,"
                . "cod_glosa_especifico,id_cod_glosa,CodigoActividad,DescripcionActividad,EstadoGlosa,FechaIPS,FechaAuditoria,valor_actividad,"
                . "valor_glosado_eps,valor_levantado_eps,valor_aceptado_ips,observacion_auditor,Soporte,fecha_registo,TipoArchivo,idUser,Tratado) "
                . "SELECT "
                . "num_factura, idGlosa,CuentaGlobal,CuentaRIPS,cod_glosa_general,"
                . "cod_glosa_especifico,id_cod_glosa,CodigoActividad,DescripcionActividad,EstadoGlosa,FechaIPS,FechaAuditoria,valor_actividad,"
                . "valor_glosado_eps,valor_levantado_eps,valor_aceptado_ips,observacion_auditor,Soporte,fecha_registo,TipoArchivo,idUser,'1' "
                . "FROM salud_archivo_control_glosas_respuestas_temp WHERE EstadoGlosa=3 AND valor_levantado_eps=valor_glosado_eps-valor_aceptado_ips" ;
        
        $this->Query($sql);
        
        //Copio las respuestas en estado 5 (Conciliada) cuyo valor Glosado sea igual al aceptado pero con la columna tratado =1
      
        $sql="INSERT INTO salud_archivo_control_glosas_respuestas (num_factura, idGlosa,CuentaGlobal,CuentaRIPS,cod_glosa_general,"
                . "cod_glosa_especifico,id_cod_glosa,CodigoActividad,DescripcionActividad,EstadoGlosa,FechaIPS,FechaAuditoria,valor_actividad,"
                . "valor_glosado_eps,valor_levantado_eps,valor_aceptado_ips,observacion_auditor,Soporte,fecha_registo,TipoArchivo,idUser) "
                . "SELECT "
                . "num_factura, idGlosa,CuentaGlobal,CuentaRIPS,cod_glosa_general,"
                . "cod_glosa_especifico,id_cod_glosa,CodigoActividad,DescripcionActividad,'5',FechaIPS,FechaAuditoria,valor_actividad,"
                . "valor_glosado_eps,valor_levantado_eps,valor_aceptado_ips,observacion_auditor,Soporte,fecha_registo,TipoArchivo,idUser "
                . "FROM salud_archivo_control_glosas_respuestas_temp WHERE EstadoGlosa=3 AND valor_levantado_eps=valor_glosado_eps-valor_aceptado_ips" ;
        
        $this->Query($sql);
        
        $sql="SELECT *,valor_aceptado_ips AS ValorIPS FROM salud_archivo_control_glosas_respuestas_temp WHERE EstadoGlosa=3 ";
        $consulta= $this->Query($sql);
        while($DatosTemp=$this->FetchArray($consulta)){
            $ValorAceptadoIPS=$DatosTemp["ValorIPS"];
            $ValorGlosado=$DatosTemp["valor_glosado_eps"];
            $ValorLevantado=$DatosTemp["valor_levantado_eps"];
            $Estado=3;
            if($ValorLevantado=$ValorGlosado-$ValorAceptadoIPS){
                $Estado=5;
            }
            $ValorXConciliar=$ValorGlosado-$ValorAceptadoIPS-$ValorLevantado;
            $NumFactura=$DatosTemp["num_factura"];
            $CodigoActividad=$DatosTemp["CodigoActividad"];
            $idGlosa=$DatosTemp["idGlosa"];
            //Actualizo los datos de las glosas iniciales
            $sql="UPDATE salud_glosas_iniciales SET ValorLevantado='$ValorLevantado',EstadoGlosa='$Estado',ValorAceptado='$ValorAceptadoIPS',ValorXConciliar='$ValorXConciliar' WHERE ID='$idGlosa'";
            $this->Query($sql);
            //Actualizo la columna tratado de las respuestas para saber que ya se trató ese registro
            $sql="UPDATE salud_archivo_control_glosas_respuestas SET Tratado=1 WHERE idGlosa='$idGlosa' AND EstadoGlosa=2";
            $this->Query($sql);
            //Actualizo el estado de las facturas
            $sql="SELECT MIN(EstadoGlosa) as MinEstado FROM salud_archivo_control_glosas_respuestas WHERE num_factura='$NumFactura' AND Tratado=0";
            $Datos=$this->Query($sql);
            $Datos= $this->FetchArray($Datos);
            $EstadoGlosaFactura=$Datos["MinEstado"];
            
            $this->ActualizaRegistro("salud_archivo_facturacion_mov_generados", "EstadoGlosa", $EstadoGlosaFactura, "num_factura", $NumFactura);
            $TipoArchivo=$DatosTemp["TipoArchivo"];
            //Actualizo el estado de las actividades
            if($TipoArchivo=="AC"){
                
                $this->update("salud_archivo_consultas", "EstadoGlosa", $Estado, " WHERE num_factura='$NumFactura' AND cod_consulta='$CodigoActividad'");
                
            }
            if($TipoArchivo=="AP"){
               
                $this->update("salud_archivo_procedimientos", "EstadoGlosa", $Estado, " WHERE num_factura='$NumFactura' AND cod_procedimiento='$CodigoActividad'");
                
            }
            if($TipoArchivo=="AT"){
               
                $this->update("salud_archivo_otros_servicios", "EstadoGlosa", $Estado, " WHERE num_factura='$NumFactura' AND cod_servicio='$CodigoActividad'");
                
            }
            if($TipoArchivo=="AM"){
               
                $this->update("salud_archivo_medicamentos", "EstadoGlosa", $Estado, " WHERE num_factura='$NumFactura' AND cod_medicamento='$CodigoActividad'");
                
            }
        }
        
        
        
       }
    
    //Fin Clases
}