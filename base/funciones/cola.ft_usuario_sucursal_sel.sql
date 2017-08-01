CREATE OR REPLACE FUNCTION cola.ft_usuario_sucursal_sel (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		Sistema de Colas
 FUNCION: 		cola.ft_usuario_sucursal_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'cola.tusuario_sucursal'
 AUTOR: 		 (admin)
 FECHA:	        22-07-2016 01:55:47
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
			    
BEGIN

	v_nombre_funcion = 'cola.ft_usuario_sucursal_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'COLA_USUSUC_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		admin	
 	#FECHA:		22-07-2016 01:55:47
	***********************************/

	if(p_transaccion='COLA_USUSUC_SEL')then
     				
    	begin
    		--Sentencia de la consulta
			v_consulta:='select
						ususuc.id_usuario_sucursal,
						ususuc.id_sucursal,
						ususuc.estado_reg,
						ususuc.id_tipo_ventanilla,
						ususuc.id_usuario,
						ususuc.id_usuario_ai,
						ususuc.id_usuario_reg,
						ususuc.fecha_reg,
						ususuc.usuario_ai,
						ususuc.id_usuario_mod,
						ususuc.fecha_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod,
                        suc.nombre as nombre_sucursal,
                        vusu.desc_persona,
                        tipven.nombre as nombre_ventanilla,
                        ususuc.numero_ventanilla,
                        array_to_string(ususuc.prioridades,'','')::varchar as ids_prioridad,
                        (select pxp.list(p.nombre) from cola.tprioridad p where p.id_prioridad =ANY(ususuc.prioridades))::varchar as nombres_prioridad,
                         array_to_string(ususuc.servicios,'','')::varchar as ids_servicio,
                        (select pxp.list(s.nombre) from cola.tservicio s where s.id_servicio =ANY(ususuc.servicios))::varchar as nombres_servicio,
                        suc.servidor_remoto
                        from cola.tusuario_sucursal ususuc
                        inner join cola.tsucursal suc on suc.id_sucursal = ususuc.id_sucursal
                        inner join segu.vusuario vusu on vusu.id_usuario = ususuc.id_usuario
                        inner join cola.ttipo_ventanilla tipven on tipven.id_tipo_ventanilla = ususuc.id_tipo_ventanilla
						inner join segu.tusuario usu1 on usu1.id_usuario = ususuc.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = ususuc.id_usuario_mod
				        where ';
			
			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;
						
		end;

	/*********************************    
 	#TRANSACCION:  'COLA_USUSUC_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		admin	
 	#FECHA:		22-07-2016 01:55:47
	***********************************/

	elsif(p_transaccion='COLA_USUSUC_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_usuario_sucursal)
					     from cola.tusuario_sucursal ususuc
                        inner join cola.tsucursal suc on suc.id_sucursal = ususuc.id_sucursal
                        inner join segu.vusuario vusu on vusu.id_usuario = ususuc.id_usuario
                        inner join cola.ttipo_ventanilla tipven on tipven.id_tipo_ventanilla = ususuc.id_tipo_ventanilla
						inner join segu.tusuario usu1 on usu1.id_usuario = ususuc.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = ususuc.id_usuario_mod
					    where ';
			
			--Definicion de la respuesta		    
			v_consulta:=v_consulta||v_parametros.filtro;

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