<?php
/**
*@package pXP
*@file SucursalServicio.php
*@author  (José Mita)
*@date 15-06-2016 23:17:07
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.SucursalServicio=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		Phx.vista.SucursalServicio.superclass.constructor.call(this,config);
		this.init();
		this.load({params:{start:0, limit:this.tam_pag}});
		this.addButton('btnResetFicha', { grupo:[0], text:'Resetear Fichas', iconCls: 'bchecklist', disabled:true,handler:this.resetFicha,tooltip: '<b>Reset Ficha</b><p>Resetea la numeración de las fichas</p>'});
		//this.addButton('btnRepRelCon',{grupo:[2],text: 'Duplicar Presupuestos',iconCls: 'bchecklist',disabled: false,handler: this.duplicarPresupuestos,tooltip: '<b>Duplicar presupuestos </b><br/>Duplicar presupuestos para la siguiente gestión'});
       
	},
			
	Atributos:[
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_sucursal_servicio'
			},
			type:'Field',
			form:true 
		},
		{
			config: {
				name: 'id_sucursal',
				fieldLabel: 'Sucursal',
				allowBlank: true,
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
				gdisplayField: 'nombre_sucur',
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
					return String.format('{0}', record.data['nombre_sucur']);
				}
			},
			type: 'ComboBox',
			id_grupo: 0,
			filters: {pfiltro: 'sucur.nombre_sucur',type: 'string'},
			grid: true,
			form: true
		},
		{
			config: {
				name: 'id_servicio',
				fieldLabel: 'Servicio',
				allowBlank: true,
				emptyText: 'Elija una opción...',
				store: new Ext.data.JsonStore({
					url: '../../sis_colas/control/Servicio/listarServicioUltimoNivel',
					id: 'id_servicio',
					root: 'datos',
					sortInfo: {
						field: 'nombre',
						direction: 'ASC'
					},
					totalProperty: 'total',
					fields: ['id_servicio', 'nombre', 'sigla'],
					remoteSort: true,
					baseParams: {par_filtro: 'servi.nombre#servi.sigla'}
				}),
				valueField: 'id_servicio',
				displayField: 'nombre',
				gdisplayField: 'nombre_servi',
				hiddenName: 'id_servicio',
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
					return String.format('{0}', record.data['nombre_servi']);
				}
			},
			type: 'ComboBox',
			id_grupo: 0,
			filters: {pfiltro: 'servi.nombre_servi',type: 'string'},
			grid: true,
			form: true
		},
		{
			config: {
				name: 'id_tipo_ventanilla',
				fieldLabel: 'Tipo Ventanilla',
				allowBlank: true,
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
				gdisplayField: 'nombre_tipo',
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
					return String.format('{0}', record.data['nombre_tipo']);
				}
			},
			type: 'ComboBox',
			id_grupo: 0,
			filters: {pfiltro: 'tipven.nombre_tipo',type: 'string'},
			grid: true,
			form: true
		},
		
		{
       			config:{
       				name:'ids_prioridad',
       				fieldLabel:'Prioridades',
       				allowBlank:true,
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
       				width:250,
       				minChars:2,
	       			enableMultiSelect:true,
       			
       				renderer:function(value, p, record){return String.format('{0}', record.data['nombres_prioridad']);}

       			},
       			type:'AwesomeCombo',
       			id_grupo:0,
       			grid:false,
       			form:false
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
				filters:{pfiltro:'sersuc.estado_reg',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
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
				filters: {pfiltro: 'sersuc.estado', type: 'string'},
				id_grupo: 1,
				form: true,
				grid: true
		},
		
		{
			config:{
				name: 'id_usuario_ai',
				fieldLabel: '',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:4
			},
				type:'Field',
				filters:{pfiltro:'sersuc.id_usuario_ai',type:'numeric'},
				id_grupo:1,
				grid:false,
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
				name: 'usuario_ai',
				fieldLabel: 'Funcionaro AI',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:300
			},
				type:'TextField',
				filters:{pfiltro:'sersuc.usuario_ai',type:'string'},
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
				filters:{pfiltro:'sersuc.fecha_reg',type:'date'},
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
				filters:{pfiltro:'sersuc.fecha_mod',type:'date'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'digito',
				fieldLabel: 'Digitos Ficha',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:1,
				minValue:1
			},
				type:'NumberField',
				filters:{pfiltro:'sersuc.digito',type:'numeric'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'tickets',
				fieldLabel: 'Tickets',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:1,
				minValue:1
			},
				type:'NumberField',
				filters:{pfiltro:'sersuc.tickets',type:'numeric'},
				id_grupo:1,
				grid:true,
				form:false
		}
	],
	tam_pag:50,	
	title:'Servicios Sucursal',
	ActSave:'../../sis_colas/control/SucursalServicio/insertarSucursalServicio',
	ActDel:'../../sis_colas/control/SucursalServicio/eliminarSucursalServicio',
	ActList:'../../sis_colas/control/SucursalServicio/listarSucursalServicio',
	id_store:'id_sucursal_servicio',
	fields: [
		{name:'id_sucursal_servicio', type: 'numeric'},
		{name:'id_sucursal', type: 'numeric'},
		{name:'id_servicio', type: 'numeric'},
		{name:'id_tipo_ventanilla', type: 'numeric'},
		{name:'estado_reg', type: 'string'},
		{name:'ids_prioridad', type: 'string'},
		{name:'nombres_prioridad', type: 'string'},
		{name:'estado', type: 'string'},
		{name:'id_usuario_ai', type: 'numeric'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'usuario_ai', type: 'string'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},
		{name:'nombre_sucur', type: 'string'},
		{name:'nombre_servi', type: 'string'},
		{name:'nombre_tipo', type: 'string'},
		{name:'digito', type: 'numeric'},
		{name:'tickets', type: 'numeric'},
		
	],
	sortInfo:{
		field: 'id_sucursal_servicio',
		direction: 'ASC'
	},
	bdel:true,
	bsave:true,
	
	resetFicha: function(n){
		var data = this.getSelectedData();
        var tb =this.tbar;
        Phx.vista.SucursalServicio.superclass.preparaMenu.call(this,n);
        
		//alert (data['id_sucursal_servicio']); exit;
		if(data['id_sucursal_servicio'] != ''){
			Phx.CP.loadingShow(); 
	   		Ext.Ajax.request({
				url: '../../sis_colas/control/SucursalServicio/resetFichaSucursalServicio',
			  	params:{
			  		id_sucursal_servicio: data['id_sucursal_servicio']
			      },
			      success:this.successRep,
			      failure: this.conexionFailure,
			      timeout:this.timeout,
			      scope:this
			});
		}
		else{
			alert('primero debe selecionar un registro');
		}
   		
     },
    successRep:function(resp){
        Phx.CP.loadingHide();
        var reg = Ext.util.JSON.decode(Ext.util.Format.trim(resp.responseText));
        if(!reg.ROOT.error){
            this.reload();
            if(reg.ROOT.datos.observaciones){
               alert(reg.ROOT.datos.observaciones)
            }
           
        }else{
            alert('Ocurrió un error durante el proceso')
        }
	},
	
	preparaMenu:function(n){
          var data = this.getSelectedData();
          var tb =this.tbar;
          
          Phx.vista.SucursalServicio.superclass.preparaMenu.call(this,n);
          if(data['estado'] == 'Habilitado' ){
          	 this.getBoton('btnResetFicha').enable();
          }
          else{
          	 this.getBoton('btnResetFicha').disable();
          }

    },
	
	 liberaMenu:function(){
        var tb = Phx.vista.SucursalServicio.superclass.liberaMenu.call(this);
        if(tb){
            
            this.getBoton('btnResetFicha').disable();
        }
    }, 
	}
)
</script>
		
		
