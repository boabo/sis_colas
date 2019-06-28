<?php
/**
*@package pXP
*@file Servicio.php
*@author  Browser - José Mita
*@date 15-06-2016 23:15:11
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.Servicio=Ext.extend(Phx.arbInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		Phx.vista.Servicio.superclass.constructor.call(this,config);
		this.init();
		//this.load({params:{start:0, limit:this.tam_pag}})
	},

	Atributos:[
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_servicio'
			},
			type:'Field',
			form:true
		},
		{
			config:{
				name: 'estado_reg',
				fieldLabel: 'Estado Reg.',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:10
			},
				type:'TextField',
				filters:{pfiltro:'servi.estado_reg',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config: {
				labelSeparator:'',
					inputType:'hidden',
					name: 'id_servicio_fk'
			},
			type:'Field',
			form:true
		},
		{
			config:{
				name: 'sigla',
				fieldLabel: 'Sigla',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:2
			},
				type:'TextField',
				filters:{pfiltro:'servi.sigla',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'nombre',
				fieldLabel: 'Nombre',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:50
			},
				type:'TextField',
				filters:{pfiltro:'servi.nombre',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'descripcion',
				fieldLabel: 'Descripción',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:100
			},
				type:'TextField',
				filters:{pfiltro:'servi.descripcion',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},

		{
			config: {
				name: 'peso',
				fieldLabel: 'Peso',
				allowBlank: false,
				emptyText: 'peso...',
				typeAhead: true,
				triggerAction: 'all',
				lazyRender: true,
				mode: 'local',
				store: ['1', '2','3','4','5'],
				width: 100
				},
				type: 'ComboBox',
				filters: {pfiltro: 'servi.peso', type: 'numeric'},
				id_grupo: 1,
				form: true,
				grid: true
		},

		{
			config:{
				name: 'fecha_reg',
				fieldLabel: 'Fecha creación',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
							format: 'd/m/Y',
							renderer:function (value,p,record){return value?value.dateFormat('d/m/Y H:i:s'):''}
			},
				type:'DateField',
				filters:{pfiltro:'servi.fecha_reg',type:'date'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'usuario_ai',
				fieldLabel: 'Funcionaro AI',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:300
			},
				type:'TextField',
				filters:{pfiltro:'servi.usuario_ai',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'usr_reg',
				fieldLabel: 'Creado por',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:4
			},
				type:'Field',
				filters:{pfiltro:'usu1.cuenta',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'id_usuario_ai',
				fieldLabel: 'Creado por',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:4
			},
				type:'Field',
				filters:{pfiltro:'servi.id_usuario_ai',type:'numeric'},
				id_grupo:1,
				grid:false,
				form:false
		},
		{
			config:{
				name: 'fecha_mod',
				fieldLabel: 'Fecha Modif.',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
							format: 'd/m/Y',
							renderer:function (value,p,record){return value?value.dateFormat('d/m/Y H:i:s'):''}
			},
				type:'DateField',
				filters:{pfiltro:'servi.fecha_mod',type:'date'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'usr_mod',
				fieldLabel: 'Modificado por',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:4
			},
				type:'Field',
				filters:{pfiltro:'usu2.cuenta',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
		}
	],
	tam_pag:50,
	title:'Servicios',
	ActSave:'../../sis_colas/control/Servicio/insertarServicio',
	ActDel:'../../sis_colas/control/Servicio/eliminarServicio',
	ActList:'../../sis_colas/control/Servicio/listarServicioArb',
	id_store:'id_servicio',
	enableDD:false,
		expanded:false,
		fheight:'80%',
		fwidth:'50%',
		textRoot:'Servicios',
		id_nodo:'id_servicio',
		id_nodo_p:'id_servicio_fk',
	fields: [
	'id',
	    'tipo_meta',
		{name:'id_servicio', type: 'numeric'},
		{name:'estado_reg', type: 'string'},
		{name:'id_servicio_fk', type: 'numeric'},
		{name:'nombre', type: 'string'},
		{name:'sigla', type: 'string'},
		{name:'descripcion', type: 'string'},
		{name:'peso', type: 'numeric'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usuario_ai', type: 'string'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'id_usuario_ai', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},

	],
	sortInfo:{
		field: 'id_servicio',
		direction: 'ASC'
	},
	bdel:true,
	bsave:true,
	bedit:true,
	rootVisible:true,
	//sobrecarga prepara menu
	preparaMenu:function(n){
			//si es una nodo tipo carpeta habilitamos la opcion de nuevo

			if(n.attributes.tipo_nodo == 'hijo' || n.attributes.tipo_nodo == 'raiz' || n.attributes.id == 'id'){
					this.tbar.items.get('b-new-'+this.idContenedor).enable()
					this.tbar.items.get('b-edit-'+this.idContenedor).enable()
				}
				else {
					this.tbar.items.get('b-new-'+this.idContenedor).disable()
				}
			// llamada funcion clace padre
			Phx.vista.Servicio.superclass.preparaMenu.call(this,n)
		},

	/*EnableSelect:function(n){
	    var nivel = n.getDepth();
		var direc = this.getNombrePadre(n)
		if(direc){
			Phx.CP.getPagina(this.idContenedor+'-east').ubicarPos(direc,nivel)
			Phx.vista.Servicio.superclass.EnableSelect.call(this,n)
		}

	},*/

	getNombrePadre:function(n){
		var direc


		var padre = n.parentNode;


		if(padre){
			if(padre.attributes.id!='id'){
			   direc = n.attributes.nombre +' - '+ this.getNombrePadre(padre)
			   return direc;
			}else{

				return n.attributes.nombre;
			}
		}
		else{
				return undefined;
		}


	 }

	}
)
</script>
