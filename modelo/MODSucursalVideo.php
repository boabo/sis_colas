<?php
/**
*@package pXP
*@file gen-MODSucursalVideo.php
*@author  (favio.figueroa)
*@date 08-08-2017 21:54:34
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODSucursalVideo extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarSucursalVideo(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='cola.ft_sucursal_video_sel';
		$this->transaccion='COLA_SUCVIDEO_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_sucursal_video','int4');
		$this->captura('id_video','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('id_sucursal','int4');
		$this->captura('id_usuario_ai','int4');
		$this->captura('usuario_ai','varchar');
		$this->captura('fecha_reg','timestamp');
		$this->captura('id_usuario_reg','int4');
		$this->captura('id_usuario_mod','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
        $this->captura('desc_sucursal','varchar');
        $this->captura('desc_video','varchar');
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function insertarSucursalVideo(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='cola.ft_sucursal_video_ime';
		$this->transaccion='COLA_SUCVIDEO_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_video','id_video','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('id_sucursal','id_sucursal','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarSucursalVideo(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='cola.ft_sucursal_video_ime';
		$this->transaccion='COLA_SUCVIDEO_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_sucursal_video','id_sucursal_video','int4');
		$this->setParametro('id_video','id_video','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('id_sucursal','id_sucursal','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarSucursalVideo(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='cola.ft_sucursal_video_ime';
		$this->transaccion='COLA_SUCVIDEO_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_sucursal_video','id_sucursal_video','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
}
?>