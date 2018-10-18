<div id="progressWizard" class="basic-wizard">
    <?php
		if(isset($institucion['id']) && $institucion['id']!="") {
	?>
			<input type="hidden" name="id_institucion" id="id_institucion" class="form-control"  value="<?php echo $institucion['id_institucion'] ?>" />
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
                <label for="nombre_institucion" class="col-sm-3 control-label">Razón Social <span class="asterisk">*</span></label>
                <div class="col-sm-8">
                    <input type="text" data-req="true" data-tip="x" data-min="5" name="nombre_institucion" id="nombre_institucion" class="form-control" value="<?php echo $institucion['nombre'] ?>" />
                </div>
            </div>
          
            <div class="form-group">
                <label for="nit_empleador" class="col-sm-3 control-label">NIT del empleador <span class="asterisk">*</span></label>
                <div class="col-sm-5">
                    <input type="text" data-req="true" data-tip="nit" name="nit_empleador" id="nit_empleador" class="form-control" value="<?php echo $institucion['nit_empleador'] ?>"  placeholder="#### - ###### - ### - #" maxlength="17"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">&nbsp;</label>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">&nbsp;</label>
            </div>
        </div>
        <div class="tab-pane" id="ptab2">
            <div class="form-group">
                <label for="nombre_representante" class="col-sm-3 control-label">Nombre del representante legal </label>
                <div class="col-sm-8">
                    <input type="text" name="nombre_representante" id="nombre_representante" class="form-control" value="<?php echo $institucion['nombre_representante'] ?>" />
                </div>
            </div>
    
            <div class="form-group">
                <label for="id_clasificacion" class="col-sm-3 control-label">Clasificación CIIU</label>
                <div class="col-sm-8">
                    <select class="form-control" name="id_clasificacion" id="id_clasificacion" data-placeholder="[Seleccione..]">
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
                <label for="id_sector" class="col-sm-3 control-label">Sector</label>
                <div class="col-sm-4">
                    <select class="form-control" name="id_sector" id="id_sector" data-placeholder="[Seleccione..]">
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
      </div>   
      
    
    </div><!-- tab-content -->
    
    <ul class="pager wizard">
    	<?php
			if(isset($institucion['id']) && $institucion['id']!="") {
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
			$("#formu").load(base_url()+"index.php/promocion/general_recargado");
		});
		$("select").chosen({
			'width': '100%',
			'min-width': '100px',
			'white-space': 'nowrap',
			no_results_text: "Sin resultados!"
		});
	});
</script>