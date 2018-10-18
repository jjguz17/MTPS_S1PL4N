<br/>
<?php
    if ($estructura[0]['id_nivel']!="") {
?>
        <div class="form-group">
            <div class="col-sm-1">
            </div>
            <div class="col-sm-10" style="padding-left: 0;">
                <p style="text-align: justify;">
                    <strong>IMPORTANTE!</strong> Si se modifica la estructura se perderán todos los registros que herede. Sin embargo puede modificar los nombres, abreviaturas y si necesitan ser presupuestados. Si desea modificar la estructura, de clic <a data-toggle="modal" href="#modal" onclick="habilitar_edicion_estructura(); return false;">aquí</a>
                </p>
            </div>
        </div>
<?php
    }
?>
<style>
	.gruposombra {
		position: relative;
		display: inline-block;
	}
	.sombra {
		position: absolute;
		width: 100%;
		height: 100%;
		top: 0;
	}
	.sombra2 {
		position: absolute;
		margin: 0;
		left: 0;
		top: 0;
		width: 30px;
		text-indent: 100%;
		white-space: nowrap;
		overflow: hidden;
		display: block;
    	height: 30px;
	}
	.quitarsombra {
		z-index: -1;
	}
</style>
<textarea name="lista" id="nestable2-output" style="display:none" class="form-control" rows="3"></textarea>
<div class="form-group">
    <!--<label for="nombre_pei" class="col-sm-3 control-label">Estructura <span class="asterisk">*</span></label>-->
    <div class="col-sm-1">
    </div>
    <div class="col-sm-10 dd" id="nestable3">
        <ol id="ls" class="dd-list">
            <?php
                if ($estructura[0]['id_nivel']=="") {
            ?>
                    <li class="dd-item dd3-item" data-id="Proceso 1" data-ind="false" data-abr="P1">
                        <div class="dd-handle dd3-handle">Drag</div>
                        <div class="dd3-content">
                            <a href="#" data-type="text" data-pk="1" data-title="Ingrese nombre" class="editable editable-click">Proceso 1</a>
                            <a>(</a><a href="#" data-type="textarea" data-pk="1" data-title="Ingrese abreviatura" class="editable editable-click">P1</a><a>)</a>
                            <div class="nested-links">
								<div class="gruposombra">
                                    <a href="#" class="nested-link add-proceso" onclick="add_proceso(this);return false;" title="Agregar Proceso"><i class="fa fa-plus"></i></a>
                                    <a href="#" class="nested-link del-proceso" onclick="del_proceso(this);return false;" title="Eliminar Proceso"><i class="fa fa-trash-o"></i></a>
                                </div>
                                <div class="checkbox-nice cnl" title="¿Agregar presupuesto?">
                                    <input type="checkbox" id="checkbox-1" onclick="cambiarIndicador(this)" />
                                    <label for="checkbox-1"></label>
                                </div>
                            </div>
                        </div>
                    </li>
        	<?php
                }
        		$j=0;
                foreach($estructura as $val) {
                	if($val['id_padre']==NULL) {
    				  	$j++;
                    	if($val['indicador']=='true')$che='checked="checked"';else $che='';
    					echo '<li class="dd-item dd3-item" data-id="'.$val['nombre_nivel'].'" data-ind="'.$val['indicador'].'" data-abr="'.$val['abreviacion'].'" data-id_padre="'.$val['id_padre'].'" data-id_nivel="'.$val['id_nivel'].'">
    				                <div class="dd-handle dd3-handle"></div>
    				                <div class="dd3-content">
    				                    <a href="#" data-type="text" data-pk="1" data-title="Ingrese nombre" class="editable editable-click">'.$val['nombre_nivel'].'</a>
    				                    <a>(</a><a href="#" data-type="textarea" data-pk="1" data-title="Ingrese abreviatura" class="editable editable-click">'.$val['abreviacion'].'</a><a>)</a>
    				                    <div class="nested-links">
											<div class="gruposombra">
												<a href="#" class="nested-link add-proceso" onclick="add_proceso(this);return false;" title="Agregar Proceso"><i class="fa fa-plus"></i></a>
												<a href="#" class="nested-link del-proceso" onclick="del_proceso(this);return false;" title="Eliminar Proceso"><i class="fa fa-trash-o"></i></a>
												<div class="sombra"></div>
											</div>
    				                    	<div class="checkbox-nice cnl" title="¿Agregar presupuesto?">
                                                <input type="checkbox" id="checkbox-'.$j.'" onclick="cambiarIndicador(this)" '.$che.' />
                                                <label for="checkbox-'.$j.'"></label>
                                            </div>
    				                    </div> 
                                    </div> 
									<div class="sombra2"></div> ';
                        foreach($estructura as $val2) {
                            echo '<ol class="dd-list"> ';
                            if($val2['id_padre']==$val['id_nivel']) {
    				  	$j++;
                                if($val2['indicador']=='true')$che='checked="checked"';else $che='';
                                echo '  <li class="dd-item dd3-item" data-id="'.$val2['nombre_nivel'].'" data-ind="'.$val2['indicador'].'" data-abr="'.$val2['abreviacion'].'" data-id_padre="'.$val2['id_padre'].'" data-id_nivel="'.$val2['id_nivel'].'">
                                            <div class="dd-handle dd3-handle"></div>
                                            <div class="dd3-content">
                                                <a href="#" data-type="text" data-pk="1" data-title="Ingrese nombre" class="editable editable-click">'.$val2['nombre_nivel'].'</a>
                                                <a>(</a><a href="#" data-type="textarea" data-pk="1" data-title="Ingrese abreviatura" class="editable editable-click">'.$val2['abreviacion'].'</a><a>)</a>
                                                <div class="nested-links">
													<div class="gruposombra">
														<a href="#" class="nested-link add-proceso" onclick="add_proceso(this);return false;" title="Agregar Proceso"><i class="fa fa-plus"></i></a>
														<a href="#" class="nested-link del-proceso" onclick="del_proceso(this);return false;" title="Eliminar Proceso"><i class="fa fa-trash-o"></i></a>
                                                    	<div class="sombra"></div>
													</div>
													<div class="checkbox-nice cnl" title="¿Agregar presupuesto?">
                                                        <input type="checkbox" id="checkbox-'.$j.'" onclick="cambiarIndicador(this)" '.$che.' />
                                                        <label for="checkbox-'.$j.'"></label>
                                                    </div>
                                                </div>
                                            </div> 
											<div class="sombra2"></div> ';
                                foreach($estructura as $val3) {
                                    echo '<ol class="dd-list"> ';
                                    if($val3['id_padre']==$val2['id_nivel']) {
    				  	$j++;
                                        if($val3['indicador']=='true')$che='checked="checked"';else $che='';
                                        echo '  <li class="dd-item dd3-item" data-id="'.$val3['nombre_nivel'].'" data-ind="'.$val3['indicador'].'" data-abr="'.$val3['abreviacion'].'" data-id_padre="'.$val3['id_padre'].'" data-id_nivel="'.$val3['id_nivel'].'">
                                                    <div class="dd-handle dd3-handle"></div>
                                                    <div class="dd3-content">
                                                        <a href="#" data-type="text" data-pk="1" data-title="Ingrese nombre" class="editable editable-click">'.$val3['nombre_nivel'].'</a>
                                                        <a>(</a><a href="#" data-type="textarea" data-pk="1" data-title="Ingrese abreviatura" class="editable editable-click">'.$val3['abreviacion'].'</a><a>)</a>
                                                        <div class="nested-links">
															<div class="gruposombra">
																<a href="#" class="nested-link add-proceso" onclick="add_proceso(this);return false;" title="Agregar Proceso"><i class="fa fa-plus"></i></a>
																<a href="#" class="nested-link del-proceso" onclick="del_proceso(this);return false;" title="Eliminar Proceso"><i class="fa fa-trash-o"></i></a>
                                                            	<div class="sombra"></div>
															</div>
															<div class="checkbox-nice cnl" title="¿Agregar presupuesto?">
                                                                <input type="checkbox" id="checkbox-'.$j.'" onclick="cambiarIndicador(this)" '.$che.' />
                                                                <label for="checkbox-'.$j.'"></label>
                                                            </div>
                                                        </div>
                                                    </div> 
													<div class="sombra2"></div> ';                                            
                                        foreach($estructura as $val4) {
                                            echo '<ol class="dd-list"> ';
                                            if($val4['id_padre']==$val3['id_nivel']) {
    				  	$j++;
                                                if($val4['indicador']=='true')$che='checked="checked"';else $che='';
                                                echo '  <li class="dd-item dd3-item" data-id="'.$val4['nombre_nivel'].'" data-ind="'.$val4['indicador'].'" data-abr="'.$val4['abreviacion'].'" data-id_padre="'.$val4['id_padre'].'" data-id_nivel="'.$val4['id_nivel'].'">
                                                            <div class="dd-handle dd3-handle"></div>
                                                            <div class="dd3-content">
                                                                <a href="#" data-type="text" data-pk="1" data-title="Ingrese nombre" class="editable editable-click">'.$val4['nombre_nivel'].'</a>
                                                                <a>(</a><a href="#" data-type="textarea" data-pk="1" data-title="Ingrese abreviatura" class="editable editable-click">'.$val4['abreviacion'].'</a><a>)</a>
                                                                <div class="nested-links">
																	<div class="gruposombra">
																		<a href="#" class="nested-link add-proceso" onclick="add_proceso(this);return false;" title="Agregar Proceso"><i class="fa fa-plus"></i></a>
																		<a href="#" class="nested-link del-proceso" onclick="del_proceso(this);return false;" title="Eliminar Proceso"><i class="fa fa-trash-o"></i></a>
                                                                    	<div class="sombra"></div>
																	</div>
																	<div class="checkbox-nice cnl" title="¿Agregar presupuesto?">
                                                                        <input type="checkbox" id="checkbox-'.$j.'" onclick="cambiarIndicador(this)" '.$che.' />
                                                                        <label for="checkbox-'.$j.'"></label>
                                                                    </div>
                                                                </div>
                                                            </div> 
															<div class="sombra2"></div> ';                                                    
                                                foreach($estructura as $val5) {
                                                    echo '<ol class="dd-list"> ';
                                                    if($val5['id_padre']==$val4['id_nivel']) {
    				  	$j++;
                                                        if($val5['indicador']=='true')$che='checked="checked"';else $che='';
                                                        echo '  <li class="dd-item dd3-item" data-id="'.$val5['nombre_nivel'].'" data-ind="'.$val5['indicador'].'" data-abr="'.$val5['abreviacion'].'" data-id_padre="'.$val5['id_padre'].'" data-id_nivel="'.$val5['id_nivel'].'">
                                                                    <div class="dd-handle dd3-handle"></div>
                                                                    <div class="dd3-content">
                                                                        <a href="#" data-type="text" data-pk="1" data-title="Ingrese nombre" class="editable editable-click">'.$val5['nombre_nivel'].'</a>
                                                                        <a>(</a><a href="#" data-type="textarea" data-pk="1" data-title="Ingrese abreviatura" class="editable editable-click">'.$val5['abreviacion'].'</a><a>)</a>
                                                                        <div class="nested-links">
																			<div class="gruposombra">
																				<a href="#" class="nested-link add-proceso" onclick="add_proceso(this);return false;" title="Agregar Proceso"><i class="fa fa-plus"></i></a>
																				<a href="#" class="nested-link del-proceso" onclick="del_proceso(this);return false;" title="Eliminar Proceso"><i class="fa fa-trash-o"></i></a>
                                                                            	<div class="sombra"></div>
																			</div>
																			<div class="checkbox-nice cnl" title="¿Agregar presupuesto?">
                                                                                <input type="checkbox" id="checkbox-'.$j.'" onclick="cambiarIndicador(this)" '.$che.' />
                                                                                <label for="checkbox-'.$j.'"></label>
                                                                            </div>
                                                                        </div>
                                                                    </div> 
																	<div class="sombra2"></div> ';                                                    
                                                        foreach($estructura as $val6) {
                                                            echo '<ol class="dd-list"> ';
                                                            if($val6['id_padre']==$val5['id_nivel']) {
    				  	$j++;
                                                                if($val6['indicador']=='true')$che='checked="checked"';else $che='';
                                                                echo '  <li class="dd-item dd3-item" data-id="'.$val6['nombre_nivel'].'" data-ind="'.$val6['indicador'].'" data-abr="'.$val6['abreviacion'].'" data-id_padre="'.$val6['id_padre'].'" data-id_nivel="'.$val6['id_nivel'].'">
                                                                            <div class="dd-handle dd3-handle"></div>
                                                                            <div class="dd3-content">
                                                                                <a href="#" data-type="text" data-pk="1" data-title="Ingrese nombre" class="editable editable-click">'.$val6['nombre_nivel'].'</a>
                                                                                <a>(</a><a href="#" data-type="textarea" data-pk="1" data-title="Ingrese abreviatura" class="editable editable-click">'.$val6['abreviacion'].'</a><a>)</a>
                                                                                <div class="nested-links">
																					<div class="gruposombra">
																						<a href="#" class="nested-link add-proceso" onclick="add_proceso(this);return false;" title="Agregar Proceso"><i class="fa fa-plus"></i></a>
																						<a href="#" class="nested-link del-proceso" onclick="del_proceso(this);return false;" title="Eliminar Proceso"><i class="fa fa-trash-o"></i></a>
                                                                                    	<div class="sombra"></div>
																					</div>
																					<div class="checkbox-nice cnl" title="¿Agregar presupuesto?">
                                                                                        <input type="checkbox" id="checkbox-'.$j.'" onclick="cambiarIndicador(this)" '.$che.' />
                                                                                        <label for="checkbox-'.$j.'"></label>
                                                                                    </div>
                                                                                </div>
                                                                            </div> 
																			<div class="sombra2"></div> ';                                                    
                                                                foreach($estructura as $val7) {
                                                                    echo '<ol class="dd-list"> ';
                                                                    if($val7['id_padre']==$val6['id_nivel']) {
    				  	$j++;
                                                                        if($val7['indicador']=='true')$che='checked="checked"';else $che='';
                                                                        echo '  <li class="dd-item dd3-item" data-id="'.$val7['nombre_nivel'].'" data-ind="'.$val7['indicador'].'" data-abr="'.$val7['abreviacion'].'" data-id_padre="'.$val7['id_padre'].'" data-id_nivel="'.$val7['id_nivel'].'">
                                                                                    <div class="dd-handle dd3-handle"></div>
                                                                                    <div class="dd3-content">
                                                                                        <a href="#" data-type="text" data-pk="1" data-title="Ingrese nombre" class="editable editable-click">'.$val7['nombre_nivel'].'</a>
                                                                                        <a>(</a><a href="#" data-type="textarea" data-pk="1" data-title="Ingrese abreviatura" class="editable editable-click">'.$val7['abreviacion'].'</a><a>)</a>
                                                                                        <div class="nested-links">
																							<div class="gruposombra">
																								<a href="#" class="nested-link add-proceso" onclick="add_proceso(this);return false;" title="Agregar Proceso"><i class="fa fa-plus"></i></a>
																								<a href="#" class="nested-link del-proceso" onclick="del_proceso(this);return false;" title="Eliminar Proceso"><i class="fa fa-trash-o"></i></a>
                                                                                            	<div class="sombra"></div>
																							</div>
																							<div class="checkbox-nice cnl" title="¿Agregar presupuesto?">
                                                                                                <input type="checkbox" id="checkbox-'.$j.'" onclick="cambiarIndicador(this)" '.$che.' />
                                                                                                <label for="checkbox-'.$j.'"></label>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div> 
																					<div class="sombra2"></div> ';                                                    
                                                                        foreach($estructura as $val8) {
                                                                            echo '<ol class="dd-list"> ';
                                                                            if($val8['id_padre']==$val7['id_nivel']) {
    				  	$j++;
                                                                                if($val8['indicador']=='true')$che='checked="checked"';else $che='';
                                                                                echo '  <li class="dd-item dd3-item" data-id="'.$val8['nombre_nivel'].'" data-ind="'.$val8['indicador'].'" data-abr="'.$val8['abreviacion'].'" data-id_padre="'.$val8['id_padre'].'" data-id_nivel="'.$val8['id_nivel'].'">
                                                                                            <div class="dd-handle dd3-handle"></div>
                                                                                            <div class="dd3-content">
                                                                                                <a href="#" data-type="text" data-pk="1" data-title="Ingrese nombre" class="editable editable-click">'.$val8['nombre_nivel'].'</a>
                                                                                                <a>(</a><a href="#" data-type="textarea" data-pk="1" data-title="Ingrese abreviatura" class="editable editable-click">'.$val8['abreviacion'].'</a><a>)</a>
                                                                                                <div class="nested-links">
																									<div class="gruposombra">
																										<a href="#" class="nested-link add-proceso" onclick="add_proceso(this);return false;" title="Agregar Proceso"><i class="fa fa-plus"></i></a>
																										<a href="#" class="nested-link del-proceso" onclick="del_proceso(this);return false;" title="Eliminar Proceso"><i class="fa fa-trash-o"></i></a>
                                                                                                    	<div class="sombra"></div>
																									</div>
																									<div class="checkbox-nice cnl" title="¿Agregar presupuesto?">
                                                                                                        <input type="checkbox" id="checkbox-'.$j.'" onclick="cambiarIndicador(this)" '.$che.' />
                                                                                                        <label for="checkbox-'.$j.'"></label>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div> 
																							<div class="sombra2"></div> ';                                                    
                                                                                foreach($estructura as $val9) {
                                                                                    echo '<ol class="dd-list"> ';
                                                                                    if($val9['id_padre']==$val8['id_nivel']) {
    				  	$j++;
                                                                                        if($val9['indicador']=='true')$che='checked="checked"';else $che='';
                                                                                        echo '  <li class="dd-item dd3-item" data-id="'.$val9['nombre_nivel'].'" data-ind="'.$val9['indicador'].'" data-abr="'.$val9['abreviacion'].'" data-id_padre="'.$val9['id_padre'].'" data-id_nivel="'.$val9['id_nivel'].'">
                                                                                                    <div class="dd-handle dd3-handle"></div>
                                                                                                    <div class="dd3-content">
                                                                                                        <a href="#" data-type="text" data-pk="1" data-title="Ingrese nombre" class="editable editable-click">'.$val9['nombre_nivel'].'</a>
                                                                                                        <a>(</a><a href="#" data-type="textarea" data-pk="1" data-title="Ingrese abreviatura" class="editable editable-click">'.$val9['abreviacion'].'</a><a>)</a>
                                                                                                        <div class="nested-links">
																											<div class="gruposombra">
																												<a href="#" class="nested-link add-proceso" onclick="add_proceso(this);return false;" title="Agregar Proceso"><i class="fa fa-plus"></i></a>
																												<a href="#" class="nested-link del-proceso" onclick="del_proceso(this);return false;" title="Eliminar Proceso"><i class="fa fa-trash-o"></i></a>
                                                                                                            	<div class="sombra"></div>
																											</div>
																											<div class="checkbox-nice cnl" title="¿Agregar presupuesto?">
                                                                                                                <input type="checkbox" id="checkbox-'.$j.'" onclick="cambiarIndicador(this)" '.$che.' />
                                                                                                                <label for="checkbox-'.$j.'"></label>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div> 
																									<div class="sombra2"></div> ';                                                    
                                                                                        foreach($estructura as $val0) {
                                                                                            echo '<ol class="dd-list"> ';
                                                                                            if($val0['id_padre']==$val9['id_nivel']) {
    				  	$j++;
                                                                                                if($val0['indicador']=='true')$che='checked="checked"';else $che='';
                                                                                                echo '  <li class="dd-item dd3-item" data-id="'.$val0['nombre_nivel'].'" data-ind="'.$val0['indicador'].'" data-abr="'.$val0['abreviacion'].'" data-id_padre="'.$val0['id_padre'].'" data-id_nivel="'.$val0['id_nivel'].'">
                                                                                                            <div class="dd-handle dd3-handle"></div>
                                                                                                            <div class="dd3-content">
                                                                                                                <a href="#" data-type="text" data-pk="1" data-title="Ingrese nombre" class="editable editable-click">'.$val0['nombre_nivel'].'</a>
                                                                                                                <a>(</a><a href="#" data-type="textarea" data-pk="1" data-title="Ingrese abreviatura" class="editable editable-click">'.$val0['abreviacion'].'</a><a>)</a>
                                                                                                                <div class="nested-links">
																													<div class="gruposombra">
																														<a href="#" class="nested-link add-proceso" onclick="add_proceso(this);return false;" title="Agregar Proceso"><i class="fa fa-plus"></i></a>
																														<a href="#" class="nested-link del-proceso" onclick="del_proceso(this);return false;" title="Eliminar Proceso"><i class="fa fa-trash-o"></i></a>
                                                                                                                    	<div class="sombra"></div>
																													</div>
																													<div class="checkbox-nice cnl" title="¿Agregar presupuesto?">
                                                                                                                        <input type="checkbox" id="checkbox-'.$j.'" onclick="cambiarIndicador(this)" '.$che.' />
                                                                                                                        <label for="checkbox-'.$j.'"></label>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div> 
																											<div class="sombra2"></div> ';                                                    
                                                                                                
                                                                                                echo '  </li>';
                                                                                            }
                                                                                            echo '</ol> ';
                                                                                        }
                                                                                        echo '  </li>';
                                                                                    }
                                                                                    echo '</ol> ';
                                                                                }
                                                                                echo '  </li>';
                                                                            }
                                                                            echo '</ol> ';
                                                                        }
                                                                        echo '  </li>';
                                                                    }
                                                                    echo '</ol> ';
                                                                }
                                                                echo '  </li>';
                                                            }
                                                            echo '</ol> ';
                                                        }
                                                        echo '  </li>';
                                                    }
                                                    echo '</ol> ';
                                                }
                                                echo '  </li>';
                                            }
                                            echo '</ol> ';
                                        }
                                        echo '  </li>';
                                    }
                                    echo '</ol> ';
                                }
                                echo '  </li>';
                            }
                            echo '</ol> ';
                        }
    				    echo '</li>';
                    }
	          	}
            ?> 
        </ol>        
    </div>
</div>
<script type="text/javascript">
	$(document).ready(function(){

        //toggle `popup` / `inline` mode
        $.fn.editable.defaults.mode = 'inline';     
        
        //make username editable
        $('.editable').editable();

        $('#nestable3').nestable({
            group: 1
        })
        .on('change', updateOutput);
    
        // output initial serialised data
        updateOutput($('#nestable3').data('output', $('#nestable2-output')));
    });
		
	function habilitar_edicion_estructura() {
		$("#modal .modal-title").html("Alerta");
		$("#modal .modal-body").html("¿Realmente desea modificar la estructura? Tenga en cuenta que todos los registros heredados se perderán y no los podrá recuperar.");
		$("#modal .btn-success").attr("onClick","$('.sombra, .sombra2').addClass('quitarsombra');return false;");
	}
</script>

<!--<pre>
<?=print_r($estructura)?>
</pre>-->