<?php
/**
*@package pXP
*@file Sucursal.php
*@author  (José Mita)
*@date 15-06-2016 23:15:40
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODSucursal extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarSucursal(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='cola.ft_sucursal_sel';
		$this->transaccion='COLA_sucur_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_sucursal','int4');
		$this->captura('id_depto','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('codigo','varchar');
		$this->captura('mensaje_imp','varchar');
		$this->captura('nombre','varchar');
		$this->captura('id_usuario_reg','int4');
		$this->captura('usuario_ai','varchar');
		$this->captura('fecha_reg','timestamp');
		$this->captura('id_usuario_ai','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('id_usuario_mod','int4');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		$this->captura('nombre_dep','varchar');
		$this->captura('servidor_remoto','varchar');
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function insertarSucursal(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='cola.ft_sucursal_ime';
		$this->transaccion='COLA_sucur_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_depto','id_depto','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('codigo','codigo','varchar');
		$this->setParametro('mensaje_imp','mensaje_imp','varchar');
		$this->setParametro('nombre','nombre','varchar');
		$this->setParametro('servidor_remoto','servidor_remoto','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarSucursal(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='cola.ft_sucursal_ime';
		$this->transaccion='COLA_sucur_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_sucursal','id_sucursal','int4');
		$this->setParametro('id_depto','id_depto','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('codigo','codigo','varchar');
		$this->setParametro('mensaje_imp','mensaje_imp','varchar');
		$this->setParametro('nombre','nombre','varchar');
		$this->setParametro('servidor_remoto','servidor_remoto','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarSucursal(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='cola.ft_sucursal_ime';
		$this->transaccion='COLA_sucur_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_sucursal','id_sucursal','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
}
?>