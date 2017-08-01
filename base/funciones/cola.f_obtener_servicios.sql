CREATE OR REPLACE FUNCTION cola.f_obtener_servicios (
  p_id_sucursal integer,
  p_id_usuario integer
)
RETURNS integer [] AS
$body$
DECLARE
	v_resp		            	varchar;
  	v_nombre_funcion        	text;
	v_servicios					INTEGER[];

BEGIN  
	v_nombre_funcion = 'cola.f_obtener_servicios';

		select servicios into v_servicios from cola.tusuario_sucursal where id_sucursal = p_id_sucursal and id_usuario = p_id_usuario and estado_reg = 'activo';


    return v_servicios;
    
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