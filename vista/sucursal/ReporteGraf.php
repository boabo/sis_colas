<?php
/**
 * @package pXP
 * @file ReporteGraf.php
 * @author  (José Mita)
 * @date 15-06-2016 23:15:40
 * @description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
 */

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
    Phx.vista.ReporteGraf = Ext.extend(Phx.gridInterfaz, {

            constructor: function (config) {
                this.maestro = config.maestro;
                //llama al constructor de la clase padre
                Phx.vista.ReporteGraf.superclass.constructor.call(this, config);


                this.campo_fecha_desde = new Ext.form.DateField({
                    name: 'desde',
                    fieldLabel: 'Desde',
                    allowBlank: true,
                    anchor: '80%',
                    gwidth: 100,
                    format: 'd/m/Y'
                });

                this.campo_fecha_hasta = new Ext.form.DateField({
                    name: 'hasta',
                    fieldLabel: 'Hasta',
                    allowBlank: true,
                    anchor: '80%',
                    gwidth: 100,
                    format: 'd/m/Y'
                });


                this.tbar.addField('Desde:');
                this.tbar.addField(this.campo_fecha_desde);
                this.tbar.addField('Hasta:');
                this.tbar.addField(this.campo_fecha_hasta);
                this.campo_fecha_desde.setValue();
                this.campo_fecha_hasta.setValue();

                this.init();
                this.load({params: {start: 0, limit: this.tam_pag}})


            },

            Atributos: [
                {
                    //configuracion del componente
                    config: {
                        labelSeparator: '',
                        inputType: 'hidden',
                        name: 'id_sucursal'
                    },
                    type: 'Field',
                    form: true
                },
                {
                    config: {
                        name: 'codigo',
                        fieldLabel: 'Código',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 4
                    },
                    type: 'TextField',
                    filters: {pfiltro: 'sucur.codigo', type: 'string'},
                    id_grupo: 1,
                    grid: true,
                    form: true
                },
                {
                    config: {
                        name: 'nombre',
                        fieldLabel: 'Nombre',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 150,
                        maxLength: 80
                    },
                    type: 'TextField',
                    filters: {pfiltro: 'sucur.nombre', type: 'string'},
                    id_grupo: 1,
                    grid: true,
                    form: true
                },
                {
                    config: {
                        name: 'id_depto',
                        fieldLabel: 'Departamento',
                        allowBlank: false,
                        emptyText: 'Elija una opción...',
                        store: new Ext.data.JsonStore({
                            url: '../../sis_parametros/control/Depto/listarDepto',
                            id: 'id_depto',
                            root: 'datos',
                            sortInfo: {
                                field: 'nombre',
                                direction: 'ASC'
                            },
                            totalProperty: 'total',
                            fields: ['id_depto', 'nombre', 'codigo'],
                            remoteSort: true,
                            baseParams: {par_filtro: 'DEPPTO.nombre#DEPPTO.codigo'}
                        }),
                        valueField: 'id_depto',
                        displayField: 'nombre',
                        gdisplayField: 'nombre_dep',
                        hiddenName: 'id_depto',
                        forceSelection: true,
                        typeAhead: false,
                        triggerAction: 'all',
                        lazyRender: true,
                        mode: 'remote',
                        pageSize: 15,
                        queryDelay: 1000,
                        anchor: '100%',
                        gwidth: 150,
                        minChars: 2,
                        renderer: function (value, p, record) {
                            return String.format('{0}', record.data['nombre_dep']);
                        }
                    },
                    type: 'ComboBox',
                    id_grupo: 0,
                    filters: {pfiltro: 'sucur.nombre_dep', type: 'string'},
                    grid: true,
                    form: true
                },


                {
                    config: {
                        name: 'mensaje_imp',
                        fieldLabel: 'Mensaje Impresión',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 150,
                        maxLength: 100
                    },
                    type: 'TextField',
                    filters: {pfiltro: 'sucur.mensaje_imp', type: 'string'},
                    id_grupo: 1,
                    grid: true,
                    form: true
                },

                {
                    config: {
                        name: 'servidor_remoto',
                        fieldLabel: 'Serv. Remoto',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 150,
                        maxLength: 80
                    },
                    type: 'TextField',
                    filters: {pfiltro: 'sucur.servidor_remoto', type: 'string'},
                    id_grupo: 1,
                    grid: true,
                    form: true
                },
                {
                    config: {
                        name: 'estado_reg',
                        fieldLabel: 'Estado Reg.',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 10
                    },
                    type: 'TextField',
                    filters: {pfiltro: 'sucur.estado_reg', type: 'string'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                },
                {
                    config: {
                        name: 'usr_reg',
                        fieldLabel: 'Creado por',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 4
                    },
                    type: 'Field',
                    filters: {pfiltro: 'usu1.cuenta', type: 'string'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                },
                {
                    config: {
                        name: 'usuario_ai',
                        fieldLabel: 'Funcionaro AI',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 300
                    },
                    type: 'TextField',
                    filters: {pfiltro: 'sucur.usuario_ai', type: 'string'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                },
                {
                    config: {
                        name: 'fecha_reg',
                        fieldLabel: 'Fecha creación',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        format: 'd/m/Y',
                        renderer: function (value, p, record) {
                            return value ? value.dateFormat('d/m/Y H:i:s') : ''
                        }
                    },
                    type: 'DateField',
                    filters: {pfiltro: 'sucur.fecha_reg', type: 'date'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                },
                {
                    config: {
                        name: 'id_usuario_ai',
                        fieldLabel: 'Fecha creación',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 4
                    },
                    type: 'Field',
                    filters: {pfiltro: 'sucur.id_usuario_ai', type: 'numeric'},
                    id_grupo: 1,
                    grid: false,
                    form: false
                },
                {
                    config: {
                        name: 'fecha_mod',
                        fieldLabel: 'Fecha Modif.',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        format: 'd/m/Y',
                        renderer: function (value, p, record) {
                            return value ? value.dateFormat('d/m/Y H:i:s') : ''
                        }
                    },
                    type: 'DateField',
                    filters: {pfiltro: 'sucur.fecha_mod', type: 'date'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                },
                {
                    config: {
                        name: 'usr_mod',
                        fieldLabel: 'Modificado por',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 4
                    },
                    type: 'Field',
                    filters: {pfiltro: 'usu2.cuenta', type: 'string'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                }
            ],
            tam_pag: 50,
            title: 'ReporteGrafes',

            ActList: '../../sis_colas/control/Sucursal/listarSucursal',
            id_store: 'id_sucursal',
            fields: [
                {name: 'id_sucursal', type: 'numeric'},
                {name: 'id_depto', type: 'numeric'},
                {name: 'estado_reg', type: 'string'},
                {name: 'codigo', type: 'string'},
                {name: 'servidor_remoto', type: 'string'},
                {name: 'mensaje_imp', type: 'string'},
                {name: 'nombre', type: 'string'},
                {name: 'id_usuario_reg', type: 'numeric'},
                {name: 'usuario_ai', type: 'string'},
                {name: 'fecha_reg', type: 'date', dateFormat: 'Y-m-d H:i:s.u'},
                {name: 'id_usuario_ai', type: 'numeric'},
                {name: 'fecha_mod', type: 'date', dateFormat: 'Y-m-d H:i:s.u'},
                {name: 'id_usuario_mod', type: 'numeric'},
                {name: 'usr_reg', type: 'string'},
                {name: 'usr_mod', type: 'string'},
                {name: 'nombre_dep', type: 'string'},

            ],
            sortInfo: {
                field: 'id_sucursal',
                direction: 'ASC'
            },
            bdel: false,
            bnew: false,
            bedit: false,
            bsave: false,

            validarFiltros: function () {
                if (this.campo_fecha_hasta.validate() && this.campo_fecha_desde.validate()) {
                    return true;
                } else {
                    return false;
                }

            },
            onButtonAct: function () {

                if (!this.validarFiltros()) {
                    alert('Especifique los filtros antes')
                }
                else {
                    this.capturaFiltros();
                }

            },
            capturaFiltros: function (combo, record, index) {


                var desde = this.campo_fecha_desde.getValue(),
                    hasta = this.campo_fecha_hasta.getValue();


               /* if (desde && hasta) {
                    this.loaderTree.baseParams = {
                        desde: desde.dateFormat('d/m/Y'),
                        hasta: hasta.dateFormat('d/m/Y')
                    };
                }


                this.root.reload();*/

            },


        tabeast:[

            {
                url:'../../../sis_colas/vista/sucursal/Torta.php',
                title:'Por Status',
                width:'50%',
                cls:'Torta'
            },
            {
                url:'../../../sis_colas/vista/sucursal/PorServicio.php',
                title:'Por Servicio',
                width:'50%',
                cls:'PorServicio'
            },
            {
                url:'../../../sis_colas/vista/sucursal/PromedioAtencionEstado.php',
                title:'Por Promedio Atencion Estado',
                width:'50%',
                cls:'PromedioAtencionEstado'
            },
            {
                url:'../../../sis_colas/vista/sucursal/AtencionUsuario.php',
                title:'Por Promedio Atencion Usuario',
                width:'50%',
                cls:'AtencionUsuario'
            }
        ]



        }
    )
</script>

		