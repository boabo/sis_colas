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
        //this.load({params:{start:0, limit:this.tam_pag}})
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
				name: 'nombre',
				fieldLabel: 'Nombre',
				allowBlank: true,
				anchor: '200%',
				gwidth: 185,
				maxLength:20,
				renderer: function (value, p, record) {
						if (record.data['nombre'] == 'Atendidas') {
								return String.format('<div><b><font color="green" style="font-size:20px;"> {0}</font></b></div>', value);
						} else if (record.data['nombre'] == 'Espera') {
							return String.format('<div><b><font color="blue" style="font-size:20px;"> {0}</font></b></div>', value);
						} else if (record.data['nombre'] == 'No se Presento') {
							return String.format('<div><b><font color="red" style="font-size:20px;"> {0}</font></b></div>', value);
						}
				}
			},
				type:'TextField',
				filters:{pfiltro:'fichtot.nombre',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'cantidad',
				fieldLabel: 'Cantidad',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:4,
				renderer: function (value, p, record) {
						if (record.data['nombre'] == 'Atendidas') {
								return String.format('<div><b><font color="green" style="font-size:20px;">{0} <i class="fa fa-thumbs-up" aria-hidden="true"></i></font></b></div>', value);
						} else if (record.data['nombre'] == 'Espera') {
							return String.format('<div><b><font color="blue" style="font-size:20px;"> {0} <i class="fa fa-users" aria-hidden="true"></i></font></b></div>', value);
						} else if (record.data['nombre'] == 'No se Presento') {
							return String.format('<div><b><font color="red" style="font-size:20px;"> {0} <i class="fa fa-user-times" aria-hidden="true"></i></font></b></div>', value);
						}
				}
			},
				type:'NumberField',
				filters:{pfiltro:'fichtot.cantidad',type:'numeric'},
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
			this.maestro = m;
			this.store.baseParams = {id_sucursal:this.maestro.id_sucursal};
			// this.bloquearMenus();
		  this.load({params: {start: 0, limit: 50}});
		},


	mostrar:function(param){
		this.store.baseParams = {id_sucursal:param};
		// this.bloquearMenus();
		this.load({params: {start: 0, limit: 50}});
		Phx.vista.FichaTotal.superclass.loadValoresIniciales.call(this);
		console.log("LLEGA",param);

	}

	}
)
</script>
