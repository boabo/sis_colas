<?php
/**
*@package pXP
*@file gen-ACTPrioridad.php
*@author  (admin)
*@date 15-06-2016 22:48:33
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTPrioridad extends ACTbase{    
			
	function listarPrioridad(){
		$this->objParam->defecto('ordenacion','id_prioridad');

		$this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODPrioridad','listarPrioridad');
		} else{
			$this->objFunc=$this->create('MODPrioridad');
			
			$this->res=$this->objFunc->listarPrioridad($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarPrioridad(){
		$this->objFunc=$this->create('MODPrioridad');	
		if($this->objParam->insertar('id_prioridad')){
			$this->res=$this->objFunc->insertarPrioridad($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarPrioridad($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarPrioridad(){
			$this->objFunc=$this->create('MODPrioridad');	
		$this->res=$this->objFunc->eliminarPrioridad($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>