<select data-req="true" class="form-control" name="mes" id="mes" data-placeholder="[Seleccione..]">
	<option value="0"></option>
	<?php
	    foreach($meses as $val) {
	      if($val['id']==date('m'))
	        echo '<option value="'.$val['id'].'" selected="selected">'.$val['nombre'].'</option>';
	      else
	        echo '<option value="'.$val['id'].'">'.$val['nombre'].'</option>';
	    }
  	?>
</select>
<script language="javascript" >
	$(document).ready(function(){	
		$("select").chosen({
			'width': '100%',
			'min-width': '100px',
			'white-space': 'nowrap',
			no_results_text: "Sin resultados!"
		});
	});
</script>