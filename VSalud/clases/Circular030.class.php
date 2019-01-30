<?php
/* 
 * Clase donde se realizaran procesos de compras u otros modulos.
 * Julian Alvaran
 * Techno Soluciones SAS
 */
//include_once '../../php_conexion.php';
class Circular030 extends conexion{
    public function CrearCircular030($FechaInicial,$FechaFinal,$Tipo,$Vector) {
        $DatosIPS=$this->DevuelveValores("empresapro", "idEmpresaPro", 1);
        $Nit=str_pad($DatosIPS["NIT"], 12, "0", STR_PAD_LEFT);
        $FechaCorte= str_replace("-", "", $FechaFinal);
        $NombreCircular="SAC165FIPS".$FechaCorte."NI".$Nit.".txt";
        $nombre_archivo = "../ArchivosTemporales/$NombreCircular";
        //Si existe el archivo lo borro
        if(file_exists($nombre_archivo)){
            unlink($nombre_archivo);
        }
          //Sentencia para generar la circular 030
        
        $sql="SELECT '2' as TipoRegistro, @rownum:=@rownum+1 as ConsecutivoRegistro, 
            tipo_ident_prest_servicio as TipoIdentificacionERP, 
            (SELECT nit FROM salud_eps WHERE salud_eps.cod_pagador_min=t1.cod_enti_administradora) as NumeroIdentificacionERP, 
            nom_enti_administradora as RazonSocialIPS, 
            'NI' as TipoIdentificacionIPS, 
            (SELECT NIT FROM empresapro WHERE idEmpresaPro=1) as NumeroIdentificacionIPS, 
            'F' as TipoCobro,num_factura,'I' as IndicadorActualizacion,valor_neto_pagar as Valor,
            fecha_factura as FechaEmision,fecha_radicado as FechaPresentacion,'' as FechaDevolucion,
            '0' as ValorPagado,'0' as ValorGlosaAceptada,'NO' as GlosaRespondida, 
            (SELECT Valor-ValorPagado-ValorGlosaAceptada) as SaldoFactura, 'NO' as CobroJuridico, '0' as EtapaCobroJuridico
            FROM (SELECT @rownum:=0) r, vista_af t1 
            WHERE  t1.GeneraCircular='S' AND t1.estado='RADICADO' AND fecha_radicado>='$FechaInicial' AND fecha_radicado<='$FechaFinal'
                
            UNION ALL
            
            SELECT '2' as TipoRegistro, @rownum:=@rownum+1 as ConsecutivoRegistro, 
            tipo_ident_prest_servicio as TipoIdentificacionERP, 
            (SELECT nit FROM salud_eps WHERE salud_eps.cod_pagador_min=t1.cod_enti_administradora) as NumeroIdentificacionERP, 
            nom_enti_administradora as RazonSocialIPS, 
            'NI' as TipoIdentificacionIPS, 
            (SELECT NIT FROM empresapro WHERE idEmpresaPro=1) as NumeroIdentificacionIPS, 
            'F' as TipoCobro,num_factura,'I' as IndicadorActualizacion,valor_neto_pagar as Valor,
            fecha_factura as FechaEmision,fecha_radicado as FechaPresentacion,'' as FechaDevolucion,
            '0' as ValorPagado,'0' as ValorGlosaAceptada,'NO' as GlosaRespondida, 
            (SELECT Valor-ValorPagado-ValorGlosaAceptada) as SaldoFactura,
            'SI' as CobroJuridico, EstadoCobro as EtapaCobroJuridico
            FROM (SELECT @rownum:=0) r, vista_af t1 
            WHERE t1.GeneraCircular='S' AND t1.estado='JURIDICO' AND fecha_radicado>='$FechaInicial' AND fecha_radicado<='$FechaFinal'

            UNION ALL

            SELECT '2' as TipoRegistro, @rownum:=@rownum+1 as ConsecutivoRegistro, 
            tipo_ident_prest_servicio as TipoIdentificacionERP, 
            (SELECT nit FROM salud_eps WHERE salud_eps.cod_pagador_min=t1.cod_enti_administradora) as NumeroIdentificacionERP, 
            nom_enti_administradora as RazonSocialIPS, 
            'NI' as TipoIdentificacionIPS, 
            (SELECT NIT FROM empresapro WHERE idEmpresaPro=1) as NumeroIdentificacionIPS, 
            'F' as TipoCobro,num_factura,'A' as IndicadorActualizacion,valor_neto_pagar as Valor,
            fecha_factura as FechaEmision,fecha_radicado as FechaPresentacion,'' as FechaDevolucion,
            '0' as ValorPagado,'0' as ValorGlosaAceptada,'NO' as GlosaRespondida, 
            (SELECT Valor-ValorPagado-ValorGlosaAceptada) as SaldoFactura,
            'NO' as CobroJuridico, '0' as EtapaCobroJuridico
            FROM (SELECT @rownum:=0) r, vista_af t1 
            WHERE t1.GeneraCircular='S' AND t1.estado='RADICADO' AND fecha_radicado<'$FechaInicial'
                
            UNION ALL
            
            SELECT '2' as TipoRegistro, @rownum:=@rownum+1 as ConsecutivoRegistro, 
            tipo_ident_prest_servicio as TipoIdentificacionERP,  
            (SELECT nit FROM salud_eps WHERE salud_eps.cod_pagador_min=t1.cod_enti_administradora) as NumeroIdentificacionERP, 
            nom_enti_administradora as RazonSocialIPS, 
            'NI' as TipoIdentificacionIPS, 
            (SELECT NIT FROM empresapro WHERE idEmpresaPro=1) as NumeroIdentificacionIPS, 
            'F' as TipoCobro,num_factura,'A' as IndicadorActualizacion,valor_neto_pagar as Valor,
            fecha_factura as FechaEmision,fecha_radicado as FechaPresentacion,'' as FechaDevolucion,
            '0' as ValorPagado,'0' as ValorGlosaAceptada,'NO' as GlosaRespondida, 
            (SELECT Valor-ValorPagado-ValorGlosaAceptada) as SaldoFactura,
            'SI' as CobroJuridico, EstadoCobro as EtapaCobroJuridico
            FROM (SELECT @rownum:=0) r, vista_af t1 
            WHERE t1.GeneraCircular='S' AND t1.estado='JURIDICO' AND fecha_radicado<'$FechaInicial'

            UNION ALL

            SELECT '2' as TipoRegistro, @rownum:=@rownum+1 as ConsecutivoRegistro, 
            tipo_ident_prest_servicio as TipoIdentificacionERP, 
            (SELECT nit FROM salud_eps WHERE salud_eps.cod_pagador_min=t1.cod_enti_administradora) as NumeroIdentificacionERP, 
            nom_enti_administradora as RazonSocialIPS, 
            'NI' as TipoIdentificacionIPS, 
            (SELECT NIT FROM empresapro WHERE idEmpresaPro=1) as NumeroIdentificacionIPS, 
            'F' as TipoCobro,num_factura,'A' as IndicadorActualizacion,valor_neto_pagar as Valor,
            fecha_factura as FechaEmision,fecha_radicado as FechaPresentacion,'' as FechaDevolucion,
            (SELECT IFNULL((SELECT SUM(valor_pagado) FROM salud_archivo_facturacion_mov_pagados WHERE salud_archivo_facturacion_mov_pagados.num_factura=t1.num_factura),0)) as ValorPagado,
            (SELECT IFNULL((SELECT SUM(GlosaAceptada) FROM salud_registro_glosas WHERE salud_registro_glosas.num_factura=t1.num_factura),0)) as ValorGlosaAceptada,
            (SELECT IF((SELECT SUM(GlosaAceptada) FROM salud_registro_glosas WHERE salud_registro_glosas.num_factura=t1.num_factura)>0,'SI','NO')) as GlosaRespondida, 
            (SELECT Valor-ValorPagado-ValorGlosaAceptada) as SaldoFactura,
            'NO' as CobroJuridico, '0' as EtapaCobroJuridico
            FROM (SELECT @rownum:=0) r, vista_af t1 
            WHERE t1.GeneraCircular='S' AND t1.estado='DIFERENCIA' AND fecha_radicado>='$FechaInicial' AND fecha_radicado<='$FechaFinal'

            UNION ALL

            SELECT '2' as TipoRegistro, @rownum:=@rownum+1 as ConsecutivoRegistro, 
            tipo_ident_prest_servicio as TipoIdentificacionERP, 
            (SELECT nit FROM salud_eps WHERE salud_eps.cod_pagador_min=t1.cod_enti_administradora) as NumeroIdentificacionERP, 
            nom_enti_administradora as RazonSocialIPS, 
            'NI' as TipoIdentificacionIPS, 
            (SELECT NIT FROM empresapro WHERE idEmpresaPro=1) as NumeroIdentificacionIPS, 
            'F' as TipoCobro,num_factura,'A' as IndicadorActualizacion,valor_neto_pagar as Valor,
            fecha_factura as FechaEmision,fecha_radicado as FechaPresentacion,'' as FechaDevolucion,
            (SELECT IFNULL((SELECT SUM(valor_pagado) FROM salud_archivo_facturacion_mov_pagados WHERE salud_archivo_facturacion_mov_pagados.num_factura=t1.num_factura),0)) as ValorPagado,
            (SELECT IFNULL((SELECT SUM(GlosaAceptada) FROM salud_registro_glosas WHERE salud_registro_glosas.num_factura=t1.num_factura),0)) as ValorGlosaAceptada,
            (SELECT IF((SELECT SUM(GlosaAceptada) FROM salud_registro_glosas WHERE salud_registro_glosas.num_factura=t1.num_factura)>0,'SI','NO')) as GlosaRespondida, 
            (SELECT Valor-ValorPagado-ValorGlosaAceptada) as SaldoFactura,
            'NO' as CobroJuridico, '0' as EtapaCobroJuridico
            FROM (SELECT @rownum:=0) r, vista_af t1 
            WHERE t1.GeneraCircular='S' AND t1.estado='DIFERENCIA' AND fecha_radicado<'$FechaInicial'
             
            UNION ALL

            SELECT '2' as TipoRegistro, @rownum:=@rownum+1 as ConsecutivoRegistro, 
            tipo_ident_prest_servicio as TipoIdentificacionERP, 
            (SELECT nit FROM salud_eps WHERE salud_eps.cod_pagador_min=t1.cod_enti_administradora) as NumeroIdentificacionERP, 
            nom_enti_administradora as RazonSocialIPS, 
            'NI' as TipoIdentificacionIPS, 
            (SELECT NIT FROM empresapro WHERE idEmpresaPro=1) as NumeroIdentificacionIPS, 
            'F' as TipoCobro,num_factura,'E' as IndicadorActualizacion,valor_neto_pagar as Valor,
            fecha_factura as FechaEmision,fecha_radicado as FechaPresentacion,'' as FechaDevolucion,
            (SELECT IFNULL((SELECT SUM(valor_pagado) FROM salud_archivo_facturacion_mov_pagados WHERE salud_archivo_facturacion_mov_pagados.num_factura=t1.num_factura),0)) as ValorPagado,
            (SELECT IFNULL((SELECT SUM(GlosaAceptada) FROM salud_registro_glosas WHERE salud_registro_glosas.num_factura=t1.num_factura),0)) as ValorGlosaAceptada,
            (SELECT IF((SELECT SUM(GlosaAceptada) FROM salud_registro_glosas WHERE salud_registro_glosas.num_factura=t1.num_factura)>0,'SI','NO')) as GlosaRespondida, 
            (SELECT Valor-ValorPagado-ValorGlosaAceptada) as SaldoFactura,
            'NO' as CobroJuridico, '0' as EtapaCobroJuridico
            FROM (SELECT @rownum:=0) r, vista_af t1 
            WHERE t1.GeneraCircular='S' AND t1.estado='DEVUELTA' AND fecha_radicado<='$FechaFinal'
                
            "
             
             ;
        
        //Las pagas si el usuario elije esa opcion
        if($Tipo=='2'){
            $sql.=" UNION ALL
                SELECT '2' as TipoRegistro, @rownum:=@rownum+1 as ConsecutivoRegistro, 
            tipo_ident_prest_servicio as TipoIdentificacionERP, 
            (SELECT nit FROM salud_eps WHERE salud_eps.cod_pagador_min=t1.cod_enti_administradora) as NumeroIdentificacionERP, 
            nom_enti_administradora as RazonSocialIPS, 
            'NI' as TipoIdentificacionIPS, 
            (SELECT NIT FROM empresapro WHERE idEmpresaPro=1) as NumeroIdentificacionIPS, 
            'F' as TipoCobro,num_factura,'A' as IndicadorActualizacion,valor_neto_pagar as Valor,
            fecha_factura as FechaEmision,fecha_radicado as FechaPresentacion,'' as FechaDevolucion,
            (SELECT IFNULL((SELECT SUM(valor_pagado) FROM salud_archivo_facturacion_mov_pagados WHERE salud_archivo_facturacion_mov_pagados.num_factura=t1.num_factura),0)) as ValorPagado,
            (SELECT IFNULL((SELECT SUM(GlosaAceptada) FROM salud_registro_glosas WHERE salud_registro_glosas.num_factura=t1.num_factura),0)) as ValorGlosaAceptada,
            'NO' as GlosaRespondida, 
            (SELECT Valor-ValorPagado-ValorGlosaAceptada) as SaldoFactura,
            'NO' as CobroJuridico, '0' as EtapaCobroJuridico
            FROM (SELECT @rownum:=0) r, vista_af t1 
            WHERE  t1.GeneraCircular='S' AND t1.estado='PAGADA' AND fecha_radicado<='$FechaFinal'
                
                     ";
        }
        //Las eliminadas del 030 inicial
        $sql.=" UNION ALL

            SELECT '2' as TipoRegistro, @rownum:=@rownum+1 as ConsecutivoRegistro, 
            tipo_ident_erp as TipoIdentificacionERP, 
            num_ident_erp as NumeroIdentificacionERP, 
            razon_social as RazonSocialIPS, 
            tipo_ident_ips as TipoIdentificacionIPS, 
            num_ident_ips as NumeroIdentificacionIPS, 
            tipo_cobro as TipoCobro,numero_factura as num_factura,'E' as IndicadorActualizacion,valor_factura as Valor,
            fecha_factura as FechaEmision,fecha_radicado as FechaPresentacion,'' as FechaDevolucion,
            (SELECT IFNULL((SELECT SUM(valor_pagado) FROM salud_archivo_facturacion_mov_pagados WHERE salud_archivo_facturacion_mov_pagados.num_factura=t1.numero_factura),0)) as ValorPagado,
            valor_glosa_acept as ValorGlosaAceptada,
            glosa_respondida as GlosaRespondida, 
            (SELECT Valor-ValorPagado-ValorGlosaAceptada) as SaldoFactura,
            cobro_juridico as CobroJuridico, etapa_proceso as EtapaCobroJuridico
            FROM (SELECT @rownum:=0) r, salud_circular030_inicial t1 
            WHERE t1.indic_act_fact='E' AND t1.fecha_radicado<'$FechaFinal'
                  ";
                
        $consulta=$this->Query($sql);
        if($archivo = fopen($nombre_archivo, "a")){
            $mensaje="";
            while($Datos030= $this->FetchArray($consulta)){
                
                for($i=0;$i<20;$i++){
                    $Datos030[$i]= $this->QuitarAcentos($Datos030[$i]);
                    $Datos030[$i]= trim($Datos030[$i]);
                    if($i==8){
                        $Caracter=strpos($Datos030[$i], "-");
                        if($Caracter !== false){
                            $DatosNumFactura=explode("-", $Datos030[$i]);
                            $Prefijo=$DatosNumFactura[0];
                            //$Prefijo=preg_replace('/[0-9]/', '', $Datos030[$i]);
                            //$Prefijo= str_replace("-", "", $Prefijo);
                            $NumeroFactura=$DatosNumFactura[1];
                        }else{
                            $Prefijo="";
                            $NumeroFactura=$Datos030[$i];
                        }
                        //$NumeroFactura=intval(preg_replace('/[^0-9]+/', '', $Datos030[$i]));
                        //if($Prefijo==''){
                          //  $Prefijo=0;
                        //}
                        $mensaje.=$Prefijo.",".$NumeroFactura.",";
                    }else{
                        $mensaje.=$Datos030[$i].",";
                    }
                    
                }
                $Contador=$Datos030[1];
                $mensaje=substr($mensaje, 0, -1);
                $mensaje.="\r\n";
            }
            $mensaje=substr($mensaje, 0, -2);
            
            $RegistroControl="1,NI,".$DatosIPS["NIT"].",".$DatosIPS["RazonSocial"].",$FechaInicial,$FechaFinal,$Contador";
            $RegistroControl.="\r\n";
            fwrite($archivo, $RegistroControl.$mensaje);
            fclose($archivo);
        }
        return($NombreCircular);
    }
    /**
     * Escribe la 030 los datos generados en estado radicado durante el rango seleccionado
     * @param type $FechaInicial
     * @param type $FechaFinal
     * @param type $Inicia
     * @param type $Tipo
     * @param type $Vector
     */
    public function Escribir030_Radicados_Rango($FechaInicial,$FechaFinal,$Contador,$Tipo,$Vector) {
        $nombre_archivo = "../ArchivosTemporales/pre_Circular030.txt";
        //Si existe el archivo y no se ha iniciado la escritura
        
        if(file_exists($nombre_archivo) and $Contador==''){
            unlink($nombre_archivo);
        }
       
        if($Contador==''){
            $Contador=0;
            $limit="LIMIT 5000";
        }else{
            $limit="LIMIT $Contador,5000";
        }
        
        $sql="SELECT * FROM vista_circular030_1_radicados "
                        . "WHERE FechaPresentacion>='$FechaInicial' AND FechaPresentacion<='$FechaFinal' $limit";
        
        $consulta=$this->Query($sql);
        
        if($archivo = fopen($nombre_archivo, "a")){
            
            $mensaje="";
            while($Datos030= $this->FetchArray($consulta)){
                $Contador++;
                for($i=0;$i<=18;$i++){
                    $Datos030[$i]= $this->QuitarAcentos($Datos030[$i]);
                    $Datos030[$i]= trim($Datos030[$i]);
                    if($i==7){
                        $Prefijo=preg_replace('/[^A-Za-z]+/', '', $Datos030[$i]);
                        $NumeroFactura=preg_replace('/[^0-9]+/', '', $Datos030[$i]);
                        
                        $mensaje.=$Prefijo.",".$NumeroFactura.",";
                    }else if($i==0){
                        $mensaje.=$Datos030[$i].",$Contador,";
                    }else{
                        $mensaje.=$Datos030[$i].",";
                    }
                    
                }
                
                $mensaje=substr($mensaje, 0, -1);
                $mensaje.="\r\n";
            }
            //$mensaje=substr($mensaje, 0, -2);
            fwrite($archivo, $mensaje);
            fclose($archivo);
        }
        return($Contador);
    }
    
    
    /**
     * Escribe la 030 los datos generados en estado de cobro juridico durante el rango seleccionado
     * @param type $FechaInicial
     * @param type $FechaFinal
     * @param type $Inicia
     * @param type $Tipo
     * @param type $Vector
     */
    public function Escribir030_Juridicos_Rango($FechaInicial,$FechaFinal,$Contador,$Tipo,$ContadorGeneral,$Vector) {
        $nombre_archivo = "../ArchivosTemporales/pre_Circular030.txt";
               
        if($Contador==''){
            $Contador=0;
            $limit="LIMIT 5000";
        }else{
            $limit="LIMIT $Contador,5000";
        }
        
        $sql="SELECT * FROM vista_circular030_2_juridicos "
                        . "WHERE FechaPresentacion>='$FechaInicial' AND FechaPresentacion<='$FechaFinal' $limit";
        
        $consulta=$this->Query($sql);
        
        if($archivo = fopen($nombre_archivo, "a")){
            
            $mensaje="";
            while($Datos030= $this->FetchArray($consulta)){
                $Contador++;
                $ContadorGeneral++;
                for($i=0;$i<=18;$i++){
                    $Datos030[$i]= $this->QuitarAcentos($Datos030[$i]);
                    $Datos030[$i]= trim($Datos030[$i]);
                    if($i==7){
                        $Prefijo=preg_replace('/[^A-Za-z]+/', '', $Datos030[$i]);
                        $NumeroFactura=preg_replace('/[^0-9]+/', '', $Datos030[$i]);                    
                        
                        $mensaje.=$Prefijo.",".$NumeroFactura.",";
                    }else if($i==0){
                        $mensaje.=$Datos030[$i].",$ContadorGeneral,";
                    }else{
                        $mensaje.=$Datos030[$i].",";
                    }
                    
                }
                
                $mensaje=substr($mensaje, 0, -1);
                $mensaje.="\r\n";
            }
            //$mensaje=substr($mensaje, 0, -2);
            fwrite($archivo, $mensaje);
            fclose($archivo);
        }
        $Contadores[0]=$Contador;
        $Contadores[1]=$ContadorGeneral;
        return($Contadores);
    }
    /**
     * Escribe los radicados anteriores al rango seleccionado
     * @param type $FechaInicial
     * @param type $FechaFinal
     * @param int $Contador
     * @param type $Tipo
     * @param type $Vector
     * @return type
     */
    public function Escribir030_Radicados_Iniciales($FechaInicial,$FechaFinal,$Contador,$Tipo,$ContadorGeneral,$Vector) {
        $nombre_archivo = "../ArchivosTemporales/pre_Circular030.txt";
        
        if($Contador==''){
            $Contador=0;
            $limit="LIMIT 5000";
        }else{
            $limit="LIMIT $Contador,5000";
        }
        
        $sql="SELECT * FROM vista_circular030_1_radicados "
                        . "WHERE FechaPresentacion<'$FechaInicial' $limit";
        
        $consulta=$this->Query($sql);
        
        if($archivo = fopen($nombre_archivo, "a")){
            
            $mensaje="";
            while($Datos030= $this->FetchArray($consulta)){
                $Contador++;
                $ContadorGeneral++;
                for($i=0;$i<=18;$i++){
                    $Datos030[$i]= $this->QuitarAcentos($Datos030[$i]);
                    $Datos030[$i]= trim($Datos030[$i]);
                    if($i==7){
                        $Prefijo=preg_replace('/[^A-Za-z]+/', '', $Datos030[$i]);
                        $NumeroFactura=preg_replace('/[^0-9]+/', '', $Datos030[$i]);
                        
                        $mensaje.=$Prefijo.",".$NumeroFactura.",";
                    }else if($i==0){
                        $mensaje.=$Datos030[$i].",$ContadorGeneral,";
                    }else{
                        $mensaje.=$Datos030[$i].",";
                    }
                    
                }
                
                $mensaje=substr($mensaje, 0, -1);
                $mensaje.="\r\n";
            }
            //$mensaje=substr($mensaje, 0, -2);
            fwrite($archivo, $mensaje);
            fclose($archivo);
        }
       $Contadores[0]=$Contador;
       $Contadores[1]=$ContadorGeneral;
       return($Contadores);
    }
    
    //Fin Clases
}