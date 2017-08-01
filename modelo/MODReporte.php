<?php
/**
 *@package pXP
 *@file MODFicha.php
 *@author  (José Mita)
 *@date 21-06-2016 10:11:23
 *@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
 */

class MODReporte extends MODbase{

    function __construct(CTParametro $pParam){
        parent::__construct($pParam);
    }

    function listarTicketAtendido(){
        //Definicion de variables para ejecucion del procedimientp
        $this->procedimiento='cola.ft_reporte_sel';
        $this->transaccion='COLA_REPTICKATE_SEL';
        $this->tipo_procedimiento='SEL';//tipo de transaccion
        if ( isset($this->arreglo['servidor_remoto'])) {
			$this->setRemote($this->arreglo['servidor_remoto']);
		}

        $this->setParametro('id_usuario','id_usuario','int4');

        //Definicion de la lista del resultado del query
        $this->captura('id_ficha','int4');
        $this->captura('ficha','varchar');
        $this->captura('sucursal','varchar');
        $this->captura('operador','varchar');
        $this->captura('servicio','varchar');
        $this->captura('tipo_ventanilla','varchar');
        $this->captura('numero_ventanilla','varchar');
        $this->captura('hora_generacion','varchar');
        $this->captura('fecha_generacion','varchar');
        $this->captura('hora_llamado','varchar');
        $this->captura('hora_inicio_atencion','varchar');
        $this->captura('hora_fin_atencion','varchar');
        $this->captura('tiempo_espera','varchar');
        $this->captura('tiempo_atencion','varchar');
		$this->captura('estado','varchar');


        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }

    function listarTicketAtencion(){
        //Definicion de variables para ejecucion del procedimientp
        $this->procedimiento='cola.ft_reporte_sel';
        $this->transaccion='COLA_REPTICKACT_SEL';
        $this->tipo_procedimiento='SEL';//tipo de transaccion
        if ( isset($this->arreglo['servidor_remoto'])) {
			$this->setRemote($this->arreglo['servidor_remoto']);
		}

        $this->setParametro('id_usuario','id_usuario','int4');
        $this->setParametro('estado','estado','varchar');

        //Definicion de la lista del resultado del query
        $this->captura('id_ficha','int4');
        $this->captura('ficha','varchar');
        $this->captura('sucursal','varchar');
        $this->captura('operador','varchar');
        $this->captura('servicio','varchar');
        $this->captura('tipo_ventanilla','varchar');
        $this->captura('numero_ventanilla','varchar');
        $this->captura('hora_generacion','varchar');
        $this->captura('hora_llamado','varchar');
        $this->captura('hora_inicio_atencion','varchar');
        $this->captura('hora_fin_atencion','varchar');
        $this->captura('tiempo_espera','varchar');
        $this->captura('tiempo_atencion','varchar');


        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }

    function listarTiemposArribo(){
        //Definicion de variables para ejecucion del procedimientp
        $this->procedimiento='cola.ft_reporte_sel';
        $this->transaccion='COLA_REPTIEARRI_SEL';
        $this->tipo_procedimiento='SEL';//tipo de transaccion
        if ( isset($this->arreglo['servidor_remoto'])) {
			$this->setRemote($this->arreglo['servidor_remoto']);
		}

        //Definicion de la lista del resultado del query
        $this->captura('hora','int4');
        $this->captura('rango','varchar');
        $this->captura('cantidad','integer');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }

    function listarTiemposEspera(){
        //Definicion de variables para ejecucion del procedimientp
        $this->procedimiento='cola.ft_reporte_sel';
        $this->transaccion='COLA_REPTIEESP_SEL';
        $this->tipo_procedimiento='SEL';//tipo de transaccion
        if ( isset($this->arreglo['servidor_remoto'])) {
			$this->setRemote($this->arreglo['servidor_remoto']);
		}

        //Definicion de la lista del resultado del query
        $this->captura('nombre','varchar');
        $this->captura('cantidad_atencion','integer');
        $this->captura('cantidad_espera','integer');
        $this->captura('cantidad_llamado','integer');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }

    function listarTiemposEsperaDetalle(){
        //Definicion de variables para ejecucion del procedimientp
        $this->procedimiento='cola.ft_reporte_sel';
        $this->transaccion='COLA_REPTIESPDET_SEL';
        $this->tipo_procedimiento='SEL';//tipo de transaccion
        $this->setCount(false);
		if ( isset($this->arreglo['servidor_remoto'])) {
			$this->setRemote($this->arreglo['servidor_remoto']);
		}

        //Definicion de la lista del resultado del query
        $this->captura('servicio','varchar');
        $this->captura('cantidad_atencion1','integer');
        $this->captura('cantidad_atencion2','integer');
        $this->captura('cantidad_atencion3','integer');

        $this->captura('cantidad_espera1','integer');
        $this->captura('cantidad_espera2','integer');
        $this->captura('cantidad_espera3','integer');

        $this->captura('cantidad_llamado1','integer');
        $this->captura('cantidad_llamado2','integer');
        $this->captura('cantidad_llamado3','integer');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }

    function listarHistoricoFichas(){
        //Definicion de variables para ejecucion del procedimientp
        $this->procedimiento='cola.ft_reporte_sel';
        $this->transaccion='COLA_REPHISFIC_SEL';
        $this->tipo_procedimiento='SEL';//tipo de transaccion
        if ( isset($this->arreglo['servidor_remoto'])) {
			$this->setRemote($this->arreglo['servidor_remoto']);
		}

        //Definicion de la lista del resultado del query
        $this->captura('operador','varchar');
        $this->captura('cantidad_finalizadas','numeric');
        $this->captura('cantidad_abandonadas','numeric');
        $this->captura('porcentaje_finalizadas','numeric');
        $this->captura('porcentaje_abandonadas','numeric');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
    function reporteCuadroI(){
        //Definicion de variables para ejecucion del procedimientp
        $this->procedimiento='cola.ft_reporte_sel';
        $this->transaccion='COLA_REPCUAI_SEL';
        $this->tipo_procedimiento='SEL';//tipo de transaccion
        $this->setCount(false);
		if ( isset($this->arreglo['servidor_remoto'])) {
			$this->setRemote($this->arreglo['servidor_remoto']);
		}

        //Definicion de la lista del resultado del query
        $this->captura('hora','int4');
        $this->captura('rango','varchar');
        $this->captura('cantidad_atendidos','numeric');
        $this->captura('cantidad_abandonados','numeric');
        $this->captura('promedio_espera','numeric');
        $this->captura('promedio_atencion','numeric');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }

    function listarHorasServicios(){
        //Definicion de variables para ejecucion del procedimientp
        $this->procedimiento='cola.ft_reporte_sel';
        $this->transaccion='COLA_LISTHORSERV_SEL';
        $this->tipo_procedimiento='SEL';//tipo de transaccion
        $this->setCount(false);
		if ( isset($this->arreglo['servidor_remoto'])) {
			$this->setRemote($this->arreglo['servidor_remoto']);
		}

        //Definicion de la lista del resultado del query
        $this->captura('nombre','varchar');
        $this->captura('tipo','varchar');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }

    function listarHorasUsuarios(){
        //Definicion de variables para ejecucion del procedimientp
        $this->procedimiento='cola.ft_reporte_sel';
        $this->transaccion='COLA_LISTHORUSU_SEL';
        $this->tipo_procedimiento='SEL';//tipo de transaccion
        $this->setCount(false);
		if ( isset($this->arreglo['servidor_remoto'])) {
			$this->setRemote($this->arreglo['servidor_remoto']);
		}

        //Definicion de la lista del resultado del query
        $this->captura('nombre','varchar');
        $this->captura('tipo','varchar');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
	
	function listarUsuariosServicio(){
        //Definicion de variables para ejecucion del procedimientp
        $this->procedimiento='cola.ft_reporte_sel';
        $this->transaccion='COLA_LISTUSUSERV_SEL';
        $this->tipo_procedimiento='SEL';//tipo de transaccion
        $this->setCount(false);
		if ( isset($this->arreglo['servidor_remoto'])) {
			$this->setRemote($this->arreglo['servidor_remoto']);
		}

        //Definicion de la lista del resultado del query
        $this->captura('nombre','varchar');
        $this->captura('tipo','varchar');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
	
	

    function listarCuadroII(){
        //Definicion de variables para ejecucion del procedimientp
        $this->procedimiento='cola.ft_reporte_sel';
        $this->transaccion='COLA_REPCUAII_SEL';
        $this->tipo_procedimiento='SEL';//tipo de transaccion
        $this->setCount(false);
		if ( isset($this->arreglo['servidor_remoto'])) {
			$this->setRemote($this->arreglo['servidor_remoto']);
		}

        //Definicion de la lista del resultado del query
        $this->captura('hora','varchar');
        $this->captura('servicio','varchar');
        $this->captura('cantidad','integer');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
	
	function listarCuadroIII(){
        //Definicion de variables para ejecucion del procedimientp
        $this->procedimiento='cola.ft_reporte_sel';
        $this->transaccion='COLA_REPCUAIII_SEL';
        $this->tipo_procedimiento='SEL';//tipo de transaccion
        $this->setCount(false);
		if ( isset($this->arreglo['servidor_remoto'])) {
			$this->setRemote($this->arreglo['servidor_remoto']);
		}

        //Definicion de la lista del resultado del query
        $this->captura('hora','varchar');
        $this->captura('usuario','varchar');
        $this->captura('cantidad','integer');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
	function listarCuadroVI(){
        //Definicion de variables para ejecucion del procedimientp
        $this->procedimiento='cola.ft_reporte_sel';
        $this->transaccion='COLA_REPCUAVI_SEL';
        $this->tipo_procedimiento='SEL';//tipo de transaccion
        $this->setCount(false);
		if ( isset($this->arreglo['servidor_remoto'])) {
			$this->setRemote($this->arreglo['servidor_remoto']);
		}

        //Definicion de la lista del resultado del query
        $this->captura('usuario','varchar');
        $this->captura('servicio','varchar');
        $this->captura('cantidad','integer');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
}
?>