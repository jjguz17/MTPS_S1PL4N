<?php
	$objeto='el <strong>lugar de trabajo</strong>';
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
		$mensaje='<span class="glyphicon glyphicon-info-sign"></span> '.ucfirst($objeto).' se ha <strong>'.$accion_transaccion.'do</strong> éxitosamente! Si deseas asignar un técnico a un lugar de trabajo presiona <a href="'.base_url().'index.php/promocion/programa" class="alert-link">aquí</a>.';
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
<div class="col-sm-6">
	<div class="panel panel-primary">
		<div class="panel-heading">
        <div class="panel-btns">
        	<a href="#" class="tooltips ayuda" data-ayuda="3" data-toggle="tooltip" title="" data-original-title="Ayuda"><i class="fa fa-question-circle"></i></a>
        	<a href="#"class="tooltips minimize" data-toggle="tooltip" title="" data-original-title="Minimizar">−</a>
        </div><!-- panel-btns -->
        	<h3 class="panel-title">Datos del lugar de trabajo</h3>
        </div>
        <div class="panel-body panel-body-nopadding">
        	<form class="form-horizontal" name="formu" id="formu" method="post" action="<?php echo base_url()?>index.php/promocion/guardar_lugar_trabajo" autocomplete="off">
                <div id="progressWizard" class="basic-wizard">
                    
                    <ul class="nav nav-pills nav-justified">
                        <li><a href="#ptab1" data-toggle="tab"><span>Paso 1:</span> Información General</a></li>
                        <li><a href="#ptab2" data-toggle="tab"><span>Paso 2:</span> Información Complementaria</a></li>
                    </ul>
                      
                    <div class="tab-content">
                      
                      	<div class="progress progress-striped active">
                        	<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"></div>
                      	</div>
                      
                  		<div class="tab-pane" id="ptab1">
                            <div class="form-group">
                                <label for="id_institucion" class="col-sm-3 control-label">Empleador <span class="asterisk">*</span></label>
                                <div class="col-sm-7">
                                    <select data-req="true" class="form-control" name="id_institucion" id="id_institucion" data-placeholder="[Seleccione..]" >
                                        <option value=""></option>
                                        <?php
                                            foreach($institucion as $val) {
                                                echo '<option value="'.$val['id'].'">'.$val['nombre'].'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="id_tipo_lugar_trabajo" class="col-sm-3 control-label">Tipo de lugar de trabajo <span class="asterisk">*</span></label>
                                <div class="col-sm-4">
                                    <select data-req="true" class="form-control" name="id_tipo_lugar_trabajo" id="id_tipo_lugar_trabajo" data-placeholder="[Seleccione..]" >
                                        <option value=""></option>
                                        <?php
                                            foreach($tipo_lugar_trabajo as $val) {
                                                echo '<option value="'.$val['id'].'">'.$val['nombre'].'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="nombre_lugar" class="col-sm-3 control-label">Nombre lugar de trabajo <span class="asterisk">*</span></label>
                                <div class="col-sm-7">
                                    <input type="text" name="nombre_lugar" id="nombre_lugar" class="form-control" data-req="true" data-tip="x" data-min="5" />
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="direccion_lugar" class="col-sm-3 control-label">Dirección <span class="asterisk">*</span></label>
                                <div class="col-sm-7">
                                    <textarea data-req="true" data-tip="x" data-min="10" class="form-control" id="direccion_lugar" tabindex="2" name="direccion_lugar" ></textarea>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="id_municipio" class="col-sm-3 control-label">Municipio <span class="asterisk">*</span></label>
                                <div class="col-sm-6">
                                    <select data-req="true" class="form-control" name="id_municipio" id="id_municipio" data-placeholder="[Seleccione..]" >
                                        <option value=""></option>
                                        <?php
                                            foreach($municipio as $val) {
                                                echo '<option value="'.$val['id'].'">'.$val['nombre'].'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                		<div class="tab-pane" id="ptab2">
                        	<div class="form-group">
                                <label for="nombre_contacto" class="col-sm-3 control-label">Nombre contacto</label>
                                <div class="col-sm-7">
                                    <input type="text" name="nombre_contacto" id="nombre_contacto" class="form-control" />
                                </div>
                            </div>
                        	
                        	<div class="form-group">
                                <label for="telefono" class="col-sm-3 control-label">Teléfono contacto</label>
                                <div class="col-sm-3">
                                    <input type="tel" name="telefono" id="telefono" class="form-control" data-tip="tel" placeholder="#### ####"  maxlength="8" />
                                </div>
                            </div>
                        	
                        	<div class="form-group">
                                <label for="correo" class="col-sm-3 control-label">Correo contacto</label>
                                <div class="col-sm-7">
                                    <input type="text" name="correo" id="correo" class="form-control" data-tip="cor" />
                                </div>
                            </div>
                        	
                        	<div class="form-group">
                                <label for="total_hombres" class="col-sm-3 control-label">Total hombres</label>
                                <div class="col-sm-3">
                                    <input type="number" name="total_hombres" id="total_hombres" class="form-control" data-tip="int" data-min="0"/>
                                </div>
                            </div>
                        	
                        	<div class="form-group">
                                <label for="total_mujeres" class="col-sm-3 control-label">Total Mujeres</label>
                                <div class="col-sm-3">
                                    <input type="number" name="total_mujeres" id="total_mujeres" class="form-control" data-tip="int" data-min="0" />
                                </div>
                            </div>
                        </div>
                   	</div><!-- tab-content -->
                    
                    <ul class="pager wizard">
                        <li><button class="btn btn-success" type="submit" name="guardar" id="guardar"><span class="glyphicon glyphicon-floppy-save"></span> Guardar</button></li>
                        <li><button class="btn btn-warning" type="reset" name="limpiar" id="limpiar"><span class="glyphicon glyphicon-trash"></span> Limpiar</button></li>
              		
                    </ul>
                </div><!-- #basicWizard -->
 			</form> 
      	</div>
    </div><!-- panel -->
</div>
<div class="col-sm-6">
	<div class="panel panel-primary">
		<div class="panel-heading">
        <div class="panel-btns">
        	<a href="#" class="tooltips ayuda" data-ayuda="4" data-toggle="tooltip" title="" data-original-title="Ayuda"><i class="fa fa-question-circle"></i></a>
        	<a href="#"class="tooltips minimize" data-toggle="tooltip" title="" data-original-title="Minimizar">−</a>
        </div><!-- panel-btns -->
        	<h3 class="panel-title" id="titulo-tabla">Lugares de trabajo registrados</h3>
        </div>
        <div class="panel-body" id="contenido-tabla">
          		<table class="table table-hover mb30">
            		<thead>
              			<tr>
                            <th class="all">Nombre lugar de trabajo</th>
                            <th class="desktop tablet-l tablet-p" style="width:100px">Acción</th>
              			</tr>
            		</thead>
            		<tbody>
            		</tbody>
          		</table>
        </div>
  	</div>
</div>
<script language="javascript" >
	$(document).ready(function(){	
	  	$('#progressWizard').bootstrapWizard({
			'nextSelector': '.next',
			'previousSelector': '.previous',
			onNext: function(tab, navigation, index) {
		  		var $total = navigation.find('li').length;
		  		var $current = index+1;
		  		var $percent = ($current/$total) * 100;
		  		$('#progressWizard').find('.progress-bar').css('width', $percent+'%');
			},
			onPrevious: function(tab, navigation, index) {
		  		var $total = navigation.find('li').length;
		  		var $current = index+1;
		  		var $percent = ($current/$total) * 100;
		  		$('#progressWizard').find('.progress-bar').css('width', $percent+'%');
			},
			onTabShow: function(tab, navigation, index) {
		  		var $total = navigation.find('li').length;
		  		var $current = index+1;
		  		var $percent = ($current/$total) * 100;
		  		$('#progressWizard').find('.progress-bar').css('width', $percent+'%');
			}
	  	});	
		$("#limpiar").click(function(){
			$("#formu").load(base_url()+"index.php/promocion/lugares_trabajo_recargado");
			$('#contenido-tabla').load(base_url()+'index.php/promocion/lugares_trabajo_empresa/0');
		});
		$('#id_institucion').change(function(){
			id=$(this).val();
			$('#contenido-tabla').load(base_url()+'index.php/promocion/lugares_trabajo_empresa/'+id);
		});
	});
</script>