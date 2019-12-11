CREATE OR REPLACE FUNCTION cola.ft_sucursal_ime (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		Sistema de Colas
 FUNCION: 		cola.ft_sucursal_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'cola.tsucursal'
 AUTOR: 		 (Jose Mita)
 FECHA:	        15-06-2016 23:15:40
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
	v_id_sucursal	integer;

BEGIN

    v_nombre_funcion = 'cola.ft_sucursal_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************
 	#TRANSACCION:  'COLA_sucur_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		Jose Mita
 	#FECHA:		15-06-2016 23:15:40
	***********************************/

	if(p_transaccion='COLA_sucur_INS')then

        begin
        	--Sentencia de la insercion
        	insert into cola.tsucursal(
			id_depto,
			estado_reg,
			codigo,
			mensaje_imp,
			nombre,
			id_usuario_reg,
			usuario_ai,
			fecha_reg,
			id_usuario_ai,
			fecha_mod,
			id_usuario_mod,
            servidor_remoto,
            /*Aumentando para relacionar con la sucursal de venta (Ismael Valdivia 11/12/2019)*/
            id_sucursal_venta
            /**********************************************************************************/
          	) values(
			v_parametros.id_depto,
			'activo',
			v_parametros.codigo,
			v_parametros.mensaje_imp,
			v_parametros.nombre,
			p_id_usuario,
			v_parametros._nombre_usuario_ai,
			now(),
			v_parametros._id_usuario_ai,
			null,
			null,
            v_parametros.servidor_remoto,
            /*Aumentando para relacionar con la sucursal de venta (Ismael Valdivia 11/12/2019)*/
            v_parametros.id_sucursal_venta
            /**********************************************************************************/
			)RETURNING id_sucursal into v_id_sucursal;

			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Sucursales almacenado(a) con exito (id_sucursal'||v_id_sucursal||')');
            v_resp = pxp.f_agrega_clave(v_resp,'id_sucursal',v_id_sucursal::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************
 	#TRANSACCION:  'COLA_sucur_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		Jose Mita
 	#FECHA:		15-06-2016 23:15:40
	***********************************/

	elsif(p_transaccion='COLA_sucur_MOD')then

		begin
			--Sentencia de la modificacion
			update cola.tsucursal set
			id_depto = v_parametros.id_depto,
			codigo = v_parametros.codigo,
			mensaje_imp = v_parametros.mensaje_imp,
			nombre = v_parametros.nombre,
			fecha_mod = now(),
			id_usuario_mod = p_id_usuario,
			id_usuario_ai = v_parametros._id_usuario_ai,
			usuario_ai = v_parametros._nombre_usuario_ai,
            servidor_remoto = v_parametros.servidor_remoto,
            /*Aumentando para relacionar con la sucursal de venta (Ismael Valdivia 11/12/2019)*/
            id_sucursal_venta = v_parametros.id_sucursal_venta
            /**********************************************************************************/
			where id_sucursal=v_parametros.id_sucursal;

			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Sucursales modificado(a)');
            v_resp = pxp.f_agrega_clave(v_resp,'id_sucursal',v_parametros.id_sucursal::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************
 	#TRANSACCION:  'COLA_sucur_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		Jose Mita
 	#FECHA:		15-06-2016 23:15:40
	***********************************/

	elsif(p_transaccion='COLA_sucur_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from cola.tsucursal
            where id_sucursal=v_parametros.id_sucursal;

            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Sucursales eliminado(a)');
            v_resp = pxp.f_agrega_clave(v_resp,'id_sucursal',v_parametros.id_sucursal::varchar);

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

ALTER FUNCTION cola.ft_sucursal_ime (p_administrador integer, p_id_usuario integer, p_tabla varchar, p_transaccion varchar)
  OWNER TO postgres;
