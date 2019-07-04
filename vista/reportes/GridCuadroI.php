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
    Phx.vista.GridCuadroI = Ext.extend(Phx.gridInterfaz, {
        constructor : function(config) {
            this.maestro = config;
            this.sucursal = this.desc_sucursal;

            Phx.vista.GridCuadroI.superclass.constructor.call(this, config);
            this.init();
            this.load({
                params : {
                    start: 0,
                    limit: 50,
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
                    name: 'cantidad_atendidos',
                    fieldLabel: 'Cantidad Atendidas',
                    gwidth: 180
                },
                type: 'Field',
                grid: true

            },
            {
                config: {
                    name: 'cantidad_abandonados',
                    fieldLabel: 'Cantidad Abandonadas',
                    gwidth: 180
                },
                type: 'Field',
                grid: true

            },
            {
                config: {
                    name: 'promedio_espera',
                    fieldLabel: 'Prom. Tiempo Espera',
                    gwidth: 180,
                    galign: 'right',
                    renderer : function(value, p, record) {
                        if ( record.data['promedio_espera'] != '') {
                          return String.format('<div>{0}</div>', record.data['promedio_espera'] + ' min');
                        } else {
                          return String.format('{0}', record.data['promedio_espera']);
                        }
                    }
                },
                type: 'Field',
                grid: true

            },
            {
                config: {
                    name: 'promedio_atencion',
                    fieldLabel: 'Prom. Tiempo Atencion',
                    gwidth: 180,
                    galign: 'right',
                    renderer : function(value, p, record) {
                        if ( record.data['promedio_espera'] != '') {
                          return String.format('<div>{0}</div>', record.data['promedio_atencion'] + ' min');
                        } else {
                          return String.format('{0}', record.data['promedio_atencion']);
                        }
                    }
                },
                type: 'Field',
                grid: true

            }
        ],
        title : 'Cuadro I',
        ActList : '../../sis_colas/control/Reporte/reporteCuadroI',
        id_store : 'hora',
        fields : [{
            name : 'hora'
        }, {
            name : 'rango',
            type : 'string'
        },{
            name : 'cantidad_atendidos',
            type : 'numeric'
        },{
            name : 'cantidad_abandonados',
            type : 'numeric'
        },{
            name : 'promedio_espera',
            type : 'numeric'
        },{
            name : 'promedio_atencion',
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
