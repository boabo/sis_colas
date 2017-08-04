CREATE OR REPLACE FUNCTION "cola"."ft_mensaje_ime" (	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$

/**************************************************************************
 SISTEMA:		Sistema de Colas
 FUNCION: 		cola.ft_mensaje_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'cola.tmensaje'
 AUTOR: 		 (admin)
 FECHA:	        17-05-2017 13:33:23
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
	v_id_mensaje	integer;

	v_record RECORD;
	v_id_sucursal varchar;
			    
BEGIN

    v_nombre_funcion = 'cola.ft_mensaje_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'COLA_MEN_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		admin	
 	#FECHA:		17-05-2017 13:33:23
	***********************************/

	if(p_transaccion='COLA_MEN_INS')then
					
        begin


        	--Sentencia de la insercion
        	insert into cola.tmensaje(
			titulo,
			estado_reg,
			mensaje,
			id_usuario_ai,
			id_usuario_reg,
			fecha_reg,
			usuario_ai,
			id_usuario_mod,
			fecha_mod
          	) values(
			v_parametros.titulo,
			'activo',
			v_parametros.mensaje,
			v_parametros._id_usuario_ai,
			p_id_usuario,
			now(),
			v_parametros._nombre_usuario_ai,
			null,
			null
							
			
			
			)RETURNING id_mensaje into v_id_mensaje;


					for v_id_sucursal in select regexp_split_to_table(v_parametros.id_sucursales,',') LOOP

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
							v_id_sucursal::integer,
							v_id_mensaje,
							'activo',
							v_parametros._id_usuario_ai,
							p_id_usuario,
							now(),
							v_parametros._nombre_usuario_ai,
							null,
							null



						);

					END LOOP;

			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Mensaje almacenado(a) con exito (id_mensaje'||v_id_mensaje||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_mensaje',v_id_mensaje::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'COLA_MEN_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		admin	
 	#FECHA:		17-05-2017 13:33:23
	***********************************/

	elsif(p_transaccion='COLA_MEN_MOD')then

		begin
			--Sentencia de la modificacion
			update cola.tmensaje set
			titulo = v_parametros.titulo,
			mensaje = v_parametros.mensaje,
			id_usuario_mod = p_id_usuario,
			fecha_mod = now(),
			id_usuario_ai = v_parametros._id_usuario_ai,
			usuario_ai = v_parametros._nombre_usuario_ai
			where id_mensaje=v_parametros.id_mensaje;

			DELETE FROM cola.tsucursal_mensaje where id_mensaje = v_parametros.id_mensaje;

			for v_id_sucursal in select regexp_split_to_table(v_parametros.id_sucursales,',') LOOP

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
					v_id_sucursal::integer,
					v_parametros.id_mensaje,
					'activo',
					v_parametros._id_usuario_ai,
					p_id_usuario,
					now(),
					v_parametros._nombre_usuario_ai,
					null,
					null



				);

			END LOOP;

               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Mensaje modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_mensaje',v_parametros.id_mensaje::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'COLA_MEN_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		admin	
 	#FECHA:		17-05-2017 13:33:23
	***********************************/

	elsif(p_transaccion='COLA_MEN_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from cola.tmensaje
            where id_mensaje=v_parametros.id_mensaje;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Mensaje eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_mensaje',v_parametros.id_mensaje::varchar);
              
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
ALTER FUNCTION "cola"."ft_mensaje_ime"(integer, integer, character varying, character varying) OWNER TO postgres;
