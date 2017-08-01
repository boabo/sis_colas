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
    Phx.vista.GridTiemposEspera = Ext.extend(Phx.gridInterfaz, {
        constructor : function(config) {
            this.maestro = config;
            this.sucursal = this.desc_sucursal;

            Phx.vista.GridTiemposEspera.superclass.constructor.call(this, config);
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
                    name: 'nombre',
                    fieldLabel: 'Tiempos',
                    gwidth: 100
                },
                type: 'Field',
                grid: true

            },
            {
                config: {
                    name: 'cantidad_atencion',
                    fieldLabel: 'Tiempo de Atencion',
                    gwidth: 120
                },
                type: 'Field',
                grid: true

            },
            {
                config: {
                    name: 'cantidad_espera',
                    fieldLabel: 'Tiempo de Espera',
                    gwidth: 120
                },
                type: 'Field',
                grid: true

            },
            {
                config: {
                    name: 'cantidad_llamado',
                    fieldLabel: 'Tiempo de Llamado',
                    gwidth: 120
                },
                type: 'Field',
                grid: true

            }


        ],
        title : 'Tiempos de Espera',
        ActList : '../../sis_colas/control/Reporte/listarTiemposEspera',
        fields : [ {
            name : 'nombre',
            type : 'string'
        },{
            name : 'cantidad_atencion',
            type : 'numeric'
        },{
            name : 'cantidad_espera',
            type : 'numeric'
        },{
            name : 'cantidad_llamado',
            type : 'numeric'
        }],
        sortInfo : {
            field : 'nombre',
            direction : 'ASC'
        },
        bdel : false,
        bnew: false,
        bedit: false,
        fwidth : '90%',
        fheight : '80%'
    });
</script>
