CREATE OR REPLACE FUNCTION cola.ft_servicio_ime (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		Sistema de Colas
 FUNCION: 		cola.ft_servicio_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'cola.tservicio'
 AUTOR: 		 (José Mita)
 FECHA:	        15-06-2016 23:15:11
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
	v_id_servicio	integer;
			    
BEGIN

    v_nombre_funcion = 'cola.ft_servicio_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'COLA_servi_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		José Mita	
 	#FECHA:		15-06-2016 23:15:11
	***********************************/

	if(p_transaccion='COLA_servi_INS')then
					
        begin
        	--Sentencia de la insercion
        	insert into cola.tservicio(
			estado_reg,
			id_servicio_fk,
			nombre,
            sigla,
			descripcion,
			peso,
			fecha_reg,
			usuario_ai,
			id_usuario_reg,
			id_usuario_ai,
			fecha_mod,
			id_usuario_mod
          	) values(
			'activo',
			v_parametros.id_servicio_fk,
			v_parametros.nombre,
            v_parametros.sigla,
			v_parametros.descripcion,
			v_parametros.peso,
			now(),
			v_parametros._nombre_usuario_ai,
			p_id_usuario,
			v_parametros._id_usuario_ai,
			null,
			null
							
			
			
			)RETURNING id_servicio into v_id_servicio;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Servicios almacenado(a) con exito (id_servicio'||v_id_servicio||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_servicio',v_id_servicio::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'COLA_servi_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		José Mita	
 	#FECHA:		15-06-2016 23:15:11
	***********************************/

	elsif(p_transaccion='COLA_servi_MOD')then

		begin
			--Sentencia de la modificacion
			update cola.tservicio set
			id_servicio_fk = v_parametros.id_servicio_fk,
			nombre = v_parametros.nombre,
            sigla = v_parametros.sigla,
			descripcion = v_parametros.descripcion,
			peso = v_parametros.peso,
			fecha_mod = now(),
			id_usuario_mod = p_id_usuario,
			id_usuario_ai = v_parametros._id_usuario_ai,
			usuario_ai = v_parametros._nombre_usuario_ai
			where id_servicio=v_parametros.id_servicio;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Servicios modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_servicio',v_parametros.id_servicio::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'COLA_servi_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		José Mita	
 	#FECHA:		15-06-2016 23:15:11
	***********************************/

	elsif(p_transaccion='COLA_servi_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from cola.tservicio
            where id_servicio=v_parametros.id_servicio;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Servicios eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_servicio',v_parametros.id_servicio::varchar);
              
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