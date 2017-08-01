<?php
/**
 *@package pXP
 *@file ACTFicha.php
 *@author  (José Mita)
 *@date 21-06-2016 10:11:23
 *@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
 */

class ACTParametrizacion extends ACTbase{

    function verArchivos(){
        
        $this->objFunc=$this->create('MODParametrizacion');
        $this->res=$this->objFunc->verArchivos($this->objParam);
        $this->res->imprimirRespuesta($this->res->generarJson());

    }

}

?>