<style>
	#a1 {height: 450px !important;}
	#a2 {height: 444px !important;}
	#calendar_dia .ui-resizable-s, .editar-programacion, .eliminar-programacion {display: none !important;}
</style>
<div class="col-md-6">
	<div class="panel panel-primary">
		<div class="panel-heading">
        <div class="panel-btns">
        	<a href="#" class="tooltips ayuda" data-ayuda="6" data-toggle="tooltip" title="" data-original-title="Ayuda"><i class="fa fa-question-circle"></i></a>
        	<a href="#"class="tooltips minimize" data-toggle="tooltip" title="" data-original-title="Minimizar">−</a>
        </div><!-- panel-btns -->
        	<h3 class="panel-title">Calendario mensual de actividades </h3>
        </div>
        <div class="panel-body">
			<?php if($id_permiso==3 || $id_permiso==4) {?>	
                <form class="form-horizontal" name="formu" id="formu">
                    <div class="form-group">
                        <label for="id_empleado" class="col-sm-3 control-label">Técnico <span class="asterisk">*</span></label>
                        <div class="col-sm-7">
                            <select class="form-control" name="id_empleado" id="id_empleado" data-placeholder="[Seleccione..]">
                                <option value=""></option>
                                <?php
                                    foreach($tecnico as $val) {
                                        echo '<option value="'.$val['id'].'">'.ucwords($val['nombre']).'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                </form>	 
            <?php } ?>
            <div id="cont-calendario">
  				<div id="calendar"></div>
            </div>
            <ul class="pager wizard">
                <li><button class="btn btn-info" type="button" name="itinerario" id="itinerario"><span class="glyphicon glyphicon-search"></span> Consultar</button></li>
            </ul>
      	</div>
   	</div>
</div>
<div class="col-md-6">
	<div class="panel panel-primary">
		<div class="panel-heading">
        <div class="panel-btns">
        	<a href="#" class="tooltips ayuda" data-ayuda="9" data-toggle="tooltip" title="" data-original-title="Ayuda"><i class="fa fa-question-circle"></i></a>
        	<a href="#"class="tooltips minimize" data-toggle="tooltip" title="" data-original-title="Minimizar">−</a>
        </div><!-- panel-btns -->
        	<h3 class="panel-title">Calendario diario de actividades</h3>
        </div>
		<div class="panel-body" id="cont-calendario-dia">
  			<div id="calendar_dia" class="fc-ltr">
                <table class="fc-header" style="width:100%; display: none;">
                    <tbody>
                        <tr>
                            <td class="fc-header-left"></td>
                            <td class="fc-header-center"><span class="fc-header-title"><h2></h2></span></td>
                            <td class="fc-header-right"></td>
                        </tr>
                    </tbody>
                </table>
                <div class="fc-content" style="position: relative;">
                    <div class="fc-view fc-view-agendaDay fc-agenda" style="position:relative" unselectable="on">
                        <table style="width:100%" class="fc-agenda-days fc-border-separate" cellspacing="0">
                            <thead>
                                <tr class="fc-first fc-last">
                                    <th class="fc-agenda-axis fc-widget-header fc-first" style="width: 50px;">&nbsp;</th>
                                    <th class="fc-thu fc-col0 fc-widget-header">
										<?php 
											echo $this->promocion_model->fecha_letras();
										?>
                                    </th>
                                    <th class="fc-agenda-gutter fc-widget-header fc-last" style="width: 7px;">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="fc-first fc-last">
                                    <th class="fc-agenda-axis fc-widget-header fc-first">&nbsp;</th>
                                    <td class="fc-col0 fc-thu fc-widget-content fc-state-highlight fc-today"><div id="a1" style="height: 450px;"><div class="fc-day-content"><div style="position:relative">&nbsp;</div></div></div></td>
                                    <td class="fc-agenda-gutter fc-widget-content fc-last" style="width: 7px;">&nbsp;</td>
                                </tr>
                            </tbody>
                        </table>
                        <div style="position: absolute; z-index: 2; left: 0px; width: 100%; top: 40px;">
                            <div style="position: absolute; width: 100%; overflow-x: auto; overflow-y: auto; height: 444px;" id="a2">
                                <div style="position:relative;width:100%;overflow: hidden;">
                                    <div class="fc-event-container" style="position:absolute;z-index:8;top:0;left:0">
                                    </div>
                                    <table class="fc-agenda-slots" style="width:100%;" cellspacing="0">
                                        <tbody>
                                            <tr class="fc-slot1 ">
                                                <th class="fc-agenda-axis fc-widget-header">8am</th>
                                                <td class="fc-widget-content">
                                                    <div style="position:relative">
                                                        <?php
                                                            $i=1;
                                                            foreach($visita as $val) {
															$class='';
															 if($val['hora_m']>='08:00' && $val['hora_m']<'09:00'){
                                                                    switch($val['estado']) {
                                                                        case 1:
                                                                            $estado="visita programada";
                                                                            break;
																		case 2:
																			$estado="Visita realizada";
																			$class='visitados';
																			break;
                                                                        case 3:
																			$estado="Verificación de cumplimiento";
																			$class='visita_2';
																			break;
																		case 4:
																			$estado="Visita de verificación realizada";
																			$class='visitados';
																			break;
																		default:
                                                                            $estado="";
                                                                    }
                                                        ?>
                                                                    <div class="fc-event <?php echo $class ?> fc-event-vert fc-event-draggable fc-event-start fc-event-end ui-draggable ui-resizable" style="position: absolute; top: 0; left: 0; width: 100%; height: 45px;">
                                                                        <div class="fc-event-inner">
                                                                            <div class="fc-event-time"><?php echo $val['hora']." - ".$val['hora_final']." * ".$estado;?><br/><?php echo $val['titulo2']." - ".$val['titulo']."";?></div>
                                                                        </div>
                                                                        <div class="ui-resizable-handle ui-resizable-s">
                                                                            <a title="Editar" class="editar-programacion" data-id="<?php echo $val['id'];?>" href="#"><span class="glyphicon glyphicon-edit"></span></a>
                                                                            <a title="Eliminar" class="eliminar-programacion" data-id="<?php echo $val['id'];?>" href="#"><span class="glyphicon glyphicon-remove"></span></a>
                                                                        </div>
                                                                    </div>
                                                        <?php
                                                                }
                                                            }
                                                        ?>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="fc-slot2 ">
                                                <th class="fc-agenda-axis fc-widget-header">9am</th>
                                                <td class="fc-widget-content">
                                                    <div style="position:relative">
                                                        <?php
                                                            $i=1;
                                                            foreach($visita as $val) {
													$class='';
													 if($val['hora_m']>='09:00' && $val['hora_m']<'10:00'){
                                                                    switch($val['estado']) {
                                                                        case 1:
                                                                            $estado="visita programada";
                                                                            break;
																		case 2:
																			$estado="Visita realizada";
																			$class='visitados';
																			break;
                                                                        case 3:
                                                                            $estado="Verificación de cumplimiento";
																			$class='visita_2';
																			break;
																		case 4:
																			$estado="Visita de verificación realizada";
																			$class='visitados';
																			break;
																		default:
                                                                            $estado="";
                                                                    }
                                                        ?>
                                                                    <div class="fc-event <?php echo $class ?> fc-event-vert fc-event-draggable fc-event-start fc-event-end ui-draggable ui-resizable" style="position: absolute; top: 0; left: 0; width: 100%; height: 45px;">
                                                                        <div class="fc-event-inner">
                                                                            <div class="fc-event-time"><?php echo $val['hora']." - ".$val['hora_final']." * ".$estado;?><br/><?php echo $val['titulo2']." - ".$val['titulo']."";?></div>
                                                                        </div>
                                                                        <div class="ui-resizable-handle ui-resizable-s">
                                                                            <a title="Editar" class="editar-programacion" data-id="<?php echo $val['id'];?>" href="#"><span class="glyphicon glyphicon-edit"></span></a>
                                                                            <a title="Eliminar" class="eliminar-programacion" data-id="<?php echo $val['id'];?>" href="#"><span class="glyphicon glyphicon-remove"></span></a>
                                                                        </div>
                                                                    </div>
                                                        <?php
                                                                }
                                                            }
                                                        ?>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="fc-slot3 ">
                                                <th class="fc-agenda-axis fc-widget-header">10am</th>
                                                <td class="fc-widget-content">
                                                    <div style="position:relative">
                                                        <?php
                                                            $i=1;
                                                            foreach($visita as $val) {
													$class='';
													 if($val['hora_m']>='10:00' && $val['hora_m']<'11:00'){
                                                                    switch($val['estado']) {
                                                                        case 1:
                                                                            $estado="visita programada";
                                                                            break;
																		case 2:
																			$estado="Visita realizada";
																			$class='visitados';
																			break;
                                                                        case 3:
																			$estado="Verificación de cumplimiento";
																			$class='visita_2';
																			break;
																		case 4:
																			$estado="Visita de verificación realizada";
																			$class='visitados';
																			break;
																		default:
                                                                            $estado="";
                                                                    }
                                                        ?>
                                                                    <div class="fc-event <?php echo $class ?> fc-event-vert fc-event-draggable fc-event-start fc-event-end ui-draggable ui-resizable" style="position: absolute; top: 0; left: 0; width: 100%; height: 45px;">
                                                                        <div class="fc-event-inner">
                                                                            <div class="fc-event-time"><?php echo $val['hora']." - ".$val['hora_final']." * ".$estado;?><br/><?php echo $val['titulo2']." - ".$val['titulo']."";?></div>
                                                                        </div>
                                                                        <div class="ui-resizable-handle ui-resizable-s">
                                                                            <a title="Editar" class="editar-programacion" data-id="<?php echo $val['id'];?>" href="#"><span class="glyphicon glyphicon-edit"></span></a>
                                                                            <a title="Eliminar" class="eliminar-programacion" data-id="<?php echo $val['id'];?>" href="#"><span class="glyphicon glyphicon-remove"></span></a>
                                                                        </div>
                                                                    </div>
                                                        <?php
                                                                }
                                                            }
                                                        ?>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="fc-slot4 ">
                                                <th class="fc-agenda-axis fc-widget-header">11am</th>
                                                <td class="fc-widget-content">
                                                    <div style="position:relative">
                                                        <?php
                                                            $i=1;
                                                            foreach($visita as $val) {
													$class='';
													 if($val['hora_m']>='11:00' && $val['hora_m']<'12:00'){
                                                                    switch($val['estado']) {
                                                                        case 1:
                                                                            $estado="visita programada";
                                                                            break;
																		case 2:
																			$estado="Visita realizada";
																			$class='visitados';
																			break;
                                                                        case 3:
																			$estado="Verificación de cumplimiento";
																			$class='visita_2';
																			break;
																		case 4:
																			$estado="Visita de verificación realizada";
																			$class='visitados';
																			break;
																		default:
                                                                            $estado="";
                                                                    }
                                                        ?>
                                                                    <div class="fc-event <?php echo $class ?> fc-event-vert fc-event-draggable fc-event-start fc-event-end ui-draggable ui-resizable" style="position: absolute; top: 0; left: 0; width: 100%; height: 45px;">
                                                                        <div class="fc-event-inner">
                                                                            <div class="fc-event-time"><?php echo $val['hora']." - ".$val['hora_final']." * ".$estado;?><br/><?php echo $val['titulo2']." - ".$val['titulo']."";?></div>
                                                                        </div>
                                                                        <div class="ui-resizable-handle ui-resizable-s">
                                                                            <a title="Editar" class="editar-programacion" data-id="<?php echo $val['id'];?>" href="#"><span class="glyphicon glyphicon-edit"></span></a>
                                                                            <a title="Eliminar" class="eliminar-programacion" data-id="<?php echo $val['id'];?>" href="#"><span class="glyphicon glyphicon-remove"></span></a>
                                                                        </div>
                                                                    </div>
                                                        <?php
                                                                }
                                                            }
                                                        ?>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="fc-slot5 ">
                                                <th class="fc-agenda-axis fc-widget-header">12pm</th>
                                                <td class="fc-widget-content">
                                                    <div style="position:relative">
                                                        <?php
                                                            $i=1;
                                                            foreach($visita as $val) {
													$class='';
													 if($val['hora_m']>='12:00' && $val['hora_m']<'13:00'){
                                                                    switch($val['estado']) {
                                                                        case 1:
                                                                            $estado="visita programada";
                                                                            break;
																		case 2:
																			$estado="Visita realizada";
																			$class='visitados';
																			break;
                                                                        case 3:
																			$estado="Verificación de cumplimiento";
																			$class='visita_2';
																			break;
																		case 4:
																			$estado="Visita de verificación realizada";
																			$class='visitados';
																			break;
																		default:
                                                                            $estado="";
                                                                    }
                                                        ?>
                                                                    <div class="fc-event <?php echo $class ?> fc-event-vert fc-event-draggable fc-event-start fc-event-end ui-draggable ui-resizable" style="position: absolute; top: 0; left: 0; width: 100%; height: 45px;">
                                                                        <div class="fc-event-inner">
                                                                            <div class="fc-event-time"><?php echo $val['hora']." - ".$val['hora_final']." * ".$estado;?><br/><?php echo $val['titulo2']." - ".$val['titulo']."";?></div>
                                                                        </div>
                                                                        <div class="ui-resizable-handle ui-resizable-s">
                                                                            <a title="Editar" class="editar-programacion" data-id="<?php echo $val['id'];?>" href="#"><span class="glyphicon glyphicon-edit"></span></a>
                                                                            <a title="Eliminar" class="eliminar-programacion" data-id="<?php echo $val['id'];?>" href="#"><span class="glyphicon glyphicon-remove"></span></a>
                                                                        </div>
                                                                    </div>
                                                        <?php
                                                                }
                                                            }
                                                        ?>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="fc-slot6 ">
                                                <th class="fc-agenda-axis fc-widget-header">1pm</th>
                                                <td class="fc-widget-content">
                                                    <div style="position:relative">
                                                        <?php
                                                            $i=1;
                                                            foreach($visita as $val) {
													$class='';
													 if($val['hora_m']>='13:00' && $val['hora_m']<'14:00'){
                                                                    switch($val['estado']) {
                                                                        case 1:
                                                                            $estado="visita programada";
                                                                            break;
																		case 2:
																			$estado="Visita realizada";
																			$class='visitados';
																			break;
                                                                        case 3:
																			$estado="Verificación de cumplimiento";
																			$class='visita_2';
																			break;
																		case 4:
																			$estado="Visita de verificación realizada";
																			$class='visitados';
																			break;
																		default:
                                                                            $estado="";
                                                                    }
                                                        ?>
                                                                    <div class="fc-event <?php echo $class ?> fc-event-vert fc-event-draggable fc-event-start fc-event-end ui-draggable ui-resizable" style="position: absolute; top: 0; left: 0; width: 100%; height: 45px;">
                                                                        <div class="fc-event-inner">
                                                                            <div class="fc-event-time"><?php echo $val['hora']." - ".$val['hora_final']." * ".$estado;?><br/><?php echo $val['titulo2']." - ".$val['titulo']."";?></div>
                                                                        </div>
                                                                        <div class="ui-resizable-handle ui-resizable-s">
                                                                            <a title="Editar" class="editar-programacion" data-id="<?php echo $val['id'];?>" href="#"><span class="glyphicon glyphicon-edit"></span></a>
                                                                            <a title="Eliminar" class="eliminar-programacion" data-id="<?php echo $val['id'];?>" href="#"><span class="glyphicon glyphicon-remove"></span></a>
                                                                        </div>
                                                                    </div>
                                                        <?php
                                                                }
                                                            }
                                                        ?>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="fc-slot7 ">
                                                <th class="fc-agenda-axis fc-widget-header">2pm</th>
                                                <td class="fc-widget-content">                            		
                                                    <div style="position:relative">
                                                        <?php
                                                            $i=1;
                                                            foreach($visita as $val) {
													$class='';
													 if($val['hora_m']>='14:00' && $val['hora_m']<'15:00'){
                                                                    switch($val['estado']) {
                                                                        case 1:
                                                                            $estado="visita programada";
                                                                            break;
																		case 2:
																			$estado="Visita realizada";
																			$class='visitados';
																			break;
                                                                        case 3:
																			$estado="Verificación de cumplimiento";
																			$class='visita_2';
																			break;
																		case 4:
																			$estado="Visita de verificación realizada";
																			$class='visitados';
																			break;
																		default:
                                                                            $estado="";
                                                                    }
                                                        ?>
                                                                    <div class="fc-event <?php echo $class ?> fc-event-vert fc-event-draggable fc-event-start fc-event-end ui-draggable ui-resizable" style="position: absolute; top: 0; left: 0; width: 100%; height: 45px;">
                                                                        <div class="fc-event-inner">
                                                                            <div class="fc-event-time"><?php echo $val['hora']." - ".$val['hora_final']." * ".$estado;?><br/><?php echo $val['titulo2']." - ".$val['titulo']."";?></div>
                                                                        </div>
                                                                        <div class="ui-resizable-handle ui-resizable-s">
                                                                            <a title="Editar" class="editar-programacion" data-id="<?php echo $val['id'];?>" href="#"><span class="glyphicon glyphicon-edit"></span></a>
                                                                            <a title="Eliminar" class="eliminar-programacion" data-id="<?php echo $val['id'];?>" href="#"><span class="glyphicon glyphicon-remove"></span></a>
                                                                        </div>
                                                                    </div>
                                                        <?php
                                                                }
                                                            }
                                                        ?>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="fc-slot8 ">
                                                <th class="fc-agenda-axis fc-widget-header">3pm</th>
                                                <td class="fc-widget-content">
                                                    <div style="position:relative">
                                                        <?php
                                                            $i=1;
                                                            foreach($visita as $val) {
													$class='';
													 if($val['hora_m']>='15:00' && $val['hora_m']<'16:00'){
                                                                    switch($val['estado']) {
                                                                        case 1:
                                                                            $estado="visita programada";
                                                                            break;
																		case 2:
																			$estado="Visita realizada";
																			$class='visitados';
																			break;
                                                                        case 3:
																			$estado="Verificación de cumplimiento";
																			$class='visita_2';
																			break;
																		case 4:
																			$estado="Visita de verificación realizada";
																			$class='visitados';
																			break;
																		default:
                                                                            $estado="";
                                                                    }
                                                        ?>
                                                                    <div class="fc-event <?php echo $class ?> fc-event-vert fc-event-draggable fc-event-start fc-event-end ui-draggable ui-resizable" style="position: absolute; top: 0; left: 0; width: 100%; height: 45px;">
                                                                        <div class="fc-event-inner">
                                                                            <div class="fc-event-time"><?php echo $val['hora']." - ".$val['hora_final']." * ".$estado;?><br/><?php echo $val['titulo2']." - ".$val['titulo']."";?></div>
                                                                        </div>
                                                                        <div class="ui-resizable-handle ui-resizable-s">
                                                                            <a title="Editar" class="editar-programacion" data-id="<?php echo $val['id'];?>" href="#"><span class="glyphicon glyphicon-edit"></span></a>
                                                                            <a title="Eliminar" class="eliminar-programacion" data-id="<?php echo $val['id'];?>" href="#"><span class="glyphicon glyphicon-remove"></span></a>
                                                                        </div>
                                                                    </div>
                                                        <?php
                                                                }
                                                            }
                                                        ?>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class="fc-slot9 ">
                                                <th class="fc-agenda-axis fc-widget-header">4pm</th>
                                                <td class="fc-widget-content">
                                                    <div style="position:relative">
                                                        <?php
                                                            $i=1;
                                                            foreach($visita as $val) {
													$class='';
													 if($val['hora_m']>='16:00' && $val['hora_m']<'17:00'){
                                                                    switch($val['estado']) {
                                                                        case 1:
                                                                            $estado="visita programada";
                                                                            break;
																		case 2:
																			$estado="Visita realizada";
																			$class='visitados';
																			break;
                                                                        case 3:
																			$estado="Verificación de cumplimiento";
																			$class='visita_2';
																			break;
																		case 4:
																			$estado="Visita de verificación realizada";
																			$class='visitados';
																			break;
																		default:
                                                                            $estado="";
                                                                    }
                                                        ?>
                                                                    <div class="fc-event <?php echo $class ?> fc-event-vert fc-event-draggable fc-event-start fc-event-end ui-draggable ui-resizable" style="position: absolute; top: 0; left: 0; width: 100%; height: 45px;">
                                                                        <div class="fc-event-inner">
                                                                            <div class="fc-event-time"><?php echo $val['hora']." - ".$val['hora_final']." * ".$estado;?><br/><?php echo $val['titulo2']." - ".$val['titulo']."";?></div>
                                                                        </div>
                                                                        <div class="ui-resizable-handle ui-resizable-s">
                                                                            <a title="Editar" class="editar-programacion" data-id="<?php echo $val['id'];?>" href="#"><span class="glyphicon glyphicon-edit"></span></a>
                                                                            <a title="Eliminar" class="eliminar-programacion" data-id="<?php echo $val['id'];?>" href="#"><span class="glyphicon glyphicon-remove"></span></a>
                                                                        </div>
                                                                    </div>
                                                        <?php
                                                                }
                                                            }
                                                        ?>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
      	</div>
   	</div>
</div>
<script>
	$('#id_empleado').change(function(){
		id=$(this).val();
		$('#cont-calendario').load(base_url()+'index.php/promocion/calendario/'+id+'/1');
		$('#cont-calendario-dia').load(base_url()+'index.php/promocion/calendario_dia/0/0');
	});
	
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
		
		events: [
			<?php
				$i=1;
				foreach($visita_mensual as $val) {
					$fecha=explode('-',$val['fecha']);
					if($i>1)
						echo ',';
					echo '{ id: "'.$val['fecha'].'", title: "'.$val['titulo'].'", start: new Date('.$fecha[0].','.($fecha[1]-1).','.$fecha[2].') }';
					$i++;
				}
			?>
		],
		
		dayClick: function(date, view) {
		},
		eventClick: function(event, jsEvent){	
			fecha_actual=event.id;	
			 <?php if($id_permiso==1) {?>		 
				$('#cont-calendario-dia').load(base_url()+'index.php/promocion/calendario_dia/<?php echo $id_empleado?>/'+event.id);
			 <?php } else {?>		 
				$('#cont-calendario-dia').load(base_url()+'index.php/promocion/calendario_dia/'+$("#id_empleado").val()+'/'+event.id);
			 <?php } ?>
		}
	});
	$("#itinerario").click(function(){
		if(($('#id_empleado').val()!="" && $('#id_empleado').length!=0) || ($('#id_empleado').length==0))
			modal("Consultar itinerario",base_url()+'index.php/promocion/buscar_asignaciones');
	});
</script>