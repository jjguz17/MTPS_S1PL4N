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
                <th align="center" colspan="5">
                    <strong class="ti">
                        MINISTERIO DE TRABAJO Y PREVISIÓN SOCIAL<br />
                        DIRECCIÓN GENERAL DE PREVISIÓN SOCIAL Y EMPLEO<br />
                        DEPARTAMENTO DE SEGURIDAD E HIGIENE OCUPACIONAL<br />
                        SECCIÓN DE PREVENCIÓN DE RIESGOS OCUPACIONALES<br /><br />
                        CAPACITACIONES REALIZADAS POR LUGAR DE TRABAJO
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
                <th style="<?php echo $css;?>" width="200" valign="middle">LUGAR DE TRABAJO</th>
                <th style="<?php echo $css;?>" width="300" valign="middle">DIRECCIÓN COMPLETA</th>
                <th style="<?php echo $css;?>" width="80" valign="middle">SECTOR</th>
                <th style="<?php echo $css;?>" width="85" valign="middle">TOTAL CAPACITADOS</th>
                <th style="<?php echo $css;?>" width="85" valign="middle">TOTAL BENEFICIADOS</th>
                <th style="<?php echo $css;?>" width="200" valign="middle">LUGAR CAPACITACIÓN</th>
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
               	<th class="desktop">FECHA DE PROMOCIÓN</th>
                <th class="all">LUGAR DE TRABAJO</th>
                <th class="none">DIRECCIÓN COMPLETA</th>
                <th class="none">SECTOR</th>
                <th class="none">TOTAL CAPACITADOS</th>
                <th class="none">TOTAL BENEFICIADOS</th>
                <th class="none">LUGAR CAPACITACIÓN</th>
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
                 	<td valign="middle" style="<?php echo $css;?>" align="center"><?php echo $val['fecha_capacitacion']?></td>
                	<td valign="middle" style="<?php echo $css;?>" align="left"><?php echo $val['nombre_lugar']?></td>
                	<td valign="middle" style="<?php echo $css;?>" align="left"><?php echo ucwords($val['direccion_lugar'])?></td>
                	<td valign="middle" style="<?php echo $css;?>" align="left"><?php echo $val['nombre_sector']?></td>
                	<td valign="middle" style="<?php echo $css;?>" align="right"><?php echo $val['total_capacitados']?></td>
                	<td valign="middle" style="<?php echo $css;?>" align="right"><?php echo $val['total_empleados']?></td>
                	<td valign="middle" style="<?php echo $css;?>" align="left"><?php echo $val['lugar_capacitacion']?></td>
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