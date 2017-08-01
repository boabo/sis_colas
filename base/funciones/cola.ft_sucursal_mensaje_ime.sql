CREATE OR REPLACE FUNCTION "cola"."ft_sucursal_mensaje_ime" (	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$

/**************************************************************************
 SISTEMA:		Sistema de Colas
 FUNCION: 		cola.ft_sucursal_mensaje_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'cola.tsucursal_mensaje'
 AUTOR: 		 (admin)
 FECHA:	        17-05-2017 13:39:41
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
	v_id_sucursal_mensaje	integer;
			    
BEGIN

    v_nombre_funcion = 'cola.ft_sucursal_mensaje_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'COLA_SUCMEN_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		admin	
 	#FECHA:		17-05-2017 13:39:41
	***********************************/

	if(p_transaccion='COLA_SUCMEN_INS')then
					
        begin
        	--Sentencia de la insercion
        	insert into cola.tsucursal_mensaje(
			id_sucursal,
			id_mensaje,
			estado_reg,
			id_usuario_ai,
			id_usuario_reg,
			fecha_reg,
			usuario_ai,
			fecha_mod,
			id_usuario_mod
          	) values(
			v_parametros.id_sucursal,
			v_parametros.id_mensaje,
			'activo',
			v_parametros._id_usuario_ai,
			p_id_usuario,
			now(),
			v_parametros._nombre_usuario_ai,
			null,
			null
							
			
			
			)RETURNING id_sucursal_mensaje into v_id_sucursal_mensaje;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','SucursalMensaje almacenado(a) con exito (id_sucursal_mensaje'||v_id_sucursal_mensaje||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_sucursal_mensaje',v_id_sucursal_mensaje::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'COLA_SUCMEN_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		admin	
 	#FECHA:		17-05-2017 13:39:41
	***********************************/

	elsif(p_transaccion='COLA_SUCMEN_MOD')then

		begin
			--Sentencia de la modificacion
			update cola.tsucursal_mensaje set
			id_sucursal = v_parametros.id_sucursal,
			id_mensaje = v_parametros.id_mensaje,
			fecha_mod = now(),
			id_usuario_mod = p_id_usuario,
			id_usuario_ai = v_parametros._id_usuario_ai,
			usuario_ai = v_parametros._nombre_usuario_ai
			where id_sucursal_mensaje=v_parametros.id_sucursal_mensaje;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','SucursalMensaje modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_sucursal_mensaje',v_parametros.id_sucursal_mensaje::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'COLA_SUCMEN_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		admin	
 	#FECHA:		17-05-2017 13:39:41
	***********************************/

	elsif(p_transaccion='COLA_SUCMEN_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from cola.tsucursal_mensaje
            where id_sucursal_mensaje=v_parametros.id_sucursal_mensaje;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','SucursalMensaje eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_sucursal_mensaje',v_parametros.id_sucursal_mensaje::varchar);
              
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
$BODY$
LANGUAGE 'plpgsql' VOLATILE
COST 100;
ALTER FUNCTION "cola"."ft_sucursal_mensaje_ime"(integer, integer, character varying, character varying) OWNER TO postgres;
