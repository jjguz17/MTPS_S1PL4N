<?php
if($exportacion==3) {
	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=".$nombre.".xls");
	header("Pragma: no-cache");
	header("Expires: 0");
}
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php 
	if($exportacion==2 || $exportacion==3) {
		if($exportacion==3) {
?>
    <table align="center" border="0" cellspacing="0" cellpadding="0" style="width:100%;">
    	 <thead>
            <tr>
                <th align="left" id="imagen" colspan="2" height="110">
                    <img src="<?=base_url()?>img/mtps_report.jpg" />
                </th>
                <th align="center" colspan="7">
                    <strong class="ti">
                        MINISTERIO DE TRABAJO Y PREVISIÓN SOCIAL<br />
                        DIRECCIÓN GENERAL DE PREVISIÓN SOCIAL Y EMPLEO<br />
                        DEPARTAMENTO DE SEGURIDAD E HIGIENE OCUPACIONAL<br />
                        SECCIÓN DE PREVENCIÓN DE RIESGOS OCUPACIONALES<br /><br />
                        VERIFICACIONES REALIZADAS POR LUGAR DE TRABAJO
                    </strong>
                </th>
                <th align="right">
                    <img src="<?=base_url()?>img/escudo.min.gif" style="position:absolute; right:0"/>
                </th>
            </tr>
            <tr>
            	<th colspan="8" align="center">&nbsp;</th>
            </tr>
<?php
		}
		else {
?>
	<table align="center" border="0" cellspacing="0" cellpadding="0" style="width:100%;">
    	 <thead>
<?php
		}
?>
            <tr>
            	<?php
					$css='';
					if($exportacion==2 || $exportacion==3) {
						$css='background-color: #CCC; border: 1px solid #CCC;';
					}
				?>
               	<th style="<?php echo $css;?>" width="25" valign="middle">N°</th>
               	<th style="<?php echo $css;?>" width="80" valign="middle">FECHA</th>
               	<th style="<?php echo $css;?>" width="80" valign="middle">HORA</th>
                <th style="<?php echo $css;?>" width="150" valign="middle">LUGAR DE TRABAJO</th>
                <th style="<?php echo $css;?>" width="150" valign="middle">DIRECCIÓN COMPLETA</th>
                <th style="<?php echo $css;?>" width="100" valign="middle">ATENDIÓ</th>
                <th style="<?php echo $css;?>" width="<?php if($exportacion==3) echo '300'; else echo '150'?>" valign="middle">RESULTADO DE LA VISITA</th>
                <th style="<?php echo $css;?>" width="100" valign="middle">ESTADO</th>
                <th style="<?php echo $css;?>" width="<?php if($exportacion==3) echo '500'; else echo '200'?>" valign="middle">MIEMBROS ENTREVISTADOS</th>
                <th style="<?php echo $css;?>" width="<?php if($exportacion==3) echo '900'; else echo '500'?>" valign="middle">TEMÁTICAS IMPARTIDAS</th>
            </tr>
        </thead>
<?php 
	}
	if($exportacion!=2 && $exportacion!=3) {
?>   
    <table class="display table responsive no-wrap" style="width: 100%;">
        <thead>
        	<tr>
               	<th class="all" width="50">N°</th>
               	<th class="desktop">FECHA DE VERIFICACIÓN</th>
               	<th class="none">HORA DE VERIFICACIÓN</th>
                <th class="all">LUGAR DE TRABAJO</th>
                <th class="none">DIRECCIÓN COMPLETA</th>
                <th class="none">ATENDIÓ</th>
                <th class="none">RESULTADO DE LA VISITA</th>
                <th class="all">ESTADO</th>
                <th class="none">MIEMBROS ENTREVISTADOS</th>
                <th class="none">TEMÁTICAS IMPARTIDAS</th>
            </tr>
        </thead>
<?php
	}
?>
        <tbody>
            <?php
                foreach($info as $val) {
			?>
            	<tr valign="middle" style="cursor: pointer;" class="ver_promociones" data-id="<?php echo $val['id_promocion']?>">
					<?php
						$css="";
                        if($exportacion==2 || $exportacion==3) {
							$css='border: 1px solid #CCC;';
                        }
                    ?>
                 	<td valign="middle" style="<?php echo $css;?>" align="left"><?php echo $val['numero']?></td>
                 	<td valign="middle" style="<?php echo $css;?>" align="center"><?php echo $val['fecha_promocion']?></td>
                	<td valign="middle" style="<?php echo $css;?>" align="center"><?php echo $val['hora_promocion']?></td>
                	<td valign="middle" style="<?php echo $css;?>" align="left"><?php echo $val['nombre_lugar']?></td>
                	<td valign="middle" style="<?php echo $css;?>" align="left"><?php echo ucwords($val['direccion_lugar'])?></td>
                	<td valign="middle" style="<?php echo $css;?>" align="left"><?php echo $val['nombre_recibio']?></td>
                	<td valign="middle" style="<?php echo $css;?>" align="left"><?php echo $val['observaciones']?></td>
                	<td valign="middle" style="<?php echo $css;?>" align="left"><?php echo $val['nombre_estado_verificacion']?></td>
                    <td valign="middle" style="<?php echo $css;?>" align="left"><?php 
                                                                                        $ent=explode(",", $val['entrevistados']);
                                                                                        //echo "<ul>";
                                                                                        for ($i=0; $i <count($ent) ; $i++) { 
                                                                                            echo "<li>".$ent[$i]."</li>";
                                                                                        }
                                                                                        //echo "</ul>";
                                                                                ?></td>
                	<td valign="middle" style="<?php echo $css;?>" align="left"><?php 
                                                                                        $ent=explode(",", $val['tematicas']);
                                                                                        //echo "<ul>";
                                                                                        for ($i=0; $i <count($ent) ; $i++) { 
                                                                                            echo "<li>".$ent[$i]."</li>";
                                                                                        }
                                                                                        //echo "</ul>";
                                                                                ?></td>
                </tr>
            <?php
                }
            ?>
        </tbody>
    </table>
<?php if($exportacion==1) { ?>
<script>
	$('.table').DataTable({
		"sPaginationType": "simple",
		responsive: true
	});
	$("select").chosen({
		'width': '100%',
		'min-width': '100px',
		'white-space': 'nowrap',
		no_results_text: "Sin resultados!"
	});
</script>
<?php } ?>