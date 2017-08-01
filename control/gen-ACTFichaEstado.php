<?php
/**
*@package pXP
*@file gen-ACTFichaEstado.php
*@author  (admin)
*@date 21-06-2016 10:12:07
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTFichaEstado extends ACTbase{    
			
	function listarFichaEstado(){
		$this->objParam->defecto('ordenacion','id_ficha_estado');

		$this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODFichaEstado','listarFichaEstado');
		} else{
			$this->objFunc=$this->create('MODFichaEstado');
			
			$this->res=$this->objFunc->listarFichaEstado($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarFichaEstado(){
		$this->objFunc=$this->create('MODFichaEstado');	
		if($this->objParam->insertar('id_ficha_estado')){
			$this->res=$this->objFunc->insertarFichaEstado($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarFichaEstado($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarFichaEstado(){
			$this->objFunc=$this->create('MODFichaEstado');	
		$this->res=$this->objFunc->eliminarFichaEstado($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>