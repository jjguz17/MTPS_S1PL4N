<label for="id_empleado" class="col-sm-3 control-label">Técnico(s) <span class="asterisk">*</span></label>
<div class="col-sm-6">
    <select data-req="true" multiple class="form-control" name="id_empleado[]" id="id_empleado" data-placeholder="&nbsp;" >
        <option value=""></option>
        <?php
            foreach($capacitacion as $val) {
                $id=$val['id_empleado_institucion'];
                $ids[$id]=1;
                $ide[]=$val['id_empleado'];
            }
            foreach($tecnico as $val) {
                if(in_array($val['id'],$ide))
                    echo '<option value="'.$val['id'].'" selected="selected" '.$val['activo'].'>'.ucwords($val['nombre']).'</option>';
                else
                    echo '<option value="'.$val['id'].'" '.$val['activo'].'>'.ucwords($val['nombre']).'</option>';
            }
        ?>
    </select>
</div>
<script>
	$(document).ready(function(){
		$("select").chosen({
			'width': '100%',
			'min-width': '100px',
			'white-space': 'nowrap',
			no_results_text: "Sin resultados!",
			max_selected_options: 2
		});	
		$("#id_empleado").bind("chosen:maxselected", function () { alerta_rapida("Error en la selección de técnicos", "Sólo puede seleccionar 2 técnicos como máximo", "danger")}); 
	});
</script>