<?php
/**
*@package pXP
*@file gen-UsuarioSucursal.php
*@author  (admin)
*@date 22-07-2016 01:55:47
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.UsuarioSucursal=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		Phx.vista.UsuarioSucursal.superclass.constructor.call(this,config);
		this.init();
		this.iniciarEventos();
		this.Cmp.ids_servicio.disable(); 
		this.load({params:{start:0, limit:this.tam_pag}})
	},
			
	Atributos:[
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_usuario_sucursal'
			},
			type:'Field',
			form:true 
		},
		{
			config: {
				name: 'id_sucursal',
				fieldLabel: 'Sucursal',
				allowBlank: false,
				emptyText: 'Elija una opción...',
				store: new Ext.data.JsonStore({
					url: '../../sis_colas/control/Sucursal/listarSucursal',
					id: 'id_sucursal',
					root: 'datos',
					sortInfo: {
						field: 'nombre',
						direction: 'ASC'
					},
					totalProperty: 'total',
					fields: ['id_sucursal', 'nombre', 'codigo'],
					remoteSort: true,
					baseParams: {par_filtro: 'sucur.nombre#sucur.codigo'}
				}),
				valueField: 'id_sucursal',
				displayField: 'nombre',
				gdisplayField: 'nombre_sucursal',
				hiddenName: 'id_sucursal',
				forceSelection: true,
				typeAhead: false,
				triggerAction: 'all',
				lazyRender: true,
				mode: 'remote',
				pageSize: 15,
				queryDelay: 1000,
				anchor: '100%',
				gwidth: 150,
				minChars: 2,
				renderer : function(value, p, record) {
					return String.format('{0}', record.data['nombre_sucursal']);
				}
			},
			type: 'ComboBox',
			id_grupo: 0,
			filters: {pfiltro: 'suc.nombre_sucural',type: 'string'},
			grid: true,
			form: true
		},
		{
			config: {
				name: 'id_usuario',
				fieldLabel: 'Usuario',
				allowBlank: false,
				emptyText: 'Elija una opción...',
				store: new Ext.data.JsonStore({
					url: '../../sis_seguridad/control/Usuario/listarUsuario',
					id: 'id_usuario',
					root: 'datos',
					sortInfo: {
						field: 'desc_person',
						direction: 'ASC'
					},
					totalProperty: 'total',
					fields: ['id_usuario', 'desc_person', 'descripcion'],
					remoteSort: true,
					baseParams: {par_filtro: 'PERSON.nombre_completo2'}
				}),
				valueField: 'id_usuario',
				displayField: 'desc_person',
				gdisplayField: 'desc_persona',
				hiddenName: 'id_usuario',
				forceSelection: true,
				typeAhead: false,
				triggerAction: 'all',
				lazyRender: true,
				mode: 'remote',
				pageSize: 15,
				queryDelay: 1000,
				anchor: '100%',
				gwidth: 200,
				minChars: 2,
				renderer : function(value, p, record) {
					return String.format('{0}', record.data['desc_persona']);
				}
			},
			type: 'ComboBox',
			id_grupo: 0,
			filters: {pfiltro: 'vusu.desc_persona',type: 'string'},
			grid: true,
			form: true
		},
		{
			config: {
				name: 'id_tipo_ventanilla',
				fieldLabel: 'Tipo Ventanilla',
				allowBlank: false,
				emptyText: 'Elija una opción...',
				store: new Ext.data.JsonStore({
					url: '../../sis_colas/control/TipoVentanilla/listarTipoVentanilla',
					id: 'id_tipo_ventanilla',
					root: 'datos',
					sortInfo: {
						field: 'nombre',
						direction: 'ASC'
					},
					totalProperty: 'total',
					fields: ['id_tipo_ventanilla', 'nombre'],
					remoteSort: true,
					baseParams: {par_filtro: 'tipven.nombre'}
				}),
				valueField: 'id_tipo_ventanilla',
				displayField: 'nombre',
				gdisplayField: 'nombre_ventanilla',
				hiddenName: 'id_tipo_ventanilla',
				forceSelection: true,
				typeAhead: false,
				triggerAction: 'all',
				lazyRender: true,
				mode: 'remote',
				pageSize: 15,
				queryDelay: 1000,
				anchor: '100%',
				gwidth: 150,
				minChars: 2,
				renderer : function(value, p, record) {
					return String.format('{0}', record.data['nombre_ventanilla']);
				}
			},
			type: 'ComboBox',
			id_grupo: 0,
			filters: {pfiltro: 'tipven.nombre_ventanilla',type: 'string'},
			grid: true,
			form: true
		},
		{
			config:{
				name: 'numero_ventanilla',
				fieldLabel: 'Número Ventanilla',
				allowBlank: false,
				anchor: '80%',
				gwidth: 100,
				maxLength:5
			},
				type:'TextField',
				filters:{pfiltro:'ususuc.numero_ventanilla',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		
		{
       			config:{
       				name:'ids_servicio',
       				fieldLabel:'Servicios',
       				allowBlank:false,
       				emptyText:'Servicios...',
       				store: new Ext.data.JsonStore({
              			url: '../../sis_colas/control/SucursalServicio/listarSucursalServicio',
       					id: 'id_servicio',
       					root: 'datos',
       					sortInfo:{
       						field: 'nombre_servi',
       						direction: 'ASC'
       					},
       					totalProperty: 'total',
       					fields: ['id_servicio','nombre_servi'],
       					// turn on remote sorting
       					remoteSort: true,
       					baseParams:{par_filtro:'nombre_servi'}
       					
       				}),
       				valueField: 'id_servicio',
       				displayField: 'nombre_servi',
       				forceSelection:true,
       				typeAhead: true,
           			triggerAction: 'all',
           			lazyRender:true,
       				mode:'remote',
       				pageSize:10,
       				queryDelay:1000,
       				width:400,
       				gwidth: 400,
       				minChars:2,
	       			enableMultiSelect:true,
	       		
       			
       				renderer:function(value, p, record){return String.format('{0}', record.data['nombres_servicio']);}

       			},
       			type:'AwesomeCombo',
       			id_grupo:0,
       			grid:true,
       			form:true
       	},
				
		{
       			config:{
       				name:'ids_prioridad',
       				fieldLabel:'Prioridades',
       				allowBlank:false,
       				emptyText:'Prioridades...',
       				store: new Ext.data.JsonStore({
              			url: '../../sis_colas/control/Prioridad/listarPrioridad',
       					id: 'id_prioridad',
       					root: 'datos',
       					sortInfo:{
       						field: 'nombre',
       						direction: 'ASC'
       					},
       					totalProperty: 'total',
       					fields: ['id_prioridad','nombre'],
       					// turn on remote sorting
       					remoteSort: true,
       					baseParams:{par_filtro:'nombre'}
       					
       				}),
       				valueField: 'id_prioridad',
       				displayField: 'nombre',
       				forceSelection:true,
       				typeAhead: true,
           			triggerAction: 'all',
           			lazyRender:true,
       				mode:'remote',
       				pageSize:10,
       				queryDelay:1000,
       				width:350,
       				gwidth: 400,
       				minChars:2,
	       			enableMultiSelect:true,
       			
       				renderer:function(value, p, record){return String.format('{0}', record.data['nombres_prioridad']);}

       			},
       			type:'AwesomeCombo',
       			id_grupo:0,
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
				filters:{pfiltro:'ususuc.estado_reg',type:'string'},
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
				name: 'fecha_reg',
				fieldLabel: 'Fecha creación',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
							format: 'd/m/Y', 
							renderer:function (value,p,record){return value?value.dateFormat('d/m/Y H:i:s'):''}
			},
				type:'DateField',
				filters:{pfiltro:'ususuc.fecha_reg',type:'date'},
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
				filters:{pfiltro:'ususuc.fecha_mod',type:'date'},
				id_grupo:1,
				grid:true,
				form:false
		}
	],
	tam_pag:50,	
	title:'Usuario Sucursal',
	ActSave:'../../sis_colas/control/UsuarioSucursal/insertarUsuarioSucursal',
	ActDel:'../../sis_colas/control/UsuarioSucursal/eliminarUsuarioSucursal',
	ActList:'../../sis_colas/control/UsuarioSucursal/listarUsuarioSucursal',
	id_store:'id_usuario_sucursal',
	fields: [
		{name:'id_usuario_sucursal', type: 'numeric'},
		{name:'id_sucursal', type: 'numeric'},
		{name:'estado_reg', type: 'string'},
		{name:'id_tipo_ventanilla', type: 'numeric'},
		{name:'id_usuario', type: 'numeric'},
		{name:'id_usuario_ai', type: 'numeric'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usuario_ai', type: 'string'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},
		{name:'nombre_sucursal', type: 'string'},
		{name:'desc_persona', type: 'string'},
		{name:'nombre_ventanilla', type: 'string'},
		{name:'numero_ventanilla', type: 'string'},
		{name:'ids_prioridad', type: 'string'},
		{name:'nombres_prioridad', type: 'string'},
		{name:'ids_servicio', type: 'string'},
		{name:'nombres_servicio', type: 'string'},
	],
	sortInfo:{
		field: 'id_usuario_sucursal',
		direction: 'ASC'
	},
	bdel:true,
	bsave:true,
	
	iniciarEventos : function() {
		console.log('entra a eventos');
			this.Cmp.id_sucursal.on('select', function (c, r, i) {
				console.log(r.data.id_sucursal);
			this.Cmp.ids_servicio.store.setBaseParam('id_sucursal',r.data.id_sucursal);
						
			this.Cmp.ids_servicio.enable(); 
			 
			this.Cmp.ids_servicio.modificado = true;
						
			this.Cmp.ids_servicio.reset();
			
		}, this);	
		
		/*this.Cmp.id_cuenta.on('select', function (c, r, i) {
          
            this.Cmp.id_auxiliar.store.setBaseParam('id_cuenta',r.data.id_cuenta);
            this.Cmp.id_auxiliar.modificado = true;
            this.Cmp.id_auxiliar.reset();
            
            //this.Cmp.id_partida.store.setBaseParam('id_cuenta',r.data.id_cuenta);
            //this.Cmp.id_partida.modificado = true;
            //this.Cmp.id_partida.reset();
            
            
        }, this);*/
     },
	
	}
)
</script>
		
		