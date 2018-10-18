<span class="glyphicon glyphicon-info-sign"></span> INFORMACIÓN GENERAL
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
        	<td align="right"><?=$total_comite?></td>
        	<td align="right"><?=$total_empleados?></td>
        </tr>
    	<tr>
        	<td>Hombres</td>
        	<td align="right"><?=$total_comite_hombres?></td>
        	<td align="right"><?=$total_empleados_hombres?></td>
        </tr>
    	<tr>
        	<td>Mujeres</td>
        	<td align="right"><?=$total_comite_mujeres?></td>
        	<td align="right"><?=$total_empleados_mujeres?></td>
        </tr>
    </tbody>
</table>
<span class="glyphicon glyphicon-exclamation-sign"></span> REQUISITOS
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
        	<td align="right"><?=$total_comite?></td>
        	<td align="right"><?=($total_empleados_representantes*2)?></td>
            <td align="center"><?php if($total_comite>=($total_empleados_representantes*2)) echo '<span class="fa fa-check" style="color:#1caf9a;" title="Cumple requisito"></span>'; else echo '<span class="glyphicon glyphicon-remove" style="color:#F00;" title="No cumple requisito"></span>';?></td>
        </tr>
    	<tr>
        	<td>Representantes de empleador</td>
        	<td align="right"><?=$total_comite_representantes_empleador?></td>
        	<td align="right"><?=$total_empleados_representantes?></td>
            <td align="center"><?php if($total_comite_representantes_empleador>=$total_empleados_representantes) echo '<span class="fa fa-check" style="color:#1caf9a;" title="Cumple requisito"></span>'; else echo '<span class="glyphicon glyphicon-remove" style="color:#F00;" title="No cumple requisito"></span>';?></td>
        </tr>
    	<tr>
        	<td>Representantes de trabajadores</td>
        	<td align="right"><?=$total_comite_representantes_trabajadores+$total_comite_sindicato?></td>
        	<td align="right"><?=$total_empleados_representantes?></td>
            <td align="center"><?php if($total_comite_representantes_trabajadores+$total_comite_sindicato>=$total_empleados_representantes) echo '<span class="fa fa-check" style="color:#1caf9a;" title="Cumple requisito"></span>'; else echo '<span class="glyphicon glyphicon-remove" style="color:#F00;" title="No cumple requisito"></span>';?></td>
        </tr>
    	<tr>
        	<td>Delegados de prevención</td>
        	<td align="right"><?=$total_comite_delegados?></td>
        	<td align="right"><?=$total_empleados_delegados?></td>
            <td align="center"><?php if($total_comite_delegados>=$total_empleados_delegados) echo '<span class="fa fa-check" style="color:#1caf9a;" title="Cumple requisito"></span>'; else echo '<span class="glyphicon glyphicon-remove" style="color:#F00;" title="No cumple requisito"></span>';?></td>
        </tr>
    	<tr>
        	<td>Miembros del sindicato</td>
        	<td align="right"><?=$total_comite_sindicato?></td>
        	<td align="right"><?=$sindicato?></td>
            <td align="center"><?php if($total_comite_sindicato>=$sindicato) echo '<span class="fa fa-check" style="color:#1caf9a;" title="Cumple requisito"></span>'; else echo '<span class="glyphicon glyphicon-remove" style="color:#F00;" title="No cumple requisito"></span>';?></td>
        </tr>
    </tbody>
</table>