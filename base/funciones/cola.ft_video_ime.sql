CREATE OR REPLACE FUNCTION "cola"."ft_video_ime" (	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$

/**************************************************************************
 SISTEMA:		Sistema de Colas
 FUNCION: 		cola.ft_video_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'cola.tvideo'
 AUTOR: 		 (favio.figueroa)
 FECHA:	        08-08-2017 21:46:18
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
	v_id_video	integer;

	v_id_sucursal varchar;



BEGIN

    v_nombre_funcion = 'cola.ft_video_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'COLA_VIDE_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		favio.figueroa	
 	#FECHA:		08-08-2017 21:46:18
	***********************************/

	if(p_transaccion='COLA_VIDE_INS')then
					
        begin
        	--Sentencia de la insercion
        	insert into cola.tvideo(
			estado_reg,
			descripcion,
			usuario_ai,
			fecha_reg,
			id_usuario_reg,
			id_usuario_ai,
			id_usuario_mod,
			fecha_mod
          	) values(
			'activo',
			v_parametros.descripcion,
			v_parametros._nombre_usuario_ai,
			now(),
			p_id_usuario,
			v_parametros._id_usuario_ai,
			null,
			null
							
			
			
			)RETURNING id_video into v_id_video;


			for v_id_sucursal in select regexp_split_to_table(v_parametros.id_sucursales,',') LOOP


				insert into cola.tsucursal_video(
					id_video,
					estado_reg,
					id_sucursal,
					id_usuario_ai,
					usuario_ai,
					fecha_reg,
					id_usuario_reg,
					id_usuario_mod,
					fecha_mod
				) values(
					v_id_video,
					'activo',
					v_id_sucursal::INTEGER,
					v_parametros._id_usuario_ai,
					v_parametros._nombre_usuario_ai,
					now(),
					p_id_usuario,
					null,
					null



				);
			END LOOP;

			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Video almacenado(a) con exito (id_video'||v_id_video||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_video',v_id_video::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'COLA_VIDE_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		favio.figueroa	
 	#FECHA:		08-08-2017 21:46:18
	***********************************/

	elsif(p_transaccion='COLA_VIDE_MOD')then

		begin
			--Sentencia de la modificacion
			update cola.tvideo set
			descripcion = v_parametros.descripcion,
			id_usuario_mod = p_id_usuario,
			fecha_mod = now(),
			id_usuario_ai = v_parametros._id_usuario_ai,
			usuario_ai = v_parametros._nombre_usuario_ai
			where id_video=v_parametros.id_video;


			DELETE FROM cola.tsucursal_video where id_video = v_parametros.id_video;

			for v_id_sucursal in select regexp_split_to_table(v_parametros.id_sucursales,',') LOOP

				--RAISE EXCEPTION '%',v_id_sucursal;
				insert into cola.tsucursal_video(
					id_video,
					estado_reg,
					id_sucursal,
					id_usuario_ai,
					usuario_ai,
					fecha_reg,
					id_usuario_reg,
					id_usuario_mod,
					fecha_mod
				) values(
					v_parametros.id_video,
					'activo',
					v_id_sucursal::INTEGER,
					v_parametros._id_usuario_ai,
					v_parametros._nombre_usuario_ai,
					now(),
					p_id_usuario,
					null,
					null



				);

			END LOOP;

               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Video modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_video',v_parametros.id_video::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'COLA_VIDE_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		favio.figueroa	
 	#FECHA:		08-08-2017 21:46:18
	***********************************/

	elsif(p_transaccion='COLA_VIDE_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from cola.tvideo
            where id_video=v_parametros.id_video;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Video eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_video',v_parametros.id_video::varchar);
              
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
ALTER FUNCTION "cola"."ft_video_ime"(integer, integer, character varying, character varying) OWNER TO postgres;
