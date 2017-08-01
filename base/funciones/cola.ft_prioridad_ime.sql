CREATE OR REPLACE FUNCTION cola.ft_prioridad_ime (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		Sistema de Colas
 FUNCION: 		cola.ft_prioridad_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'cola.tprioridad'
 AUTOR: 		Jose Mita
 FECHA:	        15-06-2016 22:48:33
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
	v_id_prioridad	integer;
			    
BEGIN

    v_nombre_funcion = 'cola.ft_prioridad_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'COLA_priori_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		Jose Mita	
 	#FECHA:		15-06-2016 22:48:33
	***********************************/

	if(p_transaccion='COLA_priori_INS')then
					
        begin
        	--Sentencia de la insercion
        	insert into cola.tprioridad(
			nombre,
            sigla,
			estado_reg,
			descripcion,
			estado,
			peso,
			id_usuario_reg,
			usuario_ai,
			fecha_reg,
			id_usuario_ai,
			fecha_mod,
			id_usuario_mod
          	) values(
			v_parametros.nombre,
            v_parametros.sigla,
			'activo',
			v_parametros.descripcion,
			v_parametros.estado,
			v_parametros.peso,
			p_id_usuario,
			v_parametros._nombre_usuario_ai,
			now(),
			v_parametros._id_usuario_ai,
			null,
			null
							
			
			
			)RETURNING id_prioridad into v_id_prioridad;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Prioridad almacenado(a) con exito (id_prioridad'||v_id_prioridad||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_prioridad',v_id_prioridad::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'COLA_priori_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		Jose Mita	
 	#FECHA:		15-06-2016 22:48:33
	***********************************/

	elsif(p_transaccion='COLA_priori_MOD')then

		begin
			--Sentencia de la modificacion
			update cola.tprioridad set
			nombre = v_parametros.nombre,
   			sigla = v_parametros.sigla,
			descripcion = v_parametros.descripcion,
			estado = v_parametros.estado,
			peso = v_parametros.peso,
			fecha_mod = now(),
			id_usuario_mod = p_id_usuario,
			id_usuario_ai = v_parametros._id_usuario_ai,
			usuario_ai = v_parametros._nombre_usuario_ai
			where id_prioridad=v_parametros.id_prioridad;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Prioridad modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_prioridad',v_parametros.id_prioridad::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'COLA_priori_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		Jose Mita	
 	#FECHA:		15-06-2016 22:48:33
	***********************************/

	elsif(p_transaccion='COLA_priori_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from cola.tprioridad
            where id_prioridad=v_parametros.id_prioridad;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Prioridad eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_prioridad',v_parametros.id_prioridad::varchar);
              
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