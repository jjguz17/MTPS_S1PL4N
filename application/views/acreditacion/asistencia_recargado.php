<style>
	.ckbox input[type="checkbox"]:checked + label::after {
		top: 3px;
	}
</style>
<div id="progressWizard" class="basic-wizard">
	<?php
        if(isset($capacitacion[0]['id_capacitacion']) && $capacitacion[0]['id_capacitacion']!="") {
    ?>
            <input type="hidden" name="id_capacitacion" id="id_capacitacion" class="form-control"  value="<?php echo $id_capacitacion ?>" />
    <?php
        }
    ?>
    <ul class="nav nav-pills nav-justified">
        <li><a href="#ptab1" data-toggle="tab"><span>Paso 1:</span> Empleados Registrados en Capacitación</a></li>
    </ul>
      
    <div class="tab-content">
      
        <div class="progress progress-striped active">
            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
      
        <div class="tab-pane" id="ptab1">
            <table id="empleados" class="table table-hover mb30">
                    <thead>
                        <tr>
                            <th class="all">Nombre del empleado</th>
                            <th class="desktop tablet-l tablet-p" style="width:100px">Asistió</th>
                        </tr>
                    </thead>
                    <tbody>
                    	<?php
							
                            foreach($capacitacion as $val) {
                                $id=$val['id_empleado_institucion'];
                            	$ids[$id]=1;
							}
                            foreach($capacitacion as $val) {
                                $id=$val['id_empleado_institucion'];
								if($ids[$id]==1) {
                                	echo '<tr><td class="fila">'.$val['nombre_empleado'].'</td><td><!--<a href="#" class="edit-row" onClick="editar_empleado('.$val['id_empleado_institucion'].');return false;" data-id="'.$val['id_empleado_institucion'].'"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;--><div class="ckbox ckbox-success"><input type="checkbox" class="chk" name="id_empleado_ck[]" id="id_empleado_ck_'.$val['id_empleado_institucion'].'" value="'.$val['id_empleado_institucion'].'***1" /><label for="id_empleado_ck_'.$val['id_empleado_institucion'].'"></label></div></td></tr>';
									$ids[$id]=0;
								}
							}
                        ?>
                    </tbody>
                </table>
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
		  "filter": false,
		  "paginate": false,
		  "destroy": true,
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
		$("#limpiar").click(function(){
			$("#formu").load(base_url()+"index.php/acreditacion/asistencia_recargado");
		});
		$('.fila').click(function(){
			var $fil=$(this).parent("tr"); 
			var $chk=$fil.find(".chk");
			$chk.click();
		});
	});
</script>