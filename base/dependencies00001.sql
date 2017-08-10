/***********************************I-DEP-JMH-COLA-0-25/06/2016****************************************/

ALTER TABLE ONLY cola.tservicio
    ADD CONSTRAINT tservicio_fk_id_servicio FOREIGN KEY (id_servicio_fk)
    REFERENCES cola.tservicio(id_servicio)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;
    
ALTER TABLE ONLY cola.tsucursal_servicio
    ADD CONSTRAINT tsucursal_servicio_fk_id_servicio FOREIGN KEY (id_servicio)
    REFERENCES cola.tservicio(id_servicio)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;
    
ALTER TABLE ONLY cola.tsucursal_servicio
    ADD CONSTRAINT tsucursal_servicio_fk_id_sucural FOREIGN KEY (id_sucursal)
    REFERENCES cola.tsucursal(id_sucursal)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;
    
ALTER TABLE ONLY cola.tsucursal_servicio
    ADD CONSTRAINT tsucursal_servicio_fk_id_tipo_servicio FOREIGN KEY (id_tipo_ventanilla)
    REFERENCES cola.ttipo_ventanilla(id_tipo_ventanilla)
    MATCH FULL
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;
    
/***********************************F-DEP-JMH-COLA-0-25/06/2016****************************************/


/***********************************I-DEP-JMH-COLA-0-09/07/2016****************************************/

select pxp.f_insert_testructura_gui ('COLA', 'SISTEMA');
select pxp.f_insert_testructura_gui ('PARCOL', 'COLA');
select pxp.f_insert_testructura_gui ('priori', 'PARCOL');
select pxp.f_insert_testructura_gui ('servi', 'PARCOL');
select pxp.f_insert_testructura_gui ('sucur', 'PARCOL');
select pxp.f_insert_testructura_gui ('tipven', 'PARCOL');
select pxp.f_insert_testructura_gui ('PROCOL', 'COLA');
select pxp.f_insert_testructura_gui ('sersur', 'PROCOL');
select pxp.f_insert_testructura_gui ('ficha', 'PROCOL');

/***********************************F-DEP-JMH-COLA-0-09/07/2016****************************************/

/***********************************I-DEP-JMH-COLA-0-20/07/2016****************************************/
ALTER TABLE cola.tficha
  ADD COLUMN ultima_llamada TIMESTAMP(0) WITHOUT TIME ZONE;

ALTER TABLE cola.tficha
  ALTER COLUMN ultima_llamada SET DEFAULT now();
  
/***********************************F-DEP-JMH-COLA-0-20/07/2016****************************************/

/***********************************I-DEP-JMH-COLA-0-27/07/2016****************************************/
select pxp.f_insert_testructura_gui ('COLA', 'SISTEMA');
select pxp.f_insert_testructura_gui ('PARCOL', 'COLA');
select pxp.f_insert_testructura_gui ('priori', 'PARCOL');
select pxp.f_insert_testructura_gui ('servi', 'PARCOL');
select pxp.f_insert_testructura_gui ('sucur', 'PARCOL');
select pxp.f_insert_testructura_gui ('tipven', 'PARCOL');
select pxp.f_insert_testructura_gui ('PROCOL', 'COLA');
select pxp.f_insert_testructura_gui ('sersur', 'PROCOL');
select pxp.f_insert_testructura_gui ('ficha', 'PROCOL');
select pxp.f_insert_testructura_gui ('FICATE', 'PROCOL');
select pxp.f_insert_testructura_gui ('USUSUC', 'PARCOL');
select pxp.f_insert_testructura_gui ('PERSO', 'PARCOL');
select pxp.f_insert_testructura_gui ('USUA', 'PARCOL');
select pxp.f_insert_testructura_gui ('FICATE.1', 'FICATE');
select pxp.f_insert_testructura_gui ('PERSO.1', 'PERSO');
select pxp.f_insert_testructura_gui ('USUA.1', 'USUA');
select pxp.f_insert_testructura_gui ('USUA.2', 'USUA');
select pxp.f_insert_testructura_gui ('USUA.3', 'USUA');
select pxp.f_insert_testructura_gui ('USUA.1.1', 'USUA.1');
/***********************************F-DEP-JMH-COLA-0-27/07/2016****************************************/

/***********************************I-DEP-JMH-COLA-0-31/07/2016****************************************/

/***********************************F-DEP-JMH-COLA-0-31/07/2016****************************************/
/***********************************I-DEP-JMH-COLA-0-07/08/2016****************************************/

/***********************************F-DEP-JMH-COLA-0-07/08/2016****************************************/

/***********************************I-DEP-JMH-COLA-0-11/08/2016****************************************/

--ALTER TABLE cola.tficha_estado
  --DROP CONSTRAINT tficha_estado_fk_id_ficha RESTRICT;

ALTER TABLE cola.tficha_estado
  ADD CONSTRAINT tficha_estado_fk_id_ficha FOREIGN KEY (id_ficha)
    REFERENCES cola.tficha(id_ficha)
    MATCH FULL
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
    NOT DEFERRABLE;
/***********************************F-DEP-JMH-COLA-0-11/08/2016****************************************/

/***********************************I-DEP-JRR-COLA-0-05/09/2016****************************************/
CREATE OR REPLACE VIEW cola.vficha(
    id_usuario_reg,
    id_usuario_mod,
    fecha_reg,
    fecha_mod,
    estado_reg,
    id_usuario_ai,
    usuario_ai,
    id_ficha,
    id_prioridad,
    id_sucursal,
    id_servicio,
    sigla,
    numero,
    peso,
    ultima_llamada)
AS
  SELECT tficha.id_usuario_reg,
         tficha.id_usuario_mod,
         tficha.fecha_reg,
         tficha.fecha_mod,
         tficha.estado_reg,
         tficha.id_usuario_ai,
         tficha.usuario_ai,
         tficha.id_ficha,
         tficha.id_prioridad,
         tficha.id_sucursal,
         tficha.id_servicio,
         tficha.sigla,
         tficha.numero,
         tficha.peso,
         tficha.ultima_llamada
  FROM cola.tficha
  UNION ALL
  SELECT tficha_historico.id_usuario_reg,
         tficha_historico.id_usuario_mod,
         tficha_historico.fecha_reg,
         tficha_historico.fecha_mod,
         tficha_historico.estado_reg,
         tficha_historico.id_usuario_ai,
         tficha_historico.usuario_ai,
         tficha_historico.id_ficha,
         tficha_historico.id_prioridad,
         tficha_historico.id_sucursal,
         tficha_historico.id_servicio,
         tficha_historico.sigla,
         tficha_historico.numero,
         tficha_historico.peso,
         tficha_historico.ultima_llamada
  FROM cola.tficha_historico;

  CREATE OR REPLACE VIEW cola.vficha_estado(
    id_usuario_reg,
    id_usuario_mod,
    fecha_reg,
    fecha_mod,
    estado_reg,
    id_usuario_ai,
    usuario_ai,
    id_ficha_estado,
    id_ficha,
    estado,
    fecha_hora_inicio,
    fecha_hora_fin,
    id_tipo_ventanilla,
    id_usuario_atencion,
    numero_ventanilla,
    id_servicio)
AS
  SELECT tficha_estado.id_usuario_reg,
         tficha_estado.id_usuario_mod,
         tficha_estado.fecha_reg,
         tficha_estado.fecha_mod,
         tficha_estado.estado_reg,
         tficha_estado.id_usuario_ai,
         tficha_estado.usuario_ai,
         tficha_estado.id_ficha_estado,
         tficha_estado.id_ficha,
         tficha_estado.estado,
         tficha_estado.fecha_hora_inicio,
         tficha_estado.fecha_hora_fin,
         tficha_estado.id_tipo_ventanilla,
         tficha_estado.id_usuario_atencion,
         tficha_estado.numero_ventanilla,
         tficha_estado.id_servicio
  FROM cola.tficha_estado
  UNION ALL
  SELECT tficha_estado_historico.id_usuario_reg,
         tficha_estado_historico.id_usuario_mod,
         tficha_estado_historico.fecha_reg,
         tficha_estado_historico.fecha_mod,
         tficha_estado_historico.estado_reg,
         tficha_estado_historico.id_usuario_ai,
         tficha_estado_historico.usuario_ai,
         tficha_estado_historico.id_ficha_estado,
         tficha_estado_historico.id_ficha,
         tficha_estado_historico.estado,
         tficha_estado_historico.fecha_hora_inicio,
         tficha_estado_historico.fecha_hora_fin,
         tficha_estado_historico.id_tipo_ventanilla,
         tficha_estado_historico.id_usuario_atencion,
         tficha_estado_historico.numero_ventanilla,
         tficha_estado_historico.id_servicio
  FROM cola.tficha_estado_historico;
/***********************************F-DEP-JRR-COLA-0-05/09/2016****************************************/

/***********************************I-DEP-FFP-COLA-0-17/05/2017****************************************/

select pxp.f_insert_testructura_gui ('MENSA', 'PARCOL');
/***********************************F-DEP-FFP-COLA-0-17/05/2017****************************************/


/***********************************I-DEP-FFP-COLA-0-03/08/2017****************************************/

select pxp.f_insert_testructura_gui ('RGCOLA', 'REPCOL');

/***********************************F-DEP-FFP-COLA-0-03/08/2017****************************************/

/***********************************I-DEP-FFP-COLA-0-08/08/2017****************************************/

select pxp.f_insert_testructura_gui ('VIDEO', 'PARCOL');

/***********************************F-DEP-FFP-COLA-0-08/08/2017****************************************/

