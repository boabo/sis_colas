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
    Phx.vista.GridHistoricoFichas = Ext.extend(Phx.gridInterfaz, {
        constructor : function(config) {
            this.maestro = config;
            this.sucursal = this.desc_sucursal;

            Phx.vista.GridHistoricoFichas.superclass.constructor.call(this, config);
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
                    name: 'operador',
                    fieldLabel: 'Operador',
                    gwidth: 200
                },
                type: 'Field',
                grid: true

            },


            {
                config: {
                    name: 'cantidad_finalizadas',
                    fieldLabel: 'Cantidad de Atendidas',
                    gwidth: 180
                },
                type: 'Field',
                grid: true

            },
            {
                config: {
                    name: 'cantidad_abandonadas',
                    fieldLabel: 'Cantidad de Abandonadas',
                    gwidth: 180
                },
                type: 'Field',
                grid: true

            },
            {
                config: {
                    name: 'porcentaje_finalizadas',
                    fieldLabel: 'Porcentaje de Atendidas',
                    gwidth: 180
                },
                type: 'Field',
                grid: true

            },
            {
                config: {
                    name: 'porcentaje_abandonadas',
                    fieldLabel: 'Porcentaje de Abandonadas',
                    gwidth: 180
                },
                type: 'Field',
                grid: true

            }
        ],
        title : 'Historico Fichas',
        ActList : '../../sis_colas/control/Reporte/listarHistoricoFichas',
        id_store : 'id_ficha',
        fields : [{
            name : 'operador',
            type : 'string'
        },{
            name : 'cantidad_finalizadas',
            type : 'numeric'
        },{
            name : 'cantidad_abandonadas',
            type : 'numeric'
        },{
            name : 'porcentaje_finalizadas',
            type : 'numeric'
        },{
            name : 'porcentaje_abandonadas',
            type : 'numeric'
        }],
        sortInfo : {
            field : 'operador',
            direction : 'ASC'
        },
        bdel : false,
        bnew: false,
        bedit: false,
        fwidth : '90%',
        fheight : '80%'
    });
</script>
