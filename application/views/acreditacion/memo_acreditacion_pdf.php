<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="shortcut icon" href="images/ico.ico" type="image/png">
</head>
<body>
	<table align="center" border="0" cellspacing="0" style="width:100%; border-bottom:3px solid #000">
        <tr>
        	<td align="center" colspan="2">
            	<strong id="titu_memo_2">MEMORANDUM</strong>
            </td>
        </tr>
        <tr>
        	<td id="fecha_2" valign="top" width="150">
            	<br />
        		PARA:
        	</td>
        	<td id="fecha_2">
        		<br />
        		LICDA. NORA DEL CARMEN LÓPEZ LAÍNEZ
        		<br />
        		DIRECTORA GENERAL DE PREVISIÓN SOCIAL Y EMPLEO
        	</td>
        </tr>>
        <tr>
        	<td id="fecha_2" valign="top">
            	<br />
        		DE:
        	</td>
        	<td id="fecha_2">
        		<br />
        		ING. JUAN CARLOS SERRANO
        		<br />
        		JEFE DE SECCIÓN DE PREVENCIÓN DE RIESGOS OCUPACIONALES
        	</td>
        </tr>>
        <tr>
        	<td id="fecha_2" valign="top">
            	<br />
        		ASUNTO:
        	</td>
        	<td id="fecha_2">
        		<br />
        		SOLICITAR FIMAS PARA ACREDITACIONES DE COMITÉ DE SEGURIDAD Y SALUD OCUPACIONAL DE:
        		<br />
        		<br />
        		LUGAR DE TRABAJO: <strong id="fecha_2"><?=$memo['nombre_lugar']?></strong>
        		<br />
        		PROPIEDAD DE: <strong id="fecha"><?=$memo['nombre_institucion']?></strong>
        	</td>
        </tr>
        <tr>
        	<td id="fecha_2" valign="top">
            	<br />
        		FECHA:
        	</td>
        	<td id="fecha_2">
        		<br />
            	<?php 
					/*$fec=explode("-",$memo['fecha_conformacion']);*/
					$fec=explode("-",date('Y-m-d'));
					switch($fec[1]) {
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
					echo $depto.", ".$fec[2]." de ". $mes." de ".$fec[0];
				?> 
				<br />
            </td>
        </tr>
  	</table>
  	<br />
  	<span id="fecha_3">Atentamente, solicito firma para Acreditaciones de Comité de la empresa mencionada:</span>
  	<br /><br />
  	<table align="center" style="border-collapse:collapse; border: none; width:100%; ">
  		<tr>
  			<td align="center" style="border:1px solid #000; padding: 5px;"><strong>No.</strong></td>
  			<td align="center" style="border:1px solid #000; padding: 5px;"><strong>NOMBRE</strong></td>
  			<td align="center" style="border:1px solid #000; padding: 5px;"><strong>CARGO EN COMITÉ</strong></td>
  		</tr>
  		<?php
  			$i=0;
  			foreach($empleados as $val) {
  				$i++;
  		?>
  				<tr>
		  			<td align="center" style="border:1px solid #000; padding: 5px;"><?=$i?></td>
		  			<td align="center" style="border:1px solid #000; padding: 5px; text-transform: uppercase;"><?=$val['nombre_empleado']?></td>
		  			<td align="center" style="border:1px solid #000; padding: 5px; text-transform: uppercase;"><?=$val['cargo_comite']?></td>
		  		</tr>
  		<?php
	        }
  		?>
  	</table>
</body>
</html>