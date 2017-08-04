<?php
/**
*@package pXP
*@file gen-SucursalMensaje.php
*@author  (admin)
*@date 17-05-2017 13:39:41
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.SucursalMensaje=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		Phx.vista.SucursalMensaje.superclass.constructor.call(this,config);
		this.init();
		//this.load({params:{start:0, limit:this.tam_pag}})
	},
			
	Atributos:[
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_sucursal_mensaje'
			},
			type:'Field',
			form:true 
		},
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_mensaje'
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
                gdisplayField: 'desc_sucursal',
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
                    return String.format('{0}', record.data['desc_sucursal']);
                }
            },
            type: 'ComboBox',
            id_grupo: 0,
            filters: {pfiltro: 'suc.nombre_sucural',type: 'string'},
            grid: true,
            form: true
        },

        {
            config:{
                name: 'desc_mensaje_titulo',
                fieldLabel: 'Mensaje Titulo',
                allowBlank: true,
                anchor: '80%',
                gwidth: 100,
                maxLength:10
            },
            type:'TextField',
            filters:{pfiltro:'sucmen.estado_reg',type:'string'},
            id_grupo:1,
            grid:true,
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
				filters:{pfiltro:'sucmen.estado_reg',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
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
				filters:{pfiltro:'sucmen.id_usuario_ai',type:'numeric'},
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
				name: 'fecha_reg',
				fieldLabel: 'Fecha creación',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
							format: 'd/m/Y', 
							renderer:function (value,p,record){return value?value.dateFormat('d/m/Y H:i:s'):''}
			},
				type:'DateField',
				filters:{pfiltro:'sucmen.fecha_reg',type:'date'},
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
				filters:{pfiltro:'sucmen.usuario_ai',type:'string'},
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
				filters:{pfiltro:'sucmen.fecha_mod',type:'date'},
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
	title:'SucursalMensaje',
	ActSave:'../../sis_colas/control/SucursalMensaje/insertarSucursalMensaje',
	ActDel:'../../sis_colas/control/SucursalMensaje/eliminarSucursalMensaje',
	ActList:'../../sis_colas/control/SucursalMensaje/listarSucursalMensaje',
	id_store:'id_sucursal_mensaje',
	fields: [
		{name:'id_sucursal_mensaje', type: 'numeric'},
		{name:'id_sucursal', type: 'numeric'},
		{name:'id_mensaje', type: 'numeric'},
		{name:'estado_reg', type: 'string'},
		{name:'id_usuario_ai', type: 'numeric'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usuario_ai', type: 'string'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},
		{name:'desc_sucursal', type: 'string'},
		{name:'desc_mensaje_titulo', type: 'string'},

	],
	sortInfo:{
		field: 'id_sucursal_mensaje',
		direction: 'ASC'
	},
	bdel:true,
	bsave:true,
    preparaMenu: function (tb) {
        // llamada funcion clace padre
        Phx.vista.SucursalMensaje.superclass.preparaMenu.call(this, tb)

    },
    onButtonNew: function () {
        Phx.vista.SucursalMensaje.superclass.onButtonNew.call(this);

        this.getComponente('id_mensaje').setValue(this.maestro.id_mensaje);
    },
    onReloadPage: function (m) {
        this.maestro = m;
        console.log(this.maestro);

        this.store.baseParams = {id_mensaje: this.maestro.id_mensaje};


        this.load({params: {start: 0, limit: 50}})
    },
	}
)
</script>
		
		