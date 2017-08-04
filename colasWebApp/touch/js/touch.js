/**
 * Created by faviofigueroa on 06/06/17.
 */
(function ($) {

    $("#imprimir").hide();

    var sucursal = localStorage.getItem("sucursal");
    var user = localStorage.getItem("userPXP");
    var contra = localStorage.getItem("contraPXP");

    config.usPxp = user;
    config.pwdPxp = contra;
    config.tipo_ruta  = localStorage.getItem("tipoHost");

    if(localStorage.getItem("tipoHost") == "DOMINIO"){
        var dominio = localStorage.getItem("dominioPXP");

        config.DOMINIO.url = dominio;

    }else if(localStorage.getItem("tipoHost") == "IP"){

        var host = localStorage.getItem("hostPXP");
        var carpeta = localStorage.getItem("carpetaPxp");

        config.IP.ip = host;
        config.IP.carpeta = carpeta;

    }else {
        alert("hay un error en su configuracion revisa tu configuracion");
    }






    config.init();
    clientRestPxp.setCredentialsPxp(config.usPxp, config.pwdPxp);
    clientRestPxp.genHeaders();

    touch = {


        ficha : function (id_servicio,id_prioridad){

        console.log('prioridad',id_prioridad)
        $("#left-drawer-menu").hide();

        ajax_dyd.data = {id_ficha:"",numero:"",id_sucursal:sucursal,sigla:"",id_servicio:id_servicio,id_prioridad:id_prioridad,peso:"1"};
        ajax_dyd.type = 'POST';
        ajax_dyd.url = 'pxp/lib/rest/colas/Ficha/insertarFicha';
        ajax_dyd.dataType = 'json';
        ajax_dyd.async = true;
        ajax_dyd.peticion_ajax(function (callback) {

            console.log(callback.ROOT.datos.v_fecha_reg)

            var time = callback.ROOT.datos.v_fecha_reg.split(" ");
            console.log(time)

            $("#siglaNum").empty();
            $("#siglaNum").append(callback.ROOT.datos.sigla);

            $("#fecha_ficha").empty();
            $("#fecha_ficha").append(time[1]);

            var texto = '<!DOCTYPE html>'+
                '<html ng-app="TriagemTouch">'+
                '<head>'+
                '<title></title>'+
                '<link type="text/css" rel="stylesheet" href="css/print/print.css" />'+

                '<link rel="shortcut icon" href="images/favicon.png" />'+
                '</head>'+
                ' <body onload="print()">'+

                '<div id="senha">'+
                ' <div id="senha-header">'+
                '<center>'+
                '<div><center>BoA</center></div>'+
                ''+callback.ROOT.datos.nombre_suc+''+

                '<div id="senha-body">'+
                ''+callback.ROOT.datos.sigla+''+
                '<span class="descricao">'+
                callback.ROOT.datos.v_fecha_reg+
                '</span>'+


                '</div>'+
                '<div id="senha-footer">'+
                callback.ROOT.datos.mensaje_impresion+
                '</div>'+
                '</center>'+
                '</div>'+
                '</body>'+
                '</html>';

            var iframes = document.querySelectorAll('iframe');
            for (var i = 0; i < iframes.length; i++) {
                iframes[i].parentNode.removeChild(iframes[i]);
            }

            ifrm = document.createElement("IFRAME");
            ifrm.name = 'mifr';
            ifrm.id = 'mifr';
            //document.body.appendChild(ifrm);
            $('#imprimir').append(ifrm);
            var doc = window.frames['mifr'].document;
            doc.open();
            doc.write(texto);
            doc.close();






            servicio('','id');


        });

    }


    }

})(jQuery);