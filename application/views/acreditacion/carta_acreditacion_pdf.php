<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="shortcut icon" href="images/ico.ico" type="image/png">
</head>
<body>
	<table align="center" border="0" cellspacing="0" style="width:100%;">
        <tr>
            <td align="center">
                <img id="escudo" src="img/escudo.min.gif" />
            </td>
        </tr>
        <tr>
        	<td align="center">
            	<strong id="titu_memo"><br />
            	Ministerio de Trabajo y Previsión Social<br />
                Dirección General de Previsión Social<br />
                Departamento de Seguridad e Higiene Ocupacional<br />
                Sección de Prevención de Riesgos Ocupacionales</strong>
            </td>
        </tr>
        <tr>
        	<td id="fecha" align="right">
            	<br /><br />
            	<?php 
					/*$fec=explode("-",$carta['fecha_conformacion']);*/
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
            </td>
        </tr>
  	</table>
    <p id="memoria">
    <br /><br />
    LUGAR DE TRABAJO: <strong id="fecha"><?=$carta['nombre_lugar']?></strong> PROPIEDAD DE: <strong id="fecha"><?=$carta['nombre_institucion']?></strong>
    <br /><br />
    TELÉFONO: <?=$carta['telefono_lugar']?>
    <br />
    DIRECCIÓN: <?=$carta['direccion_lugar']?>
    <br />
    <span style="text-transform: capitalize;"><?=$carta['municipio_lugar']?></span>
    <br /><br />
    SEÑOR (A), (ITA):
    <br />
    <?=$carta['nombre_empleado']?><br />
    <?=$carta['cargo_empleado']?><br />
    PRESENTE
    <br /><br />
    Remito Acreditaciones de Comité de Seguridad y Salud Ocupacional, debidamente autorizados por el Ministerio de Trabajo y Previsión Social.
    <br /><br />
    Agradeciendo el apoyo para la gestión del mismo, dando a conocer su funcionamiento en su empresa, de acuerdo a metodologías a implementar.
    <br /><br />
    Reiteramos nuestras felicitaciones y por la atención a la presente muchas gracias.
    <br /><br /><br /></p>
    <table align="center">
        <tr>
            <td align="center">
                <p id="memoria">
                    Atentamente,
                </p><br />
                	<br style="display:block;"/>
                    <br style="display:block;"/>
                    <br style="display:block;"/>
                    <img src="img/firma_jefatura.JPG" style="display:none;" />
                    <br />
                <p id="pie">
                	<strong>
                        Ing. Juan Carlos Serrano<br />
                        Jefe se Sección de Prevención de Riesgos Ocupacionales.
                    </strong>
                </p>
            </td>
        </tr>
    </table>
</body>
</html>