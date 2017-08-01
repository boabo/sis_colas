<?php
/**
 *@package pXP
 *@file MODParametrizacion.php
 *@author  (favio figueroa)
 *@date 21-06-2016 10:11:23
 *@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
 */

class MODParametrizacion extends MODbase{

    function __construct(CTParametro $pParam){
        parent::__construct($pParam);
    }

    function verArchivos(){

        $tipo_media = $this->objParam->getParametro('tipo');
        $ruta_videos = $this->objParam->getParametro('ruta_videos');

        //$path = "../../../sis_colas/colasWebApp/panel/media/".$tipo_media."/";
        $path = $ruta_videos;

        $dir = opendir($path);
        $files = array();
        while ($current = readdir($dir)){
            if( $current != "." && $current != "..") {


                if(is_dir($path.$current)) {
                   // showFiles($path.$current.'/');
                }
                else {
                    $files[] = $current;
                }
            }
        }

        $this->respuesta = new Mensaje();
        $this->respuesta->setMensaje('EXITO',$path, 'La consulta se ejecuto con exito de insercion de nota', 'La consulta se ejecuto con exito', 'base', 'no tiene', 'no tiene', 'SEL', '$this->consulta', 'no tiene');
        $this->respuesta->setTotal(1);
        $this->respuesta->setDatos($files);
        return $this->respuesta;
    }

}
?>