<?php
/* 
 * Clase donde se realizaran procesos de para Cargar Glosas Masivas
 * Julian Andres Alvaran
 * Techno Soluciones SAS en asociacion con SITIS SAS
 * 2018-07-29
 */
include_once 'GlosasTSS.class.php';
class GlosasMasivas extends Glosas{
    /**
     * Registra los archivos subidos para la carga temporal
     * @param type $Fecha
     * @param type $destino
     * @param type $idUser
     */
    public function RegistreArchivoSubido($Fecha,$destino,$TipoArchivo,$idUser) {
        $Datos["Fecha"]=$Fecha;
        $Datos["Soporte"]=$destino;
        $Datos["idUser"]=$idUser;
        $Datos["TipoArchivo"]=$TipoArchivo;
        $Datos["Analizado"]=0;
        $sql=$this->getSQLInsert("salud_control_glosas_masivas", $Datos);
        $this->Query($sql);
    }
    public function LeerArchivo($Vector) {
        require_once('../../librerias/Excel/PHPExcel.php');
        require_once('../../librerias/Excel/PHPExcel/Reader/Excel2007.php'); 
        $DatosUpload["Soporte"]="";
        $sql="SELECT Soporte,TipoArchivo FROM salud_control_glosas_masivas WHERE Analizado=0  ORDER BY ID DESC LIMIT 1";
        $consulta=$this->Query($sql);
        $DatosUpload=$this->FetchArray($consulta);
        
        $RutaArchivo="../../".$DatosUpload["Soporte"];
        if($DatosUpload["TipoArchivo"]=="xlsx"){
            $objReader = PHPExcel_IOFactory::createReader('Excel2007');
        }else if($DatosUpload["TipoArchivo"]=="xls"){
            $objReader = PHPExcel_IOFactory::createReader('Excel5');
        }else{
            exit("Solo se permiten archivos con extension xls o xlsx");
        }
        
        //$objReader = new PHPExcel_Reader_Excel2007();
        $objPHPExcel = $objReader->load($RutaArchivo);
        $objFecha = new PHPExcel_Shared_Date();       
        $objPHPExcel->setActiveSheetIndex(0);
        
        $count=0;
        $columnas = $objPHPExcel->setActiveSheetIndex(0)->getHighestColumn();
        $filas = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();
        for ($i=2;$i<=$filas;$i++){
            if($objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue()<>''){
                $_DATOS_EXCEL[$i]['FechaIPS'] = $objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();
                $_DATOS_EXCEL[$i]['FechaAuditoria'] = $objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue();
                $_DATOS_EXCEL[$i]['EPS']= $objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue();
                $_DATOS_EXCEL[$i]['NIT']= $objPHPExcel->getActiveSheet()->getCell('F'.$i)->getCalculatedValue();
                $_DATOS_EXCEL[$i]['CuentaRIPS'] = $objPHPExcel->getActiveSheet()->getCell('G'.$i)->getCalculatedValue();
                $_DATOS_EXCEL[$i]['num_factura'] = $objPHPExcel->getActiveSheet()->getCell('H'.$i)->getCalculatedValue();
                $_DATOS_EXCEL[$i]['CodigoActividad'] = $objPHPExcel->getActiveSheet()->getCell('I'.$i)->getCalculatedValue();
                $_DATOS_EXCEL[$i]['ValorGlosado'] = $objPHPExcel->getActiveSheet()->getCell('J'.$i)->getCalculatedValue();
                $_DATOS_EXCEL[$i]['CodigoGlosa'] = $objPHPExcel->getActiveSheet()->getCell('K'.$i)->getCalculatedValue();
                $_DATOS_EXCEL[$i]['CuentaGlobal'] = $objPHPExcel->getActiveSheet()->getCell('L'.$i)->getCalculatedValue();
                $_DATOS_EXCEL[$i]['Observaciones'] = $objPHPExcel->getActiveSheet()->getCell('M'.$i)->getCalculatedValue();
                $_DATOS_EXCEL[$i]['Soporte']=$DatosUpload["Soporte"];
                
            }
        } 
        $sql="";
        foreach($_DATOS_EXCEL as $campo => $valor){
            $sql= "INSERT INTO salud_glosas_masivas_temp (FechaIPS,FechaAuditoria,ID_EPS,NIT_EPS,CuentaRips,num_factura,CodigoActividad,ValorGlosado,CodigoGlosa,CuentaGlobal,Observaciones,Soporte)  VALUES ('";
            foreach ($valor as $campo2 => $valor2){
                $campo2 == "Soporte" ? $sql.= $valor2."');" : $sql.= $valor2."','";
            }
            $this->Query($sql);
        }    
       
        $errores=0;

        //print($DatosUpload["Soporte"]);
    }
    //Fin Clases
}