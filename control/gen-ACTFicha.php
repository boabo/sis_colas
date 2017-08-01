<?php
/**
*@package pXP
*@file gen-ACTFicha.php
*@author  (admin)
*@date 21-06-2016 10:11:23
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTFicha extends ACTbase{    
			
	function listarFicha(){
		$this->objParam->defecto('ordenacion','id_ficha');

		$this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODFicha','listarFicha');
		} else{
			$this->objFunc=$this->create('MODFicha');
			
			$this->res=$this->objFunc->listarFicha($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarFicha(){
		$this->objFunc=$this->create('MODFicha');	
		if($this->objParam->insertar('id_ficha')){
			$this->res=$this->objFunc->insertarFicha($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarFicha($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarFicha(){
			$this->objFunc=$this->create('MODFicha');	
		$this->res=$this->objFunc->eliminarFicha($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>