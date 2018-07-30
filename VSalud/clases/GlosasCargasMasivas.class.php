<?php
/* 
 * Clase donde se realizaran procesos de para Cargar Glosas Masivas
 * Julian Andres Alvaran
 * Techno Soluciones SAS en asociacion con SITIS SAS
 * 2018-07-29
 */

class GlosasMasivas extends conexion{
    /**
     * Registra los archivos subidos para la carga temporal
     * @param type $Fecha
     * @param type $destino
     * @param type $idUser
     */
    public function RegistreArchivoSubido($Fecha,$destino,$idUser) {
        $Datos["Fecha"]=$Fecha;
        $Datos["Soporte"]=$destino;
        $Datos["idUser"]=$idUser;
        $Datos["Analizado"]=0;
        $sql=$this->getSQLInsert("salud_control_glosas_masivas", $Datos);
        $this->Query($sql);
    }
    public function LeerArchivo($Vector) {
        $DatosUpload= $this->DevuelveValores("salud_control_glosas_masivas", "Analizado", 0);
        //print($DatosUpload["Soporte"]);
    }
    //Fin Clases
}