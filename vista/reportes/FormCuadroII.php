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
    Phx.vista.FormCuadroII = Ext.extend(Phx.frmInterfaz, {

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
                    filters: {pfiltro: 'suc.nombre',type: 'string'},
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
                },
                {
                    config:{
                        name:'tipo_reporte',
                        fieldLabel:'Tipo Reporte',
                        allowBlank:true,
                        emptyText:'Tipo Rep...',
                        triggerAction: 'all',
                        lazyRender:true,
                        mode: 'local',
                        store:['servicioXtiempo','operadorXtiempo','operadorXservicio']

                    },
                    type:'ComboBox',
                    id_grupo:0,
                    valorInicial:'servicioXtiempo',
                    form:true
                }
               ];

            Phx.vista.FormCuadroII.superclass.constructor.call(this, config);
            this.init();
            this.iniciarEventos();

        },
        title : 'Reporte de Cuadro II y III',
        ActSave : '../../sis_colas/control/Reporte/reporteCuadroIIyIII',
        topBar : true,
        botones : false,
        remoteServer : '',
        labelSubmit : 'Generar',
        tooltipSubmit : '<b>Generar Reporte de servicio por rango de tiempo y operador por rango de tiempo</b>',
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
        agregarArgsExtraSubmit: function() {
            this.argumentExtraSubmit.sucursal = this.Cmp.id_sucursal.getRawValue();
            this.argumentExtraSubmit.servidor_remoto = this.remoteServer;

        },

        desc_item:''

    })
</script>
