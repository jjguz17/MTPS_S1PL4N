<style>
	.table a.table-link {margin: 0;}
</style>
<div class="wizard" id="wizard-demo">
	<h1>Crear PEI</h1>
    <?php
		$band=-1;
		foreach($estructura as $val) {
			if($band==-1) {
				$band=$val['id_nivel'];
			}
	?>	
    		<div class="wizard-card" data-cardname="name_<?=$val['id_nivel']?>">
            	<form id="name_<?=$val['id_nivel']?>" data-change="0">
                    <h3 style="margin-top: 0 !important;" data-id_nivel="<?=$val['id_nivel']?>"><span><?=$val['nombre_nivel']?></span></h3>
                    <div class="wizard-input-section">
                        <div class="form-group">
                            <input type="hidden" class="form-control id_nivel" id="id_nivel_<?=$val['id_nivel']?>" name="id_nivel" value="<?=$val['id_nivel']?>"/>
                        </div>
                    </div>
					<?php
						if($val['id_padre']!="") {
							//$items=$this->pei_model->buscar_items('NULL', $val['id_padre'], 'NULL');
							/*Buscar en tabla pat_item todos los registros que tengan id_nivel=$val['id_padre'] y ponerlos en un <select name="id_padre_<?=$val['id_nivel']?>">*/
					?>	
                            <div class="wizard-input-section">
                                <div class="form-group">
                                    <label for="id_padre_<?=$val['id_nivel']?>" style="text-transform: capitalize;"><?=$nom_padre?></label>
                                    <select class="form-control select" name="id_padre_<?=$val['id_nivel']?>" id="id_padre_<?=$val['id_nivel']?>" data-placeholder="[Seleccione..]" style="max-width: 150px;display: block;">
                                        <option value=""></option>
                                        <?php
                                            foreach($items as $val2) {
                                                if($val2['id_nivel']==$val['id_padre'])
                                                echo '<option value="'.$val2['id_item'].'">'.$val2['correlativo_item'].'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <script type="text/javascript">
                                $(function() {		
                                    $("#id_padre_<?=$val['id_nivel']?>").select2({
										placeholder: "[Seleccione...]",
										allowClear: true
									});									

									$('#id_padre_<?=$val['id_nivel']?>').change(function(){
										var t=$("#name_<?=$val['id_nivel']?> #tabla_<?=$val['id_nivel']?> tr").length;
										var s="";
										var a="<?=$val['abreviacion']?>";
										if($('#agregar_separador_<?=$val['id_nivel']?>').is(':checked')) {
											s="-";
										}
										if ($(this).val()!="") {
											if($('#agrupar_numeracion_<?=$val['id_nivel']?>').is(':checked')) {
												t=$("#tabla_<?=$val['id_nivel']?> td:contains('"+$(this).select2('data').text+"')").length+1;
											}
										}
										count_<?=$val['id_nivel']?>=t;
										$('#correlativo_item_<?=$val['id_nivel']?>').val(a+s+count_<?=$val['id_nivel']?>);
									});

									$('#agrupar_numeracion_<?=$val['id_nivel']?>').click(function(){
										var $form=$(this).parents('form');											
										$form.data("change",1);
										$('#id_padre_<?=$val['id_nivel']?>').change();
									});	
                                });
                            </script>
					<?php
						}
						else {
					?>	
             				<input type="hidden" id="id_padre_<?=$val['id_nivel']?>" name="id_padre_<?=$val['id_nivel']?>" value="NULL"/>
    				<?php
						}
					?>	
                    <div class="wizard-input-section">
                        <div class="form-group">
                        	<div class="form-group">
                                <label for="correlativo_item_<?=$val['id_nivel']?>" style="display: block;">Código </label>
                                <div class="input-group">
                                    <input type="text" style="width: 150px;display: inline-block;" class="form-control" id="correlativo_item_<?=$val['id_nivel']?>" name="correlativo_item_<?=$val['id_nivel']?>">
                                        <style type="text/css">
                                            .radio, .checkbox {
                                                margin-top: 0px;
                                                margin-bottom: 0px;
                                            }
                                            .input-group-btn {
                                                float: left;
                                            }
											.dropdown-menu>li>a {
												padding-left: 10px;
											}
                                        </style>
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Acciones <span class="caret"></span></button>
                                            <ul class="dropdown-menu">  
												<?php
                                                    if($val['id_padre']!="") {
                                                ?>	                                  
                                                    <li>
                                                        <a href="javascript:;">  
                                                            <div class="checkbox-nice" style="display: inline-block;">
                                                                <input type="checkbox" id="agrupar_numeracion_<?=$val['id_nivel']?>" name="agrupar_numeracion_<?=$val['id_nivel']?>" <?=$val['agrupar_numeracion']?> value="1" />
                                                                <label for="agrupar_numeracion_<?=$val['id_nivel']?>" >Agrupar numeración por <?=$nom_padre?></label>
                                                            </div>
                                                        </a>
                                                    </li>
                                               	<?php
													}
												?>	
                                                <li>
                                                    <a href="javascript:;">  
                                                        <div class="checkbox-nice" style="display: inline-block;">
                                                            <input type="checkbox" id="agregar_separador_<?=$val['id_nivel']?>" name="agregar_separador_<?=$val['id_nivel']?>" <?=$val['agregar_separador']?> value="1" />
                                                            <label for="agregar_separador_<?=$val['id_nivel']?>" >Agregar guión medio al código</label>
                                                        </div>
                                                    </a>
                                                </li>
                                                <!--<li>
                                                    <a href="javascript:;">
                                                        <div class="radio">
                                                            <input type="radio" name="optionsRadios2" id="optionsRadios11" value="." checked>
                                                            <label for="optionsRadios11">
                                                                Usar punto como separador
                                                            </label>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;">
                                                        <div class="radio">
                                                            <input type="radio" name="optionsRadios2" id="optionsRadios12" value="-">
                                                            <label for="optionsRadios12">
                                                               	Usar guión medio como separador
                                                            </label>
                                                        </div>
                                                    </a>
                                                </li>-->
                                            </ul>
                                        </div> 
                                    <?php
                                        if($val['id_padre']=="") {
                                    ?>	
                                            <input type="hidden" id="agrupar_numeracion_<?=$val['id_nivel']?>" name="agrupar_numeracion_<?=$val['id_nivel']?>" value="1"/>
                                    <?php
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="wizard-input-section">
                        <div class="form-group">
                            <label for="descripcion_item_<?=$val['id_nivel']?>">Descripción </label>
                            <textarea class="form-control descripcion" id="descripcion_item_<?=$val['id_nivel']?>" name="descripcion_item_<?=$val['id_nivel']?>"></textarea>
                        </div>
                    </div>
                    <div class="wizard-input-section">
                        <div class="form-group">
                            <label for="id_seccion_<?=$val['id_nivel']?>" style="text-transform: capitalize;">Unidad responsable</label>
                            <select class="form-control select" name="id_seccion_<?=$val['id_nivel']?>" id="id_seccion_<?=$val['id_nivel']?>" data-placeholder="[Seleccione..]" style="max-width: 100%;display: block;">
                                <option value=""></option>
                                <?php
                                    foreach($seccion as $val2) {
                                        echo '<option value="'.$val2['id_seccion'].'">'.$val2['nombre_seccion'].'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="wizard-input-section">
                        <div class="form-group">
                            <button class="btn btn-success" type="button" name="agregar_<?=$val['id_nivel']?>" id="agregar_<?=$val['id_nivel']?>"><span class="fa fa-plus"></span> Agregar</button>
                            <button class="btn btn-info noVer" type="button" name="actualizar_<?=$val['id_nivel']?>" id="actualizar_<?=$val['id_nivel']?>"><span class="glyphicon glyphicon-refresh"></span> Actualizar</button>
                        </div>
                    </div>
                    <table id="tabla_<?=$val['id_nivel']?>" class="table footable toggle-circle-filled" data-page-size="6" data-filter="#filter" data-filter-text-only="true">
                        <thead>
                            <tr>
                            	<?php /*if($val['id_padre']!="") { ?>
                      				<th class="all"><?=$nom_padre?></th>
                              	<?php }*/ ?>
                                <th class="all" style="width:120px">Código</th>
                                <th class="all">Descripción</th>
                                <th class="desktop tablet-l tablet-p" style="width:150px" align="center">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                        	<?php
                        		$c=1;
                                foreach($items as $val2) {
                                    if($val2['id_nivel']==$val['id_nivel']) {
                                    	$c++;
										if($val2['id_padre']=="")
											$val2['id_padre']="NULL";
										if($val['indicador']=="true")
											$adi='<a title=\'Presupuestar\' data-toggle="modal" href=\'#modal\' onClick=\'edit_presupuesto_row(this);return false;\'  class=\'table-link edit_presupuesto_row\'><span class=\'fa-stack\'><i class=\'fa fa-square fa-stack-2x\'></i><i class=\'fa fa-usd fa-stack-1x fa-inverse\'></i></span></a>';
	                                    else
	                                    	$adi='';
	                                    echo '	<tr>';
	                                    /*if($val['id_padre']!="")
	                                    	echo '<td>'.$val2['correlativo_item_p'].'</td>';*/
	                                    echo '	<td><span class="cv">'.$val2['correlativo_item'].'</span></td>
	                                			<td>
													<input type="hidden" name="id_item'.$val2['id_nivel'].'[]" class="ite" value="'.$val2['id_item'].'"/>
													<input type="hidden" name="id_seccion'.$val2['id_nivel'].'[]" class="sec" value="'.$val2['id_seccion'].'"/>
	                                				<input type="hidden" name="registro'.$val2['id_nivel'].'[]" class="reg" value=""/>
	                                				<input type="hidden" name="correlativo_item'.$val2['id_nivel'].'[]" class="cor" value="'.$val2['correlativo_item'].'"/>
	                                				<input type="hidden" name="id_padre'.$val2['id_nivel'].'[]" class="pad" value="'.$val2['id_padre'].'"/>
	                                				<input type="hidden" name="descripcion'.$val2['id_nivel'].'[]" class="des" value="'.$val2['descripcion_item'].'"/>
	                                				<span class="dv">'.$val2['descripcion_item'].'</span></td>
	                                			<td>
													<a title=\'Editar\' href=\'#\' onClick=\'edit_row_'.$val2['id_nivel'].'(this);return false;\'  class=\'table-link edit_row\' data-id=\''.$val2['id_nivel'].'\'><span class=\'fa-stack\'><i class=\'fa fa-square fa-stack-2x\'></i><i class=\'fa fa-pencil fa-stack-1x fa-inverse\'></i></span></a>
													<a title=\'Eliminar\' data-toggle="modal" href=\'#modal\' onClick=\'eliminar_item_'.$val2['id_nivel'].'(this);return false;\'  class=\'table-link\' data-id=\''.$val2['id_nivel'].'\'><span class=\'fa-stack\'><i class=\'fa fa-square fa-stack-2x\'></i><i class=\'fa fa-trash-o fa-stack-1x fa-inverse\'></i></span></a>
		                                			<a class="delete_row" href="#" onClick="delete_row_'.$val2['id_nivel'].'(this);return false;"></a>
		                                			'.$adi.'
	                                			</td>';
	                                	echo '	</tr>';
									}
                                    //echo '<option value="'.$val2['id_item'].'">'.$val2['correlativo_item'].'</option>';
                                }
                            ?>
                        </tbody>
                    </table>  
                    <table id="tabla_<?=$val['id_nivel']?>2">
                        <thead>
                            <tr>
                                <th class="all" style="width:100px">Código</th>
                                <th class="all">Descripción</th>
                                <th class="desktop tablet-l tablet-p" style="width:100px" align="center">Acción</th>
                            </tr>
                        </thead>
                        <tbody> 
                        </tbody>
                    </table>               
					<script type="text/javascript">                        
						var tabla_<?=$val['id_nivel']?>=$('#tabla_<?=$val['id_nivel']?>').DataTable({'info': false,"iDisplayLength": 100,"bSort":false});
						var tabla_<?=$val['id_nivel']?>2=$('#tabla_<?=$val['id_nivel']?>2').DataTable({'info': false,"iDisplayLength": 100,"bSort":false});						
						var count_<?=$val['id_nivel']?>=<?=$c?>;
						$('#tabla_<?=$val['id_nivel']?>2_wrapper').css({"display":"none"});
						if($('#agregar_separador_<?=$val['id_nivel']?>').is(':checked')) {
							$('#correlativo_item_<?=$val['id_nivel']?>').val("<?=$val['abreviacion'].'-'.$c?>");
						}
						else {
							$('#correlativo_item_<?=$val['id_nivel']?>').val("<?=$val['abreviacion'].$c?>");
						}
						
						$("#id_seccion_<?=$val['id_nivel']?>").select2({
							placeholder: "[Seleccione...]",
							allowClear: true
						});

						$('#agregar_separador_<?=$val['id_nivel']?>').click(function(){
							var $form=$(this).parents('form');											
							$form.data("change",1);
							var t=$("#name_<?=$val['id_nivel']?> #tabla_<?=$val['id_nivel']?> tr").length;
							var s="";
							var a="<?=$val['abreviacion']?>";
							if($('#agregar_separador_<?=$val['id_nivel']?>').is(':checked')) {
								s="-";
							}
							if ($('#id_padre_<?=$val['id_nivel']?>').val()!="NULL" && $('#id_padre_<?=$val['id_nivel']?>').val()!="") {
								if($('#agrupar_numeracion_<?=$val['id_nivel']?>').is(':checked')) {
									t=$("#tabla_<?=$val['id_nivel']?> td:contains('"+$(this).select2('data').text+"')").length+1;
								}
							}
							count_<?=$val['id_nivel']?>=t;
							$('#correlativo_item_<?=$val['id_nivel']?>').val(a+s+count_<?=$val['id_nivel']?>);
						});	
						
						$('#agregar_<?=$val['id_nivel']?>').on('click',function (){								
							var $form=$(this).parents('form');
							$form.data("change",1);
							var ph="."+$form.find('#id_padre_<?=$val['id_nivel']?>').select2('data').text;							
							<?php if($val['id_padre']=="") { ?>
								ph="";
							<?php } ?>

							var adi="";
							<?php
								if($val['indicador']=="true") {
							?>
									adi='<a title=\'Presupuestar\' data-toggle="modal" href=\'#modal\' onClick=\'edit_presupuesto_row(this);return false;\'  class=\'table-link edit_presupuesto_row\'><span class=\'fa-stack\'><i class=\'fa fa-square fa-stack-2x\'></i><i class=\'fa fa-usd fa-stack-1x fa-inverse\'></i></span></a>';
							<?php
								}
							?>

							tabla_<?=$val['id_nivel']?>.row.add( [
								<?php /*if($val['id_padre']!="") { ?>
									$form.find('#id_padre_<?=$val['id_nivel']?>').select2('data').text,
								<?php }*/ ?>
								'<span class="cv">'+$form.find('#correlativo_item_<?=$val['id_nivel']?>').val()+ph+'</span>',
								'<input type="hidden" class="ite" name="id_item<?=$val['id_nivel']?>[]" value=""/>'+'<input type="hidden" name="id_seccion<?=$val['id_nivel']?>[]" class="sec" value="'+$form.find('#id_seccion_<?=$val['id_nivel']?>').val()+'"/>'+'<input type="hidden" class="reg" name="registro<?=$val['id_nivel']?>[]" value="new"/>'+'<input type="hidden" class="cor" name="correlativo_item<?=$val['id_nivel']?>[]" value="'+$form.find('#correlativo_item_<?=$val['id_nivel']?>').val()+ph+'"/>'+'<input class="pad" type="hidden" name="id_padre<?=$val['id_nivel']?>[]" value="'+$form.find('#id_padre_<?=$val['id_nivel']?>').val()+'"/>'+'<input type="hidden" class="des" name="descripcion<?=$val['id_nivel']?>[]" value="'+$form.find('textarea[name="descripcion_item_<?=$val['id_nivel']?>"]').val()+'"/>'+'<span class="dv">'+$form.find('textarea[name="descripcion_item_<?=$val['id_nivel']?>"]').val()+'</span>',
								'<a title=\'Editar\' href=\'#\' onClick=\'edit_row_<?=$val['id_nivel']?>(this);return false;\'  class=\'table-link edit_row\'><span class=\'fa-stack\'><i class=\'fa fa-square fa-stack-2x\'></i><i class=\'fa fa-pencil fa-stack-1x fa-inverse\'></i></span></a> <a title=\'Eliminar\' data-toggle="modal" href=\'#modal\' onClick=\'eliminar_item_<?=$val['id_nivel']?>(this);return false;\'  class=\'table-link\'><span class=\'fa-stack\'><i class=\'fa fa-square fa-stack-2x\'></i><i class=\'fa fa-trash-o fa-stack-1x fa-inverse\'></i></span></a> <a class="delete_row" href="#" onClick="delete_row_<?=$val['id_nivel']?>(this);return false;"></a> '+adi
							]).draw();
								//'<a href="#" class="edit_row" onClick="edit_row_<?=$val['id_nivel']?>(this);return false;"><i class="fa fa-pencil"></i></a>&nbsp; <!--<a class="delete_row" href="#" onClick="delete_row_<?=$val['id_nivel']?>(this);return false;"><i class="fa fa-trash-o"></i></a>--> <a class="delete_row" href="#" onClick="delete_row_<?=$val['id_nivel']?>(this);return false;">&nbsp;</a> <a data-toggle="modal" href="#modal" onClick="eliminar_item_<?=$val['id_nivel']?>(this);return false;"><i class="fa fa-trash-o"></i></a>'+adi
							<?php
								if($val['indicador']=="true") {
							?>
									guardar_activo();
									$("#tabla_<?=$val['id_nivel']?> td:contains('"+$form.find('#correlativo_item_<?=$val['id_nivel']?>').val()+ph+"')").each(function (index) {
										var tr=$(this).parents('tr');
										tr.find('.ite').val(val['id_item']);
										tr.find('.reg').val("");
										$form.data("change",0);
									});				  
									/*tabla_<?=$val['id_nivel']?>.destroy();
									$('#tabla_<?=$val['id_nivel']?> tbody').load(base_url()+"index.php/pei/wizard_recargado2/<?=$val['id_nivel']?>");
									tabla_<?=$val['id_nivel']?>=$('#tabla_<?=$val['id_nivel']?>').DataTable({'info': false});*/
							<?php
								}
							?>
							$form.find('textarea[name="descripcion_item_<?=$val['id_nivel']?>"]').val("");
							count_<?=$val['id_nivel']?>++;						
							if($('#agregar_separador_<?=$val['id_nivel']?>').is(':checked')) {
								$form.find('#correlativo_item_<?=$val['id_nivel']?>').val("<?=$val['abreviacion']?>-"+count_<?=$val['id_nivel']?>);
							}
							else {
								$form.find('#correlativo_item_<?=$val['id_nivel']?>').val("<?=$val['abreviacion']?>"+count_<?=$val['id_nivel']?>);
							}
						});
						
						var dd;
						function eliminar_item_<?=$val['id_nivel']?>(e)
						{		
							dd=e;					
							$("#modal .modal-title").html("Eliminar registro");
							$("#modal .modal-body").html("Realmente desea eliminar este registro? Tenga en cuenta que una vez borrado no lo podrá recuperar y todos los registros heredados también se perderán.");
							$("#modal .btn-success").attr("onClick","delete_row_<?=$val['id_nivel']?>(0)");
						}

						function delete_row_<?=$val['id_nivel']?>(e){	
							/*alert($(e).parents('tr').find('.reg').val())						
							if($(e).parents('tr').find('.reg').val()!="del") {*/
								if(e==0)
									e=dd;
								var form=$(e).parents('form');
								var tr=$(e).parents('tr');
								$(e).parents('tr').find('.reg').val("del");
								var row = tabla_<?=$val['id_nivel']?>.row( $(e).parents('tr') );
								try {
									var rowNode = row.node();
									row.remove();
									form.data("change",2);
									tabla_<?=$val['id_nivel']?>2
										.row.add( rowNode )
										.draw();
									$("td:contains('."+tr.find('.cor').val()+"')").each(function (index) {
										$(this).parents('tr').find('.delete_row').click();
									});	
								}
								catch(err) {
									tr.remove();
								}						
							/*}*/
						}
						
						var idItem;
						var correlativoItem;
						var idPadre;
						var descripcion;
						function edit_row_<?=$val['id_nivel']?>(e){
							var form=$(e).parents('form');
							
							var tr=$(e).parents('tr');
							if(tr.find('.reg').val()!="new")
								tr.find('.reg').val("update");
							var x=Number(tr.find('.pad').val());
							var parts = tr.find('.cor').val().split(".");
							var c=parts.length-1;
							c=0;
							idItem = tr.find('.ite').val();
							correlativoItem = tr.find('.cor').val();
							idPadre = tr.find('.pad').val();
							descripcion = tr.find('.des').val();
							
							//alert(correlativoItem+'****'+idPadre);
							
							$("#id_padre_<?=$val['id_nivel']?>").val(x).trigger("change");
							$('#correlativo_item_<?=$val['id_nivel']?>').val(parts[c]);
							$('textarea[name="descripcion_item_<?=$val['id_nivel']?>"]').val(tr.find('.des').val());
							$("#id_seccion_<?=$val['id_nivel']?>").val(tr.find('.sec').val()).trigger("change");
							
							$("#agregar_<?=$val['id_nivel']?>").removeClass("ver").addClass("noVer");
							$("#actualizar_<?=$val['id_nivel']?>").removeClass("noVer").addClass("ver");
							$("#id_padre_<?=$val['id_nivel']?>").attr("disabled","disabled");
							$("#correlativo_item_<?=$val['id_nivel']?>").attr("disabled","disabled");
						}
						$('#actualizar_<?=$val['id_nivel']?>').on('click',function (){
							var $form=$(this).parents('form');			
							var ph="."+$form.find('#id_padre_<?=$val['id_nivel']?>').select2('data').text;							
							<?php if($val['id_padre']=="") { ?>
								ph="";
							<?php } ?>
							
							$("#name_<?=$val['id_nivel']?> tbody tr").each(function (index) {
								if($(this).find('.cor').val()==correlativoItem && $(this).find('.pad').val()==idPadre) {
									$form.data("change",3);
									<?php if($val['id_padre']!="") { ?>
										$(this).find('.pad').val($('#id_padre_<?=$val['id_nivel']?>').val());
									<?php } ?>
									$(this).find('.cor').val($('#correlativo_item_<?=$val['id_nivel']?>').val()+ph);
									$(this).find('.des').val($('textarea[name="descripcion_item_<?=$val['id_nivel']?>"]').val());
									$(this).find('.sec').val($('#id_seccion_<?=$val['id_nivel']?>').val());
									
									$(this).find('.cv').html($('#correlativo_item_<?=$val['id_nivel']?>').val()+ph);
									$(this).find('.dv').html($('textarea[name="descripcion_item_<?=$val['id_nivel']?>"]').val());
									$('#id_padre_<?=$val['id_nivel']?>').change();
									$form.find('textarea[name="descripcion_item_<?=$val['id_nivel']?>"]').val("");
								}
							});	
							$(this).removeClass("ver").addClass("noVer");
							$("#agregar_<?=$val['id_nivel']?>").removeClass("noVer").addClass("ver");
							$("#id_padre_<?=$val['id_nivel']?>").removeAttr("disabled");
							$("#correlativo_item_<?=$val['id_nivel']?>").removeAttr("disabled");
							$("#id_seccion_<?=$val['id_nivel']?>").val(null).trigger("change");
						});
                    </script>
                </form>
            </div>
	<?php
			$nom_padre=$val['nombre_nivel_l'];
		}
	?>
	<!--<div class="wizard-card" data-onvalidated="setServerName" data-cardname="name">
		<h3><span>Name &amp; FQDN</span></h3>
		<div class="wizard-input-section">
			<p>
				 To begin, please enter the IP of your server or the fully-qualified name.
			</p>
			<div class="form-group">
				<label for="exampleInputEmail1">Email address</label>
				<input type="text" class="form-control" id="new-server-fqdn" placeholder="FQDN or IP" data-validate="fqdn_or_ip"/>
			</div>
		</div>
		<div class="wizard-input-section">
			<p>
				 Optionally, give this server a label.
			</p>
			<div class="form-group">
				<label for="exampleInputEmail1">Email address</label>
				<input type="text" class="form-control" id="new-server-name" placeholder="Server name (optional)" data-validate=""/>
			</div>
		</div>
	</div>
	<div class="wizard-card" data-cardname="group">
		<h3><span>Server Group</span></h3>
		<div class="wizard-input-section">
			<p>
				 Where would you like server <strong class="create-server-name"></strong>
				to go?
			</p>
		</div>
	</div>
	<div class="wizard-card" data-cardname="services">
		<h3><span>Service Selection</span></h3>
		<div class="alert hide">
			 It's recommended that you select at least one service, like ping.
		</div>
		<div class="wizard-input-section">
			<p>
				 Please choose the services you'd like Panopta to monitor. Any service you select will be given a default check frequency of 1 minute.
			</p>
			<div class="form-group">
				<label for="exampleInputCountry">Country</label>
				<input type="text" class="form-control" id="exampleInputCountry">
			</div>
		</div>
	</div>
	<div class="wizard-card" data-onload="" data-cardname="location">
		<h3><span>Monitoring Location</span></h3>
		<div class="wizard-input-section">
			<p>
				 We determined <strong>Chicago</strong> to be the closest location to monitor <strong class="create-server-name"></strong>
				If you would like to change this, or you think this is incorrect, please select a different monitoring location.
			</p>
			<div class="form-group form-group-select2 col-md-6">
				<label>Enhanced Select</label>
				<select style="width:300px" id="sel2">
					<option value="United States">United States</option>
					<option value="United Kingdom">United Kingdom</option>
					<option value="Afghanistan">Afghanistan</option>
					<option value="Albania">Albania</option>
					<option value="Algeria">Algeria</option>
					<option value="American Samoa">American Samoa</option>
					<option value="Andorra">Andorra</option>
					<option value="Angola">Angola</option>
					<option value="Anguilla">Anguilla</option>
					<option value="Antarctica">Antarctica</option>
					<option value="Antigua and Barbuda">Antigua and Barbuda</option>
					<option value="Argentina">Argentina</option>
					<option value="Armenia">Armenia</option>
					<option value="Aruba">Aruba</option>
					<option value="Australia">Australia</option>
					<option value="Austria">Austria</option>
					<option value="Azerbaijan">Azerbaijan</option>
					<option value="Slovakia">Slovakia</option>
				</select>
			</div>
		</div>
	</div>
	<div class="wizard-card">
		<h3><span>Notification Schedule</span></h3>
		<div class="wizard-input-section">
			<p>
				 Select the notification schedule to be used for outages.
			</p>
			<div class="form-group">
				<input type="text" class="form-control" placeholder="Type schedule here">
			</div>
		</div>
		<div class="wizard-ns-detail hide">
			 Also using <strong>ALIS Production</strong>:
			<ul id="wizard-ns-detail-servers">
				<li>Corporate sites</li>
				<li>dt01.sat.medtelligent.com</li>
				<li>alisonline.com</li>
				<li>circa-db04.sat.medtelligent.com</li>
				<li>circa-services01.sat.medtelligent.com</li>
				<li>circa-web01.sat.medtelligent.com</li>
				<li>heartbeat.alisonline.com</li>
				<li>medtelligent.com</li>
				<li>dt02.fre.medtelligent.com</li>
				<li>dev03.lin.medtelligent.com</li>
			</ul>
		</div>
	</div>
	<div class="wizard-card">
		<h3><span>Agent Setup</span></h3>
		<div class="wizard-input-section">
			<p>
				The Agent allows you to monitor local resources (disk usage, cpu usage, etc). If you would like to set that up now, please download and follow the install instructions.
			</p>
		</div>
		<div class="wizard-input-section">
			<p>
				You will be given a server key after you install the Agent on <strong class="create-server-name"></strong>. If you know your server key now, please enter it below.
			</p>
			<div class="form-group">
				<input type="text" class="form-control create-server-agent-key" data-validate="" placeholder="Server key (optional)">
			</div>
		</div>
	</div>-->
	<div class="wizard-error">
		<div class="alert alert-error">
			<strong>There was a problem</strong> with your submission. Please correct the errors and re-submit.
		</div>
	</div>
	<div class="wizard-failure">
		<div class="alert alert-error">
			<strong>There was a problem</strong> submitting the form. Please try again in a minute.
		</div>
	</div>
	<div class="wizard-success">
		<div class="alert alert-success">
			<span class="create-server-name"></span>
			El proceso fue creado <strong> con éxito.</strong>
		</div>
		<a class="btn btn-default create-another-server">Modificar</a>
		<span style="padding:0 10px">o</span>
		<a class="btn btn-primary im-done">Terminar</a>
	</div>
</div>
<script src="<?=base_url()?>js/bootstrap-wizard.js"></script>
<script type="text/javascript">
	
	var id_nivel=<?=$band?>;
	
	function setServerName(card) {
		var host = $("#new-server-fqdn").val();
		var name = $("#new-server-name").val();
		var displayName = host;
	
		if (name) {
			displayName = name + " ("+host+")";
		};
	
		card.wizard.setSubtitle(displayName);
		card.wizard.el.find(".create-server-name").text(displayName);
	}
	
	function validateIP(ipaddr) {
	    //Remember, this function will validate only Class C IP.
	    //change to other IP Classes as you need
	    ipaddr = ipaddr.replace(/\s/g, "") //remove spaces for checking
	    var re = /^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$/; //regex. check for digits and in
	                                          //all 4 quadrants of the IP
	    if (re.test(ipaddr)) {
	        //split into units with dots "."
	        var parts = ipaddr.split(".");
	        //if the first unit/quadrant of the IP is zero
	        if (parseInt(parseFloat(parts[0])) == 0) {
	            return false;
	        }
	        //if the fourth unit/quadrant of the IP is zero
	        if (parseInt(parseFloat(parts[3])) == 0) {
	            return false;
	        }
	        //if any part is greater than 255
	        for (var i=0; i<parts.length; i++) {
	            if (parseInt(parseFloat(parts[i])) > 255){
	                return false;
	            }
	        }
	        return true;
	    }
	    else {
	        return false;
	    }
	}
	
	function validateFQDN(val) {
		return /^[a-z0-9-_]+(\.[a-z0-9-_]+)*\.([a-z]{2,4})$/.test(val);
	}
	
	function fqdn_or_ip(el) {
		var val = el.val();
		ret = {
			status: true
		};
		if (!validateFQDN(val)) {
			if (!validateIP(val)) {
				ret.status = false;
				ret.msg = "Invalid IP address or FQDN";
			}
		}
		return ret;
	}	
	
	$(function() {			
		$.fn.wizard.logging = false;
	
		var wizard = $("#wizard-demo").wizard({
			showCancel: false,
			buttons:{
				cancelText:"Cancelar",
				nextText:"Siguiente",
				backText:"Anterior",
				submitText:"Finalizar",
				submittingText:"Guardando..."
			}
		});
	
		wizard.el.find(".wizard-ns-select").change(function() {
			wizard.el.find(".wizard-ns-detail").show();
		});
	
		wizard.el.find(".create-server-service-list").change(function() {
			var noOption = $(this).find("option:selected").length == 0;
			wizard.getCard(this).toggleAlert(null, noOption);
		});
	
		/*wizard.cards["name"].on("validated", function(card) {
			var hostname = card.el.find("#new-server-fqdn").val();
		});*/
	
		wizard.on("submit", function(wizard) {
			var submit = {
				"hostname": $("#new-server-fqdn").val()
			};
	
			setTimeout(function() {
				wizard.trigger("success");
				wizard.hideButtons();
				wizard._submitting = false;
				wizard.showSubmitCard("success");
				wizard.updateProgressBar(0);
			}, 1000);
		});
		
		wizard.on("incrementCard", function(wizard) {
			var i_n=id_nivel;
			var $card=wizard.el.find(".active");
			id_nivel=$card.find("a").data("id_nivel");
			var $form=$("#name_"+i_n);
			var c=Number($form.data("change"));
			$form.find('.reg').val("");
			$form.data("change",0);
			if(c>=1) {
				$("#id_padre_"+id_nivel).select2("destroy");
				$("#id_padre_"+id_nivel).load(base_url()+"index.php/pei/wizard_recargado/"+i_n);
				setTimeout(function(){				  
					$("#id_padre_"+id_nivel).select2({
						placeholder: "[Seleccione...]",
						allowClear: true
					});
				}, 250);
				//alert("antes del ok");
				//$("#id_padre_"+id_nivel).val(null).trigger("change");
				//alert("ok!");
			}
			if(c==2) {
				//alert("recargar tabla");
				//$("#id_padre_"+id_nivel).load(base_url()+"index.php/pei/wizard_recargado/"+i_n);
			}
		});
		
		wizard.on("decrementCard", function(wizard) {
			var $card=wizard.el.find(".active");
			id_nivel=$card.find("a").data("id_nivel");
		});	
		
		$('a.wizard-nav-link').click(function(){
			var $p=$(this).parent('li');
			if($p.hasClass("active") || $p.hasClass("already-visited")) {
				id_nivel=$(this).data("id_nivel");
			}
		});
		
		wizard.on("reset", function(wizard) {
			wizard.setSubtitle("");
			wizard.el.find("#new-server-fqdn").val("");
			wizard.el.find("#new-server-name").val("");
		});
	
		wizard.el.find(".wizard-success .im-done").click(function() {
			wizard.reset().close();
			$('.wizard-nav-link').click();
		});
	
		wizard.el.find(".wizard-success .create-another-server").click(function() {
			wizard.reset();
			$('.wizard-nav-link').click();
		});
	
		$(".wizard-group-list").click(function() {
			//alert("Disabled for demo.");
		});
	
		$("#open-wizard").click(function() {
			wizard.show();
		});	
		wizard.show();
	});
	function guardar_activo()
	{
		var $form=$("#name_"+id_nivel);
		//alert("guardar el número: "+id_nivel+"\n"+$form.serialize());
		if($form.data("change")>=1) {
			var url='<?=base_url()?>index.php/pei/guardar_wizard';
	        var mensaje_correcto="loadingcircle***La petición se ha completado éxitosamente!";
	        var mensaje_incorrecto="loadingcircle***Error en la peticitión! Se perdió la conexión a la red";
			var data = new FormData($("#name_"+id_nivel)[0]);
			//alert("guardar el número: "+id_nivel+"\n"+data);
	        ajax_json(url, mensaje_correcto, mensaje_incorrecto, data);
	   	}
	}
	function edit_presupuesto_row(e) {
		var id_item=$(e).parents('tr').find('.ite').val();
		$("#modal .modal-title").html('Presupuesto Indicativo Plurianual de <b>'+$(e).parents('tr').find('.cor').val()+'</b>');
		$("#modal .modal-body").html("");
		$("#modal .modal-body").load(base_url()+"index.php/pei/presupuesto/"+id_item);
		$("#modal .btn-success").attr("onClick","guardar_presupuesto();return false;");
	}
</script>