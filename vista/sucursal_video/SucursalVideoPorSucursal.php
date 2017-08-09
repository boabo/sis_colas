<?php
/**
 *@package pXP
 *@file gen-SistemaDist.php
 *@author  (favio figueroa)
 *@date 16-09-2015 10:22:05
 *@description Archivo con la interfaz de usuario que permite
 *dar el visto a solicitudes de compra
 *
 */
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
    Phx.vista.SucursalVideoPorSucursal = {

        require: '../../../sis_colas/vista/sucursal_video/SucursalVideo.php',
        requireclase: 'Phx.vista.SucursalVideo',
        title: 'Videos de la Sucursal',
        nombreVista: 'SucursalVideo',

        constructor: function(config) {
            Phx.vista.SucursalVideoPorSucursal.superclass.constructor.call(this,config);
            var dataPadre = Phx.CP.getPagina(this.idContenedorPadre).getSelectedData();
            if (dataPadre) {
                this.onReloadPage(dataPadre)

            }
            else {
                console.log('disbled')
            }
        },

        preparaMenu: function (tb) {
            // llamada funcion clace padre
            Phx.vista.SucursalVideoPorSucursal.superclass.preparaMenu.call(this, tb)

        },
        onButtonNew: function () {
            Phx.vista.SucursalVideoPorSucursal.superclass.onButtonNew.call(this);

            this.getComponente('id_video').setValue(this.maestro.id_video);
        },
        onReloadPage: function (m) {
            this.maestro = m;
            console.log(this.maestro);
            this.store.baseParams = {id_sucursal: this.maestro.id_sucursal};


            this.load({params: {start: 0, limit: 50}})
        },
        bdel:false,
        bsave:false,
        bnew:false,
        bedit:false,



    };
</script>