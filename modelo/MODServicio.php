<?php
/**
*@package pXP
*@file gen-MODServicio.php
*@author  (admin)
*@date 15-06-2016 23:15:11
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODServicio extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarServicio(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='cola.ft_servicio_sel';
		$this->transaccion='COLA_servi_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_servicio','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('id_servicio_pk','int4');
		$this->captura('nombre','varchar');
		$this->captura('sigla','varchar');
		$this->captura('descripcion','varchar');
		$this->captura('peso','int4');
		$this->captura('fecha_reg','timestamp');
		$this->captura('usuario_ai','varchar');
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
	
	function listarServicioCombo(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='cola.ft_servicio_sel';
		$this->transaccion='COLA_servi_COM';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
		$this-> setCount(false);
				
		//Definicion de la lista del resultado del query
		$this->captura('id_servicio','int4');
		$this->captura('des_padre','varchar');
		$this->captura('des_hijo','varchar');

		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
	
	function listarServicioArb(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='cola.ft_servicio_sel';
		$this-> setCount(false);
		$this->transaccion='COLA_servi_arb_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		$this->setParametro('id_servicio_fk','id_servicio_fk','varchar');	


		//Definicion de la lista del resultado del query
		$this->captura('id_servicio','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('id_servicio_fk','int4');
		$this->captura('nombre','varchar');
		$this->captura('sigla','varchar');
		$this->captura('descripcion','varchar');
		$this->captura('peso','int4');
		$this->captura('fecha_reg','timestamp');
		$this->captura('usuario_ai','varchar');
		$this->captura('id_usuario_reg','int4');
		$this->captura('id_usuario_ai','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('id_usuario_mod','int4');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		$this->captura('tipo_nodo','varchar');


		$this->setParametro('vista','vista','varchar');
		$this->setParametro('id_sucursal','id_sucursal','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
	
	
			
	function insertarServicio(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='cola.ft_servicio_ime';
		$this->transaccion='COLA_servi_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('id_servicio_fk','id_servicio_fk','int4');
		$this->setParametro('nombre','nombre','varchar');
		$this->setParametro('sigla','sigla','varchar');
		$this->setParametro('descripcion','descripcion','varchar');
		$this->setParametro('peso','peso','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarServicio(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='cola.ft_servicio_ime';
		$this->transaccion='COLA_servi_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_servicio','id_servicio','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('id_servicio_fk','id_servicio_fk','int4');
		$this->setParametro('nombre','nombre','varchar');
		$this->setParametro('sigla','sigla','varchar');
		$this->setParametro('descripcion','descripcion','varchar');
		$this->setParametro('peso','peso','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarServicio(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='cola.ft_servicio_ime';
		$this->transaccion='COLA_servi_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_servicio','id_servicio','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}


    function listarServicioUltimoNivel(){
        //Definicion de variables para ejecucion del procedimientp
        $this->procedimiento='cola.ft_servicio_sel';
        $this->transaccion='COLA_SERULTI_SEL';
        $this->tipo_procedimiento='SEL';//tipo de transaccion

        //Definicion de la lista del resultado del query
        $this->captura('id_servicio','int4');
        $this->captura('estado_reg','varchar');
        $this->captura('id_servicio_pk','int4');
        $this->captura('nombre','varchar');
        $this->captura('sigla','varchar');
        $this->captura('descripcion','varchar');
        $this->captura('peso','int4');
        $this->captura('fecha_reg','timestamp');
        $this->captura('usuario_ai','varchar');
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


    function listarServicioUsuario(){
        //Definicion de variables para ejecucion del procedimientp
        $this->procedimiento='cola.ft_servicio_sel';
        $this->transaccion='COLA_SERUSU_SEL';
        $this->tipo_procedimiento='SEL';//tipo de transaccion

        //Definicion de la lista del resultado del query
        $this->captura('id_servicio','int4');
        $this->captura('descripcion','varchar');


        $this->setParametro('id_sucursal','id_sucursal','int4');


        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }


			
}
?>