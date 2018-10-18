<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
	<?php
    	foreach($capacitacion as $val) {
			$id=$val['id_empleado_institucion'];
			$ids[$id]=1;
			$id=$val['id_empleado'];
			$ide[$id]=1;
		}
		
		switch($id_seccion) {
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
    <table align="center" border="0" cellspacing="0" style="width:100%;">
        <tr>
            <td align="left" id="imagen" width="150">
                <img src="img/mtps_report.jpg" />
            </td>
            <td align="center">
            	<strong class="ti">
                	MINISTERIO DE TRABAJO Y PREVISIÓN SOCIAL<br />
                    DIRECCIÓN GENERAL DE PREVISIÓN SOCIAL Y EMPLEO<br />
                    DEPARTAMENTO DE SEGURIDAD E HIGIENE OCUPACIONAL<br />
                    SECCIÓN DE PREVENCIÓN DE RIESGOS OCUPACIONALES<br />
                    OFICINA DEPARTAMENTAL DE <?=strtoupper($depto)?>
                </strong>
            </td>
            <td align="right" width="150">
                <img src="img/escudo.min.gif" />
            </td>
        </tr>
 	</table>
    <table align="center" border="0" cellspacing="0" style="width:100%;">
        <tr>
        	<td>
            	FECHA:
            </td>
        	<td class="cabe">
            	<?=$this->promocion_model->fecha_letras($capacitacion['fecha_capacitacion2'])?>
            </td>
        </tr>
        <tr>
        	<td>
            	TÉCNICO(S):
            </td>
        	<td class="cabe">
            	<?php
					$i=0;
					foreach($capacitacion as $val) {
						$id=$val['id_empleado'];
						if($ide[$id]==1) {
							if($i>0)
								echo " - ";
							echo $val['nombre'];
							$ide[$id]=0;
						}
						$i++;
					}
				?>
            </td>
        </tr>
        <tr>
        	<td>
            	NOMBRE DE LA EMPRESA O INSTITUCIÓN:
            </td>
        	<td class="cabe">
            	<?=$capacitacion[0]['nombre_lugar']?>
            </td>
        </tr>
  	</table>
    <br />
    <table align="center" border="1" cellspacing="0" style="width:100%;">
    	<thead>
        	<tr>
            	<th width="50">No.</th>
            	<th>Nombre del participante</th>
            	<th>Cargo en la empresa o institución</th>
            	<th width="200">Firma</th>
            </tr>
        </thead>
        <tbody>
        	<?php
					$i=1;
					foreach($capacitacion as $val) {
						$id=$val['id_empleado_institucion'];
						if($ids[$id]==1) {
							echo "<tr><td height='30' align='right'>".$i."</td><td>".$val['nombre_empleado']."</td><td>".$val['cargo_empleado']."</td><td></td></tr>";
							$ids[$id]=0;
							$i++;
						}
					}
				?>
        </tbody>
    </table>
</body>
</html>