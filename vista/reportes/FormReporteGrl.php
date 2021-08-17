<?php
/**
 *@package pXP
 *@file    KardexItem.php
 *@author  FAVIO FIGUEROA
 *@date    17/08/2021
 *@description Archivo con la interfaz para generación de reporte
 */
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
    Phx.vista.FormReporteGrl = Ext.extend(Phx.frmInterfaz, {

        constructor: function(config) {
            Ext.apply(this,config);
            this.Atributos = [
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

            Phx.vista.FormReporteGrl.superclass.constructor.call(this, config);
            this.init();
            this.iniciarEventos();

        },
        title : 'Reporte General',
        topBar : true,
        botones : false,
        remoteServer : '',
        labelSubmit : 'Generar',
        tooltipSubmit : '<b>Generar Reporte de Tickets Atendidos y Abandonados</b>',
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
           
        },

        successGenerarReporte: function (resp) {
            Phx.CP.loadingHide();
            const objRes = Ext.util.JSON.decode(Ext.util.Format.trim(resp.responseText));
            console.log('objRes',objRes)
            const archivoGenerado = objRes.ROOT.detalle.archivo_generado;
            window.open(`../../../lib/lib_control/Intermediario.php?r=${archivoGenerado}&t=${new Date().toLocaleTimeString()}`)

        },
        onSubmit: function(){
            if (this.form.getForm().isValid()) {
                var data={};
                data.fecha_ini=this.getComponente('fecha_ini').getValue().dateFormat('d/m/Y');
                data.fecha_fin=this.getComponente('fecha_fin').getValue().dateFormat('d/m/Y');
                data.servidor_remoto = this.remoteServer;

                Phx.CP.loadingShow();


                Ext.Ajax.request({
                    url: '../../sis_colas/control/Ficha/generarReporteGrl',
                    params: {fecha_ini: data.fecha_ini, fecha_fin:  data.fecha_fin},
                    success: this.successGenerarReporte,
                    failure: this.conexionFailure,
                    timeout: this.timeout,
                    scope: this
                });

            }
        },
        desc_item:''

    })
</script>
