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
<script>
	$("select").chosen({
		'width': '100%',
		'min-width': '100px',
		'white-space': 'nowrap',
		no_results_text: "Sin resultados!"
	});
</script>