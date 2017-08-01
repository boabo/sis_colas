CREATE OR REPLACE FUNCTION cola.f_resetear_fichas (
  p_id_sucursal_servicio integer
)
RETURNS varchar AS
$body$
DECLARE
	v_resp		            	varchar;
  	v_nombre_funcion        	text;
	    v_id_servicio 			integer;
    v_id_sucursal			integer;

BEGIN  
	v_nombre_funcion = 'cola.f_resetear_fichas';
    
    if (p_id_sucursal_servicio =0) THEN
    	
            
            insert into cola.tficha_historico (id_usuario_reg, id_usuario_mod, fecha_reg, fecha_mod, estado_reg, id_ficha, id_prioridad, id_sucursal, id_servicio, sigla, numero, peso)
            select fic.id_usuario_reg, fic.id_usuario_mod, fic.fecha_reg, fic.fecha_mod, fic.estado_reg, fic.id_ficha, fic.id_prioridad, fic.id_sucursal, fic.id_servicio, fic.sigla, fic.numero, fic.peso
            from cola.tficha fic;
            
            insert into cola.tficha_estado_historico (id_usuario_reg, id_usuario_mod, fecha_reg, fecha_mod, estado_reg, id_usuario_ai, usuario_ai, id_ficha_estado, id_ficha, estado, fecha_hora_inicio,
            											fecha_hora_fin, id_tipo_ventanilla, id_usuario_atencion, numero_ventanilla, id_servicio)
            select fe.id_usuario_reg, fe.id_usuario_mod, fe.fecha_reg, fe.fecha_mod, fe.estado_reg, fe.id_usuario_ai, fe.usuario_ai, fe.id_ficha_estado, fe.id_ficha, fe.estado, fe.fecha_hora_inicio,
            											fe.fecha_hora_fin, fe.id_tipo_ventanilla, fe.id_usuario_atencion, fe.numero_ventanilla, fe.id_servicio
            from cola.tficha_estado fe 
            inner join cola.tficha fic on fic.id_ficha=fe.id_ficha;
             
			TRUNCATE cola.tficha CASCADE;
		ELSE
        	select sucser.id_servicio, sucser.id_sucursal into v_id_servicio, v_id_sucursal
            from cola.tsucursal_servicio sucser
            where sucser.id_sucursal_servicio= p_id_sucursal_servicio;
            
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
             
			TRUNCATE cola.tficha CASCADE;
            end if;
	


    return 'exito';
    
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