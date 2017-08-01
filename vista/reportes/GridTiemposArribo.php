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
    Phx.vista.GridTiemposArribo = Ext.extend(Phx.gridInterfaz, {
        constructor : function(config) {
            this.maestro = config;
            this.sucursal = this.desc_sucursal;

            Phx.vista.GridTiemposArribo.superclass.constructor.call(this, config);
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
                    labelSeparator: '',
                    inputType: 'hidden',
                    name: 'hora'
                },
                type: 'Field',
                form: true
            },
            {
                config: {
                    name: 'rango',
                    fieldLabel: 'Rango de Horas',
                    gwidth: 200
                },
                type: 'Field',
                grid: true

            },

            {
                config: {
                    name: 'cantidad',
                    fieldLabel: 'Cantidad de Fichas',
                    gwidth: 180
                },
                type: 'Field',
                grid: true

            }
        ],
        title : 'Tiempos de Arribo',
        ActList : '../../sis_colas/control/Reporte/listarTiemposArribo',
        id_store : 'id_ficha',
        fields : [{
            name : 'hora'
        }, {
            name : 'rango',
            type : 'string'
        },{
            name : 'cantidad',
            type : 'numeric'
        }],
        sortInfo : {
            field : 'hora',
            direction : 'ASC'
        },
        bdel : false,
        bnew: false,
        bedit: false,
        fwidth : '90%',
        fheight : '80%'
    });
</script>
