<?php
/**
*@package pXP
*@file gen-MODFicha.php
*@author  (admin)
*@date 21-06-2016 10:11:23
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODFicha extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarFicha(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='cola.ft_ficha_sel';
		$this->transaccion='COLA_ficha_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_ficha','int4');
		$this->captura('numero','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('id_unidad','int4');
		$this->captura('sigla','varchar');
		$this->captura('id_servicio','int4');
		$this->captura('id_prioridad','int4');
		$this->captura('peso','int4');
		$this->captura('id_usuario_reg','int4');
		$this->captura('usuario_ai','varchar');
		$this->captura('fecha_reg','timestamp');
		$this->captura('id_usuario_ai','int4');
		$this->captura('id_usuario_mod','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function insertarFicha(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='cola.ft_ficha_ime';
		$this->transaccion='COLA_ficha_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('numero','numero','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('id_unidad','id_unidad','int4');
		$this->setParametro('sigla','sigla','varchar');
		$this->setParametro('id_servicio','id_servicio','int4');
		$this->setParametro('id_prioridad','id_prioridad','int4');
		$this->setParametro('peso','peso','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarFicha(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='cola.ft_ficha_ime';
		$this->transaccion='COLA_ficha_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_ficha','id_ficha','int4');
		$this->setParametro('numero','numero','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('id_unidad','id_unidad','int4');
		$this->setParametro('sigla','sigla','varchar');
		$this->setParametro('id_servicio','id_servicio','int4');
		$this->setParametro('id_prioridad','id_prioridad','int4');
		$this->setParametro('peso','peso','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarFicha(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='cola.ft_ficha_ime';
		$this->transaccion='COLA_ficha_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_ficha','id_ficha','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
}
?>