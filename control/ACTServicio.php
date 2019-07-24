<?php
/**
*@package pXP
*@file gen-ACTServicio.php
*@author  (admin)
*@date 15-06-2016 23:15:11
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTServicio extends ACTbase{

	function listarServicio(){
		$this->objParam->defecto('ordenacion','id_servicio');

		$this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODServicio','listarServicio');
		} else{
			$this->objFunc=$this->create('MODServicio');

			$this->res=$this->objFunc->listarServicio($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}

	 function listarServicioArb() {

		//obtiene el parametro nodo enviado por la vista
		$node=$this->objParam->getParametro('node');
		$id_servicio=$this->objParam->getParametro('id_servicio');


		if($node=='id'){
			$this->objParam->addParametro('id_servicio_fk','%');
		}
		else {
			$this->objParam->addParametro('id_servicio_fk',$id_servicio);
		}
		//crea el objetoFunSeguridad que contiene todos los metodos del sistema de seguridad
		$this->objFunc=$this->create('MODServicio');

		//$this->objParam->addParametro('id_subsistema',$id_subsistema);
		$this->res=$this->objFunc->listarServicioArb();

		$this->res->setTipoRespuestaArbol();

		$arreglo=array();

		array_push($arreglo,array('nombre'=>'id','valor'=>'id_servicio'));
		array_push($arreglo,array('nombre'=>'id_p','valor'=>'id_servicio_fk'));

		array_push($arreglo,array('nombre'=>'text','valor'=>'nombre'));
		array_push($arreglo,array('nombre'=>'cls','valor'=>'descripcion'));
		array_push($arreglo,array('nombre'=>'qtip','valores'=>'<b> #nombre#</b><br> #peso#'));


		//array_push($arreglo,array('nombre'=>'id_p','valor'=>'id_lugar_Fk'));


		/*se ande un nivel al arbol incluyendo con tido de nivel carpeta con su arreglo de equivalencias
		  es importante que entre los resultados devueltos por la base exista la variable\
		  tipo_dato que tenga el valor en texto = 'carpeta' */

		$this->res->addNivelArbol('tipo_nodo','raiz',array('leaf'=>false,
														'allowDelete'=>true,
														'allowEdit'=>true,
		 												'cls'=>'folder',
		 												'tipo_nodo'=>'raiz',
		 												'icon'=>'../../../lib/imagenes/a_form.png'),
		 												$arreglo);



		/*se ande un nivel al arbol incluyendo con tido de nivel carpeta con su arreglo de equivalencias
		  es importante que entre los resultados devueltos por la base exista la variable\
		  tipo_dato que tenga el valor en texto = 'hoja' */


		 $this->res->addNivelArbol('tipo_nodo','hijo',array(
														'leaf'=>false,
														'allowDelete'=>true,
														'allowEdit'=>true,
		 												'tipo_nodo'=>'hijo',
		 												'icon'=>'../../../lib/imagenes/a_form.png'),
		 												$arreglo);


		//Se imprime el arbol en formato JSON
		$this->res->imprimirRespuesta($this->res->generarJson());



	}

	function listarServicioCombo(){
		$this->objParam->defecto('ordenacion','id_servicio');

		$this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODServicio','listarServicioCombo');
		} else{
			$this->objFunc=$this->create('MODServicio');

			$this->res=$this->objFunc->listarServicioCombo($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}

	function insertarServicio(){
		$this->objFunc=$this->create('MODServicio');
		if($this->objParam->insertar('id_servicio')){
			$this->res=$this->objFunc->insertarServicio($this->objParam);
		} else{
			$this->res=$this->objFunc->modificarServicio($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}

	function eliminarServicio(){
			$this->objFunc=$this->create('MODServicio');
		$this->res=$this->objFunc->eliminarServicio($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}


    function listarServicioUltimoNivel(){
        $this->objParam->defecto('ordenacion','id_servicio');

        $this->objParam->defecto('dir_ordenacion','asc');
        if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
            $this->objReporte = new Reporte($this->objParam,$this);
            $this->res = $this->objReporte->generarReporteListado('MODServicio','listarServicio');
        } else{
            $this->objFunc=$this->create('MODServicio');

            $this->res=$this->objFunc->listarServicioUltimoNivel($this->objParam);
        }
        $this->res->imprimirRespuesta($this->res->generarJson());
    }

		function listarServicioUsuario(){
			if($this->objParam->getParametro('excluir')=='SI'){
					$this->objParam->addFiltro("id_servicio not in (1)");
			}
				$this->objFunc=$this->create('MODServicio');
				$this->res=$this->objFunc->listarServicioUsuario($this->objParam);
				$this->res->imprimirRespuesta($this->res->generarJson());
		}



}

?>
