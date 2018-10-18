<label for="id_empleado_institucion" class="col-sm-3 control-label">Miembros del comité entrevistados <span class="asterisk">*</span></label>
<div class="col-sm-6">
    <select data-req="true" multiple class="form-control" data-placeholder="&nbsp;" name="id_empleado_institucion[]" id="id_empleado_institucion">
        <option value=""></option>
        <?php
            foreach($empleado_institucion as $val) {
                echo '<option value="'.$val['id'].'">'.ucwords($val['nombre']).'</option>';
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