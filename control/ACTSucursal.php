<?php
/**
*@package pXP
*@file ACTSucursal.php
*@author  (José Mita)
*@date 15-06-2016 23:15:40
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTSucursal extends ACTbase{

	function listarSucursal(){
		$this->objParam->defecto('ordenacion','id_sucursal');

		$this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('filtroUsuario')=='si'){
             $this->objParam->addFiltro("(sucur.id_sucursal in  ( select id_sucursal from cola.tusuario_sucursal where id_usuario = " . $_SESSION["ss_id_usuario"]. " and estado_reg=''activo''))");
        }

		if($this->objParam->getParametro('id_sucursal')!=''){
             $this->objParam->addFiltro("sucur.id_sucursal = ".$this->objParam->getParametro('id_sucursal')." ");
        }

		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODSucursal','listarSucursal');
		} else{
			$this->objFunc=$this->create('MODSucursal');

			$this->res=$this->objFunc->listarSucursal($this->objParam);
		}
		if($this->objParam->getParametro('_adicionar')!=''){

			$respuesta = $this->res->getDatos();

			array_unshift ( $respuesta, array(  'id_sucursal'=>'0',
																				   'nombre'=>'Todos'
											));
		//		var_dump($respuesta);
			$this->res->setDatos($respuesta);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}

	function insertarSucursal(){
		$this->objFunc=$this->create('MODSucursal');
		if($this->objParam->insertar('id_sucursal')){
			$this->res=$this->objFunc->insertarSucursal($this->objParam);
		} else{
			$this->res=$this->objFunc->modificarSucursal($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}

	function eliminarSucursal(){
			$this->objFunc=$this->create('MODSucursal');
		$this->res=$this->objFunc->eliminarSucursal($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
	function verPuerto(){

	    echo $_SESSION['_PUERTO_WEBSOCKET'];
	}

}

?>
