<?php
/**
*@package pXP
*@file ACTFicha.php
*@author  (José Mita)
*@date 21-06-2016 10:11:23
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTFicha extends ACTbase{    
			
	function listarFicha(){
		
			
		
		$this->objParam->defecto('ordenacion','cola_atencion');

		$this->objParam->defecto('dir_ordenacion','desc');
		
		if($this->objParam->getParametro('filtroUsuario')=='si'){
             $this->objParam->addFiltro("ficha.id_servicio = ANY(cola.f_obtener_servicios(".$this->objParam->getParametro('id_sucursal').",". $_SESSION["ss_id_usuario"]." ))");
			$this->objParam->addFiltro("ficha.id_prioridad = ANY(cola.f_obtener_prioridades(".$this->objParam->getParametro('id_sucursal').",". $_SESSION["ss_id_usuario"]." ))");
        }
		
		if($this->objParam->getParametro('estado')!=''){
             $this->objParam->addFiltro("(estact.estado in (''" . $this->objParam->getParametro('estado') . "''))");
        }
		
		if(strtolower($this->objParam->getParametro('estado_ficha'))=='espera'){
             $this->objParam->addFiltro("(estact.estado in (''espera'',''llamado''))");
        }
		if(strtolower($this->objParam->getParametro('estado_ficha'))=='en_atencion'){
             $this->objParam->addFiltro("(estact.estado not in (''espera'',''finalizado'',''no_show''))");
        }
		if(strtolower($this->objParam->getParametro('estado_ficha'))=='finalizados'){
             $this->objParam->addFiltro("(estact.estado in (''finalizado'',''no_show''))");
        }
		
		if($this->objParam->getParametro('id_sucursal')!=''){
	    	$this->objParam->addFiltro("ficha.id_sucursal = ".$this->objParam->getParametro('id_sucursal'));	
		}
		
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODFicha','listarFicha');
		} else{
			$this->objFunc=$this->create('MODFicha');
			
			$this->res=$this->objFunc->listarFicha($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
	
	function listarFichaTotal(){
		$this->objParam->defecto('ordenacion','cantidad');

		$this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODFicha','listarFichaTotal');
		} else{
			$this->objFunc=$this->create('MODFicha');
			
			$this->res=$this->objFunc->listarFichaTotal($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarFicha(){
		$this->objFunc=$this->create('MODFicha');	
		if($this->objParam->insertar('id_ficha')){
			$this->res=$this->objFunc->insertarFicha($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarFicha($this->objParam);
		}




		$id_sucursal = $this->objParam->getParametro('id_sucursal');

        $data = array(
            "evento" => "sis_colas/nuevosTickets/".$id_sucursal."",
            "mensaje" => "tienes nuevo ticket campeon",

        );

        $send = array(
            "tipo" => "enviarMensaje",
            "data" => $data
        );


       $res = $this->dispararEventoWS($send);

		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarFicha(){
			$this->objFunc=$this->create('MODFicha');	
		$this->res=$this->objFunc->eliminarFicha($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
	
	function llamarSiguienteFicha(){
			$this->objFunc=$this->create('MODFicha');	
		$this->res=$this->objFunc->llamarSiguienteFicha($this->objParam);

        if ($this->res->getTipo() == 'ERROR') {
            $this->res->imprimirRespuesta($this->res->generarJson());
            exit;
        }


        $ficha = $this->res->getDatos();


        $id_sucursal = $this->objParam->getParametro('id_sucursal');


        $data = array(
            "evento" => "sis_colas/nuevaLlamadaPanel/".$id_sucursal."",
            "mensaje" => $ficha[0],

        );

        $send = array(
            "tipo" => "enviarMensaje",
            "data" => $data
        );

        $this->dispararEventoWS($send);


		$this->res->imprimirRespuesta($this->res->generarJson());
	}
	
	function rellamadaFicha(){
			$this->objFunc=$this->create('MODFicha');	
		$this->res=$this->objFunc->rellamadaFicha($this->objParam);
        

		$this->res->imprimirRespuesta($this->res->generarJson());
	}
	
	function derivarFicha(){
			$this->objFunc=$this->create('MODFicha');	
		$this->res=$this->objFunc->derivarFicha($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
	
	function finalizarFicha(){
			$this->objFunc=$this->create('MODFicha');	
		$this->res=$this->objFunc->finalizarFicha($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
	function iniciarAtencion(){
			$this->objFunc=$this->create('MODFicha');	
		$this->res=$this->objFunc->iniciarAtencion($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
	function noShowFicha(){
			$this->objFunc=$this->create('MODFicha');	
		$this->res=$this->objFunc->noShowFicha($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
	function llamarFichaPantalla(){
		$this->objParam->defecto('ordenacion','ultima_llamada');

		$this->objParam->defecto('dir_ordenacion','asc');
		
		if($this->objParam->getParametro('fecha_pantalla')!=''){
	    	$this->objParam->addFiltro("ficha.ultima_llamada >=   ''".$this->objParam->getParametro('fecha_pantalla')."''::timestamp ");
	    	$this->objParam->addFiltro("ficest.estado =   ''llamado'' ");
		}else{
			$this->objParam->addFiltro("ficest.estado !=   ''espera'' ");
		}
		if($this->objParam->getParametro('id_sucursal')!=''){
	    	$this->objParam->addFiltro("ficha.id_sucursal =   ".$this->objParam->getParametro('id_sucursal'));	
		}else{
			echo('Seleecione una Sucursal'); exit;
			
		}
		
			$this->objFunc=$this->create('MODFicha');
			
			$this->res=$this->objFunc->llamarFichaPantalla($this->objParam);
		
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
	function activarFicha(){
			$this->objFunc=$this->create('MODFicha');	
		$this->res=$this->objFunc->activarFicha($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
	function reporteStatus(){
			$this->objFunc=$this->create('MODFicha');
		$this->res=$this->objFunc->reporteStatus($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
	function reporteServicio(){
			$this->objFunc=$this->create('MODFicha');
		$this->res=$this->objFunc->reporteServicio($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
	function reporteTiempoAtencionEstado(){
			$this->objFunc=$this->create('MODFicha');
		$this->res=$this->objFunc->reporteTiempoAtencionEstado($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
	function reporteTiempoAtencionUsuario(){
			$this->objFunc=$this->create('MODFicha');
		$this->res=$this->objFunc->reporteTiempoAtencionUsuario($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
}

?>