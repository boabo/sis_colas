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
    Phx.vista.FormTicketsAtencion = Ext.extend(Phx.frmInterfaz, {

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
                    config: {
                        name: 'id_usuario',
                        fieldLabel: 'Operador',
                        allowBlank: true,
                        emptyText: 'Elija una opción...',
                        store: new Ext.data.JsonStore({
                            url: '../../sis_seguridad/control/Usuario/listarUsuario',
                            id: 'id_usuario',
                            root: 'datos',
                            sortInfo: {
                                field: 'desc_person',
                                direction: 'ASC'
                            },
                            totalProperty: 'total',
                            fields: ['id_usuario', 'desc_person', 'descripcion'],
                            remoteSort: true,
                            baseParams: {par_filtro: 'PERSON.nombre_completo2'}
                        }),
                        valueField: 'id_usuario',
                        displayField: 'desc_person',
                        gdisplayField: 'desc_persona',
                        hiddenName: 'id_usuario',
                        forceSelection: true,
                        typeAhead: false,
                        triggerAction: 'all',
                        lazyRender: true,
                        mode: 'remote',
                        pageSize: 15,
                        queryDelay: 1000,
                        anchor: '100%',
                        gwidth: 200,
                        minChars: 2,
                        renderer : function(value, p, record) {
                            return String.format('{0}', record.data['desc_persona']);
                        }
                    },
                    type: 'ComboBox',
                    id_grupo: 0,
                    filters: {pfiltro: 'vusu.desc_persona',type: 'string'},
                    grid: true,
                    form: true
                },
                {
                    config:{
                        name:'estado',
                        fieldLabel:'Estado',
                        allowBlank:true,
                        emptyText:'Estado...',

                        typeAhead: true,
                        triggerAction: 'all',
                        lazyRender:true,
                        mode: 'local',
                        store:['espera','llamado','en_atencion','finalizado','no_show']

                    },
                    type:'ComboBox',
                    form:true
                },];

            Phx.vista.FormTicketsAtencion.superclass.constructor.call(this, config);
            this.init();

        },
        title : 'Reporte Tickets en Atencion',
        topBar : true,
        botones : false,
        remoteServer : '',
        labelSubmit : 'Generar',
        tooltipSubmit : '<b>Generar Reporte de Tickets en Atencions</b>',
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

                data.id_sucursal=this.getComponente('id_sucursal').getValue();
                data.id_usuario=this.getComponente('id_usuario').getValue();
                data.estado=this.getComponente('estado').getValue();
                
                data.desc_sucursal = this.Cmp.id_sucursal.getRawValue();
				data.servidor_remoto = this.remoteServer;
                Phx.CP.loadWindows('../../../sis_colas/vista/reportes/GridTicketsAtencion.php', 'Tickets en Atencion: '+data.desc_sucursal, {
                    width : '90%',
                    height : '80%'
                }, data	, this.idContenedor, 'GridTicketsAtencion')
            }
        },
        desc_item:''

    })
</script>