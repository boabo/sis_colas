<?php
/**
*@package pXP
*@file gen-Video.php
*@author  (favio.figueroa)
*@date 08-08-2017 21:46:18
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.Video=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		Phx.vista.Video.superclass.constructor.call(this,config);
		this.init();
		this.load({params:{start:0, limit:this.tam_pag}})

        this.addButton('archivo', {
            argument: {imprimir: 'archivo'},
            text: '<i class="fa fa-file-video-o  fa-2x"></i> Video', /*iconCls:'' ,*/
            disabled: false,
            handler: this.archivo
        });

	},
			
	Atributos:[
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_video'
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
				filters:{pfiltro:'vide.estado_reg',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'descripcion',
				fieldLabel: 'descripcion',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:255
			},
				type:'TextField',
				filters:{pfiltro:'vide.descripcion',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
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
				filters:{pfiltro:'vide.usuario_ai',type:'string'},
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
				filters:{pfiltro:'vide.fecha_reg',type:'date'},
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
				filters:{pfiltro:'vide.id_usuario_ai',type:'numeric'},
				id_grupo:1,
				grid:false,
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
				filters:{pfiltro:'vide.fecha_mod',type:'date'},
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
	title:'Video',
	ActSave:'../../sis_colas/control/Video/insertarVideo',
	ActDel:'../../sis_colas/control/Video/eliminarVideo',
	ActList:'../../sis_colas/control/Video/listarVideo',
	id_store:'id_video',
	fields: [
		{name:'id_video', type: 'numeric'},
		{name:'estado_reg', type: 'string'},
		{name:'descripcion', type: 'string'},
		{name:'usuario_ai', type: 'string'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'id_usuario_ai', type: 'numeric'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},
		{name:'id_sucursales', type: 'string'},

	],
	sortInfo:{
		field: 'id_video',
		direction: 'ASC'
	},
	bdel:true,
	bsave:true,
    east:{
        url:'../../../sis_colas/vista/sucursal_video/SucursalVideo.php',
        title:'SucursalVideo',
        width:300,
        cls:'SucursalVideo'
    },

    archivo : function (){



        var rec = this.getSelectedData();

        //enviamos el id seleccionado para cual el archivo se deba subir
        rec.datos_extras_id = rec.id_video;
        //enviamos el nombre de la tabla
        rec.datos_extras_tabla = 'cola.tvideo';
        //enviamos el codigo ya que una tabla puede tener varios archivos diferentes como ci,pasaporte,contrato,slider,fotos,etc
        rec.datos_extras_codigo = 'videos';

        //esto es cuando queremos darle una ruta personalizada
        rec.datos_extras_ruta_personalizada = './../../../uploaded_files/sis_colas/';

        Phx.CP.loadWindows('../../../sis_parametros/vista/archivo/Archivo.php',
            'Archivo',
            {
                width: 900,
                height: 400
            }, rec, this.idContenedor, 'Archivo');

    },

	}
)
</script>
		
		