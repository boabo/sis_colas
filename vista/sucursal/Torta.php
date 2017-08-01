<?php
/**
 *@package pXP
 *@file gen-Depto.php
 *@author  favio figueroa
 *@date 24-11-2017 15:52:20
 *@description grafico
 */
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
    Ext.define('Phx.vista.Torta',{
        extend: 'Ext.util.Observable',

        constructor: function(config) {

            Ext.apply(this, config);
            var me = this;
            this.callParent(arguments);

            this.panel = Ext.getCmp(this.idContenedor);

            this.store = new Ext.data['JsonStore']({
                url: '../../sis_colas/control/Ficha/reporteStatus',
                id: 'id_ficha',
                //root: 'datos',
                sortInfo: {field: 'id_ficha',direction: 'ASC'},
                totalProperty: 'total',
                fields:['cantidad_estado','porcentaje_estado','estado'],
                remoteSort: true
            });
            this.store.load({ params: { start: 0, limit: 300}});



            this.tbar = new Ext.Toolbar({
                items:['Tipo: ',this.cmbTipo]
            });






            this.panelTorta = new Ext.Panel({
                padding: '0 0 0 0',
                tbar: this.tbar,
                html:'<div id="map-'+this.idContenedor +'" style="width: 100%; height: 100%; position:absolute;"></div>',
                //html:'<div id="map-'+this.idContenedor +'" style="position: absolute;  top: 0; right: 0; bottom: 0; left: 0;border: 15px solid orange"></div>',
                region:'center',
                layout:  'fit' });

            this.Border = new Ext.Container({
                layout:'border',
                items:[ this.panelTorta]
            });



            this.panel.add(this.Border);
            this.panel.doLayout();
            this.addEvents('init');


            this.chart = Highcharts.chart('map-'+this.idContenedor, {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'bar'
                },
                title: {
                    text: "POR STATUS"
                },
                tooltip: {
                    pointFormat: '({series.name}) <br>{point.descripcion}: <br><b>{point.y}</b>'
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            /*formatter:function() {
                             var pcnt = (this.y / dataSum) * 100;
                             return Highcharts.numberFormat(pcnt) + '%';


                             }, */
                            format: '{point.name}: <br><b>{point.percentage:.1f} %</b>',
                            style: {
                                color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                            }
                        }
                    }
                },
                series: [{
                    name: 'Elemento',
                    colorByPoint: true,
                    data: [{}]
                }]
            });


            this.cmbTipo.on('select',function(cm,dat,num){


                this.chart.series[0].update({ type: dat.data.field1 });
                this.chart.redraw();

            },this);

        },

        onReloadPage : function(m){

            this.maestro = m;


            console.log('maestro',this.maestro)
            var padre = Phx.CP.getPagina(this.idContenedorPadre);
            var desde = padre.campo_fecha_desde.getValue(),
                hasta = padre.campo_fecha_hasta.getValue();
            console.log('desde',desde)
            console.log('hasta',hasta)



           /* this.store.baseParams = { id_sucursal:  this.maestro.id_sucursal};

            if(desde && hasta){
                this.store.baseParams=Ext.apply(this.store.baseParams,{ desde: desde.dateFormat('d/m/Y'),
                    hasta: hasta.dateFormat('d/m/Y')});
            }

            this.store.reload({ params: this.store.baseParams, callback : this.cargarChart, scope: this});*/


            Ext.Ajax.request({
                url:'../../sis_colas/control/Ficha/reporteStatus',
                params:{'otro':'','id_sucursal':this.maestro.id_sucursal,desde: desde.dateFormat('d/m/Y'),hasta: hasta.dateFormat('d/m/Y')},
                success: this.cargarChart,

                failure: this.conexionFailure,
                timeout:this.timeout,
                scope:this
            });





        },

        cmbTipo: new Ext.form.ComboBox({
            name: 'tipo',
            fieldLabel: 'Tipo',
            allowBlank: false,
            forceSelection : true,
            emptyText:'Tipo...',
            typeAhead: true,
            triggerAction: 'all',
            lazyRender: true,
            mode: 'local',
            width: 70,
            store: ['bar','pie','line','column'],
            value: 'column'
        }),




        cargarChart: function(resp){


            var resul = [];
            var reg = Ext.util.JSON.decode(Ext.util.Format.trim(resp.responseText));
            console.log('reg',reg)
            reg.datos.forEach(function(element) {
                console.log('ele',element)
                resul.push({

                    name: element.estado,
                    descripcion:element.porcentaje_estado,
                    y:parseInt(element.cantidad_estado)
                });

            });





            console.log('resultado.....',resul)
            //this.chart.series[0].remove();
            /*this.chart.series[0].setData({ name: 'Brands',
             colorByPoint: true,
             data: resul
             updatePoints:false});*/


            this.chart.series[0].setData(resul);

            //this.chart.redraw()

        },

        liberaMenu:function(){

        },
        preparaMenu: function(){

        },
        postReloadPage: function(){

        }



    });
</script>