CREATE OR REPLACE FUNCTION cola.f_obtener_num_ficha (
  p_id_sucursal integer,
  p_id_servicio integer,
  p_id_prioridad integer
)
RETURNS varchar AS
$body$
DECLARE
	v_resp		            	varchar;
  	v_nombre_funcion        	text;
    sigla_servi				varchar;
    sigla_priori			varchar;
    max_ficha				integer;
    cant_ficha				integer; 
    v_digito					integer;
    cant_dig				varchar;
    num_ficha				integer;
    ticket					varchar;
BEGIN  
	v_nombre_funcion = 'cola.f_obtener_num_ficha';

    		select servi.sigla into sigla_servi
            from cola.tservicio servi
            where servi.id_servicio = p_id_servicio;

            select priori.sigla into sigla_priori
            from cola.tprioridad priori 
            where priori.id_prioridad = p_id_prioridad;
            
            select sucser.digito into v_digito
            from cola.tsucursal_servicio sucser
            where sucser.id_sucursal=p_id_sucursal and sucser.id_servicio=p_id_servicio; 
            
            select count(*) into cant_ficha
            from cola.tficha ficha
            --where ficha.id_sucursal = p_id_sucursal and ficha.id_servicio = p_id_servicio and ficha.id_prioridad = p_id_prioridad;
            --where ficha.id_sucursal = p_id_sucursal and ficha.sigla like ''||sigla_servi||sigla_priori||''-''||%'';
            where ficha.id_sucursal = p_id_sucursal and ficha.sigla like sigla_servi||sigla_priori||'-'||'%';

            -- raise notice 'entrando del case primer';
            CASE
            	when v_digito=1 THEN max_ficha:=9;
                 when v_digito=2 THEN max_ficha:=99;
                 when v_digito=3 THEN max_ficha:=999;
                 when v_digito=4 THEN max_ficha:=9999;
                 when v_digito=5 THEN max_ficha:=99999;
                 when v_digito=6 THEN max_ficha:=999999;
                 when v_digito=7 THEN max_ficha:=9999999;
                 when v_digito=8 THEN max_ficha:=99999999;
                 when v_digito=9 THEN max_ficha:=999999999;
                 else max_ficha:= 1;
            end case;
              
            select (cant_ficha % max_ficha)+1 into num_ficha;
            select char_length(num_ficha::varchar) into cant_dig;
          
            CASE
            	when v_digito - cant_dig::integer =0 THEN ticket:=sigla_servi||sigla_priori||'-'||num_ficha;
            	when v_digito - cant_dig::integer =1 THEN ticket:=sigla_servi||sigla_priori||'-0'||num_ficha;
                when v_digito - cant_dig::integer =2 THEN ticket:=sigla_servi||sigla_priori||'-00'||num_ficha;
                when v_digito - cant_dig::integer =3 THEN ticket:=sigla_servi||sigla_priori||'-000'||num_ficha;
                when v_digito - cant_dig::integer =4 THEN ticket:=sigla_servi||sigla_priori||'-0000'||num_ficha;
                when v_digito - cant_dig::integer =5 THEN ticket:=sigla_servi||sigla_priori||'-00000'||num_ficha;
                when v_digito - cant_dig::integer =6 THEN ticket:=sigla_servi||sigla_priori||'-000000'||num_ficha;
                when v_digito - cant_dig::integer =7 THEN ticket:=sigla_servi||sigla_priori||'-0000000'||num_ficha;
                when v_digito - cant_dig::integer =8 THEN ticket:=sigla_servi||sigla_priori||'-00000000'||num_ficha;
                else  ticket:=sigla_servi||sigla_priori||'-'||num_ficha;
            end case;     
    raise notice '%', 'sale con:'||ticket;
    return ticket;
    
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