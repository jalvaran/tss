<?php
/* 
 * Clase donde se realizaran la generacion de informes.
 * Julian Alvaran
 * Techno Soluciones SAS
 */

class Reportes extends conexion{
    /**
     * Se cargan las facturas que se deberan consultar para plasmar las respuestas en un excel
     * @param type $CuentaRIPS
     * @param type $idFactura
     * @param type $idEPS
     * @param type $Vector
     */
    public function CargaFacturasAResponder($CuentaRIPS,$idFactura,$idEPS,$Vector) {
        $Tabla="salud_control_generacion_respuestas_excel";
        $Datos["CuentaRIPS"]=$CuentaRIPS;
        $Datos["idEPS"]=$idEPS;
        $Datos["num_factura"]=$idFactura;
        $sql= $this->getSQLInsert($Tabla, $Datos);
        $this->Query($sql);
        
    }
    
    public function CrearArchivoRespuestas($Nombre,$Soportes,$Vector) {
        require_once '../../librerias/Excel/PHPExcel.php';        
        $objPHPExcel = new PHPExcel(); 
        $objPHPExcel->
        getProperties()
            ->setCreator("www.technosoluciones.com.co")
            ->setLastModifiedBy("www.technosoluciones.com.co")
            ->setTitle("Respuestas Glosas")
            ->setSubject("Informe")
            ->setDescription("Documento generado con PHPExcel")
            ->setKeywords("Techno Soluciones SAS")
            ->setCategory("Reportes");    

        
        $objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');
        $objWriter->save("../ArchivosTemporales/Reportes/$Nombre");
        
    }
    
    public function RegistreRespuestasFacturaExcel($NombreArchivo,$Vector) {
        $Negrilla = array( 'font' => array( 'bold' => true ) ); 
        require_once '../../librerias/Excel/PHPExcel/IOFactory.php';
        
        $NombreArchivo="../ArchivosTemporales/Reportes/".$NombreArchivo;
        
	
	// Creamos un objeto PHPExcel
	$objPHPExcel = new PHPExcel();
        
	$objReader = PHPExcel_IOFactory::createReader('Excel2007');
	$objPHPExcel = $objReader->load($NombreArchivo);   
        
	// Indicamos que se pare en la hoja uno del libro
	$objPHPExcel->setActiveSheetIndex(0);
	$objPHPExcel->getActiveSheet()->getStyle("A:N")->getFont()->setSize(10);
        $sql="SELECT re.idEPS,num_factura,nombre_completo,direccion,telefonos,email FROM salud_control_generacion_respuestas_excel re "
                . "INNER JOIN salud_eps se ON cod_pagador_min=idEPS WHERE re.Generada=0";
        $consulta= $this->Query($sql);
        //$consulta=$this->ConsultarTabla("salud_control_generacion_respuestas_excel", "WHERE Generada=0");
        $i=2;       
        $EncabezadoInforme=1;
        while($DatosFacturas=$this->FetchArray($consulta)){
            $idFactura=$DatosFacturas["num_factura"];
            $sql="SELECT * FROM vista_salud_respuestas WHERE factura='$idFactura' AND cod_estado=2 or cod_estado=4";
            $Datos= $this->Query($sql);
            $EncabezadoFacturas=1;
            $EncabezadoDatosFacturas=1;
            
            while($DatosRespuesta= $this->FetchAssoc($Datos)){
                if($EncabezadoInforme==1){
                    $DatosIPS= $this->DevuelveValores("empresapro", "idEmpresaPro", 1);
                    $objPHPExcel->getActiveSheet()->getStyle("D$i")->getFont()->setSize(10)->setBold(true); 
                    $objPHPExcel->getActiveSheet()->SetCellValue("D$i", utf8_encode($DatosIPS["RazonSocial"]));
                    $i++;
                    $objPHPExcel->getActiveSheet()->getStyle("D$i")->getFont()->setSize(10)->setBold(true); 
                    $objPHPExcel->getActiveSheet()->SetCellValue("D$i", $DatosIPS["NIT"]);
                    $i++;
                    $objPHPExcel->getActiveSheet()->getStyle("D$i")->getFont()->setSize(10)->setBold(true); 
                    $objPHPExcel->getActiveSheet()->SetCellValue("D$i", $DatosIPS["Direccion"]);
                    $i++;
                    $objPHPExcel->getActiveSheet()->getStyle("D$i")->getFont()->setSize(10)->setBold(true); 
                    $objPHPExcel->getActiveSheet()->SetCellValue("D$i", $DatosIPS["Telefono"]);
                    $i++;
                    $objPHPExcel->getActiveSheet()->getStyle("D$i")->getFont()->setSize(10)->setBold(true); 
                    $objPHPExcel->getActiveSheet()->SetCellValue("D$i", $DatosIPS["Email"]);
                    $i++;$i++;
                    $objPHPExcel->getActiveSheet()->getStyle("D$i")->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID) ->getStartColor()->setARGB("8fe5ff");
                   
                    $objPHPExcel->getActiveSheet()->getStyle("D$i")->getFont()->setSize(10)->setBold(true); 
                    $objPHPExcel->getActiveSheet()->SetCellValue("D$i", "INFORME DE RESPUESTAS A GLOSAS");
                    $i++;$i++;
                    $objPHPExcel->getActiveSheet()->getStyle("A$i")->getFont()->setSize(10)->setBold(true); 
                    $objPHPExcel->getActiveSheet()->SetCellValue("A$i", 'NOMBRE ASEGURADORA');
                    $objPHPExcel->getActiveSheet()->SetCellValue("B$i", utf8_encode($DatosFacturas["nombre_completo"]));
                    $i++;
                    $objPHPExcel->getActiveSheet()->getStyle("A$i")->getFont()->setSize(10)->setBold(true);
                    $objPHPExcel->getActiveSheet()->SetCellValue("A$i", 'CÓDIGO MINSALUD');
                    $objPHPExcel->getActiveSheet()->SetCellValue("B$i", $DatosFacturas["idEPS"]);
                    $i++;
                    $objPHPExcel->getActiveSheet()->getStyle("A$i")->getFont()->setSize(10)->setBold(true);
                    $objPHPExcel->getActiveSheet()->SetCellValue("A$i", 'DIRECCIÓN');
                    $objPHPExcel->getActiveSheet()->SetCellValue("B$i", $DatosFacturas["direccion"]);
                    $i++;
                    $objPHPExcel->getActiveSheet()->getStyle("A$i")->getFont()->setSize(10)->setBold(true);
                    $objPHPExcel->getActiveSheet()->SetCellValue("A$i", 'TELÉFONOS');
                    $objPHPExcel->getActiveSheet()->SetCellValue("B$i", $DatosFacturas["telefonos"]);
                    $i++;
                    $objPHPExcel->getActiveSheet()->getStyle("A$i")->getFont()->setSize(10)->setBold(true);
                    $objPHPExcel->getActiveSheet()->SetCellValue("A$i", 'EMAIL');
                    $objPHPExcel->getActiveSheet()->SetCellValue("B$i", $DatosFacturas["email"]);
                    
                    $i++;
                    $EncabezadoInforme=0;
                }
                
                if($EncabezadoFacturas==1){
                    $i++;$i++;$i++;
                    $Color='ffe6b6';
                    $objPHPExcel->getActiveSheet()->getStyle("A$i:H$i")->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID) ->getStartColor()->setARGB($Color);
                    $objPHPExcel->getActiveSheet()->getStyle("A$i:H$i")->getFont()->setSize(10)->setBold(true);
                    $objPHPExcel->getActiveSheet()->SetCellValue("A$i", 'NÚMERO DE FACTURA');
                    $objPHPExcel->getActiveSheet()->SetCellValue("B$i", 'FECHA DE FACTURA');
                    $objPHPExcel->getActiveSheet()->SetCellValue("C$i", 'TIPO DE DOCUMENTO');
                    $objPHPExcel->getActiveSheet()->SetCellValue("D$i", 'IDENTIFICACION DEL PACIENTE');
                    $objPHPExcel->getActiveSheet()->SetCellValue("E$i", 'EDAD');
                    $objPHPExcel->getActiveSheet()->SetCellValue("F$i", 'MEDIDA EDAD');
                    $objPHPExcel->getActiveSheet()->SetCellValue("G$i", 'SEXO');
                    $objPHPExcel->getActiveSheet()->SetCellValue("H$i", 'VALOR DE LA FACTURA');
                    $i++;
                    $objPHPExcel->getActiveSheet()->SetCellValue("A$i", $DatosRespuesta["factura"]);
                    $objPHPExcel->getActiveSheet()->SetCellValue("B$i", $DatosRespuesta["fecha_factura"]);
                    $objPHPExcel->getActiveSheet()->SetCellValue("C$i", $DatosRespuesta["tipo_identificacion"]);
                    $objPHPExcel->getActiveSheet()->SetCellValue("D$i", $DatosRespuesta["identificacion"]);
                    $objPHPExcel->getActiveSheet()->SetCellValue("E$i", $DatosRespuesta["edad_usuario"]);
                    $UnidadEdad="";
                    if($DatosRespuesta["unidad_medida_edad"]==1){
                        $UnidadEdad="AÑOS";
                    }
                    if($DatosRespuesta["unidad_medida_edad"]==2){
                        $UnidadEdad="MESES";
                    }
                    if($DatosRespuesta["unidad_medida_edad"]==3){
                        $UnidadEdad="DÍAS";
                    }
                    $objPHPExcel->getActiveSheet()->SetCellValue("F$i", $UnidadEdad);
                    $objPHPExcel->getActiveSheet()->SetCellValue("G$i", $DatosRespuesta["sexo_usuario"]);
                    $objPHPExcel->getActiveSheet()->SetCellValue("H$i", $DatosRespuesta["valor_factura"]);
                    
                    $i++;
                $EncabezadoFacturas=0;
                }
                if($EncabezadoDatosFacturas==1){
                    $i++;
                    $Color='dfe8e7';
                    $objPHPExcel->getActiveSheet()->getStyle("A$i:N$i")->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID) ->getStartColor()->setARGB($Color);
                    $objPHPExcel->getActiveSheet()->getStyle("A$i:N$i")->getFont()->setSize(10)->setBold(true);
                    $objPHPExcel->getActiveSheet()->SetCellValue("A$i", 'CUENTA RIPS');
                    $objPHPExcel->getActiveSheet()->SetCellValue("B$i", 'RADICADO');
                    $objPHPExcel->getActiveSheet()->SetCellValue("C$i", 'FACTURA');
                    $objPHPExcel->getActiveSheet()->SetCellValue("D$i", 'CÓDIGO ACTIVIDAD');
                    $objPHPExcel->getActiveSheet()->SetCellValue("D$i", 'VALOR ACTIVIDAD');
                    $objPHPExcel->getActiveSheet()->SetCellValue("E$i", 'FECHA DE RESPUESTA');
                    $objPHPExcel->getActiveSheet()->SetCellValue("F$i", 'CÓDIGO GLOSA');
                    $objPHPExcel->getActiveSheet()->SetCellValue("G$i", 'DESCRIPCIÓN GLOSA');
                    $objPHPExcel->getActiveSheet()->SetCellValue("H$i", 'ESTADO');
                    $objPHPExcel->getActiveSheet()->SetCellValue("I$i", 'VALOR GLOSADO');
                    $objPHPExcel->getActiveSheet()->SetCellValue("J$i", 'VALOR LEVANTADO');
                    $objPHPExcel->getActiveSheet()->SetCellValue("K$i", 'VALOR ACEPTADO');
                    $objPHPExcel->getActiveSheet()->SetCellValue("L$i", 'VALOR X CONCILIAR');
                    $objPHPExcel->getActiveSheet()->SetCellValue("M$i", 'CODIGO DE RESPUESTA');
                    $objPHPExcel->getActiveSheet()->SetCellValue("N$i", 'DESCRIPCIÓN DE RESPUESTA');
                    
                    $EncabezadoDatosFacturas=0;
                }
                $i++;
                $objPHPExcel->getActiveSheet()->SetCellValue("A$i", $DatosRespuesta["cuenta"]);
                $objPHPExcel->getActiveSheet()->SetCellValue("B$i", $DatosRespuesta["numero_radicado"]);
                $objPHPExcel->getActiveSheet()->SetCellValue("C$i", $DatosRespuesta["factura"]);
                $objPHPExcel->getActiveSheet()->SetCellValue("D$i", $DatosRespuesta["cod_actividad"]);
                $objPHPExcel->getActiveSheet()->SetCellValue("D$i", $DatosRespuesta["valor_total_actividad"]);
                $objPHPExcel->getActiveSheet()->SetCellValue("E$i", $DatosRespuesta["fecha_respuesta"]);
                $objPHPExcel->getActiveSheet()->SetCellValue("F$i", $DatosRespuesta["cod_glosa_inicial"]);
                $objPHPExcel->getActiveSheet()->SetCellValue("G$i", utf8_encode($DatosRespuesta["descripcion_glosa_inicial"]));
                $objPHPExcel->getActiveSheet()->SetCellValue("H$i", utf8_encode($DatosRespuesta["descripcion_estado"]));
                $objPHPExcel->getActiveSheet()->SetCellValue("I$i", $DatosRespuesta["valor_glosado_eps"]);
                $objPHPExcel->getActiveSheet()->SetCellValue("J$i", $DatosRespuesta["valor_levantado_eps"]);
                $objPHPExcel->getActiveSheet()->SetCellValue("K$i", $DatosRespuesta["valor_aceptado_ips"]);
                $objPHPExcel->getActiveSheet()->SetCellValue("L$i", $DatosRespuesta["valor_x_conciliar"]);
                $objPHPExcel->getActiveSheet()->SetCellValue("M$i", $DatosRespuesta["cod_glosa_respuesta"]);
                $objPHPExcel->getActiveSheet()->SetCellValue("N$i", utf8_encode($DatosRespuesta["descripcion_glosa_respuesta"]));
               
                
            }
            $this->update("salud_control_generacion_respuestas_excel", "Generada", 1, " WHERE num_factura='$idFactura'");
        }
	
	//Guardamos los cambios
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save($NombreArchivo);
	
    }
    
   
   //Fin Clases
}
    