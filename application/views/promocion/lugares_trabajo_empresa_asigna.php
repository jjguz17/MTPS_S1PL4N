<table class="table table-hover mb30" id="lugares_trabajo">
    <thead>
        <tr>
            <th class="all">Nombre lugar de trabajo</th>
            <th class="desktop tablet-l tablet-p" style="width:100px">Acción</th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach($lugar_trabajo as $val) {
                echo '<tr><td>'.$val['nombre'].'</td><td><a href="#" class="edit-row" onClick="asignar('.$val['id'].',this,\''.$val['nombre'].'\');return false;" data-id="'.$val['id'].'"><i class="glyphicon glyphicon-paperclip"></i></a></td></tr>';
            }
        ?>
    </tbody>
</table>
<script language="javascript" >
	$(document).ready(function(){
		$('.table').DataTable({
			"sPaginationType": "simple",
			responsive: true
		});
		$("select").chosen({
			'width': '100%',
			'min-width': '100px',
			'white-space': 'nowrap',
			no_results_text: "Sin resultados!"
		});
	});	
	var t=$('#lugar_trabajo').DataTable();
	var t2=$('#lugares_trabajo').DataTable();
	function asignar(id,e,nom){
		t.row.add([
			nom+'<input type="hidden" name="id_lugar_trabajo[]" value="'+id+'">',
			'<a href="#" class="delete-row" onClick="quitar_asignacion('+id+',this,\''+nom+'\');return false;" data-id="'+id+'"><i class="fa fa-trash-o"></i></a>'
		]).draw();
		var padre=e.parentNode.parentNode;
		padre.className="quitar";
		t2.row('.quitar').remove().draw( false );
		return false;
	}	
	function quitar_asignacion(id,e,nom){
		t2.row.add([
			nom,
			'<a href="#" class="edit-row" onClick="asignar('+id+',this,\''+nom+'\');return false;" data-id="'+id+'"><i class="glyphicon glyphicon-paperclip"></i></a>'
		]).draw();
		var padre=e.parentNode.parentNode;
		padre.className="quitar";
		t.row('.quitar').remove().draw( false );
		return false;
	}
</script>