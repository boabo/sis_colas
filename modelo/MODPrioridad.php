<?php
/**
*@package pXP
*@file gen-MODPrioridad.php
*@author  (admin)
*@date 15-06-2016 22:48:33
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODPrioridad extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarPrioridad(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='cola.ft_prioridad_sel';
		$this->transaccion='COLA_priori_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_prioridad','int4');
		$this->captura('nombre','varchar');
		$this->captura('sigla','varchar');
		$this->captura('estado_reg','varchar');
		$this->captura('descripcion','varchar');
		$this->captura('estado','varchar');
		$this->captura('peso','int4');
		$this->captura('id_usuario_reg','int4');
		$this->captura('usuario_ai','varchar');
		$this->captura('fecha_reg','timestamp');
		$this->captura('id_usuario_ai','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('id_usuario_mod','int4');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function insertarPrioridad(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='cola.ft_prioridad_ime';
		$this->transaccion='COLA_priori_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('nombre','nombre','varchar');
		$this->setParametro('sigla','sigla','varchar');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('descripcion','descripcion','varchar');
		$this->setParametro('estado','estado','varchar');
		$this->setParametro('peso','peso','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarPrioridad(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='cola.ft_prioridad_ime';
		$this->transaccion='COLA_priori_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_prioridad','id_prioridad','int4');
		$this->setParametro('nombre','nombre','varchar');
		$this->setParametro('sigla','sigla','varchar');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('descripcion','descripcion','varchar');
		$this->setParametro('estado','estado','varchar');
		$this->setParametro('peso','peso','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarPrioridad(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='cola.ft_prioridad_ime';
		$this->transaccion='COLA_priori_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_prioridad','id_prioridad','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
}
?>