CREATE OR REPLACE FUNCTION cola.ft_ficha_ime (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
  /**************************************************************************
 SISTEMA:		Sistema de Colas
 FUNCION: 		cola.ft_ficha_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'cola.tficha'
 AUTOR: 		 (Jose Mita)
 FECHA:	        21-06-2016 10:11:23
 COMENTARIOS:
***************************************************************************
 HISTORIAL DE MODIFICACIONES:

 DESCRIPCION:
 AUTOR:
 FECHA:
***************************************************************************/

DECLARE

	v_nro_requerimiento    	integer;
	v_parametros           	record;
	v_id_requerimiento     	integer;
	v_resp		            varchar;
	v_nombre_funcion        text;
	v_mensaje_error         text;
	v_id_ficha				integer;
    v_id_ficha_estado		integer;
    sigla_servi				varchar;
    sigla_priori			varchar;
    peso_priori				integer;
    peso_servi				integer;
    sigla_ficha				varchar;
    m_imp					varchar;
    nombre_sucursal			varchar;
    v_fecha_reg				timestamp;
      v_num_ventanilla	varchar;
    v_servicio_inicial		varchar;
    v_array_servicios 	varchar;




BEGIN

    v_nombre_funcion = 'cola.ft_ficha_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************
 	#TRANSACCION:  'COLA_ficha_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		Jose Mita
 	#FECHA:		21-06-2016 10:11:23
	***********************************/

	if(p_transaccion='COLA_ficha_INS')then

        begin
        	--Sentencia de la insercion

            select suc.mensaje_imp, suc.nombre into m_imp, nombre_sucursal
            from cola.tsucursal suc
            where suc.id_sucursal = v_parametros.id_sucursal;

			select sigla, peso into sigla_servi, peso_servi
            from cola.tservicio
            where id_servicio =v_parametros.id_servicio;

            select sigla, peso into sigla_priori, peso_priori
            from cola.tprioridad
            where id_prioridad = v_parametros.id_prioridad;


	        sigla_ficha = cola.f_obtener_num_ficha(v_parametros.id_sucursal,v_parametros.id_servicio,v_parametros.id_prioridad);


        	insert into cola.tficha(
			numero,
			estado_reg,
			id_sucursal,
			sigla,
			id_servicio,
			id_prioridad,
			peso,
			id_usuario_reg,
			usuario_ai,
			fecha_reg,
			id_usuario_ai,
			id_usuario_mod,
			fecha_mod,
            ultima_llamada
          	) values(
			peso_priori,
			'activo',
			v_parametros.id_sucursal,
			sigla_ficha,
			v_parametros.id_servicio,
			v_parametros.id_prioridad,
			peso_priori+peso_servi,
			p_id_usuario,
			v_parametros._nombre_usuario_ai,
			now(),
			v_parametros._id_usuario_ai,
			null,
			null,
            null
			)RETURNING id_ficha, sigla, fecha_reg into v_id_ficha, sigla_ficha, v_fecha_reg;

            insert into cola.tficha_estado(
			id_ficha,
			estado_reg,
			estado,
			fecha_hora_inicio,
			usuario_ai,
			fecha_reg,
			id_usuario_reg,
			id_usuario_ai,
			fecha_mod,
			id_usuario_mod
          	) values(
			v_id_ficha,
			'activo',
			'espera',
			now(),
			v_parametros._nombre_usuario_ai,
			now(),
			p_id_usuario,
			v_parametros._id_usuario_ai,
			null,
			null
			);

			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Fichas almacenado(a) con exito (id_ficha'||v_id_ficha||')');
            v_resp = pxp.f_agrega_clave(v_resp,'id_ficha',v_id_ficha::varchar);
            v_resp = pxp.f_agrega_clave(v_resp,'sigla',sigla_ficha::varchar);
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje_impresion',m_imp::varchar);
            v_resp = pxp.f_agrega_clave(v_resp,'nombre_suc',nombre_sucursal::varchar);
            v_resp = pxp.f_agrega_clave(v_resp,'v_fecha_reg',to_char(v_fecha_reg,'DD/MM/YYYY HH24:MI:SS')::VARCHAR);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************
 	#TRANSACCION:  'COLA_ficha_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		Jose Mita
 	#FECHA:		21-06-2016 10:11:23
	***********************************/

	elsif(p_transaccion='COLA_ficha_MOD')then

		begin
			--Sentencia de la modificacion
			update cola.tficha set
			numero = v_parametros.numero,
			id_sucursal = v_parametros.id_sucursal,
			sigla = v_parametros.sigla,
			id_servicio = v_parametros.id_servicio,
			id_prioridad = v_parametros.id_prioridad,
			peso = v_parametros.peso,
			id_usuario_mod = p_id_usuario,
			fecha_mod = now(),
			id_usuario_ai = v_parametros._id_usuario_ai,
			usuario_ai = v_parametros._nombre_usuario_ai
			where id_ficha=v_parametros.id_ficha;

			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Fichas modificado(a)');
            v_resp = pxp.f_agrega_clave(v_resp,'id_ficha',v_parametros.id_ficha::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************
 	#TRANSACCION:  'COLA_ficha_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		Jose Mita
 	#FECHA:		21-06-2016 10:11:23
	***********************************/

	elsif(p_transaccion='COLA_ficha_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from cola.tficha
            where id_ficha=v_parametros.id_ficha;

            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Fichas eliminado(a)');
            v_resp = pxp.f_agrega_clave(v_resp,'id_ficha',v_parametros.id_ficha::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

    /*********************************
 	#TRANSACCION:  'COLA_rellam_MOD'
 	#DESCRIPCION:	Actualizacion de la ultima llamada
 	#AUTOR:		Jose Mita
 	#FECHA:		22-07-2016 10:11:23
	***********************************/

	elsif(p_transaccion='COLA_RELLAM_MOD')then

		begin
			--Sentencia de la modificacion
			update cola.tficha set
			ultima_llamada= now(),
			fecha_mod = now()
			where id_ficha=v_parametros.id_ficha;

			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Fichas modificado(a)');
            v_resp = pxp.f_agrega_clave(v_resp,'id_ficha',v_parametros.id_ficha::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

      /*********************************
 	#TRANSACCION:  'COLA_derivar_MOD'
 	#DESCRIPCION:	Derivacion de una ficha
 	#AUTOR:		Jose Mita
 	#FECHA:		22-07-2016 15:11:23
	***********************************/

	elsif(p_transaccion='COLA_DERIVAR_MOD')then

		begin
			--Sentencia de la modificacion
           -- raise exception '%','llega al modificado';
			if (v_parametros.id_servicio_der >= 0) then
                  update cola.tficha set
                  ultima_llamada= null,
                  fecha_mod = now(),
                  id_servicio = v_parametros.id_servicio_der,
                    peso = 1000
                  where id_ficha=v_parametros.id_ficha;
            elsif (v_parametros.id_usuario is not null) then
            	update cola.tficha set
                  fecha_mod = now(),
                    peso = 1000
                  where id_ficha=v_parametros.id_ficha;

            end if;


            update cola.tficha_estado set
			fecha_mod = now(),
            fecha_hora_fin = now(),
            id_servicio = string_to_array (v_parametros.ids_servicio,',')::INTEGER[]
			where id_ficha=v_parametros.id_ficha and estado_reg='activo';

            update cola.tficha_estado set
			estado_reg = 'inactivo'
			where id_ficha=v_parametros.id_ficha;

            insert into cola.tficha_estado(
			id_usuario_reg,
			estado_reg,
            id_ficha,
			estado,
			fecha_hora_inicio,
			id_usuario_atencion
          	) values(
			p_id_usuario,
			'activo',
			v_parametros.id_ficha,
			'espera',
			now(),
			v_parametros.id_usuario
			);

			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Fichas modificado(a)');
            v_resp = pxp.f_agrega_clave(v_resp,'id_ficha',v_parametros.id_ficha::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;
     /*********************************
 	#TRANSACCION:  'COLA_INIATE_MOD'
 	#DESCRIPCION:	Iniciar atencion de una ficha
 	#AUTOR:		Jose Mita
 	#FECHA:		24-07-2016 15:11:23
	***********************************/

	elsif(p_transaccion='COLA_INIATE_MOD')then

		begin
			--Sentencia de la modificacion
			  select usc.numero_ventanilla into  v_num_ventanilla
            from cola.tusuario_sucursal usc
            where usc.id_usuario = p_id_usuario;

            update cola.tficha_estado set
			fecha_mod = now(),
            fecha_hora_fin = now()
			where id_ficha=v_parametros.id_ficha and estado_reg='activo';

            update cola.tficha_estado set
			estado_reg = 'inactivo'
			where id_ficha=v_parametros.id_ficha;

            insert into cola.tficha_estado(
			id_ficha,

			estado,
			fecha_hora_inicio,

			id_usuario_reg,

            numero_ventanilla,
            id_usuario_atencion
          	) values(
			v_parametros.id_ficha,

			'en_atencion',
			now(),

			p_id_usuario,

            v_num_ventanilla,
            p_id_usuario
			);

			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Fichas modificado(a)');
            v_resp = pxp.f_agrega_clave(v_resp,'id_ficha',v_parametros.id_ficha::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;
    /*********************************
 	#TRANSACCION:  'COLA_FINFIC_MOD'
 	#DESCRIPCION:	Finalizacion de una ficha
 	#AUTOR:		Jose Mita
 	#FECHA:		24-07-2016 15:11:23
	***********************************/

	elsif(p_transaccion='COLA_FINFIC_MOD')then

		begin
			--Sentencia de la modificacion
            /*Controlaremos que los servicios ingresados no contenga servicio inicial (1) si tiene mostrar mensaje*/
            select '{'||v_parametros.ids_servicio||'}' into v_array_servicios;
            select '{1}' && (v_array_servicios::int[]) into v_servicio_inicial;

            if (v_servicio_inicial = 'true') then
            	raise exception 'El servicio Inicial no debe ser seleccionado, Verifique!';
            end if;

            /**************************************************************************************************************/

			select usc.numero_ventanilla into  v_num_ventanilla
            from cola.tusuario_sucursal usc
            where usc.id_usuario = p_id_usuario;

            update cola.tficha_estado set
			fecha_mod = now(),
            fecha_hora_fin = now()
			where id_ficha=v_parametros.id_ficha and estado_reg='activo';

            update cola.tficha_estado set

			estado_reg = 'inactivo'
			where id_ficha=v_parametros.id_ficha;

            insert into cola.tficha_estado(
			id_ficha,

			estado,
			fecha_hora_inicio,
			fecha_hora_fin,
			id_usuario_reg,

            numero_ventanilla,
            id_usuario_atencion,
            id_servicio
          	) values(
			v_parametros.id_ficha,

			'finalizado',
			now(),
			now(),
			p_id_usuario,

            v_num_ventanilla,
            p_id_usuario,
            string_to_array (v_parametros.ids_servicio,',')::INTEGER[]
			);

			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Fichas modificado(a)');
            v_resp = pxp.f_agrega_clave(v_resp,'id_ficha',v_parametros.id_ficha::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;
     /*********************************
 	#TRANSACCION:  'COLA_NOSHOW_MOD'
 	#DESCRIPCION:	No se presento para la atencion de una ficha
 	#AUTOR:		Jose Mita
 	#FECHA:		26-07-2016 15:11:23
	***********************************/

	elsif(p_transaccion='COLA_NOSHOW_MOD')then

		begin
			--Sentencia de la modificacion
			  select usc.numero_ventanilla into  v_num_ventanilla
            from cola.tusuario_sucursal usc
            where usc.id_usuario = p_id_usuario;

            update cola.tficha_estado set
			fecha_mod = now(),
            fecha_hora_fin = now()
			where id_ficha=v_parametros.id_ficha and estado_reg='activo';

            update cola.tficha_estado set
			estado_reg = 'inactivo'
			where id_ficha=v_parametros.id_ficha;

            insert into cola.tficha_estado(
			id_ficha,

			estado,
			fecha_hora_inicio,
			fecha_hora_fin,
			id_usuario_reg,

            numero_ventanilla,
            id_usuario_atencion

          	) values(
			v_parametros.id_ficha,

			'no_show',
			now(),
			now(),
			p_id_usuario,

            v_num_ventanilla,
            p_id_usuario

			);

			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Fichas modificado(a)');
            v_resp = pxp.f_agrega_clave(v_resp,'id_ficha',v_parametros.id_ficha::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;
     /*********************************
 	#TRANSACCION:  'COLA_ACTFIC_MOD'
 	#DESCRIPCION:	Activacion de una ficha
 	#AUTOR:		Jose Mita
 	#FECHA:		01-08-2016 15:11:23
	***********************************/

	elsif(p_transaccion='COLA_ACTFIC_MOD')then

		begin
			--Sentencia de la modificacion

			update cola.tficha set
			ultima_llamada= null,
			fecha_mod = now()
            where id_ficha=v_parametros.id_ficha;

            update cola.tficha_estado set
			fecha_mod = now(),
            fecha_hora_fin = now()
			where id_ficha=v_parametros.id_ficha and estado_reg='activo';

            update cola.tficha_estado set
			estado_reg = 'inactivo'
			where id_ficha=v_parametros.id_ficha;

            insert into cola.tficha_estado(
			id_ficha,
			estado_reg,
			estado,
			fecha_hora_inicio,

			id_usuario_reg


          	) values(
			v_parametros.id_ficha,
			'activo',
			'espera',
			now(),

			p_id_usuario

			);

			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Fichas modificado(a)');
            v_resp = pxp.f_agrega_clave(v_resp,'id_ficha',v_parametros.id_ficha::varchar);

            --Devuelve la respuesta
            return v_resp;
        end;
	else

    	raise exception 'Transaccion inexistente: %',p_transaccion;

	end if;

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

ALTER FUNCTION cola.ft_ficha_ime (p_administrador integer, p_id_usuario integer, p_tabla varchar, p_transaccion varchar)
  OWNER TO postgres;
