<label for="id_institucion" class="col-sm-3 control-label">Empleador <span class="asterisk">*</span></label>
<div class="col-sm-7">
    <select data-req="true" class="form-control" name="id_institucion" id="id_institucion" data-placeholder="[Seleccione..]">
        <option value=""></option>
        <?php
            foreach($institucion as $val) {
                echo '<option value="'.$val['id'].'">'.$val['nombre'].'</option>';
            }
        ?>
    </select>
</div>
<script>
    $('#id_institucion').change(function(){
        var id=$(this).val();
        //alert(id_lugar_trabajo);
        $('#cont-lugar-trabajo').load(base_url()+'index.php/promocion/lugares_trabajo_institucion_visita/'+$('#id_empleado').val()+'/'+id+'/'+id_lugar_trabajo);
    });
    $("select").chosen({
        'width': '100%',
        'min-width': '100px',
        'white-space': 'nowrap',
        no_results_text: "Sin resultados!"
    });
</script>