<?php
	$objeto='el ingreso de la <strong>promoción</strong>';
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
		$mensaje='<span class="glyphicon glyphicon-info-sign"></span> '.ucfirst($objeto).' se ha <strong>'.$accion_transaccion.'do</strong> éxitosamente!';
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
<?php } ?>
<style>
	.ckbox input[type="checkbox"]:checked + label::after {
		top: 3px;
	}
    .ckbox #sel-todo2:checked + label::after {
        top: 0px;
    }
</style>
<div class="col-sm-1">
</div>
<div class="col-sm-10">
	<div class="panel panel-primary">
		<div class="panel-heading">
        <div class="panel-btns">
            <a href="#" class="tooltips ayuda" data-ayuda="10" data-toggle="tooltip" title="" data-original-title="Ayuda"><i class="fa fa-question-circle"></i></a>
        	<a href="#"class="tooltips minimize" data-toggle="tooltip" title="" data-original-title="Minimizar">−</a>
        </div><!-- panel-btns -->
        	<h3 class="panel-title">Datos de la promoción</h3>
        </div>
        <div class="panel-body panel-body-nopadding">
        	<form class="form-horizontal" name="formu" id="formu" method="post" action="<?php echo base_url()?>index.php/promocion/guardar_ingreso_promocion" autocomplete="off">
                <div id="progressWizard" class="basic-wizard">
                    
                    <ul class="nav nav-pills nav-justified">
                        <li><a href="#ptab1" data-toggle="tab"><span>Paso 1:</span> Información de la Promoción</a></li>
                        <li><a href="#ptab2" data-toggle="tab"><span>Paso 2:</span> Información del establecimiento</a></li>
                        <li><a href="#ptab3" data-toggle="tab"><span>Paso 3:</span> Información del lugar de trabajo</a></li>
                        <li><a href="#ptab4" data-toggle="tab"><span>Paso 4:</span> Condiciones de incumplimiento</a></li>
                    </ul>
                      
                    <div class="tab-content">
                    
                      	<div class="progress progress-striped active">
                        	<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"></div>
                      	</div>
                      
                  		<div class="tab-pane" id="ptab1">
							<?php if($id_permiso==3 || $id_permiso==4) {?>	
                                <div class="form-group">
                                    <label for="id_empleado" class="col-sm-3 control-label">Técnico <span class="asterisk">*</span></label>
                                    <div class="col-sm-4">
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
                          	<?php } ?>
                            
							<div class="form-group" id="cont-institucion">
                                <label for="id_lugar_trabajo" class="col-sm-3 control-label">Lugar de trabajo <span class="asterisk">*</span></label>
                                <div class="col-sm-4">
                                    <select data-req="true" class="form-control" name="id_lugar_trabajo" id="id_lugar_trabajo" data-placeholder="[Seleccione..]" >
                                        <option value=""></option>
                                        <?php
                                            foreach($insticion_lugar_trabajo as $val) {
                                                echo '<option value="'.$val['id'].'">'.$val['nombre'].'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="fecha_promocion" class="col-sm-3 control-label">Fecha de promoción <span class="asterisk">*</span></label>
                                <div class="col-sm-2">
                                    <div class="input-group">
                                        <input data-req="true" data-tip="fec"type="text" class="form-control" id="fecha_promocion" name="fecha_promocion" value="<?php echo date('d/m/Y')?>" readonly="readonly" >
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="hora_inicio" class="col-sm-3 control-label">Hora de inicio <span class="asterisk">*</span></label>
                                <div class="col-sm-2">
                                    <div class="input-group">
                                        <div class="bootstrap-timepicker"><input data-req="true" id="timepicker" name="hora_inicio" type="text" class="form-control" readonly="readonly" /></div>
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="hora_final" class="col-sm-3 control-label">Hora de finalización <span class="asterisk">*</span></label>
                                <div class="col-sm-2">
                                    <div class="input-group">
                                        <div class="bootstrap-timepicker"><input data-req="true" id="timepicker2" name="hora_final" type="text" class="form-control" readonly="readonly" /></div>
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                            	<label for="nombre_recibio" class="col-sm-3 control-label">Persona que atendió <span class="asterisk">*</span></label>
                                <div class="col-sm-6">
                                    <input data-req="true" data-tip="var" data-min="5" type="text" name="nombre_recibio" id="nombre_recibio" class="form-control"/>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="observaciones" class="col-sm-3 control-label">Resultado de la visita</label>
                                <div class="col-sm-7">
                                    <textarea data-tip="x" data-min="10" class="form-control" id="observaciones" name="observaciones" ></textarea>
                                </div>
                            </div>
                            
                            <div class="form-group">
                            	<label class="col-sm-3 control-label">Aplica para capacitación</label>
                                <div class="col-sm-4" style="margin-top: 7px;">
                                    <div class="ckbox ckbox-default">
                                        <input type="checkbox" value="1" name="necesita_comite" id="necesita_comite" />
                                        <label for="necesita_comite">Sí</label>
                                    </div>
                               	</div>
                           	</div>
              			</div>
                		<div class="tab-pane" id="ptab2">
                        	<div class="form-group">
                            	<label for="nombre_institucion" class="col-sm-3 control-label">Razón Social <span class="asterisk">*</span></label>
                                <div class="col-sm-7">
                                    <input data-req="true" data-tip="x" data-min="5" type="text" name="nombre_institucion" id="nombre_institucion" class="form-control"/>
                                </div>
                            </div>
                          
                            <div class="form-group">
                                <label for="nit_empleador" class="col-sm-3 control-label">NIT del empleador <span class="asterisk">*</span></label>
                                <div class="col-sm-3">
                                    <input data-req="true" data-tip="nit" placeholder="#### - ###### - ### - #" maxlength="17" type="text" name="nit_empleador" id="nit_empleador" class="form-control"/>
                                </div>
                            </div>
                			<div class="form-group">
                   				<label for="nombre_representante" class="col-sm-3 control-label">Nombre del representante legal <span class="asterisk">*</span></label>
                        		<div class="col-sm-6">
                            		<input data-req="true" data-tip="var" data-min="5" type="text" name="nombre_representante" id="nombre_representante" class="form-control"/>
                        		</div>
                    		</div>
                   	
                          	<div class="form-group">
                            	<label for="id_clasificacion" class="col-sm-3 control-label">Clasificación CIIU <span class="asterisk">*</span></label>
                            	<div class="col-sm-6">
                              		<select data-req="true" class="form-control" name="id_clasificacion" id="id_clasificacion" data-placeholder="[Seleccione..]">
                                		<option value=""></option>
                                        <?php
											foreach($clasificacion as $val) {
												echo '<option value="'.$val['id'].'">'.$val['nombre'].'</option>';
											}
										?>
                              		</select>
                            	</div>
                          	</div>
                   	
                          	<div class="form-group">
                            	<label for="id_sector" class="col-sm-3 control-label">Sector <span class="asterisk">*</span></label>
                            	<div class="col-sm-4">
                              		<select data-req="true" class="form-control" name="id_sector" id="id_sector" data-placeholder="[Seleccione..]">
                                    	<option value=""></option>
                                        <?php
											foreach($sector as $val) {
												echo '<option value="'.$val['id'].'">'.$val['nombre'].'</option>';
											}
										?>
                              		</select>
                            	</div>
                          	</div>
                            
                            <div class="form-group">
                            	<label class="col-sm-3 control-label">¿Existe sindicato?</label>
                                <div class="col-sm-4" style="margin-top: 7px;">
                                    <div class="ckbox ckbox-default">
                                        <input type="checkbox" value="1" name="sindicato" id="sindicato"  />
                                        <label for="sindicato">Sí</label>
                                    </div>
                               	</div>
                           	</div>
                      	</div>   
                      	<div class="tab-pane" id="ptab3">
                      		<div class="form-group">
                                <label for="id_tipo_lugar_trabajo" class="col-sm-3 control-label">Tipo de lugar de trabajo <span class="asterisk">*</span></label>
                                <div class="col-sm-4">
                                    <select data-req="true" class="form-control" name="id_tipo_lugar_trabajo" id="id_tipo_lugar_trabajo" data-placeholder="[Seleccione..]" >
                                        <option value=""></option>
                                        <?php
                                            foreach($tipo_lugar_trabajo as $val) {
                                                echo '<option value="'.$val['id'].'">'.$val['nombre'].'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="nombre_lugar" class="col-sm-3 control-label">Nombre lugar de trabajo <span class="asterisk">*</span></label>
                                <div class="col-sm-7">
                                    <input data-req="true" data-tip="var" data-min="5" type="text" name="nombre_lugar" id="nombre_lugar" class="form-control" />
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="direccion_lugar" class="col-sm-3 control-label">Dirección <span class="asterisk">*</span></label>
                                <div class="col-sm-7">
                                    <textarea data-req="true" data-tip="x" data-min="10" class="form-control" id="direccion_lugar" tabindex="2" name="direccion_lugar" ></textarea>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="id_municipio" class="col-sm-3 control-label">Municipio <span class="asterisk">*</span></label>
                                <div class="col-sm-4">
                                    <select data-req="true" class="form-control" name="id_municipio" id="id_municipio" data-placeholder="[Seleccione..]" >
                                        <option value=""></option>
                                        <?php
                                            foreach($municipio as $val) {
                                                echo '<option value="'.$val['id'].'">'.$val['nombre'].'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="nombre_contacto" class="col-sm-3 control-label">Nombre contacto <span class="asterisk">*</span></label>
                                <div class="col-sm-6">
                                    <input data-req="true" data-tip="var" data-min="5" type="text" name="nombre_contacto" id="nombre_contacto" class="form-control" />
                                </div>
                            </div>
                        	
                        	<div class="form-group">
                                <label for="telefono" class="col-sm-3 control-label">Teléfono contacto <span class="asterisk">*</span></label>
                                <div class="col-sm-2">
                                    <input data-req="true" data-tip="tel" maxlength="8" placeholder="#### ####" type="tel" name="telefono" id="telefono" class="form-control"/>
                                </div>
                            </div>
                        	
                        	<div class="form-group">
                                <label for="correo" class="col-sm-3 control-label">Correo contacto <span class="asterisk">*</span></label>
                                <div class="col-sm-4">
                                    <input type="text" data-req="true" data-tip="cor" name="correo" id="correo" class="form-control" />
                                </div>
                            </div>
                        	
                        	<div class="form-group">
                                <label for="total_hombres" class="col-sm-3 control-label">Total hombres <span class="asterisk">*</span></label>
                                <div class="col-sm-2">
                                    <input data-req="true" data-tip="int" data-min="0" type="number" name="total_hombres" id="total_hombres" class="form-control" />
                                </div>
                            </div>
                        	
                        	<div class="form-group">
                                <label for="total_mujeres" class="col-sm-3 control-label">Total Mujeres <span class="asterisk">*</span></label>
                                <div class="col-sm-2">
                                    <input data-req="true" data-tip="int" data-min="0"  type="number" name="total_mujeres" id="total_mujeres" class="form-control" />
                                </div>
                            </div>
                      	</div>
                		<div class="tab-pane" id="ptab4">
                            <table class="table table-hover mb30">
                                <thead>
                                    <tr>
                                        <th class="all">Condiciones de incumplimiento</th>
                                        <th class="desktop tablet-l tablet-p" style="width:150px">Cumplimiento</th>
                                        <th class="desktop tablet-l tablet-p" style="width:200px">Base legal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        foreach($incumplimientos as $val) {
                                            echo '<tr class="tr">
													<td>'.$val['nombre'].'</td>
													<td>
														<div class="ckbox ckbox-success">
															<input type="checkbox" class="chk2" name="id_incumplimiento[]" id="id_incumplimiento_'.$val['id'].'" value="'.$val['id'].'"/>
															<label for="id_incumplimiento_'.$val['id'].'"></label>
														</div>
                                                    	<input type="hidden" class="incumplimiento_real" value="'.$val['id'].'" name="id_incumplimiento_real[]" id="id_incumplimiento_real_'.$val['id'].'">
													</td>
													<td>'.$val['base_legal'].'</td>
												</tr>';
                                        }
                                    ?>
                                </tbody>
                            </table>
                            <div class="ckbox ckbox-success"><input type="checkbox" name="sel-todo2" id="sel-todo2"  /><label for="sel-todo2">Seleccionar/Deseleccionar todo</label></div> 
                      		<div class="form-group">
                                <label for="observacion_adicional" class="col-sm-3 control-label">Otros incumplimientos </label>
                                <div class="col-sm-7">
                                    <textarea data-tip="x" data-min="10" class="form-control" id="observacion_adicional" name="observacion_adicional" ></textarea>
                                </div>
                            </div>
                        </div>  

                    </div><!-- tab-content -->
                    
                    <ul class="pager wizard">
                        <li><button class="btn btn-success" type="submit" name="guardar" id="guardar"><span class="glyphicon glyphicon-floppy-save"></span> Guardar</button></li>
                        <li><button class="btn btn-warning" type="button" name="limpiar" id="limpiar"><span class="glyphicon glyphicon-trash"></span> Limpiar</button></li>
              		</ul>
                    
            	</div><!-- #basicWizard -->
 			</form> 
      	</div>
    </div><!-- panel -->
</div>
<script language="javascript" >
	$(document).ready(function(){
		$('.table').dataTable( {
		  "filter": false,
          "paginate": false,
          "destroy": true,
          responsive: true,
          sort: false,
          info: false
		});
	  	$('#progressWizard').bootstrapWizard({
			'nextSelector': '.next',
			'previousSelector': '.previous',
			onNext: function(tab, navigation, index) {
		  		var $total = navigation.find('li').length;
		  		var $current = index+1;
		  		var $percent = ($current/$total) * 100;
		  		$('#progressWizard').find('.progress-bar').css('width', $percent+'%');
			},
			onPrevious: function(tab, navigation, index) {
		  		var $total = navigation.find('li').length;
		  		var $current = index+1;
		  		var $percent = ($current/$total) * 100;
		  		$('#progressWizard').find('.progress-bar').css('width', $percent+'%');
			},
			onTabShow: function(tab, navigation, index) {
		  		var $total = navigation.find('li').length;
		  		var $current = index+1;
		  		var $percent = ($current/$total) * 100;
		  		$('#progressWizard').find('.progress-bar').css('width', $percent+'%');
			}
	  	});
		
        $('#sel-todo2').click(function(){
            $('.chk2').prop('checked', $(this).prop('checked'));
            $('.chk2').change();
        });
		$('#id_empleado').change(function(){
			id=$(this).val();
			if(id=="")
				id=0;
			$('#cont-institucion').load(base_url()+'index.php/promocion/institucion_visita/'+id+"/1");
			$("#ptab2").load(base_url()+"index.php/promocion/ingreso_promocion_institucion_recargado/0");
			$("#ptab3").load(base_url()+"index.php/promocion/ingreso_promocion_lugar_trabajo_recargado/0");
		});
		
		$("#id_lugar_trabajo").change(function(){
			var id=$(this).val();
			var ids=id.split('***');
			$("#ptab2").load(base_url()+"index.php/promocion/ingreso_promocion_institucion_recargado/"+ids[1]);
			$("#ptab3").load(base_url()+"index.php/promocion/ingreso_promocion_lugar_trabajo_recargado/"+ids[2]);
		});
		$("#limpiar").click(function(){
			$("#ptab1").load(base_url()+"index.php/promocion/ingreso_promocion_recargado");
			$("#ptab2").load(base_url()+"index.php/promocion/ingreso_promocion_institucion_recargado/0");
			$("#ptab3").load(base_url()+"index.php/promocion/ingreso_promocion_lugar_trabajo_recargado/0");
		});
		$('#fecha_promocion').datepicker({beforeShowDay: $.datepicker.noWeekends, maxDate: '0D'});
		$('#timepicker,#timepicker2').timepicker({defaultTIme: false});
	});
</script>