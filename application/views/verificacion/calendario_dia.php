<div id="calendar_dia" class="fc-ltr" data-val="2">
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
								$fecha=date('Y-m-d');
								foreach($visita as $val) {
									$fecha=$val['fecha'];
								}
                                echo $this->promocion_model->fecha_letras($fecha);
                            ?>
                        </th>
                        <th class="fc-agenda-gutter fc-widget-header fc-last" style="width: 7px;">&nbsp;</th>
                 	</tr>
             	</thead>
                <tbody>
                    <tr class="fc-first fc-last">
                        <th class="fc-agenda-axis fc-widget-header fc-first">&nbsp;</th>
                        <td class="fc-col0 fc-thu fc-widget-content fc-state-highlight fc-today"><div id="a1" style="height: 350px;"><div class="fc-day-content"><div style="position:relative">&nbsp;</div></div></div></td>
                        <td class="fc-agenda-gutter fc-widget-content fc-last" style="width: 7px;">&nbsp;</td>
                    </tr>
                </tbody>
            </table>
            <div style="position: absolute; z-index: 2; left: 0px; width: 100%; top: 40px;">
                <div style="position: absolute; width: 100%; overflow-x: auto; overflow-y: auto; height: 344px;" id="a2">
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
                                          	<?php
														if($val['estado']==3) {
											?>
                                           					<div class="ui-resizable-handle ui-resizable-s">
                                                               	<a title="Editar" class="editar-programacion" data-id="<?php echo $val['id'];?>" href="#"><span class="glyphicon glyphicon-edit"></span></a>
                                                              	<a title="Eliminar" class="eliminar-programacion" data-id="<?php echo $val['id'];?>" href="#"><span class="glyphicon glyphicon-remove"></span></a>
                                                            </div>
                                         	<?php
														}
											?>
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
                                          	<?php
														if($val['estado']==3) {
											?>
                                           					<div class="ui-resizable-handle ui-resizable-s">
                                                               	<a title="Editar" class="editar-programacion" data-id="<?php echo $val['id'];?>" href="#"><span class="glyphicon glyphicon-edit"></span></a>
                                                              	<a title="Eliminar" class="eliminar-programacion" data-id="<?php echo $val['id'];?>" href="#"><span class="glyphicon glyphicon-remove"></span></a>
                                                            </div>
                                         	<?php
														}
											?>
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
                                          	<?php
														if($val['estado']==3) {
											?>
                                           					<div class="ui-resizable-handle ui-resizable-s">
                                                               	<a title="Editar" class="editar-programacion" data-id="<?php echo $val['id'];?>" href="#"><span class="glyphicon glyphicon-edit"></span></a>
                                                              	<a title="Eliminar" class="eliminar-programacion" data-id="<?php echo $val['id'];?>" href="#"><span class="glyphicon glyphicon-remove"></span></a>
                                                            </div>
                                         	<?php
														}
											?>
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
                                          	<?php
														if($val['estado']==3) {
											?>
                                           					<div class="ui-resizable-handle ui-resizable-s">
                                                               	<a title="Editar" class="editar-programacion" data-id="<?php echo $val['id'];?>" href="#"><span class="glyphicon glyphicon-edit"></span></a>
                                                              	<a title="Eliminar" class="eliminar-programacion" data-id="<?php echo $val['id'];?>" href="#"><span class="glyphicon glyphicon-remove"></span></a>
                                                            </div>
                                         	<?php
														}
											?>
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
                                          	<?php
														if($val['estado']==3) {
											?>
                                           					<div class="ui-resizable-handle ui-resizable-s">
                                                               	<a title="Editar" class="editar-programacion" data-id="<?php echo $val['id'];?>" href="#"><span class="glyphicon glyphicon-edit"></span></a>
                                                              	<a title="Eliminar" class="eliminar-programacion" data-id="<?php echo $val['id'];?>" href="#"><span class="glyphicon glyphicon-remove"></span></a>
                                                            </div>
                                         	<?php
														}
											?>
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
                                          	<?php
														if($val['estado']==3) {
											?>
                                           					<div class="ui-resizable-handle ui-resizable-s">
                                                               	<a title="Editar" class="editar-programacion" data-id="<?php echo $val['id'];?>" href="#"><span class="glyphicon glyphicon-edit"></span></a>
                                                              	<a title="Eliminar" class="eliminar-programacion" data-id="<?php echo $val['id'];?>" href="#"><span class="glyphicon glyphicon-remove"></span></a>
                                                            </div>
                                         	<?php
														}
											?>
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
                                          	<?php
														if($val['estado']==3) {
											?>
                                           					<div class="ui-resizable-handle ui-resizable-s">
                                                               	<a title="Editar" class="editar-programacion" data-id="<?php echo $val['id'];?>" href="#"><span class="glyphicon glyphicon-edit"></span></a>
                                                              	<a title="Eliminar" class="eliminar-programacion" data-id="<?php echo $val['id'];?>" href="#"><span class="glyphicon glyphicon-remove"></span></a>
                                                            </div>
                                         	<?php
														}
											?>
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
                                          	<?php
														if($val['estado']==3) {
											?>
                                           					<div class="ui-resizable-handle ui-resizable-s">
                                                               	<a title="Editar" class="editar-programacion" data-id="<?php echo $val['id'];?>" href="#"><span class="glyphicon glyphicon-edit"></span></a>
                                                              	<a title="Eliminar" class="eliminar-programacion" data-id="<?php echo $val['id'];?>" href="#"><span class="glyphicon glyphicon-remove"></span></a>
                                                            </div>
                                         	<?php
														}
											?>
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
                                          	<?php
														if($val['estado']==3) {
											?>
                                           					<div class="ui-resizable-handle ui-resizable-s">
                                                               	<a title="Editar" class="editar-programacion" data-id="<?php echo $val['id'];?>" href="#"><span class="glyphicon glyphicon-edit"></span></a>
                                                              	<a title="Eliminar" class="eliminar-programacion" data-id="<?php echo $val['id'];?>" href="#"><span class="glyphicon glyphicon-remove"></span></a>
                                                            </div>
                                         	<?php
														}
											?>
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
<script>
	$(".editar-programacion").click(function(){
		var id=$(this).data("id");
		$("#formu").load(base_url()+"index.php/verificacion/programa_recargado/"+id);
		$('#modal-modal .close').click();
		return false;
	});
	$(".eliminar-programacion").click(function(){
		var id=$(this).data("id");
		var titulo="Alerta";
		var mensaje="Realmente desea eliminar este registro? No podrá revertir los cambios.";
		var url=base_url()+"index.php/verificacion/eliminar_programacion_nuevo/"+id;
		confirmacion(titulo,mensaje,url,true);
		return false;
	});
	$("#myModalLink").click(function(){
		setTimeout(function() {
			$('#cont-lugar-trabajo').load(base_url()+'index.php/verificacion/lugares_trabajo_institucion_visita_nuevo/'+$("#id_empleado").val());
		}, 1000);
	});
</script>