<?php
/**
*@package pXP
*@file FichaNoShow.php
*@author  (José Mita)
*@date 1-08-2016 10:11:23
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/
header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.FichaNoShow= {
    bedit:false,
    bnew:false,
    bsave:false,
    bdel:false,
	require:'../../../sis_colas/vista/ficha/Ficha.php',
	requireclase:'Phx.vista.Ficha',
	title:'Fichas',
	nombreVista: 'FichaNoShow',
	
	swEstado : 'no_show',
    
	
	constructor: function(config) {
	    this.initButtons=[this.cmbSucursal];//, this.cmbTipoPres];
	    Phx.vista.FichaNoShow.superclass.constructor.call(this,config);
        this.bloquearOrdenamientoGrid();
        this.store.baseParams.estado = 'no_show';
        this.store.baseParams.filtroUsuario = 'si';
	    this.cmbSucursal.on('select', function(){
		    if(this.validarFiltros()){
                  this.capturaFiltros();
           }
		},this);
		
		this.bloquearOrdenamientoGrid();
		this.cmbSucursal.on('clearcmb', function() {this.DisableSelect();this.store.removeAll();}, this);
		
		//Crea el botón para llamar a la replicación
		//this.addButton('btnRepRelCon',{grupo:[2],text: 'Duplicar Presupuestos',iconCls: 'bchecklist',disabled: false,handler: this.duplicarPresupuestos,tooltip: '<b>Duplicar presupuestos </b><br/>Duplicar presupuestos para la siguiente gestión'});
		//this.addButton('btnLlamar',{text: 'Llamar siguiente',iconCls: 'bchecklist',disabled: true,handler: this.llamarSiguiente,tooltip: '<b>Llamar Siguiente</b><br/>Llama a la siguiente persona de la cola'});
		this.addButton('btnActivar', { grupo:[0], text:'Activar Fichas', iconCls: 'bchecklist', disabled:true,handler:this.activarFicha,tooltip: '<b>Activar Ficha</b><p>Activa la ficha que no se presento</p>'});	   
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
		 
   },
   iniciarEventos : function () {
   		this.cmbSucursal.store.load({params:{start:0,limit:this.tam_pag}, 
           callback : function (r) {
           		if (r.length == 1 ) { 
           			this.cmbSucursal.setValue(r[0].data.id_sucursal);
           			this.cmbSucursal.fireEvent('select',this.cmbSucursal, this.cmbSucursal.store.getById(r[0].data.id_sucursal));	
           			
           		}
           		
            }, scope : this
        });
   },
   
activarFicha: function(n){
		var data = this.getSelectedData();
        var tb =this.tbar;
        Phx.vista.FichaNoShow.superclass.preparaMenu.call(this,n);
        
		//alert (data['id_sucursal_servicio']); exit;
		if(data['id_sucursal_servicio'] != ''){
			Phx.CP.loadingShow(); 
	   		Ext.Ajax.request({
				url: '../../sis_colas/control/Ficha/activarFicha',
			  	params:{
			  		id_ficha: data['id_ficha']
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
	
   
  
   cmbSucursal: new Ext.form.ComboBox({
				fieldLabel: 'Sucursal',
				grupo:[0,1,2],
				allowBlank: false,
				emptyText:'Sucursal...',
				store:new Ext.data.JsonStore(
				{
					url: '../../sis_colas/control/Sucursal/listarSucursal',
					id: 'id_sucursal',
					root: 'datos',
					sortInfo:{
						field: 'nombre',
						direction: 'ASC'
					},
					totalProperty: 'total',
					fields: ['id_sucursal','nombre'],
					// turn on remote sorting
					remoteSort: true,
					baseParams:{par_filtro:'nombre',filtroUsuario:'si'}
				}),
				valueField: 'id_sucursal',
				triggerAction: 'all',
				displayField: 'nombre',
			    hiddenName: 'id_sucursal',
    			mode:'remote',
				pageSize:50,
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
    
    getParametrosFiltro: function(){
    	this.store.baseParams.id_sucursal=this.cmbSucursal.getValue();
        //this.store.baseParams.codigos_tipo_pres = this.cmbTipoPres.getValue();
        this.store.baseParams.estado_ficha = 'no_show';
        this.store.baseParams.tipo_interfaz = this.nombreVista;
    },
	
	capturaFiltros:function(combo, record, index){
		
		this.desbloquearOrdenamientoGrid();
        this.getParametrosFiltro();
        this.load({params:{start:0, limit:50}});
		
		
	},
    preparaMenu:function(n){
          var data = this.getSelectedData();
          var tb =this.tbar;
          this.getBoton('btnActivar').enable();
          
          Phx.vista.FichaNoShow.superclass.preparaMenu.call(this,n);
    },
    
    liberaMenu:function(){
        var tb = Phx.vista.FichaNoShow.superclass.liberaMenu.call(this);
        //this.getBoton('btnActivar').enable();
      
    }
    
};
</script>