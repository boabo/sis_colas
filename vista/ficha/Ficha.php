<?php
/**
*@package pXP
*@file gen-Ficha.php
*@author  (José Mita)
*@date 21-06-2016 10:11:23
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.Ficha=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		Phx.vista.Ficha.superclass.constructor.call(this,config);
		//this.init();
		//this.load({params:{start:0, limit:this.tam_pag}})
	},
    loadMask :false,
	Atributos:[
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_ficha'
			},
			type:'Field',
			form:true 
		},
		
		
		
		{
			config:{
				name: 'sigla',
				fieldLabel: 'Ficha',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:5,
				readOnly:true,
				renderer:function (value, p, record){  
                            if(record.data['peso_prioridad'] != 1)
                                return  String.format('<font color="red">{0}</font>',value);
                            else
                                return value;
                        }
			},
				type:'TextField',
				filters:{pfiltro:'ficha.sigla',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'nombre_servi',
				fieldLabel: 'Servicio',
				allowBlank: true,
				anchor: '80%',
				gwidth: 150,
				maxLength:5
			},
				type:'TextField',
				filters:{pfiltro:'servi.nombre_servi',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
		},
		
		{
			config:{
				name: 'nombre_priori',
				fieldLabel: 'Prioridad',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:5
			},
				type:'TextField',
				filters:{pfiltro:'priori.nombre_priori',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
		},
		

		{
			config:{
				name: 'fecha_hora_inicio',
				fieldLabel: 'Hora Llegada.',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100
							
			},
				type:'TextField',
				filters:{pfiltro:'ficest.fecha_hora_inicio',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'minuto_espera',
				fieldLabel: 'Minutos Espera',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:300
			},
				type:'TextField',
				filters:{pfiltro:'minuto_espera',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'desc_persona',
				fieldLabel: 'Funcionario',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:5
			},
				type:'TextField',
				filters:{pfiltro:'usu1.desc_persona',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'ultima_llamada',
				fieldLabel: 'Ultima Llamada',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100
			},
				type:'TextField',
				filters:{pfiltro:'ficha.ultima_llamada',type:'date'},
				id_grupo:1,
				grid:true,
				form:false 
		},
		{
			config:{
				name: 'numero_ventanilla',
				fieldLabel: 'Ventanilla',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:5
			},
				type:'TextField',
				filters:{pfiltro:'ficest.numero_ventanilla',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'fecha_hora_fin',
				fieldLabel: 'Hora Finalizado',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100
			},
				type:'TextField',
				filters:{pfiltro:'ficest1.fecha_hora_fin',type:'date'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'derivado',
				fieldLabel: 'Derivado a',
				allowBlank: true,
				anchor: '80%',
				gwidth: 200,
				maxLength:5
			},
				type:'TextField',
				filters:{pfiltro:'usu3.desc_persona',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
		}
	],
	tam_pag:50,	
	title:'Fichas',
	ActSave:'../../sis_colas/control/Ficha/insertarFicha',
	ActDel:'../../sis_colas/control/Ficha/eliminarFicha',
	ActList:'../../sis_colas/control/Ficha/listarFicha',
	id_store:'id_ficha',
	fields: [
		{name:'id_ficha', type: 'numeric'},
		{name:'numero', type: 'numeric'},
		{name:'estado_reg', type: 'string'},
		{name:'id_sucursal', type: 'numeric'},
		{name:'sigla', type: 'string'},
		{name:'id_servicio', type: 'numeric'},
		{name:'id_prioridad', type: 'numeric'},
		{name:'peso', type: 'numeric'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'usuario_ai', type: 'string'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_ai', type: 'numeric'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},
		{name:'nombre_servi', type: 'string'},
		{name:'nombre_sucur', type: 'string'},
		{name:'nombre_priori', type: 'string'},
		{name:'estado_ficha', type: 'string'},
		{name:'fecha_hora_inicio', type: 'string'},
		{name:'cola_atencion', type: 'numeric'},
		{name:'desc_persona', type: 'string'},
		{name:'ultima_llamada', type: 'string'},
		{name:'numero_ventanilla', type: 'string'},
		{name:'minuto_espera', type: 'numeric'},
		{name:'fecha_hora_fin', type: 'string'},
		{name:'derivado', type: 'string'},
        {name:'peso_prioridad', type: 'numeric'}
	],
	sortInfo:{
		field: 'cola_atencion',
		direction: 'DESC'
	},
	bdel:true,
	bsave:true
	}
)
</script>
		
		