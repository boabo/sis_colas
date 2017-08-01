<?php
/**
*@package pXP
*@file gen-MODFichaEstado.php
*@author  (admin)
*@date 21-06-2016 10:12:07
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODFichaEstado extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarFichaEstado(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='cola.ft_ficha_estado_sel';
		$this->transaccion='COLA_ficest_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_ficha_estado','int4');
		$this->captura('id_ficha','int4');
		$this->captura('id_usuario_atencion','int4');
		$this->captura('id_tipo_ventanilla','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('numero_ventanilla','int4');
		$this->captura('estado','varchar');
		$this->captura('fecha_hora_fin','timestamp');
		$this->captura('fecha_hora_inicio','timestamp');
		$this->captura('usuario_ai','varchar');
		$this->captura('fecha_reg','timestamp');
		$this->captura('id_usuario_reg','int4');
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
			
	function insertarFichaEstado(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='cola.ft_ficha_estado_ime';
		$this->transaccion='COLA_ficest_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_ficha','id_ficha','int4');
		$this->setParametro('id_usuario_atencion','id_usuario_atencion','int4');
		$this->setParametro('id_tipo_ventanilla','id_tipo_ventanilla','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('numero_ventanilla','numero_ventanilla','int4');
		$this->setParametro('estado','estado','varchar');
		$this->setParametro('fecha_hora_fin','fecha_hora_fin','timestamp');
		$this->setParametro('fecha_hora_inicio','fecha_hora_inicio','timestamp');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarFichaEstado(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='cola.ft_ficha_estado_ime';
		$this->transaccion='COLA_ficest_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_ficha_estado','id_ficha_estado','int4');
		$this->setParametro('id_ficha','id_ficha','int4');
		$this->setParametro('id_usuario_atencion','id_usuario_atencion','int4');
		$this->setParametro('id_tipo_ventanilla','id_tipo_ventanilla','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('numero_ventanilla','numero_ventanilla','int4');
		$this->setParametro('estado','estado','varchar');
		$this->setParametro('fecha_hora_fin','fecha_hora_fin','timestamp');
		$this->setParametro('fecha_hora_inicio','fecha_hora_inicio','timestamp');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarFichaEstado(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='cola.ft_ficha_estado_ime';
		$this->transaccion='COLA_ficest_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_ficha_estado','id_ficha_estado','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
}
?>