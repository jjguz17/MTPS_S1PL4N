<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="shortcut icon" href="images/ico.ico" type="image/png">
</head>
<body>
    <table align="center" border="0" cellspacing="0" style="width:100%;">
        <tr>
            <td align="left">
                <img id="imagen" src="img/mtps_report2.jpg" />
            </td>
            <td align="right">
                <img id="escudo" src="img/escudo.min.gif" />
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center">
            	<strong style="font-size:20px">ACREDITACION</strong>
            </td>
        </tr>
  	</table>
    <p>
        EL MINISTERIO DE TRABAJO Y PREVISION SOCIAL A TRAVÉS DE LA DIRECCIÓN GENERAL DE PREVISIÓN SOCIAL, HACE CONSTAR QUE EL DÍA: <strong><?=$this->promocion_model->fecha_letras($lugar_trabajo['fecha_capacitacion'])?></strong> BRINDÓ LA CAPACITACIÓN  INICIAL  ESTIPULADA EN EL ARTICULO 15 DE LA LEY GENERAL DE PREVENCIÓN DE RIESGOS EN LOS LUGARES DE TRABAJO, A <strong><?=$lugar_trabajo['nombre_empleado']?></strong> EN SU CALIDAD DE MIEMBRO DEL COMITÉ DE SEGURIDAD Y SALUD OCUPACIONAL DEL LUGAR DE TRABAJO DENOMINADO <strong><?=$lugar_trabajo['nombre_lugar']?></strong> PROPIEDAD DE <strong><?=$lugar_trabajo['nombre_institucion']?></strong>.
    </p>
    <br />
    <p>
        por lo que la dirección general de previsión social, otorga a <strong><?=$lugar_trabajo['nombre_empleado']?></strong>,  LA PRESENTE <strong>ACREDITACION</strong> como miembro del comité de seguridad y salud ocupacional de: <strong><?=$lugar_trabajo['nombre_lugar']?></strong> PROPIEDAD DE <strong><?=$lugar_trabajo['nombre_institucion']?></strong>.
    </p>
    <br />
    <p>
        TENIENDO LAS RESPONSABILIDADES ESTABLECIDAS EN LA LEY GENERAL DE PREVENCION DE RIESGOS EN LOS LUGARES DE TRABAJO Y LOS REGLAMENTOS DE EJECUCION.
    </p>
    <br />
    <p>
        <strong>LOS MIEMBROS DEL COMITÉ, ASI COMO LOS DELEGADOS DE PREVENCION DURARAN EN SUS FUNCIONES, DENTRO DEL COMITÉ, DOS AÑOS. A PARTIR DE SU ACREDITACION.</strong>
    </p>    
    <br />
    <br />
    <p class="extendido">
		Extiendo en <?php 
					$fec=explode("-",$lugar_trabajo['fecha_acreditacion']);
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
					
				?>
            <?php echo $depto; ?>, 
            <?php echo $fec[2] ?> de 
            <?php echo $mes." ".$fec[0]?> 
    </p>
    <table align="center">
    	<tr>
        	<td align="center">
                	<br style="display:block;"/>
                    <br style="display:block;"/>
                    <br style="display:block;"/>
            	<img src="img/firma_gerencia.png" style="display:none;"/><br />
                <p>
	                f. _______________________________________<br />
	                LICDA. NORA DEL CARMEN LÓPEZ LAÍNEZ<br />
	                <strong>DIRECTORA GENERAL DE PREVISIÓN SOCIAL Y EMPLEO</strong>
	            </p>
            </td>
        </tr>
    </table>
</body>
</html>