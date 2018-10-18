<div class="form-group">
    <label for="nombre_institucion" class="col-sm-3 control-label">Razón Social <span class="asterisk">*</span></label>
    <div class="col-sm-7">
        <input data-req="true" data-tip="x" data-min="5" type="text" name="nombre_institucion" id="nombre_institucion" class="form-control" value="<?php echo $institucion['nombre'] ?>"/>
    </div>
</div>

<div class="form-group">
    <label for="nit_empleador" class="col-sm-3 control-label">NIT del empleador <span class="asterisk">*</span></label>
    <div class="col-sm-3">
        <input data-req="true" data-tip="nit" type="text" name="nit_empleador" id="nit_empleador" class="form-control" value="<?php echo $institucion['nit_empleador'] ?>"/>
    </div>
</div>
<div class="form-group">
    <label for="nombre_representante" class="col-sm-3 control-label">Nombre del representante legal <span class="asterisk">*</span></label>
    <div class="col-sm-6">
        <input data-req="true" data-tip="var" data-min="5" type="text" name="nombre_representante" id="nombre_representante" class="form-control" value="<?php echo $institucion['nombre_representante'] ?>"/>
    </div>
</div>

<div class="form-group">
    <label for="id_clasificacion" class="col-sm-3 control-label">Clasificación CIIU <span class="asterisk">*</span></label>
    <div class="col-sm-6">
        <select data-req="true" class="form-control" name="id_clasificacion" id="id_clasificacion" data-placeholder="[Seleccione..]">
            <option value=""></option>
            <?php
                foreach($clasificacion as $val) {
                    if($institucion['id_clasificacion']==$val['id'])
						echo '<option value="'.$val['id'].'" selected>'.$val['nombre'].'</option>';
					else
						echo '<option value="'.$val['id'].'">'.$val['nombre'].'</option>';
                }
            ?>
        </select>
    </div>
</div>

<div class="form-group">
    <label for="id_sector" class="col-sm-3 control-label">Sector <span class="asterisk">*</span></label>
    <div class="col-sm-4">
        <select data-req="true" class="form-control" name="id_sector" id="id_sector" data-placeholder="[Seleccione..]">
            <option value=""></option>
            <?php
                foreach($sector as $val) {
                    if($institucion['id_sector']==$val['id'])
							echo '<option value="'.$val['id'].'" selected>'.$val['nombre'].'</option>';
						else
							echo '<option value="'.$val['id'].'">'.$val['nombre'].'</option>';
                }
            ?>
        </select>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 control-label">¿Existe sindicato?</label>
    <div class="col-sm-4" style="margin-top: 7px;">
        <div class="ckbox ckbox-default">
            <input type="checkbox" value="1" name="sindicato" id="sindicato" <?php echo ($institucion['sindicato']==1)?'checked':'';?> />
            <label for="sindicato">Sí</label>
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
	});
</script>