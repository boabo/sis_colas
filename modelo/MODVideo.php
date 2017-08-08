<?php
/**
*@package pXP
*@file gen-MODVideo.php
*@author  (favio.figueroa)
*@date 08-08-2017 21:46:18
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODVideo extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarVideo(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='cola.ft_video_sel';
		$this->transaccion='COLA_VIDE_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_video','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('descripcion','varchar');
		$this->captura('usuario_ai','varchar');
		$this->captura('fecha_reg','timestamp');
		$this->captura('id_usuario_reg','int4');
		$this->captura('id_usuario_ai','int4');
		$this->captura('id_usuario_mod','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		$this->captura('id_sucursales','text');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function insertarVideo(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='cola.ft_video_ime';
		$this->transaccion='COLA_VIDE_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('descripcion','descripcion','varchar');
        $this->setParametro('id_sucursales','id_sucursales','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarVideo(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='cola.ft_video_ime';
		$this->transaccion='COLA_VIDE_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_video','id_video','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('descripcion','descripcion','varchar');
        $this->setParametro('id_sucursales','id_sucursales','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarVideo(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='cola.ft_video_ime';
		$this->transaccion='COLA_VIDE_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_video','id_video','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
}
?>