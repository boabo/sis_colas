CREATE OR REPLACE FUNCTION cola.ft_sucursal_servicio_sel (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		Sistema de Colas
 FUNCION: 		cola.ft_sucursal_servicio_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'cola.tsucursal_servicio'
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

	v_consulta    		varchar;
	v_parametros  		record;
	v_nombre_funcion   	text;
	v_resp				varchar;
			    
BEGIN

	v_nombre_funcion = 'cola.ft_sucursal_servicio_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'COLA_sersuc_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		José Mita	
 	#FECHA:		15-06-2016 23:17:07
	***********************************/

	if(p_transaccion='COLA_sersuc_SEL')then
     				
    	begin
    		--Sentencia de la consulta
			v_consulta:='select
						sersuc.id_sucursal_servicio,
						sersuc.id_sucursal,
						sersuc.id_servicio,
						sersuc.id_tipo_ventanilla,
						sersuc.estado_reg,
						sersuc.estado,
						sersuc.id_usuario_ai,
						sersuc.id_usuario_reg,
						sersuc.usuario_ai,
						sersuc.fecha_reg,
						sersuc.id_usuario_mod,
						sersuc.fecha_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod,
                        array_to_string(sersuc.prioridades,'','')::varchar as ids_prioridad,
                        (select pxp.list(p.nombre) from cola.tprioridad p where p.id_prioridad =ANY(sersuc.prioridades))::varchar as nombres_prioridad,
                        sucur.nombre as nombre_sucur,
                        servi.nombre as nombre_servi,
                        tipven.nombre as nombre_tipo,
                        sersuc.digito,
                         ( select count(*) 
				       	from cola.tficha fic
				        where fic.id_sucursal= sersuc.id_sucursal and fic.id_servicio=sersuc.id_servicio )::integer as tickets
						from cola.tsucursal_servicio sersuc
                        inner join cola.tsucursal sucur on sucur.id_sucursal = sersuc.id_sucursal
                        inner join cola.tservicio servi on servi.id_servicio = sersuc.id_servicio
                        inner join cola.ttipo_ventanilla tipven on tipven.id_tipo_ventanilla = sersuc.id_tipo_ventanilla
						inner join segu.tusuario usu1 on usu1.id_usuario = sersuc.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = sersuc.id_usuario_mod
				        where  ';
			
			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;
						
		end;

	/*********************************    
 	#TRANSACCION:  'COLA_sersuc_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		José Mita	
 	#FECHA:		15-06-2016 23:17:07
	***********************************/

	elsif(p_transaccion='COLA_sersuc_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_sucursal_servicio)
					    
						from cola.tsucursal_servicio sersuc
                        inner join cola.tsucursal sucur on sucur.id_sucursal = sersuc.id_sucursal
                        inner join cola.tservicio servi on servi.id_servicio = sersuc.id_servicio
                        inner join cola.ttipo_ventanilla tipven on tipven.id_tipo_ventanilla = sersuc.id_tipo_ventanilla
						inner join segu.tusuario usu1 on usu1.id_usuario = sersuc.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = sersuc.id_usuario_mod
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