CREATE OR REPLACE FUNCTION cola.ft_usuario_sucursal_ime (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		Sistema de Colas
 FUNCION: 		cola.ft_usuario_sucursal_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'cola.tusuario_sucursal'
 AUTOR: 		 (José Mita)
 FECHA:	        22-07-2016 01:55:47
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
	v_id_usuario_sucursal	integer;
   	v_consulta        text;
			    
BEGIN

    v_nombre_funcion = 'cola.ft_usuario_sucursal_ime';
    v_parametros = pxp.f_get_record(p_tabla);
 
	/*********************************    
 	#TRANSACCION:  'COLA_USUSUC_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		José Mita	
 	#FECHA:		22-07-2016 01:55:47
	***********************************/

	if(p_transaccion='COLA_USUSUC_INS')then
					
        begin
        	
        	--Sentencia de la insercion
        	insert into cola.tusuario_sucursal(
			servicios,
			id_sucursal,
			prioridades,
			numero_ventanilla,
			estado_reg,
			id_tipo_ventanilla,
			id_usuario,
			id_usuario_reg,
			fecha_reg,
			id_usuario_mod,
			fecha_mod
          	) values(
            string_to_array (v_parametros.ids_servicio,',')::INTEGER[],
			v_parametros.id_sucursal,
			string_to_array (v_parametros.ids_prioridad,',')::INTEGER[],
			v_parametros.numero_ventanilla,
			'activo',
			v_parametros.id_tipo_ventanilla,
			v_parametros.id_usuario,
			p_id_usuario,
			now(),
			null,
			null
			)RETURNING id_usuario_sucursal into v_id_usuario_sucursal;
			
           
            
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Usuario Sucursal almacenado(a) con exito (id_usuario_sucursal'||v_id_usuario_sucursal||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_usuario_sucursal',v_id_usuario_sucursal::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'COLA_USUSUC_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		José Mita	
 	#FECHA:		22-07-2016 01:55:47
	***********************************/

	elsif(p_transaccion='COLA_USUSUC_MOD')then

		begin
			--Sentencia de la modificacion
			update cola.tusuario_sucursal set
			servicios = string_to_array (v_parametros.ids_servicio,',')::INTEGER[],
			id_sucursal = v_parametros.id_sucursal,
			prioridades = string_to_array (v_parametros.ids_prioridad,',')::INTEGER[],
			numero_ventanilla = v_parametros.numero_ventanilla,
			id_tipo_ventanilla = v_parametros.id_tipo_ventanilla,
			id_usuario = v_parametros.id_usuario,
			id_usuario_mod = p_id_usuario,
			fecha_mod = now(),
			id_usuario_ai = v_parametros._id_usuario_ai,
			usuario_ai = v_parametros._nombre_usuario_ai
			where id_usuario_sucursal=v_parametros.id_usuario_sucursal;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Usuario Sucursal modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_usuario_sucursal',v_parametros.id_usuario_sucursal::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'COLA_USUSUC_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		José Mita	
 	#FECHA:		22-07-2016 01:55:47
	***********************************/

	elsif(p_transaccion='COLA_USUSUC_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from cola.tusuario_sucursal
            where id_usuario_sucursal=v_parametros.id_usuario_sucursal;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Usuario Sucursal eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_usuario_sucursal',v_parametros.id_usuario_sucursal::varchar);
              
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