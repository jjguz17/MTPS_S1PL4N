<?php
	$id_usuario="";
	$nombre_completo="";
	$usuario="";
	$id_rol[]="";
	$req='data-req="true"';
	$reqla='<span class="asterisk">*</span>';
	foreach ($usu as $val) {
		$id_usuario=$val['id_usuario'];
		$nombre_completo=ucwords($val['nombre_completo']);
		$usuario=$val['usuario'];
		$id_rol[]=$val['id_rol'];
		$req='';
		$reqla='';
	}
?>
<div id="progressWizard" class="basic-wizard">
	<?php
		if(isset($id_usuario) && $id_usuario!="") {
	?>
  			<input type="hidden" id="id_usuario" name="id_usuario" value="<?=$id_usuario?>"/>
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
                <label for="nombre_completo" class="col-sm-3 control-label">Nombre <span class="asterisk">*</span></label>
                <div class="col-sm-8">
                    <?php
                        if($id_usuario=="") {
                    ?>
                        <select name="nombre_completo" id="nombre_completo" data-req="true" class="form-control" data-placeholder="[Seleccione..]">
                            <option value=""></option>
                            <?php
                                foreach($empleados as $val) {
                                    echo '<option value="'.$val['id_empleado'].'">'.ucwords($val['nombre']).'</option>';
                                }
                            ?>
                        </select>
                    <?php
                        }
                        else
                            echo '<label class="col-sm-8 control-label" style="text-align: left;"><strong> '.$nombre_completo.' </strong></label>';
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label for="usuario" class="col-sm-3 control-label">Usuario <span class="asterisk">*</span></label>
                <div class="col-sm-8">
                    <?php
                        if($id_usuario=="") {
                    ?>
                        <input type="text" id="usuario" name="usuario" data-req="true" class="form-control"/>
                    <?php
                        }
                        else
                            echo '<label class="col-sm-8 control-label" style="text-align: left;"><strong> '.$usuario." </strong></label>";
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label for="password" class="col-sm-3 control-label">Contraseña <?=$reqla?></label>
                <div class="col-sm-8">
                    <input type="password" id="password" name="password" <?=$req?> data-tip="pas" data-min="8" data-max="20" class="form-control"/>
                </div>
            </div>
            <div class="form-group" id="multi-s">
                <label for="id_rol" class="col-sm-3 control-label">Rol <span class="asterisk">*</span></label>
                <div class="col-sm-8">
                    <select name="id_rol[]" id="id_rol"  data-req="true" multiple class="form-control" data-placeholder="&nbsp;">
                        <?php
                            foreach($roles as $val) {
                                if(in_array($val['id_rol'], $id_rol))
                                    echo '<option value="'.$val['id_rol'].'" selected="selected">'.ucwords($val['nombre_rol']).'</option>';
                                else
                                    echo '<option value="'.$val['id_rol'].'">'.ucwords($val['nombre_rol']).'</option>';
                            }
                        ?>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <ul class="pager wizard">
        <?php
            if(isset($id_usuario) && $id_usuario!="") {
        ?>
                <li><button class="btn btn-primary" type="submit" name="aprobar" id="aprobar"><span class="glyphicon glyphicon-floppy-saved"></span> Actualizar</button></li>
        <?php
            }
            else {
        ?>
                <li><button class="btn btn-success" type="submit" name="aprobar" id="aprobar"><span class="glyphicon glyphicon-floppy-save"></span> Guardar</button></li>
        <?php
            }
        ?>
        <li><button class="btn btn-warning" type="reset" name="limpiar" id="limpiar"><span class="glyphicon glyphicon-trash"></span> Limpiar</button></li>
    </ul>
</div>
<script>
	$(document).ready(function() {
		$("#formu select").chosen({
			'width': '100%',
			'min-width': '100px',
			'white-space': 'nowrap',
			no_results_text: "Sin resultados!"
		});
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
	});
</script>