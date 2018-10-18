<form class="form-horizontal" target="_blank" name="formu_buscar" id="formu_buscar" method="post" action="<?php echo base_url()?>index.php/promocion/asignaciones_pdf" autocomplete="off">
    <input type="hidden" id="id_empleado" name="id_empleado">
    <div class="form-group">
        <label for="fecha_inicial" class="col-sm-4 control-label">Fecha inicio</label>
        <div class="col-sm-6">
            <div class="input-group">
                <input type="text" class="form-control" id="fecha_inicial" name="fecha_inicial" value="<?php echo date('d/m/Y')?>" readonly>
                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
            </div>
        </div>
    </div>            
    <div class="form-group">
        <label for="fecha_final" class="col-sm-4 control-label">Fecha final</label>
        <div class="col-sm-6">
            <div class="input-group">
                <input type="text" class="form-control" id="fecha_final" name="fecha_final" value="<?php $fechaFFase=date('Y-m-d');echo date('d/m/Y', strtotime(" + 7 day"));?>" readonly>
				<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
            </div>
        </div>
    </div>
    <ul class="pager wizard">
        <li><button class="btn btn-info" type="submit"><span class="fa fa-calendar-o"></span> Buscar</button></li>
    </ul>
</form>
<script>
	$(document).ready(function() {
		$('#fecha_inicial, #fecha_final').datepicker();
		$('#formu_buscar').submit(function(){
			if($('#formu #id_empleado').length!=0)
				$('#formu_buscar #id_empleado').val($('#formu #id_empleado').val());
		});
	});
</script>