<?php
/**
*@package pXP
*@file gen-Mensaje.php
*@author  (admin)
*@date 17-05-2017 13:33:23
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.Mensaje=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		Phx.vista.Mensaje.superclass.constructor.call(this,config);
		this.init();
		this.load({params:{start:0, limit:this.tam_pag}})
	},
			
	Atributos:[
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
			config:{
				name: 'titulo',
				fieldLabel: 'titulo',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:255
			},
				type:'TextField',
				filters:{pfiltro:'men.titulo',type:'string'},
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
				filters:{pfiltro:'men.estado_reg',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'mensaje',
				fieldLabel: 'Mensaje',
				allowBlank: true,
				anchor: '80%',
				gwidth: 550,
				//maxLength:
			},
				type:'TextField',
				filters:{pfiltro:'men.mensaje',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
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
				filters:{pfiltro:'men.id_usuario_ai',type:'numeric'},
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
				filters:{pfiltro:'men.fecha_reg',type:'date'},
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
				filters:{pfiltro:'men.usuario_ai',type:'string'},
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
				filters:{pfiltro:'men.fecha_mod',type:'date'},
				id_grupo:1,
				grid:true,
				form:false
		},
        {
            config:{
                name:'id_sucursales',
                fieldLabel:'Sucursales',
                allowBlank:true,
                emptyText:'Sucursales...',
                store: new Ext.data.JsonStore({
                    url: '../../sis_colas/control/Sucursal/listarSucursal',
                    id: 'id_sucursal',
                    root: 'datos',
                    sortInfo:{
                        field: 'nombre',
                        direction: 'ASC'
                    },
                    totalProperty: 'total',
                    fields: ['id_sucursal','nombre','codigo'],
                    // turn on remote sorting
                    remoteSort: true,
                    baseParams:{par_filtro:'nombre'}

                }),
                valueField: 'id_sucursal',
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
                enableMultiSelect:true

                //renderer:function(value, p, record){return String.format('{0}', record.data['descripcion']);}

            },
            type:'AwesomeCombo',
            id_grupo:0,
            grid:false,
            form:true
        }
	],
	tam_pag:50,	
	title:'Mensaje',
	ActSave:'../../sis_colas/control/Mensaje/insertarMensaje',
	ActDel:'../../sis_colas/control/Mensaje/eliminarMensaje',
	ActList:'../../sis_colas/control/Mensaje/listarMensaje',
	id_store:'id_mensaje',
	fields: [
		{name:'id_mensaje', type: 'numeric'},
		{name:'titulo', type: 'string'},
		{name:'estado_reg', type: 'string'},
		{name:'mensaje', type: 'string'},
		{name:'id_usuario_ai', type: 'numeric'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usuario_ai', type: 'string'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},
		{name:'id_sucursales', type: 'string'},

	],
	sortInfo:{
		field: 'id_mensaje',
		direction: 'ASC'
	},
	bdel:true,
	bsave:true,

    east:{
        url:'../../../sis_colas/vista/sucursal_mensaje/SucursalMensaje.php',
        title:'SucursalMensaje',
        width:300,
        cls:'SucursalMensaje'
    },
	}
)
</script>
		
		