<form id="form_emp" class="form-horizontal">
    <div class="form-group">
        <label for="id_lugar_trabajo_2" class="col-sm-3 control-label">Lugar de trabajo</label>
        <div class="col-sm-9">
            <select data-req="true" class="form-control" name="id_lugar_trabajo" id="id_lugar_trabajo_2" data-placeholder="[Seleccione..]">
                <option value=""></option>
                <?php
                    foreach($insticion_lugar_trabajo as $val) {
                        echo '<option value="'.$val['id'].'">'.$val['nombre'].'</option>';
                    }
                ?>
            </select>
        </div>
    </div>
   	<div class="form-group">
    	<div class="col-sm-12" id="cont-empleado">
            <table class="table table2 table-hover mb30" style="width: 100%;">
                <thead>
                    <tr>
                        <th class="all">Empleado</th>
                        <th class="desktop tablet-l tablet-p" style="width: 90px">Acción</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
     	</div>
    </div>
	<div class="modal-footer">
        <button type="button" id="myModalCancel" class="btn btn-white" data-dismiss="modal"><span class="glyphicon glyphicon-plus"></span> Agregar</button>
	</div>
</form>
<script>
	$(document).ready(function(){
		$('#id_lugar_trabajo_2').change(function(){
			id=$(this).val();
			if(id=="")
				id=0;
			var empleados="";
			$("[name='id_empleado_institucion[]']").each(function(index, element) {
                empleados=empleados+$(this).val()+"-";
            });
			$('#cont-empleado').load(base_url()+'index.php/acreditacion/empleados_lugar_trabajo_capacitacion/'+id+'/'+empleados);
		});
		$('.table2').DataTable({
			"sPaginationType": "simple",
			responsive: true
		});
		var t=$('#empleados').DataTable();
		$("#myModalCancel").click(function(){
			$('.fila').each(function(indice, elemento) {
				var $fil=$(this).parent("tr"); 
				var $chk=$fil.find("input");
				if($chk.attr('checked')=="checked"){
					var id=$(this).data("id");
					var nom=$(this).html();
					if(emp[id]==1) {
					}
					else {
						emp[id]=1;
						t.row.add([
							nom+'<input type="hidden" name="id_empleado_institucion[]" value="'+id+'">',
							'<a href="#" class="edit-row" onClick="editar_empleado('+id+');return false;" data-id="'+id+'"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" class="delete-row" onClick="quitar_empleado('+id+',this);return false;" data-id="'+id+'"><i class="fa fa-trash-o"></i></a>'
						]).draw();
					}
				}
			});
		});
		$("select").chosen({
			'width': '100%',
			'min-width': '100px',
			'white-space': 'nowrap',
			no_results_text: "Sin resultados!",
			max_selected_options: 2
		});
	});
</script>