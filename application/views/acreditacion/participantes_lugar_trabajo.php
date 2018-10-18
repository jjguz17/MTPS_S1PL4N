    <table class="table table-hover mb30">
        <thead>
            <tr>
                <th class="all">Nombre del empleado</th>
                <th class="desktop tablet-l tablet-p" style="width:100px">Acción</th>
            </tr>
        </thead>
        <tbody>
       	 	<?php
				foreach($empleados_lugar_trabajo as $val) {
					echo '<tr><td>'.$val['nombre'].'</td><td><a href="#" class="edit-row" onClick="editar('.$val['id'].');return false;" data-id="'.$val['id'].'"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" class="delete-row" onClick="eliminar('.$val['id'].');return false;" data-id="'.$val['id'].'"><i class="fa fa-trash-o"></i></a></td></tr>';
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
		/*$('.delete-row').click(function(){
		  	var id=$(this).data("id");
			var titulo="Alerta";
			var mensaje="Realmente desea eliminar este registro? No podrá revertir los cambios.";
			var url=base_url()+"index.php/acreditacion/eliminar_participante/"+id;
		  	
			confirmacion(titulo, mensaje, url);
			return false;
		});	
		$(".edit-row").click(function(){
			$("#formu").load(base_url()+"index.php/acreditacion/participantes_recargado/"+$(this).data("id"));
			return false;
		});*/
	});
	function eliminar(id){
		var titulo="Alerta";
		var mensaje="Realmente desea eliminar este registro? No podrá revertir los cambios.";
		var url=base_url()+"index.php/acreditacion/eliminar_participante/"+id;
		
		confirmacion(titulo, mensaje, url);
		return false;
	}
	function editar(id){
		$("#formu").load(base_url()+"index.php/acreditacion/participantes_recargado/"+id);
		return false;
	}
</script>