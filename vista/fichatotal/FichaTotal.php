<?php
/**
*@package pXP
*@file Fichatotal.php
*@author  (admin)
*@date 12-06-2017 21:56:45
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.FichaTotal=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		Phx.vista.FichaTotal.superclass.constructor.call(this,config);
		this.init();
        this.load({params:{start:0, limit:this.tam_pag}})
	},
			
	Atributos:[
		/*{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_ficha_total'
			},
			type:'Field',
			form:true 
		},*/
		{
			config:{
				name: 'cantidad',
				fieldLabel: 'cantidad',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:4
			},
				type:'NumberField',
				filters:{pfiltro:'fichtot.cantidad',type:'numeric'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'nombre',
				fieldLabel: 'nombre',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:20
			},
				type:'TextField',
				filters:{pfiltro:'fichtot.nombre',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		}
	],
	tam_pag:50,	
	title:'Ficha Total',
	
	ActList:'../../sis_colas/control/Ficha/listarFichaTotal',
	id_store:'nombre',
	fields: [
		//{name:'id_ficha_total', type: 'numeric'},
		{name:'cantidad', type: 'numeric'},
		{name:'nombre', type: 'string'}
	],
	sortInfo:{
		field: 'nombre',
		direction: 'ASC'
	},
	bedit:false,
    bnew:false,
    bsave:false,
    bdel:false,
    onReloadPage: function (m) {
        
    },
	}
)
</script>
		
		