<?php
	$objeto='el <strong>usuario</strong>';
	switch($accion_transaccion) {
		case 2: 
			$accion_transaccion="actualiza";
			break;
	}
	if($estado_transaccion==1) {
		$class='success';
		$mensaje='<span class="glyphicon glyphicon-info-sign"></span> '.ucfirst($objeto).' se ha <strong>'.$accion_transaccion.'do</strong> éxitosamente!';
	}
	else {
		$class='danger';
		if($estado_transaccion==2)
			$mensaje='<span class="glyphicon glyphicon-exclamation-sign"></span> Error al intentar <strong>'.$accion_transaccion.'r</strong> '.$objeto.': Se perdió la señal de la red. Porfavor vuelva a intentarlo.';
		else
			if($estado_transaccion==3)
				$mensaje='<span class="glyphicon glyphicon-exclamation-sign"></span> Error al intentar <strong>'.$accion_transaccion.'r</strong> '.$objeto.': La contraseña actual es incorrecta. Porfavor vuelva a intentarlo.';
			else
				$mensaje='<span class="glyphicon glyphicon-exclamation-sign"></span> Error al intentar <strong>'.$accion_transaccion.'r</strong> '.$objeto.': La nueva contraseña no coincide con su replica. Porfavor vuelva a intentarlo.';
	}
	if($estado_transaccion!="" && $estado_transaccion!=NULL) {	
?>
        <div class="alert alert-<?php echo $class?>">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <?php echo $mensaje?>
        </div>
<?php } ?>
<div class="col-sm-3">
</div>
<div class="col-lg-6 col-md-6 col-sm-6">
    <div class="main-box clearfix project-box green-box">
        <div class="main-box-body clearfix">
            <div class="project-box-header green-bg">
                <div class="name">
                    <a>Datos del usuario</a>
                </div>
            </div>               
            <form name="formu" id="formu" class="form-horizontal" method="post" action="<?php echo base_url()?>index.php/usuarios/actualizar_usuario" autocomplete="off">
                <input type="hidden" id="id_documento" name="id_documento">
                <div class="project-box-content project-box-content-nopadding">                    
                    <div id="myWizard" class="wizard">
                        <div class="wizard-inner">
                            <ul class="steps">
                                <li data-target="#step1" class="active"><span class="badge badge-primary">1</span>Datos Generales<span class="chevron"></span></li>
                            </ul>
                            <div class="actions">
                                <button type="button" class="btn btn-default btn-mini btn-prev"> <i class="icon-arrow-left"></i><i class="fa fa-chevron-left"></i></button>
                                <button type="button" class="btn btn-success btn-mini btn-next" data-last="Finish"><i class="fa fa-chevron-right"></i><i class="icon-arrow-right"></i></button>
                            </div>
                        </div>
                        <div class="step-content">
                            <div class="step-pane active" id="step1">
                                <br/>
                                <div class="form-group">
                                <label for="usuario" class="col-sm-4 control-label">Nombre <span class="asterisk">*</span></label>
                                <label for="usuario" class="col-sm-6 control-label" style="text-align: left; text-transform: uppercase;"><strong><?=$usuario['nombre']?></strong></label>
                            </div>
                            <div class="form-group">
                                <label for="usuario" class="col-sm-4 control-label">Sección <span class="asterisk">*</span></label>
                                <label for="usuario" class="col-sm-6 control-label" style="text-align: left; text-transform: uppercase;"><strong><?=$usuario['seccion']?></strong></label>
                            </div>
                            <div class="form-group">
                                <label for="usuario" class="col-sm-4 control-label">Usuario <span class="asterisk">*</span></label>
                                <label for="usuario" class="col-sm-6 control-label" style="text-align: left"><strong><?=$usuario['usuario']?></strong></label>
                            </div>
                            <div class="form-group">
                                <label for="new_password" class="col-sm-4 control-label">Contraseña nueva <span class="asterisk">*</span></label>
                                <div class="col-sm-6">
                                    <input type="password" id="new_password" name="new_password" data-req="true" data-tip="pas" data-min="8" data-max="20"  class="form-control"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="new_password2" class="col-sm-4 control-label">Repita contraseña nueva <span class="asterisk">*</span></label>
                                <div class="col-sm-6">
                                    <input type="password" id="new_password2" name="new_password2" data-req="true" data-tip="pas" data-min="8" data-max="20"  class="form-control"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password" class="col-sm-4 control-label">Contraseña actual <span class="asterisk">*</span></label>
                                <div class="col-sm-6">
                                    <input type="password" id="password" name="password" data-req="true" data-min="8" data-max="20"  class="form-control"/>
                                </div>
                            </div>
                            </div>
                        </div>
                        <!--Aquí estaban los botones-->
                    </div>
                </div>
                <div class="project-box-footer clearfix">
                </div>
                <div class="project-box-ultrafooter clearfix">
                    <ul class="pager wizard">
                        <li><button class="btn btn-info" type="submit" name="actualizar" id="actualizar"><span class="glyphicon glyphicon-floppy-saved"></span> Actualizar</button></li>
                        <li><button class="btn btn-warning" type="reset" name="limpiar" id="limpiar"><span class="glyphicon glyphicon-trash"></span> Limpiar</button></li>
                    </ul>
                </div>
            </form>
        </div>
    </div>
</div>
<script language="javascript" >
	$(document).ready(function(){
		$('#myWizard').wizard();
	});
</script>