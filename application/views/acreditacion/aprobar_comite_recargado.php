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
        <li><a href="#ptab1" data-toggle="tab"> Información General</a></li>
        <li><a href="#ptab2" data-toggle="tab"> Requisitos de conformación</a></li>
        <li><a href="#ptab3" data-toggle="tab"> Miembros del Comité</a></li>
    </ul>
      
    <div class="tab-content">
      
        <div class="progress progress-striped active">
            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
      	
        <div class="tab-pane" id="ptab1">
        	<div class="form-group">
                <label for="fecha_conformacion" class="col-sm-3 control-label">Fecha de aprobación<span class="asterisk">*</span></label>
                <div class="col-sm-4">
                    <div class="input-group">
                        <input type="text" name="fecha_conformacion" id="fecha_conformacion" class="form-control" data-req="true" data-tip="fec" value="<?php echo date('d/m/Y')?>" readonly="readonly"/>
                        <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                    </div>
                </div>
            </div>
            <table class="table table-hover mb30">
                <thead>
                    <tr>
                        <th class="all">Registro</th>
                        <th class="desktop tablet-l tablet-p" style="width:50px">Comité</th>
                        <th class="desktop tablet-l tablet-p" style="width:50px">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Empleados</td>
                        <td align="right"><?=$lugar_trabajo['total_comite']?></td>
                        <td align="right"><?=$lugar_trabajo['total_empleados']?></td>
                    </tr>
                    <tr>
                        <td>Hombres</td>
                        <td align="right"><?=$lugar_trabajo['total_comite_hombres']?></td>
                        <td align="right"><?=$lugar_trabajo['total_empleados_hombres']?></td>
                    </tr>
                    <tr>
                        <td>Mujeres</td>
                        <td align="right"><?=$lugar_trabajo['total_comite_mujeres']?></td>
                        <td align="right"><?=$lugar_trabajo['total_empleados_mujeres']?></td>
                    </tr>
                </tbody>
            </table>
      	</div>
        <div class="tab-pane" id="ptab2">
            <table class="table table-hover mb30">
                <thead>
                    <tr>
                        <th class="all">Requisito</th>
                        <th class="desktop tablet-l tablet-p" style="width:80px">Registrados</th>
                        <th class="desktop tablet-l tablet-p" style="width:80px">Obligatorios</th>
                        <th class="desktop tablet-l tablet-p" style="width:70px">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Miembros del comité</td>
                        <td align="right"><?=$lugar_trabajo['total_comite']?></td>
                        <td align="right"><?php if(isset($id_lugar_trabajo) && $id_lugar_trabajo!="") echo ($lugar_trabajo['total_empleados_representantes']*2)?></td>
                        <td align="center"><?php if(isset($id_lugar_trabajo) && $id_lugar_trabajo!="")if($lugar_trabajo['total_comite']>=($lugar_trabajo['total_empleados_representantes']*2)) echo '<span class="fa fa-check" style="color:#1caf9a;" title="Cumple requisito"></span>'; else echo '<span class="glyphicon glyphicon-remove" style="color:#F00;" title="No cumple requisito"></span>';?></td>
                    </tr>
                    <tr>
                        <td>Representantes de empleador</td>
                        <td align="right"><?=$lugar_trabajo['total_comite_representantes_empleador']?></td>
                        <td align="right"><?=$lugar_trabajo['total_empleados_representantes']?></td>
                        <td align="center"><?php if(isset($id_lugar_trabajo) && $id_lugar_trabajo!="")if($lugar_trabajo['total_comite_representantes_empleador']>=$lugar_trabajo['total_empleados_representantes']) echo '<span class="fa fa-check" style="color:#1caf9a;" title="Cumple requisito"></span>'; else echo '<span class="glyphicon glyphicon-remove" style="color:#F00;" title="No cumple requisito"></span>';?></td>
                    </tr>
                    <tr>
                        <td>Representantes de trabajadores</td>
                        <td align="right"><?php if(isset($id_lugar_trabajo) && $id_lugar_trabajo!="") echo $lugar_trabajo['total_comite_representantes_trabajadores']+$lugar_trabajo['total_comite_sindicato']?></td>
                        <td align="right"><?=$lugar_trabajo['total_empleados_representantes']?></td>
                        <td align="center"><?php if(isset($id_lugar_trabajo) && $id_lugar_trabajo!="")if($lugar_trabajo['total_comite_representantes_trabajadores']+$lugar_trabajo['total_comite_sindicato']>=$lugar_trabajo['total_empleados_representantes']) echo '<span class="fa fa-check" style="color:#1caf9a;" title="Cumple requisito"></span>'; else echo '<span class="glyphicon glyphicon-remove" style="color:#F00;" title="No cumple requisito"></span>';?></td>
                    </tr>
                    <tr>
                        <td>Delegados de prevención</td>
                        <td align="right"><?=$lugar_trabajo['total_comite_delegados']?></td>
                        <td align="right"><?=$lugar_trabajo['total_empleados_delegados']?></td>
                        <td align="center"><?php if(isset($id_lugar_trabajo) && $id_lugar_trabajo!="")if($lugar_trabajo['total_comite_delegados']>=$lugar_trabajo['total_empleados_delegados']) echo '<span class="fa fa-check" style="color:#1caf9a;" title="Cumple requisito"></span>'; else echo '<span class="glyphicon glyphicon-remove" style="color:#F00;" title="No cumple requisito"></span>';?></td>
                    </tr>
                    <tr>
                        <td>Miembros del sindicato</td>
                        <td align="right"><?=$lugar_trabajo['total_comite_sindicato']?></td>
                        <td align="right"><?php if(isset($id_lugar_trabajo) && $id_lugar_trabajo!="") echo $lugar_trabajo['sindicato'];?></td>
                        <td align="center"><?php if(isset($id_lugar_trabajo) && $id_lugar_trabajo!="")if($lugar_trabajo['total_comite_sindicato']>=$lugar_trabajo['sindicato']) echo '<span class="fa fa-check" style="color:#1caf9a;" title="Cumple requisito"></span>'; else echo '<span class="glyphicon glyphicon-remove" style="color:#F00;" title="No cumple requisito"></span>';?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="tab-pane" id="ptab3">
            <!--<div class="form-group">
                <label for="nombre_empleado" class="col-sm-4 control-label">Fecha de conformación<span class="asterisk">*</span></label>
                <div class="col-sm-2 control-label">
                    <strong><?php if($ins['fecha_conformacion']!="") echo $ins['fecha_conformacion'];?></strong>
                </div>
            </div>-->
            <table class="table table-hover mb30">
                <thead>
                    <tr>
                        <th class="all">Nombre del empleado</th>
                        <th class="desktop tablet-l tablet-p" style="width:200px">Cargo Comité</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach($empleado_lugar_trabajo as $val) {
                            echo '<tr>
                                    <td>'.$val['nombre'].'</td>
                                    <td>
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <select data-req="true" class="form-control" name="id_cargo_comite[]" id="id_cargo_comite'.$val['id'].'" data-placeholder="[Seleccione..]" ><option value=""></option>';
							foreach($cargo_comite as $val2) {
								echo '              <option value="'.$val['id'].'***'.$val2['id'].'" selected="selected">'.$val2['nombre'].'</option>';
							}
                            echo '              </select>
                                            </div>
                                        </div>
                                    </td>
                                </tr>';
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div><!-- tab-content -->
    <ul class="pager wizard">
        <li><button class="btn btn-success" type="submit" name="guardar" id="guardar"><span class="fa fa-check"></span> Aprobar</button></li>
        <li><button class="btn btn-warning" type="reset" name="limpiar" id="limpiar"><span class="glyphicon glyphicon-trash"></span> Limpiar</button></li>
    
    </ul>
</div><!-- #basicWizard -->
<script language="javascript" >
	$(document).ready(function(){		
		$('.table').DataTable({
		  "filter": false,
		  "paginate": false,
		  "destroy": true,
		  responsive: true,
		  sort: false,
		  info: false
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
		$('#fecha_conformacion').datepicker({beforeShowDay: $.datepicker.noWeekends, maxDate: '0D'});
		$("#limpiar").click(function(){
			$("#formu").load(base_url()+"index.php/acreditacion/aprobar_comite_recargado");
		})
	});
</script>