/**
 * Created by faviofigueroa on 29/7/16.
 */
(function ($) {


    var sucursal = localStorage.getItem("sucursal_panel");
    var user = localStorage.getItem("userPXP_panel");
    var contra = localStorage.getItem("contraPXP_panel");
    var id_usuario = localStorage.getItem("id_usuario");
    var nombre_usuario = localStorage.getItem("nombre_usuario");
    var puerto_web_socket = localStorage.getItem("puerto_web_socket");

    var hostname;


    config.usPxp = user;
    config.pwdPxp = contra;
    config.tipo_ruta = localStorage.getItem("tipoHost_panel");

    if (localStorage.getItem("tipoHost_panel") == "DOMINIO") {
        var dominio = localStorage.getItem("dominioPXP_panel");

        config.DOMINIO.url = dominio;
        hostname = dominio;

    } else if (localStorage.getItem("tipoHost_panel") == "IP") {

        var host = localStorage.getItem("hostPXP_panel");
        var carpeta = localStorage.getItem("carpetaPxp_panel");

        config.IP.ip = host;
        config.IP.carpeta = carpeta;

        hostname = host;

    } else {
        alert("hay un error en su configuracion revisa tu configuracion");
    }


    config.init();

    clientRestPxp.setCredentialsPxp(config.usPxp, config.pwdPxp);
    clientRestPxp.genHeaders();

    /*
    *
    * localStorage.setItem("tiempoEspera_panel", $("#tiempo_espera_peticion").val());
     localStorage.setItem("tiempoNuevo_panel", $("#tiempo_nueva_peticion_panel").val());
     localStorage.setItem("sonidoLLamadoTono", $("#sonido_llamado_tono").val());
     localStorage.setItem("volumenLLamadoTono", $("#volumen_sonido_llamado_tono").val());
     localStorage.setItem("sonidoLLamadoVoz", $("#sonido_llamado_voz").val());
     localStorage.setItem("volumenLLamadoVoz", $("#volumen_sonido_llamado_voz").val());
     */

    var jsonArchivos = {
        sort: 'tabla.id_video',
        limit: 500,
        start: 0,
        dir: 'asc',
        tipo_archivo: 'videos',
        filtros: [
            {
                campo: 'suc.id_sucursal',
                tipo_filtro: 'igual',
                valor: parseInt(sucursal),
            }
        ]
    };
    console.log('jsonArchivos',jsonArchivos)

    panel = {
        tiempoEspera_panel:localStorage.getItem("tiempoEspera_panel"),
        tiempoNuevo_panel:localStorage.getItem("tiempoNuevo_panel"),
        sonidoLLamadoTono:localStorage.getItem("sonidoLLamadoTono"),
        volumenLLamadoTono:localStorage.getItem("volumenLLamadoTono"),
        sonidoLLamadoVoz:localStorage.getItem("sonidoLLamadoVoz"),
        volumenLLamadoVoz:localStorage.getItem("volumenLLamadoVoz"),
        volumenVideo:localStorage.getItem("volumenVideo"),
        tiempoActualizarMensaje:localStorage.getItem("tiempoActualizarMensaje"),
        ruta_videos:localStorage.getItem("ruta_videos"),
        /*esta ruta si esta definido en la configuracion usaremos la ruta de configuracion en caso de que no
        * usaremos la ruta directa que esta en el servidor */
        ruta_audio_panel:(localStorage.getItem("ruta_audio_panel")!= '')?localStorage.getItem("ruta_audio_panel"):'media',

        primera_vez: 'si',
        fecha_ultima_llamada: "",
        alert: 'ekiga-vm.wav',
        cola: [],
        cola_vista: [],
        enProceso: false,
        limit: 6,
        dir: 'desc',
        hacerAjax: 'si',
        countError:0,

        mensajesPXP : 'si',
        init: function () {
            console.log(this)

            if (panel.sonidoLLamadoTono == 'si'){
                panel.Alert.play();
            }


            /*var ficha= {
             sigla:"abc-150"
             };
             this.Speech.play(ficha);*/
            this.panelAjax();


        },
        Alert: {

            play: function (filename) {
                filename = filename || panel.alert;
                $("#alert").attr("src", panel.ruta_audio_panel+'/alert/' + filename);
                $("#alert")[0].play();
                $("#alert")[0].volume = localStorage.getItem("volumenLLamadoTono") / 10;

            }
        },
        panelAjax: function () {

            var self = this;
            ajax_dyd.data = {
                start: "0",
                limit: self.limit,
                sort: "ultima_llamada",
                dir: this.dir,
                id_sucursal: sucursal,
                fecha_pantalla: self.fecha_ultima_llamada
            };
            ajax_dyd.type = 'POST';
            ajax_dyd.url = 'pxp/lib/rest/colas/Ficha/llamarFichaPantalla';
            ajax_dyd.dataType = 'json';
            ajax_dyd.async = true;
            ajax_dyd.timeout_= panel.tiempoEspera_panel * 1000;
            ajax_dyd.peticion_ajax(function (resp) {


                self.hacerAjax = 'si';
                //vemos si existe un error en el servidor
                if(resp.ROOT != undefined){

                    alert("Ha ocurrido un error en el servidor. Revise los logs y actualice la pagina");
                    self.hacerAjax = 'no';
                    return;

                }

                if (resp.estado == "error") {
                    
                    self.hacerAjax = 'no';
                    self.countError++;
                    if(self.countError < 3){
                        console.log('error pero intentara nuevamente');
                        setTimeout(function () {
                            self.panelAjax();
                        }, panel.tiempoNuevo_panel*1000);
                    }else{
                        console.log("error dejara de hacer peticiones");
                        if(resp.t==="timeout") {
                            alert("Problemas de red , esta demorando demasiado la peticion, actualizar por favor");
                        } else {
                            alert(t+" actualizar por favor");
                        }
                    }
                    return;
                }



                if (self.hacerAjax == 'si') {

                    self.countError = 0;

                    if (resp.datos.length > 0) {
                        self.fecha_ultima_llamada = resp.datos[0].fecha_respuesta;
                    }

                    //cuando inicia recien la pagina
                    if (self.primera_vez == 'si') {

                        self.primera_vez = 'no';
                        $.each(resp.datos, function (k, v) {

                            self.cola_vista.push(v);

                            //va a dibujar los 6 objetos no pueden ser mas
                            $(".contenedor_cajas").append('<div id="' + v.sigla + '" class="caja_panel">' + v.sigla + ' -> ' + v.letra_ventanila + v.numero_ventanilla + '</div>');


                        });
                        self.limit = 1000;
                        self.dir = "asc";


                        console.log('cola vista', self.cola_vista)

                    } else if (self.primera_vez = 'no') {//cuando ya es la segunda peticion

                        console.log('resp.datos.length',resp.datos.length)
                        if (resp.datos.length > 0) {

                            console.log('llega')
                            console.log('self.enProceso',self.enProceso)

                            $.each(resp.datos, function (k, v) {
                                self.cola.push(v);
                                console.log('llega',v)

                            });


                            if (self.enProceso == false) {
                                console.log('ya no hay cola se inicia otra vez el proceso');
                                self.procesarCola();
                            }


                        }

                    }


                   /* setTimeout(function () {
                        self.panelAjax();
                    }, panel.tiempoNuevo_panel*1000);*/
                }


            });


        },
        procesarCola: function () {

            if (this.cola.length > 0) {

                this.enProceso = true;

                panel.Alert.play();


                var atendimiento = this.cola.shift(); // agrego el atendimiento nuevo segun su entrada

                var result = $.grep(this.cola_vista, function (e) {
                    return e.sigla == atendimiento.sigla;
                });

                console.log('result', result);

                var rellamada = 'no';
                //vemos si existe ya un llamado si existe es una re llamada
                if (result.length > 0) {

                    console.log('entra a re llamada')
                    var data = $.grep(this.cola_vista, function (e) {
                        return e.sigla != atendimiento.sigla;
                    });

                    //aca inicio la cola vista con todos los datos iguales pero quitanto la re llamada
                    this.cola_vista = data;

                    var quitar_atendimiento = {
                        sigla: atendimiento.sigla
                    };//quito el objeto de los datos el mas antiguo

                    rellamada = 'si';

                }


                this.cola_vista.push(atendimiento);//agrego a los datos de la vista el nuevo atendimiento


                if (rellamada == 'no') {
                    if (this.cola_vista.length <= 6) {
                        console.log('menor a 6')
                    } else {

                        this.cola_vista.shift();
                        console.log('igual o mayor a 6')

                    }

                }

                /*if(this.cola_vista.length > 5 && rellamada == 'no' ){
                 console.log('entra a remover')
                 console.log('quitar',quitar_atendimiento)
                 $("#"+quitar_atendimiento.sigla).remove(); //elimino de la vista html

                 }*/


                $(".contenedor_cajas").empty();

                $.each(this.cola_vista, function (k, v) {

                    $(".contenedor_cajas").prepend('<div id="' + v.sigla + '" class="caja_panel">' + v.sigla + ' -> ' + v.letra_ventanila + v.numero_ventanilla + '</div>');


                });


                //cambiamos el color de la letra
                $("#" + atendimiento.sigla).addClass("llamado");
                setTimeout(function () {
                    //volvemos a poner el color normal despues de llamar
                    $("#" + atendimiento.sigla).removeClass("llamado");
                }, 1800);

                //dibujo a la vista html el atendimientos
                //$(".contenedor_cajas").prepend('<div id="'+atendimiento.sigla+'" class="caja_panel">'+atendimiento.sigla+' -> '+atendimiento.letra_ventanila+atendimiento.numero_ventanilla+'</div>');

                $("#" + atendimiento.sigla).fadeTo(300, 0.1).fadeTo(300, 1.0).fadeTo(300, 0.1).fadeTo(300, 1.0).fadeTo(300, 0.1).fadeTo(300, 1.0);


                if(panel.sonidoLLamadoVoz == "si"){
                    this.Speech.play(atendimiento);
                }else{
                    //procesamos otra vez
                    panel.procesarCola();
                }



            } else {
                this.enProceso = false;
                return;
            }


        },
        Speech: {
            queue: [],


            play: function (ficha) {

                //ficha audio
                this.queue.push({name: "ficha"});

                var sigla_num = ficha.sigla.split('-');

                //hacemos que hable la sigla las letras
                var sigla = sigla_num[0];
                sigla = sigla.toLowerCase();
                for (var i = 0; i < sigla.length; i++) {
                    this.queue.push({name: sigla.charAt(i).toLowerCase()});
                }


                //haacemos que hable los numeros
                var num = parseInt(sigla_num[1]);
                num = num + "";
                if (num.length == 3) {

                    var res = num.charAt(0);
                    console.log(res)
                    var ciento = "";
                    switch (parseInt(res)) {
                        case 1:
                            ciento = "ciento";
                            break;
                        case 2:
                            ciento = "doscientos";
                            break;
                        case 3:
                            ciento = "trescientos";
                            break;
                        case 4:
                            ciento = "cuatrocientos";
                            break;
                        case 5:
                            ciento = "quiñientos";
                            break;
                        case 6:
                            ciento = "seiscientos";
                            break;
                        case 7:
                            ciento = "setecientos";
                            break;
                        case 8:
                            ciento = "ochocientos";
                            break;
                        case 9:
                            ciento = "novecientos";
                            break;
                    }
                    this.queue.push({name: ciento});

                    var res2 = num.charAt(1) + num.charAt(2);
                    var res2 = parseInt(res2);
                    res2 = res2 + "";
                    this.queue.push({name: res2});
                    console.log('asd', this.queue)

                } else if (num.length == 2) {

                    var res2 = num.charAt(0) + num.charAt(1);
                    this.queue.push({name: res2});

                } else if (num.length == 1) {
                    this.queue.push({name: num});
                }

                //tipo de ventanilla
                this.queue.push({name: ficha.desc_tipo_ventanilla.toLowerCase()});

                //numero de ventanilla
                this.queue.push({name: ficha.numero_ventanilla});

                this.processQueue();

            },


            playFile: function (filename) {
                var self = this;
                console.log('llega audio')
                var bz = new buzz.sound(filename, {
                    formats: ["wav"],
                    autoplay: true,
                    volume:localStorage.getItem("volumenLLamadoVoz")*20
                });

                bz.bind("ended", function () {
                    buzz.sounds = [];
                    console.log('llega audio')
                    self.processQueue();


                });
            },

            processQueue: function () {
                var self = this;
                if (this.queue.length === 0) {
                    panel.procesarCola();
                    return;
                }
                if (buzz.sounds.length > 0) {
                    return;
                }
                var current = this.queue.shift();
                var filename = panel.ruta_audio_panel+"/audios/" + current.name; // toque

                this.playFile(filename);
                //verificamos si existe
                /*if(existeUrl(filename)){
                    this.playFile(filename);
                }else{ //si no existe volvemos aprocesar directamente el siguiente

                    this.processQueue();
                }*/

                 function existeUrl(url) {
                    var http = new XMLHttpRequest();
                    http.open('HEAD', url+".wav", false);
                    http.send();
                    return http.status!=404;
                }


            }
        },
        media: [],
        nombreActualReproducido: "",
        nueva_peticion:'no',
        MediaVideosImagenes: function () {


            var objectJsonArchivo = Object.create(jsonArchivos);

            if (jsonArchivos.filtros != undefined) {
                objectJsonArchivo.filtros = JSON.stringify(objectJsonArchivo.filtros);
            }

            var self = this;
            ajax_dyd.data = objectJsonArchivo;
            ajax_dyd.type = 'POST';
            ajax_dyd.url = 'pxp/lib/rest/parametros/Archivo/listarArchivoTabla';
            ajax_dyd.dataType = 'json';
            ajax_dyd.async = true;
            ajax_dyd.peticion_ajax(function (callback) {

                //self.media = callback.datos;
                $.each(callback.datos,function (k,v) {

                    console.log(v)
                    console.log(v.extension)
                    console.log(v.nombre_archivo)
                    self.media[k] = v.folder + v.nombre_archivo +'.'+v.extension;
                });

                console.log(self.media)

                self.cargarVideos();
            });

            setTimeout(function () {
               panel.nueva_peticion = 'si';
            }, panel.tiempoActualizarMensaje*60000);


        },
        cargarVideos: function () {


            var self = this;
            //panel.ruta_videos = './../../../uploaded_files/sis_parametros/Archivo/./../../../uploaded_files/sis_colas//videos//';

            var reproductor = $("#reproductor"),
                videos = this.media;
            console.log(this.media)

            //info = document.getElementById("info2");

            //info.innerHTML = "Vídeo: " + videos[0];
            console.log($("#reproductor"));
            //$("#reproductor").attr("src", "media/videos/" + videos[0]);
            $("#reproductor").attr("src",  videos[0]);
            $("#reproductor").get(0).play();
            $("#reproductor").get(0).volume = panel.volumenVideo/15;

            self.nombreActualReproducido = videos[0];

            var actual_;

            $('#reproductor').on('ended', function () {

                if(panel.nueva_peticion == 'no'){
                    var nombreActual = self.nombreActualReproducido;
                    var actual = videos.indexOf(nombreActual);
                    console.log(actual);
                    actual = actual == videos.length - 1 ? 0 : actual + 1;
                    //this.src = "media/videos/" + videos[actual];
                    this.src =  videos[actual];
                    this.type = "video/mp4";
                    self.nombreActualReproducido = videos[actual];

                    actual_ = actual;

                    this.play();
                }else{
                    //cuando existe nuva peticion para hacer
                    panel.nueva_peticion = 'no'; //lo volvemos a poner en no para que siga el ciclo
                    console.log('nueva carga de videos');
                    panel.MediaVideosImagenes();

                }



            });

            $('#reproductor').on('error', function (e) {

                console.log(e)
                console.log(this)
                //alert("ocurrio un error con el video");

                console.log('video que no reproducio' , videos[actual_]);
                console.log('videoS' , videos);

                var nombreActual = self.nombreActualReproducido;
                var actual = videos.indexOf(nombreActual);
                console.log(actual);
                actual = actual == videos.length - 1 ? 0 : actual + 1;
                //this.src = "media/videos/" + videos[actual];
                this.src = videos[actual];
                this.type = "video/mp4";
                self.nombreActualReproducido = videos[actual];


                this.play();

            });


            //reproductor.muted = true;


            /* reproductor.volume = 0.05;

             console.log(videos[0])*/

            /*reproductor.addEventListener("ended", function() {
             var nombreActual = info.innerHTML.split(": ")[1];
             var actual = videos.indexOf(nombreActual);
             console.log(actual);
             actual = actual == videos.length - 1 ? 0 : actual + 1;
             this.src = "includes/videos/"+videos[actual] + ".mp4";
             this.type="video/mp4";
             info.innerHTML = "Vídeo: " + videos[actual];

             if(videos[actual] == "adulto_mayor"){
             reproductor.volume = 0.05;
             }else{
             reproductor.volume = 0;
             }
             this.play();


             }, false);*/


        },
        errorVideo : function (e) {

            console.log('ERRORRRRR',e)
        },
        
        
        //mensajes
        mensajes :function () {

            //el tiempo es por 60000 por que son minutos
            this.listarMensajes();
            var self = this;


        },
        listarMensajes:function () {
            ajax_dyd.data = {
                start: "0",
                limit: 100,
                sort: "id_mensaje",
                dir: "asc",
                id_sucursal: sucursal,
            };

            ajax_dyd.type = 'POST';
            ajax_dyd.url = 'pxp/lib/rest/colas/SucursalMensaje/listarSucursalMensaje';
            ajax_dyd.dataType = 'json';
            ajax_dyd.async = true;
            ajax_dyd.timeout_= panel.tiempoEspera_panel * 1000;
            ajax_dyd.peticion_ajax(function (resp) {


                console.log( resp );
                var m = '<marquee  style="color: #ffffff; font-family: RobotoRegular;"  scrollamount="5" loop="infinite">';

                $.each(resp.datos,function (k,v) {
                    console.log(v)
                    m+=v.mensaje;
                    m+='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                    m+='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                    m+='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                });
                m+='</marquee>';
                $("#texto_contenido").html(m);

            });

            setTimeout(function () {
                panel.listarMensajes();
            }, panel.tiempoActualizarMensaje*60000);
        }




    }

    webSocket = {



        obtenerCokie:function (cname) {


            var name = cname + "=";
            var ca = document.cookie.split(';');
            for(var i=0; i<ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0)==' ') c = c.substring(1);
                if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
            }
            return "";

        },
        iniciar: function () {
            var puerto = puerto_web_socket;

            console.log('session',webSocket.obtenerCokie('PHPSESSID'))
            webSocket.conn = new WebSocket('ws://'+hostname+':'+puerto+'?sessionIDPXP='+webSocket.obtenerCokie('PHPSESSID'));
            webSocket.conn.onopen = function (e) {
                console.log("Conecion establecida");

                webSocket.escucharEvento( 'sis_colas/nuevaLlamadaPanel/'+sucursal+'',0,'',this);


            };

            webSocket.conn.onmessage = function (e) {

                console.log(e)
                var jsonData = JSON.parse(e.data);
                var data = jsonData.data;
                var mensaje = jsonData.mensaje;

                console.log(data)
                console.log(mensaje)

                panel.cola.push(mensaje);

                console.log(panel.enProceso);
                if (panel.enProceso == false) {
                    console.log('ya no hay cola se inicia otra vez el proceso');
                    panel.procesarCola();
                }


            };

        },

        //x es el this de la vista es el scope que tendremos
        escucharEvento:function(evento,id_contenedor,metodo,scope){



            //crear json
            var json = JSON.stringify({
                data: {"id_usuario": id_usuario,"nombre_usuario":nombre_usuario ,"evento": evento,"id_contenedor":id_contenedor,"metodo":metodo},
                tipo: "escucharEvento"

            });

            console.log(json)
            webSocket.conn.send(json);




        },

    }

    panel.init();
    webSocket.iniciar();




})(jQuery);