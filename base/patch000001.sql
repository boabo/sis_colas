
/***********************************I-SCP-JMH-COLA-0-25/06/2016****************************************/
CREATE TABLE cola.tficha (
  id_ficha SERIAL,
  id_prioridad INTEGER NOT NULL,
  id_unidad INTEGER NOT NULL,
  id_servicio INTEGER NOT NULL,
  sigla VARCHAR,
  numero INTEGER,
  peso INTEGER,
  CONSTRAINT tficha_pkey PRIMARY KEY(id_ficha)
) INHERITS (pxp.tbase);

COMMENT ON COLUMN cola.tficha.id_ficha
IS 'Identificador unico de la tabla';

COMMENT ON COLUMN cola.tficha.id_prioridad
IS 'Identificador de la tabla Prioridad';

COMMENT ON COLUMN cola.tficha.id_unidad
IS 'Identificador de la tabla Unidad';

COMMENT ON COLUMN cola.tficha.id_servicio
IS 'Identificador de la tabla Servicio';

COMMENT ON COLUMN cola.tficha.sigla
IS 'La sigla del servicio que se imprime en el ticket';

COMMENT ON COLUMN cola.tficha.numero
IS 'Numero de la ficha del servicio';

COMMENT ON COLUMN cola.tficha.peso
IS 'El peso de la ficha';

CREATE TABLE cola.tficha_estado (
  id_ficha_estado SERIAL,
  id_ficha INTEGER NOT NULL,
  estado VARCHAR,
  fecha_hora_inicio TIMESTAMP WITHOUT TIME ZONE,
  fecha_hora_fin TIMESTAMP WITHOUT TIME ZONE,
  id_tipo_ventanilla INTEGER,
  id_usuario_atencion INTEGER,
  numero_ventanilla INTEGER,
  CONSTRAINT tficha_estado_pkey PRIMARY KEY(id_ficha_estado)
) INHERITS (pxp.tbase)

WITH (oids = false);

COMMENT ON COLUMN cola.tficha_estado.id_ficha_estado
IS 'Identificador unico de la tabla';

COMMENT ON COLUMN cola.tficha_estado.id_ficha
IS 'Identificador de la tabla Ficha';

COMMENT ON COLUMN cola.tficha_estado.estado
IS 'Estado de la ficha';

COMMENT ON COLUMN cola.tficha_estado.fecha_hora_inicio
IS 'Fecha hora inicio del estado';

COMMENT ON COLUMN cola.tficha_estado.fecha_hora_fin
IS 'Fecha hora fin del estado';

COMMENT ON COLUMN cola.tficha_estado.id_tipo_ventanilla
IS 'Identificador de la tabla Tipo Ventanilla';

COMMENT ON COLUMN cola.tficha_estado.id_usuario_atencion
IS 'Identificador de la tabla Usuario';

COMMENT ON COLUMN cola.tficha_estado.numero_ventanilla
IS 'Numero de la ventanilla donde es atendido la ficha';

CREATE TABLE cola.tprioridad (
  id_prioridad SERIAL,
  nombre VARCHAR,
  descripcion VARCHAR,
  peso INTEGER,
  estado VARCHAR,
  CONSTRAINT tprioridad_pkey PRIMARY KEY(id_prioridad)
) INHERITS (pxp.tbase)

WITH (oids = false);

COMMENT ON COLUMN cola.tprioridad.id_prioridad
IS 'Identificador unico de la tabla';

COMMENT ON COLUMN cola.tprioridad.nombre
IS 'Nombre de la Prioridad';

COMMENT ON COLUMN cola.tprioridad.descripcion
IS 'Descripcion de la Prioridad';

COMMENT ON COLUMN cola.tprioridad.peso
IS 'Peso del registro de la Prioridad';

COMMENT ON COLUMN cola.tprioridad.estado
IS 'Estado del registro de la Prioridad';

CREATE TABLE cola.tservicio (
  id_servicio SERIAL,
  id_servicio_fk INTEGER,
  descripcion VARCHAR,
  nombre VARCHAR,
  peso INTEGER,
  CONSTRAINT tservicio_pkey PRIMARY KEY(id_servicio)
  
) INHERITS (pxp.tbase)

WITH (oids = false);

COMMENT ON COLUMN cola.tservicio.id_servicio
IS 'Identificador unico de la tabla';

COMMENT ON COLUMN cola.tservicio.id_servicio_fk
IS 'Identificador unico de la tabla Servicio, es una tabla recursiva';

COMMENT ON COLUMN cola.tservicio.descripcion
IS 'Descripcion del Servicio';

COMMENT ON COLUMN cola.tservicio.nombre
IS 'Nombre del Servicio';

COMMENT ON COLUMN cola.tservicio.peso
IS 'Peso del registro del Servicio';

CREATE TABLE cola.tsucursal (
  id_sucursal SERIAL,
  id_depto INTEGER NOT NULL,
  codigo VARCHAR,
  nombre VARCHAR,
  mensaje_imp VARCHAR,
  CONSTRAINT tsucursal_pkey PRIMARY KEY(id_sucursal)
) INHERITS (pxp.tbase)

WITH (oids = false);

COMMENT ON COLUMN cola.tsucursal.id_sucursal
IS 'Identificador unico de la tabla';

COMMENT ON COLUMN cola.tsucursal.id_depto
IS 'Identificador de la tabla Departamento';

COMMENT ON COLUMN cola.tsucursal.codigo
IS 'Código de la Sucursal';

COMMENT ON COLUMN cola.tsucursal.nombre
IS 'Nombre de la Sucursal';

COMMENT ON COLUMN cola.tsucursal.mensaje_imp
IS 'mensaje de impresion';

CREATE TABLE cola.tsucursal_servicio (
  id_sucursal_servicio SERIAL,
  id_sucursal INTEGER,
  id_servicio INTEGER,
  id_tipo_ventanilla INTEGER,
  sigla VARCHAR,
  peso INTEGER,
  estado VARCHAR,
  prioridades INTEGER[],
  CONSTRAINT tsucursal_servicio_pkey PRIMARY KEY(id_sucursal_servicio)
  
) INHERITS (pxp.tbase)

WITH (oids = false);

COMMENT ON COLUMN cola.tsucursal_servicio.id_sucursal_servicio
IS 'Identificador unico de la tabla';

COMMENT ON COLUMN cola.tsucursal_servicio.id_sucursal
IS 'Identificador de la tabla Sucursal';

COMMENT ON COLUMN cola.tsucursal_servicio.id_servicio
IS 'Identificador de la tabla Servicio';

COMMENT ON COLUMN cola.tsucursal_servicio.id_tipo_ventanilla
IS 'Identificador de la tabla Tipo Servicio';

COMMENT ON COLUMN cola.tsucursal_servicio.sigla
IS 'Sigla de la tabla compuesta  Sucursal Servicio';

COMMENT ON COLUMN cola.tsucursal_servicio.peso
IS 'Peso de la tabla compuesta  Sucursal Servicio';

COMMENT ON COLUMN cola.tsucursal_servicio.estado
IS 'Estado de la tabla compuesta  Sucursal Servicio';

CREATE TABLE cola.ttipo_ventanilla (
  id_tipo_ventanilla SERIAL,
  nombre VARCHAR,
  CONSTRAINT ttipo_ventanilla_pkey PRIMARY KEY(id_tipo_ventanilla)
) INHERITS (pxp.tbase)

WITH (oids = false);

COMMENT ON COLUMN cola.ttipo_ventanilla.id_tipo_ventanilla
IS 'Identificador unico de la tabla';

COMMENT ON COLUMN cola.ttipo_ventanilla.nombre
IS 'Nombre de la Sucursal';

/***********************************F-SCP-JMH-COLA-0-25/06/2016****************************************/
/***********************************I-SCP-JMH-COLA-0-28/06/2016****************************************/
ALTER TABLE cola.tprioridad
  ADD COLUMN sigla VARCHAR(3);
  
ALTER TABLE cola.tservicio
  ADD COLUMN sigla VARCHAR(3);

ALTER TABLE cola.tficha
  RENAME COLUMN id_unidad TO id_sucursal;

COMMENT ON COLUMN cola.tficha.id_sucursal
IS 'Identificador de la tabla Sucursal';  
/***********************************F-SCP-JMH-COLA-0-28/06/2016****************************************/
/***********************************I-SCP-JMH-COLA-0-11/07/2016****************************************/
ALTER TABLE cola.tsucursal_servicio
  ADD COLUMN digito INTEGER;

COMMENT ON COLUMN cola.tsucursal_servicio.digito
IS 'tamaño de digitos que tendra la numeracion de las fichas';

ALTER TABLE cola.tsucursal_servicio
  DROP COLUMN sigla;
  
  ALTER TABLE cola.tsucursal_servicio
  DROP COLUMN peso;
/***********************************F-SCP-JMH-COLA-0-11/07/2016****************************************/
/***********************************I-SCP-JMH-COLA-0-13/07/2016****************************************/
CREATE TABLE cola.tficha_historico (
  id_ficha SERIAL, 
  id_prioridad INTEGER NOT NULL, 
  id_sucursal INTEGER NOT NULL, 
  id_servicio INTEGER NOT NULL, 
  sigla VARCHAR, 
  numero INTEGER, 
  peso INTEGER, 
  CONSTRAINT tficha_historico_pkey PRIMARY KEY(id_ficha)
) INHERITS (pxp.tbase)
WITHOUT OIDS;

COMMENT ON COLUMN cola.tficha_historico.id_ficha
IS 'Identificador unico de la tabla';

COMMENT ON COLUMN cola.tficha_historico.id_prioridad
IS 'Identificador de la tabla Prioridad';

COMMENT ON COLUMN cola.tficha_historico.id_sucursal
IS 'Identificador de la tabla Sucursal';

COMMENT ON COLUMN cola.tficha_historico.id_servicio
IS 'Identificador de la tabla Servicio';

COMMENT ON COLUMN cola.tficha_historico.sigla
IS 'La sigla del servicio que se imprime en el ticket';

COMMENT ON COLUMN cola.tficha_historico.numero
IS 'Numero de la ficha del servicio';

COMMENT ON COLUMN cola.tficha_historico.peso
IS 'El peso de la ficha';


CREATE TABLE cola.tficha_estado_historico (
  id_ficha_estado SERIAL, 
  id_ficha INTEGER NOT NULL, 
  estado VARCHAR, 
  fecha_hora_inicio TIMESTAMP WITHOUT TIME ZONE, 
  fecha_hora_fin TIMESTAMP WITHOUT TIME ZONE, 
  id_tipo_ventanilla INTEGER, 
  id_usuario_atencion INTEGER, 
  numero_ventanilla INTEGER, 
  CONSTRAINT tficha_estado_historico_pkey PRIMARY KEY(id_ficha_estado)
) INHERITS (pxp.tbase)
WITHOUT OIDS;

COMMENT ON COLUMN cola.tficha_estado_historico.id_ficha_estado
IS 'Identificador unico de la tabla';

COMMENT ON COLUMN cola.tficha_estado_historico.id_ficha
IS 'Identificador de la tabla Ficha';

COMMENT ON COLUMN cola.tficha_estado_historico.estado
IS 'Estado de la ficha';

COMMENT ON COLUMN cola.tficha_estado_historico.fecha_hora_inicio
IS 'Fecha hora inicio del estado';

COMMENT ON COLUMN cola.tficha_estado_historico.fecha_hora_fin
IS 'Fecha hora fin del estado';

COMMENT ON COLUMN cola.tficha_estado_historico.id_tipo_ventanilla
IS 'Identificador de la tabla Tipo Ventanilla';

COMMENT ON COLUMN cola.tficha_estado_historico.id_usuario_atencion
IS 'Identificador de la tabla Usuario';

COMMENT ON COLUMN cola.tficha_estado_historico.numero_ventanilla
IS 'Numero de la ventanilla donde es atendido la ficha';
/***********************************F-SCP-JMH-COLA-0-13/07/2016****************************************/

/***********************************I-SCP-JMH-COLA-0-21/07/2016****************************************/
CREATE TABLE cola.tusuario_sucursal (
  id_usuario_sucursal SERIAL, 
  id_usuario INTEGER, 
  id_sucursal INTEGER, 
  servicios INTEGER[], 
  prioridades INTEGER[], 
  numero_ventanilla VARCHAR, 
  id_tipo_ventanilla INTEGER, 
  CONSTRAINT tusuario_sucursal_pkey PRIMARY KEY(id_usuario_sucursal)
) INHERITS (pxp.tbase)
WITHOUT OIDS;

COMMENT ON COLUMN cola.tusuario_sucursal.id_usuario_sucursal
IS 'ID unico de la tabla Usuario Sucursal';

/***********************************F-SCP-JMH-COLA-0-21/07/2016****************************************/

/***********************************I-SCP-JMH-COLA-0-25/07/2016****************************************/
ALTER TABLE cola.tficha_historico
  ADD COLUMN ultima_llamada TIMESTAMP(0) WITHOUT TIME ZONE;

ALTER TABLE cola.tficha_historico
  ALTER COLUMN ultima_llamada SET DEFAULT now();
ALTER TABLE cola.tficha_estado
  ALTER COLUMN numero_ventanilla TYPE VARCHAR(5);
ALTER TABLE cola.tficha_estado_historico
  ALTER COLUMN numero_ventanilla TYPE VARCHAR(5);
  
ALTER TABLE cola.tficha_estado
  ADD COLUMN id_servicio INTEGER[];
ALTER TABLE cola.tficha_estado_historico
  ADD COLUMN id_servicio INTEGER[];
/***********************************F-SCP-JMH-COLA-0-25/07/2016****************************************/

/***********************************I-SCP-FFP-COLA-0-17/05/2017****************************************/


CREATE TABLE cola.tmensaje (
  id_mensaje SERIAL,
  mensaje text,
  titulo VARCHAR(255),
  CONSTRAINT tmensaje_pkey PRIMARY KEY(id_mensaje)
) INHERITS (pxp.tbase);

CREATE TABLE cola.tsucursal_mensaje (
  id_sucursal_mensaje SERIAL,
  id_sucursal INTEGER,
  id_mensaje INTEGER,
  CONSTRAINT tsucursal_mensaje_pkey PRIMARY KEY(id_sucursal_mensaje)
) INHERITS (pxp.tbase);


/***********************************F-SCP-FFP-COLA-0-17/05/2017****************************************/

/***********************************I-SCP-JRR-COLA-0-20/05/2017****************************************/
ALTER TABLE cola.tsucursal
  ADD COLUMN servidor_remoto VARCHAR(30);
  
/***********************************F-SCP-JRR-COLA-0-20/05/2017****************************************/

/***********************************I-SCP-FFP-COLA-0-08/08/2017****************************************/
CREATE TABLE cola.tvideo (
  id_video SERIAL,
  descripcion varchar(255),
  CONSTRAINT tvideo_pkey PRIMARY KEY(id_video)
) INHERITS (pxp.tbase);


CREATE TABLE cola.tsucursal_video (
  id_sucursal_video SERIAL,
  id_sucursal INTEGER,
  id_video INTEGER,
  CONSTRAINT tsucursal_video_pkey PRIMARY KEY(id_sucursal_video)
) INHERITS (pxp.tbase);



/***********************************F-SCP-FFP-COLA-0-08/08/2017****************************************/
