<?php
/**
*@package pXP
*@file MODSucursalServicio.php
*@author  (José Mita)
*@date 15-06-2016 23:17:07
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODSucursalServicio extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarSucursalServicio(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='cola.ft_sucursal_servicio_sel';
		$this->transaccion='COLA_sersuc_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_sucursal_servicio','int4');
		$this->captura('id_sucursal','int4');
		$this->captura('id_servicio','int4');
		$this->captura('id_tipo_ventanilla','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('estado','varchar');
		$this->captura('id_usuario_ai','int4');
		$this->captura('id_usuario_reg','int4');
		$this->captura('usuario_ai','varchar');
		$this->captura('fecha_reg','timestamp');
		$this->captura('id_usuario_mod','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		$this->captura('ids_prioridad','varchar');
		$this->captura('nombres_prioridad','varchar');
		$this->captura('nombre_sucur','varchar');
		$this->captura('nombre_servi','varchar');
		$this->captura('nombre_tipo','varchar');
		$this->captura('digito','int4');
		$this->captura('tickets','int4');
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function insertarSucursalServicio(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='cola.ft_sucursal_servicio_ime';
		$this->transaccion='COLA_sersuc_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_sucursal','id_sucursal','int4');
		$this->setParametro('id_servicio','id_servicio','int4');
		$this->setParametro('id_tipo_ventanilla','id_tipo_ventanilla','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('estado','estado','varchar');
		$this->setParametro('ids_prioridad','ids_prioridad','varchar');
		$this->setParametro('digito','digito','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarSucursalServicio(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='cola.ft_sucursal_servicio_ime';
		$this->transaccion='COLA_sersuc_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_sucursal_servicio','id_sucursal_servicio','int4');
		$this->setParametro('id_sucursal','id_sucursal','int4');
		$this->setParametro('id_servicio','id_servicio','int4');
		$this->setParametro('id_tipo_ventanilla','id_tipo_ventanilla','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('estado','estado','varchar');
		$this->setParametro('digito','digito','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarSucursalServicio(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='cola.ft_sucursal_servicio_ime';
		$this->transaccion='COLA_sersuc_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_sucursal_servicio','id_sucursal_servicio','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}

	function resetFichaSucursalServicio(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='cola.ft_sucursal_servicio_ime';
		$this->transaccion='COLA_resfic_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_sucursal_servicio','id_sucursal_servicio','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
}
?>
