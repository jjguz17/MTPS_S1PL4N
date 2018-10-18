<?php
	$objeto='el <strong>rol</strong>';
	switch($accion_transaccion) {
		case 1: 
			$accion_transaccion="guarda";
			break;
		case 2: 
			$accion_transaccion="actualiza";
			break;
		case 3: 
			$accion_transaccion="elimina";
			break;
	}
	if($estado_transaccion==1) {
		$class='success';
		$mensaje='<span class="glyphicon glyphicon-info-sign"></span> '.ucfirst($objeto).' se ha <strong>'.$accion_transaccion.'do</strong> éxitosamente! Si deseas agregar un rol a un usuario presiona <a href="'.base_url().'index.php/usuarios/usuario" class="alert-link">aquí</a>.';
	}
	else {
		$class='danger';
		$mensaje='<span class="glyphicon glyphicon-exclamation-sign"></span> Error al intentar <strong>'.$accion_transaccion.'r</strong> '.$objeto.': Se perdió la señal de la red. Porfavor vuelva a intentarlo.';
	}
	if($estado_transaccion!="" && $estado_transaccion!=NULL) {	
?>
        <div class="alert alert-<?php echo $class?>">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <?php echo $mensaje?>
        </div>
<?php } ?>
<style type="text/css">
    .list-group-item  {
        text-align: left !important;
        color: #3c763d !important;
    }
    .theme-red a, .theme-red .fc-state-default, .theme-red .jvectormap-zoomin, .theme-red .jvectormap-zoomout, .theme-red #user-profile .profile-details ul>li>span {
        color: inherit;
    }
</style>
<div class="col-lg-6 col-md-6 col-sm-6">
    <div class="main-box clearfix project-box red-box">
        <div class="main-box-body clearfix">
            <div class="project-box-header red-bg">
                <div class="name">
                    <a>Datos del rol</a>
                </div>
            </div>
            <form name="formu" id="formu" class="form-horizontal" method="post" action="<?php echo base_url()?>index.php/usuarios/guardar_rol" autocomplete="off">                  
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
                                        <input type="text" data-req="true" id="nombre_rol" name="nombre_rol" class="form-control"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="descripcion_rol" class="col-sm-3 control-label">Descripción <span class="asterisk">*</span></label>
                                    <div class="col-sm-8">
                                        <textarea class="form-control" data-req="true" id="descripcion_rol" name="descripcion_rol"></textarea>
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
                        <li><button class="btn btn-success" type="submit" name="aprobar" id="aprobar"><span class="glyphicon glyphicon-floppy-save"></span> Guardar</button></li>
                        <li><button class="btn btn-warning" type="reset" name="limpiar" id="limpiar"><span class="glyphicon glyphicon-trash"></span> Limpiar</button></li>
                    </ul>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="col-lg-6 col-md-6 col-sm-6">
    <div class="main-box clearfix project-box red-box">
        <div class="main-box-body clearfix">
            <div class="project-box-header red-bg">
                <div class="name">
                    <a>Roles registrados</a>
                </div>
            </div>
            <div class="project-box-content project-box-content-nopadding">
                <table class="table footable toggle-circle-filled" data-page-size="6" data-filter="#filter" data-filter-text-only="true">
                    <thead>
                      <tr>
                        <th class="all" style="width:200px">Nombre del Rol</th>
                        <th class="none" >Descripción de Rol</th>
                        <th class="desktop tablet-l tablet-p" style="width:100px">Opción</th>
                      </tr>
                     </thead>
                     <tbody>
                        <?php
                            foreach ($roles as $val) {
                        ?>
                            <tr>
                                <td align="left"><?php echo ucwords($val['nombre_rol'])?></td>
                                <td align="left"><?php echo $val['descripcion_rol']?></td>
                                <td>
                                    <a href="" class="modificar_rol" onClick="editar(<?php echo $val['id_rol']?>);return false;" title="Modificar Rol" data-toggle="modal" data-target=".bs-example-modal-static2" data-id_rol="<?php echo $val['id_rol']?>" data-nombre_rol="<?php echo ucwords($val['nombre_rol'])?>"><img src="<?php echo base_url()?>img/rol_editar.png"/></a>
                                    <a data-toggle="modal" href="#modal" class="eliminar_rol" onClick="eliminar(<?php echo $val['id_rol']?>);return false;" title="Eliminar Rol" data-id_rol="<?php echo $val['id_rol']?>" data-nombre_rol="<?php echo ucwords($val['nombre_rol'])?>"><img src="<?php echo base_url()?>img/rol_borrar.png"/></a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="project-box-footer clearfix">
            </div>
            <div class="project-box-ultrafooter clearfix">
            </div>
        </div>
    </div>
</div>
<script language="javascript" >
	$(document).ready(function(){
        $('#myWizard').wizard();
        $('select').select2();
		$('.footable').dataTable({'info': false});
		$("#limpiar").click(function(){
			$("#formu").load(base_url()+"index.php/usuarios/datos_de_rol");
		});
	});
	function editar(id){
		$("#formu").load(base_url()+'index.php/usuarios/datos_de_rol/'+id);
		return false;
	}
	function eliminar(id){
		var titulo="Alerta";
		var mensaje="Realmente desea eliminar este registro? No podrá revertir los cambios.";
		var url="<?=base_url()?>index.php/usuarios/eliminar_rol/"+id;
		confirmacion(titulo, mensaje, url);
		return false;
	}
</script>