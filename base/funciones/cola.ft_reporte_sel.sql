CREATE OR REPLACE FUNCTION cola.ft_reporte_sel (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		Sistema de Colas
 FUNCION: 		cola.ft_reporte_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'cola.tservicio'
 AUTOR: 		 (JRR)
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
    v_filtro_adi		varchar;

BEGIN

	v_nombre_funcion = 'cola.ft_reporte_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************
 	#TRANSACCION:  'COLA_REPTICKATE_SEL'
 	#DESCRIPCION:	Reporte Tickets atendidos
 	#AUTOR:		JRR
 	#FECHA:		15-06-2016 23:15:11
	***********************************/

	if(p_transaccion='COLA_REPTICKATE_SEL')then

    	begin
				v_filtro_adi = '';
        	if (v_parametros.id_usuario is not null) then
            	v_filtro_adi = v_filtro_adi || ' and atencion.id_usuario_atencion = ' || v_parametros.id_usuario;
            end if;

    		--Sentencia de la consulta
			v_consulta:='with espera as (
              select f.id_ficha, round(sum( extract (epoch from(coalesce(feh.fecha_hora_fin,now()) - feh.fecha_hora_inicio))/60)::numeric,0) as tiempo_espera
              from cola.vficha_estado feh
              inner join cola.vficha f on f.id_ficha = feh.id_ficha
              where feh.estado = ''espera'' and ' ||v_parametros.filtro || '
              group by f.id_ficha
              )
              select f.id_ficha,
              f.sigla::varchar as ficha,
              	s.nombre::varchar as sucursal,
              	pxp.list(usu.desc_persona)::varchar as operador,
              pxp.list(ser.nombre)::varchar as servicio,
              pxp.list(tv.nombre)::varchar as tipo_ventanilla,
              pxp.list(llamado.numero_ventanilla)::varchar as numero_ventanilla,
              pxp.list(to_char(f.fecha_reg,''HH24:MI:SS''))::varchar as hora_generacion,
              pxp.list(to_char(f.fecha_reg,''DD/MM/YYYY''))::varchar as fecha_generacion,
              pxp.list(to_char(llamado.fecha_hora_inicio,''HH24:MI:SS''))::varchar as hora_llamado,
              pxp.list(to_char(atencion.fecha_hora_inicio,''HH24:MI:SS''))::varchar as hora_inicio_atencion,
              pxp.list(to_char(atencion.fecha_hora_fin,''HH24:MI:SS''))::varchar as hora_fin_atencion,
              es.tiempo_espera::varchar,
              round(sum(extract (epoch from(coalesce(atencion.fecha_hora_fin,now()) - atencion.fecha_hora_inicio))/60)::numeric,0)::varchar as tiempo_atencion,
              actual.estado
              from cola.vficha f
              left join cola.vficha_estado llamado on llamado.id_ficha = f.id_ficha and llamado.estado = ''llamado''
              inner join cola.vficha_estado actual on actual.id_ficha = f.id_ficha and actual.estado_reg = ''activo''
              left join cola.vficha_estado atencion on atencion.id_ficha = f.id_ficha and atencion.estado = ''en_atencion'' AND
                  llamado.id_usuario_atencion = atencion.id_usuario_atencion
              left join segu.vusuario usu on usu.id_usuario = llamado.id_usuario_atencion
              inner join cola.tsucursal s on s.id_sucursal = f.id_sucursal
              left join cola.tservicio ser on ser.id_servicio = f.id_servicio
              left join cola.ttipo_ventanilla tv on tv.id_tipo_ventanilla = llamado.id_tipo_ventanilla
              left join espera es on es.id_ficha = f.id_ficha
              where ' ||v_parametros.filtro || v_filtro_adi;


			v_consulta:=v_consulta||'

            group by f.id_ficha,f.sigla,
              	s.nombre,
              es.tiempo_espera,
              actual.estado

            order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;
			raise notice '%',v_consulta;
			--Devuelve la respuesta
			return v_consulta;

		end;
    /*********************************
 	#TRANSACCION:  'COLA_REPTICKATE_CONT'
 	#DESCRIPCION:	Reporte Tickets atendidos
 	#AUTOR:		JRR
 	#FECHA:		15-06-2016 23:15:11
	***********************************/

	elsif(p_transaccion='COLA_REPTICKATE_CONT')then

    	begin
        	v_filtro_adi = '';
        	if (v_parametros.id_usuario is not null) then
            	v_filtro_adi = v_filtro_adi || ' and atencion.id_usuario_atencion = ' || v_parametros.id_usuario;
            end if;

    		--Sentencia de la consulta
			v_consulta:='with espera as (
              select f.id_ficha, round(sum( extract (epoch from(coalesce(feh.fecha_hora_fin,now()) - feh.fecha_hora_inicio))/60)::numeric,0) as tiempo_espera
              from cola.vficha_estado feh
              inner join cola.vficha f on f.id_ficha = feh.id_ficha
              where feh.estado = ''espera'' and ' ||v_parametros.filtro || '
              group by f.id_ficha
              )
              select count( distinct f.id_ficha)
              from cola.vficha f
              left join cola.vficha_estado llamado on llamado.id_ficha = f.id_ficha and llamado.estado = ''llamado''
              inner join cola.vficha_estado actual on actual.id_ficha = f.id_ficha and actual.estado_reg = ''activo''
              left join cola.vficha_estado atencion on atencion.id_ficha = f.id_ficha and atencion.estado = ''en_atencion'' AND
                  llamado.id_usuario_atencion = atencion.id_usuario_atencion
              left join segu.vusuario usu on usu.id_usuario = llamado.id_usuario_atencion
              inner join cola.tsucursal s on s.id_sucursal = f.id_sucursal
              left join cola.tservicio ser on ser.id_servicio = f.id_servicio
              left join cola.ttipo_ventanilla tv on tv.id_tipo_ventanilla = llamado.id_tipo_ventanilla
              left join espera es on es.id_ficha = f.id_ficha
              where ' ||v_parametros.filtro || v_filtro_adi;


			--Devuelve la respuesta
			return v_consulta;

		end;

    /*********************************
 	#TRANSACCION:  'COLA_REPTICKACT_SEL'
 	#DESCRIPCION:	Reporte Tickets en atencion
 	#AUTOR:		JRR
 	#FECHA:		15-06-2016 23:15:11
	***********************************/

	elsif(p_transaccion='COLA_REPTICKACT_SEL')then

    	begin
        	v_filtro_adi = '';
        	if (v_parametros.id_usuario is not null) then
            	v_filtro_adi = v_filtro_adi || ' and atencion.id_usuario_atencion = ' || v_parametros.id_usuario;
            end if;

            if (v_parametros.estado is not null and v_parametros.estado != '') then
            	v_filtro_adi = v_filtro_adi || ' and est.estado = ''' || v_parametros.estado || '''';
            end if;

    		--Sentencia de la consulta
			v_consulta:='with espera as (
              select f.id_ficha, round(sum( extract (epoch from(coalesce(feh.fecha_hora_fin,now()) - feh.fecha_hora_inicio))/60)::numeric,0) as tiempo_espera
              from cola.tficha_estado feh
              inner join cola.tficha f on f.id_ficha = feh.id_ficha
              where feh.estado = ''espera'' and ' ||v_parametros.filtro || '
              group by f.id_ficha
              )
              select f.id_ficha,f.sigla::varchar as ficha,
              	s.nombre::varchar as sucursal,usu.desc_persona::varchar as operador,
              ser.nombre::varchar as servicio, tv.nombre::varchar as tipo_ventanilla,
              llamado.numero_ventanilla::varchar,
              to_char(f.fecha_reg,''HH24:MI:SS'')::varchar as hora_generacion,
              to_char(llamado.fecha_hora_inicio,''HH24:MI:SS'')::varchar as hora_llamado,
              to_char(atencion.fecha_hora_inicio,''HH24:MI:SS'')::varchar as hora_inicio_atencion,
              to_char(atencion.fecha_hora_fin,''HH24:MI:SS'')::varchar as hora_fin_atencion,
              es.tiempo_espera::varchar,
              round((extract (epoch from(coalesce(atencion.fecha_hora_fin,now()) - atencion.fecha_hora_inicio))/60)::numeric,0)::varchar as tiempo_atencion
              from cola.tficha f
              inner join cola.tficha_estado est on est.id_ficha = f.id_ficha and est.estado_reg = ''activo''
              left join cola.tficha_estado llamado on llamado.id_ficha = f.id_ficha and llamado.estado = ''llamado''
              left join cola.tficha_estado atencion on atencion.id_ficha = f.id_ficha and atencion.estado = ''en_atencion'' AND
                  llamado.id_usuario_atencion = atencion.id_usuario_atencion
              left join segu.vusuario usu on usu.id_usuario = llamado.id_usuario_atencion
              inner join cola.tsucursal s on s.id_sucursal = f.id_sucursal
              inner join cola.tservicio ser on ser.id_servicio = f.id_servicio
              left join cola.ttipo_ventanilla tv on tv.id_tipo_ventanilla = llamado.id_tipo_ventanilla
              inner join espera es on es.id_ficha = f.id_ficha
              where ' ||v_parametros.filtro || v_filtro_adi;


			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;
			raise notice '%',v_consulta;
			--Devuelve la respuesta
			return v_consulta;

		end;
    /*********************************
 	#TRANSACCION:  'COLA_REPTICKACT_CONT'
 	#DESCRIPCION:	Reporte Tickets atendidos
 	#AUTOR:		JRR
 	#FECHA:		15-06-2016 23:15:11
	***********************************/

	elsif(p_transaccion='COLA_REPTICKACT_CONT')then

    	begin
        	v_filtro_adi = '';
        	if (v_parametros.id_usuario is not null) then
            	v_filtro_adi = v_filtro_adi || ' and atencion.id_usuario_atencion = ' || v_parametros.id_usuario;
            end if;

            if (v_parametros.estado is not null and v_parametros.estado != '') then
            	v_filtro_adi = v_filtro_adi || ' and est.estado = ''' || v_parametros.estado || '''';
            end if;

    		--Sentencia de la consulta
			v_consulta:='with espera as (
              select f.id_ficha, round(sum( extract (epoch from(coalesce(feh.fecha_hora_fin,now()) - feh.fecha_hora_inicio))/60)::numeric,0) as tiempo_espera
              from cola.tficha_estado feh
              inner join cola.tficha f on f.id_ficha = feh.id_ficha
              where feh.estado = ''espera'' and ' ||v_parametros.filtro || '
              group by f.id_ficha
              )
              select count(f.id_ficha)
              from cola.tficha_historico f
              inner join cola.tficha_estado est on est.id_ficha = f.id_ficha and est.estado_reg = ''activo''
              left join cola.tficha_estado llamado on llamado.id_ficha = f.id_ficha and llamado.estado = ''llamado''
              left join cola.tficha_estado atencion on atencion.id_ficha = f.id_ficha and atencion.estado = ''atencion'' AND
                  llamado.id_usuario_atencion = atencion.id_usuario_atencion
              left join segu.vusuario usu on usu.id_usuario = llamado.id_usuario_atencion
              inner join cola.tsucursal s on s.id_sucursal = f.id_sucursal
              inner join cola.tservicio ser on ser.id_servicio = f.id_servicio
              left join cola.ttipo_ventanilla tv on tv.id_tipo_ventanilla = llamado.id_tipo_ventanilla
              inner join espera es on es.id_ficha = f.id_ficha
              where ' ||v_parametros.filtro || v_filtro_adi;


			--Devuelve la respuesta
			return v_consulta;

		end;

    /*********************************
 	#TRANSACCION:  'COLA_REPTIEARRI_SEL'
 	#DESCRIPCION:	Reporte Tickets en atencion
 	#AUTOR:		JRR
 	#FECHA:		15-06-2016 23:15:11
	***********************************/

	elsif(p_transaccion='COLA_REPTIEARRI_SEL')then

    	begin

    		--Sentencia de la consulta
			v_consulta:='select EXTRACT(hour FROM f.fecha_reg)::integer as hora, (EXTRACT(hour FROM f.fecha_reg) || ''-'' || (EXTRACT(hour FROM f.fecha_reg) + 1))::varchar as rango,count(*)::integer as cantidad
                        from cola.tficha_historico f
                        where ' ||v_parametros.filtro || '
                        group by EXTRACT(hour FROM f.fecha_reg)
                        ';


			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			return v_consulta;

		end;
    /*********************************
 	#TRANSACCION:  'COLA_REPTIEARRI_CONT'
 	#DESCRIPCION:	Reporte Tickets atendidos
 	#AUTOR:		JRR
 	#FECHA:		15-06-2016 23:15:11
	***********************************/

	elsif(p_transaccion='COLA_REPTIEARRI_CONT')then

    	begin

    		--Sentencia de la consulta
			v_consulta:=' with cantidad as (
            				select EXTRACT(hour FROM f.fecha_reg)::integer as hora, (EXTRACT(hour FROM f.fecha_reg) || ''-'' || (EXTRACT(hour FROM f.fecha_reg) + 1))::varchar as rango,count(*)::integer as cantidad
                        	from cola.tficha_historico f
                        	where ' ||v_parametros.filtro || '
                        	group by EXTRACT(hour FROM f.fecha_reg))
             			  select count (*)
                          from cantidad
                        ';

			--Devuelve la respuesta
			return v_consulta;

		end;

    /*********************************
 	#TRANSACCION:  'COLA_REPTIEESP_SEL'
 	#DESCRIPCION:	Reporte Tiempos de espera
 	#AUTOR:		JRR
 	#FECHA:		15-06-2016 23:15:11
	***********************************/

	elsif(p_transaccion='COLA_REPTIEESP_SEL')then

    	begin

    		--Sentencia de la consulta
			v_consulta:='with datos_espera as (
                              select f.id_sucursal,f.id_ficha, round(sum( extract (epoch from(coalesce(feh.fecha_hora_fin,now()) - feh.fecha_hora_inicio))/60)::numeric,0) as tiempo_espera,
                              count(f.id_sucursal) OVER () as total
                              from cola.vficha_estado feh
                              inner join cola.vficha f on f.id_ficha = feh.id_ficha
                              where feh.estado = ''espera'' and ' || v_parametros.filtro || '
                              group by f.id_sucursal,f.id_ficha),
                          datos_atencion as (
                                                  select f.id_sucursal,f.id_ficha, round(sum( extract (epoch from(coalesce(feh.fecha_hora_fin,now()) - feh.fecha_hora_inicio))/60)::numeric,0) as tiempo_atencion,
                                                  count(f.id_sucursal) OVER () as total
                                                  from cola.vficha_estado feh
                                                  inner join cola.vficha f on f.id_ficha = feh.id_ficha
                                                  where feh.estado = ''en_atencion'' and ' || v_parametros.filtro || '
                                                  group by f.id_sucursal,f.id_ficha),
                           datos_llamado as (
                                                  select f.id_sucursal,f.id_ficha, round(sum( extract (epoch from(coalesce(feh.fecha_hora_fin,now()) - feh.fecha_hora_inicio))/60)::numeric,0) as tiempo_llamado,
                                                  count(f.id_sucursal) OVER () as total
                                                  from cola.vficha_estado feh
                                                  inner join cola.vficha f on f.id_ficha = feh.id_ficha
                                                  where feh.estado = ''llamado'' and ' || v_parametros.filtro || '
                                                  group by f.id_sucursal,f.id_ficha)
                          select  ''0 a 5 minutos''::varchar,
                          			sum(case when da.tiempo_atencion <= 5 then 1 else 0 end)::integer as  cantidad_atencion,
                          			sum(case when de.tiempo_espera <= 5 then 1 else 0 end)::integer as  cantidad_espera,
                                    sum(case when dl.tiempo_llamado <= 5 then 1 else 0 end)::integer as  cantidad_llamado

                          from datos_espera de
                          left join datos_llamado dl on dl.id_ficha = de.id_ficha
                          left join datos_atencion da on da.id_ficha = de.id_ficha

                          union ALL
                          select  ''5 a 10 minutos''::varchar,
                          			sum(case when da.tiempo_atencion > 5 and da.tiempo_atencion <=10 then 1 else 0 end)::integer as  cantidad_atencion,
                          			sum(case when de.tiempo_espera > 5 and de.tiempo_espera <=10 then 1 else 0 end)::integer as  cantidad_espera,
                                    sum(case when dl.tiempo_llamado > 5 and dl.tiempo_llamado <=10 then 1 else 0 end)::integer as  cantidad_llamado

                          from datos_espera de
                          left join datos_llamado dl on dl.id_ficha = de.id_ficha
                          left join datos_atencion da on da.id_ficha = de.id_ficha
                          union ALL
                          select  ''10 a mas''::varchar,
                          			sum(case when da.tiempo_atencion > 10 then 1 else 0 end)::integer as  cantidad_atencion,
                          			sum(case when de.tiempo_espera > 10 then 1 else 0 end)::integer as  cantidad_espera,
                                    sum(case when dl.tiempo_llamado > 10 then 1 else 0 end)::integer as  cantidad_llamado

                          from datos_espera de
                          left join datos_llamado dl on dl.id_ficha = de.id_ficha
                          left join datos_atencion da on da.id_ficha = de.id_ficha
                        ';
			raise notice '%',v_consulta;
			return v_consulta;

		end;
   /*********************************
 	#TRANSACCION:  'COLA_REPTIEESP_CONT'
 	#DESCRIPCION:	Reporte Tiempos de espera
 	#AUTOR:		JRR
 	#FECHA:		15-06-2016 23:15:11
	***********************************/

	elsif(p_transaccion='COLA_REPTIEESP_CONT')then

    	begin

    		--Sentencia de la consulta
			v_consulta:=' select 3::bigint
                        ';

			--Devuelve la respuesta
			return v_consulta;

		end;

    /*********************************
 	#TRANSACCION:  'COLA_REPTIESPDET_SEL'
 	#DESCRIPCION:	Reporte Tiempos de espera Detalle
 	#AUTOR:		JRR
 	#FECHA:		15-06-2016 23:15:11
	***********************************/

	elsif(p_transaccion='COLA_REPTIESPDET_SEL')then

    	begin

    		--Sentencia de la consulta
			v_consulta:='with datos_espera as (
                              select f.id_sucursal,f.id_ficha,s.nombre as servicio, round(sum( extract (epoch from(coalesce(feh.fecha_hora_fin,now()) - feh.fecha_hora_inicio))/60)::numeric,0) as tiempo_espera,
                              count(f.id_sucursal) OVER () as total
                              from cola.vficha_estado feh
                              inner join cola.vficha f on f.id_ficha = feh.id_ficha
                              inner join cola.tservicio s on s.id_servicio = f.id_servicio
                              where feh.estado = ''espera'' and ' || v_parametros.filtro || '
                              group by f.id_sucursal,f.id_ficha,s.nombre),
	  datos_atencion as (
                              select f.id_sucursal,f.id_ficha, round(sum( extract (epoch from(coalesce(feh.fecha_hora_fin,now()) - feh.fecha_hora_inicio))/60)::numeric,0) as tiempo_atencion,
                              count(f.id_sucursal) OVER () as total
                              from cola.vficha_estado feh
                              inner join cola.vficha f on f.id_ficha = feh.id_ficha

                              where feh.estado = ''en_atencion'' and ' || v_parametros.filtro || '
                              group by f.id_sucursal,f.id_ficha),
       datos_llamado as (
                              select f.id_sucursal,f.id_ficha, round(sum( extract (epoch from(coalesce(feh.fecha_hora_fin,now()) - feh.fecha_hora_inicio))/60)::numeric,0) as tiempo_llamado,
                              count(f.id_sucursal) OVER () as total
                              from cola.vficha_estado feh
                              inner join cola.vficha f on f.id_ficha = feh.id_ficha
                              where feh.estado = ''llamado''  and ' || v_parametros.filtro || '
                              group by f.id_sucursal,f.id_ficha)
                          select    de.servicio,
                          			sum(case when da.tiempo_atencion <= 5 then 1 else 0 end)::integer as  cantidad_atencion1,
                          			sum(case when da.tiempo_atencion > 5 and da.tiempo_atencion <=10 then 1 else 0 end)::integer as  cantidad_atencion2,
                                    sum(case when da.tiempo_atencion > 10 then 1 else 0 end)::integer as  cantidad_atencion3,

                                    sum(case when de.tiempo_espera <= 5 then 1 else 0 end)::integer as  cantidad_espera1,
                                    sum(case when de.tiempo_espera > 5 and de.tiempo_espera <=10 then 1 else 0 end)::integer as  cantidad_espera2,
                                    sum(case when de.tiempo_espera > 10 then 1 else 0 end)::integer as  cantidad_espera3,

                                    sum(case when dl.tiempo_llamado <= 5 then 1 else 0 end)::integer as  cantidad_llamado1,
                          			sum(case when dl.tiempo_llamado > 5 and dl.tiempo_llamado <=10 then 1 else 0 end)::integer as  cantidad_llamado2,
                                    sum(case when dl.tiempo_llamado > 10 then 1 else 0 end)::integer as  cantidad_llamado3
                          from datos_espera de
                          left join datos_llamado dl on dl.id_ficha = de.id_ficha
                          left join datos_atencion da on da.id_ficha = de.id_ficha
                          group by de.servicio
                        ';
			raise notice '%',v_consulta;
			return v_consulta;

		end;

    /*********************************
 	#TRANSACCION:  'COLA_REPHISFIC_SEL'
 	#DESCRIPCION:	Reporte Historico de fichas
 	#AUTOR:		JRR
 	#FECHA:		15-06-2016 23:15:11
	***********************************/

	elsif(p_transaccion='COLA_REPHISFIC_SEL')then

    	begin

    		--Sentencia de la consulta
            if (v_parametros.id_sucursal = 0) then

            v_consulta:='select
            			usu.desc_persona::varchar as operador,
                        sum(case when feh.estado = ''finalizado'' then
                        1
                        else
                        0
                        end)::numeric as cantidad_finalizadas,

                        sum(case when feh.estado = ''no_show'' then
                        1
                        else
                        0
                        end)::numeric as cantidad_abandonadas,

                        /************************************Aumentado************************************/
                        count(*)::numeric as total_fichas,

                        round(((sum (case when feh.estado = ''finalizado'' then
                        1
                        else
                        0
                        end) * 100 )::numeric / count(*)),0) as porcentaje_finalizadas,

                        round (((sum(case when feh.estado = ''no_show'' then
                        1
                        else
                        0
                        end) *100 )::numeric / count(*)),0) as porcentaje_abandonadas,

                        sucur.nombre

                       	/******************************************************************************/


                          /*
                          (sum(case when feh.estado = ''finalizado'' then
                          1
                          else
                          0
                          end) / count(*)*100)::numeric as porcentaje_finalizadas,

                          (sum(case when feh.estado = ''no_show'' then
                          1
                          else
                          0
                          end)/ count(*)*100)::numeric as porcentaje_abandonadas*/


                          from cola.vficha fh
                          inner join cola.vficha_estado feh on feh.id_ficha = fh.id_ficha
                          and feh.estado in (''finalizado'',''no_show'') and feh.estado_reg = ''activo''

                          inner join cola.tsucursal sucur on sucur.id_sucursal = fh.id_sucursal

                          left join segu.vusuario usu on usu.id_usuario = feh.id_usuario_atencion
                          where fh.fecha_reg::date >= ''' || v_parametros.fecha_ini || ''' and fh.fecha_reg::date <= ''' || v_parametros.fecha_fin || '''
                          group by usu.desc_persona,sucur.nombre';

            else



			v_consulta:='select  usu.desc_persona::varchar as operador,
                          sum(case when feh.estado = ''finalizado'' then
                          1
                          else
                          0
                          end)::numeric as cantidad_finalizadas,
                          sum(case when feh.estado = ''no_show'' then
                          1
                          else
                          0
                          end)::numeric as cantidad_abandonadas,


                         /************************************Aumentado************************************/

                          count(*)::numeric as total_fichas,


                        round(((sum (case when feh.estado = ''finalizado'' then
                          1
                          else
                          0
                          end) * 100 )::numeric / count(*)),0) as porcentaje_finalizadas,


                          round (((sum(case when feh.estado = ''no_show'' then
                          1
                          else
                          0
                          end) *100 )::numeric / count(*)),0) as porcentaje_abandonadas,

                          sucur.nombre

                       	/******************************************************************************/



                          /*
                          (sum(case when feh.estado = ''finalizado'' then
                          1
                          else
                          0
                          end) / count(*)*100)::numeric as porcentaje_finalizadas,

                          (sum(case when feh.estado = ''no_show'' then
                          1
                          else
                          0
                          end)/ count(*)*100)::numeric as porcentaje_abandonadas
                          */
                          from cola.vficha fh
                          inner join cola.vficha_estado feh on feh.id_ficha = fh.id_ficha
                          and feh.estado in (''finalizado'',''no_show'') and feh.estado_reg = ''activo''

                          inner join cola.tsucursal sucur on sucur.id_sucursal = fh.id_sucursal

                          left join segu.vusuario usu on usu.id_usuario = feh.id_usuario_atencion
                          where ' || v_parametros.filtro || '
                          group by usu.desc_persona,sucur.nombre

                        ';
            end if;
				v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;
			raise notice '%',v_consulta;
			return v_consulta;

		end;
   /*********************************
 	#TRANSACCION:  'COLA_REPHISFIC_CONT'
 	#DESCRIPCION:	Conteo Reporte Historico de fichas
 	#AUTOR:		JRR
 	#FECHA:		15-06-2016 23:15:11
	***********************************/

	elsif(p_transaccion='COLA_REPHISFIC_CONT')then

    	begin
          if (v_parametros.id_sucursal = 0) then

          --Sentencia de la consulta
			v_consulta:=' with detalle as (
                          select  usu.desc_persona as operador,
                          sum(case when feh.estado = ''finalizado'' then
                          1
                          else
                          0
                          end)::numeric as cantidad_finalizadas,
                          sum(case when feh.estado = ''no_show'' then
                          1
                          else
                          0
                          end)::numeric as cantidad_abandonadas,
                          count(*)::numeric as total_fichas
                          from cola.tficha_historico fh
                          inner join cola.tficha_estado_historico feh on feh.id_ficha = fh.id_ficha
                          and feh.estado in (''finalizado'',''no_show'') and feh.estado_reg = ''activo''
                          left join segu.vusuario usu on usu.id_usuario = feh.id_usuario_atencion
                          where fh.fecha_reg::date >= ''' || v_parametros.fecha_ini || ''' and fh.fecha_reg::date <= ''' || v_parametros.fecha_fin || '''
                          group by usu.desc_persona)

                          select count(*),
                          sum(cantidad_finalizadas),
                          sum(cantidad_abandonadas),
                          sum(total_fichas)
                          from detalle
                        ';
            else

    		--Sentencia de la consulta
			v_consulta:=' with detalle as (
                          select  usu.desc_persona as operador,
                          sum(case when feh.estado = ''finalizado'' then
                          1
                          else
                          0
                          end)::numeric as cantidad_finalizadas,
                          sum(case when feh.estado = ''no_show'' then
                          1
                          else
                          0
                          end)::numeric as cantidad_abandonadas,
                          count(*)::numeric as total_fichas
                          from cola.tficha_historico fh
                          inner join cola.tficha_estado_historico feh on feh.id_ficha = fh.id_ficha
                          and feh.estado in (''finalizado'',''no_show'') and feh.estado_reg = ''activo''
                          left join segu.vusuario usu on usu.id_usuario = feh.id_usuario_atencion
                          where ' || v_parametros.filtro || '
                          group by usu.desc_persona)

                          select count(*),
                          sum(cantidad_finalizadas),
                          sum(cantidad_abandonadas),
                          sum(total_fichas)
                          from detalle
                        ';
			end if;
			--Devuelve la respuesta
			return v_consulta;

		end;
    /*********************************
 	#TRANSACCION:  'COLA_REPCUAI_SEL'
 	#DESCRIPCION:	Total de tickets atendidos, abandonados y el promedio de atención por intervalo de tiempo
 	#AUTOR:		JRR
 	#FECHA:		15-06-2016 23:15:11
	***********************************/

	elsif(p_transaccion='COLA_REPCUAI_SEL')then

    	begin
        	/*Para el promedio se cambio los decimales de 2 a 0*/
    		--Sentencia de la consulta
			v_consulta:='with tiempos as (
            select f.id_ficha,
            round(sum(EXTRACT(EPOCH FROM arribo.fecha_hora_fin - arribo.fecha_hora_inicio)/60)::numeric,0) as promedio_espera,
            round(sum(EXTRACT(EPOCH FROM atencion.fecha_hora_fin - atencion.fecha_hora_inicio)/60)::numeric,0) as promedio_atencion
            from cola.vficha f
            left join cola.vficha_estado arribo on arribo.estado = ''espera'' and arribo.id_ficha = f.id_ficha
             left join cola.vficha_estado atencion on atencion.estado = ''en_atencion'' and atencion.id_ficha = f.id_ficha

            group by  f.id_ficha)


            select EXTRACT(hour FROM f.fecha_reg)::integer as hora,
            (EXTRACT(hour FROM f.fecha_reg) || ''-'' || (EXTRACT(hour FROM f.fecha_reg) + 1))::varchar as rango,
            sum(case when fe.estado = ''finalizado'' then 1 else 0 end)::numeric as cantidad_atendidos,
            sum(case when fe.estado = ''no_show'' then 1 else 0 end)::numeric as cantidad_abandonados,
            round(avg(t.promedio_espera)::NUMERIC,0),
            round(avg(t.promedio_atencion)::NUMERIC,0)
            from cola.vficha f
            inner join tiempos t on t.id_ficha = f.id_ficha
            inner join cola.vficha_estado fe on
            	fe.id_ficha = f.id_ficha and fe.estado_reg = ''activo''
                where  ' || v_parametros.filtro || '
            group by EXTRACT(hour FROM f.fecha_reg)
            order by hora
                        ';

			return v_consulta;

		end;

    /*********************************
 	#TRANSACCION:  'COLA_LISTHORSERV_SEL'
 	#DESCRIPCION:	Listado de servicios y horas atendidas en un rango de tiempo
 	#AUTOR:		JRR
 	#FECHA:		15-06-2016 23:15:11
	***********************************/

	elsif(p_transaccion='COLA_LISTHORSERV_SEL')then

    	begin

    		--Sentencia de la consulta
			v_consulta:='(select
            (EXTRACT(hour FROM f.fecha_reg) || ''-'' || (EXTRACT(hour FROM f.fecha_reg) + 1))::varchar as nombre,
            ''hora''::varchar as tipo
            from cola.vficha f
            where ' ||v_parametros.filtro || '
            group by EXTRACT(hour FROM f.fecha_reg)
            order by EXTRACT(hour FROM f.fecha_reg)::integer
            )
            union all
            (select
            s.nombre::varchar as nombre,
            ''servicio''::varchar as tipo
            from cola.vficha f
            inner join cola.tservicio s on s.id_servicio = f.id_servicio
            where ' ||v_parametros.filtro || '
            group by s.nombre
            order by 1)

                        ';

			return v_consulta;

		end;
    /*********************************
 	#TRANSACCION:  'COLA_REPCUAII_SEL'
 	#DESCRIPCION:	Cuadro II Servicios X Intervalo de tiempo
 	#AUTOR:		JRR
 	#FECHA:		15-06-2016 23:15:11
	***********************************/

	elsif(p_transaccion='COLA_REPCUAII_SEL')then

    	begin

    		--Sentencia de la consulta
			v_consulta:='select
            (EXTRACT(hour FROM f.fecha_reg) || ''-'' || (EXTRACT(hour FROM f.fecha_reg) + 1))::varchar as hora,
            s.nombre::varchar as servicio,
            count(f.id_ficha)::integer as cantidad
            from cola.vficha f
            inner join cola.tservicio s on s.id_servicio = f.id_servicio
            where ' ||v_parametros.filtro || '
            group by EXTRACT(hour FROM f.fecha_reg),s.nombre
            order by EXTRACT(hour FROM f.fecha_reg)::integer,s.nombre
               ';

			return v_consulta;

		end;
    /*********************************
 	#TRANSACCION:  'COLA_LISTHORUSU_SEL'
 	#DESCRIPCION:	Listado de usuario y horas atendidas en un rango de tiempo
 	#AUTOR:		JRR
 	#FECHA:		15-06-2016 23:15:11
	***********************************/

	elsif(p_transaccion='COLA_LISTHORUSU_SEL')then

    	begin

    		--Sentencia de la consulta
			v_consulta:='(select
            (EXTRACT(hour FROM f.fecha_reg) || ''-'' || (EXTRACT(hour FROM f.fecha_reg) + 1))::varchar as nombre,
            ''hora''::varchar as tipo
            from cola.vficha f
            where ' ||v_parametros.filtro || '
            group by EXTRACT(hour FROM f.fecha_reg)
            order by EXTRACT(hour FROM f.fecha_reg)::integer
            )
            union all
            (select
            u.desc_persona::varchar as nombre,
            ''usuario''::varchar as tipo
            from cola.vficha f
            inner join cola.vficha_estado e on e.id_ficha = f.id_ficha and estado = ''llamado''
            inner join segu.vusuario u on u.id_usuario = e.id_usuario_atencion
            where ' ||v_parametros.filtro || '
            group by u.desc_persona
            order by 1)';

			return v_consulta;

		end;
     /*********************************
 	#TRANSACCION:  'COLA_LISTUSUSERV_SEL'
 	#DESCRIPCION:	Listado de servicios y operadores en rango de tiempo
 	#AUTOR:		JRR
 	#FECHA:		15-06-2016 23:15:11
	***********************************/

	elsif(p_transaccion='COLA_LISTUSUSERV_SEL')then

    	begin

    		--Sentencia de la consulta
			v_consulta:='
            (select
            u.desc_persona::varchar as nombre,
            ''usuario''::varchar as tipo
            from cola.vficha f
            inner join cola.vficha_estado e on e.id_ficha = f.id_ficha and estado = ''finalizado''
            inner join segu.vusuario u on u.id_usuario = e.id_usuario_atencion
            where ' ||v_parametros.filtro || '
            group by u.desc_persona
            order by 1)

            union all

            (select
            s.nombre::varchar as nombre,
            ''servicio''::varchar as tipo
            from cola.vficha f
            inner join cola.vficha_estado e on e.id_ficha = f.id_ficha and estado = ''finalizado''
            inner join cola.tservicio s on s.id_servicio = ANY(e.id_servicio)
            where ' ||v_parametros.filtro || '
            group by s.nombre
            order by 1) ';

			return v_consulta;

		end;


    /*********************************
 	#TRANSACCION:  'COLA_REPCUAIII_SEL'
 	#DESCRIPCION:	Cuadro II Usuarios X Intervalo de tiempo
 	#AUTOR:		JRR
 	#FECHA:		15-06-2016 23:15:11
	***********************************/

	elsif(p_transaccion='COLA_REPCUAIII_SEL')then

    	begin

    		--Sentencia de la consulta
			v_consulta:='select
            (EXTRACT(hour FROM f.fecha_reg) || ''-'' || (EXTRACT(hour FROM f.fecha_reg) + 1))::varchar as hora,
            u.desc_persona::varchar as usuario,
            count(f.id_ficha)::integer as cantidad
            from cola.vficha f
            inner join cola.vficha_estado e on e.id_ficha = f.id_ficha and estado = ''llamado''
            inner join segu.vusuario u on u.id_usuario = e.id_usuario_atencion
            where ' ||v_parametros.filtro || '
            group by EXTRACT(hour FROM f.fecha_reg),u.desc_persona
            order by EXTRACT(hour FROM f.fecha_reg)::integer,u.desc_persona
               ';

			return v_consulta;

		end;

    /*********************************
 	#TRANSACCION:  'COLA_REPCUAVI_SEL'
 	#DESCRIPCION:	Cuadro VI Servicios Atendidos por usuario
 	#AUTOR:		JRR
 	#FECHA:		15-06-2016 23:15:11
	***********************************/

	elsif(p_transaccion='COLA_REPCUAVI_SEL')then

    	begin

    		--Sentencia de la consulta
			v_consulta:='select

            u.desc_persona::varchar as usuario,
            s.nombre as servicio,
            count(f.id_ficha)::integer as cantidad
            from cola.vficha f

            inner join cola.vficha_estado e on e.id_ficha = f.id_ficha  and e.estado_reg = ''activo'' and  estado = ''finalizado''
            inner join segu.vusuario u on u.id_usuario = e.id_usuario_atencion
            inner join cola.tservicio s on s.id_servicio = ANY(e.id_servicio)
            where ' ||v_parametros.filtro || '
            group by u.desc_persona,s.nombre
            order by u.desc_persona,s.nombre
               ';

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

ALTER FUNCTION cola.ft_reporte_sel (p_administrador integer, p_id_usuario integer, p_tabla varchar, p_transaccion varchar)
  OWNER TO postgres;
