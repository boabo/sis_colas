<?php
/**
 *@package pXP
 *@file ACTFicha.php
 *@author  (José Mita)
 *@date 21-06-2016 10:11:23
 *@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
 */
require_once(dirname(__FILE__).'/../reportes/RCuadroII.php');
require_once(dirname(__FILE__).'/../reportes/RCuadroIII.php');
require_once(dirname(__FILE__).'/../reportes/RCuadroVI.php');
class ACTReporte extends ACTbase{

    function listarTicketAtendido(){
        $this->objParam->defecto('ordenacion','id_ficha');

        $this->objParam->defecto('dir_ordenacion','asc');

        if($this->objParam->getParametro('fecha_ini')!=''){
            $this->objParam->addFiltro("f.fecha_reg::date >= ''" . $this->objParam->getParametro('fecha_ini') . "''::date");
        }

        if($this->objParam->getParametro('fecha_fin')!=''){
            $this->objParam->addFiltro("f.fecha_reg::date <= ''" . $this->objParam->getParametro('fecha_fin') . "''::date");
        }

        if($this->objParam->getParametro('id_sucursal')!=''){
            $this->objParam->addFiltro("f.id_sucursal = ".$this->objParam->getParametro('id_sucursal'));
        }

        if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
            $this->objReporte = new Reporte($this->objParam,$this);
            $this->res = $this->objReporte->generarReporteListado('MODReporte','listarTicketAtendido');
        } else{
            $this->objFunc=$this->create('MODReporte');

            $this->res=$this->objFunc->listarTicketAtendido($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }

    function listarTicketAtencion(){
        $this->objParam->defecto('ordenacion','id_ficha');

        $this->objParam->defecto('dir_ordenacion','asc');


        if($this->objParam->getParametro('id_sucursal')!=''){
            $this->objParam->addFiltro("f.id_sucursal = ".$this->objParam->getParametro('id_sucursal'));
        }

        if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
            $this->objReporte = new Reporte($this->objParam,$this);
            $this->res = $this->objReporte->generarReporteListado('MODReporte','listarTicketAtencion');
        } else{
            $this->objFunc=$this->create('MODReporte');

            $this->res=$this->objFunc->listarTicketAtencion($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }

    function listarTiemposArribo(){
        $this->objParam->defecto('ordenacion','hora');

        $this->objParam->defecto('dir_ordenacion','asc');

        if($this->objParam->getParametro('fecha_ini')!=''){
            $this->objParam->addFiltro("f.fecha_reg::date >= ''" . $this->objParam->getParametro('fecha_ini') . "''::date");
        }

        if($this->objParam->getParametro('fecha_fin')!=''){
            $this->objParam->addFiltro("f.fecha_reg::date <= ''" . $this->objParam->getParametro('fecha_fin') . "''::date");
        }

        if($this->objParam->getParametro('id_sucursal')!=''){
            $this->objParam->addFiltro("f.id_sucursal = ".$this->objParam->getParametro('id_sucursal'));
        }

        if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
            $this->objReporte = new Reporte($this->objParam,$this);
            $this->res = $this->objReporte->generarReporteListado('MODReporte','listarTiemposArribo');
        } else{
            $this->objFunc=$this->create('MODReporte');

            $this->res=$this->objFunc->listarTiemposArribo($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }

    function reporteCuadroI(){
        $this->objParam->defecto('ordenacion','hora');

        $this->objParam->defecto('dir_ordenacion','asc');

        if($this->objParam->getParametro('fecha_ini')!=''){
            $this->objParam->addFiltro("f.fecha_reg::date >= ''" . $this->objParam->getParametro('fecha_ini') . "''::date");
        }

        if($this->objParam->getParametro('fecha_fin')!=''){
            $this->objParam->addFiltro("f.fecha_reg::date <= ''" . $this->objParam->getParametro('fecha_fin') . "''::date");
        }

        if($this->objParam->getParametro('id_sucursal')!=''){
            $this->objParam->addFiltro("f.id_sucursal = ".$this->objParam->getParametro('id_sucursal'));
        }

        if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
            $this->objReporte = new Reporte($this->objParam,$this);
            $this->res = $this->objReporte->generarReporteListado('MODReporte','reporteCuadroI');
        } else{
            $this->objFunc=$this->create('MODReporte');

            $this->res=$this->objFunc->reporteCuadroI($this->objParam);
        }
        $this->res->setTotal(count($this->res->getDatos()));
        $this->res->imprimirRespuesta($this->res->generarJson());
    }

    function listarTiemposEspera(){
        $this->objParam->defecto('ordenacion','hora');

        $this->objParam->defecto('dir_ordenacion','asc');

        if($this->objParam->getParametro('fecha_ini')!=''){
            $this->objParam->addFiltro("f.fecha_reg::date >= ''" . $this->objParam->getParametro('fecha_ini') . "''::date");
        }

        if($this->objParam->getParametro('fecha_fin')!=''){
            $this->objParam->addFiltro("f.fecha_reg::date <= ''" . $this->objParam->getParametro('fecha_fin') . "''::date");
        }

        if($this->objParam->getParametro('id_sucursal')!=''){
            $this->objParam->addFiltro("f.id_sucursal = ".$this->objParam->getParametro('id_sucursal'));
        }

        if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
            $this->objReporte = new Reporte($this->objParam,$this);
            $this->res = $this->objReporte->generarReporteListado('MODReporte','listarTiemposEspera');
        } else{
            $this->objFunc=$this->create('MODReporte');

            $this->res=$this->objFunc->listarTiemposEspera($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }

    function listarTiemposEsperaDetalle(){
        $this->objParam->defecto('ordenacion','hora');

        $this->objParam->defecto('dir_ordenacion','asc');

        if($this->objParam->getParametro('fecha_ini')!=''){
            $this->objParam->addFiltro("f.fecha_reg::date >= ''" . $this->objParam->getParametro('fecha_ini') . "''::date");
        }

        if($this->objParam->getParametro('fecha_fin')!=''){
            $this->objParam->addFiltro("f.fecha_reg::date <= ''" . $this->objParam->getParametro('fecha_fin') . "''::date");
        }

        if($this->objParam->getParametro('id_sucursal')!=''){
            $this->objParam->addFiltro("f.id_sucursal = ".$this->objParam->getParametro('id_sucursal'));
        }

        if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
            $this->objReporte = new Reporte($this->objParam,$this);
            $this->res = $this->objReporte->generarReporteListado('MODReporte','listarTiemposEsperaDetalle');
        } else{
            $this->objFunc=$this->create('MODReporte');

            $this->res=$this->objFunc->listarTiemposEsperaDetalle($this->objParam);
        }
        $this->res->setTotal(count($this->res->getDatos()));
        $this->res->imprimirRespuesta($this->res->generarJson());
    }

    function listarHistoricoFichas(){
        $this->objParam->defecto('ordenacion','hora');

        $this->objParam->defecto('dir_ordenacion','asc');

        if($this->objParam->getParametro('fecha_ini')!=''){
            $this->objParam->addFiltro("fh.fecha_reg::date >= ''" . $this->objParam->getParametro('fecha_ini') . "''::date");
        }

        if($this->objParam->getParametro('fecha_fin')!=''){
            $this->objParam->addFiltro("fh.fecha_reg::date <= ''" . $this->objParam->getParametro('fecha_fin') . "''::date");
        }

        if($this->objParam->getParametro('id_sucursal')!=''){
            $this->objParam->addFiltro("fh.id_sucursal = ".$this->objParam->getParametro('id_sucursal'));
        }

        if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
            $this->objReporte = new Reporte($this->objParam,$this);
            $this->res = $this->objReporte->generarReporteListado('MODReporte','listarHistoricoFichas');
        } else{
            $this->objFunc=$this->create('MODReporte');

            if ($this->objParam->getParametro('id_sucursal') != '') {
                $this->res=$this->objFunc->listarHistoricoFichas($this->objParam);
                $temp = Array();
                $temp['total_cantidad_atendidas'] = $this->res->extraData['total_cantidad_atendidas'];
                $temp['total_cantidad_abandonadas'] = $this->res->extraData['total_cantidad_abandonadas'];
                $temp['totales_fichas'] = $this->res->extraData['totales_fichas'];
                $temp['tipo_reg'] = 'summary';
                //$temp['id_deposito'] = 0;

                $this->res->total++;
                $this->res->addLastRecDatos($temp);

            }else{
                $this->res=$this->objFunc->listarHistoricoFichas($this->objParam);

            }
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }
    function reporteCuadroIIyIII() {
        $this->objFunc=$this->create('MODReporte');
        //obtener titulo del reporte
        $titulo = 'Cuadro';
        //Genera el nombre del archivo (aleatorio + titulo)
        $nombreArchivo=uniqid(md5(session_id()).$titulo);
        $nombreArchivo.='.xls';
        $this->objParam->addParametro('nombre_archivo',$nombreArchivo);

        if($this->objParam->getParametro('fecha_ini')!=''){
            $this->objParam->addFiltro("f.fecha_reg::date >= ''" . $this->objParam->getParametro('fecha_ini') . "''::date");
        }

        if($this->objParam->getParametro('fecha_fin')!=''){
            $this->objParam->addFiltro("f.fecha_reg::date <= ''" . $this->objParam->getParametro('fecha_fin') . "''::date");
        }

        if($this->objParam->getParametro('id_sucursal')!=''){
            $this->objParam->addFiltro("f.id_sucursal = ".$this->objParam->getParametro('id_sucursal'));
        }

        if($this->objParam->getParametro('tipo_reporte')=='servicioXtiempo') {
            $this->res = $this->objFunc->listarHorasServicios($this->objParam);

            $this->objFunc=$this->create('MODReporte');
            $this->res2=$this->objFunc->listarCuadroII($this->objParam);

            $this->objParam->addParametro('parametros',$this->res->datos);

            $this->objParam->addParametro('datos',$this->res2->datos);
            //Instancia la clase de excel
            $this->objReporteFormato=new RCuadroII($this->objParam);

        } elseif($this->objParam->getParametro('tipo_reporte')=='operadorXtiempo') {
            $this->res = $this->objFunc->listarHorasUsuarios($this->objParam);

            $this->objFunc=$this->create('MODReporte');
            $this->res2=$this->objFunc->listarCuadroIII($this->objParam);
            $this->objParam->addParametro('parametros',$this->res->datos);
            $this->objParam->addParametro('datos',$this->res2->datos);

            //Instancia la clase de excel
            $this->objReporteFormato=new RCuadroIII($this->objParam);

        } elseif($this->objParam->getParametro('tipo_reporte')=='operadorXservicio') {
            $this->res = $this->objFunc->listarUsuariosServicio($this->objParam);

            $this->objFunc=$this->create('MODReporte');
            $this->res2=$this->objFunc->listarCuadroVI($this->objParam);

            $this->objParam->addParametro('parametros',$this->res->datos);
            $this->objParam->addParametro('datos',$this->res2->datos);

            //Instancia la clase de excel
            $this->objReporteFormato=new RCuadroVI($this->objParam);

        }

        if ($this->res->getTipo() == 'ERROR') {
            $this->res->imprimirRespuesta($this->res->generarJson());
            exit;
        }
        if ($this->res2->getTipo() == 'ERROR') {
            $this->res2->imprimirRespuesta($this->res2->generarJson());
            exit;
        }
        $this->objReporteFormato->imprimeDatos();
        $this->objReporteFormato->generarReporte();


        $this->mensajeExito=new Mensaje();
        $this->mensajeExito->setMensaje('EXITO','Reporte.php','Reporte generado',
            'Se generó con éxito el reporte: '.$nombreArchivo,'control');
        $this->mensajeExito->setArchivoGenerado($nombreArchivo);
        $this->mensajeExito->imprimirRespuesta($this->mensajeExito->generarJson());
    }

}

?>
