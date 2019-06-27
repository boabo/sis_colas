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
                    gwidth: 300
                },
                type: 'Field',
                grid: true

            },

            {
                config: {
                    name: 'nombre',
                    fieldLabel: 'Sucursal',
                    gwidth: 200,
                    renderer:function (value,p,record){
                        if(record.data.tipo_reg != 'summary'){
                            return  String.format('<div>{0}</div>', record.data['nombre']);
                        }
                        else{
                            return '<b><p style="font-size:20px; color:blue; font-weight:bold; text-align:right; text-decoration: border-top:2px;">Totales: &nbsp;&nbsp; </p></b>';
                        }
                    },
                },
                type: 'Field',
                grid: true

            },


            {
                config: {
                    name: 'cantidad_finalizadas',
                    fieldLabel: 'Cantidad de Atendidas',
                    gwidth: 180,
                    galign: 'right',
                    renderer:function (value,p,record){
                        if(record.data.tipo_reg != 'summary'){
                            return  String.format('<div style="font-size:15px; color:#006C24; text-align:right;"><b>{0}</b></div>', Ext.util.Format.number(value));
                        }
                        else{
                            return  String.format('<div style="font-size:20px; text-align:right; font-weight:bold; color:#006C24;"><b>{0}<b></div>', Ext.util.Format.number(record.data.total_cantidad_atendidas,'0,000.00'));
                        }
                    },

                },
                type: 'Field',
                grid: true

            },
            {
                config: {
                    name: 'cantidad_abandonadas',
                    fieldLabel: 'Cantidad de Abandonadas',
                    gwidth: 180,
                    galign: 'right',
                    renderer:function (value,p,record){
                        if(record.data.tipo_reg != 'summary'){
                            return  String.format('<div style="font-size:15px; color:red; text-align:right;"><b>{0}</b></div>', Ext.util.Format.number(value));
                        }
                        else{
                            return  String.format('<div style="font-size:20px; text-align:right; font-weight:bold; color:red;"><b>{0}<b></div>', Ext.util.Format.number(record.data.total_cantidad_abandonadas,'0,000.00'));
                        }
                    },
                },
                type: 'Field',
                grid: true

            },
            {
                config: {
                    name: 'total_fichas',
                    fieldLabel: 'Total Fichas',
                    gwidth: 180,
                    galign: 'right',
                    renderer:function (value,p,record){
                        if(record.data.tipo_reg != 'summary'){
                            return  String.format('<div style="font-size:15px; color:#D3871A; text-align:right;"><b>{0}</b></div>', Ext.util.Format.number(value));
                        }
                        else{
                            return  String.format('<div style="font-size:20px; text-align:right; font-weight:bold; color:#D3871A;"><b>{0}<b></div>', Ext.util.Format.number(record.data.totales_fichas,'0,000.00'));
                        }
                    },
                },
                type: 'Field',
                grid: true

            },
            {
                config: {
                    name: 'porcentaje_finalizadas',
                    fieldLabel: 'Porcentaje de Atendidas',
                    gwidth: 180,
                    galign: 'right',
                    renderer : function(value, p, record) {
                        if ( record.data['porcentaje_finalizadas'] != '') {
                          return String.format('<div style="font-size:15px; font-weight:bold; color:#006C24;">{0}</div>', record.data['porcentaje_finalizadas'] + '%');
                        } else {
                          return String.format('{0}', record.data['porcentaje_finalizadas']);
                        }
                    }
                },
                type: 'Field',
                grid: true

            },
            {
                config: {
                    name: 'porcentaje_abandonadas',
                    fieldLabel: 'Porcentaje de Abandonadas',
                    gwidth: 180,
                    galign: 'right',
                    renderer : function(value, p, record) {
                        if ( record.data['porcentaje_abandonadas'] != '') {
                          return String.format('<div style="font-size:15px; font-weight:bold; color:red;">{0}</div>', record.data['porcentaje_abandonadas'] + '%');
                        } else {
                          return String.format('{0}', record.data['porcentaje_abandonadas']);
                        }
                    }
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
            name : 'nombre',
            type : 'string'
        },{
           name:'tipo_reg',
           type: 'string'
         },{
            name : 'cantidad_finalizadas',
            type : 'numeric'
        },{
          name:'total_cantidad_atendidas',
          type: 'numeric'
        },{
            name : 'cantidad_abandonadas',
            type : 'numeric'
        },{
          name:'total_cantidad_abandonadas',
          type: 'numeric'
        },{
            name : 'porcentaje_finalizadas',
            type : 'numeric'
        },{
            name : 'total_fichas',
            type : 'numeric'
        },{
          name:'totales_fichas',
          type: 'numeric'
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
