CREATE OR REPLACE FUNCTION "cola"."ft_video_sel"(	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$
/**************************************************************************
 SISTEMA:		Sistema de Colas
 FUNCION: 		cola.ft_video_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'cola.tvideo'
 AUTOR: 		 (favio.figueroa)
 FECHA:	        08-08-2017 21:46:18
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

	v_nombre_funcion = 'cola.ft_video_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'COLA_VIDE_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		favio.figueroa	
 	#FECHA:		08-08-2017 21:46:18
	***********************************/

	if(p_transaccion='COLA_VIDE_SEL')then
     				
    	begin
    		--Sentencia de la consulta
			v_consulta:='select
						vide.id_video,
						vide.estado_reg,
						vide.descripcion,
						vide.usuario_ai,
						vide.fecha_reg,
						vide.id_usuario_reg,
						vide.id_usuario_ai,
						vide.id_usuario_mod,
						vide.fecha_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod,
						(select pxp.list(suvideo.id_sucursal::VARCHAR) from cola.tsucursal_video suvideo where suvideo.id_video = vide.id_video) as id_sucursales
	
						from cola.tvideo vide
						inner join segu.tusuario usu1 on usu1.id_usuario = vide.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = vide.id_usuario_mod
				        where  ';
			
			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;
						
		end;

	/*********************************    
 	#TRANSACCION:  'COLA_VIDE_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		favio.figueroa	
 	#FECHA:		08-08-2017 21:46:18
	***********************************/

	elsif(p_transaccion='COLA_VIDE_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_video)
					    from cola.tvideo vide
					    inner join segu.tusuario usu1 on usu1.id_usuario = vide.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = vide.id_usuario_mod
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
$BODY$
LANGUAGE 'plpgsql' VOLATILE
COST 100;
ALTER FUNCTION "cola"."ft_video_sel"(integer, integer, character varying, character varying) OWNER TO postgres;
