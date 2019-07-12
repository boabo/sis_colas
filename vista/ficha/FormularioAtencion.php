<?php
/**
 * @package pXP
 * @file    ItemEntRec.php
 * @author  RCM
 * @date    07/08/2013
 * @description Reporte Material Entregado/Recibido
 */
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
    var control;
    Phx.vista.FormularioAtencion = Ext.extend(Phx.frmInterfaz, {

        Atributos: [


            {
                //configuracion del componente
                config: {
                    labelSeparator: '',
                    inputType: 'hidden',
                    name: 'id_ficha'
                },
                type: 'Field',
                form: true
            },

            {
                //configuracion del componente
                config: {
                    labelSeparator: '',
                    name: 'id_servicio',
                    inputType: 'hidden'

                },
                type: 'Field',
                form: true
            },

            {
                //configuracion del componente
                config: {
                    labelSeparator: '',
                    name: 'letra_ventanila',
                    inputType: 'hidden'

                },
                type: 'Field',
                form: true
            },


            {
                config: {
                    name: 'sigla',
                    fieldLabel: 'Ficha',
                    allowBlank: true,
                    anchor: '80%',

                    readOnly: true

                },
                type: 'TextField',
                id_grupo: 0,
                form: true
            },
            {
                config: {
                    name: 'nombre_servi',
                    fieldLabel: 'Servicio',
                    allowBlank: true,
                    anchor: '80%'

                },
                type: 'TextField',
                id_grupo: 0,
                form: true
            },

            {
                config: {
                    name: 'nombre_priori',
                    fieldLabel: 'Ficha',
                    allowBlank: true,
                    anchor: '80%'
                },
                type: 'TextField',
                id_grupo: 0,
                form: true
            },

            {
                config: {
                    name: 'fecha_hora_inicio',
                    fieldLabel: 'Hora Llegada.',
                    allowBlank: true,
                    anchor: '80%',

                },
                type: 'TextField',
                id_grupo: 0,
                form: true
            },
            {
                config: {
                    name: 'minutos',
                    fieldLabel: 'Minutos Espera',
                    allowBlank: true,
                    anchor: '80%'
                },
                type: 'TextField',
                id_grupo: 0,
                form: true
            },
            {
                config: {
                    name: 'estado_ficha',
                    fieldLabel: 'Estado Ficha',
                    allowBlank: true,
                    anchor: '80%'
                },
                type: 'TextField',
                id_grupo: 0,
                form: true
            },
            {
                config: {
                    name: 'ids_servicio',
                    fieldLabel: 'Servicios',
                    allowBlank: false,
                    emptyText: 'Servicios...',
                    store: new Ext.data.JsonStore({
                        url: '../../sis_colas/control/Servicio/listarServicioUsuario',
                        id: 'id_servicio',
                        root: 'datos',
                        sortInfo: {
                            field: 'id_servicio',
                            direction: 'DESC'
                        },
                        totalProperty: 'total',
                        fields: ['id_servicio', 'descripcion'],
                        // turn on remote sorting
                        remoteSort: true,
                        baseParams: {par_filtro: 'serv.descripcion'}

                    }),
                    valueField: 'id_servicio',
                    displayField: 'descripcion',
                    forceSelection: true,
                    typeAhead: true,
                    triggerAction: 'all',
                    lazyRender: true,
                    mode: 'remote',
                    pageSize: 50,
                    queryDelay: 1000,
                    width: 400,
                    minChars: 2,
                    enableMultiSelect: true
                    //tpl:'<tpl for="."><div class="x-combo-list-item"><p><b>{des_hijo}</b></p><p>Pertenece a :{des_padre}</p> </div></tpl>'
                },
                type: 'AwesomeCombo',
                id_grupo: 0,
                grid: true,
                form: true
            },

            {
                config: {
                    name: 'cronometro',
                    fieldLabel: 'Tiempo Atención',
                    allowBlank: true,
                    anchor: '50%',
                    style: {color: 'red', width: '95%'}
                },
                type: 'TextField',
                id_grupo: 1,
                form: true
            },
            {
                config: {
                    name: 'deriva',
                    fieldLabel: 'Derivar?',
                    gwidth: 100,
                    items: [
                        {boxLabel: 'Si', name: 'trg-auto', inputValue: 'Si'},
                        {boxLabel: 'No', name: 'trg-auto', inputValue: 'No', checked: true}

                    ]
                },
                type: 'RadioGroupField',
                id_grupo: 0,
                grid: false,
                form: true
            },
            {
                config: {
                    name: 'id_usuario',
                    fieldLabel: 'Ejecutivo',
                    allowBlank: true,
                    emptyText: 'Ejecutivos...',
                    store: new Ext.data.JsonStore({
                        url: '../../sis_colas/control/UsuarioSucursal/listarUsuarioSucursal',
                        id: 'id_usario',
                        root: 'datos',
                        sortInfo: {
                            field: 'id_usuario',
                            direction: 'DESC'
                        },
                        totalProperty: 'total',
                        fields: ['id_usuario', 'desc_persona'],
                        // turn on remote sorting
                        remoteSort: true,
                        baseParams: {par_filtro: 'desc_persona',filtro_usuario:'diferente'}

                    }),
                    valueField: 'id_usuario',
                    displayField: 'desc_persona',
                    forceSelection: true,
                    typeAhead: true,
                    triggerAction: 'all',
                    lazyRender: true,
                    mode: 'remote',
                    pageSize: 50,
                    queryDelay: 1000,
                    width: 400,
                    minChars: 2,
                    enableMultiSelect: false
                },
                type: 'AwesomeCombo',
                id_grupo: 0,
                grid: true,
                form: true
            },
            {
                config: {
                    name: 'id_servicio_der',
                    fieldLabel: 'Servicio A derivar',
                    allowBlank: true,
                    emptyText: 'Servicios...',
                    store: new Ext.data.JsonStore({
                        url: '../../sis_colas/control/SucursalServicio/listarSucursalServicio',
                        id: 'id_servicio',
                        root: 'datos',
                        sortInfo: {
                            field: 'nombre_servi',
                            direction: 'ASC'
                        },
                        totalProperty: 'total',
                        fields: ['id_servicio', 'nombre_servi'],
                        // turn on remote sorting
                        remoteSort: true,
                        baseParams: {par_filtro: 'servi.nombre'}

                    }),
                    valueField: 'id_servicio',
                    displayField: 'nombre_servi',
                    forceSelection: false,
                    typeAhead: true,
                    triggerAction: 'all',
                    lazyRender: true,
                    mode: 'remote',
                    pageSize: 30,
                    queryDelay: 1000,
                    width: 400,
                    gwidth: 400,
                    minChars: 2,
                    enableMultiSelect: false,


                    renderer: function (value, p, record) {
                        return String.format('{0}', record.data['nombres_servicio']);
                    }

                },
                type: 'ComboBox',
                id_grupo: 0,
                grid: true,
                form: true
            },
        ],
        title: 'Atencion',
        topBar: true,
        botones: false,
        bsubmit: false,
        breset: false,
        closable: true,
        closeAction: 'hide',
        constructor: function (config) {
            Phx.vista.FormularioAtencion.superclass.constructor.call(this, config);
            this.init();

            this.datos = config.datos;
            this.Cmp.sigla.setValue(this.datos.sigla);
            this.Cmp.id_ficha.setValue(this.datos.id_ficha);
            this.Cmp.id_servicio.setValue(this.datos.id_servicio);
            this.Cmp.nombre_servi.setValue(this.datos.nombre_servi);
            this.Cmp.nombre_priori.setValue(this.datos.nombre_priori);
            this.Cmp.fecha_hora_inicio.setValue(this.datos.fecha_hora_inicio);
            this.Cmp.minutos.setValue(this.datos.minutos);
            this.Cmp.estado_ficha.setValue(this.datos.estado_ficha);
            this.Cmp.ids_servicio.disable();
            this.Cmp.id_usuario.disable();
            this.Cmp.cronometro.disable();
            this.Cmp.id_servicio_der.disable();
            this.getBoton('derivar').disable();
            this.getBoton('finalizar').disable();
            this.getBoton('no_show').disable();
            this.Cmp.deriva.setVisible(false);
            this.Cmp.ids_servicio.setVisible(false);
            this.Cmp.cronometro.setVisible(false);
            this.Cmp.id_usuario.setVisible(false);
            this.Cmp.id_servicio_der.setVisible(false);


            this.Cmp.letra_ventanila.setValue(this.datos.letra_ventanila);


            this.iniciarEventos();

            //this.onEsc();




            //mandamos mensaje por el socket para que actualizen los demas sus pantallas de administradores
            var data = {
                "evento": "sis_colas/nuevosTickets/" + this.datos.id_sucursal + "",
                "mensaje": "tienes nuevo ticket campeon"
            };
            //crear json
            var json = JSON.stringify({
                data: data,
                tipo: "enviarMensaje"

            });

            Phx.CP.webSocket.conn.send(json);


        },
        iniciarEventos: function () {
            this.cmpDeriva = this.getComponente('deriva');
            this.cmpDeriva.on('change', function (f) {
                //alert (this.cmpPruebaPasiva.getValue());
                if (this.cmpDeriva.getValue() == 'Si') {
                    this.Cmp.id_servicio_der.setValue(this.Cmp.id_servicio.getValue());

                    // 			this.Cmp.id_servicio_der.setValue(this.Cmp.id_servicio.getValue());
                    this.Cmp.id_servicio_der.fireEvent('select', this.Cmp.id_servicio_der, this.Cmp.id_servicio_der.store.getById(this.Cmp.id_servicio.getValue()));

                    this.Cmp.id_usuario.setVisible(true);
                    this.Cmp.id_usuario.enable();
                    this.Cmp.id_usuario.allowBlank = false;
                    this.Cmp.id_servicio_der.setVisible(true);
                    this.Cmp.id_servicio_der.enable();
                    this.Cmp.id_servicio_der.allowBlank = false;
                    this.getBoton('finalizar').disable();
                    this.getBoton('derivar').enable();
                }
                else if (this.cmpDeriva.getValue() == 'No') {
                    this.getBoton('finalizar').enable();
                    this.Cmp.id_usuario.setVisible(false);
                    this.Cmp.id_servicio_der.setVisible(false);
                    this.getBoton('derivar').disable();
                }

                else {
                    alert(this.cmpDeriva.getValue());
                }
            }, this);

        },
        tipo: 'frmInterfaz',


        defineMenu: function () {
            var cbuttons = [], me = this;
            // definicion de la barra de menu


            //cbuttons.push(['Impirmir']);

            cbuttons.push({
                id: 'b-rellamar-' + me.idContenedor,
                //icon: me.iconSubmit, // icons can also be specified inline
                tooltip: 'Volver a llamar',          // <-- Add the action directly to a menu
                handler: this.onRellamar,
                text: 'Volver a llamar',
                scope: this,
                iconCls: 'brellamada'
            });

            cbuttons.push({
                id: 'b-iniciar-' + me.idContenedor,
                //icon: me.iconSubmit, // icons can also be specified inline
                tooltip: 'Iniciar Atencion',          // <-- Add the action directly to a menu
                handler: this.onIniciarAtencion,
                text: 'Iniciar Atencion',
                scope: this,
                iconCls: 'batencion'
            });

            cbuttons.push({
                id: 'b-derivar-' + me.idContenedor,
                //icon: me.iconSubmit, // icons can also be specified inline
                tooltip: 'Derivar Ficha',          // <-- Add the action directly to a menu
                handler: this.onDerivar,
                text: 'Derivar Ficha',
                scope: this,
                iconCls: 'bderivar'
            });

            cbuttons.push({
                id: 'b-finalizar-' + me.idContenedor,
                //icon: me.iconSubmit, // icons can also be specified inline
                tooltip: 'Finalizar Atencion',          // <-- Add the action directly to a menu
                handler: this.onFinalizar,
                text: 'Finalizar Atencion',
                scope: this,
                iconCls: 'bstop'
            });

            cbuttons.push({
                id: 'b-no_show-' + me.idContenedor,
                //icon: me.iconSubmit, // icons can also be specified inline
                tooltip: 'No se Presento',          // <-- Add the action directly to a menu
                handler: this.onNoShow,
                text: 'No se Presento',
                scope: this,
                iconCls: 'bcancelar'
            });

            me.tbar = new Ext.Toolbar({defaults: {scale: 'large', cls: 'x-btn-text-icon bmenu'}, items: cbuttons});
        },

        preparaMenu: function (n) {
            var data = this.getSelectedData();
            var tb = this.tbar;
            ///echo ('entra al prepara');exit;
            Phx.vista.FormularioAtencion.superclass.preparaMenu.call(this, n);
            if (data['estado_ficha'] == 'en_atencion') {
                this.getBoton('rellamar').disable();
                this.getBoton('iniciar').disable();
            }
            ;
            if (data['estado_ficha'] == 'llamado') {
                this.getBoton('rellamar').enable();
                this.getBoton('iniciar').ebable();
                this.getBoton('derivar').disable();
                this.getBoton('finalizar').disable();
            }
            /*else{
             this.getBoton('rellamar').enable();
             }*/

        },

        onRellamar: function () {
            Phx.CP.loadingShow();
            Ext.Ajax.request({
                url: '../../sis_colas/control/Ficha/rellamadaFicha',
                params: {
                    id_ficha: this.Cmp.id_ficha.getValue(),
                    id_sucursal: this.datos.id_sucursal
                },
                success: this.successRellamada,
                failure: this.conexionFailure,
                timeout: this.timeout,
                scope: this
            });

            //mandamos mensaje por el socket

            var ficha = {
                estado_ficha: this.Cmp.estado_ficha.getValue(),
                fecha_hora_inicio: this.Cmp.fecha_hora_inicio.getValue(),
                id_ficha: this.Cmp.id_ficha.getValue(),
                id_servicio:this.Cmp.id_servicio.getValue(),
                id_sucursal: this.datos.id_sucursal,
                letra_ventanila: this.Cmp.letra_ventanila.getValue(),
                minutos: this.Cmp.minutos.getValue(),
                nombre_priori: this.datos.nombre_priori,
                nombre_servi: this.datos.nombre_servi,
                numero_ventanilla: this.datos.numero_ventanilla,
                sigla: this.datos.sigla,
                desc_tipo_ventanilla:this.datos.desc_tipo_ventanilla
            };

            var data = {
                "evento": "sis_colas/nuevaLlamadaPanel/" + this.datos.id_sucursal + "",
                "mensaje": ficha
            };
            //crear json
            var json = JSON.stringify({
                data: data,
                tipo: "enviarMensaje"

            });

            Phx.CP.webSocket.conn.send(json);

        },
        successRellamada: function (resp) {
            Phx.CP.loadingHide();
            this.getBoton('no_show').enable();

        },
        onIniciarAtencion: function () {
            Phx.CP.loadingShow();
            Ext.Ajax.request({
                url: '../../sis_colas/control/Ficha/iniciarAtencion',
                params: {
                    id_ficha: this.Cmp.id_ficha.getValue(),

                },
                success: this.successIniciarAtencion,
                failure: this.conexionFailure,
                timeout: this.timeout,
                scope: this
            });
        },
        successIniciarAtencion: function (resp) {
            Phx.CP.loadingHide();
            this.getBoton('rellamar').disable();
            this.getBoton('iniciar').disable();
            this.getBoton('no_show').disable();
            this.getBoton('derivar').disable();
            this.getBoton('finalizar').enable();
            this.Cmp.estado_ficha.setValue('En Atención');
            this.Cmp.ids_servicio.store.setBaseParam('id_sucursal', this.datos.id_sucursal);
            this.Cmp.id_usuario.store.setBaseParam('id_sucursal', this.datos.id_sucursal);
            this.Cmp.ids_servicio.enable();
            this.Cmp.ids_servicio.modificado = true;
            this.Cmp.ids_servicio.reset();
            this.Cmp.id_usuario.setVisible(false);
            this.Cmp.deriva.setVisible(true);
            this.Cmp.ids_servicio.setVisible(true);
            this.Cmp.cronometro.setVisible(true);
            control = setInterval(this.cronometro, 10, this);

        },
        //control:"",
        centesimas: 0,
        segundos: 0,
        minutos: 0,
        horas: 0,
        mostrar: " ",
        Grupos: [{
            layout: 'column',
            items: [
                {
                    xtype: 'fieldset',
                    layout: 'form',
                    border: true,
                    title: 'Ficha Atención',
                    bodyStyle: 'padding:0 10px 0;',
                    columnWidth: '.7',
                    items: [],
                    id_grupo: 0,
                },
                {
                    xtype: 'fieldset',
                    layout: 'form',
                    border: true,
                    title: 'Tiempo',
                    bodyStyle: 'padding:0 10px 0;',
                    columnWidth: '.3',
                    items: [],
                    id_grupo: 1,
                }
            ]
        }],
        cronometro: function (me) {
            //alert("asdfasdfasdfasdfasdf");
            /*
             console.log("ingresa no setipo:   "+ me.tipo);
             console.log("ingresa no title:   "+ me.title);
             console.log("ingresa no se que:   "+ me.centesimas);
             me.centesimas++;
             */

            if (me.centesimas < 99) {
                me.centesimas++;
                if (me.centesimas < 10) {
                    me.centesimas = "0" + me.centesimas
                }

                me.mostrar = me.horas + ":" + me.minutos + ":" + me.segundos;


            }

            if (me.centesimas == 99) {
                me.centesimas = -1;
            }
            if (me.centesimas == 0) {
                me.segundos++;
                if (me.segundos < 10) {
                    me.segundos = "0" + me.segundos
                }
                //Segundos.innerHTML = ":"+segundos;
                me.mostrar = me.horas + ":" + me.minutos + ":" + me.segundos;
            }

            if (me.segundos == 59) {
                me.segundos = -1;
            }
            if ((me.centesimas == 0) && (me.segundos == 0)) {
                me.minutos++;
                if (me.minutos < 10) {
                    me.minutos = "0" + me.minutos
                }
                //Minutos.innerHTML = ":"+minutos;
                me.mostrar = me.horas + ":" + me.minutos + ":" + me.segundos;
            }
            if (me.minutos == 59) {
                me.minutos = -1;
            }
            if ((me.centesimas == 0) && (me.segundos == 0) && (me.minutos == 0)) {
                me.horas++;
                if (me.horas < 10) {
                    me.horas = "0" + me.horas
                }
                //Horas.innerHTML = horas;
                me.mostrar = me.horas + ":" + me.minutos + ":" + me.segundos;
            }

            me.Cmp.cronometro.setValue(me.mostrar);


        },

        onFinalizar: function () {

            if (this.Cmp.ids_servicio.getValue() == '') {
                alert('FAVOR DE SELECCIONAR EL O LOS SERVICIOS');
            }
            else {
                Phx.CP.loadingShow();
                Ext.Ajax.request({
                    url: '../../sis_colas/control/Ficha/finalizarFicha',
                    params: {
                        id_ficha: this.Cmp.id_ficha.getValue(),
                        ids_servicio: this.Cmp.ids_servicio.getValue()
                    },
                    success: this.successFinalizar,
                    failure: this.conexionFailure,
                    timeout: this.timeout,
                    scope: this
                });


            }


        },
        successFinalizar: function (resp) {
            clearInterval(control);
            Phx.CP.loadingHide();
            this.onDestroy();
            this.close();
            //this.getBoton('iniciar').disable();

            //mandamos mensaje por el socket para que actualizen los demas sus pantallas de administradores
            var data = {
                "evento": "sis_colas/nuevosTickets/" + this.datos.id_sucursal + "",
                "mensaje": "tienes nuevo ticket campeon"
            };
            //crear json
            var json = JSON.stringify({
                data: data,
                tipo: "enviarMensaje"

            });

            Phx.CP.webSocket.conn.send(json);

        },
        onDerivar: function () {
            //alert (control);

            if (this.Cmp.ids_servicio.getValue() == '' || this.Cmp.id_servicio_der.getValue() == '') {

                alert('FAVOR DE SELECCIONAR EL SERVICIO A DERIVAR Y EL EJECUTIVO');

            }
            else if (this.Cmp.ids_servicio.getValue() == '') {
                alert('FAVOR DE SELECCIONAR EL SERVICIO A DERIVAR Y EL EJECUTIVO');
            }
            else {
                //alert ("asdasdasda");
                Phx.CP.loadingShow();

                Ext.Ajax.request({
                    url: '../../sis_colas/control/Ficha/derivarFicha',
                    params: {
                        id_ficha: this.Cmp.id_ficha.getValue(),
                        ids_servicio: this.Cmp.ids_servicio.getValue(),
                        id_usuario: this.Cmp.id_usuario.getValue(),
                        id_servicio_der: this.Cmp.id_servicio_der.getValue()
                    },
                    success: this.successDerivar,
                    failure: this.conexionFailure,
                    timeout: this.timeout,
                    scope: this
                });




            }


        },
        successDerivar: function (resp) {
            clearInterval(control);
            Phx.CP.loadingHide();
            this.onDestroy();
            this.close();
            //this.getBoton('iniciar').disable();

            //mandamos mensaje por el socket para que actualizen los demas sus pantallas de administradores

            var data = {
                "evento": "sis_colas/nuevosTickets/" + this.datos.id_sucursal + "",
                "mensaje": "tienes nuevo ticket campeon"
            };
            //crear json
            var json = JSON.stringify({
                data: data,
                tipo: "enviarMensaje"

            });

            Phx.CP.webSocket.conn.send(json);


        },

        onNoShow: function () {
            Phx.CP.loadingShow();
            Ext.Ajax.request({
                url: '../../sis_colas/control/Ficha/noShowFicha',
                params: {
                    id_ficha: this.Cmp.id_ficha.getValue()

                },
                success: this.successNoShow,
                failure: this.conexionFailure,
                timeout: this.timeout,
                scope: this
            });




        },
        successNoShow: function (resp) {
            Phx.CP.loadingHide();
            this.onDestroy();
            this.close();
            //this.getBoton('iniciar').disable();

            //mandamos mensaje por el socket para que actualizen los demas sus pantallas de administradores
            var data = {
                "evento": "sis_colas/nuevosTickets/" + this.datos.id_sucursal + "",
                "mensaje": "tienes nuevo ticket campeon"
            };
            //crear json
            var json = JSON.stringify({
                data: data,
                tipo: "enviarMensaje"

            });

            Phx.CP.webSocket.conn.send(json);

        },

    })
</script>
