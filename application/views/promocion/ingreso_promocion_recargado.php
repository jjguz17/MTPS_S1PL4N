<?php if($id_permiso==3 || $id_permiso==4) {?>	
    <div class="form-group">
        <label for="id_empleado" class="col-sm-3 control-label">Técnico <span class="asterisk">*</span></label>
        <div class="col-sm-4">
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
<?php } ?>

<div class="form-group" id="cont-institucion">
    <label for="id_lugar_trabajo" class="col-sm-3 control-label">Lugar de trabajo <span class="asterisk">*</span></label>
    <div class="col-sm-4">
        <select data-req="true" class="form-control" name="id_lugar_trabajo" id="id_lugar_trabajo" data-placeholder="[Seleccione..]" >
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
    <label for="fecha_promocion" class="col-sm-3 control-label">Fecha de promoción <span class="asterisk">*</span></label>
    <div class="col-sm-2">
        <div class="input-group">
            <input data-req="true" data-tip="fec" type="text" class="form-control" id="fecha_promocion" name="fecha_promocion" value="<?php echo date('d/m/Y')?>" readonly="readonly" >
            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
        </div>
    </div>
</div>

<div class="form-group">
    <label for="hora_inicio" class="col-sm-3 control-label">Hora de inicio <span class="asterisk">*</span></label>
    <div class="col-sm-2">
        <div class="input-group">
            <div class="bootstrap-timepicker"><input data-req="true" id="timepicker" name="hora_inicio" type="text" class="form-control" readonly="readonly" /></div>
            <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
        </div>
    </div>
</div>

<div class="form-group">
    <label for="hora_final" class="col-sm-3 control-label">Hora de finalización <span class="asterisk">*</span></label>
    <div class="col-sm-2">
        <div class="input-group">
            <div class="bootstrap-timepicker"><input data-req="true" id="timepicker2" name="hora_final" type="text" class="form-control" readonly="readonly" /></div>
            <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
        </div>
    </div>
</div>

<div class="form-group">
    <label for="nombre_recibio" class="col-sm-3 control-label">Persona que atendió <span class="asterisk">*</span></label>
    <div class="col-sm-6">
        <input data-req="true" data-tip="var" data-min="5" type="text" name="nombre_recibio" id="nombre_recibio" class="form-control"/>
    </div>
</div>

<div class="form-group">
    <label for="observaciones" class="col-sm-3 control-label">Resultado de la visita </label>
    <div class="col-sm-7">
        <textarea data-tip="x" data-min="10" class="form-control" id="observaciones" name="observaciones" ></textarea>
    </div>
</div>
                            
<div class="form-group">
    <label class="col-sm-3 control-label">Aplica para capacitación</label>
    <div class="col-sm-4" style="margin-top: 7px;">
        <div class="ckbox ckbox-default">
            <input type="checkbox" value="1" name="necesita_comite" id="necesita_comite" />
            <label for="necesita_comite">Sí</label>
        </div>
    </div>
</div>
<script language="javascript" >
	$(document).ready(function(){
		$("select").chosen({
			'width': '100%',
			'min-width': '100px',
			'white-space': 'nowrap',
			no_results_text: "Sin resultados!"
		});
		$('#id_empleado').change(function(){
			id=$(this).val();
			if(id=="")
				id=0;
			$('#cont-institucion').load(base_url()+'index.php/promocion/institucion_visita/'+id+"/1");
			$("#ptab2").load(base_url()+"index.php/promocion/ingreso_promocion_institucion_recargado/0");
			$("#ptab3").load(base_url()+"index.php/promocion/ingreso_promocion_lugar_trabajo_recargado/0");
		});
		
		$("#id_lugar_trabajo").change(function(){
			var id=$(this).val();
			var ids=id.split('***');
			$("#ptab2").load(base_url()+"index.php/promocion/ingreso_promocion_institucion_recargado/"+ids[1]);
			$("#ptab3").load(base_url()+"index.php/promocion/ingreso_promocion_lugar_trabajo_recargado/"+ids[2]);
		});
		$('#fecha_promocion').datepicker({beforeShowDay: $.datepicker.noWeekends, maxDate: '0D'});
		$('#timepicker,#timepicker2').timepicker({defaultTIme: false});
	});
</script>