<div class="form-group">
    <label for="id_empleado" class="col-sm-3 control-label">Técnico <span class="asterisk">*</span></label>
    <div class="col-sm-7">
        <select data-req="true" class="form-control" name="id_empleado" id="id_empleado" data-placeholder="[Seleccione..]" >
            <option value=""></option>
            <?php
                foreach($tecnico as $val) {
                    echo '<option value="'.$val['id'].'">'.ucwords($val['nombre']).'</option>';
                }
            ?>
        </select>
    </div>
</div>
<div class="form-group">
    <div class="col-sm-12">		
        <table class="table table-hover mb30" id="lugar_trabajo">
            <thead>
                <tr>
                    <th class="all">Nombre lugar de trabajo</th>
                    <th class="desktop tablet-l tablet-p" style="width:100px">Acción</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>                 
<ul class="pager wizard">
    <li><button class="btn btn-success" type="button" name="guardar" id="guardar"><span class="glyphicon glyphicon-floppy-save"></span> Guardar</button></li>
    <li><button class="btn btn-warning" type="reset" name="limpiar" id="limpiar"><span class="glyphicon glyphicon-trash"></span> Limpiar</button></li>
</ul>
<input type="hidden" name="tabla" id="tabla" />
<script>
	$(document).ready(function() {
		var table = $('.table').dataTable();
		var tt=$('#lugar_trabajo').DataTable();
		$("#formu").submit(function(){
        	var data = table.$('input, select').serialize();
			$('#tabla').val(data);
		});
		$('#id_empleado').change(function(){
			id=$(this).val();
			$('#contenido-tabla').load(base_url()+'index.php/promocion/lugares_trabajo_empresa_asigna/'+id);
			$('#lugar_trabajo').find('tbody tr').addClass('quitar');
			tt.row('.quitar').remove().draw( false );
		});
		$("#guardar").click(function(){
			$("#formu").submit();
		});
		$("#limpiar").click(function(){
			$('#lugar_trabajo').find('tbody tr').addClass('quitar');
			tt.row('.quitar').remove().draw( false );
			$('#id_empleado').val("");
			$("#id_empleado").trigger("chosen:updated");
			$('#id_empleado').change();
		});
	});
</script>