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
Phx.vista.FichaInicio = {
    bedit:false,
    bnew:false,
    bsave:false,
    bdel:false,
	require:'../../../sis_colas/vista/ficha/Ficha.php',
	requireclase:'Phx.vista.Ficha',
	title:'Fichas',
	nombreVista: 'FichaInicio',
	
	swEstado : 'espera',
    gruposBarraTareas:[{name:'espera',title:'<H1 align="center"><i class="fa fa-thumbs-o-down"></i> En Espera</h1>', grupo:0,height:0},
                       {name:'en_atencion',title:'<H1 align="center"><i class="fa fa-eye"></i> En Atención</h1>', grupo:1,height:0},
                       {name:'finalizados',title:'<H1 align="center"><i class="fa fa-file-o"></i> Finalizados</h1>', grupo:2,height:0}],
	 
    // beditGroups: [0,1,2],     
     bactGroups:  [0,1,2],
     btestGroups: [0],
     bexcelGroups: [0,1,2],
	 //bnewGroups: [0,1,2],
	
	constructor: function(config) {
	    this.initButtons=[this.cmbSucursal];//, this.cmbTipoPres];
	    Phx.vista.FichaInicio.superclass.constructor.call(this,config);
        this.bloquearOrdenamientoGrid();
	    this.cmbSucursal.on('select', function(){
		    if(this.validarFiltros()){
                  this.capturaFiltros();
           }
		},this);
		
		this.bloquearOrdenamientoGrid();
		this.cmbSucursal.on('clearcmb', function() {this.DisableSelect();this.store.removeAll();}, this);
		this.cmbSucursal.on('valid', function() {this.capturaFiltros();}, this);
		//Crea el botón para llamar a la replicación
		//this.addButton('btnRepRelCon',{grupo:[2],text: 'Duplicar Presupuestos',iconCls: 'bchecklist',disabled: false,handler: this.duplicarPresupuestos,tooltip: '<b>Duplicar presupuestos </b><br/>Duplicar presupuestos para la siguiente gestión'});
		//this.addButton('btnIniTra',{grupo:[0],text: 'Iniciar',iconCls: 'bchecklist',disabled: true,handler: this.iniTramite,tooltip: '<b>Iniciar Trámite</b><br/>Inicia el trámite de formulación para el presupuesto'});
		
	   
		this.init();
		//this.TabPanelEast.get(2).disable();
        this.finCons = true; 
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
					baseParams:{par_filtro:'nombre'}
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
        this.store.baseParams.estado_ficha = this.swEstado;
        this.store.baseParams.tipo_interfaz = this.nombreVista;
    },
	
	capturaFiltros:function(combo, record, index){
		
		this.desbloquearOrdenamientoGrid();
        this.getParametrosFiltro();
        this.load({params:{start:0, limit:50, sort:'cola_atencion'}});
		
		
	},
	
	actualizarSegunTab: function(name, indice){
		
		if (name == 'espera') {
			this.cm.setHidden(6, true);
			this.cm.setHidden(7, true); // hide column 0 (0 = the first column).
			this.cm.setHidden(8, true);
			this.cm.setHidden(9, true);
			
		} else {
			this.cm.setHidden(6, false);
			this.cm.setHidden(7, false); // hide column 0 (0 = the first column).
			this.cm.setHidden(8, false);
			this.cm.setHidden(9, false);
		}
		this.swEstado = name;
		if(this.validarFiltros()){
            this.getParametrosFiltro();
            Phx.vista.Ficha.superclass.onButtonAct.call(this);
        }
    },
	
	onButtonAct:function(){
        if(!this.validarFiltros()){
            alert('Especifique los filtros antes')
         }
        else{
            this.getParametrosFiltro();
            Phx.vista.Ficha.superclass.onButtonAct.call(this);
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
          
          Phx.vista.FichaInicio.superclass.preparaMenu.call(this,n);
          /*if(data['estado'] == 'aprobado' || data['estado'] == 'preparado'){
          	 this.getBoton('btnRepRelCon').enable();
          }
          else{
          	 this.getBoton('btnRepRelCon').disable();
          }
          
          if(data['estado'] == 'borrador'){
          	 this.getBoton('btnIniTra').enable();
          }
          else{
          	 this.getBoton('btnIniTra').disable();
          }
          
           if(data['sw_consolidado'] == 'si'){
          	  this.TabPanelEast.get(2).enable();
          }
          else{
          	  this.TabPanelEast.get(2).disable();
          	  this.TabPanelEast.setActiveTab(0)
          }
          
         */
     		     
          
    },
    
    liberaMenu:function(){
        var tb = Phx.vista.FichaInicio.superclass.liberaMenu.call(this);
       /* if(tb){
            this.getBoton('btnIniTra').disable();
            this.getBoton('btnRepRelCon').disable();
        }*/
    },
    

   
    
};
</script>