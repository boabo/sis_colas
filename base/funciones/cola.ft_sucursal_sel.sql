CREATE OR REPLACE FUNCTION cola.ft_sucursal_sel (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		Sistema de Colas
 FUNCION: 		cola.ft_sucursal_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'cola.tsucursal'
 AUTOR: 		 (Jose Mita)
 FECHA:	        15-06-2016 23:15:40
 COMENTARIOS:
***************************************************************************
 HISTORIAL DE MODIFICACIONES:

 DESCRIPCION:
 AUTOR:
 FECHA:
***************************************************************************/

DECLARE

	v_consulta    		varchar;
	v_parametros  		record;
	v_nombre_funcion   	text;
	v_resp				varchar;
    v_admin						varchar;

BEGIN

	v_nombre_funcion = 'cola.ft_sucursal_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************
 	#TRANSACCION:  'COLA_sucur_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		Jose Mita
 	#FECHA:		15-06-2016 23:15:40
	***********************************/

	if(p_transaccion='COLA_sucur_SEL')then

    	begin
        	/*Verificamos si es administrador*/
            SELECT 'administrador'::varchar as adminCounter into v_admin
            from segu.tusuario_rol usu
            where usu.id_usuario = p_id_usuario and usu.estado_reg = 'activo' and (usu.id_rol = 200 or usu.id_rol = 1);
        	/*********************************/

    if (v_admin = 'administrador') then

    		--Sentencia de la consulta
			v_consulta:='select
						sucur.id_sucursal,
						sucur.id_depto,
						sucur.estado_reg,
						sucur.codigo,
						sucur.mensaje_imp,
						sucur.nombre,
						sucur.id_usuario_reg,
						sucur.usuario_ai,
						sucur.fecha_reg,
						sucur.id_usuario_ai,
						sucur.fecha_mod,
						sucur.id_usuario_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod,
                        dep.nombre	as nombre_dep,
                        sucur.servidor_remoto
						from cola.tsucursal sucur
						inner join segu.tusuario usu1 on usu1.id_usuario = sucur.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = sucur.id_usuario_mod
                        inner join param.tdepto dep on dep.id_depto = sucur.id_depto
				         ';

			--Definicion de la respuesta
			--v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

	else
    	v_consulta:='select
						sucur.id_sucursal,
						sucur.id_depto,
						sucur.estado_reg,
						sucur.codigo,
						sucur.mensaje_imp,
						sucur.nombre,
						sucur.id_usuario_reg,
						sucur.usuario_ai,
						sucur.fecha_reg,
						sucur.id_usuario_ai,
						sucur.fecha_mod,
						sucur.id_usuario_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod,
                        dep.nombre	as nombre_dep,
                        sucur.servidor_remoto
						from cola.tsucursal sucur
						inner join segu.tusuario usu1 on usu1.id_usuario = sucur.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = sucur.id_usuario_mod
                        inner join param.tdepto dep on dep.id_depto = sucur.id_depto
				        where ';

			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;
	end if;

			--Devuelve la respuesta
			return v_consulta;

		end;

	/*********************************
 	#TRANSACCION:  'COLA_sucur_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		Jose Mita
 	#FECHA:		15-06-2016 23:15:40
	***********************************/

	elsif(p_transaccion='COLA_sucur_CONT')then

		begin
        	/*Verificamos si es administrador*/
            SELECT 'administrador'::varchar as adminCounter into v_admin
            from segu.tusuario_rol usu
            where usu.id_usuario = p_id_usuario and usu.estado_reg = 'activo' and (usu.id_rol = 200 or usu.id_rol = 1);
        	/*********************************/

    if (v_admin = 'administrador') then

			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_sucursal)
					    from cola.tsucursal sucur
					    inner join segu.tusuario usu1 on usu1.id_usuario = sucur.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = sucur.id_usuario_mod
					    ';

			--Definicion de la respuesta
			--v_consulta:=v_consulta||v_parametros.filtro;
    else
    		--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_sucursal)
					    from cola.tsucursal sucur
					    inner join segu.tusuario usu1 on usu1.id_usuario = sucur.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = sucur.id_usuario_mod
					    where ';

			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
	end if;
			--Devuelve la respuesta
			return v_consulta;

		end;

	else

		raise exception 'Transaccion inexistente';

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

ALTER FUNCTION cola.ft_sucursal_sel (p_administrador integer, p_id_usuario integer, p_tabla varchar, p_transaccion varchar)
  OWNER TO postgres;
