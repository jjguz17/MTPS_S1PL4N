<label for="id_lugar_trabajo" class="col-sm-3 control-label">Lugar de trabajo <span class="asterisk">*</span></label>
<div class="col-sm-4">
    <select data-req="true" class="form-control" name="id_lugar_trabajo" id="id_lugar_trabajo" data-placeholder="[Seleccione..]">
        <option value=""></option>
        <?php
			foreach($institucion as $val) {
				echo '<option value="'.$val['id'].'">'.$val['nombre'].'</option>';
			}
		?>
    </select>
</div>
<script>
	$("#id_lugar_trabajo").change(function(){
		var id=$(this).val();
		var ids=id.split('***');
		if(id=="")
			ids[2]=0;
        $('#multi-s').load(base_url()+'index.php/verificacion/miembros_comite/'+ids[2]);
		/*$("#ptab2").load(base_url()+"index.php/verificacion/ingreso_promocion_institucion_recargado/"+ids[1]);
		$("#ptab3").load(base_url()+"index.php/verificacion/ingreso_promocion_lugar_trabajo_recargado/"+ids[2]);*/
	});
	$("select").chosen({
		'width': '100%',
		'min-width': '100px',
		'white-space': 'nowrap',
		no_results_text: "Sin resultados!"
	});
</script>