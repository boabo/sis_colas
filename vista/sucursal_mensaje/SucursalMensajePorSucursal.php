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
    Phx.vista.SucursalMensajePorSucursal = {

        require: '../../../sis_colas/vista/sucursal_mensaje/SucursalMensaje.php',
        requireclase: 'Phx.vista.SucursalMensaje',
        title: 'Mensajes de la Sucursal',
        nombreVista: 'SucursalMensaje',


        preparaMenu: function (tb) {
            // llamada funcion clace padre
            Phx.vista.SucursalMensajePorSucursal.superclass.preparaMenu.call(this, tb)

        },
        onButtonNew: function () {
            Phx.vista.SucursalMensajePorSucursal.superclass.onButtonNew.call(this);

            this.getComponente('id_mensaje').setValue(this.maestro.id_mensaje);
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