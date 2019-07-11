CREATE OR REPLACE FUNCTION cola.f_obtener_prioridades (
  p_id_sucursal integer,
  p_id_usuario integer
)
RETURNS integer [] AS
$body$
DECLARE
	v_resp		            	varchar;
  	v_nombre_funcion        	text;
	v_prioridades				INTEGER[];
    v_admin						varchar;

BEGIN
	v_nombre_funcion = 'cola.f_obtener_prioridades';

    	/*Verificamos si es administrador*/
        SELECT 'administrador'::varchar as adminCounter into v_admin
        from segu.tusuario_rol usu
        where usu.id_usuario = p_id_usuario and usu.estado_reg = 'activo' and (usu.id_rol = 200 or usu.id_rol = 1);
        /*********************************/

    	if (v_admin = 'administrador') then
        select ARRAY (SELECT DISTINCT UNNEST( ('{'||string_agg(rtrim(ltrim(prioridades::VARCHAR,'{'),'}'),',')||'}')::int[]))::INTEGER[] into v_prioridades
        from cola.tusuario_sucursal
        where id_sucursal = p_id_sucursal and estado_reg = 'activo';

        else

		select prioridades into v_prioridades from cola.tusuario_sucursal where id_sucursal = p_id_sucursal and id_usuario = p_id_usuario and estado_reg = 'activo';

        end if;

    return v_prioridades;

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

ALTER FUNCTION cola.f_obtener_prioridades (p_id_sucursal integer, p_id_usuario integer)
  OWNER TO postgres;
