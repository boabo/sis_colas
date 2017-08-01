<?php
/**
*@package pXP
*@file gen-MODSucursalMensaje.php
*@author  (admin)
*@date 17-05-2017 13:39:41
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODSucursalMensaje extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarSucursalMensaje(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='cola.ft_sucursal_mensaje_sel';
		$this->transaccion='COLA_SUCMEN_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_sucursal_mensaje','int4');
		$this->captura('id_sucursal','int4');
		$this->captura('id_mensaje','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('id_usuario_ai','int4');
		$this->captura('id_usuario_reg','int4');
		$this->captura('fecha_reg','timestamp');
		$this->captura('usuario_ai','varchar');
		$this->captura('fecha_mod','timestamp');
		$this->captura('id_usuario_mod','int4');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		$this->captura('desc_mensaje','varchar');
		$this->captura('mensaje','text');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function insertarSucursalMensaje(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='cola.ft_sucursal_mensaje_ime';
		$this->transaccion='COLA_SUCMEN_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_sucursal','id_sucursal','int4');
		$this->setParametro('id_mensaje','id_mensaje','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarSucursalMensaje(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='cola.ft_sucursal_mensaje_ime';
		$this->transaccion='COLA_SUCMEN_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_sucursal_mensaje','id_sucursal_mensaje','int4');
		$this->setParametro('id_sucursal','id_sucursal','int4');
		$this->setParametro('id_mensaje','id_mensaje','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarSucursalMensaje(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='cola.ft_sucursal_mensaje_ime';
		$this->transaccion='COLA_SUCMEN_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_sucursal_mensaje','id_sucursal_mensaje','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
}
?>