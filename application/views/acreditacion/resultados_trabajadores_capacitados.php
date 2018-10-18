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
                <th align="left" id="imagen" height="110" width="180" colspan="2">
                    <img src="<?=base_url()?>img/mtps_report.jpg" />
                </th>
                <th align="center" colspan="4">
                    <strong class="ti">
                        MINISTERIO DE TRABAJO Y PREVISIÓN SOCIAL<br />
                        DIRECCIÓN GENERAL DE PREVISIÓN SOCIAL Y EMPLEO<br />
                        DEPARTAMENTO DE SEGURIDAD E HIGIENE OCUPACIONAL<br />
                        SECCIÓN DE PREVENCIÓN DE RIESGOS OCUPACIONALES<br /><br />
                        CAPACITACIONES POR EMPLEADO
                    </strong>
                </th>
                <th align="right">
                    <img src="<?=base_url()?>img/escudo.min.gif" style="position:absolute; right:0"/>
                </th>
            </tr>
            <tr>
            	<th colspan="3" align="center">&nbsp;</th>
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
                <th style="<?php echo $css;?>" width="100">DUI</th>
                <th style="<?php echo $css;?>" width="200">NOMBRE</th>
                <th style="<?php echo $css;?>" width="70">GÉNERO</th>
                <th style="<?php echo $css;?>" width="105">REPRESENTACIÓN</th>
                <th style="<?php echo $css;?>" width="200">LUGAR DE TRABAJO</th>
                <th style="<?php echo $css;?>" width="100">FECHA CAPACITACIÓN</th>
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
                <th class="all">DUI</th>
                <th class="all">NOMBRE</th>
                <th class="none">GÉNERO</th>
                <th class="none">REPRESENTACIÓN</th>
                <th class="all">LUGAR DE TRABAJO</th>
                <th class="none">FECHA CAPACITACIÓN</th>
            </tr>
        </thead>
<?php 
	}
?> 
        <tbody>
            <?php
                foreach($info as $val) {
			?>
            	<tr>
                	<?php
						$css="";
						$cs="";
                        if($exportacion==2 || $exportacion==3) {
							$css='border: 1px solid #CCC;';
							$cs='colspan="2"';
                        }
                    ?>
                    <td valign="middle" style="<?php echo $css;?>" align="left"><?php echo $val['numero']?></td>
                	<td valign="middle" style="<?php echo $css;?>" align="left"><?php echo $val['dui_empleado']?></td>
                	<td valign="middle" style="<?php echo $css;?>" align="left"><?php echo ucwords($val['nombre_empleado'])?></td>
                	<td valign="middle" style="<?php echo $css;?>" align="center"><?php echo ucwords($val['genero'])?></td>
                	<td valign="middle" style="<?php echo $css;?>" align="left"><?php echo $val['tipo_representacion']?></td>
                	<td valign="middle" style="<?php echo $css;?>" align="left"><?php echo $val['nombre_lugar']?></td>
                	<td valign="middle" style="<?php echo $css;?>" align="center"><?php echo $val['fecha_capacitacion']?></td>
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