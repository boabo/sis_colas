<?php
/**
*@package pXP
*@file gen-MODMensaje.php
*@author  (admin)
*@date 17-05-2017 13:33:23
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODMensaje extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarMensaje(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='cola.ft_mensaje_sel';
		$this->transaccion='COLA_MEN_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_mensaje','int4');
		$this->captura('titulo','varchar');
		$this->captura('estado_reg','varchar');
		$this->captura('mensaje','text');
		$this->captura('id_usuario_ai','int4');
		$this->captura('id_usuario_reg','int4');
		$this->captura('fecha_reg','timestamp');
		$this->captura('usuario_ai','varchar');
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
			
	function insertarMensaje(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='cola.ft_mensaje_ime';
		$this->transaccion='COLA_MEN_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('titulo','titulo','varchar');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('mensaje','mensaje','text');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarMensaje(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='cola.ft_mensaje_ime';
		$this->transaccion='COLA_MEN_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_mensaje','id_mensaje','int4');
		$this->setParametro('titulo','titulo','varchar');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('mensaje','mensaje','text');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarMensaje(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='cola.ft_mensaje_ime';
		$this->transaccion='COLA_MEN_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_mensaje','id_mensaje','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
}
?>