<?php
/**
*@package pXP
*@file ACTSucursalServicio.php
*@author  (José Mita)
*@date 15-06-2016 23:17:07
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTSucursalServicio extends ACTbase{    
			
	function listarSucursalServicio(){
		$this->objParam->defecto('ordenacion','id_sucursal_servicio');

		$this->objParam->defecto('dir_ordenacion','asc');

		
		 if($this->objParam->getParametro('id_sucursal')!=''){
                $this->objParam->addFiltro("sersuc.id_sucursal = ''".$this->objParam->getParametro('id_sucursal')."''");
         }
		 
		 if($this->objParam->getParametro('id_servicio_padre')!=''){
                $this->objParam->addFiltro("servi.id_servicio_fk = ''".$this->objParam->getParametro('id_servicio_padre')."''");
         }

		
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODSucursalServicio','listarSucursalServicio');
		} else{
			$this->objFunc=$this->create('MODSucursalServicio');
			
			$this->res=$this->objFunc->listarSucursalServicio($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarSucursalServicio(){
		$this->objFunc=$this->create('MODSucursalServicio');	
		if($this->objParam->insertar('id_sucursal_servicio')){
			$this->res=$this->objFunc->insertarSucursalServicio($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarSucursalServicio($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarSucursalServicio(){
			$this->objFunc=$this->create('MODSucursalServicio');	
		$this->res=$this->objFunc->eliminarSucursalServicio($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
	
	function resetFichaSucursalServicio(){
			$this->objFunc=$this->create('MODSucursalServicio');	
		$this->res=$this->objFunc->resetFichaSucursalServicio($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>