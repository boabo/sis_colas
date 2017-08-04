<?php
/**
*@package pXP
*@file gen-ACTSucursalMensaje.php
*@author  (admin)
*@date 17-05-2017 13:39:41
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTSucursalMensaje extends ACTbase{    
			
	function listarSucursalMensaje(){
		$this->objParam->defecto('ordenacion','id_sucursal_mensaje');

		$this->objParam->defecto('dir_ordenacion','asc');
        if ($this->objParam->getParametro('id_mensaje') != '') {
            $this->objParam->addFiltro("sucmen.id_mensaje = ''" . $this->objParam->getParametro('id_mensaje') . "''");
        }
        if ($this->objParam->getParametro('id_sucursal') != '') {
            $this->objParam->addFiltro("suc.id_sucursal = ''" . $this->objParam->getParametro('id_sucursal') . "''");
        }

		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODSucursalMensaje','listarSucursalMensaje');
		} else{
			$this->objFunc=$this->create('MODSucursalMensaje');
			
			$this->res=$this->objFunc->listarSucursalMensaje($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarSucursalMensaje(){
		$this->objFunc=$this->create('MODSucursalMensaje');	
		if($this->objParam->insertar('id_sucursal_mensaje')){
			$this->res=$this->objFunc->insertarSucursalMensaje($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarSucursalMensaje($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarSucursalMensaje(){
			$this->objFunc=$this->create('MODSucursalMensaje');	
		$this->res=$this->objFunc->eliminarSucursalMensaje($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>