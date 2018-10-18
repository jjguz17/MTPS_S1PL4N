<style>
	.ckbox input[type="checkbox"]:checked + label::after {
		top: 3px;
	}
</style>
<div id="progressWizard" class="basic-wizard">
    <?php
        if(isset($id_lugar_trabajo) && $id_lugar_trabajo!="") {
    ?>
            <input type="hidden" name="id_lugar_trabajo" id="id_lugar_trabajo" class="form-control"  value="<?php echo $ilt ?>" />
    <?php
        }
    ?>
    <ul class="nav nav-pills nav-justified">
        <li><a href="#ptab1" data-toggle="tab"><span>Paso 1:</span> Información General</a></li>
    </ul>
      
    <div class="tab-content">
      
        <div class="progress progress-striped active">
            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
      
        <div class="tab-pane" id="ptab1">
            <div class="form-group">
                <label for="nombre_empleado" class="col-sm-4 control-label">Fecha de conformación<span class="asterisk">*</span></label>
                <div class="col-sm-4">
                    <div class="input-group">
                        <input type="text" name="fecha_conformacion" id="fecha_conformacion" class="form-control" data-req="true" data-tip="fec" value="<?php if($ins['fecha_conformacion']!="") echo $ins['fecha_conformacion']; else echo date('d/m/Y')?>" readonly="readonly"/>
                        <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <table class="table table-hover mb30">
                    <thead>
                        <tr>
                            <th class="all">Nombre del empleado</th>
                            <th class="desktop tablet-l tablet-p" style="width:100px">Delegado</th>
                            <th class="desktop tablet-l tablet-p" style="width:100px">Sindicato</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach($empleado_lugar_trabajo as $val) {
                                echo '<tr><td>'.$val['nombre'].'</td><td><div class="ckbox ckbox-success"><input type="checkbox" class="chk" name="id_empleado_ck_del[]" id="id_empleado_ck_del_'.$val['id'].'" value="'.$val['id'].'" ';
								if($val['delegado']==1) echo ' checked="checked"';
								echo' /><label for="id_empleado_ck_del_'.$val['id'].'"></label></div></td><td><div class="ckbox ckbox-success"><input type="checkbox" class="chk" name="id_empleado_ck_sin[]" id="id_empleado_ck_sin_'.$val['id'].'" value="'.$val['id'].'" ';
								if($val['sindicato']==1) echo ' checked="checked"';
								echo' /><label for="id_empleado_ck_sin_'.$val['id'].'"></label></div></td></tr>';
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div><!-- tab-content -->
    <ul class="pager wizard">
        <li><button class="btn btn-success" type="submit" name="guardar" id="guardar"><span class="glyphicon glyphicon-floppy-save"></span> Guardar</button></li>
        <li><button class="btn btn-warning" type="reset" name="limpiar" id="limpiar"><span class="glyphicon glyphicon-trash"></span> Limpiar</button></li>
    
    </ul>
</div><!-- #basicWizard -->
<script language="javascript" >
	$(document).ready(function(){		
		$('.table').DataTable({
		"sPaginationType": "simple",
		responsive: true
		});
		$("select").chosen({
			'width': '100%',
			'min-width': '100px',
			'white-space': 'nowrap',
			no_results_text: "Sin resultados!",
			max_selected_options: 2
		});
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
		$('#fecha_conformacion').datepicker({beforeShowDay: $.datepicker.noWeekends, minDate: '0D'});
		$("#limpiar").click(function(){
			$("#formu").load(base_url()+"index.php/acreditacion/registrar_comite_recargado");
		})
	});
	function editar(id){
		$("#formu").load(base_url()+"index.php/acreditacion/registrar_comite_recargado/"+id);
		return false;
	}
</script>