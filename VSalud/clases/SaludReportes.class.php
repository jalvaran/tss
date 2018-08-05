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
    
    public function RegistreRespuestasFacturaExcel($NombreArchivo,$idFactura,$Vector) {
        //require_once '../../librerias/Excel/PHPExcel.php';  
        require_once '../../librerias/Excel/PHPExcel/IOFactory.php';
        
        $NombreArchivo="../ArchivosTemporales/Reportes/".$NombreArchivo;
        
	
	// Creamos un objeto PHPExcel
	$objPHPExcel = new PHPExcel();
        
	$objReader = PHPExcel_IOFactory::createReader('Excel2007');
	$objPHPExcel = $objReader->load($NombreArchivo);   
        
        $objClonedWorksheet= clone $objPHPExcel->getSheetByName('Worksheet');
        $objClonedWorksheet->setTitle('Copy of Worksheet1');
        $objPHPExcel->addSheet($objClonedWorksheet);


        
        
	// Indicamos que se pare en la hoja uno del libro
	$objPHPExcel->setActiveSheetIndex(0);
	
	//Modificamos los valoresde las celdas A2, B2 Y C2
	$objPHPExcel->getActiveSheet()->SetCellValue('A2', 'Nuevos Dulces');
	$objPHPExcel->getActiveSheet()->SetCellValue('B2', 8.30);
	$objPHPExcel->getActiveSheet()->SetCellValue('C2', 10);
	
	//Agregamos nuevos valores en las celdas A7, B7 y C7
	$objPHPExcel->getActiveSheet()->SetCellValue('A7', 'Nuevo Producto');
	$objPHPExcel->getActiveSheet()->SetCellValue('B7', 10);
	$objPHPExcel->getActiveSheet()->SetCellValue('C7', 2);
	
	//Guardamos los cambios
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save($NombreArchivo);
	
	   
    }
    
   
   //Fin Clases
}
    