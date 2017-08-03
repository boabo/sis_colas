CREATE OR REPLACE FUNCTION cola.ft_servicio_sel (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		Sistema de Colas
 FUNCION: 		cola.ft_servicio_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'cola.tservicio'
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

	v_consulta    		varchar;
	v_parametros  		record;
	v_nombre_funcion   	text;
	v_resp				varchar;
    v_where varchar;
    v_join varchar;
	v_ids_servicios VARCHAR;
	v_ids_servicios_configurados VARCHAR;
    
	v_con1 VARCHAR;
	v_con2 VARCHAR;
    v_id_sucursal integer;

	v_array_servicios INTEGER[];

  v_consulta_servicio_aux varchar;
			    
BEGIN

	v_nombre_funcion = 'cola.ft_servicio_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'COLA_servi_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		José Mita	
 	#FECHA:		15-06-2016 23:15:11
	***********************************/

	if(p_transaccion='COLA_servi_SEL')then
     				
    	begin
    		--Sentencia de la consulta
			v_consulta:='select
						servi.id_servicio,
						servi.estado_reg,
						servi.id_servicio_fk,
						servi.nombre,
                        servi.sigla,
						servi.descripcion,
						servi.peso,
						servi.fecha_reg,
						servi.usuario_ai,
						servi.id_usuario_reg,
						servi.id_usuario_ai,
						servi.fecha_mod,
						servi.id_usuario_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod	
						from cola.tservicio servi
						inner join segu.tusuario usu1 on usu1.id_usuario = servi.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = servi.id_usuario_mod
				        where  ';
			
			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;
						
		end;
      /*********************************    
 	#TRANSACCION:  'COLA_servi_arb_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		José Mita	
 	#FECHA:		15-06-2016 23:15:11
	***********************************/

	elsif(p_transaccion='COLA_servi_arb_SEL')then
     				
    	begin
        	
        	  if(v_parametros.id_servicio_fk = '%') then
                v_where := ' servi.id_servicio_fk is NULL';
                 v_join:= 'LEFT';      
                      
              else
                v_where := ' servi.id_servicio_fk = '||v_parametros.id_servicio_fk;
                v_join := 'INNER';
              end if;

				IF (pxp.f_existe_parametro(p_tabla,'vista')) THEN


					select pxp.list(sepadre.id_servicio::VARCHAR)
					into v_ids_servicios
					from cola.tsucursal_servicio suse
					inner join cola.tservicio se on se.id_servicio = suse.id_servicio
					inner join cola.tservicio sepadre on sepadre.id_servicio = se.id_servicio_fk
					where suse.id_sucursal = v_parametros.id_sucursal;


					select pxp.list(suse.id_servicio::VARCHAR)
					into v_ids_servicios_configurados
						FROM cola.tsucursal_servicio suse where suse.id_sucursal = v_parametros.id_sucursal;

        IF(v_ids_servicios is  NULL OR v_ids_servicios = '') THEN

						v_con1 = '';

					IF(v_ids_servicios_configurados is  NULL OR v_ids_servicios_configurados = '') THEN
						v_con2 = '';
					ELSE
						v_con2 = ' servi.id_servicio in ('||v_ids_servicios_configurados||') ';

					END IF;


					ELSE
						v_con1 = '  servi.id_servicio in ('||v_ids_servicios||')  ';
						IF(v_ids_servicios_configurados is  NULL OR v_ids_servicios_configurados = '') THEN
							v_con2 = '';
						ELSE
							v_con2 = ' or servi.id_servicio in ('||v_ids_servicios_configurados||') ';

						END IF;
				END IF;



					v_where = v_where || ' and ( '||v_con1||' '||v_con2||' ) ';
					--RAISE EXCEPTION '%',v_ids_servicios;
				END IF;
        
    		--Sentencia de la consulta
			v_consulta:='select
						servi.id_servicio,
						servi.estado_reg,
						servi.id_servicio_fk,
						servi.nombre,
                        servi.sigla,
						servi.descripcion,
						servi.peso,
						servi.fecha_reg,
						servi.usuario_ai,
						servi.id_usuario_reg,
						servi.id_usuario_ai,
						servi.fecha_mod,
						servi.id_usuario_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod,
                        case
                          when (servi.id_servicio_fk is null )then
                               ''raiz''::varchar
                          ELSE
                              ''hijo''::varchar
                          END as tipo_nodo	
						from cola.tservicio servi
						inner join segu.tusuario usu1 on usu1.id_usuario = servi.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = servi.id_usuario_mod
				        where  '||v_where|| '  
                        ORDER BY servi.id_servicio';
                        
			--Devuelve la respuesta
			return v_consulta;
						
		end;
	/*********************************    
 	#TRANSACCION:  'COLA_servi_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		José Mita	
 	#FECHA:		15-06-2016 23:15:11
	***********************************/

	elsif(p_transaccion='COLA_servi_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_servicio)
					    from cola.tservicio servi
					    inner join segu.tusuario usu1 on usu1.id_usuario = servi.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = servi.id_usuario_mod
					    where ';
			
			--Definicion de la respuesta		    
			v_consulta:=v_consulta||v_parametros.filtro;

			--Devuelve la respuesta
			return v_consulta;

		end;
        
   
    /*********************************    
 	#TRANSACCION:  'COLA_servi_COM'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		José Mita	
 	#FECHA:		27-03-2017 21:15:11
	***********************************/

	elsif(p_transaccion='COLA_servi_COM')then

		begin
			RAISE EXCEPTION '%',p_id_usuario;
			--Sentencia de la consulta de conteo de registros
            select ususuc.id_sucursal into v_id_sucursal
				from cola.tusuario_sucursal ususuc
				where ususuc.id_usuario=p_id_usuario;
            
			v_consulta:='select serv.id_servicio, ser.descripcion as des_padre, serv.descripcion as des_hijo
                          from cola.tservicio serv
                          inner join cola.tservicio ser on serv.id_servicio_fk=ser.id_servicio
                          where serv.id_servicio_fk in (
                          select servic.id_servicio
                          from cola.tservicio servic
                          inner join cola.tsucursal_servicio sucser on servic.id_servicio=sucser.id_servicio
                          where sucser.id_sucursal= '||v_id_sucursal||' ) and ';
			
			--Definicion de la respuesta		    
			v_consulta:=v_consulta||v_parametros.filtro;

			--Devuelve la respuesta
			return v_consulta;

		end;


	/*********************************
 	#TRANSACCION:  'COLA_SERULTI_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		Favio Figueroa
 	#FECHA:		15-06-2016 23:15:11
	***********************************/

	elsif(p_transaccion='COLA_SERULTI_SEL')then

    	begin
    		--Sentencia de la consulta


				select pxp.list(servicio_fk.id_servicio_fk::VARCHAR) into v_ids_servicios from cola.tservicio servicio_fk
				WHERE servicio_fk.id_servicio_fk is NOT NULL;

        IF v_ids_servicios is NULL THEN

          v_consulta_servicio_aux = '';
          ELSE
          v_consulta_servicio_aux = ' servi.id_servicio not in('||v_ids_servicios||') and ';
        END IF;

			v_consulta:='select
						servi.id_servicio,
						servi.estado_reg,
						servi.id_servicio_fk,
						servi.nombre,
                        servi.sigla,
						servi.descripcion,
						servi.peso,
						servi.fecha_reg,
						servi.usuario_ai,
						servi.id_usuario_reg,
						servi.id_usuario_ai,
						servi.fecha_mod,
						servi.id_usuario_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod
						from cola.tservicio servi
						inner join segu.tusuario usu1 on usu1.id_usuario = servi.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = servi.id_usuario_mod
				        where '||v_consulta_servicio_aux||' ';

			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;

		end;


		/*********************************
 	#TRANSACCION:  'COLA_SERULTI_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		Favio Figueroa
 	#FECHA:		15-06-2016 23:15:11
	***********************************/

	elsif(p_transaccion='COLA_SERULTI_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros

			select pxp.list(servicio_fk.id_servicio_fk::VARCHAR) into v_ids_servicios from cola.tservicio servicio_fk
			WHERE servicio_fk.id_servicio_fk is NOT NULL;

      IF v_ids_servicios is NULL THEN

        v_consulta_servicio_aux = '';
      ELSE
        v_consulta_servicio_aux = ' servi.id_servicio not in('||v_ids_servicios||') and ';
      END IF;

			v_consulta:='select count(id_servicio)
					    from cola.tservicio servi
					    inner join segu.tusuario usu1 on usu1.id_usuario = servi.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = servi.id_usuario_mod
					    where '||v_consulta_servicio_aux||' ';

			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;

			--Devuelve la respuesta
			return v_consulta;

		end;



	/*********************************
 	#TRANSACCION:  'COLA_SERUSU_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		Favio Figueroa
 	#FECHA:		15-06-2016 23:15:11
	***********************************/

	elsif(p_transaccion='COLA_SERUSU_SEL')then

    	begin
    		--Sentencia de la consulta

				select servicios INTO v_array_servicios from cola.tusuario_sucursal
				where id_usuario = p_id_usuario and id_sucursal = v_parametros.id_sucursal;

				--RAISE EXCEPTION '%',v_array_servicios;

			v_consulta:='select serv.id_servicio, serv.descripcion
				from cola.tservicio serv
				where id_servicio in ('||array_to_string(v_array_servicios, ',', '*')	||') and  ';

			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;

		end;


		/*********************************
 	#TRANSACCION:  'COLA_SERULTI_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		Favio Figueroa
 	#FECHA:		15-06-2016 23:15:11
	***********************************/

	elsif(p_transaccion='COLA_SERUSU_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros

			select servicios INTO v_array_servicios from cola.tusuario_sucursal
			where id_usuario = p_id_usuario and id_sucursal = v_parametros.id_sucursal;


			v_consulta:='select count(id_servicio)
									from cola.tservicio serv
									where serv.id_servicio in ('||array_to_string(v_array_servicios, ',', '*')	||') and  ';

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