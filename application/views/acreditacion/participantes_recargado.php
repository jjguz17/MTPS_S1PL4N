<div id="progressWizard" class="basic-wizard">
	<?php
        if(isset($empleado_institucion['id_empleado_institucion']) && $empleado_institucion['id_empleado_institucion']!="") {
    ?>
            <input type="hidden" name="id_empleado_institucion" id="id_empleado_institucion" class="form-control"  value="<?php echo $empleado_institucion['id_empleado_institucion'] ?>" />
    <?php
        }
    ?>
    <ul class="nav nav-pills nav-justified">
        <li><a href="#ptab1" data-toggle="tab"><span>Paso 1:</span> Información General</a></li>
    </ul>
    <div class="tab-content">
        <div class="progress progress-striped active">
            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <div class="tab-pane" id="ptab1">
            <div class="form-group">
                <label for="id_lugar_trabajo" class="col-sm-3 control-label">Lugar de trabajo <span class="asterisk">*</span></label>
                <div class="col-sm-7">
                    <select data-req="true" class="form-control" name="id_lugar_trabajo" id="id_lugar_trabajo" data-placeholder="[Seleccione..]" >
                        <option value=""></option>
                        <?php
                            foreach($insticion_lugar_trabajo as $val) {
                               if($empleado_institucion['id_lugar_trabajo']==$val['id'])
                                    echo '<option value="'.$val['id'].'" selected>'.$val['nombre'].'</option>';
                                else
                                    echo '<option value="'.$val['id'].'">'.$val['nombre'].'</option>';
                            }
                        ?>
                    </select>
                </div>
                <div class="col-sm-1 control-label" style="text-align:left">
                    <a id="resumen_empleados" href="#" title="Resumen de conformación de Comité"><i class="fa fa-list">&nbsp;</i></a>
                </div>
            </div>
            
            <div class="form-group">
                <label for="nombre_empleado" class="col-sm-3 control-label">Fecha de ingreso al comité<span class="asterisk">*</span></label>
                <div class="col-sm-4">
                    <div class="input-group">
                        <input type="text" name="fecha_ingreso" id="fecha_ingreso" class="form-control" data-req="true" data-tip="fec" value="<?php if($empleado_institucion['fecha_ingreso']!="") echo $empleado_institucion['fecha_ingreso']; else echo date('d/m/Y')?>" readonly="readonly"/>
                        <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label for="id_tipo_representacion" class="col-sm-3 control-label">Representación <span class="asterisk">*</span></label>
                <div class="col-sm-4">
                    <select data-req="true" class="form-control" name="id_tipo_representacion" id="id_tipo_representacion" data-placeholder="[Seleccione..]" >
                        <option value=""></option>
                        <?php
                            foreach($tipo_representacion as $val) {
                                if($empleado_institucion['id_tipo_representacion']==$val['id'])
                                    echo '<option value="'.$val['id'].'" selected>'.$val['nombre'].'</option>';
                                else
                                    echo '<option value="'.$val['id'].'">'.$val['nombre'].'</option>';
                            }
                        ?>
                    </select>
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-sm-3 control-label">Delegado</label>
                <div class="col-sm-4" style="margin-top: 7px;">
                    <div class="ckbox ckbox-default">
                        <input type="checkbox" value="1" name="delegado" id="delegado" <?php if($empleado_institucion['delegado']==1)echo 'checked="checked"';?>/>
                        <label for="delegado">Sí</label>
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label for="nombre_empleado" class="col-sm-3 control-label">Nombre <span class="asterisk">*</span></label>
                <div class="col-sm-7">
                    <input type="text" name="nombre_empleado" id="nombre_empleado" class="form-control" value="<?php echo $empleado_institucion['nombre_empleado'] ?>" data-req="true" data-tip="var" data-min="5" />
                </div>
            </div>
                            
            <div class="row">                
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="col-sm-11 control-label">Género <span class="asterisk">*</span></label>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="rdio rdio-success">
                        <input type="radio" name="id_genero" value="1" id="masc" <?php if($empleado_institucion['id_genero']==1) echo 'checked';?> />
                        <label for="masc">Masculino</label>
                    </div>
                    <div class="rdio rdio-success">
                        <input type="radio" name="id_genero" value="2" id="feme" <?php if($empleado_institucion['id_genero']==2) echo 'checked';?> />
                        <label for="feme">Femenino</label>
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label for="dui_empleado" class="col-sm-3 control-label">DUI <span class="asterisk">*</span></label>
                <div class="col-sm-7">
                    <input type="text" name="dui_empleado" id="dui_empleado" class="form-control" data-req="true" data-tip="dui" value="<?php echo $empleado_institucion['dui_empleado'] ?>" placeholder="######## - #" maxlength="10"/>
                </div>
            </div>
            
            <div class="form-group">
                <label for="cargo_empleado" class="col-sm-3 control-label">Cargo funcional </label>
                <div class="col-sm-7">
                    <input type="text" name="cargo_empleado" id="cargo_empleado" class="form-control" data-tip="var" data-min="5"  value="<?php echo $empleado_institucion['cargo_empleado'] ?>" />
                </div>
            </div>
                                        
            <div class="form-group">
                <label for="id_cargo_comite" class="col-sm-3 control-label">Cargo comité </label>
                <div class="col-sm-4">
                    <select class="form-control" name="id_cargo_comite" id="id_cargo_comite" data-placeholder="[Seleccione..]" >
                        <option value=""></option>
                        <?php
                            foreach($cargo_comite as $val) {
                                if($empleado_institucion['id_cargo_comite']==$val['id'])
                                    echo '<option value="'.$val['id'].'" selected="selected">'.$val['nombre'].'</option>';
                                else
                                    echo '<option value="'.$val['id'].'">'.$val['nombre'].'</option>';
                            }
                        ?>
                    </select>
                </div>
            </div>
            
            <div class="form-group">
                <label for="id_tipo_inscripcion" class="col-sm-3 control-label">Tipo de inscripción <span class="asterisk">*</span></label>
                <div class="col-sm-4">
                    <select data-req="true" class="form-control" name="id_tipo_inscripcion" id="id_tipo_inscripcion" data-placeholder="[Seleccione..]" >
                        <option value=""></option>
                        <?php
							$i=0;
                            foreach($tipo_inscripcion as $val) {
                                if($empleado_institucion['id_tipo_inscripcion']==$val['id'])
                                    echo '<option value="'.$val['id'].'" selected>'.$val['nombre'].'</option>';
                                else {
									if($i==0) {
                                    	echo '<option value="'.$val['id'].'" selected>'.$val['nombre'].'</option>';
									}
									else {
										echo '<option value="'.$val['id'].'">'.$val['nombre'].'</option>';
									}
								}
								$i++;
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group" id="empleado_sustituye">
                <label for="id_empleado_institucion_sustituye" class="col-sm-3 control-label">Empleado a sustituir <span class="asterisk">*</span></label>
                <div class="col-sm-7">
                    <select data-req="false" class="form-control" name="id_empleado_institucion_sustituye" id="id_empleado_institucion_sustituye" data-placeholder="[Seleccione..]" disabled="disabled">
                        <option value=""></option>
                        <?php
                            foreach($empleados_lugar_trabajo_sustituyen as $val) {
                                echo '<option value="'.$val['id'].'">'.$val['nombre'].'</option>';
                            }
                        ?>
                    </select>
                </div>
            </div>
        </div>
    </div><!-- tab-content -->
    
    <ul class="pager wizard">
    	<?php
			if(isset($empleado_institucion['id_tipo_inscripcion']) && $empleado_institucion['id_tipo_inscripcion']!="") {
		?>
				<li><button class="btn btn-primary" type="submit" name="actualizar" id="actualizar"><span class="glyphicon glyphicon-floppy-saved"></span> Actualizar</button></li>
        <?php
			}
			else {
		?>
        		<li><button class="btn btn-success" type="submit" name="guardar" id="guardar"><span class="glyphicon glyphicon-floppy-save"></span> Guardar</button></li>
		<?php
			}
		?>
        <li><button class="btn btn-warning" type="reset" name="limpiar" id="limpiar"><span class="glyphicon glyphicon-trash"></span> Limpiar</button></li>
    
    </ul>
</div><!-- #basicWizard -->
<script language="javascript" >
	$(document).ready(function(){
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
        $("#id_tipo_inscripcion").change(function(){
            if($(this).val()==4 && $("#id_lugar_trabajo").val()!="") {
                $("#id_empleado_institucion_sustituye").attr("disabled",false);
                $("#id_empleado_institucion_sustituye").data("req",true);
                $("#id_empleado_institucion_sustituye").trigger("chosen:updated");
            }
            else {
                $("#id_empleado_institucion_sustituye").val("");
                $("#id_empleado_institucion_sustituye").attr("disabled",true);
                $("#id_empleado_institucion_sustituye").data("req",false);
                $("#id_empleado_institucion_sustituye").trigger("chosen:updated");
            }
        });
		$("#limpiar").click(function(){
			$("#formu").load(base_url()+"index.php/acreditacion/participantes_recargado");
			$('#contenido-tabla').load(base_url()+'index.php/acreditacion/empleados_lugar_trabajo/0');
		});	
		$('#id_lugar_trabajo').change(function(){
			id=$(this).val();
			if(id=="")
				id=0;
			$('#contenido-tabla').load(base_url()+'index.php/acreditacion/empleados_lugar_trabajo/'+id);
            $('#empleado_sustituye').load(base_url()+'index.php/acreditacion/empleados_lugar_trabajo_sustituyen/'+id);
            $("#id_tipo_inscripcion").change();
		});
		$('#fecha_ingreso').datepicker({maxDate: '0D'});
		$("select").chosen({
			'width': '100%',
			'min-width': '100px',
			'white-space': 'nowrap',
			no_results_text: "Sin resultados!"
		});
        $('#resumen_empleados i').click(function(){
            var id=$("#id_lugar_trabajo").val();
            if(id!="")
                modal("Resumen de conformación de comité",base_url()+'index.php/acreditacion/resumen_empleados_comite/'+id);
            return false;
        });
		$("#dui_empleado").blur(function(){
			$.ajax({
				async: true, 
				url: base_url()+'index.php/acreditacion/busqueda_dui_empleados',
				dataType:"json",
				type: "POST",
				data: {dui_empleado:$("#dui_empleado").val(),id_empleado_institucion:$("#id_empleado_institucion").val()},
				success: function(data) {
					var json=data;
					if(Number(json['resultado'])!=0)
						alerta("Búsqueda de empleado", "El número DUI ya está registrado")
				},
				error:function(data) {
					alerta_rapida("Error en la búsqueda de empleado", 'Se ha perdido la conexión a la red', 'danger');
				}
			});	
		});
	});
</script>