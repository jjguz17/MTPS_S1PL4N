<style>
	.ckbox input[type="checkbox"]:checked + label::after {
		top: 2px;
		left: 1px;
	}
</style>
<table class="table table2 table-hover mb30">
	<thead>
		<tr>
			<th class="all">Empleado</th>
			<th class="desktop tablet-l tablet-p" style="width: 90px">Acción</th>
		</tr>
	</thead>
	<tbody>
		<?php
			foreach($empleados_lugar_trabajo as $val) {
				echo '<tr><td class="fila" data-id="'.$val['id'].'">'.$val['nombre'].'</td><td align="center"><div class="ckbox ckbox-success">
					<input type="checkbox" name="id_empleado_ck[]" id="id_empleado_ck_'.$val['id'].'" value="'.$val['id'].'" />
					<label for="id_empleado_ck_'.$val['id'].'"></label>
				  </div>
				  </td></tr>';
			}
		?>
	</tbody>
</table>
<script language="javascript" >
	$(document).ready(function(){
		$('.table2').DataTable({
			"sPaginationType": "simple",
			responsive: true
		});
		$("select").chosen({
			'width': '100%',
			'min-width': '100px',
			'white-space': 'nowrap',
			no_results_text: "Sin resultados!",
			max_selected_options: 2
		});
		$('.fila').click(function(){
			var $fil=$(this).parent("tr"); 
			var $chk=$fil.find("input");
			$chk.click();
		});
	});
</script>