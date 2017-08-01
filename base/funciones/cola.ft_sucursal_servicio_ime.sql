CREATE OR REPLACE FUNCTION cola.ft_sucursal_servicio_ime (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		Sistema de Colas
 FUNCION: 		cola.ft_sucursal_servicio_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'cola.tsucursal_servicio'
 AUTOR: 		 (José Mita)
 FECHA:	        15-06-2016 23:17:07
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
	v_id_sucursal_servicio	integer;
    v_id_servicio 			integer;
    v_id_sucursal			integer;
    
			    
BEGIN

    v_nombre_funcion = 'cola.ft_sucursal_servicio_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'COLA_sersuc_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		José Mita	
 	#FECHA:		15-06-2016 23:17:07
	***********************************/

	if(p_transaccion='COLA_sersuc_INS')then
					
        begin
        	--Sentencia de la insercion
        	insert into cola.tsucursal_servicio(
			id_sucursal,
			id_servicio,
			id_tipo_ventanilla,
			estado_reg,
			estado,
			id_usuario_ai,
			id_usuario_reg,
			usuario_ai,
			fecha_reg,
			id_usuario_mod,
			fecha_mod,
      
            digito
          	) values(
			v_parametros.id_sucursal,
			v_parametros.id_servicio,
			v_parametros.id_tipo_ventanilla,
			'activo',
			v_parametros.estado,
			v_parametros._id_usuario_ai,
			p_id_usuario,
			v_parametros._nombre_usuario_ai,
			now(),
			null,
			null,
         
			v_parametros.digito				
			)RETURNING id_sucursal_servicio into v_id_sucursal_servicio;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Servicios Sucursal almacenado(a) con exito (id_sucursal_servicio'||v_id_sucursal_servicio||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_sucursal_servicio',v_id_sucursal_servicio::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'COLA_sersuc_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		José Mita	
 	#FECHA:		15-06-2016 23:17:07
	***********************************/

	elsif(p_transaccion='COLA_sersuc_MOD')then

		begin
			--Sentencia de la modificacion
			update cola.tsucursal_servicio set
			id_sucursal = v_parametros.id_sucursal,
			id_servicio = v_parametros.id_servicio,
			id_tipo_ventanilla = v_parametros.id_tipo_ventanilla,
			estado = v_parametros.estado,
			id_usuario_mod = p_id_usuario,
			fecha_mod = now(),
			id_usuario_ai = v_parametros._id_usuario_ai,
			usuario_ai = v_parametros._nombre_usuario_ai,
       
            digito = v_parametros.digito
			where id_sucursal_servicio=v_parametros.id_sucursal_servicio;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Servicios Sucursal modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_sucursal_servicio',v_parametros.id_sucursal_servicio::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'COLA_sersuc_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		José Mita	
 	#FECHA:		15-06-2016 23:17:07
	***********************************/

	elsif(p_transaccion='COLA_sersuc_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from cola.tsucursal_servicio
            where id_sucursal_servicio=v_parametros.id_sucursal_servicio;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Servicios Sucursal eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_sucursal_servicio',v_parametros.id_sucursal_servicio::varchar);
              
            --Devuelve la respuesta
            return v_resp;

		end;
        
    /*********************************    
 	#TRANSACCION:  'COLA_resfic_INS'
 	#DESCRIPCION:	Reseteo de fichas 
 	#AUTOR:		José Mita	
 	#FECHA:		12-07-2016 23:17:07
	***********************************/

	elsif(p_transaccion='COLA_resfic_INS')then

		begin
			--Sentencia de la duplicacion
            
         v_resp = cola.f_resetear_fichas(v_parametros.id_sucursal_servicio);
            /*
            select sucser.id_servicio, sucser.id_sucursal into v_id_servicio, v_id_sucursal
            from cola.tsucursal_servicio sucser
            where sucser.id_sucursal_servicio= v_parametros.id_sucursal_servicio;
            
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
             
			TRUNCATE cola.tficha CASCADE;*/
            
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Fichas Reseteadas'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_sucursal_servicio',v_parametros.id_sucursal_servicio::varchar);
              
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