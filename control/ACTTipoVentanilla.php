<?php
/**
*@package pXP
*@file ACTTipoVentanilla.php
*@author  (José Mita)
*@date 15-06-2016 23:16:11
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTTipoVentanilla extends ACTbase{    
			
	function listarTipoVentanilla(){
		$this->objParam->defecto('ordenacion','id_tipo_ventanilla');

		$this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODTipoVentanilla','listarTipoVentanilla');
		} else{
			$this->objFunc=$this->create('MODTipoVentanilla');
			
			$this->res=$this->objFunc->listarTipoVentanilla($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarTipoVentanilla(){
		$this->objFunc=$this->create('MODTipoVentanilla');	
		if($this->objParam->insertar('id_tipo_ventanilla')){
			$this->res=$this->objFunc->insertarTipoVentanilla($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarTipoVentanilla($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarTipoVentanilla(){
			$this->objFunc=$this->create('MODTipoVentanilla');	
		$this->res=$this->objFunc->eliminarTipoVentanilla($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>