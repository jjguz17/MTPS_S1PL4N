<?php
	$objeto='el <strong>empleado participante</strong>';
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
		$mensaje='<span class="glyphicon glyphicon-info-sign"></span> '.ucfirst($objeto).' se ha <strong>'.$accion_transaccion.'do</strong> éxitosamente! Si deseas programar una capacitación presiona <a href="'.base_url().'index.php/acreditacion/capacitacion" class="alert-link">aquí</a>.';
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
<div class="col-sm-6">
	<div class="panel panel-primary">
		<div class="panel-heading">
        <div class="panel-btns">
        	<a href="#" class="tooltips ayuda" data-ayuda="13" data-toggle="tooltip" title="" data-original-title="Ayuda"><i class="fa fa-question-circle"></i></a>
        	<a href="#"class="tooltips minimize" data-toggle="tooltip" title="" data-original-title="Minimizar">−</a>
        </div><!-- panel-btns -->
        	<h3 class="panel-title">Datos de miembro del comité</h3>
        </div>
        <div class="panel-body panel-body-nopadding">
        	<form class="form-horizontal" name="formu" id="formu" method="post" action="<?php echo base_url()?>index.php/acreditacion/guardar_participantes" autocomplete="off">
                <div id="progressWizard" class="basic-wizard">
                    
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
												if($val['id']==$idlt)
                                                	echo '<option value="'.$val['id'].'" selected="selected">'.$val['nombre'].'</option>';
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
                                        <input type="text" name="fecha_ingreso" id="fecha_ingreso" class="form-control" data-req="true" data-tip="fec" value="<?php echo date('d/m/Y')?>" readonly="readonly"/>
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
                                        <input type="checkbox" value="1" name="delegado" id="delegado" />
                                        <label for="delegado">Sí</label>
                                    </div>
                               	</div>
                           	</div>
                            
                            <div class="form-group">
                                <label for="nombre_empleado" class="col-sm-3 control-label">Nombre <span class="asterisk">*</span></label>
                                <div class="col-sm-7">
                                    <input type="text" name="nombre_empleado" id="nombre_empleado" class="form-control" data-req="true" data-tip="var" data-min="5" />
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
                                        <input type="radio" name="id_genero" value="1" id="masc" checked />
                                        <label for="masc">Masculino</label>
                                    </div>
                                    <div class="rdio rdio-success">
                                        <input type="radio" name="id_genero" value="2" id="feme" />
                                        <label for="feme">Femenino</label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="dui_empleado" class="col-sm-3 control-label">DUI <span class="asterisk">*</span></label>
                                <div class="col-sm-7">
                                    <input type="text" name="dui_empleado" id="dui_empleado" class="form-control" data-req="true" data-tip="dui" placeholder="######## - #" maxlength="10"/>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="cargo_empleado" class="col-sm-3 control-label">Cargo funcional </label>
                                <div class="col-sm-7">
                                    <input type="text" name="cargo_empleado" id="cargo_empleado" class="form-control" data-tip="var" data-min="5" />
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="id_cargo_comite" class="col-sm-3 control-label">Cargo comité </label>
                                <div class="col-sm-4">
                                    <select class="form-control" name="id_cargo_comite" id="id_cargo_comite" data-placeholder="[Seleccione..]" >
                                        <option value=""></option>
                                        <?php
                                            foreach($cargo_comite as $val) {
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
											$i=1;
                                            foreach($tipo_inscripcion as $val) {
												if($i==1) {
													$i=0;
                                                	echo '<option value="'.$val['id'].'" selected="selected">'.$val['nombre'].'</option>';
												}
												else
                                                	echo '<option value="'.$val['id'].'">'.$val['nombre'].'</option>';
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
                                    </select>
                                </div>
                            </div>
                        </div>
                   	</div><!-- tab-content -->
                    
                    <ul class="pager wizard">
                        <li><button class="btn btn-success" type="submit" name="guardar" id="guardar"><span class="glyphicon glyphicon-floppy-save"></span> Guardar</button></li>
                        <li><button class="btn btn-warning" type="reset" name="limpiar" id="limpiar"><span class="glyphicon glyphicon-trash"></span> Limpiar</button></li>
              		
                    </ul>
                </div><!-- #basicWizard -->
 			</form> 
      	</div>
    </div><!-- panel -->
</div>
<div class="col-sm-6">
	<div class="panel panel-primary">
		<div class="panel-heading">
        <div class="panel-btns">
        	<a href="#" class="tooltips ayuda" data-ayuda="14" data-toggle="tooltip" title="" data-original-title="Ayuda"><i class="fa fa-question-circle"></i></a>
        	<a href="#"class="tooltips minimize" data-toggle="tooltip" title="" data-original-title="Minimizar">−</a>
        </div><!-- panel-btns -->
        	<h3 class="panel-title" id="titulo-tabla">Empleados registrados</h3>
        </div>
        <div class="panel-body" id="contenido-tabla">
            <table class="table table-hover mb30">
                <thead>
                    <tr>
                        <th class="all">Nombre del empleado</th>
                        <th class="desktop tablet-l tablet-p" style="width:100px">Acción</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
  	</div>
</div>
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
		$('#fecha_ingreso').datepicker({maxDate: '0D'});
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
				data: {dui_empleado:$("#dui_empleado").val()},
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
		<?php 
			if($idlt!="") {
		?>
				$('#id_lugar_trabajo').change();
		<?php		
			}
		?>
	});
</script>