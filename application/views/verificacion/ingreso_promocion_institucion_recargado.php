<table class="table table-hover mb30">
    <thead>
        <tr>
            <th class="all">Temática</th>
            <th class="desktop tablet-l tablet-p" style="width:130px">Impartida</th>
            <th class="desktop tablet-l tablet-p" style="width:135px">Fecha</th>
            <th class="desktop tablet-l tablet-p" style="width:330px">Facilitador</th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach($tematicas as $val) {
                echo '<tr class="tr"><td>'.$val['nombre'].'</td><td><div class="ckbox ckbox-success"><input type="checkbox" class="chk" name="id_tematica[]" id="id_tematica_'.$val['id'].'" value="'.$val['id'].'" ';
                if($val['delegado']==1) echo ' checked="checked"';
                echo' /><label for="id_tematica_'.$val['id'].'"></label></div></td>
                    <td>
                        <input type="hidden" class="tematica_real" value="'.$val['id'].'" name="id_tematica_real[]" id="id_tematica_real_'.$val['id'].'" disabled="disabled" >
                        <div class="form-group">
                            <div class="col-sm-12">
                                <div class="input-group fechas">
                                    <input data-req="true" data-tip="fec" type="text" class="form-control" id="fecha_capacitacion_'.$val['id'].'" name="fecha_capacitacion[]" readonly="readonly" disabled="disabled" value=" " style="background-color: #FFF !important;" />
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <div class="col-sm-12 facilitador">
                                <input type="text" data-req="true" class="form-control" name="facilitador[]" id="facilitador_'.$val['id'].'" disabled="disabled" value=" " style="background-color: #FFF !important;" />
                            </div>
                        </div>
                    </td>
                </tr>';
            }
        ?>
    </tbody>
</table>
<div class="ckbox ckbox-success"><input type="checkbox" name="sel-todo" id="sel-todo"  /><label for="sel-todo">Seleccionar/Deseleccionar todo</label></div> 
<script language="javascript" >
	$(document).ready(function(){
		$('.table').dataTable( {
          "filter": false,
          "paginate": false,
          "destroy": true,
          responsive: true,
          sort: false,
          info: false
        });
        $('#sel-todo').click(function(){
            $('.chk').prop('checked', $(this).prop('checked'));
            $('.chk').change();
        });
        $('.fechas input').datepicker({beforeShowDay: $.datepicker.noWeekends, maxDate: '0D'});
        $('.chk').change(function(){
            var $padre=$(this).parents('.tr');
            var $fec=$padre.find('.fechas input');
            var $fac=$padre.find('.facilitador input');
            var $tem=$padre.find('.tematica_real');
            if($(this).prop('checked')) {
                $fec.attr("disabled",false);
                $fac.attr("disabled",false);
                $tem.attr("disabled",false);
                $fec.val("<?=date('d/m/Y')?>");
                $fac.val('');
            }
            else {
                $fec.attr("disabled",true);
                $fac.attr("disabled",true);
                $tem.attr("disabled",true);
                $fec.val(' ');
                $fac.val(' ');
            }
        });
	});
</script>