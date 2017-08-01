<?php
/**
 *@package pXP
 *@file    KardexItem.php
 *@author  RCM
 *@date    06/07/2013
 *@description Archivo con la interfaz para generación de reporte
 */
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
    Phx.vista.FormHistoricoFichas = Ext.extend(Phx.frmInterfaz, {

        constructor: function(config) {
            Ext.apply(this,config);
            this.Atributos = [
                {
                    config: {
                        name: 'id_sucursal',
                        fieldLabel: 'Sucursal',
                        allowBlank: false,
                        emptyText: 'Elija una opción...',
                        store: new Ext.data.JsonStore({
                            url: '../../sis_colas/control/Sucursal/listarSucursal',
                            id: 'id_sucursal',
                            root: 'datos',
                            sortInfo: {
                                field: 'nombre',
                                direction: 'ASC'
                            },
                            totalProperty: 'total',
                            fields: ['id_sucursal', 'nombre', 'codigo','servidor_remoto'],
                            remoteSort: true,
                            baseParams: {par_filtro: 'sucur.nombre#sucur.codigo'}
                        }),
                        valueField: 'id_sucursal',
                        displayField: 'nombre',
                        gdisplayField: 'nombre_sucursal',
                        hiddenName: 'id_sucursal',
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
                        renderer : function(value, p, record) {
                            return String.format('{0}', record.data['nombre_sucursal']);
                        }
                    },
                    type: 'ComboBox',
                    id_grupo: 0,
                    filters: {pfiltro: 'suc.nombre_sucural',type: 'string'},
                    grid: true,
                    form: true
                },
                {
                    config : {
                        name : 'fecha_ini',
                        id:'fecha_ini'+this.idContenedor,
                        fieldLabel : 'Fecha Desde',
                        allowBlank : false,
                        format : 'd/m/Y',
                        renderer : function(value, p, record) {
                            return value ? value.dateFormat('d/m/Y h:i:s') : ''
                        },
                        vtype: 'daterange',
                        endDateField: 'fecha_fin'+this.idContenedor
                    },
                    type : 'DateField',
                    id_grupo : 0,
                    grid : true,
                    form : true
                },
                {
                    config : {
                        name : 'fecha_fin',
                        id:'fecha_fin'+this.idContenedor,
                        fieldLabel: 'Fecha Hasta',
                        allowBlank: false,
                        gwidth: 100,
                        format: 'd/m/Y',
                        renderer: function(value, p, record) {
                            return value ? value.dateFormat('d/m/Y h:i:s') : ''
                        },
                        vtype: 'daterange',
                        startDateField: 'fecha_ini'+this.idContenedor
                    },
                    type : 'DateField',
                    id_grupo : 0,
                    grid : true,
                    form : true
                }];

            Phx.vista.FormHistoricoFichas.superclass.constructor.call(this, config);
            this.init();
            this.iniciarEventos();

        },
        title : 'Reporte de Historico Atencion Fichas',
        topBar : true,
        botones : false,
        remoteServer : '',
        labelSubmit : 'Generar',
        tooltipSubmit : '<b>Generar Reporte Historico de Atencion de Fichas</b>',
        tipo : 'reporte',
        clsSubmit : 'bprint',
        Grupos : [{
            layout : 'column',
            items : [{
                xtype : 'fieldset',
                layout : 'form',
                border : true,
                title : 'Generar Reporte',
                bodyStyle : 'padding:0 10px 0;',
                columnWidth : '300px',
                items : [],
                id_grupo : 0,
                collapsible : true
            }]
        }],
        iniciarEventos : function() {
        	this.Cmp.id_sucursal.on('select',function(c, r, i) {
        		this.remoteServer = r.data.servidor_remoto;
        	},this);
        },

        onSubmit: function(){
            if (this.form.getForm().isValid()) {
                var data={};
                data.fecha_ini=this.getComponente('fecha_ini').getValue().dateFormat('d/m/Y');
                data.id_sucursal=this.getComponente('id_sucursal').getValue();
                data.fecha_fin=this.getComponente('fecha_fin').getValue().dateFormat('d/m/Y');
                data.desc_sucursal = this.Cmp.id_sucursal.getRawValue();
                data.servidor_remoto = this.remoteServer;

                Phx.CP.loadWindows('../../../sis_colas/vista/reportes/GridHistoricoFichas.php', 'Historico Fichas : '+data.desc_sucursal, {
                    width : '90%',
                    height : '80%'
                }, data	, this.idContenedor, 'GridHistoricoFichas')
            }
        },
        desc_item:''

    })
</script>