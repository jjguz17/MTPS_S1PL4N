<?php
	$objeto='la <strong> aprobación del comité</strong>';
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
		$mensaje='<span class="glyphicon glyphicon-info-sign"></span> '.ucfirst($objeto).' se ha <strong>'.$accion_transaccion.'do</strong> éxitosamente!';
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
<style>
	.ckbox input[type="checkbox"]:checked + label::after {
		top: 3px;
	}
</style>
<div class="col-sm-6">
	<div class="panel panel-primary">
		<div class="panel-heading">
        <div class="panel-btns">
        	<a href="#" class="tooltips ayuda" data-ayuda="13" data-toggle="tooltip" title="" data-original-title="Ayuda"><i class="fa fa-question-circle"></i></a>
        	<a href="#"class="tooltips minimize" data-toggle="tooltip" title="" data-original-title="Minimizar">−</a>
        </div><!-- panel-btns -->
        	<h3 class="panel-title">Datos del comité</h3>
        </div>
        <div class="panel-body panel-body-nopadding">
        	<form class="form-horizontal" name="formu" id="formu" method="post" action="<?php echo base_url()?>index.php/acreditacion/guardar_aprobacion_comite" autocomplete="off">
                <div id="progressWizard" class="basic-wizard">
                    
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
                                        <td align="right"></td>
                                        <td align="right"></td>
                                    </tr>
                                    <tr>
                                        <td>Hombres</td>
                                        <td align="right"></td>
                                        <td align="right"></td>
                                    </tr>
                                    <tr>
                                        <td>Mujeres</td>
                                        <td align="right"></td>
                                        <td align="right"></td>
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
                                        <td align="right"></td>
                                        <td align="right"></td>
                                        <td align="center"></td>
                                    </tr>
                                    <tr>
                                        <td>Representantes de empleador</td>
                                        <td align="right"></td>
                                        <td align="right"></td>
                                        <td align="center"></td>
                                    </tr>
                                    <tr>
                                        <td>Representantes de trabajadores</td>
                                        <td align="right"></td>
                                        <td align="right"></td>
                                        <td align="center"></td>
                                    </tr>
                                    <tr>
                                        <td>Delegados de prevención</td>
                                        <td align="right"></td>
                                        <td align="right"></td>
                                        <td align="center"></td>
                                    </tr>
                                    <tr>
                                        <td>Miembros del sindicato</td>
                                        <td align="right"></td>
                                        <td align="right"></td>
                                        <td align="center"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                  		<div class="tab-pane" id="ptab3">
                            <!--<div class="form-group">
                                <label for="nombre_empleado" class="col-sm-4 control-label">Fecha de conformación<span class="asterisk">*</span></label>
                                <div class="col-sm-4">
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
                                </tbody>
                            </table>
                        </div>
                   	</div><!-- tab-content -->
                    
                    <ul class="pager wizard">
                        <li><button class="btn btn-success" type="submit" name="guardar" id="guardar"><span class="fa fa-check"></span> Aprobar</button></li>
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
        	<a href="#" class="tooltips ayuda" data-ayuda="14" data-toggle="tooltip" title="" data-original-title="Ayuda"><i class="fa fa-question-circle"></i></a>
        	<a href="#"class="tooltips minimize" data-toggle="tooltip" title="" data-original-title="Minimizar">−</a>
        </div><!-- panel-btns -->
        	<h3 class="panel-title" id="titulo-tabla">Comités resgistrados</h3>
        </div>
        <div class="panel-body" id="contenido-tabla">
            <table class="table table-hover mb30">
                <thead>
                    <tr>
                        <th class="all">Lugar de trabajo</th>
                        <th class="desktop tablet-l tablet-p" style="width:100px">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach($insticion_lugar_trabajo as $val) {
                            echo '<tr><td>'.$val['nombre'].'</td><td><a href="#" onClick="editar('.$val['id'].');return false;" class="edit-row" data-id="'.$val['id'].'"><i class="fa fa-search"></i></a></td></tr>';
                        }
                    ?>
                </tbody>
            </table>
        </div>
  	</div>
</div>
<script language="javascript" >
	$(document).ready(function(){		
		$('#formu .table').DataTable({
		  "filter": false,
		  "paginate": false,
		  "destroy": true,
		  responsive: true,
		  sort: false,
		  info: false
		});
		$('#fecha_conformacion').datepicker({beforeShowDay: $.datepicker.noWeekends, maxDate: '0D'});
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
			$("#formu").load(base_url()+"index.php/acreditacion/aprobar_comite_recargado");
		});
	});
	function editar(id){
		$("#formu").load(base_url()+"index.php/acreditacion/aprobar_comite_recargado/"+id);
		return false;
	}
</script>