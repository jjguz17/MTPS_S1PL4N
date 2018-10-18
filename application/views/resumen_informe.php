<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
	if($exportacion==3) {
		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=".$nombre.".xls");
		header("Pragma: no-cache");
		header("Expires: 0");
	}
	switch($mes) {
		case 1: 
			$mes="Enero";
			break;
		case 2:
			$mes="Febreo";
			break;
		case 3: 
			$mes="Marzo";
			break;
		case 4: 
			$mes="Abril";
			break;
		case 5: 
			$mes="Mayo";
			break;
		case 6: 
			$mes="Junio";
			break;
		case 7: 
			$mes="Julio";
			break;
		case 8: 
			$mes="Agosto";
			break;
		case 9: 
			$mes="Septiembre";
			break;
		case 10: 
			$mes="Octubre";
			break;
		case 11: 
			$mes="Noviembre";
			break;
		case 12: 
			$mes="Diciembre";
			break;
	}

	switch(date('m')) {
		case 1: 
			$m="Enero";
			break;
		case 2:
			$m="Febreo";
			break;
		case 3: 
			$m="Marzo";
			break;
		case 4: 
			$m="Abril";
			break;
		case 5: 
			$m="Mayo";
			break;
		case 6: 
			$m="Junio";
			break;
		case 7: 
			$m="Julio";
			break;
		case 8: 
			$m="Agosto";
			break;
		case 9: 
			$m="Septiembre";
			break;
		case 10: 
			$m="Octubre";
			break;
		case 11: 
			$m="Noviembre";
			break;
		case 12: 
			$m="Diciembre";
			break;
	}

	switch($id_seccion)
	{
		case 52:
		$depto="Ahuachapán";
		break;
		case 53:
		$depto="Cabañas";
		break;
		case 54:
		$depto="Chalatenango";
		break;
		case 55:
		$depto="Cuscatlán";
		break;
		case 56:
		$depto="La Libertad";
		break;
		case 57:
		$depto="La Unión";
		break;
		case 58:
		$depto="Morazán";
		break;
		case 59:
		$depto="San Vicente";
		break;
		case 60:
		$depto="Sonsonate";
		break;
		case 61:
		$depto="Usulután";
		break;
		case 64:
		$depto="Zacatecoluca";
		break;
		case 65:
		$depto="San Miguel";
		break;
		case 66:
		$depto="Santa Ana";
		break;
		default:
		$depto="San Salvador";
		break;
	}
?>
<table align="center">
	<tr>
		<td width="50"></td>
		<td width="130"></td>
		<td width="470"></td>
		<td width="70"></td>
		<td width="70"></td>
		<td width="70"></td>
	</tr>
	<tr>
		<td colspan="2" height="100" width="180"><img id="imagen" src="<?=base_url()?>img/mtps_report2.jpg" width="180" /></td>
		<td colspan="2" width="760" align="center">
			<strong>MINISTERIO DE TRABAJO Y PREVISION SOCIAL</strong><br>
			<strong>DIRECCION GENERAL DE PREVISION SOCIAL</strong><br>
			<strong>DEPARTAMENTO DE SEGURIDAD E HIGIENE OCUPACIONAL</strong><br>
			<strong>SECCIÓN DE PREVENCIÓN DE RIESGOS OCUPACIONALES</strong><br>
		</td>
		<td colspan="2"></td>
	</tr>
	<tr>
		<td colspan="6" align="right"><strong><?=$depto.", ".date('d')." de ".$m." de ".date('Y')?></strong></td>
	</tr>
	<tr>
		<td colspan="6">
			<strong>
				Ingeniero<br>
				<?=ltrim(ucwords($nombre_jefe['nombre_jefe']))?><br>				
				Jefe del Departamento de Seguridad e Higiene Ocupacional<br>
				Oficina Central<br>&nbsp;
			</strong>
		</td>
	</tr>
	<tr>
		<td colspan="6" align="justify">
			Atentamente Informo de las Actividades Realizadas en la Sección de Prevención de Riesgos Ocupacionales de la Oficina Departamental de <strong><?=$depto?></strong>, Correspondiente al Mes de <strong><?=$mes?></strong> del año <strong><?=$anio?></strong>.<br>&nbsp;
		</td>
	</tr>
	<?php
        foreach($resumen_informe_general as $val) {
    ?>
		    <tr>
				<td valign="middle" width="50"><?php if($val['idh']==0) echo '<strong>'.$val['idp'].'.</strong>';?></td>
				<td valign="middle" width="600" colspan="2"><?php if($val['idh']==0) echo '<strong>'.$val['tipo'].'</strong>'; else echo $val['tipo']?></td>
				<td valign="middle" width="70"></td>
				<td valign="middle" width="70" align="center" <?php if($val['subtotal']!="") echo 'style="border:1px solid #CCC;"'?>><?='<strong>'.$val['subtotal'].'</strong>'?></td>
				<td valign="middle" width="70" align="center" <?php if($val['subtotal']=="" && $val['total']!="") echo 'style="border:1px solid #CCC;"'?>><?='<strong>'.$val['total'].'</strong>'?></td>
			</tr>
    <?php
        }
    ?>
	<tr>
		<td colspan="6" align="center" height="60">
			<?='<strong style="text-transform: capitalize;">'.strtolower($this->session->userdata('nombre')).'</strong>'?><br>
			<?=ucwords($puesto['nominal'])?>
		</td>
	</tr>
</table>
<table align="center" border="1">
	<tr style="background-color: beige;">
		<td colspan="5" align="center">
			<strong>PROMOCIÓN DE COMITÉS</strong>
		</td>
	</tr>
	<tr style="background-color: beige;">
		<td valign="middle" align="center" width="50"><strong>N°</strong></td>
		<td valign="middle" align="center" width="600"><strong>EMPRESA</strong></td>
		<td valign="middle" align="center" width="140" colspan="2"><strong>CIIU</strong></td>
		<td valign="middle" align="center" width="70"><strong>ENTREVISTAS</strong></td>
	</tr>
	<?php
		$i=0;
		$total=0;
        foreach($resumen_informe_promocion as $val) {
        	if($val['direccion_lugar']!="" && $val['ciiu4']!="" && $val['codigo']!="" && $val['total']!="") {
    			$i++;
    			$total=$total+$val['total'];
    ?>
			    <tr>
					<td valign="middle" width="50" align="center"><?=$i?></td>
					<td valign="middle"><?=$val['direccion_lugar']?></td>
					<td valign="middle" width="70" align="center"><?=$val['ciiu4']?></td>
					<td valign="middle" width="70" align="center"><?=$val['codigo']?></td>
					<td valign="middle" width="70" align="center"><?=$val['total']?></td>
				</tr>
    <?php
			}
        }
        if($i==0) {
    ?>
    		<tr>
				<td colspan="5" align="center">
					(No se encontraron registros)
				</td>
			</tr>
    <?php
        }
        else {
    ?>
    		<tr>
				<td colspan="4" align="right">
					<strong>TOTAL</strong>
				</td>
				<td align="center"><?=$total?></td>
			</tr>
    <?php   
        }
    ?>
</table>
<br><br>
<table align="center" border="1">
	<tr style="background-color: beige;">
		<td colspan="5" align="center">
			<strong>VERIFICACION ART.10 DECRETO 86</strong>
		</td>
	</tr>
	<tr style="background-color: beige;">
		<td valign="middle" align="center" width="50"><strong>N°</strong></td>
		<td valign="middle" align="center" width="600"><strong>EMPRESA</strong></td>
		<td valign="middle" align="center" width="140" colspan="2"><strong>CIIU</strong></td>
		<td valign="middle" align="center" width="70"><strong>ESTADO</strong></td>
	</tr>
	<?php
		$i=0;
		$j=0;
		$total=0;
        foreach($resumen_informe_verificacion as $val) {
        	if($val['direccion_lugar']!="" && $val['ciiu4']!="" && $val['codigo']!="" && $val['nombre_estado_verificacion']!="") {
    			$i++;
    			$j++;
    			$total=$total+$j;
    ?>
			    <tr>
					<td valign="middle" width="50" align="center"><?=$i?></td>
					<td valign="middle"><?=$val['direccion_lugar']?></td>
					<td valign="middle" width="70" align="center"><?=$val['ciiu4']?></td>
					<td valign="middle" width="70" align="center"><?=$val['codigo']?></td>
					<td valign="middle" width="70" align="center"><?=$val['nombre_estado_verificacion']?></td>
				</tr>
    <?php
    		}
        }
        if($j==0) {
    ?>
    		<tr>
				<td colspan="5" align="center">
					(No se encontraron registros)
				</td>
			</tr>
    <?php
        }
        else {
    ?>
    		<tr>
				<td colspan="4" align="right">
					<strong>TOTAL</strong>
				</td>
				<td align="center"><?=$total?></td>
			</tr>
    <?php   
        }
    ?>
</table>
<br><br>
<table align="center" border="1">
	<tr style="background-color: beige;">
		<td colspan="4" align="center">
			<strong>EMPRESAS CAPACITADAS</strong>
		</td>
		<td colspan="3" align="center">
			<strong>TRABAJADORES CAPACITADOS</strong>
		</td>
		<td colspan="3" align="center">
			<strong>TRABAJADORES BENEFICIADOS</strong>
		</td>
	</tr>
	<tr style="background-color: beige;">
		<td valign="middle" align="center" width="50"><strong>N°</strong></td>
		<td valign="middle" align="center" width="600"><strong>EMPRESA</strong></td>
		<td valign="middle" align="center" width="140" colspan="2"><strong>CIIU</strong></td>
		<td valign="middle" align="center" width="70"><strong>HOMBRES</strong></td>
		<td valign="middle" align="center" width="70"><strong>MUJERES</strong></td>
		<td valign="middle" align="center" width="70"><strong>TOTAL</strong></td>
		<td valign="middle" align="center" width="70"><strong>HOMBRES</strong></td>
		<td valign="middle" align="center" width="70"><strong>MUJERES</strong></td>
		<td valign="middle" align="center" width="70"><strong>TOTAL</strong></td>
	</tr>
	<?php
		$i=1;
		$total_hombres_capacitados=0;
		$total_mujeres_capacitados=0;
		$total_capacitados=0;
		$total_hombres_beneficiados=0;
		$total_mujeres_beneficiados=0;
		$total_beneficiados=0;
        foreach($resumen_informe_capacitacion as $val) {
			$total_hombres_capacitados=$total_hombres_capacitados+$val['total_hombres_capacitados'];
			$total_mujeres_capacitados=$total_mujeres_capacitados+$val['total_mujeres_capacitados'];
			$total_capacitados=$total_capacitados+$val['total_capacitados'];
			$total_hombres_beneficiados=$total_hombres_beneficiados+$val['total_hombres_beneficiados'];
			$total_mujeres_beneficiados=$total_mujeres_beneficiados+$val['total_mujeres_beneficiados'];
			$total_beneficiados=$total_beneficiados+$val['total_beneficiados'];
    ?>
		    <tr>
				<td valign="middle" width="50" align="center"><?=$i?></td>
				<td valign="middle"><?=$val['direccion_lugar']?></td>
				<td valign="middle" width="70" align="center"><?=$val['ciiu4']?></td>
				<td valign="middle" width="70" align="center"><?=$val['codigo']?></td>
				<td valign="middle" width="70" align="center"><?=$val['total_hombres_capacitados']?></td>
				<td valign="middle" width="70" align="center"><?=$val['total_mujeres_capacitados']?></td>
				<td valign="middle" width="70" align="center"><?=$val['total_capacitados']?></td>
				<td valign="middle" width="70" align="center"><?=$val['total_hombres_beneficiados']?></td>
				<td valign="middle" width="70" align="center"><?=$val['total_mujeres_beneficiados']?></td>
				<td valign="middle" width="70" align="center"><?=$val['total_beneficiados']?></td>
			</tr>
    <?php
    	$i++;
        }
        if($i==1) {
    ?>
    		<tr>
				<td colspan="10" align="center">
					(No se encontraron registros)
				</td>
			</tr>
    <?php
        }
        else {
    ?>
    		<tr>
				<td colspan="4" align="right">
					<strong>TOTAL</strong>
				</td>
				<td align="center"><?=$total_hombres_capacitados?></td>
				<td align="center"><?=$total_mujeres_capacitados?></td>
				<td align="center"><?=$total_capacitados?></td>
				<td align="center"><?=$total_hombres_beneficiados?></td>
				<td align="center"><?=$total_mujeres_beneficiados?></td>
				<td align="center"><?=$total_beneficiados?></td>
			</tr>
    <?php   
        }
    ?>
</table>
<br><br>
<table align="center" border="1">
	<tr style="background-color: beige;">
		<td colspan="4" align="center">
			<strong>COMITÉS ACREDITADOS (NUEVOS)</strong>
		</td>
		<td colspan="3" align="center">
			<strong>TRABAJADORES CAPACITADOS</strong>
		</td>
		<td colspan="3" align="center">
			<strong>TRABAJADORES BENEFICIADOS</strong>
		</td>
	</tr>
	<tr style="background-color: beige;">
		<td valign="middle" align="center" width="50"><strong>N°</strong></td>
		<td valign="middle" align="center" width="600"><strong>EMPRESA</strong></td>
		<td valign="middle" align="center" width="140" colspan="2"><strong>CIIU</strong></td>
		<td valign="middle" align="center" width="70"><strong>HOMBRES</strong></td>
		<td valign="middle" align="center" width="70"><strong>MUJERES</strong></td>
		<td valign="middle" align="center" width="70"><strong>TOTAL</strong></td>
		<td valign="middle" align="center" width="70"><strong>HOMBRES</strong></td>
		<td valign="middle" align="center" width="70"><strong>MUJERES</strong></td>
		<td valign="middle" align="center" width="70"><strong>TOTAL</strong></td>
	</tr>
	<?php
		$i=1;
		$total_hombres_capacitados=0;
		$total_mujeres_capacitados=0;
		$total_capacitados=0;
		$total_hombres_beneficiados=0;
		$total_mujeres_beneficiados=0;
		$total_beneficiados=0;
        foreach($resumen_informe_acreditacion as $val) {
			$total_hombres_capacitados=$total_hombres_capacitados+$val['total_hombres_capacitados'];
			$total_mujeres_capacitados=$total_mujeres_capacitados+$val['total_mujeres_capacitados'];
			$total_capacitados=$total_capacitados+$val['total_capacitados'];
			$total_hombres_beneficiados=$total_hombres_beneficiados+$val['total_hombres_beneficiados'];
			$total_mujeres_beneficiados=$total_mujeres_beneficiados+$val['total_mujeres_beneficiados'];
			$total_beneficiados=$total_beneficiados+$val['total_beneficiados'];
    ?>
		    <tr>
				<td valign="middle" width="50" align="center"><?=$i?></td>
				<td valign="middle"><?=$val['direccion_lugar']?></td>
				<td valign="middle" width="70" align="center"><?=$val['ciiu4']?></td>
				<td valign="middle" width="70" align="center"><?=$val['codigo']?></td>
				<td valign="middle" width="70" align="center"><?=$val['total_hombres_capacitados']?></td>
				<td valign="middle" width="70" align="center"><?=$val['total_mujeres_capacitados']?></td>
				<td valign="middle" width="70" align="center"><?=$val['total_capacitados']?></td>
				<td valign="middle" width="70" align="center"><?=$val['total_hombres_beneficiados']?></td>
				<td valign="middle" width="70" align="center"><?=$val['total_mujeres_beneficiados']?></td>
				<td valign="middle" width="70" align="center"><?=$val['total_beneficiados']?></td>
			</tr>
    <?php
    	$i++;
        }
        if($i==1) {
    ?>
    		<tr>
				<td colspan="10" align="center">
					(No se encontraron registros)
				</td>
			</tr>
    <?php
        }
        else {
    ?>
    		<tr>
				<td colspan="4" align="right">
					<strong>TOTAL</strong>
				</td>
				<td align="center"><?=$total_hombres_capacitados?></td>
				<td align="center"><?=$total_mujeres_capacitados?></td>
				<td align="center"><?=$total_capacitados?></td>
				<td align="center"><?=$total_hombres_beneficiados?></td>
				<td align="center"><?=$total_mujeres_beneficiados?></td>
				<td align="center"><?=$total_beneficiados?></td>
			</tr>
    <?php   
        }
    ?>
</table>