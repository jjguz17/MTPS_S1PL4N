<div id="progressWizard" class="basic-wizard">
    <?php
		if(isset($lugar_trabajo['id']) && $lugar_trabajo['id']!="") {
	?>
			<input type="hidden" name="id_lugar_trabajo" id="id_lugar_trabajo" class="form-control"  value="<?php echo $lugar_trabajo['id_lugar_trabajo'] ?>" />
	<?php
		}
	?>  
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
								if($lugar_trabajo['id_institucion']==$val['id'])
                                	echo '<option value="'.$val['id'].'" selected>'.$val['nombre'].'</option>';
								else
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
                                if($lugar_trabajo['id_tipo_lugar_trabajo']==$val['id'])
                                	echo '<option value="'.$val['id'].'" selected>'.$val['nombre'].'</option>';
								else
                                	echo '<option value="'.$val['id'].'">'.$val['nombre'].'</option>';
                            }
                        ?>
                    </select>
                </div>
            </div>
            
            <div class="form-group">
                <label for="nombre_lugar" class="col-sm-3 control-label">Nombre lugar de trabajo <span class="asterisk">*</span></label>
                <div class="col-sm-7">
                    <input data-req="true" data-tip="x" data-min="5" type="text" name="nombre_lugar" id="nombre_lugar" class="form-control" value="<?php echo $lugar_trabajo['nombre']?>" />
                </div>
            </div>
            
            <div class="form-group">
                <label for="direccion_lugar" class="col-sm-3 control-label">Dirección <span class="asterisk">*</span></label>
                <div class="col-sm-7">
                    <textarea data-req="true" data-tip="x" data-min="10" class="form-control" id="direccion_lugar" tabindex="2" name="direccion_lugar" ><?php echo $lugar_trabajo['direccion_lugar']?></textarea>
                </div>
            </div>
            
            <div class="form-group">
                <label for="id_municipio" class="col-sm-3 control-label">Municipio <span class="asterisk">*</span></label>
                <div class="col-sm-6">
                    <select data-req="true" class="form-control" name="id_municipio" id="id_municipio" data-placeholder="[Seleccione..]" >
                        <option value=""></option>
                        <?php
                            foreach($municipio as $val) {
                                if($lugar_trabajo['id_municipio']==$val['id'])
                                	echo '<option value="'.$val['id'].'" selected>'.$val['nombre'].'</option>';
								else	
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
                    <input type="text" name="nombre_contacto" id="nombre_contacto" class="form-control" value="<?php echo $lugar_trabajo['nombre_contacto']?>" />
                </div>
            </div>
            
            <div class="form-group">
                <label for="telefono" class="col-sm-3 control-label">Teléfono contacto</label>
                <div class="col-sm-3">
                    <input type="tel" name="telefono" id="telefono" class="form-control" value="<?php echo $lugar_trabajo['telefono']?>" data-tip="tel" placeholder="#### ####"  maxlength="8"/>
                </div>
            </div>
            
            <div class="form-group">
                <label for="correo" class="col-sm-3 control-label">Correo contacto</label>
                <div class="col-sm-7">
                    <input type="text" name="correo" id="correo" class="form-control" data-tip="cor" value="<?php echo $lugar_trabajo['correo']?>" />
                </div>
            </div>
            
            <div class="form-group">
                <label for="total_hombres" class="col-sm-3 control-label">Total hombres</label>
                <div class="col-sm-3">
                    <input type="number" name="total_hombres" id="total_hombres" class="form-control" value="<?php if($lugar_trabajo['id_lugar_trabajo']=="")echo ''; else echo $lugar_trabajo['total_hombres'];?>" />
                </div>
            </div>
            
            <div class="form-group">
                <label for="total_mujeres" class="col-sm-3 control-label">Total Mujeres</label>
                <div class="col-sm-3">
                    <input type="number" name="total_mujeres" id="total_mujeres" class="form-control" value="<?php if($lugar_trabajo['id_lugar_trabajo']=="")echo ''; else echo $lugar_trabajo['total_mujeres'];?>" />
                </div>
            </div>
        </div>
    </div><!-- tab-content -->
    
    <ul class="pager wizard">
        <?php
			if(isset($lugar_trabajo['id_lugar_trabajo']) && $lugar_trabajo['id_lugar_trabajo']!="") {
		?>
				<li><button class="btn btn-primary" type="submit" name="actualizar" id="actualizar"><span class="glyphicon glyphicon-floppy-saved"></span> Actualizar</button></li>
        <?php
			}
			else {
		?>
        		<li><button class="btn btn-success" type="submit" name="guardar" id="guardar"><span class="glyphicon glyphicon-floppy-save"></span> Guardar</button></li>
		<?php
			}
		?>
        <li><button class="btn btn-warning" type="reset" name="limpiar" id="limpiar"><span class="glyphicon glyphicon-trash"></span> Limpiar</button></li>
    
    </ul>
</div><!-- #basicWizard -->
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
		$("select").chosen({
			'width': '100%',
			'min-width': '100px',
			'white-space': 'nowrap',
			no_results_text: "Sin resultados!"
		});
	});
</script>