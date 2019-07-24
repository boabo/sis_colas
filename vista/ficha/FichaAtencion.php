<?php
/**
*@package pXP
*@file FichaInicio.php
*@author  (José Mita)
*@date 21-06-2016 10:11:23
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.FichaAtencion = {
    bedit:false,
    bnew:false,
    bsave:false,
    bdel:false,
	require:'../../../sis_colas/vista/ficha/Ficha.php',
	requireclase:'Phx.vista.Ficha',
	title:'Fichas',
	nombreVista: 'FichaAtencion',

	swEstado : 'espera',
    that:'',



     east:{
        url:'../../../sis_colas/vista/fichatotal/FichaTotal.php',
        title:'<center style="font-size:12px;">Total Fichas Por Usuario</center>',
        width:300,
        cls:'FichaTotal'
   },




	constructor: function(config) {
        that = this;
	    this.initButtons=[this.cmbSucursal];//, this.cmbTipoPres];
	    Phx.vista.FichaAtencion.superclass.constructor.call(this,config);
        //this.bloquearOrdenamientoGrid();
        this.store.baseParams.estado = 'espera';
        this.store.baseParams.filtroUsuario = 'si';
	    this.cmbSucursal.on('select', function(c,r,i){
	    	this.store.baseParams.servidor_remoto = r.data.servidor_remoto;
		    if(this.validarFiltros()){
                  this.capturaFiltros();
           }
		},this);

		this.bloquearOrdenamientoGrid();
		this.cmbSucursal.on('clearcmb', function() {this.DisableSelect();this.store.removeAll();}, this);

		//Crea el botón para llamar a la replicación
		//this.addButton('btnRepRelCon',{grupo:[2],text: 'Duplicar Presupuestos',iconCls: 'bchecklist',disabled: false,handler: this.duplicarPresupuestos,tooltip: '<b>Duplicar presupuestos </b><br/>Duplicar presupuestos para la siguiente gestión'});
		this.addButton('btnLlamar',{text: 'Llamar siguiente',iconCls: 'bchecklist',disabled: true,handler: this.llamarSiguiente,tooltip: '<b>Llamar Siguiente</b><br/>Llama a la siguiente persona de la cola'});
        this.cm.setHidden(2, true);
        this.cm.setHidden(3, true);
        this.cm.setHidden(6, true);
		this.cm.setHidden(7, true);
		this.cm.setHidden(8, true);
		this.cm.setHidden(9, true);
		this.init();
		this.iniciarEventos();


    this.timer_id=Ext.TaskMgr.start({
       run: Ftimer,
       interval:3000,
       scope:this
   });

   function Ftimer(){
           if (this.cmbSucursal.getValue()) {
               this.reload();
           }

     }


        this.addButton('configurar', {
            argument: {imprimir: 'configurar'},
            text: '<i class="fa fa-cog  fa-2x"></i> CONFIG', /*iconCls:'' ,*/
            disabled: false,
            handler: this.onButtonNew
        });


   },
    ejecucionNuevoTicketEscuchando : function(mensaje){

        console.log('llega aca la ejecucion de la funcion para actualizar la grilla',mensaje)
        console.log(this)

        if (this.cmbSucursal.getValue()) {
            this.reload();
        }

    },
   iniciarEventos : function () {
   		this.cmbSucursal.store.load({params:{start:0,limit:this.tam_pag},
           callback : function (r) {
   		    console.log('r',r)
           		if (r.length == 1 ) {
           			this.cmbSucursal.setValue(r[0].data.id_sucursal);
           			this.cmbSucursal.fireEvent('select',this.cmbSucursal, this.cmbSucursal.store.getById(r[0].data.id_sucursal));


                    Phx.CP.webSocket.escucharEvento( 'sis_colas/nuevosTickets/'+this.cmbSucursal.getValue()+'',this.idContenedor,'ejecucionNuevoTicketEscuchando',this);


                }

            }, scope : this
        });
   },

   llamarSiguiente : function () {
   		//AJAX tiene q revisar revisar si hay una ficha para llamar, si hay una ficha anterior en atencion por el mismo usuario o si no hay fichas para atender
   		//si no hay fichas para atender lanzar alerta
   		//si ya hay una ficha en atencion para el usuario devovler esa ficha
   		//Si hay una nueva ficha para atender, cambiar el estado de la ficha, asignarla al usuario y devolver al ficha
   		Phx.CP.loadingShow();

   		Ext.Ajax.request({
				url: '../../sis_colas/control/Ficha/llamarSiguienteFicha',
			  	params:{
			  		id_sucursal: this.cmbSucursal.getValue()
			      },
			      success:this.successRep,
			      failure: this.conexionFailure,
			      timeout:this.timeout,
			      scope:this
			});
   		//Cargar el formulario con los datos de la ficha devuelta en el ajax





   },
   successRep:function(resp){
        Phx.CP.loadingHide();
        var reg = Ext.util.JSON.decode(Ext.util.Format.trim(resp.responseText));
        var datos = {datos:reg.datos[0]};
        //this.onButtonAct();
        Phx.CP.loadWindows('../../../sis_colas/vista/ficha/FormularioAtencion.php',
                    'Atencion',
                    {
                        width:800,
                        height:'90%'
                    },
                    datos,
                    this.idContenedor,
                    'FormularioAtencion');


	},



   cmbSucursal: new Ext.form.ComboBox({
				fieldLabel: 'Sucursal',
				grupo:[0,1,2],
				allowBlank: false,
				emptyText:'Sucursal...',
				store:new Ext.data.JsonStore(
				{
					url: '../../sis_colas/control/UsuarioSucursal/listarUsuarioSucursal',
					id: 'id_sucursal',
					root: 'datos',
					sortInfo:{
						field: 'suc.nombre',
						direction: 'ASC'
					},
					totalProperty: 'total',
					fields: ['id_sucursal','nombre_sucursal','servidor_remoto'],
					// turn on remote sorting
					remoteSort: true,
					baseParams:{par_filtro:'suc.nombre',filtro_usuario:'igual'}
				}),
				valueField: 'id_sucursal',
				triggerAction: 'all',
				displayField: 'nombre_sucursal',
			    hiddenName: 'id_sucursal',
    			mode:'remote',
				pageSize:200,
				queryDelay:500,
				listWidth:'280',
				width:150
			}),


	validarFiltros:function(){
        if(this.cmbSucursal.isValid()){// && this.cmbTipoPres.validate()){
            return true;
        }
        else{
            return false;
        }

    },

   /*east:{
        url:'../../../sis_colas/vista/ficha/FichaTotal.php',
        title:'Total Fichas',
        width:300,
        cls:'FichaTotal'
    },*/


    getParametrosFiltro: function(){
    	this.store.baseParams.id_sucursal=this.cmbSucursal.getValue();
        //this.store.baseParams.codigos_tipo_pres = this.cmbTipoPres.getValue();
        this.store.baseParams.estado_ficha = 'espera';
        this.store.baseParams.tipo_interfaz = this.nombreVista;
    },

	capturaFiltros:function(combo, record, index){
   //console.log("PROBANDO",this.store.baseParams);

   Phx.CP.getPagina('docs-FICATE-east').mostrar(this.cmbSucursal.getValue());

		this.desbloquearOrdenamientoGrid();
        this.getParametrosFiltro();
        this.load({params:{start:0, limit:50}});


	},
    preparaMenu:function(n){
          var data = this.getSelectedData();
          var tb =this.tbar;
          this.getBoton('btnLlamar').enable();

          Phx.vista.FichaAtencion.superclass.preparaMenu.call(this,n);
    },

    liberaMenu:function(){
        var tb = Phx.vista.FichaAtencion.superclass.liberaMenu.call(this);
        this.getBoton('btnLlamar').enable();

    },
    onReloadPage:function(m){
		this.maestro=m;
		//this.store.baseParams={id_gestion:this.maestro.id_gestion};
		this.load({params:{start:0, limit:50}})
	},
	loadValoresIniciales:function()
	{
		Phx.vista.FichaAtencion.superclass.loadValoresIniciales.call(this);
		//this.getComponente('id_gestion').setValue(this.maestro.id_gestion);
	},
    EnableSelect: function(n,extra) {
        var data = this.getSelectedData();
        Ext.apply(data,extra);

        this.preparaMenu(n);


    },


    /**
     * @function DisableSelect
     * @autor Rensi Arteaga Copari
     * se ejecuta al deseleccionar un evento de grid
     * @param {Ext.tree.node}  n  cuando viene de arbInterfaz, es el nodo selecionado
     *        {ext.grid.SelectionModel} n   el SelectionModel
     *
     */

    DisableSelect: function(n) {

        this.liberaMenu(n)

    },


    onButtonNew: function () {
        Phx.vista.FichaAtencion.superclass.onButtonNew.call(this);

        console.log('this.cmbSucursal.getValue()',this.cmbSucursal.getValue());
        var dataSucSeleccionado = this.cmbSucursal.store.data.map[this.cmbSucursal.getValue()];

        this.Cmp.id_sucursal.store.baseParams.id_sucursal = dataSucSeleccionado.id;
        this.Cmp.id_sucursal.modificado = true;

        this.Cmp.id_usuario_sucursal.setValue(dataSucSeleccionado.json.id_usuario_sucursal);
        this.Cmp.id_sucursal.setValue(dataSucSeleccionado.json.id_sucursal);
        this.Cmp.id_sucursal.setRawValue(dataSucSeleccionado.json.nombre_sucursal);



        this.Cmp.ids_prioridad.setValue(dataSucSeleccionado.json.ids_prioridad);
        this.Cmp.ids_prioridad.setRawValue(dataSucSeleccionado.json.nombres_prioridad);

        this.getComponente('numero_ventanilla').setValue(dataSucSeleccionado.json.numero_ventanilla);

        console.log(dataSucSeleccionado.json)
        console.log(this);
        //this.getComponente('id_sucursal').setValue(this.maestro.id_sucursal);
    },

};
</script>
