<?php
	$objeto='el <strong>usuario</strong>';
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
<div class="col-sm-6">
    <div class="panel panel-danger">
        <div class="panel-heading">
        <div class="panel-btns">
        	<a href="#" class="tooltips ayuda" data-ayuda="7" data-toggle="tooltip" title="" data-original-title="Ayuda"><i class="fa fa-question-circle"></i></a>
        	<a href="#"class="tooltips minimize" data-toggle="tooltip" title="" data-original-title="Minimizar">−</a>
        </div><!-- panel-btns -->
        	<h3 class="panel-title">Datos del usuario</h3>
        </div>
        <div class="panel-body panel-body-nopadding">
        	<form name="formu" id="formu" class="form-horizontal" method="post" action="<?php echo base_url()?>index.php/usuarios/guardar_usuario" autocomplete="off">
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
                                <label for="nombre_completo" class="col-sm-3 control-label">Nombre <span class="asterisk">*</span></label>
                                <div class="col-sm-8">
                                    <select name="nombre_completo" id="nombre_completo" data-req="true" class="form-control" data-placeholder="[Seleccione..]"/>
										<option value=""></option>
										<?php
                                            foreach($empleados as $val) {
                                                echo '<option value="'.$val['id_empleado'].'">'.ucwords($val['nombre']).'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="usuario" class="col-sm-3 control-label">Usuario <span class="asterisk">*</span></label>
                                <div class="col-sm-8">
                                    <input type="text" id="usuario" name="usuario" data-req="true" class="form-control"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password" class="col-sm-3 control-label">Contraseña <span class="asterisk">*</span></label>
                                <div class="col-sm-8">
                                    <input type="password" id="password" name="password" data-req="true" data-tip="pas" data-min="8" data-max="20"  class="form-control"/>
                                </div>
                            </div>
                       	 	<div class="form-group" id="multi-s">
                                <label for="id_rol" class="col-sm-3 control-label">Rol <span class="asterisk">*</span></label>
                                <div class="col-sm-8">
                                    <select name="id_rol[]" id="id_rol" data-req="true" multiple class="form-control" data-placeholder="&nbsp;">
                						<?php
											foreach($roles as $val) {
												echo '<option value="'.$val['id_rol'].'">'.ucwords($val['nombre_rol']).'</option>';
											}
										?>
									</select>
                                </div>
                            </div>
                        </div>
                 	</div>
                    <ul class="pager wizard">
                        <li><button class="btn btn-success" type="submit" name="aprobar" id="aprobar"><span class="glyphicon glyphicon-floppy-save"></span> Guardar</button></li>
                        <li><button class="btn btn-warning" type="reset" name="limpiar" id="limpiar"><span class="glyphicon glyphicon-trash"></span> Limpiar</button></li>
                    </ul>
              	</div>
          	</form>
        </div>
  	</div>
</div>
<div class="col-sm-6">
    <div class="panel panel-danger">
        <div class="panel-heading">
        <div class="panel-btns">
        	<a href="#" class="tooltips ayuda" data-ayuda="7" data-toggle="tooltip" title="" data-original-title="Ayuda"><i class="fa fa-question-circle"></i></a>
        	<a href="#"class="tooltips minimize" data-toggle="tooltip" title="" data-original-title="Minimizar">−</a>
        </div><!-- panel-btns -->
        	<h3 class="panel-title">Usuarios registrados</h3>
        </div>
        <div class="panel-body">
            <table class="table">
                <thead>
                  <tr>
                    <th>Nombre del Empleado</th>
                    <th>Usuario</th>
                    <th width="100">Opción</th>
                  </tr>
                 </thead>
                 <tbody>
                <?php
                    foreach ($usuarios as $val) {
                ?>
                  <tr>
                    <td><?php echo ucwords($val['nombre_completo'])?></td>
                    <td><?php echo $val['usuario']?></td>
                    <td>
                        <a class="modificar_usuario" title="Modificar Usuario" onClick="editar(<?php echo $val['id_usuario']?>);return false;" href="#" data-id_usuario="<?php echo $val['id_usuario']?>" data-nombre_completo="<?php echo $val['usuario']?>"><img src="<?php echo base_url()?>img/usu_editar.png"/></a>
                        <a class="eliminar_usuario" title="Eliminar Usuario" onClick="eliminar(<?php echo $val['id_usuario']?>);return false;" href="#" data-id_usuario="<?php echo $val['id_usuario']?>" data-nombre_completo="<?php echo $val['usuario']?>"><img src="<?php echo base_url()?>img/usu_borrar.png"/></a>
                    </td>
                  </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div><!-- panel -->
</div>
<script language="javascript" >
	$(document).ready(function(){
		var y=$("#id_rol").chosen().data();
		y.chosen.max_selected_options=100;
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
		$("#limpiar").click(function(){
			$("#formu").load(base_url()+"index.php/usuarios/datos_de_usuario");
		});
		$("#nombre_completo").change(function(){
			var id=$(this).val();
			$.ajax({
				type:  "post",  
				async:	true, 
				url:	base_url()+"index.php/usuarios/buscar_info_adicional_usuario",
				data:   {
						id_empleado: id
					},
				dataType: "json",
				success: function(data) { 
					if(data['estado']==1) {
						var html=data['usuario'];
						$("#usuario").val(html);
					}
					else {	
						alertify.alert('Error al intentar buscar empleado: No se encuentra el registro');
						$("#usuario").val("");
					}
				},
				error:function(data) { 
					alertify.alert('Error al intentar buscar empleado: No se pudo conectar al servidor');
					$("#usuario").val("");
				}
			});
		});
	});
	function editar(id){
		$("#formu").load(base_url()+'index.php/usuarios/datos_de_usuario/'+id);
		return false;
	}
	function eliminar(id){
		var titulo="Alerta";
		var mensaje="Realmente desea eliminar este registro? No podrá revertir los cambios.";
		var url=base_url()+"index.php/usuarios/eliminar_usuario/"+id;
		confirmacion(titulo, mensaje, url);
		return false;
	}
</script>