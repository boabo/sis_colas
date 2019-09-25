CREATE OR REPLACE FUNCTION cola.f_resetear_fichas (
  p_id_sucursal_servicio integer
)
RETURNS varchar AS
$body$
DECLARE
	v_resp		            	varchar;
  	v_nombre_funcion        	text;
	    v_id_servicio 			integer;
    v_id_sucursal			integer;

    /*********************/
    v_id_minimo		integer;
    v_id_maximo_histo	integer;
    v_registros			record;
    v_id_minimo_ficha_estado	integer;
    v_id_maximo_ficha_estado_histo	integer;
    v_existencia		integer;
    v_historico_seq		bigint;
    v_estado_historico_seq	bigint;
    v_secuencia_ficha	bigint;
    v_secuencia_ficha_estado bigint;

BEGIN
	v_nombre_funcion = 'cola.f_resetear_fichas';

    if (p_id_sucursal_servicio =0) THEN

    	/*Controlamos si existen datos en la tabla tficha*/
        select count(fic.id_ficha) into v_existencia
        from cola.tficha fic;
        /*************************************************/

        if (v_existencia is not null) then

    		/*Verificamos si la secuencia de tficha inicio en 1*/
    		select min(fi.id_ficha) into v_id_minimo
            from cola.tficha fi;
    		/***************************************************/

            /*Obtenemos el maximo valor de la tabla tficha_historico*/
                select max(his.id_ficha) into v_id_maximo_histo
                from cola.tficha_historico his;
            /********************************************************/


            if (v_id_minimo <= v_id_maximo_histo) then

                /*Realizamos la actualizacion del id_ficha de acuerdo a la secuencia de tficha_historico*/
                    FOR v_registros in (select f.*
                                        from cola.tficha f
                                        order by f.id_ficha
                                        ) loop

                    v_id_maximo_histo = v_id_maximo_histo + 1;

                               UPDATE cola.tficha SET
                               id_ficha = v_id_maximo_histo
                               Where id_ficha = v_registros.id_ficha;

                               /*UPDATE cola.tficha_estado SET
                               id_ficha = v_id_maximo_histo
                               Where id_ficha = v_registros.id_ficha;*/



                    end loop;
                /***********************************************************************************************/


            end if;

            /*Verificamos si la secuencia de tficha_estado inició en 1*/
            select min(fies.id_ficha_estado) into v_id_minimo_ficha_estado
            from cola.tficha_estado fies;
            /**********************************************************/

            /*Obtenemos el maximo valor de la tabla tficha_historico*/
                select max(estHis.id_ficha_estado) into v_id_maximo_histo
                from cola.tficha_estado_historico estHis;
            	/********************************************************/
            	--raise exception 'llega auqi el id % , %',v_id_maximo_ficha_estado,v_id_maximo_histo;
             if (v_id_minimo_ficha_estado <= v_id_maximo_ficha_estado_histo) then

                /*Realizamos la actualizacion del id_ficha de acuerdo a la secuencia de tficha_estado_historico*/
                    FOR v_registros in (select f.*
                                        from cola.tficha_estado f
                                        ) loop

                    v_id_maximo_ficha_estado_histo = v_id_maximo_ficha_estado_histo + 1;

                               UPDATE cola.tficha_estado SET
                               id_ficha_estado = v_id_maximo_ficha_estado_histo
                               Where id_ficha_estado = v_registros.id_ficha_estado;

                    end loop;
                /***********************************************************************************************/

            end if;

    	    insert into cola.tficha_historico (id_usuario_reg, id_usuario_mod, fecha_reg, fecha_mod, estado_reg, id_ficha, id_prioridad, id_sucursal, id_servicio, sigla, numero, peso)
            select fic.id_usuario_reg, fic.id_usuario_mod, fic.fecha_reg, fic.fecha_mod, fic.estado_reg, fic.id_ficha, fic.id_prioridad, fic.id_sucursal, fic.id_servicio, fic.sigla, fic.numero, fic.peso
            from cola.tficha fic;

            insert into cola.tficha_estado_historico (id_usuario_reg, id_usuario_mod, fecha_reg, fecha_mod, estado_reg, id_usuario_ai, usuario_ai, id_ficha_estado, id_ficha, estado, fecha_hora_inicio,
            											fecha_hora_fin, id_tipo_ventanilla, id_usuario_atencion, numero_ventanilla, id_servicio)
            select fe.id_usuario_reg, fe.id_usuario_mod, fe.fecha_reg, fe.fecha_mod, fe.estado_reg, fe.id_usuario_ai, fe.usuario_ai, fe.id_ficha_estado, fe.id_ficha, fe.estado, fe.fecha_hora_inicio,
            											fe.fecha_hora_fin, fe.id_tipo_ventanilla, fe.id_usuario_atencion, fe.numero_ventanilla, fe.id_servicio
            from cola.tficha_estado fe
            inner join cola.tficha fic on fic.id_ficha=fe.id_ficha;

			TRUNCATE cola.tficha CASCADE;

             /*Obtenemos el nuevo id de la tabla historico*/
            /*Obtenemos el maximo valor de la tabla tficha_historico*/
                select max(his.id_ficha) into v_historico_seq
                from cola.tficha_historico his;
            /********************************************************/

            /*Obtenemos el maximo valor de la tabla tficha_historico*/
                select max(estHis.id_ficha_estado) into v_estado_historico_seq
                from cola.tficha_estado_historico estHis;
            /********************************************************/

            /********************Cambiamos la secuencia de la tabla tficha*********************/
            v_secuencia_ficha = (select pg_catalog.setval('cola.tficha_id_ficha_seq', v_historico_seq+1, true));
            /************************************************************************************/

            /********************Cambiamos la secuencia de la tabla tficha_estado*********************/
            v_secuencia_ficha_estado = (select pg_catalog.setval('cola.tficha_estado_id_ficha_estado_seq', v_estado_historico_seq+1, true));
            /************************************************************************************/


        end if;

		ELSE

        	select sucser.id_servicio, sucser.id_sucursal into v_id_servicio, v_id_sucursal
            from cola.tsucursal_servicio sucser
            where sucser.id_sucursal_servicio= p_id_sucursal_servicio;

            insert into cola.tficha_historico (id_usuario_reg, id_usuario_mod, fecha_reg, fecha_mod, estado_reg, id_ficha, id_prioridad, id_sucursal, id_servicio, sigla, numero, peso)
            select fic.id_usuario_reg, fic.id_usuario_mod, fic.fecha_reg, fic.fecha_mod, fic.estado_reg, fic.id_ficha, fic.id_prioridad, fic.id_sucursal, fic.id_servicio, fic.sigla, fic.numero, fic.peso
            from cola.tficha fic
            where fic.id_servicio = v_id_servicio and fic.id_sucursal = v_id_sucursal;

            insert into cola.tficha_estado_historico (id_usuario_reg, id_usuario_mod, fecha_reg, fecha_mod, estado_reg, id_usuario_ai, usuario_ai, id_ficha_estado, id_ficha, estado, fecha_hora_inicio,
            											fecha_hora_fin, id_tipo_ventanilla, id_usuario_atencion, numero_ventanilla, id_servicio)
            select fe.id_usuario_reg, fe.id_usuario_mod, fe.fecha_reg, fe.fecha_mod, fe.estado_reg, fe.id_usuario_ai, fe.usuario_ai, fe.id_ficha_estado, fe.id_ficha, fe.estado, fe.fecha_hora_inicio,
            											fe.fecha_hora_fin, fe.id_tipo_ventanilla, fe.id_usuario_atencion, fe.numero_ventanilla, fe.id_servicio
            from cola.tficha_estado fe
            inner join cola.tficha fic on fic.id_ficha=fe.id_ficha
            where fic.id_servicio = v_id_servicio and fic.id_sucursal = v_id_sucursal;

            /*Eliminamos el registro que se selecciono para el reseteo*/
            DELETE
            FROM cola.tficha_estado fe
            USING cola.tficha fic
            WHERE fic.id_ficha = fe.id_ficha and fic.id_servicio = v_id_servicio
            and fic.id_sucursal = v_id_sucursal;
            /**********************************************************/

			--TRUNCATE cola.tficha CASCADE;
            end if;



    return 'exito';

EXCEPTION
WHEN OTHERS THEN
		v_resp='';
		v_resp = pxp.f_agrega_clave(v_resp,'mensaje',SQLERRM);
		v_resp = pxp.f_agrega_clave(v_resp,'codigo_error',SQLSTATE);
		v_resp = pxp.f_agrega_clave(v_resp,'procedimientos',v_nombre_funcion);
		raise exception '%',v_resp;
END;
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER
COST 100;

ALTER FUNCTION cola.f_resetear_fichas (p_id_sucursal_servicio integer)
  OWNER TO postgres;
