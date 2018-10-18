<label for="id_lugar_trabajo" class="col-sm-3 control-label">Lugar de trabajo <span class="asterisk">*</span></label>
<div class="col-sm-7">
    <select data-req="true" class="form-control" name="id_lugar_trabajo" id="id_lugar_trabajo" data-placeholder="[Seleccione..]" <?php if($vacio==0) echo 'disabled="disabled"'?>>
        <option value=""></option>
        <?php
			if($vacio!=0)
				foreach($lugar_trabajo as $val) {
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