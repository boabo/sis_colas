<?php

/**
 * @package pXP
 * @file MODFicha.php
 * @author  (José Mita)
 * @date 21-06-2016 10:11:23
 * @description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
 */
class MODFicha extends MODbase
{

    function __construct(CTParametro $pParam)
    {
        parent::__construct($pParam);
    }

    function listarFicha()
    {

        //Definicion de variables para ejecucion del procedimientp

        $this->procedimiento = 'cola.ft_ficha_sel';
        $this->transaccion = 'COLA_ficha_SEL';
        $this->tipo_procedimiento = 'SEL';//tipo de transaccion
        /*if ( isset($this->arreglo['servidor_remoto'])) {
            $this->setRemote($this->arreglo['servidor_remoto']);
        }*/

        //Definicion de la lista del resultado del query
        $this->captura('id_ficha', 'int4');
        $this->captura('numero', 'int4');
        $this->captura('estado_reg', 'varchar');
        $this->captura('id_sucursal', 'int4');
        $this->captura('sigla', 'varchar');
        $this->captura('id_servicio', 'int4');
        $this->captura('id_prioridad', 'int4');
        $this->captura('peso', 'int4');
        $this->captura('id_usuario_reg', 'int4');
        $this->captura('usuario_ai', 'varchar');
        $this->captura('fecha_reg', 'timestamp');
        $this->captura('id_usuario_ai', 'int4');
        $this->captura('id_usuario_mod', 'int4');
        $this->captura('fecha_mod', 'timestamp');
        $this->captura('usr_reg', 'varchar');
        $this->captura('usr_mod', 'varchar');
        $this->captura('nombre_sucur', 'varchar');
        $this->captura('nombre_servi', 'varchar');
        $this->captura('nombre_priori', 'varchar');
        $this->captura('estado_ficha', 'varchar');
        $this->captura('fecha_hora_inicio', 'varchar');
        $this->captura('cola_atencion', 'int4');
        $this->captura('desc_persona', 'text');
        $this->captura('ultima_llamada', 'varchar');
        $this->captura('numero_ventanilla', 'varchar');
        $this->captura('minuto_espera', 'varchar');
        $this->captura('fecha_hora_fin', 'varchar');
        $this->captura('derivado', 'text');
        $this->captura('peso_prioridad', 'integer');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }

    function listarFichaTotal()
    {


        //Definicion de variables para ejecucion del procedimientp

        $this->procedimiento = 'cola.ft_ficha_sel';
        $this->transaccion = 'COLA_fichaTotal_SEL';
        $this->tipo_procedimiento = 'SEL';//tipo de transaccion
        $this->setCount(false);
        //Definicion de la lista del resultado del query
        $this->setParametro('id_sucursal','id_sucursal','int4');

        $this->captura('cantidad', 'int4');
        $this->captura('nombre', 'varchar');

        //Ejecuta la instruccion

        $this->armarConsulta();

        /*echo "aquiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiii";
         echo $this->getConsulta();
         exit; */
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }

    function insertarFicha()
    {
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento = 'cola.ft_ficha_ime';
        $this->transaccion = 'COLA_ficha_INS';
        $this->tipo_procedimiento = 'IME';

        //Define los parametros para la funcion
        $this->setParametro('numero', 'numero', 'int4');
        $this->setParametro('estado_reg', 'estado_reg', 'varchar');
        $this->setParametro('id_sucursal', 'id_sucursal', 'int4');

        $this->setParametro('id_servicio', 'id_servicio', 'int4');
        $this->setParametro('id_prioridad', 'id_prioridad', 'int4');


        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }

    function modificarFicha()
    {
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento = 'cola.ft_ficha_ime';
        $this->transaccion = 'COLA_ficha_MOD';
        $this->tipo_procedimiento = 'IME';

        //Define los parametros para la funcion
        $this->setParametro('id_ficha', 'id_ficha', 'int4');
        $this->setParametro('numero', 'numero', 'int4');
        $this->setParametro('estado_reg', 'estado_reg', 'varchar');
        $this->setParametro('id_sucursal', 'id_sucursal', 'int4');
        $this->setParametro('sigla', 'sigla', 'varchar');
        $this->setParametro('id_servicio', 'id_servicio', 'int4');
        $this->setParametro('id_prioridad', 'id_prioridad', 'int4');
        $this->setParametro('peso', 'peso', 'int4');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }

    function eliminarFicha()
    {
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento = 'cola.ft_ficha_ime';
        $this->transaccion = 'COLA_ficha_ELI';
        $this->tipo_procedimiento = 'IME';

        //Define los parametros para la funcion
        $this->setParametro('id_ficha', 'id_ficha', 'int4');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }

    function llamarSiguienteFicha()
    {
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento = 'cola.ft_ficha_sel';
        $this->transaccion = 'COLA_llamsig_INS';
        $this->tipo_procedimiento = 'SEL';
        $this->setCount(false);

        $this->setParametro('id_sucursal', 'id_sucursal', 'int4');

        $this->captura('id_ficha', 'int4');
        $this->captura('id_servicio', 'int4');
        $this->captura('sigla', 'varchar');
        $this->captura('nombre_servi', 'varchar');
        $this->captura('nombre_priori', 'varchar');
        $this->captura('fecha_hora_inicio', 'varchar');
        $this->captura('minutos', 'int4');
        $this->captura('estado_ficha', 'varchar');
        $this->captura('id_sucursal', 'int4');
        $this->captura('numero_ventanilla', 'int4');
        $this->captura('letra_ventanila', 'varchar');
        $this->captura('desc_tipo_ventanilla', 'varchar');

        //Ejecuta la instruccion
        $this->armarConsulta();


        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }

    function rellamadaFicha()
    {
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento = 'cola.ft_ficha_ime';
        $this->transaccion = 'COLA_RELLAM_MOD';
        $this->tipo_procedimiento = 'IME';

        //Define los parametros para la funcion
        $this->setParametro('id_ficha', 'id_ficha', 'int4');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }

    function derivarFicha()
    {
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento = 'cola.ft_ficha_ime';
        $this->transaccion = 'COLA_DERIVAR_MOD';
        $this->tipo_procedimiento = 'IME';

        //Define los parametros para la funcion
        $this->setParametro('id_ficha', 'id_ficha', 'int4');
        $this->setParametro('ids_servicio', 'ids_servicio', 'varchar');
        $this->setParametro('id_usuario', 'id_usuario', 'int4');
        $this->setParametro('id_servicio_der', 'id_servicio_der', 'int4');

        //Ejecuta la instruccion
        $this->armarConsulta();

        /*echo "aquiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiii";
         echo $this->getConsulta();
         exit;
        */
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }

    function finalizarFicha()
    {
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento = 'cola.ft_ficha_ime';
        $this->transaccion = 'COLA_FINFIC_MOD';
        $this->tipo_procedimiento = 'IME';

        //Define los parametros para la funcion
        $this->setParametro('id_ficha', 'id_ficha', 'int4');
        $this->setParametro('ids_servicio', 'ids_servicio', 'varchar');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }

    function iniciarAtencion()
    {
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento = 'cola.ft_ficha_ime';
        $this->transaccion = 'COLA_INIATE_MOD';
        $this->tipo_procedimiento = 'IME';

        //Define los parametros para la funcion
        $this->setParametro('id_ficha', 'id_ficha', 'int4');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }

    function noShowFicha()
    {
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento = 'cola.ft_ficha_ime';
        $this->transaccion = 'COLA_NOSHOW_MOD';
        $this->tipo_procedimiento = 'IME';

        //Define los parametros para la funcion
        $this->setParametro('id_ficha', 'id_ficha', 'int4');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }

    function llamarFichaPantalla()
    {
        //Definicion de variables para ejecucion del procedimientp
        $this->procedimiento = 'cola.ft_ficha_sel';
        $this->transaccion = 'COLA_llapan_SEL';
        $this->tipo_procedimiento = 'SEL';//tipo de transaccion
        $this->setCount(false);

        //$this->setParametro('fecha_pantalla','fecha_pantalla','timestamp');
        //$this->setParametro('id_sucursal','id_sucursal','int4');

        //Definicion de la lista del resultado del query
        $this->captura('sigla', 'varchar');
        $this->captura('ultima_llamada', 'timestamp');
        $this->captura('numero_ventanilla', 'int4');
        $this->captura('fecha_respuesta', 'timestamp');
        $this->captura('letra_ventanila', 'varchar');
        $this->captura('prioridad', 'int4');
        $this->captura('desc_tipo_ventanilla', 'varchar');


        //Ejecuta la instruccion
        $this->armarConsulta();
        /*echo "aquiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiii";
         echo $this->getConsulta();
         exit; */

        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }

    function activarFicha()
    {
        //Definicion de variables para ejecucion del procedimiento
        $this->procedimiento = 'cola.ft_ficha_ime';
        $this->transaccion = 'COLA_ACTFIC_MOD';
        $this->tipo_procedimiento = 'IME';

        //Define los parametros para la funcion
        $this->setParametro('id_ficha', 'id_ficha', 'int4');

        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }

    function reporteStatus(){
        //Definicion de variables para ejecucion del procedimientp
        $this->procedimiento='cola.ft_ficha_sel';
        $this->transaccion='COLA_FICSTATUS_SEL';
        $this->tipo_procedimiento='SEL';//tipo de transaccion
        $this-> setCount(false);


        //mandamos parametros
        $this->setParametro('id_sucursal', 'id_sucursal', 'int4');
        $this->setParametro('desde', 'desde', 'date');
        $this->setParametro('hasta', 'hasta', 'date');


        //Definicion de la lista del resultado del query
        $this->captura('cantidad_estado','numeric');
        $this->captura('porcentaje_estado','numeric');
        $this->captura('estado','varchar');


        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
    function reporteTiempoAtencionEstado(){
        //Definicion de variables para ejecucion del procedimientp
        $this->procedimiento='cola.ft_ficha_sel';
        $this->transaccion='COLA_FICATEN_SEL';
        $this->tipo_procedimiento='SEL';//tipo de transaccion
        $this-> setCount(false);


        //mandamos parametros
        $this->setParametro('id_sucursal', 'id_sucursal', 'int4');
        $this->setParametro('desde', 'desde', 'date');
        $this->setParametro('hasta', 'hasta', 'date');


        //Definicion de la lista del resultado del query
        $this->captura('estado','varchar');
        $this->captura('promedio_estado','numeric');


        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
    function reporteServicio(){
        //Definicion de variables para ejecucion del procedimientp
        $this->procedimiento='cola.ft_ficha_sel';
        $this->transaccion='COLA_FICSER_SEL';
        $this->tipo_procedimiento='SEL';//tipo de transaccion
        $this-> setCount(false);


        //mandamos parametros
        $this->setParametro('id_sucursal', 'id_sucursal', 'int4');
        $this->setParametro('desde', 'desde', 'date');
        $this->setParametro('hasta', 'hasta', 'date');


        //Definicion de la lista del resultado del query
        $this->captura('cantidad_estado','numeric');
        $this->captura('porcentaje_servicio','numeric');
        $this->captura('servicio','varchar');


        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }

    function reporteTiempoAtencionUsuario(){
        //Definicion de variables para ejecucion del procedimientp
        $this->procedimiento='cola.ft_ficha_sel';
        $this->transaccion='COLA_FICATENUS_SEL';
        $this->tipo_procedimiento='SEL';//tipo de transaccion
        $this-> setCount(false);


        //mandamos parametros
        $this->setParametro('id_sucursal', 'id_sucursal', 'int4');
        $this->setParametro('desde', 'desde', 'date');
        $this->setParametro('hasta', 'hasta', 'date');


        //Definicion de la lista del resultado del query
        $this->captura('desc_persona','text');
        $this->captura('cantidad','int8');
        $this->captura('espera','numeric');
        $this->captura('llamado','numeric');
        $this->captura('atencion','numeric');


        //Ejecuta la instruccion
        $this->armarConsulta();
        $this->ejecutarConsulta();

        //Devuelve la respuesta
        return $this->respuesta;
    }
}

?>
