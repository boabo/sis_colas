<?php
/**
*@package pXP
*@file gen-ACTUsuarioSucursal.php
*@author  (admin)
*@date 22-07-2016 01:55:47
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTUsuarioSucursal extends ACTbase{    
			
	function listarUsuarioSucursal(){
		$this->objParam->defecto('ordenacion','id_usuario_sucursal');

		$this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODUsuarioSucursal','listarUsuarioSucursal');
		} else{
			$this->objFunc=$this->create('MODUsuarioSucursal');
			
			$this->res=$this->objFunc->listarUsuarioSucursal($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarUsuarioSucursal(){
		$this->objFunc=$this->create('MODUsuarioSucursal');	
		if($this->objParam->insertar('id_usuario_sucursal')){
			$this->res=$this->objFunc->insertarUsuarioSucursal($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarUsuarioSucursal($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarUsuarioSucursal(){
			$this->objFunc=$this->create('MODUsuarioSucursal');	
		$this->res=$this->objFunc->eliminarUsuarioSucursal($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>