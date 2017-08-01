<?php
/**
*@package pXP
*@file gen-Prioridad.php
*@author  (admin)
*@date 15-06-2016 22:48:33
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.Prioridad=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		Phx.vista.Prioridad.superclass.constructor.call(this,config);
		this.init();
		this.load({params:{start:0, limit:this.tam_pag}})
	},
			
	Atributos:[
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_prioridad'
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
				filters:{pfiltro:'priori.sigla',type:'string'},
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
				filters:{pfiltro:'priori.nombre',type:'string'},
				id_grupo:1,
				grid:true,
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
				filters:{pfiltro:'priori.estado_reg',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'descripcion',
				fieldLabel: 'Descripción',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:150
			},
				type:'TextField',
				filters:{pfiltro:'priori.descripcion',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		
		{
			config: {
				name: 'estado',
				fieldLabel: 'Estado',
				allowBlank: false,
				emptyText: 'estado...',
				typeAhead: true,
				triggerAction: 'all',
				lazyRender: true,
				mode: 'local',
				store: ['Habilitado', 'Inhabilitado'],
				width: 200
				},
				type: 'ComboBox',
				filters: {pfiltro: 'priori.estado', type: 'string'},
				id_grupo: 1,
				form: true,
				grid: true
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
				filters: {pfiltro: 'priori.peso', type: 'numeric'},
				id_grupo: 1,
				form: true,
				grid: true
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
				name: 'usuario_ai',
				fieldLabel: 'Funcionaro AI',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:300
			},
				type:'TextField',
				filters:{pfiltro:'priori.usuario_ai',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
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
				filters:{pfiltro:'priori.fecha_reg',type:'date'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'id_usuario_ai',
				fieldLabel: 'Fecha creación',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:4
			},
				type:'Field',
				filters:{pfiltro:'priori.id_usuario_ai',type:'numeric'},
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
				filters:{pfiltro:'priori.fecha_mod',type:'date'},
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
	title:'Prioridad',
	ActSave:'../../sis_colas/control/Prioridad/insertarPrioridad',
	ActDel:'../../sis_colas/control/Prioridad/eliminarPrioridad',
	ActList:'../../sis_colas/control/Prioridad/listarPrioridad',
	id_store:'id_prioridad',
	fields: [
		{name:'id_prioridad', type: 'numeric'},
		{name:'nombre', type: 'string'},
		{name:'sigla', type: 'string'},
		{name:'estado_reg', type: 'string'},
		{name:'descripcion', type: 'string'},
		{name:'estado', type: 'string'},
		{name:'peso', type: 'numeric'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'usuario_ai', type: 'string'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_ai', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},
		
	],
	sortInfo:{
		field: 'id_prioridad',
		direction: 'ASC'
	},
	bdel:true,
	bsave:true
	}
)
</script>
		
		