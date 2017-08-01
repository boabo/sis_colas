<?php
/**
*@package pXP
*@file gen-MODUsuarioSucursal.php
*@author  (admin)
*@date 22-07-2016 01:55:47
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODUsuarioSucursal extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarUsuarioSucursal(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='cola.ft_usuario_sucursal_sel';
		$this->transaccion='COLA_USUSUC_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_usuario_sucursal','int4');
		$this->captura('id_sucursal','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('id_tipo_ventanilla','int4');
		$this->captura('id_usuario','int4');
		$this->captura('id_usuario_ai','int4');
		$this->captura('id_usuario_reg','int4');
		$this->captura('fecha_reg','timestamp');
		$this->captura('usuario_ai','varchar');
		$this->captura('id_usuario_mod','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		$this->captura('nombre_sucursal','varchar');
		$this->captura('desc_persona','text');
		$this->captura('nombre_ventanilla','varchar');
		$this->captura('numero_ventanilla','varchar');
		$this->captura('ids_prioridad','varchar');
		$this->captura('nombres_prioridad','varchar');
		$this->captura('ids_servicio','varchar');
		$this->captura('nombres_servicio','varchar');
		$this->captura('servidor_remoto','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function insertarUsuarioSucursal(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='cola.ft_usuario_sucursal_ime';
		$this->transaccion='COLA_USUSUC_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('ids_servicio','ids_servicio','varchar');
		$this->setParametro('id_sucursal','id_sucursal','int4');
		$this->setParametro('ids_prioridad','ids_prioridad','varchar');
		$this->setParametro('numero_ventanilla','numero_ventanilla','varchar');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('id_tipo_ventanilla','id_tipo_ventanilla','int4');
		$this->setParametro('id_usuario','id_usuario','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarUsuarioSucursal(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='cola.ft_usuario_sucursal_ime';
		$this->transaccion='COLA_USUSUC_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_usuario_sucursal','id_usuario_sucursal','int4');
		$this->setParametro('ids_servicio','ids_servicio','varchar');
		$this->setParametro('id_sucursal','id_sucursal','int4');
		$this->setParametro('ids_prioridad','ids_prioridad','varchar');
		$this->setParametro('numero_ventanilla','numero_ventanilla','varchar');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('id_tipo_ventanilla','id_tipo_ventanilla','int4');
		$this->setParametro('id_usuario','id_usuario','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarUsuarioSucursal(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='cola.ft_usuario_sucursal_ime';
		$this->transaccion='COLA_USUSUC_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_usuario_sucursal','id_usuario_sucursal','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
	function modificarUsuarioSucursalAtencion(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='cola.ft_usuario_sucursal_ime';
		$this->transaccion='COLA_USUSUCATE_MOD';
		$this->tipo_procedimiento='IME';

		//Define los parametros para la funcion
		$this->setParametro('id_usuario_sucursal','id_usuario_sucursal','int4');
		$this->setParametro('id_sucursal','id_sucursal','int4');
		$this->setParametro('ids_prioridad','ids_prioridad','varchar');
		$this->setParametro('numero_ventanilla','numero_ventanilla','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
}
?>