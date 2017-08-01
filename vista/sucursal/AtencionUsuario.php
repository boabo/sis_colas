<?php
/**
 * @package pXP
 * @file AtencionUsuario.php
 * @author  (José Mita)
 * @date 15-06-2016 23:15:40
 * @description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
 */

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
    Phx.vista.AtencionUsuario = Ext.extend(Phx.gridInterfaz, {

            constructor: function (config) {
                this.maestro = config.maestro;
                //llama al constructor de la clase padre
                Phx.vista.AtencionUsuario.superclass.constructor.call(this, config);
                this.init();
                //this.load({params:{start:0, limit:this.tam_pag}})


            },

            Atributos: [

                {
                    config: {
                        name: 'desc_persona',
                        fieldLabel: 'Persona',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 100,
                        maxLength: 4
                    },
                    type: 'TextField',
                    filters: {pfiltro: 'sucur.codigo', type: 'string'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                },
                {
                    config: {
                        name: 'cantidad',
                        fieldLabel: 'Cantidad',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 150,
                        maxLength: 80
                    },
                    type: 'TextField',
                    filters: {pfiltro: 'sucur.cantidad', type: 'string'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                },

                {
                    config: {
                        name: 'espera',
                        fieldLabel: 'Espera',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 150,
                        maxLength: 80
                    },
                    type: 'TextField',
                    filters: {pfiltro: 'sucur.espera', type: 'string'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                },
                {
                    config: {
                        name: 'llamado',
                        fieldLabel: 'Llamado',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 150,
                        maxLength: 80
                    },
                    type: 'TextField',
                    filters: {pfiltro: 'sucur.llamado', type: 'string'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                },
                {
                    config: {
                        name: 'atencion',
                        fieldLabel: 'Atencion',
                        allowBlank: true,
                        anchor: '80%',
                        gwidth: 150,
                        maxLength: 80
                    },
                    type: 'TextField',
                    filters: {pfiltro: 'sucur.atencion', type: 'string'},
                    id_grupo: 1,
                    grid: true,
                    form: false
                },


            ],
            tam_pag: 1000,
            title: 'AtencionUsuario',
            ActList: '../../sis_colas/control/Ficha/reporteTiempoAtencionUsuario',
            id_store: 'id_sucursal',
            fields: [

                {name: 'desc_persona', type: 'string'},
                {name: 'cantidad', type: 'numeric'},
                {name: 'espera', type: 'numeric'},
                {name: 'llamado', type: 'numeric'},
                {name: 'atencion', type: 'numeric'},


            ],
            sortInfo: {
                field: 'id_sucursal',
                direction: 'ASC'
            },
            bdel: false,
            bnew: false,
            bedit: false,
            bsave: false,

        preparaMenu: function (tb) {
            // llamada funcion clace padre
            Phx.vista.AtencionUsuario.superclass.preparaMenu.call(this, tb)
        },
        onButtonNew: function () {
            Phx.vista.AtencionUsuario.superclass.onButtonNew.call(this);
            this.getComponente('id_sucursal').setValue(this.maestro.id_sucursal);
        },
        onReloadPage: function (m) {
            this.maestro = m;

            console.log('maestro',this.maestro)
            var padre = Phx.CP.getPagina(this.idContenedorPadre);
            var desde = padre.campo_fecha_desde.getValue(),
                hasta = padre.campo_fecha_hasta.getValue();




            this.store.baseParams ={'otro':'','id_sucursal':this.maestro.id_sucursal,desde: desde.dateFormat('d/m/Y'),hasta: hasta.dateFormat('d/m/Y')},

            this.load({params: {start: 0, limit: 50}})
        },



        }
    )
</script>
		
		