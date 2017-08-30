CREATE OR REPLACE FUNCTION "cola"."ft_sucursal_mensaje_sel"(	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$
/**************************************************************************
 SISTEMA:		Sistema de Colas
 FUNCION: 		cola.ft_sucursal_mensaje_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'cola.tsucursal_mensaje'
 AUTOR: 		 (admin)
 FECHA:	        17-05-2017 13:39:41
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

	v_nombre_funcion = 'cola.ft_sucursal_mensaje_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'COLA_SUCMEN_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		admin	
 	#FECHA:		17-05-2017 13:39:41
	***********************************/

	if(p_transaccion='COLA_SUCMEN_SEL')then
     				
    	begin
    		--Sentencia de la consulta
			v_consulta:='select
  sucmen.id_sucursal_mensaje,
  sucmen.id_sucursal,
  sucmen.id_mensaje,
  sucmen.estado_reg,
  sucmen.id_usuario_ai,
  sucmen.id_usuario_reg,
  sucmen.fecha_reg,
  sucmen.usuario_ai,
  sucmen.fecha_mod,
  sucmen.id_usuario_mod,
  usu1.cuenta as usr_reg,
  usu2.cuenta as usr_mod,
  suc.nombre as desc_sucursal,
  men.titulo as desc_mensaje_titulo,
  men.mensaje
 from cola.tsucursal_mensaje sucmen
  inner join segu.tusuario usu1 on usu1.id_usuario = sucmen.id_usuario_reg
  left join segu.tusuario usu2 on usu2.id_usuario = sucmen.id_usuario_mod
  inner join cola.tsucursal suc on suc.id_sucursal = sucmen.id_sucursal
  inner join cola.tmensaje men on men.id_mensaje = sucmen.id_mensaje

				        where  ';
			
			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;
						
		end;

	/*********************************    
 	#TRANSACCION:  'COLA_SUCMEN_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		admin	
 	#FECHA:		17-05-2017 13:39:41
	***********************************/

	elsif(p_transaccion='COLA_SUCMEN_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_sucursal_mensaje)
					    from cola.tsucursal_mensaje sucmen
					    inner join segu.tusuario usu1 on usu1.id_usuario = sucmen.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = sucmen.id_usuario_mod
					     inner join cola.tsucursal suc on suc.id_sucursal = sucmen.id_sucursal
  inner join cola.tmensaje men on men.id_mensaje = sucmen.id_mensaje

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
ALTER FUNCTION "cola"."ft_sucursal_mensaje_sel"(integer, integer, character varying, character varying) OWNER TO postgres;
