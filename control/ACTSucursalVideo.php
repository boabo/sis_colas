<?php
/**
*@package pXP
*@file gen-ACTSucursalVideo.php
*@author  (favio.figueroa)
*@date 08-08-2017 21:54:34
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTSucursalVideo extends ACTbase{    
			
	function listarSucursalVideo(){
		$this->objParam->defecto('ordenacion','id_sucursal_video');

		$this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODSucursalVideo','listarSucursalVideo');
		} else{
			$this->objFunc=$this->create('MODSucursalVideo');
			
			$this->res=$this->objFunc->listarSucursalVideo($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarSucursalVideo(){
		$this->objFunc=$this->create('MODSucursalVideo');	
		if($this->objParam->insertar('id_sucursal_video')){
			$this->res=$this->objFunc->insertarSucursalVideo($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarSucursalVideo($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarSucursalVideo(){
			$this->objFunc=$this->create('MODSucursalVideo');	
		$this->res=$this->objFunc->eliminarSucursalVideo($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>