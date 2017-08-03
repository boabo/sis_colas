
/***********************************I-DAT-JMH-COLA-0-09/07/2016****************************************/
INSERT INTO segu.tsubsistema ( "codigo", "nombre", "fecha_reg", "prefijo", "estado_reg", "nombre_carpeta", "id_subsis_orig")
VALUES ( E'COLA', E'Sistema de Colas', E'2016-06-15', E'COLA', E'activo', E'colas', NULL);
/***********************************F-DAT-JMH-COLA-0-09/07/2016****************************************/

/***********************************I-DAT-JMH-COLA-1-09/07/2016****************************************/

select pxp.f_insert_tgui ('SISTEMA DE COLAS', '', 'COLA', 'si', 1, '', 1, '', '', 'COLA');
select pxp.f_insert_tgui ('PARAMETROS', 'Parametros del sistema', 'PARCOL', 'si', 1, '', 2, '', '', 'COLA');
select pxp.f_insert_tgui ('Prioridades', 'Prioridades del servicio', 'priori', 'si', 1, 'sis_colas/vista/prioridad/Prioridad.php', 3, '', 'Prioridad', 'COLA');
select pxp.f_insert_tgui ('Servicios', 'Servicios de atencion', 'servi', 'si', 2, 'sis_colas/vista/servicio/Servicio.php', 3, '', 'Servicio', 'COLA');
select pxp.f_insert_tgui ('Sucursales', 'Sucursales de la empresa', 'sucur', 'si', 3, 'sis_colas/vista/sucursal/Sucursal.php', 3, '', 'Sucursal', 'COLA');
select pxp.f_insert_tgui ('Tipos  Ventanilla', 'Tipos de ventanilla', 'tipven', 'si', 4, 'sis_colas/vista/tipo_ventanilla/TipoVentanilla.php', 3, '', 'TipoVentanilla', 'COLA');
select pxp.f_insert_tgui ('PROCESOS', 'Procesos del sistema', 'PROCOL', 'si', 2, '', 2, '', '', 'COLA');
select pxp.f_insert_tgui ('Servicios Sucursal', 'Servicios por sucursal', 'sersur', 'si', 1, 'sis_colas/vista/sucursal_servicio/SucursalServicio.php', 3, '', 'SucursalServicio', 'COLA');
select pxp.f_insert_tgui ('Ficha', 'fichas', 'ficha', 'si', 3, 'sis_colas/vista/ficha/FichaInicio.php', 3, '', 'FichaInicio', 'COLA');

/***********************************F-DAT-JMH-COLA-1-09/07/2016****************************************/
/***********************************I-DAT-JMH-COLA-0-11/07/2016****************************************/
INSERT INTO cola.tprioridad ("id_usuario_reg", "id_usuario_mod", "fecha_reg", "fecha_mod", "estado_reg", "id_usuario_ai", "usuario_ai", "nombre", "descripcion", "peso", "estado", "sigla")
VALUES (1, NULL, E'2016-06-28 01:44:17.450', NULL, E'activo', NULL, E'NULL', E'Tercera edad', E'Tercera edad', 5, E'habilitado', E'VJ');

INSERT INTO cola.tprioridad ("id_usuario_reg", "id_usuario_mod", "fecha_reg", "fecha_mod", "estado_reg", "id_usuario_ai", "usuario_ai", "nombre", "descripcion", "peso", "estado", "sigla")
VALUES (1, NULL, E'2016-06-28 03:30:47.162', NULL, E'activo', NULL, E'NULL', E'Mujeres embarazadas o con niño', E'Mujeres embarazadas o con niño', 4, E'habilitado', E'EM');

INSERT INTO cola.tprioridad ("id_usuario_reg", "id_usuario_mod", "fecha_reg", "fecha_mod", "estado_reg", "id_usuario_ai", "usuario_ai", "nombre", "descripcion", "peso", "estado", "sigla")
VALUES (1, 1, E'2016-06-28 03:31:16.497', E'2016-06-28 03:31:25.766', E'activo', NULL, E'NULL', E'Normal', E'normal', 1, E'habilitado', E'N');

INSERT INTO cola.tservicio ("id_usuario_reg", "id_usuario_mod", "fecha_reg", "fecha_mod", "estado_reg", "id_usuario_ai", "usuario_ai", "id_servicio_fk", "descripcion", "nombre", "peso", "sigla")
VALUES (1, NULL, E'2016-06-28 13:17:16.239', NULL, E'activo', NULL, E'NULL', NULL, E'tramites', E'Tramites', 4, E'T');

INSERT INTO cola.tservicio ("id_usuario_reg", "id_usuario_mod", "fecha_reg", "fecha_mod", "estado_reg", "id_usuario_ai", "usuario_ai", "id_servicio_fk", "descripcion", "nombre", "peso", "sigla")
VALUES (1, NULL, E'2016-06-28 10:58:12.826', NULL, E'activo', NULL, E'NULL', NULL, E'reclamos', E'Reclamos', 2, E'R');

INSERT INTO cola.tservicio ("id_usuario_reg", "id_usuario_mod", "fecha_reg", "fecha_mod", "estado_reg", "id_usuario_ai", "usuario_ai", "id_servicio_fk", "descripcion", "nombre", "peso", "sigla")
VALUES (1, NULL, E'2016-06-28 11:31:33.628', NULL, E'activo', NULL, E'NULL', 2, E'Artefactos dañados', E'Artefactos Dañados', 2, E'AD');

INSERT INTO cola.tservicio ("id_usuario_reg", "id_usuario_mod", "fecha_reg", "fecha_mod", "estado_reg", "id_usuario_ai", "usuario_ai", "id_servicio_fk", "descripcion", "nombre", "peso", "sigla")
VALUES (1, NULL, E'2016-06-28 11:34:02.933', NULL, E'activo', NULL, E'NULL', 2, E'artefacto dañado', E'Artefacto dañado', 2, E'AQ');

INSERT INTO cola.tservicio ("id_usuario_reg", "id_usuario_mod", "fecha_reg", "fecha_mod", "estado_reg", "id_usuario_ai", "usuario_ai", "id_servicio_fk", "descripcion", "nombre", "peso", "sigla")
VALUES (1, NULL, E'2016-06-28 10:55:38.922', NULL, E'activo', NULL, E'NULL', NULL, E'Atención al cliente', E'Atención al Cliente', 1, E'AC');


INSERT INTO cola.tsucursal ("id_usuario_reg", "id_usuario_mod", "fecha_reg", "fecha_mod", "estado_reg", "id_usuario_ai", "usuario_ai", "id_depto", "codigo", "nombre", "mensaje_imp")
VALUES (1, NULL, E'2016-06-28 15:45:39.747', NULL, E'activo', NULL, E'NULL', 1, E'CB', E'Oficina Chapare', E'Sucursal Chapare');

INSERT INTO cola.tsucursal ("id_usuario_reg", "id_usuario_mod", "fecha_reg", "fecha_mod", "estado_reg", "id_usuario_ai", "usuario_ai", "id_depto", "codigo", "nombre", "mensaje_imp")
VALUES (1, 1, E'2016-06-28 15:27:12.789', E'2016-06-28 15:45:57.354', E'activo', NULL, E'NULL', 1, E'CB', E'Oficina Central', E'Oficina Central');


INSERT INTO cola.ttipo_ventanilla ("id_usuario_reg", "id_usuario_mod", "fecha_reg", "fecha_mod", "estado_reg", "id_usuario_ai", "usuario_ai", "nombre")
VALUES (1, 1, E'2016-06-28 16:31:10.866', E'2016-06-28 16:34:48.274', E'activo', NULL, E'NULL', E'Plataformas');

INSERT INTO cola.ttipo_ventanilla ("id_usuario_reg", "id_usuario_mod", "fecha_reg", "fecha_mod", "estado_reg", "id_usuario_ai", "usuario_ai", "nombre")
VALUES (1, NULL, E'2016-06-28 16:43:27.552', NULL, E'activo', NULL, E'NULL', E'Cajas');

/***********************************F-DAT-JMH-COLA-0-11/07/2016****************************************/

/***********************************I-DAT-JMH-COLA-0-27/07/2016****************************************/
select pxp.f_insert_tgui ('SISTEMA DE COLAS', '', 'COLA', 'si', 1, '', 1, '', '', 'COLA');
select pxp.f_insert_tgui ('PARAMETROS', 'Parametros del sistema', 'PARCOL', 'si', 1, '', 2, '', '', 'COLA');
select pxp.f_insert_tgui ('Prioridades', 'Prioridades del servicio', 'priori', 'si', 1, 'sis_colas/vista/prioridad/Prioridad.php', 3, '', 'Prioridad', 'COLA');
select pxp.f_insert_tgui ('Servicios', 'Servicios de atencion', 'servi', 'si', 2, 'sis_colas/vista/servicio/Servicio.php', 3, '', 'Servicio', 'COLA');
select pxp.f_insert_tgui ('Sucursales', 'Sucursales de la empresa', 'sucur', 'si', 3, 'sis_colas/vista/sucursal/Sucursal.php', 3, '', 'Sucursal', 'COLA');
select pxp.f_insert_tgui ('Tipos  Ventanilla', 'Tipos de ventanilla', 'tipven', 'si', 4, 'sis_colas/vista/tipo_ventanilla/TipoVentanilla.php', 3, '', 'TipoVentanilla', 'COLA');
select pxp.f_insert_tgui ('PROCESOS', 'Procesos del sistema', 'PROCOL', 'si', 2, '', 2, '', '', 'COLA');
select pxp.f_insert_tgui ('Servicios Sucursal', 'Servicios por sucursal', 'sersur', 'si', 1, 'sis_colas/vista/sucursal_servicio/SucursalServicio.php', 3, '', 'SucursalServicio', 'COLA');
select pxp.f_insert_tgui ('Ficha', 'fichas', 'ficha', 'si', 3, 'sis_colas/vista/ficha/FichaInicio.php', 3, '', 'FichaInicio', 'COLA');
select pxp.f_insert_tgui ('Ficha Atención', 'Fichas para atención', 'FICATE', 'si', 3, 'sis_colas/vista/ficha/FichaAtencion.php', 3, '', 'FichaAtencion', 'COLA');
select pxp.f_insert_tgui ('Usuarios x Sucursal', 'Usuarios que estan en la sucural', 'USUSUC', 'si', 5, 'sis_colas/vista/usuario_sucursal/UsuarioSucursal.php', 3, '', 'UsuarioSucursal', 'COLA');
select pxp.f_insert_tgui ('Persona', 'Persona', 'PERSO', 'si', 1, 'sis_seguridad/vista/persona/Persona.php', 3, '', 'persona', 'COLA');
select pxp.f_insert_tgui ('Usuarios', 'Usuarios', 'USUA', 'si', 2, 'sis_seguridad/vista/usuario/Usuario.php', 3, '', 'usuario', 'COLA');
select pxp.f_insert_tgui ('Atencion', 'Atencion', 'FICATE.1', 'no', 0, 'sis_colas/vista/ficha/FormularioAtencion.php', 4, '', '90%', 'COLA');
select pxp.f_insert_tgui ('Subir foto', 'Subir foto', 'PERSO.1', 'no', 0, 'sis_seguridad/vista/persona/subirFotoPersona.php', 4, '', 'subirFotoPersona', 'COLA');
select pxp.f_insert_tgui ('Personas', 'Personas', 'USUA.1', 'no', 0, 'sis_seguridad/vista/persona/Persona.php', 4, '', 'persona', 'COLA');
select pxp.f_insert_tgui ('Roles', 'Roles', 'USUA.2', 'no', 0, 'sis_seguridad/vista/usuario_rol/UsuarioRol.php', 4, '', 'usuario_rol', 'COLA');
select pxp.f_insert_tgui ('EP\', 'EP\', 'USUA.3', 'no', 0, 'sis_seguridad/vista/usuario_grupo_ep/UsuarioGrupoEp.php', 4, '', ', 
          width:400,
          cls:', 'COLA');
select pxp.f_insert_tgui ('Subir foto', 'Subir foto', 'USUA.1.1', 'no', 0, 'sis_seguridad/vista/persona/subirFotoPersona.php', 5, '', 'subirFotoPersona', 'COLA');
/***********************************F-DAT-JMH-COLA-0-27/07/2016****************************************/


/***********************************I-DAT-JRR-COLA-0-01/08/2016****************************************/
select pxp.f_insert_tgui ('REPORTES', 'REPORTES COLAS', 'REPCOL', 'si', 3, '', 2, '', '', 'COLA');
select pxp.f_insert_tgui ('Tickets Atendidos', 'Tickets Atendidos', 'REPCOLTIC', 'si', 1, 'sis_colas/vista/reportes/FormTicketsAtendidos.php', 3, '', 'FormTicketsAtendidos', 'COLA');
select pxp.f_insert_tgui ('Tickets en Atencion', 'Tickets en Atencion', 'REPCOLTICATE', 'si', 2, 'sis_colas/vista/reportes/FormTicketsAtencion.php', 3, '', 'FormTicketsAtencion', 'COLA');
select pxp.f_insert_testructura_gui ('REPCOL', 'COLA');
select pxp.f_insert_testructura_gui ('REPCOLTIC', 'REPCOL');
select pxp.f_insert_testructura_gui ('REPCOLTICATE', 'REPCOL');
/***********************************F-DAT-JRR-COLA-0-01/08/2016****************************************/

/***********************************I-DAT-JMH-COLA-0-31/07/2016****************************************/
select pxp.f_insert_tgui ('SISTEMA DE COLAS', '', 'COLA', 'si', 1, '', 1, '../../../lib/imagenes/colas.png', '', 'COLA');
select pxp.f_insert_tfuncion ('cola.ft_usuario_sucursal_ime', 'Funcion para tabla     ', 'COLA');
select pxp.f_insert_tfuncion ('cola.f_obtener_servicios', 'Funcion para tabla     ', 'COLA');
select pxp.f_insert_tfuncion ('cola.f_obtener_prioridades', 'Funcion para tabla     ', 'COLA');
select pxp.f_insert_tfuncion ('cola.ft_usuario_sucursal_sel', 'Funcion para tabla     ', 'COLA');
select pxp.f_insert_tfuncion ('cola.ft_servicio_ime', 'Funcion para tabla     ', 'COLA');
select pxp.f_insert_tfuncion ('cola.ft_servicio_sel', 'Funcion para tabla     ', 'COLA');
select pxp.f_insert_tfuncion ('cola.ft_tipo_ventanilla_sel', 'Funcion para tabla     ', 'COLA');
select pxp.f_insert_tfuncion ('cola.ft_tipo_ventanilla_ime', 'Funcion para tabla     ', 'COLA');
select pxp.f_insert_tfuncion ('cola.ft_sucursal_servicio_ime', 'Funcion para tabla     ', 'COLA');
select pxp.f_insert_tfuncion ('cola.ft_prioridad_sel', 'Funcion para tabla     ', 'COLA');
select pxp.f_insert_tfuncion ('cola.ft_ficha_sel', 'Funcion para tabla     ', 'COLA');
select pxp.f_insert_tfuncion ('cola.ft_sucursal_ime', 'Funcion para tabla     ', 'COLA');
select pxp.f_insert_tfuncion ('cola.ft_ficha_ime', 'Funcion para tabla     ', 'COLA');
select pxp.f_insert_tfuncion ('cola.ft_prioridad_ime', 'Funcion para tabla     ', 'COLA');
select pxp.f_insert_tfuncion ('cola.ft_sucursal_servicio_sel', 'Funcion para tabla     ', 'COLA');
select pxp.f_insert_tfuncion ('cola.f_obtener_num_ficha', 'Funcion para tabla     ', 'COLA');
select pxp.f_insert_tfuncion ('cola.ft_sucursal_sel', 'Funcion para tabla     ', 'COLA');
/***********************************F-DAT-JMH-COLA-0-31/07/2016****************************************/

/***********************************I-DAT-JRR-COLA-0-02/08/2016****************************************/

select pxp.f_insert_tgui ('Tiempos de Arribo', 'Tiempos de Arribo', 'REPTIEARRI', 'si', 3, 'sis_colas/vista/reportes/FormTiemposArribo.php', 3, '', 'FormTiemposArribo', 'COLA');
select pxp.f_insert_tgui ('Tiempos de Espera', 'Tiempos de Espera', 'REPTIEESP', 'si', 4, 'sis_colas/vista/reportes/FormTiemposEspera.php', 3, '', 'FormTiemposEspera', 'COLA');
select pxp.f_insert_tgui ('Historico de Fichas', 'Historico de Fichas', 'REPHIFIC', 'si', 6, 'sis_colas/vista/reportes/FormHistoricoFichas.php',3, '', 'FormHistoricoFichas', 'COLA');

select pxp.f_insert_testructura_gui ('REPTIEARRI', 'REPCOL');
select pxp.f_insert_testructura_gui ('REPTIEESP', 'REPCOL');
select pxp.f_insert_testructura_gui ('REPHIFIC', 'REPCOL');
/***********************************F-DAT-JRR-COLA-0-02/08/2016****************************************/

/***********************************I-DAT-JMH-COLA-0-07/08/2016****************************************/
select pxp.f_insert_tgui ('Tickets Atendidos: ', 'Tickets Atendidos: ', 'REPCOLTIC.1', 'no', 0, 'sis_colas/vista/reportes/GridTicketsAtendidos.php', 4, '', '90%', 'COLA');
select pxp.f_insert_tgui ('Tickets en Atencion: ', 'Tickets en Atencion: ', 'REPCOLTICATE.1', 'no', 0, 'sis_colas/vista/reportes/GridTicketsAtencion.php', 4, '', '90%', 'COLA');
select pxp.f_insert_tgui ('Tiempos de arribo : ', 'Tiempos de arribo : ', 'REPTIEARRI.1', 'no', 0, 'sis_colas/vista/reportes/GridTiemposArribo.php', 4, '', '90%', 'COLA');
select pxp.f_insert_tgui ('Tiempos de espera : ', 'Tiempos de espera : ', 'REPTIEESP.1', 'no', 0, 'sis_colas/vista/reportes/GridTiemposEspera.php', 4, '', '90%', 'COLA');
select pxp.f_insert_tgui ('Historico Fichas : ', 'Historico Fichas : ', 'REPHIFIC.1', 'no', 0, 'sis_colas/vista/reportes/GridHistoricoFichas.php', 4, '', '90%', 'COLA');
select pxp.f_insert_tgui ('Fichas No Show', 'Fichas que fueron pasadas', 'FICNOS', 'si', 4, 'sis_colas/vista/ficha/FichaNoShow.php', 3, '', 'FichaNoShow', 'COLA');
select pxp.f_insert_tfuncion ('cola.ft_reporte_sel', 'Funcion para tabla     ', 'COLA');
select pxp.f_insert_tfuncion ('cola.f_resetear_fichas', 'Funcion para tabla     ', 'COLA');
select pxp.f_insert_testructura_gui ('REPCOLTIC.1', 'REPCOLTIC');
select pxp.f_insert_testructura_gui ('REPCOLTICATE.1', 'REPCOLTICATE');
select pxp.f_insert_testructura_gui ('REPTIEARRI.1', 'REPTIEARRI');
select pxp.f_insert_testructura_gui ('REPTIEESP.1', 'REPTIEESP');
select pxp.f_insert_testructura_gui ('REPHIFIC.1', 'REPHIFIC');
select pxp.f_insert_testructura_gui ('FICNOS', 'PROCOL');
/***********************************F-DAT-JMH-COLA-0-07/08/2016****************************************/

/***********************************I-DAT-JRR-COLA-0-04/09/2016****************************************/

select pxp.f_insert_tgui ('Cuadro I', 'Cuadro I', 'REPCUAI', 'si', 7, 'sis_colas/vista/reportes/FormCuadroI.php', 3, '', 'FormCuadroI', 'COLA');
select pxp.f_insert_testructura_gui ('REPCUAI', 'REPCOL');

select pxp.f_insert_tgui ('Cuadro V (Tiempos de espera) : ', 'Tiempos de espera : ', 'REPTIEESP.1', 'no', 0, 'sis_colas/vista/reportes/GridTiemposEspera.php', 4, '', '90%', 'COLA');

select pxp.f_insert_tgui ('Cuadro IV (Atencion por Tramite)', 'Tickets Atendidos', 'REPCOLTIC', 'si', 1, 'sis_colas/vista/reportes/FormTicketsAtendidos.php', 3, '', 'FormTicketsAtendidos', 'COLA');
select pxp.f_delete_testructura_gui ('REPCOLTICATE', 'REPCOL');
select pxp.f_delete_tgui ('REPCOLTICATE');
/***********************************F-DAT-JRR-COLA-0-04/09/2016****************************************/

/***********************************I-DAT-JRR-COLA-0-05/09/2016****************************************/

select pxp.f_insert_tgui ('Cuadro II y III', 'Cuadro II y III', 'REPCUAII', 'si', 8, 'sis_colas/vista/reportes/FormCuadroII.php', 3, '', 'FormCuadroII', 'COLA');
select pxp.f_insert_testructura_gui ('REPCUAII', 'REPCOL');

/***********************************F-DAT-JRR-COLA-0-05/09/2016****************************************/

/***********************************I-DAT-JMH-COLA-0-15/03/2017****************************************/
update segu.tprocedimiento SET habilita_log= 'no' where codigo='COLA_ficha_SEL';
update segu.tprocedimiento SET habilita_log= 'no' where codigo='COLA_ficha_CONT';
update segu.tprocedimiento SET habilita_log= 'no' where codigo='COLA_llapan_SEL';
/***********************************F-DAT-JMH-COLA-0-15/03/2017****************************************/


/***********************************I-DAT-FFP-COLA-0-17/05/2017****************************************/

select pxp.f_insert_tgui ('Mensaje', 'Mensaje', 'MENSA', 'si', 6, 'sis_colas/vista/mensaje/Mensaje.php', 3, '', 'Mensaje', 'COLA');


/***********************************F-DAT-FFP-COLA-0-17/05/2017****************************************/

/***********************************I-DAT-FFP-COLA-0-19/05/2017****************************************/

INSERT INTO param.ttipo_archivo (id_usuario_reg, id_usuario_mod, fecha_reg, fecha_mod, estado_reg, id_usuario_ai, usuario_ai,  nombre_id, tipo_archivo, tabla, codigo, nombre, multiple, extensiones_permitidas, ruta_guardar) VALUES (1, null, '2017-05-16 09:07:27.803243', null, 'activo', null, 'NULL',  'id_sucursal', 'documento', 'tsucursal', 'videoSuc', 'videoSuc', 'si', 'mp4,MP4', '');


/***********************************F-DAT-FFP-COLA-0-19/05/2017****************************************/

