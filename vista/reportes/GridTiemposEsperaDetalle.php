<?php
/**
 * @package pxP
 * @file 	GridTicketsAtendidos.php
 * @author 	RCM
 * @date	10/07/2013
 * @description	Reporte Sistema de Colas
 */
header("content-type:text/javascript; charset=UTF-8");
?>
<script>
    Phx.vista.GridTiemposEsperaDetalle = Ext.extend(Phx.gridInterfaz, {
        constructor : function(config) {
            this.maestro = config;
            this.sucursal = this.desc_sucursal;

            Phx.vista.GridTiemposEsperaDetalle.superclass.constructor.call(this, config);
            this.init();
            this.load({
                params : {
                    start: 0,
                    limit: this.tam_pag,
                    fecha_ini:this.maestro.fecha_ini,
                    fecha_fin:this.maestro.fecha_fin,
                    id_sucursal:this.maestro.id_sucursal,
                    servidor_remoto : this.maestro.servidor_remoto
                }
            });
        },
        tam_pag:1000,
        Atributos : [

            {
                config: {
                    name: 'servicio',
                    fieldLabel: 'Servicio',
                    gwidth: 120
                },
                type: 'Field',
                grid: true

            },
            {
                config: {
                    name: 'cantidad_atencion1',
                    fieldLabel: 'ATENCION<br>DE 0 A 5',
                    gwidth: 100
                },
                type: 'Field',
                form:false,
                grid: true

            },
            {
                config: {
                    name: 'cantidad_atencion2',
                    fieldLabel: 'ATENCION<br>DE 5 A 10',
                    gwidth: 100
                },
                type: 'Field',
                form:false,
                grid: true

            },
            {
                config: {
                    name: 'cantidad_atencion3',
                    fieldLabel: 'ATENCION<br>MAYOR A 10',
                    gwidth: 100
                },
                type: 'Field',
                form:false,
                grid: true

            },
            {
                config: {
                    name: 'cantidad_espera1',
                    fieldLabel: 'ESPERA<br>DE 0 A 5',
                    gwidth: 100
                },
                type: 'Field',
                form:false,
                grid: true

            },
            {
                config: {
                    name: 'cantidad_espera2',
                    fieldLabel: 'ESPERA<br>DE 5 A 10',
                    gwidth: 100
                },
                type: 'Field',
                form:false,
                grid: true

            },
            {
                config: {
                    name: 'cantidad_espera3',
                    fieldLabel: 'ESPERA<br>MAYOR A 10',
                    gwidth: 100
                },
                type: 'Field',
                form:false,
                grid: true

            },
            {
                config: {
                    name: 'cantidad_llamado1',
                    fieldLabel: 'LLAMADO<br>DE 0 A 5',
                    gwidth: 100
                },
                type: 'Field',
                form:false,
                grid: true

            },
            {
                config: {
                    name: 'cantidad_llamado2',
                    fieldLabel: 'LLAMADO<br>DE 5 A 10',
                    gwidth: 100
                },
                type: 'Field',
                form:false,
                grid: true

            },
            {
                config: {
                    name: 'cantidad_llamado3',
                    fieldLabel: 'LLAMADO<br>MAYOR A 10',
                    gwidth: 100
                },
                type: 'Field',
                form:false,
                grid: true

            },
        ],
        title : 'Tiempos de Espera',
        ActList : '../../sis_colas/control/Reporte/listarTiemposEsperaDetalle',
        fields : [ {
            name : 'servicio',
            type : 'string'
        },{
            name : 'cantidad_atencion1',
            type : 'numeric'
        },{
            name : 'cantidad_atencion2',
            type : 'numeric'
        },{
            name : 'cantidad_atencion3',
            type : 'numeric'
        },{
            name : 'cantidad_espera1',
            type : 'numeric'
        },{
            name : 'cantidad_espera2',
            type : 'numeric'
        },{
            name : 'cantidad_espera3',
            type : 'numeric'
        },{
            name : 'cantidad_llamado1',
            type : 'numeric'
        },{
            name : 'cantidad_llamado2',
            type : 'numeric'
        },{
            name : 'cantidad_llamado3',
            type : 'numeric'
        }],
        sortInfo : {
            field : 'servicio',
            direction : 'ASC'
        },
        bdel : false,
        bnew: false,
        bedit: false,
        fwidth : '90%',
        fheight : '80%'
    });
</script>
