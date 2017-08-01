<?php
/**
 * @package pxP
 * @file 	GridTicketsAtendidos.php
 * @author 	RCM
 * @date	10/07/2013
 * @description	Reporte Sistema de Colas
 */
header("content-type:text/javascript; charset=UTF-8");
?>
<script>
	Phx.vista.GridTicketsAtendidos = Ext.extend(Phx.gridInterfaz, {
		constructor : function(config) {
			this.maestro = config;
			this.sucursal = this.desc_sucursal;
		
			Phx.vista.GridTicketsAtendidos.superclass.constructor.call(this, config);
			this.init();
			this.store.baseParams.id_usuario = this.maestro.id_usuario;
			this.load({
				params : {
					start: 0,
					limit: this.tam_pag,
					fecha_ini:this.maestro.fecha_ini,
					fecha_fin:this.maestro.fecha_fin,
					id_sucursal:this.maestro.id_sucursal,
                    servidor_remoto : this.maestro.servidor_remoto
				}
			});
		},
		tam_pag:1000,
		Atributos : [
            {
                config: {
                    labelSeparator: '',
                    inputType: 'hidden',
                    name: 'id_ficha'
                },
                type: 'Field',
                form: true
            },
            {
                config: {
                    name: 'ficha',
                    fieldLabel: 'Ficha',
                    gwidth: 90
                },
                type: 'Field',
                filters: {
                    pfiltro: 'f.sigla',
                    type:'string'
                },
                grid: true

            },

            {
                config: {
                    name: 'sucursal',
                    fieldLabel: 'Sucursal',
                    gwidth: 110
                },
                type: 'Field',
                filters: {
                    pfiltro: 's.nombre',
                    type:'string'
                },
                grid: true

            },
            {
                config: {
                    name: 'operador',
                    fieldLabel: 'Operador',
                    gwidth: 110
                },
                type: 'Field',
                filters: {
                    pfiltro: 'usu.desc_persona',
                    type:'string'
                },
                grid: true

            },
            {
                config: {
                    name: 'servicio',
                    fieldLabel: 'Servicio',
                    gwidth: 110
                },
                type: 'Field',
                filters: {
                    pfiltro: 'ser.nombre',
                    type:'string'
                },
                grid: true

            },
            {
                config: {
                    name: 'tipo_ventanilla',
                    fieldLabel: 'Tipo Ventanilla',
                    gwidth: 110
                },
                type: 'Field',
                filters: {
                    pfiltro: 'tv.nombre',
                    type:'string'
                },
                grid: true

            },
            {
                config: {
                    name: 'numero_ventanilla',
                    fieldLabel: 'Numero Ventanilla',
                    gwidth: 110
                },
                type: 'Field',
                filters: {
                    pfiltro: 'llamado.numero_ventanilla',
                    type:'string'
                },
                grid: true

            },
            {
                config: {
                    name: 'fecha_generacion',
                    fieldLabel: 'Fecha Generacion',
                    gwidth: 110
                },
                type: 'Field',
                grid: true

            },
            {
                config: {
                    name: 'hora_generacion',
                    fieldLabel: 'Hora Generacion',
                    gwidth: 110
                },
                type: 'Field',
                grid: true

            },
            {
                config: {
                    name: 'hora_llamado',
                    fieldLabel: 'Hora Llamado',
                    gwidth: 110
                },
                type: 'Field',
                grid: true

            },
            {
                config: {
                    name: 'hora_inicio_atencion',
                    fieldLabel: 'Hora Inicio Atencion',
                    gwidth: 110
                },
                type: 'Field',
                grid: true

            },
            {
                config: {
                    name: 'hora_fin_atencion',
                    fieldLabel: 'Hora Fin Atencion',
                    gwidth: 110
                },
                type: 'Field',
                grid: true

            },
            {
                config: {
                    name: 'tiempo_espera',
                    fieldLabel: 'Tiempo Espera',
                    gwidth: 110
                },
                type: 'Field',
                grid: true

            },
            {
                config: {
                    name: 'tiempo_atencion',
                    fieldLabel: 'Tiempo Atencion',
                    gwidth: 110
                },
                type: 'Field',
                grid: true

            },
            {
                config: {
                    name: 'estado',
                    fieldLabel: 'Observacion',
                    gwidth: 110
                },
                type: 'Field',
                grid: true

            },


		
		],
		title : 'Tickets Atendidos',
		ActList : '../../sis_colas/control/Reporte/listarTicketAtendido',
		id_store : 'id_ficha',
		fields : [{
			name : 'id_ficha'
		}, {
			name : 'ficha',
			type : 'string'
		} ,{
			name : 'estado',
			type : 'string'
		},{
            name : 'sucursal',
            type : 'string'
        },{
            name : 'operador',
            type : 'string'
        },{
            name : 'servicio',
            type : 'string'
        },{
            name : 'tipo_ventanilla',
            type : 'string'
        },{
            name : 'numero_ventanilla',
            type : 'string'
        },{
            name : 'fecha_generacion',
            type : 'string'
        },{
            name : 'hora_generacion',
            type : 'string'
        },{
            name : 'hora_llamado',
            type : 'string'
        }, {
			name : 'hora_inicio_atencion',
			type : 'string'
		},
        {
            name : 'hora_fin_atencion',
            type : 'string'
        },
        {
            name : 'tiempo_espera',
            type : 'string'
        },
        {
            name : 'tiempo_atencion',
            type : 'string'
        }],
		sortInfo : {
			field : 'id_ficha',
			direction : 'ASC'
		},
		bdel : false,
		bnew: false,
		bedit: false,
		fwidth : '90%',
		fheight : '80%'
	}); 
</script>
