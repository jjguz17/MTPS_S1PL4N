<?php
	$objeto='el registro de <strong>programación</strong>';
	switch($accion_transaccion) {
		case 1: 
			$accion_transaccion="guarda";
			break;
		case 2: 
			$accion_transaccion="actualiza";
			break;
		case 3: 
			$accion_transaccion="elimina";
			break;
	}
	if($estado_transaccion==1) {
		$class='success';
		$mensaje='<span class="glyphicon glyphicon-info-sign"></span> '.ucfirst($objeto).' se ha <strong>'.$accion_transaccion.'do</strong> éxitosamente! Si deseas crear el registro de promoción de un lugar de trabajo <a href="'.base_url().'index.php/promocion/ingreso" class="alert-link">aquí</a>.';
	}
	else {
		$class='danger';
		$mensaje='<span class="glyphicon glyphicon-exclamation-sign"></span> Error al intentar <strong>'.$accion_transaccion.'r</strong> '.$objeto.': Se perdió la señal de la red. Porfavor vuelva a intentarlo.';
	}
	if($estado_transaccion!="" && $estado_transaccion!=NULL) {	
?>
        <div class="alert alert-<?php echo $class?>">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <?php echo $mensaje?>
        </div>
<?php } 

include(base_url."index.php/promocion/calendario_dia");
?>
<div class="col-md-6">
	<div class="panel panel-primary">
		<div class="panel-heading">
        <div class="panel-btns">
        	<a href="#" class="tooltips ayuda" data-ayuda="5" data-toggle="tooltip" title="" data-original-title="Ayuda"><i class="fa fa-question-circle"></i></a>
        	<a href="#"class="tooltips minimize" data-toggle="tooltip" title="" data-original-title="Minimizar">−</a>
        </div><!-- panel-btns -->
        	<h3 class="panel-title">Datos de la visita</h3>
        </div>
        <div class="panel-body">
  			<form class="form-horizontal" name="formu" id="formu" method="post" action="<?php echo base_url()?>index.php/promocion/guardar_programacion_nuevo" autocomplete="off">                
				<?php if($id_permiso==3 || $id_permiso==4) {?>
                    <div class="form-group">
                        <label for="id_empleado" class="col-sm-3 control-label">Técnico <span class="asterisk">*</span></label>
                        <div class="col-sm-7">
                            <select data-req="true" class="form-control" name="id_empleado" id="id_empleado" data-placeholder="[Seleccione..]" >
                                <option value=""></option>
                                <?php
                                    foreach($tecnico as $val) {
                                        echo '<option value="'.$val['id'].'">'.ucwords($val['nombre']).'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
           		<?php } else {?>
                	<input type="hidden" name="id_empleado" id="id_empleado" value="<?=$id_empleado?>" />                	
          		<?php } ?>
                <!--<div class="form-group" id="cont-institucion">
                    <label for="id_institucion" class="col-sm-3 control-label">Establecimiento <span class="asterisk">*</span></label>
                    <div class="col-sm-7">
                        <select class="form-control" name="id_institucion" id="id_institucion" data-placeholder="[Seleccione..]" disabled="disabled">
                            <option value=""></option>
                        </select>
                    </div>
                </div>-->
                
               	<div class="form-group" id="cont-lugar-trabajo">
                    <label for="id_lugar_trabajo" class="col-sm-3 control-label">Lugar de trabajo <span class="asterisk">*</span></label>
                    <div class="col-sm-7">
                        <select class="form-control" name="id_lugar_trabajo" id="id_lugar_trabajo" data-placeholder="[Seleccione..]" <?php if(!isset($lugar_trabajo)) echo 'disabled="disabled"' ?>>
                            <option value=""></option>
				            <?php
				                foreach($lugar_trabajo as $val) {
									echo '<option value="'.$val['id'].'">'.ucwords($val['nombre']).'</option>';
				                }
				            ?>
                        </select>
                    </div>
                </div>
                
               	<div class="form-group" id="cont-lugar-trabajo">
                    <label for="fecha_visita" class="col-sm-3 control-label">Fecha de visita <span class="asterisk">*</span></label>
                    <div class="col-sm-4">
                    	<div class="input-group">
                            <input data-req="true" data-tip="fec" type="text" class="form-control" id="fecha_visita" name="fecha_visita" value="<?php echo date('d/m/Y')?>" readonly="readonly" >
                            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                      	</div>
                    </div>
                </div>
                
               	<div class="form-group" id="cont-lugar-trabajo">
                    <label for="hora_visita" class="col-sm-3 control-label">Hora de visita <span class="asterisk">*</span></label>
                    <div class="col-sm-4">
                    	<div class="input-group">
                            <div class="bootstrap-timepicker"><input data-req="true" id="timepicker" type="text" class="form-control" readonly="readonly" /></div>
                     		<span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                    	</div>
                    </div>
                </div>
                
                <ul class="pager wizard">
                    <li><button class="btn btn-success" type="button" name="guardar" id="guardar"><span class="glyphicon glyphicon-floppy-save"></span> Guardar</button></li>
                    <li><button class="btn btn-warning" type="reset" name="limpiar" id="limpiar"><span class="glyphicon glyphicon-trash"></span> Limpiar</button></li>
                </ul>
            </form>
      	</div>
   	</div>
</div>
<div class="col-md-6">
	<div class="panel panel-primary">
		<div class="panel-heading">
        <div class="panel-btns">
        	<a href="#" class="tooltips ayuda" data-ayuda="6" data-toggle="tooltip" title="" data-original-title="Ayuda"><i class="fa fa-question-circle"></i></a>
        	<a href="#"class="tooltips minimize" data-toggle="tooltip" title="" data-original-title="Minimizar">−</a>
        </div><!-- panel-btns -->
        	<h3 class="panel-title">Calendario de actividades</h3>
        </div>
        <div class="panel-body panel-body-nopadding" id="cont-calendario">
  			<div id="calendar"></div>
      	</div>
   	</div>
</div>
<script>
	var id_lugar_trabajo="";
	$(document).ready(function() {
		var date = new Date('2014-7-13 13:34:12');
		var d = date.getDate();
		var m = date.getMonth();
		var y = date.getFullYear();
		
		$('#id_empleado').change(function(){
			id=$(this).val();
			if(id=="")
				id=0;
			/*$('#cont-institucion').load(base_url()+'index.php/promocion/institucion_visita/'+id);
			$('#cont-lugar-trabajo').load(base_url()+'index.php/promocion/lugares_trabajo_institucion_visita/0/0/0');*/
			$('#cont-lugar-trabajo').load(base_url()+'index.php/promocion/lugares_trabajo_institucion_visita_nuevo/'+id);
			$('#cont-calendario').load(base_url()+'index.php/promocion/calendario/'+id);
		});
		
		<?php if($id_permiso==1) {?>
			$('#cont-calendario').load(base_url()+'index.php/promocion/calendario/'+<?=$id_empleado?>);
		<?php }?>
		
		$('#fecha_visita').datepicker({beforeShowDay: $.datepicker.noWeekends, minDate: '0D'});
		$('#timepicker').timepicker({defaultTIme: false});
		
		$('#calendar').fullCalendar({
			header: {
				right: 'today prev,next',
				center: 'title',
				left: ''
			},
			buttonText: {
				today : 'Hoy',
				month: 'Mes',
				agendaWeek: 'Semana',
				agendaDay: 'Día'
			},
			monthNamesShort : ['Enero' , 'Febrero' , 'Marzo' , 'Abril' , 'Mayo' , 'Junio' , 'Julio' , 'Agosto' , 'Septiembre' , 'Octubre' , 'Noviembre' , 'Diciembre' ],
			dayNamesShort : ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],   
			titleFormat : "MMM yyyy",  
			columnFormat:'ddd',  
			timeFormat: 'h:mm tt  - h:mm tt \n',  
			
			defaultView: 'month',
			editable: false,
			eventDurationEditable: false,
			eventStartEditable: false,
			droppable: false,
			selectHelper: false,
			slotMinutes: 60,
			selectable: false,
			minTime : 7,
			maxTime : 18,
			firstDay : 1,
			allDaySlot : false,
			weekends: false,
			defaultEventMinutes : 60,  
          	dragOpacity: "0.5",		
			slotEventOverlap: false,	
			unselectAuto: false,
			weekMode : false,  
			dayClick: function(date, view) {
			},
			eventClick: function(event, jsEvent){
          	}
		});
		$("#guardar").click(function(){
			if($("#id_empleado").val()!="" && $("#id_lugar_trabajo").val()!="" && $("#fecha_visita").val()!="" && $("#timepicker").val()!="") {
				$.ajax({
					async:	true, 
					url:	base_url()+"index.php/promocion/comprobar_programacion",
					dataType:"json",
					type: "POST",
					data: $("#formu").serialize(),
					success: function(data) {
					var json=data;
						if(Number(json['resultado'])==1) {
							$("#formu").submit();
						}
						else {
							alerta_rapida('Error en el ingreso de programación!', 'El técnico ya tiene una visita en el día y hora ingresados', 'danger');
						}
					},
					error:function(data) {
						/*alerta_rapida('Error en el ingreso de programación!', 'Se ha perdido la conexión a la red', 'danger');*/
					}
				});			
			}
			else {
				$("#formu").submit();
			}
		});
		$("#limpiar").click(function(){
			$("#formu").load(base_url()+"index.php/promocion/programa_recargado");
			$('#cont-calendario').load(base_url()+'index.php/promocion/calendario/0');
		});
	});
</script>