<style>
	blockquote {
		font-size: 13px;
	}
</style>
<form name="formuPre" id="formuPre" class="form-horizontal" method="post">
	<input type="hidden" name="id_item" value="<?=$id_item[0]['id_item']?>">
	<div class="form-group">
        <div class="col-sm-12">
    		<blockquote>
                <p><?=$id_item[0]['descripcion_item']?></p>
            </blockquote>
        </div>
    </div>
    <div class="form-group">
        <label for="clasificacion_gasto" class="col-sm-3 control-label">Clasificación del gasto</label>
        <div class="col-sm-8">
            <input type="text" class="form-control" id="clasificacion_gasto" name="clasificacion_gasto" style="letter-spacing: 0.46px;" value="<?=$id_presupuesto[0]['clasificacion_gasto']?>">
        </div>
    </div>
    <div class="form-group form-group-select2">
        <label for="unidad_lider" class="col-sm-3 control-label">Unidad(es) líder(es) <span class="asterisk">*</span></label>
        <div class="col-sm-8">
        	<select name="unidad_lider[]" id="unidad_lider" data-placeholder="[Seleccione..]" style="width:100%" multiple>
                <option value=""></option>
                <?php
                    foreach($seccion as $val2) {
						$b="";
                        foreach($unidades_apoyo as $val3)
							if($val2['id_seccion']==$val3['id_seccion'] && $val3['id_tipo_apoyo']==1)
								$b='selected="selected"';
                        echo '<option value="'.$val2['id_seccion'].'" '.$b.' >'.$val2['nombre_seccion'].'</option>';
                    }
                ?>
            </select>
        </div>
    </div>
    <div class="form-group form-group-select2">
        <label for="unidad_apoyo" class="col-sm-3 control-label">Unidad(es) de apoyo</label>
        <div class="col-sm-8">
        	<select name="unidad_apoyo[]" id="unidad_apoyo" data-placeholder="[Seleccione..]" style="width:100%" multiple>
                <option value=""></option>
                <?php
                    foreach($seccion as $val2) {
						$b="";
						foreach($unidades_apoyo as $val3)
							if($val2['id_seccion']==$val3['id_seccion'] && $val3['id_tipo_apoyo']==2)
                        		$b='selected="selected"';
                        echo '<option value="'.$val2['id_seccion'].'" '.$b.' >'.$val2['nombre_seccion'].'</option>';
                    }
                ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <div class="table-responsive col-sm-12">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <!--<th class="text-center"><span style="text-transform: capitalize;"><?=$estructura[0]['nombre_nivel_l']?></span></th>-->
                        <!--<th class="text-center"><span>Unidad Líder</span></th>-->
                        <!--<th class="text-center"><span>Clasificación</span></th>-->
                        <?php
                            $i=$documento[0]['inicio_periodo'];
                            $f=$documento[0]['fin_periodo'];
                            $d=$f-$i;
                            for($j=1;$j<=$d;$j++)
                                echo '<th class="text-center"><span>'.($i+$j).'</span></th>';
                        ?>
                    </tr>
                </thead>
                <tbody>
                <tr>
                    <!--<td><?=$id_item[0]['descripcion_item']?></td>-->
                    <!--<td class="text-center"><span class="label label-danger"></span></td>-->
                    <!--<td class="text-center"><input type="text" name="clasificacion"/></td>-->
                    <?php
                        $i=$documento[0]['inicio_periodo'];
                        $f=$documento[0]['fin_periodo'];
                        $d=$f-$i;
                        for($j=1;$j<=$d;$j++){
							$band=true;
							for($x=0;$x<count($id_presupuesto);$x++)
								if($id_presupuesto[$x]['anio']==($i+$j)) {									
                            		echo '<td>
                                        <div class="input-group">
                                            <span class="input-group-addon">$</span>
                                            <input type="text" class="form-control" name="presupuesto[]" value="'.$id_presupuesto[$x]['presupuesto'].'">
                                        </div>
                                        <input type="hidden" name="anio[]" value="'.($i+$j).'"/>
                                        <input type="hidden" name="id_presupuesto[]" value="'.$id_presupuesto[$x]['id_presupuesto'].'"/>
                                    </td>';
									$band=false;
								}
							if($band)	
                            	echo '<td>
                                    <div class="input-group">
                                        <span class="input-group-addon">$</span>
                                        <input type="text" class="form-control" name="presupuesto[]" value="'.$id_presupuesto[$x]['presupuesto'].'">
                                    </div>
                                    <input type="hidden" name="anio[]" value="'.($i+$j).'"/>
                                    <input type="hidden" name="id_presupuesto[]" value="'.$id_presupuesto[$x]['id_presupuesto'].'"/>
                                </td>';
						}
					?>
                </tr>
                </tbody>
            </table>
        </div>
   	</div>
</form>
<script>
	$(document).ready(function(e) {						
		$("#unidad_lider").select2({
			placeholder: "[Seleccione...]",
			allowClear: true,
			maximumSelectionLength: 5
		});					
		$("#unidad_apoyo").select2({
			placeholder: "[Seleccione...]",
			allowClear: true,
			maximumSelectionLength: 5
		});
    });
	function guardar_presupuesto()
	{
		var url='<?=base_url()?>index.php/pei/guardar_presupuesto';
		var mensaje_correcto="loadingcircle***La petición se ha completado éxitosamente!";
		var mensaje_incorrecto="loadingcircle***Error en la peticitión! Se perdió la conexión a la red";
		var data = new FormData($("#formuPre")[0]);
		//alert("guardar el número: "+id_nivel+"\n"+data);
		ajax_json(url, mensaje_correcto, mensaje_incorrecto, data);
	}
</script>