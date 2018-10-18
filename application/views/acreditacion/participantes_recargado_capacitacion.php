<div class="form-horizontal">
<div class="form-group">
    <label for="nombre_empleado" class="col-sm-3 control-label">Nombre <span class="asterisk">*</span></label>
    <div class="col-sm-7" style="margin-top: 6px;">
        <strong><?php echo $empleado_institucion['nombre_empleado'] ?></strong>
    </div>
</div>

<div class="form-group">
    <label for="dui_empleado" class="col-sm-3 control-label">DUI <span class="asterisk">*</span></label>
    <div class="col-sm-7">
        <input type="text" name="dui_empleado" id="dui_empleado" class="form-control" data-req="true" data-tip="dui" value="<?php echo $empleado_institucion['dui_empleado'] ?>" placeholder="######## - #" maxlength="10"/>
    </div>
</div>

<div class="form-group">
    <label for="cargo_empleado" class="col-sm-3 control-label">Cargo funcional<span class="asterisk">*</span></label>
    <div class="col-sm-7">
        <input type="text" name="cargo_empleado" id="cargo_empleado" class="form-control" data-req="true" data-tip="var" data-min="5"  value="<?php echo $empleado_institucion['cargo_empleado'] ?>" />
    </div>
</div>

<div class="modal-footer">
	<button type="button" id="myModalCancel" class="btn btn-primary" data-dismiss="modal"><span class="glyphicon glyphicon-floppy-saved"></span> Actualizar</button>
</div>
</div>
<script language="javascript" >
	$(document).ready(function(){
		$("#myModalCancel").click(function(){
			var url=base_url()+"index.php/acreditacion/actualizar_empleado_capacitacion/<?php echo $empleado_institucion['id_empleado_institucion'] ?>";
			var mensaje_correcto="La petición se ha completado éxitosamente!*** Los datos de miembro del comité se han actualizado exitosamente!";
			var mensaje_incorrecto="Error en la peticitión solicitada!***Se ha perdido la conexión a la red'";
			var data="dui_empleado="+$("#dui_empleado").val()+"&cargo_empleado="+$("#cargo_empleado").val();
			ajax_json(url, mensaje_correcto, mensaje_incorrecto, data);
		});	
	});
</script>