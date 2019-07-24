CREATE OR REPLACE FUNCTION cola.ft_ficha_sel (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		Sistema de Colas
 FUNCION: 		cola.ft_ficha_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'cola.tficha'
 AUTOR: 		 (Jose Mita)
 FECHA:	        21-06-2016 10:11:23
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
    v_servicios			INTEGER[];
    v_prioridades		integer[];
    v_num_ventanilla	varchar;
    v_id_ficha			integer;
    v_minutos			integer;
    v_tipo_ventanilla	integer;
    v_estado    		varchar;
    v_id_atencion		integer;
    v_admin				varchar;
    v_minutos_espera	varchar;

BEGIN

	v_nombre_funcion = 'cola.ft_ficha_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************
 	#TRANSACCION:  'COLA_ficha_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		Jose Mita
 	#FECHA:		21-06-2016 10:11:23
	***********************************/

	if(p_transaccion='COLA_ficha_SEL')then

    	begin

        IF (v_parametros.estado_ficha = 'espera' or v_parametros.estado_ficha = 'en_atencion' )  then
        	v_minutos_espera = '(((SELECT EXTRACT(EPOCH FROM (now()-ficha.fecha_reg))/60)::integer)::varchar || '' min'')::varchar AS minuto_espera,';
        else
        	v_minutos_espera = '(((SELECT EXTRACT(EPOCH FROM (estact.fecha_hora_fin - ficha.fecha_reg))/60)::integer)::varchar || '' min'')::varchar AS minuto_espera,';

            /* '((((SELECT EXTRACT(EPOCH FROM (estact.fecha_hora_fin - ficha.fecha_reg))/60/60)::integer)::varchar) || ''h:'' || (case
                        				 when ((SELECT EXTRACT(MINUTE FROM ficha.fecha_reg::TIMESTAMP)) - (SELECT EXTRACT(MINUTE FROM estact.fecha_hora_fin::TIMESTAMP)))<0 THEN
                                         	(((SELECT EXTRACT(MINUTE FROM ficha.fecha_reg::TIMESTAMP)) - (SELECT EXTRACT(MINUTE FROM estact.fecha_hora_fin::TIMESTAMP)))*-1)::varchar
                                         else
                                         	((SELECT EXTRACT(MINUTE FROM ficha.fecha_reg::TIMESTAMP)) - (SELECT EXTRACT(MINUTE FROM estact.fecha_hora_fin::TIMESTAMP)))::varchar
                                         END) || ''m'')::varchar as minuto_espera,';*/

        end if;

        SELECT 'administrador'::varchar as adminCounter into v_admin
            from segu.tusuario_rol usu
            where usu.id_usuario = p_id_usuario and usu.estado_reg = 'activo' and (usu.id_rol = 200 or usu.id_rol = 1);

            if (v_admin = 'administrador') then

--raise exception 'ficha %', v_parametros.filtro;
    		--Sentencia de la consulta
			v_consulta:='select
						ficha.id_ficha,
						ficha.numero,
						ficha.estado_reg,
						ficha.id_sucursal,
						ficha.sigla,
						ficha.id_servicio,
						ficha.id_prioridad,
						ficha.peso,
						ficha.id_usuario_reg,
						ficha.usuario_ai,
						ficha.fecha_reg,
						ficha.id_usuario_ai,
						ficha.id_usuario_mod,
						ficha.fecha_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod,
                        sucur.nombre as nombre_sucur,
                        servi.nombre as nombre_servi,
                        priori.nombre as nombre_priori,
                         estact.estado as estado_ficha,

                        to_char(ficha.fecha_reg,''HH24:MI:SS'')::varchar as fecha_hora_inicio,
                       ((EXTRACT(EPOCH FROM (now() - ficha.fecha_reg))/60) * ficha.peso)::integer AS cola_atencion,
                       usu1.desc_persona,

                       to_char(ficha.ultima_llamada,''HH24:MI:SS'')::varchar as ultima_llamada,
                       estact.numero_ventanilla,

                       '|| v_minutos_espera ||'

                         to_char( estact.fecha_hora_fin,''HH24:MI:SS'')::varchar as fecha_hora_fin,
                        -- ''''::varchar,
                         usu3.desc_persona as derivado, priori.peso
						from cola.tficha ficha
                        inner join cola.tsucursal sucur on sucur.id_sucursal = ficha.id_sucursal
                        inner join cola.tservicio servi on servi.id_servicio = ficha.id_servicio
                        inner join cola.tprioridad priori on priori.id_prioridad = ficha.id_prioridad
                         --inner join cola.tficha_estado ficest on ficest.id_ficha = ficha.id_ficha --and ficest.estado  in (''espera'')
                         inner join cola.tficha_estado estact on estact.id_ficha = ficha.id_ficha and estact.estado_reg  = ''activo''

                            /*Quitando esto IRVA*/
                            --and estact.estado  = ''espera'' and (estact.id_usuario_atencion is null or estact.id_usuario_atencion = ' || p_id_usuario ||')
                            /**/
                            /*Aumentando Esto*/
                            --and (estact.id_usuario_atencion is null or estact.id_usuario_atencion = ' || p_id_usuario ||')
                        	/**/


                        --left join cola.tficha_estado ficest1 on ficest1.id_ficha = ficha.id_ficha and ficest1.estado in (''finalizado'',''no_show'')
						inner join segu.vusuario usu1 on usu1.id_usuario = estact.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = ficha.id_usuario_mod
                        left join segu.vusuario usu3 on usu3.id_usuario = estact.id_usuario_atencion
				        where  ';

                        raise notice '%', v_consulta;
                        --Definicion de la respuesta
                        v_consulta:=v_consulta||v_parametros.filtro;
                        v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;
                        --v_consulta:=v_consulta||' order by cola_atencion desc , ficha.fecha_reg ASC limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

                        --Devuelve la respuesta
                        return v_consulta;
            else
            	v_consulta:='select
						ficha.id_ficha,
						ficha.numero,
						ficha.estado_reg,
						ficha.id_sucursal,
						ficha.sigla,
						ficha.id_servicio,
						ficha.id_prioridad,
						ficha.peso,
						ficha.id_usuario_reg,
						ficha.usuario_ai,
						ficha.fecha_reg,
						ficha.id_usuario_ai,
						ficha.id_usuario_mod,
						ficha.fecha_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod,
                        sucur.nombre as nombre_sucur,
                        servi.nombre as nombre_servi,
                        priori.nombre as nombre_priori,
                         estact.estado as estado_ficha,

                        to_char(estact.fecha_hora_inicio,''HH24:MI:SS'')::varchar as fecha_hora_inicio,
                       ((EXTRACT(EPOCH FROM (now() - ficha.fecha_reg))/60) * ficha.peso)::integer AS cola_atencion,
                       usu1.desc_persona,

                       to_char(ficha.ultima_llamada,''HH24:MI:SS'')::varchar as ultima_llamada,
                       estact.numero_ventanilla,

                       '|| v_minutos_espera ||'

                         to_char( estact.fecha_hora_fin,''HH24:MI:SS'')::varchar as fecha_hora_fin,
                         --''''::varchar,
                         usu3.desc_persona as derivado, priori.peso
						from cola.tficha ficha
                        inner join cola.tsucursal sucur on sucur.id_sucursal = ficha.id_sucursal
                        inner join cola.tservicio servi on servi.id_servicio = ficha.id_servicio
                        inner join cola.tprioridad priori on priori.id_prioridad = ficha.id_prioridad
                       -- inner join cola.tficha_estado ficest on ficest.id_ficha = ficha.id_ficha and ficest.estado  in (''espera'')
                         inner join cola.tficha_estado estact on estact.id_ficha = ficha.id_ficha and estact.estado_reg  = ''activo''

                            /*Quitando esto IRVA*/
                            --and estact.estado  = ''espera'' and (estact.id_usuario_atencion is null or estact.id_usuario_atencion = ' || p_id_usuario ||')
                            /**/
                            /*Aumentando Esto*/
                            and (estact.id_usuario_atencion is null or estact.id_usuario_atencion = ' || p_id_usuario ||')
                        	/**/


                        --left join cola.tficha_estado ficest1 on ficest1.id_ficha = ficha.id_ficha and ficest1.estado in (''finalizado'',''no_show'')
						inner join segu.vusuario usu1 on usu1.id_usuario = estact.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = ficha.id_usuario_mod
                        left join segu.vusuario usu3 on usu3.id_usuario = estact.id_usuario_atencion
				        where  ';

                        raise notice '%', v_consulta;
                        --Definicion de la respuesta
                        v_consulta:=v_consulta||v_parametros.filtro;
                        --v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;
                        v_consulta:=v_consulta||' order by cola_atencion desc , ficha.fecha_reg ASC limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

                        --Devuelve la respuesta
                        return v_consulta;
                end if;



		end;

	/*********************************
 	#TRANSACCION:  'COLA_ficha_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		Jose Mita
 	#FECHA:		21-06-2016 10:11:23
	***********************************/

	elsif(p_transaccion='COLA_ficha_CONT')then

		begin

        	SELECT 'administrador'::varchar as adminCounter into v_admin
            from segu.tusuario_rol usu
            where usu.id_usuario = p_id_usuario and usu.estado_reg = 'activo' and (usu.id_rol = 200 or usu.id_rol = 1);

            if (v_admin = 'administrador') then

			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(ficha.id_ficha)
					    from cola.tficha ficha
                        inner join cola.tsucursal sucur on sucur.id_sucursal = ficha.id_sucursal
                        inner join cola.tservicio servi on servi.id_servicio = ficha.id_servicio
                        inner join cola.tprioridad priori on priori.id_prioridad = ficha.id_prioridad
                        --inner join cola.tficha_estado ficest on ficest.id_ficha = ficha.id_ficha and ficest.estado  in (''espera'')
                         inner join cola.tficha_estado estact on estact.id_ficha = ficha.id_ficha and estact.estado_reg  = ''activo''

                            /*Quitando esto IRVA*/
                            --and estact.estado  = ''espera'' and (estact.id_usuario_atencion is null or estact.id_usuario_atencion = ' || p_id_usuario ||')
                            /**/
                            /*Aumentando Esto*/
                            --and (estact.id_usuario_atencion is null or estact.id_usuario_atencion = ' || p_id_usuario ||')
                        	/**/

                        --left join cola.tficha_estado ficest1 on ficest1.id_ficha = ficha.id_ficha and ficest1.estado in (''finalizado'',''no_show'')
						inner join segu.vusuario usu1 on usu1.id_usuario = ficha.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = ficha.id_usuario_mod
                        left join segu.vusuario usu3 on usu3.id_usuario = estact.id_usuario_atencion
					    where ';


            else
            v_consulta:='select count(ficha.id_ficha)
					    from cola.tficha ficha
                        inner join cola.tsucursal sucur on sucur.id_sucursal = ficha.id_sucursal
                        inner join cola.tservicio servi on servi.id_servicio = ficha.id_servicio
                        inner join cola.tprioridad priori on priori.id_prioridad = ficha.id_prioridad
                        --inner join cola.tficha_estado ficest on ficest.id_ficha = ficha.id_ficha and ficest.estado  in (''espera'')
                         inner join cola.tficha_estado estact on estact.id_ficha = ficha.id_ficha and estact.estado_reg  = ''activo''

                            /*Quitando esto IRVA*/
                            --and estact.estado  = ''espera'' and (estact.id_usuario_atencion is null or estact.id_usuario_atencion = ' || p_id_usuario ||')
                            /**/
                            /*Aumentando Esto*/
                            and (estact.id_usuario_atencion is null or estact.id_usuario_atencion = ' || p_id_usuario ||')
                        	/**/

                        --left join cola.tficha_estado ficest1 on ficest1.id_ficha = ficha.id_ficha and ficest1.estado in (''finalizado'',''no_show'')
						inner join segu.vusuario usu1 on usu1.id_usuario = ficha.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = ficha.id_usuario_mod
                        left join segu.vusuario usu3 on usu3.id_usuario = estact.id_usuario_atencion
					    where ';


            end if;

			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;

			--Devuelve la respuesta
			return v_consulta;

		end;

    /*********************************
 	#TRANSACCION:  'COLA_fichaTotal_SEL'
 	#DESCRIPCION:	Listado de fichas totales
 	#AUTOR:		Jose Mita
 	#FECHA:		31-05-2017 10:11:23
	***********************************/

	elsif(p_transaccion='COLA_fichaTotal_SEL')then

		begin
            --raise exception 'LLEGA AQUI %',v_parametros.id_sucursal;
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select

            			  count(fe.id_ficha)::integer as cantidad,
                          ''Espera''::varchar as nombre
                          from cola.tficha fi
                          inner join cola.tficha_estado fe on fi.id_ficha=fe.id_ficha
                          where fe.estado=''espera'' and fe.estado_reg=''activo'' and fi.id_sucursal = '||v_parametros.id_sucursal||'



                          UNION

                          select

                          count(fe2.id_ficha)::integer as cantidad,
                          ''No se Presento''::varchar as nombre
                          from cola.tficha fi
                          inner join cola.tficha_estado fe2 on fi.id_ficha=fe2.id_ficha
                          where fe2.estado=''no_show'' and fe2.estado_reg=''activo'' and fi.id_sucursal = '||v_parametros.id_sucursal||' and fe2.id_usuario_atencion='||p_id_usuario||'



                          UNION

                          select

                          count(fe3.id_ficha)::integer as cantidad,
                          ''Atendidas''::varchar as nombre
                          from cola.tficha fi
                          inner join cola.tficha_estado fe3 on fi.id_ficha=fe3.id_ficha
                          where fe3.estado=''finalizado'' and fe3.estado_reg=''activo'' and fi.id_sucursal = '||v_parametros.id_sucursal||' and fe3.id_usuario_atencion= '||p_id_usuario||'
                      		';

			--Definicion de la respuesta
			--v_consulta:=v_consulta||v_parametros.filtro;
			--v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;
			v_consulta:=v_consulta||'order by nombre';
			--Devuelve la respuesta
			return v_consulta;

		end;

    	/*********************************
 	#TRANSACCION:  'COLA_ficha_INS'
 	#DESCRIPCION:	LLamr siguiente ficha
 	#AUTOR:		Jose Mita
 	#FECHA:		27-06-2016 10:11:23
	***********************************/

	elsif(p_transaccion='COLA_llamsig_INS')then

		begin
			--Sentencia de la consulta de conteo de registros
            select usc.servicios, usc.prioridades, usc.numero_ventanilla, usc.id_tipo_ventanilla
            into v_servicios, v_prioridades, v_num_ventanilla, v_tipo_ventanilla
            from cola.tusuario_sucursal usc
            where usc.id_usuario = p_id_usuario AND usc.id_sucursal = v_parametros.id_sucursal;

      --BUSCA SI LE ALGUIEN DERIVO A UN USUARIO DETERMINADO
            select ficest.id_ficha, ficest.estado into v_id_ficha, v_estado
			from cola.tficha_estado ficest
			where ficest.estado in ('espera') and ficest.estado_reg='activo' and ficest.id_usuario_atencion=p_id_usuario ORDER BY ficest.id_ficha ASC ;

      --
            if (v_id_ficha is NULL)then
            --BUSCA SI YA ESTABA ATENDIENDO ALGO ESTE USUARIO
            	select ficest.id_ficha, ficest.estado into v_id_ficha, v_estado
				from cola.tficha_estado ficest
				where ficest.estado in ('llamado','en_atencion') and ficest.estado_reg='activo' and ficest.id_usuario_atencion=p_id_usuario;

            end if;

             if (v_id_ficha is NULL) THEN

               --FICHA NUEVA PARA LLAMAR

              --RAISE EXCEPTION '%','ficha es null';
                select fic.id_ficha,

               ((EXTRACT(EPOCH FROM (now() - fic.fecha_reg))/60) * fic.peso)::integer as peso_total into v_id_ficha, v_minutos
                from cola.tficha fic
                inner join cola.tficha_estado ficest on ficest.id_ficha = fic.id_ficha and ficest.estado_reg='activo' and  ficest.estado  in ('espera')
                where fic.id_prioridad=ANY(v_prioridades) and fic.id_servicio=ANY(v_servicios) and fic.id_sucursal=v_parametros.id_sucursal and ficest.id_usuario_atencion is null
                order by peso_total DESC, fic.fecha_reg ASC limit 1 offset 0;

                if (v_id_ficha is NULL) THEN
                    raise exception 'No hay fichas en la cola';
                end if;

                update cola.tficha_estado set
                fecha_mod = now(),
                fecha_hora_fin = now()
                where id_ficha=v_id_ficha and estado_reg='activo';

                update cola.tficha_estado set
                estado_reg = 'inactivo'
                where id_ficha=v_id_ficha;

                update cola.tficha set
                ultima_llamada = now()
                where id_ficha=v_id_ficha;

                insert into cola.tficha_estado(
                id_ficha,

                estado,
                fecha_hora_inicio,

                id_usuario_reg,
    			id_tipo_ventanilla,
                numero_ventanilla,
                id_usuario_atencion
                ) values(
                v_id_ficha,

                'llamado',
                now(),

                p_id_usuario,
    			v_tipo_ventanilla,
                v_num_ventanilla,
                p_id_usuario
                );

                v_consulta:='select
                            ficha.id_ficha,
                            ficha.id_servicio,
                            ficha.sigla,
                            servi.nombre as nombre_servi,
                            priori.nombre as nombre_priori,
                            to_char(estini.fecha_hora_inicio,''HH24:MI:SS'')::varchar as fecha_hora_inicio,
                            (EXTRACT(EPOCH FROM (now() - estini.fecha_hora_inicio)::interval)/60)::integer AS minutos,
                            ficest.estado as estado_ficha,
                            ficha.id_sucursal,
                            SUBSTRING(ficest.numero_ventanilla,2,3)::INTEGER as numero_ventanilla,
                            SUBSTRING(ficest.numero_ventanilla,1,1)::varchar as letra_ventanilla,
                            tive.nombre as desc_tipo_ventanilla

                            from cola.tficha ficha
                            inner join cola.tsucursal sucur on sucur.id_sucursal = ficha.id_sucursal
                            inner join cola.tservicio servi on servi.id_servicio = ficha.id_servicio
                            inner join cola.tprioridad priori on priori.id_prioridad = ficha.id_prioridad
                            inner join cola.tficha_estado ficest on ficest.id_ficha = ficha.id_ficha and ficest.estado_reg=''activo''
                            inner join cola.tficha_estado estini on estini.id_ficha = ficha.id_ficha and estini.estado=''espera''
                            inner join segu.tusuario usu1 on usu1.id_usuario = ficha.id_usuario_reg
                            left join segu.tusuario usu2 on usu2.id_usuario = ficha.id_usuario_mod

                            left join cola.ttipo_ventanilla tive on tive.id_tipo_ventanilla = ficest.id_tipo_ventanilla


                            where ficha.id_ficha= '|| v_id_ficha||' ;';


            else

              --RAISE EXCEPTION '%','ficha NOes null';
            	select  ficest.id_usuario_atencion into v_id_atencion
                from cola.tficha_estado ficest
                where ficest.id_ficha = v_id_ficha and ficest.estado = 'espera' ORDER BY ficest.id_ficha_estado desc LIMIT 1;



            	if (v_estado='espera' and v_id_atencion=p_id_usuario) then
                --raise exception '%','ficha: '||v_id_ficha||' , usuario:'||v_id_atencion;
                update cola.tficha_estado set
                fecha_mod = now(),
                fecha_hora_fin = now()
                where id_ficha=v_id_ficha and estado_reg='activo';

                update cola.tficha_estado set
                estado_reg = 'inactivo'
                where id_ficha=v_id_ficha;

                update cola.tficha set
                ultima_llamada = now()
                where id_ficha=v_id_ficha;

                insert into cola.tficha_estado(
                id_ficha,
                estado,
                fecha_hora_inicio,
                id_usuario_reg,
    			id_tipo_ventanilla,
                numero_ventanilla,
                id_usuario_atencion
                ) values(
                v_id_ficha,
                'llamado',
                now(),
                p_id_usuario,
    			v_tipo_ventanilla,
                v_num_ventanilla,
                p_id_usuario
                );
                end if;

                	 v_consulta:='select
                            ficha.id_ficha,
                            ficha.id_servicio,
                            ficha.sigla,
                            servi.nombre as nombre_servi,
                            priori.nombre as nombre_priori,
                            to_char(estini.fecha_hora_inicio,''HH24:MI:SS'')::varchar as fecha_hora_inicio,
                             (EXTRACT(EPOCH FROM (now() - estini.fecha_hora_inicio)::interval)/60)::integer AS minutos,
                            ficest.estado as estado_ficha,
                            ficha.id_sucursal,
                             SUBSTRING(ficest.numero_ventanilla,2,3)::INTEGER as numero_ventanilla,
                            SUBSTRING(ficest.numero_ventanilla,1,1)::varchar as letra_ventanilla,
                            tive.nombre as desc_tipo_ventanilla
                            from cola.tficha ficha
                            inner join cola.tsucursal sucur on sucur.id_sucursal = ficha.id_sucursal
                            inner join cola.tservicio servi on servi.id_servicio = ficha.id_servicio
                            inner join cola.tprioridad priori on priori.id_prioridad = ficha.id_prioridad
                            inner join cola.tficha_estado ficest on ficest.id_ficha = ficha.id_ficha and ficest.estado_reg=''activo''
                            inner join cola.tficha_estado estini on estini.id_ficha = ficha.id_ficha and estini.estado=''espera''
                            inner join segu.tusuario usu1 on usu1.id_usuario = ficha.id_usuario_reg
                            left join segu.tusuario usu2 on usu2.id_usuario = ficha.id_usuario_mod

                            left join cola.ttipo_ventanilla tive on tive.id_tipo_ventanilla = ficest.id_tipo_ventanilla


                            where ficha.id_ficha= '|| v_id_ficha||' ;';
                end if;

			--Devuelve la respuesta
           -- raise notice '%', v_consulta;
			return v_consulta;

		end;
    /*********************************
 	#TRANSACCION:  'COLA_llapan_SEL'
 	#DESCRIPCION:	Funcio que devuelve la lista para la pantalla
 	#AUTOR:		Jose Mita
 	#FECHA:		28-06-2016 10:11:23
	***********************************/

	elsif(p_transaccion='COLA_llapan_SEL')then

		begin




			--Sentencia de la consulta de conteo de registros
			v_consulta:='select ficha.sigla,
            					ficha.ultima_llamada,
                                SUBSTRING(ficest.numero_ventanilla,2,3)::INTEGER as numero_ventanilla,
                                now()::timestamp as fecha_respuesta,
                                 SUBSTRING(ficest.numero_ventanilla,1,1)::varchar as letra_ventanilla,
                                ficha.numero as prioridad,
                                tive.nombre as desc_tipo_ventanilla
							from cola.tficha ficha
							inner join cola.tficha_estado ficest on ficest.id_ficha = ficha.id_ficha
							left join cola.ttipo_ventanilla tive on tive.id_tipo_ventanilla = ficest.id_tipo_ventanilla
					    where  ficest.estado_reg=''activo'' and  ';

			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;

                     raise notice '%',v_consulta;

			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;
			--Devuelve la respuesta
  raise notice '%',v_consulta;
      --RAISE EXCEPTION '%',v_consulta;
			return v_consulta;

		end;

    /*********************************
 	#TRANSACCION:  'COLA_FICSTATUS_SEL'
 	#DESCRIPCION:	Funcio que devuelve  para el reporte de status
 	#AUTOR:		Favio Figueroa
 	#FECHA:		29-07-2017 10:11:23
	***********************************/

	elsif(p_transaccion='COLA_FICSTATUS_SEL')then

		begin

			--Sentencia de la consulta de conteo de registros
			v_consulta:='with historico as (

      select fe.estado
      from cola.vficha_estado fe
        inner join cola.vficha f  on f.id_ficha = fe.id_ficha
      where f.fecha_reg::date between '''||v_parametros.desde||'''::date and '''||v_parametros.hasta||'''::date and f.id_sucursal = '||v_parametros.id_sucursal||'
      and fe.estado_reg = ''activo''

    )
    select count(1)::numeric as cantidad_estado,round(((count(1) / (sum(count(1)) over ()))*100),2)::numeric as porcentaje_estado,estado::varchar
    from historico h
    group by h.estado ';

			--Definicion de la respuesta

			--Devuelve la respuesta
      --RAISE EXCEPTION '%',v_consulta;
			return v_consulta;

		end;


    /*********************************
 	#TRANSACCION:  'COLA_FICSER_SEL'
 	#DESCRIPCION:	Funcio que devuelve  para el reporte de SERVICIO
 	#AUTOR:		Favio Figueroa
 	#FECHA:		29-07-2017 10:11:23
	***********************************/

	elsif(p_transaccion='COLA_FICSER_SEL')then

		begin

			--Sentencia de la consulta de conteo de registros
			v_consulta:='with historico as (



                  select s.nombre as servicio
                  from cola.vficha_estado fe
                  --inner join cola.tficha f  on f.id_ficha = fe.id_ficha
                  inner join cola.vficha f  on f.id_ficha = fe.id_ficha
                  inner join cola.tservicio s on s.id_servicio = ANY(fe.id_servicio)
                  where f.fecha_reg::date between '''||v_parametros.desde||'''::date and '''||v_parametros.hasta||''' and f.id_sucursal = '||v_parametros.id_sucursal||'
                  and fe.estado in (''en_atencion'',''finalizado'') and fe.estado_reg = ''activo'' --se aumento estado Activo
                  )
                  select count(1)::numeric as cantidad_estado,round(((count(1) / (sum(count(1)) over ()))*100),2)::numeric as porcentaje_servicio,servicio::varchar
                  from historico h
                  group by h.servicio ';

			--Definicion de la respuesta

			--Devuelve la respuesta
      --RAISE EXCEPTION '%',v_consulta;
			return v_consulta;

		end;


    /*********************************
 	#TRANSACCION:  'COLA_FICATEN_SEL'
 	#DESCRIPCION:	Funcio que devuelve  para el reporte de ATENCION POR ESTADO
 	#AUTOR:		Favio Figueroa
 	#FECHA:		29-07-2017 10:11:23
	***********************************/

	elsif(p_transaccion='COLA_FICATEN_SEL')then

		begin

			--Sentencia de la consulta de conteo de registros
			v_consulta:='select fe.estado,
                    round(avg(EXTRACT(EPOCH FROM (fe.fecha_hora_fin - fe.fecha_hora_inicio))/60)::numeric,0) as promedio_estado--,

                  from cola.vficha f
                    inner join cola.vficha_estado fe on fe.id_ficha = f.id_ficha
                  where estado in (''espera'',''llamado'',''en_atencion'') and
                        f.id_sucursal = '||v_parametros.id_sucursal||' and f.fecha_reg::date between '''||v_parametros.desde||'''::date and '''||v_parametros.hasta||''' and
                        fe.fecha_hora_fin is not NULL
                  group by fe.estado ';

			--Definicion de la respuesta

			--Devuelve la respuesta
      --RAISE EXCEPTION '%',v_consulta;
			return v_consulta;

		end;


 /*********************************
 	#TRANSACCION:  'COLA_FICATENUS_SEL'
 	#DESCRIPCION:	Funcio que devuelve  para el reporte de ATENCION POR USUARIO
 	#AUTOR:		Favio Figueroa
 	#FECHA:		29-07-2017 10:11:23
	***********************************/

	elsif(p_transaccion='COLA_FICATENUS_SEL')then

		begin

			--Sentencia de la consulta de conteo de registros
			v_consulta:='with fichas as (
    SELECT f.id_ficha,fe.id_usuario_atencion
    from cola.vficha_estado fe
      --inner join cola.tficha f on f.id_ficha = fe.id_ficha
      inner join cola.vficha f  on f.id_ficha = fe.id_ficha
    where fe.estado in (''atencion'',''finalizado'') and f.id_sucursal = '||v_parametros.id_sucursal||' and
          f.fecha_reg::date between '''||v_parametros.desde||''' and '''||v_parametros.hasta||'''
          and fe.id_usuario_atencion is not NULL
    group by f.id_ficha,fe.id_usuario_atencion
), usuarios as (
    select id_usuario_atencion,count(*) as cantidad
    from fichas
    group by id_usuario_atencion
), espera as (
    select f.id_usuario_atencion,
      round(avg(EXTRACT(EPOCH FROM (fe.fecha_hora_fin - fe.fecha_hora_inicio))/60)::numeric,0) as espera
    from fichas f
      inner join cola.vficha_estado fe on fe.id_ficha = f.id_ficha
    where fe.estado = ''espera'' and fe.fecha_hora_fin is not null
    group by f.id_usuario_atencion
), llamado as (
    select f.id_usuario_atencion,
      round(avg(EXTRACT(EPOCH FROM (fe.fecha_hora_fin - fe.fecha_hora_inicio))/60)::numeric,0) as llamado
    from fichas f
      inner join cola.vficha_estado fe on fe.id_ficha = f.id_ficha and fe.id_usuario_atencion = f.id_usuario_atencion
    where fe.estado = ''llamado'' and fe.fecha_hora_fin is not null
    group by f.id_usuario_atencion

), atencion as (
    select f.id_usuario_atencion,
      round(avg(EXTRACT(EPOCH FROM (fe.fecha_hora_fin - fe.fecha_hora_inicio))/60)::numeric,0) as atencion
    from fichas f
      inner join cola.vficha_estado fe on fe.id_ficha = f.id_ficha and fe.id_usuario_atencion = f.id_usuario_atencion
    where fe.estado = ''en_atencion'' and fe.fecha_hora_fin is not null
    group by f.id_usuario_atencion
)
select usu.desc_persona, u.cantidad, e.espera, l.llamado,a.atencion
from usuarios u
  inner join segu.vusuario usu on usu.id_usuario = u.id_usuario_atencion
  left join espera e on e.id_usuario_atencion = u.id_usuario_atencion
  left join llamado l on l.id_usuario_atencion = u.id_usuario_atencion
  left join atencion a  on a.id_usuario_atencion = u.id_usuario_atencion' ;

			--Definicion de la respuesta

			--Devuelve la respuesta
      --RAISE EXCEPTION '%',v_consulta;
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

ALTER FUNCTION cola.ft_ficha_sel (p_administrador integer, p_id_usuario integer, p_tabla varchar, p_transaccion varchar)
  OWNER TO postgres;
