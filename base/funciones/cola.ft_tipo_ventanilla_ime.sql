CREATE OR REPLACE FUNCTION cola.ft_tipo_ventanilla_ime (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		Sistema de Colas
 FUNCION: 		cola.ft_tipo_ventanilla_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'cola.ttipo_ventanilla'
 AUTOR: 		 (Jose Mita)
 FECHA:	        15-06-2016 23:16:11
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
	v_id_tipo_ventanilla	integer;
			    
BEGIN

    v_nombre_funcion = 'cola.ft_tipo_ventanilla_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'COLA_tipven_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		Jose Mita	
 	#FECHA:		15-06-2016 23:16:11
	***********************************/

	if(p_transaccion='COLA_tipven_INS')then
					
        begin
        	--Sentencia de la insercion
        	insert into cola.ttipo_ventanilla(
			estado_reg,
			nombre,
			id_usuario_ai,
			usuario_ai,
			fecha_reg,
			id_usuario_reg,
			id_usuario_mod,
			fecha_mod
          	) values(
			'activo',
			v_parametros.nombre,
			v_parametros._id_usuario_ai,
			v_parametros._nombre_usuario_ai,
			now(),
			p_id_usuario,
			null,
			null
							
			
			
			)RETURNING id_tipo_ventanilla into v_id_tipo_ventanilla;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Tipos de Ventanillas almacenado(a) con exito (id_tipo_ventanilla'||v_id_tipo_ventanilla||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_tipo_ventanilla',v_id_tipo_ventanilla::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'COLA_tipven_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		Jose Mita	
 	#FECHA:		15-06-2016 23:16:11
	***********************************/

	elsif(p_transaccion='COLA_tipven_MOD')then

		begin
			--Sentencia de la modificacion
			update cola.ttipo_ventanilla set
			nombre = v_parametros.nombre,
			id_usuario_mod = p_id_usuario,
			fecha_mod = now(),
			id_usuario_ai = v_parametros._id_usuario_ai,
			usuario_ai = v_parametros._nombre_usuario_ai
			where id_tipo_ventanilla=v_parametros.id_tipo_ventanilla;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Tipos de Ventanillas modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_tipo_ventanilla',v_parametros.id_tipo_ventanilla::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'COLA_tipven_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		Jose Mita	
 	#FECHA:		15-06-2016 23:16:11
	***********************************/

	elsif(p_transaccion='COLA_tipven_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from cola.ttipo_ventanilla
            where id_tipo_ventanilla=v_parametros.id_tipo_ventanilla;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Tipos de Ventanillas eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_tipo_ventanilla',v_parametros.id_tipo_ventanilla::varchar);
              
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