<?php
	if(isset($programacion['id_programacion_visita']) && $programacion['id_programacion_visita']!="") {
?>
		<input type="hidden" name="id_programacion_visita" id="id_programacion_visita" class="form-control"  value="<?php echo $idpv ?>" />
<?php
	}
?>    
<?php if($id_permiso==3 || $id_permiso==4) {?> 
	<div class="form-group">
	    <label for="id_empleado" class="col-sm-3 control-label">Técnico <span class="asterisk">*</span></label>
	    <div class="col-sm-7">
	        <select data-req="true" class="form-control" name="id_empleado" id="id_empleado" data-placeholder="[Seleccione..]" >
	            <option value=""></option>
	            <?php
	                foreach($tecnico as $val) {
						if($programacion['id_empleado']==$val['id'])
	                   		echo '<option value="'.$val['id'].'" selected="selected">'.ucwords($val['nombre']).'</option>';
						else
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
        <select data-req="true" class="form-control" name="id_institucion" id="id_institucion" data-placeholder="[Seleccione..]" <?php if($programacion['id_institucion']=="") echo 'disabled="disabled"' ?> >
            <option value=""></option>
            <?php
                foreach($institucion as $val) {
					if($programacion['id_institucion']==$val['id'])
                   		echo '<option value="'.$val['id'].'" selected="selected">'.ucwords($val['nombre']).'</option>';
					else
                   		echo '<option value="'.$val['id'].'">'.ucwords($val['nombre']).'</option>';
                }
            ?>
        </select>
    </div>
</div>-->

<div class="form-group" id="cont-lugar-trabajo">
    <label for="id_lugar_trabajo" class="col-sm-3 control-label">Lugar de trabajo <span class="asterisk">*</span></label>
    <div class="col-sm-7">
        <select data-req="true" class="form-control" name="id_lugar_trabajo" id="id_lugar_trabajo" data-placeholder="[Seleccione..]" <?php if($programacion['id_lugar_trabajo']=="" && !isset($lugar_trabajo)) echo 'disabled="disabled"' ?> >
            <option value=""></option>
            <?php
                foreach($lugar_trabajo as $val) {
					if($programacion['id_lugar_trabajo']==$val['id'])
                   		echo '<option value="'.$val['id'].'" selected="selected">'.ucwords($val['nombre']).'</option>';
					else
						if(isset($programacion['id_lugar_trabajo']) && $programacion['id_lugar_trabajo']!="")
                   			echo '<option value="'.$val['id'].'" disabled="disabled">'.ucwords($val['nombre']).'</option>';
						else
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
            <input data-req="true" data-tip="fec" type="text" class="form-control" id="fecha_visita" name="fecha_visita" value="<?php if($programacion['fecha_visita']!="")echo $programacion['fecha_visita']; else echo date('d/m/Y');?>" readonly />
            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
        </div>
    </div>
</div>

<div class="form-group" id="cont-lugar-trabajo">
    <label for="hora_visita" class="col-sm-3 control-label">Hora de visita <span class="asterisk">*</span></label>
    <div class="col-sm-4">
        <div class="input-group">
            <div class="bootstrap-timepicker"><input data-req="true" id="timepicker" type="text" class="form-control" value="<?php echo $programacion['hora_visita'];?>"  readonly /></div>
            <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
        </div>
    </div>
</div>

<ul class="pager wizard">
	<?php
		if(isset($programacion['id_programacion_visita']) && $programacion['id_programacion_visita']!="") {
    ?>
            <li><button class="btn btn-primary" type="button" name="actualizar" id="actualizar"><span class="glyphicon glyphicon-floppy-saved"></span> Actualizar</button></li>
    <?php
        }
        else {
    ?>
            <li><button class="btn btn-success" type="button" name="guardar" id="guardar"><span class="glyphicon glyphicon-floppy-save"></span> Guardar</button></li>
    <?php
        }
    ?>
    <li><button class="btn btn-warning" type="reset" name="limpiar" id="limpiar"><span class="glyphicon glyphicon-trash"></span> Limpiar</button></li>
</ul>

<script>
	id_lugar_trabajo=$("#id_lugar_trabajo").val();
	$(document).ready(function() {
		$('#id_empleado').change(function(){
			id=$(this).val();
			$('#cont-lugar-trabajo').load(base_url()+'index.php/verificacion/lugares_trabajo_institucion_visita_nuevo/'+id);
			$('#cont-calendario').load(base_url()+'index.php/verificacion/calendario/'+id);

		});
		
		<?php if($id_permiso==1) {?>
			$('#cont-calendario').load(base_url()+'index.php/verificacion/calendario/'+<?=$id_empleado?>);
		<?php }?>
		
		$("select").chosen({
			'width': '100%',
			'min-width': '100px',
			'white-space': 'nowrap',
			no_results_text: "Sin resultados!"
		});
		
		$('#fecha_visita').datepicker({beforeShowDay: $.datepicker.noWeekends, minDate: '0D'});
		$('#timepicker').timepicker({defaultTIme: false});
		
		$("#guardar, #actualizar").click(function(){
			if($("#id_empleado").val()!="" && $("#id_lugar_trabajo").val()!="" && $("#fecha_visita").val()!="" && $("#timepicker").val()!="") {
				$.ajax({
					async:	true, 
					url:	base_url()+"index.php/verificacion/comprobar_programacion",
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
			$("#formu").load(base_url()+"index.php/verificacion/programa_recargado");
			$('#cont-calendario').load(base_url()+'index.php/verificacion/calendario/0');
		});
	});
</script>