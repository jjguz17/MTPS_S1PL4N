<?php
	$id_rol="";
	$nombre_rol="";
	$descripcion_rol="";
	foreach ($rol as $val) {
		$id_rol=$val['id_rol'];
		$nombre_rol=ucwords($val['nombre_rol']);
		$descripcion_rol=$val['descripcion_rol'];
	}
?>
<?php
	if(isset($id_rol) && $id_rol!="") {
?>
		<input type="hidden" id="id_rol" name="id_rol" value="<?=$id_rol?>"/>
<?php
	}
?>
<div class="project-box-content project-box-content-nopadding">
    <div id="myWizard" class="wizard" data-restrict="">
        <div class="wizard-inner">
            <ul class="steps">
                <li data-target="#step1" class="active"><span class="badge badge-primary">1</span>Datos generales<span class="chevron"></span></li>
             	<li data-target="#step2"><span class="badge">2</span>Datos del sistema<span class="chevron"></span></li>
            </ul>
            <div class="actions">
                <button type="button" class="btn btn-default btn-mini btn-prev"> <i class="icon-arrow-left"></i><i class="fa fa-chevron-left"></i></button>
                <button type="button" class="btn btn-success btn-mini btn-next" data-last=""><i class="fa fa-chevron-right"></i><i class="icon-arrow-right"></i></button>
            </div>
        </div>
        <div class="step-content">
            <div class="step-pane active" id="step1">
                <br/>
                <div class="form-group">
                    <label for="nombre_rol" class="col-sm-3 control-label">Nombre del rol <span class="asterisk">*</span></label>
                    <div class="col-sm-8">
                    <input type="text" data-req="true" id="nombre_rol" name="nombre_rol" value="<?=$nombre_rol?>" class="form-control"/>
                    </div>
                </div>
                <div class="form-group">
                    <label for="descripcion_rol" class="col-sm-3 control-label">Descripción <span class="asterisk">*</span></label>
                    <div class="col-sm-8">
                    <textarea class="form-control" id="descripcion_rol" data-req="true" name="descripcion_rol"><?=$descripcion_rol?></textarea>
                    </div>
                </div>
            </div>
            <div class="step-pane" id="step2">
                <br/>
                <div id="html1">
                    <?=$menu?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="project-box-footer clearfix">
</div>
<div class="project-box-ultrafooter clearfix">
    <ul class="pager wizard">
        <?php
			if(isset($id_rol) && $id_rol!="") {
		?>
				<li><button class="btn btn-primary" type="submit" name="aprobar" id="aprobar"><span class="glyphicon glyphicon-floppy-saved"></span> Actualizar</button></li>
        <?php
			}
			else {
		?>
        		<li><button class="btn btn-success" type="submit" name="aprobar" id="aprobar"><span class="glyphicon glyphicon-floppy-save"></span> Guardar</button></li>
        <?php
			}
		?>
        <li><button class="btn btn-warning" type="reset" name="limpiar" id="limpiar"><span class="glyphicon glyphicon-trash"></span> Limpiar</button></li>
    </ul>
</div>
<script>
	$(document).ready(function(){
		$('#myWizard').wizard();
        $('select').select2();

		$("#limpiar").click(function(){
			$("#formu").load(base_url()+"index.php/usuarios/datos_de_rol");
		});
	});
</script>